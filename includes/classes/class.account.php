<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class Account extends common
{
    public function registerAccount($username, $password, $cpassword, $email, $question = NULL, $answer = NULL, $country = NULL, $referral, $forumUsername = NULL, $firstName = NULL, $lastName = NULL)
    {
        global $common;
        global $dB;
        global $dB2;
        global $config;
        $question = xss_clean($question);
        $answer = xss_clean($answer);
        $country = xss_clean($country);
        $referral = xss_clean($referral);
        $firstName = xss_clean($firstName);
        $lastName = xss_clean($lastName);
        if (!check_value($username)) {
            message("error", lang("error_4", true));
        } else {
            if (!check_value($password)) {
                message("error", lang("error_4", true));
            } else {
                if (!check_value($cpassword)) {
                    message("error", lang("error_4", true));
                } else {
                    if (!check_value($email)) {
                        message("error", lang("error_4", true));
                    } else {
                        if (!check_value($question) && mconfig("reg_secret_qa")) {
                            message("error", lang("error_4", true));
                        } else {
                            if (!check_value($answer) && mconfig("reg_secret_qa")) {
                                message("error", lang("error_4", true));
                            } else {
                                if (!check_value($country) && mconfig("reg_country")) {
                                    message("error", lang("error_4", true));
                                } else {
                                    if (!check_value($firstName) && mconfig("reg_first_last_name")) {
                                        message("error", lang("error_4", true));
                                    } else {
                                        if (!check_value($lastName) && mconfig("reg_first_last_name")) {
                                            message("error", lang("error_4", true));
                                        } else {
                                            if (!Validator::UsernameLength($username)) {
                                                message("error", lang("error_5", true));
                                            } else {
                                                if (!Validator::AlphaNumeric($username)) {
                                                    message("error", lang("error_6", true));
                                                } else {
                                                    if (!Validator::PasswordLength($password)) {
                                                        message("error", lang("error_7", true));
                                                    } else {
                                                        if ($password != $cpassword) {
                                                            message("error", lang("error_8", true));
                                                        } else {
                                                            if (!Validator::Email($email)) {
                                                                message("error", lang("error_9", true));
                                                            } else {
                                                                if (!Validator::AlphaNumeric($answer) && mconfig("reg_secret_qa")) {
                                                                    message("error", lang("error_62", true));
                                                                } else {
                                                                    if (100 < strlen($answer) && mconfig("reg_secret_qa")) {
                                                                        message("error", lang("error_63", true));
                                                                    } else {
                                                                        if (!Validator::AlphaNumeric($country) && mconfig("reg_country")) {
                                                                            message("error", lang("error_64", true));
                                                                        } else {
                                                                            if (2 < strlen($country) && mconfig("reg_country")) {
                                                                                message("error", lang("error_65", true));
                                                                            } else {
                                                                                if (255 < strlen($firstName) && mconfig("reg_first_last_name")) {
                                                                                    message("error", lang("register_txt_34", true));
                                                                                } else {
                                                                                    if (255 < strlen($lastName) && mconfig("reg_first_last_name")) {
                                                                                        message("error", lang("register_txt_35", true));
                                                                                    } else {
                                                                                        $regCfg = loadConfigurations("register");
                                                                                        if ($this->userExists($username)) {
                                                                                            message("error", lang("error_10", true));
                                                                                        } else {
                                                                                            if ($this->emailExists($email)) {
                                                                                                message("error", lang("error_11", true));
                                                                                            } else {
                                                                                                if ($regCfg["verify_email"]) {
                                                                                                    if ($this->checkUsernameEVS($username)) {
                                                                                                        message("error", lang("error_10", true));
                                                                                                    } else {
                                                                                                        if ($this->checkEmailEVS($email)) {
                                                                                                            message("error", lang("error_11", true));
                                                                                                        } else {
                                                                                                            $forumUsernameCreation = true;
                                                                                                            $ipb4Cfg = loadConfigurations("ipboardapi");
                                                                                                            if ($ipb4Cfg["create_account"]) {
                                                                                                                $forumUsernameCreation = $common->IPB_createMember("&name=" . $forumUsername . "&email=" . $email . "&password=" . $password . "&group=" . $ipb4Cfg["group_id"]);
                                                                                                            }
                                                                                                            if ($forumUsernameCreation) {
                                                                                                                $verificationKey = $this->createRegistrationVerification($username, $password, $email, $question, $answer, $country, $firstName, $lastName);
                                                                                                                if (!check_value($verificationKey)) {
                                                                                                                    message("error", lang("error_23", true));
                                                                                                                } else {
                                                                                                                    $this->sendRegistrationVerificationEmail($username, $email, $verificationKey);
                                                                                                                    if ($referral != NULL) {
                                                                                                                        $referral = Decode($referral);
                                                                                                                        if (!Validator::UsernameLength($referral)) {
                                                                                                                            message("error", lang("error_5", true));
                                                                                                                            return NULL;
                                                                                                                        }
                                                                                                                        if (!Validator::AlphaNumeric($referral)) {
                                                                                                                            message("error", lang("error_6", true));
                                                                                                                            return NULL;
                                                                                                                        }
                                                                                                                        if (!$this->userExists($referral)) {
                                                                                                                            message("error", lang("error_67", true));
                                                                                                                            return NULL;
                                                                                                                        }
                                                                                                                        $date = date("Y-m-d H:i:s", time());
                                                                                                                        $dB->query("INSERT INTO IMPERIAMUCMS_RECRUIT_A_FRIEND(AccountID_Friend,AccountID_Inviter,date,reward1_friend,reward1_inviter) VALUES(?,?,?,?,?)", [$username, $referral, $date, 0, 0]);
                                                                                                                        $logDate = date("Y-m-d H:i:s", time());
                                                                                                                        $common->accountLogs($referral, "recruit", sprintf(lang("register_txt_19", true), $username), $logDate);
                                                                                                                    }
                                                                                                                    if (mconfig("multiacc") == "1") {
                                                                                                                        if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                                                                                                            $checkCredits = $dB2->query_fetch_single("SELECT memb___id FROM MEMB_CREDITS WHERE memb___id = ?", [$username]);
                                                                                                                        } else {
                                                                                                                            $checkCredits = $dB->query_fetch_single("SELECT memb___id FROM MEMB_CREDITS WHERE memb___id = ?", [$username]);
                                                                                                                        }
                                                                                                                        if ($checkCredits != NULL && $checkCredits["memb___id"] == $username) {
                                                                                                                            $addCreditsQuery = false;
                                                                                                                        } else {
                                                                                                                            $addCreditsQuery = true;
                                                                                                                        }
                                                                                                                    } else {
                                                                                                                        $addCreditsQuery = true;
                                                                                                                    }
                                                                                                                    if ($addCreditsQuery) {
                                                                                                                        $cred_data = ["username" => $username, "plat" => 0, "plat_u" => 0, "gold" => 0, "gold_u" => 0, "silv" => 0, "silv_u" => 0];
                                                                                                                        $credits = "INSERT INTO MEMB_CREDITS(memb___id, platinum, platinum_used, gold, gold_used, silver, silver_used) VALUES(:username, :plat, :plat_u, :gold, :gold_u, :silv, :silv_u)";
                                                                                                                        if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                                                                                                            $result2 = $dB2->query($credits, $cred_data);
                                                                                                                        } else {
                                                                                                                            $result2 = $dB->query($credits, $cred_data);
                                                                                                                        }
                                                                                                                    }
                                                                                                                    message("success", lang("success_18", true));
                                                                                                                    if ($ipb4Cfg["create_account"]) {
                                                                                                                        message("success", sprintf(lang("register_txt_31", true), $forumUsername));
                                                                                                                    }
                                                                                                                }
                                                                                                            }
                                                                                                        }
                                                                                                    }
                                                                                                } else {
                                                                                                    $forumUsernameCreation = true;
                                                                                                    $ipb4Cfg = loadConfigurations("ipboardapi");
                                                                                                    if ($ipb4Cfg["create_account"]) {
                                                                                                        $forumUsernameCreation = $common->IPB_createMember("&name=" . $forumUsername . "&email=" . $email . "&password=" . $password . "&group=" . $ipb4Cfg["group_id"]);
                                                                                                    }
                                                                                                    if (!mconfig("reg_country")) {
                                                                                                        $country = NULL;
                                                                                                    }
                                                                                                    if (!mconfig("reg_secret_qa")) {
                                                                                                        $question = NULL;
                                                                                                        $answer = NULL;
                                                                                                    }
                                                                                                    if (!mconfig("reg_first_last_name")) {
                                                                                                        $firstName = NULL;
                                                                                                        $lastName = NULL;
                                                                                                    }
                                                                                                    if ($forumUsernameCreation) {
                                                                                                        $data = ["username" => $username, "password" => $password, "name" => $username, "serial" => "111111111111", "email" => $email, "date" => date("Y-m-d H:i:s", time()), "question" => $question, "answer" => $answer, "country" => $country, "firstName" => $firstName, "lastName" => $lastName];
                                                                                                        if ($this->_md5Enabled == "1") {
                                                                                                            $query = "INSERT INTO " . _TBL_MI_ . " (memb___id, memb__pwd, memb_name, sno__numb, mail_addr, appl_days, bloc_code, ctl1_code, SecretQuestion, SecretAnswer, Country, FirstName, LastName) VALUES (:username, [dbo].[fn_md5](:password, :username), :name, :serial, :email, :date, 0, 0, :question, :answer, :country, :firstName, :lastName)";
                                                                                                        } else {
                                                                                                            if ($this->_md5Enabled == "2") {
                                                                                                                $data["password"] = md5($data["password"]);
                                                                                                                $query = "INSERT INTO " . _TBL_MI_ . " (memb___id, memb__pwd, memb_name, sno__numb, mail_addr, appl_days, bloc_code, ctl1_code, SecretQuestion, SecretAnswer, Country, FirstName, LastName) VALUES (:username, :password, :name, :serial, :email, :date, 0, 0, :question, :answer, :country, :firstName, :lastName)";
                                                                                                            } else {
                                                                                                                $query = "INSERT INTO " . _TBL_MI_ . " (memb___id, memb__pwd, memb_name, sno__numb, mail_addr, appl_days, bloc_code, ctl1_code, SecretQuestion, SecretAnswer, Country, FirstName, LastName) VALUES (:username, :password, :name, :serial, :email, :date, 0, 0, :question, :answer, :country, :firstName, :lastName)";
                                                                                                            }
                                                                                                        }
                                                                                                        $result = $this->db->query($query, $data);
                                                                                                        if (!$result) {
                                                                                                            throw new Exception(lang("error_22", true));
                                                                                                        }
                                                                                                        $registerConfig = loadConfigurations("register");
                                                                                                        if ($registerConfig["vip_enable"]) {
                                                                                                            $vipEnd = time() + $registerConfig["vip_hours"] * 3600;
                                                                                                            $this->db->query("INSERT INTO T_VIPList (AccountID, Date, Type) VALUES (?, ?, ?)", [$username, date("Y-m-d H:i:s", $vipEnd), $registerConfig["vip_type"]]);
                                                                                                        }
                                                                                                        if ($referral != NULL) {
                                                                                                            $referral = Decode($referral);
                                                                                                            if (!Validator::UsernameLength($referral)) {
                                                                                                                message("error", lang("error_5", true));
                                                                                                                return NULL;
                                                                                                            }
                                                                                                            if (!Validator::AlphaNumeric($referral)) {
                                                                                                                message("error", lang("error_6", true));
                                                                                                                return NULL;
                                                                                                            }
                                                                                                            if (!$this->userExists($referral)) {
                                                                                                                throw new Exception("Invalid referral.");
                                                                                                            }
                                                                                                            $date = date("Y-m-d H:i:s", time());
                                                                                                            $dB->query("INSERT INTO IMPERIAMUCMS_RECRUIT_A_FRIEND(AccountID_Friend,AccountID_Inviter,date,reward1_friend,reward1_inviter) VALUES(?,?,?,?,?)", [$username, $referral, $date, 0, 0]);
                                                                                                            $logDate = date("Y-m-d H:i:s", time());
                                                                                                            $common->accountLogs($referral, "recruit", sprintf(lang("register_txt_19", true), $username), $logDate);
                                                                                                        }
                                                                                                        if (mconfig("multiacc") == "1") {
                                                                                                            if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                                                                                                $checkCredits = $dB2->query_fetch_single("SELECT memb___id FROM MEMB_CREDITS WHERE memb___id = ?", [$username]);
                                                                                                            } else {
                                                                                                                $checkCredits = $dB->query_fetch_single("SELECT memb___id FROM MEMB_CREDITS WHERE memb___id = ?", [$username]);
                                                                                                            }
                                                                                                            if ($checkCredits != NULL && $checkCredits["memb___id"] == $username) {
                                                                                                                $addCreditsQuery = false;
                                                                                                            } else {
                                                                                                                $addCreditsQuery = true;
                                                                                                            }
                                                                                                        } else {
                                                                                                            $addCreditsQuery = true;
                                                                                                        }
                                                                                                        if ($addCreditsQuery) {
                                                                                                            $cred_data = ["username" => $username, "plat" => 0, "plat_u" => 0, "gold" => 0, "gold_u" => 0, "silv" => 0, "silv_u" => 0];
                                                                                                            $credits = "INSERT INTO MEMB_CREDITS(memb___id, platinum, platinum_used, gold, gold_used, silver, silver_used) VALUES(:username, :plat, :plat_u, :gold, :gold_u, :silv, :silv_u)";
                                                                                                            if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                                                                                                $result2 = $dB2->query($credits, $cred_data);
                                                                                                            } else {
                                                                                                                $result2 = $dB->query($credits, $cred_data);
                                                                                                            }
                                                                                                        }
                                                                                                        if ($regCfg["send_welcome_email"]) {
                                                                                                            $this->sendWelcomeEmail($username, $email);
                                                                                                        }
                                                                                                        message("success", lang("success_1", true));
                                                                                                        if ($ipb4Cfg["create_account"]) {
                                                                                                            message("success", sprintf(lang("register_txt_31", true), $forumUsername));
                                                                                                        }
                                                                                                        redirect(2, "login/", 5);
                                                                                                    }
                                                                                                }
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    public function registerAccountTransfer($username, $password, $cpassword, $email, $question, $answer, $country, $referral, $keyxx)
    {
        global $common;
        global $dB;
        global $dB2;
        $question = xss_clean($question);
        $answer = xss_clean($answer);
        $country = xss_clean($country);
        $referral = xss_clean($referral);
        if (!check_value($username)) {
            message("error", lang("error_4", true));
        } else {
            if (!check_value($password)) {
                message("error", lang("error_4", true));
            } else {
                if (!check_value($cpassword)) {
                    message("error", lang("error_4", true));
                } else {
                    if (!check_value($email)) {
                        message("error", lang("error_4", true));
                    } else {
                        if (!check_value($question)) {
                            message("error", lang("error_4", true));
                        } else {
                            if (!check_value($answer)) {
                                message("error", lang("error_4", true));
                            } else {
                                if (!check_value($country)) {
                                    message("error", lang("error_4", true));
                                } else {
                                    if (!Validator::UsernameLength($username)) {
                                        message("error", lang("error_5", true));
                                    } else {
                                        if (!Validator::AlphaNumeric($username)) {
                                            message("error", lang("error_6", true));
                                        } else {
                                            if (!Validator::PasswordLength($password)) {
                                                message("error", lang("error_7", true));
                                            } else {
                                                if ($password != $cpassword) {
                                                    message("error", lang("error_8", true));
                                                } else {
                                                    if (!Validator::Email($email)) {
                                                        message("error", lang("error_9", true));
                                                    } else {
                                                        if (!Validator::AlphaNumeric($answer)) {
                                                            message("error", lang("error_62", true));
                                                        } else {
                                                            if (100 < strlen($answer)) {
                                                                message("error", lang("error_63", true));
                                                            } else {
                                                                if (!Validator::AlphaNumeric($country)) {
                                                                    message("error", lang("error_64", true));
                                                                } else {
                                                                    if (2 < strlen($country)) {
                                                                        message("error", lang("error_65", true));
                                                                    } else {
                                                                        $regCfg = loadConfigurations("register");
                                                                        if ($this->userExists($username)) {
                                                                            message("error", lang("error_10", true));
                                                                        } else {
                                                                            if ($this->emailExists($email)) {
                                                                                message("error", lang("error_11", true));
                                                                            } else {
                                                                                if ($regCfg["verify_email"]) {
                                                                                    if ($this->checkUsernameEVS($username)) {
                                                                                        message("error", lang("error_10", true));
                                                                                    } else {
                                                                                        if ($this->checkEmailEVS($email)) {
                                                                                            message("error", lang("error_11", true));
                                                                                        } else {
                                                                                            $verificationKey = $this->createRegistrationVerification($username, $password, $email, $question, $answer, $country, NULL, NULL);
                                                                                            if (!check_value($verificationKey)) {
                                                                                                message("error", lang("error_23", true));
                                                                                            } else {
                                                                                                $this->sendRegistrationVerificationEmailTransfer($username, $email, $verificationKey, $keyxx);
                                                                                                $cred_data = ["username" => $username, "plat" => 0, "plat_u" => 0, "gold" => 0, "gold_u" => 0, "silv" => 0, "silv_u" => 0];
                                                                                                $credits = "INSERT INTO MEMB_CREDITS(memb___id, platinum, platinum_used, gold, gold_used, silver, silver_used) VALUES(:username, :plat, :plat_u, :gold, :gold_u, :silv, :silv_u)";
                                                                                                if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                                                                                    $checkCredits = $dB2->query_fetch_single("SELECT memb___id FROM MEMB_CREDITS WHERE memb___id = ?", [$username]);
                                                                                                    if ($checkCredits["memb___id"] == NULL) {
                                                                                                        $result2 = $dB2->query($credits, $cred_data);
                                                                                                    }
                                                                                                } else {
                                                                                                    $checkCredits = $dB->query_fetch_single("SELECT memb___id FROM MEMB_CREDITS WHERE memb___id = ?", [$username]);
                                                                                                    if ($checkCredits["memb___id"] == NULL) {
                                                                                                        $result2 = $dB->query($credits, $cred_data);
                                                                                                    }
                                                                                                }
                                                                                                message("success", lang("success_18", true));
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                } else {
                                                                                    $data = ["username" => $username, "password" => $password, "name" => $username, "serial" => "111111111111", "email" => $email, "date" => date("Y-m-d H:i:s", time()), "question" => $question, "answer" => $answer, "country" => $country];
                                                                                    if ($this->_md5Enabled == "1") {
                                                                                        $query = "INSERT INTO " . _TBL_MI_ . " (memb___id, memb__pwd, memb_name, sno__numb, mail_addr, appl_days, bloc_code, ctl1_code, SecretQuestion, SecretAnswer, Country) VALUES (:username, [dbo].[fn_md5](:password, :username), :name, :serial, :email, :date, 0, 0, :question, :answer, :country)";
                                                                                    } else {
                                                                                        if ($this->_md5Enabled == "2") {
                                                                                            $data["password"] = md5($data["password"]);
                                                                                            $query = "INSERT INTO " . _TBL_MI_ . " (memb___id, memb__pwd, memb_name, sno__numb, mail_addr, appl_days, bloc_code, ctl1_code, SecretQuestion, SecretAnswer, Country) VALUES (:username, :password, :name, :serial, :email, :date, 0, 0, :question, :answer, :country)";
                                                                                        } else {
                                                                                            $query = "INSERT INTO " . _TBL_MI_ . " (memb___id, memb__pwd, memb_name, sno__numb, mail_addr, appl_days, bloc_code, ctl1_code, SecretQuestion, SecretAnswer, Country) VALUES (:username, :password, :name, :serial, :email, :date, 0, 0, :question, :answer, :country)";
                                                                                        }
                                                                                    }
                                                                                    $result = $this->db->query($query, $data);
                                                                                    if (!$result) {
                                                                                        throw new Exception(lang("error_22", true));
                                                                                    }
                                                                                    $cred_data = ["username" => $username, "plat" => 0, "plat_u" => 0, "gold" => 0, "gold_u" => 0, "silv" => 0, "silv_u" => 0];
                                                                                    $credits = "INSERT INTO MEMB_CREDITS(memb___id, platinum, platinum_used, gold, gold_used, silver, silver_used) VALUES(:username, :plat, :plat_u, :gold, :gold_u, :silv, :silv_u)";
                                                                                    if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                                                                        $checkCredits = $dB2->query_fetch_single("SELECT memb___id FROM MEMB_CREDITS WHERE memb___id = ?", [$username]);
                                                                                        if ($checkCredits["memb___id"] == NULL) {
                                                                                            $result2 = $dB2->query($credits, $cred_data);
                                                                                        }
                                                                                    } else {
                                                                                        $checkCredits = $dB->query_fetch_single("SELECT memb___id FROM MEMB_CREDITS WHERE memb___id = ?", [$username]);
                                                                                        if ($checkCredits["memb___id"] == NULL) {
                                                                                            $result2 = $dB->query($credits, $cred_data);
                                                                                        }
                                                                                    }
                                                                                    if ($regCfg["send_welcome_email"]) {
                                                                                        $this->sendWelcomeEmail($username, $email);
                                                                                    }
                                                                                    message("success", lang("transferaccount_txt_46", true));
                                                                                    redirect(2, "verifyemail/?op=" . Encode_id(5) . "&user=" . Encode($username) . "&key=" . $keyxx . "&keyxx=" . $keyxx, 5);
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    private function checkUsernameEVS($username)
    {
        if (!check_value($username)) {
            return NULL;
        }
        $result = $this->muonline->query_fetch_single("SELECT * FROM IMPERIAMUCMS_REGISTER_ACCOUNT WHERE registration_account = ?", [$username]);
        $configs = loadConfigurations("register");
        if (!is_array($configs)) {
            return NULL;
        }
        $timelimit = $result["registration_date"] + $configs["verification_timelimit"] * 3600;
        if (time() < $timelimit) {
            return true;
        }
        $this->deleteRegistrationVerification($username);
        return false;
    }
    private function deleteRegistrationVerification($username)
    {
        if (!check_value($username)) {
            return NULL;
        }
        $delete = $this->muonline->query("DELETE FROM IMPERIAMUCMS_REGISTER_ACCOUNT WHERE registration_account = ?", [$username]);
        if ($delete) {
            return true;
        }
        return NULL;
    }
    private function checkEmailEVS($email)
    {
        if (!check_value($email)) {
            return NULL;
        }
        $result = $this->muonline->query_fetch_single("SELECT * FROM IMPERIAMUCMS_REGISTER_ACCOUNT WHERE registration_email = ?", [$email]);
        $configs = loadConfigurations("register");
        if (!is_array($configs)) {
            return NULL;
        }
        $timelimit = $result["registration_date"] + $configs["verification_timelimit"] * 60 * 60;
        if (time() < $timelimit) {
            return true;
        }
        $this->deleteRegistrationVerification($result["registration_account"]);
        return false;
    }
    private function createRegistrationVerification($username, $password, $email, $question, $answer, $country, $firstName, $lastName)
    {
        if (!check_value($username)) {
            return NULL;
        }
        if (!check_value($password)) {
            return NULL;
        }
        if (!check_value($email)) {
            return NULL;
        }
        if (!check_value($question) && mconfig("reg_secret_qa")) {
            return NULL;
        }
        if (!check_value($answer) && mconfig("reg_secret_qa")) {
            return NULL;
        }
        if (!check_value($country) && mconfig("reg_country")) {
            return NULL;
        }
        if (!check_value($firstName) && mconfig("reg_first_last_name")) {
            return NULL;
        }
        if (!check_value($lastName) && mconfig("reg_first_last_name")) {
            return NULL;
        }
        $key = uniqid();
        $data = [$username, Encode($password), $email, time(), $_SERVER["REMOTE_ADDR"], $key, $question, $answer, $country, $firstName, $lastName];
        $query = "INSERT INTO IMPERIAMUCMS_REGISTER_ACCOUNT (registration_account,registration_password,registration_email,registration_date,registration_ip,registration_key,registration_question,registration_answer,registration_country,first_name,last_name) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
        $result = $this->muonline->query($query, $data);
        if (!$result) {
            return NULL;
        }
        return $key;
    }
    private function sendRegistrationVerificationEmail($username, $account_email, $key)
    {
        $verificationLink = __BASE_URL__ . "verifyemail/?op=" . Encode_id(2) . "&user=" . Encode($username) . "&key=" . $key;
        try {
            $email = new Email();
            $email->setTemplate("WELCOME_EMAIL_VERIFICATION");
            $email->addVariable("{USERNAME}", $username);
            $email->addVariable("{LINK}", $verificationLink);
            $email->addAddress($account_email);
            $email->send();
        } catch (Exception $ex) {
        }
    }
    private function sendRegistrationVerificationEmailTransfer($username, $account_email, $key, $keyxx)
    {
        $verificationLink = __BASE_URL__ . "verifyemail/?op=" . Encode_id(5) . "&user=" . Encode($username) . "&key=" . $key . "&keyxx=" . $keyxx;
        try {
            $email = new Email();
            $email->setTemplate("WELCOME_EMAIL_VERIFICATION");
            $email->addVariable("{USERNAME}", $username);
            $email->addVariable("{LINK}", $verificationLink);
            $email->addAddress($account_email);
            $email->send();
        } catch (Exception $ex) {
        }
    }
    private function sendWelcomeEmail($username, $address)
    {
        try {
            $email = new Email();
            $email->setTemplate("WELCOME_EMAIL");
            $email->addVariable("{USERNAME}", $username);
            $email->addAddress($address);
            $email->send();
        } catch (Exception $ex) {
        }
    }
    public function changePasswordProcess($userid, $username, $password, $new_password, $confirm_new_password)
    {
        global $common;
        if (!check_value($userid)) {
            message("error", lang("error_4", true));
        } else {
            if (!check_value($username)) {
                message("error", lang("error_4", true));
            } else {
                if (!check_value($password)) {
                    message("error", lang("error_4", true));
                } else {
                    if (!check_value($new_password)) {
                        message("error", lang("error_4", true));
                    } else {
                        if (!check_value($confirm_new_password)) {
                            message("error", lang("error_4", true));
                        } else {
                            if (!Validator::PasswordLength($new_password)) {
                                message("error", lang("error_7", true));
                            } else {
                                if ($new_password != $confirm_new_password) {
                                    message("error", lang("error_8", true));
                                } else {
                                    if (!$this->validateUser($username, $password)) {
                                        throw new Exception(lang("error_13", true));
                                    }
                                    if ($this->accountOnline($username)) {
                                        throw new Exception(lang("error_14", true));
                                    }
                                    if (!$this->changePassword($userid, $username, $new_password)) {
                                        message("error", lang("error_23", true));
                                    } else {
                                        $accountData = $this->accountInformation($userid);
                                        try {
                                            $email = new Email();
                                            $email->setTemplate("CHANGE_PASSWORD");
                                            $email->addVariable("{USERNAME}", $username);
                                            $email->addVariable("{NEW_PASSWORD}", $new_password);
                                            $email->addAddress($accountData[_CLMN_EMAIL_]);
                                            $email->send();
                                        } catch (Exception $ex) {
                                            message("success", lang("success_2", true));
                                            $logDate = date("Y-m-d H:i:s", time());
                                            $common->accountLogs($username, "changepass", lang("changepassword_txt_5", true), $logDate);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    public function changePasswordProcess_verifyEmail($userid, $username, $password, $new_password, $confirm_new_password, $ip_address)
    {
        global $common;
        global $config;
        if (!check_value($userid)) {
            message("error", lang("error_4", true));
        } else {
            if (!check_value($username)) {
                message("error", lang("error_4", true));
            } else {
                if (!check_value($password)) {
                    message("error", lang("error_4", true));
                } else {
                    if (!check_value($new_password)) {
                        message("error", lang("error_4", true));
                    } else {
                        if (!check_value($confirm_new_password)) {
                            message("error", lang("error_4", true));
                        } else {
                            if (!Validator::PasswordLength($new_password)) {
                                message("error", lang("error_7", true));
                            } else {
                                if ($new_password != $confirm_new_password) {
                                    message("error", lang("error_8", true));
                                } else {
                                    $mypassCfg = loadConfigurations("usercp.mypassword");
                                    if (!$this->validateUser($username, $password)) {
                                        throw new Exception(lang("error_13", true));
                                    }
                                    if ($this->accountOnline($username)) {
                                        throw new Exception(lang("error_14", true));
                                    }
                                    if ($this->hasActivePasswordChangeRequest($userid)) {
                                        throw new Exception(lang("error_19", true));
                                    }
                                    $accountData = $this->accountInformation($userid);
                                    if (!is_array($accountData)) {
                                        throw new Exception(lang("error_21", true));
                                    }
                                    $auth_code = mt_rand(111111, 999999);
                                    $link = $this->generatePasswordChangeVerificationURL($userid, $auth_code);
                                    $addRequest = $this->addPasswordChangeRequest($userid, $new_password, $auth_code);
                                    if (!$addRequest) {
                                        throw new Exception(lang("error_21", true));
                                    }
                                    try {
                                        $email = new Email();
                                        $email->setTemplate("CHANGE_PASSWORD_EMAIL_VERIFICATION");
                                        $email->addVariable("{USERNAME}", $username);
                                        $email->addVariable("{DATE}", date($config["time_date_format"]));
                                        $email->addVariable("{IP_ADDRESS}", $ip_address);
                                        $email->addVariable("{LINK}", $link);
                                        $email->addVariable("{EXPIRATION_TIME}", $mypassCfg["change_password_request_timeout"]);
                                        $email->addAddress($accountData[_CLMN_EMAIL_]);
                                        $email->send();
                                        message("success", lang("success_3", true));
                                        $logDate = date("Y-m-d H:i:s", time());
                                        $common->accountLogs($username, "changepass", lang("changepassword_txt_5", true), $logDate);
                                    } catch (Exception $ex) {
                                        message("error", lang("error_20", true));
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    public function changePasswordVerificationProcess($user_id, $auth_code)
    {
        while (!check_value($user_id)) {
            if (!check_value($auth_code)) {
                throw new Exception(lang("error_24", true));
            }
            $userid = Decode_id($user_id);
            $authcode = Decode_id($auth_code);
            if (!Validator::UnsignedNumber($userid)) {
                throw new Exception(lang("error_25", true));
            }
            if (!Validator::UnsignedNumber($authcode)) {
                throw new Exception(lang("error_25", true));
            }
            $result = $this->muonline->query_fetch_single("SELECT * FROM IMPERIAMUCMS_PASSCHANGE_REQUEST WHERE user_id = ?", [$userid]);
            if (!is_array($result)) {
                throw new Exception(lang("error_25", true));
            }
            $mypassCfg = loadConfigurations("usercp.mypassword");
            $request_timeout = $mypassCfg["change_password_request_timeout"] * 3600;
            $request_date = $result["request_date"] + $request_timeout;
            if ($request_date < time()) {
                throw new Exception(lang("error_26", true));
            }
            if ($result["auth_code"] != $authcode) {
                throw new Exception(lang("error_27", true));
            }
            $accountData = $this->accountInformation($userid);
            $username = $accountData[_CLMN_USERNM_];
            $new_password = Decode($result["new_password"]);
            if ($this->accountOnline($username)) {
                throw new Exception(lang("error_14", true));
            }
            if (!$this->changePassword($userid, $username, $new_password)) {
                throw new Exception(lang("error_29", true));
            }
            try {
                $email = new Email();
                $email->setTemplate("CHANGE_PASSWORD");
                $email->addVariable("{USERNAME}", $username);
                $email->addVariable("{NEW_PASSWORD}", $new_password);
                $email->addAddress($accountData[_CLMN_EMAIL_]);
                $email->send();
            } catch (Exception $ex) {
                $this->removePasswordChangeRequest($userid);
                message("success", lang("success_5", true));
            }
        }
        throw new Exception(lang("error_24", true));
    }
    public function passwordRecoveryProcess($user_email, $ip_address, $username = NULL)
    {
        global $config;
        if (!check_value($user_email)) {
            throw new Exception(lang("error_30", true));
        }
        if (!check_value($ip_address)) {
            throw new Exception(lang("error_30", true));
        }
        if (!Validator::Email($user_email)) {
            throw new Exception(lang("error_30", true));
        }
        if (!Validator::Ip($ip_address)) {
            throw new Exception(lang("error_30", true));
        }
        if (!$this->emailExists($user_email, true)) {
            throw new Exception(lang("error_30", true));
        }
        if ($username == NULL) {
            $user_id = $this->retrieveUserIDbyEmail($user_email);
        } else {
            $user_id = $this->retrieveUserID($username);
        }
        if (!check_value($user_id)) {
            message("error", lang("error_23", true));
        } else {
            $accountData = $this->accountInformation($user_id);
            if (!is_array($accountData)) {
                message("error", lang("error_23", true));
            } else {
                if ($accountData["mail_addr"] != $user_email) {
                    message("error", lang("forgotpass_txt_5", true));
                } else {
                    $cfg = loadConfigurations("register");
                    if ($cfg["multiacc"] == "1" && $accountData["mail_addr"] != $user_email) {
                        message("error", lang("error_30", true));
                    } else {
                        $arc = $this->generateAccountRecoveryCode($accountData[_CLMN_MEMBID_], $accountData[_CLMN_USERNM_]);
                        $aru = $this->generateAccountRecoveryLink($accountData[_CLMN_MEMBID_], $accountData[_CLMN_EMAIL_], $arc);
                        try {
                            $email = new Email();
                            $email->setTemplate("PASSWORD_RECOVERY_REQUEST");
                            $email->addVariable("{USERNAME}", $accountData[_CLMN_USERNM_]);
                            $email->addVariable("{DATE}", date($config["time_date_format"]));
                            $email->addVariable("{IP_ADDRESS}", $ip_address);
                            $email->addVariable("{LINK}", $aru);
                            $email->addAddress($accountData[_CLMN_EMAIL_]);
                            $email->send();
                            message("success", lang("success_6", true));
                        } catch (Exception $ex) {
                            throw new Exception(lang("error_23", true));
                        }
                    }
                }
            }
        }
    }
    private function generateAccountRecoveryLink($userid, $email, $recovery_code)
    {
        if (!check_value($userid)) {
            return NULL;
        }
        if (!check_value($recovery_code)) {
            return NULL;
        }
        $build_url = __BASE_URL__;
        $build_url .= "forgotpassword/";
        $build_url .= "?ui=";
        $build_url .= Encode($userid);
        $build_url .= "&ue=";
        $build_url .= Encode($email);
        $build_url .= "&key=";
        $build_url .= $recovery_code;
        return $build_url;
    }
    public function passwordRecoveryVerificationProcess($ui, $ue, $key)
    {
        while (!check_value($ui)) {
            if (!check_value($ue)) {
                throw new Exception(lang("error_31", true));
            }
            if (!check_value($key)) {
                throw new Exception(lang("error_31", true));
            }
            $user_id = Decode($ui);
            if (!Validator::UnsignedNumber($user_id)) {
                throw new Exception(lang("error_31", true));
            }
            $user_email = Decode($ue);
            if (!$this->emailExists($user_email, true)) {
                throw new Exception(lang("error_31", true));
            }
            $accountData = $this->accountInformation($user_id);
            if (!is_array($accountData)) {
                throw new Exception(lang("error_31", true));
            }
            $cfg = loadConfigurations("register");
            if ($cfg["multiacc"] == "1" && $accountData["mail_addr"] != $user_email) {
                throw new Exception(lang("error_31", true));
            }
            $username = $accountData[_CLMN_USERNM_];
            $gen_key = $this->generateAccountRecoveryCode($user_id, $username);
            if ($key != $gen_key) {
                throw new Exception(lang("error_31", true));
            }
            $new_password = rand(11111111, 99999999);
            $update_pass = $this->changePassword($user_id, $username, $new_password);
            if (!$update_pass) {
                throw new Exception(lang("error_23", true));
            }
            try {
                $email = new Email();
                $email->setTemplate("PASSWORD_RECOVERY_COMPLETED");
                $email->addVariable("{USERNAME}", $username);
                $email->addVariable("{NEW_PASSWORD}", $new_password);
                $email->addAddress($accountData[_CLMN_EMAIL_]);
                $email->send();
                message("success", lang("success_7", true));
            } catch (Exception $ex) {
                throw new Exception(lang("error_23", true));
            }
        }
        throw new Exception(lang("error_31", true));
    }
    public function changeEmailAddress($accountId, $newEmail, $ipAddress)
    {
        if (!check_value($accountId)) {
            throw new Exception(lang("error_21", true));
        }
        if (!check_value($newEmail)) {
            throw new Exception(lang("error_21", true));
        }
        if (!check_value($ipAddress)) {
            throw new Exception(lang("error_21", true));
        }
        if (!Validator::Ip($ipAddress)) {
            throw new Exception(lang("error_21", true));
        }
        if (!Validator::Email($newEmail)) {
            throw new Exception(lang("error_21", true));
        }
        if ($this->emailExists($newEmail)) {
            message("error", lang("error_11", true));
        } else {
            $accountInfo = $this->accountInformation($accountId);
            if (!is_array($accountInfo)) {
                throw new Exception(lang("error_21", true));
            }
            $userName = $accountInfo[_CLMN_USERNM_];
            $userEmail = $accountInfo[_CLMN_EMAIL_];
            $requestDate = strtotime(date("m/d/Y 23:59"));
            $key = md5(md5($userName) . md5($userEmail) . md5($requestDate) . md5($newEmail));
            $verificationLink = __BASE_URL__ . "verifyemail/?op=" . Encode_id(3) . "&uid=" . Encode_id($accountId) . "&email=" . $newEmail . "&key=" . $key;
            $sendEmail = $this->changeEmailVerificationMail($userName, $userEmail, $newEmail, $verificationLink, $ipAddress);
            if (!$sendEmail) {
                throw new Exception(lang("error_21", true));
            }
        }
    }
    private function changeEmailVerificationMail($userName, $emailAddress, $newEmail, $verificationLink, $ipAddress)
    {
        try {
            $email = new Email();
            $email->setTemplate("CHANGE_EMAIL_VERIFICATION");
            $email->addVariable("{USERNAME}", $userName);
            $email->addVariable("{IP_ADDRESS}", $ipAddress);
            $email->addVariable("{NEW_EMAIL}", $newEmail);
            $email->addVariable("{LINK}", $verificationLink);
            $email->addAddress($emailAddress);
            $email->send();
            return true;
        } catch (Exception $ex) {
        }
    }
    public function changeEmailVerificationProcess($encodedId, $newEmail, $encryptedKey)
    {
        $userId = Decode_id($encodedId);
        if (!Validator::UnsignedNumber($userId)) {
            throw new Exception(lang("error_21", true));
        }
        if (!Validator::Email($newEmail)) {
            throw new Exception(lang("error_21", true));
        }
        if ($this->emailExists($newEmail)) {
            message("error", lang("error_11", true));
        } else {
            $accountInfo = $this->accountInformation($userId);
            if (!is_array($accountInfo)) {
                throw new Exception(lang("error_21", true));
            }
            $requestDate = strtotime(date("m/d/Y 23:59"));
            $key = md5(md5($accountInfo[_CLMN_USERNM_]) . md5($accountInfo[_CLMN_EMAIL_]) . md5($requestDate) . md5($newEmail));
            if ($key != $encryptedKey) {
                throw new Exception(lang("error_21", true));
            }
            if (!$this->updateEmail($userId, $newEmail)) {
                throw new Exception(lang("error_21", true));
            }
        }
    }
    public function verifyRegistrationProcess($username, $key)
    {
        global $common;
        $verifyKey = $this->muonline->query_fetch_single("SELECT * FROM IMPERIAMUCMS_REGISTER_ACCOUNT WHERE registration_account = ? AND registration_key = ?", [$username, $key]);
        if (!is_array($verifyKey)) {
            throw new Exception(lang("error_25", true));
        }
        $regCfg = loadConfigurations("register");
        $data = ["username" => $verifyKey["registration_account"], "password" => Decode($verifyKey["registration_password"]), "name" => $verifyKey["registration_account"], "serial" => "111111111111", "email" => $verifyKey["registration_email"], "date" => date("Y-m-d H:i:s", time()), "question" => $verifyKey["registration_question"], "answer" => $verifyKey["registration_answer"], "country" => $verifyKey["registration_country"], "firstName" => $verifyKey["first_name"], "lastName" => $verifyKey["last_name"]];
        if ($this->_md5Enabled == "1") {
            $query = "INSERT INTO " . _TBL_MI_ . " (memb___id, memb__pwd, memb_name, sno__numb, mail_addr, appl_days, bloc_code, ctl1_code, SecretQuestion, SecretAnswer, Country, FirstName, LastName) VALUES (:username, [dbo].[fn_md5](:password, :username), :name, :serial, :email, :date, 0, 0, :question, :answer, :country, :firstName, :lastName)";
        } else {
            if ($this->_md5Enabled == "2") {
                $data["password"] = md5($data["password"]);
                $query = "INSERT INTO " . _TBL_MI_ . " (memb___id, memb__pwd, memb_name, sno__numb, mail_addr, appl_days, bloc_code, ctl1_code, SecretQuestion, SecretAnswer, Country, FirstName, LastName) VALUES (:username, :password, :name, :serial, :email, :date, 0, 0, :question, :answer, :country, :firstName, :lastName)";
            } else {
                $query = "INSERT INTO " . _TBL_MI_ . " (memb___id, memb__pwd, memb_name, sno__numb, mail_addr, appl_days, bloc_code, ctl1_code, SecretQuestion, SecretAnswer, Country, FirstName, LastName) VALUES (:username, :password, :name, :serial, :email, :date, 0, 0, :question, :answer, :country, :firstName, :lastName)";
            }
        }
        $result = $this->db->query($query, $data);
        if (!$result) {
            throw new Exception(lang("error_22", true));
        }
        $registerConfig = loadConfigurations("register");
        if ($registerConfig["vip_enable"]) {
            $vipEnd = time() + $registerConfig["vip_hours"] * 3600;
            $this->db->query("INSERT INTO T_VIPList (AccountID, Date, Type) VALUES (?, ?, ?)", [$verifyKey["registration_account"], date("Y-m-d H:i:s", $vipEnd), $registerConfig["vip_type"]]);
        }
        $this->deleteRegistrationVerification($username);
        if ($regCfg["send_welcome_email"]) {
            $this->sendWelcomeEmail($verifyKey["registration_account"], $verifyKey["registration_email"]);
        }
        message("success", lang("success_1", true));
        $logDate = date("Y-m-d H:i:s", time());
        $common->accountLogs($username, "register", lang("register_txt_20", true), $logDate);
        redirect(2, "login/", 5);
    }
    public function verifyRegistrationProcessTransfer($username, $key, $keyxx)
    {
        global $common;
        $verifyKey = $this->muonline->query_fetch_single("SELECT * FROM IMPERIAMUCMS_REGISTER_ACCOUNT WHERE registration_account = ? AND registration_key = ?", [$username, $key]);
        if (!is_array($verifyKey)) {
            throw new Exception(lang("error_25", true));
        }
        $regCfg = loadConfigurations("register");
        $data = ["username" => $verifyKey["registration_account"], "password" => Decode($verifyKey["registration_password"]), "name" => $verifyKey["registration_account"], "serial" => "111111111111", "email" => $verifyKey["registration_email"], "date" => date("Y-m-d H:i:s", time()), "question" => $verifyKey["registration_question"], "answer" => $verifyKey["registration_answer"], "country" => $verifyKey["registration_country"]];
        if ($this->_md5Enabled == "1") {
            $query = "INSERT INTO " . _TBL_MI_ . " (memb___id, memb__pwd, memb_name, sno__numb, mail_addr, appl_days, bloc_code, ctl1_code, SecretQuestion, SecretAnswer, Country) VALUES (:username, [dbo].[fn_md5](:password, :username), :name, :serial, :email, :date, 0, 0, :question, :answer, :country)";
        } else {
            if ($this->_md5Enabled == "2") {
                $data["password"] = md5($data["password"]);
                $query = "INSERT INTO " . _TBL_MI_ . " (memb___id, memb__pwd, memb_name, sno__numb, mail_addr, appl_days, bloc_code, ctl1_code, SecretQuestion, SecretAnswer, Country) VALUES (:username, :password, :name, :serial, :email, :date, 0, 0, :question, :answer, :country)";
            } else {
                $query = "INSERT INTO " . _TBL_MI_ . " (memb___id, memb__pwd, memb_name, sno__numb, mail_addr, appl_days, bloc_code, ctl1_code, SecretQuestion, SecretAnswer, Country) VALUES (:username, :password, :name, :serial, :email, :date, 0, 0, :question, :answer, :country)";
            }
        }
        $result = $this->db->query($query, $data);
        if (!$result) {
            throw new Exception(lang("error_22", true));
        }
        $this->deleteRegistrationVerification($username);
        if ($regCfg["send_welcome_email"]) {
            $this->sendWelcomeEmail($verifyKey["registration_account"], $verifyKey["registration_email"]);
        }
        $logDate = date("Y-m-d H:i:s", time());
        $common->accountLogs($username, "register", lang("register_txt_20", true), $logDate);
    }
    public function banAccount($username)
    {
        global $dB;
        global $dB2;
        if (!check_value($username)) {
            message("error", lang("error_4", true));
        } else {
            if (!Validator::UsernameLength($username)) {
                message("error", lang("error_5", true));
            } else {
                if (!Validator::AlphaNumeric($username)) {
                    message("error", lang("error_6", true));
                } else {
                    if (config("SQL_USE_2_DB", true)) {
                        $dB2->query("UPDATE MEMB_INFO SET bloc_code = ? WHERE memb___id = ?", [1, $username]);
                    } else {
                        $dB->query("UPDATE MEMB_INFO SET bloc_code = ? WHERE memb___id = ?", [1, $username]);
                    }
                }
            }
        }
    }
    public function unbanAccount($username)
    {
        global $dB;
        global $dB2;
        if (!check_value($username)) {
            message("error", lang("error_4", true));
        } else {
            if (!Validator::UsernameLength($username)) {
                message("error", lang("error_5", true));
            } else {
                if (!Validator::AlphaNumeric($username)) {
                    message("error", lang("error_6", true));
                } else {
                    if (config("SQL_USE_2_DB", true)) {
                        $dB2->query("UPDATE MEMB_INFO SET bloc_code = ? WHERE memb___id = ?", [0, $username]);
                    } else {
                        $dB->query("UPDATE MEMB_INFO SET bloc_code = ? WHERE memb___id = ?", [0, $username]);
                    }
                }
            }
        }
    }
}

?>