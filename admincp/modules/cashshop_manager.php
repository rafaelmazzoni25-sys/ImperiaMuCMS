<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h1 class=\"page-header\">Cash Shop Manager</h1>\r\n<style>\r\n    .panel-heading a.col_link:after {\r\n        font-family: 'Glyphicons Halflings';\r\n        content: \"\\e114\";\r\n        float: right;\r\n        color: grey;\r\n    }\r\n\r\n    .panel-heading a.collapsed:after {\r\n        content: \"\\e080\";\r\n    }\r\n\r\n    .collapsable {\r\n        cursor: pointer;\r\n    }\r\n\r\n    .white {\r\n        color: white;\r\n    }\r\n\r\n    .white:hover {\r\n        color: #e8e8e8;\r\n    }\r\n</style>\r\n\r\n";
$General = new xGeneral();
if (check_value($_POST["activate_module"])) {
    $key = $_POST["license_key"];
    $General->jIhfnHDm_activate_KdiupmNBd_Module("cashshop", $key);
}
$isActivated = $General->jHdksHgYYix_isModule_hDbMVOIfs_Activated("cashshop");
if (!$isActivated) {
    echo "\r\n    <form method=\"post\" action=\"\">\r\n        <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n            <tr>\r\n                <th>License Key<br/><span></span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"license_key\" value=\"\" size=\"30\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td colspan=\"2\"><input type=\"submit\" name=\"activate_module\" value=\"Activate Module\" class=\"btn btn-success\"/>\r\n                </td>\r\n            </tr>\r\n        </table>\r\n    </form>";
} else {
    if (check_value($_GET["action"]) && check_value($_GET["type"]) && check_value($_GET["id"]) && is_numeric($_GET["id"])) {
        $table = "";
        $active = 0;
        $id = $_GET["id"];
        $name = "";
        switch ($_GET["action"]) {
            case "enable":
                $active = 1;
                break;
            case "disable":
                $active = 0;
                break;
            default:
                switch ($_GET["type"]) {
                    case "item":
                        $table = "IMPERIAMUCMS_CASHSHOP_ITEMS";
                        $name = "Item";
                        break;
                    case "cat":
                        $table = "IMPERIAMUCMS_CASHSHOP_CATEGORIES";
                        $name = "Category";
                        break;
                    case "subcat":
                        $table = "IMPERIAMUCMS_CASHSHOP_SUBCATEGORIES";
                        $name = "Subcategory";
                        break;
                    default:
                        $update = $dB->query("UPDATE " . $table . " SET active = ? WHERE id = ?", [$active, $id]);
                        if ($update) {
                            message("success", $name . " #" . $id . " was successfully " . $_GET["action"] . "d.");
                        } else {
                            message("error", "Status could not be changed.");
                        }
                }
        }
    }
    if (check_value($_POST["save"])) {
        $error = false;
        $query = "";
        $array = [];
        foreach ($_POST as $thisPost) {
            if (check_value($thisPost)) {
                $values = explode("_", $thisPost);
                if ($values[0] == "pos") {
                    if ($values[1] == "cat") {
                        if (check_value($values[2]) && is_numeric($values[2])) {
                            $query .= "UPDATE IMPERIAMUCMS_CASHSHOP_CATEGORIES SET position = ? WHERE id = ?; ";
                            array_push($array, $thisPost, $values[2]);
                        }
                    } else {
                        if ($values[1] == "subcat") {
                            if (check_value($values[2]) && is_numeric($values[2])) {
                                $query .= "UPDATE IMPERIAMUCMS_CASHSHOP_SUBCATEGORIES SET position = ? WHERE id = ?; ";
                                array_push($array, $thisPost, $values[2]);
                            }
                        } else {
                            if ($values[1] == "item" && check_value($values[2]) && is_numeric($values[2])) {
                                $query .= "UPDATE IMPERIAMUCMS_CASHSHOP_ITEMS SET position = ? WHERE id = ?; ";
                                array_push($array, $thisPost, $values[2]);
                            }
                        }
                    }
                }
            } else {
                $error = true;
                if (!$error) {
                    $update = $dB->query($query, $array);
                    if ($update) {
                        message("success", "Positions were successfully updated.");
                    } else {
                        message("error", "Positions could not be changed.");
                    }
                } else {
                    message("error", "Some fields are empty.");
                }
            }
        }
    }
    try {
        $items = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_CASHSHOP_ITEMS ORDER BY category_id, subcategory_id, position");
        $cats = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_CASHSHOP_CATEGORIES ORDER BY position");
        $subcats = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_CASHSHOP_SUBCATEGORIES ORDER BY category_id, position");
        echo "<div style=\"padding-bottom: 30px;\">";
        echo "<a class=\"btn btn-primary\" href=\"" . admincp_base("cashshop_add_cat") . "\">ADD NEW CATEGORY</a> ";
        echo "<a class=\"btn btn-info\" href=\"" . admincp_base("cashshop_add_subcat") . "\">ADD NEW SUBCATEGORY</a> ";
        echo "<a class=\"btn btn-success\" href=\"" . admincp_base("cashshop_add_item") . "\">ADD NEW ITEM</a>";
        echo "</div><div class=\"panel-group\" id=\"accordion\">";
        if (is_array($cats)) {
            echo "<form method=\"post\" action=\"\">";
            foreach ($cats as $thisCat) {
                if ($thisCat["active"] == "1") {
                    $status = "<a href=\"" . admincp_base("cashshop_manager") . "&action=disable&type=cat&id=" . $thisCat["id"] . "\" title=\"Disable " . $thisCat["title"] . "\"><i class=\"fa fa-times-circle white\"></i></a>";
                } else {
                    $status = "<a href=\"" . admincp_base("cashshop_manager") . "&action=enable&type=cat&id=" . $thisCat["id"] . "\" title=\"Enable " . $thisCat["title"] . "\"><i class=\"fa fa-check-circle-o white\"></i></a>";
                }
                echo "\r\n            <div class=\"panel panel-primary\" id=\"main\">\r\n                <div class=\"panel-heading\">\r\n                    <h4 class=\"panel-title collapsable\">\r\n                        <a data-toggle=\"collapse\" data-target=\"#subcategories_" . $thisCat["id"] . ", #items_" . $thisCat["id"] . "\" class=\"collapsed col_link\">" . $thisCat["title"] . "</a>\r\n                        <div style=\"float: right; margin-right: 20px;\">\r\n                            <!--<input type=\"text\" class=\"form-control\" name=\"pos_cat_" . $thisCat["id"] . "\" value=\"" . $thisCat["position"] . "\" maxlength=\"4\" style=\"width: 60px;\" />-->\r\n                            <a href=\"" . admincp_base("cashshop_edit_cat") . "&id=" . $thisCat["id"] . "\"><i class=\"fa fa-edit white\"></i></a>\r\n                            " . $status . "\r\n                        </div> \r\n                    </h4>\r\n                </div>";
                if (is_array($subcats)) {
                    foreach ($subcats as $thisSubcat) {
                        if ($thisSubcat["category_id"] == $thisCat["id"]) {
                            if ($thisSubcat["active"] == "1") {
                                $status = "<a href=\"" . admincp_base("cashshop_manager") . "&action=disable&type=subcat&id=" . $thisSubcat["id"] . "\" title=\"Disable " . $thisSubcat["title"] . "\"><i class=\"fa fa-times-circle\"></i></a>";
                            } else {
                                $status = "<a href=\"" . admincp_base("cashshop_manager") . "&action=enable&type=subcat&id=" . $thisSubcat["id"] . "\" title=\"Enable " . $thisSubcat["title"] . "\"><i class=\"fa fa-check-circle-o\"></i></a>";
                            }
                            echo "\r\n                        <div class=\"panel panel-default collapse\" id=\"subcategories_" . $thisCat["id"] . "\" style=\"padding: 10px; border: none;\">\r\n                            <div class=\"panel-heading\">\r\n                                <h4 class=\"panel-title collapsable\">\r\n                                    <a data-toggle=\"collapse\" data-target=\"#items_" . $thisCat["id"] . "_" . $thisSubcat["id"] . "\" class=\"collapsed col_link\">" . $thisSubcat["title"] . "</a> \r\n                                    <div style=\"float: right; margin-right: 20px;\">\r\n                                        <!--<input type=\"text\" class=\"form-control\" name=\"pos_subcat_" . $thisSubcat["id"] . "\" value=\"" . $thisSubcat["position"] . "\" maxlength=\"4\" style=\"width: 60px;\" />-->\r\n                                        <a href=\"" . admincp_base("cashshop_edit_subcat") . "&id=" . $thisSubcat["id"] . "\"><i class=\"fa fa-edit\"></i></a>\r\n                                        " . $status . "\r\n                                    </div> \r\n                                </h4>\r\n                            </div>";
                            if (is_array($items)) {
                                echo "<div id=\"items_" . $thisCat["id"] . "_" . $thisSubcat["id"] . "\" class=\"panel-collapse collapse\">";
                                foreach ($items as $thisItem) {
                                    if ($thisItem["category_id"] == $thisCat["id"] && $thisItem["subcategory_id"] == $thisSubcat["id"]) {
                                        if ($thisItem["active"] == "1") {
                                            $status = "<a href=\"" . admincp_base("cashshop_manager") . "&action=disable&type=item&id=" . $thisItem["id"] . "\" title=\"Disable " . $thisItem["name"] . "\"><i class=\"fa fa-times-circle\"></i></a>";
                                        } else {
                                            $status = "<a href=\"" . admincp_base("cashshop_manager") . "&action=enable&type=item&id=" . $thisItem["id"] . "\" title=\"Enable " . $thisItem["name"] . "\"><i class=\"fa fa-check-circle-o\"></i></a>";
                                        }
                                        echo "\r\n                                    <div class=\"panel-body\">\r\n                                        " . $thisItem["name"] . "\r\n                                        <div style=\"float: right; margin-right: 20px;\">\r\n                                            <a href=\"" . admincp_base("cashshop_edit_item") . "&id=" . $thisItem["id"] . "\"><i class=\"fa fa-edit\"></i></a>\r\n                                            " . $status . "\r\n                                        </div>\r\n                                    </div>";
                                    }
                                }
                                echo "</div>";
                            }
                            echo "</div>";
                        }
                    }
                }
                if (is_array($items)) {
                    echo "<div id=\"items_" . $thisCat["id"] . "\" class=\"panel-collapse collapse\">";
                    foreach ($items as $thisItem) {
                        if ($thisItem["category_id"] == $thisCat["id"] && $thisItem["subcategory_id"] == 0) {
                            if ($thisItem["active"] == "1") {
                                $status = "<a href=\"" . admincp_base("cashshop_manager") . "&action=disable&type=item&id=" . $thisItem["id"] . "\" title=\"Disable " . $thisItem["name"] . "\"><i class=\"fa fa-times-circle\"></i></a>";
                            } else {
                                $status = "<a href=\"" . admincp_base("cashshop_manager") . "&action=enable&type=item&id=" . $thisItem["id"] . "\" title=\"Enable " . $thisItem["name"] . "\"><i class=\"fa fa-check-circle-o\"></i></a>";
                            }
                            echo "\r\n                        <div class=\"panel-body\">\r\n                            " . $thisItem["name"] . "\r\n                            <div style=\"float: right; margin-right: 20px;\">\r\n                                <a href=\"" . admincp_base("cashshop_edit_item") . "&id=" . $thisItem["id"] . "\"><i class=\"fa fa-edit\"></i></a>\r\n                                " . $status . "\r\n                            </div>\r\n                        </div>";
                        }
                    }
                    echo "</div>";
                }
                echo "</div>";
            }
            echo "</form>";
        } else {
            message("error", "Please create your first category.");
        }
    } catch (Exception $ex) {
        message("error", $ex->getMessage());
    }
}

?>