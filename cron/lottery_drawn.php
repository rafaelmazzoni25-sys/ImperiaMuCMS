<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$file_name = basename(__FILE__);
$dir_path = str_replace("\\", "/", dirname(dirname(__FILE__))) . "/";
include $dir_path . "includes/imperiamucms.php";
loadModuleConfigs("usercp.lottery");
if (mconfig("active")) {
    $Lottery = new Lottery();
    $execute = false;
    if (mconfig("lottery_length") == 7 || mconfig("lottery_length") == 14) {
        if (mconfig("lottery_start") < date("Y-m-d", time())) {
            $lastLottery = $dB->query_fetch_single("SELECT TOP 1 * FROM IMPERIAMUCMS_LOTTERY ORDER BY id DESC");
            if ($lastLottery["start"] == NULL) {
                $lastLottery["start"] = mconfig("lottery_start");
                $coef = 1;
            } else {
                $coef = 2;
            }
            $startsOn = date("Y-m-d", strtotime($lastLottery["start"]) + 86400 * mconfig("lottery_length") * $coef);
            if ($startsOn == date("Y-m-d", time())) {
                $execute = true;
            }
        }
    } else {
        $firstDay = 1;
        $currentDay = date("d", time());
        if ($currentDay == $firstDay) {
            $execute = true;
        }
    }
    if ($execute) {
        $check = $dB->query_fetch_single("SELECT TOP 1 * FROM IMPERIAMUCMS_LOTTERY ORDER BY date DESC");
        if ($check["date"] == NULL || date("Y-m-d", strtotime($check["date"])) < date("Y-m-d", time())) {
            $interval = range(mconfig("lottery_min_num"), mconfig("lottery_max_num"));
            $keys = array_rand($interval, 6);
            $lotteryNumbers = [1 => $interval[$keys[0]], 2 => $interval[$keys[1]], 3 => $interval[$keys[2]], 4 => $interval[$keys[3]], 5 => $interval[$keys[4]], 6 => $interval[$keys[5]]];
            $lottery_id = $Lottery->getLotteryNumber();
            $lastLottery = $dB->query_fetch_single("SELECT TOP 1 * FROM IMPERIAMUCMS_LOTTERY ORDER BY id DESC");
            if ($lastLottery["start"] == NULL) {
                if (mconfig("lottery_length") == 7 || mconfig("lottery_length") == 14) {
                    $start = mconfig("lottery_start");
                    $end = date("Y-m-d", strtotime($start) + 86400 * (mconfig("lottery_length") - 1));
                } else {
                    $start = date("Y-m-01", time());
                    $end = date("Y-m-t", time());
                }
            } else {
                if (mconfig("lottery_length") == 7 || mconfig("lottery_length") == 14) {
                    $start = date("Y-m-d", strtotime($lastLottery["start"]) + 86400 * mconfig("lottery_length"));
                    $end = date("Y-m-d", strtotime($start) + 86400 * (mconfig("lottery_length") - 1));
                } else {
                    $start = date("Y-m-01", time());
                    $end = date("Y-m-t", time());
                }
            }
            $winners = [];
            $prizes = ["1" => 0, "2" => 0, "3" => 0, "4" => 0, "5" => 0, "6" => 0];
            $tickets = $Lottery->getLotteryTickets($lottery_id);
            $i = 0;
            foreach ($tickets as $thisTicket) {
                $ticketNumbers = [1 => $thisTicket["num1"], 2 => $thisTicket["num2"], 3 => $thisTicket["num3"], 4 => $thisTicket["num4"], 5 => $thisTicket["num5"], 6 => $thisTicket["num6"]];
                $match = $Lottery->checkTicket($ticketNumbers, $lotteryNumbers);
                if (0 < $match) {
                    if ($match == 6) {
                        $reward = mconfig("lottery_1st_prize");
                        $prizes[1]++;
                    } else {
                        if ($match == 5) {
                            $reward = mconfig("lottery_2nd_prize");
                            $prizes[2]++;
                        } else {
                            if ($match == 4) {
                                $reward = mconfig("lottery_3rd_prize");
                                $prizes[3]++;
                            } else {
                                if ($match == 3) {
                                    $reward = mconfig("lottery_4th_prize");
                                    $prizes[4]++;
                                } else {
                                    if ($match == 2) {
                                        $reward = mconfig("lottery_5th_prize");
                                        $prizes[5]++;
                                    } else {
                                        if ($match == 1) {
                                            $reward = mconfig("lottery_6th_prize");
                                            $prizes[6]++;
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $winners[$i] = ["AccountID" => $thisTicket["AccountID"], "reward" => $reward, "reward_type" => mconfig("lottery_prize_type"), "lottery_id" => $lottery_id, "count" => $match];
                    $i++;
                }
            }
            if (mconfig("lottery_type") == "1") {
                $reward1 = round(mconfig("lottery_1st_prize") / $prizes[1]);
                $reward2 = round(mconfig("lottery_2nd_prize") / $prizes[2]);
                $reward3 = round(mconfig("lottery_3rd_prize") / $prizes[3]);
                $reward4 = round(mconfig("lottery_4th_prize") / $prizes[4]);
                $reward5 = round(mconfig("lottery_5th_prize") / $prizes[5]);
                $reward6 = round(mconfig("lottery_6th_prize") / $prizes[6]);
                $i = 0;
                while ($i < count($winners)) {
                    if ($winners[$i]["count"] == 6) {
                        $winners[$i]["reward"] = $reward1;
                    } else {
                        if ($winners[$i]["count"] == 5) {
                            $winners[$i]["reward"] = $reward2;
                        } else {
                            if ($winners[$i]["count"] == 4) {
                                $winners[$i]["reward"] = $reward3;
                            } else {
                                if ($winners[$i]["count"] == 3) {
                                    $winners[$i]["reward"] = $reward4;
                                } else {
                                    if ($winners[$i]["count"] == 2) {
                                        $winners[$i]["reward"] = $reward5;
                                    } else {
                                        if ($winners[$i]["count"] == 1) {
                                            $winners[$i]["reward"] = $reward6;
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $i++;
                }
            }
            $winnersMerged = [];
            $j = 0;
            $i = 0;
            while ($i < count($winners)) {
                $added = false;
                foreach ($winnersMerged as $key => $value) {
                    if ($value["AccountID"] == $winners[$i]["AccountID"]) {
                        $winnersMerged[$key]["reward"] = $winnersMerged[$key]["reward"] + $winners[$i]["reward"];
                        $added = true;
                    }
                }
                if (!$added) {
                    $winnersMerged[$j] = ["AccountID" => $winners[$i]["AccountID"], "reward" => $winners[$i]["reward"], "reward_type" => $winners[$i]["reward_type"], "lottery_id" => $winners[$i]["lottery_id"]];
                    $j++;
                }
                $i++;
            }
            foreach ($winnersMerged as $thisWinner) {
                $dB->query("INSERT INTO IMPERIAMUCMS_LOTTERY_WINNERS (AccountID, reward, reward_type, lottery_id, status) VALUES (?, ?, ?, ?, ?)", [$thisWinner["AccountID"], $thisWinner["reward"], $thisWinner["reward_type"], $thisWinner["lottery_id"], 0]);
            }
            $insert = $dB->query("INSERT INTO IMPERIAMUCMS_LOTTERY ([lottery],[start],[end],[date],[num1],[num2],[num3],[num4],[num5],[num6],[1st_price],[2nd_price],[3rd_price],[4th_price],[5th_price],[6th_price],\r\n                                                                [1st_price_winners],[2nd_price_winners],[3rd_price_winners],[4th_price_winners],[5th_price_winners],[6th_price_winners])\r\n                              VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", [$lottery_id, $start, $end, date("Y-m-d H:i:s", time()), $lotteryNumbers[1], $lotteryNumbers[2], $lotteryNumbers[3], $lotteryNumbers[4], $lotteryNumbers[5], $lotteryNumbers[6], mconfig("lottery_1st_prize"), mconfig("lottery_2nd_prize"), mconfig("lottery_3rd_prize"), mconfig("lottery_4th_prize"), mconfig("lottery_5th_prize"), mconfig("lottery_6th_prize"), $prizes[1], $prizes[2], $prizes[3], $prizes[4], $prizes[5], $prizes[6]]);
        }
    }
}
updateCronLastRun($file_name);

?>