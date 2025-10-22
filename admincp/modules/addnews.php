<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h1 class=\"page-header\">Publish News</h1>\r\n";
$News = new News();
loadModuleConfigs("news");
if ($News->isNewsDirWritable()) {
    if (check_value($_POST["news_submit"])) {
        $News->addNews($_POST["news_title"], $_POST["news_content"], $_POST["news_author"], $_POST["news_comments"], $_POST["visible"], $_POST["news_type"]);
        $News->cacheNews();
        $News->updateNewsCacheIndex();
    }
    if (check_value($_REQUEST["cache"]) && $_REQUEST["cache"] == 1) {
        $cacheNews = $News->cacheNews();
        if ($cacheNews) {
            message("success", "News successfully cached!");
        } else {
            message("error", "Unknown error");
        }
    }
    echo "    <form role=\"form\" method=\"post\">\r\n        <div class=\"form-group\">\r\n            <label for=\"input_1\">Title:</label>\r\n            <input type=\"text\" class=\"form-control\" id=\"input_1\" name=\"news_title\"/>\r\n        </div>\r\n        <div class=\"form-group\">\r\n            <label for=\"input_1\">Type:</label>\r\n            <select class=\"form-control\" name=\"news_type\">\r\n                <option value=\"0\">Notice</option>\r\n                <option value=\"1\">Event</option>\r\n                <option value=\"2\">Update</option>\r\n                <option value=\"3\">Maintenance</option>\r\n            </select>\r\n        </div>\r\n        <div class=\"form-group\">\r\n            <label for=\"news_content\"></label>\r\n            <textarea name=\"news_content\" id=\"news_content\"></textarea>\r\n        </div>\r\n        <div class=\"form-group\">\r\n            <label for=\"input_2\">Author:</label>\r\n            <input type=\"text\" class=\"form-control\" id=\"input_2\" name=\"news_author\" value=\"Administrator\"/>\r\n        </div>\r\n        ";
    if (mconfig("news_enable_comment_system")) {
        echo "            <div class=\"form-group\">\r\n                <label for=\"input_3\">Allow Facebook Comments:</label>\r\n\r\n                <div class=\"radio\">\r\n                    <label><input type=\"radio\" name=\"news_comments\" id=\"input_3\" value=\"1\" checked> Yes</label>\r\n                </div>\r\n                <div class=\"radio\">\r\n                    <label><input type=\"radio\" name=\"news_comments\" id=\"input_3\" value=\"0\"> No</label>\r\n                </div>\r\n            </div>\r\n\r\n        ";
    } else {
        echo "            <input type=\"hidden\" name=\"news_comments\" value=\"0\"/>\r\n        ";
    }
    echo "\r\n        <div class=\"form-group\">\r\n            <label for=\"visible\">Is Visible:</label>\r\n            ";
    enabledisableCheckboxes("visible", 1, "Visible", "Hidden");
    echo "        </div>\r\n\r\n        <button type=\"submit\" class=\"btn btn-large btn-block btn-success\" name=\"news_submit\" value=\"ok\">Publish</button>\r\n    </form>\r\n\r\n    <script src=\"";
    echo __BASE_URL__;
    echo "admincp/ckeditor/ckeditor.js\"></script>\r\n    <script type=\"text/javascript\">//<![CDATA[\r\n        //CKEDITOR.replace('editor1');\r\n        CKEDITOR.replace('news_content', {\r\n            language: 'en',\r\n            uiColor: '#f1f1f1'\r\n        });\r\n        //]]></script>\r\n    ";
} else {
    message("error", "The news cache folder is not writable.");
}

?>