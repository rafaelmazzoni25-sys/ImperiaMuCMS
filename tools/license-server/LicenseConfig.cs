namespace LicenseServer;

using System.Linq;
using System.Text.Json;
using System.Text.Json.Serialization;

public sealed class LicenseConfig
{
    public static readonly JsonSerializerOptions JsonOptions = new()
    {
        PropertyNameCaseInsensitive = true,
        ReadCommentHandling = JsonCommentHandling.Skip,
        AllowTrailingCommas = true,
        WriteIndented = true
    };

    [JsonPropertyName("prefixes")]
    public List<string> Prefixes { get; set; } = new() { "http://*:5000/" };

    [JsonPropertyName("defaultCustomFields")]
    public List<string> DefaultCustomFields { get; set; } = new()
    {
        "Local ImperiaMuCMS Server",
        "http://localhost",
        "http://localhost",
        "127.0.0.1",
        "yes",
        "Season 18",
        "Season 18",
        "yes",
        string.Empty,
        string.Empty,
        string.Empty,
        string.Empty,
        string.Empty,
        string.Empty,
        string.Empty,
        string.Empty,
        string.Empty,
        string.Empty,
        string.Empty,
        string.Empty,
        "Season 18"
    };

    [JsonPropertyName("modules")]
    public List<LicenseModuleDefinition> Modules { get; set; } = new();

    [JsonPropertyName("users")]
    public List<LicenseUser> Users { get; set; } = new();

    public IEnumerable<LicenseRecord> EnumerateRecords()
    {
        foreach (var user in Users)
        {
            if (user.CoreLicense is null)
            {
                continue;
            }

            var coreRecord = user.CoreLicense.ToLicenseRecord(
                user.Identifier,
                string.IsNullOrWhiteSpace(user.CoreLicense.PurchaseName)
                    ? $"{user.DisplayName} - ImperiaMuCMS"
                    : user.CoreLicense.PurchaseName);

            yield return coreRecord;

            foreach (var assignment in user.Modules)
            {
                var moduleName = ResolveModuleName(assignment.ModuleId);
                var purchaseName = string.IsNullOrWhiteSpace(assignment.PurchaseName)
                    ? moduleName
                    : assignment.PurchaseName;

                yield return assignment.ToLicenseRecord(user.Identifier, purchaseName);
            }
        }
    }

    public LicenseModuleDefinition? GetModule(string moduleId)
        => Modules.FirstOrDefault(m =>
            string.Equals(m.Id, moduleId, StringComparison.OrdinalIgnoreCase));

    public string ResolveModuleName(string moduleId)
    {
        var module = GetModule(moduleId);
        if (module is null)
        {
            return moduleId;
        }

        if (!string.IsNullOrWhiteSpace(module.PurchaseName))
        {
            return module.PurchaseName;
        }

        return string.IsNullOrWhiteSpace(module.DisplayName) ? module.Id : module.DisplayName;
    }

    public static LicenseConfig CreateDefault()
    {
        var config = new LicenseConfig();

        config.Modules.AddRange(LicenseModuleDefinition.CreateDefaultModules());

        config.Users.Add(new LicenseUser
        {
            Name = "Administrador",
            Identifier = "owner@example.com",
            CoreLicense = new LicenseEntry
            {
                Key = "IMPERIA-CORE-LICENSE",
                PurchaseName = "ImperiaMuCMS Premium Package",
                UsageId = "CORE-USAGE-0001",
                Status = "ACTIVE",
                Expires = DateTimeOffset.UtcNow.AddYears(5).ToUnixTimeSeconds(),
                CustomFields = new List<string>(config.DefaultCustomFields)
            }
        });

        return config;
    }
}

public sealed class LicenseModuleDefinition
{
    [JsonPropertyName("id")]
    public string Id { get; set; } = string.Empty;

    [JsonPropertyName("displayName")]
    public string DisplayName { get; set; } = string.Empty;

    [JsonPropertyName("defaultKey")]
    public string DefaultKey { get; set; } = string.Empty;

    [JsonPropertyName("defaultUsageId")]
    public string? DefaultUsageId { get; set; }
        = null;

    [JsonPropertyName("purchaseName")]
    public string? PurchaseName { get; set; }
        = null;

