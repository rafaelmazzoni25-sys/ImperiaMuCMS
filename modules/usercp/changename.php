<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

if (!isLoggedIn()) {
    redirect(1, "login");
} else {
    if (!canAccessModule($_SESSION["username"], "changename", "block")) {
        return NULL;
    }
    if (mconfig("credit_config") == "1") {
        $tax_type = lang("currency_platinum", true);
    } else {
        if (mconfig("credit_config") == "2") {
            $tax_type = lang("currency_gold", true);
        } else {
            if (mconfig("credit_config") == "3") {
                $tax_type = lang("currency_silver", true);
            } else {
                if (mconfig("credit_config") == "4") {
                    $tax_type = lang("currency_wcoinc", true);
                } else {
                    if (mconfig("credit_config") == "5") {
                        $tax_type = lang("currency_gp", true);
                    } else {
                        if (mconfig("credit_config") == "6") {
                            $tax_type = "" . lang("currency_zen", true) . "";
                        }
                    }
                }
            }
        }
    }
    if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
        $breadcrumb = generateBreadcrumb();
        echo "\r\n    <h3>\r\n        " . lang("renamechar_txt_1", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
        if (mconfig("active")) {
            $General = new xGeneral();
            $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("changename");
            $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("changename");
            if (0 < mconfig("price")) {
                echo "\r\n    <div class=\"row desc-row\">\r\n        <div class=\"col-xs-12\">\r\n            " . sprintf(lang("renamechar_txt_2", true), number_format(mconfig("price")), $tax_type) . "\r\n        </div>\r\n    </div>";
            }
            $Character = new Character();
            if (check_value($_POST["submit"])) {
                if ($_SESSION["token"] == $_POST["token"]) {
                    $name = htmlspecialchars($_POST["name"]);
                    $char = Decode($_POST["character"]);
                    if ($common->beginDbTrans($_SESSION["username"])) {
                        $Character->renameCharacter($_SESSION["username"], $name, $char);
                        $common->endDbTrans($_SESSION["username"]);
                    }
                } else {
                    message("notice", lang("global_module_13", true));
                }
            }
            $AccountCharacters = $Character->AccountCharacter($_SESSION["username"]);
            if (is_array($AccountCharacters)) {
                $characters = "";
                $charDivs = "";
                $token = time();
                $_SESSION["token"] = $token;
                foreach ($AccountCharacters as $thisCharacter) {
                    $characterData = $Character->CharacterData($thisCharacter);
                    $characters .= "<option value=\"" . Encode($characterData[_CLMN_CHR_NAME_]) . "\">" . $common->replaceHtmlSymbols($characterData[_CLMN_CHR_NAME_]) . " (" . $custom["character_class"][$characterData["Class"]][0] . ")</option>";
                }
                echo "\r\n    <div class=\"row\">\r\n        <div class=\"col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 col-center\">\r\n            <form action=\"\" method=\"post\">\r\n                <div class=\"form-group\">\r\n                    <label>" . lang("renamechar_txt_3", true) . "</label>\r\n                    <select name=\"character\" class=\"form-control\">\r\n                        " . $characters . "\r\n                    </select>\r\n                </div>\r\n                <div class=\"form-group\">\r\n                    <label>" . lang("renamechar_txt_7", true) . "</label>\r\n                    <input type=\"text\" name=\"name\" class=\"form-control\" onfocus=\"if(this.value == '" . lang("renamechar_txt_7", true) . "') { this.value = ''; }\" onblur=\"if(this.value == '') { this.value = '" . lang("renamechar_txt_7", true) . "'; }\" value=\"" . lang("renamechar_txt_7", true) . "\" maxlength=\"10\" />\r\n                </div>\r\n                <div class=\"form-group\">\r\n                    <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                    <input type=\"submit\" name=\"submit\" value=\"" . lang("renamechar_txt_6", true) . "\" class=\"btn btn-warning full-width-btn\">\r\n                </div>\r\n            </form>";
                if (mconfig("allow_special_chars")) {
                    echo sprintf(lang("renamechar_txt_5", true), "a-z A-Z 0-9 _ ! ~ ^ @ # \$ ? [ ] ( ) { } = - + * / \\ |");
                } else {
                    echo sprintf(lang("renamechar_txt_5", true), "a-z A-Z 0-9");
                }
                echo "\r\n        </div>\r\n    </div>";
            } else {
                message("error", lang("error_46", true));
            }
        } else {
            message("error", lang("error_47", true));
        }
    } else {
        echo "\r\n<div class=\"sub-page-title\">\r\n  <div id=\"title\"><h1>" . lang("module_titles_txt_3", true) . "<p></p><span></span></h1></div>\r\n</div>\r\n<div class=\"container_2 account\" align=\"center\">\r\n  <div class=\"cont-image\">\r\n    <div class=\"container_3 account_sub_header\">\r\n      <div class=\"grad\">\r\n        <div class=\"page-title\">" . lang("renamechar_txt_1", true) . "</div>\r\n        <a href=\"" . __BASE_URL__ . "usercp\">" . lang("global_module_1", true) . "</a>\r\n      </div>\r\n    </div>\r\n    <div class=\"page-desc-holder\">";
        if (0 < mconfig("price")) {
            echo sprintf(lang("renamechar_txt_2", true), number_format(mconfig("price")), $tax_type);
        }
        echo "</div>";
        if (mconfig("active")) {
            $General = new xGeneral();
            $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("changename");
            $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("changename");
            $Character = new Character();
            if (check_value($_POST["submit"])) {
                if ($_SESSION["token"] == $_POST["token"]) {
                    $name = htmlspecialchars($_POST["name"]);
                    $char = Decode($_POST["character"]);
                    $Character->renameCharacter($_SESSION["username"], $name, $char);
                } else {
                    message("notice", lang("global_module_13", true));
                }
            }
            $AccountCharacters = $Character->AccountCharacter($_SESSION["username"]);
            if (is_array($AccountCharacters)) {
                $characters = "";
                $charDivs = "";
                $token = time();
                $_SESSION["token"] = $token;
                foreach ($AccountCharacters as $thisCharacter) {
                    $characterData = $Character->CharacterData($thisCharacter);
                    $characterIMG = $Character->GenerateCharacterClassAvatar($characterData[_CLMN_CHR_CLASS_]);
                    $charDivs .= "\r\n      <div id=\"character-option-" . Encode($characterData[_CLMN_CHR_NAME_]) . "\" style=\"display:none;\">\r\n        <div class=\"character-holder\">\r\n          <div class=\"s-class-icon " . $custom["character_class"][$characterData["Class"]][1] . "\" style=\"background-image:url(" . __BASE_URL__ . "templates/" . $config["website_template"] . "/style/images/character-icons/" . $custom["character_class"][$characterData["Class"]][3] . ");\"></div>\r\n          <p>" . $common->replaceHtmlSymbols($characterData[_CLMN_CHR_NAME_]) . "</p><span>" . $custom["character_class"][$characterData["Class"]][0] . "</span>\r\n        </div>\r\n      </div>";
                    $characters .= "<option value=\"" . Encode($characterData[_CLMN_CHR_NAME_]) . "\" gethtmlfrom=\"#character-option-" . Encode($characterData[_CLMN_CHR_NAME_]) . "\">" . $common->replaceHtmlSymbols($characterData[_CLMN_CHR_NAME_]) . "</option>";
                }
                echo "\r\n      <div class=\"container_3 account-wide\" align=\"center\">\r\n        <form action=\"\" method=\"post\">\r\n          <div class=\"select-charcater-s\" align=\"right\">\r\n            " . $charDivs . "\r\n            <div id=\"select-charcater-selected\" style=\"display:none;\">\r\n\t\t\t\t\t\t\t<p class=\"select-charcater-selected\">" . lang("renamechar_txt_3", true) . "</p>\r\n\t\t\t\t\t\t</div>\r\n            <select styled=\"true\" id=\"character-select\" name=\"character\" style=\"display: none;\">\r\n              <option selected=\"selected\" disabled=\"disabled\" gethtmlfrom=\"#select-charcater-selected\"></option>\r\n              " . $characters . "\r\n            </select>\r\n          </div>\r\n          <div class=\"cooldown-ico\">\r\n            <input type=\"text\" name=\"name\" onfocus=\"if(this.value == '" . lang("renamechar_txt_7", true) . "') { this.value = ''; }\" onblur=\"if(this.value == '') { this.value = '" . lang("renamechar_txt_7", true) . "'; }\" value=\"" . lang("renamechar_txt_7", true) . "\" style=\"width: 90px; margin-top: 26px; margin-left: -12px;\" maxlength=\"10\" />\r\n\t\t\t\t    <div class=\"ust-cooldown\" style=\"display:block;\"></div>\r\n\t   \t\t  </div>\r\n          <div class=\"ust-submit\" align=\"left\">\r\n            <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n            <input type=\"submit\" name=\"submit\" value=\"" . lang("renamechar_txt_6", true) . "\">\r\n            <p>" . lang("renamechar_txt_4", true) . "</p>\r\n          </div>\r\n          <div class=\"clear\"></div>\r\n          <div class=\"description-small\">";
                if (mconfig("allow_special_chars")) {
                    echo sprintf(lang("renamechar_txt_5", true), "a-z A-Z 0-9 _ ! ~ ^ @ # \$ ? [ ] ( ) { } = - + * / \\ |");
                } else {
                    echo sprintf(lang("renamechar_txt_5", true), "a-z A-Z 0-9");
                }
                echo "\r\n          </div>\r\n        </form>\r\n      </div>";
            } else {
                message("error", lang("error_46", true));
            }
        } else {
            message("error", lang("error_47", true));
        }
        echo "\r\n  </div>\r\n</div>";
    }
}

?>