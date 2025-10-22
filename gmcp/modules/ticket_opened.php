<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

loadModuleConfigs("ticket");
if (isset($_GET["id"])) {
    $ticket_id = htmlspecialchars($_GET["id"]);
    echo "<h2>View Ticket: #" . $ticket_id . "</h2>";
    if (isset($_GET["change"])) {
        $change = htmlspecialchars($_GET["change"]);
        if ($change == "open") {
            $newstatus = "<span class=\"ticket-open\">open</span>";
            $statusId = 0;
        } else {
            if ($change == "wait") {
                $newstatus = "<span class=\"ticket-wait\">waiting</span>";
                $statusId = 2;
            } else {
                if ($change == "close") {
                    $newstatus = "<span class=\"ticket-closed\">closed</span>";
                    $statusId = 1;
                }
            }
        }
        $date = date("Y-m-d H:i:s", time());
        $updateTicket = $dB->query_fetch("UPDATE IMPERIAMUCMS_TICKETS SET status = '" . $statusId . "',updated = '" . $date . "',updatedBy = '" . mconfig("staff_nickname") . "' WHERE ticket_id = '" . $ticket_id . "'");
        echo "<div><a href=\"index.php?module=ticket_opened\" class=\"btn\">Back to Opened Tickets</a></div>";
        message("success", "Status of Ticket #" . $ticket_id . " was changed to " . $newstatus . "");
    }
    if (isset($_GET["delete"])) {
        $delete = htmlspecialchars($_GET["delete"]);
        if ($delete == "ticket") {
            $deleteTicket = $dB->query_fetch("DELETE FROM IMPERIAMUCMS_TICKETS WHERE ticket_id = '" . $ticket_id . "'");
            $deleteTicket2 = $dB->query_fetch("DELETE FROM IMPERIAMUCMS_TICKETS_MESSAGES WHERE ticket_id = '" . $ticket_id . "'");
            echo "<div><a href=\"index.php?module=ticket_opened\" class=\"btn\">Back to Opened Tickets</a></div>";
            message("success", "Ticket #" . $ticket_id . " was deleted");
        }
        if ($delete == "reply" && isset($_GET["reply"])) {
            $reply = htmlspecialchars($_GET["reply"]);
            $deleteReply = $dB->query_fetch("DELETE FROM IMPERIAMUCMS_TICKETS_MESSAGES WHERE reply_id = '" . $reply . "'");
            echo "<div><a href=\"index.php?module=ticket_opened\" class=\"btn\">Back to Opened Tickets</a></div>";
            message("success", "Reply #" . $reply . " was deleted");
        }
    }
    $Ticket = new Ticket();
    $thisTicket = $Ticket->getTicketById($ticket_id);
    if (check_value($_POST["submit"])) {
        $checkSubmit = $Ticket->SubmitReplyAdmin($ticket_id, $_POST["message"], mconfig("staff_nickname"));
    }
    $date = date($config["time_date_format"], strtotime($thisTicket["date"]));
    if ($thisTicket["updated"] == NULL) {
        $update = "never";
    } else {
        $update = date($config["time_date_format"], strtotime($thisTicket["updated"]));
    }
    if ($thisTicket["status"] == 0) {
        $thisTicket["status"] = "<span class=\"ticket-open\">open</span>";
    } else {
        if ($thisTicket["status"] == 1) {
            $thisTicket["status"] = "<span class=\"ticket-closed\">closed</span>";
        } else {
            if ($thisTicket["status"] == 2) {
                $thisTicket["status"] = "<span class=\"ticket-wait\">waiting</span>";
            }
        }
    }
    echo "\r\n  <table class=\"table table-striped table-bordered table-hover\">\r\n  \t<tr>\r\n    \t<th>Subject</th>\r\n      <td>" . stripslashes($thisTicket["subject"]) . "</td>\r\n  \t</tr>\r\n    <tr>\r\n    \t<th>Author</th>\r\n      <td>" . $thisTicket["author"] . "</td>\r\n  \t</tr>\r\n    <tr>\r\n    \t<th>Create Date</th>\r\n      <td>" . $date . "</td>\r\n  \t</tr>\r\n    <tr>\r\n    \t<th>Last Update</th>\r\n      <td>" . $update . "</td>\r\n  \t</tr>\r\n    <tr>\r\n    \t<th>Status</th>\r\n      <td>" . $thisTicket["status"] . "\r\n        <div class=\"btn-group\">\r\n          <a class=\"btn dropdown-toggle btn\" data-toggle=\"dropdown\" href=\"#\">Change Status<span class=\"caret\"></span></a>\r\n          <ul class=\"dropdown-menu\">\r\n            <li><a href=\"index.php?module=ticket_opened&id=" . $ticket_id . "&change=open\"><span class=\"ticket-open\">Opened</span></a></li>\r\n            <li><a href=\"index.php?module=ticket_opened&id=" . $ticket_id . "&change=wait\"><span class=\"ticket-wait\">Waiting</span></a></li>\r\n            <li><a href=\"index.php?module=ticket_opened&id=" . $ticket_id . "&change=close\"><span class=\"ticket-closed\">Closed</span></a></li>\r\n          </ul>\r\n        </div>\r\n      </td>\r\n  \t</tr>\r\n  </table>";
    $date = date($config["time_date_format"], strtotime($thisTicket["date"]));
    echo "\r\n  <table class=\"table2 table-striped table-bordered table-hover\" width=\"100%\">\r\n  \t<tr>\r\n    \t<th width=\"50%\">" . $thisTicket["author"] . ":</th>\r\n      <td width=\"50%\" align=\"right\">" . $date . "&nbsp;&nbsp;&nbsp;<a href=\"index.php?module=ticket_opened&id=" . $ticket_id . "&delete=ticket\" class=\"btn btn-danger\">Delete Ticket</a></td>\r\n    </tr>\r\n    <tr>\r\n      <td colspan=\"2\">" . stripslashes($thisTicket["message"]) . "</td>\r\n  \t</tr>\r\n  </table>";
    $minlength1 = mconfig("msg_min_length");
    $maxlength1 = mconfig("msg_max_length");
    $ticketReplies = $Ticket->getMyReplies($ticket_id);
    if (is_array($ticketReplies)) {
        foreach ($ticketReplies as $thisReply) {
            $replyData = $Ticket->getReplyById($thisReply);
            $date = date($config["time_date_format"], strtotime($replyData["date"]));
            echo "\r\n      <table class=\"table2 table-striped table-bordered table-hover\" width=\"100%\">\r\n      \t<tr>\r\n        \t<th width=\"50%\">" . $replyData["author"] . ":</th>\r\n          <td width=\"50%\" align=\"right\">" . $date . "&nbsp;&nbsp;&nbsp;<a href=\"index.php?module=ticket_opened&id=" . $ticket_id . "&delete=reply&reply=" . $replyData["reply_id"] . "\" class=\"btn btn-danger\">Delete Reply</a></td>\r\n      \t</tr>\r\n        <tr>\r\n          <td colspan=\"2\">" . stripslashes($replyData["message"]) . "</td>\r\n      \t</tr>\r\n      </table>";
        }
    }
    echo "<b>Submit Reply:</b>";
    echo "\r\n  <form action=\"\" method=\"post\">\r\n    <table class=\"table3\" width=\"100%\">\r\n      <tr>\r\n        <td><textarea style=\"width:100%\" rows=\"6\" name=\"message\" pattern=\".{" . $minlength1 . "," . $maxlength1 . "}\" required title=\"Enter " . $minlength1 . " - " . $maxlength1 . " characters\"></textarea></td>\r\n      </tr>\r\n      <tr>\r\n        <td align=\"right\"><input type=\"submit\" name=\"submit\" value=\"Submit Reply\" class=\"btn btn-primary\"/></td>\r\n      </tr>\r\n    </table>\r\n  </form>\r\n  ";
} else {
    echo "<h2>Ticket System: Opened Tickets</h2>";
    $getOpenTickets = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_TICKETS WHERE status = 0 OR status = 2 ORDER BY date asc");
    if (is_array($getOpenTickets)) {
        message("", count($getOpenTickets), "Total Opened Tickets:");
        echo "<table class=\"table table-striped table-bordered table-hover\">\r\n  \t<tr>\r\n  \t<th width=\"1%\">ID</th>\r\n  \t<th width=\"20%\">Subject</th>\r\n  \t<th width=\"10%\">Author</th>\r\n    <th width=\"20%\">Create Date</th>\r\n    <th width=\"20%\">Last Update</th>\r\n    <th width=\"10%\">Last Update By</th>\r\n    <th width=\"5%\">Status</th>\r\n    <th width=\"5%\">Action</th>\r\n  \t</tr>";
        foreach ($getOpenTickets as $thisTicket) {
            $date = date($config["time_date_format"], strtotime($thisTicket["date"]));
            if ($thisTicket["updated"] == NULL) {
                $update = "never";
            } else {
                $update = date($config["time_date_format"], strtotime($thisTicket["updated"]));
            }
            if ($thisTicket["status"] == 0) {
                $thisTicket["status"] = "<span class=\"ticket-open\">open</span>";
            } else {
                if ($thisTicket["status"] == 1) {
                    $thisTicket["status"] = "<span class=\"ticket-closed\">closed</span>";
                } else {
                    if ($thisTicket["status"] == 2) {
                        $thisTicket["status"] = "<span class=\"ticket-wait\">waiting</span>";
                    }
                }
            }
            echo "<tr>";
            echo "<td>" . $thisTicket["ticket_id"] . "</td>";
            echo "<td>" . stripslashes($thisTicket["subject"]) . "</td>";
            echo "<td>" . $thisTicket["author"] . "</td>";
            echo "<td>" . $date . "</td>";
            echo "<td>" . $update . "</td>";
            echo "<td>" . $thisTicket["updatedBy"] . "</td>";
            echo "<td>" . $thisTicket["status"] . "</td>";
            echo "<td><a href=\"index.php?module=ticket_opened&id=" . $thisTicket["ticket_id"] . "\" class=\"btn\">View</a></td>";
            echo "</tr>";
        }
        echo "\r\n  \t</table>";
    } else {
        message("error", "Opened tickets was not found.");
    }
}

?>