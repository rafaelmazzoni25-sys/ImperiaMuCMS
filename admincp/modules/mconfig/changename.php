<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h2>Change Name Settings</h2>\r\n";
if (check_value($_POST["submit_changes"])) {
    savechanges();
}
loadModuleConfigs("usercp.changename");
$creditSystem = new CreditSystem($common, new Character(), $dB, $dB2);
echo "<form action=\"\" method=\"post\">\r\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n        <tr>\r\n            <th>Status<br/><span>Enable/disable the character reset module.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_1", mconfig("active"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Price<br/><span></span>\r\n            </th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_2\" value=\"";
echo mconfig("price");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Credit Configuration<br/><span></span></th>\r\n            <td>\r\n                ";
echo $creditSystem->buildSelectInput("setting_3", mconfig("credit_config"), "form-control");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Allow Special\r\n                Characters<br/><span>If \"Enabled\", allowed characters are a-z A-Z 0-9 _ ! ~ ^ @ # \$ ? [ ] ( ) { } = - + * / \\ |<br>If \"Disabled\", allowed characters are a-z A-Z 0-9</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_4", mconfig("allow_special_chars"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Disable Regex<br/><span>If regex is disabled, character name can contains any symbols.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("disable_regex", mconfig("disable_regex"), "Yes", "No");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan=\"2\"><input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\" class=\"btn btn-success\"/>\r\n            </td>\r\n        </tr>\r\n    </table>\r\n</form>";
function saveChanges()
{
    
    foreach ($_POST as $setting) {
        if (!check_value($setting)) {
            message("error", "Missing data (complete all fields).");
            return NULL;
        }
    }
    $xmlPath = __PATH_MODULE_CONFIGS__ . "usercp.changename.xml";
    $xml = simplexml_load_file($xmlPath);
    $xml->active = $_POST["setting_1"];
    $xml->price = $_POST["setting_2"];
    $xml->credit_config = $_POST["setting_3"];
    $xml->allow_special_chars = $_POST["setting_4"];
    $xml->disable_regex = $_POST["disable_regex"];
    $save = $xml->asXML($xmlPath);
    if ($save) {
        message("success", "Settings successfully saved.");
    } else {
        message("error", "There has been an error while saving changes.");
    }
}

?>