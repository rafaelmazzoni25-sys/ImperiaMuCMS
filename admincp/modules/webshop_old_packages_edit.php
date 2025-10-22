<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h1 class=\"page-header\">Edit Package</h1>\r\n\r\n";
$Webshop = new Webshop();
if (check_value($_POST["edit_package"])) {
    $Webshop->editPackage($_REQUEST["id"], $_POST["setting_1"], $_POST["setting_2"], $_POST["setting_3"], $_POST["setting_4"], $_POST["setting_5"], $_POST["setting_6"], $_POST["setting_7"], $_POST["setting_8"]);
    $delete = $dB->query("DELETE FROM IMPERIAMUCMS_WEBSHOP_PACKAGES_ITEMS WHERE package_id = ?", [$_REQUEST["id"]]);
    $i = 0;
    while ($i < 50) {
        $index = "item" . $i;
        if (!($_POST[$index] == NULL || $_POST[$index] == __ITEM_EMPTY__)) {
            $Webshop->addPackageItem($_REQUEST["id"], $_POST[$index]);
        }
        $i++;
    }
}
$packageData = $Webshop->getPackageData($_REQUEST["id"]);
$packageItems = $Webshop->getPackageItems($_REQUEST["id"]);
echo "<form role=\"form\" method=\"post\">\r\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n        <tr>\r\n            <th>Status<br/><span>Enable/disable package.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_7", $packageData["status"], "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Name<br/><span>Package Name</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_1\" value=\"";
echo $packageData["name"];
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Price<br/><span>Price</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_2\" value=\"";
echo $packageData["price"];
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Payment type<br/><span>1 - Platinum Coins, 2 - Gold Coins, 4 - Silver Coins (you can use combinations of values, for example:<br>\r\n          3 = Platinum & Gold Coins, 5 = Platinum & Silver Coins, 7 = All)</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_3\" value=\"";
echo $packageData["payment_type"];
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Is on Sale<br/><span>0 - no, values 1-99 - yes | For example, if this config will be 25, item price will be lowered by 25%</span>\r\n            </th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_4\" value=\"";
echo $packageData["on_sale"];
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Store Count<br/><span>How many packages will be available for sale (-1 unlimited)</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_8\" value=\"";
echo $packageData["store_count"];
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Image<br/><span>Location: /templates/assets/items/ | Value example: box_of_kundun5.jpg</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_5\" value=\"";
echo $packageData["image"];
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Description<br/><span>Item Description</span></th>\r\n            <td>\r\n                <textarea name=\"setting_6\" id=\"description\">";
echo $packageData["description"];
echo "</textarea>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Items<br/><span>Enter hex code of items (maximum 50 items)</span></th>\r\n            <td>\r\n                ";
$id = 0;
foreach ($packageItems as $thisItem) {
    echo "Item " . ($id + 1) . ": <input type=text class=form-control style=display:inline;width:90%; maxlength=64 size=80 name=item" . $id . " value=\"" . $thisItem["item_hex"] . "\"><hr>";
    $id++;
}
echo "                <div id=newItem></div>\r\n                <script type=\"text/javascript\">\r\n                    var iid = ";
echo $id;
echo ";\r\n\r\n                    function popitup(url) {\r\n                        newwindow = window.open(url, 'name', 'height = 550, width = 600');\r\n                        if (window.focus) {\r\n                            newwindow.focus()\r\n                        }\r\n                        return false;\r\n                    }\r\n\r\n                    function addItem() {\r\n                        var newItem = \$('#newItem');\r\n                        var html = 'Item ' + (iid + 1) + ': <input type=\"text\" class=\"form-control\" style=\"display:inline; width:90%;\" maxlength=\"64\" size=\"80\" name=\"item' + iid + '\" value=\"";
echo __ITEM_EMPTY__;
echo "\" /><hr>';\r\n                        newItem.append(html);\r\n                        iid = iid + 1;\r\n                    }\r\n                </script>\r\n                <input type=\"button\" value=\"Add new\" class=\"btn btn-primary\" onClick=\"addItem();\">\r\n                <input class=\"btn btn-primary\" type=\"button\" onClick=\"popitup('item_hex_generator.php')\" value=\"Item Code Generator\" title=\"Item Code Generator\">\r\n            </td>\r\n        </tr>\r\n    </table>\r\n    <button type=\"submit\" class=\"btn btn-large btn-block btn-success\" name=\"edit_package\" value=\"ok\">Edit Package</button>\r\n</form>\r\n\r\n<script src=\"";
echo __BASE_URL__;
echo "admincp/ckeditor/ckeditor.js\"></script>\r\n<script type=\"text/javascript\">//<![CDATA[\r\n    //CKEDITOR.replace('editor1');\r\n    CKEDITOR.replace('description', {\r\n        language: 'en',\r\n        uiColor: '#f1f1f1'\r\n    });\r\n    //]]>\r\n</script>";

?>