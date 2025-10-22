<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

if (!isLoggedIn()) {
    redirect(1, "login");
} else {
    if (!canAccessModule($_SESSION["username"], "architect", "block")) {
        return NULL;
    }
    if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
        $breadcrumb = generateBreadcrumb();
        echo "\r\n    <h3>\r\n        " . lang("architect_txt_1", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
        if (mconfig("active")) {
            $General = new xGeneral();
            $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("architect");
            $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("architect");
            echo "\r\n    <div class=\"row desc-row\">\r\n        <div class=\"row\">\r\n            <div class=\"col-xs-12\" style=\"padding-bottom: 1em;\">";
            if (check_value($_GET["char"])) {
                echo "<a href=\"" . __BASE_URL__ . "usercp/webbankguild/char/" . $_GET["char"] . "/\"  class=\"btn btn-warning btn-navtop\">" . lang("webbankguild_txt_1", true) . "</a>";
            }
            if (check_value($_GET["char"])) {
                if (check_value($_GET["building"]) && $_GET["building"] == "bank") {
                    echo "<a href=\"" . __BASE_URL__ . "usercp/architect/char/" . $_GET["char"] . "\" class=\"btn btn-warning btn-navtop\">" . lang("architect_txt_35", true) . "</a>";
                } else {
                    echo "<a href=\"" . __BASE_URL__ . "usercp/architect/\" class=\"btn btn-warning btn-navtop\">" . lang("architect_txt_34", true) . "</a>";
                }
            }
            echo "\r\n            </div>\r\n        </div>\r\n        <div class=\"col-xs-12\">\r\n            " . lang("architect_txt_2", true) . "\r\n        </div>\r\n    </div>";
            if (check_value($_GET["char"])) {
                $char = hex_decode($_GET["char"]);
                $char = xss_clean($char);
                $Character = new Character();
                if ($Character->CharacterExists($char) && $Character->CharacterBelongsToAccount($char, $_SESSION["username"])) {
                    $Architect = new Architect();
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
                            $buildingsData = $Architect->loadBuildingsData($castleOwnerData["G_Name"]);
                        }
                        if ($canBuild && check_value($_POST["upgrade"]) && ($_POST["type"] == "mine" || $_POST["type"] == "bank")) {
                            if ($_SESSION["token"] == $_POST["token"]) {
                                $Architect->upgradeBuilding($char, $_POST["type"]);
                                $buildingsData = $Architect->loadBuildingsData($castleOwnerData["G_Name"]);
                            } else {
                                message("notice", lang("global_module_13", true));
                            }
                        }
                        if (check_value($_GET["building"]) && $_GET["building"] == "bank" && mconfig("building_bank") && 0 < $buildingsData["Bank_Level"]) {
                            if (check_value($_POST["bank_invest"])) {
                                if ($_SESSION["token"] == $_POST["token"]) {
                                    $Architect->manageInvestments($_POST["type"], $_SESSION["username"], $char, $_POST["amount"], $_POST["resource"]);
                                } else {
                                    message("notice", lang("global_module_13", true));
                                }
                            }
                            $token = time();
                            $_SESSION["token"] = $token;
                            $currLevelCfg = mconfig("bank_stage" . $buildingsData["Bank_Level"]);
                            echo "\r\n    <div class=\"castleArchitect\">\r\n        <div class=\"row\">\r\n            <div class=\"col-xs-12\">\r\n                <div class=\"building-title\">\r\n                    " . lang("architect_txt_23", true) . "\r\n                </div>\r\n            </div>\r\n            <div class=\"col-xs-5 col-md-3 text-center\">\r\n                <img src=\"" . __PATH_TEMPLATE_ASSETS__ . "images/bank.png\" />\r\n            </div>\r\n            <div class=\"col-xs-7 col-md-9\">\r\n                <ul>\r\n                    <li>" . lang("architect_txt_21", true) . "</li>\r\n                    <li>" . lang("architect_txt_19", true) . "</li>\r\n                </ul>\r\n            </div>\r\n        </div>\r\n        <div class=\"row\">\r\n            <div class=\"col-xs-12\">\r\n                <div class=\"table-responsive rankings-table\">\r\n                    <table class=\"table table-hover text-center\">\r\n                        <tbody>\r\n                            <tr>\r\n                                <th class=\"headerRow\">" . lang("architect_txt_42", true) . "</th>\r\n                                <th class=\"headerRow\">" . lang("architect_txt_43", true) . "</th>\r\n                                <th class=\"headerRow\">" . lang("architect_txt_36", true) . "</th>\r\n                            </tr>";
                            $myInvestments = $Architect->loadMyInvestments($_SESSION["username"], $char);
                            if (mconfig("bank_platinum")) {
                                echo "\r\n                            <tr>\r\n                                <td>" . lang("currency_platinum", true) . "</td>\r\n                                <td>" . number_format($myInvestments["platinum"]) . "</td>\r\n                                <td>" . $currLevelCfg["reward_platinum"] . "%</td>\r\n                            </tr>";
                            }
                            if (mconfig("bank_gold")) {
                                echo "\r\n                            <tr>\r\n                                <td>" . lang("currency_gold", true) . "</td>\r\n                                <td>" . number_format($myInvestments["gold"]) . "</td>\r\n                                <td>" . $currLevelCfg["reward_gold"] . "%</td>\r\n                            </tr>";
                            }
                            if (mconfig("bank_silver")) {
                                echo "\r\n                            <tr>\r\n                                <td>" . lang("currency_silver", true) . "</td>\r\n                                <td>" . number_format($myInvestments["silver"]) . "</td>\r\n                                <td>" . $currLevelCfg["reward_silver"] . "%</td>\r\n                            </tr>";
                            }
                            if (mconfig("bank_wcoin")) {
                                echo "\r\n                            <tr>\r\n                                <td>" . lang("currency_wcoinc", true) . "</td>\r\n                                <td>" . number_format($myInvestments["wcoin"]) . "</td>\r\n                                <td>" . $currLevelCfg["reward_wcoin"] . "%</td>\r\n                            </tr>";
                            }
                            if (mconfig("bank_gp")) {
                                echo "\r\n                            <tr>\r\n                                <td>" . lang("currency_gp", true) . "</td>\r\n                                <td>" . number_format($myInvestments["gp"]) . "</td>\r\n                                <td>" . $currLevelCfg["reward_gp"] . "%</td>\r\n                            </tr>";
                            }
                            if (mconfig("bank_zen")) {
                                echo "\r\n                            <tr>\r\n                                <td>" . lang("currency_zen", true) . "</td>\r\n                                <td>" . number_format($myInvestments["zen"]) . "</td>\r\n                                <td>" . $currLevelCfg["reward_zen"] . "%</td>\r\n                            </tr>";
                            }
                            echo "\r\n                        </tbody>\r\n                    </table>\r\n                </div>\r\n            </div>\r\n        </div>\r\n        <div class=\"row\">\r\n            <div class=\"col-xs-12\">\r\n                <div class=\"architect-section\">" . lang("architect_txt_44", true) . "</div>\r\n            </div>\r\n        </div>\r\n        <div class=\"row desc-row\">\r\n            <div class=\"col-xs-12\">" . lang("architect_txt_45", true) . "</div>\r\n        </div>\r\n        <div class=\"row\">\r\n            <div class=\"col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 col-center\">\r\n                <form action=\"\" method=\"post\">\r\n                    <div class=\"form-group\">\r\n                        <label>" . lang("architect_txt_46", true) . "</label>\r\n                        <select name=\"type\" class=\"form-control\">\r\n                            <option value=\"invest\">" . lang("architect_txt_50", true) . "</option>\r\n                            <option value=\"withdraw\">" . lang("architect_txt_51", true) . "</option>\r\n                        </select>\r\n                    </div>\r\n                    <div class=\"form-group\">\r\n                        <label>" . lang("architect_txt_47", true) . "</label>\r\n                        <select name=\"resource\" class=\"form-control\">";
                            if (mconfig("bank_platinum")) {
                                echo "<option value=\"platinum\">" . lang("currency_platinum", true) . "</option>";
                            }
                            if (mconfig("bank_gold")) {
                                echo "<option value=\"gold\">" . lang("currency_gold", true) . "</option>";
                            }
                            if (mconfig("bank_silver")) {
                                echo "<option value=\"silver\">" . lang("currency_silver", true) . "</option>";
                            }
                            if (mconfig("bank_wcoin")) {
                                echo "<option value=\"wcoin\">" . lang("currency_wcoinc", true) . "</option>";
                            }
                            if (mconfig("bank_gp")) {
                                echo "<option value=\"gp\">" . lang("currency_gp", true) . "</option>";
                            }
                            if (mconfig("bank_zen")) {
                                echo "<option value=\"zen\">" . lang("currency_zen", true) . "</option>";
                            }
                            echo "\r\n                        </select>\r\n                    </div>\r\n                    <div class=\"form-group\">\r\n                        <label>" . lang("architect_txt_48", true) . "</label>\r\n                        <input type=\"text\" name=\"amount\" class=\"form-control\">\r\n                    </div>\r\n                    <div class=\"form-group\">\r\n                        <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                        <input type=\"submit\" name=\"bank_invest\" value=\"" . lang("architect_txt_49", true) . "\" class=\"btn btn-warning full-width-btn\">\r\n                    </div>\r\n                </form>\r\n            </div>\r\n        </div>\r\n    </div>";
                        } else {
                            if (!empty($castleOwnerData["G_Name"])) {
                                $castleOwnerColumn = returnGuildLogo($castleOwnerData["G_Mark"], 16) . " <a href=\"" . __BASE_URL__ . "profile/guild/req/" . hex_encode($castleOwnerData["G_Name"]) . "/\">" . $common->replaceHtmlSymbols($castleOwnerData["G_Name"]) . "</a>";
                            } else {
                                $castleOwnerColumn = $castleOwnerData["G_Name"];
                            }
                            $castleLordFlag = "";
                            if ($config["flags"]) {
                                $castleLordFlag = "<img src=\"" . __PATH_TEMPLATE__ . "images/blank.png\" class=\"flag-icon flag-icon-" . $castleOwnerData["Country"] . "\" alt=\"" . $custom["countries"][$castleOwnerData["Country"]] . "\" title=\"" . $custom["countries"][$castleOwnerData["Country"]] . "\" />&nbsp;";
                            }
                            echo "\r\n    <div class=\"castleArchitect\">\r\n        <div class=\"row\">\r\n            <div class=\"col-xs-12\">\r\n                <div class=\"architect-section\">" . lang("architect_txt_3", true) . "</div>\r\n            </div>\r\n        </div>\r\n        <div class=\"row\">\r\n            <div class=\"col-xs-12\">\r\n                <ul class=\"castleArchitectInfo\">\r\n                    <li>" . lang("architect_txt_4", true) . "</li>\r\n                    <li>" . lang("architect_txt_5", true) . "</li>\r\n                </ul>\r\n            </div>\r\n            <div class=\"col-xs-12 col-md-6 col-md-offset-3\">\r\n                <div class=\"table-responsive rankings-table\">\r\n                    <table class=\"table table-hover text-center\">\r\n                        <tbody>\r\n                            <tr>\r\n                                <th class=\"headerRow\" width=\"50%\">" . lang("architect_txt_6", true) . "</th>\r\n                                <td width=\"50%\">" . $castleOwnerColumn . "</th>\r\n                            </tr>\r\n                            <tr>\r\n                                <th class=\"headerRow\">" . lang("architect_txt_16", true) . "</th>\r\n                                <td>" . $castleLordFlag . "<a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($castleOwnerData["G_Master"]) . "/\">" . $common->replaceHtmlSymbols($castleOwnerData["G_Master"]) . "</a></th>\r\n                            </tr>";
                            if (is_array($castleOwnerData["Alliance"])) {
                                $alliance = "";
                                foreach ($castleOwnerData["Alliance"] as $thisGuild) {
                                    if ($alliance == "") {
                                        $alliance = returnGuildLogo($thisGuild["G_Mark"], 16) . " <a href=\"" . __BASE_URL__ . "profile/guild/req/" . hex_encode($thisGuild["G_Name"]) . "/\">" . $common->replaceHtmlSymbols($thisGuild["G_Name"]) . "</a>";
                                    } else {
                                        $alliance .= ", " . returnGuildLogo($thisGuild["G_Mark"], 16) . " <a href=\"" . __BASE_URL__ . "profile/guild/req/" . hex_encode($thisGuild["G_Name"]) . "/\">" . $common->replaceHtmlSymbols($thisGuild["G_Name"]) . "</a>";
                                    }
                                }
                                echo "\r\n                            <tr>\r\n                                <th class=\"headerRow\">" . lang("architect_txt_14", true) . "</th>\r\n                                <td>" . $alliance . "</td>\r\n                            </tr>";
                            }
                            echo "\r\n                            <tr>\r\n                                <th class=\"headerRow\">" . lang("architect_txt_7", true) . "</th>\r\n                                <td>" . date($config["date_format"], strtotime($castleOwnerData["SIEGE_START_DATE"])) . "</td>\r\n                            </tr>\r\n                        </tbody>\r\n                    </table>\r\n                </div>\r\n            </div>\r\n        </div>\r\n        <div class=\"row\">\r\n            <div class=\"col-xs-12\">\r\n                <div class=\"architect-section\">" . lang("architect_txt_18", true) . "</div>\r\n            </div>\r\n        </div>";
                            $token = time();
                            $_SESSION["token"] = $token;
                            $addLineToBank = false;
                            if (mconfig("building_mine")) {
                                $addLineToBank = true;
                                echo "\r\n        <div class=\"row\">\r\n            <div class=\"col-xs-12\">\r\n                <div class=\"building-title\">\r\n                    " . lang("architect_txt_22", true) . "\r\n                </div>\r\n            </div>\r\n            <div class=\"col-xs-5 col-md-3 text-center\">\r\n                <img src=\"" . __PATH_TEMPLATE_ASSETS__ . "images/jewel-mine.png\" />\r\n            </div>\r\n            <div class=\"col-xs-7 col-md-9\">\r\n                <ul>\r\n                    <li>" . lang("architect_txt_20", true) . "</li>\r\n                    <li>" . lang("architect_txt_19", true) . "</li>\r\n                </ul>\r\n            </div>\r\n        </div>";
                                if ($isCastleOwner || $isFromAlliance) {
                                    $currLevelCfg = mconfig("mine_stage" . $buildingsData["Mine_Level"]);
                                    $nextLevel = $buildingsData["Mine_Level"] + 1;
                                    $nextLevelCfg = mconfig("mine_stage" . $nextLevel);
                                    if ($nextLevelCfg["active"]) {
                                        $thWidth = " style=\"width: 50%\"";
                                        $tdWidth = " style=\"width: 25%\"";
                                    } else {
                                        $thWidth = " style=\"width: 100%\"";
                                        $tdWidth = " style=\"width: 50%\"";
                                    }
                                    echo "\r\n        <div class=\"row\">\r\n            <div class=\"col-xs-12\">\r\n                <div class=\"table-responsive rankings-table\">\r\n                    <table class=\"table table-hover text-center\">\r\n                        <tbody>\r\n                            <tr>\r\n                                <th class=\"headerRow\" colspan=\"2\"" . $thWidth . ">" . lang("architect_txt_29", true) . "</th>";
                                    if ($nextLevelCfg["active"]) {
                                        echo "\r\n                                <th class=\"headerRow\" colspan=\"2\"" . $thWidth . ">" . sprintf(lang("architect_txt_30", true), $nextLevel) . "</th>";
                                    }
                                    echo "\r\n                            </tr>\r\n                            <tr>\r\n                                <td" . $tdWidth . ">" . lang("currency_bless", true) . "</td>\r\n                                <td" . $tdWidth . ">" . $currLevelCfg["reward_bless_min"] . " - " . $currLevelCfg["reward_bless_max"] . "</td>";
                                    if ($nextLevelCfg["active"]) {
                                        echo "\r\n                                <td" . $tdWidth . ">" . lang("currency_bless", true) . "</td>\r\n                                <td" . $tdWidth . ">" . $nextLevelCfg["reward_bless_min"] . " - " . $nextLevelCfg["reward_bless_max"] . "</td>";
                                    }
                                    echo "\r\n                            </tr>\r\n                            <tr>\r\n                                <td" . $tdWidth . ">" . lang("currency_soul", true) . "</td>\r\n                                <td" . $tdWidth . ">" . $currLevelCfg["reward_soul_min"] . " - " . $currLevelCfg["reward_soul_max"] . "</td>";
                                    if ($nextLevelCfg["active"]) {
                                        echo "\r\n                                <td" . $tdWidth . ">" . lang("currency_soul", true) . "</td>\r\n                                <td" . $tdWidth . ">" . $nextLevelCfg["reward_soul_min"] . " - " . $nextLevelCfg["reward_soul_max"] . "</td>";
                                    }
                                    echo "\r\n                            </tr>\r\n                            <tr>\r\n                                <td" . $tdWidth . ">" . lang("currency_life", true) . "</td>\r\n                                <td" . $tdWidth . ">" . $currLevelCfg["reward_life_min"] . " - " . $currLevelCfg["reward_life_max"] . "</td>";
                                    if ($nextLevelCfg["active"]) {
                                        echo "\r\n                                <td" . $tdWidth . ">" . lang("currency_life", true) . "</td>\r\n                                <td" . $tdWidth . ">" . $nextLevelCfg["reward_life_min"] . " - " . $nextLevelCfg["reward_life_max"] . "</td>";
                                    }
                                    echo "\r\n                            </tr>\r\n                            <tr>\r\n                                <td" . $tdWidth . ">" . lang("currency_chaos", true) . "</td>\r\n                                <td" . $tdWidth . ">" . $currLevelCfg["reward_chaos_min"] . " - " . $currLevelCfg["reward_chaos_max"] . "</td>";
                                    if ($nextLevelCfg["active"]) {
                                        echo "\r\n                                <td" . $tdWidth . ">" . lang("currency_chaos", true) . "</td>\r\n                                <td" . $tdWidth . ">" . $nextLevelCfg["reward_chaos_min"] . " - " . $nextLevelCfg["reward_chaos_max"] . "</td>";
                                    }
                                    echo "\r\n                            </tr>\r\n                            <tr>\r\n                                <td" . $tdWidth . ">" . lang("currency_harmony", true) . "</td>\r\n                                <td" . $tdWidth . ">" . $currLevelCfg["reward_harmony_min"] . " - " . $currLevelCfg["reward_harmony_max"] . "</td>";
                                    if ($nextLevelCfg["active"]) {
                                        echo "\r\n                                <td" . $tdWidth . ">" . lang("currency_harmony", true) . "</td>\r\n                                <td" . $tdWidth . ">" . $nextLevelCfg["reward_harmony_min"] . " - " . $nextLevelCfg["reward_harmony_max"] . "</td>";
                                    }
                                    echo "\r\n                            </tr>\r\n                            <tr>\r\n                                <td" . $tdWidth . ">" . lang("currency_creation", true) . "</td>\r\n                                <td" . $tdWidth . ">" . $currLevelCfg["reward_creation_min"] . " - " . $currLevelCfg["reward_creation_max"] . "</td>";
                                    if ($nextLevelCfg["active"]) {
                                        echo "\r\n                                <td" . $tdWidth . ">" . lang("currency_creation", true) . "</td>\r\n                                <td" . $tdWidth . ">" . $nextLevelCfg["reward_creation_min"] . " - " . $nextLevelCfg["reward_creation_max"] . "</td>";
                                    }
                                    echo "\r\n                            </tr>\r\n                            <tr>\r\n                                <td" . $tdWidth . ">" . lang("currency_guardian", true) . "</td>\r\n                                <td" . $tdWidth . ">" . $currLevelCfg["reward_guardian_min"] . " - " . $currLevelCfg["reward_guardian_max"] . "</td>";
                                    if ($nextLevelCfg["active"]) {
                                        echo "\r\n                                <td" . $tdWidth . ">" . lang("currency_guardian", true) . "</td>\r\n                                <td" . $tdWidth . ">" . $nextLevelCfg["reward_guardian_min"] . " - " . $nextLevelCfg["reward_guardian_max"] . "</td>";
                                    }
                                    echo "\r\n                            </tr>\r\n                        </tbody>\r\n                    </table>\r\n                </div>\r\n            </div>\r\n        </div>\r\n        <div class=\"row\">\r\n            <div class=\"col-xs-12\">\r\n                <div class=\"table-responsive rankings-table\">\r\n                    <table class=\"table table-hover text-center\">\r\n                        <tbody>\r\n                            <tr>\r\n                                <th class=\"headerRow\" colspan=\"7\">" . lang("architect_txt_40", true) . "</th>\r\n                            </tr>";
                                    $lastProduction = $Architect->loadMineLastProduction();
                                    if (is_array($lastProduction)) {
                                        echo "\r\n                            <tr>\r\n                                <th>" . lang("currency_bless", true) . "</th>\r\n                                <th>" . lang("currency_soul", true) . "</th>\r\n                                <th>" . lang("currency_life", true) . "</th>\r\n                                <th>" . lang("currency_chaos", true) . "</th>\r\n                                <th>" . lang("currency_harmony", true) . "</th>\r\n                                <th>" . lang("currency_creation", true) . "</th>\r\n                                <th>" . lang("currency_guardian", true) . "</th>\r\n                            </tr>\r\n                            <tr>\r\n                                <td>" . number_format($lastProduction["bless"]) . "</td>\r\n                                <td>" . number_format($lastProduction["soul"]) . "</td>\r\n                                <td>" . number_format($lastProduction["life"]) . "</td>\r\n                                <td>" . number_format($lastProduction["chaos"]) . "</td>\r\n                                <td>" . number_format($lastProduction["harmony"]) . "</td>\r\n                                <td>" . number_format($lastProduction["creation"]) . "</td>\r\n                                <td>" . number_format($lastProduction["guardian"]) . "</td>\r\n                            </tr>";
                                    } else {
                                        echo "\r\n                            <tr>\r\n                                <td colspan=\"7\">" . lang("architect_txt_41", true) . "</td>\r\n                            </tr>";
                                    }
                                    echo "\r\n                        </tbody>\r\n                    </table>\r\n                </div>\r\n            </div>\r\n        </div>";
                                    if ($nextLevelCfg["active"]) {
                                        echo "\r\n        <h4>" . lang("architect_txt_24", true) . "</h4>";
                                    } else {
                                        echo "\r\n        <div class=\"building-cannot-upgrade\">" . lang("architect_txt_26", true) . "</div>";
                                    }
                                    echo "\r\n        <div class=\"building-price\">";
                                    if ($nextLevelCfg["active"]) {
                                        if (0 < $nextLevelCfg["price_valor"]) {
                                            echo "\r\n            <div class=\"col-xs-6 col-sm-4 col-md-3 col-lg-2 building-price-box\">\r\n                " . lang("architect_txt_8", true) . ":<br>\r\n                <span class=\"building-price-val\">" . number_format($nextLevelCfg["price_valor"]) . "</span>\r\n            </div>";
                                        }
                                        if (0 < $nextLevelCfg["price_sol"]) {
                                            echo "\r\n            <div class=\"col-xs-6 col-sm-4 col-md-3 col-lg-2 building-price-box\">\r\n                " . lang("architect_txt_17", true) . ":<br>\r\n                <span class=\"building-price-val\">" . number_format($nextLevelCfg["price_sol"]) . "</span>\r\n            </div>";
                                        }
                                        if (0 < $nextLevelCfg["price_zen"]) {
                                            echo "\r\n            <div class=\"col-xs-6 col-sm-4 col-md-3 col-lg-2 building-price-box\">\r\n                " . lang("currency_zen", true) . ":<br>\r\n                <span class=\"building-price-val\">" . number_format($nextLevelCfg["price_zen"]) . "</span>\r\n            </div>";
                                        }
                                        if (0 < $nextLevelCfg["price_bless"]) {
                                            echo "\r\n            <div class=\"col-xs-6 col-sm-4 col-md-3 col-lg-2 building-price-box\">\r\n                " . lang("currency_bless", true) . ":<br>\r\n                <span class=\"building-price-val\">" . number_format($nextLevelCfg["price_bless"]) . "</span>\r\n            </div>";
                                        }
                                        if (0 < $nextLevelCfg["price_soul"]) {
                                            echo "\r\n            <div class=\"col-xs-6 col-sm-4 col-md-3 col-lg-2 building-price-box\">\r\n                " . lang("currency_soul", true) . ":<br>\r\n                <span class=\"building-price-val\">" . number_format($nextLevelCfg["price_soul"]) . "</span>\r\n            </div>";
                                        }
                                        if (0 < $nextLevelCfg["price_life"]) {
                                            echo "\r\n            <div class=\"col-xs-6 col-sm-4 col-md-3 col-lg-2 building-price-box\">\r\n                " . lang("currency_life", true) . ":<br>\r\n                <span class=\"building-price-val\">" . number_format($nextLevelCfg["price_life"]) . "</span>\r\n            </div>";
                                        }
                                        if (0 < $nextLevelCfg["price_chaos"]) {
                                            echo "\r\n            <div class=\"col-xs-6 col-sm-4 col-md-3 col-lg-2 building-price-box\">\r\n                " . lang("currency_chaos", true) . ":<br>\r\n                <span class=\"building-price-val\">" . number_format($nextLevelCfg["price_chaos"]) . "</span>\r\n            </div>";
                                        }
                                        if (0 < $nextLevelCfg["price_harmony"]) {
                                            echo "\r\n            <div class=\"col-xs-6 col-sm-4 col-md-3 col-lg-2 building-price-box\">\r\n                " . lang("currency_harmony", true) . ":<br>\r\n                <span class=\"building-price-val\">" . number_format($nextLevelCfg["price_harmony"]) . "</span>\r\n            </div>";
                                        }
                                        if (0 < $nextLevelCfg["price_creation"]) {
                                            echo "\r\n            <div class=\"col-xs-6 col-sm-4 col-md-3 col-lg-2 building-price-box\">\r\n                " . lang("currency_creation", true) . ":<br>\r\n                <span class=\"building-price-val\">" . number_format($nextLevelCfg["price_creation"]) . "</span>\r\n            </div>";
                                        }
                                        if (0 < $nextLevelCfg["price_guardian"]) {
                                            echo "\r\n            <div class=\"col-xs-6 col-sm-4 col-md-3 col-lg-2 building-price-box\">\r\n                " . lang("currency_guardian", true) . ":<br>\r\n                <span class=\"building-price-val\">" . number_format($nextLevelCfg["price_guardian"]) . "</span>\r\n            </div>";
                                        }
                                    }
                                    if ($canBuild && $nextLevelCfg["active"]) {
                                        if ($nextLevel == 1) {
                                            $btnText = lang("architect_txt_27", true);
                                        } else {
                                            $btnText = sprintf(lang("architect_txt_28", true), $nextLevel);
                                        }
                                        echo "\r\n            <div class=\"col-xs-12 col-sm-4 col-md-3 col-lg-2 building-button\">\r\n                <form method=\"post\" action=\"" . __BASE_URL__ . "usercp/architect/char/" . hex_encode($char) . "/\">\r\n                    <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                    <input type=\"hidden\" name=\"type\" value=\"mine\">\r\n                    <input type=\"submit\" name=\"upgrade\" value=\"" . $btnText . "\" class=\"btn btn-primary full-width-btn\" />\r\n                </form>\r\n            </div>";
                                    }
                                    echo "\r\n        </div>";
                                }
                            }
                            if (mconfig("building_bank")) {
                                echo "\r\n        <div class=\"row\">\r\n            <div class=\"col-xs-12\">";
                                if ($addLineToBank) {
                                    echo "<hr>";
                                }
                                echo "\r\n                <div class=\"building-title\">\r\n                    " . lang("architect_txt_23", true) . "\r\n                </div>\r\n            </div>\r\n            <div class=\"col-xs-5 col-md-3 text-center\">\r\n                <img src=\"" . __PATH_TEMPLATE_ASSETS__ . "images/bank.png\" />\r\n            </div>\r\n            <div class=\"col-xs-7 col-md-9\">\r\n                <ul>\r\n                    <li>" . lang("architect_txt_21", true) . "</li>\r\n                    <li>" . lang("architect_txt_19", true) . "</li>\r\n                </ul>\r\n            </div>\r\n        </div>";
                                if ($isCastleOwner || $isFromAlliance) {
                                    $currLevelCfg = mconfig("bank_stage" . $buildingsData["Bank_Level"]);
                                    $nextLevel = $buildingsData["Bank_Level"] + 1;
                                    $nextLevelCfg = mconfig("bank_stage" . $nextLevel);
                                    if ($nextLevelCfg["active"]) {
                                        $thWidth = " style=\"width: 50%\"";
                                        $tdWidth = " style=\"width: 25%\"";
                                    } else {
                                        $thWidth = " style=\"width: 100%\"";
                                        $tdWidth = " style=\"width: 50%\"";
                                    }
                                    if ($currLevelCfg["active"]) {
                                        $bankPerc = "%";
                                    } else {
                                        $bankPerc = "-";
                                    }
                                    echo "\r\n        <div class=\"row\">\r\n            <div class=\"col-xs-12\">\r\n                <div class=\"table-responsive rankings-table\">\r\n                    <table class=\"table table-hover text-center\">\r\n                        <tbody>\r\n                            <tr>\r\n                                <th class=\"headerRow\" colspan=\"2\"" . $thWidth . ">" . lang("architect_txt_36", true) . "</th>";
                                    if ($nextLevelCfg["active"]) {
                                        echo "\r\n                                <th class=\"headerRow\" colspan=\"2\"" . $thWidth . ">" . sprintf(lang("architect_txt_37", true), $nextLevel) . "</th>";
                                    }
                                    echo "                                                    \r\n                            </tr>";
                                    if (mconfig("bank_platinum")) {
                                        echo "\r\n                            <tr>\r\n                                <td" . $tdWidth . ">" . lang("currency_platinum", true) . "</td>\r\n                                <td" . $tdWidth . ">" . $currLevelCfg["reward_platinum"] . $bankPerc . "</td>";
                                        if ($nextLevelCfg["active"]) {
                                            echo "\r\n                                <td" . $tdWidth . ">" . lang("currency_platinum", true) . "</td>\r\n                                <td" . $tdWidth . ">" . $nextLevelCfg["reward_platinum"] . "%</td>";
                                        }
                                        echo "\r\n                            </tr>";
                                    }
                                    if (mconfig("bank_gold")) {
                                        echo "\r\n                            <tr>\r\n                                <td" . $tdWidth . ">" . lang("currency_gold", true) . "</td>\r\n                                <td" . $tdWidth . ">" . $currLevelCfg["reward_gold"] . $bankPerc . "</td>";
                                        if ($nextLevelCfg["active"]) {
                                            echo "\r\n                                <td" . $tdWidth . ">" . lang("currency_gold", true) . "</td>\r\n                                <td" . $tdWidth . ">" . $nextLevelCfg["reward_gold"] . "%</td>";
                                        }
                                        echo "\r\n                            </tr>";
                                    }
                                    if (mconfig("bank_silver")) {
                                        echo "\r\n                            <tr>\r\n                                <td" . $tdWidth . ">" . lang("currency_silver", true) . "</td>\r\n                                <td" . $tdWidth . ">" . $currLevelCfg["reward_silver"] . $bankPerc . "</td>";
                                        if ($nextLevelCfg["active"]) {
                                            echo "\r\n                                <td" . $tdWidth . ">" . lang("currency_silver", true) . "</td>\r\n                                <td" . $tdWidth . ">" . $nextLevelCfg["reward_silver"] . "%</td>";
                                        }
                                        echo "\r\n                            </tr>";
                                    }
                                    if (mconfig("bank_wcoin")) {
                                        echo "\r\n                            <tr>\r\n                                <td" . $tdWidth . ">" . lang("currency_wcoinc", true) . "</td>\r\n                                <td" . $tdWidth . ">" . $currLevelCfg["reward_wcoin"] . $bankPerc . "</td>";
                                        if ($nextLevelCfg["active"]) {
                                            echo "\r\n                                <td" . $tdWidth . ">" . lang("currency_wcoinc", true) . "</td>\r\n                                <td" . $tdWidth . ">" . $nextLevelCfg["reward_wcoin"] . "%</td>";
                                        }
                                        echo "\r\n                            </tr>";
                                    }
                                    if (mconfig("bank_gp")) {
                                        echo "\r\n                            <tr>\r\n                                <td" . $tdWidth . ">" . lang("currency_gp", true) . "</td>\r\n                                <td" . $tdWidth . ">" . $currLevelCfg["reward_gp"] . $bankPerc . "</td>";
                                        if ($nextLevelCfg["active"]) {
                                            echo "\r\n                                <td" . $tdWidth . ">" . lang("currency_gp", true) . "</td>\r\n                                <td" . $tdWidth . ">" . $nextLevelCfg["reward_gp"] . "%</td>";
                                        }
                                        echo "\r\n                            </tr>";
                                    }
                                    if (mconfig("bank_zen")) {
                                        echo "\r\n                            <tr>\r\n                                <td" . $tdWidth . ">" . lang("currency_zen", true) . "</td>\r\n                                <td" . $tdWidth . ">" . $currLevelCfg["reward_zen"] . $bankPerc . "</td>";
                                        if ($nextLevelCfg["active"]) {
                                            echo "\r\n                                <td" . $tdWidth . ">" . lang("currency_zen", true) . "</td>\r\n                                <td" . $tdWidth . ">" . $nextLevelCfg["reward_zen"] . "%</td>";
                                        }
                                        echo "\r\n                            </tr>";
                                    }
                                    echo "\r\n                        </tbody>\r\n                    </table>\r\n                </div>\r\n            </div>\r\n        </div>";
                                    if ($nextLevelCfg["active"]) {
                                        echo "\r\n        <h4>" . lang("architect_txt_24", true) . "</h4>";
                                    } else {
                                        echo "<div class=\"building-cannot-upgrade\">" . lang("architect_txt_26", true) . "</div>";
                                    }
                                    echo "\r\n        <div class=\"building-price\">";
                                    if ($nextLevelCfg["active"]) {
                                        if (0 < $nextLevelCfg["price_valor"]) {
                                            echo "\r\n            <div class=\"col-xs-6 col-sm-4 col-md-3 col-lg-2 building-price-box\">\r\n                " . lang("architect_txt_8", true) . ":<br>\r\n                <span class=\"building-price-val\">" . number_format($nextLevelCfg["price_valor"]) . "</span>\r\n            </div>";
                                        }
                                        if (0 < $nextLevelCfg["price_sol"]) {
                                            echo "\r\n            <div class=\"col-xs-6 col-sm-4 col-md-3 col-lg-2 building-price-box\">\r\n                " . lang("architect_txt_17", true) . ":<br>\r\n                <span class=\"building-price-val\">" . number_format($nextLevelCfg["price_sol"]) . "</span>\r\n            </div>";
                                        }
                                        if (0 < $nextLevelCfg["price_zen"]) {
                                            echo "\r\n            <div class=\"col-xs-6 col-sm-4 col-md-3 col-lg-2 building-price-box\">\r\n                " . lang("currency_zen", true) . ":<br>\r\n                <span class=\"building-price-val\">" . number_format($nextLevelCfg["price_zen"]) . "</span>\r\n            </div>";
                                        }
                                        if (0 < $nextLevelCfg["price_bless"]) {
                                            echo "\r\n            <div class=\"col-xs-6 col-sm-4 col-md-3 col-lg-2 building-price-box\">\r\n                " . lang("currency_bless", true) . ":<br>\r\n                <span class=\"building-price-val\">" . number_format($nextLevelCfg["price_bless"]) . "</span>\r\n            </div>";
                                        }
                                        if (0 < $nextLevelCfg["price_soul"]) {
                                            echo "\r\n            <div class=\"col-xs-6 col-sm-4 col-md-3 col-lg-2 building-price-box\">\r\n                " . lang("currency_soul", true) . ":<br>\r\n                <span class=\"building-price-val\">" . number_format($nextLevelCfg["price_soul"]) . "</span>\r\n            </div>";
                                        }
                                        if (0 < $nextLevelCfg["price_life"]) {
                                            echo "\r\n            <div class=\"col-xs-6 col-sm-4 col-md-3 col-lg-2 building-price-box\">\r\n                " . lang("currency_life", true) . ":<br>\r\n                <span class=\"building-price-val\">" . number_format($nextLevelCfg["price_life"]) . "</span>\r\n            </div>";
                                        }
                                        if (0 < $nextLevelCfg["price_chaos"]) {
                                            echo "\r\n            <div class=\"col-xs-6 col-sm-4 col-md-3 col-lg-2 building-price-box\">\r\n                " . lang("currency_chaos", true) . ":<br>\r\n                <span class=\"building-price-val\">" . number_format($nextLevelCfg["price_chaos"]) . "</span>\r\n            </div>";
                                        }
                                        if (0 < $nextLevelCfg["price_harmony"]) {
                                            echo "\r\n            <div class=\"col-xs-6 col-sm-4 col-md-3 col-lg-2 building-price-box\">\r\n                " . lang("currency_harmony", true) . ":<br>\r\n                <span class=\"building-price-val\">" . number_format($nextLevelCfg["price_harmony"]) . "</span>\r\n            </div>";
                                        }
                                        if (0 < $nextLevelCfg["price_creation"]) {
                                            echo "\r\n            <div class=\"col-xs-6 col-sm-4 col-md-3 col-lg-2 building-price-box\">\r\n                " . lang("currency_creation", true) . ":<br>\r\n                <span class=\"building-price-val\">" . number_format($nextLevelCfg["price_creation"]) . "</span>\r\n            </div>";
                                        }
                                        if (0 < $nextLevelCfg["price_guardian"]) {
                                            echo "\r\n            <div class=\"col-xs-6 col-sm-4 col-md-3 col-lg-2 building-price-box\">\r\n                " . lang("currency_guardian", true) . ":<br>\r\n                <span class=\"building-price-val\">" . number_format($nextLevelCfg["price_guardian"]) . "</span>\r\n            </div>";
                                        }
                                    }
                                    if ($canBuild && $nextLevelCfg["active"]) {
                                        if ($nextLevel == 1) {
                                            $btnText = lang("architect_txt_27", true);
                                        } else {
                                            $btnText = sprintf(lang("architect_txt_28", true), $nextLevel);
                                        }
                                        echo "\r\n            <div class=\"col-xs-12 col-sm-4 col-md-3 col-lg-2 building-button\">\r\n                <form method=\"post\" action=\"" . __BASE_URL__ . "usercp/architect/char/" . hex_encode($char) . "/\">\r\n                    <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                    <input type=\"hidden\" name=\"type\" value=\"bank\">\r\n                    <input type=\"submit\" name=\"upgrade\" value=\"" . $btnText . "\" class=\"btn btn-primary full-width-btn\" />\r\n                </form>\r\n            </div>";
                                    }
                                    if (($isCastleOwner || $isFromAlliance) && 0 < $buildingsData["Bank_Level"]) {
                                        echo "\r\n            <div class=\"col-xs-12 col-sm-4 col-md-3 col-lg-2 building-button\">\r\n                <form method=\"get\" action=\"" . __BASE_URL__ . "usercp/architect/char/" . hex_encode($char) . "/building/bank/\">\r\n                    <input type=\"submit\" value=\"" . lang("architect_txt_38", true) . "\" class=\"btn btn-success full-width-btn\" />\r\n                </form>\r\n            </div>";
                                    }
                                    echo "                                            \r\n        </div>";
                                }
                            }
                            echo "\r\n    </div>";
                        }
                    } else {
                        message("error", lang("architect_txt_15", true));
                    }
                }
            } else {
                $chars = $dB->query_fetch("SELECT Name,cLevel,mLevel,RESETS,Grand_Resets,Class FROM Character WHERE AccountID = ? ORDER BY Grand_Resets desc,RESETS desc,mLevel desc,cLevel desc,Name asc", [$_SESSION["username"]]);
                echo "\r\n            <div class=\"table-responsive rankings-table\">\r\n                <table class=\"table table-hover text-center\">\r\n                    <tbody>\r\n                        <tr>\r\n                            <th class=\"headerRow\" colspan=\"8\">" . lang("global_module_2", true) . "</th>\r\n                        </tr>\r\n                        <tr>\r\n                            <th class=\"headerRow\">" . lang("global_module_3", true) . "</th>\r\n                            <th class=\"headerRow\">" . lang("global_module_4", true) . "</th>\r\n                            <th class=\"headerRow\">" . lang("profiles_txt_20", true) . "</th>\r\n                            <th class=\"headerRow\">" . lang("global_module_5", true) . "</th>\r\n                            <th class=\"headerRow\">" . lang("global_module_6", true) . "</th>";
                if ($config["use_resets"]) {
                    echo "<th class=\"headerRow\">" . lang("global_module_7", true) . "</th>";
                }
                if ($config["use_grand_resets"]) {
                    echo "<th class=\"headerRow\">" . lang("global_module_8", true) . "</th>";
                }
                echo "\r\n                            <th class=\"headerRow\">" . lang("global_module_9", true) . "</th>\r\n                        </tr>";
                foreach ($chars as $char) {
                    $guild = $dB->query_fetch_single("SELECT G_Name FROM GuildMember WHERE Name = ?", [$char["Name"]]);
                    $guildName = NULL;
                    if ($guild["G_Name"] != NULL) {
                        $guildName = "<a href=\"" . __BASE_URL__ . "profile/guild/req/" . hex_encode($guild["G_Name"]) . "/\">" . $common->replaceHtmlSymbols($guild["G_Name"]) . "</a>";
                    }
                    if ($guildName != NULL) {
                        $link = "<a href=\"" . __BASE_URL__ . "usercp/architect/char/" . hex_encode($char["Name"]) . "/\">" . lang("architect_txt_10", true) . "</a>";
                    } else {
                        $link = lang("architect_txt_11", true);
                    }
                    echo "\r\n                    <tr>\r\n                        <td><b><a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($char["Name"]) . "/\">" . $common->replaceHtmlSymbols($char["Name"]) . "</a></b></td>\r\n                        <td>" . $custom["character_class"][$char["Class"]][0] . "</td>\r\n                        <td>" . $guildName . "</td>\r\n                        <td>" . $char["cLevel"] . "</td>\r\n                        <td>" . $char["mLevel"] . "</td>";
                    if ($config["use_resets"]) {
                        echo "<td>" . $char["RESETS"] . "</td>";
                    }
                    if ($config["use_grand_resets"]) {
                        echo "<td>" . $char["Grand_Resets"] . "</td>";
                    } else {
                        echo "</td>";
                    }
                    echo "\r\n                        <td>" . $link . "</td>\r\n                    </tr>\r\n                    ";
                }
                echo "\r\n                    </tbody>\r\n                </table>\r\n            </div>";
            }
        } else {
            message("error", lang("error_47", true));
        }
    } else {
        echo "\r\n<div class=\"sub-page-title\">\r\n    <div id=\"title\">\r\n        <h1>" . lang("module_titles_txt_3", true) . "<p></p><span></span></h1>\r\n    </div>\r\n</div>";
        echo "\r\n<div class=\"container_2 account\" align=\"center\">\r\n    <div class=\"cont-image\">\r\n        <div class=\"container_3 account_sub_header\">\r\n            <div class=\"grad\">\r\n                <div class=\"page-title\"><p>" . lang("architect_txt_1", true) . "</p></div>";
        if (check_value($_GET["char"])) {
            echo "<a href=\"" . __BASE_URL__ . "usercp/webbankguild/char/" . $_GET["char"] . "/\" style=\"background-image: none;padding: 9px 12px 10px 10px\">" . lang("webbankguild_txt_1", true) . "</a>";
        }
        if (check_value($_GET["char"])) {
            $_GET["building"] = "bank";
            if (check_value($_GET["building"]) && $_GET["building"]) {
                echo "<a href=\"" . __BASE_URL__ . "usercp/architect/char/" . $_GET["char"] . "\">" . lang("architect_txt_35", true) . "</a>";
            } else {
                echo "<a href=\"" . __BASE_URL__ . "usercp/architect/\">" . lang("architect_txt_34", true) . "</a>";
            }
        } else {
            echo "<a href=\"" . __BASE_URL__ . "usercp\">" . lang("global_module_1", true) . "</a>";
        }
        echo "                \r\n            </div>\r\n        </div>\r\n        <div class=\"page-desc-holder\">" . lang("architect_txt_2", true) . "</div>";
        if (mconfig("active")) {
            $General = new xGeneral();
            $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("architect");
            $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("architect");
            if (check_value($_GET["char"])) {
                $char = hex_decode($_GET["char"]);
                $char = xss_clean($char);
                $Character = new Character();
                if ($Character->CharacterExists($char) && $Character->CharacterBelongsToAccount($char, $_SESSION["username"])) {
                    $Architect = new Architect();
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
                            $buildingsData = $Architect->loadBuildingsData($castleOwnerData["G_Name"]);
                        }
                        if ($canBuild && check_value($_POST["upgrade"]) && ($_POST["type"] == "mine" || $_POST["type"] == "bank")) {
                            if ($_SESSION["token"] == $_POST["token"]) {
                                $Architect->upgradeBuilding($char, $_POST["type"]);
                                $buildingsData = $Architect->loadBuildingsData($castleOwnerData["G_Name"]);
                            } else {
                                message("notice", lang("global_module_13", true));
                            }
                        }
                        if (check_value($_GET["building"]) && $_GET["building"] == "bank" && mconfig("building_bank") && 0 < $buildingsData["Bank_Level"]) {
                            if (check_value($_POST["bank_invest"])) {
                                if ($_SESSION["token"] == $_POST["token"]) {
                                    $Architect->manageInvestments($_POST["type"], $_SESSION["username"], $char, $_POST["amount"], $_POST["resource"]);
                                } else {
                                    message("notice", lang("global_module_13", true));
                                }
                            }
                            $token = time();
                            $_SESSION["token"] = $token;
                            echo "\r\n                    <div class=\"container_3 account-wide\" align=\"center\">\r\n                        <div id=\"castleArchitect\" class=\"castleArchitect\">";
                            $currLevelCfg = mconfig("bank_stage" . $buildingsData["Bank_Level"]);
                            echo "\r\n                            <div class=\"building\">\r\n                                <div class=\"building-top\">\r\n                                    <div class=\"building-title\">\r\n                                        " . lang("architect_txt_23", true) . "\r\n                                    </div>\r\n                                </div>\r\n                                <div class=\"building-middle\">\r\n                                    <div class=\"building-image\">\r\n                                        <img src=\"" . __PATH_TEMPLATE__ . "style/images/bank.png\" />\r\n                                    </div>\r\n                                    <div class=\"building-desc\">\r\n                                        <ul>\r\n                                            <li>" . lang("architect_txt_21", true) . "</li>\r\n                                            <li>" . lang("architect_txt_19", true) . "</li>\r\n                                        </ul>\r\n                                    </div>\r\n                                </div>\r\n                                <div class=\"building-bottom\">\r\n                                    <table class=\"general-table-ui castleArchitectMyInvestments\" cellspacing=\"0\">\r\n                                        <tr>\r\n                                            <th>" . lang("architect_txt_42", true) . "</th>\r\n                                            <th>" . lang("architect_txt_43", true) . "</th>\r\n                                            <th>" . lang("architect_txt_36", true) . "</th>\r\n                                        </tr>";
                            $myInvestments = $Architect->loadMyInvestments($_SESSION["username"], $char);
                            if (mconfig("bank_platinum")) {
                                echo "\r\n                                        <tr>\r\n                                            <td>" . lang("currency_platinum", true) . "</td>\r\n                                            <td>" . number_format($myInvestments["platinum"]) . "</td>\r\n                                            <td>" . $currLevelCfg["reward_platinum"] . "%</td>\r\n                                        </tr>";
                            }
                            if (mconfig("bank_gold")) {
                                echo "\r\n                                        <tr>\r\n                                            <td>" . lang("currency_gold", true) . "</td>\r\n                                            <td>" . number_format($myInvestments["gold"]) . "</td>\r\n                                            <td>" . $currLevelCfg["reward_gold"] . "%</td>\r\n                                        </tr>";
                            }
                            if (mconfig("bank_silver")) {
                                echo "\r\n                                        <tr>\r\n                                            <td>" . lang("currency_silver", true) . "</td>\r\n                                            <td>" . number_format($myInvestments["silver"]) . "</td>\r\n                                            <td>" . $currLevelCfg["reward_silver"] . "%</td>\r\n                                        </tr>";
                            }
                            if (mconfig("bank_wcoin")) {
                                echo "\r\n                                        <tr>\r\n                                            <td>" . lang("currency_wcoinc", true) . "</td>\r\n                                            <td>" . number_format($myInvestments["wcoin"]) . "</td>\r\n                                            <td>" . $currLevelCfg["reward_wcoin"] . "%</td>\r\n                                        </tr>";
                            }
                            if (mconfig("bank_gp")) {
                                echo "\r\n                                        <tr>\r\n                                            <td>" . lang("currency_gp", true) . "</td>\r\n                                            <td>" . number_format($myInvestments["gp"]) . "</td>\r\n                                            <td>" . $currLevelCfg["reward_gp"] . "%</td>\r\n                                        </tr>";
                            }
                            if (mconfig("bank_zen")) {
                                echo "\r\n                                        <tr>\r\n                                            <td>" . lang("currency_zen", true) . "</td>\r\n                                            <td>" . number_format($myInvestments["zen"]) . "</td>\r\n                                            <td>" . $currLevelCfg["reward_zen"] . "%</td>\r\n                                        </tr>";
                            }
                            echo "\r\n                                    </table>\r\n                                    \r\n                                    <div class=\"container_3 account_sub_header\">\r\n                                        <div class=\"grad\">\r\n                                            <div class=\"page-title\">" . lang("architect_txt_44", true) . "</div>\r\n                                        </div>\r\n                                    </div>\r\n                                    <div class=\"page-desc-holder\">\r\n                                        " . lang("architect_txt_45", true) . "\r\n                                    </div>\r\n                                    <div class=\"container_3 account-wide\" align=\"center\">\r\n                                        <form action=\"\" method=\"post\">\r\n                                            <div style=\"padding: 20px 0 14px 0;\">\r\n                                                <div class=\"row\">\r\n                                                    <label for=\"type\">" . lang("architect_txt_46", true) . "</label>\r\n                                                    <select name=\"type\" styled=\"true\" id=\"select-style-2\" style=\"display: none;\">\r\n                                                        <option value=\"invest\">" . lang("architect_txt_50", true) . "</option>\r\n                                                        <option value=\"withdraw\">" . lang("architect_txt_51", true) . "</option>\r\n                                                    </select>\r\n                                                </div>\r\n                                                <div class=\"row\">\r\n                                                    <label for=\"resource\">" . lang("architect_txt_47", true) . ":</label>\r\n                                                    <select name=\"resource\" styled=\"true\" id=\"select-style-2\" style=\"display: none;\">";
                            if (mconfig("bank_platinum")) {
                                echo "<option value=\"platinum\">" . lang("currency_platinum", true) . "</option>";
                            }
                            if (mconfig("bank_gold")) {
                                echo "<option value=\"gold\">" . lang("currency_gold", true) . "</option>";
                            }
                            if (mconfig("bank_silver")) {
                                echo "<option value=\"silver\">" . lang("currency_silver", true) . "</option>";
                            }
                            if (mconfig("bank_wcoin")) {
                                echo "<option value=\"wcoin\">" . lang("currency_wcoinc", true) . "</option>";
                            }
                            if (mconfig("bank_gp")) {
                                echo "<option value=\"gp\">" . lang("currency_gp", true) . "</option>";
                            }
                            if (mconfig("bank_zen")) {
                                echo "<option value=\"zen\">" . lang("currency_zen", true) . "</option>";
                            }
                            echo "\r\n                                                    </select>\r\n                                                </div>\r\n                                                <div class=\"row\">\r\n                                                    <label for=\"amount\">" . lang("architect_txt_48", true) . ":</label>\r\n                                                    <input type=\"text\" name=\"amount\">\r\n                                                </div>\r\n                                                <div class=\"row\" align=\"right\">\r\n                                                    <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                                                    <input type=\"submit\" name=\"bank_invest\" value=\"" . lang("architect_txt_49", true) . "\">\r\n                                                </div>\r\n                                            </div>\r\n                                        </form>\r\n                                    </div>\r\n                                    \r\n                                </div>\r\n                            </div>";
                            echo "\r\n                        </div>\r\n                    </div>";
                        } else {
                            if (!empty($castleOwnerData["G_Name"])) {
                                $castleOwnerColumn = returnGuildLogo($castleOwnerData["G_Mark"], 16) . " <a href=\"" . __BASE_URL__ . "profile/guild/req/" . hex_encode($castleOwnerData["G_Name"]) . "/\">" . $common->replaceHtmlSymbols($castleOwnerData["G_Name"]) . "</a>";
                            } else {
                                $castleOwnerColumn = $castleOwnerData["G_Name"];
                            }
                            $castleLordFlag = "";
                            if ($config["flags"]) {
                                $castleLordFlag = "<img src=\"" . __PATH_TEMPLATE__ . "style/images/blank.png\" class=\"flag-icon flag-icon-" . $castleOwnerData["Country"] . "\" alt=\"" . $custom["countries"][$castleOwnerData["Country"]] . "\" title=\"" . $custom["countries"][$castleOwnerData["Country"]] . "\" />&nbsp;";
                            }
                            echo "\r\n                    <div class=\"container_3 account-wide\" align=\"center\">\r\n                        <div id=\"castleArchitect\" class=\"castleArchitect\">\r\n                            <h3>" . lang("architect_txt_3", true) . "</h3>\r\n                            <ul class=\"castleArchitectInfo\">\r\n                                <li>" . lang("architect_txt_4", true) . "</li>\r\n                                <li>" . lang("architect_txt_5", true) . "</li>\r\n                            </ul>";
                            echo "\r\n                            <table class=\"general-table-ui castleArchitectOwner\" cellspacing=\"0\">\r\n                                <tr>\r\n                                    <th>" . lang("architect_txt_6", true) . "</th>\r\n                                    <td>" . $castleOwnerColumn . "</td>\r\n                                </tr>\r\n                                <tr>\r\n                                    <th>" . lang("architect_txt_16", true) . "</th>\r\n                                    <td>" . $castleLordFlag . "<a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($castleOwnerData["G_Master"]) . "/\">" . $common->replaceHtmlSymbols($castleOwnerData["G_Master"]) . "</a></td>\r\n                                </tr>";
                            if (is_array($castleOwnerData["Alliance"])) {
                                $alliance = "";
                                foreach ($castleOwnerData["Alliance"] as $thisGuild) {
                                    if ($alliance == "") {
                                        $alliance = returnGuildLogo($thisGuild["G_Mark"], 16) . " <a href=\"" . __BASE_URL__ . "profile/guild/req/" . hex_encode($thisGuild["G_Name"]) . "/\">" . $common->replaceHtmlSymbols($thisGuild["G_Name"]) . "</a>";
                                    } else {
                                        $alliance .= ", " . returnGuildLogo($thisGuild["G_Mark"], 16) . " <a href=\"" . __BASE_URL__ . "profile/guild/req/" . hex_encode($thisGuild["G_Name"]) . "/\">" . $common->replaceHtmlSymbols($thisGuild["G_Name"]) . "</a>";
                                    }
                                }
                                echo "\r\n                                <tr>\r\n                                    <th>" . lang("architect_txt_14", true) . "</th>\r\n                                    <td>" . $alliance . "</td>\r\n                                </tr>";
                            }
                            echo "\r\n                                <tr>\r\n                                    <th>" . lang("architect_txt_7", true) . "</th>\r\n                                    <td>" . date($config["date_format"], strtotime($castleOwnerData["SIEGE_START_DATE"])) . "</td>\r\n                                </tr>\r\n                            </table>";
                            echo "\r\n                            <h4>" . lang("architect_txt_18", true) . "</h4>";
                            $token = time();
                            $_SESSION["token"] = $token;
                            if (mconfig("building_mine")) {
                                echo "\r\n                            <div class=\"building\">\r\n                                <div class=\"building-top\">\r\n                                    <div class=\"building-title\">\r\n                                        " . lang("architect_txt_22", true) . "\r\n                                    </div>\r\n                                </div>\r\n                                <div class=\"building-middle\">\r\n                                    <div class=\"building-image\">\r\n                                        <img src=\"" . __PATH_TEMPLATE__ . "style/images/jewel-mine.png\" />\r\n                                    </div>\r\n                                    <div class=\"building-desc\">\r\n                                        <ul>\r\n                                            <li>" . lang("architect_txt_20", true) . "</li>\r\n                                            <li>" . lang("architect_txt_19", true) . "</li>\r\n                                        </ul>\r\n                                    </div>";
                                if ($isCastleOwner || $isFromAlliance) {
                                    $currLevelCfg = mconfig("mine_stage" . $buildingsData["Mine_Level"]);
                                    $nextLevel = $buildingsData["Mine_Level"] + 1;
                                    $nextLevelCfg = mconfig("mine_stage" . $nextLevel);
                                    if ($nextLevelCfg["active"]) {
                                        $thWidth = " style=\"width: 50%\"";
                                        $tdWidth = " style=\"width: 25%\"";
                                    } else {
                                        $thWidth = " style=\"width: 100%\"";
                                        $tdWidth = " style=\"width: 50%\"";
                                    }
                                    echo "\r\n                                    <div class=\"building-bottom\">\r\n                                        <div>\r\n                                            <table class=\"general-table-ui castleArchitectProduction\" cellspacing=\"0\">\r\n                                                <tr>\r\n                                                    <th colspan=\"2\"" . $thWidth . ">" . lang("architect_txt_29", true) . "</th>";
                                    if ($nextLevelCfg["active"]) {
                                        echo "\r\n                                                    <th colspan=\"2\"" . $thWidth . ">" . sprintf(lang("architect_txt_30", true), $nextLevel) . "</th>";
                                    }
                                    echo "                                                    \r\n                                                </tr>";
                                    echo "\r\n                                                <tr>\r\n                                                    <td" . $tdWidth . ">" . lang("currency_bless", true) . "</td>\r\n                                                    <td" . $tdWidth . ">" . $currLevelCfg["reward_bless_min"] . " - " . $currLevelCfg["reward_bless_max"] . "</td>";
                                    if ($nextLevelCfg["active"]) {
                                        echo "\r\n                                                    <td" . $tdWidth . ">" . lang("currency_bless", true) . "</td>\r\n                                                    <td" . $tdWidth . ">" . $nextLevelCfg["reward_bless_min"] . " - " . $nextLevelCfg["reward_bless_max"] . "</td>";
                                    }
                                    echo "\r\n                                                </tr>";
                                    echo "\r\n                                                <tr>\r\n                                                    <td" . $tdWidth . ">" . lang("currency_soul", true) . "</td>\r\n                                                    <td" . $tdWidth . ">" . $currLevelCfg["reward_soul_min"] . " - " . $currLevelCfg["reward_soul_max"] . "</td>";
                                    if ($nextLevelCfg["active"]) {
                                        echo "\r\n                                                    <td" . $tdWidth . ">" . lang("currency_soul", true) . "</td>\r\n                                                    <td" . $tdWidth . ">" . $nextLevelCfg["reward_soul_min"] . " - " . $nextLevelCfg["reward_soul_max"] . "</td>";
                                    }
                                    echo "\r\n                                                </tr>";
                                    echo "\r\n                                                <tr>\r\n                                                    <td" . $tdWidth . ">" . lang("currency_life", true) . "</td>\r\n                                                    <td" . $tdWidth . ">" . $currLevelCfg["reward_life_min"] . " - " . $currLevelCfg["reward_life_max"] . "</td>";
                                    if ($nextLevelCfg["active"]) {
                                        echo "\r\n                                                    <td" . $tdWidth . ">" . lang("currency_life", true) . "</td>\r\n                                                    <td" . $tdWidth . ">" . $nextLevelCfg["reward_life_min"] . " - " . $nextLevelCfg["reward_life_max"] . "</td>";
                                    }
                                    echo "\r\n                                                </tr>";
                                    echo "\r\n                                                <tr>\r\n                                                    <td" . $tdWidth . ">" . lang("currency_chaos", true) . "</td>\r\n                                                    <td" . $tdWidth . ">" . $currLevelCfg["reward_chaos_min"] . " - " . $currLevelCfg["reward_chaos_max"] . "</td>";
                                    if ($nextLevelCfg["active"]) {
                                        echo "\r\n                                                    <td" . $tdWidth . ">" . lang("currency_chaos", true) . "</td>\r\n                                                    <td" . $tdWidth . ">" . $nextLevelCfg["reward_chaos_min"] . " - " . $nextLevelCfg["reward_chaos_max"] . "</td>";
                                    }
                                    echo "\r\n                                                </tr>";
                                    echo "\r\n                                                <tr>\r\n                                                    <td" . $tdWidth . ">" . lang("currency_harmony", true) . "</td>\r\n                                                    <td" . $tdWidth . ">" . $currLevelCfg["reward_harmony_min"] . " - " . $currLevelCfg["reward_harmony_max"] . "</td>";
                                    if ($nextLevelCfg["active"]) {
                                        echo "\r\n                                                    <td" . $tdWidth . ">" . lang("currency_harmony", true) . "</td>\r\n                                                    <td" . $tdWidth . ">" . $nextLevelCfg["reward_harmony_min"] . " - " . $nextLevelCfg["reward_harmony_max"] . "</td>";
                                    }
                                    echo "\r\n                                                </tr>";
                                    echo "\r\n                                                <tr>\r\n                                                    <td" . $tdWidth . ">" . lang("currency_creation", true) . "</td>\r\n                                                    <td" . $tdWidth . ">" . $currLevelCfg["reward_creation_min"] . " - " . $currLevelCfg["reward_creation_max"] . "</td>";
                                    if ($nextLevelCfg["active"]) {
                                        echo "\r\n                                                    <td" . $tdWidth . ">" . lang("currency_creation", true) . "</td>\r\n                                                    <td" . $tdWidth . ">" . $nextLevelCfg["reward_creation_min"] . " - " . $nextLevelCfg["reward_creation_max"] . "</td>";
                                    }
                                    echo "\r\n                                                </tr>";
                                    echo "\r\n                                                <tr>\r\n                                                    <td" . $tdWidth . ">" . lang("currency_guardian", true) . "</td>\r\n                                                    <td" . $tdWidth . ">" . $currLevelCfg["reward_guardian_min"] . " - " . $currLevelCfg["reward_guardian_max"] . "</td>";
                                    if ($nextLevelCfg["active"]) {
                                        echo "\r\n                                                    <td" . $tdWidth . ">" . lang("currency_guardian", true) . "</td>\r\n                                                    <td" . $tdWidth . ">" . $nextLevelCfg["reward_guardian_min"] . " - " . $nextLevelCfg["reward_guardian_max"] . "</td>";
                                    }
                                    echo "\r\n                                                </tr>";
                                    echo "\r\n                                            </table>\r\n                                            <table class=\"general-table-ui castleArchitectLastProduction\" cellspacing=\"0\">\r\n                                                <tr>\r\n                                                    <th colspan=\"7\">" . lang("architect_txt_40", true) . "</th>\r\n                                                </tr>\r\n                                                <tr>\r\n                                                    <th>" . lang("currency_bless", true) . "</th>\r\n                                                    <th>" . lang("currency_soul", true) . "</th>\r\n                                                    <th>" . lang("currency_life", true) . "</th>\r\n                                                    <th>" . lang("currency_chaos", true) . "</th>\r\n                                                    <th>" . lang("currency_harmony", true) . "</th>\r\n                                                    <th>" . lang("currency_creation", true) . "</th>\r\n                                                    <th>" . lang("currency_guardian", true) . "</th>\r\n                                                </tr>";
                                    $lastProduction = $Architect->loadMineLastProduction();
                                    if (is_array($lastProduction)) {
                                        echo "\r\n                                                <tr>\r\n                                                    <td>" . number_format($lastProduction["bless"]) . "</td>\r\n                                                    <td>" . number_format($lastProduction["soul"]) . "</td>\r\n                                                    <td>" . number_format($lastProduction["life"]) . "</td>\r\n                                                    <td>" . number_format($lastProduction["chaos"]) . "</td>\r\n                                                    <td>" . number_format($lastProduction["harmony"]) . "</td>\r\n                                                    <td>" . number_format($lastProduction["creation"]) . "</td>\r\n                                                    <td>" . number_format($lastProduction["guardian"]) . "</td>\r\n                                                </tr>";
                                    } else {
                                        echo "\r\n                                                <tr>\r\n                                                    <td colspan=\"7\">" . lang("architect_txt_41", true) . "</td>\r\n                                                </tr>";
                                    }
                                    echo "\r\n                                            </table>\r\n                                        </div>";
                                    if ($nextLevelCfg["active"]) {
                                        echo "\r\n                                        <h4>" . lang("architect_txt_24", true) . "</h4>";
                                    } else {
                                        echo "\r\n                                        <div class=\"building-cannot-upgrade\">" . lang("architect_txt_26", true) . "</div>";
                                    }
                                    echo "\r\n                                        <div class=\"building-price\">";
                                    if ($nextLevelCfg["active"]) {
                                        if (0 < $nextLevelCfg["price_valor"]) {
                                            echo "\r\n                                            <div class=\"building-price-box\">\r\n                                                " . lang("architect_txt_8", true) . ":<br>\r\n                                                <span class=\"building-price-val\">" . number_format($nextLevelCfg["price_valor"]) . "</span>\r\n                                            </div>";
                                        }
                                        if (0 < $nextLevelCfg["price_sol"]) {
                                            echo "\r\n                                            <div class=\"building-price-box\">\r\n                                                " . lang("architect_txt_17", true) . ":<br>\r\n                                                <span class=\"building-price-val\">" . number_format($nextLevelCfg["price_sol"]) . "</span>\r\n                                            </div>";
                                        }
                                        if (0 < $nextLevelCfg["price_zen"]) {
                                            echo "\r\n                                            <div class=\"building-price-box\">\r\n                                                " . lang("currency_zen", true) . ":<br>\r\n                                                <span class=\"building-price-val\">" . number_format($nextLevelCfg["price_zen"]) . "</span>\r\n                                            </div>";
                                        }
                                        if (0 < $nextLevelCfg["price_bless"]) {
                                            echo "\r\n                                            <div class=\"building-price-box\">\r\n                                                " . lang("currency_bless", true) . ":<br>\r\n                                                <span class=\"building-price-val\">" . number_format($nextLevelCfg["price_bless"]) . "</span>\r\n                                            </div>";
                                        }
                                        if (0 < $nextLevelCfg["price_soul"]) {
                                            echo "\r\n                                            <div class=\"building-price-box\">\r\n                                                " . lang("currency_soul", true) . ":<br>\r\n                                                <span class=\"building-price-val\">" . number_format($nextLevelCfg["price_soul"]) . "</span>\r\n                                            </div>";
                                        }
                                        if (0 < $nextLevelCfg["price_life"]) {
                                            echo "\r\n                                            <div class=\"building-price-box\">\r\n                                                " . lang("currency_life", true) . ":<br>\r\n                                                <span class=\"building-price-val\">" . number_format($nextLevelCfg["price_life"]) . "</span>\r\n                                            </div>";
                                        }
                                        if (0 < $nextLevelCfg["price_chaos"]) {
                                            echo "\r\n                                            <div class=\"building-price-box\">\r\n                                                " . lang("currency_chaos", true) . ":<br>\r\n                                                <span class=\"building-price-val\">" . number_format($nextLevelCfg["price_chaos"]) . "</span>\r\n                                            </div>";
                                        }
                                        if (0 < $nextLevelCfg["price_harmony"]) {
                                            echo "\r\n                                            <div class=\"building-price-box\">\r\n                                                " . lang("currency_harmony", true) . ":<br>\r\n                                                <span class=\"building-price-val\">" . number_format($nextLevelCfg["price_harmony"]) . "</span>\r\n                                            </div>";
                                        }
                                        if (0 < $nextLevelCfg["price_creation"]) {
                                            echo "\r\n                                            <div class=\"building-price-box\">\r\n                                                " . lang("currency_creation", true) . ":<br>\r\n                                                <span class=\"building-price-val\">" . number_format($nextLevelCfg["price_creation"]) . "</span>\r\n                                            </div>";
                                        }
                                        if (0 < $nextLevelCfg["price_guardian"]) {
                                            echo "\r\n                                            <div class=\"building-price-box\">\r\n                                                " . lang("currency_guardian", true) . ":<br>\r\n                                                <span class=\"building-price-val\">" . number_format($nextLevelCfg["price_guardian"]) . "</span>\r\n                                            </div>";
                                        }
                                    }
                                    if ($canBuild && $nextLevelCfg["active"]) {
                                        if ($nextLevel == 1) {
                                            $btnText = lang("architect_txt_27", true);
                                        } else {
                                            $btnText = sprintf(lang("architect_txt_28", true), $nextLevel);
                                        }
                                        echo "\r\n                                            <div class=\"building-button\">\r\n                                                <form method=\"post\" action=\"" . __BASE_URL__ . "usercp/architect/char/" . hex_encode($char) . "/\">\r\n                                                    <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                                                    <input type=\"hidden\" name=\"type\" value=\"mine\">\r\n                                                    <input type=\"submit\" name=\"upgrade\" value=\"" . $btnText . "\" class=\"building-manage-btn\" />\r\n                                                </form>\r\n                                            </div>";
                                    }
                                    echo "\r\n                                        </div>\r\n                                    </div>";
                                }
                                echo "                                              \r\n                                </div>\r\n                            </div>";
                            }
                            if (mconfig("building_bank")) {
                                echo "\r\n                            <div class=\"building\">\r\n                                <div class=\"building-top\">\r\n                                    <div class=\"building-title\">\r\n                                        " . lang("architect_txt_23", true) . "\r\n                                    </div>\r\n                                </div>\r\n                                <div class=\"building-middle\">\r\n                                    <div class=\"building-image\">\r\n                                        <img src=\"" . __PATH_TEMPLATE__ . "style/images/bank.png\" />\r\n                                    </div>\r\n                                    <div class=\"building-desc\">\r\n                                        <ul>\r\n                                            <li>" . lang("architect_txt_21", true) . "</li>\r\n                                            <li>" . lang("architect_txt_19", true) . "</li>\r\n                                        </ul>\r\n                                    </div>";
                                if ($isCastleOwner || $isFromAlliance) {
                                    $currLevelCfg = mconfig("bank_stage" . $buildingsData["Bank_Level"]);
                                    $nextLevel = $buildingsData["Bank_Level"] + 1;
                                    $nextLevelCfg = mconfig("bank_stage" . $nextLevel);
                                    if ($nextLevelCfg["active"]) {
                                        $thWidth = " style=\"width: 50%\"";
                                        $tdWidth = " style=\"width: 25%\"";
                                    } else {
                                        $thWidth = " style=\"width: 100%\"";
                                        $tdWidth = " style=\"width: 50%\"";
                                    }
                                    if ($currLevelCfg["active"]) {
                                        $bankPerc = "%";
                                    } else {
                                        $bankPerc = "-";
                                    }
                                    echo "\r\n                                    <div class=\"building-bottom\">\r\n                                        <div>\r\n                                            <table class=\"general-table-ui castleArchitectProduction\" cellspacing=\"0\">\r\n                                                <tr>\r\n                                                    <th colspan=\"2\"" . $thWidth . ">" . lang("architect_txt_36", true) . "</th>";
                                    if ($nextLevelCfg["active"]) {
                                        echo "\r\n                                                    <th colspan=\"2\"" . $thWidth . ">" . sprintf(lang("architect_txt_37", true), $nextLevel) . "</th>";
                                    }
                                    echo "                                                    \r\n                                                </tr>";
                                    if (mconfig("bank_platinum")) {
                                        echo "\r\n                                                <tr>\r\n                                                    <td" . $tdWidth . ">" . lang("currency_platinum", true) . "</td>\r\n                                                    <td" . $tdWidth . ">" . $currLevelCfg["reward_platinum"] . $bankPerc . "</td>";
                                        if ($nextLevelCfg["active"]) {
                                            echo "\r\n                                                    <td" . $tdWidth . ">" . lang("currency_platinum", true) . "</td>\r\n                                                    <td" . $tdWidth . ">" . $nextLevelCfg["reward_platinum"] . "%</td>";
                                        }
                                        echo "\r\n                                                </tr>";
                                    }
                                    if (mconfig("bank_gold")) {
                                        echo "\r\n                                                <tr>\r\n                                                    <td" . $tdWidth . ">" . lang("currency_gold", true) . "</td>\r\n                                                    <td" . $tdWidth . ">" . $currLevelCfg["reward_gold"] . $bankPerc . "</td>";
                                        if ($nextLevelCfg["active"]) {
                                            echo "\r\n                                                    <td" . $tdWidth . ">" . lang("currency_gold", true) . "</td>\r\n                                                    <td" . $tdWidth . ">" . $nextLevelCfg["reward_gold"] . "%</td>";
                                        }
                                        echo "\r\n                                                </tr>";
                                    }
                                    if (mconfig("bank_silver")) {
                                        echo "\r\n                                                <tr>\r\n                                                    <td" . $tdWidth . ">" . lang("currency_silver", true) . "</td>\r\n                                                    <td" . $tdWidth . ">" . $currLevelCfg["reward_silver"] . $bankPerc . "</td>";
                                        if ($nextLevelCfg["active"]) {
                                            echo "\r\n                                                    <td" . $tdWidth . ">" . lang("currency_silver", true) . "</td>\r\n                                                    <td" . $tdWidth . ">" . $nextLevelCfg["reward_silver"] . "%</td>";
                                        }
                                        echo "\r\n                                                </tr>";
                                    }
                                    if (mconfig("bank_wcoin")) {
                                        echo "\r\n                                                <tr>\r\n                                                    <td" . $tdWidth . ">" . lang("currency_wcoinc", true) . "</td>\r\n                                                    <td" . $tdWidth . ">" . $currLevelCfg["reward_wcoin"] . $bankPerc . "</td>";
                                        if ($nextLevelCfg["active"]) {
                                            echo "\r\n                                                    <td" . $tdWidth . ">" . lang("currency_wcoinc", true) . "</td>\r\n                                                    <td" . $tdWidth . ">" . $nextLevelCfg["reward_wcoin"] . "%</td>";
                                        }
                                        echo "\r\n                                                </tr>";
                                    }
                                    if (mconfig("bank_gp")) {
                                        echo "\r\n                                                <tr>\r\n                                                    <td" . $tdWidth . ">" . lang("currency_gp", true) . "</td>\r\n                                                    <td" . $tdWidth . ">" . $currLevelCfg["reward_gp"] . $bankPerc . "</td>";
                                        if ($nextLevelCfg["active"]) {
                                            echo "\r\n                                                    <td" . $tdWidth . ">" . lang("currency_gp", true) . "</td>\r\n                                                    <td" . $tdWidth . ">" . $nextLevelCfg["reward_gp"] . "%</td>";
                                        }
                                        echo "\r\n                                                </tr>";
                                    }
                                    if (mconfig("bank_zen")) {
                                        echo "\r\n                                                <tr>\r\n                                                    <td" . $tdWidth . ">" . lang("currency_zen", true) . "</td>\r\n                                                    <td" . $tdWidth . ">" . $currLevelCfg["reward_zen"] . $bankPerc . "</td>";
                                        if ($nextLevelCfg["active"]) {
                                            echo "\r\n                                                    <td" . $tdWidth . ">" . lang("currency_zen", true) . "</td>\r\n                                                    <td" . $tdWidth . ">" . $nextLevelCfg["reward_zen"] . "%</td>";
                                        }
                                        echo "\r\n                                                </tr>";
                                    }
                                    echo "\r\n                                            </table>\r\n                                        </div>";
                                    if ($nextLevelCfg["active"]) {
                                        echo "\r\n                                        <h4>" . lang("architect_txt_24", true) . "</h4>";
                                    } else {
                                        echo "<div class=\"building-cannot-upgrade\">" . lang("architect_txt_26", true) . "</div>";
                                    }
                                    echo "\r\n                                            <div class=\"building-price\">";
                                    if ($nextLevelCfg["active"]) {
                                        if (0 < $nextLevelCfg["price_valor"]) {
                                            echo "\r\n                                            <div class=\"building-price-box\">\r\n                                                " . lang("architect_txt_8", true) . ":<br>\r\n                                                <span class=\"building-price-val\">" . number_format($nextLevelCfg["price_valor"]) . "</span>\r\n                                            </div>";
                                        }
                                        if (0 < $nextLevelCfg["price_sol"]) {
                                            echo "\r\n                                            <div class=\"building-price-box\">\r\n                                                " . lang("architect_txt_17", true) . ":<br>\r\n                                                <span class=\"building-price-val\">" . number_format($nextLevelCfg["price_sol"]) . "</span>\r\n                                            </div>";
                                        }
                                        if (0 < $nextLevelCfg["price_zen"]) {
                                            echo "\r\n                                            <div class=\"building-price-box\">\r\n                                                " . lang("currency_zen", true) . ":<br>\r\n                                                <span class=\"building-price-val\">" . number_format($nextLevelCfg["price_zen"]) . "</span>\r\n                                            </div>";
                                        }
                                        if (0 < $nextLevelCfg["price_bless"]) {
                                            echo "\r\n                                            <div class=\"building-price-box\">\r\n                                                " . lang("currency_bless", true) . ":<br>\r\n                                                <span class=\"building-price-val\">" . number_format($nextLevelCfg["price_bless"]) . "</span>\r\n                                            </div>";
                                        }
                                        if (0 < $nextLevelCfg["price_soul"]) {
                                            echo "\r\n                                            <div class=\"building-price-box\">\r\n                                                " . lang("currency_soul", true) . ":<br>\r\n                                                <span class=\"building-price-val\">" . number_format($nextLevelCfg["price_soul"]) . "</span>\r\n                                            </div>";
                                        }
                                        if (0 < $nextLevelCfg["price_life"]) {
                                            echo "\r\n                                            <div class=\"building-price-box\">\r\n                                                " . lang("currency_life", true) . ":<br>\r\n                                                <span class=\"building-price-val\">" . number_format($nextLevelCfg["price_life"]) . "</span>\r\n                                            </div>";
                                        }
                                        if (0 < $nextLevelCfg["price_chaos"]) {
                                            echo "\r\n                                            <div class=\"building-price-box\">\r\n                                                " . lang("currency_chaos", true) . ":<br>\r\n                                                <span class=\"building-price-val\">" . number_format($nextLevelCfg["price_chaos"]) . "</span>\r\n                                            </div>";
                                        }
                                        if (0 < $nextLevelCfg["price_harmony"]) {
                                            echo "\r\n                                            <div class=\"building-price-box\">\r\n                                                " . lang("currency_harmony", true) . ":<br>\r\n                                                <span class=\"building-price-val\">" . number_format($nextLevelCfg["price_harmony"]) . "</span>\r\n                                            </div>";
                                        }
                                        if (0 < $nextLevelCfg["price_creation"]) {
                                            echo "\r\n                                            <div class=\"building-price-box\">\r\n                                                " . lang("currency_creation", true) . ":<br>\r\n                                                <span class=\"building-price-val\">" . number_format($nextLevelCfg["price_creation"]) . "</span>\r\n                                            </div>";
                                        }
                                        if (0 < $nextLevelCfg["price_guardian"]) {
                                            echo "\r\n                                            <div class=\"building-price-box\">\r\n                                                " . lang("currency_guardian", true) . ":<br>\r\n                                                <span class=\"building-price-val\">" . number_format($nextLevelCfg["price_guardian"]) . "</span>\r\n                                            </div>";
                                        }
                                    }
                                    if ($canBuild && $nextLevelCfg["active"]) {
                                        if ($nextLevel == 1) {
                                            $btnText = lang("architect_txt_27", true);
                                        } else {
                                            $btnText = sprintf(lang("architect_txt_28", true), $nextLevel);
                                        }
                                        echo "\r\n                                            <div class=\"building-button\">\r\n                                                <form method=\"post\" action=\"" . __BASE_URL__ . "usercp/architect/char/" . hex_encode($char) . "/\">\r\n                                                    <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                                                    <input type=\"hidden\" name=\"type\" value=\"bank\">                                                    \r\n                                                    <input type=\"submit\" name=\"upgrade\" value=\"" . $btnText . "\" class=\"building-manage-btn\" />\r\n                                                </form>\r\n                                            </div>";
                                    }
                                    if (($isCastleOwner || $isFromAlliance) && 0 < $buildingsData["Bank_Level"]) {
                                        echo "\r\n                                            <div class=\"building-button\">\r\n                                                <form method=\"get\" action=\"" . __BASE_URL__ . "usercp/architect/char/" . hex_encode($char) . "/building/bank/\">\r\n                                                    <input type=\"submit\" value=\"" . lang("architect_txt_38", true) . "\" class=\"building-manage-btn\" />\r\n                                                </form>\r\n                                            </div>";
                                    }
                                    echo "                                            \r\n                                        </div>";
                                }
                                echo "          \r\n                                    </div>\r\n                                </div>\r\n                            </div>";
                            }
                            echo "\r\n                        </div>\r\n                    </div>";
                        }
                    } else {
                        message("error", lang("architect_txt_15", true));
                    }
                }
            } else {
                $chars = $dB->query_fetch("SELECT Name,cLevel,mLevel,RESETS,Grand_Resets,Class FROM Character WHERE AccountID = ? ORDER BY Grand_Resets desc,RESETS desc,mLevel desc,cLevel desc,Name asc", [$_SESSION["username"]]);
                echo "\r\n            <div class=\"container_3 account-wide\" align=\"center\">\r\n                <table class=\"general-table-ui\" cellspacing=\"0\" width=\"100%\">\r\n                    <tr>\r\n                        <th colspan=\"6\">" . lang("global_module_2", true) . "</th>\r\n                    </tr>\r\n                    <tr>\r\n                        <th>" . lang("global_module_3", true) . "</th>\r\n                        <th>" . lang("global_module_4", true) . "</th>\r\n                        <th>" . lang("profiles_txt_20", true) . "</th>\r\n                        <th>" . lang("global_module_5", true) . " [" . lang("global_module_6", true) . "]</th>";
                if ($config["use_resets"]) {
                    echo "<th>" . lang("global_module_7", true) . "";
                }
                if ($config["use_grand_resets"]) {
                    echo " [" . lang("global_module_8", true) . "]</th>";
                } else {
                    echo "</th>";
                }
                echo "\r\n                        <th>" . lang("global_module_9", true) . "</th>\r\n                    </tr>";
                foreach ($chars as $char) {
                    $guild = $dB->query_fetch_single("SELECT G_Name FROM GuildMember WHERE Name = ?", [$char["Name"]]);
                    $guildName = NULL;
                    if ($guild["G_Name"] != NULL) {
                        $guildName = "<a href=\"" . __BASE_URL__ . "profile/guild/req/" . hex_encode($guild["G_Name"]) . "/\">" . $common->replaceHtmlSymbols($guild["G_Name"]) . "</a>";
                    }
                    if ($guildName != NULL) {
                        $link = "<a href=\"" . __BASE_URL__ . "usercp/architect/char/" . hex_encode($char["Name"]) . "/\">" . lang("architect_txt_10", true) . "</a>";
                    } else {
                        $link = lang("architect_txt_11", true);
                    }
                    echo "\r\n                    <tr>\r\n                        <td><b><a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($char["Name"]) . "/\">" . $common->replaceHtmlSymbols($char["Name"]) . "</a></b></td>\r\n                        <td>" . $custom["character_class"][$char["Class"]][0] . "</td>\r\n                        <td>" . $guildName . "</td>\r\n                        <td>" . $char["cLevel"] . " [" . $char["mLevel"] . "]</td>";
                    if ($config["use_resets"]) {
                        echo "<td>" . $char["RESETS"];
                    }
                    if ($config["use_grand_resets"]) {
                        echo " [" . $char["Grand_Resets"] . "]</td>";
                    } else {
                        echo "</td>";
                    }
                    echo "\r\n                        <td>" . $link . "</td>\r\n                    </tr>\r\n                    ";
                }
                echo "\r\n                </table>\r\n            </div>";
            }
        } else {
            message("error", lang("error_47", true));
        }
        echo "\r\n    </div>\r\n</div>";
    }
}

?>