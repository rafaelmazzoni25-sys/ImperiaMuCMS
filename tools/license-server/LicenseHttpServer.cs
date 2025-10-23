namespace LicenseServer;

using System;
using System.Collections.Generic;
using System.Diagnostics;
using System.Globalization;
using System.Net;
using System.Text;
using System.Text.Json.Serialization;
using System.Threading;
using System.Threading.Tasks;

public sealed class LicenseHttpServer
{
    private readonly object _listenerLock = new();
    private HttpListener? _listener;
    private readonly IReadOnlyList<string> _prefixes;
    private readonly LicenseStore _store;
    private readonly Logger? _logger;

    private const string ServerCategory = "Servidor";
    private const string RequestCategory = "Requisição";
    private const string LicenseCategory = "Licenças";

    public LicenseHttpServer(IEnumerable<string> prefixes, LicenseStore store, Logger? logger = null)
    {
        var prefixList = new List<string>();

        foreach (var prefix in prefixes ?? Array.Empty<string>())
        {
            var trimmed = prefix?.Trim();
            if (string.IsNullOrWhiteSpace(trimmed))
            {
                continue;
            }

            prefixList.Add(trimmed);
        }

        if (prefixList.Count == 0)
        {
            throw new ArgumentException("No valid prefixes configured.", nameof(prefixes));
        }

        _prefixes = prefixList.AsReadOnly();
        _store = store;
        _logger = logger;
    }

    public async Task RunAsync(CancellationToken cancellationToken)
    {
        HttpListener? listener = null;

        lock (_listenerLock)
        {
            if (_listener is not null)
            {
                throw new InvalidOperationException("O servidor HTTP já está em execução.");
            }

            listener = new HttpListener();
            foreach (var prefix in _prefixes)
            {
                listener.Prefixes.Add(prefix);
            }

            _listener = listener;
        }

        try
        {
            StartListener(listener);

            LogInformation("Servidor HTTP iniciado.", ServerCategory, BuildListenerMetadata());

            foreach (var prefix in _prefixes)
            {
                LogDebug($"Escutando prefixo: {prefix}", ServerCategory);
            }

            while (!cancellationToken.IsCancellationRequested && IsListening(listener))
            {
                HttpListenerContext? context = null;
                try
                {
                    context = await listener.GetContextAsync().ConfigureAwait(false);
                }
                catch (HttpListenerException) when (!IsListening(listener) || cancellationToken.IsCancellationRequested)
                {
                    break;
                }
                catch (ObjectDisposedException)
                {
                    break;
                }

                if (context is null)
                {
                    continue;
                }

                _ = Task.Run(() => HandleAsync(context), cancellationToken);
            }
        }
        finally
        {
            StopListener(listener);

            lock (_listenerLock)
            {
                if (_listener == listener)
                {
                    _listener = null;
                }
            }

            LogInformation("Servidor HTTP parado.", ServerCategory);
        }
    }

    private void StartListener(HttpListener listener)
    {
        try
        {
            listener.Start();
        }
        catch (ObjectDisposedException ex)
        {
            LogError("Falha ao iniciar o servidor HTTP: ouvinte descartado.", ex, ServerCategory, BuildListenerMetadata());
            throw new InvalidOperationException("Falha ao iniciar o servidor HTTP: o ouvinte foi descartado.", ex);
        }
        catch (HttpListenerException ex) when (ex.ErrorCode == 5)
        {
            LogError("Acesso negado ao iniciar o servidor HTTP.", ex, ServerCategory, BuildListenerMetadata());
            throw new InvalidOperationException(BuildAccessDeniedMessage(), ex);
        }
        catch (HttpListenerException ex)
        {
            LogError($"Falha ao iniciar o servidor HTTP: {ex.Message}", ex, ServerCategory, BuildListenerMetadata());
            throw new InvalidOperationException($"Falha ao iniciar o servidor HTTP: {ex.Message}", ex);
        }
    }

    private static bool IsListening(HttpListener listener)
    {
        try
        {
            return listener.IsListening;
        }
        catch (ObjectDisposedException)
        {
            return false;
        }
    }

    private static void StopListener(HttpListener? listener)
    {
        if (listener is null)
        {
            return;
        }

        try
        {
            if (IsListening(listener))
            {
                listener.Stop();
            }
        }
        catch (ObjectDisposedException)
        {
            // already disposed
        }
        catch (HttpListenerException)
        {
            // listener is already stopped
        }
        finally
        {
            try
            {
                listener.Close();
            }
            catch (ObjectDisposedException)
            {
                // already closed
            }
        }
    }

