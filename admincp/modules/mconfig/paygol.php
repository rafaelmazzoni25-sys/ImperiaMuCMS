<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h1 class=\"page-header\">PayGol Settings</h1>\n";
if (check_value($_POST["submit_changes"])) {
    savechanges();
}
loadModuleConfigs("donation.paygol");
$creditSystem = new CreditSystem($common, new Character(), $dB, $dB2);
echo "<form action=\"\" method=\"post\">\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\n        <tr>\n            <th>Status<br/><span>Enable/disable the PayGol donation gateway.<br/><br/>More info:<br/><a\n                            href=\"http://www.paygol.com/\" target=\"_blank\">http://www.paygol.com/</a></span></th>\n            <td>\n                ";
enabledisableCheckboxes("setting_10", mconfig("active"), "Enabled", "Disabled");
echo "            </td>\n        </tr>\n        <tr>\n            <th>Online Check<br/><span>Enable/disable online check of player.</span></th>\n            <td>\n                ";
enabledisableCheckboxes("setting_11", mconfig("check_online"), "Enabled", "Disabled");
echo "            </td>\n        </tr>\n        <tr>\n            <th>Credit Configuration<br/><span></span></th>\n            <td>\n                ";
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
    $xmlPath = __PATH_MODULE_CONFIGS__ . "donation.paygol.xml";
    $xml = simplexml_load_file($xmlPath);
    $xml->active = $_POST["setting_10"];
    $xml->check_online = $_POST["setting_11"];
    $xml->credit_config = $_POST["setting_14"];
    $save3 = $xml->asXML($xmlPath);
    if ($save3) {
        message("success", "[PayGol] Settings successfully saved.");
    } else {
        message("error", "[PayGol] There has been an error while saving changes.");
    }
}

?>