<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h2>Registration Settings</h2>\r\n";
if (check_value($_POST["submit_changes"])) {
    savechanges();
}
loadModuleConfigs("register");
echo "<form action=\"\" method=\"post\">\r\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n        <tr>\r\n            <th>Status<br/><span>Enable/disable the registration module.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_1", mconfig("active"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Terms of Service<br/><span>Enable/disable requirement for confirm ToS.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_9", mconfig("register_terms"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Show Country<br/><span>Enable/disable requirement to enter country.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("reg_country", mconfig("reg_country"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Show Secret Question & Answer<br/><span>Enable/disable requirement to enter secret question and answer.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("reg_secret_qa", mconfig("reg_secret_qa"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Show First & Last Name<br/><span>Enable/disable requirement to enter first and last name.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("reg_first_last_name", mconfig("reg_first_last_name"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Multi-Account<br/><span>Enable/disable option to register multiple accounts with same email address.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("multiacc", mconfig("multiacc"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>reCAPTCHA<br/><span>Enable/disable reCAPTCHA validation. <br/><br/> <a\r\n                            href=\"https://www.google.com/recaptcha\"\r\n                            target=\"_blank\">https://www.google.com/recaptcha</a></span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_2", mconfig("register_enable_recaptcha"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>reCAPTCHA Version<br/><span></span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes2("setting_8", mconfig("register_recaptcha_version"), "Version 2", "Version 1");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>reCAPTCHA Public Key<br/></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_3\"\r\n                       value=\"";
echo mconfig("register_recaptcha_public_key");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>reCAPTCHA Private Key<br/></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_4\"\r\n                       value=\"";
echo mconfig("register_recaptcha_private_key");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Email Verification<br/><span>If enabled, the user will receive an email with a verification link. The accout will not be created if the email is not verified.</span>\r\n            </th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_5", mconfig("verify_email"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Send Welcome Email<br/><span>Sends a welcome email after registering a new account.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_6", mconfig("send_welcome_email"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Verification Time Limit<br/><span>If <strong>Email Verification</strong> is Enabled. Set the amount of time the user has to verify the account. After the verification time limit passed, the user will have to repeat the registration process.</span>\r\n            </th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_7\" value=\"";
echo mconfig("verification_timelimit");
echo "\" style=\"display: inline; width: 150px\"/> Hour(s)\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Enable Free VIP<br/><span>Enable/disable free VIP for new accounts.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_10", mconfig("vip_enable"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>VIP Type<br/></th>\r\n            <td>\r\n                <select name=\"setting_11\" class=\"form-control\">\r\n                    ";
if (mconfig("vip_type") == "1") {
    echo "<option value=\"1\" selected=\"selected\">Bronze</option>";
} else {
    echo "<option value=\"1\">Bronze</option>";
}
if (mconfig("vip_type") == "2") {
    echo "<option value=\"2\" selected=\"selected\">Silver</option>";
} else {
    echo "<option value=\"2\">Silver</option>";
}
if (mconfig("vip_type") == "3") {
    echo "<option value=\"3\" selected=\"selected\">Gold</option>";
} else {
    echo "<option value=\"3\">Gold</option>";
}
if (mconfig("vip_type") == "4") {
    echo "<option value=\"4\" selected=\"selected\">Platinum</option>";
} else {
    echo "<option value=\"4\">Platinum</option>";
}
echo "                </select>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>VIP Hours<br/></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_12\" value=\"";
echo mconfig("vip_hours");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan=\"2\"><input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\" class=\"btn btn-success\"/>\r\n            </td>\r\n        </tr>\r\n    </table>\r\n</form>";
function saveChanges()
{
    
    foreach ($_POST as $setting) {
        if (!check_value($setting)) {
            message("error", "Missing data (complete all fields).");
            return NULL;
        }
    }
    $xmlPath = __PATH_MODULE_CONFIGS__ . "register.xml";
    $xml = simplexml_load_file($xmlPath);
    $xml->active = $_POST["setting_1"];
    $xml->register_terms = $_POST["setting_9"];
    $xml->reg_country = $_POST["reg_country"];
    $xml->reg_secret_qa = $_POST["reg_secret_qa"];
    $xml->reg_first_last_name = $_POST["reg_first_last_name"];
    $xml->multiacc = $_POST["multiacc"];
    $xml->register_enable_recaptcha = $_POST["setting_2"];
    $xml->register_recaptcha_version = $_POST["setting_8"];
    $xml->register_recaptcha_public_key = $_POST["setting_3"];
    $xml->register_recaptcha_private_key = $_POST["setting_4"];
    $xml->send_welcome_email = $_POST["setting_6"];
    $xml->verify_email = $_POST["setting_5"];
    $xml->verification_timelimit = $_POST["setting_7"];
    $xml->vip_enable = $_POST["setting_10"];
    $xml->vip_type = $_POST["setting_11"];
    $xml->vip_hours = $_POST["setting_12"];
    $save = $xml->asXML($xmlPath);
    if ($save) {
        message("success", "Settings successfully saved.");
    } else {
        message("error", "There has been an error while saving changes.");
    }
}

?>