<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

include "../includes/imperiamucms.php";
loadModuleConfigs("donation.payu");
$server = "www.platnosci.pl";
$server_script = "/paygw/UTF/Payment/get";
define("PAYU_POS_ID", mconfig("pos_id"));
define("PAYU_KEY1", mconfig("first_md5_key"));
define("PAYU_KEY2", mconfig("second_md5_key"));
$rewardName = "";
$rewardType = mconfig("credit_config");
if ($rewardType == "1") {
    $rewardType = lang("currency_platinum", true);
    $return["column"] = "platinum";
    $return["table"] = "MEMB_CREDITS";
    $return["ident"] = "memb___id";
    $rewardName = "Platinum Coins";
} else {
    if ($rewardType == "2") {
        $rewardType = lang("currency_gold", true);
        $return["column"] = "gold";
        $return["table"] = "MEMB_CREDITS";
        $return["ident"] = "memb___id";
        $rewardName = "Gold Coins";
    } else {
        if ($rewardType == "3") {
            $rewardType = lang("currency_silver", true);
            $return["column"] = "silver";
            $return["table"] = "MEMB_CREDITS";
            $return["ident"] = "memb___id";
            $rewardName = "Silver Coins";
        } else {
            if ($rewardType == "4") {
                $rewardType = lang("currency_wcoinc", true);
                if (100 <= config("server_files_season", true)) {
                    $return["column"] = "WCoin";
                } else {
                    $return["column"] = "WCoinC";
                }
                $return["table"] = "T_InGameShop_Point";
                $return["ident"] = "AccountID";
                $rewardName = "WCoinC";
            } else {
                if ($rewardType == "5") {
                    $rewardType = lang("currency_gp", true);
                    $return["column"] = "GoblinPoint";
                    $return["table"] = "T_InGameShop_Point";
                    $return["ident"] = "AccountID";
                    $rewardName = "Goblin Points";
                } else {
                    if ($rewardType == "6") {
                        $rewardType = "" . lang("currency_zen", true) . "";
                        $return["column"] = "zen";
                        $return["table"] = "IMPERIAMUCMS_WEB_BANK";
                        $return["ident"] = "AccountID";
                        $rewardName = "" . lang("currency_zen", true) . "";
                    }
                }
            }
        }
    }
}
if (!isset($_POST["pos_id"]) || !isset($_POST["session_id"]) || !isset($_POST["ts"]) || !isset($_POST["sig"])) {
    exit("ERROR: EMPTY PARAMETERS");
}
if ($_POST["pos_id"] != PAYU_POS_ID) {
    exit("ERROR: INCORRECT POS ID");
}
$sig = md5($_POST["pos_id"] . $_POST["session_id"] . $_POST["ts"] . PAYU_KEY2);
if ($_POST["sig"] != $sig) {
    exit("ERROR: INCORRECT SIGNATURE");
}
$ts = time();
$sig = md5(PAYU_POS_ID . $_POST["session_id"] . $ts . PAYU_KEY1);
$parameters = "pos_id=" . PAYU_POS_ID . "&session_id=" . $_POST["session_id"] . "&ts=" . $ts . "&sig=" . $sig;
$fsocket = false;
$curl = false;
if (0 <= PHP_VERSION && ($fp = @fsockopen("ssl://" . $server, 443, $errno, $errstr, 30))) {
    $fsocket = true;
} else {
    if (function_exists("curl_exec")) {
        $curl = true;
    }
}
if ($fsocket) {
    $header = "POST " . $server_script . " HTTP/1.0" . "\r\n" . "Host: " . $server . "\r\n" . "Content-Type: application/x-www-form-urlencoded" . "\r\n" . "Content-Length: " . strlen($parameters) . "\r\n" . "Connection: close" . "\r\n\r\n";
    @fputs($fp, $header . $parameters);
    $payu_response = "";
    while (!@feof($fp)) {
        $res = @fgets($fp, 1024);
        $payu_response .= $res;
    }
    @fclose($fp);
} else {
    if ($curl) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://" . $server . $server_script);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $payu_response = curl_exec($ch);
        curl_close($ch);
    } else {
        exit("ERROR: No connect method ...\n");
    }
}
$result = false;
if (preg_match("/<trans>.*<pos_id>([0-9]*)<\\/pos_id>.*<session_id>(.*)<\\/session_id>.*<order_id>(.*)<\\/order_id>.*<amount>([0-9]*)<\\/amount>.*<status>([0-9]*)<\\/status>.*<desc>(.*)<\\/desc>.*<ts>([0-9]*)<\\/ts>.*<sig>([a-z0-9]*)<\\/sig>.*<\\/trans>/is", $payu_response, $parts)) {
    $result = get_status($parts);
}
if ($result["code"]) {
    list($pos_id, $session_id, $order_id, $amount, $status, $desc, $ts, $sig) = $parts;
    $payment = $dB->query_fetch_single("SELECT TOP 1 * FROM IMPERIAMUCMS_PAYU_LOGS WHERE id = ?", [$session_id]);
    if ($result["code"] == "99") {
        if ($payment["lastStatus"] != 99 && $payment["lastStatus"] != 2 && 0 < $payment["reward"]) {
            $dB->query("UPDATE IMPERIAMUCMS_PAYU_LOGS SET paymentDate = '" . date("Y-m-d H:i:s", time()) . "', lastStatus = ? WHERE id = ?", [$status, $session_id]);
            if (config("MEMB_CREDITS_MEMUONLINE", true) && ($return["column"] == "platinum" || $return["column"] == "gold" || $return["column"] == "silver")) {
                $update = $dB2->query("UPDATE " . $return["table"] . " SET " . $return["column"] . " = " . $return["column"] . " + ? WHERE " . $return["ident"] . " = ?", [$payment["reward"], $payment["AccountID"]]);
            } else {
                $update = $dB->query("UPDATE " . $return["table"] . " SET " . $return["column"] . " = " . $return["column"] . " + ? WHERE " . $return["ident"] . " = ?", [$payment["reward"], $payment["AccountID"]]);
            }
            $fp = fopen(__ROOT_DIR__ . "__logs/payu_" . date("Y-m-d", time()) . ".log", "ab");
            if ($fp) {
                fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] [Username: " . $payment["AccountID"] . "] [" . $_SERVER["REQUEST_URI"] . "] Added " . $payment["reward"] . " " . $rewardName . ". [Payment data: pos_id: " . $pos_id . " session_id: " . $session_id . " order_id: " . $order_id . " amount: " . $amount . " status: " . $status . " desc: " . $desc . " ts: " . $ts . " sig: " . $sig . "]" . PHP_EOL);
                fclose($fp);
            }
            echo "OK";
            exit;
        }
    } else {
        if ($result["code"] == "2") {
            $dB->query("UPDATE IMPERIAMUCMS_PAYU_LOGS SET paymentDate = " . date("Y-m-d H:i:s", time()) . ", lastStatus = ? WHERE id = ?", [$status, $session_id]);
        } else {
            $dB->query("UPDATE IMPERIAMUCMS_PAYU_LOGS SET paymentDate = " . date("Y-m-d H:i:s", time()) . ", lastStatus = ? WHERE id = ?", [$status, $session_id]);
        }
    }
    echo "OK";
    exit;
}
echo "ERROR: Data error ...\n";
echo "code=" . $result["code"] . " message=" . $result["message"] . "\n";
echo $payu_response;
function get_status($parts)
{
    if ($parts[1] != PAYU_POS_ID) {
        return ["code" => false, "message" => "incorrect POS number"];
    }
    $sig = md5($parts[1] . $parts[2] . $parts[3] . $parts[5] . $parts[4] . $parts[6] . $parts[7] . PAYU_KEY2);
    if ($parts[8] != $sig) {
        return ["code" => false, "message" => "incorrect signature"];
    }
    switch ($parts[5]) {
        case 1:
            return ["code" => $parts[5], "message" => "new"];
            break;
        case 2:
            return ["code" => $parts[5], "message" => "cancelled"];
            break;
        case 3:
            return ["code" => $parts[5], "message" => "rejected"];
            break;
        case 4:
            return ["code" => $parts[5], "message" => "started"];
            break;
        case 5:
            return ["code" => $parts[5], "message" => "awaiting receipt"];
            break;
        case 6:
            return ["code" => $parts[5], "message" => "no authorization"];
            break;
        case 7:
            return ["code" => $parts[5], "message" => "payment rejected"];
            break;
        case 99:
            return ["code" => $parts[5], "message" => "payment received - ended"];
            break;
        case 888:
            return ["code" => $parts[5], "message" => "incorrect status"];
            break;
        default:
            return ["code" => false, "message" => "no status"];
    }
}

?>