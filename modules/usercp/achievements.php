<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

if (!isLoggedIn()) {
    redirect(1, "login");
} else {
    if (!canAccessModule($_SESSION["username"], "achievements", "block")) {
        return NULL;
    }
    $xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "usercp.achievements.quests.xml");
    $active = mconfig("active");
    $total = mconfig("total");
    $req_items = mconfig("req_items");
    $req_item1_code = mconfig("item1_code");
    $req_item1_count = mconfig("item1_count");
    $req_item2_code = mconfig("item2_code");
    $req_item2_count = mconfig("item2_count");
    $req_item3_code = mconfig("item3_code");
    $req_item3_count = mconfig("item3_count");
    $req_zen = mconfig("zen");
    if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
        $breadcrumb = generateBreadcrumb();
        echo "\r\n    <h3>\r\n        " . lang("achievement_txt_0", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
    } else {
        echo "\r\n<div class=\"sub-page-title\">\r\n    <div id=\"title\">\r\n        <h1>" . lang("module_titles_txt_3", true) . "<p></p><span></span></h1>\r\n    </div>\r\n</div>\r\n<div class=\"container_2 account\" align=\"center\">\r\n    <div class=\"cont-image\">\r\n        <div class=\"container_3 account_sub_header\">\r\n            <div class=\"grad\">\r\n                <div class=\"page-title\"><p>" . lang("achievement_txt_0", true) . "</p></div>\r\n                <a href=\"" . __BASE_URL__ . "usercp\">" . lang("global_module_1", true) . "</a>\r\n            </div>\r\n        </div>";
    }
    if ($active == "0") {
        message("error", lang("error_47", true));
    } else {
        $General = new xGeneral();
        $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("achievements");
        $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("achievements");
        $Achievement = new Achievements();
        $achievements = $Achievement->loadXML($xml);
        if (isset($_GET["char"])) {
            $char = hex_decode($_GET["char"]);
            $char = xss_clean($char);
            $Character = new Character();
            if ($Character->CharacterExists($char) && $Character->CharacterBelongsToAccount($char, $_SESSION["username"])) {
                if (check_value($_POST["reg_item1"])) {
                    if ($_SESSION["token"] == $_POST["token"]) {
                        $amount = htmlspecialchars($_POST["item1_value"]);
                        $amount = xss_clean($amount);
                        if ($common->beginDbTrans($_SESSION["username"])) {
                            $Achievement->registerItem($_SESSION["username"], $char, $amount, $req_item1_code, 1);
                            $common->endDbTrans($_SESSION["username"]);
                        }
                    } else {
                        message("notice", lang("global_module_13", true));
                    }
                }
                if (check_value($_POST["reg_item2"])) {
                    if ($_SESSION["token"] == $_POST["token"]) {
                        $amount = htmlspecialchars($_POST["item2_value"]);
                        $amount = xss_clean($amount);
                        if ($common->beginDbTrans($_SESSION["username"])) {
                            $Achievement->registerItem($_SESSION["username"], $char, $amount, $req_item2_code, 2);
                            $common->endDbTrans($_SESSION["username"]);
                        }
                    } else {
                        message("notice", lang("global_module_13", true));
                    }
                }
                if (check_value($_POST["reg_item3"])) {
                    if ($_SESSION["token"] == $_POST["token"]) {
                        $amount = htmlspecialchars($_POST["item3_value"]);
                        $amount = xss_clean($amount);
                        if ($common->beginDbTrans($_SESSION["username"])) {
                            $Achievement->registerItem($_SESSION["username"], $char, $amount, $req_item3_code, 3);
                            $common->endDbTrans($_SESSION["username"]);
                        }
                    } else {
                        message("notice", lang("global_module_13", true));
                    }
                }
                if (check_value($_POST["reg_zen"])) {
                    if ($_SESSION["token"] == $_POST["token"]) {
                        $amount = htmlspecialchars($_POST["zen_value"]);
                        $amount = xss_clean($amount);
                        if ($common->beginDbTrans($_SESSION["username"])) {
                            $Achievement->registerZen($_SESSION["username"], $char, $amount);
                            $common->endDbTrans($_SESSION["username"]);
                        }
                    } else {
                        message("notice", lang("global_module_13", true));
                    }
                }
                if (check_value($_POST["unlock"])) {
                    if ($_SESSION["token"] == $_POST["token"]) {
                        $Achievement->unlockAchievements($_SESSION["username"], $char);
                    } else {
                        message("notice", lang("global_module_13", true));
                    }
                }
                $unlockData = $Achievement->unlockData($_SESSION["username"], $char);
                if (mconfig("autounlock") && $unlockData["Unlock"] == "0") {
                    $Achievement->autoUnlock($_SESSION["username"], $char);
                }
                $unlockData = $Achievement->unlockData($_SESSION["username"], $char);
                if ($unlockData["Unlock"] == "1") {
                    if (check_value($_POST["reward"])) {
                        $uid = Decode(htmlspecialchars($_POST[Encode("uid")]));
                        $uid = xss_clean($uid);
                        $stage = Decode(htmlspecialchars($_POST[Encode("stage")]));
                        $stage = xss_clean($stage);
                        $j = Decode(htmlspecialchars($_POST[Encode("j")]));
                        $j = xss_clean($j);
                        if ($common->beginDbTrans($_SESSION["username"])) {
                            $Achievement->giveReward($_SESSION["username"], $char, $achievements, $uid, $stage, $j);
                            $common->endDbTrans($_SESSION["username"]);
                        }
                    }
                    $token = time();
                    $_SESSION["token"] = $token;
                    if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
                        $Achievement->showAchievements($_SESSION["username"], $char, $achievements, $total, $token);
                    } else {
                        echo "<div class=\"container_3 account-wide\" align=\"center\">";
                        $Achievement->showAchievements($_SESSION["username"], $char, $achievements, $total, $token);
                        echo "</div>";
                    }
                } else {
                    if (!mconfig("autounlock")) {
                        $token = time();
                        $_SESSION["token"] = $token;
                        $money = $Achievement->getMoneyInv($_SESSION["username"], $char);
                        $found_item1 = 0;
                        $found_item2 = 0;
                        $found_item3 = 0;
                        if (1 <= $req_items) {
                            $found_item1 = $Achievement->getReqItemInv($_SESSION["username"], $char, $req_item1_code);
                            if (2 <= $req_items) {
                                $found_item2 = $Achievement->getReqItemInv($_SESSION["username"], $char, $req_item2_code);
                                if (3 <= $req_items) {
                                    $found_item3 = $Achievement->getReqItemInv($_SESSION["username"], $char, $req_item3_code);
                                }
                            }
                        }
                        if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
                            echo "\r\n                    <div class=\"row desc-row\">\r\n                        <div class=\"col-xs-12\">";
                            if (mconfig("autounlock")) {
                                echo lang("achievement_txt_24", true) . " ";
                                if (0 < mconfig("level")) {
                                    echo mconfig("level") . " Level ";
                                }
                                if (0 < mconfig("mlevel")) {
                                    echo mconfig("mlevel") . " Master Level ";
                                }
                                if (0 < mconfig("reset")) {
                                    echo mconfig("reset") . " Reset ";
                                }
                                if (0 < mconfig("greset")) {
                                    echo mconfig("greset") . " Grand Reset ";
                                }
                            } else {
                                echo lang("achievement_txt_25", true);
                            }
                            echo "\r\n                        </div>\r\n                    </div>\r\n                    <table class=\"table table-hover text-center\">\r\n                        <tr>\r\n                            <th class=\"headerRow ach-header-row\" colspan=\"2\">" . lang("achievement_txt_26", true) . "</th>\r\n                        </tr>";
                            if (1 <= $req_items) {
                                echo "\r\n                        <tr>\r\n                            <td width=\"50%\"><b>" . mconfig("item1_name") . "</b></td>\r\n                            <td width=\"50%\">" . $unlockData["Item1"] . " / " . $req_item1_count . "</td>\r\n                        </tr>";
                                if (2 <= $req_items) {
                                    echo "\r\n                        <tr>\r\n                            <td width=\"50%\"><b>" . mconfig("item2_name") . "</b></td>\r\n                            <td width=\"50%\">" . $unlockData["Item2"] . " / " . $req_item2_count . "</td>\r\n                        </tr>";
                                    if (3 <= $req_items) {
                                        echo "\r\n                        <tr>\r\n                            <td width=\"50%\"><b>" . mconfig("item3_name") . "</b></td>\r\n                            <td width=\"50%\">" . $unlockData["Item3"] . " / " . $req_item3_count . "</td>\r\n                        </tr>";
                                    }
                                }
                            }
                            if (0 < $req_zen) {
                                echo "\r\n                        <tr>\r\n                            <td><b>" . lang("currency_zen", true) . "</b></td>\r\n                            <td>" . number_format($unlockData["Zen"]) . " / " . number_format($req_zen) . "</td>\r\n                        </tr>";
                            }
                            $characterData = $Character->CharacterData($char);
                            if (0 < mconfig("level")) {
                                echo "\r\n                        <tr>\r\n                            <td><b>" . lang("global_module_5", true) . "</b></td>\r\n                            <td>" . number_format($characterData["cLevel"]) . " / " . number_format(mconfig("level")) . "</td>\r\n                        </tr>";
                            }
                            if (0 < mconfig("mlevel")) {
                                echo "\r\n                        <tr>\r\n                            <td><b>" . lang("global_module_6", true) . "</b></td>\r\n                            <td>" . number_format($characterData["mLevel"]) . " / " . number_format(mconfig("mlevel")) . "</td>\r\n                        </tr>";
                            }
                            if (0 < mconfig("reset")) {
                                echo "\r\n                        <tr>\r\n                            <td><b>" . lang("global_module_7", true) . "</b></td>\r\n                            <td>" . number_format($characterData["RESETS"]) . " / " . number_format(mconfig("reset")) . "</td>\r\n                        </tr>";
                            }
                            if (0 < mconfig("greset")) {
                                echo "\r\n                        <tr>\r\n                            <td><b>" . lang("global_module_8", true) . "</b></td>\r\n                            <td>" . number_format($characterData["Grand_Resets"]) . " / " . number_format(mconfig("greset")) . "</td>\r\n                        </tr>";
                            }
                            echo "\r\n                    </table>";
                            $can_unlock = true;
                            $other_req = true;
                            if (1 <= $req_items) {
                                if ($req_item1_count > $unlockData["Item1"]) {
                                    $can_unlock = false;
                                }
                                if (2 <= $req_items) {
                                    if ($req_item2_count > $unlockData["Item2"]) {
                                        $can_unlock = false;
                                    }
                                    if (3 <= $req_items && $req_item3_count > $unlockData["Item3"]) {
                                        $can_unlock = false;
                                    }
                                }
                            }
                            if (0 < $req_zen && $req_zen > $unlockData["Zen"]) {
                                $can_unlock = false;
                            }
                            if (0 < mconfig("level") && mconfig("level") > $characterData["cLevel"]) {
                                $can_unlock = false;
                                $other_req = false;
                            }
                            if (0 < mconfig("mlevel") && mconfig("mlevel") > $characterData["mLevel"]) {
                                $can_unlock = false;
                                $other_req = false;
                            }
                            if (0 < mconfig("reset") && mconfig("reset") > $characterData["RESETS"]) {
                                $can_unlock = false;
                                $other_req = false;
                            }
                            if (0 < mconfig("greset") && mconfig("greset") > $characterData["Grand_Resets"]) {
                                $can_unlock = false;
                                $other_req = false;
                            }
                            if ($can_unlock) {
                                echo "\r\n                    <form method=\"post\">\r\n                        <table class=\"table table-hover text-center\">\r\n                            <tr>\r\n                                <th class=\"headerRow ach-header-row\">" . lang("achievement_txt_27", true) . "</th>\r\n                            </tr>\r\n                            <tr>\r\n                                <td>\r\n                                    <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                                    <input type=\"submit\" name=\"unlock\" id=\"unlock\" class=\"btn btn-warning full-width-btn\" value=\"" . lang("achievement_txt_27", true) . "\">\r\n                                </td>\r\n                            </tr>\r\n                        </table>\r\n                    </form>";
                            } else {
                                if ($other_req) {
                                    echo "\r\n                    <form method=\"post\">\r\n                        <table class=\"table table-hover text-center ach-unlock-tab\">\r\n                            <tr>\r\n                                <th class=\"headerRow ach-header-row\" colspan=\"2\">" . lang("achievement_txt_28", true) . "</th>\r\n                            </tr>";
                                    if (1 <= $req_items) {
                                        if ($unlockData["Item1"] < $req_item1_count) {
                                            echo "\r\n                            <tr>\r\n                                <td width=\"50%\"><b>" . lang("achievement_txt_29", true) . " " . mconfig("item1_name") . "</b></td>\r\n                                <td width=\"50%\" align=\"left\">\r\n                                    <div class=\"row\">\r\n                                        <div class=\"col-xs-12 col-sm-12 col-md-6 col-lg-6\">\r\n                                            <input type=\"text\" class=\"form-control\" name=\"item1_value\" value=\"0\">\r\n                                        </div>\r\n                                        <div class=\"col-xs-12 col-sm-12 col-md-6 col-lg-6\">\r\n                                            <small>" . lang("achievement_txt_30", true) . " " . number_format($found_item1) . " " . mconfig("item1_name") . "</small>\r\n                                        </div>\r\n                                    </div>\r\n                                    <div class=\"row\">\r\n                                        <div class=\"col-xs-12\">\r\n                                            <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                                            <input type=\"submit\" name=\"reg_item1\" id=\"reg_item1\" class=\"btn btn-warning full-width-btn ach-reg-btn\" value=\"" . lang("achievement_txt_29", true) . "\">\r\n                                        </div>\r\n                                    </div>\r\n                                </td>\r\n                            </tr>";
                                        }
                                        if (2 <= $req_items) {
                                            if ($unlockData["Item2"] < $req_item2_count) {
                                                echo "\r\n                            <tr>\r\n                                <td width=\"50%\"><b>" . lang("achievement_txt_29", true) . " " . mconfig("item2_name") . "</b></td>\r\n                                <td width=\"50%\" align=\"left\">\r\n                                    <div class=\"row\">\r\n                                        <div class=\"col-xs-12 col-sm-12 col-md-6 col-lg-6\">\r\n                                            <input type=\"text\" class=\"form-control\" name=\"item2_value\" value=\"0\">\r\n                                        </div>\r\n                                        <div class=\"col-xs-12 col-sm-12 col-md-6 col-lg-6\">\r\n                                            <small>" . lang("achievement_txt_30", true) . " " . number_format($found_item2) . " " . mconfig("item2_name") . "</small>\r\n                                        </div>\r\n                                    </div>\r\n                                    <div class=\"row\">\r\n                                        <div class=\"col-xs-12\">\r\n                                            <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                                            <input type=\"submit\" name=\"reg_item2\" id=\"reg_item2\" class=\"btn btn-warning full-width-btn ach-reg-btn\" value=\"" . lang("achievement_txt_29", true) . "\">\r\n                                        </div>\r\n                                    </div>\r\n                                </td>\r\n                            </tr>";
                                            }
                                            if (3 <= $req_items && $unlockData["Item3"] < $req_item3_count) {
                                                echo "\r\n                            <tr>\r\n                                <td width=\"50%\"><b>" . lang("achievement_txt_29", true) . " " . mconfig("item3_name") . "</b></td>\r\n                                <td width=\"50%\" align=\"left\">\r\n                                    <div class=\"row\">\r\n                                        <div class=\"col-xs-12 col-sm-12 col-md-6 col-lg-6\">\r\n                                            <input type=\"text\" class=\"form-control\" name=\"item3_value\" value=\"0\">\r\n                                        </div>\r\n                                        <div class=\"col-xs-12 col-sm-12 col-md-6 col-lg-6\">\r\n                                            <small>" . lang("achievement_txt_30", true) . " " . number_format($found_item3) . " " . mconfig("item3_name") . "</small>\r\n                                        </div>\r\n                                    </div>\r\n                                    <div class=\"row\">\r\n                                        <div class=\"col-xs-12\">\r\n                                            <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                                            <input type=\"submit\" name=\"reg_item3\" id=\"reg_item3\" class=\"btn btn-warning full-width-btn ach-reg-btn\" value=\"" . lang("achievement_txt_29", true) . "\">\r\n                                        </div>\r\n                                    </div>\r\n                                </td>\r\n                            </tr>";
                                            }
                                        }
                                    }
                                    if (0 < $req_zen && $unlockData["Zen"] < $req_zen) {
                                        echo "\r\n                            <tr>\r\n                                <td width=\"50%\"><b>" . lang("achievement_txt_31", true) . "</b></td>\r\n                                <td width=\"50%\" align=\"left\">\r\n                                    <div class=\"row\">\r\n                                        <div class=\"col-xs-12 col-sm-12 col-md-6 col-lg-6\">\r\n                                            <input type=\"text\" class=\"form-control\" name=\"zen_value\" value=\"0\">\r\n                                        </div>\r\n                                        <div class=\"col-xs-12 col-sm-12 col-md-6 col-lg-6\">\r\n                                            <small>" . lang("achievement_txt_30", true) . " " . number_format($money) . " " . lang("currency_zen", true) . "</small>\r\n                                        </div>\r\n                                    </div>\r\n                                    <div class=\"row\">\r\n                                        <div class=\"col-xs-12\">\r\n                                            <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                                            <input type=\"submit\" name=\"reg_zen\" id=\"reg_zen\" class=\"btn btn-warning full-width-btn ach-reg-btn\" value=\"" . lang("achievement_txt_29", true) . "\">\r\n                                        </div>\r\n                                    </div>\r\n                                </td>\r\n                            </tr>";
                                    }
                                    echo "\r\n                        </table>\r\n                    </form>";
                                }
                            }
                        } else {
                            echo "<div class=\"page-desc-holder\">";
                            if (mconfig("autounlock")) {
                                echo lang("achievement_txt_24", true) . " ";
                                if (0 < mconfig("level")) {
                                    echo mconfig("level") . " Level ";
                                }
                                if (0 < mconfig("mlevel")) {
                                    echo mconfig("mlevel") . " Master Level ";
                                }
                                if (0 < mconfig("reset")) {
                                    echo mconfig("reset") . " Reset ";
                                }
                                if (0 < mconfig("greset")) {
                                    echo mconfig("greset") . " Grand Reset ";
                                }
                            } else {
                                echo lang("achievement_txt_25", true);
                            }
                            echo "</div>";
                            echo "\r\n                    <div class=\"container_3 account-wide\" align=\"center\">\r\n                        <table class=\"general-table-ui\" width=\"100%\">\r\n                            <tr>\r\n                                <th colspan=\"2\">" . lang("achievement_txt_26", true) . "</th>\r\n                            </tr>";
                            if (1 <= $req_items) {
                                echo "\r\n                            <tr>\r\n                                <td width=\"50%\"><b>" . mconfig("item1_name") . ":</b></td>\r\n                                <td width=\"50%\">" . $unlockData["Item1"] . " / " . $req_item1_count . "</td>\r\n                            </tr>";
                                if (2 <= $req_items) {
                                    echo "\r\n                            <tr>\r\n                                <td width=\"50%\"><b>" . mconfig("item2_name") . ":</b></td>\r\n                                <td width=\"50%\">" . $unlockData["Item2"] . " / " . $req_item2_count . "</td>\r\n                            </tr>";
                                    if (3 <= $req_items) {
                                        echo "\r\n                            <tr>\r\n                                <td width=\"50%\"><b>" . mconfig("item3_name") . ":</b></td>\r\n                                <td width=\"50%\">" . $unlockData["Item3"] . " / " . $req_item3_count . "</td>\r\n                            </tr>";
                                    }
                                }
                            }
                            if (0 < $req_zen) {
                                echo "\r\n                            <tr>\r\n                                <td><b>" . lang("currency_zen", true) . ":</b></td>\r\n                                <td>" . number_format($unlockData["Zen"]) . " / " . number_format($req_zen) . "</td>\r\n                            </tr>";
                            }
                            $characterData = $Character->CharacterData($char);
                            if (0 < mconfig("level")) {
                                echo "\r\n                            <tr>\r\n                                <td><b>" . lang("global_module_5", true) . ":</b></td>\r\n                                <td>" . number_format($characterData["cLevel"]) . " / " . number_format(mconfig("level")) . "</td>\r\n                            </tr>";
                            }
                            if (0 < mconfig("mlevel")) {
                                echo "\r\n                            <tr>\r\n                                <td><b>" . lang("global_module_6", true) . ":</b></td>\r\n                                <td>" . number_format($characterData["mLevel"]) . " / " . number_format(mconfig("mlevel")) . "</td>\r\n                            </tr>";
                            }
                            if (0 < mconfig("reset")) {
                                echo "\r\n                            <tr>\r\n                                <td><b>" . lang("global_module_7", true) . ":</b></td>\r\n                                <td>" . number_format($characterData["RESETS"]) . " / " . number_format(mconfig("reset")) . "</td>\r\n                            </tr>";
                            }
                            if (0 < mconfig("greset")) {
                                echo "\r\n                            <tr>\r\n                                <td><b>" . lang("global_module_8", true) . ":</b></td>\r\n                                <td>" . number_format($characterData["Grand_Resets"]) . " / " . number_format(mconfig("greset")) . "</td>\r\n                            </tr>";
                            }
                            echo "\r\n                        </table>";
                            $can_unlock = true;
                            $other_req = true;
                            if (1 <= $req_items) {
                                if ($req_item1_count > $unlockData["Item1"]) {
                                    $can_unlock = false;
                                }
                                if (2 <= $req_items) {
                                    if ($req_item2_count > $unlockData["Item2"]) {
                                        $can_unlock = false;
                                    }
                                    if (3 <= $req_items && $req_item3_count > $unlockData["Item3"]) {
                                        $can_unlock = false;
                                    }
                                }
                            }
                            if (0 < $req_zen && $req_zen > $unlockData["Zen"]) {
                                $can_unlock = false;
                            }
                            if (0 < mconfig("level") && mconfig("level") > $characterData["cLevel"]) {
                                $can_unlock = false;
                                $other_req = false;
                            }
                            if (0 < mconfig("mlevel") && mconfig("mlevel") > $characterData["mLevel"]) {
                                $can_unlock = false;
                                $other_req = false;
                            }
                            if (0 < mconfig("reset") && mconfig("reset") > $characterData["RESETS"]) {
                                $can_unlock = false;
                                $other_req = false;
                            }
                            if (0 < mconfig("greset") && mconfig("greset") > $characterData["Grand_Resets"]) {
                                $can_unlock = false;
                                $other_req = false;
                            }
                            if ($can_unlock) {
                                echo "\r\n                        <br />\r\n                        <form method=\"post\">\r\n                            <table class=\"general-table-ui\" width=\"100%\">\r\n                                <tr>\r\n                                    <th>" . lang("achievement_txt_27", true) . "</th>\r\n                                </tr>\r\n                                <tr>\r\n                                    <td>\r\n                                        <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                                        <input type=\"submit\" name=\"unlock\" id=\"unlock\" value=\"" . lang("achievement_txt_27", true) . "\">\r\n                                    </td>\r\n                                </tr>\r\n                            </table>\r\n                        </form>";
                            } else {
                                if ($other_req) {
                                    echo "\r\n                        <br />\r\n                        <form method=\"post\">\r\n                            <table class=\"general-table-ui\" width=\"100%\">\r\n                                <tr>\r\n                                    <th colspan=\"2\">" . lang("achievement_txt_28", true) . "</th>\r\n                                </tr>";
                                    if (1 <= $req_items) {
                                        if ($unlockData["Item1"] < $req_item1_count) {
                                            echo "\r\n                                <tr>\r\n                                    <td width=\"50%\"><b>" . lang("achievement_txt_29", true) . " " . mconfig("item1_name") . ":</b></td>\r\n                                    <td width=\"50%\" align=\"left\">\r\n                                        <small>" . lang("achievement_txt_30", true) . " " . number_format($found_item1) . " " . mconfig("item1_name") . "</small><br>\r\n                                        <input type=\"text\" name=\"item1_value\" style=\"width: 200px;\" value=\"0\">\r\n                                        <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                                        <input type=\"submit\" name=\"reg_item1\" id=\"reg_item1\" value=\"" . lang("achievement_txt_29", true) . "\" style=\"width: 140px; margin-top: -1px;\">\r\n                                    </td>\r\n                                </tr>";
                                        }
                                        if (2 <= $req_items) {
                                            if ($unlockData["Item2"] < $req_item2_count) {
                                                echo "\r\n                                <tr>\r\n                                    <td width=\"50%\"><b>" . lang("achievement_txt_29", true) . " " . mconfig("item2_name") . ":</b></td>\r\n                                    <td width=\"50%\" align=\"left\">\r\n                                        <small>" . lang("achievement_txt_30", true) . " " . number_format($found_item2) . " " . mconfig("item2_name") . "</small><br>\r\n                                        <input type=\"text\" name=\"item2_value\" style=\"width: 200px;\" value=\"0\">\r\n                                        <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                                        <input type=\"submit\" name=\"reg_item2\" id=\"reg_item2\" value=\"" . lang("achievement_txt_29", true) . "\" style=\"width: 140px; margin-top: -1px;\">\r\n                                    </td>\r\n                                </tr>";
                                            }
                                            if (3 <= $req_items && $unlockData["Item3"] < $req_item3_count) {
                                                echo "\r\n                                <tr>\r\n                                    <td width=\"50%\"><b>" . lang("achievement_txt_29", true) . " " . mconfig("item3_name") . ":</b></td>\r\n                                    <td width=\"50%\" align=\"left\">\r\n                                        <small>" . lang("achievement_txt_30", true) . " " . number_format($found_item3) . " " . mconfig("item3_name") . "</small><br>\r\n                                        <input type=\"text\" name=\"item3_value\" style=\"width: 200px;\" value=\"0\">\r\n                                        <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                                        <input type=\"submit\" name=\"reg_item3\" id=\"reg_item3\" value=\"" . lang("achievement_txt_29", true) . "\" style=\"width: 140px; margin-top: -1px;\">\r\n                                    </td>\r\n                                </tr>";
                                            }
                                        }
                                    }
                                    if (0 < $req_zen && $unlockData["Zen"] < $req_zen) {
                                        echo "\r\n                                <tr>\r\n                                    <td width=\"50%\"><b>" . lang("achievement_txt_31", true) . ":</b></td>\r\n                                    <td width=\"50%\" align=\"left\">\r\n                                        <small>" . lang("achievement_txt_30", true) . " " . number_format($money) . " " . lang("currency_zen", true) . "</small><br>\r\n                                        <input type=\"text\" name=\"zen_value\" style=\"width: 200px;\" value=\"0\">\r\n                                        <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                                        <input type=\"submit\" name=\"reg_zen\" id=\"reg_zen\" value=\"" . lang("achievement_txt_29", true) . "\" style=\"width: 140px; margin-top: -1px;\">\r\n                                    </td>\r\n                                </tr>";
                                    }
                                    echo "\r\n                            </table>\r\n                        </form>";
                                }
                            }
                            echo "</div>";
                        }
                    }
                }
            } else {
                message("error", lang("achievement_error_4", true));
            }
        } else {
            $chars = $dB->query_fetch("SELECT Name,cLevel,mLevel,RESETS,Grand_Resets,Class from Character where AccountID = ? ORDER BY Grand_Resets desc,RESETS desc,mLevel desc,cLevel desc,Name asc", [$_SESSION["username"]]);
            if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
                echo "\r\n            <div class=\"row desc-row\">\r\n                <div class=\"col-xs-12\">";
            } else {
                echo "<div class=\"page-desc-holder\">";
            }
            if (mconfig("autounlock")) {
                echo lang("achievement_txt_24", true) . " ";
                if (0 < mconfig("level")) {
                    echo "<br>" . mconfig("level") . " Level";
                }
                if (0 < mconfig("mlevel")) {
                    echo "<br>" . mconfig("mlevel") . " Master Level";
                }
                if (0 < mconfig("reset")) {
                    echo "<br>" . mconfig("reset") . " Reset";
                }
                if (0 < mconfig("greset")) {
                    echo "<br>" . mconfig("greset") . " Grand Reset";
                }
            }
            if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
                echo "\r\n                </div>\r\n            </div>";
            } else {
                echo "</div>";
            }
            if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
                echo "\r\n    <div class=\"table-responsive rankings-table\">\r\n        <table class=\"table table-hover text-center\">\r\n            <tr>\r\n                <th class=\"headerRow\" colspan=\"8\">" . lang("global_module_2", true) . "</th>\r\n            </tr>\r\n            <tr>\r\n                <th class=\"headerRow\">" . lang("global_module_3", true) . "</th>\r\n                <th class=\"headerRow\">" . lang("global_module_4", true) . "</th>\r\n                <th class=\"headerRow\">" . lang("global_module_5", true) . "</th>\r\n                <th class=\"headerRow\">" . lang("global_module_6", true) . "</th>";
                if ($config["use_resets"]) {
                    echo "<th class=\"headerRow\">" . lang("global_module_7", true) . "</th>";
                }
                if ($config["use_grand_resets"]) {
                    echo "<th class=\"headerRow\">" . lang("global_module_8", true) . "</th>";
                }
                echo "\r\n                <th class=\"headerRow\">" . lang("global_module_9", true) . "</th>\r\n            </tr>";
                foreach ($chars as $char) {
                    echo "\r\n                <tr>\r\n                    <td><b><a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($char["Name"]) . "/\">" . $common->replaceHtmlSymbols($char["Name"]) . "</a></b></td>\r\n                    <td>" . $custom["character_class"][$char["Class"]][0] . "</td>\r\n                    <td>" . $char["cLevel"] . "</td>\r\n                    <td>" . $char["mLevel"] . "</td>";
                    if ($config["use_resets"]) {
                        echo "<td>" . $char["RESETS"] . "</td>";
                    }
                    if ($config["use_grand_resets"]) {
                        echo "<td>" . $char["Grand_Resets"] . "</td>";
                    } else {
                        echo "</td>";
                    }
                    echo "\r\n                    <td><a href=\"" . __BASE_URL__ . "usercp/achievements/char/" . hex_encode($char["Name"]) . "/\">" . lang("global_module_10", true) . "</a></td>\r\n                </tr>";
                }
                echo "\r\n        </table>\r\n    </div>";
            } else {
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
                    echo "\r\n                <tr>\r\n                    <td><b><a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($char["Name"]) . "/\">" . $common->replaceHtmlSymbols($char["Name"]) . "</a></b></td>\r\n                    <td>" . $custom["character_class"][$char["Class"]][0] . "</td>\r\n                    <td>" . $char["cLevel"] . " [" . $char["mLevel"] . "]</td>";
                    if ($config["use_resets"]) {
                        echo "<td>" . $char["RESETS"];
                    }
                    if ($config["use_grand_resets"]) {
                        echo " [" . $char["Grand_Resets"] . "]</td>";
                    } else {
                        echo "</td>";
                    }
                    echo "\r\n                    <td><a href=\"" . __BASE_URL__ . "usercp/achievements/char/" . hex_encode($char["Name"]) . "/\">" . lang("global_module_10", true) . "</a></td>\r\n                </tr>\r\n                ";
                }
                echo "\r\n            </table>\r\n        </div>";
            }
        }
        if (!defined(__RESPONSIVE__) && __RESPONSIVE__ != "TRUE") {
            echo "\r\n    </div>\r\n</div>";
        }
    }
}

?>