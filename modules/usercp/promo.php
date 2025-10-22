<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

if (!isLoggedIn()) {
    redirect(1, "login");
} else {
    if (!canAccessModule($_SESSION["username"], "promo", "block")) {
        return NULL;
    }
    echo "\r\n<script type=\"text/javascript\" src=\"" . __PATH_TEMPLATE__ . "js/jquery.maskedinput.js\"></script>\r\n<script>\r\n    jQuery(function (\$) {\r\n        \$.mask.definitions['c'] = \"[a-zA-Z0-9]\";\r\n        \$(\"#code\").mask(\"cccc-cccc-cccc\", {placeholder: \"-\"});\r\n    });\r\n</script>";
    if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
        $breadcrumb = generateBreadcrumb();
        echo "\r\n    <h3>\r\n        " . lang("promo_txt_10", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
        if (mconfig("active")) {
            $General = new xGeneral();
            $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("promo");
            $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("promo");
            echo "\r\n    <div class=\"row desc-row\">\r\n        <div class=\"col-xs-12\">\r\n            " . lang("promo_txt_11", true) . "\r\n        </div>\r\n    </div>";
            $Promo = new Promo();
            if (check_value($_POST["submit"])) {
                if ($_SESSION["token"] == $_POST["token"]) {
                    if ($Promo->canUseCode($_POST["code"], $_SESSION["username"])) {
                        $Promo->giveReward($_POST["code"], $_SESSION["username"]);
                    } else {
                        message("error", lang("promo_txt_12", true));
                    }
                } else {
                    message("notice", lang("global_module_13", true));
                }
            }
            $token = time();
            $_SESSION["token"] = $token;
            echo "\r\n    <div class=\"col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 col-center\">\r\n        <form method=\"post\">\r\n            <div class=\"form-group\">\r\n                <input type=\"text\" id=\"code\" name=\"code\" placeholder=\"" . lang("promo_txt_13", true) . "\" class=\"form-control promo-code-input\" aria-describedby=\"helpBlock\">\r\n            </div>\r\n            <span class=\"help-block\" id=\"helpBlock\">" . lang("promo_txt_14", true) . "</span>\r\n            <div class=\"form-group\">\r\n                <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                <input type=\"submit\" name=\"submit\" value=\"" . lang("promo_txt_15", true) . "\" class=\"btn btn-warning full-width-btn\">\r\n            </div>\r\n        </form>\r\n    </div>";
        } else {
            message("error", lang("error_47", true));
        }
    } else {
        echo "\r\n<div class=\"sub-page-title\">\r\n\t<div id=\"title\"><h1>" . lang("module_titles_txt_3", true) . "<p></p><span></span></h1></div>\r\n</div>";
        echo "\r\n<div class=\"container_2 account\" align=\"center\">\r\n  <div class=\"cont-image\">\r\n    <div class=\"container_3 account_sub_header\">\r\n      <div class=\"grad\">\r\n        <div class=\"page-title\">" . lang("promo_txt_10", true) . "</div>\r\n        <a href=\"" . __BASE_URL__ . "usercp\">" . lang("global_module_1", true) . "</a>\r\n      </div>\r\n    </div>\r\n    <div class=\"faction-change\">\r\n      <div class=\"page-desc-holder\">\r\n        " . lang("promo_txt_11", true) . "\r\n      </div>";
        if (mconfig("active")) {
            $General = new xGeneral();
            $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("promo");
            $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("promo");
            $Promo = new Promo();
            if (check_value($_POST["submit"])) {
                if ($_SESSION["token"] == $_POST["token"]) {
                    if ($Promo->canUseCode($_POST["code"], $_SESSION["username"])) {
                        $Promo->giveReward($_POST["code"], $_SESSION["username"]);
                    } else {
                        message("error", lang("promo_txt_12", true));
                    }
                } else {
                    message("notice", lang("global_module_13", true));
                }
            }
            $token = time();
            $_SESSION["token"] = $token;
            echo "\r\n      <div class=\"container_3 account-wide\" align=\"center\">\r\n        <div class=\"promotion_codes\">\r\n          <div class=\"pcode-top-cont\">\r\n            <form id=\"promo-code-form\" method=\"post\">\r\n              <input type=\"text\" id=\"code\" name=\"code\" placeholder=\"" . lang("promo_txt_13", true) . "\" style=\"text-align: center;\">\r\n              <p style=\"text-align:left;\">" . lang("promo_txt_14", true) . "</p>\r\n              <br /><div align=\"right\"><input type=\"hidden\" name=\"token\" value=\"" . $token . "\"><input type=\"submit\" name=\"submit\" value=\"" . lang("promo_txt_15", true) . "\"></div>\r\n            </form>\r\n            <div class=\"clear\"></div>\r\n          </div>\r\n        </div>\r\n      </div>";
        }
        echo "\r\n    </div>\r\n  </div>\r\n</div>";
    }
}

?>