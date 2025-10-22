<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */
$General = new xGeneral();
if ($General->ftanHCIfo_canUse_j8GsnawwvJ_Module("networking")) {
    echo "\r\n<div class=\"sub-page-title\">\r\n<div id=\"title\">\r\n<h1>Networking<p></p><span></span></h1>\r\n</div>\r\n</div>\r\n\r\n<div class=\"container_2 account\" align=\"center\">\r\n<div class=\"cont-image\">";
    if (mconfig("active")) {
        $accounts = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_NETWORKING ORDER BY id");
        echo "<div class=\"page-desc-holder\">You can write some description here.</div><div class=\"container_3 account-wide\" style=\"padding:0;\" align=\"center\"><table class=\"general-table-ui\" cellspacing=\"0\"><tr><th>#</th><th>AccountID</th><th>Downline Entry #1</th><th>Downline Entry #2</th><th>Downline Entry #3</th><th>Graduate Status</th></tr>";
        $i = 0;
        foreach ($accounts as $thisAccount) {
            if ($thisAccount["grad_status"] == 0) {
                $reward = "Not Available";
            } else {
                if ($thisAccount["grad_status"] == 1 && $_SESSION["username"] == $thisAccount["AccountID"]) {
                    $reward = "<a href=\"" . __BASE_URL__ . "ticket/new/\">Collect</a>";
                } else {
                    if ($thisAccount["grad_status"] == 2) {
                        $reward = "Claimed";
                    }
                }
            }
            echo "\r\n    <tr>\r\n        <td>" . ($i + 1) . "</td>\r\n        <td>" . $thisAccount["AccountID"] . "</td>\r\n        <td>" . $thisAccount["grad_1"] . "</td>\r\n        <td>" . $thisAccount["grad_2"] . "</td>\r\n        <td>" . $thisAccount["grad_3"] . "</td>\r\n        <td>" . $reward . "</td>\r\n    </tr>";
            $i++;
        }
        echo "</table></div>";
    } else {
        message("error", lang("error_47", true));
    }
    echo "\r\n</div>\r\n</div>\r\n";
} else {
    message("error", "You can't use this module!");
}

?>