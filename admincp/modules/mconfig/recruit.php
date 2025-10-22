<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h2>Recruit a Friend Settings</h2>\r\n";
if (check_value($_POST["submit_changes"])) {
    savechanges();
}
loadModuleConfigs("usercp.recruit");
$creditSystem = new CreditSystem($common, new Character(), $dB, $dB2);
echo "<form action=\"\" method=\"post\">\r\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n        <tr>\r\n            <th>Status<br/><span>Enable/disable the recruit module.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_1", mconfig("active"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Limit<br/><span>Number of players for who will be inviter rewarded.</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_2\" value=\"";
echo mconfig("limit");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Required Level #1<br/><span>Required level to get Reward #1.</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_6\" value=\"";
echo mconfig("req1_level");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Required Master Level #1<br/><span>Required master level to get Reward #1.</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_7\" value=\"";
echo mconfig("req1_mlevel");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Required Resets #1<br/><span>Required resets to get Reward #1.</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_3\" value=\"";
echo mconfig("req1_resets");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Reward #1<br/><span>Reward for both players - inviter and invited.</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_4\" value=\"";
echo mconfig("reward1");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Credit Configuration<br/><span></span></th>\r\n            <td>\r\n                ";
echo $creditSystem->buildSelectInput("setting_5", mconfig("credit_config"), "form-control");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan=\"2\"><input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\" class=\"btn btn-success\"/>\r\n            </td>\r\n        </tr>\r\n    </table>\r\n</form>";
function saveChanges()
{
    
    foreach ($_POST as $setting) {
        if (!check_value($setting)) {
            message("error", "Missing data (complete all fields).");
            return NULL;
        }
    }
    $xmlPath = __PATH_MODULE_CONFIGS__ . "usercp.recruit.xml";
    $xml = simplexml_load_file($xmlPath);
    $xml->active = $_POST["setting_1"];
    $xml->limit = $_POST["setting_2"];
    $xml->req1_resets = $_POST["setting_3"];
    $xml->req1_level = $_POST["setting_6"];
    $xml->req1_mlevel = $_POST["setting_7"];
    $xml->reward1 = $_POST["setting_4"];
    $xml->credit_config = $_POST["setting_5"];
    $save = $xml->asXML($xmlPath);
    if ($save) {
        message("success", "Settings successfully saved.");
    } else {
        message("error", "There has been an error while saving changes.");
    }
}

?>