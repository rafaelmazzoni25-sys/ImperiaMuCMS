<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$_GET["req"] = hex_decode($_GET["req"]);
loadModuleConfigs("profiles");
$General = new xGeneral();
if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
    $breadcrumb = generateBreadcrumb();
    echo "\r\n    <h3>\r\n        " . lang("profiles_txt_1", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
    if (mconfig("active")) {
        if (check_value($_GET["req"])) {
            try {
                $_GET["req"] = xss_clean($_GET["req"]);
                $Profile = new Profile($dB, $common);
                $Profile->setType("guild");
                $Profile->setRequest($_GET["req"]);
                $guildData = $Profile->data();
                $guildMembers = explode(",", $guildData[5]);
                $alliance = "";
                $rivals = "";
                if ($guildData[6] != NULL) {
                    $guildAlliance = explode(",", $guildData[6]);
                    $i = 1;
                    foreach ($guildAlliance as $thisGuild) {
                        $allianceData = explode(":", $thisGuild);
                        $alliance .= returnGuildLogo($allianceData[1], 16, true) . " <a href=\"" . __BASE_URL__ . "profile/guild/req/" . hex_encode($allianceData[0]) . "/\">" . $allianceData[0] . "</a>";
                        if ($i < count($guildAlliance)) {
                            $alliance .= "&nbsp;&nbsp;&nbsp;";
                        }
                        $i++;
                    }
                } else {
                    $alliance = lang("profiles_txt_50", true);
                }
                if ($guildData[7] != NULL) {
                    $guildRivals = explode(",", $guildData[7]);
                    $i = 1;
                    foreach ($guildRivals as $thisGuild) {
                        $rivalData = explode(":", $thisGuild);
                        $rivals .= returnGuildLogo($rivalData[1], 16) . " <a href=\"" . __BASE_URL__ . "profile/guild/req/" . hex_encode($rivalData[0]) . "/\">" . $rivalData[0] . "</a>";
                        if ($i < count($guildRivals)) {
                            $rivals .= "&nbsp;&nbsp;&nbsp;";
                        }
                        $i++;
                    }
                } else {
                    $rivals = lang("profiles_txt_50", true);
                }
                $displayData = ["gname" => $guildData[1], "glogo" => returnGuildLogo($guildData[2], 200), "gmaster" => $guildData[4], "gscore" => $guildData[3], "gmembers" => count($guildMembers), "alliance" => $alliance, "rivals" => $rivals, "gmastercountry" => $guildData[8]];
                $arkaWarWon = $dB->query_fetch_single("SELECT COUNT(G_Name) as total FROM IMPERIAMUCMS_ARKAWAR_HISTORY WHERE G_Name = ?", [$guildData[1]]);
                $csWon = $dB->query_fetch_single("SELECT COUNT(OWNER_GUILD) as total FROM IMPERIAMUCMS_CS_HISTORY WHERE OWNER_GUILD = ?", [$guildData[1]]);
                $valleyWon = $dB->query_fetch_single("SELECT COUNT(G_Name) as total FROM IMPERIAMUCMS_IWV_HISTORY WHERE G_Name = ?", [$guildData[1]]);
                echo "\r\n    <div class=\"row\">\r\n        <div class=\"col-xs-12\">\r\n            <div class=\"table-responsive rankings-table\">\r\n                <table class=\"table table-hover text-center\">\r\n                    <tr>\r\n                        <th colspan=\"3\" class=\"headerRow\">" . $common->replaceHtmlSymbols($displayData["gname"]) . "</th>\r\n                    </tr>\r\n                    <tr>\r\n                        <td rowspan=\"9\" width=\"33%\">" . $displayData["glogo"] . "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>" . lang("profiles_txt_3", true) . "</td>\r\n                        <td>";
                if ($config["flags"] && $displayData["gmastercountry"] != NULL) {
                    echo "<img src=\"" . __PATH_TEMPLATE__ . "images/blank.png\" class=\"flag-icon flag-icon-" . $displayData["gmastercountry"] . " fix-img\" alt=\"" . $custom["countries"][$displayData["gmastercountry"]] . "\" title=\"" . $custom["countries"][$displayData["gmastercountry"]] . "\" /> ";
                }
                echo "\r\n                            <a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($displayData["gmaster"]) . "/\" target=\"_blank\">" . $common->replaceHtmlSymbols($displayData["gmaster"]) . "</a>\r\n                        </td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>" . lang("profiles_txt_4", true) . "</td>\r\n                        <td>" . number_format($displayData["gscore"]) . "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>" . lang("profiles_txt_5", true) . "</td>\r\n                        <td>" . $displayData["gmembers"] . "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>" . lang("profiles_txt_49", true) . "</td>\r\n                        <td>" . $displayData["alliance"] . "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>" . lang("profiles_txt_51", true) . "</td>\r\n                        <td>" . $displayData["rivals"] . "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>" . lang("profiles_txt_53", true) . "</td>\r\n                        <td>" . $csWon["total"] . "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>" . lang("profiles_txt_54", true) . "</td>\r\n                        <td>" . $arkaWarWon["total"] . "</td>\r\n                    </tr>";
                if ($General->ftanHCIfo_canUse_j8GsnawwvJ_Module("icewindvalley")) {
                    echo "\r\n                    <tr>\r\n                        <td>" . lang("profiles_txt_55", true) . "</td>\r\n                        <td>" . $valleyWon["total"] . "</td>\r\n                    </tr>";
                }
                echo "\r\n                </table>\r\n            </div>\r\n        </div>\r\n    </div>";
                if ($General->ftanHCIfo_canUse_j8GsnawwvJ_Module("badges") || $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("badges") && $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("badges")) {
                    $badgesCfg = loadConfigurations("badges");
                    if ($badgesCfg["active"] == "1") {
                        $badgesData = $Profile->getGuildBadges($guildData[9]);
                        echo "\r\n        <div class=\"col-xs-12\">\r\n            <table class=\"table table-hover text-center\">\r\n                <tr>\r\n                    <th class=\"headerRow text-center\">" . lang("profiles_txt_52", true) . "</th>\r\n                </tr>\r\n                <tr>\r\n                    <td align=\"center\" class=\"no-hover\">";
                        if (is_array($badgesData)) {
                            foreach ($badgesData as $thisBadge) {
                                $Profile->displayBadge($thisBadge);
                            }
                        }
                        echo "\r\n                    </td>\r\n                </tr>\r\n            </table>\r\n        </div>\r\n        <script type=\"text/javascript\">\r\n            \$(function () {\r\n                \$('[data-toggle=\"tooltip\"]').tooltip({html:true});\r\n            })\r\n        </script>";
                    }
                }
                echo "\r\n    <div class=\"row\">\r\n        <div class=\"col-xs-12\">\r\n            <div class=\"table-responsive rankings-table\">\r\n                <table class=\"table table-hover text-center\">\r\n                    <tr>\r\n                        <th colspan=\"9\" class=\"headerRow\">" . lang("profiles_txt_6", true) . "</th>\r\n                    </tr>\r\n                    <tr>\r\n                        <th>" . lang("global_module_3", true) . "</th>\r\n                        <th>" . lang("global_module_4", true) . "</th>\r\n                        <th>" . lang("global_module_5", true) . "</th>\r\n                        <th>" . lang("global_module_6", true) . "</th>";
                if ($config["use_resets"]) {
                    echo "\r\n                        <th>" . lang("global_module_7", true) . "</th>";
                }
                if ($config["use_grand_resets"]) {
                    echo "\r\n                        <th>" . lang("global_module_8", true) . "</th>";
                }
                echo "\r\n                        <th>" . lang("profiles_txt_21", true) . "</th>";
                if ($config["flags"]) {
                    echo "\r\n                        <th>" . lang("global_module_11", true) . "</th>";
                }
                echo "\r\n                        <th>" . lang("profiles_txt_22", true) . "</th>\r\n                    </tr>";
                foreach ($guildMembers as $gMember) {
                    $gMember = explode(":", $gMember);
                    list($gMember, $gPos, $gCountry) = $gMember;
                    $playerData = $dB->query_fetch_single("SELECT AccountID, Name, cLevel, LevelUpPoint, Class, Experience, Strength, Dexterity, Vitality, Energy, CONVERT(VARCHAR(MAX), MagicList, 2) AS MagicList, Money, Life, MaxLife, Mana, MaxMana, MapNumber, MapPosX, MapPosY, PkCount, PkLevel, PkTime, MDate, LDate, CtlCode, CONVERT(VARCHAR(MAX), Quest, 2) AS Quest, Leadership, ChatLimitTime, FruitPoint, RESETS, CONVERT(VARCHAR(MAX), Inventory, 2) AS Inventory, Married, MarryName, mLevel, mlPoint, mlExperience, mlNextExp, InventoryExpansion, WinDuels, LoseDuels, Grand_Resets FROM Character WHERE Name = ?", [$gMember]);
                    if (config("SQL_USE_2_DB", true)) {
                        $online = $dB2->query_fetch_single("SELECT ConnectStat FROM MEMB_STAT WHERE memb___id = ?", [$playerData["AccountID"]]);
                    } else {
                        $online = $dB->query_fetch_single("SELECT ConnectStat FROM MEMB_STAT WHERE memb___id = ?", [$playerData["AccountID"]]);
                    }
                    if ($online["ConnectStat"] == "1") {
                        $currChar = $dB->query_fetch_single("SELECT GameIDC FROM AccountCharacter WHERE Id = ?", [$playerData["AccountID"]]);
                        if ($currChar["GameIDC"] == $gMember) {
                            $online = "<span class=\"status-online\">" . lang("profiles_txt_23", true) . "</span>";
                        } else {
                            $online = "<span class=\"status-offline\">" . lang("profiles_txt_24", true) . "</span>";
                        }
                    } else {
                        $online = "<span class=\"status-offline\">" . lang("profiles_txt_24", true) . "</span>";
                    }
                    echo "\r\n                    <tr>\r\n                        <td><a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($gMember) . "/\">" . $common->replaceHtmlSymbols($gMember) . "</a></td>\r\n                        <td>" . $custom["character_class"][$playerData["Class"]][0] . "</td>\r\n                        <td>" . $playerData["cLevel"] . "</td>\r\n                        <td>" . $playerData["mLevel"] . "</td>";
                    if ($config["use_resets"]) {
                        echo "\r\n                        <td>" . $playerData["RESETS"] . "</td>";
                    }
                    if ($config["use_grand_resets"]) {
                        echo "\r\n                        <td>" . $playerData["Grand_Resets"] . "</td>";
                    }
                    echo "\r\n                        <td>" . $gPos . "</td>";
                    if ($config["flags"] && $displayData["gmastercountry"] != NULL) {
                        echo "\r\n                        <td>\r\n                            <img src=\"" . __PATH_TEMPLATE__ . "images/blank.png\" class=\"flag-icon flag-icon-" . $gCountry . " fix-img\" alt=\"" . $custom["countries"][$gCountry] . "\" title=\"" . $custom["countries"][$gCountry] . "\" />\r\n                        </td>";
                    }
                    echo "\r\n                        <td>" . $online . "</td>";
                    echo "\r\n                    </tr>";
                }
                echo "\r\n                </table>\r\n            </div>\r\n        </div>\r\n    </div>";
            } catch (Exception $e) {
                message("error", $e->getMessage());
            }
        } else {
            message("error", lang("error_25", true));
        }
    } else {
        message("error", lang("error_47", true));
    }
} else {
    echo "\r\n<div class=\"sub-page-title\">\r\n  <div id=\"title\"><h1>" . lang("profiles_txt_1", true) . "<p></p><span></span></h1></div>\r\n</div>\r\n<div class=\"container_2 account\" align=\"center\">\r\n  <div class=\"cont-image\">\r\n    <div class=\"container_3 account_sub_header\">\r\n      <div class=\"grad\">\r\n        <div class=\"page-title\">" . lang("profiles_txt_20", true) . "</div>\r\n        <div class=\"sub-active-page\">" . $common->replaceHtmlSymbols(xss_clean($_GET["req"])) . "</div>\r\n      </div>\r\n    </div>\r\n    <div class=\"container_3 account-wide\" align=\"center\">";
    if (mconfig("active")) {
        if (check_value($_GET["req"])) {
            try {
                $_GET["req"] = xss_clean($_GET["req"]);
                $Profile = new Profile($dB, $common);
                $Profile->setType("guild");
                $Profile->setRequest($_GET["req"]);
                $guildData = $Profile->data();
                $guildMembers = explode(",", $guildData[5]);
                $alliance = "";
                $rivals = "";
                if ($guildData[6] != NULL) {
                    $guildAlliance = explode(",", $guildData[6]);
                    $i = 1;
                    foreach ($guildAlliance as $thisGuild) {
                        $allianceData = explode(":", $thisGuild);
                        $alliance .= returnGuildLogo($allianceData[1], 16) . " <a href=\"" . __BASE_URL__ . "profile/guild/req/" . hex_encode($allianceData[0]) . "/\">" . $allianceData[0] . "</a>";
                        if ($i < count($guildAlliance)) {
                            $alliance .= "&nbsp;&nbsp;&nbsp;";
                        }
                        $i++;
                    }
                } else {
                    $alliance = lang("profiles_txt_50", true);
                }
                if ($guildData[7] != NULL) {
                    $guildRivals = explode(",", $guildData[7]);
                    $i = 1;
                    foreach ($guildRivals as $thisGuild) {
                        $rivalData = explode(":", $thisGuild);
                        $rivals .= returnGuildLogo($rivalData[1], 16) . " <a href=\"" . __BASE_URL__ . "profile/guild/req/" . hex_encode($rivalData[0]) . "/\">" . $rivalData[0] . "</a>";
                        if ($i < count($guildRivals)) {
                            $rivals .= "&nbsp;&nbsp;&nbsp;";
                        }
                        $i++;
                    }
                } else {
                    $rivals = lang("profiles_txt_50", true);
                }
                $displayData = ["gname" => $guildData[1], "glogo" => returnGuildLogo($guildData[2], 150), "gmaster" => $guildData[4], "gscore" => $guildData[3], "gmembers" => count($guildMembers), "alliance" => $alliance, "rivals" => $rivals];
                echo "<table class=\"irq\" width=\"100%\"><tr>";
                echo "<th colspan=\"3\">" . $common->replaceHtmlSymbols($displayData["gname"]) . "</th>";
                echo "</tr><tr>";
                echo "<td rowspan=\"6\" width=\"30%\">" . $displayData["glogo"] . "</td>";
                echo "</tr><tr>";
                echo "<td>" . lang("profiles_txt_3", true) . "</td>";
                echo "<td><a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($displayData["gmaster"]) . "/\" target=\"_blank\">" . $common->replaceHtmlSymbols($displayData["gmaster"]) . "</a></td>";
                echo "</tr><tr>";
                echo "<td>" . lang("profiles_txt_4", true) . "</td>";
                echo "<td>" . $displayData["gscore"] . "</td>";
                echo "</tr><tr>";
                echo "<td>" . lang("profiles_txt_5", true) . "</td>";
                echo "<td>" . $displayData["gmembers"] . "</td>";
                echo "</tr><tr>";
                echo "<td>" . lang("profiles_txt_49", true) . "</td>";
                echo "<td>" . $displayData["alliance"] . "</td>";
                echo "</tr><tr>";
                echo "<td>" . lang("profiles_txt_51", true) . "</td>";
                echo "<td>" . $displayData["rivals"] . "</td>";
                echo "</tr></table><br><br><table class=\"irq\" width=\"100%\"><tr>";
                echo "<th colspan=\"6\">" . lang("profiles_txt_6", true) . "</th>";
                echo "</tr><tr>";
                echo "<th>" . lang("global_module_3", true) . "</th>";
                echo "<th>" . lang("global_module_4", true) . "</th>";
                echo "<th>" . lang("global_module_5", true) . " [" . lang("global_module_6", true) . "]</th>";
                if ($config["use_resets"]) {
                    echo "<th>" . lang("global_module_7", true) . "";
                }
                if ($config["use_grand_resets"]) {
                    echo " [" . lang("global_module_8", true) . "]</th>";
                } else {
                    echo "</th>";
                }
                echo "<th>" . lang("profiles_txt_21", true) . "</th>";
                echo "<th>" . lang("profiles_txt_22", true) . "</th>";
                echo "</tr>";
                foreach ($guildMembers as $gMember) {
                    $gMember = explode(":", $gMember);
                    list($gMember, $gPos) = $gMember;
                    $playerData = $dB->query_fetch_single("SELECT AccountID, Name, cLevel, LevelUpPoint, Class, Experience, Strength, Dexterity, Vitality, Energy, CONVERT(VARCHAR(MAX), MagicList, 2) AS MagicList, Money, Life, MaxLife, Mana, MaxMana, MapNumber, MapPosX, MapPosY, PkCount, PkLevel, PkTime, MDate, LDate, CtlCode, CONVERT(VARCHAR(MAX), Quest, 2) AS Quest, Leadership, ChatLimitTime, FruitPoint, RESETS, CONVERT(VARCHAR(MAX), Inventory, 2) AS Inventory, Married, MarryName, mLevel, mlPoint, mlExperience, mlNextExp, InventoryExpansion, WinDuels, LoseDuels, Grand_Resets FROM Character WHERE Name = ?", [$gMember]);
                    if (config("SQL_USE_2_DB", true)) {
                        $online = $dB2->query_fetch_single("SELECT ConnectStat FROM MEMB_STAT WHERE memb___id = ?", [$playerData["AccountID"]]);
                    } else {
                        $online = $dB->query_fetch_single("SELECT ConnectStat FROM MEMB_STAT WHERE memb___id = ?", [$playerData["AccountID"]]);
                    }
                    if ($online["ConnectStat"] == "1") {
                        $currChar = $dB->query_fetch_single("SELECT GameIDC FROM AccountCharacter WHERE Id = ?", [$playerData["AccountID"]]);
                        if ($currChar["GameIDC"] == $gMember) {
                            $online = "<span style=\"color: #318f09; text-shadow: 0 0 3px rgba(0, 0, 0, .55), 1px 1px 0 rgba(0, 0, 0, .45);\">" . lang("profiles_txt_23", true) . "</span>";
                        } else {
                            $online = "<span style=\"color: #a20c08; text-shadow: 0 0 3px rgba(0, 0, 0, .55), 1px 1px 0 rgba(0, 0, 0, .45);\">" . lang("profiles_txt_24", true) . "</span>";
                        }
                    } else {
                        $online = "<span style=\"color: #a20c08; text-shadow: 0 0 3px rgba(0, 0, 0, .55), 1px 1px 0 rgba(0, 0, 0, .45);\">" . lang("profiles_txt_24", true) . "</span>";
                    }
                    echo "\r\n                        <tr>\r\n                            <td><a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($gMember) . "/\">" . $common->replaceHtmlSymbols($gMember) . "</a></td>\r\n                            <td>" . $custom["character_class"][$playerData["Class"]][0] . "</td>\r\n                            <td>" . $playerData["cLevel"] . " [" . $playerData["mLevel"] . "]</td>";
                    if ($config["use_resets"]) {
                        echo "<td>" . $playerData["RESETS"];
                    }
                    if ($config["use_grand_resets"]) {
                        echo " [" . $playerData["Grand_Resets"] . "]</td>";
                    } else {
                        echo "</td>";
                    }
                    echo "<td>" . $gPos . "</td>";
                    echo "<td>" . $online . "</td>";
                    echo "\r\n                        </tr>";
                }
                echo "</table>";
            } catch (Exception $e) {
                message("error", $e->getMessage());
            }
        } else {
            message("error", lang("error_25", true));
        }
    } else {
        message("error", lang("error_47", true));
    }
    echo "\r\n    </div>\r\n  </div>\r\n</div>";
}

?>