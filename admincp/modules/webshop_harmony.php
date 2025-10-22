<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h1 class=\"page-header\">Harmony Manager</h1>\r\n";
$Webshop = new Webshop();
if (check_value($_REQUEST["disable"])) {
    $deleteItem = $Webshop->disableHarmony($_REQUEST["disable"]);
    if ($deleteItem) {
        message("success", "Harmony was successfully disabled.");
    } else {
        message("error", "Invalid harmony ID.");
    }
}
if (check_value($_REQUEST["enable"])) {
    $deleteItem = $Webshop->enableHarmony($_REQUEST["enable"]);
    if ($deleteItem) {
        message("success", "Harmony was successfully enabled.");
    } else {
        message("error", "Invalid harmony ID.");
    }
}
echo "\r\n  <form method=\"post\" action=\"\">\r\n    <table width=\"100%\">\r\n      <tr>\r\n        <td></td>\r\n        <td align=\"right\">\r\n          Filter:\r\n          <select name=\"filter\">\r\n            <option value=\"none\" selected disabled>Select Category</option>\r\n            <option value=\"1\">Melee Options (Swords, etc.)</option>\r\n            <option value=\"2\">Ranged Options (Staffs, Sticks)</option>\r\n            <option value=\"3\">Defense Options (Sets, Shields)</option>\r\n          </select>\r\n          &nbsp;<input type=\"submit\" name=\"submit\" value=\"Show\" class=\"btn btn-info\">\r\n        </td>\r\n      </tr>\r\n    </table>\r\n  </form>\r\n  ";
if (check_value($_POST["submit"])) {
    $filter_cat = htmlspecialchars($_POST["filter"]);
    $items_list = $Webshop->retrieveHarmony($filter_cat);
    if (is_array($items_list)) {
        echo "<table class=\"table table-hover table-striped\"><thead><tr><th>#</th><th>NAME</th><th>PRICE</th><th>ACTION</th></tr></thead><tbody>";
        $i = 1;
        foreach ($items_list as $thisItem) {
            echo "<tr>";
            echo "<td>" . $i . "</td>";
            echo "<td>" . $thisItem["hname"] . "</td>";
            echo "<td>" . $thisItem["price"] . "</td>";
            echo "<td>";
            echo "<a class=\"btn btn-default btn-sm\" href=\"" . admincp_base("webshop_harmony_edit&id=" . $thisItem["id"]) . "\"><i class=\"fa fa-edit\"></i> edit</a> ";
            if ($thisItem["status"] == 0) {
                echo "<a class=\"btn btn-success btn-sm\" href=\"" . admincp_base("webshop_harmony&enable=" . $thisItem["id"]) . "\"><i class=\"fa fa-check-circle\"></i> enable</a>";
            } else {
                echo "<a class=\"btn btn-danger btn-sm\" href=\"" . admincp_base("webshop_harmony&disable=" . $thisItem["id"]) . "\"><i class=\"fa fa-times-circle\"></i> disable</a>";
            }
            echo "</td></tr>";
            $i++;
        }
        echo "</tbody></table>";
    }
} else {
    $items_list = $Webshop->retrieveHarmony();
    if (is_array($items_list)) {
        echo "<table class=\"table table-hover table-striped\"><thead><tr><th>#</th><th>NAME</th><th>PRICE</th><th>ACTION</th></tr></thead><tbody>";
        $i = 1;
        foreach ($items_list as $thisItem) {
            echo "<tr>";
            echo "<td>" . $i . "</td>";
            echo "<td>" . $thisItem["hname"] . "</td>";
            echo "<td>" . $thisItem["price"] . "</td>";
            echo "<td>";
            echo "<a class=\"btn btn-default btn-sm\" href=\"" . admincp_base("webshop_harmony_edit&id=" . $thisItem["id"]) . "\"><i class=\"fa fa-edit\"></i> edit</a> ";
            if ($thisItem["status"] == 0) {
                echo "<a class=\"btn btn-success btn-sm\" href=\"" . admincp_base("webshop_harmony&enable=" . $thisItem["id"]) . "\"><i class=\"fa fa-check-circle\"></i> enable</a>";
            } else {
                echo "<a class=\"btn btn-danger btn-sm\" href=\"" . admincp_base("webshop_harmony&disable=" . $thisItem["id"]) . "\"><i class=\"fa fa-times-circle\"></i> disable</a>";
            }
            echo "</td></tr>";
            $i++;
        }
        echo "</tbody></table>";
    }
}

?>