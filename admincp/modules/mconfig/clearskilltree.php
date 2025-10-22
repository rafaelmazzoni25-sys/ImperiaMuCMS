<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h2>Clear Skill-Tree Settings</h2>\r\n";
if (check_value($_POST["submit_changes"])) {
    savechanges();
}
loadModuleConfigs("usercp.clearskilltree");
echo "<form action=\"\" method=\"post\">\r\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n        <tr>\r\n            <th>Status<br/><span>Enable/disable the clear skill-tree module.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_1", mconfig("active"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Price Requirement<br/></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_2", mconfig("clearst_enable_requirement"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Price Type<br/><span></span>\r\n            </th>\r\n            <td>\r\n                <select name=\"setting_5\" class=\"form-control\">\r\n                    ";
if (mconfig("clearst_price_type") == "1") {
    echo "<option value=\"1\" selected=\"selected\">Platinum Coins</option>";
} else {
    echo "<option value=\"1\">Platinum Coins</option>";
}
if (mconfig("clearst_price_type") == "2") {
    echo "<option value=\"2\" selected=\"selected\">Gold Coins</option>";
} else {
    echo "<option value=\"2\">Gold Coins</option>";
}
if (mconfig("clearst_price_type") == "3") {
    echo "<option value=\"3\" selected=\"selected\">Silver Coins</option>";
} else {
    echo "<option value=\"3\">Silver Coins</option>";
}
if (mconfig("clearst_price_type") == "4") {
    echo "<option value=\"4\" selected=\"selected\">WCoins</option>";
} else {
    echo "<option value=\"4\">WCoins</option>";
}
if (mconfig("clearst_price_type") == "5") {
    echo "<option value=\"5\" selected=\"selected\">GoblinPoints</option>";
} else {
    echo "<option value=\"5\">GoblinPoints</option>";
}
if (mconfig("clearst_price_type") == "6") {
    echo "<option value=\"6\" selected=\"selected\">Zen</option>";
} else {
    echo "<option value=\"6\">Zen</option>";
}
echo "                </select>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Price Value<br/><span>If price requirement is enabled, set the price of this feature.</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_3\" value=\"";
echo mconfig("clearst_price");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Required Level<br/><span>Required Level to clear Skill-Tree.</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_4\"\r\n                       value=\"";
echo mconfig("clearst_required_level");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan=\"2\"><input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\" class=\"btn btn-success\"/>\r\n            </td>\r\n        </tr>\r\n    </table>\r\n</form>";
function saveChanges()
{
    
    foreach ($_POST as $setting) {
        if (!check_value($setting)) {
            message("error", "Missing data (complete all fields).");
            return NULL;
        }
    }
    $xmlPath = __PATH_MODULE_CONFIGS__ . "usercp.clearskilltree.xml";
    $xml = simplexml_load_file($xmlPath);
    $xml->active = $_POST["setting_1"];
    $xml->clearst_enable_requirement = $_POST["setting_2"];
    $xml->clearst_price_type = $_POST["setting_5"];
    $xml->clearst_price = $_POST["setting_3"];
    $xml->clearst_required_level = $_POST["setting_4"];
    $save = $xml->asXML($xmlPath);
    if ($save) {
        message("success", "Settings successfully saved.");
    } else {
        message("error", "There has been an error while saving changes.");
    }
}

?>