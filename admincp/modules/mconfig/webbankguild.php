<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h2>Guild Web Bank Settings</h2>\r\n";
$Market = new Market();
if (check_value($_POST["submit_changes"])) {
    savechanges();
}
$General = new xGeneral();
if (check_value($_POST["activate_module"])) {
    $key = $_POST["license_key"];
    $General->jIhfnHDm_activate_KdiupmNBd_Module("architect", $key);
}
$isActivated = $General->jHdksHgYYix_isModule_hDbMVOIfs_Activated("architect");
if (!$isActivated) {
    echo "\r\n    <form method=\"post\" action=\"\">\r\n        <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n            <tr>\r\n                <th>License Key<br/><span></span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"license_key\" value=\"\" size=\"30\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td colspan=\"2\"><input type=\"submit\" name=\"activate_module\" value=\"Activate Module\" class=\"btn btn-success\"/>\r\n                </td>\r\n            </tr>\r\n        </table>\r\n    </form>";
} else {
    loadModuleConfigs("usercp.webbankguild");
    echo "    <form action=\"index.php?module=modules_manager&config=webbankguild\" method=\"post\">\r\n        <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n            <tr>\r\n                <th>Status<br/><span>Enable/disable the guild web bank module.</span></th>\r\n                <td>\r\n                    ";
    enabledisableCheckboxes("setting_1", mconfig("active"), "Enabled", "Disabled");
    echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Valor<br/><span>Enable/disable storage for Valor in guild web bank.</span></th>\r\n                <td>\r\n                    ";
    enabledisableCheckboxes("valor", mconfig("valor"), "Enabled", "Disabled");
    echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Sign of Lord<br/><span>Enable/disable storage for Sign of Lord in guild web bank.</span></th>\r\n                <td>\r\n                    ";
    enabledisableCheckboxes("sign_of_lord", mconfig("sign_of_lord"), "Enabled", "Disabled");
    echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Zen<br/><span>Enable/disable storage for Zen in guild web bank.</span></th>\r\n                <td>\r\n                    ";
    enabledisableCheckboxes("setting_2", mconfig("zen"), "Enabled", "Disabled");
    echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Jewel of Bless<br/><span>Enable/disable storage for Jewel of Bless in guild web bank.</span></th>\r\n                <td>\r\n                    ";
    enabledisableCheckboxes("setting_3", mconfig("job"), "Enabled", "Disabled");
    echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Jewel of Soul<br/><span>Enable/disable storage for Jewel of Soul in guild web bank.</span></th>\r\n                <td>\r\n                    ";
    enabledisableCheckboxes("setting_4", mconfig("jos"), "Enabled", "Disabled");
    echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Jewel of Life<br/><span>Enable/disable storage for Jewel of Life in guild web bank.</span></th>\r\n                <td>\r\n                    ";
    enabledisableCheckboxes("setting_5", mconfig("jol"), "Enabled", "Disabled");
    echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Jewel of Chaos<br/><span>Enable/disable storage for Jewel of Chaos in guild web bank.</span></th>\r\n                <td>\r\n                    ";
    enabledisableCheckboxes("setting_6", mconfig("joch"), "Enabled", "Disabled");
    echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Jewel of Harmony<br/><span>Enable/disable storage for Jewel of Harmony in guild web bank.</span></th>\r\n                <td>\r\n                    ";
    enabledisableCheckboxes("setting_7", mconfig("joh"), "Enabled", "Disabled");
    echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Jewel of Creation<br/><span>Enable/disable storage for Jewel of Creation in guild web bank.</span></th>\r\n                <td>\r\n                    ";
    enabledisableCheckboxes("setting_8", mconfig("joc"), "Enabled", "Disabled");
    echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Jewel of Guardian<br/><span>Enable/disable storage for Jewel of Guardian in guild web bank.</span></th>\r\n                <td>\r\n                    ";
    enabledisableCheckboxes("setting_9", mconfig("jog"), "Enabled", "Disabled");
    echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Guild Web Bank Zen Limit<br/><span>Maximum can be 9,223,372,036,854,775,807</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"setting_10\" value=\"";
    echo mconfig("zen_limit");
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Guild Web Bank Jewel Limit<br/><span>Maximum can be 2,147,483,647</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"setting_11\" value=\"";
    echo mconfig("jewel_limit");
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Inventory Zen Limit<br/><span>Maximum can be 2,000,000,000</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"setting_12\" value=\"";
    echo mconfig("inv_limit");
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td colspan=\"2\"><input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\" class=\"btn btn-success\"/></td>\r\n            </tr>\r\n        </table>\r\n    </form>\r\n\r\n    ";
}
function saveChanges()
{
    
    foreach ($_POST as $setting) {
        if (!check_value($setting)) {
            message("error", "Missing data (complete all fields).");
            return NULL;
        }
    }
    $xmlPath = __PATH_MODULE_CONFIGS__ . "usercp.webbankguild.xml";
    $xml = simplexml_load_file($xmlPath);
    $xml->active = $_POST["setting_1"];
    $xml->valor = $_POST["valor"];
    $xml->sign_of_lord = $_POST["sign_of_lord"];
    $xml->zen = $_POST["setting_2"];
    $xml->job = $_POST["setting_3"];
    $xml->jos = $_POST["setting_4"];
    $xml->jol = $_POST["setting_5"];
    $xml->joch = $_POST["setting_6"];
    $xml->joh = $_POST["setting_7"];
    $xml->joc = $_POST["setting_8"];
    $xml->jog = $_POST["setting_9"];
    $xml->zen_limit = $_POST["setting_10"];
    $xml->jewel_limit = $_POST["setting_11"];
    $xml->inv_limit = $_POST["setting_12"];
    $save = $xml->asXML($xmlPath);
    if ($save) {
        message("success", "Settings successfully saved.");
    } else {
        message("error", "There has been an error while saving changes.");
    }
}

?>