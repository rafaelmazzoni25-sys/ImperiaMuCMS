<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$file_name = basename(__FILE__);
$dir_path = str_replace("\\", "/", dirname(dirname(__FILE__))) . "/";
include $dir_path . "includes/imperiamucms.php";
loadModuleConfigs("mulords");
if (mconfig("active")) {
    $firstDay = 1;
    $currentDay = date("d", time());
    if ($firstDay == $currentDay) {
        $check = $dB->query_fetch_single("SELECT TOP 1 * FROM IMPERIAMUCMS_MULORDS ORDER BY date DESC");
        if ($check["date"] == NULL || date("Y-m", strtotime($check["date"])) < date("Y-m", time())) {
            $ranks = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_MU_LORDS_RANKS");
            $guildsOrdered = [];
            $guilds = $dB->query_fetch("SELECT * FROM Guild");
            foreach ($guilds as $thisGuild) {
                $members = $dB->query_fetch("SELECT * FROM GuildMember WHERE G_Name = ?", [$thisGuild["G_Name"]]);
                $total_donation = 0;
                $total_level = 0;
                $total_coins = 0;
                foreach ($members as $thisMember) {
                    $AccountID = $dB->query_fetch_single("SELECT AccountID, cLevel, mLevel FROM Character WHERE Name = ?", [$thisMember["Name"]]);
                    $donations = $dB->query_fetch_single("SELECT SUM(amount) as sum FROM IMPERIAMUCMS_MU_LORDS_DONATION WHERE AccountID = ?", [$AccountID["AccountID"]]);
                    if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                        $coins = $dB2->query_fetch_single("SELECT gold, gold_used FROM MEMB_CREDITS WHERE memb___id = ?", [$AccountID["AccountID"]]);
                    } else {
                        $coins = $dB->query_fetch_single("SELECT gold, gold_used FROM MEMB_CREDITS WHERE memb___id = ?", [$AccountID["AccountID"]]);
                    }
                    $total_level = $total_level + $AccountID["cLevel"] + $AccountID["mLevel"];
                    $total_donation = $total_donation + $donations["sum"];
                    $total_coins = $total_coins + $coins["gold"] + $coins["gold_used"];
                }
                if ($ranks[0]["req_level"] <= $total_level && $ranks[0]["req_donation"] <= $total_donation && $ranks[0]["req_coins"] <= $total_coins) {
                    $rank = 1;
                } else {
                    if ($ranks[1]["req_level"] <= $total_level && $ranks[1]["req_donation"] <= $total_donation && $ranks[1]["req_coins"] <= $total_coins) {
                        $rank = 2;
                    } else {
                        if ($ranks[2]["req_level"] <= $total_level && $ranks[2]["req_donation"] <= $total_donation && $ranks[2]["req_coins"] <= $total_coins) {
                            $rank = 3;
                        } else {
                            if ($ranks[3]["req_level"] <= $total_level && $ranks[3]["req_donation"] <= $total_donation && $ranks[3]["req_coins"] <= $total_coins) {
                                $rank = 4;
                            } else {
                                if ($ranks[4]["req_level"] <= $total_level && $ranks[4]["req_donation"] <= $total_donation && $ranks[4]["req_coins"] <= $total_coins) {
                                    $rank = 5;
                                } else {
                                    $rank = 0;
                                }
                            }
                        }
                    }
                }
                if (0 < $rank) {
                    $rewards = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_MU_LORDS_RANKS_REWARDS WHERE rank_id = ?", [$rank]);
                    if (config("SQL_USE_2_DB", true)) {
                        $AccountID = $dB->query_fetch_single("SELECT AccountID FROM Character WHERE Name = ?", [$thisGuild["G_Master"]]);
                        $accountInfo = $dB2->query_fetch_single("SELECT * FROM MEMB_INFO WHERE memb___id = ?", [$AccountID["AccountID"]]);
                    } else {
                        $AccountID = $dB->query_fetch_single("SELECT AccountID FROM Character WHERE Name = ?", [$thisGuild["G_Master"]]);
                        $accountInfo = $dB->query_fetch_single("SELECT * FROM MEMB_INFO WHERE memb___id = ?", [$AccountID["AccountID"]]);
                    }
                    foreach ($rewards as $thisReward) {
                        if ($thisReward["reward"] == NULL) {
                            $Market = new Market();
                            $Items = new Items();
                            $itemInfo = $Items->ItemInfo($thisReward["item"]);
                            $date = date("Y-m-d H:i:s", time());
                            $giveReward = $dB->query("INSERT INTO IMPERIAMUCMS_WEBSHOP_ITEMS_INVENTORY(AccountID,item,price,price_type,date,status,type,giftFrom)\r\n                                                          VALUES(?,?,0,0,?,0,3,'MU Lords')", [$accountInfo[_CLMN_USERNM_], $thisReward["item"], $date]);
                            $insert_log = $dB->query("INSERT INTO IMPERIAMUCMS_MU_LORDS_REWARDS (AccountID, reward, reward_type, item, date) VALUES (?, ?, ?, ?, ?)", [$AccountID["AccountID"], NULL, NULL, $thisReward["item"], date("Y-m-d H:i:s", time())]);
                            $logDate = date("Y-m-d H:i:s", time());
                            $common->accountLogs($accountInfo[_CLMN_USERNM_], "mulords", "Received item " . $itemInfo["name"] . " for MU Lords. Gained rank: " . $ranks[$rank]["rank"] . ".", $logDate);
                        } else {
                            $creditSystem = new CreditSystem($common, new Character(), $dB, $dB2);
                            $creditSystem->setConfigId($thisReward["reward_type"]);
                            $configSettings = $creditSystem->showConfigs(true);
                            switch ($configSettings["config_user_col_id"]) {
                                case "userid":
                                    $creditSystem->setIdentifier($accountInfo[_CLMN_MEMBID_]);
                                    break;
                                case "username":
                                    $creditSystem->setIdentifier($accountInfo[_CLMN_USERNM_]);
                                    break;
                                case "email":
                                    $creditSystem->setIdentifier($accountInfo[_CLMN_EMAIL_]);
                                    $_GET["page"] = "cron";
                                    $_GET["subpage"] = "reward_mulords";
                                    $creditSystem->addCredits($thisReward["reward"]);
                                    $insert_log = $dB->query("INSERT INTO IMPERIAMUCMS_MU_LORDS_REWARDS (AccountID, reward, reward_type, item, date) VALUES (?, ?, ?, ?, ?)", [$AccountID["AccountID"], $thisReward["reward"], $thisReward["reward_type"], NULL, date("Y-m-d H:i:s", time())]);
                                    $title = $dB->query_fetch_single("SELECT config_title FROM IMPERIAMUCMS_CREDITS_CONFIG WHERE config_id = ?", [$thisReward["reward_type"]]);
                                    $logDate = date("Y-m-d H:i:s", time());
                                    $common->accountLogs($accountInfo[_CLMN_USERNM_], "mulords", "Received " . $thisReward["reward"] . " " . $title["config_title"] . " for MU Lords. Gained rank: " . $ranks[$rank]["rank"] . ".", $logDate);
                                    break;
                                default:
                                    throw new Exception("invalid identifier");
                            }
                        }
                    }
                    $insert = $dB->query("INSERT INTO IMPERIAMUCMS_MU_LORDS (G_Name, G_Master, rank, levels, donation, coins, date) VALUES (?, ?, ?, ?, ?, ?, ?)", [$thisGuild["G_Name"], $thisGuild["G_Master"], $ranks[$rank]["rank"], $total_level, $total_donation, $total_coins, date("Y-m-d H:i:s", time())]);
                }
            }
        }
    }
}
updateCronLastRun($file_name);

?>