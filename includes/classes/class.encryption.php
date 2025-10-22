<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class Encryption
{
    private $skey = "Cgp1OUzel4W3p5b872BjunWRpbozdHKrhiRp19Dvf8uJT2xkpPEi8X37rF4PQ69AMVEkhXOs0rW8tWHgtcXu0mugYP5Xi9Bpy1hhfY4yZg6rbt15hhW5Xx7Fe8nS6HGJI4x2jiN5OGR0Hqxq1QkQWVVFtfR6SkhMZKEprntzivJOB8sBHFemQnrEKwgRT0vOHexzW8wLZ3baPI38hRfnCbmYnIfRKEVkkbuduNfxzIjgWJKdjgwaCGaEIwyRzLZ";
    private $secretIV = "r0OPQe9YtboBkg4rswgSy0MBH9mec3oocMM7ThCgBCWPnLhw8BZdRp6jvv8SJNzF";
    public function __construct()
    {
        global $config;
        $this->skey = isset($config["encryption_hash"]) ? $config["encryption_hash"] : "PT2TIyURRgSwO98T";
    }
    public function encode($value)
    {
        if (!$value && $value != 0) {
            return false;
        }
        $encrypt_method = "AES-256-CBC";
        $secret_key = $this->skey;
        $secret_iv = $this->secretIV;
        $key = hash("sha256", $secret_key);
        $iv = substr(hash("sha256", $secret_iv), 0, 16);
        $output = openssl_encrypt($value, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
        return $output;
    }
    public function safe_b64encode($string)
    {
        $data = base64_encode($string);
        $data = str_replace(["+", "/", "="], ["-", "_", ""], $data);
        return $data;
    }
    public function decode($value)
    {
        if (!$value) {
            return false;
        }
        $encrypt_method = "AES-256-CBC";
        $secret_key = $this->skey;
        $secret_iv = $this->secretIV;
        $key = hash("sha256", $secret_key);
        $iv = substr(hash("sha256", $secret_iv), 0, 16);
        $output = openssl_decrypt(base64_decode($value), $encrypt_method, $key, 0, $iv);
        return $output;
    }
    public function safe_b64decode($string)
    {
        $data = str_replace(["-", "_"], ["+", "/"], $string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr("====", $mod4);
        }
        return base64_decode($data);
    }
}

?>