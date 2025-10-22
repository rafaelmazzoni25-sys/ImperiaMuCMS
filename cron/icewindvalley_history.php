<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$file_name = basename(__FILE__);
$dir_path = str_replace("\\", "/", dirname(dirname(__FILE__))) . "/";
include $dir_path . "includes/imperiamucms.php";
$General = new xGeneral();
if ($General->ftanHCIfo_canUse_j8GsnawwvJ_Module("icewindvalley")) {
    $valleyWinners = $dB->query_fetch_single("\r\n      SELECT TOP 1 g.G_Name as G_Name, CONVERT(date, iw.LastSiegeDate) as WinDate, CONVERT(varchar(max), g.G_Mark, 2) as G_Mark, g.G_Master as G_Master\r\n      FROM IGC_IceWind_Data iw\r\n      INNER JOIN Guild g ON iw.OwnerGuildNumber = g.Number\r\n      ORDER BY LastSiegeDate DESC\r\n    ");
    if (is_array($valleyWinners)) {
        $valleyHistory = $dB->query_fetch_single("SELECT TOP 1 G_Name, CONVERT(date, WinDate) as WinDate FROM IMPERIAMUCMS_IWV_HISTORY ORDER BY WinDate DESC");
        if ($valleyWinners["WinDate"] != NULL && ($valleyHistory["WinDate"] == NULL || $valleyWinners["WinDate"] != $valleyHistory["WinDate"])) {
            $dB->query("INSERT INTO IMPERIAMUCMS_IWV_HISTORY (G_Name, G_Mark, G_Master, WinDate) VALUES (?, ?, ?, ?)", [$valleyWinners["G_Name"], $valleyWinners["G_Mark"], $valleyWinners["G_Master"], $valleyWinners["WinDate"]]);
        }
    }
}
updateCronLastRun($file_name);

?>