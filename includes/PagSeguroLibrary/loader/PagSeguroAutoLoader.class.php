<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class PagSeguroAutoloader
{
    private static $dirs = ["config", "resources", "log", "domain", "exception", "parser", "service", "utils", "helper"];
    public static $loader = NULL;
    private function __construct()
    {
        if (function_exists("__autoload")) {
            spl_autoload_register("__autoload");
        }
        spl_autoload_register([$this, "addClass"]);
    }
    public static function init()
    {
        if (!function_exists("spl_autoload_register")) {
            throw new Exception("PagSeguroLibrary: Standard PHP Library (SPL) is required.");
        }
        if (self::$loader == NULL) {
            self::$loader = new PagSeguroAutoloader();
        }
        return self::$loader;
    }
    private function addClass($class)
    {
        foreach (self::$dirs as $key => $dir) {
            $file = PagSeguroLibrary::getPath() . DIRECTORY_SEPARATOR . $dir . DIRECTORY_SEPARATOR . $class . ".class.php";
            if (file_exists($file) && is_file($file)) {
                require_once $file;
            }
        }
    }
}

?>