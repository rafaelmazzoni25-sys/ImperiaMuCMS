<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$file_name = basename(__FILE__);
$dir_path = str_replace("\\", "/", dirname(dirname(__FILE__))) . "/";
include $dir_path . "includes/imperiamucms.php";
$cacheDATA = LoadCacheData("cron.cache");
foreach ($cacheDATA as $key => $thisCRON) {
    if ($key != 0) {
        $cron = ["id" => $thisCRON[0], "file" => $thisCRON[3], "run_time" => $thisCRON[4], "last_run" => $thisCRON[5], "status" => $thisCRON[6]];
        if ($cron["status"] == 1) {
            if (!check_value($cron["last_run"])) {
                $lrtime = $cron["run_time"];
            } else {
                $lrtime = $cron["last_run"] + $cron["run_time"];
            }
            if ($lrtime < time()) {
                $filePath = __PATH_CRON__ . $cron["file"];
                if (file_exists($filePath)) {
                    include $filePath;
                }
            }
        }
    }
}

?>