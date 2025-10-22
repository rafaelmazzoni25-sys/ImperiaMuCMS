<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

include "../includes/imperiamucms.php";
loadModuleConfigs("donation.nganluong");
require_once __PATH_INCLUDES__ . "libs/nganluong/lib/nusoap.php";
require_once __PATH_INCLUDES__ . "libs/nganluong/nganluong.microcheckout.class.php";
$obj = new NL_MicroCheckout(mconfig("merchant_id"), mconfig("merchant_pass"), mconfig("url_ws"));
$order_code = $_GET["order_code"];
if ($obj->checkReturnUrlAuto()) {
    $inputs = ["token" => $obj->getTokenCode()];
    $result = $obj->getExpressCheckout($inputs);
    if ($result) {
        if ($result["result_code"] != "00") {
            $dB->query("UPDATE IMPERIAMUCMS_DONATE_NGANLUONG SET result_code = ?, result_msg = ? WHERE order_code = ?", [$result["result_code"], $result["result_description"], $order_code]);
            exit("Mã lỗi " . $result["result_code"] . " (" . $result["result_description"] . ") ");
        }
        if (isset($result) && !empty($result) && $result["result_code"] == "00") {
            $transaction = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_DONATE_NGANLUONG WHERE order_code = ?", [$order_code]);
            $user_id = $common->retrieveUserID($transaction["AccountID"]);
            $credits = $transaction["reward"];
            try {
                if (!Validator::UnsignedNumber($user_id)) {
                    throw new Exception("invalid userid");
                }
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
                        $_GET["subpage"] = "nganluong";
                        $creditSystem->addCredits($credits);
                        $update = $dB->query("UPDATE IMPERIAMUCMS_DONATE_NGANLUONG SET transaction_id = ?, transaction_type = ?, transaction_status = ?,\n                paid_with = ?, payer_name = ?, payer_email = ?, payer_mobile = ?, result_code = ?, result_msg = ?, status = ? ", [$result["transaction_id"], $result["transaction_type"], $result["transaction_status"], $result["method_payment_name"], $result["payer_name"], $result["payer_email"], $result["payer_mobile"], $result["result_code"], $result["result_description"], 1]);
                        break;
                    default:
                        throw new Exception("invalid identifier");
                }
            } catch (Exception $ex) {
                $update = $dB->query("UPDATE IMPERIAMUCMS_DONATE_NGANLUONG SET transaction_id = ?, transaction_type = ?, transaction_status = ?,\n                paid_with = ?, payer_name = ?, payer_email = ?, payer_mobile = ?, result_code = ?, result_msg = ?, status = ? ", [$result["transaction_id"], $result["transaction_type"], $result["transaction_status"], $result["method_payment_name"], $result["payer_name"], $result["payer_email"], $result["payer_mobile"], $result["result_code"], $result["result_description"], 0]);
            }
        }
    } else {
        exit("Lỗi kết nối tới cổng thanh toán Ngân Lượng");
    }
} else {
    exit("Tham số truyền không đúng");
}

?>