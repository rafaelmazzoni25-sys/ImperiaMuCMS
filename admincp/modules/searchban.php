<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h1 class=\"page-header\">Search Ban</h1>\r\n<form class=\"form-inline\" role=\"form\" method=\"post\">\r\n    <div class=\"form-group\">\r\n        <input type=\"text\" class=\"form-control\" id=\"input_1\" name=\"search_acc\" placeholder=\"Account username\"/>\r\n    </div>\r\n    <button type=\"submit\" class=\"btn btn-primary\" name=\"search_ban_acc\" value=\"ok\">Search</button>\r\n    <br/><br/>\r\n    <div class=\"form-group\">\r\n        <input type=\"text\" class=\"form-control\" id=\"input_2\" name=\"search_char\" placeholder=\"Character name\"/>\r\n    </div>\r\n    <button type=\"submit\" class=\"btn btn-primary\" name=\"search_ban_char\" value=\"ok\">Search</button>\r\n</form>\r\n<br/>\r\n";
if (check_value($_POST["search_ban_acc"])) {
    try {
        $search = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_BAN_LOG WHERE AccountID LIKE '%" . $_POST["search_acc"] . "%'");
        if (is_array($search)) {
            echo "<div class=\"row\"><div class=\"col-md-12\"><table class=\"table table-striped table-condensed table-hover\"><thead><tr>";
            echo "<th colspan=\"6\">Search Results for <span style=\"color:red;\"><i>" . $_POST["search_acc"] . "</i></span></th>";
            echo "</tr></thead><thead><tr><th>Account</th><th>Character</th><th>Banned By</th><th>Type</th><th>Date</th><th>Length</th><th></th></tr></thead><tbody>";
            foreach ($search as $ban) {
                $banType = $ban["ban_type"] == "temporal" ? "<span class=\"label label-default\">Temporal</span>" : "<span class=\"label label-danger\">Permanent</span>";
                echo "<tr>";
                echo "<td><a href=\"" . admincp_base("accountinfo&id=" . $common->retrieveUserID($ban["AccountID"])) . "\">" . $ban["AccountID"] . "</a></td>";
                echo "<td>" . $ban["name"] . "</td>";
                echo "<td><a href=\"" . admincp_base("accountinfo&id=" . $common->retrieveUserID($ban["banned_by"])) . "\">" . $ban["banned_by"] . "</a></td>";
                echo "<td>" . $banType . "</td>";
                echo "<td>" . date($config["time_date_format"], $ban["ban_date"]) . "</td>";
                if (24 <= $ban["ban_hours"]) {
                    $ban["ban_days"] = floor($ban["ban_hours"] / 24);
                    $ban["ban_days"] = $ban["ban_days"] . " day(s)";
                }
                $ban["ban_hours"] = $ban["ban_hours"] % 24;
                $ban["ban_hours"] = $ban["ban_hours"] . " hour(s)";
                echo "<td>" . $ban["ban_days"] . " " . $ban["ban_hours"] . "</td>";
                echo "<td style=\"text-align:right;\"><a href=\"#\" class=\"btn btn-default btn-xs\" title=\"" . $ban["ban_reason"] . "\">Reason</a> <a href=\"index.php?module=latestbans&liftban=" . $ban["id"] . "\" class=\"btn btn-danger btn-xs\">Lift Ban</a></td>";
                echo "</tr>";
            }
            echo "</tbody></table></div></div>";
        } else {
            throw new Exception("No results found.");
        }
    } catch (Exception $ex) {
        message("error", $ex->getMessage());
    }
} else {
    if (check_value($_POST["search_ban_char"])) {
        try {
            $search = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_BAN_LOG WHERE name LIKE '%" . $_POST["search_char"] . "%'");
            if (is_array($search)) {
                echo "<div class=\"row\"><div class=\"col-md-12\"><table class=\"table table-striped table-condensed table-hover\"><thead><tr>";
                echo "<th colspan=\"6\">Search Results for <span style=\"color:red;\"><i>" . $_POST["search_char"] . "</i></span></th>";
                echo "</tr></thead><thead><tr><th>Account</th><th>Character</th><th>Banned By</th><th>Type</th><th>Date</th><th>Length/th><th></th></tr></thead><tbody>";
                foreach ($search as $ban) {
                    $banType = $ban["ban_type"] == "temporal" ? "<span class=\"label label-default\">Temporal</span>" : "<span class=\"label label-danger\">Permanent</span>";
                    echo "<tr>";
                    echo "<td><a href=\"" . admincp_base("accountinfo&id=" . $common->retrieveUserID($ban["AccountID"])) . "\">" . $ban["AccountID"] . "</a></td>";
                    echo "<td>" . $ban["name"] . "</td>";
                    echo "<td><a href=\"" . admincp_base("accountinfo&id=" . $common->retrieveUserID($ban["banned_by"])) . "\">" . $ban["banned_by"] . "</a></td>";
                    echo "<td>" . $banType . "</td>";
                    echo "<td>" . date($config["time_date_format"], $ban["ban_date"]) . "</td>";
                    if (24 <= $ban["ban_hours"]) {
                        $ban["ban_days"] = floor($ban["ban_hours"] / 24);
                        $ban["ban_days"] = $ban["ban_days"] . " day(s)";
                    }
                    $ban["ban_hours"] = $ban["ban_hours"] % 24;
                    $ban["ban_hours"] = $ban["ban_hours"] . " hour(s)";
                    echo "<td>" . $ban["ban_days"] . " " . $ban["ban_hours"] . "</td>";
                    echo "<td style=\"text-align:right;\"><a href=\"#\" class=\"btn btn-default btn-xs\" title=\"" . $ban["ban_reason"] . "\">Reason</a> <a href=\"index.php?module=latestbans&liftban=" . $ban["id"] . "\" class=\"btn btn-danger btn-xs\">Lift Ban</a></td>";
                    echo "</tr>";
                }
                echo "</tbody></table></div></div>";
            } else {
                throw new Exception("No results found.");
            }
        } catch (Exception $ex) {
            message("error", $ex->getMessage());
        }
    }
}
echo "\r\n";

?>