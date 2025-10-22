<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

include "../includes/imperiamucms.php";
loadModuleConfigs("donation.paymentwall");
$secret_key = mconfig("pw_secret_key");
$app_key = mconfig("pw_app_key");
$userId = isset($_GET["uid"]) ? $_GET["uid"] : NULL;
$credits = isset($_GET["currency"]) ? $_GET["currency"] : NULL;
$type = isset($_GET["type"]) ? $_GET["type"] : NULL;
$refId = isset($_GET["ref"]) ? $_GET["ref"] : NULL;
$signature = isset($_GET["sig"]) ? $_GET["sig"] : NULL;
$result = false;
$signatureParams = ["uid" => $userId, "currency" => $credits, "type" => $type, "ref" => $refId];
$signatureCalculated = signaturegenerator($signatureParams, $secret_key);
$error = false;
if (!check_value($userId) || !check_value($credits) || !check_value($type) || !check_value($refId) || !check_value($signature)) {
    $error = true;
    $code = 100;
}
if ($signature != $signatureCalculated) {
    $error = true;
    $code = 101;
}
if (!$common->userExists($userId)) {
    $error = true;
    $code = 102;
}
if ($common->accountOnline($userId) && mconfig("check_online")) {
    $error = true;
    $code = 103;
}
$checkTID = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_PW_TRANSACTIONS WHERE transaction_id = ?", [$refId]);
if (is_array($checkTID)) {
    $error = true;
    $code = 104;
}
if (!in_array($_SERVER["REMOTE_ADDR"], ["174.36.92.186", "174.36.96.66", "174.36.92.187", "174.36.92.192", "174.37.14.28"])) {
    $error = true;
    $code = 105;
}
$user_id = $common->retrieveUserID($userId);
if ($user_id == NULL || empty($user_id)) {
    $user_id = 0;
}
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
                $_GET["subpage"] = "paymentwall";
                if ($type == 2) {
                    $creditSystem->subtractCredits($credits);
                    $xtype = "chargeback";
                } else {
                    if ($type == 0 || $type == 1) {
                        $creditSystem->addCredits($credits);
                        $xtype = "payment";
                    }
                }
                $add_logs_data = [$refId, $user_id, $credits, time(), $xtype];
                $add_logs = $dB->query("INSERT INTO IMPERIAMUCMS_PW_TRANSACTIONS (transaction_id,user_id,credits_amount,transaction_date,type) VALUES (?, ?, ?, ?, ?)", $add_logs_data);
                $result = true;
                echo "OK";
                break;
            default:
                throw new Exception("invalid identifier");
        }
    } catch (Exception $ex) {
        $add_error_logs_data = [$refId, $user_id, $credits, time(), $code];
        $add_error_logs = $dB->query("INSERT INTO IMPERIAMUCMS_PW_ERROR_LOGS (transaction_id,user_id,credits_amount,transaction_date,error_code) VALUES (?, ?, ?, ?, ?)", $add_error_logs_data);
        $result = false;
        echo "ERROR";
    }
} else {
    $add_error_logs_data = [$refId, $user_id, $credits, time(), $code];
    $add_error_logs = $dB->query("INSERT INTO IMPERIAMUCMS_PW_ERROR_LOGS (transaction_id,user_id,credits_amount,transaction_date,error_code) VALUES (?, ?, ?, ?, ?)", $add_error_logs_data);
    $result = false;
    echo "ERROR";
}
function SignatureGenerator($params, $secret)
{
    $str = "";
    foreach ($params as $k => $v) {
        $str .= $k . "=" . $v;
    }
    $str .= $secret;
    return md5($str);
}

?>