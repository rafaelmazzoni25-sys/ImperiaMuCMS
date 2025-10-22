<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */
if (!defined("access") || !access) {
    exit;
}
define("__RESPONSIVE__", "FALSE");
include "inc/template.functions.php";
echo "<!doctype html>\n<html lang=\"en\">\n<head>\n    ";
echo $handler->printHeader();
echo "\n    <meta name=\"author\" content=\"jacubb\">\n    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">\n    <meta http-equiv=\"Content-Language\" content=\"en\">\n    <meta name=\"language\" content=\"English\">\n    <meta name=\"type\" content=\"website\">\n    <meta name=\"copyright\" content=\"Copyright ImperiaMuCMS\">\n    <meta name=\"resource-type\" content=\"games\">\n    <meta name=\"Distribution\" content=\"Global\">\n    <meta name=\"Rating\" content=\"General\">\n    <meta name=\"robots\" content=\"INDEX,FOLLOW\">\n    <meta name=\"Revisit-after\" content=\"7 Days\">\n    <meta name=\"DC.Creator\" content=\"php\">\n    <meta name=\"DC.Description\" content=\"Welcome to the best free server.\">\n    <meta name=\"DC.Type\" content=\"text\">\n    <meta name=\"DC.Language\" content=\"en\">\n    <meta name=\"DC.Rights\" content=\"(c) ImperiaMuCMS all rights reserved.\">\n\n    <link rel=\"stylesheet\" href=\"";
echo __PATH_TEMPLATE__;
echo "style/main.css?v=25\"/>\n    <link rel=\"stylesheet\" href=\"";
echo __PATH_TEMPLATE__;
echo "style/flag-icon.min.css\"/>\n\n    <script type=\"text/javascript\" src=\"";
echo __PATH_TEMPLATE__;
echo "js/jquery-1.7.js\"></script>\n    <script type=\"text/javascript\" src=\"";
echo __PATH_TEMPLATE__;
echo "js/jquery.cycle.all.js\"></script>\n    <script type=\"text/javascript\" src=\"";
echo __PATH_TEMPLATE__;
echo "js/jquery.cycle2.min.js\"></script>\n    <script type=\"text/javascript\" src=\"";
echo __PATH_TEMPLATE__;
echo "js/jquery.maskedinput.js\"></script>\n\n    <script type=\"text/javascript\" src=\"";
echo __PATH_TEMPLATE__;
echo "js/select.js\"></script>\n    <script type=\"text/javascript\" src=\"";
echo __PATH_TEMPLATE__;
echo "js/video.bg.js\"></script>\n    <script type=\"text/javascript\" src=\"";
echo __PATH_TEMPLATE__;
echo "js/custom.js\"></script>\n    <script type=\"text/javascript\" src=\"";
echo __PATH_TEMPLATE__;
echo "js/alertbox.js\"></script>\n    <script type=\"text/javascript\" src=\"";
echo __PATH_TEMPLATE__;
echo "js/jquery.easing.1.3.js\"></script>\n    <!--<script type=\"text/javascript\" src=\"";
echo __PATH_TEMPLATE__;
echo "js/power.js\"></script>-->\n\n    <script type=\"text/javascript\" src=\"";
echo __PATH_TEMPLATE__;
echo "js/store.js\"></script>\n    <script type=\"text/javascript\" src=\"";
echo __PATH_TEMPLATE__;
echo "js/jquery.tinyscrollbar.min.js\"></script>\n    <script type=\"text/javascript\" src=\"";
echo __PATH_TEMPLATE__;
echo "js/WebShop.js\"></script>\n    <script type=\"text/javascript\" src=\"";
echo __PATH_TEMPLATE__;
echo "js/WebShopFnc.js?v=12\"></script>\n    <script type=\"text/javascript\" src=\"";
echo __PATH_TEMPLATE__;
echo "js/global_functions.js\"></script>\n\n\n    ";
echo "\n    <script>\n        var lang = new Array(\"" . lang("template_txt_39", true) . "\",\"" . lang("template_txt_40", true) . "\",\"" . lang("template_txt_41", true) . "\",\"" . lang("template_txt_42", true) . "\");\n    </script>";
include_once "inc/modules/google_analytics.php";
echo "\n    ";
if (isSidebar()) {
    echo "        <script type=\"text/javascript\">\n            var currenttime = '";
    echo date("F j, Y H:i:s");
    echo "';\n            var montharray = new Array(\"January\", \"February\", \"March\", \"April\", \"May\", \"June\", \"July\", \"August\", \"September\", \"October\", \"November\", \"December\");\n            var serverdate = new Date(currenttime);\n\n            function padlength(what) {\n                var output = (what.toString().length == 1) ? \"0\" + what : what;\n                return output;\n            }\n\n            function displaytime() {\n                serverdate.setSeconds(serverdate.getSeconds() + 1);\n                var datestring = montharray[serverdate.getMonth()] + \" \" + padlength(serverdate.getDate()) + \", \" + serverdate.getFullYear();\n                var timestring = padlength(serverdate.getHours()) + \":\" + padlength(serverdate.getMinutes()) + \":\" + padlength(serverdate.getSeconds());\n                //document.getElementById(\"servertime\").innerHTML = \"";
    echo lang("server_time", true);
    echo "<br />\" + datestring + \" \" + timestring;\n                document.getElementById(\"servertime\").innerHTML = \"";
    echo lang("server_time", true);
    echo "<br />\" + \"<p id='server-time-cloack'>\" + timestring + \"</p>\";\n            }\n\n            window.onload = function () {\n                setInterval(\"displaytime()\", 1000);\n            }\n        </script>\n    ";
}
echo "</head>\n<body>\n<center>\n\n    ";
if ($config["language_switch_active"]) {
    echo "<div class=\"language-switch\">";
    foreach ($config["languages"] as $thisLang) {
        echo "<a href=\"" . __BASE_URL__ . "language/switch/?to=" . $thisLang[1] . "\"><img src=\"" . __PATH_TEMPLATE__ . "style/images/blank.png\" class=\"flag-icon flag-icon-" . $thisLang[2] . "\" alt=\"" . $custom["countries"][$thisLang[2]] . "\" title=\"" . $thisLang[0] . "\" /></a> ";
    }
    echo "</div>";
}
echo "\n    <!--HEADER-->\n    <div id=\"header\" align=\"center\">\n        <div class=\"holder\">\n            ";
include "inc/modules/navigation.php";
echo "        </div>\n    </div>\n    <!--HEADER.End-->\n\n    <!--SLIDER-->\n    <div id=\"image_header\" align=\"center\">\n        <div class=\"slider\" id=\"warcry-slider\" align=\"center\">\n            <!-- TextFader Cycle JQuery Plugin -->\n            <script type=\"text/javascript\">\n                \$(function () {\n                    setTimeout(function () {\n                        \$(\"#IndexTextFader\").cycle(\n                            {\n                                random: 1,\n                                delay: -6000\n                            });\n                    }, 1000);\n                });\n            </script>\n            <div id=\"IndexTextFader\">\n                <!--<img src=\"";
echo __PATH_TEMPLATE__;
echo "style/images/IndexSlider/1.png\" style=\"opacity:0;\"/>\n                <img src=\"";
echo __PATH_TEMPLATE__;
echo "style/images/IndexSlider/2.png\" style=\"opacity:0;\"/>-->\n            </div>\n        </div>\n    </div>\n    <!--SLIDER.End-->\n\n    <div class=\"main_a_holder\" align=\"center\">\n        <!-- BODY-->\n        <div class=\"main_b_holder\" align=\"center\">\n            <!--Membership-->\n            <div class=\"membership-holder\">\n                <div class=\"membership-bar\">\n                    ";
if (!isLoggedIn()) {
    echo "                        <!--Not logged-->\n                        <div class=\"member-side-left\">\n                            <ul class=\"not-logged-menu\">\n                                <li class=\"login-home\"><a id=\"login\" href=\"";
    echo __BASE_URL__;
    echo "login\"><p></p> <span></span></a></li>\n                                <li class=\"register-home\"><a id=\"register\" href=\"";
    echo __BASE_URL__;
    echo "register\"><p></p> <span></span></a></li>\n                            </ul>\n                        </div>\n                        <!--Not logged.End-->\n                    ";
} else {
    echo "                        <!-- Logged In -->\n                        <div class=\"logged_in_bar member-side-left\">\n                            <div class=\"logged_in_bar_bg\">\n                                <div class=\"logout-btn-cont\">\n                                    <a id=\"logout\" href=\"";
    echo __BASE_URL__;
    echo "logout\"><span></span>\n\n                                        <p></p></a>\n                                </div>\n                                <div class=\"info\">\n                                    <p>";
    echo lang("template_txt_22", true);
    echo " <font color=\"#bf873f\" style=\"font-size: 13px;\"><a href=\"#\" class=\"username\">";
    echo $_SESSION["username"];
    echo "</a></font>! ";
    echo lang("template_txt_23", true);
    echo "</p>\n\n                                    ";
    $accountBalance = $common->accountBalance($_SESSION["username"]);
    echo "\n                                    <div class=\"coints\">\n                                        ";
    if ($config["use_platinum"]) {
        echo "<span id=\"platinum_str\">" . $accountBalance["platinum"] . "</span> " . lang("template_txt_24", true);
    }
    echo "                                        ";
    if ($config["use_gold"]) {
        echo "<span id=\"gold_str\">" . $accountBalance["gold"] . "</span> " . lang("template_txt_25", true);
    }
    echo "                                        ";
    if ($config["use_silver"]) {
        echo "<span id=\"silver_str\">" . $accountBalance["silver"] . "</span> " . lang("template_txt_26", true);
    }
    echo "                                    </div>\n                                </div>\n                                ";
    include "inc/modules/control_panel.php";
    echo "                            </div>\n                        </div>\n                        <!-- Logged In.End -->\n                    ";
}
echo "                    <div class=\"memeber-side-right\">\n                        <div class=\"bonus-m-links\">\n                            <a href=\"";
echo __BASE_URL__;
echo "faq\">";
echo lang("template_txt_27", true);
echo "</a>\n                            <a href=\"";
echo __BASE_URL__;
echo "forgotpassword\">";
echo lang("template_txt_28", true);
echo "</a>\n                        </div>\n                        <div class=\"search\" align=\"left\">\n                            <form action=\"";
echo __BASE_URL__;
echo "search\" method=\"post\" id=\"search\">\n                                <input type=\"text\" name=\"charname\" maxlength=\"10\" title=\"";
echo lang("template_txt_29", true);
echo "\" placeholder=\"";
echo lang("template_txt_29", true);
echo "\"><input type=\"submit\" value=\"\">\n                                <input type=\"hidden\" value=\"search\" name=\"search\"/>\n                            </form>\n                        </div>\n                    </div>\n                </div>\n            </div>\n            <!--Membership.End-->\n            <div class=\"sec_b_holder\" align=\"center\">\n                <div id=\"body\" align=\"left\">\n                    <!-- BODY Content start here -->\n                    <div class=\"content_holder\">\n                        ";
if (isSidebar()) {
    echo "                            ";
    include "inc/modules/announcement.php";
    echo "                            <div class=\"main_side\">\n                                <div class=\"index_news\">\n                                    ";
    include "inc/modules/top.php";
    echo "                                    <div class=\"news_container\">\n                                        ";
    $handler->loadModule($_REQUEST["page"], $_REQUEST["subpage"]);
    echo "                                    </div>\n                                </div>\n                                ";
    include "inc/modules/bottom.php";
    echo "                            </div>\n                            ";
    include "inc/modules/sidebar.php";
    echo "                            <div class=\"clear\"></div>\n\n                        ";
} else {
    if ($config["enable_scroll_down"]) {
        echo "\n                                <script>\n                                    \$(document).ready(function () {\n                                        \$('html, body').animate({\n                                            scrollTop: \$('.sub-page-title').offset().top\n                                        }, 'fast');\n                                    });\n                                </script>";
    }
    $handler->loadModule($_REQUEST["page"], $_REQUEST["subpage"]);
    echo "\n                        ";
}
echo "                    </div>\n                    <!-- BODY Content end here -->\n                </div>\n            </div>\n            <!-- BODY-->\n        </div>\n    </div>\n    <div class=\"footer-holder\">\n        <div id=\"footer\">\n            ";
include "inc/modules/footer.php";
echo "        </div>\n        <div class=\"bot-foot-border\">\n            ";
$handler->imperiamucmsPowered();
echo "        </div>\n    </div>\n</center>\n</body>\n</html>";

?>