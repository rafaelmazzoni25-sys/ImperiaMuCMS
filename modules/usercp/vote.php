<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

while (!isLoggedIn()) {
    redirect(1, "login");
}
if (!canAccessModule($_SESSION["username"], "vote", "allow")) {
    return NULL;
}
if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
    $breadcrumb = generateBreadcrumb();
    echo "\r\n    <h3>\r\n        " . lang("myaccount_txt_28", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
    mconfig("credit_config");
    switch (mconfig("credit_config")) {
        case "1":
            $voteReward = "<b>" . lang("currency_platinum", true) . "</b>";
            break;
        case "2":
            $voteReward = "<b>" . lang("currency_gold", true) . "</b>";
            break;
        case "3":
            $voteReward = "<b>" . lang("currency_silver", true) . "</b>";
            break;
        case "4":
            $voteReward = "<b>" . lang("currency_wcoinc", true) . "</b>";
            break;
        case "5":
            $voteReward = "<b>" . lang("currency_gp", true) . "</b>";
            break;
        case "6":
            $voteReward = "<b>" . lang("currency_zen", true) . "</b>";
            break;
        default:
            $voteReward = "";
            if (mconfig("active")) {
                if (0 < mconfig("credit_config")) {
                    echo "\r\n    <div class=\"row desc-row\">\r\n        <div class=\"col-xs-12\">" . sprintf(lang("vfc_txt_4", true), $voteReward) . "</div>\r\n    </div>";
                }
                $Vote = new Vote();
                if (isset($_GET["do"]) && check_value($_GET["do"])) {
                    $voteId = Decode($_GET["do"]);
                    $getName = $dB->query_fetch_single("SELECT votesite_title, postback_enabled, postback_type, votesite_time FROM IMPERIAMUCMS_VOTE_SITES WHERE votesite_id = ?", [$voteId]);
                    if ($getName["postback_enabled"] == "1" && $getName["postback_type"] != NULL && $getName["postback_type"] != "") {
                        if (strtolower($getName["postback_type"]) == "topg") {
                            $timeToCheck = time() - $getName["votesite_time"] * 3600;
                            $checkPendingVote = $dB->query_fetch_single("SELECT vote_site_id FROM IMPERIAMUCMS_VOTES WHERE user_id = ? AND vote_site_id = ? AND timestamp > ?", [$_SESSION["userid"], $voteId, $timeToCheck]);
                            if (!is_array($checkPendingVote)) {
                                $add_logs_data = [$_SESSION["userid"], $_SERVER["REMOTE_ADDR"], $voteId, time(), 0, strtolower($getName["postback_type"])];
                                $dB->query("INSERT INTO IMPERIAMUCMS_VOTES(user_id, user_ip, vote_site_id, timestamp, confirm, postback_type) VALUES (?, ?, ?, ?, ?, ?)", $add_logs_data);
                            }
                        }
                    } else {
                        if ($Vote->canVote($_SESSION["userid"], $voteId, $_SERVER["REMOTE_ADDR"])) {
                            try {
                                $accountInfo = $common->accountInformation($_SESSION["userid"]);
                                if (!is_array($accountInfo)) {
                                    throw new Exception("invalid account");
                                }
                                $credits = $dB->query_fetch_single("SELECT votesite_reward FROM IMPERIAMUCMS_VOTE_SITES WHERE votesite_id = ?", [$voteId]);
                                $credits = $credits["votesite_reward"];
                                $creditSystem = new CreditSystem($common, new Character(), $dB, $dB2);
                                $creditSystem->setConfigId(mconfig("credit_config"));
                                $configSettings = $creditSystem->showConfigs(true);
                                switch ($configSettings["config_user_col_id"]) {
                                    case "userid":
                                        $creditSystem->setIdentifier($accountInfo[_CLMN_MEMBID_]);
                                        break;
                                    case "username":
                                        $creditSystem->setIdentifier($accountInfo[_CLMN_USERNM_]);
                                        break;
                                    case "email":
                                        $creditSystem->setIdentifier($accountInfo[_CLMN_EMAIL_]);
                                        $creditSystem->addCredits($credits);
                                        $add_vote_data = [$_SESSION["userid"], $_SERVER["REMOTE_ADDR"], $voteId, time(), 1];
                                        $add_vote = $dB->query("INSERT INTO IMPERIAMUCMS_VOTES(user_id, user_ip, vote_site_id, timestamp, confirm) VALUES (?, ?, ?, ?, ?)", $add_vote_data);
                                        $logDate = date("Y-m-d H:i:s", time());
                                        $common->accountLogs($_SESSION["username"], "vote", lang("vfc_txt_5", true), $logDate);
                                        break;
                                    default:
                                        throw new Exception("invalid identifier");
                                }
                            } catch (Exception $ex) {
                            }
                        } else {
                            message("error", lang("vfc_txt_6", true));
                        }
                    }
                }
                $sites = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_VOTE_SITES ORDER BY votesite_id");
                echo "\r\n    <div class=\"row\">";
                foreach ($sites as $thisSite) {
                    if ($thisSite["active"] == "1") {
                        $check = $Vote->canVote($_SESSION["userid"], $thisSite["votesite_id"], $_SERVER["REMOTE_ADDR"]);
                        if ($check) {
                            if (strtolower($thisSite["votesite_title"]) == "xtremetop100") {
                                echo "\r\n        <div class=\"col-xs-12 col-sm-6 col-md-3 col-lg-2 vote-box\">\r\n            <a href=\"" . __BASE_URL__ . "usercp/vote/?do=" . Encode($thisSite["votesite_id"]) . "\" onclick=\"window.open('" . $thisSite["votesite_link"] . "&postback=" . $_SESSION["username"] . "', '_newtab'); return true;\">\r\n                <div class=\"vote-box-site\">\r\n                    <div class=\"vote-img\"><img src=\"" . $thisSite["img"] . "\" /></div>\r\n                    <div class=\"vote-text\">" . lang("vfc_txt_7", true) . "</div>\r\n                </div>\r\n            </a>\r\n        </div>";
                            } else {
                                if (strtolower($thisSite["votesite_title"]) == "gtop100") {
                                    echo "\r\n        <div class=\"col-xs-12 col-sm-6 col-md-3 col-lg-2 vote-box\">\r\n            <a href=\"" . __BASE_URL__ . "usercp/vote/?do=" . Encode($thisSite["votesite_id"]) . "\" onclick=\"window.open('" . $thisSite["votesite_link"] . "&pingUsername=" . $_SESSION["username"] . "', '_newtab'); return true;\">\r\n                <div class=\"vote-box-site\">\r\n                    <div class=\"vote-img\"><img src=\"" . $thisSite["img"] . "\" /></div>\r\n                    <div class=\"vote-text\">" . lang("vfc_txt_7", true) . "</div>\r\n                </div>\r\n            </a>\r\n        </div>";
                                } else {
                                    if (strtolower($thisSite["votesite_title"]) == "topg") {
                                        echo "\r\n        <div class=\"col-xs-12 col-sm-6 col-md-3 col-lg-2 vote-box\">\r\n            <a href=\"" . __BASE_URL__ . "usercp/vote/?do=" . Encode($thisSite["votesite_id"]) . "\" onclick=\"window.open('" . $thisSite["votesite_link"] . "-" . $_SESSION["username"] . "', '_newtab'); return true;\">\r\n                <div class=\"vote-box-site\">\r\n                    <div class=\"vote-img\"><img src=\"" . $thisSite["img"] . "\" /></div>\r\n                    <div class=\"vote-text\">" . lang("vfc_txt_7", true) . "</div>\r\n                </div>\r\n            </a>\r\n        </div>";
                                    } else {
                                        if (strtolower($thisSite["votesite_title"]) == "mmtop200") {
                                            echo "\r\n        <div class=\"col-xs-12 col-sm-6 col-md-3 col-lg-2 vote-box\">\r\n            <a href=\"" . __BASE_URL__ . "usercp/vote/?do=" . Encode($thisSite["votesite_id"]) . "\" onclick=\"window.open('" . $thisSite["votesite_link"] . "/" . $_SESSION["username"] . "', '_newtab'); return true;\">\r\n                <div class=\"vote-box-site\">\r\n                    <div class=\"vote-img\"><img src=\"" . $thisSite["img"] . "\" /></div>\r\n                    <div class=\"vote-text\">" . lang("vfc_txt_7", true) . "</div>\r\n                </div>\r\n            </a>\r\n        </div>";
                                        } else {
                                            echo "\r\n        <div class=\"col-xs-12 col-sm-6 col-md-3 col-lg-2 vote-box\">\r\n            <a href=\"" . __BASE_URL__ . "usercp/vote/?do=" . Encode($thisSite["votesite_id"]) . "\" onclick=\"window.open('" . $thisSite["votesite_link"] . "', '_newtab'); return true;\">\r\n                <div class=\"vote-box-site\">\r\n                    <div class=\"vote-img\"><img src=\"" . $thisSite["img"] . "\" /></div>\r\n                    <div class=\"vote-text\">" . lang("vfc_txt_7", true) . "</div>\r\n                </div>\r\n            </a>\r\n        </div>";
                                        }
                                    }
                                }
                            }
                        } else {
                            $top_level = $dB->query_fetch_single("SELECT TOP 1 cLevel FROM Character WHERE AccountID = '" . $_SESSION["username"] . "' ORDER BY cLevel desc");
                            $top_reset = $dB->query_fetch_single("SELECT TOP 1 RESETS FROM Character WHERE AccountID = '" . $_SESSION["username"] . "' ORDER BY RESETS desc");
                            $is_error = false;
                            if (0 < mconfig("required_level") && $top_level["cLevel"] < mconfig("required_level")) {
                                $msg = sprintf(lang("vfc_txt_8", true), mconfig("required_level"));
                                $is_error = true;
                            }
                            if (0 < mconfig("required_reset") && $top_reset["RESETS"] < mconfig("required_reset")) {
                                $msg = sprintf(lang("vfc_txt_8", true), mconfig("required_reset"));
                                $is_error = true;
                            }
                            if (!$is_error) {
                                $sec = $Vote->getSeconds($_SESSION["userid"], $thisSite["votesite_id"], $_SERVER["REMOTE_ADDR"]);
                                $h = floor($sec / 3600);
                                $sec = $sec - $h * 3600;
                                $min = floor($sec / 60);
                                $msg = sprintf(lang("vfc_txt_10", true), $h, $min);
                            }
                            echo "\r\n        <div class=\"col-xs-12 col-sm-6 col-md-3 col-lg-2 vote-box\">\r\n            <a>\r\n                <div class=\"vote-box-site\">\r\n                    <div class=\"vote-img\"><img src=\"" . $thisSite["img"] . "\" /></div>\r\n                    <div class=\"vote-text\">" . $msg . "</div>\r\n                </div>\r\n            </a>\r\n        </div>";
                        }
                    }
                }
                echo "\r\n    </div>";
            } else {
                message("error", lang("error_47", true));
            }
    }
} else {
    mconfig("credit_config");
    switch (mconfig("credit_config")) {
        case "1":
            $voteReward = "<font color=\"#00ffa8\"><b>" . lang("currency_platinum", true) . "</b></font>";
            break;
        case "2":
            $voteReward = "<font color=\"#b38e47\"><b>" . lang("currency_gold", true) . "</b></font>";
            break;
        case "3":
            $voteReward = "<font color=\"#969696\"><b>" . lang("currency_silver", true) . "</b></font>";
            break;
        case "4":
            $voteReward = "<font color=\"#b38e47\"><b>" . lang("currency_wcoinc", true) . "</b></font>";
            break;
        case "5":
            $voteReward = "<font color=\"#b38e47\"><b>" . lang("currency_gp", true) . "</b></font>";
            break;
        case "6":
            $voteReward = "<font color=\"#b38e47\"><b>" . lang("currency_zen", true) . "</b></font>";
            break;
        default:
            $voteReward = "";
            echo "\r\n<div class=\"sub-page-title\">\r\n    <div id=\"title\">\r\n        <h1>" . lang("module_titles_txt_3", true) . "<p></p><span></span></h1>\r\n    </div>\r\n</div>\r\n<div class=\"container_2 account\" align=\"center\">\r\n    <div class=\"cont-image\">\r\n        <div class=\"container_3 account_sub_header\">\r\n            <div class=\"grad\">\r\n                <div class=\"page-title\">" . lang("myaccount_txt_28", true) . "</div>\r\n                <a href=\"" . __BASE_URL__ . "usercp\">" . lang("global_module_1", true) . "</a>\r\n            </div>\r\n        </div>\r\n        <div class=\"vote-page\">\r\n            <div class=\"page-desc-holder\">";
            if (0 < mconfig("credit_config")) {
                echo sprintf(lang("vfc_txt_4", true), $voteReward);
            }
            echo "\r\n            </div>";
            if (mconfig("active")) {
                $Vote = new Vote();
                if (isset($_GET["do"]) && check_value($_GET["do"])) {
                    $voteId = Decode($_GET["do"]);
                    $getName = $dB->query_fetch_single("SELECT votesite_title, postback_enabled, postback_type, votesite_time FROM IMPERIAMUCMS_VOTE_SITES WHERE votesite_id = ?", [$voteId]);
                    if ($getName["postback_enabled"] == "1" && $getName["postback_type"] != NULL && $getName["postback_type"] != "") {
                        if (strtolower($getName["postback_type"]) == "topg") {
                            $timeToCheck = time() - $getName["votesite_time"] * 3600;
                            $checkPendingVote = $dB->query_fetch_single("SELECT vote_site_id FROM IMPERIAMUCMS_VOTES WHERE user_id = ? AND vote_site_id = ? AND timestamp > ?", [$_SESSION["userid"], $voteId, $timeToCheck]);
                            if (!is_array($checkPendingVote)) {
                                $add_logs_data = [$_SESSION["userid"], $_SERVER["REMOTE_ADDR"], $voteId, time(), 0, strtolower($getName["postback_type"])];
                                $dB->query("INSERT INTO IMPERIAMUCMS_VOTES(user_id, user_ip, vote_site_id, timestamp, confirm, postback_type) VALUES (?, ?, ?, ?, ?, ?)", $add_logs_data);
                            }
                        }
                    } else {
                        if ($Vote->canVote($_SESSION["userid"], $voteId, $_SERVER["REMOTE_ADDR"])) {
                            try {
                                $accountInfo = $common->accountInformation($_SESSION["userid"]);
                                if (!is_array($accountInfo)) {
                                    throw new Exception("invalid account");
                                }
                                $credits = $dB->query_fetch_single("SELECT votesite_reward FROM IMPERIAMUCMS_VOTE_SITES WHERE votesite_id = ?", [$voteId]);
                                $credits = $credits["votesite_reward"];
                                $creditSystem = new CreditSystem($common, new Character(), $dB, $dB2);
                                $creditSystem->setConfigId(mconfig("credit_config"));
                                $configSettings = $creditSystem->showConfigs(true);
                                switch ($configSettings["config_user_col_id"]) {
                                    case "userid":
                                        $creditSystem->setIdentifier($accountInfo[_CLMN_MEMBID_]);
                                        break;
                                    case "username":
                                        $creditSystem->setIdentifier($accountInfo[_CLMN_USERNM_]);
                                        break;
                                    case "email":
                                        $creditSystem->setIdentifier($accountInfo[_CLMN_EMAIL_]);
                                        $creditSystem->addCredits($credits);
                                        $add_vote_data = [$_SESSION["userid"], $_SERVER["REMOTE_ADDR"], $voteId, time(), 1];
                                        $add_vote = $dB->query("INSERT INTO IMPERIAMUCMS_VOTES(user_id, user_ip, vote_site_id, timestamp, confirm) VALUES (?, ?, ?, ?, ?)", $add_vote_data);
                                        $logDate = date("Y-m-d H:i:s", time());
                                        $common->accountLogs($_SESSION["username"], "vote", lang("vfc_txt_5", true), $logDate);
                                        break;
                                    default:
                                        throw new Exception("invalid identifier");
                                }
                            } catch (Exception $ex) {
                            }
                        } else {
                            message("error", lang("vfc_txt_6", true));
                        }
                    }
                }
                echo "\r\n            <div class=\"container_3 account-wide\" align=\"center\">\r\n                <ul class=\"vote-sites-cont\">";
                $sites = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_VOTE_SITES ORDER BY votesite_id");
                foreach ($sites as $thisSite) {
                    if ($thisSite["active"] == "1") {
                        $check = $Vote->canVote($_SESSION["userid"], $thisSite["votesite_id"], $_SERVER["REMOTE_ADDR"]);
                        if ($check) {
                            if (strtolower($thisSite["votesite_title"]) == "xtremetop100") {
                                echo "\r\n                    <li>\r\n                        <a href=\"" . __BASE_URL__ . "usercp/vote/?do=" . Encode($thisSite["votesite_id"]) . "\" onclick=\"window.open('" . $thisSite["votesite_link"] . "&postback=" . $_SESSION["username"] . "', '_newtab'); return true;\">\r\n                            <div class=\"vote-site-image\" style=\"background-image:url(" . $thisSite["img"] . ")\"></div>\r\n                            <p>" . lang("vfc_txt_7", true) . "</p>\r\n                        </a>\r\n                    </li>";
                            } else {
                                if (strtolower($thisSite["votesite_title"]) == "gtop100") {
                                    echo "\r\n                    <li>\r\n                        <a href=\"" . __BASE_URL__ . "usercp/vote/?do=" . Encode($thisSite["votesite_id"]) . "\" onclick=\"window.open('" . $thisSite["votesite_link"] . "&pingUsername=" . $_SESSION["username"] . "', '_newtab'); return true;\">\r\n                            <div class=\"vote-site-image\" style=\"background-image:url(" . $thisSite["img"] . ")\"></div>\r\n                            <p>" . lang("vfc_txt_7", true) . "</p>\r\n                        </a>\r\n                    </li>";
                                } else {
                                    if (strtolower($thisSite["votesite_title"]) == "topg") {
                                        echo "\r\n                    <li>\r\n                        <a href=\"" . __BASE_URL__ . "usercp/vote/?do=" . Encode($thisSite["votesite_id"]) . "\" onclick=\"window.open('" . $thisSite["votesite_link"] . "-" . $_SESSION["username"] . "', '_newtab'); return true;\">\r\n                            <div class=\"vote-site-image\" style=\"background-image:url(" . $thisSite["img"] . ")\"></div>\r\n                            <p>" . lang("vfc_txt_7", true) . "</p>\r\n                        </a>\r\n                    </li>";
                                    } else {
                                        if (strtolower($thisSite["votesite_title"]) == "mmtop200") {
                                            echo "\r\n                    <li>\r\n                        <a href=\"" . __BASE_URL__ . "usercp/vote/?do=" . Encode($thisSite["votesite_id"]) . "\" onclick=\"window.open('" . $thisSite["votesite_link"] . "/" . $_SESSION["username"] . "', '_newtab'); return true;\">\r\n                            <div class=\"vote-site-image\" style=\"background-image:url(" . $thisSite["img"] . ")\"></div>\r\n                            <p>" . lang("vfc_txt_7", true) . "</p>\r\n                        </a>\r\n                    </li>";
                                        } else {
                                            echo "\r\n                    <li>\r\n                        <a href=\"" . __BASE_URL__ . "usercp/vote/?do=" . Encode($thisSite["votesite_id"]) . "\" onclick=\"window.open('" . $thisSite["votesite_link"] . "', '_newtab'); return true;\">\r\n                            <div class=\"vote-site-image\" style=\"background-image:url(" . $thisSite["img"] . ")\"></div>\r\n                            <p>" . lang("vfc_txt_7", true) . "</p>\r\n                        </a>\r\n                    </li>";
                                        }
                                    }
                                }
                            }
                        } else {
                            $top_level = $dB->query_fetch_single("SELECT TOP 1 cLevel FROM Character WHERE AccountID = '" . $_SESSION["username"] . "' ORDER BY cLevel desc");
                            $top_reset = $dB->query_fetch_single("SELECT TOP 1 RESETS FROM Character WHERE AccountID = '" . $_SESSION["username"] . "' ORDER BY RESETS desc");
                            $is_error = false;
                            if (0 < mconfig("required_level") && $top_level["cLevel"] < mconfig("required_level")) {
                                $msg = sprintf(lang("vfc_txt_8", true), mconfig("required_level"));
                                $is_error = true;
                            }
                            if (0 < mconfig("required_reset") && $top_reset["RESETS"] < mconfig("required_reset")) {
                                $msg = sprintf(lang("vfc_txt_8", true), mconfig("required_reset"));
                                $is_error = true;
                            }
                            if (!$is_error) {
                                $sec = $Vote->getSeconds($_SESSION["userid"], $thisSite["votesite_id"], $_SERVER["REMOTE_ADDR"]);
                                $h = floor($sec / 3600);
                                $sec = $sec - $h * 3600;
                                $min = floor($sec / 60);
                                $msg = sprintf(lang("vfc_txt_10", true), $h, $min);
                            }
                            echo "\r\n                <li>\r\n                    <a>\r\n                        <div class=\"vote-site-image\" style=\"background-image:url(" . $thisSite["img"] . ")\"></div>\r\n                        <p>" . $msg . "</p>\r\n                    </a>\r\n                </li>";
                        }
                    }
                }
                echo "\r\n                </ul>\r\n            </div>";
            } else {
                message("error", lang("error_47", true));
            }
            echo "\r\n        </div>\r\n    </div>\r\n</div>";
    }
}

?>