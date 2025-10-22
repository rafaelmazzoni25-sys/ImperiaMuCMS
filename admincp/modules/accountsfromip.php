<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h1 class=\"page-header\">Find accounts from IP</h1>\r\n    <form class=\"form-inline\" role=\"form\" method=\"post\">\r\n        <div class=\"form-group\">\r\n            <input type=\"text\" class=\"form-control\" id=\"input_1\" name=\"ip_address\" placeholder=\"Ip Address\"/>\r\n        </div>\r\n        <button type=\"submit\" class=\"btn btn-primary\" name=\"search_ip\" value=\"ok\">Search</button>\r\n    </form>\r\n    <br/>\r\n";
if (check_value($_POST["ip_address"])) {
    try {
        if (!Validator::Ip($_POST["ip_address"])) {
            throw new Exception("You have entered an invalid IP address.");
        }
        echo "<h4>Search results for <span style=\"color:red;font-weight:bold;\"><i>" . $_POST["ip_address"] . "</i></span>:</h4>";
        echo "<div class=\"row\"><div class=\"col-md-6\"><div class=\"panel panel-primary\"><div class=\"panel-heading\">MEMB_STAT</div><div class=\"panel-body\">";
        if (config("SQL_USE_2_DB", true)) {
            $membStatData = $dB2->query_fetch("SELECT " . _CLMN_MS_MEMBID_ . " FROM " . _TBL_MS_ . " WHERE " . _CLMN_MS_IP_ . " = ? GROUP BY " . _CLMN_MS_MEMBID_ . "", [$_POST["ip_address"]]);
        } else {
            $membStatData = $dB->query_fetch("SELECT " . _CLMN_MS_MEMBID_ . " FROM " . _TBL_MS_ . " WHERE " . _CLMN_MS_IP_ . " = ? GROUP BY " . _CLMN_MS_MEMBID_ . "", [$_POST["ip_address"]]);
        }
        if (is_array($membStatData)) {
            echo "<table class=\"table table-no-border table-hover\">";
            foreach ($membStatData as $membStatUser) {
                echo "<tr>";
                echo "<td>" . $membStatUser[_CLMN_MS_MEMBID_] . "</td>";
                echo "<td style=\"text-align:right;\"><a href=\"" . admincp_base("accountinfo&id=" . $common->retrieveUserID($membStatUser[_CLMN_MS_MEMBID_])) . "\" class=\"btn btn-xs btn-default\">Account Information</a></td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            message("warning", "No accounts found linked to this Ip.", " ");
        }
        echo "</div></div></div></div>";
    } catch (Exception $ex) {
        message("error", $ex->getMessage());
    }
}

?>