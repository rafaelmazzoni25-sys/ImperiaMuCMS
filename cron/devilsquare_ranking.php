<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$file_name = basename(__FILE__);
$dir_path = str_replace("\\", "/", dirname(dirname(__FILE__))) . "/";
include $dir_path . "includes/imperiamucms.php";
$Rankings = new Rankings();
loadModuleConfigs("rankings");
if (mconfig("active")) {
    if (mconfig("rankings_enable_devilsquare")["@attributes"]["general"]) {
        $Rankings->UpdateRankingCache("devilsquare");
    }
    if (mconfig("rankings_enable_devilsquare")["@attributes"]["monthly"]) {
        $Rankings->UpdateRankingCache("monthly_devilsquare");
    }
    if (mconfig("rankings_enable_devilsquare")["@attributes"]["weekly"]) {
        $Rankings->UpdateRankingCache("weekly_devilsquare");
    }
    if (mconfig("rankings_enable_devilsquare")["@attributes"]["daily"]) {
        $Rankings->UpdateRankingCache("daily_devilsquare");
    }
}
updateCronLastRun($file_name);

?>