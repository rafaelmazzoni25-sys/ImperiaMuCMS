<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

if (!isLoggedIn()) {
    redirect(1, "login");
} else {
    $General = new xGeneral();
    if ($General->ftanHCIfo_canUse_j8GsnawwvJ_Module("transferaccount-relic")) {
        echo "\r\n<div class=\"sub-page-title\">\r\n    <div id=\"title\">\r\n        <h1>" . lang("module_titles_txt_3", true) . "<p></p><span></span></h1>\r\n    </div>\r\n</div>\r\n<div class=\"container_2 account\" align=\"center\">\r\n    <div class=\"cont-image\">\r\n        <div class=\"container_3 account_sub_header\">\r\n            <div class=\"grad\">\r\n                <div class=\"page-title\">" . lang("transferaccount_txt_1", true) . "</div>\r\n                <a href=\"" . __BASE_URL__ . "usercp\">" . lang("global_module_1", true) . "</a>\r\n            </div>\r\n        </div>\r\n        <div class=\"page-desc-holder\">\r\n        \r\n        </div>";
        if (mconfig("active")) {
            if (canAccessModule($_SESSION["username"], "transferaccount", "block")) {
                $fp = fopen(__ROOT_DIR__ . "__logs/transferaccount_" . date("Y-m-d", time()) . ".log", "ab");
                fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] START (TRANSFER) ==================================================================" . PHP_EOL);
                $checkDate = date("Y-m-d H:i:s", time() - 86400);
                $nextStep = xss_clean(Decode($_POST["step"]));
                $showTerms = false;
                $showLogin = false;
                $showChangeName = false;
                $showTransfer = false;
                $dB3 = new dB($config["SQL2_DB_HOST"], $config["SQL2_DB_PORT"], $config["SQL2_DB_NAME"], $config["SQL2_DB_USER"], $config["SQL2_DB_PASS"], $config["SQL_PDO_DRIVER"]);
                if ($dB3->dead) {
                    if (config("error_reporting", true)) {
                        throw new Exception($dB3->error);
                    }
                    throw new Exception("Connection to database server failed. [03]");
                }
                if ($config["SQL2_USE_2_DB"]) {
                    $dB4 = new dB($config["SQL2_DB_HOST"], $config["SQL2_DB_PORT"], $config["SQL2_DB_2_NAME"], $config["SQL2_DB_USER"], $config["SQL2_DB_PASS"], $config["SQL_PDO_DRIVER"]);
                    if ($dB4->dead) {
                        if (config("error_reporting", true)) {
                            throw new Exception($dB4->error);
                        }
                        throw new Exception("Connection to database server failed. [03]");
                    }
                }
                if ($nextStep == "" || $nextStep == NULL) {
                    fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Show terms" . PHP_EOL);
                    $showTerms = true;
                } else {
                    if ($nextStep == "login") {
                        if ($_SESSION["token"] == $_POST["token"]) {
                            fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Show login" . PHP_EOL);
                            $showLogin = true;
                        } else {
                            fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Show login invalid token" . PHP_EOL);
                            message("notice", lang("global_module_13", true));
                        }
                    } else {
                        if ($nextStep == "char") {
                            if ($_SESSION["token"] == $_POST["token"]) {
                                fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Show char" . PHP_EOL);
                                $username = xss_clean($_POST["username"]);
                                $password = xss_clean($_POST["password"]);
                                fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Username: " . $username . " Password: " . $password . " " . PHP_EOL);
                                if (check_value($username) && check_value($password)) {
                                    if ($config["SQL2_USE_2_DB"]) {
                                        $getUsername = $dB4->query_fetch_single("SELECT memb___id, mail_addr FROM MEMB_INFO WHERE memb___id = ? AND bloc_code = ?", [$username, 0]);
                                    } else {
                                        $getUsername = $dB3->query_fetch_single("SELECT memb___id, mail_addr FROM MEMB_INFO WHERE memb___id = ? AND bloc_code = ?", [$username, 0]);
                                    }
                                    $username = $getUsername["memb___id"];
                                    $oldEmail = $getUsername["mail_addr"];
                                    if ($config["SQL2_ENABLE_MD5"] == "1") {
                                        if ($config["SQL2_USE_2_DB"]) {
                                            $query = $dB4->query_fetch_single("SELECT * FROM " . _TBL_MI_ . " WHERE " . _CLMN_USERNM_ . " = ? AND " . _CLMN_PASSWD_ . " = [dbo].[fn_md5](?, ?)", [$username, $password, $username]);
                                            $md5_password = $dB4->query_fetch_single("SELECT [dbo].[fn_md5](?, ?) AS password FROM MEMB_INFO", [$password, $username]);
                                        } else {
                                            $query = $dB3->query_fetch_single("SELECT * FROM " . _TBL_MI_ . " WHERE " . _CLMN_USERNM_ . " = ? AND " . _CLMN_PASSWD_ . " = [dbo].[fn_md5](?, ?)", [$username, $password, $username]);
                                            $md5_password = $dB3->query_fetch_single("SELECT [dbo].[fn_md5](?, ?) AS password FROM MEMB_INFO", [$password, $username]);
                                        }
                                        $md5_password = $md5_password["password"];
                                    } else {
                                        if ($config["SQL2_ENABLE_MD5"] == "2") {
                                            if ($config["SQL2_USE_2_DB"]) {
                                                $query = $dB4->query_fetch_single("SELECT * FROM " . _TBL_MI_ . " WHERE " . _CLMN_USERNM_ . " = ? AND " . _CLMN_PASSWD_ . " = ?", [$username, md5($password)]);
                                            } else {
                                                $query = $dB3->query_fetch_single("SELECT * FROM " . _TBL_MI_ . " WHERE " . _CLMN_USERNM_ . " = ? AND " . _CLMN_PASSWD_ . " = ?", [$username, md5($password)]);
                                            }
                                            $md5_password = md5($password);
                                        } else {
                                            if ($config["SQL2_USE_2_DB"]) {
                                                $query = $dB4->query_fetch_single("SELECT * FROM " . _TBL_MI_ . " WHERE " . _CLMN_USERNM_ . " = ?  AND " . _CLMN_PASSWD_ . " = ?", [$username, $password]);
                                            } else {
                                                $query = $dB3->query_fetch_single("SELECT * FROM " . _TBL_MI_ . " WHERE " . _CLMN_USERNM_ . " = ?  AND " . _CLMN_PASSWD_ . " = ?", [$username, $password]);
                                            }
                                            $md5_password = $password;
                                        }
                                    }
                                    if (is_array($query)) {
                                        if ($md5_password == $query["memb__pwd"]) {
                                            fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Account and password verified" . PHP_EOL);
                                            if ($config["SQL2_USE_2_DB"]) {
                                                $checkOnline = $dB4->query_fetch_single("SELECT ConnectStat FROM MEMB_STAT WHERE memb___id = ?", [$username]);
                                            } else {
                                                $checkOnline = $dB3->query_fetch_single("SELECT ConnectStat FROM MEMB_STAT WHERE memb___id = ?", [$username]);
                                            }
                                            if ($checkOnline["ConnectStat"] != "0" && $checkOnline["ConnectStat"] != NULL) {
                                                message("error", lang("transferaccount_txt_49", true));
                                                $showLogin = true;
                                            }
                                            if ($config["SQL2_USE_2_DB"]) {
                                                $checkBanned = $dB4->query_fetch_single("SELECT bloc_code FROM MEMB_INFO WHERE memb___id = ?", [$username]);
                                            } else {
                                                $checkBanned = $dB3->query_fetch_single("SELECT bloc_code FROM MEMB_INFO WHERE memb___id = ?", [$username]);
                                            }
                                            if ($checkBanned["bloc_code"] != "0") {
                                                message("error", lang("transferaccount_txt_50", true));
                                                $showLogin = true;
                                            }
                                            if (!$showLogin) {
                                                $oldCharacters = $dB3->query_fetch("SELECT Name FROM Character WHERE AccountId = ?", [$username]);
                                                $charIndex = 0;
                                                $needToChangeName = [];
                                                foreach ($oldCharacters as $thisOldChar) {
                                                    $checkName = $dB->query_fetch_single("SELECT Name FROM Character WHERE Name = ?", [$thisOldChar["Name"]]);
                                                    if ($checkName["Name"] == $thisOldChar["Name"]) {
                                                        $needToChangeName[$charIndex] = true;
                                                    } else {
                                                        $needToChangeName[$charIndex] = false;
                                                    }
                                                    $charIndex++;
                                                }
                                                $showChangeName = true;
                                            }
                                        } else {
                                            fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Invalid account or password 1 [" . $username . "]" . PHP_EOL);
                                            message("error", lang("error_1", true));
                                            $showLogin = true;
                                        }
                                    } else {
                                        fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Invalid account or password 2 [" . $username . "]" . PHP_EOL);
                                        message("error", lang("error_1", true));
                                        $showLogin = true;
                                    }
                                } else {
                                    fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Empty field [" . $username . "]" . PHP_EOL);
                                    message("error", lang("error_4", true));
                                    $showLogin = true;
                                }
                            } else {
                                fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Invalid token [" . $username . "]" . PHP_EOL);
                                message("notice", lang("global_module_13", true));
                            }
                        } else {
                            if ($nextStep == "transfer") {
                                $username = xss_clean(Decode($_POST[Encode("username")]));
                                $oldCharacters = $dB3->query_fetch("SELECT Name FROM Character WHERE AccountId = ?", [$username]);
                                $i = 1;
                                $charIndex = 0;
                                $usedNames = [];
                                foreach ($oldCharacters as $thisOldChar) {
                                    $newCharName = $_POST["oldChar" . $i];
                                    $oldCharacters[$charIndex]["Name"] = $newCharName;
                                    $checkName = $dB->query_fetch_single("SELECT Name FROM Character WHERE Name = ?", [$newCharName]);
                                    if ($checkName["Name"] == $newCharName) {
                                        $needToChangeName[$charIndex] = true;
                                        $showChangeName = true;
                                        message("error", sprintf(lang("transferaccount_txt_43", true), $newCharName));
                                    } else {
                                        if (in_array($newCharName, $usedNames)) {
                                            $needToChangeName[$charIndex] = true;
                                            $showChangeName = true;
                                            message("error", sprintf(lang("transferaccount_txt_43", true), $newCharName));
                                        } else {
                                            $needToChangeName[$charIndex] = false;
                                        }
                                    }
                                    $i++;
                                    $charIndex++;
                                    array_push($usedNames, $newCharName);
                                }
                                if (!$showChangeName) {
                                    $showTransfer = true;
                                }
                            }
                        }
                    }
                }
                $token = time();
                $_SESSION["token"] = $token;
                if ($showTerms) {
                    if (!$common->accountOnline($_SESSION["username"])) {
                        echo "\r\n                        <div class=\"container_3 terms-of-usage\" align=\"center\">\r\n                            <h1></h1>\r\n                            <script type=\"text/javascript\" src=\"https://code.jquery.com/jquery-latest.min.js\"></script>\r\n                            <script type=\"text/javascript\" src=\"" . __PATH_TEMPLATE__ . "js/jquery.tinyscrollbar.min.js\"></script>\r\n                            <script type=\"text/javascript\">\r\n                                \$(document).ready(function () {\r\n                                    \$('#terms-container').tinyscrollbar();\r\n                                });\r\n                            </script>\r\n                            <div id=\"terms-container\">\r\n                                <div class=\"scrollbar\">\r\n                                    <div class=\"track\">\r\n                                        <div class=\"thumb\"></div>\r\n                                    </div>\r\n                                </div>\r\n                                <div class=\"terms-shadow\"></div>\r\n                                <div class=\"viewport\">\r\n                                    <div class=\"overview\">\r\n                                        " . lang("transferaccount_txt_2", true) . "\r\n                                    </div>\r\n                                </div>\r\n                                <div class=\"clear\"></div>\r\n                            </div>\r\n                            <div style=\"height:20px;\"></div>\r\n                            <form method=\"post\" action=\"\">\r\n                                <table width=\"100%\" align=\"center\">\r\n                                    <tr>\r\n                                        <td align=\"center\">\r\n                                            <input type=\"submit\" class=\"agree\" id=\"terms\" value=\"" . lang("transferaccount_txt_3", true) . "\" style=\"margin:10px 0 0 0;\"/>\r\n                                            <input type=\"hidden\" name=\"step\" value=\"" . Encode("login") . "\" />\r\n                                            <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                                            <a class=\"dissagree\" href=\"index.php\">" . lang("transferaccount_txt_4", true) . "</a>\r\n                                        </td>\r\n                                    </tr>\r\n                                </table>\r\n                            </form>\r\n                        </div>";
                    } else {
                        message("error", lang("transferaccount_txt_49", true));
                    }
                }
                if ($showLogin) {
                    $checkCharVaultError = false;
                    $checkChars = $dB->query_fetch_single("SELECT TOP 1 Name FROM Character WHERE AccountID = ?", [$_SESSION["username"]]);
                    if (!empty($checkChars["Name"])) {
                        $checkCharVaultError = true;
                        message("error", lang("transferaccount_txt_47", true));
                    }
                    $checkVault = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT Items FROM warehouse WHERE AccountID = ?), 2) AS vault", [$username]);
                    if ($checkVault["vault"] != NULL) {
                        $i = 0;
                        while ($i < 240) {
                            $_item = substr($checkVault["vault"], __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                            if ($_item != __ITEM_EMPTY__) {
                                echo $_item;
                                $checkCharVaultError = true;
                                message("error", lang("transferaccount_txt_48", true));
                            } else {
                                $i++;
                            }
                        }
                    }
                    if (!$checkCharVaultError) {
                        echo "\r\n                        <div class=\"page-desc-holder\">" . lang("transferaccount_txt_20", true) . "</div>\r\n                        <div class=\"container_3\" align=\"center\">\r\n                            <form action=\"\" method=\"post\">\r\n                                <div class=\"row\">\r\n                                    <label for=\"username\">" . lang("transferaccount_txt_5", true) . "</label>\r\n                                    <input type=\"text\" name=\"username\" id=\"username\" tabindex=\"1\" maxlength=\"10\" autocomplete=\"off\" required=\"required\" />\r\n                                </div>\r\n                                <div class=\"row\">\r\n                                    <label for=\"password\">" . lang("transferaccount_txt_6", true) . "</label>\r\n                                    <input type=\"password\" name=\"password\" id=\"password\" tabindex=\"2\" maxlength=\"20\" autocomplete=\"off\" required=\"required\" />\r\n                                </div>\r\n                                <div class=\"seperator\"></div>\r\n                                <div class=\"row\" align=\"right\">\r\n                                    <input type=\"submit\" name=\"submit\" tabindex=\"3\" value=\"" . lang("transferaccount_txt_19", true) . "\" />\r\n                                    <input type=\"hidden\" name=\"step\" value=\"" . Encode("char") . "\"/>\r\n                                    <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                                </div>\r\n                            </form>\r\n                        </div>";
                    }
                }
                if ($showChangeName) {
                    echo "\r\n                        <div class=\"page-desc-holder\">" . lang("transferaccount_txt_51", true) . "</div>\r\n                        <div class=\"container_3\" align=\"center\">\r\n                            <form action=\"\" method=\"post\">";
                    $i = 0;
                    foreach ($oldCharacters as $thisOldChar) {
                        echo "\r\n                                <div class=\"row\">";
                        if ($needToChangeName[$i]) {
                            echo "\r\n                                    <label for=\"oldChar" . ($i + 1) . "\">" . sprintf(lang("transferaccount_txt_22", true), $i + 1, $thisOldChar["Name"]) . "</label>\r\n                                    <input type=\"text\" name=\"oldChar" . ($i + 1) . "\" id=\"oldChar" . ($i + 1) . "\" tabindex=\"" . ($i + 1) . "\" maxlength=\"10\" autocomplete=\"off\" required=\"required\" placeholder=\"Please choose another name\" />";
                        } else {
                            echo "\r\n                                    <label for=\"oldChar" . ($i + 1) . "\">" . sprintf(lang("transferaccount_txt_52", true), $i + 1) . "</label>\r\n                                    <input type=\"text\" name=\"oldChar" . ($i + 1) . "\" id=\"oldChar" . ($i + 1) . "\" value=\"" . $thisOldChar["Name"] . "\" tabindex=\"" . ($i + 1) . "\" maxlength=\"10\" autocomplete=\"off\" required=\"required\" readonly=\"readonly\" />";
                        }
                        echo "                                    \r\n                                </div>";
                        $i++;
                    }
                    echo "\r\n                                <div class=\"seperator\"></div>\r\n                                <div class=\"row\" align=\"right\">\r\n                                    <input type=\"submit\" name=\"submit\" tabindex=\"9\" value=\"" . lang("transferaccount_txt_19", true) . "\" />\r\n                                    <input type=\"hidden\" name=\"" . Encode("username") . "\" value=\"" . Encode($username) . "\">\r\n                                    <input type=\"hidden\" name=\"step\" value=\"" . Encode("transfer") . "\"/>\r\n                                    <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                                </div>\r\n                            </form>\r\n                        </div>";
                }
                if ($showTransfer) {
                    echo "OK - WE CAN TRANSFER";
                }
                fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] END (TRANSFER) ====================================================================" . PHP_EOL);
                fclose($fp);
            } else {
                canAccessModuleMsg($_SESSION["username"], "transferaccount", "block");
            }
        } else {
            message("error", lang("error_47", true));
        }
        echo "\r\n\t</div>\r\n</div>\r\n";
    }
}

?>