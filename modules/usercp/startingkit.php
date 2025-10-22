<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

if (!isLoggedIn()) {
    redirect(1, "login");
} else {
    if (!canAccessModule($_SESSION["username"], "startingkit", "block")) {
        return NULL;
    }
    if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
        $breadcrumb = generateBreadcrumb();
        echo "\r\n    <h3>\r\n        " . lang("startingkit_txt_1", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
        if (mconfig("active")) {
            $General = new xGeneral();
            $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("startingkit");
            $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("startingkit");
            $Market = new Market();
            $Items = new Items();
            $Promo = new Promo();
            echo "<script type=\"text/javascript\" SRC=\"" . __PATH_TEMPLATE_ASSETS__ . "js/tooltip.js\"></script>";
            if (isset($_GET["char"])) {
                $char = hex_decode($_GET["char"]);
                $char = xss_clean($char);
                if (check_value($_POST["submit"])) {
                    if ($_SESSION["token"] == $_POST["token"]) {
                        $kit_id = xss_clean(Decode($_POST["id"]));
                        $item_id = xss_clean(Decode($_POST["item"]));
                        if ($common->beginDbTrans($_SESSION["username"])) {
                            $Promo->claimStartingKit($_SESSION["username"], $char, $kit_id, $item_id);
                            $common->endDbTrans($_SESSION["username"]);
                        }
                    } else {
                        message("notice", lang("global_module_13", true));
                    }
                }
                $token = time();
                $_SESSION["token"] = $token;
                $kits = $Promo->loadStartingKits($_SESSION["username"], $char);
                $checkAccount = $dB->query_fetch_single("SELECT COUNT(*) as total FROM IMPERIAMUCMS_STARTING_KIT_LOGS WHERE AccountID = ?", [$_SESSION["username"]]);
                $checkChar = $dB->query_fetch_single("SELECT COUNT(*) as total FROM IMPERIAMUCMS_STARTING_KIT_LOGS WHERE AccountID = ? AND Name = ?", [$_SESSION["username"], $char]);
                echo "\r\n    <div class=\"row desc-row\">\r\n        <div class=\"col-xs-12\">\r\n            " . sprintf(lang("startingkit_txt_13", true), $checkAccount["total"], mconfig("kits_per_account")) . "<br>\r\n            " . sprintf(lang("startingkit_txt_14", true), $checkChar["total"], mconfig("kits_per_character")) . "\r\n        </div>\r\n    </div>";
                if (is_array($kits)) {
                    foreach ($kits as $kit) {
                        if ($kit["type"] == NULL) {
                            $kit["type"] = 2;
                        }
                        $items = $Promo->loadStartingKitItems($kit["id"]);
                        echo "\r\n    <div class=\"col-xs-12 col-sm-12 col-md-6 col-lg-4\">\r\n        <div class=\"auction\">\r\n            <form method=\"post\">\r\n                <table>\r\n                    <tbody>\r\n                        <tr>\r\n                            <td colspan=\"4\" class=\"auction-text\">\r\n                                <div class=\"auction-title\">" . $kit["title"] . "</div>\r\n                            </td>\r\n                        </tr>\r\n                    </tbody>\r\n                </table>\r\n                <table>\r\n                    <tbody>\r\n                        <tr>\r\n                            <td colspan=\"2\" align=\"center\">";
                        $currentItemID = 0;
                        foreach ($items as $thisItem) {
                            $itemInfo = $Items->ItemInfo($thisItem["item"]);
                            echo "\r\n            <div style=\"height: 170px; display: inline-block;\">\r\n                <div class=\"auction-item-frame\" style=\"cursor: pointer;\" onmouseover=\"Tip(" . $Items->generateItemTooltip($itemInfo, 1, 0, 1, 1, 1, $thisItem["expiration"]) . ")\" onmouseout=\"UnTip()\">";
                            echo "\r\n                    <span class=\"auction-img\"></span><img src=\"" . $itemInfo["thumb"] . "\">\r\n                </div>";
                            if ($kit["type"] == 1) {
                                if ($currentItemID == 0) {
                                    echo "\r\n                                <div>\r\n                                    <label class=\"label_radio r_on\">\r\n                                        <div></div>\r\n                                        <input type=\"radio\" name=\"item\" value=\"" . Encode($currentItemID) . "\" checked=\"checked\">\r\n                                    </label>\r\n                                </div>";
                                } else {
                                    echo "\r\n                                <div>\r\n                                    <label class=\"label_radio\">\r\n                                        <div></div>\r\n                                        <input type=\"radio\" name=\"item\" value=\"" . Encode($currentItemID) . "\"\">\r\n                                    </label>\r\n                                </div>";
                                }
                            } else {
                                if ($kit["type"] == 2) {
                                    echo "\r\n                                <div>\r\n                                    <label class=\"label_check\">\r\n                                        <div></div>\r\n                                        <input type=\"checkbox\" name=\"item\" value=\"" . Encode($currentItemID) . "\" checked=\"checked\" disabled>\r\n                                    </label>\r\n                                </div>";
                                }
                            }
                            echo "    \r\n            </div>";
                            $currentItemID++;
                        }
                        $totalClaimed = $dB->query_fetch_single("SELECT COUNT(kit_id) as count FROM IMPERIAMUCMS_STARTING_KIT_LOGS WHERE kit_id = ? AND AccountID = ? AND Name = ?", [$kit["id"], $_SESSION["username"], $char]);
                        if (empty($totalClaimed["count"])) {
                            $totalClaimed["count"] = 0;
                        }
                        echo "\r\n                    </td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td colspan=\"4\" align=\"right\">\r\n                                <span style=\"vertical-align: bottom; padding-right: 10px;\">" . sprintf(lang("startingkit_txt_19", true), $totalClaimed["count"], $kit["limit"]) . "</span>";
                        if ($totalClaimed["count"] < $kit["limit"]) {
                            echo "\r\n                                <input type=\"hidden\" name=\"id\" value=\"" . Encode($kit["id"]) . "\">\r\n                                <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                                <input type=\"submit\" name=\"submit\" value=\"" . lang("startingkit_txt_12", true) . "\" class=\"btn btn-warning full-width-btn\">";
                        } else {
                            echo "\r\n                                <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                                <input type=\"submit\" name=\"submit\" value=\"" . lang("startingkit_txt_20", true) . "\" class=\"btn btn-warning full-width-btn\" disabled=\"disabled\">";
                        }
                        echo "\r\n                            </td>\r\n                        </tr>\r\n                    </tbody>\r\n                </table>\r\n            </form>\r\n        </div>\r\n    </div>";
                    }
                } else {
                    message("notice", lang("startingkit_txt_6", true));
                }
            } else {
                $chars = $dB->query_fetch("SELECT Name,cLevel,mLevel,RESETS,Grand_Resets,Class from Character where AccountID = ? ORDER BY Grand_Resets desc,RESETS desc,mLevel desc,cLevel desc,Name asc", [$_SESSION["username"]]);
                echo "\r\n        <div class=\"row desc-row\">\r\n            <div class=\"col-xs-12\">\r\n                " . lang("startingkit_txt_2", true) . "\r\n            </div>\r\n        </div>";
                echo "\r\n    <div class=\"table-responsive rankings-table\">\r\n        <table class=\"table table-hover text-center\">\r\n            <tr>\r\n                <th class=\"headerRow\" colspan=\"7\">" . lang("global_module_2", true) . "</th>\r\n            </tr>\r\n            <tr>\r\n                <th class=\"headerRow\">" . lang("global_module_3", true) . "</th>\r\n                <th class=\"headerRow\">" . lang("global_module_4", true) . "</th>\r\n                <th class=\"headerRow\">" . lang("global_module_5", true) . "</th>\r\n                <th class=\"headerRow\">" . lang("global_module_6", true) . "</th>";
                if ($config["use_resets"]) {
                    echo "<th class=\"headerRow\">" . lang("global_module_7", true) . "</th>";
                }
                if ($config["use_grand_resets"]) {
                    echo "<th class=\"headerRow\">" . lang("global_module_8", true) . "</th>";
                }
                echo "\r\n                <th class=\"headerRow\">" . lang("global_module_9", true) . "</th>\r\n            </tr>";
                foreach ($chars as $char) {
                    if ($char["cLevel"] == NULL) {
                        $char["cLevel"] = 0;
                    }
                    if ($char["mLevel"] == NULL) {
                        $char["mLevel"] = 0;
                    }
                    if ($char["RESETS"] == NULL) {
                        $char["RESETS"] = 0;
                    }
                    if ($char["Grand_Resets"] == NULL) {
                        $char["Grand_Resets"] = 0;
                    }
                    echo "\r\n                <tr>\r\n                    <td><b><a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($char["Name"]) . "/\">" . $common->replaceHtmlSymbols($char["Name"]) . "</a></b></td>\r\n                    <td>" . $custom["character_class"][$char["Class"]][0] . "</td>\r\n                    <td>" . $char["cLevel"] . "</td>\r\n                    <td>" . $char["mLevel"] . "</td>";
                    if ($config["use_resets"]) {
                        echo "<td>" . $char["RESETS"] . "</td>";
                    }
                    if ($config["use_grand_resets"]) {
                        echo "<td>" . $char["Grand_Resets"] . "</td>";
                    }
                    echo "\r\n                    <td><a href=\"" . __BASE_URL__ . "usercp/startingkit/char/" . hex_encode($char["Name"]) . "/\">" . lang("startingkit_txt_3", true) . "</a></td>\r\n                </tr>";
                }
                echo "\r\n        </table>\r\n    </div>";
            }
        } else {
            message("error", lang("error_47", true));
        }
    } else {
        echo "\r\n<div class=\"sub-page-title\">\r\n    <div id=\"title\">\r\n        <h1>" . lang("module_titles_txt_3", true) . "<p></p><span></span></h1>\r\n    </div>\r\n</div>\r\n<div class=\"container_2 account\" align=\"center\">\r\n    <div class=\"cont-image\">\r\n        <div class=\"container_3 account_sub_header\">\r\n            <div class=\"grad\">\r\n                <div class=\"page-title\"><p>" . lang("startingkit_txt_1", true) . "</p></div>";
        if (isset($_GET["char"])) {
            echo "<a href=\"" . __BASE_URL__ . "usercp/startingkit\">" . lang("startingkit_txt_7", true) . "</a>";
        } else {
            echo "<a href=\"" . __BASE_URL__ . "usercp/\">" . lang("global_module_1", true) . "</a>";
        }
        echo "\r\n            </div>\r\n        </div>";
        if (mconfig("active")) {
            $General = new xGeneral();
            $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("startingkit");
            $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("startingkit");
            $Market = new Market();
            $Items = new Items();
            $Promo = new Promo();
            echo "<script type=\"text/javascript\" SRC=\"" . __PATH_TEMPLATE__ . "js/tooltip.js\"></script>";
            if (isset($_GET["char"])) {
                $char = hex_decode($_GET["char"]);
                $char = xss_clean($char);
                if (check_value($_POST["submit"])) {
                    if ($_SESSION["token"] == $_POST["token"]) {
                        $kit_id = xss_clean(Decode($_POST["id"]));
                        $item_id = xss_clean(Decode($_POST["item"]));
                        if (!$common->accountOnline($_SESSION["username"])) {
                            $Promo->claimStartingKit($_SESSION["username"], $char, $kit_id, $item_id);
                        } else {
                            message("error", lang("error_14", true));
                        }
                    } else {
                        message("notice", lang("global_module_13", true));
                    }
                }
                $token = time();
                $_SESSION["token"] = $token;
                $kits = $Promo->loadStartingKits($_SESSION["username"], $char);
                $checkAccount = $dB->query_fetch_single("SELECT COUNT(*) as total FROM IMPERIAMUCMS_STARTING_KIT_LOGS WHERE AccountID = ?", [$_SESSION["username"]]);
                $checkChar = $dB->query_fetch_single("SELECT COUNT(*) as total FROM IMPERIAMUCMS_STARTING_KIT_LOGS WHERE AccountID = ? AND Name = ?", [$_SESSION["username"], $char]);
                echo "\r\n        <div class=\"page-desc-holder\">\r\n            " . sprintf(lang("startingkit_txt_13", true), $checkAccount["total"], mconfig("kits_per_account")) . "<br>\r\n            " . sprintf(lang("startingkit_txt_14", true), $checkChar["total"], mconfig("kits_per_character")) . "\r\n        </div>";
                echo "<div class=\"account-wide\" align=\"center\">";
                if (is_array($kits)) {
                    foreach ($kits as $kit) {
                        if ($kit["type"] == NULL) {
                            $kit["type"] = 2;
                        }
                        $items = $Promo->loadStartingKitItems($kit["id"]);
                        echo "\r\n            <div class=\"auction\">\r\n                <form method=\"post\">\r\n                    <table>\r\n                        <tbody>\r\n                            <tr>\r\n                                <td colspan=\"4\" class=\"auction-text\">\r\n                                    <div class=\"auction-title\">" . $kit["title"] . "</div>\r\n                                </td>\r\n                            </tr>\r\n                        </tbody>\r\n                    </table>\r\n                    <table>\r\n                        <tbody>\r\n                            <tr>\r\n                                <td colspan=\"2\" align=\"center\">";
                        $currentItemID = 0;
                        foreach ($items as $thisItem) {
                            $itemInfo = $Items->ItemInfo($thisItem["item"]);
                            if (0 < $thisItem["expiration"]) {
                                $expMinutes = $thisItem["expiration"];
                                $expDays = floor($expMinutes / 1440);
                                $expMinutes = $expMinutes - $expDays * 1440;
                                $expHours = floor($expMinutes / 60);
                                $expMinutes = $expMinutes - $expHours * 60;
                                $expText = "";
                                $expLength = 0;
                                if (0 < $expDays) {
                                    $expText = lang("startingkit_txt_11", true);
                                    $expLength = $expDays;
                                } else {
                                    if (0 < $expHours) {
                                        $expText = lang("startingkit_txt_10", true);
                                        $expLength = $expHours;
                                    } else {
                                        if (0 < $expMinutes) {
                                            $expText = lang("startingkit_txt_9", true);
                                            $expLength = $expMinutes;
                                        }
                                    }
                                }
                                $itemsExpirationInfo = "<br><br><font color=#ff0000>" . sprintf(lang("startingkit_txt_8", true), $expLength, $expText) . "</font>";
                            } else {
                                $itemsExpirationInfo = "";
                            }
                            $luck = "";
                            $skill = "";
                            $option = "";
                            $exl = "";
                            $ancsetopt = "";
                            if ($itemInfo["level"]) {
                                $itemInfo["level"] = " +" . $itemInfo["level"];
                            } else {
                                $itemInfo["level"] = NULL;
                            }
                            if ($itemInfo["luck"]) {
                                $luck = "<br><font color=#9aadd5>" . $itemInfo["luck"] . "</font>";
                            }
                            if ($itemInfo["skill"]) {
                                $skill = "<br><font color=#9aadd5>" . $itemInfo["skill"] . "</font>";
                            }
                            if ($itemInfo["opt"]) {
                                $option = "<font color=#9aadd5>" . $itemInfo["opt"] . "</font>";
                            }
                            if ($itemInfo["exl"]) {
                                $exl = "<font color=#4d668d>" . str_replace("^^", "<br>", $itemInfo["exl"]) . "</font>";
                            }
                            if ($itemInfo["ancsetopt"]) {
                                $ancsetopt = "<font color=#9aadd5>" . str_replace("^^", "<br>", $itemInfo["ancsetopt"]) . "</font>";
                            }
                            echo "\r\n                <div style=\"height: 170px; display: inline-block;\">\r\n                    <div class=\"auction-item-frame\" style=\"cursor: pointer;\" onmouseover=\"Tip('<center><img src=" . $itemInfo["thumb"] . "><br /><font color=white><br>Durability: " . $itemInfo["dur"] . "</font><br><font color=#FF99CC>" . $itemInfo["jog"] . "</font><font color=FFCC00>" . $itemInfo["harm"] . "</font><br>" . $option . " " . $luck . " " . $skill . " " . $exl . " <br>" . $ancsetopt . "<br><font color=#4d668d>" . $itemInfo["socket"] . "</font><br><br><span class=itemTooltipClassReq>" . $itemInfo["classReq"] . "</span>" . $itemsExpirationInfo . "</center>', TITLEFONTCOLOR, '" . $itemInfo["color"] . "',TITLE,'" . addslashes($itemInfo["name"]) . $itemInfo["level"] . "',TITLEBGCOLOR,'" . $itemInfo["anco"] . "')\" onmouseout=\"UnTip()\">";
                            echo "\r\n                        <span class=\"auction-img\"></span><img src=\"" . $itemInfo["thumb"] . "\">\r\n                    </div>";
                            if ($kit["type"] == 1) {
                                if ($currentItemID == 0) {
                                    echo "\r\n                                    <div>\r\n                                        <label class=\"label_radio r_on\">\r\n                                            <div></div>\r\n                                            <input type=\"radio\" name=\"item\" value=\"" . Encode($currentItemID) . "\" checked=\"checked\">\r\n                                        </label>\r\n                                    </div>";
                                } else {
                                    echo "\r\n                                    <div>\r\n                                        <label class=\"label_radio\">\r\n                                            <div></div>\r\n                                            <input type=\"radio\" name=\"item\" value=\"" . Encode($currentItemID) . "\"\">\r\n                                        </label>\r\n                                    </div>";
                                }
                            } else {
                                if ($kit["type"] == 2) {
                                    echo "\r\n                                    <div>\r\n                                        <label class=\"label_check\">\r\n                                            <div></div>\r\n                                            <input type=\"checkbox\" name=\"item\" value=\"" . Encode($currentItemID) . "\" checked=\"checked\" disabled>\r\n                                        </label>\r\n                                    </div>";
                                }
                            }
                            echo "    \r\n                </div>";
                            $currentItemID++;
                        }
                        $totalClaimed = $dB->query_fetch_single("SELECT COUNT(kit_id) as count FROM IMPERIAMUCMS_STARTING_KIT_LOGS WHERE kit_id = ? AND AccountID = ? AND Name = ?", [$kit["id"], $_SESSION["username"], $char]);
                        if (empty($totalClaimed["count"])) {
                            $totalClaimed["count"] = 0;
                        }
                        echo "\r\n                        </td>\r\n                            </tr>\r\n                            <tr>\r\n                                <td colspan=\"4\" align=\"right\">\r\n                                    <span style=\"vertical-align: bottom; padding-right: 10px;\">" . sprintf(lang("startingkit_txt_19", true), $totalClaimed["count"], $kit["limit"]) . "</span>";
                        if ($totalClaimed["count"] < $kit["limit"]) {
                            echo "\r\n                                    <input type=\"hidden\" name=\"id\" value=\"" . Encode($kit["id"]) . "\">\r\n                                    <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                                    <input type=\"submit\" name=\"submit\" value=\"" . lang("startingkit_txt_12", true) . "\">";
                        } else {
                            echo "\r\n                                    <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                                    <input type=\"submit\" name=\"submit\" value=\"" . lang("startingkit_txt_20", true) . "\" class=\"disabled\" disabled=\"disabled\">";
                        }
                        echo "\r\n                                </td>\r\n                            </tr>\r\n                        </tbody>\r\n                    </table>\r\n                </form>\r\n            </div>";
                    }
                } else {
                    message("notice", lang("startingkit_txt_6", true));
                }
                echo "</div>";
            } else {
                $chars = $dB->query_fetch("SELECT Name,cLevel,mLevel,RESETS,Grand_Resets,Class from Character where AccountID = ? ORDER BY Grand_Resets desc,RESETS desc,mLevel desc,cLevel desc,Name asc", [$_SESSION["username"]]);
                echo "<div class=\"page-desc-holder\">" . lang("startingkit_txt_2", true) . "</div>";
                echo "\r\n        <div class=\"container_3 account-wide\" align=\"center\">\r\n            <table class=\"general-table-ui\" cellspacing=\"0\" width=\"100%\">\r\n                <tr>\r\n                    <th colspan=\"5\">" . lang("global_module_2", true) . "</th>\r\n                </tr>\r\n                <tr>\r\n                    <th>" . lang("global_module_3", true) . "</th>\r\n                    <th>" . lang("global_module_4", true) . "</th>\r\n                    <th>" . lang("global_module_5", true) . " [" . lang("global_module_6", true) . "]</th>";
                if ($config["use_resets"]) {
                    echo "<th>" . lang("global_module_7", true) . "";
                }
                if ($config["use_grand_resets"]) {
                    echo " [" . lang("global_module_8", true) . "]</th>";
                } else {
                    echo "</th>";
                }
                echo "\r\n                    <th>" . lang("global_module_9", true) . "</th>\r\n                </tr>";
                foreach ($chars as $char) {
                    if ($char["cLevel"] == NULL) {
                        $char["cLevel"] = 0;
                    }
                    if ($char["mLevel"] == NULL) {
                        $char["mLevel"] = 0;
                    }
                    if ($char["RESETS"] == NULL) {
                        $char["RESETS"] = 0;
                    }
                    if ($char["Grand_Resets"] == NULL) {
                        $char["Grand_Resets"] = 0;
                    }
                    echo "\r\n                <tr>\r\n                    <td><b><a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($char["Name"]) . "/\">" . $common->replaceHtmlSymbols($char["Name"]) . "</a></b></td>\r\n                    <td>" . $custom["character_class"][$char["Class"]][0] . "</td>\r\n                    <td>" . $char["cLevel"] . " [" . $char["mLevel"] . "]</td>";
                    if ($config["use_resets"]) {
                        echo "<td>" . $char["RESETS"];
                    }
                    if ($config["use_grand_resets"]) {
                        echo " [" . $char["Grand_Resets"] . "]</td>";
                    } else {
                        echo "</td>";
                    }
                    echo "\r\n                    <td><a href=\"" . __BASE_URL__ . "usercp/startingkit/char/" . hex_encode($char["Name"]) . "/\">" . lang("startingkit_txt_3", true) . "</a></td>\r\n                </tr>\r\n                ";
                }
                echo "\r\n            </table>\r\n        </div>";
            }
        } else {
            message("error", lang("error_47", true));
        }
        echo "\r\n\t</div>\r\n</div>";
    }
}

?>