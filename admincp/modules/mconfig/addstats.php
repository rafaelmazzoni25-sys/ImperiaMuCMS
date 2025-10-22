<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h2>Add Stats Settings</h2>\r\n";
if (check_value($_POST["submit_changes"])) {
    savechanges();
}
loadModuleConfigs("usercp.addstats");
echo "<form action=\"\" method=\"post\">\r\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n        <tr>\r\n            <th>Status<br/><span>Enable/disable the add stats module.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_1", mconfig("active"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Zen Requirement<br/></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_2", mconfig("addstats_enable_zen_requirement"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Zen<br/><span>If zen requirement is enabled, set the price of this feature.</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_3\" value=\"";
echo mconfig("addstats_price_zen");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Max Stats<br/></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_4\" value=\"";
echo mconfig("addstats_max_stats");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Minimum Level-Up Points to Add<br/><span>Minimum amount of level-up points to add in order to use the module.</span>\r\n            </th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_5\"\r\n                       value=\"";
echo mconfig("addstats_minimum_add_points");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan=\"2\"><input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\" class=\"btn btn-success\"/>\r\n            </td>\r\n        </tr>\r\n    </table>\r\n</form>";
function saveChanges()
{
    
    foreach ($_POST as $setting) {
        if (!check_value($setting)) {
            message("error", "Missing data (complete all fields).");
            return NULL;
        }
    }
    $xmlPath = __PATH_MODULE_CONFIGS__ . "usercp.addstats.xml";
    $xml = simplexml_load_file($xmlPath);
    $xml->active = $_POST["setting_1"];
    $xml->addstats_enable_zen_requirement = $_POST["setting_2"];
    $xml->addstats_price_zen = $_POST["setting_3"];
    $xml->addstats_max_stats = $_POST["setting_4"];
    $xml->addstats_minimum_add_points = $_POST["setting_5"];
    $save = $xml->asXML($xmlPath);
    if ($save) {
        message("success", "Settings successfully saved.");
    } else {
        message("error", "There has been an error while saving changes.");
    }
}

?>