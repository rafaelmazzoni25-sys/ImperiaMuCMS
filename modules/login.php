<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

if (isLoggedIn()) {
    redirect();
}
if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
    $breadcrumb = generateBreadcrumb();
    echo "\n    <h3>\n        " . lang("module_titles_txt_2", true) . "\n        " . $breadcrumb . "\n    </h3>";
    if (mconfig("active")) {
        if (check_value($_POST["submit"])) {
            $userLogin = new login();
            $userLogin->validateLogin($_POST["username"], $_POST["password"]);
        }
        $usernameStr = lang("login_txt_1", true);
        $passwordStr = lang("login_txt_2", true);
        if (substr($usernameStr, -1) == ":") {
            $usernameStr = substr($usernameStr, 0, -1);
        }
        if (substr($passwordStr, -1) == ":") {
            $passwordStr = substr($passwordStr, 0, -1);
        }
        echo "\n        <div class=\"col-xs-12 col-md-6 col-md-offset-3 column\">\n            <form action=\"\" method=\"post\" class=\"form-horizontal\">\n                <div class=\"form-group\">\n                    <label for=\"username\" class=\"col-sm-3 control-label\">" . lang("login_txt_1", true) . "</label>\n                    <div class=\"col-xs-12 col-sm-6\">\n                        <input type=\"text\" name=\"username\" class=\"form-control\" id=\"username\" autocomplete=\"on\" placeholder=\"" . $usernameStr . "\">\n                    </div>\n                </div>\n                <div class=\"form-group\">\n                    <label for=\"password\" class=\"col-sm-3 control-label\">" . lang("login_txt_2", true) . "</label>\n                    <div class=\"col-xs-12 col-sm-6\">\n                        <input type=\"password\" name=\"password\" class=\"form-control\" id=\"password\" autocomplete=\"on\" placeholder=\"" . $passwordStr . "\">\n                    </div>\n                </div>\n                <div class=\"form-group\">\n                    <div class=\"col-xs-12 col-sm-offset-3 col-sm-6\">\n                        <input type=\"submit\" name=\"submit\" id=\"submit\" class=\"btn btn-warning\" style=\"width: 100%;\" value=\"" . lang("login_txt_3", true) . "\">\n                    </div>\n                </div>\n                <div class=\"form-group\">\n                    <div class=\"col-xs-12 col-sm-offset-3 col-sm-6\">\n                        <a href=\"" . __BASE_URL__ . "forgotpassword/\">" . lang("login_txt_4", true) . "</a><br>\n                        <span>" . $lang["login_txt_5"] . " <a href=\"" . __BASE_URL__ . "register\">" . lang("login_txt_6", true) . "</a></span>\n                    </div>\n                </div>\n            </form>\n        </div>";
    } else {
        message("error", lang("error_47", true));
    }
} else {
    echo "\n<div class=\"sub-page-title\">\n  <div id=\"title\"><h1>" . lang("module_titles_txt_2", true) . "<p></p><span></span></h1></div>\n</div>\n<div class=\"container_2\" align=\"center\" style=\"height: 305px;\">";
    if (mconfig("active")) {
        if (check_value($_POST["submit"])) {
            $userLogin = new login();
            $userLogin->validateLogin($_POST["username"], $_POST["password"]);
        }
        echo "\n    <div class=\"vertical_center\" align=\"center\" style=\"position: relative; top: 200px; margin-top: -145px;\">\n      <div class=\"container_3\" align=\"center\">\n        <form action=\"\" method=\"post\">\n          <div class=\"row\">\n            <label>" . lang("login_txt_1", true) . "</label>\n            <input type=\"text\" name=\"username\" autocomplete=\"on\">\n          </div>\n          <div class=\"row\">\n            <label>" . lang("login_txt_2", true) . "</label>\n            <input type=\"password\" name=\"password\" autocomplete=\"on\">\n          </div>\n          <div class=\"row\" align=\"right\">\n          \t<input type=\"submit\" name=\"submit\" id=\"submit\" value=\"" . lang("login_txt_3", true) . "\">\n          </div>\n        </form>\n        <div class=\"login-box-options\">\n          <a href=\"" . __BASE_URL__ . "forgotpassword/\">" . lang("login_txt_4", true) . "</a><br>\n          <span>" . $lang["login_txt_5"] . " <a href=\"" . __BASE_URL__ . "register\">" . lang("login_txt_6", true) . "</a></span>\n        </div>\n      </div>\n    </div>";
    } else {
        message("error", lang("error_47", true));
    }
    echo "</div>";
}

?>