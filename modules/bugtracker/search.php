<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

if (!isLoggedIn()) {
    redirect(1, "login");
} else {
    loadModuleConfigs("bugtracker");
    if (!canAccessModule($_SESSION["username"], "bugtracker", "block")) {
        return NULL;
    }
    if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
        $breadcrumb = generateBreadcrumb();
        echo "\n    <h3>\n        " . lang("module_titles_txt_29", true) . "\n        " . $breadcrumb . "\n    </h3>";
        if (mconfig("active")) {
            $BugTracker = new BugTracker();
            if (isset($_GET["keyword"]) && isset($_GET["type"]) && ($_GET["type"] == "1" || $_GET["type"] == "2")) {
                $category = htmlspecialchars($_GET["type"]);
                $keyword = htmlspecialchars($_GET["keyword"]);
                $search_results = $BugTracker->searchReports($category, $keyword);
                if (is_array($search_results)) {
                    echo "\n    <div class=\"row\">\n        <div class=\"col-xs-12\">\n            <div class=\"table-responsive rankings-table\">\n                <table class=\"table table-hover text-center\">\n                    <tr>\n                        <th class=\"headerRow\">" . lang("bugtracker_txt_14", true) . "</th>\n                        <th class=\"headerRow\">" . lang("bugtracker_txt_15", true) . "</th>\n                        <th class=\"headerRow\">" . lang("bugtracker_txt_16", true) . "</th>\n                        <th class=\"headerRow\">" . lang("bugtracker_txt_17", true) . "</th>\n                    </tr>";
                    foreach ($search_results as $thisReport) {
                        $date = date($config["time_date_format"], strtotime($thisReport["date"]));
                        $thisReport["status"] = $BugTracker->getStatusName($thisReport["status"], "span");
                        echo "\n                    <tr>\n                        <td><a href=\"" . __BASE_URL__ . "bugtracker/view/?id=" . $thisReport["id"] . "\">" . stripslashes($thisReport["title"]) . "</a></td>";
                        if (mconfig("hide_names")) {
                            echo "<td>" . lang("bugtracker_txt_45", true) . "</td>";
                        } else {
                            echo "<td>" . $thisReport["author"] . "</td>";
                        }
                        echo "\n                        <td>" . $date . "</td>\n                        <td>" . $thisReport["status"] . "</td>\n                    </tr>";
                    }
                    echo "\n                </table>\n            </div>\n        </div>\n    </div>";
                } else {
                    message("error", lang("bugtracker_error_2", true));
                }
            } else {
                message("error", lang("error_57", true));
            }
        } else {
            message("error", lang("error_47", true));
        }
    }
}

?>