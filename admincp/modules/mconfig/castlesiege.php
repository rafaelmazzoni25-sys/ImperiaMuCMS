<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h2>Castle Siege Settings</h2>\r\n";
if (check_value($_POST["submit_changes"])) {
    savechanges();
}
loadModuleConfigs("castlesiege");
echo "<form action=\"\" method=\"post\">\r\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n        <tr>\r\n            <th>Status<br/><span>Enable/disable the castle siege module.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_1", mconfig("active"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Register Period<br/><span>Use values from IGCData/Events/IGC_CastleSiege.xml, Stage=\"1\"</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_2\" value=\"";
echo mconfig("cs_period_register_day");
echo "\" style=\"display: inline; width: 150px\"/> = Day<br/>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_3\" value=\"";
echo mconfig("cs_period_register_time");
echo "\" style=\"display: inline; width: 150px\"/> = Hour:Minute\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Idle 1 Period<br/><span>Use values from IGCData/Events/IGC_CastleSiege.xml, Stage=\"2\"</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_4\" value=\"";
echo mconfig("cs_period_idle1_day");
echo "\" style=\"display: inline; width: 150px\"/> = Day<br/>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_5\" value=\"";
echo mconfig("cs_period_idle1_time");
echo "\" style=\"display: inline; width: 150px\"/> = Hour:Minute\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Register Sign of Lord Period<br/><span>Use values from IGCData/Events/IGC_CastleSiege.xml, Stage=\"3\"</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_6\" value=\"";
echo mconfig("cs_period_registermark_day");
echo "\" style=\"display: inline; width: 150px\"/> = Day<br/>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_7\" value=\"";
echo mconfig("cs_period_registermark_time");
echo "\" style=\"display: inline; width: 150px\"/> = Hour:Minute\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Idle 2 Period<br/><span>Use values from IGCData/Events/IGC_CastleSiege.xml, Stage=\"4\"</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_8\" value=\"";
echo mconfig("cs_period_idle2_day");
echo "\" style=\"display: inline; width: 150px\"/> = Day<br/>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_9\" value=\"";
echo mconfig("cs_period_idle2_time");
echo "\" style=\"display: inline; width: 150px\"/> = Hour:Minute\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Guild Notification Period<br/><span>Use values from IGCData/Events/IGC_CastleSiege.xml, Stage=\"5\"</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_10\" value=\"";
echo mconfig("cs_period_notification_day");
echo "\" style=\"display: inline; width: 150px\"/> = Day<br/>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_11\" value=\"";
echo mconfig("cs_period_notification_time");
echo "\" style=\"display: inline; width: 150px\"/> = Hour:Minute\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Ready for Battle Period<br/><span>Use values from IGCData/Events/IGC_CastleSiege.xml, Stage=\"6\"</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_12\" value=\"";
echo mconfig("cs_period_ready_day");
echo "\" style=\"display: inline; width: 150px\"/> = Day<br/>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_13\" value=\"";
echo mconfig("cs_period_ready_time");
echo "\" style=\"display: inline; width: 150px\"/> = Hour:Minute\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Castle Siege Start<br/><span>Use values from IGCData/Events/IGC_CastleSiege.xml, Stage=\"7\"</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_14\" value=\"";
echo mconfig("cs_period_start_day");
echo "\" style=\"display: inline; width: 150px\"/> = Day<br/>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_15\" value=\"";
echo mconfig("cs_period_start_time");
echo "\" style=\"display: inline; width: 150px\"/> = Hour:Minute\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Castle Siege End<br/><span>Use values from IGCData/Events/IGC_CastleSiege.xml, Stage=\"8\"</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_16\" value=\"";
echo mconfig("cs_period_end_day");
echo "\" style=\"display: inline; width: 150px\"/> = Day<br/>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_17\" value=\"";
echo mconfig("cs_period_end_time");
echo "\" style=\"display: inline; width: 150px\"/> = Hour:Minute\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>End of Cycle<br/><span>Use values from IGCData/Events/IGC_CastleSiege.xml, Stage=\"9\"</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_18\" value=\"";
echo mconfig("cs_period_cycle_day");
echo "\" style=\"display: inline; width: 150px\"/> = Day<br/>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_19\" value=\"";
echo mconfig("cs_period_cycle_time");
echo "\" style=\"display: inline; width: 150px\"/> = Hour:Minute\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan=\"2\"><input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\" class=\"btn btn-success\"/>\r\n            </td>\r\n        </tr>\r\n    </table>\r\n</form>";
function saveChanges()
{
    
    foreach ($_POST as $setting) {
        if (!check_value($setting)) {
            message("error", "Missing data (complete all fields).");
            return NULL;
        }
    }
    $xmlPath = __PATH_MODULE_CONFIGS__ . "castlesiege.xml";
    $xml = simplexml_load_file($xmlPath);
    $xml->active = $_POST["setting_1"];
    $xml->cs_period_register_day = $_POST["setting_2"];
    $xml->cs_period_register_time = $_POST["setting_3"];
    $xml->cs_period_idle1_day = $_POST["setting_4"];
    $xml->cs_period_idle1_time = $_POST["setting_5"];
    $xml->cs_period_registermark_day = $_POST["setting_6"];
    $xml->cs_period_registermark_time = $_POST["setting_7"];
    $xml->cs_period_idle2_day = $_POST["setting_8"];
    $xml->cs_period_idle2_time = $_POST["setting_9"];
    $xml->cs_period_notification_day = $_POST["setting_10"];
    $xml->cs_period_notification_time = $_POST["setting_11"];
    $xml->cs_period_ready_day = $_POST["setting_12"];
    $xml->cs_period_ready_time = $_POST["setting_13"];
    $xml->cs_period_start_day = $_POST["setting_14"];
    $xml->cs_period_start_time = $_POST["setting_15"];
    $xml->cs_period_end_day = $_POST["setting_16"];
    $xml->cs_period_end_time = $_POST["setting_17"];
    $xml->cs_period_cycle_day = $_POST["setting_18"];
    $xml->cs_period_cycle_time = $_POST["setting_19"];
    $save = $xml->asXML($xmlPath);
    if ($save) {
        message("success", "Settings successfully saved.");
    } else {
        message("error", "There has been an error while saving changes.");
    }
}

?>