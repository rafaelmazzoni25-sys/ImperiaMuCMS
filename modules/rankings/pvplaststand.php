<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$Rankings = new Rankings();
$menu = $Rankings->rankingsMenu(true);
echo $menu;
$Character = new Character();
loadModuleConfigs("rankings");
echo "\r\n  <div class=\"container_2 account\" align=\"center\">\r\n    <div class=\"cont-image\">";
if (mconfig("active") && mconfig("rankings_enable_pvplaststand")) {
    $ranking_data = LoadCacheData("rankings_pvplaststand.cache");
    echo "<div class=\"container_3 account-wide\" align=\"center\"><table class=\"general-table-ui\" cellspacing=\"0\" width=\"100%\"><tr>";
    if (mconfig("rankings_show_place_number")) {
        echo "<th style=\"font-weight:bold;\">#</th>";
    }
    echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_10", true) . "</th>";
    echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_11", true) . "</th>";
    echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_25", true) . "</th>";
    echo "</tr>";
    $i = 0;
    foreach ($ranking_data as $rdata) {
        if (1 <= $i) {
            echo "<tr>";
            if (mconfig("rankings_show_place_number")) {
                echo "<td>" . $i . "</td>";
            }
            echo "<td>" . $common->replaceHtmlSymbols($rdata[0]) . "</td>";
            echo "<td>" . $custom["character_class"][$rdata[1]][0] . "</td>";
            echo "<td>" . $rdata[2] . "</td>";
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

?>