    private string BuildAccessDeniedMessage()
    {
        var builder = new StringBuilder();
        builder.AppendLine("Acesso negado ao iniciar o servidor HTTP.");
        builder.AppendLine(_prefixes.Count == 1
            ? "Execute o License Server como administrador ou registre a URL HTTP utilizando:"
            : "Execute o License Server como administrador ou registre as URLs HTTP utilizando:");

        foreach (var prefix in _prefixes)
        {
            builder.AppendLine($"  netsh http add urlacl url=\"{prefix}\" user=Todos");
        }

        builder.Append("Substitua \"Todos\" por \"Everyone\" em sistemas em inglês.");
        return builder.ToString();
    }

    public void Stop()
    {
        HttpListener? listener;
        lock (_listenerLock)
        {
            listener = _listener;
        }

        if (listener is null)
        {
            return;
        }

        try
        {
            listener.Stop();
        }
        catch (ObjectDisposedException)
        {
            // already disposed
        }
        catch (HttpListenerException)
        {
            // already stopped
        }
    }

    private async Task HandleAsync(HttpListenerContext context)
    {
        var request = context.Request;
        var requestId = Guid.NewGuid().ToString("N", CultureInfo.InvariantCulture)[..8];
        var requestMetadata = BuildRequestMetadata(request, requestId);
        var stopwatch = Stopwatch.StartNew();
        var statusCode = (int)HttpStatusCode.OK;

        LogDebug($"Requisição recebida: {request.HttpMethod} {request.RawUrl}", RequestCategory, requestMetadata);

        try
        {
            var requestPath = request.Url?.AbsolutePath ?? string.Empty;
            if (requestPath.Equals("/apiversion.php", StringComparison.OrdinalIgnoreCase))
            {
                await WritePlainAsync(context.Response, "1\n").ConfigureAwait(false);
                statusCode = context.Response.StatusCode;
                LogInformation("Endpoint /apiversion.php respondido.", RequestCategory, requestMetadata);
                return;
            }

            if (requestPath.StartsWith("/applications/nexus/interface/licenses/", StringComparison.OrdinalIgnoreCase))
            {
                await HandleLicenseEndpointAsync(context, requestMetadata).ConfigureAwait(false);
                statusCode = context.Response.StatusCode;
                return;
            }

            statusCode = (int)HttpStatusCode.NotFound;
            context.Response.StatusCode = statusCode;
            LogWarning(
                "Endpoint não encontrado.",
                RequestCategory,
                MergeMetadata(requestMetadata, ("http.status_code", statusCode.ToString(CultureInfo.InvariantCulture))));
        }
        catch (Exception ex)
        {
            statusCode = (int)HttpStatusCode.InternalServerError;
            context.Response.StatusCode = statusCode;
            LogError(
                "Falha ao processar requisição.",
                ex,
                RequestCategory,
                MergeMetadata(requestMetadata, ("http.status_code", statusCode.ToString(CultureInfo.InvariantCulture))));
        }
        finally
        {
            stopwatch.Stop();

            try
            {
                context.Response.Close();
            }
            catch (Exception ex)
            {
                LogWarning(
                    "Erro ao finalizar resposta HTTP.",
                    RequestCategory,
                    MergeMetadata(requestMetadata, ("erro", ex.Message)));
            }

            var completionMetadata = MergeMetadata(
                requestMetadata,
                ("http.status_code", statusCode.ToString(CultureInfo.InvariantCulture)),
                ("tempo_ms", stopwatch.Elapsed.TotalMilliseconds.ToString("F3", CultureInfo.InvariantCulture)));

            LogInformation("Requisição finalizada.", RequestCategory, completionMetadata);
        }
    }

    private async Task HandleLicenseEndpointAsync(HttpListenerContext context, IReadOnlyDictionary<string, string?> requestMetadata)
    {
        var query = context.Request.QueryString;
        var hasInfo = query.GetKey(0)?.Equals("info", StringComparison.OrdinalIgnoreCase) == true || query["info"] != null;
        var hasCheck = query.GetKey(0)?.Equals("check", StringComparison.OrdinalIgnoreCase) == true || query["check"] != null;
        var hasActivate = query.GetKey(0)?.Equals("activate", StringComparison.OrdinalIgnoreCase) == true || query["activate"] != null;

        if (hasInfo)
        {
            await RespondWithLicenseInfoAsync(context, requestMetadata).ConfigureAwait(false);
            return;
        }

        if (hasCheck)
        {
            await RespondWithLicenseCheckAsync(context, requestMetadata).ConfigureAwait(false);
            return;
        }

        if (hasActivate)
        {
            await RespondWithActivationAsync(context, requestMetadata).ConfigureAwait(false);
            return;
        }

        context.Response.StatusCode = (int)HttpStatusCode.BadRequest;
        LogWarning(
            "Operação de licença desconhecida.",
            LicenseCategory,
            MergeMetadata(requestMetadata, ("erro", "missing_operation")));
    }

