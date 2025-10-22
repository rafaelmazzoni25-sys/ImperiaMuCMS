<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class Auction
{
    public function getAuction($id)
    {
        global $dB;
        if (check_value($id) && is_numeric($id)) {
            $result = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_AUCTIONS WHERE id = ?", [$id]);
            if (is_array($result)) {
                return $result;
            }
            return NULL;
        }
        message("error", lang("error_23", true));
    }
    public function getActiveAuctions($page, $limit)
    {
        global $dB;
        $now = date("Y-m-d H:i:s", time());
        $result = $dB->query_fetch("\r\n            SELECT * FROM IMPERIAMUCMS_AUCTIONS \r\n            WHERE start_date <= ? AND end_date > ?\r\n            ORDER BY end_date ASC\r\n            OFFSET " . intval($page * $limit - $limit) . " ROWS FETCH NEXT " . intval($limit) . " ROWS ONLY", [$now, $now]);
        if (is_array($result)) {
            return $result;
        }
        return NULL;
    }
    public function getAllActiveAuctions()
    {
        global $dB;
        $now = date("Y-m-d H:i:s", time());
        $result = $dB->query_fetch_single("\r\n            SELECT COUNT(*) as count FROM IMPERIAMUCMS_AUCTIONS \r\n            WHERE start_date <= ? AND end_date > ?", [$now, $now]);
        return $result["count"];
    }
    public function getEndedAuctions()
    {
        global $dB;
        $now = date("Y-m-d H:i:s", time());
        $result = $dB->query_fetch("SELECT TOP 10 * FROM IMPERIAMUCMS_AUCTIONS WHERE end_date < ? ORDER BY end_date DESC", [$now]);
        if (is_array($result)) {
            return $result;
        }
        return NULL;
    }
    public function getEndedAuctionsToReward()
    {
        global $dB;
        $now = date("Y-m-d H:i:s", time());
        $result = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_AUCTIONS WHERE end_date < ? AND rewardGiven = ?", [$now, 0]);
        if (is_array($result)) {
            return $result;
        }
        return NULL;
    }
    public function getLatestAuctions()
    {
        global $dB;
        $now = date("Y-m-d H:i:s", time());
        $result = $dB->query_fetch("SELECT TOP 5 * FROM IMPERIAMUCMS_AUCTIONS WHERE start_date <= ? AND end_date > ?", [$now, $now]);
        if (is_array($result)) {
            return $result;
        }
        return NULL;
    }
    public function getCurrentBid($auction_id)
    {
        global $dB;
        $bids = $dB->query_fetch_single("SELECT highestBid FROM IMPERIAMUCMS_AUCTIONS WHERE id = ?", [$auction_id]);
        if (is_array($bids)) {
            return $bids["highestBid"];
        }
        return NULL;
    }
    public function getHighestBid($auction_id)
    {
        global $dB;
        $bids = $dB->query_fetch_single("SELECT TOP 1 bid FROM IMPERIAMUCMS_AUCTIONS_BIDS WHERE auction_id = ? ORDER BY bid DESC", [$auction_id]);
        if (is_array($bids)) {
            return $bids["bid"];
        }
        $bids = $dB->query_fetch_single("SELECT TOP 1 bid FROM IMPERIAMUCMS_AUCTIONS WHERE id = ?", [$auction_id]);
        return $bids["bid"];
    }
    public function getHighestBidData($auction_id)
    {
        global $dB;
        $bids = $dB->query_fetch_single("SELECT TOP 1 * FROM IMPERIAMUCMS_AUCTIONS_BIDS WHERE auction_id = ? AND isHighestBid = ? ORDER BY bid DESC", [$auction_id, 1]);
        if (is_array($bids)) {
            return $bids;
        }
        return NULL;
    }
    public function getTotalBids($auction_id)
    {
        global $dB;
        $bids = $dB->query_fetch_single("SELECT COUNT(*) as count FROM IMPERIAMUCMS_AUCTIONS_BIDS WHERE auction_id = ?", [$auction_id]);
        if (is_array($bids)) {
            return $bids["count"];
        }
        return 0;
    }
    public function madeBid($username, $auction_id)
    {
        global $dB;
        if (!check_value($username)) {
            message("error", lang("error_4", true));
        } else {
            if (!check_value($auction_id)) {
                message("error", lang("error_4", true));
            } else {
                if (!Validator::UsernameLength($username)) {
                    message("error", lang("error_5", true));
                } else {
                    if (!Validator::AlphaNumeric($username)) {
                        message("error", lang("error_6", true));
                    } else {
                        $check = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_AUCTIONS_BIDS WHERE AccountID = ? AND auction_id = ?", [$username, $auction_id]);
                        if (is_array($check)) {
                            return true;
                        }
                        return false;
                    }
                }
            }
        }
    }
    public function canBid($username, $auction_id)
    {
        global $dB;
        global $dB2;
        if (!check_value($username)) {
            message("error", lang("error_4", true));
        } else {
            if (!check_value($auction_id)) {
                message("error", lang("error_4", true));
            } else {
                if (!Validator::UsernameLength($username)) {
                    message("error", lang("error_5", true));
                } else {
                    if (!Validator::AlphaNumeric($username)) {
                        message("error", lang("error_6", true));
                    } else {
                        $auctionData = $this->getAuction($auction_id);
                        $currentBid = $this->getCurrentBid($auction_id);
                        if (time() < strtotime($auctionData["end_date"])) {
                            if ($auctionData["currency"] == "0") {
                                if (config("SQL_USE_2_DB", true)) {
                                    $query = $dB2->query_fetch_single("SELECT OnlineTime FROM MEMB_STAT WHERE memb___id = ?", [$username]);
                                } else {
                                    $query = $dB->query_fetch_single("SELECT OnlineTime FROM MEMB_STAT WHERE memb___id = ?", [$username]);
                                }
                                $currency = floor($query["OnlineTime"] / 60);
                            } else {
                                if ($auctionData["currency"] == "1") {
                                    if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                        $query = $dB2->query_fetch_single("SELECT platinum FROM MEMB_CREDITS WHERE memb___id = ?", [$username]);
                                    } else {
                                        $query = $dB->query_fetch_single("SELECT platinum FROM MEMB_CREDITS WHERE memb___id = ?", [$username]);
                                    }
                                    $currency = $query["platinum"];
                                } else {
                                    if ($auctionData["currency"] == "2") {
                                        if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                            $query = $dB2->query_fetch_single("SELECT gold FROM MEMB_CREDITS WHERE memb___id = ?", [$username]);
                                        } else {
                                            $query = $dB->query_fetch_single("SELECT gold FROM MEMB_CREDITS WHERE memb___id = ?", [$username]);
                                        }
                                        $currency = $query["gold"];
                                    } else {
                                        if ($auctionData["currency"] == "3") {
                                            if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                                $query = $dB2->query_fetch_single("SELECT silver FROM MEMB_CREDITS WHERE memb___id = ?", [$username]);
                                            } else {
                                                $query = $dB->query_fetch_single("SELECT silver FROM MEMB_CREDITS WHERE memb___id = ?", [$username]);
                                            }
                                            $currency = $query["silver"];
                                        } else {
                                            if ($auctionData["currency"] == "4") {
                                                if (100 <= config("server_files_season", true)) {
                                                    $query = $dB->query_fetch_single("SELECT WCoin FROM T_InGameShop_Point WHERE AccountID = ?", [$username]);
                                                    $currency = $query["WCoin"];
                                                } else {
                                                    $query = $dB->query_fetch_single("SELECT WCoinC FROM T_InGameShop_Point WHERE AccountID = ?", [$username]);
                                                    $currency = $query["WCoinC"];
                                                }
                                            } else {
                                                if ($auctionData["currency"] == "5") {
                                                    $query = $dB->query_fetch_single("SELECT GoblinPoint FROM T_InGameShop_Point WHERE AccountID = ?", [$username]);
                                                    $currency = $query["GoblinPoint"];
                                                } else {
                                                    if ($auctionData["currency"] == "6") {
                                                        $query = $dB->query_fetch_single("SELECT zen FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$username]);
                                                        $currency = $query["zen"];
                                                    } else {
                                                        if ($auctionData["currency"] == "7") {
                                                            $query = $dB->query_fetch_single("SELECT bless FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$username]);
                                                            $currency = $query["bless"];
                                                        } else {
                                                            if ($auctionData["currency"] == "8") {
                                                                $query = $dB->query_fetch_single("SELECT soul FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$username]);
                                                                $currency = $query["soul"];
                                                            } else {
                                                                if ($auctionData["currency"] == "9") {
                                                                    $query = $dB->query_fetch_single("SELECT life FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$username]);
                                                                    $currency = $query["life"];
                                                                } else {
                                                                    if ($auctionData["currency"] == "10") {
                                                                        $query = $dB->query_fetch_single("SELECT chaos FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$username]);
                                                                        $currency = $query["chaos"];
                                                                    } else {
                                                                        if ($auctionData["currency"] == "11") {
                                                                            $query = $dB->query_fetch_single("SELECT harmony FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$username]);
                                                                            $currency = $query["harmony"];
                                                                        } else {
                                                                            if ($auctionData["currency"] == "12") {
                                                                                $query = $dB->query_fetch_single("SELECT creation FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$username]);
                                                                                $currency = $query["creation"];
                                                                            } else {
                                                                                if ($auctionData["currency"] == "13") {
                                                                                    $query = $dB->query_fetch_single("SELECT guardian FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$username]);
                                                                                    $currency = $query["guardian"];
                                                                                } else {
                                                                                    $query = $dB->query_fetch_single("SELECT name FROM IMPERIAMUCMS_WEB_BANK_CUSTOM WHERE ident = ?", [$auctionData["currency"]]);
                                                                                    $dbName = str_replace(" ", "_", $query["name"]);
                                                                                    $amount = $dB->query_fetch_single("SELECT " . $dbName . " FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$username]);
                                                                                    $currency = $amount[$dbName];
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
                            if ($this->getTotalBids($auction_id) == 0) {
                                if ($currentBid <= $currency) {
                                    return true;
                                }
                                return false;
                            }
                            if ($currentBid + $auctionData["increment"] <= $currency) {
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
    public function placeBid($username, $amount, $auction_id)
    {
        global $dB;
        global $dB2;
        if (!check_value($username)) {
            message("error", lang("error_4", true));
        } else {
            if (!check_value($amount)) {
                message("error", lang("error_4", true));
            } else {
                if (!check_value($auction_id)) {
                    message("error", lang("error_4", true));
                } else {
                    if (!Validator::UsernameLength($username)) {
                        message("error", lang("error_5", true));
                    } else {
                        if (!Validator::AlphaNumeric($username)) {
                            message("error", lang("error_6", true));
                        } else {
                            $amount = xss_clean($amount);
                            if (!is_numeric($amount) || $amount < 1) {
                                message("error", lang("error_23", true));
                            } else {
                                $auctionData = $this->getAuction($auction_id);
                                $currentBid = $this->getCurrentBid($auction_id);
                                $highestBid = $this->getHighestBid($auction_id);
                                $totalBids = $this->getTotalBids($auction_id);
                                $highestBidData = $this->getHighestBidData($auction_id);
                                $currencyName = $this->getCurrencyName($auctionData["currency"]);
                                if (time() < strtotime($auctionData["end_date"])) {
                                    if ($auctionData["currency"] == "0") {
                                        if (config("SQL_USE_2_DB", true)) {
                                            $query = $dB2->query_fetch_single("SELECT OnlineTime FROM MEMB_STAT WHERE memb___id = ?", [$username]);
                                        } else {
                                            $query = $dB->query_fetch_single("SELECT OnlineTime FROM MEMB_STAT WHERE memb___id = ?", [$username]);
                                        }
                                        $currency = floor($query["OnlineTime"] / 60);
                                    } else {
                                        if ($auctionData["currency"] == "1") {
                                            if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                                $query = $dB2->query_fetch_single("SELECT platinum FROM MEMB_CREDITS WHERE memb___id = ?", [$username]);
                                            } else {
                                                $query = $dB->query_fetch_single("SELECT platinum FROM MEMB_CREDITS WHERE memb___id = ?", [$username]);
                                            }
                                            $currency = $query["platinum"];
                                        } else {
                                            if ($auctionData["currency"] == "2") {
                                                if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                                    $query = $dB2->query_fetch_single("SELECT gold FROM MEMB_CREDITS WHERE memb___id = ?", [$username]);
                                                } else {
                                                    $query = $dB->query_fetch_single("SELECT gold FROM MEMB_CREDITS WHERE memb___id = ?", [$username]);
                                                }
                                                $currency = $query["gold"];
                                            } else {
                                                if ($auctionData["currency"] == "3") {
                                                    if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                                        $query = $dB2->query_fetch_single("SELECT silver FROM MEMB_CREDITS WHERE memb___id = ?", [$username]);
                                                    } else {
                                                        $query = $dB->query_fetch_single("SELECT silver FROM MEMB_CREDITS WHERE memb___id = ?", [$username]);
                                                    }
                                                    $currency = $query["silver"];
                                                } else {
                                                    if ($auctionData["currency"] == "4") {
                                                        if (100 <= config("server_files_season", true)) {
                                                            $query = $dB->query_fetch_single("SELECT WCoin FROM T_InGameShop_Point WHERE AccountID = ?", [$username]);
                                                            $currency = $query["WCoin"];
                                                        } else {
                                                            $query = $dB->query_fetch_single("SELECT WCoinC FROM T_InGameShop_Point WHERE AccountID = ?", [$username]);
                                                            $currency = $query["WCoinC"];
                                                        }
                                                    } else {
                                                        if ($auctionData["currency"] == "5") {
                                                            $query = $dB->query_fetch_single("SELECT GoblinPoint FROM T_InGameShop_Point WHERE AccountID = ?", [$username]);
                                                            $currency = $query["GoblinPoint"];
                                                        } else {
                                                            if ($auctionData["currency"] == "6") {
                                                                $query = $dB->query_fetch_single("SELECT zen FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$username]);
                                                                $currency = $query["zen"];
                                                            } else {
                                                                if ($auctionData["currency"] == "7") {
                                                                    $query = $dB->query_fetch_single("SELECT bless FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$username]);
                                                                    $currency = $query["bless"];
                                                                } else {
                                                                    if ($auctionData["currency"] == "8") {
                                                                        $query = $dB->query_fetch_single("SELECT soul FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$username]);
                                                                        $currency = $query["soul"];
                                                                    } else {
                                                                        if ($auctionData["currency"] == "9") {
                                                                            $query = $dB->query_fetch_single("SELECT life FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$username]);
                                                                            $currency = $query["life"];
                                                                        } else {
                                                                            if ($auctionData["currency"] == "10") {
                                                                                $query = $dB->query_fetch_single("SELECT chaos FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$username]);
                                                                                $currency = $query["chaos"];
                                                                            } else {
                                                                                if ($auctionData["currency"] == "11") {
                                                                                    $query = $dB->query_fetch_single("SELECT harmony FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$username]);
                                                                                    $currency = $query["harmony"];
                                                                                } else {
                                                                                    if ($auctionData["currency"] == "12") {
                                                                                        $query = $dB->query_fetch_single("SELECT creation FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$username]);
                                                                                        $currency = $query["creation"];
                                                                                    } else {
                                                                                        if ($auctionData["currency"] == "13") {
                                                                                            $query = $dB->query_fetch_single("SELECT guardian FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$username]);
                                                                                            $currency = $query["guardian"];
                                                                                        } else {
                                                                                            $query = $dB->query_fetch_single("SELECT name FROM IMPERIAMUCMS_WEB_BANK_CUSTOM WHERE ident = ?", [$auctionData["currency"]]);
                                                                                            $dbName = str_replace(" ", "_", $query["name"]);
                                                                                            $amount = $dB->query_fetch_single("SELECT " . $dbName . " FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$username]);
                                                                                            $currency = $amount[$dbName];
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
                                    if ($totalBids == 0) {
                                        $requiredAmount = $currentBid;
                                    } else {
                                        if ($currentBid < $highestBid) {
                                            $requiredAmount = $highestBid + $auctionData["increment"];
                                        } else {
                                            $requiredAmount = $currentBid + $auctionData["increment"];
                                        }
                                    }
                                    if ($currentBid + $auctionData["increment"] <= $currency && $amount <= $currency) {
                                        if ($requiredAmount <= $amount) {
                                            if (($amount - $auctionData["bid"]) % $auctionData["increment"] == 0) {
                                                if ($highestBidData["AccountID"] == $username) {
                                                    $updateBid = $dB->query("UPDATE IMPERIAMUCMS_AUCTIONS_BIDS SET bid = ?, date = ? WHERE auction_id = ? AND AccountID = ?", [$amount, date("Y-m-d H:i:s", time()), $auction_id, $username]);
                                                    if ($auctionData["bidType"] == "0") {
                                                        $updateAuction = $dB->query("UPDATE IMPERIAMUCMS_AUCTIONS SET highestBid = ? WHERE id = ?", [$amount, $auction_id]);
                                                    }
                                                } else {
                                                    if ($auctionData["bidType"] == "0") {
                                                        $newBid = $amount;
                                                    } else {
                                                        if ($totalBids == 0) {
                                                            $newBid = $currentBid;
                                                        } else {
                                                            if ($highestBid < $amount) {
                                                                $newBid = $highestBid + $auctionData["increment"];
                                                            } else {
                                                                $newBid = $currentBid + $auctionData["increment"];
                                                            }
                                                        }
                                                        $updatePreviousBid = $dB->query("UPDATE IMPERIAMUCMS_AUCTIONS_BIDS SET isHighestBid = 0 WHERE AccountID = ? AND auction_id = ?", [$highestBidData["AccountID"], $auction_id]);
                                                    }
                                                    $insertBid = $dB->query("INSERT INTO IMPERIAMUCMS_AUCTIONS_BIDS (auction_id, AccountID, bid, currency, date, isHighestBid)\r\n                                             VALUES (?, ?, ?, ?, ?, ?)", [$auction_id, $username, $amount, $auctionData["currency"], date("Y-m-d H:i:s", time()), 1]);
                                                    $updateAuction = $dB->query("UPDATE IMPERIAMUCMS_AUCTIONS SET highestBid = ? WHERE id = ?", [$newBid, $auction_id]);
                                                }
                                                if ($auctionData["currency"] == "0") {
                                                    if (config("SQL_USE_2_DB", true)) {
                                                        $query = $dB2->query("UPDATE MEMB_STAT SET OnlineTime = OnlineTime - ? WHERE memb___id = ?", [$amount * 60, $username]);
                                                    } else {
                                                        $query = $dB->query("UPDATE MEMB_STAT SET OnlineTime = OnlineTime - ? WHERE memb___id = ?", [$amount * 60, $username]);
                                                    }
                                                } else {
                                                    if ($auctionData["currency"] == "1") {
                                                        if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                                            $query = $dB2->query("UPDATE MEMB_CREDITS SET platinum = platinum - ? WHERE memb___id = ?", [$amount, $username]);
                                                        } else {
                                                            $query = $dB->query("UPDATE MEMB_CREDITS SET platinum = platinum - ? WHERE memb___id = ?", [$amount, $username]);
                                                        }
                                                    } else {
                                                        if ($auctionData["currency"] == "2") {
                                                            if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                                                $query = $dB2->query("UPDATE MEMB_CREDITS SET gold = gold - ? WHERE memb___id = ?", [$amount, $username]);
                                                            } else {
                                                                $query = $dB->query("UPDATE MEMB_CREDITS SET gold = gold - ? WHERE memb___id = ?", [$amount, $username]);
                                                            }
                                                        } else {
                                                            if ($auctionData["currency"] == "3") {
                                                                if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                                                    $query = $dB2->query("UPDATE MEMB_CREDITS SET silver = silver - ? WHERE memb___id = ?", [$amount, $username]);
                                                                } else {
                                                                    $query = $dB->query("UPDATE MEMB_CREDITS SET silver = silver - ? WHERE memb___id = ?", [$amount, $username]);
                                                                }
                                                            } else {
                                                                if ($auctionData["currency"] == "4") {
                                                                    if (100 <= config("server_files_season", true)) {
                                                                        $query = $dB->query("UPDATE T_InGameShop_Point SET WCoin = WCoin - ? WHERE AccountID = ?", [$amount, $username]);
                                                                    } else {
                                                                        $query = $dB->query("UPDATE T_InGameShop_Point SET WCoinC = WCoinC - ? WHERE AccountID = ?", [$amount, $username]);
                                                                    }
                                                                } else {
                                                                    if ($auctionData["currency"] == "5") {
                                                                        $query = $dB->query("UPDATE T_InGameShop_Point SET GoblinPoint = GoblinPoint - ? WHERE AccountID = ?", [$amount, $username]);
                                                                    } else {
                                                                        if ($auctionData["currency"] == "6") {
                                                                            $query = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET zen = zen - ? WHERE AccountID = ?", [$amount, $username]);
                                                                        } else {
                                                                            if ($auctionData["currency"] == "7") {
                                                                                $query = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET bless = bless - ? WHERE AccountID = ?", [$amount, $username]);
                                                                            } else {
                                                                                if ($auctionData["currency"] == "8") {
                                                                                    $query = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET soul = soul - ? WHERE AccountID = ?", [$amount, $username]);
                                                                                } else {
                                                                                    if ($auctionData["currency"] == "9") {
                                                                                        $query = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET life = life - ? WHERE AccountID = ?", [$amount, $username]);
                                                                                    } else {
                                                                                        if ($auctionData["currency"] == "10") {
                                                                                            $query = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET chaos = chaos - ? WHERE AccountID = ?", [$amount, $username]);
                                                                                        } else {
                                                                                            if ($auctionData["currency"] == "11") {
                                                                                                $query = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET harmony = harmony - ? WHERE AccountID = ?", [$amount, $username]);
                                                                                            } else {
                                                                                                if ($auctionData["currency"] == "12") {
                                                                                                    $query = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET creation = creation - ? WHERE AccountID = ?", [$amount, $username]);
                                                                                                } else {
                                                                                                    if ($auctionData["currency"] == "13") {
                                                                                                        $query = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET guardian = guardian - ? WHERE AccountID = ?", [$amount, $username]);
                                                                                                    } else {
                                                                                                        $query = $dB->query_fetch_single("SELECT name FROM IMPERIAMUCMS_WEB_BANK_CUSTOM WHERE ident = ?", [$auctionData["currency"]]);
                                                                                                        $dbName = str_replace(" ", "_", $query["name"]);
                                                                                                        $query = $dB->query_fetch_single("UPDATE IMPERIAMUCMS_WEB_BANK SET " . $dbName . " = " . $dbName . " - ? WHERE AccountID = ?", [$amount, $username]);
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
                                                if (0 < $totalBids) {
                                                    $usernameBidder = $highestBidData["AccountID"];
                                                    $amountBidder = $highestBidData["bid"];
                                                    if ($auctionData["currency"] == "0") {
                                                        if (config("SQL_USE_2_DB", true)) {
                                                            $query = $dB2->query("UPDATE MEMB_STAT SET OnlineTime = OnlineTime + ? WHERE memb___id = ?", [$amountBidder * 60, $usernameBidder]);
                                                        } else {
                                                            $query = $dB->query("UPDATE MEMB_STAT SET OnlineTime = OnlineTime + ? WHERE memb___id = ?", [$amountBidder * 60, $usernameBidder]);
                                                        }
                                                    } else {
                                                        if ($auctionData["currency"] == "1") {
                                                            if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                                                $query = $dB2->query("UPDATE MEMB_CREDITS SET platinum = platinum + ? WHERE memb___id = ?", [$amountBidder, $usernameBidder]);
                                                            } else {
                                                                $query = $dB->query("UPDATE MEMB_CREDITS SET platinum = platinum + ? WHERE memb___id = ?", [$amountBidder, $usernameBidder]);
                                                            }
                                                        } else {
                                                            if ($auctionData["currency"] == "2") {
                                                                if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                                                    $query = $dB2->query("UPDATE MEMB_CREDITS SET gold = gold + ? WHERE memb___id = ?", [$amountBidder, $usernameBidder]);
                                                                } else {
                                                                    $query = $dB->query("UPDATE MEMB_CREDITS SET gold = gold + ? WHERE memb___id = ?", [$amountBidder, $usernameBidder]);
                                                                }
                                                            } else {
                                                                if ($auctionData["currency"] == "3") {
                                                                    if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                                                        $query = $dB2->query("UPDATE MEMB_CREDITS SET silver = silver + ? WHERE memb___id = ?", [$amountBidder, $usernameBidder]);
                                                                    } else {
                                                                        $query = $dB->query("UPDATE MEMB_CREDITS SET silver = silver + ? WHERE memb___id = ?", [$amountBidder, $usernameBidder]);
                                                                    }
                                                                } else {
                                                                    if ($auctionData["currency"] == "4") {
                                                                        if (100 <= config("server_files_season", true)) {
                                                                            $query = $dB->query("UPDATE T_InGameShop_Point SET WCoin = WCoin + ? WHERE AccountID = ?", [$amountBidder, $usernameBidder]);
                                                                        } else {
                                                                            $query = $dB->query("UPDATE T_InGameShop_Point SET WCoinC = WCoinC + ? WHERE AccountID = ?", [$amountBidder, $usernameBidder]);
                                                                        }
                                                                    } else {
                                                                        if ($auctionData["currency"] == "5") {
                                                                            $query = $dB->query("UPDATE T_InGameShop_Point SET GoblinPoint = GoblinPoint + ? WHERE AccountID = ?", [$amountBidder, $usernameBidder]);
                                                                        } else {
                                                                            if ($auctionData["currency"] == "6") {
                                                                                $query = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET zen = zen + ? WHERE AccountID = ?", [$amountBidder, $usernameBidder]);
                                                                            } else {
                                                                                if ($auctionData["currency"] == "7") {
                                                                                    $query = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET bless = bless + ? WHERE AccountID = ?", [$amountBidder, $usernameBidder]);
                                                                                } else {
                                                                                    if ($auctionData["currency"] == "8") {
                                                                                        $query = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET soul = soul + ? WHERE AccountID = ?", [$amountBidder, $usernameBidder]);
                                                                                    } else {
                                                                                        if ($auctionData["currency"] == "9") {
                                                                                            $query = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET life = life + ? WHERE AccountID = ?", [$amountBidder, $usernameBidder]);
                                                                                        } else {
                                                                                            if ($auctionData["currency"] == "10") {
                                                                                                $query = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET chaos = chaos + ? WHERE AccountID = ?", [$amountBidder, $usernameBidder]);
                                                                                            } else {
                                                                                                if ($auctionData["currency"] == "11") {
                                                                                                    $query = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET harmony = harmony + ? WHERE AccountID = ?", [$amountBidder, $usernameBidder]);
                                                                                                } else {
                                                                                                    if ($auctionData["currency"] == "12") {
                                                                                                        $query = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET creation = creation + ? WHERE AccountID = ?", [$amountBidder, $usernameBidder]);
                                                                                                    } else {
                                                                                                        if ($auctionData["currency"] == "13") {
                                                                                                            $query = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET guardian = guardian + ? WHERE AccountID = ?", [$amountBidder, $usernameBidder]);
                                                                                                        } else {
                                                                                                            $query = $dB->query_fetch_single("SELECT name FROM IMPERIAMUCMS_WEB_BANK_CUSTOM WHERE ident = ?", [$auctionData["currency"]]);
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
                                                $secondsLeft = strtotime($auctionData["end_date"]) - time();
                                                if ($secondsLeft < $auctionData["extend"] * 60) {
                                                    $extend = time() + $auctionData["extend"] * 60;
                                                    $updateAuction2 = $dB->query("UPDATE IMPERIAMUCMS_AUCTIONS SET end_date = ? WHERE id = ?", [date("Y-m-d H:i:s", $extend), $auction_id]);
                                                }
                                                if ($highestBidData["AccountID"] == $username) {
                                                    message("success", lang("auction_txt_18", true));
                                                } else {
                                                    message("success", lang("auction_txt_14", true));
                                                }
                                            } else {
                                                message("error", sprintf(lang("auction_txt_25", true), $auctionData["increment"]));
                                            }
                                        } else {
                                            if (($amount - $auctionData["bid"]) % $auctionData["increment"] == 0) {
                                                if ($currentBid + $auctionData["increment"] <= $amount && $amount <= $highestBid && $username != $highestBidData["AccountID"]) {
                                                    $updateAuction = $dB->query("UPDATE IMPERIAMUCMS_AUCTIONS SET highestBid = ? WHERE id = ?", [$amount, $auction_id]);
                                                    message("notice", "increased current bid");
                                                }
                                                if ($currentBid + $auctionData["increment"] <= $amount) {
                                                    message("error", lang("auction_txt_23", true));
                                                } else {
                                                    message("error", sprintf(lang("auction_txt_22", true), $currentBid + $auctionData["increment"], $currencyName));
                                                }
                                            } else {
                                                message("error", sprintf(lang("auction_txt_25", true), $auctionData["increment"]));
                                            }
                                        }
                                    } else {
                                        message("error", sprintf(lang("auction_txt_21", true), $currencyName));
                                    }
                                } else {
                                    message("error", lang("auction_txt_26", true));
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    public function getItems($auction_id)
    {
        global $dB;
        if (check_value($auction_id) && is_numeric($auction_id)) {
            $result = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_AUCTIONS_ITEMS WHERE auction_id = ?", [$auction_id]);
            if (is_array($result)) {
                return $result;
            }
            return NULL;
        }
        message("error", lang("error_23", true));
    }
    public function addAuction($name, $author, $start, $end, $currency, $bid, $increment, $bidType, $extend)
    {
        global $dB;
        if (check_value($name) && check_value($author) && check_value($start) && check_value($end) && check_value($currency) && check_value($bid) && check_value($increment) && check_value($bidType) && check_value($extend)) {
            if (is_numeric($currency) && is_numeric($bid) && is_numeric($increment) && is_numeric($bidType) && is_numeric($extend) && 1 <= $bid && 1 <= $increment) {
                $insert = $dB->query("INSERT INTO IMPERIAMUCMS_AUCTIONS (name, author, start_date, end_date, currency, bid, increment, bidType, extend, rewardGiven, highestBid)\r\n                                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$name, $author, $start, $end, $currency, $bid, $increment, $bidType, $extend, 0, $bid]);
                if ($insert) {
                    message("success", "Auction was successfully created.");
                } else {
                    message("error", lang("error_23", true));
                }
            } else {
                message("error", lang("error_23", true));
            }
        } else {
            message("error", lang("error_23", true));
        }
    }
    public function addAuctionItem($auction_id, $item_hex)
    {
        global $dB;
        if (check_value($auction_id) && check_value($item_hex)) {
            if (is_numeric($auction_id) && strlen($item_hex) == __ITEM_LENGTH__) {
                $insert = $dB->query("INSERT INTO IMPERIAMUCMS_AUCTIONS_ITEMS (auction_id, item) VALUES (?, ?)", [$auction_id, $item_hex]);
                if ($insert) {
                    message("success", "Item " . $item_hex . " was successfully added into auction #" . $auction_id . ".");
                } else {
                    message("error", lang("error_23", true));
                }
            } else {
                message("error", lang("error_23", true));
            }
        } else {
            message("error", lang("error_23", true));
        }
    }
    public function editAuction($id, $name, $author, $start, $end, $currency, $bid, $increment, $bidType, $extend)
    {
        global $dB;
        if (check_value($id) && check_value($name) && check_value($author) && check_value($start) && check_value($end) && check_value($currency) && check_value($bid) && check_value($increment) && check_value($bidType) && check_value($extend)) {
            if (is_numeric($id) && is_numeric($currency) && is_numeric($bid) && is_numeric($increment) && is_numeric($bidType) && is_numeric($extend) && 1 <= $bid && 1 <= $increment) {
                $update = $dB->query("UPDATE IMPERIAMUCMS_AUCTIONS SET name = ?, author = ?, start_date = ?, end_date = ?, currency = ?, bid = ?, increment = ?, bidType = ?, extend = ? WHERE id = ?", [$name, $author, $start, $end, $currency, $bid, $increment, $bidType, $extend, $id]);
                if ($update) {
                    message("success", "Auction #" . $id . " was successfully edited.");
                } else {
                    message("error", lang("error_23", true) . "1");
                }
            } else {
                message("error", lang("error_23", true) . "2");
            }
        } else {
            message("error", lang("error_23", true) . "3");
        }
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
            case 5:
                return lang("currency_gp", true);
                break;
            case 6:
                return "" . lang("currency_zen", true) . "";
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
}

?>