<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h1 class=\"page-header\">Transfer Account Logs</h1>\r\n";
$totalAccounts = $dB->query_fetch_single("SELECT TOP 100 COUNT(*) as count FROM IMPERIAMUCMS_TRANSFER_ACCOUNT WHERE IsCompleted = '1'");
echo "\r\n<table width=\"100%\">\r\n    <tr>\r\n        <td class=\"btn btn-primary\">Total Accounts transfered: " . $totalAccounts["count"] . "</td>\r\n        <td align=\"right\">\r\n            <a href=\"" . admincp_base("transferaccount_logs&filter=completed") . "\"><button class=\"btn btn-success\">Completed</button></a>\r\n            <a href=\"" . admincp_base("transferaccount_logs&filter=incomplete") . "\"><button class=\"btn btn-info\">Incomplete</button></a>\r\n        </td>\r\n    </tr>\r\n</table>\r\n";
if (isset($_GET["filter"])) {
    switch ($_GET["filter"]) {
        case "completed":
            $logs = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_TRANSFER_ACCOUNT WHERE IsCompleted = '1' ORDER BY CreatedDate DESC");
            break;
        case "incomplete":
            $logs = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_TRANSFER_ACCOUNT WHERE IsCompleted = '0' ORDER BY CreatedDate DESC");
            break;
    }
} else {
    $logs = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_TRANSFER_ACCOUNT ORDER BY CreatedDate DESC");
}
if (is_array($logs)) {
    echo "<table id=\"webshop_logs\" class=\"table display\"><thead><tr><th>Completed Date</th><th>Username</th><th>Email</th><th>Characters</th><th>IP</th><th>Created Date</th></tr></thead><tbody>";
    foreach ($logs as $thisLog) {
        echo "<tr>";
        if ($thisLog["CompletedDate"] == NULL) {
            echo "<td>Not completed</td>";
        } else {
            echo "<td>" . date($config["time_date_format_logs"], strtotime($thisLog["CompletedDate"])) . "</td>";
        }
        echo "<td>Old: " . $thisLog["OldAccountID"] . "<br>New: " . $thisLog["NewAccountID"] . "</td>";
        echo "<td>Old: " . $thisLog["OldEmail"] . "<br>New: " . $thisLog["NewEmail"] . "</td>";
        echo "<td>Old: " . $thisLog["OldName1"] . " " . $thisLog["OldName2"] . " " . $thisLog["OldName3"] . " " . $thisLog["OldName4"] . " " . $thisLog["OldName5"] . "<br>\r\n                  New: " . $thisLog["NewName1"] . " " . $thisLog["NewName2"] . " " . $thisLog["NewName3"] . " " . $thisLog["NewName4"] . " " . $thisLog["NewName5"] . "</td>";
        echo "<td>" . $thisLog["IP"] . "</td>";
        echo "<td>" . date($config["time_date_format_logs"], strtotime($thisLog["CreatedDate"])) . "</td>";
        echo "</tr>";
    }
    echo "</tbody></table>";
}

?>