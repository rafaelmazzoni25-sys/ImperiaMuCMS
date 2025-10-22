<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

if (!isLoggedIn()) {
    redirect(1, "login");
} else {
    if (!canAccessModule($_SESSION["username"], "donation", "allow")) {
        return NULL;
    }
    $order_id = md5(time());
    if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
        $breadcrumb = generateBreadcrumb();
        echo "\n    <h3>\n        " . lang("module_titles_txt_35", true) . "\n        " . $breadcrumb . "\n    </h3>";
        if (mconfig("active")) {
            $General = new xGeneral();
            $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("mercadopago");
            $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("mercadopago");
            echo "\n        <div class=\"row desc-row\">\n            <div class=\"col-xs-12\">";
            if (0 < mconfig("mercadopago_bonus_perc1")) {
                echo sprintf(lang("donation_txt_20", true), mconfig("mercadopago_bonus_amount1"), mconfig("mercadopago_currency"), mconfig("mercadopago_bonus_perc1"), lang("donation_txt_2", true)) . "<br>";
            }
            if (0 < mconfig("mercadopago_bonus_perc2")) {
                echo sprintf(lang("donation_txt_20", true), mconfig("mercadopago_bonus_amount2"), mconfig("mercadopago_currency"), mconfig("mercadopago_bonus_perc2"), lang("donation_txt_2", true)) . "<br>";
            }
            if (0 < mconfig("mercadopago_bonus_perc3")) {
                echo sprintf(lang("donation_txt_20", true), mconfig("mercadopago_bonus_amount3"), mconfig("mercadopago_currency"), mconfig("mercadopago_bonus_perc3"), lang("donation_txt_2", true)) . "<br>";
            }
            if (0 < mconfig("mercadopago_bonus_perc4")) {
                echo sprintf(lang("donation_txt_20", true), mconfig("mercadopago_bonus_amount4"), mconfig("mercadopago_currency"), mconfig("mercadopago_bonus_perc4"), lang("donation_txt_2", true)) . "<br>";
            }
            if (0 < mconfig("mercadopago_bonus_perc5")) {
                echo sprintf(lang("donation_txt_20", true), mconfig("mercadopago_bonus_amount5"), mconfig("mercadopago_currency"), mconfig("mercadopago_bonus_perc5"), lang("donation_txt_2", true)) . "<br>";
            }
            echo "\n            </div>\n        </div>";
            echo show_flash_msg();
            if (check_value($_GET["type"])) {
                switch ($_GET["type"]) {
                    case "success":
                        message("success", lang("donation_txt_55", true));
                        break;
                    case "fail":
                        message("error", lang("donation_txt_57", true));
                        break;
                    case "pending":
                        message("info", lang("donation_txt_56", true));
                        break;
                }
            }
            echo "\n        <form action=\"" . __BASE_URL__ . "api/mercadopago/mercadopago_payment.php\" method=\"post\">\n            <div class=\"donation-gateway-container\">\n                <div class=\"donation-gateway-content\">\n                    <div class=\"mercadopago-gateway-logo\"></div>\n                    <div class=\"donation-gateway-form\">\n                        <div>\n                            <input type=\"hidden\" name=\"order_id\" value=\"" . $order_id . "\"/>\n                            <input type=\"text\" name=\"amount\" id=\"amount\" class=\"form-control\" maxlength=\"10\" value=\"0\"/> " . mconfig("mercadopago_currency") . " = \n                            <span id=\"result\">0</span> " . lang("donation_txt_2", true) . " \n                            <span id=\"bonus\">(0 " . lang("donation_txt_21", true) . ")</span>\n                        </div>\n                    </div>\n                    <div class=\"donation-gateway-continue\">\n                        <input type=\"hidden\" name=\"custom\" value=\"" . Encode($_SESSION["userid"]) . "\"/><br/>\n                        <input style=\"display: none;\" type=\"submit\" name=\"submit\" id=\"submit\" class=\"btn btn-warning\" value=\"" . lang("donation_txt_43", true) . "\"/>\n                    </div>\n                </div>\n            </div>\n        </form>";
            echo "\n        <script type=\"text/javascript\">\n            document.getElementById('amount').onkeyup = function (ev) {\n                var num = 0;\n                var c = 0;\n                var event = window.event || ev;\n                var code = (event.keyCode) ? event.keyCode : event.charCode;\n                for (num = 0; num < this.value.length; num++) {\n                    c = this.value.charCodeAt(num);\n                    if (c < 48 || c > 57) {\n                        document.getElementById('result').innerHTML = '0';\n                        return false;\n                    }\n                }\n                var bonusTxt;\n                num = parseInt(this.value);\n                if (isNaN(num)) {\n                    document.getElementById('result').innerHTML = '0';\n                } else {\n                    var result = ";
            echo mconfig("mercadopago_conversion_rate");
            echo " *\n                    num;\n                    var bonus = 0;\n\n                    if (num >= ";
            echo mconfig("mercadopago_bonus_amount5");
            echo " && ";
            echo mconfig("mercadopago_bonus_amount5");
            echo " > 0) {\n                        bonus = result / 100 * ";
            echo mconfig("mercadopago_bonus_perc5");
            echo ";\n                    } else if (num >= ";
            echo mconfig("mercadopago_bonus_amount4");
            echo " && ";
            echo mconfig("mercadopago_bonus_amount4");
            echo " > 0) {\n                        bonus = result / 100 * ";
            echo mconfig("mercadopago_bonus_perc4");
            echo ";\n                    } else if (num >= ";
            echo mconfig("mercadopago_bonus_amount3");
            echo " && ";
            echo mconfig("mercadopago_bonus_amount3");
            echo " > 0) {\n                        bonus = result / 100 * ";
            echo mconfig("mercadopago_bonus_perc3");
            echo ";\n                    } else if (num >= ";
            echo mconfig("mercadopago_bonus_amount2");
            echo " && ";
            echo mconfig("mercadopago_bonus_amount2");
            echo " > 0) {\n                        bonus = result / 100 * ";
            echo mconfig("mercadopago_bonus_perc2");
            echo ";\n                    } else if (num >= ";
            echo mconfig("mercadopago_bonus_amount1");
            echo " && ";
            echo mconfig("mercadopago_bonus_amount1");
            echo " > 0) {\n                        bonus = result / 100 * ";
            echo mconfig("mercadopago_bonus_perc1");
            echo ";\n                    }\n\n                    result = result + bonus;\n                    result = result.toString();\n\n                    document.getElementById('result').innerHTML = result;\n                }\n\n                if (num == '' || num == null || isNaN(num) || num < ";
            echo mconfig("mercadopago_min");
            echo ") {\n                    document.getElementById('submit').style.display = 'none';\n                } else {\n                    document.getElementById('submit').style.display = '';\n                }\n\n                if (isNaN(bonus)) {\n                    bonus = 0;\n                    bonus = 0;\n                }\n                bonusTxt = \"(\" + bonus + \" ";
            echo lang("donation_txt_21", true);
            echo ")\";\n                bonusTxt = bonusTxt.toString();\n                document.getElementById('bonus').innerHTML = bonusTxt;\n            }\n        </script>\n\n        ";
        } else {
            message("error", lang("error_47", true));
        }
    } else {
        echo "\n    <div class=\"sub-page-title\">\n        <div id=\"title\">\n            <h1>";
        echo lang("module_titles_txt_3", true);
        echo "<p></p><span></span></h1>\n        </div>\n    </div>\n\n    <div class=\"container_2 account\" align=\"center\">\n        <div class=\"cont-image\">\n            <div class=\"container_3 account_sub_header\">\n                <div class=\"grad\">\n                    <div class=\"page-title\"><p>";
        echo lang("donation_txt_3", true);
        echo "</p></div>\n                    <div class=\"sub-active-page\">";
        echo lang("module_titles_txt_35", true);
        echo "</div>\n                    <a href=\"";
        echo __BASE_URL__;
        echo "donation\">";
        echo lang("donation_txt_6", true);
        echo "</a>\n                </div>\n            </div>\n            <div class=\"page-desc-holder\">\n                ";
        if (0 < mconfig("mercadopago_bonus_perc1")) {
            echo sprintf(lang("donation_txt_20", true), mconfig("mercadopago_bonus_amount1"), mconfig("mercadopago_currency"), mconfig("mercadopago_bonus_perc1"), lang("donation_txt_2", true)) . "<br>";
        }
        if (0 < mconfig("mercadopago_bonus_perc2")) {
            echo sprintf(lang("donation_txt_20", true), mconfig("mercadopago_bonus_amount2"), mconfig("mercadopago_currency"), mconfig("mercadopago_bonus_perc2"), lang("donation_txt_2", true)) . "<br>";
        }
        if (0 < mconfig("mercadopago_bonus_perc3")) {
            echo sprintf(lang("donation_txt_20", true), mconfig("mercadopago_bonus_amount3"), mconfig("mercadopago_currency"), mconfig("mercadopago_bonus_perc3"), lang("donation_txt_2", true)) . "<br>";
        }
        if (0 < mconfig("mercadopago_bonus_perc4")) {
            echo sprintf(lang("donation_txt_20", true), mconfig("mercadopago_bonus_amount4"), mconfig("mercadopago_currency"), mconfig("mercadopago_bonus_perc4"), lang("donation_txt_2", true)) . "<br>";
        }
        if (0 < mconfig("mercadopago_bonus_perc5")) {
            echo sprintf(lang("donation_txt_20", true), mconfig("mercadopago_bonus_amount5"), mconfig("mercadopago_currency"), mconfig("mercadopago_bonus_perc5"), lang("donation_txt_2", true)) . "<br>";
        }
        echo "            </div>\n            ";
        echo show_flash_msg();
        echo "            ";
        if (check_value($_GET["type"])) {
            switch ($_GET["type"]) {
                case "success":
                    message("success", lang("donation_txt_55", true));
                    break;
                case "fail":
                    message("error", lang("donation_txt_57", true));
                    break;
                case "pending":
                    message("info", lang("donation_txt_56", true));
                    break;
            }
        }
        echo "            ";
        if (mconfig("active")) {
            $General = new xGeneral();
            $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("mercadopago");
            $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("mercadopago");
            echo "                <div class=\"container_3 account-wide\" align=\"center\">\n                    <form action=\"";
            echo __BASE_URL__;
            echo "api/mercadopago/mercadopago_payment.php\" method=\"post\">\n                        <div class=\"mercadopago-gateway-container\">\n                            <div class=\"mercadopago-gateway-content\">\n                                <div class=\"mercadopago-gateway-logo\"></div>\n                                <div class=\"mercadopago-gateway-form\">\n                                    <div>\n                                        <input type=\"hidden\" name=\"order_id\" value=\"";
            echo $order_id;
            echo "\"/>\n                                        <input type=\"text\" name=\"amount\" id=\"amount\" maxlength=\"4\"\n                                               value=\"0\"/> ";
            echo mconfig("mercadopago_currency");
            echo " = <span\n                                                id=\"result\">0</span> ";
            echo lang("donation_txt_2", true);
            echo " <span\n                                                id=\"bonus\">(0 ";
            echo lang("donation_txt_21", true);
            echo ")</span>\n                                    </div>\n                                </div>\n                                <div class=\"mercadopago-gateway-continue\">\n                                    <input type=\"hidden\" name=\"custom\"\n                                           value=\"";
            echo Encode($_SESSION["userid"]);
            echo "\"/>\n                                    <br/>\n                                    <input style=\"display: none;\" type=\"submit\" name=\"submit\" id=\"submit\"\n                                           value=\"";
            echo lang("donation_txt_43", true);
            echo "\"/>\n                                </div>\n                            </div>\n                        </div>\n                    </form>\n                </div>\n\n                <script type=\"text/javascript\">\n                    document.getElementById('amount').onkeyup = function (ev) {\n                        var num = 0;\n                        var c = 0;\n                        var event = window.event || ev;\n                        var code = (event.keyCode) ? event.keyCode : event.charCode;\n                        for (num = 0; num < this.value.length; num++) {\n                            c = this.value.charCodeAt(num);\n                            if (c < 48 || c > 57) {\n                                document.getElementById('result').innerHTML = '0';\n                                return false;\n                            }\n                        }\n                        var bonusTxt;\n                        num = parseInt(this.value);\n                        if (isNaN(num)) {\n                            document.getElementById('result').innerHTML = '0';\n                        } else {\n                            var result = ";
            echo mconfig("mercadopago_conversion_rate");
            echo " *\n                            num;\n                            var bonus = 0;\n\n                            if (num >= ";
            echo mconfig("mercadopago_bonus_amount5");
            echo " && ";
            echo mconfig("mercadopago_bonus_amount5");
            echo " > 0) {\n                                bonus = result / 100 * ";
            echo mconfig("mercadopago_bonus_perc5");
            echo ";\n                            } else if (num >= ";
            echo mconfig("mercadopago_bonus_amount4");
            echo " && ";
            echo mconfig("mercadopago_bonus_amount4");
            echo " > 0) {\n                                bonus = result / 100 * ";
            echo mconfig("mercadopago_bonus_perc4");
            echo ";\n                            } else if (num >= ";
            echo mconfig("mercadopago_bonus_amount3");
            echo " && ";
            echo mconfig("mercadopago_bonus_amount3");
            echo " > 0) {\n                                bonus = result / 100 * ";
            echo mconfig("mercadopago_bonus_perc3");
            echo ";\n                            } else if (num >= ";
            echo mconfig("mercadopago_bonus_amount2");
            echo " && ";
            echo mconfig("mercadopago_bonus_amount2");
            echo " > 0) {\n                                bonus = result / 100 * ";
            echo mconfig("mercadopago_bonus_perc2");
            echo ";\n                            } else if (num >= ";
            echo mconfig("mercadopago_bonus_amount1");
            echo " && ";
            echo mconfig("mercadopago_bonus_amount1");
            echo " > 0) {\n                                bonus = result / 100 * ";
            echo mconfig("mercadopago_bonus_perc1");
            echo ";\n                            }\n\n                            result = result + bonus;\n                            result = result.toString();\n\n                            document.getElementById('result').innerHTML = result;\n                        }\n\n                        if (num == '' || num == null || isNaN(num) || num < ";
            echo mconfig("mercadopago_min");
            echo ") {\n                            document.getElementById('submit').style.display = 'none';\n                        } else {\n                            document.getElementById('submit').style.display = '';\n                        }\n\n                        if (isNaN(bonus)) {\n                            bonus = 0;\n                            bonus = 0;\n                        }\n                        bonusTxt = \"(\" + bonus + \" ";
            echo lang("donation_txt_21", true);
            echo ")\";\n                        bonusTxt = bonusTxt.toString();\n                        document.getElementById('bonus').innerHTML = bonusTxt;\n                    }\n                </script>\n                ";
        } else {
            message("error", lang("error_47", true));
        }
        echo "        </div>\n    </div>\n    ";
    }
}

?>