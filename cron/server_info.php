<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$file_name = basename(__FILE__);
$dir_path = str_replace("\\", "/", dirname(dirname(__FILE__))) . "/";
include $dir_path . "includes/imperiamucms.php";
$totalAccounts = 0;
if (config("SQL_USE_2_DB", true)) {
    $countAccounts = $dB2->query_fetch_single("SELECT COUNT(*) as totalAccounts FROM " . _TBL_MI_);
} else {
    $countAccounts = $dB->query_fetch_single("SELECT COUNT(*) as totalAccounts FROM " . _TBL_MI_);
}
if (is_array($countAccounts)) {
    $totalAccounts = $countAccounts["totalAccounts"];
}
$serverInfo[] = $totalAccounts;
$totalCharacters = 0;
$countCharacters = $dB->query_fetch_single("SELECT COUNT(*) as totalCharacters FROM " . _TBL_CHR_);
if (is_array($countCharacters)) {
    $totalCharacters = $countCharacters["totalCharacters"];
}
$serverInfo[] = $totalCharacters;
$totalGuilds = 0;
$countGuilds = $dB->query_fetch_single("SELECT COUNT(*) as totalGuilds FROM " . _TBL_GUILD_);
if (is_array($countGuilds)) {
    $totalGuilds = $countGuilds["totalGuilds"];
}
$serverInfo[] = $totalGuilds;
$totalOnline = 0;
if (config("SQL_USE_2_DB", true)) {
    $countOnline = $dB2->query_fetch_single("SELECT COUNT(*) as totalOnline FROM " . _TBL_MS_ . " WHERE " . _CLMN_CONNSTAT_ . " = 1");
} else {
    $countOnline = $dB->query_fetch_single("SELECT COUNT(*) as totalOnline FROM " . _TBL_MS_ . " WHERE " . _CLMN_CONNSTAT_ . " = 1");
}
if (is_array($countOnline)) {
    $totalOnline = $countOnline["totalOnline"];
}
$serverInfo[] = $totalOnline;
$totalActivePlayers = 0;
$time = time() - 86400;
$now = date("Y-m-d H:i:s", $time);
if (config("SQL_USE_2_DB", true)) {
    $activePlayers = $dB2->query_fetch_single("SELECT COUNT(*) as activeCount FROM " . _TBL_MS_ . " WHERE ConnectTM > '" . $now . "'");
} else {
    $activePlayers = $dB->query_fetch_single("SELECT COUNT(*) as activeCount FROM " . _TBL_MS_ . " WHERE ConnectTM > '" . $now . "'");
}
if (is_array($activePlayers)) {
    $totalActivePlayers = $activePlayers["activeCount"];
}
$serverInfo[] = $totalActivePlayers;
$cryWolf = "server_statistics_13";
$cryWolfData = $dB->query_fetch_single("SELECT CRYWOLF_STATE FROM MuCrywolf_DATA");
if (is_array($countGuilds) && $cryWolfData["CRYWOLF_STATE"] == "1") {
    $cryWolf = "server_statistics_14";
}
$serverInfo[] = $cryWolf;
$serverInfo[] = "tmp";
$serverInfo[] = "tmp";
$serverInfo[] = "tmp";
$marketItems = $dB->query_fetch_single("SELECT COUNT(*) as count FROM IMPERIAMUCMS_MARKET WHERE is_sold = 0");
$marketItemsSold = $dB->query_fetch_single("SELECT COUNT(*) as count FROM IMPERIAMUCMS_MARKET WHERE is_sold = 1");
$serverInfo[] = $marketItems["count"];
$serverInfo[] = $marketItemsSold["count"];
$webshopItemsSold = $dB->query_fetch_single("SELECT SUM(total_bought) as count FROM IMPERIAMUCMS_WEBSHOP_ITEMS");
$serverInfo[] = $webshopItemsSold["count"];
if (is_array($serverInfo)) {
    $cacheDATA = implode("|", $serverInfo);
    UpdateCache("server_info.cache", $cacheDATA);
}
updateCronLastRun($file_name);

?>