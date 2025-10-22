<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h1 class=\"page-header\">Edit Subcategory</h1>\r\n\r\n";
if (check_value($_GET["id"]) && is_numeric($_GET["id"])) {
    $id = $_GET["id"];
    if (check_value($_POST["submit"])) {
        if (check_value($_POST["title"]) && check_value($_POST["cat"]) && check_value($_POST["pos"])) {
            if (is_numeric($_POST["pos"])) {
                $title = addslashes($_POST["title"]);
                $cat = xss_clean($_POST["cat"]);
                $pos = xss_clean($_POST["pos"]);
                $insert = $dB->query("UPDATE IMPERIAMUCMS_CASHSHOP_SUBCATEGORIES SET category_id = ?, title = ?, position = ? WHERE id = ?", [$cat, $title, $pos, $id]);
                if ($insert) {
                    message("success", "Subcategory was successfully updated.");
                } else {
                    message("error", "Unexpected error occurred. Please contact website's developer.");
                }
            } else {
                message("error", "Position must be a number!");
            }
        } else {
            message("error", "Some fields are empty.");
        }
    }
    $subcatData = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_CASHSHOP_SUBCATEGORIES WHERE id = ?", [$id]);
    $cats = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_CASHSHOP_CATEGORIES ORDER BY title");
    $catsOptions = "";
    foreach ($cats as $thisCat) {
        if ($subcatData["category_id"] == $thisCat["id"]) {
            $catsOptions .= "<option value=\"" . $thisCat["id"] . "\" selected=\"selected\">" . $thisCat["title"] . "</option>";
        } else {
            $catsOptions .= "<option value=\"" . $thisCat["id"] . "\">" . $thisCat["title"] . "</option>";
        }
    }
    echo "\r\n    <form role=\"form\" method=\"post\">\r\n        <div class=\"form-group\">\r\n            <label for=\"title\">Title:</label>\r\n            <input type=\"text\" class=\"form-control\" id=\"title\" name=\"title\" value=\"" . stripslashes($subcatData["title"]) . "\" placeholder=\"Title\" maxlength=\"255\"/>\r\n        </div>\r\n        <div class=\"form-group\">\r\n            <label for=\"cat\">Category:</label>\r\n            <select class=\"form-control\" id=\"cat\" name=\"cat\">\r\n                " . $catsOptions . "\r\n            </select>\r\n        </div>\r\n        <div class=\"form-group\">\r\n            <label for=\"pos\">Position:</label>\r\n            <input type=\"text\" class=\"form-control\" id=\"pos\" name=\"pos\" value=\"" . $subcatData["position"] . "\" placeholder=\"Position\"/>\r\n        </div>\r\n\r\n        <button type=\"submit\" class=\"btn btn-large btn-block btn-success\" name=\"submit\" value=\"ok\">Edit Subcategory</button>\r\n    </form>";
} else {
    message("error", "Requested subcategory does not exist.");
}

?>