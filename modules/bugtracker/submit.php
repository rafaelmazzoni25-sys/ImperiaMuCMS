<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

if (!isLoggedIn()) {
    redirect(1, "login");
} else {
    loadModuleConfigs("bugtracker");
    if (!canAccessModule($_SESSION["username"], "bugtracker", "block")) {
        return NULL;
    }
    $BugTracker = new BugTracker();
    if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
        $breadcrumb = generateBreadcrumb();
        echo "\r\n    <h3>\r\n        " . lang("module_titles_txt_29", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
        if (mconfig("active")) {
            $General = new xGeneral();
            $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("bugtracker");
            $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("bugtracker");
            if (check_value($_POST["submit"])) {
                if ($_SESSION["token"] == $_POST["token"]) {
                    if (check_value($_POST["mainCategory"]) && check_value($_POST["title"]) && check_value($_POST["text"]) && check_value($_POST["prio"])) {
                        $category = htmlspecialchars($_POST["mainCategory"]);
                        $title = htmlspecialchars($_POST["title"]);
                        $text = htmlspecialchars($_POST["text"]);
                        $priority = htmlspecialchars($_POST["prio"]);
                        $date = date("Y-m-d H:i:s", time());
                        $BugTracker->submitReport($category, $title, $text, $priority, $_SESSION["username"], $date);
                    } else {
                        message("error", lang("error_57", true));
                    }
                } else {
                    message("notice", lang("global_module_13", true));
                }
            }
            $token = time();
            $_SESSION["token"] = $token;
            echo "\r\n        <div class=\"row\">\r\n            <div class=\"col-xs-12\">" . lang("bugtracker_txt_3", true) . "</div>\r\n        </div>\r\n        <div class=\"row\">\r\n            <div class=\"col-xs-12\">\r\n                <form method=\"post\" action=\"\" name=\"BTSubmitForm\">\r\n                    <select class=\"form-control bug-tracker-input\" name=\"mainCategory\">\r\n                        <option value=\"0\" disabled=\"disabled\">" . lang("bugtracker_txt_4", true) . "</option>\r\n                        <option value=\"1\">" . lang("bugtracker_txt_5", true) . "</option>\r\n                        <option value=\"2\" selected=\"selected\">" . lang("bugtracker_txt_6", true) . "</option>\r\n                    </select>\r\n                    <input name=\"title\" class=\"form-control bug-tracker-input\" type=\"text\" placeholder=\"" . lang("bugtracker_txt_7", true) . "\" maxlength=\"" . mconfig("title_max") . "\">\r\n                    <textarea rows=\"10\" name=\"text\" class=\"form-control bug-tracker-input\" placeholder=\"" . lang("bugtracker_txt_8", true) . "\" maxlength=\"" . mconfig("text_max") . "\"></textarea>\r\n                    <div class=\"bug-tracker-input\">\r\n                        <label class=\"radio-inline\">\r\n                            <input type=\"radio\" name=\"prio\" value=\"1\"> " . lang("bugtracker_txt_9", true) . "\r\n                        </label>\r\n                        <label class=\"radio-inline\">\r\n                            <input type=\"radio\" name=\"prio\" value=\"2\" checked=\"checked\"> " . lang("bugtracker_txt_10", true) . "\r\n                        </label>\r\n                        <label class=\"radio-inline\">\r\n                            <input type=\"radio\" name=\"prio\" value=\"3\"> " . lang("bugtracker_txt_11", true) . "\r\n                        </label>\r\n                    </div>\r\n                    <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                    <input type=\"submit\" name=\"submit\" class=\"btn btn-warning bug-tracker-input-btn\" value=\"" . lang("bugtracker_txt_25", true) . "\">\r\n                </form>\r\n            </div>\r\n        </div>";
        } else {
            message("error", lang("error_47", true));
        }
    } else {
        $General = new xGeneral();
        $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("bugtracker");
        $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("bugtracker");
        echo "\r\n    <script type=\"text/javascript\">\r\n        \$(document).ready(function () {\r\n            \$(\"input[name='prio']\").change(function () {\r\n                \$(\".label_radio\").each(function () {\r\n                    \$(this).removeClass(\"r_on\");\r\n                });\r\n                \$(this).parent().addClass(\"r_on\");\r\n            });\r\n        });\r\n    </script>\r\n\r\n    <div class=\"sub-page-title\">\r\n        <div id=\"title\">\r\n            <h1>";
        echo lang("module_titles_txt_29", true);
        echo "<p></p><span></span></h1>\r\n        </div>\r\n    </div>\r\n\r\n    <div class=\"container_2\" align=\"center\">\r\n        <div class=\"container_3 account_sub_header\">\r\n            <div class=\"grad\">\r\n                <div class=\"page-title\"><p>";
        echo lang("bugtracker_txt_1", true);
        echo "</p></div>\r\n                <a href=\"";
        echo __BASE_URL__;
        echo "bugtracker\">";
        echo lang("bugtracker_txt_2", true);
        echo "</a>\r\n            </div>\r\n        </div>\r\n\r\n        ";
        if (check_value($_POST["submit"])) {
            if ($_SESSION["token"] == $_POST["token"]) {
                if (check_value($_POST["mainCategory"]) && check_value($_POST["title"]) && check_value($_POST["text"]) && check_value($_POST["prio"])) {
                    $category = htmlspecialchars($_POST["mainCategory"]);
                    $title = htmlspecialchars($_POST["title"]);
                    $text = htmlspecialchars($_POST["text"]);
                    $priority = htmlspecialchars($_POST["prio"]);
                    $date = date("Y-m-d H:i:s", time());
                    $BugTracker->submitReport($category, $title, $text, $priority, $_SESSION["username"], $date);
                } else {
                    message("error", lang("error_57", true));
                }
            } else {
                message("notice", lang("global_module_13", true));
            }
        }
        $token = time();
        $_SESSION["token"] = $token;
        echo "\r\n        <div class=\"page-desc-holder\">\r\n            <b>";
        echo lang("bugtracker_txt_3", true);
        echo "</b>\r\n        </div>\r\n\r\n        <div class=\"holder-bugtracker-form container_3 account-wide\" align=\"left\" style=\"padding:36px\">\r\n            <form method=\"post\" action=\"\" name=\"BTSubmitForm\">\r\n                <div style=\"display:inline-block\">\r\n                    <select styled=\"true\" name=\"mainCategory\" onchange=\"return showCategories(this);\"\r\n                            style=\"display: none;\">\r\n                        <option value=\"0\" disabled=\"disabled\">";
        echo lang("bugtracker_txt_4", true);
        echo "</option>\r\n                        <option value=\"1\">";
        echo lang("bugtracker_txt_5", true);
        echo "</option>\r\n                        <option value=\"2\" selected=\"selected\">";
        echo lang("bugtracker_txt_6", true);
        echo "</option>\r\n                    </select>\r\n                </div>\r\n                <div class=\"sub-selects\">\r\n                    <div id=\"category-select\" style=\"display:inline-block; margin:0 0 0 9px; display:none;\"></div>\r\n                    <div id=\"subcategory-select\" style=\"display:inline-block; margin:0 0 0 9px; display:none;\"></div>\r\n                </div>\r\n                <br>\r\n                <input name=\"title\" type=\"text\" placeholder=\"";
        echo lang("bugtracker_txt_7", true);
        echo "\"\r\n                       style=\"margin:15px 0 15px 0;\" maxlength=\"";
        echo mconfig("title_max");
        echo "\">\r\n                <textarea name=\"text\" style=\"display:block; float:none; width:800px; height:300px; margin:0 0 15px 0;\"\r\n                          placeholder=\"";
        echo lang("bugtracker_txt_8", true);
        echo "\"\r\n                          maxlength=\"";
        echo mconfig("text_max");
        echo "\"></textarea>\r\n                <div class=\"has-js select-priority\">\r\n                    <label class=\"label_radio\">\r\n                        <div></div>\r\n                        <input type=\"radio\" name=\"prio\" value=\"1\">\r\n                        <p>";
        echo lang("bugtracker_txt_9", true);
        echo "</p>\r\n                    </label>\r\n                    <label class=\"label_radio r_on\">\r\n                        <div></div>\r\n                        <input type=\"radio\" name=\"prio\" value=\"2\" checked=\"checked\">\r\n                        <p>";
        echo lang("bugtracker_txt_10", true);
        echo "</p>\r\n                    </label>\r\n                    <label class=\"label_radio\">\r\n                        <div></div>\r\n                        <input type=\"radio\" name=\"prio\" value=\"3\">\r\n                        <p>";
        echo lang("bugtracker_txt_11", true);
        echo "</p>\r\n                    </label>\r\n                </div>\r\n                <input type=\"hidden\" name=\"token\" value=\"";
        echo $token;
        echo "\">\r\n                <input type=\"submit\" name=\"submit\" value=\"Report\">\r\n            </form>\r\n        </div>\r\n    </div>\r\n    ";
    }
}

?>