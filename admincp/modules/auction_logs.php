<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h1 class=\"page-header\">Auction Logs</h1>\r";
try {
    $logs = $dB->query_fetch("SELECT TOP 100 * FROM IMPERIAMUCMS_AUCTIONS_LOGS ORDER BY date DESC");
    if (!is_array($logs)) {
        throw new Exception("There are no auction logs in the database.");
    }
    echo "<script type=\"text/javascript\" SRC=\"" . __PATH_TEMPLATE__ . "js/tooltip.js\"></script>";
    $Market = new Market();
    $Items = new Items();
    echo "<table id=\"promo_logs\" class=\"table table-condensed table-hover\"><thead><tr><th>AuctionID</th><th>AccountID</th><th>Winning Bid</th><th>Items</th><th>Date</th></tr></thead><tbody>";
    foreach ($logs as $thisLog) {
        $itemsData = explode(";", $thisLog["items"]);
        $showReward = "";
        foreach ($itemsData as $thisItem) {
            $itemInfo = $Items->ItemInfo($thisItem);
            $luck = "";
            $skill = "";
            $option = "";
            $exl = "";
            $ancsetopt = "";
            if ($itemInfo["level"]) {
                $itemInfo["level"] = " +" . $itemInfo["level"];
            } else {
                $itemInfo["level"] = NULL;
            }
            if ($itemInfo["luck"]) {
                $luck = "<br><font color=#9aadd5>" . $itemInfo["luck"] . "</font>";
            }
            if ($itemInfo["skill"]) {
                $skill = "<br><font color=#9aadd5>" . $itemInfo["skill"] . "</font>";
            }
            if ($itemInfo["opt"]) {
                $option = "<font color=#9aadd5>" . $itemInfo["opt"] . "</font>";
            }
            if ($itemInfo["exl"]) {
                $exl = "<font color=#4d668d>" . str_replace("^^", "<br>", $itemInfo["exl"]) . "</font>";
            }
            if ($itemInfo["ancsetopt"]) {
                $ancsetopt = "<font color=#9aadd5>" . str_replace("^^", "<br>", $itemInfo["ancsetopt"]) . "</font>";
            }
            $showReward .= "<div style=\"cursor: pointer;\" onmouseover=\"Tip('<center><img src=" . $itemInfo["thumb"] . "><br /><font color=yellow><br>Serial: " . $itemInfo["sn2"] . $itemInfo["sn"] . "</font><br><font color=white><br>Durability: " . $itemInfo["dur"] . "</font><br><font color=#FF99CC>" . $itemInfo["jog"] . "</font><font color=FFCC00>" . $itemInfo["harm"] . "</font><br>" . $option . " " . $luck . " " . $skill . " " . $exl . " <br>" . $ancsetopt . "<br><font color=#4d668d>" . $itemInfo["socket"] . "</font><br><br><span class=itemTooltipClassReq>" . $itemInfo["classReq"] . "</span></center>', TITLEFONTCOLOR, '" . $itemInfo["color"] . "',TITLE,'" . addslashes($itemInfo["name"]) . $itemInfo["level"] . "',TITLEBGCOLOR,'" . $itemInfo["anco"] . "')\" onmouseout=\"UnTip()\">" . $itemInfo["name"] . "</div>&nbsp;&nbsp;&nbsp;";
        }
        if ($thisLog["currency"] == "0") {
            $currency = "Online Time (Hours)";
        } else {
            if ($thisLog["currency"] == "1") {
                $currency = "Platinum Coins";
            } else {
                if ($thisLog["currency"] == "2") {
                    $currency = "Gold Coins";
                } else {
                    if ($thisLog["currency"] == "3") {
                        $currency = "Silver Coins";
                    } else {
                        if ($thisLog["currency"] == "4") {
                            $currency = "WCoinC";
                        } else {
                            if ($thisLog["currency"] == "5") {
                                $currency = "GoblinPoint";
                            } else {
                                if ($thisLog["currency"] == "6") {
                                    $currency = "Zen";
                                } else {
                                    if ($thisLog["currency"] == "7") {
                                        $currency = "Jewel of Bless";
                                    } else {
                                        if ($thisLog["currency"] == "8") {
                                            $currency = "Jewel of Soul";
                                        } else {
                                            if ($thisLog["currency"] == "9") {
                                                $currency = "Jewel of Life";
                                            } else {
                                                if ($thisLog["currency"] == "10") {
                                                    $currency = "Jewel of Chaos";
                                                } else {
                                                    if ($thisLog["currency"] == "11") {
                                                        $currency = "Jewel of Harmony";
                                                    } else {
                                                        if ($thisLog["currency"] == "12") {
                                                            $currency = "Jewel of Creation";
                                                        } else {
                                                            if ($thisLog["currency"] == "13") {
                                                                $currency = "Jewel of Guardian";
                                                            } else {
                                                                $customItems = $dB->query_fetch_single("SELECT name FROM IMPERIAMUCMS_WEB_BANK_CUSTOM WHERE ident = ?", [$thisLog["currency"]]);
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
        echo "<td>" . $thisLog["auction_id"] . "</td>";
        echo "<td><a href=\"" . admincp_base("accountinfo&id=" . $common->retrieveUserID($thisLog["AccountID"])) . "\">" . $thisLog["AccountID"] . "</a></td>";
        echo "<td>" . number_format($thisLog["bid"]) . " " . $currency . "</td>";
        echo "<td>" . $showReward . "</td>";
        echo "<td>" . date($config["time_date_format_logs"], strtotime($thisLog["date"])) . "</td>";
        echo "</tr>";
    }
    echo "</tbody></table>";
} catch (Exception $ex) {
    message("error", $ex->getMessage());
}

?>