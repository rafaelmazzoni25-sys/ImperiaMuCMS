<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h1 class=\"page-header\">Socket Manager</h1>\r\n";
$Webshop = new Webshop();
if (check_value($_REQUEST["disable"])) {
    $deleteItem = $Webshop->disableSocket($_REQUEST["disable"]);
    if ($deleteItem) {
        message("success", "Socket was successfully disabled.");
    } else {
        message("error", "Invalid socket ID.");
    }
}
if (check_value($_REQUEST["enable"])) {
    $deleteItem = $Webshop->enableSocket($_REQUEST["enable"]);
    if ($deleteItem) {
        message("success", "Socket was successfully enabled.");
    } else {
        message("error", "Invalid socket ID.");
    }
}
echo "\r\n  <form method=\"post\" action=\"\">\r\n    <table width=\"100%\">\r\n      <tr>\r\n        <td></td>\r\n        <td align=\"right\">\r\n          Filter:\r\n          <select name=\"filter\" class=\"form-control\" style=\"display: inline; max-width: 200px;\">\r\n            <option value=\"none\" selected disabled>Select Category</option>\r\n            <option value=\"0\">Empty</option>\r\n            <option value=\"5\">Lightning</option>\r\n            <option value=\"3\">Ice</option>\r\n            <option value=\"1\">Fire</option>\r\n            <option value=\"2\">Water</option>\r\n            <option value=\"4\">Wind</option>\r\n            <option value=\"6\">Earth</option>\r\n            <option value=\"-1\">Bonus</option>\r\n          </select>\r\n          &nbsp;<input type=\"submit\" name=\"submit\" value=\"Show\" class=\"btn btn-info\">\r\n        </td>\r\n      </tr>\r\n    </table>\r\n  </form>\r\n  ";
if (check_value($_POST["submit"])) {
    $filter_cat = htmlspecialchars($_POST["filter"]);
    $items_list = $Webshop->retrieveSockets($filter_cat);
    if (is_array($items_list)) {
        echo "<table class=\"table table-hover table-striped\"><thead><tr><th>#</th><th>NAME</th><th>PRICE</th><th>ACTION</th></tr></thead><tbody>";
        $i = 1;
        foreach ($items_list as $thisItem) {
            echo "<tr>";
            echo "<td>" . $i . "</td>";
            echo "<td>" . $thisItem["socket_name"] . "</td>";
            echo "<td>" . $thisItem["price"] . "</td>";
            echo "<td>";
            echo "<a class=\"btn btn-default btn-sm\" href=\"" . admincp_base("webshop_sockets_edit&id=" . $thisItem["id"]) . "\"><i class=\"fa fa-edit\"></i> Edit</a> ";
            if ($thisItem["active"] == 0) {
                echo "<a class=\"btn btn-success btn-sm\" href=\"" . admincp_base("webshop_sockets&enable=" . $thisItem["id"]) . "\"><i class=\"fa fa-check-circle\"></i> Enable</a>";
            } else {
                echo "<a class=\"btn btn-danger btn-sm\" href=\"" . admincp_base("webshop_sockets&disable=" . $thisItem["id"]) . "\"><i class=\"fa fa-times-circle\"></i> Disable</a>";
            }
            echo "</td></tr>";
            $i++;
        }
        echo "</tbody></table>";
    }
} else {
    $items_list = $Webshop->retrieveSockets();
    if (is_array($items_list)) {
        echo "<table class=\"table table-hover table-striped\"><thead><tr><th>#</th><th>NAME</th><th>PRICE</th><th>ACTION</th></tr></thead><tbody>";
        $i = 1;
        foreach ($items_list as $thisItem) {
            echo "<tr>";
            echo "<td>" . $i . "</td>";
            echo "<td>" . $thisItem["socket_name"] . "</td>";
            echo "<td>" . $thisItem["price"] . "</td>";
            echo "<td>";
            echo "<a class=\"btn btn-default btn-sm\" href=\"" . admincp_base("webshop_sockets_edit&id=" . $thisItem["id"]) . "\"><i class=\"fa fa-edit\"></i> Edit</a> ";
            if ($thisItem["active"] == 0) {
                echo "<a class=\"btn btn-success btn-sm\" href=\"" . admincp_base("webshop_sockets&enable=" . $thisItem["id"]) . "\"><i class=\"fa fa-check-circle\"></i> Enable</a>";
            } else {
                echo "<a class=\"btn btn-danger btn-sm\" href=\"" . admincp_base("webshop_sockets&disable=" . $thisItem["id"]) . "\"><i class=\"fa fa-times-circle\"></i> Disable</a>";
            }
            echo "</td></tr>";
            $i++;
        }
        echo "</tbody></table>";
    }
}

?>