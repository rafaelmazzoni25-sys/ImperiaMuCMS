<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */
while (isLoggedIn()) {
    redirect();
}
if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
    $breadcrumb = generateBreadcrumb();
    echo "\r\n    <h3>\r\n        " . lang("module_titles_txt_1", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
    if (mconfig("active")) {
        if (!mconfig("register_terms")) {
            $_POST["terms"] = "I Agree with Terms of Service";
        }
        if (isset($_POST["terms"])) {
            if (check_value($_POST["submit"])) {
                try {
                    $Account = new Account($dB, $dB2);
                    if (mconfig("register_enable_recaptcha")) {
                        if (mconfig("register_recaptcha_version")) {
                            $resp = recaptcha_verify(mconfig("register_recaptcha_private_key"), $_SERVER["REMOTE_ADDR"], $_POST["g-recaptcha-response"]);
                            if (!$resp->is_valid) {
                                throw new Exception(lang("error_18", true));
                            }
                        } else {
                            $resp = recaptcha_check_answer(mconfig("register_recaptcha_private_key"), $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
                            if (!$resp->is_valid) {
                                throw new Exception(lang("error_18", true));
                            }
                        }
                    }
                    $ipb4cfg = loadConfigurations("ipboardapi");
                    if ($ipb4cfg["create_account"] && (strlen($_POST["forumUsername"]) < 3 || 20 < strlen($_POST["forumUsername"]))) {
                        throw new Exception(lang("register_txt_25", true));
                    }
                    loadModuleConfigs("register");
                    $Account->registerAccount($_POST["username"], $_POST["password"], $_POST["password_confirm"], $_POST["email"], $_POST["question"], $_POST["answer"], $_POST["country"], $_GET["ref"], $_POST["forumUsername"], $_POST["firstName"], $_POST["lastName"]);
                } catch (Exception $ex) {
                    message("error", $ex->getMessage());
                }
            }
            $questions = "";
            $i = 1;
            foreach ($custom["secret_questions"] as $thisQuestion) {
                $questions .= "<option value=\"" . $i . "\">" . $thisQuestion . "</option>";
                $i++;
            }
            echo "\r\n            <div class=\"row\">\r\n                <div class=\"col-xs-12 col-md-6 col-md-offset-3 column\">\r\n                    <form action=\"\" method=\"post\" class=\"form-horizontal\">\r\n                        <div class=\"form-group\">\r\n                            <label for=\"username\" class=\"col-sm-3 control-label\">" . lang("login_txt_1", true) . "</label>\r\n                            <div class=\"col-xs-12 col-sm-6\">\r\n                                <input type=\"text\" name=\"username\" class=\"form-control\" id=\"register-username\" tabindex=\"1\" maxlength=\"10\" />\r\n                            </div>\r\n                        </div>";
            $ipb4cfg = loadConfigurations("ipboardapi");
            if ($ipb4cfg["create_account"]) {
                echo "\r\n                        <div class=\"form-group\">\r\n                            <label for=\"register-forumUsername\" class=\"col-sm-3 control-label\">" . lang("register_txt_24", true) . "</label>\r\n                            <div class=\"col-xs-12 col-sm-6\">\r\n                                <input type=\"text\" name=\"forumUsername\" class=\"form-control\" id=\"register-forumUsername\" tabindex=\"2\" minlength=\"3\" maxlength=\"20\" />\r\n                            </div>\r\n                        </div>";
            }
            loadModuleConfigs("register");
            if (mconfig("reg_first_last_name")) {
                echo "\r\n                        <div class=\"form-group separator\">\r\n                            <label for=\"register-first-name\" class=\"col-sm-3 control-label\">" . lang("register_txt_32", true) . "</label>\r\n                            <div class=\"col-xs-12 col-sm-6\">\r\n                                <input type=\"text\" name=\"firstName\" class=\"form-control\" id=\"register-first-name\" tabindex=\"3\" maxlength=\"255\" />\r\n                            </div>\r\n                        </div>\r\n                        <div class=\"form-group\">\r\n                            <label for=\"register-last-name\" class=\"col-sm-3 control-label\">" . lang("register_txt_33", true) . "</label>\r\n                            <div class=\"col-xs-12 col-sm-6\">\r\n                                <input type=\"text\" name=\"lastName\" class=\"form-control\" id=\"register-last-name\" tabindex=\"4\" maxlength=\"255\" />\r\n                            </div>\r\n                        </div>";
            }
            echo "\r\n                        <div class=\"form-group separator\">\r\n                            <label for=\"register-password\" class=\"col-sm-3 control-label\">" . lang("register_txt_2", true) . "</label>\r\n                            <div class=\"col-xs-12 col-sm-6\">\r\n                                <input type=\"password\" name=\"password\" class=\"form-control\" id=\"register-password\" tabindex=\"5\" maxlength=\"20\" />\r\n                            </div>\r\n                        </div>\r\n                        <div class=\"form-group\">\r\n                            <label for=\"register-password2\" class=\"col-sm-3 control-label\">" . lang("register_txt_3", true) . "</label>\r\n                            <div class=\"col-xs-12 col-sm-6\">\r\n                                <input type=\"password\" name=\"password_confirm\" class=\"form-control\" id=\"register-password2\" tabindex=\"6\" maxlength=\"20\" />\r\n                            </div>\r\n                        </div>\r\n                        <div class=\"form-group separator\">\r\n                            <label for=\"register-email\" class=\"col-sm-3 control-label\">" . lang("register_txt_4", true) . "</label>\r\n                            <div class=\"col-xs-12 col-sm-6\">\r\n                                <input type=\"text\" name=\"email\" class=\"form-control\" id=\"register-email\" tabindex=\"7\" />\r\n                            </div>\r\n                        </div>";
            if (mconfig("reg_country") || mconfig("reg_secret_qa")) {
                echo "<div class=\"separator\"></div>";
            }
            if (mconfig("reg_country")) {
                echo "    \r\n                        <div class=\"form-group\">\r\n                            <label for=\"register-country\" class=\"col-sm-3 control-label\">" . lang("register_txt_12", true) . "</label>\r\n                            <div class=\"col-xs-12 col-sm-6\">\r\n                                <select name=\"country\" class=\"form-control\" tabindex=\"8\">\r\n                                    <option value=\"\" disabled=\"disabled\" selected=\"selected\">" . lang("register_txt_36", true) . "</option>";
                $ip_info = $common->ip_info($_SERVER["REMOTE_ADDR"]);
                foreach ($custom["countries"] as $key => $thisCountry) {
                    if (strtolower($ip_info["country_code"]) == $key) {
                        echo "<option value=\"" . $key . "\" selected=\"selected\">" . $thisCountry . "</option>";
                    } else {
                        echo "<option value=\"" . $key . "\">" . $thisCountry . "</option>";
                    }
                }
                echo "\r\n                                </select>\r\n                            </div>\r\n                        </div>";
            }
            if (mconfig("reg_secret_qa")) {
                echo "\r\n                        <div class=\"form-group\">\r\n                            <label for=\"register-question\" class=\"col-sm-3 control-label\">" . lang("register_txt_13", true) . "</label>\r\n                            <div class=\"col-xs-12 col-sm-6\">\r\n                                <select name=\"question\" class=\"form-control\" tabindex=\"9\">\r\n                                    " . $questions . "\r\n                                </select>\r\n                            </div>\r\n                        </div>\r\n                        <div class=\"form-group\">\r\n                            <label for=\"register-answer\" class=\"col-sm-3 control-label\">" . lang("register_txt_14", true) . "</label>\r\n                            <div class=\"col-xs-12 col-sm-6\">\r\n                                <input type=\"text\" name=\"answer\" class=\"form-control\" id=\"register-answer\" tabindex=\"10\" maxlength=\"100\" />\r\n                            </div>\r\n                        </div>";
            }
            if (mconfig("register_enable_recaptcha")) {
                echo "\r\n                        <div class=\"form-group separator\">\r\n                            <label class=\"col-sm-3 control-label\"></label>\r\n                            <div class=\"col-xs-12 col-sm-6\">\r\n                                <div class=\"row recaptcha\">";
                echo recaptcha_get_html(mconfig("register_recaptcha_public_key"), NULL, true);
                echo "\r\n                                </div>\r\n                            </div>\r\n                        </div>";
            }
            echo "\r\n                        <div class=\"form-group separator\">\r\n                            <div class=\"col-xs-12 col-sm-offset-3 col-sm-6\">\r\n                                <input type=\"hidden\" name=\"terms\" id=\"terms\">\r\n                                <input type=\"submit\" name=\"submit\" class=\"btn btn-warning\" style=\"width: 100%;\" value=\"" . lang("register_txt_5", true) . "\" tabindex=\"11\">\r\n                            </div>\r\n                        </div>\r\n                    </form>\r\n                </div>\r\n            </div>";
        } else {
            echo "\r\n            <div class=\"row\">\r\n                <div class=\"col-xs-12 text-justify register-terms\">\r\n                    " . lang("register_txt_18", true) . "\r\n                </div>\r\n            </div>\r\n            <div class=\"row\">\r\n                <div class=\"col-xs-12 text-center\">\r\n                    <form method=\"post\" action=\"\">\r\n                        <input type=\"submit\" class=\"btn btn-success\" name=\"terms\" id=\"terms\" value=\"" . lang("register_txt_15", true) . "\" />\r\n                        <a class=\"btn btn-danger\" href=\"" . __BASE_URL__ . "\">" . lang("register_txt_16", true) . "</a>\r\n                    </form>\r\n                </div>\r\n            </div>";
        }
    } else {
        message("error", lang("error_17", true));
    }
} else {
    echo "\r\n<div class=\"sub-page-title\">\r\n    <div id=\"title\"><h1>" . lang("module_titles_txt_1", true) . "<p></p><span></span></h1></div>\r\n</div>";
    if (mconfig("active")) {
        if (!mconfig("register_terms")) {
            $_POST["terms"] = "I Agree with Terms of Service";
        }
        if (isset($_POST["terms"])) {
            if (check_value($_POST["submit"])) {
                try {
                    $Account = new Account($dB, $dB2);
                    if (mconfig("register_enable_recaptcha")) {
                        if (mconfig("register_recaptcha_version")) {
                            $resp = recaptcha_verify(mconfig("register_recaptcha_private_key"), $_SERVER["REMOTE_ADDR"], $_POST["g-recaptcha-response"]);
                            if (!$resp->is_valid) {
                                throw new Exception(lang("error_18", true));
                            }
                        } else {
                            $resp = recaptcha_check_answer(mconfig("register_recaptcha_private_key"), $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
                            if (!$resp->is_valid) {
                                throw new Exception(lang("error_18", true));
                            }
                        }
                    }
                    $ipb4cfg = loadConfigurations("ipboardapi");
                    if ($ipb4cfg["create_account"] && (strlen($_POST["forumUsername"]) < 3 || 20 < strlen($_POST["forumUsername"]))) {
                        throw new Exception(lang("register_txt_25", true));
                    }
                    loadModuleConfigs("register");
                    $Account->registerAccount($_POST["username"], $_POST["password"], $_POST["password_confirm"], $_POST["email"], $_POST["question"], $_POST["answer"], $_POST["country"], $_GET["ref"], $_POST["forumUsername"], $_POST["firstName"], $_POST["lastName"]);
                } catch (Exception $ex) {
                    message("error", $ex->getMessage());
                }
            }
            $questions = "";
            $i = 1;
            foreach ($custom["secret_questions"] as $thisQuestion) {
                $questions .= "<option value=\"" . $i . "\">" . $thisQuestion . "</option>";
                $i++;
            }
            echo "\r\n<div class=\"container_2\" align=\"center\">\r\n    <div class=\"page-desc-holder\">";
            if (mconfig("verify_email")) {
                echo lang("register_txt_11", true);
            }
            if (mconfig("vip_enable")) {
                if (mconfig("vip_type") == "1") {
                    $vipType = lang("vip_txt_18", true);
                } else {
                    if (mconfig("vip_type") == "2") {
                        $vipType = lang("vip_txt_19", true);
                    } else {
                        if (mconfig("vip_type") == "3") {
                            $vipType = lang("vip_txt_20", true);
                        } else {
                            if (mconfig("vip_type") == "4") {
                                $vipType = lang("vip_txt_21", true);
                            }
                        }
                    }
                }
                if (24 <= mconfig("vip_hours")) {
                    $length = floor(mconfig("vip_hours") / 24);
                    $lengthName = lang("register_txt_22", true);
                } else {
                    $length = mconfig("vip_hours");
                    $lengthName = lang("register_txt_23", true);
                }
                echo sprintf(lang("register_txt_21", true), $vipType, $length, $lengthName);
            }
            echo "\r\n    </div>\r\n    <div class=\"container_3\" align=\"center\">\r\n        <form action=\"\" method=\"post\">\r\n            <div class=\"row\">\r\n                <label for=\"register-username\">" . lang("register_txt_1", true) . "</label>\r\n                <input type=\"text\" name=\"username\" id=\"register-username\" tabindex=\"1\" maxlength=\"10\" />\r\n            </div>";
            $ipb4cfg = loadConfigurations("ipboardapi");
            if ($ipb4cfg["create_account"]) {
                echo "\r\n                <div class=\"row\">\r\n                    <label for=\"register-forumUsername\">" . lang("register_txt_24", true) . "</label>\r\n                    <input type=\"text\" name=\"forumUsername\" id=\"register-forumUsername\" tabindex=\"2\" minlength=\"3\" maxlength=\"20\" />\r\n                </div>";
            }
            loadModuleConfigs("register");
            if (mconfig("reg_first_last_name")) {
                echo "\r\n                <div class=\"seperator\"></div>\r\n                <div class=\"row\">\r\n                    <label for=\"register-first-name\">" . lang("register_txt_32", true) . "</label>\r\n                    <input type=\"text\" name=\"firstName\" id=\"register-first-name\" tabindex=\"3\" maxlength=\"255\" />\r\n                </div>\r\n                <div class=\"row\">\r\n                    <label for=\"register-last-name\">" . lang("register_txt_33", true) . "</label>\r\n                    <input type=\"text\" name=\"lastName\" id=\"register-last-name\" tabindex=\"4\" maxlength=\"255\" />\r\n                </div>";
            }
            echo "\r\n            <div class=\"seperator\"></div>\r\n            <div class=\"row\">\r\n                <label for=\"register-password\">" . lang("register_txt_2", true) . "</label>\r\n                <input type=\"password\" name=\"password\" id=\"register-password\" tabindex=\"5\" maxlength=\"20\" />\r\n            </div>\r\n            <div class=\"row\">\r\n                <label for=\"register-password2\">" . lang("register_txt_3", true) . "</label>\r\n                <input type=\"password\" name=\"password_confirm\" id=\"register-password2\" tabindex=\"6\" maxlength=\"20\" />\r\n            </div>\r\n            <div class=\"seperator\"></div>\r\n            <div class=\"row\">\r\n                <label for=\"register-email\">" . lang("register_txt_4", true) . "</label>\r\n                <input type=\"text\" name=\"email\" id=\"register-email\" tabindex=\"7\" />\r\n            </div>";
            if (mconfig("reg_country") || mconfig("reg_secret_qa")) {
                echo "<div class=\"seperator\"></div>";
            }
            if (mconfig("reg_country")) {
                echo "            \r\n                <div class=\"row\">\r\n                    <label for=\"register-country\">" . lang("register_txt_12", true) . "</label>\r\n                    <select name=\"country\" styled=\"true\" id=\"select-style-2\" style=\"display: none;\" tabindex=\"8\">";
                $ip_info = $common->ip_info($_SERVER["REMOTE_ADDR"]);
                foreach ($custom["countries"] as $key => $thisCountry) {
                    if (strtolower($ip_info["country_code"]) == $key) {
                        echo "<option value=\"" . $key . "\" selected=\"selected\">" . $thisCountry . "</option>";
                    } else {
                        echo "<option value=\"" . $key . "\">" . $thisCountry . "</option>";
                    }
                }
                echo "\r\n                    </select>\r\n                </div>";
            }
            if (mconfig("reg_secret_qa")) {
                echo "\r\n                <div class=\"row\">\r\n                    <label for=\"register-question\">" . lang("register_txt_13", true) . "</label>\r\n                    <select name=\"question\" styled=\"true\" id=\"select-style-2\" style=\"display: none;\" tabindex=\"9\">\r\n                        " . $questions . "\r\n                    </select>\r\n                </div>\r\n                <div class=\"row\">\r\n                    <label for=\"register-answer\">" . lang("register_txt_14", true) . "</label>\r\n                    <input type=\"text\" name=\"answer\" id=\"register-answer\" tabindex=\"10\" maxlength=\"100\" />\r\n                </div>";
            }
            if (mconfig("register_enable_recaptcha")) {
                echo "\r\n            <div class=\"seperator\"></div>\r\n            <div class=\"row\" style=\"height:129px;\">\r\n                <div style=\"padding-left:30px;\">";
                echo recaptcha_get_html(mconfig("register_recaptcha_public_key"), NULL, true);
                echo "\r\n                </div>\r\n            </div>";
            }
            echo "\r\n\t\t    <div class=\"row\" align=\"right\">\r\n         \t\t<input type=\"hidden\" name=\"terms\" id=\"terms\">\r\n                <input type=\"submit\" name=\"submit\" value=\"" . lang("register_txt_5", true) . "\" tabindex=\"11\">\r\n            </div>\r\n        </form>\r\n    </div>\r\n</div>";
        } else {
            echo "\r\n            <div class=\"container_2\" align=\"center\">\r\n                <div class=\"container_3 terms-of-usage\" align=\"center\">\r\n                    <h1></h1>\r\n                    <script type=\"text/javascript\" src=\"https://code.jquery.com/jquery-latest.min.js\"></script>\r\n                    <script type=\"text/javascript\"\r\n                            src=\"";
            echo __PATH_TEMPLATE__;
            echo "js/jquery.tinyscrollbar.min.js\"></script>\r\n                    <script type=\"text/javascript\">\r\n                        \$(document).ready(function () {\r\n                            \$('#terms-container').tinyscrollbar();\r\n                        });\r\n                    </script>\r\n                    <div id=\"terms-container\">\r\n                        <div class=\"scrollbar\">\r\n                            <div class=\"track\">\r\n                                <div class=\"thumb\"></div>\r\n                            </div>\r\n                        </div>\r\n                        <div class=\"terms-shadow\"></div>\r\n                        <div class=\"viewport\">\r\n                            <div class=\"overview\">\r\n                                ";
            echo lang("register_txt_18", true);
            echo "                            </div>\r\n                        </div>\r\n                        <div class=\"clear\"></div>\r\n                    </div>\r\n                    <!-- SCROLL BAR Container . End -->\r\n                    <div style=\"height:20px;\"></div>\r\n                    <form method=\"post\" action=\"\">\r\n                        <table width=\"100%\" align=\"center\">\r\n                            <tr>\r\n                                <td align=\"center\">\r\n                                    <input type=\"submit\" class=\"agree\" name=\"terms\" id=\"terms\" value=\"";
            echo lang("register_txt_15", true);
            echo "\" style=\"margin:10px 0 0 0;\"/>\r\n                                    <a class=\"dissagree\" href=\"index.php\">";
            echo lang("register_txt_16", true);
            echo "</a>\r\n                                </td>\r\n                            </tr>\r\n                        </table>\r\n                    </form>\r\n                </div>\r\n                <!-- TERMS OF USAGE . End -->\r\n            </div>\r\n\r\n            ";
        }
    } else {
        message("error", lang("error_17", true));
    }
}

?>