<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

try {
    if (!config("language_switch_active", true)) {
        throw new Exception("The language system is disabled.");
    }
    if (!check_value($_GET["to"])) {
        throw new Exception("Invalid request, no language requested.");
    }
    if (strlen($_GET["to"]) != 2) {
        throw new Exception("Invalid language requested (please use ISO 639-1).");
    }
    if (!Validator::Alpha($_GET["to"])) {
        throw new Exception("Invalid language requested (please use ISO 639-1).");
    }
    if (!$handler->switchLanguage($_GET["to"])) {
        throw new Exception("Could not change language (handler).");
    }
    redirect();
} catch (Exception $ex) {
    if (!config("error_reporting", true)) {
        redirect();
    }
    message("error", $ex->getMessage());
}

?>