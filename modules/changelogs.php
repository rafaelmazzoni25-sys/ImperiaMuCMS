<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

if (!defined(__RESPONSIVE__) || __RESPONSIVE__ == "FALSE") {
    if (!check_value($_REQUEST["subpage"])) {
        redirect(1, $_REQUEST["page"] . "/server/");
    }
} else {
    loadModuleConfigs("changelog");
    $Changelog = new Changelog();
    $breadcrumb = generateBreadcrumb();
    echo "\r\n    <h3>\r\n        " . lang("changelogs_txt_1", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
    if (mconfig("active")) {
        $limit = 10;
        $page = $_GET["pg"];
        if ($page == NULL) {
            $page = 1;
        }
        $listSrv = $Changelog->retrieveChangelogSrv($page, $limit);
        $listWeb = $Changelog->retrieveChangelogWeb($page, $limit);
        $totalSrv = $Changelog->retrieveChangelogSrvAll();
        $totalWeb = $Changelog->retrieveChangelogWebAll();
        if (isset($_GET["type"])) {
            if ($_GET["type"] == "1") {
                $serverActive = "active";
                $serverActiveExp = "true";
                $serverActiveLi = "active";
                $websiteActive = "";
                $websiteActiveExp = "false";
                $websiteActiveLi = "next";
            } else {
                if ($_GET["type"] == "2") {
                    $serverActive = "";
                    $serverActiveExp = "false";
                    $serverActiveLi = "next";
                    $websiteActive = "active";
                    $websiteActiveExp = "true";
                    $websiteActiveLi = "active";
                }
            }
        } else {
            $serverActive = "active";
            $serverActiveExp = "true";
            $serverActiveLi = "active";
            $websiteActive = "";
            $websiteActiveExp = "false";
            $websiteActiveLi = "next";
        }
        echo "\r\n    <div class=\"row\">\r\n        <div class=\"col-xs-12\">\r\n            <div role=\"tabpanel\" data-example-id=\"togglable-tabs\">\r\n                <ul id=\"changelogsTabs\" class=\"nav nav-tabs nav-tabs-responsive\" role=\"tablist\">\r\n                    <li role=\"presentation\" class=\"" . $serverActiveLi . "\">\r\n                        <a href=\"" . __BASE_URL__ . "changelogs?type=1&pg=1\" class=\"changelogs-tab\">\r\n                            <span class=\"text\">" . lang("changelogs_txt_2", true) . "</span>\r\n                        </a>\r\n                    </li>\r\n                    <li role=\"presentation\" class=\"" . $websiteActiveLi . "\">\r\n                        <a href=\"" . __BASE_URL__ . "changelogs?type=2&pg=1\" class=\"changelogs-tab\">\r\n                            <span class=\"text\">" . lang("changelogs_txt_3", true) . "</span>\r\n                        </a>\r\n                    </li>\r\n                </ul>\r\n                <div id=\"changelogsContent\" class=\"tab-content\">\r\n                    <div role=\"tabpanel\" class=\"tab-pane fade in " . $serverActive . "\" id=\"serverChangelogs\" aria-labelledby=\"server-tab\">";
        if (is_array($listSrv)) {
            echo "\r\n                        <div class=\"table-responsive rankings-table\">\r\n                            <table class=\"table table-hover text-center\">\r\n                                <tbody>";
            foreach ($listSrv as $thisLog) {
                echo "\r\n                                    <tr>\r\n                                        <td class=\"changelog-rev\">" . $thisLog["title"] . "</td>\r\n                                        <td class=\"changelog-by\">" . $thisLog["author"] . "</td>\r\n                                        <td class=\"changelog-date\">" . date($config["date_format"], strtotime($thisLog["date"])) . "</td>\r\n                                        <td class=\"changelog-info\">" . $thisLog["text"] . "</td>\r\n                                    </tr>";
            }
            echo "\r\n                                </tbody>\r\n                            </table>\r\n                        </div>\r\n                        <div class=\"row\">\r\n                            <nav aria-label=\"pagination\" class=\"col-xs-12 text-center\">\r\n                                <ul class=\"pagination\">";
            $totalPagesSrv = ceil($totalSrv / $limit);
            generatePagination($totalPagesSrv, $page, __BASE_URL__ . "changelogs?type=1&pg=%pageHolder%");
            echo "\r\n                                </ul>\r\n                            </nav>\r\n                        </div>";
        } else {
            message("error", lang("changelogs_error_1", true));
        }
        echo "\r\n                    </div>\r\n                    <div role=\"tabpanel\" class=\"tab-pane fade in " . $websiteActive . "\" id=\"websiteChangelogs\" aria-labelledby=\"website-tab\">";
        if (is_array($listWeb)) {
            echo "\r\n                        <div class=\"table-responsive rankings-table\">\r\n                            <table class=\"table table-hover text-center\">\r\n                                <tbody>";
            foreach ($listWeb as $thisLog) {
                echo "\r\n                                    <tr>\r\n                                        <td class=\"changelog-rev\">" . $thisLog["title"] . "</td>\r\n                                        <td class=\"changelog-by\">" . $thisLog["author"] . "</td>\r\n                                        <td class=\"changelog-date\">" . date($config["date_format"], strtotime($thisLog["date"])) . "</td>\r\n                                        <td class=\"changelog-info\">" . $thisLog["text"] . "</td>\r\n                                    </tr>";
            }
            echo "\r\n                                </tbody>\r\n                            </table>\r\n                        </div>\r\n                        <div class=\"row\">\r\n                            <nav aria-label=\"pagination\" class=\"col-xs-12 text-center\">\r\n                                <ul class=\"pagination\">";
            $totalPagesWeb = ceil($totalWeb / $limit);
            generatePagination($totalPagesWeb, $page, __BASE_URL__ . "changelogs?type=2&pg=%pageHolder%");
            echo "\r\n                                </ul>\r\n                            </nav>\r\n                        </div>";
        } else {
            message("error", lang("changelogs_error_1", true));
        }
        echo "\r\n                    </div>\r\n                </div>\r\n            </div>\r\n        </div>\r\n    </div>";
    } else {
        message("error", lang("error_47", true));
    }
}

?>