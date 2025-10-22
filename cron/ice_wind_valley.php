<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$General = new xGeneral();
if ($General->ftanHCIfo_canUse_j8GsnawwvJ_Module("icewindvalley")) {
    $file_name = basename(__FILE__);
    $dir_path = str_replace("\\", "/", dirname(dirname(__FILE__))) . "/";
    include $dir_path . "includes/imperiamucms.php";
    $castleData = $dB->query_fetch("\r\nSELECT g.G_Name, g.G_Master, CONVERT(varchar(max), g.G_Mark, 2) as G_Mark, iw.CastleState, iw.Occupied, iw.LastSiegeDate\r\nFROM IGC_IceWind_Data iw\r\nINNER JOIN Guild g ON g.Number = iw.OwnerGuildNumber");
    $castleGuilds = $dB->query_fetch("\r\nSELECT g.G_Name, g.G_Master, CONVERT(varchar(max), g.G_Mark, 2) as G_Mark, iw.status\r\nFROM IGC_IceWind_RegGuildList iw\r\nINNER JOIN Guild g ON g.Number = iw.guildnumber");
    if (is_array($castleGuilds)) {
        $guildList = [];
        $i = 0;
        foreach ($castleGuilds as $row) {
            $guildList[$i] = [$row["G_Name"], $row["G_Master"], $row["G_Mark"], $row["status"]];
            $i++;
        }
    }
    $data = [$castleData[0]];
    foreach ($guildList as $thisGuild) {
        array_push($data, $thisGuild);
    }
    if (is_array($data)) {
        $cacheDATA = BuildCacheData($data);
        UpdateCache("ice_wind_valley.cache", $cacheDATA);
    }
    updateCronLastRun($file_name);
}

?>