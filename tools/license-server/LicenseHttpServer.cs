namespace LicenseServer;

using System.Net;
using System.Text;
using System.Text.Json.Serialization;

public sealed class LicenseHttpServer
{
    private readonly HttpListener _listener = new();
    private readonly LicenseStore _store;
    private readonly Action<string>? _logger;

    public LicenseHttpServer(IEnumerable<string> prefixes, LicenseStore store, Action<string>? logger = null)
    {
        foreach (var prefix in prefixes)
        {
            if (string.IsNullOrWhiteSpace(prefix))
            {
                continue;
            }

            _listener.Prefixes.Add(prefix);
        }

        if (_listener.Prefixes.Count == 0)
        {
            throw new ArgumentException("No valid prefixes configured.", nameof(prefixes));
        }

        _store = store;
        _logger = logger;
    }

    public async Task RunAsync(CancellationToken cancellationToken)
    {
        _listener.Start();
        Log("License server listening on:");
        foreach (var prefix in _listener.Prefixes)
        {
            Log($"  {prefix}");
        }

        try
        {
            while (_listener.IsListening && !cancellationToken.IsCancellationRequested)
            {
                HttpListenerContext? context = null;
                try
                {
                    context = await _listener.GetContextAsync().ConfigureAwait(false);
                }
                catch (HttpListenerException) when (!_listener.IsListening)
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
            if (_listener.IsListening)
            {
                _listener.Stop();
            }

            Log("License server stopped.");
        }
    }

    public void Stop()
    {
        if (_listener.IsListening)
        {
            _listener.Stop();
        }
    }

    private async Task HandleAsync(HttpListenerContext context)
    {
        try
        {
            var requestPath = context.Request.Url?.AbsolutePath ?? string.Empty;
            if (requestPath.Equals("/apiversion.php", StringComparison.OrdinalIgnoreCase))
            {
                await WritePlainAsync(context.Response, "1\n").ConfigureAwait(false);
                return;
            }

            if (requestPath.StartsWith("/applications/nexus/interface/licenses/", StringComparison.OrdinalIgnoreCase))
            {
                await HandleLicenseEndpointAsync(context).ConfigureAwait(false);
                return;
            }

            context.Response.StatusCode = (int)HttpStatusCode.NotFound;
        }
        catch (Exception ex)
        {
            Log($"[{DateTime.UtcNow:O}] Request failed: {ex}");
            context.Response.StatusCode = (int)HttpStatusCode.InternalServerError;
        }
        finally
        {
            context.Response.Close();
        }
    }

    private async Task HandleLicenseEndpointAsync(HttpListenerContext context)
    {
        var query = context.Request.QueryString;
        var hasInfo = query.GetKey(0)?.Equals("info", StringComparison.OrdinalIgnoreCase) == true || query["info"] != null;
        var hasCheck = query.GetKey(0)?.Equals("check", StringComparison.OrdinalIgnoreCase) == true || query["check"] != null;
        var hasActivate = query.GetKey(0)?.Equals("activate", StringComparison.OrdinalIgnoreCase) == true || query["activate"] != null;

        if (hasInfo)
        {
            await RespondWithLicenseInfoAsync(context).ConfigureAwait(false);
            return;
        }

        if (hasCheck)
        {
            await RespondWithLicenseCheckAsync(context).ConfigureAwait(false);
            return;
        }

        if (hasActivate)
        {
            await RespondWithActivationAsync(context).ConfigureAwait(false);
            return;
        }

        context.Response.StatusCode = (int)HttpStatusCode.BadRequest;
    }

    private async Task RespondWithLicenseInfoAsync(HttpListenerContext context)
    {
        var key = context.Request.QueryString["key"];
        var identifier = context.Request.QueryString["identifier"];

        if (!_store.TryGetLicense(key, out var license) || !license.MatchesIdentifier(identifier))
        {
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

        await WriteEncryptedAsync(context.Response, payload).ConfigureAwait(false);
    }

    private async Task RespondWithLicenseCheckAsync(HttpListenerContext context)
    {
        var key = context.Request.QueryString["key"];
        var identifier = context.Request.QueryString["identifier"];

        if (!_store.TryGetLicense(key, out var license) || !license.MatchesIdentifier(identifier))
        {
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

        await WriteEncryptedAsync(context.Response, payload).ConfigureAwait(false);
    }

    private async Task RespondWithActivationAsync(HttpListenerContext context)
    {
        var key = context.Request.QueryString["key"];
        var identifier = context.Request.QueryString["identifier"];

        if (!_store.TryGetLicense(key, out var license) || !license.MatchesIdentifier(identifier))
        {
            await WriteEncryptedAsync(context.Response, new { response = "ERROR", message = "invalid_license" }).ConfigureAwait(false);
            return;
        }

        var payload = new ActivationPayload
        {
            Response = "OKAY",
            UsageId = license.UsageId
        };

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

    private void Log(string message)
    {
        _logger?.Invoke(message);
    }
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
