<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$file_name = basename(__FILE__);
$dir_path = str_replace("\\", "/", dirname(dirname(__FILE__))) . "/";
include $dir_path . "includes/imperiamucms.php";
$Rankings = new Rankings();
loadModuleConfigs("rankings");
if (mconfig("active")) {
    if (mconfig("rankings_enable_resets")["@attributes"]["general"]) {
        $Rankings->UpdateRankingCache("resets");
    }
    if (mconfig("rankings_enable_resets")["@attributes"]["monthly"]) {
        $Rankings->UpdateRankingCache("monthly_resets");
    }
    if (mconfig("rankings_enable_resets")["@attributes"]["weekly"]) {
        $Rankings->UpdateRankingCache("weekly_resets");
    }
    if (mconfig("rankings_enable_resets")["@attributes"]["daily"]) {
        $Rankings->UpdateRankingCache("daily_resets");
    }
    if (mconfig("rankings_enable_fast_resets")["@attributes"]["general"]) {
        $Rankings->UpdateRankingCache("fast_resets");
    }
}
updateCronLastRun($file_name);

?>