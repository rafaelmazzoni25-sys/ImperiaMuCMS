<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h1 class=\"page-header\">Homepay.pl Donations</h1>\r\n";
try {
    $donations = $dB->query_fetch("SELECT TOP 100 * FROM IMPERIAMUCMS_HOMEPAYPL_LOGS ORDER BY id DESC");
    if (!is_array($donations)) {
        throw new Exception("There are no Homepay.pl logs in the database.");
    }
    echo "<table id=\"paypal_donations\" class=\"table table-condensed table-hover\"><thead><tr><th>Date</th><th>AccountID</th><th>Netto (Brutto)</th><th>Reward</th><th>ID</th></tr></thead><tbody>";
    foreach ($donations as $data) {
        if ($data["reward_type"] == "1") {
            $data["reward_type"] = lang("currency_platinum", true);
        } else {
            if ($data["reward_type"] == "2") {
                $data["reward_type"] = lang("currency_gold", true);
            } else {
                if ($data["reward_type"] == "3") {
                    $data["reward_type"] = lang("currency_silver", true);
                } else {
                    if ($data["reward_type"] == "4") {
                        $data["reward_type"] = lang("currency_wcoinc", true);
                    } else {
                        if ($data["reward_type"] == "5") {
                            $data["reward_type"] = lang("currency_gp", true);
                        } else {
                            if ($data["reward_type"] == "6") {
                                $data["reward_type"] = "Zen";
                            }
                        }
                    }
                }
            }
        }
        echo "<tr>";
        echo "<td>" . $data["date"] . "</td>";
        echo "<td><a href=\"" . admincp_base("accountinfo&id=" . $common->retrieveUserID($data["AccountID"])) . "\">" . $data["AccountID"] . "</a></td>";
        echo "<td>" . $data["netto"] . " (" . $data["brutto"] . ")</td>";
        echo "<td>" . $data["reward"] . " " . $data["reward_type"] . "</td>";
        echo "<td>" . $data["acc_id"] . "</td>";
        echo "</tr>";
    }
    echo "\r\n\t</tbody>\r\n\t</table>";
} catch (Exception $ex) {
    message("error", $ex->getMessage());
}

?>