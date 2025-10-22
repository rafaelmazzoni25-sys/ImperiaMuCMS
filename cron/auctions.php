<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$file_name = basename(__FILE__);
$dir_path = str_replace("\\", "/", dirname(dirname(__FILE__))) . "/";
include $dir_path . "includes/imperiamucms.php";
loadModuleConfigs("usercp.auction");
if (mconfig("active")) {
    $Auction = new Auction();
    $auctions = $Auction->getEndedAuctionsToReward();
    $date = date("Y-m-d H:i:s", time());
    if (is_array($auctions)) {
        foreach ($auctions as $thisAuction) {
            $totalBids = $Auction->getTotalBids($thisAuction["id"]);
            if (0 < $totalBids) {
                $currentBid = $Auction->getCurrentBid($thisAuction["id"]);
                $highestBid = $Auction->getHighestBidData($thisAuction["id"]);
                if ($currentBid < $highestBid["bid"]) {
                    $usernameBidder = $highestBid["AccountID"];
                    $amountBidder = $highestBid["bid"] - $currentBid;
                    if ($thisAuction["currency"] == "0") {
                        if (config("SQL_USE_2_DB", true)) {
                            $query = $dB2->query("UPDATE MEMB_STAT SET OnlineTime = OnlineTime + ? WHERE memb___id = ?", [$amountBidder * 60, $usernameBidder]);
                        } else {
                            $query = $dB->query("UPDATE MEMB_STAT SET OnlineTime = OnlineTime + ? WHERE memb___id = ?", [$amountBidder * 60, $usernameBidder]);
                        }
                    } else {
                        if ($thisAuction["currency"] == "1") {
                            if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                $query = $dB2->query("UPDATE MEMB_CREDITS SET platinum = platinum + ? WHERE memb___id = ?", [$amountBidder, $usernameBidder]);
                            } else {
                                $query = $dB->query("UPDATE MEMB_CREDITS SET platinum = platinum + ? WHERE memb___id = ?", [$amountBidder, $usernameBidder]);
                            }
                        } else {
                            if ($thisAuction["currency"] == "2") {
                                if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                    $query = $dB2->query("UPDATE MEMB_CREDITS SET gold = gold + ? WHERE memb___id = ?", [$amountBidder, $usernameBidder]);
                                } else {
                                    $query = $dB->query("UPDATE MEMB_CREDITS SET gold = gold + ? WHERE memb___id = ?", [$amountBidder, $usernameBidder]);
                                }
                            } else {
                                if ($thisAuction["currency"] == "3") {
                                    if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                        $query = $dB2->query("UPDATE MEMB_CREDITS SET silver = silver + ? WHERE memb___id = ?", [$amountBidder, $usernameBidder]);
                                    } else {
                                        $query = $dB->query("UPDATE MEMB_CREDITS SET silver = silver + ? WHERE memb___id = ?", [$amountBidder, $usernameBidder]);
                                    }
                                } else {
                                    if ($thisAuction["currency"] == "4") {
                                        if (100 <= config("server_files_season", true)) {
                                            $query = $dB->query("UPDATE T_InGameShop_Point SET WCoin = WCoin + ? WHERE AccountID = ?", [$amountBidder, $usernameBidder]);
                                        } else {
                                            $query = $dB->query("UPDATE T_InGameShop_Point SET WCoinC = WCoinC + ? WHERE AccountID = ?", [$amountBidder, $usernameBidder]);
                                        }
                                    } else {
                                        if ($thisAuction["currency"] == "5") {
                                            $query = $dB->query("UPDATE T_InGameShop_Point SET GoblinPoint = GoblinPoint + ? WHERE AccountID = ?", [$amountBidder, $usernameBidder]);
                                        } else {
                                            if ($thisAuction["currency"] == "6") {
                                                $query = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET zen = zen + ? WHERE AccountID = ?", [$amountBidder, $usernameBidder]);
                                            } else {
                                                if ($thisAuction["currency"] == "7") {
                                                    $query = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET bless = bless + ? WHERE AccountID = ?", [$amountBidder, $usernameBidder]);
                                                } else {
                                                    if ($thisAuction["currency"] == "8") {
                                                        $query = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET soul = soul + ? WHERE AccountID = ?", [$amountBidder, $usernameBidder]);
                                                    } else {
                                                        if ($thisAuction["currency"] == "9") {
                                                            $query = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET life = life + ? WHERE AccountID = ?", [$amountBidder, $usernameBidder]);
                                                        } else {
                                                            if ($thisAuction["currency"] == "10") {
                                                                $query = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET chaos = chaos + ? WHERE AccountID = ?", [$amountBidder, $usernameBidder]);
                                                            } else {
                                                                if ($thisAuction["currency"] == "11") {
                                                                    $query = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET harmony = harmony + ? WHERE AccountID = ?", [$amountBidder, $usernameBidder]);
                                                                } else {
                                                                    if ($thisAuction["currency"] == "12") {
                                                                        $query = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET creation = creation + ? WHERE AccountID = ?", [$amountBidder, $usernameBidder]);
                                                                    } else {
                                                                        if ($thisAuction["currency"] == "13") {
                                                                            $query = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET guardian = guardian + ? WHERE AccountID = ?", [$amountBidder, $usernameBidder]);
                                                                        } else {
                                                                            $query = $dB->query_fetch_single("SELECT name FROM IMPERIAMUCMS_WEB_BANK_CUSTOM WHERE ident = ?", [$thisAuction["currency"]]);
                                                                            $dbName = str_replace(" ", "_", $query["name"]);
                                                                            $query = $dB->query_fetch_single("UPDATE IMPERIAMUCMS_WEB_BANK SET " . $dbName . " = " . $dbName . " + ? WHERE AccountID = ?", [$amountBidder, $usernameBidder]);
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
                }
                if ($thisAuction["currency"] == 0) {
                    $currencyType = -1;
                } else {
                    if ($thisAuction["currency"] == 1 || $thisAuction["currency"] == 2) {
                        $currencyType = $thisAuction["currency"];
                    } else {
                        if ($thisAuction["currency"] == 3) {
                            $currencyType = 4;
                        } else {
                            $currencyType = $thisAuction["currency"] + 4;
                        }
                    }
                }
                $items = $Auction->getItems($thisAuction["id"]);
                $itemsTxt = "";
                if (is_array($items)) {
                    foreach ($items as $thisItem) {
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
                        $itemsTxt .= $thisItem["item"] . ";";
                        $insert = $dB->query("INSERT INTO IMPERIAMUCMS_WEBSHOP_ITEMS_INVENTORY (AccountID, item, price, price_type, date, status, type, giftFrom) VALUES (?, ?, ?, ?, ?, ?, ?, ?)", [$highestBid["AccountID"], $thisItem["item"], $currentBid, $currencyType, $date, 0, 6, NULL]);
                    }
                }
                $update = $dB->query("UPDATE IMPERIAMUCMS_AUCTIONS SET rewardGiven = ? WHERE id = ?", [1, $thisAuction["id"]]);
                $insert2 = $dB->query("INSERT INTO IMPERIAMUCMS_AUCTIONS_LOGS (auction_id, AccountID, currency, bid, date, items) VALUES (?, ?, ?, ?, ?, ?)", [$thisAuction["id"], $highestBid["AccountID"], $thisAuction["currency"], $currentBid, $date, $itemsTxt]);
            }
        }
    }
}
updateCronLastRun($file_name);

?>