<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */
echo "    <h2>MU Lords Donation</h2>\r\n";
if (check_value($_POST["add_submit"])) {
    $username = htmlspecialchars($_POST["username"]);
    $amount = htmlspecialchars($_POST["amount"]);
    $currency = htmlspecialchars($_POST["currency"]);
    if (config("SQL_USE_2_DB", true)) {
        $check = $dB2->query_fetch_single("SELECT memb___id FROM MEMB_INFO WHERE memb___id = ?", [$username]);
    } else {
        $check = $dB->query_fetch_single("SELECT memb___id FROM MEMB_INFO WHERE memb___id = ?", [$username]);
    }
    if ($check["memb___id"] == NULL) {
        message("error", "AccountID " . $username . " does not exist.");
    } else {
        $insert = $dB->query("INSERT INTO IMPERIAMUCMS_MU_LORDS_DONATION (AccountID, amount, currency, date) VALUES(?, ?, ?, ?)", [$username, $amount, $currency, date("Y-m-d H:i:s", time())]);
        if ($insert) {
            message("success", "Donation was successfully created.");
        } else {
            message("error", "Donation could not be created, please check your values.");
        }
    }
}
if (check_value($_GET["delete"])) {
    $id = htmlspecialchars($_GET["delete"]);
    $delete = $dB->query("DELETE FROM IMPERIAMUCMS_MU_LORDS_DONATION WHERE id = ?", [$id]);
    if ($delete) {
        message("success", "Donation was successfully deleted.");
    } else {
        message("error", "Donation does not exist.");
    }
}
echo "<hr>\r\n<h3>Add New Donation</h3><table class=\"table table-striped table-bordered table-hover\"><tr><th>AccountID</th><th>Donation Amount</th><th>Currency</th><th></th></tr><form action=\"index.php?module=mulords_donation\" method=\"post\"><tr><td><input name=\"username\" class=\"form-control\" type=\"text\" value=\"\" /></td><td><input name=\"amount\" class=\"form-control\" type=\"text\" value=\"\" /></td><td><input name=\"currency\" class=\"form-control\" type=\"text\" value=\"\" /></td><td>\r\n        <input type=\"submit\" class=\"btn btn-success\" name=\"add_submit\" value=\"Add\"/>\r\n      </td></tr></form></table><hr>\r\n<h3>Donations</h3><table class=\"table table-striped table-bordered table-hover\"><tr><th>Date</th><th>AccountID</th><th>Donation Amount</th><th></th></tr>";
$donations = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_MU_LORDS_DONATION ORDER BY date DESC");
foreach ($donations as $thisDonation) {
    echo "<tr>";
    echo "<td>" . $thisDonation["date"] . "</td>";
    echo "<td>" . $thisDonation["AccountID"] . "</td>";
    echo "<td>" . $thisDonation["amount"] . " " . $thisDonation["currency"] . "</td>";
    echo "<td>\r\n            <a href=\"index.php?module=mulords_donation&delete=" . $thisDonation["id"] . "\" class=\"btn btn-danger\"><i class=\"fa fa-remove\"></i></a>\r\n          </td>";
    echo "</tr>";
}
echo "</table>";

?>