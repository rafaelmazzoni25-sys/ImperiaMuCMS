<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

if (!isLoggedIn()) {
    redirect(1, "login");
} else {
    if (!canAccessModule($_SESSION["username"], "reset", "block")) {
        return NULL;
    }
    $Character = new Character();
    $Items = new Items();
    if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
        $breadcrumb = generateBreadcrumb();
        echo "\r\n    <h3>\r\n        " . lang("module_titles_txt_12", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
        if (mconfig("active")) {
            echo "<script type=\"text/javascript\" SRC=\"" . __PATH_TEMPLATE_ASSETS__ . "js/tooltip.js\"></script>";
            echo "\r\n    <div class=\"row desc-row\">\r\n        <div class=\"col-xs-12\">" . lang("resetcharacter_txt_14", true) . "</div>\r\n    </div>";
            $AccountCharacters = $Character->AccountCharacter($_SESSION["username"]);
            if (is_array($AccountCharacters)) {
                if (check_value($_POST["submit"])) {
                    if ($_SESSION["token"] == $_POST["token"]) {
                        if ($common->beginDbTrans($_SESSION["username"])) {
                            $Character->CharacterReset($_SESSION["username"], $_POST["character"], $_SESSION["userid"]);
                            $common->endDbTrans($_SESSION["username"]);
                        }
                    } else {
                        message("notice", lang("global_module_13", true));
                    }
                }
                $token = time();
                $_SESSION["token"] = $token;
                $resetLimit = 0;
                if ($Character->isVIP($_SESSION["username"])) {
                    $isVIP = true;
                } else {
                    $isVIP = false;
                }
                echo "\r\n    <div class=\"table-responsive rankings-table\">\r\n        <table class=\"table table-hover text-center\">\r\n            <tr>\r\n                <th class=\"headerRow\"></th>\r\n                <th class=\"headerRow\">" . lang("resetcharacter_txt_1", true) . "</th>\r\n                <th class=\"headerRow\">" . lang("resetcharacter_txt_2", true) . "</th>\r\n                <th class=\"headerRow\">" . lang("resetcharacter_txt_15", true) . "</th>";
                if ($config["use_resets"]) {
                    echo "\r\n                <th class=\"headerRow\">" . lang("resetcharacter_txt_4", true) . "</th>";
                }
                if ($config["use_grand_resets"]) {
                    echo "\r\n                <th class=\"headerRow\">" . lang("resetcharacter_txt_18", true) . "</th>";
                }
                echo "\r\n                <th class=\"headerRow\">" . lang("resetcharacter_txt_3", true) . "</th>\r\n                <th class=\"headerRow\"></th>\r\n            </tr>";
                $xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "usercp.reset.xml");
                foreach ($AccountCharacters as $thisCharacter) {
                    $characterData = $Character->CharacterData($thisCharacter);
                    $characterIMG = $Character->GenerateCharacterClassAvatar($characterData[_CLMN_CHR_CLASS_]);
                    $req_items = [];
                    if ($xml !== false) {
                        $resetConfig = [];
                        $bonusStats = 0;
                        $requiredPrice = 0;
                        $foundStage = false;
                        $fromNextStage = false;
                        $addedNextStage = false;
                        $i = 1;
                        $reqItemsCounter = 0;
                        foreach ($xml->resets->children() as $tag => $reset) {
                            if ($tag == "reset") {
                                if ($resetLimit < intval($reset["req_reset_max"])) {
                                    $resetLimit = intval($reset["req_reset_max"]);
                                }
                                if (!$foundStage) {
                                    if (intval($reset["req_reset_min"]) <= $characterData[_CLMN_CHR_RSTS_] && $characterData[_CLMN_CHR_RSTS_] <= intval($reset["req_reset_max"])) {
                                        $resetConfig["id"] = intval($reset["id"]);
                                        $resetConfig["req_reset_min"] = intval($reset["req_reset_min"]);
                                        $resetConfig["req_reset_max"] = intval($reset["req_reset_max"]);
                                        $resetConfig["price_req"] = intval($reset["price_req"]);
                                        $resetConfig["price_type"] = intval($reset["price_type"]);
                                        $resetConfig["price_formula"] = intval($reset["price_formula"]);
                                        $resetConfig["reset_stats"] = intval($reset["reset_stats"]);
                                        $resetConfig["bonus_stats_type"] = intval($reset["bonus_stats_type"]);
                                        $resetConfig["bonus_stats_formula"] = intval($reset["bonus_stats_formula"]);
                                        $resetConfig["is_cred_reward"] = intval($reset["is_cred_reward"]);
                                        $resetConfig["credit_config"] = intval($reset["credit_config"]);
                                        $resetConfig["clear_ml"] = intval($reset["clear_ml"]);
                                        $resetConfig["clear_ml_tree"] = intval($reset["clear_ml_tree"]);
                                        $resetConfig["clear_4th_tree"] = intval($reset["clear_4th_tree"]);
                                        $resetConfig["items_req"] = intval($reset["items_req"]);
                                        if ($resetConfig["items_req"]) {
                                            foreach ($reset->req_items->children() as $thisItem) {
                                                $req_items[$reqItemsCounter]["hexcode"] = strval($thisItem["hexcode"]);
                                                $req_items[$reqItemsCounter]["count"] = intval($thisItem["count"]);
                                                $reqItemsCounter++;
                                            }
                                        }
                                        if ($isVIP) {
                                            $resetConfig["price"] = intval($reset["price_vip"]);
                                            $resetConfig["req_lvl"] = intval($reset["req_lvl_vip"]);
                                            $resetConfig["req_mlvl"] = intval($reset["req_mlvl_vip"]);
                                            if ($resetConfig["bonus_stats_type"] == "1") {
                                                $resetConfig["bonus_stats"] = intval($reset["bonus_stats_vip_" . $characterData["Class"]]);
                                            } else {
                                                $resetConfig["bonus_stats"] = intval($reset["bonus_stats_vip"]);
                                            }
                                            $resetConfig["cred_reward"] = intval($reset["cred_reward_vip"]);
                                            $resetConfig["time"] = intval($reset["time_vip"]);
                                        } else {
                                            $resetConfig["price"] = intval($reset["price"]);
                                            $resetConfig["req_lvl"] = intval($reset["req_lvl"]);
                                            $resetConfig["req_mlvl"] = intval($reset["req_mlvl"]);
                                            if ($resetConfig["bonus_stats_type"] == "1") {
                                                $resetConfig["bonus_stats"] = intval($reset["bonus_stats_" . $characterData["Class"]]);
                                            } else {
                                                $resetConfig["bonus_stats"] = intval($reset["bonus_stats"]);
                                            }
                                            $resetConfig["cred_reward"] = intval($reset["cred_reward"]);
                                            $resetConfig["time"] = intval($reset["time"]);
                                        }
                                        if ($resetConfig["price_formula"] && mconfig("stage_price_separate") == "0") {
                                            $requiredPrice += ($characterData[_CLMN_CHR_RSTS_] + 1 - $resetConfig["req_reset_min"]) * $resetConfig["price"];
                                        } else {
                                            if ($resetConfig["price_formula"] && mconfig("stage_price_separate") == "1") {
                                                $requiredPrice += ($characterData[_CLMN_CHR_RSTS_] + 1) * $resetConfig["price"];
                                            } else {
                                                $requiredPrice = $resetConfig["price"];
                                            }
                                        }
                                        if ($resetConfig["bonus_stats_formula"] && mconfig("stage_price_separate") == "0") {
                                            $bonusStats += ($characterData[_CLMN_CHR_RSTS_] + 1 - $resetConfig["req_reset_min"]) * $resetConfig["bonus_stats"];
                                        } else {
                                            if ($resetConfig["bonus_stats_formula"] && mconfig("stage_price_separate") == "1") {
                                                $bonusStats += ($characterData[_CLMN_CHR_RSTS_] + 1) * $resetConfig["bonus_stats"];
                                            } else {
                                                $bonusStats = $resetConfig["bonus_stats"];
                                            }
                                        }
                                        $foundStage = true;
                                    } else {
                                        if (intval($reset["price_formula"]) && mconfig("stage_price_separate") == "0") {
                                            if ($isVIP) {
                                                $requiredPrice += (intval($reset["req_reset_max"]) - intval($reset["req_reset_min"]) + 1) * intval($reset["price_vip"]);
                                            } else {
                                                $requiredPrice += (intval($reset["req_reset_max"]) - intval($reset["req_reset_min"]) + 1) * intval($reset["price"]);
                                            }
                                        }
                                        if (intval($reset["bonus_stats_formula"]) && mconfig("stage_price_separate") == "0") {
                                            if ($isVIP) {
                                                $tmpBonusStats = 0;
                                                if (intval($reset["bonus_stats_type"]) == "1") {
                                                    $tmpBonusStats = intval($reset["bonus_stats_vip_" . $characterData["Class"]]);
                                                } else {
                                                    $tmpBonusStats = intval($reset["bonus_stats_vip"]);
                                                }
                                                $bonusStats += (intval($reset["req_reset_max"]) - intval($reset["req_reset_min"]) + 1) * $tmpBonusStats;
                                            } else {
                                                $tmpBonusStats = 0;
                                                if (intval($reset["bonus_stats_type"]) == "1") {
                                                    $tmpBonusStats = intval($reset["bonus_stats_" . $characterData["Class"]]);
                                                } else {
                                                    $tmpBonusStats = intval($reset["bonus_stats"]);
                                                }
                                                $bonusStats += (intval($reset["req_reset_max"]) - intval($reset["req_reset_min"]) + 1) * $tmpBonusStats;
                                            }
                                        }
                                    }
                                } else {
                                    if ($fromNextStage && !$addedNextStage) {
                                        if ($isVIP) {
                                            $requiredPrice += intval($reset["price_vip"]);
                                            if (intval($reset["bonus_stats_type"]) == "1") {
                                                $bonusStats += intval($reset["bonus_stats_vip_" . $characterData["Class"]]);
                                            } else {
                                                $bonusStats += intval($reset["bonus_stats_vip"]);
                                            }
                                        } else {
                                            $requiredPrice += intval($reset["price"]);
                                            if (intval($reset["bonus_stats_type"]) == "1") {
                                                $bonusStats += intval($reset["bonus_stats_" . $characterData["Class"]]);
                                            } else {
                                                $bonusStats += intval($reset["bonus_stats"]);
                                            }
                                        }
                                        $addedNextStage = true;
                                    }
                                }
                            }
                        }
                    }
                    if ($characterData[_CLMN_CHR_RSTS_] < $resetLimit) {
                        $rowspan = 4;
                    } else {
                        $rowspan = 1;
                    }
                    if ($resetConfig["items_req"]) {
                        $rowspan++;
                    }
                    echo "\r\n            <form action=\"\" method=\"post\">\r\n                <input type=\"hidden\" name=\"character\" value=\"" . Encode($characterData[_CLMN_CHR_NAME_]) . "\"/>\r\n                <tr>\r\n                    <td rowspan=\"" . ($rowspan + 1) . "\">" . $characterIMG . "</td>\r\n                </tr>\r\n                <tr>\r\n                    <td>" . $common->replaceHtmlSymbols($characterData[_CLMN_CHR_NAME_]) . "</td>\r\n                    <td>" . $characterData[_CLMN_CHR_LVL_] . "</td>\r\n                    <td>" . $characterData["mLevel"] . "</td>";
                    if ($config["use_resets"]) {
                        echo "\r\n                    <td>" . $characterData[_CLMN_CHR_RSTS_] . "</td>";
                    }
                    if ($config["use_grand_resets"]) {
                        echo "\r\n                    <td>" . $characterData["Grand_Resets"] . "</td>";
                    }
                    echo "\r\n                    <td>" . number_format($characterData[_CLMN_CHR_ZEN_]) . "</td>";
                    $price_type = $resetConfig["price_type"];
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
                                        } else {
                                            if ($price_type == "7") {
                                                $price_type = "" . lang("currency_bless", true) . " (" . lang("myaccount_txt_60", true) . ")";
                                            } else {
                                                if ($price_type == "8") {
                                                    $price_type = "" . lang("currency_soul", true) . " (" . lang("myaccount_txt_60", true) . ")";
                                                } else {
                                                    if ($price_type == "9") {
                                                        $price_type = "" . lang("currency_life", true) . " (" . lang("myaccount_txt_60", true) . ")";
                                                    } else {
                                                        if ($price_type == "10") {
                                                            $price_type = "" . lang("currency_chaos", true) . " (" . lang("myaccount_txt_60", true) . ")";
                                                        } else {
                                                            if ($price_type == "11") {
                                                                $price_type = "" . lang("currency_harmony", true) . " (" . lang("myaccount_txt_60", true) . ")";
                                                            } else {
                                                                if ($price_type == "12") {
                                                                    $price_type = "" . lang("currency_creation", true) . " (" . lang("myaccount_txt_60", true) . ")";
                                                                } else {
                                                                    if ($price_type == "13") {
                                                                        $price_type = "" . lang("currency_guardian", true) . " (" . lang("myaccount_txt_60", true) . ")";
                                                                    } else {
                                                                        $customItem = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_WEB_BANK_CUSTOM WHERE ident = ?", [$price_type]);
                                                                        $price_type = $customItem["name"] . " (" . lang("myaccount_txt_60", true) . ")";
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
                    $price_type2 = $resetConfig["credit_config"];
                    if ($price_type2 == "1") {
                        $price_type2 = lang("currency_platinum", true);
                    } else {
                        if ($price_type2 == "2") {
                            $price_type2 = lang("currency_gold", true);
                        } else {
                            if ($price_type2 == "3") {
                                $price_type2 = lang("currency_silver", true);
                            } else {
                                if ($price_type2 == "4") {
                                    $price_type2 = lang("currency_wcoinc", true);
                                } else {
                                    if ($price_type2 == "5") {
                                        $price_type2 = lang("currency_gp", true);
                                    } else {
                                        if ($price_type2 == "6") {
                                            $price_type2 = "" . lang("currency_zen", true) . "";
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $lacking = NULL;
                    if ($resetLimit <= $characterData[_CLMN_CHR_RSTS_]) {
                        $lacking = lang("resetcharacter_txt_19", true);
                    } else {
                        if ($characterData[_CLMN_CHR_LVL_] < $resetConfig["req_lvl"]) {
                            $lvl_lacking = $resetConfig["req_lvl"] - $characterData[_CLMN_CHR_LVL_];
                            if ($lacking == NULL) {
                                $lacking = sprintf(lang("resetcharacter_txt_20", true), $lvl_lacking);
                            } else {
                                $lacking .= sprintf(lang("resetcharacter_txt_23", true), $lvl_lacking);
                            }
                        }
                        if ($characterData["mLevel"] < $resetConfig["req_mlvl"]) {
                            $mlvl_lacking = $resetConfig["req_mlvl"] - $characterData["mLevel"];
                            if ($lacking == NULL) {
                                $lacking = sprintf(lang("resetcharacter_txt_21", true), $mlvl_lacking);
                            } else {
                                $lacking .= sprintf(lang("resetcharacter_txt_24", true), $mlvl_lacking);
                            }
                        }
                        if ($resetConfig["price_req"]) {
                            switch ($resetConfig["price_type"]) {
                                case 1:
                                    $return["column"] = "platinum";
                                    $return["table"] = "MEMB_CREDITS";
                                    $return["ident"] = "memb___id";
                                    $return["name"] = lang("currency_platinum", true);
                                    if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                        $checkCurrency = $dB2->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$_SESSION["username"]]);
                                    } else {
                                        $checkCurrency = $dB->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$_SESSION["username"]]);
                                    }
                                    break;
                                case 2:
                                    $return["column"] = "gold";
                                    $return["table"] = "MEMB_CREDITS";
                                    $return["ident"] = "memb___id";
                                    $return["name"] = lang("currency_gold", true);
                                    if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                        $checkCurrency = $dB2->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$_SESSION["username"]]);
                                    } else {
                                        $checkCurrency = $dB->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$_SESSION["username"]]);
                                    }
                                    break;
                                case 3:
                                    $return["column"] = "silver";
                                    $return["table"] = "MEMB_CREDITS";
                                    $return["ident"] = "memb___id";
                                    $return["name"] = lang("currency_silver", true);
                                    if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                        $checkCurrency = $dB2->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$_SESSION["username"]]);
                                    } else {
                                        $checkCurrency = $dB->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$_SESSION["username"]]);
                                    }
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
                                    $checkCurrency = $dB->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$_SESSION["username"]]);
                                    break;
                                case 5:
                                    $return["column"] = "GoblinPoint";
                                    $return["table"] = "T_InGameShop_Point";
                                    $return["ident"] = "AccountID";
                                    $return["name"] = lang("currency_gp", true);
                                    $checkCurrency = $dB->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$_SESSION["username"]]);
                                    break;
                                case 6:
                                    $return["column"] = "Money";
                                    $return["table"] = "Character";
                                    $return["ident"] = "AccountID";
                                    $return["name"] = "" . lang("currency_zen", true) . "";
                                    $checkCurrency = $dB->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ? AND Name = ?", [$_SESSION["username"], $characterData["Name"]]);
                                    break;
                                case 7:
                                    $return["column"] = "bless";
                                    $return["table"] = "IMPERIAMUCMS_WEB_BANK";
                                    $return["ident"] = "AccountID";
                                    $return["name"] = "" . lang("currency_bless", true) . " (" . lang("myaccount_txt_60", true) . ")";
                                    $checkCurrency = $dB->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$_SESSION["username"]]);
                                    break;
                                case 8:
                                    $return["column"] = "soul";
                                    $return["table"] = "IMPERIAMUCMS_WEB_BANK";
                                    $return["ident"] = "AccountID";
                                    $return["name"] = "" . lang("currency_soul", true) . " (" . lang("myaccount_txt_60", true) . ")";
                                    $checkCurrency = $dB->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$_SESSION["username"]]);
                                    break;
                                case 9:
                                    $return["column"] = "life";
                                    $return["table"] = "IMPERIAMUCMS_WEB_BANK";
                                    $return["ident"] = "AccountID";
                                    $return["name"] = "" . lang("currency_life", true) . " (" . lang("myaccount_txt_60", true) . ")";
                                    $checkCurrency = $dB->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$_SESSION["username"]]);
                                    break;
                                case 10:
                                    $return["column"] = "chaos";
                                    $return["table"] = "IMPERIAMUCMS_WEB_BANK";
                                    $return["ident"] = "AccountID";
                                    $return["name"] = "" . lang("currency_chaos", true) . " (" . lang("myaccount_txt_60", true) . ")";
                                    $checkCurrency = $dB->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$_SESSION["username"]]);
                                    break;
                                case 11:
                                    $return["column"] = "harmony";
                                    $return["table"] = "IMPERIAMUCMS_WEB_BANK";
                                    $return["ident"] = "AccountID";
                                    $return["name"] = "" . lang("currency_harmony", true) . " (" . lang("myaccount_txt_60", true) . ")";
                                    $checkCurrency = $dB->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$_SESSION["username"]]);
                                    break;
                                case 12:
                                    $return["column"] = "creation";
                                    $return["table"] = "IMPERIAMUCMS_WEB_BANK";
                                    $return["ident"] = "AccountID";
                                    $return["name"] = "" . lang("currency_creation", true) . " (" . lang("myaccount_txt_60", true) . ")";
                                    $checkCurrency = $dB->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$_SESSION["username"]]);
                                    break;
                                case 13:
                                    $return["column"] = "guardian";
                                    $return["table"] = "IMPERIAMUCMS_WEB_BANK";
                                    $return["ident"] = "AccountID";
                                    $return["name"] = "" . lang("currency_guardian", true) . " (" . lang("myaccount_txt_60", true) . ")";
                                    $checkCurrency = $dB->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$_SESSION["username"]]);
                                    break;
                                default:
                                    $customItem = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_WEB_BANK_CUSTOM WHERE ident = ?", [$resetConfig["price_type"]]);
                                    $return["column"] = str_replace(" ", "_", $customItem["name"]);
                                    $return["table"] = "IMPERIAMUCMS_WEB_BANK";
                                    $return["ident"] = "AccountID";
                                    $return["name"] = $customItem["name"] . " (" . lang("myaccount_txt_60", true) . ")";
                                    $checkCurrency = $dB->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$_SESSION["username"]]);
                                    if ($resetConfig["price_formula"]) {
                                        $resetConfig_price = $resetConfig["price"] * ($characterData[_CLMN_CHR_RSTS_] + 1);
                                    }
                                    if ($checkCurrency[$return["column"]] < $resetConfig["price"]) {
                                        $currency_lacking = $requiredPrice - $checkCurrency[$return["column"]];
                                        if ($lacking == NULL) {
                                            $lacking = lang("resetcharacter_txt_22", true) . " " . number_format($currency_lacking) . " " . $price_type;
                                        } else {
                                            $lacking .= ", " . number_format($currency_lacking) . " " . $price_type;
                                        }
                                    }
                            }
                        }
                        if (0 < $resetConfig["time"]) {
                            $checkTime = $dB->query_fetch_single("SELECT TOP 1 * FROM IMPERIAMUCMS_CHARACTER_PROGRESS_LOGS \r\n                                                          WHERE AccountID = ? AND Name = ? AND Type = ? AND NewValue > 0\r\n                                                          ORDER BY Date DESC", [$_SESSION["username"], $characterData["Name"], 1]);
                            if ($checkTime["Date"] != NULL) {
                                $resetTime = strtotime($checkTime["Date"]) + $resetConfig["time"] * 60;
                                if (time() < $resetTime) {
                                    $wait = $resetTime - time();
                                    $hours = $wait / 3600;
                                    $wait = $wait % 3600;
                                    $minutes = $wait / 60;
                                    $seconds = $wait % 60;
                                    $lacking = sprintf(lang("resetcharacter_txt_36", true), $hours, $minutes, $seconds);
                                }
                            }
                        }
                    }
                    if ($lacking == NULL) {
                        echo "\r\n                    <td>\r\n                        <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                        <button name=\"submit\" value=\"submit\" class=\"btn btn-warning full-width-btn\">\r\n                            " . lang("resetcharacter_txt_5", true) . "\r\n                        </button>\r\n                    </td>";
                    } else {
                        echo "\r\n                    <td>" . $lacking . "</td>";
                    }
                    $requirements = "";
                    $rewards = "";
                    $resetStats = "";
                    $clearML = "";
                    $clearMlTree = "";
                    if (0 < $resetConfig["req_lvl"]) {
                        if ($requirements == "") {
                            $requirements .= sprintf(lang("resetcharacter_txt_26", true), $resetConfig["req_lvl"]);
                        } else {
                            $requirements .= ", " . sprintf(lang("resetcharacter_txt_26", true), $resetConfig["req_lvl"]);
                        }
                    }
                    if (0 < $resetConfig["req_mlvl"]) {
                        if ($requirements == "") {
                            $requirements .= sprintf(lang("resetcharacter_txt_27", true), $resetConfig["req_mlvl"]);
                        } else {
                            $requirements .= ", " . sprintf(lang("resetcharacter_txt_27", true), $resetConfig["req_mlvl"]);
                        }
                    }
                    if ($resetConfig["price_req"]) {
                        if ($requirements == "") {
                            $requirements .= sprintf(lang("resetcharacter_txt_28", true), number_format($requiredPrice), $price_type);
                        } else {
                            $requirements .= ", " . sprintf(lang("resetcharacter_txt_28", true), number_format($requiredPrice), $price_type);
                        }
                    }
                    loadModuleConfigs("usercp.greset");
                    $gr_bonus = mconfig("gresets_bonus_stats");
                    $gr_bonus_formula = mconfig("gresets_bonus_stats_formula");
                    loadModuleConfigs("usercp.reset");
                    if ($resetConfig["reset_stats"] == "1" && mconfig("keep_gr_bonus") && 0 < $gr_bonus && 0 < $characterData["Grand_Resets"]) {
                        if ($gr_bonus_formula == "2") {
                            $bonusStats += $characterData["RESETS"] * $gr_bonus;
                        } else {
                            if ($gr_bonus_formula == "1") {
                                $bonusStats += $characterData["Grand_Resets"] * $gr_bonus;
                            } else {
                                if ($gr_bonus_formula == "0") {
                                    $bonusStats += $gr_bonus;
                                }
                            }
                        }
                    }
                    if (0 < $resetConfig["bonus_stats"]) {
                        if ($rewards == "") {
                            $rewards .= sprintf(lang("resetcharacter_txt_30", true), number_format($bonusStats));
                        } else {
                            $rewards .= ", " . sprintf(lang("resetcharacter_txt_30", true), number_format($bonusStats));
                        }
                    }
                    if ($resetConfig["is_cred_reward"]) {
                        if ($rewards == "") {
                            $rewards .= sprintf(lang("resetcharacter_txt_28", true), number_format($resetConfig["cred_reward"]), $price_type2);
                        } else {
                            $rewards .= ", " . sprintf(lang("resetcharacter_txt_28", true), number_format($resetConfig["cred_reward"]), $price_type2);
                        }
                    }
                    if ($resetConfig["reset_stats"]) {
                        $resetStats = lang("resetcharacter_txt_33", true);
                    } else {
                        $resetStats = lang("resetcharacter_txt_34", true);
                    }
                    if ($resetConfig["clear_ml"]) {
                        $clearML = lang("resetcharacter_txt_33", true);
                    } else {
                        $clearML = lang("resetcharacter_txt_34", true);
                    }
                    if ($resetConfig["clear_ml_tree"]) {
                        $clearMlTree = lang("resetcharacter_txt_33", true);
                    } else {
                        $clearMlTree = lang("resetcharacter_txt_34", true);
                    }
                    if ($resetConfig["clear_4th_tree"]) {
                        $clear4thTree = lang("resetcharacter_txt_33", true);
                    } else {
                        $clear4thTree = lang("resetcharacter_txt_34", true);
                    }
                    echo "\r\n                </tr>";
                    if ($characterData[_CLMN_CHR_RSTS_] < $resetLimit) {
                        echo "\r\n                <tr>\r\n                    <td colspan=\"7\" align=\"left\">\r\n                        <small>" . lang("resetcharacter_txt_25", true) . " " . $requirements . "</small>\r\n                    </td>\r\n                </tr>";
                        if ($resetConfig["items_req"] && is_array($req_items)) {
                            $req_items_info = "";
                            foreach ($req_items as $thisItem) {
                                $itemInfo = $Items->ItemInfo($thisItem["hexcode"]);
                                if ($req_items_info != "") {
                                    $req_items_info .= ", ";
                                }
                                $req_items_info .= $thisItem["count"] . "x <span style=\"cursor: pointer;\" onmouseover=\"Tip(" . $Items->generateItemTooltip($itemInfo, 1, 0, 0, 1, 0, 0) . ")\" onmouseout=\"UnTip()\">" . $itemInfo["name"] . "</span>";
                            }
                            echo "\r\n                <tr>\r\n                    <td colspan=\"7\" align=\"left\"><small>" . lang("resetcharacter_txt_40", true) . " " . $req_items_info . "</small></td>\r\n                </tr>";
                        }
                        echo "\r\n                <tr>\r\n                    <td colspan=\"7\" align=\"left\"><small>" . lang("resetcharacter_txt_29", true) . " " . $rewards . "</small></td>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan=\"2\" align=\"left\"><small>" . lang("resetcharacter_txt_31", true) . " " . $resetStats . "</small></td>\r\n                    <td colspan=\"2\" align=\"left\"><small>" . lang("resetcharacter_txt_32", true) . " " . $clearML . "</small></td>\r\n                    <td colspan=\"2\" align=\"left\"><small>" . lang("resetcharacter_txt_41", true) . " " . $clearMlTree . "</small></td>\r\n                    <td colspan=\"1\" align=\"left\">";
                        if (120 <= config("server_files_season", true)) {
                            echo "<small>" . lang("resetcharacter_txt_88", true) . " " . $clear4thTree . "</small>";
                        }
                        echo "\r\n                    </td>\r\n                </tr>";
                    }
                    echo "\r\n            </form>";
                }
                echo "\r\n        </table>\r\n    </div>";
            } else {
                message("error", lang("error_46", true));
            }
        } else {
            message("error", lang("error_47", true));
        }
    } else {
        echo "\r\n<div class=\"sub-page-title\">\r\n    <div id=\"title\">\r\n        <h1>" . lang("module_titles_txt_3", true) . "<p></p><span></span></h1>\r\n    </div>\r\n</div>\r\n\r\n<div class=\"container_2 account\" align=\"center\">\r\n    <div class=\"cont-image\">\r\n        <div class=\"container_3 account_sub_header\">\r\n            <div class=\"grad\">\r\n                <div class=\"page-title\"><p>" . lang("module_titles_txt_12", true) . "</p></div>\r\n                <a href=\"" . __BASE_URL__ . "usercp\">" . lang("global_module_1", true) . "</a>\r\n            </div>\r\n        </div>\r\n        <div class=\"page-desc-holder\">\r\n            " . lang("resetcharacter_txt_14", true) . "\r\n        </div>";
        if (mconfig("active")) {
            echo "<script type=\"text/javascript\" SRC=\"" . __PATH_TEMPLATE__ . "js/tooltip.js\"></script>";
            $AccountCharacters = $Character->AccountCharacter($_SESSION["username"]);
            if (is_array($AccountCharacters)) {
                if (check_value($_POST["submit"])) {
                    if ($_SESSION["token"] == $_POST["token"]) {
                        $Character->CharacterReset($_SESSION["username"], $_POST["character"], $_SESSION["userid"]);
                    } else {
                        message("notice", lang("global_module_13", true));
                    }
                }
                $token = time();
                $_SESSION["token"] = $token;
                $resetLimit = 0;
                if ($Character->isVIP($_SESSION["username"])) {
                    $isVIP = true;
                } else {
                    $isVIP = false;
                }
                echo "\r\n        <div class=\"container_3 account-wide\" align=\"center\">\r\n            <table class=\"general-table-ui\" cellspacing=\"0\">\r\n                <tr>\r\n                    <th></th>\r\n                    <th>" . lang("resetcharacter_txt_1", true) . "</th>\r\n                    <th>" . lang("resetcharacter_txt_2", true) . "</th>\r\n                    <th>" . lang("resetcharacter_txt_15", true) . "</th>";
                if ($config["use_resets"]) {
                    echo "<th>" . lang("resetcharacter_txt_4", true) . "</th>";
                }
                if ($config["use_grand_resets"]) {
                    echo "<th>" . lang("resetcharacter_txt_18", true) . "</th>";
                }
                echo "<th>" . lang("resetcharacter_txt_3", true) . "</th>\r\n                    <th></th>\r\n                </tr>";
                $xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "usercp.reset.xml");
                foreach ($AccountCharacters as $thisCharacter) {
                    $characterData = $Character->CharacterData($thisCharacter);
                    $characterIMG = $Character->GenerateCharacterClassAvatar($characterData[_CLMN_CHR_CLASS_]);
                    $req_items = [];
                    if ($xml !== false) {
                        $resetConfig = [];
                        $bonusStats = 0;
                        $requiredPrice = 0;
                        $foundStage = false;
                        $fromNextStage = false;
                        $addedNextStage = false;
                        $i = 1;
                        $reqItemsCounter = 0;
                        foreach ($xml->resets->children() as $tag => $reset) {
                            if ($tag == "reset") {
                                if ($resetLimit < intval($reset["req_reset_max"])) {
                                    $resetLimit = intval($reset["req_reset_max"]);
                                }
                                if (!$foundStage) {
                                    if (intval($reset["req_reset_min"]) <= $characterData[_CLMN_CHR_RSTS_] && $characterData[_CLMN_CHR_RSTS_] <= intval($reset["req_reset_max"])) {
                                        $resetConfig["id"] = intval($reset["id"]);
                                        $resetConfig["req_reset_min"] = intval($reset["req_reset_min"]);
                                        $resetConfig["req_reset_max"] = intval($reset["req_reset_max"]);
                                        $resetConfig["price_req"] = intval($reset["price_req"]);
                                        $resetConfig["price_type"] = intval($reset["price_type"]);
                                        $resetConfig["price_formula"] = intval($reset["price_formula"]);
                                        $resetConfig["reset_stats"] = intval($reset["reset_stats"]);
                                        $resetConfig["bonus_stats_type"] = intval($reset["bonus_stats_type"]);
                                        $resetConfig["bonus_stats_formula"] = intval($reset["bonus_stats_formula"]);
                                        $resetConfig["is_cred_reward"] = intval($reset["is_cred_reward"]);
                                        $resetConfig["credit_config"] = intval($reset["credit_config"]);
                                        $resetConfig["clear_ml"] = intval($reset["clear_ml"]);
                                        $resetConfig["clear_ml_tree"] = intval($reset["clear_ml_tree"]);
                                        $resetConfig["clear_4th_tree"] = intval($reset["clear_4th_tree"]);
                                        $resetConfig["items_req"] = intval($reset["items_req"]);
                                        if ($resetConfig["items_req"]) {
                                            foreach ($reset->req_items->children() as $thisItem) {
                                                $req_items[$reqItemsCounter]["hexcode"] = strval($thisItem["hexcode"]);
                                                $req_items[$reqItemsCounter]["count"] = intval($thisItem["count"]);
                                                $reqItemsCounter++;
                                            }
                                        }
                                        if ($isVIP) {
                                            $resetConfig["price"] = intval($reset["price_vip"]);
                                            $resetConfig["req_lvl"] = intval($reset["req_lvl_vip"]);
                                            $resetConfig["req_mlvl"] = intval($reset["req_mlvl_vip"]);
                                            if ($resetConfig["bonus_stats_type"] == "1") {
                                                $resetConfig["bonus_stats"] = intval($reset["bonus_stats_vip_" . $characterData["Class"]]);
                                            } else {
                                                $resetConfig["bonus_stats"] = intval($reset["bonus_stats_vip"]);
                                            }
                                            $resetConfig["cred_reward"] = intval($reset["cred_reward_vip"]);
                                            $resetConfig["time"] = intval($reset["time_vip"]);
                                        } else {
                                            $resetConfig["price"] = intval($reset["price"]);
                                            $resetConfig["req_lvl"] = intval($reset["req_lvl"]);
                                            $resetConfig["req_mlvl"] = intval($reset["req_mlvl"]);
                                            if ($resetConfig["bonus_stats_type"] == "1") {
                                                $resetConfig["bonus_stats"] = intval($reset["bonus_stats_" . $characterData["Class"]]);
                                            } else {
                                                $resetConfig["bonus_stats"] = intval($reset["bonus_stats"]);
                                            }
                                            $resetConfig["cred_reward"] = intval($reset["cred_reward"]);
                                            $resetConfig["time"] = intval($reset["time"]);
                                        }
                                        if ($resetConfig["price_formula"]) {
                                            $requiredPrice += ($characterData[_CLMN_CHR_RSTS_] + 1 - $resetConfig["req_reset_min"]) * $resetConfig["price"];
                                        } else {
                                            $requiredPrice = $resetConfig["price"];
                                        }
                                        if ($resetConfig["bonus_stats_formula"]) {
                                            $bonusStats += ($characterData[_CLMN_CHR_RSTS_] + 1 - $resetConfig["req_reset_min"]) * $resetConfig["bonus_stats"];
                                        } else {
                                            $bonusStats = $resetConfig["bonus_stats"];
                                        }
                                        $foundStage = true;
                                    } else {
                                        if (intval($reset["price_formula"]) && mconfig("stage_price_separate") == "0") {
                                            if ($isVIP) {
                                                $requiredPrice += (intval($reset["req_reset_max"]) - intval($reset["req_reset_min"]) + 1) * intval($reset["price_vip"]);
                                            } else {
                                                $requiredPrice += (intval($reset["req_reset_max"]) - intval($reset["req_reset_min"]) + 1) * intval($reset["price"]);
                                            }
                                        }
                                        if (intval($reset["bonus_stats_formula"])) {
                                            if ($isVIP) {
                                                $tmpBonusStats = 0;
                                                if (intval($reset["bonus_stats_type"]) == "1") {
                                                    $tmpBonusStats = intval($reset["bonus_stats_vip_" . $characterData["Class"]]);
                                                } else {
                                                    $tmpBonusStats = intval($reset["bonus_stats_vip"]);
                                                }
                                                $bonusStats += (intval($reset["req_reset_max"]) - intval($reset["req_reset_min"]) + 1) * $tmpBonusStats;
                                            } else {
                                                $tmpBonusStats = 0;
                                                if (intval($reset["bonus_stats_type"]) == "1") {
                                                    $tmpBonusStats = intval($reset["bonus_stats_" . $characterData["Class"]]);
                                                } else {
                                                    $tmpBonusStats = intval($reset["bonus_stats"]);
                                                }
                                                $bonusStats += (intval($reset["req_reset_max"]) - intval($reset["req_reset_min"]) + 1) * $tmpBonusStats;
                                            }
                                        }
                                    }
                                } else {
                                    if ($fromNextStage && !$addedNextStage) {
                                        if ($isVIP) {
                                            $requiredPrice += intval($reset["price_vip"]);
                                            if (intval($reset["bonus_stats_type"]) == "1") {
                                                $bonusStats += intval($reset["bonus_stats_vip_" . $characterData["Class"]]);
                                            } else {
                                                $bonusStats += intval($reset["bonus_stats_vip"]);
                                            }
                                        } else {
                                            $requiredPrice += intval($reset["price"]);
                                            if (intval($reset["bonus_stats_type"]) == "1") {
                                                $bonusStats += intval($reset["bonus_stats_" . $characterData["Class"]]);
                                            } else {
                                                $bonusStats += intval($reset["bonus_stats"]);
                                            }
                                        }
                                        $addedNextStage = true;
                                    }
                                }
                            }
                        }
                    }
                    if ($characterData[_CLMN_CHR_RSTS_] < $resetLimit) {
                        $rowspan = 4;
                    } else {
                        $rowspan = 1;
                    }
                    if ($resetConfig["items_req"]) {
                        $rowspan++;
                    }
                    echo "<form action=\"\" method=\"post\">\r\n            <input type=\"hidden\" name=\"character\" value=\"" . Encode($characterData[_CLMN_CHR_NAME_]) . "\"/>\r\n            <tr>\r\n            <td rowspan=\"" . $rowspan . "\">" . $characterIMG . "</td>\r\n            <td>" . $common->replaceHtmlSymbols($characterData[_CLMN_CHR_NAME_]) . "</td>\r\n            <td>" . $characterData[_CLMN_CHR_LVL_] . "</td>\r\n            <td>" . $characterData["mLevel"] . "</td>";
                    if ($config["use_resets"]) {
                        echo "<td>" . $characterData[_CLMN_CHR_RSTS_] . "</td>";
                    }
                    if ($config["use_grand_resets"]) {
                        echo "<td>" . $characterData["Grand_Resets"] . "</td>";
                    }
                    echo "<td>" . number_format($characterData[_CLMN_CHR_ZEN_]) . "</td>";
                    $price_type = $resetConfig["price_type"];
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
                                        } else {
                                            if ($price_type == "7") {
                                                $price_type = "" . lang("currency_bless", true) . " (" . lang("myaccount_txt_60", true) . ")";
                                            } else {
                                                if ($price_type == "8") {
                                                    $price_type = "" . lang("currency_soul", true) . " (" . lang("myaccount_txt_60", true) . ")";
                                                } else {
                                                    if ($price_type == "9") {
                                                        $price_type = "" . lang("currency_life", true) . " (" . lang("myaccount_txt_60", true) . ")";
                                                    } else {
                                                        if ($price_type == "10") {
                                                            $price_type = "" . lang("currency_chaos", true) . " (" . lang("myaccount_txt_60", true) . ")";
                                                        } else {
                                                            if ($price_type == "11") {
                                                                $price_type = "" . lang("currency_harmony", true) . " (" . lang("myaccount_txt_60", true) . ")";
                                                            } else {
                                                                if ($price_type == "12") {
                                                                    $price_type = "" . lang("currency_creation", true) . " (" . lang("myaccount_txt_60", true) . ")";
                                                                } else {
                                                                    if ($price_type == "13") {
                                                                        $price_type = "" . lang("currency_guardian", true) . " (" . lang("myaccount_txt_60", true) . ")";
                                                                    } else {
                                                                        $customItem = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_WEB_BANK_CUSTOM WHERE ident = ?", [$price_type]);
                                                                        $price_type = $customItem["name"] . " (" . lang("myaccount_txt_60", true) . ")";
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
                    $price_type2 = $resetConfig["credit_config"];
                    if ($price_type2 == "1") {
                        $price_type2 = lang("currency_platinum", true);
                    } else {
                        if ($price_type2 == "2") {
                            $price_type2 = lang("currency_gold", true);
                        } else {
                            if ($price_type2 == "3") {
                                $price_type2 = lang("currency_silver", true);
                            } else {
                                if ($price_type2 == "4") {
                                    $price_type2 = lang("currency_wcoinc", true);
                                } else {
                                    if ($price_type2 == "5") {
                                        $price_type2 = lang("currency_gp", true);
                                    } else {
                                        if ($price_type2 == "6") {
                                            $price_type2 = "" . lang("currency_zen", true) . "";
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $lacking = NULL;
                    if ($resetLimit <= $characterData[_CLMN_CHR_RSTS_]) {
                        $lacking = lang("resetcharacter_txt_19", true);
                    } else {
                        if ($characterData[_CLMN_CHR_LVL_] < $resetConfig["req_lvl"]) {
                            $lvl_lacking = $resetConfig["req_lvl"] - $characterData[_CLMN_CHR_LVL_];
                            if ($lacking == NULL) {
                                $lacking = sprintf(lang("resetcharacter_txt_20", true), $lvl_lacking);
                            } else {
                                $lacking .= sprintf(lang("resetcharacter_txt_23", true), $lvl_lacking);
                            }
                        }
                        if ($characterData["mLevel"] < $resetConfig["req_mlvl"]) {
                            $mlvl_lacking = $resetConfig["req_mlvl"] - $characterData["mLevel"];
                            if ($lacking == NULL) {
                                $lacking = sprintf(lang("resetcharacter_txt_21", true), $mlvl_lacking);
                            } else {
                                $lacking .= sprintf(lang("resetcharacter_txt_24", true), $mlvl_lacking);
                            }
                        }
                        if ($resetConfig["price_req"]) {
                            switch ($resetConfig["price_type"]) {
                                case 1:
                                    $return["column"] = "platinum";
                                    $return["table"] = "MEMB_CREDITS";
                                    $return["ident"] = "memb___id";
                                    $return["name"] = lang("currency_platinum", true);
                                    if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                        $checkCurrency = $dB2->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$_SESSION["username"]]);
                                    } else {
                                        $checkCurrency = $dB->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$_SESSION["username"]]);
                                    }
                                    break;
                                case 2:
                                    $return["column"] = "gold";
                                    $return["table"] = "MEMB_CREDITS";
                                    $return["ident"] = "memb___id";
                                    $return["name"] = lang("currency_gold", true);
                                    if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                        $checkCurrency = $dB2->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$_SESSION["username"]]);
                                    } else {
                                        $checkCurrency = $dB->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$_SESSION["username"]]);
                                    }
                                    break;
                                case 3:
                                    $return["column"] = "silver";
                                    $return["table"] = "MEMB_CREDITS";
                                    $return["ident"] = "memb___id";
                                    $return["name"] = lang("currency_silver", true);
                                    if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                        $checkCurrency = $dB2->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$_SESSION["username"]]);
                                    } else {
                                        $checkCurrency = $dB->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$_SESSION["username"]]);
                                    }
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
                                    $checkCurrency = $dB->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$_SESSION["username"]]);
                                    break;
                                case 5:
                                    $return["column"] = "GoblinPoint";
                                    $return["table"] = "T_InGameShop_Point";
                                    $return["ident"] = "AccountID";
                                    $return["name"] = lang("currency_gp", true);
                                    $checkCurrency = $dB->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$_SESSION["username"]]);
                                    break;
                                case 6:
                                    $return["column"] = "Money";
                                    $return["table"] = "Character";
                                    $return["ident"] = "AccountID";
                                    $return["name"] = "" . lang("currency_zen", true) . "";
                                    $checkCurrency = $dB->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ? AND Name = ?", [$_SESSION["username"], $characterData["Name"]]);
                                    break;
                                case 7:
                                    $return["column"] = "bless";
                                    $return["table"] = "IMPERIAMUCMS_WEB_BANK";
                                    $return["ident"] = "AccountID";
                                    $return["name"] = "" . lang("currency_bless", true) . " (" . lang("myaccount_txt_60", true) . ")";
                                    $checkCurrency = $dB->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$_SESSION["username"]]);
                                    break;
                                case 8:
                                    $return["column"] = "soul";
                                    $return["table"] = "IMPERIAMUCMS_WEB_BANK";
                                    $return["ident"] = "AccountID";
                                    $return["name"] = "" . lang("currency_soul", true) . " (" . lang("myaccount_txt_60", true) . ")";
                                    $checkCurrency = $dB->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$_SESSION["username"]]);
                                    break;
                                case 9:
                                    $return["column"] = "life";
                                    $return["table"] = "IMPERIAMUCMS_WEB_BANK";
                                    $return["ident"] = "AccountID";
                                    $return["name"] = "" . lang("currency_life", true) . " (" . lang("myaccount_txt_60", true) . ")";
                                    $checkCurrency = $dB->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$_SESSION["username"]]);
                                    break;
                                case 10:
                                    $return["column"] = "chaos";
                                    $return["table"] = "IMPERIAMUCMS_WEB_BANK";
                                    $return["ident"] = "AccountID";
                                    $return["name"] = "" . lang("currency_chaos", true) . " (" . lang("myaccount_txt_60", true) . ")";
                                    $checkCurrency = $dB->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$_SESSION["username"]]);
                                    break;
                                case 11:
                                    $return["column"] = "harmony";
                                    $return["table"] = "IMPERIAMUCMS_WEB_BANK";
                                    $return["ident"] = "AccountID";
                                    $return["name"] = "" . lang("currency_harmony", true) . " (" . lang("myaccount_txt_60", true) . ")";
                                    $checkCurrency = $dB->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$_SESSION["username"]]);
                                    break;
                                case 12:
                                    $return["column"] = "creation";
                                    $return["table"] = "IMPERIAMUCMS_WEB_BANK";
                                    $return["ident"] = "AccountID";
                                    $return["name"] = "" . lang("currency_creation", true) . " (" . lang("myaccount_txt_60", true) . ")";
                                    $checkCurrency = $dB->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$_SESSION["username"]]);
                                    break;
                                case 13:
                                    $return["column"] = "guardian";
                                    $return["table"] = "IMPERIAMUCMS_WEB_BANK";
                                    $return["ident"] = "AccountID";
                                    $return["name"] = "" . lang("currency_guardian", true) . " (" . lang("myaccount_txt_60", true) . ")";
                                    $checkCurrency = $dB->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$_SESSION["username"]]);
                                    break;
                                default:
                                    $customItem = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_WEB_BANK_CUSTOM WHERE ident = ?", [$resetConfig["price_type"]]);
                                    $return["column"] = str_replace(" ", "_", $customItem["name"]);
                                    $return["table"] = "IMPERIAMUCMS_WEB_BANK";
                                    $return["ident"] = "AccountID";
                                    $return["name"] = $customItem["name"] . " (" . lang("myaccount_txt_60", true) . ")";
                                    $checkCurrency = $dB->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$_SESSION["username"]]);
                                    if ($resetConfig["price_formula"]) {
                                        $resetConfig_price = $resetConfig["price"] * ($characterData[_CLMN_CHR_RSTS_] + 1);
                                    }
                                    if ($checkCurrency[$return["column"]] < $resetConfig["price"]) {
                                        $currency_lacking = $requiredPrice - $checkCurrency[$return["column"]];
                                        if ($lacking == NULL) {
                                            $lacking = lang("resetcharacter_txt_22", true) . " " . number_format($currency_lacking) . " " . $price_type;
                                        } else {
                                            $lacking .= ", " . number_format($currency_lacking) . " " . $price_type;
                                        }
                                    }
                            }
                        }
                        if (0 < $resetConfig["time"]) {
                            $checkTime = $dB->query_fetch_single("SELECT TOP 1 * FROM IMPERIAMUCMS_CHARACTER_PROGRESS_LOGS \r\n                                                          WHERE AccountID = ? AND Name = ? AND Type = ? AND NewValue > 0\r\n                                                          ORDER BY Date DESC", [$_SESSION["username"], $characterData["Name"], 1]);
                            if ($checkTime["Date"] != NULL) {
                                $resetTime = strtotime($checkTime["Date"]) + $resetConfig["time"] * 60;
                                if (time() < $resetTime) {
                                    $wait = $resetTime - time();
                                    $hours = $wait / 3600;
                                    $wait = $wait % 3600;
                                    $minutes = $wait / 60;
                                    $seconds = $wait % 60;
                                    $lacking = sprintf(lang("resetcharacter_txt_36", true), $hours, $minutes, $seconds);
                                }
                            }
                        }
                    }
                    if ($lacking == NULL) {
                        echo "<td><input type=\"hidden\" name=\"token\" value=\"" . $token . "\"><button name=\"submit\" value=\"submit\" class=\"ui-button button1\" ><span class=\"button-left\"><span class=\"button-right\">" . lang("resetcharacter_txt_5", true) . "</span></span></button></td>";
                    } else {
                        echo "<td>" . $lacking . "</td>";
                    }
                    $requirements = "";
                    $rewards = "";
                    $resetStats = "";
                    $clearML = "";
                    $clearMlTree = "";
                    if (0 < $resetConfig["req_lvl"]) {
                        if ($requirements == "") {
                            $requirements .= sprintf(lang("resetcharacter_txt_26", true), $resetConfig["req_lvl"]);
                        } else {
                            $requirements .= ", " . sprintf(lang("resetcharacter_txt_26", true), $resetConfig["req_lvl"]);
                        }
                    }
                    if (0 < $resetConfig["req_mlvl"]) {
                        if ($requirements == "") {
                            $requirements .= sprintf(lang("resetcharacter_txt_27", true), $resetConfig["req_mlvl"]);
                        } else {
                            $requirements .= ", " . sprintf(lang("resetcharacter_txt_27", true), $resetConfig["req_mlvl"]);
                        }
                    }
                    if ($resetConfig["price_req"]) {
                        if ($requirements == "") {
                            $requirements .= sprintf(lang("resetcharacter_txt_28", true), number_format($requiredPrice), $price_type);
                        } else {
                            $requirements .= ", " . sprintf(lang("resetcharacter_txt_28", true), number_format($requiredPrice), $price_type);
                        }
                    }
                    loadModuleConfigs("usercp.greset");
                    $gr_bonus = mconfig("gresets_bonus_stats");
                    $gr_bonus_formula = mconfig("gresets_bonus_stats_formula");
                    loadModuleConfigs("usercp.reset");
                    if ($resetConfig["reset_stats"] == "1" && mconfig("keep_gr_bonus") && 0 < $gr_bonus && 0 < $characterData["Grand_Resets"]) {
                        if ($gr_bonus_formula == "2") {
                            $bonusStats += $characterData["RESETS"] * $gr_bonus;
                        } else {
                            if ($gr_bonus_formula == "1") {
                                $bonusStats += $characterData["Grand_Resets"] * $gr_bonus;
                            } else {
                                if ($gr_bonus_formula == "0") {
                                    $bonusStats += $gr_bonus;
                                }
                            }
                        }
                    }
                    if (0 < $resetConfig["bonus_stats"]) {
                        if ($rewards == "") {
                            $rewards .= sprintf(lang("resetcharacter_txt_30", true), number_format($bonusStats));
                        } else {
                            $rewards .= ", " . sprintf(lang("resetcharacter_txt_30", true), number_format($bonusStats));
                        }
                    }
                    if ($resetConfig["is_cred_reward"]) {
                        if ($rewards == "") {
                            $rewards .= sprintf(lang("resetcharacter_txt_28", true), number_format($resetConfig["cred_reward"]), $price_type2);
                        } else {
                            $rewards .= ", " . sprintf(lang("resetcharacter_txt_28", true), number_format($resetConfig["cred_reward"]), $price_type2);
                        }
                    }
                    if ($resetConfig["reset_stats"]) {
                        $resetStats = lang("resetcharacter_txt_33", true);
                    } else {
                        $resetStats = lang("resetcharacter_txt_34", true);
                    }
                    if ($resetConfig["clear_ml"]) {
                        $clearML = lang("resetcharacter_txt_33", true);
                    } else {
                        $clearML = lang("resetcharacter_txt_34", true);
                    }
                    if ($resetConfig["clear_ml_tree"]) {
                        $clearMlTree = lang("resetcharacter_txt_33", true);
                    } else {
                        $clearMlTree = lang("resetcharacter_txt_34", true);
                    }
                    if ($resetConfig["clear_4th_tree"]) {
                        $clear4thTree = lang("resetcharacter_txt_33", true);
                    } else {
                        $clear4thTree = lang("resetcharacter_txt_34", true);
                    }
                    echo "\r\n            </tr>";
                    if ($characterData[_CLMN_CHR_RSTS_] < $resetLimit) {
                        echo "\r\n                <tr>\r\n                    <td colspan=\"7\" align=\"left\"><small>" . lang("resetcharacter_txt_25", true) . " " . $requirements . "</small></td>\r\n                </tr>";
                        if ($resetConfig["items_req"] && is_array($req_items)) {
                            $req_items_info = "";
                            foreach ($req_items as $thisItem) {
                                $itemInfo = $Items->ItemInfo($thisItem["hexcode"]);
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
                                if ($req_items_info != "") {
                                    $req_items_info .= ", ";
                                }
                                $req_items_info .= $thisItem["count"] . "x <span style=\"cursor: pointer;\" onmouseover=\"Tip('<center><img src=" . $itemInfo["thumb"] . "><br /><font color=#FF99CC>" . $itemInfo["jog"] . "</font><font color=FFCC00>" . $itemInfo["harm"] . "</font><br>" . $option . " " . $luck . " " . $skill . " " . $exl . " <br>" . $ancsetopt . "<br><font color=#4d668d>" . $itemInfo["socket"] . "</font><br><br><span class=itemTooltipClassReq>" . $itemInfo["classReq"] . "</span></center>', TITLEFONTCOLOR, '" . $itemInfo["color"] . "',TITLE,'" . addslashes($itemInfo["name"]) . $itemInfo["level"] . "',TITLEBGCOLOR,'" . $itemInfo["anco"] . "')\" onmouseout=\"UnTip()\">" . $itemInfo["name"] . "</span>";
                            }
                            echo "\r\n                <tr>\r\n                    <td colspan=\"7\" align=\"left\"><small>" . lang("resetcharacter_txt_40", true) . " " . $req_items_info . "</small></td>\r\n                </tr>";
                        }
                        echo "\r\n                <tr>\r\n                    <td colspan=\"7\" align=\"left\"><small>" . lang("resetcharacter_txt_29", true) . " " . $rewards . "</small></td>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan=\"2\" align=\"left\"><small>" . lang("resetcharacter_txt_31", true) . " " . $resetStats . "</small></td>\r\n                    <td colspan=\"2\" align=\"left\"><small>" . lang("resetcharacter_txt_32", true) . " " . $clearML . "</small></td>\r\n                    <td colspan=\"2\" align=\"left\"><small>" . lang("resetcharacter_txt_41", true) . " " . $clearMlTree . "</small></td>\r\n                    <td colspan=\"1\" align=\"left\"></td>\r\n                </tr>";
                    }
                    echo "\r\n            </form>";
                }
                echo "</table>\r\n        </div>";
            } else {
                message("error", lang("error_46", true));
            }
        } else {
            message("error", lang("error_47", true));
        }
        echo "\r\n\t</div>\r\n</div>";
    }
}

?>