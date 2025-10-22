<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$Rankings = new Rankings();
if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
    echo "<script type=\"text/javascript\" SRC=\"" . __PATH_TEMPLATE_ASSETS__ . "js/tooltip.js\"></script>";
    $breadcrumb = generateBreadcrumb();
    echo "\n<h3>\n    " . lang("module_titles_txt_10", true) . "\n    " . $breadcrumb . "\n</h3>";
    $menu = $Rankings->rankingsMenu(false);
    echo $menu;
    loadModuleConfigs("rankings");
    if (mconfig("active") && mconfig("rankings_enable_monster_hunter")["@attributes"]["general"]) {
        $Rankings->monsterFilter();
        $monsterHunterCfg = loadConfigurations("monster_hunter");
        $currMonsterCfg = NULL;
        if (!isset($_GET["monster"]) || $_GET["monster"] == NULL || $_GET["monster"] == "") {
            $_GET["monster"] = $monsterHunterCfg["Monster"][0]["@attributes"]["id"];
            if ($_GET["monster"] == "-1") {
                $_GET["monster"] = "all";
            }
        }
        foreach ($monsterHunterCfg["Monster"] as $thisCfg) {
            if ($thisCfg["@attributes"]["id"] == "-1") {
                $monsterId = "all";
            } else {
                $monsterId = $thisCfg["@attributes"]["id"];
            }
            if ($monsterId == $_GET["monster"]) {
                $currMonsterCfg = $thisCfg["@attributes"];
            }
        }
        if ($_GET["monster"] == "all") {
            $showTabs = true;
            if ($showTabs) {
                echo "\n<div role=\"tabpanel\" data-example-id=\"togglable-tabs\">\n    <ul id=\"rankingsTabs\" class=\"nav nav-tabs nav-tabs-responsive\" role=\"tablist\">";
                $isActive = "active";
                $isExpanded = "true";
                $count = 0;
                if ($currMonsterCfg["general"] == "1") {
                    $count++;
                    echo "\n        <li role=\"presentation\" class=\"" . $isActive . "\">\n            <a href=\"#general\" id=\"general-tab\" role=\"tab\" data-toggle=\"tab\" aria-controls=\"general\" aria-expanded=\"" . $isExpanded . "\">\n                <span class=\"text\">" . lang("rankings_txt_80", true) . "</span>\n            </a>\n        </li>";
                    $isActive = "";
                    $isExpanded = "false";
                }
                if ($currMonsterCfg["monthly"] == "1") {
                    $count++;
                    if ($count == 2) {
                        $isActive = "next";
                    }
                    echo "\n        <li role=\"presentation\" class=\"" . $isActive . "\">\n            <a href=\"#monthly\" id=\"general-tab\" role=\"tab\" data-toggle=\"tab\" aria-controls=\"monthly\" aria-expanded=\"" . $isExpanded . "\">\n                <span class=\"text\">" . lang("rankings_txt_83", true) . "</span>\n            </a>\n        </li>";
                    $isActive = "";
                    $isExpanded = "false";
                }
                if ($currMonsterCfg["weekly"] == "1") {
                    $count++;
                    if ($count == 2) {
                        $isActive = "next";
                    }
                    echo "\n        <li role=\"presentation\" class=\"" . $isActive . "\">\n            <a href=\"#weekly\" id=\"general-tab\" role=\"tab\" data-toggle=\"tab\" aria-controls=\"weekly\" aria-expanded=\"" . $isExpanded . "\">\n                <span class=\"text\">" . lang("rankings_txt_82", true) . "</span>\n            </a>\n        </li>";
                    $isActive = "";
                    $isExpanded = "false";
                }
                if ($currMonsterCfg["daily"] == "1") {
                    $count++;
                    if ($count == 2) {
                        $isActive = "next";
                    }
                    echo "\n        <li role=\"presentation\" class=\"" . $isActive . "\">\n            <a href=\"#daily\" id=\"general-tab\" role=\"tab\" data-toggle=\"tab\" aria-controls=\"daily\" aria-expanded=\"" . $isExpanded . "\">\n                <span class=\"text\">" . lang("rankings_txt_81", true) . "</span>\n            </a>\n        </li>";
                    $isActive = "";
                    $isExpanded = "false";
                }
                echo "\n    </ul>\n    <div id=\"rankingsContent\" class=\"tab-content\">";
            }
            $isActive = "in active";
            if ($currMonsterCfg["general"] == "1") {
                echo "\n        <div role=\"tabpanel\" class=\"tab-pane fade " . $isActive . "\" id=\"general\" aria-labelledby=\"general-tab\">";
                $isActive = "";
                $ranking_data = LoadCacheData("monster_hunter/" . $_GET["monster"] . "_general.cache");
                echo "\n            <div class=\"table-responsive rankings-table\">\n                <table class=\"table table-hover text-center\">\n                    <thead>\n                        <tr>";
                if (mconfig("rankings_show_place_number")) {
                    echo "<th>#</th>";
                }
                echo "\n                            <th>" . lang("rankings_txt_10", true) . "</th>\n                            <th>" . lang("rankings_txt_11", true) . "</th>\n                            <th>" . lang("rankings_txt_95", true) . "</th>";
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
                        echo "<td>" . number_format($rdata[2]) . "</td>";
                        if ($config["flags"]) {
                            echo "<td><img src=\"" . __PATH_TEMPLATE__ . "images/blank.png\" class=\"flag-icon flag-icon-" . $rdata[3] . "\" alt=\"" . $custom["countries"][$rdata[3]] . "\" title=\"" . $custom["countries"][$rdata[3]] . "\" /></td>";
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
            if ($currMonsterCfg["monthly"] == "1") {
                echo "\n        <div role=\"tabpanel\" class=\"tab-pane fade " . $isActive . "\" id=\"monthly\" aria-labelledby=\"monthly-tab\">";
                $isActive = "";
                $ranking_data = LoadCacheData("monster_hunter/" . $_GET["monster"] . "_monthly.cache");
                echo "\n            <div class=\"table-responsive rankings-table\">\n                <table class=\"table table-hover text-center\">\n                    <thead>\n                        <tr>";
                if (mconfig("rankings_show_place_number")) {
                    echo "<th>#</th>";
                }
                echo "\n                            <th>" . lang("rankings_txt_10", true) . "</th>\n                            <th>" . lang("rankings_txt_11", true) . "</th>\n                            <th>" . lang("rankings_txt_95", true) . "</th>";
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
                        echo "<td><span class=\"rankings-progress\">+" . number_format($rdata[2]) . "</span></td>";
                        if ($config["flags"]) {
                            echo "<td><img src=\"" . __PATH_TEMPLATE__ . "images/blank.png\" class=\"flag-icon flag-icon-" . $rdata[3] . "\" alt=\"" . $custom["countries"][$rdata[3]] . "\" title=\"" . $custom["countries"][$rdata[3]] . "\" /></td>";
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
                if ($currMonsterCfg["monthly_reward"] == "1") {
                    $rewardsHtml = $Rankings->returnRewardsHtml("monthly_monster_hunter_all");
                    if ($rewardsHtml != NULL) {
                        echo $rewardsHtml;
                    }
                }
                echo "\n        </div>";
            }
            if ($currMonsterCfg["weekly"] == "1") {
                echo "\n        <div role=\"tabpanel\" class=\"tab-pane fade " . $isActive . "\" id=\"weekly\" aria-labelledby=\"weekly-tab\">";
                $isActive = "";
                $ranking_data = LoadCacheData("monster_hunter/" . $_GET["monster"] . "_weekly.cache");
                echo "\n            <div class=\"table-responsive rankings-table\">\n                <table class=\"table table-hover text-center\">\n                    <thead>\n                        <tr>";
                if (mconfig("rankings_show_place_number")) {
                    echo "<th>#</th>";
                }
                echo "\n                            <th>" . lang("rankings_txt_10", true) . "</th>\n                            <th>" . lang("rankings_txt_11", true) . "</th>\n                            <th>" . lang("rankings_txt_95", true) . "</th>";
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
                        echo "<td><span class=\"rankings-progress\">+" . number_format($rdata[2]) . "</span></td>";
                        if ($config["flags"]) {
                            echo "<td><img src=\"" . __PATH_TEMPLATE__ . "images/blank.png\" class=\"flag-icon flag-icon-" . $rdata[3] . "\" alt=\"" . $custom["countries"][$rdata[3]] . "\" title=\"" . $custom["countries"][$rdata[3]] . "\" /></td>";
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
                if ($currMonsterCfg["weekly_reward"] == "1") {
                    $rewardsHtml = $Rankings->returnRewardsHtml("weekly_monster_hunter_all");
                    if ($rewardsHtml != NULL) {
                        echo $rewardsHtml;
                    }
                }
                echo "\n        </div>";
            }
            if ($currMonsterCfg["daily"] == "1") {
                echo "\n        <div role=\"tabpanel\" class=\"tab-pane fade " . $isActive . "\" id=\"daily\" aria-labelledby=\"daily-tab\">";
                $isActive = "";
                $ranking_data = LoadCacheData("monster_hunter/" . $_GET["monster"] . "_daily.cache");
                echo "\n            <div class=\"table-responsive rankings-table\">\n                <table class=\"table table-hover text-center\">\n                    <thead>\n                        <tr>";
                if (mconfig("rankings_show_place_number")) {
                    echo "<th>#</th>";
                }
                echo "\n                            <th>" . lang("rankings_txt_10", true) . "</th>\n                            <th>" . lang("rankings_txt_11", true) . "</th>\n                            <th>" . lang("rankings_txt_95", true) . "</th>";
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
                        echo "<td><span class=\"rankings-progress\">+" . number_format($rdata[2]) . "</span></td>";
                        if ($config["flags"]) {
                            echo "<td><img src=\"" . __PATH_TEMPLATE__ . "images/blank.png\" class=\"flag-icon flag-icon-" . $rdata[3] . "\" alt=\"" . $custom["countries"][$rdata[3]] . "\" title=\"" . $custom["countries"][$rdata[3]] . "\" /></td>";
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
                if ($currMonsterCfg["daily_reward"] == "1") {
                    $rewardsHtml = $Rankings->returnRewardsHtml("daily_monster_hunter_all");
                    if ($rewardsHtml != NULL) {
                        echo $rewardsHtml;
                    }
                }
                echo "\n        </div>";
            }
            if ($showTabs) {
                echo "\n    </div>\n</div>";
            }
        } else {
            if (isset($_GET["monster"]) && is_numeric($_GET["monster"]) && 0 <= $_GET["monster"]) {
                $showTabs = true;
                if ($showTabs) {
                    echo "\n<div role=\"tabpanel\" data-example-id=\"togglable-tabs\">\n    <ul id=\"rankingsTabs\" class=\"nav nav-tabs nav-tabs-responsive\" role=\"tablist\">";
                    $isActive = "active";
                    $isExpanded = "true";
                    $count = 0;
                    if ($currMonsterCfg["general"] == "1") {
                        $count++;
                        echo "\n        <li role=\"presentation\" class=\"" . $isActive . "\">\n            <a href=\"#general\" id=\"general-tab\" role=\"tab\" data-toggle=\"tab\" aria-controls=\"general\" aria-expanded=\"" . $isExpanded . "\">\n                <span class=\"text\">" . lang("rankings_txt_80", true) . "</span>\n            </a>\n        </li>";
                        $isActive = "";
                        $isExpanded = "false";
                    }
                    if ($currMonsterCfg["monthly"] == "1") {
                        $count++;
                        if ($count == 2) {
                            $isActive = "next";
                        }
                        echo "\n        <li role=\"presentation\" class=\"" . $isActive . "\">\n            <a href=\"#monthly\" id=\"general-tab\" role=\"tab\" data-toggle=\"tab\" aria-controls=\"monthly\" aria-expanded=\"" . $isExpanded . "\">\n                <span class=\"text\">" . lang("rankings_txt_83", true) . "</span>\n            </a>\n        </li>";
                        $isActive = "";
                        $isExpanded = "false";
                    }
                    if ($currMonsterCfg["weekly"] == "1") {
                        $count++;
                        if ($count == 2) {
                            $isActive = "next";
                        }
                        echo "\n        <li role=\"presentation\" class=\"" . $isActive . "\">\n            <a href=\"#weekly\" id=\"general-tab\" role=\"tab\" data-toggle=\"tab\" aria-controls=\"weekly\" aria-expanded=\"" . $isExpanded . "\">\n                <span class=\"text\">" . lang("rankings_txt_82", true) . "</span>\n            </a>\n        </li>";
                        $isActive = "";
                        $isExpanded = "false";
                    }
                    if ($currMonsterCfg["daily"] == "1") {
                        $count++;
                        if ($count == 2) {
                            $isActive = "next";
                        }
                        echo "\n        <li role=\"presentation\" class=\"" . $isActive . "\">\n            <a href=\"#daily\" id=\"general-tab\" role=\"tab\" data-toggle=\"tab\" aria-controls=\"daily\" aria-expanded=\"" . $isExpanded . "\">\n                <span class=\"text\">" . lang("rankings_txt_81", true) . "</span>\n            </a>\n        </li>";
                        $isActive = "";
                        $isExpanded = "false";
                    }
                    echo "\n    </ul>\n    <div id=\"rankingsContent\" class=\"tab-content\">";
                }
                $isActive = "in active";
                if ($currMonsterCfg["general"] == "1") {
                    echo "\n        <div role=\"tabpanel\" class=\"tab-pane fade " . $isActive . "\" id=\"general\" aria-labelledby=\"general-tab\">";
                    $isActive = "";
                    $ranking_data = LoadCacheData("monster_hunter/" . $_GET["monster"] . "_general.cache");
                    echo "\n            <div class=\"table-responsive rankings-table\">\n                <table class=\"table table-hover text-center\">\n                    <thead>\n                        <tr>";
                    if (mconfig("rankings_show_place_number")) {
                        echo "<th>#</th>";
                    }
                    echo "\n                            <th>" . lang("rankings_txt_10", true) . "</th>\n                            <th>" . lang("rankings_txt_11", true) . "</th>\n                            <th>" . lang("rankings_txt_95", true) . "</th>";
                    if ($config["flags"]) {
                        echo "<th>" . lang("global_module_11", true) . "</th>";
                    }
                    echo "\n                        </tr>\n                    </thead>\n                    <tbody>";
                    $i = 0;
                    if (is_array($ranking_data)) {
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
                                echo "<td>" . number_format($rdata[2]) . "</td>";
                                if ($config["flags"]) {
                                    echo "<td><img src=\"" . __PATH_TEMPLATE__ . "images/blank.png\" class=\"flag-icon flag-icon-" . $rdata[3] . "\" alt=\"" . $custom["countries"][$rdata[3]] . "\" title=\"" . $custom["countries"][$rdata[3]] . "\" /></td>";
                                }
                                echo "</tr>";
                            }
                            $i++;
                        }
                    }
                    echo "\n                    </tbody>\n                </table>\n            </div>";
                    if (mconfig("rankings_show_date")) {
                        echo "<div class=\"rankings-update-time\">";
                        echo lang("rankings_txt_20", true) . " " . date($config["time_date_format"], $ranking_data[0][0]);
                        echo "</div>";
                    }
                    echo "\n        </div>";
                }
                if ($currMonsterCfg["monthly"] == "1") {
                    echo "\n        <div role=\"tabpanel\" class=\"tab-pane fade " . $isActive . "\" id=\"monthly\" aria-labelledby=\"monthly-tab\">";
                    $isActive = "";
                    $ranking_data = LoadCacheData("monster_hunter/" . $_GET["monster"] . "_monthly.cache");
                    echo "\n            <div class=\"table-responsive rankings-table\">\n                <table class=\"table table-hover text-center\">\n                    <thead>\n                        <tr>";
                    if (mconfig("rankings_show_place_number")) {
                        echo "<th>#</th>";
                    }
                    echo "\n                            <th>" . lang("rankings_txt_10", true) . "</th>\n                            <th>" . lang("rankings_txt_11", true) . "</th>\n                            <th>" . lang("rankings_txt_95", true) . "</th>";
                    if ($config["flags"]) {
                        echo "<th>" . lang("global_module_11", true) . "</th>";
                    }
                    echo "\n                        </tr>\n                    </thead>\n                    <tbody>";
                    $i = 0;
                    if (is_array($ranking_data)) {
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
                                echo "<td><span class=\"rankings-progress\">+" . number_format($rdata[2]) . "</span></td>";
                                if ($config["flags"]) {
                                    echo "<td><img src=\"" . __PATH_TEMPLATE__ . "images/blank.png\" class=\"flag-icon flag-icon-" . $rdata[3] . "\" alt=\"" . $custom["countries"][$rdata[3]] . "\" title=\"" . $custom["countries"][$rdata[3]] . "\" /></td>";
                                }
                                echo "</tr>";
                            }
                            $i++;
                        }
                    }
                    echo "\n                    </tbody>\n                </table>\n            </div>";
                    if (mconfig("rankings_show_date")) {
                        echo "<div class=\"rankings-update-time\">";
                        echo lang("rankings_txt_20", true) . " " . date($config["time_date_format"], $ranking_data[0][0]);
                        echo "</div>";
                    }
                    if ($currMonsterCfg["monthly_reward"] == "1") {
                        $rewardsHtml = $Rankings->returnRewardsHtml("monthly_monster_hunter_" . $_GET["monster"]);
                        if ($rewardsHtml != NULL) {
                            echo $rewardsHtml;
                        }
                    }
                    echo "\n        </div>";
                }
                if ($currMonsterCfg["weekly"] == "1") {
                    echo "\n        <div role=\"tabpanel\" class=\"tab-pane fade " . $isActive . "\" id=\"weekly\" aria-labelledby=\"weekly-tab\">";
                    $isActive = "";
                    $ranking_data = LoadCacheData("monster_hunter/" . $_GET["monster"] . "_weekly.cache");
                    echo "\n            <div class=\"table-responsive rankings-table\">\n                <table class=\"table table-hover text-center\">\n                    <thead>\n                        <tr>";
                    if (mconfig("rankings_show_place_number")) {
                        echo "<th>#</th>";
                    }
                    echo "\n                            <th>" . lang("rankings_txt_10", true) . "</th>\n                            <th>" . lang("rankings_txt_11", true) . "</th>\n                            <th>" . lang("rankings_txt_95", true) . "</th>";
                    if ($config["flags"]) {
                        echo "<th>" . lang("global_module_11", true) . "</th>";
                    }
                    echo "\n                        </tr>\n                    </thead>\n                    <tbody>";
                    $i = 0;
                    if (is_array($ranking_data)) {
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
                                echo "<td><span class=\"rankings-progress\">+" . number_format($rdata[2]) . "</span></td>";
                                if ($config["flags"]) {
                                    echo "<td><img src=\"" . __PATH_TEMPLATE__ . "images/blank.png\" class=\"flag-icon flag-icon-" . $rdata[3] . "\" alt=\"" . $custom["countries"][$rdata[3]] . "\" title=\"" . $custom["countries"][$rdata[3]] . "\" /></td>";
                                }
                                echo "</tr>";
                            }
                            $i++;
                        }
                    }
                    echo "\n                    </tbody>\n                </table>\n            </div>";
                    if (mconfig("rankings_show_date")) {
                        echo "<div class=\"rankings-update-time\">";
                        echo lang("rankings_txt_20", true) . " " . date($config["time_date_format"], $ranking_data[0][0]);
                        echo "</div>";
                    }
                    if ($currMonsterCfg["weekly_reward"] == "1") {
                        $rewardsHtml = $Rankings->returnRewardsHtml("weekly_monster_hunter_" . $_GET["monster"]);
                        if ($rewardsHtml != NULL) {
                            echo $rewardsHtml;
                        }
                    }
                    echo "\n        </div>";
                }
                if ($currMonsterCfg["daily"] == "1") {
                    echo "\n        <div role=\"tabpanel\" class=\"tab-pane fade " . $isActive . "\" id=\"daily\" aria-labelledby=\"daily-tab\">";
                    $isActive = "";
                    $ranking_data = LoadCacheData("monster_hunter/" . $_GET["monster"] . "_daily.cache");
                    echo "\n            <div class=\"table-responsive rankings-table\">\n                <table class=\"table table-hover text-center\">\n                    <thead>\n                        <tr>";
                    if (mconfig("rankings_show_place_number")) {
                        echo "<th>#</th>";
                    }
                    echo "\n                            <th>" . lang("rankings_txt_10", true) . "</th>\n                            <th>" . lang("rankings_txt_11", true) . "</th>\n                            <th>" . lang("rankings_txt_95", true) . "</th>";
                    if ($config["flags"]) {
                        echo "<th>" . lang("global_module_11", true) . "</th>";
                    }
                    echo "\n                        </tr>\n                    </thead>\n                    <tbody>";
                    $i = 0;
                    if (is_array($ranking_data)) {
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
                                echo "<td><span class=\"rankings-progress\">+" . number_format($rdata[2]) . "</span></td>";
                                if ($config["flags"]) {
                                    echo "<td><img src=\"" . __PATH_TEMPLATE__ . "images/blank.png\" class=\"flag-icon flag-icon-" . $rdata[3] . "\" alt=\"" . $custom["countries"][$rdata[3]] . "\" title=\"" . $custom["countries"][$rdata[3]] . "\" /></td>";
                                }
                                echo "</tr>";
                            }
                            $i++;
                        }
                    }
                    echo "\n                    </tbody>\n                </table>\n            </div>";
                    if (mconfig("rankings_show_date")) {
                        echo "<div class=\"rankings-update-time\">";
                        echo lang("rankings_txt_20", true) . " " . date($config["time_date_format"], $ranking_data[0][0]);
                        echo "</div>";
                    }
                    if ($currMonsterCfg["daily_reward"] == "1") {
                        $rewardsHtml = $Rankings->returnRewardsHtml("daily_monster_hunter_" . $_GET["monster"]);
                        if ($rewardsHtml != NULL) {
                            echo $rewardsHtml;
                        }
                    }
                    echo "\n        </div>";
                }
                if ($showTabs) {
                    echo "\n    </div>\n</div>";
                }
            }
        }
    } else {
        message("error", lang("error_44", true));
    }
}

?>