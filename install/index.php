<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

define("__IMPERIAMUCMS_LICENSE_SERVER__", "http://imperiamucms.com/");
define("__IMPERIAMUCMS_FREE__", "ImperiaMuCMS Free Package;Additional License for ImperiaMuCMS Free Package");
define("__IMPERIAMUCMS_LITE__", "ImperiaMuCMS Lite Package;ImperiaMuCMS Lite Package (Rent);ImperiaMuCMS Lite Package (Lifetime);Additional License for ImperiaMuCMS Lite Package;Additional License for ImperiaMuCMS Lite Package (Lifetime)");
define("__IMPERIAMUCMS_PREMIUM__", "ImperiaMuCMS Premium Package;ImperiaMuCMS Premium Package (Rent);ImperiaMuCMS Premium Package (lifetime);Additional License for ImperiaMuCMS Premium Package;Additional License for ImperiaMuCMS Premium Package (Lifetime)");
define("__IMPERIAMUCMS_PREMIUM_PLUS__", "ImperiaMuCMS Plus Package;ImperiaMuCMS Plus Package (Rent);ImperiaMuCMS Plus Package (Lifetime);Additional License for ImperiaMuCMS Premium Plus Package;Additional License for ImperiaMuCMS Premium Plus Package (Lifetime)");
define("__IMPERIAMUCMS_BRONZE__", "ImperiaMuCMS Bronze Package;Additional License for Bronze Package");
define("__IMPERIAMUCMS_SILVER__", "ImperiaMuCMS Silver Package;Additional License for Silver Package");
define("__IMPERIAMUCMS_GOLD__", "ImperiaMuCMS Gold Package;Additional License for Gold Package;ImperiaMuCMS Gold Package [Lifetime];Additional License for Gold Package [Lifetime]");
if (!(include_once "../includes/config.php")) {
    throw new Exception("Could not load the configurations file.");
}
$_SERVER["REMOTE_ADDR"] = isset($_SERVER["HTTP_CF_CONNECTING_IP"]) ? $_SERVER["HTTP_CF_CONNECTING_IP"] : $_SERVER["REMOTE_ADDR"];
if (empty($_SERVER["HTTP_HOST"])) {
    $server_host = $_SERVER["SERVER_NAME"];
} else {
    $server_host = $_SERVER["HTTP_HOST"];
}
define("HTTP_HOST", $_SERVER["HTTP_HOST"]);
define("SERVER_PROTOCOL", !empty($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"]) == "on" ? "https://" : "http://");
define("__ROOT_DIR__", str_replace("\\", "/", dirname(dirname(__FILE__))) . "/");
define("__RELATIVE_ROOT__", str_ireplace(rtrim(str_replace("\\", "/", realpath(str_replace($_SERVER["SCRIPT_NAME"], "", $_SERVER["SCRIPT_FILENAME"]))), "/"), "", __ROOT_DIR__));
if (strpos(__RELATIVE_ROOT__, "/install/") === false) {
    $installFolder = "install/";
} else {
    if (strpos(__RELATIVE_ROOT__, "/install") === true) {
        $installFolder = "/";
    } else {
        $installFolder = "";
    }
}
define("__BASE_URL__", SERVER_PROTOCOL . HTTP_HOST . __RELATIVE_ROOT__ . $installFolder);
define("__DOMAIN__", SERVER_PROTOCOL . HTTP_HOST);
if (!(include_once "../includes/classes/class.database.php")) {
    throw new Exception("Could not load class (database).");
}
if (!(include_once "../includes/classes/class.general.php")) {
    throw new Exception("Could not load class (general).");
}
if (!(include_once "../includes/classes/class.smtp.php")) {
    throw new Exception("Could not load class (general).");
}
if (!(include_once "../includes/functions/function.global.php")) {
    throw new Exception("Could not load function (global).");
}
if (!(include_once "../includes/functions/function.config.php")) {
    throw new Exception("Could not load function (config).");
}
if (!(include_once "../includes/custom.php")) {
    throw new Exception("Could not load custom data.");
}
$General = new xGeneral();
if (isset($_GET["step"]) && $_GET["step"] == "install") {
    $dB = new dB($config["SQL_DB_HOST"], $config["SQL_DB_PORT"], $config["SQL_DB_NAME"], $config["SQL_DB_USER"], $config["SQL_DB_PASS"], $config["SQL_PDO_DRIVER"]);
    if ($dB->dead) {
        echo "\r\n              <div class=\"alert alert-danger\" role=\"alert\">\r\n                <span class=\"glyphicon glyphicon-exclamation-sign\" aria-hidden=\"true\"></span>\r\n                <span class=\"sr-only\">Error:</span>\r\n                Connection to " . $config["SQL_DB_NAME"] . " failed. " . $dB->error . "\r\n              </div>";
    }
    if ($config["SQL_USE_2_DB"]) {
        $dB2 = new dB($config["SQL_DB_HOST"], $config["SQL_DB_PORT"], $config["SQL_DB_2_NAME"], $config["SQL_DB_USER"], $config["SQL_DB_PASS"], $config["SQL_PDO_DRIVER"]);
        if ($dB2->dead) {
            echo "\r\n                  <div class=\"alert alert-danger\" role=\"alert\">\r\n                    <span class=\"glyphicon glyphicon-exclamation-sign\" aria-hidden=\"true\"></span>\r\n                    <span class=\"sr-only\">Error:</span>\r\n                    Connection to " . $config["SQL_DB_2_NAME"] . " failed. " . $dB->error . "\r\n                  </div>";
        }
    }
}
echo "\r\n<!DOCTYPE html>\r\n<html lang=\"en\">\r\n<head>\r\n    <meta charset=\"utf-8\">\r\n    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">\r\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">\r\n    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->\r\n    <title>ImperiaMuCMS Install</title>\r\n    <!-- Latest compiled and minified CSS -->\r\n    <link rel=\"stylesheet\" href=\"css/bootstrap.css\">\r\n    <link rel=\"stylesheet\" href=\"css/font-awesome.min.css\">\r\n    <link rel=\"stylesheet\" href=\"css/extra.css\">\r\n</head>\r\n<body>\r\n<div class=\"container\" style=\"padding-top: 10px;\">\r\n    ";
if (isset($_GET["step"])) {
    include $_GET["step"] . ".php";
} else {
    include "systemcheck.php";
}
echo "</div>\r\n<!-- Include all compiled plugins (below), or include individual files as needed -->\r\n<script src=\"js/jquery.min.js\"></script>\r\n<script src=\"js/bootstrap.min.js\"></script>\r\n<script src=\"js/bootstrap_validator.min.js\"></script>\r\n<script src=\"js/redirect.js\"></script>\r\n</body>\r\n</html>";

?>