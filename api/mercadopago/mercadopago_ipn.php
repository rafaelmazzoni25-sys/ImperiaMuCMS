<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

include "../../includes/imperiamucms.php";
require_once "mercadopago.php";
define("LOG_FILE", "../../__logs/mercadopago_ipn.log");
loadModuleConfigs("donation.mercadopago");
$client_id = mconfig("mercadopago_client_id");
$client_secret = mconfig("mercadopago_client_secret");
$mp = new MP($client_id, $client_secret);
$params = ["access_token" => $mp->get_access_token()];
if (!isset($_GET["id"]) || !ctype_digit($_GET["id"])) {
    http_response_code(400);
} else {
    if ($_GET["topic"] == "payment") {
        $payment_info = $mp->get("/v1/payments/" . $_GET["id"], $params, false);
        $merchant_order_info = $mp->get("/merchant_orders/" . $payment_info["response"]["order"]["id"], $params, false);
    } else {
        if ($_GET["topic"] == "merchant_order") {
            $merchant_order_info = $mp->get("/merchant_orders/" . $_GET["id"], $params, false);
        }
    }
    if ($merchant_order_info["status"] == 200) {
        $transaction_amount_payments = 0;
        $transaction_amount_order = $merchant_order_info["response"]["total_amount"];
        $payments = $merchant_order_info["response"]["payments"];
        foreach ($payments as $payment) {
            if ($payment["status"] == "approved") {
                $transaction_amount_payments += $payment["transaction_amount"];
            }
        }
        if ($transaction_amount_order <= $transaction_amount_payments) {
            try {
                $transaction_id = $merchant_order_info["response"]["preference_id"];
                $transaction = $common->mercadopago_get_transaction($transaction_id);
                if (is_array($transaction) && $transaction["transaction_status"] == 1) {
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
                            $_GET["page"] = "api";
                            $_GET["subpage"] = "mercadopago";
                            $creditSystem->addCredits($add_credits);
                            if (!$common->mercadopago_transaction_updatestatus($transaction_id, 2)) {
                                error_log(date("[Y-m-d H:i e] ") . "FAILED TO UPDATE TRANSACTION [" . $transaction_id . "] " . PHP_EOL, 3, LOG_FILE);
                            }
                            break;
                        default:
                            throw new Exception("invalid identifier");
                    }
                }
            } catch (Exception $ex) {
                error_log(date("[Y-m-d H:i e] ") . "EXCEPTION [" . var_export($ex, true) . "] " . PHP_EOL, 3, LOG_FILE);
            }
        }
    }
}

?>