<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

if (!isLoggedIn()) {
    redirect(1, "login");
} else {
    if (!canAccessModule($_SESSION["username"], "reset", "block")) {
        return NULL;
    }
    $Character = new Character();
    $Items = new Items();
    if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
        $breadcrumb = generateBreadcrumb();
        echo "\r\n    <h3>\r\n        " . lang("module_titles_txt_12", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
        if (mconfig("active")) {
            echo "<script type=\"text/javascript\" SRC=\"" . __PATH_TEMPLATE_ASSETS__ . "js/tooltip.js\"></script>";
            echo "\r\n    <div class=\"row desc-row\">\r\n        <div class=\"col-xs-12\">" . lang("resetcharacter_txt_14", true) . "</div>\r\n    </div>";
            if (isset($_GET["char"])) {
                $charName = hex_decode($_GET["char"]);
                $charData = $dB->query_fetch_single("SELECT AccountID,Name,cLevel,mLevel,RESETS,Grand_Resets,Class,CONVERT(VARCHAR(MAX), Inventory, 2) as Inventory FROM Character WHERE AccountID = ? AND Name = ?", [$_SESSION["username"], $charName]);
                $resetStages = $Character->findResetTypesStage($charData["RESETS"]);
                $normalReset = $resetStages["normalReset"];
                $gpReset = $resetStages["gpReset"];
                $wcoinReset = $resetStages["wcoinReset"];
                $reqNormalReset = $Character->checkReqResetType($_SESSION["username"], $charData, $normalReset);
                $reqGpReset = $Character->checkReqResetType($_SESSION["username"], $charData, $gpReset);
                $reqWcoinReset = $Character->checkReqResetType($_SESSION["username"], $charData, $wcoinReset);
                echo "\r\n    <div class=\"table-responsive rankings-table\">\r\n        <table class=\"table table-hover text-center\">\r\n            <tr>\r\n                <th class=\"headerRow\" colspan=\"5\"><b><a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($charData["Name"]) . "/\">" . $common->replaceHtmlSymbols($charData["Name"]) . "</a></b></th>\r\n            </tr>\r\n            <tr>\r\n                <th class=\"headerRow\">" . lang("global_module_4", true) . "</th>\r\n                <th class=\"headerRow\">" . lang("global_module_5", true) . "</th>\r\n                <th class=\"headerRow\">" . lang("global_module_6", true) . "</th>";
                if ($config["use_resets"]) {
                    echo "<th class=\"headerRow\">" . lang("global_module_7", true) . "</th>";
                }
                if ($config["use_grand_resets"]) {
                    echo "<th class=\"headerRow\">" . lang("global_module_8", true) . "</th>";
                }
                echo "\r\n            </tr>\r\n                <tr>\r\n                    <td>" . $custom["character_class"][$charData["Class"]][0] . "</td>\r\n                    <td>" . $charData["cLevel"] . "</td>\r\n                    <td>" . $charData["mLevel"] . "</td>";
                if ($config["use_resets"]) {
                    echo "<td>" . $charData["RESETS"] . "</td>";
                }
                if ($config["use_grand_resets"]) {
                    echo "<td>" . $charData["Grand_Resets"] . "</td>";
                } else {
                    echo "</td>";
                }
                $reqStatus = [];
                foreach ($reqNormalReset as $key => $val) {
                    if ($val) {
                        $reqStatus["normal"][$key] = "<i class=\"fa fa-check req-success\" aria-hidden=\"true\"></i>";
                    } else {
                        $reqStatus["normal"][$key] = "<i class=\"fa fa-times req-danger\" aria-hidden=\"true\"></i>";
                    }
                }
                foreach ($reqGpReset as $key => $val) {
                    if ($val) {
                        $reqStatus["gp"][$key] = "<i class=\"fa fa-check req-success\" aria-hidden=\"true\"></i>";
                    } else {
                        $reqStatus["gp"][$key] = "<i class=\"fa fa-times req-danger\" aria-hidden=\"true\"></i>";
                    }
                }
                foreach ($reqWcoinReset as $key => $val) {
                    if ($val) {
                        $reqStatus["wcoin"][$key] = "<i class=\"fa fa-check req-success\" aria-hidden=\"true\"></i>";
                    } else {
                        $reqStatus["wcoin"][$key] = "<i class=\"fa fa-times req-danger\" aria-hidden=\"true\"></i>";
                    }
                }
                echo "\r\n                </tr>\r\n        </table>\r\n    </div>\r\n    <div class=\"table-responsive rankings-table\">\r\n        <table class=\"table table-hover text-center\">\r\n            <tr>\r\n                <th class=\"headerRow\" width=\"25%\"></th>\r\n                <th class=\"headerRow\" width=\"25%\">" . lang("resetcharacter_txt_43", true) . "</th>\r\n                <th class=\"headerRow\" width=\"25%\">" . lang("resetcharacter_txt_44", true) . "</th>\r\n                <th class=\"headerRow\" width=\"25%\">" . lang("resetcharacter_txt_45", true) . "</th>\r\n            </tr>\r\n            <tr>\r\n                <th class=\"headerRow\">" . lang("resetcharacter_txt_46", true) . "</th>\r\n                <td>" . $normalReset["@attributes"]["req_lvl"] . " " . $reqStatus["normal"]["req_lvl"] . "</td>\r\n                <td>" . $gpReset["@attributes"]["req_lvl"] . " " . $reqStatus["gp"]["req_lvl"] . "</td>\r\n                <td class=\"ranking-wcoins-reset-highlight\">" . $wcoinReset["@attributes"]["req_lvl"] . " " . $reqStatus["wcoin"]["req_lvl"] . "</td>\r\n            </tr>";
                if (0 < $normalReset["@attributes"]["req_mlvl"] || 0 < $gpReset["@attributes"]["req_mlvl"] || 0 < $wcoinReset["@attributes"]["req_mlvl"]) {
                    echo "\r\n            <tr>\r\n                <th class=\"headerRow\">" . lang("resetcharacter_txt_47", true) . "</th>\r\n                <td>" . $normalReset["@attributes"]["req_mlvl"] . " " . $reqStatus["normal"]["req_mlvl"] . "</td>\r\n                <td>" . $gpReset["@attributes"]["req_mlvl"] . " " . $reqStatus["gp"]["req_mlvl"] . "</td>\r\n                <td class=\"ranking-wcoins-reset-highlight\">" . $wcoinReset["@attributes"]["req_mlvl"] . " " . $reqStatus["wcoin"]["req_mlvl"] . "</td>\r\n            </tr>";
                }
                if (0 < $normalReset["@attributes"]["price_req"] || 0 < $gpReset["@attributes"]["price_req"] || 0 < $wcoinReset["@attributes"]["price_req"]) {
                    $normalPrice = $normalReset["@attributes"]["price"];
                    if ($normalReset["@attributes"]["price_formula"] == "1") {
                        $normalPrice = ($charData["RESETS"] + 1) * $normalReset["@attributes"]["price"];
                    }
                    $gpPrice = $normalReset["@attributes"]["price"];
                    if ($gpReset["@attributes"]["price_formula"] == "1") {
                        $gpPrice = ($charData["RESETS"] + 1) * $gpReset["@attributes"]["price"];
                    }
                    $wcoinPrice = $normalReset["@attributes"]["price"];
                    if ($wcoinReset["@attributes"]["price_formula"] == "1") {
                        $wcoinPrice = ($charData["RESETS"] + 1) * $wcoinReset["@attributes"]["price"];
                    }
                    echo "\r\n            <tr>\r\n                <th class=\"headerRow\">" . lang("resetcharacter_txt_48", true) . "</th>\r\n                <td>" . number_format($normalPrice) . " " . $Character->getCurrencyName($normalReset["@attributes"]["price_type"]) . " " . $reqStatus["normal"]["req_price"] . "</td>\r\n                <td>" . number_format($gpPrice) . " " . $Character->getCurrencyName($gpReset["@attributes"]["price_type"]) . " " . $reqStatus["gp"]["req_price"] . "</td>\r\n                <td class=\"ranking-wcoins-reset-highlight\">" . number_format($wcoinPrice) . " " . $Character->getCurrencyName($wcoinReset["@attributes"]["price_type"]) . " " . $reqStatus["wcoin"]["req_price"] . "</td>\r\n            </tr>";
                }
                if (0 < $normalReset["@attributes"]["apply_equip_check"] || 0 < $gpReset["@attributes"]["apply_equip_check"] || 0 < $wcoinReset["@attributes"]["apply_equip_check"]) {
                    $slotsCheck = "";
                    if (mconfig("check_equip_0")) {
                        $slotsCheck .= "<br>" . lang("resetcharacter_txt_51", true);
                    }
                    if (mconfig("check_equip_1")) {
                        $slotsCheck .= "<br>" . lang("resetcharacter_txt_52", true);
                    }
                    if (mconfig("check_equip_2")) {
                        $slotsCheck .= "<br>" . lang("resetcharacter_txt_53", true);
                    }
                    if (mconfig("check_equip_3")) {
                        $slotsCheck .= "<br>" . lang("resetcharacter_txt_54", true);
                    }
                    if (mconfig("check_equip_4")) {
                        $slotsCheck .= "<br>" . lang("resetcharacter_txt_55", true);
                    }
                    if (mconfig("check_equip_5")) {
                        $slotsCheck .= "<br>" . lang("resetcharacter_txt_56", true);
                    }
                    if (mconfig("check_equip_6")) {
                        $slotsCheck .= "<br>" . lang("resetcharacter_txt_57", true);
                    }
                    if (mconfig("check_equip_7")) {
                        $slotsCheck .= "<br>" . lang("resetcharacter_txt_58", true);
                    }
                    if (mconfig("check_equip_8")) {
                        $slotsCheck .= "<br>" . lang("resetcharacter_txt_59", true);
                    }
                    if (mconfig("check_equip_9")) {
                        $slotsCheck .= "<br>" . lang("resetcharacter_txt_60", true);
                    }
                    if (mconfig("check_equip_10")) {
                        $slotsCheck .= "<br>" . lang("resetcharacter_txt_61", true);
                    }
                    if (mconfig("check_equip_11")) {
                        $slotsCheck .= "<br>" . lang("resetcharacter_txt_62", true);
                    }
                    if (mconfig("check_equip_236")) {
                        $slotsCheck .= "<br>" . lang("resetcharacter_txt_63", true);
                    }
                    if (mconfig("check_equip_237")) {
                        $slotsCheck .= "<br>" . lang("resetcharacter_txt_64", true);
                    }
                    if (mconfig("check_equip_238")) {
                        $slotsCheck .= "<br>" . lang("resetcharacter_txt_65", true);
                    }
                    $equipNormalInfo = "<i class=\"fa fa-check req-success\" aria-hidden=\"true\"></i>";
                    if (0 < $normalReset["@attributes"]["apply_equip_check"]) {
                        $equipNormalInfo = "<i class=\"fa fa-info-circle req-info\" aria-hidden=\"true\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"" . lang("resetcharacter_txt_50", true) . $slotsCheck . "\"></i>";
                    }
                    $equipGpInfo = "<i class=\"fa fa-check req-success\" aria-hidden=\"true\"></i>";
                    if (0 < $gpReset["@attributes"]["apply_equip_check"]) {
                        $equipGpInfo = "<i class=\"fa fa-info-circle req-info\" aria-hidden=\"true\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"" . lang("resetcharacter_txt_50", true) . $slotsCheck . "\"></i>";
                    }
                    $equipWcoinInfo = "<i class=\"fa fa-check req-success\" aria-hidden=\"true\"></i>";
                    if (0 < $wcoinReset["@attributes"]["apply_equip_check"]) {
                        $equipWcoinInfo = "<i class=\"fa fa-info-circle req-info\" aria-hidden=\"true\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"" . lang("resetcharacter_txt_50", true) . $slotsCheck . "\"></i>";
                    }
                    echo "\r\n            <tr>\r\n                <th class=\"headerRow\">" . lang("resetcharacter_txt_49", true) . "</th>\r\n                <td>" . $reqStatus["normal"]["equip"] . " " . $equipNormalInfo . "</td>\r\n                <td>" . $reqStatus["gp"]["equip"] . " " . $equipGpInfo . "</td>\r\n                <td class=\"ranking-wcoins-reset-highlight\">" . $reqStatus["wcoin"]["equip"] . " " . $equipWcoinInfo . "</td>\r\n            </tr>";
                }
                if (0 < $normalReset["@attributes"]["items_req"] || 0 < $gpReset["@attributes"]["items_req"] || 0 < $wcoinReset["@attributes"]["items_req"]) {
                    echo "<script type=\"text/javascript\" src=\"" . __PATH_TEMPLATE_ASSETS__ . "js/tooltip.js\"></script>";
                    $Items = new Items();
                    if (0 < $normalReset["@attributes"]["items_req"]) {
                        $reqItemsNormal = "";
                        foreach ($normalReset["req_items"] as $thisItem) {
                            $itemInfo = $Items->ItemInfo($thisItem["@attributes"]["hexcode"]);
                            if ($reqItemsNormal != "") {
                                $reqItemsNormal .= "<br>";
                            }
                            $checkedOpts = "";
                            if ($thisItem["@attributes"]["level"] == "1") {
                                $checkedOpts .= "<br>" . lang("resetcharacter_txt_68", true);
                            }
                            if ($thisItem["@attributes"]["option"] == "1") {
                                $checkedOpts .= "<br>" . lang("resetcharacter_txt_69", true);
                            }
                            if ($thisItem["@attributes"]["durability"] == "1") {
                                $checkedOpts .= "<br>" . lang("resetcharacter_txt_70", true);
                            }
                            if ($thisItem["@attributes"]["luck"] == "1") {
                                $checkedOpts .= "<br>" . lang("resetcharacter_txt_71", true);
                            }
                            if ($thisItem["@attributes"]["skill"] == "1") {
                                $checkedOpts .= "<br>" . lang("resetcharacter_txt_72", true);
                            }
                            if ($thisItem["@attributes"]["excellent"] == "1") {
                                $checkedOpts .= "<br>" . lang("resetcharacter_txt_73", true);
                            }
                            if ($thisItem["@attributes"]["ancient"] == "1") {
                                $checkedOpts .= "<br>" . lang("resetcharacter_txt_74", true);
                            }
                            if ($thisItem["@attributes"]["harmony"] == "1") {
                                $checkedOpts .= "<br>" . lang("resetcharacter_txt_75", true);
                            }
                            if ($thisItem["@attributes"]["guardian"] == "1") {
                                $checkedOpts .= "<br>" . lang("resetcharacter_txt_76", true);
                            }
                            if ($thisItem["@attributes"]["socket"] == "1") {
                                $checkedOpts .= "<br>" . lang("resetcharacter_txt_77", true);
                            }
                            $reqItemsNormal .= "<span style=\"cursor: pointer;\" onmouseover=\"Tip(" . $Items->generateItemTooltip($itemInfo, 1, 0, 0, 1, 0, 0) . ")\" onmouseout=\"UnTip()\">" . $itemInfo["name"] . "</span> (" . $thisItem["@attributes"]["count"] . "x) \r\n                            <i class=\"fa fa-info-circle req-info\" aria-hidden=\"true\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"" . lang("resetcharacter_txt_67", true) . $checkedOpts . "\"></i>";
                        }
                    } else {
                        $reqItemsNormal = "<i class=\"fa fa-check req-success\" aria-hidden=\"true\"></i>";
                    }
                    if (0 < $gpReset["@attributes"]["items_req"]) {
                        $reqItemsGP = "";
                        foreach ($gpReset["req_items"] as $thisItem) {
                            $itemInfo = $Items->ItemInfo($thisItem["@attributes"]["hexcode"]);
                            if ($reqItemsGP != "") {
                                $reqItemsGP .= "<br>";
                            }
                            $checkedOpts = "";
                            if ($thisItem["@attributes"]["level"] == "1") {
                                $checkedOpts .= "<br>" . lang("resetcharacter_txt_68", true);
                            }
                            if ($thisItem["@attributes"]["option"] == "1") {
                                $checkedOpts .= "<br>" . lang("resetcharacter_txt_69", true);
                            }
                            if ($thisItem["@attributes"]["durability"] == "1") {
                                $checkedOpts .= "<br>" . lang("resetcharacter_txt_70", true);
                            }
                            if ($thisItem["@attributes"]["luck"] == "1") {
                                $checkedOpts .= "<br>" . lang("resetcharacter_txt_71", true);
                            }
                            if ($thisItem["@attributes"]["skill"] == "1") {
                                $checkedOpts .= "<br>" . lang("resetcharacter_txt_72", true);
                            }
                            if ($thisItem["@attributes"]["excellent"] == "1") {
                                $checkedOpts .= "<br>" . lang("resetcharacter_txt_73", true);
                            }
                            if ($thisItem["@attributes"]["ancient"] == "1") {
                                $checkedOpts .= "<br>" . lang("resetcharacter_txt_74", true);
                            }
                            if ($thisItem["@attributes"]["harmony"] == "1") {
                                $checkedOpts .= "<br>" . lang("resetcharacter_txt_75", true);
                            }
                            if ($thisItem["@attributes"]["guardian"] == "1") {
                                $checkedOpts .= "<br>" . lang("resetcharacter_txt_76", true);
                            }
                            if ($thisItem["@attributes"]["socket"] == "1") {
                                $checkedOpts .= "<br>" . lang("resetcharacter_txt_77", true);
                            }
                            $reqItemsGP .= "<span style=\"cursor: pointer;\" onmouseover=\"Tip(" . $Items->generateItemTooltip($itemInfo, 1, 0, 0, 1, 0, 0) . ")\" onmouseout=\"UnTip()\">" . $itemInfo["name"] . "</span> (" . $thisItem["@attributes"]["count"] . "x) \r\n                            <i class=\"fa fa-info-circle req-info\" aria-hidden=\"true\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"" . lang("resetcharacter_txt_67", true) . $checkedOpts . "\"></i>";
                        }
                    } else {
                        $reqItemsGP = "<i class=\"fa fa-check req-success\" aria-hidden=\"true\"></i>";
                    }
                    if (0 < $wcoinReset["@attributes"]["items_req"]) {
                        $reqItemsWcoin = "";
                        foreach ($wcoinReset["req_items"] as $thisItem) {
                            $itemInfo = $Items->ItemInfo($thisItem["@attributes"]["hexcode"]);
                            if ($reqItemsWcoin != "") {
                                $reqItemsWcoin .= "<br>";
                            }
                            $checkedOpts = "";
                            if ($thisItem["@attributes"]["level"] == "1") {
                                $checkedOpts .= "<br>" . lang("resetcharacter_txt_68", true);
                            }
                            if ($thisItem["@attributes"]["option"] == "1") {
                                $checkedOpts .= "<br>" . lang("resetcharacter_txt_69", true);
                            }
                            if ($thisItem["@attributes"]["durability"] == "1") {
                                $checkedOpts .= "<br>" . lang("resetcharacter_txt_70", true);
                            }
                            if ($thisItem["@attributes"]["luck"] == "1") {
                                $checkedOpts .= "<br>" . lang("resetcharacter_txt_71", true);
                            }
                            if ($thisItem["@attributes"]["skill"] == "1") {
                                $checkedOpts .= "<br>" . lang("resetcharacter_txt_72", true);
                            }
                            if ($thisItem["@attributes"]["excellent"] == "1") {
                                $checkedOpts .= "<br>" . lang("resetcharacter_txt_73", true);
                            }
                            if ($thisItem["@attributes"]["ancient"] == "1") {
                                $checkedOpts .= "<br>" . lang("resetcharacter_txt_74", true);
                            }
                            if ($thisItem["@attributes"]["harmony"] == "1") {
                                $checkedOpts .= "<br>" . lang("resetcharacter_txt_75", true);
                            }
                            if ($thisItem["@attributes"]["guardian"] == "1") {
                                $checkedOpts .= "<br>" . lang("resetcharacter_txt_76", true);
                            }
                            if ($thisItem["@attributes"]["socket"] == "1") {
                                $checkedOpts .= "<br>" . lang("resetcharacter_txt_77", true);
                            }
                            $reqItemsWcoin .= "<span style=\"cursor: pointer;\" onmouseover=\"Tip(" . $Items->generateItemTooltip($itemInfo, 1, 0, 0, 1, 0, 0) . ")\" onmouseout=\"UnTip()\">" . $itemInfo["name"] . "</span> (" . $thisItem["@attributes"]["count"] . "x) \r\n                            <i class=\"fa fa-info-circle req-info\" aria-hidden=\"true\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"" . lang("resetcharacter_txt_67", true) . $checkedOpts . "\"></i>";
                        }
                    } else {
                        $reqItemsWcoin = "<i class=\"fa fa-check req-success\" aria-hidden=\"true\"></i>";
                    }
                    echo "\r\n            <tr>\r\n                <th class=\"headerRow\">" . lang("resetcharacter_txt_66", true) . "</th>\r\n                <td>" . $reqItemsNormal . "</td>\r\n                <td>" . $reqItemsGP . "</td>\r\n                <td class=\"ranking-wcoins-reset-highlight\">" . $reqItemsWcoin . "</td>\r\n            </tr>";
                }
                if ($normalReset["@attributes"]["bonus_stats_type"] == "0") {
                    $bonusStatsNormal = $normalReset["@attributes"]["bonus_stats"];
                } else {
                    $bonusStatsNormal = $normalReset["@attributes"]["bonus_stats_" . $charData["Class"]];
                }
                if ($normalReset["@attributes"]["bonus_stats_formula"] == "1") {
                    $bonusStatsNormal = ($charData["RESETS"] + 1) * $bonusStatsNormal;
                }
                if ($gpReset["@attributes"]["bonus_stats_type"] == "0") {
                    $bonusStatsGP = $gpReset["@attributes"]["bonus_stats"];
                } else {
                    $bonusStatsGP = $gpReset["@attributes"]["bonus_stats_" . $charData["Class"]];
                }
                if ($gpReset["@attributes"]["bonus_stats_formula"] == "1") {
                    $bonusStatsGP = ($charData["RESETS"] + 1) * $bonusStatsGP;
                }
                if ($wcoinReset["@attributes"]["bonus_stats_type"] == "0") {
                    $bonusStatsWcoin = $wcoinReset["@attributes"]["bonus_stats"];
                } else {
                    $bonusStatsWcoin = $wcoinReset["@attributes"]["bonus_stats_" . $charData["Class"]];
                }
                if ($wcoinReset["@attributes"]["bonus_stats_formula"] == "1") {
                    $bonusStatsWcoin = ($charData["RESETS"] + 1) * $bonusStatsWcoin;
                }
                echo "\r\n            <tr>\r\n                <th class=\"headerRow\">" . lang("resetcharacter_txt_78", true) . "</th>\r\n                <td>" . lang("resetcharacter_txt_79_" . $normalReset["@attributes"]["reset_stats"], true) . "</td>\r\n                <td>" . lang("resetcharacter_txt_79_" . $gpReset["@attributes"]["reset_stats"], true) . "</td>\r\n                <td class=\"ranking-wcoins-reset-highlight\">" . lang("resetcharacter_txt_79_" . $wcoinReset["@attributes"]["reset_stats"], true) . "</td>\r\n            </tr>\r\n            <tr>\r\n                <th class=\"headerRow\">" . lang("resetcharacter_txt_81", true) . "</th>\r\n                <td>" . lang("resetcharacter_txt_79_" . $normalReset["@attributes"]["clear_ml"], true) . "</td>\r\n                <td>" . lang("resetcharacter_txt_79_" . $gpReset["@attributes"]["clear_ml"], true) . "</td>\r\n                <td class=\"ranking-wcoins-reset-highlight\">" . lang("resetcharacter_txt_79_" . $wcoinReset["@attributes"]["clear_ml"], true) . "</td>\r\n            </tr>\r\n            <tr>\r\n                <th class=\"headerRow\">" . lang("resetcharacter_txt_82", true) . "</th>\r\n                <td>" . lang("resetcharacter_txt_79_" . $normalReset["@attributes"]["clear_ml_tree"], true) . "</td>\r\n                <td>" . lang("resetcharacter_txt_79_" . $gpReset["@attributes"]["clear_ml_tree"], true) . "</td>\r\n                <td class=\"ranking-wcoins-reset-highlight\">" . lang("resetcharacter_txt_79_" . $wcoinReset["@attributes"]["clear_ml_tree"], true) . "</td>\r\n            </tr>\r\n            <tr>\r\n                <th class=\"headerRow\">" . lang("resetcharacter_txt_80", true) . "</th>\r\n                <td>" . number_format($bonusStatsNormal) . "</td>\r\n                <td>" . number_format($bonusStatsGP) . "</td>\r\n                <td class=\"ranking-wcoins-reset-highlight\">" . number_format($bonusStatsWcoin) . "</td>\r\n            </tr>\r\n            <tr>\r\n                <th class=\"headerRow\">" . lang("resetcharacter_txt_83", true) . "</th>\r\n                <td>" . number_format($normalReset["@attributes"]["lvl_after_reset"]) . "</td>\r\n                <td>" . number_format($gpReset["@attributes"]["lvl_after_reset"]) . "</td>\r\n                <td class=\"ranking-wcoins-reset-highlight\">" . number_format($wcoinReset["@attributes"]["lvl_after_reset"]) . "</td>\r\n            </tr>";
                if (0 < $normalReset["@attributes"]["is_cred_reward"] || 0 < $gpReset["@attributes"]["is_cred_reward"] || 0 < $wcoinReset["@attributes"]["is_cred_reward"]) {
                    if (0 < $normalReset["@attributes"]["is_cred_reward"]) {
                        $rewardNormal = number_format($normalReset["@attributes"]["cred_reward"]) . " " . $Character->getCurrencyName($normalReset["@attributes"]["credit_config"]);
                    } else {
                        $rewardNormal = "-";
                    }
                    if (0 < $gpReset["@attributes"]["is_cred_reward"]) {
                        $rewardGP = number_format($gpReset["@attributes"]["cred_reward"]) . " " . $Character->getCurrencyName($gpReset["@attributes"]["credit_config"]);
                    } else {
                        $rewardGP = "-";
                    }
                    if (0 < $wcoinReset["@attributes"]["is_cred_reward"]) {
                        $rewardWcoin = number_format($wcoinReset["@attributes"]["cred_reward"]) . " " . $Character->getCurrencyName($wcoinReset["@attributes"]["credit_config"]);
                    } else {
                        $rewardWcoin = "-";
                    }
                    echo "\r\n            <tr>\r\n                <th class=\"headerRow\">" . lang("resetcharacter_txt_84", true) . "</th>\r\n                <td>" . $rewardNormal . "</td>\r\n                <td>" . $rewardGP . "</td>\r\n                <td class=\"ranking-wcoins-reset-highlight\">" . $rewardWcoin . "</td>\r\n            </tr>";
                }
                echo "\r\n            <tr>\r\n                <th></th>\r\n                <td><button class=\"btn btn-warning full-width-btn\">" . lang("resetcharacter_txt_85", true) . "</button></td>\r\n                <td><button class=\"btn btn-warning full-width-btn\">" . lang("resetcharacter_txt_86", true) . "</button></td>\r\n                <td><button class=\"btn btn-success full-width-btn\">" . lang("resetcharacter_txt_87", true) . "</button></td>\r\n            </tr>\r\n        </table>\r\n    </div>";
                echo "<script>\$(function () {\$('[data-toggle=\"tooltip\"]').tooltip({\"html\": \"true\"})})</script>";
            } else {
                $chars = $dB->query_fetch("SELECT Name,cLevel,mLevel,RESETS,Grand_Resets,Class FROM Character WHERE AccountID = ? ORDER BY Grand_Resets desc,RESETS desc,mLevel desc,cLevel desc,Name asc", [$_SESSION["username"]]);
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
                    echo "\r\n                    <td><a href=\"" . __BASE_URL__ . "usercp/reset-types/char/" . hex_encode($char["Name"]) . "/\">" . lang("resetcharacter_txt_42", true) . "</a></td>\r\n                </tr>";
                }
                echo "\r\n        </table>\r\n    </div>";
            }
        } else {
            message("error", lang("error_47", true));
        }
    }
}

?>