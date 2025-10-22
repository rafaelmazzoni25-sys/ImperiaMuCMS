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
echo "\r\n  <form method=\"post\" action=\"\">\r\n    <table width=\"100%\">\r\n      <tr>\r\n        <td><a class=\"btn btn-success\" href=\"" . admincp_base("webshop_old_items_add") . "\">ADD NEW ITEM</a></td>\r\n        <td align=\"right\">\r\n          Filter:\r\n          <select name=\"filter\" class=\"form-control\" style=\"display: inline; width: 250px;\">\r\n            <option value=\"none\" selected disabled>Select Category</option>\r\n            <option value=\"0\">Swords</option>\r\n            <option value=\"1\">Axes</option>\r\n            <option value=\"2\">Maces & Scepters</option>\r\n            <option value=\"3\">Spears</option>\r\n            <option value=\"4\">Bows & Crossbows</option>\r\n            <option value=\"5\">Staffs</option>\r\n            <option value=\"6\">Shields</option>\r\n            <option value=\"7\">Helms</option>\r\n            <option value=\"8\">Armors</option>\r\n            <option value=\"9\">Pants</option>\r\n            <option value=\"10\">Gloves</option>\r\n            <option value=\"11\">Boots</option>\r\n            <option value=\"12\">Wings lvl 1</option>\r\n            <option value=\"13\">Wings lvl 2</option>\r\n            <option value=\"31\">Wings lvl 2.5</option>\r\n            <option value=\"14\">Wings lvl 3</option>\r\n            <option value=\"32\">Wings lvl 4</option>\r\n            <option value=\"16\">Rings</option>\r\n            <option value=\"17\">Pendants</option>\r\n            <option value=\"18\">Fenrirs</option>\r\n            <option value=\"19\">Pets</option>\r\n            <option value=\"21\">Jewels</option>\r\n            <option value=\"22\">Seeds & Spheres</option>\r\n            <option value=\"23\">Elemental Items</option>\r\n            <option value=\"24\">Skills & Spells</option>\r\n            <option value=\"25\">Boxes</option>\r\n            <option value=\"26\">Tickets</option>\r\n            <option value=\"27\">Chaos Cards</option>\r\n            <option value=\"28\">Keys</option>\r\n            <option value=\"30\">Special Items</option>\r\n          </select>\r\n          &nbsp;<input type=\"submit\" name=\"submit\" value=\"Show\" class=\"btn btn-info\">\r\n        </td>\r\n      </tr>\r\n    </table>\r\n  </form>\r\n  ";
if (check_value($_POST["submit"])) {
    $filter_cat = htmlspecialchars($_POST["filter"]);
    $items_list = $Webshop->retrieveItems($filter_cat);
    if (is_array($items_list)) {
        echo "<table class=\"table table-hover table-striped\"><thead><tr><th>ID</th><th>NAME</th><th>CATEGORY</th><th>INDEX</th><th>ACTION</th></tr></thead><tbody>";
        foreach ($items_list as $thisItem) {
            echo "<tr>";
            echo "<td>" . $thisItem["id"] . "</td>";
            echo "<td>" . $thisItem["name"] . "</td>";
            echo "<td>" . $thisItem["item_cat"] . "</td>";
            echo "<td>" . $thisItem["item_id"] . "</td>";
            echo "<td>";
            echo "<a class=\"btn btn-default btn-sm\" href=\"" . admincp_base("webshop_old_items_edit&id=" . $thisItem["id"]) . "\"><i class=\"fa fa-edit\"></i> edit</a> ";
            echo "<a class=\"btn btn-danger btn-sm\" href=\"" . admincp_base("webshop_old_items&delete=" . $thisItem["id"]) . "\"><i class=\"fa fa-trash\"></i> delete</a>";
            echo "</td></tr>";
        }
        echo "</tbody></table>";
    }
} else {
    $items_list = $Webshop->retrieveItems();
    if (is_array($items_list)) {
        echo "<table class=\"table table-hover table-striped\"><thead><tr><th>ID</th><th>NAME</th><th>CATEGORY</th><th>INDEX</th><th>ACTION</th></tr></thead><tbody>";
        foreach ($items_list as $thisItem) {
            echo "<tr>";
            echo "<td>" . $thisItem["id"] . "</td>";
            echo "<td>" . $thisItem["name"] . "</td>";
            echo "<td>" . $thisItem["item_cat"] . "</td>";
            echo "<td>" . $thisItem["item_id"] . "</td>";
            echo "<td>";
            echo "<a class=\"btn btn-default btn-sm\" href=\"" . admincp_base("webshop_old_items_edit&id=" . $thisItem["id"]) . "\"><i class=\"fa fa-edit\"></i> edit</a> ";
            echo "<a class=\"btn btn-danger btn-sm\" href=\"" . admincp_base("webshop_old_items&delete=" . $thisItem["id"]) . "\"><i class=\"fa fa-trash\"></i> delete</a>";
            echo "</td></tr>";
        }
        echo "</tbody></table>";
    }
}

?>