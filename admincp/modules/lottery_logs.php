<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h1 class=\"page-header\">Lottery Logs</h1>\r\n";
$logs = $dB->query_fetch("SELECT TOP 100 * FROM IMPERIAMUCMS_LOTTERY ORDER BY id");
loadModuleConfigs("usercp.lottery");
if (is_array($logs)) {
    echo "<table id=\"webshop_logs\" class=\"table display\"><thead><tr><th>LotteryID</th><th>Period</th><th>Drawn Time & Date</th><th>Numbers</th><th>6th Prize</th><th>5th Prize</th><th>4th Prize</th><th>3rd Prize</th><th>2nd Prize</th><th>1st Prize</th></tr></thead><tbody>";
    foreach ($logs as $thisLog) {
        if (mconfig("lottery_type") == "1") {
            if (0 < $thisLog["6th_price_winners"]) {
                $reward6 = round($thisLog["6th_price"] / $thisLog["6th_price_winners"]);
            } else {
                $reward6 = 0;
            }
            if (0 < $thisLog["5th_price_winners"]) {
                $reward5 = round($thisLog["5th_price"] / $thisLog["5th_price_winners"]);
            } else {
                $reward5 = 0;
            }
            if (0 < $thisLog["4th_price_winners"]) {
                $reward4 = round($thisLog["4th_price"] / $thisLog["4th_price_winners"]);
            } else {
                $reward4 = 0;
            }
            if (0 < $thisLog["3rd_price_winners"]) {
                $reward3 = round($thisLog["3rd_price"] / $thisLog["3rd_price_winners"]);
            } else {
                $reward3 = 0;
            }
            if (0 < $thisLog["2nd_price_winners"]) {
                $reward2 = round($thisLog["2nd_price"] / $thisLog["2nd_price_winners"]);
            } else {
                $reward2 = 0;
            }
            if (0 < $thisLog["1st_price_winners"]) {
                $reward1 = round($thisLog["1st_price"] / $thisLog["1st_price_winners"]);
            } else {
                $reward1 = 0;
            }
        } else {
            if (0 < $thisLog["6th_price_winners"]) {
                $reward6 = $thisLog["6th_price"];
            } else {
                $reward6 = 0;
            }
            if (0 < $thisLog["5th_price_winners"]) {
                $reward5 = $thisLog["5th_price"];
            } else {
                $reward5 = 0;
            }
            if (0 < $thisLog["4th_price_winners"]) {
                $reward4 = $thisLog["4th_price"];
            } else {
                $reward4 = 0;
            }
            if (0 < $thisLog["3rd_price_winners"]) {
                $reward3 = $thisLog["3rd_price"];
            } else {
                $reward3 = 0;
            }
            if (0 < $thisLog["2nd_price_winners"]) {
                $reward2 = $thisLog["2nd_price"];
            } else {
                $reward2 = 0;
            }
            if (0 < $thisLog["1st_price_winners"]) {
                $reward1 = $thisLog["1st_price"];
            } else {
                $reward1 = 0;
            }
        }
        if (mconfig("lottery_prize_type") == 1) {
            $rewardName = lang("currency_platinum", true);
        } else {
            if (mconfig("lottery_prize_type") == 2) {
                $rewardName = lang("currency_gold", true);
            } else {
                if (mconfig("lottery_prize_type") == 3) {
                    $rewardName = lang("currency_silver", true);
                } else {
                    if (mconfig("lottery_prize_type") == 4) {
                        $rewardName = lang("currency_wcoinc", true);
                    } else {
                        if (mconfig("lottery_prize_type") == 5) {
                            $rewardName = lang("currency_gp", true);
                        } else {
                            if (mconfig("lottery_prize_type") == 6) {
                                $rewardName = "Zen";
                            }
                        }
                    }
                }
            }
        }
        echo "<tr>";
        echo "<td>" . $thisLog["lottery"] . "</td>";
        echo "<td>" . date($config["date_format"], strtotime($thisLog["start"])) . " - " . date($config["date_format"], strtotime($thisLog["end"])) . "</td>";
        echo "<td>" . date($config["time_date_format_logs"], strtotime($thisLog["date"])) . "</td>";
        echo "<td>" . $thisLog["num1"] . ", " . $thisLog["num2"] . ", " . $thisLog["num3"] . ", " . $thisLog["num4"] . ", " . $thisLog["num5"] . ", " . $thisLog["num6"] . "</td>";
        echo "<td>" . $thisLog["6th_price_winners"] . " (" . $reward6 . " " . $rewardName . ")</td>";
        echo "<td>" . $thisLog["5th_price_winners"] . " (" . $reward5 . " " . $rewardName . ")</td>";
        echo "<td>" . $thisLog["4th_price_winners"] . " (" . $reward4 . " " . $rewardName . ")</td>";
        echo "<td>" . $thisLog["3rd_price_winners"] . " (" . $reward3 . " " . $rewardName . ")</td>";
        echo "<td>" . $thisLog["2nd_price_winners"] . " (" . $reward2 . " " . $rewardName . ")</td>";
        echo "<td>" . $thisLog["1st_price_winners"] . " (" . $reward1 . " " . $rewardName . ")</td>";
        echo "</tr>";
    }
    echo "</tbody></table>";
}

?>