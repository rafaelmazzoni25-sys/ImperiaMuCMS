<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h2>Starting Kit Settings</h2>\r\n";
define("__RESPONSIVE__", "FALSE");
echo "<script type=\"text/javascript\" SRC=\"" . __PATH_TEMPLATE__ . "js/tooltip.js\"></script>";
$Market = new Market();
$Items = new Items();
if (check_value($_POST["submit_changes"])) {
    savechanges();
}
if (check_value($_POST["add_kit"])) {
    $classFilter = [];
    foreach ($custom["character_class"] as $classCode => $thisClass) {
        if (isset($_POST["class" . $classCode])) {
            $classFilter[$classCode] = $_POST["class" . $classCode];
        }
    }
    $class = implode(",", $classFilter);
    $items = [];
    $j = 0;
    $i = 0;
    while ($i < 50) {
        $index = "item" . $i;
        $index2 = "itemexp" . $i;
        if (!($_POST[$index] == NULL || $_POST[$index] == __ITEM_EMPTY__)) {
            $items[$j] = ["item" => xss_clean($_POST[$index]), "expiration" => xss_clean($_POST[$index2])];
            $j++;
        }
        $i++;
    }
    $Promo = new Promo();
    $Promo->addStartingKit($_POST["name"], $_POST["req_lvl"], $_POST["req_mlvl"], $_POST["req_reset"], $_POST["req_greset"], $_POST["req_lvl_max"], $_POST["req_mlvl_max"], $_POST["req_reset_max"], $_POST["req_greset_max"], $class, $items, $_POST["type"], $_POST["limit"]);
}
if (check_value($_POST["kit_edit_submit"])) {
    $classFilter = [];
    foreach ($custom["character_class"] as $classCode => $thisClass) {
        if (isset($_POST["class" . $classCode])) {
            $classFilter[$classCode] = $_POST["class" . $classCode];
        }
    }
    $class = implode(",", $classFilter);
    $items = [];
    $i = 0;
    while ($i < 50) {
        $index = "item" . $i;
        $index2 = "itemexp" . $i;
        $index3 = "itemid" . $i;
        if ($_POST[$index3] != NULL) {
            $items[$i] = ["id" => xss_clean($_POST[$index3]), "item" => xss_clean($_POST[$index]), "expiration" => xss_clean($_POST[$index2])];
        }
        $i++;
    }
    $Promo = new Promo();
    $Promo->editStartingKit($_POST["kit_id"], $_POST["name"], $_POST["req_lvl"], $_POST["req_mlvl"], $_POST["req_reset"], $_POST["req_greset"], $_POST["req_lvl_max"], $_POST["req_mlvl_max"], $_POST["req_reset_max"], $_POST["req_greset_max"], $class, $items, $_POST["type"], $_POST["limit"]);
}
if (check_value($_GET["delete"]) && is_numeric($_GET["delete"])) {
    $kitID = xss_clean($_GET["delete"]);
    $check = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_STARTING_KIT WHERE id = ?", [$kitID]);
    if (is_array($check)) {
        $dB->query("DELETE FROM IMPERIAMUCMS_STARTING_KIT_ITEMS WHERE kit_id = ?", [$kitID]);
        $delete = $dB->query("DELETE FROM IMPERIAMUCMS_STARTING_KIT WHERE id = ?", [$kitID]);
        if ($delete) {
            message("success", "Starting Kit #" . $kitID . " was successfully deleted.");
        } else {
            message("error", "Unexpected error occurred.");
        }
    } else {
        message("error", "Starting Kit #" . $kitID . " does not exist.");
    }
}
$General = new xGeneral();
if (check_value($_POST["activate_module"])) {
    $key = $_POST["license_key"];
    $General->jIhfnHDm_activate_KdiupmNBd_Module("startingkit", $key);
}
$isActivated = $General->jHdksHgYYix_isModule_hDbMVOIfs_Activated("startingkit");
if (!$isActivated) {
    echo "\r\n    <form method=\"post\" action=\"\">\r\n        <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n            <tr>\r\n                <th>License Key<br/><span></span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"license_key\" value=\"\" size=\"30\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td colspan=\"2\"><input type=\"submit\" name=\"activate_module\" value=\"Activate Module\" class=\"btn btn-success\"/>\r\n                </td>\r\n            </tr>\r\n        </table>\r\n    </form>";
} else {
    loadModuleConfigs("usercp.startingkit");
    echo "    <form action=\"index.php?module=modules_manager&config=startingkit\" method=\"post\">\r\n        <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n            <tr>\r\n                <th>Status<br/><span>Enable/disable the starting kit module.</span></th>\r\n                <td>\r\n                    ";
    enabledisableCheckboxes("setting_1", mconfig("active"), "Enabled", "Disabled");
    echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Kits per Account<br/><span>Total starting kits what can be claimed by single account.</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"setting_2\" value=\"";
    echo mconfig("kits_per_account");
    echo "\" placeholder=\"Kits per Account\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Kits per Character<br/><span>Total starting kits what can be claimed by single character.<br>Notice: <b>Kits per Account</b> value has higher priority.</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"setting_3\" value=\"";
    echo mconfig("kits_per_character");
    echo "\" placeholder=\"Kits per Character\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td colspan=\"2\"><input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\" class=\"btn btn-success\"/></td>\r\n            </tr>\r\n        </table>\r\n    </form>\r\n\r\n    <hr>\r\n    <h3>Add New Starting Kit</h3>\r\n    <form method=\"post\" action=\"\">\r\n        <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n            <tr>\r\n                <th>Name<br/><span>Enter name of the reward.</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"name\" value=\"\" placeholder=\"Name\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Limit per Character<br/><span>Enter limit how many times kit can be claimed by specific character.</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"limit\" value=\"\" placeholder=\"Limit per Character\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Required Level<br/><span>Enter required level to claim this starting kit.</span></th>\r\n                <td>\r\n                    <table width=\"100%\">\r\n                        <tr>\r\n                            <td width=\"50%\">\r\n                                <div class=\"input-group\">\r\n                                    <div class=\"input-group-addon\">Min. Level</div>\r\n                                    <input class=\"form-control\" type=\"text\" name=\"req_lvl\" value=\"0\" placeholder=\"Min. Level\"/>\r\n                                </div>\r\n                            </td>\r\n                            <td width=\"50%\">\r\n                                <div class=\"input-group\">\r\n                                    <div class=\"input-group-addon\">Max. Level</div>\r\n                                    <input class=\"form-control\" type=\"text\" name=\"req_lvl_max\" value=\"400\" placeholder=\"Max. Level\"/>\r\n                                </div>\r\n                            </td>\r\n                        </tr>\r\n                    </table>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Required Master Level<br/><span>Enter required master level to claim this starting kit.</span></th>\r\n                <td>\r\n                    <table width=\"100%\">\r\n                        <tr>\r\n                            <td width=\"50%\">\r\n                                <div class=\"input-group\">\r\n                                    <div class=\"input-group-addon\">Min. Master Level</div>\r\n                                    <input class=\"form-control\" type=\"text\" name=\"req_mlvl\" value=\"0\" placeholder=\"Min. Master Level\"/>\r\n                                </div>\r\n                            </td>\r\n                            <td width=\"50%\">\r\n                                <div class=\"input-group\">\r\n                                    <div class=\"input-group-addon\">Max. Master Level</div>\r\n                                    <input class=\"form-control\" type=\"text\" name=\"req_mlvl_max\" value=\"400\" placeholder=\"Max. Master Level\"/>\r\n                                </div>\r\n                            </td>\r\n                        </tr>\r\n                    </table>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Required Reset<br/><span>Enter required reset to claim this starting kit.</span></th>\r\n                <td>\r\n                    <table width=\"100%\">\r\n                        <tr>\r\n                            <td width=\"50%\">\r\n                                <div class=\"input-group\">\r\n                                    <div class=\"input-group-addon\">Min. Reset</div>\r\n                                    <input class=\"form-control\" type=\"text\" name=\"req_reset\" value=\"0\" placeholder=\"Min. Reset\"/>\r\n                                </div>\r\n                            </td>\r\n                            <td width=\"50%\">\r\n                                <div class=\"input-group\">\r\n                                    <div class=\"input-group-addon\">Max. Reset</div>\r\n                                    <input class=\"form-control\" type=\"text\" name=\"req_reset_max\" value=\"999\" placeholder=\"Max. Reset\"/>\r\n                                </div>\r\n                            </td>\r\n                        </tr>\r\n                    </table>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Required Grand Reset<br/><span>Enter required grand reset to claim this starting kit.</span></th>\r\n                <td>\r\n                    <table width=\"100%\">\r\n                        <tr>\r\n                            <td width=\"50%\">\r\n                                <div class=\"input-group\">\r\n                                    <div class=\"input-group-addon\">Min. Grand Reset</div>\r\n                                    <input class=\"form-control\" type=\"text\" name=\"req_greset\" value=\"0\" placeholder=\"Min. Grand Reset\"/>\r\n                                </div>\r\n                            </td>\r\n                            <td width=\"50%\">\r\n                                <div class=\"input-group\">\r\n                                    <div class=\"input-group-addon\">Max. Grand Reset</div>\r\n                                    <input class=\"form-control\" type=\"text\" name=\"req_greset_max\" value=\"999\" placeholder=\"Max. Grand Reset\"/>\r\n                                </div>\r\n                            </td>\r\n                        </tr>\r\n                    </table>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Class Filter<br/><span>Check all classes for what will be this starting available.</span></th>\r\n                <td>\r\n                    <table width=\"100%\">\r\n                        ";
    $itemsPerLine = 3;
    $currentLine = 0;
    $counter = 0;
    if (122 <= config("server_files_season", true)) {
        $itemsPerLine = 4;
    }
    foreach ($custom["character_class"] as $classCode => $thisClass) {
        if ($counter == 0) {
            echo "<tr>";
        }
        echo "<td><input type=\"checkbox\" name=\"class" . $classCode . "\" value=\"" . $classCode . "\" checked=\"checked\"/> " . $thisClass[0] . "</td>";
        if ($currentLine == 3 || $currentLine == 4 || $currentLine == 6 || $currentLine == 7) {
            if ($counter == $itemsPerLine - 2) {
                echo "</tr>";
                $counter = 0;
                $currentLine++;
            }
        } else {
            if ($counter == $itemsPerLine - 1) {
                echo "</tr>";
                $counter = 0;
                $currentLine++;
            }
        }
        $counter++;
    }
    echo "                    </table>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Reward Items Type<br/><span>You can configure multiple items or single item choice from predefined items.</span></th>\r\n                <td>\r\n                    <select name=\"type\" class=\"form-control\">\r\n                        <option value=\"1\">Single Item (with choice)</option>\r\n                        <option value=\"2\">Multiple Items</option>\r\n                        <option value=\"3\">Random Item</option>\r\n                    </select>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Reward Items<br/><span>Configure reward items and their expiration in minutes. Use \"0\" for non-expirable items.<br>\r\n                Items are added into character's inventory so make sure, that there will be enough space for them.<br>\r\n                <b>Recommended Starting Kit:</b> 2 weapons (weapon + shield), complete set (helm, armor, pants, globes, boots), 2 rings, pendant and maybe some pets like panda, demon etc.<br>\r\n                <b>Warning:</b> Maximum 50 items.</span>\r\n                </th>\r\n                <td>\r\n                    <div id=newItem></div>\r\n                    <script type=\"text/javascript\">\r\n                        var iid = 0;\r\n\r\n                        function popitup(url) {\r\n                            newwindow = window.open(url, 'name', 'height = 550, width = 600');\r\n                            if (window.focus) {\r\n                                newwindow.focus()\r\n                            }\r\n                            return false;\r\n                        }\r\n\r\n                        function addItem() {\r\n                            var newItem = \$('#newItem');\r\n                            var html = 'Item ' + (iid + 1) + ': <input type=\"text\" class=\"form-control\" style=\"display:inline; width:60%;\" maxlength=\"64\" size=\"80\" name=\"item' + iid + '\" value=\"";
    echo __ITEM_EMPTY__;
    echo "\" />' +\r\n                                ' Expiration: <input type=\"text\" class=\"form-control\" style=\"display:inline; width:50px;\" size=\"80\" name=\"itemexp' + iid + '\" value=\"0\" /> minute(s)<hr>';\r\n                            newItem.append(html);\r\n                            iid = iid + 1;\r\n                        }\r\n                    </script>\r\n                    <br>\r\n                    <input type=\"button\" value=\"Add New\" class=\"btn btn-primary\" onClick=\"addItem();\">\r\n                    <input class=\"btn btn-primary\" type=\"button\" onClick=\"popitup('item_hex_generator.php')\" value=\"Item Code Generator\" title=\"Item Code Generator\">\r\n                </td>\r\n            </tr>\r\n        </table>\r\n        <button type=\"submit\" class=\"btn btn-large btn-block btn-success\" name=\"add_kit\" value=\"ok\">Add Kit</button>\r\n    </form>\r\n\r\n    <hr>\r\n    <h3>Manage Starting Kits</h3>\r\n    <small>To delete item from Starting Kit delete it's hex code or use \"";
    echo __ITEM_EMPTY__;
    echo "\" and click on Save button.</small>\r\n    ";
    $kits = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_STARTING_KIT ORDER BY id");
    if (is_array($kits)) {
        foreach ($kits as $kit) {
            $classFilter = explode(",", $kit["req_class"]);
            echo "<form method=\"post\"><table class=\"table table-striped table-bordered table-hover\"><tr>";
            echo "<td>" . $kit["id"] . "</td>";
            echo "<td>\r\n            Name: <input class=\"form-control\" type=\"text\" name=\"name\" value=\"" . $kit["title"] . "\" placeholder=\"Name\" style=\"width: 250px; display: inline;\"/><br>        \r\n            Limit: <input class=\"form-control\" type=\"text\" name=\"limit\" value=\"" . $kit["limit"] . "\" placeholder=\"Limit per Character\" style=\"width: 250px; display: inline;\"/><br>            \r\n            Class filter:\r\n            <table width=\"100%\">";
            $itemsPerLine = 3;
            $currentLine = 0;
            $counter = 0;
            if (122 <= config("server_files_season", true)) {
                $itemsPerLine = 4;
            }
            foreach ($custom["character_class"] as $classCode => $thisClass) {
                if ($counter == 0) {
                    echo "<tr>";
                }
                echo "<td><input type=\"checkbox\" name=\"class" . $classCode . "\" value=\"" . $classCode . "\" ";
                if (in_array($classCode, $classFilter)) {
                    echo "checked=\"checked\"";
                }
                echo "/> " . $thisClass[1] . "</td>";
                if ($currentLine == 3 || $currentLine == 4 || $currentLine == 6 || $currentLine == 7) {
                    if ($counter == $itemsPerLine - 2) {
                        echo "</tr>";
                        $counter = 0;
                        $currentLine++;
                    }
                } else {
                    if ($counter == $itemsPerLine - 1) {
                        echo "</tr>";
                        $counter = 0;
                        $currentLine++;
                    }
                }
                $counter++;
            }
            echo "\r\n            </table>\r\n        </td>";
            echo "\r\n        <td align=\"right\">\r\n            <div class=\"input-group\">\r\n                <div class=\"input-group-addon\">Min. Level</div>\r\n                <input class=\"form-control\" type=\"text\" name=\"req_lvl\" value=\"" . $kit["req_lvl"] . "\" placeholder=\"Min. Level\"/>\r\n            </div>\r\n            <div class=\"input-group\">\r\n                <div class=\"input-group-addon\">Max. Level</div>\r\n                <input class=\"form-control\" type=\"text\" name=\"req_lvl_max\" value=\"" . $kit["req_lvl_max"] . "\" placeholder=\"Max. Level\"/>\r\n            </div>\r\n            <div class=\"input-group\">\r\n                <div class=\"input-group-addon\">Min. Master Level</div>\r\n                <input class=\"form-control\" type=\"text\" name=\"req_mlvl\" value=\"" . $kit["req_mlvl"] . "\" placeholder=\"Min. Master Level\"/>\r\n            </div>\r\n            <div class=\"input-group\">\r\n                <div class=\"input-group-addon\">Max. Master Level</div>\r\n                <input class=\"form-control\" type=\"text\" name=\"req_mlvl_max\" value=\"" . $kit["req_mlvl_max"] . "\" placeholder=\"Max. Master Level\"/>\r\n            </div>\r\n            <div class=\"input-group\">\r\n                <div class=\"input-group-addon\">Min. Reset</div>\r\n                <input class=\"form-control\" type=\"text\" name=\"req_reset\" value=\"" . $kit["req_reset"] . "\" placeholder=\"Min. Reset\"/>\r\n            </div>\r\n            <div class=\"input-group\">\r\n                <div class=\"input-group-addon\">Max. Reset</div>\r\n                <input class=\"form-control\" type=\"text\" name=\"req_reset_max\" value=\"" . $kit["req_reset_max"] . "\" placeholder=\"Max. Reset\"/>\r\n            </div>\r\n            <div class=\"input-group\">\r\n                <div class=\"input-group-addon\">Min. Grand Reset</div>\r\n                <input class=\"form-control\" type=\"text\" name=\"req_greset\" value=\"" . $kit["req_greset"] . "\" placeholder=\"Min. Grand Reset\"/>\r\n            </div>\r\n            <div class=\"input-group\">\r\n                <div class=\"input-group-addon\">Max. Grand Reset</div>\r\n                <input class=\"form-control\" type=\"text\" name=\"req_greset_max\" value=\"" . $kit["req_greset_max"] . "\" placeholder=\"Max. Grand Reset\"/>\r\n            </div>\r\n        </td>";
            echo "\r\n        <td>\r\n            <select name=\"type\" class=\"form-control\">";
            if ($kit["type"] == "1") {
                echo "<option value=\"1\" selected=\"selected\">Single Item (with choice)</option>";
            } else {
                echo "<option value=\"1\">Single Item (with choice)</option>";
            }
            if ($kit["type"] == "2" || $kit["type"] == NULL) {
                echo "<option value=\"2\" selected=\"selected\">Multiple Items</option>";
            } else {
                echo "<option value=\"2\">Multiple Items</option>";
            }
            if ($kit["type"] == "3") {
                echo "<option value=\"3\" selected=\"selected\">Random Item</option>";
            } else {
                echo "<option value=\"3\">Random Item</option>";
            }
            echo "\r\n            </select><br>";
            $items = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_STARTING_KIT_ITEMS WHERE kit_id = ? ORDER BY id", [$kit["id"]]);
            $rewardItemsShow = "";
            $i = 0;
            foreach ($items as $item) {
                $itemInfo = $Items->ItemInfo($item["item"]);
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
                $rewardItemsShow .= "<input type=\"hidden\" name=\"itemid" . $i . "\" value=\"" . $item["id"] . "\"/><span  style=\"cursor: pointer;\" onmouseover=\"Tip('<center><img src=" . $itemInfo["thumb"] . "><br /><font color=yellow><br><font color=white><br>Durability: " . $itemInfo["dur"] . "</font><br><font color=#FF99CC>" . $itemInfo["jog"] . "</font><font color=FFCC00>" . $itemInfo["harm"] . "</font><br>" . $option . " " . $luck . " " . $skill . " " . $exl . " <br>" . $ancsetopt . "<br><font color=#4d668d>" . $itemInfo["socket"] . "</font><br><br><span class=itemTooltipClassReq>" . $itemInfo["classReq"] . "</span></center>', TITLEFONTCOLOR, '" . $itemInfo["color"] . "',TITLE,'" . addslashes($itemInfo["name"]) . $itemInfo["level"] . "',TITLEBGCOLOR,'" . $itemInfo["anco"] . "')\" onmouseout=\"UnTip()\">" . $itemInfo["name"] . "</span>: <input class=\"form-control\" type=\"text\" name=\"item" . $i . "\" value=\"" . $item["item"] . "\" placeholder=\"Item Hex Code\" style=\"width: 250px; display: inline;\"/>";
                $rewardItemsShow .= " Expiration: <input class=\"form-control\" type=\"text\" name=\"itemexp" . $i . "\" value=\"" . $item["expiration"] . "\" placeholder=\"Expiration\" style=\"width: 50px; display: inline;\"/> minute(s)";
                $rewardItemsShow .= "<br>";
                $i++;
            }
            echo $rewardItemsShow;
            echo "<hr><div id=\"newItemMng" . $kit["id"] . "\"></div>\r\n            <script type=\"text/javascript\">\r\n                var iid" . $kit["id"] . " = " . count($items) . ";\r\n                function addItem" . $kit["id"] . "() {\r\n                    var newItem = \$('#newItemMng" . $kit["id"] . "');\r\n                    var html = 'Item ' + (iid" . $kit["id"] . " + 1) + ': <input type=\"hidden\" name=\"itemid' + iid" . $kit["id"] . " + '\" value=\"0\"/><input type=\"text\" class=\"form-control\" style=\"display:inline; width:60%;\" maxlength=\"64\" size=\"80\" name=\"item' + iid" . $kit["id"] . " + '\" value=\"" . __ITEM_EMPTY__ . "\" />' +\r\n                               ' Expiration: <input type=\"text\" class=\"form-control\" style=\"display:inline; width:50px;\" size=\"80\" name=\"itemexp' + iid" . $kit["id"] . " + '\" value=\"0\" /> minute(s)<br>';\r\n                    newItem.append(html);\r\n                    iid" . $kit["id"] . " = iid" . $kit["id"] . " + 1;\r\n                }\r\n            </script><br>\r\n            <input type=\"button\" value=\"Add New\" class=\"btn btn-primary\" onClick=\"addItem" . $kit["id"] . "();\">\r\n            <input class=\"btn btn-primary\" type=\"button\" onClick=\"popitup('item_hex_generator.php')\" value=\"Item Code Generator\" title=\"Item Code Generator\">";
            $itemsDivID = "#newItemMng" . $kit["id"];
            echo "</td>";
            echo "<td><input type=\"hidden\" name=\"kit_id\" value=\"" . $kit["id"] . "\"/><input type=\"submit\" class=\"btn btn-success\" name=\"kit_edit_submit\" value=\"Save\"> <a href=\"index.php?module=modules_manager&amp;config=startingkit&amp;delete=" . $kit["id"] . "\" class=\"btn btn-danger\"><i class=\"fa fa-remove\"></i></a></td>";
            echo "</tr></table></form>";
        }
    } else {
        echo "<br><br>";
        message("info", "No starting kits");
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
    $xmlPath = __PATH_MODULE_CONFIGS__ . "usercp.startingkit.xml";
    $xml = simplexml_load_file($xmlPath);
    $xml->active = $_POST["setting_1"];
    $xml->kits_per_account = $_POST["setting_2"];
    $xml->kits_per_character = $_POST["setting_3"];
    $save = $xml->asXML($xmlPath);
    if ($save) {
        message("success", "Settings successfully saved.");
    } else {
        message("error", "There has been an error while saving changes.");
    }
}

?>