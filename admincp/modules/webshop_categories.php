<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */
echo "<h1 class=\"page-header\">Categories Manager</h1>\r\n";
$Webshop = new Webshop();
if (check_value($_GET["enable"])) {
    $update = $dB->query("UPDATE IMPERIAMUCMS_WEBSHOP_CATEGORY SET active = 1 WHERE id = ?", [$_GET["enable"]]);
    if ($update) {
        message("success", "Category was enabled successfully.");
    } else {
        message("error", "Category could not be enabled, please check your SQL logs for error message.");
    }
}
if (check_value($_GET["disable"])) {
    $update = $dB->query("UPDATE IMPERIAMUCMS_WEBSHOP_CATEGORY SET active = 0 WHERE id = ?", [$_GET["disable"]]);
    if ($update) {
        message("success", "Category was disabled successfully.");
    } else {
        message("error", "Category could not be disabled, please check your SQL logs for error message.");
    }
}
if (check_value($_GET["delete"])) {
    $update = $dB->query("DELETE FROM IMPERIAMUCMS_WEBSHOP_CATEGORY WHERE id = ?", [$_GET["delete"]]);
    if ($update) {
        message("success", "Category was deleted successfully.");
    } else {
        message("error", "Category could not be deleted, please check your SQL logs for error message.");
    }
}
$categories = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_WEBSHOP_CATEGORY WHERE type = 1 ORDER BY [order]");
echo "\r\n<a class=\"btn btn-success\" href=\"" . admincp_base("webshop_categories_add") . "\">ADD NEW CATEGORY</a><br /><br />\r\n<table class=\"table table-hover table-striped\">\r\n    <tr>\r\n        <th>#</th>\r\n        <th>Title</th>\r\n        <th>Status</th>\r\n        <th>Action</th>\r\n    </tr>";
$i = 1;
foreach ($categories as $thisCat) {
    $status = "";
    if ($thisCat["active"] == "1") {
        $status = "<span class=\"label label-success\">Active</span>";
        $changeStatus = "<a href=\"" . admincp_base("webshop_categories") . "&disable=" . $thisCat["id"] . "\" class=\"btn btn-warning\">Disable</a>";
    } else {
        $status = "<span class=\"label label-danger\">Inactive</span>";
        $changeStatus = "<a href=\"" . admincp_base("webshop_categories") . "&enable=" . $thisCat["id"] . "\" class=\"btn btn-success\">Enable</a>";
    }
    $actions = "\r\n    <a href=\"" . admincp_base("webshop_categories_edit") . "&id=" . $thisCat["id"] . "\" class=\"btn btn-default\">Edit</a>&nbsp;\r\n    " . $changeStatus . "";
    if ($thisCat["protected"] != "1") {
        $actions .= "&nbsp;<a href=\"" . admincp_base("webshop_categories") . "&delete=" . $thisCat["id"] . "\" onclick=\"if(confirm('Do you really want to delete this category?')) return true; else return false;\" class=\"btn btn-danger\">Delete</a>";
    }
    echo "\r\n    <tr>\r\n        <td>" . $i . "</td>\r\n        <td>" . $thisCat["title"] . "</td>\r\n        <td>" . $status . "</td>\r\n        <td>" . $actions . "</td>\r\n    </tr>";
    $i++;
    $subcategories = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_WEBSHOP_CATEGORY WHERE type = ? AND parent = ? ORDER BY [order]", [2, $thisCat["code"]]);
    if (is_array($subcategories)) {
        foreach ($subcategories as $thisSub) {
            $subStatus = "";
            if ($thisSub["active"] == "1") {
                $subStatus = "<span class=\"label label-success\">Active</span>";
                $subChangeStatus = "<a href=\"" . admincp_base("webshop_categories") . "&disable=" . $thisSub["id"] . "\" class=\"btn btn-warning\">Disable</a>";
            } else {
                $subStatus = "<span class=\"label label-danger\">Inactive</span>";
                $subChangeStatus = "<a href=\"" . admincp_base("webshop_categories") . "&enable=" . $thisSub["id"] . "\" class=\"btn btn-success\">Enable</a>";
            }
            $subActions = "\r\n            <a href=\"" . admincp_base("webshop_categories_edit") . "&id=" . $thisSub["id"] . "\" class=\"btn btn-default\">Edit</a>&nbsp;\r\n            " . $subChangeStatus . "";
            if ($thisSub["protected"] != "1") {
                $subActions .= "&nbsp;<a href=\"" . admincp_base("webshop_categories") . "&delete=" . $thisSub["id"] . "\" onclick=\"if(confirm('Do you really want to delete this sub-category?')) return true; else return false;\" class=\"btn btn-danger\">Delete</a>";
            }
            echo "\r\n    <tr>\r\n        <td></td>\r\n        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $thisSub["title"] . "</td>\r\n        <td>" . $subStatus . "</td>\r\n        <td>" . $subActions . "</td>\r\n    </tr>";
        }
    }
}
echo "\r\n</table>";

?>