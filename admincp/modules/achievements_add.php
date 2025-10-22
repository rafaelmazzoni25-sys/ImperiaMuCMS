<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h1 class=\"page-header\">Add New Achievement</h1>\r\n";
if (check_value($_POST["add_achievement"])) {
    $Achievement = new Achievements();
    $xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "usercp.achievements.quests.xml");
    $achievements = $Achievement->loadXMLforArray($xml);
    $totalAchievements = totalachievements($achievements);
    $i = $totalAchievements + 1;
    $uid = generateuid($achievements);
    $totalStages = $_POST["stageCount"];
    $classFilter = [];
    foreach ($custom["character_class"] as $classCode => $thisClass) {
        if (isset($_POST["class" . $classCode])) {
            $classFilter[$classCode] = $_POST["class" . $classCode];
        }
    }
    $class = implode(",", $classFilter);
    $achievements[$i]["uid"] = $uid;
    $achievements[$i]["type"] = $_POST["type"];
    $achievements[$i]["name"] = $_POST["name"];
    $achievements[$i]["img"] = $_POST["img"];
    $achievements[$i]["class"] = $class;
    $achievements[$i]["req_lvl"] = $_POST["req_lvl"];
    $achievements[$i]["req_mlvl"] = $_POST["req_mlvl"];
    $achievements[$i]["req_reset"] = $_POST["req_reset"];
    $achievements[$i]["req_greset"] = $_POST["req_greset"];
    $achievements[$i]["stage"] = [];
    $x = 1;
    while ($x <= $_POST["stageCount"]) {
        $stage = NULL;
        $monsters = NULL;
        $monsters_count = NULL;
        $items = NULL;
        $items_count = NULL;
        $rew_items = NULL;
        $rew_items_count = NULL;
        $stage = [];
        $curr_stage = "stage" . $x;
        if (isset($_POST[$curr_stage . "desc"])) {
            $stage["desc"] = $_POST[$curr_stage . "desc"];
            if ($_POST["type"] == "0") {
                $monsters = [];
                $monsters_count = [];
                $k = 1;
                foreach ($_POST[$curr_stage . "req0monster_id"] as $monster) {
                    $monsters[$k] = $_POST[$curr_stage . "req0monster_id"][$k];
                    $monsters_count[$k] = intval($_POST[$curr_stage . "req0monster_count"][$k]);
                    $k++;
                }
            } else {
                if ($_POST["type"] == "1") {
                    $stage["zen"] = $_POST[$curr_stage . "req1"];
                } else {
                    if ($_POST["type"] == "2" || $_POST["type"] == "3" || $_POST["type"] == "4" || $_POST["type"] == "6" || $_POST["type"] == "7" || $_POST["type"] == "8" || $_POST["type"] == "9" || $_POST["type"] == "10" || $_POST["type"] == "11" || $_POST["type"] == "12" || $_POST["type"] == "13") {
                        $stage["exp"] = $_POST[$curr_stage . "req1"];
                    } else {
                        if ($_POST["type"] == "5") {
                            $items = [];
                            $items_count = [];
                            $k = 1;
                            foreach ($_POST[$curr_stage . "req5item_category"] as $item) {
                                $items_tmp = [];
                                if (isset($_POST[$curr_stage . "req5item_category"][$k])) {
                                    $items_tmp[0] = intval($_POST[$curr_stage . "req5item_category"][$k]);
                                }
                                if (isset($_POST[$curr_stage . "req5item_index"][$k])) {
                                    $items_tmp[1] = intval($_POST[$curr_stage . "req5item_index"][$k]);
                                }
                                if (isset($_POST[$curr_stage . "req5item_level"][$k])) {
                                    $items_tmp[2] = intval($_POST[$curr_stage . "req5item_level"][$k]);
                                }
                                if (isset($_POST[$curr_stage . "req5item_skill"][$k])) {
                                    $items_tmp[3] = intval($_POST[$curr_stage . "req5item_skill"][$k]);
                                }
                                if (isset($_POST[$curr_stage . "req5item_luck"][$k])) {
                                    $items_tmp[4] = intval($_POST[$curr_stage . "req5item_luck"][$k]);
                                }
                                if (isset($_POST[$curr_stage . "req5item_option"][$k])) {
                                    $items_tmp[5] = intval($_POST[$curr_stage . "req5item_option"][$k]);
                                }
                                if (isset($_POST[$curr_stage . "req5item_excellent"][$k])) {
                                    $items_tmp[6] = intval($_POST[$curr_stage . "req5item_excellent"][$k]);
                                }
                                if (isset($_POST[$curr_stage . "req5item_ancient"][$k])) {
                                    $items_tmp[7] = intval($_POST[$curr_stage . "req5item_ancient"][$k]);
                                }
                                $item = implode(",", $items_tmp);
                                $items[$k] = $item;
                                $items_count[$k] = intval($_POST[$curr_stage . "req5item_count"][$k]);
                                $k++;
                            }
                        }
                    }
                }
            }
            $stage["reward_type"] = $_POST[$curr_stage . "rewardType"];
            if ($stage["reward_type"] == "7") {
                $rew_items = [];
                $rew_items_count = [];
                $m = 1;
                foreach ($_POST[$curr_stage . "reward7item_category"] as $item) {
                    $items_tmp = [];
                    if (isset($_POST[$curr_stage . "reward7item_category"][$m])) {
                        $items_tmp[0] = intval($_POST[$curr_stage . "reward7item_category"][$m]);
                    }
                    if (isset($_POST[$curr_stage . "reward7item_index"][$m])) {
                        $items_tmp[1] = intval($_POST[$curr_stage . "reward7item_index"][$m]);
                    }
                    if (isset($_POST[$curr_stage . "reward7item_level"][$m])) {
                        $items_tmp[2] = intval($_POST[$curr_stage . "reward7item_level"][$m]);
                    }
                    if (isset($_POST[$curr_stage . "reward7item_skill"][$m])) {
                        $items_tmp[3] = intval($_POST[$curr_stage . "reward7item_skill"][$m]);
                    }
                    if (isset($_POST[$curr_stage . "reward7item_luck"][$m])) {
                        $items_tmp[4] = intval($_POST[$curr_stage . "reward7item_luck"][$m]);
                    }
                    if (isset($_POST[$curr_stage . "reward7item_option"][$m])) {
                        $items_tmp[5] = intval($_POST[$curr_stage . "reward7item_option"][$m]);
                    }
                    if (isset($_POST[$curr_stage . "reward7item_excellent"][$m])) {
                        $items_tmp[6] = intval($_POST[$curr_stage . "reward7item_excellent"][$m]);
                    }
                    if (isset($_POST[$curr_stage . "reward7item_ancient"][$m])) {
                        $items_tmp[7] = intval($_POST[$curr_stage . "reward7item_ancient"][$m]);
                    }
                    $item = implode(",", $items_tmp);
                    $rew_items[$m] = $item;
                    $rew_items_count[$m] = intval($_POST[$curr_stage . "reward7item_count"][$m]);
                    $m++;
                }
            } else {
                $stage["reward"] = $_POST[$curr_stage . "reward1"];
            }
            $stage["points"] = $_POST[$curr_stage . "points"];
            $achievements[$i]["stage"][$x] = $stage;
            $achievements[$i]["stage"][$x]["monsters"] = $monsters;
            $achievements[$i]["stage"][$x]["monsters_count"] = $monsters_count;
            $achievements[$i]["stage"][$x]["items"] = $items;
            $achievements[$i]["stage"][$x]["items_count"] = $items_count;
            $achievements[$i]["stage"][$x]["rew_items"] = $rew_items;
            $achievements[$i]["stage"][$x]["rew_items_count"] = $rew_items_count;
        } else {
            $totalStages--;
        }
        $achievements[$i]["total_stages"] = $totalStages;
        $x++;
    }
    $tmp = $Achievement->arrayToXML($achievements);
    file_put_contents(__PATH_MODULE_CONFIGS__ . "usercp.achievements.quests.xml", $tmp);
    message("success", "Achievement was successfully created.");
}
echo "\r\n<script type=\"text/javascript\" src=\"js/achievements.js?v=13\"></script>\r\n\r\n<form role=\"form\" method=\"post\" class=\"form-inline\">\r\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n        <tr>\r\n            <th>Type<br/><span>Achievement Type</span></th>\r\n            <td>\r\n                <select class=\"form-control\" name=\"type\" id=\"acv_type\">\r\n                    <option value=\"0\">Kill Monsters</option>\r\n                    <option value=\"1\">Collect Zen</option>\r\n                    <option value=\"2\">Blood Castle</option>\r\n                    <option value=\"3\">Devil Square</option>\r\n                    <option value=\"4\">Chaos Castle</option>\r\n                    <option value=\"5\">Collect Items</option>\r\n                    <option value=\"6\">Illusion Temple</option>\r\n                    <option value=\"7\">Duels</option>\r\n                    <option value=\"8\">Resets</option>\r\n                    <option value=\"9\">Grand Resets</option>\r\n                    <option value=\"10\">Level</option>\r\n                    <option value=\"11\">Master Level</option>\r\n                    <option value=\"12\">Kill Players</option>\r\n                    <option value=\"13\">Gens</option>\r\n                </select>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Name<br/><span>Achievement Name</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"name\" value=\"\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Image<br/><span>Image should be placed in /templates/assets/achievements/</span>\r\n            </th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"img\" value=\"1.png\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Class Filter<br/><span>Check all classes for what will be this achievement available</span></th>\r\n            <td>\r\n                <table width=\"100%\">\r\n                    ";
$itemsPerLine = 3;
$currentLine = 0;
$counter = 0;
if (122 <= config("server_files_season", true)) {
    $itemsPerLine = 4;
}
foreach ($custom["character_class"] as $classCode => $thisClass) {
    if ($counter == 0) {
        echo "<tr>";
    }
    echo "<td><input type=\"checkbox\" name=\"class" . $classCode . "\" value=\"" . $classCode . "\" checked=\"checked\"/> " . $thisClass[0] . "</td>";
    if ($currentLine == 3 || $currentLine == 4 || $currentLine == 6 || $currentLine == 7) {
        if ($counter == $itemsPerLine - 2) {
            echo "</tr>";
            $counter = 0;
            $currentLine++;
        }
    } else {
        if ($counter == $itemsPerLine - 1) {
            echo "</tr>";
            $counter = 0;
            $currentLine++;
        }
    }
    $counter++;
}
echo "                </table>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Required Level<br/><span>Character must have level >= to see this achievement.</span>\r\n            </th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"req_lvl\" value=\"0\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Required Master Level<br/><span>Character must have master level >= to see this achievement.</span>\r\n            </th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"req_mlvl\" value=\"0\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Required Reset<br/><span>Character must have reset >= to see this achievement.</span>\r\n            </th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"req_reset\" value=\"0\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Required Grand Reset<br/><span>Character must have grand reset >= to see this achievement.</span>\r\n            </th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"req_greset\" value=\"0\"/>\r\n            </td>\r\n        </tr>\r\n    </table>\r\n\r\n    <div id=\"stages\"></div>\r\n    <input type=\"hidden\" name=\"stageCount\" id=\"stageCount\" value=\"0\"/>\r\n    <button id=\"add_stage\" class=\"btn btn-large btn-block btn-primary\" name=\"add_stage\" value=\"\"\r\n            onClick=\"addEmptyStage(); return false;\">Add another Stage\r\n    </button>\r\n    <button type=\"submit\" class=\"btn btn-large btn-block btn-success\" name=\"add_achievement\" value=\"ok\">Add\r\n        Achievement\r\n    </button>\r\n</form>\r\n\r\n<script type=\"text/javascript\">\r\n    \$(document).ready(function () {\r\n        InitAchievemetsForm();\r\n    });\r\n</script>";
function generateUID($achievements)
{
    $uid = 999;
    foreach ($achievements as $thisAchievement) {
        if ($uid < $thisAchievement["uid"]) {
            $uid = $thisAchievement["uid"];
        }
    }
    $uid = $uid + 1;
    return $uid;
}
function totalAchievements($achievements)
{
    $i = 0;
    foreach ($achievements as $thisAchievement) {
        $i++;
    }
    return $i;
}

?>