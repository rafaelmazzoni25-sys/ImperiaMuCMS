<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class Lottery
{
    public function getMyTickets($username, $lottery_id)
    {
        global $dB;
        if (check_value($username) && check_value($lottery_id)) {
            if (!Validator::UsernameLength($username)) {
                message("error", lang("error_23", true));
            } else {
                if (!Validator::AlphaNumeric($username)) {
                    message("error", lang("error_23", true));
                } else {
                    if (!Validator::UnsignedNumber($lottery_id)) {
                        message("error", lang("error_23", true));
                    } else {
                        $tickets = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_LOTTERY_TICKETS WHERE AccountID = ? AND lottery_id = ?", [$username, $lottery_id]);
                        if (is_array($tickets)) {
                            return $tickets;
                        }
                        return NULL;
                    }
                }
            }
        } else {
            message("error", lang("error_23", true));
        }
    }
    public function getLotteryNumber()
    {
        global $dB;
        $lottery_id = $dB->query_fetch_single("SELECT TOP 1 * FROM IMPERIAMUCMS_LOTTERY ORDER BY id DESC");
        if ($lottery_id["lottery"] == NULL) {
            $lottery_id = 1;
        } else {
            $lottery_id = $lottery_id["lottery"] + 1;
        }
        return $lottery_id;
    }
    public function getLatestDrawns()
    {
        global $dB;
        $lotteries = $dB->query_fetch("SELECT TOP " . mconfig("lottery_history") . " * FROM IMPERIAMUCMS_LOTTERY ORDER BY id DESC");
        if (is_array($lotteries)) {
            return $lotteries;
        }
        return NULL;
    }
    public function compareNumbers($username, $lottery_id, $ticket_id)
    {
        global $dB;
        if (check_value($username) && check_value($lottery_id) && check_value($ticket_id)) {
            if (!Validator::UsernameLength($username)) {
                message("error", lang("error_23", true));
            } else {
                if (!Validator::AlphaNumeric($username)) {
                    message("error", lang("error_23", true));
                } else {
                    if (!Validator::UnsignedNumber($lottery_id)) {
                        message("error", lang("error_23", true));
                    } else {
                        if (!Validator::UnsignedNumber($ticket_id)) {
                            message("error", lang("error_23", true));
                        } else {
                            $ticketData = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_LOTTERY_TICKETS WHERE AccountID = ? AND lottery_id = ? AND id = ?", [$username, $lottery_id, $ticket_id]);
                            $lotteryData = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_LOTTERY WHERE lottery = ?", [$lottery_id]);
                            $winningNumbers = [1 => $lotteryData["num1"], 2 => $lotteryData["num2"], 3 => $lotteryData["num3"], 4 => $lotteryData["num4"], 5 => $lotteryData["num5"], 6 => $lotteryData["num6"]];
                            $returnNumbers = [1 => $ticketData["num1"], 2 => $ticketData["num2"], 3 => $ticketData["num3"], 4 => $ticketData["num4"], 5 => $ticketData["num5"], 6 => $ticketData["num6"]];
                            if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
                                $i = 1;
                                while ($i <= 6) {
                                    if (array_search($returnNumbers[$i], $winningNumbers)) {
                                        $returnNumbers[$i] = "<span class=\"lottery-win-num\">" . $returnNumbers[$i] . "</span>";
                                    } else {
                                        $returnNumbers[$i] = "<span class=\"lottery-lose-num\">" . $returnNumbers[$i] . "</span>";
                                    }
                                    $i++;
                                }
                            } else {
                                $i = 1;
                                while ($i <= 6) {
                                    if (array_search($returnNumbers[$i], $winningNumbers)) {
                                        $returnNumbers[$i] = "<span style=\"color: #008800; font-size: 20px; font-weight: bold;\">" . $returnNumbers[$i] . "</span>";
                                    } else {
                                        $returnNumbers[$i] = "<span style=\"color: #880000; font-size: 12px; font-weight: bold;\">" . $returnNumbers[$i] . "</span>";
                                    }
                                    $i++;
                                }
                            }
                            return $returnNumbers;
                        }
                    }
                }
            }
        } else {
            message("error", lang("error_23", true));
        }
    }
    public function checkTicket($array_ticket_numbers, $array_lottery_numbers)
    {
        $match = 0;
        $i = 1;
        while ($i <= 6) {
            if (array_search($array_ticket_numbers[$i], $array_lottery_numbers)) {
                $match++;
            }
            $i++;
        }
        return $match;
    }
    public function lotteryPeriod()
    {
        global $dB;
        global $config;
        if (mconfig("lottery_length") == "7" || mconfig("lottery_length") == "14") {
            if (date("Y-m-d", time()) < mconfig("lottery_start")) {
                return sprintf(lang("lottery_txt_25", true), date($config["date_format"], strtotime(mconfig("lottery_start"))));
            }
            $lastLottery = $dB->query_fetch_single("SELECT TOP 1 * FROM IMPERIAMUCMS_LOTTERY ORDER BY id DESC");
            if ($lastLottery["end"] == NULL) {
                $lastLottery["end"] = mconfig("lottery_start");
            }
            $endsOn = date($config["date_format"], strtotime($lastLottery["end"]) + 86400 * mconfig("lottery_length"));
            return sprintf(lang("lottery_txt_24", true), $endsOn);
        }
        $dateFormat = $config["date_format"];
        $dateFormat = str_replace("j", "t", $dateFormat);
        $dateFormat = str_replace("d", "t", $dateFormat);
        return sprintf(lang("lottery_txt_25", true), date($dateFormat, time()));
    }
    public function canSubmitTicket($username)
    {
        global $dB;
        if (check_value($username)) {
            if (!Validator::UsernameLength($username)) {
                message("error", lang("error_23", true));
            } else {
                if (!Validator::AlphaNumeric($username)) {
                    message("error", lang("error_23", true));
                } else {
                    if (mconfig("lottery_length") == "7" || mconfig("lottery_length") == "14") {
                        if (mconfig("lottery_start") <= date("Y-m-d", time())) {
                            $lottery_id = $this->getLotteryNumber();
                            $totalTickets = $dB->query_fetch_single("SELECT COUNT(*) AS count FROM IMPERIAMUCMS_LOTTERY_TICKETS WHERE AccountID = ? AND lottery_id = ?", [$username, $lottery_id]);
                            if ($totalTickets["count"] < mconfig("lottery_ticket_limit")) {
                                return true;
                            }
                            return false;
                        }
                        return false;
                    }
                    $lottery_id = $this->getLotteryNumber();
                    $totalTickets = $dB->query_fetch_single("SELECT COUNT(*) AS count FROM IMPERIAMUCMS_LOTTERY_TICKETS WHERE AccountID = ? AND lottery_id = ?", [$username]);
                    if ($totalTickets["count"] < mconfig("lottery_ticket_limit")) {
                        return true;
                    }
                    return false;
                }
            }
        } else {
            message("error", lang("error_23", true));
        }
    }
    public function submitTicket($username, $num1, $num2, $num3, $num4, $num5, $num6)
    {
        global $dB;
        global $dB2;
        global $common;
        $num1 = xss_clean($num1);
        $num2 = xss_clean($num2);
        $num3 = xss_clean($num3);
        $num4 = xss_clean($num4);
        $num5 = xss_clean($num5);
        $num6 = xss_clean($num6);
        if (check_value($username) && check_value($num1) && check_value($num2) && check_value($num3) && check_value($num4) && check_value($num5) && check_value($num6)) {
            if (!Validator::UsernameLength($username)) {
                message("error", lang("error_23", true));
                return NULL;
            }
            if (!Validator::AlphaNumeric($username)) {
                message("error", lang("error_23", true));
                return NULL;
            }
            if (!is_numeric($num1) || !is_numeric($num2) || !is_numeric($num3) || !is_numeric($num4) || !is_numeric($num5) || !is_numeric($num6)) {
                message("error", lang("lottery_txt_13", true));
                return NULL;
            }
            if ($num1 == $num2 || $num1 == $num3 || $num1 == $num4 || $num1 == $num5 || $num1 == $num6 || $num2 == $num3 || $num2 == $num4 || $num2 == $num5 || $num2 == $num6 || $num3 == $num4 || $num3 == $num5 || $num3 == $num6 || $num4 == $num5 || $num4 == $num6 || $num5 == $num6) {
                message("error", lang("lottery_txt_14", true));
                return NULL;
            }
            if ($num1 < mconfig("lottery_min_num") || mconfig("lottery_max_num") < $num1) {
                message("error", sprintf(lang("lottery_txt_15", true), mconfig("lottery_min_num"), mconfig("lottery_max_num")));
                return NULL;
            }
            if ($num2 < mconfig("lottery_min_num") || mconfig("lottery_max_num") < $num2) {
                message("error", sprintf(lang("lottery_txt_15", true), mconfig("lottery_min_num"), mconfig("lottery_max_num")));
                return NULL;
            }
            if ($num3 < mconfig("lottery_min_num") || mconfig("lottery_max_num") < $num3) {
                message("error", sprintf(lang("lottery_txt_15", true), mconfig("lottery_min_num"), mconfig("lottery_max_num")));
                return NULL;
            }
            if ($num4 < mconfig("lottery_min_num") || mconfig("lottery_max_num") < $num4) {
                message("error", sprintf(lang("lottery_txt_15", true), mconfig("lottery_min_num"), mconfig("lottery_max_num")));
                return NULL;
            }
            if ($num5 < mconfig("lottery_min_num") || mconfig("lottery_max_num") < $num5) {
                message("error", sprintf(lang("lottery_txt_15", true), mconfig("lottery_min_num"), mconfig("lottery_max_num")));
                return NULL;
            }
            if ($num6 < mconfig("lottery_min_num") || mconfig("lottery_max_num") < $num6) {
                message("error", sprintf(lang("lottery_txt_15", true), mconfig("lottery_min_num"), mconfig("lottery_max_num")));
                return NULL;
            }
            $totalTickets = $dB->query_fetch_single("SELECT COUNT(*) AS count FROM IMPERIAMUCMS_LOTTERY_TICKETS WHERE AccountID = ? AND lottery_id = ?", [$username, $this->getLotteryNumber()]);
            if (mconfig("lottery_ticket_limit") <= $totalTickets["count"]) {
                message("error", lang("lottery_txt_17", true));
                return NULL;
            }
            $return = [];
            mconfig("lottery_ticket_price_type");
            switch (mconfig("lottery_ticket_price_type")) {
                case 1:
                    $return["column"] = "platinum";
                    $return["table"] = "MEMB_CREDITS";
                    $return["ident"] = "memb___id";
                    $return["name"] = lang("currency_platinum", true);
                    break;
                case 2:
                    $return["column"] = "gold";
                    $return["table"] = "MEMB_CREDITS";
                    $return["ident"] = "memb___id";
                    $return["name"] = lang("currency_gold", true);
                    break;
                case 3:
                    $return["column"] = "silver";
                    $return["table"] = "MEMB_CREDITS";
                    $return["ident"] = "memb___id";
                    $return["name"] = lang("currency_silver", true);
                    break;
                case 4:
                    if (100 <= config("server_files_season", true)) {
                        $return["column"] = "WCoin";
                    } else {
                        $return["column"] = "WCoinC";
                    }
                    $return["table"] = "T_InGameShop_Point";
                    $return["ident"] = "AccountID";
                    $return["name"] = lang("currency_wcoinc", true);
                    break;
                case 5:
                    $return["column"] = "GoblinPoint";
                    $return["table"] = "T_InGameShop_Point";
                    $return["ident"] = "AccountID";
                    $return["name"] = lang("currency_gp", true);
                    break;
                case 6:
                    $return["column"] = "zen";
                    $return["table"] = "IMPERIAMUCMS_WEB_BANK";
                    $return["ident"] = "AccountID";
                    $return["name"] = "" . lang("currency_zen", true) . "";
                    break;
                default:
                    if (config("MEMB_CREDITS_MEMUONLINE", true) && ($return["column"] == "platinum" || $return["column"] == "gold" || $return["column"] == "silver")) {
                        $checkCurrency = $dB2->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$username]);
                    } else {
                        $checkCurrency = $dB->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$username]);
                    }
                    if ($checkCurrency[$return["column"]] < mconfig("lottery_ticket_price")) {
                        message("error", sprintf(lang("lottery_txt_18", true), $return["name"]));
                        return NULL;
                    }
                    $numbers = [$num1, $num2, $num3, $num4, $num5, $num6];
                    sort($numbers);
                    list($num1, $num2, $num3, $num4, $num5, $num6) = $numbers;
                    $lottery_id = $this->getLotteryNumber();
                    $insert = $dB->query("INSERT INTO IMPERIAMUCMS_LOTTERY_TICKETS (AccountID, date, num1, num2, num3, num4, num5, num6, price, price_type, lottery_id)\r\n                                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$username, date("Y-m-d H:i:s", time()), $num1, $num2, $num3, $num4, $num5, $num6, mconfig("lottery_ticket_price"), mconfig("lottery_ticket_price_type"), $lottery_id]);
                    if (mconfig("lottery_ticket_price_type") < 4) {
                        $update = $dB->query("UPDATE " . $return["table"] . " SET " . $return["column"] . " = " . $return["column"] . " - ?, " . $return["column"] . "_used = " . $return["column"] . "_used + ? WHERE " . $return["ident"] . " = ?", [mconfig("lottery_ticket_price"), mconfig("lottery_ticket_price"), $username]);
                    } else {
                        $update = $dB->query("UPDATE " . $return["table"] . " SET " . $return["column"] . " = " . $return["column"] . " - ? WHERE " . $return["ident"] . " = ?", [mconfig("lottery_ticket_price"), $username]);
                    }
                    if ($insert && $update) {
                        message("success", sprintf(lang("lottery_txt_20", true), $lottery_id, mconfig("lottery_ticket_price"), $return["name"]));
                        $logDate = date("Y-m-d H:i:s", time());
                        $common->accountLogs($username, "lottery", sprintf(lang("lottery_txt_19", true), $lottery_id, mconfig("lottery_ticket_price"), $return["name"]), $logDate);
                    } else {
                        message("error", lang("error_23", true));
                    }
            }
        } else {
            message("error", lang("error_23", true));
        }
    }
    public function hasReward($username, $lottery_id)
    {
        global $dB;
        if (check_value($username) && check_value($lottery_id)) {
            if (!Validator::UsernameLength($username)) {
                message("error", lang("error_23", true));
            } else {
                if (!Validator::AlphaNumeric($username)) {
                    message("error", lang("error_23", true));
                } else {
                    if (!Validator::UnsignedNumber($lottery_id)) {
                        message("error", lang("error_23", true));
                    } else {
                        $check = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_LOTTERY_WINNERS WHERE AccountID = ? AND lottery_id = ? AND status = ?", [$username, $lottery_id, 0]);
                        if ($check["AccountID"] != NULL) {
                            return true;
                        }
                        return false;
                    }
                }
            }
        } else {
            message("error", lang("error_23", true));
        }
    }
    public function getRewardAmount($username, $lottery_id)
    {
        global $dB;
        if (check_value($username) && check_value($lottery_id)) {
            if (!Validator::UsernameLength($username)) {
                message("error", lang("error_23", true));
            } else {
                if (!Validator::AlphaNumeric($username)) {
                    message("error", lang("error_23", true));
                } else {
                    if (!Validator::UnsignedNumber($lottery_id)) {
                        message("error", lang("error_23", true));
                    } else {
                        $check = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_LOTTERY_WINNERS WHERE AccountID = ? AND lottery_id = ? AND status = ?", [$username, $lottery_id, 0]);
                        if ($check["AccountID"] != NULL) {
                            if ($check["reward_type"] == 1) {
                                $rewardName = lang("currency_platinum", true);
                            } else {
                                if ($check["reward_type"] == 2) {
                                    $rewardName = lang("currency_gold", true);
                                } else {
                                    if ($check["reward_type"] == 3) {
                                        $rewardName = lang("currency_silver", true);
                                    } else {
                                        if ($check["reward_type"] == 4) {
                                            $rewardName = lang("currency_wcoinc", true);
                                        } else {
                                            if ($check["reward_type"] == 5) {
                                                $rewardName = lang("currency_gp", true);
                                            } else {
                                                if ($check["reward_type"] == 6) {
                                                    $rewardName = "" . lang("currency_zen", true) . "";
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                            return $check["reward"] . " " . $rewardName;
                        }
                        return NULL;
                    }
                }
            }
        } else {
            message("error", lang("error_23", true));
        }
    }
    public function getLotteryTickets($lottery_id)
    {
        global $dB;
        if (check_value($lottery_id)) {
            if (!Validator::UnsignedNumber($lottery_id)) {
                message("error", lang("error_23", true));
            } else {
                $tickets = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_LOTTERY_TICKETS WHERE lottery_id = ?", [$lottery_id]);
                if (is_array($tickets)) {
                    return $tickets;
                }
                return NULL;
            }
        } else {
            message("error", lang("error_23", true));
        }
    }
    public function claimReward($username, $lottery_id)
    {
        global $dB;
        global $dB2;
        global $common;
        if (check_value($username) && check_value($lottery_id)) {
            if (!Validator::UsernameLength($username)) {
                message("error", lang("error_23", true));
                return NULL;
            }
            if (!Validator::AlphaNumeric($username)) {
                message("error", lang("error_23", true));
                return NULL;
            }
            if (!Validator::UnsignedNumber($lottery_id)) {
                message("error", lang("error_23", true));
                return NULL;
            }
            if ($this->hasReward($username, $lottery_id)) {
                $rewardData = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_LOTTERY_WINNERS WHERE AccountID = ? AND lottery_id = ?", [$username, $lottery_id]);
                $return = [];
                switch ($rewardData["reward_type"]) {
                    case 1:
                        $return["column"] = "platinum";
                        $return["table"] = "MEMB_CREDITS";
                        $return["ident"] = "memb___id";
                        $return["name"] = lang("currency_platinum", true);
                        break;
                    case 2:
                        $return["column"] = "gold";
                        $return["table"] = "MEMB_CREDITS";
                        $return["ident"] = "memb___id";
                        $return["name"] = lang("currency_gold", true);
                        break;
                    case 3:
                        $return["column"] = "silver";
                        $return["table"] = "MEMB_CREDITS";
                        $return["ident"] = "memb___id";
                        $return["name"] = lang("currency_silver", true);
                        break;
                    case 4:
                        if (100 <= config("server_files_season", true)) {
                            $return["column"] = "WCoin";
                        } else {
                            $return["column"] = "WCoinC";
                        }
                        $return["table"] = "T_InGameShop_Point";
                        $return["ident"] = "AccountID";
                        $return["name"] = lang("currency_wcoinc", true);
                        break;
                    case 5:
                        $return["column"] = "GoblinPoint";
                        $return["table"] = "T_InGameShop_Point";
                        $return["ident"] = "AccountID";
                        $return["name"] = lang("currency_gp", true);
                        break;
                    case 6:
                        $return["column"] = "zen";
                        $return["table"] = "IMPERIAMUCMS_WEB_BANK";
                        $return["ident"] = "AccountID";
                        $return["name"] = "" . lang("currency_zen", true) . "";
                        break;
                    default:
                        if (config("MEMB_CREDITS_MEMUONLINE", true) && ($return["column"] == "platinum" || $return["column"] == "gold" || $return["column"] == "silver")) {
                            $update = $dB2->query("UPDATE " . $return["table"] . " SET " . $return["column"] . " = " . $return["column"] . " + ? WHERE " . $return["ident"] . " = ?", [$rewardData["reward"], $username]);
                        } else {
                            $update = $dB->query("UPDATE " . $return["table"] . " SET " . $return["column"] . " = " . $return["column"] . " + ? WHERE " . $return["ident"] . " = ?", [$rewardData["reward"], $username]);
                        }
                        $update2 = $dB->query("UPDATE IMPERIAMUCMS_LOTTERY_WINNERS SET status = ? WHERE AccountID = ? AND lottery_id = ?", [1, $username, $lottery_id]);
                        $insert = $dB->query("INSERT INTO IMPERIAMUCMS_LOTTERY_LOGS (AccountID, date, reward, reward_type, lottery_id) VALUES (?, ?, ?, ?, ?)", [$username, date("Y-m-d H:i:s", time()), $rewardData["reward"], $rewardData["reward_type"], $lottery_id]);
                        if ($insert && $update && $update2) {
                            message("success", sprintf(lang("lottery_txt_33", true), $lottery_id));
                            $logDate = date("Y-m-d H:i:s", time());
                            $common->accountLogs($username, "lottery", sprintf(lang("lottery_txt_34", true), $rewardData["reward"], $return["name"], $lottery_id), $logDate);
                        } else {
                            message("error", lang("error_23", true));
                        }
                }
            } else {
                message("error", sprintf(lang("lottery_txt_32", true), $lottery_id));
            }
        } else {
            message("error", lang("error_23", true));
        }
    }
}

?>