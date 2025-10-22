<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h1 class=\"page-header\">Edit Category</h1>\r\n";
$Webshop = new Webshop();
loadModuleConfigs("webshop");
if (check_value($_POST["edit_category"])) {
    if ($_POST["type"] == "1") {
        $parent = NULL;
    } else {
        $parent = $_POST["parent"];
    }
    $update = $dB->query("UPDATE IMPERIAMUCMS_WEBSHOP_CATEGORY SET [title] = ?, [type] = ?, [parent] = ?, [order] = ? WHERE [id] = ?", [$_POST["title"], $_POST["type"], $parent, $_POST["order"], $_POST["id"]]);
    if ($update) {
        message("success", "Category was updated successfully.");
    } else {
        message("error", "Category could not be updated, please check your SQL logs for error message.");
    }
}
$category = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_WEBSHOP_CATEGORY WHERE id = ?", [$_GET["id"]]);
if (is_array($category)) {
    $categories = $dB->query_fetch("SELECT code, title FROM IMPERIAMUCMS_WEBSHOP_CATEGORY WHERE type = 1 ORDER BY [order]");
    $catOpts = "<option value=\"\">-- None --</option>";
    if (is_array($categories)) {
        foreach ($categories as $thisCat) {
            if ($category["parent"] == $thisCat["code"]) {
                $catOpts .= "<option value=\"" . $thisCat["code"] . "\" selected=\"selected\">" . $thisCat["title"] . "</option>";
            } else {
                $catOpts .= "<option value=\"" . $thisCat["code"] . "\">" . $thisCat["title"] . "</option>";
            }
        }
    }
    echo "\r\n<a class=\"btn btn-primary\" href=\"" . admincp_base("webshop_categories") . "\">CATEGORIES MANAGER</a><br/><br/>\r\n<form role=\"form\" method=\"post\">\r\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n        <tr>\r\n            <th>Title<br/><span>Category title</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"title\" value=\"" . $category["title"] . "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Type<br/><span>Type of the category</span></th>\r\n            <td>\r\n                <select name=\"type\" class=\"form-control\">";
    if ($category["type"] == "1") {
        echo "<option value=\"1\" selected=\"selected\">Main Category</option>";
    } else {
        echo "<option value=\"1\">Main Category</option>";
    }
    if ($category["type"] == "2") {
        echo "<option value=\"2\" selected=\"selected\">Sub-Category</option>";
    } else {
        echo "<option value=\"2\">Sub-Category</option>";
    }
    echo "\r\n                </select>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Parent Category<br/><span>Choose Parent Category ONLY in case you are creating new Sub-Category!</span></th>\r\n            <td>\r\n                <select name=\"parent\" class=\"form-control\">\r\n                    " . $catOpts . "\r\n                </select>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Order<br/><span>Position of the category in the filter, number values only</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"order\" value=\"" . $category["order"] . "\"/>\r\n            </td>\r\n        </tr>\r\n    </table>\r\n    <input type=\"hidden\" name=\"id\" value=\"" . $category["id"] . "\" />\r\n    <button type=\"submit\" class=\"btn btn-large btn-block btn-success\" name=\"edit_category\" value=\"ok\">Edit Category</button>\r\n</form>";
} else {
    message("error", "Category doesn't exist.");
}

?>