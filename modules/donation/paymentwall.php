<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

if (!isLoggedIn()) {
    redirect(1, "login");
} else {
    if (!canAccessModule($_SESSION["username"], "donation", "allow")) {
        return NULL;
    }
    if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
        $breadcrumb = generateBreadcrumb();
        echo "\r\n    <h3>\r\n        " . lang("module_titles_txt_31", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
        if (mconfig("active")) {
            if (config("SQL_USE_2_DB", true)) {
                $userData = $dB2->query_fetch_single("SELECT mail_addr, appl_days FROM MEMB_INFO WHERE memb___id = ?", [$_SESSION["username"]]);
            } else {
                $userData = $dB->query_fetch_single("SELECT mail_addr, appl_days FROM MEMB_INFO WHERE memb___id = ?", [$_SESSION["username"]]);
            }
            if (mconfig("type") == "0") {
                require_once __PATH_INCLUDES__ . "libs/Paymentwall/paymentwall.php";
                Paymentwall_Config::getInstance()->set(["api_type" => Paymentwall_Config::API_VC, "public_key" => mconfig("pw_app_key"), "private_key" => mconfig("pw_secret_key")]);
                $widget = new Paymentwall_Widget($_SESSION["username"], mconfig("pw_widget"), [], ["email" => $userData["mail_addr"], "history[registration_date]" => strtotime($userData["appl_days"])]);
                echo $widget->getHtmlCode();
            } else {
                echo "\r\n    <div class=\"row\">\r\n        <div class=\"col-xs-12\">\r\n            <iframe src=\"https://api.paymentwall.com/api/" . mconfig("pw_api") . "/?key=" . mconfig("pw_app_key") . "&uid=" . $_SESSION["username"] . "&widget=" . mconfig("pw_widget") . "&email=" . $userData["mail_addr"] . "&history[registration_date]=" . strtotime($userData["appl_days"]) . "\" width=\"100%\" class=\"donate-paymentwall\" frameborder=\"0\"></iframe>\r\n        </div>\r\n    </div>";
            }
        } else {
            message("error", lang("error_47", true));
        }
    } else {
        echo "\r\n<div class=\"sub-page-title\">\r\n    <div id=\"title\">\r\n        <h1>" . lang("module_titles_txt_3", true) . "<p></p><span></span></h1>\r\n    </div>\r\n</div>\r\n<div class=\"container_2 account\" align=\"center\">\r\n    <div class=\"cont-image\">\r\n        <div class=\"container_3 account_sub_header\">\r\n            <div class=\"grad\">\r\n                <div class=\"page-title\"><p>" . lang("donation_txt_3", true) . "</p></div>\r\n                <div class=\"sub-active-page\">" . lang("module_titles_txt_31", true) . "</div>\r\n                <a href=\"" . __BASE_URL__ . "donation\">" . lang("donation_txt_6", true) . "</a>\r\n            </div>\r\n        </div>\r\n        <div class=\"page-desc-holder\"></div>";
        if (mconfig("active")) {
            if (config("SQL_USE_2_DB", true)) {
                $userData = $dB2->query_fetch_single("SELECT mail_addr, appl_days FROM MEMB_INFO WHERE memb___id = ?", [$_SESSION["username"]]);
            } else {
                $userData = $dB->query_fetch_single("SELECT mail_addr, appl_days FROM MEMB_INFO WHERE memb___id = ?", [$_SESSION["username"]]);
            }
            if (mconfig("type") == "0") {
                require_once __PATH_INCLUDES__ . "/libs/Paymentwall/paymentwall.php";
                Paymentwall_Config::getInstance()->set(["api_type" => Paymentwall_Config::API_VC, "public_key" => mconfig("pw_app_key"), "private_key" => mconfig("pw_secret_key")]);
                $widget = new Paymentwall_Widget($_SESSION["username"], mconfig("pw_widget"), [], ["email" => $userData["mail_addr"], "history[registration_date]" => strtotime($userData["appl_days"])]);
                echo $widget->getHtmlCode();
            } else {
                echo "\r\n        <div class=\"container_3 account-wide\" align=\"center\">\r\n            <iframe src=\"https://api.paymentwall.com/api/" . mconfig("pw_api") . "/?key=" . mconfig("pw_app_key") . "&uid=" . $_SESSION["username"] . "&widget=" . mconfig("pw_widget") . "&email=" . $userData["mail_addr"] . "&history[registration_date]=" . strtotime($userData["appl_days"]) . "\" width=\"845\" height=\"500\" frameborder=\"0\"></iframe>\r\n        </div>";
            }
        } else {
            message("error", lang("error_47", true));
        }
        echo "\r\n    </div>\r\n</div>";
    }
}

?>