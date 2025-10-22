<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

if (check_value($_POST["add"])) {
    if (check_value($_POST["account"]) && check_value($_POST["moduleName"])) {
        if ($common->userExists($_POST["account"])) {
            if (empty($_POST["expiration"])) {
                $_POST["expiration"] = NULL;
            }
            if (empty($_POST["reason"])) {
                $_POST["reason"] = NULL;
            }
            $query = $dB->query("INSERT INTO IMPERIAMUCMS_ACCESS_RESTRICTION (AccountID, module, expiration, author, date, reason) VALUES (?, ?, ?, ?, ?, ?)", [$_POST["account"], $_POST["moduleName"], $_POST["expiration"], $_SESSION["username"], date("Y-m-d H:i:s", time()), $_POST["reason"]]);
            if ($query) {
                message("success", "Access restriction was successfully created.");
            } else {
                message("error", "Unexpected error occurred.");
            }
        } else {
            message("error", "Account " . $_POST["account"] . " does not exist.");
        }
    } else {
        message("error", "Please enter AccountID and/or module.");
    }
}
if (check_value($_GET["remove"]) && is_numeric($_GET["remove"])) {
    $dB->query("DELETE FROM IMPERIAMUCMS_ACCESS_RESTRICTION WHERE id = ?", [$_GET["remove"]]);
    message("success", "Restriction " . $_GET["remove"] . " was successfully removed.");
}
echo "    <h2>Access Restriction System</h2>\r\n<form method=\"post\" role=\"form\"><table class=\"table table-striped table-bordered table-hover\"><tr><th>AccountID</th><th>Module</th><th>Expiration <small>(Format: YYYY-MM-DD HH:MM:SS)</small></th><th>Reason</th><th></th></tr><tr><td><input type=\"text\" class=\"form-control\" name=\"account\" placeholder=\"AccountID\"></td><td>\r\n<select class=\"form-control\" name=\"moduleName\">\r\n<optgroup label=\"Premium Services\"></optgroup>\r\n<option value=\"donation\">Donation</option>\r\n<option value=\"vip\">Buy VIP</option>\r\n<option value=\"webshop\">Webshop</option>\r\n<option value=\"vote\">Vote</option>\r\n<option value=\"lottery\">Lottery</option>\r\n<option value=\"auction\">Auction</option>\r\n<optgroup label=\"Character Panel\"></optgroup>\r\n<option value=\"reset\">Reset</option>\r\n<option value=\"greset\">Grand Reset</option>\r\n<option value=\"addstats\">Add Stats</option>\r\n<option value=\"resetstats\">Reset Stats</option>\r\n<option value=\"dualstats\">Dual Stats</option>\r\n<option value=\"clearskills\">Reset Skills</option>\r\n<option value=\"clearskilltree\">Reset Skill Tree</option>\r\n<option value=\"dualskilltreee\">Dual Skill Tree</option>\r\n<option value=\"unstuck\">Unstuck</option>\r\n<option value=\"clearpk\">Clear PK</option>\r\n<option value=\"clearinv\">Clear Inventory</option>\r\n<option value=\"achievements\">Achievements</option>\r\n<optgroup label=\"Game Panel\"></optgroup>\r\n<option value=\"exchange\">Exchange</option>\r\n<option value=\"market\">Market</option>\r\n<option value=\"webbank\">Web Bank</option>\r\n<option value=\"vault\">My Vault</option>\r\n<optgroup label=\"Quick Menu\"></optgroup>\r\n<option value=\"promo\">Promo Codes</option>\r\n<option value=\"claimreward\">Claim Reward</option>\r\n<option value=\"balance\">Acount Balance</option>\r\n<option value=\"items\">Items Inventory</option>\r\n<option value=\"ticket\">Support Ticket</option>\r\n<option value=\"bugtracker\">Bug Tracker</option>\r\n<option value=\"recruit\">Recruit Friend</option>\r\n<option value=\"changename\">Rename Character</option>\r\n<option value=\"changeclass\">Change Class</option>\r\n<option value=\"transfercoins\">Transfer Coins</option>\r\n<option value=\"transferchar\">Transfer Character</option>\r\n<option value=\"mypassword\">Change Password</option>\r\n<option value=\"myemail\">Change Email</option>\r\n<option value=\"logs\">Account Activities</option>\r\n</select>\r\n</td><td><input type=\"text\" class=\"form-control\" name=\"expiration\" placeholder=\"Leave empty for permanent ban\"></td><td><input type=\"text\" class=\"form-control\" name=\"reason\" placeholder=\"Reason (optional)\"></td><td><input type=\"submit\" name=\"add\" value=\"Add\" class=\"btn btn-success\"></td></tr></table></form>";
$data = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_ACCESS_RESTRICTION ORDER BY AccountID ASC, date DESC, expiration ASC");
if (is_array($data)) {
    echo "<table class=\"table table-striped table-bordered table-hover\"><tr><th>AccountID</th><th>Module</th><th>Expiration</th><th>Author</th><th>Reason</th><th>Date</th><th></th></tr>";
    foreach ($data as $thisAccess) {
        if (date("Y-m-d H:i:s", time()) < $thisAccess["expiration"] || $thisAccess["expiration"] == NULL) {
            if ($thisAccess["expiration"] == NULL) {
                $thisAccess["expiration"] = "never";
            } else {
                $thisAccess["expiration"] = date($config["time_date_format"], strtotime($thisAccess["expiration"]));
            }
            echo "\r\n        <tr>\r\n            <td>" . $thisAccess["AccountID"] . "</td>\r\n            <td>" . $thisAccess["module"] . "</td>\r\n            <td>" . $thisAccess["expiration"] . "</td>\r\n            <td>" . $thisAccess["author"] . "</td>\r\n            <td>" . $thisAccess["reason"] . "</td>\r\n            <td>" . date($config["time_date_format"], strtotime($thisAccess["date"])) . "</td>\r\n            <td><a href=\"" . admincp_base("accessrestriction") . "&remove=" . $thisAccess["id"] . "\"><button class=\"btn btn-primary\" onclick=\"if(confirm('Do you really want to remove this Restriction Access?')) return true; else return false;\">Remove Restriction</button></a></td>\r\n        </tr>";
        }
    }
    echo "</table>";
} else {
    message("info", "No data found.");
}

?>