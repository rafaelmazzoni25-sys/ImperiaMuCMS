namespace LicenseServer;

using System;
using System.Collections.Generic;
using System.Globalization;
using System.IO;
using System.Text.Json;
using System.Windows.Forms;
using System.Threading;

internal static class Program
{
    [STAThread]
    private static void Main(string[] args)
    {
        ApplicationConfiguration.Initialize();

        var configPath = args.Length > 0
            ? Path.GetFullPath(args[0])
            : Path.Combine(AppContext.BaseDirectory, "license-config.json");

        using var logger = CreateLogger();

        logger.LogInformation(
            "Aplicação iniciada.",
            "Aplicação",
            new Dictionary<string, string?> { ["config.path"] = configPath });

        var config = LoadConfiguration(configPath, logger);
        var store = new LicenseStore(config);

        ThreadExceptionEventHandler uiHandler = (_, eventArgs)
            => logger.LogCritical(
                "Exceção não tratada na interface gráfica.",
                "Aplicação",
                eventArgs.Exception);

        UnhandledExceptionEventHandler domainHandler = (_, eventArgs) =>
        {
            if (eventArgs.ExceptionObject is Exception ex)
            {
                logger.LogCritical(
                    "Exceção não tratada no domínio do aplicativo.",
                    "Aplicação",
                    ex,
                    new Dictionary<string, string?>
                    {
                        ["terminating"] = eventArgs.IsTerminating ? "true" : "false"
                    });
            }
        };

        Application.ThreadException += uiHandler;
        AppDomain.CurrentDomain.UnhandledException += domainHandler;

        try
        {
            using var mainForm = new MainForm(configPath, config, store, logger);
            Application.Run(mainForm);
        }
        finally
        {
            Application.ThreadException -= uiHandler;
            AppDomain.CurrentDomain.UnhandledException -= domainHandler;
            logger.LogInformation("Aplicação finalizada.", "Aplicação");
        }
    }

    private static Logger CreateLogger()
    {
        var logger = new Logger();
        var logsDirectory = Path.Combine(AppContext.BaseDirectory, "__logs", "license-server");
        var logFile = Path.Combine(logsDirectory, $"license-server-{DateTime.Now:yyyyMMdd}.log");
        logger.RegisterSink(new FileLogSink(logFile));
        return logger;
    }

    private static LicenseConfig LoadConfiguration(string path, Logger logger)
    {
        if (!File.Exists(path))
        {
            logger.LogWarning(
                "Arquivo de configuração não encontrado. Utilizando valores padrão.",
                "Configuração",
                new Dictionary<string, string?> { ["arquivo"] = path });
            return LicenseConfig.CreateDefault();
        }

        try
        {
            using var stream = File.OpenRead(path);
            var config = JsonSerializer.Deserialize<LicenseConfig>(stream, LicenseConfig.JsonOptions);
            if (config is null)
            {
                logger.LogWarning(
                    "Configuração vazia. Utilizando valores padrão.",
                    "Configuração",
                    new Dictionary<string, string?> { ["arquivo"] = path });
                return LicenseConfig.CreateDefault();
            }

            logger.LogInformation(
                "Configuração carregada com sucesso.",
                "Configuração",
                BuildConfigurationMetadata(path, config));

            return config;
        }
        catch (Exception ex)
        {
            logger.LogError(
                "Falha ao carregar configuração. Utilizando valores padrão.",
                "Configuração",
                ex,
                new Dictionary<string, string?> { ["arquivo"] = path });
            return LicenseConfig.CreateDefault();
        }
    }

    private static IReadOnlyDictionary<string, string?> BuildConfigurationMetadata(string path, LicenseConfig config)
    {
        var metadata = new Dictionary<string, string?>
        {
            ["arquivo"] = path,
            ["prefixos"] = (config.Prefixes?.Count ?? 0).ToString(CultureInfo.InvariantCulture),
            ["usuarios"] = (config.Users?.Count ?? 0).ToString(CultureInfo.InvariantCulture)
        };

        if (config.Prefixes is { Count: > 0 })
        {
            for (var index = 0; index < config.Prefixes.Count; index++)
            {
                metadata[$"prefixo[{index}]"] = config.Prefixes[index];
            }
        }

        return metadata;
    }
}
