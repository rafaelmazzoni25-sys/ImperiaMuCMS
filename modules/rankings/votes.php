<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$Rankings = new Rankings();
if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
    $breadcrumb = generateBreadcrumb();
    echo "\r\n    <h3>\r\n        " . lang("module_titles_txt_10", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
    $menu = $Rankings->rankingsMenu(false);
    echo $menu;
    $Character = new Character();
    loadModuleConfigs("rankings");
    if (mconfig("active")) {
        $showTabs = true;
        if ($showTabs) {
            echo "\r\n            <div role=\"tabpanel\" data-example-id=\"togglable-tabs\">\r\n                <ul id=\"rankingsTabs\" class=\"nav nav-tabs nav-tabs-responsive\" role=\"tablist\">";
            $isActive = "active";
            $isExpanded = "true";
            $count = 0;
            if (mconfig("rankings_enable_votes")["@attributes"]["general"] == "1") {
                $count++;
                echo "\r\n                    <li role=\"presentation\" class=\"" . $isActive . "\">\r\n                        <a href=\"#general\" id=\"general-tab\" role=\"tab\" data-toggle=\"tab\" aria-controls=\"general\" aria-expanded=\"" . $isExpanded . "\">\r\n                            <span class=\"text\">" . lang("rankings_txt_80", true) . "</span>\r\n                        </a>\r\n                    </li>";
                $isActive = "";
                $isExpanded = "false";
            }
            if (mconfig("rankings_enable_votes")["@attributes"]["monthly"] == "1") {
                $count++;
                if ($count == 2) {
                    $isActive = "next";
                }
                echo "\r\n                    <li role=\"presentation\" class=\"" . $isActive . "\">\r\n                        <a href=\"#monthly\" id=\"general-tab\" role=\"tab\" data-toggle=\"tab\" aria-controls=\"monthly\" aria-expanded=\"" . $isExpanded . "\">\r\n                            <span class=\"text\">" . lang("rankings_txt_83", true) . "</span>\r\n                        </a>\r\n                    </li>";
                $isActive = "";
                $isExpanded = "false";
            }
            echo "\r\n                </ul>\r\n                <div id=\"rankingsContent\" class=\"tab-content\">";
        }
        $isActive = "in active";
        if (mconfig("rankings_enable_votes")["@attributes"]["general"] == "1") {
            echo "<div role=\"tabpanel\" class=\"tab-pane fade " . $isActive . "\" id=\"general\" aria-labelledby=\"general-tab\">";
            $isActive = "";
            $ranking_data = LoadCacheData("rankings_votes.cache");
            echo "\r\n        <div class=\"table-responsive rankings-table\">\r\n            <table class=\"table table-hover text-center\">\r\n                <thead>\r\n                    <tr>";
            if (mconfig("rankings_show_place_number")) {
                echo "<th>#</th>";
            }
            echo "\r\n                        <th>" . lang("rankings_txt_10", true) . "</th>\r\n                        <th>" . lang("rankings_txt_32", true) . "</th>";
            if ($config["flags"]) {
                echo "<th>" . lang("global_module_11", true) . "</th>";
            }
            echo "\r\n                    </tr>\r\n                </thead>\r\n                <tbody>";
            $i = 0;
            foreach ($ranking_data as $rdata) {
                $accountInfo = $common->accountInformation($rdata[0]);
                $characterName = $Character->AccountCharacterIDC($accountInfo[_CLMN_USERNM_]);
                if ($characterName == NULL) {
                    $characterName = $accountInfo[_CLMN_USERNM_];
                }
                if (1 <= $i) {
                    echo "<tr>";
                    if (mconfig("rankings_show_place_number")) {
                        echo "<td>" . $i . "</td>";
                    }
                    echo "<td><a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($characterName) . "/\">" . $common->replaceHtmlSymbols($characterName) . "</a></td>";
                    echo "<td>" . $rdata[1] . "</td>";
                    if ($config["flags"]) {
                        echo "<td><img src=\"" . __PATH_TEMPLATE__ . "images/blank.png\" class=\"flag-icon flag-icon-" . $rdata[3] . "\" alt=\"" . $custom["countries"][$rdata[3]] . "\" title=\"" . $custom["countries"][$rdata[3]] . "\" /></td>";
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
        if (mconfig("rankings_enable_votes")["@attributes"]["monthly"] == "1") {
            echo "\r\n                <div role=\"tabpanel\" class=\"tab-pane fade" . $isActive . "\" id=\"monthly\" aria-labelledby=\"monthly-tab\">";
            $isActive = "";
            $ranking_data = LoadCacheData("monthly_rankings/rankings_votes.cache");
            echo "\r\n        <div class=\"table-responsive rankings-table\">\r\n            <table class=\"table table-hover text-center\">\r\n                <thead>\r\n                    <tr>";
            if (mconfig("rankings_show_place_number")) {
                echo "<th>#</th>";
            }
            echo "\r\n                        <th>" . lang("rankings_txt_10", true) . "</th>\r\n                        <th>" . lang("rankings_txt_32", true) . "</th>";
            if ($config["flags"]) {
                echo "<th>" . lang("global_module_11", true) . "</th>";
            }
            echo "\r\n                    </tr>\r\n                </thead>\r\n                <tbody>";
            $i = 0;
            foreach ($ranking_data as $rdata) {
                $accountInfo = $common->accountInformation($rdata[0]);
                $characterName = $Character->AccountCharacterIDC($accountInfo[_CLMN_USERNM_]);
                if ($characterName == NULL) {
                    $characterName = $accountInfo[_CLMN_USERNM_];
                }
                if (1 <= $i) {
                    echo "<tr>";
                    if (mconfig("rankings_show_place_number")) {
                        echo "<td>" . $i . "</td>";
                    }
                    echo "<td><a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($characterName) . "/\">" . $common->replaceHtmlSymbols($characterName) . "</a></td>";
                    echo "<td>" . $rdata[1] . "</td>";
                    if ($config["flags"]) {
                        echo "<td><img src=\"" . __PATH_TEMPLATE__ . "images/blank.png\" class=\"flag-icon flag-icon-" . $rdata[3] . "\" alt=\"" . $custom["countries"][$rdata[3]] . "\" title=\"" . $custom["countries"][$rdata[3]] . "\" /></td>";
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
        if ($showTabs) {
            echo "\r\n            </div>\r\n        </div>";
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
    if (mconfig("active") && mconfig("rankings_enable_votes")) {
        if (mconfig("rankings_enable_votes")["@attributes"]["monthly"] == "1") {
            $ranking_data = LoadCacheData("monthly_rankings/rankings_votes.cache");
        }
        if (mconfig("rankings_enable_votes")["@attributes"]["general"] == "1") {
            $ranking_data = LoadCacheData("rankings_votes.cache");
        }
        echo "<div class=\"container_3 account-wide\" align=\"center\"><table class=\"general-table-ui\" cellspacing=\"0\" width=\"100%\"><tr>";
        if (mconfig("rankings_show_place_number")) {
            echo "<th style=\"font-weight:bold;\">#</th>";
        }
        echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_10", true) . "</th>";
        echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_32", true) . "</th>";
        if ($config["flags"]) {
            echo "<th style=\"font-weight:bold;\">" . lang("global_module_11", true) . "</th>";
        }
        echo "</tr>";
        $i = 0;
        foreach ($ranking_data as $rdata) {
            $accountInfo = $common->accountInformation($rdata[0]);
            $characterName = $Character->AccountCharacterIDC($accountInfo[_CLMN_USERNM_]);
            if ($characterName == NULL) {
                $characterName = $accountInfo[_CLMN_USERNM_];
            }
            if (1 <= $i) {
                echo "<tr>";
                if (mconfig("rankings_show_place_number")) {
                    echo "<td>" . $i . "</td>";
                }
                echo "<td><a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($characterName) . "/\">" . $common->replaceHtmlSymbols($characterName) . "</a></td>";
                echo "<td>" . $rdata[1] . "</td>";
                if ($config["flags"]) {
                    echo "<td><img src=\"" . __PATH_TEMPLATE__ . "style/images/blank.png\" class=\"flag-icon flag-icon-" . $rdata[2] . "\" alt=\"" . $custom["countries"][$rdata[2]] . "\" title=\"" . $custom["countries"][$rdata[2]] . "\" /></td>";
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