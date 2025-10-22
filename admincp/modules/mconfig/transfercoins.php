<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h2>Transfer Coins Settings</h2>\r\n";
if (check_value($_POST["submit_changes"])) {
    savechanges();
}
loadModuleConfigs("usercp.transfercoins");
echo "<form action=\"\" method=\"post\">\r\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n        <tr>\r\n            <th>Status<br/><span>Enable/disable the add stats module.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_1", mconfig("active"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        </tr>\r\n        <tr>\r\n            <th>Tax<br/><span>Tax value in coins.</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_2\" value=\"";
echo mconfig("tax");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Enable Message<br/><span>Enable/disable message for receiver.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("enable_msg", mconfig("enable_msg"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Platinum Coins<br/><span>Enable/disable platinum coins transfer.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_3", mconfig("platinum"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Gold Coins<br/><span>Enable/disable gold coins transfer.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_4", mconfig("gold"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Silver Coins<br/><span>Enable/disable silver coins transfer.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_5", mconfig("silver"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>WCoins<br/><span>Enable/disable WCoins transfer.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_6", mconfig("WCoinC"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Goblin Points<br/><span>Enable/disable Goblin Points transfer.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_7", mconfig("GoblinPoint"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Zen<br/><span>Enable/disable Zen transfer.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_8", mconfig("zen"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan=\"2\"><input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\" class=\"btn btn-success\"/>\r\n            </td>\r\n        </tr>\r\n    </table>\r\n</form>";
function saveChanges()
{
    
    foreach ($_POST as $setting) {
        if (!check_value($setting)) {
            message("error", "Missing data (complete all fields).");
            return NULL;
        }
    }
    $xmlPath = __PATH_MODULE_CONFIGS__ . "usercp.transfercoins.xml";
    $xml = simplexml_load_file($xmlPath);
    $xml->active = $_POST["setting_1"];
    $xml->tax = $_POST["setting_2"];
    $xml->platinum = $_POST["setting_3"];
    $xml->gold = $_POST["setting_4"];
    $xml->silver = $_POST["setting_5"];
    $xml->WCoinC = $_POST["setting_6"];
    $xml->GoblinPoint = $_POST["setting_7"];
    $xml->zen = $_POST["setting_8"];
    $xml->enable_msg = $_POST["enable_msg"];
    $save = $xml->asXML($xmlPath);
    if ($save) {
        message("success", "Settings successfully saved.");
    } else {
        message("error", "There has been an error while saving changes.");
    }
}

?>