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
        echo "\r\n    <h3>\r\n        " . lang("module_titles_txt_27", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
        if (mconfig("active")) {
            $General = new xGeneral();
            $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("pagseguro");
            $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("pagseguro");
            echo "\r\n        <div class=\"donation-gateway-container\">\r\n            <div class=\"donation-gateway-content\">\r\n                <div class=\"pagseguro-gateway-logo\"></div>\r\n                <div class=\"donation-gateway-form\">\r\n                    <div>\r\n                        <input name=\"receiverEmail\" type=\"hidden\" value=\"" . mconfig("pgseguro_email") . "\">\r\n                        <input name=\"currency\" type=\"hidden\" value=\"" . mconfig("pgseguro_currency") . "\">\r\n                        <input name=\"itemId1\" type=\"hidden\" value=\"0001\">\r\n                        <input name=\"itemDescription1\" type=\"hidden\" value=\"" . mconfig("pgseguro_itemtitle") . "\">\r\n                        <input name=\"itemAmount1\" id=\"itemAmount1\" type=\"hidden\" value=\"0\">\r\n                        <input name=\"itemQuantity1\" type=\"hidden\" value=\"1\">\r\n                        <input name=\"reference\" type=\"hidden\" value=\"" . $_SESSION["username"] . "\">\r\n                        <input type=\"text\" name=\"amount\" id=\"amount\" class=\"form-control\" maxlength=\"10\" value=\"0\" /> " . mconfig("pgseguro_currency") . " = <span id=\"result\">0</span> " . lang("donation_txt_2", true) . "\r\n                    </div>\r\n                </div>\r\n                <div class=\"donation-gateway-continue\">\r\n                    <br />\r\n                    <input style=\"display: none;\" type=\"submit\" name=\"submit\" id=\"submit\" class=\"btn btn-warning\" value=\"" . lang("donation_txt_78", true) . "\" />\r\n                </div>\r\n            </div>\r\n        </div>";
            echo "\r\n        <script type=\"text/javascript\">\r\n            document.getElementById('amount').onkeyup = function (ev) {\r\n                var num = 0;\r\n                var c = 0;\r\n                var event = window.event || ev;\r\n                var code = (event.keyCode) ? event.keyCode : event.charCode;\r\n                for (num = 0; num < this.value.length; num++) {\r\n                    c = this.value.charCodeAt(num);\r\n                    if (c < 48 || c > 57) {\r\n                        document.getElementById('result').innerHTML = '0';\r\n                        document.getElementById('itemAmount1').value = '0.00';\r\n                        document.getElementById('amount').value = '';\r\n                        return false;\r\n                    }\r\n                }\r\n                num = parseInt(this.value);\r\n                if (isNaN(num)) {\r\n                    document.getElementById('result').innerHTML = '0';\r\n                } else {\r\n                    var result = (";
            echo mconfig("pgseguro_conversion_rate");
            echo " * num\r\n                ).\r\n                    toString();\r\n                    document.getElementById('result').innerHTML = result;\r\n                    document.getElementById('itemAmount1').value = num.toPrecision(4);\r\n                }\r\n\r\n                if (num == '' || num == null || isNaN(num)) {\r\n                    document.getElementById('submit').style.display = 'none';\r\n                } else {\r\n                    document.getElementById('submit').style.display = '';\r\n                }\r\n            }\r\n        </script>\r\n\r\n        ";
        }
    } else {
        echo "\r\n  <div class=\"sub-page-title\">\r\n    <div id=\"title\">\r\n      <h1>" . lang("module_titles_txt_3", true) . "<p></p><span></span></h1>\r\n    </div>\r\n  </div>\r\n\r\n  <div class=\"container_2 account\" align=\"center\">\r\n    <div class=\"cont-image\">\r\n      <div class=\"container_3 account_sub_header\">\r\n        <div class=\"grad\">\r\n          <div class=\"page-title\"><p>" . lang("donation_txt_3", true) . "</p></div>\r\n          <div class=\"sub-active-page\">" . lang("module_titles_txt_27", true) . "</div>\r\n          <a href=\"" . __BASE_URL__ . "donation\">" . lang("donation_txt_6", true) . "</a>\r\n        </div>\r\n      </div>\r\n      <div class=\"page-desc-holder\"></div>";
        if (mconfig("active")) {
            $General = new xGeneral();
            $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("pagseguro");
            $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("pagseguro");
            echo "<div class=\"container_3 account-wide\" align=\"center\"><form  method=\"post\"  target=\"PagSeguro\" action=\"https://pagseguro.uol.com.br/v2/checkout/payment.html\"><div class=\"pagseguro-gateway-container\"><div class=\"pagseguro-gateway-content\"><div class=\"pagseguro-gateway-logo\"></div><div class=\"pagseguro-gateway-form\"><div>";
            echo "<input  name=\"receiverEmail\"  type=\"hidden\"  value=\"" . mconfig("pgseguro_email") . "\">";
            echo "<input  name=\"currency\"  type=\"hidden\"  value=\"" . mconfig("pgseguro_currency") . "\">";
            echo "<input  name=\"itemId1\"  type=\"hidden\"  value=\"0001\">";
            echo "<input  name=\"itemDescription1\"  type=\"hidden\"  value=\"" . mconfig("pgseguro_itemtitle") . "\">";
            echo "<input  name=\"itemAmount1\"  id=\"itemAmount1\"  type=\"hidden\"  value=\"0\">\$ <input  type=\"text\"  id=\"amount\"  value=\"0\"> ";
            echo mconfig("pgseguro_currency");
            echo " = <span id=\"result\">0</span> ";
            echo lang("donation_txt_2", true);
            echo "<input  name=\"itemQuantity1\"  type=\"hidden\"  value=\"1\">";
            echo "<input  name=\"reference\"  type=\"hidden\"  value=\"" . $_SESSION["username"] . "\">";
            echo "</div></div><div class=\"pagseguro-gateway-continue\"><br><input  alt=\"Pay with PagSeguro\"  name=\"submit\"   type=\"image\" src=\"https://p.simg.uol.com.br/out/pagseguro/i/botoes/pagamentos/120x53-pagar.gif\" /></div></div></div></form></div>\r\n        <script type=\"text/javascript\">\r\n            document.getElementById('amount').onkeyup = function (ev) {\r\n                var num = 0;\r\n                var c = 0;\r\n                var event = window.event || ev;\r\n                var code = (event.keyCode) ? event.keyCode : event.charCode;\r\n                for (num = 0; num < this.value.length; num++) {\r\n                    c = this.value.charCodeAt(num);\r\n                    if (c < 48 || c > 57) {\r\n                        document.getElementById('result').innerHTML = '0';\r\n                        document.getElementById('itemAmount1').value = '0.00';\r\n                        document.getElementById('amount').value = '';\r\n                        return false;\r\n                    }\r\n                }\r\n                num = parseInt(this.value);\r\n                if (isNaN(num)) {\r\n                    document.getElementById('result').innerHTML = '0';\r\n                } else {\r\n                    var result = (";
            echo mconfig("pgseguro_conversion_rate");
            echo " * num\r\n                ).\r\n                    toString();\r\n                    document.getElementById('result').innerHTML = result;\r\n                    document.getElementById('itemAmount1').value = num.toPrecision(4);\r\n                }\r\n            }\r\n        </script>\r\n\r\n        ";
        } else {
            message("error", lang("error_47", true));
        }
        echo "\r\n    </div>\r\n  </div>\r\n\t";
    }
}

?>