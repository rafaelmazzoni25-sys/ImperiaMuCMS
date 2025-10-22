<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h1 class=\"page-header\">Ban HWID</h1>\r\n";
if (check_value($_POST["submit_ban"])) {
    try {
        if (!check_value($_POST["ban_hwid"])) {
            throw new Exception("Please enter HWID.");
        }
        if (100 < strlen($_POST["ban_hwid"]) || 200 < strlen($_POST["ban_note"])) {
            throw new Exception("Invalid length of HWID and/or Note.");
        }
        if (config("SQL_USE_2_DB", true)) {
            $banCheck = $dB2->query_fetch("SELECT HWID, Note FROM IGC_MachineID_Banned WHERE HWID = ?", [$_POST["ban_hwid"]]);
        } else {
            $banCheck = $dB->query_fetch("SELECT HWID, Note FROM IGC_MachineID_Banned WHERE HWID = ?", [$_POST["ban_hwid"]]);
        }
        if (is_array($banCheck)) {
            throw new Exception("HWID [" . $_POST["ban_hwid"] . "] is already blocked.");
        }
        if (config("SQL_USE_2_DB", true)) {
            $insert = $dB2->query("INSERT INTO IGC_MachineID_Banned (HWID, Note) VALUES (?, ?)", [$_POST["ban_hwid"], $_POST["ban_note"]]);
        } else {
            $insert = $dB->query("INSERT INTO IGC_MachineID_Banned (HWID, Note) VALUES (?, ?)", [$_POST["ban_hwid"], $_POST["ban_note"]]);
        }
        if ($insert) {
            message("success", "HWID [" . $_POST["ban_hwid"] . "] was blocked successfully.");
        } else {
            throw new Exception("Insert failed, please contact website developer.");
        }
    } catch (Exception $ex) {
        message("error", $ex->getMessage());
    }
} else {
    if (check_value($_POST["unblock"])) {
        if (!check_value($_POST["hwid"])) {
            throw new Exception("Invalid HWID.");
        }
        if (config("SQL_USE_2_DB", true)) {
            $banCheck = $dB2->query_fetch("SELECT HWID, Note FROM IGC_MachineID_Banned WHERE HWID = ?", [$_POST["hwid"]]);
        } else {
            $banCheck = $dB->query_fetch("SELECT HWID, Note FROM IGC_MachineID_Banned WHERE HWID = ?", [$_POST["hwid"]]);
        }
        if (is_array($banCheck)) {
            if (config("SQL_USE_2_DB", true)) {
                $delete = $dB2->query("DELETE FROM IGC_MachineID_Banned WHERE HWID = ?", [$_POST["hwid"]]);
            } else {
                $delete = $dB->query("DELETE FROM IGC_MachineID_Banned WHERE HWID = ?", [$_POST["hwid"]]);
            }
            if ($delete) {
                message("success", "HWID [" . $_POST["hwid"] . "] was successfully unblocked.");
            } else {
                message("error", "Unexpected error occurred, please contact website developer.");
            }
        } else {
            message("error", "HWID [" . $_POST["hwid"] . "] is not blocked.");
        }
    }
}
echo "<div class=\"row\">\r\n    <div class=\"col-md-6\">\r\n        <form action=\"\" method=\"post\" role=\"form\">\r\n            <div class=\"form-group\">\r\n                <label for=\"hwid\">HWID</label>\r\n                <input type=\"text\" name=\"ban_hwid\" class=\"form-control\" id=\"hwid\" maxlength=\"100\">\r\n            </div>\r\n            <div class=\"form-group\">\r\n                <label for=\"ban_note\">Note (Optional)</label>\r\n                <input type=\"text\" name=\"ban_note\" class=\"form-control\" id=\"note\" value=\"\" placeholder=\"Ban Note\" maxlength=\"200\">\r\n            </div>\r\n            <input type=\"submit\" name=\"submit_ban\" class=\"btn btn-primary\" value=\"Ban HWID\"/>\r\n        </form>\r\n    </div>\r\n</div>\r\n\r\n<h1 class=\"page-header\">Active HWID Bans</h1>\r\n<div class=\"row\">\r\n    <div class=\"col-md-12\">\r\n        <form action=\"\" method=\"post\" role=\"form\">\r\n            <table class=\"table table-striped table-hover\">\r\n                <thead>\r\n                <tr>\r\n                    <th>HWID</th>\r\n                    <th>Note</th>\r\n                    <th>Action</th>\r\n                </tr>\r\n                </thead>\r\n                <tbody>\r\n                ";
if (config("SQL_USE_2_DB", true)) {
    $hwidBans = $dB2->query_fetch("SELECT * FROM IGC_MachineID_Banned");
} else {
    $hwidBans = $dB->query_fetch("SELECT * FROM IGC_MachineID_Banned");
}
if (is_array($hwidBans)) {
    foreach ($hwidBans as $thisBan) {
        echo "\r\n                        <tr>\r\n                            <td>" . $thisBan["HWID"] . "</td>\r\n                            <td>" . $thisBan["Note"] . "</td>\r\n                            <td>\r\n                                <form method=\"post\">\r\n                                    <input type=\"hidden\" name=\"hwid\" value=\"" . $thisBan["HWID"] . "\" />\r\n                                    <input type=\"submit\" name=\"unblock\" value=\"Unblock\" class=\"btn btn-danger btn-xs\" />\r\n                                </form>\r\n                            </td>\r\n                        </tr>";
    }
} else {
    echo "<tr><td colspan=\"3\">";
    message("info", "No HWID bans found.");
    echo "</td></tr>";
}
echo "                </tbody>\r\n            </table>\r\n        </form>\r\n    </div>\r\n</div>";

?>