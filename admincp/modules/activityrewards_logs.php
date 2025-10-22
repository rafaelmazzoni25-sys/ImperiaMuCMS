<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h1 class=\"page-header\">Activity Rewards Logs</h1>";
$limit = 50;
$page = $_GET["pg"];
if ($page == NULL) {
    $page = 1;
}
$search = NULL;
if (isset($_GET["search"]) && $_GET["search"] != NULL && $_GET["search"] != "") {
    $search = $_GET["search"];
} else {
    unset($_GET["search"]);
    $search = NULL;
}
generateLogPage("activityrewards_logs", true, $page, $limit, $search);

?>