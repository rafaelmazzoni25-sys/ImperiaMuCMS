<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h1 class=\"page-header\">Badges Manager</h1>\r\n";
$General = new xGeneral();
if (check_value($_POST["activate_module"])) {
    $key = $_POST["license_key"];
    $General->jIhfnHDm_activate_KdiupmNBd_Module("achievements", $key);
}
$isActivated = $General->jHdksHgYYix_isModule_hDbMVOIfs_Activated("badges");
if (!$isActivated && !$General->ftanHCIfo_canUse_j8GsnawwvJ_Module("badges")) {
    echo "\r\n    <form method=\"post\" action=\"\">\r\n        <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n            <tr>\r\n                <th>License Key<br/><span></span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"license_key\" value=\"\" size=\"30\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td colspan=\"2\"><input type=\"submit\" name=\"activate_module\" value=\"Activate Module\" class=\"btn btn-success\"/>\r\n                </td>\r\n            </tr>\r\n        </table>\r\n    </form>";
} else {
    if ($General->ftanHCIfo_canUse_j8GsnawwvJ_Module("badges")) {
        if (check_value($_POST["add_badge"])) {
            $title = xss_clean($_POST["badge_title"]);
            $titleLang = xss_clean($_POST["badge_title_lang"]);
            $image = xss_clean($_POST["badge_image"]);
            $insert = $dB->query("INSERT INTO IMPERIAMUCMS_BADGES (Title, TitleLang, Image, Type1, Type2) VALUES (?, ?, ?, ?, ?)", [$title, $titleLang, $image, 0, 0]);
            if ($insert) {
                message("success", "Badge was created successfully.");
            } else {
                message("error", "Badge could not be created, please check your values.");
            }
        }
        if (check_value($_GET["delete"]) && is_numeric($_GET["delete"])) {
            $delete = $dB->query("DELETE FROM IMPERIAMUCMS_BADGES WHERE id = ?", [$_GET["delete"]]);
            if ($delete) {
                message("success", "Badge was deleted successfully.");
            } else {
                message("error", "Badge couldn't be deleted, please check SQL logs.");
            }
        }
        echo "\r\n<h3>Add New Badge</h3>\r\n<form action=\"\" method=\"post\">\r\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n        <tr>\r\n            <th>Title<br/><span>Enter badge's title.</span></th>\r\n            <td><input type=\"text\" name=\"badge_title\" class=\"form-control\" placeholder=\"Title\" /></td>\r\n        </tr>\r\n        <tr>\r\n            <th>Title Lang<br/><span>If you want to support different languages, create new language string in your lang file located in languages/xx/language.php.<br>\r\n            Example: \$lang['badge_1'] = 'This can be title of Badge #1';<br>\r\n            Keep in mind that if you want to use single quotes inside text, you must escape it with backslash \"\\\", for example: \$lang['badge_2'] = 'Kundun\\'s Killer Badge';</span></th>\r\n            <td><input type=\"text\" name=\"badge_title_lang\" class=\"form-control\" placeholder=\"badge_1\" /></td>\r\n        </tr>\r\n        <tr>\r\n            <th>Image<br/><span>Enter badge's image. Image must be located in templates/assets/badges/. If image name is badge1.png, enter \"badge1.png\".<br>\r\n            If you want to display badge's image in tooltip, copy image with same name to templates/assets/badges/tooltip (image can be bigger, but name must be the same).</span></th>\r\n            <td><input type=\"text\" name=\"badge_image\" class=\"form-control\" placeholder=\"badge1.png\" /></td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan=\"2\"><input type=\"submit\" name=\"add_badge\" value=\"Add Badge\" class=\"btn btn-success\" style=\"width: 100%;\"/></td>\r\n        </tr> \r\n    </table>\r\n</form>\r\n<hr>\r\n<h3>Badges Management</h3>";
    }
    $badgesData = $dB->query_fetch("SELECT id, Title, TitleLang, Image, Status FROM IMPERIAMUCMS_BADGES ORDER BY Title ASC");
    echo "\r\n<table id=\"badges\" class=\"table table-condensed table-hover\">\r\n    <thead>\r\n        <tr>\r\n            <th>#</th>\r\n            <th>Title</th>\r\n            <th>Title Lang</th>\r\n            <th>Image</th>\r\n            <th>Image Preview</th>\r\n            <th>Status</th>\r\n            <th>Action</th>\r\n        </tr>\r\n    </thead>\r\n    <tbody>";
    $counter = 1;
    foreach ($badgesData as $thisBadge) {
        $status = "";
        if ($thisBadge["Status"] == "1") {
            $status = "<span class=\"label label-success\">Active</span>";
        } else {
            $status = "<span class=\"label label-danger\">Inactive</span>";
        }
        echo "\r\n        <tr>\r\n            <td>" . $counter . "</td>\r\n            <td>" . $thisBadge["Title"] . "</td>\r\n            <td>" . $thisBadge["TitleLang"] . "</td>\r\n            <td>" . $thisBadge["Image"] . "</td>\r\n            <td><img src=\"" . __PATH_TEMPLATE_ASSETS__ . "badges/" . $thisBadge["Image"] . "\"></td>\r\n            <td>" . $status . "</td>\r\n            <td>\r\n                <a class=\"btn btn-default btn-sm\" href=\"" . admincp_base("badges_edit&id=" . $thisBadge["id"]) . "\"><i class=\"fa fa-edit\"></i> Edit</a>\r\n                <a class=\"btn btn-danger btn-sm\" href=\"" . admincp_base("badges_manager&delete=" . $thisBadge["id"]) . "\" onclick=\"if (confirm('Do you really want to delete badge " . $thisBadge["Title"] . "?')) return true; else return false;\"><i class=\"fa fa-trash-o\"></i> Delete</a>\r\n            </td>\r\n        </tr>";
        $counter++;
    }
    echo "    \r\n    </tbody>\r\n</table>";
}

?>