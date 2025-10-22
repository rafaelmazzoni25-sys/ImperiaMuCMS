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
        echo "\r\n    <h3>\r\n        " . lang("module_titles_txt_22", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
        if (mconfig("active")) {
            echo "\r\n    <div class=\"row\">\r\n        <div class=\"col-xs-12\">\r\n            <iframe src=\"http://www.superrewards-offers.com/super/offers?h=" . mconfig("sr_h") . "&uid=" . $_SESSION["username"] . "\" frameborder=\"0\" width=\"100%\" height=\"auto\"></iframe>\r\n        </div>\r\n    </div>";
        } else {
            message("error", lang("error_47", true));
        }
    } else {
        echo "\r\n    <div class=\"sub-page-title\">\r\n        <div id=\"title\">\r\n            <h1>" . lang("module_titles_txt_3", true) . "<p></p><span></span></h1>\r\n        </div>\r\n    </div>\r\n\r\n    <div class=\"container_2 account\" align=\"center\">\r\n        <div class=\"cont-image\">\r\n            <div class=\"container_3 account_sub_header\">\r\n                <div class=\"grad\">\r\n                    <div class=\"page-title\"><p>" . lang("donation_txt_3", true) . "</p></div>\r\n                    <div class=\"sub-active-page\">" . lang("module_titles_txt_22", true) . "</div>\r\n                    <a href=\"" . __BASE_URL__ . "donation\">" . lang("donation_txt_6", true) . "</a>\r\n                </div>\r\n            </div>\r\n            <div class=\"page-desc-holder\"></div>";
        if (mconfig("active")) {
            echo "\r\n            <div class=\"container_3 account-wide\" align=\"center\">\r\n                <iframe src=\"http://www.superrewards-offers.com/super/offers?h=" . mconfig("sr_h") . "&uid=" . $_SESSION["username"] . "\" frameborder=\"0\" width=\"630\" height=\"1200\" scrolling=\"no\"></iframe>\r\n            </div>";
        } else {
            message("error", lang("error_47", true));
        }
        echo "\r\n        </div>\r\n    </div>";
    }
}

?>