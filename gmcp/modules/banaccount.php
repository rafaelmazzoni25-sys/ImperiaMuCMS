<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h1 class=\"page-header\">Ban Account</h1>\r\n";
if (check_value($_POST["submit_ban"])) {
    try {
        if (!check_value($_POST["ban_account"])) {
            throw new Exception("Please enter the account username.");
        }
        if (!$common->userExists($_POST["ban_account"])) {
            throw new Exception("Invalid account username.");
        }
        if (!check_value($_POST["ban_hours"])) {
            throw new Exception("Please enter the amount of hours.");
        }
        if (!Validator::UnsignedNumber($_POST["ban_hours"])) {
            throw new Exception("Invalid ban hours.");
        }
        if (check_value($_POST["ban_reason"]) && !Validator::Length($_POST["ban_reason"], 100, 1)) {
            throw new Exception("Invalid ban reason.");
        }
        if ($common->accountOnline($_POST["ban_account"])) {
            throw new Exception("The account is currently online.");
        }
        $userID = $common->retrieveUserID($_POST["ban_account"]);
        $accountData = $common->accountInformation($userID);
        if ($accountData[_CLMN_BLOCCODE_] == 1) {
            throw new Exception("This account is already banned.");
        }
        $banType = 1 <= $_POST["ban_hours"] ? "temporal" : "permanent";
        if ($_POST["length"] == "2") {
            $_POST["ban_hours"] = $_POST["ban_hours"] * 24;
        }
        $banLogData = ["acc" => $_POST["ban_account"], "by" => $_SESSION["username"], "type" => $banType, "date" => time(), "length" => $_POST["ban_hours"], "reason" => check_value($_POST["ban_reason"]) ? $_POST["ban_reason"] : ""];
        $logBan = $dB->query("INSERT INTO IMPERIAMUCMS_BAN_LOG (AccountID, banned_by, ban_type, ban_date, ban_hours, ban_reason) VALUES (:acc, :by, :type, :date, :length, :reason)", $banLogData);
        if (!$logBan) {
            throw new Exception("Could not log ban (check tables)[1].");
        }
        if ($banType == "temporal") {
            $tempBanData = ["acc" => $_POST["ban_account"], "by" => $_SESSION["username"], "date" => time(), "length" => $_POST["ban_hours"], "reason" => check_value($_POST["ban_reason"]) ? $_POST["ban_reason"] : ""];
            $tempBan = $dB->query("INSERT INTO IMPERIAMUCMS_BANS (AccountID, banned_by, ban_date, ban_hours, ban_reason) VALUES (:acc, :by, :date, :length, :reason)", $tempBanData);
            if (!$tempBan) {
                throw new Exception("Could not add temporal ban (check tables)[2]. - " . $dB->error);
            }
        }
        $db = config("SQL_USE_2_DB", true) ? $dB2 : $dB;
        $banAccount = $db->query("UPDATE " . _TBL_MI_ . " SET " . _CLMN_BLOCCODE_ . " = ? WHERE " . _CLMN_USERNM_ . " = ?", [1, $_POST["ban_account"]]);
        if (!$banAccount) {
            throw new Exception("Could not ban account.");
        }
        message("success", "Account Banned");
    } catch (Exception $ex) {
        message("error", $ex->getMessage());
    }
}
echo "<div class=\"row\">\r\n    <div class=\"col-md-6\">\r\n        <form action=\"\" method=\"post\" role=\"form\">\r\n            <div class=\"form-group\">\r\n                <label for=\"acc\">Account</label>\r\n                <input type=\"text\" name=\"ban_account\" class=\"form-control\" id=\"acc\">\r\n            </div>\r\n            <div class=\"form-group\">\r\n                <label for=\"hours\">Length (0 for permanent ban)</label>\r\n                <input type=\"text\" name=\"ban_hours\" class=\"form-control\" id=\"hours\" value=\"0\">\r\n                <select name=\"length\" class=\"form-control\">\r\n                    <option value=\"1\">Hours</option>\r\n                    <option value=\"2\">Days</option>\r\n                </select>\r\n            </div>\r\n            <div class=\"form-group\">\r\n                <label for=\"reason\">Reason (optional)</label>\r\n                <input type=\"text\" name=\"ban_reason\" class=\"form-control\" id=\"reason\">\r\n            </div>\r\n            <input type=\"submit\" name=\"submit_ban\" class=\"btn btn-primary\" value=\"Ban Account\"/>\r\n        </form>\r\n    </div>\r\n</div>";

?>