<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h1 class=\"page-header\">Mystery Boxes Manager</h1>\r\n";
$Webshop = new Webshop();
if (check_value($_REQUEST["disable"])) {
    $deleteItem = $Webshop->disableMystery($_REQUEST["disable"]);
    if ($deleteItem) {
        message("success", "Mystery Box was successfully disabled.");
    } else {
        message("error", "Invalid mystery box ID.");
    }
}
if (check_value($_REQUEST["enable"])) {
    $deleteItem = $Webshop->enableMystery($_REQUEST["enable"]);
    if ($deleteItem) {
        message("success", "Mystery Box was successfully enabled.");
    } else {
        message("error", "Invalid mystery box ID.");
    }
}
echo "\r\n  <form method=\"post\" action=\"\">\r\n    <table width=\"100%\">\r\n      <tr>\r\n        <td><a class=\"btn btn-success\" href=\"" . admincp_base("webshop_mystery_add") . "\">ADD NEW MYSTERY BOX</a></td>\r\n        <td align=\"right\"></td>\r\n      </tr>\r\n    </table>\r\n  </form>\r\n  ";
$items_list = $Webshop->getMysteryAdmin();
if (is_array($items_list)) {
    echo "<table class=\"table table-hover table-striped\"><thead><tr><th>ID</th><th>NAME</th><th>PRICE</th><th>ACTION</th></tr></thead><tbody>";
    foreach ($items_list as $thisItem) {
        echo "<tr>";
        echo "<td>" . $thisItem["id"] . "</td>";
        echo "<td>" . $thisItem["name"] . "</td>";
        echo "<td>" . $thisItem["price"] . "</td>";
        echo "<td>";
        echo "<a class=\"btn btn-default btn-sm\" href=\"" . admincp_base("webshop_mystery_edit&id=" . $thisItem["id"]) . "\"><i class=\"fa fa-edit\"></i> edit</a> ";
        if ($thisItem["status"] == 0) {
            echo "<a class=\"btn btn-success btn-sm\" href=\"" . admincp_base("webshop_mystery&enable=" . $thisItem["id"]) . "\"><i class=\"fa fa-check-circle\"></i> enable</a>";
        } else {
            echo "<a class=\"btn btn-danger btn-sm\" href=\"" . admincp_base("webshop_mystery&disable=" . $thisItem["id"]) . "\"><i class=\"fa fa-times-circle\"></i> disable</a>";
        }
        echo "</td></tr>";
    }
    echo "</tbody></table>";
}

?>