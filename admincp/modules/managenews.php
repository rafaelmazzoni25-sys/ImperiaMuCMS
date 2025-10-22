<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h1 class=\"page-header\">Manage News</h1>\r\n";
$News = new News();
if ($News->isNewsDirWritable()) {
    if (check_value($_REQUEST["delete"])) {
        $deleteNews = $News->removeNews($_REQUEST["delete"]);
        $News->cacheNews();
        $News->updateNewsCacheIndex();
        if ($deleteNews) {
            message("success", "News successfully deleted");
        } else {
            message("error", "Invalid news ID");
        }
    }
    if (check_value($_REQUEST["cache"]) && $_REQUEST["cache"] == 1) {
        $cacheNews = $News->cacheNews();
        $News->updateNewsCacheIndex();
        if ($cacheNews) {
            message("success", "News successfully cached");
        } else {
            message("error", "Unknown error");
        }
    }
    $news_list = $News->retrieveNews();
    if (is_array($news_list)) {
        echo "<table class=\"table table-hover table-striped\"><thead><tr><th>#</th><th>TITLE</th><th>AUTHOR</th><th>DATE</th><th>ALLOW COMMENTS</th><th></th></tr></thead><tbody>";
        foreach ($news_list as $thisNews) {
            $thisNews_allowcomments = $thisNews["allow_comments"] == 1 ? "<span class=\"btn btn-success btn-circle\"><i class=\"fa fa-check\"></i></span>" : "<span class=\"btn btn-danger btn-circle\"><i class=\"fa fa-times\"></i></span>";
            echo "<tr>";
            echo "<td>" . $thisNews["news_id"] . "</td>";
            echo "<td><a href=\"" . __BASE_URL__ . "news/" . Encode_id($thisNews["news_id"]) . "/\" target=\"_blank\">" . $thisNews["news_title"] . "</a></td>";
            echo "<td>" . $thisNews["news_author"] . "</td>";
            echo "<td>" . date($config["time_date_format"], $thisNews["news_date"]) . "</td>";
            echo "<td>" . $thisNews_allowcomments . "</td>";
            echo "<td>";
            echo "<a class=\"btn btn-default btn-sm\" href=\"" . admincp_base("editnews&id=" . $thisNews["news_id"]) . "\"><i class=\"fa fa-edit\"></i> edit</a> ";
            echo "<a class=\"btn btn-danger btn-sm\" href=\"" . admincp_base("managenews&delete=" . $thisNews["news_id"]) . "\"><i class=\"fa fa-trash\"></i> delete</a>";
            echo "</td></tr>";
        }
        echo "</tbody></table>";
    }
    echo "<a class=\"btn btn-success\" href=\"" . admincp_base("managenews&cache=1") . "\">UPDATE NEWS CACHE</a>";
} else {
    message("error", "The news cache folder is not writable.");
}

?>