<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

if (!isLoggedIn()) {
    redirect(1, "login");
} else {
    if (!canAccessModule($_SESSION["username"], "activityrewards", "block")) {
        return NULL;
    }
    if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
        $breadcrumb = generateBreadcrumb();
        echo "\r\n    <h3>\r\n        " . lang("activityrewards_1", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
        if (mconfig("active")) {
            $General = new xGeneral();
            $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("activityrewards");
            $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("activityrewards");
            echo "<script type=\"text/javascript\" SRC=\"" . __PATH_TEMPLATE_ASSETS__ . "js/tooltip.js\"></script>";
            $Promo = new Promo();
            $Currency = new Currency();
            $Items = new Items();
            $longestPeriod = $Promo->getLongestPeriod($_SESSION["username"]);
            echo "\r\n    <div class=\"row desc-row\">\r\n        <div class=\"col-xs-12\">\r\n            " . lang("activityrewards_12", true) . "<br />\r\n            " . sprintf(lang("activityrewards_5", true), $longestPeriod) . "\r\n        </div>\r\n    </div>";
            if (0 < mconfig("req_level") || 0 < mconfig("req_mlevel") || 0 < mconfig("req_reset") || mconfig("req_greset")) {
                $canUseModule = $Promo->activityRewardsCheckCharReq($_SESSION["username"]);
            } else {
                $canUseModule = true;
            }
            if ($canUseModule) {
                if (isset($_POST["claim_reward"])) {
                    if ($_SESSION["token"] == $_POST["token"]) {
                        $Promo->claimActivityReward($_SESSION["username"], $_POST["char"]);
                    } else {
                        message("notice", lang("global_module_13", true));
                    }
                }
                $currencyNames = $Currency->getAllCurrencies();
                $lastReward = $Promo->loadActivityRewardStatus($_SESSION["username"]);
                $rewards = $Promo->loadActivityRewards($lastReward["period"]);
                $nextPeriod = $lastReward["period"] + 1;
                $token = time();
                $_SESSION["token"] = $token;
                echo "\r\n    <div class=\"row\">\r\n        <div class=\"col-xs-12 text-center\">\r\n            <ul class=\"timeline\">";
                $rewardCounter = 0;
                $maxRewards = 5;
                $totalRewards = 1;
                if (3 <= $lastReward["period"]) {
                    $totalRewards = $totalRewards + $lastReward["period"] - 2;
                    $maxRewards = $maxRewards + $lastReward["period"] - 2;
                }
                $lastOnline = $Promo->checkLastOnlineActivityRewards($_SESSION["username"]);
                $showCharSelect = false;
                while ($totalRewards <= $maxRewards) {
                    $thisReward = $rewards[$rewardCounter];
                    if ($thisReward != NULL) {
                        if ($thisReward["DayStart"] == $thisReward["DayEnd"] || $totalRewards == $thisReward["DayEnd"]) {
                            $rewardCounter++;
                        }
                        $thisStatus = "";
                        $buttonStatus = lang("activityrewards_8", true);
                        $buttonDisabled = " disabled=\"disabled\"";
                        if ($totalRewards < $nextPeriod) {
                            $thisStatus = " done";
                            $buttonStatus = lang("activityrewards_7", true);
                            $buttonDisabled = " disabled=\"disabled\"";
                        } else {
                            if ($totalRewards == $nextPeriod && $lastReward["canClaim"] == "1") {
                                $thisStatus = " active";
                                if ($lastOnline) {
                                    $buttonStatus = lang("activityrewards_6", true);
                                    $buttonDisabled = "";
                                } else {
                                    $buttonStatus = lang("activityrewards_22", true);
                                    $buttonDisabled = " disabled=\"disabled\"";
                                }
                            }
                        }
                        $rewardType = $thisReward["RewardType"];
                        if ($rewardType == 4) {
                            $rewardType = 11;
                        } else {
                            if ($rewardType == 5) {
                                $rewardType = 13;
                            } else {
                                if ($rewardType == 6) {
                                    $rewardType = 20;
                                }
                            }
                        }
                        $showItemsReward = true;
                        $items = $thisReward["RewardItems"];
                        $itemsHtml = "";
                        if ($items != NULL && $items != "") {
                            $items = explode(",", $items);
                            foreach ($items as $thisItem) {
                                $thisItemData = explode(":", $thisItem);
                                $itemHex = $thisItemData[0];
                                $itemExp = 0;
                                $itemExpTime = 0;
                                if ($thisItemData[1] != NULL) {
                                    $itemExpTime = $thisItemData[1];
                                    $itemExp = 1;
                                }
                                $itemInfo = $Items->ItemInfo($itemHex);
                                if ($itemsHtml != "") {
                                    $itemsHtml .= ", ";
                                }
                                $itemsHtml .= "<span style=\"cursor: pointer;\" onmouseover=\"Tip(" . $Items->generateItemTooltip($itemInfo, 1, 0, 1, 1, $itemExp, $itemExpTime) . ")\" onmouseout=\"UnTip()\">" . $itemInfo["name"] . "</span>";
                                if ($thisStatus == " active" && $itemExp == 1) {
                                    $showCharSelect = true;
                                }
                            }
                        }
                        if ($itemsHtml == "") {
                            $showItemsReward = false;
                        } else {
                            if ($thisReward["RewardItemsType"] == "1") {
                                $rewardItemsType = lang("activityrewards_9", true);
                            } else {
                                if ($thisReward["RewardItemsType"] == "2") {
                                    $rewardItemsType = lang("activityrewards_10", true);
                                } else {
                                    if ($thisReward["RewardItemsType"] == "3") {
                                        $rewardItemsType = lang("activityrewards_11", true);
                                    }
                                }
                            }
                        }
                        echo "\r\n                <li class=\"event" . $thisStatus . "\" data-date=\"" . sprintf(lang("activityrewards_2", true), $totalRewards) . "\">\r\n                    <div class=\"row make-border\">\r\n                        <div class=\"col-xs-12 col-md-8\">\r\n                            <p>" . $thisReward["Title"] . "</p>";
                        if ($thisStatus != "" && (0 < $thisReward["ReqTodayOnlineMinutes"] || 0 < $thisReward["ReqTodayLevels"] || 0 < $thisReward["ReqTodayMasterLevels"] || 0 < $thisReward["ReqTodayResets"] || 0 < $thisReward["ReqTodayGrandResets"] || 0 < $thisReward["ReqTodayKilledMonsters"])) {
                            $claimRequirements = "";
                            if (0 < $thisReward["ReqTodayOnlineMinutes"]) {
                                if ($claimRequirements != "") {
                                    $claimRequirements .= ", ";
                                }
                                $claimRequirements .= sprintf(lang("activityrewards_24", true), $thisReward["ReqTodayOnlineMinutes"]);
                            }
                            if (0 < $thisReward["ReqTodayLevels"]) {
                                if ($claimRequirements != "") {
                                    $claimRequirements .= ", ";
                                }
                                $claimRequirements .= sprintf(lang("activityrewards_25", true), $thisReward["ReqTodayLevels"]);
                            }
                            if (0 < $thisReward["ReqTodayMasterLevels"]) {
                                if ($claimRequirements != "") {
                                    $claimRequirements .= ", ";
                                }
                                $claimRequirements .= sprintf(lang("activityrewards_26", true), $thisReward["ReqTodayMasterLevels"]);
                            }
                            if (0 < $thisReward["ReqTodayResets"]) {
                                if ($claimRequirements != "") {
                                    $claimRequirements .= ", ";
                                }
                                $claimRequirements .= sprintf(lang("activityrewards_27", true), $thisReward["ReqTodayResets"]);
                            }
                            if (0 < $thisReward["ReqTodayGrandResets"]) {
                                if ($claimRequirements != "") {
                                    $claimRequirements .= ", ";
                                }
                                $claimRequirements .= sprintf(lang("activityrewards_28", true), $thisReward["ReqTodayGrandResets"]);
                            }
                            if (0 < $thisReward["ReqTodayKilledMonsters"]) {
                                if ($claimRequirements != "") {
                                    $claimRequirements .= ", ";
                                }
                                $claimRequirements .= sprintf(lang("activityrewards_29", true), $thisReward["ReqTodayKilledMonsters"]);
                            }
                            echo "<p>" . lang("activityrewards_23", true) . $claimRequirements . "</p>";
                        }
                        if (0 < $thisReward["Reward"]) {
                            echo "<p>" . lang("activityrewards_3", true) . " " . number_format($thisReward["Reward"]) . " " . $currencyNames[$rewardType] . "</p>";
                        }
                        if ($showItemsReward) {
                            echo "<p>" . sprintf(lang("activityrewards_4", true), $rewardItemsType) . " " . $itemsHtml . "</p>";
                        }
                        echo "\r\n                        </div>\r\n                        <div class=\"col-xs-12 col-md-4 text-right\">\r\n                            <form method=\"post\" action=\"\">";
                        if ($showCharSelect) {
                            $charOptions = "";
                            $characters = $dB->query_fetch("SELECT Name FROM Character WHERE AccountID = ? ORDER BY Name ASC", [$_SESSION["username"]]);
                            foreach ($characters as $thisChar) {
                                $charOptions .= "<option value=\"" . Encode($thisChar["Name"]) . "\">" . $thisChar["Name"] . "</option>";
                            }
                            echo "\r\n                                <div class=\"form-group\">\r\n                                    <label class=\"text-center\" style=\"width: 100%;\"><small>" . lang("activityrewards_36", true) . "</small></label>\r\n                                    <select name=\"char\" class=\"form-control\" style=\"margin-bottom: .5em;\">\r\n                                        " . $charOptions . "\r\n                                    </select>\r\n                                </div>";
                        } else {
                            echo "<input type=\"hidden\" name=\"char\" value=\"" . Encode(".x") . "\">";
                        }
                        echo "\r\n                                <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                                <input type=\"submit\" name=\"claim_reward\" value=\"" . $buttonStatus . "\" class=\"btn btn-warning activity-claim-reward-btn\"" . $buttonDisabled . " />\r\n                            </form>\r\n                        </div>\r\n                    </div>\r\n                </li>";
                        $totalRewards++;
                    }
                }
                echo "\r\n            </ul>\r\n        </div>\r\n    </div>";
            } else {
                $reqText = "";
                if (0 < mconfig("req_level")) {
                    if ($reqText != "") {
                        $reqText .= ", ";
                    }
                    $reqText .= sprintf(lang("activityrewards_18", true), mconfig("req_level"));
                }
                if (0 < mconfig("req_mlevel")) {
                    if ($reqText != "") {
                        $reqText .= ", ";
                    }
                    $reqText .= sprintf(lang("activityrewards_19", true), mconfig("req_mlevel"));
                }
                if (0 < mconfig("req_reset")) {
                    if ($reqText != "") {
                        $reqText .= ", ";
                    }
                    $reqText .= sprintf(lang("activityrewards_20", true), mconfig("req_reset"));
                }
                if (0 < mconfig("req_greset")) {
                    if ($reqText != "") {
                        $reqText .= ", ";
                    }
                    $reqText .= sprintf(lang("activityrewards_21", true), mconfig("req_greset"));
                }
                message("notice", sprintf(lang("activityrewards_17", true), $reqText));
            }
        } else {
            message("error", lang("error_47", true));
        }
    }
}

?>