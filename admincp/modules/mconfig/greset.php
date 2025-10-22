<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h2>Character Grand Reset Settings</h2>\r\n\r\n<script>\r\n    function popitup(url) {\r\n        newwindow = window.open(url, 'name', 'height = 550, width = 600');\r\n        if (window.focus) {\r\n            newwindow.focus()\r\n        }\r\n        return false;\r\n    }\r\n</script>\r\n\r\n<style>\r\n    .hidden {\r\n        display: none;\r\n    }\r\n</style>\r\n";
if (check_value($_POST["submit_changes"])) {
    savechanges();
}
loadModuleConfigs("usercp.greset");
$creditSystem = new CreditSystem($common, new Character(), $dB, $dB2);
echo "<form action=\"\" method=\"post\">\r\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n        <tr>\r\n            <th>Status<br/><span>Enable/disable the character reset module.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_1", mconfig("active"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Price Requirement<br/></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_2", mconfig("gresets_enable_requirement"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Price Type<br/><span></span>\r\n            </th>\r\n            <td>\r\n                <select name=\"setting_8\" class=\"form-control\">\r\n                    ";
if (mconfig("gresets_price_type") == "1") {
    echo "<option value=\"1\" selected=\"selected\">Platinum Coins</option>";
} else {
    echo "<option value=\"1\">Platinum Coins</option>";
}
if (mconfig("gresets_price_type") == "2") {
    echo "<option value=\"2\" selected=\"selected\">Gold Coins</option>";
} else {
    echo "<option value=\"2\">Gold Coins</option>";
}
if (mconfig("gresets_price_type") == "3") {
    echo "<option value=\"3\" selected=\"selected\">Silver Coins</option>";
} else {
    echo "<option value=\"3\">Silver Coins</option>";
}
if (mconfig("gresets_price_type") == "4") {
    echo "<option value=\"4\" selected=\"selected\">WCoins</option>";
} else {
    echo "<option value=\"4\">WCoins</option>";
}
if (mconfig("gresets_price_type") == "5") {
    echo "<option value=\"5\" selected=\"selected\">GoblinPoints</option>";
} else {
    echo "<option value=\"5\">GoblinPoints</option>";
}
if (mconfig("gresets_price_type") == "6") {
    echo "<option value=\"6\" selected=\"selected\">Zen</option>";
} else {
    echo "<option value=\"6\">Zen</option>";
}
echo "                </select>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Price Value<br/><span>If price requirement is enabled, set the price of this feature.</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_3\" value=\"";
echo mconfig("gresets_price");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Reset Price Formula<br/><span></span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes2("setting_9", mconfig("gresets_price_formula"), "Price * (Grand Resets + 1)", "Fixed Price");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Required Level<br/><span>Required level to reset.</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_4\"\r\n                       value=\"";
echo mconfig("gresets_required_level");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Required Master Level<br/><span>Required master level to reset.</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_15\"\r\n                       value=\"";
echo mconfig("gresets_required_mlevel");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Required Reset<br/><span>Required reset to grand reset.</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_11\"\r\n                       value=\"";
echo mconfig("gresets_required_reset");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Grand Reset Limit<br/><span>Maximum Grand Resets.</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_10\" value=\"";
echo mconfig("gresets_limit");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Reset Stats<br/><span></span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_12", mconfig("gresets_reset_stats"), "Yes", "No");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Bonus Stats<br/><span></span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_13\" value=\"";
echo mconfig("gresets_bonus_stats");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Bonus Stats Formula<br/><span></span></th>\r\n            <td>\r\n                <select class=\"form-control\" name=\"setting_14\">\r\n                    ";
if (mconfig("gresets_bonus_stats_formula") == 0) {
    echo "<option value=\"0\" selected>Fixed Bonus</option>";
} else {
    echo "<option value=\"0\">Fixed Bonus</option>";
}
if (mconfig("gresets_bonus_stats_formula") == 1) {
    echo "<option value=\"1\" selected>Bonus * (Grand Resets + 1)</option>";
} else {
    echo "<option value=\"1\">Bonus * (Grand Resets + 1)</option>";
}
if (mconfig("gresets_bonus_stats_formula") == 2) {
    echo "<option value=\"2\" selected>Bonus * (Resets - 1)</option>";
} else {
    echo "<option value=\"2\">Bonus * (Resets - 1)</option>";
}
echo "                </select>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Clear Master Level<br/><span>If \"Yes\", after reset will be master level set to 0, master level points will be deleted and skill tree will be cleared.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_20", mconfig("gresets_clear_ml"), "Yes", "No");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Credits Reward<br/><span>Enable/disable giving credit(s) reward for every reset.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_5", mconfig("gresets_enable_credit_reward"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Reward<br/><span>If credits reward is enabled, set the amount of credits that will be rewarded for every reset.</span>\r\n            </th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_6\" value=\"";
echo mconfig("gresets_credits_reward");
echo "\" style=\"display: inline; width: 150px\"/> credit(s)\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Bonus<br/><span>If credits reward is enabled, set the amount of credits that will be rewarded for every reset.\r\n                <br>This option is used only when formula is \"Reward + (Bonus * (GR + 1))\".</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_17\" value=\"";
echo mconfig("gresets_credits_reward2");
echo "\" style=\"display: inline; width: 150px\"/> credit(s)\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Credits Reward Formula<br/><span></span></th>\r\n            <td>\r\n                <select class=\"form-control\" name=\"setting_16\">\r\n                    ";
if (mconfig("gresets_reward_formula") == 0) {
    echo "<option value=\"0\" selected>Fixed Reward</option>";
} else {
    echo "<option value=\"0\">Fixed Reward</option>";
}
if (mconfig("gresets_reward_formula") == 1) {
    echo "<option value=\"1\" selected>Reward * (Grand Resets + 1)</option>";
} else {
    echo "<option value=\"1\">Reward * (Grand Resets + 1)</option>";
}
if (mconfig("gresets_reward_formula") == 2) {
    echo "<option value=\"2\" selected>Reward + (Bonus * (GR + 1))</option>";
} else {
    echo "<option value=\"2\">Reward + (Bonus * (GR + 1))</option>";
}
echo "                </select>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Credit Configuration<br/><span></span></th>\r\n            <td>\r\n                ";
echo $creditSystem->buildSelectInput("setting_7", mconfig("credit_config"), "form-control");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Delay<br/><span>Delay time in minutes between grand resets.<br><b>Example:</b><br>0 = you can make next grand reset instantly<br>60 = you must wait at least 1 hour to make next grand reset</span>\r\n            </th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_35\" value=\"";
echo mconfig("time");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Decrease Resets By<br/><span>If greater than \"0\", character's reset will be decreased by config value. If \"0\", character's reset will be set to 0.<br><b>Example:</b><br>\r\n                0 = clear resets to 0<br>\r\n                1 = after grand reset, character's reset will be decreased by 1 (for example from 10 to 9 resets)<br>\r\n                5 = after grand reset, character's reset will be decreased by 5 (for example from 10 to 5 resets)</span>\r\n            </th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_34\" value=\"";
echo mconfig("decrease_resets");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Check Equipment<br/><span>If enabled, character will have to remove item from specific slot to be able to proceed with grand reset.</span></th>\r\n            <td>\r\n                <table width=\"100%\">\r\n                    <tr>\r\n                        <td width=\"30%\"><b>Left Hand:</b></td>\r\n                        <td width=\"70%\">";
enabledisableCheckboxes("setting_21", mconfig("check_equip_0"), "Yes", "No");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td width=\"30%\"><b>Right Hand:</b></td>\r\n                        <td width=\"70%\">";
enabledisableCheckboxes("setting_22", mconfig("check_equip_1"), "Yes", "No");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td width=\"30%\"><b>Helmet:</b></td>\r\n                        <td width=\"70%\">";
enabledisableCheckboxes("setting_23", mconfig("check_equip_2"), "Yes", "No");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td width=\"30%\"><b>Armor:</b></td>\r\n                        <td width=\"70%\">";
enabledisableCheckboxes("setting_24", mconfig("check_equip_3"), "Yes", "No");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td width=\"30%\"><b>Pants:</b></td>\r\n                        <td width=\"70%\">";
enabledisableCheckboxes("setting_25", mconfig("check_equip_4"), "Yes", "No");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td width=\"30%\"><b>Gloves:</b></td>\r\n                        <td width=\"70%\">";
enabledisableCheckboxes("setting_26", mconfig("check_equip_5"), "Yes", "No");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td width=\"30%\"><b>Boots:</b></td>\r\n                        <td width=\"70%\">";
enabledisableCheckboxes("setting_27", mconfig("check_equip_6"), "Yes", "No");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td width=\"30%\"><b>Wings:</b></td>\r\n                        <td width=\"70%\">";
enabledisableCheckboxes("setting_28", mconfig("check_equip_7"), "Yes", "No");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td width=\"30%\"><b>Pet:</b></td>\r\n                        <td width=\"70%\">";
enabledisableCheckboxes("setting_29", mconfig("check_equip_8"), "Yes", "No");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td width=\"30%\"><b>Pendant:</b></td>\r\n                        <td width=\"70%\">";
enabledisableCheckboxes("setting_30", mconfig("check_equip_9"), "Yes", "No");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td width=\"30%\"><b>Left Ring:</b></td>\r\n                        <td width=\"70%\">";
enabledisableCheckboxes("setting_31", mconfig("check_equip_10"), "Yes", "No");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td width=\"30%\"><b>Right Ring:</b></td>\r\n                        <td width=\"70%\">";
enabledisableCheckboxes("setting_32", mconfig("check_equip_11"), "Yes", "No");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td width=\"30%\"><b>Pentagram:</b></td>\r\n                        <td width=\"70%\">";
enabledisableCheckboxes("setting_33", mconfig("check_equip_236"), "Yes", "No");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td width=\"30%\"><b>Earring (R):</b></td>\r\n                        <td width=\"70%\">";
enabledisableCheckboxes("check_equip_237", mconfig("check_equip_237"), "Yes", "No");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td width=\"30%\"><b>Earring (L):</b></td>\r\n                        <td width=\"70%\">";
enabledisableCheckboxes("check_equip_238", mconfig("check_equip_238"), "Yes", "No");
echo "</td>\r\n                    </tr>\r\n                </table>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan=\"2\"><input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\" class=\"btn btn-success\"/>\r\n            </td>\r\n        </tr>\r\n    </table>\r\n</form>";
function saveChanges()
{
    
    foreach ($_POST as $setting) {
        if (!check_value($setting)) {
            message("error", "Missing data (complete all fields).");
            return NULL;
        }
    }
    $xmlPath = __PATH_MODULE_CONFIGS__ . "usercp.greset.xml";
    $xml = simplexml_load_file($xmlPath);
    $xml->active = $_POST["setting_1"];
    $xml->gresets_limit = $_POST["setting_10"];
    $xml->gresets_enable_requirement = $_POST["setting_2"];
    $xml->gresets_price_type = $_POST["setting_8"];
    $xml->gresets_price = $_POST["setting_3"];
    $xml->gresets_price_formula = $_POST["setting_9"];
    $xml->gresets_required_level = $_POST["setting_4"];
    $xml->gresets_required_mlevel = $_POST["setting_15"];
    $xml->gresets_required_reset = $_POST["setting_11"];
    $xml->gresets_reset_stats = $_POST["setting_12"];
    $xml->gresets_bonus_stats = $_POST["setting_13"];
    $xml->gresets_bonus_stats_formula = $_POST["setting_14"];
    $xml->gresets_enable_credit_reward = $_POST["setting_5"];
    $xml->gresets_credits_reward = $_POST["setting_6"];
    $xml->gresets_credits_reward2 = $_POST["setting_17"];
    $xml->gresets_reward_formula = $_POST["setting_16"];
    $xml->credit_config = $_POST["setting_7"];
    $xml->gresets_clear_ml = $_POST["setting_20"];
    $xml->check_equip_0 = $_POST["setting_21"];
    $xml->check_equip_1 = $_POST["setting_22"];
    $xml->check_equip_2 = $_POST["setting_23"];
    $xml->check_equip_3 = $_POST["setting_24"];
    $xml->check_equip_4 = $_POST["setting_25"];
    $xml->check_equip_5 = $_POST["setting_26"];
    $xml->check_equip_6 = $_POST["setting_27"];
    $xml->check_equip_7 = $_POST["setting_28"];
    $xml->check_equip_8 = $_POST["setting_29"];
    $xml->check_equip_9 = $_POST["setting_30"];
    $xml->check_equip_10 = $_POST["setting_31"];
    $xml->check_equip_11 = $_POST["setting_32"];
    $xml->check_equip_236 = $_POST["setting_33"];
    $xml->check_equip_237 = $_POST["check_equip_237"];
    $xml->check_equip_238 = $_POST["check_equip_238"];
    $xml->decrease_resets = $_POST["setting_34"];
    $xml->time = $_POST["setting_35"];
    $save = $xml->asXML($xmlPath);
    if ($save) {
        message("success", "Settings successfully saved.");
    } else {
        message("error", "There has been an error while saving changes.");
    }
}

?>