namespace LicenseServer;

using System.Text.Json;
using System.Windows.Forms;

internal static class Program
{
    [STAThread]
    private static void Main(string[] args)
    {
        ApplicationConfiguration.Initialize();

        var configPath = args.Length > 0
            ? Path.GetFullPath(args[0])
            : Path.Combine(AppContext.BaseDirectory, "license-config.json");

        var config = LoadConfiguration(configPath);
        var store = new LicenseStore(config);

        using var mainForm = new MainForm(configPath, config, store);
        Application.Run(mainForm);
    }

    private static LicenseConfig LoadConfiguration(string path)
    {
        if (!File.Exists(path))
        {
            return LicenseConfig.CreateDefault();
        }

        try
        {
            using var stream = File.OpenRead(path);
            var config = JsonSerializer.Deserialize<LicenseConfig>(stream, LicenseConfig.JsonOptions);
            return config ?? LicenseConfig.CreateDefault();
        }
        catch
        {
            return LicenseConfig.CreateDefault();
        }
    }
}
