<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h1 class=\"page-header\">Publish Changelog</h1>\r\n";
$Changelog = new Changelog();
loadModuleConfigs("changelog");
if ($Changelog->isChangelogDirWritable()) {
    if (check_value($_POST["changelog_submit"])) {
        $Changelog->addChangelog($_POST["changelog_title"], $_POST["changelog_content"], $_POST["changelog_author"], $_POST["changelog_type"]);
        $Changelog->cacheChangelog();
        $Changelog->updateChangelogCacheIndex();
    }
    if (check_value($_REQUEST["cache"]) && $_REQUEST["cache"] == 1) {
        $cacheChangelog = $Changelog->cacheChangelog();
        if ($cacheChangelog) {
            message("success", "Changelogs successfully cached!");
        } else {
            message("error", "Unknown error");
        }
    }
    echo "\r\n    <form role=\"form\" method=\"post\">\r\n        <div class=\"form-group\">\r\n            <label for=\"input_1\">Title:</label>\r\n            <input type=\"text\" class=\"form-control\" id=\"input_1\" name=\"changelog_title\"/>\r\n        </div>\r\n        <div class=\"form-group\">\r\n            <label for=\"type\">Type:</label>\r\n            <select name=\"changelog_type\" class=\"form-control\">\r\n                <option value=\"1\" selected=\"selected\">Server</option>\r\n                <option value=\"2\">Website</option>\r\n            </select>\r\n        </div>\r\n\r\n        <div class=\"form-group\">\r\n            <label for=\"changelog_content\"></label>\r\n            <textarea name=\"changelog_content\" id=\"changelog_content\"></textarea>\r\n        </div>\r\n        <div class=\"form-group\">\r\n            <label for=\"input_2\">Author:</label>\r\n            <input type=\"text\" class=\"form-control\" id=\"input_2\" name=\"changelog_author\"\r\n                   value=\"";
    echo $_SESSION["username"];
    echo "\" readonly/>\r\n        </div>\r\n        <button type=\"submit\" class=\"btn btn-large btn-block btn-success\" name=\"changelog_submit\" value=\"ok\">Publish\r\n        </button>\r\n    </form>\r\n\r\n    <script src=\"";
    echo __BASE_URL__;
    echo "admincp/ckeditor/ckeditor.js\"></script>\r\n    <script type=\"text/javascript\">//<![CDATA[\r\n        //CKEDITOR.replace('editor1');\r\n        CKEDITOR.replace('changelog_content', {\r\n            language: 'en',\r\n            uiColor: '#f1f1f1'\r\n        });\r\n        //]]></script>\r\n    ";
} else {
    message("error", "The changelogs cache folder is not writable.");
}

?>