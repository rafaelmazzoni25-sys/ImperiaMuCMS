<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h2>Event Registration Settings</h2>\r\n";
$General = new xGeneral();
if ($General->ftanHCIfo_canUse_j8GsnawwvJ_Module("eventregistration")) {
    function saveChanges()
    {
        $_POST;
        foreach ($_POST as $setting) {
            if (!check_value($setting)) {
                message("error", "Missing data (complete all fields).");
                return NULL;
            }
        }
        $xmlPath = __PATH_MODULE_CONFIGS__ . "usercp.eventregistration.xml";
        $xml = simplexml_load_file($xmlPath);
        $xml->active = $_POST["setting_1"];
        $save = $xml->asXML($xmlPath);
        if ($save) {
            message("success", "Settings successfully saved.");
        } else {
            message("error", "There has been an error while saving changes.");
        }
    }
    if (check_value($_POST["submit_changes"])) {
        saveChanges();
    }
    loadModuleConfigs("usercp.eventregistration");
    echo "    <form action=\"\" method=\"post\">\r\n        <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n            <tr>\r\n                <th>Status<br/><span>Enable/disable the event registration module.</span></th>\r\n                <td>\r\n                    ";
    enabledisableCheckboxes("setting_1", mconfig("active"), "Enabled", "Disabled");
    echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <td colspan=\"2\"><input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\" class=\"btn btn-success\"/>\r\n                </td>\r\n            </tr>\r\n        </table>\r\n    </form>\r\n\r\n    ";
}

?>