<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class login
{
    public function isLoggedIN()
    {
        $_SESSION;
        global $dB;
        if ($_SESSION["valid"] && check_value($_SESSION["userid"]) && check_value($_SESSION["username"])) {
            if ($this->checkActiveSession($_SESSION["userid"], session_id())) {
                $this->updateActiveSessionTime($_SESSION["userid"]);
                if (mconfig("enable_session_timeout")) {
                    if ($this->isSessionActive($_SESSION["timeout"])) {
                        $_SESSION["timeout"] = time();
                        return true;
                    }
                    $this->logout();
                } else {
                    return true;
                }
            } else {
                $this->logout();
            }
        }
    }
    private function checkActiveSession($userid, $session_id)
    {
        global $dB;
        $check = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_ACTIVE_SESSIONS WHERE session_user_id = ? AND session_id = ?", [$userid, $session_id]);
        if ($check && is_array($check)) {
            return true;
        }
    }
    private function updateActiveSessionTime($userid)
    {
        global $dB;
        $update = $dB->query("UPDATE IMPERIAMUCMS_ACTIVE_SESSIONS SET session_time = ? WHERE session_user_id = ?", [time(), $userid]);
        if ($update) {
            return true;
        }
    }
    public function logout()
    {
        $_SESSION = [];
        session_destroy();
        redirect();
    }
    public function isSessionActive($session_timeout)
    {
        if (check_value($session_timeout)) {
            $offset = time() - $session_timeout;
            if ($offset < mconfig("session_timeout")) {
                return true;
            }
            return false;
        }
        return false;
    }
    public function validateLogin($username, $password)
    {
        global $common;
        $_SERVER;
        global $dB;
        global $dB2;
        if (check_value($username) && check_value($password)) {
            if ($this->canLogin($_SERVER["REMOTE_ADDR"])) {
                if ($common->userExists($username)) {
                    if ($common->validateUser($username, $password)) {
                        if (config("SQL_USE_2_DB", true)) {
                            $memb___id = $dB2->query_fetch_single("SELECT memb___id FROM MEMB_INFO WHERE memb___id = ?", $username);
                        } else {
                            $memb___id = $dB->query_fetch_single("SELECT memb___id FROM MEMB_INFO WHERE memb___id = ?", $username);
                        }
                        $username = $memb___id["memb___id"];
                        $this->removeFailedLogins($_SERVER["REMOTE_ADDR"]);
                        session_regenerate_id();
                        $_SESSION["valid"] = true;
                        $_SESSION["timeout"] = time();
                        $_SESSION["userid"] = $common->retrieveUserID($username);
                        $_SESSION["username"] = $username;
                        $this->deleteActiveSession($_SESSION["userid"]);
                        $this->addActiveSession($_SESSION["userid"], $_SERVER["REMOTE_ADDR"]);
                        if (check_value($_SESSION["login_last_location"])) {
                            redirect(1, $_SESSION["login_last_location"]);
                        } else {
                            redirect(1, "usercp/");
                        }
                    } else {
                        $this->addFailedLogin($username, $_SERVER["REMOTE_ADDR"]);
                        message("error", lang("error_1", true));
                        message("warning", $this->checkFailedLogins($_SERVER["REMOTE_ADDR"]) . lang("warning_1b", true) . mconfig("max_login_attempts"), lang("warning_1a", true));
                    }
                } else {
                    message("error", lang("error_2", true));
                }
            } else {
                message("error", lang("error_3", true));
            }
        } else {
            message("error", lang("error_4", true));
        }
    }
    public function validateAdminLogin($username, $password, $security)
    {
        global $common;
        $_SERVER;
        global $config;
        loadModuleConfigs("login");
        if (check_value($username) && check_value($password)) {
            if ($this->canLogin($_SERVER["REMOTE_ADDR"])) {
                if ($common->userExists($username)) {
                    if ($common->validateUser($username, $password)) {
                        if (canAccessAdminCP($username)) {
                            if ($security == $config["admincp_security"]) {
                                $this->removeFailedLogins($_SERVER["REMOTE_ADDR"]);
                                session_regenerate_id();
                                $_SESSION["valid"] = true;
                                $_SESSION["timeout"] = time();
                                $_SESSION["userid"] = $common->retrieveUserID($username);
                                $_SESSION["username"] = $username;
                                $this->deleteActiveSession($_SESSION["userid"]);
                                $this->addActiveSession($_SESSION["userid"], $_SERVER["REMOTE_ADDR"]);
                                redirect(1, "admincp/index.php");
                            } else {
                                message("error", "Invalid username or password.");
                            }
                        } else {
                            message("error", "Invalid username or password.");
                        }
                    } else {
                        $this->addFailedLogin($username, $_SERVER["REMOTE_ADDR"]);
                        message("error", lang("error_1", true));
                        message("warning", $this->checkFailedLogins($_SERVER["REMOTE_ADDR"]) . lang("warning_1b", true) . mconfig("max_login_attempts"), lang("warning_1a", true));
                    }
                } else {
                    message("error", lang("error_2", true));
                }
            } else {
                message("error", lang("error_3", true));
            }
        } else {
            message("error", lang("error_4", true));
        }
    }
    public function canLogin($ipaddress)
    {
        global $dB;
        global $common;
        if (Validator::Ip($ipaddress)) {
            $fl = $this->checkFailedLogins($ipaddress);
            if (mconfig("max_login_attempts") <= $fl) {
                $result = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_FLA WHERE ip_address = ? ORDER BY id DESC", [$ipaddress]);
                if (is_array($result)) {
                    if ($result["unlock_timestamp"] < time()) {
                        $this->removeFailedLogins($ipaddress);
                        return true;
                    }
                    return false;
                }
                return true;
            }
            return true;
        }
        return false;
    }
    public function checkFailedLogins($ipaddress)
    {
        global $dB;
        if (Validator::Ip($ipaddress)) {
            $result = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_FLA WHERE ip_address = ? ORDER BY id DESC", [$ipaddress]);
            if (is_array($result)) {
                return $result["failed_attempts"];
            }
            return false;
        }
        return false;
    }
    public function removeFailedLogins($ipaddress)
    {
        global $dB;
        if (Validator::Ip($ipaddress)) {
            $dB->query("DELETE FROM IMPERIAMUCMS_FLA WHERE ip_address = ?", [$ipaddress]);
        }
    }
    private function deleteActiveSession($userid)
    {
        global $dB;
        $delete = $dB->query("DELETE FROM IMPERIAMUCMS_ACTIVE_SESSIONS WHERE session_user_id = ?", [$userid]);
    }
    private function addActiveSession($userid, $ipaddress)
    {
        global $dB;
        $add = $dB->query("INSERT INTO IMPERIAMUCMS_ACTIVE_SESSIONS (session_user_id,session_id,session_ip,session_time) VALUES (?,?,?,?) ", [$userid, session_id(), $ipaddress, time()]);
        if ($add) {
            return true;
        }
    }
    public function addFailedLogin($username, $ipaddress)
    {
        global $dB;
        global $common;
        global $config;
        if (!Validator::UsernameLength($username)) {
            $error = true;
        }
        if (!Validator::AlphaNumeric($username)) {
            $error = true;
        }
        if (!Validator::Ip($ipaddress)) {
            $error = true;
        }
        if (!$common->userExists($username)) {
            $error = true;
        }
        if (!$error) {
            $n = $this->checkFailedLogins($ipaddress);
            $timeout = time() + mconfig("failed_login_timeout") * 60;
            if (!$n) {
                $data = [$username, $ipaddress, 0, 1, time()];
                $dB->query("INSERT INTO IMPERIAMUCMS_FLA (username, ip_address, unlock_timestamp, failed_attempts, timestamp) VALUES (?, ?, ?, ?, ?)", $data);
            } else {
                $new_n = $n + 1;
                if (mconfig("max_login_attempts") <= $new_n) {
                    $dB->query("UPDATE IMPERIAMUCMS_FLA SET username = '" . $username . "', ip_address = '" . $ipaddress . "', failed_attempts = '" . $new_n . "', unlock_timestamp = '" . $timeout . "', timestamp = '" . time() . "' WHERE ip_address = '" . $ipaddress . "'");
                } else {
                    $dB->query("UPDATE IMPERIAMUCMS_FLA SET username = '" . $username . "', ip_address = '" . $ipaddress . "', failed_attempts = '" . $new_n . "', timestamp = '" . time() . "' WHERE ip_address = '" . $ipaddress . "'");
                }
            }
        }
    }
}

?>