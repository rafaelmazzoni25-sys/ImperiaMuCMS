<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h1 class=\"page-header\">PayU.pl Donations</h1>\r\n";
try {
    $donations = $dB->query_fetch("SELECT TOP 100 * FROM IMPERIAMUCMS_PAYU_LOGS ORDER BY id DESC");
    if (!is_array($donations)) {
        throw new Exception("There are no PayU.pl logs in the database.");
    }
    echo "<table id=\"paypal_donations\" class=\"table table-condensed table-hover\"><thead><tr><th>Date</th><th>AccountID</th><th>Amount</th><th>Reward</th><th>SessionID</th><th>Status</th></tr></thead><tbody>";
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
        switch ($data["lastStatus"]) {
            case 1:
                $status = "<span style='border-radius:3px;padding-left:5px;padding-right:5px;padding-top:2px;padding-bottom:2px;color:#FFFFFF;background-color:#000099;font-weight:bold;'>new</span>";
                break;
            case 2:
                $status = "<span style='border-radius:3px;padding-left:5px;padding-right:5px;padding-top:2px;padding-bottom:2px;color:#FFFFFF;background-color:#BB0000;font-weight:bold;'>cancelled</span>";
                break;
            case 3:
                $status = "<span style='border-radius:3px;padding-left:5px;padding-right:5px;padding-top:2px;padding-bottom:2px;color:#FFFFFF;background-color:#BB0000;font-weight:bold;'>rejected</span>";
                break;
            case 4:
                $status = "<span style='border-radius:3px;padding-left:5px;padding-right:5px;padding-top:2px;padding-bottom:2px;color:#FFFFFF;background-color:#000099;font-weight:bold;'>started</span>";
                break;
            case 5:
                $status = "<span style='border-radius:3px;padding-left:5px;padding-right:5px;padding-top:2px;padding-bottom:2px;color:#FFFFFF;background-color:#d27900;font-weight:bold;'>awaiting receipt</span>";
                break;
            case 6:
                $status = "<span style='border-radius:3px;padding-left:5px;padding-right:5px;padding-top:2px;padding-bottom:2px;color:#FFFFFF;background-color:#BB0000;font-weight:bold;'>no authorization</span>";
                break;
            case 7:
                $status = "<span style='border-radius:3px;padding-left:5px;padding-right:5px;padding-top:2px;padding-bottom:2px;color:#FFFFFF;background-color:#BB0000;font-weight:bold;'>payment rejected</span>";
                break;
            case 99:
                $status = "<span style='border-radius:3px;padding-left:5px;padding-right:5px;padding-top:2px;padding-bottom:2px;color:#FFFFFF;background-color:#009900;font-weight:bold;'>payment received - ended</span>";
                break;
            case 888:
                $status = "<span style='border-radius:3px;padding-left:5px;padding-right:5px;padding-top:2px;padding-bottom:2px;color:#FFFFFF;background-color:#BB0000;font-weight:bold;'>incorrect status</span>";
                break;
            default:
                $status = "<span style='border-radius:3px;padding-left:5px;padding-right:5px;padding-top:2px;padding-bottom:2px;color:#FFFFFF;background-color:#BB0000;font-weight:bold;'>unknown</span>";
                if ($data["paymentDate"] == NULL) {
                    $date = $data["createDate"];
                } else {
                    $date = $data["paymentDate"];
                }
                echo "<tr>";
                echo "<td>" . $date . "</td>";
                echo "<td><a href=\"" . admincp_base("accountinfo&id=" . $common->retrieveUserID($data["AccountID"])) . "\">" . $data["AccountID"] . "</a></td>";
                echo "<td>" . sprintf(lang("donation_txt_40", true), number_format($data["amount"], 2, ".", " ")) . "</td>";
                echo "<td>" . $data["reward"] . " " . $data["reward_type"] . "</td>";
                echo "<td>" . $data["id"] . "</td>";
                echo "<td>" . $status . "</td>";
                echo "</tr>";
        }
    }
    echo "\r\n\t</tbody>\r\n\t</table>";
} catch (Exception $ex) {
    message("error", $ex->getMessage());
}

?>