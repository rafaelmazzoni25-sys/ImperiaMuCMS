<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "\r\n<div class=\"sub-page-title\">\r\n    <div id=\"title\">\r\n        <h1>";
echo lang("changelogs_txt_1", true);
echo "<p></p><span></span></h1>\r\n    </div>\r\n</div>\r\n<div class=\"container_2\" align=\"center\">\r\n    <div class=\"changelogs-cats\">\r\n        <a href=\"";
echo __BASE_URL__;
echo "changelogs/server\">";
echo lang("changelogs_txt_2", true);
echo "</p></a>\r\n        <a href=\"";
echo __BASE_URL__;
echo "changelogs/website\" class=\"active\">";
echo lang("changelogs_txt_3", true);
echo "</a>\r\n        <div class=\"clear\"></div>\r\n    </div>\r\n\r\n\r\n    ";
$Changelog = new Changelog();
$list = $Changelog->retrieveChangelogWeb();
if (is_array($list)) {
    echo "\r\n  <div class=\"container_3 changelogs\">\r\n    <table class=\"changes-list\" id=\"changes-list\">\r\n  \t <tbody>";
    foreach ($list as $thisLog) {
        echo "\r\n      <tr>\r\n  \t\t\t<td class=\"changelog-rev\"><span style=\"color:#c59e4b\">" . $thisLog["title"] . "</span></td>\r\n  \t\t\t<td class=\"changelog-by\"><p style=\"color:red\">" . $thisLog["author"] . "</p></td>\r\n  \t\t\t<td class=\"changelog-date\"><span style=\"color:#c59e4b\">" . date($config["date_format"], strtotime($thisLog["date"])) . "</span> </td>\r\n  \t\t\t<td class=\"changelog-info\"><span style=\"color:#816537\">" . $thisLog["text"] . "</span></td>\r\n  \t\t</tr>";
    }
    echo "</tbody></table></div>";
} else {
    message("error", lang("changelogs_error_1", true));
}
echo "\r\n</div>";

?>