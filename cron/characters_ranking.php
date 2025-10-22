<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$file_name = basename(__FILE__);
$dir_path = str_replace("\\", "/", dirname(dirname(__FILE__))) . "/";
include $dir_path . "includes/imperiamucms.php";
$Rankings = new Rankings();
loadModuleConfigs("rankings");
if (mconfig("active")) {
    if (mconfig("rankings_enable_characters")["@attributes"]["general"]) {
        $Rankings->UpdateRankingCache("characters");
    }
    if (mconfig("rankings_enable_characters")["@attributes"]["monthly"]) {
        $Rankings->UpdateRankingCache("monthly_characters");
    }
    if (mconfig("rankings_enable_characters")["@attributes"]["weekly"]) {
        $Rankings->UpdateRankingCache("weekly_characters");
    }
    if (mconfig("rankings_enable_characters")["@attributes"]["daily"]) {
        $Rankings->UpdateRankingCache("daily_characters");
    }
}
updateCronLastRun($file_name);

?>