<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$Rankings = new Rankings();
if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
    echo "<script type=\"text/javascript\" SRC=\"" . __PATH_TEMPLATE_ASSETS__ . "js/tooltip.js\"></script>";
    $breadcrumb = generateBreadcrumb();
    echo "\r\n    <h3>\r\n        " . lang("module_titles_txt_10", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
    $menu = $Rankings->rankingsMenu(false);
    echo $menu;
    loadModuleConfigs("rankings");
    if (mconfig("active")) {
        $showTabs = true;
        if ($showTabs) {
            echo "\r\n            <div role=\"tabpanel\" data-example-id=\"togglable-tabs\">\r\n                <ul id=\"rankingsTabs\" class=\"nav nav-tabs nav-tabs-responsive\" role=\"tablist\">";
            $isActive = "active";
            $isExpanded = "true";
            $count = 0;
            if (mconfig("rankings_enable_duels")["@attributes"]["general"] == "1") {
                $count++;
                echo "\r\n                    <li role=\"presentation\" class=\"" . $isActive . "\">\r\n                        <a href=\"#general\" id=\"general-tab\" role=\"tab\" data-toggle=\"tab\" aria-controls=\"general\" aria-expanded=\"" . $isExpanded . "\">\r\n                            <span class=\"text\">" . lang("rankings_txt_80", true) . "</span>\r\n                        </a>\r\n                    </li>";
                $isActive = "";
                $isExpanded = "false";
            }
            if (mconfig("rankings_enable_duels")["@attributes"]["monthly"] == "1") {
                $count++;
                if ($count == 2) {
                    $isActive = "next";
                }
                echo "\r\n                    <li role=\"presentation\" class=\"" . $isActive . "\">\r\n                        <a href=\"#monthly\" id=\"general-tab\" role=\"tab\" data-toggle=\"tab\" aria-controls=\"monthly\" aria-expanded=\"" . $isExpanded . "\">\r\n                            <span class=\"text\">" . lang("rankings_txt_83", true) . "</span>\r\n                        </a>\r\n                    </li>";
                $isActive = "";
                $isExpanded = "false";
            }
            if (mconfig("rankings_enable_duels")["@attributes"]["weekly"] == "1") {
                $count++;
                if ($count == 2) {
                    $isActive = "next";
                }
                echo "\r\n                    <li role=\"presentation\" class=\"" . $isActive . "\">\r\n                        <a href=\"#weekly\" id=\"general-tab\" role=\"tab\" data-toggle=\"tab\" aria-controls=\"weekly\" aria-expanded=\"" . $isExpanded . "\">\r\n                            <span class=\"text\">" . lang("rankings_txt_82", true) . "</span>\r\n                        </a>\r\n                    </li>";
                $isActive = "";
                $isExpanded = "false";
            }
            if (mconfig("rankings_enable_duels")["@attributes"]["daily"] == "1") {
                $count++;
                if ($count == 2) {
                    $isActive = "next";
                }
                echo "\r\n                    <li role=\"presentation\" class=\"" . $isActive . "\">\r\n                        <a href=\"#daily\" id=\"general-tab\" role=\"tab\" data-toggle=\"tab\" aria-controls=\"daily\" aria-expanded=\"" . $isExpanded . "\">\r\n                            <span class=\"text\">" . lang("rankings_txt_81", true) . "</span>\r\n                        </a>\r\n                    </li>";
                $isActive = "";
                $isExpanded = "false";
            }
            echo "\r\n                </ul>\r\n                <div id=\"rankingsContent\" class=\"tab-content\">";
        }
        $isActive = "in active";
        if (mconfig("rankings_enable_duels")["@attributes"]["general"] == "1") {
            echo "<div role=\"tabpanel\" class=\"tab-pane fade " . $isActive . "\" id=\"general\" aria-labelledby=\"general-tab\">";
            $isActive = "";
            $ranking_data = LoadCacheData("rankings_duels.cache");
            echo "\r\n        <div class=\"table-responsive rankings-table\">\r\n            <table class=\"table table-hover text-center\">\r\n                <thead>\r\n                    <tr>";
            if (mconfig("rankings_show_place_number")) {
                echo "<th>#</th>";
            }
            echo "\r\n                        <th>" . lang("rankings_txt_10", true) . "</th>\r\n                        <th>" . lang("rankings_txt_11", true) . "</th>\r\n                        <th>" . lang("rankings_txt_38", true) . "</th>\r\n                        <th>" . lang("rankings_txt_42", true) . "</th>\r\n                        <th>" . lang("rankings_txt_43", true) . "</th>";
            if ($config["flags"]) {
                echo "<th>" . lang("global_module_11", true) . "</th>";
            }
            echo "\r\n                    </tr>\r\n                </thead>\r\n                <tbody>";
            $i = 0;
            foreach ($ranking_data as $rdata) {
                if (1 <= $i) {
                    $total = $rdata[2] + $rdata[3];
                    $winratio = $rdata[2] * 100 / $total;
                    echo "<tr>";
                    if (mconfig("rankings_show_place_number")) {
                        echo "<td>" . $i . "</td>";
                    }
                    echo "<td><a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($rdata[0]) . "/\">" . $common->replaceHtmlSymbols($rdata[0]) . "</a></td>";
                    echo "<td>" . $custom["character_class"][$rdata[1]][0] . "</td>";
                    echo "<td>" . number_format($rdata[2]) . "</td>";
                    echo "<td>" . number_format($rdata[3]) . "</td>";
                    echo "<td>" . number_format($winratio, 2) . "%</td>";
                    if ($config["flags"]) {
                        echo "<td><img src=\"" . __PATH_TEMPLATE__ . "images/blank.png\" class=\"flag-icon flag-icon-" . $rdata[4] . "\" alt=\"" . $custom["countries"][$rdata[4]] . "\" title=\"" . $custom["countries"][$rdata[4]] . "\" /></td>";
                    }
                    echo "</tr>";
                }
                $i++;
            }
            echo "\r\n                </tbody>\r\n            </table>\r\n        </div>";
            if (mconfig("rankings_show_date")) {
                echo "<div class=\"rankings-update-time\">";
                echo lang("rankings_txt_20", true) . " " . date($config["time_date_format"], $ranking_data[0][0]);
                echo "</div>";
            }
            echo "</div>";
        }
        if (mconfig("rankings_enable_duels")["@attributes"]["monthly"] == "1") {
            echo "\r\n                <div role=\"tabpanel\" class=\"tab-pane fade " . $isActive . "\" id=\"monthly\" aria-labelledby=\"monthly-tab\">";
            $isActive = "";
            $ranking_data = LoadCacheData("monthly_rankings/rankings_duels.cache");
            echo "\r\n        <div class=\"table-responsive rankings-table\">\r\n            <table class=\"table table-hover text-center\">\r\n                <thead>\r\n                    <tr>";
            if (mconfig("rankings_show_place_number")) {
                echo "<th>#</th>";
            }
            echo "\r\n                        <th>" . lang("rankings_txt_10", true) . "</th>\r\n                        <th>" . lang("rankings_txt_11", true) . "</th>\r\n                        <th>" . lang("rankings_txt_38", true) . "</th>\r\n                        <th>" . lang("rankings_txt_42", true) . "</th>\r\n                        <th>" . lang("rankings_txt_43", true) . "</th>";
            if ($config["flags"]) {
                echo "<th>" . lang("global_module_11", true) . "</th>";
            }
            echo "\r\n                    </tr>\r\n                </thead>\r\n                <tbody>";
            $i = 0;
            foreach ($ranking_data as $rdata) {
                if (1 <= $i) {
                    $total = $rdata[2] + $rdata[3];
                    $winratio = $rdata[2] * 100 / $total;
                    echo "<tr>";
                    if (mconfig("rankings_show_place_number")) {
                        echo "<td>" . $i . "</td>";
                    }
                    echo "<td><a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($rdata[0]) . "/\">" . $common->replaceHtmlSymbols($rdata[0]) . "</a></td>";
                    echo "<td>" . $custom["character_class"][$rdata[1]][0] . "</td>";
                    echo "<td><span class=\"rankings-progress\">+" . number_format($rdata[2]) . "</span></td>";
                    echo "<td><span class=\"rankings-progress-neg\">+" . number_format($rdata[3]) . "</span></td>";
                    echo "<td>" . number_format($winratio, 2) . "%</td>";
                    if ($config["flags"]) {
                        echo "<td><img src=\"" . __PATH_TEMPLATE__ . "images/blank.png\" class=\"flag-icon flag-icon-" . $rdata[4] . "\" alt=\"" . $custom["countries"][$rdata[4]] . "\" title=\"" . $custom["countries"][$rdata[4]] . "\" /></td>";
                    }
                    echo "</tr>";
                }
                $i++;
            }
            echo "\r\n                </tbody>\r\n            </table>\r\n        </div>";
            if (mconfig("rankings_show_date")) {
                echo "<div class=\"rankings-update-time\">";
                echo lang("rankings_txt_20", true) . " " . date($config["time_date_format"], $ranking_data[0][0]);
                echo "</div>";
            }
            if (mconfig("rewards_duels")["@attributes"]["monthly"]) {
                $rewardsHtml = $Rankings->returnRewardsHtml("monthly_duels");
                if ($rewardsHtml != NULL) {
                    echo $rewardsHtml;
                }
            }
            echo "</div>";
        }
        if (mconfig("rankings_enable_duels")["@attributes"]["weekly"] == "1") {
            echo "\r\n                <div role=\"tabpanel\" class=\"tab-pane fade " . $isActive . "\" id=\"weekly\" aria-labelledby=\"weekly-tab\">";
            $isActive = "";
            $ranking_data = LoadCacheData("weekly_rankings/rankings_duels.cache");
            echo "\r\n        <div class=\"table-responsive rankings-table\">\r\n            <table class=\"table table-hover text-center\">\r\n                <thead>\r\n                    <tr>";
            if (mconfig("rankings_show_place_number")) {
                echo "<th>#</th>";
            }
            echo "\r\n                        <th>" . lang("rankings_txt_10", true) . "</th>\r\n                        <th>" . lang("rankings_txt_11", true) . "</th>\r\n                        <th>" . lang("rankings_txt_38", true) . "</th>\r\n                        <th>" . lang("rankings_txt_42", true) . "</th>\r\n                        <th>" . lang("rankings_txt_43", true) . "</th>";
            if ($config["flags"]) {
                echo "<th>" . lang("global_module_11", true) . "</th>";
            }
            echo "\r\n                    </tr>\r\n                </thead>\r\n                <tbody>";
            $i = 0;
            foreach ($ranking_data as $rdata) {
                if (1 <= $i) {
                    $total = $rdata[2] + $rdata[3];
                    $winratio = $rdata[2] * 100 / $total;
                    echo "<tr>";
                    if (mconfig("rankings_show_place_number")) {
                        echo "<td>" . $i . "</td>";
                    }
                    echo "<td><a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($rdata[0]) . "/\">" . $common->replaceHtmlSymbols($rdata[0]) . "</a></td>";
                    echo "<td>" . $custom["character_class"][$rdata[1]][0] . "</td>";
                    echo "<td><span class=\"rankings-progress\">+" . number_format($rdata[2]) . "</span></td>";
                    echo "<td><span class=\"rankings-progress-neg\">+" . number_format($rdata[3]) . "</span></td>";
                    echo "<td>" . number_format($winratio, 2) . "%</td>";
                    if ($config["flags"]) {
                        echo "<td><img src=\"" . __PATH_TEMPLATE__ . "images/blank.png\" class=\"flag-icon flag-icon-" . $rdata[4] . "\" alt=\"" . $custom["countries"][$rdata[4]] . "\" title=\"" . $custom["countries"][$rdata[4]] . "\" /></td>";
                    }
                    echo "</tr>";
                }
                $i++;
            }
            echo "\r\n                </tbody>\r\n            </table>\r\n        </div>";
            if (mconfig("rankings_show_date")) {
                echo "<div class=\"rankings-update-time\">";
                echo lang("rankings_txt_20", true) . " " . date($config["time_date_format"], $ranking_data[0][0]);
                echo "</div>";
            }
            if (mconfig("rewards_duels")["@attributes"]["weekly"]) {
                $rewardsHtml = $Rankings->returnRewardsHtml("weekly_duels");
                if ($rewardsHtml != NULL) {
                    echo $rewardsHtml;
                }
            }
            echo "</div>";
        }
        if (mconfig("rankings_enable_duels")["@attributes"]["daily"] == "1") {
            echo "\r\n                <div role=\"tabpanel\" class=\"tab-pane fade " . $isActive . "\" id=\"daily\" aria-labelledby=\"daily-tab\">";
            $isActive = "";
            $ranking_data = LoadCacheData("daily_rankings/rankings_duels.cache");
            echo "\r\n        <div class=\"table-responsive rankings-table\">\r\n            <table class=\"table table-hover text-center\">\r\n                <thead>\r\n                    <tr>";
            if (mconfig("rankings_show_place_number")) {
                echo "<th>#</th>";
            }
            echo "\r\n                        <th>" . lang("rankings_txt_10", true) . "</th>\r\n                        <th>" . lang("rankings_txt_11", true) . "</th>\r\n                        <th>" . lang("rankings_txt_38", true) . "</th>\r\n                        <th>" . lang("rankings_txt_42", true) . "</th>\r\n                        <th>" . lang("rankings_txt_43", true) . "</th>";
            if ($config["flags"]) {
                echo "<th>" . lang("global_module_11", true) . "</th>";
            }
            echo "\r\n                    </tr>\r\n                </thead>\r\n                <tbody>";
            $i = 0;
            foreach ($ranking_data as $rdata) {
                if (1 <= $i) {
                    $total = $rdata[2] + $rdata[3];
                    $winratio = $rdata[2] * 100 / $total;
                    echo "<tr>";
                    if (mconfig("rankings_show_place_number")) {
                        echo "<td>" . $i . "</td>";
                    }
                    echo "<td><a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($rdata[0]) . "/\">" . $common->replaceHtmlSymbols($rdata[0]) . "</a></td>";
                    echo "<td>" . $custom["character_class"][$rdata[1]][0] . "</td>";
                    echo "<td><span class=\"rankings-progress\">+" . number_format($rdata[2]) . "</span></td>";
                    echo "<td><span class=\"rankings-progress-neg\">+" . number_format($rdata[3]) . "</span></td>";
                    echo "<td>" . number_format($winratio, 2) . "%</td>";
                    if ($config["flags"]) {
                        echo "<td><img src=\"" . __PATH_TEMPLATE__ . "images/blank.png\" class=\"flag-icon flag-icon-" . $rdata[4] . "\" alt=\"" . $custom["countries"][$rdata[4]] . "\" title=\"" . $custom["countries"][$rdata[4]] . "\" /></td>";
                    }
                    echo "</tr>";
                }
                $i++;
            }
            echo "\r\n                </tbody>\r\n            </table>\r\n        </div>";
            if (mconfig("rankings_show_date")) {
                echo "<div class=\"rankings-update-time\">";
                echo lang("rankings_txt_20", true) . " " . date($config["time_date_format"], $ranking_data[0][0]);
                echo "</div>";
            }
            if (mconfig("rewards_duels")["@attributes"]["daily"]) {
                $rewardsHtml = $Rankings->returnRewardsHtml("daily_duels");
                if ($rewardsHtml != NULL) {
                    echo $rewardsHtml;
                }
            }
            echo "\r\n        </div>";
        }
        if ($showTabs) {
            echo "\r\n        </div>\r\n    </div>";
        }
    } else {
        message("error", lang("error_44", true));
    }
} else {
    $menu = $Rankings->rankingsMenu(true);
    echo $menu;
    loadModuleConfigs("rankings");
    echo "\r\n<div class=\"container_2 account\" align=\"center\">\r\n    <div class=\"cont-image\">";
    if (mconfig("active")) {
        $showTabs = false;
        $totalRankings = 0;
        if (mconfig("rankings_enable_duels")["@attributes"]["general"] == "1") {
            $totalRankings++;
        }
        if (mconfig("rankings_enable_duels")["@attributes"]["daily"] == "1") {
            $totalRankings++;
        }
        if (mconfig("rankings_enable_duels")["@attributes"]["weekly"] == "1") {
            $totalRankings++;
        }
        if (mconfig("rankings_enable_duels")["@attributes"]["monthly"] == "1") {
            $totalRankings++;
        }
        if (1 < $totalRankings) {
            $showTabs = true;
        }
        if ($showTabs) {
            $isActive = "active";
            $activeRanking = "";
            echo "\r\n            <script type=\"text/javascript\">\r\n                function changeRankings(type) {\r\n                    if (type == \"general\") {\r\n                        if (!\$('#tab-general').hasClass('active')) {\r\n                            \$('#tab-general').addClass('active');\r\n                        }\r\n                        \$('#tab-monthly').removeClass('active');\r\n                        \$('#tab-weekly').removeClass('active');\r\n                        \$('#tab-daily').removeClass('active');\r\n                        \$('#rankings-general').show();\r\n                        \$('#rankings-monthly').hide();\r\n                        \$('#rankings-weekly').hide();\r\n                        \$('#rankings-daily').hide();\r\n                    } else if (type == \"monthly\") {\r\n                        if (!\$('#tab-monthly').hasClass('active')) {\r\n                            \$('#tab-monthly').addClass('active');\r\n                        }\r\n                        \$('#tab-general').removeClass('active');\r\n                        \$('#tab-weekly').removeClass('active');\r\n                        \$('#tab-daily').removeClass('active');\r\n                        \$('#rankings-monthly').show();\r\n                        \$('#rankings-general').hide();\r\n                        \$('#rankings-weekly').hide();\r\n                        \$('#rankings-daily').hide();\r\n                    } else if (type == \"weekly\") {\r\n                        if (!\$('#tab-weekly').hasClass('active')) {\r\n                            \$('#tab-weekly').addClass('active');\r\n                        }\r\n                        \$('#tab-monthly').removeClass('active');\r\n                        \$('#tab-general').removeClass('active');                        \r\n                        \$('#tab-daily').removeClass('active');\r\n                        \$('#rankings-weekly').show();\r\n                        \$('#rankings-monthly').hide();\r\n                        \$('#rankings-general').hide();\r\n                        \$('#rankings-daily').hide();\r\n                    } else if (type == \"daily\") {\r\n                        if (!\$('#tab-daily').hasClass('active')) {\r\n                            \$('#tab-daily').addClass('active');\r\n                        }\r\n                        \$('#tab-monthly').removeClass('active');\r\n                        \$('#tab-weekly').removeClass('active');\r\n                        \$('#tab-general').removeClass('active');\r\n                        \$('#rankings-daily').show();\r\n                        \$('#rankings-monthly').hide();\r\n                        \$('#rankings-weekly').hide();\r\n                        \$('#rankings-general').hide();\r\n                    }\r\n                }\r\n            </script>\r\n            <div class=\"rankings_menu_filter2\">";
            if (mconfig("rankings_enable_duels")["@attributes"]["general"] == "1") {
                echo "<a id=\"tab-general\" href=\"#general\" class=\"" . $isActive . "\" onclick=\"changeRankings('general');\">" . lang("rankings_txt_80", true) . "</a>";
                $isActive = "";
                if ($activeRanking == "") {
                    $activeRanking = "general";
                }
            }
            if (mconfig("rankings_enable_duels")["@attributes"]["monthly"] == "1") {
                echo "<a id=\"tab-monthly\" href=\"#monthly\" class=\"" . $isActive . "\" onclick=\"changeRankings('monthly');\">" . lang("rankings_txt_83", true) . "</a>";
                $isActive = "";
                if ($activeRanking == "") {
                    $activeRanking = "monthly";
                }
            }
            if (mconfig("rankings_enable_duels")["@attributes"]["weekly"] == "1") {
                echo "<a id=\"tab-weekly\" href=\"#weekly\" class=\"" . $isActive . "\" onclick=\"changeRankings('weekly');\">" . lang("rankings_txt_82", true) . "</a>";
                $isActive = "";
                if ($activeRanking == "") {
                    $activeRanking = "weekly";
                }
            }
            if (mconfig("rankings_enable_duels")["@attributes"]["daily"] == "1") {
                echo "<a id=\"tab-daily\" href=\"#daily\" class=\"" . $isActive . "\" onclick=\"changeRankings('daily');\">" . lang("rankings_txt_81", true) . "</a>";
                $isActive = "";
                if ($activeRanking == "") {
                    $activeRanking = "daily";
                }
            }
            echo "\r\n            </div>";
        }
        if (mconfig("rankings_enable_duels")["@attributes"]["general"] == "1") {
            if ($activeRanking == "general") {
                echo "<div id=\"rankings-general\">";
            } else {
                echo "<div id=\"rankings-general\" style=\"\"display: none;>";
            }
            $ranking_data = LoadCacheData("rankings_duels.cache");
            echo "<div class=\"container_3 account-wide\" align=\"center\"><table class=\"general-table-ui\" cellspacing=\"0\" width=\"100%\"><tr>";
            if (mconfig("rankings_show_place_number")) {
                echo "<th style=\"font-weight:bold;\">#</th>";
            }
            echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_10", true) . "</th>";
            echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_11", true) . "</th>";
            echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_38", true) . "</th>";
            echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_42", true) . "</th>";
            echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_43", true) . "</th>";
            if ($config["flags"]) {
                echo "<th style=\"font-weight:bold;\">" . lang("global_module_11", true) . "</th>";
            }
            echo "</tr>";
            $i = 0;
            foreach ($ranking_data as $rdata) {
                if (1 <= $i) {
                    $total = $rdata[2] + $rdata[3];
                    $winratio = $rdata[2] * 100 / $total;
                    echo "<tr>";
                    if (mconfig("rankings_show_place_number")) {
                        echo "<td>" . $i . "</td>";
                    }
                    echo "<td><a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($rdata[0]) . "/\">" . $common->replaceHtmlSymbols($rdata[0]) . "</a></td>";
                    echo "<td>" . $custom["character_class"][$rdata[1]][0] . "</td>";
                    echo "<td>" . number_format($rdata[2]) . "</td>";
                    echo "<td>" . number_format($rdata[3]) . "</td>";
                    echo "<td>" . number_format($winratio, 2) . "%</td>";
                    if ($config["flags"]) {
                        echo "<td><img src=\"" . __PATH_TEMPLATE__ . "style/images/blank.png\" class=\"flag-icon flag-icon-" . $rdata[4] . "\" alt=\"" . $custom["countries"][$rdata[4]] . "\" title=\"" . $custom["countries"][$rdata[4]] . "\" /></td>";
                    }
                    echo "</tr>";
                }
                $i++;
            }
            echo "</table>";
            if (mconfig("rankings_show_date")) {
                echo "<div class=\"rankings-update-time\">";
                echo "" . lang("rankings_txt_20", true) . " " . date($config["time_date_format"], $ranking_data[0][0]);
                echo "</div>";
            }
            echo "</div></div>";
        }
        if (mconfig("rankings_enable_duels")["@attributes"]["monthly"] == "1") {
            if ($activeRanking == "monthly") {
                echo "<div id=\"rankings-monthly\">";
            } else {
                echo "<div id=\"rankings-monthly\" style=\"display: none;\">";
            }
            $ranking_data = LoadCacheData("monthly_rankings/rankings_duels.cache");
            echo "<div class=\"container_3 account-wide\" align=\"center\"><table class=\"general-table-ui\" cellspacing=\"0\" width=\"100%\"><tr>";
            if (mconfig("rankings_show_place_number")) {
                echo "<th style=\"font-weight:bold;\">#</th>";
            }
            echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_10", true) . "</th>";
            echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_11", true) . "</th>";
            echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_38", true) . "</th>";
            echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_42", true) . "</th>";
            echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_43", true) . "</th>";
            if ($config["flags"]) {
                echo "<th style=\"font-weight:bold;\">" . lang("global_module_11", true) . "</th>";
            }
            echo "</tr>";
            $i = 0;
            foreach ($ranking_data as $rdata) {
                if (1 <= $i) {
                    $total = $rdata[2] + $rdata[3];
                    $winratio = $rdata[2] * 100 / $total;
                    echo "<tr>";
                    if (mconfig("rankings_show_place_number")) {
                        echo "<td>" . $i . "</td>";
                    }
                    echo "<td><a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($rdata[0]) . "/\">" . $common->replaceHtmlSymbols($rdata[0]) . "</a></td>";
                    echo "<td>" . $custom["character_class"][$rdata[1]][0] . "</td>";
                    echo "<td><span class=\"rankings-progress\">+" . number_format($rdata[2]) . "</span></td>";
                    echo "<td><span class=\"rankings-progress-neg\">+" . number_format($rdata[3]) . "</span></td>";
                    echo "<td>" . number_format($winratio, 2) . "%</td>";
                    if ($config["flags"]) {
                        echo "<td><img src=\"" . __PATH_TEMPLATE__ . "style/images/blank.png\" class=\"flag-icon flag-icon-" . $rdata[4] . "\" alt=\"" . $custom["countries"][$rdata[4]] . "\" title=\"" . $custom["countries"][$rdata[4]] . "\" /></td>";
                    }
                    echo "</tr>";
                }
                $i++;
            }
            echo "</table>";
            if (mconfig("rankings_show_date")) {
                echo "<div class=\"rankings-update-time\">";
                echo "" . lang("rankings_txt_20", true) . " " . date($config["time_date_format"], $ranking_data[0][0]);
                echo "</div>";
            }
            echo "</div></div>";
        }
        if (mconfig("rankings_enable_duels")["@attributes"]["weekly"] == "1") {
            if ($activeRanking == "weekly") {
                echo "<div id=\"rankings-weekly\">";
            } else {
                echo "<div id=\"rankings-weekly\" style=\"display: none;\">";
            }
            $ranking_data = LoadCacheData("weekly_rankings/rankings_duels.cache");
            echo "<div class=\"container_3 account-wide\" align=\"center\"><table class=\"general-table-ui\" cellspacing=\"0\" width=\"100%\"><tr>";
            if (mconfig("rankings_show_place_number")) {
                echo "<th style=\"font-weight:bold;\">#</th>";
            }
            echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_10", true) . "</th>";
            echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_11", true) . "</th>";
            echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_38", true) . "</th>";
            echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_42", true) . "</th>";
            echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_43", true) . "</th>";
            if ($config["flags"]) {
                echo "<th style=\"font-weight:bold;\">" . lang("global_module_11", true) . "</th>";
            }
            echo "</tr>";
            $i = 0;
            foreach ($ranking_data as $rdata) {
                if (1 <= $i) {
                    $total = $rdata[2] + $rdata[3];
                    $winratio = $rdata[2] * 100 / $total;
                    echo "<tr>";
                    if (mconfig("rankings_show_place_number")) {
                        echo "<td>" . $i . "</td>";
                    }
                    echo "<td><a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($rdata[0]) . "/\">" . $common->replaceHtmlSymbols($rdata[0]) . "</a></td>";
                    echo "<td>" . $custom["character_class"][$rdata[1]][0] . "</td>";
                    echo "<td><span class=\"rankings-progress\">+" . number_format($rdata[2]) . "</span></td>";
                    echo "<td><span class=\"rankings-progress-neg\">+" . number_format($rdata[3]) . "</span></td>";
                    echo "<td>" . number_format($winratio, 2) . "%</td>";
                    if ($config["flags"]) {
                        echo "<td><img src=\"" . __PATH_TEMPLATE__ . "style/images/blank.png\" class=\"flag-icon flag-icon-" . $rdata[4] . "\" alt=\"" . $custom["countries"][$rdata[4]] . "\" title=\"" . $custom["countries"][$rdata[4]] . "\" /></td>";
                    }
                    echo "</tr>";
                }
                $i++;
            }
            echo "</table>";
            if (mconfig("rankings_show_date")) {
                echo "<div class=\"rankings-update-time\">";
                echo "" . lang("rankings_txt_20", true) . " " . date($config["time_date_format"], $ranking_data[0][0]);
                echo "</div>";
            }
            echo "</div></div>";
        }
        if (mconfig("rankings_enable_duels")["@attributes"]["daily"] == "1") {
            if ($activeRanking == "daily") {
                echo "<div id=\"rankings-daily\">";
            } else {
                echo "<div id=\"rankings-daily\" style=\"display: none;\">";
            }
            $ranking_data = LoadCacheData("daily_rankings/rankings_duels.cache");
            echo "<div class=\"container_3 account-wide\" align=\"center\"><table class=\"general-table-ui\" cellspacing=\"0\" width=\"100%\"><tr>";
            if (mconfig("rankings_show_place_number")) {
                echo "<th style=\"font-weight:bold;\">#</th>";
            }
            echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_10", true) . "</th>";
            echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_11", true) . "</th>";
            echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_38", true) . "</th>";
            echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_42", true) . "</th>";
            echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_43", true) . "</th>";
            if ($config["flags"]) {
                echo "<th style=\"font-weight:bold;\">" . lang("global_module_11", true) . "</th>";
            }
            echo "</tr>";
            $i = 0;
            foreach ($ranking_data as $rdata) {
                if ($rdata[3] == NULL) {
                    $rdata[3] = 0;
                }
                if (1 <= $i) {
                    $total = $rdata[2] + $rdata[3];
                    $winratio = $rdata[2] * 100 / $total;
                    echo "<tr>";
                    if (mconfig("rankings_show_place_number")) {
                        echo "<td>" . $i . "</td>";
                    }
                    echo "<td><a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($rdata[0]) . "/\">" . $common->replaceHtmlSymbols($rdata[0]) . "</a></td>";
                    echo "<td>" . $custom["character_class"][$rdata[1]][0] . "</td>";
                    echo "<td><span class=\"rankings-progress\">+" . number_format($rdata[2]) . "</span></td>";
                    echo "<td><span class=\"rankings-progress-neg\">+" . number_format($rdata[3]) . "</span></td>";
                    echo "<td>" . number_format($winratio, 2) . "%</td>";
                    if ($config["flags"]) {
                        echo "<td><img src=\"" . __PATH_TEMPLATE__ . "style/images/blank.png\" class=\"flag-icon flag-icon-" . $rdata[4] . "\" alt=\"" . $custom["countries"][$rdata[4]] . "\" title=\"" . $custom["countries"][$rdata[4]] . "\" /></td>";
                    }
                    echo "</tr>";
                }
                $i++;
            }
            echo "</table>";
            if (mconfig("rankings_show_date")) {
                echo "<div class=\"rankings-update-time\">";
                echo "" . lang("rankings_txt_20", true) . " " . date($config["time_date_format"], $ranking_data[0][0]);
                echo "</div>";
            }
            echo "</div></div>";
        }
    } else {
        message("error", lang("error_44", true));
    }
    echo "\r\n    </div>\r\n</div>";
}

?>