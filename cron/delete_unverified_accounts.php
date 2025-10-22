<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$file_name = basename(__FILE__);
$dir_path = str_replace("\\", "/", dirname(dirname(__FILE__))) . "/";
include $dir_path . "includes/imperiamucms.php";
loadModuleConfigs("register");
$now = time();
$accountsDelete = "";
$accounts = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_REGISTER_ACCOUNT");
if (is_array($accounts)) {
    foreach ($accounts as $thisAccount) {
        $expDate = $thisAccount["registration_date"] + mconfig("verification_timelimit") * 3600;
        if ($expDate < $now) {
            if ($accountsDelete == "") {
                $accountsDelete = "'" . $thisAccount["registration_account"] . "'";
            } else {
                $accountsDelete .= ",'" . $thisAccount["registration_account"] . "'";
            }
        }
    }
}
if ($accountsDelete != "") {
    $dB->query("DELETE FROM IMPERIAMUCMS_REGISTER_ACCOUNT WHERE registration_account IN (" . $accountsDelete . ")");
}
updateCronLastRun($file_name);

?>