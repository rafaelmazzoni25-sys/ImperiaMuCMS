<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$General = new xGeneral();
if ($General->ftanHCIfo_canUse_j8GsnawwvJ_Module("networking")) {
    echo "    <h2>Networking Settings</h2>\r\n    ";
    function saveChanges()
    {
        foreach ($_POST as $setting) {
            if (!check_value($setting)) {
                message("error", "Missing data (complete all fields).");
                return NULL;
            }
        }
        $xmlPath = __PATH_MODULE_CONFIGS__ . "networking.xml";
        $xml = simplexml_load_file($xmlPath);
        $xml->active = $_POST["setting_1"];
        $xml->number = $_POST["setting_2"];
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
    loadModuleConfigs("networking");
    echo "    <form action=\"\" method=\"post\">\r\n        <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n            <tr>\r\n                <th>Status<br/><span>Enable/disable the networking module.</span></th>\r\n                <td>\r\n                    ";
    enabledisableCheckboxes("setting_1", mconfig("active"), "Enabled", "Disabled");
    echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Number of displayed accounts<br/><span></span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"setting_2\" value=\"";
    echo mconfig("number");
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td colspan=\"2\"><input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\"\r\n                                       class=\"btn btn-success\"/>\r\n                </td>\r\n            </tr>\r\n        </table>\r\n    </form>\r\n\r\n    ";
} else {
    message("error", "You can't use this module!");
}

?>