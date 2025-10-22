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
        echo "\r\n    <h3>\r\n        " . lang("module_titles_txt_32", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
        if (mconfig("active")) {
            $General = new xGeneral();
            $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("paynl");
            $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("paynl");
            echo "\r\n    <div class=\"row\">\r\n        <div class=\"col-xs-12 col-md-6 col-md-offset-3\">\r\n            <form action=\"" . __BASE_URL__ . "api/paynl.submit_data.php\" method=\"post\" target=\"_top\">\r\n                <input type=\"hidden\" name=\"x\" value=\"500\">\r\n                <input type=\"hidden\" name=\"username\" value=\"" . $_SESSION["username"] . "\">\r\n                <input type=\"submit\" value=\"€5 - 500 Gold Coins\" class=\"btn btn-warning full-width-btn make-space\" alt=\"10\" class=\"forms\">\r\n            </form>\r\n            <form action=\"" . __BASE_URL__ . "api/paynl.submit_data.php\" method=\"post\" target=\"_top\">\r\n                <input type=\"hidden\" name=\"x\" value=\"1000\">\r\n                <input type=\"hidden\" name=\"username\" value=\"" . $_SESSION["username"] . "\">\r\n                <input type=\"submit\" value=\"€10 - 1000 Gold Coins\" class=\"btn btn-warning full-width-btn make-space\" alt=\"10\" class=\"forms\">\r\n            </form>\r\n            <form action=\"" . __BASE_URL__ . "api/paynl.submit_data.php\" method=\"post\" target=\"_top\">\r\n                <input type=\"hidden\" name=\"x\" value=\"2500\">\r\n                <input type=\"hidden\" name=\"username\" value=\"" . $_SESSION["username"] . "\">\r\n                <input type=\"submit\" value=\"€25 - 2500 Gold Coins\" class=\"btn btn-warning full-width-btn make-space\" alt=\"10\" class=\"forms\">\r\n            </form>\r\n        </div>\r\n    </div>";
        } else {
            message("error", lang("error_47", true));
        }
    } else {
        echo "\r\n  <div class=\"sub-page-title\">\r\n    <div id=\"title\">\r\n      <h1>" . lang("module_titles_txt_3", true) . "<p></p><span></span></h1>\r\n    </div>\r\n  </div>\r\n\r\n  <div class=\"container_2 account\" align=\"center\">\r\n    <div class=\"cont-image\">\r\n      <div class=\"container_3 account_sub_header\">\r\n        <div class=\"grad\">\r\n          <div class=\"page-title\"><p>" . lang("donation_txt_3", true) . "</p></div>\r\n          <div class=\"sub-active-page\">" . lang("module_titles_txt_32", true) . "</div>\r\n          <a href=\"" . __BASE_URL__ . "donation\">" . lang("donation_txt_6", true) . "</a>\r\n        </div>\r\n      </div>\r\n      <!-- Purchase Gold Coins -->\r\n      <div class=\"page-desc-holder\"></div>";
        if (mconfig("active")) {
            $General = new xGeneral();
            $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("paynl");
            $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("paynl");
            echo "        <div class=\"container_3 account-wide\" align=\"center\">\r\n            <br>\r\n            <div class=\"paynl-gateway-logo\"></div>\r\n            <form action=\"https://obversemu.com/high/api/paynl.submit_data.php\" method=\"post\" target=\"_top\">\r\n                <input type=\"hidden\" name=\"x\" value=\"500\">\r\n                <input type=\"hidden\" name=\"username\" value=\"";
            echo $_SESSION["username"];
            echo "\">\r\n                <input type=\"submit\" value=\"€5 - 500 Gold Coins\" alt=\"10\" class=\"forms\">\r\n            </form>\r\n            <br>\r\n\r\n            <form action=\"https://obversemu.com/high/api/paynl.submit_data.php\" method=\"post\" target=\"_top\">\r\n                <input type=\"hidden\" name=\"x\" value=\"1000\">\r\n                <input type=\"hidden\" name=\"username\" value=\"";
            echo $_SESSION["username"];
            echo "\">\r\n                <input type=\"submit\" value=\"€10 - 1000 Gold Coins\" alt=\"10\" class=\"forms\">\r\n            </form>\r\n            <br>\r\n\r\n            <form action=\"https://obversemu.com/high/api/paynl.submit_data.php\" method=\"post\" target=\"_top\">\r\n                <input type=\"hidden\" name=\"x\" value=\"2000\">\r\n                <input type=\"hidden\" name=\"username\" value=\"";
            echo $_SESSION["username"];
            echo "\">\r\n                <input type=\"submit\" value=\"€20 - 2100 Gold Coins\" alt=\"10\" class=\"forms\">\r\n            </form>\r\n            <br>\r\n\r\n            <form action=\"https://obversemu.com/high/api/paynl.submit_data.php\" method=\"post\" target=\"_top\">\r\n                <input type=\"hidden\" name=\"x\" value=\"3000\">\r\n                <input type=\"hidden\" name=\"username\" value=\"";
            echo $_SESSION["username"];
            echo "\">\r\n                <input type=\"submit\" value=\"€30 - 3300 Gold Coins\" alt=\"10\" class=\"forms\">\r\n            </form>\r\n            <br>\r\n\r\n            <form action=\"https://obversemu.com/high/api/paynl.submit_data.php\" method=\"post\" target=\"_top\">\r\n                <input type=\"hidden\" name=\"x\" value=\"4000\">\r\n                <input type=\"hidden\" name=\"username\" value=\"";
            echo $_SESSION["username"];
            echo "\">\r\n                <input type=\"submit\" value=\"€40 - 4500 Gold Coins\" alt=\"10\" class=\"forms\">\r\n            </form>\r\n            <br>\r\n\r\n            <form action=\"https://obversemu.com/high/api/paynl.submit_data.php\" method=\"post\" target=\"_top\">\r\n                <input type=\"hidden\" name=\"x\" value=\"5000\">\r\n                <input type=\"hidden\" name=\"username\" value=\"";
            echo $_SESSION["username"];
            echo "\">\r\n                <input type=\"submit\" value=\"€50 - 5750 Gold Coins\" alt=\"10\" class=\"forms\">\r\n            </form>\r\n            <br>\r\n        </div>\r\n\r\n        ";
        } else {
            message("error", lang("error_47", true));
        }
        echo "\r\n      <!-- Purchase Gold Coins.End -->\r\n    </div>\r\n  </div>\r\n\t";
    }
}

?>