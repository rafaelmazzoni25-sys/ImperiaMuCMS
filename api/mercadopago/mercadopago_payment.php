<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

include "../../includes/imperiamucms.php";
require_once "mercadopago.php";
define("LOG_FILE", "../../__logs/mercadopago_ipn.log");
if (!file_exists(LOG_FILE)) {
    $fp = fopen(LOG_FILE, "w");
    fclose($fp);
}
loadModuleConfigs("donation.mercadopago");
if (!mconfig("active")) {
    redirect(1, "donation");
}
if (isset($_POST["amount"]) && ctype_digit($_POST["amount"])) {
    try {
        $order_id = xss_clean($_POST["order_id"]);
        $amount = floatval($_POST["amount"]);
        $client_id = mconfig("mercadopago_client_id");
        $client_secret = mconfig("mercadopago_client_secret");
        $mp = new MP($client_id, $client_secret);
        $preference_data = ["items" => [["title" => mconfig("mercadopago_title") . " - " . $_SESSION["username"], "currency_id" => mconfig("mercadopago_currency"), "quantity" => 1, "unit_price" => $amount]], "back_urls" => ["success" => mconfig("mercadopago_success_url"), "failure" => mconfig("mercadopago_failure_url"), "pending" => mconfig("mercadopago_pending_url")], "notification_url" => mconfig("mercadopago_notify_url")];
        $preference = $mp->create_preference($preference_data);
        if (isset($preference["response"])) {
            if (mconfig("mercadopago_enable_sandbox")) {
                $url = $preference["response"]["sandbox_init_point"];
            } else {
                $url = $preference["response"]["init_point"];
            }
        }
        if (isset($url)) {
            $item_name = mconfig("mercadopago_title") . " - " . $_SESSION["username"];
            $item_number = $order_id;
            $payment_status = $preference["response"]["operation_type"];
            $payment_amount = $amount;
            $payment_currency = mconfig("mercadopago_currency");
            $txn_id = $preference["response"]["id"];
            $payer_email = $preference["response"]["payer"]["email"];
            $account_id = $_SESSION["userid"];
            $user_id = $_SESSION["userid"];
            $add_credits = $payment_amount * mconfig("mercadopago_conversion_rate");
            if (mconfig("mercadopago_bonus_amount5") <= $payment_amount && 0 < mconfig("mercadopago_bonus_amount5")) {
                $add_credits += $add_credits / 100 * mconfig("mercadopago_bonus_perc5");
            } else {
                if (mconfig("mercadopago_bonus_amount4") <= $payment_amount && 0 < mconfig("mercadopago_bonus_amount4")) {
                    $add_credits += $add_credits / 100 * mconfig("mercadopago_bonus_perc4");
                } else {
                    if (mconfig("mercadopago_bonus_amount3") <= $payment_amount && 0 < mconfig("mercadopago_bonus_amount3")) {
                        $add_credits += $add_credits / 100 * mconfig("mercadopago_bonus_perc3");
                    } else {
                        if (mconfig("mercadopago_bonus_amount2") <= $payment_amount && 0 < mconfig("mercadopago_bonus_amount2")) {
                            $add_credits += $add_credits / 100 * mconfig("mercadopago_bonus_perc2");
                        } else {
                            if (mconfig("mercadopago_bonus_amount1") <= $payment_amount && 0 < mconfig("mercadopago_bonus_amount1")) {
                                $add_credits += $add_credits / 100 * mconfig("mercadopago_bonus_perc1");
                            }
                        }
                    }
                }
            }
            $add_credits = floor($add_credits);
            if (empty($payer_email)) {
                $payer_email = "unknown";
            }
            if (!$common->mercadopago_transaction($txn_id, $user_id, $payment_amount, $payer_email, $item_number, $add_credits, mconfig("credit_config"), $payment_currency)) {
                set_flash_msg("error", lang("donation_txt_52", true));
                redirect(1, "donation/mercadopago");
            } else {
                redirect(3, $url);
            }
        } else {
            set_flash_msg("error", lang("donation_txt_53", true));
            redirect(1, "donation/mercadopago");
        }
    } catch (Exception $ex) {
        error_log(date("[Y-m-d H:i e] ") . "[PAYMENT] EXCEPTION: " . $ex . PHP_EOL, 3, LOG_FILE);
        redirect(1, "donation/mercadopago");
    }
} else {
    set_flash_msg("warning", lang("donation_txt_54", true));
    redirect(1, "donation/mercadopago");
}

?>