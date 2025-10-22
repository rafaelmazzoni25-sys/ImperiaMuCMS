<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h2>Login Settings</h2>\n";
if (check_value($_POST["submit_changes"])) {
    savechanges();
}
loadModuleConfigs("login");
echo "<form action=\"\" method=\"post\">\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\n        <tr>\n            <th>Status<br/><span>Enable/disable the login module.</span></th>\n            <td>\n                ";
enabledisableCheckboxes("setting_1", mconfig("active"), "Enabled", "Disabled");
echo "            </td>\n        </tr>\n        <tr>\n            <th>Session Timeout<br/><span>Enable/disable sessions timeout.</span></th>\n            <td>\n                ";
enabledisableCheckboxes("setting_2", mconfig("enable_session_timeout"), "Enabled", "Disabled");
echo "            </td>\n        </tr>\n        <tr>\n            <th>Session Timeout Limit<br/><span>If session timeout is enabled, define the time (in seconds) after which the inactive session should be logged out automatically.</span>\n            </th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"setting_3\" value=\"";
echo mconfig("session_timeout");
echo "\" style=\"display: inline; width: 150px\"/>\n                seconds\n            </td>\n        </tr>\n        <tr>\n            <th>Maximum Failed Login Attempts<br/><span>Define the maximum failed login attempts before the client's IP address should be temporarily blocked.</span>\n            </th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"setting_4\" value=\"";
echo mconfig("max_login_attempts");
echo "\"/>\n            </td>\n        </tr>\n        <tr>\n            <th>Failed Login Attempts IP Block Duration<br/><span>Time in minutes of failed login attempts IP block duration.</span>\n            </th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"setting_5\" value=\"";
echo mconfig("failed_login_timeout");
echo "\" style=\"display: inline; width: 150px\"/>\n                minutes\n            </td>\n        </tr>\n        <tr>\n            <td colspan=\"2\"><input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\" class=\"btn btn-success\"/>\n            </td>\n        </tr>\n    </table>\n</form>";
function saveChanges()
{
    
    foreach ($_POST as $setting) {
        if (!check_value($setting)) {
            message("error", "Missing data (complete all fields).");
            return NULL;
        }
    }
    $xmlPath = __PATH_MODULE_CONFIGS__ . "login.xml";
    $xml = simplexml_load_file($xmlPath);
    $xml->active = $_POST["setting_1"];
    $xml->enable_session_timeout = $_POST["setting_2"];
    $xml->session_timeout = $_POST["setting_3"];
    $xml->max_login_attempts = $_POST["setting_4"];
    $xml->failed_login_timeout = $_POST["setting_5"];
    $save = $xml->asXML($xmlPath);
    if ($save) {
        message("success", "Settings successfully saved.");
    } else {
        message("error", "There has been an error while saving changes.");
    }
}

?>