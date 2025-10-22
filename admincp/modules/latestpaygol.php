<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h1 class=\"page-header\">PayGol Donations</h1>\r\n";
try {
    $paypalDonations = $dB->query_fetch("SELECT TOP 100 * FROM IMPERIAMUCMS_PG_TRANSACTIONS ORDER BY id DESC");
    if (!is_array($paypalDonations)) {
        throw new Exception("There are no PayGol transactions in the database.");
    }
    echo "<table id=\"paygol_donations\" class=\"table table-condensed table-hover\"><thead><tr><th>Transaction ID</th><th>AccountID</th><th>Price</th><th>Credits</th><th>Service ID</th><th>Operator</th><th>ShortCode</th><th>Keyword</th><th>Message</th><th>Sender</th><th>Country</th><th>Date</th><th>Status</th></tr></thead><tbody>";
    foreach ($paypalDonations as $data) {
        $userData = $common->accountInformation($data["custom"]);
        echo "<tr>";
        echo "<td>" . $data["transaction_id"] . "</td>";
        echo "<td><a href=\"" . admincp_base("accountinfo&id=" . $data["user_id"]) . "\">" . $userData[_CLMN_USERNM_] . "</a></td>";
        echo "<td>" . $data["price"] . " " . $data["currency"] . "</td>";
        echo "<td>" . $data["points"] . "</td>";
        echo "<td>" . $data["service_id"] . "</td>";
        echo "<td>" . $data["operator"] . "</td>";
        echo "<td>" . $data["shortcode"] . "</td>";
        echo "<td>" . $data["keyword"] . "</td>";
        echo "<td>" . $data["message"] . "</td>";
        echo "<td>" . $data["sender"] . "</td>";
        echo "<td>" . $data["country"] . "</td>";
        echo "<td>" . date($config["time_date_format"], $data["transaction_date"]) . "</td>";
        echo "</tr>";
    }
    echo "\r\n\t</tbody>\r\n\t</table>";
} catch (Exception $ex) {
    message("error", $ex->getMessage());
}

?>