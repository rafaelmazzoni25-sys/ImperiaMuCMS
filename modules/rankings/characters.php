<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$Rankings = new Rankings();
if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
    echo "<script type=\"text/javascript\" SRC=\"" . __PATH_TEMPLATE_ASSETS__ . "js/tooltip.js\"></script>";
    $breadcrumb = generateBreadcrumb();
    echo "\n    <h3>\n        " . lang("module_titles_txt_10", true) . "\n        " . $breadcrumb . "\n    </h3>";
    $menu = $Rankings->rankingsMenu(false);
    echo $menu;
    loadModuleConfigs("rankings");
    if (mconfig("active")) {
        $showTabs = true;
        if ($showTabs) {
            echo "\n    <div role=\"tabpanel\" data-example-id=\"togglable-tabs\">\n        <ul id=\"rankingsTabs\" class=\"nav nav-tabs nav-tabs-responsive\" role=\"tablist\">";
            $isActive = "active";
            $isExpanded = "true";
            $count = 0;
            if (mconfig("rankings_enable_characters")["@attributes"]["general"] == "1") {
                $count++;
                echo "\n            <li role=\"presentation\" class=\"" . $isActive . "\">\n                <a href=\"#general\" id=\"general-tab\" role=\"tab\" data-toggle=\"tab\" aria-controls=\"general\" aria-expanded=\"" . $isExpanded . "\">\n                    <span class=\"text\">" . lang("rankings_txt_80", true) . "</span>\n                </a>\n            </li>";
                $isActive = "";
                $isExpanded = "false";
            }
            if (mconfig("rankings_enable_characters")["@attributes"]["monthly"] == "1") {
                $count++;
                if ($count == 2) {
                    $isActive = "next";
                }
                echo "\n            <li role=\"presentation\" class=\"" . $isActive . "\">\n                <a href=\"#monthly\" id=\"general-tab\" role=\"tab\" data-toggle=\"tab\" aria-controls=\"monthly\" aria-expanded=\"" . $isExpanded . "\">\n                    <span class=\"text\">" . lang("rankings_txt_83", true) . "</span>\n                </a>\n            </li>";
                $isActive = "";
                $isExpanded = "false";
            }
            if (mconfig("rankings_enable_characters")["@attributes"]["weekly"] == "1") {
                $count++;
                if ($count == 2) {
                    $isActive = "next";
                }
                echo "\n            <li role=\"presentation\" class=\"" . $isActive . "\">\n                <a href=\"#weekly\" id=\"general-tab\" role=\"tab\" data-toggle=\"tab\" aria-controls=\"weekly\" aria-expanded=\"" . $isExpanded . "\">\n                    <span class=\"text\">" . lang("rankings_txt_82", true) . "</span>\n                </a>\n            </li>";
                $isActive = "";
                $isExpanded = "false";
            }
            if (mconfig("rankings_enable_characters")["@attributes"]["daily"] == "1") {
                $count++;
                if ($count == 2) {
                    $isActive = "next";
                }
                echo "\n            <li role=\"presentation\" class=\"" . $isActive . "\">\n                <a href=\"#daily\" id=\"general-tab\" role=\"tab\" data-toggle=\"tab\" aria-controls=\"daily\" aria-expanded=\"" . $isExpanded . "\">\n                    <span class=\"text\">" . lang("rankings_txt_81", true) . "</span>\n                </a>\n            </li>";
                $isActive = "";
                $isExpanded = "false";
            }
            echo "\n        </ul>\n    <div id=\"rankingsContent\" class=\"tab-content\">";
        }
        $isActive = "in active";
        if (mconfig("rankings_enable_characters")["@attributes"]["general"] == "1") {
            echo "<div role=\"tabpanel\" class=\"tab-pane fade " . $isActive . "\" id=\"general\" aria-labelledby=\"general-tab\">";
            $isActive = "";
            $Rankings->classFilter();
            if (isset($_GET["class"])) {
                $filter = "_" . xss_clean($_GET["class"]);
            } else {
                $filter = "";
            }
            $ranking_data = LoadCacheData("rankings_characters" . $filter . ".cache");
            echo "\n            <div class=\"table-responsive rankings-table\">\n                <table class=\"table table-hover text-center\">\n                    <thead>\n                        <tr>";
            if (mconfig("rankings_show_place_number")) {
                echo "<th>#</th>";
            }
            echo "\n                            <th>" . lang("rankings_txt_10", true) . "</th>\n                            <th>" . lang("rankings_txt_11", true) . "</th>\n                            <th>" . lang("global_module_5", true) . "</th>\n                            <th>" . lang("global_module_6", true) . "</th>";
            if ($config["use_resets"]) {
                echo "<th>" . lang("global_module_7", true) . "</th>";
            }
            if ($config["use_grand_resets"]) {
                echo "<th>" . lang("global_module_8", true) . "</th>";
            }
            if ($config["flags"]) {
                echo "<th>" . lang("global_module_11", true) . "</th>";
            }
            echo "\n                        </tr>\n                    </thead>\n                    <tbody>";
            $i = 0;
            foreach ($ranking_data as $rdata) {
                if ($rdata[3] == NULL) {
                    $rdata[3] = 0;
                }
                if (1 <= $i) {
                    echo "<tr>";
                    if (mconfig("rankings_show_place_number")) {
                        echo "<td>" . $i . "</td>";
                    }
                    echo "<td><a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($rdata[0]) . "/\">" . $common->replaceHtmlSymbols($rdata[0]) . "</a></td>";
                    echo "<td>" . $custom["character_class"][$rdata[1]][0] . "</td>";
                    echo "<td>" . $rdata[2] . "</td>";
                    echo "<td>" . $rdata[3] . "</td>";
                    if ($config["use_resets"]) {
                        echo "<td>" . $rdata[4] . "</td>";
                    }
                    if ($config["use_grand_resets"]) {
                        echo "<td>" . $rdata[5] . "</td>";
                    }
                    if ($config["flags"]) {
                        echo "<td><img src=\"" . __PATH_TEMPLATE__ . "images/blank.png\" class=\"flag-icon flag-icon-" . $rdata[6] . "\" alt=\"" . $custom["countries"][$rdata[6]] . "\" title=\"" . $custom["countries"][$rdata[6]] . "\" /></td>";
                    }
                    echo "</tr>";
                }
                $i++;
            }
            echo "\n                    </tbody>\n                </table>\n            </div>";
            if (mconfig("rankings_show_date")) {
                echo "<div class=\"rankings-update-time\">";
                echo lang("rankings_txt_20", true) . " " . date($config["time_date_format"], $ranking_data[0][0]);
                echo "</div>";
            }
            echo "\n        </div>";
        }
        if (mconfig("rankings_enable_characters")["@attributes"]["monthly"] == "1") {
            echo "\n        <div role=\"tabpanel\" class=\"tab-pane fade " . $isActive . "\" id=\"monthly\" aria-labelledby=\"monthly-tab\">";
            $isActive = "";
            $ranking_data = LoadCacheData("monthly_rankings/rankings_characters.cache");
            echo "\n            <div class=\"table-responsive rankings-table\">\n                <table class=\"table table-hover text-center\">\n                    <thead>\n                        <tr>";
            if (mconfig("rankings_show_place_number")) {
                echo "<th>#</th>";
            }
            echo "\n                            <th>" . lang("rankings_txt_10", true) . "</th>\n                            <th>" . lang("rankings_txt_11", true) . "</th>\n                            <th>" . lang("global_module_5", true) . "</th>\n                            <th>" . lang("global_module_6", true) . "</th>";
            if ($config["use_resets"]) {
                echo "<th>" . lang("global_module_7", true) . "</th>";
            }
            if ($config["use_grand_resets"]) {
                echo "<th>" . lang("global_module_8", true) . "</th>";
            }
            if ($config["flags"]) {
                echo "<th>" . lang("global_module_11", true) . "</th>";
            }
            echo "\n                        </tr>\n                    </thead>\n                    <tbody>";
            $i = 0;
            foreach ($ranking_data as $rdata) {
                if ($rdata[3] == NULL) {
                    $rdata[3] = 0;
                }
                if (1 <= $i) {
                    echo "<tr>";
                    if (mconfig("rankings_show_place_number")) {
                        echo "<td>" . $i . "</td>";
                    }
                    echo "<td><a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($rdata[0]) . "/\">" . $common->replaceHtmlSymbols($rdata[0]) . "</a></td>";
                    echo "<td>" . $custom["character_class"][$rdata[1]][0] . "</td>";
                    echo "<td><span class=\"rankings-progress\">+" . number_format($rdata[7]) . "</span></td>";
                    echo "<td><span class=\"rankings-progress\">+" . number_format($rdata[8]) . "</span></td>";
                    if ($config["use_resets"]) {
                        echo "<td><span class=\"rankings-progress\">+" . number_format($rdata[9]) . "</span></td>";
                    }
                    if ($config["use_grand_resets"]) {
                        echo "<td><span class=\"rankings-progress\">+" . number_format($rdata[10]) . "</span></td>";
                    }
                    if ($config["flags"]) {
                        echo "<td><img src=\"" . __PATH_TEMPLATE__ . "images/blank.png\" class=\"flag-icon flag-icon-" . $rdata[6] . "\" alt=\"" . $custom["countries"][$rdata[6]] . "\" title=\"" . $custom["countries"][$rdata[6]] . "\" /></td>";
                    }
                    echo "</tr>";
                }
                $i++;
            }
            echo "\n                    </tbody>\n                </table>\n            </div>";
            if (mconfig("rankings_show_date")) {
                echo "<div class=\"rankings-update-time\">";
                echo lang("rankings_txt_20", true) . " " . date($config["time_date_format"], $ranking_data[0][0]);
                echo "</div>";
            }
            if (mconfig("rewards_characters")["@attributes"]["monthly"]) {
                $rewardsHtml = $Rankings->returnRewardsHtml("monthly_characters");
                if ($rewardsHtml != NULL) {
                    echo $rewardsHtml;
                }
            }
            echo "\n        </div>";
        }
        if (mconfig("rankings_enable_characters")["@attributes"]["weekly"] == "1") {
            echo "\n        <div role=\"tabpanel\" class=\"tab-pane fade " . $isActive . "\" id=\"weekly\" aria-labelledby=\"weekly-tab\">";
            $isActive = "";
            $ranking_data = LoadCacheData("weekly_rankings/rankings_characters.cache");
            echo "\n            <div class=\"table-responsive rankings-table\">\n                <table class=\"table table-hover text-center\">\n                    <thead>\n                        <tr>";
            if (mconfig("rankings_show_place_number")) {
                echo "<th>#</th>";
            }
            echo "\n                            <th>" . lang("rankings_txt_10", true) . "</th>\n                            <th>" . lang("rankings_txt_11", true) . "</th>\n                            <th>" . lang("global_module_5", true) . "</th>\n                            <th>" . lang("global_module_6", true) . "</th>";
            if ($config["use_resets"]) {
                echo "<th>" . lang("global_module_7", true) . "</th>";
            }
            if ($config["use_grand_resets"]) {
                echo "<th>" . lang("global_module_8", true) . "</th>";
            }
            if ($config["flags"]) {
                echo "<th>" . lang("global_module_11", true) . "</th>";
            }
            echo "\n                        </tr>\n                    </thead>\n                    <tbody>";
            $i = 0;
            foreach ($ranking_data as $rdata) {
                if ($rdata[3] == NULL) {
                    $rdata[3] = 0;
                }
                if (1 <= $i) {
                    echo "<tr>";
                    if (mconfig("rankings_show_place_number")) {
                        echo "<td>" . $i . "</td>";
                    }
                    echo "<td><a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($rdata[0]) . "/\">" . $common->replaceHtmlSymbols($rdata[0]) . "</a></td>";
                    echo "<td>" . $custom["character_class"][$rdata[1]][0] . "</td>";
                    echo "<td><span class=\"rankings-progress\">+" . number_format($rdata[7]) . "</span></td>";
                    echo "<td><span class=\"rankings-progress\">+" . number_format($rdata[8]) . "</span></td>";
                    if ($config["use_resets"]) {
                        echo "<td><span class=\"rankings-progress\">+" . number_format($rdata[9]) . "</span></td>";
                    }
                    if ($config["use_grand_resets"]) {
                        echo "<td><span class=\"rankings-progress\">+" . number_format($rdata[10]) . "</span></td>";
                    }
                    if ($config["flags"]) {
                        echo "<td><img src=\"" . __PATH_TEMPLATE__ . "images/blank.png\" class=\"flag-icon flag-icon-" . $rdata[6] . "\" alt=\"" . $custom["countries"][$rdata[6]] . "\" title=\"" . $custom["countries"][$rdata[6]] . "\" /></td>";
                    }
                    echo "</tr>";
                }
                $i++;
            }
            echo "\n                    </tbody>\n                </table>\n            </div>";
            if (mconfig("rankings_show_date")) {
                echo "<div class=\"rankings-update-time\">";
                echo lang("rankings_txt_20", true) . " " . date($config["time_date_format"], $ranking_data[0][0]);
                echo "</div>";
            }
            if (mconfig("rewards_characters")["@attributes"]["weekly"]) {
                $rewardsHtml = $Rankings->returnRewardsHtml("weekly_characters");
                if ($rewardsHtml != NULL) {
                    echo $rewardsHtml;
                }
            }
            echo "\n        </div>";
        }
        if (mconfig("rankings_enable_characters")["@attributes"]["daily"] == "1") {
            echo "\n        <div role=\"tabpanel\" class=\"tab-pane fade " . $isActive . "\" id=\"daily\" aria-labelledby=\"daily-tab\">";
            $isActive = "";
            $ranking_data = LoadCacheData("daily_rankings/rankings_characters.cache");
            echo "\n            <div class=\"table-responsive rankings-table\">\n                <table class=\"table table-hover text-center\">\n                    <thead>\n                        <tr>";
            if (mconfig("rankings_show_place_number")) {
                echo "<th>#</th>";
            }
            echo "\n                            <th>" . lang("rankings_txt_10", true) . "</th>\n                            <th>" . lang("rankings_txt_11", true) . "</th>\n                            <th>" . lang("global_module_5", true) . "</th>\n                            <th>" . lang("global_module_6", true) . "</th>";
            if ($config["use_resets"]) {
                echo "<th>" . lang("global_module_7", true) . "</th>";
            }
            if ($config["use_grand_resets"]) {
                echo "<th>" . lang("global_module_8", true) . "</th>";
            }
            if ($config["flags"]) {
                echo "<th>" . lang("global_module_11", true) . "</th>";
            }
            echo "\n                        </tr>\n                    </thead>\n                    <tbody>";
            $i = 0;
            foreach ($ranking_data as $rdata) {
                if ($rdata[3] == NULL) {
                    $rdata[3] = 0;
                }
                if (1 <= $i) {
                    echo "<tr>";
                    if (mconfig("rankings_show_place_number")) {
                        echo "<td>" . $i . "</td>";
                    }
                    echo "<td><a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($rdata[0]) . "/\">" . $common->replaceHtmlSymbols($rdata[0]) . "</a></td>";
                    echo "<td>" . $custom["character_class"][$rdata[1]][0] . "</td>";
                    echo "<td><span class=\"rankings-progress\">+" . number_format($rdata[7]) . "</span></td>";
                    echo "<td><span class=\"rankings-progress\">+" . number_format($rdata[8]) . "</span></td>";
                    if ($config["use_resets"]) {
                        echo "<td><span class=\"rankings-progress\">+" . number_format($rdata[9]) . "</span></td>";
                    }
                    if ($config["use_grand_resets"]) {
                        echo "<td><span class=\"rankings-progress\">+" . number_format($rdata[10]) . "</span></td>";
                    }
                    if ($config["flags"]) {
                        echo "<td><img src=\"" . __PATH_TEMPLATE__ . "images/blank.png\" class=\"flag-icon flag-icon-" . $rdata[6] . "\" alt=\"" . $custom["countries"][$rdata[6]] . "\" title=\"" . $custom["countries"][$rdata[6]] . "\" /></td>";
                    }
                    echo "</tr>";
                }
                $i++;
            }
            echo "\n                    </tbody>\n                </table>\n            </div>";
            if (mconfig("rankings_show_date")) {
                echo "<div class=\"rankings-update-time\">";
                echo lang("rankings_txt_20", true) . " " . date($config["time_date_format"], $ranking_data[0][0]);
                echo "</div>";
            }
            if (mconfig("rewards_characters")["@attributes"]["daily"]) {
                $rewardsHtml = $Rankings->returnRewardsHtml("daily_characters");
                if ($rewardsHtml != NULL) {
                    echo $rewardsHtml;
                }
            }
            echo "\n        </div>";
        }
        if ($showTabs) {
            echo "\n        </div>\n    </div>";
        }
    } else {
        message("error", lang("error_44", true));
    }
} else {
    $menu = $Rankings->rankingsMenu(true);
    echo $menu;
    loadModuleConfigs("rankings");
    echo "\n<div class=\"container_2 account\" align=\"center\">\n    <div class=\"cont-image\">";
    if (mconfig("active")) {
        $showTabs = false;
        $totalRankings = 0;
        if (mconfig("rankings_enable_characters")["@attributes"]["general"] == "1") {
            $totalRankings++;
        }
        if (mconfig("rankings_enable_characters")["@attributes"]["daily"] == "1") {
            $totalRankings++;
        }
        if (mconfig("rankings_enable_characters")["@attributes"]["weekly"] == "1") {
            $totalRankings++;
        }
        if (mconfig("rankings_enable_characters")["@attributes"]["monthly"] == "1") {
            $totalRankings++;
        }
        if (1 < $totalRankings) {
            $showTabs = true;
        }
        if ($showTabs) {
            $isActive = "active";
            $activeRanking = "";
            echo "\n            <script type=\"text/javascript\">\n                function changeRankings(type) {\n                    if (type == \"general\") {\n                        if (!\$('#tab-general').hasClass('active')) {\n                            \$('#tab-general').addClass('active');\n                        }\n                        \$('#tab-monthly').removeClass('active');\n                        \$('#tab-weekly').removeClass('active');\n                        \$('#tab-daily').removeClass('active');\n                        \$('#rankings-general').show();\n                        \$('#rankings-monthly').hide();\n                        \$('#rankings-weekly').hide();\n                        \$('#rankings-daily').hide();\n                    } else if (type == \"monthly\") {\n                        if (!\$('#tab-monthly').hasClass('active')) {\n                            \$('#tab-monthly').addClass('active');\n                        }\n                        \$('#tab-general').removeClass('active');\n                        \$('#tab-weekly').removeClass('active');\n                        \$('#tab-daily').removeClass('active');\n                        \$('#rankings-monthly').show();\n                        \$('#rankings-general').hide();\n                        \$('#rankings-weekly').hide();\n                        \$('#rankings-daily').hide();\n                    } else if (type == \"weekly\") {\n                        if (!\$('#tab-weekly').hasClass('active')) {\n                            \$('#tab-weekly').addClass('active');\n                        }\n                        \$('#tab-monthly').removeClass('active');\n                        \$('#tab-general').removeClass('active');                        \n                        \$('#tab-daily').removeClass('active');\n                        \$('#rankings-weekly').show();\n                        \$('#rankings-monthly').hide();\n                        \$('#rankings-general').hide();\n                        \$('#rankings-daily').hide();\n                    } else if (type == \"daily\") {\n                        if (!\$('#tab-daily').hasClass('active')) {\n                            \$('#tab-daily').addClass('active');\n                        }\n                        \$('#tab-monthly').removeClass('active');\n                        \$('#tab-weekly').removeClass('active');\n                        \$('#tab-general').removeClass('active');\n                        \$('#rankings-daily').show();\n                        \$('#rankings-monthly').hide();\n                        \$('#rankings-weekly').hide();\n                        \$('#rankings-general').hide();\n                    }\n                }\n            </script>\n            <div class=\"rankings_menu_filter2\">";
            if (mconfig("rankings_enable_characters")["@attributes"]["general"] == "1") {
                echo "<a id=\"tab-general\" href=\"#general\" class=\"" . $isActive . "\" onclick=\"changeRankings('general');\">" . lang("rankings_txt_80", true) . "</a>";
                $isActive = "";
                if ($activeRanking == "") {
                    $activeRanking = "general";
                }
            }
            if (mconfig("rankings_enable_characters")["@attributes"]["monthly"] == "1") {
                echo "<a id=\"tab-monthly\" href=\"#monthly\" class=\"" . $isActive . "\" onclick=\"changeRankings('monthly');\">" . lang("rankings_txt_83", true) . "</a>";
                $isActive = "";
                if ($activeRanking == "") {
                    $activeRanking = "monthly";
                }
            }
            if (mconfig("rankings_enable_characters")["@attributes"]["weekly"] == "1") {
                echo "<a id=\"tab-weekly\" href=\"#weekly\" class=\"" . $isActive . "\" onclick=\"changeRankings('weekly');\">" . lang("rankings_txt_82", true) . "</a>";
                $isActive = "";
                if ($activeRanking == "") {
                    $activeRanking = "weekly";
                }
            }
            if (mconfig("rankings_enable_characters")["@attributes"]["daily"] == "1") {
                echo "<a id=\"tab-daily\" href=\"#daily\" class=\"" . $isActive . "\" onclick=\"changeRankings('daily');\">" . lang("rankings_txt_81", true) . "</a>";
                $isActive = "";
                if ($activeRanking == "") {
                    $activeRanking = "daily";
                }
            }
            echo "\n            </div>";
        }
        if (mconfig("rankings_enable_characters")["@attributes"]["general"] == "1") {
            if ($activeRanking == "general") {
                echo "<div id=\"rankings-general\">";
            } else {
                echo "<div id=\"rankings-general\" style=\"\"display: none;>";
            }
            $Rankings->classFilter();
            if (isset($_GET["class"])) {
                $filter = "_" . xss_clean($_GET["class"]);
            } else {
                $filter = "";
            }
            $ranking_data = LoadCacheData("rankings_characters" . $filter . ".cache");
            echo "<div class=\"container_3 account-wide\" align=\"center\"><table class=\"general-table-ui\" cellspacing=\"0\" width=\"100%\"><tr>";
            if (mconfig("rankings_show_place_number")) {
                echo "<th style=\"font-weight:bold;\">#</th>";
            }
            echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_10", true) . "</th>";
            echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_11", true) . "</th>";
            echo "<th style=\"font-weight:bold;\">" . lang("global_module_5", true) . "</th>";
            echo "<th style=\"font-weight:bold;\">" . lang("global_module_6", true) . "</th>";
            if ($config["use_resets"]) {
                echo "<th style=\"font-weight:bold;\">" . lang("global_module_7", true) . "</th>";
            }
            if ($config["use_grand_resets"]) {
                echo "<th>" . lang("global_module_8", true) . "</th>";
            }
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
                    echo "<tr>";
                    if (mconfig("rankings_show_place_number")) {
                        echo "<td>" . $i . "</td>";
                    }
                    echo "<td><a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($rdata[0]) . "/\">" . $common->replaceHtmlSymbols($rdata[0]) . "</a></td>";
                    echo "<td>" . $custom["character_class"][$rdata[1]][0] . "</td>";
                    echo "<td>" . $rdata[2] . "</td>";
                    echo "<td>" . $rdata[3] . "</td>";
                    if ($config["use_resets"]) {
                        echo "<td>" . $rdata[4] . "</td>";
                    }
                    if ($config["use_grand_resets"]) {
                        echo "<td>" . $rdata[5] . "</td>";
                    }
                    if ($config["flags"]) {
                        echo "<td><img src=\"" . __PATH_TEMPLATE__ . "style/images/blank.png\" class=\"flag-icon flag-icon-" . $rdata[6] . "\" alt=\"" . $custom["countries"][$rdata[6]] . "\" title=\"" . $custom["countries"][$rdata[6]] . "\" /></td>";
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
        if (mconfig("rankings_enable_characters")["@attributes"]["monthly"] == "1") {
            if ($activeRanking == "monthly") {
                echo "<div id=\"rankings-monthly\">";
            } else {
                echo "<div id=\"rankings-monthly\" style=\"display: none;\">";
            }
            $ranking_data = LoadCacheData("monthly_rankings/rankings_characters.cache");
            echo "<div class=\"container_3 account-wide\" align=\"center\"><table class=\"general-table-ui\" cellspacing=\"0\" width=\"100%\"><tr>";
            if (mconfig("rankings_show_place_number")) {
                echo "<th style=\"font-weight:bold;\">#</th>";
            }
            echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_10", true) . "</th>";
            echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_11", true) . "</th>";
            echo "<th style=\"font-weight:bold;\">" . lang("global_module_5", true) . "</th>";
            echo "<th style=\"font-weight:bold;\">" . lang("global_module_6", true) . "</th>";
            if ($config["use_resets"]) {
                echo "<th style=\"font-weight:bold;\">" . lang("global_module_7", true) . "</th>";
            }
            if ($config["use_grand_resets"]) {
                echo "<th style=\"font-weight:bold;\">" . lang("global_module_8", true) . "</th>";
            }
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
                    echo "<tr>";
                    if (mconfig("rankings_show_place_number")) {
                        echo "<td>" . $i . "</td>";
                    }
                    echo "<td><a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($rdata[0]) . "/\">" . $common->replaceHtmlSymbols($rdata[0]) . "</a></td>";
                    echo "<td>" . $custom["character_class"][$rdata[1]][0] . "</td>";
                    echo "<td><span class=\"rankings-progress\">+" . number_format($rdata[7]) . "</span></td>";
                    echo "<td><span class=\"rankings-progress\">+" . number_format($rdata[8]) . "</span></td>";
                    if ($config["use_resets"]) {
                        echo "<td><span class=\"rankings-progress\">+" . number_format($rdata[9]) . "</span></td>";
                    }
                    if ($config["use_grand_resets"]) {
                        echo "<td><span class=\"rankings-progress\">+" . number_format($rdata[10]) . "</span></td>";
                    }
                    if ($config["flags"]) {
                        echo "<td><img src=\"" . __PATH_TEMPLATE__ . "style/images/blank.png\" class=\"flag-icon flag-icon-" . $rdata[6] . "\" alt=\"" . $custom["countries"][$rdata[6]] . "\" title=\"" . $custom["countries"][$rdata[6]] . "\" /></td>";
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
        if (mconfig("rankings_enable_characters")["@attributes"]["weekly"] == "1") {
            if ($activeRanking == "weekly") {
                echo "<div id=\"rankings-weekly\">";
            } else {
                echo "<div id=\"rankings-weekly\" style=\"display: none;\">";
            }
            $ranking_data = LoadCacheData("weekly_rankings/rankings_characters.cache");
            echo "<div class=\"container_3 account-wide\" align=\"center\"><table class=\"general-table-ui\" cellspacing=\"0\" width=\"100%\"><tr>";
            if (mconfig("rankings_show_place_number")) {
                echo "<th style=\"font-weight:bold;\">#</th>";
            }
            echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_10", true) . "</th>";
            echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_11", true) . "</th>";
            echo "<th style=\"font-weight:bold;\">" . lang("global_module_5", true) . "</th>";
            echo "<th style=\"font-weight:bold;\">" . lang("global_module_6", true) . "</th>";
            if ($config["use_resets"]) {
                echo "<th style=\"font-weight:bold;\">" . lang("global_module_7", true) . "</th>";
            }
            if ($config["use_grand_resets"]) {
                echo "<th style=\"font-weight:bold;\">" . lang("global_module_8", true) . "</th>";
            }
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
                    echo "<tr>";
                    if (mconfig("rankings_show_place_number")) {
                        echo "<td>" . $i . "</td>";
                    }
                    echo "<td><a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($rdata[0]) . "/\">" . $common->replaceHtmlSymbols($rdata[0]) . "</a></td>";
                    echo "<td>" . $custom["character_class"][$rdata[1]][0] . "</td>";
                    echo "<td><span class=\"rankings-progress\">+" . number_format($rdata[7]) . "</span></td>";
                    echo "<td><span class=\"rankings-progress\">+" . number_format($rdata[8]) . "</span></td>";
                    if ($config["use_resets"]) {
                        echo "<td><span class=\"rankings-progress\">+" . number_format($rdata[9]) . "</span></td>";
                    }
                    if ($config["use_grand_resets"]) {
                        echo "<td><span class=\"rankings-progress\">+" . number_format($rdata[10]) . "</span></td>";
                    }
                    if ($config["flags"]) {
                        echo "<td><img src=\"" . __PATH_TEMPLATE__ . "style/images/blank.png\" class=\"flag-icon flag-icon-" . $rdata[6] . "\" alt=\"" . $custom["countries"][$rdata[6]] . "\" title=\"" . $custom["countries"][$rdata[6]] . "\" /></td>";
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
        if (mconfig("rankings_enable_characters")["@attributes"]["daily"] == "1") {
            if ($activeRanking == "daily") {
                echo "<div id=\"rankings-daily\">";
            } else {
                echo "<div id=\"rankings-daily\" style=\"display: none;\">";
            }
            $ranking_data = LoadCacheData("daily_rankings/rankings_characters.cache");
            echo "<div class=\"container_3 account-wide\" align=\"center\"><table class=\"general-table-ui\" cellspacing=\"0\" width=\"100%\"><tr>";
            if (mconfig("rankings_show_place_number")) {
                echo "<th style=\"font-weight:bold;\">#</th>";
            }
            echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_10", true) . "</th>";
            echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_11", true) . "</th>";
            echo "<th style=\"font-weight:bold;\">" . lang("global_module_5", true) . "</th>";
            echo "<th style=\"font-weight:bold;\">" . lang("global_module_6", true) . "</th>";
            if ($config["use_resets"]) {
                echo "<th style=\"font-weight:bold;\">" . lang("global_module_7", true) . "</th>";
            }
            if ($config["use_grand_resets"]) {
                echo "<th style=\"font-weight:bold;\">" . lang("global_module_8", true) . "</th>";
            }
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
                    echo "<tr>";
                    if (mconfig("rankings_show_place_number")) {
                        echo "<td>" . $i . "</td>";
                    }
                    echo "<td><a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($rdata[0]) . "/\">" . $common->replaceHtmlSymbols($rdata[0]) . "</a></td>";
                    echo "<td>" . $custom["character_class"][$rdata[1]][0] . "</td>";
                    echo "<td><span class=\"rankings-progress\">+" . number_format($rdata[7]) . "</span></td>";
                    echo "<td><span class=\"rankings-progress\">+" . number_format($rdata[8]) . "</span></td>";
                    if ($config["use_resets"]) {
                        echo "<td><span class=\"rankings-progress\">+" . number_format($rdata[9]) . "</span></td>";
                    }
                    if ($config["use_grand_resets"]) {
                        echo "<td><span class=\"rankings-progress\">+" . number_format($rdata[10]) . "</span></td>";
                    }
                    if ($config["flags"]) {
                        echo "<td><img src=\"" . __PATH_TEMPLATE__ . "style/images/blank.png\" class=\"flag-icon flag-icon-" . $rdata[6] . "\" alt=\"" . $custom["countries"][$rdata[6]] . "\" title=\"" . $custom["countries"][$rdata[6]] . "\" /></td>";
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
    echo "\n    </div>\n</div>";
}

?>