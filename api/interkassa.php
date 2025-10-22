<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

include "../includes/imperiamucms.php";
loadModuleConfigs("donation.interkassa");
define("DEBUG", 1);
define("LOG_FILE", "../__logs/interkassa_ipn.log");
$checkoutID = $_POST["ik_co_id"];
$invoiceID = $_POST["ik_inv_id"];
$invoiceStatus = $_POST["ik_inv_st"];
$invoiceCreated = $_POST["ik_inv_crt"];
$invoiceProceed = $_POST["ik_inv_prc"];
$transactionID = $_POST["ik_trn_id"];
$paymentID = $_POST["ik_pm_no"];
$paidWith = $_POST["ik_pw_via"];
$amount = $_POST["ik_am"];
$currency = $_POST["ik_cur"];
$packageID = $_POST["ik_x_baggage"];
$sign = $_POST["ik_sign"];
if ($invoiceStatus == "success") {
    $allowedIPs = ["151.80.190.97", "151.80.190.98", "151.80.190.99", "151.80.190.100", "151.80.190.101", "151.80.190.102", "151.80.190.103", "151.80.190.104"];
    if (!in_array($_SERVER["REMOTE_ADDR"], $allowedIPs)) {
        if (DEBUG) {
            error_log(date("[Y-m-d H:i e] ") . " [" . $_SERVER["REMOTE_ADDR"] . "] [" . $paymentID . "] [101] Invalid IP." . PHP_EOL, 3, LOG_FILE);
        }
        exit;
    }
    $transactionData = $dB->query_fetch_single("SELECT TOP 1 * FROM IMPERIAMUCMS_DONATE_INTERKASSA WHERE payment_id = ? AND status = ?", [$paymentID, 0]);
    if (is_array($transactionData)) {
        if (mconfig("enable_signature") && $transactionData["signature"] != $sign) {
            if (DEBUG) {
                error_log(date("[Y-m-d H:i e] ") . " [" . $_SERVER["REMOTE_ADDR"] . "] [" . $paymentID . "] [102] Invalid signature. [" . $transactionData["signature"] . " | " . $sign . "]" . PHP_EOL, 3, LOG_FILE);
            }
            exit;
        }
        if ($transactionData["package_id"] != $packageID) {
            if (DEBUG) {
                error_log(date("[Y-m-d H:i e] ") . " [" . $_SERVER["REMOTE_ADDR"] . "] [" . $paymentID . "] [104] Invalid package ID. [" . $transactionData["package_id"] . " | " . $packageID . "]" . PHP_EOL, 3, LOG_FILE);
            }
            exit;
        }
        $packageAmount = NULL;
        $packageCurrency = NULL;
        $packageReward = NULL;
        $xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "donation.interkassa.xml");
        if ($xml !== false) {
            foreach ($xml->options->children() as $tag => $option) {
                if ($tag == "option" && $option["id"] == $transactionData["package_id"]) {
                    $packageAmount = $option["amount"];
                    $packageCurrency = $option["currency"];
                    $packageReward = $option["reward"];
                }
            }
        }
        if ($packageAmount != NULL && $packageCurrency != NULL && $packageReward != NULL) {
            if ($transactionData["amount"] != $amount) {
                if (DEBUG) {
                    error_log(date("[Y-m-d H:i e] ") . " [" . $_SERVER["REMOTE_ADDR"] . "] [" . $paymentID . "] [105] Invalid amount. [" . $transactionData["amount"] . " | " . $amount . "]" . PHP_EOL, 3, LOG_FILE);
                }
                exit;
            }
            if ($transactionData["amount_currency"] != $currency) {
                if (DEBUG) {
                    error_log(date("[Y-m-d H:i e] ") . " [" . $_SERVER["REMOTE_ADDR"] . "] [" . $paymentID . "] [106] Invalid currency. [" . $transactionData["amount_currency"] . " | " . $currency . "]" . PHP_EOL, 3, LOG_FILE);
                }
                exit;
            }
            if ($transactionData["reward"] != $packageReward) {
                if (DEBUG) {
                    error_log(date("[Y-m-d H:i e] ") . " [" . $_SERVER["REMOTE_ADDR"] . "] [" . $paymentID . "] [107] Invalid reward. [" . $transactionData["reward"] . " | " . $packageReward . "]" . PHP_EOL, 3, LOG_FILE);
                }
                exit;
            }
            try {
                $user_id = $common->retrieveUserID($transactionData["AccountID"]);
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
                        $_GET["subpage"] = "interkassa";
                        $creditSystem->addCredits($packageReward);
                        $update = $dB->query("UPDATE IMPERIAMUCMS_DONATE_INTERKASSA SET checkout_id = ?, invoice_id = ?, invoice_created = ?, invoice_processed = ?, transaction_id = ?, paid_with = ?, status = ? WHERE payment_id = ?", [$checkoutID, $invoiceID, $invoiceCreated, $invoiceProceed, $transactionID, $paidWith, 1, $paymentID]);
                        break;
                    default:
                        throw new Exception("invalid identifier");
                }
            } catch (Exception $ex) {
                if (DEBUG) {
                    error_log(date("[Y-m-d H:i e] ") . " [" . $_SERVER["REMOTE_ADDR"] . "] [" . $paymentID . "] [108] Exception: " . $ex . "" . PHP_EOL, 3, LOG_FILE);
                }
            }
        } else {
            if (DEBUG) {
                error_log(date("[Y-m-d H:i e] ") . " [" . $_SERVER["REMOTE_ADDR"] . "] [" . $paymentID . "] [103] Invalid package data. [" . $transactionData["package_id"] . " | " . $packageID . "]." . PHP_EOL, 3, LOG_FILE);
            }
            exit;
        }
    } else {
        if (DEBUG) {
            error_log(date("[Y-m-d H:i e] ") . " [" . $_SERVER["REMOTE_ADDR"] . "] [" . $paymentID . "] [100] Could not find transaction data." . PHP_EOL, 3, LOG_FILE);
        }
        exit;
    }
} else {
    if (DEBUG) {
        error_log(date("[Y-m-d H:i e] ") . " [" . $_SERVER["REMOTE_ADDR"] . "] [" . $paymentID . "] [099] Invalid status. [" . $invoiceStatus . "]" . PHP_EOL, 3, LOG_FILE);
    }
    exit;
}

?>