<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h2>Profiles Settings</h2>\r\n";
if (check_value($_POST["submit_changes"])) {
    savechanges();
}
loadModuleConfigs("profiles");
echo "<form action=\"\" method=\"post\">\r\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n        <tr>\r\n            <th>Status<br/><span>Enable/disable the profile modules.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_1", mconfig("active"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Player - Gens<br/><span>Enable/disable gens info.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_2", mconfig("player_gens"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Player - Account Characters<br/><span>Enable/disable account characters info.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_3", mconfig("player_chars"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Player - Inventory<br/><span>Enable/disable inventory info.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_4", mconfig("player_inv"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Player - Location<br/><span>Enable/disable location info.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_5", mconfig("player_location"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Player - Account Information<br/><span>Enable/disable Account information.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_6", mconfig("player_info"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Player - Stats<br/><span>Enable/disable character stats information.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("player_stats", mconfig("player_stats"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan=\"2\"><input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\" class=\"btn btn-success\"/>\r\n            </td>\r\n        </tr>\r\n    </table>\r\n</form>";
function saveChanges()
{
    
    foreach ($_POST as $setting) {
        if (!check_value($setting)) {
            message("error", "Missing data (complete all fields).");
            return NULL;
        }
    }
    $xmlPath = __PATH_MODULE_CONFIGS__ . "profiles.xml";
    $xml = simplexml_load_file($xmlPath);
    $xml->active = $_POST["setting_1"];
    $xml->player_gens = $_POST["setting_2"];
    $xml->player_chars = $_POST["setting_3"];
    $xml->player_inv = $_POST["setting_4"];
    $xml->player_location = $_POST["setting_5"];
    $xml->player_info = $_POST["setting_6"];
    $xml->player_stats = $_POST["player_stats"];
    $save = $xml->asXML($xmlPath);
    if ($save) {
        message("success", "Settings successfully saved.");
    } else {
        message("error", "There has been an error while saving changes.");
    }
}

?>