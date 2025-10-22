<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

if (!isLoggedIn()) {
    redirect(1, "login");
} else {
    loadModuleConfigs("webshop");
    if (!canAccessModule($_SESSION["username"], "webshop", "block")) {
        return NULL;
    }
    echo "<script type=\"text/javascript\" SRC=\"" . __PATH_TEMPLATE__ . "js/tooltip.js\"></script>\r\n<style>\r\n.js-select {\r\n    width: 400px;\r\n}\r\n.js-select .js-select-selected {\r\n    width: 90%;\r\n}\r\n</style>";
    echo "\r\n<div class=\"sub-page-title\">\r\n  <div id=\"title\"><h1>" . lang("module_titles_txt_3", true) . "<p></p><span></span></h1></div>\r\n</div>";
    if (mconfig("active")) {
        $General = new xGeneral();
        $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("webshop");
        $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("webshop");
        $is_global = mconfig("is_global_active");
        $max_exc_opt = mconfig("max_exc_opt");
        $max_socket = mconfig("max_socket");
        $max_lvl = mconfig("max_lvl");
        $max_life_opt = mconfig("max_life_opt");
        $payment_type = mconfig("payment_type");
        $is_harmony = mconfig("is_harmony");
        $is_socket = mconfig("is_socket");
        $is_refinery = mconfig("is_refinery");
        $is_anc = mconfig("is_anc");
        $cat0 = "";
        $cat1 = "";
        $cat2 = "";
        $cat3 = "";
        $cat4 = "";
        $cat5 = "";
        $cat6 = "";
        $cat7 = "";
        $cat8 = "";
        $cat9 = "";
        $cat10 = "";
        $cat11 = "";
        $cat12 = "";
        $cat13 = "";
        $cat14 = "";
        $cat15 = "";
        $cat16 = "";
        $cat17 = "";
        $cat18 = "";
        $cat19 = "";
        $cat20 = "";
        $cat21 = "";
        $cat22 = "";
        $cat23 = "";
        $cat24 = "";
        $cat25 = "";
        $cat26 = "";
        $cat27 = "";
        $cat28 = "";
        $cat29 = "";
        $cat30 = "";
        $cat31 = "";
        $cat32 = "";
        $cat33 = "";
        $all1 = "";
        $all2 = "";
        $all3 = "";
        $all4 = "";
        $all5 = "";
        $all6 = "";
        $all7 = "";
        $main1 = "";
        $main2 = "";
        $main3 = "";
        $main4 = "";
        $main5 = "";
        $main6 = "";
        $main7 = "";
        if (check_value($_GET["cat"])) {
            $cat = htmlspecialchars($_GET["cat"]);
            if ($cat == "1") {
                $main1 = "open_category";
                $main11 = "active_category";
                $display1 = "block";
            } else {
                $display1 = "none";
            }
            if ($cat == "2") {
                $main2 = "open_category";
                $main22 = "active_category";
                $display2 = "block";
            } else {
                $display2 = "none";
            }
            if ($cat == "3") {
                $main3 = "open_category";
                $main33 = "active_category";
                $display3 = "block";
            } else {
                $display3 = "none";
            }
            if ($cat == "4") {
                $main4 = "open_category";
                $main44 = "active_category";
                $display4 = "block";
            } else {
                $display4 = "none";
            }
            if ($cat == "5") {
                $main5 = "open_category";
                $main55 = "active_category";
                $display5 = "block";
            } else {
                $display5 = "none";
            }
            if ($cat == "6") {
                $main6 = "open_category";
                $main66 = "active_category";
                $display6 = "block";
            } else {
                $display6 = "none";
            }
            if ($cat == "7") {
                $main7 = "open_category";
                $main77 = "active_category";
                $display7 = "block";
            } else {
                $display7 = "none";
            }
        }
        if (check_value($_GET["sub"])) {
            if ($_GET["sub"] == "0") {
                $cat0 = "active_category";
            }
            if ($_GET["sub"] == "1") {
                $cat1 = "active_category";
            }
            if ($_GET["sub"] == "2") {
                $cat2 = "active_category";
            }
            if ($_GET["sub"] == "3") {
                $cat3 = "active_category";
            }
            if ($_GET["sub"] == "4") {
                $cat4 = "active_category";
            }
            if ($_GET["sub"] == "5") {
                $cat5 = "active_category";
            }
            if ($_GET["sub"] == "6") {
                $cat6 = "active_category";
            }
            if ($_GET["sub"] == "7") {
                $cat7 = "active_category";
            }
            if ($_GET["sub"] == "8") {
                $cat8 = "active_category";
            }
            if ($_GET["sub"] == "9") {
                $cat9 = "active_category";
            }
            if ($_GET["sub"] == "10") {
                $cat10 = "active_category";
            }
            if ($_GET["sub"] == "11") {
                $cat11 = "active_category";
            }
            if ($_GET["sub"] == "12") {
                $cat12 = "active_category";
            }
            if ($_GET["sub"] == "13") {
                $cat13 = "active_category";
            }
            if ($_GET["sub"] == "14") {
                $cat14 = "active_category";
            }
            if ($_GET["sub"] == "15") {
                $cat15 = "active_category";
            }
            if ($_GET["sub"] == "16") {
                $cat16 = "active_category";
            }
            if ($_GET["sub"] == "17") {
                $cat17 = "active_category";
            }
            if ($_GET["sub"] == "18") {
                $cat18 = "active_category";
            }
            if ($_GET["sub"] == "19") {
                $cat19 = "active_category";
            }
            if ($_GET["sub"] == "20") {
                $cat20 = "active_category";
            }
            if ($_GET["sub"] == "21") {
                $cat21 = "active_category";
            }
            if ($_GET["sub"] == "22") {
                $cat22 = "active_category";
            }
            if ($_GET["sub"] == "23") {
                $cat23 = "active_category";
            }
            if ($_GET["sub"] == "24") {
                $cat24 = "active_category";
            }
            if ($_GET["sub"] == "25") {
                $cat25 = "active_category";
            }
            if ($_GET["sub"] == "26") {
                $cat26 = "active_category";
            }
            if ($_GET["sub"] == "27") {
                $cat27 = "active_category";
            }
            if ($_GET["sub"] == "28") {
                $cat28 = "active_category";
            }
            if ($_GET["sub"] == "29") {
                $cat29 = "active_category";
            }
            if ($_GET["sub"] == "30") {
                $cat30 = "active_category";
            }
            if ($_GET["sub"] == "31") {
                $cat31 = "active_category";
            }
            if ($_GET["sub"] == "32") {
                $cat32 = "active_category";
            }
            if ($_GET["sub"] == "33") {
                $cat33 = "active_category";
            }
            if ($_GET["sub"] == "all" && $_GET["cat"] == "1") {
                $all1 = "active_category";
            }
            if ($_GET["sub"] == "all" && $_GET["cat"] == "2") {
                $all2 = "active_category";
            }
            if ($_GET["sub"] == "all" && $_GET["cat"] == "3") {
                $all3 = "active_category";
            }
            if ($_GET["sub"] == "all" && $_GET["cat"] == "4") {
                $all4 = "active_category";
            }
            if ($_GET["sub"] == "all" && $_GET["cat"] == "5") {
                $all5 = "active_category";
            }
            if ($_GET["sub"] == "all" && $_GET["cat"] == "6") {
                $all6 = "active_category";
            }
            if ($_GET["sub"] == "all" && $_GET["cat"] == "7") {
                $all7 = "active_category";
            }
        }
        echo "\r\n    <div class=\"container_2 account store\" align=\"center\">\r\n        <div class=\"cont-image\">\r\n            <div class=\"container_3 account_sub_header\">\r\n                <div class=\"grad\">\r\n                    <div class=\"page-title\">";
        echo lang("myaccount_txt_26", true);
        echo "</div>\r\n                    <div class=\"sub-active-page\">";
        echo lang("itemsinv_txt_2", true);
        echo "</div>\r\n                    <a href=\"";
        echo __BASE_URL__;
        echo "usercp/items\" style=\"background-image: none;padding: 9px 12px 10px 10px\">";
        echo lang("itemsinv_txt_1", true);
        echo "</a>\r\n                    <a href=\"";
        echo __BASE_URL__;
        echo "usercp\">";
        echo lang("global_module_1", true);
        echo "</a>\r\n                </div>\r\n            </div>\r\n            <script type=\"text/javascript\">\r\n                \$(document).ready(function () {\r\n                    \$('#left_scrollbable').tinyscrollbar();\r\n                    \$('.store_items_list').tinyscrollbar();\r\n                    \$('.store_body').WarcryStore();\r\n                });\r\n            </script>\r\n            <div class=\"store_body\">\r\n                <form id=\"store_form\" method=\"post\">\r\n                    <div class=\"store_header\" align=\"left\"></div>\r\n                    <div class=\"store_inner_body\">\r\n                        <div class=\"store_left_side\">\r\n                            <div class=\"scrollable\" id=\"left_scrollbable\">\r\n                                <div class=\"scrollbar disable\" style=\"height: 606px;\">\r\n                                    <div class=\"track\" style=\"height: 606px;\">\r\n                                        <div class=\"thumb\" style=\"top: 0px; height: 606px;\">\r\n                                            <div class=\"end\"></div>\r\n                                        </div>\r\n                                    </div>\r\n                                </div>\r\n                                <div class=\"viewport\">\r\n                                    <div class=\"overview\" id=\"store_categories\" style=\"top: 0px;\">\r\n\r\n                                        ";
        $specialShow = $dB->query_fetch_single("SELECT COUNT(*) as count FROM IMPERIAMUCMS_WEBSHOP WHERE price > 0 AND main_cat = 1");
        $specialShow2 = $dB->query_fetch_single("SELECT COUNT(*) as count FROM IMPERIAMUCMS_WEBSHOP_MYSTERY WHERE price > 0 AND status = 1");
        $specialShow3 = $dB->query_fetch_single("SELECT COUNT(*) as count FROM IMPERIAMUCMS_WEBSHOP_PACKAGES WHERE price > 0 AND status = 1");
        $specialCount = $specialShow["count"] + $specialShow2["count"] + $specialShow3["count"];
        if (0 < $specialCount) {
            echo "\r\n                                            <div class=\"store_category ";
            echo $main1;
            echo "\" data-id=\"2\">\r\n                                                <a href=\"#\" class=\"store_category_button ";
            echo $main11;
            echo "\">\r\n                                                    <span>";
            echo lang("webshop_txt_8", true);
            echo "</span>\r\n                                                    <p id=\"arrow\"></p>\r\n                                                    <div class=\"clear\"></div>\r\n                                                </a>\r\n\r\n                                                <div class=\"store_sub_categories\" align=\"left\"\r\n                                                     style=\"display: ";
            echo $display1;
            echo ";\">\r\n                                                    <a href=\"";
            echo __BASE_URL__;
            echo "webshop/shop/cat/1/?sub=all\"\r\n                                                       class=\"store_sub_category_button ";
            echo $all1;
            echo "\">\r\n                                                        <span>";
            echo lang("webshop_txt_9", true);
            echo "</span>\r\n                                                    </a>\r\n                                                    ";
            $specialShow = $dB->query_fetch_single("SELECT COUNT(*) as count FROM IMPERIAMUCMS_WEBSHOP WHERE price > 0 AND sub_cat = 27");
            if (0 < $specialShow["count"]) {
                echo "                                                        <a href=\"";
                echo __BASE_URL__;
                echo "webshop/shop/cat/1/?sub=27\"\r\n                                                           class=\"store_sub_category_button ";
                echo $cat27;
                echo "\">\r\n                                                            <span>";
                echo lang("webshop_txt_10", true);
                echo "</span>\r\n                                                        </a>\r\n                                                        ";
            }
            $specialShow = $dB->query_fetch_single("SELECT COUNT(*) as count FROM IMPERIAMUCMS_WEBSHOP WHERE price > 0 AND sub_cat = 26");
            if (0 < $specialShow["count"]) {
                echo "                                                        <a href=\"";
                echo __BASE_URL__;
                echo "webshop/shop/cat/1/?sub=26\"\r\n                                                           class=\"store_sub_category_button ";
                echo $cat26;
                echo "\">\r\n                                                            <span>";
                echo lang("webshop_txt_11", true);
                echo "</span>\r\n                                                        </a>\r\n                                                        ";
            }
            $specialShow = $dB->query_fetch_single("SELECT COUNT(*) as count FROM IMPERIAMUCMS_WEBSHOP WHERE price > 0 AND sub_cat = 28");
            if (0 < $specialShow["count"]) {
                echo "                                                        <a href=\"";
                echo __BASE_URL__;
                echo "webshop/shop/cat/1/?sub=28\"\r\n                                                           class=\"store_sub_category_button ";
                echo $cat28;
                echo "\">\r\n                                                            <span>";
                echo lang("webshop_txt_12", true);
                echo "</span>\r\n                                                        </a>\r\n                                                        ";
            }
            $specialShow = $dB->query_fetch_single("SELECT COUNT(*) as count FROM IMPERIAMUCMS_WEBSHOP WHERE price > 0 AND sub_cat = 24");
            if (0 < $specialShow["count"]) {
                echo "                                                        <a href=\"";
                echo __BASE_URL__;
                echo "webshop/shop/cat/1/?sub=24\"\r\n                                                           class=\"store_sub_category_button ";
                echo $cat24;
                echo "\">\r\n                                                            <span>";
                echo lang("webshop_txt_13", true);
                echo "</span>\r\n                                                        </a>\r\n                                                        ";
            }
            $specialShow = $dB->query_fetch_single("SELECT COUNT(*) as count FROM IMPERIAMUCMS_WEBSHOP_MYSTERY WHERE price > 0 AND status = 1");
            if (0 < $specialShow["count"]) {
                echo "                                                        <a href=\"";
                echo __BASE_URL__;
                echo "webshop/shop/cat/1/?sub=25\"\r\n                                                           class=\"store_sub_category_button ";
                echo $cat25;
                echo "\">\r\n                                                            <span>";
                echo lang("webshop_txt_14", true);
                echo "</span>\r\n                                                        </a>\r\n                                                        ";
            }
            $specialShow = $dB->query_fetch_single("SELECT COUNT(*) as count FROM IMPERIAMUCMS_WEBSHOP_PACKAGES WHERE price > 0 AND status = 1");
            if (0 < $specialShow["count"]) {
                echo "                                                        <a href=\"";
                echo __BASE_URL__;
                echo "webshop/shop/cat/1/?sub=30\"\r\n                                                           class=\"store_sub_category_button ";
                echo $cat30;
                echo "\">\r\n                                                            <span>";
                echo lang("webshop_txt_15", true);
                echo "</span>\r\n                                                        </a>\r\n                                                    ";
            }
            echo "                                                </div>\r\n                                            </div>\r\n                                            ";
        }
        $weaponsShow = $dB->query_fetch_single("SELECT COUNT(*) as count FROM IMPERIAMUCMS_WEBSHOP WHERE price > 0 AND main_cat = 2");
        if (0 < $weaponsShow["count"]) {
            echo "                                            <div class=\"store_category ";
            echo $main2;
            echo "\" data-id=\"4\">\r\n                                                <a href=\"#\" class=\"store_category_button ";
            echo $main22;
            echo "\">\r\n                                                    <span>";
            echo lang("webshop_txt_16", true);
            echo "</span>\r\n                                                    <p id=\"arrow\"></p>\r\n                                                    <div class=\"clear\"></div>\r\n                                                </a>\r\n\r\n                                                <div class=\"store_sub_categories\" align=\"left\"\r\n                                                     style=\"display: ";
            echo $display2;
            echo ";\">\r\n                                                    <a href=\"";
            echo __BASE_URL__;
            echo "webshop/shop/cat/2/?sub=all\"\r\n                                                       class=\"store_sub_category_button ";
            echo $all2;
            echo "\">\r\n                                                        <span>";
            echo lang("webshop_txt_9", true);
            echo "</span>\r\n                                                    </a>\r\n                                                    ";
            $weaponsShow = $dB->query_fetch_single("SELECT COUNT(*) as count FROM IMPERIAMUCMS_WEBSHOP WHERE price > 0 AND sub_cat = 0");
            if (0 < $weaponsShow["count"]) {
                echo "                                                        <a href=\"";
                echo __BASE_URL__;
                echo "webshop/shop/cat/2/?sub=0\"\r\n                                                           class=\"store_sub_category_button ";
                echo $cat0;
                echo "\">\r\n                                                            <span>";
                echo lang("webshop_txt_17", true);
                echo "</span>\r\n                                                        </a>\r\n                                                        ";
            }
            $weaponsShow = $dB->query_fetch_single("SELECT COUNT(*) as count FROM IMPERIAMUCMS_WEBSHOP WHERE price > 0 AND sub_cat = 1");
            if (0 < $weaponsShow["count"]) {
                echo "                                                        <a href=\"";
                echo __BASE_URL__;
                echo "webshop/shop/cat/2/?sub=1\"\r\n                                                           class=\"store_sub_category_button ";
                echo $cat1;
                echo "\">\r\n                                                            <span>";
                echo lang("webshop_txt_18", true);
                echo "</span>\r\n                                                        </a>\r\n                                                        ";
            }
            $weaponsShow = $dB->query_fetch_single("SELECT COUNT(*) as count FROM IMPERIAMUCMS_WEBSHOP WHERE price > 0 AND sub_cat = 2");
            if (0 < $weaponsShow["count"]) {
                echo "                                                        <a href=\"";
                echo __BASE_URL__;
                echo "webshop/shop/cat/2/?sub=2\"\r\n                                                           class=\"store_sub_category_button ";
                echo $cat2;
                echo "\">\r\n                                                            <span>";
                echo lang("webshop_txt_19", true);
                echo "</span>\r\n                                                        </a>\r\n                                                        ";
            }
            $weaponsShow = $dB->query_fetch_single("SELECT COUNT(*) as count FROM IMPERIAMUCMS_WEBSHOP WHERE price > 0 AND sub_cat = 3");
            if (0 < $weaponsShow["count"]) {
                echo "                                                        <a href=\"";
                echo __BASE_URL__;
                echo "webshop/shop/cat/2/?sub=3\"\r\n                                                           class=\"store_sub_category_button ";
                echo $cat3;
                echo "\">\r\n                                                            <span>";
                echo lang("webshop_txt_20", true);
                echo "</span>\r\n                                                        </a>\r\n                                                        ";
            }
            $weaponsShow = $dB->query_fetch_single("SELECT COUNT(*) as count FROM IMPERIAMUCMS_WEBSHOP WHERE price > 0 AND sub_cat = 4");
            if (0 < $weaponsShow["count"]) {
                echo "                                                        <a href=\"";
                echo __BASE_URL__;
                echo "webshop/shop/cat/2/?sub=4\"\r\n                                                           class=\"store_sub_category_button ";
                echo $cat4;
                echo "\">\r\n                                                            <span>";
                echo lang("webshop_txt_21", true);
                echo "</span>\r\n                                                        </a>\r\n                                                        ";
            }
            $weaponsShow = $dB->query_fetch_single("SELECT COUNT(*) as count FROM IMPERIAMUCMS_WEBSHOP WHERE price > 0 AND sub_cat = 5");
            if (0 < $weaponsShow["count"]) {
                echo "                                                        <a href=\"";
                echo __BASE_URL__;
                echo "webshop/shop/cat/2/?sub=5\"\r\n                                                           class=\"store_sub_category_button ";
                echo $cat5;
                echo "\">\r\n                                                            <span>";
                echo lang("webshop_txt_22", true);
                echo "</span>\r\n                                                        </a>\r\n                                                    ";
            }
            echo "                                                </div>\r\n                                            </div>\r\n                                            ";
        }
        $equipShow = $dB->query_fetch_single("SELECT COUNT(*) as count FROM IMPERIAMUCMS_WEBSHOP WHERE price > 0 AND main_cat = 3");
        if (0 < $equipShow["count"]) {
            echo "                                            <div class=\"store_category ";
            echo $main3;
            echo "\" data-id=\"1\">\r\n                                                <a href=\"#\" class=\"store_category_button ";
            echo $main33;
            echo "\">\r\n                                                    <span>";
            echo lang("webshop_txt_23", true);
            echo "</span>\r\n                                                    <p id=\"arrow\"></p>\r\n                                                    <div class=\"clear\"></div>\r\n                                                </a>\r\n\r\n                                                <div class=\"store_sub_categories\" align=\"left\"\r\n                                                     style=\"display: ";
            echo $display3;
            echo ";\">\r\n                                                    <a href=\"";
            echo __BASE_URL__;
            echo "webshop/shop/cat/3/?sub=all\"\r\n                                                       class=\"store_sub_category_button ";
            echo $all3;
            echo "\">\r\n                                                        <span>";
            echo lang("webshop_txt_9", true);
            echo "</span>\r\n                                                    </a>\r\n                                                    ";
            $equipShow = $dB->query_fetch_single("SELECT COUNT(*) as count FROM IMPERIAMUCMS_WEBSHOP WHERE price > 0 AND sub_cat = 7");
            if (0 < $equipShow["count"]) {
                echo "                                                        <a href=\"";
                echo __BASE_URL__;
                echo "webshop/shop/cat/3/?sub=7\"\r\n                                                           class=\"store_sub_category_button ";
                echo $cat7;
                echo "\">\r\n                                                            <span>";
                echo lang("webshop_txt_24", true);
                echo "</span>\r\n                                                        </a>\r\n                                                        ";
            }
            $equipShow = $dB->query_fetch_single("SELECT COUNT(*) as count FROM IMPERIAMUCMS_WEBSHOP WHERE price > 0 AND sub_cat = 8");
            if (0 < $equipShow["count"]) {
                echo "                                                        <a href=\"";
                echo __BASE_URL__;
                echo "webshop/shop/cat/3/?sub=8\"\r\n                                                           class=\"store_sub_category_button ";
                echo $cat8;
                echo "\">\r\n                                                            <span>";
                echo lang("webshop_txt_25", true);
                echo "</span>\r\n                                                        </a>\r\n                                                        ";
            }
            $equipShow = $dB->query_fetch_single("SELECT COUNT(*) as count FROM IMPERIAMUCMS_WEBSHOP WHERE price > 0 AND sub_cat = 9");
            if (0 < $equipShow["count"]) {
                echo "                                                        <a href=\"";
                echo __BASE_URL__;
                echo "webshop/shop/cat/3/?sub=9\"\r\n                                                           class=\"store_sub_category_button ";
                echo $cat9;
                echo "\">\r\n                                                            <span>";
                echo lang("webshop_txt_26", true);
                echo "</span>\r\n                                                        </a>\r\n                                                        ";
            }
            $equipShow = $dB->query_fetch_single("SELECT COUNT(*) as count FROM IMPERIAMUCMS_WEBSHOP WHERE price > 0 AND sub_cat = 10");
            if (0 < $equipShow["count"]) {
                echo "                                                        <a href=\"";
                echo __BASE_URL__;
                echo "webshop/shop/cat/3/?sub=10\"\r\n                                                           class=\"store_sub_category_button ";
                echo $cat10;
                echo "\">\r\n                                                            <span>";
                echo lang("webshop_txt_27", true);
                echo "</span>\r\n                                                        </a>\r\n                                                        ";
            }
            $equipShow = $dB->query_fetch_single("SELECT COUNT(*) as count FROM IMPERIAMUCMS_WEBSHOP WHERE price > 0 AND sub_cat = 11");
            if (0 < $equipShow["count"]) {
                echo "                                                        <a href=\"";
                echo __BASE_URL__;
                echo "webshop/shop/cat/3/?sub=11\"\r\n                                                           class=\"store_sub_category_button ";
                echo $cat11;
                echo "\">\r\n                                                            <span>";
                echo lang("webshop_txt_28", true);
                echo "</span>\r\n                                                        </a>\r\n                                                        ";
            }
            $equipShow = $dB->query_fetch_single("SELECT COUNT(*) as count FROM IMPERIAMUCMS_WEBSHOP WHERE price > 0 AND sub_cat = 6");
            if (0 < $equipShow["count"]) {
                echo "                                                        <a href=\"";
                echo __BASE_URL__;
                echo "webshop/shop/cat/3/?sub=6\"\r\n                                                           class=\"store_sub_category_button ";
                echo $cat6;
                echo "\">\r\n                                                            <span>";
                echo lang("webshop_txt_29", true);
                echo "</span>\r\n                                                        </a>\r\n                                                    ";
            }
            echo "                                                </div>\r\n                                            </div>\r\n                                            ";
        }
        $wingsShow = $dB->query_fetch_single("SELECT COUNT(*) as count FROM IMPERIAMUCMS_WEBSHOP WHERE price > 0 AND main_cat = 4");
        if (0 < $wingsShow["count"]) {
            echo "                                            <div class=\"store_category ";
            echo $main4;
            echo "\" data-id=\"0\">\r\n                                                <a href=\"#\" class=\"store_category_button ";
            echo $main44;
            echo "\">\r\n                                                    <span>";
            echo lang("webshop_txt_30", true);
            echo "</span>\r\n                                                    <p id=\"arrow\"></p>\r\n                                                    <div class=\"clear\"></div>\r\n                                                </a>\r\n\r\n                                                <div class=\"store_sub_categories\" align=\"left\"\r\n                                                     style=\"display: ";
            echo $display4;
            echo ";\">\r\n                                                    <a href=\"";
            echo __BASE_URL__;
            echo "webshop/shop/cat/4/?sub=all\"\r\n                                                       class=\"store_sub_category_button ";
            echo $all4;
            echo "\">\r\n                                                        <span>";
            echo lang("webshop_txt_9", true);
            echo "</span>\r\n                                                    </a>\r\n                                                    ";
            $wingsShow = $dB->query_fetch_single("SELECT COUNT(*) as count FROM IMPERIAMUCMS_WEBSHOP WHERE price > 0 AND sub_cat = 12");
            if (0 < $wingsShow["count"]) {
                echo "                                                        <a href=\"";
                echo __BASE_URL__;
                echo "webshop/shop/cat/4/?sub=12\"\r\n                                                           class=\"store_sub_category_button ";
                echo $cat12;
                echo "\">\r\n                                                            <span>";
                echo lang("webshop_txt_31", true);
                echo "</span>\r\n                                                        </a>\r\n                                                        ";
            }
            $wingsShow = $dB->query_fetch_single("SELECT COUNT(*) as count FROM IMPERIAMUCMS_WEBSHOP WHERE price > 0 AND sub_cat = 13");
            if (0 < $wingsShow["count"]) {
                echo "                                                        <a href=\"";
                echo __BASE_URL__;
                echo "webshop/shop/cat/4/?sub=13\"\r\n                                                           class=\"store_sub_category_button ";
                echo $cat13;
                echo "\">\r\n                                                            <span>";
                echo lang("webshop_txt_32", true);
                echo "</span>\r\n                                                        </a>\r\n                                                        ";
            }
            $wingsShow = $dB->query_fetch_single("SELECT COUNT(*) as count FROM IMPERIAMUCMS_WEBSHOP WHERE price > 0 AND sub_cat = 31");
            if (0 < $wingsShow["count"]) {
                echo "                                                        <a href=\"";
                echo __BASE_URL__;
                echo "webshop/shop/cat/4/?sub=31\"\r\n                                                           class=\"store_sub_category_button ";
                echo $cat31;
                echo "\">\r\n                                                            <span>";
                echo lang("webshop_txt_33", true);
                echo "</span>\r\n                                                        </a>\r\n                                                        ";
            }
            $wingsShow = $dB->query_fetch_single("SELECT COUNT(*) as count FROM IMPERIAMUCMS_WEBSHOP WHERE price > 0 AND sub_cat = 14");
            if (0 < $wingsShow["count"]) {
                echo "                                                        <a href=\"";
                echo __BASE_URL__;
                echo "webshop/shop/cat/4/?sub=14\"\r\n                                                           class=\"store_sub_category_button ";
                echo $cat14;
                echo "\">\r\n                                                            <span>";
                echo lang("webshop_txt_34", true);
                echo "</span>\r\n                                                        </a>\r\n                                                        ";
            }
            $wingsShow = $dB->query_fetch_single("SELECT COUNT(*) as count FROM IMPERIAMUCMS_WEBSHOP WHERE price > 0 AND sub_cat = 32");
            if (0 < $wingsShow["count"]) {
                echo "                                                        <a href=\"";
                echo __BASE_URL__;
                echo "webshop/shop/cat/4/?sub=32\" class=\"store_sub_category_button ";
                echo $cat32;
                echo "\">\r\n                                                            <span>";
                echo lang("webshop_txt_35", true);
                echo "</span>\r\n                                                        </a>\r\n                                                    ";
            }
            echo "                                                </div>\r\n                                            </div>\r\n                                            ";
        }
        $jewelryShow = $dB->query_fetch_single("SELECT COUNT(*) as count FROM IMPERIAMUCMS_WEBSHOP WHERE price > 0 AND main_cat = 5");
        if (0 < $jewelryShow["count"]) {
            echo "                                            <div class=\"store_category ";
            echo $main5;
            echo "\" data-id=\"16\">\r\n                                                <a href=\"#\" class=\"store_category_button ";
            echo $main55;
            echo "\">\r\n                                                    <span>";
            echo lang("webshop_txt_36", true);
            echo "</span>\r\n                                                    <p id=\"arrow\"></p>\r\n                                                    <div class=\"clear\"></div>\r\n                                                </a>\r\n\r\n                                                <div class=\"store_sub_categories\" align=\"left\" style=\"display: ";
            echo $display5;
            echo ";\">\r\n                                                    <a href=\"";
            echo __BASE_URL__;
            echo "webshop/shop/cat/5/?sub=all\"\r\n                                                       class=\"store_sub_category_button ";
            echo $all5;
            echo "\">\r\n                                                        <span>";
            echo lang("webshop_txt_9", true);
            echo "</span>\r\n                                                    </a>\r\n                                                    ";
            $jewelryShow = $dB->query_fetch_single("SELECT COUNT(*) as count FROM IMPERIAMUCMS_WEBSHOP WHERE price > 0 AND sub_cat = 16");
            if (0 < $jewelryShow["count"]) {
                echo "                                                        <a href=\"";
                echo __BASE_URL__;
                echo "webshop/shop/cat/5/?sub=16\" class=\"store_sub_category_button ";
                echo $cat16;
                echo "\">\r\n                                                            <span>";
                echo lang("webshop_txt_37", true);
                echo "</span>\r\n                                                        </a>\r\n                                                        ";
            }
            $jewelryShow = $dB->query_fetch_single("SELECT COUNT(*) as count FROM IMPERIAMUCMS_WEBSHOP WHERE price > 0 AND sub_cat = 17");
            if (0 < $jewelryShow["count"]) {
                echo "                                                        <a href=\"";
                echo __BASE_URL__;
                echo "webshop/shop/cat/5/?sub=17\" class=\"store_sub_category_button ";
                echo $cat17;
                echo "\">\r\n                                                            <span>";
                echo lang("webshop_txt_38", true);
                echo "</span>\r\n                                                        </a>\r\n                                                    ";
            }
            $jewelryShow = $dB->query_fetch_single("SELECT COUNT(*) as count FROM IMPERIAMUCMS_WEBSHOP WHERE price > 0 AND sub_cat = 33");
            if (0 < $jewelryShow["count"]) {
                echo "                                                        <a href=\"";
                echo __BASE_URL__;
                echo "webshop/shop/cat/5/?sub=33\" class=\"store_sub_category_button ";
                echo $cat33;
                echo "\">\r\n                                                            <span>";
                echo lang("webshop_txt_92", true);
                echo "</span>\r\n                                                        </a>\r\n                                                    ";
            }
            echo "                                                </div>\r\n                                            </div>\r\n                                            ";
        }
        $petsShow = $dB->query_fetch_single("SELECT COUNT(*) as count FROM IMPERIAMUCMS_WEBSHOP WHERE price > 0 AND main_cat = 6");
        if (0 < $petsShow["count"]) {
            echo "                                            <div class=\"store_category ";
            echo $main6;
            echo "\" data-id=\"7\">\r\n                                                <a href=\"#\" class=\"store_category_button ";
            echo $main66;
            echo "\">\r\n                                                    <span>";
            echo lang("webshop_txt_39", true);
            echo "</span>\r\n                                                    <p id=\"arrow\"></p>\r\n                                                    <div class=\"clear\"></div>\r\n                                                </a>\r\n\r\n                                                <div class=\"store_sub_categories\" align=\"left\" style=\"display: ";
            echo $display6;
            echo ";\">\r\n                                                    <a href=\"";
            echo __BASE_URL__;
            echo "webshop/shop/cat/6/?sub=all\" class=\"store_sub_category_button ";
            echo $all6;
            echo "\">\r\n                                                        <span>";
            echo lang("webshop_txt_9", true);
            echo "</span>\r\n                                                    </a>\r\n                                                    ";
            $petsShow = $dB->query_fetch_single("SELECT COUNT(*) as count FROM IMPERIAMUCMS_WEBSHOP WHERE price > 0 AND sub_cat = 19");
            if (0 < $petsShow["count"]) {
                echo "                                                        <a href=\"";
                echo __BASE_URL__;
                echo "webshop/shop/cat/6/?sub=19\" class=\"store_sub_category_button ";
                echo $cat19;
                echo "\">\r\n                                                            <span>";
                echo lang("webshop_txt_40", true);
                echo "</span>\r\n                                                        </a>\r\n                                                        ";
            }
            $petsShow = $dB->query_fetch_single("SELECT COUNT(*) as count FROM IMPERIAMUCMS_WEBSHOP WHERE price > 0 AND sub_cat = 18");
            if (0 < $petsShow["count"]) {
                echo "                                                        <a href=\"";
                echo __BASE_URL__;
                echo "webshop/shop/cat/6/?sub=18\"\r\n                                                           class=\"store_sub_category_button ";
                echo $cat18;
                echo "\">\r\n                                                            <span>";
                echo lang("webshop_txt_41", true);
                echo "</span>\r\n                                                        </a>\r\n                                                    ";
            }
            echo "                                                </div>\r\n                                            </div>\r\n                                            ";
        }
        $craftShow = $dB->query_fetch_single("SELECT COUNT(*) as count FROM IMPERIAMUCMS_WEBSHOP WHERE price > 0 AND main_cat = 7");
        if (0 < $craftShow["count"]) {
            echo "                                            <div class=\"store_category ";
            echo $main7;
            echo "\" data-id=\"9\">\r\n                                                <a href=\"#\" class=\"store_category_button ";
            echo $main77;
            echo "\">\r\n                                                    <span>";
            echo lang("webshop_txt_42", true);
            echo "</span>\r\n                                                    <p id=\"arrow\"></p>\r\n                                                    <div class=\"clear\"></div>\r\n                                                </a>\r\n\r\n                                                <div class=\"store_sub_categories\" align=\"left\"\r\n                                                     style=\"display: ";
            echo $display7;
            echo ";\">\r\n                                                    <a href=\"";
            echo __BASE_URL__;
            echo "webshop/shop/cat/7/?sub=all\"\r\n                                                       class=\"store_sub_category_button ";
            echo $all7;
            echo "\">\r\n                                                        <span>";
            echo lang("webshop_txt_9", true);
            echo "</span>\r\n                                                    </a>\r\n                                                    ";
            $craftShow = $dB->query_fetch_single("SELECT COUNT(*) as count FROM IMPERIAMUCMS_WEBSHOP WHERE price > 0 AND sub_cat = 21");
            if (0 < $craftShow["count"]) {
                echo "                                                        <a href=\"";
                echo __BASE_URL__;
                echo "webshop/shop/cat/7/?sub=21\"\r\n                                                           class=\"store_sub_category_button ";
                echo $cat21;
                echo "\">\r\n                                                            <span>";
                echo lang("webshop_txt_43", true);
                echo "</span>\r\n                                                        </a>\r\n                                                        ";
            }
            $craftShow = $dB->query_fetch_single("SELECT COUNT(*) as count FROM IMPERIAMUCMS_WEBSHOP WHERE price > 0 AND sub_cat = 22");
            if (0 < $craftShow["count"]) {
                echo "                                                        <a href=\"";
                echo __BASE_URL__;
                echo "webshop/shop/cat/7/?sub=22\"\r\n                                                           class=\"store_sub_category_button ";
                echo $cat22;
                echo "\">\r\n                                                            <span>";
                echo lang("webshop_txt_44", true);
                echo "</span>\r\n                                                        </a>\r\n                                                        ";
            }
            $craftShow = $dB->query_fetch_single("SELECT COUNT(*) as count FROM IMPERIAMUCMS_WEBSHOP WHERE price > 0 AND sub_cat = 23");
            if (0 < $craftShow["count"]) {
                echo "                                                        <a href=\"";
                echo __BASE_URL__;
                echo "webshop/shop/cat/7/?sub=23\"\r\n                                                           class=\"store_sub_category_button ";
                echo $cat23;
                echo "\">\r\n                                                            <span>";
                echo lang("webshop_txt_45", true);
                echo "</span>\r\n                                                        </a>\r\n                                                    ";
            }
            echo "                                                </div>\r\n                                            </div>\r\n                                        ";
        }
        echo "                                    </div>\r\n                                </div>\r\n                            </div>\r\n                        </div>\r\n                        <div class=\"store_right_side\">\r\n                            <div class=\"store_items_list\">\r\n                                <div class=\"scrollbar disable\" style=\"height: 554px;\">\r\n                                    <div class=\"track\" style=\"height: 554px;\">\r\n                                        <div class=\"thumb\" style=\"top: 0px; height: 554px;\">\r\n                                            <div class=\"end\"></div>\r\n                                        </div>\r\n                                    </div>\r\n                                </div>\r\n                                <div class=\"viewport\">\r\n                                    <div class=\"overview\" style=\"top: 0px;\">\r\n\r\n                                        ";
        if (check_value($_GET["cat"])) {
            $cat = htmlspecialchars($_GET["cat"]);
            if ($cat != "1" && $cat != "2" && $cat != "3" && $cat != "4" && $cat != "5" && $cat != "6" && $cat != "7") {
                message("error", lang("webshop_txt_46", true));
            } else {
                if (check_value($_GET["sub"])) {
                    $sub = htmlspecialchars($_GET["sub"]);
                    $Webshop = new Webshop();
                    if (check_value($_GET["buy"])) {
                        $id = Decode($_GET["buy"]);
                        $itype = Decode($_GET["type"]);
                        if ($itype == "normal") {
                            if (isset($_POST["buy"])) {
                                $itemData = $Webshop->loadItemData($id);
                                $anc = $Webshop->isAncient($id);
                                $payments = $Webshop->loadPayments($id, "IMPERIAMUCMS_WEBSHOP");
                                $level = htmlspecialchars($_POST["level"]);
                                if ($level == NULL || empty($level)) {
                                    $level = 0;
                                }
                                $life = htmlspecialchars($_POST["life"]);
                                if ($life == NULL || empty($life)) {
                                    $life = 0;
                                }
                                $luck = htmlspecialchars($_POST["luck"]);
                                if ($luck == NULL || empty($luck)) {
                                    $luck = 0;
                                }
                                if ($luck) {
                                    $luck = 1;
                                }
                                $skill = htmlspecialchars($_POST["skill"]);
                                if ($skill == NULL || empty($skill)) {
                                    $skill = 0;
                                }
                                if ($skill) {
                                    $skill = 1;
                                }
                                $ancopt = htmlspecialchars($_POST["ancopt"]);
                                $stamina = htmlspecialchars($_POST["stamina"]);
                                if ($ancopt == NULL || empty($ancopt) || !$is_anc) {
                                    $ancopt = 0;
                                }
                                if ($stamina == NULL || empty($stamina) || !$is_anc) {
                                    $stamina = 0;
                                }
                                if ($anc["anc1"] == "0" && $anc["anc2"] == "0") {
                                    $ancopt = 0;
                                    $stamina = 0;
                                }
                                if ("0" < $ancopt && $stamina == "0") {
                                    $ancopt = 0;
                                }
                                if ($ancopt == "0" && "0" < $stamina) {
                                    $stamina = 0;
                                }
                                $exc1 = htmlspecialchars($_POST["exc1"]);
                                $exc2 = htmlspecialchars($_POST["exc2"]);
                                $exc3 = htmlspecialchars($_POST["exc3"]);
                                $exc4 = htmlspecialchars($_POST["exc4"]);
                                $exc5 = htmlspecialchars($_POST["exc5"]);
                                $exc6 = htmlspecialchars($_POST["exc6"]);
                                if ($exc1 == NULL || empty($exc1)) {
                                    $exc1 = 0;
                                }
                                if ($exc2 == NULL || empty($exc2)) {
                                    $exc2 = 0;
                                }
                                if ($exc3 == NULL || empty($exc3)) {
                                    $exc3 = 0;
                                }
                                if ($exc4 == NULL || empty($exc4)) {
                                    $exc4 = 0;
                                }
                                if ($exc5 == NULL || empty($exc5)) {
                                    $exc5 = 0;
                                }
                                if ($exc6 == NULL || empty($exc6)) {
                                    $exc6 = 0;
                                }
                                if ($exc1) {
                                    $exc1 = 1;
                                }
                                if ($exc2) {
                                    $exc2 = 1;
                                }
                                if ($exc3) {
                                    $exc3 = 1;
                                }
                                if ($exc4) {
                                    $exc4 = 1;
                                }
                                if ($exc5) {
                                    $exc5 = 1;
                                }
                                if ($exc6) {
                                    $exc6 = 1;
                                }
                                $total_exc = 0;
                                $total_exc = $exc1 + $exc2 + $exc3 + $exc4 + $exc5 + $exc6;
                                $refinery = htmlspecialchars($_POST["refinery"]);
                                if ($refinery == NULL || empty($refinery)) {
                                    $refinery = 0;
                                }
                                if ($refinery) {
                                    $refinery = 1;
                                }
                                $harmony = htmlspecialchars($_POST["harmony"]);
                                if ($harmony == NULL || empty($harmony)) {
                                    $harmony = 0;
                                }
                                $socket1 = htmlspecialchars($_POST["socket1"]);
                                $socket2 = htmlspecialchars($_POST["socket2"]);
                                $socket3 = htmlspecialchars($_POST["socket3"]);
                                $socket4 = htmlspecialchars($_POST["socket4"]);
                                $socket5 = htmlspecialchars($_POST["socket5"]);
                                $socket99 = htmlspecialchars($_POST["socket99"]);
                                if ($socket1 == NULL) {
                                    $socket1 = 255;
                                }
                                if ($socket2 == NULL) {
                                    $socket2 = 255;
                                }
                                if ($socket3 == NULL) {
                                    $socket3 = 255;
                                }
                                if ($socket4 == NULL) {
                                    $socket4 = 255;
                                }
                                if ($socket5 == NULL) {
                                    $socket5 = 255;
                                }
                                if ($socket99 == NULL) {
                                    $socket99 = 255;
                                }
                                $total_sockets = 0;
                                if (0 <= $socket1 && $socket1 < 255 || 255 < $socket1) {
                                    $total_sockets++;
                                }
                                if (0 <= $socket2 && $socket2 < 255 || 255 < $socket2) {
                                    $total_sockets++;
                                }
                                if (0 <= $socket3 && $socket3 < 255 || 255 < $socket3) {
                                    $total_sockets++;
                                }
                                if (0 <= $socket4 && $socket4 < 255 || 255 < $socket4) {
                                    $total_sockets++;
                                }
                                if (0 <= $socket5 && $socket5 < 255 || 255 < $socket5) {
                                    $total_sockets++;
                                }
                                $elementType = htmlspecialchars($_POST["element"]);
                                if (1 <= mconfig("element_errtel_slots")) {
                                    if (1 <= mconfig("element_anger_slots")) {
                                        $anger1 = htmlspecialchars($_POST["anger1"]);
                                        $anger1lvl = htmlspecialchars($_POST["anger1lvl"]);
                                        if (mconfig("element_anger_1_maxlvl") <= $anger1lvl) {
                                            $anger1lvl = mconfig("element_anger_1_maxlvl");
                                        }
                                    }
                                    if (2 <= mconfig("element_anger_slots")) {
                                        $anger2 = htmlspecialchars($_POST["anger2"]);
                                        $anger2lvl = htmlspecialchars($_POST["anger2lvl"]);
                                        if (mconfig("element_anger_2_maxlvl") <= $anger2lvl) {
                                            $anger2lvl = mconfig("element_anger_2_maxlvl");
                                        }
                                    }
                                    if (3 <= mconfig("element_anger_slots")) {
                                        $anger3 = htmlspecialchars($_POST["anger3"]);
                                        $anger3lvl = htmlspecialchars($_POST["anger3lvl"]);
                                        if (mconfig("element_anger_3_maxlvl") <= $anger3lvl) {
                                            $anger3lvl = mconfig("element_anger_3_maxlvl");
                                        }
                                    }
                                    if (4 <= mconfig("element_anger_slots")) {
                                        $anger4 = htmlspecialchars($_POST["anger4"]);
                                        $anger4lvl = htmlspecialchars($_POST["anger4lvl"]);
                                        if (mconfig("element_anger_4_maxlvl") <= $anger4lvl) {
                                            $anger4lvl = mconfig("element_anger_4_maxlvl");
                                        }
                                    }
                                    if (5 <= mconfig("element_anger_slots")) {
                                        $anger5 = htmlspecialchars($_POST["anger5"]);
                                        $anger5lvl = htmlspecialchars($_POST["anger5lvl"]);
                                        if (mconfig("element_anger_5_maxlvl") <= $anger5lvl) {
                                            $anger5lvl = mconfig("element_anger_5_maxlvl");
                                        }
                                    }
                                }
                                if (2 <= mconfig("element_errtel_slots")) {
                                    if (1 <= mconfig("element_blessing_slots")) {
                                        $blessing1 = htmlspecialchars($_POST["blessing1"]);
                                        $blessing1lvl = htmlspecialchars($_POST["blessing1lvl"]);
                                        if (mconfig("element_blessing_1_maxlvl") <= $blessing1lvl) {
                                            $blessing1lvl = mconfig("element_blessing_1_maxlvl");
                                        }
                                    }
                                    if (2 <= mconfig("element_blessing_slots")) {
                                        $blessing2 = htmlspecialchars($_POST["blessing2"]);
                                        $blessing2lvl = htmlspecialchars($_POST["blessing2lvl"]);
                                        if (mconfig("element_blessing_2_maxlvl") <= $blessing2lvl) {
                                            $blessing2lvl = mconfig("element_blessing_2_maxlvl");
                                        }
                                    }
                                    if (3 <= mconfig("element_blessing_slots")) {
                                        $blessing3 = htmlspecialchars($_POST["blessing3"]);
                                        $blessing3lvl = htmlspecialchars($_POST["blessing3lvl"]);
                                        if (mconfig("element_blessing_3_maxlvl") <= $blessing3lvl) {
                                            $blessing3lvl = mconfig("element_blessing_3_maxlvl");
                                        }
                                    }
                                    if (4 <= mconfig("element_blessing_slots")) {
                                        $blessing4 = htmlspecialchars($_POST["blessing4"]);
                                        $blessing4lvl = htmlspecialchars($_POST["blessing4lvl"]);
                                        if (mconfig("element_blessing_4_maxlvl") <= $blessing4lvl) {
                                            $blessing4lvl = mconfig("element_blessing_4_maxlvl");
                                        }
                                    }
                                    if (5 <= mconfig("element_blessing_slots")) {
                                        $blessing5 = htmlspecialchars($_POST["blessing5"]);
                                        $blessing5lvl = htmlspecialchars($_POST["blessing5lvl"]);
                                        if (mconfig("element_blessing_5_maxlvl") <= $blessing5lvl) {
                                            $blessing5lvl = mconfig("element_blessing_5_maxlvl");
                                        }
                                    }
                                }
                                if (3 <= mconfig("element_errtel_slots")) {
                                    if (1 <= mconfig("element_integrity_slots")) {
                                        $integrity1 = htmlspecialchars($_POST["integrity1"]);
                                        $integrity1lvl = htmlspecialchars($_POST["integrity1lvl"]);
                                        if (mconfig("element_integrity_1_maxlvl") <= $integrity1lvl) {
                                            $integrity1lvl = mconfig("element_integrity_1_maxlvl");
                                        }
                                    }
                                    if (2 <= mconfig("element_integrity_slots")) {
                                        $integrity2 = htmlspecialchars($_POST["integrity2"]);
                                        $integrity2lvl = htmlspecialchars($_POST["integrity2lvl"]);
                                        if (mconfig("element_integrity_2_maxlvl") <= $integrity2lvl) {
                                            $integrity2lvl = mconfig("element_integrity_2_maxlvl");
                                        }
                                    }
                                    if (3 <= mconfig("element_integrity_slots")) {
                                        $integrity3 = htmlspecialchars($_POST["integrity3"]);
                                        $integrity3lvl = htmlspecialchars($_POST["integrity3lvl"]);
                                        if (mconfig("element_integrity_3_maxlvl") <= $integrity3lvl) {
                                            $integrity3lvl = mconfig("element_integrity_3_maxlvl");
                                        }
                                    }
                                    if (4 <= mconfig("element_integrity_slots")) {
                                        $integrity4 = htmlspecialchars($_POST["integrity4"]);
                                        $integrity4lvl = htmlspecialchars($_POST["integrity4lvl"]);
                                        if (mconfig("element_integrity_4_maxlvl") <= $integrity4lvl) {
                                            $integrity4lvl = mconfig("element_integrity_4_maxlvl");
                                        }
                                    }
                                    if (5 <= mconfig("element_integrity_slots")) {
                                        $integrity5 = htmlspecialchars($_POST["integrity5"]);
                                        $integrity5lvl = htmlspecialchars($_POST["integrity5lvl"]);
                                        if (mconfig("element_integrity_5_maxlvl") <= $integrity5lvl) {
                                            $integrity5lvl = mconfig("element_integrity_5_maxlvl");
                                        }
                                    }
                                }
                                if (4 <= mconfig("element_errtel_slots")) {
                                    if (1 <= mconfig("element_divinity_slots")) {
                                        $divinity1 = htmlspecialchars($_POST["divinity1"]);
                                        $divinity1lvl = htmlspecialchars($_POST["divinity1lvl"]);
                                        if (mconfig("element_divinity_1_maxlvl") <= $divinity1lvl) {
                                            $divinity1lvl = mconfig("element_divinity_1_maxlvl");
                                        }
                                    }
                                    if (2 <= mconfig("element_divinity_slots")) {
                                        $divinity2 = htmlspecialchars($_POST["divinity2"]);
                                        $divinity2lvl = htmlspecialchars($_POST["divinity2lvl"]);
                                        if (mconfig("element_divinity_2_maxlvl") <= $divinity2lvl) {
                                            $divinity2lvl = mconfig("element_divinity_2_maxlvl");
                                        }
                                    }
                                    if (3 <= mconfig("element_divinity_slots")) {
                                        $divinity3 = htmlspecialchars($_POST["divinity3"]);
                                        $divinity3lvl = htmlspecialchars($_POST["divinity3lvl"]);
                                        if (mconfig("element_divinity_3_maxlvl") <= $divinity3lvl) {
                                            $divinity3lvl = mconfig("element_divinity_3_maxlvl");
                                        }
                                    }
                                    if (4 <= mconfig("element_divinity_slots")) {
                                        $divinity4 = htmlspecialchars($_POST["divinity4"]);
                                        $divinity4lvl = htmlspecialchars($_POST["divinity4lvl"]);
                                        if (mconfig("element_divinity_4_maxlvl") <= $divinity4lvl) {
                                            $divinity4lvl = mconfig("element_divinity_4_maxlvl");
                                        }
                                    }
                                    if (5 <= mconfig("element_divinity_slots")) {
                                        $divinity5 = htmlspecialchars($_POST["divinity5"]);
                                        $divinity5lvl = htmlspecialchars($_POST["divinity5lvl"]);
                                        if (mconfig("element_divinity_5_maxlvl") <= $divinity5lvl) {
                                            $divinity5lvl = mconfig("element_divinity_5_maxlvl");
                                        }
                                    }
                                }
                                if (5 <= mconfig("element_errtel_slots")) {
                                    if (1 <= mconfig("element_gale_slots")) {
                                        $gale1 = htmlspecialchars($_POST["gale1"]);
                                        $gale1lvl = htmlspecialchars($_POST["gale1lvl"]);
                                        if (mconfig("element_gale_1_maxlvl") <= $gale1lvl) {
                                            $gale1lvl = mconfig("element_gale_1_maxlvl");
                                        }
                                    }
                                    if (2 <= mconfig("element_gale_slots")) {
                                        $gale2 = htmlspecialchars($_POST["gale2"]);
                                        $gale2lvl = htmlspecialchars($_POST["gale2lvl"]);
                                        if (mconfig("element_gale_2_maxlvl") <= $gale2lvl) {
                                            $gale2lvl = mconfig("element_gale_2_maxlvl");
                                        }
                                    }
                                    if (3 <= mconfig("element_gale_slots")) {
                                        $gale3 = htmlspecialchars($_POST["gale3"]);
                                        $gale3lvl = htmlspecialchars($_POST["gale3lvl"]);
                                        if (mconfig("element_gale_3_maxlvl") <= $gale3lvl) {
                                            $gale3lvl = mconfig("element_gale_3_maxlvl");
                                        }
                                    }
                                    if (4 <= mconfig("element_gale_slots")) {
                                        $gale4 = htmlspecialchars($_POST["gale4"]);
                                        $gale4lvl = htmlspecialchars($_POST["gale4lvl"]);
                                        if (mconfig("element_gale_4_maxlvl") <= $gale4lvl) {
                                            $gale4lvl = mconfig("element_gale_4_maxlvl");
                                        }
                                    }
                                    if (5 <= mconfig("element_gale_slots")) {
                                        $gale5 = htmlspecialchars($_POST["gale5"]);
                                        $gale5lvl = htmlspecialchars($_POST["gale5lvl"]);
                                        if (mconfig("element_gale_5_maxlvl") <= $gale5lvl) {
                                            $gale5lvl = mconfig("element_gale_5_maxlvl");
                                        }
                                    }
                                }
                                $error = false;
                                $reason = "";
                                if ($itemData["luck"] == "0" && 0 < $luck) {
                                    $luck = 0;
                                }
                                if ($itemData["skill"] == "0" && 0 < $skill) {
                                    $skill = 0;
                                }
                                if ($is_refinery && $itemData["use_refinary"] == "0" && 0 < $refinery) {
                                    $refinery = 0;
                                }
                                if ($is_harmony && $itemData["use_harmony"] == "0" && 0 < $harmony) {
                                    $harmony = 0;
                                }
                                if ($is_global) {
                                    if ($level < 0 || 15 < $level || $max_lvl < $level) {
                                        $level = 0;
                                    }
                                    if ($life < 0 || 7 < $life || $max_life_opt < $life) {
                                        $life = 0;
                                    }
                                    if (0 < $itemData["exetype"] && $max_exc_opt < $total_exc) {
                                        $error = true;
                                        $reason = lang("webshop_txt_47", true);
                                    }
                                    if ($is_socket && $itemData["use_sockets"] && $max_socket < $total_sockets) {
                                        $error = true;
                                        $reason = lang("webshop_txt_48", true);
                                    }
                                } else {
                                    if ($level < 0 || 15 < $level || $itemData["max_item_lvl"] < $level) {
                                        $level = 0;
                                    }
                                    if ($life < 0 || 7 < $life || $itemData["max_item_opt"] < $life) {
                                        $life = 0;
                                    }
                                    if (0 < $itemData["exetype"] && $itemData["max_exc_opt"] < $total_exc) {
                                        $error = true;
                                        $reason = lang("webshop_txt_47", true);
                                    }
                                    if ($is_socket && $itemData["use_sockets"] && $itemData["max_socket"] < $total_sockets) {
                                        $error = true;
                                        $reason = lang("webshop_txt_48", true);
                                    }
                                }
                                if ($is_socket && !mconfig("allow_same_socket")) {
                                    $allSocketsData = $Webshop->retrieveSockets();
                                    $allSockets = [];
                                    if (is_array($allSocketsData)) {
                                        foreach ($allSocketsData as $thisSocket) {
                                            $allSockets[$thisSocket["socket_id"]] = $thisSocket["seed"];
                                        }
                                    }
                                    if ($allSockets[$socket1] != -1 && ($allSockets[$socket1] == $allSockets[$socket2] || $allSockets[$socket1] == $allSockets[$socket3] || $allSockets[$socket1] == $allSockets[$socket4] || $allSockets[$socket1] == $allSockets[$socket5])) {
                                        $error = true;
                                        $reason = lang("webshop_txt_49", true);
                                    }
                                    if ($allSockets[$socket2] != -1 && ($allSockets[$socket2] == $allSockets[$socket1] || $allSockets[$socket2] == $allSockets[$socket3] || $allSockets[$socket2] == $allSockets[$socket4] || $allSockets[$socket2] == $allSockets[$socket5])) {
                                        $error = true;
                                        $reason = lang("webshop_txt_49", true);
                                    }
                                    if ($allSockets[$socket3] != -1 && ($allSockets[$socket3] == $allSockets[$socket1] || $allSockets[$socket3] == $allSockets[$socket2] || $allSockets[$socket3] == $allSockets[$socket4] || $allSockets[$socket3] == $allSockets[$socket5])) {
                                        $error = true;
                                        $reason = lang("webshop_txt_49", true);
                                    }
                                    if ($allSockets[$socket4] != -1 && ($allSockets[$socket4] == $allSockets[$socket1] || $allSockets[$socket4] == $allSockets[$socket2] || $allSockets[$socket4] == $allSockets[$socket3] || $allSockets[$socket4] == $allSockets[$socket5])) {
                                        $error = true;
                                        $reason = lang("webshop_txt_49", true);
                                    }
                                    if ($allSockets[$socket5] != -1 && ($allSockets[$socket5] == $allSockets[$socket1] || $allSockets[$socket5] == $allSockets[$socket2] || $allSockets[$socket5] == $allSockets[$socket3] || $allSockets[$socket5] == $allSockets[$socket4])) {
                                        $error = true;
                                        $reason = lang("webshop_txt_49", true);
                                    }
                                }
                                if ($itemData["store_count"] == "0") {
                                    $error = true;
                                    $reason = lang("webshop_txt_50", true);
                                }
                                if ($itemData["status"] != "1") {
                                    $error = true;
                                    $reason = lang("webshop_txt_51", true);
                                }
                                if (!$error) {
                                    if (0 < $harmony) {
                                        $harmonyData = $Webshop->loadHarmonyData($harmony);
                                    }
                                    if ($harmonyData["price"] == NULL || empty($harmonyData["price"])) {
                                        $harmonyData["price"] = 0;
                                    }
                                    if (0 <= $socket1 && $socket1 < 255 || 255 < $socket1) {
                                        $socket1Data = $Webshop->loadNormalSocketData($socket1);
                                    }
                                    if (0 <= $socket2 && $socket2 < 255 || 255 < $socket2) {
                                        $socket2Data = $Webshop->loadNormalSocketData($socket2);
                                    }
                                    if (0 <= $socket3 && $socket3 < 255 || 255 < $socket3) {
                                        $socket3Data = $Webshop->loadNormalSocketData($socket3);
                                    }
                                    if (0 <= $socket4 && $socket4 < 255 || 255 < $socket4) {
                                        $socket4Data = $Webshop->loadNormalSocketData($socket4);
                                    }
                                    if (0 <= $socket5 && $socket5 < 255 || 255 < $socket5) {
                                        $socket5Data = $Webshop->loadNormalSocketData($socket5);
                                    }
                                    if (0 <= $socket99 && $socket99 < 255 || 255 < $socket99) {
                                        $socket99Data = $Webshop->loadBonusSocketData($socket99);
                                    }
                                    $hop = 0;
                                    $xl = 0;
                                    $dur = 255;
                                    $harmony_opt = $harmonyData["hoption"];
                                    $harmony_lvl = $harmonyData["hvalue"];
                                    if (0 < $itemData["item_lvl"]) {
                                        $level = $itemData["item_lvl"];
                                    }
                                    if ($luck) {
                                        $hop += 4;
                                    }
                                    if ($skill) {
                                        $hop += 128;
                                    }
                                    if (4 <= $life) {
                                        $hop += $life - 4;
                                        $xl += 64;
                                    } else {
                                        $hop += $life;
                                    }
                                    if (0 < $level) {
                                        $hop += $level * 8;
                                    }
                                    if ($exc1) {
                                        $xl += 1;
                                    }
                                    if ($exc2) {
                                        $xl += 2;
                                    }
                                    if ($exc3) {
                                        $xl += 4;
                                    }
                                    if ($exc4) {
                                        $xl += 8;
                                    }
                                    if ($exc5) {
                                        $xl += 16;
                                    }
                                    if ($exc6) {
                                        $xl += 32;
                                    }
                                    if (0 < $itemData["item_exc"]) {
                                        $xl = $itemData["item_exc"];
                                    }
                                    $serial = $dB->query_fetch_single("exec WZ_GetItemSerial2 1");
                                    $serial = $serial["ItemSerial"];
                                    while (strlen($serial) < 16) {
                                        $serial = "0" . $serial;
                                    }
                                    $serial2 = substr($serial, 0, 8);
                                    $serial = substr($serial, 8, 8);
                                    if (256 <= $itemData["item_id"]) {
                                        $itemData["item_id"] = $itemData["item_id"] - 256;
                                        $xl += 128;
                                    }
                                    if ($itemData["item_cat"] == 12 && (200 <= $itemData["item_id"] && $itemData["item_id"] <= 218 || 306 <= $itemData["item_id"] && $itemData["item_id"] <= 308)) {
                                        $dur = 5;
                                    }
                                    if ($itemData["use_sockets"] == "1") {
                                        if (255 < $socket1) {
                                            $socket1 -= 254;
                                            $stamina += 64;
                                        }
                                        if (255 < $socket2) {
                                            $socket2 -= 254;
                                            $stamina += 16;
                                        }
                                        if (255 < $socket3) {
                                            $socket3 -= 254;
                                            $stamina += 4;
                                        }
                                        if (255 < $socket4) {
                                            $socket4 -= 254;
                                            $stamina += 1;
                                        }
                                        if (255 < $socket5) {
                                            $socket5 -= 254;
                                            $stamina += 0;
                                            $xl += 16;
                                        }
                                    }
                                    $itemhex = "";
                                    $itemhex = sprintf("%02X", $itemData["item_id"], 0);
                                    $itemhex .= sprintf("%02X", $hop, 0);
                                    $itemhex .= sprintf("%02X", $dur, 0);
                                    $itemhex .= sprintf("%08X", $serial2, 0);
                                    $itemhex .= sprintf("%02X", $xl, 0);
                                    $itemhex .= sprintf("%02X", $stamina, 0);
                                    $itemhex .= dechex($itemData["item_cat"]);
                                    if ($refinery) {
                                        $itemhex .= "8";
                                    } else {
                                        $itemhex .= "0";
                                    }
                                    if ($itemData["use_sockets"] == "1") {
                                        $itemhex .= sprintf("%02X", $socket99, 0);
                                    } else {
                                        $itemhex .= dechex($harmony_opt);
                                        if ($itemData["item_cat"] == 12 && (200 <= $itemData["item_id"] && $itemData["item_id"] <= 218 || 306 <= $itemData["item_id"] && $itemData["item_id"] <= 308)) {
                                            $itemhex .= dechex($elementType);
                                        } else {
                                            $itemhex .= dechex($harmony_lvl);
                                        }
                                    }
                                    if ($itemData["use_sockets"] == "1") {
                                        $itemhex .= sprintf("%02X", $socket1, 0);
                                        $itemhex .= sprintf("%02X", $socket2, 0);
                                        $itemhex .= sprintf("%02X", $socket3, 0);
                                        $itemhex .= sprintf("%02X", $socket4, 0);
                                        $itemhex .= sprintf("%02X", $socket5, 0);
                                    } else {
                                        if ($itemData["item_cat"] == 12 && (200 <= $itemData["item_id"] && $itemData["item_id"] <= 218 || 306 <= $itemData["item_id"] && $itemData["item_id"] <= 308)) {
                                            $pentagramUserData = $dB->query_fetch("SELECT * FROM T_PentagramInfo WHERE AccountID = ? AND (Name = ? OR Name = ?) AND JewelPos = ?", [$_SESSION["username"], NULL, "", 1]);
                                            $freeSlots = [];
                                            if (is_array($pentagramUserData)) {
                                                $x = 0;
                                                while ($x <= 253) {
                                                    array_push($freeSlots, $x);
                                                    $x++;
                                                }
                                                $j = 0;
                                                foreach ($pentagramUserData as $thisPentagram) {
                                                    unset($freeSlots[$thisPentagram["JewelIndex"]]);
                                                }
                                                $freeSlots = array_values($freeSlots);
                                            } else {
                                                $freeSlots = [0, 1, 2, 3, 4];
                                                $foundSlots = 5;
                                            }
                                            if (0 <= $freeSlots[0] && $freeSlots[0] <= 253) {
                                                $socket1 = $freeSlots[0];
                                            } else {
                                                $socket1 = 255;
                                            }
                                            if (0 <= $freeSlots[1] && $freeSlots[1] <= 253) {
                                                $socket2 = $freeSlots[1];
                                            } else {
                                                $socket2 = 255;
                                            }
                                            if (0 <= $freeSlots[2] && $freeSlots[2] <= 253) {
                                                $socket3 = $freeSlots[2];
                                            } else {
                                                $socket3 = 255;
                                            }
                                            if (0 <= $freeSlots[3] && $freeSlots[0] <= 253) {
                                                $socket4 = $freeSlots[3];
                                            } else {
                                                $socket4 = 255;
                                            }
                                            if (0 <= $freeSlots[0] && $freeSlots[0] <= 253) {
                                                $socket5 = $freeSlots[4];
                                            } else {
                                                $socket5 = 255;
                                            }
                                            if ($anger1 == 0 && $anger2 == 0 && $anger3 == 0 && $anger4 == 0 && $anger5 == 0) {
                                                $socket1 = 255;
                                            }
                                            if ($blessing1 == 0 && $blessing2 == 0 && $blessing3 == 0 && $blessing4 == 0 && $blessing5 == 0) {
                                                $socket2 = 255;
                                            }
                                            if ($integrity1 == 0 && $integrity2 == 0 && $integrity3 == 0 && $integrity4 == 0 && $integrity5 == 0) {
                                                $socket3 = 255;
                                            }
                                            if ($divinity1 == 0 && $divinity2 == 0 && $divinity3 == 0 && $divinity4 == 0 && $divinity5 == 0) {
                                                $socket4 = 255;
                                            }
                                            if ($gale1 == 0 && $gale2 == 0 && $gale3 == 0 && $gale4 == 0 && $gale5 == 0) {
                                                $socket5 = 255;
                                            }
                                            $itemhex .= sprintf("%02X", $socket1, 0);
                                            $itemhex .= sprintf("%02X", $socket2, 0);
                                            $itemhex .= sprintf("%02X", $socket3, 0);
                                            $itemhex .= sprintf("%02X", $socket4, 0);
                                            $itemhex .= sprintf("%02X", $socket5, 0);
                                        } else {
                                            $itemhex .= "FFFFFFFFFF";
                                        }
                                    }
                                    $itemhex .= sprintf("%08X", $serial, 0);
                                    $itemhex .= "FFFFFFFFFFFFFFFFFFFFFFFF";
                                    $itemhex = strtoupper($itemhex);
                                    $paymentType = htmlspecialchars($_POST["activeCredit"]);
                                    switch ($paymentType) {
                                        case "0":
                                            $paymentType = 1;
                                            break;
                                        case "1":
                                            $paymentType = 2;
                                            break;
                                        case "2":
                                            $paymentType = 4;
                                            break;
                                        default:
                                            $paymentType = 0;
                                            $item_price = $itemData["price"];
                                            $harmony_price = $harmonyData["price"];
                                            $socket1_price = $socket1Data["price"];
                                            $socket2_price = $socket2Data["price"];
                                            $socket3_price = $socket3Data["price"];
                                            $socket4_price = $socket4Data["price"];
                                            $socket5_price = $socket5Data["price"];
                                            $socket99_price = $socket99Data["price"];
                                            $on_sale = $itemData["on_sale"];
                                            $exetype = $itemData["exetype"];
                                            $total_price = $Webshop->computePrice($item_price, $exetype, $level, $life, $luck, $skill, $harmony_price, $refinery, $exc1, $exc2, $exc3, $exc4, $exc5, $exc6, $ancopt, $stamina, $socket1_price, $socket2_price, $socket3_price, $socket4_price, $socket5_price, $socket99_price, $on_sale);
                                            if ($itemData["item_cat"] == 12 && (200 <= $itemData["item_id"] && $itemData["item_id"] <= 218 || 306 <= $itemData["item_id"] && $itemData["item_id"] <= 308)) {
                                                if (0 < $anger1) {
                                                    $total_price += mconfig("element_anger_1_price");
                                                }
                                                if (0 < $anger1lvl) {
                                                    $total_price += $anger1lvl * mconfig("element_anger_1_price_level");
                                                }
                                                if (0 < $anger2) {
                                                    $total_price += mconfig("element_anger_2_price");
                                                }
                                                if (0 < $anger2lvl) {
                                                    $total_price += $anger2lvl * mconfig("element_anger_2_price_level");
                                                }
                                                if (0 < $anger3) {
                                                    $total_price += mconfig("element_anger_3_price");
                                                }
                                                if (0 < $anger3lvl) {
                                                    $total_price += $anger3lvl * mconfig("element_anger_3_price_level");
                                                }
                                                if (0 < $anger4) {
                                                    $total_price += mconfig("element_anger_4_price");
                                                }
                                                if (0 < $anger4lvl) {
                                                    $total_price += $anger4lvl * mconfig("element_anger_4_price_level");
                                                }
                                                if (0 < $anger5) {
                                                    $total_price += mconfig("element_anger_5_price");
                                                }
                                                if (0 < $anger5lvl) {
                                                    $total_price += $anger5lvl * mconfig("element_anger_5_price_level");
                                                }
                                                if (0 < $blessing1) {
                                                    $total_price += mconfig("element_blessing_1_price");
                                                }
                                                if (0 < $blessing1lvl) {
                                                    $total_price += $blessing1lvl * mconfig("element_blessing_1_price_level");
                                                }
                                                if (0 < $blessing2) {
                                                    $total_price += mconfig("element_blessing_2_price");
                                                }
                                                if (0 < $blessing2lvl) {
                                                    $total_price += $blessing2lvl * mconfig("element_blessing_2_price_level");
                                                }
                                                if (0 < $blessing3) {
                                                    $total_price += mconfig("element_blessing_3_price");
                                                }
                                                if (0 < $blessing3lvl) {
                                                    $total_price += $blessing3lvl * mconfig("element_blessing_3_price_level");
                                                }
                                                if (0 < $blessing4) {
                                                    $total_price += mconfig("element_blessing_4_price");
                                                }
                                                if (0 < $blessing4lvl) {
                                                    $total_price += $blessing4lvl * mconfig("element_blessing_4_price_level");
                                                }
                                                if (0 < $blessing5) {
                                                    $total_price += mconfig("element_blessing_5_price");
                                                }
                                                if (0 < $blessing5lvl) {
                                                    $total_price += $blessing5lvl * mconfig("element_blessing_5_price_level");
                                                }
                                                if (0 < $integrity1) {
                                                    $total_price += mconfig("element_integrity_1_price");
                                                }
                                                if (0 < $integrity1lvl) {
                                                    $total_price += $integrity1lvl * mconfig("element_integrity_1_price_level");
                                                }
                                                if (0 < $integrity2) {
                                                    $total_price += mconfig("element_integrity_2_price");
                                                }
                                                if (0 < $integrity2lvl) {
                                                    $total_price += $integrity2lvl * mconfig("element_integrity_2_price_level");
                                                }
                                                if (0 < $integrity3) {
                                                    $total_price += mconfig("element_integrity_3_price");
                                                }
                                                if (0 < $integrity3lvl) {
                                                    $total_price += $integrity3lvl * mconfig("element_integrity_3_price_level");
                                                }
                                                if (0 < $integrity4) {
                                                    $total_price += mconfig("element_integrity_4_price");
                                                }
                                                if (0 < $integrity4lvl) {
                                                    $total_price += $integrity4lvl * mconfig("element_integrity_4_price_level");
                                                }
                                                if (0 < $integrity5) {
                                                    $total_price += mconfig("element_integrity_5_price");
                                                }
                                                if (0 < $integrity5lvl) {
                                                    $total_price += $integrity5lvl * mconfig("element_integrity_5_price_level");
                                                }
                                                if (0 < $divinity1) {
                                                    $total_price += mconfig("element_divinity_1_price");
                                                }
                                                if (0 < $divinity1lvl) {
                                                    $total_price += $divinity1lvl * mconfig("element_divinity_1_price_level");
                                                }
                                                if (0 < $divinity2) {
                                                    $total_price += mconfig("element_divinity_2_price");
                                                }
                                                if (0 < $divinity2lvl) {
                                                    $total_price += $divinity2lvl * mconfig("element_divinity_2_price_level");
                                                }
                                                if (0 < $divinity3) {
                                                    $total_price += mconfig("element_divinity_3_price");
                                                }
                                                if (0 < $divinity3lvl) {
                                                    $total_price += $divinity3lvl * mconfig("element_divinity_3_price_level");
                                                }
                                                if (0 < $divinity4) {
                                                    $total_price += mconfig("element_divinity_4_price");
                                                }
                                                if (0 < $divinity4lvl) {
                                                    $total_price += $divinity4lvl * mconfig("element_divinity_4_price_level");
                                                }
                                                if (0 < $divinity5) {
                                                    $total_price += mconfig("element_divinity_5_price");
                                                }
                                                if (0 < $divinity5lvl) {
                                                    $total_price += $divinity5lvl * mconfig("element_divinity_5_price_level");
                                                }
                                                if (0 < $gale1) {
                                                    $total_price += mconfig("element_gale_1_price");
                                                }
                                                if (0 < $gale1lvl) {
                                                    $total_price += $gale1lvl * mconfig("element_gale_1_price_level");
                                                }
                                                if (0 < $gale2) {
                                                    $total_price += mconfig("element_gale_2_price");
                                                }
                                                if (0 < $gale2lvl) {
                                                    $total_price += $gale2lvl * mconfig("element_gale_2_price_level");
                                                }
                                                if (0 < $gale3) {
                                                    $total_price += mconfig("element_gale_3_price");
                                                }
                                                if (0 < $gale3lvl) {
                                                    $total_price += $gale3lvl * mconfig("element_gale_3_price_level");
                                                }
                                                if (0 < $gale4) {
                                                    $total_price += mconfig("element_gale_4_price");
                                                }
                                                if (0 < $gale4lvl) {
                                                    $total_price += $gale4lvl * mconfig("element_gale_4_price_level");
                                                }
                                                if (0 < $gale5) {
                                                    $total_price += mconfig("element_gale_5_price");
                                                }
                                                if (0 < $gale5lvl) {
                                                    $total_price += $gale5lvl * mconfig("element_gale_5_price_level");
                                                }
                                            }
                                            if (0 < $paymentType) {
                                                switch ($paymentType) {
                                                    case "1":
                                                        $total_price = $total_price * mconfig("price_platinum");
                                                        $queryCheck = "SELECT TOP 1 platinum FROM MEMB_CREDITS WHERE memb___id = ?";
                                                        $currencyName = lang("currency_platinum", true);
                                                        $currencyName2 = "platinum";
                                                        break;
                                                    case "2":
                                                        $total_price = $total_price * mconfig("price_gold");
                                                        $queryCheck = "SELECT TOP 1 gold FROM MEMB_CREDITS WHERE memb___id = ?";
                                                        $currencyName = lang("currency_gold", true);
                                                        $currencyName2 = "gold";
                                                        break;
                                                    case "4":
                                                        $total_price = $total_price * mconfig("price_silver");
                                                        $queryCheck = "SELECT TOP 1 silver FROM MEMB_CREDITS WHERE memb___id = ?";
                                                        $currencyName = lang("currency_silver", true);
                                                        $currencyName2 = "silver";
                                                        break;
                                                }
                                            }
                                            $array = [$_SESSION["username"]];
                                            $total_price = ceil($total_price);
                                            if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                                $currencyCheck = $dB2->query_fetch_single($queryCheck, $array);
                                            } else {
                                                $currencyCheck = $dB->query_fetch_single($queryCheck, $array);
                                            }
                                            if ($currencyCheck[$currencyName2] < $total_price) {
                                                message("error", sprintf(lang("webshop_txt_52", true), $currencyName));
                                            } else {
                                                $buyItem = $Webshop->buyItem($_SESSION["username"], $itemhex, $total_price, $paymentType, $id, $itemData["store_count"]);
                                                if ($itemData["item_cat"] == 12 && (200 <= $itemData["item_id"] && $itemData["item_id"] <= 218 || 306 <= $itemData["item_id"] && $itemData["item_id"] <= 308)) {
                                                    if (0 <= $socket1 && $socket1 <= 253) {
                                                        if ($anger1 == NULL || $anger1 == 0) {
                                                            $anger1 = 15;
                                                            $anger1lvl = 15;
                                                        } else {
                                                            if ($anger1lvl == NULL || 10 < $anger1lvl) {
                                                                $anger1lvl = 0;
                                                            }
                                                        }
                                                        if ($anger2 == NULL || $anger2 == 0) {
                                                            $anger2 = 15;
                                                            $anger2lvl = 15;
                                                        } else {
                                                            if ($anger2lvl == NULL || 10 < $anger2lvl) {
                                                                $anger2lvl = 0;
                                                            }
                                                        }
                                                        if ($anger3 == NULL || $anger3 == 0) {
                                                            $anger3 = 15;
                                                            $anger3lvl = 15;
                                                        } else {
                                                            if ($anger3lvl == NULL || 10 < $anger3lvl) {
                                                                $anger3lvl = 0;
                                                            }
                                                        }
                                                        if ($anger4 == NULL || $anger4 == 0) {
                                                            $anger4 = 15;
                                                            $anger4lvl = 15;
                                                        } else {
                                                            if ($anger4lvl == NULL || 10 < $anger4lvl) {
                                                                $anger4lvl = 0;
                                                            }
                                                        }
                                                        if ($anger5 == NULL || $anger5 == 0) {
                                                            $anger5 = 15;
                                                            $anger5lvl = 15;
                                                        } else {
                                                            if ($anger5lvl == NULL || 10 < $anger5lvl) {
                                                                $anger5lvl = 0;
                                                            }
                                                        }
                                                        $errtelLevel = 0;
                                                        if ($anger5lvl != NULL && $errtelLevel < $anger5lvl) {
                                                            $errtelLevel = $anger5lvl;
                                                        } else {
                                                            if ($anger4lvl != NULL && $errtelLevel < $anger4lvl) {
                                                                $errtelLevel = $anger4lvl;
                                                            } else {
                                                                if ($anger3lvl != NULL && $errtelLevel < $anger3lvl) {
                                                                    $errtelLevel = $anger3lvl;
                                                                } else {
                                                                    if ($anger2lvl != NULL && $errtelLevel < $anger2lvl) {
                                                                        $errtelLevel = $anger2lvl;
                                                                    } else {
                                                                        if ($anger1lvl != NULL && $errtelLevel < $anger1lvl) {
                                                                            $errtelLevel = $anger1lvl;
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                        if ($errtelLevel == 15) {
                                                            $errtelLevel = 0;
                                                        }
                                                        $dB->query("INSERT INTO T_PentagramInfo (UserGuid, AccountID, Name, JewelPos, JewelIndex, ItemType, ItemIndex, MainAttribute, JewelLevel, Rank1, Rank1Level, Rank2, Rank2Level, Rank3, Rank3Level, Rank4, Rank4Level, Rank5, Rank5Level, RegDate) \r\n                                                                                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$_SESSION["userid"], $_SESSION["username"], "", 1, $socket1, 12, 221, $elementType + 16, $errtelLevel, $anger1, $anger1lvl, $anger2, $anger2lvl, $anger3, $anger3lvl, $anger4, $anger4lvl, $anger5, $anger5lvl, date("Y-m-d H:i:s", time())]);
                                                    }
                                                    if (0 <= $socket2 && $socket2 <= 253) {
                                                        if ($blessing1 == NULL || $blessing1 == 0) {
                                                            $blessing1 = 15;
                                                            $blessing1lvl = 15;
                                                        } else {
                                                            if ($blessing1lvl == NULL || 10 < $blessing1lvl) {
                                                                $blessing1lvl = 0;
                                                            }
                                                        }
                                                        if ($blessing2 == NULL || $blessing2 == 0) {
                                                            $blessing2 = 15;
                                                            $blessing2lvl = 15;
                                                        } else {
                                                            if ($blessing2lvl == NULL || 10 < $blessing2lvl) {
                                                                $blessing2lvl = 0;
                                                            }
                                                        }
                                                        if ($blessing3 == NULL || $blessing3 == 0) {
                                                            $blessing3 = 15;
                                                            $blessing3lvl = 15;
                                                        } else {
                                                            if ($blessing3lvl == NULL || 10 < $blessing3lvl) {
                                                                $blessing3lvl = 0;
                                                            }
                                                        }
                                                        if ($blessing4 == NULL || $blessing4 == 0) {
                                                            $blessing4 = 15;
                                                            $blessing4lvl = 15;
                                                        } else {
                                                            if ($blessing4lvl == NULL || 10 < $blessing4lvl) {
                                                                $blessing4lvl = 0;
                                                            }
                                                        }
                                                        if ($blessing5 == NULL || $blessing5 == 0) {
                                                            $blessing5 = 15;
                                                            $blessing5lvl = 15;
                                                        } else {
                                                            if ($blessing5lvl == NULL || 10 < $blessing5lvl) {
                                                                $blessing5lvl = 0;
                                                            }
                                                        }
                                                        $errtelLevel = 0;
                                                        if ($blessing5lvl != NULL && $errtelLevel < $blessing5lvl) {
                                                            $errtelLevel = $blessing5lvl;
                                                        } else {
                                                            if ($blessing4lvl != NULL && $errtelLevel < $blessing4lvl) {
                                                                $errtelLevel = $blessing4lvl;
                                                            } else {
                                                                if ($blessing3lvl != NULL && $errtelLevel < $blessing3lvl) {
                                                                    $errtelLevel = $blessing3lvl;
                                                                } else {
                                                                    if ($blessing2lvl != NULL && $errtelLevel < $blessing2lvl) {
                                                                        $errtelLevel = $blessing2lvl;
                                                                    } else {
                                                                        if ($blessing1lvl != NULL && $errtelLevel < $blessing1lvl) {
                                                                            $errtelLevel = $blessing1lvl;
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                        if ($errtelLevel == 15) {
                                                            $errtelLevel = 0;
                                                        }
                                                        $dB->query("INSERT INTO T_PentagramInfo (UserGuid, AccountID, Name, JewelPos, JewelIndex, ItemType, ItemIndex, MainAttribute, JewelLevel, Rank1, Rank1Level, Rank2, Rank2Level, Rank3, Rank3Level, Rank4, Rank4Level, Rank5, Rank5Level, RegDate) \r\n                                                                                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$_SESSION["userid"], $_SESSION["username"], "", 1, $socket2, 12, 231, $elementType + 16, $errtelLevel, $blessing1, $blessing1lvl, $blessing2, $blessing2lvl, $blessing3, $blessing3lvl, $blessing4, $blessing4lvl, $blessing5, $blessing5lvl, date("Y-m-d H:i:s", time())]);
                                                    }
                                                    if (0 <= $socket3 && $socket3 <= 253) {
                                                        if ($integrity1 == NULL || $integrity1 == 0) {
                                                            $integrity1 = 15;
                                                            $integrity1lvl = 15;
                                                        } else {
                                                            if ($integrity1lvl == NULL || 10 < $integrity1lvl) {
                                                                $integrity1lvl = 0;
                                                            }
                                                        }
                                                        if ($integrity2 == NULL || $integrity2 == 0) {
                                                            $integrity2 = 15;
                                                            $integrity2lvl = 15;
                                                        } else {
                                                            if ($integrity2lvl == NULL || 10 < $integrity2lvl) {
                                                                $integrity2lvl = 0;
                                                            }
                                                        }
                                                        if ($integrity3 == NULL || $integrity3 == 0) {
                                                            $integrity3 = 15;
                                                            $integrity3lvl = 15;
                                                        } else {
                                                            if ($integrity3lvl == NULL || 10 < $integrity3lvl) {
                                                                $integrity3lvl = 0;
                                                            }
                                                        }
                                                        if ($integrity4 == NULL || $integrity4 == 0) {
                                                            $integrity4 = 15;
                                                            $integrity4lvl = 15;
                                                        } else {
                                                            if ($integrity4lvl == NULL || 10 < $integrity4lvl) {
                                                                $integrity4lvl = 0;
                                                            }
                                                        }
                                                        if ($integrity5 == NULL || $integrity5 == 0) {
                                                            $integrity5 = 15;
                                                            $integrity5lvl = 15;
                                                        } else {
                                                            if ($integrity5lvl == NULL || 10 < $integrity5lvl) {
                                                                $integrity5lvl = 0;
                                                            }
                                                        }
                                                        $errtelLevel = 0;
                                                        if ($integrity5lvl != NULL && $errtelLevel < $integrity5lvl) {
                                                            $errtelLevel = $integrity5lvl;
                                                        } else {
                                                            if ($integrity4lvl != NULL && $errtelLevel < $integrity4lvl) {
                                                                $errtelLevel = $integrity4lvl;
                                                            } else {
                                                                if ($integrity3lvl != NULL && $errtelLevel < $integrity3lvl) {
                                                                    $errtelLevel = $integrity3lvl;
                                                                } else {
                                                                    if ($integrity2lvl != NULL && $errtelLevel < $integrity2lvl) {
                                                                        $errtelLevel = $integrity2lvl;
                                                                    } else {
                                                                        if ($integrity1lvl != NULL && $errtelLevel < $integrity1lvl) {
                                                                            $errtelLevel = $integrity1lvl;
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                        if ($errtelLevel == 15) {
                                                            $errtelLevel = 0;
                                                        }
                                                        $dB->query("INSERT INTO T_PentagramInfo (UserGuid, AccountID, Name, JewelPos, JewelIndex, ItemType, ItemIndex, MainAttribute, JewelLevel, Rank1, Rank1Level, Rank2, Rank2Level, Rank3, Rank3Level, Rank4, Rank4Level, Rank5, Rank5Level, RegDate) \r\n                                                                                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$_SESSION["userid"], $_SESSION["username"], "", 1, $socket3, 12, 241, $elementType + 16, $errtelLevel, $integrity1, $integrity1lvl, $integrity2, $integrity2lvl, $integrity3, $integrity3lvl, $integrity4, $integrity4lvl, $integrity5, $integrity5lvl, date("Y-m-d H:i:s", time())]);
                                                    }
                                                    if (0 <= $socket4 && $socket4 <= 253) {
                                                        if ($divinity1 == NULL || $divinity1 == 0) {
                                                            $divinity1 = 15;
                                                            $divinity1lvl = 15;
                                                        } else {
                                                            if ($divinity1lvl == NULL || 10 < $divinity1lvl) {
                                                                $divinity1lvl = 0;
                                                            }
                                                        }
                                                        if ($divinity2 == NULL || $divinity2 == 0) {
                                                            $divinity2 = 15;
                                                            $divinity2lvl = 15;
                                                        } else {
                                                            if ($divinity2lvl == NULL || 10 < $divinity2lvl) {
                                                                $divinity2lvl = 0;
                                                            }
                                                        }
                                                        if ($divinity3 == NULL || $divinity3 == 0) {
                                                            $divinity3 = 15;
                                                            $divinity3lvl = 15;
                                                        } else {
                                                            if ($divinity3lvl == NULL || 10 < $divinity3lvl) {
                                                                $divinity3lvl = 0;
                                                            }
                                                        }
                                                        if ($divinity4 == NULL || $divinity4 == 0) {
                                                            $divinity4 = 15;
                                                            $divinity4lvl = 15;
                                                        } else {
                                                            if ($divinity4lvl == NULL || 10 < $divinity4lvl) {
                                                                $divinity4lvl = 0;
                                                            }
                                                        }
                                                        if ($divinity5 == NULL || $divinity5 == 0) {
                                                            $divinity5 = 15;
                                                            $divinity5lvl = 15;
                                                        } else {
                                                            if ($divinity5lvl == NULL || 10 < $divinity5lvl) {
                                                                $divinity5lvl = 0;
                                                            }
                                                        }
                                                        $errtelLevel = 0;
                                                        if ($divinity5lvl != NULL && $errtelLevel < $divinity5lvl) {
                                                            $errtelLevel = $divinity5lvl;
                                                        } else {
                                                            if ($divinity4lvl != NULL && $errtelLevel < $divinity4lvl) {
                                                                $errtelLevel = $divinity4lvl;
                                                            } else {
                                                                if ($divinity3lvl != NULL && $errtelLevel < $divinity3lvl) {
                                                                    $errtelLevel = $divinity3lvl;
                                                                } else {
                                                                    if ($divinity2lvl != NULL && $errtelLevel < $divinity2lvl) {
                                                                        $errtelLevel = $divinity2lvl;
                                                                    } else {
                                                                        if ($divinity1lvl != NULL && $errtelLevel < $divinity1lvl) {
                                                                            $errtelLevel = $divinity1lvl;
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                        if ($errtelLevel == 15) {
                                                            $errtelLevel = 0;
                                                        }
                                                        $dB->query("INSERT INTO T_PentagramInfo (UserGuid, AccountID, Name, JewelPos, JewelIndex, ItemType, ItemIndex, MainAttribute, JewelLevel, Rank1, Rank1Level, Rank2, Rank2Level, Rank3, Rank3Level, Rank4, Rank4Level, Rank5, Rank5Level, RegDate) \r\n                                                                                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$_SESSION["userid"], $_SESSION["username"], "", 1, $socket4, 12, 251, $elementType + 16, $errtelLevel, $divinity1, $divinity1lvl, $divinity2, $divinity2lvl, $divinity3, $divinity3lvl, $divinity4, $divinity4lvl, $divinity5, $divinity5lvl, date("Y-m-d H:i:s", time())]);
                                                    }
                                                    if (0 <= $socket5 && $socket5 <= 253) {
                                                        if ($gale1 == NULL || $gale1 == 0) {
                                                            $gale1 = 15;
                                                            $gale1lvl = 15;
                                                        } else {
                                                            if ($gale1lvl == NULL || 10 < $gale1lvl) {
                                                                $gale1lvl = 0;
                                                            }
                                                        }
                                                        if ($gale2 == NULL || $gale2 == 0) {
                                                            $gale2 = 15;
                                                            $gale2lvl = 15;
                                                        } else {
                                                            if ($gale2lvl == NULL || 10 < $gale2lvl) {
                                                                $gale2lvl = 0;
                                                            }
                                                        }
                                                        if ($gale3 == NULL || $gale3 == 0) {
                                                            $gale3 = 15;
                                                            $gale3lvl = 15;
                                                        } else {
                                                            if ($gale3lvl == NULL || 10 < $gale3lvl) {
                                                                $gale3lvl = 0;
                                                            }
                                                        }
                                                        if ($gale4 == NULL || $gale4 == 0) {
                                                            $gale4 = 15;
                                                            $gale4lvl = 15;
                                                        } else {
                                                            if ($gale4lvl == NULL || 10 < $gale4lvl) {
                                                                $gale4lvl = 0;
                                                            }
                                                        }
                                                        if ($gale5 == NULL || $gale5 == 0) {
                                                            $gale5 = 15;
                                                            $gale5lvl = 15;
                                                        } else {
                                                            if ($gale5lvl == NULL || 10 < $gale5lvl) {
                                                                $gale5lvl = 0;
                                                            }
                                                        }
                                                        $errtelLevel = 0;
                                                        if ($gale5lvl != NULL && $errtelLevel < $gale5lvl) {
                                                            $errtelLevel = $gale5lvl;
                                                        } else {
                                                            if ($gale4lvl != NULL && $errtelLevel < $gale4lvl) {
                                                                $errtelLevel = $gale4lvl;
                                                            } else {
                                                                if ($gale3lvl != NULL && $errtelLevel < $gale3lvl) {
                                                                    $errtelLevel = $gale3lvl;
                                                                } else {
                                                                    if ($gale2lvl != NULL && $errtelLevel < $gale2lvl) {
                                                                        $errtelLevel = $gale2lvl;
                                                                    } else {
                                                                        if ($gale1lvl != NULL && $errtelLevel < $gale1lvl) {
                                                                            $errtelLevel = $gale1lvl;
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                        if ($errtelLevel == 15) {
                                                            $errtelLevel = 0;
                                                        }
                                                        $dB->query("INSERT INTO T_PentagramInfo (UserGuid, AccountID, Name, JewelPos, JewelIndex, ItemType, ItemIndex, MainAttribute, JewelLevel, Rank1, Rank1Level, Rank2, Rank2Level, Rank3, Rank3Level, Rank4, Rank4Level, Rank5, Rank5Level, RegDate) \r\n                                                                                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$_SESSION["userid"], $_SESSION["username"], "", 1, $socket5, 12, 261, $elementType + 16, $errtelLevel, $gale1, $gale1lvl, $gale2, $gale2lvl, $gale3, $gale3lvl, $gale4, $gale4lvl, $gale5, $gale5lvl, date("Y-m-d H:i:s", time())]);
                                                    }
                                                }
                                                if ($buyItem) {
                                                    message("success", lang("webshop_txt_53", true));
                                                    $Webshop->addLog($_SESSION["username"], $itemhex, $total_price, $paymentType, "normal");
                                                    $logDate = date("Y-m-d H:i:s", time());
                                                    $common->accountLogs($_SESSION["username"], "webshop", sprintf(lang("webshop_txt_54", true), $total_price, $currencyName, $itemhex), $logDate);
                                                } else {
                                                    message("error", lang("error_23", true));
                                                }
                                            }
                                    }
                                } else {
                                    message("error", $reason);
                                }
                            } else {
                                if (isset($_POST["gift"]) && mconfig("is_gift")) {
                                    if (isset($_POST["sendgift"])) {
                                        echo "confirmed";
                                    } else {
                                        echo "\r\n              <form method=\"post\" action=\"\">\r\n\r\n                <div class=\"row\">\r\n                  <label for=\"username\">" . lang("webshop_txt_55", true) . "</label>\r\n                  <input type=\"text\" name=\"username\">\r\n                </div>\r\n                <div class=\"row\">\r\n                  <div style=\"width:100%;\" align=\"right\">\r\n                    <input type=\"hidden\" name=\"gift\">\r\n                    <input type=\"submit\" name=\"sendgift\" value=\"" . lang("webshop_txt_56", true) . "\">\r\n                  </div>\r\n                </div>\r\n              </form>\r\n              ";
                                    }
                                } else {
                                    $itemData = $Webshop->loadItemData($id);
                                    $opts = $Webshop->getExcOpts($id);
                                    $anc = $Webshop->isAncient($id);
                                    $payments = $Webshop->loadPayments($id, "IMPERIAMUCMS_WEBSHOP");
                                    if ($payments["platinum"]) {
                                        $activeCredit = 0;
                                    } else {
                                        if ($payments["gold"]) {
                                            $activeCredit = 1;
                                        } else {
                                            $activeCredit = 2;
                                        }
                                    }
                                    echo "<script type=\"text/javascript\">\r\n                    var creditType = [];\r\n                    creditType[0] = { name:\"" . lang("currency_platinum", true) . "\", ratio:" . mconfig("price_platinum") . " };\r\n                    creditType[1] = { name:\"" . lang("currency_gold", true) . "\", ratio:" . mconfig("price_gold") . " };\r\n                    creditType[2] = { name:\"" . lang("currency_silver", true) . "\", ratio:" . mconfig("price_silver") . " };\r\n\r\n                    var maxSocket = " . mconfig("max_socket") . ";\r\n                    var maxExcOpt = " . mconfig("max_exc_opt") . ";\r\n                    var ancHarm = " . mconfig("anc_harm") . ";\r\n                    var ancExc = " . mconfig("anc_exc") . ";\r\n                    var allowSameSocket = " . mconfig("allow_same_socket") . ";                    \r\n                    var activeRatio = creditType[" . $activeCredit . "][\"ratio\"];\r\n\r\n                    \$(document).ready(function()\r\n                    {\r\n                      InitItemForm(" . $activeCredit . ");\r\n                    });\r\n                  </script>";
                                    echo "\r\n            <div class=\"pay_wp\" style=\"display:block;\">\r\n            <form name=\"frmItem\" id=\"frmItem\" method=\"post\">\r\n              <div class=\"webshop-title\">\r\n                <div id=\"title\">\r\n                  <h1>" . $itemData["name"] . "<p></p><span></span></h1>\r\n                </div>\r\n              </div>\r\n          \t\t<div class=\"currency-cats\">";
                                    $platinum = false;
                                    $gold = false;
                                    $silver = false;
                                    if ($payments["platinum"]) {
                                        echo "<a class=\"btn_type4 on\" id=\"btnPlatinum\">" . lang("currency_platinum", true) . " <p>" . lang("webshop_txt_57", true) . "</p></a>";
                                        $platinum = true;
                                    }
                                    if ($payments["gold"] && !$platinum) {
                                        echo "<a class=\"btn_type4 on\" id=\"btnGold\">" . lang("currency_gold", true) . " <p>" . lang("webshop_txt_58", true) . "</p></a>";
                                        $gold = true;
                                    } else {
                                        if ($payments["gold"]) {
                                            echo "<a class=\"btn_type4\" id=\"btnGold\">" . lang("currency_gold", true) . " <p>" . lang("webshop_txt_58", true) . "</p></a>";
                                            $gold = true;
                                        }
                                    }
                                    if ($payments["silver"] && !$platinum && !$gold) {
                                        echo "<a class=\"btn_type4 on\" id=\"btnSilver\">" . lang("currency_silver", true) . " <p>" . lang("webshop_txt_59", true) . "</p></a>";
                                    } else {
                                        if ($payments["silver"]) {
                                            echo "<a class=\"btn_type4\" id=\"btnSilver\">" . lang("currency_silver", true) . " <p>" . lang("webshop_txt_59", true) . "</p></a>";
                                        }
                                    }
                                    echo "\r\n                  <div class=\"clear\"></div>\r\n                </div>\r\n                <ul class=\"desc\" id=\"coin_c_msg\">\r\n                  <li>" . $itemData["description"] . "</li>\r\n          \t\t\t</ul>\r\n                <div class=\"itemsel\">";
                                    if (!$is_global) {
                                        if (0 < $itemData["max_item_lvl"]) {
                                            echo "\r\n                    <div class=\"seperator\"></div>\r\n                      <div class=\"row\">\r\n                        <label for=\"level\">" . lang("webshop_txt_60", true) . "\r\n                          <span class=\"opt_prt\" id=\"dOptionLevelCoinC\" style=\"display: none;\">+ " . mconfig("level") . "</span>\r\n                          <div id=\"dOptionLevelBit\" style=\"display:none;\">" . mconfig("level") . "</div>\r\n                        </label>\r\n                        <select name=\"level\" styled=\"true\" id=\"dOptionLevel\" style=\"display: none;\" tabindex=\"1\">";
                                            $i = 0;
                                            while ($i <= $itemData["max_item_lvl"]) {
                                                echo "<option value=\"" . $i . "\">+" . $i . "</option>";
                                                $i++;
                                            }
                                            echo "\r\n                        </select>\r\n                      </div>\r\n                      ";
                                        }
                                        if (0 < $itemData["max_item_opt"]) {
                                            echo "\r\n                      <div class=\"row\">\r\n                        <label for=\"life\">" . lang("webshop_txt_61", true) . "\r\n                          <span class=\"opt_prt\" id=\"dOptionLifeCoinC\" style=\"display: none;\">+ " . mconfig("life") . "</span>\r\n                          <div id=\"dOptionLifeBit\" style=\"display:none;\">" . mconfig("life") . "</div>\r\n                        </label>\r\n                        <select name=\"life\" styled=\"true\" id=\"dOptionLife\" style=\"display: none;\" tabindex=\"2\">";
                                            $i = 0;
                                            while ($i <= $itemData["max_item_opt"]) {
                                                echo "<option value=\"" . $i . "\">" . $opts["life"] . " +" . $i * 4 . "</option>";
                                                $i++;
                                            }
                                            echo "\r\n                        </select>\r\n                      </div>\r\n                      ";
                                        }
                                    } else {
                                        if (0 < $itemData["max_item_lvl"] && 0 < $max_lvl) {
                                            echo "\r\n                      <div class=\"row\">\r\n                        <label for=\"level\">" . lang("webshop_txt_60", true) . "\r\n                          <span class=\"opt_prt\" id=\"dOptionLevelCoinC\" style=\"display: none;\">+ " . mconfig("level") . "</span>\r\n                          <div id=\"dOptionLevelBit\" style=\"display:none;\">" . mconfig("level") . "</div>\r\n                        </label>\r\n                        <select name=\"level\" styled=\"true\" id=\"dOptionLevel\" style=\"display: none;\" tabindex=\"1\">";
                                            $i = 0;
                                            while ($i <= $max_lvl) {
                                                echo "<option value=\"" . $i . "\">+" . $i . "</option>";
                                                $i++;
                                            }
                                            echo "\r\n                        </select>\r\n                      </div>\r\n                      ";
                                        }
                                        if (0 < $itemData["max_item_opt"] && 0 < $max_life_opt) {
                                            echo "\r\n                      <div class=\"row\">\r\n                        <label for=\"life\">" . lang("webshop_txt_61", true) . "\r\n                          <span class=\"opt_prt\" id=\"dOptionLifeCoinC\" style=\"display: none;\">+ " . mconfig("life") . "</span>\r\n                          <div id=\"dOptionLifeBit\" style=\"display:none;\">" . mconfig("life") . "</div>\r\n                        </label>\r\n                        <select name=\"life\" styled=\"true\" id=\"dOptionLife\" style=\"display: none;\" tabindex=\"2\">";
                                            $i = 0;
                                            while ($i <= $max_life_opt) {
                                                echo "<option value=\"" . $i . "\">" . $opts["life"] . " +" . $i * 4 . "</option>";
                                                $i++;
                                            }
                                            echo "\r\n                        </select>\r\n                      </div>\r\n                      ";
                                        }
                                    }
                                    if ($itemData["luck"] == "1") {
                                        echo "<div class=\"seperator\"></div>";
                                        echo "\r\n                    <div class=\"row\">\r\n                      <label for=\"luck\">" . lang("webshop_txt_62", true) . "\r\n                        <span class=\"opt_prt\" id=\"dOptionLuckCoinC\" style=\"display: none;\">+ " . mconfig("luck") . "</span>\r\n                        <div id=\"dOptionLuckBit\" style=\"display:none;\">" . mconfig("luck") . "</div>\r\n                      </label>\r\n                      <label class=\"label_check webshop\">\r\n                        <div></div>\r\n                        <input type=\"checkbox\" name=\"luck\" id=\"dOptionLuck\" class=\"chk\">\r\n                        <p></p>\r\n                      </label>\r\n                    </div>\r\n                    ";
                                    }
                                    if ($itemData["skill"] == "1") {
                                        echo "\r\n                    <div class=\"row\">\r\n                      <label for=\"skill\">" . lang("webshop_txt_63", true) . "\r\n                        <span class=\"opt_prt\" id=\"dOptionSkillCoinC\" style=\"display: none;\">+ " . mconfig("skill") . "</span>\r\n                        <div id=\"dOptionSkillBit\" style=\"display:none;\">" . mconfig("skill") . "</div>\r\n                      </label>\r\n                      <label class=\"label_check webshop\">\r\n                        <div></div>\r\n                        <input type=\"checkbox\" name=\"skill\" id=\"dOptionSkill\" class=\"chk\">\r\n                        <p></p>\r\n                      </label>\r\n                    </div>\r\n                    ";
                                    }
                                    if ($is_anc && (0 < $anc["anc1"] || 0 < $anc["anc2"])) {
                                        echo "\r\n                <div class=\"seperator\"></div>\r\n                  <div class=\"row\">\r\n                    <label for=\"ancopt\">" . lang("webshop_txt_64", true) . "</label>\r\n                    <select name=\"ancopt\" styled=\"true\" id=\"ancopt\" style=\"display: none;\" tabindex=\"5\">\r\n                      <option value=\"\">" . lang("webshop_txt_65", true) . "</option>";
                                        if (0 < $anc["anc1"]) {
                                            $anc_data1 = $Webshop->getAncData($anc["anc1"]);
                                            $ancClass1 = $anc_data1["tier"] == 2 ? "anc12" : "anc11";
                                            echo "<option value=\"" . $anc["anc1"] . "\" class=\"" . $ancClass1 . "\">" . $anc_data1["ancient_name"] . "</option>";
                                        }
                                        if (0 < $anc["anc2"]) {
                                            $anc_data2 = $Webshop->getAncData($anc["anc2"]);
                                            $ancClass2 = $anc_data2["tier"] == 2 ? "anc22" : "anc21";
                                            echo "<option value=\"" . $anc["anc2"] . "\" class=\"" . $ancClass2 . "\">" . $anc_data2["ancient_name"] . "</option>";
                                        }
                                        echo "\r\n                    </select>\r\n                  </div>\r\n                  ";
                                        echo "\r\n                  <div class=\"row\">\r\n                    <label for=\"stamina\">" . lang("webshop_txt_66", true) . "\r\n                      <span class=\"opt_prt\" id=\"staminaCoinC\" style=\"display: none;\"></span>\r\n                      <div id=\"anc11\" style=\"display:none;\">" . mconfig("anc11") . "</div>\r\n                      <div id=\"anc12\" style=\"display:none;\">" . mconfig("anc12") . "</div>\r\n                      <div id=\"anc21\" style=\"display:none;\">" . mconfig("anc21") . "</div>\r\n                      <div id=\"anc22\" style=\"display:none;\">" . mconfig("anc22") . "</div>\r\n                    </label>\r\n                    <select name=\"stamina\" styled=\"true\" id=\"stamina\" style=\"display: none;\" tabindex=\"6\">\r\n                      <option value=\"\">" . lang("webshop_txt_65", true) . "</option>\r\n                    </select>\r\n                  </div>\r\n                  ";
                                        echo "<div class=\"seperator\"></div>";
                                    }
                                    if (!$itemData["use_sockets"] || mconfig("sock_exc")) {
                                        $exc = "exc" . $opts["exetype"];
                                        if ($opts["exc1"] != NULL || !empty($opts["exc1"])) {
                                            echo "\r\n                    <div class=\"seperator\"></div>\r\n                    <div class=\"row\">\r\n                      <label for=\"exc1\">" . $opts["exc1"] . ":\r\n                        <span class=\"opt_prt\" id=\"pOption1CoinC\" style=\"display:none;\">+ " . mconfig($exc . "1") . "</span>\r\n                        <div id=\"pOption1Bit\" style=\"display:none;\">" . mconfig($exc . "1") . "</div>\r\n                      </label>\r\n                      <label class=\"label_check webshop\">\r\n                        <div></div>\r\n                        <input type=\"checkbox\" name=\"exc1\" id=\"pOption1\" class=\"chk excOpt\">\r\n                        <p></p>\r\n                      </label>\r\n                    </div>\r\n                    ";
                                        }
                                        if ($opts["exc2"] != NULL || !empty($opts["exc2"])) {
                                            echo "\r\n                    <div class=\"row\">\r\n                      <label for=\"exc2\">" . $opts["exc2"] . ":\r\n                        <span class=\"opt_prt\" id=\"pOption2CoinC\" style=\"display:none;\">+ " . mconfig($exc . "2") . "</span>\r\n                        <div id=\"pOption2Bit\" style=\"display:none;\">" . mconfig($exc . "2") . "</div>\r\n                      </label>\r\n                      <label class=\"label_check webshop\">\r\n                        <div></div>\r\n                        <input type=\"checkbox\" name=\"exc2\" id=\"pOption2\" class=\"chk excOpt\">\r\n                        <p></p>\r\n                      </label>\r\n                    </div>\r\n                    ";
                                        }
                                        if ($opts["exc3"] != NULL || !empty($opts["exc3"])) {
                                            echo "\r\n                    <div class=\"row\">\r\n                      <label for=\"exc3\">" . $opts["exc3"] . ":\r\n                        <span class=\"opt_prt\" id=\"pOption3CoinC\" style=\"display:none;\">+ " . mconfig($exc . "3") . "</span>\r\n                        <div id=\"pOption3Bit\" style=\"display:none;\">" . mconfig($exc . "3") . "</div>\r\n                      </label>\r\n                      <label class=\"label_check webshop\">\r\n                        <div></div>\r\n                        <input type=\"checkbox\" name=\"exc3\" id=\"pOption3\" class=\"chk excOpt\">\r\n                        <p></p>\r\n                      </label>\r\n                    </div>\r\n                    ";
                                        }
                                        if ($opts["exc4"] != NULL || !empty($opts["exc4"])) {
                                            echo "\r\n                    <div class=\"row\">\r\n                      <label for=\"exc4\">" . $opts["exc4"] . ":\r\n                        <span class=\"opt_prt\" id=\"pOption4CoinC\" style=\"display:none;\">+ " . mconfig($exc . "4") . "</span>\r\n                        <div id=\"pOption4Bit\" style=\"display:none;\">" . mconfig($exc . "4") . "</div>\r\n                      </label>\r\n                      <label class=\"label_check webshop\">\r\n                        <div></div>\r\n                        <input type=\"checkbox\" name=\"exc4\" id=\"pOption4\" class=\"chk excOpt\">\r\n                        <p></p>\r\n                      </label>\r\n                    </div>\r\n                    ";
                                        }
                                        if ($opts["exc5"] != NULL || !empty($opts["exc5"])) {
                                            echo "\r\n                    <div class=\"row\">\r\n                      <label for=\"exc5\">" . $opts["exc5"] . ":\r\n                        <span class=\"opt_prt\" id=\"pOption5CoinC\" style=\"display:none;\">+ " . mconfig($exc . "5") . "</span>\r\n                        <div id=\"pOption5Bit\" style=\"display:none;\">" . mconfig($exc . "5") . "</div>\r\n                      </label>\r\n                      <label class=\"label_check webshop\">\r\n                        <div></div>\r\n                        <input type=\"checkbox\" name=\"exc5\" id=\"pOption5\" class=\"chk excOpt\">\r\n                        <p></p>\r\n                      </label>\r\n                    </div>\r\n                    ";
                                        }
                                        if ($opts["exc6"] != NULL || !empty($opts["exc6"])) {
                                            echo "\r\n                    <div class=\"row\">\r\n                      <label for=\"exc6\">" . $opts["exc6"] . ":\r\n                        <span class=\"opt_prt\" id=\"pOption6CoinC\" style=\"display:none;\">+ " . mconfig($exc . "6") . "</span>\r\n                        <div id=\"pOption6Bit\" style=\"display:none;\">" . mconfig($exc . "6") . "</div>\r\n                      </label>\r\n                      <label class=\"label_check webshop\">\r\n                        <div></div>\r\n                        <input type=\"checkbox\" name=\"exc6\" id=\"pOption6\" class=\"chk excOpt\">\r\n                        <p></p>\r\n                      </label>\r\n                    </div>\r\n                    ";
                                        }
                                    }
                                    if ($is_refinery && $itemData["use_refinary"] == "1") {
                                        echo "\r\n                <div class=\"seperator\"></div>\r\n                  <div class=\"row\">\r\n                    <label for=\"refinery\">" . lang("webshop_txt_67", true) . "\r\n                      <span class=\"opt_prt\" id=\"pOption380CoinC\" style=\"display: none;\">+ " . mconfig("refin") . "</span>\r\n                      <div id=\"pOption380Bit\" style=\"display:none;\">" . mconfig("refin") . "</div>\r\n                    </label>\r\n                    <label class=\"label_check webshop\">\r\n                      <div></div>\r\n                      <input type=\"checkbox\" name=\"refinery\" id=\"pOption380\" class=\"chk\">\r\n                      <p></p>\r\n                    </label>\r\n                  </div>\r\n                  ";
                                    }
                                    if (!$itemData["use_sockets"] || mconfig("sock_harm")) {
                                        if ($is_harmony && $itemData["use_harmony"] == "1") {
                                            $harmony = [];
                                            $dbHarmony = $Webshop->getHarmony($itemData["item_cat"]);
                                            foreach ($dbHarmony as $h) {
                                                $harmony[$h["hoption"]][$h["id"]]["hvalue"] = $h["hvalue"];
                                                $harmony[$h["hoption"]][$h["id"]]["name"] = $h["hname"];
                                                $harmony[$h["hoption"]][$h["id"]]["price"] = $h["price"];
                                                $harmony_options .= "<option value=\"" . $h["id"] . "\">" . $h["hname"] . "</option>";
                                            }
                                            echo "<script type=\"text/javascript\">\r\n                          var harmony = " . json_encode($harmony) . ";\r\n                          </script>";
                                            echo "\r\n                    <div class=\"seperator\"></div>\r\n                    <div class=\"row\">\r\n                      <label for=\"harmony\">" . lang("webshop_txt_68", true) . "\r\n                        <span class=\"opt_prt\" id=\"harmonyCoinC\" style=\"display: none;\"></span>\r\n                      </label>\r\n                      <select name=\"harmony\" styled=\"true\" id=\"harmony\" style=\"display: none;\" tabindex=\"14\">\r\n                        <option value=\"\">" . lang("webshop_txt_65", true) . "</option>\r\n                      </select>\r\n                    </div>\r\n                    ";
                                        }
                                    }
                                    if ($is_socket && $itemData["use_sockets"] == "1") {
                                        echo "<div class=\"seperator\"></div>";
                                        $socket_options = "";
                                        $sockets = [];
                                        $bonusSockets = [];
                                        $dbSockets = $Webshop->getSockets($itemData["item_cat"]);
                                        $dbBonusSockets = $Webshop->getBonusSockets($itemData["item_cat"]);
                                        foreach ($dbSockets as $s) {
                                            $sockets[$s["socket_id"]]["id"] = $s["id"];
                                            $sockets[$s["socket_id"]]["price"] = $s["price"];
                                            $sockets[$s["socket_id"]]["type"] = $s["seed"];
                                            if ($s["socket_id"] == "254") {
                                                $socket_options .= "<option value=\"" . $s["socket_id"] . "\">" . lang($s["socket_name_lang"], true) . "</option>";
                                            } else {
                                                $socket_options .= "<option value=\"" . $s["socket_id"] . "\">" . sprintf(lang($s["socket_name_lang"], true), $s["socket_lvl"], $s["socket_value"]) . "</option>";
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
                                            $bonusSocket_options .= "<option value=\"" . $s["socket_id"] . "\">" . sprintf(lang($s["socket_name_lang"], true), lang($socketBonusLvl, true), $s["socket_value"]) . "</option>";
                                        }
                                        echo "<script type=\"text/javascript\">\r\n                        var sockets = " . json_encode($sockets) . ";\r\n                        var bsockets = " . json_encode($bonusSockets) . ";\r\n                        </script>";
                                        $i = 1;
                                        while ($i <= mconfig("max_socket")) {
                                            $index = 14 + $i;
                                            echo "\r\n                    <div class=\"row\">\r\n                      <label for=\"socket" . $i . "\">" . lang("webshop_txt_69", true) . " " . $i . ":\r\n                        <span class=\"opt_prt\" id=\"socket" . $i . "CoinC\" style=\"display: none;\"></span>\r\n                      </label>\r\n                      <select name=\"socket" . $i . "\" styled=\"true\" id=\"socket" . $i . "\" style=\"display: none;\" tabindex=\"" . $index . "\">\r\n                        <option value=\"\">" . lang("webshop_txt_65", true) . "</option>\r\n                        " . $socket_options . "\r\n                      </select>\r\n                    </div>\r\n                    ";
                                            $i++;
                                        }
                                        if (mconfig("allow_bonus_socket")) {
                                            echo "\r\n                    <div class=\"row\">\r\n                      <label for=\"socket99\">" . lang("webshop_txt_94", true) . ":\r\n                        <span class=\"opt_prt\" id=\"socket99CoinC\" style=\"display: none;\"></span>\r\n                      </label>\r\n                      <select name=\"socket99\" styled=\"true\" id=\"socket99\" style=\"display: none;\" tabindex=\"22\">\r\n                        <option value=\"\">" . lang("webshop_txt_65", true) . "</option>\r\n                        " . $bonusSocket_options . "\r\n                      </select>\r\n                    </div>\r\n                    ";
                                        }
                                        echo "<div class=\"seperator\"></div>";
                                    }
                                    if ($sub == 33 && $itemData["item_cat"] == 12 && (200 <= $itemData["item_id"] && $itemData["item_id"] <= 218 || 306 <= $itemData["item_id"] && $itemData["item_id"] <= 308)) {
                                        $elementTypes = $Webshop->elementalTypes();
                                        $elementOptions = $Webshop->elementalOptions();
                                        $elementValues = $Webshop->elementalOptionsValues();
                                        $elementTypesOpts = "";
                                        foreach ($elementTypes as $key => $thisType) {
                                            $elementTypesOpts .= "<option value=\"" . $key . "\">" . $thisType . "</option>";
                                        }
                                        echo "\r\n                    <div class=\"row\">\r\n                      <label for=\"element\">Element Type:\r\n                        <span class=\"opt_prt\" id=\"elementCoinC\" style=\"display: none;\"></span>\r\n                      </label>\r\n                      <select name=\"element\" styled=\"true\" id=\"element\" style=\"display: none;\" tabindex=\"" . $index . "\">\r\n                        " . $elementTypesOpts . "\r\n                      </select>\r\n                    </div>";
                                        $blessing5 = "";
                                        $anger2 = "";
                                        $anger3 = "";
                                        $anger4 = "";
                                        $anger5 = "";
                                        $blessing1 = "";
                                        $blessing2 = "";
                                        $blessing3 = "";
                                        $blessing4 = "";
                                        $blessing5 = "";
                                        $integrity1 = "";
                                        $integrity2 = "";
                                        $integrity3 = "";
                                        $integrity4 = "";
                                        $integrity5 = "";
                                        $divinity1 = "";
                                        $divinity2 = "";
                                        $divinity3 = "";
                                        $divinity4 = "";
                                        $divinity5 = "";
                                        $gale1 = "";
                                        $gale2 = "";
                                        $gale3 = "";
                                        $gale4 = "";
                                        $gale5 = "";
                                        $anger1lvl = "";
                                        $anger2lvl = "";
                                        $anger3lvl = "";
                                        $anger4lvl = "";
                                        $anger5lvl = "";
                                        $blessing1lvl = "";
                                        $blessing2lvl = "";
                                        $blessing3lvl = "";
                                        $blessing4lvl = "";
                                        $blessing5lvl = "";
                                        $integrity1lvl = "";
                                        $integrity2lvl = "";
                                        $integrity3lvl = "";
                                        $integrity4lvl = "";
                                        $integrity5lvl = "";
                                        $divinity1lvl = "";
                                        $divinity2lvl = "";
                                        $divinity3lvl = "";
                                        $divinity4lvl = "";
                                        $divinity5lvl = "";
                                        $gale1lvl = "";
                                        $gale2lvl = "";
                                        $gale3lvl = "";
                                        $gale4lvl = "";
                                        $gale5lvl = "";
                                        foreach ($elementValues as $key => $thisValue) {
                                            if ($key == "anger") {
                                                foreach ($thisValue as $id => $anger) {
                                                    switch ($id) {
                                                        case 1:
                                                            foreach ($anger as $index => $value) {
                                                                if ($index <= mconfig("element_anger_1_maxlvl")) {
                                                                    $anger1lvl .= "<option value=\"" . $index . "\">" . $value . "</option>";
                                                                }
                                                            }
                                                            break;
                                                        case 2:
                                                            foreach ($anger as $index => $value) {
                                                                if ($index <= mconfig("element_anger_2_maxlvl")) {
                                                                    $anger2lvl .= "<option value=\"" . $index . "\">" . $value . "</option>";
                                                                }
                                                            }
                                                            break;
                                                        case 3:
                                                            foreach ($anger as $index => $value) {
                                                                if ($index <= mconfig("element_anger_3_maxlvl")) {
                                                                    $anger3lvl .= "<option value=\"" . $index . "\">" . $value . "</option>";
                                                                }
                                                            }
                                                            break;
                                                        case 4:
                                                            foreach ($anger as $index => $value) {
                                                                if ($index <= mconfig("element_anger_4_maxlvl")) {
                                                                    $anger4lvl .= "<option value=\"" . $index . "\">" . $value . "</option>";
                                                                }
                                                            }
                                                            break;
                                                        case 5:
                                                            foreach ($anger as $index => $value) {
                                                                if ($index <= mconfig("element_anger_5_maxlvl")) {
                                                                    $anger5lvl .= "<option value=\"" . $index . "\">" . $value . "</option>";
                                                                }
                                                            }
                                                            break;
                                                    }
                                                }
                                            } else {
                                                if ($key == "blessing") {
                                                    foreach ($thisValue as $id => $blessing) {
                                                        switch ($id) {
                                                            case 1:
                                                                foreach ($blessing as $index => $value) {
                                                                    if ($index <= mconfig("element_blessing_1_maxlvl")) {
                                                                        $blessing1lvl .= "<option value=\"" . $index . "\">" . $value . "</option>";
                                                                    }
                                                                }
                                                                break;
                                                            case 2:
                                                                foreach ($blessing as $index => $value) {
                                                                    if ($index <= mconfig("element_blessing_2_maxlvl")) {
                                                                        $blessing2lvl .= "<option value=\"" . $index . "\">" . $value . "</option>";
                                                                    }
                                                                }
                                                                break;
                                                            case 3:
                                                                foreach ($blessing as $index => $value) {
                                                                    if ($index <= mconfig("element_blessing_3_maxlvl")) {
                                                                        $blessing3lvl .= "<option value=\"" . $index . "\">" . $value . "</option>";
                                                                    }
                                                                }
                                                                break;
                                                            case 4:
                                                                foreach ($blessing as $index => $value) {
                                                                    if ($index <= mconfig("element_blessing_4_maxlvl")) {
                                                                        $blessing4lvl .= "<option value=\"" . $index . "\">" . $value . "</option>";
                                                                    }
                                                                }
                                                                break;
                                                            case 5:
                                                                foreach ($blessing as $index => $value) {
                                                                    if ($index <= mconfig("element_blessing_5_maxlvl")) {
                                                                        $blessing5lvl .= "<option value=\"" . $index . "\">" . $value . "</option>";
                                                                    }
                                                                }
                                                                break;
                                                        }
                                                    }
                                                } else {
                                                    if ($key == "integrity") {
                                                        foreach ($thisValue as $id => $integrity) {
                                                            switch ($id) {
                                                                case 1:
                                                                    foreach ($integrity as $index => $value) {
                                                                        if ($index <= mconfig("element_integrity_1_maxlvl")) {
                                                                            $integrity1lvl .= "<option value=\"" . $index . "\">" . $value . "</option>";
                                                                        }
                                                                    }
                                                                    break;
                                                                case 2:
                                                                    foreach ($integrity as $index => $value) {
                                                                        if ($index <= mconfig("element_integrity_2_maxlvl")) {
                                                                            $integrity2lvl .= "<option value=\"" . $index . "\">" . $value . "</option>";
                                                                        }
                                                                    }
                                                                    break;
                                                                case 3:
                                                                    foreach ($integrity as $index => $value) {
                                                                        if ($index <= mconfig("element_integrity_3_maxlvl")) {
                                                                            $integrity3lvl .= "<option value=\"" . $index . "\">" . $value . "</option>";
                                                                        }
                                                                    }
                                                                    break;
                                                                case 4:
                                                                    foreach ($integrity as $index => $value) {
                                                                        if ($index <= mconfig("element_integrity_4_maxlvl")) {
                                                                            $integrity4lvl .= "<option value=\"" . $index . "\">" . $value . "</option>";
                                                                        }
                                                                    }
                                                                    break;
                                                                case 5:
                                                                    foreach ($integrity as $index => $value) {
                                                                        if ($index <= mconfig("element_integrity_5_maxlvl")) {
                                                                            $integrity5lvl .= "<option value=\"" . $index . "\">" . $value . "</option>";
                                                                        }
                                                                    }
                                                                    break;
                                                            }
                                                        }
                                                    } else {
                                                        if ($key == "divinity") {
                                                            foreach ($thisValue as $id => $divinity) {
                                                                switch ($id) {
                                                                    case 1:
                                                                        foreach ($divinity as $index => $value) {
                                                                            if ($index <= mconfig("element_divinity_1_maxlvl")) {
                                                                                $divinity1lvl .= "<option value=\"" . $index . "\">" . $value . "</option>";
                                                                            }
                                                                        }
                                                                        break;
                                                                    case 2:
                                                                        foreach ($divinity as $index => $value) {
                                                                            if ($index <= mconfig("element_divinity_2_maxlvl")) {
                                                                                $divinity2lvl .= "<option value=\"" . $index . "\">" . $value . "</option>";
                                                                            }
                                                                        }
                                                                        break;
                                                                    case 3:
                                                                        foreach ($divinity as $index => $value) {
                                                                            if ($index <= mconfig("element_divinity_3_maxlvl")) {
                                                                                $divinity3lvl .= "<option value=\"" . $index . "\">" . $value . "</option>";
                                                                            }
                                                                        }
                                                                        break;
                                                                    case 4:
                                                                        foreach ($divinity as $index => $value) {
                                                                            if ($index <= mconfig("element_divinity_4_maxlvl")) {
                                                                                $divinity4lvl .= "<option value=\"" . $index . "\">" . $value . "</option>";
                                                                            }
                                                                        }
                                                                        break;
                                                                    case 5:
                                                                        foreach ($divinity as $index => $value) {
                                                                            if ($index <= mconfig("element_divinity_5_maxlvl")) {
                                                                                $divinity5lvl .= "<option value=\"" . $index . "\">" . $value . "</option>";
                                                                            }
                                                                        }
                                                                        break;
                                                                }
                                                            }
                                                        } else {
                                                            if ($key == "gale") {
                                                                foreach ($thisValue as $id => $gale) {
                                                                    switch ($id) {
                                                                        case 1:
                                                                            foreach ($gale as $index => $value) {
                                                                                if ($index <= mconfig("element_gale_1_maxlvl")) {
                                                                                    $gale1lvl .= "<option value=\"" . $index . "\">" . $value . "</option>";
                                                                                }
                                                                            }
                                                                            break;
                                                                        case 2:
                                                                            foreach ($gale as $index => $value) {
                                                                                if ($index <= mconfig("element_gale_2_maxlvl")) {
                                                                                    $gale2lvl .= "<option value=\"" . $index . "\">" . $value . "</option>";
                                                                                }
                                                                            }
                                                                            break;
                                                                        case 3:
                                                                            foreach ($gale as $index => $value) {
                                                                                if ($index <= mconfig("element_gale_3_maxlvl")) {
                                                                                    $gale3lvl .= "<option value=\"" . $index . "\">" . $value . "</option>";
                                                                                }
                                                                            }
                                                                            break;
                                                                        case 4:
                                                                            foreach ($gale as $index => $value) {
                                                                                if ($index <= mconfig("element_gale_4_maxlvl")) {
                                                                                    $gale4lvl .= "<option value=\"" . $index . "\">" . $value . "</option>";
                                                                                }
                                                                            }
                                                                            break;
                                                                        case 5:
                                                                            foreach ($gale as $index => $value) {
                                                                                if ($index <= mconfig("element_gale_5_maxlvl")) {
                                                                                    $gale5lvl .= "<option value=\"" . $index . "\">" . $value . "</option>";
                                                                                }
                                                                            }
                                                                            break;
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                        foreach ($elementOptions as $key => $thisOption) {
                                            if ($key == "anger") {
                                                foreach ($thisOption as $id => $anger) {
                                                    switch ($id) {
                                                        case 1:
                                                            foreach ($anger as $index => $option) {
                                                                $pos = strpos($option, "%s");
                                                                if ($pos) {
                                                                    $option = substr_replace($option, "", $pos, 3);
                                                                }
                                                                $anger1 .= "<option value=\"" . $index . "\">" . $option . "</option>";
                                                            }
                                                            break;
                                                        case 2:
                                                            foreach ($anger as $index => $option) {
                                                                $pos = strpos($option, "%s");
                                                                if (is_numeric($pos)) {
                                                                    $option = substr_replace($option, "", $pos, 3);
                                                                }
                                                                $anger2 .= "<option value=\"" . $index . "\">" . $option . "</option>";
                                                            }
                                                            break;
                                                        case 3:
                                                            foreach ($anger as $index => $option) {
                                                                $pos = strpos($option, "%s");
                                                                if ($pos) {
                                                                    $option = substr_replace($option, "", $pos, 3);
                                                                }
                                                                $anger3 .= "<option value=\"" . $index . "\">" . $option . "</option>";
                                                            }
                                                            break;
                                                        case 4:
                                                            foreach ($anger as $index => $option) {
                                                                $pos = strpos($option, "%s");
                                                                if ($pos) {
                                                                    $option = substr_replace($option, "", $pos, 3);
                                                                }
                                                                $anger4 .= "<option value=\"" . $index . "\">" . $option . "</option>";
                                                            }
                                                            break;
                                                        case 5:
                                                            foreach ($anger as $index => $option) {
                                                                $pos = strpos($option, "%s");
                                                                if ($pos) {
                                                                    $option = substr_replace($option, "", $pos, 3);
                                                                }
                                                                $anger5 .= "<option value=\"" . $index . "\">" . $option . "</option>";
                                                            }
                                                            break;
                                                    }
                                                }
                                            } else {
                                                if ($key == "blessing") {
                                                    foreach ($thisOption as $id => $blessing) {
                                                        switch ($id) {
                                                            case 1:
                                                                foreach ($blessing as $index => $option) {
                                                                    $pos = strpos($option, "%s");
                                                                    if ($pos) {
                                                                        $option = substr_replace($option, "", $pos, 3);
                                                                    }
                                                                    $blessing1 .= "<option value=\"" . $index . "\">" . $option . "</option>";
                                                                }
                                                                break;
                                                            case 2:
                                                                foreach ($blessing as $index => $option) {
                                                                    $pos = strpos($option, "%s");
                                                                    if (is_numeric($pos)) {
                                                                        $option = substr_replace($option, "", $pos, 3);
                                                                    }
                                                                    $blessing2 .= "<option value=\"" . $index . "\">" . $option . "</option>";
                                                                }
                                                                break;
                                                            case 3:
                                                                foreach ($blessing as $index => $option) {
                                                                    $pos = strpos($option, "%s");
                                                                    if ($pos) {
                                                                        $option = substr_replace($option, "", $pos, 3);
                                                                    }
                                                                    $blessing3 .= "<option value=\"" . $index . "\">" . $option . "</option>";
                                                                }
                                                                break;
                                                            case 4:
                                                                foreach ($blessing as $index => $option) {
                                                                    $pos = strpos($option, "%s");
                                                                    if ($pos) {
                                                                        $option = substr_replace($option, "", $pos, 3);
                                                                    }
                                                                    $blessing4 .= "<option value=\"" . $index . "\">" . $option . "</option>";
                                                                }
                                                                break;
                                                            case 5:
                                                                foreach ($blessing as $index => $option) {
                                                                    $pos = strpos($option, "%s");
                                                                    if ($pos) {
                                                                        $option = substr_replace($option, "", $pos, 3);
                                                                    }
                                                                    $blessing5 .= "<option value=\"" . $index . "\">" . $option . "</option>";
                                                                }
                                                                break;
                                                        }
                                                    }
                                                } else {
                                                    if ($key == "integrity") {
                                                        foreach ($thisOption as $id => $integrity) {
                                                            switch ($id) {
                                                                case 1:
                                                                    foreach ($integrity as $index => $option) {
                                                                        $pos = strpos($option, "%s");
                                                                        if ($pos) {
                                                                            $option = substr_replace($option, "", $pos, 3);
                                                                        }
                                                                        $integrity1 .= "<option value=\"" . $index . "\">" . $option . "</option>";
                                                                    }
                                                                    break;
                                                                case 2:
                                                                    foreach ($integrity as $index => $option) {
                                                                        $pos = strpos($option, "%s");
                                                                        if (is_numeric($pos)) {
                                                                            $option = substr_replace($option, "", $pos, 3);
                                                                        }
                                                                        $integrity2 .= "<option value=\"" . $index . "\">" . $option . "</option>";
                                                                    }
                                                                    break;
                                                                case 3:
                                                                    foreach ($integrity as $index => $option) {
                                                                        $pos = strpos($option, "%s");
                                                                        if ($pos) {
                                                                            $option = substr_replace($option, "", $pos, 3);
                                                                        }
                                                                        $integrity3 .= "<option value=\"" . $index . "\">" . $option . "</option>";
                                                                    }
                                                                    break;
                                                                case 4:
                                                                    foreach ($integrity as $index => $option) {
                                                                        $pos = strpos($option, "%s");
                                                                        if ($pos) {
                                                                            $option = substr_replace($option, "", $pos, 3);
                                                                        }
                                                                        $integrity4 .= "<option value=\"" . $index . "\">" . $option . "</option>";
                                                                    }
                                                                    break;
                                                                case 5:
                                                                    foreach ($integrity as $index => $option) {
                                                                        $pos = strpos($option, "%s");
                                                                        if ($pos) {
                                                                            $option = substr_replace($option, "", $pos, 3);
                                                                        }
                                                                        $integrity5 .= "<option value=\"" . $index . "\">" . $option . "</option>";
                                                                    }
                                                                    break;
                                                            }
                                                        }
                                                    } else {
                                                        if ($key == "divinity") {
                                                            foreach ($thisOption as $id => $divinity) {
                                                                switch ($id) {
                                                                    case 1:
                                                                        foreach ($divinity as $index => $option) {
                                                                            $pos = strpos($option, "%s");
                                                                            if ($pos) {
                                                                                $option = substr_replace($option, "", $pos, 3);
                                                                            }
                                                                            $divinity1 .= "<option value=\"" . $index . "\">" . $option . "</option>";
                                                                        }
                                                                        break;
                                                                    case 2:
                                                                        foreach ($divinity as $index => $option) {
                                                                            $pos = strpos($option, "%s");
                                                                            if (is_numeric($pos)) {
                                                                                $option = substr_replace($option, "", $pos, 3);
                                                                            }
                                                                            $divinity2 .= "<option value=\"" . $index . "\">" . $option . "</option>";
                                                                        }
                                                                        break;
                                                                    case 3:
                                                                        foreach ($divinity as $index => $option) {
                                                                            $pos = strpos($option, "%s");
                                                                            if ($pos) {
                                                                                $option = substr_replace($option, "", $pos, 3);
                                                                            }
                                                                            $divinity3 .= "<option value=\"" . $index . "\">" . $option . "</option>";
                                                                        }
                                                                        break;
                                                                    case 4:
                                                                        foreach ($divinity as $index => $option) {
                                                                            $pos = strpos($option, "%s");
                                                                            if ($pos) {
                                                                                $option = substr_replace($option, "", $pos, 3);
                                                                            }
                                                                            $divinity4 .= "<option value=\"" . $index . "\">" . $option . "</option>";
                                                                        }
                                                                        break;
                                                                    case 5:
                                                                        foreach ($divinity as $index => $option) {
                                                                            $pos = strpos($option, "%s");
                                                                            if ($pos) {
                                                                                $option = substr_replace($option, "", $pos, 3);
                                                                            }
                                                                            $divinity5 .= "<option value=\"" . $index . "\">" . $option . "</option>";
                                                                        }
                                                                        break;
                                                                }
                                                            }
                                                        } else {
                                                            if ($key == "gale") {
                                                                foreach ($thisOption as $id => $gale) {
                                                                    switch ($id) {
                                                                        case 1:
                                                                            foreach ($gale as $index => $option) {
                                                                                $pos = strpos($option, "%s");
                                                                                if ($pos) {
                                                                                    $option = substr_replace($option, "", $pos, 3);
                                                                                }
                                                                                $gale1 .= "<option value=\"" . $index . "\">" . $option . "</option>";
                                                                            }
                                                                            break;
                                                                        case 2:
                                                                            foreach ($gale as $index => $option) {
                                                                                $pos = strpos($option, "%s");
                                                                                if (is_numeric($pos)) {
                                                                                    $option = substr_replace($option, "", $pos, 3);
                                                                                }
                                                                                $gale2 .= "<option value=\"" . $index . "\">" . $option . "</option>";
                                                                            }
                                                                            break;
                                                                        case 3:
                                                                            foreach ($gale as $index => $option) {
                                                                                $pos = strpos($option, "%s");
                                                                                if ($pos) {
                                                                                    $option = substr_replace($option, "", $pos, 3);
                                                                                }
                                                                                $gale3 .= "<option value=\"" . $index . "\">" . $option . "</option>";
                                                                            }
                                                                            break;
                                                                        case 4:
                                                                            foreach ($gale as $index => $option) {
                                                                                $pos = strpos($option, "%s");
                                                                                if ($pos) {
                                                                                    $option = substr_replace($option, "", $pos, 3);
                                                                                }
                                                                                $gale4 .= "<option value=\"" . $index . "\">" . $option . "</option>";
                                                                            }
                                                                            break;
                                                                        case 5:
                                                                            foreach ($gale as $index => $option) {
                                                                                $pos = strpos($option, "%s");
                                                                                if ($pos) {
                                                                                    $option = substr_replace($option, "", $pos, 3);
                                                                                }
                                                                                $gale5 .= "<option value=\"" . $index . "\">" . $option . "</option>";
                                                                            }
                                                                            break;
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                        if (1 <= mconfig("element_errtel_slots")) {
                                            echo "\r\n                    <div class=\"seperator\"></div>";
                                            if (1 <= mconfig("element_anger_slots")) {
                                                echo "\r\n                    <div class=\"row\">\r\n                      <label for=\"anger1\">Errtel of Anger #1:\r\n                        <span class=\"opt_prt\" id=\"anger1CoinC\" style=\"display: none;\"></span>\r\n                      </label>\r\n                      <select name=\"anger1lvl\" styled=\"true\" id=\"anger1lvl\" style=\"display: none;\" tabindex=\"" . $index . "\">\r\n                        " . $anger1lvl . "\r\n                      </select>\r\n                      <select name=\"anger1\" styled=\"true\" id=\"anger1\" style=\"display: none;\" tabindex=\"" . $index . "\">\r\n                        " . $anger1 . "\r\n                      </select>\r\n                    </div>";
                                            }
                                            if (2 <= mconfig("element_anger_slots")) {
                                                echo "\r\n                    <div class=\"row\">\r\n                      <label for=\"anger2\">Errtel of Anger #2:\r\n                        <span class=\"opt_prt\" id=\"anger2CoinC\" style=\"display: none;\"></span>\r\n                      </label>\r\n                      <select name=\"anger2lvl\" styled=\"true\" id=\"anger2lvl\" style=\"display: none;\" tabindex=\"" . $index . "\">\r\n                        " . $anger2lvl . "\r\n                      </select>\r\n                      <select name=\"anger2\" styled=\"true\" id=\"anger2\" style=\"display: none;\" tabindex=\"" . $index . "\">\r\n                        " . $anger2 . "\r\n                      </select>\r\n                    </div>";
                                            }
                                            if (3 <= mconfig("element_anger_slots")) {
                                                echo "\r\n                    <div class=\"row\">\r\n                      <label for=\"anger3\">Errtel of Anger #3:\r\n                        <span class=\"opt_prt\" id=\"anger3CoinC\" style=\"display: none;\"></span>\r\n                      </label>\r\n                      <select name=\"anger3lvl\" styled=\"true\" id=\"anger3lvl\" style=\"display: none;\" tabindex=\"" . $index . "\">\r\n                        " . $anger3lvl . "\r\n                      </select>\r\n                      <select name=\"anger3\" styled=\"true\" id=\"anger3\" style=\"display: none;\" tabindex=\"" . $index . "\">\r\n                        " . $anger3 . "\r\n                      </select>\r\n                    </div>";
                                            }
                                            if (4 <= mconfig("element_anger_slots")) {
                                                echo "\r\n                    <div class=\"row\">\r\n                      <label for=\"anger4\">Errtel of Anger #4:\r\n                        <span class=\"opt_prt\" id=\"anger4CoinC\" style=\"display: none;\"></span>\r\n                      </label>\r\n                      <select name=\"anger4lvl\" styled=\"true\" id=\"anger4lvl\" style=\"display: none;\" tabindex=\"" . $index . "\">\r\n                        " . $anger4lvl . "\r\n                      </select>\r\n                      <select name=\"anger4\" styled=\"true\" id=\"anger4\" style=\"display: none;\" tabindex=\"" . $index . "\">\r\n                        " . $anger4 . "\r\n                      </select>\r\n                    </div>";
                                            }
                                            if (5 <= mconfig("element_anger_slots")) {
                                                echo "\r\n                    <div class=\"row\">\r\n                      <label for=\"anger5\">Errtel of Anger #5:\r\n                        <span class=\"opt_prt\" id=\"anger5CoinC\" style=\"display: none;\"></span>\r\n                      </label>\r\n                      <select name=\"anger5lvl\" styled=\"true\" id=\"anger5lvl\" style=\"display: none;\" tabindex=\"" . $index . "\">\r\n                        " . $anger5lvl . "\r\n                      </select>\r\n                      <select name=\"anger5\" styled=\"true\" id=\"anger5\" style=\"display: none;\" tabindex=\"" . $index . "\">\r\n                        " . $anger5 . "\r\n                      </select>\r\n                    </div>";
                                            }
                                        }
                                        if (2 <= mconfig("element_errtel_slots")) {
                                            echo "\r\n                    <div class=\"seperator\"></div>";
                                            if (1 <= mconfig("element_blessing_slots")) {
                                                echo "\r\n                    <div class=\"row\">\r\n                      <label for=\"blessing1\">Errtel of Blessing #1:\r\n                        <span class=\"opt_prt\" id=\"blessing1CoinC\" style=\"display: none;\"></span>\r\n                      </label>\r\n                      <select name=\"blessing1lvl\" styled=\"true\" id=\"blessing1lvl\" style=\"display: none;\" tabindex=\"" . $index . "\">\r\n                        " . $blessing1lvl . "\r\n                      </select>\r\n                      <select name=\"blessing1\" styled=\"true\" id=\"blessing1\" style=\"display: none;\" class=\"js-select small\" tabindex=\"" . $index . "\">\r\n                        " . $blessing1 . "\r\n                      </select>\r\n                    </div>";
                                            }
                                            if (2 <= mconfig("element_blessing_slots")) {
                                                echo "\r\n                    <div class=\"row\">\r\n                      <label for=\"blessing2\">Errtel of Blessing #2:\r\n                        <span class=\"opt_prt\" id=\"blessing2CoinC\" style=\"display: none;\"></span>\r\n                      </label>\r\n                      <select name=\"blessing2lvl\" styled=\"true\" id=\"blessing2lvl\" style=\"display: none;\" tabindex=\"" . $index . "\">\r\n                        " . $blessing2lvl . "\r\n                      </select>\r\n                      <select name=\"blessing2\" styled=\"true\" id=\"blessing2\" style=\"display: none;\" tabindex=\"" . $index . "\">\r\n                        " . $blessing2 . "\r\n                      </select>\r\n                    </div>";
                                            }
                                            if (3 <= mconfig("element_blessing_slots")) {
                                                echo "\r\n                    <div class=\"row\">\r\n                      <label for=\"blessing3\">Errtel of Blessing #3:\r\n                        <span class=\"opt_prt\" id=\"blessing3CoinC\" style=\"display: none;\"></span>\r\n                      </label>\r\n                      <select name=\"blessing3lvl\" styled=\"true\" id=\"blessing3lvl\" style=\"display: none;\" tabindex=\"" . $index . "\">\r\n                        " . $blessing3lvl . "\r\n                      </select>\r\n                      <select name=\"blessing3\" styled=\"true\" id=\"blessing3\" style=\"display: none;\" tabindex=\"" . $index . "\">\r\n                        " . $blessing3 . "\r\n                      </select>\r\n                    </div>";
                                            }
                                            if (4 <= mconfig("element_blessing_slots")) {
                                                echo "\r\n                    <div class=\"row\">\r\n                      <label for=\"blessing4\">Errtel of Blessing #4:\r\n                        <span class=\"opt_prt\" id=\"blessing4CoinC\" style=\"display: none;\"></span>\r\n                      </label>\r\n                      <select name=\"blessing4lvl\" styled=\"true\" id=\"blessing4lvl\" style=\"display: none;\" tabindex=\"" . $index . "\">\r\n                        " . $blessing4lvl . "\r\n                      </select>\r\n                      <select name=\"blessing4\" styled=\"true\" id=\"blessing4\" style=\"display: none;\" tabindex=\"" . $index . "\">\r\n                        " . $blessing4 . "\r\n                      </select>\r\n                    </div>";
                                            }
                                            if (5 <= mconfig("element_blessing_slots")) {
                                                echo "\r\n                    <div class=\"row\">\r\n                      <label for=\"blessing5\">Errtel of Blessing #5:\r\n                        <span class=\"opt_prt\" id=\"blessing5CoinC\" style=\"display: none;\"></span>\r\n                      </label>\r\n                      <select name=\"blessing5lvl\" styled=\"true\" id=\"blessing5lvl\" style=\"display: none;\" tabindex=\"" . $index . "\">\r\n                        " . $blessing5lvl . "\r\n                      </select>\r\n                      <select name=\"blessing5\" styled=\"true\" id=\"blessing5\" style=\"display: none;\" tabindex=\"" . $index . "\">\r\n                        " . $blessing5 . "\r\n                      </select>\r\n                    </div>";
                                            }
                                        }
                                        if (3 <= mconfig("element_errtel_slots")) {
                                            echo "\r\n                    <div class=\"seperator\"></div>";
                                            if (1 <= mconfig("element_integrity_slots")) {
                                                echo "\r\n                    <div class=\"row\">\r\n                      <label for=\"integrity1\">Errtel of Integrity #1:\r\n                        <span class=\"opt_prt\" id=\"integrity1CoinC\" style=\"display: none;\"></span>\r\n                      </label>\r\n                      <select name=\"integrity1lvl\" styled=\"true\" id=\"integrity1lvl\" style=\"display: none;\" tabindex=\"" . $index . "\">\r\n                        " . $integrity1lvl . "\r\n                      </select>\r\n                      <select name=\"integrity1\" styled=\"true\" id=\"integrity1\" style=\"display: none;\" class=\"js-select small\" tabindex=\"" . $index . "\">\r\n                        " . $integrity1 . "\r\n                      </select>\r\n                    </div>";
                                            }
                                            if (2 <= mconfig("element_integrity_slots")) {
                                                echo "\r\n                    <div class=\"row\">\r\n                      <label for=\"integrity2\">Errtel of Integrity #2:\r\n                        <span class=\"opt_prt\" id=\"integrity2CoinC\" style=\"display: none;\"></span>\r\n                      </label>\r\n                      <select name=\"integrity2lvl\" styled=\"true\" id=\"integrity2lvl\" style=\"display: none;\" tabindex=\"" . $index . "\">\r\n                        " . $integrity2lvl . "\r\n                      </select>\r\n                      <select name=\"integrity2\" styled=\"true\" id=\"integrity2\" style=\"display: none;\" tabindex=\"" . $index . "\">\r\n                        " . $integrity2 . "\r\n                      </select>\r\n                    </div>";
                                            }
                                            if (3 <= mconfig("element_integrity_slots")) {
                                                echo "\r\n                    <div class=\"row\">\r\n                      <label for=\"integrity3\">Errtel of Integrity #3:\r\n                        <span class=\"opt_prt\" id=\"integrity3CoinC\" style=\"display: none;\"></span>\r\n                      </label>\r\n                      <select name=\"integrity3lvl\" styled=\"true\" id=\"integrity3lvl\" style=\"display: none;\" tabindex=\"" . $index . "\">\r\n                        " . $integrity3lvl . "\r\n                      </select>\r\n                      <select name=\"integrity3\" styled=\"true\" id=\"integrity3\" style=\"display: none;\" tabindex=\"" . $index . "\">\r\n                        " . $integrity3 . "\r\n                      </select>\r\n                    </div>";
                                            }
                                            if (4 <= mconfig("element_integrity_slots")) {
                                                echo "\r\n                    <div class=\"row\">\r\n                      <label for=\"integrity4\">Errtel of Integrity #4:\r\n                        <span class=\"opt_prt\" id=\"integrity4CoinC\" style=\"display: none;\"></span>\r\n                      </label>\r\n                      <select name=\"integrity4lvl\" styled=\"true\" id=\"integrity4lvl\" style=\"display: none;\" tabindex=\"" . $index . "\">\r\n                        " . $integrity4lvl . "\r\n                      </select>\r\n                      <select name=\"integrity4\" styled=\"true\" id=\"integrity4\" style=\"display: none;\" tabindex=\"" . $index . "\">\r\n                        " . $integrity4 . "\r\n                      </select>\r\n                    </div>";
                                            }
                                            if (5 <= mconfig("element_integrity_slots")) {
                                                echo "\r\n                    <div class=\"row\">\r\n                      <label for=\"integrity5\">Errtel of Integrity #5:\r\n                        <span class=\"opt_prt\" id=\"integrity5CoinC\" style=\"display: none;\"></span>\r\n                      </label>\r\n                      <select name=\"integrity5lvl\" styled=\"true\" id=\"integrity5lvl\" style=\"display: none;\" tabindex=\"" . $index . "\">\r\n                        " . $integrity5lvl . "\r\n                      </select>\r\n                      <select name=\"integrity5\" styled=\"true\" id=\"integrity5\" style=\"display: none;\" tabindex=\"" . $index . "\">\r\n                        " . $integrity5 . "\r\n                      </select>\r\n                    </div>";
                                            }
                                        }
                                        if (4 <= mconfig("element_errtel_slots")) {
                                            echo "\r\n                    <div class=\"seperator\"></div>";
                                            if (1 <= mconfig("element_divinity_slots")) {
                                                echo "\r\n                    <div class=\"row\">\r\n                      <label for=\"divinity1\">Errtel of Divinity #1:\r\n                        <span class=\"opt_prt\" id=\"divinity1CoinC\" style=\"display: none;\"></span>\r\n                      </label>\r\n                      <select name=\"divinity1lvl\" styled=\"true\" id=\"divinity1lvl\" style=\"display: none;\" tabindex=\"" . $index . "\">\r\n                        " . $divinity1lvl . "\r\n                      </select>\r\n                      <select name=\"divinity1\" styled=\"true\" id=\"divinity1\" style=\"display: none;\" class=\"js-select small\" tabindex=\"" . $index . "\">\r\n                        " . $divinity1 . "\r\n                      </select>\r\n                    </div>";
                                            }
                                            if (2 <= mconfig("element_divinity_slots")) {
                                                echo "\r\n                    <div class=\"row\">\r\n                      <label for=\"divinity2\">Errtel of Divinity #2:\r\n                        <span class=\"opt_prt\" id=\"divinity2CoinC\" style=\"display: none;\"></span>\r\n                      </label>\r\n                      <select name=\"divinity2lvl\" styled=\"true\" id=\"divinity2lvl\" style=\"display: none;\" tabindex=\"" . $index . "\">\r\n                        " . $divinity2lvl . "\r\n                      </select>\r\n                      <select name=\"divinity2\" styled=\"true\" id=\"divinity2\" style=\"display: none;\" tabindex=\"" . $index . "\">\r\n                        " . $divinity2 . "\r\n                      </select>\r\n                    </div>";
                                            }
                                            if (3 <= mconfig("element_divinity_slots")) {
                                                echo "\r\n                    <div class=\"row\">\r\n                      <label for=\"divinity3\">Errtel of Divinity #3:\r\n                        <span class=\"opt_prt\" id=\"divinity3CoinC\" style=\"display: none;\"></span>\r\n                      </label>\r\n                      <select name=\"divinity3lvl\" styled=\"true\" id=\"divinity3lvl\" style=\"display: none;\" tabindex=\"" . $index . "\">\r\n                        " . $divinity3lvl . "\r\n                      </select>\r\n                      <select name=\"divinity3\" styled=\"true\" id=\"divinity3\" style=\"display: none;\" tabindex=\"" . $index . "\">\r\n                        " . $divinity3 . "\r\n                      </select>\r\n                    </div>";
                                            }
                                            if (4 <= mconfig("element_divinity_slots")) {
                                                echo "\r\n                    <div class=\"row\">\r\n                      <label for=\"divinity4\">Errtel of Divinity #4:\r\n                        <span class=\"opt_prt\" id=\"divinity4CoinC\" style=\"display: none;\"></span>\r\n                      </label>\r\n                      <select name=\"divinity4lvl\" styled=\"true\" id=\"divinity4lvl\" style=\"display: none;\" tabindex=\"" . $index . "\">\r\n                        " . $divinity4lvl . "\r\n                      </select>\r\n                      <select name=\"divinity4\" styled=\"true\" id=\"divinity4\" style=\"display: none;\" tabindex=\"" . $index . "\">\r\n                        " . $divinity4 . "\r\n                      </select>\r\n                    </div>";
                                            }
                                            if (5 <= mconfig("element_divinity_slots")) {
                                                echo "\r\n                    <div class=\"row\">\r\n                      <label for=\"divinity5\">Errtel of Divinity #5:\r\n                        <span class=\"opt_prt\" id=\"divinity5CoinC\" style=\"display: none;\"></span>\r\n                      </label>\r\n                      <select name=\"divinity5lvl\" styled=\"true\" id=\"divinity5lvl\" style=\"display: none;\" tabindex=\"" . $index . "\">\r\n                        " . $divinity5lvl . "\r\n                      </select>\r\n                      <select name=\"divinity5\" styled=\"true\" id=\"divinity5\" style=\"display: none;\" tabindex=\"" . $index . "\">\r\n                        " . $divinity5 . "\r\n                      </select>\r\n                    </div>";
                                            }
                                        }
                                        if (5 <= mconfig("element_errtel_slots")) {
                                            echo "\r\n                    <div class=\"seperator\"></div>";
                                            if (1 <= mconfig("element_gale_slots")) {
                                                echo "\r\n                    <div class=\"row\">\r\n                      <label for=\"gale1\">Errtel of Gale #1:\r\n                        <span class=\"opt_prt\" id=\"gale1CoinC\" style=\"display: none;\"></span>\r\n                      </label>\r\n                      <select name=\"gale1lvl\" styled=\"true\" id=\"gale1lvl\" style=\"display: none;\" tabindex=\"" . $index . "\">\r\n                        " . $gale1lvl . "\r\n                      </select>\r\n                      <select name=\"gale1\" styled=\"true\" id=\"gale1\" style=\"display: none;\" class=\"js-select small\" tabindex=\"" . $index . "\">\r\n                        " . $gale1 . "\r\n                      </select>\r\n                    </div>";
                                            }
                                            if (2 <= mconfig("element_gale_slots")) {
                                                echo "\r\n                    <div class=\"row\">\r\n                      <label for=\"gale2\">Errtel of Gale #2:\r\n                        <span class=\"opt_prt\" id=\"gale2CoinC\" style=\"display: none;\"></span>\r\n                      </label>\r\n                      <select name=\"gale2lvl\" styled=\"true\" id=\"gale2lvl\" style=\"display: none;\" tabindex=\"" . $index . "\">\r\n                        " . $gale2lvl . "\r\n                      </select>\r\n                      <select name=\"gale2\" styled=\"true\" id=\"gale2\" style=\"display: none;\" tabindex=\"" . $index . "\">\r\n                        " . $gale2 . "\r\n                      </select>\r\n                    </div>";
                                            }
                                            if (3 <= mconfig("element_gale_slots")) {
                                                echo "\r\n                    <div class=\"row\">\r\n                      <label for=\"gale3\">Errtel of Gale #3:\r\n                        <span class=\"opt_prt\" id=\"gale3CoinC\" style=\"display: none;\"></span>\r\n                      </label>\r\n                      <select name=\"gale3lvl\" styled=\"true\" id=\"gale3lvl\" style=\"display: none;\" tabindex=\"" . $index . "\">\r\n                        " . $gale3lvl . "\r\n                      </select>\r\n                      <select name=\"gale3\" styled=\"true\" id=\"gale3\" style=\"display: none;\" tabindex=\"" . $index . "\">\r\n                        " . $gale3 . "\r\n                      </select>\r\n                    </div>";
                                            }
                                            if (4 <= mconfig("element_gale_slots")) {
                                                echo "\r\n                    <div class=\"row\">\r\n                      <label for=\"gale4\">Errtel of Gale #4:\r\n                        <span class=\"opt_prt\" id=\"gale4CoinC\" style=\"display: none;\"></span>\r\n                      </label>\r\n                      <select name=\"gale4lvl\" styled=\"true\" id=\"gale4lvl\" style=\"display: none;\" tabindex=\"" . $index . "\">\r\n                        " . $gale4lvl . "\r\n                      </select>\r\n                      <select name=\"gale4\" styled=\"true\" id=\"gale4\" style=\"display: none;\" tabindex=\"" . $index . "\">\r\n                        " . $gale4 . "\r\n                      </select>\r\n                    </div>";
                                            }
                                            if (5 <= mconfig("element_gale_slots")) {
                                                echo "\r\n                    <div class=\"row\">\r\n                      <label for=\"gale5\">Errtel of Gale #5:\r\n                        <span class=\"opt_prt\" id=\"gale5CoinC\" style=\"display: none;\"></span>\r\n                      </label>\r\n                      <select name=\"gale5lvl\" styled=\"true\" id=\"gale5lvl\" style=\"display: none;\" tabindex=\"" . $index . "\">\r\n                        " . $gale5lvl . "\r\n                      </select>\r\n                      <select name=\"gale5\" styled=\"true\" id=\"gale5\" style=\"display: none;\" tabindex=\"" . $index . "\">\r\n                        " . $gale5 . "\r\n                      </select>\r\n                    </div>";
                                            }
                                            echo "\r\n                    <div class=\"seperator\"></div>";
                                        }
                                    }
                                    echo "\r\n              </div>\r\n              <!-- //if (basicInfo != null && socketInfo != null && mappingInfo != null) -->\r\n            </div><!-- //itemoption_wp -->\r\n\r\n            <div class=\"webshop-price\">\r\n              <span class=\"title\">" . lang("webshop_txt_70", true) . "</span>\r\n              <table width=\"100%\">\r\n                <tr>\r\n                  <td>" . lang("webshop_txt_71", true) . "</td>\r\n                  <td align=\"right\">\r\n                    <em id=\"dPriceCoinC\" style=\"display: inline;\">" . ceil($itemData["price"]) . "</em>\r\n                    <div id=\"dPriceBit\" style=\"display: none;\">" . ceil($itemData["price"]) . "</div>\r\n                    <span class=\"creditTypeName\">--</span>\r\n                  </td>\r\n                </tr>\r\n                <tr>\r\n                  <td>" . lang("webshop_txt_72", true) . "</td>\r\n                  <td align=\"right\">\r\n                    <em id=\"optPriceCoinC\" style=\"display: inline;\">0</em>\r\n                    <span class=\"creditTypeName\">--</span>\r\n                  </td>\r\n                </tr>\r\n                <tr>\r\n                  <td>" . lang("webshop_txt_73", true) . "</td>\r\n                  <td align=\"right\">\r\n                    <em id=\"totPriceCoinC\" style=\"display: inline;\">" . ceil($itemData["price"]) . "</em>\r\n                    <span class=\"creditTypeName\">--</span>\r\n                  </td>\r\n                </tr>\r\n              </table>\r\n            </div>\r\n            <div class=\"webshop-buybtn\">\r\n              <div style=\"float:right;\">\r\n                <input type=\"hidden\" name=\"activeCredit\" id=\"activeCredit\" value=\"" . $activeCredit . "\" />\r\n                <input type=\"submit\" name=\"buy\" id=\"buyBtnPrev\" value=\"" . lang("webshop_txt_74", true) . "\" class=\"btn_payment\">";
                                    if (mconfig("is_gift")) {
                                        echo "&nbsp;<input type=\"submit\" name=\"gift\" id=\"buyBtnPrev\" value=\"" . lang("webshop_txt_75", true) . "\" class=\"btn_payment\">";
                                    }
                                    echo "\r\n              </div>\r\n            </div>\r\n\r\n            </form>\r\n            </div>";
                                }
                            }
                        } else {
                            if ($itype == "package") {
                                if (isset($_POST["buy"])) {
                                    $packageData = $Webshop->getPackageData($id);
                                    $packageItems = $Webshop->getPackageItems($id);
                                    $payments = $Webshop->loadPayments($id, "IMPERIAMUCMS_WEBSHOP_PACKAGES");
                                    $error = false;
                                    if ($packageData["store_count"] == "0") {
                                        $error = true;
                                        $reason = lang("webshop_txt_50", true);
                                    }
                                    if ($packageData["status"] != "1") {
                                        $error = true;
                                        $reason = lang("webshop_txt_51", true);
                                    }
                                    if (!$error) {
                                        $paymentType = htmlspecialchars($_POST["activeCredit"]);
                                        switch ($paymentType) {
                                            case "0":
                                                $paymentType = 1;
                                                break;
                                            case "1":
                                                $paymentType = 2;
                                                break;
                                            case "2":
                                                $paymentType = 4;
                                                break;
                                            default:
                                                $paymentType = 0;
                                                if (0 < $paymentType) {
                                                    switch ($paymentType) {
                                                        case "1":
                                                            $packageData["price"] = $packageData["price"] * mconfig("price_platinum");
                                                            $queryCheck = "SELECT TOP 1 platinum FROM MEMB_CREDITS WHERE memb___id = ?";
                                                            $currencyName = "platinum";
                                                            $currencyName2 = lang("currency_platinum", true);
                                                            break;
                                                        case "2":
                                                            $packageData["price"] = $packageData["price"] * mconfig("price_gold");
                                                            $queryCheck = "SELECT TOP 1 gold FROM MEMB_CREDITS WHERE memb___id = ?";
                                                            $currencyName = "gold";
                                                            $currencyName2 = lang("currency_gold", true);
                                                            break;
                                                        case "4":
                                                            $packageData["price"] = $packageData["price"] * mconfig("price_silver");
                                                            $queryCheck = "SELECT TOP 1 silver FROM MEMB_CREDITS WHERE memb___id = ?";
                                                            $currencyName = "silver";
                                                            $currencyName2 = lang("currency_silver", true);
                                                            break;
                                                    }
                                                }
                                                $array = [$_SESSION["username"]];
                                                if (0 < $packageData["on_sale"] && $packageData["on_sale"] < 100) {
                                                    $sale = 100 - $on_sale;
                                                    $packageData["price"] = $sale * $packageData["price"] / 100;
                                                }
                                                $packageData["price"] = ceil($packageData["price"]);
                                                if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                                    $currencyCheck = $dB2->query_fetch_single($queryCheck, $array);
                                                } else {
                                                    $currencyCheck = $dB->query_fetch_single($queryCheck, $array);
                                                }
                                                if ($currencyCheck[$currencyName] < $packageData["price"]) {
                                                    message("error", sprintf(lang("webshop_txt_52", true), $currencyName2));
                                                } else {
                                                    $date = date("Y-m-d H:i:s", time());
                                                    $total_items = sizeof($packageItems);
                                                    $item_price = $packageData["price"] / $total_items;
                                                    $item_price = ceil($item_price);
                                                    foreach ($packageItems as $thisItem) {
                                                        $serial = $dB->query_fetch_single("exec WZ_GetItemSerial2 1");
                                                        $serial = $serial["ItemSerial"];
                                                        while (strlen($serial) < 16) {
                                                            $serial = "0" . $serial;
                                                        }
                                                        $serial2 = substr($serial, 0, 8);
                                                        $serial = substr($serial, 8, 8);
                                                        $thisItem["item_hex"] = substr_replace($thisItem["item_hex"], $serial2, 6, 8);
                                                        $thisItem["item_hex"] = substr_replace($thisItem["item_hex"], $serial, 32, 8);
                                                        $insert = $dB->query("INSERT INTO IMPERIAMUCMS_WEBSHOP_ITEMS_INVENTORY(AccountID,item,price,price_type,date,status,type,giftFrom) \r\n                                        VALUES(?,?,?,?,?,?,?,?)", [$_SESSION["username"], $thisItem["item_hex"], $item_price, $paymentType, $date, "0", "1", NULL]);
                                                        $Webshop->addLog($_SESSION["username"], $thisItem["item_hex"], $item_price, $paymentType, "package");
                                                    }
                                                    if ($packageData["store_count"] == "-1") {
                                                        $update = $dB->query("UPDATE IMPERIAMUCMS_WEBSHOP_PACKAGES SET total_bought = total_bought + 1 WHERE id = ?", [$id]);
                                                    } else {
                                                        $update = $dB->query("UPDATE IMPERIAMUCMS_WEBSHOP_PACKAGES SET store_count = store_count - 1, total_bought = total_bought + 1 WHERE id = ?", [$id]);
                                                    }
                                                    switch ($paymentType) {
                                                        case "1":
                                                            if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                                                $deduct = $dB2->query("UPDATE MEMB_CREDITS SET platinum = platinum - ?, platinum_used = platinum_used + ? WHERE memb___id = ?", [$packageData["price"], $packageData["price"], $_SESSION["username"]]);
                                                            } else {
                                                                $deduct = $dB->query("UPDATE MEMB_CREDITS SET platinum = platinum - ?, platinum_used = platinum_used + ? WHERE memb___id = ?", [$packageData["price"], $packageData["price"], $_SESSION["username"]]);
                                                            }
                                                            break;
                                                        case "2":
                                                            if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                                                $deduct = $dB2->query("UPDATE MEMB_CREDITS SET gold = gold - ?, gold_used = gold_used + ? WHERE memb___id = ?", [$packageData["price"], $packageData["price"], $_SESSION["username"]]);
                                                            } else {
                                                                $deduct = $dB->query("UPDATE MEMB_CREDITS SET gold = gold - ?, gold_used = gold_used + ? WHERE memb___id = ?", [$packageData["price"], $packageData["price"], $_SESSION["username"]]);
                                                            }
                                                            break;
                                                        case "4":
                                                            if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                                                $deduct = $dB2->query("UPDATE MEMB_CREDITS SET silver = silver - ?, silver_used = silver_used + ? WHERE memb___id = ?", [$packageData["price"], $packageData["price"], $_SESSION["username"]]);
                                                            } else {
                                                                $deduct = $dB->query("UPDATE MEMB_CREDITS SET silver = silver - ?, silver_used = silver_used + ? WHERE memb___id = ?", [$packageData["price"], $packageData["price"], $_SESSION["username"]]);
                                                            }
                                                            message("success", lang("webshop_txt_76", true));
                                                            $logDate = date("Y-m-d H:i:s", time());
                                                            $common->accountLogs($_SESSION["username"], "webshop", sprintf(lang("webshop_txt_77", true), $packageData["price"], $currencyName2, $packageData["name"]), $logDate);
                                                            redirect(2, "webshop", 5);
                                                            break;
                                                        default:
                                                            throw new Exception(lang("webshop_txt_7", true));
                                                    }
                                                }
                                        }
                                    } else {
                                        message("error", $reason);
                                    }
                                } else {
                                    if (!isset($_POST["gift"])) {
                                        $package = $Webshop->getPackageData($id);
                                        $package_items = $Webshop->getPackageItems($id);
                                        $payments = $Webshop->loadPayments($id, "IMPERIAMUCMS_WEBSHOP_PACKAGES");
                                        $Market = new Market();
                                        $Items = new Items();
                                        if ($payments["platinum"]) {
                                            $activeCredit = 0;
                                        } else {
                                            if ($payments["gold"]) {
                                                $activeCredit = 1;
                                            } else {
                                                $activeCredit = 2;
                                            }
                                        }
                                        echo "<script type=\"text/javascript\">\r\n                    var creditType = [];\r\n                    creditType[0] = { name:\"" . lang("currency_platinum", true) . "\", ratio:" . mconfig("price_platinum") . " };\r\n                    creditType[1] = { name:\"" . lang("currency_gold", true) . "\", ratio:" . mconfig("price_gold") . " };\r\n                    creditType[2] = { name:\"" . lang("currency_silver", true) . "\", ratio:" . mconfig("price_silver") . " };\r\n\r\n                    var maxSocket = " . mconfig("max_socket") . ";\r\n                    var maxExcOpt = " . mconfig("max_exc_opt") . ";\r\n                    var ancHarm = " . mconfig("anc_harm") . ";\r\n                    var ancExc = " . mconfig("anc_exc") . ";\r\n                    var allowSameSocket = " . mconfig("allow_same_socket") . ";\r\n                    var activeRatio = creditType[" . $activeCredit . "][\"ratio\"];\r\n\r\n                    \$(document).ready(function()\r\n                    {\r\n                      InitItemForm(" . $activeCredit . ");\r\n                    });\r\n                  </script>";
                                        echo "\r\n            <div class=\"pay_wp\" style=\"display:block;\">\r\n              <form name=\"frmItem\" id=\"frmItem\" method=\"post\">\r\n                <div class=\"webshop-title\">\r\n                  <div id=\"title\">\r\n                    <h1>" . $package["name"] . "<p></p><span></span></h1>\r\n                  </div>\r\n                </div>\r\n            \t\t<div class=\"currency-cats\">";
                                        $platinum = false;
                                        $gold = false;
                                        $silver = false;
                                        if ($payments["platinum"]) {
                                            echo "<a class=\"btn_type4 on\" id=\"btnPlatinum\">" . lang("currency_platinum", true) . " <p>" . lang("webshop_txt_57", true) . "</p></a>";
                                            $platinum = true;
                                        }
                                        if ($payments["gold"] && !$platinum) {
                                            echo "<a class=\"btn_type4 on\" id=\"btnGold\">" . lang("currency_gold", true) . " <p>" . lang("webshop_txt_58", true) . "</p></a>";
                                            $gold = true;
                                        } else {
                                            if ($payments["gold"]) {
                                                echo "<a class=\"btn_type4\" id=\"btnGold\">" . lang("currency_gold", true) . " <p>" . lang("webshop_txt_58", true) . "</p></a>";
                                                $gold = true;
                                            }
                                        }
                                        if ($payments["silver"] && !$platinum && !$gold) {
                                            echo "<a class=\"btn_type4 on\" id=\"btnSilver\">" . lang("currency_silver", true) . " <p>" . lang("webshop_txt_59", true) . "</p></a>";
                                        } else {
                                            if ($payments["silver"]) {
                                                echo "<a class=\"btn_type4\" id=\"btnSilver\">" . lang("currency_silver", true) . " <p>" . lang("webshop_txt_59", true) . "</p></a>";
                                            }
                                        }
                                        echo "\r\n                  <div class=\"clear\"></div>\r\n                </div>\r\n                <ul class=\"desc\" id=\"coin_c_msg\">\r\n                  <li>" . $package["description"] . "</li>\r\n          \t\t\t</ul>\r\n\r\n                <div class=\"webshop-price\">\r\n                  <span class=\"title\">" . lang("webshop_txt_78", true) . "</span>\r\n                  <table width=\"100%\">";
                                        foreach ($package_items as $thisItem) {
                                            $itemInfo = $Items->ItemInfo($thisItem["item_hex"]);
                                            if ($itemInfo["level"]) {
                                                $itemInfo["level"] = " +" . $itemInfo["level"];
                                            } else {
                                                $itemInfo["level"] = NULL;
                                            }
                                            $luck = "";
                                            $skill = "";
                                            $option = "";
                                            $exl = "";
                                            $ancsetopt = "";
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
                                            echo "\r\n                    <tr style=\"cursor: pointer;\">\r\n                      <td align=\"left\" onmouseover=\"Tip('<center><img src=" . $itemInfo["thumb"] . "><br /><font color=yellow><br>" . lang("market_txt_100", true) . " " . $itemInfo["sn2"] . $itemInfo["sn"] . "</font><br><font color=white><br>" . lang("market_txt_101", true) . " " . $itemInfo["dur"] . "</font><br><font color=#FF99CC>" . $itemInfo["jog"] . "</font><font color=FFCC00>" . $itemInfo["harm"] . "</font><br>" . $option . " " . $luck . " " . $skill . " " . $exl . " <br>" . $ancsetopt . "<br><font color=#4d668d>" . $itemInfo["socket"] . "</font><br><br><span class=itemTooltipClassReq>" . $itemInfo["classReq"] . "</span></center>', TITLEFONTCOLOR, '" . $itemInfo["color"] . "',TITLE,'" . addslashes($itemInfo["name"]) . $itemInfo["level"] . "',TITLEBGCOLOR,'" . $itemInfo["anco"] . "')\" onmouseout=\"UnTip()\" <img src=\"" . $itemInfo["thumb"] . "\" class=\"m\">\r\n                      <center><font style=\"color:" . $itemInfo["color"] . ";background-color:" . $itemInfo["anco"] . "\">" . $itemInfo["name"] . "</font></center></td>\r\n                    </tr>";
                                        }
                                        echo "\r\n                  </table>\r\n                </div>\r\n                <div class=\"webshop-price\">\r\n                  <span class=\"title\">" . lang("webshop_txt_79", true) . "</span>\r\n                  <table width=\"100%\">\r\n                    <tr>\r\n                      <td>" . lang("webshop_txt_71", true) . "</td>\r\n                      <td align=\"right\">\r\n                        <em id=\"dPriceCoinC\" style=\"display: inline;\">" . ceil($package["price"]) . "</em>\r\n                        <div id=\"dPriceBit\" style=\"display: none;\">" . ceil($package["price"]) . "</div>\r\n                        <span class=\"creditTypeName\">--</span>\r\n                      </td>\r\n                    </tr>\r\n                    <tr>\r\n                      <td>" . lang("webshop_txt_72", true) . "</td>\r\n                      <td align=\"right\">\r\n                        <em id=\"optPriceCoinC\" style=\"display: inline;\">0</em>\r\n                        <span class=\"creditTypeName\">--</span>\r\n                      </td>\r\n                    </tr>\r\n                    <tr>\r\n                      <td>" . lang("webshop_txt_73", true) . "</td>\r\n                      <td align=\"right\">\r\n                        <em id=\"totPriceCoinC\" style=\"display: inline;\">" . ceil($package["price"]) . "</em>\r\n                        <span class=\"creditTypeName\">--</span>\r\n                      </td>\r\n                    </tr>\r\n                  </table>\r\n                </div>\r\n                <div class=\"webshop-buybtn\">\r\n                  <div style=\"float:right;\">\r\n                    <input type=\"hidden\" name=\"activeCredit\" id=\"activeCredit\" value=\"" . $activeCredit . "\" />\r\n                    <input type=\"submit\" name=\"buy\" id=\"buyBtnPrev\" value=\"" . lang("webshop_txt_73", true) . "\" class=\"btn_payment\">";
                                        if (mconfig("is_gift")) {
                                            echo "&nbsp;<input type=\"submit\" name=\"gift\" id=\"buyBtnPrev\" value=\"" . lang("webshop_txt_73", true) . "\" class=\"btn_payment\">";
                                        }
                                        echo "\r\n                  </div>\r\n                </div>\r\n              </form>\r\n            </div>";
                                    }
                                }
                            } else {
                                if ($itype == "mystery") {
                                    if (isset($_POST["buy"])) {
                                        $mysteryData = $Webshop->getMysteryData($id);
                                        $mysteryItems = $Webshop->getMysteryItems($id);
                                        $payments = $Webshop->loadPayments($id, "IMPERIAMUCMS_WEBSHOP_MYSTERY");
                                        $error = false;
                                        if ($mysteryData["store_count"] == "0") {
                                            $error = true;
                                            $reason = lang("webshop_txt_50", true);
                                        }
                                        if ($mysteryData["status"] != "1") {
                                            $error = true;
                                            $reason = lang("webshop_txt_51", true);
                                        }
                                        if (!$error) {
                                            $paymentType = htmlspecialchars($_POST["activeCredit"]);
                                            switch ($paymentType) {
                                                case "0":
                                                    $paymentType = 1;
                                                    break;
                                                case "1":
                                                    $paymentType = 2;
                                                    break;
                                                case "2":
                                                    $paymentType = 4;
                                                    break;
                                                default:
                                                    $paymentType = 0;
                                                    if (0 < $paymentType) {
                                                        switch ($paymentType) {
                                                            case "1":
                                                                $mysteryData["price"] = $mysteryData["price"] * mconfig("price_platinum");
                                                                $queryCheck = "SELECT TOP 1 platinum FROM MEMB_CREDITS WHERE memb___id = ?";
                                                                $currencyName = "platinum";
                                                                $currencyName2 = lang("currency_platinum", true);
                                                                break;
                                                            case "2":
                                                                $mysteryData["price"] = $mysteryData["price"] * mconfig("price_gold");
                                                                $queryCheck = "SELECT TOP 1 gold FROM MEMB_CREDITS WHERE memb___id = ?";
                                                                $currencyName = "gold";
                                                                $currencyName2 = lang("currency_gold", true);
                                                                break;
                                                            case "4":
                                                                $mysteryData["price"] = $mysteryData["price"] * mconfig("price_silver");
                                                                $queryCheck = "SELECT TOP 1 silver FROM MEMB_CREDITS WHERE memb___id = ?";
                                                                $currencyName = "silver";
                                                                $currencyName2 = lang("currency_silver", true);
                                                                break;
                                                        }
                                                    }
                                                    $array = [$_SESSION["username"]];
                                                    if (0 < $mysteryData["on_sale"] && $mysteryData["on_sale"] < 100) {
                                                        $sale = 100 - $on_sale;
                                                        $mysteryData["price"] = $sale * $mysteryData["price"] / 100;
                                                    }
                                                    $mysteryData["price"] = ceil($mysteryData["price"]);
                                                    if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                                        $currencyCheck = $dB2->query_fetch_single($queryCheck, $array);
                                                    } else {
                                                        $currencyCheck = $dB->query_fetch_single($queryCheck, $array);
                                                    }
                                                    if ($currencyCheck[$currencyName] < $mysteryData["price"]) {
                                                        message("error", sprintf(lang("webshop_txt_52", true), $currencyName2));
                                                    } else {
                                                        $date = date("Y-m-d H:i:s", time());
                                                        $total_items = sizeof($mysteryItems);
                                                        $item_price = $mysteryData["price"];
                                                        $totalChance = 0;
                                                        $tmpChance = 0;
                                                        foreach ($mysteryItems as $thisItem) {
                                                            $totalChance += $thisItem["chance"];
                                                        }
                                                        $min = 1;
                                                        $max = $totalChance;
                                                        $random = rand($min, $max);
                                                        $i = 0;
                                                        foreach ($mysteryItems as $thisItem) {
                                                            echo $i . " ";
                                                            $tmpChance += $thisItem["chance"];
                                                            echo $tmpChance . " ";
                                                            if ($random <= $tmpChance) {
                                                                $random = $i;
                                                                $i = 0;
                                                                foreach ($mysteryItems as $thisItem) {
                                                                    if ($i == $random) {
                                                                        $serial = $dB->query_fetch_single("exec WZ_GetItemSerial2 1");
                                                                        $serial = $serial["ItemSerial"];
                                                                        while (strlen($serial) < 16) {
                                                                            $serial = "0" . $serial;
                                                                        }
                                                                        $serial2 = substr($serial, 0, 8);
                                                                        $serial = substr($serial, 8, 8);
                                                                        $thisItem["item_hex"] = substr_replace($thisItem["item_hex"], $serial2, 6, 8);
                                                                        $thisItem["item_hex"] = substr_replace($thisItem["item_hex"], $serial, 32, 8);
                                                                        $insert = $dB->query("INSERT INTO IMPERIAMUCMS_WEBSHOP_ITEMS_INVENTORY(AccountID,item,price,price_type,date,status,type,giftFrom) \r\n                                          VALUES(?,?,?,?,?,?,?,?)", [$_SESSION["username"], $thisItem["item_hex"], $item_price, $paymentType, $date, "0", "1", NULL]);
                                                                        $Webshop->addLog($_SESSION["username"], $thisItem["item_hex"], $item_price, $paymentType, "mystery");
                                                                        if ($mysteryData["store_count"] == "-1") {
                                                                            $update = $dB->query("UPDATE IMPERIAMUCMS_WEBSHOP_MYSTERY SET total_bought = total_bought + 1 WHERE id = ?", [$id]);
                                                                        } else {
                                                                            $update = $dB->query("UPDATE IMPERIAMUCMS_WEBSHOP_MYSTERY SET store_count = store_count - 1, total_bought = total_bought + 1 WHERE id = ?", [$id]);
                                                                        }
                                                                        switch ($paymentType) {
                                                                            case "1":
                                                                                if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                                                                    $deduct = $dB2->query("UPDATE MEMB_CREDITS SET platinum = platinum - ?, platinum_used = platinum_used + ? WHERE memb___id = ?", [$mysteryData["price"], $mysteryData["price"], $_SESSION["username"]]);
                                                                                } else {
                                                                                    $deduct = $dB->query("UPDATE MEMB_CREDITS SET platinum = platinum - ?, platinum_used = platinum_used + ? WHERE memb___id = ?", [$mysteryData["price"], $mysteryData["price"], $_SESSION["username"]]);
                                                                                }
                                                                                break;
                                                                            case "2":
                                                                                if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                                                                    $deduct = $dB2->query("UPDATE MEMB_CREDITS SET gold = gold - ?, gold_used = gold_used + ? WHERE memb___id = ?", [$mysteryData["price"], $mysteryData["price"], $_SESSION["username"]]);
                                                                                } else {
                                                                                    $deduct = $dB->query("UPDATE MEMB_CREDITS SET gold = gold - ?, gold_used = gold_used + ? WHERE memb___id = ?", [$mysteryData["price"], $mysteryData["price"], $_SESSION["username"]]);
                                                                                }
                                                                                break;
                                                                            case "4":
                                                                                if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                                                                    $deduct = $dB2->query("UPDATE MEMB_CREDITS SET silver = silver - ?, silver_used = silver_used + ? WHERE memb___id = ?", [$mysteryData["price"], $mysteryData["price"], $_SESSION["username"]]);
                                                                                } else {
                                                                                    $deduct = $dB->query("UPDATE MEMB_CREDITS SET silver = silver - ?, silver_used = silver_used + ? WHERE memb___id = ?", [$mysteryData["price"], $mysteryData["price"], $_SESSION["username"]]);
                                                                                }
                                                                                message("success", lang("webshop_txt_82", true));
                                                                                $logDate = date("Y-m-d H:i:s", time());
                                                                                $common->accountLogs($_SESSION["username"], "webshop", sprintf(lang("webshop_txt_83", true), $mysteryData["price"], $currencyName2, $mysteryData["name"]), $logDate);
                                                                                redirect(2, "webshop", 5);
                                                                                break;
                                                                            default:
                                                                                throw new Exception("Invalid currency.");
                                                                        }
                                                                    } else {
                                                                        $i++;
                                                                    }
                                                                }
                                                            } else {
                                                                echo "<br>";
                                                                $i++;
                                                            }
                                                        }
                                                    }
                                            }
                                        } else {
                                            message("error", $reason);
                                        }
                                    } else {
                                        if (!isset($_POST["gift"])) {
                                            $mystery = $Webshop->getMysteryData($id);
                                            $mystery_items = $Webshop->getMysteryItems($id);
                                            $payments = $Webshop->loadPayments($id, "IMPERIAMUCMS_WEBSHOP_MYSTERY");
                                            $Market = new Market();
                                            $Items = new Items();
                                            if ($payments["platinum"]) {
                                                $activeCredit = 0;
                                            } else {
                                                if ($payments["gold"]) {
                                                    $activeCredit = 1;
                                                } else {
                                                    $activeCredit = 2;
                                                }
                                            }
                                            echo "<script type=\"text/javascript\">\r\n                    var creditType = [];\r\n                    creditType[0] = { name:\"" . lang("currency_platinum", true) . "\", ratio:" . mconfig("price_platinum") . " };\r\n                    creditType[1] = { name:\"" . lang("currency_gold", true) . "\", ratio:" . mconfig("price_gold") . " };\r\n                    creditType[2] = { name:\"" . lang("currency_silver", true) . "\", ratio:" . mconfig("price_silver") . " };\r\n\r\n                    var maxSocket = " . mconfig("max_socket") . ";\r\n                    var maxExcOpt = " . mconfig("max_exc_opt") . ";\r\n                    var ancHarm = " . mconfig("anc_harm") . ";\r\n                    var ancExc = " . mconfig("anc_exc") . ";\r\n                    var allowSameSocket = " . mconfig("allow_same_socket") . ";\r\n                    var activeRatio = creditType[" . $activeCredit . "][\"ratio\"];\r\n\r\n                    \$(document).ready(function()\r\n                    {\r\n                      InitItemForm(" . $activeCredit . ");\r\n                    });\r\n                  </script>";
                                            echo "\r\n            <div class=\"pay_wp\" style=\"display:block;\">\r\n              <form name=\"frmItem\" id=\"frmItem\" method=\"post\">\r\n                <div class=\"webshop-title\">\r\n                  <div id=\"title\">\r\n                    <h1>" . $mystery["name"] . "<p></p><span></span></h1>\r\n                  </div>\r\n                </div>\r\n            \t\t<div class=\"currency-cats\">";
                                            $platinum = false;
                                            $gold = false;
                                            $silver = false;
                                            if ($payments["platinum"]) {
                                                echo "<a class=\"btn_type4 on\" id=\"btnPlatinum\">" . lang("currency_platinum", true) . " <p>" . lang("webshop_txt_57", true) . "</p></a>";
                                                $platinum = true;
                                            }
                                            if ($payments["gold"] && !$platinum) {
                                                echo "<a class=\"btn_type4 on\" id=\"btnGold\">" . lang("currency_gold", true) . " <p>" . lang("webshop_txt_58", true) . "</p></a>";
                                                $gold = true;
                                            } else {
                                                if ($payments["gold"]) {
                                                    echo "<a class=\"btn_type4\" id=\"btnGold\">" . lang("currency_gold", true) . " <p>" . lang("webshop_txt_58", true) . "</p></a>";
                                                    $gold = true;
                                                }
                                            }
                                            if ($payments["silver"] && !$platinum && !$gold) {
                                                echo "<a class=\"btn_type4 on\" id=\"btnSilver\">" . lang("currency_silver", true) . " <p>" . lang("webshop_txt_59", true) . "</p></a>";
                                            } else {
                                                if ($payments["silver"]) {
                                                    echo "<a class=\"btn_type4\" id=\"btnSilver\">" . lang("currency_silver", true) . " <p>" . lang("webshop_txt_59", true) . "</p></a>";
                                                }
                                            }
                                            echo "\r\n                  <div class=\"clear\"></div>\r\n                </div>\r\n                <ul class=\"desc\" id=\"coin_c_msg\">\r\n                  <li>" . $mystery["description"] . "</li>\r\n          \t\t\t</ul>\r\n\r\n                <div class=\"webshop-price\">\r\n                  <span class=\"title\">" . lang("webshop_txt_84", true) . "</span>\r\n                  <table width=\"100%\">\r\n                    <tr>\r\n                      <td align=\"left\">" . lang("webshop_txt_85", true) . "</td>\r\n                    </tr>";
                                            foreach ($mystery_items as $thisItem) {
                                                $itemInfo = $Items->ItemInfo($thisItem["item_hex"]);
                                                if ($itemInfo["level"]) {
                                                    $itemInfo["level"] = " +" . $itemInfo["level"];
                                                } else {
                                                    $itemInfo["level"] = NULL;
                                                }
                                                $luck = "";
                                                $skill = "";
                                                $option = "";
                                                $exl = "";
                                                $ancsetopt = "";
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
                                                echo "\r\n                    <tr style=\"cursor: pointer;\">\r\n                      <td align=\"left\" onmouseover=\"Tip('<center><img src=" . $itemInfo["thumb"] . "><br /><font color=yellow><br>" . lang("market_txt_100", true) . " " . $itemInfo["sn2"] . $itemInfo["sn"] . "</font><br><font color=white><br>" . lang("market_txt_101", true) . " " . $itemInfo["dur"] . "</font><br><font color=#FF99CC>" . $itemInfo["jog"] . "</font><font color=FFCC00>" . $itemInfo["harm"] . "</font><br>" . $option . " " . $luck . " " . $skill . " " . $exl . " <br>" . $ancsetopt . "<br><font color=#4d668d>" . $itemInfo["socket"] . "</font><br><br><span class=itemTooltipClassReq>" . $itemInfo["classReq"] . "</span></center>', TITLEFONTCOLOR, '" . $itemInfo["color"] . "',TITLE,'" . addslashes($itemInfo["name"]) . $itemInfo["level"] . "',TITLEBGCOLOR,'" . $itemInfo["anco"] . "')\" onmouseout=\"UnTip()\" <img src=\"" . $itemInfo["thumb"] . "\" class=\"m\">\r\n                      <center><font style=\"color:" . $itemInfo["color"] . ";background-color:" . $itemInfo["anco"] . "\">" . $itemInfo["name"] . "</font></center></td>\r\n                    </tr>";
                                            }
                                            echo "\r\n                  </table>\r\n                </div>\r\n                <div class=\"webshop-price\">\r\n                  <span class=\"title\">" . lang("webshop_txt_86", true) . "</span>\r\n                  <table width=\"100%\">\r\n                    <tr>\r\n                      <td>" . lang("webshop_txt_71", true) . "</td>\r\n                      <td align=\"right\">\r\n                        <em id=\"dPriceCoinC\" style=\"display: inline;\">" . ceil($mystery["price"]) . "</em>\r\n                        <div id=\"dPriceBit\" style=\"display: none;\">" . ceil($mystery["price"]) . "</div>\r\n                        <span class=\"creditTypeName\">--</span>\r\n                      </td>\r\n                    </tr>\r\n                    <tr>\r\n                      <td>" . lang("webshop_txt_72", true) . "</td>\r\n                      <td align=\"right\">\r\n                        <em id=\"optPriceCoinC\" style=\"display: inline;\">0</em>\r\n                        <span class=\"creditTypeName\">--</span>\r\n                      </td>\r\n                    </tr>\r\n                    <tr>\r\n                      <td>" . lang("webshop_txt_73", true) . "</td>\r\n                      <td align=\"right\">\r\n                        <em id=\"totPriceCoinC\" style=\"display: inline;\">" . ceil($mystery["price"]) . "</em>\r\n                        <span class=\"creditTypeName\">--</span>\r\n                      </td>\r\n                    </tr>\r\n                  </table>\r\n                </div>\r\n                <div class=\"webshop-buybtn\">\r\n                  <div style=\"float:right;\">\r\n                    <input type=\"hidden\" name=\"activeCredit\" id=\"activeCredit\" value=\"" . $activeCredit . "\" />\r\n                    <input type=\"submit\" name=\"buy\" id=\"buyBtnPrev\" value=\"" . lang("webshop_txt_87", true) . "\" class=\"btn_payment\">";
                                            if (mconfig("is_gift")) {
                                                echo "&nbsp;<input type=\"submit\" name=\"gift\" id=\"buyBtnPrev\" value=\"" . lang("webshop_txt_88", true) . "\" class=\"btn_payment\">";
                                            }
                                            echo "\r\n                  </div>\r\n                </div>\r\n              </form>\r\n            </div>";
                                        }
                                    }
                                }
                            }
                        }
                    } else {
                        echo "<script type=\"text/javascript\">\r\n                \$(document).ready(function()\r\n                {\r\n                  InitCategoryList();\r\n                });\r\n              </script>";
                        echo "\r\n        <div class=\"shop_fnc\">\r\n\t        <dl class=\"opt\">\r\n\t\t        <dt>" . lang("webshop_txt_89", true) . " </dt>\r\n\t\t        <dd>";
                        if ($config["use_platinum"]) {
                            echo "\r\n              <label class=\"label_check\">\r\n                <div></div>\r\n                <input type=\"checkbox\" class=\"chItemPrice\" id=\"chShowPlatinum\">\r\n                <p><font color=\"#00ffa8\">" . lang("currency_platinum", true) . "</font></p>\r\n              </label>";
                        }
                        if ($config["use_gold"]) {
                            echo "\r\n              <label class=\"label_check\">\r\n                <div></div>\r\n                <input type=\"checkbox\" class=\"chItemPrice\" id=\"chShowGold\" checked=\"checked\">\r\n                <p><font color=\"#b38e47\">" . lang("currency_gold", true) . "</font></p>\r\n              </label>";
                        }
                        if ($config["use_silver"]) {
                            echo "\r\n              <label class=\"label_check\">\r\n                <div></div>\r\n                <input type=\"checkbox\" class=\"chItemPrice\" id=\"chShowSilver\">\r\n                <p><font color=\"#959595\">" . lang("currency_silver", true) . "</font></p>\r\n              </label>";
                        }
                        echo "\r\n\t\t        </dd>\r\n\t        </dl>\r\n        </div>";
                        if ($cat == "1" && $sub == "30") {
                            $items = $Webshop->getPackages();
                            echo "<div class=\"shop_list\">";
                            if (0 < count($items)) {
                                foreach ($items as $thisItem) {
                                    echo "\r\n                    <a href=\"" . __BASE_URL__ . "webshop/shop/cat/" . $cat . "/?sub=" . $sub . "&type=" . Encode("package") . "&buy=" . Encode($thisItem["id"]) . "\" class=\"buy\" rel=\"\">\r\n                    <div class=\"item_wp\" id=\"item1\">\r\n                      <dl class=\"\">\r\n                        <dt>";
                                    $img = $thisItem["image"];
                                    if (file_exists("" . __PATH_TEMPLATE_ROOT__ . "img/items/" . $img)) {
                                        echo "<img src=\"" . __PATH_TEMPLATE__ . "img/items/" . $img . "\" alt=\"\">";
                                    } else {
                                        echo "<img src=\"" . __PATH_TEMPLATE_IMG__ . "misc_images/empty.png\" alt=\"\">";
                                    }
                                    if ($Webshop->isOnSale($thisItem["id"], "package")) {
                                        echo "<img src=\"" . __PATH_TEMPLATE__ . "img/ico_sale.gif\" alt=\"\">";
                                    }
                                    echo "\r\n                        </dt>\r\n                        <dd>\r\n                          <span class=\"itemname\"><b>" . $thisItem["name"] . "</b>";
                                    if ($thisItem["store_count"] != "-1") {
                                        echo " " . sprintf(lang("webshop_txt_93", true), $thisItem["store_count"]);
                                    }
                                    echo "</span>\r\n                          <div class=\"itemcost\">\r\n                            <div class=\"itemPricePlatinum\"><span class=\"itemPrice\"><font color=\"#00ffa8\">" . ceil($thisItem["price"] * mconfig("price_platinum")) . "</font></span>&nbsp;" . lang("currency_platinum", true) . "<br /></div>\r\n                            <div class=\"itemPriceGold\"><span class=\"itemPrice\"><font color=\"#b38e47\">" . ceil($thisItem["price"] * mconfig("price_gold")) . "</font></span>&nbsp;" . lang("currency_gold", true) . "<br /></div>\r\n                            <div class=\"itemPriceSilver\"><span class=\"itemPrice\"><font color=\"#959595\">" . ceil($thisItem["price"] * mconfig("price_silver")) . "</font></span>&nbsp;" . lang("currency_silver", true) . "<br /></div>\r\n                          </div>\r\n                        </dd>\r\n                      </dl>\r\n                    </div>\r\n                    </a>";
                                }
                            } else {
                                message("info", lang("webshop_txt_91", true));
                            }
                            echo "</div>";
                        } else {
                            if ($cat == "1" && $sub == "25") {
                                $items = $Webshop->getMystery();
                                echo "<div class=\"shop_list\">";
                                if (0 < count($items)) {
                                    foreach ($items as $thisItem) {
                                        echo "\r\n                    <a href=\"" . __BASE_URL__ . "webshop/shop/cat/" . $cat . "/?sub=" . $sub . "&type=" . Encode("mystery") . "&buy=" . Encode($thisItem["id"]) . "\" class=\"buy\" rel=\"\">\r\n                    <div class=\"item_wp\" id=\"item1\">\r\n                      <dl class=\"\">\r\n                        <dt>";
                                        $img = $thisItem["image"];
                                        echo "<img src=\"" . __PATH_TEMPLATE__ . "img/items/" . $img . "\" alt=\"\">";
                                        if ($Webshop->isOnSale($thisItem["id"], "mystery")) {
                                            echo "<img src=\"" . __PATH_TEMPLATE__ . "img/ico_sale.gif\" alt=\"\">";
                                        }
                                        echo "\r\n                        </dt>\r\n                        <dd>\r\n                          <span class=\"itemname\"><b>" . $thisItem["name"] . "</b>";
                                        if ($thisItem["store_count"] != "-1") {
                                            echo " " . sprintf(lang("webshop_txt_93", true), $thisItem["store_count"]);
                                        }
                                        echo "</span>\r\n                          <div class=\"itemcost\">\r\n                            <div class=\"itemPricePlatinum\"><span class=\"itemPrice\"><font color=\"#00ffa8\">" . ceil($thisItem["price"] * mconfig("price_platinum")) . "</font></span>&nbsp;" . lang("currency_platinum", true) . "<br /></div>\r\n                            <div class=\"itemPriceGold\"><span class=\"itemPrice\"><font color=\"#b38e47\">" . ceil($thisItem["price"] * mconfig("price_gold")) . "</font></span>&nbsp;" . lang("currency_gold", true) . "<br /></div>\r\n                            <div class=\"itemPriceSilver\"><span class=\"itemPrice\"><font color=\"#959595\">" . ceil($thisItem["price"] * mconfig("price_silver")) . "</font></span>&nbsp;" . lang("currency_silver", true) . "<br /></div>\r\n                          </div>\r\n                        </dd>\r\n                      </dl>\r\n                    </div>\r\n                    </a>";
                                    }
                                } else {
                                    message("info", lang("webshop_txt_91", true));
                                }
                                echo "</div>";
                            } else {
                                if ($sub == "all") {
                                    $items = $Webshop->getAllCatItems($cat);
                                } else {
                                    $items = $Webshop->getCatItems($cat, $sub);
                                }
                                echo "<div class=\"shop_list\">";
                                if (0 < count($items)) {
                                    foreach ($items as $thisItem) {
                                        echo "<a href=\"" . __BASE_URL__ . "webshop/shop/cat/" . $cat . "/?sub=" . $sub . "&type=" . Encode("normal") . "&buy=" . Encode($thisItem["id"]) . "\" class=\"buy\" rel=\"\">\r\n                                                                    <div class=\"item_wp\" id=\"item1\">\r\n                      <dl class=\"\">\r\n                        <dt>";
                                        $img = $Webshop->getImage($thisItem["id"]);
                                        echo "<img src=\"" . $img . "\" alt=\"\">";
                                        $sale = $Webshop->isOnSale($thisItem["id"], "normal");
                                        if (0 < $sale) {
                                            echo "<img src=\"" . __PATH_TEMPLATE__ . "img/ico_sale.gif\" alt=\"\">";
                                            $thisItem["price"] = ceil($thisItem["price"] * (100 - $sale) / 100);
                                        }
                                        echo "\r\n                        </dt>\r\n                        <dd>\r\n                          <span class=\"itemname\"><b>" . $thisItem["name"] . "</b>";
                                        if ($thisItem["store_count"] != "-1") {
                                            echo " " . sprintf(lang("webshop_txt_93", true), $thisItem["store_count"]);
                                        }
                                        echo "</span>\r\n                          <div class=\"itemcost\">\r\n                            <div class=\"itemPricePlatinum\"><span class=\"itemPrice\"><font color=\"#00ffa8\">" . ceil($thisItem["price"] * mconfig("price_platinum")) . "</font></span>&nbsp;" . lang("currency_platinum", true) . "<br /></div>\r\n                            <div class=\"itemPriceGold\"><span class=\"itemPrice\"><font color=\"#b38e47\">" . ceil($thisItem["price"] * mconfig("price_gold")) . "</font></span>&nbsp;" . lang("currency_gold", true) . "<br /></div>\r\n                            <div class=\"itemPriceSilver\"><span class=\"itemPrice\"><font color=\"#959595\">" . ceil($thisItem["price"] * mconfig("price_silver")) . "</font></span>&nbsp;" . lang("currency_silver", true) . "<br /></div>\r\n                          </div>\r\n                        </dd>\r\n                      </dl>\r\n                    </div>\r\n                    </a>";
                                    }
                                } else {
                                    message("info", lang("webshop_txt_91", true));
                                }
                                echo "</div>";
                            }
                        }
                    }
                }
            }
        } else {
            redirect(1, "webshop/shop/cat/1/?sub=all");
        }
        echo "\r\n                                    </div>\r\n                                </div>\r\n                            </div>\r\n                        </div>\r\n                        <div class=\"clear\"></div>\r\n                    </div>\r\n                </form>\r\n            </div>\r\n        </div>\r\n    </div>\r\n\r\n    ";
    } else {
        message("error", lang("error_47", true));
    }
}

?>