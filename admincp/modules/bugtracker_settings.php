<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h2>Bug Tracker: Settings</h2>\r\n";
if (check_value($_POST["submit_changes"])) {
    savechanges();
}
loadModuleConfigs("bugtracker");
echo "<form action=\"\" method=\"post\">\r\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n        <tr>\r\n            <th>Status<br/><span>Enable/disable the registration module.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_1", mconfig("active"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Is reward<br/><span>If enabled players will get reward after report will be approved by administrator.</span>\r\n            </th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_2", mconfig("isreward"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Reward Type<br/><span></span>\r\n            </th>\r\n            <td>\r\n                <select name=\"setting_5\" class=\"form-control\">\r\n                    ";
if (mconfig("reward_type") == "1") {
    echo "<option value=\"1\" selected=\"selected\">Platinum Coins</option>";
} else {
    echo "<option value=\"1\">Platinum Coins</option>";
}
if (mconfig("reward_type") == "2") {
    echo "<option value=\"2\" selected=\"selected\">Gold Coins</option>";
} else {
    echo "<option value=\"2\">Gold Coins</option>";
}
if (mconfig("reward_type") == "3") {
    echo "<option value=\"3\" selected=\"selected\">Silver Coins</option>";
} else {
    echo "<option value=\"3\">Silver Coins</option>";
}
if (mconfig("reward_type") == "4") {
    echo "<option value=\"4\" selected=\"selected\">WCoins</option>";
} else {
    echo "<option value=\"4\">WCoins</option>";
}
if (mconfig("reward_type") == "5") {
    echo "<option value=\"5\" selected=\"selected\">GoblinPoints</option>";
} else {
    echo "<option value=\"5\">GoblinPoints</option>";
}
if (mconfig("reward_type") == "6") {
    echo "<option value=\"6\" selected=\"selected\">Zen</option>";
} else {
    echo "<option value=\"6\">Zen</option>";
}
echo "                </select>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Reward Value<br/><span>If \"Is reward\" is enabled, players will get reward after report will be approved by administrator. Reward is in selected currency.</span>\r\n            </th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_3\" value=\"";
echo mconfig("reward_value");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Staff Nickname<br/><span>Max. 50 characters</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_4\" value=\"";
echo mconfig("staff_nickname");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Hide Names<br/><span>If enabled, players' account names won't be displayed.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_11", mconfig("hide_names"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Title Min. Length<br/><span>Use values from interval 1 - 100.</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_6\" value=\"";
echo mconfig("title_min");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Title Max. Length<br/><span>Use values from interval 1 - 100.</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_7\" value=\"";
echo mconfig("title_max");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Text Min. Length<br/><span>Use values from interval 1 - 10000.</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_8\" value=\"";
echo mconfig("text_min");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Text Max. Length<br/><span>Use values from interval 1 - 10000.</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_9\" value=\"";
echo mconfig("text_max");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Comment only own Reports<br/><span>If enabled, players will be able to comment only own reports.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_10", mconfig("reply_only_own"), "Yes", "No");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan=\"2\"><input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\" class=\"btn btn-success\"/>\r\n            </td>\r\n        </tr>\r\n    </table>\r\n</form>";
function saveChanges()
{
    foreach ($_POST as $setting) {
        if (!check_value($setting)) {
            message("error", "Missing data (complete all fields).");
            return NULL;
        }
    }
    $xmlPath = __PATH_MODULE_CONFIGS__ . "bugtracker.xml";
    $xml = simplexml_load_file($xmlPath);
    $xml->active = $_POST["setting_1"];
    $xml->isreward = $_POST["setting_2"];
    $xml->reward_type = $_POST["setting_5"];
    $xml->reward_value = $_POST["setting_3"];
    $xml->staff_nickname = $_POST["setting_4"];
    $xml->hide_names = $_POST["setting_11"];
    $xml->title_min = $_POST["setting_6"];
    $xml->title_max = $_POST["setting_7"];
    $xml->text_min = $_POST["setting_8"];
    $xml->text_max = $_POST["setting_9"];
    $xml->reply_only_own = $_POST["setting_10"];
    $save = $xml->asXML($xmlPath);
    if ($save) {
        message("success", "Settings successfully saved.");
    } else {
        message("error", "There has been an error while saving changes.");
    }
}

?>