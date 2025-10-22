<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h1 class=\"page-header\">Items Manager</h1>\r\n";
$Webshop = new Webshop();
if (check_value($_REQUEST["delete"])) {
    $deleteItem = $Webshop->removeItem($_REQUEST["delete"]);
    if ($deleteItem) {
        message("success", "Item was successfully deleted.");
    } else {
        message("error", "Invalid item ID.");
    }
}
echo "\r\n<form method=\"post\" action=\"\">\r\n    <table width=\"100%\">\r\n        <tr>\r\n            <td>\r\n                <a class=\"btn btn-success\" href=\"" . admincp_base("webshop_items_add") . "\">ADD NEW ITEM</a>\r\n            </td>\r\n            <td align=\"right\">\r\n                Filter:\r\n                <select name=\"filter\" class=\"form-control\" style=\"display: inline; width: 250px;\">\r\n                    <option value=\"none\" selected disabled>Select Category</option>\r\n                    <option value=\"0\">Swords</option>\r\n                    <option value=\"1\">Axes</option>\r\n                    <option value=\"2\">Maces & Scepters</option>\r\n                    <option value=\"3\">Spears</option>\r\n                    <option value=\"4\">Bows & Crossbows</option>\r\n                    <option value=\"5\">Staffs</option>\r\n                    <option value=\"6\">Shields</option>\r\n                    <option value=\"7\">Helms</option>\r\n                    <option value=\"8\">Armors</option>\r\n                    <option value=\"9\">Pants</option>\r\n                    <option value=\"10\">Gloves</option>\r\n                    <option value=\"11\">Boots</option>\r\n                    <option value=\"12\">Wings</option>\r\n                    <option value=\"20\">Rings, Pendants & Earrings</option>\r\n                    <option value=\"30\">Pentagrams</option>\r\n                    <option value=\"40\">Pets</option>\r\n                </select>\r\n                <input type=\"submit\" name=\"submit\" value=\"Show\" class=\"btn btn-info\">\r\n            </td>\r\n        </tr>\r\n    </table>\r\n</form>";
if (check_value($_POST["submit"])) {
    $filter_cat = htmlspecialchars($_POST["filter"]);
    $items_list = loadwebshopitems($filter_cat);
    if (is_array($items_list)) {
        echo "<table class=\"table table-hover table-striped\"><thead><tr><th>ID</th><th>NAME</th><th>CATEGORY</th><th>INDEX</th><th>PRICE</th><th>ACTION</th></tr></thead><tbody>";
        foreach ($items_list as $thisItem) {
            echo "<tr>";
            echo "<td>" . $thisItem["id"] . "</td>";
            echo "<td>" . $thisItem["name"] . "</td>";
            echo "<td>" . $thisItem["item_cat"] . "</td>";
            echo "<td>" . $thisItem["item_id"] . "</td>";
            echo "<td>" . $thisItem["price"] . "</td>";
            echo "<td>";
            echo "<a class=\"btn btn-default btn-sm\" href=\"" . admincp_base("webshop_items_edit&id=" . $thisItem["id"]) . "\"><i class=\"fa fa-edit\"></i> edit</a> ";
            echo "<a class=\"btn btn-danger btn-sm\" href=\"" . admincp_base("webshop_items&delete=" . $thisItem["id"]) . "\"><i class=\"fa fa-trash\"></i> delete</a>";
            echo "</td></tr>";
        }
        echo "</tbody></table>";
    }
} else {
    $items_list = loadwebshopitems(NULL);
    if (is_array($items_list)) {
        echo "<table class=\"table table-hover table-striped\"><thead><tr><th>ID</th><th>NAME</th><th>CATEGORY</th><th>INDEX</th><th>PRICE</th><th>ACTION</th></tr></thead><tbody>";
        foreach ($items_list as $thisItem) {
            echo "<tr>";
            echo "<td>" . $thisItem["id"] . "</td>";
            echo "<td>" . $thisItem["name"] . "</td>";
            echo "<td>" . $thisItem["item_cat"] . "</td>";
            echo "<td>" . $thisItem["item_id"] . "</td>";
            echo "<td>" . $thisItem["price"] . "</td>";
            echo "<td>";
            echo "<a class=\"btn btn-default btn-sm\" href=\"" . admincp_base("webshop_items_edit&id=" . $thisItem["id"]) . "\"><i class=\"fa fa-edit\"></i> edit</a> ";
            echo "<a class=\"btn btn-danger btn-sm\" href=\"" . admincp_base("webshop_items&delete=" . $thisItem["id"]) . "\"><i class=\"fa fa-trash\"></i> delete</a>";
            echo "</td></tr>";
        }
        echo "</tbody></table>";
    }
}
function loadWebshopItems($cat)
{
    global $dB;
    if ($cat != NULL) {
        return $dB->query_fetch("\r\n            SELECT id, name, price, image, item_cat, item_id, item_lvl, item_exc\r\n            FROM IMPERIAMUCMS_WEBSHOP_ITEMS wi\r\n            WHERE main_cat = ?\r\n            ORDER BY item_cat, item_id\r\n        ", [$cat]);
    }
    return $dB->query_fetch("\r\n            SELECT id, name, price, image, item_cat, item_id, item_lvl, item_exc\r\n            FROM IMPERIAMUCMS_WEBSHOP_ITEMS wi\r\n            ORDER BY item_cat, item_id\r\n        ");
}

?>