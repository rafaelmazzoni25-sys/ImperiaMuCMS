<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h2>Account Balance Settings</h2>\r\n";
if (check_value($_POST["submit_changes"])) {
    savechanges();
}
loadModuleConfigs("usercp.balance");
echo "<form action=\"index.php?module=modules_manager&config=balance\" method=\"post\">\r\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n        <tr>\r\n            <th>Status<br/><span>Enable/disable the account balance module.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_1", mconfig("active"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>WCoinC<br/><span>Enable/disable WCoinC.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_2", mconfig("wcoinc"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>WCoinP<br/><span>Enable/disable WCoinP.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_3", mconfig("wcoinp"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Goblin Points<br/><span>Enable/disable Goblin Points.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_4", mconfig("gp"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan=\"2\"><input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\"\r\n                                   class=\"btn btn-success\"/></td>\r\n        </tr>\r\n    </table>\r\n</form>";
function saveChanges()
{
    
    foreach ($_POST as $setting) {
        if (!check_value($setting)) {
            message("error", "Missing data (complete all fields).");
            return NULL;
        }
    }
    $xmlPath = __PATH_MODULE_CONFIGS__ . "usercp.balance.xml";
    $xml = simplexml_load_file($xmlPath);
    $xml->active = $_POST["setting_1"];
    $xml->wcoinc = $_POST["setting_2"];
    $xml->wcoinp = $_POST["setting_3"];
    $xml->gp = $_POST["setting_4"];
    $save = $xml->asXML($xmlPath);
    if ($save) {
        message("success", "Settings successfully saved.");
    } else {
        message("error", "There has been an error while saving changes.");
    }
}

?>