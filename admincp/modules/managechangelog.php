<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h1 class=\"page-header\">Manage Changelogs</h1>\r\n";
$Changelog = new Changelog();
if ($Changelog->isChangelogDirWritable()) {
    if (check_value($_REQUEST["delete"])) {
        $deleteChangelog = $Changelog->removeChangelog($_REQUEST["delete"]);
        $Changelog->cacheChangelog();
        $Changelog->updateChangelogCacheIndex();
        if ($deleteChangelog) {
            message("success", "Changelog successfully deleted");
        } else {
            message("error", "Invalid Changelog ID");
        }
    }
    if (check_value($_REQUEST["cache"]) && $_REQUEST["cache"] == 1) {
        $cacheChangelog = $Changelog->cacheChangelog();
        $Changelog->updateChangelogCacheIndex();
        if ($cacheChangelog) {
            message("success", "Changelog successfully cached");
        } else {
            message("error", "Unknown error");
        }
    }
    $Changelog_list = $Changelog->retrieveChangelog();
    if (is_array($Changelog_list)) {
        echo "<table class=\"table table-hover table-striped\"><thead><tr><th>#</th><th>TITLE</th><th>AUTHOR</th><th>DATE</th><th>TYPE</th><th></th></tr></thead><tbody>";
        foreach ($Changelog_list as $thisChangelog) {
            if ($thisChangelog["type"] == 1) {
                $thisChangelog_type = "Server";
            } else {
                $thisChangelog_type = "Website";
            }
            echo "<tr>";
            echo "<td>" . $thisChangelog["id"] . "</td>";
            echo "<td>" . $thisChangelog["title"] . "</td>";
            echo "<td>" . $thisChangelog["author"] . "</td>";
            echo "<td>" . $thisChangelog["date"] . "</td>";
            echo "<td>" . $thisChangelog_type . "</td>";
            echo "<td>";
            echo "<a class=\"btn btn-default btn-sm\" href=\"" . admincp_base("editchangelog&id=" . $thisChangelog["id"]) . "\"><i class=\"fa fa-edit\"></i> edit</a> ";
            echo "<a class=\"btn btn-danger btn-sm\" href=\"" . admincp_base("managechangelog&delete=" . $thisChangelog["id"]) . "\"><i class=\"fa fa-trash\"></i> delete</a>";
            echo "</td></tr>";
        }
        echo "</tbody></table>";
    }
    echo "<a class=\"btn btn-success\" href=\"" . admincp_base("managechangelog&cache=1") . "\">UPDATE CHANGELOG CACHE</a>";
} else {
    message("error", "The changelog cache folder is not writable.");
}

?>