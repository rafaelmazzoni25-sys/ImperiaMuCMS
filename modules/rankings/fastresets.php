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
        if (mconfig("rankings_enable_fast_resets")["@attributes"]["general"] == "1") {
            echo "<div role=\"tabpanel\" class=\"tab-pane fade in active\" id=\"general\" aria-labelledby=\"general-tab\">";
            $ranking_data = LoadCacheData("rankings_fast_resets.cache");
            echo "\r\n        <div class=\"table-responsive rankings-table\">\r\n            <table class=\"table table-hover text-center\">\r\n                <thead>\r\n                    <tr>";
            if (mconfig("rankings_show_place_number")) {
                echo "<th>#</th>";
            }
            echo "\r\n                        <th>" . lang("rankings_txt_10", true) . "</th>\r\n                        <th>" . lang("rankings_txt_11", true) . "</th>\r\n                        <th>" . lang("rankings_txt_100", true) . "</th>\r\n                        <th>" . lang("rankings_txt_102", true) . "</th>\r\n                        <th>" . lang("rankings_txt_101", true) . "</th>";
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
                    echo "<td>" . formatmicroseconds($rdata[2]) . "</td>";
                    echo "<td>" . $rdata[3] . "</td>";
                    if ($i == 1) {
                        echo "<td>-</td>";
                    } else {
                        echo "<td><span class=\"rankings-progress-neg\">+" . formatmicroseconds($rdata[5]) . "</span></td>";
                    }
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
        } else {
            message("error", lang("error_44", true));
        }
    } else {
        message("error", lang("error_44", true));
    }
}
function formatMicroseconds($microseconds)
{
    $seconds = $microseconds / 1000000;
    $microseconds = $microseconds % 1000000;
    $minutes = $seconds / 60;
    $seconds = $seconds % 60;
    $hours = $minutes / 60;
    $minutes = $minutes % 60;
    if ($hours < 1) {
        $hours = "00";
    } else {
        $hours = floor($hours);
        if (strlen($hours) == 1) {
            $hours = "0" . $hours;
        }
    }
    if ($minutes < 1) {
        $minutes = "00";
    } else {
        $minutes = floor($minutes);
        if (strlen($minutes) == 1) {
            $minutes = "0" . $minutes;
        }
    }
    if ($seconds < 1) {
        $seconds = "00";
    } else {
        $seconds = floor($seconds);
        if (strlen($seconds) == 1) {
            $seconds = "0" . $seconds;
        }
    }
    if ($microseconds < 1) {
        $microseconds = "000000";
    } else {
        $microseconds = floor($microseconds);
        while (strlen($microseconds) != 6) {
            $microseconds = "0" . $microseconds;
        }
    }
    return $hours . ":" . $minutes . ":" . $seconds . "." . $microseconds;
}

?>