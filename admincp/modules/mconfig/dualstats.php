<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h2>Dual Stats Settings</h2>\r\n";
if (check_value($_POST["submit_changes"])) {
    savechanges();
}
$General = new xGeneral();
if (check_value($_POST["activate_module"])) {
    $key = $_POST["license_key"];
    $General->jIhfnHDm_activate_KdiupmNBd_Module("dualstats", $key);
}
$isActivated = $General->jHdksHgYYix_isModule_hDbMVOIfs_Activated("dualstats");
if (!$isActivated) {
    echo "\r\n    <form method=\"post\" action=\"\">\r\n        <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n            <tr>\r\n                <th>License Key<br/><span></span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"license_key\" value=\"\" size=\"30\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td colspan=\"2\"><input type=\"submit\" name=\"activate_module\" value=\"Activate Module\" class=\"btn btn-success\"/>\r\n                </td>\r\n            </tr>\r\n        </table>\r\n    </form>";
} else {
    loadModuleConfigs("usercp.dualstats");
    $creditSystem = new CreditSystem($common, new Character(), $dB, $dB2);
    echo "    <form action=\"\" method=\"post\">\r\n        <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n            <tr>\r\n                <th>Status<br/><span>Enable/disable the dual stats module.</span></th>\r\n                <td>\r\n                    ";
    enabledisableCheckboxes("setting_1", mconfig("active"), "Enabled", "Disabled");
    echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Required Level<br/><span>Required level to use module.</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"setting_2\" value=\"";
    echo mconfig("required_level");
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n\r\n            <tr>\r\n                <th>Equipment Check<br/><span>Enable/disable character's equipment check.</span></th>\r\n                <td>\r\n                    ";
    enabledisableCheckboxes("setting_3", mconfig("equip_check"), "Enabled", "Disabled");
    echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Store Equipment<br/><span>Enable/disable store equipment with stats (character's equipment will be moved to database).<br>If enabled, Equipment Check must be disabled.</span></th>\r\n                <td>\r\n                    ";
    enabledisableCheckboxes("setting_4", mconfig("store_equip"), "Enabled", "Disabled");
    echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Is Locked<br/><span>Yes = player will have to pay required amount to unlock Dual Stats module<br>No = usage is free</span></th>\r\n                <td>\r\n                    ";
    enabledisableCheckboxes("setting_5", mconfig("is_locked"), "Yes", "No");
    echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Unlock Price<br/><span>Required amount of selected currency to unlock module.</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"setting_6\" value=\"";
    echo mconfig("price");
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Credit Configuration<br/><span></span></th>\r\n                <td>\r\n                    ";
    echo $creditSystem->buildSelectInput("setting_7", mconfig("credit_config"), "form-control");
    echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <td colspan=\"2\"><input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\" class=\"btn btn-success\"/>\r\n                </td>\r\n            </tr>\r\n        </table>\r\n    </form>\r\n\r\n";
}
function saveChanges()
{
    
    foreach ($_POST as $setting) {
        if (!check_value($setting)) {
            message("error", "Missing data (complete all fields).");
            return NULL;
        }
    }
    $xmlPath = __PATH_MODULE_CONFIGS__ . "usercp.dualstats.xml";
    $xml = simplexml_load_file($xmlPath);
    $xml->active = $_POST["setting_1"];
    $xml->required_level = $_POST["setting_2"];
    $xml->equip_check = $_POST["setting_3"];
    $xml->store_equip = $_POST["setting_4"];
    $xml->is_locked = $_POST["setting_5"];
    $xml->price = $_POST["setting_6"];
    $xml->credit_config = $_POST["setting_7"];
    $save = $xml->asXML($xmlPath);
    if ($save) {
        message("success", "Settings successfully saved.");
    } else {
        message("error", "There has been an error while saving changes.");
    }
}

?>