    public static IEnumerable<LicenseModuleDefinition> CreateDefaultModules()
    {
        yield return new LicenseModuleDefinition { Id = "bugtracker", DisplayName = "Bug Tracker", PurchaseName = "Bug Tracker", DefaultKey = "MODULE-BUGTRACKER", DefaultUsageId = "BUGTRACKER-USAGE" };
        yield return new LicenseModuleDefinition { Id = "rename", DisplayName = "Rename Character", PurchaseName = "Change Name", DefaultKey = "MODULE-CHANGE-NAME", DefaultUsageId = "CHANGE-NAME-USAGE" };
        yield return new LicenseModuleDefinition { Id = "market", DisplayName = "Market", PurchaseName = "Market", DefaultKey = "MODULE-MARKET", DefaultUsageId = "MARKET-USAGE" };
        yield return new LicenseModuleDefinition { Id = "webbank", DisplayName = "Web Bank", PurchaseName = "Web Bank", DefaultKey = "MODULE-WEBBANK", DefaultUsageId = "WEBBANK-USAGE" };
        yield return new LicenseModuleDefinition { Id = "transfercoins", DisplayName = "Transfer Coins", PurchaseName = "Transfer Coins", DefaultKey = "MODULE-TRANSFER-COINS", DefaultUsageId = "TRANSFER-COINS-USAGE" };
        yield return new LicenseModuleDefinition { Id = "myvault", DisplayName = "My Vault", PurchaseName = "My Vault", DefaultKey = "MODULE-MY-VAULT", DefaultUsageId = "MY-VAULT-USAGE" };
        yield return new LicenseModuleDefinition { Id = "recruit", DisplayName = "Recruit a Friend", PurchaseName = "Recruit Friend", DefaultKey = "MODULE-RECRUIT", DefaultUsageId = "RECRUIT-FRIEND-USAGE" };
        yield return new LicenseModuleDefinition { Id = "claimreward", DisplayName = "Claim Reward", PurchaseName = "Claim Reward", DefaultKey = "MODULE-CLAIM-REWARD", DefaultUsageId = "CLAIM-REWARD-USAGE" };
        yield return new LicenseModuleDefinition { Id = "inventory", DisplayName = "Items Inventory", PurchaseName = "Items Inventory", DefaultKey = "MODULE-ITEMS", DefaultUsageId = "ITEMS-INVENTORY-USAGE" };
        yield return new LicenseModuleDefinition { Id = "activity", DisplayName = "Activity Reward", PurchaseName = "Activity Rewards", DefaultKey = "MODULE-ACTIVITY-REWARDS", DefaultUsageId = "ACTIVITY-REWARDS-USAGE" };
        yield return new LicenseModuleDefinition { Id = "badges", DisplayName = "Badges", PurchaseName = "Badges", DefaultKey = "MODULE-BADGES", DefaultUsageId = "BADGES-USAGE" };
        yield return new LicenseModuleDefinition { Id = "lottery", DisplayName = "Lottery", PurchaseName = "Lottery", DefaultKey = "MODULE-LOTTERY", DefaultUsageId = "LOTTERY-USAGE" };
        yield return new LicenseModuleDefinition { Id = "architect", DisplayName = "Architect", PurchaseName = "Architect", DefaultKey = "MODULE-ARCHITECT", DefaultUsageId = "ARCHITECT-USAGE" };
        yield return new LicenseModuleDefinition { Id = "auction", DisplayName = "Auctions", PurchaseName = "Auction", DefaultKey = "MODULE-AUCTION", DefaultUsageId = "AUCTION-USAGE" };
        yield return new LicenseModuleDefinition { Id = "achievements", DisplayName = "Achievements", PurchaseName = "Achievements", DefaultKey = "MODULE-ACHIEVEMENTS", DefaultUsageId = "ACHIEVEMENTS-USAGE" };
        yield return new LicenseModuleDefinition { Id = "cashshop", DisplayName = "Cash Shop", PurchaseName = "Cash Shop", DefaultKey = "MODULE-CASHSHOP", DefaultUsageId = "CASHSHOP-USAGE" };
        yield return new LicenseModuleDefinition { Id = "dualskill", DisplayName = "Dual Skill Tree", PurchaseName = "Dual Skill Tree", DefaultKey = "MODULE-DUAL-SKILLTREE", DefaultUsageId = "DUAL-SKILLTREE-USAGE" };
        yield return new LicenseModuleDefinition { Id = "dualstats", DisplayName = "Dual Stats", PurchaseName = "Dual Stats", DefaultKey = "MODULE-DUAL-STATS", DefaultUsageId = "DUAL-STATS-USAGE" };
        yield return new LicenseModuleDefinition { Id = "startingkit", DisplayName = "Starting Kit", PurchaseName = "Starting Kit", DefaultKey = "MODULE-STARTING-KIT", DefaultUsageId = "STARTING-KIT-USAGE" };
        yield return new LicenseModuleDefinition { Id = "guildbank", DisplayName = "Guild Web Bank", PurchaseName = "Guild Web Bank", DefaultKey = "MODULE-GUILD-BANK", DefaultUsageId = "GUILD-BANK-USAGE" };
        yield return new LicenseModuleDefinition { Id = "wheel", DisplayName = "Wheel of Fortune", PurchaseName = "Wheel of Fortune", DefaultKey = "MODULE-WHEEL-OF-FORTUNE", DefaultUsageId = "WHEEL-OF-FORTUNE-USAGE" };
    }
}

