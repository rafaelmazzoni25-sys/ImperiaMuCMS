<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$file_name = basename(__FILE__);
$dir_path = str_replace("\\", "/", dirname(dirname(__FILE__))) . "/";
include $dir_path . "includes/imperiamucms.php";
loadModuleConfigs("bosstimer");
if (mconfig("active")) {
    $dbDATA = $dB->query_fetch("SELECT [name], [monsterId], [respawn], [order], [active] FROM IMPERIAMUCMS_BOSS_TIMER WHERE [active] = '1' ORDER BY [order] ASC");
    $cacheDATA = BuildCacheData($dbDATA);
    UpdateCache("boss_timer.cache", $cacheDATA);
}

?>