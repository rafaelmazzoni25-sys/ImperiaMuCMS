<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

PagSeguroLibrary::init();
class PagSeguroLibrary
{
    private static $php_version = NULL;
    public static $resources = NULL;
    public static $config = NULL;
    public static $log = NULL;
    private static $path = NULL;
    private static $library = NULL;
    private static $module_version = NULL;
    private static $cms_version = NULL;
    const VERSION = "2.2.4";
    private function __construct()
    {
        self::$path = dirname(__FILE__);
        PagSeguroAutoloader::init();
        self::$resources = PagSeguroResources::init();
        self::$config = PagSeguroConfig::init();
        self::$log = LogPagSeguro::init();
    }
    public static function init()
    {
        require_once "loader" . DIRECTORY_SEPARATOR . "PagSeguroAutoLoader.class.php";
        $this::verifyDependencies();
        if (self::$library == NULL) {
            self::$library = new PagSeguroLibrary();
        }
        return self::$library;
    }
    private static function verifyDependencies()
    {
        $dependencies = true;
        try {
            if (!function_exists("curl_init")) {
                $dependencies = false;
                throw new Exception("PagSeguroLibrary: cURL library is required.");
            }
            if (!class_exists("DOMDocument")) {
                $dependencies = false;
                throw new Exception("PagSeguroLibrary: DOM XML extension is required.");
            }
            return $dependencies;
        } catch (Exception $e) {
            return $dependencies;
        }
    }
    public static final function getVersion()
    {
        return "2.2.4";
    }
    public static final function getPath()
    {
        return self::$path;
    }
    public static final function getModuleVersion()
    {
        return self::$module_version;
    }
    public static final function setModuleVersion($version)
    {
        self::$module_version = $version;
    }
    public static final function getPHPVersion()
    {
        return self::$php_version = phpversion();
    }
    public static final function setPHPVersion($version)
    {
        self::$php_version = $version;
    }
    public static final function getCMSVersion()
    {
        return self::$cms_version;
    }
    public static final function setCMSVersion($version)
    {
        self::$cms_version = $version;
    }
}

?>