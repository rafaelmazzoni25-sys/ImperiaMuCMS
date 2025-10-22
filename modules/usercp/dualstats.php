<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

if (!isLoggedIn()) {
    redirect(1, "login");
} else {
    if (!canAccessModule($_SESSION["username"], "dualstats", "block")) {
        return NULL;
    }
    if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
        $breadcrumb = generateBreadcrumb();
        echo "\r\n    <h3>\r\n        " . lang("dualstats_txt_8", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
        if (mconfig("active")) {
            echo "\r\n    <div class=\"row desc-row\">\r\n        <div class=\"col-xs-12\">" . sprintf(lang("dualstats_txt_9", true), mconfig("required_level")) . "</div>\r\n    </div>";
            $General = new xGeneral();
            $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("dualstats");
            $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("dualstats");
            $Character = new Character();
            $AccountCharacters = $Character->AccountCharacter($_SESSION["username"]);
            if (is_array($AccountCharacters)) {
                if (check_value($_POST["switch"])) {
                    if ($_SESSION["token"] == $_POST["token"]) {
                        $char = Decode($_POST["character"]);
                        if ($common->beginDbTrans($_SESSION["username"])) {
                            $Character->CharacterDualStatsSwitch($_SESSION["username"], $char);
                            $common->endDbTrans($_SESSION["username"]);
                        }
                    } else {
                        message("notice", lang("global_module_13", true));
                    }
                }
                if (check_value($_POST["submit"])) {
                    $char = Decode($_POST["character"]);
                    $charData = $Character->CharacterData($char);
                    $locked = false;
                    if (check_value($_POST["unlock"])) {
                        if ($_SESSION["token"] == $_POST["token"]) {
                            $Character->CharacterDualStatsUnlock($_SESSION["username"], $char);
                        } else {
                            message("notice", lang("global_module_13", true));
                        }
                    }
                    if (mconfig("is_locked") == "1") {
                        $checkDualStats = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_DUAL_STATS WHERE Name = ?", [$char]);
                        if ($checkDualStats["AccountID"] == NULL) {
                            $locked = true;
                        } else {
                            $locked = false;
                        }
                    }
                    $token = time();
                    $_SESSION["token"] = $token;
                    if ($locked) {
                        $creditName = $dB->query_fetch_single("SELECT config_title FROM IMPERIAMUCMS_CREDITS_CONFIG WHERE config_id = ?", [mconfig("credit_config")]);
                        echo "\r\n    <div class=\"table-responsive rankings-table\">\r\n        <form method=\"post\" action=\"\">\r\n            <input type=\"hidden\" name=\"character\" value=\"" . Encode($char) . "\">\r\n            <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n            <input type=\"hidden\" name=\"submit\" value=\"submit\">\r\n            <table class=\"table table-hover text-center\">\r\n                <tr>\r\n                    <th colspan=\"3\" class=\"headerRow\">" . lang("dualstats_txt_10", true) . " " . $char . "</th>\r\n                </tr>\r\n                <tr>\r\n                    <td>" . sprintf(lang("dualstats_txt_11", true), mconfig("price"), $creditName["config_title"]) . "</td>\r\n                </tr>\r\n                <tr>\r\n                    <td>\r\n                        <input type=\"hidden\" name=\"character\" value=\"" . Encode($charData[_CLMN_CHR_NAME_]) . "\"/>\r\n                        <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                        <input type=\"hidden\" name=\"submit\" value=\"1\"/>\r\n                        <button name=\"unlock\" value=\"submit\" class=\"btn btn-success full-width-btn\">\r\n                            " . lang("dualstats_txt_12", true) . "\r\n                        </button>\r\n                    </td>\r\n                </tr>\r\n            </table>\r\n        </form>\r\n    </div>";
                    } else {
                        $charDualStatsData = $Character->CharacterDualStatsData($_SESSION["username"], $char);
                        $active1 = "";
                        $active2 = "";
                        $switch1 = "";
                        $switch2 = "";
                        if ($charDualStatsData["active"] == "0") {
                            $str1 = $charData["Strength"];
                            $agi1 = $charData["Dexterity"];
                            $vit1 = $charData["Vitality"];
                            $ene1 = $charData["Energy"];
                            $cmd1 = $charData["Leadership"];
                            $str2 = $charDualStatsData["Strength"];
                            $agi2 = $charDualStatsData["Dexterity"];
                            $vit2 = $charDualStatsData["Vitality"];
                            $ene2 = $charDualStatsData["Energy"];
                            $cmd2 = $charDualStatsData["Leadership"];
                            $active1 = "class=\"dualstats_active\"";
                            $switch2 = "<button name=\"switch\" value=\"submit\" class=\"btn btn-warning full-width-btn\">" . lang("dualstats_txt_13", true) . "</button>";
                        } else {
                            $str2 = $charData["Strength"];
                            $agi2 = $charData["Dexterity"];
                            $vit2 = $charData["Vitality"];
                            $ene2 = $charData["Energy"];
                            $cmd2 = $charData["Leadership"];
                            $str1 = $charDualStatsData["Strength"];
                            $agi1 = $charDualStatsData["Dexterity"];
                            $vit1 = $charDualStatsData["Vitality"];
                            $ene1 = $charDualStatsData["Energy"];
                            $cmd1 = $charDualStatsData["Leadership"];
                            $active2 = "class=\"dualstats_active\"";
                            $switch1 = "<button name=\"switch\" value=\"submit\" class=\"btn btn-warning full-width-btn\">" . lang("dualstats_txt_14", true) . "</button>";
                        }
                        echo "\r\n    <div class=\"table-responsive rankings-table\">\r\n        <form method=\"post\" action=\"\">\r\n            <input type=\"hidden\" name=\"character\" value=\"" . Encode($char) . "\">\r\n            <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n            <input type=\"hidden\" name=\"submit\" value=\"submit\">\r\n            <table class=\"table table-hover text-center\">\r\n                <tr>\r\n                    <th colspan=\"3\" class=\"headerRow\">" . lang("dualstats_txt_10", true) . " " . $common->replaceHtmlSymbols($char) . "</th>\r\n                </tr>\r\n                <tr>\r\n                    <th width=\"20%\"></th>\r\n                    <th width=\"40%\">" . lang("dualstats_txt_15", true) . "</th>\r\n                    <th width=\"40%\">" . lang("dualstats_txt_16", true) . "</th>\r\n                </tr>\r\n                <tr>\r\n                    <td class=\"title\">" . lang("dualstats_txt_17", true) . "</td>\r\n                    <td " . $active1 . ">" . $str1 . "</td>\r\n                    <td " . $active2 . ">" . $str2 . "</td>\r\n                </tr>\r\n                <tr>\r\n                    <td class=\"title\">" . lang("dualstats_txt_18", true) . "</td>\r\n                    <td " . $active1 . ">" . $agi1 . "</td>\r\n                    <td " . $active2 . ">" . $agi2 . "</td>\r\n                </tr>\r\n                <tr>\r\n                    <td class=\"title\">" . lang("dualstats_txt_19", true) . "</td>\r\n                    <td " . $active1 . ">" . $vit1 . "</td>\r\n                    <td " . $active2 . ">" . $vit2 . "</td>\r\n                </tr>\r\n                <tr>\r\n                    <td class=\"title\">" . lang("dualstats_txt_20", true) . "</td>\r\n                    <td " . $active1 . ">" . $ene1 . "</td>\r\n                    <td " . $active2 . ">" . $ene2 . "</td>\r\n                </tr>";
                        if (in_array($charData["Class"], $custom["class_filter"]["lord"])) {
                            echo "\r\n                <tr>\r\n                    <td class=\"title\">" . lang("dualstats_txt_21", true) . "</td>\r\n                    <td " . $active1 . ">" . $cmd1 . "</td>\r\n                    <td " . $active2 . ">" . $cmd2 . "</td>\r\n                </tr>";
                        }
                        echo "\r\n                <tr>\r\n                    <td></td>\r\n                    <td align=\"center\">" . $switch1 . "</td>\r\n                    <td align=\"center\">" . $switch2 . "</td>\r\n                </tr>\r\n            </table>\r\n        </form>\r\n    </div>";
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
                foreach ($AccountCharacters as $thisCharacter) {
                    $characterData = $Character->CharacterData($thisCharacter);
                    $characterIMG = $Character->GenerateCharacterClassAvatar($characterData[_CLMN_CHR_CLASS_]);
                    echo "\r\n            <form action=\"\" method=\"post\">\r\n                <input type=\"hidden\" name=\"character\" value=\"" . Encode($characterData[_CLMN_CHR_NAME_]) . "\"/>\r\n                <tr>\r\n                <td>" . $characterIMG . "</td>\r\n                <td>" . $common->replaceHtmlSymbols($characterData[_CLMN_CHR_NAME_]) . "</td>\r\n                <td>" . $characterData[_CLMN_CHR_LVL_] . "</td>\r\n                <td>" . $characterData["mLevel"] . "</td>";
                    if ($config["use_resets"]) {
                        echo "<td>" . $characterData[_CLMN_CHR_RSTS_] . "</td>";
                    }
                    if ($config["use_grand_resets"]) {
                        echo "<td>" . $characterData["Grand_Resets"] . "</td>";
                    }
                    echo "<td>" . number_format($characterData[_CLMN_CHR_ZEN_]) . "</td>";
                    echo "\r\n                <td>\r\n                    <button name=\"submit\" value=\"submit\" class=\"btn btn-warning full-width-btn\">\r\n                        " . lang("dualstats_txt_22", true) . "\r\n                    </button>\r\n                </td>";
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
        echo "\r\n<div class=\"sub-page-title\">\r\n  <div id=\"title\">\r\n    <h1>" . lang("module_titles_txt_3", true) . "<p></p><span></span></h1>\r\n  </div>\r\n</div>\r\n\r\n  <div class=\"container_2 account\" align=\"center\">\r\n    <div class=\"cont-image\">\r\n      <div class=\"container_3 account_sub_header\">\r\n        <div class=\"grad\">\r\n          <div class=\"page-title\"><p>" . lang("dualstats_txt_8", true) . "</p></div>\r\n          <a href=\"" . __BASE_URL__ . "usercp\">" . lang("global_module_1", true) . "</a>\r\n        </div>\r\n      </div>\r\n      <div class=\"page-desc-holder\">\r\n        " . sprintf(lang("dualstats_txt_9", true), mconfig("required_level")) . "\r\n      </div>";
        if (mconfig("active")) {
            $General = new xGeneral();
            $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("dualstats");
            $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("dualstats");
            $Character = new Character();
            $AccountCharacters = $Character->AccountCharacter($_SESSION["username"]);
            if (is_array($AccountCharacters)) {
                if (check_value($_POST["switch"])) {
                    if ($_SESSION["token"] == $_POST["token"]) {
                        $char = Decode($_POST["character"]);
                        $Character->CharacterDualStatsSwitch($_SESSION["username"], $char);
                    } else {
                        message("notice", lang("global_module_13", true));
                    }
                }
                if (check_value($_POST["submit"])) {
                    $char = Decode($_POST["character"]);
                    $charData = $Character->CharacterData($char);
                    $locked = false;
                    if (check_value($_POST["unlock"])) {
                        if ($_SESSION["token"] == $_POST["token"]) {
                            $Character->CharacterDualStatsUnlock($_SESSION["username"], $char);
                        } else {
                            message("notice", lang("global_module_13", true));
                        }
                    }
                    if (mconfig("is_locked") == "1") {
                        $checkDualStats = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_DUAL_STATS WHERE Name = ?", [$char]);
                        if ($checkDualStats["AccountID"] == NULL) {
                            $locked = true;
                        } else {
                            $locked = false;
                        }
                    }
                    $token = time();
                    $_SESSION["token"] = $token;
                    if ($locked) {
                        $creditName = $dB->query_fetch_single("SELECT config_title FROM IMPERIAMUCMS_CREDITS_CONFIG WHERE config_id = ?", [mconfig("credit_config")]);
                        echo "\r\n          <div class=\"container_3 account-wide\" align=\"center\">\r\n            <form method=\"post\" action=\"\">\r\n              <input type=\"hidden\" name=\"character\" value=\"" . Encode($char) . "\">\r\n              <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n              <input type=\"hidden\" name=\"submit\" value=\"submit\">\r\n              <table class=\"irq\" width=\"100%\" cellspacing=\"0\">\r\n                <tr>\r\n                  <th colspan=\"3\">" . lang("dualstats_txt_10", true) . " " . $char . "</th>\r\n                </tr>\r\n                <tr>\r\n                  <td>" . sprintf(lang("dualstats_txt_11", true), mconfig("price"), $creditName["config_title"]) . "</td>\r\n                </tr>\r\n                <tr>\r\n                    <td>\r\n                        <input type=\"hidden\" name=\"character\" value=\"" . Encode($charData[_CLMN_CHR_NAME_]) . "\"/>\r\n                        <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                        <input type=\"hidden\" name=\"submit\" value=\"1\"/>\r\n                        <button name=\"unlock\" value=\"submit\" class=\"ui-button button1\" ><span class=\"button-left\"><span class=\"button-right\">" . lang("dualstats_txt_12", true) . "</span></span></button>\r\n                    </td>\r\n                </tr>";
                        echo "\r\n              </table>\r\n            </form>\r\n          </div>\r\n          <div style=\"padding-bottom: 30px;\"></div>";
                    } else {
                        $charDualStatsData = $Character->CharacterDualStatsData($_SESSION["username"], $char);
                        $active1 = "";
                        $active2 = "";
                        $switch1 = "";
                        $switch2 = "";
                        if ($charDualStatsData["active"] == "0") {
                            $str1 = $charData["Strength"];
                            $agi1 = $charData["Dexterity"];
                            $vit1 = $charData["Vitality"];
                            $ene1 = $charData["Energy"];
                            $cmd1 = $charData["Leadership"];
                            $str2 = $charDualStatsData["Strength"];
                            $agi2 = $charDualStatsData["Dexterity"];
                            $vit2 = $charDualStatsData["Vitality"];
                            $ene2 = $charDualStatsData["Energy"];
                            $cmd2 = $charDualStatsData["Leadership"];
                            $active1 = "class=\"dualstats_active\"";
                            $switch2 = "<button name=\"switch\" value=\"submit\" class=\"ui-button button1\" ><span class=\"button-left\"><span class=\"button-right\">" . lang("dualstats_txt_13", true) . "</span></span></button>";
                        } else {
                            $str2 = $charData["Strength"];
                            $agi2 = $charData["Dexterity"];
                            $vit2 = $charData["Vitality"];
                            $ene2 = $charData["Energy"];
                            $cmd2 = $charData["Leadership"];
                            $str1 = $charDualStatsData["Strength"];
                            $agi1 = $charDualStatsData["Dexterity"];
                            $vit1 = $charDualStatsData["Vitality"];
                            $ene1 = $charDualStatsData["Energy"];
                            $cmd1 = $charDualStatsData["Leadership"];
                            $active2 = "class=\"dualstats_active\"";
                            $switch1 = "<button name=\"switch\" value=\"submit\" class=\"ui-button button1\" ><span class=\"button-left\"><span class=\"button-right\">" . lang("dualstats_txt_14", true) . "</span></span></button>";
                        }
                        echo "\r\n          <div class=\"container_3 account-wide\" align=\"center\">\r\n            <form method=\"post\" action=\"\">\r\n              <input type=\"hidden\" name=\"character\" value=\"" . Encode($char) . "\">\r\n              <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n              <input type=\"hidden\" name=\"submit\" value=\"submit\">\r\n              <table class=\"irq\" width=\"100%\" cellspacing=\"0\">\r\n                <tr>\r\n                  <th colspan=\"3\">" . lang("dualstats_txt_10", true) . " " . $common->replaceHtmlSymbols($char) . "</th>\r\n                </tr>\r\n                <tr>\r\n                  <th width=\"20%\"></th>\r\n                  <th width=\"40%\">" . lang("dualstats_txt_15", true) . "</th>\r\n                  <th width=\"40%\">" . lang("dualstats_txt_16", true) . "</th>\r\n                </tr>\r\n                <tr>\r\n                  <td class=\"title\">" . lang("dualstats_txt_17", true) . "</td>\r\n                  <td " . $active1 . ">" . $str1 . "</td>\r\n                  <td " . $active2 . ">" . $str2 . "</td>\r\n                </tr>\r\n                <tr>\r\n                  <td class=\"title\">" . lang("dualstats_txt_18", true) . "</td>\r\n                  <td " . $active1 . ">" . $agi1 . "</td>\r\n                  <td " . $active2 . ">" . $agi2 . "</td>\r\n                </tr>\r\n                <tr>\r\n                  <td class=\"title\">" . lang("dualstats_txt_19", true) . "</td>\r\n                  <td " . $active1 . ">" . $vit1 . "</td>\r\n                  <td " . $active2 . ">" . $vit2 . "</td>\r\n                </tr>\r\n                <tr>\r\n                  <td class=\"title\">" . lang("dualstats_txt_20", true) . "</td>\r\n                  <td " . $active1 . ">" . $ene1 . "</td>\r\n                  <td " . $active2 . ">" . $ene2 . "</td>\r\n                </tr>";
                        if (in_array($charData["Class"], $custom["class_filter"]["lord"])) {
                            echo "\r\n                <tr>\r\n                  <td class=\"title\">" . lang("dualstats_txt_21", true) . "</td>\r\n                  <td " . $active1 . ">" . $cmd1 . "</td>\r\n                  <td " . $active2 . ">" . $cmd2 . "</td>\r\n                </tr>";
                        }
                        echo "\r\n                <tr>\r\n                  <td></td>\r\n                  <td align=\"center\">" . $switch1 . "</td>\r\n                  <td align=\"center\">" . $switch2 . "</td>\r\n                </tr>";
                        echo "\r\n              </table>\r\n            </form>\r\n          </div>\r\n          <div style=\"padding-bottom: 30px;\"></div>";
                    }
                }
                echo "\r\n        <div class=\"container_3 account-wide\" align=\"center\">\r\n\t\t\t\t\t<table class=\"general-table-ui\" cellspacing=\"0\">\r\n\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t<th></th>\r\n\t\t\t\t\t\t\t<th>" . lang("global_module_3", true) . "</th>\r\n\t\t\t\t\t\t\t<th>" . lang("global_module_5", true) . "</th>\r\n\t\t\t\t\t\t\t<th>" . lang("global_module_6", true) . "</th>";
                if ($config["use_resets"]) {
                    echo "<th>" . lang("global_module_7", true) . "</th>";
                }
                if ($config["use_grand_resets"]) {
                    echo "<th>" . lang("global_module_8", true) . "</th>";
                }
                echo "<th>" . lang("resetcharacter_txt_3", true) . "</th>\r\n\t\t\t\t\t\t\t<th></th>\r\n\t\t\t\t\t\t</tr>";
                foreach ($AccountCharacters as $thisCharacter) {
                    $characterData = $Character->CharacterData($thisCharacter);
                    $characterIMG = $Character->GenerateCharacterClassAvatar($characterData[_CLMN_CHR_CLASS_]);
                    echo "<form action=\"\" method=\"post\">\r\n\t\t\t\t\t\t\t<input type=\"hidden\" name=\"character\" value=\"" . Encode($characterData[_CLMN_CHR_NAME_]) . "\"/>\r\n\t\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t<td>" . $characterIMG . "</td>\r\n\t\t\t\t\t\t\t<td>" . $common->replaceHtmlSymbols($characterData[_CLMN_CHR_NAME_]) . "</td>\r\n\t\t\t\t\t\t\t<td>" . $characterData[_CLMN_CHR_LVL_] . "</td>\r\n\t\t\t\t\t\t\t<td>" . $characterData["mLevel"] . "</td>";
                    if ($config["use_resets"]) {
                        echo "<td>" . $characterData[_CLMN_CHR_RSTS_] . "</td>";
                    }
                    if ($config["use_grand_resets"]) {
                        echo "<td>" . $characterData["Grand_Resets"] . "</td>";
                    }
                    echo "<td>" . number_format($characterData[_CLMN_CHR_ZEN_]) . "</td>";
                    echo "<td><button name=\"submit\" value=\"submit\" class=\"ui-button button1\" ><span class=\"button-left\"><span class=\"button-right\">" . lang("dualstats_txt_22", true) . "</span></span></button></td>";
                    echo "\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t</form>";
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