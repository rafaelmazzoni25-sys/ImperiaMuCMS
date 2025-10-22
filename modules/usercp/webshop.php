<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

if (!isLoggedIn()) {
    redirect(1, "login");
} else {
    loadModuleConfigs("usercp.webshop");
    if (!canAccessModule($_SESSION["username"], "webshop", "block")) {
        return NULL;
    }
    if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
        echo "\r\n    <script type=\"text/javascript\">\r\n        var empty_option = \"" . lang("webshop_59", true) . "\";\r\n        var ratio_platinum = \"" . mconfig("ratio_platinum") . "\";\r\n        var ratio_gold = \"" . mconfig("ratio_gold") . "\";\r\n        var ratio_silver = \"" . mconfig("ratio_silver") . "\";\r\n        var ratio_wcoin = \"" . mconfig("ratio_wcoin") . "\";\r\n        var ratio_gp = \"" . mconfig("ratio_gp") . "\";\r\n        var curr_currency = \"" . mconfig("default_currency") . "\";\r\n        var price_level = \"" . mconfig("price_level") . "\";\r\n        var price_life = \"" . mconfig("price_life") . "\";\r\n        var price_luck = \"" . mconfig("price_luck") . "\";\r\n        var price_skill = \"" . mconfig("price_skill") . "\";\r\n        var price_stamina = \"" . mconfig("price_anc_stamina") . "\";\r\n        var price_380lvl = \"" . mconfig("price_380lvl") . "\";\r\n        var enable_harmony = \"" . mconfig("enable_harmony") . "\";\r\n        var enable_anc_harm = \"" . mconfig("enable_anc_harm") . "\";\r\n        var enable_anc_exc = \"" . mconfig("enable_anc_exc") . "\";\r\n        var enable_same_socket = \"" . mconfig("enable_same_socket") . "\";\r\n        \r\n        var price_exc_opt_wings_4th_grade = \"" . mconfig("price_exc_opt_wings_4th_grade") . "\";\r\n        var price_pent_main_wings_4th_lvl = \"" . mconfig("price_pent_main_wings_4th_lvl") . "\";\r\n        var price_pent_add_wings_4th_lvl = \"" . mconfig("price_pent_add_wings_4th_lvl") . "\";\r\n    </script>";
        echo "<script src=\"" . __PATH_TEMPLATE_ASSETS__ . "js/webshop.js?v=8\"></script>";
        $breadcrumb = generateBreadcrumb();
        echo "\r\n    <h3>\r\n        " . lang("myaccount_txt_26", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
        if (mconfig("active")) {
            $Webshop = new Webshop();
            $Items = new Items();
            $Currency = new Currency();
            echo "\r\n    <div class=\"row webshop\">\r\n        <div class=\"col-xs-12 col-sm-3 col-md-2\">\r\n            <ul class=\"nav nav-pills nav-stacked\">\r\n                <li role=\"presentation\"><a href=\"" . __BASE_URL__ . "usercp/webshop/\">" . lang("webshop_18", true) . "</a></li>\r\n                <li role=\"presentation\"><a href=\"" . __BASE_URL__ . "usercp/webshop/history/purchases/\">" . lang("webshop_19", true) . "</a></li>\r\n                <li role=\"presentation\"><a href=\"" . __BASE_URL__ . "usercp/items/\">" . lang("myaccount_txt_67", true) . "</a></li>\r\n                <li role=\"presentation\"><a href=\"" . __BASE_URL__ . "donation/\">" . lang("webshop_20", true) . "</a></li>\r\n                <li role=\"presentation\"><a href=\"" . __BASE_URL__ . "ticket/new/\">" . lang("webshop_21", true) . "</a></li>\r\n            </ul>\r\n        </div>";
            if (check_value($_GET["history"])) {
                $limit = 10;
                $page = $_GET["pg"];
                if ($page == NULL) {
                    $page = 1;
                }
                echo "<script type=\"text/javascript\" SRC=\"" . __PATH_TEMPLATE_ASSETS__ . "js/tooltip.js\"></script>";
                echo "\r\n        <div class=\"col-xs-12 col-sm-9 col-md-10\">\r\n            <div class=\"table-responsive rankings-table\">\r\n                <table class=\"table table-hover text-center\">\r\n                    <tbody>\r\n                        <tr>\r\n                            <th class=\"headerRow\">#</th>\r\n                            <th class=\"headerRow\">" . lang("webshop_83", true) . "</th>\r\n                            <th class=\"headerRow\">" . lang("webshop_84", true) . "</th>\r\n                            <th class=\"headerRow\">" . lang("webshop_85", true) . "</th>\r\n                            <th class=\"headerRow\">" . lang("webshop_86", true) . "</th>\r\n                        </tr>";
                $historyDataTotal = $Webshop->loadWebshopHistoryAll($_SESSION["username"]);
                $historyData = $Webshop->loadWebshopHistory($_SESSION["username"], $page, $limit);
                if (is_array($historyData)) {
                    $historyCounter = $page * $limit - $limit + 1;
                    foreach ($historyData as $thisPurchase) {
                        $itemInfo = $Items->ItemInfo($thisPurchase["item"], $_SESSION["username"], NULL, 1);
                        $wasGift = "";
                        if ($thisPurchase["type"] == "gift") {
                            $wasGift = lang("webshop_87", true);
                        }
                        $historyCurrencyName = "";
                        $historyCurrencyName = $Currency->getCurrencyData($thisPurchase["price_type"])["name"];
                        echo "\r\n                        <tr>\r\n                            <td>" . $historyCounter . "</td>\r\n                            <td align=\"left\" style=\"cursor: pointer;\" onmouseover=\"Tip(" . $Items->generateItemTooltip($itemInfo, 1, 1, 1, 1, 0, 0) . ")\" onmouseout=\"UnTip()\" <img src=\"" . $itemInfo["thumb"] . "\" class=\"m items-inventory-item-bg\">\r\n                                <span style=\"color:" . $itemInfo["color"] . ";background-color:" . $itemInfo["anco"] . "\">" . $itemInfo["name"] . "</span>\r\n                            </td>\r\n                            <td>" . number_format($thisPurchase["price"]) . " " . $historyCurrencyName . "</td>\r\n                            <td>" . date($config["time_date_format"], strtotime($thisPurchase["date"])) . "</td>\r\n                            <td>" . $wasGift . "</td>\r\n                        </tr>";
                        $historyCounter++;
                    }
                } else {
                    echo "<tr><td colspan=\"5\">" . lang("webshop_88", true) . "</td></tr>";
                }
                echo "\r\n                    </tbody>\r\n                </table>\r\n            </div>\r\n            <div class=\"row\">\r\n            <nav aria-label=\"pagination\" class=\"col-xs-12 text-center\">\r\n                <ul class=\"pagination\">";
                $total_pages = ceil($historyDataTotal / $limit);
                $pageUrl = __BASE_URL__ . "usercp/webshop/history/purchases/pg/%pageHolder%";
                if ($search != NULL && $search != "") {
                    $pageUrl .= "&search=" . $pageUrl;
                }
                generatePagination($total_pages, $page, $pageUrl);
                echo "\r\n                </ul>\r\n            </nav>\r\n        </div>\r\n        </div>";
            } else {
                if (check_value($_GET["class"])) {
                    $classReq = [];
                    if (count($custom["class_filter"][$_GET["class"]]) == 3) {
                        $classReq = [1 => $custom["class_filter"][$_GET["class"]][0], 3 => $custom["class_filter"][$_GET["class"]][1], 4 => $custom["class_filter"][$_GET["class"]][2]];
                    } else {
                        $classReq = [1 => $custom["class_filter"][$_GET["class"]][0], 2 => $custom["class_filter"][$_GET["class"]][1], 3 => $custom["class_filter"][$_GET["class"]][2], 4 => $custom["class_filter"][$_GET["class"]][3]];
                    }
                    echo "\r\n        <div class=\"col-xs-12 col-sm-9 col-md-10\">";
                    if (0 < mconfig("global_discount")) {
                        echo "\r\n            <div class=\"row\">" . message("info", sprintf(lang("webshop_93", true), mconfig("global_discount"))) . "</div>";
                    }
                    $showPlatinum = false;
                    if (mconfig("enable_platinum")) {
                        $showPlatinum = true;
                    }
                    $showGold = false;
                    if (mconfig("enable_gold")) {
                        $showGold = true;
                    }
                    $showSilver = false;
                    if (mconfig("enable_silver")) {
                        $showSilver = true;
                    }
                    $showWcoin = false;
                    if (mconfig("enable_wcoin")) {
                        $showWcoin = true;
                    }
                    $showGP = false;
                    if (mconfig("enable_gp")) {
                        $showGP = true;
                    }
                    if (check_value($_GET["customise"])) {
                        if (!is_numeric($_GET["customise"])) {
                            $_GET["customise"] = 0;
                        }
                        if (check_value($_POST["submit"])) {
                            if ($_SESSION["token"] == $_POST["token"]) {
                                $purchaseResult = $Webshop->purchaseItem($_POST);
                            } else {
                                message("notice", lang("global_module_13", true));
                            }
                        }
                        if (check_value($_POST["submit_package"])) {
                            if ($_SESSION["token"] == $_POST["token"]) {
                                $purchaseResult = $Webshop->purchasePackage($_POST);
                            } else {
                                message("notice", lang("global_module_13", true));
                            }
                        }
                        if (check_value($_POST["submit_mystery"])) {
                            if ($_SESSION["token"] == $_POST["token"]) {
                                $purchaseResult = $Webshop->purchaseMystery($_POST);
                            } else {
                                message("notice", lang("global_module_13", true));
                            }
                        }
                        $token = time();
                        $_SESSION["token"] = $token;
                        $currencyOpts = "";
                        if (mconfig("enable_platinum")) {
                            if (mconfig("default_currency") == "1") {
                                $isSelected = " selected=\"selected\"";
                            } else {
                                $isSelected = "";
                            }
                            $currencyOpts .= "<option value=\"1\"" . $isSelected . ">" . lang("currency_platinum", true) . "</option>";
                        }
                        if (mconfig("enable_gold")) {
                            if (mconfig("default_currency") == "2") {
                                $isSelected = " selected=\"selected\"";
                            } else {
                                $isSelected = "";
                            }
                            $currencyOpts .= "<option value=\"2\"" . $isSelected . ">" . lang("currency_gold", true) . "</option>";
                        }
                        if (mconfig("enable_silver")) {
                            if (mconfig("default_currency") == "3") {
                                $isSelected = " selected=\"selected\"";
                            } else {
                                $isSelected = "";
                            }
                            $currencyOpts .= "<option value=\"3\"" . $isSelected . ">" . lang("currency_silver", true) . "</option>";
                        }
                        if (mconfig("enable_wcoin")) {
                            if (mconfig("default_currency") == "11") {
                                $isSelected = " selected=\"selected\"";
                            } else {
                                $isSelected = "";
                            }
                            $currencyOpts .= "<option value=\"11\"" . $isSelected . ">" . lang("currency_wcoinc", true) . "</option>";
                        }
                        if (mconfig("enable_gp")) {
                            if (mconfig("default_currency") == "13") {
                                $isSelected = " selected=\"selected\"";
                            } else {
                                $isSelected = "";
                            }
                            $currencyOpts .= "<option value=\"13\"" . $isSelected . ">" . lang("currency_gp", true) . "</option>";
                        }
                        if (mconfig("default_currency") == "1") {
                            $currCurrency = "platinum";
                        } else {
                            if (mconfig("default_currency") == "2") {
                                $currCurrency = "gold";
                            } else {
                                if (mconfig("default_currency") == "3") {
                                    $currCurrency = "silver";
                                } else {
                                    if (mconfig("default_currency") == "11") {
                                        $currCurrency = "wcoin";
                                    } else {
                                        if (mconfig("default_currency") == "13") {
                                            $currCurrency = "gp";
                                        }
                                    }
                                }
                            }
                        }
                        $currRatio = mconfig("ratio_" . $currCurrency);
                        if (check_value($_GET["package"])) {
                            echo "<script type=\"text/javascript\" SRC=\"" . __PATH_TEMPLATE__ . "js/tooltip.js\"></script>";
                            $currPackage = $Webshop->getPackageData($_GET["customise"]);
                            if (is_array($currPackage)) {
                                message("notice", lang("webshop_78", true));
                                echo "\r\n            <script type=\"text/javascript\">\r\n                var item_price = \"" . $currPackage["price"] . "\";\r\n                var global_discount = \"" . mconfig("global_discount") . "\";\r\n            </script>";
                                if (0 < $currPackage["on_sale"]) {
                                    $currPackage["price"] = $currPackage["price"] - floor($currPackage["price"] * $currPackage["on_sale"] / 100);
                                }
                                $itemPrice = floor($currRatio * $currPackage["price"]);
                                $totalPrice = $itemPrice;
                                if (0 < mconfig("global_discount")) {
                                    $totalPrice = $totalPrice - floor($itemPrice * mconfig("global_discount") / 100);
                                    $totalPrice = $totalPrice . "&nbsp;<sup class=\"webshop-item-on-sale\">-" . mconfig("global_discount") . "%</sup>";
                                }
                                echo "\r\n            <div class=\"row\">\r\n                <div class=\"col-xs-12 webshop-right webshop-options\">\r\n                    <div class=\"col-xs-12 col-md-4 text-center item-detail\">\r\n                        <div class=\"item-detail-title\">" . $currPackage["name"] . "</div>\r\n                        <div>\r\n                            <img src=\"" . __PATH_TEMPLATE_ASSETS__ . "items/" . $currPackage["image"] . "\" />\r\n                        </div>";
                                if (!empty($currPackage["description"])) {
                                    echo "<hr>\r\n                        <p class=\"webshop-desc-p\">" . $currPackage["description"] . "</p>";
                                }
                                if (mconfig("show_store_count") || mconfig("show_total_bought")) {
                                    echo "<hr>";
                                }
                                if (mconfig("show_store_count")) {
                                    $storeCount = $currPackage["store_count"];
                                    if ($storeCount == "-1") {
                                        $storeCount = lang("webshop_75", true);
                                    }
                                    echo "<div class=\"item-detail-store-count\">" . sprintf(lang("webshop_73", true), $storeCount) . "</div>";
                                }
                                if (mconfig("show_total_bought")) {
                                    echo "<div class=\"item-detail-total-bought\">" . sprintf(lang("webshop_74", true), $currPackage["total_bought"]) . "</div>";
                                }
                                echo "\r\n                        <hr>\r\n                        <div class=\"webshop-price-box\">\r\n                            <p class=\"webshop-price-p\">" . lang("webshop_txt_71", true) . " <span class=\"webshop-item-price\">" . $itemPrice . "</span></p>\r\n                            <p class=\"webshop-price-p\">" . lang("webshop_txt_72", true) . " <span class=\"webshop-options-price\">0</span></p>\r\n                            <p class=\"webshop-price-p\">" . lang("webshop_txt_73", true) . " <span class=\"webshop-total-price\">" . $totalPrice . "</span></p>\r\n                            \r\n                            <p class=\"webshop-price-p\">\r\n                                " . lang("webshop_60", true) . " \r\n                                <span class=\"webshop-item-price-currency\">\r\n                                    <select name=\"payment-currency-tmp\" class=\"form-control input-sm\" onchange=\"changeCurrency(this.value);\">\r\n                                        " . $currencyOpts . "\r\n                                    </select>\r\n                                </span>\r\n                            </p>\r\n                        </div>\r\n                    </div>\r\n                    <div class=\"col-xs-12 col-md-8\">";
                                $packageItems = $Webshop->getPackageItems($_GET["customise"]);
                                if (is_array($packageItems)) {
                                    foreach ($packageItems as $thisItem) {
                                        $itemInfo = $Items->ItemInfo($thisItem["item_hex"]);
                                        echo "\r\n                            <div class=\"col-xs-12 col-md-6 text-center\">\r\n                                <div class=\"webshop-item-x\" onmouseover=\"Tip(" . $Items->generateItemTooltip($itemInfo, 1, 1, 1, 1, 0, 0) . ")\" onmouseout=\"UnTip()\">\r\n                                    <div class=\"webshop-item-title\">\r\n                                        <span style=\"color:" . $itemInfo["color"] . ";background-color:" . $itemInfo["anco"] . "; padding: 2px 2px 2px 2px;\">" . $Items->generateItemName($itemInfo["name"], $itemInfo["level"]) . "</span>\r\n                                    </div>\r\n                                    <div class=\"webshop-item-img\">\r\n                                        <span class=\"webshop-item-img-helper\"></span>\r\n                                        <img src=\"" . $itemInfo["thumb"] . "\" alt=\"" . $itemInfo["name"] . "\" />\r\n                                    </div>\r\n                                </div>\r\n                            </div>";
                                    }
                                }
                                echo "\r\n                        <form class=\"form-horizontal webshop-options-form\" method=\"post\">\r\n                            <div class=\"form-group\">\r\n                                <input type=\"hidden\" id=\"payment-currency\" name=\"payment-currency\" value=\"" . mconfig("default_currency") . "\" />\r\n                                <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                                <input type=\"submit\" class=\"btn btn-warning full-width-btn webshop-purchase-item-btn\" name=\"submit_package\" value=\"" . lang("webshop_96", true) . "\" />\r\n                            </div>\r\n                        </form>\r\n                    </div>\r\n                </div>\r\n            </div>";
                            }
                        } else {
                            if (check_value($_GET["mystery"])) {
                                echo "<script type=\"text/javascript\" SRC=\"" . __PATH_TEMPLATE__ . "js/tooltip.js\"></script>";
                                $currMystery = $Webshop->getMysteryData($_GET["customise"]);
                                if (is_array($currMystery)) {
                                    message("notice", lang("webshop_78", true));
                                    echo "\r\n            <script type=\"text/javascript\">\r\n                var item_price = \"" . $currMystery["price"] . "\";\r\n                var global_discount = \"" . mconfig("global_discount") . "\";\r\n            </script>";
                                    if (0 < $currMystery["on_sale"]) {
                                        $currMystery["price"] = $currMystery["price"] - floor($currMystery["price"] * $currMystery["on_sale"] / 100);
                                    }
                                    $itemPrice = floor($currRatio * $currMystery["price"]);
                                    $totalPrice = $itemPrice;
                                    if (0 < mconfig("global_discount")) {
                                        $totalPrice = $totalPrice - floor($itemPrice * mconfig("global_discount") / 100);
                                        $totalPrice = $totalPrice . "&nbsp;<sup class=\"webshop-item-on-sale\">-" . mconfig("global_discount") . "%</sup>";
                                    }
                                    echo "\r\n            <div class=\"row\">\r\n                <div class=\"col-xs-12 webshop-right webshop-options\">\r\n                    <div class=\"col-xs-12 col-md-4 text-center item-detail\">\r\n                        <div class=\"item-detail-title\">" . $currMystery["name"] . "</div>\r\n                        <div>\r\n                            <img src=\"" . __PATH_TEMPLATE_ASSETS__ . "items/" . $currMystery["image"] . "\" />\r\n                        </div>";
                                    if (!empty($currMystery["description"])) {
                                        echo "<hr>\r\n                        <p class=\"webshop-desc-p\">" . $currMystery["description"] . "</p>";
                                    }
                                    if (mconfig("show_store_count") || mconfig("show_total_bought")) {
                                        echo "<hr>";
                                    }
                                    if (mconfig("show_store_count")) {
                                        $storeCount = $currMystery["store_count"];
                                        if ($storeCount == "-1") {
                                            $storeCount = lang("webshop_75", true);
                                        }
                                        echo "<div class=\"item-detail-store-count\">" . sprintf(lang("webshop_73", true), $storeCount) . "</div>";
                                    }
                                    if (mconfig("show_total_bought")) {
                                        echo "<div class=\"item-detail-total-bought\">" . sprintf(lang("webshop_74", true), $currMystery["total_bought"]) . "</div>";
                                    }
                                    echo "\r\n                        <hr>\r\n                        <div class=\"webshop-price-box\">\r\n                            <p class=\"webshop-price-p\">" . lang("webshop_txt_71", true) . " <span class=\"webshop-item-price\">" . $itemPrice . "</span></p>\r\n                            <p class=\"webshop-price-p\">" . lang("webshop_txt_72", true) . " <span class=\"webshop-options-price\">0</span></p>\r\n                            <p class=\"webshop-price-p\">" . lang("webshop_txt_73", true) . " <span class=\"webshop-total-price\">" . $totalPrice . "</span></p>\r\n                            \r\n                            <p class=\"webshop-price-p\">\r\n                                " . lang("webshop_60", true) . " \r\n                                <span class=\"webshop-item-price-currency\">\r\n                                    <select name=\"payment-currency-tmp\" class=\"form-control input-sm\" onchange=\"changeCurrency(this.value);\">\r\n                                        " . $currencyOpts . "\r\n                                    </select>\r\n                                </span>\r\n                            </p>\r\n                        </div>\r\n                    </div>\r\n                    <div class=\"col-xs-12 col-md-8\">";
                                    $mysteryItems = $Webshop->getMysteryItems($_GET["customise"]);
                                    if (is_array($mysteryItems)) {
                                        foreach ($mysteryItems as $thisItem) {
                                            $itemInfo = $Items->ItemInfo($thisItem["item_hex"]);
                                            echo "\r\n                            <div class=\"col-xs-12 col-md-6 text-center\">\r\n                                <div class=\"webshop-item-x\" onmouseover=\"Tip(" . $Items->generateItemTooltip($itemInfo, 1, 1, 1, 1, 0, 0) . ")\" onmouseout=\"UnTip()\">\r\n                                    <div class=\"webshop-item-title\">\r\n                                        <span style=\"color:" . $itemInfo["color"] . ";background-color:" . $itemInfo["anco"] . "; padding: 2px 2px 2px 2px;\">" . $Items->generateItemName($itemInfo["name"], $itemInfo["level"]) . "</span>\r\n                                    </div>\r\n                                    <div class=\"webshop-item-img\">\r\n                                        <span class=\"webshop-item-img-helper\"></span>\r\n                                        <img src=\"" . $itemInfo["thumb"] . "\" alt=\"" . $itemInfo["name"] . "\" />\r\n                                    </div>\r\n                                </div>\r\n                            </div>";
                                        }
                                    }
                                    echo "\r\n                        <form class=\"form-horizontal webshop-options-form\" method=\"post\">\r\n                            <div class=\"form-group\">\r\n                                <input type=\"hidden\" id=\"payment-currency\" name=\"payment-currency\" value=\"" . mconfig("default_currency") . "\" />\r\n                                <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                                <input type=\"submit\" class=\"btn btn-warning full-width-btn webshop-purchase-item-btn\" name=\"submit_mystery\" value=\"" . lang("webshop_97", true) . "\" />\r\n                            </div>\r\n                        </form>\r\n                    </div>\r\n                </div>\r\n            </div>";
                                }
                            } else {
                                $currItem = $Webshop->loadWebshopItem($_GET["customise"]);
                                $itemData = $Items->loadItemFromItemList($currItem["item_cat"], $currItem["item_id"]);
                                $itemDetail = $Items->generateItemDetails($itemData);
                                $excData = $Items->loadExcOptForItem($currItem["item_cat"], $currItem["item_id"], $itemData["KindA"], $itemData["KindB"]);
                                message("notice", lang("webshop_78", true));
                                echo "\r\n                <script type=\"text/javascript\">\r\n                    var item_price = \"" . $currItem["price"] . "\";\r\n                    var global_discount = \"" . mconfig("global_discount") . "\";\r\n                </script>";
                                if ($currItem["exetype"] == "1" || $currItem["exetype"] == "2") {
                                    echo "\r\n                    <script type=\"text/javascript\">\r\n                        var exc1_price = \"" . mconfig("price_exc_opt_item_" . $excData[0]["ID"]) . "\";\r\n                        var exc2_price = \"" . mconfig("price_exc_opt_item_" . $excData[1]["ID"]) . "\";\r\n                        var exc3_price = \"" . mconfig("price_exc_opt_item_" . $excData[2]["ID"]) . "\";\r\n                        var exc4_price = \"" . mconfig("price_exc_opt_item_" . $excData[3]["ID"]) . "\";\r\n                        var exc5_price = \"" . mconfig("price_exc_opt_item_" . $excData[4]["ID"]) . "\";\r\n                        var exc6_price = \"" . mconfig("price_exc_opt_item_" . $excData[5]["ID"]) . "\";\r\n                    </script>";
                                } else {
                                    echo "\r\n                    <script type=\"text/javascript\">\r\n                        var exc1_price = \"" . mconfig("price_exc_opt_wings_" . $excData[0]["ID"]) . "\";\r\n                        var exc2_price = \"" . mconfig("price_exc_opt_wings_" . $excData[1]["ID"]) . "\";\r\n                        var exc3_price = \"" . mconfig("price_exc_opt_wings_" . $excData[2]["ID"]) . "\";\r\n                        var exc4_price = \"" . mconfig("price_exc_opt_wings_" . $excData[3]["ID"]) . "\";\r\n                        var exc5_price = \"" . mconfig("price_exc_opt_wings_" . $excData[4]["ID"]) . "\";\r\n                        var exc6_price = \"" . mconfig("price_exc_opt_wings_" . $excData[5]["ID"]) . "\";\r\n                    </script>";
                                }
                                $itemPrice = floor($currRatio * $currItem["price"]);
                                $totalPrice = $itemPrice;
                                if (0 < mconfig("global_discount")) {
                                    $totalPrice = $totalPrice - floor($itemPrice * mconfig("global_discount") / 100);
                                    $totalPrice = $totalPrice . "&nbsp;<sup class=\"webshop-item-on-sale\">-" . mconfig("global_discount") . "%</sup>";
                                }
                                echo "\r\n            <div class=\"row\">\r\n                <div class=\"col-xs-12 webshop-right webshop-options\">\r\n                    <div class=\"col-xs-12 col-md-4 text-center item-detail\">\r\n                        <div class=\"item-detail-title\">" . $currItem["name"] . "</div>\r\n                        <div>\r\n                            <img src=\"" . __PATH_TEMPLATE_ASSETS__ . "items/" . $currItem["item_cat"] . "-" . $currItem["item_id"] . ".gif\" />\r\n                        </div>\r\n                        <div class=\"item-detail-details\">" . $itemDetail["itemDetails"] . "</div>\r\n                        <div class=\"item-detail-class-req\">" . $itemDetail["classReq"] . "</div>";
                                if (!empty($currItem["description"])) {
                                    echo "<hr>\r\n                        <p class=\"webshop-desc-p\">" . $currItem["description"] . "</p>";
                                }
                                if (mconfig("show_store_count") || mconfig("show_total_bought")) {
                                    echo "<hr>";
                                }
                                if (mconfig("show_store_count")) {
                                    $storeCount = $currItem["store_count"];
                                    if ($storeCount == "-1") {
                                        $storeCount = lang("webshop_75", true);
                                    }
                                    echo "<div class=\"item-detail-store-count\">" . sprintf(lang("webshop_73", true), $storeCount) . "</div>";
                                }
                                if (mconfig("show_total_bought")) {
                                    echo "<div class=\"item-detail-total-bought\">" . sprintf(lang("webshop_74", true), $currItem["total_bought"]) . "</div>";
                                }
                                echo "\r\n                        <hr>\r\n                        <div class=\"webshop-price-box\">\r\n                            <p class=\"webshop-price-p\">" . lang("webshop_txt_71", true) . " <span class=\"webshop-item-price\">" . $itemPrice . "</span></p>\r\n                            <p class=\"webshop-price-p\">" . lang("webshop_txt_72", true) . " <span class=\"webshop-options-price\">0</span></p>\r\n                            <p class=\"webshop-price-p\">" . lang("webshop_txt_73", true) . " <span class=\"webshop-total-price\">" . $totalPrice . "</span></p>\r\n                            \r\n                            <p class=\"webshop-price-p\">\r\n                                " . lang("webshop_60", true) . " \r\n                                <span class=\"webshop-item-price-currency\">\r\n                                    <select name=\"payment-currency-tmp\" class=\"form-control input-sm\" onchange=\"changeCurrency(this.value);\">\r\n                                        " . $currencyOpts . "\r\n                                    </select>\r\n                                </span>\r\n                            </p>\r\n                        </div>\r\n                    </div>\r\n                    <div class=\"col-xs-12 col-md-8\">\r\n                        <form class=\"form-horizontal webshop-options-form\" method=\"post\">\r\n                            <div class=\"form-group\">";
                                if (0 < $currItem["max_item_lvl"]) {
                                    $lvlOpts = "";
                                    $maxlvl = mconfig("max_level");
                                    if ($maxlvl < $currItem["max_item_lvl"]) {
                                        $maxlvl = $currItem["max_item_lvl"];
                                    }
                                    $lvlCounter = 0;
                                    while ($lvlCounter <= $maxlvl) {
                                        $lvlOpts .= "<option value=\"" . $lvlCounter . "\">+" . $lvlCounter . "</option>";
                                        $lvlCounter++;
                                    }
                                    echo "\r\n                                <div class=\"input-group webshop-options-group\">\r\n                                    <div class=\"input-group-addon\">" . lang("webshop_txt_60", true) . "</div>\r\n                                    <select name=\"item-level\" class=\"form-control\" onchange=\"checkHarmony(this.value); recalcOptionsPrice(); recalcTotalPrice();\">\r\n                                        " . $lvlOpts . "\r\n                                    </select>\r\n                                </div>";
                                }
                                if (0 < $currItem["max_item_opt"]) {
                                    $lifeOpts = "";
                                    $maxlife = mconfig("max_life_opts");
                                    $optRate = 4;
                                    if ($currItem["item_cat"] == "6") {
                                        $optRate = 5;
                                    }
                                    if ($maxlife < $currItem["max_item_opt"]) {
                                        $maxlife = $currItem["max_item_opt"];
                                    }
                                    $lifeCounter = 0;
                                    while ($lifeCounter <= $maxlife) {
                                        $lifeOpts .= "<option value=\"" . $lifeCounter . "\">+" . $lifeCounter * $optRate . "</option>";
                                        $lifeCounter++;
                                    }
                                    echo "\r\n                                <div class=\"input-group webshop-options-group\">\r\n                                    <div class=\"input-group-addon\">" . lang("webshop_txt_61", true) . "</div>\r\n                                    <select name=\"item-life\" class=\"form-control\" onchange=\"recalcOptionsPrice(); recalcTotalPrice();\">\r\n                                        " . $lifeOpts . "\r\n                                    </select>\r\n                                </div>";
                                }
                                if ($currItem["luck"] == "1") {
                                    echo "\r\n                                <div class=\"input-group webshop-options-group\">\r\n                                    <div class=\"input-group-addon webshop-label-checkbox\">" . lang("webshop_txt_62", true) . "</div>\r\n                                    <input name=\"item-luck\" type=\"checkbox\" onchange=\"recalcOptionsPrice(); recalcTotalPrice();\" />\r\n                                </div>";
                                }
                                if ($currItem["skill"] == "1") {
                                    echo "\r\n                                <div class=\"input-group webshop-options-group\">\r\n                                    <div class=\"input-group-addon webshop-label-checkbox\">" . lang("webshop_txt_63", true) . "</div>\r\n                                    <input name=\"item-skill\" type=\"checkbox\" onchange=\"recalcOptionsPrice(); recalcTotalPrice();\" />\r\n                                </div>";
                                }
                                if (mconfig("enable_anc")) {
                                    $ancData = $dB->query_fetch_single("SELECT TOP 1 * FROM [IMPERIAMUCMS_DATA_ANCIENT_ITEMS] WHERE [item_id] = ? AND [item_cat] = ? AND [active] = ?", [$currItem["item_id"], $currItem["item_cat"], 1]);
                                    if (is_array($ancData)) {
                                        $ancSets = $dB->query_fetch("SELECT * FROM [IMPERIAMUCMS_DATA_ANCIENT_SETS] WHERE [ancient_id] IN (?, ?, ?, ?) AND [available] <= ?", [$ancData["tier1"], $ancData["tier2"], $ancData["tier3"], $ancData["tier4"], config("server_files_season", true)]);
                                        $ancSetOpts = "";
                                        foreach ($ancSets as $thisAnc) {
                                            $ancTier = 0;
                                            if ($thisAnc["ancient_id"] == $ancData["tier1"]) {
                                                $ancTier = 1;
                                            }
                                            if ($thisAnc["ancient_id"] == $ancData["tier2"]) {
                                                $ancTier = 2;
                                            }
                                            if ($thisAnc["ancient_id"] == $ancData["tier3"]) {
                                                $ancTier = 3;
                                            }
                                            if ($thisAnc["ancient_id"] == $ancData["tier4"]) {
                                                $ancTier = 4;
                                            }
                                            $ancSetOpts .= "<option value=\"" . $thisAnc["ancient_id"] . ":" . $ancTier . "\">" . $thisAnc["ancient_name"] . "</option>";
                                        }
                                        echo "\r\n                    <script type=\"text/javascript\">\r\n                        var anc1_price = \"" . $ancData["tier1_price"] . "\";\r\n                        var anc2_price = \"" . $ancData["tier2_price"] . "\";\r\n                        var anc3_price = \"" . $ancData["tier3_price"] . "\";\r\n                        var anc4_price = \"" . $ancData["tier4_price"] . "\";\r\n                    </script>";
                                        echo "\r\n                                <hr><!-- ANCIENT OPTION -->\r\n                                <div class=\"input-group webshop-options-group\">\r\n                                    <div class=\"input-group-addon\">" . lang("webshop_txt_64", true) . "</div>\r\n                                    <select name=\"item-ancient\" class=\"form-control\" onchange=\"changeAncient(this.value); recalcOptionsPrice(); recalcTotalPrice();\">\r\n                                        <option value=\"\">" . lang("webshop_59", true) . "</option>\r\n                                        " . $ancSetOpts . "\r\n                                    </select>\r\n                                </div>\r\n                                <div class=\"input-group webshop-options-group\">\r\n                                    <div class=\"input-group-addon\">" . lang("webshop_txt_66", true) . "</div>\r\n                                    <select name=\"item-stamina\" class=\"form-control\" onchange=\"recalcOptionsPrice(); recalcTotalPrice();\" disabled=\"disabled\">\r\n                                        <option value=\"\">" . lang("webshop_59", true) . "</option>\r\n                                    </select>\r\n                                </div>";
                                    }
                                }
                                if (0 < $currItem["max_exc_opt"] && $currItem["exetype"] != "10" && $currItem["exetype"] != "11" && $currItem["exetype"] != "12" && ($currItem["use_sockets"] == "0" || $currItem["use_sockets"] == "1" && mconfig("enable_socket_exc"))) {
                                    $excIndex = 0;
                                    echo "<hr id=\"exc-line\"><!-- EXCELLENT OPTIONS -->";
                                    foreach ($excData as $thisExc) {
                                        $excName = "";
                                        if ($thisExc["FormulaID"] != "-1" && "0" <= $thisExc["FormulaID"]) {
                                            $formulaData = $Items->loadExcOptFormula($thisExc["FormulaID"]);
                                            $optValue = $Items->calculateValueByFormula($thisExc["FormulaID"], $formulaData["Data"], $itemData["DropLevel"]);
                                        } else {
                                            $optValue = $thisExc["Value"];
                                        }
                                        if ($itemDetail["KindA"] == "1" || $itemDetail["KindA"] == "2" || $itemDetail["KindA"] == "3" || $itemDetail["KindA"] == "4" || $itemDetail["KindA"] == "14" || $itemDetail["KindA"] == "15" || $itemDetail["KindA"] == "18" || $itemDetail["KindA"] == "100") {
                                            if ($thisExc["ID"] != "1" && $thisExc["ID"] != "2" && $thisExc["ID"] != "6" && $thisExc["ID"] != "7" && $thisExc["ID"] != "18") {
                                                $excName = sprintf(lang("exc_opt_item_" . $thisExc["ID"], true), $optValue);
                                            } else {
                                                if ($currItem["item_cat"] == "5") {
                                                    $excOptStringTmp = lang("item_detail_txt_13", true);
                                                } else {
                                                    $excOptStringTmp = lang("item_detail_txt_12", true);
                                                }
                                                if ($thisExc["ID"] == "1") {
                                                    $excName = sprintf(lang("exc_opt_item_" . $thisExc["ID"], true), $excOptStringTmp, $optValue);
                                                } else {
                                                    if ($thisExc["ID"] == "2") {
                                                        $excName = sprintf(lang("exc_opt_item_" . $thisExc["ID"], true), $excOptStringTmp, $optValue);
                                                    } else {
                                                        if ($thisExc["ID"] == "6") {
                                                            $excName = sprintf(lang("exc_opt_item_" . $thisExc["ID"], true), $excOptStringTmp, $optValue);
                                                        } else {
                                                            if ($thisExc["ID"] == "7") {
                                                                $excName = sprintf(lang("exc_opt_item_" . $thisExc["ID"], true), $excOptStringTmp, $optValue);
                                                            } else {
                                                                if ($thisExc["ID"] == "18") {
                                                                    $excName = sprintf(lang("exc_opt_item_" . $thisExc["ID"], true), lang("item_detail_txt_17", true), $optValue);
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        } else {
                                            if ($itemDetail["KindA"] == "6") {
                                                $excName = sprintf(lang("exc_opt_wings_" . $thisExc["ID"], true), $optValue);
                                            }
                                        }
                                        echo "\r\n                                <div class=\"input-group webshop-options-group\">\r\n                                    <div class=\"input-group-addon webshop-label-checkbox exc-opt\">" . $excName . "</div>\r\n                                    <input name=\"item-exc-" . ($excIndex + 1) . "\" type=\"checkbox\" onchange=\"recalcOptionsPrice(); recalcTotalPrice();\" />\r\n                                </div>";
                                        $excIndex++;
                                    }
                                }
                                if (mconfig("enable_380lvl") && $currItem["use_refinary"] == "1") {
                                    echo "\r\n                                <hr><!-- 380 LVL OPTION -->\r\n                                <div class=\"input-group webshop-options-group\">\r\n                                    <div class=\"input-group-addon webshop-label-checkbox\">" . lang("webshop_txt_67", true) . "</div>\r\n                                    <input name=\"item-380lvl\" type=\"checkbox\" onchange=\"recalcOptionsPrice(); recalcTotalPrice();\" />\r\n                                </div>";
                                }
                                if (mconfig("enable_harmony") && $currItem["use_harmony"] == "1") {
                                    $harmonyType = 0;
                                    if (0 <= $currItem["item_cat"] && $currItem["item_cat"] <= 4) {
                                        $harmonyType = 1;
                                    }
                                    if ($currItem["item_cat"] == 5) {
                                        $harmonyType = 2;
                                    }
                                    if (7 <= $currItem["item_cat"] && $currItem["item_cat"] <= 11) {
                                        $harmonyType = 3;
                                    }
                                    $harmonyData = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_WEBSHOP_HARMONY WHERE itemtype = ? AND status = ? ORDER BY hoption ASC, hvalue ASC", [$harmonyType, 1]);
                                    $harmonyOptions = "";
                                    $harmonyArray = [];
                                    if (is_array($harmonyData)) {
                                        foreach ($harmonyData as $thisHarmony) {
                                            $disableHarm = "";
                                            if (0 < $thisHarmony["hvalue"]) {
                                                $disableHarm = " disabled=\"disabled\"";
                                            }
                                            $harmonyOptions .= "<option value=\"" . $thisHarmony["id"] . ":" . $thisHarmony["hoption"] . ":" . $thisHarmony["price"] . ":" . $thisHarmony["hvalue"] . "\"" . $disableHarm . ">" . $thisHarmony["hname"] . "</option>";
                                        }
                                    }
                                    echo "\r\n                                <hr id=\"harmony-line\"><!-- HARMONY OPTION -->\r\n                                <div class=\"input-group webshop-options-group\">\r\n                                    <div class=\"input-group-addon\">" . lang("webshop_txt_68", true) . "</div>\r\n                                    <select name=\"item-harmony\" class=\"form-control\" onchange=\"recalcOptionsPrice(); recalcTotalPrice();\">\r\n                                        <option value=\"\">" . lang("webshop_59", true) . "</option>\r\n                                        " . $harmonyOptions . "\r\n                                    </select>\r\n                                </div>";
                                }
                                if (0 < mconfig("max_sockets") && $currItem["use_sockets"] == "1") {
                                    $dbSockets = $Webshop->getSockets($currItem["item_cat"]);
                                    $dbBonusSockets = $Webshop->getBonusSockets($currItem["item_cat"]);
                                    $socketOptions = "<option value=\"\">" . lang("webshop_59", true) . "</option>";
                                    $bonusSocketOptions = "<option value=\"\">" . lang("webshop_59", true) . "</option>";
                                    foreach ($dbSockets as $s) {
                                        $sockets[$s["socket_id"]]["id"] = $s["id"];
                                        $sockets[$s["socket_id"]]["price"] = $s["price"];
                                        $sockets[$s["socket_id"]]["type"] = $s["seed"];
                                        if ($s["socket_id"] == "254" && $s["socket_elem"] == "0") {
                                            $socketOptions .= "<option value=\"" . $s["socket_id"] . ":" . $s["socket_type"] . ":" . $s["seed"] . ":" . $s["price"] . "\">" . lang($s["socket_name_lang"], true) . "</option>";
                                        } else {
                                            $socketOptions .= "<option value=\"" . $s["socket_id"] . ":" . $s["socket_type"] . ":" . $s["seed"] . ":" . $s["price"] . "\">" . sprintf(lang($s["socket_name_lang"], true), $s["socket_lvl"], $s["socket_value"]) . "</option>";
                                        }
                                    }
                                    foreach ($dbBonusSockets as $s) {
                                        $bonusSockets[$s["socket_id"]]["id"] = $s["id"];
                                        $bonusSockets[$s["socket_id"]]["price"] = $s["price"];
                                        $bonusSockets[$s["socket_id"]]["type"] = $s["seed"];
                                        if ($s["socket_lvl"] == "1") {
                                            $socketBonusLvl = "socket_bonus_lvl1";
                                        } else {
                                            $socketBonusLvl = "socket_bonus_lvl2";
                                        }
                                        $bonusSocketOptions .= "<option value=\"" . $s["socket_id"] . ":" . $s["price"] . ":" . $s["seed"] . "\">" . sprintf(lang($s["socket_name_lang"], true), lang($socketBonusLvl, true), $s["socket_value"]) . "</option>";
                                    }
                                    echo "\r\n                                <hr><!-- SOCKET OPTIONS -->\r\n                                <div class=\"input-group webshop-options-group\">\r\n                                    <div class=\"input-group-addon\">" . lang("webshop_txt_69", true) . " #1:</div>\r\n                                    <select id=\"item-socket-1\" name=\"item-socket-1\" class=\"form-control\" onchange=\"changeSocket(this.id, this.value); recalcOptionsPrice(); recalcTotalPrice();\">\r\n                                        " . $socketOptions . "\r\n                                    </select>\r\n                                </div>";
                                    if (1 < mconfig("max_sockets")) {
                                        echo "\r\n                                <div class=\"input-group webshop-options-group\">\r\n                                    <div class=\"input-group-addon\">" . lang("webshop_txt_69", true) . " #2:</div>\r\n                                    <select id=\"item-socket-2\" name=\"item-socket-2\" class=\"form-control\" onchange=\"changeSocket(this.id, this.value); recalcOptionsPrice(); recalcTotalPrice();\">\r\n                                        " . $socketOptions . "\r\n                                    </select>\r\n                                </div>";
                                    }
                                    if (2 < mconfig("max_sockets")) {
                                        echo "\r\n                                <div class=\"input-group webshop-options-group\">\r\n                                    <div class=\"input-group-addon\">" . lang("webshop_txt_69", true) . " #3:</div>\r\n                                    <select id=\"item-socket-3\" name=\"item-socket-3\" class=\"form-control\" onchange=\"changeSocket(this.id, this.value); recalcOptionsPrice(); recalcTotalPrice();\">\r\n                                        " . $socketOptions . "\r\n                                    </select>\r\n                                </div>";
                                    }
                                    if (3 < mconfig("max_sockets")) {
                                        echo "\r\n                                <div class=\"input-group webshop-options-group\">\r\n                                    <div class=\"input-group-addon\">" . lang("webshop_txt_69", true) . " #4:</div>\r\n                                    <select id=\"item-socket-4\" name=\"item-socket-4\" class=\"form-control\" onchange=\"changeSocket(this.id, this.value); recalcOptionsPrice(); recalcTotalPrice();\">\r\n                                        " . $socketOptions . "\r\n                                    </select>\r\n                                </div>";
                                    }
                                    if (4 < mconfig("max_sockets")) {
                                        echo "\r\n                                <div class=\"input-group webshop-options-group\">\r\n                                    <div class=\"input-group-addon\">" . lang("webshop_txt_69", true) . " #5:</div>\r\n                                    <select id=\"item-socket-5\" name=\"item-socket-5\" class=\"form-control\" onchange=\"changeSocket(this.id, this.value); recalcOptionsPrice(); recalcTotalPrice();\">\r\n                                        " . $socketOptions . "\r\n                                    </select>\r\n                                </div>";
                                    }
                                    if (mconfig("enable_bonus_socket")) {
                                        $bonusSockets = $Webshop->getBonusSockets($currItem["item_cat"]);
                                        echo "\r\n                                <div class=\"input-group webshop-options-group\">\r\n                                    <div class=\"input-group-addon\">" . lang("webshop_txt_94", true) . ":</div>\r\n                                    <select name=\"item-socket-bonus\" class=\"form-control\" onchange=\"recalcOptionsPrice(); recalcTotalPrice();\">\r\n                                        " . $bonusSocketOptions . "\r\n                                    </select>\r\n                                </div>";
                                    }
                                }
                                if ($currItem["exetype"] == "10") {
                                    $gradeOptionsData = $Items->loadGradeOptForItem();
                                    $gradeOptions = "<option value=\"\">" . lang("webshop_59", true) . "</option>";
                                    foreach ($gradeOptionsData as $thisGrade) {
                                        $gradeCounter = 0;
                                        while ($gradeCounter <= 9) {
                                            if (0 < $thisGrade["Grade" . $gradeCounter . "Val"]) {
                                                $gradeName = sprintf(lang("exc_opt_wings_4th_" . $thisGrade["Index"], true), $thisGrade["Grade" . $gradeCounter . "Val"]);
                                                $gradeOptions .= "<option value=\"" . $thisGrade["Index"] . ":" . $gradeCounter . ":" . mconfig("price_exc_opt_wings_4th_" . $thisGrade["Index"]) . "\">" . $gradeName . "</option>";
                                            }
                                            $gradeCounter++;
                                        }
                                    }
                                    if (0 < mconfig("wings_4th_max_exc_opts")) {
                                        echo "\r\n                                <div class=\"input-group webshop-options-group\">\r\n                                    <div class=\"input-group-addon\">" . sprintf(lang("webshop_62", true), 1) . "</div>\r\n                                    <select id=\"item-exc-1\" name=\"item-exc-1\" class=\"form-control\" onchange=\"changeGrade(this.id, this.value); recalcOptionsPrice(); recalcTotalPrice();\">\r\n                                        " . $gradeOptions . "\r\n                                    </select>\r\n                                </div>";
                                    }
                                    if (1 < mconfig("wings_4th_max_exc_opts")) {
                                        echo "\r\n                                <div class=\"input-group webshop-options-group\">\r\n                                    <div class=\"input-group-addon\">" . sprintf(lang("webshop_62", true), 2) . "</div>\r\n                                    <select id=\"item-exc-2\" name=\"item-exc-2\" class=\"form-control\" onchange=\"changeGrade(this.id, this.value); recalcOptionsPrice(); recalcTotalPrice();\">\r\n                                        " . $gradeOptions . "\r\n                                    </select>\r\n                                </div>";
                                    }
                                    if (2 < mconfig("wings_4th_max_exc_opts")) {
                                        echo "\r\n                                <div class=\"input-group webshop-options-group\">\r\n                                    <div class=\"input-group-addon\">" . sprintf(lang("webshop_62", true), 3) . "</div>\r\n                                    <select id=\"item-exc-3\" name=\"item-exc-3\" class=\"form-control\" onchange=\"changeGrade(this.id, this.value); recalcOptionsPrice(); recalcTotalPrice();\">\r\n                                        " . $gradeOptions . "\r\n                                    </select>\r\n                                </div>";
                                    }
                                    if (3 < mconfig("wings_4th_max_exc_opts")) {
                                        echo "\r\n                                <div class=\"input-group webshop-options-group\">\r\n                                    <div class=\"input-group-addon\">" . sprintf(lang("webshop_62", true), 4) . "</div>\r\n                                    <select id=\"item-exc-4\" name=\"item-exc-4\" class=\"form-control\" onchange=\"changeGrade(this.id, this.value); recalcOptionsPrice(); recalcTotalPrice();\">\r\n                                        " . $gradeOptions . "\r\n                                    </select>\r\n                                </div>";
                                    }
                                    if (mconfig("wings_4th_main_opt") || mconfig("wings_4th_add_opt")) {
                                        $pentagramAttrData = $Items->loadPentagramOptForWings();
                                        $mainPentagramOptions = "<option value=\"\">" . lang("webshop_59", true) . "</option>";
                                        foreach ($pentagramAttrData["main"] as $thisOpt) {
                                            $mainPentCounter = 0;
                                            while ($mainPentCounter <= 15) {
                                                if (0 < $thisOpt["Value" . $mainPentCounter]) {
                                                    $mainPentName = sprintf(lang("pentagram_main_opt_4th_wings_0", true), $thisOpt["Value" . $mainPentCounter]);
                                                    $mainPentagramOptions .= "<option value=\"0:" . $mainPentCounter . ":" . mconfig("price_pent_main_wings_4th") . "\">" . $mainPentName . "</option>";
                                                }
                                                $mainPentCounter++;
                                            }
                                        }
                                        $additionalPentagramOptions = "<option value=\"\">" . lang("webshop_59", true) . "</option>";
                                        foreach ($pentagramAttrData["add"] as $thisOpt) {
                                            $addPentCounter = 0;
                                            while ($addPentCounter <= 15) {
                                                if (0 < $thisOpt["Value" . $addPentCounter]) {
                                                    $addPentName = sprintf(lang("pentagram_add_opt_4th_wings_" . $thisOpt["Index"], true), $thisOpt["Value" . $addPentCounter]);
                                                    $additionalPentagramOptions .= "<option value=\"" . $thisOpt["Index"] . ":" . $addPentCounter . ":" . mconfig("price_pent_add_wings_4th_" . $thisOpt["Index"]) . "\">" . $addPentName . "</option>";
                                                }
                                                $addPentCounter++;
                                            }
                                        }
                                        if (mconfig("wings_4th_main_opt")) {
                                            echo "\r\n                                <div class=\"input-group webshop-options-group\">\r\n                                    <div class=\"input-group-addon\">" . lang("webshop_63", true) . "</div>\r\n                                    <select id=\"item-pentagram-main\" name=\"item-pentagram-main\" class=\"form-control\" onchange=\"recalcOptionsPrice(); recalcTotalPrice();\">\r\n                                        " . $mainPentagramOptions . "\r\n                                    </select>\r\n                                </div>";
                                        }
                                        if (mconfig("wings_4th_add_opt")) {
                                            echo "\r\n                                <div class=\"input-group webshop-options-group\">\r\n                                    <div class=\"input-group-addon\">" . lang("webshop_64", true) . "</div>\r\n                                    <select id=\"item-pentagram-add\" name=\"item-pentagram-add\" class=\"form-control\" onchange=\"recalcOptionsPrice(); recalcTotalPrice();\">\r\n                                        " . $additionalPentagramOptions . "\r\n                                    </select>\r\n                                </div>";
                                        }
                                    }
                                }
                                if ($currItem["exetype"] == "11") {
                                    echo "\r\n                    <script type=\"text/javascript\">\r\n                        var exc1_price = \"" . mconfig("price_exc_opt_earring_l_0") . "\";\r\n                        var exc2_price = \"" . mconfig("price_exc_opt_earring_l_1") . "\";\r\n                        var exc3_price = \"" . mconfig("price_exc_opt_earring_l_2") . "\";\r\n                        var exc4_price = \"" . mconfig("price_exc_opt_earring_l_3") . "\";\r\n                        var exc5_price = \"" . mconfig("price_exc_opt_earring_l_4") . "\";\r\n                    </script>";
                                    if ($currItem["item_id"] == "450") {
                                        echo "\r\n                                <hr id=\"exc-line\"><!-- EXCELLENT OPTIONS -->\r\n                                <div class=\"input-group webshop-options-group\">\r\n                                    <div class=\"input-group-addon webshop-label-checkbox exc-opt\">" . lang("exc_opt_earring_left_5", true) . "</div>\r\n                                    <input name=\"item-exc-1\" type=\"checkbox\" onchange=\"recalcOptionsPrice(); recalcTotalPrice();\" />\r\n                                </div>\r\n                                <div class=\"input-group webshop-options-group\">\r\n                                    <div class=\"input-group-addon webshop-label-checkbox exc-opt\">" . lang("exc_opt_earring_left_6", true) . "</div>\r\n                                    <input name=\"item-exc-2\" type=\"checkbox\" onchange=\"recalcOptionsPrice(); recalcTotalPrice();\" />\r\n                                </div>\r\n                                <div class=\"input-group webshop-options-group\">\r\n                                    <div class=\"input-group-addon webshop-label-checkbox exc-opt\">" . lang("exc_opt_earring_left_7", true) . "</div>\r\n                                    <input name=\"item-exc-3\" type=\"checkbox\" onchange=\"recalcOptionsPrice(); recalcTotalPrice();\" />\r\n                                </div>\r\n                                <div class=\"input-group webshop-options-group\">\r\n                                    <div class=\"input-group-addon webshop-label-checkbox exc-opt\">" . lang("exc_opt_earring_left_8", true) . "</div>\r\n                                    <input name=\"item-exc-4\" type=\"checkbox\" onchange=\"recalcOptionsPrice(); recalcTotalPrice();\" />\r\n                                </div>\r\n                                <div class=\"input-group webshop-options-group\">\r\n                                    <div class=\"input-group-addon webshop-label-checkbox exc-opt\">" . lang("exc_opt_earring_left_9", true) . "</div>\r\n                                    <input name=\"item-exc-5\" type=\"checkbox\" onchange=\"recalcOptionsPrice(); recalcTotalPrice();\" />\r\n                                </div>";
                                    } else {
                                        echo "\r\n                                <hr id=\"exc-line\"><!-- EXCELLENT OPTIONS -->\r\n                                <div class=\"input-group webshop-options-group\">\r\n                                    <div class=\"input-group-addon webshop-label-checkbox exc-opt\">" . lang("exc_opt_earring_left_0", true) . "</div>\r\n                                    <input name=\"item-exc-1\" type=\"checkbox\" onchange=\"recalcOptionsPrice(); recalcTotalPrice();\" />\r\n                                </div>\r\n                                <div class=\"input-group webshop-options-group\">\r\n                                    <div class=\"input-group-addon webshop-label-checkbox exc-opt\">" . lang("exc_opt_earring_left_1", true) . "</div>\r\n                                    <input name=\"item-exc-2\" type=\"checkbox\" onchange=\"recalcOptionsPrice(); recalcTotalPrice();\" />\r\n                                </div>\r\n                                <div class=\"input-group webshop-options-group\">\r\n                                    <div class=\"input-group-addon webshop-label-checkbox exc-opt\">" . lang("exc_opt_earring_left_2", true) . "</div>\r\n                                    <input name=\"item-exc-3\" type=\"checkbox\" onchange=\"recalcOptionsPrice(); recalcTotalPrice();\" />\r\n                                </div>\r\n                                <div class=\"input-group webshop-options-group\">\r\n                                    <div class=\"input-group-addon webshop-label-checkbox exc-opt\">" . lang("exc_opt_earring_left_3", true) . "</div>\r\n                                    <input name=\"item-exc-4\" type=\"checkbox\" onchange=\"recalcOptionsPrice(); recalcTotalPrice();\" />\r\n                                </div>\r\n                                <div class=\"input-group webshop-options-group\">\r\n                                    <div class=\"input-group-addon webshop-label-checkbox exc-opt\">" . lang("exc_opt_earring_left_4", true) . "</div>\r\n                                    <input name=\"item-exc-5\" type=\"checkbox\" onchange=\"recalcOptionsPrice(); recalcTotalPrice();\" />\r\n                                </div>";
                                    }
                                }
                                if ($currItem["exetype"] == "12") {
                                    echo "\r\n                    <script type=\"text/javascript\">\r\n                        var exc1_price = \"" . mconfig("price_exc_opt_earring_r_0") . "\";\r\n                        var exc2_price = \"" . mconfig("price_exc_opt_earring_r_1") . "\";\r\n                        var exc3_price = \"" . mconfig("price_exc_opt_earring_r_2") . "\";\r\n                        var exc4_price = \"" . mconfig("price_exc_opt_earring_r_3") . "\";\r\n                        var exc5_price = \"" . mconfig("price_exc_opt_earring_r_4") . "\";\r\n                    </script>";
                                    if ($currItem["item_id"] == "458") {
                                        echo "\r\n                                <hr id=\"exc-line\"><!-- EXCELLENT OPTIONS -->\r\n                                <div class=\"input-group webshop-options-group\">\r\n                                    <div class=\"input-group-addon webshop-label-checkbox exc-opt\">" . lang("exc_opt_earring_right_5", true) . "</div>\r\n                                    <input name=\"item-exc-1\" type=\"checkbox\" onchange=\"recalcOptionsPrice(); recalcTotalPrice();\" />\r\n                                </div>\r\n                                <div class=\"input-group webshop-options-group\">\r\n                                    <div class=\"input-group-addon webshop-label-checkbox exc-opt\">" . lang("exc_opt_earring_right_6", true) . "</div>\r\n                                    <input name=\"item-exc-2\" type=\"checkbox\" onchange=\"recalcOptionsPrice(); recalcTotalPrice();\" />\r\n                                </div>\r\n                                <div class=\"input-group webshop-options-group\">\r\n                                    <div class=\"input-group-addon webshop-label-checkbox exc-opt\">" . lang("exc_opt_earring_right_7", true) . "</div>\r\n                                    <input name=\"item-exc-3\" type=\"checkbox\" onchange=\"recalcOptionsPrice(); recalcTotalPrice();\" />\r\n                                </div>\r\n                                <div class=\"input-group webshop-options-group\">\r\n                                    <div class=\"input-group-addon webshop-label-checkbox exc-opt\">" . lang("exc_opt_earring_right_8", true) . "</div>\r\n                                    <input name=\"item-exc-4\" type=\"checkbox\" onchange=\"recalcOptionsPrice(); recalcTotalPrice();\" />\r\n                                </div>\r\n                                <div class=\"input-group webshop-options-group\">\r\n                                    <div class=\"input-group-addon webshop-label-checkbox exc-opt\">" . lang("exc_opt_earring_right_9", true) . "</div>\r\n                                    <input name=\"item-exc-5\" type=\"checkbox\" onchange=\"recalcOptionsPrice(); recalcTotalPrice();\" />\r\n                                </div>";
                                    } else {
                                        echo "\r\n                                <hr id=\"exc-line\"><!-- EXCELLENT OPTIONS -->\r\n                                <div class=\"input-group webshop-options-group\">\r\n                                    <div class=\"input-group-addon webshop-label-checkbox exc-opt\">" . lang("exc_opt_earring_right_0", true) . "</div>\r\n                                    <input name=\"item-exc-1\" type=\"checkbox\" onchange=\"recalcOptionsPrice(); recalcTotalPrice();\" />\r\n                                </div>\r\n                                <div class=\"input-group webshop-options-group\">\r\n                                    <div class=\"input-group-addon webshop-label-checkbox exc-opt\">" . lang("exc_opt_earring_right_1", true) . "</div>\r\n                                    <input name=\"item-exc-2\" type=\"checkbox\" onchange=\"recalcOptionsPrice(); recalcTotalPrice();\" />\r\n                                </div>\r\n                                <div class=\"input-group webshop-options-group\">\r\n                                    <div class=\"input-group-addon webshop-label-checkbox exc-opt\">" . lang("exc_opt_earring_right_2", true) . "</div>\r\n                                    <input name=\"item-exc-3\" type=\"checkbox\" onchange=\"recalcOptionsPrice(); recalcTotalPrice();\" />\r\n                                </div>\r\n                                <div class=\"input-group webshop-options-group\">\r\n                                    <div class=\"input-group-addon webshop-label-checkbox exc-opt\">" . lang("exc_opt_earring_right_3", true) . "</div>\r\n                                    <input name=\"item-exc-4\" type=\"checkbox\" onchange=\"recalcOptionsPrice(); recalcTotalPrice();\" />\r\n                                </div>\r\n                                <div class=\"input-group webshop-options-group\">\r\n                                    <div class=\"input-group-addon webshop-label-checkbox exc-opt\">" . lang("exc_opt_earring_right_4", true) . "</div>\r\n                                    <input name=\"item-exc-5\" type=\"checkbox\" onchange=\"recalcOptionsPrice(); recalcTotalPrice();\" />\r\n                                </div>";
                                    }
                                }
                                if ($itemDetail["KindA"] == "8" && $itemDetail["KindB"] == "43" && $currItem["item_id"] != "215") {
                                    $elementTypes = $Webshop->elementalTypes();
                                    $elementOptions = $Webshop->errtelOptions();
                                    $elementTypesOpts = "";
                                    foreach ($elementTypes as $key => $thisType) {
                                        $thisTypePrice = 0;
                                        if ($key == 0) {
                                            $thisTypePrice = mconfig("element_none_price");
                                        } else {
                                            $thisTypePrice = mconfig("element_" . strtolower($thisType) . "_price");
                                        }
                                        $elementTypesOpts .= "<option value=\"" . $key . ":" . $thisTypePrice . "\">" . $thisType . "</option>";
                                    }
                                    echo "\r\n                                <div class=\"input-group webshop-options-group\">\r\n                                    <div class=\"input-group-addon\">" . lang("webshop_65", true) . "</div>\r\n                                    <select id=\"element\" name=\"element\" class=\"form-control\" onchange=\"recalcOptionsPrice(); recalcTotalPrice();\">\r\n                                        " . $elementTypesOpts . "\r\n                                    </select>\r\n                                </div>";
                                    $errtelOptions = [];
                                    $previousErrtelRank = NULL;
                                    $optionCounter = 1;
                                    foreach ($elementOptions as $thisOption) {
                                        $slotType = NULL;
                                        if ($thisOption["errtel"] == "1") {
                                            $slotType = "anger";
                                        } else {
                                            if ($thisOption["errtel"] == "2") {
                                                $slotType = "blessing";
                                            } else {
                                                if ($thisOption["errtel"] == "3") {
                                                    $slotType = "integrity";
                                                } else {
                                                    if ($thisOption["errtel"] == "4") {
                                                        $slotType = "divinity";
                                                    } else {
                                                        if ($thisOption["errtel"] == "5") {
                                                            $slotType = "gale";
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                        if ($previousErrtelRank != $thisOption["errtel_rank"]) {
                                            $easytoyou_decoder_beta_not_finish .= "<option value=\"0\">" . lang("pentagram_none", true) . "</option>";
                                            $optionCounter = 1;
                                        }
                                        $i = 0;
                                        while ($i <= 10) {
                                            if ($i <= mconfig("element_" . $slotType . "_" . $thisOption["errtel_rank"] . "_maxlvl")) {
                                                $easytoyou_decoder_beta_not_finish .= "<option value=\"" . $optionCounter . ":" . mconfig("element_" . $slotType . "_" . $thisOption["errtel_rank"] . "_price") . ":" . $i . ":" . mconfig("element_" . $slotType . "_" . $thisOption["errtel_rank"] . "_price_level") . "\">" . sprintf(lang($thisOption["errtel_option_lang"], true), $thisOption["errtel_level_" . $i]) . "</option>";
                                            }
                                            $i++;
                                        }
                                        $previousErrtelRank = $thisOption["errtel_rank"];
                                        $optionCounter++;
                                    }
                                    if (1 <= mconfig("element_errtel_slots")) {
                                        echo "<hr>";
                                        $angerIndex = 1;
                                        while ($angerIndex <= 5) {
                                            if ($angerIndex <= mconfig("element_anger_slots")) {
                                                echo "\r\n                                    <div class=\"input-group webshop-options-group\">\r\n                                        <div class=\"input-group-addon\">" . sprintf(lang("webshop_66", true), $angerIndex) . "</div>\r\n                                        <select id=\"anger" . $angerIndex . "\" name=\"anger" . $angerIndex . "\" class=\"form-control\" onchange=\"recalcOptionsPrice(); recalcTotalPrice();\">\r\n                                            " . $errtelOptions["anger"][$angerIndex] . "\r\n                                        </select>\r\n                                    </div>";
                                            }
                                            $angerIndex++;
                                        }
                                    }
                                    if (2 <= mconfig("element_errtel_slots")) {
                                        echo "<hr>";
                                        $blessingIndex = 1;
                                        while ($blessingIndex <= 5) {
                                            if ($blessingIndex <= mconfig("element_blessing_slots")) {
                                                echo "\r\n                                    <div class=\"input-group webshop-options-group\">\r\n                                        <div class=\"input-group-addon\">" . sprintf(lang("webshop_67", true), $blessingIndex) . "</div>\r\n                                        <select id=\"blessing" . $blessingIndex . "\" name=\"blessing" . $blessingIndex . "\" class=\"form-control\" onchange=\"recalcOptionsPrice(); recalcTotalPrice();\">\r\n                                            " . $errtelOptions["blessing"][$blessingIndex] . "\r\n                                        </select>\r\n                                    </div>";
                                            }
                                            $blessingIndex++;
                                        }
                                    }
                                    if (3 <= mconfig("element_errtel_slots")) {
                                        echo "<hr>";
                                        $integrityIndex = 1;
                                        while ($integrityIndex <= 5) {
                                            if ($integrityIndex <= mconfig("element_integrity_slots")) {
                                                echo "\r\n                                    <div class=\"input-group webshop-options-group\">\r\n                                        <div class=\"input-group-addon\">" . sprintf(lang("webshop_68", true), $integrityIndex) . "</div>\r\n                                        <select id=\"integrity" . $integrityIndex . "\" name=\"integrity" . $integrityIndex . "\" class=\"form-control\" onchange=\"recalcOptionsPrice(); recalcTotalPrice();\">\r\n                                            " . $errtelOptions["integrity"][$integrityIndex] . "\r\n                                        </select>\r\n                                    </div>";
                                            }
                                            $integrityIndex++;
                                        }
                                    }
                                    if (4 <= mconfig("element_errtel_slots")) {
                                        echo "<hr>";
                                        $divinityIndex = 1;
                                        while ($divinityIndex <= 5) {
                                            if ($divinityIndex <= mconfig("element_divinity_slots")) {
                                                echo "\r\n                                    <div class=\"input-group webshop-options-group\">\r\n                                        <div class=\"input-group-addon\">" . sprintf(lang("webshop_69", true), $divinityIndex) . "</div>\r\n                                        <select id=\"divinity" . $divinityIndex . "\" name=\"divinity" . $divinityIndex . "\" class=\"form-control\" onchange=\"recalcOptionsPrice(); recalcTotalPrice();\">\r\n                                            " . $errtelOptions["divinity"][$divinityIndex] . "\r\n                                        </select>\r\n                                    </div>";
                                            }
                                            $divinityIndex++;
                                        }
                                    }
                                    if (5 <= mconfig("element_errtel_slots")) {
                                        echo "<hr>";
                                        $galeIndex = 1;
                                        while ($galeIndex <= 5) {
                                            if ($galeIndex <= mconfig("element_gale_slots")) {
                                                echo "\r\n                                    <div class=\"input-group webshop-options-group\">\r\n                                        <div class=\"input-group-addon\">" . sprintf(lang("webshop_70", true), $galeIndex) . "</div>\r\n                                        <select id=\"gale" . $galeIndex . "\" name=\"gale" . $galeIndex . "\" class=\"form-control\" onchange=\"recalcOptionsPrice(); recalcTotalPrice();\">\r\n                                            " . $errtelOptions["gale"][$galeIndex] . "\r\n                                        </select>\r\n                                    </div>";
                                            }
                                            $galeIndex++;
                                        }
                                    }
                                }
                                if ($itemDetail["KindA"] == "8" && $itemDetail["KindB"] == "43" && $currItem["item_id"] == "215") {
                                    $elementTypes = $Webshop->elementalTypes();
                                    $elementOptions = $Webshop->errtelOptionsBeginner();
                                    $elementTypesOpts = "";
                                    foreach ($elementTypes as $key => $thisType) {
                                        $thisTypePrice = 0;
                                        if ($key == 0) {
                                            $thisTypePrice = mconfig("element_none_price");
                                        } else {
                                            $thisTypePrice = mconfig("element_" . strtolower($thisType) . "_price");
                                        }
                                        $elementTypesOpts .= "<option value=\"" . $key . ":" . $thisTypePrice . "\">" . $thisType . "</option>";
                                    }
                                    echo "\r\n                                <div class=\"input-group webshop-options-group\">\r\n                                    <div class=\"input-group-addon\">" . lang("webshop_65", true) . "</div>\r\n                                    <select id=\"element\" name=\"element\" class=\"form-control\" onchange=\"recalcOptionsPrice(); recalcTotalPrice();\">\r\n                                        " . $elementTypesOpts . "\r\n                                    </select>\r\n                                </div>";
                                    $errtelOptions = [];
                                    foreach ($elementOptions as $thisOption) {
                                        $slotType = NULL;
                                        if ($thisOption["errtel"] == "1") {
                                            $slotType = "anger";
                                        } else {
                                            if ($thisOption["errtel"] == "2") {
                                                $slotType = "blessing";
                                            } else {
                                                if ($thisOption["errtel"] == "3") {
                                                    $slotType = "integrity";
                                                } else {
                                                    if ($thisOption["errtel"] == "4") {
                                                        $slotType = "divinity";
                                                    }
                                                }
                                            }
                                        }
                                        $easytoyou_decoder_beta_not_finish .= "<option value=\"0\">" . lang("pentagram_none", true) . "</option>";
                                        $easytoyou_decoder_beta_not_finish .= "<option value=\"1:" . mconfig("element_" . $slotType . "_" . $thisOption["errtel_rank"] . "_price") . ":0:" . mconfig("element_" . $slotType . "_" . $thisOption["errtel_rank"] . "_price_level") . "\">" . sprintf(lang($thisOption["errtel_option_lang"], true), $thisOption["errtel_level_0"]) . "</option>";
                                    }
                                    if (1 <= mconfig("element_errtel_slots")) {
                                        echo "<hr>";
                                        $angerIndex = 1;
                                        while ($angerIndex <= 1) {
                                            if ($angerIndex <= mconfig("element_anger_slots")) {
                                                echo "\r\n                                    <div class=\"input-group webshop-options-group\">\r\n                                        <div class=\"input-group-addon\">" . sprintf(lang("webshop_66", true), $angerIndex) . "</div>\r\n                                        <select id=\"anger" . $angerIndex . "\" name=\"anger" . $angerIndex . "\" class=\"form-control\" onchange=\"recalcOptionsPrice(); recalcTotalPrice();\">\r\n                                            " . $errtelOptions["anger"][$angerIndex] . "\r\n                                        </select>\r\n                                    </div>";
                                            }
                                            $angerIndex++;
                                        }
                                    }
                                    if (2 <= mconfig("element_errtel_slots")) {
                                        echo "<hr>";
                                        $blessingIndex = 1;
                                        while ($blessingIndex <= 1) {
                                            if ($blessingIndex <= mconfig("element_blessing_slots")) {
                                                echo "\r\n                                    <div class=\"input-group webshop-options-group\">\r\n                                        <div class=\"input-group-addon\">" . sprintf(lang("webshop_67", true), $blessingIndex) . "</div>\r\n                                        <select id=\"blessing" . $blessingIndex . "\" name=\"blessing" . $blessingIndex . "\" class=\"form-control\" onchange=\"recalcOptionsPrice(); recalcTotalPrice();\">\r\n                                            " . $errtelOptions["blessing"][$blessingIndex] . "\r\n                                        </select>\r\n                                    </div>";
                                            }
                                            $blessingIndex++;
                                        }
                                    }
                                    if (3 <= mconfig("element_errtel_slots")) {
                                        echo "<hr>";
                                        $integrityIndex = 1;
                                        while ($integrityIndex <= 1) {
                                            if ($integrityIndex <= mconfig("element_integrity_slots")) {
                                                echo "\r\n                                    <div class=\"input-group webshop-options-group\">\r\n                                        <div class=\"input-group-addon\">" . sprintf(lang("webshop_68", true), $integrityIndex) . "</div>\r\n                                        <select id=\"integrity" . $integrityIndex . "\" name=\"integrity" . $integrityIndex . "\" class=\"form-control\" onchange=\"recalcOptionsPrice(); recalcTotalPrice();\">\r\n                                            " . $errtelOptions["integrity"][$integrityIndex] . "\r\n                                        </select>\r\n                                    </div>";
                                            }
                                            $integrityIndex++;
                                        }
                                    }
                                    if (4 <= mconfig("element_errtel_slots")) {
                                        echo "<hr>";
                                        $divinityIndex = 1;
                                        while ($divinityIndex <= 1) {
                                            if ($divinityIndex <= mconfig("element_divinity_slots")) {
                                                echo "\r\n                                    <div class=\"input-group webshop-options-group\">\r\n                                        <div class=\"input-group-addon\">" . sprintf(lang("webshop_69", true), $divinityIndex) . "</div>\r\n                                        <select id=\"divinity" . $divinityIndex . "\" name=\"divinity" . $divinityIndex . "\" class=\"form-control\" onchange=\"recalcOptionsPrice(); recalcTotalPrice();\">\r\n                                            " . $errtelOptions["divinity"][$divinityIndex] . "\r\n                                        </select>\r\n                                    </div>";
                                            }
                                            $divinityIndex++;
                                        }
                                    }
                                }
                                echo "\r\n                                <input type=\"hidden\" id=\"payment-currency\" name=\"payment-currency\" value=\"" . mconfig("default_currency") . "\" />\r\n                                <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                                <input type=\"submit\" class=\"btn btn-warning full-width-btn webshop-purchase-item-btn\" name=\"submit\" value=\"" . lang("webshop_61", true) . "\" />\r\n                            </div>\r\n                        </form>\r\n                    </div>\r\n                </div>\r\n            </div>";
                            }
                        }
                    } else {
                        echo "\r\n            <div class=\"row\">\r\n                <div class=\"col-xs-12 webshop-right webshop-options\">\r\n                    <form method=\"get\" action=\"" . __BASE_URL__ . "usercp/webshop/class/" . $_GET["class"] . "/\">\r\n                        <div style=\"display: inline\">\r\n                            <div class=\"col-xs-12 webshop-right webshop-options\">\r\n                                " . lang("webshop_28", true) . ":&nbsp;\r\n                                <span class=\"webshop-hover\" onclick=\"\$('#webshop-list').show(); \$('#webshop-grid').hide();\"><i class=\"fa fa-th-list\"></i></span>\r\n                                <span class=\"webshop-hover webshop-space\" onclick=\"\$('#webshop-list').hide(); \$('#webshop-grid').show();\"><i class=\"fa fa-th-large\"></i></span>\r\n                                \r\n                                " . lang("webshop_51", true) . ":\r\n                                <select id=\"webshop-curr\" name=\"curr\" class=\"form-control webshop-curr webshop-space\" onchange=\"document.getElementById('submit-filter').click();\">";
                        if ($showPlatinum) {
                            if (check_value($_GET["curr"]) && $_GET["curr"] == "1" || !check_value($_GET["curr"]) && mconfig("default_currency") == "1") {
                                echo "<option value=\"1\" selected=\"selected\">" . lang("currency_platinum", true) . "</option>";
                            } else {
                                echo "<option value=\"1\">" . lang("currency_platinum", true) . "</option>";
                            }
                        }
                        if ($showGold) {
                            if (check_value($_GET["curr"]) && $_GET["curr"] == "2" || !check_value($_GET["curr"]) && mconfig("default_currency") == "2") {
                                echo "<option value=\"2\" selected=\"selected\">" . lang("currency_gold", true) . "</option>";
                            } else {
                                echo "<option value=\"2\">" . lang("currency_gold", true) . "</option>";
                            }
                        }
                        if ($showSilver) {
                            if (check_value($_GET["curr"]) && $_GET["curr"] == "3" || !check_value($_GET["curr"]) && mconfig("default_currency") == "3") {
                                echo "<option value=\"3\" selected=\"selected\">" . lang("currency_silver", true) . "</option>";
                            } else {
                                echo "<option value=\"3\">" . lang("currency_silver", true) . "</option>";
                            }
                        }
                        if ($showWcoin) {
                            if (check_value($_GET["curr"]) && $_GET["curr"] == "11" || !check_value($_GET["curr"]) && mconfig("default_currency") == "11") {
                                echo "<option value=\"11\" selected=\"selected\">" . lang("currency_wcoinc", true) . "</option>";
                            } else {
                                echo "<option value=\"11\">" . lang("currency_wcoinc", true) . "</option>";
                            }
                        }
                        if ($showGP) {
                            if (check_value($_GET["curr"]) && $_GET["curr"] == "13" || !check_value($_GET["curr"]) && mconfig("default_currency") == "13") {
                                echo "<option value=\"13\" selected=\"selected\">" . lang("currency_gp", true) . "</option>";
                            } else {
                                echo "<option value=\"13\">" . lang("currency_gp", true) . "</option>";
                            }
                        }
                        echo "\r\n                                </select>\r\n                                \r\n                                " . lang("webshop_22", true) . ":&nbsp;\r\n                                <select id=\"webshop-sort\" name=\"sort\" class=\"form-control webshop-sort webshop-space\" onchange=\"document.getElementById('submit-filter').click();\">";
                        if (check_value($_GET["sort"]) && $_GET["sort"] == "1") {
                            echo "<option value=\"1\" selected=\"selected\">" . lang("webshop_29", true) . "</option>";
                        } else {
                            echo "<option value=\"1\">" . lang("webshop_29", true) . "</option>";
                        }
                        if (check_value($_GET["sort"]) && $_GET["sort"] == "2") {
                            echo "<option value=\"2\" selected=\"selected\">" . lang("webshop_26", true) . "</option>";
                        } else {
                            echo "<option value=\"2\">" . lang("webshop_26", true) . "</option>";
                        }
                        if (check_value($_GET["sort"]) && $_GET["sort"] == "3") {
                            echo "<option value=\"3\" selected=\"selected\">" . lang("webshop_25", true) . "</option>";
                        } else {
                            echo "<option value=\"3\">" . lang("webshop_25", true) . "</option>";
                        }
                        if (check_value($_GET["sort"]) && $_GET["sort"] == "4") {
                            echo "<option value=\"4\" selected=\"selected\">" . lang("webshop_23", true) . "</option>";
                        } else {
                            echo "<option value=\"4\">" . lang("webshop_23", true) . "</option>";
                        }
                        if (check_value($_GET["sort"]) && $_GET["sort"] == "5") {
                            echo "<option value=\"5\" selected=\"selected\">" . lang("webshop_24", true) . "</option>";
                        } else {
                            echo "<option value=\"5\">" . lang("webshop_24", true) . "</option>";
                        }
                        echo "\r\n                                </select>";
                        echo "\r\n                                " . lang("webshop_30", true) . ":&nbsp;\r\n                                <select id=\"webshop-category\" name=\"category\" class=\"form-control webshop-category\" onchange=\"document.getElementById('submit-filter').click();\">";
                        if (!check_value($_GET["category"]) || $_GET["category"] == NULL || $_GET["category"] == "" || $_GET["category"] == "all") {
                            echo "<option value=\"all\" selected=\"selected\">" . lang("webshop_50", true) . "</option>";
                        } else {
                            echo "<option value=\"all\">" . lang("webshop_50", true) . "</option>";
                        }
                        $categories = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_WEBSHOP_CATEGORY WHERE type = 1 AND active = 1 ORDER BY [order]");
                        if (is_array($categories)) {
                            foreach ($categories as $thisCat) {
                                echo "<optgroup label=\"" . $thisCat["title"] . "\">";
                                $subcategories = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_WEBSHOP_CATEGORY WHERE type = ? AND parent = ? AND active = ? ORDER BY [order]", [2, $thisCat["code"], 1]);
                                if (is_array($subcategories)) {
                                    foreach ($subcategories as $thisSub) {
                                        if (check_value($_GET["category"]) && $_GET["category"] == $thisSub["code"]) {
                                            echo "<option value=\"" . $thisSub["code"] . "\" selected=\"selected\">" . $thisSub["title"] . "</option>";
                                        } else {
                                            echo "<option value=\"" . $thisSub["code"] . "\">" . $thisSub["title"] . "</option>";
                                        }
                                    }
                                }
                                echo "</optgroup>";
                            }
                        }
                        echo "\r\n                                </select>\r\n                                <input id=\"submit-filter\" type=\"submit\" class=\"hidden\" />\r\n                            </div>\r\n                        </div>\r\n                    </form>\r\n                </div>\r\n            </div>";
                        $webshopItems = $Webshop->loadWebshopItems($_GET["class"], $_GET["category"], $_GET["subcategory"], $_GET["sort"]);
                        if (is_array($webshopItems)) {
                            if (substr(basename($_SERVER["REQUEST_URI"]), 0, 1) == "?") {
                                $retUrl = $_GET["class"] . "/" . basename($_SERVER["REQUEST_URI"]);
                            } else {
                                $retUrl = basename($_SERVER["REQUEST_URI"]);
                            }
                            $retUrl = urlencode($retUrl);
                            echo "\r\n            <div id=\"webshop-list\" style=\"display: none;\">\r\n                <table class=\"table table-hover text-center webshop-table\">\r\n                    <thead>\r\n                        <tr>\r\n                            <th>" . lang("webshop_52", true) . "</th>\r\n                            <th>" . lang("webshop_53", true) . "</th>\r\n                            <th>" . lang("webshop_54", true) . "</th>\r\n                            <th>" . lang("webshop_55", true) . "</th>\r\n                        </tr>\r\n                    </thead>\r\n                    <tbody>";
                            foreach ($webshopItems as $thisItem) {
                                $image = $Webshop->returnImage($thisItem);
                                $isOnSale = "";
                                if (0 < $thisItem["on_sale"]) {
                                    $thisItem["price"] = $thisItem["price"] - floor($thisItem["price"] * $thisItem["on_sale"] / 100);
                                    $isOnSale = "&nbsp;<sup class=\"webshop-item-on-sale\">" . lang("webshop_92", true) . "</sup>";
                                }
                                echo "\r\n                        <tr>\r\n                            <td>" . $thisItem["name"] . "</td>\r\n                            <td>" . $custom["character_class"][$classReq[$thisItem["classReq"]]][0] . "</td>\r\n                            <td>";
                                if ($showPlatinum) {
                                    echo "<span class=\"price_platinum\" style=\"display: none;\">" . number_format(floor($thisItem["price"] * mconfig("ratio_platinum"))) . " " . lang("currency_platinum", true) . $isOnSale . "</span>";
                                }
                                if ($showGold) {
                                    echo "<span class=\"price_gold\" style=\"display: none;\">" . number_format(floor($thisItem["price"] * mconfig("ratio_gold"))) . " " . lang("currency_gold", true) . $isOnSale . "</span>";
                                }
                                if ($showSilver) {
                                    echo "<span class=\"price_silver\" style=\"display: none;\">" . number_format(floor($thisItem["price"] * mconfig("ratio_silver"))) . " " . lang("currency_silver", true) . $isOnSale . "</span>";
                                }
                                if ($showWcoin) {
                                    echo "<span class=\"price_wcoin\" style=\"display: none;\">" . number_format(floor($thisItem["price"] * mconfig("ratio_wcoin"))) . " " . lang("currency_wcoinc", true) . $isOnSale . "</span>";
                                }
                                if ($showGP) {
                                    echo "<span class=\"price_gp\" style=\"display: none;\">" . number_format(floor($thisItem["price"] * mconfig("ratio_gp"))) . " " . lang("currency_gp", true) . $isOnSale . "</span>";
                                }
                                if ($thisItem["isPackage"] == "1" || check_value($_GET["category"]) && $_GET["category"] == "52") {
                                    $addParam = "&package=1";
                                } else {
                                    if ($thisItem["isMystery"] == "1" || check_value($_GET["category"]) && $_GET["category"] == "52=3") {
                                        $addParam = "&mystery=1";
                                    } else {
                                        $addParam = "";
                                    }
                                }
                                echo "\r\n                            </td>\r\n                            <td>\r\n                                <a href=\"" . __BASE_URL__ . "usercp/webshop/class/" . $_GET["class"] . "/?customise=" . $thisItem["id"] . "&returl=" . __BASE_URL__ . "usercp/webshop/class/" . $retUrl . $addParam . "\">\r\n                                    <button class=\"btn btn-warning\">" . lang("webshop_56", true) . "</button>\r\n                                </a>\r\n                            </td>\r\n                        </tr>";
                            }
                            echo "\r\n                    </tbody>\r\n                </table>\r\n            </div>\r\n            <div id=\"webshop-grid\">";
                            foreach ($webshopItems as $thisItem) {
                                $image = $Webshop->returnImage($thisItem);
                                $isOnSale = "";
                                if (0 < $thisItem["on_sale"]) {
                                    $thisItem["price"] = $thisItem["price"] - floor($thisItem["price"] * $thisItem["on_sale"] / 100);
                                    $isOnSale = "&nbsp;<sup class=\"webshop-item-on-sale\">" . lang("webshop_92", true) . "</sup>";
                                }
                                if ($thisItem["isPackage"] == "1" || check_value($_GET["category"]) && $_GET["category"] == "52") {
                                    $addParam = "&package=1";
                                } else {
                                    if ($thisItem["isMystery"] == "1" || check_value($_GET["category"]) && $_GET["category"] == "53") {
                                        $addParam = "&mystery=1";
                                    } else {
                                        $addParam = "";
                                    }
                                }
                                echo "\r\n                <a href=\"" . __BASE_URL__ . "usercp/webshop/class/" . $_GET["class"] . "/?customise=" . $thisItem["id"] . "&returl=" . __BASE_URL__ . "usercp/webshop/class/" . $retUrl . $addParam . "\">\r\n                    <div class=\"col-xs-12 col-sm-6 col-md-4 col-lg-3 class-category\">\r\n                        <div class=\"webshop-item\">\r\n                            <div class=\"webshop-item-title\">" . $thisItem["name"] . "</div>\r\n                            <div class=\"webshop-item-img\">\r\n                                <span class=\"webshop-item-img-helper\"></span>\r\n                                <img src=\"" . $image . "\" alt=\"" . $thisItem["name"] . "\">\r\n                            </div>\r\n                            <div class=\"webshop-item-desc\">";
                                if ($showPlatinum) {
                                    echo "<span class=\"price_platinum\" style=\"display: none;\">" . number_format(floor($thisItem["price"] * mconfig("ratio_platinum"))) . " " . lang("currency_platinum", true) . $isOnSale . "</span>";
                                }
                                if ($showGold) {
                                    echo "<span class=\"price_gold\" style=\"display: none;\">" . number_format(floor($thisItem["price"] * mconfig("ratio_gold"))) . " " . lang("currency_gold", true) . $isOnSale . "</span>";
                                }
                                if ($showSilver) {
                                    echo "<span class=\"price_silver\" style=\"display: none;\">" . number_format(floor($thisItem["price"] * mconfig("ratio_silver"))) . " " . lang("currency_silver", true) . $isOnSale . "</span>";
                                }
                                if ($showWcoin) {
                                    echo "<span class=\"price_wcoin\" style=\"display: none;\">" . number_format(floor($thisItem["price"] * mconfig("ratio_wcoin"))) . " " . lang("currency_wcoinc", true) . $isOnSale . "</span>";
                                }
                                if ($showGP) {
                                    echo "<span class=\"price_gp\" style=\"display: none;\">" . number_format(floor($thisItem["price"] * mconfig("ratio_gp"))) . " " . lang("currency_gp", true) . $isOnSale . "</span>";
                                }
                                if ($addParam == "") {
                                    echo "\r\n                                <br>\r\n                                " . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][$classReq[$thisItem["classReq"]]][0]) . "";
                                } else {
                                    echo "<br>";
                                    if ($thisItem["isPackage"] == "1" || check_value($_GET["category"]) && $_GET["category"] == "52") {
                                        echo lang("webshop_94", true);
                                    } else {
                                        if ($thisItem["isMystery"] == "1" || check_value($_GET["category"]) && $_GET["category"] == "53") {
                                            echo lang("webshop_95", true);
                                        }
                                    }
                                }
                                echo "\r\n                            </div>\r\n                        </div>\r\n                    </div>\r\n                </a>";
                            }
                            echo "\r\n            </div>";
                        } else {
                            message("warning", "No items.");
                        }
                    }
                    echo "\r\n        </div>\r\n        <script type=\"text/javascript\">\r\n            \$(document).ready(function() {\r\n                var currFilter = \$(\"#webshop-curr\").val();\r\n                if (currFilter == \"1\") {\r\n                    \$(\".price_platinum\").show();\r\n                    \$(\".price_gold\").hide();\r\n                    \$(\".price_silver\").hide();\r\n                    \$(\".price_wcoin\").hide();\r\n                    \$(\".price_gp\").hide();\r\n                } else if (currFilter == \"2\") {\r\n                    \$(\".price_platinum\").hide();\r\n                    \$(\".price_gold\").show();\r\n                    \$(\".price_silver\").hide();\r\n                    \$(\".price_wcoin\").hide();\r\n                    \$(\".price_gp\").hide();\r\n                } else if (currFilter == \"3\") {\r\n                    \$(\".price_platinum\").hide();\r\n                    \$(\".price_gold\").hide();\r\n                    \$(\".price_silver\").show();\r\n                    \$(\".price_wcoin\").hide();\r\n                    \$(\".price_gp\").hide();\r\n                } else if (currFilter == \"11\") {\r\n                    \$(\".price_platinum\").hide();\r\n                    \$(\".price_gold\").hide();\r\n                    \$(\".price_silver\").hide();\r\n                    \$(\".price_wcoin\").show();\r\n                    \$(\".price_gp\").hide();\r\n                } else if (currFilter == \"13\") {\r\n                    \$(\".price_platinum\").hide();\r\n                    \$(\".price_gold\").hide();\r\n                    \$(\".price_silver\").hide();\r\n                    \$(\".price_wcoin\").hide();\r\n                    \$(\".price_gp\").show();\r\n                }\r\n            });\r\n        </script>";
                } else {
                    echo "\r\n        <div class=\"col-xs-12 col-sm-9 col-md-10\">";
                    if (0 < mconfig("global_discount")) {
                        echo "\r\n            <div class=\"row\">" . message("info", sprintf(lang("webshop_93", true), mconfig("global_discount"))) . "</div>";
                    }
                    echo "\r\n            <div class=\"row\">\r\n                <div class=\"col-xs-12 sale-holder\">";
                    echo "\r\n                </div>\r\n                <div class=\"col-xs-12 desc-holder\">\r\n                    " . lang("webshop_17", true) . "\r\n                </div>\r\n            </div>\r\n            <a href=\"" . __BASE_URL__ . "usercp/webshop/class/wizard/\">\r\n                <div class=\"col-xs-12 col-sm-6 col-md-4 col-lg-3 class-category\">\r\n                    <div class=\"thumbnail class-category-item\">\r\n                        <img src=\"" . __PATH_TEMPLATE_ASSETS__ . "characters/dw.jpg\" alt=\"\">\r\n                        <div class=\"caption\">\r\n                            <h3>" . lang("webshop_1", true) . "</h3>\r\n                            <p>" . lang("webshop_9", true) . "</p>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n            </a>\r\n            <a href=\"" . __BASE_URL__ . "usercp/webshop/class/knight/\">\r\n                <div class=\"col-xs-12 col-sm-6 col-md-4 col-lg-3 class-category\">\r\n                    <div class=\"thumbnail class-category-item\">\r\n                        <img src=\"" . __PATH_TEMPLATE_ASSETS__ . "characters/dk.jpg\" alt=\"\">\r\n                        <div class=\"caption\">\r\n                            <h3>" . lang("webshop_2", true) . "</h3>\r\n                            <p>" . lang("webshop_10", true) . "</p>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n            </a>\r\n            <a href=\"" . __BASE_URL__ . "usercp/webshop/class/elf/\">\r\n                <div class=\"col-xs-12 col-sm-6 col-md-4 col-lg-3 class-category\">\r\n                    <div class=\"thumbnail class-category-item\">\r\n                        <img src=\"" . __PATH_TEMPLATE_ASSETS__ . "characters/elf.jpg\" alt=\"\">\r\n                        <div class=\"caption\">\r\n                            <h3>" . lang("webshop_3", true) . "</h3>\r\n                            <p>" . lang("webshop_11", true) . "</p>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n            </a>\r\n            <a href=\"" . __BASE_URL__ . "usercp/webshop/class/summoner/\">\r\n                <div class=\"col-xs-12 col-sm-6 col-md-4 col-lg-3 class-category\">\r\n                    <div class=\"thumbnail class-category-item\">\r\n                        <img src=\"" . __PATH_TEMPLATE_ASSETS__ . "characters/sum.jpg\" alt=\"\">\r\n                        <div class=\"caption\">\r\n                            <h3>" . lang("webshop_4", true) . "</h3>\r\n                            <p>" . lang("webshop_12", true) . "</p>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n            </a>\r\n            <a href=\"" . __BASE_URL__ . "usercp/webshop/class/gladiator/\">\r\n                <div class=\"col-xs-12 col-sm-6 col-md-4 col-lg-3 class-category\">\r\n                    <div class=\"thumbnail class-category-item\">\r\n                        <img src=\"" . __PATH_TEMPLATE_ASSETS__ . "characters/mg.jpg\" alt=\"\">\r\n                        <div class=\"caption\">\r\n                            <h3>" . lang("webshop_5", true) . "</h3>\r\n                            <p>" . lang("webshop_13", true) . "</p>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n            </a>\r\n            <a href=\"" . __BASE_URL__ . "usercp/webshop/class/lord/\">\r\n                <div class=\"col-xs-12 col-sm-6 col-md-4 col-lg-3 class-category\">\r\n                    <div class=\"thumbnail class-category-item\">\r\n                        <img src=\"" . __PATH_TEMPLATE_ASSETS__ . "characters/dl.jpg\" alt=\"\">\r\n                        <div class=\"caption\">\r\n                            <h3>" . lang("webshop_6", true) . "</h3>\r\n                            <p>" . lang("webshop_14", true) . "</p>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n            </a>\r\n            <a href=\"" . __BASE_URL__ . "usercp/webshop/class/fighter/\">\r\n                <div class=\"col-xs-12 col-sm-6 col-md-4 col-lg-3 class-category\">\r\n                    <div class=\"thumbnail class-category-item\">\r\n                        <img src=\"" . __PATH_TEMPLATE_ASSETS__ . "characters/rf.jpg\" alt=\"\">\r\n                        <div class=\"caption\">\r\n                            <h3>" . lang("webshop_7", true) . "</h3>\r\n                            <p>" . lang("webshop_15", true) . "</p>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n            </a>";
                    if (100 <= config("server_files_season", true)) {
                        echo "\r\n            <a href=\"" . __BASE_URL__ . "usercp/webshop/class/lancer/\">\r\n                <div class=\"col-xs-12 col-sm-6 col-md-4 col-lg-3 class-category\">\r\n                    <div class=\"thumbnail class-category-item\">\r\n                        <img src=\"" . __PATH_TEMPLATE_ASSETS__ . "characters/gl.jpg\" alt=\"\">\r\n                        <div class=\"caption\">\r\n                            <h3>" . lang("webshop_8", true) . "</h3>\r\n                            <p>" . lang("webshop_16", true) . "</p>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n            </a>";
                    }
                    if (140 <= config("server_files_season", true)) {
                        echo "\r\n            <a href=\"" . __BASE_URL__ . "usercp/webshop/class/rune/\">\r\n                <div class=\"col-xs-12 col-sm-6 col-md-4 col-lg-3 class-category\">\r\n                    <div class=\"thumbnail class-category-item\">\r\n                        <img src=\"" . __PATH_TEMPLATE_ASSETS__ . "characters/rw.jpg\" alt=\"\">\r\n                        <div class=\"caption\">\r\n                            <h3>" . lang("webshop_57", true) . "</h3>\r\n                            <p>" . lang("webshop_58", true) . "</p>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n            </a>";
                    }
                    if (150 <= config("server_files_season", true)) {
                        echo "\r\n            <a href=\"" . __BASE_URL__ . "usercp/webshop/class/slayer/\">\r\n                <div class=\"col-xs-12 col-sm-6 col-md-4 col-lg-3 class-category\">\r\n                    <div class=\"thumbnail class-category-item\">\r\n                        <img src=\"" . __PATH_TEMPLATE_ASSETS__ . "characters/sr.jpg\" alt=\"\">\r\n                        <div class=\"caption\">\r\n                            <h3>" . lang("webshop_89", true) . "</h3>\r\n                            <p>" . lang("webshop_90", true) . "</p>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n            </a>";
                    }
                    echo "\r\n        </div>";
                }
            }
            echo "\r\n    </div>";
        } else {
            message("error", lang("error_47", true));
        }
    }
}

?>