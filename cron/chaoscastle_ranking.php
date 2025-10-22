<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$file_name = basename(__FILE__);
$dir_path = str_replace("\\", "/", dirname(dirname(__FILE__))) . "/";
include $dir_path . "includes/imperiamucms.php";
$Rankings = new Rankings();
loadModuleConfigs("rankings");
if (mconfig("active")) {
    if (mconfig("rankings_enable_chaoscastle")["@attributes"]["general"]) {
        $Rankings->UpdateRankingCache("chaoscastle");
    }
    if (mconfig("rankings_enable_chaoscastle")["@attributes"]["monthly"]) {
        $Rankings->UpdateRankingCache("monthly_chaoscastle");
    }
    if (mconfig("rankings_enable_chaoscastle")["@attributes"]["weekly"]) {
        $Rankings->UpdateRankingCache("weekly_chaoscastle");
    }
    if (mconfig("rankings_enable_chaoscastle")["@attributes"]["daily"]) {
        $Rankings->UpdateRankingCache("daily_chaoscastle");
    }
}
updateCronLastRun($file_name);

?>