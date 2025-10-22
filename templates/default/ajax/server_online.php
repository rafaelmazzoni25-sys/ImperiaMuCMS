<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */
try {
    if (!(include_once "ajaxconfig.php")) {
        throw new Exception("Could not load the AJAX configurations file.");
    }
    if (!(include_once __PATH_INCLUDES__ . "serverstatus_config.php")) {
        throw new Exception("Could not load the server status configurations file.");
    }
    if (isset($config["serveronline"]["ip"]) && isset($config["serveronline"]["port"])) {
        $ip = $config["serveronline"]["ip"];
        $port = intval($config["serveronline"]["port"]);
        if (check_port($ip, $port)) {
            if (config("SQL_USE_2_DB", true)) {
                if ($config["server_names"] != NULL && !empty($config["server_names"])) {
                    $server_names = "";
                    foreach ($config["server_names"] as $thisName) {
                        if ($server_names == "") {
                            $server_names = "'" . $thisName . "'";
                        } else {
                            $server_names .= ", '" . $thisName . "'";
                        }
                    }
                    $online = $dB2->query_fetch_single("SELECT COUNT(*) AS count FROM MEMB_STAT WHERE ConnectStat = '1' AND ServerName IN (" . $server_names . ")");
                } else {
                    $online = $dB2->query_fetch_single("SELECT COUNT(*) AS count FROM MEMB_STAT WHERE ConnectStat = '1'");
                }
            } else {
                $online = $dB->query_fetch_single("SELECT COUNT(*) AS count FROM MEMB_STAT WHERE ConnectStat = '1'");
            }
            echo "<p class=\"status online\" id=\"logon-status2\">" . lang("template_txt_1", true) . " (" . $online["count"] . ")</p>";
        } else {
            echo "<p class=\"status offline\" id=\"logon-status2\">" . lang("template_txt_2", true) . "</p>";
        }
    } else {
        throw new Exception("Main server IP or PORT not set");
    }
} catch (Exception $e) {
    echo "Error";
}

?>