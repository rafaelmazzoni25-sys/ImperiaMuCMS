<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */
if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
    $breadcrumb = generateBreadcrumb();
    echo "\r\n    <h3>\r\n        " . lang("search_txt_1", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
    if (check_value($_POST["search"])) {
        $charName = addslashes($_POST["charname"]);
        $charName = xss_clean($charName);
        if (3 <= strlen($charName) && strlen($charName) <= 10) {
            message("info", sprintf(lang("search_txt_5", true), $common->replaceHtmlSymbols(xss_clean($_POST["charname"]))));
            $characters = $dB->query_fetch("SELECT Name, cLevel, Class, RESETS, mLevel, Grand_Resets FROM Character WHERE Name LIKE '%" . $charName . "%'");
            $Character = new Character();
            echo "<div class=\"table-responsive rankings-table\">\r\n            <table class=\"table table-hover text-center\"><tr><th class=\"headerRow\">#</th>";
            echo "<th class=\"headerRow\">" . lang("global_module_3", true) . "</th>";
            echo "<th class=\"headerRow\">" . lang("global_module_4", true) . "</th>";
            echo "<th class=\"headerRow\">" . lang("global_module_5", true) . "</th>";
            echo "<th class=\"headerRow\">" . lang("global_module_6", true) . "</th>";
            if ($config["use_resets"]) {
                echo "<th class=\"headerRow\">" . lang("global_module_7", true) . "</th>";
            }
            if ($config["use_grand_resets"]) {
                echo "<th class=\"headerRow\">" . lang("global_module_8", true) . "</th>";
            }
            if ($config["flags"]) {
                echo "<th class=\"headerRow\">" . lang("global_module_11", true) . "</th>";
            }
            echo "<th class=\"headerRow\">" . lang("global_module_9", true) . "</th>";
            echo "</tr>";
            $i = 1;
            if (is_array($characters)) {
                foreach ($characters as $thisChar) {
                    $country = $Character->getCharacterFlag($thisChar["Name"]);
                    $flag = "<img src=\"" . __PATH_TEMPLATE__ . "images/blank.png\" class=\"flag-icon flag-icon-" . $country . "\" alt=\"" . $custom["countries"][$country] . "\" title=\"" . $custom["countries"][$country] . "\"/>";
                    echo "<tr>";
                    echo "<td>" . $i . "</td>";
                    echo "<td>" . $common->replaceHtmlSymbols($thisChar["Name"]) . "</td>";
                    echo "<td>" . $custom["character_class"][$thisChar["Class"]][0] . "</td>";
                    echo "<td>" . $thisChar["cLevel"] . "</td>";
                    echo "<td>" . $thisChar["mLevel"] . "</td>";
                    if ($config["use_resets"]) {
                        echo "<td>" . $thisChar["RESETS"] . "</td>";
                    }
                    if ($config["use_grand_resets"]) {
                        echo "<td>" . $thisChar["Grand_Resets"] . "</td>";
                    }
                    if ($config["flags"]) {
                        echo "<td>" . $flag . "</td>";
                    }
                    echo "<td><a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($thisChar["Name"]) . "/\">" . lang("search_txt_3", true) . "</a></td>";
                    echo "</tr>";
                    $i++;
                }
            } else {
                echo "<tr><td colspan=\"8\" align=\"center\">" . lang("search_txt_4", true) . "</td></tr>";
            }
            echo "</table></div>";
        } else {
            message("error", lang("search_txt_4", true));
        }
    } else {
        message("error", lang("search_txt_4", true));
    }
} else {
    echo "\r\n<div class=\"sub-page-title\">\r\n  <div id=\"title\"><h1>" . lang("search_txt_1", true) . "<p></p><span></span></h1></div>\r\n</div>\r\n<div class=\"container_2 account\" align=\"center\">\r\n  <div class=\"cont-image\">\r\n    <div class=\"container_3 account_sub_header\">\r\n      <div class=\"grad\">\r\n        <div class=\"page-title\">" . lang("search_txt_2", true) . "</div>\r\n        <div class=\"sub-active-page\">\"" . $common->replaceHtmlSymbols(xss_clean($_POST["charname"])) . "\"</div>\r\n      </div>\r\n    </div>";
    if (check_value($_POST["search"])) {
        $charName = addslashes($_POST["charname"]);
        $charName = xss_clean($charName);
        if (3 <= strlen($charName) && strlen($charName) <= 10) {
            $characters = $dB->query_fetch("SELECT Name, cLevel, Class, RESETS, mLevel, Grand_Resets FROM Character WHERE Name LIKE '%" . $charName . "%'");
            $Character = new Character();
            echo "<div class=\"container_3 account-wide\" align=\"center\"><table class=\"irq\" width=\"100%\"><tr><th>#</th>";
            echo "<th>" . lang("global_module_3", true) . "</th>";
            echo "<th>" . lang("global_module_4", true) . "</th>";
            echo "<th>" . lang("global_module_5", true) . "</th>";
            echo "<th>" . lang("global_module_6", true) . "</th>";
            if ($config["use_resets"]) {
                echo "<th>" . lang("global_module_7", true);
            }
            if ($config["use_grand_resets"]) {
                echo " [" . lang("global_module_8", true) . "]";
            }
            echo "</th>";
            if ($config["flags"]) {
                echo "<th>" . lang("global_module_11", true) . "</th>";
            }
            echo "<th>" . lang("global_module_9", true) . "</th>";
            echo "</tr>";
            $i = 1;
            if (is_array($characters)) {
                foreach ($characters as $thisChar) {
                    $country = $Character->getCharacterFlag($thisChar["Name"]);
                    $flag = "<img src=\"" . __PATH_TEMPLATE__ . "style/images/blank.png\" class=\"flag-icon flag-icon-" . $country . "\" alt=\"" . $custom["countries"][$country] . "\" title=\"" . $custom["countries"][$country] . "\"/>";
                    echo "<tr>";
                    echo "<td>" . $i . "</td>";
                    echo "<td>" . $common->replaceHtmlSymbols($thisChar["Name"]) . "</td>";
                    echo "<td>" . $custom["character_class"][$thisChar["Class"]][0] . "</td>";
                    echo "<td>" . $thisChar["cLevel"] . "</td>";
                    echo "<td>" . $thisChar["mLevel"] . "</td>";
                    if ($config["use_resets"]) {
                        echo "<td>" . $thisChar["RESETS"];
                    }
                    if ($config["use_grand_resets"]) {
                        echo " [" . $thisChar["Grand_Resets"] . "]";
                    }
                    echo "</td>";
                    if ($config["flags"]) {
                        echo "<td>" . $flag . "</td>";
                    }
                    echo "<td><a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($thisChar["Name"]) . "/\">" . lang("search_txt_3", true) . "</a></td>";
                    echo "</tr>";
                    $i++;
                }
            } else {
                echo "<tr><td colspan=\"8\" align=\"center\">" . lang("search_txt_4", true) . "</td></tr>";
            }
            echo "</table></div>";
        } else {
            message("error", lang("search_txt_4", true));
        }
    } else {
        message("error", lang("search_txt_4", true));
    }
    echo "\r\n  </div>\r\n</div>";
}

?>