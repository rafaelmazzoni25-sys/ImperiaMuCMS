<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

include "../includes/imperiamucms.php";
loadModuleConfigs("donation.paygol");
$transaction_id = $_GET["transaction_id"];
$service_id = $_GET["service_id"];
$shortcode = $_GET["shortcode"];
$keyword = $_GET["keyword"];
$message = $_GET["message"];
$sender = $_GET["sender"];
$operator = $_GET["operator"];
$country = $_GET["country"];
$custom = Decode($_GET["custom"]);
$points = $_GET["points"];
$price = $_GET["price"];
$currency = $_GET["currency"];
if ($credits < 0) {
    $credits = abs($credits);
}
$error = false;
if (!check_value($custom) || !check_value($points)) {
    $error = true;
    $code = 100;
}
if (!$common->userExists($custom)) {
    $error = true;
    $code = 102;
}
if ($common->accountOnline($custom) && mconfig("check_online")) {
    $error = true;
    $code = 103;
}
$checkTID = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_PG_TRANSACTIONS WHERE transaction_id = ?", [$transaction_id]);
if (is_array($checkTID)) {
    $error = true;
    $code = 104;
}
if (!in_array($_SERVER["REMOTE_ADDR"], ["109.70.3.48", "109.70.3.146", "109.70.3.210"])) {
    $error = true;
    $code = 105;
}
$user_id = $common->retrieveUserID($userId);
if ($user_id == NULL || empty($user_id)) {
    $user_id = 0;
}
if (!$error) {
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
                $_GET["subpage"] = "paygol";
                $creditSystem->addCredits($points);
                $add_logs_data = [$transaction_id, date("Y-m-d H:i:s", time()), $service_id, $shortcode, $keyword, $message, $sender, $operator, $country, $custom, $points, $price, $currency];
                mconfig("credit_config");
                switch (mconfig("credit_config")) {
                    case 1:
                        $currencyType = "Platinum Coins";
                        break;
                    case 2:
                        $currencyType = "Gold Coins";
                        break;
                    case 3:
                        $currencyType = "Silver Coins";
                        break;
                    case 4:
                        $currencyType = "WCoins";
                        break;
                    case 5:
                        $currencyType = "Goblin Points";
                        break;
                    case 6:
                        $currencyType = lang("currency_zen", true);
                        break;
                    default:
                        $add_logs = $dB->query("INSERT INTO IMPERIAMUCMS_PG_TRANSACTIONS (transaction_id,date,service_id,shortcode,keyword,message,sender,operator,country,custom,points,price,currency)\r                                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)", $add_logs_data);
                        $logDate = date("Y-m-d H:i:s", time());
                        $common->accountLogs($custom, "donation", "Received " . $points . " " . $currencyType . " for donation with PayGol.", $logDate);
                        $result = true;
                        echo "OK";
                }
                break;
            default:
                throw new Exception("invalid identifier");
        }
    } catch (Exception $ex) {
        $add_error_logs_data = [$transaction_id, date("Y-m-d H:i:s", time()), $service_id, $shortcode, $keyword, $message, $sender, $operator, $country, $custom, $points, $price, $currency, $code];
        $add_error_logs = $dB->query("INSERT INTO IMPERIAMUCMS_PG_ERROR_LOGS (transaction_id,date,service_id,shortcode,keyword,message,sender,operator,country,custom,points,price,currency,error_code)\r                                      VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)", $add_error_logs_data);
        $result = false;
        echo "ERROR";
    }
} else {
    $add_error_logs_data = [$transaction_id, date("Y-m-d H:i:s", time()), $service_id, $shortcode, $keyword, $message, $sender, $operator, $country, $custom, $points, $price, $currency, $code];
    $add_error_logs = $dB->query("INSERT INTO IMPERIAMUCMS_PG_ERROR_LOGS (transaction_id,date,service_id,shortcode,keyword,message,sender,operator,country,custom,points,price,currency,error_code)\r                                  VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)", $add_error_logs_data);
    $result = false;
    echo "ERROR";
}

?>