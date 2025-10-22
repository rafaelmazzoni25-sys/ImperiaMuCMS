<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */
if (!isLoggedIn()) {
    redirect(1, "login");
} else {
    if (!canAccessModule($_SESSION["username"], "settings", "allow")) {
        return NULL;
    }
    echo "\r\n<div class=\"sub-page-title\">\r\n\t<div id=\"title\"><h1>" . lang("module_titles_txt_3", true) . "<p></p><span></span></h1></div>\r\n</div>\r\n\r\n<div class=\"container_2 account\" align=\"center\">\r\n  <div class=\"cont-image\">\r\n    <div class=\"container_3 account_sub_header\">\r\n      <div class=\"grad\">\r\n        <div class=\"page-title\">" . lang("settings_txt_1", true) . "</div>\r\n        <a href=\"" . __BASE_URL__ . "usercp\">" . lang("global_module_1", true) . "</a>\r\n      </div>\r\n    </div>\r\n    <div class=\"vote-page\">\r\n      <div class=\"container_3 account-wide\" align=\"center\">\r\n        <ul class=\"account-settings\">";
    loadModuleConfigs("usercp.mypassword");
    if (mconfig("active")) {
        echo "<li>\r\n            <a href=\"" . __BASE_URL__ . "usercp/mypassword\">\r\n            " . lang("settings_txt_2", true) . "\r\n            <p>" . lang("settings_txt_3", true) . "</p>\r\n            </a>\r\n          </li>";
    }
    loadModuleConfigs("usercp.myemail");
    if (mconfig("active")) {
        echo "<li>\r\n            <a href=\"" . __BASE_URL__ . "usercp/myemail\">\r\n            " . lang("settings_txt_4", true) . "\r\n            <p>" . lang("settings_txt_5", true) . "</p>\r\n            </a>\r\n          </li>";
    }
    loadModuleConfigs("ticket");
    if (mconfig("active")) {
        echo "<li>\r\n            <a href=\"" . __BASE_URL__ . "ticket\">\r\n            " . lang("settings_txt_6", true) . "\r\n            <p>" . lang("settings_txt_7", true) . "</p>\r\n            </a>\r\n          </li>";
    }
    echo "\r\n        </ul>\r\n      </div>\r\n    </div>\r\n  </div>\r\n</div>";
}

?>