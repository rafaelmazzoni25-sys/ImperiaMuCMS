<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h2>Adventures Settings</h2>\r\n";
if (check_value($_POST["submit_changes"])) {
    savechanges();
}
$General = new xGeneral();
if (check_value($_POST["activate_module"])) {
    $key = $_POST["license_key"];
    $General->jIhfnHDm_activate_KdiupmNBd_Module("adventures", $key);
}
$isActivated = $General->jHdksHgYYix_isModule_hDbMVOIfs_Activated("adventures");
if (!$isActivated) {
    echo "\r\n    <form method=\"post\" action=\"\">\r\n        <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n            <tr>\r\n                <th>License Key<br/><span></span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"license_key\" value=\"\" size=\"30\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td colspan=\"2\"><input type=\"submit\" name=\"activate_module\" value=\"Activate Module\" class=\"btn btn-success\"/>\r\n                </td>\r\n            </tr>\r\n        </table>\r\n    </form>";
} else {
    loadModuleConfigs("usercp.adventures");
    echo "    <form action=\"\" method=\"post\">\r\n        <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n            <tr>\r\n                <th>Status<br/><span>Enable/disable the dual stats module.</span></th>\r\n                <td>\r\n                    ";
    enabledisableCheckboxes("active", mconfig("active"), "Enabled", "Disabled");
    echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Share Tokens<br/><span>If \"Yes\" then tokens will be traced on Account. If \"No\" then tokens will be traced on each character.</span></th>\r\n                <td>\r\n                    ";
    enabledisableCheckboxes2("share_tokens", mconfig("share_tokens"), "Yes", "No");
    echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Max. Tokens<br/><span>Enter maximum tokens what can be hold per account/character.</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"max_tokens\" value=\"";
    echo mconfig("max_tokens");
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Token Refill<br/><span>Enter period in hours when tokens will be added on account/character.</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"token_refill\" value=\"";
    echo mconfig("token_refill");
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Token Refill Amount<br/><span>Enter amount of token(s) what will be added on refill period.</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"token_refill_amount\" value=\"";
    echo mconfig("token_refill_amount");
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td colspan=\"2\"><input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\" class=\"btn btn-success\"/>\r\n                </td>\r\n            </tr>\r\n        </table>\r\n    </form>\r\n\r\n";
}
function saveChanges()
{
    
    foreach ($_POST as $setting) {
        if (!check_value($setting)) {
            message("error", "Missing data (complete all fields).");
            return NULL;
        }
    }
    $xmlPath = __PATH_MODULE_CONFIGS__ . "usercp.adventures.xml";
    $xml = simplexml_load_file($xmlPath);
    $xml->active = $_POST["active"];
    $xml->max_tokens = $_POST["max_tokens"];
    $xml->share_tokens = $_POST["share_tokens"];
    $xml->token_refill = $_POST["token_refill"];
    $xml->token_refill_amount = $_POST["token_refill_amount"];
    $save = $xml->asXML($xmlPath);
    if ($save) {
        message("success", "Settings successfully saved.");
    } else {
        message("error", "There has been an error while saving changes.");
    }
}

?>