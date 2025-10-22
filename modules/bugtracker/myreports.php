<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

if (!isLoggedIn()) {
    redirect(1, "login");
} else {
    loadModuleConfigs("bugtracker");
    if (!canAccessModule($_SESSION["username"], "bugtracker", "block")) {
        return NULL;
    }
    $BugTracker = new BugTracker();
    if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
        $breadcrumb = generateBreadcrumb();
        echo "\r\n    <h3>\r\n        " . lang("module_titles_txt_29", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
        if (mconfig("active")) {
            $myreports = $BugTracker->getMyReportsFull($_SESSION["username"]);
            if (is_array($myreports)) {
                echo "\r\n    <div class=\"row\">\r\n        <div class=\"col-xs-12\">\r\n            <div class=\"table-responsive rankings-table\">\r\n                <table class=\"table table-hover text-center\">\r\n                    <tr>\r\n                        <th class=\"headerRow\">" . lang("bugtracker_txt_14", true) . "</th>\r\n                        <th class=\"headerRow\">" . lang("bugtracker_txt_48", true) . "</th>\r\n                        <th class=\"headerRow\">" . lang("bugtracker_txt_16", true) . "</th>\r\n                        <th class=\"headerRow\">" . lang("bugtracker_txt_17", true) . "</th>\r\n                    </tr>";
                foreach ($myreports as $thisReport) {
                    $date = date($config["time_date_format"], strtotime($thisReport["date"]));
                    $thisReport["status"] = $BugTracker->getStatusName($thisReport["status"], "span");
                    echo "\r\n                    <tr>\r\n                        <td><a href=\"" . __BASE_URL__ . "bugtracker/view/?id=" . $thisReport["id"] . "\">" . stripslashes($thisReport["title"]) . "</a></td>";
                    if ($thisReport["updatedBy"] != NULL) {
                        echo "<td>" . $thisReport["updatedBy"] . "</td>";
                    } else {
                        echo "<td>" . $thisReport["author"] . "</td>";
                    }
                    echo "\r\n                        <td>" . $date . "</td>\r\n                        <td>" . $thisReport["status"] . "</td>\r\n                    </tr>";
                }
                echo "\r\n                </table>\r\n            </div>\r\n        </div>\r\n    </div>";
            } else {
                message("error", lang("bugtracker_error_2", true));
            }
        } else {
            message("error", lang("error_47", true));
        }
    } else {
        echo "\r\n<div class=\"sub-page-title\">\r\n    <div id=\"title\"><h1>" . lang("module_titles_txt_29", true) . "<p></p><span></span></h1></div>\r\n</div>\r\n<div class=\"container_2 bug-search-results\" align=\"center\">\r\n    <div class=\"container_3 account_sub_header\">\r\n        <div class=\"grad\">\r\n            <div class=\"page-title\"><p>" . lang("bugtracker_txt_44", true) . "</p></div>\r\n            <a href=\"" . __BASE_URL__ . "bugtracker\">" . lang("bugtracker_txt_2", true) . "</a>\r\n        </div>\r\n    </div>";
        if (mconfig("active")) {
            echo "\r\n    <div class=\"container_3 bug-report-search-results\" style=\"width:843px; padding-top:14px; padding-bottom:10px;\">";
            $myreports = $BugTracker->getMyReportsFull($_SESSION["username"]);
            if (is_array($myreports)) {
                foreach ($myreports as $thisReport) {
                    if ($thisReport["updated"] != NULL) {
                        $date = date($config["time_date_format"], strtotime($thisReport["updated"]));
                    } else {
                        $date = date($config["time_date_format"], strtotime($thisReport["date"]));
                    }
                    $thisReport["status"] = $BugTracker->getStatusName($thisReport["status"], "li");
                    echo "\r\n                <ul class=\"bug-report-row\">\r\n                    <li class=\"title\"><a\r\n                                href=\"";
                    echo __BASE_URL__ . "bugtracker/view/?id=" . $thisReport["id"];
                    echo "\">";
                    echo stripslashes($thisReport["title"]);
                    echo "</a>\r\n                    </li>\r\n                    <li class=\"by\">";
                    echo lang("bugtracker_txt_21", true);
                    echo "                        <b>";
                    if ($thisReport["updatedBy"] != NULL) {
                        echo $thisReport["updatedBy"];
                    } else {
                        echo $thisReport["author"];
                    }
                    echo "</b>\r\n                    </li>\r\n                    <li class=\"date\">";
                    echo $date;
                    echo "</li>\r\n                    ";
                    echo $thisReport["status"];
                    echo "                </ul>\r\n                <div style=\"display: none;\" id=\"";
                    echo $thisReport["id"];
                    echo "\">";
                    echo stripslashes($thisReport["text"]);
                    echo "</div>\r\n\r\n                ";
                }
            } else {
                message("error", lang("bugtracker_error_2", true));
            }
            echo "\r\n    </div>";
        } else {
            message("error", lang("error_47", true));
        }
        echo "\r\n</div>";
    }
}

?>