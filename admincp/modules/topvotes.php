<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h2>Top Voters</h2>\r\n";
$month0_first = date("Y-m-01 00:00:00", time());
$month0_last = date("Y-m-t 00:00:00", time());
$month0_name = date("Y F", time());
$month1_first = date("Y-m-01 00:00:00", strtotime("-1 month"));
$month1_last = date("Y-m-t 00:00:00", strtotime("-1 month"));
$month1_name = date("Y F", strtotime("-1 month"));
$month2_first = date("Y-m-01 00:00:00", strtotime("-2 month"));
$month2_last = date("Y-m-t 00:00:00", strtotime("-2 month"));
$month2_name = date("Y F", strtotime("-2 month"));
$month3_first = date("Y-m-01 00:00:00", strtotime("-3 month"));
$month3_last = date("Y-m-t 00:00:00", strtotime("-3 month"));
$month3_name = date("Y F", strtotime("-3 month"));
$month4_first = date("Y-m-01 00:00:00", strtotime("-4 month"));
$month4_last = date("Y-m-t 00:00:00", strtotime("-4 month"));
$month4_name = date("Y F", strtotime("-4 month"));
$month5_first = date("Y-m-01 00:00:00", strtotime("-5 month"));
$month5_last = date("Y-m-t 00:00:00", strtotime("-5 month"));
$month5_name = date("Y F", strtotime("-5 month"));
if (check_value($_POST["submit"])) {
    if (is_numeric($_POST["filter"])) {
        $selectedFilter = xss_clean($_POST["filter"]);
    } else {
        $selectedFilter = 0;
    }
} else {
    $selectedFilter = 0;
}
echo "<br />\r\n<form method=\"post\" action=\"\">\r\n    <table width=\"100%\">\r\n        <tr>\r\n            <td align=\"right\">\r\n                Filter: <select name=\"filter\" class=\"form-control\" style=\"display: inline; width: 200px;\">";
if ($selectedFilter == "0") {
    echo "<option value=\"0\" selected=\"selected\">Total Votes</option>";
} else {
    echo "<option value=\"0\">Total Votes</option>";
}
if ($selectedFilter == "1") {
    echo "<option value=\"1\" selected=\"selected\">" . $month0_name . "</option>";
} else {
    echo "<option value=\"1\">" . $month0_name . "</option>";
}
if ($selectedFilter == "2") {
    echo "<option value=\"2\" selected=\"selected\">" . $month1_name . "</option>";
} else {
    echo "<option value=\"2\">" . $month1_name . "</option>";
}
if ($selectedFilter == "3") {
    echo "<option value=\"3\" selected=\"selected\">" . $month2_name . "</option>";
} else {
    echo "<option value=\"3\">" . $month2_name . "</option>";
}
if ($selectedFilter == "4") {
    echo "<option value=\"4\" selected=\"selected\">" . $month3_name . "</option>";
} else {
    echo "<option value=\"4\">" . $month3_name . "</option>";
}
if ($selectedFilter == "5") {
    echo "<option value=\"5\" selected=\"selected\">" . $month4_name . "</option>";
} else {
    echo "<option value=\"5\">" . $month4_name . "</option>";
}
if ($selectedFilter == "6") {
    echo "<option value=\"6\" selected=\"selected\">" . $month5_name . "</option>";
} else {
    echo "<option value=\"6\">" . $month5_name . "</option>";
}
echo "\r\n                </select> \r\n                <input type=\"submit\" name=\"submit\" class=\"btn btn-primary\" value=\"Show\" />\r\n            </td>\r\n        </tr>\r\n    </table>\r\n</form><br />";
if ($selectedFilter == "0") {
    $voteLogs = $dB->query_fetch("SELECT TOP 100 user_id, COUNT(*) AS totalvotes FROM IMPERIAMUCMS_VOTES WHERE confirm = 1 GROUP BY user_id ORDER BY totalvotes DESC");
} else {
    if ($selectedFilter == "1") {
        $voteLogs = $dB->query_fetch("SELECT TOP 100 user_id, COUNT(*) AS totalvotes FROM IMPERIAMUCMS_VOTES WHERE confirm = 1 AND timestamp >= ? AND IMPERIAMUCMS_VOTES.timestamp <= ? GROUP BY user_id ORDER BY totalvotes DESC", [strtotime($month0_first), strtotime($month0_last)]);
    } else {
        if ($selectedFilter == "2") {
            $voteLogs = $dB->query_fetch("SELECT TOP 100 user_id, COUNT(*) AS totalvotes FROM IMPERIAMUCMS_VOTES WHERE confirm = 1 AND timestamp >= ? AND IMPERIAMUCMS_VOTES.timestamp <= ? GROUP BY user_id ORDER BY totalvotes DESC", [strtotime($month1_first), strtotime($month1_last)]);
        } else {
            if ($selectedFilter == "3") {
                $voteLogs = $dB->query_fetch("SELECT TOP 100 user_id, COUNT(*) AS totalvotes FROM IMPERIAMUCMS_VOTES WHERE confirm = 1 AND timestamp >= ? AND IMPERIAMUCMS_VOTES.timestamp <= ? GROUP BY user_id ORDER BY totalvotes DESC", [strtotime($month2_first), strtotime($month2_last)]);
            } else {
                if ($selectedFilter == "4") {
                    $voteLogs = $dB->query_fetch("SELECT TOP 100 user_id, COUNT(*) AS totalvotes FROM IMPERIAMUCMS_VOTES WHERE confirm = 1 AND timestamp >= ? AND IMPERIAMUCMS_VOTES.timestamp <= ? GROUP BY user_id ORDER BY totalvotes DESC", [strtotime($month3_first), strtotime($month3_last)]);
                } else {
                    if ($selectedFilter == "5") {
                        $voteLogs = $dB->query_fetch("SELECT TOP 100 user_id, COUNT(*) AS totalvotes FROM IMPERIAMUCMS_VOTES WHERE confirm = 1 AND timestamp >= ? AND IMPERIAMUCMS_VOTES.timestamp <= ? GROUP BY user_id ORDER BY totalvotes DESC", [strtotime($month4_first), strtotime($month4_last)]);
                    } else {
                        if ($selectedFilter == "6") {
                            $voteLogs = $dB->query_fetch("SELECT TOP 100 user_id, COUNT(*) AS totalvotes FROM IMPERIAMUCMS_VOTES WHERE confirm = 1 AND timestamp >= ? AND IMPERIAMUCMS_VOTES.timestamp <= ? GROUP BY user_id ORDER BY totalvotes DESC", [strtotime($month5_first), strtotime($month5_last)]);
                        }
                    }
                }
            }
        }
    }
}
if ($voteLogs && is_array($voteLogs)) {
    echo "<table class=\"table table-condensed table-hover\"><tr><th>#</th><th>Account</th><th>Votes</th></tr>";
    foreach ($voteLogs as $key => $thisVote) {
        $accountInfo = $common->accountInformation($thisVote["user_id"]);
        $keyx = $key + 1;
        echo "<tr>";
        echo "<td>" . $keyx . "</td>";
        echo "<td>" . $accountInfo[_CLMN_USERNM_] . "</td>";
        echo "<td>" . $thisVote["totalvotes"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    message("error", "No vote logs found.");
}

?>