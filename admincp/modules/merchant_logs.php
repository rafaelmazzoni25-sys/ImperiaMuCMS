<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$General = new xGeneral();
if ($General->ftanHCIfo_canUse_j8GsnawwvJ_Module("merchant")) {
    echo "    <h1 class=\"page-header\">Merchant Logs</h1>\r\n    ";
    $logs = $dB->query_fetch("SELECT TOP 100 * FROM IMPERIAMUCMS_MERCHANTS_LOGS ORDER BY id DESC");
    if (is_array($logs)) {
        echo "<table id=\"webshop_logs\" class=\"table display\"><thead><tr><th>Date</th><th>Merchant</th><th>Buyer</th><th>PHP Amount</th><th>Reward</th></tr></thead><tbody>";
        foreach ($logs as $thisLog) {
            echo "<tr>";
            echo "<td>" . date($config["time_date_format_logs"], strtotime($thisLog["date"])) . "</td>";
            echo "<td>" . $thisLog["AccountID"] . "</td>";
            echo "<td>" . $thisLog["buyer"] . "</td>";
            echo "<td>" . number_format($thisLog["amount"]) . "</td>";
            echo "<td>" . number_format($thisLog["reward_wcoin"]) . " WCoinC";
            if (0 < $thisLog["reward_platinum"]) {
                echo ", " . number_format($thisLog["reward_platinum"]) . " Platinum Coins";
            }
            echo "</td></tr>";
        }
        echo "</tbody></table>";
    }
} else {
    message("error", "You can't use this module!");
}

?>