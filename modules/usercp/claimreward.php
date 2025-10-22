<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

if (!isLoggedIn()) {
    redirect(1, "login");
} else {
    if (!canAccessModule($_SESSION["username"], "claimreward", "block")) {
        return NULL;
    }
    if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
        $breadcrumb = generateBreadcrumb();
        echo "\r\n    <h3>\r\n        " . lang("myaccount_txt_81", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
        if (mconfig("active")) {
            $General = new xGeneral();
            $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("claimreward");
            $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("claimreward");
            echo "\r\n    <div class=\"row desc-row\">\r\n        <div class=\"col-xs-12\">\r\n            " . lang("claimreward_txt_1", true) . "\r\n        </div>\r\n    </div>";
            $Market = new Market();
            $Items = new Items();
            $Promo = new Promo();
            if (check_value($_POST["submit"])) {
                if ($_SESSION["token"] == $_POST["token"]) {
                    $reward_id = xss_clean(Decode($_POST["id"]));
                    $item_id = xss_clean(Decode($_POST["item"]));
                    $rewardData = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_CLAIM_REWARD WHERE id = ?", [$reward_id]);
                    if ($common->beginDbTrans($_SESSION["username"])) {
                        $Promo->claimReward($_SESSION["username"], $rewardData["Name"], $reward_id, $item_id);
                        $common->endDbTrans($_SESSION["username"]);
                    }
                } else {
                    message("notice", lang("global_module_13", true));
                }
            }
            $token = time();
            $_SESSION["token"] = $token;
            echo "<script type=\"text/javascript\" SRC=\"" . __PATH_TEMPLATE_ASSETS__ . "js/tooltip.js\"></script>";
            if (!isset($_GET["pg"])) {
                $_GET["pg"] = 1;
            }
            if ($myRewards = $Promo->getMyRewards($_SESSION["username"], $_GET["pg"], mconfig("page_limit"))) {
                foreach ($myRewards as $thisReward) {
                    if ($thisReward["expiration"] != NULL && !empty($thisReward["expiration"])) {
                        $expirationDate = date($config["time_date_format"], strtotime($thisReward["expiration"]));
                    } else {
                        $expirationDate = lang("claimreward_txt_7", true);
                    }
                    if ($thisReward["AccountID"] != NULL && !empty($thisReward["AccountID"]) && empty($thisReward["Name"])) {
                        $rewardTarget = lang("claimreward_txt_12", true);
                    } else {
                        $rewardTarget = sprintf(lang("claimreward_txt_13", true), $thisReward["Name"]);
                    }
                    echo "\r\n    <div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-6\">\r\n        <div class=\"auction\">\r\n            <form method=\"post\" action=\"" . __BASE_URL__ . "usercp/claimreward/pg/1/\">\r\n                <table>\r\n                    <tbody>\r\n                        <tr>\r\n                            <td colspan=\"4\" class=\"auction-text\">\r\n                                <div class=\"auction-title\">" . $thisReward["title"] . "</div>\r\n                            </td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td width=\"25%\">" . lang("claimreward_txt_3", true) . ":</td>\r\n                            <td width=\"25%\">" . $rewardTarget . "</td>\r\n                            <td width=\"25%\" align=\"right\">" . lang("claimreward_txt_4", true) . ":</td>\r\n                            <td width=\"25%\" align=\"right\">" . date($config["time_date_format"], strtotime($thisReward["date"])) . "</td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td>" . lang("claimreward_txt_5", true) . ":</td>\r\n                            <td>" . $thisReward["author"] . "</td>\r\n                            <td align=\"right\">" . lang("claimreward_txt_6", true) . ":</td>\r\n                            <td align=\"right\">" . $expirationDate . "</td>\r\n                        </tr>";
                    if (0 < $thisReward["reward_amount"]) {
                        if ($thisReward["reward_amount_type"] == 1) {
                            $rewardName = lang("currency_platinum", true);
                        } else {
                            if ($thisReward["reward_amount_type"] == 2) {
                                $rewardName = lang("currency_gold", true);
                            } else {
                                if ($thisReward["reward_amount_type"] == 3) {
                                    $rewardName = lang("currency_silver", true);
                                } else {
                                    if ($thisReward["reward_amount_type"] == 4) {
                                        $rewardName = lang("currency_wcoinc", true);
                                    } else {
                                        if ($thisReward["reward_amount_type"] == 5) {
                                            $rewardName = lang("currency_gp", true);
                                        } else {
                                            if ($thisReward["reward_amount_type"] == 6) {
                                                $rewardName = lang("currency_zen", true);
                                            } else {
                                                if ($thisReward["reward_amount_type"] == 7) {
                                                    $rewardName = lang("currency_wcoinp", true);
                                                } else {
                                                    if ($thisReward["reward_amount_type"] == 8) {
                                                        $rewardName = lang("currency_ruud", true);
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        echo "\r\n                    </tbody>\r\n                </table>\r\n                <div class=\"auction-status-box\">\r\n                    <span class=\"claimreward\">" . sprintf(lang("claimreward_txt_14", true), number_format($thisReward["reward_amount"]), $rewardName) . "</span>\r\n                </div>\r\n                <table>\r\n                    <tbody>";
                    }
                    if ($thisReward["reward_items"] != NULL && !empty($thisReward["reward_items"])) {
                        $rewardItems = explode(",", $thisReward["reward_items"]);
                        if ($thisReward["reward_item_type"] == 1) {
                            $rewardItemType = lang("claimreward_txt_9", true);
                        } else {
                            if ($thisReward["reward_item_type"] == 2) {
                                $rewardItemType = lang("claimreward_txt_10", true);
                            } else {
                                if ($thisReward["reward_item_type"] == 3) {
                                    $rewardItemType = lang("claimreward_txt_11", true);
                                }
                            }
                        }
                        echo "\r\n                    </tbody>\r\n                </table>\r\n                <div class=\"auction-status-box\">\r\n                    <span class=\"claimreward\">" . lang("claimreward_txt_8", true) . " - " . $rewardItemType . "</span>\r\n                </div>\r\n                <table>\r\n                    <tbody>\r\n                        <tr>\r\n                            <td colspan=\"2\" align=\"center\">";
                        $currentItemID = 0;
                        foreach ($rewardItems as $thisItem) {
                            $itemData = explode(":", $thisItem);
                            list($itemHex, $itemExp) = $itemData;
                            if ($itemExp == NULL) {
                                $itemExp = $thisReward["items_expiration"];
                            }
                            $itemInfo = $Items->ItemInfo($itemHex);
                            echo "\r\n                                <div style=\"height: 170px; display: inline-block;\">\r\n                                    <div class=\"auction-item-frame\" style=\"cursor: pointer;\" onmouseover=\"Tip(" . $Items->generateItemTooltip($itemInfo, 1, 0, 1, 1, 1, $itemExp) . ")\" onmouseout=\"UnTip()\">";
                            echo "\r\n                                        <span class=\"auction-img\"></span><img src=\"" . $itemInfo["thumb"] . "\">\r\n                                    </div>";
                            if ($thisReward["reward_item_type"] == 1) {
                                if ($currentItemID == 0) {
                                    echo "\r\n                                    <div>\r\n                                        <label class=\"label_radio r_on\">\r\n                                            <div></div>\r\n                                            <input type=\"radio\" name=\"item\" value=\"" . Encode($currentItemID) . "\" checked=\"checked\">\r\n                                        </label>\r\n                                    </div>";
                                } else {
                                    echo "\r\n                                    <div>\r\n                                        <label class=\"label_radio\">\r\n                                            <div></div>\r\n                                            <input type=\"radio\" name=\"item\" value=\"" . Encode($currentItemID) . "\"\">\r\n                                        </label>\r\n                                    </div>";
                                }
                            } else {
                                if ($thisReward["reward_item_type"] == 2) {
                                    echo "\r\n                                    <div>\r\n                                        <label class=\"label_check\">\r\n                                            <div></div>\r\n                                            <input type=\"checkbox\" name=\"item\" value=\"" . Encode($currentItemID) . "\" checked=\"checked\" disabled>\r\n                                        </label>\r\n                                    </div>";
                                }
                            }
                            echo "\r\n                                </div>";
                            $currentItemID++;
                        }
                        echo "\r\n                            </td>\r\n                        </tr>";
                    }
                    echo "\r\n                        <tr>\r\n                            <td colspan=\"4\">\r\n                                <input type=\"hidden\" name=\"id\" value=\"" . Encode($thisReward["id"]) . "\">\r\n                                <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                                <input type=\"submit\" name=\"submit\" value=\"" . lang("claimreward_txt_16", true) . "\" class=\"btn btn-warning full-width-btn\">\r\n                            </td>\r\n                        </tr>\r\n                    </tbody>\r\n                </table>\r\n            </form>\r\n        </div>\r\n    </div>";
                }
                echo "\r\n    <div class=\"row\">\r\n        <nav aria-label=\"pagination\" class=\"col-xs-12 market-pagination\">\r\n            <ul class=\"pagination\">";
                $limit = mconfig("page_limit");
                $total_items = $Promo->getAllMyRewards($_SESSION["username"]);
                $total_pages = ceil($total_items / $limit);
                generatePagination($total_pages, $_GET["pg"], __BASE_URL__ . "usercp/claimreward/pg/%pageHolder%/");
                echo "\r\n            </ul>\r\n        </nav>\r\n    </div>";
            } else {
                message("info", lang("claimreward_txt_2", true));
            }
        } else {
            message("error", lang("error_47", true));
        }
    } else {
        echo "\r\n<div class=\"sub-page-title\">\r\n    <div id=\"title\">\r\n        <h1>" . lang("module_titles_txt_3", true) . "<p></p><span></span></h1>\r\n    </div>\r\n</div>\r\n<div class=\"container_2 account\" align=\"center\">\r\n    <div class=\"cont-image\">\r\n        <div class=\"container_3 account_sub_header\">\r\n            <div class=\"grad\">\r\n                <div class=\"page-title\"><p>" . lang("myaccount_txt_81", true) . "</p></div>\r\n                <a href=\"" . __BASE_URL__ . "usercp/\">" . lang("global_module_1", true) . "</a>\r\n            </div>\r\n        </div>\r\n        <div class=\"page-desc-holder\">" . lang("claimreward_txt_1", true) . "</div>";
        if (mconfig("active")) {
            $General = new xGeneral();
            $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("claimreward");
            $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("claimreward");
            $Market = new Market();
            $Items = new Items();
            $Promo = new Promo();
            if (check_value($_POST["submit"])) {
                if ($_SESSION["token"] == $_POST["token"]) {
                    $reward_id = xss_clean(Decode($_POST["id"]));
                    $item_id = xss_clean(Decode($_POST["item"]));
                    $rewardData = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_CLAIM_REWARD WHERE id = ?", [$reward_id]);
                    if (!$common->accountOnline($_SESSION["username"])) {
                        $Promo->claimReward($_SESSION["username"], $rewardData["Name"], $reward_id, $item_id);
                    } else {
                        message("error", lang("error_14", true));
                    }
                } else {
                    message("notice", lang("global_module_13", true));
                }
            }
            $token = time();
            $_SESSION["token"] = $token;
            echo "<script type=\"text/javascript\" SRC=\"" . __PATH_TEMPLATE__ . "js/tooltip.js\"></script>";
            echo "<div class=\"account-wide\" align=\"center\">";
            if ($myRewards = $Promo->getMyRewards($_SESSION["username"])) {
                foreach ($myRewards as $thisReward) {
                    if ($thisReward["expiration"] != NULL && !empty($thisReward["expiration"])) {
                        $expirationDate = date($config["time_date_format"], strtotime($thisReward["expiration"]));
                    } else {
                        $expirationDate = lang("claimreward_txt_7", true);
                    }
                    if ($thisReward["AccountID"] != NULL && !empty($thisReward["AccountID"]) && empty($thisReward["Name"])) {
                        $rewardTarget = lang("claimreward_txt_12", true);
                    } else {
                        $rewardTarget = sprintf(lang("claimreward_txt_13", true), $thisReward["Name"]);
                    }
                    echo "\r\n            <div class=\"auction\">\r\n                <form method=\"post\">\r\n                    <table>\r\n                        <tbody>\r\n                            <tr>\r\n                                <td colspan=\"4\" class=\"auction-text\">\r\n                                    <div class=\"auction-title\">" . $thisReward["title"] . "</div>\r\n                                </td>\r\n                            </tr>\r\n                            <tr>\r\n                                <td width=\"25%\">" . lang("claimreward_txt_3", true) . ":</td>\r\n                                <td width=\"25%\">" . $rewardTarget . "</td>\r\n                                <td width=\"25%\" align=\"right\">" . lang("claimreward_txt_4", true) . ":</td>\r\n                                <td width=\"25%\" align=\"right\">" . date($config["time_date_format"], strtotime($thisReward["date"])) . "</td>\r\n                            </tr>\r\n                            <tr>\r\n                                <td>" . lang("claimreward_txt_5", true) . ":</td>\r\n                                <td>" . $thisReward["author"] . "</td>\r\n                                <td align=\"right\">" . lang("claimreward_txt_6", true) . ":</td>\r\n                                <td align=\"right\">" . $expirationDate . "</td>\r\n                            </tr>";
                    if (0 < $thisReward["reward_amount"]) {
                        if ($thisReward["reward_amount_type"] == 1) {
                            $rewardName = lang("currency_platinum", true);
                        }
                        if ($thisReward["reward_amount_type"] == 2) {
                            $rewardName = lang("currency_gold", true);
                        }
                        if ($thisReward["reward_amount_type"] == 3) {
                            $rewardName = lang("currency_silver", true);
                        }
                        if ($thisReward["reward_amount_type"] == 4) {
                            $rewardName = lang("currency_wcoinc", true);
                        }
                        if ($thisReward["reward_amount_type"] == 5) {
                            $rewardName = lang("currency_gp", true);
                        }
                        if ($thisReward["reward_amount_type"] == 6) {
                            $rewardName = "" . lang("currency_zen", true) . "";
                        }
                        if ($thisReward["reward_amount_type"] == 7) {
                            $rewardName = lang("currency_wcoinp", true);
                        }
                        echo "\r\n                        </tbody>\r\n                    </table>\r\n                    <div class=\"auction-status-box\">\r\n                        <span class=\"claimreward\">" . sprintf(lang("claimreward_txt_14", true), number_format($thisReward["reward_amount"]), $rewardName) . "</span>\r\n                    </div>\r\n                    <table>\r\n                        <tbody>";
                    }
                    if ($thisReward["reward_items"] != NULL && !empty($thisReward["reward_items"])) {
                        $rewardItems = explode(",", $thisReward["reward_items"]);
                        if ($thisReward["reward_item_type"] == 1) {
                            $rewardItemType = lang("claimreward_txt_9", true);
                        } else {
                            if ($thisReward["reward_item_type"] == 2) {
                                $rewardItemType = lang("claimreward_txt_10", true);
                            } else {
                                if ($thisReward["reward_item_type"] == 3) {
                                    $rewardItemType = lang("claimreward_txt_11", true);
                                }
                            }
                        }
                        echo "\r\n                        </tbody>\r\n                    </table>\r\n                    <div class=\"auction-status-box\">\r\n                        <span class=\"claimreward\">" . lang("claimreward_txt_8", true) . " - " . $rewardItemType . "</span>\r\n                    </div>\r\n                    <table>\r\n                        <tbody>\r\n                            <tr>\r\n                                <td colspan=\"2\" align=\"center\">";
                        $currentItemID = 0;
                        foreach ($rewardItems as $thisItem) {
                            $itemInfo = $Items->ItemInfo($thisItem);
                            if (0 < $thisReward["items_expiration"]) {
                                $expMinutes = $thisReward["items_expiration"];
                                $expDays = floor($expMinutes / 1440);
                                $expMinutes = $expMinutes - $expDays * 1440;
                                $expHours = floor($expMinutes / 60);
                                $expMinutes = $expMinutes - $expHours * 60;
                                $expText = "";
                                $expLength = 0;
                                if (0 < $expDays) {
                                    $expText = lang("claimreward_txt_22", true);
                                    $expLength = $expDays;
                                } else {
                                    if (0 < $expHours) {
                                        $expText = lang("claimreward_txt_21", true);
                                        $expLength = $expHours;
                                    } else {
                                        if (0 < $expMinutes) {
                                            $expText = lang("claimreward_txt_20", true);
                                            $expLength = $expMinutes;
                                        }
                                    }
                                }
                                $itemsExpirationInfo = "<br><br><font color=#ff0000>" . sprintf(lang("claimreward_txt_15", true), $expLength, $expText) . "</font>";
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
                            echo "\r\n                                    <div style=\"height: 170px; display: inline-block;\">\r\n                                        <div class=\"auction-item-frame\" style=\"cursor: pointer;\" onmouseover=\"Tip('<center><img src=" . $itemInfo["thumb"] . "><br><font color=#FF99CC>" . $itemInfo["jog"] . "</font><font color=FFCC00>" . $itemInfo["harm"] . "</font><br>" . $option . " " . $luck . " " . $skill . " " . $exl . " <br>" . $ancsetopt . "<br><font color=#4d668d>" . $itemInfo["socket"] . "</font><br><br><span class=itemTooltipClassReq>" . $itemInfo["classReq"] . "</span>" . $itemsExpirationInfo . "</center>', TITLEFONTCOLOR, '" . $itemInfo["color"] . "',TITLE,'" . addslashes($itemInfo["name"]) . $itemInfo["level"] . "',TITLEBGCOLOR,'" . $itemInfo["anco"] . "')\" onmouseout=\"UnTip()\">";
                            echo "\r\n                                            <span class=\"auction-img\"></span><img src=\"" . $itemInfo["thumb"] . "\">\r\n                                        </div>";
                            if ($thisReward["reward_item_type"] == 1) {
                                if ($currentItemID == 0) {
                                    echo "\r\n                                        <div>\r\n                                            <label class=\"label_radio r_on\">\r\n                                                <div></div>\r\n                                                <input type=\"radio\" name=\"item\" value=\"" . Encode($currentItemID) . "\" checked=\"checked\">\r\n                                            </label>\r\n                                        </div>";
                                } else {
                                    echo "\r\n                                        <div>\r\n                                            <label class=\"label_radio\">\r\n                                                <div></div>\r\n                                                <input type=\"radio\" name=\"item\" value=\"" . Encode($currentItemID) . "\"\">\r\n                                            </label>\r\n                                        </div>";
                                }
                            } else {
                                if ($thisReward["reward_item_type"] == 2) {
                                    echo "\r\n                                        <div>\r\n                                            <label class=\"label_check\">\r\n                                                <div></div>\r\n                                                <input type=\"checkbox\" name=\"item\" value=\"" . Encode($currentItemID) . "\" checked=\"checked\" disabled>\r\n                                            </label>\r\n                                        </div>";
                                }
                            }
                            echo "\r\n                                    </div>";
                            $currentItemID++;
                        }
                        echo "\r\n                                </td>\r\n                            </tr>";
                    }
                    echo "\r\n                            <tr>\r\n                                <td colspan=\"4\" align=\"right\">\r\n                                    <input type=\"hidden\" name=\"id\" value=\"" . Encode($thisReward["id"]) . "\">\r\n                                    <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                                    <input type=\"submit\" name=\"submit\" value=\"" . lang("claimreward_txt_16", true) . "\">\r\n                                </td>\r\n                            </tr>\r\n                        </tbody>\r\n                    </table>\r\n                </form>\r\n            </div>";
                }
            } else {
                message("info", lang("claimreward_txt_2", true));
            }
            echo "</div>";
        } else {
            message("error", lang("error_47", true));
        }
        echo "\r\n\t</div>\r\n</div>";
    }
}

?>