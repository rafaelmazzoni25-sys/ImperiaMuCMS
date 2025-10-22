<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

loadModuleConfigs("bugtracker");
$BugTracker = new BugTracker();
if (isset($_GET["id"])) {
    $report_id = htmlspecialchars($_GET["id"]);
    $reportData = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_BUG_TRACKER WHERE id = ?", [$report_id]);
    if (check_value($_POST["submit"])) {
        $checkSubmit = $BugTracker->SubmitReplyAdmin($report_id, $_POST["message"], mconfig("staff_nickname"));
        $BugTracker->updateLastUpdatedReport($report_id, mconfig("staff_nickname"));
    }
    echo "<h2>View Report: #" . $report_id . "</h2>";
    if (isset($_GET["change"])) {
        $change = htmlspecialchars($_GET["change"]);
        $give_reward = false;
        if ($change == "new") {
            $statusId = 0;
        } else {
            if ($change == "decline") {
                $statusId = 1;
            } else {
                if ($change == "approve") {
                    if ($reportData["reward"] == 0) {
                        $give_reward = true;
                    }
                    $statusId = 2;
                } else {
                    if ($change == "fix") {
                        if ($reportData["reward"] == 0) {
                            $give_reward = true;
                        }
                        $statusId = 3;
                    } else {
                        if ($change == "notabug") {
                            $statusId = 4;
                        } else {
                            if ($change == "duplicated") {
                                $statusId = 5;
                            } else {
                                if ($change == "notconfirmed") {
                                    $statusId = 6;
                                } else {
                                    if ($change == "inprogress") {
                                        $statusId = 7;
                                    } else {
                                        if ($change == "invalid") {
                                            $statusId = 8;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        $newstatus = $BugTracker->getStatusName($statusId, "span");
        $updateReport = $dB->query("UPDATE IMPERIAMUCMS_BUG_TRACKER SET status = ? WHERE id = ?", [$statusId, $report_id]);
        if ($give_reward && mconfig("isreward")) {
            mconfig("reward_type");
            switch (mconfig("reward_type")) {
                case "1":
                    if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                        $reward = $dB2->query("UPDATE MEMB_CREDITS SET platinum = platinum + " . mconfig("reward_value") . " WHERE memb___id = ?", [$reportData["author"]]);
                    } else {
                        $reward = $dB->query("UPDATE MEMB_CREDITS SET platinum = platinum + " . mconfig("reward_value") . " WHERE memb___id = ?", [$reportData["author"]]);
                    }
                    break;
                case "2":
                    if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                        $reward = $dB2->query("UPDATE MEMB_CREDITS SET gold = gold + " . mconfig("reward_value") . " WHERE memb___id = ?", [$reportData["author"]]);
                    } else {
                        $reward = $dB->query("UPDATE MEMB_CREDITS SET platinum = platinum + " . mconfig("reward_value") . " WHERE memb___id = ?", [$reportData["author"]]);
                    }
                    break;
                case "3":
                    if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                        $reward = $dB2->query("UPDATE MEMB_CREDITS SET silver = silver + " . mconfig("reward_value") . " WHERE memb___id = ?", [$reportData["author"]]);
                    } else {
                        $reward = $dB->query("UPDATE MEMB_CREDITS SET platinum = platinum + " . mconfig("reward_value") . " WHERE memb___id = ?", [$reportData["author"]]);
                    }
                    break;
                case "4":
                    if (100 <= config("server_files_season", true)) {
                        $reward = $dB->query("UPDATE T_InGameShop_Point SET WCoin = WCoin + " . mconfig("reward_value") . " WHERE AccountID = ?", [$reportData["author"]]);
                    } else {
                        $reward = $dB->query("UPDATE T_InGameShop_Point SET WCoinC = WCoinC + " . mconfig("reward_value") . " WHERE AccountID = ?", [$reportData["author"]]);
                    }
                    break;
                case "5":
                    $reward = $dB->query("UPDATE T_InGameShop_Point SET GoblinPoint = GoblinPoint + " . mconfig("reward_value") . " where AccountID = ?", [$reportData["author"]]);
                    break;
                case "6":
                    $reward = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET zen = zen + " . mconfig("reward_value") . " where AccountID = ?", [$reportData["author"]]);
                    break;
                default:
                    $updateReport2 = $dB->query("UPDATE IMPERIAMUCMS_BUG_TRACKER SET reward = '1' WHERE id = '" . $report_id . "'");
            }
        }
        $BugTracker->updateLastUpdatedReport($report_id, mconfig("staff_nickname"));
        echo "<div><a href=\"index.php?module=bugtracker_reports\" class=\"btn\">Back to Reports</a></div>";
        message("success", "Status of Report #" . $report_id . " was changed to " . $newstatus . "");
    }
    if (isset($_GET["changecat"])) {
        $change = htmlspecialchars($_GET["changecat"]);
        if ($change == "1") {
            $newcat = "Website";
            $cat = 1;
        } else {
            if ($change == "2") {
                $newcat = "Server Files";
                $cat = 2;
            }
        }
        $updateReport = $dB->query("UPDATE IMPERIAMUCMS_BUG_TRACKER SET category = '" . $cat . "' WHERE id = '" . $report_id . "'");
        echo "<div><a href=\"index.php?module=bugtracker_reports\" class=\"btn\">Back to Reports</a></div>";
        message("success", "Category of Report #" . $report_id . " was changed to " . $newcat . ".");
    }
    if (isset($_GET["delete"])) {
        $delete = htmlspecialchars($_GET["delete"]);
        if ($delete == "report") {
            $deleteReport = $dB->query("DELETE FROM IMPERIAMUCMS_BUG_TRACKER WHERE id = '" . $report_id . "'");
            $deleteReplies = $dB->query("DELETE FROM IMPERIAMUCMS_BUG_TRACKER_REPLIES WHERE report_id = '" . $report_id . "'");
            echo "<div><a href=\"index.php?module=bugtracker_reports\" class=\"btn\">Back to Reports</a></div>";
            message("success", "Report #" . $report_id . " was deleted.");
        } else {
            if ($delete == "reply") {
                $reply_id = htmlspecialchars($_GET["reply"]);
                $deleteReply = $dB->query("DELETE FROM IMPERIAMUCMS_BUG_TRACKER_REPLIES WHERE id = '" . $reply_id . "'");
                echo "<div><a href=\"index.php?module=bugtracker_reports\" class=\"btn\">Back to Reports</a></div>";
                message("success", "Reply from report #" . $report_id . " was deleted.");
            }
        }
    }
    $reportData = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_BUG_TRACKER WHERE id = '" . $report_id . "'");
    $date = date($config["time_date_format"], strtotime($reportData["date"]));
    if ($reportData["category"] == "1") {
        $cat = "Website";
    } else {
        if ($reportData["category"] == "2") {
            $cat = "Server Files";
        }
    }
    $status = $BugTracker->getStatusName($reportData["status"], "span");
    if ($reportData["priority"] == 1) {
        $priority = "<span style=\"font-weight: bold; color: green;\">Low Priority</span>";
    } else {
        if ($reportData["priority"] == 2) {
            $priority = "<span style=\"font-weight: bold; color: orange;\">Normal Priority</span>";
        } else {
            if ($reportData["priority"] == 3) {
                $priority = "<span style=\"font-weight: bold; color: red;\">High Priority</span>";
            }
        }
    }
    echo "\r\n  <table class=\"table table-striped table-bordered table-hover\">\r\n  \t<tr>\r\n    \t<th>Title</th>\r\n      <td>" . stripslashes($reportData["title"]) . "</td>\r\n  \t</tr>\r\n    <tr>\r\n    \t<th>Author</th>\r\n      <td>" . $reportData["author"] . "</td>\r\n  \t</tr>\r\n    <tr>\r\n    \t<th>Create Date</th>\r\n      <td>" . $date . "</td>\r\n  \t</tr>\r\n    <tr>\r\n    \t<th>Priority</th>\r\n      <td>" . $priority . "</td>\r\n  \t</tr>\r\n    <tr>\r\n    \t<th>Category</th>\r\n      <td>" . $cat . "\r\n        <div class=\"btn-group\">\r\n          <a class=\"btn dropdown-toggle btn\" data-toggle=\"dropdown\" href=\"#\">Change Category<span class=\"caret\"></span></a>\r\n          <ul class=\"dropdown-menu\">\r\n            <li><a href=\"index.php?module=bugtracker_reports&id=" . $report_id . "&changecat=1\">Website</a></li>\r\n            <li><a href=\"index.php?module=bugtracker_reports&id=" . $report_id . "&changecat=2\">Server Files</a></li>\r\n          </ul>\r\n        </div>\r\n      </td>\r\n  \t</tr>\r\n    <tr>\r\n    \t<th>Status</th>\r\n      <td>" . $status . "\r\n        <div class=\"btn-group\">\r\n          <a class=\"btn dropdown-toggle btn\" data-toggle=\"dropdown\" href=\"#\">Change Status<span class=\"caret\"></span></a>\r\n          <ul class=\"dropdown-menu\">\r\n            <li><a href=\"index.php?module=bugtracker_reports&id=" . $report_id . "&change=new\"><span style=\"-moz-border-radius: 3px;-webkit-border-radius: 3px;border-radius: 3px;padding-left: 5px;padding-right: 5px;padding-top: 0px;padding-bottom: 2px;color: #FFFFFF;background-color: #0000ff;font-weight: bold;\">New</span></a></li>\r\n            <li><a href=\"index.php?module=bugtracker_reports&id=" . $report_id . "&change=decline\"><span style=\"-moz-border-radius: 3px;-webkit-border-radius: 3px;border-radius: 3px;padding-left: 5px;padding-right: 5px;padding-top: 0px;padding-bottom: 2px;color: #FFFFFF;background-color: #ff0000;font-weight: bold;\">Declined</span></a></li>\r\n            <li><a href=\"index.php?module=bugtracker_reports&id=" . $report_id . "&change=approve\"><span style=\"-moz-border-radius: 3px;-webkit-border-radius: 3px;border-radius: 3px;padding-left: 5px;padding-right: 5px;padding-top: 0px;padding-bottom: 2px;color: #FFFFFF;background-color: #00ff00;font-weight: bold;\">Confirmed</span></li>\r\n            <li><a href=\"index.php?module=bugtracker_reports&id=" . $report_id . "&change=fix\"><span style=\"-moz-border-radius: 3px;-webkit-border-radius: 3px;border-radius: 3px;padding-left: 5px;padding-right: 5px;padding-top: 0px;padding-bottom: 2px;color: #FFFFFF;background-color: #00ff00;font-weight: bold;\">Fixed</span></a></li>\r\n            <li><a href=\"index.php?module=bugtracker_reports&id=" . $report_id . "&change=notabug\"><span style=\"-moz-border-radius: 3px;-webkit-border-radius: 3px;border-radius: 3px;padding-left: 5px;padding-right: 5px;padding-top: 0px;padding-bottom: 2px;color: #FFFFFF;background-color: #ff0000;font-weight: bold;\">Not a Bug</span></a></li>\r\n            <li><a href=\"index.php?module=bugtracker_reports&id=" . $report_id . "&change=duplicated\"><span style=\"-moz-border-radius: 3px;-webkit-border-radius: 3px;border-radius: 3px;padding-left: 5px;padding-right: 5px;padding-top: 0px;padding-bottom: 2px;color: #FFFFFF;background-color: #ff0000;font-weight: bold;\">Duplicated</span></a></li>\r\n            <li><a href=\"index.php?module=bugtracker_reports&id=" . $report_id . "&change=notconfirmed\"><span style=\"-moz-border-radius: 3px;-webkit-border-radius: 3px;border-radius: 3px;padding-left: 5px;padding-right: 5px;padding-top: 0px;padding-bottom: 2px;color: #FFFFFF;background-color: #ffa500;font-weight: bold;\">Not Confirmed</span></a></li>\r\n            <li><a href=\"index.php?module=bugtracker_reports&id=" . $report_id . "&change=inprogress\"><span style=\"-moz-border-radius: 3px;-webkit-border-radius: 3px;border-radius: 3px;padding-left: 5px;padding-right: 5px;padding-top: 0px;padding-bottom: 2px;color: #FFFFFF;background-color: #ffff00;font-weight: bold;\">In Progress</span></a></li>\r\n            <li><a href=\"index.php?module=bugtracker_reports&id=" . $report_id . "&change=invalid\"><span style=\"-moz-border-radius: 3px;-webkit-border-radius: 3px;border-radius: 3px;padding-left: 5px;padding-right: 5px;padding-top: 0px;padding-bottom: 2px;color: #FFFFFF;background-color: #ff0000;font-weight: bold;\">Invalid Report</span></a></li>\r\n          </ul>\r\n        </div>\r\n      </td>\r\n  \t</tr>\r\n  </table>";
    $date = date($config["time_date_format"], strtotime($reportData["date"]));
    echo "\r\n  <table class=\"table2 table-striped table-bordered table-hover\" width=\"100%\">\r\n  \t<tr>\r\n    \t<th width=\"50%\">" . $reportData["author"] . ":</th>\r\n      <td width=\"50%\" align=\"right\">" . $date . "&nbsp;&nbsp;&nbsp;<a href=\"index.php?module=bugtracker_reports&id=" . $report_id . "&delete=report\" class=\"btn btn-danger\">Delete Report</a></td>\r\n    </tr>\r\n    <tr>\r\n      <td colspan=\"2\">" . stripslashes($reportData["text"]) . "</td>\r\n  \t</tr>\r\n  </table>";
    $reportReplies = $BugTracker->getReplies($report_id);
    if (is_array($reportReplies)) {
        foreach ($reportReplies as $thisReply) {
            $tblstyle = "";
            $replyData = $BugTracker->getReplyById($thisReply["id"]);
            if (array_key_exists($replyData["author"], $config["admins"]) || $replyData["author"] == mconfig("staff_nickname")) {
                $tblstyle = "style=\"color:#ffffff;background-color:#770000\"";
            }
            $date = date($config["time_date_format"], strtotime($replyData["date"]));
            echo "<br />\r\n      <table class=\"table2 table-striped table-bordered table-hover\" width=\"100%\">\r\n      \t<tr>\r\n        \t<th width=\"50%\">" . $replyData["author"] . ":</th>\r\n          <td width=\"50%\" align=\"right\">" . $date . "&nbsp;&nbsp;&nbsp;<a href=\"index.php?module=bugtracker_reports&id=" . $report_id . "&reply=" . $replyData["id"] . "&delete=reply\" class=\"btn btn-danger\">Delete Reply</a></td>\r\n        </tr>\r\n        <tr>\r\n          <td colspan=\"2\" " . $tblstyle . ">" . stripslashes($replyData["text"]) . "</td>\r\n      \t</tr>\r\n      </table>";
        }
    }
    echo "<br /><b>Submit Reply:</b>\r\n  <form action=\"\" method=\"post\">\r\n    <table class=\"table3\" width=\"100%\">\r\n      <tr>\r\n        <td><textarea style=\"width:100%\" rows=\"6\" name=\"message\" class=\"form-control\"></textarea></td>\r\n      </tr>\r\n      <tr>\r\n        <td align=\"right\"><input type=\"submit\" name=\"submit\" value=\"Submit Reply\" class=\"btn btn-primary\"/></td>\r\n      </tr>\r\n    </table>\r\n  </form>\r\n  ";
} else {
    echo "<h2>Bug Tracker: Reports</h2>";
    if (isset($_GET["filter"])) {
        if ($_GET["filter"] == "new") {
            $reports = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_BUG_TRACKER WHERE status = 0 ORDER BY date desc");
        } else {
            if ($_GET["filter"] == "declined") {
                $reports = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_BUG_TRACKER WHERE status = 1 ORDER BY date desc");
            } else {
                if ($_GET["filter"] == "confirmed") {
                    $reports = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_BUG_TRACKER WHERE status = 2 ORDER BY date desc");
                } else {
                    if ($_GET["filter"] == "fixed") {
                        $reports = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_BUG_TRACKER WHERE status = 3 ORDER BY date desc");
                    } else {
                        if ($_GET["filter"] == "notabug") {
                            $reports = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_BUG_TRACKER WHERE status = 4 ORDER BY date desc");
                        } else {
                            if ($_GET["filter"] == "duplicated") {
                                $reports = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_BUG_TRACKER WHERE status = 5 ORDER BY date desc");
                            } else {
                                if ($_GET["filter"] == "notconfirmed") {
                                    $reports = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_BUG_TRACKER WHERE status = 6 ORDER BY date desc");
                                } else {
                                    if ($_GET["filter"] == "inprogress") {
                                        $reports = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_BUG_TRACKER WHERE status = 7 ORDER BY date desc");
                                    } else {
                                        if ($_GET["filter"] == "invalid") {
                                            $reports = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_BUG_TRACKER WHERE status = 8 ORDER BY date desc");
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    } else {
        $reports = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_BUG_TRACKER ORDER BY date desc");
    }
    echo "<br />\r\n    <table width=\"100%\">\r\n      <tr>\r\n        <td>Total Reports: " . count($reports) . "</td>\r\n        <td align=\"right\">\r\n          Filter:\r\n          <a class=\"btn btn-primary\" href=\"index.php?module=bugtracker_reports\">ALL</a>\r\n          <a class=\"btn btn-info\" href=\"index.php?module=bugtracker_reports&filter=new\">NEW</a>\r\n          <a class=\"btn btn-danger\" href=\"index.php?module=bugtracker_reports&filter=declined\">DECLINED</a>\r\n          <a class=\"btn btn-danger\" href=\"index.php?module=bugtracker_reports&filter=notabug\">NOT A BUG</a>\r\n          <a class=\"btn btn-danger\" href=\"index.php?module=bugtracker_reports&filter=duplicated\">DUPLICATED</a>\r\n          <a class=\"btn btn-warning\" href=\"index.php?module=bugtracker_reports&filter=notconfirmed\">NOT CONFIRMED</a>\r\n          <a class=\"btn btn-success\" href=\"index.php?module=bugtracker_reports&filter=confirmed\">CONFIRMED</a>\r\n          <a class=\"btn btn-warning\" href=\"index.php?module=bugtracker_reports&filter=inprogress\">IN PROGRESS</a>\r\n          <a class=\"btn btn-success\" href=\"index.php?module=bugtracker_reports&filter=fixed\">FIXED</a>\r\n          <a class=\"btn btn-danger\" href=\"index.php?module=bugtracker_reports&filter=invalid\">INVALID REPORT</a>\r\n        </td>\r\n      </tr>\r\n    </table><br />";
    if (is_array($reports)) {
        echo "<table class=\"table table-striped table-bordered table-hover\">\r\n  \t<tr>\r\n  \t<th width=\"20%\">Title</th>\r\n  \t<th width=\"10%\">Author</th>\r\n    <th width=\"20%\">Create Date</th>\r\n    <th width=\"20%\">Priority</th>\r\n    <th width=\"10%\">Category</th>\r\n    <th width=\"5%\">Status</th>\r\n    <th width=\"5%\">Action</th>\r\n  \t</tr>";
        foreach ($reports as $thisReport) {
            $date = date($config["time_date_format"], strtotime($thisReport["date"]));
            if ($thisReport["category"] == "1") {
                $cat = "Website";
            } else {
                if ($thisReport["category"] == "2") {
                    $cat = "Server Files";
                }
            }
            $status = $BugTracker->getStatusName($thisReport["status"], "span");
            if ($thisReport["priority"] == 1) {
                $priority = "<span style=\"font-weight: bold; color: green;\">Low Priority</span>";
            } else {
                if ($thisReport["priority"] == 2) {
                    $priority = "<span style=\"font-weight: bold; color: orange;\">Normal Priority</span>";
                } else {
                    if ($thisReport["priority"] == 3) {
                        $priority = "<span style=\"font-weight: bold; color: red;\">High Priority</span>";
                    }
                }
            }
            echo "<tr>";
            echo "<td>" . stripslashes($thisReport["title"]) . "</td>";
            echo "<td>" . $thisReport["author"] . "</td>";
            echo "<td>" . $date . "</td>";
            echo "<td>" . $priority . "</td>";
            echo "<td>" . $cat . "</td>";
            echo "<td>" . $status . "</td>";
            echo "<td><a href=\"index.php?module=bugtracker_reports&id=" . $thisReport["id"] . "\" class=\"btn\">View</a></td>";
            echo "</tr>";
        }
        echo "\r\n  \t</table>";
    } else {
        message("error", "No reports found.");
    }
}

?>