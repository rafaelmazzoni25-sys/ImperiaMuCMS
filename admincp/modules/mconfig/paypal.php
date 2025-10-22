<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h1 class=\"page-header\">PayPal Settings</h1>\n";
if (check_value($_POST["submit_changes"])) {
    savechanges();
}
loadModuleConfigs("donation.paypal");
$creditSystem = new CreditSystem($common, new Character(), $dB, $dB2);
echo "<form action=\"\" method=\"post\">\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\n        <tr>\n            <th>Status<br/><span>Enable/disable the paypal donation gateway.</span></th>\n            <td>\n                ";
enabledisableCheckboxes("setting_2", mconfig("active"), "Enabled", "Disabled");
echo "            </td>\n        </tr>\n        <tr>\n            <th>PayPal Sandbox Mode<br/><span>Enable/disable PayPal's IPN testing mode.<br/><br/>More info:<br/><a href=\"https://developer.paypal.com/\"\n                                                                                                                   target=\"_blank\">https://developer.paypal.com/</a></span>\n            </th>\n            <td>\n                ";
enabledisableCheckboxes("setting_3", mconfig("paypal_enable_sandbox"), "Enabled", "Disabled");
echo "            </td>\n        </tr>\n        <tr>\n            <th>PayPal Email<br/><span>PayPal email where you will receive the donations.</span></th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"setting_4\" value=\"";
echo mconfig("paypal_email");
echo "\"/>\n            </td>\n        </tr>\n        <tr>\n            <th>PayPal Image<br/><span>Image what will be shown on PayPal checkout page.<br>Use \"none\" if you want to show email address or valid link to image if you want to show image.<br>\n                The image's maximum size is 750 pixels wide by 90 pixels high. PayPal recommends that you provide an image that is stored only on a secure (https) server. </span></th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"setting_18\" value=\"";
echo mconfig("paypal_image");
echo "\"/>\n            </td>\n        </tr>\n        <tr>\n            <th>PayPal Donations Title<br/><span>Title of the PayPal donation. Example: \"Donation for MU Credits\".</span></th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"setting_5\" value=\"";
echo mconfig("paypal_title");
echo "\"/>\n            </td>\n        </tr>\n        <tr>\n            <th>Currency Code<br/><span>List of available PayPal currencies: <a href=\"https://cms.paypal.com/uk/cgi-bin/?cmd=_render-content&content_ID=developer/e_howto_api_nvp_currency_codes\"\n                                                                                target=\"_blank\">click here</a>.</span></th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"setting_6\" value=\"";
echo mconfig("paypal_currency");
echo "\"/>\n            </td>\n        </tr>\n        <tr>\n            <th>Return URL<br/><span>URL where the client will be redirected to if the donation is completed.</span></th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"setting_7\" value=\"";
echo mconfig("paypal_return_url");
echo "\"/>\n            </td>\n        </tr>\n        <tr>\n            <th>Cancel URL<br/><span>URL where the client will be redirected to if the donation is cancelled.</span>\n            </th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"setting_19\" value=\"";
echo mconfig("paypal_cancel_url");
echo "\"/>\n            </td>\n        </tr>\n        <tr>\n            <th>IPN Notify URL<br/><span>URL of ImperiaMuCMS's PayPal API.<br/><br/> By default it has to be in: <b>http://YOURWEBSITE.COM/api/paypal.php</b></span></th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"setting_8\" value=\"";
echo mconfig("paypal_notify_url");
echo "\"/>\n            </td>\n        </tr>\n        <tr>\n            <th>Minimal Donation Amount<br/><span>.</span></th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"setting_17\" value=\"";
echo mconfig("paypal_min");
echo "\"/>\n            </td>\n        </tr>\n        <tr>\n            <th>Credits Conversion Rate<br/><span>How many game credits is equivalent to 1 of real money currency.<br/><br/>Example:<br/>1 USD = 100 Credits, in this example you would type in the box 100.</span>\n            </th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"setting_9\" value=\"";
echo mconfig("paypal_conversion_rate");
echo "\"/>\n            </td>\n        </tr>\n\n        <tr>\n            <th>Bonus Amount #1<br/><span>If donation amount will be higher than this value, player will gets bonus credits in % configured below.</span>\n            </th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"setting_11\" value=\"";
echo mconfig("paypal_bonus_amount1");
echo "\"/>\n            </td>\n        </tr>\n        <tr>\n            <th>Bonus Percentage #1<br/><span>If donation amount will be higher than value above, player will gets bonus credits in %.</span>\n            </th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"setting_12\" value=\"";
echo mconfig("paypal_bonus_perc1");
echo "\" style=\"display: inline; width: 150px\"/>%\n            </td>\n        </tr>\n        <tr>\n            <th>Bonus Amount #2<br/><span>If donation amount will be higher than this value, player will gets bonus credits in % configured below.</span>\n            </th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"setting_13\" value=\"";
echo mconfig("paypal_bonus_amount2");
echo "\"/>\n            </td>\n        </tr>\n        <tr>\n            <th>Bonus Percentage #2<br/><span>If donation amount will be higher than value above, player will gets bonus credits in %.</span>\n            </th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"setting_14\" value=\"";
echo mconfig("paypal_bonus_perc2");
echo "\" style=\"display: inline; width: 150px\"/>%\n            </td>\n        </tr>\n        <tr>\n            <th>Bonus Amount #3<br/><span>If donation amount will be higher than this value, player will gets bonus credits in % configured below.</span>\n            </th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"setting_15\" value=\"";
echo mconfig("paypal_bonus_amount3");
echo "\"/>\n            </td>\n        </tr>\n        <tr>\n            <th>Bonus Percentage #3<br/><span>If donation amount will be higher than value above, player will gets bonus credits in %.</span>\n            </th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"setting_16\" value=\"";
echo mconfig("paypal_bonus_perc3");
echo "\" style=\"display: inline; width: 150px\"/>%\n            </td>\n        </tr>\n        <tr>\n            <th>Bonus Amount #4<br/><span>If donation amount will be higher than this value, player will gets bonus credits in % configured below.</span>\n            </th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"setting_20\" value=\"";
echo mconfig("paypal_bonus_amount4");
echo "\"/>\n            </td>\n        </tr>\n        <tr>\n            <th>Bonus Percentage #4<br/><span>If donation amount will be higher than value above, player will gets bonus credits in %.</span>\n            </th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"setting_21\" value=\"";
echo mconfig("paypal_bonus_perc4");
echo "\" style=\"display: inline; width: 150px\"/>%\n            </td>\n        </tr>\n        <tr>\n            <th>Bonus Amount #5<br/><span>If donation amount will be higher than this value, player will gets bonus credits in % configured below.</span>\n            </th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"setting_22\" value=\"";
echo mconfig("paypal_bonus_amount5");
echo "\"/>\n            </td>\n        </tr>\n        <tr>\n            <th>Bonus Percentage #5<br/><span>If donation amount will be higher than value above, player will gets bonus credits in %.</span>\n            </th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"setting_23\" value=\"";
echo mconfig("paypal_bonus_perc5");
echo "\" style=\"display: inline; width: 150px\"/>%\n            </td>\n        </tr>\n\n        <tr>\n            <th>Credit Configuration<br/><span></span></th>\n            <td>\n                ";
echo $creditSystem->buildSelectInput("setting_10", mconfig("credit_config"), "form-control");
echo "            </td>\n        </tr>\n        <tr>\n            <td colspan=\"2\"><input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\" class=\"btn btn-success\"/>\n            </td>\n        </tr>\n    </table>\n</form>";
function saveChanges()
{
    
    foreach ($_POST as $setting) {
        if (!check_value($setting)) {
            message("error", "Missing data (complete all fields).");
            return NULL;
        }
    }
    $xmlPath = __PATH_MODULE_CONFIGS__ . "donation.paypal.xml";
    $xml = simplexml_load_file($xmlPath);
    $xml->active = $_POST["setting_2"];
    $xml->paypal_enable_sandbox = $_POST["setting_3"];
    $xml->paypal_email = $_POST["setting_4"];
    $xml->paypal_image = $_POST["setting_18"];
    $xml->paypal_title = $_POST["setting_5"];
    $xml->paypal_currency = $_POST["setting_6"];
    $xml->paypal_return_url = $_POST["setting_7"];
    $xml->paypal_cancel_url = $_POST["setting_19"];
    $xml->paypal_notify_url = $_POST["setting_8"];
    $xml->paypal_min = $_POST["setting_17"];
    $xml->paypal_conversion_rate = $_POST["setting_9"];
    $xml->paypal_bonus_amount1 = $_POST["setting_11"];
    $xml->paypal_bonus_perc1 = $_POST["setting_12"];
    $xml->paypal_bonus_amount2 = $_POST["setting_13"];
    $xml->paypal_bonus_perc2 = $_POST["setting_14"];
    $xml->paypal_bonus_amount3 = $_POST["setting_15"];
    $xml->paypal_bonus_perc3 = $_POST["setting_16"];
    $xml->paypal_bonus_amount4 = $_POST["setting_20"];
    $xml->paypal_bonus_perc4 = $_POST["setting_21"];
    $xml->paypal_bonus_amount5 = $_POST["setting_22"];
    $xml->paypal_bonus_perc5 = $_POST["setting_23"];
    $xml->credit_config = $_POST["setting_10"];
    $save2 = $xml->asXML($xmlPath);
    if ($save2) {
        message("success", "[PayPal] Settings successfully saved.");
    } else {
        message("error", "[PayPal] There has been an error while saving changes.");
    }
}

?>