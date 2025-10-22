<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$file_name = basename(__FILE__);
$dir_path = str_replace("\\", "/", dirname(dirname(__FILE__))) . "/";
include $dir_path . "includes/imperiamucms.php";
$Rankings = new Rankings();
loadModuleConfigs("rankings");
if (mconfig("active")) {
    if (mconfig("rankings_enable_pk")["@attributes"]["general"]) {
        $Rankings->UpdateRankingCache("killers");
    }
    if (mconfig("rankings_enable_pk")["@attributes"]["monthly"]) {
        $Rankings->UpdateRankingCache("monthly_killers");
    }
    if (mconfig("rankings_enable_pk")["@attributes"]["weekly"]) {
        $Rankings->UpdateRankingCache("weekly_killers");
    }
    if (mconfig("rankings_enable_pk")["@attributes"]["daily"]) {
        $Rankings->UpdateRankingCache("daily_killers");
    }
}
updateCronLastRun($file_name);

?>