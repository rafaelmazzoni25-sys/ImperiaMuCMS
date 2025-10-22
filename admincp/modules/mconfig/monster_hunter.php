<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "\r\n<h2>Monster Hunter Settings</h2>";
if (check_value($_POST["save_monsters"])) {
    $xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "monster_hunter.xml");
    if ($xml !== false) {
        $array = [];
        $i = 1;
        foreach ($xml->children() as $tag => $monster) {
            $array[$i]["id"] = intval($monster["id"]);
            if ($array[$i]["id"] == "-1") {
                $monsterId = "all";
            } else {
                $monsterId = $array[$i]["id"];
            }
            $array[$i]["general"] = intval($_POST["monster_" . $monsterId . "_general"]);
            $array[$i]["monthly"] = intval($_POST["monster_" . $monsterId . "_monthly"]);
            $array[$i]["weekly"] = intval($_POST["monster_" . $monsterId . "_weekly"]);
            $array[$i]["daily"] = intval($_POST["monster_" . $monsterId . "_daily"]);
            $array[$i]["monthly_reward"] = intval($_POST["reward_monster_" . $monsterId . "_monthly"]);
            $array[$i]["weekly_reward"] = intval($_POST["reward_monster_" . $monsterId . "_weekly"]);
            $array[$i]["daily_reward"] = intval($_POST["reward_monster_" . $monsterId . "_daily"]);
            $i++;
        }
        $tmp = arraytoxml($array);
        file_put_contents(__PATH_MODULE_CONFIGS__ . "monster_hunter.xml", $tmp);
        message("success", "Changes were saved successfully.");
    }
}
if (check_value($_POST["add_monster"])) {
    $xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "monster_hunter.xml");
    if ($xml !== false) {
        $array = [];
        $i = 1;
        foreach ($xml->children() as $tag => $monster) {
            $array[$i]["id"] = intval($monster["id"]);
            $array[$i]["general"] = intval($monster["general"]);
            $array[$i]["monthly"] = intval($monster["monthly"]);
            $array[$i]["weekly"] = intval($monster["weekly"]);
            $array[$i]["daily"] = intval($monster["daily"]);
            $array[$i]["monthly_reward"] = intval($monster["monthly_reward"]);
            $array[$i]["weekly_reward"] = intval($monster["weekly_reward"]);
            $array[$i]["daily_reward"] = intval($monster["daily_reward"]);
            $i++;
        }
        $array[$i]["id"] = intval($_POST["monsterId"]);
        $array[$i]["general"] = intval($_POST["general"]);
        $array[$i]["monthly"] = intval($_POST["monthly"]);
        $array[$i]["weekly"] = intval($_POST["weekly"]);
        $array[$i]["daily"] = intval($_POST["daily"]);
        $array[$i]["monthly_reward"] = intval($_POST["monthly_reward"]);
        $array[$i]["weekly_reward"] = intval($_POST["weekly_reward"]);
        $array[$i]["daily_reward"] = intval($_POST["daily_reward"]);
        $tmp = arraytoxml($array);
        file_put_contents(__PATH_MODULE_CONFIGS__ . "monster_hunter.xml", $tmp);
        message("success", "Changes were saved successfully.");
    }
}
if (check_value($_GET["delete"]) && is_numeric($_GET["delete"]) && 0 <= $_GET["delete"]) {
    $xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "monster_hunter.xml");
    if ($xml !== false) {
        $array = [];
        $found = false;
        $i = 1;
        foreach ($xml->children() as $tag => $monster) {
            if (intval($monster["id"]) != $_GET["delete"]) {
                $array[$i]["id"] = intval($monster["id"]);
                $array[$i]["general"] = intval($monster["general"]);
                $array[$i]["monthly"] = intval($monster["monthly"]);
                $array[$i]["weekly"] = intval($monster["weekly"]);
                $array[$i]["daily"] = intval($monster["daily"]);
                $array[$i]["monthly_reward"] = intval($monster["monthly_reward"]);
                $array[$i]["weekly_reward"] = intval($monster["weekly_reward"]);
                $array[$i]["daily_reward"] = intval($monster["daily_reward"]);
                $i++;
            } else {
                $found = true;
            }
        }
        $tmp = arraytoxml($array);
        file_put_contents(__PATH_MODULE_CONFIGS__ . "monster_hunter.xml", $tmp);
    }
    if ($found) {
        message("success", "Monster #" . intval($_GET["delete"]) . " was successfully deleted.");
    }
}
loadModuleConfigs("monster_hunter");
$monsterList = monsterList();
echo "\r\n<form action=\"\" method=\"post\">\r\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">";
foreach (mconfig("Monster") as $thisMonster) {
    $monsterId = $thisMonster["@attributes"]["id"];
    if ($monsterId == "-1") {
        $monsterId = "all";
    }
    echo "\r\n        <tr>\r\n            <th>" . $monsterList["monster_" . $monsterId] . "<br/><span></span></th>\r\n            <td>\r\n                <table width=\"100%\">\r\n                    <tr>\r\n                        <td>General:</td>\r\n                        <td>";
    enabledisableCheckboxes("monster_" . $monsterId . "_general", $thisMonster["@attributes"]["general"], "Enabled", "Disabled");
    echo "\r\n                        </td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Monthly:</td>\r\n                        <td>";
    enabledisableCheckboxes("monster_" . $monsterId . "_monthly", $thisMonster["@attributes"]["monthly"], "Enabled", "Disabled");
    echo "\r\n                        </td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Weekly:</td>\r\n                        <td>";
    enabledisableCheckboxes("monster_" . $monsterId . "_weekly", $thisMonster["@attributes"]["weekly"], "Enabled", "Disabled");
    echo "\r\n                        </td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Daily:</td>\r\n                        <td>";
    enabledisableCheckboxes("monster_" . $monsterId . "_daily", $thisMonster["@attributes"]["daily"], "Enabled", "Disabled");
    echo "\r\n                        </td>\r\n                    </tr>\r\n                </table>\r\n            </td>\r\n            <td>\r\n                <table width=\"100%\">\r\n                    <tr>\r\n                        <td>Monthly Rewards:</td>\r\n                        <td>";
    enabledisableCheckboxes("reward_monster_" . $monsterId . "_monthly", $thisMonster["@attributes"]["monthly_reward"], "Enabled", "Disabled");
    echo "\r\n                        </td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Weekly Rewards:</td>\r\n                        <td>";
    enabledisableCheckboxes("reward_monster_" . $monsterId . "_weekly", $thisMonster["@attributes"]["weekly_reward"], "Enabled", "Disabled");
    echo "\r\n                        </td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Daily Rewards:</td>\r\n                        <td>";
    enabledisableCheckboxes("reward_monster_" . $monsterId . "_daily", $thisMonster["@attributes"]["daily_reward"], "Enabled", "Disabled");
    echo "\r\n                        </td>\r\n                    </tr>\r\n                </table>\r\n            </td>\r\n            <td>";
    if ($thisMonster["@attributes"]["id"] != "-1") {
        echo "\r\n                <a href=\"" . admincp_base("modules_manager&config=monster_hunter") . "&delete=" . $monsterId . "\" class=\"btn btn-danger\" \r\n                    onclick=\"if(confirm('Do you really want to delete " . $monsterList["monster_" . $monsterId] . "?')) return true; else return false;\">\r\n                    Delete\r\n                </a>";
    }
    echo "\r\n            </td>\r\n        </tr>";
}
echo "\r\n        <tr>\r\n            <td colspan=\"4\"><input type=\"submit\" name=\"save_monsters\" value=\"Save\" class=\"btn btn-success\" style=\"width: 100%;\"/></td>\r\n        </tr>     \r\n    </table>\r\n</form>";
$totalMonsters = 1200;
$monsters = "";
$monsterCounter = 0;
while ($monsterCounter <= $totalMonsters) {
    if ($monsterList["monster_" . $monsterCounter] != NULL) {
        $monsters .= "<option value=\"" . $monsterCounter . "\">" . $monsterCounter . " - " . $monsterList["monster_" . $monsterCounter] . "</option>";
    }
    $monsterCounter++;
}
echo "\r\n<hr><h3>Add New Monster Hunter Ranking</h3>\r\n<form action=\"\" method=\"post\">\r\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n        <tr>\r\n            <th>Monster<br/><span>Select monster from the list. If you don't see any values in the list, please check if you have \"monster_0\" - \"monster_X\" strings in your language file.</span></th>\r\n            <td>\r\n                <select name=\"monsterId\" class=\"form-control\">\r\n                    " . $monsters . "\r\n                </select>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>General Rankings</th>\r\n            <td>";
enabledisableCheckboxes("general", 0, "Enabled", "Disabled");
echo "                \r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Monthly Rankings</th>\r\n            <td>";
enabledisableCheckboxes("monthly", 0, "Enabled", "Disabled");
echo "                \r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Weekly Rankings</th>\r\n            <td>";
enabledisableCheckboxes("weekly", 0, "Enabled", "Disabled");
echo "                \r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Daily Rankings</th>\r\n            <td>";
enabledisableCheckboxes("daily", 0, "Enabled", "Disabled");
echo "                \r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Monthly Rewards</th>\r\n            <td>";
enabledisableCheckboxes("monthly_reward", 0, "Enabled", "Disabled");
echo "                \r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Weekly Rewards</th>\r\n            <td>";
enabledisableCheckboxes("weekly_reward", 0, "Enabled", "Disabled");
echo "                \r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Daily Rewards</th>\r\n            <td>";
enabledisableCheckboxes("daily_reward", 0, "Enabled", "Disabled");
echo "                \r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan=\"2\"><input type=\"submit\" name=\"add_monster\" value=\"Add Monster Hunter\" class=\"btn btn-success\" style=\"width: 100%;\"/></td>\r\n        </tr> \r\n    </table>\r\n</form>";
function arrayToXML($array)
{
    global $custom;
    $sxe = new SimpleXMLElement("<MonsterHunter/>");
    if (is_array($array)) {
        foreach ($array as $thisMonster) {
            $monster = $sxe->addChild("Monster");
            $monster->addAttribute("id", $thisMonster["id"]);
            $monster->addAttribute("general", $thisMonster["general"]);
            $monster->addAttribute("monthly", $thisMonster["monthly"]);
            $monster->addAttribute("weekly", $thisMonster["weekly"]);
            $monster->addAttribute("daily", $thisMonster["daily"]);
            $monster->addAttribute("monthly_reward", $thisMonster["monthly_reward"]);
            $monster->addAttribute("weekly_reward", $thisMonster["weekly_reward"]);
            $monster->addAttribute("daily_reward", $thisMonster["daily_reward"]);
        }
    }
    return $sxe->asXML();
}

?>