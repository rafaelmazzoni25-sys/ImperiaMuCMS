<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class Promo
{
    public function codeExist($code)
    {
        global $dB;
        $code = xss_clean($code);
        if (!check_value($code)) {
            message("error", lang("error_4", true));
        } else {
            $data = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_PROMO WHERE code = ? AND active = '1'", [$code]);
            if (is_array($data)) {
                return true;
            }
            return false;
        }
    }
    public function rewardExist($code)
    {
        global $dB;
        $code = xss_clean($code);
        if (!check_value($code)) {
            message("error", lang("error_4", true));
        } else {
            $data = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_PROMO_REWARDS WHERE code = ?", [$code]);
            if (is_array($data)) {
                return true;
            }
            return false;
        }
    }
    public function canUseCode($code, $username)
    {
        $code = xss_clean($code);
        if (!check_value($code)) {
            message("error", lang("error_4", true));
        } else {
            if (!check_value($username)) {
                message("error", lang("error_4", true));
            } else {
                if (!Validator::UsernameLength($username)) {
                    message("error", lang("error_5", true));
                } else {
                    if (!Validator::AlphaNumeric($username)) {
                        message("error", lang("error_6", true));
                    } else {
                        $codeData = $this->getPromo($code);
                        if ($codeData["owner"] != NULL) {
                            if ($codeData["owner"] != $username) {
                                return false;
                            }
                            $promoUser = $this->getPromoUser($code, $username);
                            if ($promoUser == NULL || empty($promoUser)) {
                                return true;
                            }
                            return false;
                        }
                        if ($codeData["type"] == "1") {
                            $promoLogs = $this->getPromoLogs($code);
                            if ($promoLogs == NULL || empty($promoLogs)) {
                                return true;
                            }
                            return false;
                        }
                        if ($codeData["type"] == "2") {
                            $promoUser = $this->getPromoUser($code, $username);
                            if ($promoUser == NULL || empty($promoUser)) {
                                return true;
                            }
                            return false;
                        }
                        return false;
                    }
                }
            }
        }
    }
    public function getPromo($code)
    {
        global $dB;
        $code = xss_clean($code);
        if (!check_value($code)) {
            message("error", lang("error_4", true));
        } else {
            $data = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_PROMO WHERE code = ? AND active = 1", [$code]);
            if (is_array($data)) {
                return $data;
            }
            return NULL;
        }
    }
    public function getPromoUser($code, $username)
    {
        global $dB;
        $code = xss_clean($code);
        if (!check_value($code)) {
            message("error", lang("error_4", true));
        } else {
            if (!check_value($username)) {
                message("error", lang("error_4", true));
            } else {
                if (!Validator::UsernameLength($username)) {
                    message("error", lang("error_5", true));
                } else {
                    if (!Validator::AlphaNumeric($username)) {
                        message("error", lang("error_6", true));
                    } else {
                        $data = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_PROMO_LOGS WHERE code = ? AND AccountID = ?", [$code, $username]);
                        if (is_array($data)) {
                            return $data;
                        }
                        return NULL;
                    }
                }
            }
        }
    }
    public function getPromoLogs($code)
    {
        global $dB;
        $code = xss_clean($code);
        if (!check_value($code)) {
            message("error", lang("error_4", true));
        } else {
            $data = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_PROMO_LOGS WHERE code = ?", [$code]);
            if (is_array($data)) {
                return $data;
            }
            return NULL;
        }
    }
    public function giveReward($code, $username)
    {
        global $dB;
        global $dB2;
        global $common;
        $code = xss_clean($code);
        if (!check_value($code)) {
            message("error", lang("error_4", true));
        } else {
            if (!check_value($username)) {
                message("error", lang("error_4", true));
            } else {
                if (!Validator::UsernameLength($username)) {
                    message("error", lang("error_5", true));
                } else {
                    if (!Validator::AlphaNumeric($username)) {
                        message("error", lang("error_6", true));
                    } else {
                        $codeData = $this->getPromo($code);
                        switch ($codeData["reward_type"]) {
                            case "1":
                                $rewards = $this->getReward($code);
                                if ($rewards["count"] == NULL || empty($rewards["count"])) {
                                    message("error", lang("promo_txt_1", true));
                                } else {
                                    $date = date("Y-m-d H:i:s", time());
                                    if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                        $giveReward = $dB2->query("UPDATE MEMB_CREDITS SET gold = gold + ? WHERE memb___id = ?", [$rewards["count"], $username]);
                                    } else {
                                        $giveReward = $dB->query("UPDATE MEMB_CREDITS SET gold = gold + ? WHERE memb___id = ?", [$rewards["count"], $username]);
                                    }
                                    $log = $dB->query("INSERT INTO IMPERIAMUCMS_PROMO_LOGS(code,AccountID,date,reward)\r\n                             VALUES(?,?,?,?)", [$code, $username, $date, $rewards["count"] . " " . lang("currency_gold", true)]);
                                    if ($giveReward) {
                                        message("success", sprintf(lang("promo_txt_2", true), $rewards["count"], lang("currency_gold", true)));
                                        $logDate = date("Y-m-d H:i:s", time());
                                        $common->accountLogs($username, "promo", sprintf(lang("promo_txt_3", true), $rewards["count"], lang("currency_gold", true)), $logDate);
                                    } else {
                                        message("error", lang("error_23", true));
                                    }
                                }
                                break;
                            case "2":
                                $rewards = $this->getReward($code);
                                if ($rewards["count"] == NULL || empty($rewards["count"])) {
                                    message("error", lang("promo_txt_1", true));
                                } else {
                                    $date = date("Y-m-d H:i:s", time());
                                    if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                        $giveReward = $dB2->query("UPDATE MEMB_CREDITS SET silver = silver + ? WHERE memb___id = ?", [$rewards["count"], $username]);
                                    } else {
                                        $giveReward = $dB->query("UPDATE MEMB_CREDITS SET silver = silver + ? WHERE memb___id = ?", [$rewards["count"], $username]);
                                    }
                                    $log = $dB->query("INSERT INTO IMPERIAMUCMS_PROMO_LOGS(code,AccountID,date,reward)\r\n                             VALUES(?,?,?,?)", [$code, $username, $date, $rewards["count"] . " " . lang("currency_silver", true)]);
                                    if ($giveReward) {
                                        message("success", sprintf(lang("promo_txt_2", true), $rewards["count"], lang("currency_silver", true)));
                                        $logDate = date("Y-m-d H:i:s", time());
                                        $common->accountLogs($username, "promo", sprintf(lang("promo_txt_3", true), $rewards["count"], lang("currency_silver", true)), $logDate);
                                    } else {
                                        message("error", lang("error_23", true));
                                    }
                                }
                                break;
                            case "3":
                                $rewards = $this->getReward($code);
                                if ($rewards["count"] == NULL || empty($rewards["count"])) {
                                    message("error", lang("promo_txt_1", true));
                                } else {
                                    $date = date("Y-m-d H:i:s", time());
                                    if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                        $giveReward = $dB2->query("UPDATE MEMB_CREDITS SET platinum = platinum + ? WHERE memb___id = ?", [$rewards["count"], $username]);
                                    } else {
                                        $giveReward = $dB->query("UPDATE MEMB_CREDITS SET platinum = platinum + ? WHERE memb___id = ?", [$rewards["count"], $username]);
                                    }
                                    $log = $dB->query("INSERT INTO IMPERIAMUCMS_PROMO_LOGS(code,AccountID,date,reward)\r\n                             VALUES(?,?,?,?)", [$code, $username, $date, $rewards["count"] . " " . lang("currency_platinum", true)]);
                                    if ($giveReward) {
                                        message("success", sprintf(lang("promo_txt_2", true), $rewards["count"], lang("currency_platinum", true)));
                                        $logDate = date("Y-m-d H:i:s", time());
                                        $common->accountLogs($username, "promo", sprintf(lang("promo_txt_3", true), $rewards["count"], lang("currency_platinum", true)), $logDate);
                                    } else {
                                        message("error", lang("error_23", true));
                                    }
                                }
                                break;
                            case "4":
                                $Market = new Market();
                                $Items = new Items();
                                $rewards = $this->getReward($code);
                                if ($rewards["item"] == NULL || empty($rewards["item"])) {
                                    message("error", lang("promo_txt_1", true));
                                } else {
                                    $itemInfo = $Items->ItemInfo($rewards["item"]);
                                    $serial = $dB->query_fetch_single("exec WZ_GetItemSerial2 1");
                                    $serial = $serial["ItemSerial"];
                                    $serial = dechex($serial);
                                    while (strlen($serial) < 16) {
                                        $serial = "0" . $serial;
                                    }
                                    $serial2 = substr($serial, 0, 8);
                                    $serial = substr($serial, 8, 8);
                                    $rewards["item"] = substr_replace($rewards["item"], $serial2, 6, 8);
                                    $rewards["item"] = substr_replace($rewards["item"], $serial, 32, 8);
                                    $date = date("Y-m-d H:i:s", time());
                                    $giveReward = $dB->query("INSERT INTO IMPERIAMUCMS_WEBSHOP_ITEMS_INVENTORY(AccountID,item,price,price_type,date,status,type,giftFrom)\r\n                                    VALUES(?,?,0,0,?,0,3,'Staff')", [$username, $rewards["item"], $date]);
                                    $log = $dB->query("INSERT INTO IMPERIAMUCMS_PROMO_LOGS(code,AccountID,date,reward)\r\n                             VALUES(?,?,?,?)", [$code, $username, $date, $rewards["item"]]);
                                    if ($giveReward) {
                                        message("success", sprintf(lang("promo_txt_4", true), $itemInfo["name"]));
                                        $logDate = date("Y-m-d H:i:s", time());
                                        $common->accountLogs($username, "promo", sprintf(lang("promo_txt_5", true), $itemInfo["name"]), $logDate);
                                    } else {
                                        message("error", lang("error_23", true));
                                    }
                                }
                                break;
                            case "5":
                                $Market = new Market();
                                $Items = new Items();
                                $rewards = $this->getRewards($code);
                                $max = sizeof($rewards) - 1;
                                $min = 0;
                                $random = rand($min, $max);
                                $date = date("Y-m-d H:i:s", time());
                                $i = 0;
                                foreach ($rewards as $thisItem) {
                                    if ($random == $i) {
                                        $itemInfo = $Items->ItemInfo($thisItem["item"]);
                                        $serial = $dB->query_fetch_single("exec WZ_GetItemSerial2 1");
                                        $serial = $serial["ItemSerial"];
                                        $serial = dechex($serial);
                                        while (strlen($serial) < 16) {
                                            $serial = "0" . $serial;
                                        }
                                        $serial2 = substr($serial, 0, 8);
                                        $serial = substr($serial, 8, 8);
                                        $thisItem["item"] = substr_replace($thisItem["item"], $serial2, 6, 8);
                                        $thisItem["item"] = substr_replace($thisItem["item"], $serial, 32, 8);
                                        $giveReward = $dB->query("INSERT INTO IMPERIAMUCMS_WEBSHOP_ITEMS_INVENTORY(AccountID,item,price,price_type,date,status,type,giftFrom)\r\n                                      VALUES(?,?,0,0,?,0,3,'Staff')", [$username, $thisItem["item"], $date]);
                                        $log = $dB->query("INSERT INTO IMPERIAMUCMS_PROMO_LOGS(code,AccountID,date,reward)\r\n                              VALUES(?,?,?,?)", [$code, $username, $date, $thisItem["item"]]);
                                        if ($giveReward) {
                                            message("success", sprintf(lang("promo_txt_4", true), $itemInfo["name"]));
                                            $logDate = date("Y-m-d H:i:s", time());
                                            $common->accountLogs($username, "promo", sprintf(lang("promo_txt_5", true), $itemInfo["name"]), $logDate);
                                        } else {
                                            message("error", lang("error_23", true));
                                        }
                                    } else {
                                        $i++;
                                    }
                                }
                                break;
                            case "6":
                                $Market = new Market();
                                $Items = new Items();
                                $rewards = $this->getRewards($code);
                                $date = date("Y-m-d H:i:s", time());
                                foreach ($rewards as $thisItem) {
                                    $itemInfo = $Items->ItemInfo($thisItem["item"]);
                                    $serial = $dB->query_fetch_single("exec WZ_GetItemSerial2 1");
                                    $serial = $serial["ItemSerial"];
                                    $serial = dechex($serial);
                                    while (strlen($serial) < 16) {
                                        $serial = "0" . $serial;
                                    }
                                    $serial2 = substr($serial, 0, 8);
                                    $serial = substr($serial, 8, 8);
                                    $thisItem["item"] = substr_replace($thisItem["item"], $serial2, 6, 8);
                                    $thisItem["item"] = substr_replace($thisItem["item"], $serial, 32, 8);
                                    $giveReward = $dB->query("INSERT INTO IMPERIAMUCMS_WEBSHOP_ITEMS_INVENTORY(AccountID,item,price,price_type,date,status,type,giftFrom)\r\n                                    VALUES(?,?,0,0,?,0,3,'Staff')", [$username, $thisItem["item"], $date]);
                                    $log = $dB->query("INSERT INTO IMPERIAMUCMS_PROMO_LOGS(code,AccountID,date,reward)\r\n                             VALUES(?,?,?,?)", [$code, $username, $date, $thisItem["item"]]);
                                    if ($giveReward) {
                                        message("success", sprintf(lang("promo_txt_4", true), $itemInfo["name"]));
                                        $logDate = date("Y-m-d H:i:s", time());
                                        $common->accountLogs($username, "promo", sprintf(lang("promo_txt_5", true), $itemInfo["name"]), $logDate);
                                    } else {
                                        message("error", lang("error_23", true));
                                    }
                                }
                                break;
                            case "7":
                                $rewards = $this->getReward($code);
                                if ($rewards["count"] == NULL || empty($rewards["count"]) || $rewards["vip_type"] == NULL || empty($rewards["vip_type"])) {
                                    message("error", lang("promo_txt_1", true));
                                } else {
                                    if ($rewards["vip_type"] == "1") {
                                        $vip_type = "Bronze";
                                    } else {
                                        if ($rewards["vip_type"] == "2") {
                                            $vip_type = "Silver";
                                        } else {
                                            if ($rewards["vip_type"] == "3") {
                                                $vip_type = "Gold";
                                            } else {
                                                if ($rewards["vip_type"] == "4") {
                                                    $vip_type = "Platinum";
                                                }
                                            }
                                        }
                                    }
                                    if (config("SQL_USE_2_DB", true)) {
                                        $vipData = $dB2->query_fetch_single("SELECT * FROM T_VIPList WHERE AccountID = ?", [$username]);
                                    } else {
                                        $vipData = $dB->query_fetch_single("SELECT * FROM T_VIPList WHERE AccountID = ?", [$username]);
                                    }
                                    if ($vipData == NULL) {
                                        if (config("SQL_USE_2_DB", true)) {
                                            $dB2->query("INSERT INTO T_VIPList(AccountID,Date,Type) VALUES(?,NULL,NULL)", [$username]);
                                        } else {
                                            $dB->query("INSERT INTO T_VIPList(AccountID,Date,Type) VALUES(?,NULL,NULL)", [$username]);
                                        }
                                    }
                                    if (time() < strtotime($vipData["Date"])) {
                                        if ($vipData["Type"] == $rewards["vip_type"]) {
                                            $time = strtotime($vipData["Date"]) + $rewards["count"] * 86400;
                                            $date = date("Y-m-d H:i:s", $time);
                                            $date2 = date("Y-m-d H:i:s", time());
                                            if (config("SQL_USE_2_DB", true)) {
                                                $giveReward = $dB2->query("UPDATE T_VIPList SET Date = ?, Type = ? WHERE AccountID = ?", [$date, $rewards["vip_type"], $username]);
                                            } else {
                                                $giveReward = $dB->query("UPDATE T_VIPList SET Date = ?, Type = ? WHERE AccountID = ?", [$date, $rewards["vip_type"], $username]);
                                            }
                                            $log = $dB->query("INSERT INTO IMPERIAMUCMS_PROMO_LOGS(code,AccountID,date,reward)\r\n                                 VALUES(?,?,?,?)", [$code, $username, $date2, $vip_type . " " . sprintf(lang("promo_txt_6", true), $rewards["count"])]);
                                            if ($giveReward) {
                                                message("success", sprintf(lang("promo_txt_7", true), $vip_type, $rewards["count"]));
                                                $logDate = date("Y-m-d H:i:s", time());
                                                $common->accountLogs($username, "promo", sprintf(lang("promo_txt_8", true), $vip_type, $rewards["count"]), $logDate);
                                            } else {
                                                message("error", lang("error_23", true));
                                            }
                                        } else {
                                            message("error", lang("promo_txt_9", true));
                                        }
                                    } else {
                                        $time = time() + $rewards["count"] * 86400;
                                        $date = date("Y-m-d H:i:s", $time);
                                        $date2 = date("Y-m-d H:i:s", time());
                                        if (config("SQL_USE_2_DB", true)) {
                                            $giveReward = $dB2->query("UPDATE T_VIPList SET Date = ?, Type = ? WHERE AccountID = ?", [$date, $rewards["vip_type"], $username]);
                                        } else {
                                            $giveReward = $dB->query("UPDATE T_VIPList SET Date = ?, Type = ? WHERE AccountID = ?", [$date, $rewards["vip_type"], $username]);
                                        }
                                        $log = $dB->query("INSERT INTO IMPERIAMUCMS_PROMO_LOGS(code,AccountID,date,reward)\r\n                               VALUES(?,?,?,?)", [$code, $username, $date2, $vip_type . " " . sprintf(lang("promo_txt_6", true), $rewards["count"])]);
                                        if ($giveReward) {
                                            message("success", sprintf(lang("promo_txt_7", true), $vip_type, $rewards["count"]));
                                            $logDate = date("Y-m-d H:i:s", time());
                                            $common->accountLogs($username, "promo", sprintf(lang("promo_txt_8", true), $vip_type, $rewards["count"]), $logDate);
                                        } else {
                                            message("error", lang("error_23", true));
                                        }
                                    }
                                }
                                break;
                            case "8":
                                $rewards = $this->getReward($code);
                                if ($rewards["count"] == NULL || empty($rewards["count"])) {
                                    message("error", lang("promo_txt_1", true));
                                } else {
                                    $date = date("Y-m-d H:i:s", time());
                                    if (100 <= config("server_files_season", true)) {
                                        $giveReward = $dB->query("UPDATE T_InGameShop_Point SET WCoin = WCoin + ? WHERE AccountID = ?", [$rewards["count"], $username]);
                                    } else {
                                        $giveReward = $dB->query("UPDATE T_InGameShop_Point SET WCoinC = WCoinC + ? WHERE AccountID = ?", [$rewards["count"], $username]);
                                    }
                                    $log = $dB->query("INSERT INTO IMPERIAMUCMS_PROMO_LOGS(code,AccountID,date,reward)\r\n                             VALUES(?,?,?,?)", [$code, $username, $date, $rewards["count"] . " " . lang("currency_wcoinc", true)]);
                                    if ($giveReward) {
                                        message("success", sprintf(lang("promo_txt_2", true), $rewards["count"], lang("currency_wcoinc", true)));
                                        $logDate = date("Y-m-d H:i:s", time());
                                        $common->accountLogs($username, "promo", sprintf(lang("promo_txt_3", true), $rewards["count"], lang("currency_wcoinc", true)), $logDate);
                                    } else {
                                        message("error", lang("error_23", true));
                                    }
                                }
                                break;
                            case "9":
                                $rewards = $this->getReward($code);
                                if ($rewards["count"] == NULL || empty($rewards["count"])) {
                                    message("error", lang("promo_txt_1", true));
                                } else {
                                    $date = date("Y-m-d H:i:s", time());
                                    $giveReward = $dB->query("UPDATE T_InGameShop_Point SET GoblinPoint = T_InGameShop_Point.GoblinPoint + ? WHERE AccountID = ?", [$rewards["count"], $username]);
                                    $log = $dB->query("INSERT INTO IMPERIAMUCMS_PROMO_LOGS(code,AccountID,date,reward)\r\n                             VALUES(?,?,?,?)", [$code, $username, $date, $rewards["count"] . " " . lang("currency_gp", true)]);
                                    if ($giveReward) {
                                        message("success", sprintf(lang("promo_txt_2", true), $rewards["count"], lang("currency_gp", true)));
                                        $logDate = date("Y-m-d H:i:s", time());
                                        $common->accountLogs($username, "promo", sprintf(lang("promo_txt_3", true), $rewards["count"], lang("currency_gp", true)), $logDate);
                                    } else {
                                        message("error", lang("error_23", true));
                                    }
                                }
                                break;
                            case "10":
                                $rewards = $this->getReward($code);
                                if ($rewards["count"] == NULL || empty($rewards["count"])) {
                                    message("error", lang("promo_txt_1", true));
                                } else {
                                    $date = date("Y-m-d H:i:s", time());
                                    $giveReward = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET zen = zen + ? WHERE AccountID = ?", [$rewards["count"], $username]);
                                    $log = $dB->query("INSERT INTO IMPERIAMUCMS_PROMO_LOGS(code,AccountID,date,reward)\r\n                             VALUES(?,?,?,?)", [$code, $username, $date, $rewards["count"] . " " . lang("currency_zen", true) . ""]);
                                    if ($giveReward) {
                                        message("success", sprintf(lang("promo_txt_2", true), $rewards["count"], "" . lang("currency_zen", true) . ""));
                                        $logDate = date("Y-m-d H:i:s", time());
                                        $common->accountLogs($username, "promo", sprintf(lang("promo_txt_3", true), $rewards["count"], "" . lang("currency_zen", true) . ""), $logDate);
                                    } else {
                                        message("error", lang("error_23", true));
                                    }
                                }
                                break;
                        }
                    }
                }
            }
        }
    }
    public function getReward($code)
    {
        global $dB;
        $code = xss_clean($code);
        if (!check_value($code)) {
            message("error", lang("error_4", true));
        } else {
            $data = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_PROMO_REWARDS WHERE code = ?", [$code]);
            if (is_array($data)) {
                return $data;
            }
            return NULL;
        }
    }
    public function getRewards($code)
    {
        global $dB;
        $code = xss_clean($code);
        if (!check_value($code)) {
            message("error", lang("error_4", true));
        } else {
            $data = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_PROMO_REWARDS WHERE code = ?", [$code]);
            if (is_array($data)) {
                return $data;
            }
            return NULL;
        }
    }
    public function addCode($code, $type, $reward_type, $owner, $status)
    {
        global $dB;
        if (!check_value($code)) {
            message("error", lang("error_4", true));
        } else {
            if (!check_value($type)) {
                message("error", lang("error_4", true));
            } else {
                if (!check_value($reward_type)) {
                    message("error", lang("error_4", true));
                } else {
                    if ($owner != NULL) {
                        if (!check_value($owner)) {
                            message("error", lang("error_4", true));
                            return NULL;
                        }
                        if (!Validator::UsernameLength($owner)) {
                            message("error", lang("error_5", true));
                            return NULL;
                        }
                        if (!Validator::AlphaNumeric($owner)) {
                            message("error", lang("error_6", true));
                            return NULL;
                        }
                    }
                    if (!is_numeric($type)) {
                        return NULL;
                    }
                    if (!is_numeric($reward_type)) {
                        return NULL;
                    }
                    if (!is_numeric($status)) {
                        return NULL;
                    }
                    if (empty($owner)) {
                        $owner = NULL;
                    }
                    $checkCode = $dB->query_fetch_single("SELECT code FROM IMPERIAMUCMS_PROMO WHERE code = ?", [$code]);
                    if (is_array($checkCode)) {
                        message("error", "Code already exists.");
                    } else {
                        $insert = $dB->query("INSERT INTO IMPERIAMUCMS_PROMO(code,type,reward_type,owner,active) VALUES(?,?,?,?,?)", [$code, $type, $reward_type, $owner, $status]);
                        if ($insert) {
                            message("success", "Promo code was successfully created.");
                        } else {
                            message("error", "Unexpected error occurred.");
                        }
                    }
                }
            }
        }
    }
    public function editCode($id, $code, $type, $reward_type, $owner, $status)
    {
        global $dB;
        if (!check_value($code)) {
            message("error", lang("error_4", true));
        } else {
            if (!check_value($type)) {
                message("error", lang("error_4", true));
            } else {
                if (!check_value($reward_type)) {
                    message("error", lang("error_4", true));
                } else {
                    if ($owner != NULL) {
                        if (!check_value($owner)) {
                            message("error", lang("error_4", true));
                            return NULL;
                        }
                        if (!Validator::UsernameLength($owner)) {
                            message("error", lang("error_5", true));
                            return NULL;
                        }
                        if (!Validator::AlphaNumeric($owner)) {
                            message("error", lang("error_6", true));
                            return NULL;
                        }
                    }
                    if (!is_numeric($type)) {
                        return NULL;
                    }
                    if (!is_numeric($reward_type)) {
                        return NULL;
                    }
                    if (!is_numeric($status)) {
                        return NULL;
                    }
                    if (empty($owner)) {
                        $owner = NULL;
                    }
                    $update = $dB->query("UPDATE IMPERIAMUCMS_PROMO SET type = ?, reward_type = ?, owner = ?, active = ? WHERE id = ? AND code = ?", [$type, $reward_type, $owner, $status, $id, $code]);
                    if ($update) {
                        message("success", "Promo code was successfully updated.");
                    } else {
                        message("error", "Unexpected error occurred.");
                    }
                }
            }
        }
    }
    public function addCodeItem($code, $item)
    {
        global $dB;
        $insert = $dB->query("INSERT INTO IMPERIAMUCMS_PROMO_REWARDS(code,vip_type,count,item) VALUES(?,?,?,?)", [$code, NULL, NULL, $item]);
        if ($insert) {
            message("success", "Item " . $item . " was successfully added to code " . $code . ".");
        } else {
            message("error", "Error occurred.");
        }
    }
    public function addCodeCoins($code, $count)
    {
        global $dB;
        $insert = $dB->query("INSERT INTO IMPERIAMUCMS_PROMO_REWARDS(code,vip_type,count,item) VALUES(?,?,?,?)", [$code, NULL, $count, NULL]);
        if ($insert) {
            message("success", "Reward was successfully added to code " . $code . ".");
        } else {
            message("error", "Error occurred.");
        }
    }
    public function addCodeVip($code, $vip_type, $count)
    {
        global $dB;
        $insert = $dB->query("INSERT INTO IMPERIAMUCMS_PROMO_REWARDS(code,vip_type,count,item) VALUES(?,?,?,?)", [$code, $vip_type, $count, NULL]);
        if ($insert) {
            message("success", "Reward was successfully added to code " . $code . ".");
        } else {
            message("error", "Error occurred.");
        }
    }
    public function editCodeCoins($code, $count)
    {
        global $dB;
        $update = $dB->query("UPDATE IMPERIAMUCMS_PROMO_REWARDS SET count = ? WHERE code = ?", [$count, $code]);
        if ($update) {
            message("success", "Reward for code " . $code . " was successfully updated.");
        } else {
            message("error", "Error occurred.");
        }
    }
    public function editCodeVip($code, $vip_type, $count)
    {
        global $dB;
        $update = $dB->query("UPDATE IMPERIAMUCMS_PROMO_REWARDS SET vip_type = ?, count = ? WHERE code = ?", [$vip_type, $count, $code]);
        if ($update) {
            message("success", "Reward for code " . $code . " was successfully updated.");
        } else {
            message("error", "Error occurred.");
        }
    }
    public function enableCode($id)
    {
        global $dB;
        $dB->query("UPDATE IMPERIAMUCMS_PROMO SET active = '1' WHERE id = ?", [$id]);
    }
    public function disableCode($id)
    {
        global $dB;
        $dB->query("UPDATE IMPERIAMUCMS_PROMO SET active = '0' WHERE id = ?", [$id]);
    }
    public function getPromoData($id)
    {
        global $dB;
        $result = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_PROMO WHERE id = ?", [$id]);
        if (is_array($result)) {
            return $result;
        }
        return NULL;
    }
    public function addReward($name, $author, $accounts, $characters, $reward_items, $items_type, $reward_amount, $amount_type, $items_exp, $reward_exp, $showMsg = true)
    {
        global $dB;
        global $dB2;
        global $common;
        if (!check_value($name)) {
            message("error", lang("error_4", true));
        } else {
            if (!check_value($author)) {
                message("error", lang("error_4", true));
            } else {
                if ($accounts != NULL && !empty($accounts) && $characters != NULL && !empty($characters)) {
                    message("error", "You can give reward to accounts or characters, not both at the same time.");
                } else {
                    if ($reward_items != NULL && !empty($reward_items) && $items_type < 1) {
                        message("error", lang("error_4", true));
                    } else {
                        if ($reward_amount != NULL && !empty($reward_amount) && 0 < $reward_amount && $amount_type < 1) {
                            message("error", lang("error_4", true));
                        } else {
                            if (($accounts == NULL || empty($accounts)) && ($characters == NULL || empty($characters)) && ($reward_amount < 1 || $reward_amount == NULL) && ($amount_type < 1 || $amount_type == NULL) && ($reward_items == NULL || empty($reward_items))) {
                                message("error", lang("error_4", true));
                            } else {
                                $rewards_created = 0;
                                if ($accounts != NULL && !empty($accounts)) {
                                    $accounts = str_replace(" ", "", $accounts);
                                    $accountsArray = explode(",", $accounts);
                                    foreach ($accountsArray as $thisAcc) {
                                        if (!$common->userExists($thisAcc)) {
                                            message("error", "Account " . $thisAcc . " does not exist.");
                                        } else {
                                            $insert = $dB->query("INSERT INTO IMPERIAMUCMS_CLAIM_REWARD (title, author, AccountID, Name, reward_items, reward_item_type, reward_amount, reward_amount_type, date, expiration, items_expiration)\r\n                                          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$name, $author, $thisAcc, NULL, $reward_items, $items_type, $reward_amount, $amount_type, date("Y-m-d H:i:s", time()), $reward_exp, $items_exp]);
                                            if ($insert) {
                                                $rewards_created++;
                                            }
                                        }
                                    }
                                }
                                if ($characters != NULL && !empty($characters)) {
                                    $characters = str_replace(" ", "", $characters);
                                    $charactersArray = explode(",", $characters);
                                    $Character = new Character();
                                    foreach ($charactersArray as $thisChar) {
                                        if (!$Character->CharacterExists($thisChar)) {
                                            message("error", "Character " . $thisChar . " does not exist.");
                                        } else {
                                            $getAccountID = $dB->query_fetch_single("SELECT TOP 1 AccountID FROM Character WHERE Name = ?", [$thisChar]);
                                            $insert = $dB->query("INSERT INTO IMPERIAMUCMS_CLAIM_REWARD (title, author, AccountID, Name, reward_items, reward_item_type, reward_amount, reward_amount_type, date, expiration, items_expiration)\r\n                                          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$name, $author, $getAccountID["AccountID"], $thisChar, $reward_items, $items_type, $reward_amount, $amount_type, date("Y-m-d H:i:s", time()), $reward_exp, $items_exp]);
                                            if ($insert) {
                                                $rewards_created++;
                                            }
                                        }
                                    }
                                }
                                if (($accounts == NULL || empty($accounts)) && ($characters == NULL || empty($characters))) {
                                    if (config("SQL_USE_2_DB", true)) {
                                        $allAccounts = $dB2->query_fetch("SELECT memb___id FROM MEMB_INFO");
                                    } else {
                                        $allAccounts = $dB->query_fetch("SELECT memb___id FROM MEMB_INFO");
                                    }
                                    foreach ($allAccounts as $thisAcc) {
                                        $insert = $dB->query("INSERT INTO IMPERIAMUCMS_CLAIM_REWARD (title, author, AccountID, Name, reward_items, reward_item_type, reward_amount, reward_amount_type, date, expiration, items_expiration)\r\n                                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$name, $author, $thisAcc["memb___id"], NULL, $reward_items, $items_type, $reward_amount, $amount_type, date("Y-m-d H:i:s", time()), $reward_exp, $items_exp]);
                                        if ($insert) {
                                            $rewards_created++;
                                        }
                                    }
                                }
                                if ($showMsg) {
                                    message("success", $rewards_created . " rewards were successfully created.");
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    public function getMyRewards($username, $page = NULL, $limit = NULL)
    {
        global $dB;
        if (!check_value($username)) {
            message("error", lang("error_4", true));
        } else {
            if (!Validator::UsernameLength($username)) {
                message("error", lang("error_5", true));
            } else {
                if (!Validator::AlphaNumeric($username)) {
                    message("error", lang("error_6", true));
                } else {
                    $result = $dB->query_fetch("\r\n            SELECT * FROM IMPERIAMUCMS_CLAIM_REWARD \r\n            WHERE AccountID = ? AND claimed = ? AND (expiration IS NULL OR expiration > GETDATE())\r\n            ORDER BY date ASC\r\n            OFFSET " . intval($page * $limit - $limit) . " ROWS FETCH NEXT " . intval($limit) . " ROWS ONLY", [$username, 0]);
                    if (is_array($result)) {
                        return $result;
                    }
                    return false;
                }
            }
        }
    }
    public function getAllMyRewards($username)
    {
        global $dB;
        if (!check_value($username)) {
            message("error", lang("error_4", true));
        } else {
            if (!Validator::UsernameLength($username)) {
                message("error", lang("error_5", true));
            } else {
                if (!Validator::AlphaNumeric($username)) {
                    message("error", lang("error_6", true));
                } else {
                    $result = $dB->query_fetch_single("\r\n            SELECT COUNT(*) as count FROM IMPERIAMUCMS_CLAIM_REWARD \r\n            WHERE AccountID = ? AND claimed = ? AND (expiration IS NULL OR expiration > GETDATE())", [$username, 0]);
                    return $result["count"];
                }
            }
        }
    }
    public function claimReward($username, $char, $reward_id, $item = NULL)
    {
        global $dB;
        global $dB2;
        global $common;
        if (!Validator::UsernameLength($username)) {
            message("error", lang("error_5", true));
        } else {
            if (!Validator::AlphaNumeric($username)) {
                message("error", lang("error_6", true));
            } else {
                if ($char != NULL && !empty($char) && 10 < strlen($char)) {
                    message("error", lang("error_23", true));
                } else {
                    if (!Validator::UnsignedNumber($reward_id)) {
                        message("error", lang("error_23", true));
                    } else {
                        if ($item != NULL && !empty($item) && !Validator::UnsignedNumber($item)) {
                            message("error", lang("error_23", true));
                        } else {
                            if (!$common->accountOnline($_SESSION["username"])) {
                                $Character = new Character();
                                if ($char != NULL && !empty($char) && (!$Character->CharacterExists($char) || !$Character->CharacterBelongsToAccount($char, $username))) {
                                    message("error", lang("claimreward_txt_17", true));
                                    return NULL;
                                }
                                $checkReward = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_CLAIM_REWARD WHERE id = ? AND (AccountID = ? OR Name = ?) AND claimed = ?", [$reward_id, $username, $char, 0]);
                                if (is_array($checkReward)) {
                                    $addCoins = true;
                                    if ($checkReward["reward_items"] != NULL && !empty($checkReward["reward_items"])) {
                                        $rewardItems = "";
                                        switch ($checkReward["reward_item_type"]) {
                                            case 1:
                                                $itemsTMP = explode(",", $checkReward["reward_items"]);
                                                $rewardItems = $itemsTMP[$item];
                                                break;
                                            case 2:
                                                $rewardItems = $checkReward["reward_items"];
                                                break;
                                            case 3:
                                                $itemsTMP = explode(",", $checkReward["reward_items"]);
                                                $rand = rand(0, count($itemsTMP) - 1);
                                                $rewardItems = $itemsTMP[$rand];
                                                break;
                                            default:
                                                if ($char != NULL && !empty($char)) {
                                                    $addCoins = $this->giveItemsToInventory($username, $char, $rewardItems, $checkReward["items_expiration"]);
                                                } else {
                                                    $addCoins = $this->giveItemsToVault($username, $rewardItems);
                                                }
                                        }
                                    }
                                    if ($addCoins) {
                                        $giveReward = true;
                                        if (0 < $checkReward["reward_amount"]) {
                                            switch ($checkReward["reward_amount_type"]) {
                                                case 1:
                                                    $rewardCoinsName = lang("currency_platinum", true);
                                                    if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                                        $giveReward = $dB2->query("UPDATE MEMB_CREDITS SET platinum = platinum + ? WHERE memb___id = ?", [$checkReward["reward_amount"], $username]);
                                                    } else {
                                                        $giveReward = $dB->query("UPDATE MEMB_CREDITS SET platinum = platinum + ? WHERE memb___id = ?", [$checkReward["reward_amount"], $username]);
                                                    }
                                                    break;
                                                case 2:
                                                    $rewardCoinsName = lang("currency_gold", true);
                                                    if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                                        $giveReward = $dB2->query("UPDATE MEMB_CREDITS SET gold = gold + ? WHERE memb___id = ?", [$checkReward["reward_amount"], $username]);
                                                    } else {
                                                        $giveReward = $dB->query("UPDATE MEMB_CREDITS SET gold = gold + ? WHERE memb___id = ?", [$checkReward["reward_amount"], $username]);
                                                    }
                                                    break;
                                                case 3:
                                                    $rewardCoinsName = lang("currency_silver", true);
                                                    if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                                        $giveReward = $dB2->query("UPDATE MEMB_CREDITS SET silver = silver + ? WHERE memb___id = ?", [$checkReward["reward_amount"], $username]);
                                                    } else {
                                                        $giveReward = $dB->query("UPDATE MEMB_CREDITS SET silver = silver + ? WHERE memb___id = ?", [$checkReward["reward_amount"], $username]);
                                                    }
                                                    break;
                                                case 4:
                                                    $rewardCoinsName = lang("currency_wcoinc", true);
                                                    if (100 <= config("server_files_season", true)) {
                                                        $giveReward = $dB->query("UPDATE T_InGameShop_Point SET WCoin = WCoin + ? WHERE AccountID = ?", [$checkReward["reward_amount"], $username]);
                                                    } else {
                                                        $giveReward = $dB->query("UPDATE T_InGameShop_Point SET WCoinC = WCoinC + ? WHERE AccountID = ?", [$checkReward["reward_amount"], $username]);
                                                    }
                                                    break;
                                                case 5:
                                                    $rewardCoinsName = lang("currency_gp", true);
                                                    $giveReward = $dB->query("UPDATE T_InGameShop_Point SET GoblinPoint = GoblinPoint + ? WHERE AccountID = ?", [$checkReward["reward_amount"], $username]);
                                                    break;
                                                case 6:
                                                    $rewardCoinsName = "" . lang("currency_zen", true) . "";
                                                    $giveReward = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET zen = zen + ? WHERE AccountID = ?", [$checkReward["reward_amount"], $username]);
                                                    break;
                                                case 7:
                                                    $rewardCoinsName = lang("currency_wcoinp", true);
                                                    $giveReward = $dB->query("UPDATE T_InGameShop_Point SET WCoinP = WCoinP + ? WHERE AccountID = ?", [$checkReward["reward_amount"], $username]);
                                                    break;
                                                case 8:
                                                    $rewardCoinsName = lang("currency_ruud", true);
                                                    if ($char != NULL && !empty($char)) {
                                                        $checkRuud = $dB->query_fetch_single("SELECT Ruud FROM Character WHERE AccountID = ? AND Name = ?", [$username, $char]);
                                                        if (2000000000 < $checkRuud["Ruud"] + $checkReward["reward_amount"]) {
                                                            message("error", lang("claimreward_txt_26", true));
                                                            return NULL;
                                                        }
                                                        $giveReward = $dB->query("UPDATE Character SET Ruud = Ruud + ? WHERE AccountID = ? AND Name = ?", [$checkReward["reward_amount"], $username, $char]);
                                                    }
                                                    break;
                                                default:
                                                    if ($giveReward) {
                                                        message("success", sprintf(lang("claimreward_txt_19", true), number_format($checkReward["reward_amount"]), $rewardCoinsName));
                                                    } else {
                                                        message("error", lang("error_23", true) . "1");
                                                    }
                                            }
                                        }
                                        if ($giveReward) {
                                            $update = $dB->query("UPDATE IMPERIAMUCMS_CLAIM_REWARD SET claimed = ? WHERE id = ?", [1, $reward_id]);
                                            if ($checkReward["reward_amount_type"] == NULL) {
                                                $checkReward["reward_amount_type"] = 0;
                                            }
                                            $insert = $dB->query("INSERT INTO IMPERIAMUCMS_CLAIM_REWARD_LOGS (reward_id, AccountID, Name, reward_items, reward_amount, reward_type, date, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)", [$reward_id, $username, $char, $rewardItems, $checkReward["reward_amount"], $checkReward["reward_amount_type"], date("Y-m-d H:i:s", time()), 1]);
                                            message("success", lang("claimreward_txt_25", true));
                                        } else {
                                            message("error", lang("error_23", true) . "2");
                                        }
                                    }
                                } else {
                                    message("error", lang("claimreward_txt_18", true));
                                }
                            } else {
                                message("error", lang("error_14", true));
                            }
                        }
                    }
                }
            }
        }
    }
    public function giveItemsToInventory($username, $char, $rewardItems, $expiration)
    {
        global $dB;
        global $dB2;
        global $common;
        if (!Validator::UsernameLength($username)) {
            message("error", lang("error_5", true));
        } else {
            if (!Validator::AlphaNumeric($username)) {
                message("error", lang("error_6", true));
            } else {
                if ($char != NULL && !empty($char) && 10 < strlen($char)) {
                    message("error", lang("error_23", true));
                } else {
                    if (!$common->accountOnline($username)) {
                        $Market = new Market();
                        $Items = new Items();
                        $inventory = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT Inventory FROM Character WHERE AccountID = ? AND Name = ?), 2) AS inv", [$username, $char]);
                        $inventory = $inventory["inv"];
                        $inventoryNew = $inventory;
                        $items = explode(",", $rewardItems);
                        $i = 0;
                        $fullSerial = [];
                        foreach ($items as $thisItem) {
                            $itemData = explode(":", $thisItem);
                            $itemHex = $itemData[0];
                            if (1 < count($itemData)) {
                                $itemExp = $itemData[1];
                            } else {
                                $itemExp = 0;
                            }
                            $itemInfo = $Items->ItemInfo($itemHex);
                            $test = 0;
                            $slot = $Market->smartsearchInventory($username, $char, $inventoryNew, $itemInfo["X"], $itemInfo["Y"]);
                            $test = $slot * __ITEM_LENGTH__;
                            if ($slot == 1337) {
                                message("error", lang("claimreward_txt_23", true));
                                return false;
                            }
                            $serial = $dB->query_fetch_single("exec WZ_GetItemSerial2 1");
                            $serial = $serial["ItemSerial"];
                            $fullSerial[$i] = $serial;
                            $serial = dechex($serial);
                            while (strlen($serial) < 16) {
                                $serial = "0" . $serial;
                            }
                            $serial2 = substr($serial, 0, 8);
                            $serial = substr($serial, 8, 8);
                            $itemHex = substr_replace($itemHex, $serial2, 6, 8);
                            $itemHex = substr_replace($itemHex, $serial, 32, 8);
                            if (0 < $itemExp) {
                                $jog = hexdec(substr($itemHex, 19, 1));
                                $jog = $jog + 2;
                                $itemHex = substr_replace($itemHex, dechex($jog), 19, 1);
                            }
                            $inventoryNew = substr_replace($inventoryNew, $itemHex, $test, __ITEM_LENGTH__);
                            $i++;
                        }
                        if (config("SQL_USE_2_DB", true)) {
                            $memb_guid = $dB2->query_fetch_single("SELECT memb_guid FROM MEMB_INFO WHERE memb___id = ?", [$username]);
                        } else {
                            $memb_guid = $dB->query_fetch_single("SELECT memb_guid FROM MEMB_INFO WHERE memb___id = ?", [$username]);
                        }
                        $inventoryNew = "0x" . $inventoryNew;
                        $update = $dB->query("UPDATE [Character] SET [Inventory] = " . $inventoryNew . " WHERE [AccountID] = '" . $username . "' AND Name = '" . $char . "'");
                        if ($update) {
                            $i = 0;
                            foreach ($items as $thisItem) {
                                $itemData = explode(":", $thisItem);
                                $itemHex = $itemData[0];
                                if (1 < count($itemData)) {
                                    $itemExp = $itemData[1];
                                } else {
                                    $itemExp = 0;
                                }
                                if (0 < $itemExp) {
                                    $itemInfo = $Items->ItemInfo($itemHex);
                                    $insert = $dB->query("exec IGC_PeriodItemInsertEx " . $memb_guid["memb_guid"] . ", '" . $char . "', 2, " . ($itemInfo["type"] * 512 + $itemInfo["id"]) . ", 0, 0, 0, " . $fullSerial[$i] . ", " . $itemExp * 60 . ", " . time() . ", " . (time() + $itemExp * 60) . "");
                                }
                                $i++;
                            }
                            return true;
                        } else {
                            return false;
                        }
                    } else {
                        message("error", lang("error_14", true));
                        return false;
                    }
                }
            }
        }
    }
    public function giveItemsToVault($username, $rewardItems)
    {
        global $dB;
        global $common;
        if (!Validator::UsernameLength($username)) {
            message("error", lang("error_5", true));
        } else {
            if (!Validator::AlphaNumeric($username)) {
                message("error", lang("error_6", true));
            } else {
                if (!$common->accountOnline($username)) {
                    $Market = new Market();
                    $Items = new Items();
                    $vault = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT Items FROM warehouse WHERE AccountID = ?), 2) AS vault", [$username]);
                    $vault = $vault["vault"];
                    $vaultNew = $vault;
                    $items = explode(",", $rewardItems);
                    foreach ($items as $thisItem) {
                        $itemInfo = $Items->ItemInfo($thisItem);
                        $test = 0;
                        $slot = $Market->smartsearch2($username, $vaultNew, $itemInfo["X"], $itemInfo["Y"]);
                        $test = $slot * __ITEM_LENGTH__;
                        if ($slot == 1337) {
                            message("error", lang("claimreward_txt_24", true));
                            return false;
                        }
                        $serial = $dB->query_fetch_single("exec WZ_GetItemSerial2 1");
                        $serial = $serial["ItemSerial"];
                        $serial = dechex($serial);
                        while (strlen($serial) < 16) {
                            $serial = "0" . $serial;
                        }
                        $serial2 = substr($serial, 0, 8);
                        $serial = substr($serial, 8, 8);
                        $thisItem = substr_replace($thisItem, $serial2, 6, 8);
                        $thisItem = substr_replace($thisItem, $serial, 32, 8);
                        $vaultNew = substr_replace($vaultNew, $thisItem, $test, __ITEM_LENGTH__);
                    }
                    $vaultNew = "0x" . $vaultNew;
                    $update = $dB->query("UPDATE [warehouse] SET [Items] = " . $vaultNew . " WHERE [AccountID] = '" . $username . "'");
                    if ($update) {
                        return true;
                    }
                    return false;
                } else {
                    message("error", lang("error_14", true));
                    return false;
                }
            }
        }
    }
    public function getCurrencyName($ident)
    {
        switch ($ident) {
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
        }
    }
    public function addStartingKit($title, $req_lvl, $req_mlvl, $req_reset, $req_greset, $req_lvl_max, $req_mlvl_max, $req_reset_max, $req_greset_max, $class, $items, $type, $limit)
    {
        global $dB;
        if (check_value($title) && is_array($items)) {
            $title = xss_clean($title);
            $req_lvl = xss_clean($req_lvl);
            $req_mlvl = xss_clean($req_mlvl);
            $req_reset = xss_clean($req_reset);
            $req_greset = xss_clean($req_greset);
            $req_lvl_max = xss_clean($req_lvl_max);
            $req_mlvl_max = xss_clean($req_mlvl_max);
            $req_reset_max = xss_clean($req_reset_max);
            $req_greset_max = xss_clean($req_greset_max);
            $class = xss_clean($class);
            $type = xss_clean($type);
            if (empty($req_lvl)) {
                $req_lvl = 0;
            }
            if (empty($req_mlvl)) {
                $req_mlvl = 0;
            }
            if (empty($req_reset)) {
                $req_reset = 0;
            }
            if (empty($req_greset)) {
                $req_greset = 0;
            }
            if (empty($req_lvl_max)) {
                $req_lvl_max = 400;
            }
            if (empty($req_mlvl_max)) {
                $req_mlvl_max = 400;
            }
            if (empty($req_reset_max)) {
                $req_reset_max = 999;
            }
            if (empty($req_greset_max)) {
                $req_greset_max = 999;
            }
            if (empty($limit)) {
                $limit = 1;
            }
            if (is_numeric($req_lvl) && is_numeric($req_mlvl) && is_numeric($req_reset) && is_numeric($req_greset) && is_numeric($req_lvl_max) && is_numeric($req_mlvl_max) && is_numeric($req_reset_max) && is_numeric($req_greset_max) && is_numeric($limit)) {
                $insertKit = $dB->query("INSERT INTO IMPERIAMUCMS_STARTING_KIT (title, req_lvl, req_mlvl, req_reset, req_greset, req_lvl_max, req_mlvl_max, req_reset_max, req_greset_max, req_class, type, limit) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$title, $req_lvl, $req_mlvl, $req_reset, $req_greset, $req_lvl_max, $req_mlvl_max, $req_reset_max, $req_greset_max, $class, $type, $limit]);
                if ($insertKit) {
                    $kitID = $dB->query_fetch_single("SELECT id FROM IMPERIAMUCMS_STARTING_KIT WHERE title = ?", [$title]);
                    foreach ($items as $item) {
                        $dB->query("INSERT INTO IMPERIAMUCMS_STARTING_KIT_ITEMS (kit_id, item, expiration) VALUES (?, ?, ?)", [$kitID["id"], $item["item"], $item["expiration"]]);
                    }
                    message("success", "New Starting Kit was successfully created.");
                } else {
                    message("error", lang("error_23", true));
                }
            } else {
                message("error", lang("error_23", true));
            }
        } else {
            message("error", lang("error_4", true));
        }
    }
    public function editStartingKit($id, $title, $req_lvl, $req_mlvl, $req_reset, $req_greset, $req_lvl_max, $req_mlvl_max, $req_reset_max, $req_greset_max, $class, $items, $type, $limit)
    {
        global $dB;
        if (check_value($id) && check_value($title) && is_array($items)) {
            $id = xss_clean($id);
            $title = xss_clean($title);
            $req_lvl = xss_clean($req_lvl);
            $req_mlvl = xss_clean($req_mlvl);
            $req_reset = xss_clean($req_reset);
            $req_greset = xss_clean($req_greset);
            $req_lvl_max = xss_clean($req_lvl_max);
            $req_mlvl_max = xss_clean($req_mlvl_max);
            $req_reset_max = xss_clean($req_reset_max);
            $req_greset_max = xss_clean($req_greset_max);
            $class = xss_clean($class);
            $type = xss_clean($type);
            if (empty($req_lvl)) {
                $req_lvl = 0;
            }
            if (empty($req_mlvl)) {
                $req_mlvl = 0;
            }
            if (empty($req_reset)) {
                $req_reset = 0;
            }
            if (empty($req_greset)) {
                $req_greset = 0;
            }
            if (empty($req_lvl_max)) {
                $req_lvl_max = 400;
            }
            if (empty($req_mlvl_max)) {
                $req_mlvl_max = 400;
            }
            if (empty($req_reset_max)) {
                $req_reset_max = 999;
            }
            if (empty($req_greset_max)) {
                $req_greset_max = 999;
            }
            if (empty($limit)) {
                $limit = 1;
            }
            $updateKit = $dB->query("UPDATE IMPERIAMUCMS_STARTING_KIT SET title = ?, req_lvl = ?, req_mlvl = ?, req_reset = ?, req_greset = ?, req_lvl_max = ?, req_mlvl_max = ?, req_reset_max = ?, req_greset_max = ?, req_class = ?, type = ?, limit = ? WHERE id = ?", [$title, $req_lvl, $req_mlvl, $req_reset, $req_greset, $req_lvl_max, $req_mlvl_max, $req_reset_max, $req_greset_max, $class, $type, $limit, $id]);
            if ($updateKit) {
                foreach ($items as $item) {
                    if ($item["item"] == __ITEM_EMPTY__ || $item["item"] == "" || $item["item"] == NULL) {
                        $dB->query("DELETE FROM IMPERIAMUCMS_STARTING_KIT_ITEMS WHERE id = ?", [$item["id"]]);
                    } else {
                        if (0 < $item["id"]) {
                            $dB->query("UPDATE IMPERIAMUCMS_STARTING_KIT_ITEMS SET item = ?, expiration = ? WHERE id = ?", [$item["item"], $item["expiration"], $item["id"]]);
                        } else {
                            $dB->query("INSERT INTO IMPERIAMUCMS_STARTING_KIT_ITEMS (kit_id, item, expiration) VALUES (?, ?, ?)", [$id, $item["item"], $item["expiration"]]);
                        }
                    }
                }
                message("success", "Starting Kit #" . $id . " was successfully updated.");
            } else {
                message("error", lang("error_23", true));
            }
        } else {
            message("error", lang("error_4", true));
        }
    }
    public function loadStartingKits($username, $char)
    {
        global $dB;
        if (check_value($username) && check_value($char)) {
            if (!check_value($username)) {
                message("error", lang("error_4", true));
            } else {
                if (!Validator::UsernameLength($username)) {
                    message("error", lang("error_5", true));
                } else {
                    if (!Validator::AlphaNumeric($username)) {
                        message("error", lang("error_6", true));
                    } else {
                        $checkAccount = $dB->query_fetch_single("SELECT COUNT(*) as total FROM IMPERIAMUCMS_STARTING_KIT_LOGS WHERE AccountID = ?", [$username]);
                        if ($checkAccount["total"] < mconfig("kits_per_account")) {
                            $Character = new Character();
                            if ($Character->CharacterExists($char) && $Character->CharacterBelongsToAccount($char, $username)) {
                                $checkChar = $dB->query_fetch_single("SELECT COUNT(*) as total FROM IMPERIAMUCMS_STARTING_KIT_LOGS WHERE AccountID = ? AND Name = ?", [$username, $char]);
                                if ($checkChar["total"] < mconfig("kits_per_character")) {
                                    $charData = $Character->CharacterData($char);
                                    if ($charData["cLevel"] == NULL) {
                                        $charData["cLevel"] = 0;
                                    }
                                    if ($charData["mLevel"] == NULL) {
                                        $charData["mLevel"] = 0;
                                    }
                                    if ($charData["RESETS"] == NULL) {
                                        $charData["RESETS"] = 0;
                                    }
                                    if ($charData["Grand_Resets"] == NULL) {
                                        $charData["Grand_Resets"] = 0;
                                    }
                                    $kits = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_STARTING_KIT WHERE req_lvl <= ? AND req_lvl_max >= ? AND req_mlvl <= ? AND req_mlvl_max >= ? AND req_reset <= ? AND req_reset_max >= ? AND req_greset <= ? AND req_greset_max >= ?", [$charData["cLevel"], $charData["cLevel"], $charData["mLevel"], $charData["mLevel"], $charData["RESETS"], $charData["RESETS"], $charData["Grand_Resets"], $charData["Grand_Resets"]]);
                                    if (is_array($kits) && !empty($kits)) {
                                        $i = 0;
                                        foreach ($kits as $kit) {
                                            $reqClassArray = explode(",", $kit["req_class"]);
                                            if (in_array($charData["Class"], $reqClassArray) !== false) {
                                                $return[$i]["id"] = $kit["id"];
                                                $return[$i]["title"] = $kit["title"];
                                                $return[$i]["type"] = $kit["type"];
                                                $return[$i]["limit"] = $kit["limit"];
                                                $i++;
                                            }
                                        }
                                        return $return;
                                    } else {
                                        message("error", lang("startingkit_txt_6", true));
                                    }
                                } else {
                                    message("error", lang("startingkit_txt_4", true));
                                }
                            } else {
                                message("error", lang("startingkit_txt_5", true));
                            }
                        } else {
                            message("error", lang("startingkit_txt_4", true));
                        }
                    }
                }
            }
        } else {
            message("error", lang("error_4", true));
        }
    }
    public function loadStartingKitItems($kit_id)
    {
        global $dB;
        if (is_numeric($kit_id)) {
            $items = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_STARTING_KIT_ITEMS WHERE kit_id = ?", [$kit_id]);
            if (is_array($items)) {
                return $items;
            }
        }
    }
    public function claimStartingKit($username, $char, $kit_id, $item_id = NULL)
    {
        global $dB;
        global $dB2;
        global $common;
        if (!Validator::UsernameLength($username)) {
            message("error", lang("error_5", true));
        } else {
            if (!Validator::AlphaNumeric($username)) {
                message("error", lang("error_6", true));
            } else {
                if ($item_id != NULL && !empty($item_id) && !Validator::UnsignedNumber($item_id)) {
                    message("error", lang("error_23", true) . "2");
                } else {
                    $kitData = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_STARTING_KIT WHERE id = ?", [$kit_id]);
                    $totalClaimed = $dB->query_fetch_single("SELECT COUNT(kit_id) as count FROM IMPERIAMUCMS_STARTING_KIT_LOGS WHERE kit_id = ? AND AccountID = ? AND Name = ?", [$kit_id, $username, $char]);
                    if (empty($totalClaimed["count"])) {
                        $totalClaimed["count"] = 0;
                    }
                    if ($totalClaimed["count"] < $kitData["limit"]) {
                        $charData = $dB->query_fetch_single("SELECT Name, cLevel, mLevel, RESETS, Grand_Resets FROM Character WHERE AccountID = ? AND Name = ?", [$username, $char]);
                        if ($kitData["req_lvl"] <= $charData["cLevel"] && $charData["cLevel"] <= $kitData["req_lvl_max"] && $kitData["req_mlvl"] <= $charData["mLevel"] && $charData["mLevel"] <= $kitData["req_mlvl_max"] && $kitData["req_reset"] <= $charData["RESETS"] && $charData["RESETS"] <= $kitData["req_reset_max"] && $kitData["req_greset"] <= $charData["Grand_Resets"] && $charData["Grand_Resets"] <= $kitData["req_greset_max"]) {
                            if (!$common->accountOnline($username)) {
                                $Market = new Market();
                                $Items = new Items();
                                $inventory = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT Inventory FROM Character WHERE AccountID = ? AND Name = ?), 2) AS inv", [$username, $char]);
                                $inventory = $inventory["inv"];
                                $inventoryNew = $inventory;
                                $i = 0;
                                $fullSerial = [];
                                $items = $this->loadStartingKitItems($kit_id);
                                if ($kitData["type"] == NULL) {
                                    $kitData["type"] = 2;
                                }
                                switch ($kitData["type"]) {
                                    case 1:
                                        $rewardItems[0] = $items[$item_id];
                                        break;
                                    case 2:
                                        $rewardItems = $items;
                                        break;
                                    case 3:
                                        $rand = rand(0, count($items) - 1);
                                        $rewardItems[0] = $items[$rand];
                                        break;
                                    default:
                                        foreach ($rewardItems as $thisItem) {
                                            $itemInfo = $Items->ItemInfo($thisItem["item"]);
                                            $test = 0;
                                            $slot = $Market->smartsearchInventory($username, $char, $inventoryNew, $itemInfo["X"], $itemInfo["Y"]);
                                            $test = $slot * __ITEM_LENGTH__;
                                            if ($slot == 1337) {
                                                message("error", lang("startingkit_txt_15", true));
                                                return false;
                                            }
                                            $serial = $dB->query_fetch_single("exec WZ_GetItemSerial2 1");
                                            $serial = $serial["ItemSerial"];
                                            $fullSerial[$i] = $serial;
                                            $serial = dechex($serial);
                                            while (strlen($serial) < 16) {
                                                $serial = "0" . $serial;
                                            }
                                            $serial2 = substr($serial, 0, 8);
                                            $serial = substr($serial, 8, 8);
                                            $thisItem["item"] = substr_replace($thisItem["item"], $serial2, 6, 8);
                                            $thisItem["item"] = substr_replace($thisItem["item"], $serial, 32, 8);
                                            if (0 < $thisItem["expiration"]) {
                                                $jog = hexdec(substr($thisItem["item"], 19, 1));
                                                $jog = $jog + 2;
                                                $thisItem["item"] = substr_replace($thisItem["item"], dechex($jog), 19, 1);
                                            }
                                            $inventoryNew = substr_replace($inventoryNew, $thisItem["item"], $test, __ITEM_LENGTH__);
                                            $i++;
                                        }
                                        if (config("SQL_USE_2_DB", true)) {
                                            $memb_guid = $dB2->query_fetch_single("SELECT memb_guid FROM MEMB_INFO WHERE memb___id = ?", [$username]);
                                        } else {
                                            $memb_guid = $dB->query_fetch_single("SELECT memb_guid FROM MEMB_INFO WHERE memb___id = ?", [$username]);
                                        }
                                        $inventoryNew = "0x" . $inventoryNew;
                                        $update = $dB->query("UPDATE [Character] SET [Inventory] = " . $inventoryNew . " WHERE [AccountID] = '" . $username . "' AND Name = '" . $char . "'");
                                        if ($update) {
                                            $i = 0;
                                            foreach ($items as $thisItem) {
                                                if (0 < $thisItem["expiration"]) {
                                                    $itemInfo = $Items->ItemInfo($thisItem["item"]);
                                                    $insert = $dB->query("exec IGC_PeriodItemInsertEx " . $memb_guid["memb_guid"] . ", '" . $char . "', 2, " . ($itemInfo["type"] * 512 + $itemInfo["id"]) . ", 0, 0, 0, " . $fullSerial[$i] . ", " . $thisItem["expiration"] * 60 . ", " . time() . ", " . (time() + $thisItem["expiration"] * 60) . "");
                                                }
                                                $i++;
                                            }
                                            $insert = $dB->query("INSERT INTO IMPERIAMUCMS_STARTING_KIT_LOGS (AccountID, Name, kit_id, date) VALUES (?, ?, ?, ?)", [$username, $char, $kit_id, date("Y-m-d H:i:s", time())]);
                                            message("success", lang("startingkit_txt_16", true));
                                        } else {
                                            message("error", lang("startingkit_txt_17", true));
                                        }
                                }
                            } else {
                                message("error", lang("error_14", true));
                            }
                        } else {
                            message("error", lang("startingkit_txt_22", true));
                        }
                    } else {
                        message("error", lang("startingkit_txt_21", true));
                    }
                }
            }
        }
    }
    public function activityRewardsCheckCharReq($username)
    {
        global $dB;
        if (!check_value($username)) {
            message("error", lang("error_4", true));
        } else {
            if (!Validator::UsernameLength($username)) {
                message("error", lang("error_5", true));
            } else {
                if (!Validator::AlphaNumeric($username)) {
                    message("error", lang("error_6", true));
                } else {
                    $charData = $dB->query_fetch_single("\r\n            SELECT TOP 1 AccountID, Name FROM Character \r\n            WHERE AccountID = ? AND  cLevel >= ? AND mLevel >= ? AND RESETS >= ? AND Grand_Resets >= ?\r\n            ORDER BY Grand_Resets DESC, RESETS DESC, mLevel DESC, cLevel DESC", [$username, mconfig("req_level"), mconfig("req_mlevel"), mconfig("req_reset"), mconfig("req_greset")]);
                    if (is_array($charData) && $charData["AccountID"] == $username) {
                        return true;
                    }
                    return false;
                }
            }
        }
    }
    public function loadActivityRewardStatus($username)
    {
        global $dB;
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
                    $return["period"] = 0;
                    $return["canClaim"] = 1;
                    $logs = $dB->query_fetch_single("SELECT TOP 1 id, AccountID, Date, Period FROM IMPERIAMUCMS_ACTIVITY_REWARDS_LOGS WHERE AccountID = ? ORDER BY Date DESC, Period DESC", [$username]);
                    if (is_array($logs)) {
                        $thisMidnight = date("Y-m-d 00:00:01", time());
                        if ($logs["Date"] < $thisMidnight) {
                            $currentDay = strtotime($thisMidnight);
                            $lastDay = strtotime($logs["Date"]);
                            $daysBetween = ceil(abs($currentDay - $lastDay) / 86400);
                            if (1 < $daysBetween) {
                                $return["period"] = 0;
                                $return["canClaim"] = 1;
                            } else {
                                $return["period"] = $logs["Period"];
                                $return["canClaim"] = 1;
                            }
                        } else {
                            $return["period"] = $logs["Period"];
                            $return["canClaim"] = 0;
                        }
                    }
                    return $return;
                }
            }
        }
    }
    public function loadActivityRewards($period)
    {
        global $dB;
        if ($period == NULL || $period == 0) {
            $period = 1;
        }
        $lowestPeriod = $period - 1;
        if ($lowestPeriod < 1) {
            $lowestPeriod = 1;
        }
        $highestPeriod = $period + 3;
        $rewards = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_ACTIVITY_REWARDS WHERE Status = 1 ORDER BY DayStart ASC");
        $filteredRewards = [];
        $i = 0;
        foreach ($rewards as $thisReward) {
            if ($thisReward["DayStart"] <= $period && $period <= $thisReward["DayEnd"]) {
                if (1 <= $i) {
                    $filteredRewards[1] = $thisReward;
                } else {
                    $filteredRewards[0] = $thisReward;
                }
                if ($i == 0) {
                    if ($rewards[1] != NULL) {
                        $filteredRewards[1] = $rewards[1];
                    }
                    if ($rewards[2] != NULL) {
                        $filteredRewards[2] = $rewards[2];
                    }
                    if ($rewards[3] != NULL) {
                        $filteredRewards[3] = $rewards[3];
                    }
                    if ($rewards[4] != NULL) {
                        $filteredRewards[4] = $rewards[4];
                    }
                } else {
                    $needAdd = true;
                    if ($rewards[$i - 1] != NULL) {
                        if ($rewards[$i - 1]["DayEnd"] < $period - 1) {
                            $needAdd = false;
                            $filteredRewards[0] = $filteredRewards[1];
                            if ($rewards[$i + 1] != NULL) {
                                $filteredRewards[1] = $rewards[$i + 1];
                            }
                            if ($rewards[$i + 2] != NULL) {
                                $filteredRewards[2] = $rewards[$i + 2];
                            }
                            if ($rewards[$i + 3] != NULL) {
                                $filteredRewards[3] = $rewards[$i + 3];
                            }
                            if ($rewards[$i + 4] != NULL) {
                                $filteredRewards[4] = $rewards[$i + 4];
                            }
                        } else {
                            $filteredRewards[0] = $rewards[$i - 1];
                        }
                    }
                    if ($needAdd) {
                        if ($rewards[$i + 1] != NULL) {
                            $filteredRewards[2] = $rewards[$i + 1];
                        }
                        if ($rewards[$i + 2] != NULL) {
                            $filteredRewards[3] = $rewards[$i + 2];
                        }
                        if ($rewards[$i + 3] != NULL) {
                            $filteredRewards[4] = $rewards[$i + 3];
                        }
                    }
                }
                ksort($filteredRewards);
                return $filteredRewards;
            }
            $i++;
        }
    }
    public function getLongestPeriod($username)
    {
        global $dB;
        if (!check_value($username)) {
            message("error", lang("error_4", true));
        } else {
            if (!Validator::UsernameLength($username)) {
                message("error", lang("error_5", true));
            } else {
                if (!Validator::AlphaNumeric($username)) {
                    message("error", lang("error_6", true));
                } else {
                    $logs = $dB->query_fetch_single("SELECT TOP 1 AccountID, Period FROM IMPERIAMUCMS_ACTIVITY_REWARDS_LOGS WHERE AccountID = ? ORDER BY Period DESC", [$username]);
                    if (is_array($logs)) {
                        return $logs["Period"];
                    }
                    return 0;
                }
            }
        }
    }
    public function checkLastOnlineActivityRewards($username)
    {
        global $dB;
        global $dB2;
        global $config;
        global $common;
        if (!check_value($username)) {
            message("error", lang("error_4", true));
        } else {
            if (!Validator::UsernameLength($username)) {
                message("error", lang("error_5", true));
            } else {
                if (!Validator::AlphaNumeric($username)) {
                    message("error", lang("error_6", true));
                } else {
                    if ($common->accountOnline($username)) {
                        return true;
                    }
                    $lastLoginHours = mconfig("req_hours");
                    $now = time();
                    $currentDateTime = date("Y-m-d H:i:s", $now);
                    $lastDateTime = date("Y-m-d H:i:s", $now - $lastLoginHours * 3600);
                    if (config("SQL_USE_2_DB", true)) {
                        $membStatData = $dB2->query_fetch_single("SELECT memb___id, ConnectTM, DisConnectTM FROM MEMB_STAT WHERE memb___id = ?", [$username]);
                    } else {
                        $membStatData = $dB->query_fetch_single("SELECT memb___id, ConnectTM, DisConnectTM FROM MEMB_STAT WHERE memb___id = ?", [$username]);
                    }
                    if ($lastDateTime <= $membStatData["ConnectTM"] || $lastDateTime <= $membStatData["DisConnectTM"]) {
                        return true;
                    }
                    return false;
                }
            }
        }
    }
    public function claimActivityReward($username, $charName)
    {
        global $dB;
        global $config;
        global $common;
        if (!isset($_SESSION["claimActivityReward"]) || $_SESSION["claimActivityReward"] != "true") {
            $_SESSION["claimActivityReward"] = "true";
            if (!check_value($username)) {
                message("error", lang("error_4", true));
                return NULL;
            }
            if (!Validator::UsernameLength($username)) {
                message("error", lang("error_5", true));
                return NULL;
            }
            if (!Validator::AlphaNumeric($username)) {
                message("error", lang("error_6", true));
                return NULL;
            }
            $charName = Decode($charName);
            if ($charName == ".x") {
                $charName = NULL;
            }
            if (10 < strlen($charName)) {
                message("error", lang("error_23", true));
                return NULL;
            }
            $adminName = "";
            foreach ($config["admins"] as $thisAdmin => $accessLevel) {
                if (100 <= $accessLevel) {
                    $adminName = $thisAdmin;
                    $rewardStatus = $this->loadActivityRewardStatus($username);
                    $claimPeriod = $rewardStatus["period"] + 1;
                    if ($rewardStatus["canClaim"] == "1") {
                        $reward = $dB->query_fetch_single("SELECT TOP 1 * FROM IMPERIAMUCMS_ACTIVITY_REWARDS WHERE DayStart <= ? AND (DayEnd >= ? OR DayEnd = 0) AND Status = 1", [$claimPeriod, $claimPeriod]);
                        $canProceedOnline = true;
                        $canProceedLevel = true;
                        $canProceedMasterLevel = true;
                        $canProceedReset = true;
                        $canProceedGrandReset = true;
                        $canProceedMonster = true;
                        if (0 < $reward["ReqTodayOnlineMinutes"] || 0 < $reward["ReqTodayLevels"] || 0 < $reward["ReqTodayMasterLevels"] || 0 < $reward["ReqTodayResets"] || 0 < $reward["ReqTodayGrandResets"] || 0 < $reward["ReqTodayKilledMonsters"]) {
                            if (0 < $reward["ReqTodayOnlineMinutes"]) {
                                $onlineTime = $dB->query_fetch_single("SELECT AccountID, OnlineTime FROM IMPERIAMUCMS_TRIGGER_ONLINE WHERE AccountID = ? AND Date = ?", [$username, date("Y-m-d", time())]);
                                if ($onlineTime != NULL && $reward["ReqTodayOnlineMinutes"] <= $onlineTime["OnlineTime"]) {
                                    $canProceedOnline = true;
                                } else {
                                    $canProceedOnline = false;
                                    message("error", sprintf(lang("activityrewards_30", true), $reward["ReqTodayOnlineMinutes"], number_format($reward["ReqTodayOnlineMinutes"] - $onlineTime["OnlineTime"])));
                                }
                            }
                            if (0 < $reward["ReqTodayLevels"] || 0 < $reward["ReqTodayMasterLevels"] || 0 < $reward["ReqTodayResets"] || 0 < $reward["ReqTodayGrandResets"]) {
                                $charProgress = $dB->query_fetch_single("SELECT SUM(cLevel) as level, SUM(mLevel) as mlevel, SUM(RESETS) as reset, SUM(Grand_Resets) as greset\r\n                            FROM IMPERIAMUCMS_TRIGGER_CHARACTER WHERE AccountID = ? AND Date = ?", [$username, date("Y-m-d", time())]);
                            }
                            if (0 < $reward["ReqTodayLevels"]) {
                                if ($charProgress != NULL && $reward["ReqTodayLevels"] <= $charProgress["level"]) {
                                    $canProceedLevel = true;
                                } else {
                                    $canProceedLevel = false;
                                    message("error", sprintf(lang("activityrewards_31", true), $reward["ReqTodayLevels"], number_format($reward["ReqTodayLevels"] - $charProgress["killedMonsters"])));
                                }
                            }
                            if (0 < $reward["ReqTodayMasterLevels"]) {
                                if ($charProgress != NULL && $reward["ReqTodayMasterLevels"] <= $charProgress["mlevel"]) {
                                    $canProceedMasterLevel = true;
                                } else {
                                    $canProceedMasterLevel = false;
                                    message("error", sprintf(lang("activityrewards_32", true), $reward["ReqTodayMasterLevels"], number_format($reward["ReqTodayMasterLevels"] - $charProgress["killedMonsters"])));
                                }
                            }
                            if (0 < $reward["ReqTodayResets"]) {
                                if ($charProgress != NULL && $reward["ReqTodayResets"] <= $charProgress["reset"]) {
                                    $canProceedReset = true;
                                } else {
                                    $canProceedReset = false;
                                    message("error", sprintf(lang("activityrewards_33", true), $reward["ReqTodayResets"], number_format($reward["ReqTodayResets"] - $charProgress["killedMonsters"])));
                                }
                            }
                            if (0 < $reward["ReqTodayGrandResets"]) {
                                if ($charProgress != NULL && $reward["ReqTodayGrandResets"] <= $charProgress["greset"]) {
                                    $canProceedGrandReset = true;
                                } else {
                                    $canProceedGrandReset = false;
                                    message("error", sprintf(lang("activityrewards_34", true), $reward["ReqTodayGrandResets"], number_format($reward["ReqTodayGrandResets"] - $charProgress["killedMonsters"])));
                                }
                            }
                            if (0 < $reward["ReqTodayKilledMonsters"]) {
                                $killedMonsters = $dB->query_fetch_single("SELECT SUM(Count) as killedMonsters FROM IMPERIAMUCMS_TRIGGER_MONSTER WHERE AccountID = ? AND Date = ?", [$username, date("Y-m-d", time())]);
                                if ($killedMonsters != NULL && $reward["ReqTodayKilledMonsters"] <= $killedMonsters["killedMonsters"]) {
                                    $canProceedMonster = true;
                                } else {
                                    $canProceedMonster = false;
                                    message("error", sprintf(lang("activityrewards_35", true), $reward["ReqTodayKilledMonsters"], number_format($reward["ReqTodayKilledMonsters"] - $killedMonsters["killedMonsters"])));
                                }
                            }
                        }
                        if ($canProceedOnline && $canProceedLevel && $canProceedMasterLevel && $canProceedReset && $canProceedGrandReset && $canProceedMonster) {
                            $insert2 = $dB->query("INSERT INTO IMPERIAMUCMS_ACTIVITY_REWARDS_LOGS (AccountID, Date, Period, Reward, RewardType, RewardItems, RewardItemsType)\r\n                VALUES (?, ?, ?, ?, ?, ?, ?)", [$username, date("Y-m-d H:i:s", time()), $claimPeriod, $reward["Reward"], $reward["RewardType"], $reward["RewardItems"], $reward["RewardItemsType"]]);
                            if (0 < $reward["Reward"] || $reward["RewardItems"] != NULL && $reward["RewardItems"] != "") {
                                $insert = $dB->query("\r\n                INSERT INTO IMPERIAMUCMS_CLAIM_REWARD (title, author, AccountID, Name, reward_items, reward_item_type, reward_amount, reward_amount_type, date, expiration, items_expiration)\r\n                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [lang("activityrewards_1", true) . " - " . $reward["Title"], $adminName, $username, $charName, $reward["RewardItems"], $reward["RewardItemsType"], $reward["Reward"], $reward["RewardType"], date("Y-m-d H:i:s", time()), NULL, NULL]);
                            } else {
                                $insert = true;
                            }
                            if ($insert) {
                                message("success", lang("activityrewards_14", true));
                                $logDate = date("Y-m-d H:i:s", time());
                                $common->accountLogs($username, "activityrewards", lang("activityrewards_16", true), $logDate);
                            } else {
                                message("error", lang("activityrewards_15", true));
                            }
                        }
                    } else {
                        message("error", lang("activityrewards_13", true));
                    }
                    $_SESSION["claimActivityReward"] = "false";
                }
            }
        }
    }
}

?>