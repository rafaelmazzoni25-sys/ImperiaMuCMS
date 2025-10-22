<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h1 class=\"page-header\">MercadoPago Settings</h1>\n";
if (check_value($_POST["submit_changes"])) {
    savechanges();
}
loadModuleConfigs("donation.mercadopago");
$creditSystem = new CreditSystem($common, new Character(), $dB, $dB2);
echo "<form action=\"\" method=\"post\">\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\n        <tr>\n            <th>Status<br/><span>Enable/disable the MercadoPago donation gateway.</span></th>\n            <td>\n                ";
enabledisableCheckboxes("mercadopago_active", mconfig("active"), "Enabled", "Disabled");
echo "            </td>\n        </tr>\n        <tr>\n            <th>MercadoPago Sandbox Mode<br/><span>Enable/disable MercadoPago's IPN testing mode.<br/><br/>More info:<br/><a href=\"https://www.mercadopago.com.ar/developers/\" target=\"_blank\">https://www.mercadopago.com.ar/developers/</a></span>\n            </th>\n            <td>\n                ";
enabledisableCheckboxes("mercadopago_enable_sandbox", mconfig("mercadopago_enable_sandbox"), "Enabled", "Disabled");
echo "            </td>\n        </tr>\n        <tr>\n            <th>Client ID<br/><span>MercadoPago client ID.</span></th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"mercadopago_client_id\" value=\"";
echo mconfig("mercadopago_client_id");
echo "\"/>\n            </td>\n        </tr>\n        <tr>\n            <th>Client Secret<br/><span>MercadoPago Client Secret</span></th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"mercadopago_client_secret\" value=\"";
echo mconfig("mercadopago_client_secret");
echo "\"/>\n            </td>\n        </tr>\n        <tr>\n            <th>Access Token<br/><span>MercadoPago Access Token</span></th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"mercadopago_access_token\" value=\"";
echo mconfig("mercadopago_access_token");
echo "\"/>\n            </td>\n        </tr>\n        <tr>\n            <th>MercadoPago Donations Title<br/><span>Title of the MercadoPago donation. Example: \"Donation for Gold Coins\".</span></th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"mercadopago_title\" value=\"";
echo mconfig("mercadopago_title");
echo "\"/>\n            </td>\n        </tr>\n        <tr>\n            <th>Currency Code<br/><span>List of available MercadoPago currencies:\n                <ul>\n                    <li>ARS - Argentine peso</li>\n                    <li>BRL - Brazilian real</li>\n                    <li>VEF - Venezuelan strong bolivar</li>\n                    <li>CLP - Chilean peso</li>\n                    <li>MXN - Mexican peso</li>\n                    <li>COP - Colombian peso</li>\n                    <li>PEN - Peruvian sol</li>\n                    <li>UYU - Uruguayan peso</li>\n                </ul></span>\n            </th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"mercadopago_currency\" value=\"";
echo mconfig("mercadopago_currency");
echo "\"/>\n            </td>\n        </tr>\n        <tr>\n            <th>Success URL<br/><span>URL where the client will be redirected to if the donation is completed.<br/><br/> By default it has to be in: <b>http://YOURWEBSITE.COM/donation/mercadopago?type=success</b></span>\n            </th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"mercadopago_success_url\" value=\"";
echo mconfig("mercadopago_success_url");
echo "\"/>\n            </td>\n        </tr>\n        <tr>\n            <th>Failure\n                URL<br/><span>URL where the client will be redirected to if the donation failed.<br/><br/> By default it has to be in: <b>http://YOURWEBSITE.COM/donation/mercadopago?type=fail</b></span>\n            </th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"mercadopago_failure_url\" value=\"";
echo mconfig("mercadopago_failure_url");
echo "\"/>\n            </td>\n        </tr>\n        <tr>\n            <th>Pending URL<br/><span>URL where the client will be redirected to if the donation is pending.<br/><br/> By default it has to be in: <b>http://YOURWEBSITE.COM/donation/mercadopago?type=pending</b></span>\n            </th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"mercadopago_pending_url\" value=\"";
echo mconfig("mercadopago_pending_url");
echo "\"/>\n            </td>\n        </tr>\n        <tr>\n            <th>IPN Notify URL<br/><span>URL of ImperiaMuCMS's MercadoPago API.<br/><br/> By default it has to be in: <b>http://YOURWEBSITE.COM/api/mercadopago/mercadopago_ipn.php</b></span></th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"mercadopago_notify_url\" value=\"";
echo mconfig("mercadopago_notify_url");
echo "\"/>\n            </td>\n        </tr>\n        <tr>\n            <th>Minimal Donation Amount<br/><span>.</span></th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"mercadopago_min\" value=\"";
echo mconfig("mercadopago_min");
echo "\"/>\n            </td>\n        </tr>\n        <tr>\n            <th>Credits Conversion Rate<br/><span>How many game credits is equivalent to 1 of real money currency.<br/><br/>Example:<br/>1 USD = 100 Credits, in this example you would type in the box 100.</span>\n            </th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"mercadopago_conversion_rate\" value=\"";
echo mconfig("mercadopago_conversion_rate");
echo "\"/>\n            </td>\n        </tr>\n\n        <tr>\n            <th>Bonus Amount #1<br/><span>If donation amount will be higher than this value, player will gets bonus credits in % configured below.</span>\n            </th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"mercadopago_bonus_amount1\" value=\"";
echo mconfig("mercadopago_bonus_amount1");
echo "\"/>\n            </td>\n        </tr>\n        <tr>\n            <th>Bonus Percentage #1<br/><span>If donation amount will be higher than value above, player will gets bonus credits in %.</span>\n            </th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"mercadopago_bonus_perc1\" value=\"";
echo mconfig("mercadopago_bonus_perc1");
echo "\" style=\"display: inline; width: 150px\"/>%\n            </td>\n        </tr>\n        <tr>\n            <th>Bonus Amount #2<br/><span>If donation amount will be higher than this value, player will gets bonus credits in % configured below.</span>\n            </th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"mercadopago_bonus_amount2\" value=\"";
echo mconfig("mercadopago_bonus_amount2");
echo "\"/>\n            </td>\n        </tr>\n        <tr>\n            <th>Bonus Percentage #2<br/><span>If donation amount will be higher than value above, player will gets bonus credits in %.</span>\n            </th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"mercadopago_bonus_perc2\" value=\"";
echo mconfig("mercadopago_bonus_perc2");
echo "\" style=\"display: inline; width: 150px\"/>%\n            </td>\n        </tr>\n        <tr>\n            <th>Bonus Amount #3<br/><span>If donation amount will be higher than this value, player will gets bonus credits in % configured below.</span>\n            </th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"mercadopago_bonus_amount3\" value=\"";
echo mconfig("mercadopago_bonus_amount3");
echo "\"/>\n            </td>\n        </tr>\n        <tr>\n            <th>Bonus Percentage #3<br/><span>If donation amount will be higher than value above, player will gets bonus credits in %.</span>\n            </th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"mercadopago_bonus_perc3\" value=\"";
echo mconfig("mercadopago_bonus_perc3");
echo "\" style=\"display: inline; width: 150px\"/>%\n            </td>\n        </tr>\n        <tr>\n            <th>Bonus Amount #4<br/><span>If donation amount will be higher than this value, player will gets bonus credits in % configured below.</span>\n            </th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"mercadopago_bonus_amount4\" value=\"";
echo mconfig("mercadopago_bonus_amount4");
echo "\"/>\n            </td>\n        </tr>\n        <tr>\n            <th>Bonus Percentage #4<br/><span>If donation amount will be higher than value above, player will gets bonus credits in %.</span>\n            </th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"mercadopago_bonus_perc4\" value=\"";
echo mconfig("mercadopago_bonus_perc4");
echo "\" style=\"display: inline; width: 150px\"/>%\n            </td>\n        </tr>\n        <tr>\n            <th>Bonus Amount #5<br/><span>If donation amount will be higher than this value, player will gets bonus credits in % configured below.</span>\n            </th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"mercadopago_bonus_amount5\" value=\"";
echo mconfig("mercadopago_bonus_amount5");
echo "\"/>\n            </td>\n        </tr>\n        <tr>\n            <th>Bonus Percentage #5<br/><span>If donation amount will be higher than value above, player will gets bonus credits in %.</span>\n            </th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"mercadopago_bonus_perc5\" value=\"";
echo mconfig("mercadopago_bonus_perc5");
echo "\" style=\"display: inline; width: 150px\"/>%\n            </td>\n        </tr>\n\n        <tr>\n            <th>Credit Configuration<br/><span></span></th>\n            <td>\n                ";
echo $creditSystem->buildSelectInput("credit_config", mconfig("credit_config"), "form-control");
echo "            </td>\n        </tr>\n        <tr>\n            <td colspan=\"2\"><input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\" class=\"btn btn-success\"/>\n            </td>\n        </tr>\n    </table>\n</form>";
function saveChanges()
{
    
    foreach ($_POST as $setting) {
        if (!check_value($setting)) {
            message("error", "Missing data (complete all fields).");
            return NULL;
        }
    }
    $xmlPath = __PATH_MODULE_CONFIGS__ . "donation.mercadopago.xml";
    $xml = simplexml_load_file($xmlPath);
    $xml->active = $_POST["mercadopago_active"];
    $xml->mercadopago_enable_sandbox = $_POST["mercadopago_enable_sandbox"];
    $xml->mercadopago_client_id = $_POST["mercadopago_client_id"];
    $xml->mercadopago_client_secret = $_POST["mercadopago_client_secret"];
    $xml->mercadopago_access_token = $_POST["mercadopago_access_token"];
    $xml->mercadopago_title = $_POST["mercadopago_title"];
    $xml->mercadopago_currency = $_POST["mercadopago_currency"];
    $xml->mercadopago_success_url = $_POST["mercadopago_success_url"];
    $xml->mercadopago_failure_url = $_POST["mercadopago_failure_url"];
    $xml->mercadopago_pending_url = $_POST["mercadopago_pending_url"];
    $xml->mercadopago_notify_url = $_POST["mercadopago_notify_url"];
    $xml->mercadopago_min = $_POST["mercadopago_min"];
    $xml->mercadopago_conversion_rate = $_POST["mercadopago_conversion_rate"];
    $xml->mercadopago_bonus_amount1 = $_POST["mercadopago_bonus_amount1"];
    $xml->mercadopago_bonus_perc1 = $_POST["mercadopago_bonus_perc1"];
    $xml->mercadopago_bonus_amount2 = $_POST["mercadopago_bonus_amount2"];
    $xml->mercadopago_bonus_perc2 = $_POST["mercadopago_bonus_perc2"];
    $xml->mercadopago_bonus_amount3 = $_POST["mercadopago_bonus_amount3"];
    $xml->mercadopago_bonus_perc3 = $_POST["mercadopago_bonus_perc3"];
    $xml->mercadopago_bonus_amount4 = $_POST["mercadopago_bonus_amount4"];
    $xml->mercadopago_bonus_perc4 = $_POST["mercadopago_bonus_perc4"];
    $xml->mercadopago_bonus_amount5 = $_POST["mercadopago_bonus_amount5"];
    $xml->mercadopago_bonus_perc5 = $_POST["mercadopago_bonus_perc5"];
    $xml->credit_config = $_POST["credit_config"];
    $save2 = $xml->asXML($xmlPath);
    if ($save2) {
        message("success", "[MercadoPago] Settings successfully saved.");
    } else {
        message("error", "[MercadoPago] There has been an error while saving changes.");
    }
}

?>