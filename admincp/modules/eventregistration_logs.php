<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h1 class=\"page-header\">Event Registration Logs</h1>\r\n";
try {
    $logs = $dB->query_fetch("SELECT TOP 100 * FROM IMPERIAMUCMS_EVENT_REGISTRATION_LOGS ORDER BY date DESC");
    if (!is_array($logs)) {
        throw new Exception("There are no event registration logs in the database.");
    }
    $Market = new Market();
    echo "<table id=\"promo_logs\" class=\"table table-condensed table-hover\"><thead><tr><th>EventID</th><th>AccountID</th><th>Name</th><th>Class</th><th>Level</th><th>Master Level</th><th>Guild</th><th>Price</th><th>Date</th><th>IP</th></tr></thead><tbody>";
    foreach ($logs as $thisLog) {
        if ($thisLog["price_type"] == "0") {
            $currency = "Online Time (Hours)";
        } else {
            if ($thisLog["price_type"] == "1") {
                $currency = "Platinum Coins";
            } else {
                if ($thisLog["price_type"] == "2") {
                    $currency = "Gold Coins";
                } else {
                    if ($thisLog["price_type"] == "3") {
                        $currency = "Silver Coins";
                    } else {
                        if ($thisLog["price_type"] == "4") {
                            $currency = "WCoinC";
                        } else {
                            if ($thisLog["price_type"] == "5") {
                                $currency = "GoblinPoint";
                            } else {
                                if ($thisLog["price_type"] == "6") {
                                    $currency = "Zen";
                                } else {
                                    if ($thisLog["price_type"] == "7") {
                                        $currency = "Jewel of Bless";
                                    } else {
                                        if ($thisLog["price_type"] == "8") {
                                            $currency = "Jewel of Soul";
                                        } else {
                                            if ($thisLog["price_type"] == "9") {
                                                $currency = "Jewel of Life";
                                            } else {
                                                if ($thisLog["price_type"] == "10") {
                                                    $currency = "Jewel of Chaos";
                                                } else {
                                                    if ($thisLog["price_type"] == "11") {
                                                        $currency = "Jewel of Harmony";
                                                    } else {
                                                        if ($thisLog["price_type"] == "12") {
                                                            $currency = "Jewel of Creation";
                                                        } else {
                                                            if ($thisLog["price_type"] == "13") {
                                                                $currency = "Jewel of Guardian";
                                                            } else {
                                                                $customItems = $dB->query_fetch_single("SELECT name FROM IMPERIAMUCMS_WEB_BANK_CUSTOM WHERE ident = ?", [$thisLog["price_type"]]);
                                                                $currency = $customItems["name"];
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
            }
        }
        echo "<tr>";
        echo "<td>" . $thisLog["event_id"] . "</td>";
        echo "<td><a href=\"" . admincp_base("accountinfo&id=" . $common->retrieveUserID($thisLog["AccountID"])) . "\">" . $thisLog["AccountID"] . "</a></td>";
        echo "<td>" . $thisLog["Name"] . "</td>";
        echo "<td>" . $thisLog["Class"] . "</td>";
        echo "<td>" . $thisLog["cLevel"] . "</td>";
        echo "<td>" . $thisLog["mLevel"] . "</td>";
        echo "<td>" . $thisLog["GName"] . "</td>";
        echo "<td>" . $thisLog["price"] . " " . $currency . "</td>";
        echo "<td>" . date($config["time_date_format_logs"], strtotime($thisLog["date"])) . "</td>";
        echo "<td>" . $thisLog["ip"] . "</td>";
        echo "</tr>";
    }
    echo "</tbody></table>";
} catch (Exception $ex) {
    message("error", $ex->getMessage());
}

?>