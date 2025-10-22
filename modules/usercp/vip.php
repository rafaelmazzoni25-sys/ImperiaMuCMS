<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

if (!isLoggedIn()) {
    redirect(1, "login");
} else {
    if (!canAccessModule($_SESSION["username"], "vip", "block")) {
        return NULL;
    }
    if (config("server_files", true) != "IGCN") {
        redirect();
    }
    if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
        $breadcrumb = generateBreadcrumb();
        echo "\r\n    <h3>\r\n        " . lang("myaccount_txt_24", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
        if (mconfig("active")) {
            echo "\r\n    <div class=\"row desc-row\">\r\n        <div class=\"col-xs-12\">";
            if (0 < mconfig("bronze_exp") || 0 < mconfig("bronze_drop")) {
                echo lang("vip_txt_18", true) . " " . lang("vip_txt_35", true) . ": +" . mconfig("bronze_exp") . "% " . lang("vip_txt_22", true) . ", +" . mconfig("bronze_drop") . "% " . lang("vip_txt_23", true) . "<br>";
            }
            if (0 < mconfig("silver_exp") || 0 < mconfig("silver_drop")) {
                echo lang("vip_txt_19", true) . " " . lang("vip_txt_35", true) . ": +" . mconfig("silver_exp") . "% " . lang("vip_txt_22", true) . ", +" . mconfig("silver_drop") . "% " . lang("vip_txt_23", true) . "<br>";
            }
            if (0 < mconfig("gold_exp") || 0 < mconfig("gold_drop")) {
                echo lang("vip_txt_20", true) . " " . lang("vip_txt_35", true) . ": +" . mconfig("gold_exp") . "% " . lang("vip_txt_22", true) . ", +" . mconfig("gold_drop") . "% " . lang("vip_txt_23", true) . "<br>";
            }
            if (0 < mconfig("platinum_exp") || 0 < mconfig("platinum_drop")) {
                echo lang("vip_txt_21", true) . " " . lang("vip_txt_35", true) . ": +" . mconfig("platinum_exp") . "% " . lang("vip_txt_22", true) . ", +" . mconfig("platinum_drop") . "% " . lang("vip_txt_23", true) . "";
            }
            echo lang("vip_txt_34", true);
            echo "\r\n        </div>\r\n    </div>";
            if (check_value($_POST["buyvip"])) {
                if ($_SESSION["token"] == $_POST["token"]) {
                    $tmp = Encode("id");
                    $id = htmlspecialchars($_POST[$tmp]);
                    $Vip = new Vip();
                    if ($common->beginDbTrans($_SESSION["username"])) {
                        $Vip->buyVip($_SESSION["username"], $id);
                        $common->endDbTrans($_SESSION["username"]);
                    }
                } else {
                    message("notice", lang("global_module_13", true));
                }
            }
            if (config("SQL_USE_2_DB", true)) {
                $vipData = $dB2->query_fetch_single("SELECT * FROM T_VIPList WHERE AccountID = ?", [$_SESSION["username"]]);
            } else {
                $vipData = $dB->query_fetch_single("SELECT * FROM T_VIPList WHERE AccountID = ?", [$_SESSION["username"]]);
            }
            if (!is_array($vipData) || $vipData["Date"] == NULL || $vipData["Type"] == NULL) {
                $vipStatus = lang("vip_txt_39", true);
                $isActiveVip = false;
            } else {
                if (time() < strtotime($vipData["Date"])) {
                    switch ($vipData["Type"]) {
                        case "1":
                            $vipStatus = lang("vip_txt_18", true);
                            break;
                        case "2":
                            $vipStatus = lang("vip_txt_19", true);
                            break;
                        case "3":
                            $vipStatus = lang("vip_txt_20", true);
                            break;
                        case "4":
                            $vipStatus = lang("vip_txt_21", true);
                            break;
                        default:
                            $date = date($config["time_date_format"], strtotime($vipData["Date"]));
                            $vipStatus .= ", " . lang("vip_txt_24", true) . " " . $date;
                            $isActiveVip = true;
                    }
                } else {
                    $vipStatus = lang("vip_txt_25", true);
                    $isActiveVip = false;
                }
            }
            echo "\r\n    <div class=\"row desc-row\">\r\n        <div class=\"col-xs-12\">\r\n            " . lang("vip_txt_26", true) . " " . $vipStatus . " \r\n        </div>\r\n    </div>";
            $token = time();
            $_SESSION["token"] = $token;
            $vipPackages = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_VIP WHERE active = '1' ORDER BY price ASC");
            echo "\r\n    <div class=\"table-responsive rankings-table\">\r\n        <table class=\"table table-hover text-center\">\r\n            <thead>\r\n                <tr>\r\n                    <th>" . lang("vip_txt_6", true) . "</th>\r\n                    <th>" . lang("vip_txt_37", true) . "</th>\r\n                    <th>" . lang("vip_txt_38", true) . "</th>\r\n                    <th></th>\r\n                </tr>\r\n            </thead>\r\n            <tbody>";
            if (is_array($vipPackages)) {
                foreach ($vipPackages as $thisVip) {
                    if ($thisVip["hours"] != NULL) {
                        if ($thisVip["hours"] == "1") {
                            $length = $thisVip["hours"] . " " . lang("vip_txt_27", true);
                        } else {
                            $length = $thisVip["hours"] . " " . lang("vip_txt_28", true);
                        }
                    } else {
                        if ($thisVip["days"] == "1") {
                            $length = $thisVip["days"] . " " . lang("vip_txt_29", true);
                        } else {
                            $length = $thisVip["days"] . " " . lang("vip_txt_30", true);
                        }
                    }
                    if (!$isActiveVip) {
                        $btn = lang("vip_txt_36", true);
                    } else {
                        if ($vipData["Type"] != $thisVip["type"]) {
                            $btn = lang("vip_txt_31", true);
                            $disabled = "disabled=\"disabled\"";
                        } else {
                            $btn = lang("vip_txt_32", true);
                            $disabled = "";
                        }
                    }
                    if ($thisVip["currency"] == "1") {
                        $currency = lang("currency_platinum", true);
                    } else {
                        if ($thisVip["currency"] == "2") {
                            $currency = lang("currency_gold", true);
                        } else {
                            if ($thisVip["currency"] == "3") {
                                $currency = lang("currency_silver", true);
                            } else {
                                if ($thisVip["currency"] == "4") {
                                    $currency = lang("currency_wcoinc", true);
                                } else {
                                    if ($thisVip["currency"] == "5") {
                                        $currency = lang("currency_gp", true);
                                    } else {
                                        if ($thisVip["currency"] == "6") {
                                            $currency = "" . lang("currency_zen", true) . "";
                                        }
                                    }
                                }
                            }
                        }
                    }
                    echo "\r\n                <tr>\r\n                    <td>" . $thisVip["name"] . "</td>\r\n                    <td>" . $length . "</td>\r\n                    <td>" . $thisVip["price"] . " " . $currency . "</td>\r\n                    <td>\r\n                        <form name=\"vip\" method=\"post\">\r\n                            <input type=\"hidden\" name=\"" . Encode("id") . "\" value=\"" . Encode($thisVip["id"]) . "\">\r\n                            <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                            <input type=\"submit\" name=\"buyvip\" value=\"" . $btn . "\" class=\"btn btn-warning\" " . $disabled . ">\r\n                        </form>\r\n                    </td>\r\n                </tr>";
                }
            } else {
                message("info", lang("vip_txt_33", true));
            }
            echo "  \r\n            </tbody>\r\n        </table>\r\n    </div>";
        } else {
            message("error", lang("error_47", true));
        }
    } else {
        $cat11 = "";
        $cat12 = "";
        $cat13 = "";
        $cat14 = "";
        $cat21 = "";
        $cat22 = "";
        $cat23 = "";
        $cat24 = "";
        $cat31 = "";
        $cat32 = "";
        $cat33 = "";
        $cat34 = "";
        $cat41 = "";
        $cat42 = "";
        $cat43 = "";
        $cat44 = "";
        $cat51 = "";
        $cat52 = "";
        $cat53 = "";
        $cat54 = "";
        $cat61 = "";
        $cat62 = "";
        $cat63 = "";
        $cat64 = "";
        $main1 = "";
        $main2 = "";
        $main3 = "";
        $main4 = "";
        $main5 = "";
        $main6 = "";
        if (check_value($_GET["cat"])) {
            $cat = htmlspecialchars($_GET["cat"]);
            if (check_value($_GET["sub"])) {
                $sub = htmlspecialchars($_GET["sub"]);
            }
        }
        echo "\r\n    <div class=\"sub-page-title\">\r\n        <div id=\"title\">\r\n            <h1>";
        echo lang("module_titles_txt_3", true);
        echo "<p></p><span></span></h1>\r\n        </div>\r\n    </div>\r\n\r\n    <div class=\"container_2 account store\" align=\"center\">\r\n        <div class=\"cont-image\">\r\n            <div class=\"container_3 account_sub_header\">\r\n                <div class=\"grad\">\r\n                    <div class=\"page-title\">";
        echo lang("myaccount_txt_24", true);
        echo "</div>\r\n                    <a href=\"";
        echo __BASE_URL__;
        echo "usercp\">";
        echo lang("global_module_1", true);
        echo "</a>\r\n                </div>\r\n            </div>\r\n            <div class=\"page-desc-holder\">\r\n                ";
        if (0 < mconfig("bronze_exp") || 0 < mconfig("bronze_drop")) {
            echo "<font color=\"#CD7F32\">" . lang("vip_txt_18", true) . " " . lang("vip_txt_35", true) . "</font>: +" . mconfig("bronze_exp") . "% " . lang("vip_txt_22", true) . ", +" . mconfig("bronze_drop") . "% " . lang("vip_txt_23", true) . "<br>";
        }
        if (0 < mconfig("silver_exp") || 0 < mconfig("silver_drop")) {
            echo "<font color=\"#959595\">" . lang("vip_txt_19", true) . " " . lang("vip_txt_35", true) . "</font>: +" . mconfig("silver_exp") . "% " . lang("vip_txt_22", true) . ", +" . mconfig("silver_drop") . "% " . lang("vip_txt_23", true) . "<br>";
        }
        if (0 < mconfig("gold_exp") || 0 < mconfig("gold_drop")) {
            echo "<font color=\"#b38e47\">" . lang("vip_txt_20", true) . " " . lang("vip_txt_35", true) . "</font>: +" . mconfig("gold_exp") . "% " . lang("vip_txt_22", true) . ", +" . mconfig("gold_drop") . "% " . lang("vip_txt_23", true) . "<br>";
        }
        if (0 < mconfig("platinum_exp") || 0 < mconfig("platinum_drop")) {
            echo "<font color=\"#00ffa8\">" . lang("vip_txt_21", true) . " " . lang("vip_txt_35", true) . "</font>: +" . mconfig("platinum_exp") . "% " . lang("vip_txt_22", true) . ", +" . mconfig("platinum_drop") . "% " . lang("vip_txt_23", true) . "";
        }
        echo lang("vip_txt_34", true);
        echo "            </div>\r\n            <script type=\"text/javascript\">\r\n                \$(document).ready(function () {\r\n                    \$('#left_scrollbable').tinyscrollbar();\r\n                    \$('.store_items_list').tinyscrollbar();\r\n                    \$('.store_body').WarcryStore();\r\n                });\r\n            </script>\r\n\r\n            ";
        if (check_value($_POST["buyvip"])) {
            if ($_SESSION["token"] == $_POST["token"]) {
                $tmp = Encode("id");
                $id = htmlspecialchars($_POST[$tmp]);
                $Vip = new Vip();
                $Vip->buyVip($_SESSION["username"], $id);
            } else {
                message("notice", lang("global_module_13", true));
            }
        }
        if (config("SQL_USE_2_DB", true)) {
            $vipData = $dB2->query_fetch_single("SELECT * FROM T_VIPList WHERE AccountID = ?", [$_SESSION["username"]]);
        } else {
            $vipData = $dB->query_fetch_single("SELECT * FROM T_VIPList WHERE AccountID = ?", [$_SESSION["username"]]);
        }
        if (!is_array($vipData) || $vipData["Date"] == NULL || $vipData["Type"] == NULL) {
            $vipStatus = "none";
            $isActiveVip = false;
        } else {
            if (time() < strtotime($vipData["Date"])) {
                switch ($vipData["Type"]) {
                    case "1":
                        $vipStatus = "<font color=\"#cd7f32\">" . lang("vip_txt_18", true) . "</font>";
                        break;
                    case "2":
                        $vipStatus = "<font color=\"#959595\">" . lang("vip_txt_19", true) . "</font>";
                        break;
                    case "3":
                        $vipStatus = "<font color=\"#b38e47\">" . lang("vip_txt_20", true) . "</font>";
                        break;
                    case "4":
                        $vipStatus = "<font color=\"#00ffa8\">" . lang("vip_txt_21", true) . "</font>";
                        break;
                    default:
                        $date = date($config["time_date_format"], strtotime($vipData["Date"]));
                        $vipStatus .= ", " . lang("vip_txt_24", true) . " " . $date;
                        $isActiveVip = true;
                }
            } else {
                $vipStatus = lang("vip_txt_25", true);
                $isActiveVip = false;
            }
        }
        $token = time();
        $_SESSION["token"] = $token;
        echo "\r\n            <div class=\"store_body\" style=\"margin: 0 0 0 0;\">\r\n                <form id=\"store_form\" method=\"post\">\r\n                    <div class=\"store_header\" align=\"right\">\r\n                        <div style=\"padding-top: 10px; margin-right: 20px;\">";
        echo lang("vip_txt_26", true);
        echo "                            <b>";
        echo $vipStatus;
        echo "</b></div>\r\n                    </div>\r\n                    <div class=\"store_inner_body\">\r\n                        <div class=\"store_left_side\">\r\n                            <div class=\"scrollable\" id=\"left_scrollbable\">\r\n                                <div class=\"scrollbar disable\" style=\"height: 606px;\">\r\n                                    <div class=\"track\" style=\"height: 606px;\">\r\n                                        <div class=\"thumb\" style=\"top: 0px; height: 606px;\">\r\n                                            <div class=\"end\"></div>\r\n                                        </div>\r\n                                    </div>\r\n                                </div>\r\n                                <div class=\"viewport\">\r\n                                    <div class=\"overview\" id=\"store_categories\" style=\"top: 0px;\">\r\n\r\n                                        ";
        if (mconfig("active")) {
            $categories = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_VIP_CATEGORIES WHERE position > 0 ORDER BY position");
            $i = 1;
            foreach ($categories as $thisCat) {
                $main1 = "";
                $main11 = "";
                $display1 = "";
                $sub1 = "";
                $sub2 = "";
                $sub3 = "";
                $sub4 = "";
                if ($thisCat["currency"] == $cat) {
                    $main1 = "open_category";
                    $main11 = "active_category";
                    $display1 = "block";
                    if ($sub == "1") {
                        $sub1 = "active_category";
                    } else {
                        if ($sub == "2") {
                            $sub2 = "active_category";
                        } else {
                            if ($sub == "3") {
                                $sub3 = "active_category";
                            } else {
                                if ($sub == "4") {
                                    $sub4 = "active_category";
                                }
                            }
                        }
                    }
                } else {
                    $display1 = "none";
                }
                echo "\r\n                  <div class=\"store_category " . $main1 . "\" data-id=\"" . $i . "\">\r\n                    <a href=\"#\" class=\"store_category_button " . $main11 . "\">\r\n                      <span>" . $thisCat["name"] . "</span>\r\n                      <p id=\"arrow\"></p>\r\n                      <div class=\"clear\"></div>\r\n                    </a>\r\n                    <div class=\"store_sub_categories\" align=\"left\" style=\"display: " . $display1 . ";\">";
                if (0 < mconfig("bronze_exp") || 0 < mconfig("bronze_drop")) {
                    echo "\r\n                        <a href=\"" . __BASE_URL__ . "usercp/vip/cat/" . $thisCat["currency"] . "/?sub=1\" class=\"store_sub_category_button " . $sub1 . "\">\r\n                        <span>" . lang("vip_txt_18", true) . " " . lang("vip_txt_35", true) . "</span>\r\n                        </a>";
                }
                if (0 < mconfig("silver_exp") || 0 < mconfig("silver_drop")) {
                    echo "\r\n                        <a href=\"" . __BASE_URL__ . "usercp/vip/cat/" . $thisCat["currency"] . "/?sub=2\" class=\"store_sub_category_button " . $sub2 . "\">\r\n                        <span>" . lang("vip_txt_19", true) . " " . lang("vip_txt_35", true) . "</span>\r\n                        </a>";
                }
                if (0 < mconfig("gold_exp") || 0 < mconfig("gold_drop")) {
                    echo "\r\n                        <a href=\"" . __BASE_URL__ . "usercp/vip/cat/" . $thisCat["currency"] . "/?sub=3\" class=\"store_sub_category_button " . $sub3 . "\">\r\n                        <span>" . lang("vip_txt_20", true) . " " . lang("vip_txt_35", true) . "</span>\r\n                        </a>";
                }
                if (0 < mconfig("platinum_exp") || 0 < mconfig("platinum_drop")) {
                    echo "\r\n                        <a href=\"" . __BASE_URL__ . "usercp/vip/cat/" . $thisCat["currency"] . "/?sub=4\" class=\"store_sub_category_button " . $sub4 . "\">\r\n                        <span>" . lang("vip_txt_21", true) . " " . lang("vip_txt_35", true) . "</span>\r\n                        </a>";
                }
                echo "\r\n                    </div>\r\n                  </div>";
                $i++;
            }
            echo "\r\n                                    </div>\r\n                                </div>\r\n                            </div>\r\n                        </div>\r\n                        <div class=\"store_right_side\">\r\n                            <div class=\"store_items_list\">\r\n                                <div class=\"scrollbar disable\" style=\"height: 554px;\">\r\n                                    <div class=\"track\" style=\"height: 554px;\">\r\n                                        <div class=\"thumb\" style=\"top: 0px; height: 554px;\">\r\n                                            <div class=\"end\"></div>\r\n                                        </div>\r\n                                    </div>\r\n                                </div>\r\n                                <div class=\"viewport\">\r\n                                    <div class=\"overview\" style=\"top: 0px;\">\r\n\r\n                                        ";
            if (check_value($_GET["cat"])) {
                $cat = htmlspecialchars($_GET["cat"]);
                if (check_value($_GET["sub"])) {
                    $sub = htmlspecialchars($_GET["sub"]);
                    if ($cat == "1") {
                        $currency = lang("currency_platinum", true);
                        $color = "#00ffa8";
                    } else {
                        if ($cat == "2") {
                            $currency = lang("currency_gold", true);
                            $color = "#b38e47";
                        } else {
                            if ($cat == "3") {
                                $currency = lang("currency_silver", true);
                                $color = "#959595";
                            } else {
                                if ($cat == "4") {
                                    $currency = lang("currency_wcoinc", true);
                                    $color = "#ffffff";
                                } else {
                                    if ($cat == "5") {
                                        $currency = lang("currency_gp", true);
                                        $color = "#ffffff";
                                    } else {
                                        if ($cat == "6") {
                                            $currency = "" . lang("currency_zen", true) . "";
                                            $color = "#ffffff";
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $cat = xss_clean($cat);
                    $sub = xss_clean($sub);
                    $vipPackages = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_VIP WHERE currency = ? AND type = ? AND active = '1' ORDER BY price", [$cat, $sub]);
                    if (is_array($vipPackages)) {
                        echo "<ul class=\"items\">";
                        foreach ($vipPackages as $thisVip) {
                            if ($thisVip["hours"] != NULL) {
                                if ($thisVip["hours"] == "1") {
                                    $length = $thisVip["hours"] . " " . lang("vip_txt_27", true);
                                } else {
                                    $length = $thisVip["hours"] . " " . lang("vip_txt_28", true);
                                }
                            } else {
                                if ($thisVip["days"] == "1") {
                                    $length = $thisVip["days"] . " " . lang("vip_txt_29", true);
                                } else {
                                    $length = $thisVip["days"] . " " . lang("vip_txt_30", true);
                                }
                            }
                            if (!$isActiveVip) {
                                $btn = lang("vip_txt_36", true);
                            } else {
                                if ($vipData["Type"] != $sub) {
                                    $btn = lang("vip_txt_31", true);
                                    $disabled = "disabled=\"disabled\"";
                                } else {
                                    $btn = lang("vip_txt_32", true);
                                    $disabled = "";
                                }
                            }
                            echo "\r\n                      <li class=\"item\">\r\n                        <div id=\"hover\"></div>\r\n                        <div id=\"middle\">\r\n                          " . $thisVip["name"] . "\r\n                          <p>" . $length . " | <font color=\"" . $color . "\">" . $thisVip["price"] . "</font> " . $currency . "\r\n                          </p>\r\n                        </div>\r\n                        <form name=\"vip\" method=\"post\">\r\n                          <input type=\"hidden\" name=\"" . Encode("id") . "\" value=\"" . Encode($thisVip["id"]) . "\">\r\n                          <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                          <input type=\"submit\" name=\"buyvip\" value=\"" . $btn . "\" class=\"simple_button purchase_button\" " . $disabled . ">\r\n                        </form>\r\n                        <div class=\"clear\"></div>\r\n                      </li>";
                        }
                        echo "</ul>";
                    } else {
                        message("info", lang("vip_txt_33", true));
                    }
                }
            }
            echo "\r\n                                    </div>\r\n                                </div>\r\n                            </div>\r\n                        </div>\r\n\r\n                        ";
        }
        echo "\r\n                        <div class=\"clear\"></div>\r\n                    </div>\r\n                </form>\r\n            </div>\r\n        </div>\r\n    </div>\r\n    ";
    }
}

?>