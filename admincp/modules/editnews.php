<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h1 class=\"page-header\">Edit News</h1>\r\n";
$News = new News();
loadModuleConfigs("news");
if ($News->isNewsDirWritable()) {
    if (check_value($_POST["news_submit"])) {
        $News->editNews($_REQUEST["id"], $_POST["news_title"], $_POST["news_content"], $_POST["news_author"], $_POST["news_comments"], $_POST["news_date"], $_POST["visible"], $_POST["news_type"]);
        $News->cacheNews();
        $News->updateNewsCacheIndex();
    }
    $editNews = $News->loadNewsData($_REQUEST["id"]);
    if ($editNews) {
        echo "        <form role=\"form\" method=\"post\">\r\n            <div class=\"form-group\">\r\n                <label for=\"input_1\">Title:</label>\r\n                <input type=\"text\" class=\"form-control\" id=\"input_1\" name=\"news_title\"\r\n                       value=\"";
        echo $editNews["news_title"];
        echo "\"/>\r\n            </div>\r\n            <div class=\"form-group\">\r\n                <label for=\"input_1\">Type:</label>\r\n                <select class=\"form-control\" name=\"news_type\">\r\n\r\n                    ";
        if ($editNews["news_type"] == "0") {
            echo "<option value=\"0\" selected=\"selected\">Notice</option>";
        } else {
            echo "<option value=\"0\">Notice</option>";
        }
        if ($editNews["news_type"] == "1") {
            echo "<option value=\"1\" selected=\"selected\">Event</option>";
        } else {
            echo "<option value=\"1\">Event</option>";
        }
        if ($editNews["news_type"] == "2") {
            echo "<option value=\"2\" selected=\"selected\">Update</option>";
        } else {
            echo "<option value=\"2\">Update</option>";
        }
        if ($editNews["news_type"] == "3") {
            echo "<option value=\"3\" selected=\"selected\">Maintenance</option>";
        } else {
            echo "<option value=\"3\">Maintenance</option>";
        }
        echo "\r\n                </select>\r\n            </div>\r\n            <div class=\"form-group\">\r\n                <label for=\"news_content\"></label>\r\n                <textarea name=\"news_content\" id=\"news_content\">";
        echo $editNews["news_content"];
        echo "</textarea>\r\n            </div>\r\n            <div class=\"form-group\">\r\n                <label for=\"input_2\">Author:</label>\r\n                <input type=\"text\" class=\"form-control\" id=\"input_2\" name=\"news_author\"\r\n                       value=\"";
        echo $editNews["news_author"];
        echo "\"/>\r\n            </div>\r\n            <div class=\"form-group\">\r\n                <label for=\"input_4\">News Date:</label>\r\n                <input type=\"text\" class=\"form-control\" id=\"input_4\" name=\"news_date\"\r\n                       value=\"";
        echo date("Y-m-d H:i", $editNews["news_date"]);
        echo "\"/>\r\n            </div>\r\n            ";
        if (mconfig("news_enable_comment_system")) {
            echo "                <div class=\"form-group\">\r\n                    <label for=\"input_3\">Allow Facebook Comments:</label>\r\n\r\n                    <div class=\"radio\">\r\n                        <label><input type=\"radio\" name=\"news_comments\" id=\"input_3\"\r\n                                      value=\"1\"";
            if ($editNews["allow_comments"] == 1) {
                echo " checked";
            }
            echo "> Yes</label>\r\n                    </div>\r\n                    <div class=\"radio\">\r\n                        <label><input type=\"radio\" name=\"news_comments\" id=\"input_3\"\r\n                                      value=\"0\"";
            if ($editNews["allow_comments"] == 0) {
                echo " checked";
            }
            echo "> No</label>\r\n                    </div>\r\n                </div>\r\n\r\n            ";
        } else {
            echo "                <input type=\"hidden\" name=\"news_comments\" value=\"0\"/>\r\n            ";
        }
        echo "\r\n            <div class=\"form-group\">\r\n                <label for=\"visible\">Is Visible:</label>\r\n                ";
        enabledisableCheckboxes("visible", $editNews["visible"], "Visible", "Hidden");
        echo "            </div>\r\n\r\n            <button type=\"submit\" class=\"btn btn-large btn-block btn-success\" name=\"news_submit\" value=\"ok\">Update News</button>\r\n        </form>\r\n\r\n        <script src=\"";
        echo __BASE_URL__;
        echo "admincp/ckeditor/ckeditor.js\"></script>\r\n        <script type=\"text/javascript\">//<![CDATA[\r\n            //CKEDITOR.replace('editor1');\r\n            CKEDITOR.replace('news_content', {\r\n                language: 'en',\r\n                uiColor: '#f1f1f1'\r\n            });\r\n            //]]></script>\r\n        ";
    } else {
        message("error", "Could not load news data.");
    }
} else {
    message("error", "The news cache folder is not writable.");
}

?>