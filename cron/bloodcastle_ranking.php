<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$file_name = basename(__FILE__);
$dir_path = str_replace("\\", "/", dirname(dirname(__FILE__))) . "/";
include $dir_path . "includes/imperiamucms.php";
$Rankings = new Rankings();
loadModuleConfigs("rankings");
if (mconfig("active")) {
    if (mconfig("rankings_enable_bloodcastle")["@attributes"]["general"]) {
        $Rankings->UpdateRankingCache("bloodcastle");
    }
    if (mconfig("rankings_enable_bloodcastle")["@attributes"]["monthly"]) {
        $Rankings->UpdateRankingCache("monthly_bloodcastle");
    }
    if (mconfig("rankings_enable_bloodcastle")["@attributes"]["weekly"]) {
        $Rankings->UpdateRankingCache("weekly_bloodcastle");
    }
    if (mconfig("rankings_enable_bloodcastle")["@attributes"]["daily"]) {
        $Rankings->UpdateRankingCache("daily_bloodcastle");
    }
}
updateCronLastRun($file_name);

?>