<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h1 class=\"page-header\">Edit Guide</h1>\r\n\r\n";
if (check_value($_GET["id"]) && is_numeric($_GET["id"])) {
    $id = $_GET["id"];
    if (check_value($_POST["submit"])) {
        if (check_value($_POST["title"]) && check_value($_POST["text"]) && check_value($_POST["cat"]) && check_value($_POST["pos"])) {
            if (is_numeric($_POST["pos"])) {
                $title = addslashes($_POST["title"]);
                $text = addslashes($_POST["text"]);
                $cat = xss_clean($_POST["cat"]);
                $pos = xss_clean($_POST["pos"]);
                $tmp = explode(";", $cat);
                list($cat, $subcat) = $tmp;
                $insert = $dB->query("UPDATE IMPERIAMUCMS_GUIDES SET category_id = ?, subcategory_id = ?, title = ?, text = ?, position = ? WHERE id = ?", [$cat, $subcat, $title, $text, $pos, $id]);
                if ($insert) {
                    message("success", "Guide was successfully updated.");
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
    $guideData = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_GUIDES WHERE id = ?", [$id]);
    $cats = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_GUIDES_CATEGORIES ORDER BY title");
    $catsOptions = "";
    if (is_array($cats)) {
        foreach ($cats as $thisCat) {
            $isSubcat = false;
            $subcats = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_GUIDES_SUBCATEGORIES WHERE category_id = ? ORDER BY title", [$thisCat["id"]]);
            if (is_array($subcats)) {
                foreach ($subcats as $thisSubcat) {
                    if ($guideData["subcategory_id"] == $thisSubcat["id"]) {
                        $isSubcat = true;
                        $catsOptions .= "<option value=\"" . $thisCat["id"] . ";" . $thisSubcat["id"] . "\" selected=\"selected\"> -- " . $thisSubcat["title"] . "</option>";
                    } else {
                        $catsOptions .= "<option value=\"" . $thisCat["id"] . ";" . $thisSubcat["id"] . "\"> -- " . $thisSubcat["title"] . "</option>";
                    }
                }
            }
            if ($guideData["category_id"] == $thisCat["id"] && !$isSubcat) {
                $catsOptions .= "<option value=\"" . $thisCat["id"] . ";0\" selected=\"selected\">" . $thisCat["title"] . "</option>";
            } else {
                $catsOptions .= "<option value=\"" . $thisCat["id"] . ";0\">" . $thisCat["title"] . "</option>";
            }
        }
    }
    echo "\r\n    <form role=\"form\" method=\"post\">\r\n        <div class=\"form-group\">\r\n            <label for=\"title\">Title:</label>\r\n            <input type=\"text\" class=\"form-control\" id=\"title\" name=\"title\" value=\"" . stripslashes($guideData["title"]) . "\" placeholder=\"Title\" maxlength=\"255\"/>\r\n        </div>\r\n        <div class=\"form-group\">\r\n            <label for=\"cat\">Category:</label>\r\n            <select class=\"form-control\" id=\"cat\" name=\"cat\">\r\n                " . $catsOptions . "\r\n            </select>\r\n        </div>\r\n        <div class=\"form-group\">\r\n            <label for=\"pos\">Position:</label>\r\n            <input type=\"text\" class=\"form-control\" id=\"pos\" name=\"pos\" value=\"" . $guideData["position"] . "\" placeholder=\"Position\"/>\r\n        </div>\r\n        <div class=\"form-group\">\r\n            <label for=\"news_content\"></label>\r\n            <textarea name=\"text\" id=\"text\">" . stripslashes($guideData["text"]) . "</textarea>\r\n        </div>\r\n\r\n        <button type=\"submit\" class=\"btn btn-large btn-block btn-success\" name=\"submit\" value=\"ok\">Edit Guide</button>\r\n    </form>";
    echo "\r\n    <script src=\"";
    echo __BASE_URL__;
    echo "admincp/ckeditor/ckeditor.js\"></script>\r\n    <script type=\"text/javascript\">//<![CDATA[\r\n        //CKEDITOR.replace('editor1');\r\n        CKEDITOR.replace('text', {\r\n            language: 'en',\r\n            uiColor: '#f1f1f1'\r\n        });\r\n        CKEDITOR.addStylesSet('";
    echo __PATH_TEMPLATE__;
    echo "style/guides.css');\r\n        //]]>\r\n    </script>\r\n    ";
} else {
    message("error", "Requested guide does not exist.");
}

?>