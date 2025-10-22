<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h1 class=\"page-header\">VIP Logs</h1>";
$limit = 20;
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
if (isset($_GET["start"]) && $_GET["start"] != NULL && $_GET["start"] != "") {
    $start = $_GET["start"];
} else {
    unset($_GET["start"]);
    $start = NULL;
}
if (isset($_GET["end"]) && $_GET["end"] != NULL && $_GET["end"] != "") {
    $end = $_GET["end"];
} else {
    unset($_GET["end"]);
    $end = NULL;
}
generateLogPage("vip_logs", false, $page, $limit, $search, $start, $end);

?>