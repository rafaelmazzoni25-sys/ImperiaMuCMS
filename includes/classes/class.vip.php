<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class Vip
{
    public function addPackage($title, $type, $currency, $price, $length, $length_type)
    {
        global $dB;
        if (check_value($title) && check_value($type) && check_value($currency) && check_value($price) && check_value($length) && check_value($length_type)) {
            if ($length < 1) {
                message("error", "Length of VIP must be at least 1 hour/day.");
                return NULL;
            }
            if ($price < 1) {
                message("error", "Price of VIP must be at least 1.");
                return NULL;
            }
            if ($length_type != "hours" && $length_type != "days") {
                message("error", "Invalid length type.");
                return NULL;
            }
            if ($type != "1" && $type != "2" && $type != "3" && $type != "4") {
                message("error", "Invalid VIP type.");
                return NULL;
            }
            if ($currency < 1 && 6 < $currency) {
                message("error", "Invalid currency type.");
                return NULL;
            }
            $hours = NULL;
            $days = NULL;
            if ($length_type == "hours") {
                $hours = $length;
            } else {
                if ($length_type == "days") {
                    $days = $length;
                }
            }
            $save = $dB->query("INSERT INTO IMPERIAMUCMS_VIP(name,type,currency,price,hours,days,active)\r\n                          VALUES(?,?,?,?,?,?,?)", [$title, $type, $currency, $price, $hours, $days, "1"]);
            if ($save) {
                message("success", "VIP Package Successfully Added!");
            } else {
                message("error", "There has been an error while adding the package.");
            }
        } else {
            message("error", "Missing data (complete all fields).");
        }
    }
    public function editPackage($id, $title, $type, $currency, $price, $length, $length_type)
    {
        global $dB;
        if (check_value($id) && check_value($title) && check_value($type) && check_value($currency) && check_value($price) && check_value($length) && check_value($length_type)) {
            if ($length < 1) {
                message("error", "Length of VIP must be at least 1 hour/day.");
                return NULL;
            }
            if ($price < 1) {
                message("error", "Price of VIP must be at least 1.");
                return NULL;
            }
            if ($length_type != "hours" && $length_type != "days") {
                message("error", "Invalid length type.");
                return NULL;
            }
            if ($type != "1" && $type != "2" && $type != "3" && $type != "4") {
                message("error", "Invalid VIP type.");
                return NULL;
            }
            if ($currency < 1 && 6 < $currency) {
                message("error", "Invalid currency type.");
                return NULL;
            }
            $hours = NULL;
            $days = NULL;
            if ($length_type == "hours") {
                $hours = $length;
            } else {
                if ($length_type == "days") {
                    $days = $length;
                }
            }
            $save = $dB->query("UPDATE IMPERIAMUCMS_VIP SET name=?, type=?, currency=?, price=?, hours=?, days=? WHERE id = '" . $id . "'", [$title, $type, $currency, $price, $hours, $days]);
            if ($save) {
                message("success", "VIP Package Successfully Edited!");
            } else {
                message("error", "There has been an error while editing the package.");
            }
        } else {
            message("error", "Missing data (complete all fields).");
        }
    }
    public function deletePackage($id)
    {
        global $dB;
        if (check_value($id)) {
            $delete = $dB->query("DELETE FROM IMPERIAMUCMS_VIP WHERE id = '" . $id . "'");
            if ($delete) {
                message("success", "VIP Package Successfully Deleted!");
            } else {
                message("error", "There has been an error while deleting the package.");
            }
        } else {
            message("error", "Missing data (complete all fields).");
        }
    }
    public function editCategory($id, $title, $position, $currency)
    {
        global $dB;
        if (check_value($id) && check_value($title) && check_value($position) && check_value($currency)) {
            if ($currency < 1 && 6 < $currency) {
                message("error", "Invalid currency type.");
                return NULL;
            }
            $save = $dB->query("UPDATE IMPERIAMUCMS_VIP_CATEGORIES SET name = ?, position = ?, currency=? WHERE id = ?", [$title, $position, $currency, $id]);
            if ($save) {
                message("success", "VIP Category Successfully Edited!");
            } else {
                message("error", "There has been an error while editing the category.");
            }
        } else {
            message("error", "Missing data (complete all fields).");
        }
    }
    public function buyVip($username, $id)
    {
        global $dB;
        global $dB2;
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
                    $id = Decode($id);
                    $error = false;
                    $vipPackage = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_VIP WHERE id = ?", [$id]);
                    if (config("SQL_USE_2_DB", true)) {
                        $vipData = $dB2->query_fetch_single("SELECT * FROM T_VIPList WHERE AccountID = ?", [$username]);
                    } else {
                        $vipData = $dB->query_fetch_single("SELECT * FROM T_VIPList WHERE AccountID = ?", [$username]);
                    }
                    if ($vipData == NULL || empty($vipData)) {
                        if (config("SQL_USE_2_DB", true)) {
                            $dB2->query("INSERT INTO T_VIPList(AccountID,Date,Type) VALUES(?,?,?)", [$username, NULL, NULL]);
                        } else {
                            $dB->query("INSERT INTO T_VIPList(AccountID,Date,Type) VALUES(?,?,?)", [$username, NULL, NULL]);
                        }
                    }
                    $currName = "";
                    $tableName = "";
                    $identName = "";
                    if ($vipPackage["currency"] == "3") {
                        $currName = "silver";
                        $tableName = "MEMB_CREDITS";
                        $identName = "memb___id";
                        if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                            $checkCurrency = $dB2->query_fetch_single("SELECT silver FROM MEMB_CREDITS WHERE memb___id = ?", [$username]);
                        } else {
                            $checkCurrency = $dB->query_fetch_single("SELECT silver FROM MEMB_CREDITS WHERE memb___id = ?", [$username]);
                        }
                        if ($checkCurrency["silver"] < $vipPackage["price"]) {
                            $error = true;
                            message("error", sprintf(lang("vip_txt_12", true), lang("currency_silver", true)));
                        }
                    } else {
                        if ($vipPackage["currency"] == "2") {
                            $currName = "gold";
                            $tableName = "MEMB_CREDITS";
                            $identName = "memb___id";
                            if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                $checkCurrency = $dB2->query_fetch_single("SELECT gold FROM MEMB_CREDITS WHERE memb___id = ?", [$username]);
                            } else {
                                $checkCurrency = $dB->query_fetch_single("SELECT gold FROM MEMB_CREDITS WHERE memb___id = ?", [$username]);
                            }
                            if ($checkCurrency["gold"] < $vipPackage["price"]) {
                                $error = true;
                                message("error", sprintf(lang("vip_txt_12", true), lang("currency_gold", true)));
                            }
                        } else {
                            if ($vipPackage["currency"] == "1") {
                                $currName = "platinum";
                                $tableName = "MEMB_CREDITS";
                                $identName = "memb___id";
                                if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                    $checkCurrency = $dB2->query_fetch_single("SELECT platinum FROM MEMB_CREDITS WHERE memb___id = ?", [$username]);
                                } else {
                                    $checkCurrency = $dB->query_fetch_single("SELECT platinum FROM MEMB_CREDITS WHERE memb___id = ?", [$username]);
                                }
                                if ($checkCurrency["platinum"] < $vipPackage["price"]) {
                                    $error = true;
                                    message("error", sprintf(lang("vip_txt_12", true), lang("currency_platinum", true)));
                                }
                            } else {
                                if ($vipPackage["currency"] == "4") {
                                    if (100 <= config("server_files_season", true)) {
                                        $currName = "WCoin";
                                        $tableName = "T_InGameShop_Point";
                                        $identName = "AccountID";
                                        $checkCurrency = $dB->query_fetch_single("SELECT WCoin FROM T_InGameShop_Point WHERE AccountID = ?", [$username]);
                                        if ($checkCurrency["WCoin"] < $vipPackage["price"]) {
                                            $error = true;
                                            message("error", sprintf(lang("vip_txt_12", true), lang("currency_wcoinc", true)));
                                        }
                                    } else {
                                        $currName = "WCoinC";
                                        $tableName = "T_InGameShop_Point";
                                        $identName = "AccountID";
                                        $checkCurrency = $dB->query_fetch_single("SELECT WCoinC FROM T_InGameShop_Point WHERE AccountID = ?", [$username]);
                                        if ($checkCurrency["WCoinC"] < $vipPackage["price"]) {
                                            $error = true;
                                            message("error", sprintf(lang("vip_txt_12", true), lang("currency_wcoinc", true)));
                                        }
                                    }
                                } else {
                                    if ($vipPackage["currency"] == "5") {
                                        $currName = "GoblinPoint";
                                        $tableName = "T_InGameShop_Point";
                                        $identName = "AccountID";
                                        $checkCurrency = $dB->query_fetch_single("SELECT GoblinPoint FROM T_InGameShop_Point WHERE AccountID = ?", [$username]);
                                        if ($checkCurrency["GoblinPoint"] < $vipPackage["price"]) {
                                            $error = true;
                                            message("error", sprintf(lang("vip_txt_12", true), lang("currency_gp", true)));
                                        }
                                    } else {
                                        if ($vipPackage["currency"] == "6") {
                                            $currName = "zen";
                                            $tableName = "IMPERIAMUCMS_WEB_BANK";
                                            $identName = "AccountID";
                                            $checkCurrency = $dB->query_fetch_single("SELECT zen FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$username]);
                                            if ($checkCurrency["zen"] < $vipPackage["price"]) {
                                                $error = true;
                                                message("error", sprintf(lang("vip_txt_12", true), "" . lang("currency_zen", true) . ""));
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    if ($common->accountOnline($username)) {
                        $error = true;
                        message("error", lang("vip_txt_13", true));
                    }
                    if (!$error) {
                        if ($vipData == NULL || empty($vipData) || strtotime($vipData["Date"]) < time() || $vipData["Date"] == NULL) {
                            if ($vipPackage["hours"] != NULL) {
                                $time = time() + $vipPackage["hours"] * 3600;
                            } else {
                                $time = time() + $vipPackage["days"] * 3600 * 24;
                            }
                            $date = date("Y-m-d H:i:s", $time);
                            if (config("SQL_USE_2_DB", true)) {
                                $update = $dB2->query("UPDATE T_VIPList SET Type = ?, Date = ? WHERE AccountID = ?", [$vipPackage["type"], $date, $username]);
                            } else {
                                $update = $dB->query("UPDATE T_VIPList SET Type = ?, Date = ? WHERE AccountID = ?", [$vipPackage["type"], $date, $username]);
                            }
                            if ($vipPackage["currency"] == 1 || $vipPackage["currency"] == 2 || $vipPackage["currency"] == 3) {
                                if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                    $update2 = $dB2->query("UPDATE " . $tableName . " SET " . $currName . " = " . $currName . " - ?, " . $currName . "_used = " . $currName . "_used + ?  WHERE " . $identName . " = ?", [$vipPackage["price"], $vipPackage["price"], $username]);
                                } else {
                                    $update2 = $dB->query("UPDATE " . $tableName . " SET " . $currName . " = " . $currName . " - ?, " . $currName . "_used = " . $currName . "_used + ?  WHERE " . $identName . " = ?", [$vipPackage["price"], $vipPackage["price"], $username]);
                                }
                            } else {
                                $update2 = $dB->query("UPDATE " . $tableName . " SET " . $currName . " = " . $currName . " - ?  WHERE " . $identName . " = ?", [$vipPackage["price"], $username]);
                            }
                        } else {
                            if (time() < strtotime($vipData["Date"]) && $vipPackage["type"] == $vipData["Type"]) {
                                if ($vipPackage["hours"] != NULL) {
                                    $time = strtotime($vipData["Date"]) + $vipPackage["hours"] * 3600;
                                } else {
                                    $time = strtotime($vipData["Date"]) + $vipPackage["days"] * 3600 * 24;
                                }
                                $date = date("Y-m-d H:i:s", $time);
                                if (config("SQL_USE_2_DB", true)) {
                                    $update = $dB2->query("UPDATE T_VIPList SET Type = ?, Date = ? WHERE AccountID = ?", [$vipPackage["type"], $date, $username]);
                                } else {
                                    $update = $dB->query("UPDATE T_VIPList SET Type = ?, Date = ? WHERE AccountID = ?", [$vipPackage["type"], $date, $username]);
                                }
                                if ($vipPackage["currency"] == 1 || $vipPackage["currency"] == 2 || $vipPackage["currency"] == 3) {
                                    if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                        $update2 = $dB2->query("UPDATE " . $tableName . " SET " . $currName . " = " . $currName . " - ?, " . $currName . "_used = " . $currName . "_used + ?  WHERE " . $identName . " = ?", [$vipPackage["price"], $vipPackage["price"], $username]);
                                    } else {
                                        $update2 = $dB->query("UPDATE " . $tableName . " SET " . $currName . " = " . $currName . " - ?, " . $currName . "_used = " . $currName . "_used + ?  WHERE " . $identName . " = ?", [$vipPackage["price"], $vipPackage["price"], $username]);
                                    }
                                } else {
                                    $update2 = $dB->query("UPDATE " . $tableName . " SET " . $currName . " = " . $currName . " - ?  WHERE " . $identName . " = ?", [$vipPackage["price"], $username]);
                                }
                            }
                        }
                        if ($update && $update2) {
                            message("success", lang("vip_txt_14", true));
                            $logDate = date("Y-m-d H:i:s", time());
                            if ($vipPackage["type"] == 1) {
                                $vipTypeName = "Bronze";
                            } else {
                                if ($vipPackage["type"] == 2) {
                                    $vipTypeName = "Silver";
                                } else {
                                    if ($vipPackage["type"] == 3) {
                                        $vipTypeName = "Gold";
                                    } else {
                                        if ($vipPackage["type"] == 4) {
                                            $vipTypeName = "Platinum";
                                        }
                                    }
                                }
                            }
                            if ($vipPackage["hours"] != NULL) {
                                $length = $vipPackage["hours"] . " " . lang("vip_txt_15", true);
                            } else {
                                $length = $vipPackage["days"] . " " . lang("vip_txt_16", true);
                            }
                            if ($vipPackage["currency"] == "1") {
                                $vipPriceLog = $vipPackage["price"] . " " . lang("currency_platinum", true);
                            } else {
                                if ($vipPackage["currency"] == "2") {
                                    $vipPriceLog = $vipPackage["price"] . " " . lang("currency_gold", true);
                                } else {
                                    if ($vipPackage["currency"] == "3") {
                                        $vipPriceLog = $vipPackage["price"] . " " . lang("currency_silver", true);
                                    } else {
                                        if ($vipPackage["currency"] == "4") {
                                            $vipPriceLog = $vipPackage["price"] . " " . lang("currency_wcoinc", true);
                                        } else {
                                            if ($vipPackage["currency"] == "5") {
                                                $vipPriceLog = $vipPackage["price"] . " " . lang("currency_gp", true);
                                            } else {
                                                if ($vipPackage["currency"] == "6") {
                                                    $vipPriceLog = $vipPackage["price"] . " " . lang("currency_zen", true) . "";
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                            $common->accountLogs($username, "vip", sprintf(lang("vip_txt_17", true), $vipTypeName, $length, $vipPriceLog), $logDate);
                            $dB->query("INSERT INTO IMPERIAMUCMS_VIP_LOGS(AccountID,package_id,type,length,price,date) VALUES(?,?,?,?,?,?)", [$username, $id, $vipTypeName, $length, $vipPriceLog, $logDate]);
                        } else {
                            message("error", lang("error_23", true));
                        }
                    }
                }
            }
        }
    }
}

?>