<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<div class=\"row\"><div class=\"col-md-6\"><div class=\"panel panel-primary\"><div class=\"panel-heading\">General Information</div><div class=\"panel-body\"><div class=\"list-group\">";
echo "<a href=\"" . __IMPERIAMUCMS_LICENSE_SERVER__ . "\" class=\"list-group-item\" target=\"_blank\">";
if (checkVersion()) {
    echo "<i class=\"fa fa-remove\"></i> ImperiaMuCMS Version";
} else {
    echo "<i class=\"fa fa-check\"></i> ImperiaMuCMS Version";
}
echo "<span class=\"pull-right text-muted small\">";
if (checkVersion()) {
    echo "<span class=\"label label-danger\">Update ";
    echo latestVersion();
    echo " Available</span>  ";
}
echo "<em>" . __IMPERIAMUCMS_VERSION__ . "</em>";
echo "</span></a></div><div class=\"list-group\">";
$dbacc = config("SQL_USE_2_DB", true) ? $dB2 : $dB;
$totalAccounts = $dbacc->query_fetch_single("SELECT COUNT(*) as result FROM MEMB_INFO");
echo "<div class=\"list-group-item\">Registered Accounts";
echo "<span class=\"pull-right text-muted small\">" . number_format($totalAccounts["result"]) . "</span>";
echo "</div>";
$bannedAccounts = $dbacc->query_fetch_single("SELECT COUNT(*) as result FROM MEMB_INFO WHERE bloc_code = 1");
echo "<div class=\"list-group-item\">Banned Accounts";
echo "<span class=\"pull-right text-muted small\">" . number_format($bannedAccounts["result"]) . "</span>";
echo "</div>";
$totalCharacters = $dB->query_fetch_single("SELECT COUNT(*) as result FROM Character");
echo "<div class=\"list-group-item\">Characters";
echo "<span class=\"pull-right text-muted small\">" . number_format($totalCharacters["result"]) . "</span>";
echo "</div>";
$scheduledTasks = $dB->query_fetch_single("SELECT COUNT(*) as result FROM IMPERIAMUCMS_CRON");
echo "<div class=\"list-group-item\">Scheduled Tasks (cron)";
echo "<span class=\"pull-right text-muted small\">" . number_format($scheduledTasks["result"]) . "</span>";
echo "</div><div class=\"list-group-item\">Server Time (web)";
echo "<span class=\"pull-right text-muted small\">" . date($config["time_date_format"]) . "</span>";
echo "</div>";
$gmcpUsers = implode(", ", array_keys(config("gamemasters", true)));
echo "<div class=\"list-group-item\">Game Masters";
echo "<span class=\"pull-right text-muted small\">" . $gmcpUsers . "</span>";
echo "</div></div></div></div></div><div class=\"col-md-6\"><div class=\"panel panel-default\"><div class=\"panel-heading\">ImperiaMuCMS Facebook Feed</div><div class=\"panel-body\">\r\n      <iframe src=\"//www.facebook.com/plugins/likebox.php?\r\n      href=http%3A%2F%2Fwww.facebook.com%2FImperiaMuCMS&amp;\r\n      width=600&amp;height=500&amp;colorscheme=light&amp;\r\n      show_faces=false&amp;header=false&amp;stream=true&amp;\r\n      show_border=false&amp;appId=1439010682981422\" scrolling=\"no\"\r\n      frameborder=\"0\" style=\"border:none; overflow:hidden;\r\n      width:100%; height:500px;\" allowTransparency=\"true\"></iframe></div></div></div></div>";

?>