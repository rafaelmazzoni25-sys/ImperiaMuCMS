<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$json = [];
try {
    session_start();
    @ini_set("default_charset", "utf-8");
    $filepath = str_replace("\\", "/", dirname(__FILE__));
    $rootpath = dirname($filepath);
    if (empty($_SERVER["HTTP_HOST"])) {
        $server_host = $_SERVER["SERVER_NAME"];
    } else {
        $server_host = $_SERVER["HTTP_HOST"];
    }
    define("HTTP_HOST", $server_host);
    define("SERVER_PROTOCOL", !empty($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"]) == "on" ? "https://" : "http://");
    define("__ROOT_DIR__", $rootpath . "/");
    define("__RELATIVE_ROOT__", str_ireplace(rtrim(str_replace("\\", "/", realpath(str_replace($_SERVER["SCRIPT_NAME"], "", $_SERVER["SCRIPT_FILENAME"]))), "/"), "", __ROOT_DIR__));
    define("__BASE_URL__", SERVER_PROTOCOL . HTTP_HOST . __RELATIVE_ROOT__);
    define("__PATH_INCLUDES__", __ROOT_DIR__ . "includes/");
    if (!(include_once __PATH_INCLUDES__ . "config.php")) {
        throw new Exception("Could not load the configurations file.");
    }
    date_default_timezone_set($config["timezone_name"]);
    $time = time();
    $json["ServerTime"] = date("Y-m-d H:i:s", $time);
} catch (Exception $e) {
    $json["error"] = $e->getMessage();
    echo json_encode($json);
}

?>