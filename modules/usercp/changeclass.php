<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

if (!isLoggedIn()) {
    redirect(1, "login");
} else {
    if (!canAccessModule($_SESSION["username"], "changeclass", "block")) {
        return NULL;
    }
    $price_type = mconfig("credit_config");
    if ($price_type == "1") {
        $price_type = lang("currency_platinum", true);
    } else {
        if ($price_type == "2") {
            $price_type = lang("currency_gold", true);
        } else {
            if ($price_type == "3") {
                $price_type = lang("currency_silver", true);
            } else {
                if ($price_type == "4") {
                    $price_type = lang("currency_wcoinc", true);
                } else {
                    if ($price_type == "5") {
                        $price_type = lang("currency_gp", true);
                    } else {
                        if ($price_type == "6") {
                            $price_type = "" . lang("currency_zen", true) . "";
                        }
                    }
                }
            }
        }
    }
    if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
        $breadcrumb = generateBreadcrumb();
        echo "\r\n    <h3>\r\n        " . lang("changeclass_txt_1", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
        if (mconfig("active")) {
            $General = new xGeneral();
            $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("changeclass");
            $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("changeclass");
            echo "\r\n    <div class=\"row desc-row\">\r\n        <div class=\"col-xs-12\">";
            if (0 < mconfig("price")) {
                echo sprintf(lang("changeclass_txt_12", true), number_format(mconfig("price")), $price_type);
            } else {
                echo lang("changeclass_txt_11", true);
            }
            if (0 < mconfig("equip_check")) {
                echo "<br>" . lang("changeclass_txt_13", true);
            }
            echo "    \r\n        </div>\r\n    </div>";
            $Character = new Character();
            $AccountCharacters = $Character->AccountCharacter($_SESSION["username"]);
            if (is_array($AccountCharacters)) {
                if (check_value($_POST["submit"])) {
                    if ($_SESSION["token"] == $_POST["token"]) {
                        if ($common->beginDbTrans($_SESSION["username"])) {
                            $Character->changeClass($_SESSION["username"], $_POST["character"], $_POST["new_class"]);
                            $common->endDbTrans($_SESSION["username"]);
                        }
                    } else {
                        message("notice", lang("global_module_13", true));
                    }
                }
                $characters = "";
                $charDivs = "";
                $token = time();
                $_SESSION["token"] = $token;
                foreach ($AccountCharacters as $thisCharacter) {
                    $characterData = $Character->CharacterData($thisCharacter);
                    $characters .= "<option value=\"" . Encode($characterData[_CLMN_CHR_NAME_]) . "\">" . $common->replaceHtmlSymbols($characterData[_CLMN_CHR_NAME_]) . " (" . $custom["character_class"][$characterData["Class"]][0] . ")</option>";
                }
                foreach ($custom["class_filter"] as $thisClass) {
                    $classes .= "<option value=\"" . Encode($thisClass[0]) . "\">" . $custom["character_class"][$thisClass[0]][0] . "</option>";
                }
                echo "\r\n    <div class=\"row\">\r\n        <div class=\"col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 col-center\">\r\n            <form action=\"\" method=\"post\">\r\n                <div class=\"form-group\">\r\n                    <label>" . lang("changeclass_txt_3", true) . "</label>\r\n                    <select name=\"character\" class=\"form-control\">\r\n                        " . $characters . "\r\n                    </select>\r\n                </div>\r\n                <div class=\"form-group\">\r\n                    <label>" . lang("changeclass_txt_6", true) . "</label>\r\n                    <select name=\"new_class\" class=\"form-control\">\r\n                        " . $classes . "\r\n                    </select>\r\n                </div>\r\n                <div class=\"form-group\">\r\n                    <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                    <input type=\"submit\" name=\"submit\" value=\"" . lang("changeclass_txt_4", true) . "\" class=\"btn btn-warning full-width-btn\">\r\n                </div>\r\n            </form>\r\n        </div>\r\n    </div>";
            } else {
                message("error", lang("error_46", true));
            }
        } else {
            message("error", lang("error_47", true));
        }
    } else {
        echo "\r\n<div class=\"sub-page-title\">\r\n    <div id=\"title\"><h1>" . lang("module_titles_txt_3", true) . "<p></p><span></span></h1></div>\r\n</div>\r\n<div class=\"container_2 account\" align=\"center\">\r\n    <div class=\"cont-image\">\r\n        <div class=\"container_3 account_sub_header\">\r\n            <div class=\"grad\">\r\n                <div class=\"page-title\">" . lang("changeclass_txt_1", true) . "</div>\r\n                <a href=\"" . __BASE_URL__ . "usercp\">" . lang("global_module_1", true) . "</a>\r\n            </div>\r\n        </div>\r\n        <div class=\"unstuck\">\r\n            <div class=\"page-desc-holder\">";
        if (0 < mconfig("price")) {
            echo sprintf(lang("changeclass_txt_12", true), number_format(mconfig("price")), $price_type);
        } else {
            echo lang("changeclass_txt_11", true);
        }
        if (0 < mconfig("equip_check")) {
            echo "<br>" . lang("changeclass_txt_13", true);
        }
        echo "\r\n            </div>";
        if (mconfig("active")) {
            $General = new xGeneral();
            $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("changeclass");
            $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("changeclass");
            $Character = new Character();
            $AccountCharacters = $Character->AccountCharacter($_SESSION["username"]);
            if (is_array($AccountCharacters)) {
                if (check_value($_POST["submit"])) {
                    if ($_SESSION["token"] == $_POST["token"]) {
                        $Character->changeClass($_SESSION["username"], $_POST["character"], $_POST["new_class"]);
                    } else {
                        message("notice", lang("global_module_13", true));
                    }
                }
                $characters = "";
                $charDivs = "";
                $token = time();
                $_SESSION["token"] = $token;
                foreach ($AccountCharacters as $thisCharacter) {
                    $characterData = $Character->CharacterData($thisCharacter);
                    $characterIMG = $Character->GenerateCharacterClassAvatar($characterData[_CLMN_CHR_CLASS_]);
                    $charDivs .= "\r\n          <div id=\"character-option-" . Encode($characterData[_CLMN_CHR_NAME_]) . "\" style=\"display:none;\">\r\n            <div class=\"character-holder\">\r\n              <div class=\"s-class-icon " . $custom["character_class"][$characterData["Class"]][1] . "\" style=\"background-image:url(" . __BASE_URL__ . "templates/" . $config["website_template"] . "/style/images/character-icons/" . $custom["character_class"][$characterData["Class"]][3] . ");\"></div>\r\n              <p>" . $common->replaceHtmlSymbols($characterData[_CLMN_CHR_NAME_]) . "</p><span>" . $custom["character_class"][$characterData["Class"]][0] . "</span>\r\n            </div>\r\n          </div>";
                    $characters .= "<option value=\"" . Encode($characterData[_CLMN_CHR_NAME_]) . "\" gethtmlfrom=\"#character-option-" . Encode($characterData[_CLMN_CHR_NAME_]) . "\">" . $common->replaceHtmlSymbols($characterData[_CLMN_CHR_NAME_]) . "</option>";
                }
                $classesDivs = "\r\n        <div id=\"class-option-" . Encode("0") . "\" style=\"display:none;\">\r\n            <div class=\"character-holder\">\r\n                <div class=\"s-class-icon DW\" style=\"background-image:url(" . __BASE_URL__ . "templates/" . $config["website_template"] . "/style/images/character-icons/dw_icon.jpg);\"></div>\r\n                <p>Dark Wizard</p><span></span>\r\n            </div>\r\n        </div>\r\n        <div id=\"class-option-" . Encode("16") . "\" style=\"display:none;\">\r\n            <div class=\"character-holder\">\r\n                <div class=\"s-class-icon DK\" style=\"background-image:url(" . __BASE_URL__ . "templates/" . $config["website_template"] . "/style/images/character-icons/dk_icon.jpg);\"></div>\r\n                <p>Dark Knight</p><span></span>\r\n            </div>\r\n        </div>\r\n        <div id=\"class-option-" . Encode("32") . "\" style=\"display:none;\">\r\n            <div class=\"character-holder\">\r\n                <div class=\"s-class-icon FE\" style=\"background-image:url(" . __BASE_URL__ . "templates/" . $config["website_template"] . "/style/images/character-icons/fe_icon.jpg);\"></div>\r\n                <p>Fairy Elf</p><span></span>\r\n            </div>\r\n        </div>\r\n        <div id=\"class-option-" . Encode("48") . "\" style=\"display:none;\">\r\n            <div class=\"character-holder\">\r\n                <div class=\"s-class-icon MG\" style=\"background-image:url(" . __BASE_URL__ . "templates/" . $config["website_template"] . "/style/images/character-icons/mg_icon.jpg);\"></div>\r\n                <p>Magic Gladiator</p><span></span>\r\n            </div>\r\n        </div>\r\n        <div id=\"class-option-" . Encode("64") . "\" style=\"display:none;\">\r\n            <div class=\"character-holder\">\r\n                <div class=\"s-class-icon DL\" style=\"background-image:url(" . __BASE_URL__ . "templates/" . $config["website_template"] . "/style/images/character-icons/dl_icon.jpg);\"></div>\r\n                <p>Dark Lord</p><span></span>\r\n            </div>\r\n        </div>\r\n        <div id=\"class-option-" . Encode("80") . "\" style=\"display:none;\">\r\n            <div class=\"character-holder\">\r\n                <div class=\"s-class-icon SU\" style=\"background-image:url(" . __BASE_URL__ . "templates/" . $config["website_template"] . "/style/images/character-icons/su_icon.jpg);\"></div>\r\n                <p>Summoner</p><span></span>\r\n            </div>\r\n        </div>\r\n        <div id=\"class-option-" . Encode("96") . "\" style=\"display:none;\">\r\n            <div class=\"character-holder\">\r\n                <div class=\"s-class-icon RF\" style=\"background-image:url(" . __BASE_URL__ . "templates/" . $config["website_template"] . "/style/images/character-icons/rf_icon.jpg);\"></div>\r\n                <p>Rage Fighter</p><span></span>\r\n            </div>\r\n        </div>";
                if (100 <= config("server_files_season", true)) {
                    $classesDivs .= "\r\n            <div id=\"class-option-" . Encode("112") . "\" style=\"display:none;\">\r\n                <div class=\"character-holder\">\r\n                    <div class=\"s-class-icon GL\" style=\"background-image:url(" . __BASE_URL__ . "templates/" . $config["website_template"] . "/style/images/character-icons/gl_icon.jpg);\"></div>\r\n                    <p>Grow Lancer</p><span></span>\r\n                </div>\r\n            </div>";
                }
                $classes .= "\r\n        <option value=\"" . Encode("0") . "\" gethtmlfrom=\"#class-option-" . Encode("0") . "\">Dark Wizard</option>\r\n        <option value=\"" . Encode("16") . "\" gethtmlfrom=\"#class-option-" . Encode("16") . "\">Dark Knight</option>\r\n        <option value=\"" . Encode("32") . "\" gethtmlfrom=\"#class-option-" . Encode("32") . "\">Fairy Elf</option>\r\n        <option value=\"" . Encode("48") . "\" gethtmlfrom=\"#class-option-" . Encode("48") . "\">Magic Gladiator</option>\r\n        <option value=\"" . Encode("64") . "\" gethtmlfrom=\"#class-option-" . Encode("64") . "\">Dark Lord</option>\r\n        <option value=\"" . Encode("80") . "\" gethtmlfrom=\"#class-option-" . Encode("80") . "\">Summoner</option>\r\n        <option value=\"" . Encode("96") . "\" gethtmlfrom=\"#class-option-" . Encode("96") . "\">Rage Fighter</option>";
                if (100 <= config("server_files_season", true)) {
                    $classes .= "<option value=\"" . Encode("112") . "\" gethtmlfrom=\"#class-option-" . Encode("112") . "\">Grow Lancer</option>";
                }
                echo "\r\n        <div class=\"container_3 account-wide\" align=\"center\">\r\n            <form action=\"\" method=\"post\">\r\n                <div class=\"select-charcater-s\" style=\"-webkit-linear-gradient(left, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.25) 100%); height: 150px;\" align=\"right\">\r\n                    " . $charDivs . "\r\n                    <div id=\"select-charcater-selected\" style=\"display:none;\">\r\n                        <p class=\"select-charcater-selected\">" . lang("changeclass_txt_3", true) . "</p>\r\n                    </div>\r\n                    <select styled=\"true\" id=\"character-select\" name=\"character\" style=\"display: none;\">\r\n                        <option selected=\"selected\" disabled=\"disabled\" gethtmlfrom=\"#select-charcater-selected\"></option>\r\n                        " . $characters . "\r\n                    </select>\r\n\r\n                    " . $classesDivs . "\r\n                    <div id=\"select-class-selected\" style=\"display:none;\">\r\n                        <p class=\"select-charcater-selected\">" . lang("changeclass_txt_6", true) . "</p>\r\n                    </div>\r\n                    <select styled=\"true\" id=\"character-select\" name=\"new_class\" style=\"display: none;\">\r\n                        <option selected=\"selected\" disabled=\"disabled\" gethtmlfrom=\"#select-class-selected\"></option>\r\n                        " . $classes . "\r\n                    </select>\r\n                </div>\r\n                <div class=\"cooldown-ico\">\r\n                    <div class=\"ust-cooldown\" style=\"display:block;\"></div>\r\n                </div>\r\n                <div class=\"ust-submit\" align=\"left\">\r\n                    <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                    <input type=\"submit\" name=\"submit\" value=\"" . lang("changeclass_txt_4", true) . "\">\r\n                    <p>\r\n                        " . lang("changeclass_txt_5", true) . "\r\n                    </p>\r\n                </div>\r\n                <div class=\"clear\"></div>\r\n            </form>\r\n        </div>";
            } else {
                message("error", lang("error_46", true));
            }
        } else {
            message("error", lang("error_47", true));
        }
        echo "\r\n        </div>\r\n    </div>\r\n</div>";
    }
}

?>