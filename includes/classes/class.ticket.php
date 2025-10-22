<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class Ticket
{
    public function ticketMenu()
    {
        $show_ticket = $_REQUEST["subpage"];
        loadModuleConfigs("ticket");
        $ticket_menu = [[lang("ticket_txt_1", true), "my", mconfig("ticket_enable_my")], [lang("ticket_txt_2", true), "new", mconfig("ticket_enable_new")]];
        echo "<div class=\"changelogs-cats\">";
        foreach ($ticket_menu as $rm_item) {
            if ($rm_item[2]) {
                if ($show_ticket == $rm_item[1]) {
                    echo "<a href=\"" . __PATH_MODULES_TICKET__ . $rm_item[1] . "/\" class=\"active\">" . $rm_item[0] . "</a>";
                } else {
                    echo "<a href=\"" . __PATH_MODULES_TICKET__ . $rm_item[1] . "/\">" . $rm_item[0] . "</a>";
                }
            }
        }
        echo "</div>";
    }
    public function getMyTickets($username)
    {
        global $dB;
        $query = "SELECT * FROM IMPERIAMUCMS_TICKETS WHERE author = ? ORDER BY ticket_id desc";
        $array = [$username];
        $tickets = $dB->query_fetch($query, $array);
        if (is_array($tickets)) {
            $mytickets = [];
            foreach ($tickets as $thisTicket) {
                if (check_value($thisTicket["ticket_id"])) {
                    $mytickets[] = $thisTicket["ticket_id"];
                }
            }
            if (1 <= count($mytickets)) {
                return $mytickets;
            }
            return NULL;
        }
    }
    public function getMyTicketsFull($username)
    {
        global $dB;
        $query = "SELECT * FROM IMPERIAMUCMS_TICKETS WHERE author = ? ORDER BY ticket_id desc";
        $array = [$username];
        $tickets = $dB->query_fetch($query, $array);
        if (is_array($tickets)) {
            return $tickets;
        }
        return NULL;
    }
    public function getTicketById($ticket_id)
    {
        global $dB;
        $ticket_id = xss_clean($ticket_id);
        if (check_value($ticket_id)) {
            if (!is_numeric($ticket_id)) {
                return NULL;
            }
            $result = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_TICKETS WHERE ticket_id = ? ORDER BY ticket_id desc", [$ticket_id]);
            if (is_array($result)) {
                return $result;
            }
            return NULL;
        }
        return NULL;
    }
    public function updateLastSeenTicket($ticket_id, $date)
    {
        global $dB;
        $ticket_id = xss_clean($ticket_id);
        if (check_value($ticket_id)) {
            if (!is_numeric($ticket_id)) {
                return NULL;
            }
            $update = $dB->query("UPDATE IMPERIAMUCMS_TICKETS SET lastSeen = ? WHERE ticket_id = ?", [$date, $ticket_id]);
        }
    }
    public function SubmitTicket($subject, $message, $author)
    {
        global $dB;
        global $common;
        $subject = xss_clean($subject);
        $message = nl2br(xss_clean($message));
        if (check_value($subject) && check_value($message) && check_value($author)) {
            loadModuleConfigs("ticket");
            $minlength = mconfig("msg_min_length");
            $maxlength = mconfig("msg_max_length");
            if ($maxlength < strlen($message) || strlen($message) < $minlength) {
                message("error", sprintf(lang("tickets_error_3", true), $minlength, $maxlength));
                return NULL;
            }
            $date = date("Y-m-d H:i:s", time());
            $message = addslashes($message);
            $subject = addslashes($subject);
            $result = $dB->query("INSERT INTO IMPERIAMUCMS_TICKETS(subject,message,author,date,status,updated,updatedBy)\r\n                            VALUES(?,?,?,?,?,?,?)", [$subject, $message, $author, $date, 0, NULL, NULL]);
            if ($result) {
                message("success", lang("success_22", true));
                $logDate = date("Y-m-d H:i:s", time());
                $common->accountLogs($author, "ticket", lang("tickets_txt_23", true), $logDate);
            } else {
                message("error", lang("error_23", true));
            }
        } else {
            message("error", lang("error_60", true));
        }
    }
    public function SubmitReply($ticket_id, $message, $author)
    {
        global $dB;
        global $common;
        $ticket_id = xss_clean($ticket_id);
        $message = nl2br(xss_clean($message));
        if (check_value($ticket_id) && check_value($message) && check_value($author)) {
            if (!is_numeric($ticket_id)) {
                return NULL;
            }
            $date = date("Y-m-d H:i:s", time());
            $message = addslashes($message);
            $result = $dB->query("INSERT INTO IMPERIAMUCMS_TICKETS_MESSAGES (ticket_id,message,author,date,staff_reply)\r\n                            VALUES (?,?,?,?,?)", [$ticket_id, $message, $author, $date, 0]);
            $result2 = $dB->query("UPDATE IMPERIAMUCMS_TICKETS SET updated = ?,updatedBy = ? WHERE ticket_id = ?", [$date, $author, $ticket_id]);
            if ($result && $result2) {
                message("success", lang("success_23", true));
                $logDate = date("Y-m-d H:i:s", time());
                $common->accountLogs($author, "ticket", lang("tickets_txt_24", true), $logDate);
            }
        } else {
            message("error", lang("error_61", true));
        }
    }
    public function SubmitReplyAdmin($ticket_id, $message, $author)
    {
        global $dB;
        global $common;
        $ticket_id = xss_clean($ticket_id);
        $message = nl2br(xss_clean($message));
        if (check_value($ticket_id) && check_value($message) && check_value($author)) {
            if (!is_numeric($ticket_id)) {
                return NULL;
            }
            $date = date("Y-m-d H:i:s", time());
            $message = addslashes($message);
            $result = $dB->query("INSERT INTO IMPERIAMUCMS_TICKETS_MESSAGES (ticket_id,message,author,date,staff_reply)\r\n                            VALUES (?,?,?,?,?)", [$ticket_id, $message, $author, $date, 1]);
            $result2 = $dB->query("UPDATE IMPERIAMUCMS_TICKETS SET updated = ?,updatedBy = ? WHERE ticket_id = ?", [$date, $author, $ticket_id]);
            if ($result && $result2) {
                message("success", lang("success_23", true));
            }
        } else {
            message("error", lang("error_61", true));
        }
    }
    public function getMyReplies($ticket_id)
    {
        global $dB;
        $ticket_id = xss_clean($ticket_id);
        if (!is_numeric($ticket_id)) {
            return NULL;
        }
        $query = "SELECT * FROM IMPERIAMUCMS_TICKETS_MESSAGES WHERE ticket_id = ? ORDER BY reply_id asc";
        $array = [$ticket_id];
        $replies = $dB->query_fetch($query, $array);
        if (is_array($replies)) {
            $myreplies = [];
            foreach ($replies as $thisReply) {
                if (check_value($thisReply["reply_id"])) {
                    $myreplies[] = $thisReply["reply_id"];
                }
            }
            if (1 <= count($myreplies)) {
                return $myreplies;
            }
            return NULL;
        }
    }
    public function getReplyById($reply_id)
    {
        global $dB;
        $reply_id = xss_clean($reply_id);
        if (!is_numeric($reply_id)) {
            return NULL;
        }
        if (check_value($reply_id)) {
            $result = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_TICKETS_MESSAGES WHERE reply_id = ? ORDER BY reply_id asc", [$reply_id]);
            if (is_array($result)) {
                return $result;
            }
            return NULL;
        }
        return NULL;
    }
    public function checkTicketOwner($ticket_id, $owner)
    {
        global $dB;
        $ticket_id = xss_clean($ticket_id);
        if (!is_numeric($ticket_id)) {
            return NULL;
        }
        if (check_value($ticket_id) && check_value($owner)) {
            $result = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_TICKETS WHERE ticket_id = ? and author = ?", [$ticket_id, $owner]);
            if (is_array($result)) {
                return $result;
            }
            return NULL;
        }
        return NULL;
    }
}

?>