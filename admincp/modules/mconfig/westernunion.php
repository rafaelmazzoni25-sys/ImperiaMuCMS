<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h1 class=\"page-header\">Western Union Settings</h1>\n";
if (check_value($_POST["submit_changes"])) {
    savechanges();
}
loadModuleConfigs("donation.westernunion");
echo "<form action=\"\" method=\"post\">\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\n        <tr>\n            <th>Status<br/><span>Enable/disable the western union donation gateway.</span></th>\n            <td>\n                ";
enabledisableCheckboxes("setting_1", mconfig("active"), "Enabled", "Disabled");
echo "            </td>\n        </tr>\n        <tr>\n            <th>Name<br/><span></span>\n            </th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"setting_2\" value=\"";
echo mconfig("name");
echo "\"/>\n            </td>\n        </tr>\n        <tr>\n            <th>Address<br/><span></span>\n            </th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"setting_3\" value=\"";
echo mconfig("address");
echo "\"/>\n            </td>\n        </tr>\n        <tr>\n            <th>City / State<br/><span></span>\n            </th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"setting_4\" value=\"";
echo mconfig("city_state");
echo "\"/>\n            </td>\n        </tr>\n        <tr>\n            <th>Country<br/><span></span>\n            </th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"setting_5\" value=\"";
echo mconfig("country");
echo "\"/>\n            </td>\n        </tr>\n        <tr>\n            <th>Email<br/><span></span>\n            </th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"setting_6\" value=\"";
echo mconfig("email");
echo "\"/>\n            </td>\n        </tr>\n        <tr>\n            <td colspan=\"2\"><input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\" class=\"btn btn-success\"/>\n            </td>\n        </tr>\n    </table>\n</form>";
function saveChanges()
{
    
    foreach ($_POST as $setting) {
        if (!check_value($setting)) {
            message("error", "Missing data (complete all fields).");
            return NULL;
        }
    }
    $xmlPath = __PATH_MODULE_CONFIGS__ . "donation.westernunion.xml";
    $xml = simplexml_load_file($xmlPath);
    $xml->active = $_POST["setting_1"];
    $xml->name = $_POST["setting_2"];
    $xml->address = $_POST["setting_3"];
    $xml->city_state = $_POST["setting_4"];
    $xml->country = $_POST["setting_5"];
    $xml->email = $_POST["setting_6"];
    $save4 = $xml->asXML($xmlPath);
    if ($save4) {
        message("success", "[Western Union] Settings successfully saved.");
    } else {
        message("error", "[Western Union] There has been an error while saving changes.");
    }
}

?>