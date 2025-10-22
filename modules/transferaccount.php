<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */
$General = new xGeneral();
if ($General->ftanHCIfo_canUse_j8GsnawwvJ_Module("transferaccount")) {
    if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
        $breadcrumb = generateBreadcrumb();
        echo "\r\n<h3>\r\n    " . lang("transferaccount_txt_1", true) . "\r\n    " . $breadcrumb . "\r\n</h3>";
    } else {
        echo "\r\n<div class=\"sub-page-title\">\r\n<div id=\"title\"><h1>" . lang("transferaccount_txt_1", true) . "<p></p><span></span></h1></div>\r\n</div>\r\n<div class=\"container_2\" align=\"center\">";
    }
    $fp = fopen(__ROOT_DIR__ . "__logs/transferaccount_" . date("Y-m-d", time()) . ".log", "ab");
    fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] START (TRANSFER) ==================================================================" . PHP_EOL);
    if (mconfig("active")) {
        $checkDate = date("Y-m-d H:i:s", time() - 86400);
        $step = xss_clean(Decode($_POST["step"]));
        $showTerms = false;
        $showLogin = false;
        $showResendEmail = false;
        $showCharacter = false;
        $showVerification = false;
        $showCharacterAccount = false;
        $showCharacterEmail = false;
        $showCharacter1 = false;
        $showCharacter2 = false;
        $showCharacter3 = false;
        $showCharacter4 = false;
        $showCharacter5 = false;
        $showCharacter1Name = "";
        $showCharacter2Name = "";
        $showCharacter3Name = "";
        $showCharacter4Name = "";
        $showCharacter5Name = "";
        $showCharacterAccountMsg = "";
        $showCharacterEmailMsg = "";
        $showCharacter1Msg = "";
        $showCharacter2Msg = "";
        $showCharacter3Msg = "";
        $showCharacter4Msg = "";
        $showCharacter5Msg = "";
        $showCharacterCountryMsg = "";
        $showCharacterAnswerMsg = "";
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
                throw new Exception("Connection to database server failed. [04]");
            }
        }
        fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Connection to databases successful" . PHP_EOL);
        if ($step == "" || $step == NULL) {
            fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Show terms" . PHP_EOL);
            $showTerms = true;
        } else {
            if ($step == "login") {
                if ($_SESSION["token"] == $_POST["token"]) {
                    fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Show login" . PHP_EOL);
                    $showLogin = true;
                } else {
                    fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Show login invalid token" . PHP_EOL);
                    message("notice", lang("global_module_13", true));
                }
            } else {
                if ($step == "char") {
                    if ($_SESSION["token"] == $_POST["token"]) {
                        fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Show char" . PHP_EOL);
                        $username = xss_clean($_POST["username"]);
                        $password = xss_clean($_POST["password"]);
                        fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Username: " . $username . " Password: " . $password . " " . PHP_EOL);
                        if (check_value($username) && check_value($password)) {
                            fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Check data OK" . PHP_EOL);
                            if ($config["SQL2_USE_2_DB"]) {
                                fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Use 2 DBs" . PHP_EOL);
                                $getUsername = $dB4->query_fetch_single("SELECT memb___id, mail_addr FROM MEMB_INFO WHERE memb___id = ? AND bloc_code = ?", [$username, 0]);
                            } else {
                                fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Use 1 DB" . PHP_EOL);
                                $getUsername = $dB3->query_fetch_single("SELECT memb___id, mail_addr FROM MEMB_INFO WHERE memb___id = ? AND bloc_code = ?", [$username, 0]);
                            }
                            fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Data from DB: [" . $getUsername["memb___id"] . "] [" . $getUsername["mail_addr"] . "]" . PHP_EOL);
                            $username = $getUsername["memb___id"];
                            $oldEmail = $getUsername["mail_addr"];
                            if ($config["SQL2_ENABLE_MD5"] == "1") {
                                fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] MD5 - 1" . PHP_EOL);
                                if ($config["SQL2_USE_2_DB"]) {
                                    fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Use 2 DBs - 2 [" . $username . "] [" . $password . "] [SELECT * FROM " . _TBL_MI_ . " WHERE " . _CLMN_USERNM_ . " = ? AND " . _CLMN_PASSWD_ . " = [dbo].[fn_md5](?, ?)]" . PHP_EOL);
                                    $query = $dB4->query_fetch_single("SELECT * FROM " . _TBL_MI_ . " WHERE " . _CLMN_USERNM_ . " = ? AND " . _CLMN_PASSWD_ . " = [dbo].[fn_md5](?, ?)", [$username, $password, $username]);
                                    fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] After query" . PHP_EOL);
                                    $md5_password = $dB4->query_fetch_single("SELECT [dbo].[fn_md5](?, ?) AS password FROM MEMB_INFO", [$password, $username]);
                                } else {
                                    fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Use 1 DB - 2" . PHP_EOL);
                                    $query = $dB3->query_fetch_single("SELECT * FROM " . _TBL_MI_ . " WHERE " . _CLMN_USERNM_ . " = ? AND " . _CLMN_PASSWD_ . " = [dbo].[fn_md5](?, ?)", [$username, $password, $username]);
                                    fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] After query" . PHP_EOL);
                                    $md5_password = $dB3->query_fetch_single("SELECT [dbo].[fn_md5](?, ?) AS password FROM MEMB_INFO", [$password, $username]);
                                }
                                fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] MD5 password: [" . $md5_password["password"] . "]" . PHP_EOL);
                                $md5_password = $md5_password["password"];
                            } else {
                                if ($config["SQL2_ENABLE_MD5"] == "2") {
                                    fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] MD5 - 2" . PHP_EOL);
                                    if ($config["SQL2_USE_2_DB"]) {
                                        $query = $dB4->query_fetch_single("SELECT * FROM " . _TBL_MI_ . " WHERE " . _CLMN_USERNM_ . " = ? AND " . _CLMN_PASSWD_ . " = ?", [$username, md5($password)]);
                                    } else {
                                        $query = $dB3->query_fetch_single("SELECT * FROM " . _TBL_MI_ . " WHERE " . _CLMN_USERNM_ . " = ? AND " . _CLMN_PASSWD_ . " = ?", [$username, md5($password)]);
                                    }
                                    $md5_password = md5($password);
                                } else {
                                    fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] MD5 - 0" . PHP_EOL);
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
                                    $checkRequest = $dB->query_fetch_single("SELECT TOP 1 OldAccountID, IsCompleted FROM IMPERIAMUCMS_TRANSFER_ACCOUNT WHERE OldAccountID = ? AND CreatedDate >= ? \r\n                                                                         ORDER BY CreatedDate DESC", [$username, $checkDate]);
                                    if ($checkRequest != NULL) {
                                        fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Transfer request found" . PHP_EOL);
                                        if ($checkRequest["IsCompleted"] == 1) {
                                            message("error", lang("transferaccount_txt_53", true));
                                            fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Transfer request is already completed" . PHP_EOL);
                                        } else {
                                            if ($checkRequest["IsCompleted"] == 0 && $checkRequest["OldAccountID"] == $username) {
                                                fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Show resend email" . PHP_EOL);
                                                $showResendEmail = true;
                                            }
                                        }
                                    } else {
                                        $showCharacter = true;
                                        fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Transfer request not found" . PHP_EOL);
                                        if (strlen($username) < 4 || !preg_match("/^[0-9a-zA-Z]+\$/", $username)) {
                                            fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Invalid account 1 [" . $username . "]" . PHP_EOL);
                                            $showCharacterAccountMsg = "<br>" . lang("transferaccount_txt_25", true);
                                            $showCharacterAccount = true;
                                        } else {
                                            if (!Validator::UsernameLength($username) || !Validator::AlphaNumeric($username)) {
                                                fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Invalid account 2 [" . $username . "]" . PHP_EOL);
                                                $showCharacterAccountMsg = "<br>" . lang("transferaccount_txt_25", true);
                                                $showCharacterAccount = true;
                                            } else {
                                                if ($config["SQL_USE_2_DB"]) {
                                                    $checkAccount = $dB2->query_fetch_single("SELECT TOP 1 memb___id FROM MEMB_INFO WHERE memb___id = ?", [$username]);
                                                } else {
                                                    $checkAccount = $dB->query_fetch_single("SELECT TOP 1 memb___id FROM MEMB_INFO WHERE memb___id = ?", [$username]);
                                                }
                                                if ($checkAccount["memb___id"] != NULL) {
                                                    fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Account already exists [" . $checkAccount["memb___id"] . "]" . PHP_EOL);
                                                    $showCharacterAccountMsg = "<br>" . lang("transferaccount_txt_24", true);
                                                    $showCharacterAccount = true;
                                                }
                                            }
                                        }
                                        if (!Validator::Email($getUsername["mail_addr"])) {
                                            fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Invalid email [" . $getUsername["mail_addr"] . "]" . PHP_EOL);
                                            $showCharacterEmailMsg = "<br>" . lang("transferaccount_txt_26", true);
                                            $showCharacterEmail = true;
                                        } else {
                                            if ($config["SQL_USE_2_DB"]) {
                                                $checkEmail = $dB2->query_fetch_single("SELECT TOP 1 mail_addr FROM MEMB_INFO WHERE mail_addr = ?", [$getUsername["mail_addr"]]);
                                            } else {
                                                $checkEmail = $dB->query_fetch_single("SELECT TOP 1 mail_addr FROM MEMB_INFO WHERE mail_addr = ?", [$getUsername["mail_addr"]]);
                                            }
                                            if ($checkEmail["mail_addr"] != NULL) {
                                                fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Email already exists [" . $checkEmail["mail_addr"] . "]" . PHP_EOL);
                                                $showCharacterEmailMsg = "<br>" . lang("transferaccount_txt_26", true);
                                                $showCharacterEmail = true;
                                            }
                                        }
                                        $oldCharacters = $dB3->query_fetch_single("SELECT TOP 1 GameID1, GameID2, GameID3, GameID4, GameID5 FROM AccountCharacter WHERE Id = ?", [$username]);
                                        $oldChar1 = $oldCharacters["GameID1"];
                                        $oldChar2 = $oldCharacters["GameID2"];
                                        $oldChar3 = $oldCharacters["GameID3"];
                                        $oldChar4 = $oldCharacters["GameID4"];
                                        $oldChar5 = $oldCharacters["GameID5"];
                                        fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Old characters [" . $oldChar1 . "] [" . $oldChar2 . "] [" . $oldChar3 . "] [" . $oldChar4 . "] [" . $oldChar5 . "]" . PHP_EOL);
                                        if ($oldChar1 != NULL) {
                                            if (strlen($oldChar1) < 4 || !preg_match("/^[0-9a-zA-Z]+\$/", $oldChar1)) {
                                                fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Invalid character name #1 [" . $oldChar1 . "]" . PHP_EOL);
                                                $showCharacter1Msg = "<br>" . sprintf(lang("transferaccount_txt_28", true), 1);
                                                $showCharacter1 = true;
                                                $showCharacter1Name = $oldChar1;
                                            } else {
                                                if (strcasecmp($oldChar1, $oldChar2) == 0 || strcasecmp($oldChar1, $oldChar3) == 0 || strcasecmp($oldChar1, $oldChar4) == 0 || strcasecmp($oldChar1, $oldChar5) == 0) {
                                                    fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Invalid character name #1 [" . $oldChar1 . "]" . PHP_EOL);
                                                    $showCharacter1Msg = "<br>" . sprintf(lang("transferaccount_txt_27", true), 1);
                                                    $showCharacter1 = true;
                                                    $showCharacter1Name = $oldChar1;
                                                } else {
                                                    $checkChar1 = $dB->query_fetch_single("SELECT TOP 1 Name FROM Character WHERE Name = ?", [$oldChar1]);
                                                    if ($checkChar1["Name"] != NULL) {
                                                        fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Character name #1 already exists [" . $oldChar1 . "]" . PHP_EOL);
                                                        $showCharacter1Msg = "<br>" . sprintf(lang("transferaccount_txt_27", true), 1);
                                                        $showCharacter1 = true;
                                                        $showCharacter1Name = $oldChar1;
                                                    }
                                                }
                                            }
                                        }
                                        if ($oldChar2 != NULL) {
                                            if (strlen($oldChar2) < 4 || !preg_match("/^[0-9a-zA-Z]+\$/", $oldChar2)) {
                                                fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Invalid character name #2 [" . $oldChar2 . "]" . PHP_EOL);
                                                $showCharacter2Msg = "<br>" . sprintf(lang("transferaccount_txt_28", true), 2);
                                                $showCharacter2 = true;
                                                $showCharacter2Name = $oldChar2;
                                            } else {
                                                if (strcasecmp($oldChar2, $oldChar1) == 0 || strcasecmp($oldChar2, $oldChar3) == 0 || strcasecmp($oldChar2, $oldChar4) == 0 || strcasecmp($oldChar2, $oldChar5) == 0) {
                                                    fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Invalid character name #2 [" . $oldChar2 . "]" . PHP_EOL);
                                                    $showCharacter2Msg = "<br>" . sprintf(lang("transferaccount_txt_27", true), 2);
                                                    $showCharacter2 = true;
                                                    $showCharacter2Name = $oldChar2;
                                                } else {
                                                    $checkChar2 = $dB->query_fetch_single("SELECT TOP 1 Name FROM Character WHERE Name = ?", [$oldChar2]);
                                                    if ($checkChar2["Name"] != NULL) {
                                                        fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Character name #2 already exists [" . $oldChar2 . "]" . PHP_EOL);
                                                        $showCharacter2Msg = "<br>" . sprintf(lang("transferaccount_txt_27", true), 2);
                                                        $showCharacter2 = true;
                                                        $showCharacter2Name = $oldChar2;
                                                    }
                                                }
                                            }
                                        }
                                        if ($oldChar3 != NULL) {
                                            if (strlen($oldChar3) < 4 || !preg_match("/^[0-9a-zA-Z]+\$/", $oldChar3)) {
                                                fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Invalid character name #3 [" . $oldChar3 . "]" . PHP_EOL);
                                                $showCharacter3Msg = "<br>" . sprintf(lang("transferaccount_txt_28", true), 3);
                                                $showCharacter3 = true;
                                                $showCharacter3Name = $oldChar3;
                                            } else {
                                                if (strcasecmp($oldChar3, $oldChar1) == 0 || strcasecmp($oldChar3, $oldChar2) == 0 || strcasecmp($oldChar3, $oldChar4) == 0 || strcasecmp($oldChar3, $oldChar5) == 0) {
                                                    fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Invalid character name #3 [" . $oldChar3 . "]" . PHP_EOL);
                                                    $showCharacter3Msg = "<br>" . sprintf(lang("transferaccount_txt_27", true), 3);
                                                    $showCharacter3 = true;
                                                    $showCharacter3Name = $oldChar3;
                                                } else {
                                                    $checkChar3 = $dB->query_fetch_single("SELECT TOP 1 Name FROM Character WHERE Name = ?", [$oldChar3]);
                                                    if ($checkChar3["Name"] != NULL) {
                                                        fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Character name #3 already exists [" . $oldChar3 . "]" . PHP_EOL);
                                                        $showCharacter3Msg = "<br>" . sprintf(lang("transferaccount_txt_27", true), 3);
                                                        $showCharacter3 = true;
                                                        $showCharacter3Name = $oldChar3;
                                                    }
                                                }
                                            }
                                        }
                                        if ($oldChar4 != NULL) {
                                            if (strlen($oldChar4) < 4 || !preg_match("/^[0-9a-zA-Z]+\$/", $oldChar4)) {
                                                fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Invalid character name #4 [" . $oldChar4 . "]" . PHP_EOL);
                                                $showCharacter4Msg = "<br>" . sprintf(lang("transferaccount_txt_28", true), 4);
                                                $showCharacter4 = true;
                                                $showCharacter4Name = $oldChar4;
                                            } else {
                                                if (strcasecmp($oldChar4, $oldChar1) == 0 || strcasecmp($oldChar4, $oldChar2) == 0 || strcasecmp($oldChar4, $oldChar3) == 0 || strcasecmp($oldChar4, $oldChar5) == 0) {
                                                    fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Invalid character name #4 [" . $oldChar4 . "]" . PHP_EOL);
                                                    $showCharacter4Msg = "<br>" . sprintf(lang("transferaccount_txt_27", true), 4);
                                                    $showCharacter4 = true;
                                                    $showCharacter4Name = $oldChar4;
                                                } else {
                                                    $checkChar4 = $dB->query_fetch_single("SELECT TOP 1 Name FROM Character WHERE Name = ?", [$oldChar4]);
                                                    if ($checkChar4["Name"] != NULL) {
                                                        fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Character name #4 already exists [" . $oldChar4 . "]" . PHP_EOL);
                                                        $showCharacter4Msg = "<br>" . sprintf(lang("transferaccount_txt_27", true), 4);
                                                        $showCharacter4 = true;
                                                        $showCharacter4Name = $oldChar4;
                                                    }
                                                }
                                            }
                                        }
                                        if ($oldChar5 != NULL) {
                                            if (strlen($oldChar5) < 4 || !preg_match("/^[0-9a-zA-Z]+\$/", $oldChar5)) {
                                                fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Invalid character name #5 [" . $oldChar5 . "]" . PHP_EOL);
                                                $showCharacter5Msg = "<br>" . sprintf(lang("transferaccount_txt_28", true), 5);
                                                $showCharacter5 = true;
                                                $showCharacter5Name = $oldChar5;
                                            } else {
                                                if (strcasecmp($oldChar5, $oldChar1) == 0 || strcasecmp($oldChar5, $oldChar2) == 0 || strcasecmp($oldChar5, $oldChar3) == 0 || strcasecmp($oldChar5, $oldChar4) == 0) {
                                                    fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Invalid character name #5 [" . $oldChar5 . "]" . PHP_EOL);
                                                    $showCharacter5Msg = "<br>" . sprintf(lang("transferaccount_txt_27", true), 5);
                                                    $showCharacter5 = true;
                                                    $showCharacter5Name = $oldChar5;
                                                } else {
                                                    $checkChar5 = $dB->query_fetch_single("SELECT TOP 1 Name FROM Character WHERE Name = ?", [$oldChar5]);
                                                    if ($checkChar5["Name"] != NULL) {
                                                        fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Character name #5already exists [" . $oldChar5 . "]" . PHP_EOL);
                                                        $showCharacter5Msg = "<br>" . sprintf(lang("transferaccount_txt_27", true), 5);
                                                        $showCharacter5 = true;
                                                        $showCharacter5Name = $oldChar5;
                                                    }
                                                }
                                            }
                                        }
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
                    if ($step == "verify") {
                        if ($_SESSION["token"] == $_POST["token"]) {
                            fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Show verify" . PHP_EOL);
                            $error = false;
                            $username = xss_clean(Decode($_POST[Encode("username_hidden")]));
                            $password = xss_clean(Decode($_POST[Encode("password_hidden")]));
                            $info = xss_clean(Decode($_POST[Encode("info_hidden")]));
                            $infoLog = $info;
                            $info = explode(";", $info);
                            list($isNewAccount, $isNewEmail, $isNewChar1, $isNewChar2, $isNewChar3, $isNewChar4, $isNewChar5) = $info;
                            $oldCharacters = $dB3->query_fetch_single("SELECT TOP 1 GameID1, GameID2, GameID3, GameID4, GameID5 FROM AccountCharacter WHERE Id = ?", [$username]);
                            $oldChar1 = $oldCharacters["GameID1"];
                            $oldChar2 = $oldCharacters["GameID2"];
                            $oldChar3 = $oldCharacters["GameID3"];
                            $oldChar4 = $oldCharacters["GameID4"];
                            $oldChar5 = $oldCharacters["GameID5"];
                            $newUsername = xss_clean($_POST["username"]);
                            $newEmail = xss_clean($_POST["email"]);
                            $newChar1 = xss_clean($_POST["char1"]);
                            $newChar2 = xss_clean($_POST["char2"]);
                            $newChar3 = xss_clean($_POST["char3"]);
                            $newChar4 = xss_clean($_POST["char4"]);
                            $newChar5 = xss_clean($_POST["char5"]);
                            $country = xss_clean($_POST["country"]);
                            $question = xss_clean($_POST["question"]);
                            $answer = xss_clean($_POST["answer"]);
                            if ($newUsername == NULL || empty($newUsername)) {
                                $newUsername = xss_clean(Decode($_POST[Encode("oldUsername")]));
                            }
                            if ($newEmail == NULL || empty($newEmail)) {
                                $newEmail = xss_clean(Decode($_POST[Encode("oldEmail")]));
                            }
                            if ($newChar1 == NULL || empty($newChar1)) {
                                $newChar1 = xss_clean(Decode($_POST[Encode("oldCharacter1")]));
                            }
                            if ($newChar2 == NULL || empty($newChar2)) {
                                $newChar2 = xss_clean(Decode($_POST[Encode("oldCharacter2")]));
                            }
                            if ($newChar3 == NULL || empty($newChar3)) {
                                $newChar3 = xss_clean(Decode($_POST[Encode("oldCharacter3")]));
                            }
                            if ($newChar4 == NULL || empty($newChar4)) {
                                $newChar4 = xss_clean(Decode($_POST[Encode("oldCharacter4")]));
                            }
                            if ($newChar5 == NULL || empty($newChar5)) {
                                $newChar5 = xss_clean(Decode($_POST[Encode("oldCharacter5")]));
                            }
                            $oldEmail = $newEmail;
                            fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Data: [Username: " . $username . "] [Password: " . $password . "] [Info: " . $infoLog . "] [IsNewAcc: " . $isNewAccount . "]\r\n                        [IsNewEmail: " . $isNewEmail . "] [IsNewChar1: " . $isNewChar1 . "] [IsNewChar2: " . $isNewChar2 . "] [IsNewChar3: " . $isNewChar3 . "] [IsNewChar4: " . $isNewChar4 . "] [IsNewChar5: " . $isNewChar5 . "] \r\n                        [NewUsername: " . $newUsername . "] [NewEmail: " . $newEmail . "] [NewChar1: " . $newChar1 . "] [NewChar2: " . $newChar2 . "] [NewChar3: " . $newChar3 . "] [NewChar4: " . $newChar4 . "] [NewChar5: " . $newChar5 . "]\r\n                        [Country: " . $country . "] [Question: " . $question . "] [Answer: " . $answer . "]" . PHP_EOL);
                            $storeValues = [];
                            $storeValues["username"] = $newUsername;
                            $storeValues["email"] = $newEmail;
                            $storeValues["char1"] = $newChar1;
                            $storeValues["char2"] = $newChar2;
                            $storeValues["char3"] = $newChar3;
                            $storeValues["char4"] = $newChar4;
                            $storeValues["char5"] = $newChar5;
                            $storeValues["country"] = $country;
                            $storeValues["question"] = $question;
                            $storeValues["answer"] = $answer;
                            if ($isNewAccount) {
                                fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] IsNewAccount is true" . PHP_EOL);
                                $showCharacterAccount = true;
                                if (check_value($newUsername)) {
                                    if (strlen($newUsername) < 4 || !preg_match("/^[0-9a-zA-Z]+\$/", $newUsername) || !Validator::UsernameLength($newUsername) || !Validator::AlphaNumeric($newUsername)) {
                                        $showCharacterAccountMsg = "<br>" . lang("transferaccount_txt_25", true);
                                        $storeValues["username"] = NULL;
                                        $error = true;
                                    } else {
                                        if ($config["SQL_USE_2_DB"]) {
                                            $checkAccount = $dB2->query_fetch_single("SELECT TOP 1 memb___id FROM MEMB_INFO WHERE memb___id = ?", [$newUsername]);
                                        } else {
                                            $checkAccount = $dB->query_fetch_single("SELECT TOP 1 memb___id FROM MEMB_INFO WHERE memb___id = ?", [$newUsername]);
                                        }
                                        if ($checkAccount["memb___id"] != NULL) {
                                            $showCharacterAccountMsg = "<br>" . lang("transferaccount_txt_24", true);
                                            $storeValues["username"] = NULL;
                                            $error = true;
                                        }
                                    }
                                } else {
                                    $showCharacterAccountMsg = "<br>" . lang("transferaccount_txt_25", true);
                                    $storeValues["username"] = NULL;
                                    $error = true;
                                }
                            }
                            if ($isNewEmail) {
                                fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] IsNewEmail is true" . PHP_EOL);
                                $showCharacterEmail = true;
                                if (check_value($newEmail)) {
                                    if (Validator::Email($newEmail)) {
                                        if ($config["SQL_USE_2_DB"]) {
                                            $checkEmail = $dB2->query_fetch_single("SELECT TOP 1 mail_addr FROM MEMB_INFO WHERE mail_addr = ?", [$newEmail]);
                                        } else {
                                            $checkEmail = $dB->query_fetch_single("SELECT TOP 1 mail_addr FROM MEMB_INFO WHERE mail_addr = ?", [$newEmail]);
                                        }
                                        if ($checkEmail["mail_addr"] != NULL) {
                                            $showCharacterEmailMsg = "<br>" . lang("transferaccount_txt_26", true);
                                            $storeValues["email"] = NULL;
                                            $error = true;
                                        }
                                    } else {
                                        $showCharacterEmailMsg = "<br>" . lang("transferaccount_txt_29", true);
                                        $storeValues["email"] = NULL;
                                        $error = true;
                                    }
                                } else {
                                    $showCharacterEmailMsg = "<br>" . lang("transferaccount_txt_29", true);
                                    $storeValues["email"] = NULL;
                                    $error = true;
                                }
                            }
                            if ($isNewChar1) {
                                fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] IsNewChar1 is true" . PHP_EOL);
                                $showCharacter1 = true;
                                $showCharacter1Name = $oldChar1;
                                if (check_value($newChar1)) {
                                    if (strlen($newChar1) < 4 || !preg_match("/^[0-9a-zA-Z]+\$/", $newChar1)) {
                                        $showCharacter1Msg = "<br>" . sprintf(lang("transferaccount_txt_28", true), 1);
                                        $storeValues["char1"] = NULL;
                                        $error = true;
                                    } else {
                                        if (strcasecmp($newChar1, $newChar2) == 0 || strcasecmp($newChar1, $newChar3) == 0 || strcasecmp($newChar1, $newChar4) == 0 || strcasecmp($newChar1, $newChar5) == 0) {
                                            $showCharacter1Msg = "<br>" . sprintf(lang("transferaccount_txt_27", true), 1);
                                            $storeValues["char1"] = NULL;
                                            $error = true;
                                        } else {
                                            $checkChar1 = $dB->query_fetch_single("SELECT TOP 1 Name FROM Character WHERE Name = ?", [$newChar1]);
                                            if ($checkChar1["Name"] != NULL) {
                                                $showCharacter1Msg = "<br>" . sprintf(lang("transferaccount_txt_27", true), 1);
                                                $storeValues["char1"] = NULL;
                                                $error = true;
                                            }
                                        }
                                    }
                                } else {
                                    $showCharacter1Msg = "<br>" . sprintf(lang("transferaccount_txt_28", true), 1);
                                    $storeValues["char1"] = NULL;
                                    $error = true;
                                }
                            }
                            if ($isNewChar2) {
                                fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] IsNewChar2 is true" . PHP_EOL);
                                $showCharacter2 = true;
                                $showCharacter2Name = $oldChar2;
                                if (check_value($newChar2)) {
                                    if (strlen($newChar2) < 4 || !preg_match("/^[0-9a-zA-Z]+\$/", $newChar2)) {
                                        $showCharacter2Msg = "<br>" . sprintf(lang("transferaccount_txt_28", true), 2);
                                        $storeValues["char2"] = NULL;
                                        $error = true;
                                    } else {
                                        if (strcasecmp($newChar2, $newChar1) == 0 || strcasecmp($newChar2, $newChar3) == 0 || strcasecmp($newChar2, $newChar4) == 0 || strcasecmp($newChar2, $newChar5) == 0) {
                                            $showCharacter2Msg = "<br>" . sprintf(lang("transferaccount_txt_27", true), 2);
                                            $storeValues["char2"] = NULL;
                                            $error = true;
                                        } else {
                                            $checkChar2 = $dB->query_fetch_single("SELECT TOP 1 Name FROM Character WHERE Name = ?", [$newChar2]);
                                            if ($checkChar2["Name"] != NULL) {
                                                $showCharacter2Msg = "<br>" . sprintf(lang("transferaccount_txt_27", true), 2);
                                                $storeValues["char2"] = NULL;
                                                $error = true;
                                            }
                                        }
                                    }
                                } else {
                                    $showCharacter2Msg = "<br>" . sprintf(lang("transferaccount_txt_28", true), 1);
                                    $storeValues["char2"] = NULL;
                                    $error = true;
                                }
                            }
                            if ($isNewChar3) {
                                fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] IsNewChar3 is true" . PHP_EOL);
                                $showCharacter3 = true;
                                $showCharacter3Name = $oldChar3;
                                if (check_value($newChar3)) {
                                    if (strlen($newChar3) < 4 || !preg_match("/^[0-9a-zA-Z]+\$/", $newChar3)) {
                                        $showCharacter3Msg = "<br>" . sprintf(lang("transferaccount_txt_28", true), 3);
                                        $storeValues["char3"] = NULL;
                                        $error = true;
                                    } else {
                                        if (strcasecmp($newChar3, $newChar1) == 0 || strcasecmp($newChar3, $newChar2) == 0 || strcasecmp($newChar3, $newChar4) == 0 || strcasecmp($newChar3, $newChar5) == 0) {
                                            $showCharacter3Msg = "<br>" . sprintf(lang("transferaccount_txt_27", true), 3);
                                            $storeValues["char3"] = NULL;
                                            $error = true;
                                        } else {
                                            $checkChar3 = $dB->query_fetch_single("SELECT TOP 1 Name FROM Character WHERE Name = ?", [$newChar3]);
                                            if ($checkChar3["Name"] != NULL) {
                                                $showCharacter3Msg = "<br>" . sprintf(lang("transferaccount_txt_27", true), 3);
                                                $storeValues["char3"] = NULL;
                                                $error = true;
                                            }
                                        }
                                    }
                                } else {
                                    $showCharacter3Msg = "<br>" . sprintf(lang("transferaccount_txt_28", true), 3);
                                    $storeValues["char3"] = NULL;
                                    $error = true;
                                }
                            }
                            if ($isNewChar4) {
                                fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] IsNewChar4 is true" . PHP_EOL);
                                $showCharacter4 = true;
                                $showCharacter4Name = $oldChar4;
                                if (check_value($newChar4)) {
                                    if (strlen($newChar4) < 4 || !preg_match("/^[0-9a-zA-Z]+\$/", $newChar4)) {
                                        $showCharacter4Msg = "<br>" . sprintf(lang("transferaccount_txt_28", true), 4);
                                        $storeValues["char4"] = NULL;
                                        $error = true;
                                    } else {
                                        if (strcasecmp($newChar4, $newChar1) == 0 || strcasecmp($newChar4, $newChar2) == 0 || strcasecmp($newChar4, $newChar3) == 0 || strcasecmp($newChar4, $newChar5) == 0) {
                                            $showCharacter4Msg = "<br>" . sprintf(lang("transferaccount_txt_27", true), 4);
                                            $storeValues["char4"] = NULL;
                                            $error = true;
                                        } else {
                                            $checkChar4 = $dB->query_fetch_single("SELECT TOP 1 Name FROM Character WHERE Name = ?", [$newChar4]);
                                            if ($checkChar4["Name"] != NULL) {
                                                $showCharacter4Msg = "<br>" . sprintf(lang("transferaccount_txt_27", true), 4);
                                                $storeValues["char4"] = NULL;
                                                $error = true;
                                            }
                                        }
                                    }
                                } else {
                                    $showCharacter4Msg = "<br>" . sprintf(lang("transferaccount_txt_28", true), 4);
                                    $storeValues["char4"] = NULL;
                                    $error = true;
                                }
                            }
                            if ($isNewChar5) {
                                fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] IsNewChar5 is true" . PHP_EOL);
                                $showCharacter5 = true;
                                $showCharacter5Name = $oldChar5;
                                if (check_value($newChar5)) {
                                    if (strlen($newChar5) < 4 || !preg_match("/^[0-9a-zA-Z]+\$/", $newChar5)) {
                                        $showCharacter5Msg = "<br>" . sprintf(lang("transferaccount_txt_28", true), 5);
                                        $storeValues["char5"] = NULL;
                                        $error = true;
                                    } else {
                                        if (strcasecmp($newChar5, $newChar1) == 0 || strcasecmp($newChar5, $newChar2) == 0 || strcasecmp($newChar5, $newChar3) == 0 || strcasecmp($newChar5, $newChar4) == 0) {
                                            $showCharacter5Msg = "<br>" . sprintf(lang("transferaccount_txt_27", true), 5);
                                            $storeValues["char5"] = NULL;
                                            $error = true;
                                        } else {
                                            $checkChar5 = $dB->query_fetch_single("SELECT TOP 1 Name FROM Character WHERE Name = ?", [$newChar5]);
                                            if ($checkChar5["Name"] != NULL) {
                                                $showCharacter5Msg = "<br>" . sprintf(lang("transferaccount_txt_27", true), 5);
                                                $storeValues["char5"] = NULL;
                                                $error = true;
                                            }
                                        }
                                    }
                                } else {
                                    $showCharacter5Msg = "<br>" . sprintf(lang("transferaccount_txt_28", true), 5);
                                    $storeValues["char5"] = NULL;
                                    $error = true;
                                }
                            }
                            if (!check_value($question) || !check_value($answer) || !check_value($country)) {
                                $error = true;
                            }
                            if (!Validator::AlphaNumeric($answer)) {
                                $showCharacterAnswerMsg = "<br>" . sprintf(lang("transferaccount_txt_30", true), 5);
                                $error = true;
                            }
                            if (100 < strlen($answer) || strlen($answer) < 1) {
                                $showCharacterAnswerMsg = "<br>" . sprintf(lang("transferaccount_txt_31", true), 5);
                                $error = true;
                            }
                            if (!Validator::AlphaNumeric($country)) {
                                $showCharacterCountryMsg = "<br>" . sprintf(lang("transferaccount_txt_32", true), 5);
                                $error = true;
                            }
                            if (2 < strlen($country) || strlen($country) < 2) {
                                $showCharacterCountryMsg = "<br>" . sprintf(lang("transferaccount_txt_33", true), 5);
                                $error = true;
                            }
                            if ($error) {
                                fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Some error occurred" . PHP_EOL);
                                $showCharacter = true;
                            } else {
                                fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Everything is ok, next step - verification" . PHP_EOL);
                                $showVerification = true;
                            }
                        } else {
                            fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Invalid token" . PHP_EOL);
                            message("notice", lang("global_module_13", true));
                        }
                    } else {
                        if ($step == "send") {
                            if ($_SESSION["token"] == $_POST["token"]) {
                                fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Show send" . PHP_EOL);
                                $data = xss_clean(Decode($_POST[Encode("data_hidden")]));
                                $dataLog = $data;
                                $data = explode(";", $data);
                                fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Data: [" . $dataLog . "]" . PHP_EOL);
                                $checkRequest = $dB->query_fetch_single("SELECT TOP 1 OldAccountID, IsCompleted FROM IMPERIAMUCMS_TRANSFER_ACCOUNT WHERE OldAccountID = ? AND CreatedDate >= ? \r\n                                                         ORDER BY CreatedDate DESC", [$username, $checkDate]);
                                if ($checkRequest != NULL) {
                                    fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Request already exists, show resend email" . PHP_EOL);
                                    $showResendEmail = true;
                                } else {
                                    fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Request does not exist" . PHP_EOL);
                                    list($newUsername, $newEmail, $newChar1, $newChar2, $newChar3, $newChar4, $newChar5, $newCountry, $newQuestion, $newAnswer, $oldUsername, $password) = $data;
                                    if ($newChar1 == "") {
                                        $newChar1 = NULL;
                                    }
                                    if ($newChar2 == "") {
                                        $newChar2 = NULL;
                                    }
                                    if ($newChar3 == "") {
                                        $newChar3 = NULL;
                                    }
                                    if ($newChar4 == "") {
                                        $newChar4 = NULL;
                                    }
                                    if ($newChar5 == "") {
                                        $newChar5 = NULL;
                                    }
                                    $key = uniqid();
                                    if ($config["SQL2_USE_2_DB"]) {
                                        $checkEmail = $dB4->query_fetch_single("SELECT TOP 1 mail_addr FROM MEMB_INFO WHERE memb___id = ?", [$oldUsername]);
                                    } else {
                                        $checkEmail = $dB3->query_fetch_single("SELECT TOP 1 mail_addr FROM MEMB_INFO WHERE memb___id = ?", [$oldUsername]);
                                    }
                                    $characters = $dB3->query_fetch_single("SELECT TOP 1 GameID1, GameID2, GameID3, GameID4, GameID5 FROM AccountCharacter WHERE Id = ?", [$oldUsername]);
                                    fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Insert data: [OldUsername: " . $oldUsername . "] [NewUsername: " . $newUsername . "] [Password: " . $password . " (" . Encode($password) . ")]\r\n                             [OldEmail: " . $checkEmail["mail_addr"] . "] [NewEmail: " . $newEmail . "]\r\n                             [OldName1: " . $characters["GameID1"] . "] [OldName2: " . $characters["GameID2"] . "] [OldName3: " . $characters["GameID3"] . "] [OldName4: " . $characters["GameID4"] . "] [OldName5: " . $characters["GameID5"] . "]\r\n                             [NewName1: " . $newChar1 . "] [NewName2: " . $newChar2 . "] [NewName3: " . $newChar3 . "] [NewName4: " . $newChar4 . "] [NewName5: " . $newChar5 . "]\r\n                             [Country: " . $newCountry . "] [Question: " . $newQuestion . "] [Answer: " . $newAnswer . "] [CreatedDate: " . date("Y-m-d H:i:s", time()) . "] [CompletedDate: null] [IsCompleted: 0] [IP: " . $_SERVER["REMOTE_ADDR"] . "] [VerificationKey: " . $key . "]" . PHP_EOL);
                                    $insert = $dB->query("INSERT INTO IMPERIAMUCMS_TRANSFER_ACCOUNT (OldAccountID, NewAccountID, Password, OldEmail, NewEmail, OldName1, OldName2, OldName3, OldName4, OldName5, NewName1, NewName2, NewName3, NewName4, NewName5, Country, SecretQuestion, SecretAnswer, CreatedDate, CompletedDate, IsCompleted, IP, VerificationKey) \r\n                                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$oldUsername, $newUsername, Encode($password), $checkEmail["mail_addr"], $newEmail, $characters["GameID1"], $characters["GameID2"], $characters["GameID3"], $characters["GameID4"], $characters["GameID5"], $newChar1, $newChar2, $newChar3, $newChar4, $newChar5, $newCountry, $newQuestion, $newAnswer, date("Y-m-d H:i:s", time()), NULL, 0, $_SERVER["REMOTE_ADDR"], $key]);
                                    if ($insert) {
                                        fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Request was successfully inserted" . PHP_EOL);
                                        $verificationLink = __BASE_URL__ . "verifyemail/?op=" . Encode_id(4) . "&user=" . Encode($oldUsername) . "&key=" . $key;
                                        fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Verification link: " . $verificationLink . "" . PHP_EOL);
                                        try {
                                            $email = new Email();
                                            $email->setTemplate("TRANSFER_EMAIL_VERIFICATION");
                                            $email->addVariable("{USERNAME}", $oldUsername);
                                            $email->addVariable("{LINK}", $verificationLink);
                                            $email->addAddress($checkEmail["mail_addr"]);
                                            $email->send();
                                            message("success", sprintf(lang("transferaccount_txt_35", true), $checkEmail["mail_addr"]));
                                            fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Email verification was successfully sent" . PHP_EOL);
                                        } catch (Exception $ex) {
                                            fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Error occurred during sending email" . PHP_EOL);
                                            message("error", $ex->getMessage());
                                        }
                                    } else {
                                        fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Insert failed" . PHP_EOL);
                                    }
                                }
                            } else {
                                fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] Invalid token" . PHP_EOL);
                                message("notice", lang("global_module_13", true));
                            }
                        } else {
                            if ($step == "resendemail") {
                                if ($_SESSION["token"] == $_POST["token"]) {
                                    $username = xss_clean(Decode($_POST[Encode("username_hidden")]));
                                    $getData = $dB->query_fetch_single("SELECT TOP 1 * FROM IMPERIAMUCMS_TRANSFER_ACCOUNT WHERE OldAccountID = ? AND CreatedDate >= ?\r\n                                                    ORDER BY CreatedDate DESC", [$username, $checkDate]);
                                    if (is_array($getData)) {
                                        $verificationLink = __BASE_URL__ . "verifyemail/?op=" . Encode_id(4) . "&user=" . Encode($getData["OldAccountID"]) . "&key=" . $getData["VerificationKey"];
                                        try {
                                            $email = new Email();
                                            $email->setTemplate("TRANSFER_EMAIL_VERIFICATION");
                                            $email->addVariable("{USERNAME}", $getData["OldAccountID"]);
                                            $email->addVariable("{LINK}", $verificationLink);
                                            $email->addAddress($getData["OldEmail"]);
                                            $email->send();
                                            message("success", sprintf(lang("transferaccount_txt_35", true), $getData["OldEmail"]));
                                        } catch (Exception $ex) {
                                        }
                                    }
                                } else {
                                    message("notice", lang("global_module_13", true));
                                }
                            }
                        }
                    }
                }
            }
        }
        $token = time();
        $_SESSION["token"] = $token;
        if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
            if ($showTerms) {
                echo "\r\n            <div class=\"row\">\r\n                <div class=\"col-xs-12 text-justify register-terms\">\r\n                    " . lang("transferaccount_txt_2", true) . "\r\n                </div>\r\n            </div>\r\n            <div class=\"row\" style=\"margin-top: 15px;\">\r\n                <div class=\"col-xs-12 text-center\">\r\n                    <form method=\"post\" action=\"\">\r\n                        <input type=\"submit\" class=\"btn btn-success\" name=\"terms\" id=\"terms\" value=\"" . lang("transferaccount_txt_3", true) . "\" />\r\n                        <input type=\"hidden\" name=\"step\" value=\"" . Encode("login") . "\" />\r\n                        <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                        <a class=\"btn btn-danger\" href=\"" . __BASE_URL__ . "\">" . lang("transferaccount_txt_4", true) . "</a>\r\n                    </form>\r\n                </div>\r\n            </div>";
            }
            if ($showLogin) {
                echo "\r\n    <div class=\"row desc-row\">\r\n        <div class=\"col-xs-12\">" . lang("transferaccount_txt_20", true) . "</div>\r\n    </div>\r\n    <div class=\"row\">\r\n        <div class=\"col-xs-12 col-md-6 col-md-offset-3 column\">\r\n            <form action=\"\" method=\"post\" class=\"form-horizontal\">\r\n                <div class=\"form-group\">\r\n                    <label for=\"username\" class=\"col-sm-3 control-label\">" . lang("transferaccount_txt_5", true) . "</label>\r\n                    <div class=\"col-xs-12 col-sm-6\">\r\n                        <input type=\"text\" name=\"username\" class=\"form-control\" id=\"username\" tabindex=\"1\" maxlength=\"10\" required=\"required\" />\r\n                    </div>\r\n                </div>\r\n                <div class=\"form-group\">\r\n                    <label for=\"password\" class=\"col-sm-3 control-label\">" . lang("transferaccount_txt_6", true) . "</label>\r\n                    <div class=\"col-xs-12 col-sm-6\">\r\n                        <input type=\"password\" name=\"password\" class=\"form-control\" id=\"password\" tabindex=\"2\" maxlength=\"20\" autocomplete=\"off\" required=\"required\" />\r\n                    </div>\r\n                </div>\r\n                <div class=\"form-group separator\">\r\n                    <div class=\"col-xs-12 col-sm-offset-3 col-sm-6\">\r\n                        <input type=\"hidden\" name=\"step\" value=\"" . Encode("char") . "\"/>\r\n                        <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                        <input type=\"submit\" name=\"submit\" class=\"btn btn-warning\" style=\"width: 100%;\" value=\"" . lang("transferaccount_txt_19", true) . "\" tabindex=\"3\">\r\n                    </div>\r\n                </div>\r\n            </form>\r\n        </div>\r\n    </div>";
            }
            if ($showResendEmail) {
                echo "\r\n    <div class=\"row desc-row\">\r\n        <div class=\"col-xs-12\">" . lang("transferaccount_txt_20", true) . "</div>\r\n    </div>\r\n    <div class=\"row\">\r\n        <div class=\"col-xs-12 col-md-6 col-md-offset-3 column\">\r\n            <form action=\"\" method=\"post\" class=\"form-horizontal\">\r\n                <div class=\"form-group\">\r\n                    " . lang("transferaccount_txt_37", true) . "\r\n                </div>\r\n                <div class=\"form-group separator\">\r\n                    <div class=\"col-xs-12 col-sm-offset-3 col-sm-6\">\r\n                        <input type=\"hidden\" name=\"" . Encode("username_hidden") . "\" value=\"" . Encode($username) . "\"/>\r\n                        <input type=\"hidden\" name=\"step\" value=\"" . Encode("resendemail") . "\"/>\r\n                        <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                        <input type=\"submit\" name=\"submit\" class=\"btn btn-warning\" style=\"width: 100%;\" value=\"" . lang("transferaccount_txt_38", true) . "\" tabindex=\"3\">\r\n                    </div>\r\n                </div>\r\n            </form>\r\n        </div>\r\n    </div>";
            }
        } else {
            if ($showTerms) {
                echo "\r\n<div class=\"container_3 terms-of-usage\" align=\"center\">\r\n    <h1></h1>\r\n    <script type=\"text/javascript\" src=\"https://code.jquery.com/jquery-latest.min.js\"></script>\r\n    <script type=\"text/javascript\" src=\"" . __PATH_TEMPLATE__ . "js/jquery.tinyscrollbar.min.js\"></script>\r\n    <script type=\"text/javascript\">\r\n        \$(document).ready(function () {\r\n            \$('#terms-container').tinyscrollbar();\r\n        });\r\n    </script>\r\n    <div id=\"terms-container\">\r\n        <div class=\"scrollbar\">\r\n            <div class=\"track\">\r\n                <div class=\"thumb\"></div>\r\n            </div>\r\n        </div>\r\n        <div class=\"terms-shadow\"></div>\r\n        <div class=\"viewport\">\r\n            <div class=\"overview\">\r\n                " . lang("transferaccount_txt_2", true) . "\r\n            </div>\r\n        </div>\r\n        <div class=\"clear\"></div>\r\n    </div>\r\n    <div style=\"height:20px;\"></div>\r\n    <form method=\"post\" action=\"\">\r\n        <table width=\"100%\" align=\"center\">\r\n            <tr>\r\n                <td align=\"center\">\r\n                    <input type=\"submit\" class=\"agree\" id=\"terms\" value=\"" . lang("transferaccount_txt_3", true) . "\" style=\"margin:10px 0 0 0;\"/>\r\n                    <input type=\"hidden\" name=\"step\" value=\"" . Encode("login") . "\" />\r\n                    <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                    <a class=\"dissagree\" href=\"index.php\">" . lang("transferaccount_txt_4", true) . "</a>\r\n                </td>\r\n            </tr>\r\n        </table>\r\n    </form>\r\n</div>";
            }
            if ($showLogin) {
                echo "\r\n<div class=\"page-desc-holder\">" . lang("transferaccount_txt_20", true) . "</div>\r\n<div class=\"container_3\" align=\"center\">\r\n    <form action=\"\" method=\"post\">\r\n        <div class=\"row\">\r\n            <label for=\"username\">" . lang("transferaccount_txt_5", true) . "</label>\r\n            <input type=\"text\" name=\"username\" id=\"username\" tabindex=\"1\" maxlength=\"10\" autocomplete=\"off\" required=\"required\" />\r\n        </div>\r\n        <div class=\"row\">\r\n            <label for=\"password\">" . lang("transferaccount_txt_6", true) . "</label>\r\n            <input type=\"password\" name=\"password\" id=\"password\" tabindex=\"2\" maxlength=\"20\" autocomplete=\"off\" required=\"required\" />\r\n        </div>\r\n        <div class=\"seperator\"></div>\r\n        <div class=\"row\" align=\"right\">\r\n            <input type=\"submit\" name=\"submit\" tabindex=\"3\" value=\"" . lang("transferaccount_txt_19", true) . "\" />\r\n            <input type=\"hidden\" name=\"step\" value=\"" . Encode("char") . "\"/>\r\n            <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n        </div>\r\n    </form>\r\n</div>";
            }
            if ($showResendEmail) {
                echo "\r\n<div class=\"page-desc-holder\">" . lang("transferaccount_txt_20", true) . "</div>\r\n<div class=\"container_3\" align=\"center\">\r\n    <form action=\"\" method=\"post\">\r\n        <div class=\"row\" style=\"height: 70px;\">\r\n            <label for=\"answer\">" . lang("transferaccount_txt_37", true) . "</label>\r\n        </div>\r\n        <div class=\"seperator\"></div>\r\n        <div class=\"row\" align=\"right\">\r\n            <input type=\"submit\" name=\"submit\" tabindex=\"3\" value=\"" . lang("transferaccount_txt_38", true) . "\" />\r\n            <input type=\"hidden\" name=\"" . Encode("username_hidden") . "\" value=\"" . Encode($username) . "\"/>\r\n            <input type=\"hidden\" name=\"step\" value=\"" . Encode("resendemail") . "\"/>\r\n            <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n        </div>\r\n    </form>\r\n</div>";
            }
        }
        if ($showCharacter) {
            $questions = "";
            $i = 1;
            foreach ($custom["secret_questions"] as $thisQuestion) {
                if ($storeValues["question"] == $i) {
                    $questions .= "<option value=\"" . $i . "\" selected=\"selected\">" . $thisQuestion . "</option>";
                } else {
                    $questions .= "<option value=\"" . $i . "\">" . $thisQuestion . "</option>";
                }
                $i++;
            }
            if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
                echo "\r\n<form action=\"\" method=\"post\" class=\"form-horizontal\">\r\n    <div class=\"row desc-row\">\r\n        <div class=\"col-xs-12\">\r\n            " . lang("transferaccount_txt_21", true) . "<br>" . $showCharacterAccountMsg . " " . $showCharacterEmailMsg . "\r\n            " . $showCharacter1Msg . " " . $showCharacter2Msg . " " . $showCharacter3Msg . " " . $showCharacter4Msg . " " . $showCharacter5Msg . "\r\n            " . $showCharacterAnswerMsg . " " . $showCharacterCountryMsg . "\r\n        </div>\r\n    </div>";
                if ($showCharacterAccount) {
                    echo "\r\n    <div class=\"row\">\r\n        <div class=\"col-xs-12 col-md-6 col-md-offset-3 column\">\r\n            <div class=\"form-group\">\r\n                <label for=\"username\" class=\"col-sm-3 control-label\">" . lang("transferaccount_txt_5", true) . "</label>\r\n                <div class=\"col-xs-12 col-sm-6\">\r\n                    <input type=\"text\" name=\"username\" value=\"" . $storeValues["username"] . "\" class=\"form-control\" id=\"username\" tabindex=\"1\" maxlength=\"10\" required=\"required\" />\r\n                </div>\r\n            </div>\r\n            <div class=\"form-group\">\r\n                " . lang("transferaccount_txt_23", true) . "\r\n            </div>\r\n        </div>\r\n    </div>";
                } else {
                    echo "<input type=\"hidden\" name=\"" . Encode("oldUsername") . "\" value=\"" . Encode($username) . "\"/>";
                }
                if ($showCharacterEmail) {
                    echo "\r\n    <div class=\"row\">\r\n        <div class=\"col-xs-12 col-md-6 col-md-offset-3 column\">\r\n            <div class=\"form-group\">\r\n                <label for=\"email\" class=\"col-sm-3 control-label\">" . lang("transferaccount_txt_8", true) . "</label>\r\n                <div class=\"col-xs-12 col-sm-6\">\r\n                    <input type=\"text\" name=\"email\" value=\"" . $storeValues["email"] . "\" class=\"form-control\" id=\"email\" tabindex=\"2\" required=\"required\" />\r\n                </div>\r\n            </div>\r\n        </div>\r\n    </div>";
                } else {
                    echo "<input type=\"hidden\" name=\"" . Encode("oldEmail") . "\" value=\"" . Encode($oldEmail) . "\"/>";
                }
                if ($showCharacter1) {
                    echo "\r\n    <div class=\"row\">\r\n        <div class=\"col-xs-12 col-md-6 col-md-offset-3 column\">\r\n            <div class=\"form-group\">\r\n                <label for=\"char1\" class=\"col-sm-3 control-label\">" . sprintf(lang("transferaccount_txt_22", true), 1, $showCharacter1Name) . "</label>\r\n                <div class=\"col-xs-12 col-sm-6\">\r\n                    <input type=\"text\" name=\"char1\" value=\"" . $storeValues["char1"] . "\" class=\"form-control\" id=\"char1\" tabindex=\"3\" maxlength=\"10\" required=\"required\" />\r\n                </div>\r\n            </div>\r\n            <div class=\"form-group\">\r\n                " . lang("transferaccount_txt_23", true) . "\r\n            </div>\r\n        </div>\r\n    </div>";
                } else {
                    echo "<input type=\"hidden\" name=\"" . Encode("oldCharacter1") . "\" value=\"" . Encode($oldChar1) . "\"/>";
                }
                if ($showCharacter2) {
                    echo "\r\n    <div class=\"row\">\r\n        <div class=\"col-xs-12 col-md-6 col-md-offset-3 column\">\r\n            <div class=\"form-group\">\r\n                <label for=\"char2\" class=\"col-sm-3 control-label\">" . sprintf(lang("transferaccount_txt_22", true), 2, $showCharacter2Name) . "</label>\r\n                <div class=\"col-xs-12 col-sm-6\">\r\n                    <input type=\"text\" name=\"char2\" value=\"" . $storeValues["char2"] . "\" class=\"form-control\" id=\"char2\" tabindex=\"4\" maxlength=\"10\" required=\"required\" />\r\n                </div>\r\n            </div>\r\n            <div class=\"form-group\">\r\n                " . lang("transferaccount_txt_23", true) . "\r\n            </div>\r\n        </div>\r\n    </div>";
                } else {
                    echo "<input type=\"hidden\" name=\"" . Encode("oldCharacter2") . "\" value=\"" . Encode($oldChar2) . "\"/>";
                }
                if ($showCharacter3) {
                    echo "\r\n    <div class=\"row\">\r\n        <div class=\"col-xs-12 col-md-6 col-md-offset-3 column\">\r\n            <div class=\"form-group\">\r\n                <label for=\"char3\" class=\"col-sm-3 control-label\">" . sprintf(lang("transferaccount_txt_22", true), 3, $showCharacter3Name) . "</label>\r\n                <div class=\"col-xs-12 col-sm-6\">\r\n                    <input type=\"text\" name=\"char3\" value=\"" . $storeValues["char3"] . "\" class=\"form-control\" id=\"char3\" tabindex=\"5\" maxlength=\"10\" required=\"required\" />\r\n                </div>\r\n            </div>\r\n            <div class=\"form-group\">\r\n                " . lang("transferaccount_txt_23", true) . "\r\n            </div>\r\n        </div>\r\n    </div>";
                } else {
                    echo "<input type=\"hidden\" name=\"" . Encode("oldCharacter3") . "\" value=\"" . Encode($oldChar3) . "\"/>";
                }
                if ($showCharacter4) {
                    echo "\r\n    <div class=\"row\">\r\n        <div class=\"col-xs-12 col-md-6 col-md-offset-3 column\">\r\n            <div class=\"form-group\">\r\n                <label for=\"char4\" class=\"col-sm-3 control-label\">" . sprintf(lang("transferaccount_txt_22", true), 4, $showCharacter4Name) . "</label>\r\n                <div class=\"col-xs-12 col-sm-6\">\r\n                    <input type=\"text\" name=\"char4\" value=\"" . $storeValues["char4"] . "\" class=\"form-control\" id=\"char4\" tabindex=\"6\" maxlength=\"10\" required=\"required\" />\r\n                </div>\r\n            </div>\r\n            <div class=\"form-group\">\r\n                " . lang("transferaccount_txt_23", true) . "\r\n            </div>\r\n        </div>\r\n    </div>";
                } else {
                    echo "<input type=\"hidden\" name=\"" . Encode("oldCharacter4") . "\" value=\"" . Encode($oldChar4) . "\"/>";
                }
                if ($showCharacter5) {
                    echo "\r\n    <div class=\"row\">\r\n        <div class=\"col-xs-12 col-md-6 col-md-offset-3 column\">\r\n            <div class=\"form-group\">\r\n                <label for=\"char5\" class=\"col-sm-3 control-label\">" . sprintf(lang("transferaccount_txt_22", true), 5, $showCharacter5Name) . "</label>\r\n                <div class=\"col-xs-12 col-sm-6\">\r\n                    <input type=\"text\" name=\"char5\" value=\"" . $storeValues["char5"] . "\" class=\"form-control\" id=\"char5\" tabindex=\"7\" maxlength=\"10\" required=\"required\" />\r\n                </div>\r\n            </div>\r\n            <div class=\"form-group\">\r\n                " . lang("transferaccount_txt_23", true) . "\r\n            </div>\r\n        </div>\r\n    </div>";
                } else {
                    echo "<input type=\"hidden\" name=\"" . Encode("oldCharacter5") . "\" value=\"" . Encode($oldChar5) . "\"/>";
                }
                if ($showCharacter1 || $showCharacter2 || $showCharacter3 || $showCharacter4 || $showCharacter5) {
                    echo "\r\n    <div class=\"separator\"></div>";
                }
                echo "\r\n    <div class=\"row\">\r\n        <div class=\"col-xs-12 col-md-6 col-md-offset-3 column\">\r\n            <div class=\"form-group\">\r\n                <label for=\"register-country\" class=\"col-sm-3 control-label\">" . lang("transferaccount_txt_16", true) . "</label>\r\n                <div class=\"col-xs-12 col-sm-6\">\r\n                    <select name=\"country\" class=\"form-control\" tabindex=\"8\" required=\"required\">";
                $ip_info = $common->ip_info($_SERVER["REMOTE_ADDR"]);
                foreach ($custom["countries"] as $key => $thisCountry) {
                    if ($storeValues["country"] == $key) {
                        echo "<option value=\"" . $key . "\" selected=\"selected\">" . $thisCountry . "</option>";
                    } else {
                        if (strtolower($ip_info["country_code"]) == $key) {
                            echo "<option value=\"" . $key . "\" selected=\"selected\">" . $thisCountry . "</option>";
                        } else {
                            echo "<option value=\"" . $key . "\">" . $thisCountry . "</option>";
                        }
                    }
                }
                echo "\r\n                    </select>\r\n                </div>\r\n            </div>\r\n            <div class=\"form-group\">\r\n                <label for=\"question\" class=\"col-sm-3 control-label\">" . lang("transferaccount_txt_17", true) . "</label>\r\n                <div class=\"col-xs-12 col-sm-6\">\r\n                    <select name=\"question\" class=\"form-control\" tabindex=\"9\" required=\"required\">\r\n                        " . $questions . "\r\n                    </select>\r\n                </div>\r\n            </div>\r\n            <div class=\"form-group\">\r\n                <label for=\"answer\" class=\"col-sm-3 control-label\">" . lang("transferaccount_txt_18", true) . "</label>\r\n                <div class=\"col-xs-12 col-sm-6\">\r\n                    <input type=\"text\" class=\"form-control\" name=\"answer\" id=\"answer\" value=\"" . $storeValues["answer"] . "\" tabindex=\"10\" maxlength=\"100\" required=\"required\" />\r\n                </div>\r\n            </div>\r\n            <div class=\"form-group separator\">\r\n                <div class=\"col-xs-12 col-sm-offset-3 col-sm-6\">\r\n                    <input type=\"submit\" name=\"submit\" tabindex=\"11\" class=\"btn btn-warning\" style=\"width: 100%;\" value=\"" . lang("transferaccount_txt_19", true) . "\" />\r\n                    <input type=\"hidden\" name=\"" . Encode("username_hidden") . "\" value=\"" . Encode($username) . "\"/>\r\n                    <input type=\"hidden\" name=\"" . Encode("password_hidden") . "\" value=\"" . Encode($password) . "\"/>\r\n                    <input type=\"hidden\" name=\"" . Encode("info_hidden") . "\" value=\"" . Encode($showCharacterAccount . ";" . $showCharacterEmail . ";" . $showCharacter1 . ";" . $showCharacter2 . ";" . $showCharacter3 . ";" . $showCharacter4 . ";" . $showCharacter5) . "\"/>\r\n                    <input type=\"hidden\" name=\"step\" value=\"" . Encode("verify") . "\"/>\r\n                    <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                </div>\r\n            </div>\r\n        </div>\r\n    </div>\r\n</form>";
            } else {
                echo "\r\n<div class=\"page-desc-holder\">\r\n    " . lang("transferaccount_txt_21", true) . "<br>" . $showCharacterAccountMsg . " " . $showCharacterEmailMsg . "\r\n    " . $showCharacter1Msg . " " . $showCharacter2Msg . " " . $showCharacter3Msg . " " . $showCharacter4Msg . " " . $showCharacter5Msg . "\r\n    " . $showCharacterAnswerMsg . " " . $showCharacterCountryMsg . "\r\n</div>\r\n<div class=\"container_3\" align=\"center\">\r\n    <form action=\"\" method=\"post\">";
                if ($showCharacterAccount) {
                    echo "\r\n        <div class=\"row\" style=\"height: 50px;\">\r\n            <label for=\"username\">" . lang("transferaccount_txt_5", true) . "</label>\r\n            <input type=\"text\" name=\"username\" id=\"username\" value=\"" . $storeValues["username"] . "\" tabindex=\"1\" maxlength=\"10\" required=\"required\" />\r\n            <br /><br /><br />\r\n            <small style=\"float: right;\">" . lang("transferaccount_txt_23", true) . "</small>\r\n        </div>\r\n        <div class=\"seperator\"></div>";
                } else {
                    echo "<input type=\"hidden\" name=\"" . Encode("oldUsername") . "\" value=\"" . Encode($username) . "\"/>";
                }
                if ($showCharacterEmail) {
                    echo "\r\n        <div class=\"row\">\r\n            <label for=\"email\">" . lang("transferaccount_txt_8", true) . "</label>\r\n            <input type=\"text\" name=\"email\" id=\"email\" value=\"" . $storeValues["email"] . "\" tabindex=\"2\" required=\"required\" />\r\n        </div>\r\n        <div class=\"seperator\"></div>";
                } else {
                    echo "<input type=\"hidden\" name=\"" . Encode("oldEmail") . "\" value=\"" . Encode($oldEmail) . "\"/>";
                }
                if ($showCharacter1) {
                    echo "\r\n        <div class=\"row\" style=\"height: 50px;\">\r\n            <label for=\"char1\">" . sprintf(lang("transferaccount_txt_22", true), 1, $showCharacter1Name) . "</label>\r\n            <input type=\"text\" name=\"char1\" id=\"char1\" value=\"" . $storeValues["char1"] . "\" tabindex=\"3\" maxlength=\"10\" required=\"required\" />\r\n            <br /><br /><br />\r\n            <small style=\"float: right;\">" . lang("transferaccount_txt_23", true) . "</small>\r\n        </div>";
                } else {
                    echo "<input type=\"hidden\" name=\"" . Encode("oldCharacter1") . "\" value=\"" . Encode($oldChar1) . "\"/>";
                }
                if ($showCharacter2) {
                    echo "\r\n        <div class=\"row\" style=\"height: 50px;\">\r\n            <label for=\"char2\">" . sprintf(lang("transferaccount_txt_22", true), 2, $showCharacter2Name) . "</label>\r\n            <input type=\"text\" name=\"char2\" id=\"char2\" value=\"" . $storeValues["char2"] . "\" tabindex=\"4\" maxlength=\"10\" required=\"required\" />\r\n            <br /><br /><br />\r\n            <small style=\"float: right;\">" . lang("transferaccount_txt_23", true) . "</small>\r\n        </div>";
                } else {
                    echo "<input type=\"hidden\" name=\"" . Encode("oldCharacter2") . "\" value=\"" . Encode($oldChar2) . "\"/>";
                }
                if ($showCharacter3) {
                    echo "\r\n        <div class=\"row\" style=\"height: 50px;\">\r\n            <label for=\"char3\">" . sprintf(lang("transferaccount_txt_22", true), 3, $showCharacter3Name) . "</label>\r\n            <input type=\"text\" name=\"char3\" id=\"char3\" value=\"" . $storeValues["char3"] . "\" tabindex=\"5\" maxlength=\"10\" required=\"required\" />\r\n            <br /><br /><br />\r\n            <small style=\"float: right;\">" . lang("transferaccount_txt_23", true) . "</small>\r\n        </div>";
                } else {
                    echo "<input type=\"hidden\" name=\"" . Encode("oldCharacter3") . "\" value=\"" . Encode($oldChar3) . "\"/>";
                }
                if ($showCharacter4) {
                    echo "\r\n        <div class=\"row\" style=\"height: 50px;\">\r\n            <label for=\"char4\">" . sprintf(lang("transferaccount_txt_22", true), 4, $showCharacter4Name) . "</label>\r\n            <input type=\"text\" name=\"char4\" id=\"char4\" value=\"" . $storeValues["char4"] . "\" tabindex=\"6\" maxlength=\"10\" required=\"required\" />\r\n            <br /><br /><br />\r\n            <small style=\"float: right;\">" . lang("transferaccount_txt_23", true) . "</small>\r\n        </div>";
                } else {
                    echo "<input type=\"hidden\" name=\"" . Encode("oldCharacter4") . "\" value=\"" . Encode($oldChar4) . "\"/>";
                }
                if ($showCharacter5) {
                    echo "\r\n        <div class=\"row\" style=\"height: 50px;\">\r\n            <label for=\"char5\">" . sprintf(lang("transferaccount_txt_22", true), 5, $showCharacter5Name) . "</label>\r\n            <input type=\"text\" name=\"char5\" id=\"char5\" value=\"" . $storeValues["char5"] . "\" tabindex=\"7\" maxlength=\"10\" required=\"required\" />\r\n            <br /><br /><br />\r\n            <small style=\"float: right;\">" . lang("transferaccount_txt_23", true) . "</small>\r\n        </div>";
                } else {
                    echo "<input type=\"hidden\" name=\"" . Encode("oldCharacter5") . "\" value=\"" . Encode($oldChar5) . "\"/>";
                }
                if ($showCharacter1 || $showCharacter2 || $showCharacter3 || $showCharacter4 || $showCharacter5) {
                    echo "\r\n        <div class=\"seperator\"></div>";
                }
                echo "\r\n        <div class=\"row\">\r\n            <label for=\"register-country\">" . lang("transferaccount_txt_16", true) . "</label>\r\n            <select name=\"country\" styled=\"true\" id=\"select-style-2\" style=\"display: none;\" required=\"required\">";
                $ip_info = $common->ip_info($_SERVER["REMOTE_ADDR"]);
                foreach ($custom["countries"] as $key => $thisCountry) {
                    if ($storeValues["country"] == $key) {
                        echo "<option value=\"" . $key . "\" selected=\"selected\">" . $thisCountry . "</option>";
                    } else {
                        if (strtolower($ip_info["country_code"]) == $key) {
                            echo "<option value=\"" . $key . "\" selected=\"selected\">" . $thisCountry . "</option>";
                        } else {
                            echo "<option value=\"" . $key . "\">" . $thisCountry . "</option>";
                        }
                    }
                }
                echo "\r\n            </select>\r\n        </div>\r\n        <div class=\"row\">\r\n            <label for=\"question\">" . lang("transferaccount_txt_17", true) . "</label>\r\n            <select name=\"question\" styled=\"true\" id=\"select-style-2\" style=\"display: none;\" tabindex=\"8\" required=\"required\">\r\n                " . $questions . "\r\n            </select>\r\n        </div>\r\n        <div class=\"row\">\r\n            <label for=\"answer\">" . lang("transferaccount_txt_18", true) . "</label>\r\n            <input type=\"text\" name=\"answer\" id=\"answer\" value=\"" . $storeValues["answer"] . "\" tabindex=\"9\" maxlength=\"100\" required=\"required\" />\r\n        </div>\r\n        <div class=\"row\" align=\"right\">\r\n            <input type=\"submit\" name=\"submit\" tabindex=\"10\" value=\"" . lang("transferaccount_txt_19", true) . "\" />\r\n            <input type=\"hidden\" name=\"" . Encode("username_hidden") . "\" value=\"" . Encode($username) . "\"/>\r\n            <input type=\"hidden\" name=\"" . Encode("password_hidden") . "\" value=\"" . Encode($password) . "\"/>\r\n            <input type=\"hidden\" name=\"" . Encode("info_hidden") . "\" value=\"" . Encode($showCharacterAccount . ";" . $showCharacterEmail . ";" . $showCharacter1 . ";" . $showCharacter2 . ";" . $showCharacter3 . ";" . $showCharacter4 . ";" . $showCharacter5) . "\"/>\r\n            <input type=\"hidden\" name=\"step\" value=\"" . Encode("verify") . "\"/>\r\n            <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n        </div>\r\n    </form>\r\n</div>";
            }
        }
        if ($showVerification) {
            if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
                echo "\r\n<div class=\"row\">\r\n    <div class=\"col-xs-12 col-md-6 col-md-offset-3 column\">\r\n        <form action=\"\" method=\"post\" class=\"form-horizontal\">\r\n            <div class=\"form-group\">\r\n                " . lang("transferaccount_txt_36", true) . "\r\n            </div>\r\n            <div class=\"form-group separator\">\r\n                <div class=\"col-xs-12 col-sm-offset-3 col-sm-6\">\r\n                    <input type=\"submit\" name=\"submit\" class=\"btn btn-warning\" style=\"width: 100%;\" tabindex=\"1\" value=\"" . lang("transferaccount_txt_34", true) . "\" />\r\n                    <input type=\"hidden\" name=\"" . Encode("data_hidden") . "\" value=\"" . Encode($newUsername . ";" . $newEmail . ";" . $newChar1 . ";" . $newChar2 . ";" . $newChar3 . ";" . $newChar4 . ";" . $newChar5 . ";" . $country . ";" . $question . ";" . $answer . ";" . $username . ";" . $password) . "\"/>\r\n                    <input type=\"hidden\" name=\"step\" value=\"" . Encode("send") . "\"/>\r\n                    <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                </div>\r\n            </div>\r\n        </form>\r\n    </div>\r\n</div>";
            } else {
                echo "\r\n<div class=\"container_3\" align=\"center\">\r\n    <form action=\"\" method=\"post\">\r\n        <div class=\"row\" style=\"height: 70px;\">\r\n            <label for=\"answer\">" . lang("transferaccount_txt_36", true) . "</label>\r\n        </div>\r\n        <div class=\"seperator\"></div>\r\n        <div class=\"row\" align=\"right\">\r\n            <input type=\"submit\" name=\"submit\" tabindex=\"1\" value=\"" . lang("transferaccount_txt_34", true) . "\" />\r\n            <input type=\"hidden\" name=\"" . Encode("data_hidden") . "\" value=\"" . Encode($newUsername . ";" . $newEmail . ";" . $newChar1 . ";" . $newChar2 . ";" . $newChar3 . ";" . $newChar4 . ";" . $newChar5 . ";" . $country . ";" . $question . ";" . $answer . ";" . $username . ";" . $password) . "\"/>\r\n            <input type=\"hidden\" name=\"step\" value=\"" . Encode("send") . "\"/>\r\n            <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n        </div>\r\n    </form>\r\n</div>";
            }
        }
    } else {
        message("error", lang("error_17", true));
    }
    fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] END (TRANSFER) ====================================================================" . PHP_EOL);
    fclose($fp);
    if (!(defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE")) {
        echo "\r\n</div>";
    }
}

?>