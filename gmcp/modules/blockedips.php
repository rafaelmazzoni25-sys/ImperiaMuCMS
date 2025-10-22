<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h1 class=\"page-header\">Block IP Address\r\n        <small>(web)</small>\r\n    </h1>\r\n    <form class=\"form-inline\" role=\"form\" method=\"post\">\r\n        <div class=\"form-group\">\r\n            <input type=\"text\" class=\"form-control\" id=\"input_1\" name=\"ip_address\" placeholder=\"0.0.0.0\"/>\r\n        </div>\r\n        <button type=\"submit\" class=\"btn btn-primary\" name=\"submit_block\" value=\"ok\">Block</button>\r\n    </form>\r\n    <br/>\r\n";
if (check_value($_POST["submit_block"], $_POST["ip_address"])) {
    if ($common->blockIpAddress($_POST["ip_address"], $_SESSION["username"])) {
        message("success", "IP address blocked.");
    } else {
        message("error", "Error blocking IP.");
    }
}
if (check_value($_GET["unblock"])) {
    if ($common->unblockIpAddress($_REQUEST["unblock"])) {
        message("success", "IP address unblocked.");
    } else {
        message("error", "Error unblocking IP.");
    }
}
$blockedIPs = $common->retrieveBlockedIPs();
if (is_array($blockedIPs)) {
    echo "<div class=\"row\"><div class=\"col-md-6\"><table id=\"blocked_ips\" class=\"table table-striped table-condensed table-hover\"><thead><tr><th>IP Address</th><th>Blocked By</th><th>Date Blocked</th><th></th></tr></thead><tbody>";
    foreach ($blockedIPs as $thisIP) {
        echo "<tr>";
        echo "<td>" . $thisIP["block_ip"] . "</td>";
        echo "<td><a href=\"" . gmcp_base("accountinfo&id=" . $common->retrieveUserID($thisIP["block_by"])) . "\">" . $thisIP["block_by"] . "</a></td>";
        echo "<td>" . date($config["time_date_format"], $thisIP["block_date"]) . "</td>";
        echo "<td style=\"text-align:right;\"><a href=\"" . gmcp_base($_REQUEST["module"] . "&unblock=" . $thisIP["id"]) . "\" class=\"btn btn-xs btn-danger\">Lift Block</a></td>";
        echo "</tr>";
    }
    echo "</tbody></table></div></div>";
}

?>