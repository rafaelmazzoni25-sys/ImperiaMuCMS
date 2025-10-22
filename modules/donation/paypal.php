<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

if (!isLoggedIn()) {
    redirect(1, "login");
} else {
    if (!canAccessModule($_SESSION["username"], "donation", "allow")) {
        return NULL;
    }
    if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
        $breadcrumb = generateBreadcrumb();
        echo "\r\n    <h3>\r\n        " . lang("module_titles_txt_21", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
        if (mconfig("active")) {
            echo "\r\n        <div class=\"row desc-row\">\r\n            <div class=\"col-xs-12\">";
            if (0 < mconfig("paypal_bonus_perc1")) {
                echo sprintf(lang("donation_txt_20", true), mconfig("paypal_bonus_amount1"), mconfig("paypal_currency"), mconfig("paypal_bonus_perc1"), lang("donation_txt_2", true)) . "<br>";
            }
            if (0 < mconfig("paypal_bonus_perc2")) {
                echo sprintf(lang("donation_txt_20", true), mconfig("paypal_bonus_amount2"), mconfig("paypal_currency"), mconfig("paypal_bonus_perc2"), lang("donation_txt_2", true)) . "<br>";
            }
            if (0 < mconfig("paypal_bonus_perc3")) {
                echo sprintf(lang("donation_txt_20", true), mconfig("paypal_bonus_amount3"), mconfig("paypal_currency"), mconfig("paypal_bonus_perc3"), lang("donation_txt_2", true)) . "<br>";
            }
            if (0 < mconfig("paypal_bonus_perc4")) {
                echo sprintf(lang("donation_txt_20", true), mconfig("paypal_bonus_amount4"), mconfig("paypal_currency"), mconfig("paypal_bonus_perc4"), lang("donation_txt_2", true)) . "<br>";
            }
            if (0 < mconfig("paypal_bonus_perc5")) {
                echo sprintf(lang("donation_txt_20", true), mconfig("paypal_bonus_amount5"), mconfig("paypal_currency"), mconfig("paypal_bonus_perc5"), lang("donation_txt_2", true)) . "<br>";
            }
            echo "\r\n            </div>\r\n        </div>";
            if (mconfig("paypal_enable_sandbox")) {
                echo "\r\n    <form action=\"https://www.sandbox.paypal.com/cgi-bin/webscr\" method=\"post\">";
            } else {
                echo "\r\n    <form action=\"https://www.paypal.com/cgi-bin/webscr\" method=\"post\">";
            }
            echo "\r\n        <div class=\"donation-gateway-container\">\r\n            <div class=\"donation-gateway-content\">\r\n                <div class=\"paypal-gateway-logo\"></div>\r\n                <div class=\"donation-gateway-form\">\r\n                    <div>";
            $order_id = md5(time());
            echo "\r\n                        <input type=\"hidden\" name=\"cmd\" value=\"_xclick\" />";
            if (mconfig("paypal_image") != "none") {
                echo "<input type=\"hidden\" name=\"cpp_header_image\" value=\"" . mconfig("paypal_image") . "\" />";
            }
            echo "\r\n                        <input type=\"hidden\" name=\"business\" value=\"" . mconfig("paypal_email") . "\" />\r\n                        <input type=\"hidden\" name=\"item_name\" value=\"" . mconfig("paypal_title") . " " . lang("donation_txt_19", true) . " " . $_SESSION["username"] . "\" />\r\n                        <input type=\"hidden\" name=\"item_number\" value=\"" . $order_id . "\" />\r\n                        <input type=\"hidden\" name=\"currency_code\" value=\"" . mconfig("paypal_currency") . "\" />\r\n                        <input type=\"text\" name=\"amount\" id=\"amount\" class=\"form-control\" maxlength=\"10\" value=\"0\" /> " . mconfig("paypal_currency") . " = <span id=\"result\">0</span> " . lang("donation_txt_2", true) . " <span id=\"bonus\">(0 " . lang("donation_txt_21", true) . ")</span>\r\n                    </div>\r\n                </div>\r\n                <div class=\"donation-gateway-continue\">\r\n                    <input type=\"hidden\" name=\"no_shipping\" value=\"1\" />\r\n                    <input type=\"hidden\" name=\"shipping\" value=\"0.00\" />\r\n                    <input type=\"hidden\" name=\"return\" value=\"" . mconfig("paypal_return_url") . "\" />\r\n                    <input type=\"hidden\" name=\"cancel_return\" value=\"" . mconfig("paypal_cancel_url") . "\" />\r\n                    <input type=\"hidden\" name=\"notify_url\" value=\"" . mconfig("paypal_notify_url") . "\" />\r\n                    <input type=\"hidden\" name=\"custom\" value=\"" . Encode($_SESSION["userid"]) . "\" />\r\n                    <input type=\"hidden\" name=\"no_note\" value=\"1\" />\r\n                    <input type=\"hidden\" name=\"tax\" value=\"0.00\" />\r\n                    <input type=\"hidden\" name=\"rm\" value=\"1\" />\r\n                    <br />\r\n                    <input style=\"display: none;\" type=\"submit\" name=\"submit\" id=\"submit\" class=\"btn btn-warning\" value=\"" . lang("donation_txt_7", true) . "\" />\r\n                </div>\r\n            </div>\r\n        </div>\r\n    </form>";
            echo "\r\n        <script type=\"text/javascript\">\r\n            document.getElementById('amount').onkeyup = function (ev) {\r\n                var num = 0;\r\n                var c = 0;\r\n                var event = window.event || ev;\r\n                var code = (event.keyCode) ? event.keyCode : event.charCode;\r\n                for (num = 0; num < this.value.length; num++) {\r\n                    c = this.value.charCodeAt(num);\r\n                    if (c < 48 || c > 57) {\r\n                        document.getElementById('result').innerHTML = '0';\r\n                        return false;\r\n                    }\r\n                }\r\n                var bonusTxt;\r\n                num = parseInt(this.value);\r\n                if (isNaN(num)) {\r\n                    document.getElementById('result').innerHTML = '0';\r\n                } else {\r\n                    if (num >= ";
            echo mconfig("paypal_bonus_amount5");
            echo " && ";
            echo mconfig("paypal_bonus_amount5");
            echo " > 0) {\r\n                        var result = ";
            echo mconfig("paypal_conversion_rate");
            echo " *\r\n                        num;\r\n                        var bonus = result / 100 * ";
            echo mconfig("paypal_bonus_perc5");
            echo ";\r\n                        result = result + bonus;\r\n                        result = result.toString();\r\n                    } else if (num >= ";
            echo mconfig("paypal_bonus_amount4");
            echo " && ";
            echo mconfig("paypal_bonus_amount4");
            echo " > 0) {\r\n                        var result = ";
            echo mconfig("paypal_conversion_rate");
            echo " *\r\n                        num;\r\n                        var bonus = result / 100 * ";
            echo mconfig("paypal_bonus_perc4");
            echo ";\r\n                        result = result + bonus;\r\n                        result = result.toString();\r\n                    } else if (num >= ";
            echo mconfig("paypal_bonus_amount3");
            echo " && ";
            echo mconfig("paypal_bonus_amount3");
            echo " > 0) {\r\n                        var result = ";
            echo mconfig("paypal_conversion_rate");
            echo " *\r\n                        num;\r\n                        var bonus = result / 100 * ";
            echo mconfig("paypal_bonus_perc3");
            echo ";\r\n                        result = result + bonus;\r\n                        result = result.toString();\r\n                    } else if (num >= ";
            echo mconfig("paypal_bonus_amount2");
            echo " && ";
            echo mconfig("paypal_bonus_amount2");
            echo " > 0) {\r\n                        var result = ";
            echo mconfig("paypal_conversion_rate");
            echo " *\r\n                        num;\r\n                        var bonus = result / 100 * ";
            echo mconfig("paypal_bonus_perc2");
            echo ";\r\n                        result = result + bonus;\r\n                        result = result.toString();\r\n                    } else if (num >= ";
            echo mconfig("paypal_bonus_amount1");
            echo " && ";
            echo mconfig("paypal_bonus_amount1");
            echo " > 0) {\r\n                        var result = ";
            echo mconfig("paypal_conversion_rate");
            echo " *\r\n                        num;\r\n                        var bonus = result / 100 * ";
            echo mconfig("paypal_bonus_perc1");
            echo ";\r\n                        result = result + bonus;\r\n                        result = result.toString();\r\n                    } else {\r\n                        var result = ";
            echo mconfig("paypal_conversion_rate");
            echo " *\r\n                        num;\r\n                        var bonus = 0;\r\n                        result = result.toString();\r\n                    }\r\n                    document.getElementById('result').innerHTML = result;\r\n                }\r\n\r\n                if (num == '' || num == null || isNaN(num) || num < ";
            echo mconfig("paypal_min");
            echo ") {\r\n                    document.getElementById('submit').style.display = 'none';\r\n                } else {\r\n                    document.getElementById('submit').style.display = '';\r\n                }\r\n\r\n                if (isNaN(bonus)) {\r\n                    bonus = 0;\r\n                    bonus = 0;\r\n                }\r\n                bonusTxt = \"(\" + bonus + \" ";
            echo lang("donation_txt_21", true);
            echo ")\";\r\n                bonusTxt = bonusTxt.toString();\r\n                document.getElementById('bonus').innerHTML = bonusTxt;\r\n            }\r\n        </script>\r\n\r\n        ";
        } else {
            message("error", lang("error_47", true));
        }
    } else {
        echo "\r\n  <div class=\"sub-page-title\">\r\n    <div id=\"title\">\r\n      <h1>" . lang("module_titles_txt_3", true) . "<p></p><span></span></h1>\r\n    </div>\r\n  </div>\r\n\r\n  <div class=\"container_2 account\" align=\"center\">\r\n    <div class=\"cont-image\">\r\n      <div class=\"container_3 account_sub_header\">\r\n        <div class=\"grad\">\r\n          <div class=\"page-title\"><p>" . lang("donation_txt_3", true) . "</p></div>\r\n          <div class=\"sub-active-page\">" . lang("module_titles_txt_21", true) . "</div>\r\n          <a href=\"" . __BASE_URL__ . "donation\">" . lang("donation_txt_6", true) . "</a>\r\n        </div>\r\n      </div>\r\n      <!-- Purchase Gold Coins -->\r\n      <div class=\"page-desc-holder\">";
        if (0 < mconfig("paypal_bonus_perc1")) {
            echo sprintf(lang("donation_txt_20", true), mconfig("paypal_bonus_amount1"), mconfig("paypal_currency"), mconfig("paypal_bonus_perc1"), lang("donation_txt_2", true)) . "<br>";
        }
        if (0 < mconfig("paypal_bonus_perc2")) {
            echo sprintf(lang("donation_txt_20", true), mconfig("paypal_bonus_amount2"), mconfig("paypal_currency"), mconfig("paypal_bonus_perc2"), lang("donation_txt_2", true)) . "<br>";
        }
        if (0 < mconfig("paypal_bonus_perc3")) {
            echo sprintf(lang("donation_txt_20", true), mconfig("paypal_bonus_amount3"), mconfig("paypal_currency"), mconfig("paypal_bonus_perc3"), lang("donation_txt_2", true)) . "<br>";
        }
        if (0 < mconfig("paypal_bonus_perc4")) {
            echo sprintf(lang("donation_txt_20", true), mconfig("paypal_bonus_amount4"), mconfig("paypal_currency"), mconfig("paypal_bonus_perc4"), lang("donation_txt_2", true)) . "<br>";
        }
        if (0 < mconfig("paypal_bonus_perc5")) {
            echo sprintf(lang("donation_txt_20", true), mconfig("paypal_bonus_amount5"), mconfig("paypal_currency"), mconfig("paypal_bonus_perc5"), lang("donation_txt_2", true)) . "<br>";
        }
        echo "</div>";
        if (mconfig("active")) {
            echo "\r\n    <div class=\"container_3 account-wide\" align=\"center\">";
            if (mconfig("paypal_enable_sandbox")) {
                echo "\r\n        <form action=\"https://www.sandbox.paypal.com/cgi-bin/webscr\" method=\"post\">";
            } else {
                echo "\r\n        <form action=\"https://www.paypal.com/cgi-bin/webscr\" method=\"post\">";
            }
            echo "\r\n            <div class=\"paypal-gateway-container\">\r\n                <div class=\"paypal-gateway-content\">\r\n                    <div class=\"paypal-gateway-logo\"></div>\r\n                    <div class=\"paypal-gateway-form\">\r\n                        <div>";
            $order_id = md5(time());
            echo "\r\n                            <input type=\"hidden\" name=\"cmd\" value=\"_xclick\" />";
            if (mconfig("paypal_image") != "none") {
                echo "<input type=\"hidden\" name=\"cpp_header_image\" value=\"" . mconfig("paypal_image") . "\" />";
            }
            echo "\r\n  \t\t\t\t\t\t\t<input type=\"hidden\" name=\"business\" value=\"" . mconfig("paypal_email") . "\" />\r\n  \t\t\t\t\t\t\t<input type=\"hidden\" name=\"item_name\" value=\"" . mconfig("paypal_title") . " " . lang("donation_txt_19", true) . " " . $_SESSION["username"] . "\" />\r\n  \t\t\t\t\t\t\t<input type=\"hidden\" name=\"item_number\" value=\"" . $order_id . "\" />\r\n  \t\t\t\t\t\t\t<input type=\"hidden\" name=\"currency_code\" value=\"" . mconfig("paypal_currency") . "\" />\r\n  \t\t\t\t\t\t\t<input type=\"text\" name=\"amount\" id=\"amount\" maxlength=\"4\" value=\"0\" /> " . mconfig("paypal_currency") . " = <span id=\"result\">0</span> " . lang("donation_txt_2", true) . " <span id=\"bonus\">(0 " . lang("donation_txt_21", true) . ")</span>\r\n  \t\t\t\t\t\t</div>\r\n  \t\t\t\t\t</div>\r\n  \t\t\t\t\t<div class=\"paypal-gateway-continue\">\r\n  \t\t\t\t\t\t<input type=\"hidden\" name=\"no_shipping\" value=\"1\" />\r\n  \t\t\t\t\t\t<input type=\"hidden\" name=\"shipping\" value=\"0.00\" />\r\n  \t\t\t\t\t\t<input type=\"hidden\" name=\"return\" value=\"" . mconfig("paypal_return_url") . "\" />\r\n  \t\t\t\t\t\t<input type=\"hidden\" name=\"cancel_return\" value=\"" . mconfig("paypal_cancel_url") . "\" />\r\n  \t\t\t\t\t\t<input type=\"hidden\" name=\"notify_url\" value=\"" . mconfig("paypal_notify_url") . "\" />\r\n  \t\t\t\t\t\t<input type=\"hidden\" name=\"custom\" value=\"" . Encode($_SESSION["userid"]) . "\" />\r\n  \t\t\t\t\t\t<input type=\"hidden\" name=\"no_note\" value=\"1\" />\r\n  \t\t\t\t\t\t<input type=\"hidden\" name=\"tax\" value=\"0.00\" />\r\n  \t\t\t\t\t\t<input type=\"hidden\" name=\"rm\" value=\"1\" />\r\n                        <br />\r\n  \t\t\t\t\t\t<input style=\"display: none;\" type=\"submit\" name=\"submit\" id=\"submit\" value=\"" . lang("donation_txt_7", true) . "\" />\r\n  \t\t\t\t\t</div>\r\n  \t\t\t\t</div>\r\n  \t\t\t</div>\r\n        </form>\r\n    </div>";
            echo "\r\n        <script type=\"text/javascript\">\r\n            document.getElementById('amount').onkeyup = function (ev) {\r\n                var num = 0;\r\n                var c = 0;\r\n                var event = window.event || ev;\r\n                var code = (event.keyCode) ? event.keyCode : event.charCode;\r\n                for (num = 0; num < this.value.length; num++) {\r\n                    c = this.value.charCodeAt(num);\r\n                    if (c < 48 || c > 57) {\r\n                        document.getElementById('result').innerHTML = '0';\r\n                        return false;\r\n                    }\r\n                }\r\n                var bonusTxt;\r\n                num = parseInt(this.value);\r\n                if (isNaN(num)) {\r\n                    document.getElementById('result').innerHTML = '0';\r\n                } else {\r\n                    if (num >= ";
            echo mconfig("paypal_bonus_amount5");
            echo " && ";
            echo mconfig("paypal_bonus_amount5");
            echo " > 0) {\r\n                        var result = ";
            echo mconfig("paypal_conversion_rate");
            echo " *\r\n                        num;\r\n                        var bonus = result / 100 * ";
            echo mconfig("paypal_bonus_perc5");
            echo ";\r\n                        result = result + bonus;\r\n                        result = result.toString();\r\n                    } else if (num >= ";
            echo mconfig("paypal_bonus_amount4");
            echo " && ";
            echo mconfig("paypal_bonus_amount4");
            echo " > 0) {\r\n                        var result = ";
            echo mconfig("paypal_conversion_rate");
            echo " *\r\n                        num;\r\n                        var bonus = result / 100 * ";
            echo mconfig("paypal_bonus_perc4");
            echo ";\r\n                        result = result + bonus;\r\n                        result = result.toString();\r\n                    } else if (num >= ";
            echo mconfig("paypal_bonus_amount3");
            echo " && ";
            echo mconfig("paypal_bonus_amount3");
            echo " > 0) {\r\n                        var result = ";
            echo mconfig("paypal_conversion_rate");
            echo " *\r\n                        num;\r\n                        var bonus = result / 100 * ";
            echo mconfig("paypal_bonus_perc3");
            echo ";\r\n                        result = result + bonus;\r\n                        result = result.toString();\r\n                    } else if (num >= ";
            echo mconfig("paypal_bonus_amount2");
            echo " && ";
            echo mconfig("paypal_bonus_amount2");
            echo " > 0) {\r\n                        var result = ";
            echo mconfig("paypal_conversion_rate");
            echo " *\r\n                        num;\r\n                        var bonus = result / 100 * ";
            echo mconfig("paypal_bonus_perc2");
            echo ";\r\n                        result = result + bonus;\r\n                        result = result.toString();\r\n                    } else if (num >= ";
            echo mconfig("paypal_bonus_amount1");
            echo " && ";
            echo mconfig("paypal_bonus_amount1");
            echo " > 0) {\r\n                        var result = ";
            echo mconfig("paypal_conversion_rate");
            echo " *\r\n                        num;\r\n                        var bonus = result / 100 * ";
            echo mconfig("paypal_bonus_perc1");
            echo ";\r\n                        result = result + bonus;\r\n                        result = result.toString();\r\n                    } else {\r\n                        var result = ";
            echo mconfig("paypal_conversion_rate");
            echo " *\r\n                        num;\r\n                        var bonus = 0;\r\n                        result = result.toString();\r\n                    }\r\n                    document.getElementById('result').innerHTML = result;\r\n                }\r\n\r\n                if (num == '' || num == null || isNaN(num) || num < ";
            echo mconfig("paypal_min");
            echo ") {\r\n                    document.getElementById('submit').style.display = 'none';\r\n                } else {\r\n                    document.getElementById('submit').style.display = '';\r\n                }\r\n\r\n                if (isNaN(bonus)) {\r\n                    bonus = 0;\r\n                    bonus = 0;\r\n                }\r\n                bonusTxt = \"(\" + bonus + \" ";
            echo lang("donation_txt_21", true);
            echo ")\";\r\n                bonusTxt = bonusTxt.toString();\r\n                document.getElementById('bonus').innerHTML = bonusTxt;\r\n            }\r\n        </script>\r\n\r\n        ";
        } else {
            message("error", lang("error_47", true));
        }
        echo "\r\n      <!-- Purchase Gold Coins.End -->\r\n    </div>\r\n  </div>\r\n\t";
    }
}

?>