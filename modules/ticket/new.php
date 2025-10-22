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
        echo "\r\n    <h3>\r\n        " . lang("tickets_txt_3", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
        if (mconfig("active") && mconfig("ticket_enable_view")) {
            $Ticket = new Ticket();
            $minlength = mconfig("subject_min_length");
            $maxlength = mconfig("subject_max_length");
            $minlength1 = mconfig("msg_min_length");
            $maxlength1 = mconfig("msg_max_length");
            $token = time();
            $_SESSION["token"] = $token;
            echo "\r\n    <div class=\"row\">\r\n        <div class=\"col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-center\">\r\n            <form method=\"post\" action=\"" . __BASE_URL__ . "ticket/my/\" class=\"form-horizontal\" name=\"submit_ticket\">\r\n                <div class=\"form-group\">\r\n                    <label class=\"col-sm-2 control-label ticket-label\">" . lang("tickets_txt_5", true) . "</label>\r\n                    <div class=\"col-sm-10\">\r\n                    <input type=\"text\" name=\"subject\" class=\"form-control\" pattern=\".{" . $minlength . "," . $maxlength . "}\" required title=\"" . sprintf(lang("tickets_txt_15", true), $minlength, $maxlength) . "\" value=\"" . $_POST["subject"] . "\">\r\n                    </div>\r\n                </div>\r\n                <div class=\"form-group\">\r\n                    <label class=\"col-sm-2 control-label ticket-label\">" . lang("tickets_txt_14", true) . "</label>\r\n                    <div class=\"col-sm-10\">\r\n                    <textarea maxlength=\"" . $maxlength1 . "\" rows=\"15\" class=\"form-control\" name=\"message\" required title=\"" . sprintf(lang("tickets_txt_15", true), $minlength1, $maxlength1) . "\">" . $_POST["message"] . "</textarea>\r\n                    </div>\r\n                </div>\r\n                <div class=\"form-group\">\r\n                    <div class=\"col-sm-offset-2 col-sm-10\">\r\n                        <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                        <input type=\"submit\" name=\"submit\" value=\"" . lang("tickets_txt_16", true) . "\" class=\"btn btn-warning full-width-btn\">\r\n                    </div>\r\n                </div>\r\n            </form>\r\n        </div>\r\n    </div>";
        } else {
            message("error", lang("error_47", true));
        }
    } else {
        echo "\r\n<div class=\"sub-page-title\">\r\n    <div id=\"title\"><h1>" . lang("module_titles_txt_3", true) . "<p></p><span></span></h1></div>\r\n</div>\r\n<div class=\"container_2 account\" align=\"center\">\r\n    <div class=\"cont-image\">\r\n        <div class=\"container_3 account_sub_header\">\r\n            <div class=\"grad\">\r\n                <div class=\"page-title\">" . lang("tickets_txt_1", true) . "</div>\r\n                <div class=\"sub-active-page\">" . lang("tickets_txt_3", true) . "</div>\r\n                <a href=\"" . __BASE_URL__ . "ticket\">" . lang("tickets_txt_13", true) . "</a>\r\n            </div>\r\n        </div>";
        if (mconfig("active") && mconfig("ticket_enable_view")) {
            echo "<div class=\"page-desc-holder\">";
            $Ticket = new Ticket();
            echo "</div><br />";
            $minlength = mconfig("subject_min_length");
            $maxlength = mconfig("subject_max_length");
            $minlength1 = mconfig("msg_min_length");
            $maxlength1 = mconfig("msg_max_length");
            $token = time();
            $_SESSION["token"] = $token;
            echo "\r\n        <div class=\"container_3 account-wide\" align=\"center\">\r\n            <form method=\"post\" action=\"" . __BASE_URL__ . "ticket/my/\" class=\"ticket\" name=\"submit_ticket\">\r\n                <label>\r\n                    <p>" . lang("tickets_txt_5", true) . ":</p>\r\n                    <input type=\"text\" name=\"subject\" pattern=\".{" . $minlength . "," . $maxlength . "}\" required title=\"" . sprintf(lang("tickets_txt_15", true), $minlength, $maxlength) . "\" value=\"" . $_POST["subject"] . "\">\r\n                </label>\r\n                <label>\r\n                    <p>" . lang("tickets_txt_14", true) . ":</p>\r\n                    <textarea maxlength=\"" . $maxlength1 . "\" rows=\"15\" name=\"message\" required title=\"" . sprintf(lang("tickets_txt_15", true), $minlength1, $maxlength1) . "\">" . $_POST["message"] . "</textarea>\r\n                </label>\r\n                <div align=\"right\" style=\"margin-right:44px;padding-bottom:25px;\">\r\n                    <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                    <input type=\"submit\" name=\"submit\" value=\"" . lang("tickets_txt_16", true) . "\">\r\n                </div>\r\n            </form>\r\n        </div>";
        } else {
            message("error", lang("error_47", true));
        }
        echo "\r\n    </div>\r\n</div>";
    }
}

?>