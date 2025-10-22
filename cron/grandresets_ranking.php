<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$file_name = basename(__FILE__);
$dir_path = str_replace("\\", "/", dirname(dirname(__FILE__))) . "/";
include $dir_path . "includes/imperiamucms.php";
$Rankings = new Rankings();
loadModuleConfigs("rankings");
if (mconfig("active")) {
    if (mconfig("rankings_enable_gr")["@attributes"]["general"]) {
        $Rankings->UpdateRankingCache("grandresets");
    }
    if (mconfig("rankings_enable_gr")["@attributes"]["monthly"]) {
        $Rankings->UpdateRankingCache("monthly_grandresets");
    }
    if (mconfig("rankings_enable_gr")["@attributes"]["weekly"]) {
        $Rankings->UpdateRankingCache("weekly_grandresets");
    }
    if (mconfig("rankings_enable_gr")["@attributes"]["daily"]) {
        $Rankings->UpdateRankingCache("daily_grandresets");
    }
    if (mconfig("rankings_enable_fast_gresets")["@attributes"]["general"]) {
        $Rankings->UpdateRankingCache("fast_grandresets");
    }
}
updateCronLastRun($file_name);

?>