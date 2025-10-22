<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h1 class=\"page-header\">Unverified Accounts</h1>\r\n";
$data = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_REGISTER_ACCOUNT ORDER BY registration_date DESC");
if (is_array($data)) {
    echo "<table id=\"new_registrations\" class=\"table display\"><thead><tr><th>#</th><th>Username</th><th>Email</th><th>IP</th><th>Date</th><th></th></tr></thead><tbody>";
    $i = 1;
    foreach ($data as $thisAcc) {
        $verificationLink = __BASE_URL__ . "verifyemail/?op=" . Encode_id(2) . "&user=" . Encode($thisAcc["registration_account"]) . "&key=" . $thisAcc["registration_key"];
        echo "<tr>";
        echo "<td>" . $i . "</td>";
        echo "<td>" . $thisAcc["registration_account"] . "</td>";
        echo "<td>" . $thisAcc["registration_email"] . "</td>";
        echo "<td>" . $thisAcc["registration_ip"] . "</td>";
        echo "<td>" . date($config["time_date_format"], $thisAcc["registration_date"]) . "</td>";
        echo "<td style=\"text-align:right;\">";
        echo "<button type=\"button\" class=\"btn btn-xs btn-primary\" data-toggle=\"modal\" data-target=\"#verification" . $i . "\"\">Show Verification Link</button> ";
        echo "<a href=\"" . $verificationLink . "\" target=\"_blank\" class=\"btn btn-xs btn-success\">Verify Account</a>";
        echo "</td></tr>";
        echo "\r\n        <div id=\"verification" . $i . "\" class=\"modal fade\" role=\"dialog\">\r\n            <div class=\"modal-dialog modal-lg\">\r\n                <div class=\"modal-content\">\r\n                    <div class=\"modal-header\">\r\n                        <button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>\r\n                        <h4 class=\"modal-title\">Verification Link for " . $thisAcc["registration_account"] . "</h4>\r\n                    </div>\r\n                    <div class=\"modal-body\">\r\n                        " . $verificationLink . "\r\n                    </div>\r\n                    <div class=\"modal-footer\">\r\n                        <button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>\r\n                        <a href=\"" . $verificationLink . "\" target=\"_blank\" class=\"btn btn-success\">Verify Account</a>\r\n                    </div>\r\n                </div>\r\n            </div>\r\n        </div>";
        $i++;
    }
    echo "</tbody></table>";
}

?>