<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$Rankings = new Rankings();
if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
    $breadcrumb = generateBreadcrumb();
    echo "\r\n    <h3>\r\n        " . lang("module_titles_txt_10", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
    $menu = $Rankings->rankingsMenu(false);
    echo $menu;
    loadModuleConfigs("rankings");
    if (mconfig("active") && mconfig("rankings_enable_married")["@attributes"]["general"]) {
        $ranking_data = LoadCacheData("rankings_married.cache");
        echo "\r\n        <div class=\"table-responsive rankings-table\">\r\n            <table class=\"table table-hover text-center\">\r\n                <thead>\r\n                    <tr>\r\n                        <th>" . lang("rankings_txt_10", true) . " #1</th>\r\n                        <th>" . lang("rankings_txt_10", true) . " #2</th>\r\n                    </tr>\r\n                </thead>\r\n                <tbody>";
        $i = 0;
        foreach ($ranking_data as $rdata) {
            if ($rdata[3] == NULL) {
                $rdata[3] = 0;
            }
            if (1 <= $i) {
                echo "<tr>";
                echo "<td><a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($rdata[0]) . "/\">" . $common->replaceHtmlSymbols($rdata[0]) . "</a></td>";
                echo "<td><a href=\"" . __BASE_URL__ . "profile/player/req/" . $rdata[1] . "/\">" . $common->replaceHtmlSymbols($rdata[1]) . "</a></td>";
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
    loadModuleConfigs("rankings");
    echo "\r\n  <div class=\"container_2 account\" align=\"center\">\r\n    <div class=\"cont-image\">";
    if (mconfig("active") && mconfig("rankings_enable_married")["@attributes"]["general"]) {
        $ranking_data = LoadCacheData("rankings_married.cache");
        echo "<div class=\"container_3 account-wide\" align=\"center\"><table class=\"general-table-ui\" cellspacing=\"0\" width=\"100%\"><tr>";
        echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_10", true) . " #1</th>";
        echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_10", true) . " #2</th>";
        echo "</tr>";
        $i = 0;
        foreach ($ranking_data as $rdata) {
            if ($rdata[3] == NULL) {
                $rdata[3] = 0;
            }
            if (1 <= $i) {
                echo "<tr>";
                echo "<td><a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($rdata[0]) . "/\">" . $common->replaceHtmlSymbols($rdata[0]) . "</a></td>";
                echo "<td><a href=\"" . __BASE_URL__ . "profile/player/req/" . $rdata[1] . "/\">" . $common->replaceHtmlSymbols($rdata[1]) . "</a></td>";
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