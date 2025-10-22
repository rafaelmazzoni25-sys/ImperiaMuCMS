<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

if (!isLoggedIn()) {
    redirect(1, "login");
} else {
    if (!canAccessModule($_SESSION["username"], "greset", "block")) {
        return NULL;
    }
    $price_type = mconfig("gresets_price_type");
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
    $price_type2 = mconfig("credit_config");
    if ($price_type2 == "1") {
        $price_type2 = lang("currency_platinum", true);
    } else {
        if ($price_type2 == "2") {
            $price_type2 = lang("currency_gold", true);
        } else {
            if ($price_type2 == "3") {
                $price_type2 = lang("currency_silver", true);
            } else {
                if ($price_type2 == "4") {
                    $price_type2 = lang("currency_wcoinc", true);
                } else {
                    if ($price_type2 == "5") {
                        $price_type2 = lang("currency_gp", true);
                    } else {
                        if ($price_type2 == "6") {
                            $price_type2 = "" . lang("currency_zen", true) . "";
                        }
                    }
                }
            }
        }
    }
    if (mconfig("gresets_enable_requirement")) {
        if (mconfig("gresets_price_formula")) {
            $requirement = ", " . lang("global_module_7", true) . " " . mconfig("gresets_required_reset") . ", " . number_format(mconfig("gresets_price")) . " * (" . lang("global_module_8", true) . " + 1) " . $price_type;
        } else {
            $requirement = ", " . lang("global_module_7", true) . " " . mconfig("gresets_required_reset") . ", " . number_format(mconfig("gresets_price")) . " " . $price_type;
        }
    } else {
        $requirement = "" . lang("global_module_7", true) . " " . mconfig("gresets_required_reset");
    }
    if (0 < mconfig("gresets_required_mlevel")) {
        $mlvl_req = ", " . lang("global_module_6", true) . " " . mconfig("gresets_required_mlevel");
    } else {
        $mlvl_req = "";
    }
    if (mconfig("gresets_enable_credit_reward")) {
        $reward = "<br /><b>" . lang("greset_txt_1", true) . "</b> " . number_format(mconfig("gresets_credits_reward")) . " ";
        if (mconfig("gresets_reward_formula") == 2) {
            $reward .= " + (" . number_format(mconfig("gresets_credits_reward2")) . " * (" . lang("global_module_8", true) . " + 1)) ";
        } else {
            if (mconfig("gresets_reward_formula") == 1) {
                $reward .= " * (" . lang("global_module_8", true) . " + 1) ";
            }
        }
        $reward .= $price_type2;
    } else {
        $reward = "";
    }
    if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
        $breadcrumb = generateBreadcrumb();
        echo "\r\n    <h3>\r\n        " . lang("greset_txt_2", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
        if (mconfig("active")) {
            echo "\r\n    <div class=\"row desc-row\">\r\n        <div class=\"col-xs-12\">\r\n            <b>" . lang("greset_txt_3", true) . "</b> " . lang("global_module_5", true) . " " . mconfig("gresets_required_level") . $mlvl_req . $requirement . "\r\n            " . $reward . "\r\n            <br /><b>" . lang("greset_txt_4", true) . "</b> " . mconfig("gresets_limit") . "\r\n        </div>\r\n    </div>";
            $Character = new Character();
            $AccountCharacters = $Character->AccountCharacter($_SESSION["username"]);
            if (is_array($AccountCharacters)) {
                if (check_value($_POST["submit"])) {
                    if ($_SESSION["token"] == $_POST["token"]) {
                        if ($common->beginDbTrans($_SESSION["username"])) {
                            $Character->CharacterGReset($_SESSION["username"], $_POST["character"], $_SESSION["userid"]);
                            $common->endDbTrans($_SESSION["username"]);
                        }
                    } else {
                        message("notice", lang("global_module_13", true));
                    }
                }
                $token = time();
                $_SESSION["token"] = $token;
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
                    echo "\r\n            <form action=\"\" method=\"post\">\r\n                <input type=\"hidden\" name=\"character\" value=\"" . Encode($characterData[_CLMN_CHR_NAME_]) . "\"/>\r\n                <tr>\r\n                    <td>" . $characterIMG . "</td>\r\n                    <td>" . $common->replaceHtmlSymbols($characterData[_CLMN_CHR_NAME_]) . "</td>\r\n                    <td>" . $characterData[_CLMN_CHR_LVL_] . "</td>\r\n                    <td>" . $characterData["mLevel"] . "</td>";
                    if ($config["use_resets"]) {
                        echo "<td>" . $characterData[_CLMN_CHR_RSTS_] . "</td>";
                    }
                    if ($config["use_grand_resets"]) {
                        echo "<td>" . $characterData["Grand_Resets"] . "</td>";
                    }
                    echo "<td>" . number_format($characterData[_CLMN_CHR_ZEN_]) . "</td>";
                    $lacking = NULL;
                    if (mconfig("gresets_limit") <= $characterData["Grand_Resets"]) {
                        $lacking = lang("greset_txt_5", true);
                    } else {
                        if ($characterData[_CLMN_CHR_LVL_] < mconfig("gresets_required_level")) {
                            $lvl_lacking = mconfig("gresets_required_level") - $characterData[_CLMN_CHR_LVL_];
                            if ($lacking == NULL) {
                                $lacking = sprintf(lang("resetcharacter_txt_20", true), $lvl_lacking);
                            } else {
                                $lacking .= sprintf(lang("resetcharacter_txt_23", true), $lvl_lacking);
                            }
                        }
                        if ($characterData[_CLMN_CHR_RSTS_] < mconfig("gresets_required_reset")) {
                            $reset_lacking = mconfig("gresets_required_reset") - $characterData[_CLMN_CHR_RSTS_];
                            if ($lacking == NULL) {
                                $lacking = sprintf(lang("greset_txt_6", true), $reset_lacking);
                            } else {
                                $lacking .= sprintf(lang("greset_txt_7", true), $reset_lacking);
                            }
                        }
                        if ($characterData["mLevel"] < mconfig("gresets_required_mlevel")) {
                            $mlvl_lacking = mconfig("gresets_required_mlevel") - $characterData["mLevel"];
                            if ($lacking == NULL) {
                                $lacking = sprintf(lang("resetcharacter_txt_21", true), $mlvl_lacking);
                            } else {
                                $lacking .= sprintf(lang("resetcharacter_txt_24", true), $mlvl_lacking);
                            }
                        }
                        if (mconfig("gresets_enable_requirement")) {
                            mconfig("gresets_price_type");
                            switch (mconfig("gresets_price_type")) {
                                case 1:
                                    $return["column"] = "platinum";
                                    $return["table"] = "MEMB_CREDITS";
                                    $return["ident"] = "memb___id";
                                    $return["name"] = lang("currency_platinum", true);
                                    if ($config["MEMB_CREDITS_MEMUONLINE"]) {
                                        $checkCurrency = $dB2->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$_SESSION["username"]]);
                                    } else {
                                        $checkCurrency = $dB->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$_SESSION["username"]]);
                                    }
                                    break;
                                case 2:
                                    $return["column"] = "gold";
                                    $return["table"] = "MEMB_CREDITS";
                                    $return["ident"] = "memb___id";
                                    $return["name"] = lang("currency_gold", true);
                                    if ($config["MEMB_CREDITS_MEMUONLINE"]) {
                                        $checkCurrency = $dB2->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$_SESSION["username"]]);
                                    } else {
                                        $checkCurrency = $dB->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$_SESSION["username"]]);
                                    }
                                    break;
                                case 3:
                                    $return["column"] = "silver";
                                    $return["table"] = "MEMB_CREDITS";
                                    $return["ident"] = "memb___id";
                                    $return["name"] = lang("currency_silver", true);
                                    if ($config["MEMB_CREDITS_MEMUONLINE"]) {
                                        $checkCurrency = $dB2->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$_SESSION["username"]]);
                                    } else {
                                        $checkCurrency = $dB->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$_SESSION["username"]]);
                                    }
                                    break;
                                case 4:
                                    if (100 <= config("server_files_season", true)) {
                                        $return["column"] = "WCoin";
                                    } else {
                                        $return["column"] = "WCoinC";
                                    }
                                    $return["table"] = "T_InGameShop_Point";
                                    $return["ident"] = "AccountID";
                                    $return["name"] = lang("currency_wcoinc", true);
                                    $checkCurrency = $dB->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$_SESSION["username"]]);
                                    break;
                                case 5:
                                    $return["column"] = "GoblinPoint";
                                    $return["table"] = "T_InGameShop_Point";
                                    $return["ident"] = "AccountID";
                                    $return["name"] = lang("currency_gp", true);
                                    $checkCurrency = $dB->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$_SESSION["username"]]);
                                    break;
                                case 6:
                                    $return["column"] = "Money";
                                    $return["table"] = "Character";
                                    $return["ident"] = "AccountID";
                                    $return["name"] = "" . lang("currency_zen", true) . "";
                                    $checkCurrency = $dB->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ? AND Name = ?", [$_SESSION["username"], $characterData["Name"]]);
                                    break;
                                default:
                                    if (mconfig("gresets_price_formula")) {
                                        $gresets_price = mconfig("gresets_price") * ($characterData["Grand_Resets"] + 1);
                                    } else {
                                        $gresets_price = mconfig("gresets_price");
                                    }
                                    if ($checkCurrency[$return["column"]] < $gresets_price) {
                                        $currency_lacking = $gresets_price - $checkCurrency[$return["column"]];
                                        if ($lacking == NULL) {
                                            $lacking = lang("resetcharacter_txt_22", true) . " " . number_format($currency_lacking) . " " . $price_type;
                                        } else {
                                            $lacking .= ", " . number_format($currency_lacking) . " " . $price_type;
                                        }
                                    }
                            }
                        }
                        if (0 < mconfig("time")) {
                            $checkTime = $dB->query_fetch_single("SELECT TOP 1 * FROM IMPERIAMUCMS_CHARACTER_PROGRESS_LOGS \r\n                                                          WHERE AccountID = ? AND Name = ? AND Type = ? AND NewValue > 0\r\n                                                          ORDER BY Date DESC", [$_SESSION["username"], $characterData["Name"], 2]);
                            if ($checkTime["Date"] != NULL) {
                                $resetTime = strtotime($checkTime["Date"]) + mconfig("time") * 60;
                                if (time() < $resetTime) {
                                    $wait = $resetTime - time();
                                    $hours = $wait / 3600;
                                    $wait = $wait % 3600;
                                    $minutes = $wait / 60;
                                    $seconds = $wait % 60;
                                    $lacking = sprintf(lang("resetcharacter_txt_36", true), $hours, $minutes, $seconds);
                                }
                            }
                        }
                    }
                    if ($lacking == NULL) {
                        echo "\r\n                        <td>\r\n                            <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                            <button name=\"submit\" value=\"submit\" class=\"btn btn-warning full-width-btn\">\r\n                                " . lang("resetcharacter_txt_5", true) . "\r\n                            </button>\r\n                        </td>";
                    } else {
                        echo "<td>" . $lacking . "</td>";
                    }
                    echo "\r\n                    </tr>\r\n\t\t\t\t</form>";
                }
                echo "\r\n        </table>\r\n    </div>";
            } else {
                message("error", lang("error_46", true));
            }
        } else {
            message("error", lang("error_47", true));
        }
    } else {
        echo "\r\n<div class=\"sub-page-title\">\r\n    <div id=\"title\">\r\n        <h1>" . lang("module_titles_txt_3", true) . "<p></p><span></span></h1>\r\n    </div>\r\n</div>\r\n\r\n<div class=\"container_2 account\" align=\"center\">\r\n    <div class=\"cont-image\">\r\n        <div class=\"container_3 account_sub_header\">\r\n            <div class=\"grad\">\r\n                <div class=\"page-title\"><p>" . lang("greset_txt_2", true) . "</p></div>\r\n                <a href=\"" . __BASE_URL__ . "usercp\">" . lang("global_module_1", true) . "</a>\r\n            </div>\r\n        </div>\r\n        <div class=\"page-desc-holder\">\r\n            <b>" . lang("greset_txt_3", true) . "</b> " . lang("global_module_5", true) . " " . mconfig("gresets_required_level") . $mlvl_req . $requirement . "\r\n            " . $reward . "\r\n            <br /><b>" . lang("greset_txt_4", true) . "</b> " . mconfig("gresets_limit") . "\r\n        </div>";
        if (mconfig("active")) {
            $Character = new Character();
            $AccountCharacters = $Character->AccountCharacter($_SESSION["username"]);
            if (is_array($AccountCharacters)) {
                if (check_value($_POST["submit"])) {
                    if ($_SESSION["token"] == $_POST["token"]) {
                        $Character->CharacterGReset($_SESSION["username"], $_POST["character"], $_SESSION["userid"]);
                    } else {
                        message("notice", lang("global_module_13", true));
                    }
                }
                $token = time();
                $_SESSION["token"] = $token;
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
                    $lacking = NULL;
                    if (mconfig("gresets_limit") <= $characterData["Grand_Resets"]) {
                        $lacking = lang("greset_txt_5", true);
                    } else {
                        if ($characterData[_CLMN_CHR_LVL_] < mconfig("gresets_required_level")) {
                            $lvl_lacking = mconfig("gresets_required_level") - $characterData[_CLMN_CHR_LVL_];
                            if ($lacking == NULL) {
                                $lacking = sprintf(lang("resetcharacter_txt_20", true), $lvl_lacking);
                            } else {
                                $lacking .= sprintf(lang("resetcharacter_txt_23", true), $lvl_lacking);
                            }
                        }
                        if ($characterData[_CLMN_CHR_RSTS_] < mconfig("gresets_required_reset")) {
                            $reset_lacking = mconfig("gresets_required_reset") - $characterData[_CLMN_CHR_RSTS_];
                            if ($lacking == NULL) {
                                $lacking = sprintf(lang("greset_txt_6", true), $reset_lacking);
                            } else {
                                $lacking .= sprintf(lang("greset_txt_7", true), $reset_lacking);
                            }
                        }
                        if ($characterData["mLevel"] < mconfig("gresets_required_mlevel")) {
                            $mlvl_lacking = mconfig("gresets_required_mlevel") - $characterData["mLevel"];
                            if ($lacking == NULL) {
                                $lacking = sprintf(lang("resetcharacter_txt_21", true), $mlvl_lacking);
                            } else {
                                $lacking .= sprintf(lang("resetcharacter_txt_24", true), $mlvl_lacking);
                            }
                        }
                        if (mconfig("gresets_enable_requirement")) {
                            mconfig("gresets_price_type");
                            switch (mconfig("gresets_price_type")) {
                                case 1:
                                    $return["column"] = "platinum";
                                    $return["table"] = "MEMB_CREDITS";
                                    $return["ident"] = "memb___id";
                                    $return["name"] = lang("currency_platinum", true);
                                    if ($config["MEMB_CREDITS_MEMUONLINE"]) {
                                        $checkCurrency = $dB2->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$_SESSION["username"]]);
                                    } else {
                                        $checkCurrency = $dB->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$_SESSION["username"]]);
                                    }
                                    break;
                                case 2:
                                    $return["column"] = "gold";
                                    $return["table"] = "MEMB_CREDITS";
                                    $return["ident"] = "memb___id";
                                    $return["name"] = lang("currency_gold", true);
                                    if ($config["MEMB_CREDITS_MEMUONLINE"]) {
                                        $checkCurrency = $dB2->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$_SESSION["username"]]);
                                    } else {
                                        $checkCurrency = $dB->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$_SESSION["username"]]);
                                    }
                                    break;
                                case 3:
                                    $return["column"] = "silver";
                                    $return["table"] = "MEMB_CREDITS";
                                    $return["ident"] = "memb___id";
                                    $return["name"] = lang("currency_silver", true);
                                    if ($config["MEMB_CREDITS_MEMUONLINE"]) {
                                        $checkCurrency = $dB2->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$_SESSION["username"]]);
                                    } else {
                                        $checkCurrency = $dB->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$_SESSION["username"]]);
                                    }
                                    break;
                                case 4:
                                    if (100 <= config("server_files_season", true)) {
                                        $return["column"] = "WCoin";
                                    } else {
                                        $return["column"] = "WCoinC";
                                    }
                                    $return["table"] = "T_InGameShop_Point";
                                    $return["ident"] = "AccountID";
                                    $return["name"] = lang("currency_wcoinc", true);
                                    $checkCurrency = $dB->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$_SESSION["username"]]);
                                    break;
                                case 5:
                                    $return["column"] = "GoblinPoint";
                                    $return["table"] = "T_InGameShop_Point";
                                    $return["ident"] = "AccountID";
                                    $return["name"] = lang("currency_gp", true);
                                    $checkCurrency = $dB->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$_SESSION["username"]]);
                                    break;
                                case 6:
                                    $return["column"] = "Money";
                                    $return["table"] = "Character";
                                    $return["ident"] = "AccountID";
                                    $return["name"] = "" . lang("currency_zen", true) . "";
                                    $checkCurrency = $dB->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ? AND Name = ?", [$_SESSION["username"], $characterData["Name"]]);
                                    break;
                                default:
                                    if (mconfig("gresets_price_formula")) {
                                        $gresets_price = mconfig("gresets_price") * ($characterData["Grand_Resets"] + 1);
                                    } else {
                                        $gresets_price = mconfig("gresets_price");
                                    }
                                    if ($checkCurrency[$return["column"]] < $gresets_price) {
                                        $currency_lacking = $gresets_price - $checkCurrency[$return["column"]];
                                        if ($lacking == NULL) {
                                            $lacking = lang("resetcharacter_txt_22", true) . " " . number_format($currency_lacking) . " " . $price_type;
                                        } else {
                                            $lacking .= ", " . number_format($currency_lacking) . " " . $price_type;
                                        }
                                    }
                            }
                        }
                        if (0 < mconfig("time")) {
                            $checkTime = $dB->query_fetch_single("SELECT TOP 1 * FROM IMPERIAMUCMS_CHARACTER_PROGRESS_LOGS \r\n                                                          WHERE AccountID = ? AND Name = ? AND Type = ? AND NewValue > 0\r\n                                                          ORDER BY Date DESC", [$_SESSION["username"], $characterData["Name"], 2]);
                            if ($checkTime["Date"] != NULL) {
                                $resetTime = strtotime($checkTime["Date"]) + mconfig("time") * 60;
                                if (time() < $resetTime) {
                                    $wait = $resetTime - time();
                                    $hours = $wait / 3600;
                                    $wait = $wait % 3600;
                                    $minutes = $wait / 60;
                                    $seconds = $wait % 60;
                                    $lacking = sprintf(lang("resetcharacter_txt_36", true), $hours, $minutes, $seconds);
                                }
                            }
                        }
                    }
                    if ($lacking == NULL) {
                        echo "<td><input type=\"hidden\" name=\"token\" value=\"" . $token . "\"><button name=\"submit\" value=\"submit\" class=\"ui-button button1\" ><span class=\"button-left\"><span class=\"button-right\">" . lang("resetcharacter_txt_5", true) . "</span></span></button></td></tr>";
                    } else {
                        echo "<td>" . $lacking . "</td>";
                    }
                    echo "\r\n\t\t\t\t\t\t\t</form>";
                }
                echo "</table>";
            } else {
                message("error", lang("error_46", true));
            }
        } else {
            message("error", lang("error_47", true));
        }
        echo "\r\n        </div>\r\n\t</div>\r\n</div>";
    }
}

?>