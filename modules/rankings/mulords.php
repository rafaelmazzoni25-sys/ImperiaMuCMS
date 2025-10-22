<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$Rankings = new Rankings();
$menu = $Rankings->rankingsMenu(true);
echo $menu;
loadModuleConfigs("mulords");
echo "\r\n  <div class=\"container_2 account\" align=\"center\">\r\n    <div class=\"cont-image\">";
if (mconfig("active")) {
    $ranking_data = LoadCacheData("rankings_mulords.cache");
    echo "<div class=\"container_3 account-wide\" align=\"center\"><table class=\"general-table-ui\" cellspacing=\"0\" width=\"100%\"><tr><th style=\"font-weight:bold;\">#</th>";
    echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_17", true) . "</th>";
    echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_28", true) . "</th>";
    echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_18", true) . "</th>";
    echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_47", true) . "</th>";
    echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_30", true) . "</th>";
    echo "</tr>";
    $i = 0;
    foreach ($ranking_data as $rdata) {
        if (1 <= $i && 0 <= $rdata[2]) {
            if (0 < $rdata[4]) {
                $rank = $dB->query_fetch_single("SELECT rank FROM IMPERIAMUCMS_MU_LORDS_RANKS WHERE id = ?", [$rdata[4]]);
                $rank = $rank["rank"];
            } else {
                $rank = lang("rankings_txt_48", true);
            }
            echo "<tr>";
            echo "<td>" . $i . "</td>";
            echo "<td><a href=\"" . __BASE_URL__ . "profile/guild/req/" . hex_encode($rdata[0]) . "/\">" . $common->replaceHtmlSymbols($rdata[0]) . "</a></td>";
            echo "<td>" . returnGuildLogo($rdata[2], 26) . "</td>";
            echo "<td><a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($rdata[1]) . "/\">" . $common->replaceHtmlSymbols($rdata[1]) . "</a></td>";
            echo "<td>" . number_format($rdata[3]) . "</td>";
            echo "<td>" . $rank . "</td>";
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