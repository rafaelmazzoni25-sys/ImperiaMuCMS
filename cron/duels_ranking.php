<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$file_name = basename(__FILE__);
$dir_path = str_replace("\\", "/", dirname(dirname(__FILE__))) . "/";
include $dir_path . "includes/imperiamucms.php";
$Rankings = new Rankings();
loadModuleConfigs("rankings");
if (mconfig("active")) {
    if (mconfig("rankings_enable_duels")["@attributes"]["general"]) {
        $Rankings->UpdateRankingCache("duels");
    }
    if (mconfig("rankings_enable_duels")["@attributes"]["monthly"]) {
        $Rankings->UpdateRankingCache("monthly_duels");
    }
    if (mconfig("rankings_enable_duels")["@attributes"]["weekly"]) {
        $Rankings->UpdateRankingCache("weekly_duels");
    }
    if (mconfig("rankings_enable_duels")["@attributes"]["daily"]) {
        $Rankings->UpdateRankingCache("daily_duels");
    }
}
updateCronLastRun($file_name);

?>