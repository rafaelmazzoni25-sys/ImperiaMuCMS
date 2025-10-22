<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h1 class=\"page-header\">Create New Category for Guides</h1>\r\n\r\n";
if (check_value($_POST["submit"])) {
    if (check_value($_POST["title"]) && check_value($_POST["pos"])) {
        if (is_numeric($_POST["pos"])) {
            $title = addslashes($_POST["title"]);
            $pos = xss_clean($_POST["pos"]);
            $insert = $dB->query("INSERT INTO IMPERIAMUCMS_GUIDES_CATEGORIES (title, position, active) VALUES (?, ?, ?)", [$title, $pos, 1]);
            if ($insert) {
                message("success", "Category was successfully created.");
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
echo "\r\n<form role=\"form\" method=\"post\">\r\n    <div class=\"form-group\">\r\n        <label for=\"title\">Title:</label>\r\n        <input type=\"text\" class=\"form-control\" id=\"title\" name=\"title\" placeholder=\"Title\" maxlength=\"255\"/>\r\n    </div>\r\n    <div class=\"form-group\">\r\n        <label for=\"pos\">Position:</label>\r\n        <input type=\"text\" class=\"form-control\" id=\"pos\" name=\"pos\" placeholder=\"Position\"/>\r\n    </div>\r\n    <button type=\"submit\" class=\"btn btn-large btn-block btn-success\" name=\"submit\" value=\"ok\">Add Category</button>\r\n</form>";

?>