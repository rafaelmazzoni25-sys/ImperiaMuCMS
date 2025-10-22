<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

include "../includes/imperiamucms.php";
loadModuleConfigs("donation.superrewards");
$sr["secret"] = mconfig("sr_secret");
$id = $_REQUEST["id"];
$new = $_REQUEST["new"];
$total = $_REQUEST["total"];
$uid = $_REQUEST["uid"];
$oid = $_REQUEST["oid"];
$sig = $_REQUEST["sig"];
$signature = md5($id . ":" . $new . ":" . $uid . ":" . $sr["secret"]);
$error = false;
if (!check_value($id) || !check_value($new) || !check_value($total) || !check_value($uid) || !check_value($oid) || !check_value($sig)) {
    $error = true;
    $code = 100;
}
if ($sig != $signature) {
    $error = true;
    $code = 101;
}
if (!$common->userExists($uid)) {
    $error = true;
    $code = 102;
}
if ($common->accountOnline($uid) && mconfig("check_online")) {
    $error = true;
    $code = 103;
}
$checkTID = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_SR_TRANSACTIONS WHERE transaction_id = ?", [$id]);
if (is_array($checkTID)) {
    $error = true;
    $code = 104;
}
$user_id = $common->retrieveUserID($uid);
if (!$error) {
    try {
        if (!Validator::UnsignedNumber($user_id)) {
            throw new Exception("invalid userid");
        }
        $accountInfo = $common->accountInformation($user_id);
        if (!is_array($accountInfo)) {
            throw new Exception("invalid account");
        }
        $creditSystem = new CreditSystem($common, new Character(), $dB, $dB2);
        $creditSystem->setConfigId(mconfig("credit_config"));
        $configSettings = $creditSystem->showConfigs(true);
        switch ($configSettings["config_user_col_id"]) {
            case "userid":
                $creditSystem->setIdentifier($accountInfo[_CLMN_MEMBID_]);
                break;
            case "username":
                $creditSystem->setIdentifier($accountInfo[_CLMN_USERNM_]);
                break;
            case "email":
                $creditSystem->setIdentifier($accountInfo[_CLMN_EMAIL_]);
                $_GET["page"] = "api";
                $_GET["subpage"] = "superrewards";
                $creditSystem->addCredits($new);
                $add_logs_data = [$id, $user_id, $new, time()];
                $add_logs = $dB->query("INSERT INTO IMPERIAMUCMS_SR_TRANSACTIONS (transaction_id,user_id,credits_amount,transaction_date) VALUES (?, ?, ?, ?)", $add_logs_data);
                exit("1");
                break;
            default:
                throw new Exception("invalid identifier");
        }
    } catch (Exception $ex) {
        $add_error_logs_data = [$id, $user_id, $new, time(), $code];
        $add_error_logs = $dB->query("INSERT INTO IMPERIAMUCMS_SR_ERROR_LOGS (transaction_id,user_id,credits_amount,transaction_date,error_code) VALUES (?, ?, ?, ?, ?)", $add_error_logs_data);
        exit("0");
    }
}
$add_error_logs_data = [$id, $user_id, $new, time(), $code];
$add_error_logs = $dB->query("INSERT INTO IMPERIAMUCMS_SR_ERROR_LOGS (transaction_id,user_id,credits_amount,transaction_date,error_code) VALUES (?, ?, ?, ?, ?)", $add_error_logs_data);
exit("0");

?>