<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

if (!isLoggedIn()) {
    redirect(1, "login");
} else {
    $General = new xGeneral();
    if ($General->ftanHCIfo_canUse_j8GsnawwvJ_Module("eventregistration")) {
        echo "\r\n<div class=\"sub-page-title\">\r\n    <div id=\"title\">\r\n        <h1>" . lang("module_titles_txt_3", true) . "<p></p><span></span></h1>\r\n    </div>\r\n</div>\r\n<div class=\"container_2 account\" align=\"center\">\r\n    <div class=\"cont-image\">\r\n        <div class=\"container_3 account_sub_header\">\r\n            <div class=\"grad\">";
        if (check_value($_GET["page"]) && $_GET["page"] == "closed") {
            echo "\r\n                <div class=\"page-title\"><p>" . lang("eventregistration_txt_1", true) . "</p></div>\r\n                <a href=\"" . __BASE_URL__ . "usercp/eventregistration/\">" . lang("eventregistration_txt_2", true) . "</a>";
        } else {
            echo "\r\n                <div class=\"page-title\"><p>" . lang("eventregistration_txt_3", true) . "</p></div>\r\n                <!--<a href=\"" . __BASE_URL__ . "usercp/eventregistration/page/closed/\" style=\"background-image: none;padding: 9px 12px 10px 10px\">" . lang("eventregistration_txt_1", true) . "</a>-->\r\n                <a href=\"" . __BASE_URL__ . "usercp/\">" . lang("global_module_1", true) . "</a>";
        }
        echo "\r\n            </div>\r\n        </div>\r\n        <div class=\"page-desc-holder\">" . lang("eventregistration_txt_4", true) . "</div>";
        if (mconfig("active")) {
            if (canAccessModule($_SESSION["username"], "eventregistration", "block")) {
                $Character = new Character();
                $AccountCharacters = $Character->AccountCharacter($_SESSION["username"]);
                if (is_array($AccountCharacters)) {
                    if (!(check_value($_GET["page"]) && $_GET["page"] == "closed")) {
                        if (check_value($_POST["submit"])) {
                            if (check_value($_POST["character"])) {
                                $char = xss_clean(Decode($_POST["character"]));
                                $event_id = xss_clean(Decode($_POST["event"]));
                                $checkLog = $dB->query_fetch_single("SELECT Name FROM IMPERIAMUCMS_EVENT_REGISTRATION_LOGS WHERE event_id = ? AND AccountID = ? AND Name = ?", [$event_id, $_SESSION["username"], $char]);
                                if ($checkLog["Name"] == NULL) {
                                    $eventData = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_EVENT_REGISTRATION WHERE id = ?", [$event_id]);
                                    $charData = $dB->query_fetch_single("SELECT Name, Class, cLevel, mLevel FROM Character WHERE AccountID = ? AND Name = ?", [$_SESSION["username"], $char]);
                                    $charGuild = $dB->query_fetch_single("SELECT G_Name FROM GuildMember WHERE Name = ?", [$char]);
                                    $classFilter = explode(",", $eventData["req_class"]);
                                    if ($charData["mLevel"] == NULL) {
                                        $charData["mLevel"] = 0;
                                    }
                                    if (strtotime($eventData["start_date"]) < time() && time() < strtotime($eventData["end_date"]) && $eventData["status"] == "1") {
                                        if (in_array($charData["Class"], $classFilter) && $eventData["req_lvl"] <= $charData["cLevel"] && $eventData["req_mlvl"] <= $charData["mLevel"]) {
                                            if ($eventData["price_type"] == "1") {
                                                if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                                    $query = $dB2->query_fetch_single("SELECT platinum FROM MEMB_CREDITS WHERE memb___id = ?", [$_SESSION["username"]]);
                                                } else {
                                                    $query = $dB->query_fetch_single("SELECT platinum FROM MEMB_CREDITS WHERE memb___id = ?", [$_SESSION["username"]]);
                                                }
                                                $currency = $query["platinum"];
                                                $currencyName = lang("currency_platinum", true);
                                            } else {
                                                if ($eventData["price_type"] == "2") {
                                                    if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                                        $query = $dB2->query_fetch_single("SELECT gold FROM MEMB_CREDITS WHERE memb___id = ?", [$_SESSION["username"]]);
                                                    } else {
                                                        $query = $dB->query_fetch_single("SELECT gold FROM MEMB_CREDITS WHERE memb___id = ?", [$_SESSION["username"]]);
                                                    }
                                                    $currency = $query["gold"];
                                                    $currencyName = lang("currency_gold", true);
                                                } else {
                                                    if ($eventData["price_type"] == "3") {
                                                        if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                                            $query = $dB2->query_fetch_single("SELECT silver FROM MEMB_CREDITS WHERE memb___id = ?", [$_SESSION["username"]]);
                                                        } else {
                                                            $query = $dB->query_fetch_single("SELECT silver FROM MEMB_CREDITS WHERE memb___id = ?", [$_SESSION["username"]]);
                                                        }
                                                        $currency = $query["silver"];
                                                        $currencyName = lang("currency_silver", true);
                                                    } else {
                                                        if ($eventData["price_type"] == "4") {
                                                            if (100 <= config("server_files_season", true)) {
                                                                $query = $dB->query_fetch_single("SELECT WCoin FROM T_InGameShop_Point WHERE AccountID = ?", [$_SESSION["username"]]);
                                                                $currency = $query["WCoin"];
                                                            } else {
                                                                $query = $dB->query_fetch_single("SELECT WCoinC FROM T_InGameShop_Point WHERE AccountID = ?", [$_SESSION["username"]]);
                                                                $currency = $query["WCoinC"];
                                                            }
                                                            $currencyName = lang("currency_wcoinc", true);
                                                        } else {
                                                            if ($eventData["price_type"] == "5") {
                                                                $query = $dB->query_fetch_single("SELECT GoblinPoint FROM T_InGameShop_Point WHERE AccountID = ?", [$_SESSION["username"]]);
                                                                $currency = $query["GoblinPoint"];
                                                                $currencyName = lang("currency_gp", true);
                                                            } else {
                                                                if ($eventData["price_type"] == "6") {
                                                                    $query = $dB->query_fetch_single("SELECT zen FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$_SESSION["username"]]);
                                                                    $currency = $query["zen"];
                                                                    $currencyName = "" . lang("currency_zen", true) . "";
                                                                } else {
                                                                    if ($eventData["price_type"] == "7") {
                                                                        $query = $dB->query_fetch_single("SELECT bless FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$_SESSION["username"]]);
                                                                        $currency = $query["bless"];
                                                                        $currencyName = "" . lang("currency_bless", true) . "";
                                                                    } else {
                                                                        if ($eventData["price_type"] == "8") {
                                                                            $query = $dB->query_fetch_single("SELECT soul FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$_SESSION["username"]]);
                                                                            $currency = $query["soul"];
                                                                            $currencyName = "" . lang("currency_soul", true) . "";
                                                                        } else {
                                                                            if ($eventData["price_type"] == "9") {
                                                                                $query = $dB->query_fetch_single("SELECT life FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$_SESSION["username"]]);
                                                                                $currency = $query["life"];
                                                                                $currencyName = "" . lang("currency_life", true) . "";
                                                                            } else {
                                                                                if ($eventData["price_type"] == "10") {
                                                                                    $query = $dB->query_fetch_single("SELECT chaos FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$_SESSION["username"]]);
                                                                                    $currency = $query["chaos"];
                                                                                    $currencyName = "" . lang("currency_chaos", true) . "";
                                                                                } else {
                                                                                    if ($eventData["price_type"] == "11") {
                                                                                        $query = $dB->query_fetch_single("SELECT harmony FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$_SESSION["username"]]);
                                                                                        $currency = $query["harmony"];
                                                                                        $currencyName = "" . lang("currency_harmony", true) . "";
                                                                                    } else {
                                                                                        if ($eventData["price_type"] == "12") {
                                                                                            $query = $dB->query_fetch_single("SELECT creation FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$_SESSION["username"]]);
                                                                                            $currency = $query["creation"];
                                                                                            $currencyName = "" . lang("currency_creation", true) . "";
                                                                                        } else {
                                                                                            if ($eventData["price_type"] == "13") {
                                                                                                $query = $dB->query_fetch_single("SELECT guardian FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$_SESSION["username"]]);
                                                                                                $currency = $query["guardian"];
                                                                                                $currencyName = "" . lang("currency_guardian", true) . "";
                                                                                            } else {
                                                                                                $query = $dB->query_fetch_single("SELECT name FROM IMPERIAMUCMS_WEB_BANK_CUSTOM WHERE ident = ?", [$eventData["price_type"]]);
                                                                                                $dbName = str_replace(" ", "_", $query["name"]);
                                                                                                $amount = $dB->query_fetch_single("SELECT " . $dbName . " FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$_SESSION["username"]]);
                                                                                                $currency = $amount[$dbName];
                                                                                                $currencyName = $query["name"];
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
                                            echo $currency;
                                            if ($eventData["price"] <= $currency) {
                                                if ($eventData["price_type"] == "1") {
                                                    if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                                        $query = $dB2->query("UPDATE MEMB_CREDITS SET platinum = platinum - ? WHERE memb___id = ?", [$eventData["price"], $_SESSION["username"]]);
                                                    } else {
                                                        $query = $dB->query("UPDATE MEMB_CREDITS SET platinum = platinum - ? WHERE memb___id = ?", [$eventData["price"], $_SESSION["username"]]);
                                                    }
                                                } else {
                                                    if ($eventData["price_type"] == "2") {
                                                        if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                                            $query = $dB2->query("UPDATE MEMB_CREDITS SET gold = gold - ? WHERE memb___id = ?", [$eventData["price"], $_SESSION["username"]]);
                                                        } else {
                                                            $query = $dB->query("UPDATE MEMB_CREDITS SET gold = gold - ? WHERE memb___id = ?", [$eventData["price"], $_SESSION["username"]]);
                                                        }
                                                    } else {
                                                        if ($eventData["price_type"] == "3") {
                                                            if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                                                $query = $dB2->query("UPDATE MEMB_CREDITS SET silver = silver - ? WHERE memb___id = ?", [$eventData["price"], $_SESSION["username"]]);
                                                            } else {
                                                                $query = $dB->query("UPDATE MEMB_CREDITS SET silver = silver - ? WHERE memb___id = ?", [$eventData["price"], $_SESSION["username"]]);
                                                            }
                                                        } else {
                                                            if ($eventData["price_type"] == "4") {
                                                                if (100 <= config("server_files_season", true)) {
                                                                    $query = $dB->query("UPDATE T_InGameShop_Point SET WCoin = WCoin - ? WHERE AccountID = ?", [$eventData["price"], $_SESSION["username"]]);
                                                                } else {
                                                                    $query = $dB->query("UPDATE T_InGameShop_Point SET WCoinC = WCoinC - ? WHERE AccountID = ?", [$eventData["price"], $_SESSION["username"]]);
                                                                }
                                                            } else {
                                                                if ($eventData["price_type"] == "5") {
                                                                    $query = $dB->query("UPDATE T_InGameShop_Point SET GoblinPoint = GoblinPoint - ? WHERE AccountID = ?", [$eventData["price"], $_SESSION["username"]]);
                                                                } else {
                                                                    if ($eventData["price_type"] == "6") {
                                                                        $query = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET zen = zen - ? WHERE AccountID = ?", [$eventData["price"], $_SESSION["username"]]);
                                                                    } else {
                                                                        if ($eventData["price_type"] == "7") {
                                                                            $query = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET bless = bless - ? WHERE AccountID = ?", [$eventData["price"], $_SESSION["username"]]);
                                                                        } else {
                                                                            if ($eventData["price_type"] == "8") {
                                                                                $query = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET soul = soul - ? WHERE AccountID = ?", [$eventData["price"], $_SESSION["username"]]);
                                                                            } else {
                                                                                if ($eventData["price_type"] == "9") {
                                                                                    $query = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET life = life - ? WHERE AccountID = ?", [$eventData["price"], $_SESSION["username"]]);
                                                                                } else {
                                                                                    if ($eventData["price_type"] == "10") {
                                                                                        $query = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET chaos = chaos - ? WHERE AccountID = ?", [$eventData["price"], $_SESSION["username"]]);
                                                                                    } else {
                                                                                        if ($eventData["price_type"] == "11") {
                                                                                            $query = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET harmony = harmony - ? WHERE AccountID = ?", [$eventData["price"], $_SESSION["username"]]);
                                                                                        } else {
                                                                                            if ($eventData["price_type"] == "12") {
                                                                                                $query = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET creation = creation - ? WHERE AccountID = ?", [$eventData["price"], $_SESSION["username"]]);
                                                                                            } else {
                                                                                                if ($eventData["price_type"] == "13") {
                                                                                                    $query = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET guardian = guardian - ? WHERE AccountID = ?", [$eventData["price"], $_SESSION["username"]]);
                                                                                                } else {
                                                                                                    $query = $dB->query_fetch_single("SELECT name FROM IMPERIAMUCMS_WEB_BANK_CUSTOM WHERE ident = ?", [$eventData["price_type"]]);
                                                                                                    $dbName = str_replace(" ", "_", $query["name"]);
                                                                                                    $query = $dB->query_fetch_single("UPDATE IMPERIAMUCMS_WEB_BANK SET " . $dbName . " = " . $dbName . " - ? WHERE AccountID = ?", [$eventData["price"], $_SESSION["username"]]);
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
                                                    $insert = $dB->query("INSERT INTO IMPERIAMUCMS_EVENT_REGISTRATION_LOGS (event_id, AccountID, Name, Class, cLevel, mLevel, GName, price, price_type, date, ip) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$eventData["id"], $_SESSION["username"], $char, $charData["Class"], $charData["cLevel"], $charData["mLevel"], $charGuild["G_Name"], $eventData["price"], $eventData["price_type"], date("Y-m-d H:i:s", time()), $_SERVER["REMOTE_ADDR"]]);
                                                    if ($insert) {
                                                        message("success", sprintf(lang("eventregistration_txt_22", true), $char, $eventData["title"]));
                                                    } else {
                                                        message("error", lang("error_23", true));
                                                    }
                                                } else {
                                                    message("error", lang("error_23", true));
                                                }
                                            } else {
                                                message("error", sprintf(lang("eventregistration_txt_20", true), $currencyName));
                                            }
                                        } else {
                                            message("error", lang("eventregistration_txt_19", true));
                                        }
                                    } else {
                                        message("error", lang("eventregistration_txt_18", true));
                                    }
                                } else {
                                    message("error", lang("eventregistration_txt_21", true));
                                }
                            } else {
                                message("error", lang("eventregistration_txt_17", true));
                            }
                        }
                        $token = time();
                        $_SESSION["token"] = $token;
                        $now = date("Y-m-d H:i:s", time());
                        $events = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_EVENT_REGISTRATION WHERE status = ? AND start_date <= ? AND end_date >= ?", [1, $now, $now]);
                        if (is_array($events)) {
                            foreach ($events as $thisEvent) {
                                $characters = "";
                                $charDivs = "";
                                $classFilter = explode(",", $thisEvent["req_class"]);
                                $req_class = "";
                                $filter_allClasses = "";
                                foreach ($custom["character_class"] as $classCode => $thisClass) {
                                    if ($filter_allClasses == "") {
                                        $filter_allClasses = $classCode;
                                    } else {
                                        $filter_allClasses .= "," . $classCode;
                                    }
                                }
                                if ($thisEvent["req_class"] == $filter_allClasses) {
                                    $req_class = lang("eventregistration_txt_11", true);
                                } else {
                                    foreach ($classFilter as $thisClass) {
                                        if ($req_class == "") {
                                            $req_class = $custom["character_class"][$thisClass][1];
                                        } else {
                                            $req_class .= ", " . $custom["character_class"][$thisClass][1];
                                        }
                                    }
                                }
                                if ($thisEvent["price_type"] == "1") {
                                    $thisEvent["price_type"] = lang("currency_platinum", true);
                                } else {
                                    if ($thisEvent["price_type"] == "2") {
                                        $thisEvent["price_type"] = lang("currency_gold", true);
                                    } else {
                                        if ($thisEvent["price_type"] == "3") {
                                            $thisEvent["price_type"] = lang("currency_silver", true);
                                        } else {
                                            if ($thisEvent["price_type"] == "4") {
                                                $thisEvent["price_type"] = lang("currency_wcoinc", true);
                                            } else {
                                                if ($thisEvent["price_type"] == "-4") {
                                                    $thisEvent["price_type"] = lang("currency_wcoinp", true);
                                                } else {
                                                    if ($thisEvent["price_type"] == "5") {
                                                        $thisEvent["price_type"] = lang("currency_gp", true);
                                                    } else {
                                                        if ($thisEvent["price_type"] == "6") {
                                                            $thisEvent["price_type"] = "" . lang("currency_zen", true) . "";
                                                        } else {
                                                            if ($thisEvent["price_type"] == "7") {
                                                                $thisEvent["price_type"] = "" . lang("currency_bless", true) . "";
                                                            } else {
                                                                if ($thisEvent["price_type"] == "8") {
                                                                    $thisEvent["price_type"] = "" . lang("currency_soul", true) . "";
                                                                } else {
                                                                    if ($thisEvent["price_type"] == "9") {
                                                                        $thisEvent["price_type"] = "" . lang("currency_life", true) . "";
                                                                    } else {
                                                                        if ($thisEvent["price_type"] == "10") {
                                                                            $thisEvent["price_type"] = "" . lang("currency_chaos", true) . "";
                                                                        } else {
                                                                            if ($thisEvent["price_type"] == "11") {
                                                                                $thisEvent["price_type"] = "" . lang("currency_harmony", true) . "";
                                                                            } else {
                                                                                if ($thisEvent["price_type"] == "12") {
                                                                                    $thisEvent["price_type"] = "" . lang("currency_creation", true) . "";
                                                                                } else {
                                                                                    if ($thisEvent["price_type"] == "13") {
                                                                                        $thisEvent["price_type"] = "" . lang("currency_guardian", true) . "";
                                                                                    } else {
                                                                                        $customItems = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_WEB_BANK_CUSTOM");
                                                                                        foreach ($customItems as $thisItem) {
                                                                                            if ($thisEvent["price_type"] == $thisItem["ident"]) {
                                                                                                $thisEvent["price_type"] = $thisItem["name"];
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
                                }
                                $canRegister = false;
                                foreach ($AccountCharacters as $thisCharacter) {
                                    $characterData = $Character->CharacterData($thisCharacter);
                                    $characterIMG = $Character->GenerateCharacterClassAvatar($characterData[_CLMN_CHR_CLASS_]);
                                    if (in_array($characterData["Class"], $classFilter)) {
                                        $canRegister = true;
                                        $charDivs .= "\r\n                                        <div id=\"character-option-" . Encode($characterData[_CLMN_CHR_NAME_]) . "\" style=\"display:none;\">\r\n                                            <div class=\"character-holder\">\r\n                                                <div class=\"s-class-icon " . $custom["character_class"][$characterData["Class"]][1] . "\" style=\"background-image:url(" . __BASE_URL__ . "templates/" . $config["website_template"] . "/style/images/character-icons/" . $custom["character_class"][$characterData["Class"]][3] . ");\"></div>\r\n                                                <p>" . $common->replaceHtmlSymbols($characterData[_CLMN_CHR_NAME_]) . "</p><span>" . $custom["character_class"][$characterData["Class"]][0] . "</span>\r\n                                            </div>\r\n                                        </div>";
                                        $characters .= "<option value=\"" . Encode($characterData[_CLMN_CHR_NAME_]) . "\" gethtmlfrom=\"#character-option-" . Encode($characterData[_CLMN_CHR_NAME_]) . "\">" . $common->replaceHtmlSymbols($characterData[_CLMN_CHR_NAME_]) . "</option>";
                                    }
                                }
                                echo "\r\n            <div class=\"auction\">\r\n                <form method=\"post\">\r\n                    <table>\r\n                        <tbody>\r\n                            <tr>\r\n                                <td class=\"auction-text\">\r\n                                    <div class=\"auction-title\">" . $thisEvent["title"] . "</div>\r\n                                </td>\r\n                            </tr>\r\n                            <tr>\r\n                                <td>\r\n                                    <table width=\"100%\">\r\n                                        <tr>\r\n                                            <td width=\"20%\">" . lang("eventregistration_txt_5", true) . "</td>\r\n                                            <td width=\"30%\"><b>" . date($config["time_date_format_logs"], strtotime($thisEvent["start_date"])) . "</b></td>\r\n                                            <td width=\"20%\">" . lang("eventregistration_txt_6", true) . "</td>\r\n                                            <td width=\"30%\"><b>" . date($config["time_date_format_logs"], strtotime($thisEvent["end_date"])) . "</b></td>\r\n                                        </tr>\r\n                                        <tr>\r\n                                            <td>" . lang("eventregistration_txt_7", true) . "</td>\r\n                                            <td><b>" . $thisEvent["req_lvl"] . "</b></td>\r\n                                            <td>" . lang("eventregistration_txt_8", true) . "</td>\r\n                                            <td><b>" . $thisEvent["req_mlvl"] . "</b></td>\r\n                                        </tr>\r\n                                        <tr>\r\n                                            <td>" . lang("eventregistration_txt_9", true) . "</td>\r\n                                            <td style=\"padding-right: 10px;\"><b>" . $req_class . "</b></td>\r\n                                            <td>" . lang("eventregistration_txt_10", true) . "</td>\r\n                                            <td><b>" . $thisEvent["price"] . " " . $thisEvent["price_type"] . "</b></td>\r\n                                        </tr>\r\n                                    </table>\r\n                                </td>\r\n                            </tr>";
                                if ($canRegister) {
                                    echo "\r\n                            <tr>\r\n                                <td align=\"center\">\r\n                                    <div class=\"select-charcater-s\" align=\"right\">\r\n                                        " . $charDivs . "\r\n                                        <div id=\"select-charcater-selected\" style=\"display:none;\">\r\n                                            <p class=\"select-charcater-selected\">" . lang("eventregistration_txt_12", true) . "</p>\r\n                                        </div>\r\n                                        <select styled=\"true\" id=\"character-select\" name=\"character\" style=\"display: none;\">\r\n                                            <option selected=\"selected\" disabled=\"disabled\" gethtmlfrom=\"#select-charcater-selected\"></option>\r\n                                            " . $characters . "\r\n                                        </select>\r\n                                    </div>\r\n                                    <div class=\"cooldown-ico\">\r\n                                        <div class=\"ust-cooldown\" style=\"display:block;\"></div>\r\n                                    </div>\r\n                                    <div class=\"ust-submit\" align=\"left\">\r\n                                        <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                                        <input type=\"hidden\" name=\"event\" value=\"" . Encode($thisEvent["id"]) . "\">\r\n                                        <input type=\"submit\" name=\"submit\" value=\"" . lang("eventregistration_txt_14", true) . "\">\r\n                                        <p>\r\n                                        " . lang("eventregistration_txt_15", true) . "\r\n                                        </p>\r\n                                    </div>\r\n                                </td>\r\n                            </tr>";
                                }
                                echo "\r\n                        </tbody>\r\n                    </table>\r\n                </form>";
                                if (!$canRegister) {
                                    echo "<div class=\"auction-status-box\"><span class=\"auction-outbid\">";
                                    echo lang("eventregistration_txt_13", true);
                                    echo "</span></div>";
                                }
                                echo "\r\n            </div>";
                            }
                        } else {
                            message("notice", lang("eventregistration_txt_16", true));
                        }
                    }
                } else {
                    message("error", lang("error_46", true));
                }
            } else {
                canAccessModuleMsg($_SESSION["username"], "eventregistration", "block");
            }
        } else {
            message("error", lang("error_47", true));
        }
        echo "\r\n\t</div>\r\n</div>\r\n";
    }
}

?>