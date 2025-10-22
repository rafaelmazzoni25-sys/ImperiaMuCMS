<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

include "../includes/imperiamucms.php";
loadModuleConfigs("donation.tmpay");
define("DEBUG", 1);
define("LOG_FILE", "../__logs/tmpay_ipn.log");
$General = new xGeneral();
if ($General->ftanHCIfo_canUse_j8GsnawwvJ_Module("tmpay")) {
    if (mconfig("active")) {
        $allowedIPs = explode(";", mconfig("access_ip"));
        $merchantId = mconfig("merchant_id");
        $transactionId = $_GET["transaction_id"];
        $cardCode = $_GET["password"];
        $status = $_GET["status"];
        $realAmount = $_GET["real_amount"];
        if ($status == "1") {
            if (in_array($_SERVER["REMOTE_ADDR"], $allowedIPs)) {
                if (is_array(mconfig("options")["option"])) {
                    $found = false;
                    foreach (mconfig("options")["option"] as $thisOpt) {
                        if ($realAmount == $thisOpt["@attributes"]["amount"]) {
                            $found = true;
                            $reward = $thisOpt["@attributes"]["reward"];
                            $bonus = $thisOpt["@attributes"]["bonus"];
                            if ($found) {
                                $data = $dB->query_fetch_single("SELECT AccountID, Code, RealAmount, TransactionID, Status FROM IMPERIAMUCMS_DONATE_TMPAY WHERE Code = ? AND Status = ?", [$cardCode, 0]);
                                if (is_array($data)) {
                                    try {
                                        $user_id = $common->retrieveUserID($data["AccountID"]);
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
                                                $_GET["subpage"] = "tmpay";
                                                $creditSystem->addCredits($reward + $bonus);
                                                $update = $dB->query("UPDATE IMPERIAMUCMS_DONATE_TMPAY SET Status = ?, RewardAmount = ?, BonusAmount = ?, RewardType = ? WHERE Code = ?", [1, $reward, $bonus, mconfig("credit_config"), $cardCode]);
                                                if ($update) {
                                                    exit("SUCCEED|UID=" . $user_id);
                                                }
                                                exit("ERROR|WHILE_UPDATE_TMN");
                                                break;
                                            default:
                                                throw new Exception("invalid identifier");
                                        }
                                    } catch (Exception $ex) {
                                        exit("ERROR|WHILE_UPDATE_CASH");
                                    }
                                }
                                exit("ERROR|FIND_NOT_FOUND_DATA");
                            }
                            exit("ERROR|ANY_REASONS");
                        }
                    }
                } else {
                    exit("ERROR|ANY_REASONS");
                }
            } else {
                exit("ERROR|ANY_REASONS");
            }
        } else {
            $dB->query("UPDATE IMPERIAMUCMS_DONATE_TMPAY SET Status = ? WHERE Code = ?", [$status, $cardCode]);
            exit("ERROR|ANY_REASONS");
        }
    } else {
        exit("ERROR|ANY_REASONS");
    }
}

?>