<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

if (!isLoggedIn()) {
    redirect(1, "login");
} else {
    loadModuleConfigs("bugtracker");
    if (!canAccessModule($_SESSION["username"], "bugtracker", "block")) {
        return NULL;
    }
    $id = xss_clean(htmlspecialchars($_GET["id"]));
    $BugTracker = new BugTracker();
    if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
        $breadcrumb = generateBreadcrumb();
        echo "\r\n    <h3>\r\n        " . lang("module_titles_txt_29", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
        if (mconfig("active")) {
            $General = new xGeneral();
            $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("bugtracker");
            $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("bugtracker");
            if (check_value($_GET["id"])) {
                $thisReport = $BugTracker->getReportByID($id);
                if (is_array($thisReport)) {
                    if (check_value($_POST["submit"])) {
                        if ($_SESSION["token"] == $_POST["token"]) {
                            $checkSubmit = $BugTracker->SubmitReply($id, $_POST["text"], $_SESSION["username"]);
                            $BugTracker->updateLastUpdatedReport($id, $_SESSION["username"]);
                            $BugTracker->updateLastSeenReport($id, date("Y-m-d H:i:s", time() + 60));
                        } else {
                            message("notice", lang("global_module_13", true));
                        }
                    }
                    $date = date($config["time_date_format"], strtotime($thisReport["date"]));
                    $status = $BugTracker->getStatusName($thisReport["status"], "span");
                    if ($_SESSION["username"] == $thisReport["author"]) {
                        $BugTracker->updateLastSeenReport($thisReport["id"], date("Y-m-d H:i:s", time()));
                    }
                    echo "\r\n    <div class=\"row\">\r\n        <div class=\"col-xs-12 col-sm-12 col-md-6 col-lg-4\">\r\n            <table class=\"table table-hover text-center\">\r\n                <tr>\r\n                    <th>" . lang("bugtracker_txt_14", true) . "</th>\r\n                    <td>" . stripslashes($thisReport["title"]) . "</td>\r\n                </tr>\r\n                <tr>\r\n                    <th>" . lang("bugtracker_txt_15", true) . "</th>\r\n                    <td>";
                    if (mconfig("hide_names")) {
                        echo lang("bugtracker_txt_45", true);
                    } else {
                        echo $thisReport["author"];
                    }
                    echo "\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>" . lang("bugtracker_txt_16", true) . "</th>\r\n                    <td>" . $date . "</td>\r\n                </tr>\r\n                <tr>\r\n                    <th>" . lang("bugtracker_txt_17", true) . "</th>\r\n                    <td>" . $status . "</td>\r\n                </tr>\r\n            </table>\r\n        </div>\r\n        <div class=\"col-xs-12 col-sm-12 col-md-6 col-lg-8\">\r\n            <table class=\"table table-hover text-center table-bug-tracker\">\r\n                <tr>\r\n                    <td>" . stripslashes($thisReport["text"]) . "</td>\r\n                </tr>\r\n            </table>";
                    $reportReplies = $BugTracker->getReplies($id);
                    if (is_array($reportReplies)) {
                        foreach ($reportReplies as $thisReply) {
                            $replyData = $BugTracker->getReplyById($thisReply["id"]);
                            $tblstyle = "";
                            if (array_key_exists($replyData["author"], $config["admins"]) || $replyData["author"] == mconfig("staff_nickname") || $thisReply["staff_reply"] == "1") {
                                $tblstyle = "admin-reply";
                                $replyData["author"] = mconfig("staff_nickname");
                            }
                            $date = date($config["time_date_format"], strtotime($replyData["date"]));
                            $msgAuthor = NULL;
                            if (mconfig("hide_names")) {
                                if (array_key_exists($replyData["author"], $config["admins"]) || $replyData["author"] == mconfig("staff_nickname") || $thisReply["staff_reply"] == "1") {
                                    $msgAuthor = $replyData["author"];
                                } else {
                                    $msgAuthor = lang("bugtracker_txt_45", true);
                                }
                            } else {
                                $msgAuthor = $replyData["author"];
                            }
                            echo "\r\n            <table class=\"table table-hover text-center table-bug-tracker " . $tblstyle . "\">\r\n                <tr>\r\n                    <th class=\"headerRow tracker-msg-author\">" . $msgAuthor . "</th>\r\n                    <th class=\"headerRow tracker-msg-date\">" . $date . "</th>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan=\"2\" align=\"left\">" . stripslashes($replyData["text"]) . "</td>\r\n                </tr>\r\n            </table>";
                        }
                    }
                    if ($thisReport["status"] == 0 || $thisReport["status"] == 6 || $thisReport["status"] == 7) {
                        $token = time();
                        $_SESSION["token"] = $token;
                        if (mconfig("reply_only_own")) {
                            if ($thisReport["author"] == $_SESSION["username"] || array_key_exists($_SESSION["username"], $config["admins"])) {
                                echo "\r\n            <div class=\"bug-tracker-add-reply\">\r\n                <form action=\"\" method=\"post\">\r\n                    <textarea rows=\"6\" class=\"form-control bug-tracker-add-reply-area\" name=\"text\" required title=\"" . lang("bugtracker_txt_18", true) . "\" maxlength=\"" . mconfig("text_max") . "\"></textarea>\r\n                    <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                    <button name=\"submit\" value=\"submit\" class=\"btn btn-warning bug-tracker-add-reply-btn\">\r\n                        " . lang("bugtracker_txt_19", true) . "\r\n                    </button>\r\n                </form>\r\n            </div>";
                            }
                        } else {
                            echo "\r\n            <div class=\"bug-tracker-add-reply\">\r\n                <form action=\"\" method=\"post\">\r\n                    <textarea rows=\"6\" class=\"form-control bug-tracker-add-reply-area\" name=\"text\" required title=\"" . lang("bugtracker_txt_18", true) . "\" maxlength=\"" . mconfig("text_max") . "\"></textarea>\r\n                    <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                    <button name=\"submit\" value=\"submit\" class=\"btn btn-warning bug-tracker-add-reply-btn\">\r\n                        " . lang("bugtracker_txt_19", true) . "\r\n                    </button>\r\n                </form>\r\n            </div>";
                        }
                    }
                    echo "\r\n        </div>\r\n    </div>";
                } else {
                    message("error", lang("bugtracker_error_1", true));
                }
            } else {
                message("error", lang("bugtracker_error_1", true));
            }
        } else {
            message("error", lang("error_47", true));
        }
    } else {
        echo "\r\n\t<div class=\"sub-page-title\">\r\n\t <div id=\"title\"><h1>" . lang("module_titles_txt_29", true) . "<p></p><span></span></h1></div>\r\n  </div>\r\n  <div class=\"container_2 account\" align=\"center\">\r\n    <div class=\"cont-image\">\r\n      <div class=\"container_3 account_sub_header\">\r\n        <div class=\"grad\">\r\n          <div class=\"page-title\">" . lang("bugtracker_txt_12", true) . "</div>\r\n          <div class=\"sub-active-page\">" . lang("bugtracker_txt_13", true) . $id . "</div>\r\n          <a href=\"" . __BASE_URL__ . "bugtracker\">" . lang("bugtracker_txt_2", true) . "</a>\r\n        </div>\r\n      </div>";
        if (mconfig("active")) {
            $General = new xGeneral();
            $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("bugtracker");
            $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("bugtracker");
            if (check_value($_GET["id"])) {
                $thisReport = $BugTracker->getReportByID($id);
                if (is_array($thisReport)) {
                    if (check_value($_POST["submit"])) {
                        if ($_SESSION["token"] == $_POST["token"]) {
                            $checkSubmit = $BugTracker->SubmitReply($id, $_POST["text"], $_SESSION["username"]);
                            $BugTracker->updateLastUpdatedReport($id, $_SESSION["username"]);
                            $BugTracker->updateLastSeenReport($id, date("Y-m-d H:i:s", time() + 60));
                        } else {
                            message("notice", lang("global_module_13", true));
                        }
                    }
                    $date = date($config["time_date_format"], strtotime($thisReport["date"]));
                    $status = $BugTracker->getStatusName($thisReport["status"], "span");
                    if ($_SESSION["username"] == $thisReport["author"]) {
                        $BugTracker->updateLastSeenReport($thisReport["id"], date("Y-m-d H:i:s", time()));
                    }
                    echo "\r\n          <div class=\"container_3 account-wide\" align=\"center\">\r\n            <table class=\"general-table-ui\" cellspacing=\"0\">\r\n              <tr>\r\n                <th align=\"left\" width=\"50%\">" . lang("bugtracker_txt_14", true) . ":</th>\r\n                <td>" . stripslashes($thisReport["title"]) . "</td>\r\n              </tr>\r\n              <tr>\r\n                <th align=\"left\" width=\"50%\">" . lang("bugtracker_txt_15", true) . ":</th>\r\n                <td>";
                    if (mconfig("hide_names")) {
                        echo lang("bugtracker_txt_45", true);
                    } else {
                        echo $thisReport["author"];
                    }
                    echo "</td>\r\n              </tr>\r\n              <tr>\r\n                <th align=\"left\" width=\"50%\">" . lang("bugtracker_txt_16", true) . ":</th>\r\n                <td>" . $date . "</td>\r\n              </tr>\r\n              <tr>\r\n                <th align=\"left\" width=\"50%\">" . lang("bugtracker_txt_17", true) . ":</th>\r\n                <td>" . $status . "</td>\r\n              </tr>\r\n            </table>\r\n            <br /><br />\r\n            <table class=\"general-table-ui\" cellspacing=\"0\">\r\n              <tr>\r\n                <th align=\"left\">";
                    if (mconfig("hide_names")) {
                        echo lang("bugtracker_txt_45", true);
                    } else {
                        echo $thisReport["author"];
                    }
                    echo ":</th>\r\n              </tr>\r\n              <tr>\r\n                <td align=\"left\">" . stripslashes($thisReport["text"]) . "</td>\r\n              </tr>\r\n            </table>";
                    $reportReplies = $BugTracker->getReplies($id);
                    if (is_array($reportReplies)) {
                        foreach ($reportReplies as $thisReply) {
                            $replyData = $BugTracker->getReplyById($thisReply["id"]);
                            if (array_key_exists($replyData["author"], $config["admins"]) || $replyData["author"] == mconfig("staff_nickname")) {
                                $tblstyle = "ticket-table-ui3";
                                $replyData["author"] = mconfig("staff_nickname");
                            } else {
                                $tblstyle = "general-table-ui";
                            }
                            $date = date($config["time_date_format"], strtotime($replyData["date"]));
                            echo "\r\n                <table class=\"" . $tblstyle . "\" cellspacing=\"0\">\r\n                  <tr>\r\n                    <th align=\"left\">";
                            if (mconfig("hide_names")) {
                                if (array_key_exists($replyData["author"], $config["admins"]) || $replyData["author"] == mconfig("staff_nickname")) {
                                    echo $replyData["author"];
                                } else {
                                    echo lang("bugtracker_txt_45", true);
                                }
                            } else {
                                echo $replyData["author"];
                            }
                            echo "</th>\r\n                    <th align=\"right\">" . $date . "</th>\r\n                  </tr>\r\n                  <tr>\r\n                    <td colspan=\"2\" align=\"left\">" . stripslashes($replyData["text"]) . "</td>\r\n                  </tr>\r\n                </table>";
                        }
                    }
                    if ($thisReport["status"] == 0 || $thisReport["status"] == 6 || $thisReport["status"] == 7) {
                        $token = time();
                        $_SESSION["token"] = $token;
                        if (mconfig("reply_only_own")) {
                            if ($thisReport["author"] == $_SESSION["username"] || array_key_exists($_SESSION["username"], $config["admins"])) {
                                echo "\r\n              <form action=\"\" method=\"post\">\r\n                <table class=\"general-table-ui\" cellspacing=\"0\">\r\n                  <tr>\r\n                    <td></td>\r\n                  </tr>\r\n                  <tr>\r\n                    <td><textarea rows=\"6\" style=\"width: 802px;\" name=\"text\" required title=\"" . lang("bugtracker_txt_18", true) . "\" maxlength=\"" . mconfig("text_max") . "\"></textarea></td>\r\n                  </tr>\r\n                  <tr>\r\n                    <td align=\"right\"><input type=\"hidden\" name=\"token\" value=\"" . $token . "\"><button name=\"submit\" value=\"submit\" class=\"ui-button button1\" ><span class=\"button-left\"><span class=\"button-right\">" . lang("bugtracker_txt_19", true) . "</span></span></button></td>\r\n                  </tr>\r\n                </table>\r\n              </form>";
                            }
                        } else {
                            echo "\r\n              <form action=\"\" method=\"post\">\r\n                <table class=\"general-table-ui\" cellspacing=\"0\">\r\n                  <tr>\r\n                    <td></td>\r\n                  </tr>\r\n                  <tr>\r\n                    <td><textarea rows=\"6\" style=\"width: 802px;\" name=\"text\" required title=\"" . lang("bugtracker_txt_18", true) . "\" maxlength=\"" . mconfig("text_max") . "\"></textarea></td>\r\n                  </tr>\r\n                  <tr>\r\n                    <td align=\"right\"><input type=\"hidden\" name=\"token\" value=\"" . $token . "\"><button name=\"submit\" value=\"submit\" class=\"ui-button button1\" ><span class=\"button-left\"><span class=\"button-right\">" . lang("bugtracker_txt_19", true) . "</span></span></button></td>\r\n                  </tr>\r\n                </table>\r\n              </form>";
                        }
                    }
                    echo "</div>";
                } else {
                    message("error", lang("bugtracker_error_1", true));
                }
            } else {
                message("error", lang("bugtracker_error_1", true));
            }
        } else {
            message("error", lang("error_47", true));
        }
        echo "\r\n  </div>\r\n</div>";
    }
}

?>