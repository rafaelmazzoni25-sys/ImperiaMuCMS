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
        echo "\r\n    <h3>\r\n        " . lang("tickets_txt_2", true) . "\r\n        <a href=\"" . __BASE_URL__ . "ticket/new\" class=\"btn btn-warning btn-navtop\">" . lang("tickets_txt_3", true) . "</a>\r\n        " . $breadcrumb . "\r\n    </h3>";
        if (mconfig("active") && mconfig("ticket_enable_my")) {
            $Ticket = new Ticket();
            if (check_value($_POST["submit"])) {
                if ($_SESSION["token"] == $_POST["token"]) {
                    $checkSubmit = $Ticket->SubmitTicket($_POST["subject"], $_POST["message"], $_SESSION["username"]);
                    $token = time();
                    $_SESSION["token"] = $token;
                } else {
                    message("notice", lang("global_module_13", true));
                }
            }
            $MyTickets = $Ticket->getMyTickets($_SESSION["username"]);
            if (is_array($MyTickets)) {
                echo "\r\n    <div class=\"table-responsive rankings-table\">\r\n        <table class=\"table table-hover text-center\">\r\n            <tr>\r\n                <th class=\"headerRow\">" . lang("tickets_txt_4", true) . "</th>\r\n                <th class=\"headerRow\">" . lang("tickets_txt_5", true) . "</th>\r\n                <th class=\"headerRow\">" . lang("tickets_txt_6", true) . "</th>\r\n                <th class=\"headerRow\">" . lang("tickets_txt_7", true) . "</th>\r\n                <th class=\"headerRow\">" . lang("tickets_txt_8", true) . "</th>\r\n            </tr>";
                foreach ($MyTickets as $thisTicket) {
                    $ticketData = $Ticket->getTicketById($thisTicket);
                    $date = date($config["time_date_format"], strtotime($ticketData["date"]));
                    if ($ticketData["status"] == 0) {
                        $ticketData["status"] = "<span class=\"ticket-open\">" . lang("tickets_txt_9", true) . "</font>";
                    } else {
                        if ($ticketData["status"] == 1) {
                            $ticketData["status"] = "<span class=\"ticket-closed\">" . lang("tickets_txt_10", true) . "</font>";
                        } else {
                            if ($ticketData["status"] == 2) {
                                $ticketData["status"] = "<span class=\"ticket-wait\">" . lang("tickets_txt_11", true) . "</font>";
                            }
                        }
                    }
                    if ($ticketData["updated"] == NULL) {
                        $update = lang("tickets_txt_26", true);
                        $by = "";
                    } else {
                        $update = date($config["time_date_format"], strtotime($ticketData["updated"]));
                        $by = " " . lang("tickets_txt_27", true);
                    }
                    echo "\r\n            <tr>\r\n                <td>" . $date . "</td>\r\n                <td>" . stripslashes($ticketData["subject"]) . "</td>\r\n                <td>" . $ticketData["status"] . "</td>\r\n                <td>" . $update . $by . " " . $ticketData["updatedBy"] . "</td>\r\n                <td><a href=\"" . __BASE_URL__ . "ticket/view/?id=" . $ticketData["ticket_id"] . "\">" . lang("tickets_txt_12", true) . "</a></td>\r\n            </tr>";
                }
                echo "\r\n        </table>\r\n    </div>";
            } else {
                message("notice", lang("error_59", true));
            }
        } else {
            message("error", lang("error_47", true));
        }
    } else {
        echo "\r\n<div class=\"sub-page-title\">\r\n    <div id=\"title\"><h1>" . lang("module_titles_txt_3", true) . "<p></p><span></span></h1></div>\r\n</div>\r\n<div class=\"container_2 account\" align=\"center\">\r\n    <div class=\"cont-image\">\r\n        <div class=\"container_3 account_sub_header\">\r\n            <div class=\"grad\">\r\n                <div class=\"page-title\">" . lang("tickets_txt_1", true) . "</div>\r\n                <div class=\"sub-active-page\">" . lang("tickets_txt_2", true) . "</div>\r\n                <a href=\"" . __BASE_URL__ . "ticket/new\" style=\"background-image: none;padding: 9px 12px 10px 10px\">" . lang("tickets_txt_3", true) . "</a>\r\n                <a href=\"" . __BASE_URL__ . "usercp\">" . lang("global_module_1", true) . "</a>\r\n            </div>\r\n        </div>";
        $Ticket = new Ticket();
        if (check_value($_POST["submit"])) {
            if ($_SESSION["token"] == $_POST["token"]) {
                $checkSubmit = $Ticket->SubmitTicket($_POST["subject"], $_POST["message"], $_SESSION["username"]);
                $token = time();
                $_SESSION["token"] = $token;
            } else {
                message("notice", lang("global_module_13", true));
            }
        }
        if (mconfig("active") && mconfig("ticket_enable_my")) {
            echo "<div class=\"page-desc-holder\"></div>";
            $MyTickets = $Ticket->getMyTickets($_SESSION["username"]);
            if (is_array($MyTickets)) {
                echo "\r\n        <div class=\"container_3 account-wide\" align=\"center\">\r\n            <table class=\"irq\" cellspacing=\"0\" width=\"100%\">\r\n                <tr>\r\n                    <th>" . lang("tickets_txt_4", true) . "</th>\r\n                    <th>" . lang("tickets_txt_5", true) . "</th>\r\n                    <th>" . lang("tickets_txt_6", true) . "</th>\r\n                    <th>" . lang("tickets_txt_7", true) . "</th>\r\n                    <th>" . lang("tickets_txt_8", true) . "</th>\r\n                </tr>";
                foreach ($MyTickets as $thisTicket) {
                    $ticketData = $Ticket->getTicketById($thisTicket);
                    $date = date($config["time_date_format"], strtotime($ticketData["date"]));
                    if ($ticketData["status"] == 0) {
                        $ticketData["status"] = "<font color=\"green\">" . lang("tickets_txt_9", true) . "</font>";
                    } else {
                        if ($ticketData["status"] == 1) {
                            $ticketData["status"] = "<font color=\"red\">" . lang("tickets_txt_10", true) . "</font>";
                        } else {
                            if ($ticketData["status"] == 2) {
                                $ticketData["status"] = "<font color=\"orange\">" . lang("tickets_txt_11", true) . "</font>";
                            }
                        }
                    }
                    if ($ticketData["updated"] == NULL) {
                        $update = "never";
                        $by = "";
                    } else {
                        $update = date($config["time_date_format"], strtotime($ticketData["updated"]));
                        $by = " by";
                    }
                    echo "\r\n                <tr>\r\n                    <td>" . $date . "</td>\r\n                    <td>" . stripslashes($ticketData["subject"]) . "</td>\r\n                    <td>" . $ticketData["status"] . "</td>\r\n                    <td>" . $update . "" . $by . " " . $ticketData["updatedBy"] . "</td>\r\n                    <td><a href=\"" . __BASE_URL__ . "ticket/view/?id=" . $ticketData["ticket_id"] . "\">" . lang("tickets_txt_12", true) . "</a></td>\r\n                </tr>";
                }
                echo "\r\n            </table>\r\n        </div>";
            } else {
                message("notice", lang("error_59", true));
            }
        } else {
            message("error", lang("error_47", true));
        }
        echo "\r\n    </div>\r\n</div>";
    }
}

?>