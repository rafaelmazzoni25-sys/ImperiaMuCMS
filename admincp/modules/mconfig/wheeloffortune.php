<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h2>Wheel of Fortune Settings</h2>\r\n";
echo "\r\n<script type=\"text/javascript\" src=\"" . __PATH_TEMPLATE__ . "js/tooltip.js\"></script>\r\n<script type=\"text/javascript\" src=\"./js/jscolor.min.js\"></script>";
echo "<script type=\"text/javascript\" SRC=\"" . __PATH_TEMPLATE__ . "js/tooltip.js\"></script>";
$Items = new Items();
if (check_value($_POST["submit_changes"])) {
    savechanges();
}
if (check_value($_POST["save_reward"])) {
    if (check_value($_POST["id"])) {
        $xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "usercp.wheeloffortune.xml");
        if ($xml !== false) {
            $array = [];
            $array["active"] = trim($xml->active);
            $array["items"] = intval(trim($xml->items));
            $array["price"] = trim($xml->price);
            $array["price_type"] = trim($xml->price_type);
            $array["max_spins"] = trim($xml->max_spins);
            $array["circle_count"] = trim($xml->circle_count);
            $array["interval_min"] = trim($xml->interval_min);
            $array["interval_max"] = trim($xml->interval_max);
            $array["enabled_month_day_start"] = trim($xml->enabled_month_day_start);
            $array["enabled_month_day_end"] = trim($xml->enabled_month_day_end);
            $array["enabled_week_day_start"] = trim($xml->enabled_week_day_start);
            $array["enabled_week_day_end"] = trim($xml->enabled_week_day_end);
            $array["enabled_hour_start"] = trim($xml->enabled_hour_start);
            $array["enabled_hour_end"] = trim($xml->enabled_hour_end);
            $totalChance = 0;
            $i = 1;
            foreach ($xml->rewards->children() as $tag => $reward) {
                if ($tag == "reward") {
                    if (intval($reward["id"]) == intval($_POST["id"])) {
                        $items = [];
                        $j = 0;
                        $x = 0;
                        while ($x < 50) {
                            $index = "item" . $x;
                            $index2 = "itemcount" . $x;
                            if (!($_POST[$index] == NULL || $_POST[$index] == __ITEM_EMPTY__)) {
                                $items[$j]["hexcode"] = strval($_POST[$index]);
                                $items[$j]["count"] = intval($_POST[$index2]);
                                $j++;
                            }
                            $x++;
                        }
                        $array["rewards"][$i]["id"] = intval($_POST["id"]);
                        $array["rewards"][$i]["img"] = strval($_POST["img"]);
                        $array["rewards"][$i]["title"] = strval($_POST["title"]);
                        $array["rewards"][$i]["desc"] = strval($_POST["desc"]);
                        $array["rewards"][$i]["chance"] = intval($_POST["chance"]);
                        $array["rewards"][$i]["bgcolor"] = strval($_POST["bgcolor"]);
                        $array["rewards"][$i]["custombg"] = strval($_POST["custombg"]);
                        $array["rewards"][$i]["rewardAmount"] = intval($_POST["rewardAmount"]);
                        $array["rewards"][$i]["rewardType"] = intval($_POST["rewardType"]);
                        $array["rewards"][$i]["rewardItems"] = intval($_POST["rewardItems"]);
                        $array["rewards"][$i]["rewardItemsType"] = intval($_POST["rewardItemsType"]);
                        $array["rewards"][$i]["items"] = $items;
                    } else {
                        $rewardItems = [];
                        $xy = 0;
                        foreach ($reward->items->children() as $thisItem) {
                            $rewardItems[$xy]["hexcode"] = strval($thisItem["hexcode"]);
                            $rewardItems[$xy]["count"] = intval($thisItem["count"]);
                            $xy++;
                        }
                        $array["rewards"][$i]["id"] = intval($reward["id"]);
                        $array["rewards"][$i]["img"] = strval($reward["img"]);
                        $array["rewards"][$i]["title"] = strval($reward["title"]);
                        $array["rewards"][$i]["desc"] = strval($reward["desc"]);
                        $array["rewards"][$i]["chance"] = intval($reward["chance"]);
                        $array["rewards"][$i]["bgcolor"] = strval($reward["bgcolor"]);
                        $array["rewards"][$i]["custombg"] = strval($reward["custombg"]);
                        $array["rewards"][$i]["rewardAmount"] = intval($reward["rewardAmount"]);
                        $array["rewards"][$i]["rewardType"] = intval($reward["rewardType"]);
                        $array["rewards"][$i]["rewardItems"] = intval($reward["rewardItems"]);
                        $array["rewards"][$i]["rewardItemsType"] = intval($reward["rewardItemsType"]);
                        $array["rewards"][$i]["items"] = $rewardItems;
                    }
                    $totalChance += $array["rewards"][$i]["chance"];
                    $i++;
                }
            }
            $array["total_chance"] = trim($totalChance);
            $tmp = arraytoxml($array);
            file_put_contents(__PATH_MODULE_CONFIGS__ . "usercp.wheeloffortune.xml", $tmp);
            message("success", "Reward was successfully created.");
        }
    } else {
        message("error", "Missing data (complete all fields).");
    }
}
if (check_value($_POST["add_reward"])) {
    if (check_value($_POST["id"])) {
        $xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "usercp.wheeloffortune.xml");
        if ($xml !== false) {
            $array = [];
            $array["active"] = trim($xml->active);
            $array["items"] = intval(trim($xml->items)) + 1;
            $array["price"] = trim($xml->price);
            $array["price_type"] = trim($xml->price_type);
            $array["max_spins"] = trim($xml->max_spins);
            $array["circle_count"] = trim($xml->circle_count);
            $array["interval_min"] = trim($xml->interval_min);
            $array["interval_max"] = trim($xml->interval_max);
            $array["enabled_month_day_start"] = trim($xml->enabled_month_day_start);
            $array["enabled_month_day_end"] = trim($xml->enabled_month_day_end);
            $array["enabled_week_day_start"] = trim($xml->enabled_week_day_start);
            $array["enabled_week_day_end"] = trim($xml->enabled_week_day_end);
            $array["enabled_hour_start"] = trim($xml->enabled_hour_start);
            $array["enabled_hour_end"] = trim($xml->enabled_hour_end);
            $totalChance = 0;
            $error = false;
            $newPos = -1;
            $j = 0;
            foreach ($xml->rewards->children() as $tag => $reward) {
                if ($tag == "reward") {
                    if (intval($reward["id"]) == intval($_POST["id"])) {
                        message("error", "ID " . intval($_POST["id"]) . " already exists, please select another value.");
                        $error = true;
                        if (!$error) {
                            $i = 1;
                            foreach ($xml->rewards->children() as $tag => $reward) {
                                if ($tag == "reward") {
                                    if ($newPos == $i) {
                                        $rewardItems = [];
                                        $xy = 0;
                                        foreach ($reward->items->children() as $thisItem) {
                                            $rewardItems[$xy]["hexcode"] = strval($thisItem["hexcode"]);
                                            $rewardItems[$xy]["count"] = intval($thisItem["count"]);
                                            $xy++;
                                        }
                                        $array["rewards"][$i]["id"] = intval($reward["id"]);
                                        $array["rewards"][$i]["img"] = strval($reward["img"]);
                                        $array["rewards"][$i]["title"] = strval($reward["title"]);
                                        $array["rewards"][$i]["desc"] = strval($reward["desc"]);
                                        $array["rewards"][$i]["chance"] = intval($reward["chance"]);
                                        $array["rewards"][$i]["bgcolor"] = strval($reward["bgcolor"]);
                                        $array["rewards"][$i]["custombg"] = strval($reward["custombg"]);
                                        $array["rewards"][$i]["rewardAmount"] = intval($reward["rewardAmount"]);
                                        $array["rewards"][$i]["rewardType"] = intval($reward["rewardType"]);
                                        $array["rewards"][$i]["rewardItems"] = intval($reward["rewardItems"]);
                                        $array["rewards"][$i]["rewardItemsType"] = intval($reward["rewardItemsType"]);
                                        $array["rewards"][$i]["items"] = $rewardItems;
                                        $i++;
                                        $items = [];
                                        $j = 0;
                                        $x = 0;
                                        while ($x < 50) {
                                            $index = "item" . $x;
                                            $index2 = "itemcount" . $x;
                                            if (!($_POST[$index] == NULL || $_POST[$index] == __ITEM_EMPTY__)) {
                                                $items[$j]["hexcode"] = strval($_POST[$index]);
                                                $items[$j]["count"] = intval($_POST[$index2]);
                                                $j++;
                                            }
                                            $x++;
                                        }
                                        $array["rewards"][$i]["id"] = intval($_POST["id"]);
                                        $array["rewards"][$i]["img"] = strval($_POST["img"]);
                                        $array["rewards"][$i]["title"] = strval($_POST["title"]);
                                        $array["rewards"][$i]["desc"] = strval($_POST["desc"]);
                                        $array["rewards"][$i]["chance"] = intval($_POST["chance"]);
                                        $array["rewards"][$i]["bgcolor"] = strval($_POST["bgcolor"]);
                                        $array["rewards"][$i]["custombg"] = strval($_POST["custombg"]);
                                        $array["rewards"][$i]["rewardAmount"] = intval($_POST["rewardAmount"]);
                                        $array["rewards"][$i]["rewardType"] = intval($_POST["rewardType"]);
                                        $array["rewards"][$i]["rewardItems"] = intval($_POST["rewardItems"]);
                                        $array["rewards"][$i]["rewardItemsType"] = intval($_POST["rewardItemsType"]);
                                        $array["rewards"][$i]["items"] = $items;
                                    } else {
                                        $rewardItems = [];
                                        $xy = 0;
                                        foreach ($reward->items->children() as $thisItem) {
                                            $rewardItems[$xy]["hexcode"] = strval($thisItem["hexcode"]);
                                            $rewardItems[$xy]["count"] = intval($thisItem["count"]);
                                            $xy++;
                                        }
                                        $array["rewards"][$i]["id"] = intval($reward["id"]);
                                        $array["rewards"][$i]["img"] = strval($reward["img"]);
                                        $array["rewards"][$i]["title"] = strval($reward["title"]);
                                        $array["rewards"][$i]["desc"] = strval($reward["desc"]);
                                        $array["rewards"][$i]["chance"] = intval($reward["chance"]);
                                        $array["rewards"][$i]["bgcolor"] = strval($reward["bgcolor"]);
                                        $array["rewards"][$i]["custombg"] = strval($reward["custombg"]);
                                        $array["rewards"][$i]["rewardAmount"] = intval($reward["rewardAmount"]);
                                        $array["rewards"][$i]["rewardType"] = intval($reward["rewardType"]);
                                        $array["rewards"][$i]["rewardItems"] = intval($reward["rewardItems"]);
                                        $array["rewards"][$i]["rewardItemsType"] = intval($reward["rewardItemsType"]);
                                        $array["rewards"][$i]["items"] = $rewardItems;
                                    }
                                    $totalChance += $array["rewards"][$i]["chance"];
                                    $i++;
                                }
                            }
                            if (sizeof($xml->rewards->children()) <= $newPos || $newPos == -1) {
                                $items = [];
                                $j = 0;
                                $x = 0;
                                while ($x < 50) {
                                    $index = "item" . $x;
                                    $index2 = "itemcount" . $x;
                                    if (!($_POST[$index] == NULL || $_POST[$index] == __ITEM_EMPTY__)) {
                                        $items[$j]["hexcode"] = strval($_POST[$index]);
                                        $items[$j]["count"] = intval($_POST[$index2]);
                                        $j++;
                                    }
                                    $x++;
                                }
                                $array["rewards"][$i]["id"] = intval($_POST["id"]);
                                $array["rewards"][$i]["img"] = strval($_POST["img"]);
                                $array["rewards"][$i]["title"] = strval($_POST["title"]);
                                $array["rewards"][$i]["desc"] = strval($_POST["desc"]);
                                $array["rewards"][$i]["chance"] = intval($_POST["chance"]);
                                $array["rewards"][$i]["bgcolor"] = strval($_POST["bgcolor"]);
                                $array["rewards"][$i]["custombg"] = strval($_POST["custombg"]);
                                $array["rewards"][$i]["rewardAmount"] = intval($_POST["rewardAmount"]);
                                $array["rewards"][$i]["rewardType"] = intval($_POST["rewardType"]);
                                $array["rewards"][$i]["rewardItems"] = intval($_POST["rewardItems"]);
                                $array["rewards"][$i]["rewardItemsType"] = intval($_POST["rewardItemsType"]);
                                $array["rewards"][$i]["items"] = $items;
                                $totalChance += $array["rewards"][$i]["chance"];
                            }
                            $array["total_chance"] = trim($totalChance);
                            $tmp = arraytoxml($array);
                            file_put_contents(__PATH_MODULE_CONFIGS__ . "usercp.wheeloffortune.xml", $tmp);
                            message("success", "Reward was successfully created.");
                        }
                    } else {
                        if ($newPos == -1 && intval($_POST["id"]) < intval($reward["id"])) {
                            $newPos = $j;
                        }
                        $j++;
                    }
                }
            }
        }
    } else {
        message("error", "Missing data (complete all fields).");
    }
}
if (check_value($_GET["delete"])) {
    $xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "usercp.wheeloffortune.xml");
    if ($xml !== false) {
        $array = [];
        $array["active"] = trim($xml->active);
        $array["items"] = intval(trim($xml->items)) - 1;
        $array["price"] = trim($xml->price);
        $array["price_type"] = trim($xml->price_type);
        $array["max_spins"] = trim($xml->max_spins);
        $array["circle_count"] = trim($xml->circle_count);
        $array["interval_min"] = trim($xml->interval_min);
        $array["interval_max"] = trim($xml->interval_max);
        $array["enabled_month_day_start"] = trim($xml->enabled_month_day_start);
        $array["enabled_month_day_end"] = trim($xml->enabled_month_day_end);
        $array["enabled_week_day_start"] = trim($xml->enabled_week_day_start);
        $array["enabled_week_day_end"] = trim($xml->enabled_week_day_end);
        $array["enabled_hour_start"] = trim($xml->enabled_hour_start);
        $array["enabled_hour_end"] = trim($xml->enabled_hour_end);
        $totalChance = 0;
        $found = false;
        $i = 1;
        foreach ($xml->rewards->children() as $tag => $reward) {
            if ($tag == "reward") {
                if (intval($reward["id"]) == intval($_GET["delete"])) {
                    $found = true;
                } else {
                    $array["rewards"][$i]["id"] = intval($reward["id"]);
                    $array["rewards"][$i]["img"] = strval($reward["img"]);
                    $array["rewards"][$i]["title"] = strval($reward["title"]);
                    $array["rewards"][$i]["desc"] = strval($reward["desc"]);
                    $array["rewards"][$i]["chance"] = intval($reward["chance"]);
                    $array["rewards"][$i]["custombg"] = intval($reward["custombg"]);
                    $array["rewards"][$i]["bgcolor"] = strval($reward["bgcolor"]);
                    $array["rewards"][$i]["rewardAmount"] = intval($reward["rewardAmount"]);
                    $array["rewards"][$i]["rewardType"] = intval($reward["rewardType"]);
                    $array["rewards"][$i]["rewardItems"] = intval($reward["rewardItems"]);
                    $array["rewards"][$i]["rewardItemsType"] = intval($reward["rewardItemsType"]);
                    $rewardItems = [];
                    $xy = 0;
                    foreach ($reward->items->children() as $thisItem) {
                        $rewardItems[$xy]["hexcode"] = strval($thisItem["hexcode"]);
                        $rewardItems[$xy]["count"] = intval($thisItem["count"]);
                        $xy++;
                    }
                    $array["rewards"][$i]["items"] = $rewardItems;
                    $totalChance += $array["rewards"][$i]["chance"];
                    $i++;
                }
            }
        }
        $array["total_chance"] = trim($totalChance);
        $tmp = arraytoxml($array);
        file_put_contents(__PATH_MODULE_CONFIGS__ . "usercp.wheeloffortune.xml", $tmp);
        if ($found) {
            message("success", "Reward #" . intval($_GET["delete"]) . " was deleted successfully.");
        }
    }
}
$General = new xGeneral();
if (check_value($_POST["activate_module"])) {
    $key = $_POST["license_key"];
    $General->jIhfnHDm_activate_KdiupmNBd_Module("wheeloffortune", $key);
}
$isActivated = $General->jHdksHgYYix_isModule_hDbMVOIfs_Activated("wheeloffortune");
if (!$isActivated) {
    echo "\r\n    <form method=\"post\" action=\"\">\r\n        <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n            <tr>\r\n                <th>License Key<br/><span></span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"license_key\" value=\"\" size=\"30\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td colspan=\"2\"><input type=\"submit\" name=\"activate_module\" value=\"Activate Module\" class=\"btn btn-success\"/>\r\n                </td>\r\n            </tr>\r\n        </table>\r\n    </form>";
} else {
    if (check_value($_GET["edit"]) && is_numeric($_GET["edit"])) {
        $xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "usercp.wheeloffortune.xml");
        $found = false;
        $totalItems = 0;
        $displayItems = "";
        if ($xml !== false) {
            $thisReward = [];
            $i = 1;
            foreach ($xml->rewards->children() as $tag => $reward) {
                if ($tag == "reward") {
                    if (intval($reward["id"]) == intval($_GET["edit"])) {
                        $found = true;
                        $thisReward["id"] = intval($reward["id"]);
                        $thisReward["img"] = strval($reward["img"]);
                        $thisReward["title"] = strval($reward["title"]);
                        $thisReward["desc"] = strval($reward["desc"]);
                        $thisReward["chance"] = intval($reward["chance"]);
                        $thisReward["custombg"] = intval($reward["custombg"]);
                        $thisReward["bgcolor"] = strval($reward["bgcolor"]);
                        $thisReward["rewardAmount"] = intval($reward["rewardAmount"]);
                        $thisReward["rewardType"] = intval($reward["rewardType"]);
                        $thisReward["rewardItems"] = intval($reward["rewardItems"]);
                        $thisReward["rewardItemsType"] = intval($reward["rewardItemsType"]);
                        $rewardItems = [];
                        $xy = 0;
                        foreach ($reward->items->children() as $thisItem) {
                            $rewardItems[$xy]["hexcode"] = strval($thisItem["hexcode"]);
                            $rewardItems[$xy]["count"] = intval($thisItem["count"]);
                            $itemInfo = $Items->ItemInfo(strval($thisItem["hexcode"]));
                            $luck = "";
                            $skill = "";
                            $option = "";
                            $exl = "";
                            $ancsetopt = "";
                            if ($itemInfo["level"]) {
                                $itemInfo["level"] = " +" . $itemInfo["level"];
                            } else {
                                $itemInfo["level"] = NULL;
                            }
                            if ($itemInfo["luck"]) {
                                $luck = "<br><font color=#9aadd5>" . $itemInfo["luck"] . "</font>";
                            }
                            if ($itemInfo["skill"]) {
                                $skill = "<br><font color=#9aadd5>" . $itemInfo["skill"] . "</font>";
                            }
                            if ($itemInfo["opt"]) {
                                $option = "<font color=#9aadd5>" . $itemInfo["opt"] . "</font>";
                            }
                            if ($itemInfo["exl"]) {
                                $exl = "<font color=#4d668d>" . str_replace("^^", "<br>", $itemInfo["exl"]) . "</font>";
                            }
                            if ($itemInfo["ancsetopt"]) {
                                $ancsetopt = "<font color=#9aadd5>" . str_replace("^^", "<br>", $itemInfo["ancsetopt"]) . "</font>";
                            }
                            $displayItems .= "<span  style=\"cursor: pointer;\" onmouseover=\"Tip('<center><img src=" . $itemInfo["thumb"] . "><br /><font color=yellow><br><font color=white><br>Durability: " . $itemInfo["dur"] . "</font><br><font color=#FF99CC>" . $itemInfo["jog"] . "</font><font color=FFCC00>" . $itemInfo["harm"] . "</font><br>" . $option . " " . $luck . " " . $skill . " " . $exl . " <br>" . $ancsetopt . "<br><font color=#4d668d>" . $itemInfo["socket"] . "</font><br><br><span class=itemTooltipClassReq>" . $itemInfo["classReq"] . "</span></center>', TITLEFONTCOLOR, '" . $itemInfo["color"] . "',TITLE,'" . addslashes($itemInfo["name"]) . $itemInfo["level"] . "',TITLEBGCOLOR,'" . $itemInfo["anco"] . "')\" onmouseout=\"UnTip()\">Item " . ($xy + 1) . "</span>: <input class=\"form-control\" type=\"text\" name=\"item" . $xy . "\" value=\"" . strval($thisItem["hexcode"]) . "\" placeholder=\"Item Hex Code\" style=\"display:inline; width:70%;\" maxlength=\"64\" size=\"64\" />";
                            $displayItems .= " Count: <input type=\"text\" disabled=\"disabled\" class=\"form-control\" style=\"display:inline; max-width:50px;\" maxlength=\"3\" size=\"4\" name=\"itemcount" . $xy . "\" value=\"" . intval($thisItem["count"]) . "\" /><br>";
                            $totalItems++;
                            $xy++;
                        }
                        $thisReward["items"] = $rewardItems;
                    } else {
                        $i++;
                    }
                }
            }
        }
        if ($found) {
            echo "\r\n        <h3>Edit Reward #" . $_GET["edit"] . "</h3>\r\n        <form method=\"post\" action=\"index.php?module=modules_manager&config=wheeloffortune\">\r\n            <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n                <tr>\r\n                    <th>ID<br/><span>Enter ID of the reward. <b>ID must be unique!</b></span></th>\r\n                    <td>\r\n                        <input class=\"form-control\" type=\"text\" name=\"id\" value=\"" . $thisReward["id"] . "\" placeholder=\"ID\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Title<br/><span>Enter title of the reward.</span></th>\r\n                    <td>\r\n                        <input class=\"form-control\" type=\"text\" name=\"title\" value=\"" . $thisReward["title"] . "\" placeholder=\"Title\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Description<br/><span>Enter description of the reward.</span></th>\r\n                    <td>\r\n                        <textarea class=\"form-control\" name=\"desc\" placeholder=\"Description is displayed in the popup window after spin.\">" . $thisReward["desc"] . "</textarea>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Chance<br/><span>Enter chance to get this reward.<br />Formula: <i>Summary of chances of all rewards / Chance of this reward</i></span></th>\r\n                    <td>\r\n                        <input class=\"form-control\" type=\"text\" name=\"chance\" value=\"" . $thisReward["chance"] . "\" placeholder=\"Chance (1 - unlimited)\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Custom Background Color<br/><span>If you want to use custom background color, use \"Yes\", otherwise \"No\".<br>You can override default color with your own custom background color for this reward.</span></th>\r\n                    <td>\r\n                        <table width=\"100%\">\r\n                            <tr>\r\n                                <td width=\"50%\">";
            enabledisableCheckboxes2("custombg", $thisReward["custombg"], "Yes", "No");
            echo "\r\n                                </td>\r\n                                <td width=\"50%\">\r\n                                    <input class=\"form-control jscolor\" name=\"bgcolor\" value=\"" . $thisReward["bgcolor"] . "\">\r\n                                </td>\r\n                            </tr>\r\n                        </table>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Image<br/><span>Enter image of the reward what will be displayed in wheel of fortune.<br>Images should be located in /templates/your_template/img/items/.</span></th>\r\n                    <td>\r\n                        <input class=\"form-control\" type=\"text\" name=\"img\" value=\"" . $thisReward["img"] . "\" placeholder=\"Image\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Currency Reward<br/><span>Enter currency reward type and amount.</span></th>\r\n                    <td>\r\n                        <table width=\"100%\">\r\n                            <tr>\r\n                                <td width=\"50%\"><input class=\"form-control\" type=\"text\" name=\"rewardAmount\" value=\"" . $thisReward["rewardAmount"] . "\" placeholder=\"Amount\" /></td>\r\n                                <td width=\"50%\">\r\n                                    <select name=\"rewardType\" class=\"form-control\">\r\n                                        <option>-- None --</option>";
            if ($thisReward["rewardType"] == "1") {
                echo "<option value=\"1\" selected=\"selected\">Platinum Coins</option>";
            } else {
                echo "<option value=\"1\">Platinum Coins</option>";
            }
            if ($thisReward["rewardType"] == "2") {
                echo "<option value=\"2\" selected=\"selected\">Gold Coins</option>";
            } else {
                echo "<option value=\"2\">Gold Coins</option>";
            }
            if ($thisReward["rewardType"] == "3") {
                echo "<option value=\"3\" selected=\"selected\">Silver Coins</option>";
            } else {
                echo "<option value=\"3\">Silver Coins</option>";
            }
            if ($thisReward["rewardType"] == "4") {
                echo "<option value=\"4\" selected=\"selected\">WCoinC</option>";
            } else {
                echo "<option value=\"4\">WCoinC</option>";
            }
            if ($thisReward["rewardType"] == "-4") {
                echo "<option value=\"-4\" selected=\"selected\">WCoinP</option>";
            } else {
                echo "<option value=\"-4\">WCoinP</option>";
            }
            if ($thisReward["rewardType"] == "5") {
                echo "<option value=\"5\" selected=\"selected\">GoblinPoint</option>";
            } else {
                echo "<option value=\"5\">GoblinPoint</option>";
            }
            if ($thisReward["rewardType"] == "6") {
                echo "<option value=\"6\" selected=\"selected\">Zen</option>";
            } else {
                echo "<option value=\"6\">Zen</option>";
            }
            if ($thisReward["rewardType"] == "7") {
                echo "<option value=\"7\" selected=\"selected\">Jewel of Bless</option>";
            } else {
                echo "<option value=\"7\">Jewel of Bless</option>";
            }
            if ($thisReward["rewardType"] == "8") {
                echo "<option value=\"8\" selected=\"selected\">Jewel of Soul</option>";
            } else {
                echo "<option value=\"8\">Jewel of Soul</option>";
            }
            if ($thisReward["rewardType"] == "9") {
                echo "<option value=\"9\" selected=\"selected\">Jewel of Life</option>";
            } else {
                echo "<option value=\"9\">Jewel of Life</option>";
            }
            if ($thisReward["rewardType"] == "10") {
                echo "<option value=\"10\" selected=\"selected\">Jewel of Chaos</option>";
            } else {
                echo "<option value=\"10\">Jewel of Chaos</option>";
            }
            if ($thisReward["rewardType"] == "11") {
                echo "<option value=\"11\" selected=\"selected\">Jewel of Harmony</option>";
            } else {
                echo "<option value=\"11\">Jewel of Harmony</option>";
            }
            if ($thisReward["rewardType"] == "12") {
                echo "<option value=\"12\" selected=\"selected\">Jewel of Creation</option>";
            } else {
                echo "<option value=\"12\">Jewel of Creation</option>";
            }
            if ($thisReward["rewardType"] == "13") {
                echo "<option value=\"13\" selected=\"selected\">Jewel of Guardian</option>";
            } else {
                echo "<option value=\"13\">Jewel of Guardian</option>";
            }
            foreach ($customItems as $thisItem) {
                if ($thisReward["rewardType"] == $thisItem["ident"]) {
                    echo "<option value=\"" . $thisItem["ident"] . "\" selected=\"selected\">" . $thisItem["name"] . "</option>";
                } else {
                    echo "<option value=\"" . $thisItem["ident"] . "\">" . $thisItem["name"] . "</option>";
                }
            }
            echo "\r\n                                    </select>\r\n                                </td>\r\n                            </tr>\r\n                        </table>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Items Reward<br/><span>Enable/disable items reward and configure item reward type.</span></th>\r\n                    <td>\r\n                        <table width=\"100%\">\r\n                            <tr>\r\n                                <td width=\"50%\">";
            enabledisableCheckboxes2("rewardItems", $thisReward["rewardItems"], "Yes", "No");
            echo "\r\n                                </td>\r\n                                <td width=\"50%\">\r\n                                    <select name=\"rewardItemsType\" class=\"form-control\">\r\n                                        <option value=\"0\" disabled=\"disabled\" selected=\"selected\">Select Reward Type</option>";
            if ($thisReward["rewardItemsType"] == "1") {
                echo "<option value=\"1\" selected=\"selected\">Single Item (with choice)</option>";
            } else {
                echo "<option value=\"1\">Single Item (with choice)</option>";
            }
            if ($thisReward["rewardItemsType"] == "2") {
                echo "<option value=\"2\" selected=\"selected\">Multiple Items</option>";
            } else {
                echo "<option value=\"2\">Multiple Items</option>";
            }
            if ($thisReward["rewardItemsType"] == "3") {
                echo "<option value=\"3\" selected=\"selected\">Random Item</option>";
            } else {
                echo "<option value=\"3\">Random Item</option>";
            }
            echo "\r\n                                    </select>\r\n                                </td>\r\n                            </tr>\r\n                        </table>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Items<br/><span>Specify reward items.</span></th>\r\n                    <td>\r\n                        " . $displayItems . "                        \r\n                        <div id=newItem></div>\r\n                        <script type=\"text/javascript\">\r\n                            var iid = " . $totalItems . ";\r\n                            function popitup(url) {\r\n                                newwindow = window.open(url, 'name', 'height = 550, width = 600');\r\n                                if (window.focus) {newwindow.focus()}\r\n                                return false;\r\n                            }\r\n                            function addItem() {\r\n                                var newItem = \$('#newItem');\r\n                                var html = 'Item ' + (iid+1) + ': <input type=\"text\" class=\"form-control\" style=\"display:inline; width:70%;\" maxlength=\"64\" size=\"64\" name=\"item' + iid + '\" value=\"" . __ITEM_EMPTY__ . "\" /> Count: <input type=\"text\" disabled=\"disabled\" class=\"form-control\" style=\"display:inline; max-width:50px;\" maxlength=\"3\" size=\"4\" name=\"itemcount' + iid + '\" value=\"1\" /><br>';\r\n                                newItem.append(html);\r\n                                iid=iid+1;\r\n                            }\r\n                        </script><br>\r\n                        <input type=\"button\" value=\"Add New\" class=\"btn btn-primary\" onClick=\"addItem();\">\r\n                        <input class=\"btn btn-primary\" type=\"button\" onClick=\"popitup('item_hex_generator.php')\" value=\"Item Code Generator\" title=\"Item Code Generator\">\r\n        \r\n                    </td>\r\n                </tr>\r\n            </table>\r\n            <button type=\"submit\" class=\"btn btn-large btn-block btn-success\" name=\"save_reward\" value=\"ok\">Save Reward</button>\r\n        </form>";
        } else {
            message("error", "Reward #" . $_GET["edit"] . " does not exist.");
        }
    } else {
        loadModuleConfigs("usercp.wheeloffortune");
        echo "        <form action=\"index.php?module=modules_manager&config=wheeloffortune\" method=\"post\">\r\n            <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n                <tr>\r\n                    <th>Status<br/><span>Enable/disable the dual stats module.</span></th>\r\n                    <td>\r\n                        ";
        enabledisableCheckboxes("active", mconfig("active"), "Enabled", "Disabled");
        echo "                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Total Items<br/><span>Total items on wheel.</span></th>\r\n                    <td>\r\n                        <input class=\"form-control\" type=\"text\" name=\"items\" value=\"";
        echo mconfig("items");
        echo "\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Price<br/><span>Price for one spin.</span></th>\r\n                    <td>\r\n                        <table width=\"100%\">\r\n                            <tr>\r\n                                <td width=\"50%\">\r\n                                    <input class=\"form-control\" type=\"text\" name=\"price\" value=\"";
        echo mconfig("price");
        echo "\"/>\r\n                                </td>\r\n                                <td width=\"50%\">\r\n                                    <select name=\"price_type\" class=\"form-control\">";
        if (mconfig("price_type") == "1") {
            echo "<option value=\"1\" selected=\"selected\">Platinum Coins</option>";
        } else {
            echo "<option value=\"1\">Platinum Coins</option>";
        }
        if (mconfig("price_type") == "2") {
            echo "<option value=\"2\" selected=\"selected\">Gold Coins</option>";
        } else {
            echo "<option value=\"2\">Gold Coins</option>";
        }
        if (mconfig("price_type") == "3") {
            echo "<option value=\"3\" selected=\"selected\">Silver Coins</option>";
        } else {
            echo "<option value=\"3\">Silver Coins</option>";
        }
        if (mconfig("price_type") == "4") {
            echo "<option value=\"4\" selected=\"selected\">WCoinC</option>";
        } else {
            echo "<option value=\"4\">WCoinC</option>";
        }
        if (mconfig("price_type") == "-4") {
            echo "<option value=\"-4\" selected=\"selected\">WCoinP</option>";
        } else {
            echo "<option value=\"-4\">WCoinP</option>";
        }
        if (mconfig("price_type") == "5") {
            echo "<option value=\"5\" selected=\"selected\">GoblinPoint</option>";
        } else {
            echo "<option value=\"5\">GoblinPoint</option>";
        }
        if (mconfig("price_type") == "6") {
            echo "<option value=\"6\" selected=\"selected\">Zen</option>";
        } else {
            echo "<option value=\"6\">Zen</option>";
        }
        if (mconfig("price_type") == "7") {
            echo "<option value=\"7\" selected=\"selected\">Jewel of Bless</option>";
        } else {
            echo "<option value=\"7\">Jewel of Bless</option>";
        }
        if (mconfig("price_type") == "8") {
            echo "<option value=\"8\" selected=\"selected\">Jewel of Soul</option>";
        } else {
            echo "<option value=\"8\">Jewel of Soul</option>";
        }
        if (mconfig("price_type") == "9") {
            echo "<option value=\"9\" selected=\"selected\">Jewel of Life</option>";
        } else {
            echo "<option value=\"9\">Jewel of Life</option>";
        }
        if (mconfig("price_type") == "10") {
            echo "<option value=\"10\" selected=\"selected\">Jewel of Chaos</option>";
        } else {
            echo "<option value=\"10\">Jewel of Chaos</option>";
        }
        if (mconfig("price_type") == "11") {
            echo "<option value=\"11\" selected=\"selected\">Jewel of Harmony</option>";
        } else {
            echo "<option value=\"11\">Jewel of Harmony</option>";
        }
        if (mconfig("price_type") == "12") {
            echo "<option value=\"12\" selected=\"selected\">Jewel of Creation</option>";
        } else {
            echo "<option value=\"12\">Jewel of Creation</option>";
        }
        if (mconfig("price_type") == "13") {
            echo "<option value=\"13\" selected=\"selected\">Jewel of Guardian</option>";
        } else {
            echo "<option value=\"13\">Jewel of Guardian</option>";
        }
        $customItems = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_WEB_BANK_CUSTOM");
        $customEditFrom = "";
        foreach ($customItems as $thisItem) {
            if (mconfig("price_type") == $thisItem["ident"]) {
                $customEditFrom .= "<option value=\"" . $thisItem["ident"] . "\" selected=\"selected\">" . $thisItem["name"] . "</option>";
            } else {
                $customEditFrom .= "<option value=\"" . $thisItem["ident"] . "\">" . $thisItem["name"] . "</option>";
            }
        }
        echo $customEditFrom;
        echo "</select>                                </td>\r\n                            </tr>\r\n                        </table>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Maximum Spins Per Day<br/><span>Maximum allowed number of wheel of fortune spins per day for account.</span>\r\n                    </th>\r\n                    <td>\r\n                        <input class=\"form-control\" type=\"text\" name=\"max_spins\" value=\"";
        echo mconfig("max_spins");
        echo "\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Minimum Circle Count<br/><span>Amount of circles what will be done as minimum on each spin.</span>\r\n                    </th>\r\n                    <td>\r\n                        <input class=\"form-control\" type=\"text\" name=\"circle_count\" value=\"";
        echo mconfig("circle_count");
        echo "\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Minimum Movement<br/><span>Minimum amount of wheel's movement. Movement of wheel is random based on this value.</span>\r\n                    </th>\r\n                    <td>\r\n                        <input class=\"form-control\" type=\"text\" name=\"interval_min\" value=\"";
        echo mconfig("interval_min");
        echo "\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Maximum Movement<br/><span>Maximum amount of wheel's movement. Movement of wheel is random based on this value.</span>\r\n                    </th>\r\n                    <td>\r\n                        <input class=\"form-control\" type=\"text\" name=\"interval_max\" value=\"";
        echo mconfig("interval_max");
        echo "\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Day of Month\r\n                        Start<br/><span>Use \"-1\" for all days in month or day represented by number (1-31).</span></th>\r\n                    <td>\r\n                        <input class=\"form-control\" type=\"text\" name=\"enabled_month_day_start\"\r\n                               value=\"";
        echo mconfig("enabled_month_day_start");
        echo "\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Day of Month\r\n                        End<br/><span>Use \"-1\" for all days in month or day represented by number (1-31).</span></th>\r\n                    <td>\r\n                        <input class=\"form-control\" type=\"text\" name=\"enabled_month_day_end\"\r\n                               value=\"";
        echo mconfig("enabled_month_day_end");
        echo "\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Day of Week Start<br/><span>Use \"-1\" for all days in week or day represented by number (1 = Monday - 7 = Sunday).</span>\r\n                    </th>\r\n                    <td>\r\n                        <input class=\"form-control\" type=\"text\" name=\"enabled_week_day_start\"\r\n                               value=\"";
        echo mconfig("enabled_week_day_start");
        echo "\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Day of Week End<br/><span>Use \"-1\" for all days in week or day represented by number (1 = Monday - 7 = Sunday).</span>\r\n                    </th>\r\n                    <td>\r\n                        <input class=\"form-control\" type=\"text\" name=\"enabled_week_day_end\"\r\n                               value=\"";
        echo mconfig("enabled_week_day_end");
        echo "\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Hour Start<br/><span>Hour from what will be module available (0-23).</span></th>\r\n                    <td>\r\n                        <input class=\"form-control\" type=\"text\" name=\"enabled_hour_start\"\r\n                               value=\"";
        echo mconfig("enabled_hour_start");
        echo "\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Hour End<br/><span>Hour until what will be module available (1-24).</span></th>\r\n                    <td>\r\n                        <input class=\"form-control\" type=\"text\" name=\"enabled_hour_end\"\r\n                               value=\"";
        echo mconfig("enabled_hour_end");
        echo "\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan=\"2\"><input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\"\r\n                                           class=\"btn btn-success\"/>\r\n                    </td>\r\n                </tr>\r\n            </table>\r\n        </form>\r\n\r\n        <hr>\r\n        <h3>Manage Rewards</h3>\r\n        <p><small>Module is designed to work correctly with 6 - 24 rewards. Total amount of rewards must be dividable by 2 (6, 8, 10, ..., 20, 22, 24).</small></p>\r\n        ";
        $xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "usercp.wheeloffortune.xml");
        echo "        <form method=\"post\" action=\"\">\r\n            <table class=\"table table-striped table-bordered table-hover\">\r\n                <tr>\r\n                    <th>ID</th>\r\n                    <th>Title</th>\r\n                    <th>Description</th>\r\n                    <th>Action</th>\r\n                </tr>\r\n                ";
        if ($xml !== false) {
            $rewards = [];
            $i = 1;
            foreach ($xml->rewards->children() as $tag => $reward) {
                if ($tag == "reward") {
                    $rewards[$i]["id"] = intval($reward["id"]);
                    $rewards[$i]["title"] = strval($reward["title"]);
                    $rewards[$i]["desc"] = strval($reward["desc"]);
                    $items_show = "";
                    if ($reward->items->children() != NULL) {
                        $tmpcounter = 0;
                        foreach ($reward->items->children() as $innerTag => $item) {
                            if ($innerTag == "item") {
                                $rewards[$i]["items"][$tmpcounter]["hexcode"] = strval($item["hexcode"]);
                                $rewards[$i]["items"][$tmpcounter]["count"] = intval($item["count"]);
                                $itemInfo = $Items->ItemInfo(strval($item["hexcode"]));
                                $luck = "";
                                $skill = "";
                                $option = "";
                                $exl = "";
                                $ancsetopt = "";
                                if ($itemInfo["level"]) {
                                    $itemInfo["level"] = " +" . $itemInfo["level"];
                                } else {
                                    $itemInfo["level"] = NULL;
                                }
                                if ($itemInfo["luck"]) {
                                    $luck = "<br><font color=#9aadd5>" . $itemInfo["luck"] . "</font>";
                                }
                                if ($itemInfo["skill"]) {
                                    $skill = "<br><font color=#9aadd5>" . $itemInfo["skill"] . "</font>";
                                }
                                if ($itemInfo["opt"]) {
                                    $option = "<font color=#9aadd5>" . $itemInfo["opt"] . "</font>";
                                }
                                if ($itemInfo["exl"]) {
                                    $exl = "<font color=#4d668d>" . str_replace("^^", "<br>", $itemInfo["exl"]) . "</font>";
                                }
                                if ($itemInfo["ancsetopt"]) {
                                    $ancsetopt = "<font color=#9aadd5>" . str_replace("^^", "<br>", $itemInfo["ancsetopt"]) . "</font>";
                                }
                                $items_show .= "<span  style=\"cursor: pointer;\" onmouseover=\"Tip('<center><img src=" . $itemInfo["thumb"] . "><br /><font color=yellow><br><font color=white><br>Durability: " . $itemInfo["dur"] . "</font><br><font color=#FF99CC>" . $itemInfo["jog"] . "</font><font color=FFCC00>" . $itemInfo["harm"] . "</font><br>" . $option . " " . $luck . " " . $skill . " " . $exl . " <br>" . $ancsetopt . "<br><font color=#4d668d>" . $itemInfo["socket"] . "</font><br><br><span class=itemTooltipClassReq>" . $itemInfo["classReq"] . "</span></center>', TITLEFONTCOLOR, '" . $itemInfo["color"] . "',TITLE,'" . addslashes($itemInfo["name"]) . $itemInfo["level"] . "',TITLEBGCOLOR,'" . $itemInfo["anco"] . "')\" onmouseout=\"UnTip()\">Item " . ($tmpcounter + 1) . "</span>: <input class=\"form-control\" type=\"text\" name=\"item" . $tmpcounter . "_" . intval($reward["id"]) . "\" value=\"" . strval($item["hexcode"]) . "\" placeholder=\"Item Hex Code\" style=\"display:inline; width:70%;\" maxlength=\"64\" size=\"80\"/>";
                                $items_show .= " Count: <input type=\"text\" disabled=\"disabled\" class=\"form-control\" style=\"display:inline; max-width:50px;\" maxlength=\"64\" size=\"4\" name=\"itemcount" . $tmpcounter . "_" . intval($reward["id"]) . "\" value=\"" . intval($item["count"]) . "\" /><br>";
                                $tmpcounter++;
                            }
                        }
                    }
                    echo "\r\n                    <tr>\r\n                        <td>" . intval($reward["id"]) . "</td>\r\n                        <td>" . strval($reward["title"]) . "</td>\r\n                        <td>" . strval($reward["desc"]) . "</td>\r\n                        <td><a href=\"index.php?module=modules_manager&config=wheeloffortune&edit=" . intval($reward["id"]) . "\"><button type=\"button\" class=\"btn btn-default btn-sm\"><i class=\"fa fa-edit\"></i> Edit</button></a> <a href=\"index.php?module=modules_manager&config=wheeloffortune&delete=" . intval($reward["id"]) . "\" class=\"btn btn-danger btn-sm\" onclick=\"if(confirm('Do you really want to delete this reward? ')) return true; else return false;\"><i class=\"fa fa-remove\"></i> Delete</a></td>\r\n                    </tr>";
                    $i++;
                }
            }
        }
        echo "            </table>\r\n        </form>\r\n\r\n        <hr>\r\n        <h3>Add New Reward</h3>\r\n        <form method=\"post\" action=\"index.php?module=modules_manager&config=wheeloffortune\">\r\n            <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n                <tr>\r\n                    <th>ID<br/><span>Enter ID of the reward. <b>ID must be unique!</b></span></th>\r\n                    <td>\r\n                        <input class=\"form-control\" type=\"text\" name=\"id\" value=\"\" placeholder=\"ID\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Title<br/><span>Enter title of the reward.</span></th>\r\n                    <td>\r\n                        <input class=\"form-control\" type=\"text\" name=\"title\" value=\"\" placeholder=\"Title\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Description<br/><span>Enter description of the reward.</span></th>\r\n                    <td>\r\n                        <textarea class=\"form-control\" name=\"desc\" placeholder=\"Description is displayed in the popup window after spin.\"></textarea>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Chance<br/><span>Enter chance to get this reward.<br/>Formula: <i>Summary of chances of all rewards / Chance of this reward</i></span></th>\r\n                    <td>\r\n                        <input class=\"form-control\" type=\"text\" name=\"chance\" value=\"\" placeholder=\"Chance (1 - unlimited)\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Custom Background Color<br/><span>If you want to use custom background color, use \"Yes\", otherwise \"No\".<br>You can override default color with your own custom background color for this reward.</span>\r\n                    </th>\r\n                    <td>\r\n                        <table width=\"100%\">\r\n                            <tr>\r\n                                <td width=\"50%\">\r\n                                    ";
        enabledisableCheckboxes2("custombg", 0, "Yes", "No");
        echo "                                </td>\r\n                                <td width=\"50%\">\r\n                                    <input class=\"form-control jscolor\" name=\"bgcolor\" value=\"000000\">\r\n                                </td>\r\n                            </tr>\r\n                        </table>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Image<br/><span>Enter image of the reward what will be displayed in wheel of fortune.<br>Images should be located in /templates/your_template/img/items/.</span></th>\r\n                    <td>\r\n                        <input class=\"form-control\" type=\"text\" name=\"img\" value=\"\" placeholder=\"Image\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Currency Reward<br/><span>Enter currency reward type and amount.</span></th>\r\n                    <td>\r\n                        <table width=\"100%\">\r\n                            <tr>\r\n                                <td width=\"50%\"><input class=\"form-control\" type=\"text\" name=\"rewardAmount\" value=\"\" placeholder=\"Amount\"/></td>\r\n                                <td width=\"50%\">\r\n                                    <select name=\"rewardType\" class=\"form-control\">\r\n                                        <option>-- None --</option>\r\n                                        <option value=\"1\">Platinum Coins</option>\r\n                                        <option value=\"2\">Gold Coins</option>\r\n                                        <option value=\"3\">Silver Coins</option>\r\n                                        <option value=\"4\">WCoinC</option>\r\n                                        <option value=\"-4\">WCoinP</option>\r\n                                        <option value=\"5\">GoblinPoint</option>\r\n                                        <option value=\"6\">Zen</option>\r\n\r\n                                        \r\n                                        <option value=\"7\">Jewel of Bless</option>\r\n                                        <option value=\"8\">Jewel of Soul</option>\r\n                                        <option value=\"9\">Jewel of Life</option>\r\n                                        <option value=\"10\">Jewel of Chaos</option>\r\n                                        <option value=\"11\">Jewel of Harmony</option>\r\n                                        <option value=\"12\">Jewel of Creation</option>\r\n                                        <option value=\"13\">Jewel of Guardian</option>\r\n\r\n                                        ";
        foreach ($customItems as $thisItem) {
            echo "<option value=\"" . $thisItem["ident"] . "\">" . $thisItem["name"] . "</option>";
        }
        echo "                                    </select>\r\n                                </td>\r\n                            </tr>\r\n                        </table>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Items Reward<br/><span>Enable/disable items reward and configure item reward type.</span></th>\r\n                    <td>\r\n                        <table width=\"100%\">\r\n                            <tr>\r\n                                <td width=\"50%\">\r\n                                    ";
        enabledisableCheckboxes2("rewardItems", 0, "Yes", "No");
        echo "                                </td>\r\n                                <td width=\"50%\">\r\n                                    <select name=\"rewardItemsType\" class=\"form-control\">\r\n                                        <option value=\"0\" disabled=\"disabled\" selected=\"selected\">Select Reward Type</option>\r\n                                        <option value=\"1\">Single Item (with choice)</option>\r\n                                        <option value=\"2\">Multiple Items</option>\r\n                                        <option value=\"3\">Random Item</option>\r\n                                    </select>\r\n                                </td>\r\n                            </tr>\r\n                        </table>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Items<br/><span>Specify reward items.</span></th>\r\n                    <td>\r\n                        <div id=newItem></div>\r\n                        <script type=\"text/javascript\">\r\n                            var iid = 0;\r\n\r\n                            function popitup(url) {\r\n                                newwindow = window.open(url, 'name', 'height = 550, width = 600');\r\n                                if (window.focus) {\r\n                                    newwindow.focus()\r\n                                }\r\n                                return false;\r\n                            }\r\n\r\n                            function addItem() {\r\n                                var newItem = \$('#newItem');\r\n                                var html = 'Item ' + (iid + 1) + ': <input type=\"text\" class=\"form-control\" style=\"display:inline; width:70%;\" maxlength=\"64\" size=\"64\" name=\"item' + iid + '\" value=\"";
        echo __ITEM_EMPTY__;
        echo "\" /> Count: <input type=\"text\" disabled=\"disabled\" class=\"form-control\" style=\"display:inline; max-width:50px;\" maxlength=\"3\" size=\"4\" name=\"itemcount' + iid + '\" value=\"1\" /><br>';\r\n                                newItem.append(html);\r\n                                iid = iid + 1;\r\n                            }\r\n                        </script>\r\n                        <br>\r\n                        <input type=\"button\" value=\"Add New\" class=\"btn btn-primary\" onClick=\"addItem();\">\r\n                        <input class=\"btn btn-primary\" type=\"button\" onClick=\"popitup('item_hex_generator.php')\" value=\"Item Code Generator\" title=\"Item Code Generator\">\r\n\r\n                    </td>\r\n                </tr>\r\n            </table>\r\n            <button type=\"submit\" class=\"btn btn-large btn-block btn-success\" name=\"add_reward\" value=\"ok\">Add Reward</button>\r\n        </form>\r\n        ";
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
    $xmlPath = __PATH_MODULE_CONFIGS__ . "usercp.wheeloffortune.xml";
    $xml = simplexml_load_file($xmlPath);
    $xml->active = $_POST["active"];
    $xml->items = $_POST["items"];
    $xml->price = $_POST["price"];
    $xml->price_type = $_POST["price_type"];
    $xml->max_spins = $_POST["max_spins"];
    $xml->circle_count = $_POST["circle_count"];
    $xml->interval_min = $_POST["interval_min"];
    $xml->interval_max = $_POST["interval_max"];
    $xml->enabled_month_day_start = $_POST["enabled_month_day_start"];
    $xml->enabled_month_day_end = $_POST["enabled_month_day_end"];
    $xml->enabled_week_day_start = $_POST["enabled_week_day_start"];
    $xml->enabled_week_day_end = $_POST["enabled_week_day_end"];
    $xml->enabled_hour_start = $_POST["enabled_hour_start"];
    $xml->enabled_hour_end = $_POST["enabled_hour_end"];
    $save = $xml->asXML($xmlPath);
    if ($save) {
        message("success", "Settings successfully saved.");
    } else {
        message("error", "There has been an error while saving changes.");
    }
}
function arrayToXML($array)
{
    $sxe = new SimpleXMLElement("<settings/>");
    $sxe->addChild("active", $array["active"]);
    $sxe->addChild("items", $array["items"]);
    $sxe->addChild("price", $array["price"]);
    $sxe->addChild("price_type", $array["price_type"]);
    $sxe->addChild("max_spins", $array["max_spins"]);
    $sxe->addChild("circle_count", $array["circle_count"]);
    $sxe->addChild("interval_min", $array["interval_min"]);
    $sxe->addChild("interval_max", $array["interval_max"]);
    $sxe->addChild("enabled_month_day_start", $array["enabled_month_day_start"]);
    $sxe->addChild("enabled_month_day_end", $array["enabled_month_day_end"]);
    $sxe->addChild("enabled_week_day_start", $array["enabled_week_day_start"]);
    $sxe->addChild("enabled_week_day_end", $array["enabled_week_day_end"]);
    $sxe->addChild("enabled_hour_start", $array["enabled_hour_start"]);
    $sxe->addChild("enabled_hour_end", $array["enabled_hour_end"]);
    $sxe->addChild("total_chance", $array["total_chance"]);
    $rewards = $sxe->addChild("rewards");
    if (is_array($array["rewards"])) {
        foreach ($array["rewards"] as $thisReward) {
            $reward = $rewards->addChild("reward");
            $reward->addAttribute("id", $thisReward["id"]);
            $reward->addAttribute("img", $thisReward["img"]);
            $reward->addAttribute("title", $thisReward["title"]);
            $reward->addAttribute("desc", $thisReward["desc"]);
            $reward->addAttribute("chance", $thisReward["chance"]);
            $reward->addAttribute("bgcolor", $thisReward["bgcolor"]);
            $reward->addAttribute("custombg", $thisReward["custombg"]);
            $reward->addAttribute("rewardAmount", $thisReward["rewardAmount"]);
            $reward->addAttribute("rewardType", $thisReward["rewardType"]);
            $reward->addAttribute("rewardItems", $thisReward["rewardItems"]);
            $reward->addAttribute("rewardItemsType", $thisReward["rewardItemsType"]);
            if (is_array($thisReward["items"])) {
                $items = $reward->addChild("items");
                foreach ($thisReward["items"] as $thisItem) {
                    $item = $items->addChild("item");
                    $item->addAttribute("count", $thisItem["count"]);
                    $item->addAttribute("hexcode", $thisItem["hexcode"]);
                }
            } else {
                $reward->addChild("items");
            }
        }
    }
    return $sxe->asXML();
}

?>