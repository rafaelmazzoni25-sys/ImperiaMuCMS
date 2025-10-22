<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h2>IP Board 4 Integration Settings</h2>\r\n";
if (check_value($_POST["submit_changes"])) {
    savechanges();
}
loadModuleConfigs("ipboardapi");
echo "<form action=\"index.php?module=modules_manager&config=ipboardapi\" method=\"post\">\r\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n        <tr>\r\n            <th>Status<br/><span>Enable/disable IP Board integration.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_1", mconfig("active"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>API Key<br/><span>Create an API key and enter it here.<br>Official guide: <a\r\n                            href=\"https://invisionpower.com/4guides/developing-plugins-and-applications/rest-api/creating-an-api-key-r166/\" target=\"_blank\">https://invisionpower.com/4guides/developing-plugins-and-applications/rest-api/creating-an-api-key-r166/</a></span>\r\n            </th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_2\" value=\"";
echo mconfig("api_key");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>URL Rewriting<br/><span>Are you using this feature in your IPB forums? If you are not sure, please check it.<br><a\r\n                            href=\"https://invisionpower.com/4guides/promotion-and-seo/using-a-friendly-url-structure-r54/\" target=\"_blank\">https://invisionpower.com/4guides/promotion-and-seo/using-a-friendly-url-structure-r54/</a> </span>\r\n            </th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_3", mconfig("url_rewrite"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Community URL<br/><span>Enter URL link to your community forums. Link must starts with \"http://\" or \"https://\" and ends with \"/\".<br>Example: <b>http://forum.muonline.com/</b></span>\r\n            </th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_4\" value=\"";
echo mconfig("url");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Create Forum Account on Register<br/><span>Enable/disable creation of forum account during registration.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_5", mconfig("create_account"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Group ID<br/><span>ID of Group where will be new accounts added.</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_6\" value=\"";
echo mconfig("group_id");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan=\"2\"><input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\" class=\"btn btn-success\"/></td>\r\n        </tr>\r\n    </table>\r\n</form>";
function saveChanges()
{
    
    foreach ($_POST as $setting) {
        if (!check_value($setting)) {
            message("error", "Missing data (complete all fields).");
            return NULL;
        }
    }
    $xmlPath = __PATH_MODULE_CONFIGS__ . "ipboardapi.xml";
    $xml = simplexml_load_file($xmlPath);
    $xml->active = $_POST["setting_1"];
    $xml->api_key = $_POST["setting_2"];
    $xml->url_rewrite = $_POST["setting_3"];
    $xml->url = $_POST["setting_4"];
    $xml->create_account = $_POST["setting_5"];
    $xml->group_id = $_POST["setting_6"];
    $save = $xml->asXML($xmlPath);
    if ($save) {
        message("success", "Settings successfully saved.");
    } else {
        message("error", "There has been an error while saving changes.");
    }
}

?>