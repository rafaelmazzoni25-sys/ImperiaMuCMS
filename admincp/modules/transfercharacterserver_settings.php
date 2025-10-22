<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h2>Transfer Character Settings</h2>\r\n";
if (check_value($_POST["submit_changes"])) {
    savechanges();
}
loadModuleConfigs("usercp.transfercharacterserver");
echo "<form action=\"\" method=\"post\">\r\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n        <tr>\r\n            <th>Status<br/><span>Enable/disable module.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("active", mconfig("active"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Max. Level<br/><span>Maximum level to transfer.</span></th>\r\n            <td>\r\n                <input type=\"text\" name=\"max_clvl\" value=\"";
echo mconfig("max_clvl");
echo "\" class=\"form-control\" />\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Max. Master Level<br/><span>Maximum master level to transfer.</span></th>\r\n            <td>\r\n                <input type=\"text\" name=\"max_mlvl\" value=\"";
echo mconfig("max_mlvl");
echo "\" class=\"form-control\" />\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Transfer Inventory<br/><span>Enable/disable transfer of character's inventory.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("transfer_inv", mconfig("transfer_inv"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Transfer Inventory Expansion<br/><span>Enable/disable transfer of inventory expansion.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("transfer_inv_ext", mconfig("transfer_inv_ext"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Free Transfers<br/><span>Amount of free transfers.</span></th>\r\n            <td>\r\n                <input type=\"text\" name=\"free_transfers\" value=\"";
echo mconfig("free_transfers");
echo "\" class=\"form-control\" />\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Transfer Price (WCoin)<br/><span>Price of transfer in WCoins.</span></th>\r\n            <td>\r\n                <input type=\"text\" name=\"price_wcoin\" value=\"";
echo mconfig("price_wcoin");
echo "\" class=\"form-control\" />\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan=\"2\"><input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\" class=\"btn btn-success\"/></td>\r\n        </tr>\r\n    </table>\r\n</form>";
function saveChanges()
{
    foreach ($_POST as $setting) {
        if (!check_value($setting)) {
            message("error", "Missing data (complete all fields).");
            return NULL;
        }
    }
    $xmlPath = __PATH_MODULE_CONFIGS__ . "usercp.transfercharacterserver.xml";
    $xml = simplexml_load_file($xmlPath);
    $xml->active = $_POST["active"];
    $xml->max_clvl = $_POST["max_clvl"];
    $xml->max_mlvl = $_POST["max_mlvl"];
    $xml->transfer_inv = $_POST["transfer_inv"];
    $xml->transfer_inv_ext = $_POST["transfer_inv_ext"];
    $xml->free_transfers = $_POST["free_transfers"];
    $xml->price_wcoin = $_POST["price_wcoin"];
    $save = $xml->asXML($xmlPath);
    if ($save) {
        message("success", "Settings successfully saved.");
    } else {
        message("error", "There has been an error while saving changes.");
    }
}

?>