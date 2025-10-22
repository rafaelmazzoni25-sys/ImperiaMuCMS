<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h2>Web Bank Settings</h2>\r\n";
$Market = new Market();
if (check_value($_POST["submit_changes"])) {
    savechanges();
}
if (check_value($_POST["item_add_submit"])) {
    if (preg_match("/^[a-zA-Z0-9_ \\s]+\$/", $_POST["name"])) {
        $Market->webBankAddCustomItem($_POST["name"], $_POST["hex"], $_POST["limit"], $_POST["type"], $_POST["ident"]);
    } else {
        message("error", "Invalid characters. Allowed symbols: a-z, A-Z, 0-9, _ and space");
    }
}
if (check_value($_POST["item_edit_submit"])) {
    $Market->webBankEditCustomItem($_POST["id"], $_POST["hex"], $_POST["limit"], $_POST["type"], $_POST["ident"]);
}
if (check_value($_REQUEST["delete"])) {
    $Market->webBankDeleteCustomItem($_GET["delete"]);
}
loadModuleConfigs("usercp.webbank");
echo "    <form action=\"index.php?module=modules_manager&config=webbank\" method=\"post\">\r\n        <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n            <tr>\r\n                <th>Status<br/><span>Enable/disable the web bank module.</span></th>\r\n                <td>\r\n                    ";
enabledisableCheckboxes("setting_1", mconfig("active"), "Enabled", "Disabled");
echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Zen<br/><span>Enable/disable storage for Zen in web bank.</span></th>\r\n                <td>\r\n                    ";
enabledisableCheckboxes("setting_2", mconfig("zen"), "Enabled", "Disabled");
echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Jewel of Bless<br/><span>Enable/disable storage for Jewel of Bless in web bank.</span></th>\r\n                <td>\r\n                    ";
enabledisableCheckboxes("setting_3", mconfig("job"), "Enabled", "Disabled");
echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Jewel of Soul<br/><span>Enable/disable storage for Jewel of Soul in web bank.</span></th>\r\n                <td>\r\n                    ";
enabledisableCheckboxes("setting_4", mconfig("jos"), "Enabled", "Disabled");
echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Jewel of Life<br/><span>Enable/disable storage for Jewel of Life in web bank.</span></th>\r\n                <td>\r\n                    ";
enabledisableCheckboxes("setting_5", mconfig("jol"), "Enabled", "Disabled");
echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Jewel of Chaos<br/><span>Enable/disable storage for Jewel of Chaos in web bank.</span></th>\r\n                <td>\r\n                    ";
enabledisableCheckboxes("setting_6", mconfig("joch"), "Enabled", "Disabled");
echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Jewel of Harmony<br/><span>Enable/disable storage for Jewel of Harmony in web bank.</span></th>\r\n                <td>\r\n                    ";
enabledisableCheckboxes("setting_7", mconfig("joh"), "Enabled", "Disabled");
echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Jewel of Creation<br/><span>Enable/disable storage for Jewel of Creation in web bank.</span></th>\r\n                <td>\r\n                    ";
enabledisableCheckboxes("setting_8", mconfig("joc"), "Enabled", "Disabled");
echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Jewel of Guardian<br/><span>Enable/disable storage for Jewel of Guardian in web bank.</span></th>\r\n                <td>\r\n                    ";
enabledisableCheckboxes("setting_9", mconfig("jog"), "Enabled", "Disabled");
echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Web Bank Zen Limit<br/><span>Maximum can be 9,223,372,036,854,775,807</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"setting_10\" value=\"";
echo mconfig("zen_limit");
echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Web Bank Jewel Limit<br/><span>Maximum can be 2,147,483,647</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"setting_11\" value=\"";
echo mconfig("jewel_limit");
echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Inventory Zen Limit<br/><span>Maximum can be 2,000,000,000</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"setting_12\" value=\"";
echo mconfig("inv_limit");
echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td colspan=\"2\"><input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\" class=\"btn btn-success\"/></td>\r\n            </tr>\r\n        </table>\r\n    </form>\r\n\r\n    <hr>\r\n    <h3>Manage Custom Items</h3>\r\n<table class=\"table table-striped table-bordered table-hover\"><tr><th>Name</th><th>Hex Code</th><th>Limit</th><th>Type</th><th>Identificator</th><th></th></tr>";
$customItems = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_WEB_BANK_CUSTOM ORDER BY id");
foreach ($customItems as $thisItem) {
    echo "<form action=\"index.php?module=modules_manager&config=webbank\" method=\"post\">";
    echo "<input type=\"hidden\" name=\"id\" value=\"" . $thisItem["id"] . "\"/>";
    echo "<tr>";
    echo "<td><input name=\"name\" class=\"form-control\" type=\"text\" value=\"" . $thisItem["name"] . "\" readonly=\"readonly\"/></td>";
    echo "<td><input name=\"hex\" class=\"form-control\" type=\"text\" value=\"" . $thisItem["hex"] . "\"/></td>";
    echo "<td><input name=\"limit\" class=\"form-control\" type=\"text\" value=\"" . $thisItem["limit"] . "\"/></td>";
    echo "<td><select name=\"type\" class=\"form-control\">";
    if ($thisItem["type"] == "1") {
        echo "<option value=\"1\" selected>Vault</option>";
    } else {
        echo "<option value=\"1\">Vault</option>";
    }
    if ($thisItem["type"] == "2") {
        echo "<option value=\"2\" selected>Inventory</option>";
    } else {
        echo "<option value=\"2\">Inventory</option>";
    }
    echo "</select></td>";
    echo "<td><input name=\"ident\" class=\"form-control\" type=\"text\" value=\"" . $thisItem["ident"] . "\" readonly=\"readonly\" /></td>";
    echo "<td>\r\n            <input type=\"submit\" class=\"btn btn-success\" name=\"item_edit_submit\" value=\"Save\"/>\r\n            <a href=\"index.php?module=modules_manager&config=webbank&delete=" . $thisItem["id"] . "\" class=\"btn btn-danger\"><i class=\"fa fa-remove\"></i></a>\r\n          </td>";
    echo "</tr></form>";
}
echo "</table>";
$newIdent = $dB->query_fetch_single("SELECT TOP 1 ident FROM IMPERIAMUCMS_WEB_BANK_CUSTOM ORDER BY ident desc");
if ($newIdent == NULL) {
    $newIdent = 100;
} else {
    $newIdent = $newIdent["ident"] + 1;
}
if ($newIdent < 100) {
    $newIdent = 100;
}
echo "<table class=\"table table-striped table-bordered table-hover\"><tr><th>Name</th><th>Hex Code</th><th>Limit</th><th>Type</th><th>Identificator</th><th></th></tr><form action=\"index.php?module=modules_manager&config=webbank\" method=\"post\"><tr><td><input name=\"name\" class=\"form-control\" type=\"text\" value=\"\"/></td><td><input name=\"hex\" class=\"form-control\" type=\"text\" value=\"\"/></td><td><input name=\"limit\" class=\"form-control\" type=\"text\" value=\"\"/></td><td>\r\n        <select name=\"type\" class=\"form-control\">\r\n            <option value=\"1\">Vault</option>\r\n            <option value=\"2\">Inventory</option>\r\n        </select>\r\n      </td>";
echo "<td><input name=\"ident\" class=\"form-control\" type=\"text\" value=\"" . $newIdent . "\" readonly=\"readonly\" /></td>";
echo "<td>\r\n        <input type=\"submit\" class=\"btn btn-success\" name=\"item_add_submit\" value=\"Add\"/>\r\n      </td></tr></form></table>";
function saveChanges()
{
    
    foreach ($_POST as $setting) {
        if (!check_value($setting)) {
            message("error", "Missing data (complete all fields).");
            return NULL;
        }
    }
    $xmlPath = __PATH_MODULE_CONFIGS__ . "usercp.webbank.xml";
    $xml = simplexml_load_file($xmlPath);
    $xml->active = $_POST["setting_1"];
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