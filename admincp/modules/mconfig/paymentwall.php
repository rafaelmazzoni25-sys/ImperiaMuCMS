<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h1 class=\"page-header\">Paymentwall Settings</h1>\n";
if (check_value($_POST["submit_changes"])) {
    savechanges();
}
loadModuleConfigs("donation.paymentwall");
$creditSystem = new CreditSystem($common, new Character(), $dB, $dB2);
echo "<form action=\"\" method=\"post\">\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\n        <tr>\n            <th>Status<br/><span>Enable/disable the Paymentwall donation gateway.<br/>More info: <a href=\"http://www.paymentwall.com/\" target=\"_blank\">http://www.paymentwall.com/</a></span></th>\n            <td>\n                ";
enabledisableCheckboxes("setting_10", mconfig("active"), "Enabled", "Disabled");
echo "            </td>\n        </tr>\n        <tr>\n            <th>Type<br/><span>Select type of donation.</span></th>\n            <td>\n                ";
enabledisableCheckboxes2("type", mconfig("type"), "Paymentwall", "Offerwall");
echo "            </td>\n        </tr>\n        <tr>\n            <th>IP Check<br/><span>Select type of IP check.</span></th>\n            <td>\n                ";
enabledisableCheckboxes2("ip_check", mconfig("ip_check"), "New IPs", "Old IPs");
echo "            </td>\n        </tr>\n        <tr>\n            <th>Secret Key<br/></th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"setting_11\" value=\"";
echo mconfig("pw_secret_key");
echo "\"/>\n            </td>\n        </tr>\n        <tr>\n            <th>App Key<br/></th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"setting_12\" value=\"";
echo mconfig("pw_app_key");
echo "\"/>\n            </td>\n        </tr>\n        <tr>\n            <th>Widget Version<br/></th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"pw_widget\" value=\"";
echo mconfig("pw_widget");
echo "\"/>\n            </td>\n        </tr>\n        <!--<tr>\n            <th>Signature Check<br/><span>Enable/disable signature integrity check.</span></th>\n            <td>\n                            </td>\n        </tr>-->\n        <tr>\n            <th>Online Check<br/><span>Enable/disable online check.</span></th>\n            <td>\n                ";
enabledisableCheckboxes("setting_17", mconfig("check_online"), "Enabled", "Disabled");
echo "            </td>\n        </tr>\n        <tr>\n            <th>Credits Conversion\n                Rate<br/><span>How many game credits is equivalent to 1 of real money currency.<br/>Example: 1 USD = 100 Credits, in this example you would type in the box 100.</span>\n            </th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"setting_13\" value=\"";
echo mconfig("pw_conversion_rate");
echo "\"/>\n            </td>\n        </tr>\n        <tr>\n            <th>API Type</th>\n            <td>\n                <select name=\"setting_15\" class=\"form-control\">\n                    ";
if (mconfig("pw_api") == "subscription") {
    echo "<option value=\"subscription\" selected=\"selected\">Digital Good / Subscription</option>";
} else {
    echo "<option value=\"subscription\">Digital Good / Subscription</option>";
}
if (mconfig("pw_api") == "ps") {
    echo "<option value=\"ps\" selected=\"selected\">Virtual Currency</option>";
} else {
    echo "<option value=\"ps\">Virtual Currency</option>";
}
echo "\n\n                </select>\n            </td>\n        </tr>\n        <tr>\n            <th>Credit Configuration<br/><span></span></th>\n            <td>\n                ";
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
    $xmlPath = __PATH_MODULE_CONFIGS__ . "donation.paymentwall.xml";
    $xml = simplexml_load_file($xmlPath);
    $xml->active = $_POST["setting_10"];
    $xml->type = $_POST["type"];
    $xml->ip_check = $_POST["ip_check"];
    $xml->pw_secret_key = $_POST["setting_11"];
    $xml->pw_app_key = $_POST["setting_12"];
    $xml->check_online = $_POST["setting_17"];
    $xml->pw_conversion_rate = $_POST["setting_13"];
    $xml->pw_api = $_POST["setting_15"];
    $xml->pw_widget = $_POST["pw_widget"];
    $xml->credit_config = $_POST["setting_14"];
    $save3 = $xml->asXML($xmlPath);
    if ($save3) {
        message("success", "[Paymentwall] Settings successfully saved.");
    } else {
        message("error", "[Paymentwall] There has been an error while saving changes.");
    }
}

?>