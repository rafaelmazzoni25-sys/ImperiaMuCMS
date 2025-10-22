<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

while (isLoggedIn()) {
    redirect();
}
$registerCfg = loadConfigurations("register");
if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
    $breadcrumb = generateBreadcrumb();
    echo "\n    <h3>\n        " . lang("module_titles_txt_15", true) . "\n        " . $breadcrumb . "\n    </h3>";
    if (check_value($_GET["ui"]) && check_value($_GET["ue"]) && check_value($_GET["key"])) {
        if ($registerCfg["register_enable_recaptcha"]) {
            if (check_value($_POST["submit-verification"])) {
                try {
                    if ($registerCfg["register_recaptcha_version"]) {
                        $resp = recaptcha_verify($registerCfg["register_recaptcha_private_key"], $_SERVER["REMOTE_ADDR"], $_POST["g-recaptcha-response"]);
                        if (!$resp->is_valid) {
                            throw new Exception(lang("error_18", true));
                        }
                    } else {
                        $resp = recaptcha_check_answer($registerCfg["register_recaptcha_private_key"], $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
                        if (!$resp->is_valid) {
                            throw new Exception(lang("error_18", true));
                        }
                    }
                    $Account = new Account($dB, $dB2);
                    $Account->passwordRecoveryVerificationProcess($_GET["ui"], $_GET["ue"], $_GET["key"]);
                } catch (Exception $ex) {
                    message("error", $ex->getMessage());
                }
            } else {
                echo "\n    <div class=\"row\">\n        <div class=\"col-xs-12 col-md-6 col-md-offset-3\">\n            <form action=\"\" method=\"post\">\n                <div class=\"recaptcha\" align=\"middle\">\n                    <label></label>";
                echo recaptcha_get_html($registerCfg["register_recaptcha_public_key"], NULL, true);
                echo "\n                </div>\n                <div align=\"right\">\n                    <input type=\"submit\" name=\"submit-verification\" id=\"submit\" class=\"btn btn-warning full-width-btn make-space\" value=\"" . lang("forgotpass_txt_4", true) . "\">\n                </div>\n            </form>\n        </div>\n    </div>";
            }
        } else {
            try {
                $Account = new Account($dB, $dB2);
                $Account->passwordRecoveryVerificationProcess($_GET["ui"], $_GET["ue"], $_GET["key"]);
            } catch (Exception $ex) {
                message("error", $ex->getMessage());
            }
        }
    } else {
        if (check_value($_POST["submit"])) {
            try {
                if ($registerCfg["register_enable_recaptcha"]) {
                    if ($registerCfg["register_recaptcha_version"]) {
                        $resp = recaptcha_verify($registerCfg["register_recaptcha_private_key"], $_SERVER["REMOTE_ADDR"], $_POST["g-recaptcha-response"]);
                        if (!$resp->is_valid) {
                            throw new Exception(lang("error_18", true));
                        }
                    } else {
                        $resp = recaptcha_check_answer($registerCfg["register_recaptcha_private_key"], $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
                        if (!$resp->is_valid) {
                            throw new Exception(lang("error_18", true));
                        }
                    }
                }
                $Account = new Account($dB, $dB2);
                $Account->passwordRecoveryProcess($_POST["email"], $_SERVER["REMOTE_ADDR"], $_POST["username"]);
            } catch (Exception $ex) {
                message("error", $ex->getMessage());
            }
        }
        echo "\n    <div class=\"row\">\n        <div class=\"col-xs-12 col-md-6 col-md-offset-3\">\n            <form action=\"\" method=\"post\">\n                <div>\n                    <label>" . lang("forgotpass_txt_2", true) . "</label>\n                    <input type=\"text\" name=\"email\" class=\"form-control\" autocomplete=\"off\">\n                </div>";
        if ($registerCfg["multiacc"]) {
            echo "\n                <div>\n                    <label>" . lang("forgotpass_txt_1", true) . "</label>\n                    <input type=\"text\" name=\"username\" class=\"form-control\" autocomplete=\"off\">\n                </div>";
        }
        if ($registerCfg["register_enable_recaptcha"]) {
            echo "\n                <div class=\"recaptcha\" align=\"middle\">\n                    <label></label>";
            echo recaptcha_get_html($registerCfg["register_recaptcha_public_key"], NULL, true);
            echo "\n                </div>";
        }
        echo "\n                <div align=\"right\">\n                    <input type=\"submit\" name=\"submit\" id=\"submit\" class=\"btn btn-warning full-width-btn make-space\" value=\"" . lang("forgotpass_txt_3", true) . "\">\n                </div>\n            </form>\n        </div>\n    </div>";
    }
} else {
    echo "\n<div class=\"sub-page-title\">\n  <div id=\"title\"><h1>" . lang("module_titles_txt_15", true) . "<p></p><span></span></h1></div>\n</div>";
    if (check_value($_GET["ui"]) && check_value($_GET["ue"]) && check_value($_GET["key"])) {
        try {
            $Account = new Account($dB, $dB2);
            $Account->passwordRecoveryVerificationProcess($_GET["ui"], $_GET["ue"], $_GET["key"]);
        } catch (Exception $ex) {
            message("error", $ex->getMessage());
        }
    } else {
        if (check_value($_POST["submit"])) {
            try {
                $Account = new Account($dB, $dB2);
                $Account->passwordRecoveryProcess($_POST["email"], $_SERVER["REMOTE_ADDR"]);
            } catch (Exception $ex) {
                message("error", $ex->getMessage());
            }
        }
        echo "\n      <div class=\"container_2\" align=\"center\" style=\"height: 305px;\">\n        <div class=\"vertical_center\" align=\"center\" style=\"position: relative; top: 200px; margin-top: -145px;\">\n          <div class=\"container_3\" align=\"center\">\n      \t\t\t<form action=\"\" method=\"post\">\n              <div class=\"row\">\n                <label>" . lang("forgotpass_txt_2", true) . "</label>\n                <input type=\"text\" name=\"email\" autocomplete=\"on\">\n              </div>\n              <div class=\"row\" align=\"right\">\n              \t<input type=\"submit\" name=\"submit\" id=\"submit\" value=\"" . lang("forgotpass_txt_3", true) . "\">\n              </div>\n      \t\t\t</form>\n          </div>\n        </div>\n      </div>";
    }
}

?>