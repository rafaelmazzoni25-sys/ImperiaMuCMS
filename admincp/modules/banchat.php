<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h1 class=\"page-header\">Ban Chat</h1>\r\n";
if (check_value($_POST["submit_ban"])) {
    try {
        if (!check_value($_POST["ban_char"])) {
            throw new Exception("Please enter the character name.");
        }
        $charExists = $dB->query_fetch_single("SELECT AccountID,Name,CtlCode FROM Character WHERE Name = ?", [$_POST["ban_char"]]);
        if ($charExists["Name"] == NULL) {
            throw new Exception("Invalid character name.");
        }
        if (!check_value($_POST["ban_length"])) {
            throw new Exception("Please enter the amount of hours.");
        }
        if (!Validator::UnsignedNumber($_POST["ban_length"])) {
            throw new Exception("Invalid ban hours.");
        }
        $userID = $common->retrieveUserID($charExists["AccountID"]);
        $accountData = $common->accountInformation($userID);
        if ($_POST["ban_length_type"] == "1") {
            $_POST["ban_length"] = $_POST["ban_length"] * 60;
        } else {
            if ($_POST["ban_length_type"] == "2") {
                $_POST["ban_length"] = $_POST["ban_length"] * 60 * 60;
            } else {
                if ($_POST["ban_length_type"] == "3") {
                    $_POST["ban_length"] = $_POST["ban_length"] * 24 * 60 * 60;
                }
            }
        }
        $newTime = time() + $_POST["ban_length"];
        $banChat = $dB->query("UPDATE Character SET BlockChatTime = ? WHERE Name = ?", [$newTime, $_POST["ban_char"]]);
        if (!$banChat) {
            throw new Exception("Could not ban character.");
        }
        message("success", "Character's chat was successfully banned. Expire on " . date($config["time_date_format_logs"], $newTime));
    } catch (Exception $ex) {
        message("error", $ex->getMessage());
    }
}
echo "<div class=\"row\">\r\n    <div class=\"col-md-6\">\r\n        <form action=\"\" method=\"post\" role=\"form\">\r\n            <div class=\"form-group\">\r\n                <label for=\"char\">Character</label>\r\n                <input type=\"text\" name=\"ban_char\" class=\"form-control\" id=\"acc\">\r\n            </div>\r\n            <div class=\"form-group\">\r\n                <label for=\"ban_length\">Length</label>\r\n                <input type=\"text\" name=\"ban_length\" class=\"form-control\" id=\"ban_length\" value=\"0\">\r\n                <select name=\"ban_length_type\" class=\"form-control\">\r\n                    <option value=\"1\">Minutes</option>\r\n                    <option value=\"2\">Hours</option>\r\n                    <option value=\"3\">Days</option>\r\n                </select>\r\n            </div>\r\n            <input type=\"submit\" name=\"submit_ban\" class=\"btn btn-primary\" value=\"Ban Chat\"/>\r\n        </form>\r\n    </div>\r\n</div>";

?>