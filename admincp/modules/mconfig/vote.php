<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h2>Vote and Reward Settings</h2>\n";
$vote = new Vote($common, $dB, $dB2);
if (check_value($_POST["submit_changes"])) {
    savechanges();
}
if (check_value($_GET["delete"])) {
    $id = htmlspecialchars($_GET["delete"]);
    $delete = $dB->query("DELETE FROM IMPERIAMUCMS_VOTE_SITES WHERE votesite_id = ?", [$id]);
    if ($delete) {
        message("success", "Vote link was successfully deleted.");
    } else {
        message("error", "Error occurred.");
    }
}
if (check_value($_POST["switchStatus"])) {
    $vote->switchStatus($_POST["id"]);
}
if (check_value($_POST["add_vote_site"])) {
    $vote->addVote($_POST["title"], $_POST["link"], $_POST["reward"], $_POST["delay"], $_POST["img"], $_POST["postback_enabled"], $_POST["postback_type"]);
}
if (check_value($_POST["deleteVote"])) {
    $vote->deleteVote($_POST["id"]);
}
if (check_value($_POST["link_edit"])) {
    $vote->updateLink($_POST["id"], $_POST["title"], $_POST["link"], $_POST["reward"], $_POST["delay"], $_POST["img"], $_POST["postback_enabled"], $_POST["postback_type"]);
}
loadModuleConfigs("usercp.vote");
$creditSystem = new CreditSystem($common, new Character(), $dB, $dB2);
echo "    <form action=\"index.php?module=modules_manager&config=vote\" method=\"post\">\n        <table class=\"table table-striped table-bordered table-hover module_config_tables\">\n            <tr>\n                <th>Status<br/><span>Enable/disable the vote module.</span></th>\n                <td>\n                    ";
enabledisableCheckboxes("setting_1", mconfig("active"), "Enabled", "Disabled");
echo "                </td>\n            </tr>\n            <!--<tr>\n                <th>Postback Confirmation<br/><span>Enable/disable postback confirmation. Enable it only if you have premium subscription on vote sites.<br>\n                    Use this names also in Vote Manager, otherwise postback will not works.</span></th>\n                <td>\n                    <b>XTREMETOP100:</b> ";
enabledisableCheckboxes("setting_20", mconfig("postback_xtremetop100"), "Enabled", "Disabled");
echo "<br>\n                    <b>GTOP100:</b> ";
enabledisableCheckboxes("setting_21", mconfig("postback_gtop100"), "Enabled", "Disabled");
echo "<br>\n                    <b>TOPG:</b> ";
enabledisableCheckboxes("setting_22", mconfig("postback_topg"), "Enabled", "Disabled");
echo "<br>\n                    <b>MMTOP200:</b> ";
enabledisableCheckboxes("setting_23", mconfig("postback_mmtop200"), "Enabled", "Disabled");
echo "                    <b>ULTRATOP100:</b> ";
enabledisableCheckboxes("setting_25", mconfig("postback_ultratop100"), "Enabled", "Disabled");
echo "                </td>\n            </tr>-->\n            <tr>\n                <th>Save Vote Logs<br/><span>If enabled, every vote will be permanently logged in a database table.</span></th>\n                <td>\n                    ";
enabledisableCheckboxes("setting_2", mconfig("vote_save_logs"), "Enabled", "Disabled");
echo "                </td>\n            </tr>\n            <tr>\n                <th>Credit Configuration<br/><span></span></th>\n                <td>\n                    ";
echo $creditSystem->buildSelectInput("setting_3", mconfig("credit_config"), "form-control");
echo "                </td>\n            </tr>\n            <tr>\n                <th>Required Level<br/><span>Required level of character to usevote module.</span></th>\n                <td>\n                    <input class=\"form-control\" type=\"text\" name=\"setting_9\" value=\"";
echo mconfig("required_level");
echo "\"/>\n                </td>\n            </tr>\n            <tr>\n                <th>Required Reset<br/><span>Required reset of character to usevote module.</span></th>\n                <td>\n                    <input class=\"form-control\" type=\"text\" name=\"setting_10\" value=\"";
echo mconfig("required_reset");
echo "\"/>\n                </td>\n            </tr>\n            <tr>\n                <th>IP Check<br/><span>Enable/disable IP check.</span></th>\n                <td>\n                    ";
enabledisableCheckboxes("setting_24", mconfig("ip_check"), "Enabled", "Disabled");
echo "                </td>\n            </tr>\n            <tr>\n                <th>Enable Auto Reward<br/><span>If enabled, every month top voters will be rewarded</span></th>\n                <td>\n                    ";
enabledisableCheckboxes("setting_4", mconfig("enable_auto_reward"), "Enabled", "Disabled");
echo "                </td>\n            </tr>\n            <tr>\n                <th>Reward Type<br/><span></span></th>\n                <td>\n                    <select name=\"setting_5\" class=\"form-control\">\n                        ";
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
echo "                    </select>\n                </td>\n            </tr>\n            <tr>\n                <th>Reward Amount<br/><span>Amount of reward what will be given to players</span></th>\n                <td>\n                    <input class=\"form-control\" type=\"text\" name=\"setting_6\" value=\"";
echo mconfig("reward_amount");
echo "\"/>\n                </td>\n            </tr>\n            <tr>\n                <th>Reward Amount Decrease<br/><span>For example, if Reward Amount = 500 and Reward Amount Decrease = 25, 1st player will gets 500, 2nd player will gets 475, 3rd player will gets 450 etc.</span>\n                </th>\n                <td>\n                    <input class=\"form-control\" type=\"text\" name=\"setting_7\" value=\"";
echo mconfig("reward_amount_decrease");
echo "\"/>\n                </td>\n            </tr>\n            <tr>\n                <th>MMOTOP.ru Postback File Link<br/><span>Enter link to MMOTOP.ru postback confirmation text file.<br><b>Example:</b> https://mmotop.ru/votes/someTextHere.txt</span></th>\n                <td>\n                    <input class=\"form-control\" type=\"text\" name=\"mmotop_postback_file\" value=\"";
echo mconfig("mmotop_postback_file");
echo "\"/>\n                </td>\n            </tr>\n            <tr>\n                <td colspan=\"2\"><input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\" class=\"btn btn-success\"/></td>\n            </tr>\n        </table>\n    </form>\n\n    <hr>\n    <h3>Add Vote Site</h3>\n";
message("info", "Each Postback Type can be used only once!");
echo "    <form action=\"index.php?module=modules_manager&config=vote\" method=\"post\">\n        <table class=\"table table-striped table-bordered table-hover module_config_tables\">\n            <tr>\n                <th>Title<br/><span>Enter Vote Site title.</span></th>\n                <td>\n                    <input class=\"form-control\" type=\"text\" name=\"title\" value=\"\" placeholder=\"Vote Title\"/>\n                </td>\n            </tr>\n            <tr>\n                <th>Link<br/><span>Enter Vote Site link.</span></th>\n                <td>\n                    <input class=\"form-control\" type=\"text\" name=\"link\" placeholder=\"Vote Link\"/>\n                </td>\n            </tr>\n            <tr>\n                <th>Reward<br/><span>Enter reward amount for vote.</span></th>\n                <td>\n                    <input class=\"form-control\" type=\"text\" name=\"reward\" placeholder=\"100\"/>\n                </td>\n            </tr>\n            <tr>\n                <th>Delay<br/><span>Enter vote delay until next vote in hours.</span></th>\n                <td>\n                    <input class=\"form-control\" type=\"text\" name=\"delay\" placeholder=\"24\"/>\n                </td>\n            </tr>\n            <tr>\n                <th>Image<br/><span>Enter URL to Vote Site image which will be displayed in UserCP module.</span></th>\n                <td>\n                    <input class=\"form-control\" type=\"text\" name=\"img\" placeholder=\"Image URL\"/>\n                </td>\n            </tr>\n            <tr>\n                <th>Postback<br/><span>Enable/disable postback confirmation. For more information about postback availability please contact Vote Site support.</span></th>\n                <td>\n                    ";
enabledisableCheckboxes("postback_enabled", 0, "Enabled", "Disabled");
echo "                </td>\n            </tr>\n            <tr>\n                <th>Postback Type<br/><span>Please select postback confirmation type, if postback is enabled.</span></th>\n                <td>\n                    <select name=\"postback_type\" class=\"form-control\">\n                        <option value=\"\">None</option>\n                        <option value=\"xtremetop100\">XTREMETOP100.com</option>\n                        <option value=\"gtop100\">GTOP100.com</option>\n                        <option value=\"topg\">TOPG.org</option>\n                        <option value=\"mmtop200\">MMTOP200.com</option>\n                        <option value=\"mmotop\">MMOTOP.ru</option>\n                    </select>\n                </td>\n            </tr>\n            <tr>\n                <td colspan=\"2\"><input type=\"submit\" name=\"add_vote_site\" value=\"Add Vote Site\" class=\"btn btn-success\" style=\"width: 100%;\"/></td>\n            </tr>\n        </table>\n    </form>\n\n    <hr>\n    <h3>Manage Vote Sites</h3>\n<table class=\"table table-striped table-bordered table-hover\"><tr><th>Title</th><th>Link</th><th>Reward</th><th>Delay</th><th>URL to Image</th><th>Postback</th><th>Postback Type</th><th></th></tr>";
$sites = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_VOTE_SITES ORDER BY votesite_id");
$i = 1;
foreach ($sites as $thisSite) {
    if ($thisSite["active"] == "1") {
        $activeBtn = "<input type=\"submit\" class=\"btn btn-danger\" name=\"switchStatus\" value=\"Disable\" />";
    } else {
        $activeBtn = "<input type=\"submit\" class=\"btn btn-success\" name=\"switchStatus\" value=\"Enable\" />";
    }
    echo "<form action=\"\" method=\"post\">";
    echo "<input type=\"hidden\" name=\"id\" value=\"" . $thisSite["votesite_id"] . "\"/>";
    echo "<tr>";
    echo "<td><input name=\"title\" class=\"form-control\" type=\"text\" value=\"" . $thisSite["votesite_title"] . "\"/></td>";
    echo "<td><input name=\"link\" class=\"form-control\" type=\"text\" value=\"" . $thisSite["votesite_link"] . "\"/></td>";
    echo "<td><input name=\"reward\" class=\"form-control\" type=\"text\" value=\"" . $thisSite["votesite_reward"] . "\"/></td>";
    echo "<td><input name=\"delay\" class=\"form-control\" type=\"text\" value=\"" . $thisSite["votesite_time"] . "\"/></td>";
    echo "<td><input name=\"img\" class=\"form-control\" type=\"text\" value=\"" . $thisSite["img"] . "\"/></td>";
    echo "<td>";
    enabledisableCheckboxes("postback_enabled", $thisSite["postback_enabled"], "Enabled", "Disabled");
    echo "</td><td><select name=\"postback_type\" class=\"form-control\">";
    if ($thisSite["postback_type"] == "" || $thisSite["postback_type"] == NULL) {
        echo "<option value=\"\" selected=\"selected\">None</option>";
    } else {
        echo "<option value=\"\">None</option>";
    }
    if ($thisSite["postback_type"] == "xtremetop100") {
        echo "<option value=\"xtremetop100\" selected=\"selected\">XTREMETOP100.com</option>";
    } else {
        echo "<option value=\"xtremetop100\">XTREMETOP100.com</option>";
    }
    if ($thisSite["postback_type"] == "gtop100") {
        echo "<option value=\"gtop100\" selected=\"selected\">GTOP100.com</option>";
    } else {
        echo "<option value=\"gtop100\">GTOP100.com</option>";
    }
    if ($thisSite["postback_type"] == "topg") {
        echo "<option value=\"topg\" selected=\"selected\">TOPG.org</option>";
    } else {
        echo "<option value=\"topg\">TOPG.org</option>";
    }
    if ($thisSite["postback_type"] == "mmtop200") {
        echo "<option value=\"mmtop200\" selected=\"selected\">MMTOP200.com</option>";
    } else {
        echo "<option value=\"mmtop200\">MMTOP200.com</option>";
    }
    if ($thisSite["postback_type"] == "mmotop") {
        echo "<option value=\"mmotop\" selected=\"selected\">MMOTOP.ru</option>";
    } else {
        echo "<option value=\"mmotop\">MMOTOP.ru</option>";
    }
    echo "</select></td>";
    echo "<td>" . $activeBtn . " <input type=\"submit\" class=\"btn btn-success\" name=\"link_edit\" value=\"Save\"/>";
    echo " <a href=\"index.php?module=modules_manager&config=vote&delete=" . $thisSite["votesite_id"] . "\" class=\"btn btn-danger\" title=\"Delete\"><i class=\"fa fa-remove\"></i></a>";
    echo "</td></tr></form>";
    $i++;
}
echo "</table>";
function saveChanges()
{
    
    foreach ($_POST as $setting) {
        if (!check_value($setting)) {
            message("error", "Missing data (complete all fields).");
            return NULL;
        }
    }
    $xmlPath = __PATH_MODULE_CONFIGS__ . "usercp.vote.xml";
    $xml = simplexml_load_file($xmlPath);
    $xml->active = $_POST["setting_1"];
    $xml->vote_save_logs = $_POST["setting_2"];
    $xml->credit_config = $_POST["setting_3"];
    $xml->required_level = $_POST["setting_9"];
    $xml->required_reset = $_POST["setting_10"];
    $xml->ip_check = $_POST["setting_24"];
    $xml->enable_auto_reward = $_POST["setting_4"];
    $xml->reward_type = $_POST["setting_5"];
    $xml->reward_amount = $_POST["setting_6"];
    $xml->reward_amount_decrease = $_POST["setting_7"];
    $xml->mmotop_postback_file = $_POST["mmotop_postback_file"];
    $save = $xml->asXML($xmlPath);
    if ($save) {
        message("success", "Settings successfully saved.");
    } else {
        message("error", "There has been an error while saving changes.");
    }
}

?>