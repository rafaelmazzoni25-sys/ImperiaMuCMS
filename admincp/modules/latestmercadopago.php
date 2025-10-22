<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h1 class=\"page-header\">MercadoPago Donations</h1>\n";
try {
    $mercadoPagoDonations = $dB->query_fetch("SELECT TOP 100 * FROM IMPERIAMUCMS_MERCADOPAGO_TRANSACTIONS ORDER BY id DESC");
    echo "    <table id=\"paypal_donations\" class=\"table table-condensed table-hover\">\n        <thead>\n        <tr>\n            <th>Transaction ID</th>\n            <th>Account</th>\n            <th>Amount</th>\n            <th>Reward</th>\n            <th>MercadoPago Email</th>\n            <th>Date</th>\n            <th>Status</th>\n        </tr>\n        </thead>\n        <tbody>\n        ";
    if (is_array($mercadoPagoDonations)) {
        foreach ($mercadoPagoDonations as $data) {
            $userData = $common->accountInformation($data["user_id"]);
            $donation_status = "";
            switch ($data["transaction_status"]) {
                case 1:
                    $donation_status = "<span class=\"badge badge-info\">pending</span>";
                    break;
                case 2:
                    $donation_status = "<span class=\"badge badge-success\">ok</span>";
                    break;
                case 0:
                    $donation_status = "<span class=\"badge badge-important\">reversed</span>";
                    break;
                default:
                    $reward_type = $dB->query_fetch_single("SELECT config_title FROM IMPERIAMUCMS_CREDITS_CONFIG WHERE config_id = ?", [$data["reward_type"]]);
                    echo "<tr>";
                    echo "<td>" . $data["transaction_id"] . "</td>";
                    echo "<td><a href=\"" . admincp_base("accountinfo&id=" . $data["user_id"]) . "\">" . $userData[_CLMN_USERNM_] . "</a></td>";
                    echo "<td>" . number_format($data["payment_amount"], 2) . " " . $data["payment_currency"] . "</td>";
                    echo "<td>" . number_format($data["reward_amount"]) . " " . $reward_type["config_title"] . "</td>";
                    echo "<td>" . $data["mercadopago_email"] . "</td>";
                    echo "<td>" . date($config["time_date_format"], $data["transaction_date"]) . "</td>";
                    echo "<td>" . $donation_status . "</td>";
                    echo "</tr>";
            }
        }
    }
    echo "        </tbody>\n    </table>\n    ";
} catch (Exception $ex) {
    message("error", $ex->getMessage());
}

?>