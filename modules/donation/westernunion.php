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
        echo "\r\n    <h3>\r\n        " . lang("module_titles_txt_23", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
        if (mconfig("active")) {
            echo "\r\n    <div class=\"row\">\r\n        <div class=\"col-xs-12 col-sm-12 col-md-6\">\r\n            <div class=\"table-responsive rankings-table\">\r\n                <table class=\"table table-hover text-center\">\r\n                    <thead>\r\n                        <tr>\r\n                            <th colspan=\"2\" align=\"center\"><b>" . lang("donation_txt_8", true) . ":</b></th>\r\n                        </tr>\r\n                    </thead>\r\n                    <tbody>\r\n                        <tr>\r\n                            <td width=\"50%\">" . lang("donation_txt_9", true) . ":</td>\r\n                            <td width=\"50%\">" . mconfig("name") . "</td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td>" . lang("donation_txt_10", true) . ":</td>\r\n                            <td>" . mconfig("address") . "</td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td>" . lang("donation_txt_11", true) . ":</td>\r\n                            <td>" . mconfig("city_state") . "</td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td>" . lang("donation_txt_12", true) . ":</td>\r\n                            <td>" . mconfig("country") . "</td>\r\n                        </tr>\r\n                    </tbody>\r\n                </table>\r\n            </div>\r\n        </div>\r\n        <div class=\"col-xs-12 col-sm-12 col-md-6\">\r\n            <div class=\"table-responsive rankings-table\">\r\n                <table class=\"table table-hover text-center\">\r\n                    <thead>\r\n                        <tr>\r\n                            <th align=\"center\">";
            echo sprintf(lang("donation_txt_13", true), mconfig("email"));
            echo "\r\n                            </th>\r\n                        </tr>\r\n                    </thead>\r\n                    <tbody>\r\n                        <tr>\r\n                            <td>" . lang("donation_txt_14", true) . "</td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td>" . lang("donation_txt_15", true) . "</td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td>" . lang("donation_txt_16", true) . "</td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td>" . lang("donation_txt_17", true) . "</td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td>" . lang("donation_txt_18", true) . "</td>\r\n                        </tr>\r\n                    </tbody>\r\n                </table>\r\n            </div>\r\n        </div>\r\n    </div>";
        } else {
            message("error", lang("error_47", true));
        }
    } else {
        echo "\r\n  <div class=\"sub-page-title\">\r\n    <div id=\"title\">\r\n      <h1>" . lang("module_titles_txt_3", true) . "<p></p><span></span></h1>\r\n    </div>\r\n  </div>\r\n\r\n  <div class=\"container_2 account\" align=\"center\">\r\n    <div class=\"cont-image\">\r\n      <div class=\"container_3 account_sub_header\">\r\n        <div class=\"grad\">\r\n          <div class=\"page-title\"><p>" . lang("donation_txt_3", true) . "</p></div>\r\n          <div class=\"sub-active-page\">" . lang("module_titles_txt_23", true) . "</div>\r\n          <a href=\"" . __BASE_URL__ . "donation\">" . lang("donation_txt_6", true) . "</a>\r\n        </div>\r\n      </div>\r\n      <div class=\"page-desc-holder\"></div>";
        if (mconfig("active")) {
            echo "\r\n\t\t<div class=\"container_3 account-wide\" align=\"center\">\r\n\t\t\t<table class=\"general-table-ui\" cellspacing=\"0\">\r\n\t\t\t\t<tr>\r\n\t\t\t\t\t<th colspan=\"2\" align=\"center\"><b>" . lang("donation_txt_8", true) . ":</b></th>\r\n\t\t\t\t</tr>\r\n\t\t\t\t<tr>\r\n\t\t\t\t\t<td width=\"50%\">" . lang("donation_txt_9", true) . ":</td>\r\n\t\t\t\t\t<td width=\"50%\">" . mconfig("name") . "</td>\r\n\t\t\t\t</tr>\r\n\t\t\t\t<tr>\r\n\t\t\t\t\t<td>" . lang("donation_txt_10", true) . ":</td>\r\n\t\t\t\t\t<td>" . mconfig("address") . "</td>\r\n\t\t\t\t</tr>\r\n\t\t\t\t<tr>\r\n\t\t\t\t\t<td>" . lang("donation_txt_11", true) . ":</td>\r\n\t\t\t\t\t<td>" . mconfig("city_state") . "</td>\r\n\t\t\t\t</tr>\r\n\t\t\t\t<tr>\r\n\t\t\t\t\t<td>" . lang("donation_txt_12", true) . ":</td>\r\n\t\t\t\t\t<td>" . mconfig("country") . "</td>\r\n\t\t\t\t</tr>\r\n\t\t\t</table>\r\n\r\n\t\t\t<div style=\"padding: 20px 0 20px 0\">\r\n\t\t\t\t<table class=\"general-table-ui\" cellspacing=\"0\" style=\"padding-bottom: 10px;\">\r\n                    <tr>\r\n                        <th align=\"center\">";
            echo sprintf(lang("donation_txt_13", true), mconfig("email"));
            echo "\r\n                        </th>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>" . lang("donation_txt_14", true) . "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>" . lang("donation_txt_15", true) . "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>" . lang("donation_txt_16", true) . "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>" . lang("donation_txt_17", true) . "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>" . lang("donation_txt_18", true) . "</td>\r\n                    </tr>\r\n\t\t\t\t</table>\r\n\t\t\t</div>\r\n\t\t</div>";
        } else {
            message("error", lang("error_47", true));
        }
        echo "\r\n\t</div>\r\n</div>";
    }
}

?>