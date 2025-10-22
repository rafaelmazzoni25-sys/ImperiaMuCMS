<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class PagSeguroConfig
{
    private static $data = NULL;
    private static $config = NULL;
    const VARNAME = "PagSeguroConfig";
    private function __construct()
    {
        define("ALLOW_PAGSEGURO_CONFIG", true);
        require_once PagSeguroLibrary::getPath() . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "PagSeguroConfig.php";
        $varName = "PagSeguroConfig";
        if (isset($varName)) {
            self::$data = ${$varName};
            unset($varName);
        } else {
            throw new Exception("Config is undefined.");
        }
    }
    public static function init()
    {
        if (self::$config == NULL) {
            self::$config = new PagSeguroConfig();
        }
        return self::$config;
    }
    public static function getData($key1, $key2 = NULL)
    {
        if ($key2 != NULL) {
            if (isset(self::$data[$key1][$key2])) {
                return self::$data[$key1][$key2];
            }
            throw new Exception("Config keys " . $key1 . ", " . $key2 . " not found.");
        }
        if (isset(self::$data[$key1])) {
            return self::$data[$key1];
        }
        throw new Exception("Config key " . $key1 . " not found.");
    }
    public static function setData($key1, $key2, $value)
    {
        if (isset(self::$data[$key1][$key2])) {
            self::$data[$key1][$key2] = $value;
        } else {
            throw new Exception("Config keys " . $key1 . ", " . $key2 . " not found.");
        }
    }
    public static function setEnvironment($value)
    {
        self::$data["environment"] = $value;
    }
    public static function getAccountCredentials()
    {
        if (isset(self::$data["credentials"]) && isset(self::$data["credentials"]["email"]) && isset(self::$data["credentials"]["token"][self::$data["environment"]])) {
            return new PagSeguroAccountCredentials(self::$data["credentials"]["email"], self::$data["credentials"]["token"][self::$data["environment"]]);
        }
        throw new Exception("Credentials not set.");
    }
    public static function getPaymentRedirectUrl()
    {
        return PagSeguroResources::getPaymentUrl(self::$data["environment"]);
    }
    public static function getStaticUrl()
    {
        return PagSeguroResources::getStaticUrl(self::$data["environment"]);
    }
    public static function getEnvironment()
    {
        if (isset(self::$data["environment"])) {
            return self::$data["environment"];
        }
        throw new Exception("Environment not set.");
    }
    public static function getApplicationCharset()
    {
        if (isset(self::$data["application"]) && isset(self::$data["application"]["charset"])) {
            return self::$data["application"]["charset"];
        }
        throw new Exception("Application charset not set.");
    }
    public static function setApplicationCharset($charset)
    {
        $this::setData("application", "charset", $charset);
    }
    public static function logIsActive()
    {
        if (isset(self::$data["log"]) && isset(self::$data["log"]["active"])) {
            return $easytoyou_decoder_beta_not_finish;
        }
        throw new Exception("Log activation flag not set.");
    }
    public static function activeLog($fileName = NULL)
    {
        $this::setData("log", "active", true);
        $this::setData("log", "fileLocation", $fileName ? $fileName : "");
        LogPagSeguro::reLoad();
    }
    public static function getLogFileLocation()
    {
        if (isset(self::$data["log"]) && isset(self::$data["log"]["fileLocation"])) {
            return self::$data["log"]["fileLocation"];
        }
        throw new Exception("Log file location not set.");
    }
    public static function validateRequirements()
    {
        $requirements = ["version" => "", "spl" => "", "curl" => "", "dom" => ""];
        $version = str_replace(".", "", phpversion());
        if ($version < 533) {
            $requirements["version"] = "PagSeguroLibrary: PHP version 5.3.3 or greater is required.";
        }
        if (!function_exists("spl_autoload_register")) {
            $requirements["spl"] = "PagSeguroLibrary: Standard PHP Library (SPL) is required.";
        }
        if (!function_exists("curl_init")) {
            $requirements["curl"] = "PagSeguroLibrary: cURL library is required.";
        }
        if (!class_exists("DOMDocument")) {
            $requirements["dom"] = "PagSeguroLibrary: DOM XML extension is required.";
        }
        return $requirements;
    }
}

?>