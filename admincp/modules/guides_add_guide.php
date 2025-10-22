<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h1 class=\"page-header\">Create New Guide</h1>\r\n\r\n";
if (check_value($_POST["submit"])) {
    if (check_value($_POST["title"]) && check_value($_POST["text"]) && check_value($_POST["cat"]) && check_value($_POST["pos"])) {
        if (is_numeric($_POST["pos"])) {
            $title = addslashes($_POST["title"]);
            $text = addslashes($_POST["text"]);
            $cat = xss_clean($_POST["cat"]);
            $pos = xss_clean($_POST["pos"]);
            $tmp = explode(";", $cat);
            list($cat, $subcat) = $tmp;
            $insert = $dB->query("INSERT INTO IMPERIAMUCMS_GUIDES (category_id, subcategory_id, title, text, position, active) VALUES (?, ?, ?, ?, ?, ?)", [$cat, $subcat, $title, $text, $pos, 1]);
            if ($insert) {
                message("success", "Guide was successfully created.");
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
$cats = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_GUIDES_CATEGORIES ORDER BY title");
$catsOptions = "";
$subcatsOptions = "<option value=\"\">-- None --</option>";
if (is_array($cats)) {
    foreach ($cats as $thisCat) {
        $catsOptions .= "<option value=\"" . $thisCat["id"] . ";0\">" . $thisCat["title"] . "</option>";
        $subcats = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_GUIDES_SUBCATEGORIES WHERE category_id = ? ORDER BY title", [$thisCat["id"]]);
        if (is_array($subcats)) {
            foreach ($subcats as $thisSubcat) {
                $catsOptions .= "<option value=\"" . $thisCat["id"] . ";" . $thisSubcat["id"] . "\"> -- " . $thisSubcat["title"] . "</option>";
            }
        }
    }
}
echo "\r\n<form role=\"form\" method=\"post\">\r\n    <div class=\"form-group\">\r\n        <label for=\"title\">Title:</label>\r\n        <input type=\"text\" class=\"form-control\" id=\"title\" name=\"title\" placeholder=\"Title\" maxlength=\"255\"/>\r\n    </div>\r\n    <div class=\"form-group\">\r\n        <label for=\"cat\">Category:</label>\r\n        <select class=\"form-control\" id=\"cat\" name=\"cat\">\r\n            ";
echo $catsOptions;
echo "        </select>\r\n    </div>\r\n    <div class=\"form-group\">\r\n        <label for=\"pos\">Position:</label>\r\n        <input type=\"text\" class=\"form-control\" id=\"pos\" name=\"pos\" placeholder=\"Position\"/>\r\n    </div>\r\n    <div class=\"form-group\">\r\n        <label for=\"news_content\"></label>\r\n        <textarea name=\"text\" id=\"text\"></textarea>\r\n    </div>\r\n\r\n    <button type=\"submit\" class=\"btn btn-large btn-block btn-success\" name=\"submit\" value=\"ok\">Add Guide</button>\r\n</form>\r\n\r\n<script src=\"";
echo __BASE_URL__;
echo "admincp/ckeditor/ckeditor.js\"></script>\r\n<script type=\"text/javascript\">//<![CDATA[\r\n    //CKEDITOR.replace('editor1');\r\n    CKEDITOR.replace('text', {\r\n        language: 'en',\r\n        uiColor: '#f1f1f1'\r\n    });\r\n    //]]>\r\n</script>";

?>