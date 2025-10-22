<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$file_name = basename(__FILE__);
$dir_path = str_replace("\\", "/", dirname(dirname(__FILE__))) . "/";
include $dir_path . "includes/imperiamucms.php";
$castleData = $dB->query_fetch("SELECT t1.OWNER_GUILD, CONVERT(varchar(max), t2.G_Mark, 2) as G_Mark, t1.MONEY, t1.TAX_RATE_CHAOS, t1.TAX_RATE_STORE, t1.TAX_HUNT_ZONE, t2.G_Master FROM MuCastle_DATA as t1 INNER JOIN Guild as t2 ON t2.G_Name = t1.OWNER_GUILD");
$castleGuilds = $dB->query_fetch("SELECT REG_SIEGE_GUILD, REG_MARKS FROM MuCastle_REG_SIEGE WHERE IS_GIVEUP = ? ORDER BY REG_MARKS DESC", [0]);
if (is_array($castleGuilds)) {
    $guildList = [];
    $i = 0;
    foreach ($castleGuilds as $row) {
        $guildList[$i] = [$row[_CLMN_MCRS_GUILD_], $row["REG_MARKS"]];
        $i++;
    }
}
$data = [$castleData[0]];
foreach ($guildList as $thisGuild) {
    array_push($data, $thisGuild);
}
if (is_array($data)) {
    $cacheDATA = BuildCacheData($data);
    UpdateCache("castle_siege.cache", $cacheDATA);
}
updateCronLastRun($file_name);

?>