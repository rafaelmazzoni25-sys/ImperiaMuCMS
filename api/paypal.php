<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

define("DEBUG", 1);
define("LOG_FILE", "../__logs/paypal_ipn.log");
include "../includes/imperiamucms.php";
loadModuleConfigs("donation.paypal");
$raw_post_data = file_get_contents("php://input");
$raw_post_array = explode("&", $raw_post_data);
$myPost = [];
foreach ($raw_post_array as $keyval) {
    $keyval = explode("=", $keyval);
    if (count($keyval) == 2) {
        $myPost[$keyval[0]] = urldecode($keyval[1]);
    }
}
$req = "cmd=_notify-validate";
if (function_exists("get_magic_quotes_gpc")) {
    $get_magic_quotes_exits = true;
}
foreach ($myPost as $key => $value) {
    if ($get_magic_quotes_exits && get_magic_quotes_gpc() == 1) {
        $value = urlencode(stripslashes($value));
    } else {
        $value = urlencode($value);
    }
    $req .= "&" . $key . "=" . $value;
}
$ch = curl_init();
if (mconfig("paypal_enable_sandbox")) {
    curl_setopt($ch, CURLOPT_URL, "https://www.sandbox.paypal.com/cgi-bin/webscr");
} else {
    curl_setopt($ch, CURLOPT_URL, "https://www.paypal.com/cgi-bin/webscr");
}
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Host: www.paypal.com"]);
$res = curl_exec($ch);
if (curl_errno($ch) != 0) {
    if (DEBUG) {
        error_log(date("[Y-m-d H:i e]") . " Can't connect to PayPal to validate IPN message: " . curl_error($ch) . PHP_EOL, 3, LOG_FILE);
    }
    curl_close($ch);
    exit;
}
if (DEBUG) {
    error_log(date("[Y-m-d H:i e]") . " HTTP request of validation request: " . curl_getinfo($ch, CURLINFO_HEADER_OUT) . " for IPN payload: " . $req . PHP_EOL, 3, LOG_FILE);
    error_log(date("[Y-m-d H:i e]") . " HTTP response of validation request: " . $res . PHP_EOL, 3, LOG_FILE);
}
curl_close($ch);
$tokens = explode("\r\n\r\n", trim($res));
$res = trim(end($tokens));
if (strcmp($res, "VERIFIED") == 0) {
    $item_name = $_POST["item_name"];
    $item_number = $_POST["item_number"];
    $payment_status = $_POST["payment_status"];
    $payment_amount = $_POST["mc_gross"];
    $payment_currency = $_POST["mc_currency"];
    $txn_id = $_POST["txn_id"];
    $txn_type = $_POST["txn_type"];
    $receiver_email = $_POST["receiver_email"];
    $payer_email = $_POST["payer_email"];
    $account_id = $_POST["custom"];
    $user_id = Decode($account_id);
    error_log(date("[Y-m-d H:i e]") . " Loaded UserID: [" . $user_id . "]" . PHP_EOL, 3, LOG_FILE);
    error_log(date("[Y-m-d H:i e]") . " Emails: [" . strtolower($receiver_email) . "] [" . strtolower(mconfig("paypal_email")) . "]" . PHP_EOL, 3, LOG_FILE);
    if (strtolower($receiver_email) == strtolower(mconfig("paypal_email"))) {
        error_log(date("[Y-m-d H:i e]") . " Emails check OK" . PHP_EOL, 3, LOG_FILE);
        error_log(date("[Y-m-d H:i e]") . " Currencies: [" . $payment_currency . "] [" . mconfig("paypal_currency") . "]" . PHP_EOL, 3, LOG_FILE);
        if ($payment_currency == mconfig("paypal_currency")) {
            error_log(date("[Y-m-d H:i e]") . " Currency check OK" . PHP_EOL, 3, LOG_FILE);
            error_log(date("[Y-m-d H:i e]") . " TXN: [" . $txn_type . "] Status: [" . $payment_status . "]" . PHP_EOL, 3, LOG_FILE);
            if (($txn_type == "web_accept" || $txn_type == "subscr_payment") && $payment_status == "Completed") {
                if (0 < $tax) {
                    $payment_amount -= $tax;
                }
                $add_credits = $payment_amount * mconfig("paypal_conversion_rate");
                if (mconfig("paypal_bonus_amount5") <= $payment_amount && 0 < mconfig("paypal_bonus_amount5")) {
                    $add_credits = $add_credits + $add_credits / 100 * mconfig("paypal_bonus_perc5");
                } else {
                    if (mconfig("paypal_bonus_amount4") <= $payment_amount && 0 < mconfig("paypal_bonus_amount4")) {
                        $add_credits = $add_credits + $add_credits / 100 * mconfig("paypal_bonus_perc4");
                    } else {
                        if (mconfig("paypal_bonus_amount3") <= $payment_amount && 0 < mconfig("paypal_bonus_amount3")) {
                            $add_credits = $add_credits + $add_credits / 100 * mconfig("paypal_bonus_perc3");
                        } else {
                            if (mconfig("paypal_bonus_amount2") <= $payment_amount && 0 < mconfig("paypal_bonus_amount2")) {
                                $add_credits = $add_credits + $add_credits / 100 * mconfig("paypal_bonus_perc2");
                            } else {
                                if (mconfig("paypal_bonus_amount1") <= $payment_amount && 0 < mconfig("paypal_bonus_amount1")) {
                                    $add_credits = $add_credits + $add_credits / 100 * mconfig("paypal_bonus_perc1");
                                }
                            }
                        }
                    }
                }
                $add_credits = floor($add_credits);
                error_log(date("[Y-m-d H:i e]") . " Credits to add: [" . $add_credits . "]" . PHP_EOL, 3, LOG_FILE);
                try {
                    if (!Validator::UnsignedNumber($user_id)) {
                        throw new Exception("invalid userid");
                    }
                    error_log(date("[Y-m-d H:i e]") . " User check OK" . PHP_EOL, 3, LOG_FILE);
                    $accountInfo = $common->accountInformation($user_id);
                    if (!is_array($accountInfo)) {
                        throw new Exception("invalid account");
                    }
                    error_log(date("[Y-m-d H:i e]") . " Account check OK" . PHP_EOL, 3, LOG_FILE);
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
                            $_GET["subpage"] = "paypal";
                            error_log(date("[Y-m-d H:i e]") . " Going to add credits" . PHP_EOL, 3, LOG_FILE);
                            $creditSystem->addCredits($add_credits);
                            error_log(date("[Y-m-d H:i e]") . " Credits added" . PHP_EOL, 3, LOG_FILE);
                            error_log(date("[Y-m-d H:i e]") . " Going to create transaction" . PHP_EOL, 3, LOG_FILE);
                            $common->paypal_transaction($txn_id, $user_id, $payment_amount, $payer_email, $item_number, $add_credits, mconfig("credit_config"), $payment_currency);
                            error_log(date("[Y-m-d H:i e]") . " Transaction created" . PHP_EOL, 3, LOG_FILE);
                            break;
                        default:
                            throw new Exception("invalid identifier");
                    }
                } catch (Exception $ex) {
                    error_log(date("[Y-m-d H:i e]") . " Exception [" . $ex . "]" . PHP_EOL, 3, LOG_FILE);
                    exit;
                }
            }
            if ($payment_status == "Reversed" || $payment_status == "Refunded") {
                error_log(date("[Y-m-d H:i e]") . " Reversed or refunded" . PHP_EOL, 3, LOG_FILE);
                $common->blockAccount($user_id);
                $common->paypal_transaction_reversed_updatestatus($item_number);
            }
        } else {
            if (DEBUG) {
                error_log(date("[Y-m-d H:i e]") . " Invalid currency: [Config: " . mconfig("paypal_currency") . "] [Actual: " . $payment_currency . "] " . PHP_EOL, 3, LOG_FILE);
            }
        }
    }
    if (DEBUG) {
        error_log(date("[Y-m-d H:i e]") . " Verified IPN: " . $req . " " . PHP_EOL, 3, LOG_FILE);
    }
} else {
    if (strcmp($res, "INVALID") == 0 && DEBUG) {
        error_log(date("[Y-m-d H:i e]") . " Invalid IPN: " . $req . PHP_EOL, 3, LOG_FILE);
    }
}

?>