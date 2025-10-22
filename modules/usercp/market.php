<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */
if (!isLoggedIn()) {
    redirect(1, "login");
} else {
    if (strpos($_SERVER["REQUEST_URI"], "page") === false && !isset($_GET["my"]) && $_GET["my"] != "items") {
        redirect("1", "usercp/market/page/1/");
    }
    loadModuleConfigs("market");
    if (!canAccessModule($_SESSION["username"], "market", "block")) {
        return NULL;
    }
    if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
        echo "<script type=\"text/javascript\" SRC=\"" . __PATH_TEMPLATE_ASSETS__ . "js/tooltip.js\"></script>";
        $breadcrumb = generateBreadcrumb();
        echo "\r\n    <h3>\r\n        " . lang("market_txt_166", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
        if (mconfig("active")) {
            $General = new xGeneral();
            $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("market");
            $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("market");
            $Market = new Market();
            $Items = new Items();
            if (isset($_GET["my"]) && $_GET["my"] == "items") {
                if (check_value($_POST["extenditem"])) {
                    if ($_SESSION["token"] == $_POST["token"]) {
                        $market_id = htmlspecialchars($_POST[Encode("id")]);
                        if ($common->beginDbTrans($_SESSION["username"])) {
                            $Market->extendItem($market_id, $_SESSION["username"]);
                            $common->endDbTrans($_SESSION["username"]);
                        }
                    } else {
                        message("notice", lang("global_module_13", true));
                    }
                }
                if (check_value($_POST["buyitem"])) {
                    if ($_SESSION["token"] == $_POST["token"]) {
                        $market_id = htmlspecialchars($_POST[Encode("id")]);
                        if ($common->beginDbTrans($_SESSION["username"])) {
                            $buyitem = $Market->buyItem($market_id, $_SESSION["username"]);
                            $common->endDbTrans($_SESSION["username"]);
                        }
                    } else {
                        message("notice", lang("global_module_13", true));
                    }
                }
                echo "\r\n    <div class=\"row\">\r\n        <div class=\"col-xs-12\">\r\n            <div class=\"form-group\">\r\n                <a href=\"" . __BASE_URL__ . "usercp/market/page/1\">\r\n                    <button class=\"btn btn-warning\">" . lang("market_txt_166", true) . "</button>\r\n                </a>\r\n                <a href=\"" . __BASE_URL__ . "usercp/vault\">\r\n                    <button class=\"btn btn-warning\">" . lang("market_txt_167", true) . "</button>\r\n                </a>\r\n                <a href=\"" . __BASE_URL__ . "usercp/items\">\r\n                    <button class=\"btn btn-warning\">" . lang("market_txt_168", true) . "</button>\r\n                </a>\r\n            </div>\r\n        </div>\r\n    </div>";
                $token = time();
                $_SESSION["token"] = $token;
                $items = $Market->getMyMarketItems($_SESSION["username"]);
                if (is_array($items)) {
                    echo "\r\n    <div class=\"table-responsive rankings-table\">\r\n        <table class=\"table table-hover text-center\">\r\n            <tr>\r\n                <th class=\"headerRow\">" . lang("market_txt_205", true) . "</th>\r\n                <th class=\"headerRow\">" . lang("market_txt_206", true) . "</th>\r\n                <th class=\"headerRow\">" . lang("market_txt_207", true) . "</th>";
                    if (mconfig("remove_items")) {
                        echo "<th class=\"headerRow\">" . lang("market_txt_211", true) . "</th>";
                    }
                    echo "\r\n                <th class=\"headerRow\">" . lang("market_txt_209", true) . "</th>\r\n            </tr>";
                    foreach ($items as $thisItem) {
                        $seller = $thisItem["seller"];
                        $itemData = $Items->ItemInfo($thisItem["item"], $seller, NULL, 1);
                        $price = $Market->showStyledPrice($thisItem["price_type"], $thisItem["price"]);
                        $itemDb = $Market->getItemInfo($itemData["type"], $itemData["id"], $thisItem["sticklevel"]);
                        $tax_type = mconfig("tax_type");
                        if ($tax_type == "1") {
                            $tax_type = lang("currency_platinum", true);
                        } else {
                            if ($tax_type == "2") {
                                $tax_type = lang("currency_gold", true);
                            } else {
                                if ($tax_type == "3") {
                                    $tax_type = lang("currency_silver", true);
                                } else {
                                    if ($tax_type == "4") {
                                        $tax_type = lang("currency_wcoinc", true);
                                    } else {
                                        if ($tax_type == "5") {
                                            $tax_type = lang("currency_gp", true);
                                        } else {
                                            if ($tax_type == "6") {
                                                $tax_type = "" . lang("currency_zen", true) . "";
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        $extendPrice = mconfig("extend_price");
                        $expireTime = strtotime($thisItem["start_date"]) + mconfig("remove_items_days") * 24 * 3600;
                        if ($thisItem["Extend"] == "1") {
                            $expireTime = $expireTime + mconfig("remove_items_days") * 24 * 3600;
                        }
                        echo "\r\n            <tr>\r\n                <td class=\"items-inventory-item-bg\">\r\n                    <span style=\"color:" . $itemData["color"] . ";background-color:" . $itemData["anco"] . "; padding: 2px 2px 2px 2px; cursor: pointer;\" onmouseover=\"Tip(" . $Items->generateItemTooltip($itemData, 1, 1, 1, 1, 0, 0) . ")\" onmouseout=\"UnTip()\">" . $Items->generateItemName($itemData["name"], $itemData["level"]) . "</span>\r\n                </td>\r\n                <td>" . $price . "</td>\r\n                <td>" . date($config["time_date_format"], strtotime($thisItem["start_date"])) . "</td>";
                        if (mconfig("remove_items")) {
                            echo "<td>" . date($config["time_date_format"], $expireTime) . "</td>";
                        }
                        echo "\r\n                <td>\r\n                    <form name=\"item\" method=\"post\">\r\n                        <input type=\"hidden\" name=\"" . Encode("id") . "\" value=\"" . Encode($thisItem["id"]) . "\">\r\n                        <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">";
                        echo "<input type=\"submit\" name=\"buyitem\" value=\"" . lang("market_txt_190", true) . "\" onclick=\"javascript:if(!confirm('" . lang("market_txt_200", true) . "')){ return false; }\"/ class=\"btn btn-warning\">";
                        if (mconfig("remove_items")) {
                            if ($thisItem["Extend"] == "0") {
                                if (0 < $extendPrice) {
                                    echo "&nbsp;<input type=\"submit\" name=\"extenditem\" value=\"" . lang("market_txt_212", true) . "\" onclick=\"javascript:if(!confirm('" . sprintf(lang("market_txt_215", true), $extendPrice, $tax_type) . "')){ return false; }\"/ class=\"btn btn-warning\">";
                                } else {
                                    echo "&nbsp;<input type=\"submit\" name=\"extenditem\" value=\"" . lang("market_txt_212", true) . "\" onclick=\"javascript:if(!confirm('" . lang("market_txt_213", true) . "')){ return false; }\"/ class=\"btn btn-warning\">";
                                }
                            } else {
                                echo "&nbsp;<input type=\"button\" value=\"" . lang("market_txt_214", true) . "\" class=\"btn btn-warning\" disabled=\"disabled\">";
                            }
                        }
                        echo "\r\n                    </form>\r\n                </td>\r\n            </tr>";
                    }
                    echo "\r\n        </table>\r\n    </div>";
                } else {
                    message("info", lang("market_txt_192", true));
                }
            } else {
                if (check_value($_POST["filter"])) {
                    $name_filter = htmlspecialchars($_POST["name_filter"]);
                    $category_filter = htmlspecialchars($_POST["category_filter"]);
                    $url = "";
                    if ($name_filter != NULL && $category_filter != NULL) {
                        $url = "?search=" . $name_filter . "&cat=" . $category_filter;
                    } else {
                        if ($name_filter != NULL) {
                            $url = "?search=" . $name_filter;
                        } else {
                            if ($category_filter != NULL) {
                                $url = "?cat=" . $category_filter;
                            }
                        }
                    }
                    redirect("1", "usercp/market/page/1/" . $url);
                }
                if (check_value($_POST["reset_filter"])) {
                    redirect("1", "usercp/market/page/1/");
                }
                if (check_value($_POST["buyitem"])) {
                    if ($_SESSION["token"] == $_POST["token"]) {
                        $market_id = htmlspecialchars($_POST[Encode("id")]);
                        if ($common->beginDbTrans($_SESSION["username"])) {
                            $buyitem = $Market->buyItem($market_id, $_SESSION["username"]);
                            $common->endDbTrans($_SESSION["username"]);
                        }
                    } else {
                        message("notice", lang("global_module_13", true));
                    }
                }
                echo "\r\n    <div class=\"row\">\r\n        <div class=\"col-xs-12 col-sm-5 col-lg-4\">\r\n            <div class=\"form-group\">\r\n                <a href=\"" . __BASE_URL__ . "usercp/market/my/items\">\r\n                    <button class=\"btn btn-warning\">" . lang("market_txt_210", true) . "</button>\r\n                </a>\r\n                <a href=\"" . __BASE_URL__ . "usercp/vault\">\r\n                    <button class=\"btn btn-warning\">" . lang("market_txt_167", true) . "</button>\r\n                </a>\r\n                <a href=\"" . __BASE_URL__ . "usercp/items\">\r\n                    <button class=\"btn btn-warning\">" . lang("market_txt_168", true) . "</button>\r\n                </a>\r\n            </div>\r\n        </div>\r\n        <div class=\"col-xs-12 col-sm-7 col-lg-8 market-filters\">\r\n            <form method=\"post\" class=\"form-inline\">\r\n                <div class=\"form-group\">\r\n                    <label class=\"sr-only\">" . lang("market_txt_169", true) . "</label>\r\n                    <input type=\"text\" class=\"form-control\" id=\"name_filter\" name=\"name_filter\" placeholder=\"" . lang("market_txt_169", true) . "\" value=\"" . $_GET["search"] . "\">\r\n                </div>\r\n                <div class=\"form-group\">\r\n                    <label class=\"sr-only\">" . lang("market_txt_169", true) . "</label>\r\n                    <select id=\"category_filter\" name=\"category_filter\" class=\"form-control\">";
                if ($_GET["cat"] == NULL) {
                    echo "<option selected=\"selected\" value=\"\">" . lang("market_txt_170", true) . "</option>";
                } else {
                    echo "<option value=\"\">" . lang("market_txt_170", true) . "</option>";
                }
                if ($_GET["cat"] == "0") {
                    echo "<option selected=\"selected\" value=\"0\">" . lang("market_txt_171", true) . "</option>";
                } else {
                    echo "<option value=\"0\">" . lang("market_txt_171", true) . "</option>";
                }
                if ($_GET["cat"] == "1") {
                    echo "<option selected=\"selected\" value=\"1\">" . lang("market_txt_172", true) . "</option>";
                } else {
                    echo "<option value=\"1\">" . lang("market_txt_172", true) . "</option>";
                }
                if ($_GET["cat"] == "2") {
                    echo "<option selected=\"selected\" value=\"2\">" . lang("market_txt_173", true) . "</option>";
                } else {
                    echo "<option value=\"2\">" . lang("market_txt_173", true) . "</option>";
                }
                if ($_GET["cat"] == "3") {
                    echo "<option selected=\"selected\" value=\"3\">" . lang("market_txt_174", true) . "</option>";
                } else {
                    echo "<option value=\"3\">" . lang("market_txt_174", true) . "</option>";
                }
                if ($_GET["cat"] == "4") {
                    echo "<option selected=\"selected\" value=\"4\">" . lang("market_txt_175", true) . "</option>";
                } else {
                    echo "<option value=\"4\">" . lang("market_txt_175", true) . "</option>";
                }
                if ($_GET["cat"] == "5") {
                    echo "<option selected=\"selected\" value=\"5\">" . lang("market_txt_176", true) . "</option>";
                } else {
                    echo "<option value=\"5\">" . lang("market_txt_176", true) . "</option>";
                }
                if ($_GET["cat"] == "6") {
                    echo "<option selected=\"selected\" value=\"6\">" . lang("market_txt_177", true) . "</option>";
                } else {
                    echo "<option value=\"6\">" . lang("market_txt_177", true) . "</option>";
                }
                if ($_GET["cat"] == "7") {
                    echo "<option selected=\"selected\" value=\"7\">" . lang("market_txt_178", true) . "</option>";
                } else {
                    echo "<option value=\"7\">" . lang("market_txt_178", true) . "</option>";
                }
                if ($_GET["cat"] == "8") {
                    echo "<option selected=\"selected\" value=\"8\">" . lang("market_txt_179", true) . "</option>";
                } else {
                    echo "<option value=\"8\">" . lang("market_txt_179", true) . "</option>";
                }
                if ($_GET["cat"] == "9") {
                    echo "<option selected=\"selected\" value=\"9\">" . lang("market_txt_180", true) . "</option>";
                } else {
                    echo "<option value=\"9\">" . lang("market_txt_180", true) . "</option>";
                }
                if ($_GET["cat"] == "10") {
                    echo "<option selected=\"selected\" value=\"10\">" . lang("market_txt_181", true) . "</option>";
                } else {
                    echo "<option value=\"10\">" . lang("market_txt_181", true) . "</option>";
                }
                if ($_GET["cat"] == "11") {
                    echo "<option selected=\"selected\" value=\"11\">" . lang("market_txt_182", true) . "</option>";
                } else {
                    echo "<option value=\"11\">" . lang("market_txt_182", true) . "</option>";
                }
                if ($_GET["cat"] == "12") {
                    echo "<option selected=\"selected\" value=\"12\">" . lang("market_txt_183", true) . "</option>";
                } else {
                    echo "<option value=\"12\">" . lang("market_txt_183", true) . "</option>";
                }
                if ($_GET["cat"] == "13") {
                    echo "<option selected=\"selected\" value=\"13\">" . lang("market_txt_184", true) . "</option>";
                } else {
                    echo "<option value=\"13\">" . lang("market_txt_184", true) . "</option>";
                }
                if ($_GET["cat"] == "14") {
                    echo "<option selected=\"selected\" value=\"14\">" . lang("market_txt_185", true) . "</option>";
                } else {
                    echo "<option value=\"14\">" . lang("market_txt_185", true) . "</option>";
                }
                if ($_GET["cat"] == "15") {
                    echo "<option selected=\"selected\" value=\"15\">" . lang("market_txt_186", true) . "</option>";
                } else {
                    echo "<option value=\"15\">" . lang("market_txt_186", true) . "</option>";
                }
                echo "\r\n                    </select>\r\n                </div>\r\n                <div class=\"form-group\">\r\n                    <input type=\"submit\" name=\"filter\" value=\"" . lang("market_txt_187", true) . "\" class=\"btn btn-primary\">\r\n                    <input type=\"submit\" name=\"reset_filter\" value=\"" . lang("market_txt_188", true) . "\" class=\"btn btn-danger\">\r\n                </div>\r\n            </form>\r\n        </div>\r\n    </div>";
                $page = $_GET["page"];
                $name_filter = $_GET["search"];
                $category_filter = $_GET["cat"];
                $token = time();
                $_SESSION["token"] = $token;
                $items = $Market->getMarketItems($page, $name_filter, $category_filter);
                if (is_array($items)) {
                    echo "\r\n    <div class=\"table-responsive rankings-table\">\r\n        <table class=\"table table-hover text-center\">\r\n            <tr>\r\n                <th class=\"headerRow\">" . lang("market_txt_205", true) . "</th>\r\n                <th class=\"headerRow\">" . lang("market_txt_206", true) . "</th>\r\n                <th class=\"headerRow\">" . lang("market_txt_207", true) . "</th>";
                    if (!mconfig("hide_author")) {
                        echo "<th class=\"headerRow\">" . lang("market_txt_208", true) . "</th>";
                    }
                    echo "\r\n                <th class=\"headerRow\">" . lang("market_txt_209", true) . "</th>\r\n            </tr>";
                    foreach ($items as $thisItem) {
                        $seller = $thisItem["seller"];
                        $itemData = $Items->ItemInfo($thisItem["item"], $seller, NULL, 1);
                        $price = $Market->showStyledPrice($thisItem["price_type"], $thisItem["price"]);
                        $itemDb = $Market->getItemInfo($itemData["type"], $itemData["id"], $thisItem["sticklevel"]);
                        echo "\r\n            <tr>\r\n                <td class=\"items-inventory-item-bg\">\r\n                    <span style=\"color:" . $itemData["color"] . ";background-color:" . $itemData["anco"] . "; padding: 2px 2px 2px 2px; cursor: pointer;\" onmouseover=\"Tip(" . $Items->generateItemTooltip($itemData, 1, 1, 1, 1, 0, 0) . ")\" onmouseout=\"UnTip()\">" . $Items->generateItemName($itemData["name"], $itemData["level"]) . "</span>\r\n                </td>\r\n                <td>" . $price . "</td>\r\n                <td>" . date($config["time_date_format"], strtotime($thisItem["start_date"])) . "</td>";
                        if (!mconfig("hide_author")) {
                            echo "\r\n                <td>" . $thisItem["seller"] . "</td>";
                        }
                        echo "\r\n                <td>\r\n                    <form name=\"item\" method=\"post\">\r\n                        <input type=\"hidden\" name=\"" . Encode("id") . "\" value=\"" . Encode($thisItem["id"]) . "\">\r\n                        <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">";
                        if ($_SESSION["username"] == $seller) {
                            echo "<input type=\"submit\" name=\"buyitem\" value=\"" . lang("market_txt_190", true) . "\" onclick=\"javascript:if(!confirm('" . lang("market_txt_200", true) . "')){ return false; }\"/ class=\"btn btn-warning\">";
                        } else {
                            echo "<input type=\"submit\" name=\"buyitem\" value=\"" . lang("market_txt_191", true) . "\" onclick=\"javascript:if(!confirm('" . lang("market_txt_199", true) . "')){ return false; }\"/ class=\"btn btn-warning\">";
                        }
                        echo "\r\n                    </form>\r\n                </td>\r\n            </tr>";
                    }
                    echo "\r\n        </table>\r\n    </div>\r\n    <nav aria-label=\"pagination\" class=\"market-pagination\">\r\n        <ul class=\"pagination\">";
                    $limit = mconfig("page");
                    $total_items = $Market->getTotalMarketItems($name_filter, $category_filter);
                    $total_pages = ceil($total_items / $limit);
                    $i = 1;
                    while ($i <= $total_pages) {
                        if ($i == $page) {
                            echo "<li class=\"active\"><a href=\"" . __BASE_URL__ . "usercp/market/page/" . $i . "/" . $filter . "\">" . $i . " <span class=\"sr-only\">(current)</span></a></li>";
                        } else {
                            $url = $_SERVER["REQUEST_URI"];
                            $filter = substr(strrchr($url, "/"), 1);
                            echo "<li><a href=\"" . __BASE_URL__ . "usercp/market/page/" . $i . "/" . $filter . "\">" . $i . "</a></li>";
                        }
                        $i++;
                    }
                    echo "\r\n        </ul>\r\n    </nav>";
                } else {
                    message("info", lang("market_txt_192", true));
                }
            }
        } else {
            message("error", lang("error_47", true));
        }
    } else {
        echo "<script type=\"text/javascript\" SRC=\"" . __PATH_TEMPLATE__ . "js/tooltip.js\"></script>";
        echo "\r\n<div class=\"sub-page-title\">\r\n    <div id=\"title\"><h1>" . lang("module_titles_txt_3", true) . "<p></p><span></span></h1></div>\r\n</div>\r\n  <div class=\"container_2 account\" align=\"center\">\r\n    <div class=\"cont-image\">\r\n      <div class=\"container_3 account_sub_header\">\r\n        <div class=\"grad\">\r\n          <div class=\"page-title\">" . lang("market_txt_166", true) . "</div>\r\n          <a href=\"" . __BASE_URL__ . "usercp/vault\" style=\"background-image: none;padding: 9px 12px 10px 10px\">" . lang("market_txt_167", true) . "</a>\r\n          <a href=\"" . __BASE_URL__ . "usercp/items\" style=\"background-image: none;padding: 9px 12px 10px 10px\">" . lang("market_txt_168", true) . "</a>\r\n          <a href=\"" . __BASE_URL__ . "usercp\">" . lang("global_module_1", true) . "</a>\r\n        </div>\r\n      </div>";
        if (mconfig("active")) {
            $General = new xGeneral();
            $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("market");
            $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("market");
            $Market = new Market();
            $Items = new Items();
            if (check_value($_POST["filter"])) {
                $name_filter = htmlspecialchars($_POST["name_filter"]);
                $category_filter = htmlspecialchars($_POST["category_filter"]);
                $url = "";
                if ($name_filter != NULL && $category_filter != NULL) {
                    $url = "?search=" . $name_filter . "&cat=" . $category_filter;
                } else {
                    if ($name_filter != NULL) {
                        $url = "?search=" . $name_filter;
                    } else {
                        if ($category_filter != NULL) {
                            $url = "?cat=" . $category_filter;
                        }
                    }
                }
                redirect("1", "usercp/market/page/1/" . $url);
            }
            if (check_value($_POST["reset_filter"])) {
                redirect("1", "usercp/market/page/1/");
            }
            if (check_value($_POST["buyitem"])) {
                if ($_SESSION["token"] == $_POST["token"]) {
                    $market_id = htmlspecialchars($_POST[Encode("id")]);
                    $buyitem = $Market->buyItem($market_id, $_SESSION["username"]);
                } else {
                    message("notice", lang("global_module_13", true));
                }
            }
            echo "\r\n      <div class=\"market_body\" style=\"margin: 0 0 0 0;\">\r\n        <form id=\"market_form\" method=\"post\">\r\n          \r\n          <div class=\"market_header\" align=\"left\">\r\n            <div style=\"padding: 6px 6px 6px 6px;\">\r\n              <table width=\"100%\">\r\n                <tr>\r\n                  <td><input type=\"text\" id=\"name_filter\" placeholder=\"" . lang("market_txt_169", true) . "\" name=\"name_filter\" value=\"" . $_GET["search"] . "\"></td>\r\n                  <td>\r\n                    <select id=\"category_filter\" name=\"category_filter\" styled=\"true\" style=\"display: none;\">";
            if ($_GET["cat"] == NULL) {
                echo "<option selected=\"selected\" value=\"\">" . lang("market_txt_170", true) . "</option>";
            } else {
                echo "<option value=\"\">All</option>";
            }
            if ($_GET["cat"] == "0") {
                echo "<option selected=\"selected\" value=\"0\" style=\"color: #9D9D9D;\">" . lang("market_txt_171", true) . "</option>";
            } else {
                echo "<option value=\"0\" style=\"color: #9D9D9D;\">" . lang("market_txt_171", true) . "</option>";
            }
            if ($_GET["cat"] == "1") {
                echo "<option selected=\"selected\" value=\"1\" style=\"color: #9D9D9D;\">" . lang("market_txt_172", true) . "</option>";
            } else {
                echo "<option value=\"1\" style=\"color: #9D9D9D;\">" . lang("market_txt_172", true) . "</option>";
            }
            if ($_GET["cat"] == "2") {
                echo "<option selected=\"selected\" value=\"2\" style=\"color: #9D9D9D;\">" . lang("market_txt_173", true) . "</option>";
            } else {
                echo "<option value=\"2\" style=\"color: #9D9D9D;\">" . lang("market_txt_173", true) . "</option>";
            }
            if ($_GET["cat"] == "3") {
                echo "<option selected=\"selected\" value=\"3\" style=\"color: #9D9D9D;\">" . lang("market_txt_174", true) . "</option>";
            } else {
                echo "<option value=\"3\" style=\"color: #9D9D9D;\">" . lang("market_txt_174", true) . "</option>";
            }
            if ($_GET["cat"] == "4") {
                echo "<option selected=\"selected\" value=\"4\" style=\"color: #9D9D9D;\">" . lang("market_txt_175", true) . "</option>";
            } else {
                echo "<option value=\"4\" style=\"color: #9D9D9D;\">" . lang("market_txt_175", true) . "</option>";
            }
            if ($_GET["cat"] == "5") {
                echo "<option selected=\"selected\" value=\"5\" style=\"color: #9D9D9D;\">" . lang("market_txt_176", true) . "</option>";
            } else {
                echo "<option value=\"5\" style=\"color: #9D9D9D;\">" . lang("market_txt_176", true) . "</option>";
            }
            if ($_GET["cat"] == "6") {
                echo "<option selected=\"selected\" value=\"6\" style=\"color: #9D9D9D;\">" . lang("market_txt_177", true) . "</option>";
            } else {
                echo "<option value=\"6\" style=\"color: #9D9D9D;\">" . lang("market_txt_177", true) . "</option>";
            }
            if ($_GET["cat"] == "7") {
                echo "<option selected=\"selected\" value=\"7\" style=\"color: #9D9D9D;\">" . lang("market_txt_178", true) . "</option>";
            } else {
                echo "<option value=\"7\" style=\"color: #9D9D9D;\">" . lang("market_txt_178", true) . "</option>";
            }
            if ($_GET["cat"] == "8") {
                echo "<option selected=\"selected\" value=\"8\" style=\"color: #9D9D9D;\">" . lang("market_txt_179", true) . "</option>";
            } else {
                echo "<option value=\"8\" style=\"color: #9D9D9D;\">" . lang("market_txt_179", true) . "</option>";
            }
            if ($_GET["cat"] == "9") {
                echo "<option selected=\"selected\" value=\"9\" style=\"color: #9D9D9D;\">" . lang("market_txt_180", true) . "</option>";
            } else {
                echo "<option value=\"9\" style=\"color: #9D9D9D;\">" . lang("market_txt_180", true) . "</option>";
            }
            if ($_GET["cat"] == "10") {
                echo "<option selected=\"selected\" value=\"10\" style=\"color: #9D9D9D;\">" . lang("market_txt_181", true) . "</option>";
            } else {
                echo "<option value=\"10\" style=\"color: #9D9D9D;\">" . lang("market_txt_181", true) . "</option>";
            }
            if ($_GET["cat"] == "11") {
                echo "<option selected=\"selected\" value=\"11\" style=\"color: #9D9D9D;\">" . lang("market_txt_182", true) . "</option>";
            } else {
                echo "<option value=\"11\" style=\"color: #9D9D9D;\">" . lang("market_txt_182", true) . "</option>";
            }
            if ($_GET["cat"] == "12") {
                echo "<option selected=\"selected\" value=\"12\" style=\"color: #9D9D9D;\">" . lang("market_txt_183", true) . "</option>";
            } else {
                echo "<option value=\"12\" style=\"color: #9D9D9D;\">" . lang("market_txt_183", true) . "</option>";
            }
            if ($_GET["cat"] == "13") {
                echo "<option selected=\"selected\" value=\"13\" style=\"color: #9D9D9D;\">" . lang("market_txt_184", true) . "</option>";
            } else {
                echo "<option value=\"13\" style=\"color: #9D9D9D;\">" . lang("market_txt_184", true) . "</option>";
            }
            if ($_GET["cat"] == "14") {
                echo "<option selected=\"selected\" value=\"14\" style=\"color: #9D9D9D;\">" . lang("market_txt_185", true) . "</option>";
            } else {
                echo "<option value=\"14\" style=\"color: #9D9D9D;\">" . lang("market_txt_185", true) . "</option>";
            }
            if ($_GET["cat"] == "15") {
                echo "<option selected=\"selected\" value=\"15\" style=\"color: #9D9D9D;\">" . lang("market_txt_186", true) . "</option>";
            } else {
                echo "<option value=\"15\" style=\"color: #9D9D9D;\">" . lang("market_txt_186", true) . "</option>";
            }
            echo "\r\n                    </select>       \r\n                  </td>\r\n                  <td align=\"right\"><input type=\"submit\" name=\"filter\" value=\"" . lang("market_txt_187", true) . "\" class=\"simple_button purchase_button\">&nbsp;\r\n                  <input type=\"submit\" name=\"reset_filter\" value=\"" . lang("market_txt_188", true) . "\" class=\"simple_button purchase_button\"></td>\r\n                </tr>\r\n              </table>\r\n            </div>\r\n          </div>\r\n          \r\n          <div class=\"market_inner_body\">\r\n            <div class=\"market_right_side\">\r\n              <div class=\"market_items_list\">\r\n                <div class=\"viewport\">\r\n                  <div class=\"overview\" style=\"top: 0px;\">";
            $page = $_GET["page"];
            $name_filter = $_GET["search"];
            $category_filter = $_GET["cat"];
            $token = time();
            $_SESSION["token"] = $token;
            $items = $Market->getMarketItems($page, $name_filter, $category_filter);
            if (is_array($items)) {
                echo "<ul class=\"items\">";
                foreach ($items as $thisItem) {
                    $itemData = $Items->ItemInfo($thisItem["item"]);
                    $price = $Market->showStyledPrice($thisItem["price_type"], $thisItem["price"]);
                    $itemDb = $Market->getItemInfo($itemData["type"], $itemData["id"], $thisItem["sticklevel"]);
                    $seller = $thisItem["seller"];
                    if (0 < $itemDb["exc"]) {
                        $level = "+" . $itemData["level"] . "";
                    } else {
                        $level = "";
                    }
                    if ($itemData["level"]) {
                        $itemData["level"] = " +" . $itemData["level"];
                    } else {
                        $itemData["level"] = NULL;
                    }
                    if ($itemData["luck"]) {
                        $luck = "<br><font color=#9aadd5>" . $itemData["luck"] . "</font>";
                    } else {
                        $luck = "";
                    }
                    if ($itemData["skill"]) {
                        $skill = "<br><font color=#9aadd5>" . $itemData["skill"] . "</font>";
                    } else {
                        $skill = "";
                    }
                    if ($itemData["opt"]) {
                        $option = "<font color=#9aadd5>" . $itemData["opt"] . "</font>";
                    } else {
                        $option = "";
                    }
                    if ($itemData["exl"]) {
                        $exl = "<font color=#4d668d>" . str_replace("^^", "<br>", $itemData["exl"]) . "</font>";
                    } else {
                        $exl = "";
                    }
                    if ($itemData["ancsetopt"]) {
                        $ancsetopt = "<font color=#9aadd5>" . str_replace("^^", "<br>", $itemData["ancsetopt"]) . "</font>";
                    } else {
                        $ancsetopt = "";
                    }
                    $exl = str_replace("'", "\\'", $exl);
                    echo "\r\n                      <li class=\"item\">\r\n                        <div id=\"hover\"></div>\r\n                        <span onmouseover=\"Tip('<center><img src=" . $itemData["thumb"] . "><br /><font color=yellow><br>" . lang("market_txt_100", true) . " " . $itemData["sn2"] . $itemData["sn"] . "</font><br><font color=white><br>" . lang("market_txt_101", true) . " " . $itemData["dur"] . "</font><br><font color=#FF99CC>" . $itemData["jog"] . "</font><font color=FFCC00>" . $itemData["harm"] . "</font><br>" . $option . " " . $luck . " " . $skill . " " . $exl . " <br>" . $ancsetopt . "<br><font color=#4d668d>" . $itemData["socket"] . "</font><br><br><span class=itemTooltipClassReq>" . $itemInfo["classReq"] . "</span></center>', TITLEFONTCOLOR, '" . $itemData["color"] . "',TITLE,'" . addslashes($itemData["name"]) . $itemData["level"] . "',TITLEBGCOLOR,'" . $itemData["anco"] . "')\" onmouseout=\"UnTip()\">\r\n                          <img id=\"icon\" class=\"q4\" src=\"" . $itemData["thumb"] . "\">\r\n                        </span>\r\n                        <div id=\"middle\"> \r\n                        <span style=\"color:" . $itemData["color"] . ";background-color:" . $itemData["anco"] . "; padding: 2px 2px 2px 2px;\">" . $itemData["name"] . " " . $level . "</span> | " . $price;
                    if (mconfig("hide_author")) {
                        echo "<p>" . sprintf(lang("market_txt_198", true), date($config["time_date_format"], strtotime($thisItem["start_date"]))) . "</p>";
                    } else {
                        echo "<p>" . sprintf(lang("market_txt_189", true), $thisItem["seller"], date($config["time_date_format"], strtotime($thisItem["start_date"]))) . "</p>";
                    }
                    echo "\r\n                        </div>\r\n                        <form name=\"item\" method=\"post\">\r\n                          <input type=\"hidden\" name=\"" . Encode("id") . "\" value=\"" . Encode($thisItem["id"]) . "\">\r\n                          <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">";
                    if ($_SESSION["username"] == $seller) {
                        echo "<input type=\"submit\" name=\"buyitem\" value=\"" . lang("market_txt_190", true) . "\" onclick=\"javascript:if(!confirm('" . lang("market_txt_200", true) . "')){ return false; }\"/ class=\"simple_button purchase_button\">";
                    } else {
                        echo "<input type=\"submit\" name=\"buyitem\" value=\"" . lang("market_txt_191", true) . "\" onclick=\"javascript:if(!confirm('" . lang("market_txt_199", true) . "')){ return false; }\"/ class=\"simple_button purchase_button\">";
                    }
                    echo "\r\n                        </form>\r\n                        <div class=\"clear\"></div>\r\n                      </li>";
                }
                echo "</ul>";
            } else {
                message("info", lang("market_txt_192", true));
            }
            echo "\r\n\r\n                  </div>\r\n                  <div style=\"width:831px;margin:15px 0 0 0;\">";
            $limit = mconfig("page");
            $total_items = $Market->getTotalMarketItems($name_filter, $category_filter);
            $total_pages = ceil($total_items / $limit);
            $i = 1;
            while ($i <= $total_pages) {
                if ($i == $page) {
                    echo "<div class=\"market_pagination_active\">" . $i . "</div>";
                } else {
                    $url = $_SERVER["REQUEST_URI"];
                    $filter = substr(strrchr($url, "/"), 1);
                    echo "<div class=\"market_pagination\"><a href=\"" . __BASE_URL__ . "usercp/market/page/" . $i . "/" . $filter . "\">" . $i . "</a></div>";
                }
                $i++;
            }
            echo "\r\n                  </div>\r\n                </div> \r\n              </div>\r\n            </div>\r\n            <div class=\"clear\"></div>\r\n          </div>\r\n        </form>\r\n      </div>";
        } else {
            message("error", lang("error_47", true));
        }
        echo "\r\n  </div>\r\n</div>";
    }
}

?>