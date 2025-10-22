<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */
if (!isLoggedIn()) {
    redirect(1, "login");
} else {
    if (!canAccessModule($_SESSION["username"], "webbankguild", "block")) {
        return NULL;
    }
    if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
        $breadcrumb = generateBreadcrumb();
        echo "\r\n    <h3>\r\n        " . lang("webbankguild_txt_1", true) . "\r\n        <a href=\"" . __BASE_URL__ . "usercp/architect/char/" . $_GET["char"] . "/\"  class=\"btn btn-warning btn-navtop\">" . lang("architect_txt_1", true) . "</a>\r\n        " . $breadcrumb . "\r\n    </h3>";
        if (mconfig("active")) {
            $General = new xGeneral();
            $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("architect");
            $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("architect");
            echo "\r\n    <div class=\"row desc-row\">\r\n        <div class=\"col-xs-12\">" . lang("webbankguild_txt_2", true) . "</div>\r\n    </div>";
            if (!check_value($_GET["char"])) {
                message("error", lang("webbankguild_txt_5", true));
            } else {
                $char = hex_decode($_GET["char"]);
                $char = xss_clean($char);
                $Architect = new Architect();
                $Market = new Market();
                $castleOwnerData = $Architect->castleOwnerData();
                $guildData = $Architect->loadGuildData($char);
                if (!empty($guildData["G_Name"])) {
                    $isCastleOwner = false;
                    $isFromAlliance = false;
                    $canBuild = false;
                    if ($castleOwnerData["G_Name"] == $guildData["G_Name"]) {
                        $isCastleOwner = true;
                        if ($castleOwnerData["G_Master"] == $char) {
                            $canBuild = true;
                        }
                    }
                    if (is_array($castleOwnerData["Alliance"])) {
                        foreach ($castleOwnerData["Alliance"] as $thisGuild) {
                            if ($thisGuild["G_Name"] == $guildData["G_Name"]) {
                                $isFromAlliance = true;
                            }
                        }
                    }
                    if ($isCastleOwner || $isFromAlliance) {
                        if (check_value($_POST["insert_resources"])) {
                            if ($_SESSION["token"] == $_POST["token"]) {
                                if ($_POST["resource"] == "signoflord") {
                                    if ($common->beginDbTrans($_SESSION["username"])) {
                                        $Architect->insertSignOfLord($_SESSION["username"], $char, $_POST["amount"]);
                                        $common->endDbTrans($_SESSION["username"]);
                                    }
                                } else {
                                    if (in_array($_POST["resource"], ["zen", "bless", "soul", "life", "chaos", "harmony", "creation", "guardian"])) {
                                        $Architect->insertFromWebBank($_SESSION["username"], $char, $_POST["amount"], $_POST["resource"]);
                                    }
                                }
                            } else {
                                message("notice", lang("global_module_13", true));
                            }
                        }
                        if ($canBuild && check_value($_POST["withdraw_resources"])) {
                            if ($_SESSION["token"] == $_POST["token"]) {
                                $Architect->withdrawToWebBank($_SESSION["username"], $char, $_POST["amount"], $_POST["resource"]);
                            } else {
                                message("notice", lang("global_module_13", true));
                            }
                        }
                        $bankData = $Architect->loadGuildWebBank($castleOwnerData["G_Name"]);
                        $webBankData = $Market->getBankData($_SESSION["username"]);
                        $token = time();
                        $_SESSION["token"] = $token;
                        echo "\r\n    <div class=\"table-responsive rankings-table\">\r\n        <table class=\"table table-hover text-center\">\r\n            <tr>\r\n                <th class=\"headerRow\">" . lang("webbankguild_txt_3", true) . "</th>\r\n                <th class=\"headerRow\">" . lang("webbankguild_txt_4", true) . "</th>\r\n            </tr>";
                        if (mconfig("valor")) {
                            echo "\r\n            <tr>\r\n                <th class=\"headerRow\">" . lang("architect_txt_8", true) . "</th>\r\n                <td>" . number_format($bankData["Valor"]) . "</td>\r\n            </tr>";
                        }
                        if (mconfig("sign_of_lord")) {
                            echo "\r\n            <tr>\r\n                <th class=\"headerRow\">" . lang("architect_txt_17", true) . "</th>\r\n                <td>" . number_format($bankData["Sign_of_Lord"]) . "</td>\r\n            </tr>";
                        }
                        if (mconfig("zen")) {
                            echo "\r\n            <tr>\r\n                <th class=\"headerRow\">" . lang("currency_zen", true) . "</th>\r\n                <td>" . number_format($bankData["zen"]) . "</td>\r\n            </tr>";
                        }
                        if (mconfig("job")) {
                            echo "\r\n            <tr>\r\n                <th class=\"headerRow\">" . lang("currency_bless", true) . "</th>\r\n                <td>" . number_format($bankData["bless"]) . "</td>\r\n            </tr>";
                        }
                        if (mconfig("jos")) {
                            echo "\r\n            <tr>\r\n                <th class=\"headerRow\">" . lang("currency_soul", true) . "</th>\r\n                <td>" . number_format($bankData["soul"]) . "</td>\r\n            </tr>";
                        }
                        if (mconfig("jol")) {
                            echo "\r\n            <tr>\r\n                <th class=\"headerRow\">" . lang("currency_life", true) . "</th>\r\n                <td>" . number_format($bankData["life"]) . "</td>\r\n            </tr>";
                        }
                        if (mconfig("joch")) {
                            echo "\r\n            <tr>\r\n                <th class=\"headerRow\">" . lang("currency_chaos", true) . "</th>\r\n                <td>" . number_format($bankData["chaos"]) . "</td>\r\n            </tr>";
                        }
                        if (mconfig("joh")) {
                            echo "\r\n            <tr>\r\n                <th class=\"headerRow\">" . lang("currency_harmony", true) . "</th>\r\n                <td>" . number_format($bankData["harmony"]) . "</td>\r\n            </tr>";
                        }
                        if (mconfig("joc")) {
                            echo "\r\n            <tr>\r\n                <th class=\"headerRow\">" . lang("currency_creation", true) . "</th>\r\n                <td>" . number_format($bankData["creation"]) . "</td>\r\n            </tr>";
                        }
                        if (mconfig("jog")) {
                            echo "\r\n            <tr>\r\n                <th class=\"headerRow\">" . lang("currency_guardian", true) . "</th>\r\n                <td>" . number_format($bankData["guardian"]) . "</td>\r\n            </tr>";
                        }
                        echo "\r\n        </table>\r\n    </div>";
                        if (mconfig("signoflord") || mconfig("zen") || mconfig("job") || mconfig("jos") || mconfig("jol") || mconfig("joch") || mconfig("joh") || mconfig("joc") || mconfig("jog")) {
                            echo "\r\n    <div class=\"row\">\r\n        <div class=\"col-xs-12 col-md-6 col-center\">\r\n            <div class=\"col-xs-12 webbank-section\">\r\n                <div class=\"webbank-section-title\">" . lang("webbankguild_txt_7", true) . "</div>\r\n            </div>";
                            if (!$common->accountOnline($_SESSION["username"])) {
                                echo "\r\n            <form action=\"\" method=\"post\">\r\n                <div class=\"form-group\">\r\n                    <label for=\"resource\">" . lang("webbankguild_txt_8", true) . ":</label>\r\n                    <select name=\"resource\" class=\"form-control\">";
                                $signOfLord = $Architect->loadSignOfLordFromCharacter($_SESSION["username"], $char);
                                if (mconfig("sign_of_lord")) {
                                    echo "<option value=\"signoflord\">" . lang("architect_txt_17", true) . " (" . number_format($signOfLord) . ")</option>";
                                }
                                if (mconfig("zen")) {
                                    echo "<option value=\"zen\">" . lang("currency_zen", true) . " (" . number_format($webBankData["zen"]) . ")</option>";
                                }
                                if (mconfig("job")) {
                                    echo "<option value=\"bless\">" . lang("currency_bless", true) . " (" . number_format($webBankData["bless"]) . ")</option>";
                                }
                                if (mconfig("jos")) {
                                    echo "<option value=\"soul\">" . lang("currency_soul", true) . " (" . number_format($webBankData["soul"]) . ")</option>";
                                }
                                if (mconfig("jol")) {
                                    echo "<option value=\"life\">" . lang("currency_life", true) . " (" . number_format($webBankData["life"]) . ")</option>";
                                }
                                if (mconfig("joch")) {
                                    echo "<option value=\"chaos\">" . lang("currency_chaos", true) . " (" . number_format($webBankData["chaos"]) . ")</option>";
                                }
                                if (mconfig("joh")) {
                                    echo "<option value=\"harmony\">" . lang("currency_harmony", true) . " (" . number_format($webBankData["harmony"]) . ")</option>";
                                }
                                if (mconfig("joc")) {
                                    echo "<option value=\"creation\">" . lang("currency_creation", true) . " (" . number_format($webBankData["creation"]) . ")</option>";
                                }
                                if (mconfig("jog")) {
                                    echo "<option value=\"guardian\">" . lang("currency_guardian", true) . " (" . number_format($webBankData["guardian"]) . ")</option>";
                                }
                                echo "\r\n                    </select>\r\n                </div>\r\n                <div class=\"form-group\">\r\n                    <label>" . lang("webbankguild_txt_10", true) . "</label>\r\n                    <input type=\"text\" name=\"amount\" class=\"form-control\">\r\n                </div>\r\n                <span class=\"help-block\" id=\"helpBlock\">" . lang("webbankguild_txt_9", true) . "</span>\r\n                <div class=\"form-group\">\r\n                    <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                    <input type=\"submit\" name=\"insert_resources\" value=\"" . lang("webbankguild_txt_7", true) . "\" class=\"btn btn-primary full-width-btn\">\r\n                </div>\r\n            </form>";
                            } else {
                                echo "<p>" . lang("webbankguild_txt_23", true) . "</p>";
                            }
                            echo "\r\n        </div>";
                            if ($canBuild) {
                                echo "\r\n        <div class=\"col-xs-12 col-md-6 col-center\">\r\n            <div class=\"col-xs-12 webbank-section\">\r\n                <div class=\"webbank-section-title\">" . lang("webbankguild_txt_24", true) . "</div>\r\n            </div>";
                                if (!$common->accountOnline($_SESSION["username"])) {
                                    echo "\r\n            <form action=\"\" method=\"post\">\r\n                <div class=\"form-group\">\r\n                    <label for=\"resource\">" . lang("webbankguild_txt_8", true) . ":</label>\r\n                    <select name=\"resource\" class=\"form-control\">";
                                    if (mconfig("zen")) {
                                        echo "<option value=\"zen\">" . lang("currency_zen", true) . "</option>";
                                    }
                                    if (mconfig("job")) {
                                        echo "<option value=\"bless\">" . lang("currency_bless", true) . "</option>";
                                    }
                                    if (mconfig("jos")) {
                                        echo "<option value=\"soul\">" . lang("currency_soul", true) . "</option>";
                                    }
                                    if (mconfig("jol")) {
                                        echo "<option value=\"life\">" . lang("currency_life", true) . "</option>";
                                    }
                                    if (mconfig("joch")) {
                                        echo "<option value=\"chaos\">" . lang("currency_chaos", true) . "</option>";
                                    }
                                    if (mconfig("joh")) {
                                        echo "<option value=\"harmony\">" . lang("currency_harmony", true) . "</option>";
                                    }
                                    if (mconfig("joc")) {
                                        echo "<option value=\"creation\">" . lang("currency_creation", true) . "</option>";
                                    }
                                    if (mconfig("jog")) {
                                        echo "<option value=\"guardian\">" . lang("currency_guardian", true) . "</option>";
                                    }
                                    echo "\r\n                    </select>\r\n                </div>\r\n                <div class=\"form-group\">\r\n                    <label>" . lang("webbankguild_txt_10", true) . "</label>\r\n                    <input type=\"text\" name=\"amount\" class=\"form-control\">\r\n                </div>\r\n                <span class=\"help-block\" id=\"helpBlock\">" . lang("webbankguild_txt_25", true) . "</span>\r\n                <div class=\"form-group\">\r\n                    <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                    <input type=\"submit\" name=\"withdraw_resources\" value=\"" . lang("webbankguild_txt_24", true) . "\" class=\"btn btn-primary full-width-btn\">\r\n                </div>\r\n            </form>";
                                } else {
                                    echo "<p>" . lang("webbankguild_txt_23", true) . "</p>";
                                }
                                echo "\r\n        </div>";
                            }
                            echo "\r\n    </div>";
                        }
                        echo "\r\n    <h3 style=\"padding-top: 2em;\">" . lang("webbankguild_txt_13", true) . "</h3>";
                        echo "\r\n    <div class=\"table-responsive rankings-table\">\r\n        <table class=\"table table-hover text-center\">\r\n            <tr>\r\n                <th class=\"headerRow\">" . lang("webbankguild_txt_14", true) . "</th>\r\n                <th class=\"headerRow\">" . lang("webbankguild_txt_15", true) . "</th>\r\n                <th class=\"headerRow\">" . lang("webbankguild_txt_16", true) . "</th>\r\n                <th class=\"headerRow\">" . lang("webbankguild_txt_18", true) . "</th>\r\n            </tr>";
                        $sevenDaysAgo = date("Y-m-d H:i:s", strtotime("-7 days"));
                        $transactions = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_WEB_BANK_GUILD_LOGS WHERE Guild = ? AND Date >= ? ORDER BY Date DESC", [$castleOwnerData["G_Name"], $sevenDaysAgo]);
                        if (is_array($transactions)) {
                            foreach ($transactions as $thisLog) {
                                $opType = "";
                                if ($thisLog["Operation_Type"] == "1") {
                                    $opType = lang("webbankguild_txt_19", true);
                                } else {
                                    if ($thisLog["Operation_Type"] == "2") {
                                        $opType = lang("webbankguild_txt_20", true);
                                    }
                                }
                                echo "\r\n            <tr>\r\n                <td>" . date($config["time_date_format"], strtotime($thisLog["Date"])) . "</td>\r\n                <td>" . $thisLog["Name"] . "</td>\r\n                <td>" . number_format($thisLog["Amount"]) . " " . $Architect->returnResourceName($thisLog["Resource_Type"]) . "</td>\r\n                <td>" . $opType . "</td>\r\n            </tr>";
                            }
                        } else {
                            echo "<tr><td colspan=\"4\">" . lang("webbankguild_txt_17", true) . "</td></tr>";
                        }
                        echo "\r\n        </table>\r\n    </div>";
                    } else {
                        message("error", lang("webbankguild_txt_6", true));
                    }
                } else {
                    message("error", lang("architect_txt_15", true));
                }
            }
        } else {
            message("error", lang("error_47", true));
        }
    } else {
        echo "\r\n<div class=\"sub-page-title\">\r\n    <div id=\"title\">\r\n        <h1>" . lang("module_titles_txt_3", true) . "<p></p><span></span></h1>\r\n    </div>\r\n</div>\r\n\r\n<div class=\"container_2 account\" align=\"center\">\r\n    <div class=\"cont-image\">\r\n        <div class=\"container_3 account_sub_header\">\r\n            <div class=\"grad\">\r\n                <div class=\"page-title\"><p>" . lang("webbankguild_txt_1", true) . "</p></div>\r\n                <a href=\"" . __BASE_URL__ . "usercp/architect/char/" . $_GET["char"] . "/\" style=\"background-image: none;padding: 9px 12px 10px 10px\">" . lang("architect_txt_1", true) . "</a>\r\n                <a href=\"" . __BASE_URL__ . "usercp\">" . lang("global_module_1", true) . "</a>\r\n            </div>\r\n        </div>\r\n        <div class=\"page-desc-holder\">\r\n            " . lang("webbankguild_txt_2", true) . "\r\n        </div>";
        if (mconfig("active")) {
            $General = new xGeneral();
            $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("architect");
            $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("architect");
            if (!check_value($_GET["char"])) {
                message("error", lang("webbankguild_txt_5", true));
            } else {
                $char = hex_decode($_GET["char"]);
                $char = xss_clean($char);
                $Architect = new Architect();
                $Market = new Market();
                $castleOwnerData = $Architect->castleOwnerData();
                $guildData = $Architect->loadGuildData($char);
                if (!empty($guildData["G_Name"])) {
                    $isCastleOwner = false;
                    $isFromAlliance = false;
                    $canBuild = false;
                    if ($castleOwnerData["G_Name"] == $guildData["G_Name"]) {
                        $isCastleOwner = true;
                        if ($castleOwnerData["G_Master"] == $char) {
                            $canBuild = true;
                        }
                    }
                    if (is_array($castleOwnerData["Alliance"])) {
                        foreach ($castleOwnerData["Alliance"] as $thisGuild) {
                            if ($thisGuild["G_Name"] == $guildData["G_Name"]) {
                                $isFromAlliance = true;
                            }
                        }
                    }
                    if ($isCastleOwner || $isFromAlliance) {
                        if (check_value($_POST["insert_resources"])) {
                            if ($_SESSION["token"] == $_POST["token"]) {
                                if ($_POST["resource"] == "signoflord") {
                                    $Architect->insertSignOfLord($_SESSION["username"], $char, $_POST["amount"]);
                                } else {
                                    if (in_array($_POST["resource"], ["zen", "bless", "soul", "life", "chaos", "harmony", "creation", "guardian"])) {
                                        $Architect->insertFromWebBank($_SESSION["username"], $char, $_POST["amount"], $_POST["resource"]);
                                    }
                                }
                            } else {
                                message("notice", lang("global_module_13", true));
                            }
                        }
                        if ($canBuild && check_value($_POST["withdraw_resources"])) {
                            if ($_SESSION["token"] == $_POST["token"]) {
                                $Architect->withdrawToWebBank($_SESSION["username"], $char, $_POST["amount"], $_POST["resource"]);
                            } else {
                                message("notice", lang("global_module_13", true));
                            }
                        }
                        $bankData = $Architect->loadGuildWebBank($castleOwnerData["G_Name"]);
                        $webBankData = $Market->getBankData($_SESSION["username"]);
                        $token = time();
                        $_SESSION["token"] = $token;
                        echo "\r\n                <div class=\"container_3 account-wide\" align=\"center\">\r\n                    <table class=\"general-table-ui\" cellspacing=\"0\">\r\n                        <tr>\r\n                            <th>" . lang("webbankguild_txt_3", true) . "</th>\r\n                            <th>" . lang("webbankguild_txt_4", true) . "</th>\r\n                        </tr>";
                        if (mconfig("valor")) {
                            echo "\r\n                        <tr>\r\n                            <th>" . lang("architect_txt_8", true) . "</th>\r\n                            <td>" . number_format($bankData["Valor"]) . "</td>\r\n                        </tr>";
                        }
                        if (mconfig("sign_of_lord")) {
                            echo "\r\n                        <tr>\r\n                            <th>" . lang("architect_txt_17", true) . "</th>\r\n                            <td>" . number_format($bankData["Sign_of_Lord"]) . "</td>\r\n                        </tr>";
                        }
                        if (mconfig("zen")) {
                            echo "\r\n                        <tr>\r\n                            <th>" . lang("currency_zen", true) . "</th>\r\n                            <td>" . number_format($bankData["zen"]) . "</td>\r\n                        </tr>";
                        }
                        if (mconfig("job")) {
                            echo "\r\n                        <tr>\r\n                            <th>" . lang("currency_bless", true) . "</th>\r\n                            <td>" . number_format($bankData["bless"]) . "</td>\r\n                        </tr>";
                        }
                        if (mconfig("jos")) {
                            echo "\r\n                        <tr>\r\n                            <th>" . lang("currency_soul", true) . "</th>\r\n                            <td>" . number_format($bankData["soul"]) . "</td>\r\n                        </tr>";
                        }
                        if (mconfig("jol")) {
                            echo "\r\n                        <tr>\r\n                            <th>" . lang("currency_life", true) . "</th>\r\n                            <td>" . number_format($bankData["life"]) . "</td>\r\n                        </tr>";
                        }
                        if (mconfig("joch")) {
                            echo "\r\n                        <tr>\r\n                            <th>" . lang("currency_chaos", true) . "</th>\r\n                            <td>" . number_format($bankData["chaos"]) . "</td>\r\n                        </tr>";
                        }
                        if (mconfig("joh")) {
                            echo "\r\n                        <tr>\r\n                            <th>" . lang("currency_harmony", true) . "</th>\r\n                            <td>" . number_format($bankData["harmony"]) . "</td>\r\n                        </tr>";
                        }
                        if (mconfig("joc")) {
                            echo "\r\n                        <tr>\r\n                            <th>" . lang("currency_creation", true) . "</th>\r\n                            <td>" . number_format($bankData["creation"]) . "</td>\r\n                        </tr>";
                        }
                        if (mconfig("jog")) {
                            echo "\r\n                        <tr>\r\n                            <th>" . lang("currency_guardian", true) . "</th>\r\n                            <td>" . number_format($bankData["guardian"]) . "</td>\r\n                        </tr>";
                        }
                        echo "\r\n                    </table>\r\n                </div>";
                        if (mconfig("signoflord") || mconfig("zen") || mconfig("job") || mconfig("jos") || mconfig("jol") || mconfig("joch") || mconfig("joh") || mconfig("joc") || mconfig("jog")) {
                            echo "\r\n                <div class=\"container_3 account_sub_header\">\r\n                    <div class=\"grad\">\r\n                        <div class=\"page-title\">" . lang("webbankguild_txt_7", true) . "</div>\r\n                    </div>\r\n                </div>\r\n                <div class=\"page-desc-holder\">\r\n                    " . lang("webbankguild_txt_9", true) . "\r\n                </div>";
                            if (!$common->accountOnline($_SESSION["username"])) {
                                echo "\r\n                <div class=\"container_3 account-wide\" align=\"center\">\r\n                    <form action=\"\" method=\"post\">\r\n                        <div style=\"padding: 20px 0 14px 0;\">\r\n                            <div class=\"row\">\r\n                                <label for=\"resource\">" . lang("webbankguild_txt_8", true) . ":</label>\r\n                                <select name=\"resource\" styled=\"true\" id=\"select-style-2\" style=\"display: none;\">";
                                $signOfLord = $Architect->loadSignOfLordFromCharacter($_SESSION["username"], $char);
                                if (mconfig("sign_of_lord")) {
                                    echo "<option value=\"signoflord\">" . lang("architect_txt_17", true) . " (" . number_format($signOfLord) . ")</option>";
                                }
                                if (mconfig("zen")) {
                                    echo "<option value=\"zen\">" . lang("currency_zen", true) . " (" . number_format($webBankData["zen"]) . ")</option>";
                                }
                                if (mconfig("job")) {
                                    echo "<option value=\"bless\">" . lang("currency_bless", true) . " (" . number_format($webBankData["bless"]) . ")</option>";
                                }
                                if (mconfig("jos")) {
                                    echo "<option value=\"soul\">" . lang("currency_soul", true) . " (" . number_format($webBankData["soul"]) . ")</option>";
                                }
                                if (mconfig("jol")) {
                                    echo "<option value=\"life\">" . lang("currency_life", true) . " (" . number_format($webBankData["life"]) . ")</option>";
                                }
                                if (mconfig("joch")) {
                                    echo "<option value=\"chaos\">" . lang("currency_chaos", true) . " (" . number_format($webBankData["chaos"]) . ")</option>";
                                }
                                if (mconfig("joh")) {
                                    echo "<option value=\"harmony\">" . lang("currency_harmony", true) . " (" . number_format($webBankData["harmony"]) . ")</option>";
                                }
                                if (mconfig("joc")) {
                                    echo "<option value=\"creation\">" . lang("currency_creation", true) . " (" . number_format($webBankData["creation"]) . ")</option>";
                                }
                                if (mconfig("jog")) {
                                    echo "<option value=\"guardian\">" . lang("currency_guardian", true) . " (" . number_format($webBankData["guardian"]) . ")</option>";
                                }
                                echo "\r\n                                </select>\r\n                            </div>\r\n                            <div class=\"row\">\r\n                                <label for=\"amount\">" . lang("webbankguild_txt_10", true) . ":</label>\r\n                                <input type=\"text\" name=\"amount\">\r\n                            </div>\r\n                            <div class=\"row\" align=\"right\">\r\n                                <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                                <input type=\"submit\" name=\"insert_resources\" value=\"" . lang("webbankguild_txt_7", true) . "\">\r\n                            </div>\r\n                        </div>\r\n                    </form>\r\n                </div>";
                            } else {
                                echo "<p>" . lang("webbankguild_txt_23", true) . "</p>";
                            }
                            if ($canBuild) {
                                echo "\r\n                <div class=\"container_3 account_sub_header\">\r\n                    <div class=\"grad\">\r\n                        <div class=\"page-title\">" . lang("webbankguild_txt_24", true) . "</div>\r\n                    </div>\r\n                </div>\r\n                <div class=\"page-desc-holder\">\r\n                    " . lang("webbankguild_txt_25", true) . "\r\n                </div>";
                                if (!$common->accountOnline($_SESSION["username"])) {
                                    echo "\r\n                <div class=\"container_3 account-wide\" align=\"center\">\r\n                    <form action=\"\" method=\"post\">\r\n                        <div style=\"padding: 20px 0 14px 0;\">\r\n                            <div class=\"row\">\r\n                                <label for=\"resource\">" . lang("webbankguild_txt_8", true) . ":</label>\r\n                                <select name=\"resource\" styled=\"true\" id=\"select-style-2\" style=\"display: none;\">";
                                    if (mconfig("zen")) {
                                        echo "<option value=\"zen\">" . lang("currency_zen", true) . "</option>";
                                    }
                                    if (mconfig("job")) {
                                        echo "<option value=\"bless\">" . lang("currency_bless", true) . "</option>";
                                    }
                                    if (mconfig("jos")) {
                                        echo "<option value=\"soul\">" . lang("currency_soul", true) . "</option>";
                                    }
                                    if (mconfig("jol")) {
                                        echo "<option value=\"life\">" . lang("currency_life", true) . "</option>";
                                    }
                                    if (mconfig("joch")) {
                                        echo "<option value=\"chaos\">" . lang("currency_chaos", true) . "</option>";
                                    }
                                    if (mconfig("joh")) {
                                        echo "<option value=\"harmony\">" . lang("currency_harmony", true) . "</option>";
                                    }
                                    if (mconfig("joc")) {
                                        echo "<option value=\"creation\">" . lang("currency_creation", true) . "</option>";
                                    }
                                    if (mconfig("jog")) {
                                        echo "<option value=\"guardian\">" . lang("currency_guardian", true) . "</option>";
                                    }
                                    echo "\r\n                                </select>\r\n                            </div>\r\n                            <div class=\"row\">\r\n                                <label for=\"amount\">" . lang("webbankguild_txt_10", true) . ":</label>\r\n                                <input type=\"text\" name=\"amount\">\r\n                            </div>\r\n                            <div class=\"row\" align=\"right\">\r\n                                <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                                <input type=\"submit\" name=\"withdraw_resources\" value=\"" . lang("webbankguild_txt_24", true) . "\">\r\n                            </div>\r\n                        </div>\r\n                    </form>\r\n                </div>";
                                } else {
                                    echo "<p>" . lang("webbankguild_txt_23", true) . "</p>";
                                }
                            }
                        }
                        echo "\r\n                <div class=\"container_3 account_sub_header\">\r\n                    <div class=\"grad\">\r\n                        <div class=\"page-title\">" . lang("webbankguild_txt_13", true) . "</div>\r\n                    </div>\r\n                </div>";
                        echo "\r\n                <div class=\"container_3 account-wide\" align=\"center\">\r\n                    <table class=\"general-table-ui\" cellspacing=\"0\">\r\n                        <tr>\r\n                            <th>" . lang("webbankguild_txt_14", true) . "</th>\r\n                            <th>" . lang("webbankguild_txt_15", true) . "</th>\r\n                            <th>" . lang("webbankguild_txt_16", true) . "</th>\r\n                            <th>" . lang("webbankguild_txt_18", true) . "</th>\r\n                        </tr>";
                        $sevenDaysAgo = date("Y-m-d H:i:s", strtotime("-7 days"));
                        $transactions = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_WEB_BANK_GUILD_LOGS WHERE Guild = ? AND Date >= ? ORDER BY Date DESC", [$castleOwnerData["G_Name"], $sevenDaysAgo]);
                        if (is_array($transactions)) {
                            foreach ($transactions as $thisLog) {
                                $opType = "";
                                if ($thisLog["Operation_Type"] == "1") {
                                    $opType = lang("webbankguild_txt_19", true);
                                } else {
                                    if ($thisLog["Operation_Type"] == "2") {
                                        $opType = lang("webbankguild_txt_20", true);
                                    }
                                }
                                echo "\r\n                        <tr>\r\n                            <td>" . date($config["time_date_format"], strtotime($thisLog["Date"])) . "</td>\r\n                            <td>" . $thisLog["Name"] . "</td>\r\n                            <td>" . number_format($thisLog["Amount"]) . " " . $Architect->returnResourceName($thisLog["Resource_Type"]) . "</td>\r\n                            <td>" . $opType . "</td>\r\n                        </tr>";
                            }
                        } else {
                            echo "<tr><td colspan=\"4\">" . lang("webbankguild_txt_17", true) . "</td></tr>";
                        }
                        echo "\r\n                    </table>\r\n                </div>";
                    } else {
                        message("error", lang("webbankguild_txt_6", true));
                    }
                } else {
                    message("error", lang("architect_txt_15", true));
                }
            }
        } else {
            message("error", lang("error_47", true));
        }
        echo "\r\n\t</div>\r\n</div>";
    }
}

?>