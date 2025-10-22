<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */
$_DEBUG = false;
$jsonError = "";
$jsonMsg = "";
$jsonDeg = 0;
$jsonTarget = 0;
try {
    if (!(include_once "../includes/imperiamucmsajax.php")) {
        throw new Exception("Could not load the AJAX configurations file.");
    }
    if (empty($_SESSION["username"])) {
        throw new Exception(lang("wheeloffortune_txt_15", true));
    }
    $deg = 0;
    if (isset($_POST["deg"])) {
        $deg = xss_clean($_POST["deg"]);
        if (!is_numeric($deg)) {
            $deg = 0;
        }
    }
    loadModuleConfigs("usercp.wheeloffortune");
    $totalItems = mconfig("items");
    $degreesPerItem = 360 / $totalItems;
    $circleCount = mconfig("circle_count");
    $circleDegrees = $circleCount * 360;
    $intervalMin = mconfig("interval_min");
    $intervalMax = mconfig("interval_max");
    $deg = generatedeg($deg, $degreesPerItem, $circleDegrees, $intervalMin, $intervalMax, mconfig("total_chance"), mconfig("rewards"));
    $jsonDeg = $deg;
    $resultId = ($deg - 360 * intval($deg / 360)) / $degreesPerItem;
    $jsonTarget = $resultId;
    $time = time();
    $todayStart = date("Y-m-d 00:00:00", $time);
    $todayEnd = date("Y-m-d 23:59:59", $time);
    $currentMonthDay = date("j", $time);
    $currentWeekDay = date("N", $time);
    $currentHour = date("G", $time);
    $monthDay_start = mconfig("enabled_month_day_start");
    $monthDay_end = mconfig("enabled_month_day_end");
    $weekDay_start = mconfig("enabled_week_day_start");
    $weekDay_end = mconfig("enabled_week_day_end");
    $hour_start = mconfig("enabled_hour_start");
    $hour_end = mconfig("enabled_hour_end");
    $check_monthDay = false;
    $check_weekDay = false;
    $check_hour = false;
    if ($monthDay_start == "-1" && $monthDay_end == "-1") {
        $check_monthDay = true;
        if ($_DEBUG) {
            echo "month day ok<br>";
        }
    } else {
        if ($monthDay_start <= $currentMonthDay && $currentMonthDay <= $monthDay_end) {
            $check_monthDay = true;
            if ($_DEBUG) {
                echo "month day ok<br>";
            }
        }
    }
    if ($weekDay_start == "-1" && $weekDay_end == "-1") {
        $check_weekDay = true;
        if ($_DEBUG) {
            echo "week day ok<br>";
        }
    } else {
        if ($weekDay_start <= $currentWeekDay && $currentWeekDay <= $weekDay_end) {
            $check_weekDay = true;
            if ($_DEBUG) {
                echo "week day ok<br>";
            }
        }
    }
    if ($hour_start <= $currentHour && $currentHour < $hour_end) {
        $check_hour = true;
        if ($_DEBUG) {
            echo "hour ok<br>";
        }
    }
    if ($check_monthDay && $check_weekDay && $check_hour) {
        $totalSpins = $dB->query_fetch_single("SELECT COUNT(id) as count FROM IMPERIAMUCMS_WHEEL_OF_FORTUNE WHERE AccountID = ? AND date >= ? AND date <= ?", [$_SESSION["username"], $todayStart, $todayEnd]);
        if ($totalSpins["count"] < mconfig("max_spins")) {
            if ($_DEBUG) {
                echo "max spins ok<br>";
            }
            $totalCurrency = 0;
            $currencyName = "";
            if (0 < mconfig("price")) {
                mconfig("price_type");
                switch (mconfig("price_type")) {
                    case 1:
                        if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                            $totalCurrency = $dB2->query_fetch_single("SELECT platinum FROM MEMB_CREDITS WHERE memb___id = ?", [$_SESSION["username"]]);
                        } else {
                            $totalCurrency = $dB->query_fetch_single("SELECT platinum FROM MEMB_CREDITS WHERE memb___id = ?", [$_SESSION["username"]]);
                        }
                        $totalCurrency = $totalCurrency["platinum"];
                        $currencyName = lang("currency_platinum", true);
                        break;
                    case 2:
                        if ($_DEBUG) {
                            echo "price type gold<br>";
                        }
                        if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                            if ($_DEBUG) {
                                echo "credits in db2<br>";
                            }
                            $totalCurrency = $dB2->query_fetch_single("SELECT gold FROM MEMB_CREDITS WHERE memb___id = ?", [$_SESSION["username"]]);
                        } else {
                            if ($_DEBUG) {
                                echo "credits in db1 [" . $_SESSION["username"] . "] user<br>";
                            }
                            $totalCurrency = $dB->query_fetch_single("SELECT gold FROM MEMB_CREDITS WHERE memb___id = ?", [$_SESSION["username"]]);
                        }
                        if ($_DEBUG) {
                            print_r_formatted($totalCurrency);
                        }
                        $totalCurrency = $totalCurrency["gold"];
                        $currencyName = lang("currency_gold", true);
                        break;
                    case 3:
                        if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                            $totalCurrency = $dB2->query_fetch_single("SELECT silver FROM MEMB_CREDITS WHERE memb___id = ?", [$_SESSION["username"]]);
                        } else {
                            $totalCurrency = $dB->query_fetch_single("SELECT silver FROM MEMB_CREDITS WHERE memb___id = ?", [$_SESSION["username"]]);
                        }
                        $totalCurrency = $totalCurrency["silver"];
                        $currencyName = lang("currency_silver", true);
                        break;
                    case 4:
                        if (100 <= config("server_files_season", true)) {
                            $totalCurrency = $dB->query_fetch_single("SELECT WCoin FROM T_InGameShop_Point WHERE AccountID = ?", [$_SESSION["username"]]);
                            $totalCurrency = $totalCurrency["WCoin"];
                        } else {
                            $totalCurrency = $dB->query_fetch_single("SELECT WCoinC FROM T_InGameShop_Point WHERE AccountID = ?", [$_SESSION["username"]]);
                            $totalCurrency = $totalCurrency["WCoinC"];
                        }
                        $currencyName = lang("currency_wcoinc", true);
                        break;
                    case -4:
                        $totalCurrency = $dB->query_fetch_single("SELECT WCoinP FROM T_InGameShop_Point WHERE AccountID = ?", [$_SESSION["username"]]);
                        $totalCurrency = $totalCurrency["WCoinP"];
                        $currencyName = lang("currency_wcoinp", true);
                        break;
                    case 5:
                        $totalCurrency = $dB->query_fetch_single("SELECT GoblinPoint FROM T_InGameShop_Point WHERE AccountID = ?", [$_SESSION["username"]]);
                        $totalCurrency = $totalCurrency["GoblinPoint"];
                        $currencyName = lang("currency_gp", true);
                        break;
                    case 6:
                        $totalCurrency = $dB->query_fetch_single("SELECT zen FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$_SESSION["username"]]);
                        $totalCurrency = $totalCurrency["zen"];
                        $currencyName = "" . lang("currency_zen", true) . "";
                        break;
                    case 7:
                        $totalCurrency = $dB->query_fetch_single("SELECT bless FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$_SESSION["username"]]);
                        $totalCurrency = $totalCurrency["bless"];
                        $currencyName = "" . lang("currency_bless", true) . "";
                        break;
                    case 8:
                        $totalCurrency = $dB->query_fetch_single("SELECT soul FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$_SESSION["username"]]);
                        $totalCurrency = $totalCurrency["soul"];
                        $currencyName = "" . lang("currency_soul", true) . "";
                        break;
                    case 9:
                        $totalCurrency = $dB->query_fetch_single("SELECT life FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$_SESSION["username"]]);
                        $totalCurrency = $totalCurrency["life"];
                        $currencyName = "" . lang("currency_life", true) . "";
                        break;
                    case 10:
                        $totalCurrency = $dB->query_fetch_single("SELECT chaos FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$_SESSION["username"]]);
                        $totalCurrency = $totalCurrency["chaos"];
                        $currencyName = "" . lang("currency_chaos", true) . "";
                        break;
                    case 11:
                        $totalCurrency = $dB->query_fetch_single("SELECT harmony FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$_SESSION["username"]]);
                        $totalCurrency = $totalCurrency["harmony"];
                        $currencyName = "" . lang("currency_harmony", true) . "";
                        break;
                    case 12:
                        $totalCurrency = $dB->query_fetch_single("SELECT creation FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$_SESSION["username"]]);
                        $totalCurrency = $totalCurrency["creation"];
                        $currencyName = "" . lang("currency_creation", true) . "";
                        break;
                    case 13:
                        $totalCurrency = $dB->query_fetch_single("SELECT guardian FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$_SESSION["username"]]);
                        $totalCurrency = $totalCurrency["guardian"];
                        $currencyName = "" . lang("currency_guardian", true) . "";
                        break;
                    default:
                        $query = $dB->query_fetch_single("SELECT name FROM IMPERIAMUCMS_WEB_BANK_CUSTOM WHERE ident = ?", [mconfig("price_type")]);
                        $dbName = str_replace(" ", "_", $query["name"]);
                        $totalCurrency = $dB->query_fetch_single("SELECT " . $dbName . " FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$_SESSION["username"]]);
                        $totalCurrency = $totalCurrency[$dbName];
                        $currencyName = $query["name"];
                }
            }
            if ($_DEBUG) {
                echo "total currency: " . $totalCurrency . " price:" . mconfig("price") . " price type: " . mconfig("price_type") . "<br>";
            }
            if (mconfig("price") <= $totalCurrency) {
                if ($_DEBUG) {
                    echo "currency ok<br>";
                }
                if (mconfig("price_type") == "1") {
                    if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                        $query = $dB2->query("UPDATE MEMB_CREDITS SET platinum = platinum - ? WHERE memb___id = ?", [mconfig("price"), $_SESSION["username"]]);
                    } else {
                        $query = $dB->query("UPDATE MEMB_CREDITS SET platinum = platinum - ? WHERE memb___id = ?", [mconfig("price"), $_SESSION["username"]]);
                    }
                } else {
                    if (mconfig("price_type") == "2") {
                        if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                            $query = $dB2->query("UPDATE MEMB_CREDITS SET gold = gold - ? WHERE memb___id = ?", [mconfig("price"), $_SESSION["username"]]);
                        } else {
                            $query = $dB->query("UPDATE MEMB_CREDITS SET gold = gold - ? WHERE memb___id = ?", [mconfig("price"), $_SESSION["username"]]);
                        }
                    } else {
                        if (mconfig("price_type") == "3") {
                            if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                $query = $dB2->query("UPDATE MEMB_CREDITS SET silver = silver - ? WHERE memb___id = ?", [mconfig("price"), $_SESSION["username"]]);
                            } else {
                                $query = $dB->query("UPDATE MEMB_CREDITS SET silver = silver - ? WHERE memb___id = ?", [mconfig("price"), $_SESSION["username"]]);
                            }
                        } else {
                            if (mconfig("price_type") == "4") {
                                if (100 <= config("server_files_season", true)) {
                                    $query = $dB->query("UPDATE T_InGameShop_Point SET WCoin = WCoin - ? WHERE AccountID = ?", [mconfig("price"), $_SESSION["username"]]);
                                } else {
                                    $query = $dB->query("UPDATE T_InGameShop_Point SET WCoinC = WCoinC - ? WHERE AccountID = ?", [mconfig("price"), $_SESSION["username"]]);
                                }
                            } else {
                                if (mconfig("price_type") == "-4") {
                                    $query = $dB->query("UPDATE T_InGameShop_Point SET WCoinP = WCoinP - ? WHERE AccountID = ?", [mconfig("price"), $_SESSION["username"]]);
                                } else {
                                    if (mconfig("price_type") == "5") {
                                        $query = $dB->query("UPDATE T_InGameShop_Point SET GoblinPoint = GoblinPoint - ? WHERE AccountID = ?", [mconfig("price"), $_SESSION["username"]]);
                                    } else {
                                        if (mconfig("price_type") == "6") {
                                            $query = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET zen = zen - ? WHERE AccountID = ?", [mconfig("price"), $_SESSION["username"]]);
                                        } else {
                                            if (mconfig("price_type") == "7") {
                                                $query = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET bless = bless - ? WHERE AccountID = ?", [mconfig("price"), $_SESSION["username"]]);
                                            } else {
                                                if (mconfig("price_type") == "8") {
                                                    $query = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET soul = soul - ? WHERE AccountID = ?", [mconfig("price"), $_SESSION["username"]]);
                                                } else {
                                                    if (mconfig("price_type") == "9") {
                                                        $query = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET life = life - ? WHERE AccountID = ?", [mconfig("price"), $_SESSION["username"]]);
                                                    } else {
                                                        if (mconfig("price_type") == "10") {
                                                            $query = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET chaos = chaos - ? WHERE AccountID = ?", [mconfig("price"), $_SESSION["username"]]);
                                                        } else {
                                                            if (mconfig("price_type") == "11") {
                                                                $query = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET harmony = harmony - ? WHERE AccountID = ?", [mconfig("price"), $_SESSION["username"]]);
                                                            } else {
                                                                if (mconfig("price_type") == "12") {
                                                                    $query = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET creation = creation - ? WHERE AccountID = ?", [mconfig("price"), $_SESSION["username"]]);
                                                                } else {
                                                                    if (mconfig("price_type") == "13") {
                                                                        $query = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET guardian = guardian - ? WHERE AccountID = ?", [mconfig("price"), $_SESSION["username"]]);
                                                                    } else {
                                                                        $query = $dB->query_fetch_single("SELECT name FROM IMPERIAMUCMS_WEB_BANK_CUSTOM WHERE ident = ?", [mconfig("price_type")]);
                                                                        $dbName = str_replace(" ", "_", $query["name"]);
                                                                        $query = $dB->query_fetch_single("UPDATE IMPERIAMUCMS_WEB_BANK SET " . $dbName . " = " . $dbName . " - ? WHERE AccountID = ?", [mconfig("price"), $_SESSION["username"]]);
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
                if ($query) {
                    if ($_DEBUG) {
                        echo "currency update ok<br>";
                    }
                    $spinnedReward = NULL;
                    $rewards = mconfig("rewards");
                    if (is_array($rewards["reward"])) {
                        foreach ($rewards["reward"] as $thisReward) {
                            if ($_DEBUG) {
                                echo "[" . intval($thisReward["@attributes"]["id"]) . "] [" . intval($resultId + 1) . "]<br>";
                            }
                            if (intval($thisReward["@attributes"]["id"]) == intval($resultId + 1)) {
                                $spinnedReward = $thisReward;
                                if ($_DEBUG) {
                                    echo "found reward<br>";
                                }
                                if ($_DEBUG) {
                                    print_r_formatted($spinnedReward);
                                }
                            }
                        }
                    }
                    $rewardItems = "";
                    if (is_array($spinnedReward["items"]["item"]) && $spinnedReward["@attributes"]["rewardItems"] == "1") {
                        foreach ($spinnedReward["items"]["item"] as $thisItem) {
                            if ($_DEBUG) {
                                echo "[LOOP] Item:<br>";
                            }
                            if ($_DEBUG) {
                                print_r_formatted($thisItem);
                            }
                            if ($rewardItems == "") {
                                $rewardItems = $thisItem["hexcode"];
                            } else {
                                $rewardItems .= "," . $thisItem["hexcode"];
                            }
                            if ($_DEBUG) {
                                echo "[LOOP] Hex: " . $thisItem["hexcode"] . "<br>";
                            }
                        }
                    }
                    $insert = $dB->query("INSERT INTO IMPERIAMUCMS_WHEEL_OF_FORTUNE (AccountID, date, ip, price, price_type, reward, reward_type, reward_items, reward_id, reward_title) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$_SESSION["username"], date("Y-m-d H:i:s"), $_SERVER["REMOTE_ADDR"], mconfig("price"), mconfig("price_type"), $spinnedReward["@attributes"]["rewardAmount"], $spinnedReward["@attributes"]["rewardType"], $rewardItems, $spinnedReward["@attributes"]["id"], $spinnedReward["@attributes"]["title"]]);
                    $currencyRewardName = "";
                    if (0 < $spinnedReward["@attributes"]["rewardAmount"] && $spinnedReward["@attributes"]["rewardType"]) {
                        if ($spinnedReward["@attributes"]["rewardType"] == "-4") {
                            $addCurrencyReward = $dB->query("UPDATE T_InGameShop_Point SET WCoinP = WCoinP + ? WHERE AccountID = ?", [$spinnedReward["@attributes"]["rewardAmount"], $_SESSION["username"]]);
                            $currencyRewardName = lang("currency_wcoinp", true);
                        } else {
                            if ($spinnedReward["@attributes"]["rewardType"] == "7") {
                                $addCurrencyReward = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET bless = bless + ? WHERE AccountID = ?", [$spinnedReward["@attributes"]["rewardAmount"], $_SESSION["username"]]);
                                $currencyRewardName = "" . lang("currency_bless", true) . "";
                            } else {
                                if ($spinnedReward["@attributes"]["rewardType"] == "8") {
                                    $addCurrencyReward = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET soul = soul + ? WHERE AccountID = ?", [$spinnedReward["@attributes"]["rewardAmount"], $_SESSION["username"]]);
                                    $currencyRewardName = "" . lang("currency_soul", true) . "";
                                } else {
                                    if ($spinnedReward["@attributes"]["rewardType"] == "9") {
                                        $addCurrencyReward = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET life = life + ? WHERE AccountID = ?", [$spinnedReward["@attributes"]["rewardAmount"], $_SESSION["username"]]);
                                        $currencyRewardName = "" . lang("currency_life", true) . "";
                                    } else {
                                        if ($spinnedReward["@attributes"]["rewardType"] == "10") {
                                            $addCurrencyReward = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET chaos = chaos + ? WHERE AccountID = ?", [$spinnedReward["@attributes"]["rewardAmount"], $_SESSION["username"]]);
                                            $currencyRewardName = "" . lang("currency_chaos", true) . "";
                                        } else {
                                            if ($spinnedReward["@attributes"]["rewardType"] == "11") {
                                                $addCurrencyReward = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET harmony = harmony + ? WHERE AccountID = ?", [$spinnedReward["@attributes"]["rewardAmount"], $_SESSION["username"]]);
                                                $currencyRewardName = "" . lang("currency_harmony", true) . "";
                                            } else {
                                                if ($spinnedReward["@attributes"]["rewardType"] == "12") {
                                                    $addCurrencyReward = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET creation = creation + ? WHERE AccountID = ?", [$spinnedReward["@attributes"]["rewardAmount"], $_SESSION["username"]]);
                                                    $currencyRewardName = "" . lang("currency_creation", true) . "";
                                                } else {
                                                    if ($spinnedReward["@attributes"]["rewardType"] == "13") {
                                                        $addCurrencyReward = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET guardian = guardian + ? WHERE AccountID = ?", [$spinnedReward["@attributes"]["rewardAmount"], $_SESSION["username"]]);
                                                        $currencyRewardName = "" . lang("currency_guardian", true) . "";
                                                    } else {
                                                        if ("14" <= $spinnedReward["@attributes"]["rewardType"]) {
                                                            $addCurrencyReward = $dB->query_fetch_single("SELECT name FROM IMPERIAMUCMS_WEB_BANK_CUSTOM WHERE ident = ?", [$spinnedReward["@attributes"]["rewardType"]]);
                                                            $dbName = str_replace(" ", "_", $addCurrencyReward["name"]);
                                                            $addCurrencyReward = $dB->query_fetch_single("UPDATE IMPERIAMUCMS_WEB_BANK SET " . $dbName . " = " . $dbName . " + ? WHERE AccountID = ?", [$spinnedReward["@attributes"]["rewardAmount"], $_SESSION["username"]]);
                                                            $currencyRewardName = $query["name"];
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
                    $adminName = "";
                    foreach ($config["admins"] as $thisAdmin => $accessLevel) {
                        if (100 <= $accessLevel) {
                            $adminName = $thisAdmin;
                            if (!(include_once __PATH_CLASSES__ . "class.common.php")) {
                                throw new Exception("Could not load class (common).");
                            }
                            if (!(include_once __PATH_CLASSES__ . "class.character.php")) {
                                throw new Exception("Could not load class (character).");
                            }
                            if (!(include_once __PATH_CLASSES__ . "class.promo.php")) {
                                throw new Exception("Could not load class (promo).");
                            }
                            $common = new common($dB, $dB2);
                            $Promo = new Promo();
                            if ($currencyRewardName != "") {
                                $Promo->addReward(lang("wheeloffortune_txt_1", true) . " :: " . $spinnedReward["@attributes"]["title"], $adminName, $_SESSION["username"], NULL, $rewardItems, $spinnedReward["@attributes"]["rewardItemsType"], NULL, NULL, NULL, NULL, false);
                            } else {
                                $Promo->addReward(lang("wheeloffortune_txt_1", true) . " :: " . $spinnedReward["@attributes"]["title"], $adminName, $_SESSION["username"], NULL, $rewardItems, $spinnedReward["@attributes"]["rewardItemsType"], $spinnedReward["@attributes"]["rewardAmount"], $spinnedReward["@attributes"]["rewardType"], NULL, NULL, false);
                            }
                            if ($insert) {
                                $jsonMsg = sprintf(lang("wheeloffortune_txt_14", true), $spinnedReward["@attributes"]["title"], lang("myaccount_txt_81", true));
                                if (0 < $spinnedReward["@attributes"]["rewardAmount"] && $spinnedReward["@attributes"]["rewardType"] && $currencyRewardName != "") {
                                    $jsonMsg .= "<br />" . sprintf(lang("wheeloffortune_txt_27", true), $spinnedReward["@attributes"]["rewardAmount"], $currencyRewardName);
                                }
                            }
                        }
                    }
                } else {
                    throw new Exception(lang("wheeloffortune_txt_19", true));
                }
            } else {
                throw new Exception(sprintf(lang("wheeloffortune_txt_18", true), $currencyName));
            }
        } else {
            throw new Exception(lang("wheeloffortune_txt_17", true));
        }
    } else {
        throw new Exception(lang("wheeloffortune_txt_16", true));
    }
} catch (Exception $e) {
    $jsonError = @$e->getMessage();
    $json = ["deg" => $jsonDeg, "target" => $jsonTarget, "msg" => $jsonMsg, "error" => $jsonError];
    echo @json_encode($json);
}
function generateDeg($deg, $degreesPerItem, $circleDegrees, $intervalMin, $intervalMax, $totalChance, $rewards)
{
    global $randNum;
    $randNum = rand(1, $totalChance);
    $startNum = 1;
    $endNum = 0;
    $moveMe = 0;
    foreach ($rewards["reward"] as $thisReward) {
        $endNum += $thisReward["@attributes"]["chance"];
        if ($startNum <= $randNum && $randNum <= $endNum) {
            $moveMe = $degreesPerItem * $moveMe;
            $deg = $deg + $circleDegrees + $moveMe + 1800;
            return $deg;
        }
        $startNum += $thisReward["@attributes"]["chance"];
        $moveMe++;
    }
}

?>