    private async Task RespondWithLicenseInfoAsync(HttpListenerContext context, IReadOnlyDictionary<string, string?> requestMetadata)
    {
        var key = context.Request.QueryString["key"];
        var identifier = context.Request.QueryString["identifier"];

        var baseMetadata = MergeMetadata(
            requestMetadata,
            ("licenca.chave", MaskLicenseKey(key)),
            ("licenca.identificador", identifier));

        if (!_store.TryGetLicense(key, out var license) || !license.MatchesIdentifier(identifier))
        {
            LogWarning("Licença inválida ao solicitar informações.", LicenseCategory, baseMetadata);
            await WriteEncryptedAsync(context.Response, new { error = "invalid_license" }).ConfigureAwait(false);
            return;
        }

        var payload = new LicensePayload
        {
            Key = license.Key,
            Email = string.IsNullOrWhiteSpace(license.Identifier) ? identifier ?? string.Empty : license.Identifier,
            UsageId = license.UsageId,
            PurchaseName = license.PurchaseName,
            Status = license.Status,
            Expires = license.Expires,
            CustomFields = _store.GetCustomFields(license)
        };

        var successMetadata = MergeMetadata(
            baseMetadata,
            ("licenca.status", license.Status),
            ("licenca.expira", license.Expires.ToString(CultureInfo.InvariantCulture)),
            ("licenca.uso", license.UsageId),
            ("licenca.comprador", license.PurchaseName));

        LogInformation("Informações de licença enviadas.", LicenseCategory, successMetadata);

        await WriteEncryptedAsync(context.Response, payload).ConfigureAwait(false);
    }

    private async Task RespondWithLicenseCheckAsync(HttpListenerContext context, IReadOnlyDictionary<string, string?> requestMetadata)
    {
        var key = context.Request.QueryString["key"];
        var identifier = context.Request.QueryString["identifier"];

        var baseMetadata = MergeMetadata(
            requestMetadata,
            ("licenca.chave", MaskLicenseKey(key)),
            ("licenca.identificador", identifier));

        if (!_store.TryGetLicense(key, out var license) || !license.MatchesIdentifier(identifier))
        {
            LogWarning(
                "Verificação de licença rejeitada.",
                LicenseCategory,
                MergeMetadata(baseMetadata, ("licenca.status", "INACTIVE")));
            await WriteEncryptedAsync(context.Response, new { status = "INACTIVE" }).ConfigureAwait(false);
            return;
        }

        var payload = new LicenseCheckPayload
        {
            Status = license.Status,
            UsageId = license.UsageId,
            PurchaseName = license.PurchaseName,
            Expires = license.Expires,
            CustomFields = _store.GetCustomFields(license)
        };

        var successMetadata = MergeMetadata(
            baseMetadata,
            ("licenca.status", license.Status),
            ("licenca.expira", license.Expires.ToString(CultureInfo.InvariantCulture)),
            ("licenca.uso", license.UsageId),
            ("licenca.comprador", license.PurchaseName));

        LogInformation("Verificação de licença aprovada.", LicenseCategory, successMetadata);

        await WriteEncryptedAsync(context.Response, payload).ConfigureAwait(false);
    }

    private async Task RespondWithActivationAsync(HttpListenerContext context, IReadOnlyDictionary<string, string?> requestMetadata)
    {
        var key = context.Request.QueryString["key"];
        var identifier = context.Request.QueryString["identifier"];

        var baseMetadata = MergeMetadata(
            requestMetadata,
            ("licenca.chave", MaskLicenseKey(key)),
            ("licenca.identificador", identifier));

        if (!_store.TryGetLicense(key, out var license) || !license.MatchesIdentifier(identifier))
        {
            LogWarning("Tentativa de ativação com licença inválida.", LicenseCategory, baseMetadata);
            await WriteEncryptedAsync(context.Response, new { response = "ERROR", message = "invalid_license" }).ConfigureAwait(false);
            return;
        }

        var payload = new ActivationPayload
        {
            Response = "OKAY",
            UsageId = license.UsageId
        };

        var successMetadata = MergeMetadata(
            baseMetadata,
            ("licenca.uso", license.UsageId),
            ("licenca.status", license.Status));

        LogInformation("Licença ativada com sucesso.", LicenseCategory, successMetadata);

        await WriteEncryptedAsync(context.Response, payload).ConfigureAwait(false);
    }

    private static async Task WritePlainAsync(HttpListenerResponse response, string body)
    {
        var buffer = Encoding.UTF8.GetBytes(body);
        response.ContentType = "text/plain; charset=utf-8";
        response.ContentLength64 = buffer.Length;
        await response.OutputStream.WriteAsync(buffer.AsMemory(0, buffer.Length)).ConfigureAwait(false);
    }

