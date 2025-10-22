<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h1 class=\"page-header\">Pay.nl Donations</h1>\r";
try {
    $srDonations = $dB->query_fetch("SELECT TOP 100 * FROM IMPERIAMUCMS_PAYNL_TRANSACTIONS ORDER BY id DESC");
    if (!is_array($srDonations)) {
        throw new Exception("There are no Pay.nl transactions in the database.");
    }
    echo "<table id=\"paynl_donations\" class=\"table table-condensed table-hover\"><thead><tr><th>Transaction ID</th><th>Account</th><th>Amount (credits)</th><th>Type</th><th>Date</th></tr></thead><tbody>";
    foreach ($srDonations as $data) {
        $userData = $common->accountInformation($data["user_id"]);
        echo "<tr>";
        echo "<td>" . $data["transaction_id"] . "</td>";
        echo "<td><a href=\"" . admincp_base("accountinfo&id=" . $data["user_id"]) . "\">" . $userData[_CLMN_USERNM_] . "</a></td>";
        echo "<td>" . $data["credits_amount"] . "</td>";
        echo "<td>" . $data["type"] . "</td>";
        echo "<td>" . date($config["time_date_format"], $data["transaction_date"]) . "</td>";
        echo "</tr>";
    }
    echo "</tbody></table>";
} catch (Exception $ex) {
    message("error", $ex->getMessage());
}

?>