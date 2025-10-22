<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */
define("access", "index");
try {
    if (!file_exists("system.php")) {
        throw new Exception("Website Offline");
    }
    if (!(include_once "includes/imperiamucms.php")) {
        throw new Exception("Could not load ImperiaMuCMS.");
    }
    if ($config["enable_logs"]) {
        if (!empty($_POST)) {
            $fp = fopen(__ROOT_DIR__ . "__logs/post_" . date("Y-m-d", time()) . ".log", "ab");
            if ($fp) {
                fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] [Username: " . $_SESSION["username"] . "] [" . $_SERVER["REQUEST_URI"] . "] [" . var_export($_POST, true) . "]" . PHP_EOL);
                fclose($fp);
            }
        }
        if (!empty($_GET)) {
            $fp = fopen(__ROOT_DIR__ . "__logs/get_" . date("Y-m-d", time()) . ".log", "ab");
            if ($fp) {
                fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] [Username: " . $_SESSION["username"] . "] [" . $_SERVER["REQUEST_URI"] . "] [" . var_export($_GET, true) . "]" . PHP_EOL);
                fclose($fp);
            }
        }
    }
} catch (Exception $ex) {
    $errorPage = file_get_contents("includes/error.html");
    echo str_replace("{ERROR_MESSAGE}", $ex->getMessage(), $errorPage);
}

?>