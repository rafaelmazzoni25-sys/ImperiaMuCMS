<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h2>Achievements Quests Manager</h2>\r\n";
$General = new xGeneral();
if (check_value($_POST["activate_module"])) {
    $key = $_POST["license_key"];
    $General->jIhfnHDm_activate_KdiupmNBd_Module("achievements", $key);
}
$isActivated = $General->jHdksHgYYix_isModule_hDbMVOIfs_Activated("achievements");
if (check_value($_GET["delete"])) {
    $uid = $_GET["delete"];
    $Achievement = new Achievements();
    $xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "usercp.achievements.quests.xml");
    $achievements = $Achievement->loadXML($xml);
    $found = false;
    $i = 1;
    foreach ($achievements as $thisAch) {
        if ($achievements[$i]["uid"] == $uid) {
            unset($achievements[$i]);
            $found = true;
            $tmp = $Achievement->arrayToXML($achievements);
            file_put_contents(__PATH_MODULE_CONFIGS__ . "usercp.achievements.quests.xml", $tmp);
            if ($found) {
                message("success", "Achievement #" . $uid . " was successfully deleted.");
            } else {
                message("error", "Achievement #" . $uid . " was already deleted or does not exist.");
            }
        } else {
            $i++;
        }
    }
}
if (!$isActivated) {
    echo "\r\n    <form method=\"post\" action=\"\">\r\n        <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n            <tr>\r\n                <th>License Key<br/><span></span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"license_key\" value=\"\" size=\"30\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td colspan=\"2\"><input type=\"submit\" name=\"activate_module\" value=\"Activate Module\" class=\"btn btn-success\"/>\r\n                </td>\r\n            </tr>\r\n        </table>\r\n    </form>";
} else {
    $Achievement = new Achievements();
    $xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "usercp.achievements.quests.xml");
    $achievements = $Achievement->loadXML($xml);
    echo "\r\n    <table width=\"100%\">\r\n      <tr>\r\n        <td><a class=\"btn btn-success\" href=\"" . admincp_base("achievements_add") . "\">ADD NEW ACHIEVEMENT</a></td>\r\n      </tr>\r\n    </table>\r\n  ";
    echo "<table class=\"table table-hover table-striped\"><thead><tr><th>UNIQUE ID</th><th>NAME</th><th>TYPE</th><th>IMAGE</th><th>ACTION</th></tr></thead><tbody>";
    foreach ($achievements as $thisAchievement) {
        echo "<tr>";
        echo "<td>" . $thisAchievement["uid"] . "</td>";
        echo "<td>" . $thisAchievement["name"] . "</td>";
        echo "<td>" . getachievementtype($thisAchievement["type"]) . "</td>";
        echo "<td><img src=\"" . __PATH_TEMPLATE_ASSETS__ . "achievements/" . $thisAchievement["img"] . "\" width=\"24px\" height=\"24px\"></td>";
        echo "<td>";
        echo "<a class=\"btn btn-default btn-sm\" href=\"" . admincp_base("achievements_edit&id=" . $thisAchievement["uid"]) . "\"><i class=\"fa fa-edit\"></i> edit</a> ";
        echo "<a class=\"btn btn-danger btn-sm\" href=\"" . admincp_base("achievements_manager&delete=" . $thisAchievement["uid"]) . "\" onClick=\"if(confirm('Do you really want to delete whole achievement?')) return true; else return false;\"><i class=\"fa fa-trash\"></i> delete</a>";
        echo "</td></tr>";
    }
    echo "</tbody></table>";
}
function getAchievementType($type)
{
    switch ($type) {
        case 0:
            return "Kill Monsters";
            break;
        case 1:
            return "Collect Zen";
            break;
        case 2:
            return "Blood Castle";
            break;
        case 3:
            return "Devil Square";
            break;
        case 4:
            return "Chaos Castle";
            break;
        case 5:
            return "Collect Items";
            break;
        case 6:
            return "Illusion Temple";
            break;
        case 7:
            return "Duels";
            break;
        case 8:
            return "Resets";
            break;
        case 9:
            return "Grand Resets";
            break;
        case 10:
            return "Level";
            break;
        case 11:
            return "Master Level";
            break;
        case 12:
            return "Kill Players";
            break;
        case 13:
            return "Gens";
            break;
        default:
            return "Unknown";
    }
}

?>