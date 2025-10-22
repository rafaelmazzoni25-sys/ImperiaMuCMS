<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h2>Activity Rewards Settings</h2>\r\n";
define("__RESPONSIVE__", "FALSE");
echo "<script type=\"text/javascript\" SRC=\"" . __PATH_TEMPLATE__ . "js/tooltip.js\"></script>";
$Market = new Market();
$Items = new Items();
if (check_value($_POST["submit_changes"])) {
    savechanges();
}
if (check_value($_POST["add_reward"])) {
    $title = xss_clean($_POST["name"]);
    $startDay = xss_clean($_POST["startday"]);
    $endDay = xss_clean($_POST["endday"]);
    $reqOnline = xss_clean($_POST["reqonline"]);
    $reqLevel = xss_clean($_POST["reqlevels"]);
    $reqMasterLevel = xss_clean($_POST["reqmlevels"]);
    $reqReset = xss_clean($_POST["reqresets"]);
    $reqGrandReset = xss_clean($_POST["reqgresets"]);
    $reqMonster = xss_clean($_POST["reqmonsters"]);
    $amount = xss_clean($_POST["amount"]);
    $amount_type = xss_clean($_POST["amount_type"]);
    $items_type = xss_clean($_POST["items_type"]);
    $error = false;
    if (empty($title)) {
        message("error", "Please fill title.");
        $error = true;
    }
    if (empty($startDay)) {
        message("error", "Please fill start date.");
        $error = true;
    }
    if ($amount != NULL && !is_numeric($amount)) {
        message("error", "Reward Amount must be a number.");
        $error = true;
    }
    if (!$error) {
        $reward_items = "";
        $i = 0;
        while ($i < 50) {
            $index = "item" . $i;
            $indexExp = "itemexp" . $i;
            if (!($_POST[$index] == NULL || $_POST[$index] == __ITEM_EMPTY__)) {
                if ($reward_items == NULL || empty($reward_items)) {
                    $reward_items .= $_POST[$index];
                    if (!empty($_POST[$indexExp])) {
                        $reward_items = $reward_items . ":" . $_POST[$indexExp];
                    }
                } else {
                    $reward_items .= "," . $_POST[$index];
                    if (!empty($_POST[$indexExp])) {
                        $reward_items = $reward_items . ":" . $_POST[$indexExp];
                    }
                }
            }
            $i++;
        }
        if (empty($reward_items)) {
            $items_type = NULL;
            $reward_items = NULL;
        }
        if (empty($amount) || $amount < 1) {
            $amount_type = NULL;
            $amount = NULL;
        }
        $insertReward = $dB->query("INSERT INTO IMPERIAMUCMS_ACTIVITY_REWARDS (Title, DayStart, DayEnd, ReqTodayOnlineMinutes, ReqTodayLevels,\r\n            ReqTodayMasterLevels, ReqTodayResets, ReqTodayGrandResets, ReqTodayKilledMonsters, Reward, RewardType, RewardItems, RewardItemsType, Status) \r\n            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$title, $startDay, $endDay, $reqOnline, $reqLevel, $reqMasterLevel, $reqReset, $reqGrandReset, $reqMonster, $amount, $amount_type, $reward_items, $items_type, 1]);
        if ($insertReward) {
            message("success", "Reward was created successfully.");
        } else {
            message("error", "Reward could not be created, please check logs.");
        }
    }
}
if (check_value($_POST["save_reward"])) {
    $reward_id = xss_clean($_POST["reward_id"]);
    $title = xss_clean($_POST["name"]);
    $startDay = xss_clean($_POST["startday"]);
    $endDay = xss_clean($_POST["endday"]);
    $reqOnline = xss_clean($_POST["reqonline"]);
    $reqLevel = xss_clean($_POST["reqlevels"]);
    $reqMasterLevel = xss_clean($_POST["reqmlevels"]);
    $reqReset = xss_clean($_POST["reqresets"]);
    $reqGrandReset = xss_clean($_POST["reqgresets"]);
    $reqMonster = xss_clean($_POST["reqmonsters"]);
    $amount = xss_clean($_POST["amount"]);
    $amount_type = xss_clean($_POST["amount_type"]);
    $items_type = xss_clean($_POST["items_type"]);
    $error = false;
    if (empty($title)) {
        message("error", "Please fill title.");
        $error = true;
    }
    if (empty($startDay)) {
        message("error", "Please fill start date.");
        $error = true;
    }
    if ($amount != NULL && !is_numeric($amount)) {
        message("error", "Reward Amount must be a number.");
        $error = true;
    }
    if (!$error) {
        $reward_items = "";
        $i = 0;
        while ($i < 50) {
            $index = "item" . $i;
            $indexExp = "itemexp" . $i;
            if (!($_POST[$index] == NULL || $_POST[$index] == __ITEM_EMPTY__)) {
                if ($reward_items == NULL || empty($reward_items)) {
                    $reward_items .= $_POST[$index];
                    if (!empty($_POST[$indexExp])) {
                        $reward_items = $reward_items . ":" . $_POST[$indexExp];
                    }
                } else {
                    $reward_items .= "," . $_POST[$index];
                    if (!empty($_POST[$indexExp])) {
                        $reward_items = $reward_items . ":" . $_POST[$indexExp];
                    }
                }
            }
            $i++;
        }
        if (empty($reward_items)) {
            $items_type = NULL;
            $reward_items = NULL;
        }
        if (empty($amount) || $amount < 1) {
            $amount_type = NULL;
            $amount = NULL;
        }
        $insertReward = $dB->query("UPDATE IMPERIAMUCMS_ACTIVITY_REWARDS SET Title = ?, DayStart = ?, DayEnd = ?, ReqTodayOnlineMinutes = ?, ReqTodayLevels = ?,\r\n            ReqTodayMasterLevels = ?, ReqTodayResets = ?, ReqTodayGrandResets = ?, ReqTodayKilledMonsters = ?, Reward = ?, RewardType = ?, RewardItems = ?, \r\n            RewardItemsType = ?, Status = ? WHERE id = ?", [$title, $startDay, $endDay, $reqOnline, $reqLevel, $reqMasterLevel, $reqReset, $reqGrandReset, $reqMonster, $amount, $amount_type, $reward_items, $items_type, 1, $reward_id]);
        if ($insertReward) {
            message("success", "Reward was updated successfully.");
        } else {
            message("error", "Reward could not be updated, please check logs.");
        }
    }
}
if (check_value($_POST["delete_reward"])) {
    $reward_id = xss_clean($_POST["reward_id"]);
    $delete = $dB->query("DELETE FROM IMPERIAMUCMS_ACTIVITY_REWARDS WHERE id = ?", [$reward_id]);
    if ($delete) {
        message("success", "Reward was deleted successfully.");
    } else {
        message("error", "Reward could not be deleted, please check logs.");
    }
}
$General = new xGeneral();
if (check_value($_POST["activate_module"])) {
    $key = $_POST["license_key"];
    $General->jIhfnHDm_activate_KdiupmNBd_Module("activityrewards", $key);
}
$isActivated = $General->jHdksHgYYix_isModule_hDbMVOIfs_Activated("activityrewards");
if (!$isActivated) {
    echo "\r\n    <form method=\"post\" action=\"\">\r\n        <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n            <tr>\r\n                <th>License Key<br/><span></span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"license_key\" value=\"\" size=\"30\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td colspan=\"2\"><input type=\"submit\" name=\"activate_module\" value=\"Activate Module\" class=\"btn btn-success\"/>\r\n                </td>\r\n            </tr>\r\n        </table>\r\n    </form>";
} else {
    if (check_value($_POST["edit_reward"]) && check_value($_POST["reward_id"])) {
        $reward = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_ACTIVITY_REWARDS WHERE id = ?", [$_POST["reward_id"]]);
        echo "\r\n        <h3>Edit Reward - " . $reward["Title"] . "</h3>\r\n        <form method=\"post\" action=\"\">\r\n            <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n                <tr>\r\n                    <th>Name<br/><span>Enter name of the reward.</span></th>\r\n                    <td>\r\n                        <input class=\"form-control\" type=\"text\" name=\"name\" value=\"" . $reward["Title"] . "\" placeholder=\"Name\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Name<br/><span>Enter name of the reward.</span></th>\r\n                    <td>";
        enabledisableCheckboxes("status", $reward["Status"], "Active", "Inactive");
        echo "\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Start Day<br/><span>Enter start day of reward.</span></th>\r\n                    <td>\r\n                        <input class=\"form-control\" type=\"text\" name=\"startday\" value=\"" . $reward["DayStart"] . "\" placeholder=\"Start Day\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>End Day<br/><span>Enter end day of reward. For unlimited use zero.</span></th>\r\n                    <td>\r\n                        <input class=\"form-control\" type=\"text\" name=\"endday\" value=\"" . $reward["DayEnd"] . "\" placeholder=\"End Day\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Required Today's Online Minutes<br/><span>Enter amount of minutes what player needs to be online to claim a reward.</span></th>\r\n                    <td>\r\n                        <input class=\"form-control\" type=\"text\" name=\"reqonline\" value=\"" . $reward["ReqTodayOnlineMinutes"] . "\" placeholder=\"Online Minutes\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Required Today's Levels<br/><span>Enter amount of levels what player needs to gain to claim a reward.</span></th>\r\n                    <td>\r\n                        <input class=\"form-control\" type=\"text\" name=\"reqlevels\" value=\"" . $reward["ReqTodayLevels"] . "\" placeholder=\"Levels\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Required Today's Master Levels<br/><span>Enter amount of master levels what player needs to gain to claim a reward.</span></th>\r\n                    <td>\r\n                        <input class=\"form-control\" type=\"text\" name=\"reqmlevels\" value=\"" . $reward["ReqTodayMasterLevels"] . "\" placeholder=\"Master Levels\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Required Today's Resets<br/><span>Enter amount of resets what player needs to gain to claim a reward.</span></th>\r\n                    <td>\r\n                        <input class=\"form-control\" type=\"text\" name=\"reqresets\" value=\"" . $reward["ReqTodayResets"] . "\" placeholder=\"Resets\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Required Today's Grand Resets<br/><span>Enter amount of grand resets what player needs to gain to claim a reward.</span></th>\r\n                    <td>\r\n                        <input class=\"form-control\" type=\"text\" name=\"reqgresets\" value=\"" . $reward["ReqTodayGrandResets"] . "\" placeholder=\"Grand Resets\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Required Today's Killed Monsters<br/><span>Enter amount of monsters what player needs to kill to claim a reward. This option requires enabled Monster Killing Count tracking enabled in server files.</span></th>\r\n                    <td>\r\n                        <input class=\"form-control\" type=\"text\" name=\"reqmonsters\" value=\"" . $reward["ReqTodayKilledMonsters"] . "\" placeholder=\"Killed Monsters\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Reward Amount<br/><span>Enter amount of currency.</span></th>\r\n                    <td>\r\n                        <table width=\"100%\">\r\n                            <tr>\r\n                                <td width=\"50%\"><input class=\"form-control\" type=\"text\" name=\"amount\" value=\"" . $reward["Reward"] . "\" placeholder=\"Reward Amount\"/></td>\r\n                                <td width=\"50%\">\r\n                                    <select name=\"amount_type\" class=\"form-control\">";
        if ($reward["RewardType"] == NULL) {
            echo "<option value=\"0\" disabled=\"disabled\" selected=\"selected\">Select Currency Type</option>";
        } else {
            echo "<option value=\"0\" disabled=\"disabled\">Select Currency Type</option>";
        }
        if ($reward["RewardType"] == "1") {
            echo "<option value=\"1\" selected=\"selected\">Platinum Coins</option>";
        } else {
            echo "<option value=\"1\">Platinum Coins</option>";
        }
        if ($reward["RewardType"] == "2") {
            echo "<option value=\"2\" selected=\"selected\">Gold Coins</option>";
        } else {
            echo "<option value=\"2\">Gold Coins</option>";
        }
        if ($reward["RewardType"] == "3") {
            echo "<option value=\"3\" selected=\"selected\">Silver Coins</option>";
        } else {
            echo "<option value=\"3\">Silver Coins</option>";
        }
        if ($reward["RewardType"] == "4") {
            echo "<option value=\"4\" selected=\"selected\">WCoinC</option>";
        } else {
            echo "<option value=\"4\">WCoinC</option>";
        }
        if ($reward["RewardType"] == "5") {
            echo "<option value=\"5\" selected=\"selected\">Goblin Points</option>";
        } else {
            echo "<option value=\"5\">Goblin Points</option>";
        }
        if ($reward["RewardType"] == "6") {
            echo "<option value=\"6\" selected=\"selected\">Zen</option>";
        } else {
            echo "<option value=\"6\">Zen</option>";
        }
        echo "\r\n                                    </select>\r\n                                </td>\r\n                            </tr>\r\n                        </table>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Reward Items<br/><span>Configure reward items and their expiration in minutes. Use \"0\" for non-expirable items.<br>\r\n                    Items are added into character's inventory so make sure, that there will be enough space for them.<br>\r\n                    <b>Warning:</b> Maximum 50 items.</span>\r\n                    </th>\r\n                    <td>\r\n                        <select name=\"items_type\" class=\"form-control\">";
        if ($reward["RewardItemsType"] == NULL) {
            echo "<option value=\"0\" disabled=\"disabled\" selected=\"selected\">Select Reward Type</option>";
        } else {
            echo "<option value=\"0\" disabled=\"disabled\">Select Reward Type</option>";
        }
        if ($reward["RewardItemsType"] == "1") {
            echo "<option value=\"1\" selected=\"selected\">Single Item (with choice)</option>";
        } else {
            echo "<option value=\"1\">Single Item (with choice)</option>";
        }
        if ($reward["RewardItemsType"] == "2") {
            echo "<option value=\"2\" selected=\"selected\">Multiple Items</option>";
        } else {
            echo "<option value=\"2\">Multiple Items</option>";
        }
        if ($reward["RewardItemsType"] == "3") {
            echo "<option value=\"3\" selected=\"selected\">Random Item</option>";
        } else {
            echo "<option value=\"3\">Random Item</option>";
        }
        echo "\r\n                        </select>\r\n                        <hr>";
        if ($reward["RewardItems"] != NULL || $reward["RewardItems"] != "") {
            $itemCounter = 0;
            $rewardItems = explode(",", $reward["RewardItems"]);
            foreach ($rewardItems as $thisItem) {
                $itemInfo = explode(":", $thisItem);
                $itemData = $Items->ItemInfo($itemInfo[0]);
                $itemExp = 0;
                if ($itemInfo[1] != NULL) {
                    $itemExp = $itemInfo[1];
                }
                if (0 < $itemExp) {
                    $showExp = 1;
                } else {
                    $showExp = 0;
                }
                echo "<span style=\"cursor: pointer;\" onmouseover=\"Tip(" . $Items->generateItemTooltip($itemData, 1, 0, 1, 1, $showExp, $itemExp) . ")\" onmouseout=\"UnTip()\">" . $itemData["name"] . "</span>:\r\n            <input type=\"text\" class=\"form-control\" style=\"display:inline; width:60%;\" maxlength=\"64\" size=\"80\" name=\"item" . $itemCounter . "\" value=\"" . $itemInfo[0] . "\" />\r\n            Expiration: <input type=\"text\" class=\"form-control\" style=\"display:inline; width:50px;\" size=\"80\" name=\"itemexp" . $itemCounter . "\" value=\"" . $itemExp . "\" /> minute(s)<br>";
                $itemCounter++;
            }
            echo "<hr>";
        } else {
            $rewardItems = [];
        }
        echo "\r\n                        <div id=newItemMng></div>\r\n                        <script type=\"text/javascript\">\r\n                            var iid = " . count($rewardItems) . ";\r\n                            function addItem() {\r\n                                var newItem = \$('#newItemMng');\r\n                                var html = 'Item ' + (iid + 1) + ': <input type=\"hidden\" name=\"itemid' + iid + '\" value=\"0\"/><input type=\"text\" class=\"form-control\" style=\"display:inline; width:60%;\" maxlength=\"64\" size=\"80\" name=\"item' + iid + '\" value=\"" . __ITEM_EMPTY__ . "\" />' +\r\n                                           ' Expiration: <input type=\"text\" class=\"form-control\" style=\"display:inline; width:50px;\" size=\"80\" name=\"itemexp' + iid + '\" value=\"0\" /> minute(s)<br>';\r\n                                newItem.append(html);\r\n                                iid = iid + 1;\r\n                            }\r\n                        </script>\r\n                        <br>\r\n                        <input type=\"button\" value=\"Add New\" class=\"btn btn-primary\" onClick=\"addItem();\">\r\n                        <input class=\"btn btn-primary\" type=\"button\" onClick=\"popitup('item_hex_generator.php')\" value=\"Item Code Generator\" title=\"Item Code Generator\">\r\n                    </td>\r\n                </tr>\r\n            </table>\r\n            <input type=\"hidden\" name=\"reward_id\" value=\"" . $reward["id"] . "\" />\r\n            <button type=\"submit\" class=\"btn btn-large btn-block btn-default\" name=\"cancel\" value=\"\">Cancel</button>\r\n            <button type=\"submit\" class=\"btn btn-large btn-block btn-success\" name=\"save_reward\" value=\"ok\">Save Reward</button>\r\n        </form>";
    } else {
        loadModuleConfigs("usercp.activityrewards");
        echo "        <form action=\"index.php?module=modules_manager&config=activityrewards\" method=\"post\">\r\n            <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n                <tr>\r\n                    <th>Status<br/><span>Enable/disable the starting activity rewards module.</span></th>\r\n                    <td>\r\n                        ";
        enabledisableCheckboxes("active", mconfig("active"), "Enabled", "Disabled");
        echo "                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Last Login<br/><span>Enter number (in hours) for last login of player in game.<br>Example: If \"24\", then player need to login into game in last 24 hours to claim the reward.</span></th>\r\n                    <td>\r\n                        <input type=\"text\" name=\"req_hours\" value=\"";
        echo mconfig("req_hours");
        echo "\" class=\"form-control\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Required Level<br/><span>Required level of character to use module.</span></th>\r\n                    <td>\r\n                        <input type=\"text\" name=\"req_level\" value=\"";
        echo mconfig("req_level");
        echo "\" class=\"form-control\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Required Master Level<br/><span>Required master level of character to use module.</span></th>\r\n                    <td>\r\n                        <input type=\"text\" name=\"req_mlevel\" value=\"";
        echo mconfig("req_mlevel");
        echo "\" class=\"form-control\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Required Reset<br/><span>Required reset of character to use module.</span></th>\r\n                    <td>\r\n                        <input type=\"text\" name=\"req_reset\" value=\"";
        echo mconfig("req_reset");
        echo "\" class=\"form-control\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Required Grand Reset<br/><span>Required grand reset of character to use module.</span></th>\r\n                    <td>\r\n                        <input type=\"text\" name=\"req_greset\" value=\"";
        echo mconfig("req_greset");
        echo "\" class=\"form-control\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan=\"2\"><input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\" class=\"btn btn-success\"/></td>\r\n                </tr>\r\n            </table>\r\n        </form>\r\n\r\n        <hr>\r\n        <h3>Add New Reward</h3>\r\n        <form method=\"post\" action=\"\">\r\n            <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n                <tr>\r\n                    <th>Name<br/><span>Enter name of the reward.</span></th>\r\n                    <td>\r\n                        <input class=\"form-control\" type=\"text\" name=\"name\" value=\"\" placeholder=\"Name\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Start Day<br/><span>Enter start day of reward.</span></th>\r\n                    <td>\r\n                        <input class=\"form-control\" type=\"text\" name=\"startday\" value=\"\" placeholder=\"Start Day\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>End Day<br/><span>Enter end day of reward. For unlimited use zero.</span></th>\r\n                    <td>\r\n                        <input class=\"form-control\" type=\"text\" name=\"endday\" value=\"\" placeholder=\"End Day\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Required Today's Online Minutes<br/><span>Enter amount of minutes what player needs to be online to claim a reward.</span></th>\r\n                    <td>\r\n                        <input class=\"form-control\" type=\"text\" name=\"reqonline\" value=\"\" placeholder=\"Online Minutes\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Required Today's Levels<br/><span>Enter amount of levels what player needs to gain to claim a reward.</span></th>\r\n                    <td>\r\n                        <input class=\"form-control\" type=\"text\" name=\"reqlevels\" value=\"\" placeholder=\"Levels\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Required Today's Master Levels<br/><span>Enter amount of master levels what player needs to gain to claim a reward.</span></th>\r\n                    <td>\r\n                        <input class=\"form-control\" type=\"text\" name=\"reqmlevels\" value=\"\" placeholder=\"Master Levels\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Required Today's Resets<br/><span>Enter amount of resets what player needs to gain to claim a reward.</span></th>\r\n                    <td>\r\n                        <input class=\"form-control\" type=\"text\" name=\"reqresets\" value=\"\" placeholder=\"Resets\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Required Today's Grand Resets<br/><span>Enter amount of grand resets what player needs to gain to claim a reward.</span></th>\r\n                    <td>\r\n                        <input class=\"form-control\" type=\"text\" name=\"reqgresets\" value=\"\" placeholder=\"Grand Resets\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Required Today's Killed Monsters<br/><span>Enter amount of monsters what player needs to kill to claim a reward. This option requires enabled Monster Killing Count tracking enabled in server files.</span></th>\r\n                    <td>\r\n                        <input class=\"form-control\" type=\"text\" name=\"reqmonsters\" value=\"\" placeholder=\"Killed Monsters\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Reward Amount<br/><span>Enter amount of currency.</span></th>\r\n                    <td>\r\n                        <table width=\"100%\">\r\n                            <tr>\r\n                                <td width=\"50%\"><input class=\"form-control\" type=\"text\" name=\"amount\" value=\"\" placeholder=\"Reward Amount\"/></td>\r\n                                <td width=\"50%\">\r\n                                    <select name=\"amount_type\" class=\"form-control\">\r\n                                        <option value=\"0\" disabled=\"disabled\" selected=\"selected\">Select Currency Type</option>\r\n                                        <option value=\"1\">Platinum Coins</option>\r\n                                        <option value=\"2\">Gold Coins</option>\r\n                                        <option value=\"3\">Silver Coins</option>\r\n                                        <option value=\"4\">WCoinC</option>\r\n                                        <option value=\"5\">Goblin Points</option>\r\n                                        <option value=\"6\">Zen</option>\r\n                                    </select>\r\n                                </td>\r\n                            </tr>\r\n                        </table>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Reward Items<br/><span>Configure reward items and their expiration in minutes. Use \"0\" for non-expirable items.<br>\r\n                    Items are added into character's inventory so make sure, that there will be enough space for them.<br>\r\n                    <b>Warning:</b> Maximum 50 items.</span>\r\n                    </th>\r\n                    <td>\r\n                        <select name=\"items_type\" class=\"form-control\">\r\n                            <option value=\"0\" disabled=\"disabled\" selected=\"selected\">Select Reward Type</option>\r\n                            <option value=\"1\">Single Item (with choice)</option>\r\n                            <option value=\"2\">Multiple Items</option>\r\n                            <option value=\"3\">Random Item</option>\r\n                        </select>\r\n                        <hr>\r\n                        <div id=newItem></div>\r\n                        <script type=\"text/javascript\">\r\n                            var iid = 0;\r\n\r\n                            function popitup(url) {\r\n                                newwindow = window.open(url, 'name', 'height = 550, width = 600');\r\n                                if (window.focus) {\r\n                                    newwindow.focus()\r\n                                }\r\n                                return false;\r\n                            }\r\n\r\n                            function addItem() {\r\n                                var newItem = \$('#newItem');\r\n                                var html = 'Item ' + (iid + 1) + ': <input type=\"text\" class=\"form-control\" style=\"display:inline; width:60%;\" maxlength=\"64\" size=\"80\" name=\"item' + iid + '\" value=\"";
        echo __ITEM_EMPTY__;
        echo "\" />' +\r\n                                    ' Expiration: <input type=\"text\" class=\"form-control\" style=\"display:inline; width:50px;\" size=\"80\" name=\"itemexp' + iid + '\" value=\"0\" /> minute(s)<hr>';\r\n                                newItem.append(html);\r\n                                iid = iid + 1;\r\n                            }\r\n                        </script>\r\n                        <br>\r\n                        <input type=\"button\" value=\"Add New\" class=\"btn btn-primary\" onClick=\"addItem();\">\r\n                        <input class=\"btn btn-primary\" type=\"button\" onClick=\"popitup('item_hex_generator.php')\" value=\"Item Code Generator\" title=\"Item Code Generator\">\r\n                    </td>\r\n                </tr>\r\n            </table>\r\n            <button type=\"submit\" class=\"btn btn-large btn-block btn-success\" name=\"add_reward\" value=\"ok\">Add Reward</button>\r\n        </form>\r\n\r\n        <hr>\r\n        <h3>Manage Rewards</h3>\r\n        <small>To delete item from Reward delete it's hex code or use \"";
        echo __ITEM_EMPTY__;
        echo "\" and click on Save button.</small>\r\n        \r\n    <table class=\"table table-striped table-bordered table-hover\">\r\n        <thead>\r\n            <tr>\r\n                <th>ID</th>\r\n                <th>Title</th>\r\n                <th>Days</th>\r\n                <th>Reward</th>\r\n                <th>Items Reward</th>\r\n                <th>Action</th>\r\n            </tr>\r\n        </thead>\r\n        <tbody>";
        $rewards = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_ACTIVITY_REWARDS ORDER BY DayStart ASC");
        if (is_array($rewards)) {
            foreach ($rewards as $thisReward) {
                if ($thisReward["DayEnd"] == "0") {
                    $endDay = "Unlimited";
                } else {
                    $endDay = $thisReward["DayEnd"];
                }
                if ($thisReward["RewardType"] == 1) {
                    $rewardType = lang("currency_platinum", true);
                } else {
                    if ($thisReward["RewardType"] == 2) {
                        $rewardType = lang("currency_gold", true);
                    } else {
                        if ($thisReward["RewardType"] == 3) {
                            $rewardType = lang("currency_silver", true);
                        } else {
                            if ($thisReward["RewardType"] == 4) {
                                $rewardType = lang("currency_wcoinc", true);
                            } else {
                                if ($thisReward["RewardType"] == 5) {
                                    $rewardType = lang("currency_gp", true);
                                } else {
                                    if ($thisReward["RewardType"] == 6) {
                                        $rewardType = lang("currency_zen", true);
                                    }
                                }
                            }
                        }
                    }
                }
                $rewardItems = explode(",", $thisReward["RewardItems"]);
                $tooltip = "";
                foreach ($rewardItems as $thisItem) {
                    $itemInfo = explode(":", $thisItem);
                    $itemData = $Items->ItemInfo($itemInfo[0]);
                    $exp = 0;
                    $expTime = NULL;
                    if ($itemInfo[1] != NULL) {
                        $exp = 0;
                        $expTime = $itemInfo[1];
                    }
                    $tooltip .= "<span style=\"cursor: pointer;\" onmouseover=\"Tip(" . $Items->generateItemTooltip($itemData, 1, 0, 1, 1, 0, $expTime) . ")\" onmouseout=\"UnTip()\">" . $itemData["name"] . "</span> ";
                }
                echo "\r\n            <tr>\r\n                <td>" . $thisReward["id"] . "</td>\r\n                <td>" . $thisReward["Title"] . "</td>\r\n                <td>" . $thisReward["DayStart"] . " - " . $endDay . "</td>\r\n                <td>" . number_format($thisReward["Reward"]) . " " . $rewardType . "</td>\r\n                <td>" . $tooltip . "</td>\r\n                <td>\r\n                    <form method=\"post\" action=\"\">\r\n                        <input type=\"hidden\" name=\"reward_id\" value=\"" . $thisReward["id"] . "\" />\r\n                        <input type=\"submit\" name=\"edit_reward\" class=\"btn btn-default\" value=\"Edit\" />\r\n                        <input type=\"submit\" name=\"delete_reward\" class=\"btn btn-danger\" value=\"Delete\" onclick=\"if(confirm('Do you really want to delete " . $thisReward["Title"] . "?')) return true; else return false;\" />\r\n                    </form>\r\n                </td>\r\n            </tr>";
            }
        } else {
            echo "\r\n            <tr>\r\n                <td colspan=\"6\">No rewards found.</td>\r\n            </tr>";
        }
        echo "\r\n        </tbody>\r\n    </table>";
    }
}
function saveChanges()
{
    
    foreach ($_POST as $setting) {
        if (!check_value($setting)) {
            message("error", "Missing data (complete all fields).");
            return NULL;
        }
    }
    $xmlPath = __PATH_MODULE_CONFIGS__ . "usercp.activityrewards.xml";
    $xml = simplexml_load_file($xmlPath);
    $xml->active = $_POST["active"];
    $xml->req_hours = $_POST["req_hours"];
    $xml->req_level = $_POST["req_level"];
    $xml->req_mlevel = $_POST["req_mlevel"];
    $xml->req_reset = $_POST["req_reset"];
    $xml->req_greset = $_POST["req_greset"];
    $save = $xml->asXML($xmlPath);
    if ($save) {
        message("success", "Settings successfully saved.");
    } else {
        message("error", "There has been an error while saving changes.");
    }
}

?>