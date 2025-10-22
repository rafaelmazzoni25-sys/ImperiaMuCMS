<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$json = [];
try {
    if (!(include_once "../includes/imperiamucmsajax.php")) {
        throw new Exception("Could not load the AJAX configurations file.");
    }
    loadModuleConfigs("bosstimer");
    if (mconfig("active")) {
        $bossData = LoadCacheData("boss_timer.cache");
        if (is_array($bossData)) {
            $now = time();
            $nowDateTime = date("Y-m-d H:i:s", $now);
            $i = 0;
            $jsonIndex = 0;
            foreach ($bossData as $thisBoss) {
                if (0 < $i) {
                    $nextTime = NULL;
                    $timeLeft = NULL;
                    $nextDate = NULL;
                    $checkBossKill = $dB->query_fetch_single("SELECT TOP 1 * FROM IMPERIAMUCMS_TRIGGER_MONSTER WHERE MonsterID = ? ORDER BY LastKilled DESC", [$thisBoss[1]]);
                    if ($checkBossKill["LastKilled"] == NULL || date("Y-m-d- H:i:s", strtotime($checkBossKill["LastKilled"])) < date("Y-m-d- H:i:s", $now - $thisBoss[2])) {
                        $json[$jsonIndex] = ["name" => $thisBoss[0], "nextDate" => $nextDate, "nextTime" => $nextTime, "timeLeft" => $timeLeft];
                    } else {
                        $timeLeft = $thisBoss[2] - ($now - strtotime($checkBossKill["LastKilled"]));
                        $nextday = $now + $timeLeft;
                        if ($now <= $nextday) {
                            $fecha1 = date("d", $now);
                            $fecha2 = date("d", $nextday);
                            $resultado = $fecha2 - $fecha1;
                            $daysCount = $resultado;
                            $nextDate = date("Y-m-d", strtotime($nowDateTime . " + " . $daysCount . " days"));
                        }
                        $nextTime = date("H:i", $now + $timeLeft);
                        $json[$jsonIndex] = ["name" => $thisBoss[0], "nextDate" => $nextDate, "nextTime" => $nextTime, "timeLeft" => $timeLeft];
                    }
                    if (mconfig("show_killer") && $checkBossKill["Name"] != NULL) {
                        $json[$jsonIndex]["lastKiller"] = $checkBossKill["Name"];
                    }
                    if (mconfig("show_date") && $checkBossKill["LastKilled"] != NULL) {
                        $json[$jsonIndex]["lastKilled"] = date($config["time_date_format"], strtotime($checkBossKill["LastKilled"]));
                    }
                }
                $i++;
                $jsonIndex++;
            }
        }
    }
} catch (Exception $e) {
    $json["error"] = @$e->getMessage();
    echo @json_encode($json);
}

?>