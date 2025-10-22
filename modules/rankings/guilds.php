<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$Rankings = new Rankings();
if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
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
            if (mconfig("rankings_enable_characters")["@attributes"]["general"] == "1") {
                $count++;
                echo "\r\n                    <li role=\"presentation\" class=\"" . $isActive . "\">\r\n                        <a href=\"#general\" id=\"general-tab\" role=\"tab\" data-toggle=\"tab\" aria-controls=\"general\" aria-expanded=\"" . $isExpanded . "\">\r\n                            <span class=\"text\">" . lang("rankings_txt_80", true) . "</span>\r\n                        </a>\r\n                    </li>";
                $isActive = "";
                $isExpanded = "false";
            }
            if (mconfig("rankings_enable_characters")["@attributes"]["monthly"] == "1") {
                $count++;
                if ($count == 2) {
                    $isActive = "next";
                }
                echo "\r\n                    <li role=\"presentation\" class=\"" . $isActive . "\">\r\n                        <a href=\"#monthly\" id=\"general-tab\" role=\"tab\" data-toggle=\"tab\" aria-controls=\"monthly\" aria-expanded=\"" . $isExpanded . "\">\r\n                            <span class=\"text\">" . lang("rankings_txt_83", true) . "</span>\r\n                        </a>\r\n                    </li>";
                $isActive = "";
                $isExpanded = "false";
            }
            if (mconfig("rankings_enable_characters")["@attributes"]["weekly"] == "1") {
                $count++;
                if ($count == 2) {
                    $isActive = "next";
                }
                echo "\r\n                    <li role=\"presentation\" class=\"" . $isActive . "\">\r\n                        <a href=\"#weekly\" id=\"general-tab\" role=\"tab\" data-toggle=\"tab\" aria-controls=\"weekly\" aria-expanded=\"" . $isExpanded . "\">\r\n                            <span class=\"text\">" . lang("rankings_txt_82", true) . "</span>\r\n                        </a>\r\n                    </li>";
                $isActive = "";
                $isExpanded = "false";
            }
            if (mconfig("rankings_enable_characters")["@attributes"]["daily"] == "1") {
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
        if (mconfig("rankings_enable_characters")["@attributes"]["general"] == "1") {
            echo "<div role=\"tabpanel\" class=\"tab-pane fade " . $isActive . "\" id=\"general\" aria-labelledby=\"general-tab\">";
            $isActive = "";
            $ranking_data = LoadCacheData("rankings_guilds.cache");
            echo "\r\n        <div class=\"table-responsive rankings-table\">\r\n            <table class=\"table table-hover text-center\">\r\n                <thead>\r\n                    <tr>";
            if (mconfig("rankings_show_place_number")) {
                echo "<th>#</th>";
            }
            echo "\r\n                        <th>" . lang("rankings_txt_17", true) . "</th>\r\n                        <th>" . lang("rankings_txt_28", true) . "</th>\r\n                        <th>" . lang("rankings_txt_18", true) . "</th>\r\n                        <th>" . lang("rankings_txt_66", true) . "</th>";
            if (mconfig("rankings_guild_type")) {
                echo "\r\n                        <th>" . lang("rankings_txt_45", true) . "</th>\r\n                        <th>" . lang("rankings_txt_85", true) . "</th>";
                if ($config["use_resets"]) {
                    echo "<th>" . lang("rankings_txt_86", true) . "</th>";
                }
                if ($config["use_grand_resets"]) {
                    echo "<th>" . lang("rankings_txt_87", true) . "</th>";
                }
            } else {
                echo "<th>" . lang("rankings_txt_19", true) . "</th>";
            }
            echo "\r\n                    </tr>\r\n                </thead>\r\n                <tbody>";
            $i = 0;
            foreach ($ranking_data as $rdata) {
                if (1 <= $i && 0 <= $rdata[2]) {
                    echo "<tr>";
                    if (mconfig("rankings_show_place_number")) {
                        echo "<td>" . $i . "</td>";
                    }
                    echo "<td><a href=\"" . __BASE_URL__ . "profile/guild/req/" . hex_encode($rdata[0]) . "/\">" . $common->replaceHtmlSymbols($rdata[0]) . "</a></td>";
                    echo "<td>" . returnGuildLogo($rdata[6], 26) . "</td>";
                    echo "<td><a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($rdata[1]) . "/\">" . $common->replaceHtmlSymbols($rdata[1]) . "</a></td>";
                    echo "<td>" . number_format($rdata[7]) . "</td>";
                    if (mconfig("rankings_guild_type")) {
                        echo "<td>" . number_format($rdata[2]) . "</td>";
                        echo "<td>" . number_format($rdata[3]) . "</td>";
                        if ($config["use_resets"]) {
                            echo "<td>" . number_format($rdata[4]) . "</td>";
                        }
                        if ($config["use_grand_resets"]) {
                            echo "<td>" . number_format($rdata[5]) . "</td>";
                        }
                    } else {
                        echo "<td>" . number_format($rdata[8]) . "</td>";
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
        if (mconfig("rankings_enable_guilds")["@attributes"]["monthly"] == "1") {
            echo "\r\n                <div role=\"tabpanel\" class=\"tab-pane fade " . $isActive . "\" id=\"monthly\" aria-labelledby=\"monthly-tab\">";
            $isActive = "";
            $ranking_data = LoadCacheData("monthly_rankings/rankings_guilds.cache");
            echo "\r\n        <div class=\"table-responsive rankings-table\">\r\n            <table class=\"table table-hover text-center\">\r\n                <thead>\r\n                    <tr>";
            if (mconfig("rankings_show_place_number")) {
                echo "<th>#</th>";
            }
            echo "\r\n                        <th>" . lang("rankings_txt_17", true) . "</th>\r\n                        <th>" . lang("rankings_txt_28", true) . "</th>\r\n                        <th>" . lang("rankings_txt_18", true) . "</th>\r\n                        <th>" . lang("rankings_txt_66", true) . "</th>";
            if (mconfig("rankings_guild_type")) {
                echo "\r\n                        <th>" . lang("global_module_5", true) . "</th>\r\n                        <th>" . lang("global_module_6", true) . "</th>";
                if ($config["use_resets"]) {
                    echo "<th>" . lang("global_module_7", true) . "</th>";
                }
                if ($config["use_grand_resets"]) {
                    echo "<th>" . lang("global_module_8", true) . "</th>";
                }
            } else {
                echo "<th>" . lang("rankings_txt_19", true) . "</th>";
            }
            echo "\r\n                    </tr>\r\n                </thead>\r\n                <tbody>";
            $i = 0;
            foreach ($ranking_data as $rdata) {
                if (1 <= $i && 0 <= $rdata[2]) {
                    echo "<tr>";
                    if (mconfig("rankings_show_place_number")) {
                        echo "<td>" . $i . "</td>";
                    }
                    echo "<td><a href=\"" . __BASE_URL__ . "profile/guild/req/" . hex_encode($rdata[0]) . "/\">" . $common->replaceHtmlSymbols($rdata[0]) . "</a></td>";
                    echo "<td>" . returnGuildLogo($rdata[7], 26) . "</td>";
                    echo "<td><a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($rdata[1]) . "/\">" . $common->replaceHtmlSymbols($rdata[1]) . "</a></td>";
                    echo "<td>" . number_format($rdata[8]) . "</td>";
                    if (mconfig("rankings_guild_type")) {
                        echo "<td><span class=\"rankings-progress\">+" . number_format($rdata[3]) . "</span></td>";
                        echo "<td><span class=\"rankings-progress\">+" . number_format($rdata[4]) . "</span></td>";
                        if ($config["use_resets"]) {
                            echo "<td><span class=\"rankings-progress\">+" . number_format($rdata[5]) . "</span></td>";
                        }
                        if ($config["use_grand_resets"]) {
                            echo "<td><span class=\"rankings-progress\">+" . number_format($rdata[6]) . "</span></td>";
                        }
                    } else {
                        echo "<td><span class=\"rankings-progress\">+" . number_format($rdata[2]) . "</span></td>";
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
        if (mconfig("rankings_enable_guilds")["@attributes"]["weekly"] == "1") {
            echo "\r\n                <div role=\"tabpanel\" class=\"tab-pane fade " . $isActive . "\" id=\"weekly\" aria-labelledby=\"weekly-tab\">";
            $isActive = "";
            $ranking_data = LoadCacheData("weekly_rankings/rankings_guilds.cache");
            echo "\r\n        <div class=\"table-responsive rankings-table\">\r\n            <table class=\"table table-hover text-center\">\r\n                <thead>\r\n                    <tr>";
            if (mconfig("rankings_show_place_number")) {
                echo "<th>#</th>";
            }
            echo "\r\n                        <th>" . lang("rankings_txt_17", true) . "</th>\r\n                        <th>" . lang("rankings_txt_28", true) . "</th>\r\n                        <th>" . lang("rankings_txt_18", true) . "</th>\r\n                        <th>" . lang("rankings_txt_66", true) . "</th>";
            if (mconfig("rankings_guild_type")) {
                echo "\r\n                        <th>" . lang("global_module_5", true) . "</th>\r\n                        <th>" . lang("global_module_6", true) . "</th>";
                if ($config["use_resets"]) {
                    echo "<th>" . lang("global_module_7", true) . "</th>";
                }
                if ($config["use_grand_resets"]) {
                    echo "<th>" . lang("global_module_8", true) . "</th>";
                }
            } else {
                echo "<th>" . lang("rankings_txt_19", true) . "</th>";
            }
            echo "\r\n                    </tr>\r\n                </thead>\r\n                <tbody>";
            $i = 0;
            foreach ($ranking_data as $rdata) {
                if (1 <= $i && 0 <= $rdata[2]) {
                    echo "<tr>";
                    if (mconfig("rankings_show_place_number")) {
                        echo "<td>" . $i . "</td>";
                    }
                    echo "<td><a href=\"" . __BASE_URL__ . "profile/guild/req/" . hex_encode($rdata[0]) . "/\">" . $common->replaceHtmlSymbols($rdata[0]) . "</a></td>";
                    echo "<td>" . returnGuildLogo($rdata[7], 26) . "</td>";
                    echo "<td><a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($rdata[1]) . "/\">" . $common->replaceHtmlSymbols($rdata[1]) . "</a></td>";
                    echo "<td>" . number_format($rdata[8]) . "</td>";
                    if (mconfig("rankings_guild_type")) {
                        echo "<td><span class=\"rankings-progress\">+" . number_format($rdata[3]) . "</span></td>";
                        echo "<td><span class=\"rankings-progress\">+" . number_format($rdata[4]) . "</span></td>";
                        if ($config["use_resets"]) {
                            echo "<td><span class=\"rankings-progress\">+" . number_format($rdata[5]) . "</span></td>";
                        }
                        if ($config["use_grand_resets"]) {
                            echo "<td><span class=\"rankings-progress\">+" . number_format($rdata[6]) . "</span></td>";
                        }
                    } else {
                        echo "<td><span class=\"rankings-progress\">+" . number_format($rdata[2]) . "</span></td>";
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
        if (mconfig("rankings_enable_guilds")["@attributes"]["daily"] == "1") {
            echo "\r\n                <div role=\"tabpanel\" class=\"tab-pane fade " . $isActive . "\" id=\"daily\" aria-labelledby=\"daily-tab\">";
            $isActive = "";
            $ranking_data = LoadCacheData("daily_rankings/rankings_guilds.cache");
            echo "\r\n        <div class=\"table-responsive rankings-table\">\r\n            <table class=\"table table-hover text-center\">\r\n                <thead>\r\n                    <tr>";
            if (mconfig("rankings_show_place_number")) {
                echo "<th>#</th>";
            }
            echo "\r\n                        <th>" . lang("rankings_txt_17", true) . "</th>\r\n                        <th>" . lang("rankings_txt_28", true) . "</th>\r\n                        <th>" . lang("rankings_txt_18", true) . "</th>\r\n                        <th>" . lang("rankings_txt_66", true) . "</th>";
            if (mconfig("rankings_guild_type")) {
                echo "\r\n                        <th>" . lang("global_module_5", true) . "</th>\r\n                        <th>" . lang("global_module_6", true) . "</th>";
                if ($config["use_resets"]) {
                    echo "<th>" . lang("global_module_7", true) . "</th>";
                }
                if ($config["use_grand_resets"]) {
                    echo "<th>" . lang("global_module_8", true) . "</th>";
                }
            } else {
                echo "<th>" . lang("rankings_txt_19", true) . "</th>";
            }
            echo "\r\n                    </tr>\r\n                </thead>\r\n                <tbody>";
            $i = 0;
            foreach ($ranking_data as $rdata) {
                if (1 <= $i && 0 <= $rdata[2]) {
                    echo "<tr>";
                    if (mconfig("rankings_show_place_number")) {
                        echo "<td>" . $i . "</td>";
                    }
                    echo "<td><a href=\"" . __BASE_URL__ . "profile/guild/req/" . hex_encode($rdata[0]) . "/\">" . $common->replaceHtmlSymbols($rdata[0]) . "</a></td>";
                    echo "<td>" . returnGuildLogo($rdata[7], 26) . "</td>";
                    echo "<td><a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($rdata[1]) . "/\">" . $common->replaceHtmlSymbols($rdata[1]) . "</a></td>";
                    echo "<td>" . number_format($rdata[8]) . "</td>";
                    if (mconfig("rankings_guild_type")) {
                        echo "<td><span class=\"rankings-progress\">+" . number_format($rdata[3]) . "</span></td>";
                        echo "<td><span class=\"rankings-progress\">+" . number_format($rdata[4]) . "</span></td>";
                        if ($config["use_resets"]) {
                            echo "<td><span class=\"rankings-progress\">+" . number_format($rdata[5]) . "</span></td>";
                        }
                        if ($config["use_grand_resets"]) {
                            echo "<td><span class=\"rankings-progress\">+" . number_format($rdata[6]) . "</span></td>";
                        }
                    } else {
                        echo "<td><span class=\"rankings-progress\">+" . number_format($rdata[2]) . "</span></td>";
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
    echo "\r\n  <div class=\"container_2 account\" align=\"center\">\r\n    <div class=\"cont-image\">";
    if (mconfig("active") && mconfig("rankings_enable_guilds")["@attributes"]["general"]) {
        $ranking_data = LoadCacheData("rankings_guilds.cache");
        echo "<div class=\"container_3 account-wide\" align=\"center\"><table class=\"general-table-ui\" cellspacing=\"0\" width=\"100%\"><tr>";
        if (mconfig("rankings_show_place_number")) {
            echo "<th>#</th>";
        }
        echo "\r\n                        <th>" . lang("rankings_txt_17", true) . "</th>\r\n                        <th>" . lang("rankings_txt_28", true) . "</th>\r\n                        <th>" . lang("rankings_txt_18", true) . "</th>\r\n                        <th>" . lang("rankings_txt_66", true) . "</th>";
        if (mconfig("rankings_guild_type")) {
            echo "\r\n                        <th>" . lang("rankings_txt_45", true) . "</th>\r\n                        <th>" . lang("rankings_txt_85", true) . "</th>";
            if ($config["use_resets"]) {
                echo "<th>" . lang("rankings_txt_86", true) . "</th>";
            }
            if ($config["use_grand_resets"]) {
                echo "<th>" . lang("rankings_txt_87", true) . "</th>";
            }
        } else {
            echo "<th>" . lang("rankings_txt_19", true) . "</th>";
        }
        echo "\r\n                    </tr>\r\n                </thead>\r\n                <tbody>";
        $i = 0;
        foreach ($ranking_data as $rdata) {
            if (1 <= $i && 0 <= $rdata[2]) {
                echo "<tr>";
                if (mconfig("rankings_show_place_number")) {
                    echo "<td>" . $i . "</td>";
                }
                echo "<td><a href=\"" . __BASE_URL__ . "profile/guild/req/" . hex_encode($rdata[0]) . "/\">" . $common->replaceHtmlSymbols($rdata[0]) . "</a></td>";
                echo "<td>" . returnGuildLogo($rdata[6], 26) . "</td>";
                echo "<td><a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($rdata[1]) . "/\">" . $common->replaceHtmlSymbols($rdata[1]) . "</a></td>";
                echo "<td>" . number_format($rdata[7]) . "</td>";
                if (mconfig("rankings_guild_type")) {
                    echo "<td>" . number_format($rdata[2]) . "</td>";
                    echo "<td>" . number_format($rdata[3]) . "</td>";
                    if ($config["use_resets"]) {
                        echo "<td>" . number_format($rdata[4]) . "</td>";
                    }
                    if ($config["use_grand_resets"]) {
                        echo "<td>" . number_format($rdata[5]) . "</td>";
                    }
                } else {
                    echo "<td>" . number_format($rdata[8]) . "</td>";
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
        echo "</div>";
    } else {
        message("error", lang("error_44", true));
    }
    echo "\r\n  </div>\r\n</div>";
}

?>