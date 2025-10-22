<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h2>Guides Settings</h2>\r\n";
if (check_value($_POST["submit_changes"])) {
    savechanges();
}
loadModuleConfigs("guides");
$guides = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_GUIDES ORDER BY title");
$options = "<option value=\"\">-- None --</option>";
foreach ($guides as $guide) {
    if (mconfig("default_guide") == $guide["id"]) {
        $options .= "<option value=\"" . $guide["id"] . "\" selected=\"selected\">" . $guide["title"] . "</option>";
    } else {
        $options .= "<option value=\"" . $guide["id"] . "\">" . $guide["title"] . "</option>";
    }
}
echo "<form action=\"\" method=\"post\">\r\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n        <tr>\r\n            <th>Status<br/><span>Enable/disable guides module.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_1", mconfig("active"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Default Guide<br/><span>Select default guide what will be loaded.</span></th>\r\n            <td>\r\n                <select name=\"setting_2\" class=\"form-control\">\r\n                    ";
echo $options;
echo "                </select>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan=\"2\"><input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\" class=\"btn btn-success\"/>\r\n            </td>\r\n        </tr>\r\n    </table>\r\n</form>";
function saveChanges()
{
    $_POST;
    foreach ($_POST as $setting) {
        if (!check_value($setting)) {
            message("error", "Missing data (complete all fields).");
            return NULL;
        }
    }
    $xmlPath = __PATH_MODULE_CONFIGS__ . "guides.xml";
    $xml = simplexml_load_file($xmlPath);
    $xml->active = $_POST["setting_1"];
    $xml->default_guide = $_POST["setting_2"];
    $save = $xml->asXML($xmlPath);
    if ($save) {
        message("success", "Settings successfully saved.");
    } else {
        message("error", "There has been an error while saving changes.");
    }
}

?>