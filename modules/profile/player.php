<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$_GET["req"] = hex_decode($_GET["req"]);
loadModuleConfigs("profiles");
if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
    $breadcrumb = generateBreadcrumb();
    echo "\r\n    <h3>\r\n        " . lang("profiles_txt_2", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
    if (mconfig("active")) {
        if (check_value($_GET["req"])) {
            echo "<script type=\"text/javascript\" SRC=\"" . __PATH_TEMPLATE_ASSETS__ . "js/tooltip.js\"></script>";
            try {
                $_GET["req"] = xss_clean($_GET["req"]);
                $Profile = new Profile($dB, $common);
                $Profile->setType("player");
                $Profile->setRequest($_GET["req"]);
                $cData = $Profile->data();
                switch ($cData[2]) {
                    case "0":
                        break;
                    case "1":
                        break;
                    case "2":
                        break;
                    case "3":
                        break;
                    case "7":
                        $img = "gm.png";
                        $_class = "dw";
                        break;
                    case "16":
                        break;
                    case "17":
                        break;
                    case "18":
                        break;
                    case "19":
                        break;
                    case "23":
                        $img = "bm.png";
                        $_class = "dk";
                        break;
                    case "32":
                        break;
                    case "33":
                        break;
                    case "34":
                        break;
                    case "35":
                        break;
                    case "39":
                        $img = "he.png";
                        $_class = "fe";
                        break;
                    case "80":
                        break;
                    case "81":
                        break;
                    case "82":
                        break;
                    case "83":
                        break;
                    case "87":
                        $img = "su.png";
                        $_class = "sum";
                        break;
                    case "48":
                        break;
                    case "49":
                        break;
                    case "50":
                        break;
                    case "54":
                        $img = "dm.png";
                        $_class = "mg";
                        break;
                    case "64":
                        break;
                    case "65":
                        break;
                    case "66":
                        break;
                    case "70":
                        $img = "le.png";
                        $_class = "dl";
                        break;
                    case "96":
                        break;
                    case "97":
                        break;
                    case "98":
                        break;
                    case "102":
                        $img = "rf.png";
                        $_class = "rf";
                        break;
                    case "112":
                        break;
                    case "114":
                        break;
                    case "118":
                        $img = "gl.png";
                        $_class = "gl";
                        break;
                    case "128":
                        break;
                    case "129":
                        break;
                    case "131":
                        break;
                    case "135":
                        $img = "rw.png";
                        $_class = "rw";
                        break;
                    case "144":
                        break;
                    case "145":
                        break;
                    case "147":
                        break;
                    case "151":
                        $img = "sr.png";
                        $_class = "sr";
                        break;
                    default:
                        if ($cData[9] == "1") {
                            $currChar = $dB->query_fetch_single("SELECT GameIDC FROM AccountCharacter WHERE GameIDC = ?", [$cData[1]]);
                            if ($currChar["GameIDC"] == $cData[1]) {
                                $cData[9] = "" . lang("profiles_txt_23", true) . "";
                            } else {
                                $cData[9] = "" . lang("profiles_txt_24", true) . "";
                            }
                        } else {
                            $cData[9] = "" . lang("profiles_txt_24", true) . "";
                        }
                        $seconds = $cData[12] * 60;
                        $days = floor($seconds / 86400);
                        $hours = floor(($seconds - $days * 86400) / 3600);
                        $mins = floor(($seconds - $days * 86400 - $hours * 3600) / 60);
                        $time = sprintf(lang("profiles_txt_27", true), $days, $hours, $mins);
                        $showtime = $time;
                        if ($cData[13] == "--") {
                            $glogo = "";
                        } else {
                            $glogo = returnGuildLogo($cData[16], 16, true);
                            $cData[13] = "<a href=\"" . __BASE_URL__ . "profile/guild/req/" . hex_encode($cData[13]) . "/\">" . $common->replaceHtmlSymbols($cData[13]) . "</a>";
                            $cData[14] = "<a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($cData[14]) . "/\">" . $common->replaceHtmlSymbols($cData[14]) . "</a>";
                        }
                        if ($cData[10] == NULL) {
                            $lastLogin = lang("profiles_txt_26", true);
                        } else {
                            $lastLogin = date($config["time_date_format"], $cData[10]);
                        }
                        if ($cData[11] == NULL) {
                            $lastLogout = lang("profiles_txt_26", true);
                        } else {
                            $lastLogout = date($config["time_date_format"], $cData[11]);
                        }
                        $char_list = explode(",", $cData[27]);
                        $acc_chars = "";
                        $i = count($char_list);
                        foreach ($char_list as $thisChar) {
                            if ($thisChar != $cData[1]) {
                                $acc_chars .= "<a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($thisChar) . "/\">" . $common->replaceHtmlSymbols($thisChar) . "</a>";
                                $last_iteration = !--$i;
                                if (!$last_iteration) {
                                    $acc_chars .= ", ";
                                }
                            } else {
                                $i--;
                            }
                        }
                        if ($cData[21] == "0") {
                            $cData[21] = 14;
                        }
                        if ($cData[19] == 1) {
                            $cData[19] = "<img class=\"rankings-gens-img\" src=\"" . __PATH_TEMPLATE_ASSETS__ . "gens/d" . $cData[21] . ".png\" title=\"" . lang("rankings_txt_26", true) . "\" alt=\"" . lang("rankings_txt_26", true) . "\"/>";
                        } else {
                            if ($cData[19] == 2) {
                                $cData[19] = "<img class=\"rankings-gens-img\" src=\"" . __PATH_TEMPLATE_ASSETS__ . "gens/v" . $cData[21] . ".png\" title=\"" . lang("rankings_txt_27", true) . "\" alt=\"" . lang("rankings_txt_27", true) . "\"/>";
                            } else {
                                $cData[19] = "";
                                $cData[21] = NULL;
                            }
                        }
                        echo "\r\n    <div class=\"row\">\r\n        <div class=\"col-xs-12 col-md-6\">\r\n            <div class=\"table-responsive rankings-table\">\r\n                <table class=\"table table-hover text-center\">\r\n                    <tr>\r\n                        <th colspan=\"2\" class=\"headerRow\">" . lang("profiles_txt_28", true) . "</th>\r\n                    </tr>\r\n                    <tr>\r\n                        <th>" . lang("global_module_3", true) . "</th>\r\n                        <td>" . $common->replaceHtmlSymbols($cData[1]) . "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <th>" . lang("global_module_4", true) . "</th>\r\n                        <td>" . $custom["character_class"][$cData[2]][0] . "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <th>" . lang("global_module_5", true) . "</th>\r\n                        <td>" . $cData[3] . "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <th>" . lang("global_module_6", true) . "</th>\r\n                        <td>" . $cData[4] . "</td>\r\n                    </tr>";
                        if ($config["use_resets"]) {
                            echo "\r\n                    <tr>\r\n                        <th>" . lang("global_module_7", true) . "</th>\r\n                        <td>" . $cData[5] . "</td>\r\n                    </tr>";
                        }
                        if ($config["use_grand_resets"]) {
                            echo "\r\n                    <tr>\r\n                        <th>" . lang("global_module_8", true) . "</th>\r\n                        <td>" . $cData[6] . "</td>\r\n                    </tr>";
                        }
                        if (mconfig("player_stats")) {
                            echo "\r\n                    <tr>\r\n                        <th>" . lang("profiles_txt_10", true) . "</th>\r\n                        <td>" . number_format($cData[22]) . "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <th>" . lang("profiles_txt_11", true) . "</th>\r\n                        <td>" . number_format($cData[23]) . "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <th>" . lang("profiles_txt_12", true) . "</th>\r\n                        <td>" . number_format($cData[24]) . "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <th>" . lang("profiles_txt_13", true) . "</th>\r\n                        <td>" . number_format($cData[25]) . "</td>\r\n                    </tr>";
                            if (in_array($cData[2], $custom["class_filter"]["lord"])) {
                                echo "\r\n                    <tr>\r\n                        <th>" . lang("profiles_txt_14", true) . "</th>\r\n                        <td>" . number_format($cData[26]) . "</td>\r\n                    </tr>";
                            }
                        }
                        if (mconfig("player_location")) {
                            echo "\r\n                    <tr>\r\n                        <th>" . lang("profiles_txt_29", true) . "</th>\r\n                        <td> " . $custom["map_codes"][$cData[7]] . " </td>\r\n                    </tr>";
                        }
                        echo "\r\n                    <tr>\r\n                        <th>" . lang("profiles_txt_30", true) . "</th>\r\n                        <td> " . $custom["pklevel"][$cData[8]] . " </td>\r\n                    </tr>\r\n                    <tr>\r\n                        <th>" . lang("profiles_txt_17", true) . "</th>\r\n                        <td> " . $cData[9] . "</td>\r\n                    </tr>";
                        if ($config["flags"]) {
                            echo "\r\n                    <tr>\r\n                        <th>" . lang("global_module_11", true) . "</th>\r\n                        <td><img src=\"" . __PATH_TEMPLATE__ . "images/blank.png\" class=\"flag-icon flag-icon-" . $cData[17] . " fix-img\" alt=\"" . $custom["countries"][$cData[17]] . "\" title=\"" . $custom["countries"][$cData[17]] . "\" /> " . $custom["countries"][$cData[17]] . "</td>\r\n                    </tr>";
                        }
                        echo "\r\n                </table>\r\n            </div>\r\n        </div>\r\n        <div class=\"col-xs-12 col-md-6\">";
                        if (mconfig("player_info")) {
                            echo "\r\n            <div class=\"table-responsive rankings-table\">\r\n                <table class=\"table table-hover text-center\">\r\n                    <tr>\r\n                        <th colspan=\"2\" class=\"headerRow\">" . lang("profiles_txt_31", true) . "</th>\r\n                    </tr>";
                            if (mconfig("player_chars")) {
                                echo "\r\n                    <tr>\r\n                        <th>" . lang("profiles_txt_32", true) . "</th>\r\n                        <td>" . $acc_chars . "</td>\r\n                    </tr>";
                            }
                            echo "\r\n                    <tr>\r\n                        <th>" . lang("profiles_txt_33", true) . "</th>\r\n                        <td>" . $lastLogin . "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <th>" . lang("profiles_txt_34", true) . "</th>\r\n                        <td>" . $lastLogout . "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <th>" . lang("profiles_txt_35", true) . "</th>\r\n                        <td>" . $showtime . "</td>\r\n                    </tr>\r\n                </table>\r\n            </div>";
                        }
                        if (mconfig("player_gens")) {
                            if ($cData[21] != NULL) {
                                echo "\r\n            <div class=\"table-responsive rankings-table\">\r\n                <table class=\"table table-hover text-center\">\r\n                    <tr>\r\n                        <th colspan=\"3\" class=\"headerRow\">" . lang("profiles_txt_36", true) . "</th>\r\n                    </tr>\r\n                    <tr>\r\n                        <td rowspan=\"3\">" . $cData[19] . "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <th>" . lang("profiles_txt_37", true) . "</th>\r\n                        <td>" . lang("rankings_txt_gens_rank_" . $cData[21], true) . "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <th>" . lang("profiles_txt_38", true) . "</th>\r\n                        <td>" . number_format($cData[20]) . "</td>\r\n                    </tr>\r\n                </table>\r\n            </div>";
                            } else {
                                echo "\r\n            <div class=\"table-responsive rankings-table\">\r\n                <table class=\"table table-hover text-center\">\r\n                    <tr>\r\n                        <th colspan=\"2\" class=\"headerRow\">" . lang("profiles_txt_36", true) . "</th>\r\n                    </tr>\r\n                    <tr>\r\n                        <td colspan=\"2\">" . lang("profiles_txt_39", true) . "</td>\r\n                    </tr>\r\n                </table>\r\n            </div>";
                            }
                        }
                        echo "\r\n            <div class=\"table-responsive rankings-table\">\r\n                <table class=\"table table-hover text-center\">\r\n                    <tr>\r\n                        <th colspan=\"2\" class=\"headerRow\">" . lang("profiles_txt_40", true) . "</th>\r\n                    </tr>\r\n                    <tr>\r\n                        <th>" . lang("profiles_txt_41", true) . "</th>\r\n                        <td>" . $glogo . " " . $cData[13] . "</td >\r\n                    </tr>\r\n                    <tr>\r\n                        <th>" . lang("profiles_txt_42", true) . "</th>\r\n                        <td>";
                        if ($config["flags"] && $cData[18] != NULL) {
                            echo "<img src=\"" . __PATH_TEMPLATE__ . "images/blank.png\" class=\"flag-icon flag-icon-" . $cData[18] . " fix-img\" alt=\"" . $custom["countries"][$cData[18]] . "\" title=\"" . $custom["countries"][$cData[18]] . "\" /> ";
                        }
                        echo "\r\n                            " . $cData[14] . "\r\n                        </td>\r\n                    </tr>\r\n                    <tr>\r\n                        <th>" . lang("profiles_txt_43", true) . "</th>\r\n                        <td>" . $cData[15] . "</td>\r\n                    </tr>\r\n                </table>\r\n            </div>\r\n        </div>";
                        if (mconfig("player_inv")) {
                            $inventory = $Profile->GetCharInventoryResponsive($cData[1]);
                            echo "\r\n        <div class=\"col-xs-12\">\r\n            <div class=\"table-responsive rankings-table\">\r\n                <table class=\"table table-hover text-center\">\r\n                    <tr>\r\n                        <th class=\"headerRow\">" . lang("profiles_txt_44", true) . "</th>\r\n                    </tr>\r\n                    <tr>\r\n                        <td align=\"center\" class=\"no-hover\">" . $inventory . "</td>\r\n                    </tr>\r\n                </table>\r\n            </div>\r\n        </div>";
                        }
                        $General = new xGeneral();
                        if ($General->ftanHCIfo_canUse_j8GsnawwvJ_Module("badges") || $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("badges") && $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("badges")) {
                            $badgesCfg = loadConfigurations("badges");
                            if ($badgesCfg["active"] == "1") {
                                $badgesData = $Profile->getPlayerBadges($cData[1]);
                                echo "\r\n        <div class=\"col-xs-12\">\r\n            <table class=\"table table-hover text-center\">\r\n                <tr>\r\n                    <th class=\"headerRow text-center\">" . lang("profiles_txt_52", true) . "</th>\r\n                </tr>\r\n                <tr>\r\n                    <td align=\"center\" class=\"no-hover\">";
                                if (is_array($badgesData)) {
                                    foreach ($badgesData as $thisBadge) {
                                        if ($thisBadge["Name"] == $cData[1] || $thisBadge["Name"] == NULL) {
                                            $Profile->displayBadge($thisBadge);
                                        }
                                    }
                                } else {
                                    echo lang("badge_none_badges", true);
                                }
                                echo "\r\n                    </td>\r\n                </tr>\r\n            </table>\r\n        </div>\r\n        <script type=\"text/javascript\">\r\n            \$(function () {\r\n                \$('[data-toggle=\"tooltip\"]').tooltip({html:true});\r\n            })\r\n        </script>";
                            }
                        }
                        echo "\r\n    </div>";
                }
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
    echo "<script type=\"text/javascript\" SRC=\"" . __PATH_TEMPLATE__ . "js/tooltip.js\"></script>";
    echo "    <style>\r\n        .profile th {\r\n            background: #18110e;\r\n            padding: 5px;\r\n            border: 1px solid #14070a;\r\n        }\r\n\r\n        .profile {\r\n            border-collapse: collapse;\r\n            text-align: center;\r\n            color: #E5E5E5;\r\n            font-size: 12px;\r\n        }\r\n\r\n        .profile td {\r\n            padding: 5px;\r\n            border: 1px solid #171006;\r\n            background-color: #1b1410;\r\n        }\r\n\r\n        .profile td a {\r\n            color: #e08000;\r\n        }\r\n\r\n        .profile td a:hover {\r\n            color: white;\r\n        }\r\n\r\n        .profile2 th {\r\n            background: #18110e;\r\n            padding: 5px;\r\n            border: 1px solid #14070a;\r\n        }\r\n\r\n        .profile2 {\r\n            border-collapse: collapse;\r\n            text-align: center;\r\n            color: #E5E5E5;\r\n            font-size: 12px;\r\n        }\r\n    </style>\r\n\r\n    ";
    echo "\r\n<div class=\"sub-page-title\">\r\n    <div id=\"title\"><h1>" . lang("profiles_txt_2", true) . "<p></p><span></span></h1></div>\r\n</div>\r\n<div class=\"container_2 account\" align=\"center\">\r\n    <div class=\"cont-image\">\r\n        <div class=\"container_3 account_sub_header\">\r\n            <div class=\"grad\">\r\n                <div class=\"page-title\">" . lang("profiles_txt_25", true) . "</div>\r\n                <div class=\"sub-active-page\">" . $common->replaceHtmlSymbols(xss_clean($_GET["req"])) . "</div>\r\n            </div>\r\n        </div>\r\n        <div class=\"container_3 account-wide\" align=\"center\">";
    if (mconfig("active")) {
        if (check_value($_GET["req"])) {
            try {
                $_GET["req"] = xss_clean($_GET["req"]);
                $Profile = new Profile($dB, $common);
                $Profile->setType("player");
                $Profile->setRequest($_GET["req"]);
                $cData = $Profile->data();
                switch ($cData[2]) {
                    case "0":
                        break;
                    case "1":
                        break;
                    case "2":
                        break;
                    case "3":
                        break;
                    case "7":
                        $img = "gm.png";
                        $_class = "dw";
                        break;
                    case "16":
                        break;
                    case "17":
                        break;
                    case "18":
                        break;
                    case "19":
                        break;
                    case "23":
                        $img = "bm.png";
                        $_class = "dk";
                        break;
                    case "32":
                        break;
                    case "33":
                        break;
                    case "34":
                        break;
                    case "35":
                        break;
                    case "39":
                        $img = "he.png";
                        $_class = "fe";
                        break;
                    case "80":
                        break;
                    case "81":
                        break;
                    case "82":
                        break;
                    case "83":
                        break;
                    case "87":
                        $img = "su.png";
                        $_class = "sum";
                        break;
                    case "48":
                        break;
                    case "49":
                        break;
                    case "50":
                        break;
                    case "54":
                        $img = "dm.png";
                        $_class = "mg";
                        break;
                    case "64":
                        break;
                    case "65":
                        break;
                    case "66":
                        break;
                    case "70":
                        $img = "le.png";
                        $_class = "dl";
                        break;
                    case "96":
                        break;
                    case "97":
                        break;
                    case "98":
                        break;
                    case "102":
                        $img = "rf.png";
                        $_class = "rf";
                        break;
                    case "112":
                        break;
                    case "114":
                        break;
                    case "118":
                        $img = "gl.png";
                        $_class = "gl";
                        break;
                    case "128":
                        break;
                    case "129":
                        break;
                    case "131":
                        break;
                    case "135":
                        $img = "rw.png";
                        $_class = "rw";
                        break;
                    default:
                        if ($cData[9] == "1") {
                            $currChar = $dB->query_fetch_single("SELECT GameIDC FROM AccountCharacter WHERE GameIDC = ?", [$cData[1]]);
                            if ($currChar["GameIDC"] == $cData[1]) {
                                $cData[9] = "<span style=\"color: #318f09; text-shadow: 0 0 3px rgba(0, 0, 0, .55), 1px 1px 0 rgba(0, 0, 0, .45);\">" . lang("profiles_txt_23", true) . "</span>";
                            } else {
                                $cData[9] = "<span style=\"color: #a20c08; text-shadow: 0 0 3px rgba(0, 0, 0, .55), 1px 1px 0 rgba(0, 0, 0, .45);\">" . lang("profiles_txt_24", true) . "</span>";
                            }
                        } else {
                            $cData[9] = "<span style=\"color: #a20c08; text-shadow: 0 0 3px rgba(0, 0, 0, .55), 1px 1px 0 rgba(0, 0, 0, .45);\">" . lang("profiles_txt_24", true) . "</span>";
                        }
                        $seconds = $cData[12] * 60;
                        $days = floor($seconds / 86400);
                        $hours = floor(($seconds - $days * 86400) / 3600);
                        $mins = floor(($seconds - $days * 86400 - $hours * 3600) / 60);
                        $time = sprintf(lang("profiles_txt_27", true), $days, $hours, $mins);
                        $showtime = $time;
                        $inventory = $Profile->GetCharInventory($cData[1], $_class);
                        if ($cData[13] == "--") {
                            $glogo = "";
                        } else {
                            $glogo = returnGuildLogo($cData[16], 16);
                            $cData[13] = "<a href=\"" . __BASE_URL__ . "profile/guild/req/" . hex_encode($cData[13]) . "/\">" . $common->replaceHtmlSymbols($cData[13]) . "</a>";
                            $cData[14] = "<a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($cData[14]) . "/\">" . $common->replaceHtmlSymbols($cData[14]) . "</a>";
                        }
                        if ($cData[10] == NULL) {
                            $lastLogin = lang("profiles_txt_26", true);
                        } else {
                            $lastLogin = date($config["time_date_format"], $cData[10]);
                        }
                        if ($cData[11] == NULL) {
                            $lastLogout = lang("profiles_txt_26", true);
                        } else {
                            $lastLogout = date($config["time_date_format"], $cData[11]);
                        }
                        $char_list = explode(",", $cData[27]);
                        $acc_chars = "";
                        $i = count($char_list);
                        foreach ($char_list as $thisChar) {
                            if ($thisChar != $cData[1]) {
                                $acc_chars .= "<a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($thisChar) . "/\">" . $common->replaceHtmlSymbols($thisChar) . "</a>";
                                $last_iteration = !--$i;
                                if (!$last_iteration) {
                                    $acc_chars .= ", ";
                                }
                            } else {
                                $i--;
                            }
                        }
                        if ($cData[21] == "0") {
                            $cData[21] = 14;
                        }
                        if ($cData[19] == 1) {
                            $cData[19] = "<img class=\"rankings-gens-img\" src=\"" . __PATH_TEMPLATE_IMG__ . "d" . $cData[21] . ".png\" title=\"" . lang("rankings_txt_26", true) . "\" alt=\"" . lang("rankings_txt_26", true) . "\"/>";
                        } else {
                            if ($cData[19] == 2) {
                                $cData[19] = "<img class=\"rankings-gens-img\" src=\"" . __PATH_TEMPLATE_IMG__ . "v" . $cData[21] . ".png\" title=\"" . lang("rankings_txt_27", true) . "\" alt=\"" . lang("rankings_txt_27", true) . "\"/>";
                            } else {
                                $cData[19] = "";
                                $cData[21] = NULL;
                            }
                        }
                        echo "\r\n            <table class=\"irq\" width=\"100%\">\r\n                <tr>\r\n                    <th colspan=\"3\">" . lang("profiles_txt_28", true) . "</th>\r\n                </tr>\r\n                <tr>\r\n                    <td width=\"146px\"><img src=\"" . __PATH_TEMPLATE_IMG__ . "profiles/" . $img . "\"></td>\r\n                    <td>\r\n                        <table class=\"irq\" width=\"100%\">\r\n                            <tr>\r\n                                <td>" . lang("global_module_3", true) . ":</td>\r\n                                <td>" . $common->replaceHtmlSymbols($cData[1]) . "</td>\r\n                            </tr>\r\n                            <tr>\r\n                                <td>" . lang("global_module_4", true) . ":</td>\r\n                                <td>" . $custom["character_class"][$cData[2]][0] . "</td>\r\n                            </tr>\r\n                            <tr>\r\n                                <td>" . lang("global_module_5", true) . ":</td>\r\n                                <td>" . $cData[3] . "</td>\r\n                            </tr>\r\n                            <tr>\r\n                                <td>" . lang("global_module_6", true) . ":</td>\r\n                                <td>" . $cData[4] . "</td>\r\n                            </tr>";
                        if ($config["use_resets"]) {
                            echo "\r\n                            <tr>\r\n                                <td>" . lang("global_module_7", true) . ":</td>\r\n                                <td>" . $cData[5] . "</td>\r\n                            </tr>";
                        }
                        if ($config["use_grand_resets"]) {
                            echo "\r\n                            <tr>\r\n                                <td>" . lang("global_module_8", true) . ":</td>\r\n                                <td>" . $cData[6] . "</td>\r\n                            </tr>";
                        }
                        if (mconfig("player_stats")) {
                            echo "\r\n                            <tr>\r\n                                <td>" . lang("profiles_txt_10", true) . "</td>\r\n                                <td>" . $cData[22] . "</td>\r\n                            </tr>\r\n                            <tr>\r\n                                <td>" . lang("profiles_txt_11", true) . "</td>\r\n                                <td>" . $cData[23] . "</td>\r\n                            </tr>\r\n                            <tr>\r\n                                <td>" . lang("profiles_txt_12", true) . "</td>\r\n                                <td>" . $cData[24] . "</td>\r\n                            </tr>\r\n                            <tr>\r\n                                <td>" . lang("profiles_txt_13", true) . "</td>\r\n                                <td>" . $cData[25] . "</td>\r\n                            </tr>";
                            if (in_array($cData[2], $custom["class_filter"]["lord"])) {
                                echo "\r\n                            <tr>\r\n                                <td>" . lang("profiles_txt_14", true) . ":</td>\r\n                                <td>" . $cData[26] . "</td>\r\n                            </tr>";
                            }
                        }
                        if (mconfig("player_location")) {
                            echo "\r\n                            <tr>\r\n                                <td>" . lang("profiles_txt_29", true) . ":</td>\r\n                                <td> " . $custom["map_codes"][$cData[7]] . " </td>\r\n                            </tr>";
                        }
                        echo "\r\n                            <tr>\r\n                                <td>" . lang("profiles_txt_30", true) . ":</td>\r\n                                <td> " . $custom["pklevel"][$cData[8]] . " </td>\r\n                            </tr>\r\n                            <tr>\r\n                                <td>" . lang("profiles_txt_17", true) . ":</td>\r\n                                <td> " . $cData[9] . "</td>\r\n                            </tr>";
                        if ($config["flags"]) {
                            echo "<tr><td>" . lang("global_module_11", true) . ":</td><td><img src=\"" . __PATH_TEMPLATE__ . "style/images/blank.png\" class=\"flag-icon flag-icon-" . $cData[17] . "\" alt=\"" . $custom["countries"][$cData[17]] . "\" title=\"" . $custom["countries"][$cData[17]] . "\" /> " . $custom["countries"][$cData[17]] . "</td></tr>";
                        }
                        echo "\r\n                        </table>\r\n                    </td>\r\n                </tr>\r\n            </table>";
                        if (mconfig("player_info")) {
                            echo "\r\n            <br />\r\n            <table class=\"irq\" width = \"100%\">\r\n                <tr>\r\n                    <th colspan = \"3\" >" . lang("profiles_txt_31", true) . "</th>\r\n                </tr>";
                            if (mconfig("player_chars")) {
                                echo "\r\n                <tr>\r\n                    <td width=\"50%\">" . lang("profiles_txt_32", true) . ":</td>\r\n                    <td>" . $acc_chars . "</td>\r\n                </tr>";
                            }
                            echo "\r\n                <tr>\r\n                    <td width = \"50%\" >" . lang("profiles_txt_33", true) . ":</td>\r\n                    <td width = \"50%\" >" . $lastLogin . "</td>\r\n                </tr>\r\n                <tr>\r\n                    <td width = \"50%\" >" . lang("profiles_txt_34", true) . ":</td>\r\n                    <td width = \"50%\" >" . $lastLogout . "</td>\r\n                </tr>\r\n                <tr>\r\n                    <td width = \"50%\" >" . lang("profiles_txt_35", true) . ":</td>\r\n                    <td width = \"50%\" >" . $showtime . "</td>\r\n                </tr>\r\n            </table>";
                        }
                        if (mconfig("player_gens")) {
                            if ($cData[21] != NULL) {
                                echo "\r\n                    <br />\r\n                    <table class=\"irq\" width = \"100%\">\r\n                        <tr>\r\n                            <th colspan = \"3\" >" . lang("profiles_txt_36", true) . "</th>\r\n                        </tr>\r\n                        <tr>\r\n                            <td width = \"40%\" >" . lang("profiles_txt_37", true) . ":</td>\r\n                            <td width = \"40%\" >" . lang("rankings_txt_gens_rank_" . $cData[21], true) . "</td>\r\n                            <td width=\"20%\" rowspan=\"2\">" . $cData[19] . "</td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td width = \"40%\" >" . lang("profiles_txt_38", true) . ":</td>\r\n                            <td width = \"40%\" >" . $cData[20] . "</td>\r\n                        </tr>\r\n                    </table>";
                            } else {
                                echo "\r\n                    <br />\r\n                    <table class=\"irq\" width=\"100%\">\r\n                        <tr>\r\n                            <th colspan=\"3\">" . lang("profiles_txt_36", true) . "</th>\r\n                        </tr>\r\n                        <tr>\r\n                            <td colspan=\"2\">" . lang("profiles_txt_39", true) . "</td>\r\n                        </tr>\r\n                    </table>";
                            }
                        }
                        echo "\r\n            <br />\r\n            <table class=\"irq\" width = \"100%\">\r\n                <tr>\r\n                    <th colspan = \"3\" >" . lang("profiles_txt_40", true) . "</th>\r\n                </tr>\r\n                <tr>\r\n                    <td width = \"50%\" >" . lang("profiles_txt_41", true) . ":</td >\r\n                    <td width = \"50%\" >" . $glogo . " " . $cData[13] . "</td >\r\n                </tr>\r\n                <tr>\r\n                    <td width = \"50%\" >" . lang("profiles_txt_42", true) . ":</td >\r\n                    <td width = \"50%\" >";
                        if ($config["flags"] && $cData[18] != NULL) {
                            echo "<img src=\"" . __PATH_TEMPLATE__ . "style/images/blank.png\" class=\"flag-icon flag-icon-" . $cData[18] . "\" alt=\"" . $custom["countries"][$cData[18]] . "\" title=\"" . $custom["countries"][$cData[18]] . "\" /> ";
                        }
                        echo "\r\n                    " . $cData[14] . "\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <td width = \"50%\" >" . lang("profiles_txt_43", true) . ":</td>\r\n                    <td width = \"50%\" >" . $cData[15] . "</td>\r\n                </tr>\r\n            </table>\r\n            <br />";
                        if (mconfig("player_inv")) {
                            echo "\r\n            <table class=\"irq\" width = \"100%\">\r\n                <tr>\r\n                    <th>" . lang("profiles_txt_44", true) . "</th>\r\n                </tr>\r\n                <tr>\r\n                    <td width = \"100%\">" . $inventory . "</td>\r\n                </tr>\r\n            </table>";
                        }
                }
            } catch (Exception $e) {
                message("error", $e->getMessage());
            }
        } else {
            message("error", lang("error_25", true));
        }
    } else {
        message("error", lang("error_47", true));
    }
    echo "\r\n        </div>\r\n    </div>\r\n</div>";
}

?>