<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h1 class=\"page-header\">SuperRewards Settings</h1>\n";
if (check_value($_POST["submit_changes"])) {
    savechanges();
}
loadModuleConfigs("donation.superrewards");
$creditSystem = new CreditSystem($common, new Character(), $dB, $dB2);
echo "<form action=\"\" method=\"post\">\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\n        <tr>\n            <th>Status<br/><span>Enable/disable the super rewards donation gateway.<br/><br/>More info:<br/><a\n                            href=\"http://www.superrewards.com/\" target=\"_blank\">http://www.superrewards.com/</a></span></th>\n            <td>\n                ";
enabledisableCheckboxes("setting_10", mconfig("active"), "Enabled", "Disabled");
echo "            </td>\n        </tr>\n        <tr>\n            <th>App ID<br/></th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"setting_11\" value=\"";
echo mconfig("sr_h");
echo "\"/>\n            </td>\n        </tr>\n        <tr>\n            <th>Secret Key<br/></th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"setting_12\" value=\"";
echo mconfig("sr_secret");
echo "\"/>\n            </td>\n        </tr>\n        <tr>\n            <th>Credits Conversion\n                Rate<br/><span>How many game credits is equivalent to 1 of real money currency.<br/><br/>Example:<br/>1 USD = 100 Credits, in this example you would type in the box 100.</span>\n            </th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"setting_13\" value=\"";
echo mconfig("sr_conversion_rate");
echo "\"/>\n            </td>\n        </tr>\n        <tr>\n            <th>Credit Configuration<br/><span></span></th>\n            <td>\n                ";
echo $creditSystem->buildSelectInput("setting_14", mconfig("credit_config"), "form-control");
echo "            </td>\n        </tr>\n        <tr>\n            <td colspan=\"2\"><input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\" class=\"btn btn-success\"/>\n            </td>\n        </tr>\n    </table>\n</form>";
function saveChanges()
{
    
    foreach ($_POST as $setting) {
        if (!check_value($setting)) {
            message("error", "Missing data (complete all fields).");
            return NULL;
        }
    }
    $xmlPath = __PATH_MODULE_CONFIGS__ . "donation.superrewards.xml";
    $xml = simplexml_load_file($xmlPath);
    $xml->active = $_POST["setting_10"];
    $xml->sr_h = $_POST["setting_11"];
    $xml->sr_secret = $_POST["setting_12"];
    $xml->sr_conversion_rate = $_POST["setting_13"];
    $xml->credit_config = $_POST["setting_14"];
    $save3 = $xml->asXML($xmlPath);
    if ($save3) {
        message("success", "[Super Rewards] Settings successfully saved.");
    } else {
        message("error", "[Super Rewards] There has been an error while saving changes.");
    }
}

?>