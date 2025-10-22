<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$file_name = basename(__FILE__);
$dir_path = str_replace("\\", "/", dirname(dirname(__FILE__))) . "/";
include $dir_path . "includes/imperiamucms.php";
$Rankings = new Rankings();
loadModuleConfigs("rankings");
if (mconfig("active")) {
    if (mconfig("rankings_enable_guilds")["@attributes"]["general"]) {
        $Rankings->UpdateRankingCache("guilds");
    }
    if (mconfig("rankings_enable_guilds")["@attributes"]["monthly"]) {
        $Rankings->UpdateRankingCache("monthly_guilds");
    }
    if (mconfig("rankings_enable_guilds")["@attributes"]["weekly"]) {
        $Rankings->UpdateRankingCache("weekly_guilds");
    }
    if (mconfig("rankings_enable_guilds")["@attributes"]["daily"]) {
        $Rankings->UpdateRankingCache("daily_guilds");
    }
}
updateCronLastRun($file_name);

?>