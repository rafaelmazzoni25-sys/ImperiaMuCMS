<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h1 class=\"page-header\">Edit Mystery Box</h1>\r\n\r\n";
$Webshop = new Webshop();
if (check_value($_POST["edit_mystery"])) {
    $Webshop->editMystery($_REQUEST["id"], $_POST["setting_1"], $_POST["setting_2"], $_POST["setting_3"], $_POST["setting_4"], $_POST["setting_5"], $_POST["setting_6"], $_POST["setting_7"], $_POST["setting_8"], $_POST["req_class"]);
    $delete = $dB->query("DELETE FROM IMPERIAMUCMS_WEBSHOP_MYSTERY_ITEMS WHERE mystery_id = ?", [$_REQUEST["id"]]);
    $i = 0;
    while ($i < 50) {
        $index = "item" . $i;
        $chance = "chance" . $i;
        if (!($_POST[$index] == NULL || $_POST[$index] == __ITEM_EMPTY__)) {
            if ($_POST[$chance] < 1 || $_POST[$chance] == NULL) {
                $_POST[$chance] = 1;
            }
            $Webshop->addMysteryItem($_REQUEST["id"], $_POST[$index], $_POST[$chance]);
        }
        $i++;
    }
}
$mysteryData = $Webshop->getMysteryData($_REQUEST["id"]);
$mysteryItems = $Webshop->getMysteryItems($_REQUEST["id"]);
echo "<a class=\"btn btn-primary\" href=\"" . admincp_base("webshop_mystery") . "\">MYSTERY BOX MANAGER</a><br/><br/>";
echo "<form role=\"form\" method=\"post\">\r\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n        <tr>\r\n            <th>Status<br/><span>Enable/disable mystery box.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_7", $mysteryData["status"], "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Name<br/><span>Mystery Box Name</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_1\" value=\"";
echo $mysteryData["name"];
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Price<br/><span>Price</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_2\" value=\"";
echo $mysteryData["price"];
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Class Filter<br/><span>Select class filter.</span></th>\r\n            <td>\r\n                <select name=\"req_class\" class=\"form-control\">\r\n                    ";
if ($mysteryData["req_class"] == "all") {
    echo "<option value=\"all\" selected=\"selected\">All</option>";
} else {
    echo "<option value=\"all\">All</option>";
}
if ($mysteryData["req_class"] == "wizard") {
    echo "<option value=\"wizard\" selected=\"selected\">Wizard</option>";
} else {
    echo "<option value=\"wizard\">Wizard</option>";
}
if ($mysteryData["req_class"] == "knight") {
    echo "<option value=\"knight\" selected=\"selected\">Knight</option>";
} else {
    echo "<option value=\"knight\">Knight</option>";
}
if ($mysteryData["req_class"] == "elf") {
    echo "<option value=\"elf\" selected=\"selected\">Elf</option>";
} else {
    echo "<option value=\"elf\">Elf</option>";
}
if ($mysteryData["req_class"] == "summoner") {
    echo "<option value=\"summoner\" selected=\"selected\">Summoner</option>";
} else {
    echo "<option value=\"summoner\">Summoner</option>";
}
if ($mysteryData["req_class"] == "gladiator") {
    echo "<option value=\"gladiator\" selected=\"selected\">Gladiator</option>";
} else {
    echo "<option value=\"gladiator\">Gladiator</option>";
}
if ($mysteryData["req_class"] == "lord") {
    echo "<option value=\"lord\" selected=\"selected\">Lord</option>";
} else {
    echo "<option value=\"lord\">Lord</option>";
}
if ($mysteryData["req_class"] == "fighter") {
    echo "<option value=\"fighter\" selected=\"selected\">Fighter</option>";
} else {
    echo "<option value=\"fighter\">Fighter</option>";
}
if (100 <= config("server_files_season", true)) {
    if ($mysteryData["req_class"] == "lancer") {
        echo "<option value=\"lancer\" selected=\"selected\">Lancer</option>";
    } else {
        echo "<option value=\"lancer\">Lancer</option>";
    }
}
if (140 <= config("server_files_season", true)) {
    if ($mysteryData["req_class"] == "rune") {
        echo "<option value=\"rune\" selected=\"selected\">Rune</option>";
    } else {
        echo "<option value=\"rune\">Rune</option>";
    }
}
if (150 <= config("server_files_season", true)) {
    if ($mysteryData["req_class"] == "slayer") {
        echo "<option value=\"slayer\" selected=\"selected\">Slayer</option>";
    } else {
        echo "<option value=\"slayer\">Slayer</option>";
    }
}
echo "                </select>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Payment type<br/><span>Currently not used</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_3\" value=\"";
echo $mysteryData["payment_type"];
echo "\" readonly=\"readonly\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Is on Sale<br/><span>0 - no, values 1-99 - yes | For example, if this config will be 25, item price will be lowered by 25%</span>\r\n            </th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_4\" value=\"";
echo $mysteryData["on_sale"];
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Store Count<br/><span>How many mystery boxes will be available for sale (-1 unlimited)</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_8\" value=\"";
echo $mysteryData["store_count"];
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Image<br/><span>Location: /templates/assets/items/ | Value example: box_of_kundun5.jpg</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_5\" value=\"";
echo $mysteryData["image"];
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Description<br/><span>Item Description</span></th>\r\n            <td>\r\n                <textarea name=\"setting_6\" id=\"description\">";
echo $mysteryData["description"];
echo "</textarea>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Items<br/><span>Enter hex code of items (maximum 50 items)</span></th>\r\n            <td>\r\n                ";
$id = 0;
foreach ($mysteryItems as $thisItem) {
    echo "<table width=\"100%\"><tr><td>Item " . ($id + 1) . ":</td><td><input type=\"text\" class=\"form-control\" style=\"display:inline;width:100%;\" maxlength=\"64\" size=\"80\" name=\"item" . $id . "\" value=\"" . $thisItem["item_hex"] . "\"></td></tr>\r\n                    <tr><td>Chance " . ($id + 1) . ":</td><td><input type=\"text\" class=\"form-control\" style=\"width:100%; float:right;\" maxlength=\"10\" name=\"chance" . $id . "\" value=\"" . $thisItem["chance"] . "\" /></td></tr></table><hr>";
    $id++;
}
echo "                <div id=newItem></div>\r\n                <script type=\"text/javascript\">\r\n                    var iid = ";
echo $id;
echo ";\r\n\r\n                    function popitup(url) {\r\n                        newwindow = window.open(url, 'name', 'height = 550, width = 600');\r\n                        if (window.focus) {\r\n                            newwindow.focus()\r\n                        }\r\n                        return false;\r\n                    }\r\n\r\n                    function addItem() {\r\n                        var newItem = \$('#newItem');\r\n                        var html = '<table width=\"100%\"><tr><td>Item ' + (iid + 1) + ':</td><td><input type=\"text\" class=\"form-control\" style=\"width:100%; float:right;\" maxlength=\"64\" size=\"80\" name=\"item' + iid + '\" value=\"";
echo __ITEM_EMPTY__;
echo "\" /></td></tr>' +\r\n                            '<tr><td>Chance ' + (iid + 1) + ':</td><td><input type=\"text\" class=\"form-control\" style=\"width:100%; float:right;\" maxlength=\"10\" name=\"chance' + iid + '\" value=\"1\" /></td></tr></table><hr>';\r\n                        newItem.append(html);\r\n                        iid = iid + 1;\r\n                    }\r\n                </script>\r\n                <input type=\"button\" value=\"Add new\" class=\"btn btn-primary\" onClick=\"addItem();\">\r\n                <input class=\"btn btn-primary\" type=\"button\" onClick=\"popitup('item_hex_generator.php')\" value=\"Item Code Generator\" title=\"Item Code Generator\">\r\n            </td>\r\n        </tr>\r\n    </table>\r\n    <button type=\"submit\" class=\"btn btn-large btn-block btn-success\" name=\"edit_mystery\" value=\"ok\">Edit Mystery Box</button>\r\n</form>\r\n\r\n<script src=\"";
echo __BASE_URL__;
echo "admincp/ckeditor/ckeditor.js\"></script>\r\n<script type=\"text/javascript\">//<![CDATA[\r\n    //CKEDITOR.replace('editor1');\r\n    CKEDITOR.replace('description', {\r\n        language: 'en',\r\n        uiColor: '#f1f1f1'\r\n    });\r\n    //]]></script>";

?>