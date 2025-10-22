<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

if (!isLoggedIn()) {
    redirect(1, "login");
} else {
    if (!canAccessModule($_SESSION["username"], "transfercoins", "block")) {
        return NULL;
    }
    if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
        $breadcrumb = generateBreadcrumb();
        echo "\r\n    <h3>\r\n        " . lang("transfercoins_txt_1", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
        if (mconfig("active")) {
            $General = new xGeneral();
            $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("transfercoins");
            $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("transfercoins");
            if (0 < mconfig("tax")) {
                echo "\r\n    <div class=\"row desc-row\">\r\n        <div class=\"col-xs-12\">\r\n            " . sprintf(lang("transfercoins_txt_2", true), mconfig("tax")) . "\r\n        </div>\r\n    </div>";
            }
            $Exchange = new Exchange();
            if (check_value($_POST["transfer"])) {
                if ($_SESSION["token"] == $_POST["token"]) {
                    $amount = htmlspecialchars($_POST["amount"]);
                    $receiver = htmlspecialchars($_POST["receiver"]);
                    if (mconfig("enable_msg")) {
                        $message = strip_tags(xss_clean($_POST["message"]));
                    } else {
                        $message = NULL;
                    }
                    $type = htmlspecialchars($_POST["currency"]);
                    if ($common->beginDbTrans($_SESSION["username"], $receiver)) {
                        $Exchange->transferCoins($_SESSION["username"], $receiver, $amount, $type, $message);
                        $common->endDbTrans($_SESSION["username"], $receiver);
                    }
                } else {
                    message("notice", lang("global_module_13", true));
                }
            }
            $token = time();
            $_SESSION["token"] = $token;
            $options = "";
            $Currency = new Currency();
            $currencies = $Currency->getCurrenciesData($_SESSION["username"]);
            if (mconfig("platinum")) {
                $options .= "<option value=\"" . Encode("platinum") . "\">" . lang("currency_platinum", true) . " (" . $currencies[1] . ")</option>";
            }
            if (mconfig("gold")) {
                $options .= "<option value=\"" . Encode("gold") . "\">" . lang("currency_gold", true) . " (" . $currencies[2] . ")</option>";
            }
            if (mconfig("silver")) {
                $options .= "<option value=\"" . Encode("silver") . "\">" . lang("currency_silver", true) . " (" . $currencies[3] . ")</option>";
            }
            if (mconfig("WCoinC")) {
                $options .= "<option value=\"" . Encode("WCoinC") . "\">" . lang("currency_wcoinc", true) . " (" . $currencies[4] . ")</option>";
            }
            if (mconfig("GoblinPoint")) {
                $options .= "<option value=\"" . Encode("GoblinPoint") . "\">" . lang("currency_gp", true) . " (" . $currencies[5] . ")</option>";
            }
            if (mconfig("zen")) {
                $options .= "<option value=\"" . Encode("zen") . "\">" . lang("currency_zen", true) . " (" . $currencies[6] . ")</option>";
            }
            echo "\r\n    <div class=\"row\">\r\n        <div class=\"col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 col-center\">\r\n            <form action=\"\" method=\"post\">\r\n                <div class=\"form-group\">\r\n                    <label>" . lang("transfercoins_txt_3", true) . "</label>\r\n                    <select name=\"currency\" class=\"form-control\">\r\n                        " . $options . "\r\n                    </select>\r\n                </div>\r\n                <div class=\"form-group\">\r\n                    <label>" . lang("transfercoins_txt_4", true) . "</label>\r\n                    <input type=\"text\" name=\"amount\" class=\"form-control\" onfocus=\"if(this.value == '" . lang("transfercoins_txt_4", true) . "') { this.value = ''; }\" onblur=\"if(this.value == '') { this.value = '" . lang("transfercoins_txt_4", true) . "'; }\" value=\"" . lang("transfercoins_txt_4", true) . "\" maxlength=\"10\" />\r\n                </div>\r\n                <div class=\"form-group\">\r\n                    <label>" . lang("transfercoins_txt_5", true) . "</label>\r\n                    <input type=\"text\" name=\"receiver\" class=\"form-control\" onfocus=\"if(this.value == '" . lang("transfercoins_txt_5", true) . "') { this.value = ''; }\" onblur=\"if(this.value == '') { this.value = '" . lang("transfercoins_txt_5", true) . "'; }\" value=\"" . lang("transfercoins_txt_5", true) . "\" maxlength=\"10\" />\r\n                </div>";
            if (mconfig("enable_msg")) {
                echo "\r\n                <div class=\"form-group\">\r\n                    <label>" . lang("transfercoins_txt_9", true) . "</label>\r\n                    <textarea name=\"message\" class=\"form-control\" onfocus=\"if(this.value == '" . lang("transfercoins_txt_10", true) . "') { this.value = ''; }\" onblur=\"if(this.value == '') { this.value = '" . lang("transfercoins_txt_10", true) . "'; }\" maxlength=\"255\">" . lang("transfercoins_txt_10", true) . "</textarea>\r\n                </div>";
            }
            echo "\r\n                <hr>\r\n                <span class=\"help-block\" id=\"helpBlock\">" . lang("transfercoins_txt_7", true) . "</span>\r\n                <div class=\"form-group\">\r\n                    <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                    <input type=\"submit\" name=\"transfer\" value=\"" . lang("transfercoins_txt_6", true) . "\" class=\"btn btn-warning full-width-btn\">\r\n                </div>\r\n            </form>\r\n        </div>\r\n    </div>";
            $receivedHistory = $Exchange->transferCoinsReceivedHistory($_SESSION["username"]);
            $sentHistory = $Exchange->transferCoinsSentHistory($_SESSION["username"]);
            echo "\r\n    <div class=\"row\">\r\n        <div class=\"col-xs-12 col-sm-6 col-center\">\r\n             <div class=\"table-responsive rankings-table\">\r\n                <table class=\"table table-hover text-center\">\r\n                    <tr>\r\n                        <th colspan=\"4\" class=\"headerRow\">" . lang("transfercoins_txt_11", true) . "</th>\r\n                    </tr>\r\n                    <tr>\r\n                        <th>" . lang("transfercoins_txt_16", true) . "</th>\r\n                        <th>" . lang("transfercoins_txt_13", true) . "</th>\r\n                        <th>" . lang("transfercoins_txt_15", true) . "</th>";
            if (mconfig("enable_msg")) {
                echo "\r\n                        <th>" . lang("transfercoins_txt_17", true) . "</th>";
            }
            echo "\r\n                    </tr>";
            if (is_array($receivedHistory)) {
                foreach ($receivedHistory as $thisLog) {
                    echo "\r\n                    <tr>\r\n                        <td>" . date($config["time_date_format_logs"], strtotime($thisLog["date"])) . "</td>\r\n                        <td>" . $thisLog["OldAccountID"] . "</td>\r\n                        <td>" . number_format($thisLog["amount"]) . " " . $Exchange->getCurrencyName($thisLog["amount_type"]) . "</td>";
                    if (mconfig("enable_msg")) {
                        echo "\r\n                        <td>" . $thisLog["message"] . "</td>";
                    }
                    echo "\r\n                    </tr>";
                }
            } else {
                echo "\r\n                    <tr>\r\n                        <td colspan=\"4\">" . lang("transfercoins_txt_18", true) . "</td>\r\n                    </tr>";
            }
            echo "\r\n                </table>\r\n            </div>\r\n        </div>\r\n        <div class=\"col-xs-12 col-sm-6 col-center\">\r\n             <div class=\"table-responsive rankings-table\">\r\n                <table class=\"table table-hover text-center\">\r\n                    <tr>\r\n                        <th colspan=\"4\" class=\"headerRow\">" . lang("transfercoins_txt_12", true) . "</th>\r\n                    </tr>\r\n                    <tr>\r\n                        <th>" . lang("transfercoins_txt_16", true) . "</th>\r\n                        <th>" . lang("transfercoins_txt_14", true) . "</th>\r\n                        <th>" . lang("transfercoins_txt_15", true) . "</th>";
            if (mconfig("enable_msg")) {
                echo "\r\n                        <th>" . lang("transfercoins_txt_17", true) . "</th>";
            }
            echo "\r\n                    </tr>";
            if (is_array($sentHistory)) {
                foreach ($sentHistory as $thisLog) {
                    echo "\r\n                    <tr>\r\n                        <td>" . date($config["time_date_format"], strtotime($thisLog["date"])) . "</td>\r\n                        <td>" . $thisLog["NewAccountID"] . "</td>\r\n                        <td>" . number_format($thisLog["amount"]) . " " . $Exchange->getCurrencyName($thisLog["amount_type"]) . "</td>";
                    if (mconfig("enable_msg")) {
                        echo "\r\n                        <td>" . $thisLog["message"] . "</td>";
                    }
                    echo "\r\n                    </tr>";
                }
            } else {
                echo "\r\n                    <tr>\r\n                        <td colspan=\"4\">" . lang("transfercoins_txt_18", true) . "</td>\r\n                    </tr>";
            }
            echo "\r\n                </table>\r\n            </div>\r\n        </div>\r\n    </div>";
        } else {
            message("error", lang("error_47", true));
        }
    } else {
        echo "\r\n<div class=\"sub-page-title\">\r\n  <div id=\"title\"><h1>" . lang("module_titles_txt_3", true) . "<p></p><span></span></h1></div>\r\n</div>\r\n<div class=\"container_2 account\" align=\"center\">\r\n  <div class=\"cont-image\">\r\n    <div class=\"container_3 account_sub_header\">\r\n      <div class=\"grad\">\r\n        <div class=\"page-title\">" . lang("transfercoins_txt_1", true) . "</div>\r\n        <a href=\"" . __BASE_URL__ . "usercp\">" . lang("global_module_1", true) . "</a>\r\n      </div>\r\n    </div>\r\n    <div class=\"page-desc-holder\">";
        if (0 < mconfig("tax")) {
            echo sprintf(lang("transfercoins_txt_2", true), mconfig("tax"));
        }
        echo "</div>";
        if (mconfig("active")) {
            $General = new xGeneral();
            $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("transfercoins");
            $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("transfercoins");
            $Exchange = new Exchange();
            if (check_value($_POST["transfer"])) {
                if ($_SESSION["token"] == $_POST["token"]) {
                    $amount = htmlspecialchars($_POST["amount"]);
                    $receiver = htmlspecialchars($_POST["receiver"]);
                    $type = htmlspecialchars($_POST["currency"]);
                    $Exchange->transferCoins($_SESSION["username"], $receiver, $amount, $type);
                } else {
                    message("notice", lang("global_module_13", true));
                }
            }
            $token = time();
            $_SESSION["token"] = $token;
            if (mconfig("platinum")) {
                echo "<option value=\"" . Encode("platinum") . "\" gethtmlfrom=\"#character-option-" . Encode("platinum") . "\">" . lang("currency_platinum", true) . "</option>";
            }
            if (mconfig("gold")) {
                echo "<option value=\"" . Encode("gold") . "\" gethtmlfrom=\"#character-option-" . Encode("gold") . "\">" . lang("currency_gold", true) . "</option>";
            }
            if (mconfig("silver")) {
                echo "<option value=\"" . Encode("silver") . "\" gethtmlfrom=\"#character-option-" . Encode("silver") . "\">" . lang("currency_silver", true) . "</option>";
            }
            if (mconfig("WCoinC")) {
                echo "<option value=\"" . Encode("WCoinC") . "\" gethtmlfrom=\"#character-option-" . Encode("WCoinC") . "\">" . lang("currency_wcoinc", true) . "</option>";
            }
            if (mconfig("GoblinPoint")) {
                echo "<option value=\"" . Encode("GoblinPoint") . "\" gethtmlfrom=\"#character-option-" . Encode("GoblinPoint") . "\">" . lang("currency_gp", true) . "</option>";
            }
            if (mconfig("zen")) {
                echo "<option value=\"" . Encode("zen") . "\" gethtmlfrom=\"#character-option-" . Encode("zen") . "\">" . lang("currency_zen", true) . "</option>";
            }
            echo "\r\n  <div class=\"container_3 account-wide\" align=\"center\">\r\n    <form action=\"\" method=\"post\">\r\n      <div class=\"select-charcater-s\" align=\"right\">";
            if (mconfig("platinum")) {
                echo "\r\n        <div id=\"character-option-" . Encode("platinum") . "\" style=\"display:none;\">\r\n          <div class=\"character-holder\">\r\n            <div class=\"s-class-icon monk\" style = \"background-image:url(" . __PATH_TEMPLATE__ . "style/images/p-coin.png);\"></div>\r\n            <p>" . lang("currency_platinum", true) . "</p><span></span>\r\n          </div>\r\n        </div>";
            }
            if (mconfig("gold")) {
                echo "\r\n        <div id=\"character-option-" . Encode("gold") . "\" style=\"display:none;\">\r\n          <div class=\"character-holder\">\r\n            <div class=\"s-class-icon monk\" style=\"background-image:url(" . __PATH_TEMPLATE__ . "style/images/g-coin.png);\"></div>\r\n            <p>" . lang("currency_gold", true) . "</p><span></span>\r\n          </div>\r\n        </div>";
            }
            if (mconfig("silver")) {
                echo "\r\n        <div id=\"character-option-" . Encode("silver") . "\" style=\"display:none;\">\r\n          <div class=\"character-holder\">\r\n            <div class=\"s-class-icon monk\" style=\"background-image:url(" . __PATH_TEMPLATE__ . "style/images/s-coin.png);\" ></div>\r\n            <p>" . lang("currency_silver", true) . "</p><span></span>\r\n          </div>\r\n        </div>";
            }
            if (mconfig("WCoinC")) {
                echo "\r\n        <div id=\"character-option-" . Encode("WCoinC") . "\" style=\"display:none;\">\r\n          <div class=\"character-holder\">\r\n            <div class=\"s-class-icon monk\" style=\"background-image:url(" . __PATH_TEMPLATE__ . "style/images/currency-icons/wcoin.png);\" ></div>\r\n            <p>" . lang("currency_wcoinc", true) . "</p><span></span>\r\n          </div>\r\n        </div>";
            }
            if (mconfig("GoblinPoint")) {
                echo "\r\n        <div id=\"character-option-" . Encode("GoblinPoint") . "\" style=\"display:none;\">\r\n          <div class=\"character-holder\">\r\n            <div class=\"s-class-icon monk\" style=\"background-image:url(" . __PATH_TEMPLATE__ . "style/images/currency-icons/goblinpoint.png);\" ></div>\r\n            <p>" . lang("currency_gp", true) . "</p><span></span>\r\n          </div>\r\n        </div>";
            }
            if (mconfig("zen")) {
                echo "\r\n        <div id=\"character-option-" . Encode("zen") . "\" style=\"display:none;\">\r\n          <div class=\"character-holder\">\r\n            <div class=\"s-class-icon monk\" style=\"background-image:url(" . __PATH_TEMPLATE__ . "style/images/currency-icons/zen.png);\" ></div>\r\n            <p>" . lang("currency_zen", true) . "</p><span></span>\r\n          </div>\r\n        </div>";
            }
            echo "\r\n        <div id=\"select-charcater-selected\" style=\"display:none;\">\r\n    \t\t\t<p class=\"select-charcater-selected\">" . lang("transfercoins_txt_3", true) . "</p>\r\n    \t\t</div>\r\n        <select styled=\"true\" id=\"character-select\" name=\"currency\" style=\"display: none;\">\r\n          <option selected=\"selected\" disabled=\"disabled\" gethtmlfrom=\"#select-charcater-selected\"></option>";
            if (mconfig("platinum")) {
                echo "<option value=\"" . Encode("platinum") . "\" gethtmlfrom=\"#character-option-" . Encode("platinum") . "\">" . lang("currency_platinum", true) . "</option>";
            }
            if (mconfig("gold")) {
                echo "<option value=\"" . Encode("gold") . "\" gethtmlfrom=\"#character-option-" . Encode("gold") . "\">" . lang("currency_gold", true) . "</option>";
            }
            if (mconfig("silver")) {
                echo "<option value=\"" . Encode("silver") . "\" gethtmlfrom=\"#character-option-" . Encode("silver") . "\">" . lang("currency_silver", true) . "</option>";
            }
            if (mconfig("WCoinC")) {
                echo "<option value=\"" . Encode("WCoinC") . "\" gethtmlfrom=\"#character-option-" . Encode("WCoinC") . "\">" . lang("currency_wcoinc", true) . "</option>";
            }
            if (mconfig("GoblinPoint")) {
                echo "<option value=\"" . Encode("GoblinPoint") . "\" gethtmlfrom=\"#character-option-" . Encode("GoblinPoint") . "\">" . lang("currency_gp", true) . "</option>";
            }
            if (mconfig("zen")) {
                echo "<option value=\"" . Encode("zen") . "\" gethtmlfrom=\"#character-option-" . Encode("zen") . "\">" . lang("currency_zen", true) . "</option>";
            }
            echo "\r\n        </select>\r\n      </div>\r\n      <div class=\"cooldown-ico\">\r\n        <div class=\"ust-cooldown\" style=\"display:block;\">\r\n          <input type=\"text\" name=\"amount\" onfocus=\"if(this.value == '" . lang("transfercoins_txt_4", true) . "') { this.value = ''; }\" onblur=\"if(this.value == '') { this.value = '" . lang("transfercoins_txt_4", true) . "'; }\" value=\"" . lang("transfercoins_txt_4", true) . "\" style=\"width: 90px; margin-top: 0; margin-left: -12px;\" maxlength=\"10\" />\r\n          <input type=\"text\" name=\"receiver\" onfocus=\"if(this.value == '" . lang("transfercoins_txt_5", true) . "') { this.value = ''; }\" onblur=\"if(this.value == '') { this.value = '" . lang("transfercoins_txt_5", true) . "'; }\" value=\"" . lang("transfercoins_txt_5", true) . "\" style=\"width: 90px; margin-top: 18px; margin-left: -12px;\" maxlength=\"10\" />\r\n        </div>\r\n      </div>\r\n      <div class=\"ust-submit\" align=\"left\">\r\n        <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n        <input type=\"submit\" name=\"transfer\" value=\"" . lang("transfercoins_txt_6", true) . "\">\r\n        <p>\r\n          " . lang("transfercoins_txt_7", true) . "\r\n        </p>\r\n      </div>\r\n      <div class=\"clear\"></div>\r\n      <div class=\"description-small\">\r\n        " . lang("transfercoins_txt_8", true) . "\r\n      </div>\r\n    </form>\r\n  </div>";
        } else {
            message("error", lang("error_47", true));
        }
        echo "\r\n  </div>\r\n</div>";
    }
}

?>