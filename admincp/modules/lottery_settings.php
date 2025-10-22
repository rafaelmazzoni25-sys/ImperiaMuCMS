<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h2>Lottery Settings</h2>\r\n";
$General = new xGeneral();
if (check_value($_POST["activate_module"])) {
    $key = $_POST["license_key"];
    $General->jIhfnHDm_activate_KdiupmNBd_Module("lottery", $key);
}
$isActivated = $General->jHdksHgYYix_isModule_hDbMVOIfs_Activated("lottery");
if (check_value($_POST["submit_changes"])) {
    savechanges();
}
if (!$isActivated) {
    echo "\r\n    <form method=\"post\" action=\"\">\r\n        <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n            <tr>\r\n                <th>License Key<br/><span></span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"license_key\" value=\"\" size=\"30\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td colspan=\"2\"><input type=\"submit\" name=\"activate_module\" value=\"Activate Module\" class=\"btn btn-success\"/>\r\n                </td>\r\n            </tr>\r\n        </table>\r\n    </form>";
} else {
    loadModuleConfigs("usercp.lottery");
    $creditSystem = new CreditSystem($common, new Character(), $dB, $dB2);
    echo "    <form action=\"\" method=\"post\">\r\n        <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n            <tr>\r\n                <th>Status<br/><span>Enable/disable the lottery module.</span></th>\r\n                <td>\r\n                    ";
    enabledisableCheckboxes("setting_1", mconfig("active"), "Enabled", "Disabled");
    echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Lottery Start<br/><span>Date is used if selected 1 or 2 weeks period, format YYYY-mm-dd</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"setting_0\" value=\"";
    echo mconfig("lottery_start");
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Lottery History<br/><span>Shows in UserCP latest drawns</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"setting_16\" value=\"";
    echo mconfig("lottery_history");
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Period<br/><span>1 week = every 7 days, starts from \"Lottery Start\"<br>\r\n                            2 weeks = every 14 days, starts from \"Lottery Start\"<br>\r\n                            1 month = lottery ends in the last day of month</span></th>\r\n                <td>\r\n                    <select name=\"setting_2\" class=\"form-control\">\r\n                        ";
    if (mconfig("lottery_length") == 7) {
        echo "<option value=\"7\" selected=\"selected\">1 week</option>";
    } else {
        echo "<option value=\"7\">1 week</option>";
    }
    if (mconfig("lottery_length") == 14) {
        echo "<option value=\"14\" selected=\"selected\">2 weeks</option>";
    } else {
        echo "<option value=\"14\">2 weeks</option>";
    }
    if (mconfig("lottery_length") == 30) {
        echo "<option value=\"30\" selected=\"selected\">1 month</option>";
    } else {
        echo "<option value=\"30\">1 month</option>";
    }
    echo "                    </select>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Type<br/><span>Static = Rewards are static, for example, if 1st prize is 1,000 credits and we will have 3 winners, they will get 1,000 credits each<br>\r\n                               Dynamic = Rewards are dynamic, for example, if 1st prize is 1,500 credits and we will have 3 winners, they will get 500 credits each (1500 / 3 = 500)</span></th>\r\n                <td>\r\n                    ";
    enabledisableCheckboxes2("setting_3", mconfig("lottery_type"), "Dynamic", "Static");
    echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Lottery Guess Number Min.<br/><span>Valid values 1 - 32,767, must be lower than max. number</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"setting_4\" value=\"";
    echo mconfig("lottery_min_num");
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Lottery Guess Number Max.<br/><span>Valid values 1 - 32,767, must be greater than min. number</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"setting_5\" value=\"";
    echo mconfig("lottery_max_num");
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Tickets Limit<br/></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"setting_6\" value=\"";
    echo mconfig("lottery_ticket_limit");
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Ticket Price<br/><span>0 = free</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"setting_7\" value=\"";
    echo mconfig("lottery_ticket_price");
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Ticket Price Type<br/><span></span></th>\r\n                <td>\r\n                    ";
    echo $creditSystem->buildSelectInput("setting_8", mconfig("lottery_ticket_price_type"), "form-control");
    echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>1st Prize (6/6 numbers match)<br/></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"setting_9\" value=\"";
    echo mconfig("lottery_1st_prize");
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>2nd Prize (5/6 numbers match)<br/></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"setting_10\" value=\"";
    echo mconfig("lottery_2nd_prize");
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>3rd Prize (4/6 numbers match)<br/></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"setting_11\" value=\"";
    echo mconfig("lottery_3rd_prize");
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>4th Prize (3/6 numbers match)<br/></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"setting_12\" value=\"";
    echo mconfig("lottery_4th_prize");
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>5th Prize (2/6 numbers match)<br/></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"setting_13\" value=\"";
    echo mconfig("lottery_5th_prize");
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>6th Prize (1/6 numbers match)<br/></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"setting_14\" value=\"";
    echo mconfig("lottery_6th_prize");
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Prize Type<br/><span></span></th>\r\n                <td>\r\n                    ";
    echo $creditSystem->buildSelectInput("setting_15", mconfig("lottery_prize_type"), "form-control");
    echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <td colspan=\"2\"><input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\" class=\"btn btn-success\"/>\r\n                </td>\r\n            </tr>\r\n        </table>\r\n    </form>\r\n\r\n";
}
function saveChanges()
{
    foreach ($_POST as $setting) {
        if (!check_value($setting)) {
            message("error", "Missing data (complete all fields).");
            return NULL;
        }
    }
    $xmlPath = __PATH_MODULE_CONFIGS__ . "usercp.lottery.xml";
    $xml = simplexml_load_file($xmlPath);
    $xml->active = $_POST["setting_1"];
    $xml->lottery_start = $_POST["setting_0"];
    $xml->lottery_length = $_POST["setting_2"];
    $xml->lottery_history = $_POST["setting_16"];
    $xml->lottery_type = $_POST["setting_3"];
    $xml->lottery_min_num = $_POST["setting_4"];
    $xml->lottery_max_num = $_POST["setting_5"];
    $xml->lottery_ticket_limit = $_POST["setting_6"];
    $xml->lottery_ticket_price = $_POST["setting_7"];
    $xml->lottery_ticket_price_type = $_POST["setting_8"];
    $xml->lottery_1st_prize = $_POST["setting_9"];
    $xml->lottery_2nd_prize = $_POST["setting_10"];
    $xml->lottery_3rd_prize = $_POST["setting_11"];
    $xml->lottery_4th_prize = $_POST["setting_12"];
    $xml->lottery_5th_prize = $_POST["setting_13"];
    $xml->lottery_6th_prize = $_POST["setting_14"];
    $xml->lottery_prize_type = $_POST["setting_15"];
    $save = $xml->asXML($xmlPath);
    if ($save) {
        message("success", "Settings successfully saved.");
    } else {
        message("error", "There has been an error while saving changes.");
    }
}

?>