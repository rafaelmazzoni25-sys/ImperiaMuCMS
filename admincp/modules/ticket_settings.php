<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h2>Ticket System: Settings</h2>\r\n";
if (check_value($_POST["submit_changes"])) {
    savechanges();
}
loadModuleConfigs("ticket");
echo "<form action=\"\" method=\"post\">\r\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n        <tr>\r\n            <th>Status<br/><span>Enable/disable the registration module.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_1", mconfig("active"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Default Page<br/><span>my - Show my tickets, new - Submit new ticket.</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_2\"\r\n                       value=\"";
echo mconfig("ticket_show_default");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Show My Tickets<br/><span>If enabled...</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_3", mconfig("ticket_enable_my"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Show New Tickets<br/><span>If enabled...</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_4", mconfig("ticket_enable_new"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Show View Tickets<br/><span>If enabled...</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_5", mconfig("ticket_enable_view"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Subject Min. Length<br/></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_6\" value=\"";
echo mconfig("subject_min_length");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Subject Max. Length<br/></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_7\" value=\"";
echo mconfig("subject_max_length");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Message Min. Length<br/></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_8\" value=\"";
echo mconfig("msg_min_length");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Message Max. Length<br/></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_9\" value=\"";
echo mconfig("msg_max_length");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Staff Nickname<br/><span>Max. 50 characters</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_10\" value=\"";
echo mconfig("staff_nickname");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan=\"2\"><input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\" class=\"btn btn-success\"/>\r\n            </td>\r\n        </tr>\r\n    </table>\r\n</form>";
function saveChanges()
{
    foreach ($_POST as $setting) {
        if (!check_value($setting)) {
            message("error", "Missing data (complete all fields).");
            return NULL;
        }
    }
    $xmlPath = __PATH_MODULE_CONFIGS__ . "ticket.xml";
    $xml = simplexml_load_file($xmlPath);
    $xml->active = $_POST["setting_1"];
    $xml->ticket_show_default = $_POST["setting_2"];
    $xml->ticket_enable_my = $_POST["setting_3"];
    $xml->ticket_enable_new = $_POST["setting_4"];
    $xml->ticket_enable_view = $_POST["setting_5"];
    $xml->subject_min_length = $_POST["setting_6"];
    $xml->subject_max_length = $_POST["setting_7"];
    $xml->msg_min_length = $_POST["setting_8"];
    $xml->msg_max_length = $_POST["setting_9"];
    $xml->staff_nickname = $_POST["setting_10"];
    $save = $xml->asXML($xmlPath);
    if ($save) {
        message("success", "Settings successfully saved.");
    } else {
        message("error", "There has been an error while saving changes.");
    }
}

?>