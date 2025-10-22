<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$General = new xGeneral();
if ($General->ftanHCIfo_canUse_j8GsnawwvJ_Module("arkawar")) {
    $Rankings = new Rankings();
    if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
        $breadcrumb = generateBreadcrumb();
        echo "\r\n    <h3>\r\n        " . lang("module_titles_txt_10", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
        $menu = $Rankings->rankingsMenu(false);
        echo $menu;
        loadModuleConfigs("rankings");
        if (mconfig("active") && mconfig("rankings_enable_arkawar_history")["@attributes"]["general"]) {
            $ranking_data = LoadCacheData("rankings_arkawar_history.cache");
            $elements = [1 => lang("arkawar_txt_23", true), 2 => lang("arkawar_txt_24", true), 3 => lang("arkawar_txt_25", true), 4 => lang("arkawar_txt_26", true), 5 => lang("arkawar_txt_27", true)];
            $areas = [1 => lang("arkawar_txt_28", true), 2 => lang("arkawar_txt_29", true), 3 => lang("arkawar_txt_30", true)];
            echo "\r\n        <div class=\"table-responsive rankings-table\">\r\n            <table class=\"table table-hover text-center\">\r\n                <thead>\r\n                    <tr>\r\n                        <th style=\"font-weight:bold;\">" . lang("arkawar_txt_7", true) . "</th>\r\n                        <th style=\"font-weight:bold;\">" . lang("arkawar_txt_3", true) . "</th>\r\n                        <th style=\"font-weight:bold;\">" . lang("rankings_txt_41", true) . "</th>\r\n                        <th style=\"font-weight:bold;\">" . lang("arkawar_txt_4", true) . "</th>\r\n                        <th style=\"font-weight:bold;\">" . lang("arkawar_txt_5", true) . "</th>\r\n                        <th style=\"font-weight:bold;\">" . lang("arkawar_txt_6", true) . "</th>\r\n                    </tr>\r\n                </thead>\r\n                <tbody>";
            $i = 0;
            foreach ($ranking_data as $rdata) {
                if (1 <= $i) {
                    echo "\r\n                    <tr>\r\n                        <td>" . date($config["date_format"], strtotime($rdata[3])) . "</td>\r\n                        <td><a href=\"" . __BASE_URL__ . "profile/guild/req/" . hex_encode($rdata[0]) . "/\">" . $common->replaceHtmlSymbols($rdata[0]) . "</a></td>\r\n                        <td>" . returnGuildLogo($rdata[1], 26) . "</td>\r\n                        <td>";
                    if ($config["flags"]) {
                        echo "<img src=\"" . __PATH_TEMPLATE__ . "images/blank.png\" class=\"flag-icon flag-icon-" . $rdata[6] . "\" alt=\"" . $custom["countries"][$rdata[6]] . "\" title=\"" . $custom["countries"][$rdata[6]] . "\" /> ";
                    }
                    echo "\r\n                            <a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($rdata[2]) . "/\">" . $common->replaceHtmlSymbols($rdata[2]) . "</a>\r\n                        </td>\r\n                        <td>" . $elements[$rdata[4]] . "</td>\r\n                        <td>" . $areas[$rdata[5]] . "</td>\r\n                    </tr>";
                }
                $i++;
            }
            echo "\r\n                </tbody>\r\n            </table>";
            if (mconfig("rankings_show_date")) {
                echo "<div class=\"rankings-update-time\">";
                echo "" . lang("rankings_txt_20", true) . " " . date($config["time_date_format"], $ranking_data[0][0]);
                echo "</div>";
            }
            echo "\r\n        </div>";
        } else {
            message("error", lang("error_44", true));
        }
    } else {
        $menu = $Rankings->rankingsMenu(true);
        echo $menu;
        loadModuleConfigs("rankings");
        echo "\r\n<div class=\"container_2 account\" align=\"center\">\r\n    <div class=\"cont-image\">";
        if (mconfig("active") && mconfig("rankings_enable_arkawar_history")["@attributes"]["general"]) {
            $ranking_data = LoadCacheData("rankings_arkawar_history.cache");
            $elements = [1 => lang("arkawar_txt_23", true), 2 => lang("arkawar_txt_24", true), 3 => lang("arkawar_txt_25", true), 4 => lang("arkawar_txt_26", true), 5 => lang("arkawar_txt_27", true)];
            $areas = [1 => lang("arkawar_txt_28", true), 2 => lang("arkawar_txt_29", true), 3 => lang("arkawar_txt_30", true)];
            echo "\r\n        <div class=\"container_3 account-wide\" align=\"center\">\r\n            <table class=\"general-table-ui\" cellspacing=\"0\" width=\"100%\">\r\n                <tr>\r\n                    <th style=\"font-weight:bold;\">" . lang("arkawar_txt_7", true) . "</th>\r\n                    <th style=\"font-weight:bold;\">" . lang("arkawar_txt_3", true) . "</th>\r\n                    <th style=\"font-weight:bold;\">" . lang("rankings_txt_41", true) . "</th>\r\n                    <th style=\"font-weight:bold;\">" . lang("arkawar_txt_4", true) . "</th>\r\n                    <th style=\"font-weight:bold;\">" . lang("arkawar_txt_5", true) . "</th>\r\n                    <th style=\"font-weight:bold;\">" . lang("arkawar_txt_6", true) . "</th>\r\n                </tr>";
            $i = 0;
            foreach ($ranking_data as $rdata) {
                if (1 <= $i) {
                    echo "\r\n                    <tr>\r\n                        <td>" . date($config["date_format"], strtotime($rdata[3])) . "</td>\r\n                        <td><a href=\"" . __BASE_URL__ . "profile/guild/req/" . hex_encode($rdata[0]) . "/\">" . $common->replaceHtmlSymbols($rdata[0]) . "</a></td>\r\n                        <td>" . returnGuildLogo($rdata[1], 26) . "</td>\r\n                        <td>";
                    if ($config["flags"]) {
                        echo "<img src=\"" . __PATH_TEMPLATE__ . "style/images/blank.png\" class=\"flag-icon flag-icon-" . $rdata[6] . "\" alt=\"" . $custom["countries"][$rdata[6]] . "\" title=\"" . $custom["countries"][$rdata[6]] . "\" /> ";
                    }
                    echo "\r\n                            <a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($rdata[2]) . "/\">" . $common->replaceHtmlSymbols($rdata[2]) . "</a>\r\n                        </td>\r\n                        <td>" . $elements[$rdata[4]] . "</td>\r\n                        <td>" . $areas[$rdata[5]] . "</td>\r\n                    </tr>";
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
        echo "\r\n    </div>\r\n</div>";
    }
}

?>