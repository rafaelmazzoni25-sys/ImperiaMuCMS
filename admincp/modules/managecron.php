<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h1 class=\"page-header\">Cron Job Manager</h1>\n";
$cron_times = ["1" => 300, "2" => 600, "3" => 900, "4" => 1800, "5" => 3600, "6" => 7200, "7" => 14400, "8" => 28800, "9" => 36000, "10" => 43200, "11" => 86400, "12" => 259200, "13" => 604800, "14" => 1209600, "15" => 1814400, "16" => 2419200];
if (check_value($_REQUEST["cache"]) && $_REQUEST["cache"] == 1) {
    $cacheDATA = BuildCacheData($dB->query_fetch("SELECT * FROM IMPERIAMUCMS_CRON"));
    UpdateCache("cron.cache", $cacheDATA);
    message("success", "Cron jobs cache successfully updated!");
}
if (check_value($_REQUEST["reset"]) && $_REQUEST["reset"] == 1) {
    $resetCrons = $dB->query("UPDATE IMPERIAMUCMS_CRON SET cron_last_run = NULL");
    if ($resetCrons) {
        $cacheDATA = BuildCacheData($dB->query_fetch("SELECT * FROM IMPERIAMUCMS_CRON"));
        UpdateCache("cron.cache", $cacheDATA);
        message("success", "Crons successfully reset and cache updated!");
    } else {
        message("error", "Could not reset crons.");
    }
}
if (check_value($_REQUEST["delete"])) {
    deleteCronJob($_REQUEST["delete"]);
}
if (check_value($_REQUEST["togglestatus"])) {
    togglestatusCronJob($_REQUEST["togglestatus"]);
}
$cronJobs = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_CRON ORDER BY cron_id ASC");
if (is_array($cronJobs)) {
    echo "<table class=\"table table-striped table-bordered\"><tr><th></th><th>Cron</th><th>File</th><th>Run Time</th><th>Last Run</th><th>Status</th></tr>";
    foreach ($cronJobs as $thisCron) {
        if (is_null($thisCron["cron_last_run"])) {
            $thisCron["cron_last_run"] = "<i>never</i>";
        } else {
            $thisCron["cron_last_run"] = date($config["time_date_format"], $thisCron["cron_last_run"]);
        }
        if ($thisCron["cron_status"] == 1) {
            $status = "<a href=\"index.php?module=managecron&togglestatus=" . $thisCron["cron_id"] . "\" class=\"btn btn-success btn-circle btn-xs\"><i class=\"fa fa-check\"></i></a>";
        } else {
            $status = "<a href=\"index.php?module=managecron&togglestatus=" . $thisCron["cron_id"] . "\" class=\"btn btn-default btn-circle btn-xs\"><i class=\"fa fa-check\"></i></a>";
        }
        $cron_t = sec_to_hms($thisCron["cron_run_time"]);
        echo "<tr>";
        echo "<td style=\"text-align:center;\"><a href=\"index.php?module=managecron&delete=" . $thisCron["cron_id"] . "\" class=\"btn btn-danger\" ><i class=\"fa fa-remove\"></i></a></td>";
        echo "<td><strong>" . $thisCron["cron_name"] . "</strong><br /><small>" . $thisCron["cron_description"] . "</small></td>";
        echo "<td>" . $thisCron["cron_file_run"] . "</td>";
        echo "<td>" . $cron_t[0] . "h " . $cron_t[1] . "m</td>";
        echo "<td>" . $thisCron["cron_last_run"] . "</td>";
        echo "<td style=\"text-align:center;\">" . $status . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    message("error", "No cron jobs added.");
}
echo "<hr>";
echo "<a class=\"btn btn-info\" href=\"index.php?module=" . $_REQUEST["module"] . "&cache=1\">UPDATE CRON JOBS CACHE</a> &nbsp;";
echo "<a class=\"btn btn-info\" href=\"index.php?module=" . $_REQUEST["module"] . "&reset=1\">RESET ALL CRON JOBS</a>";

?>