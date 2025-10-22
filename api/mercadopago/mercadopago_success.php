<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */
include "../../includes/imperiamucms.php";
require_once "mercadopago.php";
define("LOG_FILE", "../../__logs/mercadopago_ipn.log");
if (!file_exists(LOG_FILE)) {
    $fp = fopen(LOG_FILE, "w");
    fclose($fp);
}
$msg = "";
error_log(date("[Y-m-d H:i e] ") . "SUCCESS START " . PHP_EOL, 3, LOG_FILE);
error_log(date("[Y-m-d H:i e] ") . "SUCCESS GET " . var_export($_GET, true) . PHP_EOL, 3, LOG_FILE);
error_log(date("[Y-m-d H:i e] ") . "SUCCESS POST " . var_export($_POST, true) . PHP_EOL, 3, LOG_FILE);
try {
    loadModuleConfigs("donation.mercadopago");
    $client_id = mconfig("mercadopago_client_id");
    $client_secret = mconfig("mercadopago_client_secret");
    $mp = new MP($client_id, $client_secret);
    $id_name = "preference_id";
    if (!isset($_GET[$id_name])) {
        $msg = "Wrong ID. " . var_export($_GET, true);
        error_log(date("[Y-m-d H:i e] ") . "SUCCESS " . $msg . PHP_EOL, 3, LOG_FILE);
        http_response_code(400);
        return NULL;
    }
    $payment_info = $mp->get_payment_info($_GET[$id_name]);
    error_log(date("[Y-m-d H:i e] ") . "SUCCESS PAYMENT: " . var_export($payment_info, true) . PHP_EOL, 3, LOG_FILE);
    if ($payment_info["status"] == 200) {
        $msg = var_export($payment_info, true);
        error_log(date("[Y-m-d H:i e] ") . "SUCCESS MSG: " . $msg . PHP_EOL, 3, LOG_FILE);
        $transaction_id = $_GET[$id_name];
        try {
            $transaction = $common->mercadopago_get_transaction($transaction_id);
            if (is_array($transaction)) {
                $msg = var_export($transaction, true);
                error_log(date("[Y-m-d H:i e] ") . "SUCCESS MSG2: " . $msg . PHP_EOL, 3, LOG_FILE);
                if ($transaction["transaction_status"] == 1) {
                    $user_id = $transaction["user_id"];
                    $add_credits = $transaction["reward_amount"];
                    $accountInfo = $common->accountInformation($user_id);
                    if (!is_array($accountInfo)) {
                        throw new Exception("invalid account");
                    }
                    $creditSystem = new CreditSystem($common, new Character(), $dB, $dB2);
                    $creditSystem->setConfigId($transaction["reward_type"]);
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
                            $creditSystem->addCredits($add_credits);
                            if (!$common->mercadopago_transaction_updatestatus($transaction_id, 2)) {
                                $msg = "Failed to update transaction status";
                            } else {
                                $msg = "Transaction ID: " . $transaction_id . " - SUCCESS";
                            }
                            break;
                        default:
                            throw new Exception("invalid identifier");
                    }
                } else {
                    $msg = "Transaction ID: " . $transaction_id . " - Credits already added";
                }
            } else {
                $msg = "Transaction ID: " . $transaction_id . " - not found";
            }
        } catch (Exception $ex) {
            $msg = $ex;
        }
    }
    if (!empty($msg)) {
        error_log(date("[Y-m-d H:i e] ") . "SUCCESS MSG3: " . $msg . PHP_EOL, 3, LOG_FILE);
        print_r_formatted($msg);
    }
} catch (Exception $ex) {
    error_log(date("[Y-m-d H:i e] ") . "SUCCESS EXCEPTION: " . $ex . PHP_EOL, 3, LOG_FILE);
    error_log(date("[Y-m-d H:i e] ") . "SUCCESS END " . PHP_EOL, 3, LOG_FILE);
}

?>