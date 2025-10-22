<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h1 class=\"page-header\">Edit Achievement</h1>\r\n";
$uid = $_GET["id"];
$Achievement = new Achievements();
$xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "usercp.achievements.quests.xml");
$achievements = $Achievement->loadXML($xml);
$found = false;
$i = 1;
foreach ($achievements as $thisAch) {
    if ($achievements[$i]["uid"] == $uid) {
        $found = true;
        if ($found) {
            if (check_value($_POST["edit_achievement"])) {
                $totalStages = $_POST["stageCount"];
                $classFilter = [];
                foreach ($custom["character_class"] as $classCode => $thisClass) {
                    if (isset($_POST["class" . $classCode])) {
                        $classFilter[$classCode] = $_POST["class" . $classCode];
                    }
                }
                $class = implode(",", $classFilter);
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
                while ($x <= $totalStages) {
                    $curr_stage = "stage" . $x;
                    if (isset($_POST[$curr_stage . "desc"])) {
                        $stage = NULL;
                        $monsters = NULL;
                        $monsters_count = NULL;
                        $items = NULL;
                        $items_count = NULL;
                        $rew_items = NULL;
                        $rew_items_count = NULL;
                        $stage = [];
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
                message("success", "Achievement was successfully edited.");
            }
            $classFilter = explode(",", $achievements[$i]["class"]);
            echo "\r\n    <script type=\"text/javascript\" src=\"js/achievements.js?v=17\"></script>\r\n\r\n    <form role=\"form\" method=\"post\">\r\n        <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n            <tr>\r\n                <th>Type<br/><span>Achievement Type</span></th>\r\n                <td>\r\n                    <select class=\"form-control\" name=\"type\" id=\"acv_type\">\r\n                        <option value=\"0\" ";
            if ($achievements[$i]["type"] == "0") {
                echo "selected=\"selected\"";
            }
            echo ">Kill\r\n                            Monsters\r\n                        </option>\r\n                        <option value=\"1\" ";
            if ($achievements[$i]["type"] == "1") {
                echo "selected=\"selected\"";
            }
            echo ">\r\n                            Collect Zen\r\n                        </option>\r\n                        <option value=\"2\" ";
            if ($achievements[$i]["type"] == "2") {
                echo "selected=\"selected\"";
            }
            echo ">\r\n                            Blood Castle\r\n                        </option>\r\n                        <option value=\"3\" ";
            if ($achievements[$i]["type"] == "3") {
                echo "selected=\"selected\"";
            }
            echo ">\r\n                            Devil Square\r\n                        </option>\r\n                        <option value=\"4\" ";
            if ($achievements[$i]["type"] == "4") {
                echo "selected=\"selected\"";
            }
            echo ">\r\n                            Chaos Castle\r\n                        </option>\r\n                        <option value=\"5\" ";
            if ($achievements[$i]["type"] == "5") {
                echo "selected=\"selected\"";
            }
            echo ">\r\n                            Collect Items\r\n                        </option>\r\n                        <option value=\"6\" ";
            if ($achievements[$i]["type"] == "6") {
                echo "selected=\"selected\"";
            }
            echo ">\r\n                            Illusion Temple\r\n                        </option>\r\n                        <option value=\"7\" ";
            if ($achievements[$i]["type"] == "7") {
                echo "selected=\"selected\"";
            }
            echo ">\r\n                            Duels\r\n                        </option>\r\n                        <option value=\"8\" ";
            if ($achievements[$i]["type"] == "8") {
                echo "selected=\"selected\"";
            }
            echo ">\r\n                            Resets\r\n                        </option>\r\n                        <option value=\"9\" ";
            if ($achievements[$i]["type"] == "9") {
                echo "selected=\"selected\"";
            }
            echo ">\r\n                            Grand Resets\r\n                        </option>\r\n                        <option value=\"10\" ";
            if ($achievements[$i]["type"] == "10") {
                echo "selected=\"selected\"";
            }
            echo ">\r\n                            Level\r\n                        </option>\r\n                        <option value=\"11\" ";
            if ($achievements[$i]["type"] == "11") {
                echo "selected=\"selected\"";
            }
            echo ">\r\n                            Master Level\r\n                        </option>\r\n                        <option value=\"12\" ";
            if ($achievements[$i]["type"] == "12") {
                echo "selected=\"selected\"";
            }
            echo ">\r\n                            Kill Players\r\n                        </option>\r\n                        <option value=\"13\" ";
            if ($achievements[$i]["type"] == "13") {
                echo "selected=\"selected\"";
            }
            echo ">\r\n                            Gens\r\n                        </option>\r\n                    </select>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Name<br/><span>Achievement Name</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"name\" value=\"";
            echo $achievements[$i]["name"];
            echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Image<br/><span>Image should be placed in /templates/assets/achievements/</span>\r\n                </th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"img\" value=\"";
            echo $achievements[$i]["img"];
            echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Class Filter<br/><span>Check all classes for what will be this achievement available</span></th>\r\n                <td>\r\n                    <table width=\"100%\">\r\n                        ";
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
                echo "<td><input type=\"checkbox\" name=\"class" . $classCode . "\" value=\"" . $classCode . "\" ";
                if (in_array($classCode, $classFilter)) {
                    echo "checked=\"checked\"";
                }
                echo "/> " . $thisClass[0] . "</td>";
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
            echo "                    </table>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Required Level<br/><span>Character must have level >= to see this achievement.</span>\r\n                </th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"req_lvl\" value=\"";
            echo $achievements[$i]["req_lvl"];
            echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Required Master Level<br/><span>Character must have master level >= to see this achievement.</span>\r\n                </th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"req_mlvl\"\r\n                           value=\"";
            echo $achievements[$i]["req_mlvl"];
            echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Required Reset<br/><span>Character must have reset >= to see this achievement.</span>\r\n                </th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"req_reset\"\r\n                           value=\"";
            echo $achievements[$i]["req_reset"];
            echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Required Grand Reset<br/><span>Character must have grand reset >= to see this achievement.</span>\r\n                </th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"req_greset\"\r\n                           value=\"";
            echo $achievements[$i]["req_greset"];
            echo "\"/>\r\n                </td>\r\n            </tr>\r\n        </table>\r\n\r\n        <div id=\"stages\"></div>\r\n        <input type=\"hidden\" name=\"stageCount\" id=\"stageCount\" value=\"";
            echo $achievements[$i]["total_stages"];
            echo "\"/>\r\n        <button id=\"add_stage\" class=\"btn btn-large btn-block btn-primary\" name=\"add_stage\" value=\"\"\r\n                onClick=\"addEmptyStage(); return false;\">Add another Stage\r\n        </button>\r\n        <button type=\"submit\" class=\"btn btn-large btn-block btn-success\" name=\"edit_achievement\" value=\"ok\">Edit\r\n            Achievement\r\n        </button>\r\n    </form>\r\n\r\n    <script type=\"text/javascript\">\r\n        \$(document).ready(function () {\r\n            ";
            $q = 0;
            foreach ($achievements[$i]["stage"] as $stage) {
                echo "var req" . $q . " = [];";
                echo "var rewards" . $q . " = [];";
                switch ($achievements[$i]["type"]) {
                    case 0:
                        echo "req" . $q . "[0] = [];";
                        $m = 0;
                        while ($m < count($stage["monsters_count"])) {
                            echo "req" . $q . "[0][" . $m . "] = {};";
                            echo "req" . $q . "[0][" . $m . "]['monsterId'] = '" . $stage["monsters"][$m + 1] . "';";
                            echo "req" . $q . "[0][" . $m . "]['count'] = '" . $stage["monsters_count"][$m + 1] . "';";
                            $m++;
                        }
                        break;
                    case 1:
                        echo "req" . $q . "[1] = '" . $stage["zen"] . "';";
                        break;
                    case 5:
                        echo "req" . $q . "[5] = [];";
                        $x = 0;
                        while ($x < count($stage["items"])) {
                            $item = explode(",", $stage["items"][$x + 1]);
                            echo "req" . $q . "[5][" . $x . "] = {};";
                            echo "req" . $q . "[5][" . $x . "]['count'] = '" . $stage["items_count"][$x + 1] . "';";
                            echo "req" . $q . "[5][" . $x . "]['category'] = '" . $item[0] . "';";
                            echo "req" . $q . "[5][" . $x . "]['index'] = '" . $item[1] . "';";
                            echo "req" . $q . "[5][" . $x . "]['level'] = '" . $item[2] . "';";
                            echo "req" . $q . "[5][" . $x . "]['skill'] = '" . $item[3] . "';";
                            echo "req" . $q . "[5][" . $x . "]['luck'] = '" . $item[4] . "';";
                            echo "req" . $q . "[5][" . $x . "]['option'] = '" . $item[5] . "';";
                            echo "req" . $q . "[5][" . $x . "]['excellent'] = '" . $item[6] . "';";
                            echo "req" . $q . "[5][" . $x . "]['ancient'] = '" . $item[7] . "';";
                            $x++;
                        }
                        break;
                    default:
                        echo "req" . $q . "[1] = '" . $stage["exp"] . "';";
                        switch ($stage["reward_type"]) {
                            case 7:
                                $x = 0;
                                while ($x < count($stage["rew_items"])) {
                                    $item = explode(",", $stage["rew_items"][$x + 1]);
                                    echo "rewards" . $q . "[" . $x . "] = {};";
                                    echo "rewards" . $q . "[" . $x . "]['count'] = '" . $stage["rew_items_count"][$x + 1] . "';";
                                    echo "rewards" . $q . "[" . $x . "]['category'] = '" . $item[0] . "';";
                                    echo "rewards" . $q . "[" . $x . "]['index'] = '" . $item[1] . "';";
                                    echo "rewards" . $q . "[" . $x . "]['level'] = '" . $item[2] . "';";
                                    echo "rewards" . $q . "[" . $x . "]['skill'] = '" . $item[3] . "';";
                                    echo "rewards" . $q . "[" . $x . "]['luck'] = '" . $item[4] . "';";
                                    echo "rewards" . $q . "[" . $x . "]['option'] = '" . $item[5] . "';";
                                    echo "rewards" . $q . "[" . $x . "]['excellent'] = '" . $item[6] . "';";
                                    echo "rewards" . $q . "[" . $x . "]['ancient'] = '" . $item[7] . "';";
                                    $x++;
                                }
                                break;
                            default:
                                echo "rewards" . $q . "[1] = {};";
                                echo "rewards" . $q . "[1]['points'] = '" . $stage["reward"] . "';";
                                echo "addStage('" . $stage["desc"] . "', req" . $q . ", '" . $stage["reward_type"] . "', rewards" . $q . ", '" . $stage["points"] . "');";
                                $q++;
                        }
                }
            }
            echo "            InitAchievemetsForm();\r\n        });\r\n    </script>\r\n\r\n    ";
        } else {
            message("error", "Requested achievement does not exist.");
        }
    } else {
        $i++;
    }
}

?>