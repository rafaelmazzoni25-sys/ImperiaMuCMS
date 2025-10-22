<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

if (!isLoggedIn()) {
    redirect(1, "login");
} else {
    if (!canAccessModule($_SESSION["username"], "addstats", "block")) {
        return NULL;
    }
    if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
        $breadcrumb = generateBreadcrumb();
        echo "\r\n    <h3>\r\n        " . lang("module_titles_txt_25", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
        if (mconfig("active")) {
            echo "\r\n    <div class=\"row desc-row\">\r\n        <div class=\"col-xs-12\">";
            if (mconfig("addstats_enable_zen_requirement")) {
                echo lang("addstats_txt_9", true) . "<br />" . sprintf(lang("addstats_txt_10", true), number_format(mconfig("addstats_price_zen")));
            } else {
                echo lang("addstats_txt_9", true) . "<br />" . lang("addstats_txt_11", true);
            }
            echo "\r\n        </div>\r\n    </div>";
            $Character = new Character();
            $AccountCharacters = $Character->AccountCharacter($_SESSION["username"]);
            if (is_array($AccountCharacters)) {
                if (check_value($_POST["submit"])) {
                    if ($_SESSION["token"] == $_POST["token"]) {
                        if ($common->beginDbTrans($_SESSION["username"])) {
                            $Character->CharacterAddStats($_SESSION["username"], $_POST["character"], $_POST["add_str"], $_POST["add_agi"], $_POST["add_vit"], $_POST["add_ene"], $_POST["add_com"]);
                            $common->endDbTrans($_SESSION["username"]);
                        }
                    } else {
                        message("notice", lang("global_module_13", true));
                    }
                }
                echo "\r\n    <div class=\"table-responsive rankings-table\">\r\n        <table class=\"table table-hover text-center\">\r\n            <tr>\r\n                <th class=\"headerRow\">" . lang("addstats_txt_1", true) . "</th>\r\n                <th class=\"headerRow\">" . lang("addstats_txt_2", true) . "</th>\r\n                <th class=\"headerRow\">" . lang("addstats_txt_3", true) . "</th>\r\n                <th class=\"headerRow\">" . lang("addstats_txt_4", true) . "</th>\r\n                <th class=\"headerRow\">" . lang("addstats_txt_5", true) . "</th>\r\n                <th class=\"headerRow\">" . lang("addstats_txt_6", true) . "</th>\r\n                <th class=\"headerRow\">" . lang("addstats_txt_7", true) . "</th>\r\n                <th class=\"headerRow\"></th>\r\n            </tr>";
                $token = time();
                $_SESSION["token"] = $token;
                foreach ($AccountCharacters as $thisCharacter) {
                    $characterData = $Character->CharacterData($thisCharacter);
                    $characterIMG = $Character->GenerateCharacterClassAvatar($characterData[_CLMN_CHR_CLASS_]);
                    echo "\r\n            <form action=\"\" method=\"post\">\r\n                <input type=\"hidden\" name=\"character\" value=\"" . Encode($characterData[_CLMN_CHR_NAME_]) . "\"/>\r\n                <tr>\r\n                <td>" . $common->replaceHtmlSymbols($characterData[_CLMN_CHR_NAME_]) . "</td>\r\n                <td>" . $characterData[_CLMN_CHR_LVLUP_POINT_] . "</td>\r\n                <td>\r\n                    <div class=\"input-group\">\r\n                        <input class=\"form-control\" type=\"number\" name=\"add_str\" maxlength=\"5\" value=\"0\" min=\"0\" max=\"" . $characterData[_CLMN_CHR_LVLUP_POINT_] . "\" />\r\n                        <div class=\"input-group-addon\">" . $characterData[_CLMN_CHR_STAT_STR_] . "</div>\r\n                    </div>\r\n                </td>\r\n                <td>\r\n                    <div class=\"input-group\">\r\n                        <input class=\"form-control\" type=\"number\" name=\"add_agi\" maxlength=\"5\" value=\"0\" min=\"0\" max=\"" . $characterData[_CLMN_CHR_LVLUP_POINT_] . "\" />\r\n                        <div class=\"input-group-addon\">" . $characterData[_CLMN_CHR_STAT_AGI_] . "</div>\r\n                    </div>\r\n                </td>\r\n                <td>\r\n                    <div class=\"input-group\">\r\n                        <input class=\"form-control\" type=\"number\" name=\"add_vit\" maxlength=\"5\" value=\"0\" min=\"0\" max=\"" . $characterData[_CLMN_CHR_LVLUP_POINT_] . "\" />\r\n                        <div class=\"input-group-addon\">" . $characterData[_CLMN_CHR_STAT_VIT_] . "</div>\r\n                    </div>\r\n                </td>\r\n                <td>\r\n                    <div class=\"input-group\">\r\n                        <input class=\"form-control\" type=\"number\" name=\"add_ene\" maxlength=\"5\" value=\"0\" min=\"0\" max=\"" . $characterData[_CLMN_CHR_LVLUP_POINT_] . "\" />\r\n                        <div class=\"input-group-addon\">" . $characterData[_CLMN_CHR_STAT_ENE_] . "</div>\r\n                    </div>\r\n                </td>";
                    if (in_array($characterData["Class"], $custom["class_filter"]["lord"])) {
                        echo "\r\n                <td>\r\n                    <div class=\"input-group\">\r\n                        <input class=\"form-control\" type=\"number\" name=\"add_com\" maxlength=\"5\" value=\"0\" min=\"0\" max=\"" . $characterData[_CLMN_CHR_LVLUP_POINT_] . "\" />\r\n                        <div class=\"input-group-addon\">" . $characterData[_CLMN_CHR_STAT_CMD_] . "</div>\r\n                    </div>\r\n                </td>";
                    } else {
                        echo "\r\n                <td>\r\n                    <div class=\"input-group\">\r\n                        <input class=\"form-control\" type=\"number\" name=\"add_com\" maxlength=\"5\" value=\"0\" min=\"0\" max=\"" . $characterData[_CLMN_CHR_STAT_CMD_] . "\" disabled=\"disabled\" />\r\n                        <div class=\"input-group-addon\">" . $characterData[_CLMN_CHR_STAT_CMD_] . "</div>\r\n                    </div>\r\n                </td>";
                    }
                    $lacking = NULL;
                    if ($characterData[_CLMN_CHR_LVLUP_POINT_] <= 0) {
                        $lacking = "No lvl up points";
                    }
                    if (mconfig("addstats_enable_zen_requirement") && $characterData[_CLMN_CHR_ZEN_] < mconfig("addstats_price_zen")) {
                        $zen_lacking = mconfig("addstats_price_zen") - $characterData[_CLMN_CHR_ZEN_];
                        if ($lacking == NULL) {
                            $lacking = sprintf(lang("addstats_error_1", true), number_format($zen_lacking));
                        }
                    }
                    if ($lacking == NULL) {
                        echo "<td><input type=\"hidden\" name=\"token\" value=\"" . $token . "\"><button name=\"submit\" value=\"submit\" class=\"btn btn-warning full-width-btn\">" . lang("addstats_txt_8", true) . "</button></td></tr>";
                    } else {
                        echo "<td>" . $lacking . "</td>";
                    }
                    echo "</tr>\r\n            </form>";
                }
                echo "\r\n        </table>\r\n    </div>";
            } else {
                message("error", lang("error_46", true));
            }
        } else {
            message("error", lang("error_47", true));
        }
    } else {
        echo "\r\n<div class=\"sub-page-title\">\r\n    <div id=\"title\">\r\n        <h1>" . lang("module_titles_txt_3", true) . "<p></p><span></span></h1>\r\n    </div>\r\n</div>\r\n<div class=\"container_2 account\" align=\"center\">\r\n    <div class=\"cont-image\">\r\n        <div class=\"container_3 account_sub_header\">\r\n            <div class=\"grad\">\r\n                <div class=\"page-title\"><p>" . lang("module_titles_txt_25", true) . "</p></div>\r\n                <a href=\"" . __BASE_URL__ . "usercp\">" . lang("global_module_1", true) . "</a>\r\n            </div>\r\n        </div>\r\n        <div class=\"page-desc-holder\">";
        if (mconfig("addstats_enable_zen_requirement")) {
            echo lang("addstats_txt_9", true) . "<br />" . sprintf(lang("addstats_txt_10", true), number_format(mconfig("addstats_price_zen")));
        } else {
            echo lang("addstats_txt_9", true) . "<br />" . lang("addstats_txt_11", true);
        }
        echo "\r\n        </div>";
        if (mconfig("active")) {
            $Character = new Character();
            $AccountCharacters = $Character->AccountCharacter($_SESSION["username"]);
            if (is_array($AccountCharacters)) {
                if (check_value($_POST["submit"])) {
                    if ($_SESSION["token"] == $_POST["token"]) {
                        $Character->CharacterAddStats($_SESSION["username"], $_POST["character"], $_POST["add_str"], $_POST["add_agi"], $_POST["add_vit"], $_POST["add_ene"], $_POST["add_com"]);
                    } else {
                        message("notice", lang("global_module_13", true));
                    }
                }
                echo "\r\n        <div class=\"container_3 account-wide\" align=\"center\">\r\n            <table class=\"general-table-ui\" cellspacing=\"0\">\r\n                <tr>\r\n                    <th>" . lang("addstats_txt_1", true) . "</th>\r\n                    <th>" . lang("addstats_txt_2", true) . "</th>\r\n                    <th>" . lang("addstats_txt_3", true) . "</th>\r\n                    <th>" . lang("addstats_txt_4", true) . "</th>\r\n                    <th>" . lang("addstats_txt_5", true) . "</th>\r\n                    <th>" . lang("addstats_txt_6", true) . "</th>\r\n                    <th>" . lang("addstats_txt_7", true) . "</th>\r\n                    <th></th>\r\n                </tr>";
                $token = time();
                $_SESSION["token"] = $token;
                foreach ($AccountCharacters as $thisCharacter) {
                    $characterData = $Character->CharacterData($thisCharacter);
                    $characterIMG = $Character->GenerateCharacterClassAvatar($characterData[_CLMN_CHR_CLASS_]);
                    echo "\r\n            <form action=\"\" method=\"post\">\r\n                <input type=\"hidden\" name=\"character\" value=\"" . Encode($characterData[_CLMN_CHR_NAME_]) . "\"/>\r\n                <tr>\r\n                <td>" . $common->replaceHtmlSymbols($characterData[_CLMN_CHR_NAME_]) . "</td>\r\n                <td>" . $characterData[_CLMN_CHR_LVLUP_POINT_] . "</td>\r\n                <td><small>" . $characterData[_CLMN_CHR_STAT_STR_] . "</small><br /><input style=\"width: 40px;\" type=\"text\" name=\"add_str\" maxlength=\"5\"/></td>\r\n                <td><small>" . $characterData[_CLMN_CHR_STAT_AGI_] . "</small><br /><input style=\"width: 40px;\" type=\"text\" name=\"add_agi\" maxlength=\"5\" /></td>\r\n                <td><small>" . $characterData[_CLMN_CHR_STAT_VIT_] . "</small><br /><input style=\"width: 40px;\" type=\"text\" name=\"add_vit\" maxlength=\"5\" /></td>\r\n                <td><small>" . $characterData[_CLMN_CHR_STAT_ENE_] . "</small><br /><input style=\"width: 40px;\" type=\"text\" name=\"add_ene\" maxlength=\"5\" /></td>";
                    if (in_array($characterData["Class"], $custom["class_filter"]["lord"])) {
                        echo "<td><small>" . $characterData[_CLMN_CHR_STAT_CMD_] . "</small><br /><input style=\"width: 40px;\" type=\"text\" name=\"add_com\" maxlength=\"5\" /></td>";
                    } else {
                        echo "<td><small>" . $characterData[_CLMN_CHR_STAT_CMD_] . "</small><br /><input style=\"width: 40px;\" type=\"text\" name=\"add_com\" maxlength=\"5\" disabled=\"disabled\" value=\"0\"/></td>";
                    }
                    $lacking = NULL;
                    if ($characterData[_CLMN_CHR_LVLUP_POINT_] <= 0) {
                        $lacking = "No lvl up points";
                    }
                    if (mconfig("addstats_enable_zen_requirement") && $characterData[_CLMN_CHR_ZEN_] < mconfig("addstats_price_zen")) {
                        $zen_lacking = mconfig("addstats_price_zen") - $characterData[_CLMN_CHR_ZEN_];
                        if ($lacking == NULL) {
                            $lacking = sprintf(lang("addstats_error_1", true), number_format($zen_lacking));
                        }
                    }
                    if ($lacking == NULL) {
                        echo "<td><input type=\"hidden\" name=\"token\" value=\"" . $token . "\"><button name=\"submit\" value=\"submit\" class=\"ui-button button1\" ><span class=\"button-left\"><span class=\"button-right\">" . lang("addstats_txt_8", true) . "</span></span></button></td></tr>";
                    } else {
                        echo "<td>" . $lacking . "</td>";
                    }
                    echo "</tr>\r\n            </form>";
                }
                echo "</table>\r\n        </div>";
            } else {
                message("error", lang("error_46", true));
            }
        } else {
            message("error", lang("error_47", true));
        }
        echo "\r\n\t</div>\r\n</div>";
    }
}

?>