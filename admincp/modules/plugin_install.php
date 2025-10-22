<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h1 class=\"page-header\">Import Plugin</h1>\r\n";
if (check_value($_POST["submit"])) {
    if (0 < $_FILES["file"]["error"]) {
        message("error", "There has been an error uploading the file.");
    } else {
        $Plugin = new Plugins();
        $Plugin->importPlugin($_FILES);
    }
}
echo "<form action=\"\" method=\"post\" enctype=\"multipart/form-data\">\r\n    <div class=\"form-group\">\r\n        <label>Select file</label>\r\n        <input type=\"file\" name=\"file\" id=\"file\"/>\r\n    </div>\r\n    <input type=\"submit\" name=\"submit\" class=\"btn btn-primary span2\" value=\"Install\"/>\r\n</form>\r\n<p>Make sure you upload all the plugin files before importing it.</p>";

?>