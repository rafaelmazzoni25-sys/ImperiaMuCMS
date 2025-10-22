<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$file_name = basename(__FILE__);
$dir_path = str_replace("\\", "/", dirname(dirname(__FILE__))) . "/";
include $dir_path . "includes/imperiamucms.php";
$temporalBans = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_BANS");
if (is_array($temporalBans)) {
    foreach ($temporalBans as $tempBan) {
        $banTimestamp = $tempBan["ban_hours"] * 3600 + $tempBan["ban_date"];
        if ($banTimestamp < time()) {
            if ($tempBan["Name"] == NULL) {
                if (config("SQL_USE_2_DB", true)) {
                    $unban = $dB2->query("UPDATE " . _TBL_MI_ . " SET " . _CLMN_BLOCCODE_ . " = 0 WHERE " . _CLMN_USERNM_ . " = ?", [$tempBan["AccountID"]]);
                } else {
                    $unban = $dB->query("UPDATE " . _TBL_MI_ . " SET " . _CLMN_BLOCCODE_ . " = 0 WHERE " . _CLMN_USERNM_ . " = ?", [$tempBan["AccountID"]]);
                }
                if ($unban) {
                    $dB->query("DELETE FROM IMPERIAMUCMS_BANS WHERE AccountID = ?", [$tempBan["AccountID"]]);
                }
            } else {
                $unban = $dB->query("UPDATE Character SET CtlCode = 0 WHERE AccountID = ? AND Name = ?", [$tempBan["AccountID"], $tempBan["Name"]]);
                if ($unban) {
                    $dB->query("DELETE FROM IMPERIAMUCMS_BANS WHERE AccountID = ? AND Name = ?", [$tempBan["AccountID"], $tempBan["Name"]]);
                }
            }
        }
    }
}
updateCronLastRun($file_name);

?>