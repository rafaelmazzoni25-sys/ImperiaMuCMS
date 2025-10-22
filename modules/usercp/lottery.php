<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

if (!isLoggedIn()) {
    redirect(1, "login");
} else {
    if (!canAccessModule($_SESSION["username"], "lottery", "block")) {
        return NULL;
    }
    $Lottery = new Lottery();
    if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
        $breadcrumb = generateBreadcrumb();
        echo "\r\n    <h3>\r\n        " . sprintf(lang("lottery_txt_1", true), $Lottery->getLotteryNumber()) . "\r\n        <small>" . $Lottery->lotteryPeriod() . "</small>\r\n        " . $breadcrumb . "\r\n    </h3>";
        if (mconfig("active")) {
            echo "\r\n    <div class=\"row desc-row\">\r\n        <div class=\"col-xs-12\">";
            if (mconfig("lottery_prize_type") == 1) {
                $reward_type = lang("currency_platinum", true);
            } else {
                if (mconfig("lottery_prize_type") == 2) {
                    $reward_type = lang("currency_gold", true);
                } else {
                    if (mconfig("lottery_prize_type") == 3) {
                        $reward_type = lang("currency_silver", true);
                    } else {
                        if (mconfig("lottery_prize_type") == 4) {
                            $reward_type = lang("currency_wcoinc", true);
                        } else {
                            if (mconfig("lottery_prize_type") == 5) {
                                $reward_type = lang("currency_gp", true);
                            } else {
                                $reward_type = "" . lang("currency_zen", true) . "";
                            }
                        }
                    }
                }
            }
            echo sprintf(lang("lottery_txt_9", true), mconfig("lottery_min_num"), mconfig("lottery_max_num"));
            if (mconfig("lottery_length") == "7" || mconfig("lottery_length") == "14") {
                $length = mconfig("lottery_length") . " days";
                $date = date($config["date_format"], strtotime(mconfig("lottery_start")));
                echo sprintf(lang("lottery_txt_10", true), $length, $date);
            } else {
                echo lang("lottery_txt_11", true);
            }
            if (0 < mconfig("lottery_ticket_price")) {
                if (mconfig("lottery_ticket_price_type") == 1) {
                    $price_type = lang("currency_platinum", true);
                } else {
                    if (mconfig("lottery_ticket_price_type") == 2) {
                        $price_type = lang("currency_gold", true);
                    } else {
                        if (mconfig("lottery_ticket_price_type") == 3) {
                            $price_type = lang("currency_silver", true);
                        } else {
                            if (mconfig("lottery_ticket_price_type") == 4) {
                                $price_type = lang("currency_wcoinc", true);
                            } else {
                                if (mconfig("lottery_ticket_price_type") == 5) {
                                    $price_type = lang("currency_gp", true);
                                } else {
                                    $price_type = "" . lang("currency_zen", true) . "";
                                }
                            }
                        }
                    }
                }
                echo sprintf(lang("lottery_txt_12", true), mconfig("lottery_ticket_price"), $price_type, mconfig("lottery_ticket_limit"));
            }
            echo sprintf(lang("lottery_txt_44", true), $reward_type);
            echo "\r\n        </div>\r\n    </div>";
            $General = new xGeneral();
            $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("lottery");
            $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("lottery");
            if (check_value($_POST["submit"])) {
                if ($_SESSION["token"] == $_POST["token"]) {
                    $Lottery->submitTicket($_SESSION["username"], $_POST["num1"], $_POST["num2"], $_POST["num3"], $_POST["num4"], $_POST["num5"], $_POST["num6"]);
                } else {
                    message("notice", lang("global_module_13", true));
                }
            }
            if (check_value($_POST["reward"])) {
                if ($_SESSION["token"] == $_POST["token"]) {
                    $lottery_id = htmlspecialchars(Decode($_POST[Encode("lottery")]));
                    $Lottery->claimReward($_SESSION["username"], $lottery_id);
                } else {
                    message("notice", lang("global_module_13", true));
                }
            }
            if (mconfig("lottery_length") == "7" || mconfig("lottery_length") == "14") {
                if (mconfig("lottery_start") <= date("Y-m-d", time())) {
                    $showSubmit = true;
                } else {
                    $showSubmit = false;
                }
            } else {
                $showSubmit = true;
            }
            $token = time();
            $_SESSION["token"] = $token;
            if ($Lottery->canSubmitTicket($_SESSION["username"])) {
                echo "\r\n    <div class=\"table-responsive rankings-table\">\r\n        <form action=\"\" method=\"post\">\r\n            <table class=\"table table-hover text-center\">\r\n                <tr>\r\n                    <th colspan=\"7\" class=\"headerRow\">" . lang("lottery_txt_21", true) . "</th>\r\n                </tr>\r\n                <tr>\r\n                    <td>\r\n                        <div class=\"input-group\">\r\n                            <div class=\"input-group-addon\">" . lang("lottery_txt_2", true) . "</div>\r\n                            <input type=\"number\" class=\"form-control\" name=\"num1\" min=\"" . mconfig("lottery_min_num") . "\"  max=\"" . mconfig("lottery_max_num") . "\"/>\r\n                        </div>\r\n                    </td>\r\n                    <td>\r\n                        <div class=\"input-group\">\r\n                            <div class=\"input-group-addon\">" . lang("lottery_txt_3", true) . "</div>\r\n                            <input type=\"number\" class=\"form-control\" name=\"num2\" min=\"" . mconfig("lottery_min_num") . "\"  max=\"" . mconfig("lottery_max_num") . "\"/>\r\n                        </div>\r\n                    </td>\r\n                    <td>\r\n                        <div class=\"input-group\">\r\n                            <div class=\"input-group-addon\">" . lang("lottery_txt_4", true) . "</div>\r\n                            <input type=\"number\" class=\"form-control\" name=\"num3\" min=\"" . mconfig("lottery_min_num") . "\"  max=\"" . mconfig("lottery_max_num") . "\"/>\r\n                        </div>\r\n                    </td>\r\n                    <td>\r\n                        <div class=\"input-group\">\r\n                            <div class=\"input-group-addon\">" . lang("lottery_txt_5", true) . "</div>\r\n                            <input type=\"number\" class=\"form-control\" name=\"num4\" min=\"" . mconfig("lottery_min_num") . "\"  max=\"" . mconfig("lottery_max_num") . "\"/>\r\n                        </div>\r\n                    </td>\r\n                    <td>\r\n                        <div class=\"input-group\">\r\n                            <div class=\"input-group-addon\">" . lang("lottery_txt_6", true) . "</div>\r\n                            <input type=\"number\" class=\"form-control\" name=\"num5\" min=\"" . mconfig("lottery_min_num") . "\"  max=\"" . mconfig("lottery_max_num") . "\"/>\r\n                        </div>\r\n                    </td>\r\n                    <td>\r\n                        <div class=\"input-group\">\r\n                            <div class=\"input-group-addon\">" . lang("lottery_txt_7", true) . "</div>\r\n                            <input type=\"number\" class=\"form-control\" name=\"num6\" min=\"" . mconfig("lottery_min_num") . "\"  max=\"" . mconfig("lottery_max_num") . "\"/>\r\n                        </div>\r\n                    </td>\r\n                    <td>\r\n                        <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                        <button name=\"submit\" value=\"submit\" class=\"btn btn-warning full-width-btn\">" . lang("lottery_txt_8", true) . "</button>\r\n                    </td>\r\n                </tr>\r\n            </table>\r\n        </form>\r\n    </div>";
            } else {
                message("info", lang("lottery_txt_16", true));
            }
            $lottery_id = $Lottery->getLotteryNumber();
            echo "\r\n    <div class=\"table-responsive rankings-table\">\r\n        <form action=\"\" method=\"post\">\r\n            <table class=\"table table-hover text-center\">\r\n                <tr>\r\n                    <th colspan=\"7\" class=\"headerRow\">" . sprintf(lang("lottery_txt_22", true), $lottery_id) . "</th>\r\n                </tr>\r\n                <tr>\r\n                    <th>" . lang("lottery_txt_23", true) . "</th>\r\n                    <th>" . lang("lottery_txt_2", true) . "</th>\r\n                    <th>" . lang("lottery_txt_3", true) . "</th>\r\n                    <th>" . lang("lottery_txt_4", true) . "</th>\r\n                    <th>" . lang("lottery_txt_5", true) . "</th>\r\n                    <th>" . lang("lottery_txt_6", true) . "</th>\r\n                    <th>" . lang("lottery_txt_7", true) . "</th>\r\n                </tr>";
            $myTickets = $Lottery->getMyTickets($_SESSION["username"], $lottery_id);
            if (is_array($myTickets)) {
                foreach ($myTickets as $thisTicket) {
                    echo "\r\n                <tr>\r\n                    <td>" . date($config["time_date_format"], strtotime($thisTicket["date"])) . "</td>\r\n                    <td>" . $thisTicket["num1"] . "</td>\r\n                    <td>" . $thisTicket["num2"] . "</td>\r\n                    <td>" . $thisTicket["num3"] . "</td>\r\n                    <td>" . $thisTicket["num4"] . "</td>\r\n                    <td>" . $thisTicket["num5"] . "</td>\r\n                    <td>" . $thisTicket["num6"] . "</td>\r\n                </tr>";
                }
            } else {
                echo "\r\n                <tr>\r\n                    <td colspan=\"7\">" . lang("lottery_txt_29", true) . "</td>\r\n                </tr>";
            }
            echo "\r\n            </table>\r\n        </form>\r\n    </div>";
            echo "\r\n    <div class=\"sub-header-usercp\">" . lang("lottery_txt_26", true) . "</div>";
            $lotteries = $Lottery->getLatestDrawns();
            if (is_array($lotteries)) {
                foreach ($lotteries as $thisLottery) {
                    if (mconfig("lottery_type") == "1") {
                        if (0 < $thisLottery["6th_price_winners"]) {
                            $reward6 = round($thisLottery["6th_price"] / $thisLottery["6th_price_winners"]);
                        } else {
                            $reward6 = 0;
                        }
                        if (0 < $thisLottery["5th_price_winners"]) {
                            $reward5 = round($thisLottery["5th_price"] / $thisLottery["5th_price_winners"]);
                        } else {
                            $reward5 = 0;
                        }
                        if (0 < $thisLottery["4th_price_winners"]) {
                            $reward4 = round($thisLottery["4th_price"] / $thisLottery["4th_price_winners"]);
                        } else {
                            $reward4 = 0;
                        }
                        if (0 < $thisLottery["3rd_price_winners"]) {
                            $reward3 = round($thisLottery["3rd_price"] / $thisLottery["3rd_price_winners"]);
                        } else {
                            $reward3 = 0;
                        }
                        if (0 < $thisLottery["2nd_price_winners"]) {
                            $reward2 = round($thisLottery["2nd_price"] / $thisLottery["2nd_price_winners"]);
                        } else {
                            $reward2 = 0;
                        }
                        if (0 < $thisLottery["1st_price_winners"]) {
                            $reward1 = round($thisLottery["1st_price"] / $thisLottery["1st_price_winners"]);
                        } else {
                            $reward1 = 0;
                        }
                    } else {
                        if (0 < $thisLottery["6th_price_winners"]) {
                            $reward6 = $thisLottery["6th_price"];
                        } else {
                            $reward6 = 0;
                        }
                        if (0 < $thisLottery["5th_price_winners"]) {
                            $reward5 = $thisLottery["5th_price"];
                        } else {
                            $reward5 = 0;
                        }
                        if (0 < $thisLottery["4th_price_winners"]) {
                            $reward4 = $thisLottery["4th_price"];
                        } else {
                            $reward4 = 0;
                        }
                        if (0 < $thisLottery["3rd_price_winners"]) {
                            $reward3 = $thisLottery["3rd_price"];
                        } else {
                            $reward3 = 0;
                        }
                        if (0 < $thisLottery["2nd_price_winners"]) {
                            $reward2 = $thisLottery["2nd_price"];
                        } else {
                            $reward2 = 0;
                        }
                        if (0 < $thisLottery["1st_price_winners"]) {
                            $reward1 = $thisLottery["1st_price"];
                        } else {
                            $reward1 = 0;
                        }
                    }
                    echo "\r\n    <div class=\"table-responsive rankings-table\">\r\n        <table class=\"table table-hover text-center\">\r\n            <tr>\r\n                <th colspan=\"7\" class=\"headerRow\">" . sprintf(lang("lottery_txt_1", true), $thisLottery["lottery"]) . "</th>\r\n            </tr>\r\n            <tr>\r\n                <th>" . lang("lottery_txt_23", true) . "</th>\r\n                <th>" . lang("lottery_txt_2", true) . "</th>\r\n                <th>" . lang("lottery_txt_3", true) . "</th>\r\n                <th>" . lang("lottery_txt_4", true) . "</th>\r\n                <th>" . lang("lottery_txt_5", true) . "</th>\r\n                <th>" . lang("lottery_txt_6", true) . "</th>\r\n                <th>" . lang("lottery_txt_7", true) . "</th>\r\n            </tr>\r\n            <tr>\r\n                <td>" . date($config["time_date_format"], strtotime($thisLottery["date"])) . "</td>\r\n                <td><span class=\"lottery-num\">" . $thisLottery["num1"] . "</span></td>\r\n                <td><span class=\"lottery-num\">" . $thisLottery["num2"] . "</span></td>\r\n                <td><span class=\"lottery-num\">" . $thisLottery["num3"] . "</span></td>\r\n                <td><span class=\"lottery-num\">" . $thisLottery["num4"] . "</span></td>\r\n                <td><span class=\"lottery-num\">" . $thisLottery["num5"] . "</span></td>\r\n                <td><span class=\"lottery-num\">" . $thisLottery["num6"] . "</span></td>\r\n            </tr>\r\n            <tr>\r\n                <th colspan=\"7\" class=\"headerRow\">" . sprintf(lang("lottery_txt_35", true), $thisLottery["lottery"]) . "</th>\r\n            </tr>\r\n            <tr>\r\n                <th></th>\r\n                <th>" . lang("lottery_txt_41", true) . "</th>\r\n                <th>" . lang("lottery_txt_40", true) . "</th>\r\n                <th>" . lang("lottery_txt_39", true) . "</th>\r\n                <th>" . lang("lottery_txt_38", true) . "</th>\r\n                <th>" . lang("lottery_txt_37", true) . "</th>\r\n                <th>" . lang("lottery_txt_36", true) . "</th>\r\n            </tr>\r\n            <tr>\r\n                <th>" . lang("lottery_txt_42", true) . "</th>\r\n                <td>" . $thisLottery["6th_price_winners"] . "</td>\r\n                <td>" . $thisLottery["5th_price_winners"] . "</td>\r\n                <td>" . $thisLottery["4th_price_winners"] . "</td>\r\n                <td>" . $thisLottery["3rd_price_winners"] . "</td>\r\n                <td>" . $thisLottery["2nd_price_winners"] . "</td>\r\n                <td>" . $thisLottery["1st_price_winners"] . "</td>\r\n            </tr>\r\n            <tr>\r\n                <th>" . lang("lottery_txt_43", true) . "</th>\r\n                <td>" . $reward6 . "</td>\r\n                <td>" . $reward5 . "</td>\r\n                <td>" . $reward4 . "</td>\r\n                <td>" . $reward3 . "</td>\r\n                <td>" . $reward2 . "</td>\r\n                <td>" . $reward1 . "</td>\r\n            </tr>\r\n            <tr>\r\n                <th colspan=\"7\" class=\"headerRow\">" . sprintf(lang("lottery_txt_28", true), $thisLottery["lottery"]) . "</th>\r\n            </tr>";
                    $myTickets = $Lottery->getMyTickets($_SESSION["username"], $thisLottery["lottery"]);
                    if (is_array($myTickets)) {
                        foreach ($myTickets as $thisTicket) {
                            $compareNumbers = $Lottery->compareNumbers($_SESSION["username"], $thisLottery["lottery"], $thisTicket["id"]);
                            echo "\r\n            <tr>\r\n                <td>" . date($config["time_date_format"], strtotime($thisTicket["date"])) . "</td>\r\n                <td>" . $compareNumbers[1] . "</td>\r\n                <td>" . $compareNumbers[2] . "</td>\r\n                <td>" . $compareNumbers[3] . "</td>\r\n                <td>" . $compareNumbers[4] . "</td>\r\n                <td>" . $compareNumbers[5] . "</td>\r\n                <td>" . $compareNumbers[6] . "</td>\r\n            </tr>";
                        }
                    } else {
                        echo "\r\n            <tr>\r\n                <td colspan=\"7\">" . lang("lottery_txt_30", true) . "</td>\r\n            </tr>";
                    }
                    if ($Lottery->hasReward($_SESSION["username"], $thisLottery["lottery"])) {
                        $rewardAmount = $Lottery->getRewardAmount($_SESSION["username"], $thisLottery["lottery"]);
                        echo "\r\n            <tr>\r\n                <td colspan=\"7\">\r\n                    <form method=\"post\" action=\"\">\r\n                        <input type=\"hidden\" name=\"" . Encode("lottery") . "\" value=\"" . Encode($thisLottery["lottery"]) . "\">\r\n                        <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                        <button name=\"reward\" value=\"reward\" class=\"btn btn-warning full-width-btn\">" . lang("lottery_txt_31", true) . " (" . $rewardAmount . ")</button>\r\n                    </form>\r\n                </td>\r\n            </tr>";
                    }
                    echo "\r\n        </table>\r\n    </div>";
                }
            } else {
                message("info", lang("lottery_txt_27", true));
            }
        } else {
            message("error", lang("error_47", true));
        }
    } else {
        echo "\r\n<div class=\"sub-page-title\">\r\n  <div id=\"title\">\r\n      <h1>" . lang("module_titles_txt_3", true) . "<p></p><span></span></h1>\r\n  </div>\r\n</div>\r\n<div class=\"container_2 account\" align=\"center\">\r\n    <div class=\"cont-image\">\r\n        <div class=\"container_3 account_sub_header\">\r\n            <div class=\"grad\">\r\n                <div class=\"page-title\"><p>" . sprintf(lang("lottery_txt_1", true), $Lottery->getLotteryNumber()) . "</p></div>\r\n                <div class=\"sub-active-page\">" . $Lottery->lotteryPeriod() . "</div>\r\n                <a href=\"" . __BASE_URL__ . "usercp\">" . lang("global_module_1", true) . "</a>\r\n            </div>\r\n        </div>\r\n        <div class=\"page-desc-holder\">";
        if (mconfig("lottery_prize_type") == 1) {
            $reward_type = lang("currency_platinum", true);
        } else {
            if (mconfig("lottery_prize_type") == 2) {
                $reward_type = lang("currency_gold", true);
            } else {
                if (mconfig("lottery_prize_type") == 3) {
                    $reward_type = lang("currency_silver", true);
                } else {
                    if (mconfig("lottery_prize_type") == 4) {
                        $reward_type = lang("currency_wcoinc", true);
                    } else {
                        if (mconfig("lottery_prize_type") == 5) {
                            $reward_type = lang("currency_gp", true);
                        } else {
                            $reward_type = "" . lang("currency_zen", true) . "";
                        }
                    }
                }
            }
        }
        echo sprintf(lang("lottery_txt_9", true), mconfig("lottery_min_num"), mconfig("lottery_max_num"));
        if (mconfig("lottery_length") == "7" || mconfig("lottery_length") == "14") {
            $length = mconfig("lottery_length") . " days";
            $date = date($config["date_format"], strtotime(mconfig("lottery_start")));
            echo sprintf(lang("lottery_txt_10", true), $length, $date);
        } else {
            echo lang("lottery_txt_11", true);
        }
        if (0 < mconfig("lottery_ticket_price")) {
            if (mconfig("lottery_ticket_price_type") == 1) {
                $price_type = lang("currency_platinum", true);
            } else {
                if (mconfig("lottery_ticket_price_type") == 2) {
                    $price_type = lang("currency_gold", true);
                } else {
                    if (mconfig("lottery_ticket_price_type") == 3) {
                        $price_type = lang("currency_silver", true);
                    } else {
                        if (mconfig("lottery_ticket_price_type") == 4) {
                            $price_type = lang("currency_wcoinc", true);
                        } else {
                            if (mconfig("lottery_ticket_price_type") == 5) {
                                $price_type = lang("currency_gp", true);
                            } else {
                                $price_type = "" . lang("currency_zen", true) . "";
                            }
                        }
                    }
                }
            }
            echo sprintf(lang("lottery_txt_12", true), mconfig("lottery_ticket_price"), $price_type, mconfig("lottery_ticket_limit"));
        }
        echo sprintf(lang("lottery_txt_44", true), $reward_type);
        echo "\r\n        </div>";
        if (mconfig("active")) {
            $General = new xGeneral();
            $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("lottery");
            $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("lottery");
            if (check_value($_POST["submit"])) {
                if ($_SESSION["token"] == $_POST["token"]) {
                    $Lottery->submitTicket($_SESSION["username"], $_POST["num1"], $_POST["num2"], $_POST["num3"], $_POST["num4"], $_POST["num5"], $_POST["num6"]);
                } else {
                    message("notice", lang("global_module_13", true));
                }
            }
            if (check_value($_POST["reward"])) {
                if ($_SESSION["token"] == $_POST["token"]) {
                    $lottery_id = htmlspecialchars(Decode($_POST[Encode("lottery")]));
                    $Lottery->claimReward($_SESSION["username"], $lottery_id);
                } else {
                    message("notice", lang("global_module_13", true));
                }
            }
            if (mconfig("lottery_length") == "7" || mconfig("lottery_length") == "14") {
                if (mconfig("lottery_start") <= date("Y-m-d", time())) {
                    $showSubmit = true;
                } else {
                    $showSubmit = false;
                }
            } else {
                $showSubmit = true;
            }
            $token = time();
            $_SESSION["token"] = $token;
            if ($Lottery->canSubmitTicket($_SESSION["username"])) {
                echo "\r\n        <div class=\"container_3 account-wide\" align=\"center\">\r\n            <form action=\"\" method=\"post\">\r\n                <table class=\"general-table-ui\" cellspacing=\"0\">\r\n                    <tr>\r\n                        <th colspan=\"7\">" . lang("lottery_txt_21", true) . "</th>\r\n                    </tr>\r\n                    <tr>\r\n                        <th>" . lang("lottery_txt_2", true) . "</th>\r\n                        <th>" . lang("lottery_txt_3", true) . "</th>\r\n                        <th>" . lang("lottery_txt_4", true) . "</th>\r\n                        <th>" . lang("lottery_txt_5", true) . "</th>\r\n                        <th>" . lang("lottery_txt_6", true) . "</th>\r\n                        <th>" . lang("lottery_txt_7", true) . "</th>\r\n                        <th></th>\r\n                    </tr>\r\n                    <tr>\r\n                        <td><input style=\"width: 40px;\" type=\"text\" name=\"num1\" maxlength=\"" . strlen(mconfig("lottery_max_num")) . "\"/></td>\r\n                        <td><input style=\"width: 40px;\" type=\"text\" name=\"num2\" maxlength=\"" . strlen(mconfig("lottery_max_num")) . "\"/></td>\r\n                        <td><input style=\"width: 40px;\" type=\"text\" name=\"num3\" maxlength=\"" . strlen(mconfig("lottery_max_num")) . "\"/></td>\r\n                        <td><input style=\"width: 40px;\" type=\"text\" name=\"num4\" maxlength=\"" . strlen(mconfig("lottery_max_num")) . "\"/></td>\r\n                        <td><input style=\"width: 40px;\" type=\"text\" name=\"num5\" maxlength=\"" . strlen(mconfig("lottery_max_num")) . "\"/></td>\r\n                        <td><input style=\"width: 40px;\" type=\"text\" name=\"num6\" maxlength=\"" . strlen(mconfig("lottery_max_num")) . "\"/></td>\r\n                        <td><input type=\"hidden\" name=\"token\" value=\"" . $token . "\"><button name=\"submit\" value=\"submit\" class=\"ui-button button1\" ><span class=\"button-left\"><span class=\"button-right\">" . lang("lottery_txt_8", true) . "</span></span></button></td>\r\n                    </tr>";
                echo "\r\n                </table>\r\n            </form>\r\n        </div>";
            } else {
                message("info", lang("lottery_txt_16", true));
            }
            $lottery_id = $Lottery->getLotteryNumber();
            echo "\r\n        <div class=\"container_3 account-wide\" align=\"center\">\r\n            <table class=\"general-table-ui\" cellspacing=\"0\">\r\n                <tr>\r\n                    <th colspan=\"7\">" . sprintf(lang("lottery_txt_22", true), $lottery_id) . "</th>\r\n                </tr>\r\n                <tr>\r\n                    <th>" . lang("lottery_txt_23", true) . "</th>\r\n                    <th>" . lang("lottery_txt_2", true) . "</th>\r\n                    <th>" . lang("lottery_txt_3", true) . "</th>\r\n                    <th>" . lang("lottery_txt_4", true) . "</th>\r\n                    <th>" . lang("lottery_txt_5", true) . "</th>\r\n                    <th>" . lang("lottery_txt_6", true) . "</th>\r\n                    <th>" . lang("lottery_txt_7", true) . "</th>\r\n                </tr>";
            $myTickets = $Lottery->getMyTickets($_SESSION["username"], $lottery_id);
            if (is_array($myTickets)) {
                foreach ($myTickets as $thisTicket) {
                    echo "\r\n                <tr>\r\n                    <td>" . date($config["time_date_format"], strtotime($thisTicket["date"])) . "</td>\r\n                    <td>" . $thisTicket["num1"] . "</td>\r\n                    <td>" . $thisTicket["num2"] . "</td>\r\n                    <td>" . $thisTicket["num3"] . "</td>\r\n                    <td>" . $thisTicket["num4"] . "</td>\r\n                    <td>" . $thisTicket["num5"] . "</td>\r\n                    <td>" . $thisTicket["num6"] . "</td>\r\n                </tr>";
                }
            } else {
                echo "\r\n                <tr>\r\n                    <td colspan=\"7\">" . lang("lottery_txt_29", true) . "</td>\r\n                </tr>";
            }
            echo "\r\n            </table>\r\n        </div>";
            echo "\r\n    <div class=\"container_3 account_sub_header\" style=\"margin-top: 50px;\">\r\n        <div class=\"grad\">\r\n            <div class=\"page-title\"><p>" . lang("lottery_txt_26", true) . "</p></div>\r\n        </div>\r\n    </div>";
            $lotteries = $Lottery->getLatestDrawns();
            if (is_array($lotteries)) {
                foreach ($lotteries as $thisLottery) {
                    echo "\r\n            <div class=\"container_3 account-wide\" align=\"center\">\r\n                <table class=\"general-table-ui\" cellspacing=\"0\">\r\n                    <tr>\r\n                        <th colspan=\"7\">" . sprintf(lang("lottery_txt_1", true), $thisLottery["lottery"]) . "</th>\r\n                    </tr>\r\n                    <tr>\r\n                        <th>" . lang("lottery_txt_23", true) . "</th>\r\n                        <th>" . lang("lottery_txt_2", true) . "</th>\r\n                        <th>" . lang("lottery_txt_3", true) . "</th>\r\n                        <th>" . lang("lottery_txt_4", true) . "</th>\r\n                        <th>" . lang("lottery_txt_5", true) . "</th>\r\n                        <th>" . lang("lottery_txt_6", true) . "</th>\r\n                        <th>" . lang("lottery_txt_7", true) . "</th>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>" . date($config["time_date_format"], strtotime($thisLottery["date"])) . "</td>\r\n                        <td><span style=\"color: #f7c97a; font-size: 20px; font-weight: bold;\">" . $thisLottery["num1"] . "</span></td>\r\n                        <td><span style=\"color: #f7c97a; font-size: 20px; font-weight: bold;\">" . $thisLottery["num2"] . "</span></td>\r\n                        <td><span style=\"color: #f7c97a; font-size: 20px; font-weight: bold;\">" . $thisLottery["num3"] . "</span></td>\r\n                        <td><span style=\"color: #f7c97a; font-size: 20px; font-weight: bold;\">" . $thisLottery["num4"] . "</span></td>\r\n                        <td><span style=\"color: #f7c97a; font-size: 20px; font-weight: bold;\">" . $thisLottery["num5"] . "</span></td>\r\n                        <td><span style=\"color: #f7c97a; font-size: 20px; font-weight: bold;\">" . $thisLottery["num6"] . "</span></td>\r\n                    </tr>\r\n                    <tr>\r\n                        <th colspan=\"7\">" . sprintf(lang("lottery_txt_35", true), $thisLottery["lottery"]) . "</th>\r\n                    </tr>\r\n                    <tr>\r\n                        <th></th>\r\n                        <th>" . lang("lottery_txt_41", true) . "</th>\r\n                        <th>" . lang("lottery_txt_40", true) . "</th>\r\n                        <th>" . lang("lottery_txt_39", true) . "</th>\r\n                        <th>" . lang("lottery_txt_38", true) . "</th>\r\n                        <th>" . lang("lottery_txt_37", true) . "</th>\r\n                        <th>" . lang("lottery_txt_36", true) . "</th>\r\n                    </tr>\r\n                    <tr>\r\n                        <th>" . lang("lottery_txt_42", true) . "</th>\r\n                        <td>" . $thisLottery["6th_price_winners"] . "</td>\r\n                        <td>" . $thisLottery["5th_price_winners"] . "</td>\r\n                        <td>" . $thisLottery["4th_price_winners"] . "</td>\r\n                        <td>" . $thisLottery["3rd_price_winners"] . "</td>\r\n                        <td>" . $thisLottery["2nd_price_winners"] . "</td>\r\n                        <td>" . $thisLottery["1st_price_winners"] . "</td>\r\n                    </tr>";
                    if (mconfig("lottery_type") == "1") {
                        if (0 < $thisLottery["6th_price_winners"]) {
                            $reward6 = round($thisLottery["6th_price"] / $thisLottery["6th_price_winners"]);
                        } else {
                            $reward6 = 0;
                        }
                        if (0 < $thisLottery["5th_price_winners"]) {
                            $reward5 = round($thisLottery["5th_price"] / $thisLottery["5th_price_winners"]);
                        } else {
                            $reward5 = 0;
                        }
                        if (0 < $thisLottery["4th_price_winners"]) {
                            $reward4 = round($thisLottery["4th_price"] / $thisLottery["4th_price_winners"]);
                        } else {
                            $reward4 = 0;
                        }
                        if (0 < $thisLottery["3rd_price_winners"]) {
                            $reward3 = round($thisLottery["3rd_price"] / $thisLottery["3rd_price_winners"]);
                        } else {
                            $reward3 = 0;
                        }
                        if (0 < $thisLottery["2nd_price_winners"]) {
                            $reward2 = round($thisLottery["2nd_price"] / $thisLottery["2nd_price_winners"]);
                        } else {
                            $reward2 = 0;
                        }
                        if (0 < $thisLottery["1st_price_winners"]) {
                            $reward1 = round($thisLottery["1st_price"] / $thisLottery["1st_price_winners"]);
                        } else {
                            $reward1 = 0;
                        }
                    } else {
                        if (0 < $thisLottery["6th_price_winners"]) {
                            $reward6 = $thisLottery["6th_price"];
                        } else {
                            $reward6 = 0;
                        }
                        if (0 < $thisLottery["5th_price_winners"]) {
                            $reward5 = $thisLottery["5th_price"];
                        } else {
                            $reward5 = 0;
                        }
                        if (0 < $thisLottery["4th_price_winners"]) {
                            $reward4 = $thisLottery["4th_price"];
                        } else {
                            $reward4 = 0;
                        }
                        if (0 < $thisLottery["3rd_price_winners"]) {
                            $reward3 = $thisLottery["3rd_price"];
                        } else {
                            $reward3 = 0;
                        }
                        if (0 < $thisLottery["2nd_price_winners"]) {
                            $reward2 = $thisLottery["2nd_price"];
                        } else {
                            $reward2 = 0;
                        }
                        if (0 < $thisLottery["1st_price_winners"]) {
                            $reward1 = $thisLottery["1st_price"];
                        } else {
                            $reward1 = 0;
                        }
                    }
                    echo "\r\n                    <tr>\r\n                        <th>" . lang("lottery_txt_43", true) . "</th>\r\n                        <td>" . $reward6 . "</td>\r\n                        <td>" . $reward5 . "</td>\r\n                        <td>" . $reward4 . "</td>\r\n                        <td>" . $reward3 . "</td>\r\n                        <td>" . $reward2 . "</td>\r\n                        <td>" . $reward1 . "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <th colspan=\"7\">" . sprintf(lang("lottery_txt_28", true), $thisLottery["lottery"]) . "</th>\r\n                    </tr>";
                    $myTickets = $Lottery->getMyTickets($_SESSION["username"], $thisLottery["lottery"]);
                    if (is_array($myTickets)) {
                        foreach ($myTickets as $thisTicket) {
                            $compareNumbers = $Lottery->compareNumbers($_SESSION["username"], $thisLottery["lottery"], $thisTicket["id"]);
                            echo "\r\n                    <tr>\r\n                        <td>" . date($config["time_date_format"], strtotime($thisTicket["date"])) . "</td>\r\n                        <td>" . $compareNumbers[1] . "</td>\r\n                        <td>" . $compareNumbers[2] . "</td>\r\n                        <td>" . $compareNumbers[3] . "</td>\r\n                        <td>" . $compareNumbers[4] . "</td>\r\n                        <td>" . $compareNumbers[5] . "</td>\r\n                        <td>" . $compareNumbers[6] . "</td>\r\n                    </tr>";
                        }
                    } else {
                        echo "\r\n                    <tr>\r\n                        <td colspan=\"7\">" . lang("lottery_txt_30", true) . "</td>\r\n                    </tr>";
                    }
                    if ($Lottery->hasReward($_SESSION["username"], $thisLottery["lottery"])) {
                        $rewardAmount = $Lottery->getRewardAmount($_SESSION["username"], $thisLottery["lottery"]);
                        echo "\r\n                    <tr>\r\n                        <td colspan=\"7\">\r\n                            <form method=\"post\" action=\"\">\r\n                                <input type=\"hidden\" name=\"" . Encode("lottery") . "\" value=\"" . Encode($thisLottery["lottery"]) . "\">\r\n                                <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                                <button name=\"reward\" value=\"reward\" class=\"ui-button button1\" ><span class=\"button-left\"><span class=\"button-right\">" . lang("lottery_txt_31", true) . " (" . $rewardAmount . ")</span></span></button>\r\n                            </form>\r\n                        </td>\r\n                    </tr>";
                    }
                    echo "\r\n                </table>\r\n            </div>";
                }
            } else {
                message("info", lang("lottery_txt_27", true));
            }
        } else {
            message("error", lang("error_47", true));
        }
        echo "\r\n\t</div>\r\n</div>";
    }
}

?>