<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */
echo "    <h1 class=\"page-header\">Add Badge to Player</h1>\r\n";
$General = new xGeneral();
if ($General->ftanHCIfo_canUse_j8GsnawwvJ_Module("badges")) {
    if (check_value($_POST["add_badge"])) {
        $charName = xss_clean($_POST["char_name"]);
        $badgeId = xss_clean($_POST["badge_id"]);
        $tooltip = xss_clean($_POST["tooltip"]);
        if ($tooltip == "") {
            $tooltip = NULL;
        }
        if ($badgeId == NULL) {
            message("error", "Please select badge.");
        } else {
            $charData = $dB->query_fetch_single("SELECT AccountID, Name FROM Character WHERE Name = ?", [$charName]);
            if (is_array($charData)) {
                $insert = $dB->query("INSERT INTO IMPERIAMUCMS_BADGES_REWARDS (BadgeID, AccountID, Name, Date, Tooltip) VALUES (?, ?, ?, ?, ?)", [$badgeId, $charData["AccountID"], $charName, date("Y-m-d H:i:s", time()), $tooltip]);
                if ($insert) {
                    message("success", "Badge was added successfully.");
                } else {
                    message("error", "Badge could not be created, please check your values.");
                }
            } else {
                message("error", "Character doesn't exist.");
            }
        }
    }
    $badgesData = $dB->query_fetch("SELECT id, Title FROM IMPERIAMUCMS_BADGES WHERE Status = 1 ORDER BY Title ASC");
    $badgesOpts = "<option value=\"\" disabled selected>Select Badge</option>";
    if (is_array($badgesData)) {
        foreach ($badgesData as $thisBadge) {
            $badgesOpts .= "<option value=\"" . $thisBadge["id"] . "\">" . $thisBadge["Title"] . "</option>";
        }
    }
    echo "\r\n<form action=\"\" method=\"post\">\r\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n        <tr>\r\n            <th>Character Name<br/><span>Enter character's name.</span></th>\r\n            <td><input type=\"text\" name=\"char_name\" class=\"form-control\" placeholder=\"Character Name\" /></td>\r\n        </tr>\r\n        <tr>\r\n            <th>Badge<br/><span>Select badge.</span></th>\r\n            <td>\r\n                <select name=\"badge_id\" class=\"form-control\">\r\n                    " . $badgesOpts . "\r\n                </select>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Tooltip<br/><span>You can write some description which will be displayed in tooltip in player's profile on badge.</span></th>\r\n            <td><textarea name=\"tooltip\" class=\"form-control\"></textarea></td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan=\"2\"><input type=\"submit\" name=\"add_badge\" value=\"Add Badge\" class=\"btn btn-success\" style=\"width: 100%;\"/></td>\r\n        </tr> \r\n    </table>\r\n</form>";
}

?>