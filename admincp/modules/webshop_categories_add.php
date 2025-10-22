<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h1 class=\"page-header\">Add New Category</h1>\r\n";
$Webshop = new Webshop();
loadModuleConfigs("webshop");
if (check_value($_POST["add_category"])) {
    $catCode = $dB->query_fetch_single("SELECT MAX(code) as maxCode FROM IMPERIAMUCMS_WEBSHOP_CATEGORY");
    if ($catCode["maxCode"] < 200) {
        $catCode["maxCode"] = 200;
    } else {
        $catCode["maxCode"] = $catCode["maxCode"] + 1;
    }
    if ($_POST["type"] == "1") {
        $parent = NULL;
    } else {
        $parent = $_POST["parent"];
    }
    $insert = $dB->query("INSERT INTO IMPERIAMUCMS_WEBSHOP_CATEGORY ([title], [type], [code], [parent], [active], [protected], [order]) VALUES (?, ?, ?, ?, ?, ?, ?)", [$_POST["title"], $_POST["type"], $catCode["maxCode"], $parent, 1, 0, $_POST["order"]]);
    if ($insert) {
        message("success", "Category was created successfully.");
    } else {
        message("error", "Category could not be created, please check your SQL logs for error message.");
    }
}
$categories = $dB->query_fetch("SELECT code, title FROM IMPERIAMUCMS_WEBSHOP_CATEGORY WHERE type = 1 ORDER BY [order]");
$catOpts = "<option value=\"\">-- None --</option>";
if (is_array($categories)) {
    foreach ($categories as $thisCat) {
        $catOpts .= "<option value=\"" . $thisCat["code"] . "\">" . $thisCat["title"] . "</option>";
    }
}
echo "<a class=\"btn btn-primary\" href=\"";
echo admincp_base("webshop_categories");
echo "\">CATEGORIES MANAGER</a><br/><br/>\r\n<form role=\"form\" method=\"post\">\r\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n        <tr>\r\n            <th>Title<br/><span>Category title</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"title\" value=\"\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Type<br/><span>Type of the category</span></th>\r\n            <td>\r\n                <select name=\"type\" class=\"form-control\">\r\n                    <option value=\"1\">Main Category</option>\r\n                    <option value=\"2\">Sub-Category</option>\r\n                </select>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Parent Category<br/><span>Choose Parent Category ONLY in case you are creating new Sub-Category!</span></th>\r\n            <td>\r\n                <select name=\"parent\" class=\"form-control\">\r\n                    ";
echo $catOpts;
echo "                </select>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Order<br/><span>Position of the category in the filter, number values only</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"order\" value=\"1\"/>\r\n            </td>\r\n        </tr>\r\n    </table>\r\n    <button type=\"submit\" class=\"btn btn-large btn-block btn-success\" name=\"add_category\" value=\"ok\">Add Category</button>\r\n</form>";

?>