namespace LicenseServer;

using System.Linq;

public sealed class LicenseStore
{
    private readonly object _syncRoot = new();
    private Dictionary<string, LicenseRecord> _licenses = new(StringComparer.OrdinalIgnoreCase);
    private List<string> _defaultCustomFields = new();

    public LicenseStore(LicenseConfig config)
    {
        Update(config);
    }

    public void Update(LicenseConfig config)
    {
        if (config.Prefixes == null || config.Prefixes.Count == 0)
        {
            throw new ArgumentException("At least one prefix must be configured.", nameof(config));
        }

        lock (_syncRoot)
        {
            _defaultCustomFields = NormalizeFields(config.DefaultCustomFields);
            _licenses = BuildDictionary(config);
        }
    }

    public bool TryGetLicense(string? key, out LicenseRecord license)
    {
        if (string.IsNullOrWhiteSpace(key))
        {
            license = null!;
            return false;
        }

        lock (_syncRoot)
        {
            if (_licenses.TryGetValue(key, out var record))
            {
                license = record;
                return true;
            }
        }

        license = null!;
        return false;
    }

    public IReadOnlyList<string> GetCustomFields(LicenseRecord license)
    {
        if (license.CustomFields is not { Count: > 0 })
        {
            return _defaultCustomFields;
        }

        var merged = _defaultCustomFields.ToList();
        for (var index = 0; index < license.CustomFields.Count; index++)
        {
            var value = license.CustomFields[index];
            if (string.IsNullOrEmpty(value))
            {
                continue;
            }

            if (index < merged.Count)
            {
                merged[index] = value;
            }
            else
            {
                while (merged.Count <= index)
                {
                    merged.Add(string.Empty);
                }

                merged[index] = value;
            }
        }

        return merged;
    }

    private static Dictionary<string, LicenseRecord> BuildDictionary(LicenseConfig config)
    {
        var dictionary = new Dictionary<string, LicenseRecord>(StringComparer.OrdinalIgnoreCase);
        foreach (var record in config.EnumerateRecords())
        {
            if (record is null || string.IsNullOrWhiteSpace(record.Key))
            {
                continue;
            }

            dictionary[record.Key] = record;
        }

        return dictionary;
    }

    private static List<string> NormalizeFields(List<string> fields)
    {
        var normalized = fields?.ToList() ?? new List<string>();
        while (normalized.Count <= 20)
        {
            normalized.Add(string.Empty);
        }

        return normalized;
    }
}
