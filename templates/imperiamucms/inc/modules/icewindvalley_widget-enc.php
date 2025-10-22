<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */
$General = new xGeneral();
if ($General->ftanHCIfo_canUse_j8GsnawwvJ_Module("icewindvalley") && config("server_files", true) == "IGCN") {
    $moduleConfigs = loadConfigurations("icewindvalley");
    $valleyConfigs = loadIceWindValleyConfigs();
    $valleyData = LoadCacheData("ice_wind_valley.cache");
    if ($moduleConfigs["active"] && $valleyConfigs["Enabled"] == "1") {
        $weekdays = [];
        $weekdays[0] = "Sunday";
        $weekdays[1] = "Monday";
        $weekdays[2] = "Tuesday";
        $weekdays[3] = "Wednesday";
        $weekdays[4] = "Thursday";
        $weekdays[5] = "Friday";
        $weekdays[6] = "Saturday";
        $now = time();
        $currentHour = date("H", $now);
        $currentMinute = date("i", $now);
        $currentWeekday = date("w", $now);
        $eventSiegeStartHour = $valleyConfigs->StartTime["Hour"];
        $eventSiegeStartMinute = $valleyConfigs->StartTime["Minute"];
        $eventSiegeEndHour = $eventSiegeStartHour + floor($valleyConfigs->StartTime["Duration"] / 60);
        $eventSiegeEndMinute = $eventSiegeStartMinute + $valleyConfigs->StartTime["Duration"] % 60;
        if ($valleyConfigs["ActiveDay"] == "-1") {
            if ($currentHour < $eventSiegeStartHour || $eventSiegeStartHour == $currentHour && $currentMinute < $eventSiegeStartMinute) {
                $nextSiegeDate = date("Y-m-d", $now);
            } else {
                if ($eventSiegeStartHour <= $currentHour && $currentHour <= $eventSiegeEndHour && $eventSiegeStartMinute <= $currentMinute && $currentMinute <= $eventSiegeEndMinute) {
                    $nextSiegeDate = date("Y-m-d", $now);
                    $siegeActive = true;
                } else {
                    $nextSiegeDate = date("Y-m-d", $now + 86400);
                }
            }
        } else {
            if ($currentWeekday == $valleyConfigs["ActiveDay"]) {
                if ($currentHour < $eventSiegeStartHour || $eventSiegeStartHour == $currentHour && $currentMinute < $eventSiegeStartMinute) {
                    $nextSiegeDate = date("Y-m-d", $now);
                } else {
                    if ($eventSiegeStartHour <= $currentHour && $currentHour <= $eventSiegeEndHour && $eventSiegeStartMinute <= $currentMinute && $currentMinute <= $eventSiegeEndMinute) {
                        $nextSiegeDate = date("Y-m-d", $now);
                        $siegeActive = true;
                    } else {
                        $nextSiegeDate = date("Y-m-d", $now + 604800);
                    }
                }
            } else {
                $nextRegDate = date("Y-m-d", strtotime("next " . $weekdays[intval($valleyConfigs["ActiveDay"])]));
                $nextSiegeDate = date("Y-m-d", strtotime("next " . $weekdays[intval($valleyConfigs["ActiveDay"])]));
            }
        }
        $nextSiegeStart = strtotime($nextSiegeDate . " " . $eventSiegeStartHour . ":" . $eventSiegeStartMinute . ":00");
        $nextSiegeEnd = strtotime($nextSiegeDate . " " . $eventSiegeEndHour . ":" . $eventSiegeEndMinute . ":00");
        echo "\r\n        <div class=\"panel panel-default server-info-home-panel\">\r\n            <div class=\"panel-heading\">\r\n                <h3 class=\"panel-title\">" . lang("icewindvalley_txt_1", true) . "\r\n                    <a href=\"" . __BASE_URL__ . "icewindvalley\" class=\"btn-simple btn-icon-plus pull-right\"></a>\r\n                </h3>\r\n            </div>\r\n            <div class=\"panel-body\">\r\n                <div class=\"row\">\r\n                    <div class=\"col-xs-3\">\r\n                        " . returnGuildLogo($valleyData[1][2], 48) . "\r\n                    </div>\r\n                    <div class=\"col-xs-9\">\r\n                        <table width=\"100%\">\r\n                            <tr>\r\n                                <td>" . lang("icewindvalley_txt_4", true) . ":</td>\r\n                                <td align=\"right\"><b>" . $common->replaceHtmlSymbols($valleyData[1][0]) . "</b></td>\r\n                            </tr>\r\n                            <tr>\r\n                                <td>" . lang("icewindvalley_txt_5", true) . ":</td>\r\n                                <td align=\"right\"><b>" . $common->replaceHtmlSymbols($valleyData[1][1]) . "</b></td>\r\n                            </tr>\r\n                        </table>\r\n                    </div>\r\n                </div>\r\n            </div>\r\n            <hr class=\"tiny\">\r\n            <div class=\"row\">\r\n                <div class=\"col-xs-12\" style=\"text-align: center; font-size: 1.2em;\">\r\n                    " . lang("icewindvalley_txt_9", true) . " " . date($config["time_date_format"], $nextSiegeStart) . "\r\n                </div>\r\n            </div>\r\n        </div>";
    }
}

?>