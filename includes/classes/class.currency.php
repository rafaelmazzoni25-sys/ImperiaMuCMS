<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class Currency
{
    public function getAllCurrencies()
    {
        global $dB;
        $return = [];
        $return[1] = lang("currency_platinum", true);
        $return[2] = lang("currency_gold", true);
        $return[3] = lang("currency_silver", true);
        $return[11] = lang("currency_wcoinc", true);
        $return[12] = lang("currency_wcoinp", true);
        $return[13] = lang("currency_gp", true);
        $return[20] = "" . lang("currency_zen", true) . "";
        $return[21] = lang("currency_ruud", true);
        $return[22] = "" . lang("currency_zen", true) . " " . lang("currency_location_webbank", true) . "";
        $return[23] = lang("currency_ruud", true) . " " . lang("currency_location_webbank", true) . "";
        $return[30] = "" . lang("currency_bless", true) . " " . lang("currency_location_webbank", true) . "";
        $return[31] = "" . lang("currency_soul", true) . " " . lang("currency_location_webbank", true) . "";
        $return[32] = "" . lang("currency_life", true) . " " . lang("currency_location_webbank", true) . "";
        $return[33] = "" . lang("currency_chaos", true) . " " . lang("currency_location_webbank", true) . "";
        $return[34] = "" . lang("currency_harmony", true) . " " . lang("currency_location_webbank", true) . "";
        $return[35] = "" . lang("currency_creation", true) . " " . lang("currency_location_webbank", true) . "";
        $return[36] = "" . lang("currency_guardian", true) . " " . lang("currency_location_webbank", true) . "";
        $customItem = $dB->query_fetch("SELECT ident, name FROM IMPERIAMUCMS_WEB_BANK_CUSTOM ORDER BY ident ASC");
        if (is_array($customItem)) {
            foreach ($customItem as $item) {
                $return[$item["ident"]] = $item["name"] . " " . lang("currency_location_webbank", true) . "";
            }
        }
        return $return;
    }
    public function getCurrenciesSelect()
    {
        $options = "";
        $currencies = $this->getAllCurrencies();
        if (is_array($currencies)) {
            foreach ($currencies as $key => $value) {
                $options .= "<option value=\"" . $key . "\">" . $value . "</option>";
            }
        }
    }
    public function getCurrenciesData($username)
    {
        global $dB;
        global $dB2;
        if (!check_value($username)) {
            message("error", lang("error_4", true));
        } else {
            if (!Validator::UsernameLength($username)) {
                message("error", lang("error_5", true));
            } else {
                if (!Validator::AlphaNumeric($username)) {
                    message("error", lang("error_6", true));
                } else {
                    $return = [];
                    if (config("SQL_USE_2_DB", true) && config("MEMB_CREDITS_MEMUONLINE", true)) {
                        $credits = $dB2->query_fetch_single("SELECT platinum, gold, silver FROM MEMB_CREDITS WHERE memb___id = ?", [$username]);
                    } else {
                        $credits = $dB->query_fetch_single("SELECT platinum, gold, silver FROM MEMB_CREDITS WHERE memb___id = ?", [$username]);
                    }
                    if (100 <= config("server_files_season", true)) {
                        $coins = $dB->query_fetch_single("SELECT WCoin, GoblinPoint FROM T_InGameShop_Point WHERE AccountID = ?", [$username]);
                    } else {
                        $coins = $dB->query_fetch_single("SELECT WCoinC, GoblinPoint FROM T_InGameShop_Point WHERE AccountID = ?", [$username]);
                    }
                    $zen = $dB->query_fetch_single("SELECT zen FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$username]);
                    $return[1] = number_format($credits["platinum"]);
                    $return[2] = number_format($credits["gold"]);
                    $return[3] = number_format($credits["silver"]);
                    if (100 <= config("server_files_season", true)) {
                        $return[4] = number_format($coins["WCoin"]);
                    } else {
                        $return[4] = number_format($coins["WCoinC"]);
                    }
                    $return[5] = number_format($coins["GoblinPoint"]);
                    $return[6] = number_format($zen["zen"]);
                    return $return;
                }
            }
        }
    }
    public function getCurrencyData($currencyID)
    {
        global $dB;
        $return = [];
        switch ($currencyID) {
            case 1:
                $return["column"] = "platinum";
                $return["table"] = "MEMB_CREDITS";
                $return["ident"] = "memb___id";
                $return["name"] = lang("currency_platinum", true);
                $dbType = $dB->query_fetch_single("SELECT config_database FROM IMPERIAMUCMS_CREDITS_CONFIG WHERE config_credits_col = 'platinum'");
                $return["db"] = $dbType["config_database"];
                break;
            case 2:
                $return["column"] = "gold";
                $return["table"] = "MEMB_CREDITS";
                $return["ident"] = "memb___id";
                $return["name"] = lang("currency_gold", true);
                $dbType = $dB->query_fetch_single("SELECT config_database FROM IMPERIAMUCMS_CREDITS_CONFIG WHERE config_credits_col = 'gold'");
                $return["db"] = $dbType["config_database"];
                break;
            case 3:
                $return["column"] = "silver";
                $return["table"] = "MEMB_CREDITS";
                $return["ident"] = "memb___id";
                $return["name"] = lang("currency_silver", true);
                $dbType = $dB->query_fetch_single("SELECT config_database FROM IMPERIAMUCMS_CREDITS_CONFIG WHERE config_credits_col = 'silver'");
                $return["db"] = $dbType["config_database"];
                break;
            case 11:
                if (100 <= config("server_files_season", true)) {
                    $return["column"] = "WCoin";
                } else {
                    $return["column"] = "WCoinC";
                }
                $return["table"] = "T_InGameShop_Point";
                $return["ident"] = "AccountID";
                $return["name"] = lang("currency_wcoinc", true);
                $return["db"] = "MuOnline";
                break;
            case 12:
                $return["column"] = "WCoinP";
                $return["table"] = "T_InGameShop_Point";
                $return["ident"] = "AccountID";
                $return["name"] = lang("currency_wcoinp", true);
                $return["db"] = "MuOnline";
                break;
            case 13:
                $return["column"] = "GoblinPoint";
                $return["table"] = "T_InGameShop_Point";
                $return["ident"] = "AccountID";
                $return["name"] = lang("currency_gp", true);
                $return["db"] = "MuOnline";
                break;
            case 20:
                $return["column"] = "Money";
                $return["table"] = "Character";
                $return["ident"] = "AccountID";
                $return["ident2"] = "Name";
                $return["name"] = "" . lang("currency_zen", true) . "";
                $return["db"] = "MuOnline";
                break;
            case 21:
                $return["column"] = "Ruud";
                $return["table"] = "Character";
                $return["ident"] = "AccountID";
                $return["ident2"] = "Name";
                $return["name"] = lang("currency_ruud", true);
                $return["db"] = "MuOnline";
                break;
            case 22:
                $return["column"] = "zen";
                $return["table"] = "IMPERIAMUCMS_WEB_BANK";
                $return["ident"] = "AccountID";
                $return["name"] = "" . lang("currency_zen", true) . "";
                $return["db"] = "MuOnline";
                break;
            case 23:
                $return["column"] = "ruud";
                $return["table"] = "IMPERIAMUCMS_WEB_BANK";
                $return["ident"] = "AccountID";
                $return["name"] = lang("currency_ruud", true);
                $return["db"] = "MuOnline";
                break;
            case 30:
                $return["column"] = "bless";
                $return["table"] = "IMPERIAMUCMS_WEB_BANK";
                $return["ident"] = "AccountID";
                $return["name"] = "" . lang("currency_bless", true) . "";
                $return["db"] = "MuOnline";
                break;
            case 31:
                $return["column"] = "soul";
                $return["table"] = "IMPERIAMUCMS_WEB_BANK";
                $return["ident"] = "AccountID";
                $return["name"] = "" . lang("currency_soul", true) . "";
                $return["db"] = "MuOnline";
                break;
            case 32:
                $return["column"] = "life";
                $return["table"] = "IMPERIAMUCMS_WEB_BANK";
                $return["ident"] = "AccountID";
                $return["name"] = "" . lang("currency_life", true) . "";
                $return["db"] = "MuOnline";
                break;
            case 33:
                $return["column"] = "chaos";
                $return["table"] = "IMPERIAMUCMS_WEB_BANK";
                $return["ident"] = "AccountID";
                $return["name"] = "" . lang("currency_chaos", true) . "";
                $return["db"] = "MuOnline";
                break;
            case 34:
                $return["column"] = "harmony";
                $return["table"] = "IMPERIAMUCMS_WEB_BANK";
                $return["ident"] = "AccountID";
                $return["name"] = "" . lang("currency_harmony", true) . "";
                $return["db"] = "MuOnline";
                break;
            case 35:
                $return["column"] = "creation";
                $return["table"] = "IMPERIAMUCMS_WEB_BANK";
                $return["ident"] = "AccountID";
                $return["name"] = "" . lang("currency_creation", true) . "";
                $return["db"] = "MuOnline";
                break;
            case 36:
                $return["column"] = "guardian";
                $return["table"] = "IMPERIAMUCMS_WEB_BANK";
                $return["ident"] = "AccountID";
                $return["name"] = "" . lang("currency_guardian", true) . "";
                $return["db"] = "MuOnline";
                break;
            default:
                $customItem = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_WEB_BANK_CUSTOM WHERE ident = ?", [$currencyCode]);
                $return["column"] = str_replace(" ", "_", $customItem["name"]);
                $return["table"] = "IMPERIAMUCMS_WEB_BANK";
                $return["ident"] = "AccountID";
                $return["name"] = $customItem["name"];
                $return["db"] = "MuOnline";
                return $return;
        }
    }
    public function getTotalCurrency($currencyID, $AccountID, $Name)
    {
        global $dB;
        global $dB2;
        $currencyData = $this->getCurrencyData($currencyID);
        if ($currencyData["db"] == "MuOnline") {
            $thisDb = $dB;
        } else {
            $thisDb = $dB2;
        }
        if ($currencyData["ident2"] == NULL) {
            $data = $thisDb->query_fetch_single("SELECT " . $currencyData["column"] . " FROM " . $currencyData["table"] . " WHERE " . $currencyData["ident"] . " = ?", [$AccountID]);
        } else {
            $data = $thisDb->query_fetch_single("SELECT " . $currencyData["column"] . " FROM " . $currencyData["table"] . " WHERE " . $currencyData["ident"] . " = ? AND " . $currencyData["ident2"] . " = ?", [$AccountID, $Name]);
        }
        return $data[$currencyData["column"]];
    }
    public function addCurrency($currencyID, $AccountID, $Name, $amount)
    {
        global $dB;
        global $dB2;
        if (!is_numeric($amount) || $amount <= 0) {
            return false;
        }
        $currencyData = $this->getCurrencyData($currencyID);
        if ($currencyData["db"] == "MuOnline") {
            $thisDb = $dB;
        } else {
            $thisDb = $dB2;
        }
        if ($currencyData["ident2"] == NULL) {
            $thisDb->query("UPDATE " . $currencyData["table"] . " SET " . $currencyData["column"] . " = " . $currencyData["column"] . " + ? WHERE " . $currencyData["ident"] . " = ?", [$amount, $AccountID]);
        } else {
            $thisDb->query("UPDATE " . $currencyData["table"] . " SET " . $currencyData["column"] . " = " . $currencyData["column"] . " + ? WHERE " . $currencyData["ident"] . " = ? AND " . $currencyData["ident"] . " = ?", [$amount, $AccountID, $Name]);
        }
    }
    public function deductCurrency($currencyID, $AccountID, $Name, $amount)
    {
        global $dB;
        global $dB2;
        if (!is_numeric($amount) || $amount <= 0) {
            return false;
        }
        $currencyData = $this->getCurrencyData($currencyID);
        if ($currencyData["db"] == "MuOnline") {
            $thisDb = $dB;
        } else {
            $thisDb = $dB2;
        }
        if ($currencyData["ident2"] == NULL) {
            $thisDb->query("UPDATE " . $currencyData["table"] . " SET " . $currencyData["column"] . " = " . $currencyData["column"] . " - ? WHERE " . $currencyData["ident"] . " = ?", [$amount, $AccountID]);
        } else {
            $thisDb->query("UPDATE " . $currencyData["table"] . " SET " . $currencyData["column"] . " = " . $currencyData["column"] . " - ? WHERE " . $currencyData["ident"] . " = ? AND " . $currencyData["ident2"] . " = ?", [$amount, $AccountID, $Name]);
        }
    }
}

?>