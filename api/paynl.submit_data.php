<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$strUrl = "https://rest-api.pay.nl/v3/Transaction/start/json?";
$arrArguments = [];
$arrArguments["programId"] = 16402;
$arrArguments["websiteId"] = 1;
$arrArguments["serviceId"] = "SL-5097-0480";
$arrArguments["ipAddress"] = "127.0.0.1";
$arrArguments["token"] = "bd169a4729b49b59d4469322ae017158336583b8";
$arrArguments["paymentProfileId"] = 10;
$arrArguments["websiteLocationId"] = 1;
$arrArguments["statsData"] = [];
$arrArguments["statsData"]["extra1"] = $_POST["username"];
$arrArguments["amount"] = $_POST["x"];
$arrArguments["finishUrl"] = "https://obversemu.com/high/api/paynl.returnpay.php";
$arrArguments["languageId"] = 16135;
$strUrl = $strUrl . http_build_query($arrArguments);
$arrResult = json_decode(@curl_file_get_contents($strUrl));
unset($strUrl);
unset($arrArguments);
header("Status: 302 Found");
header("Location: " . preg_replace("~\\/[A-Z]{2}\$~", "/EN", $arrResult->transaction->paymentURL));

?>