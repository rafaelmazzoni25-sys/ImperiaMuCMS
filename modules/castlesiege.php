<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
    $breadcrumb = generateBreadcrumb();
    echo "\r\n    <h3>\r\n        " . lang("castlesiege_txt_1", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
    if (mconfig("active")) {
        $castleData = LoadCacheData("castle_siege.cache");
        if ($castleData[1] == NULL || !is_array($castleData)) {
            $castleData[1] = NULL;
        }
        echo "\r\n        <div class=\"table-responsive rankings-table\">\r\n            <table class=\"table table-hover text-center\">\r\n                <thead>\r\n                    <tr>\r\n                        <th colspan=\"6\">" . lang("castlesiege_txt_2", true) . "</th>\r\n                    </tr>\r\n                </thead>\r\n                <tbody>";
        echo "<tr>";
        echo "<td rowspan=\"6\" width=\"33%\">" . returnGuildLogo($castleData[1][1], 180) . "</td>";
        echo "</tr><tr>";
        echo "<th width=\"34%\">" . lang("castlesiege_txt_3", true) . "</th>";
        echo "<td width=\"33%\"><a href=\"" . __BASE_URL__ . "profile/guild/req/" . hex_encode($castleData[1][0]) . "/\">" . $common->replaceHtmlSymbols($castleData[1][0]) . "</a></td>";
        echo "</tr><tr>";
        echo "<th>" . lang("castlesiege_txt_4", true) . "</th>";
        echo "<td>" . number_format($castleData[1][2]) . "</td>";
        echo "</tr><tr>";
        echo "<th>" . lang("castlesiege_txt_5", true) . "</th>";
        echo "<td>" . number_format($castleData[1][3]) . "</td>";
        echo "</tr><tr>";
        echo "<th>" . lang("castlesiege_txt_6", true) . "</th>";
        echo "<td>" . number_format($castleData[1][4]) . "</td>";
        echo "</tr><tr>";
        echo "<th>" . lang("castlesiege_txt_7", true) . "</th>";
        echo "<td>" . number_format($castleData[1][5]) . "</td>";
        echo "</tr>\r\n                </tbody>\r\n            </table>\r\n        </div>";
        $castleSiege = $dB->query_fetch_single("SELECT TOP 1 * FROM MuCastle_DATA");
        $siegeStart = $castleSiege["SIEGE_START_DATE"];
        $registerTime = explode(":", mconfig("cs_period_register_time"));
        $siegeStartRegister = strtotime($siegeStart) + mconfig("cs_period_register_day") * 86400 + $registerTime[0] * 3600 + $registerTime[1] * 60;
        $periodRegister = date("Y-m-d H:i", $siegeStartRegister);
        $idle1Time = explode(":", mconfig("cs_period_idle1_time"));
        $siegeStartIdle1 = strtotime($siegeStart) + mconfig("cs_period_idle1_day") * 86400 + $idle1Time[0] * 3600 + $idle1Time[1] * 60;
        $periodIdle1 = date("Y-m-d H:i", $siegeStartIdle1);
        $registerMarkTime = explode(":", mconfig("cs_period_registermark_time"));
        $siegeStartRegisterMark = strtotime($siegeStart) + mconfig("cs_period_registermark_day") * 86400 + $registerMarkTime[0] * 3600 + $registerMarkTime[1] * 60;
        $periodRegisterMark = date("Y-m-d H:i", $siegeStartRegisterMark);
        $idle2Time = explode(":", mconfig("cs_period_idle2_time"));
        $siegeStartIdle2 = strtotime($siegeStart) + mconfig("cs_period_idle2_day") * 86400 + $idle2Time[0] * 3600 + $idle2Time[1] * 60;
        $periodIdle2 = date("Y-m-d H:i", $siegeStartIdle2);
        $notificationTime = explode(":", mconfig("cs_period_notification_time"));
        $siegeStartNotification = strtotime($siegeStart) + mconfig("cs_period_notification_day") * 86400 + $notificationTime[0] * 3600 + $notificationTime[1] * 60;
        $periodNotification = date("Y-m-d H:i", $siegeStartNotification);
        $readyTime = explode(":", mconfig("cs_period_ready_time"));
        $siegeStartReady = strtotime($siegeStart) + mconfig("cs_period_ready_day") * 86400 + $readyTime[0] * 3600 + $readyTime[1] * 60;
        $periodReady = date("Y-m-d H:i", $siegeStartReady);
        $csstartTime = explode(":", mconfig("cs_period_start_time"));
        $siegeStartCSStart = strtotime($siegeStart) + mconfig("cs_period_start_day") * 86400 + $csstartTime[0] * 3600 + $csstartTime[1] * 60;
        $periodCSStart = date("Y-m-d H:i", $siegeStartCSStart);
        $csendTime = explode(":", mconfig("cs_period_end_time"));
        $siegeStartCSEnd = strtotime($siegeStart) + mconfig("cs_period_end_day") * 86400 + $csendTime[0] * 3600 + $csendTime[1] * 60;
        $periodCSEnd = date("Y-m-d H:i", $siegeStartCSEnd);
        $cycleTime = explode(":", mconfig("cs_period_cycle_time"));
        $siegeStartCycle = strtotime($siegeStart) + mconfig("cs_period_cycle_day") * 86400 + $cycleTime[0] * 3600 + $cycleTime[1] * 60;
        $periodCycle = date("Y-m-d H:i", $siegeStartCycle);
        $now = time();
        echo "\r\n        <div class=\"table-responsive rankings-table\">\r\n            <table class=\"table table-hover text-center\">\r\n                <thead>\r\n                    <tr>\r\n                        <th colspan=\"2\">" . lang("castlesiege_txt_8", true) . "</th>\r\n                    </tr>\r\n                </thead>\r\n                <tbody>";
        if (strtotime($periodRegister) <= $now && $now < strtotime($periodIdle1)) {
            echo "<tr>";
            echo "<th>" . lang("castlesiege_txt_9", true) . "</th>";
            echo "<th><span style=\"color: #009900;\">" . lang("castlesiege_txt_10", true) . " " . date($config["time_date_format"], strtotime($periodIdle1)) . "</span></th>";
            echo "</tr>";
        } else {
            echo "<tr>";
            echo "<td width=\"50%\">" . lang("castlesiege_txt_9", true) . "</td>";
            echo "<td width=\"50%\">" . date($config["time_date_format"], strtotime($periodRegister)) . " - " . date($config["time_date_format"], strtotime($periodIdle1)) . "</td>";
            echo "</tr>";
        }
        if (strtotime($periodIdle1) <= $now && $now < strtotime($periodRegisterMark)) {
            echo "<tr>";
            echo "<th>" . lang("castlesiege_txt_11", true) . "</th>";
            echo "<th><span style=\"color: #009900;\">" . lang("castlesiege_txt_10", true) . " " . date($config["time_date_format"], strtotime($periodRegisterMark)) . "</span></th>";
            echo "</tr>";
        } else {
            echo "<tr>";
            echo "<td width=\"50%\">" . lang("castlesiege_txt_11", true) . "</td>";
            echo "<td width=\"50%\">" . date($config["time_date_format"], strtotime($periodIdle1)) . " - " . date($config["time_date_format"], strtotime($periodRegisterMark)) . "</td>";
            echo "</tr>";
        }
        if (strtotime($periodRegisterMark) <= $now && $now < strtotime($periodIdle2)) {
            echo "<tr>";
            echo "<th>" . lang("castlesiege_txt_12", true) . "</th>";
            echo "<th><span style=\"color: #009900;\">" . lang("castlesiege_txt_10", true) . " " . date($config["time_date_format"], strtotime($periodIdle2)) . "</span></th>";
            echo "</tr>";
        } else {
            echo "<tr>";
            echo "<td width=\"50%\">" . lang("castlesiege_txt_12", true) . "</td>";
            echo "<td width=\"50%\">" . date($config["time_date_format"], strtotime($periodRegisterMark)) . " - " . date($config["time_date_format"], strtotime($periodIdle2)) . "</td>";
            echo "</tr>";
        }
        if (strtotime($periodIdle2) <= $now && $now < strtotime($periodNotification)) {
            echo "<tr>";
            echo "<th>" . lang("castlesiege_txt_11", true) . "</th>";
            echo "<th><span style=\"color: #009900;\">" . lang("castlesiege_txt_10", true) . " " . date($config["time_date_format"], strtotime($periodNotification)) . "</span></th>";
            echo "</tr>";
        } else {
            echo "<tr>";
            echo "<td width=\"50%\">" . lang("castlesiege_txt_11", true) . "</td>";
            echo "<td width=\"50%\">" . date($config["time_date_format"], strtotime($periodIdle2)) . " - " . date($config["time_date_format"], strtotime($periodNotification)) . "</td>";
            echo "</tr>";
        }
        if (strtotime($periodNotification) <= $now && $now < strtotime($periodReady)) {
            echo "<tr>";
            echo "<th>" . lang("castlesiege_txt_13", true) . "</th>";
            echo "<th><span style=\"color: #009900;\">" . lang("castlesiege_txt_10", true) . " " . date($config["time_date_format"], strtotime($periodReady)) . "</span></th>";
            echo "</tr>";
        } else {
            echo "<tr>";
            echo "<td width=\"50%\">" . lang("castlesiege_txt_13", true) . "</td>";
            echo "<td width=\"50%\">" . date($config["time_date_format"], strtotime($periodNotification)) . " - " . date($config["time_date_format"], strtotime($periodReady)) . "</td>";
            echo "</tr>";
        }
        if (strtotime($periodReady) <= $now && $now < strtotime($periodCSStart)) {
            echo "<tr>";
            echo "<th>" . lang("castlesiege_txt_14", true) . "</th>";
            echo "<th><span style=\"color: #009900;\">" . lang("castlesiege_txt_10", true) . " " . date($config["time_date_format"], strtotime($periodCSStart)) . "</span></th>";
            echo "</tr>";
        } else {
            echo "<tr>";
            echo "<td width=\"50%\">" . lang("castlesiege_txt_14", true) . "</td>";
            echo "<td width=\"50%\">" . date($config["time_date_format"], strtotime($periodReady)) . " - " . date($config["time_date_format"], strtotime($periodCSStart)) . "</td>";
            echo "</tr>";
        }
        if (strtotime($periodCSStart) <= $now && $now < strtotime($periodCSEnd)) {
            echo "<tr>";
            echo "<th>" . lang("castlesiege_txt_15", true) . "</th>";
            echo "<th><span style=\"color: #009900;\">" . lang("castlesiege_txt_10", true) . " " . date($config["time_date_format"], strtotime($periodCSEnd)) . "</span></th>";
            echo "</tr>";
        } else {
            echo "<tr>";
            echo "<td width=\"50%\">" . lang("castlesiege_txt_15", true) . "</td>";
            echo "<td width=\"50%\">" . date($config["time_date_format"], strtotime($periodCSStart)) . " - " . date($config["time_date_format"], strtotime($periodCSEnd)) . "</td>";
            echo "</tr>";
        }
        if ($now <= strtotime($periodCycle) && strtotime($periodCSEnd) <= $now) {
            echo "<tr>";
            echo "<th>" . lang("castlesiege_txt_11", true) . "</th>";
            echo "<th><span style=\"color: #009900;\">" . lang("castlesiege_txt_10", true) . " " . date($config["time_date_format"], strtotime($periodCycle)) . "</span></th>";
            echo "</tr>";
        } else {
            echo "<tr>";
            echo "<td width=\"50%\">" . lang("castlesiege_txt_11", true) . "</td>";
            echo "<td width=\"50%\">" . date($config["time_date_format"], strtotime($periodCSEnd)) . " - " . date($config["time_date_format"], strtotime($periodCycle)) . "</td>";
            echo "</tr>";
        }
        echo "</table></div>";
        echo "\r\n        <div class=\"table-responsive rankings-table\">\r\n            <table class=\"table table-hover text-center\">\r\n                <thead>\r\n                    <tr>\r\n                        <th colspan=\"6\">" . lang("castlesiege_txt_16", true) . "</th>\r\n                    </tr>\r\n                </thead>\r\n                <tbody>";
        echo "<tr>";
        echo "<th width=\"50%\">" . lang("castlesiege_txt_3", true) . "</th>";
        echo "<th width=\"50%\">" . lang("castlesiege_txt_17", true) . "</th>";
        echo "</tr>";
        $i = 2;
        while ($i < count($castleData)) {
            if (is_array($castleData[$i])) {
                echo "\r\n            <tr>\r\n                <td><a href=\"" . __BASE_URL__ . "profile/guild/req/" . hex_encode($castleData[$i][0]) . "/\" target=\"_blank\">" . $common->replaceHtmlSymbols($castleData[$i][0]) . "</a></td>\r\n                <td>" . $castleData[$i][1] . "</td>\r\n            </tr>";
            }
            $i++;
        }
        echo "</table></div>";
    } else {
        message("error", lang("error_47", true));
    }
} else {
    echo "\r\n<div class=\"sub-page-title\">\r\n  <div id=\"title\"><h1>" . lang("castlesiege_txt_1", true) . "<p></p><span></span></h1></div>\r\n</div>\r\n<div class=\"container_2 account\" align=\"center\">\r\n  <div class=\"cont-image\">\r\n    <div class=\"container_3 account-wide\" align=\"center\">";
    if (mconfig("active")) {
        $castleData = LoadCacheData("castle_siege.cache");
        if ($castleData[1] == NULL || !is_array($castleData)) {
            $castleData[1] = NULL;
        }
        echo "<table class=\"irq\" width=\"100%\"><tr>";
        echo "<th colspan=\"6\">" . lang("castlesiege_txt_2", true) . "</th>";
        echo "</tr><tr>";
        echo "<td rowspan=\"5\" width=\"33%\">" . returnGuildLogo($castleData[1][1], 180) . "</td>";
        echo "<th width=\"34%\">" . lang("castlesiege_txt_3", true) . "</th>";
        echo "<td width=\"33%\"><a href=\"" . __BASE_URL__ . "profile/guild/req/" . hex_encode($castleData[1][0]) . "/\">" . $common->replaceHtmlSymbols($castleData[1][0]) . "</a></td>";
        echo "</tr><tr>";
        echo "<th>" . lang("castlesiege_txt_4", true) . "</th>";
        echo "<td>" . number_format($castleData[1][2]) . "</td>";
        echo "</tr><tr>";
        echo "<th>" . lang("castlesiege_txt_5", true) . "</th>";
        echo "<td>" . number_format($castleData[1][3]) . "</td>";
        echo "</tr><tr>";
        echo "<th>" . lang("castlesiege_txt_6", true) . "</th>";
        echo "<td>" . number_format($castleData[1][4]) . "</td>";
        echo "</tr><tr>";
        echo "<th>" . lang("castlesiege_txt_7", true) . "</th>";
        echo "<td>" . number_format($castleData[1][5]) . "</td>";
        echo "</tr></table>";
        $castleSiege = $dB->query_fetch_single("SELECT TOP 1 * FROM MuCastle_DATA");
        $siegeStart = $castleSiege["SIEGE_START_DATE"];
        $registerTime = explode(":", mconfig("cs_period_register_time"));
        $siegeStartRegister = strtotime($siegeStart) + mconfig("cs_period_register_day") * 86400 + $registerTime[0] * 3600 + $registerTime[1] * 60;
        $periodRegister = date("Y-m-d H:i", $siegeStartRegister);
        $idle1Time = explode(":", mconfig("cs_period_idle1_time"));
        $siegeStartIdle1 = strtotime($siegeStart) + mconfig("cs_period_idle1_day") * 86400 + $idle1Time[0] * 3600 + $idle1Time[1] * 60;
        $periodIdle1 = date("Y-m-d H:i", $siegeStartIdle1);
        $registerMarkTime = explode(":", mconfig("cs_period_registermark_time"));
        $siegeStartRegisterMark = strtotime($siegeStart) + mconfig("cs_period_registermark_day") * 86400 + $registerMarkTime[0] * 3600 + $registerMarkTime[1] * 60;
        $periodRegisterMark = date("Y-m-d H:i", $siegeStartRegisterMark);
        $idle2Time = explode(":", mconfig("cs_period_idle2_time"));
        $siegeStartIdle2 = strtotime($siegeStart) + mconfig("cs_period_idle2_day") * 86400 + $idle2Time[0] * 3600 + $idle2Time[1] * 60;
        $periodIdle2 = date("Y-m-d H:i", $siegeStartIdle2);
        $notificationTime = explode(":", mconfig("cs_period_notification_time"));
        $siegeStartNotification = strtotime($siegeStart) + mconfig("cs_period_notification_day") * 86400 + $notificationTime[0] * 3600 + $notificationTime[1] * 60;
        $periodNotification = date("Y-m-d H:i", $siegeStartNotification);
        $readyTime = explode(":", mconfig("cs_period_ready_time"));
        $siegeStartReady = strtotime($siegeStart) + mconfig("cs_period_ready_day") * 86400 + $readyTime[0] * 3600 + $readyTime[1] * 60;
        $periodReady = date("Y-m-d H:i", $siegeStartReady);
        $csstartTime = explode(":", mconfig("cs_period_start_time"));
        $siegeStartCSStart = strtotime($siegeStart) + mconfig("cs_period_start_day") * 86400 + $csstartTime[0] * 3600 + $csstartTime[1] * 60;
        $periodCSStart = date("Y-m-d H:i", $siegeStartCSStart);
        $csendTime = explode(":", mconfig("cs_period_end_time"));
        $siegeStartCSEnd = strtotime($siegeStart) + mconfig("cs_period_end_day") * 86400 + $csendTime[0] * 3600 + $csendTime[1] * 60;
        $periodCSEnd = date("Y-m-d H:i", $siegeStartCSEnd);
        $cycleTime = explode(":", mconfig("cs_period_cycle_time"));
        $siegeStartCycle = strtotime($siegeStart) + mconfig("cs_period_cycle_day") * 86400 + $cycleTime[0] * 3600 + $cycleTime[1] * 60;
        $periodCycle = date("Y-m-d H:i", $siegeStartCycle);
        $now = time();
        echo "<table class=\"irq\" width=\"100%\" style=\"padding-top: 25px;\"><tr>";
        echo "<th colspan=\"2\">" . lang("castlesiege_txt_8", true) . "</th>";
        echo "</tr>";
        if (strtotime($periodRegister) <= $now && $now < strtotime($periodIdle1)) {
            echo "<tr>";
            echo "<th>" . lang("castlesiege_txt_9", true) . "</th>";
            echo "<th><span style=\"color: #009900;\">" . lang("castlesiege_txt_10", true) . " " . date($config["time_date_format"], strtotime($periodIdle1)) . "</span></th>";
            echo "</tr>";
        } else {
            echo "<tr>";
            echo "<td width=\"50%\">" . lang("castlesiege_txt_9", true) . "</td>";
            echo "<td width=\"50%\">" . date($config["time_date_format"], strtotime($periodRegister)) . " - " . date($config["time_date_format"], strtotime($periodIdle1)) . "</td>";
            echo "</tr>";
        }
        if (strtotime($periodIdle1) <= $now && $now < strtotime($periodRegisterMark)) {
            echo "<tr>";
            echo "<th>" . lang("castlesiege_txt_11", true) . "</th>";
            echo "<th><span style=\"color: #009900;\">" . lang("castlesiege_txt_10", true) . " " . date($config["time_date_format"], strtotime($periodRegisterMark)) . "</span></th>";
            echo "</tr>";
        } else {
            echo "<tr>";
            echo "<td width=\"50%\">" . lang("castlesiege_txt_11", true) . "</td>";
            echo "<td width=\"50%\">" . date($config["time_date_format"], strtotime($periodIdle1)) . " - " . date($config["time_date_format"], strtotime($periodRegisterMark)) . "</td>";
            echo "</tr>";
        }
        if (strtotime($periodRegisterMark) <= $now && $now < strtotime($periodIdle2)) {
            echo "<tr>";
            echo "<th>" . lang("castlesiege_txt_12", true) . "</th>";
            echo "<th><span style=\"color: #009900;\">" . lang("castlesiege_txt_10", true) . " " . date($config["time_date_format"], strtotime($periodIdle2)) . "</span></th>";
            echo "</tr>";
        } else {
            echo "<tr>";
            echo "<td width=\"50%\">" . lang("castlesiege_txt_12", true) . "</td>";
            echo "<td width=\"50%\">" . date($config["time_date_format"], strtotime($periodRegisterMark)) . " - " . date($config["time_date_format"], strtotime($periodIdle2)) . "</td>";
            echo "</tr>";
        }
        if (strtotime($periodIdle2) <= $now && $now < strtotime($periodNotification)) {
            echo "<tr>";
            echo "<th>" . lang("castlesiege_txt_11", true) . "</th>";
            echo "<th><span style=\"color: #009900;\">" . lang("castlesiege_txt_10", true) . " " . date($config["time_date_format"], strtotime($periodNotification)) . "</span></th>";
            echo "</tr>";
        } else {
            echo "<tr>";
            echo "<td width=\"50%\">" . lang("castlesiege_txt_11", true) . "</td>";
            echo "<td width=\"50%\">" . date($config["time_date_format"], strtotime($periodIdle2)) . " - " . date($config["time_date_format"], strtotime($periodNotification)) . "</td>";
            echo "</tr>";
        }
        if (strtotime($periodNotification) <= $now && $now < strtotime($periodReady)) {
            echo "<tr>";
            echo "<th>" . lang("castlesiege_txt_13", true) . "</th>";
            echo "<th><span style=\"color: #009900;\">" . lang("castlesiege_txt_10", true) . " " . date($config["time_date_format"], strtotime($periodReady)) . "</span></th>";
            echo "</tr>";
        } else {
            echo "<tr>";
            echo "<td width=\"50%\">" . lang("castlesiege_txt_13", true) . "</td>";
            echo "<td width=\"50%\">" . date($config["time_date_format"], strtotime($periodNotification)) . " - " . date($config["time_date_format"], strtotime($periodReady)) . "</td>";
            echo "</tr>";
        }
        if (strtotime($periodReady) <= $now && $now < strtotime($periodCSStart)) {
            echo "<tr>";
            echo "<th>" . lang("castlesiege_txt_14", true) . "</th>";
            echo "<th><span style=\"color: #009900;\">" . lang("castlesiege_txt_10", true) . " " . date($config["time_date_format"], strtotime($periodCSStart)) . "</span></th>";
            echo "</tr>";
        } else {
            echo "<tr>";
            echo "<td width=\"50%\">" . lang("castlesiege_txt_14", true) . "</td>";
            echo "<td width=\"50%\">" . date($config["time_date_format"], strtotime($periodReady)) . " - " . date($config["time_date_format"], strtotime($periodCSStart)) . "</td>";
            echo "</tr>";
        }
        if (strtotime($periodCSStart) <= $now && $now < strtotime($periodCSEnd)) {
            echo "<tr>";
            echo "<th>" . lang("castlesiege_txt_15", true) . "</th>";
            echo "<th><span style=\"color: #009900;\">" . lang("castlesiege_txt_10", true) . " " . date($config["time_date_format"], strtotime($periodCSEnd)) . "</span></th>";
            echo "</tr>";
        } else {
            echo "<tr>";
            echo "<td width=\"50%\">" . lang("castlesiege_txt_15", true) . "</td>";
            echo "<td width=\"50%\">" . date($config["time_date_format"], strtotime($periodCSStart)) . " - " . date($config["time_date_format"], strtotime($periodCSEnd)) . "</td>";
            echo "</tr>";
        }
        if ($now <= strtotime($periodCycle) && strtotime($periodCSEnd) <= $now) {
            echo "<tr>";
            echo "<th>" . lang("castlesiege_txt_11", true) . "</th>";
            echo "<th><span style=\"color: #009900;\">" . lang("castlesiege_txt_10", true) . " " . date($config["time_date_format"], strtotime($periodCycle)) . "</span></th>";
            echo "</tr>";
        } else {
            echo "<tr>";
            echo "<td width=\"50%\">" . lang("castlesiege_txt_11", true) . "</td>";
            echo "<td width=\"50%\">" . date($config["time_date_format"], strtotime($periodCSEnd)) . " - " . date($config["time_date_format"], strtotime($periodCycle)) . "</td>";
            echo "</tr>";
        }
        echo "</table><table class=\"irq\" width=\"100%\" style=\"padding-top: 25px;\"><tr>";
        echo "<th colspan=\"6\">" . lang("castlesiege_txt_16", true) . "</th>";
        echo "</tr><tr>";
        echo "<th width=\"50%\">" . lang("castlesiege_txt_3", true) . "</th>";
        echo "<th width=\"50%\">" . lang("castlesiege_txt_17", true) . "</th>";
        echo "</tr>";
        $i = 2;
        while ($i < count($castleData)) {
            if (is_array($castleData[$i])) {
                echo "\r\n            <tr>\r\n                <td><a href=\"" . __BASE_URL__ . "profile/guild/req/" . hex_encode($castleData[$i][0]) . "/\" target=\"_blank\">" . $common->replaceHtmlSymbols($castleData[$i][0]) . "</a></td>\r\n                <td>" . $castleData[$i][1] . "</td>\r\n            </tr>";
            }
            $i++;
        }
        echo "</table>";
    } else {
        message("error", lang("error_47", true));
    }
    echo "\r\n    </div>\r\n  </div>\r\n</div>";
}

?>