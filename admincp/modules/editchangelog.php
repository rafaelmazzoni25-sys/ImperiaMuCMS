<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h1 class=\"page-header\">Edit Changelog</h1>\r\n";
$Changelog = new Changelog();
loadModuleConfigs("changelog");
if ($Changelog->isChangelogDirWritable()) {
    if (check_value($_POST["changelog_submit"])) {
        $Changelog->editChangelog($_REQUEST["id"], $_POST["title"], $_POST["content"], $_POST["author"], $_POST["type"]);
        $Changelog->cacheChangelog();
        $Changelog->updateChangelogCacheIndex();
    }
    $editChangelog = $Changelog->loadChangelogData($_REQUEST["id"]);
    if ($editChangelog) {
        echo "        <form role=\"form\" method=\"post\">\r\n            <div class=\"form-group\">\r\n                <label for=\"input_1\">Title:</label>\r\n                <input type=\"text\" class=\"form-control\" id=\"input_1\" name=\"title\"\r\n                       value=\"";
        echo $editChangelog["title"];
        echo "\"/>\r\n            </div>\r\n            <div class=\"form-group\">\r\n                <label for=\"type\">Type:</label>\r\n                ";
        if ($editChangelog["type"] == 1) {
            echo "\r\n            <select name=\"type\">\r\n              <option value=\"1\" selected=\"selected\">Server</option>\r\n              <option value=\"2\">Website</option>\r\n            </select>\r\n            ";
        } else {
            if ($editChangelog["type"] == 2) {
                echo "\r\n            <select name=\"type\" class=\"form-control\">\r\n              <option value=\"1\">Server</option>\r\n              <option value=\"2\" selected=\"selected\">Website</option>\r\n            </select>\r\n            ";
            }
        }
        echo "            </div>\r\n            <div class=\"form-group\">\r\n                <label for=\"content\"></label>\r\n                <textarea name=\"content\" id=\"content\">";
        echo $editChangelog["text"];
        echo "</textarea>\r\n            </div>\r\n            <div class=\"form-group\">\r\n                <label for=\"input_2\">Author:</label>\r\n                <input type=\"text\" class=\"form-control\" id=\"input_2\" name=\"author\"\r\n                       value=\"";
        echo $editChangelog["author"];
        echo "\"/>\r\n            </div>\r\n\r\n            <button type=\"submit\" class=\"btn btn-large btn-block btn-success\" name=\"changelog_submit\" value=\"ok\">Update\r\n                Changelog\r\n            </button>\r\n        </form>\r\n\r\n        <script src=\"";
        echo __BASE_URL__;
        echo "admincp/ckeditor/ckeditor.js\"></script>\r\n        <script type=\"text/javascript\">//<![CDATA[\r\n            //CKEDITOR.replace('editor1');\r\n            CKEDITOR.replace('content', {\r\n                language: 'en',\r\n                uiColor: '#f1f1f1'\r\n            });\r\n            //]]></script>\r\n        ";
    } else {
        message("error", "Could not load changelog data.");
    }
} else {
    message("error", "The changelog cache folder is not writable.");
}

?>