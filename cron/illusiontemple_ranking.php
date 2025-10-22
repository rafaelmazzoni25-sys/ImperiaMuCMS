<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$file_name = basename(__FILE__);
$dir_path = str_replace("\\", "/", dirname(dirname(__FILE__))) . "/";
include $dir_path . "includes/imperiamucms.php";
$Rankings = new Rankings();
loadModuleConfigs("rankings");
if (mconfig("active")) {
    if (mconfig("rankings_enable_illusiontemple")["@attributes"]["general"]) {
        $Rankings->UpdateRankingCache("illusiontemple");
    }
    if (mconfig("rankings_enable_illusiontemple")["@attributes"]["monthly"]) {
        $Rankings->UpdateRankingCache("monthly_illusiontemple");
    }
    if (mconfig("rankings_enable_illusiontemple")["@attributes"]["weekly"]) {
        $Rankings->UpdateRankingCache("weekly_illusiontemple");
    }
    if (mconfig("rankings_enable_illusiontemple")["@attributes"]["daily"]) {
        $Rankings->UpdateRankingCache("daily_illusiontemple");
    }
}
updateCronLastRun($file_name);

?>