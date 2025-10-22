<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<div class=\"page-container\">\r\n    <div class=\"page-title\"><span>";
lang("module_titles_txt_26");
echo "</span></div>\r\n    <div class=\"page-content\">\r\n        ";
if (mconfig("active")) {
    if (check_value($_POST["submit"])) {
        try {
            if (!check_value($_POST["contact_email"])) {
                throw new Exception(lang("error_41", true));
            }
            if (!check_value($_POST["contact_message"])) {
                throw new Exception(lang("error_41", true));
            }
            if (!Validator::Email($_POST["contact_email"])) {
                message("error", lang("error_9", true));
                return NULL;
            }
            if (!Validator::Length($_POST["contact_message"], 300, 10)) {
                throw new Exception(lang("error_57", true));
            }
            $email = new Email();
            $email->setMessage($_POST["contact_message"]);
            $email->addAddress($_POST["contact_email"]);
            $email->send();
            message("success", "Thank you for contacting us, we will respond to your message shortly.");
        } catch (Exception $ex) {
            message("error", $ex->getMessage());
        }
    }
    echo "<form action=\"\" method=\"post\"><table class=\"contact-table\"><tr><th>Email:</th></tr><tr><td><input type=\"text\" name=\"contact_email\" maxlength=\"255\"/></td></tr><tr><th>Message:</th></tr><tr><td><textarea name=\"contact_message\" maxlength=\"300\"></textarea><br /><small>300 characters limit.</small></td></tr><tr><td style=\"padding-top: 20px;\"><button name=\"submit\" value=\"submit\" class=\"ui-button button1\" ><span class=\"button-left\"><span class=\"button-right\">Send</span></span></button></td></tr></table></form>";
} else {
    message("error", lang("error_47", true));
}
echo "    </div>\r\n</div>";

?>