<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h2>Daily/Weekly/Monthly Rankings Rewards Settings</h2>\r\n";
define("__RESPONSIVE__", "FALSE");
echo "<script type=\"text/javascript\" SRC=\"" . __PATH_TEMPLATE_ASSETS__ . "js/tooltip.js\"></script>";
$Items = new Items();
$monsterList = monsterList();
$rankType = ["daily_characters" => "Daily Characters", "daily_level" => "Daily Levels", "daily_master" => "Daily Master Levels", "daily_resets" => "Daily Resets", "daily_grandresets" => "Daily Grand Resets", "daily_killers" => "Daily Killers", "daily_duels" => "Daily Duels", "daily_bloodcastle" => "Daily Blood Castle", "daily_devilsquare" => "Daily Devil Square", "daily_chaoscastle" => "Daily Chaos Castle", "daily_illusiontemple" => "Daily Illusion Temple", "weekly_characters" => "Weekly Characters", "weekly_level" => "Weekly Levels", "weekly_master" => "Weekly Master Levels", "weekly_resets" => "Weekly Resets", "weekly_grandresets" => "Weekly Grand Resets", "weekly_killers" => "Weekly Killers", "weekly_duels" => "Weekly Duels", "weekly_bloodcastle" => "Weekly Blood Castle", "weekly_devilsquare" => "Weekly Devil Square", "weekly_chaoscastle" => "Weekly Chaos Castle", "weekly_illusiontemple" => "Weekly Illusion Temple", "monthly_characters" => "Monthly Characters", "monthly_level" => "Monthly Levels", "monthly_master" => "Monthly Master Levels", "monthly_resets" => "Monthly Resets", "monthly_grandresets" => "Monthly Grand Resets", "monthly_killers" => "Monthly Killers", "monthly_duels" => "Monthly Duels", "monthly_bloodcastle" => "Monthly Blood Castle", "monthly_devilsquare" => "Monthly Devil Square", "monthly_chaoscastle" => "Monthly Chaos Castle", "monthly_illusiontemple" => "Monthly Illusion Temple"];
if (check_value($_GET["delete"]) && is_numeric($_GET["delete"])) {
    $checkReward = $dB->query_fetch_single("SELECT id FROM IMPERIAMUCMS_RANKINGS_REWARDS WHERE id = ?", [$_GET["delete"]]);
    if (is_array($checkReward)) {
        $delete = $dB->query("DELETE FROM IMPERIAMUCMS_RANKINGS_REWARDS WHERE id = ?", [$_GET["delete"]]);
        if ($delete) {
            message("success", "Reward #" . $_GET["delete"] . " was deleted successfully.");
        } else {
            message("error", "Could not delete reward #" . $_GET["delete"] . ", please contact administrator.");
        }
    } else {
        message("error", "Reward #" . $_GET["delete"] . " was already deleted or it does not exist.");
    }
}
if (check_value($_POST["add_reward"])) {
    try {
        if (empty($_POST["rank_type"])) {
            throw new Exception("Please select Rankings Type.");
        }
        if (empty($_POST["highest_pos"])) {
            throw new Exception("Please enter Highest Position in Rankings.");
        }
        if (!is_numeric($_POST["highest_pos"]) || $_POST["highest_pos"] < 1) {
            throw new Exception("Highest Position in Rankings must be a number.");
        }
        if (empty($_POST["lowest_pos"])) {
            throw new Exception("Please enter Lowest Position in Rankings.");
        }
        if (!is_numeric($_POST["lowest_pos"]) || $_POST["lowest_pos"] < 1) {
            throw new Exception("Lowest Position in Rankings must be a number.");
        }
        if ($_POST["amount"] != NULL && $_POST["amount"] != "") {
            if (!is_numeric($_POST["amount"]) || $_POST["amount"] < 0) {
                throw new Exception("Reward Amount must be a number.");
            }
            if (empty($_POST["amount_type"]) || $_POST["amount_type"] < 0) {
                throw new Exception("Please select Reward Amount Type.");
            }
        }
        $typeID = 0;
        if (strpos($_POST["rank_type"], "daily") !== false) {
            $typeID = 1;
            $tmp = explode("_", $_POST["rank_type"]);
            $xi = 0;
            while ($xi < count($tmp)) {
                $tmp[$xi] = ucfirst($tmp[$xi]);
                $xi++;
            }
            $typeText = implode(" ", $tmp);
        }
        if (strpos($_POST["rank_type"], "weekly") !== false) {
            $typeID = 2;
            $tmp = explode("_", $_POST["rank_type"]);
            $xi = 0;
            while ($xi < count($tmp)) {
                $tmp[$xi] = ucfirst($tmp[$xi]);
                $xi++;
            }
            $typeText = implode(" ", $tmp);
        }
        if (strpos($_POST["rank_type"], "monthly") !== false) {
            $typeID = 3;
            $tmp = explode("_", $_POST["rank_type"]);
            $xi = 0;
            while ($xi < count($tmp)) {
                $tmp[$xi] = ucfirst($tmp[$xi]);
                $xi++;
            }
            if (strpos($_POST["rank_type"], "monster_hunter") !== false && strpos($_POST["rank_type"], "monster_hunter_all") === false) {
                $tmp[3] = $monsterList["monster_" . $tmp[3]];
            }
            $typeText = implode(" ", $tmp);
        }
        $reward_items = "";
        $i = 0;
        while ($i < 50) {
            $index = "item" . $i;
            if (empty($_POST[$index . "_expiration"])) {
                $_POST[$index . "_expiration"] = 0;
            }
            if (!($_POST[$index] == NULL || $_POST[$index] == __ITEM_EMPTY__)) {
                if ($reward_items == NULL || empty($reward_items)) {
                    $reward_items .= $_POST[$index] . ":" . $_POST[$index . "_expiration"];
                } else {
                    $reward_items .= "," . $_POST[$index] . ":" . $_POST[$index . "_expiration"];
                }
            }
            $i++;
        }
        if ($reward_items == "") {
            $reward_items = NULL;
        }
        if ($_POST["items_type"] == "") {
            $_POST["items_type"] = NULL;
        }
        if ($_POST["reward_exp"] == "") {
            $_POST["reward_exp"] = NULL;
        }
        if ($_POST["items_exp"] == "") {
            $_POST["items_exp"] = NULL;
        }
        $insert = $dB->query("INSERT INTO IMPERIAMUCMS_RANKINGS_REWARDS (TypeID, Type, Type_Text, Highest_Rank, Lowest_Rank, Reward_Items, Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration, Active) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$typeID, $_POST["rank_type"], $typeText, $_POST["highest_pos"], $_POST["lowest_pos"], $reward_items, $_POST["items_type"], $_POST["amount"], $_POST["amount_type"], $_POST["reward_exp"], NULL, 1]);
        if ($insert) {
            message("success", "Reward was created successfully.");
        } else {
            message("error", "Unexpected error occurred, please check your values. If problem persists, please contact website developer.");
        }
    } catch (Exception $ex) {
        message("error", $ex->getMessage());
    }
}
if (check_value($_POST["edit_rewards"])) {
    try {
        if (is_array($_POST["rewards"])) {
            $query = "";
            $isError = false;
            foreach ($_POST["rewards"] as $thisReward) {
                if (empty($thisReward["rank_type"])) {
                    throw new Exception("Please select Rankings Type.");
                }
                if (empty($thisReward["highest_pos"])) {
                    throw new Exception("Please enter Highest Position in Rankings.");
                }
                if (!is_numeric($thisReward["highest_pos"]) || $thisReward["highest_pos"] < 1) {
                    throw new Exception("Highest Position in Rankings must be a number.");
                }
                if (empty($thisReward["lowest_pos"])) {
                    throw new Exception("Please enter Lowest Position in Rankings.");
                }
                if (!is_numeric($thisReward["lowest_pos"]) || $thisReward["lowest_pos"] < 1) {
                    throw new Exception("Lowest Position in Rankings must be a number.");
                }
                if ($thisReward["amount"] != NULL && $thisReward["amount"] != "") {
                    if (!is_numeric($thisReward["amount"]) || $thisReward["amount"] < 0) {
                        throw new Exception("Reward Amount must be a number.");
                    }
                    if (empty($thisReward["amount_type"]) || $thisReward["amount_type"] < 0) {
                        throw new Exception("Please select Reward Amount Type.");
                    }
                }
                $typeID = 0;
                if (strpos($thisReward["rank_type"], "daily") !== false) {
                    $typeID = 1;
                    $tmp = explode("_", $thisReward["rank_type"]);
                    $xi = 0;
                    while ($xi < count($tmp)) {
                        $tmp[$xi] = ucfirst($tmp[$xi]);
                        $xi++;
                    }
                    $typeText = implode(" ", $tmp);
                }
                if (strpos($thisReward["rank_type"], "weekly") !== false) {
                    $typeID = 2;
                    $tmp = explode("_", $thisReward["rank_type"]);
                    $xi = 0;
                    while ($xi < count($tmp)) {
                        $tmp[$xi] = ucfirst($tmp[$xi]);
                        $xi++;
                    }
                    $typeText = implode(" ", $tmp);
                }
                if (strpos($thisReward["rank_type"], "monthly") !== false) {
                    $typeID = 3;
                    $tmp = explode("_", $thisReward["rank_type"]);
                    $xi = 0;
                    while ($xi < count($tmp)) {
                        $tmp[$xi] = ucfirst($tmp[$xi]);
                        $xi++;
                    }
                    if (strpos($thisReward["rank_type"], "monster_hunter") !== false && strpos($thisReward["rank_type"], "monster_hunter_all") === false) {
                        $tmp[3] = $monsterList["monster_" . $tmp[3]];
                    }
                    $typeText = implode(" ", $tmp);
                }
                $reward_items = "";
                if (is_array($thisReward["items"])) {
                    $i = 0;
                    foreach ($thisReward["items"] as $thisItem) {
                        if (empty($thisReward["items_exp"][$i])) {
                            $thisReward["items_exp"][$i] = 0;
                        }
                        if (!($thisItem == NULL || $thisItem == __ITEM_EMPTY__)) {
                            if ($reward_items == NULL || empty($reward_items)) {
                                $reward_items .= $thisItem . ":" . $thisReward["items_exp"][$i];
                            } else {
                                $reward_items .= "," . $thisItem . ":" . $thisReward["items_exp"][$i];
                            }
                        }
                    }
                }
                if ($reward_items == "") {
                    $reward_items = NULL;
                }
                if ($thisReward["items_type"] == "") {
                    $thisReward["items_type"] = NULL;
                }
                if ($thisReward["reward_exp"] == "") {
                    $thisReward["reward_exp"] = NULL;
                }
                $update = $dB->query("UPDATE IMPERIAMUCMS_RANKINGS_REWARDS SET TypeID = ?, Type = ?, Type_Text = ?, Highest_Rank = ?, Lowest_Rank = ?, Reward_Items = ?, Reward_Items_Type = ?, Reward_Amount = ?, Reward_Amount_Type = ?, Expiration = ?, Items_Expiration = ?, Active = ?\r\n                                      WHERE id = ?", [$typeID, $thisReward["rank_type"], $typeText, $thisReward["highest_pos"], $thisReward["lowest_pos"], $reward_items, $thisReward["items_type"], $thisReward["amount"], $thisReward["amount_type"], $thisReward["reward_exp"], NULL, $thisReward["status"], $thisReward["id"]]);
                if (!$update) {
                    $isError = true;
                }
            }
            if (!$isError) {
                message("success", "Rewards were saved successfully.");
            }
        }
    } catch (Exception $ex) {
        message("error", $ex->getMessage());
    }
}
echo "    <h3>Add New Reward</h3>\r\n    <form method=\"post\" action=\"";
echo admincp_base("modules_manager&config=rankings_rewards");
echo "\">\r\n        <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n            <tr>\r\n                <th>Rankings Type<br/><span>Select rankings type for what you want to create new reward.</span></th>\r\n                <td>\r\n                    <select class=\"form-control\" name=\"rank_type\">\r\n                        <option value=\"0\" disabled=\"disabled\" selected=\"selected\">Select Rankings Type</option>\r\n                        ";
foreach ($rankType as $key => $value) {
    echo "<option value=\"" . $key . "\">" . $value . "</option>";
}
echo "                        <optgroup label=\"Monster Hunter\"></optgroup>\r\n                        ";
$xml = simplexml_load_file(__PATH_INCLUDES__ . "config/modules/monster_hunter.xml");
if ($xml !== false) {
    $array = [];
    $i = 1;
    foreach ($xml->children() as $tag => $monster) {
        if ($monster["id"] == "-1") {
            $monsterId = "all";
        } else {
            $monsterId = $monster["id"];
        }
        echo "<option value=\"monthly_monster_hunter_" . $monsterId . "\">Monthly Monster Hunter " . $monsterList["monster_" . $monsterId] . "</option>";
        echo "<option value=\"weekly_monster_hunter_" . $monsterId . "\">Weekly Monster Hunter " . $monsterList["monster_" . $monsterId] . "</option>";
        echo "<option value=\"daily_monster_hunter_" . $monsterId . "\">Daily Monster Hunter " . $monsterList["monster_" . $monsterId] . "</option>";
    }
}
echo "                    </select>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Highest Position in Rankings<br/><span>Enter highest position in rankings for who will be reward.<br><b>Example:</b> If highest position will be \"1\" and lowest position will be \"3\", this reward will be used for 1st, 2nd and 3rd ranks.</span>\r\n                </th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"highest_pos\" value=\"\" placeholder=\"Highest position in Rankings\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Lowest Position in Rankings<br/><span>Enter lowest position in rankings for who will be reward.<br><b>Example:</b> If highest position will be \"1\" and lowest position will be \"1\", this reward will be used only for 1st rank.</span>\r\n                </th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"lowest_pos\" value=\"\" placeholder=\"Lowest position in Rankings\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Reward Amount<br/><span>Enter amount of currency.</span></th>\r\n                <td>\r\n                    <table width=\"100%\">\r\n                        <tr>\r\n                            <td width=\"50%\"><input class=\"form-control\" type=\"text\" name=\"amount\" value=\"\" placeholder=\"Reward Amount\"/></td>\r\n                            <td width=\"50%\">\r\n                                <select name=\"amount_type\" class=\"form-control\">\r\n                                    <option value=\"0\" disabled=\"disabled\" selected=\"selected\">Select Currency Type</option>\r\n                                    <option value=\"1\">Platinum Coins</option>\r\n                                    <option value=\"2\">Gold Coins</option>\r\n                                    <option value=\"3\">Silver Coins</option>\r\n                                    <option value=\"4\">WCoinC</option>\r\n                                    <option value=\"7\">WCoinP</option>\r\n                                    <option value=\"5\">Goblin Points</option>\r\n                                    <option value=\"6\">Zen</option>\r\n                                    <option value=\"8\">Ruud</option>\r\n                                </select>\r\n                            </td>\r\n                        </tr>\r\n                    </table>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Reward Items<br/><span>Configure reward items.</span></th>\r\n                <td>\r\n                    <select name=\"items_type\" class=\"form-control\">\r\n                        <option value=\"0\" selected=\"selected\">Select Reward Type</option>\r\n                        <option value=\"1\">Single Item (with choice)</option>\r\n                        <option value=\"2\">Multiple Items</option>\r\n                        <option value=\"3\">Random Item</option>\r\n                    </select>\r\n                    <hr>\r\n                    <div id=\"newItem\" style=\"padding-bottom: 10px;\"></div>\r\n                    <script type=\"text/javascript\">\r\n                        var iid = 0;\r\n\r\n                        function popitup(url) {\r\n                            newwindow = window.open(url, 'name', 'height = 550, width = 600');\r\n                            if (window.focus) {\r\n                                newwindow.focus()\r\n                            }\r\n                            return false;\r\n                        }\r\n\r\n                        function addItem() {\r\n                            var newItem = \$('#newItem');\r\n                            var html = '<div class=\"row\" style=\"padding-bottom: 5px;\"><div class=\"col-xs-12 col-lg-8\">Item ' + (iid + 1) + ': ' +\r\n                                '<input type=\"text\" class=\"form-control\" maxlength=\"64\" size=\"64\" name=\"item' + iid + '\" value=\"";
echo __ITEM_EMPTY__;
echo "\" /></div>' +\r\n                                '<div class=\"col-xs-12 col-lg-4\">Item ' + (iid + 1) + ' Expiration: <input type=\"text\" class=\"form-control\" name=\"item' + iid + '_expiration\" value=\"\" placeholder=\"Exp. in minutes\" /></div></div>';\r\n                            newItem.append(html);\r\n                            iid = iid + 1;\r\n                        }\r\n                    </script>\r\n                    <input type=\"button\" value=\"Add New\" class=\"btn btn-primary\" onClick=\"addItem();\">\r\n                    <input class=\"btn btn-primary\" type=\"button\" onClick=\"popitup('item_hex_generator.php')\" value=\"Item Code Generator\" title=\"Item Code Generator\">\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Reward Expiration<br/><span>Leave empty if unlimited. If won't be empty, reward will be available for claim only until selected date & time.<br>Format: YYYY-MM-DD HH:MM:SS</span>\r\n                </th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"reward_exp\" value=\"\" placeholder=\"YYYY-MM-DD HH:MM:SS\"/>\r\n                </td>\r\n            </tr>\r\n        </table>\r\n        <button type=\"submit\" class=\"btn btn-large btn-block btn-success\" name=\"add_reward\" value=\"ok\">Add Reward</button>\r\n    </form>\r\n\r\n    <br/><br/><br/>\r\n    <hr>\r\n    <table width=\"100%\" style=\"margin-bottom: 12px;\">\r\n        <tr>\r\n            <td><h3>Manage Rewards</h3></td>\r\n            <td align=\"right\">\r\n                <button id=\"editMode\" class=\"btn btn-primary\" onclick=\"enableEditMode(); return false;\">Enable Edit Mode</button>\r\n            </td>\r\n        </tr>\r\n    </table>\r\n\r\n";
$rewards = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_RANKINGS_REWARDS ORDER BY TypeID ASC, Type ASC, Highest_Rank ASC, Lowest_Rank ASC");
if (is_array($rewards)) {
    echo "    <form method=\"post\" action=\"";
    echo admincp_base("modules_manager&config=rankings_rewards");
    echo "\">\r\n        <table id=\"viewTable\" class=\"table table-striped table-bordered table-hover\">\r\n            <tr>\r\n                <th>#</th>\r\n                <th>Type</th>\r\n                <th>Rank</th>\r\n                <th>Reward</th>\r\n                <th>Reward Items</th>\r\n                <th>Status</th>\r\n                <th>Action</th>\r\n            </tr>\r\n            ";
    $i = 1;
    foreach ($rewards as $thisReward) {
        $currName = "";
        switch ($thisReward["Reward_Amount_Type"]) {
            case "1":
                $currName = "Platinum Coins";
                break;
            case "2":
                $currName = "Gold Coins";
                break;
            case "3":
                $currName = "Silver Coins";
                break;
            case "4":
                $currName = "WCoinC";
                break;
            case "5":
                $currName = "Goblin Points";
                break;
            case "6":
                $currName = "Zen";
                break;
            case "7":
                $currName = "WCoinP";
                break;
            case "8":
                $currName = "Ruud";
                break;
            default:
                $currReward = "--";
                if (0 < $thisReward["Reward_Amount"] && $currName != "") {
                    $currReward = number_format($thisReward["Reward_Amount"]) . " " . $currName;
                }
                if (!empty($thisReward["Reward_Items"])) {
                    $rewardItems = explode(",", $thisReward["Reward_Items"]);
                    $rewardItemsShow = "";
                    $j = 0;
                    foreach ($rewardItems as $thisItem) {
                        $itemData = explode(":", $thisItem);
                        list($itemHex, $itemExp) = $itemData;
                        $itemInfo = $Items->ItemInfo($itemHex);
                        $rewardItemsShow .= "<span style=\"cursor: pointer;\" onmouseover=\"Tip(" . $Items->generateItemTooltip($itemInfo, 1, 0, 1, 1, 1, $itemExp) . ")\" onmouseout=\"UnTip()\">" . $itemInfo["name"] . "</span>";
                        if ($j != count($rewardItems) - 1) {
                            $rewardItemsShow .= ", ";
                        }
                        $j++;
                    }
                } else {
                    $rewardItemsShow = "--";
                }
                echo "\r\n                <tr>\r\n                    <td>" . $i . "</td>\r\n                    <td>" . $thisReward["Type_Text"] . "</td>\r\n                    <td>";
                if ($thisReward["Highest_Rank"] == $thisReward["Lowest_Rank"]) {
                    echo $thisReward["Highest_Rank"];
                } else {
                    echo $thisReward["Highest_Rank"] . " - " . $thisReward["Lowest_Rank"];
                }
                $status = "";
                $actionButtons = "";
                if ($thisReward["Active"] == "1") {
                    $status = "<span class=\"label label-success\">Active</span>";
                } else {
                    $status = "<span class=\"label label-danger\">Inactive</span>";
                }
                echo "\r\n                    </td>\r\n                    <td>" . $currReward . "</td>\r\n                    <td>" . $rewardItemsShow . "</td>\r\n                    <td>" . $status . "</td>\r\n                    <td><a href=\"" . admincp_base("modules_manager&config=rankings_rewards&delete=" . $thisReward["id"]) . "\" class=\"btn btn-block btn-danger btn-xs\" onclick=\"if(confirm('Do you really want to delete this reward? ')) return true; else return false;\">Delete</a></td>\r\n                </tr>";
                $i++;
        }
    }
    echo "        </table>\r\n\r\n        <table id=\"editTable\" class=\"table table-striped table-bordered table-hover hidden\">\r\n            <tr>\r\n                <td colspan=\"8\">";
    message("notice", "To delete an item from reward just delete item's hex code from field and \"Save Rewards\".");
    echo "</td>\r\n            </tr>\r\n            <tr>\r\n                <th>#</th>\r\n                <th>Type</th>\r\n                <th>Rank</th>\r\n                <th>Reward</th>\r\n                <th>Reward Items</th>\r\n                <th>Reward Expiration</th>\r\n                <th>Status</th>\r\n            </tr>\r\n            ";
    $i = 1;
    foreach ($rewards as $thisReward) {
        $rewardItemsShow = "";
        $totalItems = 0;
        if (!empty($thisReward["Reward_Items"])) {
            $rewardItems = explode(",", $thisReward["Reward_Items"]);
            $j = 0;
            foreach ($rewardItems as $thisItem) {
                $itemData = explode(":", $thisItem);
                list($itemHex, $itemExp) = $itemData;
                $itemInfo = $Items->ItemInfo($itemHex);
                $rewardItemsShow .= "\r\n                        <div class=\"row\" style=\"padding-bottom: 5px;\"><div class=\"col-xs-12 col-lg-8\"><span style=\"cursor: pointer;\" onmouseover=\"Tip(" . $Items->generateItemTooltip($itemInfo, 1, 0, 1, 1, 1, $itemExp) . ")\" onmouseout=\"UnTip()\">" . $itemInfo["name"] . "</span>:\r\n                        <input type=\"text\" class=\"form-control\" maxlength=\"64\" size=\"64\" name=\"rewards[" . $i . "][items][]\" value=\"" . $itemHex . "\" /></div>\r\n                        <div class=\"col-xs-12 col-lg-4\">Expiration: <input type=\"text\" class=\"form-control\" name=\"rewards[" . $i . "][items_exp][]\" value=\"" . $itemExp . "\" placeholder=\"Exp. in minutes\" /></div></div>";
                if ($j != count($rewardItems) - 1) {
                    $rewardItemsShow .= "<br />";
                }
                $totalItems++;
                $j++;
            }
        }
        echo "\r\n                <tr>\r\n                    <td>" . $i . "<input type=\"hidden\" name=\"rewards[" . $i . "][id]\" value=\"" . $thisReward["id"] . "\" /></td>\r\n                    <td>\r\n                        <select class=\"form-control\" name=\"rewards[" . $i . "][rank_type]\">";
        foreach ($rankType as $key => $value) {
            if ($thisReward["Type"] == $key) {
                echo "<option value=\"" . $key . "\" selected=\"selected\">" . $value . "</option>";
            } else {
                echo "<option value=\"" . $key . "\">" . $value . "</option>";
            }
        }
        echo "<optgroup label=\"Monster Hunter\"></optgroup>";
        $xml = simplexml_load_file(__PATH_INCLUDES__ . "config/modules/monster_hunter.xml");
        if ($xml !== false) {
            $array = [];
            foreach ($xml->children() as $tag => $monster) {
                if ($monster["id"] == "-1") {
                    $monsterId = "all";
                } else {
                    $monsterId = $monster["id"];
                }
                if ($thisReward["Type"] == "monthly_monster_hunter_" . $monsterId . "") {
                    echo "<option value=\"monthly_monster_hunter_" . $monsterId . "\" selected=\"selected\">Monthly Monster Hunter " . $monsterList["monster_" . $monsterId] . "</option>";
                } else {
                    echo "<option value=\"monthly_monster_hunter_" . $monsterId . "\">Monthly Monster Hunter " . $monsterList["monster_" . $monsterId] . "</option>";
                }
                if ($thisReward["Type"] == "weekly_monster_hunter_" . $monsterId . "") {
                    echo "<option value=\"weekly_monster_hunter_" . $monsterId . "\" selected=\"selected\">Weekly Monster Hunter " . $monsterList["monster_" . $monsterId] . "</option>";
                } else {
                    echo "<option value=\"weekly_monster_hunter_" . $monsterId . "\">Weekly Monster Hunter " . $monsterList["monster_" . $monsterId] . "</option>";
                }
                if ($thisReward["Type"] == "daily_monster_hunter_" . $monsterId . "") {
                    echo "<option value=\"daily_monster_hunter_" . $monsterId . "\" selected=\"selected\">Daily Monster Hunter " . $monsterList["monster_" . $monsterId] . "</option>";
                } else {
                    echo "<option value=\"daily_monster_hunter_" . $monsterId . "\">Daily Monster Hunter " . $monsterList["monster_" . $monsterId] . "</option>";
                }
            }
        }
        echo "\r\n                        </select>\r\n                    </td>\r\n                    <td style=\"min-width: 138px;\">\r\n                        <input class=\"form-control\" style=\"display: inline-block; max-width: 50px;\" type=\"text\" name=\"rewards[" . $i . "][highest_pos]\" value=\"" . $thisReward["Highest_Rank"] . "\" placeholder=\"Highest position in Rankings\"/>\r\n                        &nbsp;-&nbsp;\r\n                        <input class=\"form-control\" style=\"display: inline-block; max-width: 50px;\" type=\"text\" name=\"rewards[" . $i . "][lowest_pos]\" value=\"" . $thisReward["Lowest_Rank"] . "\" placeholder=\"Lowest position in Rankings\"/>\r\n                    </td>\r\n                    <td>\r\n                        <input class=\"form-control\" type=\"text\" name=\"rewards[" . $i . "][amount]\" value=\"" . $thisReward["Reward_Amount"] . "\" placeholder=\"Reward Amount\"/>\r\n                        <select name=\"rewards[" . $i . "][amount_type]\" class=\"form-control\">";
        if (empty($thisReward["Reward_Amount_Type"])) {
            echo "<option value=\"0\" disabled=\"disabled\" selected=\"selected\">Select Currency Type</option>";
        } else {
            echo "<option value=\"0\" disabled=\"disabled\">Select Currency Type</option>";
        }
        if ($thisReward["Reward_Amount_Type"] == "1") {
            echo "<option value=\"1\" selected=\"selected\">Platinum Coins</option>";
        } else {
            echo "<option value=\"1\">Platinum Coins</option>";
        }
        if ($thisReward["Reward_Amount_Type"] == "2") {
            echo "<option value=\"2\" selected=\"selected\">Gold Coins</option>";
        } else {
            echo "<option value=\"2\">Gold Coins</option>";
        }
        if ($thisReward["Reward_Amount_Type"] == "3") {
            echo "<option value=\"3\" selected=\"selected\">Silver Coins</option>";
        } else {
            echo "<option value=\"3\">Silver Coins</option>";
        }
        if ($thisReward["Reward_Amount_Type"] == "4") {
            echo "<option value=\"4\" selected=\"selected\">WCoinC</option>";
        } else {
            echo "<option value=\"4\">WCoinC</option>";
        }
        if ($thisReward["Reward_Amount_Type"] == "7") {
            echo "<option value=\"7\" selected=\"selected\">WCoinP</option>";
        } else {
            echo "<option value=\"7\">WCoinP</option>";
        }
        if ($thisReward["Reward_Amount_Type"] == "5") {
            echo "<option value=\"5\" selected=\"selected\">Goblin Points</option>";
        } else {
            echo "<option value=\"5\">Goblin Points</option>";
        }
        if ($thisReward["Reward_Amount_Type"] == "6") {
            echo "<option value=\"6\" selected=\"selected\">Zen</option>";
        } else {
            echo "<option value=\"6\">Zen</option>";
        }
        if ($thisReward["Reward_Amount_Type"] == "8") {
            echo "<option value=\"8\" selected=\"selected\">Ruud</option>";
        } else {
            echo "<option value=\"8\">Ruud</option>";
        }
        echo "\r\n                        </select>\r\n                    </td>\r\n                    <td>\r\n                        <select name=\"rewards[" . $i . "][items_type]\" class=\"form-control\">";
        if (empty($thisReward["Reward_Items_Type"])) {
            echo "<option value=\"0\" selected=\"selected\">Select Reward Type</option>";
        } else {
            echo "<option value=\"0\" >Select Reward Type</option>";
        }
        if ($thisReward["Reward_Items_Type"] == "1") {
            echo "<option value=\"1\" selected=\"selected\">Single Item (with choice)</option>";
        } else {
            echo "<option value=\"1\">Single Item (with choice)</option>";
        }
        if ($thisReward["Reward_Items_Type"] == "2") {
            echo "<option value=\"2\" selected=\"selected\">Multiple Items</option>";
        } else {
            echo "<option value=\"2\">Multiple Items</option>";
        }
        if ($thisReward["Reward_Items_Type"] == "3") {
            echo "<option value=\"3\" selected=\"selected\">Random Item</option>";
        } else {
            echo "<option value=\"3\">Random Item</option>";
        }
        echo "\r\n                        </select>";
        if ($rewardItemsShow != "") {
            echo "<div style=\"width: 100%; height: 12px;\"></div>";
        }
        echo "\r\n                        " . $rewardItemsShow . "                        \r\n                        <div id=\"newItem-" . $thisReward["id"] . "\" style=\"padding-top: 12px;\"></div>\r\n                        <script type=\"text/javascript\">\r\n                            var iid" . $thisReward["id"] . " = " . $totalItems . ";\r\n                            function popitup(url) {\r\n                                newwindow = window.open(url, 'name', 'height = 550, width = 600');\r\n                                if (window.focus) {newwindow.focus()}\r\n                                return false;\r\n                            }\r\n                            \r\n                            function addItem" . $thisReward["id"] . "() {\r\n                                var newItem = \$('#newItem-" . $thisReward["id"] . "');\r\n                                var html = '<div class=\"row\" style=\"padding-bottom: 5px;\"><div class=\"col-xs-12 col-lg-8\">Item ' + (iid" . $thisReward["id"] . "+1) + ': ' +\r\n                                '<input type=\"text\" class=\"form-control\" maxlength=\"64\" size=\"64\" name=\"rewards[" . $i . "][items][]\" value=\"" . __ITEM_EMPTY__ . "\" /></div>' +\r\n                                '<div class=\"col-xs-12 col-lg-4\">Item ' + (iid" . $thisReward["id"] . "+1) + ' Expiration:' +\r\n                                '<input type=\"text\" class=\"form-control\" name=\"rewards[" . $i . "][items_exp][]\" value=\"\" placeholder=\"Exp. in minutes\" /></div></div>';\r\n                                newItem.append(html);\r\n                                iid" . $thisReward["id"] . "=iid" . $thisReward["id"] . "+1;\r\n                            }\r\n                        </script><br>\r\n                        <input type=\"button\" value=\"Add New\" class=\"btn btn-primary\" onClick=\"addItem" . $thisReward["id"] . "();\">\r\n                        <input class=\"btn btn-primary\" type=\"button\" onClick=\"popitup('item_hex_generator.php')\" value=\"Item Code Generator\" title=\"Item Code Generator\">\r\n                    </td>\r\n                    <td><input class=\"form-control\" type=\"text\" name=\"rewards[" . $i . "][reward_exp]\" value=\"" . $thisReward["Expiration"] . "\" placeholder=\"YYYY-MM-DD HH:MM:SS\" /></td>\r\n                    <td style=\"min-width: 160px;\">";
        enabledisableCheckboxes("rewards[" . $i . "][status]", $thisReward["Active"], "Active", "Inactive");
        echo "\r\n                    </td>\r\n                </tr>";
        $i++;
    }
    echo "        </table>\r\n        <button id=\"editRewards\" type=\"submit\" class=\"btn btn-large btn-block btn-success hidden\" name=\"edit_rewards\" value=\"ok\">Save Rewards</button>\r\n    </form>\r\n\r\n    <script type=\"text/javascript\">\r\n        function enableEditMode() {\r\n            \$('#editMode').addClass('hidden');\r\n            \$('#viewTable').addClass('hidden');\r\n            \$('#editTable').removeClass('hidden');\r\n            \$('#editRewards').removeClass('hidden');\r\n        }\r\n    </script>\r\n\r\n    ";
} else {
    message("info", "No rewards found.");
}

?>