<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

if (!isLoggedIn()) {
    redirect(1, "login");
} else {
    if (!canAccessModule($_SESSION["username"], "dualskilltree", "block")) {
        return NULL;
    }
    if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
        $breadcrumb = generateBreadcrumb();
        echo "\r\n    <h3>\r\n        " . lang("dualst_txt_9", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
        if (mconfig("active")) {
            echo "\r\n    <div class=\"row desc-row\">\r\n        <div class=\"col-xs-12\">\r\n            " . sprintf(lang("dualst_txt_10", true), mconfig("required_level"));
            if (mconfig("is_locked") == "1") {
                $creditName = $dB->query_fetch_single("SELECT config_title FROM IMPERIAMUCMS_CREDITS_CONFIG WHERE config_id = ?", [mconfig("credit_config")]);
                echo "<br>" . sprintf(lang("dualst_txt_11", true), mconfig("price"), $creditName["config_title"]);
            }
            echo "\r\n        </div>\r\n    </div>";
            $General = new xGeneral();
            $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("dualskilltree");
            $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("dualskilltree");
            $Character = new Character();
            $AccountCharacters = $Character->AccountCharacter($_SESSION["username"]);
            if (is_array($AccountCharacters)) {
                if (check_value($_POST["unlock"])) {
                    if ($_SESSION["token"] == $_POST["token"]) {
                        $char = Decode($_POST["character"]);
                        $Character->CharacterDualSkillTreeUnlock($_SESSION["username"], $char);
                    } else {
                        message("notice", lang("global_module_13", true));
                    }
                }
                if (check_value($_POST["switch"])) {
                    if ($_SESSION["token"] == $_POST["token"]) {
                        $char = Decode($_POST["character"]);
                        if ($common->beginDbTrans($_SESSION["username"])) {
                            $Character->CharacterDualSkillTreeSwitch($_SESSION["username"], $char);
                            $common->endDbTrans($_SESSION["username"]);
                        }
                    } else {
                        message("notice", lang("global_module_13", true));
                    }
                }
                echo "\r\n    <div class=\"table-responsive rankings-table\">\r\n        <table class=\"table table-hover text-center\">\r\n            <tr>\r\n                <th class=\"headerRow\"></th>\r\n                <th class=\"headerRow\">" . lang("global_module_3", true) . "</th>\r\n                <th class=\"headerRow\">" . lang("global_module_5", true) . "</th>\r\n                <th class=\"headerRow\">" . lang("global_module_6", true) . "</th>";
                if ($config["use_resets"]) {
                    echo "<th class=\"headerRow\">" . lang("global_module_7", true) . "</th>";
                }
                if ($config["use_grand_resets"]) {
                    echo "<th class=\"headerRow\">" . lang("global_module_8", true) . "</th>";
                }
                echo "<th class=\"headerRow\">" . lang("resetcharacter_txt_3", true) . "</th>\r\n                <th class=\"headerRow\"></th>\r\n            </tr>";
                $token = time();
                $_SESSION["token"] = $token;
                foreach ($AccountCharacters as $thisCharacter) {
                    $characterData = $Character->CharacterData($thisCharacter);
                    $characterIMG = $Character->GenerateCharacterClassAvatar($characterData[_CLMN_CHR_CLASS_]);
                    if (mconfig("is_locked") == "1") {
                        $checkDualSkillTree = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_DUAL_SKILLTREE WHERE Name = ?", [$characterData[_CLMN_CHR_NAME_]]);
                        if ($checkDualSkillTree["AccountID"] == NULL) {
                            $locked = "<button name=\"unlock\" value=\"unlock\" class=\"btn btn-success full-width-btn\">" . lang("dualst_txt_12", true) . "</button>";
                        } else {
                            $locked = "<button name=\"switch\" value=\"switch\" class=\"btn btn-warning full-width-btn\">" . lang("dualst_txt_13", true) . "</button>";
                        }
                    } else {
                        $locked = "<button name=\"switch\" value=\"switch\" class=\"btn btn-warning full-width-btn\">" . lang("dualst_txt_13", true) . "</button>";
                    }
                    echo "\r\n            <form action=\"\" method=\"post\">\r\n                <input type=\"hidden\" name=\"character\" value=\"" . Encode($characterData[_CLMN_CHR_NAME_]) . "\"/>\r\n                <tr>\r\n                    <td>" . $characterIMG . "</td>\r\n                    <td>" . $common->replaceHtmlSymbols($characterData[_CLMN_CHR_NAME_]) . "</td>\r\n                    <td>" . $characterData[_CLMN_CHR_LVL_] . "</td>\r\n                    <td>" . $characterData["mLevel"] . "</td>";
                    if ($config["use_resets"]) {
                        echo "<td>" . $characterData[_CLMN_CHR_RSTS_] . "</td>";
                    }
                    if ($config["use_grand_resets"]) {
                        echo "<td>" . $characterData["Grand_Resets"] . "</td>";
                    }
                    echo "<td>" . number_format($characterData[_CLMN_CHR_ZEN_]) . "</td>";
                    echo "<td><input type=\"hidden\" name=\"token\" value=\"" . $token . "\">" . $locked . "</td>";
                    echo "\r\n                </tr>\r\n            </form>";
                }
                echo "\r\n        </table>\r\n    </div>";
            } else {
                message("error", lang("error_46", true));
            }
        } else {
            message("error", lang("error_47", true));
        }
    } else {
        echo "\r\n<div class=\"sub-page-title\">\r\n    <div id=\"title\">\r\n        <h1>" . lang("module_titles_txt_3", true) . "<p></p><span></span></h1>\r\n    </div>\r\n</div>\r\n    <div class=\"container_2 account\" align=\"center\">\r\n        <div class=\"cont-image\">\r\n            <div class=\"container_3 account_sub_header\">\r\n                <div class=\"grad\">\r\n                    <div class=\"page-title\"><p>" . lang("dualst_txt_9", true) . "</p></div>\r\n                    <a href=\"" . __BASE_URL__ . "usercp\">" . lang("global_module_1", true) . "</a>\r\n                </div>\r\n            </div>\r\n            <div class=\"page-desc-holder\">\r\n        " . sprintf(lang("dualst_txt_10", true), mconfig("required_level"));
        if (mconfig("is_locked") == "1") {
            $creditName = $dB->query_fetch_single("SELECT config_title FROM IMPERIAMUCMS_CREDITS_CONFIG WHERE config_id = ?", [mconfig("credit_config")]);
            echo "<br>" . sprintf(lang("dualst_txt_11", true), mconfig("price"), $creditName["config_title"]);
        }
        echo "</div>";
        if (mconfig("active")) {
            $General = new xGeneral();
            $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("dualskilltree");
            $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("dualskilltree");
            $Character = new Character();
            $AccountCharacters = $Character->AccountCharacter($_SESSION["username"]);
            if (is_array($AccountCharacters)) {
                if (check_value($_POST["unlock"])) {
                    if ($_SESSION["token"] == $_POST["token"]) {
                        $char = Decode($_POST["character"]);
                        $Character->CharacterDualSkillTreeUnlock($_SESSION["username"], $char);
                    } else {
                        message("notice", lang("global_module_13", true));
                    }
                }
                if (check_value($_POST["switch"])) {
                    if ($_SESSION["token"] == $_POST["token"]) {
                        $char = Decode($_POST["character"]);
                        $Character->CharacterDualSkillTreeSwitch($_SESSION["username"], $char);
                    } else {
                        message("notice", lang("global_module_13", true));
                    }
                }
                echo "\r\n        <div class=\"container_3 account-wide\" align=\"center\">\r\n            <table class=\"general-table-ui\" cellspacing=\"0\">\r\n                <tr>\r\n                    <th></th>\r\n                    <th>" . lang("global_module_3", true) . "</th>\r\n                    <th>" . lang("global_module_5", true) . "</th>\r\n                    <th>" . lang("global_module_6", true) . "</th>";
                if ($config["use_resets"]) {
                    echo "<th>" . lang("global_module_7", true) . "</th>";
                }
                if ($config["use_grand_resets"]) {
                    echo "<th>" . lang("global_module_8", true) . "</th>";
                }
                echo "<th>" . lang("resetcharacter_txt_3", true) . "</th>\r\n                    <th></th>\r\n                </tr>";
                $token = time();
                $_SESSION["token"] = $token;
                foreach ($AccountCharacters as $thisCharacter) {
                    $characterData = $Character->CharacterData($thisCharacter);
                    $characterIMG = $Character->GenerateCharacterClassAvatar($characterData[_CLMN_CHR_CLASS_]);
                    if (mconfig("is_locked") == "1") {
                        $checkDualSkillTree = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_DUAL_SKILLTREE WHERE Name = ?", [$characterData[_CLMN_CHR_NAME_]]);
                        if ($checkDualSkillTree["AccountID"] == NULL) {
                            $locked = "<button name=\"unlock\" value=\"unlock\" class=\"ui-button button1\" ><span class=\"button-left\"><span class=\"button-right\">" . lang("dualst_txt_12", true) . "</span></span></button>";
                        } else {
                            $locked = "<button name=\"switch\" value=\"switch\" class=\"ui-button button1\" ><span class=\"button-left\"><span class=\"button-right\">" . lang("dualst_txt_13", true) . "</span></span></button>";
                        }
                    } else {
                        $locked = "<button name=\"switch\" value=\"switch\" class=\"ui-button button1\" ><span class=\"button-left\"><span class=\"button-right\">" . lang("dualst_txt_13", true) . "</span></span></button>";
                    }
                    echo "\r\n                <form action=\"\" method=\"post\">\r\n                    <input type=\"hidden\" name=\"character\" value=\"" . Encode($characterData[_CLMN_CHR_NAME_]) . "\"/>\r\n                    <tr>\r\n                        <td>" . $characterIMG . "</td>\r\n                        <td>" . $common->replaceHtmlSymbols($characterData[_CLMN_CHR_NAME_]) . "</td>\r\n                        <td>" . $characterData[_CLMN_CHR_LVL_] . "</td>\r\n                        <td>" . $characterData["mLevel"] . "</td>";
                    if ($config["use_resets"]) {
                        echo "<td>" . $characterData[_CLMN_CHR_RSTS_] . "</td>";
                    }
                    if ($config["use_grand_resets"]) {
                        echo "<td>" . $characterData["Grand_Resets"] . "</td>";
                    }
                    echo "<td>" . number_format($characterData[_CLMN_CHR_ZEN_]) . "</td>";
                    echo "<td><input type=\"hidden\" name=\"token\" value=\"" . $token . "\">" . $locked . "</td>";
                    echo "\r\n                    </tr>\r\n                </form>";
                }
                echo "\r\n            </table>\r\n        </div>";
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