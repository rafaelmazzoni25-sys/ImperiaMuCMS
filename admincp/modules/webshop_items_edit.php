<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h1 class=\"page-header\">Edit Item</h1>\r\n";
$Webshop = new Webshop();
loadModuleConfigs("webshop");
if (check_value($_POST["update_item"])) {
    $Webshop->updateItemNew($_REQUEST["id"], $_POST["item_id"], $_POST["item_cat"], $_POST["max_item_lvl"], $_POST["max_item_opt"], $_POST["exetype"], $_POST["name"], $_POST["price"], $_POST["luck"], $_POST["skill"], $_POST["use_sockets"], $_POST["use_harmony"], $_POST["use_refinary"], $_POST["setting_7"], $_POST["description"], $_POST["main_cat"], $_POST["setting_15"], $_POST["image"], $_POST["on_sale"], $_POST["item_lvl"], $_POST["store_count"], $_POST["item_exc"], $_POST["can_gift"], $_POST["status"], $_POST["max_exc_opt"], $_POST["max_socket"]);
}
$editItems = $Webshop->loadItemDataNew($_REQUEST["id"]);
if ($editItems) {
    $categories = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_WEBSHOP_CATEGORY WHERE type = 1 ORDER BY [order]");
    $catOpts = "<option value=\"\">-- None --</option>";
    if (is_array($categories)) {
        foreach ($categories as $thisCat) {
            $catOpts .= "<optgroup label=\"" . $thisCat["title"] . "\">";
            $subcategories = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_WEBSHOP_CATEGORY WHERE type = ? AND parent = ? ORDER BY [order]", [2, $thisCat["code"]]);
            if (is_array($subcategories)) {
                foreach ($subcategories as $thisSub) {
                    if ($thisSub["code"] != "51" && $thisSub["code"] != "52" && $thisSub["code"] != "53") {
                        if ($editItems["main_cat"] == $thisSub["code"]) {
                            $catOpts .= "<option value=\"" . $thisSub["code"] . "\" selected=\"selected\">" . $thisSub["title"] . "</option>";
                        } else {
                            $catOpts .= "<option value=\"" . $thisSub["code"] . "\">" . $thisSub["title"] . "</option>";
                        }
                    }
                }
            }
            $catOpts .= "</optgroup>";
        }
    }
    echo "<a class=\"btn btn-primary\" href=\"" . admincp_base("webshop_items") . "\">ITEMS MANAGER</a><br/><br/>";
    echo "    <form role=\"form\" method=\"post\">\r\n        <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n            <tr>\r\n                <th>Status<br/><span>Enable/disable item in webshop.</span></th>\r\n                <td>\r\n                    ";
    enabledisableCheckboxes("status", $editItems["status"], "Enabled", "Disabled");
    echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Name<br/><span>Item Name</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"name\"\r\n                           value=\"";
    echo $editItems["name"];
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Type<br/><span>Item category (0 - sword, 1 - axe, 2 - mace & scepter, 3 - spear, 4 - bow & crossbow, 5 - staff, 6 - shield, <br>\r\n                7 - helm, 8 - armor, 9 - pants, 10 - gloves, 11 - boots, 12 - mix 1, 13 - mix 2, 14 - mix 3, 15 - scroll)</span>\r\n                </th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"item_cat\"\r\n                           value=\"";
    echo $editItems["item_cat"];
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Index<br/><span>Item index in item list</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"item_id\"\r\n                           value=\"";
    echo $editItems["item_id"];
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Level<br/><span>Item level (for example Box of Kundun +1: type = 14, index = 11, level = 8), don't use for regular items like weapons, shields, sets etc.!</span>\r\n                </th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"item_lvl\"\r\n                           value=\"";
    echo $editItems["item_lvl"];
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Excellent<br/><span>Use only for Fenrirs! (0 - Red, 1 - Black, 2 - Blue, 4 - Golden)</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"item_exc\"\r\n                           value=\"";
    echo $editItems["item_exc"];
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Max Level<br/><span>Max Item Level, values 0 - 15</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"max_item_lvl\"\r\n                           value=\"";
    echo $editItems["max_item_lvl"];
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Max Option<br/><span>Max Item Option, values 0 - 7</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"max_item_opt\"\r\n                           value=\"";
    echo $editItems["max_item_opt"];
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Max Excellent Options<br/><span>Max excellent options, values 0 - 6</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"max_exc_opt\" value=\"";
    echo $editItems["max_exc_opt"];
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Max Socket Options<br/><span>Max socket options, values 0 - 5</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"max_socket\" value=\"";
    echo $editItems["max_socket"];
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Price<br/><span>Price</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"price\"\r\n                           value=\"";
    echo $editItems["price"];
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Payment type<br/><span>CURRENTLY NOT USED</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"setting_7\" value=\"1\" readonly=\"readonly\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Luck<br/><span>0 - item can not have luck, 1 - item can have luck</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"luck\"\r\n                           value=\"";
    echo $editItems["luck"];
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Skill<br/><span>0 - item can not have skill, 1 - item can have skill</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"skill\"\r\n                           value=\"";
    echo $editItems["skill"];
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Excellent Type<br/><span>0 - item what cannot have excellent option<br>1 - weapons and pendants, 2 - sets, shields and rings, 3 - 2nd wings, 4 - 3rd wings, 5 - Cape of Lord, 6 - Cape of Fighter,<br>7 - 2.5 wings, 8 - Wings of Angel and Devil, 9 - Wings of Conqueror, 10 - 4th wings, 11 - left earrings, 12 - right earrings</span>\r\n                </th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"exetype\"\r\n                           value=\"";
    echo $editItems["exetype"];
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Harmony Option<br/><span>0 - item can not have harmony option, 1 - item can have harmony option</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"use_harmony\"\r\n                           value=\"";
    echo $editItems["use_harmony"];
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>380 lvl (Pink) Option<br/><span>0 - item can not have pink option, 1 - item can have pink option</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"use_refinary\"\r\n                           value=\"";
    echo $editItems["use_refinary"];
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Socket Option<br/><span>0 - item can not have socket option, 1 - item can have socket option</span>\r\n                </th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"use_sockets\"\r\n                           value=\"";
    echo $editItems["use_sockets"];
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n\r\n            <tr>\r\n                <th>Main Category<br/><span>1 - Special, 2 - Weapon, 3 - Equipment, 4 - Wing, 5 - Accessory, 6 - Pet, 7 - Crafting</span>\r\n                </th>\r\n                <td>\r\n                    <select class=\"form-control\" name=\"main_cat\">\r\n                        ";
    echo $catOpts;
    echo "                    </select>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Sub Category<br/><span>CURRENTLY NOT USED</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"setting_15\" value=\"0\" readonly=\"readonly\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Image<br/><span>Location: /templates/.../img/item_images/ | Value example: box_of_kundun5.jpg</span>\r\n                </th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"image\"\r\n                           value=\"";
    echo $editItems["image"];
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Store Count<br/><span>How many items will be available for sale (-1 unlimited)</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"store_count\"\r\n                           value=\"";
    echo $editItems["store_count"];
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Is on Sale<br/><span>CURRENTLY NOT USED<br>0 - no, values 1-99 - yes | For example, if this config will be 25, item price will be lowered by 25%</span>\r\n                </th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"on_sale\"\r\n                           value=\"";
    echo $editItems["on_sale"];
    echo "\" readonly=\"readonly\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Can be gifted<br/><span>0 - no, 1 - yes</span>\r\n                </th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"can_gift\"\r\n                           value=\"";
    echo $editItems["can_gift"];
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Description<br/><span>Item Description</span></th>\r\n                <td>\r\n                    <textarea name=\"description\" id=\"description\">";
    echo $editItems["description"];
    echo "</textarea>\r\n                </td>\r\n            </tr>\r\n        </table>\r\n        <button type=\"submit\" class=\"btn btn-large btn-block btn-success\" name=\"update_item\" value=\"ok\">Update Item\r\n        </button>\r\n    </form>\r\n\r\n    <script src=\"";
    echo __BASE_URL__;
    echo "admincp/ckeditor/ckeditor.js\"></script>\r\n    <script type=\"text/javascript\">//<![CDATA[\r\n        //CKEDITOR.replace('editor1');\r\n        CKEDITOR.replace('description', {\r\n            language: 'en',\r\n            uiColor: '#f1f1f1'\r\n        });\r\n        //]]></script>\r\n    ";
}

?>