    private static async Task WriteEncryptedAsync(HttpListenerResponse response, object payload)
    {
        var encrypted = CmsEncryption.EncryptJson(payload);
        await WritePlainAsync(response, encrypted).ConfigureAwait(false);
    }

    private IReadOnlyDictionary<string, string?> BuildListenerMetadata()
    {
        var metadata = new Dictionary<string, string?>
        {
            ["prefixos"] = _prefixes.Count.ToString(CultureInfo.InvariantCulture)
        };

        for (var index = 0; index < _prefixes.Count; index++)
        {
            metadata[$"prefixo[{index}]"] = _prefixes[index];
        }

        return metadata;
    }

    private static IReadOnlyDictionary<string, string?> BuildRequestMetadata(HttpListenerRequest request, string requestId)
    {
        var metadata = new Dictionary<string, string?>(StringComparer.OrdinalIgnoreCase)
        {
            ["requisicao.id"] = requestId,
            ["http.metodo"] = request.HttpMethod,
            ["http.url"] = request.RawUrl ?? string.Empty
        };

        if (request.RemoteEndPoint is not null)
        {
            metadata["http.origem"] = request.RemoteEndPoint.ToString();
        }

        if (!string.IsNullOrWhiteSpace(request.UserAgent))
        {
            metadata["http.user_agent"] = request.UserAgent;
        }

        if (request.Url is { } url)
        {
            metadata["http.host"] = url.Host;
            metadata["http.caminho"] = url.AbsolutePath;
            if (!string.IsNullOrEmpty(url.Query))
            {
                metadata["http.query"] = url.Query;
            }
        }

        return metadata;
    }

    private static IReadOnlyDictionary<string, string?> MergeMetadata(IReadOnlyDictionary<string, string?> baseMetadata, params (string Key, string? Value)[] entries)
    {
        var merged = new Dictionary<string, string?>(baseMetadata, StringComparer.OrdinalIgnoreCase);
        foreach (var (key, value) in entries)
        {
            merged[key] = value;
        }

        return merged;
    }

    private static string MaskLicenseKey(string? key)
    {
        if (string.IsNullOrWhiteSpace(key))
        {
            return string.Empty;
        }

        if (key.Length <= 4)
        {
            return new string('*', key.Length);
        }

        return new string('*', key.Length - 4) + key[^4..];
    }

    private void LogDebug(string message, string category, IReadOnlyDictionary<string, string?>? metadata = null)
        => _logger?.LogDebug(message, category, metadata);

    private void LogInformation(string message, string category, IReadOnlyDictionary<string, string?>? metadata = null)
        => _logger?.LogInformation(message, category, metadata);

    private void LogWarning(string message, string category, IReadOnlyDictionary<string, string?>? metadata = null)
        => _logger?.LogWarning(message, category, metadata);

    private void LogError(string message, Exception exception, string category, IReadOnlyDictionary<string, string?>? metadata = null)
        => _logger?.LogError(message, category, exception, metadata);
}

internal sealed class LicensePayload
{
    [JsonPropertyName("key")]
    public string Key { get; set; } = string.Empty;

    [JsonPropertyName("email")]
    public string Email { get; set; } = string.Empty;

    [JsonPropertyName("usage_id")]
    public string UsageId { get; set; } = string.Empty;

    [JsonPropertyName("purchase_name")]
    public string PurchaseName { get; set; } = string.Empty;

    [JsonPropertyName("status")]
    public string Status { get; set; } = "ACTIVE";

    [JsonPropertyName("expires")]
    public long Expires { get; set; }
        = DateTimeOffset.UtcNow.AddYears(1).ToUnixTimeSeconds();

    [JsonPropertyName("custom_fields")]
    public IReadOnlyList<string> CustomFields { get; set; } = Array.Empty<string>();
}

internal sealed class LicenseCheckPayload
{
    [JsonPropertyName("status")]
    public string Status { get; set; } = "ACTIVE";

    [JsonPropertyName("usage_id")]
    public string UsageId { get; set; } = string.Empty;

    [JsonPropertyName("purchase_name")]
    public string PurchaseName { get; set; } = string.Empty;

    [JsonPropertyName("expires")]
    public long Expires { get; set; }
        = DateTimeOffset.UtcNow.AddYears(1).ToUnixTimeSeconds();

    [JsonPropertyName("custom_fields")]
    public IReadOnlyList<string> CustomFields { get; set; } = Array.Empty<string>();
}

internal sealed class ActivationPayload
{
    [JsonPropertyName("response")]
    public string Response { get; set; } = "OKAY";

    [JsonPropertyName("usage_id")]
    public string UsageId { get; set; } = string.Empty;
}
