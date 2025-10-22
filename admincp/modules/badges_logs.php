<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h1 class=\"page-header\">Badges Logs</h1>\r\n";
$General = new xGeneral();
if (check_value($_POST["activate_module"])) {
    $key = $_POST["license_key"];
    $General->jIhfnHDm_activate_KdiupmNBd_Module("achievements", $key);
}
$isActivated = $General->jHdksHgYYix_isModule_hDbMVOIfs_Activated("badges");
if (!$isActivated && !$General->ftanHCIfo_canUse_j8GsnawwvJ_Module("badges")) {
    echo "\r\n    <form method=\"post\" action=\"\">\r\n        <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n            <tr>\r\n                <th>License Key<br/><span></span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"license_key\" value=\"\" size=\"30\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td colspan=\"2\"><input type=\"submit\" name=\"activate_module\" value=\"Activate Module\" class=\"btn btn-success\"/>\r\n                </td>\r\n            </tr>\r\n        </table>\r\n    </form>";
} else {
    $page = $_GET["pg"];
    if ($page == NULL) {
        $page = 1;
        $_GET["pg"] = 1;
    }
    $limit = 50;
    $logs = $dB->query_fetch("\r\n        SELECT br.BadgeID, br.AccountID, br.Name, br.Date, br.Tooltip, b.Title, b.TitleLang, b.Image, br.GuildNumber, g.G_Name\r\n        FROM IMPERIAMUCMS_BADGES_REWARDS br \r\n        LEFT JOIN IMPERIAMUCMS_BADGES b ON b.id = br.BadgeID \r\n        LEFT JOIN Guild g ON g.Number = br.GuildNumber \r\n        ORDER BY Date DESC\r\n        OFFSET " . intval($page * $limit - $limit) . " ROWS FETCH NEXT " . intval($limit) . " ROWS ONLY");
    echo "\r\n<table id=\"badges\" class=\"table table-condensed table-hover\">\r\n    <thead>\r\n        <tr>\r\n            <th>#</th>\r\n            <th>Badge</th>\r\n            <th>AccountID</th>\r\n            <th>Character Name</th>\r\n            <th>Guild Name</th>\r\n            <th>Date</th>\r\n            <th>Tooltip</th>\r\n        </tr>\r\n    </thead>\r\n    <tbody>";
    $counter = $page * $limit - $limit + 1;
    foreach ($logs as $thisLog) {
        echo "\r\n        <tr>\r\n            <td>" . $counter . "</td>\r\n            <td><img src=\"" . __PATH_TEMPLATE_ASSETS__ . "badges/" . $thisLog["Image"] . "\"> " . $thisLog["Title"] . "</td>\r\n            <td>" . $thisLog["AccountID"] . "</td>\r\n            <td>" . $thisLog["Name"] . "</td>\r\n            <td>" . $thisLog["G_Name"] . "</td>\r\n            <td>" . date($config["time_date_format"], strtotime($thisLog["Date"])) . "</td>\r\n            <td>" . $thisLog["Tooltip"] . "</td>\r\n        </tr>";
        $counter++;
    }
    echo "    \r\n    </tbody>\r\n</table>\r\n<div class=\"row\">\r\n    <nav aria-label=\"pagination\" class=\"col-xs-12 text-center\">\r\n        <ul class=\"pagination\">";
    $total_items = $dB->query_fetch_single("SELECT COUNT(*) as count FROM IMPERIAMUCMS_BADGES_REWARDS");
    $total_pages = ceil($total_items["count"] / $limit);
    $i = 1;
    while ($i <= $total_pages) {
        if ($i == $_GET["pg"]) {
            echo "<li class=\"active\"><a href=\"" . admincp_base("badges_logs") . "&pg=" . $i . "\">" . $i . " <span class=\"sr-only\">(current)</span></a></li>";
        } else {
            $url = $_SERVER["REQUEST_URI"];
            $filter = substr(strrchr($url, "/"), 1);
            echo "<li><a href=\"" . admincp_base("badges_logs") . "&pg=" . $i . "\">" . $i . "</a></li>";
        }
        $i++;
    }
    echo "\r\n        </ul>\r\n    </nav>\r\n</div>";
}

?>