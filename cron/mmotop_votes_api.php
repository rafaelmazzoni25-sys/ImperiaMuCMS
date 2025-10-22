<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$file_name = basename(__FILE__);
$dir_path = str_replace("\\", "/", dirname(dirname(__FILE__))) . "/";
include $dir_path . "includes/imperiamucms.php";
loadModuleConfigs("usercp.vote");
if (mconfig("active")) {
    $mmotopSite = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_VOTE_SITES WHERE postback_enabled = ? AND postback_type = ?", ["1", "mmotop"]);
    if (is_array($mmotopSite)) {
        $handle = fopen(mconfig("mmotop_postback_file"), "r");
        if ($handle) {
            $latestVote = $dB->query_fetch_single("SELECT postback_id FROM IMPERIAMUCMS_VOTES WHERE confirm = ? AND postback_type = ? ORDER BY postback_id DESC", ["1", "mmotop"]);
            if ($latestVote["postback_id"] != NULL) {
                $latestVote = $latestVote["postback_id"];
            } else {
                $latestVote = "0";
            }
            while (($line = fgets($handle)) !== false) {
                $line = preg_replace(["/\\s{2,}/", "/[\\t\\n]/"], " ", $line);
                $line = rtrim($line);
                $parsed = explode(" ", $line);
                if ($latestVote < $parsed[0] && count($parsed) == 6) {
                    try {
                        if ($common->userExists($parsed[4])) {
                            $user_id = $common->retrieveUserID($parsed[4]);
                            $accountInfo = $common->accountInformation($user_id);
                            if (is_array($accountInfo)) {
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
                                        $_GET["page"] = "cron";
                                        $_GET["subpage"] = "mmotop_vote_api";
                                        $creditSystem->addCredits($mmotopSite["votesite_reward"]);
                                        $add_logs_data = [$user_id, $parsed[3], $mmotopSite["votesite_id"], time(), 1, "mmotop", $parsed[0]];
                                        $add_logs = $dB->query("INSERT INTO IMPERIAMUCMS_VOTES(user_id, user_ip, vote_site_id, timestamp, confirm, postback_type, postback_id) VALUES (?, ?, ?, ?, ?, ?, ?)", $add_logs_data);
                                        $logDate = date("Y-m-d H:i:s", time());
                                        $common->accountLogs($parsed[4], "vote", "Received reward for voting on mmotop.ru.", $logDate);
                                        break;
                                    default:
                                        throw new Exception("invalid identifier");
                                }
                            }
                        }
                    } catch (Exception $ex) {
                        $add_error_logs_data = [$user_id, $parsed[3], $mmotopSite["votesite_id"], time(), $code];
                        $add_error_logs = $dB->query("INSERT INTO IMPERIAMUCMS_VOTE_LOGS(user_id, user_ip, vote_site_id, timestamp, error_code) VALUES (?, ?, ?, ?, ?)", $add_error_logs_data);
                    }
                }
            }
            fclose($handle);
        }
    }
}
updateCronLastRun($file_name);

?>