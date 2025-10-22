<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class PagSeguroResources
{
    private static $data = NULL;
    private static $resources = NULL;
    const VAR_NAME = "PagSeguroResources";
    private function __construct()
    {
        define("ALLOW_PAGSEGURO_RESOURCES", true);
        require_once PagSeguroLibrary::getPath() . DIRECTORY_SEPARATOR . "resources" . DIRECTORY_SEPARATOR . "PagSeguroResources.php";
        $varName = "PagSeguroResources";
        if (isset($varName)) {
            self::$data = ${$varName};
            unset($varName);
        } else {
            throw new Exception("Resources is undefined.");
        }
    }
    public static function init()
    {
        if (self::$resources == NULL) {
            self::$resources = new PagSeguroResources();
        }
        return self::$resources;
    }
    public static function getData($key1, $key2 = NULL)
    {
        if ($key2 != NULL) {
            if (isset(self::$data[$key1][$key2])) {
                return self::$data[$key1][$key2];
            }
            throw new Exception("Resources keys " . $key1 . ", " . $key2 . " not found.");
        }
        if (isset(self::$data[$key1])) {
            return self::$data[$key1];
        }
        throw new Exception("Resources key " . $key1 . " not found.");
    }
    public static function setData($key1, $key2, $value)
    {
        if (isset(self::$data[$key1][$key2])) {
            self::$data[$key1][$key2] = $value;
        } else {
            throw new Exception("Resources keys " . $key1 . ", " . $key2 . " not found.");
        }
    }
    public static function getWebserviceUrl($environment)
    {
        if (isset(self::$data["webserviceUrl"]) && isset(self::$data["webserviceUrl"][$environment])) {
            return self::$data["webserviceUrl"][$environment];
        }
        throw new Exception("WebService URL not set for " . $environment . " environment.");
    }
    public static function getPaymentUrl($environment)
    {
        if (isset(self::$data["paymentService"]) && isset(self::$data["paymentService"]["baseUrl"]) && isset(self::$data["paymentService"]["baseUrl"][$environment])) {
            return self::$data["paymentService"]["baseUrl"][$environment];
        }
        throw new Exception("Payment URL not set for " . $environment . " environment.");
    }
    public static function getStaticUrl($environment)
    {
        if (isset(self::$data["staticUrl"]) && isset(self::$data["staticUrl"][$environment])) {
            return self::$data["staticUrl"][$environment];
        }
        throw new Exception("Static URL not set for " . $environment . " environment.");
    }
}

?>