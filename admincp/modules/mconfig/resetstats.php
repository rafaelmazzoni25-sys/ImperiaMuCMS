<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h2>Reset Stats Settings</h2>\r\n";
if (check_value($_POST["submit_changes"])) {
    savechanges();
}
loadModuleConfigs("usercp.resetstats");
echo "<form action=\"\" method=\"post\">\r\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n        <tr>\r\n            <th>Status<br/><span>Enable/disable the fix stats module.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_1", mconfig("active"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Price Requirement<br/></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_2", mconfig("resetstats_enable_requirement"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Price Type<br/><span></span>\r\n            </th>\r\n            <td>\r\n                <select name=\"setting_5\" class=\"form-control\">\r\n                    ";
if (mconfig("resetstats_price_type") == "1") {
    echo "<option value=\"1\" selected=\"selected\">Platinum Coins</option>";
} else {
    echo "<option value=\"1\">Platinum Coins</option>";
}
if (mconfig("resetstats_price_type") == "2") {
    echo "<option value=\"2\" selected=\"selected\">Gold Coins</option>";
} else {
    echo "<option value=\"2\">Gold Coins</option>";
}
if (mconfig("resetstats_price_type") == "3") {
    echo "<option value=\"3\" selected=\"selected\">Silver Coins</option>";
} else {
    echo "<option value=\"3\">Silver Coins</option>";
}
if (mconfig("resetstats_price_type") == "4") {
    echo "<option value=\"4\" selected=\"selected\">WCoins</option>";
} else {
    echo "<option value=\"4\">WCoins</option>";
}
if (mconfig("resetstats_price_type") == "5") {
    echo "<option value=\"5\" selected=\"selected\">GoblinPoints</option>";
} else {
    echo "<option value=\"5\">GoblinPoints</option>";
}
if (mconfig("resetstats_price_type") == "6") {
    echo "<option value=\"6\" selected=\"selected\">Zen</option>";
} else {
    echo "<option value=\"6\">Zen</option>";
}
echo "                </select>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Price Value<br/><span>If price requirement is enabled, set the price of this feature.</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_3\" value=\"";
echo mconfig("resetstats_price");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>New Stats<br/><span>After fixing stats, set the default points to add to each stat.</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_4\" value=\"";
echo mconfig("resetstats_new_stats");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan=\"2\"><input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\" class=\"btn btn-success\"/>\r\n            </td>\r\n        </tr>\r\n    </table>\r\n</form>";
function saveChanges()
{
    
    foreach ($_POST as $setting) {
        if (!check_value($setting)) {
            message("error", "Missing data (complete all fields).");
            return NULL;
        }
    }
    $xmlPath = __PATH_MODULE_CONFIGS__ . "usercp.resetstats.xml";
    $xml = simplexml_load_file($xmlPath);
    $xml->active = $_POST["setting_1"];
    $xml->resetstats_enable_requirement = $_POST["setting_2"];
    $xml->resetstats_price_type = $_POST["setting_5"];
    $xml->resetstats_price = $_POST["setting_3"];
    $xml->resetstats_new_stats = $_POST["setting_4"];
    $save = $xml->asXML($xmlPath);
    if ($save) {
        message("success", "Settings successfully saved.");
    } else {
        message("error", "There has been an error while saving changes.");
    }
}

?>