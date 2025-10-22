<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h1 class=\"page-header\">Edit Item in Cash Shop</h1>\r\n\r\n";
if (check_value($_GET["id"])) {
    $CashShop = new CashShop();
    if (check_value($_POST["submit_changes"])) {
        if (check_value($_POST["name"]) && check_value($_POST["UniqueID1"]) && check_value($_POST["UniqueID2"]) && check_value($_POST["UniqueID3"]) && check_value($_POST["can_gift"]) && check_value($_POST["price"]) && check_value($_POST["price_type"]) && check_value($_POST["position"]) && check_value($_POST["cat"]) && check_value($_POST["subcat"])) {
            $CashShop->editItem($_GET["id"], $_POST["name"], $_POST["UniqueID1"], $_POST["UniqueID2"], $_POST["UniqueID3"], $_POST["can_gift"], $_POST["price"], $_POST["price_type"], $_POST["position"], $_POST["cat"], $_POST["subcat"], $_POST["img"], $_POST["desc"]);
        } else {
            message("error", "Some fields are empty.");
        }
    }
    $itemData = $CashShop->loadItemData($_GET["id"]);
    $cats = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_CASHSHOP_CATEGORIES ORDER BY title");
    $subcats = [];
    $options = "<option value=\"\">-- None --</option>";
    $subcat_opt = "<option value=\"\">-- None --</option>";
    if (isset($cats) && !empty($cats)) {
        foreach ($cats as $cat) {
            if ($itemData["category_id"] == $cat["id"]) {
                $options .= "<option value=\"" . $cat["id"] . "\" selected=\"selected\">" . $cat["title"] . "</option>";
            } else {
                $options .= "<option value=\"" . $cat["id"] . "\">" . $cat["title"] . "</option>";
            }
            $dbdata = $dB->query_fetch("SELECT id, title, category_id FROM IMPERIAMUCMS_CASHSHOP_SUBCATEGORIES WHERE category_id = ? ORDER BY title", [$cat["id"]]);
            $subcats[$cat["id"]] = [];
            foreach ($dbdata as $s) {
                if ($itemData["category_id"] == $s["category_id"]) {
                    if ($itemData["subcategory_id"] == $s["id"]) {
                        $subcat_opt .= "<option value=\"" . $s["id"] . "\" selected=\"selected\">" . $s["title"] . "</option>";
                    } else {
                        $subcat_opt .= "<option value=\"" . $s["id"] . "\">" . $s["title"] . "</option>";
                    }
                }
                $subcats[$cat["id"]][] = ["id" => $s["id"], "title" => $s["title"]];
            }
        }
    }
    echo "\r\n    <form role=\"form\" method=\"post\">\r\n        <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n            <tr>\r\n                <th>Name<br/><span>Item Name will be used as a title of item in Cash Shop module.</span></th>\r\n                <td>\r\n                    <input type=\"text\" class=\"form-control\" id=\"name\" name=\"name\" value=\"";
    echo $itemData["name"];
    echo "\" placeholder=\"Item's Name\" maxlength=\"255\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>UniqueID1<br/><span>Value must refer to existing item in Cash Shop. Use \"0\" if not applied.</span></th>\r\n                <td>\r\n                    <input type=\"text\" class=\"form-control\" id=\"UniqueID1\" name=\"UniqueID1\" value=\"";
    echo $itemData["UniqueID1"];
    echo "\" placeholder=\"UniqueID1\" maxlength=\"5\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>UniqueID2<br/><span>Value must refer to existing item in Cash Shop. Use \"0\" if not applied.</span></th>\r\n                <td>\r\n                    <input type=\"text\" class=\"form-control\" id=\"UniqueID2\" name=\"UniqueID2\" value=\"";
    echo $itemData["UniqueID2"];
    echo "\" placeholder=\"UniqueID2\" maxlength=\"5\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>UniqueID3<br/><span>Value must refer to existing item in Cash Shop. Use \"0\" if not applied.</span></th>\r\n                <td>\r\n                    <input type=\"text\" class=\"form-control\" id=\"UniqueID3\" name=\"UniqueID3\" value=\"";
    echo $itemData["UniqueID3"];
    echo "\" placeholder=\"UniqueID3\" maxlength=\"5\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Inventory Type<br/><span>Value must depends on item's type.</span></th>\r\n                <td>\r\n                    <select name=\"invtype\" class=\"form-control\" id=\"invtype\">\r\n                        ";
    if ($itemData["InventoryType"] == "1") {
        echo "<option value=\"1\" selected=\"selected\">Normal Inventory</option>";
    } else {
        echo "<option value=\"1\">Normal Inventory</option>";
    }
    if ($itemData["InventoryType"] == "2") {
        echo "<option value=\"2\" selected=\"selected\">Gift Inventory</option>";
    } else {
        echo "<option value=\"2\">Gift Inventory</option>";
    }
    echo "                    </select>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Price<br/><span>Choose price and price type of the item.</span></th>\r\n                <td>\r\n                    <table width=\"100%\">\r\n                        <tr>\r\n                            <td width=\"50%\">\r\n                                <input type=\"text\" class=\"form-control\" id=\"price\" name=\"price\" value=\"";
    echo $itemData["price"];
    echo "\" placeholder=\"Price\" maxlength=\"20\"/>\r\n                            </td>\r\n                            <td width=\"50%\">\r\n                                <select name=\"price_type\" class=\"form-control\" id=\"price_type\">\r\n                                    ";
    if ($itemData["price_type"] == "1") {
        echo "<option value=\"1\" selected=\"selected\">Platinum Coins</option>";
    } else {
        echo "<option value=\"1\">Platinum Coins</option>";
    }
    if ($itemData["price_type"] == "2") {
        echo "<option value=\"2\" selected=\"selected\">Gold Coins</option>";
    } else {
        echo "<option value=\"2\">Gold Coins</option>";
    }
    if ($itemData["price_type"] == "3") {
        echo "<option value=\"3\" selected=\"selected\">Silver Coins</option>";
    } else {
        echo "<option value=\"3\">Silver Coins</option>";
    }
    if ($itemData["price_type"] == "4") {
        echo "<option value=\"4\" selected=\"selected\">WCoinC</option>";
    } else {
        echo "<option value=\"4\">WCoinC</option>";
    }
    if ($itemData["price_type"] == "-4") {
        echo "<option value=\"-4\" selected=\"selected\">WCoinP</option>";
    } else {
        echo "<option value=\"-4\">WCoinP</option>";
    }
    if ($itemData["price_type"] == "5") {
        echo "<option value=\"5\" selected=\"selected\">Goblin Points</option>";
    } else {
        echo "<option value=\"5\">Goblin Points</option>";
    }
    if ($itemData["price_type"] == "6") {
        echo "<option value=\"6\" selected=\"selected\">Zen</option>";
    } else {
        echo "<option value=\"6\">Zen</option>";
    }
    echo "                                </select>\r\n                            </td>\r\n                        </tr>\r\n                    </table>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Image<br/><span>As a value use file name. Image must be located in templates/your_template/img/items/ folder.</span></th>\r\n                <td>\r\n                    <input type=\"text\" class=\"form-control\" id=\"img\" name=\"img\" value=\"";
    echo $itemData["img"];
    echo "\" placeholder=\"Image\" maxlength=\"255\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Description<br/><span>You can write some description of the item, for example expiration time and/or item's attributes.</span></th>\r\n                <td>\r\n                    <textarea class=\"form-control\" id=\"desc\" name=\"desc\" placeholder=\"Description\" maxlength=\"1024\">";
    echo $itemData["description"];
    echo "</textarea>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Position<br/><span>Items are ordered by position.</span></th>\r\n                <td>\r\n                    <input type=\"text\" class=\"form-control\" id=\"position\" name=\"position\" value=\"";
    echo $itemData["position"];
    echo "\" placeholder=\"Position\" maxlength=\"10\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Category<br/><span>Select category where will be item displayed.</span></th>\r\n                <td>\r\n                    <select name=\"cat\" class=\"form-control\" id=\"categories\">\r\n                        ";
    echo $options;
    echo "                    </select>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Subcategory<br/><span>Select subcategory where will be item displayed.</span></th>\r\n                <td>\r\n                    <select name=\"subcat\" class=\"form-control\" id=\"subcategories\">\r\n                        ";
    echo $subcat_opt;
    echo "                    </select>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Can be gifted?<br/><span>If \"Yes\", item can be gifted to other player.</span></th>\r\n                <td>\r\n                    ";
    enabledisableCheckboxes("can_gift", $itemData["can_gift"], "Yes", "No");
    echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <td colspan=\"2\"><input type=\"submit\" name=\"submit_changes\" value=\"Edit Item\" class=\"btn btn-success\"/></td>\r\n            </tr>\r\n        </table>\r\n    </form>\r\n\r\n    <script type=\"text/javascript\">\r\n        ";
    echo "var subcat = " . json_encode($subcats) . ";";
    echo "        \$('#categories').change(function () {\r\n            var catid = \$(this).val();\r\n            var s = \$('#subcategories');\r\n            s.empty();\r\n            s.append('<option value=\"\">-- None --</option>');\r\n            if (catid != '') {\r\n                for (var i = 0; i < subcat[catid].length; i++) {\r\n                    s.append('<option value=\"' + subcat[catid][i].id + '\">' + subcat[catid][i].title + '</option>');\r\n                }\r\n            }\r\n        });\r\n    </script>\r\n    ";
} else {
    message("error", "Invalid request.");
}

?>