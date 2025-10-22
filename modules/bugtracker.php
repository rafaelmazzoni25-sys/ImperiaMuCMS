<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */
if (!isLoggedIn()) {
    redirect(1, "login");
} else {
    if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
        $breadcrumb = generateBreadcrumb();
        echo "\r\n    <h3>\r\n        " . lang("module_titles_txt_29", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
        if (mconfig("active")) {
            $General = new xGeneral();
            $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("bugtracker");
            $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("bugtracker");
            $BugTracker = new BugTracker();
            $reports = $BugTracker->getReports();
            $app_reports = $BugTracker->getApprovedReports();
            $my_reports = $BugTracker->getMyReports();
            $my_app_reports = $BugTracker->getMyApprovedReports();
            $reward_type = mconfig("reward_type");
            if ($reward_type == "1") {
                $reward_type = lang("currency_platinum", true);
            } else {
                if ($reward_type == "2") {
                    $reward_type = lang("currency_gold", true);
                } else {
                    if ($reward_type == "3") {
                        $reward_type = lang("currency_silver", true);
                    } else {
                        if ($reward_type == "4") {
                            $reward_type = lang("currency_wcoinc", true);
                        } else {
                            if ($reward_type == "5") {
                                $reward_type = lang("currency_gp", true);
                            } else {
                                if ($reward_type == "6") {
                                    $reward_type = "" . lang("currency_zen", true) . "";
                                }
                            }
                        }
                    }
                }
            }
            echo "\r\n    <div class=\"row\">\r\n        <form method=\"get\" action=\"" . __BASE_URL__ . "bugtracker/search/\">\r\n            <div class=\"col-xs-12 col-sm-6\">\r\n                <input type=\"text\" placeholder=\"" . lang("bugtracker_txt_22", true) . "\" name=\"keyword\" class=\"form-control\">\r\n            </div>\r\n            <div class=\"col-xs-12 col-sm-3\">\r\n                <select id=\"search-category\" name=\"type\" class=\"form-control\">\r\n                    <option value=\"0\" disabled=\"disabled\">" . lang("bugtracker_txt_4", true) . "</option>\r\n                    <option value=\"1\">" . lang("bugtracker_txt_5", true) . "</option>\r\n                    <option value=\"2\" selected=\"selected\">" . lang("bugtracker_txt_6", true) . "</option>\r\n                </select>\r\n            </div>\r\n            <div class=\"col-xs-12 col-sm-3\">\r\n                <input type=\"submit\" value=\"" . lang("bugtracker_txt_20", true) . "\" class=\"btn btn-warning bug-tracker-search\">\r\n            </div>\r\n        </form>\r\n    </div>\r\n    <div class=\"row\">\r\n        <div class=\"col-xs-12 col-sm-4\">\r\n            <div class=\"bug-reports-holder reports\">\r\n                <h1>" . $reports . "</h1>\r\n                <h3>" . lang("bugtracker_txt_23", true) . "</h3>\r\n            </div>\r\n        </div>\r\n        <div class=\"col-xs-12 col-sm-4\">\r\n            <div class=\"bug-reports-holder confirmed\">\r\n                <h1>" . $app_reports . "</h1>\r\n                <h3>" . lang("bugtracker_txt_24", true) . "</h3>\r\n            </div>\r\n        </div>\r\n        <div class=\"col-xs-12 col-sm-4\">\r\n            <a href=\"" . __BASE_URL__ . "bugtracker/submit\">\r\n                <div class=\"bug-reports-holder submit-bug-report\">\r\n                    <div class=\"plus-ico\">\r\n                        <span class=\"glyphicon glyphicon-plus\" aria-hidden=\"true\"></span>\r\n                    </div>\r\n                    <h1>" . lang("bugtracker_txt_25", true) . "</h1>\r\n                </div>\r\n            </a>\r\n        </div>\r\n    </div>\r\n    <div class=\"row\">\r\n        <div class=\"col-xs-12\">\r\n            <div class=\"my-reports\">\r\n                <span>" . sprintf(lang("bugtracker_txt_26", true), $my_reports, $my_app_reports) . "</span>\r\n                <div style=\"float: right;\">\r\n                    <a href=\"" . __BASE_URL__ . "bugtracker/myreports/\">" . lang("bugtracker_txt_43", true) . "</a>\r\n                </div>\r\n            </div>\r\n        </div>\r\n    </div>\r\n    <div class=\"row\">\r\n        <div class=\"col-xs-12\">\r\n            <div class=\"bug-tracker-info\">\r\n                <h3>" . lang("bugtracker_txt_27", true) . "</h3>\r\n                <b>" . lang("bugtracker_txt_28", true) . "</b><br><br>\r\n                " . lang("bugtracker_txt_29", true) . "\r\n                <i>" . lang("bugtracker_txt_30", true);
            if (mconfig("isreward")) {
                echo sprintf(lang("bugtracker_txt_31", true), mconfig("reward_value"), $reward_type);
            }
            echo "\r\n                </i>\r\n            </div>\r\n        </div>\r\n    </div>";
        } else {
            message("error", lang("error_47", true));
        }
    } else {
        echo "\r\n    <div class=\"sub-page-title\">\r\n        <div id=\"title\">\r\n            <h1>";
        echo lang("module_titles_txt_29", true);
        echo "<p></p><span></span></h1>\r\n        </div>\r\n    </div>\r\n\r\n    ";
        if (mconfig("active")) {
            $General = new xGeneral();
            $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("bugtracker");
            $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("bugtracker");
            $BugTracker = new BugTracker();
            $reports = $BugTracker->getReports();
            $app_reports = $BugTracker->getApprovedReports();
            $my_reports = $BugTracker->getMyReports();
            $my_app_reports = $BugTracker->getMyApprovedReports();
            $reward_type = mconfig("reward_type");
            if ($reward_type == "1") {
                $reward_type = lang("currency_platinum", true);
            } else {
                if ($reward_type == "2") {
                    $reward_type = lang("currency_gold", true);
                } else {
                    if ($reward_type == "3") {
                        $reward_type = lang("currency_silver", true);
                    } else {
                        if ($reward_type == "4") {
                            $reward_type = lang("currency_wcoinc", true);
                        } else {
                            if ($reward_type == "5") {
                                $reward_type = lang("currency_gp", true);
                            } else {
                                if ($reward_type == "6") {
                                    $reward_type = "" . lang("currency_zen", true) . "";
                                }
                            }
                        }
                    }
                }
            }
            if (check_value($_POST["search"])) {
                echo "\r\n    <div class=\"container_2 bug-search-results\" align=\"center\">\r\n        <div class=\"container_3 account_sub_header\">\r\n            <div class=\"grad\">\r\n                <div class=\"page-title\"><p>" . lang("bugtracker_txt_20", true) . "</p></div>\r\n                <div class=\"sub-active-page\">\"" . $keyword . "\"</div>\r\n                <a href=\"" . __BASE_URL__ . "bugtracker\">" . lang("bugtracker_txt_2", true) . "</a>\r\n            </div>\r\n        </div>\r\n    <div class=\"container_3 bug-report-search-results\" style=\"width:843px; padding-top:14px; padding-bottom:10px;\">";
                if (check_value($_POST["mainCategory"])) {
                    $category = htmlspecialchars($_POST["mainCategory"]);
                    $keyword = htmlspecialchars($_POST["keyword"]);
                    $search_results = $BugTracker->searchReports($category, $keyword);
                    if (is_array($search_results)) {
                        foreach ($search_results as $thisReport) {
                            $date = date($config["time_date_format"], strtotime($thisReport["date"]));
                            $thisReport["status"] = $BugTracker->getStatusName($thisReport["status"], "li");
                            echo "\r\n                        <ul class=\"bug-report-row\">\r\n                            <li class=\"title\">\r\n                                <a href=\"";
                            echo __BASE_URL__ . "bugtracker/view/?id=" . $thisReport["id"];
                            echo "\">";
                            echo stripslashes($thisReport["title"]);
                            echo "</a>\r\n                            </li>\r\n                            <li class=\"by\">";
                            echo lang("bugtracker_txt_21", true);
                            echo "                                ";
                            if (mconfig("hide_names")) {
                                echo "<b>" . lang("bugtracker_txt_45", true) . "</b>";
                            } else {
                                echo "<b>" . $thisReport["author"] . "</b>";
                            }
                            echo "                            </li>\r\n                            <li class=\"date\">";
                            echo $date;
                            echo "</li>\r\n                            ";
                            echo $thisReport["status"];
                            echo "                        </ul>\r\n                        <div style=\"display: none;\"\r\n                             id=\"";
                            echo $thisReport["id"];
                            echo "\">";
                            echo stripslashes($thisReport["text"]);
                            echo "</div>\r\n\r\n                        ";
                        }
                    } else {
                        message("error", lang("bugtracker_error_2", true));
                    }
                } else {
                    message("error", lang("error_57", true));
                }
                echo "</div></div>";
            } else {
                echo "\r\n            <div class=\"container_2\" align=\"center\">\r\n\r\n                <!-- Bug Report Search -->\r\n                <div class=\"bugs-search-bar container_3\">\r\n                    <form method=\"post\" action=\"\">\r\n                        <input type=\"text\" placeholder=\"";
                echo lang("bugtracker_txt_22", true);
                echo "\" name=\"keyword\">\r\n                        <select styled=\"styled\" id=\"search-category\" name=\"mainCategory\" style=\"display: none;\">\r\n                            <option value=\"0\" disabled=\"disabled\">";
                echo lang("bugtracker_txt_4", true);
                echo "</option>\r\n                            <option value=\"1\">";
                echo lang("bugtracker_txt_5", true);
                echo "</option>\r\n                            <option value=\"2\" selected=\"selected\">";
                echo lang("bugtracker_txt_6", true);
                echo "</option>\r\n\r\n                        </select>\r\n\r\n                        <input type=\"submit\" value=\"";
                echo lang("bugtracker_txt_20", true);
                echo "\" name=\"search\">\r\n                    </form>\r\n                </div>\r\n                <!-- Bug Report Search.End -->\r\n\r\n\r\n                <!-- BUG TRACKER - Main Page -->\r\n                <div class=\"holder-bugtracker\">\r\n\r\n                    <div class=\"bug-reports-holder reports\">\r\n                        <h1>";
                echo $reports;
                echo "</h1>\r\n\r\n                        <h3>";
                echo lang("bugtracker_txt_23", true);
                echo "</h3>\r\n                    </div>\r\n\r\n                    <div class=\"bug-reports-holder confirmed\">\r\n                        <h1>";
                echo $app_reports;
                echo "</h1>\r\n\r\n                        <h3>";
                echo lang("bugtracker_txt_24", true);
                echo "</h3>\r\n                    </div>\r\n\r\n                    <a href=\"";
                echo __BASE_URL__;
                echo "bugtracker/submit\" class=\"submit-bug-report\">\r\n                        <div class=\"plus-ico\">\r\n                            <div id=\"partone\"></div>\r\n                            <div id=\"parttwo\"></div>\r\n                        </div>\r\n                        <h1>";
                echo lang("bugtracker_txt_25", true);
                echo "</h1>\r\n                    </a>\r\n\r\n                    <div class=\"clear\"></div>\r\n\r\n                    <div class=\"bugs-submited-by-me\">\r\n                        ";
                echo sprintf(lang("bugtracker_txt_26", true), $my_reports, $my_app_reports);
                echo "                        <div style=\"float: right;\"><a\r\n                                    href=\"";
                echo __BASE_URL__;
                echo "bugtracker/myreports/\">";
                echo lang("bugtracker_txt_43", true);
                echo "</a>\r\n                        </div>\r\n                    </div>\r\n\r\n                    <div class=\"bug-tracker-info\">\r\n\r\n                        <h3><font color=\"#c7962c\">";
                echo lang("bugtracker_txt_27", true);
                echo "</font></h3>\r\n                        <br>\r\n                        <b><font color=\"#79736a\">";
                echo lang("bugtracker_txt_28", true);
                echo "</font></b> <br><br>\r\n                        <font color=\"#656059\">\r\n                            ";
                echo lang("bugtracker_txt_29", true);
                echo "                        </font>\r\n\r\n                        <i><font color=\"#79736a\">";
                echo lang("bugtracker_txt_30", true);
                echo "                                ";
                if (mconfig("isreward")) {
                    echo sprintf(lang("bugtracker_txt_31", true), mconfig("reward_value"), $reward_type);
                }
                echo "</font></i>\r\n                    </div>\r\n\r\n                </div>\r\n                <!-- BUG TRACKER - Main Page . End -->\r\n\r\n            </div>\r\n\r\n        ";
            }
        } else {
            message("error", lang("error_47", true));
        }
    }
}

?>