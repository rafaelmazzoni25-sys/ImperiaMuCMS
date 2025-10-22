<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

if (!isLoggedIn()) {
    redirect(1, "login");
} else {
    loadModuleConfigs("ticket");
    if (!canAccessModule($_SESSION["username"], "ticket", "allow")) {
        return NULL;
    }
    if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
        $breadcrumb = generateBreadcrumb();
        echo "\r\n    <h3>\r\n        " . lang("tickets_txt_12", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
        if (mconfig("active") && mconfig("ticket_enable_view")) {
            $Ticket = new Ticket();
            if (check_value($_GET["id"])) {
                $ticket_id = xss_clean(htmlspecialchars($_GET["id"]));
                $checkTicketOwner = $Ticket->checkTicketOwner($ticket_id, $_SESSION["username"]);
                if ($checkTicketOwner == NULL) {
                    message("error", lang("tickets_error_1", true));
                } else {
                    $thisTicket = $Ticket->getTicketById($ticket_id);
                    if (check_value($_POST["submit"])) {
                        if ($_SESSION["token"] == $_POST["token"]) {
                            $checkSubmit = $Ticket->SubmitReply($ticket_id, $_POST["message"], $_SESSION["username"]);
                            $Ticket->updateLastSeenTicket($ticket_id, date("Y-m-d H:i:s", time() + 60));
                        } else {
                            message("notice", lang("global_module_13", true));
                        }
                    }
                    $Ticket->updateLastSeenTicket($ticket_id, date("Y-m-d H:i:s", time()));
                    $date = date($config["time_date_format"], strtotime($thisTicket["date"]));
                    if ($thisTicket["updated"] == NULL) {
                        $update = lang("tickets_txt_17", true);
                        $by = "";
                    } else {
                        $update = date($config["time_date_format"], strtotime($thisTicket["updated"]));
                        $by = " " . lang("tickets_txt_18", true);
                    }
                    if ($thisTicket["status"] == 0) {
                        $thisTicketstatus = "<span class=\"ticket-open\">" . lang("tickets_txt_9", true) . "</span>";
                    } else {
                        if ($thisTicket["status"] == 1) {
                            $thisTicketstatus = "<span class=\"ticket-closed\">" . lang("tickets_txt_10", true) . "</span>";
                        } else {
                            if ($thisTicket["status"] == 2) {
                                $thisTicketstatus = "<span class=\"ticket-wait\">" . lang("tickets_txt_11", true) . "</span>";
                            }
                        }
                    }
                    echo "\r\n    <div class=\"row\">\r\n        <div class=\"col-xs-12 col-sm-12 col-md-6 col-lg-4\">\r\n            <table class=\"table table-hover text-center\">\r\n                <tr>\r\n                    <th align=\"left\" width=\"50%\">" . lang("tickets_txt_19", true) . "</th>\r\n                    <td>#" . $thisTicket["ticket_id"] . "</td>\r\n                </tr>\r\n                <tr>\r\n                    <th align=\"left\" width=\"50%\">" . lang("tickets_txt_5", true) . "</th>\r\n                    <td>" . stripslashes($thisTicket["subject"]) . "</td>\r\n                </tr>\r\n                <tr>\r\n                    <th align=\"left\" width=\"50%\">" . lang("tickets_txt_20", true) . "</th>\r\n                    <td>" . $thisTicket["author"] . "</td>\r\n                </tr>\r\n                <tr>\r\n                    <th align=\"left\" width=\"50%\">" . lang("tickets_txt_21", true) . "</th>\r\n                    <td>" . $date . "</td>\r\n                </tr>\r\n                <tr>\r\n                    <th align=\"left\" width=\"50%\">" . lang("tickets_txt_7", true) . "</th>\r\n                    <td>" . $update . "" . $by . " " . $thisTicket["updatedBy"] . "</td>\r\n                </tr>\r\n                <tr>\r\n                    <th align=\"left\" width=\"50%\">" . lang("tickets_txt_6", true) . "</th>\r\n                    <td>" . $thisTicketstatus . "</td>\r\n                </tr>\r\n            </table>\r\n        </div>\r\n        <div class=\"col-xs-12 col-sm-12 col-md-6 col-lg-8\">\r\n            <table class=\"table table-hover text-center table-bug-tracker\">\r\n                <tr>\r\n                    <td>" . stripslashes($thisTicket["message"]) . "</td>\r\n                </tr>\r\n            </table>";
                    $ticketReplies = $Ticket->getMyReplies($ticket_id);
                    if (is_array($ticketReplies)) {
                        foreach ($ticketReplies as $thisReply) {
                            $replyData = $Ticket->getReplyById($thisReply);
                            if ($replyData["author"] != $_SESSION["username"] || $replyData["staff_reply"] == "1") {
                                $tblstyle = "admin-reply";
                            } else {
                                $tblstyle = "";
                            }
                            $date = date($config["time_date_format"], strtotime($replyData["date"]));
                            echo "\r\n            <table class=\"table table-hover text-center " . $tblstyle . "\">\r\n                <tr>\r\n                    <th class=\"headerRow ticket-msg-author\">" . $replyData["author"] . "</th>\r\n                    <th class=\"headerRow ticket-msg-date\">" . $date . "</th>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan=\"2\" align=\"left\">" . stripslashes($replyData["message"]) . "</td>\r\n                </tr>\r\n            </table>";
                        }
                    }
                    if ($thisTicket["status"] != 1) {
                        $token = time();
                        $_SESSION["token"] = $token;
                        echo "\r\n            <form action=\"\" method=\"post\">\r\n                <div class=\"form-group\">\r\n                    <textarea rows=\"6\" class=\"form-control\" name=\"message\" required title=\"" . sprintf(lang("tickets_txt_15", true), 10, 2000) . "\" maxlength=\"2000\"></textarea>\r\n                </div>\r\n                <div class=\"form-group\">\r\n                    <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                    <input type=\"submit\" name=\"submit\" value=\"" . lang("tickets_txt_22", true) . "\" class=\"btn btn-warning full-width-btn\">\r\n                </div>\r\n            </form>\r\n        </div>\r\n    </div>";
                    }
                }
            } else {
                message("error", lang("tickets_error_2", true));
            }
        } else {
            message("error", lang("error_47", true));
        }
    } else {
        echo "\r\n<div class=\"sub-page-title\">\r\n    <div id=\"title\"><h1>" . lang("module_titles_txt_3", true) . "<p></p><span></span></h1></div>\r\n</div>\r\n<div class=\"container_2 account\" align=\"center\">\r\n    <div class=\"cont-image\">\r\n        <div class=\"container_3 account_sub_header\">\r\n            <div class=\"grad\">\r\n                <div class=\"page-title\">" . lang("tickets_txt_1", true) . "</div>\r\n                <div class=\"sub-active-page\">" . lang("tickets_txt_12", true) . "</div>\r\n                <a href=\"" . __BASE_URL__ . "ticket/new\" style=\"background-image: none;padding: 9px 12px 10px 10px\">" . lang("tickets_txt_3", true) . "</a>\r\n                <a href=\"" . __BASE_URL__ . "ticket\">" . lang("tickets_txt_13", true) . "</a>\r\n            </div>\r\n        </div>";
        if (mconfig("active") && mconfig("ticket_enable_view")) {
            echo "<div class=\"page-desc-holder\">";
            $Ticket = new Ticket();
            echo "</div><br />";
            if (check_value($_GET["id"])) {
                $ticket_id = xss_clean(htmlspecialchars($_GET["id"]));
                $checkTicketOwner = $Ticket->checkTicketOwner($ticket_id, $_SESSION["username"]);
                if ($checkTicketOwner == NULL) {
                    message("error", lang("tickets_error_1", true));
                } else {
                    $thisTicket = $Ticket->getTicketById($ticket_id);
                    if (check_value($_POST["submit"])) {
                        if ($_SESSION["token"] == $_POST["token"]) {
                            $checkSubmit = $Ticket->SubmitReply($ticket_id, $_POST["message"], $_SESSION["username"]);
                            $Ticket->updateLastSeenTicket($ticket_id, date("Y-m-d H:i:s", time() + 60));
                        } else {
                            message("notice", lang("global_module_13", true));
                        }
                    }
                    $Ticket->updateLastSeenTicket($ticket_id, date("Y-m-d H:i:s", time()));
                    $date = date($config["time_date_format"], strtotime($thisTicket["date"]));
                    if ($thisTicket["updated"] == NULL) {
                        $update = lang("tickets_txt_17", true);
                        $by = "";
                    } else {
                        $update = date($config["time_date_format"], strtotime($thisTicket["updated"]));
                        $by = " " . lang("tickets_txt_18", true);
                    }
                    if ($thisTicket["status"] == 0) {
                        $thisTicketstatus = "<span class=\"ticket-open\">" . lang("tickets_txt_9", true) . "</span>";
                    } else {
                        if ($thisTicket["status"] == 1) {
                            $thisTicketstatus = "<span class=\"ticket-closed\">" . lang("tickets_txt_10", true) . "</span>";
                        } else {
                            if ($thisTicket["status"] == 2) {
                                $thisTicketstatus = "<span class=\"ticket-wait\">" . lang("tickets_txt_11", true) . "</span>";
                            }
                        }
                    }
                    echo "\r\n        <div class=\"container_3 account-wide\" align=\"center\">\r\n            <table class=\"general-table-ui\" cellspacing=\"0\">\r\n                <tr>\r\n                    <th align=\"left\" width=\"50%\">" . lang("tickets_txt_19", true) . ":</th>\r\n                    <td>#" . $thisTicket["ticket_id"] . "</td>\r\n                </tr>\r\n                <tr>\r\n                    <th align=\"left\" width=\"50%\">" . lang("tickets_txt_5", true) . ":</th>\r\n                    <td>" . stripslashes($thisTicket["subject"]) . "</td>\r\n                </tr>\r\n                <tr>\r\n                    <th align=\"left\" width=\"50%\">" . lang("tickets_txt_20", true) . ":</th>\r\n                    <td>" . $thisTicket["author"] . "</td>\r\n                </tr>\r\n                <tr>\r\n                    <th align=\"left\" width=\"50%\">" . lang("tickets_txt_21", true) . ":</th>\r\n                    <td>" . $date . "</td>\r\n                </tr>\r\n                <tr>\r\n                    <th align=\"left\" width=\"50%\">" . lang("tickets_txt_7", true) . ":</th>\r\n                    <td>" . $update . "" . $by . " " . $thisTicket["updatedBy"] . "</td>\r\n                </tr>\r\n                <tr>\r\n                    <th align=\"left\" width=\"50%\">" . lang("tickets_txt_6", true) . ":</th>\r\n                    <td>" . $thisTicketstatus . "</td>\r\n                </tr>\r\n            </table>\r\n            <br /><br />\r\n            <table class=\"general-table-ui\" cellspacing=\"0\">\r\n                <tr>\r\n                    <th align=\"left\">" . $thisTicket["author"] . ":</th>\r\n                </tr>\r\n                <tr>\r\n                    <td align=\"left\">" . stripslashes($thisTicket["message"]) . "</td>\r\n                </tr>\r\n            </table>";
                    $ticketReplies = $Ticket->getMyReplies($ticket_id);
                    if (is_array($ticketReplies)) {
                        foreach ($ticketReplies as $thisReply) {
                            $replyData = $Ticket->getReplyById($thisReply);
                            if ($replyData["author"] != $_SESSION["username"]) {
                                $tblstyle = "ticket-table-ui3";
                            } else {
                                $tblstyle = "general-table-ui";
                            }
                            $date = date($config["time_date_format"], strtotime($replyData["date"]));
                            echo "\r\n            <table class=\"" . $tblstyle . "\" cellspacing=\"0\">\r\n                <tr>\r\n                    <th align=\"left\">" . $replyData["author"] . ":</th>\r\n                    <th align=\"right\">" . $date . "</th>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan=\"2\" align=\"left\">" . stripslashes($replyData["message"]) . "</td>\r\n                </tr>\r\n            </table>";
                        }
                    }
                    if ($thisTicket["status"] != 1) {
                        $token = time();
                        $_SESSION["token"] = $token;
                        echo "\r\n            <form action=\"\" method=\"post\">\r\n                <table class=\"general-table-ui\" cellspacing=\"0\">\r\n                    <tr>\r\n                        <td></td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td><textarea rows=\"6\" style=\"width: 802px;\" name=\"message\" required title=\"" . sprintf(lang("tickets_txt_15", true), 10, 2000) . "\" maxlength=\"2000\"></textarea></td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td align=\"right\"><input type=\"hidden\" name=\"token\" value=\"" . $token . "\"><button name=\"submit\" value=\"submit\" class=\"ui-button button1\" ><span class=\"button-left\"><span class=\"button-right\">" . lang("tickets_txt_22", true) . "</span></span></button></td>\r\n                    </tr>\r\n                </table>\r\n            </form>";
                    }
                    echo "\r\n        </div>";
                }
            } else {
                message("error", lang("tickets_error_2", true));
            }
        } else {
            message("error", lang("error_47", true));
        }
        echo "\r\n    </div>\r\n</div>";
    }
}

?>