public sealed class LicenseUser
{
    [JsonPropertyName("name")]
    public string Name { get; set; } = string.Empty;

    [JsonPropertyName("identifier")]
    public string Identifier { get; set; } = string.Empty;

    [JsonPropertyName("coreLicense")]
    public LicenseEntry CoreLicense { get; set; } = new();

    [JsonPropertyName("modules")]
    public List<LicenseModuleAssignment> Modules { get; set; } = new();

    [JsonIgnore]
    public string DisplayName => string.IsNullOrWhiteSpace(Name) ? Identifier : Name;
}

public class LicenseEntry
{
    [JsonPropertyName("key")]
    public string Key { get; set; } = string.Empty;

    [JsonPropertyName("purchaseName")]
    public string PurchaseName { get; set; } = string.Empty;

    [JsonPropertyName("status")]
    public string Status { get; set; } = "ACTIVE";

    [JsonPropertyName("usageId")]
    public string UsageId { get; set; } = $"USAGE-{Guid.NewGuid():N}";

    [JsonPropertyName("expires")]
    public long Expires { get; set; } = DateTimeOffset.UtcNow.AddYears(1).ToUnixTimeSeconds();

    [JsonPropertyName("customFields")]
    public List<string>? CustomFields { get; set; }
        = null;

    public LicenseRecord ToLicenseRecord(string identifier, string defaultPurchaseName)
    {
        var purchaseName = string.IsNullOrWhiteSpace(PurchaseName)
            ? defaultPurchaseName
            : PurchaseName;

        var usageId = string.IsNullOrWhiteSpace(UsageId)
            ? $"USAGE-{Guid.NewGuid():N}"
            : UsageId;

        var expires = Expires <= 0
            ? DateTimeOffset.UtcNow.AddYears(1).ToUnixTimeSeconds()
            : Expires;

        return new LicenseRecord
        {
            Key = Key,
            Identifier = identifier,
            PurchaseName = purchaseName,
            Status = string.IsNullOrWhiteSpace(Status) ? "ACTIVE" : Status,
            UsageId = usageId,
            Expires = expires,
            CustomFields = CustomFields?.ToList()
        };
    }
}

public sealed class LicenseModuleAssignment : LicenseEntry
{
    [JsonPropertyName("moduleId")]
    public string ModuleId { get; set; } = string.Empty;
}

public sealed class LicenseRecord
{
    [JsonPropertyName("key")]
    public string Key { get; set; } = string.Empty;

    [JsonPropertyName("identifier")]
    public string Identifier { get; set; } = string.Empty;

    [JsonPropertyName("purchaseName")]
    public string PurchaseName { get; set; } = string.Empty;

    [JsonPropertyName("status")]
    public string Status { get; set; } = "ACTIVE";

    [JsonPropertyName("usageId")]
    public string UsageId { get; set; } = string.Empty;

    [JsonPropertyName("expires")]
    public long Expires { get; set; }
        = DateTimeOffset.UtcNow.AddYears(1).ToUnixTimeSeconds();

    [JsonPropertyName("customFields")]
    public List<string>? CustomFields { get; set; }
        = null;

    public bool MatchesIdentifier(string? identifier)
    {
        if (string.IsNullOrWhiteSpace(Identifier))
        {
            return true;
        }

        return string.Equals(Identifier, identifier, StringComparison.OrdinalIgnoreCase);
    }
}
