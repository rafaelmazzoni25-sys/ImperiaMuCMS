<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$file_name = basename(__FILE__);
$dir_path = str_replace("\\", "/", dirname(dirname(__FILE__))) . "/";
include $dir_path . "includes/imperiamucms.php";
include __PATH_LANGUAGES__ . $config["language_default"] . "/language.php";
loadModuleConfigs("usercp.vote");
$price_type = mconfig("reward_type");
if ($price_type == "1") {
    $price_type = lang("currency_platinum", true);
} else {
    if ($price_type == "2") {
        $price_type = lang("currency_gold", true);
    } else {
        if ($price_type == "3") {
            $price_type = lang("currency_silver", true);
        } else {
            if ($price_type == "4") {
                $price_type = lang("currency_wcoinc", true);
            } else {
                if ($price_type == "5") {
                    $price_type = lang("currency_gp", true);
                } else {
                    if ($price_type == "6") {
                        $price_type = "" . lang("currency_zen", true) . "";
                    }
                }
            }
        }
    }
}
if (mconfig("active") && mconfig("enable_auto_reward")) {
    $firstDay = 1;
    $currentDay = date("d", time());
    $startInterval = date("Y-m-d H:i:s", strtotime(date("Y-m") . " -1 month"));
    $endInterval = date("Y-m-t 23:59:59", strtotime(date("Y-m") . " -1 month"));
    if ($firstDay == $currentDay) {
        $check = $dB->query_fetch_single("SELECT TOP 1 * FROM IMPERIAMUCMS_VOTE_REWARDS ORDER BY date DESC");
        if ($check["date"] == NULL || date("Y-m", strtotime($check["date"])) < date("Y-m", time())) {
            $voteData = $dB->query_fetch("SELECT TOP 5 COUNT(*) as total, user_id FROM IMPERIAMUCMS_VOTES WHERE confirm = '1' AND\r\n                                      timestamp >= " . strtotime($startInterval) . " AND timestamp <= " . strtotime($endInterval) . " GROUP BY user_id ORDER BY total DESC");
            $reward = mconfig("reward_amount");
            foreach ($voteData as $thisUser) {
                if (0 < $reward) {
                    if (config("SQL_USE_2_DB", true)) {
                        $user = $dB2->query_fetch_single("SELECT memb___id FROM MEMB_INFO where memb_guid = ?", [$thisUser["user_id"]]);
                    } else {
                        $user = $dB->query_fetch_single("SELECT memb___id FROM MEMB_INFO where memb_guid = ?", [$thisUser["user_id"]]);
                    }
                    mconfig("reward_type");
                    switch (mconfig("reward_type")) {
                        case "1":
                            if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                $update = $dB2->query("UPDATE MEMB_CREDITS SET platinum = platinum + ? WHERE memb___id = ?", [$reward, $user["memb___id"]]);
                            } else {
                                $update = $dB->query("UPDATE MEMB_CREDITS SET platinum = platinum + ? WHERE memb___id = ?", [$reward, $user["memb___id"]]);
                            }
                            break;
                        case "2":
                            if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                $update = $dB2->query("UPDATE MEMB_CREDITS SET gold = gold + ? WHERE memb___id = ?", [$reward, $user["memb___id"]]);
                            } else {
                                $update = $dB->query("UPDATE MEMB_CREDITS SET gold = gold + ? WHERE memb___id = ?", [$reward, $user["memb___id"]]);
                            }
                            break;
                        case "3":
                            if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                $update = $dB2->query("UPDATE MEMB_CREDITS SET silver = silver + ? WHERE memb___id = ?", [$reward, $user["memb___id"]]);
                            } else {
                                $update = $dB->query("UPDATE MEMB_CREDITS SET silver = silver + ? WHERE memb___id = ?", [$reward, $user["memb___id"]]);
                            }
                            break;
                        case "4":
                            if (100 <= config("server_files_season", true)) {
                                $update = $dB->query("UPDATE T_InGameShop_Point SET WCoin = WCoin + ? WHERE AccountID = ?", [$reward, $user["memb___id"]]);
                            } else {
                                $update = $dB->query("UPDATE T_InGameShop_Point SET WCoinC = WCoinC + ? WHERE AccountID = ?", [$reward, $user["memb___id"]]);
                            }
                            break;
                        case "5":
                            $update = $dB->query("UPDATE T_InGameShop_Point SET GoblinPoint = GoblinPoint + ? WHERE AccountID = ?", [$reward, $user["memb___id"]]);
                            break;
                        case "6":
                            $update = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET zen = zen + ? WHERE AccountID = ?", [$reward, $user["memb___id"]]);
                            break;
                        default:
                            $insert = $dB->query("INSERT INTO IMPERIAMUCMS_VOTE_REWARDS (AccountID, reward, date) VALUES(?, ?, ?)", [$user["memb___id"], $reward . " " . $price_type, date("Y-m-d H:i:s", time())]);
                            $reward = $reward - mconfig("reward_amount_decrease");
                    }
                }
            }
        }
    }
}
updateCronLastRun($file_name);

?>