<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

if (!isLoggedIn()) {
    redirect(1, "login");
} else {
    if (!canAccessModule($_SESSION["username"], "cashshop", "block")) {
        return NULL;
    }
    $CashShop = new CashShop();
    if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
        $breadcrumb = generateBreadcrumb();
        echo "\r\n    <h3>\r\n        " . lang("cashshop_txt_1", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
        if (mconfig("active")) {
            $General = new xGeneral();
            $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("cashshop");
            $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("cashshop");
            if (check_value($_GET["cat"])) {
                $activeCat = xss_clean(htmlspecialchars($_GET["cat"]));
                if (check_value($_GET["sub"])) {
                    $activeSubcat = xss_clean(htmlspecialchars($_GET["sub"]));
                }
            } else {
                $activeCat = mconfig("default_cat");
                $activeSubcat = mconfig("default_subcat");
            }
            $cats = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_CASHSHOP_CATEGORIES WHERE active = '1' ORDER BY position ASC");
            $subcats = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_CASHSHOP_SUBCATEGORIES WHERE active = '1' ORDER BY position ASC");
            echo "\r\n    <div class=\"row\">\r\n        <div class=\"col-xs-12 col-md-4 col-lg-3\">";
            foreach ($cats as $thisCat) {
                if ($activeCat == $thisCat["id"]) {
                    $catExpanded = "true";
                    $subcatClass = "collapse in";
                } else {
                    $catExpanded = "false";
                    $subcatClass = "collapse";
                }
                echo "\r\n            <button class=\"btn btn-warning full-width-btn\" type=\"button\" data-toggle=\"collapse\" data-target=\"#subcats_" . $thisCat["id"] . "\" aria-expanded=\"" . $catExpanded . "\" aria-controls=\"subcats_" . $thisCat["id"] . "\">\r\n                " . $thisCat["title"] . "\r\n            </button>";
                if (is_array($subcats)) {
                    $subcatActive = "";
                    if ($activeSubcatAll == "all") {
                        $activeSubcatAll = " active";
                    }
                    echo "\r\n            <div id=\"subcats_" . $thisCat["id"] . "\" aria-expanded=\"" . $catExpanded . "\" class=\"" . $subcatClass . "\">\r\n                <a href=\"" . __BASE_URL__ . "usercp/cashshop/?cat=" . $thisCat["id"] . "&sub=all\">\r\n                    <button class=\"btn btn-primary full-width-btn" . $activeSubcatAll . "\" type=\"button\">\r\n                        " . lang("cashshop_txt_2", true) . "\r\n                    </button>\r\n                </a>";
                    foreach ($subcats as $thisSubcat) {
                        $subcatActive = "";
                        if ($activeSubcat == $thisSubcat["id"]) {
                            $subcatActive = " active";
                        }
                        if ($thisSubcat["category_id"] == $thisCat["id"]) {
                            echo "\r\n                <a href=\"" . __BASE_URL__ . "usercp/cashshop/?cat=" . $thisCat["id"] . "&sub=" . $thisSubcat["id"] . "\">\r\n                    <button class=\"btn btn-primary full-width-btn" . $subcatActive . "\" type=\"button\">\r\n                        " . $thisSubcat["title"] . "\r\n                    </button>\r\n                </a>";
                        }
                    }
                    echo "\r\n            </div>";
                }
                echo "<div class=\"btn-guide-cat\"></div>";
            }
            echo "\r\n        </div>\r\n        <div class=\"col-xs-12 col-md-8 col-lg-9\">";
            if (check_value($_POST["buy_item"]) && check_value($_GET["cat"]) && check_value($_GET["sub"]) && check_value($_GET["buy"])) {
                if ($_SESSION["token"] == $_POST["token"]) {
                    $itemID = xss_clean(Decode($_GET["buy"]));
                    $itemData = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_CASHSHOP_ITEMS WHERE id = ? AND active = ?", [$itemID, 1]);
                    if (is_array($itemData)) {
                        switch ($itemData["price_type"]) {
                            case "1":
                                $currencyName = lang("currency_platinum", true);
                                if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                    $currencyCheck = $dB2->query_fetch_single("SELECT platinum FROM MEMB_CREDITS WHERE memb___id = ?", [$_SESSION["username"]]);
                                } else {
                                    $currencyCheck = $dB->query_fetch_single("SELECT platinum FROM MEMB_CREDITS WHERE memb___id = ?", [$_SESSION["username"]]);
                                }
                                if (is_array($currencyCheck)) {
                                    $currencyCheck = $currencyCheck["platinum"];
                                } else {
                                    $currencyCheck = 0;
                                }
                                break;
                            case "2":
                                $currencyName = lang("currency_gold", true);
                                if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                    $currencyCheck = $dB2->query_fetch_single("SELECT gold FROM MEMB_CREDITS WHERE memb___id = ?", [$_SESSION["username"]]);
                                } else {
                                    $currencyCheck = $dB->query_fetch_single("SELECT gold FROM MEMB_CREDITS WHERE memb___id = ?", [$_SESSION["username"]]);
                                }
                                if (is_array($currencyCheck)) {
                                    $currencyCheck = $currencyCheck["gold"];
                                } else {
                                    $currencyCheck = 0;
                                }
                                break;
                            case "3":
                                $currencyName = lang("currency_silver", true);
                                if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                    $currencyCheck = $dB2->query_fetch_single("SELECT silver FROM MEMB_CREDITS WHERE memb___id = ?", [$_SESSION["username"]]);
                                } else {
                                    $currencyCheck = $dB->query_fetch_single("SELECT silver FROM MEMB_CREDITS WHERE memb___id = ?", [$_SESSION["username"]]);
                                }
                                if (is_array($currencyCheck)) {
                                    $currencyCheck = $currencyCheck["silver"];
                                } else {
                                    $currencyCheck = 0;
                                }
                                break;
                            case "4":
                                $currencyName = lang("currency_wcoinc", true);
                                if (100 <= config("server_files_season", true)) {
                                    $currencyCheck = $dB->query_fetch_single("SELECT WCoin FROM T_InGameShop_Point WHERE AccountID = ?", [$_SESSION["username"]]);
                                } else {
                                    $currencyCheck = $dB->query_fetch_single("SELECT WCoinC FROM T_InGameShop_Point WHERE AccountID = ?", [$_SESSION["username"]]);
                                }
                                if (is_array($currencyCheck)) {
                                    if (100 <= config("server_files_season", true)) {
                                        $currencyCheck = $currencyCheck["WCoin"];
                                    } else {
                                        $currencyCheck = $currencyCheck["WCoinC"];
                                    }
                                } else {
                                    $currencyCheck = 0;
                                }
                                break;
                            case "-4":
                                $currencyName = lang("currency_wcoinp", true);
                                $currencyCheck = $dB->query_fetch_single("SELECT WCoinP FROM T_InGameShop_Point WHERE AccountID = ?", [$_SESSION["username"]]);
                                if (is_array($currencyCheck)) {
                                    $currencyCheck = $currencyCheck["WCoinP"];
                                } else {
                                    $currencyCheck = 0;
                                }
                                break;
                            case "5":
                                $currencyName = lang("currency_gp", true);
                                $currencyCheck = $dB->query_fetch_single("SELECT GoblinPoint FROM T_InGameShop_Point WHERE AccountID = ?", [$_SESSION["username"]]);
                                if (is_array($currencyCheck)) {
                                    $currencyCheck = $currencyCheck["GoblinPoint"];
                                } else {
                                    $currencyCheck = 0;
                                }
                                break;
                            case "6":
                                $currencyName = "" . lang("currency_zen", true) . "";
                                $currencyCheck = $dB->query_fetch_single("SELECT zen FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$_SESSION["username"]]);
                                if (is_array($currencyCheck)) {
                                    $currencyCheck = $currencyCheck["zen"];
                                } else {
                                    $currencyCheck = 0;
                                }
                                break;
                            default:
                                if ($itemData["price"] <= $currencyCheck) {
                                    switch ($itemData["price_type"]) {
                                        case "1":
                                            if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                                $updateCurrency = $dB2->query("UPDATE MEMB_CREDITS SET platinum = platinum - ? WHERE memb___id = ?", [$itemData["price"], $_SESSION["username"]]);
                                            } else {
                                                $updateCurrency = $dB2->query("UPDATE MEMB_CREDITS SET platinum = platinum - ? WHERE memb___id = ?", [$itemData["price"], $_SESSION["username"]]);
                                            }
                                            break;
                                        case "2":
                                            if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                                $updateCurrency = $dB2->query("UPDATE MEMB_CREDITS SET gold = gold - ? WHERE memb___id = ?", [$itemData["price"], $_SESSION["username"]]);
                                            } else {
                                                $updateCurrency = $dB->query("UPDATE MEMB_CREDITS SET gold = gold - ? WHERE memb___id = ?", [$itemData["price"], $_SESSION["username"]]);
                                            }
                                            break;
                                        case "3":
                                            if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                                $updateCurrency = $dB2->query("UPDATE MEMB_CREDITS SET silver = silver - ? WHERE memb___id = ?", [$itemData["price"], $_SESSION["username"]]);
                                            } else {
                                                $updateCurrency = $dB2->query("UPDATE MEMB_CREDITS SET silver = silver - ? WHERE memb___id = ?", [$itemData["price"], $_SESSION["username"]]);
                                            }
                                            break;
                                        case "4":
                                            if (100 <= config("server_files_season", true)) {
                                                $updateCurrency = $dB->query("UPDATE T_InGameShop_Point SET WCoin = WCoin - ? WHERE AccountID = ?", [$itemData["price"], $_SESSION["username"]]);
                                            } else {
                                                $updateCurrency = $dB->query("UPDATE T_InGameShop_Point SET WCoinC = WCoinC - ? WHERE AccountID = ?", [$itemData["price"], $_SESSION["username"]]);
                                            }
                                            break;
                                        case "-4":
                                            $updateCurrency = $dB->query("UPDATE T_InGameShop_Point SET WCoinP = WCoinP - ? WHERE AccountID = ?", [$itemData["price"], $_SESSION["username"]]);
                                            break;
                                        case "5":
                                            $updateCurrency = $dB->query("UPDATE T_InGameShop_Point SET GoblinPoint = GoblinPoint - ? WHERE AccountID = ?", [$itemData["price"], $_SESSION["username"]]);
                                            break;
                                        case "6":
                                            $updateCurrency = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET zen = zen - ? WHERE AccountID = ?", [$itemData["price"], $_SESSION["username"]]);
                                            break;
                                        default:
                                            if ($updateCurrency) {
                                                $invName = lang("cashshop_txt_10", true);
                                                $insert = $dB->query("exec WZ_IBS_AddItem " . $_SESSION["username"] . ", " . $itemData["UniqueID1"] . ", " . $itemData["UniqueID2"] . ", " . $itemData["UniqueID3"] . ", 1");
                                                if ($insert) {
                                                    $dB->query("INSERT INTO IMPERIAMUCMS_CASHSHOP_LOGS (AccountID, item_id, item_name, price, price_type, target, date, ip) VALUES (?, ?, ?, ?, ?, ?, ?, ?)", [$_SESSION["username"], $itemID, $itemData["name"], $itemData["price"], $itemData["price_type"], NULL, date("Y-m-d H:i:s", time()), $_SERVER["REMOTE_ADDR"]]);
                                                    message("success", sprintf(lang("cashshop_txt_13", true), $invName));
                                                } else {
                                                    message("error", lang("error_23", true));
                                                }
                                            } else {
                                                message("error", lang("error_23", true));
                                            }
                                    }
                                } else {
                                    message("error", sprintf(lang("cashshop_txt_14", true), $currencyName));
                                }
                        }
                    } else {
                        message("error", lang("cashshop_txt_4", true));
                    }
                } else {
                    message("notice", lang("global_module_13", true));
                }
            } else {
                if (check_value($_POST["gift_item"]) && check_value($_GET["cat"]) && check_value($_GET["sub"]) && check_value($_GET["buy"])) {
                    if ($_SESSION["token"] == $_POST["token"]) {
                        $itemID = xss_clean(Decode($_GET["buy"]));
                        $targetCharacter = xss_clean($_POST["target"]);
                        $giftMsg = xss_clean($_POST["msg"]);
                        $checkCharacter = $dB->query_fetch_single("SELECT TOP 1 Name FROM Character WHERE Name = ?", [$targetCharacter]);
                        if (is_array($checkCharacter)) {
                            if (strlen($giftMsg) <= 200) {
                                $targetCharacter = $checkCharacter["Name"];
                                $itemData = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_CASHSHOP_ITEMS WHERE id = ? AND active = ? AND can_gift = ?", [$itemID, 1, 1]);
                                if (is_array($itemData)) {
                                    switch ($itemData["price_type"]) {
                                        case "1":
                                            $currencyName = lang("currency_platinum", true);
                                            if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                                $currencyCheck = $dB2->query_fetch_single("SELECT platinum FROM MEMB_CREDITS WHERE memb___id = ?", [$_SESSION["username"]]);
                                            } else {
                                                $currencyCheck = $dB->query_fetch_single("SELECT platinum FROM MEMB_CREDITS WHERE memb___id = ?", [$_SESSION["username"]]);
                                            }
                                            if (is_array($currencyCheck)) {
                                                $currencyCheck = $currencyCheck["platinum"];
                                            } else {
                                                $currencyCheck = 0;
                                            }
                                            break;
                                        case "2":
                                            $currencyName = lang("currency_gold", true);
                                            if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                                $currencyCheck = $dB2->query_fetch_single("SELECT gold FROM MEMB_CREDITS WHERE memb___id = ?", [$_SESSION["username"]]);
                                            } else {
                                                $currencyCheck = $dB->query_fetch_single("SELECT gold FROM MEMB_CREDITS WHERE memb___id = ?", [$_SESSION["username"]]);
                                            }
                                            if (is_array($currencyCheck)) {
                                                $currencyCheck = $currencyCheck["gold"];
                                            } else {
                                                $currencyCheck = 0;
                                            }
                                            break;
                                        case "3":
                                            $currencyName = lang("currency_silver", true);
                                            if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                                $currencyCheck = $dB2->query_fetch_single("SELECT silver FROM MEMB_CREDITS WHERE memb___id = ?", [$_SESSION["username"]]);
                                            } else {
                                                $currencyCheck = $dB->query_fetch_single("SELECT silver FROM MEMB_CREDITS WHERE memb___id = ?", [$_SESSION["username"]]);
                                            }
                                            if (is_array($currencyCheck)) {
                                                $currencyCheck = $currencyCheck["silver"];
                                            } else {
                                                $currencyCheck = 0;
                                            }
                                            break;
                                        case "4":
                                            $currencyName = lang("currency_wcoinc", true);
                                            if (100 <= config("server_files_season", true)) {
                                                $currencyCheck = $dB->query_fetch_single("SELECT WCoin FROM T_InGameShop_Point WHERE AccountID = ?", [$_SESSION["username"]]);
                                            } else {
                                                $currencyCheck = $dB->query_fetch_single("SELECT WCoinC FROM T_InGameShop_Point WHERE AccountID = ?", [$_SESSION["username"]]);
                                            }
                                            if (is_array($currencyCheck)) {
                                                if (100 <= config("server_files_season", true)) {
                                                    $currencyCheck = $currencyCheck["WCoin"];
                                                } else {
                                                    $currencyCheck = $currencyCheck["WCoinC"];
                                                }
                                            } else {
                                                $currencyCheck = 0;
                                            }
                                            break;
                                        case "-4":
                                            $currencyName = lang("currency_wcoinp", true);
                                            $currencyCheck = $dB->query_fetch_single("SELECT WCoinP FROM T_InGameShop_Point WHERE AccountID = ?", [$_SESSION["username"]]);
                                            if (is_array($currencyCheck)) {
                                                $currencyCheck = $currencyCheck["WCoinP"];
                                            } else {
                                                $currencyCheck = 0;
                                            }
                                            break;
                                        case "5":
                                            $currencyName = lang("currency_gp", true);
                                            $currencyCheck = $dB->query_fetch_single("SELECT GoblinPoint FROM T_InGameShop_Point WHERE AccountID = ?", [$_SESSION["username"]]);
                                            if (is_array($currencyCheck)) {
                                                $currencyCheck = $currencyCheck["GoblinPoint"];
                                            } else {
                                                $currencyCheck = 0;
                                            }
                                            break;
                                        case "6":
                                            $currencyName = "" . lang("currency_zen", true) . "";
                                            $currencyCheck = $dB->query_fetch_single("SELECT zen FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$_SESSION["username"]]);
                                            if (is_array($currencyCheck)) {
                                                $currencyCheck = $currencyCheck["zen"];
                                            } else {
                                                $currencyCheck = 0;
                                            }
                                            break;
                                        default:
                                            if ($itemData["price"] <= $currencyCheck) {
                                                switch ($itemData["price_type"]) {
                                                    case "1":
                                                        if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                                            $updateCurrency = $dB2->query("UPDATE MEMB_CREDITS SET platinum = platinum - ? WHERE memb___id = ?", [$itemData["price"], $_SESSION["username"]]);
                                                        } else {
                                                            $updateCurrency = $dB2->query("UPDATE MEMB_CREDITS SET platinum = platinum - ? WHERE memb___id = ?", [$itemData["price"], $_SESSION["username"]]);
                                                        }
                                                        break;
                                                    case "2":
                                                        if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                                            $updateCurrency = $dB2->query("UPDATE MEMB_CREDITS SET gold = gold - ? WHERE memb___id = ?", [$itemData["price"], $_SESSION["username"]]);
                                                        } else {
                                                            $updateCurrency = $dB->query("UPDATE MEMB_CREDITS SET gold = gold - ? WHERE memb___id = ?", [$itemData["price"], $_SESSION["username"]]);
                                                        }
                                                        break;
                                                    case "3":
                                                        if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                                            $updateCurrency = $dB2->query("UPDATE MEMB_CREDITS SET silver = silver - ? WHERE memb___id = ?", [$itemData["price"], $_SESSION["username"]]);
                                                        } else {
                                                            $updateCurrency = $dB2->query("UPDATE MEMB_CREDITS SET silver = silver - ? WHERE memb___id = ?", [$itemData["price"], $_SESSION["username"]]);
                                                        }
                                                        break;
                                                    case "4":
                                                        if (100 <= config("server_files_season", true)) {
                                                            $updateCurrency = $dB->query("UPDATE T_InGameShop_Point SET WCoin = WCoin - ? WHERE AccountID = ?", [$itemData["price"], $_SESSION["username"]]);
                                                        } else {
                                                            $updateCurrency = $dB->query("UPDATE T_InGameShop_Point SET WCoinC = WCoinC - ? WHERE AccountID = ?", [$itemData["price"], $_SESSION["username"]]);
                                                        }
                                                        break;
                                                    case "-4":
                                                        $updateCurrency = $dB->query("UPDATE T_InGameShop_Point SET WCoinP = WCoinP - ? WHERE AccountID = ?", [$itemData["price"], $_SESSION["username"]]);
                                                        break;
                                                    case "5":
                                                        $updateCurrency = $dB->query("UPDATE T_InGameShop_Point SET GoblinPoint = GoblinPoint - ? WHERE AccountID = ?", [$itemData["price"], $_SESSION["username"]]);
                                                        break;
                                                    case "6":
                                                        $updateCurrency = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET zen = zen - ? WHERE AccountID = ?", [$itemData["price"], $_SESSION["username"]]);
                                                        break;
                                                    default:
                                                        if ($updateCurrency) {
                                                            $insert = $dB->query("exec WZ_IBS_AddGift " . $targetCharacter . ", " . $itemData["UniqueID1"] . ", " . $itemData["UniqueID2"] . ", " . $itemData["UniqueID3"] . ", 2, " . $_SESSION["username"] . ", '" . $giftMsg . "'");
                                                            if ($insert) {
                                                                $dB->query("INSERT INTO IMPERIAMUCMS_CASHSHOP_LOGS (AccountID, item_id, item_name, price, price_type, target, date, ip) VALUES (?, ?, ?, ?, ?, ?, ?, ?)", [$_SESSION["username"], $itemID, $itemData["name"], $itemData["price"], $itemData["price_type"], $targetCharacter, date("Y-m-d H:i:s", time()), $_SERVER["REMOTE_ADDR"]]);
                                                                message("success", sprintf(lang("cashshop_txt_19", true), $targetCharacter));
                                                            } else {
                                                                message("error", lang("error_23", true));
                                                            }
                                                        } else {
                                                            message("error", lang("error_23", true));
                                                        }
                                                }
                                            } else {
                                                message("error", sprintf(lang("cashshop_txt_14", true), $currencyName));
                                            }
                                    }
                                } else {
                                    message("error", lang("cashshop_txt_4", true));
                                }
                            } else {
                                message("error", lang("cashshop_txt_21", true));
                            }
                        } else {
                            message("error", lang("cashshop_txt_20", true));
                        }
                    } else {
                        message("notice", lang("global_module_13", true));
                    }
                }
            }
            $token = time();
            $_SESSION["token"] = $token;
            if (check_value($activeCat) && check_value($activeSubcat)) {
                if (check_value($_GET["buy"])) {
                    $itemID = xss_clean(Decode($_GET["buy"]));
                    $itemData = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_CASHSHOP_ITEMS WHERE id = ? AND active = ?", [$itemID, 1]);
                    if (is_array($itemData)) {
                        switch ($itemData["price_type"]) {
                            case "1":
                                $currencyName = lang("currency_platinum", true);
                                break;
                            case "2":
                                $currencyName = lang("currency_gold", true);
                                break;
                            case "3":
                                $currencyName = lang("currency_silver", true);
                                break;
                            case "4":
                                $currencyName = lang("currency_wcoinc", true);
                                break;
                            case "-4":
                                $currencyName = lang("currency_wcoinp", true);
                                break;
                            case "5":
                                $currencyName = lang("currency_gp", true);
                                break;
                            case "6":
                                $currencyName = "" . lang("currency_zen", true) . "";
                                break;
                            default:
                                echo "\r\n            <form method=\"post\" class=\"cashshop\">\r\n                <div class=\"row\">\r\n                    <div class=\"col-xs-12 cashshop-options\">\r\n                        <div class=\"col-xs-12 col-md-8 col-lg-6 col-md-offset-2 col-lg-offset-3 item-detail\">\r\n                            <div class=\"item-detail-title\">" . $itemData["name"] . "</div>\r\n                            <div class=\"item-detail-details\">\r\n                                <img src=\"" . __PATH_TEMPLATE_ASSETS__ . "items/" . $itemData["img"] . "\" />\r\n                            </div>\r\n                            <div class=\"item-detail-details\">\r\n                                " . lang("cashshop_txt_6", true) . " " . $itemData["description"] . "\r\n                            </div>\r\n                            <div class=\"item-detail-details\">\r\n                                " . lang("cashshop_txt_7", true) . " " . $itemData["price"] . " " . $currencyName . "\r\n                            </div>\r\n                        </div>\r\n                    </div>\r\n                </div>";
                                if (check_value($_POST["gift_item_target"])) {
                                    echo "\r\n                <div class=\"row\">\r\n                    <div class=\"col-xs-12 cashshop-options\">\r\n                        <div class=\"col-xs-12 col-md-8 col-lg-6 col-md-offset-2 col-lg-offset-3 clear\">\r\n                            <div class=\"form-group\">\r\n                                <label>" . lang("cashshop_txt_17", true) . "</label>\r\n                                <input type=\"text\" name=\"target\" id=\"target\" class=\"form-control\" />\r\n                            </div>\r\n                            <div class=\"form-group\">\r\n                                <label>" . lang("cashshop_txt_18", true) . "</label>\r\n                                <textarea name=\"msg\" id=\"msg\" maxlength=\"200\" class=\"form-control\"></textarea>\r\n                            </div>\r\n                            <div class=\"form-group\">\r\n                                <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                                <input type=\"submit\" name=\"gift_item\" value=\"" . lang("cashshop_txt_15", true) . "\" class=\"btn btn-warning full-width-btn\" onclick=\"return confirm('" . sprintf(lang("cashshop_txt_16", true), $itemData["name"], $itemData["price"], $currencyName) . "');\">\r\n                            </div>\r\n                        </div>\r\n                    </div>\r\n                </div>";
                                } else {
                                    echo "\r\n                <div class=\"row\">\r\n                    <div class=\"col-xs-12 cashshop-options\">\r\n                        <div class=\"col-xs-12 col-md-8 col-lg-6 col-md-offset-2 col-lg-offset-3 clear\">\r\n                            <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">";
                                    if ($itemData["can_gift"]) {
                                        echo "\r\n                                <div class=\"col-xs-6 clear\">\r\n                                    <input type=\"submit\" name=\"gift_item_target\" value=\"" . lang("cashshop_txt_15", true) . "\" class=\"btn btn-primary full-width-btn\">\r\n                                </div>\r\n                                <div class=\"col-xs-6 clear\">\r\n                                    <input type=\"submit\" name=\"buy_item\" value=\"" . lang("cashshop_txt_8", true) . "\" class=\"btn btn-warning full-width-btn\" onclick=\"return confirm('" . sprintf(lang("cashshop_txt_12", true), $itemData["name"], $itemData["price"], $currencyName) . "');\">\r\n                                </div>";
                                    } else {
                                        echo "\r\n                                <div class=\"col-xs-12 clear\">\r\n                                    <input type=\"submit\" name=\"buy_item\" value=\"" . lang("cashshop_txt_8", true) . "\" class=\"btn btn-warning full-width-btn\" onclick=\"return confirm('" . sprintf(lang("cashshop_txt_12", true), $itemData["name"], $itemData["price"], $currencyName) . "');\">\r\n                                </div>";
                                    }
                                    echo "\r\n                        </div>\r\n                    </div>\r\n                </div>";
                                }
                                echo "\r\n            </form>";
                        }
                    } else {
                        message("error", lang("cashshop_txt_4", true));
                    }
                } else {
                    if ($activeSubcat == "all") {
                        $items = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_CASHSHOP_ITEMS WHERE category_id = ? AND active = ? ORDER BY position ASC", [$activeCat, 1]);
                    } else {
                        $items = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_CASHSHOP_ITEMS WHERE category_id = ? AND subcategory_id = ? AND active = ? ORDER BY position ASC", [$activeCat, $activeSubcat, 1]);
                    }
                    if (is_array($items)) {
                        echo "\r\n            <div class=\"cashshop\">";
                        foreach ($items as $thisItem) {
                            echo "\r\n                <a href=\"" . __BASE_URL__ . "usercp/cashshop/?cat=" . $thisItem["category_id"] . "&sub=" . $thisItem["subcategory_id"] . "&buy=" . Encode($thisItem["id"]) . "\">\r\n                    <div class=\"col-xs-12 col-sm-6 col-md-4 col-lg-3 class-category\">\r\n                        <div class=\"cashshop-item\">\r\n                            <div class=\"cashshop-item-title\">" . $thisItem["name"] . "</div>\r\n                            <div class=\"cashshop-item-img\">\r\n                                <span class=\"cashshop-item-img-helper\"></span>";
                            if ($thisItem["img"] != NULL) {
                                echo "<img src=\"" . __PATH_TEMPLATE_ASSETS__ . "items/" . $thisItem["img"] . "\">";
                            }
                            echo "\r\n                            </div>\r\n                            <div class=\"cashshop-item-desc\">";
                            switch ($thisItem["price_type"]) {
                                case "1":
                                    $currencyName = lang("currency_platinum", true);
                                    break;
                                case "2":
                                    $currencyName = lang("currency_gold", true);
                                    break;
                                case "3":
                                    $currencyName = lang("currency_silver", true);
                                    break;
                                case "4":
                                    $currencyName = lang("currency_wcoinc", true);
                                    break;
                                case "-4":
                                    $currencyName = lang("currency_wcoinp", true);
                                    break;
                                case "5":
                                    $currencyName = lang("currency_gp", true);
                                    break;
                                case "6":
                                    $currencyName = "" . lang("currency_zen", true) . "";
                                    break;
                                default:
                                    echo "\r\n                                " . $thisItem["price"] . "</b> " . $currencyName . "\r\n                            </div>\r\n                        </div>\r\n                    </div>\r\n                </a>";
                            }
                        }
                        echo "\r\n            </div>";
                    } else {
                        message("error", lang("cashshop_txt_3", true));
                    }
                }
            } else {
                message("error", lang("cashshop_txt_3", true));
            }
            echo "\r\n        </div>\r\n    </div>";
        } else {
            message("error", lang("error_47", true));
        }
    } else {
        if (check_value($_GET["cat"])) {
            $activeCat = xss_clean(htmlspecialchars($_GET["cat"]));
            if (check_value($_GET["sub"])) {
                $activeSubcat = xss_clean(htmlspecialchars($_GET["sub"]));
            }
        } else {
            $activeCat = mconfig("default_cat");
            $activeSubcat = mconfig("default_subcat");
        }
        echo "\r\n    <div class=\"sub-page-title\">\r\n        <div id=\"title\">\r\n            <h1>";
        echo lang("module_titles_txt_3", true);
        echo "<p></p><span></span></h1>\r\n        </div>\r\n    </div>\r\n\r\n    ";
        if (mconfig("active")) {
            $General = new xGeneral();
            $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("cashshop");
            $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("cashshop");
            echo "\r\n        <div class=\"container_2 account store\" align=\"center\">\r\n            <div class=\"cont-image\">\r\n                <div class=\"container_3 account_sub_header\">\r\n                    <div class=\"grad\">\r\n                        <div class=\"page-title\">";
            echo lang("cashshop_txt_1", true);
            echo "</div>\r\n                        <a href=\"";
            echo __BASE_URL__;
            echo "usercp\">";
            echo lang("global_module_1", true);
            echo "</a>\r\n                    </div>\r\n                </div>\r\n                <div class=\"page-desc-holder\">\r\n\r\n                </div>\r\n                <script type=\"text/javascript\">\r\n                    \$(document).ready(function () {\r\n                        \$('#left_scrollbable').tinyscrollbar();\r\n                        \$('.store_items_list').tinyscrollbar();\r\n                        \$('.store_body').WarcryStore();\r\n                    });\r\n                </script>\r\n\r\n                ";
            if (check_value($_POST["buy_item"]) && check_value($_GET["cat"]) && check_value($_GET["sub"]) && check_value($_GET["buy"])) {
                if ($_SESSION["token"] == $_POST["token"]) {
                    $itemID = xss_clean(Decode($_GET["buy"]));
                    $itemData = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_CASHSHOP_ITEMS WHERE id = ? AND active = ?", [$itemID, 1]);
                    if (is_array($itemData)) {
                        switch ($itemData["price_type"]) {
                            case "1":
                                $currencyName = lang("currency_platinum", true);
                                if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                    $currencyCheck = $dB2->query_fetch_single("SELECT platinum FROM MEMB_CREDITS WHERE memb___id = ?", [$_SESSION["username"]]);
                                } else {
                                    $currencyCheck = $dB->query_fetch_single("SELECT platinum FROM MEMB_CREDITS WHERE memb___id = ?", [$_SESSION["username"]]);
                                }
                                if (is_array($currencyCheck)) {
                                    $currencyCheck = $currencyCheck["platinum"];
                                } else {
                                    $currencyCheck = 0;
                                }
                                break;
                            case "2":
                                $currencyName = lang("currency_gold", true);
                                if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                    $currencyCheck = $dB2->query_fetch_single("SELECT gold FROM MEMB_CREDITS WHERE memb___id = ?", [$_SESSION["username"]]);
                                } else {
                                    $currencyCheck = $dB->query_fetch_single("SELECT gold FROM MEMB_CREDITS WHERE memb___id = ?", [$_SESSION["username"]]);
                                }
                                if (is_array($currencyCheck)) {
                                    $currencyCheck = $currencyCheck["gold"];
                                } else {
                                    $currencyCheck = 0;
                                }
                                break;
                            case "3":
                                $currencyName = lang("currency_silver", true);
                                if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                    $currencyCheck = $dB2->query_fetch_single("SELECT silver FROM MEMB_CREDITS WHERE memb___id = ?", [$_SESSION["username"]]);
                                } else {
                                    $currencyCheck = $dB->query_fetch_single("SELECT silver FROM MEMB_CREDITS WHERE memb___id = ?", [$_SESSION["username"]]);
                                }
                                if (is_array($currencyCheck)) {
                                    $currencyCheck = $currencyCheck["silver"];
                                } else {
                                    $currencyCheck = 0;
                                }
                                break;
                            case "4":
                                $currencyName = lang("currency_wcoinc", true);
                                if (100 <= config("server_files_season", true)) {
                                    $currencyCheck = $dB->query_fetch_single("SELECT WCoin FROM T_InGameShop_Point WHERE AccountID = ?", [$_SESSION["username"]]);
                                } else {
                                    $currencyCheck = $dB->query_fetch_single("SELECT WCoinC FROM T_InGameShop_Point WHERE AccountID = ?", [$_SESSION["username"]]);
                                }
                                if (is_array($currencyCheck)) {
                                    if (100 <= config("server_files_season", true)) {
                                        $currencyCheck = $currencyCheck["WCoin"];
                                    } else {
                                        $currencyCheck = $currencyCheck["WCoinC"];
                                    }
                                } else {
                                    $currencyCheck = 0;
                                }
                                break;
                            case "-4":
                                $currencyName = lang("currency_wcoinp", true);
                                $currencyCheck = $dB->query_fetch_single("SELECT WCoinP FROM T_InGameShop_Point WHERE AccountID = ?", [$_SESSION["username"]]);
                                if (is_array($currencyCheck)) {
                                    $currencyCheck = $currencyCheck["WCoinP"];
                                } else {
                                    $currencyCheck = 0;
                                }
                                break;
                            case "5":
                                $currencyName = lang("currency_gp", true);
                                $currencyCheck = $dB->query_fetch_single("SELECT GoblinPoint FROM T_InGameShop_Point WHERE AccountID = ?", [$_SESSION["username"]]);
                                if (is_array($currencyCheck)) {
                                    $currencyCheck = $currencyCheck["GoblinPoint"];
                                } else {
                                    $currencyCheck = 0;
                                }
                                break;
                            case "6":
                                $currencyName = "" . lang("currency_zen", true) . "";
                                $currencyCheck = $dB->query_fetch_single("SELECT zen FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$_SESSION["username"]]);
                                if (is_array($currencyCheck)) {
                                    $currencyCheck = $currencyCheck["zen"];
                                } else {
                                    $currencyCheck = 0;
                                }
                                break;
                            default:
                                if ($itemData["price"] <= $currencyCheck) {
                                    switch ($itemData["price_type"]) {
                                        case "1":
                                            if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                                $updateCurrency = $dB2->query("UPDATE MEMB_CREDITS SET platinum = platinum - ? WHERE memb___id = ?", [$itemData["price"], $_SESSION["username"]]);
                                            } else {
                                                $updateCurrency = $dB2->query("UPDATE MEMB_CREDITS SET platinum = platinum - ? WHERE memb___id = ?", [$itemData["price"], $_SESSION["username"]]);
                                            }
                                            break;
                                        case "2":
                                            if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                                $updateCurrency = $dB2->query("UPDATE MEMB_CREDITS SET gold = gold - ? WHERE memb___id = ?", [$itemData["price"], $_SESSION["username"]]);
                                            } else {
                                                $updateCurrency = $dB->query("UPDATE MEMB_CREDITS SET gold = gold - ? WHERE memb___id = ?", [$itemData["price"], $_SESSION["username"]]);
                                            }
                                            break;
                                        case "3":
                                            if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                                $updateCurrency = $dB2->query("UPDATE MEMB_CREDITS SET silver = silver - ? WHERE memb___id = ?", [$itemData["price"], $_SESSION["username"]]);
                                            } else {
                                                $updateCurrency = $dB2->query("UPDATE MEMB_CREDITS SET silver = silver - ? WHERE memb___id = ?", [$itemData["price"], $_SESSION["username"]]);
                                            }
                                            break;
                                        case "4":
                                            if (100 <= config("server_files_season", true)) {
                                                $updateCurrency = $dB->query("UPDATE T_InGameShop_Point SET WCoin = WCoin - ? WHERE AccountID = ?", [$itemData["price"], $_SESSION["username"]]);
                                            } else {
                                                $updateCurrency = $dB->query("UPDATE T_InGameShop_Point SET WCoinC = WCoinC - ? WHERE AccountID = ?", [$itemData["price"], $_SESSION["username"]]);
                                            }
                                            break;
                                        case "-4":
                                            $updateCurrency = $dB->query("UPDATE T_InGameShop_Point SET WCoinP = WCoinP - ? WHERE AccountID = ?", [$itemData["price"], $_SESSION["username"]]);
                                            break;
                                        case "5":
                                            $updateCurrency = $dB->query("UPDATE T_InGameShop_Point SET GoblinPoint = GoblinPoint - ? WHERE AccountID = ?", [$itemData["price"], $_SESSION["username"]]);
                                            break;
                                        case "6":
                                            $updateCurrency = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET zen = zen - ? WHERE AccountID = ?", [$itemData["price"], $_SESSION["username"]]);
                                            break;
                                        default:
                                            if ($updateCurrency) {
                                                $invName = lang("cashshop_txt_10", true);
                                                $insert = $dB->query("exec WZ_IBS_AddItem " . $_SESSION["username"] . ", " . $itemData["UniqueID1"] . ", " . $itemData["UniqueID2"] . ", " . $itemData["UniqueID3"] . ", 1");
                                                if ($insert) {
                                                    $dB->query("INSERT INTO IMPERIAMUCMS_CASHSHOP_LOGS (AccountID, item_id, item_name, price, price_type, target, date, ip) VALUES (?, ?, ?, ?, ?, ?, ?, ?)", [$_SESSION["username"], $itemID, $itemData["name"], $itemData["price"], $itemData["price_type"], NULL, date("Y-m-d H:i:s", time()), $_SERVER["REMOTE_ADDR"]]);
                                                    message("success", sprintf(lang("cashshop_txt_13", true), $invName));
                                                } else {
                                                    message("error", lang("error_23", true));
                                                }
                                            } else {
                                                message("error", lang("error_23", true));
                                            }
                                    }
                                } else {
                                    message("error", sprintf(lang("cashshop_txt_14", true), $currencyName));
                                }
                        }
                    } else {
                        message("error", lang("cashshop_txt_4", true));
                    }
                } else {
                    message("notice", lang("global_module_13", true));
                }
            } else {
                if (check_value($_POST["gift_item"]) && check_value($_GET["cat"]) && check_value($_GET["sub"]) && check_value($_GET["buy"])) {
                    if ($_SESSION["token"] == $_POST["token"]) {
                        $itemID = xss_clean(Decode($_GET["buy"]));
                        $targetCharacter = xss_clean($_POST["target"]);
                        $giftMsg = xss_clean($_POST["msg"]);
                        $checkCharacter = $dB->query_fetch_single("SELECT TOP 1 Name FROM Character WHERE Name = ?", [$targetCharacter]);
                        if (is_array($checkCharacter)) {
                            if (strlen($giftMsg) <= 200) {
                                $targetCharacter = $checkCharacter["Name"];
                                $itemData = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_CASHSHOP_ITEMS WHERE id = ? AND active = ? AND can_gift = ?", [$itemID, 1, 1]);
                                if (is_array($itemData)) {
                                    switch ($itemData["price_type"]) {
                                        case "1":
                                            $currencyName = lang("currency_platinum", true);
                                            if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                                $currencyCheck = $dB2->query_fetch_single("SELECT platinum FROM MEMB_CREDITS WHERE memb___id = ?", [$_SESSION["username"]]);
                                            } else {
                                                $currencyCheck = $dB->query_fetch_single("SELECT platinum FROM MEMB_CREDITS WHERE memb___id = ?", [$_SESSION["username"]]);
                                            }
                                            if (is_array($currencyCheck)) {
                                                $currencyCheck = $currencyCheck["platinum"];
                                            } else {
                                                $currencyCheck = 0;
                                            }
                                            break;
                                        case "2":
                                            $currencyName = lang("currency_gold", true);
                                            if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                                $currencyCheck = $dB2->query_fetch_single("SELECT gold FROM MEMB_CREDITS WHERE memb___id = ?", [$_SESSION["username"]]);
                                            } else {
                                                $currencyCheck = $dB->query_fetch_single("SELECT gold FROM MEMB_CREDITS WHERE memb___id = ?", [$_SESSION["username"]]);
                                            }
                                            if (is_array($currencyCheck)) {
                                                $currencyCheck = $currencyCheck["gold"];
                                            } else {
                                                $currencyCheck = 0;
                                            }
                                            break;
                                        case "3":
                                            $currencyName = lang("currency_silver", true);
                                            if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                                $currencyCheck = $dB2->query_fetch_single("SELECT silver FROM MEMB_CREDITS WHERE memb___id = ?", [$_SESSION["username"]]);
                                            } else {
                                                $currencyCheck = $dB->query_fetch_single("SELECT silver FROM MEMB_CREDITS WHERE memb___id = ?", [$_SESSION["username"]]);
                                            }
                                            if (is_array($currencyCheck)) {
                                                $currencyCheck = $currencyCheck["silver"];
                                            } else {
                                                $currencyCheck = 0;
                                            }
                                            break;
                                        case "4":
                                            $currencyName = lang("currency_wcoinc", true);
                                            if (100 <= config("server_files_season", true)) {
                                                $currencyCheck = $dB->query_fetch_single("SELECT WCoin FROM T_InGameShop_Point WHERE AccountID = ?", [$_SESSION["username"]]);
                                            } else {
                                                $currencyCheck = $dB->query_fetch_single("SELECT WCoinC FROM T_InGameShop_Point WHERE AccountID = ?", [$_SESSION["username"]]);
                                            }
                                            if (is_array($currencyCheck)) {
                                                if (100 <= config("server_files_season", true)) {
                                                    $currencyCheck = $currencyCheck["WCoin"];
                                                } else {
                                                    $currencyCheck = $currencyCheck["WCoinC"];
                                                }
                                            } else {
                                                $currencyCheck = 0;
                                            }
                                            break;
                                        case "-4":
                                            $currencyName = lang("currency_wcoinp", true);
                                            $currencyCheck = $dB->query_fetch_single("SELECT WCoinP FROM T_InGameShop_Point WHERE AccountID = ?", [$_SESSION["username"]]);
                                            if (is_array($currencyCheck)) {
                                                $currencyCheck = $currencyCheck["WCoinP"];
                                            } else {
                                                $currencyCheck = 0;
                                            }
                                            break;
                                        case "5":
                                            $currencyName = lang("currency_gp", true);
                                            $currencyCheck = $dB->query_fetch_single("SELECT GoblinPoint FROM T_InGameShop_Point WHERE AccountID = ?", [$_SESSION["username"]]);
                                            if (is_array($currencyCheck)) {
                                                $currencyCheck = $currencyCheck["GoblinPoint"];
                                            } else {
                                                $currencyCheck = 0;
                                            }
                                            break;
                                        case "6":
                                            $currencyName = "" . lang("currency_zen", true) . "";
                                            $currencyCheck = $dB->query_fetch_single("SELECT zen FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$_SESSION["username"]]);
                                            if (is_array($currencyCheck)) {
                                                $currencyCheck = $currencyCheck["zen"];
                                            } else {
                                                $currencyCheck = 0;
                                            }
                                            break;
                                        default:
                                            if ($itemData["price"] <= $currencyCheck) {
                                                switch ($itemData["price_type"]) {
                                                    case "1":
                                                        if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                                            $updateCurrency = $dB2->query("UPDATE MEMB_CREDITS SET platinum = platinum - ? WHERE memb___id = ?", [$itemData["price"], $_SESSION["username"]]);
                                                        } else {
                                                            $updateCurrency = $dB2->query("UPDATE MEMB_CREDITS SET platinum = platinum - ? WHERE memb___id = ?", [$itemData["price"], $_SESSION["username"]]);
                                                        }
                                                        break;
                                                    case "2":
                                                        if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                                            $updateCurrency = $dB2->query("UPDATE MEMB_CREDITS SET gold = gold - ? WHERE memb___id = ?", [$itemData["price"], $_SESSION["username"]]);
                                                        } else {
                                                            $updateCurrency = $dB->query("UPDATE MEMB_CREDITS SET gold = gold - ? WHERE memb___id = ?", [$itemData["price"], $_SESSION["username"]]);
                                                        }
                                                        break;
                                                    case "3":
                                                        if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                                            $updateCurrency = $dB2->query("UPDATE MEMB_CREDITS SET silver = silver - ? WHERE memb___id = ?", [$itemData["price"], $_SESSION["username"]]);
                                                        } else {
                                                            $updateCurrency = $dB2->query("UPDATE MEMB_CREDITS SET silver = silver - ? WHERE memb___id = ?", [$itemData["price"], $_SESSION["username"]]);
                                                        }
                                                        break;
                                                    case "4":
                                                        if (100 <= config("server_files_season", true)) {
                                                            $updateCurrency = $dB->query("UPDATE T_InGameShop_Point SET WCoin = WCoin - ? WHERE AccountID = ?", [$itemData["price"], $_SESSION["username"]]);
                                                        } else {
                                                            $updateCurrency = $dB->query("UPDATE T_InGameShop_Point SET WCoinC = WCoinC - ? WHERE AccountID = ?", [$itemData["price"], $_SESSION["username"]]);
                                                        }
                                                        break;
                                                    case "-4":
                                                        $updateCurrency = $dB->query("UPDATE T_InGameShop_Point SET WCoinP = WCoinP - ? WHERE AccountID = ?", [$itemData["price"], $_SESSION["username"]]);
                                                        break;
                                                    case "5":
                                                        $updateCurrency = $dB->query("UPDATE T_InGameShop_Point SET GoblinPoint = GoblinPoint - ? WHERE AccountID = ?", [$itemData["price"], $_SESSION["username"]]);
                                                        break;
                                                    case "6":
                                                        $updateCurrency = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET zen = zen - ? WHERE AccountID = ?", [$itemData["price"], $_SESSION["username"]]);
                                                        break;
                                                    default:
                                                        if ($updateCurrency) {
                                                            $insert = $dB->query("exec WZ_IBS_AddGift " . $targetCharacter . ", " . $itemData["UniqueID1"] . ", " . $itemData["UniqueID2"] . ", " . $itemData["UniqueID3"] . ", 2, " . $_SESSION["username"] . ", '" . $giftMsg . "'");
                                                            if ($insert) {
                                                                $dB->query("INSERT INTO IMPERIAMUCMS_CASHSHOP_LOGS (AccountID, item_id, item_name, price, price_type, target, date, ip) VALUES (?, ?, ?, ?, ?, ?, ?, ?)", [$_SESSION["username"], $itemID, $itemData["name"], $itemData["price"], $itemData["price_type"], $targetCharacter, date("Y-m-d H:i:s", time()), $_SERVER["REMOTE_ADDR"]]);
                                                                message("success", sprintf(lang("cashshop_txt_19", true), $targetCharacter));
                                                            } else {
                                                                message("error", lang("error_23", true));
                                                            }
                                                        } else {
                                                            message("error", lang("error_23", true));
                                                        }
                                                }
                                            } else {
                                                message("error", sprintf(lang("cashshop_txt_14", true), $currencyName));
                                            }
                                    }
                                } else {
                                    message("error", lang("cashshop_txt_4", true));
                                }
                            } else {
                                message("error", lang("cashshop_txt_21", true));
                            }
                        } else {
                            message("error", lang("cashshop_txt_20", true));
                        }
                    } else {
                        message("notice", lang("global_module_13", true));
                    }
                }
            }
            $token = time();
            $_SESSION["token"] = $token;
            echo "\r\n                <div class=\"store_body\" style=\"margin: 0 0 0 0;\">\r\n                    <form id=\"store_form\" method=\"post\">\r\n                        <div class=\"store_header\" align=\"right\"></div>\r\n                        <div class=\"store_inner_body\">\r\n                            <div class=\"store_left_side\">\r\n                                <div class=\"scrollable\" id=\"left_scrollbable\">\r\n                                    <div class=\"scrollbar disable\" style=\"height: 606px;\">\r\n                                        <div class=\"track\" style=\"height: 606px;\">\r\n                                            <div class=\"thumb\" style=\"top: 0px; height: 606px;\">\r\n                                                <div class=\"end\"></div>\r\n                                            </div>\r\n                                        </div>\r\n                                    </div>\r\n                                    <div class=\"viewport\">\r\n                                        <div class=\"overview\" id=\"store_categories\" style=\"top: 0px;\">\r\n\r\n                                            ";
            $cats = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_CASHSHOP_CATEGORIES WHERE active = '1' ORDER BY position ASC");
            if (is_array($cats)) {
                $i = 1;
                foreach ($cats as $thisCat) {
                    if ($thisCat["id"] == $activeCat) {
                        $open_category = "open_category";
                        $active_category = "active_category";
                        $display_subcats = "block";
                    } else {
                        $open_category = "";
                        $active_category = "";
                        $display_subcats = "none";
                    }
                    echo "\r\n                                            <div class=\"store_category " . $open_category . "\" data-id=\"" . $i . "\">\r\n                                                <a href=\"#\" class=\"store_category_button " . $active_category . "\">\r\n                                                    <span>" . $thisCat["title"] . "</span>\r\n                                                    <p id=\"arrow\"></p>\r\n                                                    <div class=\"clear\"></div>\r\n                                                </a>";
                    $subcats = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_CASHSHOP_SUBCATEGORIES WHERE active = '1' AND category_id = ? ORDER BY position ASC", [$thisCat["id"]]);
                    if (is_array($subcats)) {
                        if ("all" == $activeSubcat && $thisCat["id"] == $activeCat) {
                            $active_category = "active_category";
                        } else {
                            $active_category = "";
                        }
                        echo "\r\n                                                    <div class=\"store_sub_categories\" align=\"left\" style=\"display: " . $display_subcats . ";\">\r\n                                                        <a href=\"" . __BASE_URL__ . "usercp/cashshop/?cat=" . $thisCat["id"] . "&sub=all\" class=\"store_sub_category_button " . $active_category . "\">\r\n                                                            <span>" . lang("cashshop_txt_2", true) . "</span>\r\n                                                        </a>\r\n                                                    </div>";
                        foreach ($subcats as $thisSubcat) {
                            if ($thisSubcat["id"] == $activeSubcat) {
                                $active_category = "active_category";
                            } else {
                                $active_category = "";
                            }
                            echo "\r\n                                                    <div class=\"store_sub_categories\" align=\"left\" style=\"display: " . $display_subcats . ";\">\r\n                                                        <a href=\"" . __BASE_URL__ . "usercp/cashshop/?cat=" . $thisCat["id"] . "&sub=" . $thisSubcat["id"] . "\" class=\"store_sub_category_button " . $active_category . "\">\r\n                                                            <span>" . $thisSubcat["title"] . "</span>\r\n                                                        </a>\r\n                                                    </div>";
                        }
                    }
                    echo "\r\n                                            </div>";
                    $i++;
                }
            }
            echo "\r\n                                        </div>\r\n                                    </div>\r\n                                </div>\r\n                            </div>\r\n                            <div class=\"store_right_side\">\r\n                                <div class=\"store_items_list\">\r\n                                    <div class=\"scrollbar disable\" style=\"height: 554px;\">\r\n                                        <div class=\"track\" style=\"height: 554px;\">\r\n                                            <div class=\"thumb\" style=\"top: 0px; height: 554px;\">\r\n                                                <div class=\"end\"></div>\r\n                                            </div>\r\n                                        </div>\r\n                                    </div>\r\n                                    <div class=\"viewport\">\r\n                                        <div class=\"overview\" style=\"top: 0px;\">\r\n\r\n                                            ";
            if (check_value($activeCat) && check_value($activeSubcat)) {
                if (check_value($_GET["buy"])) {
                    $itemID = xss_clean(Decode($_GET["buy"]));
                    $itemData = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_CASHSHOP_ITEMS WHERE id = ? AND active = ?", [$itemID, 1]);
                    if (is_array($itemData)) {
                        echo "\r\n                                                <div class=\"pay_wp\" style=\"display: block; min-height: 100px;\">\r\n                                                    <div class=\"webshop-title\">\r\n                                                        <div id=\"title\">\r\n                                                            <h1>" . $itemData["name"] . "<p></p><span></span></h1>\r\n                                                        </div>\r\n                                                    </div>";
                        if ($itemData["img"] != NULL) {
                            echo "\r\n                                                    <div class=\"auction-item-frame\" style=\"margin-top: 10px;\">\r\n                                                        <img src=\"" . __PATH_TEMPLATE__ . "img/items/" . $itemData["img"] . "\">\r\n                                                    </div>";
                        }
                        switch ($itemData["price_type"]) {
                            case "1":
                                $currencyName = lang("currency_platinum", true);
                                break;
                            case "2":
                                $currencyName = lang("currency_gold", true);
                                break;
                            case "3":
                                $currencyName = lang("currency_silver", true);
                                break;
                            case "4":
                                $currencyName = lang("currency_wcoinc", true);
                                break;
                            case "-4":
                                $currencyName = lang("currency_wcoinp", true);
                                break;
                            case "5":
                                $currencyName = lang("currency_gp", true);
                                break;
                            case "6":
                                $currencyName = "" . lang("currency_zen", true) . "";
                                break;
                            default:
                                echo "\r\n                                                </div>\r\n                                                \r\n                                                <div class=\"webshop-price\">\r\n                                                    <span class=\"title\">" . lang("cashshop_txt_5", true) . "</span>\r\n                                                    <table width=\"100%\">\r\n                                                        <tr>\r\n                                                            <td width=\"100px\" style=\"vertical-align: top;\"><b>" . lang("cashshop_txt_6", true) . "</b></td>\r\n                                                            <td align=\"right\">" . $itemData["description"] . "</td>\r\n                                                        </tr>\r\n                                                        <tr>\r\n                                                            <td width=\"100px\" style=\"vertical-align: top;\"><b>" . lang("cashshop_txt_7", true) . "</b></td>\r\n                                                            <td align=\"right\"><b>" . $itemData["price"] . "</b> " . $currencyName . "</td>\r\n                                                        </tr>\r\n                                                    </table>\r\n                                                </div>";
                                if (check_value($_POST["gift_item_target"])) {
                                    echo "\r\n                                                    <div class=\"row\" style=\"width: 100%;\">\r\n                                                        <label for=\"target\">" . lang("cashshop_txt_17", true) . "</label>\r\n                                                        <input type=\"text\" name=\"target\" id=\"target\" />\r\n                                                    </div>\r\n                                                    <div class=\"row\" style=\"width: 100%;\">\r\n                                                        <label for=\"msg\">" . lang("cashshop_txt_18", true) . "</label>\r\n                                                        <textarea name=\"msg\" id=\"msg\" maxlength=\"200\"></textarea>\r\n                                                    </div>\r\n                                                    <div style=\"width:100%; margin-top: 40px;\" align=\"right\">\r\n                                                        <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                                                        <input type=\"submit\" name=\"gift_item\" value=\"" . lang("cashshop_txt_15", true) . "\" onclick=\"return confirm('" . sprintf(lang("cashshop_txt_16", true), $itemData["name"], $itemData["price"], $currencyName) . "');\">\r\n                                                    </div>";
                                } else {
                                    echo "\r\n                                                <div style=\"width:100%;\" align=\"right\">\r\n                                                    <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">";
                                    if ($itemData["can_gift"]) {
                                        echo "<input type=\"submit\" name=\"gift_item_target\" value=\"" . lang("cashshop_txt_15", true) . "\">";
                                    }
                                    echo "\r\n                                                    <input type=\"submit\" name=\"buy_item\" value=\"" . lang("cashshop_txt_8", true) . "\" onclick=\"return confirm('" . sprintf(lang("cashshop_txt_12", true), $itemData["name"], $itemData["price"], $currencyName) . "');\">\r\n                                                </div>";
                                }
                        }
                    } else {
                        message("error", lang("cashshop_txt_4", true));
                    }
                } else {
                    if ($activeSubcat == "all") {
                        $items = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_CASHSHOP_ITEMS WHERE category_id = ? AND active = ? ORDER BY position ASC", [$activeCat, 1]);
                    } else {
                        $items = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_CASHSHOP_ITEMS WHERE category_id = ? AND subcategory_id = ? AND active = ? ORDER BY position ASC", [$activeCat, $activeSubcat, 1]);
                    }
                    if (is_array($items)) {
                        echo "<div class=\"shop_list\">";
                        foreach ($items as $thisItem) {
                            echo "\r\n                                                <a href=\"" . __BASE_URL__ . "usercp/cashshop/?cat=" . $thisItem["category_id"] . "&sub=" . $thisItem["subcategory_id"] . "&buy=" . Encode($thisItem["id"]) . "\" class=\"buy\" rel=\"\">\r\n                                                    <div class=\"item_wp\" id=\"item1\">\r\n                                                        <dl class=\"\">\r\n                                                            <dt>";
                            if ($thisItem["img"] != NULL) {
                                echo "<img src=\"" . __PATH_TEMPLATE__ . "img/items/" . $thisItem["img"] . "\">";
                            }
                            echo "\r\n                                                            </dt>\r\n                                                            <dd>\r\n                                                                <span class=\"itemname\"><b>" . $thisItem["name"] . "</b></span>\r\n                                                                <div class=\"itemcost\">";
                            switch ($thisItem["price_type"]) {
                                case "1":
                                    $currencyName = lang("currency_platinum", true);
                                    break;
                                case "2":
                                    $currencyName = lang("currency_gold", true);
                                    break;
                                case "3":
                                    $currencyName = lang("currency_silver", true);
                                    break;
                                case "4":
                                    $currencyName = lang("currency_wcoinc", true);
                                    break;
                                case "-4":
                                    $currencyName = lang("currency_wcoinp", true);
                                    break;
                                case "5":
                                    $currencyName = lang("currency_gp", true);
                                    break;
                                case "6":
                                    $currencyName = "" . lang("currency_zen", true) . "";
                                    break;
                                default:
                                    echo "<b>" . $thisItem["price"] . "</b> " . $currencyName;
                                    echo " \r\n                                                                </div>\r\n                                                            </dd>\r\n                                                        </dl>\r\n                                                    </div>\r\n                                                </a>\r\n                                                ";
                            }
                        }
                        echo "</div>";
                    } else {
                        message("error", lang("cashshop_txt_3", true));
                    }
                }
            } else {
                message("error", lang("cashshop_txt_3", true));
            }
            echo "\r\n                                        </div>\r\n                                    </div>\r\n                                </div>\r\n                            </div>\r\n                            <div class=\"clear\"></div>\r\n                        </div>\r\n                    </form>\r\n                </div>\r\n            </div>\r\n        </div>\r\n\r\n        ";
        } else {
            message("error", lang("error_47", true));
        }
    }
}

?>