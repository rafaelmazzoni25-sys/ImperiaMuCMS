<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h2>Architect Settings</h2>\r\n";
if (check_value($_POST["submit_changes"])) {
    savechanges();
}
loadModuleConfigs("usercp.architect");
echo "<form action=\"\" method=\"post\">\r\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n        <tr>\r\n            <th>Status<br/><span>Enable/disable the architect module.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("active", mconfig("active"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Reward Day<br/><span>Select day of week when will be added rewards from building bonuses. Bonus will be added between 00:00 - 01:00 during night of that day.</span></th>\r\n            <td>\r\n                <select name=\"reward_day\" class=\"form-control\">\r\n                    ";
if (mconfig("reward_day") == "1") {
    echo "<option value=\"1\" selected=\"selected\">Monday</option>";
} else {
    echo "<option value=\"1\">Monday</option>";
}
if (mconfig("reward_day") == "2") {
    echo "<option value=\"2\" selected=\"selected\">Tuesday</option>";
} else {
    echo "<option value=\"2\">Tuesday</option>";
}
if (mconfig("reward_day") == "3") {
    echo "<option value=\"3\" selected=\"selected\">Wednesday</option>";
} else {
    echo "<option value=\"3\">Wednesday</option>";
}
if (mconfig("reward_day") == "4") {
    echo "<option value=\"4\" selected=\"selected\">Thursday</option>";
} else {
    echo "<option value=\"4\">Thursday</option>";
}
if (mconfig("reward_day") == "5") {
    echo "<option value=\"5\" selected=\"selected\">Friday</option>";
} else {
    echo "<option value=\"5\">Friday</option>";
}
if (mconfig("reward_day") == "6") {
    echo "<option value=\"6\" selected=\"selected\">Saturday</option>";
} else {
    echo "<option value=\"6\">Saturday</option>";
}
if (mconfig("reward_day") == "7") {
    echo "<option value=\"7\" selected=\"selected\">Sunday</option>";
} else {
    echo "<option value=\"7\">Sunday</option>";
}
echo "                </select>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Active Day Start<br/><span>Select day of week when Architect will be active - when Castle Lord can build and upgrade buildings, players can invest currencies, insert and withdraw resources from Guild Web Bank, etc.</span>\r\n            </th>\r\n            <td>\r\n                <select name=\"active_day_start\" class=\"form-control\">\r\n                    ";
if (mconfig("active_day_start") == "1") {
    echo "<option value=\"1\" selected=\"selected\">Monday</option>";
} else {
    echo "<option value=\"1\">Monday</option>";
}
if (mconfig("active_day_start") == "2") {
    echo "<option value=\"2\" selected=\"selected\">Tuesday</option>";
} else {
    echo "<option value=\"2\">Tuesday</option>";
}
if (mconfig("active_day_start") == "3") {
    echo "<option value=\"3\" selected=\"selected\">Wednesday</option>";
} else {
    echo "<option value=\"3\">Wednesday</option>";
}
if (mconfig("active_day_start") == "4") {
    echo "<option value=\"4\" selected=\"selected\">Thursday</option>";
} else {
    echo "<option value=\"4\">Thursday</option>";
}
if (mconfig("active_day_start") == "5") {
    echo "<option value=\"5\" selected=\"selected\">Friday</option>";
} else {
    echo "<option value=\"5\">Friday</option>";
}
if (mconfig("active_day_start") == "6") {
    echo "<option value=\"6\" selected=\"selected\">Saturday</option>";
} else {
    echo "<option value=\"6\">Saturday</option>";
}
if (mconfig("active_day_start") == "7") {
    echo "<option value=\"7\" selected=\"selected\">Sunday</option>";
} else {
    echo "<option value=\"7\">Sunday</option>";
}
echo "                </select>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Active Day End<br/><span>Select day of week when Architect will be active - when Castle Lord can build and upgrade buildings, players can invest currencies, insert and withdraw resources from Guild Web Bank, etc.</span>\r\n            </th>\r\n            <td>\r\n                <select name=\"active_day_end\" class=\"form-control\">\r\n                    ";
if (mconfig("active_day_end") == "1") {
    echo "<option value=\"1\" selected=\"selected\">Monday</option>";
} else {
    echo "<option value=\"1\">Monday</option>";
}
if (mconfig("active_day_end") == "2") {
    echo "<option value=\"2\" selected=\"selected\">Tuesday</option>";
} else {
    echo "<option value=\"2\">Tuesday</option>";
}
if (mconfig("active_day_end") == "3") {
    echo "<option value=\"3\" selected=\"selected\">Wednesday</option>";
} else {
    echo "<option value=\"3\">Wednesday</option>";
}
if (mconfig("active_day_end") == "4") {
    echo "<option value=\"4\" selected=\"selected\">Thursday</option>";
} else {
    echo "<option value=\"4\">Thursday</option>";
}
if (mconfig("active_day_end") == "5") {
    echo "<option value=\"5\" selected=\"selected\">Friday</option>";
} else {
    echo "<option value=\"5\">Friday</option>";
}
if (mconfig("active_day_end") == "6") {
    echo "<option value=\"6\" selected=\"selected\">Saturday</option>";
} else {
    echo "<option value=\"6\">Saturday</option>";
}
if (mconfig("active_day_end") == "7") {
    echo "<option value=\"7\" selected=\"selected\">Sunday</option>";
} else {
    echo "<option value=\"7\">Sunday</option>";
}
echo "                </select>\r\n            </td>\r\n        </tr>\r\n    </table>\r\n\r\n    <hr>\r\n    <h3>Jewel Mine Settings</h3>\r\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n        <tr>\r\n            <th>Jewel Mine<br/><span>Enable/disable jewel mine building.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("building_mine", mconfig("building_mine"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n    </table>\r\n\r\n    ";
$i = 1;
while ($i <= 3) {
    echo "\r\n        <h5>Stage ";
    echo $i;
    echo " Settings</h5>\r\n        <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n            <tr>\r\n                <th>Active<br/><span>Enable/disable building stage.</span></th>\r\n                <td>";
    enabledisableCheckboxes("mine_stage" . $i . "[active]", mconfig("mine_stage" . $i)["active"], "Enabled", "Disabled");
    echo "</td>\r\n            </tr>\r\n            <tr>\r\n                <th>Price Valor<br/><span>Enter price of upgrade to this stage.</span></th>\r\n                <td><input class=\"form-control\" type=\"text\" name=\"mine_stage";
    echo $i;
    echo "[price_valor]\" value=\"";
    echo mconfig("mine_stage" . $i)["price_valor"];
    echo "\"/></td>\r\n            </tr>\r\n            <tr>\r\n                <th>Price Sign of Lord<br/><span>Enter price of upgrade to this stage.</span></th>\r\n                <td><input class=\"form-control\" type=\"text\" name=\"mine_stage";
    echo $i;
    echo "[price_sol]\" value=\"";
    echo mconfig("mine_stage" . $i)["price_sol"];
    echo "\"/></td>\r\n            </tr>\r\n            <tr>\r\n                <th>Price Zen<br/><span>Enter price of upgrade to this stage.</span></th>\r\n                <td><input class=\"form-control\" type=\"text\" name=\"mine_stage";
    echo $i;
    echo "[price_zen]\" value=\"";
    echo mconfig("mine_stage" . $i)["price_zen"];
    echo "\"/></td>\r\n            </tr>\r\n            <tr>\r\n                <th>Price Jewel of Bless<br/><span>Enter price of upgrade to this stage.</span></th>\r\n                <td><input class=\"form-control\" type=\"text\" name=\"mine_stage";
    echo $i;
    echo "[price_bless]\" value=\"";
    echo mconfig("mine_stage" . $i)["price_bless"];
    echo "\"/></td>\r\n            </tr>\r\n            <tr>\r\n                <th>Price Jewel of Soul<br/><span>Enter price of upgrade to this stage.</span></th>\r\n                <td><input class=\"form-control\" type=\"text\" name=\"mine_stage";
    echo $i;
    echo "[price_soul]\" value=\"";
    echo mconfig("mine_stage" . $i)["price_soul"];
    echo "\"/></td>\r\n            </tr>\r\n            <tr>\r\n                <th>Price Jewel of Life<br/><span>Enter price of upgrade to this stage.</span></th>\r\n                <td><input class=\"form-control\" type=\"text\" name=\"mine_stage";
    echo $i;
    echo "[price_life]\" value=\"";
    echo mconfig("mine_stage" . $i)["price_life"];
    echo "\"/></td>\r\n            </tr>\r\n            <tr>\r\n                <th>Price Jewel of Chaos<br/><span>Enter price of upgrade to this stage.</span></th>\r\n                <td><input class=\"form-control\" type=\"text\" name=\"mine_stage";
    echo $i;
    echo "[price_chaos]\" value=\"";
    echo mconfig("mine_stage" . $i)["price_chaos"];
    echo "\"/></td>\r\n            </tr>\r\n            <tr>\r\n                <th>Price Jewel of Harmony<br/><span>Enter price of upgrade to this stage.</span></th>\r\n                <td><input class=\"form-control\" type=\"text\" name=\"mine_stage";
    echo $i;
    echo "[price_harmony]\" value=\"";
    echo mconfig("mine_stage" . $i)["price_harmony"];
    echo "\"/></td>\r\n            </tr>\r\n            <tr>\r\n                <th>Price Jewel of Creation<br/><span>Enter price of upgrade to this stage.</span></th>\r\n                <td><input class=\"form-control\" type=\"text\" name=\"mine_stage";
    echo $i;
    echo "[price_creation]\" value=\"";
    echo mconfig("mine_stage" . $i)["price_creation"];
    echo "\"/></td>\r\n            </tr>\r\n            <tr>\r\n                <th>Price Jewel of Guardian<br/><span>Enter price of upgrade to this stage.</span></th>\r\n                <td><input class=\"form-control\" type=\"text\" name=\"mine_stage";
    echo $i;
    echo "[price_guardian]\" value=\"";
    echo mconfig("mine_stage" . $i)["price_guardian"];
    echo "\"/></td>\r\n            </tr>\r\n            <tr>\r\n                <th>Reward Jewel of Bless<br/><span>Enter minimal and maximal reward for this stage. Reward will be generated randomly from the selected interval.</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" style=\"width: calc(50% - 9px); display: inline-block;\" type=\"text\" name=\"mine_stage";
    echo $i;
    echo "[reward_bless_min]\"\r\n                           value=\"";
    echo mconfig("mine_stage" . $i)["reward_bless_min"];
    echo "\"/>\r\n                    <div style=\"width: 10px; text-align: center; display: inline-block;\">-</div>\r\n                    <input class=\"form-control\" style=\"width: calc(50% - 9px); display: inline-block;\" type=\"text\" name=\"mine_stage";
    echo $i;
    echo "[reward_bless_max]\"\r\n                           value=\"";
    echo mconfig("mine_stage" . $i)["reward_bless_max"];
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Reward Jewel of Soul<br/><span>Enter minimal and maximal reward for this stage. Reward will be generated randomly from the selected interval.</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" style=\"width: calc(50% - 9px); display: inline-block;\" type=\"text\" name=\"mine_stage";
    echo $i;
    echo "[reward_soul_min]\"\r\n                           value=\"";
    echo mconfig("mine_stage" . $i)["reward_soul_min"];
    echo "\"/>\r\n                    <div style=\"width: 10px; text-align: center; display: inline-block;\">-</div>\r\n                    <input class=\"form-control\" style=\"width: calc(50% - 9px); display: inline-block;\" type=\"text\" name=\"mine_stage";
    echo $i;
    echo "[reward_soul_max]\"\r\n                           value=\"";
    echo mconfig("mine_stage" . $i)["reward_soul_max"];
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Reward Jewel of Life<br/><span>Enter minimal and maximal reward for this stage. Reward will be generated randomly from the selected interval.</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" style=\"width: calc(50% - 9px); display: inline-block;\" type=\"text\" name=\"mine_stage";
    echo $i;
    echo "[reward_life_min]\"\r\n                           value=\"";
    echo mconfig("mine_stage" . $i)["reward_life_min"];
    echo "\"/>\r\n                    <div style=\"width: 10px; text-align: center; display: inline-block;\">-</div>\r\n                    <input class=\"form-control\" style=\"width: calc(50% - 9px); display: inline-block;\" type=\"text\" name=\"mine_stage";
    echo $i;
    echo "[reward_life_max]\"\r\n                           value=\"";
    echo mconfig("mine_stage" . $i)["reward_life_max"];
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Reward Jewel of Chaos<br/><span>Enter minimal and maximal reward for this stage. Reward will be generated randomly from the selected interval.</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" style=\"width: calc(50% - 9px); display: inline-block;\" type=\"text\" name=\"mine_stage";
    echo $i;
    echo "[reward_chaos_min]\"\r\n                           value=\"";
    echo mconfig("mine_stage" . $i)["reward_chaos_min"];
    echo "\"/>\r\n                    <div style=\"width: 10px; text-align: center; display: inline-block;\">-</div>\r\n                    <input class=\"form-control\" style=\"width: calc(50% - 9px); display: inline-block;\" type=\"text\" name=\"mine_stage";
    echo $i;
    echo "[reward_chaos_max]\"\r\n                           value=\"";
    echo mconfig("mine_stage" . $i)["reward_chaos_max"];
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Reward Jewel of Harmony<br/><span>Enter minimal and maximal reward for this stage. Reward will be generated randomly from the selected interval.</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" style=\"width: calc(50% - 9px); display: inline-block;\" type=\"text\" name=\"mine_stage";
    echo $i;
    echo "[reward_harmony_min]\"\r\n                           value=\"";
    echo mconfig("mine_stage" . $i)["reward_harmony_min"];
    echo "\"/>\r\n                    <div style=\"width: 10px; text-align: center; display: inline-block;\">-</div>\r\n                    <input class=\"form-control\" style=\"width: calc(50% - 9px); display: inline-block;\" type=\"text\" name=\"mine_stage";
    echo $i;
    echo "[reward_harmony_max]\"\r\n                           value=\"";
    echo mconfig("mine_stage" . $i)["reward_harmony_max"];
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Reward Jewel of Creation<br/><span>Enter minimal and maximal reward for this stage. Reward will be generated randomly from the selected interval.</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" style=\"width: calc(50% - 9px); display: inline-block;\" type=\"text\" name=\"mine_stage";
    echo $i;
    echo "[reward_creation_min]\"\r\n                           value=\"";
    echo mconfig("mine_stage" . $i)["reward_creation_min"];
    echo "\"/>\r\n                    <div style=\"width: 10px; text-align: center; display: inline-block;\">-</div>\r\n                    <input class=\"form-control\" style=\"width: calc(50% - 9px); display: inline-block;\" type=\"text\" name=\"mine_stage";
    echo $i;
    echo "[reward_creation_max]\"\r\n                           value=\"";
    echo mconfig("mine_stage" . $i)["reward_creation_max"];
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Reward Jewel of Guardian<br/><span>Enter minimal and maximal reward for this stage. Reward will be generated randomly from the selected interval.</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" style=\"width: calc(50% - 9px); display: inline-block;\" type=\"text\" name=\"mine_stage";
    echo $i;
    echo "[reward_guardian_min]\"\r\n                           value=\"";
    echo mconfig("mine_stage" . $i)["reward_guardian_min"];
    echo "\"/>\r\n                    <div style=\"width: 10px; text-align: center; display: inline-block;\">-</div>\r\n                    <input class=\"form-control\" style=\"width: calc(50% - 9px); display: inline-block;\" type=\"text\" name=\"mine_stage";
    echo $i;
    echo "[reward_guardian_max]\"\r\n                           value=\"";
    echo mconfig("mine_stage" . $i)["reward_guardian_max"];
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n        </table>\r\n\r\n        ";
    $i++;
}
echo "\r\n    <hr>\r\n    <h3>Bank Settings</h3>\r\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n        <tr>\r\n            <th>Bank<br/><span>Enable/disable bank building.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("building_bank", mconfig("building_bank"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Platinum Coins Investments<br/><span>Enable/disable platinum coins investments.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("bank_platinum", mconfig("bank_platinum"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Gold Coins Investments<br/><span>Enable/disable gold coins investments.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("bank_gold", mconfig("bank_gold"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Silver Coins Investments<br/><span>Enable/disable silver coins investments.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("bank_silver", mconfig("bank_silver"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>WCoins Investments<br/><span>Enable/disable wcoins investments.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("bank_wcoin", mconfig("bank_wcoin"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Goblin Points Investments<br/><span>Enable/disable goblin points investments.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("bank_gp", mconfig("bank_gp"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Zen Investments<br/><span>Enable/disable zen investments.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("bank_zen", mconfig("bank_zen"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n    </table>\r\n\r\n    ";
$i = 1;
while ($i <= 3) {
    echo "\r\n        <h5>Stage ";
    echo $i;
    echo " Settings</h5>\r\n        <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n            <tr>\r\n                <th>Active<br/><span>Enable/disable building stage.</span></th>\r\n                <td>";
    enabledisableCheckboxes("bank_stage" . $i . "[active]", mconfig("bank_stage" . $i)["active"], "Enabled", "Disabled");
    echo "</td>\r\n            </tr>\r\n            <tr>\r\n                <th>Price Valor<br/><span>Enter price of upgrade to this stage.</span></th>\r\n                <td><input class=\"form-control\" type=\"text\" name=\"bank_stage";
    echo $i;
    echo "[price_valor]\" value=\"";
    echo mconfig("bank_stage" . $i)["price_valor"];
    echo "\"/></td>\r\n            </tr>\r\n            <tr>\r\n                <th>Price Sign of Lord<br/><span>Enter price of upgrade to this stage.</span></th>\r\n                <td><input class=\"form-control\" type=\"text\" name=\"bank_stage";
    echo $i;
    echo "[price_sol]\" value=\"";
    echo mconfig("bank_stage" . $i)["price_sol"];
    echo "\"/></td>\r\n            </tr>\r\n            <tr>\r\n                <th>Price Zen<br/><span>Enter price of upgrade to this stage.</span></th>\r\n                <td><input class=\"form-control\" type=\"text\" name=\"bank_stage";
    echo $i;
    echo "[price_zen]\" value=\"";
    echo mconfig("bank_stage" . $i)["price_zen"];
    echo "\"/></td>\r\n            </tr>\r\n            <tr>\r\n                <th>Price Jewel of Bless<br/><span>Enter price of upgrade to this stage.</span></th>\r\n                <td><input class=\"form-control\" type=\"text\" name=\"bank_stage";
    echo $i;
    echo "[price_bless]\" value=\"";
    echo mconfig("bank_stage" . $i)["price_bless"];
    echo "\"/></td>\r\n            </tr>\r\n            <tr>\r\n                <th>Price Jewel of Soul<br/><span>Enter price of upgrade to this stage.</span></th>\r\n                <td><input class=\"form-control\" type=\"text\" name=\"bank_stage";
    echo $i;
    echo "[price_soul]\" value=\"";
    echo mconfig("bank_stage" . $i)["price_soul"];
    echo "\"/></td>\r\n            </tr>\r\n            <tr>\r\n                <th>Price Jewel of Life<br/><span>Enter price of upgrade to this stage.</span></th>\r\n                <td><input class=\"form-control\" type=\"text\" name=\"bank_stage";
    echo $i;
    echo "[price_life]\" value=\"";
    echo mconfig("bank_stage" . $i)["price_life"];
    echo "\"/></td>\r\n            </tr>\r\n            <tr>\r\n                <th>Price Jewel of Chaos<br/><span>Enter price of upgrade to this stage.</span></th>\r\n                <td><input class=\"form-control\" type=\"text\" name=\"bank_stage";
    echo $i;
    echo "[price_chaos]\" value=\"";
    echo mconfig("bank_stage" . $i)["price_chaos"];
    echo "\"/></td>\r\n            </tr>\r\n            <tr>\r\n                <th>Price Jewel of Harmony<br/><span>Enter price of upgrade to this stage.</span></th>\r\n                <td><input class=\"form-control\" type=\"text\" name=\"bank_stage";
    echo $i;
    echo "[price_harmony]\" value=\"";
    echo mconfig("bank_stage" . $i)["price_harmony"];
    echo "\"/></td>\r\n            </tr>\r\n            <tr>\r\n                <th>Price Jewel of Creation<br/><span>Enter price of upgrade to this stage.</span></th>\r\n                <td><input class=\"form-control\" type=\"text\" name=\"bank_stage";
    echo $i;
    echo "[price_creation]\" value=\"";
    echo mconfig("bank_stage" . $i)["price_creation"];
    echo "\"/></td>\r\n            </tr>\r\n            <tr>\r\n                <th>Price Jewel of Guardian<br/><span>Enter price of upgrade to this stage.</span></th>\r\n                <td><input class=\"form-control\" type=\"text\" name=\"bank_stage";
    echo $i;
    echo "[price_guardian]\" value=\"";
    echo mconfig("bank_stage" . $i)["price_guardian"];
    echo "\"/></td>\r\n            </tr>\r\n            <tr>\r\n                <th>Reward Platinum Coins<br/><span>Enter reward bonus in percentage.</span></th>\r\n                <td><input class=\"form-control\" type=\"text\" name=\"bank_stage";
    echo $i;
    echo "[reward_platinum]\" value=\"";
    echo mconfig("bank_stage" . $i)["reward_platinum"];
    echo "\"/></td>\r\n            </tr>\r\n            <tr>\r\n                <th>Reward Gold Coins<br/><span>Enter reward bonus in percentage.</span></th>\r\n                <td><input class=\"form-control\" type=\"text\" name=\"bank_stage";
    echo $i;
    echo "[reward_gold]\" value=\"";
    echo mconfig("bank_stage" . $i)["reward_gold"];
    echo "\"/></td>\r\n            </tr>\r\n            <tr>\r\n                <th>Reward Silver Coins<br/><span>Enter reward bonus in percentage.</span></th>\r\n                <td><input class=\"form-control\" type=\"text\" name=\"bank_stage";
    echo $i;
    echo "[reward_silver]\" value=\"";
    echo mconfig("bank_stage" . $i)["reward_silver"];
    echo "\"/></td>\r\n            </tr>\r\n            <tr>\r\n                <th>Reward WCoins<br/><span>Enter reward bonus in percentage.</span></th>\r\n                <td><input class=\"form-control\" type=\"text\" name=\"bank_stage";
    echo $i;
    echo "[reward_wcoin]\" value=\"";
    echo mconfig("bank_stage" . $i)["reward_wcoin"];
    echo "\"/></td>\r\n            </tr>\r\n            <tr>\r\n                <th>Reward Goblin Points<br/><span>Enter reward bonus in percentage.</span></th>\r\n                <td><input class=\"form-control\" type=\"text\" name=\"bank_stage";
    echo $i;
    echo "[reward_gp]\" value=\"";
    echo mconfig("bank_stage" . $i)["reward_gp"];
    echo "\"/></td>\r\n            </tr>\r\n            <tr>\r\n                <th>Reward Zen<br/><span>Enter reward bonus in percentage.</span></th>\r\n                <td><input class=\"form-control\" type=\"text\" name=\"bank_stage";
    echo $i;
    echo "[reward_zen]\" value=\"";
    echo mconfig("bank_stage" . $i)["reward_zen"];
    echo "\"/></td>\r\n            </tr>\r\n        </table>\r\n\r\n        ";
    $i++;
}
echo "\r\n    <input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\" class=\"btn btn-success\"/>\r\n</form>";
function saveChanges()
{
    
    foreach ($_POST as $setting) {
        if (!check_value($setting)) {
            message("error", "Missing data (complete all fields).");
            return NULL;
        }
    }
    $xmlPath = __PATH_MODULE_CONFIGS__ . "usercp.architect.xml";
    $xml = simplexml_load_file($xmlPath);
    $xml->active = $_POST["active"];
    $xml->reward_day = $_POST["reward_day"];
    $xml->active_day_start = $_POST["active_day_start"];
    $xml->active_day_end = $_POST["active_day_end"];
    $xml->building_mine = $_POST["building_mine"];
    $xml->building_bank = $_POST["building_bank"];
    $xml->bank_platinum = $_POST["bank_platinum"];
    $xml->bank_gold = $_POST["bank_gold"];
    $xml->bank_silver = $_POST["bank_silver"];
    $xml->bank_wcoin = $_POST["bank_wcoin"];
    $xml->bank_gp = $_POST["bank_gp"];
    $xml->bank_zen = $_POST["bank_zen"];
    $xml->mine_stage1->active = $_POST["mine_stage1"]["active"];
    $xml->mine_stage1->price_valor = $_POST["mine_stage1"]["price_valor"];
    $xml->mine_stage1->price_sol = $_POST["mine_stage1"]["price_sol"];
    $xml->mine_stage1->price_zen = $_POST["mine_stage1"]["price_zen"];
    $xml->mine_stage1->price_bless = $_POST["mine_stage1"]["price_bless"];
    $xml->mine_stage1->price_soul = $_POST["mine_stage1"]["price_soul"];
    $xml->mine_stage1->price_life = $_POST["mine_stage1"]["price_life"];
    $xml->mine_stage1->price_chaos = $_POST["mine_stage1"]["price_chaos"];
    $xml->mine_stage1->price_harmony = $_POST["mine_stage1"]["price_harmony"];
    $xml->mine_stage1->price_creation = $_POST["mine_stage1"]["price_creation"];
    $xml->mine_stage1->price_guardian = $_POST["mine_stage1"]["price_guardian"];
    $xml->mine_stage1->reward_bless_min = $_POST["mine_stage1"]["reward_bless_min"];
    $xml->mine_stage1->reward_soul_min = $_POST["mine_stage1"]["reward_soul_min"];
    $xml->mine_stage1->reward_life_min = $_POST["mine_stage1"]["reward_life_min"];
    $xml->mine_stage1->reward_chaos_min = $_POST["mine_stage1"]["reward_chaos_min"];
    $xml->mine_stage1->reward_harmony_min = $_POST["mine_stage1"]["reward_harmony_min"];
    $xml->mine_stage1->reward_creation_min = $_POST["mine_stage1"]["reward_creation_min"];
    $xml->mine_stage1->reward_guardian_min = $_POST["mine_stage1"]["reward_guardian_min"];
    $xml->mine_stage1->reward_bless_max = $_POST["mine_stage1"]["reward_bless_max"];
    $xml->mine_stage1->reward_soul_max = $_POST["mine_stage1"]["reward_soul_max"];
    $xml->mine_stage1->reward_life_max = $_POST["mine_stage1"]["reward_life_max"];
    $xml->mine_stage1->reward_chaos_max = $_POST["mine_stage1"]["reward_chaos_max"];
    $xml->mine_stage1->reward_harmony_max = $_POST["mine_stage1"]["reward_harmony_max"];
    $xml->mine_stage1->reward_creation_max = $_POST["mine_stage1"]["reward_creation_max"];
    $xml->mine_stage1->reward_guardian_max = $_POST["mine_stage1"]["reward_guardian_max"];
    $xml->mine_stage2->active = $_POST["mine_stage2"]["active"];
    $xml->mine_stage2->price_valor = $_POST["mine_stage2"]["price_valor"];
    $xml->mine_stage2->price_sol = $_POST["mine_stage2"]["price_sol"];
    $xml->mine_stage2->price_zen = $_POST["mine_stage2"]["price_zen"];
    $xml->mine_stage2->price_bless = $_POST["mine_stage2"]["price_bless"];
    $xml->mine_stage2->price_soul = $_POST["mine_stage2"]["price_soul"];
    $xml->mine_stage2->price_life = $_POST["mine_stage2"]["price_life"];
    $xml->mine_stage2->price_chaos = $_POST["mine_stage2"]["price_chaos"];
    $xml->mine_stage2->price_harmony = $_POST["mine_stage2"]["price_harmony"];
    $xml->mine_stage2->price_creation = $_POST["mine_stage2"]["price_creation"];
    $xml->mine_stage2->price_guardian = $_POST["mine_stage2"]["price_guardian"];
    $xml->mine_stage2->reward_bless_min = $_POST["mine_stage2"]["reward_bless_min"];
    $xml->mine_stage2->reward_soul_min = $_POST["mine_stage2"]["reward_soul_min"];
    $xml->mine_stage2->reward_life_min = $_POST["mine_stage2"]["reward_life_min"];
    $xml->mine_stage2->reward_chaos_min = $_POST["mine_stage2"]["reward_chaos_min"];
    $xml->mine_stage2->reward_harmony_min = $_POST["mine_stage2"]["reward_harmony_min"];
    $xml->mine_stage2->reward_creation_min = $_POST["mine_stage2"]["reward_creation_min"];
    $xml->mine_stage2->reward_guardian_min = $_POST["mine_stage2"]["reward_guardian_min"];
    $xml->mine_stage2->reward_bless_max = $_POST["mine_stage2"]["reward_bless_max"];
    $xml->mine_stage2->reward_soul_max = $_POST["mine_stage2"]["reward_soul_max"];
    $xml->mine_stage2->reward_life_max = $_POST["mine_stage2"]["reward_life_max"];
    $xml->mine_stage2->reward_chaos_max = $_POST["mine_stage2"]["reward_chaos_max"];
    $xml->mine_stage2->reward_harmony_max = $_POST["mine_stage2"]["reward_harmony_max"];
    $xml->mine_stage2->reward_creation_max = $_POST["mine_stage2"]["reward_creation_max"];
    $xml->mine_stage2->reward_guardian_max = $_POST["mine_stage2"]["reward_guardian_max"];
    $xml->mine_stage3->active = $_POST["mine_stage3"]["active"];
    $xml->mine_stage3->price_valor = $_POST["mine_stage3"]["price_valor"];
    $xml->mine_stage3->price_sol = $_POST["mine_stage3"]["price_sol"];
    $xml->mine_stage3->price_zen = $_POST["mine_stage3"]["price_zen"];
    $xml->mine_stage3->price_bless = $_POST["mine_stage3"]["price_bless"];
    $xml->mine_stage3->price_soul = $_POST["mine_stage3"]["price_soul"];
    $xml->mine_stage3->price_life = $_POST["mine_stage3"]["price_life"];
    $xml->mine_stage3->price_chaos = $_POST["mine_stage3"]["price_chaos"];
    $xml->mine_stage3->price_harmony = $_POST["mine_stage3"]["price_harmony"];
    $xml->mine_stage3->price_creation = $_POST["mine_stage3"]["price_creation"];
    $xml->mine_stage3->price_guardian = $_POST["mine_stage3"]["price_guardian"];
    $xml->mine_stage3->reward_bless_min = $_POST["mine_stage3"]["reward_bless_min"];
    $xml->mine_stage3->reward_soul_min = $_POST["mine_stage3"]["reward_soul_min"];
    $xml->mine_stage3->reward_life_min = $_POST["mine_stage3"]["reward_life_min"];
    $xml->mine_stage3->reward_chaos_min = $_POST["mine_stage3"]["reward_chaos_min"];
    $xml->mine_stage3->reward_harmony_min = $_POST["mine_stage3"]["reward_harmony_min"];
    $xml->mine_stage3->reward_creation_min = $_POST["mine_stage3"]["reward_creation_min"];
    $xml->mine_stage3->reward_guardian_min = $_POST["mine_stage3"]["reward_guardian_min"];
    $xml->mine_stage3->reward_bless_max = $_POST["mine_stage3"]["reward_bless_max"];
    $xml->mine_stage3->reward_soul_max = $_POST["mine_stage3"]["reward_soul_max"];
    $xml->mine_stage3->reward_life_max = $_POST["mine_stage3"]["reward_life_max"];
    $xml->mine_stage3->reward_chaos_max = $_POST["mine_stage3"]["reward_chaos_max"];
    $xml->mine_stage3->reward_harmony_max = $_POST["mine_stage3"]["reward_harmony_max"];
    $xml->mine_stage3->reward_creation_max = $_POST["mine_stage3"]["reward_creation_max"];
    $xml->mine_stage3->reward_guardian_max = $_POST["mine_stage3"]["reward_guardian_max"];
    $xml->bank_stage1->active = $_POST["bank_stage1"]["active"];
    $xml->bank_stage1->price_valor = $_POST["bank_stage1"]["price_valor"];
    $xml->bank_stage1->price_sol = $_POST["bank_stage1"]["price_sol"];
    $xml->bank_stage1->price_zen = $_POST["bank_stage1"]["price_zen"];
    $xml->bank_stage1->price_bless = $_POST["bank_stage1"]["price_bless"];
    $xml->bank_stage1->price_soul = $_POST["bank_stage1"]["price_soul"];
    $xml->bank_stage1->price_life = $_POST["bank_stage1"]["price_life"];
    $xml->bank_stage1->price_chaos = $_POST["bank_stage1"]["price_chaos"];
    $xml->bank_stage1->price_harmony = $_POST["bank_stage1"]["price_harmony"];
    $xml->bank_stage1->price_creation = $_POST["bank_stage1"]["price_creation"];
    $xml->bank_stage1->price_guardian = $_POST["bank_stage1"]["price_guardian"];
    $xml->bank_stage1->reward_platinum = $_POST["bank_stage1"]["reward_platinum"];
    $xml->bank_stage1->reward_gold = $_POST["bank_stage1"]["reward_gold"];
    $xml->bank_stage1->reward_silver = $_POST["bank_stage1"]["reward_silver"];
    $xml->bank_stage1->reward_wcoin = $_POST["bank_stage1"]["reward_wcoin"];
    $xml->bank_stage1->reward_gp = $_POST["bank_stage1"]["reward_gp"];
    $xml->bank_stage1->reward_zen = $_POST["bank_stage1"]["reward_zen"];
    $xml->bank_stage2->active = $_POST["bank_stage2"]["active"];
    $xml->bank_stage2->price_valor = $_POST["bank_stage2"]["price_valor"];
    $xml->bank_stage2->price_sol = $_POST["bank_stage2"]["price_sol"];
    $xml->bank_stage2->price_zen = $_POST["bank_stage2"]["price_zen"];
    $xml->bank_stage2->price_bless = $_POST["bank_stage2"]["price_bless"];
    $xml->bank_stage2->price_soul = $_POST["bank_stage2"]["price_soul"];
    $xml->bank_stage2->price_life = $_POST["bank_stage2"]["price_life"];
    $xml->bank_stage2->price_chaos = $_POST["bank_stage2"]["price_chaos"];
    $xml->bank_stage2->price_harmony = $_POST["bank_stage2"]["price_harmony"];
    $xml->bank_stage2->price_creation = $_POST["bank_stage2"]["price_creation"];
    $xml->bank_stage2->price_guardian = $_POST["bank_stage2"]["price_guardian"];
    $xml->bank_stage2->reward_platinum = $_POST["bank_stage2"]["reward_platinum"];
    $xml->bank_stage2->reward_gold = $_POST["bank_stage2"]["reward_gold"];
    $xml->bank_stage2->reward_silver = $_POST["bank_stage2"]["reward_silver"];
    $xml->bank_stage2->reward_wcoin = $_POST["bank_stage2"]["reward_wcoin"];
    $xml->bank_stage2->reward_gp = $_POST["bank_stage2"]["reward_gp"];
    $xml->bank_stage2->reward_zen = $_POST["bank_stage2"]["reward_zen"];
    $xml->bank_stage3->active = $_POST["bank_stage3"]["active"];
    $xml->bank_stage3->price_valor = $_POST["bank_stage3"]["price_valor"];
    $xml->bank_stage3->price_sol = $_POST["bank_stage3"]["price_sol"];
    $xml->bank_stage3->price_zen = $_POST["bank_stage3"]["price_zen"];
    $xml->bank_stage3->price_bless = $_POST["bank_stage3"]["price_bless"];
    $xml->bank_stage3->price_soul = $_POST["bank_stage3"]["price_soul"];
    $xml->bank_stage3->price_life = $_POST["bank_stage3"]["price_life"];
    $xml->bank_stage3->price_chaos = $_POST["bank_stage3"]["price_chaos"];
    $xml->bank_stage3->price_harmony = $_POST["bank_stage3"]["price_harmony"];
    $xml->bank_stage3->price_creation = $_POST["bank_stage3"]["price_creation"];
    $xml->bank_stage3->price_guardian = $_POST["bank_stage3"]["price_guardian"];
    $xml->bank_stage3->reward_platinum = $_POST["bank_stage3"]["reward_platinum"];
    $xml->bank_stage3->reward_gold = $_POST["bank_stage3"]["reward_gold"];
    $xml->bank_stage3->reward_silver = $_POST["bank_stage3"]["reward_silver"];
    $xml->bank_stage3->reward_wcoin = $_POST["bank_stage3"]["reward_wcoin"];
    $xml->bank_stage3->reward_gp = $_POST["bank_stage3"]["reward_gp"];
    $xml->bank_stage3->reward_zen = $_POST["bank_stage3"]["reward_zen"];
    $save = $xml->asXML($xmlPath);
    if ($save) {
        message("success", "Settings successfully saved.");
    } else {
        message("error", "There has been an error while saving changes.");
    }
}

?>