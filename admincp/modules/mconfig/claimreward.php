<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */
echo "<h2>Claim Reward Settings</h2>\r\n";
if (check_value($_POST["submit_changes"])) {
    savechanges();
}
if (check_value($_POST["add_reward"])) {
    $reward_items = "";
    $i = 0;
    while ($i < 50) {
        $index = "item" . $i;
        if (!($_POST[$index] == NULL || $_POST[$index] == __ITEM_EMPTY__)) {
            if ($reward_items == NULL || empty($reward_items)) {
                $reward_items .= $_POST[$index];
            } else {
                $reward_items .= "," . $_POST[$index];
            }
        }
        $i++;
    }
    $Promo = new Promo();
    if (empty($_POST["accounts"])) {
        $_POST["accounts"] = NULL;
    }
    if (empty($_POST["characters"])) {
        $_POST["characters"] = NULL;
    }
    if (empty($reward_items)) {
        $reward_items = NULL;
    }
    if (empty($_POST["items_type"])) {
        $_POST["items_type"] = NULL;
    }
    if (empty($_POST["amount"])) {
        $_POST["amount"] = NULL;
    }
    if (empty($_POST["amount_type"])) {
        $_POST["amount_type"] = NULL;
    }
    if (empty($_POST["items_exp"])) {
        $_POST["items_exp"] = NULL;
    }
    if (empty($_POST["reward_exp"])) {
        $_POST["reward_exp"] = NULL;
    }
    $Promo->addReward($_POST["name"], $_POST["author"], $_POST["accounts"], $_POST["characters"], $reward_items, $_POST["items_type"], $_POST["amount"], $_POST["amount_type"], $_POST["items_exp"], $_POST["reward_exp"], true);
}
echo "<script type=\"text/javascript\" SRC=\"" . __PATH_TEMPLATE__ . "js/tooltip.js\"></script>";
$Market = new Market();
loadModuleConfigs("usercp.claimreward");
echo "<form action=\"\" method=\"post\">\r\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n        <tr>\r\n            <th>Status<br/><span>Enable/disable the claim reward module.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_1", mconfig("active"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Items per Page<br/><span>Enter number of items displayed per page.</span></th>\r\n            <td>\r\n                <input type=\"text\" name=\"page_limit\" class=\"form-control\" value=\"";
echo mconfig("page_limit");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan=\"2\"><input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\" class=\"btn btn-success\"/></td>\r\n        </tr>\r\n    </table>\r\n</form>\r\n\r\n<hr>\r\n<h3>Add New Reward</h3>\r\n<form method=\"post\" action=\"\">\r\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n        <tr>\r\n            <th>Name<br/><span>Enter name of the reward.</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"name\" value=\"\" placeholder=\"Name\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Author<br/><span>Reward's author.</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"author\" value=\"";
echo $_SESSION["username"];
echo "\" placeholder=\"Author\" readonly=\"readonly\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Receivers<br/><span>Enter AccountIDs or character names separated by comma.<br>If you want to give expiration items, you must fill Receivers - Characters.\r\n                <br>DO NOT FILL BOTH INPUTS, GIVE REWARD TO ACCOUNTS OR CHARACTERS !!!<br>Leave empty if you want to give reward to all accounts.\r\n                <br>It's not possible to add expiration items to all accounts, you must specify exact characters!</span></th>\r\n            <td>\r\n                <b>AccountIDs:</b><textarea class=\"form-control\" name=\"accounts\" value=\"\" placeholder=\"Receivers - AccountIDs\" style=\"height: 100px;\"></textarea>\r\n                <b>Characters:</b><textarea class=\"form-control\" name=\"characters\" value=\"\" placeholder=\"Receivers - Characters\" style=\"height: 100px;\"></textarea>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Reward Amount<br/><span>Enter amount of currency.</span></th>\r\n            <td>\r\n                <table width=\"100%\">\r\n                    <tr>\r\n                        <td width=\"50%\"><input class=\"form-control\" type=\"text\" name=\"amount\" value=\"\" placeholder=\"Reward Amount\"/></td>\r\n                        <td width=\"50%\">\r\n                            <select name=\"amount_type\" class=\"form-control\">\r\n                                <option value=\"0\" disabled=\"disabled\" selected=\"selected\">Select Currency Type</option>\r\n                                <option value=\"1\">Platinum Coins</option>\r\n                                <option value=\"2\">Gold Coins</option>\r\n                                <option value=\"3\">Silver Coins</option>\r\n                                <option value=\"4\">WCoinC</option>\r\n                                <option value=\"7\">WCoinP</option>\r\n                                <option value=\"5\">Goblin Points</option>\r\n                                <option value=\"6\">Zen</option>\r\n                            </select>\r\n                        </td>\r\n                    </tr>\r\n                </table>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Reward Items<br/><span>Configure reward items.</span></th>\r\n            <td>\r\n                <select name=\"items_type\" class=\"form-control\">\r\n                    <option value=\"0\" disabled=\"disabled\" selected=\"selected\">Select Reward Type</option>\r\n                    <option value=\"1\">Single Item (with choice)</option>\r\n                    <option value=\"2\">Multiple Items</option>\r\n                    <option value=\"3\">Random Item</option>\r\n                </select>\r\n                <hr>\r\n                <div id=newItem></div>\r\n                <script type=\"text/javascript\">\r\n                    var iid = 0;\r\n\r\n                    function popitup(url) {\r\n                        newwindow = window.open(url, 'name', 'height = 550, width = 600');\r\n                        if (window.focus) {\r\n                            newwindow.focus()\r\n                        }\r\n                        return false;\r\n                    }\r\n\r\n                    function addItem() {\r\n                        var newItem = \$('#newItem');\r\n                        var html = 'Item ' + (iid + 1) + ': <input type=\"text\" class=\"form-control\" style=\"display:inline; width:90%;\" maxlength=\"64\" size=\"80\" name=\"item' + iid + '\" value=\"";
echo __ITEM_EMPTY__;
echo "\" /><br>';\r\n                        newItem.append(html);\r\n                        iid = iid + 1;\r\n                    }\r\n                </script>\r\n                <br>\r\n                <input type=\"button\" value=\"Add New\" class=\"btn btn-primary\" onClick=\"addItem();\">\r\n                <input class=\"btn btn-primary\" type=\"button\" onClick=\"popitup('item_hex_generator.php')\" value=\"Item Code Generator\" title=\"Item Code Generator\">\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Items Expiration<br/><span>Use only if reward receivers are characters, DO NOT use it for AccountIDs.<br>Leave empty for non-expiration items.</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"items_exp\" value=\"\" placeholder=\"Enter amount in minutes\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Reward Expiration<br/><span>Leave empty if unlimited. If won't be empty, reward will be available for claim only until selected date & time.<br>Format: YYYY-MM-DD HH:MM:SS</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"reward_exp\" value=\"\" placeholder=\"Reward Expiration\"/>\r\n            </td>\r\n        </tr>\r\n    </table>\r\n    <button type=\"submit\" class=\"btn btn-large btn-block btn-success\" name=\"add_reward\" value=\"ok\">Add Reward</button>\r\n</form>\r\n";
function saveChanges()
{
    
    foreach ($_POST as $setting) {
        if (!check_value($setting)) {
            message("error", "Missing data (complete all fields).");
            return NULL;
        }
    }
    $xmlPath = __PATH_MODULE_CONFIGS__ . "usercp.claimreward.xml";
    $xml = simplexml_load_file($xmlPath);
    $xml->active = $_POST["setting_1"];
    $xml->page_limit = $_POST["page_limit"];
    $save = $xml->asXML($xmlPath);
    if ($save) {
        message("success", "Settings successfully saved.");
    } else {
        message("error", "There has been an error while saving changes.");
    }
}

?>