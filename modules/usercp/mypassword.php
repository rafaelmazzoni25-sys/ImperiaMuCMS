<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

while (!isLoggedIn()) {
    if (!canAccessModule($_SESSION["username"], "mypassword", "allow")) {
        return NULL;
    }
    if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
        $breadcrumb = generateBreadcrumb();
        echo "\r\n    <h3>\r\n        " . lang("module_titles_txt_6", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
        if (mconfig("active")) {
            if (check_value($_POST["submit"])) {
                if ($_SESSION["token"] == $_POST["token"]) {
                    try {
                        $Account = new Account($dB, $dB2);
                        if (mconfig("change_password_email_verification")) {
                            $Account->changePasswordProcess_verifyEmail($_SESSION["userid"], $_SESSION["username"], $_POST["password"], $_POST["new_password"], $_POST["confirm_new_password"], $_SERVER["REMOTE_ADDR"]);
                        } else {
                            $Account->changePasswordProcess($_SESSION["userid"], $_SESSION["username"], $_POST["password"], $_POST["new_password"], $_POST["confirm_new_password"]);
                        }
                    } catch (Exception $ex) {
                        message("error", $ex->getMessage());
                    }
                } else {
                    message("notice", lang("global_module_13", true));
                }
            }
            if (check_value($_POST["resend"])) {
                if ($_SESSION["token"] == $_POST["token"]) {
                    try {
                        $Account = new Account($dB, $dB2);
                        $passData = $dB->query_fetch_single("SELECT TOP 1 * FROM IMPERIAMUCMS_PASSCHANGE_REQUEST WHERE user_id = ? ORDER BY request_date DESC", [$_SESSION["userid"]]);
                        $link = $Account->generatePasswordChangeVerificationURL($_SESSION["userid"], $passData["auth_code"]);
                        $accountData = $Account->accountInformation($_SESSION["userid"]);
                        if (!is_array($accountData)) {
                            throw new Exception(lang("error_21", true));
                        }
                        $mypassCfg = loadConfigurations("usercp.mypassword");
                        $email = new Email();
                        $email->setTemplate("CHANGE_PASSWORD_EMAIL_VERIFICATION");
                        $email->addVariable("{USERNAME}", $_SESSION["username"]);
                        $email->addVariable("{DATE}", date($config["time_date_format"]));
                        $email->addVariable("{IP_ADDRESS}", $_SERVER["REMOTE_ADDR"]);
                        $email->addVariable("{LINK}", $link);
                        $email->addVariable("{EXPIRATION_TIME}", $mypassCfg["change_password_request_timeout"]);
                        $email->addAddress($accountData[_CLMN_EMAIL_]);
                        $email->send();
                        message("success", lang("success_3", true));
                    } catch (Exception $ex) {
                        message("error", lang("error_20", true));
                    }
                } else {
                    message("notice", lang("global_module_13", true));
                }
            }
            $token = time();
            $_SESSION["token"] = $token;
            if (mconfig("change_password_email_verification") && $common->hasActivePasswordChangeRequest($_SESSION["userid"])) {
                echo "\r\n    <div class=\"row\">\r\n        <div class=\"col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 col-center\">\r\n            <p style=\"padding-bottom: 15px;\">" . lang("changepassword_txt_7", true) . "</p>\r\n            <form action=\"\" method=\"post\">\r\n                <div class=\"form-group\">\r\n                    <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                    <input type=\"submit\" name=\"resend\" value=\"" . lang("changepassword_txt_8", true) . "\" class=\"btn btn-warning full-width-btn\">\r\n                </div>\r\n            </form>\r\n        </div>\r\n    </div>";
            } else {
                echo "\r\n    <div class=\"row\">\r\n        <div class=\"col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 col-center\">\r\n            <form action=\"\" method=\"post\">\r\n                <div class=\"form-group\">\r\n                    <label>" . lang("changepassword_txt_1", true) . "</label>\r\n                    <input type=\"password\" name=\"password\" class=\"form-control\">\r\n                </div>\r\n                <div class=\"form-group\">\r\n                    <label>" . lang("changepassword_txt_2", true) . "</label>\r\n                    <input type=\"password\" name=\"new_password\" class=\"form-control\">\r\n                </div>\r\n                <div class=\"form-group\">\r\n                    <label>" . lang("changepassword_txt_3", true) . "</label>\r\n                    <input type=\"password\" name=\"confirm_new_password\" class=\"form-control\">\r\n                </div>\r\n                <div class=\"form-group\">\r\n                    <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                    <input type=\"submit\" name=\"submit\" value=\"" . lang("changepassword_txt_4", true) . "\" class=\"btn btn-warning full-width-btn\">\r\n                </div>\r\n            </form>\r\n        </div>\r\n    </div>";
            }
        } else {
            message("error", lang("error_47", true));
        }
    } else {
        echo "\r\n<div class=\"sub-page-title\">\r\n\t<div id=\"title\"><h1>" . lang("module_titles_txt_3", true) . "<p></p><span></span></h1></div>\r\n</div>\r\n<div class=\"container_2 account\" align=\"center\">\r\n  <div class=\"cont-image\">\r\n    <div class=\"container_3 account_sub_header\">\r\n      <div class=\"grad\">\r\n        <div class=\"page-title\">" . lang("module_titles_txt_6", true) . "</div>\r\n        <a href=\"" . __BASE_URL__ . "usercp\">" . lang("global_module_1", true) . "</a>\r\n      </div>\r\n    </div>\r\n    <div class=\"store-activity\">\r\n      <div class=\"page-desc-holder\">\r\n      </div>";
        if (mconfig("active")) {
            if (check_value($_POST["submit"])) {
                if ($_SESSION["token"] == $_POST["token"]) {
                    try {
                        $Account = new Account($dB, $dB2);
                        if (mconfig("change_password_email_verification")) {
                            $Account->changePasswordProcess_verifyEmail($_SESSION["userid"], $_SESSION["username"], $_POST["password"], $_POST["new_password"], $_POST["confirm_new_password"], $_SERVER["REMOTE_ADDR"]);
                        } else {
                            $Account->changePasswordProcess($_SESSION["userid"], $_SESSION["username"], $_POST["password"], $_POST["new_password"], $_POST["confirm_new_password"]);
                        }
                    } catch (Exception $ex) {
                        message("error", $ex->getMessage());
                    }
                } else {
                    message("notice", lang("global_module_13", true));
                }
            }
            if (check_value($_POST["resend"])) {
                if ($_SESSION["token"] == $_POST["token"]) {
                    try {
                        $Account = new Account($dB, $dB2);
                        $passData = $dB->query_fetch_single("SELECT TOP 1 * FROM IMPERIAMUCMS_PASSCHANGE_REQUEST WHERE user_id = ? ORDER BY request_date DESC", [$_SESSION["userid"]]);
                        $link = $Account->generatePasswordChangeVerificationURL($_SESSION["userid"], $passData["auth_code"]);
                        $accountData = $Account->accountInformation($_SESSION["userid"]);
                        if (!is_array($accountData)) {
                            throw new Exception(lang("error_21", true));
                        }
                        $mypassCfg = loadConfigurations("usercp.mypassword");
                        $email = new Email();
                        $email->setTemplate("CHANGE_PASSWORD_EMAIL_VERIFICATION");
                        $email->addVariable("{USERNAME}", $_SESSION["username"]);
                        $email->addVariable("{DATE}", date($config["time_date_format"]));
                        $email->addVariable("{IP_ADDRESS}", $_SERVER["REMOTE_ADDR"]);
                        $email->addVariable("{LINK}", $link);
                        $email->addVariable("{EXPIRATION_TIME}", $mypassCfg["change_password_request_timeout"]);
                        $email->addAddress($accountData[_CLMN_EMAIL_]);
                        $email->send();
                        message("success", lang("success_3", true));
                    } catch (Exception $ex) {
                        message("error", lang("error_20", true));
                    }
                } else {
                    message("notice", lang("global_module_13", true));
                }
            }
            $token = time();
            $_SESSION["token"] = $token;
            if (mconfig("change_password_email_verification") && $common->hasActivePasswordChangeRequest($_SESSION["userid"])) {
                echo "\r\n        <div class=\"container_3 account-wide\" align=\"center\">\r\n          <p style=\"padding: 20px;\"></p>\r\n          <form action=\"\" method=\"post\">\r\n            <p style=\"padding-bottom: 15px;\">" . lang("changepassword_txt_7", true) . "</p>\r\n            <div class=\"row\" style=\"height: 60px;\">\r\n                <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                <input name=\"resend\" type=\"submit\" value=\"" . lang("changepassword_txt_8", true) . "\">\r\n            </div>\r\n          </form>\r\n        </div>";
            } else {
                echo "\r\n        <div class=\"container_3 account-wide\" align=\"center\">\r\n          <p style=\"padding: 20px;\"></p>\r\n          <form action=\"\" method=\"post\">\r\n            <div class=\"row\">\r\n                <label for=\"password\">" . lang("changepassword_txt_1", true) . "</label>\r\n                <input type=\"password\" name=\"password\">\r\n            </div>\r\n            <div class=\"row\">\r\n                <label for=\"newPassword\">" . lang("changepassword_txt_2", true) . "</label>\r\n                <input type=\"password\" name=\"new_password\">\r\n            </div>\r\n            <div class=\"row\">\r\n                <label for=\"newPassword2\">" . lang("changepassword_txt_3", true) . "</label>\r\n                <input type=\"password\" name=\"confirm_new_password\">\r\n            </div>\r\n            <div class=\"row\" style=\"height: 60px;\">\r\n                <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                <input style=\"float: right;\" name=\"submit\" type=\"submit\" value=\"" . lang("changepassword_txt_4", true) . "\">\r\n            </div>\r\n          </form>\r\n        </div>";
            }
        } else {
            message("error", lang("error_47", true));
        }
        echo "\r\n    </div>\r\n  </div>\r\n</div>";
    }
}
redirect(1, "login");

?>