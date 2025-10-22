<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h2>News Settings</h2>\r\n";
if (check_value($_POST["submit_changes"])) {
    savechanges();
}
loadModuleConfigs("news");
echo "<form action=\"\" method=\"post\">\r\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n        <tr>\r\n            <th>Status<br/><span>Enable/disable the news module.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_1", mconfig("active"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Expanded News<br/><span>Amount of news you want to display expanded. If less than the display news limit configuration, then the rest of the news will not display expanded.</span>\r\n            </th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_2\" value=\"";
echo mconfig("news_expanded");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Shown News Limit<br/><span>Amount of news to display in the news page.</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_3\" value=\"";
echo mconfig("news_list_limit");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>News Type<br/><span>Choose type of news.</span></th>\r\n            <td>\r\n                <select name=\"news_type\" class=\"form-control\">\r\n                    ";
if (mconfig("news_type") == "1") {
    echo "<option value=\"1\" selected=\"selected\">Collapsible</option>";
} else {
    echo "<option value=\"1\">Collapsible</option>";
}
if (mconfig("news_type") == "2") {
    echo "<option value=\"2\" selected=\"selected\">Standard (News body always visible)</option>";
} else {
    echo "<option value=\"2\">Standard (News body always visible)</option>";
}
echo "                </select>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>History News per Page<br/><span>Number of news which will be displayed on one page in news history.</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"news_per_page\" value=\"";
echo mconfig("news_per_page");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Comments<br/><span>Enable/disable Facebook's comment system.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_4", mconfig("news_enable_comment_system"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Like and Share<br/><span>Enable/disable Facebook's like and share buttons.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_5", mconfig("news_enable_like_button"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Facebook App ID<br/><span>If you want to use FB like & comments, you must have your own app id.</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_6\" value=\"";
echo mconfig("facebook_app_id");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan=\"2\"><input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\" class=\"btn btn-success\"/>\r\n            </td>\r\n        </tr>\r\n    </table>\r\n</form>";
function saveChanges()
{
    
    foreach ($_POST as $setting) {
        if (!check_value($setting)) {
            message("error", "Missing data (complete all fields).");
            return NULL;
        }
    }
    $xmlPath = __PATH_MODULE_CONFIGS__ . "news.xml";
    $xml = simplexml_load_file($xmlPath);
    $xml->active = $_POST["setting_1"];
    $xml->news_expanded = $_POST["setting_2"];
    $xml->news_list_limit = $_POST["setting_3"];
    $xml->news_type = $_POST["news_type"];
    $xml->news_per_page = $_POST["news_per_page"];
    $xml->news_enable_comment_system = $_POST["setting_4"];
    $xml->news_enable_like_button = $_POST["setting_5"];
    $xml->facebook_app_id = $_POST["setting_6"];
    $save = $xml->asXML($xmlPath);
    if ($save) {
        message("success", "Settings successfully saved.");
    } else {
        message("error", "There has been an error while saving changes.");
    }
}

?>