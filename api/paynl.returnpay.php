<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$strUrl = "https://rest-api.pay.nl/v3/Transaction/info/json?";
$args = [];
$args["transactionId"] = $_GET["orderId"];
$args["token"] = "bd169a4729b49b59d4469322ae017158336583b8";
$strUrl = $strUrl . http_build_query($args);
$arrResult = json_decode(@curl_file_get_contents($strUrl));
$message = "Thank you for your donation! Your points are added.";
if ($arrResult->paymentDetails->stateName != "PAID") {
    $message = "Something went wrong, we will redirect you to the homepage.";
}
session_destroy();
echo "<script>alert(";
echo json_encode($message);
echo ");\r\n    location.href = \"/\";</script>\r\n\r\n?>";

?>