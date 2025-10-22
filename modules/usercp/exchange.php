<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */
if (!isLoggedIn()) {
    redirect(1, "login");
} else {
    if (!canAccessModule($_SESSION["username"], "exchange", "block")) {
        return NULL;
    }
    if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
        $breadcrumb = generateBreadcrumb();
        echo "\r\n    <h3>\r\n        " . lang("myaccount_txt_56", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
        if (mconfig("active")) {
            echo "\r\n    <div class=\"row desc-row\">\r\n        <div class=\"col-xs-12\">\r\n            " . lang("exchange_txt_1", true) . "\r\n        </div>\r\n    </div>";
            $Exchange = new Exchange();
            if (check_value($_POST["submit"])) {
                if ($_SESSION["token"] == $_POST["token"]) {
                    if ($common->beginDbTrans($_SESSION["username"])) {
                        $Exchange->exchangeCurrency($_SESSION["username"], $_POST["exchange_from"], $_POST["exchange_to"], $_POST["exchange_amount"], $_POST["char"]);
                        $common->endDbTrans($_SESSION["username"]);
                    }
                } else {
                    message("notice", lang("global_module_13", true));
                }
            }
            $exchanges = $Exchange->getExchanges();
            $options = [];
            $identFrom = -999;
            $i = 0;
            if ($exchanges != NULL) {
                foreach ($exchanges as $thisExchange) {
                    if ($identFrom != $thisExchange["identFrom"]) {
                        $i = 0;
                    } else {
                        $i++;
                    }
                    $options[$thisExchange["identFrom"]][$i] = ["to" => $thisExchange["identTo"], "ratio" => $thisExchange["ratio"], "amount" => $thisExchange["fromAmount"]];
                    $identFrom = $thisExchange["identFrom"];
                }
            }
            $exchangeFrom = "";
            $exchangeTo = [];
            $exchangeJSON = [];
            foreach ($options as $key => $thisOption) {
                $name = $Exchange->getCurrencyNameWithAmount($_SESSION["username"], $key);
                $exchangeFrom .= "<option value=\"" . $key . "\">" . $name . "</option>";
                $x = 0;
                foreach ($thisOption as $thisRatio) {
                    $nameTo = $Exchange->getCurrencyName($thisRatio["to"]);
                    $easytoyou_decoder_beta_not_finish .= "<option value=\"" . $thisRatio["to"] . "\">" . $nameTo . "</option>";
                    $exchangeJSON[$key][$x]["to"] = $thisRatio["to"];
                    $exchangeJSON[$key][$x]["toName"] = $nameTo;
                    $exchangeJSON[$key][$x]["ratio"] = $thisRatio["ratio"];
                    $exchangeJSON[$key][$x]["amount"] = $thisRatio["amount"];
                    $x++;
                }
            }
            echo "        <script type=\"text/javascript\">\r\n            function InitExchange() {\r\n                \$('#exchange_from').change(function () {\r\n                    setExchangeTo(\$(this).val());\r\n                    setExchangeAmountMsg();\r\n                    setExchangeMsg();\r\n                    displayCharDiv();\r\n                });\r\n\r\n                \$('#exchange_to').change(function () {\r\n                    setExchangeMsg();\r\n                    setExchangeAmountMsg();\r\n                    displayCharDiv();\r\n                });\r\n\r\n                \$('#exchange_amount').keyup(function () {\r\n                    setExchangeMsg();\r\n                });\r\n\r\n                \$('#char').change(function () {\r\n                    updateRuud();\r\n                });\r\n            }\r\n\r\n            function setExchangeTo(from) {\r\n                var exTo = \$('#exchange_to');\r\n                if (exTo.length) {\r\n                    exTo.find('option').remove().end().append('<option value=\"-999\">";
            echo lang("exchange_txt_6", true);
            echo "</option>');\r\n                    if (exchangeTo[from] !== undefined) {\r\n                        for (key in exchangeTo[from]) {\r\n\r\n                            if (String(parseInt(key, 10)) === key && exchangeTo[from].hasOwnProperty(key)) {\r\n                                var val = exchangeTo[from][key]['to'];\r\n                                var name = exchangeTo[from][key]['toName'];\r\n                                exTo.append(\$(\"<option></option>\").attr(\"value\", val).text(name));\r\n                            }\r\n                        }\r\n                    }\r\n\r\n                    var x = exTo.next();\r\n                    if (typeof x.attr('id') != 'undefined') {\r\n                        if (x.attr('id') == 'exchange_to')\r\n                            x.remove();\r\n                        exTo.SelectTransform();\r\n                    }\r\n                }\r\n            }\r\n\r\n            function setExchangeAmountMsg() {\r\n                var exTo = \$('#exchange_to');\r\n                var exFrom = \$('#exchange_from');\r\n                var spanMsg = \$('#exchangeAmountMsg');\r\n\r\n                if (spanMsg.length && exFrom.length && exTo.length) {\r\n                    var msg = '';\r\n                    var fromVal = exFrom.val();\r\n                    var toVal = exTo.val();\r\n\r\n                    if (fromVal != -999 && toVal != -999 && exchangeTo[fromVal][toVal] != undefined) {\r\n                        var nameFrom = \$('#exchange_from option:selected').html();\r\n                        var indexOf = nameFrom.indexOf(\" (\");\r\n                        nameFrom = nameFrom.slice(0, indexOf);\r\n                        var nameTo = exchangeTo[fromVal][toVal]['toName'];\r\n                        var ratio = exchangeTo[fromVal][toVal]['ratio'];\r\n                        var amount = exchangeTo[fromVal][toVal]['amount'];\r\n\r\n                        msg = sprintf('%s %s = %s %s', amount, nameFrom, ratio, nameTo);\r\n                    }\r\n\r\n                    spanMsg.html(msg);\r\n                }\r\n            }\r\n\r\n            function setExchangeMsg() {\r\n                var disableBtn = true;\r\n                var defaultMsg = '";
            echo lang("exchange_txt_13", true);
            echo "';\r\n                var exTo = \$('#exchange_to');\r\n                var exFrom = \$('#exchange_from');\r\n                var amount = \$('#exchange_amount');\r\n                var spanMsg = \$('#exchangeMsg');\r\n                if (spanMsg.length && exFrom.length && exTo.length && amount.length) {\r\n                    var msg = '';\r\n                    var fromVal = exFrom.val();\r\n                    var toVal = exTo.val();\r\n                    var amountVal = parseInt(amount.val());\r\n\r\n                    if (fromVal == -999 || toVal == -999 || isNaN(amountVal)) {\r\n                        msg = defaultMsg;\r\n                    } else {\r\n                        if (exchangeTo[fromVal][toVal] === undefined) {\r\n                            msg = defaultMsg;\r\n                        } else {\r\n                            var fromAmount = exchangeTo[fromVal][toVal]['amount'];\r\n                            var nameFrom = \$('#exchange_from option:selected').html();\r\n                            var indexOf = nameFrom.indexOf(\" (\");\r\n                            nameFrom = nameFrom.slice(0, indexOf);\r\n\r\n                            if (fromAmount > amountVal) {\r\n                                msg = sprintf('";
            echo lang("exchange_txt_15", true);
            echo "', fromAmount, nameFrom);\r\n                            } else if (amountVal % fromAmount != 0) {\r\n                                msg = sprintf('";
            echo lang("exchange_txt_14", true);
            echo "', fromAmount);\r\n                            } else {\r\n                                var nameTo = exchangeTo[fromVal][toVal]['toName'];\r\n                                var ratio = exchangeTo[fromVal][toVal]['ratio'];\r\n\r\n                                msg = sprintf('";
            echo lang("exchange_txt_9", true);
            echo "', amountVal, nameFrom, ratio * (amountVal / fromAmount), nameTo);\r\n                                disableBtn = false;\r\n                            }\r\n                        }\r\n                    }\r\n\r\n                    spanMsg.html(msg);\r\n                }\r\n\r\n                var btn = \$('#BtnExchangeSubmit');\r\n                if (btn.length) {\r\n                    btn.attr('disabled', disableBtn);\r\n                    /*if (disableBtn) {\r\n                        btn.addClass('disabled');\r\n                    } else {\r\n                        btn.removeClass('disabled');\r\n                    }*/\r\n                }\r\n            }\r\n\r\n            function displayCharDiv() {\r\n                if (\$('#exchange_from').val() == \"-1\" || \$('#exchange_to').val() == \"-1\") {\r\n                    \$('#chardiv').show();\r\n                } else {\r\n                    \$('#chardiv').hide();\r\n                }\r\n            }\r\n\r\n            var exchangeTo = [];\r\n            ";
            foreach ($exchangeJSON as $key => $optArr) {
                echo "exchangeTo[" . $key . "] = [];";
                foreach ($optArr as $x => $opt) {
                    echo "exchangeTo[" . $key . "][" . $opt["to"] . "] = { to:\"" . $opt["to"] . "\", toName:\"" . $opt["toName"] . "\", amount:\"" . $opt["amount"] . "\", ratio:\"" . $opt["ratio"] . "\"};";
                }
            }
            echo "\r\n            \$(document).ready(function () {\r\n                InitExchange();\r\n            });\r\n        </script>\r\n        ";
            $token = time();
            $_SESSION["token"] = $token;
            $Character = new Character();
            $AccountCharacters = $Character->AccountCharacter($_SESSION["username"]);
            $characters = "";
            foreach ($AccountCharacters as $thisCharacter) {
                $characterData = $Character->CharacterData($thisCharacter);
                $characters .= "<option value=\"" . Encode($characterData[_CLMN_CHR_NAME_]) . "\">" . $common->replaceHtmlSymbols($characterData[_CLMN_CHR_NAME_]) . "</option>";
            }
            echo "\r\n    <div class=\"row\">\r\n        <div class=\"col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 col-center\">\r\n            <form action=\"\" method=\"post\">\r\n                <div class=\"form-group\">\r\n                    <label>" . lang("exchange_txt_2", true) . "</label>\r\n                    <select name=\"exchange_from\" id=\"exchange_from\" class=\"form-control\">\r\n                        <option value=\"-999\">" . lang("exchange_txt_6", true) . "</option>\r\n                        " . $exchangeFrom . "\r\n                    </select>\r\n                </div>\r\n                <div class=\"form-group\">\r\n                    <label>" . lang("exchange_txt_3", true) . "</label>\r\n                    <select name=\"exchange_to\" id=\"exchange_to\" class=\"form-control\">\r\n                        <option value=\"-999\">" . lang("exchange_txt_6", true) . "</option>\r\n                    </select>\r\n                </div>\r\n                <div class=\"form-group\" id=\"chardiv\" style=\"display: none;\">\r\n                    <label>" . lang("exchange_txt_23", true) . "</label>\r\n                    <select name=\"char\" id=\"char\" class=\"form-control\">\r\n                        " . $characters . "\r\n                    </select>\r\n                </div>\r\n                <div class=\"form-group\">\r\n                    <label>" . lang("exchange_txt_4", true) . "</label>\r\n                    <input type=\"text\" name=\"exchange_amount\" id=\"exchange_amount\" class=\"form-control\" maxlength=\"10\" />\r\n                </div>\r\n                <span class=\"help-block\" id=\"exchangeAmountMsg\"></span>\r\n                <span class=\"help-block\" id=\"exchangeMsg\">" . lang("exchange_txt_13", true) . "</span>\r\n                <div class=\"form-group\">\r\n                    <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                    <input type=\"submit\" name=\"submit\" id=\"BtnExchangeSubmit\" value=\"" . lang("exchange_txt_5", true) . "\" class=\"btn btn-warning full-width-btn\" disabled=\"disabled\">\r\n                </div>\r\n            </form>\r\n        </div>\r\n    </div>";
        } else {
            message("error", lang("error_47", true));
        }
    } else {
        echo "\r\n<div class=\"sub-page-title\">\r\n    <div id=\"title\"><h1>" . lang("module_titles_txt_3", true) . "<p></p><span></span></h1></div>\r\n</div>\r\n<div class=\"container_2 account\" align=\"center\">\r\n    <div class=\"cont-image\">\r\n        <div class=\"container_3 account_sub_header\">\r\n            <div class=\"grad\">\r\n                <div class=\"page-title\">" . lang("myaccount_txt_56", true) . "</div>\r\n                <a href=\"" . __BASE_URL__ . "usercp\">" . lang("global_module_1", true) . "</a>\r\n            </div>\r\n        </div>\r\n        <div class=\"page-desc-holder\">\r\n            " . lang("exchange_txt_1", true) . "\r\n        </div>";
        if (mconfig("active")) {
            $Exchange = new Exchange();
            if (check_value($_POST["submit"])) {
                if ($_SESSION["token"] == $_POST["token"]) {
                    if (!$common->accountOnline($_SESSION["username"])) {
                        $Exchange->exchangeCurrency($_SESSION["username"], $_POST["exchange_from"], $_POST["exchange_to"], $_POST["exchange_amount"], $_POST["char"]);
                    } else {
                        message("error", lang("error_14", true));
                    }
                } else {
                    message("notice", lang("global_module_13", true));
                }
            }
            $exchanges = $Exchange->getExchanges();
            $options = [];
            $identFrom = -999;
            $i = 0;
            if ($exchanges != NULL) {
                foreach ($exchanges as $thisExchange) {
                    if ($identFrom != $thisExchange["identFrom"]) {
                        $i = 0;
                    } else {
                        $i++;
                    }
                    $options[$thisExchange["identFrom"]][$i] = ["to" => $thisExchange["identTo"], "ratio" => $thisExchange["ratio"], "amount" => $thisExchange["fromAmount"]];
                    $identFrom = $thisExchange["identFrom"];
                }
            }
            $exchangeFrom = "";
            $exchangeTo = [];
            $exchangeJSON = [];
            foreach ($options as $key => $thisOption) {
                $name = $Exchange->getCurrencyNameWithAmount($_SESSION["username"], $key);
                $exchangeFrom .= "<option value=\"" . $key . "\">" . $name . "</option>";
                $x = 0;
                foreach ($thisOption as $thisRatio) {
                    $nameTo = $Exchange->getCurrencyName($thisRatio["to"]);
                    $easytoyou_decoder_beta_not_finish .= "<option value=\"" . $thisRatio["to"] . "\">" . $nameTo . "</option>";
                    $exchangeJSON[$key][$x]["to"] = $thisRatio["to"];
                    $exchangeJSON[$key][$x]["toName"] = $nameTo;
                    $exchangeJSON[$key][$x]["ratio"] = $thisRatio["ratio"];
                    $exchangeJSON[$key][$x]["amount"] = $thisRatio["amount"];
                    $x++;
                }
            }
            echo "\r\n        <script type=\"text/javascript\">\r\n            function InitExchange() {\r\n                \$('#exchange_from').change(function () {\r\n                    setExchangeTo(\$(this).val());\r\n                    setExchangeAmountMsg();\r\n                    setExchangeMsg();\r\n                    displayCharDiv();\r\n                });\r\n\r\n                \$('#exchange_to').change(function () {\r\n                    setExchangeMsg();\r\n                    setExchangeAmountMsg();\r\n                    displayCharDiv();\r\n                });\r\n\r\n                \$('#exchange_amount').keyup(function () {\r\n                    setExchangeMsg();\r\n                });\r\n\r\n                \$('#char').change(function () {\r\n                    updateRuud();\r\n                });\r\n            }\r\n\r\n            function setExchangeTo(from) {\r\n                var exTo = \$('#exchange_to');\r\n                if (exTo.length) {\r\n                    exTo.find('option').remove().end().append('<option value=\"-999\">";
            echo lang("exchange_txt_6", true);
            echo "</option>');\r\n                    if (exchangeTo[from] !== undefined) {\r\n                        for (key in exchangeTo[from]) {\r\n\r\n                            if (String(parseInt(key, 10)) === key && exchangeTo[from].hasOwnProperty(key)) {\r\n                                var val = exchangeTo[from][key]['to'];\r\n                                var name = exchangeTo[from][key]['toName'];\r\n                                exTo.append(\$(\"<option></option>\").attr(\"value\", val).text(name));\r\n                            }\r\n                        }\r\n                    }\r\n\r\n                    var x = exTo.next();\r\n                    if (typeof x.attr('id') != 'undefined') {\r\n                        if (x.attr('id') == 'exchange_to')\r\n                            x.remove();\r\n                        exTo.SelectTransform();\r\n                    }\r\n                }\r\n            }\r\n\r\n            function setExchangeAmountMsg() {\r\n                var exTo = \$('#exchange_to');\r\n                var exFrom = \$('#exchange_from');\r\n                var spanMsg = \$('#exchangeAmountMsg');\r\n\r\n                if (spanMsg.length && exFrom.length && exTo.length) {\r\n                    var msg = '';\r\n                    var fromVal = exFrom.val();\r\n                    var toVal = exTo.val();\r\n\r\n                    if (fromVal != -999 && toVal != -999 && exchangeTo[fromVal][toVal] != undefined) {\r\n                        var nameFrom = \$('#exchange_from option:selected').html();\r\n                        var indexOf = nameFrom.indexOf(\" (\");\r\n                        nameFrom = nameFrom.slice(0, indexOf);\r\n                        var nameTo = exchangeTo[fromVal][toVal]['toName'];\r\n                        var ratio = exchangeTo[fromVal][toVal]['ratio'];\r\n                        var amount = exchangeTo[fromVal][toVal]['amount'];\r\n\r\n                        msg = sprintf('%s %s = %s %s', amount, nameFrom, ratio, nameTo);\r\n                    }\r\n\r\n                    spanMsg.html(msg);\r\n                }\r\n            }\r\n\r\n            function setExchangeMsg() {\r\n                var disableBtn = true;\r\n                var defaultMsg = '";
            echo lang("exchange_txt_13", true);
            echo "';\r\n                var exTo = \$('#exchange_to');\r\n                var exFrom = \$('#exchange_from');\r\n                var amount = \$('#exchange_amount');\r\n                var spanMsg = \$('#exchangeMsg');\r\n                if (spanMsg.length && exFrom.length && exTo.length && amount.length) {\r\n                    var msg = '';\r\n                    var fromVal = exFrom.val();\r\n                    var toVal = exTo.val();\r\n                    var amountVal = parseInt(amount.val());\r\n\r\n                    if (fromVal == -999 || toVal == -999 || isNaN(amountVal)) {\r\n                        msg = defaultMsg;\r\n                    } else {\r\n                        if (exchangeTo[fromVal][toVal] === undefined) {\r\n                            msg = defaultMsg;\r\n                        } else {\r\n                            var fromAmount = exchangeTo[fromVal][toVal]['amount'];\r\n                            var nameFrom = \$('#exchange_from option:selected').html();\r\n                            var indexOf = nameFrom.indexOf(\" (\");\r\n                            nameFrom = nameFrom.slice(0, indexOf);\r\n\r\n                            if (fromAmount > amountVal) {\r\n                                msg = sprintf('";
            echo lang("exchange_txt_15", true);
            echo "', fromAmount, nameFrom);\r\n                            } else if (amountVal % fromAmount != 0) {\r\n                                msg = sprintf('";
            echo lang("exchange_txt_14", true);
            echo "', fromAmount);\r\n                            } else {\r\n                                var nameTo = exchangeTo[fromVal][toVal]['toName'];\r\n                                var ratio = exchangeTo[fromVal][toVal]['ratio'];\r\n\r\n                                msg = sprintf('";
            echo lang("exchange_txt_9", true);
            echo "', amountVal, nameFrom, ratio * (amountVal / fromAmount), nameTo);\r\n                                disableBtn = false;\r\n                            }\r\n                        }\r\n                    }\r\n\r\n                    spanMsg.html(msg);\r\n                }\r\n\r\n                var btn = \$('#BtnExchangeSubmit');\r\n                if (btn.length) {\r\n                    btn.attr('disabled', disableBtn);\r\n                    if (disableBtn) {\r\n                        btn.addClass('disabled');\r\n                    } else {\r\n                        btn.removeClass()('disabled');\r\n                    }\r\n                }\r\n            }\r\n\r\n            function displayCharDiv() {\r\n                if (\$('#exchange_from').val() == \"-1\" || \$('#exchange_to').val() == \"-1\") {\r\n                    \$('#chardiv').show();\r\n                } else {\r\n                    \$('#chardiv').hide();\r\n                }\r\n            }\r\n\r\n            var exchangeTo = [];\r\n            ";
            foreach ($exchangeJSON as $key => $optArr) {
                echo "exchangeTo[" . $key . "] = [];";
                foreach ($optArr as $x => $opt) {
                    echo "exchangeTo[" . $key . "][" . $opt["to"] . "] = { to:\"" . $opt["to"] . "\", toName:\"" . $opt["toName"] . "\", amount:\"" . $opt["amount"] . "\", ratio:\"" . $opt["ratio"] . "\"};";
                }
            }
            echo "\r\n            \$(document).ready(function () {\r\n                InitExchange();\r\n            });\r\n        </script>\r\n\r\n        ";
            $token = time();
            $_SESSION["token"] = $token;
            $Character = new Character();
            $AccountCharacters = $Character->AccountCharacter($_SESSION["username"]);
            $characters = "";
            foreach ($AccountCharacters as $thisCharacter) {
                $characterData = $Character->CharacterData($thisCharacter);
                $characterIMG = $Character->GenerateCharacterClassAvatar($characterData[_CLMN_CHR_CLASS_]);
                $charDivs .= "\r\n      <div id=\"character-option-" . Encode($characterData[_CLMN_CHR_NAME_]) . "\" style=\"display:none;\">\r\n        <div class=\"character-holder\">\r\n          <div class=\"s-class-icon " . $custom["character_class"][$characterData["Class"]][1] . "\" style=\"background-image:url(" . __BASE_URL__ . "templates/" . $config["website_template"] . "/style/images/character-icons/" . $custom["character_class"][$characterData["Class"]][3] . ");\"></div>\r\n          <p>" . $common->replaceHtmlSymbols($characterData[_CLMN_CHR_NAME_]) . " (Ruud: " . $characterData[_CLMN_CHR_RUUD_] . ")</p><span>" . $custom["character_class"][$characterData["Class"]][0] . "</span>\r\n        </div>\r\n      </div>";
                $characters .= "<option value=\"" . Encode($characterData[_CLMN_CHR_NAME_]) . "\" gethtmlfrom=\"#character-option-" . Encode($characterData[_CLMN_CHR_NAME_]) . "\">" . $common->replaceHtmlSymbols($characterData[_CLMN_CHR_NAME_]) . "</option>";
            }
            echo "\r\n        <div class=\"container_3 account-wide\" align=\"center\" style=\"padding: 35px 0 25px 0;\">\r\n            <form action=\"\" method=\"post\">\r\n                <div class=\"row\">\r\n                    <label for=\"exchange_from\">" . lang("exchange_txt_2", true) . "</label>\r\n                    <select name=\"exchange_from\" styled=\"true\" id=\"exchange_from\" style=\"display: none;\" tabindex=\"1\">\r\n                        <option value=\"-999\">" . lang("exchange_txt_6", true) . "</option>\r\n                        " . $exchangeFrom . "\r\n                    </select>\r\n                </div>\r\n                <div class=\"row\">\r\n                    <label for=\"exchange_to\">" . lang("exchange_txt_3", true) . "</label>\r\n                    <select name=\"exchange_to\" styled=\"true\" id=\"exchange_to\" style=\"display: none;\" tabindex=\"2\">\r\n                        <option value=\"-999\">" . lang("exchange_txt_6", true) . "</option>                        \r\n                    </select>\r\n                </div>\r\n                <div class=\"row\" id=\"chardiv\" style=\"display: none;\">\r\n                    <label for=\"char\">" . lang("exchange_txt_23", true) . "</label>\r\n                    " . $charDivs . "\r\n                    <select name=\"char\" styled=\"true\" id=\"char\" style=\"display: none;\" tabindex=\"3\">\r\n                        " . $characters . "                     \r\n                    </select>\r\n                </div>\r\n                <div class=\"row\">\r\n                    <label for=\"exchange_amount\">" . lang("exchange_txt_4", true) . "</label>\r\n                    <input type=\"text\" name=\"exchange_amount\" id=\"exchange_amount\" tabindex=\"4\" maxlength=\"10\" />\r\n                </div>\r\n                <div class=\"seperator\"></div>\r\n                <span id=\"exchangeAmountMsg\"></span><br />\r\n                <span id=\"exchangeMsg\">" . lang("exchange_txt_13", true) . "</span>\r\n                <div class=\"seperator\"></div>\r\n                <div class=\"row\" align=\"right\">\r\n                    <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                    <input type=\"submit\" name=\"submit\" id=\"BtnExchangeSubmit\" value=\"" . lang("exchange_txt_5", true) . "\" tabindex=\"4\">\r\n                </div>\r\n            </form>\r\n        </div>";
        } else {
            message("error", lang("error_47", true));
        }
        echo "\r\n    </div>\r\n</div>";
    }
}

?>