<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

while (!isLoggedIn()) {
    if (!canAccessModule($_SESSION["username"], "myemail", "block")) {
        return NULL;
    }
    if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
        $breadcrumb = generateBreadcrumb();
        echo "\r\n    <h3>\r\n        " . lang("module_titles_txt_5", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
        if (mconfig("active")) {
            echo "\r\n    <div class=\"row desc-row\">\r\n        <div class=\"col-xs-12\">";
            if (mconfig("type") == "1") {
                echo lang("changemail_txt_4", true);
            } else {
                echo lang("changemail_txt_9", true);
            }
            echo "\r\n        </div>\r\n    </div>";
            if (check_value($_POST["submit"])) {
                if ($_SESSION["token"] == $_POST["token"]) {
                    try {
                        if (mconfig("type") == "1") {
                            if (check_value($_POST["question"]) && check_value($_POST["answer"])) {
                                $accountData = $common->accountInformation($_SESSION["userid"]);
                                if ($accountData["SecretQuestion"] == $_POST["question"] && $accountData["SecretAnswer"] == $_POST["answer"]) {
                                    $Account = new Account($dB, $dB2);
                                    $Account->changeEmailAddress($_SESSION["userid"], $_POST["new_email"], $_SERVER["REMOTE_ADDR"]);
                                    message("success", lang("success_19", true));
                                } else {
                                    message("error", lang("changemail_txt_5", true));
                                }
                            }
                        } else {
                            $Account = new Account($dB, $dB2);
                            $Account->changeEmailAddress($_SESSION["userid"], $_POST["new_email"], $_SERVER["REMOTE_ADDR"]);
                            message("success", lang("success_19", true));
                        }
                    } catch (Exception $ex) {
                        message("error", $ex->getMessage());
                    }
                } else {
                    message("notice", lang("global_module_13", true));
                }
            }
            $questions = "";
            $i = 1;
            foreach ($custom["secret_questions"] as $thisQuestion) {
                $questions .= "<option value=\"" . $i . "\">" . $thisQuestion . "</option>";
                $i++;
            }
            $token = time();
            $_SESSION["token"] = $token;
            echo "\r\n    <div class=\"row\">\r\n        <div class=\"col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 col-center\">\r\n            <form action=\"\" method=\"post\">";
            if (mconfig("type") == "1") {
                echo "\r\n                <div class=\"form-group\">\r\n                    <label>" . lang("changemail_txt_6", true) . "</label>\r\n                    <select name=\"question\" class=\"form-control\">\r\n                        " . $questions . "\r\n                    </select>\r\n                </div>\r\n                <div class=\"form-group\">\r\n                    <label>" . lang("changemail_txt_7", true) . "</label>\r\n                    <input type=\"text\" name=\"answer\" class=\"form-control\" id=\"register-answer\">\r\n                </div>";
            }
            echo "\r\n                <div class=\"form-group\">\r\n                    <label>" . lang("changemail_txt_8", true) . "</label>\r\n                    <input type=\"text\" name=\"new_email\" class=\"form-control\" id=\"new-email\">\r\n                </div>\r\n                <div class=\"form-group\">\r\n                    <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                    <input type=\"submit\" name=\"submit\" value=\"" . lang("changemail_txt_3", true) . "\" class=\"btn btn-warning full-width-btn\">\r\n                </div>\r\n            </form>\r\n        </div>\r\n    </div>";
        } else {
            message("error", lang("error_47", true));
        }
    } else {
        echo "\r\n<div class=\"sub-page-title\">\r\n\t<div id=\"title\"><h1>" . lang("module_titles_txt_3", true) . "<p></p><span></span></h1></div>\r\n</div>\r\n<div class=\"container_2 account\" align=\"center\">\r\n  <div class=\"cont-image\">\r\n    <div class=\"container_3 account_sub_header\">\r\n      <div class=\"grad\">\r\n        <div class=\"page-title\">" . lang("module_titles_txt_5", true) . "</div>\r\n        <a href=\"" . __BASE_URL__ . "usercp\">" . lang("global_module_1", true) . "</a>\r\n      </div>\r\n    </div>\r\n    <div class=\"store-activity\">\r\n      <div class=\"page-desc-holder\">\r\n      " . lang("changemail_txt_4", true) . "\r\n      </div>";
        if (mconfig("active")) {
            if (check_value($_POST["submit"])) {
                if ($_SESSION["token"] == $_POST["token"]) {
                    try {
                        if (check_value($_POST["question"]) && check_value($_POST["answer"])) {
                            $accountData = $common->accountInformation($_SESSION["userid"]);
                            if ($accountData["SecretQuestion"] == $_POST["question"] && $accountData["SecretAnswer"] == $_POST["answer"]) {
                                $Account = new Account($dB, $dB2);
                                $Account->changeEmailAddress($_SESSION["userid"], $_POST["new_email"], $_SERVER["REMOTE_ADDR"]);
                                message("success", lang("success_19", true));
                            } else {
                                message("error", lang("changemail_txt_5", true));
                            }
                        }
                    } catch (Exception $ex) {
                        message("error", $ex->getMessage());
                    }
                } else {
                    message("notice", lang("global_module_13", true));
                }
            }
            $questions = "";
            $i = 1;
            foreach ($custom["secret_questions"] as $thisQuestion) {
                $questions .= "<option value=\"" . $i . "\">" . $thisQuestion . "</option>";
                $i++;
            }
            $token = time();
            $_SESSION["token"] = $token;
            echo "\r\n        <div class=\"container_3 account-wide\" align=\"center\">\r\n          <p style=\"padding: 20px;\"></p>\r\n          <form action=\"\" method=\"post\">\r\n            <div class=\"row\">\r\n              <label for=\"question\">" . lang("changemail_txt_6", true) . "</label>\r\n              <select name=\"question\" styled=\"true\" id=\"select-style-2\" style=\"display: none;\">\r\n                " . $questions . "\r\n              </select>\r\n            </div>\r\n            <div class=\"row\">\r\n              <label for=\"answer\">" . lang("changemail_txt_7", true) . "</label>\r\n              <input type=\"text\" name=\"answer\" id=\"register-answer\">\r\n            </div>\r\n            <div class=\"row\">\r\n              <label for=\"new_email\">" . lang("changemail_txt_8", true) . "</label>\r\n              <input type=\"text\" name=\"new_email\" id=\"register-email\">\r\n            </div>\r\n            <div class=\"row\" style=\"height: 60px;\">\r\n                <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                <input style=\"float: right;\" name=\"submit\" type=\"submit\" value=\"" . lang("changemail_txt_3", true) . "\">\r\n            </div>\r\n          </form>\r\n        </div>";
        } else {
            message("error", lang("error_47", true));
        }
        echo "\r\n    </div>\r\n  </div>\r\n</div>";
    }
}
redirect(1, "login");

?>