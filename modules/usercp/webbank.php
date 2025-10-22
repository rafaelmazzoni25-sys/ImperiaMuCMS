<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */
if (!isLoggedIn()) {
    redirect(1, "login");
} else {
    if (!canAccessModule($_SESSION["username"], "webbank", "block")) {
        return NULL;
    }
    if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
        $breadcrumb = generateBreadcrumb();
        echo "\r\n    <h3>\r\n        " . lang("myaccount_txt_60", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
        if (mconfig("active")) {
            $General = new xGeneral();
            $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("webbank");
            $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("webbank");
            echo "\r\n    <script type=\"text/javascript\">\r\n        function switchJewelSelect(val) {\r\n            if (val == \"insert\") {\r\n                \$(\"#jewel-insert\").removeAttr(\"disabled\");\r\n                \$(\"#jewel-insert\").show();\r\n                \$(\"#jewel-withdraw\").attr(\"disabled\", \"disabled\");\r\n                \$(\"#jewel-withdraw\").hide();\r\n            } else if (val == \"withdraw\") {\r\n                \$(\"#jewel-withdraw\").removeAttr(\"disabled\");\r\n                \$(\"#jewel-withdraw\").show();\r\n                \$(\"#jewel-insert\").attr(\"disabled\", \"disabled\");\r\n                \$(\"#jewel-insert\").hide();\r\n            }\r\n        }\r\n    </script>";
            echo "\r\n    <div class=\"row desc-row\">\r\n        <div class=\"col-xs-12\">\r\n            " . lang("webbank_txt_1", true) . "\r\n        </div>\r\n    </div>";
            $Market = new Market();
            if (check_value($_POST["submit_jewel"])) {
                if ($_SESSION["token"] == $_POST["token"]) {
                    $type = xss_clean(htmlspecialchars($_POST["type"]));
                    if ($type == "insert") {
                        if ($common->beginDbTrans($_SESSION["username"])) {
                            $Market->insertJewels($_SESSION["username"], $_POST["jewel"], $_POST["amount"]);
                            $common->endDbTrans($_SESSION["username"]);
                        }
                    } else {
                        if ($type == "withdraw") {
                            if (140 <= config("server_files_season", true)) {
                                if ($common->beginDbTrans($_SESSION["username"])) {
                                    $Market->withdrawJewelsS14($_SESSION["username"], $_POST["jewel"], $_POST["amount"]);
                                    $common->endDbTrans($_SESSION["username"]);
                                }
                            } else {
                                if ($common->beginDbTrans($_SESSION["username"])) {
                                    $Market->withdrawJewels($_SESSION["username"], $_POST["jewel"], $_POST["amount"]);
                                    $common->endDbTrans($_SESSION["username"]);
                                }
                            }
                        }
                    }
                } else {
                    message("notice", lang("global_module_13", true));
                }
            }
            if (check_value($_POST["submit_zen"])) {
                if ($_SESSION["token"] == $_POST["token"]) {
                    $type = xss_clean(htmlspecialchars($_POST["type"]));
                    if ($type == "insert") {
                        if ($common->beginDbTrans($_SESSION["username"])) {
                            $Market->insertZen($_SESSION["username"], $_POST["char"], $_POST["amount"]);
                            $common->endDbTrans($_SESSION["username"]);
                        }
                    } else {
                        if ($type == "withdraw" && $common->beginDbTrans($_SESSION["username"])) {
                            $Market->withdrawZen($_SESSION["username"], $_POST["char"], $_POST["amount"]);
                            $common->endDbTrans($_SESSION["username"]);
                        }
                    }
                } else {
                    message("notice", lang("global_module_13", true));
                }
            }
            if (check_value($_POST["submit_item"])) {
                if ($_SESSION["token"] == $_POST["token"]) {
                    $type = xss_clean(htmlspecialchars($_POST["type"]));
                    if ($type == "insert") {
                        if ($common->beginDbTrans($_SESSION["username"])) {
                            $Market->insertCustomItem($_SESSION["username"], Decode($_POST["char"]), $_POST["item"], $_POST["amount"]);
                            $common->endDbTrans($_SESSION["username"]);
                        }
                    } else {
                        if ($type == "withdraw" && $common->beginDbTrans($_SESSION["username"])) {
                            $Market->withdrawCustomItem($_SESSION["username"], Decode($_POST["char"]), $_POST["item"], $_POST["amount"]);
                            $common->endDbTrans($_SESSION["username"]);
                        }
                    }
                } else {
                    message("notice", lang("global_module_13", true));
                }
            }
            $BankData = $Market->getBankData($_SESSION["username"]);
            $token = time();
            $_SESSION["token"] = $token;
            echo "\r\n    <div class=\"table-responsive rankings-table\">\r\n        <table class=\"table table-hover text-center\">\r\n            <tr>\r\n                <th class=\"headerRow\">" . lang("webbank_txt_2", true) . "</th>\r\n                <th class=\"headerRow\">" . lang("webbank_txt_3", true) . "</th>\r\n            </tr>";
            if (mconfig("zen")) {
                echo "\r\n            <tr>\r\n                <th>" . lang("currency_zen", true) . "</th>\r\n                <td>" . number_format($BankData["zen"]) . "</td>\r\n            </tr>";
            }
            if (mconfig("job")) {
                echo "\r\n            <tr>\r\n                <th>" . lang("currency_bless", true) . "</th>\r\n                <td>" . number_format($BankData["bless"]) . "</td>\r\n            </tr>";
            }
            if (mconfig("jos")) {
                echo "\r\n            <tr>\r\n                <th>" . lang("currency_soul", true) . "</th>\r\n                <td>" . number_format($BankData["soul"]) . "</td>\r\n            </tr>";
            }
            if (mconfig("jol")) {
                echo "\r\n            <tr>\r\n                <th>" . lang("currency_life", true) . "</th>\r\n                <td>" . number_format($BankData["life"]) . "</td>\r\n            </tr>";
            }
            if (mconfig("joch")) {
                echo "\r\n            <tr>\r\n                <th>" . lang("currency_chaos", true) . "</th>\r\n                <td>" . number_format($BankData["chaos"]) . "</td>\r\n            </tr>";
            }
            if (mconfig("joh")) {
                echo "\r\n            <tr>\r\n                <th>" . lang("currency_harmony", true) . "</th>\r\n                <td>" . number_format($BankData["harmony"]) . "</td>\r\n            </tr>";
            }
            if (mconfig("joc")) {
                echo "\r\n            <tr>\r\n                <th>" . lang("currency_creation", true) . "</th>\r\n                <td>" . number_format($BankData["creation"]) . "</td>\r\n            </tr>";
            }
            if (mconfig("jog")) {
                echo "\r\n            <tr>\r\n                <th>" . lang("currency_guardian", true) . "</th>\r\n                <td>" . number_format($BankData["guardian"]) . "</td>\r\n            </tr>";
            }
            $customitems = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_WEB_BANK_CUSTOM");
            if (is_array($customitems)) {
                foreach ($customitems as $thisItem) {
                    $dbName = str_replace(" ", "_", $thisItem["name"]);
                    $customItemAmount = $dB->query_fetch_single("SELECT " . $dbName . " FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$_SESSION["username"]]);
                    echo "\r\n        <tr>\r\n            <th>" . $thisItem["name"] . "</th>\r\n            <td>" . number_format($customItemAmount[$dbName]) . "</td>\r\n        </tr>";
                }
            }
            echo "\r\n        </table>\r\n    </div>";
            if (!$common->accountOnline($_SESSION["username"])) {
                echo "\r\n    <div class=\"row\">";
                if (mconfig("job") || mconfig("jos") || mconfig("jol") || mconfig("joch") || mconfig("joh") || mconfig("joc") || mconfig("jog")) {
                    $allJewels = $Market->findAllJewels($_SESSION["username"]);
                    echo "\r\n        <div class=\"col-xs-12 col-md-6 col-center\">\r\n            <div class=\"col-xs-12 webbank-section\">\r\n                <div class=\"webbank-section-title\">" . lang("webbank_txt_4", true) . "</div>\r\n            </div>\r\n            <form action=\"\" method=\"post\">\r\n                <div class=\"form-group\">\r\n                    <label>" . lang("webbank_txt_5", true) . "</label>\r\n                    <select name=\"type\" class=\"form-control\" onchange=\"switchJewelSelect(this.value);\">\r\n                        <option value=\"insert\">" . lang("webbank_txt_6", true) . "</option>\r\n                        <option value=\"withdraw\">" . lang("webbank_txt_7", true) . "</option>\r\n                    </select>\r\n                </div>\r\n                <div class=\"form-group\">\r\n                    <label>" . lang("webbank_txt_8", true) . "</label>\r\n                    <select id=\"jewel-insert\" name=\"jewel\" class=\"form-control\">";
                    if (mconfig("job")) {
                        echo "<option value=\"bless\">" . lang("currency_bless", true) . " (" . number_format($allJewels["bless"]["count"]) . "x)</option>";
                    }
                    if (mconfig("jos")) {
                        echo "<option value=\"soul\">" . lang("currency_soul", true) . " (" . number_format($allJewels["soul"]["count"]) . "x)</option>";
                    }
                    if (mconfig("jol")) {
                        echo "<option value=\"life\">" . lang("currency_life", true) . " (" . number_format($allJewels["life"]["count"]) . "x)</option>";
                    }
                    if (mconfig("joch")) {
                        echo "<option value=\"chaos\">" . lang("currency_chaos", true) . " (" . number_format($allJewels["chaos"]["count"]) . "x)</option>";
                    }
                    if (mconfig("joh")) {
                        echo "<option value=\"harmony\">" . lang("currency_harmony", true) . " (" . number_format($allJewels["harmony"]["count"]) . "x)</option>";
                    }
                    if (mconfig("joc")) {
                        echo "<option value=\"creation\">" . lang("currency_creation", true) . " (" . number_format($allJewels["creation"]["count"]) . "x)</option>";
                    }
                    if (mconfig("jog")) {
                        echo "<option value=\"guardian\">" . lang("currency_guardian", true) . " (" . number_format($allJewels["guardian"]["count"]) . "x)</option>";
                    }
                    echo "\r\n                    </select>\r\n                    <select id=\"jewel-withdraw\" name=\"jewel\" class=\"form-control\" style=\"display: none;\" disabled=\"disabled\">";
                    if (mconfig("job")) {
                        echo "<option value=\"bless\">" . lang("currency_bless", true) . " (" . number_format($BankData["bless"]) . "x)</option>";
                    }
                    if (mconfig("jos")) {
                        echo "<option value=\"soul\">" . lang("currency_soul", true) . " (" . number_format($BankData["soul"]) . "x)</option>";
                    }
                    if (mconfig("jol")) {
                        echo "<option value=\"life\">" . lang("currency_life", true) . " (" . number_format($BankData["life"]) . "x)</option>";
                    }
                    if (mconfig("joch")) {
                        echo "<option value=\"chaos\">" . lang("currency_chaos", true) . " (" . number_format($BankData["chaos"]) . "x)</option>";
                    }
                    if (mconfig("joh")) {
                        echo "<option value=\"harmony\">" . lang("currency_harmony", true) . " (" . number_format($BankData["harmony"]) . "x)</option>";
                    }
                    if (mconfig("joc")) {
                        echo "<option value=\"creation\">" . lang("currency_creation", true) . " (" . number_format($BankData["creation"]) . "x)</option>";
                    }
                    if (mconfig("jog")) {
                        echo "<option value=\"guardian\">" . lang("currency_guardian", true) . " (" . number_format($BankData["guardian"]) . "x)</option>";
                    }
                    echo "\r\n                    </select>\r\n                </div>\r\n                <div class=\"form-group\">\r\n                    <label>" . lang("webbank_txt_9", true) . "</label>\r\n                    <input type=\"text\" name=\"amount\" class=\"form-control\">\r\n                </div>\r\n                <span class=\"help-block\" id=\"helpBlock\">" . lang("webbank_txt_11", true) . "</span>\r\n                <div class=\"form-group\">\r\n                    <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                    <input type=\"submit\" name=\"submit_jewel\" value=\"" . lang("webbank_txt_10", true) . "\" class=\"btn btn-primary full-width-btn\">\r\n                </div>\r\n            </form>\r\n        </div>";
                }
                if (mconfig("zen")) {
                    $Character = new Character();
                    $AccountCharacters = $Character->AccountCharacter($_SESSION["username"]);
                    echo "\r\n        <div class=\"col-xs-12 col-md-6 col-center\">\r\n            <div class=\"col-xs-12 webbank-section\">\r\n                <div class=\"webbank-section-title\">" . lang("webbank_txt_12", true) . "</div>\r\n            </div>";
                    if (is_array($AccountCharacters)) {
                        $opt_char = "";
                        foreach ($AccountCharacters as $thisCharacter) {
                            $characterData = $Character->CharacterData($thisCharacter);
                            $opt_char .= "<option value=\"" . Encode($characterData["Name"]) . "\">" . $characterData["Name"] . " (" . number_format($characterData["Money"]) . " " . lang("currency_zen", true) . ")</option>";
                        }
                        echo "\r\n            <form action=\"\" method=\"post\">\r\n                <div class=\"form-group\">\r\n                    <label>" . lang("webbank_txt_5", true) . "</label>\r\n                    <select name=\"type\" class=\"form-control\">\r\n                        <option value=\"insert\">" . lang("webbank_txt_6", true) . "</option>\r\n                        <option value=\"withdraw\">" . lang("webbank_txt_7", true) . "</option>\r\n                    </select>\r\n                </div>\r\n                <div class=\"form-group\">\r\n                    <label>" . lang("webbank_txt_13", true) . "</label>\r\n                    <select name=\"char\" class=\"form-control\">\r\n                        " . $opt_char . "\r\n                    </select>\r\n                </div>\r\n                <div class=\"form-group\">\r\n                    <label>" . lang("webbank_txt_9", true) . "</label>\r\n                    <input type=\"text\" name=\"amount\" class=\"form-control\">\r\n                </div>\r\n                <span class=\"help-block\" id=\"helpBlock\">" . lang("webbank_txt_14", true) . "</span>\r\n                <div class=\"form-group\">\r\n                    <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                    <input type=\"submit\" name=\"submit_zen\" value=\"" . lang("webbank_txt_10", true) . "\" class=\"btn btn-primary full-width-btn\">\r\n                </div>\r\n            </form>";
                    } else {
                        message("error", lang("error_46", true));
                    }
                    echo "\r\n        </div>";
                }
                echo "\r\n    </div>";
                $Character = new Character();
                $AccountCharacters = $Character->AccountCharacter($_SESSION["username"]);
                if (is_array($AccountCharacters)) {
                    $opt_char = "";
                    foreach ($AccountCharacters as $thisCharacter) {
                        $characterData = $Character->CharacterData($thisCharacter);
                        $opt_char .= "<option value=\"" . Encode($characterData["Name"]) . "\">" . $characterData["Name"] . "</option>";
                    }
                }
                $customitems = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_WEB_BANK_CUSTOM");
                if (is_array($customitems)) {
                    echo "\r\n    <div class=\"row\">\r\n        <div class=\"col-xs-12 col-md-6 col-center\">\r\n            <div class=\"col-xs-12 webbank-section\">\r\n                <div class=\"webbank-section-title\">" . lang("webbank_txt_15", true) . "</div>\r\n            </div>\r\n            <form action=\"\" method=\"post\">\r\n                <div class=\"form-group\">\r\n                    <label>" . lang("webbank_txt_5", true) . "</label>\r\n                    <select name=\"type\" class=\"form-control\">\r\n                        <option value=\"insert\">" . lang("webbank_txt_6", true) . "</option>\r\n                        <option value=\"withdraw\">" . lang("webbank_txt_7", true) . "</option>\r\n                    </select>\r\n                </div>\r\n                <div class=\"form-group\">\r\n                    <label>" . lang("webbank_txt_13", true) . "</label>\r\n                    <select name=\"char\" class=\"form-control\">\r\n                        " . $opt_char . "\r\n                    </select>\r\n                </div>\r\n                <div class=\"form-group\">\r\n                    <label>" . lang("webbank_txt_16", true) . "</label>\r\n                    <select name=\"item\" class=\"form-control\">";
                    foreach ($customitems as $thisItem) {
                        $count = $Market->findAllCustomItems($_SESSION["username"], "TEST_DW", $thisItem["hex"], $thisItem["type"]);
                        echo "<option value=\"" . str_replace(" ", "_", $thisItem["name"]) . "\">" . $thisItem["name"] . " (" . number_format($count) . "x)</option>";
                    }
                    echo "\r\n                    </select>\r\n                </div>\r\n                <div class=\"form-group\">\r\n                    <label>" . lang("webbank_txt_9", true) . "</label>\r\n                    <input type=\"text\" name=\"amount\" class=\"form-control\">\r\n                </div>\r\n                <span class=\"help-block\" id=\"helpBlock\">";
                    foreach ($customitems as $thisItem) {
                        if ($thisItem["type"] == 1) {
                            $customPlate = "<b>" . lang("webbank_txt_17", true) . "</b>";
                        } else {
                            $customPlate = "<b>" . lang("webbank_txt_18", true) . "</b>";
                        }
                        echo sprintf(lang("webbank_txt_19", true), number_format($thisItem["limit"]), $thisItem["name"], $thisItem["name"], $customPlate) . "<br>";
                    }
                    echo "\r\n                </span>\r\n                <div class=\"form-group\">\r\n                    <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                    <input type=\"submit\" name=\"submit_item\" value=\"" . lang("webbank_txt_10", true) . "\" class=\"btn btn-primary full-width-btn\">\r\n                </div>\r\n            </form>\r\n        </div>\r\n    </div>";
                }
            } else {
                message("error", lang("error_14", true));
            }
        } else {
            message("error", lang("error_47", true));
        }
    } else {
        echo "\r\n<div class=\"sub-page-title\">\r\n    <div id=\"title\">\r\n        <h1>" . lang("module_titles_txt_3", true) . "<p></p><span></span></h1>\r\n    </div>\r\n</div>\r\n\r\n  <div class=\"container_2 account\" align=\"center\">\r\n    <div class=\"cont-image\">\r\n      <div class=\"container_3 account_sub_header\">\r\n        <div class=\"grad\">\r\n          <div class=\"page-title\"><p>" . lang("myaccount_txt_60", true) . "</p></div>\r\n          <a href=\"" . __BASE_URL__ . "usercp\">" . lang("global_module_1", true) . "</a>\r\n        </div>\r\n      </div>\r\n      <div class=\"page-desc-holder\">\r\n        " . lang("webbank_txt_1", true) . "\r\n      </div>";
        if (mconfig("active")) {
            $General = new xGeneral();
            $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("webbank");
            $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("webbank");
            $Market = new Market();
            if (check_value($_POST["submit_jewel"])) {
                if ($_SESSION["token"] == $_POST["token"]) {
                    $type = xss_clean(htmlspecialchars($_POST["type"]));
                    if ($type == "insert") {
                        $Market->insertJewels($_SESSION["username"], $_POST["jewel"], $_POST["amount"]);
                    } else {
                        if ($type == "withdraw") {
                            if (140 <= config("server_files_season", true)) {
                                $Market->withdrawJewelsS14($_SESSION["username"], $_POST["jewel"], $_POST["amount"]);
                            } else {
                                $Market->withdrawJewels($_SESSION["username"], $_POST["jewel"], $_POST["amount"]);
                            }
                        }
                    }
                } else {
                    message("notice", lang("global_module_13", true));
                }
            }
            if (check_value($_POST["submit_zen"])) {
                if ($_SESSION["token"] == $_POST["token"]) {
                    $type = xss_clean(htmlspecialchars($_POST["type"]));
                    if ($type == "insert") {
                        $Market->insertZen($_SESSION["username"], $_POST["char"], $_POST["amount"]);
                    } else {
                        if ($type == "withdraw") {
                            $Market->withdrawZen($_SESSION["username"], $_POST["char"], $_POST["amount"]);
                        }
                    }
                } else {
                    message("notice", lang("global_module_13", true));
                }
            }
            if (check_value($_POST["submit_item"])) {
                if ($_SESSION["token"] == $_POST["token"]) {
                    $type = xss_clean(htmlspecialchars($_POST["type"]));
                    if ($type == "insert") {
                        $Market->insertCustomItem($_SESSION["username"], Decode($_POST["char"]), $_POST["item"], $_POST["amount"]);
                    } else {
                        if ($type == "withdraw") {
                            $Market->withdrawCustomItem($_SESSION["username"], Decode($_POST["char"]), $_POST["item"], $_POST["amount"]);
                        }
                    }
                } else {
                    message("notice", lang("global_module_13", true));
                }
            }
            $BankData = $Market->getBankData($_SESSION["username"]);
            $token = time();
            $_SESSION["token"] = $token;
            echo "\r\n    <div class=\"container_3 account-wide\" align=\"center\">\r\n        <table class=\"general-table-ui\" cellspacing=\"0\">\r\n            <tr>\r\n                <th>" . lang("webbank_txt_2", true) . "</th>\r\n                <th>" . lang("webbank_txt_3", true) . "</th>\r\n            </tr>";
            if (mconfig("zen")) {
                echo "\r\n            <tr>\r\n                <th>" . lang("currency_zen", true) . "</th>\r\n                <td>" . number_format($BankData["zen"]) . "</td>\r\n            </tr>";
            }
            if (mconfig("job")) {
                echo "\r\n            <tr>\r\n                <th>" . lang("currency_bless", true) . "</th>\r\n                <td>" . number_format($BankData["bless"]) . "</td>\r\n            </tr>";
            }
            if (mconfig("jos")) {
                echo "\r\n            <tr>\r\n                <th>" . lang("currency_soul", true) . "</th>\r\n                <td>" . number_format($BankData["soul"]) . "</td>\r\n            </tr>";
            }
            if (mconfig("jol")) {
                echo "\r\n            <tr>\r\n                <th>" . lang("currency_life", true) . "</th>\r\n                <td>" . number_format($BankData["life"]) . "</td>\r\n            </tr>";
            }
            if (mconfig("joch")) {
                echo "\r\n            <tr>\r\n                <th>" . lang("currency_chaos", true) . "</th>\r\n                <td>" . number_format($BankData["chaos"]) . "</td>\r\n            </tr>";
            }
            if (mconfig("joh")) {
                echo "\r\n            <tr>\r\n                <th>" . lang("currency_harmony", true) . "</th>\r\n                <td>" . number_format($BankData["harmony"]) . "</td>\r\n            </tr>";
            }
            if (mconfig("joc")) {
                echo "\r\n            <tr>\r\n                <th>" . lang("currency_creation", true) . "</th>\r\n                <td>" . number_format($BankData["creation"]) . "</td>\r\n            </tr>";
            }
            if (mconfig("jog")) {
                echo "\r\n            <tr>\r\n                <th>" . lang("currency_guardian", true) . "</th>\r\n                <td>" . number_format($BankData["guardian"]) . "</td>\r\n            </tr>";
            }
            $customitems = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_WEB_BANK_CUSTOM");
            if (is_array($customitems)) {
                foreach ($customitems as $thisItem) {
                    $dbName = str_replace(" ", "_", $thisItem["name"]);
                    $customItemAmount = $dB->query_fetch_single("SELECT " . $dbName . " FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$_SESSION["username"]]);
                    echo "\r\n        <tr>\r\n            <th>" . $thisItem["name"] . "</th>\r\n            <td>" . number_format($customItemAmount[$dbName]) . "</td>\r\n        </tr>";
                }
            }
            echo "\r\n        </table>\r\n      </div>";
            if (!$common->accountOnline($_SESSION["username"])) {
                if (mconfig("job") || mconfig("jos") || mconfig("jol") || mconfig("joch") || mconfig("joh") || mconfig("joc") || mconfig("jog")) {
                    $allJewels = $Market->findAllJewels($_SESSION["username"]);
                    echo "\r\n        <br /><br /><br />\r\n        <div class=\"container_3 account_sub_header\">\r\n          <div class=\"grad\">\r\n            <div class=\"page-title\">" . lang("webbank_txt_4", true) . "</div>\r\n          </div>\r\n        </div>\r\n        <div class=\"container_3 account-wide\" align=\"center\">\r\n          <form action=\"\" method=\"post\">\r\n            <div style=\"padding-top: 20px;\">\r\n              <div class=\"row\">\r\n                <label for=\"type\">" . lang("webbank_txt_5", true) . "</label>\r\n                <select name=\"type\" styled=\"true\" id=\"select-style-2\" style=\"display: none;\">\r\n                  <option value=\"insert\">" . lang("webbank_txt_6", true) . "</option>\r\n                  <option value=\"withdraw\">" . lang("webbank_txt_7", true) . "</option>\r\n                </select>\r\n              </div>\r\n              <div class=\"row\">\r\n                <label for=\"jewel\">" . lang("webbank_txt_8", true) . "</label>\r\n                <select name=\"jewel\" styled=\"true\" id=\"select-style-2\" style=\"display: none;\">";
                    if (mconfig("job")) {
                        echo "<option value=\"bless\">" . lang("currency_bless", true) . " (" . number_format($allJewels["bless"]["count"]) . "x)</option>";
                    }
                    if (mconfig("jos")) {
                        echo "<option value=\"soul\">" . lang("currency_soul", true) . " (" . number_format($allJewels["soul"]["count"]) . "x)</option>";
                    }
                    if (mconfig("jol")) {
                        echo "<option value=\"life\">" . lang("currency_life", true) . " (" . number_format($allJewels["life"]["count"]) . "x)</option>";
                    }
                    if (mconfig("joch")) {
                        echo "<option value=\"chaos\">" . lang("currency_chaos", true) . " (" . number_format($allJewels["chaos"]["count"]) . "x)</option>";
                    }
                    if (mconfig("joh")) {
                        echo "<option value=\"harmony\">" . lang("currency_harmony", true) . " (" . number_format($allJewels["harmony"]["count"]) . "x)</option>";
                    }
                    if (mconfig("joc")) {
                        echo "<option value=\"creation\">" . lang("currency_creation", true) . " (" . number_format($allJewels["creation"]["count"]) . "x)</option>";
                    }
                    if (mconfig("jog")) {
                        echo "<option value=\"guardian\">" . lang("currency_guardian", true) . " (" . number_format($allJewels["guardian"]["count"]) . "x)</option>";
                    }
                    echo "\r\n                </select>\r\n              </div>\r\n              <div class=\"row\">\r\n                <label for=\"amount\">" . lang("webbank_txt_9", true) . "</label>\r\n                <input type=\"text\" name=\"amount\">\r\n              </div>\r\n              <div class=\"row\" align=\"right\">\r\n                <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                <input type=\"submit\" name=\"submit_jewel\" value=\"" . lang("webbank_txt_10", true) . "\">\r\n              </div>\r\n              <div class=\"clear\"></div>\r\n              <div class=\"description-small\">\r\n                " . lang("webbank_txt_11", true) . "\r\n            \t</div>\r\n            </div>\r\n          </form>\r\n        </div>";
                }
                if (mconfig("zen")) {
                    $Character = new Character();
                    $AccountCharacters = $Character->AccountCharacter($_SESSION["username"]);
                    echo "\r\n          <br /><br /><br />\r\n          <div class=\"container_3 account_sub_header\">\r\n            <div class=\"grad\">\r\n              <div class=\"page-title\">" . lang("webbank_txt_12", true) . "</div>\r\n            </div>\r\n          </div>";
                    if (is_array($AccountCharacters)) {
                        $opt_char = "";
                        foreach ($AccountCharacters as $thisCharacter) {
                            $characterData = $Character->CharacterData($thisCharacter);
                            $opt_char .= "<option value=\"" . Encode($characterData["Name"]) . "\">" . $characterData["Name"] . " (" . number_format($characterData["Money"]) . " " . lang("currency_zen", true) . ")</option>";
                        }
                        echo "\r\n            <div class=\"container_3 account-wide\" align=\"center\">\r\n              <form action=\"\" method=\"post\">\r\n                <div style=\"padding-top: 20px;\">\r\n                  <div class=\"row\">\r\n                    <label for=\"type\">" . lang("webbank_txt_5", true) . "</label>\r\n                    <select name=\"type\" styled=\"true\" id=\"select-style-2\" style=\"display: none;\">\r\n                      <option value=\"insert\">" . lang("webbank_txt_6", true) . "</option>\r\n                      <option value=\"withdraw\">" . lang("webbank_txt_7", true) . "</option>\r\n                    </select>\r\n                  </div>\r\n                  <div class=\"row\">\r\n                    <label for=\"char\">" . lang("webbank_txt_13", true) . "</label>\r\n                    <select name=\"char\" styled=\"true\" id=\"select-style-2\" style=\"display: none;\">\r\n                      " . $opt_char . "\r\n                    </select>\r\n                  </div>\r\n                  <div class=\"row\">\r\n                    <label for=\"amount\">" . lang("webbank_txt_9", true) . "</label>\r\n                    <input type=\"text\" name=\"amount\">\r\n                  </div>\r\n                  <div class=\"row\" align=\"right\">\r\n                    <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                    <input type=\"submit\" name=\"submit_zen\" value=\"" . lang("webbank_txt_10", true) . "\">\r\n                  </div>\r\n                  <div class=\"clear\"></div>\r\n                  <div class=\"description-small\">\r\n                    " . lang("webbank_txt_14", true) . "\r\n                \t</div>\r\n                </div>\r\n              </form>\r\n            </div>";
                    } else {
                        message("error", lang("error_46", true));
                    }
                }
                $Character = new Character();
                $AccountCharacters = $Character->AccountCharacter($_SESSION["username"]);
                if (is_array($AccountCharacters)) {
                    $opt_char = "";
                    foreach ($AccountCharacters as $thisCharacter) {
                        $characterData = $Character->CharacterData($thisCharacter);
                        $opt_char .= "<option value=\"" . Encode($characterData["Name"]) . "\">" . $characterData["Name"] . "</option>";
                    }
                }
                $customitems = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_WEB_BANK_CUSTOM");
                if (is_array($customitems)) {
                    echo "\r\n            <br /><br /><br />\r\n            <div class=\"container_3 account_sub_header\">\r\n              <div class=\"grad\">\r\n                <div class=\"page-title\">" . lang("webbank_txt_15", true) . "</div>\r\n              </div>\r\n            </div>\r\n            <div class=\"container_3 account-wide\" align=\"center\">\r\n              <form action=\"\" method=\"post\">\r\n                <div style=\"padding-top: 20px;\">\r\n                  <div class=\"row\">\r\n                    <label for=\"type\">" . lang("webbank_txt_5", true) . "</label>\r\n                    <select name=\"type\" styled=\"true\" id=\"select-style-2\" style=\"display: none;\">\r\n                      <option value=\"insert\">" . lang("webbank_txt_6", true) . "</option>\r\n                      <option value=\"withdraw\">" . lang("webbank_txt_7", true) . "</option>\r\n                    </select>\r\n                  </div>\r\n                  <div class=\"row\">\r\n                    <label for=\"char\">" . lang("webbank_txt_13", true) . "</label>\r\n                    <select name=\"char\" styled=\"true\" id=\"select-style-2\" style=\"display: none;\">\r\n                      " . $opt_char . "\r\n                    </select>\r\n                  </div>\r\n                  <div class=\"row\">\r\n                    <label for=\"item\">" . lang("webbank_txt_16", true) . "</label>\r\n                    <select name=\"item\" styled=\"true\" id=\"select-style-2\" style=\"display: none;\">";
                    foreach ($customitems as $thisItem) {
                        $count = $Market->findAllCustomItems($_SESSION["username"], "TEST_DW", $thisItem["hex"], $thisItem["type"]);
                        echo "<option value=\"" . str_replace(" ", "_", $thisItem["name"]) . "\">" . $thisItem["name"] . " (" . number_format($count) . "x)</option>";
                    }
                    echo "\r\n                    </select>\r\n                  </div>\r\n                  <div class=\"row\">\r\n                    <label for=\"amount\">" . lang("webbank_txt_9", true) . "</label>\r\n                    <input type=\"text\" name=\"amount\">\r\n                  </div>\r\n                  <div class=\"row\" align=\"right\">\r\n                    <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                    <input type=\"submit\" name=\"submit_item\" value=\"" . lang("webbank_txt_10", true) . "\">\r\n                  </div>\r\n                  <div class=\"clear\"></div>\r\n                  <div class=\"description-small\">";
                    foreach ($customitems as $thisItem) {
                        if ($thisItem["type"] == 1) {
                            $customPlate = "<b>" . lang("webbank_txt_17", true) . "</b>";
                        } else {
                            $customPlate = "<b>" . lang("webbank_txt_18", true) . "</b>";
                        }
                        echo sprintf(lang("webbank_txt_19", true), number_format($thisItem["limit"]), $thisItem["name"], $thisItem["name"], $customPlate) . "<br>";
                    }
                    echo "\r\n                    </div>\r\n                </div>\r\n              </form>\r\n            </div>";
                }
            } else {
                message("error", lang("error_14", true));
            }
        } else {
            message("error", lang("error_47", true));
        }
        echo "\r\n\t</div>\r\n</div>";
    }
}

?>