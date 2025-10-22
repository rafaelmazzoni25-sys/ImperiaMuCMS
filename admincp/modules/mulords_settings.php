<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h2>MU Lords Settings</h2>\r\n";
$Market = new Market();
if (check_value($_POST["submit_changes"])) {
    savechanges();
}
if (check_value($_GET["delete"])) {
    $id = htmlspecialchars($_GET["delete"]);
    $delete = $dB->query("DELETE FROM IMPERIAMUCMS_MU_LORDS_RANKS_REWARDS WHERE id = ?", [$id]);
    if ($delete) {
        message("success", "Reward was successfully deleted.");
    } else {
        message("error", "Reward does not exist.");
    }
}
if (check_value($_POST["edit_submit"])) {
    $update = $dB->query("UPDATE IMPERIAMUCMS_MU_LORDS_RANKS SET rank = ?, req_level = ?, req_donation = ?, req_coins = ? WHERE id = ?", [$_POST["name"], $_POST["req_level"], $_POST["req_donation"], $_POST["req_coins"], $_POST["id"]]);
    if ($update) {
        message("success", "Rank was successfully updated.");
    } else {
        message("error", "Rank could not be updated, please check your values.");
    }
}
if (check_value($_POST["add_submit"])) {
    $rank_id = htmlspecialchars($_POST["rank"]);
    $type = htmlspecialchars($_POST["type"]);
    if ($type == "7") {
        $item = htmlspecialchars($_POST["reward"]);
        $reward = NULL;
        $type = NULL;
    } else {
        $item = NULL;
        $reward = htmlspecialchars($_POST["reward"]);
    }
    $insert = $dB->query("INSERT INTO IMPERIAMUCMS_MU_LORDS_RANKS_REWARDS (rank_id, reward, reward_type, item) VALUES(?, ?, ?, ?)", [$rank_id, $reward, $type, $item]);
    if ($insert) {
        message("success", "Reward was successfully created.");
    } else {
        message("error", "Reward could not be created, please check your values.");
    }
}
loadModuleConfigs("mulords");
echo "    <form action=\"index.php?module=mulords_settings\" method=\"post\">\r\n        <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n            <tr>\r\n                <th>Status<br/><span>Enable/disable the MU Lords module.</span></th>\r\n                <td>\r\n                    ";
enabledisableCheckboxes("setting_1", mconfig("active"), "Enabled", "Disabled");
echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <td colspan=\"2\"><input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\"\r\n                                       class=\"btn btn-success\"/></td>\r\n            </tr>\r\n        </table>\r\n    </form>\r\n\r\n    <hr>\r\n    <h3>Manage Ranks</h3>\r\n<table class=\"table table-striped table-bordered table-hover\"><tr><th>Name</th><th>Required Level</th><th>Required Donation</th><th>Required Gold Coins</th><th></th></tr>";
$ranks = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_MU_LORDS_RANKS ORDER BY id");
foreach ($ranks as $rank) {
    echo "<form action=\"index.php?module=mulords_settings\" method=\"post\">";
    echo "<input type=\"hidden\" name=\"id\" value=\"" . $rank["id"] . "\"/>";
    echo "<tr>";
    echo "<td><input name=\"name\" class=\"form-control\" type=\"text\" value=\"" . $rank["rank"] . "\"/></td>";
    echo "<td><input name=\"req_level\" class=\"form-control\" type=\"text\" value=\"" . $rank["req_level"] . "\"/></td>";
    echo "<td><input name=\"req_donation\" class=\"form-control\" type=\"text\" value=\"" . $rank["req_donation"] . "\"/></td>";
    echo "<td><input name=\"req_coins\" class=\"form-control\" type=\"text\" value=\"" . $rank["req_coins"] . "\"/></td>";
    echo "<td>\r\n            <input type=\"submit\" class=\"btn btn-success\" name=\"edit_submit\" value=\"Save\"/>\r\n          </td></tr></form>";
}
echo "</table>\r\n    <hr>\r\n    <h3>Manage Rank's Rewards</h3>\r\n<table class=\"table table-striped table-bordered table-hover\"><tr><th>Rank</th><th>Reward</th><th></th></tr>";
$rankRewards = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_MU_LORDS_RANKS_REWARDS ORDER BY rank_id");
$rankName = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_MU_LORDS_RANKS");
foreach ($rankRewards as $thisReward) {
    $index = $thisReward["rank_id"] - 1;
    echo "<form action=\"index.php?module=mulords_settings\" method=\"post\">";
    echo "<input type=\"hidden\" name=\"id\" value=\"" . $thisReward["id"] . "\"/>";
    echo "<tr>";
    echo "<td>" . $rankName[$index]["rank"] . "</td>";
    if ($thisReward["reward"] != NULL) {
        $title = $dB->query_fetch_single("SELECT config_title FROM IMPERIAMUCMS_CREDITS_CONFIG WHERE config_id = ?", [$thisReward["reward_type"]]);
        echo "<td>" . $thisReward["reward"] . " " . $title["config_title"] . "</td>";
    } else {
        $Market = new Market();
        $Items = new Items();
        $itemInfo = $Items->ItemInfo($thisReward["item"]);
        echo "<td>" . $itemInfo["name"] . " (" . $thisReward["item"] . ")</td>";
    }
    echo "<td>\r\n            <a href=\"index.php?module=mulords_settings&delete=" . $thisReward["id"] . "\" class=\"btn btn-danger\"><i class=\"fa fa-remove\"></i></a>\r\n          </td>";
    echo "</tr></form>";
}
echo "</table>";
$ranksList = "";
foreach ($rankName as $thisRank) {
    $ranksList .= "<option value=\"" . $thisRank["id"] . "\">" . $thisRank["rank"] . "</option>";
}
echo "\r\n<script type=\"text/javascript\">\r\nfunction popitup(url) {\r\n\tnewwindow=window.open(url,'name','height = 550,width = 600');\r\n\tif (window.focus) {newwindow.focus()}\r\n\treturn false;\r\n}\r\n</script><hr>\r\n<h3>Add New Reward</h3>\r\n<input class=\"btn btn-primary\" type=\"button\" onClick=\"popitup('item_hex_generator.php')\" value=\"Item Code Generator\" title=\"Item Code Generator\"><table class=\"table table-striped table-bordered table-hover\"><tr><th>Rank</th><th>Reward</th><th>Reward Type</th><th></th></tr><form action=\"index.php?module=mulords_settings\" method=\"post\"><tr><td><select name=\"rank\" class=\"form-control\">";
echo $ranksList;
echo "</select></td><td><input name=\"reward\" class=\"form-control\" type=\"text\" value=\"\" /></td><td>\r\n        <select name=\"type\" class=\"form-control\">\r\n            <option value=\"1\">Platinum Coins</option>\r\n            <option value=\"2\">Gold Coins</option>\r\n            <option value=\"3\">Silver Coins</option>\r\n            <option value=\"4\">WCoinC</option>\r\n            <option value=\"5\">Goblin Points</option>\r\n            <option value=\"6\">Zen</option>\r\n            <option value=\"7\">Item</option>\r\n        </select>\r\n      </td><td>\r\n        <input type=\"submit\" class=\"btn btn-success\" name=\"add_submit\" value=\"Add\"/>\r\n      </td></tr></form></table>";
function saveChanges()
{
    foreach ($_POST as $setting) {
        if (!check_value($setting)) {
            message("error", "Missing data (complete all fields).");
            return NULL;
        }
    }
    $xmlPath = __PATH_MODULE_CONFIGS__ . "mulords.xml";
    $xml = simplexml_load_file($xmlPath);
    $xml->active = $_POST["setting_1"];
    $save = $xml->asXML($xmlPath);
    if ($save) {
        message("success", "Settings successfully saved.");
    } else {
        message("error", "There has been an error while saving changes.");
    }
}

?>