<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$Rankings = new Rankings();
if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
    $breadcrumb = generateBreadcrumb();
    echo "\r\n    <h3>\r\n        " . lang("module_titles_txt_10", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
    $menu = $Rankings->rankingsMenu(false);
    echo $menu;
    loadModuleConfigs("rankings");
    if (mconfig("active") && mconfig("rankings_enable_online_players")["@attributes"]["general"]) {
        if (isset($_GET["class"])) {
            $filter = "_" . xss_clean($_GET["class"]);
        } else {
            $filter = "";
        }
        $ranking_data = LoadCacheData("rankings_online_players.cache");
        echo "\r\n        <div class=\"table-responsive rankings-table\">\r\n            <table class=\"table table-hover text-center\">\r\n                <thead>\r\n                    <tr>";
        if (mconfig("rankings_show_place_number")) {
            echo "<th>#</th>";
        }
        echo "\r\n                        <th>" . lang("rankings_txt_10", true) . "</th>\r\n                        <th>" . lang("rankings_txt_11", true) . "</th>\r\n                        <th>" . lang("global_module_5", true) . "</th>\r\n                        <th>" . lang("global_module_6", true) . "</th>";
        if ($config["use_resets"]) {
            echo "<th>" . lang("global_module_7", true) . "</th>";
        }
        if ($config["use_grand_resets"]) {
            echo "<th>" . lang("global_module_8", true) . "</th>";
        }
        echo "\r\n                        <th>" . lang("profiles_txt_29", true) . "</th>\r\n                        <th>" . lang("rankings_txt_53", true) . "</th>";
        if ($config["flags"]) {
            echo "<th>" . lang("global_module_11", true) . "</th>";
        }
        echo "\r\n                    </tr>\r\n                </thead>\r\n                <tbody>";
        $i = 0;
        foreach ($ranking_data as $rdata) {
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
                echo "<td>" . $custom["map_codes"][$rdata[8]] . "</td>";
                echo "<td>" . $rdata[9] . "</td>";
                if ($config["flags"]) {
                    echo "<td><img src=\"" . __PATH_TEMPLATE__ . "images/blank.png\" class=\"flag-icon flag-icon-" . $rdata[6] . "\" alt=\"" . $custom["countries"][$rdata[6]] . "\" title=\"" . $custom["countries"][$rdata[6]] . "\" /></td>";
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
    } else {
        message("error", lang("error_44", true));
    }
} else {
    $menu = $Rankings->rankingsMenu(true);
    echo $menu;
    $Character = new Character();
    loadModuleConfigs("rankings");
    echo "\r\n  <div class=\"container_2 account\" align=\"center\">\r\n    <div class=\"cont-image\">";
    if (mconfig("active") && mconfig("rankings_enable_online_players")["@attributes"]["general"]) {
        $ranking_data = LoadCacheData("rankings_online_players.cache");
        echo "<div class=\"container_3 account-wide\" align=\"center\"><table class=\"general-table-ui\" cellspacing=\"0\" width=\"100%\"><tr>";
        if (mconfig("rankings_show_place_number")) {
            echo "<th style=\"font-weight:bold;\">#</th>";
        }
        echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_10", true) . "</th>";
        echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_11", true) . "</th>";
        echo "<th style=\"font-weight:bold;\">" . lang("global_module_5", true) . "</th>";
        echo "<th style=\"font-weight:bold;\">" . lang("global_module_6", true) . "</th>";
        if ($config["use_resets"]) {
            echo "<th style=\"font-weight:bold;\">" . lang("global_module_7", true) . "";
        }
        if ($config["use_grand_resets"]) {
            echo " [" . lang("global_module_8", true) . "]</th>";
        } else {
            echo "</th>";
        }
        echo "<th style=\"font-weight:bold;\">" . lang("profiles_txt_29", true) . "</th>";
        echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_53", true) . "</th>";
        if ($config["flags"]) {
            echo "<th style=\"font-weight:bold;\">" . lang("global_module_11", true) . "</th>";
        }
        echo "</tr>";
        $i = 0;
        foreach ($ranking_data as $rdata) {
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
                    echo "<td>" . $rdata[4];
                }
                if ($config["use_grand_resets"]) {
                    echo " [" . $rdata[5] . "]</td>";
                } else {
                    echo "</td>";
                }
                echo "<td>" . $custom["map_codes"][$rdata[8]] . "</td>";
                echo "<td>" . $rdata[9] . "</td>";
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
        echo "</div>";
    } else {
        message("error", lang("error_44", true));
    }
    echo "\r\n  </div>\r\n</div>";
}

?>