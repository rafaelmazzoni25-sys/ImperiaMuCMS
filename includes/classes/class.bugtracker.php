<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class BugTracker
{
    public function getReports()
    {
        global $dB;
        $result = $dB->query_fetch_single("SELECT COUNT(*) AS count FROM IMPERIAMUCMS_BUG_TRACKER");
        if (is_array($result)) {
            return $result["count"];
        }
        return 0;
    }
    public function getReportByID($id)
    {
        global $dB;
        if (!is_numeric($id)) {
            return NULL;
        }
        $id = xss_clean($id);
        $result = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_BUG_TRACKER WHERE id = ?", [$id]);
        if (is_array($result)) {
            return $result;
        }
        return NULL;
    }
    public function getApprovedReports()
    {
        global $dB;
        $result = $dB->query_fetch_single("SELECT COUNT(*) AS count FROM IMPERIAMUCMS_BUG_TRACKER WHERE status = 2 OR status = 3");
        if (is_array($result)) {
            return $result["count"];
        }
        return 0;
    }
    public function getMyReports()
    {
        global $dB;
        $result = $dB->query_fetch_single("SELECT COUNT(*) AS count FROM IMPERIAMUCMS_BUG_TRACKER WHERE author = ?", [$_SESSION["username"]]);
        if (is_array($result)) {
            return $result["count"];
        }
        return 0;
    }
    public function getMyReportsFull($username)
    {
        global $dB;
        $result = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_BUG_TRACKER WHERE author = ? ORDER BY updated DESC", [$username]);
        if (is_array($result)) {
            return $result;
        }
        return NULL;
    }
    public function getMyApprovedReports()
    {
        global $dB;
        $result = $dB->query_fetch_single("SELECT COUNT(*) AS count FROM IMPERIAMUCMS_BUG_TRACKER WHERE (status = 2 OR status = 3) AND author = ?", [$_SESSION["username"]]);
        if (is_array($result)) {
            return $result["count"];
        }
        return 0;
    }
    public function updateLastUpdatedReport($id, $username)
    {
        global $dB;
        $id = xss_clean($id);
        if (check_value($id)) {
            if (!is_numeric($id)) {
                return NULL;
            }
            $update = $dB->query("UPDATE IMPERIAMUCMS_BUG_TRACKER SET updated = ?, updatedBy = ? WHERE id = ?", [date("Y-m-d H:i:s", time()), $username, $id]);
        }
    }
    public function updateLastSeenReport($id, $date)
    {
        global $dB;
        $id = xss_clean($id);
        if (check_value($id)) {
            if (!is_numeric($id)) {
                return NULL;
            }
            $update = $dB->query("UPDATE IMPERIAMUCMS_BUG_TRACKER SET lastSeen = ? WHERE id = ?", [$date, $id]);
        }
    }
    public function searchReports($category, $keyword)
    {
        global $dB;
        if (!is_numeric($category)) {
            return NULL;
        }
        $category = xss_clean($category);
        if (!is_numeric($category) || $category < 1) {
            $category = 1;
        }
        $keyword = xss_clean($keyword);
        $keyword = addslashes($keyword);
        if (check_value($category)) {
            return $dB->query_fetch("SELECT TOP 50 * FROM IMPERIAMUCMS_BUG_TRACKER WHERE category = ? AND title LIKE ? ORDER BY date DESC", [$category, "%" . $keyword . "%"]);
        }
        message("error", lang("error_57", true));
    }
    public function submitReport($category, $title, $text, $priority, $username, $date)
    {
        global $dB;
        global $common;
        if (!is_numeric($category)) {
            return NULL;
        }
        if (!is_numeric($priority)) {
            return NULL;
        }
        if (!Validator::UsernameLength($username)) {
            return NULL;
        }
        if (!Validator::AlphaNumeric($username)) {
            return NULL;
        }
        $category = xss_clean($category);
        $title = xss_clean($title);
        $text = nl2br(xss_clean($text));
        $priority = xss_clean($priority);
        if (check_value($category) && check_value($title) && check_value($text) && check_value($priority) && check_value($username) && check_value($date)) {
            $title = addslashes($title);
            $text = addslashes($text);
            if (strlen($title) < mconfig("title_min") || mconfig("title_max") < strlen($title)) {
                message("error", sprintf(lang("bugtracker_txt_46", true), mconfig("title_min"), mconfig("title_max")));
                return NULL;
            }
            if (strlen($text) < mconfig("text_min") || mconfig("text_max") < strlen($text)) {
                message("error", sprintf(lang("bugtracker_txt_47", true), mconfig("text_min"), mconfig("text_max")));
                return NULL;
            }
            $query = $dB->query("INSERT INTO IMPERIAMUCMS_BUG_TRACKER(category,title,text,priority,status,author,date,reward)\r\n                           VALUES(?,?,?,?,0,?,?,0)", [$category, $title, $text, $priority, $username, $date]);
            if ($query) {
                message("success", lang("bugtracker_success_1", true));
                $logDate = date("Y-m-d H:i:s", time());
                $common->accountLogs($username, "bugtracker", lang("bugtracker_txt_32", true), $logDate);
            } else {
                message("error", lang("error_23", true));
            }
        } else {
            message("error", lang("error_57", true));
        }
    }
    public function getReplies($id)
    {
        global $dB;
        if (!is_numeric($id)) {
            return NULL;
        }
        $id = xss_clean($id);
        $result = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_BUG_TRACKER_REPLIES WHERE report_id = ? ORDER BY date ASC", [$id]);
        if (is_array($result)) {
            return $result;
        }
        return NULL;
    }
    public function getReplyById($id)
    {
        global $dB;
        if (!is_numeric($id)) {
            return NULL;
        }
        $id = xss_clean($id);
        $result = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_BUG_TRACKER_REPLIES WHERE id = ?", [$id]);
        if (is_array($result)) {
            return $result;
        }
        return NULL;
    }
    public function submitReply($id, $message, $author)
    {
        global $dB;
        global $common;
        if (!is_numeric($id)) {
            return NULL;
        }
        $id = xss_clean($id);
        $message = nl2br(xss_clean($message));
        if (check_value($id) && check_value($message) && check_value($author)) {
            $date = date("Y-m-d H:i:s", time());
            $message = addslashes($message);
            if (strlen($message) < mconfig("text_min") || mconfig("text_max") < strlen($message)) {
                message("error", sprintf(lang("bugtracker_txt_47", true), mconfig("text_min"), mconfig("text_max")));
                return NULL;
            }
            $result = $dB->query("INSERT INTO IMPERIAMUCMS_BUG_TRACKER_REPLIES (report_id,text,author,date,staff_reply) VALUES (?,?,?,?,?)", [$id, $message, $author, $date, 0]);
            if ($result) {
                message("success", lang("bugtracker_success_2", true));
                $logDate = date("Y-m-d H:i:s", time());
                $common->accountLogs($author, "bugtracker", lang("bugtracker_txt_32", true), $logDate);
            }
        } else {
            message("error", lang("error_61", true));
        }
    }
    public function submitReplyAdmin($id, $message, $author)
    {
        global $dB;
        if (!is_numeric($id)) {
            return NULL;
        }
        $id = xss_clean($id);
        $message = nl2br(xss_clean($message));
        if (check_value($id) && check_value($message) && check_value($author)) {
            $date = date("Y-m-d H:i:s", time());
            $message = addslashes($message);
            $result = $dB->query("INSERT INTO IMPERIAMUCMS_BUG_TRACKER_REPLIES (report_id,text,author,date,staff_reply) VALUES (?,?,?,?,?)", [$id, $message, $author, $date, 1]);
            if ($result) {
                message("success", lang("bugtracker_success_2", true));
            }
        } else {
            message("error", lang("error_61", true));
        }
    }
    public function showReports()
    {
        global $dB;
        return $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_BUG_TRACKER order by id desc");
    }
    public function showReportsFilter($status)
    {
        global $dB;
        $status = xss_clean($status);
        if (check_value($status)) {
            return $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_BUG_TRACKER where status = ? order by id desc", [$status]);
        }
        message("error", lang("error_57", true));
    }
    public function getStatusName($status, $type)
    {
        if (check_value($status)) {
            $thisReport["status"] = $status;
            if ($type == "li") {
                if ($thisReport["status"] == 0) {
                    $thisReport["status"] = "<li class=\"status new\"><b>" . lang("bugtracker_txt_33", true) . "</b></li>";
                } else {
                    if ($thisReport["status"] == 1) {
                        $thisReport["status"] = "<li class=\"status declined\"><b>" . lang("bugtracker_txt_34", true) . "</b></li>";
                    } else {
                        if ($thisReport["status"] == 2) {
                            $thisReport["status"] = "<li class=\"status approved\"><b>" . lang("bugtracker_txt_35", true) . "</b></li>";
                        } else {
                            if ($thisReport["status"] == 3) {
                                $thisReport["status"] = "<li class=\"status approved\"><b>" . lang("bugtracker_txt_36", true) . "</b></li>";
                            } else {
                                if ($thisReport["status"] == 4) {
                                    $thisReport["status"] = "<li class=\"status declined\"><b>" . lang("bugtracker_txt_37", true) . "</b></li>";
                                } else {
                                    if ($thisReport["status"] == 5) {
                                        $thisReport["status"] = "<li class=\"status declined\"><b>" . lang("bugtracker_txt_38", true) . "</b></li>";
                                    } else {
                                        if ($thisReport["status"] == 6) {
                                            $thisReport["status"] = "<li class=\"status pending\"><b>" . lang("bugtracker_txt_39", true) . "</b></li>";
                                        } else {
                                            if ($thisReport["status"] == 7) {
                                                $thisReport["status"] = "<li class=\"status progress\"><b>" . lang("bugtracker_txt_40", true) . "</b></li>";
                                            } else {
                                                if ($thisReport["status"] == 8) {
                                                    $thisReport["status"] = "<li class=\"status declined\"><b>" . lang("bugtracker_txt_41", true) . "</b></li>";
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
                if ($type == "span") {
                    if ($thisReport["status"] == 0) {
                        $thisReport["status"] = "<span style=\"-moz-border-radius: 3px;-webkit-border-radius: 3px;border-radius: 3px;padding-left: 5px;padding-right: 5px;padding-top: 2px;padding-bottom: 2px;color: #FFFFFF;background-color: #0000ff;font-weight: bold;\">" . lang("bugtracker_txt_33", true) . "</span>";
                    } else {
                        if ($thisReport["status"] == 1) {
                            $thisReport["status"] = "<span style=\"-moz-border-radius: 3px;-webkit-border-radius: 3px;border-radius: 3px;padding-left: 5px;padding-right: 5px;padding-top: 2px;padding-bottom: 2px;color: #FFFFFF;background-color: #c50000;font-weight: bold;\">" . lang("bugtracker_txt_34", true) . "</span>";
                        } else {
                            if ($thisReport["status"] == 2) {
                                $thisReport["status"] = "<span style=\"-moz-border-radius: 3px;-webkit-border-radius: 3px;border-radius: 3px;padding-left: 5px;padding-right: 5px;padding-top: 2px;padding-bottom: 2px;color: #FFFFFF;background-color: #79a026;font-weight: bold;\">" . lang("bugtracker_txt_35", true) . "</span>";
                            } else {
                                if ($thisReport["status"] == 3) {
                                    $thisReport["status"] = "<span style=\"-moz-border-radius: 3px;-webkit-border-radius: 3px;border-radius: 3px;padding-left: 5px;padding-right: 5px;padding-top: 2px;padding-bottom: 2px;color: #FFFFFF;background-color: #79a026;font-weight: bold;\">" . lang("bugtracker_txt_36", true) . "</span>";
                                } else {
                                    if ($thisReport["status"] == 4) {
                                        $thisReport["status"] = "<span style=\"-moz-border-radius: 3px;-webkit-border-radius: 3px;border-radius: 3px;padding-left: 5px;padding-right: 5px;padding-top: 2px;padding-bottom: 2px;color: #FFFFFF;background-color: #c50000;font-weight: bold;\">" . lang("bugtracker_txt_37", true) . "</span>";
                                    } else {
                                        if ($thisReport["status"] == 5) {
                                            $thisReport["status"] = "<span style=\"-moz-border-radius: 3px;-webkit-border-radius: 3px;border-radius: 3px;padding-left: 5px;padding-right: 5px;padding-top: 2px;padding-bottom: 2px;color: #FFFFFF;background-color: #c50000;font-weight: bold;\">" . lang("bugtracker_txt_38", true) . "</span>";
                                        } else {
                                            if ($thisReport["status"] == 6) {
                                                $thisReport["status"] = "<span style=\"-moz-border-radius: 3px;-webkit-border-radius: 3px;border-radius: 3px;padding-left: 5px;padding-right: 5px;padding-top: 2px;padding-bottom: 2px;color: #FFFFFF;background-color: #ff8a00;font-weight: bold;\">" . lang("bugtracker_txt_39", true) . "</span>";
                                            } else {
                                                if ($thisReport["status"] == 7) {
                                                    $thisReport["status"] = "<span style=\"-moz-border-radius: 3px;-webkit-border-radius: 3px;border-radius: 3px;padding-left: 5px;padding-right: 5px;padding-top: 2px;padding-bottom: 2px;color: #FFFFFF;background-color: #ffde00;font-weight: bold;\">" . lang("bugtracker_txt_40", true) . "</span>";
                                                } else {
                                                    if ($thisReport["status"] == 8) {
                                                        $thisReport["status"] = "<span style=\"-moz-border-radius: 3px;-webkit-border-radius: 3px;border-radius: 3px;padding-left: 5px;padding-right: 5px;padding-top: 2px;padding-bottom: 2px;color: #FFFFFF;background-color: #c50000;font-weight: bold;\">" . lang("bugtracker_txt_41", true) . "</span>";
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            return $thisReport["status"];
        }
        message("error", lang("error_57", true));
    }
}

?>