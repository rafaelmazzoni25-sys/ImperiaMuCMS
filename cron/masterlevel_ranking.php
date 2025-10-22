<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$file_name = basename(__FILE__);
$dir_path = str_replace("\\", "/", dirname(dirname(__FILE__))) . "/";
include $dir_path . "includes/imperiamucms.php";
$Rankings = new Rankings();
loadModuleConfigs("rankings");
if (mconfig("active")) {
    if (mconfig("rankings_enable_master")["@attributes"]["general"]) {
        $Rankings->UpdateRankingCache("master");
    }
    if (mconfig("rankings_enable_master")["@attributes"]["monthly"]) {
        $Rankings->UpdateRankingCache("monthly_master");
    }
    if (mconfig("rankings_enable_master")["@attributes"]["weekly"]) {
        $Rankings->UpdateRankingCache("weekly_master");
    }
    if (mconfig("rankings_enable_master")["@attributes"]["daily"]) {
        $Rankings->UpdateRankingCache("daily_master");
    }
}
updateCronLastRun($file_name);

?>