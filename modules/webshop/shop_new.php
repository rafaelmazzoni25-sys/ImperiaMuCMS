<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

if (!isLoggedIn()) {
    redirect(1, "login");
} else {
    loadModuleConfigs("webshop_new");
    canAccessModule($_SESSION["username"], "webshop", "block");
    if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
        $breadcrumb = generateBreadcrumb();
        echo "\n    <h3>\n        " . lang("module_titles_txt_3", true) . "\n        " . $breadcrumb . "\n    </h3>";
        if (mconfig("active")) {
            echo "\n    <div class=\"row webshop\">\n        <div class=\"col-xs-12 col-sm-3 col-md-2\">\n            <ul class=\"nav nav-pills nav-stacked\">\n                <li role=\"presentation\"><a href=\"" . __BASE_URL__ . "webshop/shop_new/\">" . lang("webshop_18", true) . "</a></li>\n                <li role=\"presentation\"><a href=\"" . __BASE_URL__ . "webshop/shop_new/history/\">" . lang("webshop_19", true) . "</a></li>\n                <li role=\"presentation\"><a href=\"" . __BASE_URL__ . "usercp/items/\">" . lang("myaccount_txt_67", true) . "</a></li>\n                <li role=\"presentation\"><a href=\"" . __BASE_URL__ . "donation/\">" . lang("webshop_20", true) . "</a></li>\n                <li role=\"presentation\"><a href=\"" . __BASE_URL__ . "ticket/new/\">" . lang("webshop_21", true) . "</a></li>\n            </ul>\n        </div>";
            if (check_value($_GET["class"])) {
                $classReq = [];
                if ($_GET["class"] == "wizard") {
                    $classReq = [1 => $custom["character_class"][0], 2 => $custom["character_class"][1], 3 => $custom["character_class"][2], 4 => $custom["character_class"][7]];
                } else {
                    if ($_GET["class"] == "knight") {
                        $classReq = [1 => $custom["character_class"][16], 2 => $custom["character_class"][17], 3 => $custom["character_class"][18], 4 => $custom["character_class"][23]];
                    } else {
                        if ($_GET["class"] == "elf") {
                            $classReq = [1 => $custom["character_class"][32], 2 => $custom["character_class"][33], 3 => $custom["character_class"][34], 4 => $custom["character_class"][39]];
                        } else {
                            if ($_GET["class"] == "summoner") {
                                $classReq = [1 => $custom["character_class"][80], 2 => $custom["character_class"][81], 3 => $custom["character_class"][82], 4 => $custom["character_class"][87]];
                            } else {
                                if ($_GET["class"] == "gladiator") {
                                    $classReq = [1 => $custom["character_class"][48], 3 => $custom["character_class"][50], 4 => $custom["character_class"][54]];
                                } else {
                                    if ($_GET["class"] == "lord") {
                                        $classReq = [1 => $custom["character_class"][64], 3 => $custom["character_class"][66], 4 => $custom["character_class"][70]];
                                    } else {
                                        if ($_GET["class"] == "fighter") {
                                            $classReq = [1 => $custom["character_class"][96], 3 => $custom["character_class"][98], 4 => $custom["character_class"][102]];
                                        } else {
                                            if ($_GET["class"] == "lancer") {
                                                $classReq = [1 => $custom["character_class"][112], 3 => $custom["character_class"][114], 4 => $custom["character_class"][118]];
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                echo "\n        <div class=\"col-xs-12 col-sm-9 col-md-10\">";
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
                    echo "\n            <div class=\"row\">\n                <div class=\"col-xs-12 webshop-right webshop-options\">\n                \n                </div>\n            </div>";
                } else {
                    echo "\n            <div class=\"row\">\n                <div class=\"col-xs-12 webshop-right webshop-options\">\n                    <form method=\"get\" action=\"" . __BASE_URL__ . "webshop/shop_new/class/" . $_GET["class"] . "/\">\n                        <div style=\"display: inline\">\n                            <div class=\"col-xs-12 webshop-right webshop-options\">\n                                " . lang("webshop_28", true) . ":&nbsp;\n                                <span class=\"webshop-hover\" onclick=\"\$('#webshop-list').show(); \$('#webshop-grid').hide();\"><i class=\"fa fa-th-list\"></i></span>\n                                <span class=\"webshop-hover webshop-space\" onclick=\"\$('#webshop-list').hide(); \$('#webshop-grid').show();\"><i class=\"fa fa-th-large\"></i></span>\n                                \n                                " . lang("webshop_51", true) . ":\n                                <select id=\"webshop-curr\" name=\"curr\" class=\"form-control webshop-curr webshop-space\" onchange=\"document.getElementById('submit-filter').click();\">";
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
                        if (check_value($_GET["curr"]) && $_GET["curr"] == "4" || !check_value($_GET["curr"]) && mconfig("default_currency") == "4") {
                            echo "<option value=\"4\" selected=\"selected\">" . lang("currency_wcoinc", true) . "</option>";
                        } else {
                            echo "<option value=\"4\">" . lang("currency_wcoinc", true) . "</option>";
                        }
                    }
                    if ($showGP) {
                        if (check_value($_GET["curr"]) && $_GET["curr"] == "5" || !check_value($_GET["curr"]) && mconfig("default_currency") == "5") {
                            echo "<option value=\"5\" selected=\"selected\">" . lang("currency_gp", true) . "</option>";
                        } else {
                            echo "<option value=\"5\">" . lang("currency_gp", true) . "</option>";
                        }
                    }
                    echo "\n                                </select>\n                                \n                                " . lang("webshop_22", true) . ":&nbsp;\n                                <select id=\"webshop-sort\" name=\"sort\" class=\"form-control webshop-sort webshop-space\" onchange=\"document.getElementById('submit-filter').click();\">";
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
                    echo "\n                                </select>";
                    echo "\n                                " . lang("webshop_30", true) . ":&nbsp;\n                                <select id=\"webshop-category\" name=\"category\" class=\"form-control webshop-category\" onchange=\"document.getElementById('submit-filter').click();\">";
                    if (!check_value($_GET["category"]) || $_GET["category"] == NULL || $_GET["category"] == "" || $_GET["category"] == "all") {
                        echo "<option value=\"all\" selected=\"selected\">" . lang("webshop_50", true) . "</option>";
                    } else {
                        echo "<option value=\"all\">" . lang("webshop_50", true) . "</option>";
                    }
                    if (check_value($_GET["category"]) && $_GET["category"] == "0") {
                        echo "<option value=\"0\" selected=\"selected\">" . lang("webshop_31", true) . "</option>";
                    } else {
                        echo "<option value=\"0\">" . lang("webshop_31", true) . "</option>";
                    }
                    if (check_value($_GET["category"]) && $_GET["category"] == "1") {
                        echo "<option value=\"1\" selected=\"selected\">" . lang("webshop_32", true) . "</option>";
                    } else {
                        echo "<option value=\"1\">" . lang("webshop_32", true) . "</option>";
                    }
                    if (check_value($_GET["category"]) && $_GET["category"] == "2") {
                        echo "<option value=\"2\" selected=\"selected\">" . lang("webshop_33", true) . "</option>";
                    } else {
                        echo "<option value=\"2\">" . lang("webshop_33", true) . "</option>";
                    }
                    if (check_value($_GET["category"]) && $_GET["category"] == "3") {
                        echo "<option value=\"3\" selected=\"selected\">" . lang("webshop_34", true) . "</option>";
                    } else {
                        echo "<option value=\"3\">" . lang("webshop_34", true) . "</option>";
                    }
                    if (check_value($_GET["category"]) && $_GET["category"] == "4") {
                        echo "<option value=\"4\" selected=\"selected\">" . lang("webshop_35", true) . "</option>";
                    } else {
                        echo "<option value=\"4\">" . lang("webshop_35", true) . "</option>";
                    }
                    if (check_value($_GET["category"]) && $_GET["category"] == "5") {
                        echo "<option value=\"5\" selected=\"selected\">" . lang("webshop_36", true) . "</option>";
                    } else {
                        echo "<option value=\"5\">" . lang("webshop_36", true) . "</option>";
                    }
                    if (check_value($_GET["category"]) && $_GET["category"] == "6") {
                        echo "<option value=\"6\" selected=\"selected\">" . lang("webshop_37", true) . "</option>";
                    } else {
                        echo "<option value=\"6\">" . lang("webshop_37", true) . "</option>";
                    }
                    if (check_value($_GET["category"]) && $_GET["category"] == "7") {
                        echo "<option value=\"7\" selected=\"selected\">" . lang("webshop_38", true) . "</option>";
                    } else {
                        echo "<option value=\"7\">" . lang("webshop_38", true) . "</option>";
                    }
                    if (check_value($_GET["category"]) && $_GET["category"] == "8") {
                        echo "<option value=\"8\" selected=\"selected\">" . lang("webshop_39", true) . "</option>";
                    } else {
                        echo "<option value=\"8\">" . lang("webshop_39", true) . "</option>";
                    }
                    if (check_value($_GET["category"]) && $_GET["category"] == "9") {
                        echo "<option value=\"9\" selected=\"selected\">" . lang("webshop_40", true) . "</option>";
                    } else {
                        echo "<option value=\"9\">" . lang("webshop_40", true) . "</option>";
                    }
                    if (check_value($_GET["category"]) && $_GET["category"] == "10") {
                        echo "<option value=\"10\" selected=\"selected\">" . lang("webshop_41", true) . "</option>";
                    } else {
                        echo "<option value=\"10\">" . lang("webshop_41", true) . "</option>";
                    }
                    if (check_value($_GET["category"]) && $_GET["category"] == "11") {
                        echo "<option value=\"11\" selected=\"selected\">" . lang("webshop_42", true) . "</option>";
                    } else {
                        echo "<option value=\"11\">" . lang("webshop_42", true) . "</option>";
                    }
                    echo "\n                                </select>\n                                <input id=\"submit-filter\" type=\"submit\" class=\"hidden\" />\n                            </div>\n                        </div>\n                    </form>\n                </div>\n            </div>";
                    $Webshop = new Webshop();
                    $webshopItems = $Webshop->loadWebshopItems($_GET["class"], $_GET["category"], $_GET["subcategory"], $_GET["sort"]);
                    if (is_array($webshopItems)) {
                        echo "\n            <div id=\"webshop-list\" style=\"display: none;\">\n                <table class=\"table table-hover text-center webshop-table\">\n                    <thead>\n                        <tr>\n                            <th>" . lang("webshop_52", true) . "</th>\n                            <th>" . lang("webshop_53", true) . "</th>\n                            <th>" . lang("webshop_54", true) . "</th>\n                            <th>" . lang("webshop_55", true) . "</th>\n                        </tr>\n                    </thead>\n                    <tbody>";
                        foreach ($webshopItems as $thisItem) {
                            $image = $Webshop->returnImage($thisItem);
                            echo "\n                        <tr>\n                            <td>" . $thisItem["name"] . "</td>\n                            <td>" . $classReq[$thisItem["classReq"]][0] . "</td>\n                            <td>";
                            if ($showPlatinum) {
                                echo "<span class=\"price_platinum\" style=\"display: none;\">" . number_format(floor($thisItem["price"] * mconfig("ratio_platinum"))) . " " . lang("currency_platinum", true) . "</span>";
                            }
                            if ($showGold) {
                                echo "<span class=\"price_gold\" style=\"display: none;\">" . number_format(floor($thisItem["price"] * mconfig("ratio_gold"))) . " " . lang("currency_gold", true) . "</span>";
                            }
                            if ($showSilver) {
                                echo "<span class=\"price_silver\" style=\"display: none;\">" . number_format(floor($thisItem["price"] * mconfig("ratio_silver"))) . " " . lang("currency_silver", true) . "</span>";
                            }
                            if ($showWcoin) {
                                echo "<span class=\"price_wcoin\" style=\"display: none;\">" . number_format(floor($thisItem["price"] * mconfig("ratio_wcoin"))) . " " . lang("currency_wcoinc", true) . "</span>";
                            }
                            if ($showGP) {
                                echo "<span class=\"price_gp\" style=\"display: none;\">" . number_format(floor($thisItem["price"] * mconfig("ratio_gp"))) . " " . lang("currency_gp", true) . "</span>";
                            }
                            echo "\n                            </td>\n                            <td>\n                                <a href=\"" . __BASE_URL__ . "webshop/shop_new/class/" . $_GET["class"] . "/?customise=" . $thisItem["id"] . "&returl=" . __BASE_URL__ . "webshop/shop_new/class/" . $_GET["class"] . "/" . basename($_SERVER["REQUEST_URI"]) . "\">\n                                    <button class=\"btn btn-warning\">" . lang("webshop_56", true) . "</button>\n                                </a>\n                            </td>\n                        </tr>";
                        }
                        echo "\n                    </tbody>\n                </table>\n            </div>\n            <div id=\"webshop-grid\">";
                        foreach ($webshopItems as $thisItem) {
                            $image = $Webshop->returnImage($thisItem);
                            echo "\n                <a href=\"" . __BASE_URL__ . "webshop/shop_new/class/" . $_GET["class"] . "/?customise=" . $thisItem["id"] . "&returl=" . __BASE_URL__ . "webshop/shop_new/class/" . $_GET["class"] . "/" . basename($_SERVER["REQUEST_URI"]) . "\">\n                    <div class=\"col-xs-12 col-sm-6 col-md-4 col-lg-3 class-category\">\n                        <div class=\"webshop-item\">\n                            <div class=\"webshop-item-title\">" . $thisItem["name"] . "</div>\n                            <div class=\"webshop-item-img\">\n                                <span class=\"webshop-item-img-helper\"></span>\n                                <img src=\"" . $image . "\" alt=\"" . $thisItem["name"] . "\">\n                            </div>\n                            <div class=\"webshop-item-desc\">";
                            if ($showPlatinum) {
                                echo "<span class=\"price_platinum\" style=\"display: none;\">" . number_format(floor($thisItem["price"] * mconfig("ratio_platinum"))) . " " . lang("currency_platinum", true) . "</span>";
                            }
                            if ($showGold) {
                                echo "<span class=\"price_gold\" style=\"display: none;\">" . number_format(floor($thisItem["price"] * mconfig("ratio_gold"))) . " " . lang("currency_gold", true) . "</span>";
                            }
                            if ($showSilver) {
                                echo "<span class=\"price_silver\" style=\"display: none;\">" . number_format(floor($thisItem["price"] * mconfig("ratio_silver"))) . " " . lang("currency_silver", true) . "</span>";
                            }
                            if ($showWcoin) {
                                echo "<span class=\"price_wcoin\" style=\"display: none;\">" . number_format(floor($thisItem["price"] * mconfig("ratio_wcoin"))) . " " . lang("currency_wcoinc", true) . "</span>";
                            }
                            if ($showGP) {
                                echo "<span class=\"price_gp\" style=\"display: none;\">" . number_format(floor($thisItem["price"] * mconfig("ratio_gp"))) . " " . lang("currency_gp", true) . "</span>";
                            }
                            echo "\n                                <br>\n                                " . sprintf(lang("item_detail_txt_6", true), $classReq[$thisItem["classReq"]][0]) . "\n                            </div>\n                        </div>\n                    </div>\n                </a>";
                        }
                        echo "\n            </div>";
                    } else {
                        message("warning", "No items.");
                    }
                }
                echo "\n        </div>\n        <script type=\"text/javascript\">\n            \$(document).ready(function() {\n                var currFilter = \$(\"#webshop-curr\").val();\n                if (currFilter == \"1\") {\n                    \$(\".price_platinum\").show();\n                    \$(\".price_gold\").hide();\n                    \$(\".price_silver\").hide();\n                    \$(\".price_wcoin\").hide();\n                    \$(\".price_gp\").hide();\n                } else if (currFilter == \"2\") {\n                    \$(\".price_platinum\").hide();\n                    \$(\".price_gold\").show();\n                    \$(\".price_silver\").hide();\n                    \$(\".price_wcoin\").hide();\n                    \$(\".price_gp\").hide();\n                } else if (currFilter == \"3\") {\n                    \$(\".price_platinum\").hide();\n                    \$(\".price_gold\").hide();\n                    \$(\".price_silver\").show();\n                    \$(\".price_wcoin\").hide();\n                    \$(\".price_gp\").hide();\n                } else if (currFilter == \"4\") {\n                    \$(\".price_platinum\").hide();\n                    \$(\".price_gold\").hide();\n                    \$(\".price_silver\").hide();\n                    \$(\".price_wcoin\").show();\n                    \$(\".price_gp\").hide();\n                } else if (currFilter == \"5\") {\n                    \$(\".price_platinum\").hide();\n                    \$(\".price_gold\").hide();\n                    \$(\".price_silver\").hide();\n                    \$(\".price_wcoin\").hide();\n                    \$(\".price_gp\").show();\n                }\n            });\n        </script>";
            } else {
                echo "\n        <div class=\"col-xs-12 col-sm-9 col-md-10\">\n            <div class=\"row\">\n                <div class=\"col-xs-12 sale-holder\">";
                message("error", "HOT SALE NOW AVAILABLE!");
                message("success", "HOT SALE NOW AVAILABLE!");
                message("warning", "HOT SALE NOW AVAILABLE!");
                message("info", "HOT SALE NOW AVAILABLE!");
                message("notice", "HOT SALE NOW AVAILABLE!");
                echo "\n                </div>\n                <div class=\"col-xs-12 desc-holder\">\n                    " . lang("webshop_17", true) . "\n                </div>\n            </div>\n            <a href=\"" . __BASE_URL__ . "webshop/shop_new/class/wizard/\">\n                <div class=\"col-xs-12 col-sm-6 col-md-4 col-lg-3 class-category\">\n                    <div class=\"thumbnail class-category-item\">\n                        <img src=\"" . __PATH_TEMPLATE__ . "images/character-avatars/dw.jpg\" alt=\"\">\n                        <div class=\"caption\">\n                            <h3>" . lang("webshop_1", true) . "</h3>\n                            <p>" . lang("webshop_9", true) . "</p>\n                        </div>\n                    </div>\n                </div>\n            </a>\n            <a href=\"" . __BASE_URL__ . "webshop/shop_new/class/knight/\">\n                <div class=\"col-xs-12 col-sm-6 col-md-4 col-lg-3 class-category\">\n                    <div class=\"thumbnail class-category-item\">\n                        <img src=\"" . __PATH_TEMPLATE__ . "images/character-avatars/dk.jpg\" alt=\"\">\n                        <div class=\"caption\">\n                            <h3>" . lang("webshop_2", true) . "</h3>\n                            <p>" . lang("webshop_10", true) . "</p>\n                        </div>\n                    </div>\n                </div>\n            </a>\n            <a href=\"" . __BASE_URL__ . "webshop/shop_new/class/elf/\">\n                <div class=\"col-xs-12 col-sm-6 col-md-4 col-lg-3 class-category\">\n                    <div class=\"thumbnail class-category-item\">\n                        <img src=\"" . __PATH_TEMPLATE__ . "images/character-avatars/elf.jpg\" alt=\"\">\n                        <div class=\"caption\">\n                            <h3>" . lang("webshop_3", true) . "</h3>\n                            <p>" . lang("webshop_11", true) . "</p>\n                        </div>\n                    </div>\n                </div>\n            </a>\n            <a href=\"" . __BASE_URL__ . "webshop/shop_new/class/summoner/\">\n                <div class=\"col-xs-12 col-sm-6 col-md-4 col-lg-3 class-category\">\n                    <div class=\"thumbnail class-category-item\">\n                        <img src=\"" . __PATH_TEMPLATE__ . "images/character-avatars/sum.jpg\" alt=\"\">\n                        <div class=\"caption\">\n                            <h3>" . lang("webshop_4", true) . "</h3>\n                            <p>" . lang("webshop_12", true) . "</p>\n                        </div>\n                    </div>\n                </div>\n            </a>\n            <a href=\"" . __BASE_URL__ . "webshop/shop_new/class/gladiator/\">\n                <div class=\"col-xs-12 col-sm-6 col-md-4 col-lg-3 class-category\">\n                    <div class=\"thumbnail class-category-item\">\n                        <img src=\"" . __PATH_TEMPLATE__ . "images/character-avatars/mg.jpg\" alt=\"\">\n                        <div class=\"caption\">\n                            <h3>" . lang("webshop_5", true) . "</h3>\n                            <p>" . lang("webshop_13", true) . "</p>\n                        </div>\n                    </div>\n                </div>\n            </a>\n            <a href=\"" . __BASE_URL__ . "webshop/shop_new/class/lord/\">\n                <div class=\"col-xs-12 col-sm-6 col-md-4 col-lg-3 class-category\">\n                    <div class=\"thumbnail class-category-item\">\n                        <img src=\"" . __PATH_TEMPLATE__ . "images/character-avatars/dl.jpg\" alt=\"\">\n                        <div class=\"caption\">\n                            <h3>" . lang("webshop_6", true) . "</h3>\n                            <p>" . lang("webshop_14", true) . "</p>\n                        </div>\n                    </div>\n                </div>\n            </a>\n            <a href=\"" . __BASE_URL__ . "webshop/shop_new/class/fighter/\">\n                <div class=\"col-xs-12 col-sm-6 col-md-4 col-lg-3 class-category\">\n                    <div class=\"thumbnail class-category-item\">\n                        <img src=\"" . __PATH_TEMPLATE__ . "images/character-avatars/rf.jpg\" alt=\"\">\n                        <div class=\"caption\">\n                            <h3>" . lang("webshop_7", true) . "</h3>\n                            <p>" . lang("webshop_15", true) . "</p>\n                        </div>\n                    </div>\n                </div>\n            </a>";
                if (100 <= config("server_files_season", true)) {
                    echo "\n            <a href=\"" . __BASE_URL__ . "webshop/shop_new/class/lancer/\">\n                <div class=\"col-xs-12 col-sm-6 col-md-4 col-lg-3 class-category\">\n                    <div class=\"thumbnail class-category-item\">\n                        <img src=\"" . __PATH_TEMPLATE__ . "images/character-avatars/gl.jpg\" alt=\"\">\n                        <div class=\"caption\">\n                            <h3>" . lang("webshop_8", true) . "</h3>\n                            <p>" . lang("webshop_16", true) . "</p>\n                        </div>\n                    </div>\n                </div>\n            </a>";
                }
                echo "\n        </div>";
            }
            echo "\n    </div>";
        } else {
            message("error", lang("error_47", true));
        }
    }
}

?>