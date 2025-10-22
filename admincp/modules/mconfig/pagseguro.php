<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h1 class=\"page-header\">PagSeguro Settings</h1>\n";
if (check_value($_POST["submit_changes"])) {
    savechanges();
}
loadModuleConfigs("donation.pagseguro");
$creditSystem = new CreditSystem($common, new Character(), $dB, $dB2);
message("warning", "You must manually configure PagSeguro: <strong>/includes/PagSeguroLibrary/config/PagSeguroConfig.php</strong>", "NOTE:");
echo "<form action=\"\" method=\"post\">\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\n        <tr>\n            <th>Status<br/><span>Enable/disable the PagSeguro donation gateway.</span></th>\n            <td>\n                ";
enabledisableCheckboxes("setting_27", mconfig("active"), "Enabled", "Disabled");
echo "            </td>\n        </tr>\n        <tr>\n            <th>PagSeguro Email<br/><span>PagSeguro email where you will receive the donations.</span></th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"setting_28\" value=\"";
echo mconfig("pgseguro_email");
echo "\"/>\n            </td>\n        </tr>\n        <tr>\n            <th>PagSeguro Token<br/><span>Your PagSeguro token.</span></th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"setting_33\" value=\"";
echo mconfig("pgseguro_token");
echo "\"/>\n            </td>\n        </tr>\n        <tr>\n            <th>PagSeguro Donations\n                Title<br/><span>Title of the PagSeguro donation. Example: \"Donation for MU Credits\".</span></th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"setting_29\"\n                       value=\"";
echo mconfig("pgseguro_itemtitle");
echo "\"/>\n            </td>\n        </tr>\n        <tr>\n            <th>Currency Code<br/><span></span></th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"setting_30\" value=\"";
echo mconfig("pgseguro_currency");
echo "\"/>\n            </td>\n        </tr>\n        <tr>\n            <th>Credits Conversion\n                Rate<br/><span>How many game credits is equivalent to 1 of real money currency.<br/><br/>Example:<br/>1 USD = 100 Credits, in this example you would type in the box 100.</span>\n            </th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"setting_31\"\n                       value=\"";
echo mconfig("pgseguro_conversion_rate");
echo "\"/>\n            </td>\n        </tr>\n        <tr>\n            <th>Credit Configuration<br/><span></span></th>\n            <td>\n                ";
echo $creditSystem->buildSelectInput("setting_32", mconfig("credit_config"), "form-control");
echo "            </td>\n        </tr>\n        <tr>\n            <td colspan=\"2\"><input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\" class=\"btn btn-success\"/>\n            </td>\n        </tr>\n    </table>\n</form>";
function saveChanges()
{
    
    foreach ($_POST as $setting) {
        if (!check_value($setting)) {
            message("error", "Missing data (complete all fields).");
            return NULL;
        }
    }
    $xmlPath = __PATH_MODULE_CONFIGS__ . "donation.pagseguro.xml";
    $xml = simplexml_load_file($xmlPath);
    $xml->active = $_POST["setting_27"];
    $xml->pgseguro_email = $_POST["setting_28"];
    $xml->pgseguro_token = $_POST["setting_33"];
    $xml->pgseguro_itemtitle = $_POST["setting_29"];
    $xml->pgseguro_currency = $_POST["setting_30"];
    $xml->pgseguro_conversion_rate = $_POST["setting_31"];
    $xml->credit_config = $_POST["setting_32"];
    $save5 = $xml->asXML($xmlPath);
    if ($save5) {
        message("success", "[PagSeguro] Settings successfully saved.");
    } else {
        message("error", "[PagSeguro] There has been an error while saving changes.");
    }
}

?>