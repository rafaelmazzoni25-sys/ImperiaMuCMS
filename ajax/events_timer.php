<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$json = [];
try {
    session_start();
    @ini_set("default_charset", "utf-8");
    $filepath = str_replace("\\", "/", dirname(__FILE__));
    $rootpath = dirname($filepath);
    if (!(include_once "../includes/tables.php")) {
        throw new Exception("Could not load the tables definitions.");
    }
    if (empty($_SERVER["HTTP_HOST"])) {
        $server_host = $_SERVER["SERVER_NAME"];
    } else {
        $server_host = $_SERVER["HTTP_HOST"];
    }
    define("HTTP_HOST", $server_host);
    define("SERVER_PROTOCOL", !empty($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"]) == "on" ? "https://" : "http://");
    define("__ROOT_DIR__", $rootpath . "/");
    define("__RELATIVE_ROOT__", str_ireplace(rtrim(str_replace("\\", "/", realpath(str_replace($_SERVER["SCRIPT_NAME"], "", $_SERVER["SCRIPT_FILENAME"]))), "/"), "", __ROOT_DIR__));
    define("__BASE_URL__", SERVER_PROTOCOL . HTTP_HOST . __RELATIVE_ROOT__);
    define("__PATH_INCLUDES__", __ROOT_DIR__ . "includes/");
    define("__PATH_CLASSES__", __PATH_INCLUDES__ . "classes/");
    define("__PATH_LANGUAGES__", __ROOT_DIR__ . "languages/");
    define("__PATH_CONFIGS__", __PATH_INCLUDES__ . "config/");
    define("__PATH_MODULE_CONFIGS__", __PATH_CONFIGS__ . "modules/");
    define("__PATH_CACHE__", __PATH_INCLUDES__ . "cache/");
    if (!(include_once __PATH_INCLUDES__ . "config.php")) {
        throw new Exception("Could not load the configurations file.");
    }
    if (!(include_once __PATH_CLASSES__ . "class.validator.php")) {
        throw new Exception("Could not load class (validator).");
    }
    if (!(include_once __PATH_INCLUDES__ . "functions/function.config.php")) {
        throw new Exception("Could not load the configurations function file.");
    }
    if (!(include_once __PATH_INCLUDES__ . "functions/function.global.php")) {
        throw new Exception("Could not load the global function file.");
    }
    define("__PATH_TEMPLATE_ROOT__", __ROOT_DIR__ . "templates/" . $config["website_template"] . "/");
    if (!(include_once __PATH_TEMPLATE_ROOT__ . "inc/template.functions.php")) {
        throw new Exception("Could not load template functions");
    }
    date_default_timezone_set($config["timezone_name"]);
    $loadLanguage = isset($_SESSION["language_display"]) ? $_SESSION["language_display"] : $config["language_default"];
    $loadLanguage = config("language_switch_active", true) ? $loadLanguage : $config["language_default"];
    if (!file_exists(__PATH_LANGUAGES__ . $loadLanguage . "/language.php")) {
        throw new Exception("The chosen language cannot be loaded (" . $loadLanguage . ").");
    }
    include __PATH_LANGUAGES__ . $loadLanguage . "/language.php";
    $eventsData = LoadCacheData("events_timer.cache");
    if (is_array($eventsData)) {
        $i = 0;
        $jsonIndex = 0;
        $now = time();
        $currTime = date("Y-m-d H:i:s", $now);
        $nowHour = date("H", $now);
        $nowMin = date("i", $now);
        $currWeekday = date("N", $now);
        foreach ($eventsData as $thisEvent) {
            if (0 < $i) {
                $eventTime = date("Y-m-d H:i:s", $now);
                $nextTime = NULL;
                $weekdays = [];
                list($weekdays[1], $weekdays[2], $weekdays[3], $weekdays[4], $weekdays[5], $weekdays[6], $weekdays[7]) = $thisEvent;
                $weekdaysLang = [];
                $weekdaysLang[1] = lang("monday_short", true);
                $weekdaysLang[2] = lang("tuesday_short", true);
                $weekdaysLang[3] = lang("wednesday_short", true);
                $weekdaysLang[4] = lang("thursday_short", true);
                $weekdaysLang[5] = lang("friday_short", true);
                $weekdaysLang[6] = lang("saturday_short", true);
                $weekdaysLang[7] = lang("sunday_short", true);
                $times = NULL;
                $times = explode(",", $thisEvent[3]);
                if (is_array($times)) {
                    foreach ($times as $thisTime) {
                        $thisTimeArray = explode(":", $thisTime);
                        if (!($thisTimeArray[0] < $nowHour || $nowHour == $thisTimeArray[0] && $thisTimeArray[1] <= $nowMin)) {
                            $nextTime = $thisTime;
                            $eventYear = date("Y", strtotime($eventTime));
                            $eventMonth = date("m", strtotime($eventTime));
                            $eventDay = date("d", strtotime($eventTime));
                            $eventTime = $eventYear . "-" . $eventMonth . "-" . $eventDay . " " . $nextTime . ":00";
                            if ($nextTime == NULL || $nextTime == "") {
                                $nextTime = $times[0];
                                $eventYear = date("Y", strtotime($eventTime));
                                $eventMonth = date("m", strtotime($eventTime));
                                $eventDay = date("d", strtotime($eventTime));
                                $eventTime = $eventYear . "-" . $eventMonth . "-" . $eventDay . " " . $nextTime . ":00";
                                $eventTime = date("Y-m-d H:i:s", strtotime($eventTime . "+1 days"));
                            }
                        }
                    }
                }
                if ($weekdays[$currWeekday] != "1" || $weekdays[$currWeekday] == "1" && $nextTime < date("H:i", $now)) {
                    $secondToAdd = 0;
                    $weekdayIndex = 0;
                    $weekdayCounter = 1;
                    $tmpIndex = 1;
                    while ($tmpIndex < 8) {
                        $weekdayIndex = $currWeekday + $weekdayCounter;
                        $weekdayCounter++;
                        if (7 < $weekdayIndex) {
                            $weekdayIndex = 1;
                            $weekdayCounter = -1 * ($currWeekday - 2);
                        }
                        if ($weekdays[$weekdayIndex] == "0") {
                            $secondToAdd += 86400;
                            $tmpIndex++;
                        } else {
                            $nextTime = $weekdaysLang[$weekdayIndex] . " " . $nextTime;
                        }
                    }
                } else {
                    $secondToAdd = 0;
                }
                $timeLeft = strtotime($eventTime) - strtotime($currTime) + $secondToAdd;
                $isActive = 0;
                if ($thisEvent[1] == "1") {
                    if ($timeLeft <= $thisEvent[2] * 60) {
                        $text = lang("events_timer_txt_2", true);
                        $isActive = 1;
                    } else {
                        $text = lang("events_timer_txt_1", true);
                    }
                } else {
                    if ($thisEvent[1] == "2") {
                        if ($timeLeft <= $thisEvent[2] * 60) {
                            $text = lang("events_timer_txt_3", true);
                            $isActive = 1;
                        } else {
                            $text = lang("events_timer_txt_1", true);
                        }
                    } else {
                        if ($thisEvent[1] == "3") {
                            if ($timeLeft <= $thisEvent[2] * 60) {
                                $text = lang("events_timer_txt_5", true);
                                $isActive = 1;
                            } else {
                                $text = lang("events_timer_txt_4", true);
                            }
                        }
                    }
                }
                $json[$jsonIndex] = ["name" => $thisEvent[0], "nextTime" => $nextTime, "timeLeft" => $timeLeft, "text" => $text, "isActive" => $isActive];
                $jsonIndex++;
            }
            $i++;
        }
    }
} catch (Exception $e) {
    $json["error"] = $e->getMessage();
    echo json_encode($json);
}

?>