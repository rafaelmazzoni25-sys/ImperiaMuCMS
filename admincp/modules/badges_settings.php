<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h2>Badges Settings</h2>\r\n";
$General = new xGeneral();
if (check_value($_POST["activate_module"])) {
    $key = $_POST["license_key"];
    $General->jIhfnHDm_activate_KdiupmNBd_Module("achievements", $key);
}
$isActivated = $General->jHdksHgYYix_isModule_hDbMVOIfs_Activated("badges");
if (!$isActivated && !$General->ftanHCIfo_canUse_j8GsnawwvJ_Module("badges")) {
    echo "\r\n    <form method=\"post\" action=\"\">\r\n        <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n            <tr>\r\n                <th>License Key<br/><span></span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"license_key\" value=\"\" size=\"30\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td colspan=\"2\"><input type=\"submit\" name=\"activate_module\" value=\"Activate Module\" class=\"btn btn-success\"/>\r\n                </td>\r\n            </tr>\r\n        </table>\r\n    </form>";
} else {
    function saveChanges()
    {
        foreach ($_POST as $setting) {
            if (!check_value($setting)) {
                message("error", "Missing data (complete all fields).");
                return NULL;
            }
        }
        $xmlPath = __PATH_MODULE_CONFIGS__ . "badges.xml";
        $xml = simplexml_load_file($xmlPath);
        $xml->active = $_POST["active"];
        $xml->max_rank = $_POST["max_rank"];
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
    loadModuleConfigs("badges");
    echo "    <form action=\"\" method=\"post\">\r\n        <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n            <tr>\r\n                <th>Status<br/><span>Enable/disable the event registration module.</span></th>\r\n                <td>\r\n                    ";
    enabledisableCheckboxes("active", mconfig("active"), "Enabled", "Disabled");
    echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Max. Rank to Reward with Badge<br/><span>For example \"10\" means, that players only from TOP 10 will be rewarded with badge.</span></th>\r\n                <td><input type=\"text\" name=\"max_rank\" value=\"";
    echo mconfig("max_rank");
    echo "\" class=\"form-control\"/></td>\r\n            </tr>\r\n            <tr>\r\n                <td colspan=\"2\"><input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\" class=\"btn btn-success\"/></td>\r\n            </tr>\r\n        </table>\r\n    </form>\r\n\r\n    ";
}

?>