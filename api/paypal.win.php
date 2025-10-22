<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

include "../includes/imperiamucms.php";
loadModuleConfigs("donation.paypal");
$req = "cmd=_notify-validate";
foreach ($_POST as $key => $value) {
    $value = urlencode(stripslashes($value));
    $req .= "&" . $key . "=" . $value;
}
$header = "POST /cgi-bin/webscr HTTP/1.1\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Host: www.paypal.com\r\n";
$header .= "Connection: close\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
$fp = fsockopen("ssl://www.paypal.com", 443, $errno, $errstr, 30);
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
if (!$fp) {
}
if ($fp) {
    fputs($fp, $header . $req);
    while (!feof($fp)) {
        $res = fgets($fp, 1024);
        $res = trim($res);
        if (strcmp($res, "VERIFIED") == 0 && strtolower($receiver_email) == strtolower(mconfig("paypal_email"))) {
            if (($txn_type == "web_accept" || $txn_type == "subscr_payment") && $payment_status == "Completed") {
                $add_credits = $payment_amount * mconfig("paypal_conversion_rate");
                if (mconfig("paypal_bonus_amount3") <= $payment_amount) {
                    $add_credits = $add_credits + $add_credits / 100 * mconfig("paypal_bonus_perc3");
                } else {
                    if (mconfig("paypal_bonus_amount2") <= $payment_amount) {
                        $add_credits = $add_credits + $add_credits / 100 * mconfig("paypal_bonus_perc2");
                    } else {
                        if (mconfig("paypal_bonus_amount1") <= $payment_amount) {
                            $add_credits = $add_credits + $add_credits / 100 * mconfig("paypal_bonus_perc1");
                        }
                    }
                }
                $add_credits = floor($add_credits);
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
                            $_GET["subpage"] = "paypal(win)";
                            $creditSystem->addCredits($add_credits);
                            $common->paypal_transaction($txn_id, $user_id, $payment_amount, $payer_email, $item_number);
                            break;
                        default:
                            throw new Exception("invalid identifier");
                    }
                } catch (Exception $ex) {
                    exit;
                }
            }
            if ($payment_status == "Reversed" || $payment_status == "Refunded") {
                $common->blockAccount($user_id);
                $common->paypal_transaction_reversed_updatestatus($item_number);
            }
        }
        if (strcmp($res, "INVALID") == 0) {
        }
    }
    fclose($fp);
}

?>