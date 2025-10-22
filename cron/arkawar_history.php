<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$file_name = basename(__FILE__);
$dir_path = str_replace("\\", "/", dirname(dirname(__FILE__))) . "/";
include $dir_path . "includes/imperiamucms.php";
$General = new xGeneral();
if ($General->ftanHCIfo_canUse_j8GsnawwvJ_Module("arkawar")) {
    $arkaWinners = $dB->query_fetch("\r\n      SELECT TOP 2 ab.G_Name as G_Name, CONVERT(date, ab.WinDate) as WinDate, ab.OuccupyObelisk as OuccupyObelisk, \r\n        ab.ObeliskGroup as ObeliskGroup, CONVERT(varchar(max), g.G_Mark, 2) as G_Mark, g.G_Master as G_Master\r\n      FROM IGC_ARCA_BATTLE_WIN_GUILD_INFO ab\r\n      INNER JOIN Guild g ON ab.G_Name = g.G_Name\r\n      ORDER BY WinDate DESC\r\n    ");
    if (is_array($arkaWinners)) {
        $arkaWarHistory = $dB->query_fetch_single("SELECT TOP 1 G_Name, CONVERT(date, WinDate) as WinDate FROM IMPERIAMUCMS_ARKAWAR_HISTORY ORDER BY WinDate DESC");
        if ($arkaWarHistory["WinDate"] == NULL || $arkaWinners[0]["WinDate"] != $arkaWarHistory["WinDate"]) {
            $insert1 = $dB->query("INSERT INTO IMPERIAMUCMS_ARKAWAR_HISTORY (G_Name, G_Mark, G_Master, WinDate, OuccupyObelisk, ObeliskGroup) VALUES (?, ?, ?, ?, ?, ?)", [$arkaWinners[0]["G_Name"], $arkaWinners[0]["G_Mark"], $arkaWinners[0]["G_Master"], $arkaWinners[0]["WinDate"], $arkaWinners[0]["OuccupyObelisk"], $arkaWinners[0]["ObeliskGroup"]]);
            if (is_array($arkaWinners[1]) && $arkaWinners[0]["WinDate"] == $arkaWinners[1]["WinDate"]) {
                $insert1 = $dB->query("INSERT INTO IMPERIAMUCMS_ARKAWAR_HISTORY (G_Name, G_Mark, G_Master, WinDate, OuccupyObelisk, ObeliskGroup) VALUES (?, ?, ?, ?, ?, ?)", [$arkaWinners[1]["G_Name"], $arkaWinners[1]["G_Mark"], $arkaWinners[1]["G_Master"], $arkaWinners[1]["WinDate"], $arkaWinners[1]["OuccupyObelisk"], $arkaWinners[1]["ObeliskGroup"]]);
            }
        }
    }
}
updateCronLastRun($file_name);

?>