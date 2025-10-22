<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

include "../includes/imperiamucms.php";
loadModuleConfigs("usercp.vote");
$Vote = new Vote();
$userId = isset($_GET["p_resp"]) ? $_GET["p_resp"] : NULL;
$voteIp = 0;
$credits = $dB->query_fetch_single("SELECT votesite_reward, votesite_id FROM IMPERIAMUCMS_VOTE_SITES WHERE postback_type = 'topg'");
$votesite_id = $credits["votesite_id"];
$credits = $credits["votesite_reward"];
$delay = mconfig("delay");
$result = false;
$error = false;
if (!check_value($userId) || !check_value($voteIp)) {
    $error = true;
    $code = 100;
}
if (!$common->userExists($userId)) {
    $error = true;
    $code = 101;
}
if (!in_array($_SERVER["REMOTE_ADDR"], ["192.99.101.31"])) {
    $error = true;
    $code = 102;
}
$user_id = $common->retrieveUserID($userId);
if (!$Vote->canVote($user_id, $votesite_id, $voteIp)) {
    $error = true;
    $code = 103;
}
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
                $_GET["subpage"] = "topg";
                $creditSystem->addCredits($credits);
                $getData = $dB->query_fetch_single("SELECT TOP 1 * FROM IMPERIAMUCMS_VOTES WHERE user_id = ? AND vote_site_id = ? ORDER BY timestamp desc", [$user_id, $votesite_id]);
                $add_logs = $dB->query("UPDATE IMPERIAMUCMS_VOTES SET timestamp = ?, confirm = ? WHERE user_id = ? AND vote_site_id = ? AND timestamp = ?", [time(), "1", $user_id, $votesite_id, $getData["timestamp"]]);
                $logDate = date("Y-m-d H:i:s", time());
                $common->accountLogs($userId, "vote", "Received reward for voting on TopG.", $logDate);
                $result = true;
                echo "OK";
                break;
            default:
                throw new Exception("invalid identifier");
        }
    } catch (Exception $ex) {
        $add_error_logs_data = [$user_id, $voteIp, $votesite_id, time(), $code];
        $add_error_logs = $dB->query("INSERT INTO IMPERIAMUCMS_VOTE_LOGS(user_id, user_ip, vote_site_id, timestamp, error_code) VALUES (?, ?, ?, ?, ?)", $add_error_logs_data);
        $result = false;
        echo "ERROR";
    }
} else {
    $add_error_logs_data = [$user_id, $voteIp, $votesite_id, time(), $code];
    $add_error_logs = $dB->query("INSERT INTO IMPERIAMUCMS_VOTE_LOGS(user_id, user_ip, vote_site_id, timestamp, error_code) VALUES (?, ?, ?, ?, ?)", $add_error_logs_data);
    $result = false;
    echo "ERROR";
    echo " " . $code;
}

?>