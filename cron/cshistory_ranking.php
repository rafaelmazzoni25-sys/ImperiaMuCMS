<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$file_name = basename(__FILE__);
$dir_path = str_replace("\\", "/", dirname(dirname(__FILE__))) . "/";
include $dir_path . "includes/imperiamucms.php";
$Rankings = new Rankings();
loadModuleConfigs("rankings");
if (mconfig("active") && mconfig("rankings_enable_cshistory")["@attributes"]["general"]) {
    $Rankings->UpdateRankingCache("cshistory");
}
updateCronLastRun($file_name);

?>