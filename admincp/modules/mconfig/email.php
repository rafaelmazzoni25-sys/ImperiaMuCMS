<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h1 class=\"page-header\">Email Settings</h1>\n";
if (check_value($_POST["submit_changes"])) {
    savechanges();
}
if (check_value($_POST["send_email"])) {
    if (!Validator::Email($_POST["test_email"])) {
        message("error", $_POST["test_email"] . " is not a valid email address.");
    } else {
        try {
            $email = new Email();
            $email->setTemplate("TEST_EMAIL");
            $email->addAddress($_POST["test_email"]);
            $check = $email->send();
        } catch (Exception $ex) {
            message("error", $ex->getMessage());
            if ($check) {
                message("success", "Email was successfully sent to " . $_POST["test_email"] . ".");
            }
        }
    }
}
$emailConfigs = gconfig("email", true);
echo "\n";
message("warning", "You must edit <strong>/includes/config/email.xml</strong> manually to edit the email titles.", "NOTE:");
echo "\n<form method=\"post\" action=\"\">\n    <div style=\"float: left; height: 70px;\">\n        <button type=\"button\" class=\"btn btn-info btn-lg\" data-toggle=\"modal\" data-target=\"#massEmail\" disabled=\"disabled\">Send Mass Email <small>(this feature will be added in version 2.0.0)</small>\n        </button>\n    </div>\n    <div style=\"float: right; height: 70px;\">\n        Email: <input class=\"form-control\" name=\"test_email\" type=\"text\" placeholder=\"test@email.com\" style=\"display: inline-block; width: 250px;\"/>\n        <input type=\"submit\" name=\"send_email\" class=\"btn btn-primary\" value=\"Send Test Email\"/>\n    </div>\n</form>\n\n<form method=\"post\" action=\"\">\n    <div id=\"massEmail\" class=\"modal fade\" role=\"dialog\">\n        <div class=\"modal-dialog modal-lg\">\n            <div class=\"modal-content\">\n                <div class=\"modal-header\">\n                    <button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>\n                    <h4 class=\"modal-title\">Send Mass Email</h4>\n                </div>\n                <div class=\"modal-body\">\n                    <textarea name=\"email_text\" id=\"email_text\"></textarea>\n                </div>\n                <div class=\"modal-footer\">\n                    <button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>\n                    <input type=\"submit\" name=\"send_mass_email\" class=\"btn btn-success\" value=\"Send Mass Email\"/>\n                </div>\n            </div>\n        </div>\n    </div>\n</form>\n\n<script src=\"";
echo __BASE_URL__;
echo "admincp/ckeditor/ckeditor.js\"></script>\n<script type=\"text/javascript\">//<![CDATA[\n    //CKEDITOR.replace('editor1');\n    CKEDITOR.replace('email_text', {\n        language: 'en',\n        uiColor: '#f1f1f1'\n    });\n    //]]></script>\n\n<form action=\"\" method=\"post\">\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\n        <tr>\n            <th>Email System<br/><span>Enable/disable the email system.</span></th>\n            <td>\n                ";
enabledisableCheckboxes("setting_1", $emailConfigs["active"], "Enabled", "Disabled");
echo "            </td>\n        </tr>\n        <tr>\n            <th>Send Email From<br/><span></span></th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"setting_2\" value=\"";
echo $emailConfigs["send_from"];
echo "\"/>\n            </td>\n        </tr>\n        <tr>\n            <th>Send Email From Name<br/><span></span></th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"setting_3\" value=\"";
echo $emailConfigs["send_name"];
echo "\"/>\n            </td>\n        </tr>\n        <tr>\n            <th>SMTP Status<br/><span>Enable/disable the SMTP system.</span></th>\n            <td>\n                ";
enabledisableCheckboxes("setting_4", $emailConfigs["smtp_active"], "Enabled", "Disabled");
echo "            </td>\n        </tr>\n        <tr>\n            <th>SMTP Host<br/><span></span></th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"setting_5\" value=\"";
echo $emailConfigs["smtp_host"];
echo "\"/>\n            </td>\n        </tr>\n        <tr>\n            <th>SMTP Port<br/><span></span></th>\n            <td>\n                <input type=\"text\" class=\"form-control\" name=\"setting_6\"\n                       value=\"";
echo $emailConfigs["smtp_port"];
echo "\"/>\n            </td>\n        </tr>\n        <tr>\n            <th>SMTP Authentication<br/><span>Whether to use SMTP authentication.</span><br/>\n                <span>Uses the Username and Password properties.</span>\n            </th>\n            <td>\n                ";
enabledisableCheckboxes("setting_9", $emailConfigs["smtp_secure"] == "none" ? 0 : 1, "Enabled", "Disabled");
echo "            </td>\n        </tr>\n        <tr>\n            <th>SMTP User<br/><span></span></th>\n            <td>\n                <input class=\"form-control\" type=\"text\" name=\"setting_7\" value=\"";
echo $emailConfigs["smtp_user"];
echo "\"/>\n            </td>\n        </tr>\n        <tr>\n            <th>SMTP Password<br/><span></span></th>\n            <td>\n                <input class=\"form-control\" type=\"password\" name=\"setting_8\" value=\"";
echo $emailConfigs["smtp_pass"];
echo "\"/>\n            </td>\n        </tr>\n        <tr>\n            <th>SMTP Secure<br/><span>Enable/disable SSL/TLS encryption use on the SMTP connection.</span></th>\n            <td>\n                <select name=\"setting_10\" class=\"form-control\">\n                    <option value=\"none\" ";
echo $emailConfigs["smtp_secure"] == "none" ? "selected=\"selected\"" : "";
echo ">None</option>\n                    <option value=\"ssl\" ";
echo $emailConfigs["smtp_secure"] == "ssl" ? "selected=\"selected\"" : "";
echo ">SSL</option>\n                    <option value=\"tls\" ";
echo $emailConfigs["smtp_secure"] == "tls" ? "selected=\"selected\"" : "";
echo ">TLS</option>\n                </select>\n            </td>\n        </tr>\n        <tr>\n            <td colspan=\"2\"><input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\" class=\"btn btn-success\"/>\n            </td>\n        </tr>\n    </table>\n</form>";
function saveChanges()
{
    
    foreach ($_POST as $setting) {
        if (!check_value($setting)) {
            message("error", "Missing data (complete all fields).");
            return NULL;
        }
    }
    $xmlPath = __PATH_CONFIGS__ . "email.xml";
    $xml = simplexml_load_file($xmlPath);
    $xml->active = trim($_POST["setting_1"]);
    $xml->send_from = trim($_POST["setting_2"]);
    $xml->send_name = trim($_POST["setting_3"]);
    $xml->smtp_active = trim($_POST["setting_4"]);
    $xml->smtp_host = trim($_POST["setting_5"]);
    $xml->smtp_port = trim($_POST["setting_6"]);
    $xml->smtp_user = trim($_POST["setting_7"]);
    $xml->smtp_pass = trim($_POST["setting_8"]);
    $xml->smtp_secure = trim($_POST["setting_10"]);
    $save = $xml->asXML($xmlPath);
    if ($save) {
        message("success", "Settings successfully saved.");
    } else {
        message("error", "There has been an error while saving changes.");
    }
}

?>