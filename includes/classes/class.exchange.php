<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class Exchange
{
    public function getExchanges()
    {
        global $dB;
        $result = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_EXCHANGE WHERE active = 1 ORDER BY identFrom");
        if (is_array($result)) {
            return $result;
        }
        return NULL;
    }
    public function getCurrencyName($ident)
    {
        global $dB;
        switch ($ident) {
            case 0:
                return lang("exchange_txt_7", true);
                break;
            case 1:
                return lang("currency_platinum", true);
                break;
            case 2:
                return lang("currency_gold", true);
                break;
            case 3:
                return lang("currency_silver", true);
                break;
            case 4:
                return lang("currency_wcoinc", true);
                break;
            case -4:
                return lang("currency_wcoinp", true);
                break;
            case 5:
                return lang("currency_gp", true);
                break;
            case 6:
                return "" . lang("currency_zen", true) . "";
                break;
            case -1:
                return lang("currency_ruud", true);
                break;
            case 7:
                return "" . lang("currency_bless", true) . "";
                break;
            case 8:
                return "" . lang("currency_soul", true) . "";
                break;
            case 9:
                return "" . lang("currency_life", true) . "";
                break;
            case 10:
                return "" . lang("currency_chaos", true) . "";
                break;
            case 11:
                return "" . lang("currency_harmony", true) . "";
                break;
            case 12:
                return "" . lang("currency_creation", true) . "";
                break;
            case 13:
                return "" . lang("currency_guardian", true) . "";
                break;
            default:
                $query = $dB->query_fetch_single("SELECT name FROM IMPERIAMUCMS_WEB_BANK_CUSTOM WHERE ident = ?", [$ident]);
                return $query["name"];
        }
    }
    public function getCurrencyNameWithAmount($username, $ident)
    {
        global $dB;
        global $dB2;
        if (config("MEMB_CREDITS_MEMUONLINE", true)) {
            $checkCredits = $dB2->query_fetch_single("SELECT * FROM MEMB_CREDITS WHERE memb___id = ?", [$username]);
            if ($checkCredits["memb___id"] == NULL) {
                $insert = $dB2->query("INSERT INTO MEMB_CREDITS (memb___id, platinum, platinum_used, gold, gold_used, silver, silver_used) VALUES (?, ?, ?, ?, ?, ?, ?)", [$username, 0, 0, 0, 0, 0, 0]);
            }
        } else {
            $checkCredits = $dB->query_fetch_single("SELECT * FROM MEMB_CREDITS WHERE memb___id = ?", [$username]);
            if ($checkCredits["memb___id"] == NULL) {
                $insert = $dB->query("INSERT INTO MEMB_CREDITS (memb___id, platinum, platinum_used, gold, gold_used, silver, silver_used) VALUES (?, ?, ?, ?, ?, ?, ?)", [$username, 0, 0, 0, 0, 0, 0]);
            }
        }
        $checkXShop = $dB->query_fetch_single("SELECT * FROM T_InGameShop_Point WHERE AccountID = ?", [$username]);
        if ($checkXShop["AccountID"] == NULL) {
            if (100 <= config("server_files_season", true)) {
                $insert = $dB->query("INSERT INTO T_InGameShop_Point (AccountID, WCoin, GoblinPoint) VALUES (?, ?, ?)", [$username, 0, 0]);
            } else {
                $insert = $dB->query("INSERT INTO T_InGameShop_Point (AccountID, WCoinC, WCoinP, GoblinPoint) VALUES (?, ?, ?, ?)", [$username, 0, 0, 0]);
            }
        }
        $checkBank = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$username]);
        if ($checkBank["AccountID"] == NULL) {
            $insert = $dB->query("INSERT INTO IMPERIAMUCMS_WEB_BANK (AccountID, zen, bless, soul, life, chaos, harmony, creation, guardian) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)", [$username, 0, 0, 0, 0, 0, 0, 0, 0]);
        }
        switch ($ident) {
            case -1:
                $amount = $dB->query_fetch_single("SELECT SUM(Ruud) as Ruud FROM Character WHERE AccountID = ?", [$username]);
                return lang("currency_ruud", true) . " (" . sprintf(lang("exchange_txt_8", true), number_format($amount["Ruud"])) . ")";
                break;
            case 0:
                if (config("SQL_USE_2_DB", true)) {
                    $amount = $dB2->query_fetch_single("SELECT OnlineTime FROM MEMB_STAT WHERE memb___id = ?", [$username]);
                } else {
                    $amount = $dB->query_fetch_single("SELECT OnlineTime FROM MEMB_STAT WHERE memb___id = ?", [$username]);
                }
                return lang("exchange_txt_7", true) . " (" . sprintf(lang("exchange_txt_8", true), number_format(floor($amount["OnlineTime"] / 60))) . ")";
                break;
            case 1:
                if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                    $amount = $dB2->query_fetch_single("SELECT platinum FROM MEMB_CREDITS WHERE memb___id = ?", [$username]);
                } else {
                    $amount = $dB->query_fetch_single("SELECT platinum FROM MEMB_CREDITS WHERE memb___id = ?", [$username]);
                }
                return lang("currency_platinum", true) . " (" . sprintf(lang("exchange_txt_8", true), number_format($amount["platinum"])) . ")";
                break;
            case 2:
                if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                    $amount = $dB2->query_fetch_single("SELECT gold FROM MEMB_CREDITS WHERE memb___id = ?", [$username]);
                } else {
                    $amount = $dB->query_fetch_single("SELECT gold FROM MEMB_CREDITS WHERE memb___id = ?", [$username]);
                }
                return lang("currency_gold", true) . " (" . sprintf(lang("exchange_txt_8", true), number_format($amount["gold"])) . ")";
                break;
            case 3:
                if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                    $amount = $dB2->query_fetch_single("SELECT silver FROM MEMB_CREDITS WHERE memb___id = ?", [$username]);
                } else {
                    $amount = $dB->query_fetch_single("SELECT silver FROM MEMB_CREDITS WHERE memb___id = ?", [$username]);
                }
                return lang("currency_silver", true) . " (" . sprintf(lang("exchange_txt_8", true), number_format($amount["silver"])) . ")";
                break;
            case 4:
                if (100 <= config("server_files_season", true)) {
                    $amount = $dB->query_fetch_single("SELECT WCoin FROM T_InGameShop_Point WHERE AccountID = ?", [$username]);
                    return lang("currency_wcoinc", true) . " (" . sprintf(lang("exchange_txt_8", true), number_format($amount["WCoin"])) . ")";
                }
                $amount = $dB->query_fetch_single("SELECT WCoinC FROM T_InGameShop_Point WHERE AccountID = ?", [$username]);
                return lang("currency_wcoinc", true) . " (" . sprintf(lang("exchange_txt_8", true), number_format($amount["WCoinC"])) . ")";
                break;
            case -4:
                $amount = $dB->query_fetch_single("SELECT WCoinP FROM T_InGameShop_Point WHERE AccountID = ?", [$username]);
                return lang("currency_wcoinp", true) . " (" . sprintf(lang("exchange_txt_8", true), number_format($amount["WCoinP"])) . ")";
                break;
            case 5:
                $amount = $dB->query_fetch_single("SELECT GoblinPoint FROM T_InGameShop_Point WHERE AccountID = ?", [$username]);
                return lang("currency_gp", true) . " (" . sprintf(lang("exchange_txt_8", true), number_format($amount["GoblinPoint"])) . ")";
                break;
            case 6:
                $amount = $dB->query_fetch_single("SELECT zen FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$username]);
                return "" . lang("currency_zen", true) . " (" . sprintf(lang("exchange_txt_8", true), number_format($amount["zen"])) . ")";
                break;
            case 7:
                $amount = $dB->query_fetch_single("SELECT bless FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$username]);
                return "" . lang("currency_bless", true) . " (" . sprintf(lang("exchange_txt_8", true), number_format($amount["bless"])) . ")";
                break;
            case 8:
                $amount = $dB->query_fetch_single("SELECT soul FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$username]);
                return "" . lang("currency_soul", true) . " (" . sprintf(lang("exchange_txt_8", true), number_format($amount["soul"])) . ")";
                break;
            case 9:
                $amount = $dB->query_fetch_single("SELECT life FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$username]);
                return "" . lang("currency_life", true) . " (" . sprintf(lang("exchange_txt_8", true), number_format($amount["life"])) . ")";
                break;
            case 10:
                $amount = $dB->query_fetch_single("SELECT chaos FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$username]);
                return "" . lang("currency_chaos", true) . " (" . sprintf(lang("exchange_txt_8", true), number_format($amount["chaos"])) . ")";
                break;
            case 11:
                $amount = $dB->query_fetch_single("SELECT harmony FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$username]);
                return "" . lang("currency_harmony", true) . " (" . sprintf(lang("exchange_txt_8", true), number_format($amount["harmony"])) . ")";
                break;
            case 12:
                $amount = $dB->query_fetch_single("SELECT creation FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$username]);
                return "" . lang("currency_creation", true) . " (" . sprintf(lang("exchange_txt_8", true), number_format($amount["creation"])) . ")";
                break;
            case 13:
                $amount = $dB->query_fetch_single("SELECT guardian FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$username]);
                return "" . lang("currency_guardian", true) . " (" . sprintf(lang("exchange_txt_8", true), number_format($amount["guardian"])) . ")";
                break;
            default:
                $query = $dB->query_fetch_single("SELECT name FROM IMPERIAMUCMS_WEB_BANK_CUSTOM WHERE ident = ?", [$ident]);
                $dbName = str_replace(" ", "_", $query["name"]);
                $amount = $dB->query_fetch_single("SELECT " . $dbName . " FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$username]);
                return $query["name"] . " (" . sprintf(lang("exchange_txt_8", true), number_format($amount[$dbName])) . ")";
        }
    }
    public function exchangeCurrency($username, $identFrom, $identTo, $amount, $char = NULL)
    {
        global $dB;
        global $dB2;
        global $common;
        $identFrom = xss_clean($identFrom);
        $identTo = xss_clean($identTo);
        $amount = xss_clean($amount);
        if ($char != NULL) {
            $char = xss_clean(Decode($char));
        }
        if (check_value($username) && check_value($identFrom) && check_value($identTo) && check_value($amount)) {
            if (!Validator::UsernameLength($username)) {
                message("error", lang("error_23", true));
                return NULL;
            }
            if (!Validator::AlphaNumeric($username)) {
                message("error", lang("error_23", true));
                return NULL;
            }
            $maxIdent = $dB->query_fetch_single("SELECT TOP 1 ident FROM IMPERIAMUCMS_WEB_BANK_CUSTOM ORDER BY ident DESC");
            if ($maxIdent["ident"] == NULL) {
                $maxIdent = 13;
            } else {
                $maxIdent = $maxIdent["ident"];
            }
            if (!Validator::UnsignedNumber($identFrom) && $identFrom != "-4" && $identFrom != "-1") {
                message("error", lang("error_23", true));
                return NULL;
            }
            if (!Validator::UnsignedNumber($identTo) && $identTo != "-4" && $identTo != "-1") {
                message("error", lang("error_23", true));
                return NULL;
            }
            if (!Validator::UnsignedNumber($amount)) {
                message("error", lang("error_23", true));
                return NULL;
            }
            if ($maxIdent < $identFrom) {
                message("error", lang("error_23", true));
                return NULL;
            }
            if ($maxIdent < $identTo) {
                message("error", lang("error_23", true));
                return NULL;
            }
            $checkExchange = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_EXCHANGE WHERE identFrom = ? AND identTo = ? AND active = ?", [$identFrom, $identTo, 1]);
            if ($checkExchange["ratio"] == NULL) {
                message("error", lang("error_23", true));
                return NULL;
            }
            if ($amount % $checkExchange["fromAmount"] != 0) {
                message("error", sprintf(lang("exchange_txt_14", true), $checkExchange["fromAmount"]));
                return NULL;
            }
            if ($amount < $checkExchange["fromAmount"]) {
                message("error", sprintf(lang("exchange_txt_15", true), $checkExchange["fromAmount"], $this->getCurrencyName($identFrom)));
                return NULL;
            }
            $totalCurrency = 0;
            switch ($identFrom) {
                case -1:
                    if ($char == NULL) {
                        message("error", lang("exchange_txt_24", true));
                        return NULL;
                    }
                    $totalCurrency = $dB->query_fetch_single("SELECT Ruud FROM Character WHERE AccountID = ? AND Name = ?", [$username, $char]);
                    $totalCurrency = $totalCurrency["Ruud"];
                    break;
                case 0:
                    if (config("SQL_USE_2_DB", true)) {
                        $totalCurrency = $dB2->query_fetch_single("SELECT OnlineTime FROM MEMB_STAT WHERE memb___id = ?", [$username]);
                    } else {
                        $totalCurrency = $dB->query_fetch_single("SELECT OnlineTime FROM MEMB_STAT WHERE memb___id = ?", [$username]);
                    }
                    $totalCurrency = floor($totalCurrency["OnlineTime"] / 60);
                    break;
                case 1:
                    if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                        $totalCurrency = $dB2->query_fetch_single("SELECT platinum FROM MEMB_CREDITS WHERE memb___id = ?", [$username]);
                    } else {
                        $totalCurrency = $dB->query_fetch_single("SELECT platinum FROM MEMB_CREDITS WHERE memb___id = ?", [$username]);
                    }
                    $totalCurrency = $totalCurrency["platinum"];
                    break;
                case 2:
                    if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                        $totalCurrency = $dB2->query_fetch_single("SELECT gold FROM MEMB_CREDITS WHERE memb___id = ?", [$username]);
                    } else {
                        $totalCurrency = $dB->query_fetch_single("SELECT gold FROM MEMB_CREDITS WHERE memb___id = ?", [$username]);
                    }
                    $totalCurrency = $totalCurrency["gold"];
                    break;
                case 3:
                    if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                        $totalCurrency = $dB2->query_fetch_single("SELECT silver FROM MEMB_CREDITS WHERE memb___id = ?", [$username]);
                    } else {
                        $totalCurrency = $dB->query_fetch_single("SELECT silver FROM MEMB_CREDITS WHERE memb___id = ?", [$username]);
                    }
                    $totalCurrency = $totalCurrency["silver"];
                    break;
                case 4:
                    if (100 <= config("server_files_season", true)) {
                        $totalCurrency = $dB->query_fetch_single("SELECT WCoin FROM T_InGameShop_Point WHERE AccountID = ?", [$username]);
                        $totalCurrency = $totalCurrency["WCoin"];
                    } else {
                        $totalCurrency = $dB->query_fetch_single("SELECT WCoinC FROM T_InGameShop_Point WHERE AccountID = ?", [$username]);
                        $totalCurrency = $totalCurrency["WCoinC"];
                    }
                    break;
                case -4:
                    $totalCurrency = $dB->query_fetch_single("SELECT WCoinP FROM T_InGameShop_Point WHERE AccountID = ?", [$username]);
                    $totalCurrency = $totalCurrency["WCoinP"];
                    break;
                case 5:
                    $totalCurrency = $dB->query_fetch_single("SELECT GoblinPoint FROM T_InGameShop_Point WHERE AccountID = ?", [$username]);
                    $totalCurrency = $totalCurrency["GoblinPoint"];
                    break;
                case 6:
                    $totalCurrency = $dB->query_fetch_single("SELECT zen FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$username]);
                    $totalCurrency = $totalCurrency["zen"];
                    break;
                case 7:
                    $totalCurrency = $dB->query_fetch_single("SELECT bless FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$username]);
                    $totalCurrency = $totalCurrency["bless"];
                    break;
                case 8:
                    $totalCurrency = $dB->query_fetch_single("SELECT soul FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$username]);
                    $totalCurrency = $totalCurrency["soul"];
                    break;
                case 9:
                    $totalCurrency = $dB->query_fetch_single("SELECT life FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$username]);
                    $totalCurrency = $totalCurrency["life"];
                    break;
                case 10:
                    $totalCurrency = $dB->query_fetch_single("SELECT chaos FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$username]);
                    $totalCurrency = $totalCurrency["chaos"];
                    break;
                case 11:
                    $totalCurrency = $dB->query_fetch_single("SELECT harmony FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$username]);
                    $totalCurrency = $totalCurrency["harmony"];
                    break;
                case 12:
                    $totalCurrency = $dB->query_fetch_single("SELECT creation FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$username]);
                    $totalCurrency = $totalCurrency["creation"];
                    break;
                case 13:
                    $totalCurrency = $dB->query_fetch_single("SELECT guardian FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$username]);
                    $totalCurrency = $totalCurrency["guardian"];
                    break;
                default:
                    $query = $dB->query_fetch_single("SELECT name FROM IMPERIAMUCMS_WEB_BANK_CUSTOM WHERE ident = ?", [$identFrom]);
                    $dbName = str_replace(" ", "_", $query["name"]);
                    $totalCurrency = $dB->query_fetch_single("SELECT " . $dbName . " FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$username]);
                    $totalCurrency = $totalCurrency[$dbName];
                    if ($totalCurrency < $amount) {
                        message("error", sprintf(lang("exchange_txt_10", true), $this->getCurrencyName($identFrom)));
                        return NULL;
                    }
                    $newCurrency = floor($checkExchange["ratio"] * $amount / $checkExchange["fromAmount"]);
                    switch ($identFrom) {
                        case -1:
                            if ($char == NULL) {
                                message("error", lang("exchange_txt_24", true));
                                return NULL;
                            }
                            $update = $dB->query("UPDATE Character SET Ruud = Ruud - ? WHERE AccountID = ? AND Name = ?", [$amount, $username, $char]);
                            break;
                        case 0:
                            if (config("SQL_USE_2_DB", true)) {
                                $update = $dB2->query("UPDATE MEMB_STAT SET OnlineTime = OnlineTime - ? WHERE memb___id = ?", [floor($amount * 60), $username]);
                            } else {
                                $update = $dB->query("UPDATE MEMB_STAT SET OnlineTime = OnlineTime - ? WHERE memb___id = ?", [floor($amount * 60), $username]);
                            }
                            break;
                        case 1:
                            if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                $update = $dB2->query("UPDATE MEMB_CREDITS SET platinum = platinum - ?, platinum_used = platinum_used + ? WHERE memb___id = ?", [$amount, $amount, $username]);
                            } else {
                                $update = $dB->query("UPDATE MEMB_CREDITS SET platinum = platinum - ?, platinum_used = platinum_used + ? WHERE memb___id = ?", [$amount, $amount, $username]);
                            }
                            break;
                        case 2:
                            if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                $update = $dB2->query("UPDATE MEMB_CREDITS SET gold = gold - ?, gold_used = gold_used + ? WHERE memb___id = ?", [$amount, $amount, $username]);
                            } else {
                                $update = $dB->query("UPDATE MEMB_CREDITS SET gold = gold - ?, gold_used = gold_used + ? WHERE memb___id = ?", [$amount, $amount, $username]);
                            }
                            break;
                        case 3:
                            if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                $update = $dB2->query("UPDATE MEMB_CREDITS SET silver = silver - ?, silver_used = silver_used + ? WHERE memb___id = ?", [$amount, $amount, $username]);
                            } else {
                                $update = $dB->query("UPDATE MEMB_CREDITS SET silver = silver - ?, silver_used = silver_used + ? WHERE memb___id = ?", [$amount, $amount, $username]);
                            }
                            break;
                        case 4:
                            if (100 <= config("server_files_season", true)) {
                                $update = $dB->query("UPDATE T_InGameShop_Point SET WCoin = WCoin - ? WHERE AccountID = ?", [$amount, $username]);
                            } else {
                                $update = $dB->query("UPDATE T_InGameShop_Point SET WCoinC = WCoinC - ? WHERE AccountID = ?", [$amount, $username]);
                            }
                            break;
                        case -4:
                            $update = $dB->query("UPDATE T_InGameShop_Point SET WCoinP = WCoinP - ? WHERE AccountID = ?", [$amount, $username]);
                            break;
                        case 5:
                            $update = $dB->query("UPDATE T_InGameShop_Point SET GoblinPoint = GoblinPoint - ? WHERE AccountID = ?", [$amount, $username]);
                            break;
                        case 6:
                            $update = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET zen = zen - ? WHERE AccountID = ?", [$amount, $username]);
                            break;
                        case 7:
                            $update = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET bless = bless - ? WHERE AccountID = ?", [$amount, $username]);
                            break;
                        case 8:
                            $update = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET soul = soul - ? WHERE AccountID = ?", [$amount, $username]);
                            break;
                        case 9:
                            $update = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET life = life - ? WHERE AccountID = ?", [$amount, $username]);
                            break;
                        case 10:
                            $update = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET chaos = chaos - ? WHERE AccountID = ?", [$amount, $username]);
                            break;
                        case 11:
                            $update = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET harmony = harmony - ? WHERE AccountID = ?", [$amount, $username]);
                            break;
                        case 12:
                            $update = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET creation = creation - ? WHERE AccountID = ?", [$amount, $username]);
                            break;
                        case 13:
                            $update = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET guardian = guardian - ? WHERE AccountID = ?", [$amount, $username]);
                            break;
                        default:
                            $query = $dB->query_fetch_single("SELECT name FROM IMPERIAMUCMS_WEB_BANK_CUSTOM WHERE ident = ?", [$identFrom]);
                            $dbName = str_replace(" ", "_", $query["name"]);
                            $update = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET " . $dbName . " = " . $dbName . " - ? WHERE AccountID = ?", [$amount, $username]);
                            switch ($identTo) {
                                case -1:
                                    if ($char == NULL) {
                                        message("error", lang("exchange_txt_24", true));
                                        return NULL;
                                    }
                                    $update = $dB->query("UPDATE Character SET Ruud = Ruud + ? WHERE AccountID = ? AND Name = ?", [$newCurrency, $username, $char]);
                                    break;
                                case 0:
                                    $newCurrency = floor($newCurrency * 60);
                                    if (config("SQL_USE_2_DB", true)) {
                                        $update = $dB2->query("UPDATE MEMB_STAT SET OnlineTime = OnlineTime + ? WHERE memb___id = ?", [$newCurrency, $username]);
                                    } else {
                                        $update = $dB->query("UPDATE MEMB_STAT SET OnlineTime = OnlineTime + ? WHERE memb___id = ?", [$newCurrency, $username]);
                                    }
                                    break;
                                case 1:
                                    if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                        $update = $dB2->query("UPDATE MEMB_CREDITS SET platinum = platinum + ? WHERE memb___id = ?", [$newCurrency, $username]);
                                    } else {
                                        $update = $dB->query("UPDATE MEMB_CREDITS SET platinum = platinum + ? WHERE memb___id = ?", [$newCurrency, $username]);
                                    }
                                    break;
                                case 2:
                                    if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                        $update = $dB2->query("UPDATE MEMB_CREDITS SET gold = gold + ? WHERE memb___id = ?", [$newCurrency, $username]);
                                    } else {
                                        $update = $dB->query("UPDATE MEMB_CREDITS SET gold = gold + ? WHERE memb___id = ?", [$newCurrency, $username]);
                                    }
                                    break;
                                case 3:
                                    if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                        $update = $dB2->query("UPDATE MEMB_CREDITS SET silver = silver + ? WHERE memb___id = ?", [$newCurrency, $username]);
                                    } else {
                                        $update = $dB->query("UPDATE MEMB_CREDITS SET silver = silver + ? WHERE memb___id = ?", [$newCurrency, $username]);
                                    }
                                    break;
                                case 4:
                                    if (100 <= config("server_files_season", true)) {
                                        $update = $dB->query("UPDATE T_InGameShop_Point SET WCoin = WCoin + ? WHERE AccountID = ?", [$newCurrency, $username]);
                                    } else {
                                        $update = $dB->query("UPDATE T_InGameShop_Point SET WCoinC = WCoinC + ? WHERE AccountID = ?", [$newCurrency, $username]);
                                    }
                                    break;
                                case -4:
                                    $update = $dB->query("UPDATE T_InGameShop_Point SET WCoinP = WCoinP + ? WHERE AccountID = ?", [$newCurrency, $username]);
                                    break;
                                case 5:
                                    $update = $dB->query("UPDATE T_InGameShop_Point SET GoblinPoint = GoblinPoint + ? WHERE AccountID = ?", [$newCurrency, $username]);
                                    break;
                                case 6:
                                    $update = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET zen = zen + ? WHERE AccountID = ?", [$newCurrency, $username]);
                                    break;
                                case 7:
                                    $update = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET bless = bless + ? WHERE AccountID = ?", [$newCurrency, $username]);
                                    break;
                                case 8:
                                    $update = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET soul = soul + ? WHERE AccountID = ?", [$newCurrency, $username]);
                                    break;
                                case 9:
                                    $update = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET life = life + ? WHERE AccountID = ?", [$newCurrency, $username]);
                                    break;
                                case 10:
                                    $update = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET chaos = chaos + ? WHERE AccountID = ?", [$newCurrency, $username]);
                                    break;
                                case 11:
                                    $update = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET harmony = harmony + ? WHERE AccountID = ?", [$newCurrency, $username]);
                                    break;
                                case 12:
                                    $update = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET creation = creation + ? WHERE AccountID = ?", [$newCurrency, $username]);
                                    break;
                                case 13:
                                    $update = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET guardian = guardian + ? WHERE AccountID = ?", [$newCurrency, $username]);
                                    break;
                                default:
                                    $query = $dB->query_fetch_single("SELECT name FROM IMPERIAMUCMS_WEB_BANK_CUSTOM WHERE ident = ?", [$identFrom]);
                                    $dbName = str_replace(" ", "_", $query["name"]);
                                    $update = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET " . $dbName . " = " . $dbName . " + ? WHERE AccountID = ?", [$newCurrency, $username]);
                                    message("success", sprintf(lang("exchange_txt_11", true), number_format($amount), $this->getCurrencyName($identFrom), number_format($newCurrency), $this->getCurrencyName($identTo)));
                                    $insert = $dB->query("INSERT INTO IMPERIAMUCMS_EXCHANGE_LOGS (AccountID, exchange_amount, exchange_type, reward_amount, reward_type, date) VALUES (?, ?, ?, ?, ?, ?)", [$username, $amount, $identFrom, $newCurrency, $identTo, date("Y-m-d H:i:s", time())]);
                                    $logDate = date("Y-m-d H:i:s", time());
                                    $common->accountLogs($username, "exchange", sprintf(lang("exchange_txt_12", true), number_format($amount), $this->getCurrencyName($identFrom), number_format(floor($checkExchange["ratio"] * $amount / $checkExchange["fromAmount"])), $this->getCurrencyName($identTo)), $logDate);
                            }
                    }
            }
        } else {
            message("error", lang("error_23", true));
        }
    }
    public function addExchange($identFrom, $identTo, $fromAmount, $ratio)
    {
        global $dB;
        if (check_value($identFrom) && check_value($identTo) && check_value($fromAmount) && check_value($ratio)) {
            if ($identFrom == $identTo) {
                message("error", "Please select another exchange currency, you cannot use same From and To.");
                return NULL;
            }
            if ($fromAmount <= 0) {
                message("error", "From amount value must be greater than 0.");
                return NULL;
            }
            $checkExchange = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_EXCHANGE WHERE identFrom = ? AND identTo = ?", [$identFrom, $identTo]);
            if ($checkExchange["ratio"] == NULL) {
                if (0 < $ratio) {
                    $insert = $dB->query("INSERT INTO IMPERIAMUCMS_EXCHANGE (identFrom, identTo, fromAmount, ratio, active) VALUES (?, ?, ?, ?, ?)", [$identFrom, $identTo, $fromAmount, $ratio, 1]);
                    if ($insert) {
                        message("success", "New exchange was successfully added.");
                    } else {
                        message("error", lang("error_23"));
                    }
                } else {
                    message("error", "Ratio must be greater than 0.");
                    return NULL;
                }
            } else {
                message("error", "This type of exchange already exists.");
                return NULL;
            }
        } else {
            message("error", lang("error_23", true));
        }
    }
    public function editExchange($id, $identFrom, $identTo, $fromAmount, $ratio)
    {
        global $dB;
        if (check_value($id) && check_value($identFrom) && check_value($identTo) && check_value($fromAmount) && check_value($ratio)) {
            if ($identFrom == $identTo) {
                message("error", "Please select another exchange currency, you cannot use same From and To.");
                return NULL;
            }
            if ($fromAmount <= 0) {
                message("error", "From amount value must be greater than 0.");
                return NULL;
            }
            $checkExchange = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_EXCHANGE WHERE id = ?", [$id]);
            if ($checkExchange["ratio"] == NULL) {
                message("error", "This type of exchange does not exist.");
                return NULL;
            }
            if (0 < $ratio) {
                $update = $dB->query("UPDATE IMPERIAMUCMS_EXCHANGE SET identFrom = ?, identTo = ?, fromAmount = ?, ratio = ?, active = ? WHERE id = ?", [$identFrom, $identTo, $fromAmount, $ratio, 1, $id]);
                if ($update) {
                    message("success", "Exchange #" . $id . " was successfully edited.");
                } else {
                    message("error", lang("error_23"));
                }
            } else {
                message("error", "Ratio must be greater than 0.");
                return NULL;
            }
        } else {
            message("error", lang("error_23", true));
        }
    }
    public function deleteExchange($id)
    {
        global $dB;
        if (check_value($id)) {
            $checkExchange = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_EXCHANGE WHERE id = ?", [$id]);
            if ($checkExchange["ratio"] == NULL) {
                message("error", "This type of exchange does not exist.");
                return NULL;
            }
            $delete = $dB->query("DELETE FROM IMPERIAMUCMS_EXCHANGE WHERE id = ?", [$id]);
            if ($delete) {
                message("success", "Exchange #" . $id . " was successfully deleted.");
            } else {
                message("error", lang("error_23"));
            }
        } else {
            message("error", lang("error_23", true));
        }
    }
    public function switchStatusExchange($id)
    {
        global $dB;
        if (check_value($id)) {
            $checkExchange = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_EXCHANGE WHERE id = ?", [$id]);
            if ($checkExchange["ratio"] == NULL) {
                message("error", "This type of exchange does not exist.");
                return NULL;
            }
            if ($checkExchange["active"] == "1") {
                $update = $dB->query("UPDATE IMPERIAMUCMS_EXCHANGE SET active = ? WHERE id = ?", [0, $id]);
                if ($update) {
                    message("success", "Exchange #" . $id . " was successfully disabled.");
                } else {
                    message("error", lang("error_23"));
                }
            } else {
                $update = $dB->query("UPDATE IMPERIAMUCMS_EXCHANGE SET active = ? WHERE id = ?", [1, $id]);
                if ($update) {
                    message("success", "Exchange #" . $id . " was successfully enabled.");
                } else {
                    message("error", lang("error_23"));
                }
            }
        } else {
            message("error", lang("error_23", true));
        }
    }
    public function transferCoins($sender, $receiver, $amount, $type, $message)
    {
        global $dB;
        global $dB2;
        global $common;
        if (!check_value($sender)) {
            message("error", lang("error_23", true));
        } else {
            if (!check_value($receiver)) {
                message("error", lang("error_23", true));
            } else {
                if (!check_value($amount)) {
                    message("error", lang("error_23", true));
                } else {
                    if (!check_value($type)) {
                        message("error", lang("error_23", true));
                    } else {
                        $type = Decode($type);
                        if (!Validator::UsernameLength($sender)) {
                            message("error", lang("error_5", true));
                        } else {
                            if (!Validator::AlphaNumeric($sender)) {
                                message("error", lang("error_6", true));
                            } else {
                                if (!$common->userExists($receiver)) {
                                    message("error", lang("exchange_txt_17", true));
                                } else {
                                    if (!is_numeric($amount)) {
                                        message("error", lang("exchange_txt_18", true));
                                    } else {
                                        if ($amount <= 0) {
                                            message("error", lang("exchange_txt_20", true));
                                        } else {
                                            if ($common->accountOnline($sender) || $common->accountOnline($receiver)) {
                                                message("error", lang("exchange_txt_19", true));
                                            } else {
                                                if ($type == "platinum") {
                                                    $currencyName = lang("currency_platinum", true);
                                                    $amountType = 1;
                                                } else {
                                                    if ($type == "gold") {
                                                        $currencyName = lang("currency_gold", true);
                                                        $amountType = 2;
                                                    } else {
                                                        if ($type == "silver") {
                                                            $currencyName = lang("currency_silver", true);
                                                            $amountType = 3;
                                                        } else {
                                                            if ($type == "WCoinC") {
                                                                $currencyName = lang("currency_wcoinc", true);
                                                                $amountType = 4;
                                                            } else {
                                                                if ($type == "WCoinP") {
                                                                    $currencyName = lang("currency_wcoinp", true);
                                                                    $amountType = 5;
                                                                } else {
                                                                    if ($type == "GoblinPoint") {
                                                                        $currencyName = lang("currency_gp", true);
                                                                    } else {
                                                                        if ($type == "zen") {
                                                                            $currencyName = "" . lang("currency_zen", true) . "";
                                                                            $amountType = 6;
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                                if (100 <= config("server_files_season", true) && $type == "WCoinC") {
                                                    $type = "WCoin";
                                                }
                                                $total = $amount + mconfig("tax");
                                                if ($type == "platinum" || $type == "gold" || $type == "silver") {
                                                    if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                                        $coins = $dB2->query_fetch_single("SELECT * FROM MEMB_CREDITS WHERE memb___id = ?", [$sender]);
                                                    } else {
                                                        $coins = $dB->query_fetch_single("SELECT * FROM MEMB_CREDITS WHERE memb___id = ?", [$sender]);
                                                    }
                                                } else {
                                                    if ($type == "WCoin" || $type == "WCoinC" || $type == "WCoinP" || $type == "GoblinPoint") {
                                                        $coins = $dB->query_fetch_single("SELECT * FROM T_InGameShop_Point WHERE AccountID = ?", [$sender]);
                                                    } else {
                                                        if ($type == "zen") {
                                                            $coins = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$sender]);
                                                        }
                                                    }
                                                }
                                                if ($total <= $coins[$type]) {
                                                    if ($type == "platinum" || $type == "gold" || $type == "silver") {
                                                        if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                                            $coins2 = $dB2->query_fetch_single("SELECT * FROM MEMB_CREDITS WHERE memb___id = ?", [$receiver]);
                                                            if ($coins2[$type] == NULL) {
                                                                $dB2->query("INSERT INTO MEMB_CREDITS(memb___id,platinum,platinum_used,gold,gold_used,silver,silver_used) VALUES(?,?,?,?,?,?,?)", [$receiver, 0, 0, 0, 0, 0, 0]);
                                                            }
                                                            $update = $dB2->query("UPDATE MEMB_CREDITS SET " . $type . " = " . $type . " - " . $total . " WHERE memb___id = ?", [$sender]);
                                                            $update2 = $dB2->query("UPDATE MEMB_CREDITS SET " . $type . " = " . $type . " + " . $amount . " WHERE memb___id = ?", [$receiver]);
                                                        } else {
                                                            $coins2 = $dB->query_fetch_single("SELECT * FROM MEMB_CREDITS WHERE memb___id = ?", [$receiver]);
                                                            if ($coins2[$type] == NULL) {
                                                                $dB->query("INSERT INTO MEMB_CREDITS(memb___id,platinum,platinum_used,gold,gold_used,silver,silver_used) VALUES(?,?,?,?,?,?,?)", [$receiver, 0, 0, 0, 0, 0, 0]);
                                                            }
                                                            $update = $dB->query("UPDATE MEMB_CREDITS SET " . $type . " = " . $type . " - " . $total . " WHERE memb___id = ?", [$sender]);
                                                            $update2 = $dB->query("UPDATE MEMB_CREDITS SET " . $type . " = " . $type . " + " . $amount . " WHERE memb___id = ?", [$receiver]);
                                                        }
                                                    } else {
                                                        if ($type == "WCoin" || $type == "WCoinC" || $type == "WCoinP" || $type == "GoblinPoint") {
                                                            $coins2 = $dB->query_fetch_single("SELECT * FROM T_InGameShop_Point WHERE AccountID = ?", [$receiver]);
                                                            if (100 <= config("server_files_season", true)) {
                                                                if ($coins2[$type] == NULL) {
                                                                    $dB->query("INSERT INTO T_InGameShop_Point(AccountID,WCoin,GoblinPoint) VALUES(?,?,?)", [$receiver, 0, 0]);
                                                                }
                                                            } else {
                                                                if ($coins2[$type] == NULL) {
                                                                    $dB->query("INSERT INTO T_InGameShop_Point(AccountID,WCoinP,WCoinC,GoblinPoint) VALUES(?,?,?,?)", [$receiver, 0, 0, 0]);
                                                                }
                                                            }
                                                            $update = $dB->query("UPDATE T_InGameShop_Point SET " . $type . " = " . $type . " - " . $total . " WHERE AccountID = ?", [$sender]);
                                                            $update2 = $dB->query("UPDATE T_InGameShop_Point SET " . $type . " = " . $type . " + " . $amount . " WHERE AccountID = ?", [$receiver]);
                                                        } else {
                                                            if ($type == "zen") {
                                                                $coins2 = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$receiver]);
                                                                if ($coins2[$type] == NULL) {
                                                                    $dB->query("INSERT INTO IMPERIAMUCMS_WEB_BANK(AccountID,zen,bless,soul,life,chaos,harmony,creation,guardian) VALUES(?,?,?,?,?,?,?,?,?)", [$receiver, 0, 0, 0, 0, 0, 0, 0, 0]);
                                                                }
                                                                $update = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET " . $type . " = " . $type . " - " . $total . " WHERE AccountID = ?", [$sender]);
                                                                $update2 = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET " . $type . " = " . $type . " + " . $amount . " WHERE AccountID = ?", [$receiver]);
                                                            }
                                                        }
                                                    }
                                                    if ($update && $update2) {
                                                        message("success", "You have successfully sent " . $amount . " " . $currencyName . " to " . $receiver . ".");
                                                        $logDate = date("Y-m-d H:i:s", time());
                                                        $common->accountLogs($sender, "transfercoins", sprintf(lang("exchange_txt_21", true), $amount, $currencyName, $receiver), $logDate);
                                                        $dB->query("INSERT INTO IMPERIAMUCMS_TRANSFER_COINS_LOGS (OldAccountID, NewAccountID, amount, amount_type, date, message) VALUES (?, ?, ?, ?, ?, ?)", [$sender, $receiver, $amount, $amountType, date("Y-m-d H:i:s", time()), $message]);
                                                    } else {
                                                        message("error", lang("error_23", true));
                                                    }
                                                } else {
                                                    message("error", sprintf(lang("exchange_txt_22", true), $currencyName));
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    public function transferCoinsReceivedHistory($accountId)
    {
        global $dB;
        $data = $dB->query_fetch("SELECT TOP 20 * FROM IMPERIAMUCMS_TRANSFER_COINS_LOGS WHERE NewAccountID = ? ORDER BY date DESC", [$accountId]);
        return $data;
    }
    public function transferCoinsSentHistory($accountId)
    {
        global $dB;
        $data = $dB->query_fetch("SELECT TOP 20 * FROM IMPERIAMUCMS_TRANSFER_COINS_LOGS WHERE OldAccountID = ? ORDER BY date DESC", [$accountId]);
        return $data;
    }
}

?>