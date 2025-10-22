namespace LicenseServer;

using System.Security.Cryptography;
using System.Text;
using System.Text.Json;

public static class CmsEncryption
{
    private const string SecretKey = "XFmva8nIbtoV88dzQoioafgZlipk9dBNhU4nEeS3SHH94LkdES58ThOozVjG0wFdeLPE3ZUhIKMkCPWAn17XzJzQ1Ax3K0zzu2AP2BsxbwLi8HJI73IjkkVAUSphN87Wsxd7cKi8zqSxUIzbe2otwHvVeZH6UhL7yFepgnx0BumReJ2gfAQdAwY8VvS3LBfz5SysoUHlJUuIli7HeuePjtyC6lrfuo1lz6lxKqaCBGecoJNeGoYflkEBJNmkoIF9";
    private const string SecretIv = "xk3xudsF8XjuItROFaMuiDcPHdB0VhCpFx09glr02rO98zcTtT1lmKATtHEeiuKH";

    private static readonly byte[] Key = SHA256.HashData(Encoding.UTF8.GetBytes(SecretKey));
    private static readonly byte[] Iv = SHA256.HashData(Encoding.UTF8.GetBytes(SecretIv))[..16];

    public static string Encrypt(ReadOnlySpan<byte> payload)
    {
        using var aes = Aes.Create();
        aes.Key = Key;
        aes.IV = Iv;
        aes.Mode = CipherMode.CBC;
        aes.Padding = PaddingMode.PKCS7;

        using var encryptor = aes.CreateEncryptor();
        var cipherBytes = encryptor.TransformFinalBlock(payload.ToArray(), 0, payload.Length);
        return Convert.ToBase64String(cipherBytes);
    }

    public static string EncryptJson(object payload)
    {
        var json = JsonSerializer.Serialize(payload, LicenseConfig.JsonOptions);
        return Encrypt(Encoding.UTF8.GetBytes(json));
    }
}
