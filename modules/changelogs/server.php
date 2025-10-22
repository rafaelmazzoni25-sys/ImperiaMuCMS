<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

loadModuleConfigs("changelog");
$Changelog = new Changelog();
echo "\r\n<div class=\"sub-page-title\">\r\n    <div id=\"title\">\r\n        <h1>";
echo lang("changelogs_txt_1", true);
echo "<p></p><span></span></h1>\r\n    </div>\r\n</div>\r\n<div class=\"container_2\" align=\"center\">\r\n    <div class=\"changelogs-cats\">\r\n        <a href=\"";
echo __BASE_URL__;
echo "changelogs/server\" class=\"active\">";
echo lang("changelogs_txt_2", true);
echo "</p></a>\r\n        <a href=\"";
echo __BASE_URL__;
echo "changelogs/website\">";
echo lang("changelogs_txt_3", true);
echo "</p></a>\r\n        <div class=\"clear\"></div>\r\n    </div>\r\n\r\n    ";
$list = $Changelog->retrieveChangelogSrv();
if (is_array($list)) {
    echo "\r\n<div class=\"container_3 changelogs\">\r\n<table class=\"changes-list\" id=\"changes-list\">\r\n <tbody>";
    foreach ($list as $thisLog) {
        echo "\r\n  <tr>\r\n        <td class=\"changelog-rev\"><span style=\"color:#c59e4b\">" . $thisLog["title"] . "</span></td>\r\n        <td class=\"changelog-by\"><p style=\"color:red\">" . $thisLog["author"] . "</p></td>\r\n        <td class=\"changelog-date\"><span style=\"color:#c59e4b\">" . date($config["date_format"], strtotime($thisLog["date"])) . "</span> </td>\r\n        <td class=\"changelog-info\"><span style=\"color:#816537\">" . $thisLog["text"] . "</span></td>\r\n    </tr>";
    }
    echo "</tbody></table></div>";
} else {
    message("error", lang("changelogs_error_1", true));
}
echo "\r\n</div>";

?>