<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

include "../includes/imperiamucms.php";
$ipArr = json_decode(@curl_file_get_contents("https://rest-api.pay.nl/v1/Validate/getPayServerIps/json/?"));
if (array_search($_SERVER["REMOTE_ADDR"], $ipArr) === false) {
    header("Status: 404 Not Found");
    exit;
}
$amount = $_POST["amount"];
$extra1 = $_POST["extra1"];
$strUrl = "https://rest-api.pay.nl/v3/Transaction/info/json?";
$args = [];
$args["transactionId"] = $_POST["order_id"];
$args["token"] = "bd169a4729b49b59d4469322ae017158336583b8";
$strUrl = $strUrl . http_build_query($args);
$arrResult = json_decode(@curl_file_get_contents($strUrl));
if ($arrResult->paymentDetails->stateName != "PAID") {
    exit("TRUE|yep");
}
$creditsPerMoney = ["500" => 500, "1000" => 1000, "2000" => 2100, "3000" => 3300, "4000" => 4500, "5000" => 5750];
$money = intval($arrResult->paymentDetails->paidAmount);
$credits = $creditsPerMoney[$money];
$user_id = $common->retrieveUserID($extra1);
if (config("MEMB_CREDITS_MEMUONLINE", true)) {
    $reward = $dB2->query("UPDATE MEMB_CREDITS SET gold = gold + " . $credits . " WHERE memb___id = '" . $extra1 . "'");
} else {
    $reward = $dB->query("UPDATE MEMB_CREDITS SET gold = gold + " . $credits . " WHERE memb___id = '" . $extra1 . "'");
}
$add_logs_data = [$args["transactionId"], $user_id, $credits, time()];
$add_logs = $dB->query("INSERT INTO IMPERIAMUCMS_PAYNL_TRANSACTIONS (transaction_id,user_id,credits_amount,transaction_date) VALUES (?, ?, ?, ?)", $add_logs_data);
$logDate = date("Y-m-d H:i:s", time());
$common->accountLogs($extra1, "donation", "Received " . $credits . " Gold Coins for donation with Pay.nl.", $logDate);
echo "TRUE|" . json_encode(["credits" => $credits, "money" => $money]);

?>