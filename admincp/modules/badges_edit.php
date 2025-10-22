<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$General = new xGeneral();
if (check_value($_POST["activate_module"])) {
    $key = $_POST["license_key"];
    $General->jIhfnHDm_activate_KdiupmNBd_Module("achievements", $key);
}
$isActivated = $General->jHdksHgYYix_isModule_hDbMVOIfs_Activated("badges");
if (!$isActivated && !$General->ftanHCIfo_canUse_j8GsnawwvJ_Module("badges")) {
    echo "\r\n    <form method=\"post\" action=\"\">\r\n        <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n            <tr>\r\n                <th>License Key<br/><span></span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"license_key\" value=\"\" size=\"30\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td colspan=\"2\"><input type=\"submit\" name=\"activate_module\" value=\"Activate Module\" class=\"btn btn-success\"/>\r\n                </td>\r\n            </tr>\r\n        </table>\r\n    </form>";
} else {
    if (check_value($_GET["id"]) && is_numeric($_GET["id"])) {
        if (check_value($_POST["save_badge"])) {
            $id = xss_clean($_POST["badge_id"]);
            $title = xss_clean($_POST["badge_title"]);
            $titleLang = xss_clean($_POST["badge_title_lang"]);
            $image = xss_clean($_POST["badge_image"]);
            $status = xss_clean($_POST["badge_status"]);
            $update = $dB->query("UPDATE IMPERIAMUCMS_BADGES SET Title = ?, TitleLang = ?, Image = ?, Status = ? WHERE id = ?", [$title, $titleLang, $image, $status, $id]);
            $update2 = $dB->query("UPDATE IMPERIAMUCMS_BADGES_REWARDS SET Status = ? WHERE BadgeID = ?", [$status, $id]);
            if ($update) {
                message("success", "Badge was updated successfully.");
            } else {
                message("error", "Badge could not be updated, please check your values.");
            }
        }
        $badgeData = $dB->query_fetch_single("SELECT id, Title, TitleLang, Image, Status FROM IMPERIAMUCMS_BADGES WHERE id = ?", [$_GET["id"]]);
        echo "\r\n<table width=\"100%\" style=\"margin-bottom: 12px;\">\r\n    <tbody>\r\n        <tr>\r\n            <td><h1>Edit Badge</h1></td>\r\n            <td align=\"right\">\r\n                <a class=\"btn btn-primary\" href=\"" . admincp_base("badges_manager") . "\">Badges Manager</a>\r\n            </td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n<form action=\"\" method=\"post\">\r\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n        <tr>\r\n            <th>Title<br/><span>Enter badge's title.</span></th>\r\n            <td><input type=\"text\" name=\"badge_title\" class=\"form-control\" placeholder=\"Title\" value=\"" . $badgeData["Title"] . "\" /></td>\r\n        </tr>\r\n        <tr>\r\n            <th>Title Lang<br/><span>If you want to support different languages, create new language string in your lang file located in languages/xx/language.php.<br>\r\n            Example: \$lang['badge_1'] = 'This can be title of Badge #1';<br>\r\n            Keep in mind that if you want to use single quotes inside text, you must escape it with backslash \"\\\", for example: \$lang['badge_2'] = 'Kundun\\'s Killer Badge';</span></th>\r\n            <td><input type=\"text\" name=\"badge_title_lang\" class=\"form-control\" placeholder=\"badge_1\" value=\"" . $badgeData["TitleLang"] . "\" /></td>\r\n        </tr>\r\n        <tr>\r\n            <th>Image<br/><span>Enter badge's image. Image must be located in templates/assets/badges/. If image name is badge1.png, enter \"badge1.png\".</span></th>\r\n            <td><input type=\"text\" name=\"badge_image\" class=\"form-control\" placeholder=\"badge1.png\" value=\"" . $badgeData["Image"] . "\" /></td>\r\n        </tr>\r\n        <tr>\r\n            <th>Status<br/><span>When badge is inactive, badge will be hidden in player's profile.</span></th>\r\n            <td>";
        enabledisableCheckboxes("badge_status", $badgeData["Status"], "Active", "Inactive");
        echo "\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan=\"2\">\r\n                <input type=\"hidden\" name=\"badge_id\" value=\"" . $badgeData["id"] . "\" />\r\n                <input type=\"submit\" name=\"save_badge\" value=\"Save Badge\" class=\"btn btn-success\" style=\"width: 100%;\"/>\r\n            </td>\r\n        </tr> \r\n    </table>\r\n</form>";
    } else {
        message("error", "Invalid id.");
    }
}

?>