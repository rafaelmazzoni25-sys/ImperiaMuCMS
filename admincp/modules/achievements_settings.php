<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h2>Achievements Settings</h2>\r\n";
if (check_value($_POST["submit_changes"])) {
    savechanges();
}
$General = new xGeneral();
if (check_value($_POST["activate_module"])) {
    $key = $_POST["license_key"];
    $General->jIhfnHDm_activate_KdiupmNBd_Module("achievements", $key);
}
$isActivated = $General->jHdksHgYYix_isModule_hDbMVOIfs_Activated("achievements");
if (!$isActivated) {
    echo "\r\n    <form method=\"post\" action=\"\">\r\n        <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n            <tr>\r\n                <th>License Key<br/><span></span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"license_key\" value=\"\" size=\"30\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td colspan=\"2\"><input type=\"submit\" name=\"activate_module\" value=\"Activate Module\" class=\"btn btn-success\"/>\r\n                </td>\r\n            </tr>\r\n        </table>\r\n    </form>";
} else {
    loadModuleConfigs("usercp.achievements");
    echo "    <form action=\"\" method=\"post\">\r\n        <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n            <tr>\r\n                <th>Status<br/><span>Enable/disable the add stats module.</span></th>\r\n                <td>\r\n                    ";
    enabledisableCheckboxes("setting_1", mconfig("active"), "Enabled", "Disabled");
    echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Total Achievements<br/><span>Number of achievements what will be displayed.</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"setting_2\" value=\"";
    echo mconfig("total");
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Required Items<br/><span>Number of required different items to unlock achievements. (max. 3)</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"setting_3\" value=\"";
    echo mconfig("req_items");
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Item 1<br/><span>Name - name of item<br>Code - Category,Index,Level,Skill,Luck,Option,Excellent,Ancient<br>Count - required amount of item</span></th>\r\n                <td>\r\n                    <table width=\"100%\">\r\n                        <tr>\r\n                            <td>Name:</td>\r\n                            <td><input class=\"form-control\" type=\"text\" name=\"setting_4\" value=\"";
    echo mconfig("item1_name");
    echo "\"/></td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td>Code:</td>\r\n                            <td><input class=\"form-control\" type=\"text\" name=\"setting_5\" value=\"";
    echo mconfig("item1_code");
    echo "\"/></td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td>Count:</td>\r\n                            <td><input class=\"form-control\" type=\"text\" name=\"setting_6\" value=\"";
    echo mconfig("item1_count");
    echo "\"/></td>\r\n                        </tr>\r\n                    </table>\r\n\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Item 2<br/><span>Name - name of item<br>Code - Category,Index,Level,Skill,Luck,Option,Excellent,Ancient<br>Count - required amount of item</span>\r\n                </th>\r\n                <td>\r\n                    <table width=\"100%\">\r\n                        <tr>\r\n                            <td>Name:</td>\r\n                            <td><input class=\"form-control\" type=\"text\" name=\"setting_7\" value=\"";
    echo mconfig("item2_name");
    echo "\"/></td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td>Code:</td>\r\n                            <td><input class=\"form-control\" type=\"text\" name=\"setting_8\" value=\"";
    echo mconfig("item2_code");
    echo "\"/></td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td>Count:</td>\r\n                            <td><input class=\"form-control\" type=\"text\" name=\"setting_9\" value=\"";
    echo mconfig("item2_count");
    echo "\"/></td>\r\n                        </tr>\r\n                    </table>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Item 3<br/><span>Name - name of item<br>Code - Category,Index,Level,Skill,Luck,Option,Excellent,Ancient<br>Count - required amount of item</span>\r\n                </th>\r\n                <td>\r\n                    <table width=\"100%\">\r\n                        <tr>\r\n                            <td>Name:</td>\r\n                            <td><input class=\"form-control\" type=\"text\" name=\"setting_10\" value=\"";
    echo mconfig("item3_name");
    echo "\"/></td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td>Code:</td>\r\n                            <td><input class=\"form-control\" type=\"text\" name=\"setting_11\" value=\"";
    echo mconfig("item3_code");
    echo "\"/></td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td>Count:</td>\r\n                            <td><input class=\"form-control\" type=\"text\" name=\"setting_12\" value=\"";
    echo mconfig("item3_count");
    echo "\"/></td>\r\n                        </tr>\r\n                    </table>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Required Zen<br/><span>Amount of Zen required for unlock achievements.</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"setting_13\" value=\"";
    echo mconfig("zen");
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Auto Unlock<br/><span>Enable/disable auto unlock feature - achievements will be unlocked after character will have required level, reset, master level and grand reset.</span>\r\n                </th>\r\n                <td>\r\n                    ";
    enabledisableCheckboxes("setting_14", mconfig("autounlock"), "Enabled", "Disabled");
    echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Required Level<br/><span></span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"setting_15\" value=\"";
    echo mconfig("level");
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Required Master Level<br/><span></span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"setting_16\" value=\"";
    echo mconfig("mlevel");
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Required Reset<br/><span></span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"setting_17\" value=\"";
    echo mconfig("reset");
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Required Grand Reset<br/><span></span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"setting_18\" value=\"";
    echo mconfig("greset");
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td colspan=\"2\"><input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\"\r\n                                       class=\"btn btn-success\"/>\r\n                </td>\r\n            </tr>\r\n        </table>\r\n    </form>\r\n    ";
}
function saveChanges()
{
    foreach ($_POST as $setting) {
        if (!check_value($setting)) {
            message("error", "Missing data (complete all fields).");
            return NULL;
        }
    }
    $xmlPath = __PATH_MODULE_CONFIGS__ . "usercp.achievements.xml";
    $xml = simplexml_load_file($xmlPath);
    $xml->active = $_POST["setting_1"];
    $xml->total = $_POST["setting_2"];
    $xml->req_items = $_POST["setting_3"];
    $xml->item1_name = $_POST["setting_4"];
    $xml->item1_code = $_POST["setting_5"];
    $xml->item1_count = $_POST["setting_6"];
    $xml->item2_name = $_POST["setting_7"];
    $xml->item2_code = $_POST["setting_8"];
    $xml->item2_count = $_POST["setting_9"];
    $xml->item3_name = $_POST["setting_10"];
    $xml->item3_code = $_POST["setting_11"];
    $xml->item3_count = $_POST["setting_12"];
    $xml->zen = $_POST["setting_13"];
    $xml->autounlock = $_POST["setting_14"];
    $xml->level = $_POST["setting_15"];
    $xml->mlevel = $_POST["setting_16"];
    $xml->reset = $_POST["setting_17"];
    $xml->greset = $_POST["setting_18"];
    $save = $xml->asXML($xmlPath);
    if ($save) {
        message("success", "Settings successfully saved.");
    } else {
        message("error", "There has been an error while saving changes.");
    }
}

?>