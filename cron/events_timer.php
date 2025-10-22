<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$file_name = basename(__FILE__);
$dir_path = str_replace("\\", "/", dirname(dirname(__FILE__))) . "/";
include $dir_path . "includes/imperiamucms.php";
loadModuleConfigs("eventstimer");
if (mconfig("active")) {
    $dbDATA = $dB->query_fetch("SELECT [name], [type], [time], [times], [order], [active], [monday], [tuesday], [wednesday], [thursday], [friday], [saturday], [sunday] \r\n      FROM IMPERIAMUCMS_EVENTS_TIMER WHERE [active] = '1' ORDER BY [order] ASC");
    $cacheDATA = BuildCacheData($dbDATA);
    UpdateCache("events_timer.cache", $cacheDATA);
}

?>