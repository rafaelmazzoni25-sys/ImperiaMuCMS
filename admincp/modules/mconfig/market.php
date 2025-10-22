<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h2>Market Settings</h2>\r\n";
if (check_value($_POST["submit_changes"])) {
    savechanges();
}
loadModuleConfigs("usercp.market");
$creditSystem = new CreditSystem($common, new Character(), $dB, $dB2);
echo "<form action=\"\" method=\"post\">\r\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n        <tr>\r\n            <th>Status<br/><span>Enable/disable the market module.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_1", mconfig("active"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Items per page<br/><span>How many items will be showed on page (recommended values 50-200)</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_3\" value=\"";
echo mconfig("page");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Items Inventory limit<br/><span>Limit for maximum items in Items Inventory</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_4\" value=\"";
echo mconfig("limit_inventory");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Tax Price<br/><span>Use 0 if you want to disable tax.</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_5\" value=\"";
echo mconfig("tax");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Tax Type<br/><span>Select tax type.</span></th>\r\n            <td>\r\n                ";
echo $creditSystem->buildSelectInput("setting_6", mconfig("tax_type"), "form-control");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Extend Price<br/><span>Use 0 if you want to keep extend free. Type of currency is the same as for Tax.</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"extend_price\" value=\"";
echo mconfig("extend_price");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Enable Online Check<br/><span>Enable/disable online status check on market purchase.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_7", mconfig("online_check"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Hide Author<br/><span>Hide/show author of the offer.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes2("setting_8", mconfig("hide_author"), "Hide", "Show");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Remove Items after X days<br/><span>If enabled, items will be automatically removed and returned to the owner after X days.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_9", mconfig("remove_items"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Remove Items Days<br/><span>If \"Remove Items after X days\" is enabled, configure days after items will be removed from market.</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_10\" value=\"";
echo mconfig("remove_items_days");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan=\"2\"><input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\" class=\"btn btn-success\"/>\r\n            </td>\r\n        </tr>\r\n    </table>\r\n</form>";
function saveChanges()
{
    
    foreach ($_POST as $setting) {
        if (!check_value($setting)) {
            message("error", "Missing data (complete all fields).");
            return NULL;
        }
    }
    $xmlPath = __PATH_MODULE_CONFIGS__ . "usercp.market.xml";
    $xml = simplexml_load_file($xmlPath);
    $xml->active = $_POST["setting_1"];
    $xml->page = $_POST["setting_3"];
    $xml->limit_inventory = $_POST["setting_4"];
    $xml->tax = $_POST["setting_5"];
    $xml->tax_type = $_POST["setting_6"];
    $xml->extend_price = $_POST["extend_price"];
    $xml->online_check = $_POST["setting_7"];
    $xml->hide_author = $_POST["setting_8"];
    $xml->remove_items = $_POST["setting_9"];
    $xml->remove_items_days = $_POST["setting_10"];
    $save = $xml->asXML($xmlPath);
    if ($save) {
        message("success", "Settings successfully saved.");
    } else {
        message("error", "There has been an error while saving changes.");
    }
}

?>