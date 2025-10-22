<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h1 class=\"page-header\">Vote Logs</h1>\r\n";
$logs = $dB->query_fetch("SELECT TOP 100 * FROM IMPERIAMUCMS_VOTE_LOGS ORDER BY id DESC");
if (is_array($logs)) {
    echo "<table id=\"webshop_logs\" class=\"table display\"><thead><tr><th>Date</th><th>AccountID</th><th>Vote Site</th><th>IP</th><th>Error Code</th></tr></thead><tbody>";
    foreach ($logs as $thisLog) {
        if (config("SQL_USE_2_DB", true)) {
            $username = $dB2->query_fetch_single("SELECT memb___id FROM MEMB_INFO WHERE memb_guid = ?", [$thisLog["user_id"]]);
        } else {
            $username = $dB->query_fetch_single("SELECT memb___id FROM MEMB_INFO WHERE memb_guid = ?", [$thisLog["user_id"]]);
        }
        $votename = $dB->query_fetch_single("SELECT votesite_title FROM IMPERIAMUCMS_VOTE_SITES WHERE votesite_id = ?", [$thisLog["vote_site_id"]]);
        echo "<tr>";
        echo "<td>" . date("Y-m-d H:i:s", $thisLog["timestamp"]) . "</td>";
        echo "<td>" . $username["memb___id"] . "</td>";
        echo "<td>" . $votename["votesite_title"] . "</td>";
        echo "<td>" . $thisLog["user_ip"] . "</td>";
        echo "<td>" . $thisLog["error_code"] . "</td>";
        echo "</tr>";
    }
    echo "</tbody></table>";
}

?>