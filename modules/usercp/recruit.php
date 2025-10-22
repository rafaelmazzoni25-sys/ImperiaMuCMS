<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

if (!isLoggedIn()) {
    redirect(1, "login");
} else {
    if (!canAccessModule($_SESSION["username"], "recruit", "block")) {
        return NULL;
    }
    if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
        $breadcrumb = generateBreadcrumb();
        echo "\r\n    <h3>\r\n        " . lang("recruit_txt_11", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
        if (mconfig("active")) {
            $General = new xGeneral();
            $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("recruit");
            $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("recruit");
            $Recruit = new Recruit();
            if (check_value($_POST["submit1"])) {
                if ($_SESSION["token"] == $_POST["token"]) {
                    $friend = Decode($_POST[Encode("username")]);
                    $Recruit->giveRewardInviter($_SESSION["username"], $friend);
                } else {
                    message("notice", lang("global_module_13", true));
                }
            }
            if (check_value($_POST["submit2"])) {
                if ($_SESSION["token"] == $_POST["token"]) {
                    $inviter = Decode($_POST[Encode("username")]);
                    $Recruit->giveRewardFriend($_SESSION["username"], $inviter);
                } else {
                    message("notice", lang("global_module_13", true));
                }
            }
            $RecruitedFriends = $Recruit->getInvitedFriends($_SESSION["username"]);
            $InvitedBy = $Recruit->getInvitedBy($_SESSION["username"]);
            $token = time();
            $_SESSION["token"] = $token;
            echo "\r\n    <div class=\"form-group\">\r\n        <label for=\"raf-hash\">" . lang("recruit_txt_12", true) . "</label>\r\n        <div class=\"input-group\">\r\n            <input type=\"text\" class=\"form-control recruit-link\" id=\"raf-hash\" value=\"" . __BASE_URL__ . "register?ref=" . Encode($_SESSION["username"]) . "\" readonly=\"readonly\">\r\n            <div class=\"input-group-addon\" onclick=\"copyToClipboard();\" style=\"cursor: pointer;\"><i class=\"far fa-copy\"></i></div>\r\n        </div>\r\n    </div>";
            echo "\r\n    <script>\r\n        function copyToClipboard() {\r\n            var copyText = document.getElementById(\"raf-hash\");\r\n            copyText.select();\r\n            document.execCommand(\"copy\");\r\n        }\r\n    </script>";
            echo "\r\n    <div class=\"table-responsive rankings-table\">\r\n        <table class=\"table table-hover text-center\">\r\n            <tr>\r\n                <th class=\"headerRow\" colspan=\"4\">" . lang("recruit_txt_13", true) . "</th>\r\n            </tr>\r\n            <tr>\r\n                <th class=\"headerRow\">#</th>\r\n                <th class=\"headerRow\">" . lang("recruit_txt_14", true) . "</th>\r\n                <th class=\"headerRow\">" . lang("recruit_txt_15", true) . "</th>\r\n                <th class=\"headerRow\">" . lang("recruit_txt_16", true) . "</th>\r\n            </tr>";
            if (is_array($RecruitedFriends)) {
                $i = 1;
                foreach ($RecruitedFriends as $thisFriend) {
                    $progressData = $Recruit->checkProgress($thisFriend["AccountID_Friend"], $thisFriend["AccountID_Inviter"], "inviter");
                    echo "\r\n            <form action=\"\" method=\"post\">\r\n                <input type=\"hidden\" name=\"" . Encode("username") . "\" value=\"" . Encode($thisFriend["AccountID_Friend"]) . "\"/>\r\n                <tr>\r\n                    <td>" . $i . "</td>\r\n                    <td>" . $thisFriend["AccountID_Friend"] . "</td>\r\n                    <td>" . date($config["date_format"], strtotime($thisFriend["date"])) . "</td>\r\n                    <td><input type=\"hidden\" name=\"token\" value=\"" . $token . "\">" . $progressData . "</td>\r\n                </tr>\r\n            </form>";
                    $i++;
                }
            } else {
                echo "\r\n            <tr>\r\n                <td colspan=\"4\">" . lang("recruit_txt_17", true) . "</td>\r\n            </tr>";
            }
            echo "\r\n        </table>\r\n    </div>";
            echo "\r\n    <div class=\"table-responsive rankings-table\">\r\n        <table class=\"table table-hover text-center\">\r\n            <tr>\r\n                <th class=\"headerRow\" colspan=\"3\">" . lang("recruit_txt_18", true) . "</th>\r\n            </tr>\r\n            <tr>\r\n                <th class=\"headerRow\">" . lang("recruit_txt_14", true) . "</th>\r\n                <th class=\"headerRow\">" . lang("recruit_txt_15", true) . "</th>\r\n                <th class=\"headerRow\">" . lang("recruit_txt_16", true) . "</th>\r\n            </tr>";
            if (is_array($InvitedBy)) {
                $progressData = $Recruit->checkProgress($InvitedBy["AccountID_Friend"], $InvitedBy["AccountID_Inviter"], "friend");
                echo "\r\n            <form action=\"\" method=\"post\">\r\n                <input type=\"hidden\" name=\"" . Encode("username") . "\" value=\"" . Encode($InvitedBy["AccountID_Inviter"]) . "\"/>\r\n                <tr>\r\n                    <td>" . $InvitedBy["AccountID_Inviter"] . "</td>\r\n                    <td>" . date($config["date_format"], strtotime($InvitedBy["date"])) . "</td>\r\n                    <td><input type=\"hidden\" name=\"token\" value=\"" . $token . "\">" . $progressData . "</td>\r\n                </tr>\r\n            </form>";
            } else {
                echo "\r\n            <tr>\r\n                <td colspan=\"3\">" . lang("recruit_txt_19", true) . "</td>\r\n            </tr>";
            }
            echo "\r\n        </table>\r\n    </div>";
        } else {
            message("error", lang("error_47", true));
        }
    } else {
        echo "\r\n<div class=\"sub-page-title\">\r\n    <div id=\"title\">\r\n        <h1>" . lang("module_titles_txt_3", true) . "<p></p><span></span></h1>\r\n    </div>\r\n</div>\r\n\r\n<div class=\"container_2 account\" align=\"center\">\r\n    <div class=\"cont-image\">\r\n        <div class=\"container_3 account_sub_header\">\r\n            <div class=\"grad\">\r\n            <div class=\"page-title\"><p>" . lang("recruit_txt_11", true) . "</p></div>\r\n            <a href=\"" . __BASE_URL__ . "usercp\">" . lang("global_module_1", true) . "</a>\r\n        </div>\r\n    </div>\r\n    <div class=\"page-desc-holder\"></div>";
        if (mconfig("active")) {
            $General = new xGeneral();
            $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("recruit");
            $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("recruit");
            $Recruit = new Recruit();
            if (check_value($_POST["submit1"])) {
                if ($_SESSION["token"] == $_POST["token"]) {
                    $friend = Decode($_POST[Encode("username")]);
                    $Recruit->giveRewardInviter($_SESSION["username"], $friend);
                } else {
                    message("notice", lang("global_module_13", true));
                }
            }
            if (check_value($_POST["submit2"])) {
                if ($_SESSION["token"] == $_POST["token"]) {
                    $inviter = Decode($_POST[Encode("username")]);
                    $Recruit->giveRewardFriend($_SESSION["username"], $inviter);
                } else {
                    message("notice", lang("global_module_13", true));
                }
            }
            $RecruitedFriends = $Recruit->getInvitedFriends($_SESSION["username"]);
            $InvitedBy = $Recruit->getInvitedBy($_SESSION["username"]);
            $token = time();
            $_SESSION["token"] = $token;
            echo "\r\n      <div class=\"container_3 account-wide\" align=\"center\">\r\n        <div style=\"padding-top: 20px\"></div>\r\n        <div class=\"recruit-link-holder\">\r\n            <h2>" . lang("recruit_txt_12", true) . "</h2>\r\n            <div class=\"recruit-link\">\r\n                <div class=\"email-link\">\r\n                    <input type=\"text\" value=\"" . __BASE_URL__ . "register?ref=" . Encode($_SESSION["username"]) . "\" id=\"raf-hash\">\r\n                </div>\r\n                <span id=\"raf-hash-btn\" onclick=\"copyToClipboard();\"></span>\r\n            </div>\r\n        </div>";
            echo "\r\n    <script>\r\n        \r\n        function copyToClipboard() {\r\n            var copyText = document.getElementById(\"raf-hash\");\r\n            copyText.select();\r\n            document.execCommand(\"copy\");\r\n        }\r\n        \r\n    </script>";
            echo "\r\n            <table class=\"general-table-ui\" cellspacing=\"0\">\r\n                <tr>\r\n                    <th colspan=\"4\"><font color=\"#f7c97a\">" . lang("recruit_txt_13", true) . "</font></th>\r\n                </tr>\r\n                <tr>\r\n                    <th>#</th>\r\n                    <th>" . lang("recruit_txt_14", true) . "</th>\r\n                    <th>" . lang("recruit_txt_15", true) . "</th>\r\n                    <th>" . lang("recruit_txt_16", true) . "</th>\r\n                </tr>";
            if (is_array($RecruitedFriends)) {
                $i = 1;
                foreach ($RecruitedFriends as $thisFriend) {
                    $progressData = $Recruit->checkProgress($thisFriend["AccountID_Friend"], $thisFriend["AccountID_Inviter"], "inviter");
                    echo "\r\n                <form action=\"\" method=\"post\">\r\n\t\t\t\t\t<input type=\"hidden\" name=\"" . Encode("username") . "\" value=\"" . Encode($thisFriend["AccountID_Friend"]) . "\"/>\r\n\t\t\t\t\t<tr>\r\n  \t\t\t\t\t    <td>" . $i . "</td>\r\n                        <td>" . $thisFriend["AccountID_Friend"] . "</td>\r\n                        <td>" . date($config["date_format"], strtotime($thisFriend["date"])) . "</td>\r\n                        <td><input type=\"hidden\" name=\"token\" value=\"" . $token . "\">" . $progressData . "</td>\r\n                    </tr>\r\n                </form>";
                    $i++;
                }
            } else {
                echo "\r\n                <tr>\r\n                    <td colspan=\"4\">" . lang("recruit_txt_17", true) . "</td>\r\n                </tr>";
            }
            echo "\r\n            </table>";
            echo "\r\n            <br /><br />\r\n            <table class=\"general-table-ui\" cellspacing=\"0\">\r\n                <tr>\r\n                    <th colspan=\"3\"><font color=\"#f7c97a\">" . lang("recruit_txt_18", true) . "</font></th>\r\n                </tr>\r\n                <tr>\r\n                    <th>" . lang("recruit_txt_14", true) . "</th>\r\n                    <th>" . lang("recruit_txt_15", true) . "</th>\r\n                    <th>" . lang("recruit_txt_16", true) . "</th>\r\n                </tr>";
            if (is_array($InvitedBy)) {
                $progressData = $Recruit->checkProgress($InvitedBy["AccountID_Friend"], $InvitedBy["AccountID_Inviter"], "friend");
                echo "\r\n                <form action=\"\" method=\"post\">\r\n  \t\t\t\t    <input type=\"hidden\" name=\"" . Encode("username") . "\" value=\"" . Encode($InvitedBy["AccountID_Inviter"]) . "\"/>\r\n                    <tr>\r\n                        <td>" . $InvitedBy["AccountID_Inviter"] . "</td>\r\n                        <td>" . date($config["date_format"], strtotime($InvitedBy["date"])) . "</td>\r\n                        <td><input type=\"hidden\" name=\"token\" value=\"" . $token . "\">" . $progressData . "</td>\r\n                    </tr>\r\n                </form>";
            } else {
                echo "\r\n                <tr>\r\n                    <td colspan=\"3\">" . lang("recruit_txt_19", true) . "</td>\r\n                </tr>";
            }
            echo "\r\n            </table>\r\n        </div>";
        } else {
            message("error", lang("error_47", true));
        }
        echo "\r\n\t</div>\r\n</div>";
    }
}

?>