<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */
$General = new xGeneral();
if ($General->ftanHCIfo_canUse_j8GsnawwvJ_Module("icewindvalley") && config("server_files", true) == "IGCN" && defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
    $breadcrumb = generateBreadcrumb();
    echo "\r\n    <h3>\r\n        " . lang("icewindvalley_txt_1", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
    if (mconfig("active")) {
        $valleyData = LoadCacheData("ice_wind_valley.cache");
        $weekdays = [];
        $weekdays[0] = "Sunday";
        $weekdays[1] = "Monday";
        $weekdays[2] = "Tuesday";
        $weekdays[3] = "Wednesday";
        $weekdays[4] = "Thursday";
        $weekdays[5] = "Friday";
        $weekdays[6] = "Saturday";
        $valleyConfigs = loadIceWindValleyConfigs();
        if ($valleyConfigs["Enabled"] == "1") {
            echo "\r\n    <div class=\"table-responsive rankings-table\">\r\n        <table class=\"table table-hover text-center\">\r\n            <thead>\r\n                <tr>\r\n                    <th colspan=\"3\">" . lang("icewindvalley_txt_3", true) . "</th>\r\n                </tr>\r\n            </thead>\r\n            <tbody>";
            if ($valleyData[1][4] == "1") {
                echo "\r\n                <tr>\r\n                    <td rowspan=\"4\" width=\"33%\">" . returnGuildLogo($valleyData[1][2], 100) . "</td>\r\n                </tr>\r\n                <tr>\r\n                    <th width=\"34%\">" . lang("icewindvalley_txt_4", true) . "</th>\r\n                    <td width=\"33%\"><a href=\"" . __BASE_URL__ . "profile/guild/req/" . hex_encode($valleyData[1][0]) . "/\">" . $common->replaceHtmlSymbols($valleyData[1][0]) . "</a></td>\r\n                </tr>\r\n                <tr>\r\n                    <th>" . lang("icewindvalley_txt_5", true) . "</th>\r\n                    <td><a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($valleyData[1][1]) . "/\">" . $common->replaceHtmlSymbols($valleyData[1][1]) . "</a></td>\r\n                </tr>\r\n                <tr>\r\n                    <th>" . lang("icewindvalley_txt_6", true) . "</th>\r\n                    <td>" . date($config["time_date_format"], strtotime($valleyData[1][5])) . "</td>\r\n                </tr>";
            } else {
                echo "\r\n                <tr>\r\n                    <td colspan=\"3\">" . lang("icewindvalley_txt_15", true) . "</td>\r\n                </tr>";
            }
            echo "\r\n            </tbody>\r\n        </table>\r\n    </div>";
            $now = time();
            $currentHour = date("H", $now);
            $currentMinute = date("i", $now);
            $currentWeekday = date("w", $now);
            $eventRegStartHour = $valleyConfigs->StartTime["RegistrationHour"];
            $eventRegStartMinute = $valleyConfigs->StartTime["RegistrationMinute"];
            $eventRegEndHour = $eventRegStartHour + floor($valleyConfigs->StartTime["RegistrationDuration"] / 60);
            $eventRegEndMinute = $eventRegStartMinute + $valleyConfigs->StartTime["RegistrationDuration"] % 60;
            $eventSiegeStartHour = $valleyConfigs->StartTime["Hour"];
            $eventSiegeStartMinute = $valleyConfigs->StartTime["Minute"];
            $eventSiegeEndHour = $eventSiegeStartHour + floor($valleyConfigs->StartTime["Duration"] / 60);
            $eventSiegeEndMinute = $eventSiegeStartMinute + $valleyConfigs->StartTime["Duration"] % 60;
            $regActive = false;
            $siegeActive = false;
            if ($valleyConfigs["ActiveDay"] == "-1") {
                if ($currentHour < $eventRegStartHour || $eventRegStartHour == $currentHour && $currentMinute < $eventRegStartMinute) {
                    $nextRegDate = date("Y-m-d", $now);
                } else {
                    if ($eventRegStartHour <= $currentHour && $currentHour <= $eventRegEndHour && $eventRegStartMinute <= $currentMinute && $currentMinute <= $eventRegEndMinute) {
                        $nextRegDate = date("Y-m-d", $now);
                        $regActive = true;
                    } else {
                        $nextRegDate = date("Y-m-d", $now + 86400);
                    }
                }
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
                    if ($currentHour < $eventRegStartHour || $eventRegStartHour == $currentHour && $currentMinute < $eventRegStartMinute) {
                        $nextRegDate = date("Y-m-d", $now);
                    } else {
                        if ($eventRegStartHour <= $currentHour && $currentHour <= $eventRegEndHour && $eventRegStartMinute <= $currentMinute && $currentMinute <= $eventRegEndMinute) {
                            $nextRegDate = date("Y-m-d", $now);
                            $regActive = true;
                        } else {
                            $nextRegDate = date("Y-m-d", $now + 604800);
                        }
                    }
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
            $nextRegStart = date($config["time_format"], strtotime($nextRegDate . " " . $eventRegStartHour . ":" . $eventRegStartMinute . ":00"));
            $nextRegEnd = date($config["time_format"], strtotime($nextRegDate . " " . $eventRegEndHour . ":" . $eventRegEndMinute . ":00"));
            $nextSiegeStart = date($config["time_format"], strtotime($nextSiegeDate . " " . $eventSiegeStartHour . ":" . $eventSiegeStartMinute . ":00"));
            $nextSiegeEnd = date($config["time_format"], strtotime($nextSiegeDate . " " . $eventSiegeEndHour . ":" . $eventSiegeEndMinute . ":00"));
            $regActiveClass = "";
            $siegeActiveClass = "";
            if ($regActive) {
                $regActiveClass = " class=\"active-period\"";
            }
            if ($siegeActive) {
                $siegeActiveClass = " class=\"active-period\"";
            }
            echo "\r\n    <div class=\"table-responsive rankings-table\">\r\n        <table class=\"table table-hover text-center\">\r\n            <thead>\r\n                <tr>\r\n                    <th colspan=\"2\">" . lang("icewindvalley_txt_7", true) . "</th>\r\n                </tr>\r\n            </thead>\r\n            <tbody>\r\n                <tr>\r\n                    <th>" . lang("icewindvalley_txt_8", true) . "</th>\r\n                    <td" . $regActiveClass . ">" . date($config["date_format"], strtotime($nextRegDate)) . ", " . $nextRegStart . " - " . $nextRegEnd . "</td>\r\n                </tr>\r\n                <tr>\r\n                    <th>" . lang("icewindvalley_txt_9", true) . "</th>\r\n                    <td" . $siegeActiveClass . ">" . date($config["date_format"], strtotime($nextSiegeDate)) . ", " . $nextSiegeStart . " - " . $nextSiegeEnd . "</td>\r\n                </tr>\r\n            </tbody>\r\n        </table>\r\n    </div>";
            if ($valleyConfigs["Type"] == "1") {
                echo "\r\n    <div class=\"table-responsive rankings-table\">\r\n        <table class=\"table table-hover text-center\">\r\n            <thead>\r\n                <tr>\r\n                    <th colspan=\"3\">" . lang("icewindvalley_txt_10", true) . "</th>\r\n                </tr>\r\n            </thead>\r\n            <tbody>\r\n                <tr>\r\n                    <th>" . lang("icewindvalley_txt_4", true) . "</th>\r\n                    <th>" . lang("icewindvalley_txt_11", true) . "</th>\r\n                    <th>" . lang("icewindvalley_txt_5", true) . "</th>\r\n                </tr>";
                $i = 2;
                while ($i < count($valleyData)) {
                    if (is_array($valleyData[$i])) {
                        echo "\r\n                <tr>\r\n                    <td><a href=\"" . __BASE_URL__ . "profile/guild/req/" . hex_encode($valleyData[$i][0]) . "/\" target=\"_blank\">" . $common->replaceHtmlSymbols($valleyData[$i][0]) . "</a></td>\r\n                    <td>" . returnGuildLogo($valleyData[$i][2], 24) . "</td>\r\n                    <td><a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($valleyData[$i][1]) . "/\" target=\"_blank\">" . $common->replaceHtmlSymbols($valleyData[$i][1]) . "</a></td>\r\n                </tr>";
                    }
                    $i++;
                }
                echo "\r\n            </tbody>\r\n        </table>\r\n    </div>\r\n    <div class=\"row desc-row\">\r\n        <div class=\"col-xs-12\">\r\n            " . lang("icewindvalley_txt_12", true) . "\r\n        </div>\r\n    </div>";
            }
            echo "\r\n    <div class=\"table-responsive rankings-table\">\r\n        <table class=\"table table-hover text-center\">\r\n            <thead>\r\n                <tr>\r\n                    <th colspan=\"3\">" . lang("icewindvalley_txt_13", true) . "</th>\r\n                </tr>\r\n            </thead>\r\n            <tbody>\r\n                <tr>\r\n                    <td>" . lang("icewindvalley_txt_14", true) . "</td>\r\n                </tr>\r\n            </tbody>\r\n        </table>\r\n    </div>";
        } else {
            message("error", lang("icewindvalley_txt_2", true));
        }
    } else {
        message("error", lang("error_47", true));
    }
}

?>