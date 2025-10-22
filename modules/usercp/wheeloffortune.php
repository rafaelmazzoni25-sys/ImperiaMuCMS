<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */
echo "<script type=\"text/javascript\"\r\n        src=\"https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.6/js/jquery.fancybox.min.js\"></script>\r\n<script type=\"text/javascript\" src=\"https://cdnjs.cloudflare.com/ajax/libs/velocity/1.4.3/velocity.min.js\"></script>\r\n<link rel=\"stylesheet\" href=\"https://cdn.jsdelivr.net/fancybox/2.1.5/jquery.fancybox.min.css\"/>\r\n";
if (!isLoggedIn()) {
    redirect(1, "login");
} else {
    if (!canAccessModule($_SESSION["username"], "wheeloffortune", "block")) {
        return NULL;
    }
    if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
        $breadcrumb = generateBreadcrumb();
        echo "\r\n    <h3>\r\n        " . lang("wheeloffortune_txt_1", true);
        if (check_value($_GET["sub"]) && $_GET["sub"] == "history") {
            echo "<a href=\"" . __BASE_URL__ . "usercp/wheeloffortune\" class=\"btn btn-warning btn-navtop\">" . lang("wheeloffortune_txt_12", true) . "</a>";
        } else {
            echo "<a href=\"" . __BASE_URL__ . "usercp/wheeloffortune?sub=history\" class=\"btn btn-warning btn-navtop\">" . lang("wheeloffortune_txt_10", true) . "</a>";
        }
        echo "\r\n        " . $breadcrumb . "\r\n    </h3>";
        if (check_value($_GET["sub"]) && $_GET["sub"] == "history") {
            echo "\r\n    <div class=\"rankings-table\">\r\n        <table class=\"table table-hover text-center\">\r\n            <tr>\r\n                <th class=\"headerRow\">" . lang("wheeloffortune_txt_20", true) . "</th>\r\n                <th class=\"headerRow\">" . lang("wheeloffortune_txt_24", true) . "</th>\r\n                <th class=\"headerRow\">" . lang("wheeloffortune_txt_21", true) . "</th>\r\n            </tr>";
            $history = $dB->query_fetch("SELECT TOP 50 * FROM IMPERIAMUCMS_WHEEL_OF_FORTUNE WHERE AccountID = ? ORDER BY date DESC", [$_SESSION["username"]]);
            if (is_array($history)) {
                foreach ($history as $thisRow) {
                    echo "\r\n            <tr>\r\n                <td>" . date($config["time_date_format"], strtotime($thisRow["date"])) . "</td>\r\n                <td>" . $thisRow["reward_title"] . "</td>\r\n                <td>";
                    if (0 < $thisRow["price"]) {
                        echo $thisRow["price"] . " ";
                        switch ($thisRow["price_type"]) {
                            case 1:
                                $currencyName = lang("currency_platinum", true);
                                break;
                            case 2:
                                $currencyName = lang("currency_gold", true);
                                break;
                            case 3:
                                $currencyName = lang("currency_silver", true);
                                break;
                            case 4:
                                $currencyName = lang("currency_wcoinc", true);
                                break;
                            case -4:
                                $currencyName = lang("currency_wcoinp", true);
                                break;
                            case 5:
                                $currencyName = lang("currency_gp", true);
                                break;
                            case 6:
                                $currencyName = "" . lang("currency_zen", true) . "";
                                break;
                            case 7:
                                $currencyName = "" . lang("currency_bless", true) . "";
                                break;
                            case 8:
                                $currencyName = "" . lang("currency_soul", true) . "";
                                break;
                            case 9:
                                $currencyName = "" . lang("currency_life", true) . "";
                                break;
                            case 10:
                                $currencyName = "" . lang("currency_chaos", true) . "";
                                break;
                            case 11:
                                $currencyName = "" . lang("currency_harmony", true) . "";
                                break;
                            case 12:
                                $currencyName = "" . lang("currency_creation", true) . "";
                                break;
                            case 13:
                                $currencyName = "" . lang("currency_guardian", true) . "";
                                break;
                            default:
                                $query = $dB->query_fetch_single("SELECT name FROM IMPERIAMUCMS_WEB_BANK_CUSTOM WHERE ident = ?", [$thisRow["price_type"]]);
                                $currencyName = $query["name"];
                                echo $currencyName;
                        }
                    } else {
                        echo lang("wheeloffortune_txt_23", true);
                    }
                    echo "\r\n                </td>\r\n            </tr>";
                }
            } else {
                echo "\r\n            <tr>\r\n                <td colspan=\"3\" align=\"center\">" . lang("wheeloffortune_txt_22", true) . "</td>\r\n            </tr>";
            }
            echo "\r\n        </table>\r\n    </div>";
        } else {
            if (mconfig("active")) {
                $General = new xGeneral();
                $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("wheeloffortune");
                $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("wheeloffortune");
                echo "\r\n        <div class=\"fortune-msg-holder\"></div>\r\n        <div class=\"row desc-row\">\r\n            <div class=\"col-xs-12\">";
                $intervalInfo = false;
                if (mconfig("enabled_month_day_start") != "-1" && mconfig("enabled_month_day_end") != "-1") {
                    if (mconfig("enabled_month_day_start") == mconfig("enabled_month_day_end")) {
                        echo sprintf(lang("wheeloffortune_txt_4", true), sprintf(lang("wheeloffortune_txt_5", true), mconfig("enabled_month_day_start")), sprintf(lang("wheeloffortune_txt_9", true), mconfig("enabled_hour_start"), mconfig("enabled_hour_end")));
                    } else {
                        echo sprintf(lang("wheeloffortune_txt_4", true), sprintf(lang("wheeloffortune_txt_6", true), mconfig("enabled_month_day_start"), mconfig("enabled_month_day_end")), sprintf(lang("wheeloffortune_txt_9", true), mconfig("enabled_hour_start"), mconfig("enabled_hour_end")));
                    }
                    $intervalInfo = true;
                }
                if (mconfig("enabled_week_day_start") != "-1" && mconfig("enabled_week_day_end") != "-1") {
                    if (mconfig("enabled_week_day_start") == mconfig("enabled_week_day_end")) {
                        echo sprintf(lang("wheeloffortune_txt_4", true), sprintf(lang("wheeloffortune_txt_7", true), returnDayName(mconfig("enabled_week_day_start"))), sprintf(lang("wheeloffortune_txt_9", true), mconfig("enabled_hour_start"), mconfig("enabled_hour_end")));
                    } else {
                        echo sprintf(lang("wheeloffortune_txt_4", true), sprintf(lang("wheeloffortune_txt_8", true), returnDayName(mconfig("enabled_week_day_start")), returnDayName(mconfig("enabled_week_day_end"))), sprintf(lang("wheeloffortune_txt_9", true), mconfig("enabled_hour_start"), mconfig("enabled_hour_end")));
                    }
                    $intervalInfo = true;
                }
                if (lang("wheeloffortune_txt_13", true) != NULL && lang("wheeloffortune_txt_13", true) != "") {
                    if ($intervalInfo) {
                        echo "<br><br>";
                    }
                    echo lang("wheeloffortune_txt_13", true);
                }
                $totalCurrency = 0;
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
                        if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                            $totalCurrency = $dB2->query_fetch_single("SELECT gold FROM MEMB_CREDITS WHERE memb___id = ?", [$_SESSION["username"]]);
                        } else {
                            $totalCurrency = $dB->query_fetch_single("SELECT gold FROM MEMB_CREDITS WHERE memb___id = ?", [$_SESSION["username"]]);
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
                        $query = $dB->query_fetch_single("SELECT name FROM IMPERIAMUCMS_WEB_BANK_CUSTOM WHERE ident = ?", [$currencyId]);
                        $dbName = str_replace(" ", "_", $query["name"]);
                        $totalCurrency = $dB->query_fetch_single("SELECT " . $dbName . " FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$_SESSION["username"]]);
                        $totalCurrency = $totalCurrency[$dbName];
                        $query = $dB->query_fetch_single("SELECT name FROM IMPERIAMUCMS_WEB_BANK_CUSTOM WHERE ident = ?", [$thisRow["price_type"]]);
                        $currencyName = $query["name"];
                        echo "<p>" . sprintf(lang("wheeloffortune_txt_25", true), mconfig("price"), $currencyName) . "</p>";
                        echo sprintf(lang("wheeloffortune_txt_26", true), $totalCurrency, $currencyName);
                        echo "\r\n        </div>\r\n    </div>\r\n    <div class=\"row\">\r\n        <div class=\"col-xs-12\">\r\n            <div class=\"table-responsive rankings-table\">";
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
                        } else {
                            if ($monthDay_start <= $currentMonthDay && $currentMonthDay <= $monthDay_end) {
                                $check_monthDay = true;
                            }
                        }
                        if ($weekDay_start == "-1" && $weekDay_end == "-1") {
                            $check_weekDay = true;
                        } else {
                            if ($weekDay_start <= $currentWeekDay && $currentWeekDay <= $weekDay_end) {
                                $check_weekDay = true;
                            }
                        }
                        if ($hour_start <= $currentHour && $currentHour < $hour_end) {
                            $check_hour = true;
                        }
                        if (!($check_monthDay && $check_weekDay && $check_hour)) {
                            message("info", lang("wheeloffortune_txt_16", true));
                        }
                        $totalItems = mconfig("items");
                        $degreesPerItem = 360 / $totalItems;
                        $circleCount = mconfig("circle_count");
                        $circleDegrees = $circleCount * 360;
                        $intervalMin = mconfig("interval_min");
                        $intervalMax = mconfig("interval_max");
                        echo "\r\n            <style>\r\n                .hide {\r\n                    display: none;\r\n                }\r\n\r\n                ";
                        $circle = 0;
                        if ($totalItems == 6) {
                            $cssLeft = "-100px";
                        } else {
                            if ($totalItems == 8) {
                                $cssLeft = "-59px";
                            } else {
                                if ($totalItems == 10) {
                                    $cssLeft = "-38px";
                                } else {
                                    if ($totalItems == 12) {
                                        $cssLeft = "-22px";
                                    } else {
                                        if ($totalItems == 14) {
                                            $cssLeft = "-10px";
                                        } else {
                                            if ($totalItems == 16) {
                                                $cssLeft = "-2px";
                                            } else {
                                                $cssLeft = 0;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        echo "\r\n                        .itembg {\r\n                            top: 0;\r\n                            width: 0;\r\n                            height: 0;\r\n                            border-left: " . $circle / $totalItems / 0 . "px solid transparent;\r\n                            border-right: " . $circle / $totalItems / 0 . "px solid transparent;\r\n                            left: " . $cssLeft . ";\r\n                        }";
                        $i = 0;
                        while ($i < $totalItems) {
                            echo "\r\n                        .wheel li:nth-child(" . ($i + 1) . ") {\r\n                            -webkit-transform: rotate(" . $i * $degreesPerItem . "deg);\r\n                            -moz-transform: rotate(" . $i * $degreesPerItem . "deg);\r\n                            -ms-transform: rotate(" . $i * $degreesPerItem . "deg);\r\n                            -o-transform: rotate(" . $i * $degreesPerItem . "deg);\r\n                            transform: rotate(" . $i * $degreesPerItem . "deg);\r\n                        }";
                            $i++;
                        }
                        echo "                .wheel li:nth-child(odd) img {\r\n                    -webkit-opacity: 0.8;\r\n                    -moz-opacit: 0.8;\r\n                    opacity: 0.8;\r\n                }\r\n            </style>\r\n\r\n            <div class=\"skills-wheel\">\r\n                <ul class=\"wheel\">\r\n                    ";
                        $hiddenPopups = "";
                        $i = 0;
                        $rewards = mconfig("rewards");
                        if (is_array($rewards["reward"])) {
                            foreach ($rewards["reward"] as $thisReward) {
                                if ($thisReward["@attributes"]["custombg"] == "1" && $thisReward["@attributes"]["bgcolor"] != NULL && $thisReward["@attributes"]["bgcolor"] != "") {
                                    $customBg = " style=\"border-top: 268px solid #" . $thisReward["@attributes"]["bgcolor"] . ";\"";
                                } else {
                                    $customBg = "";
                                }
                                echo "\r\n                    <li>\r\n                        <img class=\"itembg itembg2\" src=\"" . __PATH_TEMPLATE__ . "style/images/triangle1.png\"" . $customBg . " />\r\n                        <a href=\"#item" . $i . "\" title=\"" . $thisReward["@attributes"]["title"] . "\" class=\"fancybox\">\r\n                            <img src=\"" . __PATH_TEMPLATE_ASSETS__ . "items/" . $thisReward["@attributes"]["img"] . "\" title=\"" . $thisReward["@attributes"]["title"] . "\" />\r\n                        </a>\r\n                    </li>";
                                $hiddenPopups .= "\r\n    <div id=\"item" . $i . "\" class=\"hide\">\r\n        <h2>" . lang("wheeloffortune_txt_3", true) . "</h2>\r\n        <p>" . $thisReward["@attributes"]["title"] . "</p>\r\n        <p>" . $thisReward["@attributes"]["desc"] . "</p>\r\n    </div>";
                                $i++;
                            }
                        }
                        echo "                </ul>\r\n\r\n                <a href=\"#/\" id=\"spin\" title=\"";
                        lang("wheeloffortune_txt_2", false);
                        echo "\"\r\n                   class=\"btn\">";
                        lang("wheeloffortune_txt_2", false);
                        echo "</a>\r\n            </div>\r\n\r\n            ";
                        if (!($check_monthDay && $check_weekDay && $check_hour)) {
                            echo "<div style=\"width: 600px; height: 560px; background: rgba(0, 0, 0, .5); z-index: 9999; position: relative; margin-top: -584px; margin-bottom: 20px; border-radius: 20px;\"></div>";
                        }
                        echo $hiddenPopups;
                        echo "\r\n<script>\r\nvar _target, _deg = 0;\r\nvar request;\r\n\r\nfunction startAnimation(serverMsg) {\r\n    // start animation\r\n    // reset opacity of all segments to 1\r\n    \$(\".fancybox\").parent(\"li\").velocity({\r\n        opacity: 1\r\n    }, {\r\n        duration: 100,\r\n        complete: function () {\r\n            \$(\".wheel\").velocity({\r\n                rotateZ: \"-\" + _deg + \"deg\"\r\n            }, {\r\n                duration: 15000,\r\n                easing: \"easeInOutQuart\",\r\n                complete: function (elements) {\r\n                    \r\n                    //alert(\"success: \" + serverMsg);\r\n                    \r\n                    // after spinning animation is completed, set opacity of target segment's parent\r\n                    \$(\".fancybox\").parent(\"li\").eq(_target).velocity({\r\n                        opacity: 0.4\r\n                    }, {\r\n                        duration: 1000,\r\n                        // after opacity is completed, fire targeted segment in fancybox\r\n                        complete: function () {\r\n                            //\$(\".fancybox\").eq(_target).trigger(\"click\");\r\n                            \$(\".fortune-msg-holder\").after(\"<div class='container_3 green wide fading-notification' align='left'><span class='error_icons success'></span><p>" . lang("notification_success", true) . " \" + serverMsg + \"</p></div>\");\r\n                            enableFading();\r\n                            \$(\"#spin\").removeClass(\"spinDisabled\");\r\n                        } // third animation completed\r\n                    }); // nested velocity 2\r\n                } // second animation completed\r\n            }); // nested velocity 1\r\n        } // first animation completed\r\n    }); // velocity\r\n}\r\n\r\nfunction enableFading() {\r\n    var delay = 10000;\r\n    \$('.fading-notification').each(function(){\r\n        \$(this).delay(delay).fadeOut(500);\r\n        delay = delay + 500;\r\n    });\r\n}\r\n\r\n\$(document).ready(function (\$) {\r\n    \$(\".skills-wheel .btn\").on(\"click\", function (e) {\r\n        \$(\"#spin\").addClass(\"spinDisabled\");\r\n        // Abort any pending request\r\n        if (request) {\r\n            request.abort();\r\n        }\r\n        request = \$.ajax({\r\n            url: \"" . __BASE_URL__ . "ajax/wheeloffortune.php\",\r\n            type: \"post\",   \r\n            data: \"deg=\" + _deg,\r\n            success: function(data) {\r\n                var jsonData = JSON.parse(data);\r\n                //alert(\"success: \" + data);\r\n                if (jsonData.error) {\r\n                    \$(\".fortune-msg-holder\").after(\"<div class='container_3 red wide fading-notification' align='left'><span class='error_icons attention'></span><p>" . lang("notification_error", true) . " \" + jsonData.error + \"</p></div>\");                    \r\n                    enableFading();\r\n                    \$(\"#spin\").removeClass(\"spinDisabled\");\r\n                } else {\r\n                    _deg = jsonData.deg;\r\n                    _target = jsonData.target;\r\n                    startAnimation(jsonData.msg);\r\n                }\r\n            }\r\n        });\r\n        return false;\r\n    }); // click\r\n\r\n    // initialize fancybox\r\n    \$(\".fancybox\").fancybox({\r\n        maxWidth: \"85%\"\r\n    });\r\n}); // ready\r\n</script>";
                }
            } else {
                message("error", lang("error_47", true));
            }
            echo "\r\n        </div>\r\n    </div>\r\n</div>";
        }
    } else {
        echo "\r\n<div class=\"sub-page-title\">\r\n    <div id=\"title\">\r\n        <h1>" . lang("module_titles_txt_3", true) . "<p></p><span></span></h1>\r\n    </div>\r\n</div>";
        if (check_value($_GET["sub"]) && $_GET["sub"] == "history") {
            echo "\r\n<div class=\"container_2 account\" align=\"center\">\r\n    <div class=\"cont-image\">\r\n        <div class=\"container_3 account_sub_header\">\r\n            <div class=\"grad\">\r\n                <div class=\"page-title\"><p>" . lang("wheeloffortune_txt_1", true) . "</p></div>\r\n                <div class=\"sub-active-page\">" . lang("wheeloffortune_txt_11", true) . "</div>\r\n                <a href=\"" . __BASE_URL__ . "usercp/wheeloffortune\" style=\"background-image: none;padding: 9px 12px 10px 10px\">" . lang("wheeloffortune_txt_12", true) . "</a>\r\n                <a href=\"" . __BASE_URL__ . "usercp\">" . lang("global_module_1", true) . "</a>\r\n            </div>\r\n        </div>\r\n        <div class=\"page-desc-holder\"></div>\r\n        \r\n        <div class=\"account-wide\" align=\"center\">\r\n            <table width=\"100%\" class=\"irq\">\r\n                <tr>\r\n                    <th>" . lang("wheeloffortune_txt_20", true) . "</th>\r\n                    <th>" . lang("wheeloffortune_txt_24", true) . "</th>\r\n                    <th>" . lang("wheeloffortune_txt_21", true) . "</th>\r\n                </tr>";
            $history = $dB->query_fetch("SELECT TOP 50 * FROM IMPERIAMUCMS_WHEEL_OF_FORTUNE WHERE AccountID = ? ORDER BY date DESC", [$_SESSION["username"]]);
            if (is_array($history)) {
                foreach ($history as $thisRow) {
                    echo "\r\n                <tr>\r\n                    <td>" . date($config["time_date_format"], strtotime($thisRow["date"])) . "</td>\r\n                    <td>" . $thisRow["reward_title"] . "</td>\r\n                    <td>";
                    if (0 < $thisRow["price"]) {
                        echo $thisRow["price"] . " ";
                        switch ($thisRow["price_type"]) {
                            case 1:
                                $currencyName = lang("currency_platinum", true);
                                break;
                            case 2:
                                $currencyName = lang("currency_gold", true);
                                break;
                            case 3:
                                $currencyName = lang("currency_silver", true);
                                break;
                            case 4:
                                $currencyName = lang("currency_wcoinc", true);
                                break;
                            case -4:
                                $currencyName = lang("currency_wcoinp", true);
                                break;
                            case 5:
                                $currencyName = lang("currency_gp", true);
                                break;
                            case 6:
                                $currencyName = "" . lang("currency_zen", true) . "";
                                break;
                            case 7:
                                $currencyName = "" . lang("currency_bless", true) . "";
                                break;
                            case 8:
                                $currencyName = "" . lang("currency_soul", true) . "";
                                break;
                            case 9:
                                $currencyName = "" . lang("currency_life", true) . "";
                                break;
                            case 10:
                                $currencyName = "" . lang("currency_chaos", true) . "";
                                break;
                            case 11:
                                $currencyName = "" . lang("currency_harmony", true) . "";
                                break;
                            case 12:
                                $currencyName = "" . lang("currency_creation", true) . "";
                                break;
                            case 13:
                                $currencyName = "" . lang("currency_guardian", true) . "";
                                break;
                            default:
                                $query = $dB->query_fetch_single("SELECT name FROM IMPERIAMUCMS_WEB_BANK_CUSTOM WHERE ident = ?", [$thisRow["price_type"]]);
                                $currencyName = $query["name"];
                                echo $currencyName;
                        }
                    } else {
                        echo lang("wheeloffortune_txt_23", true);
                    }
                    echo "\r\n                    </td>\r\n                </tr>";
                }
            } else {
                echo "\r\n                <tr>\r\n                    <td colspan=\"3\" align=\"center\">";
                message("info", lang("wheeloffortune_txt_22", true));
                echo "\r\n                    </td>\r\n                </tr>";
            }
            echo "\r\n            </table>\r\n        </div>\r\n    </div>\r\n</div>";
        } else {
            echo "\r\n<div class=\"container_2 account\" align=\"center\">\r\n    <div class=\"cont-image\">\r\n        <div class=\"container_3 account_sub_header\">\r\n            <div class=\"grad\">\r\n                <div class=\"page-title\"><p>" . lang("wheeloffortune_txt_1", true) . "</p></div>\r\n                <a href=\"" . __BASE_URL__ . "usercp/wheeloffortune?sub=history\" style=\"background-image: none;padding: 9px 12px 10px 10px\">" . lang("wheeloffortune_txt_10", true) . "</a>\r\n                <a href=\"" . __BASE_URL__ . "usercp\">" . lang("global_module_1", true) . "</a>\r\n            </div>\r\n        </div>\r\n        <div class=\"page-desc-holder\">";
            $intervalInfo = false;
            if (mconfig("enabled_month_day_start") != "-1" && mconfig("enabled_month_day_end") != "-1") {
                if (mconfig("enabled_month_day_start") == mconfig("enabled_month_day_end")) {
                    echo sprintf(lang("wheeloffortune_txt_4", true), sprintf(lang("wheeloffortune_txt_5", true), mconfig("enabled_month_day_start")), sprintf(lang("wheeloffortune_txt_9", true), mconfig("enabled_hour_start"), mconfig("enabled_hour_end")));
                } else {
                    echo sprintf(lang("wheeloffortune_txt_4", true), sprintf(lang("wheeloffortune_txt_6", true), mconfig("enabled_month_day_start"), mconfig("enabled_month_day_end")), sprintf(lang("wheeloffortune_txt_9", true), mconfig("enabled_hour_start"), mconfig("enabled_hour_end")));
                }
                $intervalInfo = true;
            }
            if (mconfig("enabled_week_day_start") != "-1" && mconfig("enabled_week_day_end") != "-1") {
                if (mconfig("enabled_week_day_start") == mconfig("enabled_week_day_end")) {
                    echo sprintf(lang("wheeloffortune_txt_4", true), sprintf(lang("wheeloffortune_txt_7", true), returnDayName(mconfig("enabled_week_day_start"))), sprintf(lang("wheeloffortune_txt_9", true), mconfig("enabled_hour_start"), mconfig("enabled_hour_end")));
                } else {
                    echo sprintf(lang("wheeloffortune_txt_4", true), sprintf(lang("wheeloffortune_txt_8", true), returnDayName(mconfig("enabled_week_day_start")), returnDayName(mconfig("enabled_week_day_end"))), sprintf(lang("wheeloffortune_txt_9", true), mconfig("enabled_hour_start"), mconfig("enabled_hour_end")));
                }
                $intervalInfo = true;
            }
            if (lang("wheeloffortune_txt_13", true) != NULL && lang("wheeloffortune_txt_13", true) != "") {
                if ($intervalInfo) {
                    echo "<br><br>";
                }
                echo lang("wheeloffortune_txt_13", true);
            }
            $totalCurrency = 0;
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
                    if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                        $totalCurrency = $dB2->query_fetch_single("SELECT gold FROM MEMB_CREDITS WHERE memb___id = ?", [$_SESSION["username"]]);
                    } else {
                        $totalCurrency = $dB->query_fetch_single("SELECT gold FROM MEMB_CREDITS WHERE memb___id = ?", [$_SESSION["username"]]);
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
                    $query = $dB->query_fetch_single("SELECT name FROM IMPERIAMUCMS_WEB_BANK_CUSTOM WHERE ident = ?", [$currencyId]);
                    $dbName = str_replace(" ", "_", $query["name"]);
                    $totalCurrency = $dB->query_fetch_single("SELECT " . $dbName . " FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$_SESSION["username"]]);
                    $totalCurrency = $totalCurrency[$dbName];
                    $query = $dB->query_fetch_single("SELECT name FROM IMPERIAMUCMS_WEB_BANK_CUSTOM WHERE ident = ?", [$thisRow["price_type"]]);
                    $currencyName = $query["name"];
                    echo "<p>" . sprintf(lang("wheeloffortune_txt_25", true), mconfig("price"), $currencyName) . "</p>";
                    echo "<p>" . sprintf(lang("wheeloffortune_txt_26", true), $totalCurrency, $currencyName) . "</p>";
                    echo "\r\n        </div>";
                    if (mconfig("active")) {
                        $General = new xGeneral();
                        $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("wheeloffortune");
                        $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("wheeloffortune");
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
                        } else {
                            if ($monthDay_start <= $currentMonthDay && $currentMonthDay <= $monthDay_end) {
                                $check_monthDay = true;
                            }
                        }
                        if ($weekDay_start == "-1" && $weekDay_end == "-1") {
                            $check_weekDay = true;
                        } else {
                            if ($weekDay_start <= $currentWeekDay && $currentWeekDay <= $weekDay_end) {
                                $check_weekDay = true;
                            }
                        }
                        if ($hour_start <= $currentHour && $currentHour < $hour_end) {
                            $check_hour = true;
                        }
                        if (!($check_monthDay && $check_weekDay && $check_hour)) {
                            message("info", lang("wheeloffortune_txt_16", true));
                        }
                        echo "\r\n        <div class=\"container_3 account-wide\" align=\"center\" style=\"padding-top: 20px; padding-bottom: 1px;\">";
                        $totalItems = mconfig("items");
                        $degreesPerItem = 360 / $totalItems;
                        $circleCount = mconfig("circle_count");
                        $circleDegrees = $circleCount * 360;
                        $intervalMin = mconfig("interval_min");
                        $intervalMax = mconfig("interval_max");
                        echo "\r\n            <style>\r\n                .hide {\r\n                    display: none;\r\n                }\r\n\r\n                ";
                        $circle = 0;
                        if ($totalItems == 6) {
                            $cssLeft = "-100px";
                        } else {
                            if ($totalItems == 8) {
                                $cssLeft = "-59px";
                            } else {
                                if ($totalItems == 10) {
                                    $cssLeft = "-38px";
                                } else {
                                    if ($totalItems == 12) {
                                        $cssLeft = "-22px";
                                    } else {
                                        if ($totalItems == 14) {
                                            $cssLeft = "-10px";
                                        } else {
                                            if ($totalItems == 16) {
                                                $cssLeft = "-2px";
                                            } else {
                                                $cssLeft = 0;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        echo "\r\n                .itembg2 {\r\n                    top: 0;\r\n                    width: 0;\r\n                    height: 0;\r\n                    border-left: " . $circle / $totalItems / 0 . "px solid transparent;\r\n                    border-right: " . $circle / $totalItems / 0 . "px solid transparent;\r\n                    border-top: 268px solid rgba(62, 46, 38, 1);\r\n                    left: " . $cssLeft . ";\r\n                }";
                        $i = 0;
                        while ($i < $totalItems) {
                            echo "\r\n                .wheel li:nth-child(" . ($i + 1) . ") {\r\n                    -webkit-transform: rotate(" . $i * $degreesPerItem . "deg);\r\n                    -moz-transform: rotate(" . $i * $degreesPerItem . "deg);\r\n                    -ms-transform: rotate(" . $i * $degreesPerItem . "deg);\r\n                    -o-transform: rotate(" . $i * $degreesPerItem . "deg);\r\n                    transform: rotate(" . $i * $degreesPerItem . "deg);";
                            echo "\r\n                }";
                            $i++;
                        }
                        echo "                .wheel li:nth-child(odd) img {\r\n                    -webkit-opacity: 0.8;\r\n                    -moz-opacit: 0.8;\r\n                    opacity: 0.8;\r\n                }\r\n            </style>\r\n\r\n            <div class=\"skills-wheel\">\r\n                <ul class=\"wheel\">\r\n                    ";
                        $hiddenPopups = "";
                        $i = 0;
                        $rewards = mconfig("rewards");
                        if (is_array($rewards["reward"])) {
                            foreach ($rewards["reward"] as $thisReward) {
                                if ($thisReward["@attributes"]["custombg"] == "1" && $thisReward["@attributes"]["bgcolor"] != NULL && $thisReward["@attributes"]["bgcolor"] != "") {
                                    $customBg = " style=\"border-top: 268px solid #" . $thisReward["@attributes"]["bgcolor"] . ";\"";
                                } else {
                                    $customBg = "";
                                }
                                echo "\r\n            <li>\r\n                <img class=\"itembg\" src=\"" . __PATH_TEMPLATE__ . "style/images/triangle1.png\"" . $customBg . " />\r\n                <a href=\"#item" . $i . "\" title=\"" . $thisReward["@attributes"]["title"] . "\" class=\"fancybox\">\r\n                    <img src=\"" . __PATH_TEMPLATE__ . "img/items/" . $thisReward["@attributes"]["img"] . "\" title=\"" . $thisReward["@attributes"]["title"] . "\" />\r\n                </a>\r\n            </li>";
                                $hiddenPopups .= "\r\n    <div id=\"item" . $i . "\" class=\"hide\">\r\n    <h2>" . lang("wheeloffortune_txt_3", true) . "</h2>\r\n        <p>" . $thisReward["@attributes"]["title"] . "</p>\r\n        <p>" . $thisReward["@attributes"]["desc"] . "</p>\r\n    </div>";
                                $i++;
                            }
                        }
                        echo "                </ul>\r\n\r\n                <a href=\"#/\" id=\"spin\" title=\"";
                        lang("wheeloffortune_txt_2", false);
                        echo "\"\r\n                   class=\"btn\">";
                        lang("wheeloffortune_txt_2", false);
                        echo "</a>\r\n            </div>\r\n\r\n            ";
                        if (!($check_monthDay && $check_weekDay && $check_hour)) {
                            echo "<div style=\"width: 600px; height: 560px; background: rgba(0, 0, 0, .5); z-index: 9999; position: relative; margin-top: -584px; margin-bottom: 20px; border-radius: 20px;\"></div>";
                        }
                        echo $hiddenPopups;
                        echo "\r\n<script>\r\nvar _target, _deg = 0;\r\nvar request;\r\n\r\nfunction startAnimation(serverMsg) {\r\n    // start animation\r\n    // reset opacity of all segments to 1\r\n    \$(\".fancybox\").parent(\"li\").velocity({\r\n        opacity: 1\r\n    }, {\r\n        duration: 100,\r\n        complete: function () {\r\n            \$(\".wheel\").velocity({\r\n                rotateZ: \"-\" + _deg + \"deg\"\r\n            }, {\r\n                duration: 15000,\r\n                easing: \"easeInOutQuart\",\r\n                complete: function (elements) {\r\n                    \r\n                    //alert(\"success: \" + serverMsg);\r\n                    \r\n                    // after spinning animation is completed, set opacity of target segment's parent\r\n                    \$(\".fancybox\").parent(\"li\").eq(_target).velocity({\r\n                        opacity: 0.4\r\n                    }, {\r\n                        duration: 1000,\r\n                        // after opacity is completed, fire targeted segment in fancybox\r\n                        complete: function () {\r\n                            //\$(\".fancybox\").eq(_target).trigger(\"click\");\r\n                            \$(\".page-desc-holder\").after(\"<div class='container_3 green wide fading-notification' align='left'><span class='error_icons success'></span><p>" . lang("notification_success", true) . " \" + serverMsg + \"</p></div>\");\r\n                            enableFading();\r\n                            \$(\"#spin\").removeClass(\"spinDisabled\");\r\n                        } // third animation completed\r\n                    }); // nested velocity 2\r\n                } // second animation completed\r\n            }); // nested velocity 1\r\n        } // first animation completed\r\n    }); // velocity\r\n}\r\n\r\nfunction enableFading() {\r\n    var delay = 10000;\r\n    \$('.fading-notification').each(function(){\r\n        \$(this).delay(delay).fadeOut(500);\r\n        delay = delay + 500;\r\n    });\r\n}\r\n\r\n\$(document).ready(function (\$) {\r\n    \$(\".skills-wheel .btn\").on(\"click\", function (e) {\r\n        \$(\"#spin\").addClass(\"spinDisabled\");\r\n        // Abort any pending request\r\n        if (request) {\r\n            request.abort();\r\n        }\r\n        request = \$.ajax({\r\n            url: \"" . __BASE_URL__ . "ajax/wheeloffortune.php\",\r\n            type: \"post\",   \r\n            data: \"deg=\" + _deg,\r\n            success: function(data) {\r\n                var jsonData = JSON.parse(data);\r\n                //alert(\"success: \" + data);\r\n                if (jsonData.error) {\r\n                    \$(\".page-desc-holder\").after(\"<div class='container_3 red wide fading-notification' align='left'><span class='error_icons attention'></span><p>" . lang("notification_error", true) . " \" + jsonData.error + \"</p></div>\");                    \r\n                    enableFading();\r\n                    \$(\"#spin\").removeClass(\"spinDisabled\");\r\n                } else {\r\n                    _deg = jsonData.deg;\r\n                    _target = jsonData.target;\r\n                    startAnimation(jsonData.msg);\r\n                }\r\n            }\r\n        });\r\n        return false;\r\n    }); // click\r\n\r\n    // initialize fancybox\r\n    \$(\".fancybox\").fancybox({\r\n        maxWidth: \"85%\"\r\n    });\r\n}); // ready\r\n</script>";
                        echo "\r\n        </div>";
                    } else {
                        message("error", lang("error_47", true));
                    }
                    echo "\r\n    </div>\r\n</div>";
            }
        }
    }
}

?>