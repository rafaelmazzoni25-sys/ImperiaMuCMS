<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h1 class=\"page-header\">Interkassa Donations</h1>\r\n";
try {
    $donations = $dB->query_fetch("SELECT TOP 100 * FROM IMPERIAMUCMS_DONATE_INTERKASSA ORDER BY id DESC");
    if (!is_array($donations)) {
        throw new Exception("There are no Interkassa transactions in the database.");
    }
    echo "<table id=\"paypal_donations\" class=\"table table-condensed table-hover\"><thead><tr><th>Payment ID</th><th>Account</th><th>Amount</th><th>Reward</th><th>Date</th><th>Status</th></tr></thead><tbody>";
    foreach ($donations as $data) {
        $user_id = $common->retrieveUserID($data["AccountID"]);
        $donation_status = $data["status"] == "1" ? "<span class=\"badge badge-success\">success</span>" : "<span class=\"badge badge-primary\">pending</span>";
        $reward_type = $dB->query_fetch_single("SELECT config_title FROM IMPERIAMUCMS_CREDITS_CONFIG WHERE config_id = ?", [$data["reward_type"]]);
        echo "<tr>";
        echo "<td>" . $data["payment_id"] . "</td>";
        echo "<td><a href=\"" . admincp_base("accountinfo&id=" . $user_id) . "\">" . $data["AccountID"] . "</a></td>";
        echo "<td>" . number_format($data["amount"], 2) . " " . $data["amount_currency"] . "</td>";
        echo "<td>" . number_format($data["reward"]) . " " . $reward_type["config_title"] . "</td>";
        echo "<td>" . date($config["time_date_format"], strtotime($data["date"])) . "</td>";
        echo "<td>" . $donation_status . "</td>";
        echo "</tr>";
    }
    echo "\r\n\t</tbody>\r\n\t</table>";
} catch (Exception $ex) {
    message("error", $ex->getMessage());
}

?>