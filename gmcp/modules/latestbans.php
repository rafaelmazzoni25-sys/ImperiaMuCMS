<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h1 class=\"page-header\">Bans</h1>\r\n";
if (check_value($_GET["unblock"])) {
    try {
        if (!Validator::UnsignedNumber($_GET["unblock"])) {
            throw new Exception("Invalid ban id.");
        }
        if ($_GET["type"] == "temp") {
            $banInfo = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_BANS WHERE id = ?", [$_GET["unblock"]]);
        } else {
            if ($_GET["type"] == "perm") {
                $banInfo = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_BAN_LOG WHERE id = ?", [$_GET["unblock"]]);
            }
        }
        if (!is_array($banInfo)) {
            throw new Exception("Ban ID does not exist.");
        }
        if ($common->accountOnline($banInfo["AccountID"])) {
            throw new Exception("The account is online.");
        }
        if ($banInfo["Name"] == NULL) {
            if (config("SQL_USE_2_DB", true)) {
                $unban = $dB2->query("UPDATE " . _TBL_MI_ . " SET " . _CLMN_BLOCCODE_ . " = 0 WHERE " . _CLMN_USERNM_ . " = ?", [$banInfo["AccountID"]]);
            } else {
                $unban = $dB->query("UPDATE " . _TBL_MI_ . " SET " . _CLMN_BLOCCODE_ . " = 0 WHERE " . _CLMN_USERNM_ . " = ?", [$banInfo["AccountID"]]);
            }
            if ($unban) {
                if ($_GET["type"] == "perm") {
                    $dB->query("DELETE FROM IMPERIAMUCMS_BAN_LOG WHERE AccountID = ?", [$banInfo["AccountID"]]);
                } else {
                    $dB->query("DELETE FROM IMPERIAMUCMS_BANS WHERE AccountID = ?", [$banInfo["AccountID"]]);
                }
                message("success", "Account " . $banInfo["AccountID"] . " was successfully unblocked.");
            }
        } else {
            $unban = $dB->query("UPDATE Character SET CtlCode = 0 WHERE AccountID = ? AND Name = ?", [$banInfo["AccountID"], $banInfo["Name"]]);
            if ($unban) {
                if ($_GET["type"] == "perm") {
                    $dB->query("DELETE FROM IMPERIAMUCMS_BAN_LOG WHERE AccountID = ? AND Name = ?", [$banInfo["AccountID"], $banInfo["Name"]]);
                } else {
                    $dB->query("DELETE FROM IMPERIAMUCMS_BANS WHERE AccountID = ? AND Name = ?", [$banInfo["AccountID"], $banInfo["Name"]]);
                }
                message("success", "Character " . $banInfo["Name"] . " was successfully unblocked.");
            }
        }
    } catch (Exception $ex) {
        message("error", $ex->getMessage());
    }
}
echo "<div class=\"row\">\r\n    <div class=\"col-md-12\">\r\n        <div class=\"panel-body\">\r\n            <!-- Nav tabs -->\r\n            <ul class=\"nav nav-tabs\">\r\n                <li class=\"active\"><a href=\"#temp\" data-toggle=\"tab\" aria-expanded=\"true\">Temporal</a>\r\n                </li>\r\n                <li class=\"\"><a href=\"#perm\" data-toggle=\"tab\" aria-expanded=\"false\">Permanent</a>\r\n                </li>\r\n            </ul>\r\n\r\n            ";
message("info", "If column \"Character\" is empty, ban is on account.");
echo "\r\n            <!-- Tab panes -->\r\n            <div class=\"tab-content\">\r\n                <div class=\"tab-pane fade active in\" id=\"temp\"><br/>\r\n                    ";
$tBans = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_BANS WHERE ban_hours > 0 ORDER BY id DESC");
if (is_array($tBans)) {
    echo "<table class=\"table table-condensed\"><thead><tr><th>Account</th><th>Character</th><th>Banned By</th><th>Date</th><th>Length</th><th>Reason</th><th></th></tr></thead><tbody>";
    foreach ($tBans as $temporalBan) {
        echo "<tr>";
        echo "<td>" . $temporalBan["AccountID"] . "</td>";
        echo "<td>" . $common->replaceHtmlSymbols($temporalBan["Name"]) . "</td>";
        echo "<td>" . $temporalBan["banned_by"] . "</td>";
        echo "<td>" . date($config["time_date_format"], $temporalBan["ban_date"]) . "</td>";
        if (24 <= $temporalBan["ban_hours"]) {
            $temporalBan["ban_days"] = floor($temporalBan["ban_hours"] / 24);
            $temporalBan["ban_days"] = $temporalBan["ban_days"] . " day(s)";
        }
        $temporalBan["ban_hours"] = $temporalBan["ban_hours"] % 24;
        $temporalBan["ban_hours"] = $temporalBan["ban_hours"] . " hour(s)";
        echo "<td>" . $temporalBan["ban_days"] . " " . $temporalBan["ban_hours"] . "</td>";
        echo "<td>" . $temporalBan["ban_reason"] . "</td>";
        echo "<td style=\"text-align:right;\">";
        if ($common->accountOnline($temporalBan["AccountID"])) {
            echo "<span class=\"btn btn-success btn-xs\">Online</span> ";
        } else {
            echo "<span class=\"btn btn-danger btn-xs\">Offline</span> ";
        }
        echo "<a href=\"index.php?module=" . $_REQUEST["module"] . "&unblock=" . $temporalBan["id"] . "&type=temp\" class=\"btn btn-danger btn-xs\">Unblock</a></td>";
        echo "</tr>";
    }
    echo "</tbody></table>";
} else {
    message("warning", "There are no temporal bans logged.", " ");
}
echo "                </div>\r\n                <div class=\"tab-pane fade\" id=\"perm\"><br/>\r\n                    ";
$pBans = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_BAN_LOG WHERE ban_type = 'permanent' ORDER BY id DESC");
if (is_array($pBans)) {
    echo "<table class=\"table table-condensed\"><thead><tr><th>Account</th><th>Character</th><th>Banned By</th><th>Date</th><th>Reason</th><th></th></tr></thead><tbody>";
    foreach ($pBans as $permanentBan) {
        echo "<tr>";
        echo "<td>" . $permanentBan["AccountID"] . "</td>";
        echo "<td>" . $common->replaceHtmlSymbols($permanentBan["Name"]) . "</td>";
        echo "<td>" . $permanentBan["banned_by"] . "</td>";
        echo "<td>" . date($config["time_date_format"], $permanentBan["ban_date"]) . "</td>";
        echo "<td>" . $permanentBan["ban_reason"] . "</td>";
        echo "<td style=\"text-align:right;\">";
        if ($common->accountOnline($permanentBan["AccountID"])) {
            echo "<span class=\"btn btn-success btn-xs\">Online</span> ";
        } else {
            echo "<span class=\"btn btn-danger btn-xs\">Offline</span> ";
        }
        echo "<a href=\"index.php?module=" . $_REQUEST["module"] . "&unblock=" . $permanentBan["id"] . "&type=perm\" class=\"btn btn-danger btn-xs\">Unblock</a></td>";
        echo "</tr>";
    }
    echo "</tbody></table>";
} else {
    message("warning", "There are no permanent bans logged.", " ");
}
echo "                </div>\r\n            </div>\r\n        </div>\r\n    </div>\r\n</div>";

?>