<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h1 class=\"page-header\">NganLuong Donations</h1>\r\n";
try {
    $donations = $dB->query_fetch("SELECT TOP 100 * FROM IMPERIAMUCMS_DONATE_NGANLUONG ORDER BY id DESC");
    if (!is_array($donations)) {
        throw new Exception("There are no NganLuong transactions in the database.");
    }
    echo "<table id=\"paypal_donations\" class=\"table table-condensed table-hover\"><thead><tr><th>Order Code</th><th>Account</th><th>Amount</th><th>Reward</th><th>Date</th><th>Status</th></tr></thead><tbody>";
    foreach ($donations as $data) {
        $user_id = $common->retrieveUserID($data["AccountID"]);
        if ($data["transaction_status"] == "1") {
            $donation_status = "<span class=\"badge badge-primary\">unpaid</span>";
        } else {
            if ($data["transaction_status"] == "2") {
                $donation_status = "<span class=\"badge badge-warning\">paid - seized</span>";
            } else {
                if ($data["transaction_status"] == "3") {
                    $donation_status = "<span class=\"badge badge-danger\">error</span>";
                } else {
                    if ($data["transaction_status"] == "4") {
                        $donation_status = "<span class=\"badge badge-success\">paid</span>";
                    }
                }
            }
        }
        $reward_type = $dB->query_fetch_single("SELECT config_title FROM IMPERIAMUCMS_CREDITS_CONFIG WHERE config_id = ?", [$data["reward_type"]]);
        echo "<tr>";
        echo "<td>" . $data["order_code"] . "</td>";
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