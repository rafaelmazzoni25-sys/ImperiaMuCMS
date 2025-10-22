<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class common
{
    protected $_serverFiles = NULL;
    public function __construct(dB $muonline, dB $me_muonline = NULL)
    {
        $this->muonline = $muonline;
        if ($me_muonline) {
            $this->memuonline = $me_muonline;
        }
        $this->db = config("SQL_USE_2_DB", true) ? $this->memuonline : $this->muonline;
        $this->_serverFiles = config("server_files", true);
        $this->_encryptionHash = config("encryption_hash", true);
        $this->_md5Enabled = config("SQL_ENABLE_MD5", true);
    }
    public function userExists($username)
    {
        if (!Validator::UsernameLength($username)) {
            return NULL;
        }
        if (!Validator::AlphaNumeric($username)) {
            return NULL;
        }
        $result = $this->db->query_fetch_single("SELECT * FROM " . _TBL_MI_ . " WHERE " . _CLMN_USERNM_ . " = ?", [$username]);
        if (is_array($result)) {
            return true;
        }
        return NULL;
    }
    public function validateUser($username, $password)
    {
        if (!Validator::UsernameLength($username)) {
            return NULL;
        }
        if (!Validator::AlphaNumeric($username)) {
            return NULL;
        }
        if (!Validator::PasswordLength($password)) {
            return NULL;
        }
        if ($this->_md5Enabled == "1") {
            $getUsername = $this->db->query_fetch_single("SELECT memb___id FROM MEMB_INFO WHERE memb___id = ?", [$username]);
            $username = $getUsername["memb___id"];
            $query = $this->db->query_fetch_single("SELECT * FROM " . _TBL_MI_ . " WHERE " . _CLMN_USERNM_ . " = ? AND " . _CLMN_PASSWD_ . " = [dbo].[fn_md5](?, ?)", [$username, $password, $username]);
            $md5_password = $this->db->query_fetch_single("SELECT [dbo].[fn_md5](?, ?) as password FROM MEMB_INFO", [$password, $username]);
            $md5_password = $md5_password["password"];
        } else {
            if ($this->_md5Enabled == "2") {
                $query = $this->db->query_fetch_single("SELECT * FROM " . _TBL_MI_ . " WHERE " . _CLMN_USERNM_ . " = ? AND " . _CLMN_PASSWD_ . " = ?", [$username, md5($password)]);
                $md5_password = md5($password);
            } else {
                $query = $this->db->query_fetch_single("SELECT * FROM " . _TBL_MI_ . " WHERE " . _CLMN_USERNM_ . " = ?  AND " . _CLMN_PASSWD_ . " = ?", [$username, $password]);
                $md5_password = $password;
            }
        }
        if (is_array($query)) {
            if ($md5_password == $query["memb__pwd"]) {
                return true;
            }
            return false;
        }
        return false;
    }
    public function retrieveUserID($username)
    {
        if (!Validator::UsernameLength($username)) {
            return NULL;
        }
        if (!Validator::AlphaNumeric($username)) {
            return NULL;
        }
        $result = $this->db->query_fetch_single("SELECT " . _CLMN_MEMBID_ . " FROM " . _TBL_MI_ . " WHERE " . _CLMN_USERNM_ . " = ?", [$username]);
        if (is_array($result)) {
            return $result[_CLMN_MEMBID_];
        }
        return NULL;
    }
    public function retrieveUserIDbyEmail($email)
    {
        if (!$this->emailExists($email)) {
            return NULL;
        }
        $result = $this->db->query_fetch_single("SELECT " . _CLMN_MEMBID_ . " FROM " . _TBL_MI_ . " WHERE " . _CLMN_EMAIL_ . " = ?", [$email]);
        if (is_array($result)) {
            return $result[_CLMN_MEMBID_];
        }
        return NULL;
    }
    public function emailExists($email, $flag = false)
    {
        if (!Validator::Email($email)) {
            return NULL;
        }
        $cfg = loadConfigurations("register");
        if ($cfg["multiacc"] == "1" && !$flag) {
            return false;
        }
        $result = $this->db->query_fetch_single("SELECT * FROM " . _TBL_MI_ . " WHERE " . _CLMN_EMAIL_ . " = ?", [$email]);
        if (is_array($result)) {
            return true;
        }
        return NULL;
    }
    public function accountInformation($id)
    {
        if (!Validator::Number($id)) {
            return NULL;
        }
        $result = $this->db->query_fetch_single("SELECT * FROM " . _TBL_MI_ . " WHERE " . _CLMN_MEMBID_ . " = ?", [$id]);
        if (is_array($result)) {
            return $result;
        }
        return NULL;
    }
    public function accountLoginInformation($username)
    {
        if (!Validator::UsernameLength($username)) {
            return NULL;
        }
        if (!Validator::AlphaNumeric($username)) {
            return NULL;
        }
        $result = $this->db->query_fetch_single("SELECT * FROM " . _TBL_MS_ . " WHERE " . _CLMN_MS_MEMBID_ . " = ?", [$username]);
        if (is_array($result)) {
            return $result;
        }
        return NULL;
    }
    public function accountBalance($username)
    {
        global $dB;
        global $dB2;
        if (!Validator::UsernameLength($username)) {
            return NULL;
        }
        if (!Validator::AlphaNumeric($username)) {
            return NULL;
        }
        $check1 = $dB->query_fetch_single("SELECT AccountID FROM T_InGameShop_Point WHERE AccountID = ?", [$username]);
        if ($check1["AccountID"] == NULL) {
            if (100 <= config("server_files_season", true)) {
                $dB->query("INSERT INTO T_InGameShop_Point (AccountID, WCoin, GoblinPoint) VALUES (?, ?, ?)", [$username, 0, 0]);
            } else {
                $dB->query("INSERT INTO T_InGameShop_Point (AccountID, WCoinP, WCoinC, GoblinPoint) VALUES (?, ?, ?, ?)", [$username, 0, 0, 0]);
            }
        }
        $check2 = $dB->query_fetch_single("SELECT AccountID FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$username]);
        if ($check2["AccountID"] == NULL) {
            $dB->query("INSERT INTO IMPERIAMUCMS_WEB_BANK (AccountID, zen, bless, soul, life, chaos, harmony, creation, guardian) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)", [$username, 0, 0, 0, 0, 0, 0, 0, 0]);
        }
        if (config("MEMB_CREDITS_MEMUONLINE", true)) {
            $check3 = $dB2->query_fetch_single("SELECT memb___id FROM MEMB_CREDITS WHERE memb___id = ?", [$username]);
            if ($check3["memb___id"] == NULL) {
                $dB2->query("INSERT INTO " . _TBL_MC_ . "(memb___id, platinum, platinum_used, gold, gold_used, silver, silver_used) VALUES(?,?,?,?,?,?,?)", [$username, 0, 0, 0, 0, 0, 0]);
            }
        } else {
            $check3 = $dB->query_fetch_single("SELECT memb___id FROM MEMB_CREDITS WHERE memb___id = ?", [$username]);
            if ($check3["memb___id"] == NULL) {
                $dB->query("INSERT INTO " . _TBL_MC_ . "(memb___id, platinum, platinum_used, gold, gold_used, silver, silver_used) VALUES(?,?,?,?,?,?,?)", [$username, 0, 0, 0, 0, 0, 0]);
            }
        }
        if (config("MEMB_CREDITS_MEMUONLINE", true)) {
            $result = $dB2->query_fetch_single("SELECT * FROM " . _TBL_MC_ . " WHERE " . _CLMN_MC_ID_ . " = ?", [$username]);
        } else {
            $result = $dB->query_fetch_single("SELECT * FROM " . _TBL_MC_ . " WHERE " . _CLMN_MC_ID_ . " = ?", [$username]);
        }
        $inGameShopPoints = $dB->query_fetch_single("SELECT * FROM T_InGameShop_Point WHERE AccountID = ?", [$username]);
        if (100 <= config("server_files_season", true)) {
            $result["WCoinC"] = $inGameShopPoints["WCoin"];
        } else {
            $result["WCoinC"] = $inGameShopPoints["WCoinC"];
        }
        $result["WCoinP"] = $inGameShopPoints["WCoinP"];
        $result["GoblinPoint"] = $inGameShopPoints["GoblinPoint"];
        if (is_array($result)) {
            return $result;
        }
        if (config("MEMB_CREDITS_MEMUONLINE", true)) {
            $dB2->query("INSERT INTO " . _TBL_MC_ . "(memb___id,platinum,platinum_used,gold,gold_used,silver,silver_used) VALUES(?,?,?,?,?,?,?)", [$username, 0, 0, 0, 0, 0, 0]);
            $result = $dB2->query_fetch_single("SELECT * FROM " . _TBL_MC_ . " WHERE " . _CLMN_MC_ID_ . " = ?", [$username]);
        } else {
            $dB->query("INSERT INTO " . _TBL_MC_ . "(memb___id,platinum,platinum_used,gold,gold_used,silver,silver_used) VALUES(?,?,?,?,?,?,?)", [$username, 0, 0, 0, 0, 0, 0]);
            $result = $dB->query_fetch_single("SELECT * FROM " . _TBL_MC_ . " WHERE " . _CLMN_MC_ID_ . " = ?", [$username]);
        }
        $inGameShopPoints = $dB->query_fetch_single("SELECT * FROM T_InGameShop_Point WHERE AccountID = ?", [$username]);
        if (100 <= config("server_files_season", true)) {
            $result["WCoinC"] = $inGameShopPoints["WCoin"];
        } else {
            $result["WCoinC"] = $inGameShopPoints["WCoinC"];
        }
        $result["WCoinP"] = $inGameShopPoints["WCoinP"];
        $result["GoblinPoint"] = $inGameShopPoints["GoblinPoint"];
        return $result;
    }
    public function accountOnline($username)
    {
        if (!Validator::UsernameLength($username)) {
            return NULL;
        }
        if (!Validator::AlphaNumeric($username)) {
            return NULL;
        }
        $result = $this->db->query_fetch_single("SELECT " . _CLMN_CONNSTAT_ . " FROM " . _TBL_MS_ . " WHERE " . _CLMN_USERNM_ . " = ? AND " . _CLMN_CONNSTAT_ . " = ?", [$username, 1]);
        if (is_array($result)) {
            return true;
        }
        return NULL;
    }
    public function changePassword($id, $username, $new_password)
    {
        if (!Validator::UnsignedNumber($id)) {
            return NULL;
        }
        if (!Validator::UsernameLength($username)) {
            return NULL;
        }
        if (!Validator::AlphaNumeric($username)) {
            return NULL;
        }
        if (!Validator::PasswordLength($new_password)) {
            return NULL;
        }
        if ($this->_md5Enabled == "1") {
            $data = ["userid" => $id, "username" => $username, "password" => $new_password];
            $query = "UPDATE " . _TBL_MI_ . " SET " . _CLMN_PASSWD_ . " = [dbo].[fn_md5](:password, :username) WHERE " . _CLMN_MEMBID_ . " = :userid";
        } else {
            if ($this->_md5Enabled == "2") {
                $data = ["userid" => $id, "password" => $new_password];
                $data["password"] = md5($data["password"]);
                $query = "UPDATE " . _TBL_MI_ . " SET " . _CLMN_PASSWD_ . " = :password WHERE " . _CLMN_MEMBID_ . " = :userid";
            } else {
                $data = ["userid" => $id, "password" => $new_password];
                $query = "UPDATE " . _TBL_MI_ . " SET " . _CLMN_PASSWD_ . " = :password WHERE " . _CLMN_MEMBID_ . " = :userid";
            }
        }
        $result = $this->db->query($query, $data);
        if ($result) {
            return true;
        }
        return NULL;
    }
    public function addPasswordChangeRequest($userid, $new_password, $auth_code)
    {
        if (!check_value($userid)) {
            return NULL;
        }
        if (!check_value($new_password)) {
            return NULL;
        }
        if (!check_value($auth_code)) {
            return NULL;
        }
        if (!Validator::PasswordLength($new_password)) {
            return NULL;
        }
        $data = [$userid, Encode($new_password), $auth_code, time()];
        $query = "INSERT INTO IMPERIAMUCMS_PASSCHANGE_REQUEST (user_id,new_password,auth_code,request_date) VALUES (?, ?, ?, ?)";
        $result = $this->muonline->query($query, $data);
        if ($result) {
            return true;
        }
        return NULL;
    }
    public function hasActivePasswordChangeRequest($userid)
    {
        if (!check_value($userid)) {
            return NULL;
        }
        $result = $this->muonline->query_fetch_single("SELECT * FROM IMPERIAMUCMS_PASSCHANGE_REQUEST WHERE user_id = ?", [$userid]);
        if (!is_array($result)) {
            return NULL;
        }
        $configs = loadConfigurations("usercp.mypassword");
        if (!is_array($configs)) {
            return NULL;
        }
        $request_timeout = $configs["change_password_request_timeout"] * 3600;
        $request_date = $result["request_date"] + $request_timeout;
        if (time() < $request_date) {
            return true;
        }
        $this->removePasswordChangeRequest($userid);
    }
    public function removePasswordChangeRequest($userid)
    {
        $result = $this->muonline->query("DELETE FROM IMPERIAMUCMS_PASSCHANGE_REQUEST WHERE user_id = ?", [$userid]);
        if ($result) {
            return true;
        }
        return NULL;
    }
    public function generatePasswordChangeVerificationURL($user_id, $auth_code)
    {
        $build_url = __BASE_URL__;
        $build_url .= "verifyemail/";
        $build_url .= "?op=";
        $build_url .= Encode_id(1);
        $build_url .= "&uid=";
        $build_url .= Encode_id($user_id);
        $build_url .= "&ac=";
        $build_url .= Encode_id($auth_code);
        return $build_url;
    }
    public function blockAccount($userid)
    {
        if (!check_value($userid)) {
            return NULL;
        }
        if (!Validator::UnsignedNumber($userid)) {
            return NULL;
        }
        $result = $this->db->query("UPDATE " . _TBL_MI_ . " SET " . _CLMN_BLOCCODE_ . " = ? WHERE " . _CLMN_MEMBID_ . " = ?", [1, $userid]);
        if ($result) {
            return true;
        }
        return NULL;
    }
    public function paypal_transaction($transaction_id, $user_id, $payment_amount, $paypal_email, $order_id, $reward_amount, $reward_type, $payment_currency)
    {
        if (!check_value($transaction_id)) {
            return NULL;
        }
        if (!check_value($user_id)) {
            return NULL;
        }
        if (!check_value($payment_amount)) {
            return NULL;
        }
        if (!check_value($paypal_email)) {
            return NULL;
        }
        if (!check_value($order_id)) {
            return NULL;
        }
        if (!check_value($reward_amount)) {
            return NULL;
        }
        if (!check_value($reward_type)) {
            return NULL;
        }
        if (!check_value($payment_currency)) {
            return NULL;
        }
        if (!Validator::UnsignedNumber($user_id)) {
            return NULL;
        }
        $data = [$transaction_id, $user_id, $payment_amount, $paypal_email, time(), 1, $order_id, $reward_amount, $reward_type, $payment_currency];
        $query = "INSERT INTO IMPERIAMUCMS_PAYPAL_TRANSACTIONS (transaction_id, user_id, payment_amount, paypal_email, transaction_date, transaction_status, order_id, reward_amount, reward_type, payment_currency) \r\n                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $result = $this->muonline->query($query, $data);
        if ($result) {
            return true;
        }
        return NULL;
    }
    public function paypal_transaction_reversed_updatestatus($order_id)
    {
        if (!check_value($order_id)) {
            return NULL;
        }
        $result = $this->muonline->query("UPDATE IMPERIAMUCMS_PAYPAL_TRANSACTIONS SET transaction_status = ? WHERE order_id = ?", [0, $order_id]);
        if ($result) {
            return true;
        }
        return NULL;
    }
    public function mercadopago_transaction($transaction_id, $user_id, $payment_amount, $mercadopago_email, $order_id, $reward_amount, $reward_type, $payment_currency)
    {
        if (!check_value($transaction_id)) {
            return NULL;
        }
        if (!check_value($user_id)) {
            return NULL;
        }
        if (!check_value($payment_amount)) {
            return NULL;
        }
        if (!check_value($mercadopago_email)) {
            return NULL;
        }
        if (!check_value($order_id)) {
            return NULL;
        }
        if (!check_value($reward_amount)) {
            return NULL;
        }
        if (!check_value($reward_type)) {
            return NULL;
        }
        if (!check_value($payment_currency)) {
            return NULL;
        }
        if (!Validator::UnsignedNumber($user_id)) {
            return NULL;
        }
        $data = [$transaction_id, $user_id, $payment_amount, $mercadopago_email, time(), 1, $order_id, $reward_amount, $reward_type, $payment_currency];
        $query = "INSERT INTO IMPERIAMUCMS_MERCADOPAGO_TRANSACTIONS (transaction_id, user_id, payment_amount, mercadopago_email, transaction_date, transaction_status, order_id, reward_amount, reward_type, payment_currency) \r\n                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $result = $this->muonline->query($query, $data);
        if ($result) {
            return true;
        }
        return false;
    }
    public function mercadopago_transaction_updatestatus($transaction_id, $status)
    {
        if (!check_value($transaction_id)) {
            return NULL;
        }
        if (!Validator::UnsignedNumber($status)) {
            return NULL;
        }
        $result = $this->muonline->query("UPDATE IMPERIAMUCMS_MERCADOPAGO_TRANSACTIONS SET transaction_status = ? WHERE transaction_id = ?", [$status, $transaction_id]);
        if ($result) {
            return true;
        }
        return false;
    }
    public function mercadopago_get_transaction($transaction_id)
    {
        if (!check_value($transaction_id)) {
            return NULL;
        }
        return $this->muonline->query_fetch_single("SELECT * FROM IMPERIAMUCMS_MERCADOPAGO_TRANSACTIONS WHERE transaction_id = ?", [$transaction_id]);
    }
    public function generateAccountRecoveryCode($userid, $username)
    {
        if (!check_value($userid)) {
            return NULL;
        }
        if (!check_value($username)) {
            return NULL;
        }
        return md5($userid . $username . $this->_encryptionHash . date("m-d-Y"));
    }
    public function blockIpAddress($ip, $user)
    {
        if (!check_value($user)) {
            return NULL;
        }
        if (!Validator::Ip($ip)) {
            return NULL;
        }
        if ($this->isIpBlocked($ip)) {
            return NULL;
        }
        $result = $this->muonline->query("INSERT INTO IMPERIAMUCMS_BLOCKED_IP (block_ip,block_by,block_date) VALUES (?,?,?)", [$ip, $user, time()]);
        if ($result) {
            return true;
        }
    }
    public function isIpBlocked($ip)
    {
        if (!Validator::Ip($ip)) {
            return true;
        }
        $result = $this->muonline->query_fetch_single("SELECT * FROM IMPERIAMUCMS_BLOCKED_IP WHERE block_ip = ?", [$ip]);
        if (is_array($result)) {
            return true;
        }
        return NULL;
    }
    public function retrieveBlockedIPs()
    {
        return $this->muonline->query_fetch("SELECT * FROM IMPERIAMUCMS_BLOCKED_IP ORDER BY id DESC");
    }
    public function unblockIpAddress($id)
    {
        if (!check_value($id)) {
            return NULL;
        }
        $result = $this->muonline->query("DELETE FROM IMPERIAMUCMS_BLOCKED_IP WHERE id = ?", [$id]);
        if ($result) {
            return true;
        }
        return NULL;
    }
    public function updateEmail($userid, $newemail)
    {
        if (!Validator::UnsignedNumber($userid)) {
            return NULL;
        }
        if (!Validator::Email($newemail)) {
            return NULL;
        }
        $result = $this->db->query("UPDATE " . _TBL_MI_ . " SET " . _CLMN_EMAIL_ . " = ? WHERE " . _CLMN_MEMBID_ . " = ?", [$newemail, $userid]);
        if ($result) {
            return true;
        }
        return NULL;
    }
    public function vipInfo($username)
    {
        global $dB;
        if (!Validator::UsernameLength($username)) {
            return NULL;
        }
        if (!Validator::AlphaNumeric($username)) {
            return NULL;
        }
        if (config("SQL_USE_2_DB", true)) {
            $result = $dB->query_fetch_single("SELECT * FROM T_VIPList WHERE AccountID = ?", [$username]);
        }
        if (is_array($result)) {
            return $result;
        }
        return NULL;
    }
    public function accountLogs($username, $type, $text, $date)
    {
        global $dB;
        $result = $dB->query("INSERT INTO IMPERIAMUCMS_ACCOUNT_LOGS(AccountID,type,text,date) VALUES(?,?,?,?)", [$username, $type, $text, $date]);
    }
    public function ip_info($ip = NULL, $purpose = "location", $deep_detect = true)
    {
        $output = NULL;
        if (filter_var($ip, FILTER_VALIDATE_IP) === false) {
            $ip = $_SERVER["REMOTE_ADDR"];
            if ($deep_detect) {
                if (filter_var($_SERVER["HTTP_X_FORWARDED_FOR"], FILTER_VALIDATE_IP)) {
                    $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
                }
                if (filter_var($_SERVER["HTTP_CLIENT_IP"], FILTER_VALIDATE_IP)) {
                    $ip = $_SERVER["HTTP_CLIENT_IP"];
                }
            }
        }
        $purpose = str_replace(["name", "\n", "\t", " ", "-", "_"], NULL, strtolower(trim($purpose)));
        $support = ["country", "countrycode", "state", "region", "city", "location", "address"];
        $continents = ["AF" => "Africa", "AN" => "Antarctica", "AS" => "Asia", "EU" => "Europe", "OC" => "Australia (Oceania)", "NA" => "North America", "SA" => "South America"];
        if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
            $ipdat = @json_decode(@curl_file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
            if (@strlen(@trim($ipdat->geoplugin_countryCode)) == 2) {
                switch ($purpose) {
                    case "location":
                        $output = ["city" => $ipdat->geoplugin_city, "state" => $ipdat->geoplugin_regionName, "country" => $ipdat->geoplugin_countryName, "country_code" => $ipdat->geoplugin_countryCode, "continent" => $continents[@strtoupper($ipdat->geoplugin_continentCode)], "continent_code" => $ipdat->geoplugin_continentCode];
                        break;
                    case "address":
                        $address = [$ipdat->geoplugin_countryName];
                        if (1 <= @strlen($ipdat->geoplugin_regionName)) {
                            $address[] = $ipdat->geoplugin_regionName;
                        }
                        if (1 <= @strlen($ipdat->geoplugin_city)) {
                            $address[] = $ipdat->geoplugin_city;
                        }
                        $output = implode(", ", array_reverse($address));
                        break;
                    case "city":
                        $output = $ipdat->geoplugin_city;
                        break;
                    case "state":
                        $output = $ipdat->geoplugin_regionName;
                        break;
                    case "region":
                        $output = $ipdat->geoplugin_regionName;
                        break;
                    case "country":
                        $output = $ipdat->geoplugin_countryName;
                        break;
                    case "countrycode":
                        $output = $ipdat->geoplugin_countryCode;
                        break;
                }
            }
        }
        return $output;
    }
    public function replaceHtmlSymbols($string)
    {
        $string = str_replace("<", "&lt;", $string);
        $string = str_replace(">", "&gt;", $string);
        return $string;
    }
    public function IPB_getLatestTopics($count = 5, $params = "")
    {
        $ipbCfg = loadConfigurations("ipboardapi");
        $communityUrl = $ipbCfg["url"] . "api/";
        $apiKey = $ipbCfg["api_key"];
        if (!$ipbCfg["url_rewrite"]) {
            $communityUrl .= "index.php?/";
        }
        $curl = curl_init($communityUrl . "forums/topics" . $params);
        curl_setopt_array($curl, [CURLOPT_RETURNTRANSFER => true, CURLOPT_HTTPAUTH => CURLAUTH_BASIC, CURLOPT_USERPWD => $apiKey . ":"]);
        $response = curl_exec($curl);
        $data = json_decode($response, true);
        $latestTopics = array_slice($data["results"], 0, $count);
        return $latestTopics;
    }
    public function IPB_getTopicById($id, $params = "")
    {
        $ipbCfg = loadConfigurations("ipboardapi");
        $communityUrl = $ipbCfg["url"] . "api/";
        $apiKey = $ipbCfg["api_key"];
        if (!$ipbCfg["url_rewrite"]) {
            $communityUrl .= "index.php?/";
        }
        $curl = curl_init($communityUrl . "forums/topics/" . $id . $params);
        curl_setopt_array($curl, [CURLOPT_RETURNTRANSFER => true, CURLOPT_HTTPAUTH => CURLAUTH_BASIC, CURLOPT_USERPWD => $apiKey . ":"]);
        $response = curl_exec($curl);
        $data = json_decode($response, true);
        return $data;
    }
    public function IPB_getTopicDataById($id, $count, $params)
    {
        $data = $this->IPB_getLatestTopics($count, $params);
        foreach ($data as $thisTopic) {
            if ($thisTopic["id"] == $id) {
                return $thisTopic;
            }
        }
        return NULL;
    }
    public function IPB_getLatestPosts($count = 5, $params = "")
    {
        $ipbCfg = loadConfigurations("ipboardapi");
        $communityUrl = $ipbCfg["url"] . "api/";
        $apiKey = $ipbCfg["api_key"];
        if (!$ipbCfg["url_rewrite"]) {
            $communityUrl .= "index.php?/";
        }
        $curl = curl_init($communityUrl . "forums/posts" . $params);
        curl_setopt_array($curl, [CURLOPT_RETURNTRANSFER => true, CURLOPT_HTTPAUTH => CURLAUTH_BASIC, CURLOPT_USERPWD => $apiKey . ":"]);
        $response = curl_exec($curl);
        $data = json_decode($response, true);
        $latestTopics = array_slice($data["results"], 0, $count);
        return $latestTopics;
    }
    public function IPB_getPostById($id, $params = "")
    {
        $ipbCfg = loadConfigurations("ipboardapi");
        $communityUrl = $ipbCfg["url"] . "api/";
        $apiKey = $ipbCfg["api_key"];
        if (!$ipbCfg["url_rewrite"]) {
            $communityUrl .= "index.php?/";
        }
        $curl = curl_init($communityUrl . "forums/posts/" . $id . $params);
        curl_setopt_array($curl, [CURLOPT_RETURNTRANSFER => true, CURLOPT_HTTPAUTH => CURLAUTH_BASIC, CURLOPT_USERPWD => $apiKey . ":"]);
        $response = curl_exec($curl);
        $data = json_decode($response, true);
        return $data;
    }
    public function IPB_createMember($params = "")
    {
        $ipbCfg = loadConfigurations("ipboardapi");
        $communityUrl = $ipbCfg["url"] . "api/";
        $apiKey = $ipbCfg["api_key"];
        if (!$ipbCfg["url_rewrite"]) {
            $communityUrl .= "index.php?/";
        }
        $params = rtrim($params, "&");
        $curl = curl_init($communityUrl . "core/members");
        curl_setopt_array($curl, [CURLOPT_RETURNTRANSFER => true, CURLOPT_HTTPAUTH => CURLAUTH_BASIC, CURLOPT_USERPWD => $apiKey . ":", CURLOPT_POST => count($params), CURLOPT_POSTFIELDS => $params]);
        $response = curl_exec($curl);
        $data = json_decode($response, true);
        $error = false;
        if (is_array($data)) {
            if ($data["errorCode"] == "1C292/4") {
                $error = true;
                message("error", lang("register_txt_26", true));
            } else {
                if ($data["errorCode"] == "1C292/5") {
                    $registerCfg = loadConfigurations("register");
                    if ($registerCfg["multiacc"] == "1") {
                        return true;
                    }
                    $error = true;
                    message("error", lang("register_txt_27", true));
                } else {
                    if ($data["errorCode"] == "1C292/6") {
                        $error = true;
                        message("error", lang("register_txt_28", true));
                    } else {
                        if ($data["errorCode"] == "1C292/8") {
                            $error = true;
                            message("error", lang("register_txt_29", true));
                        } else {
                            if ($data["errorCode"] == "1C292/9") {
                                $error = true;
                                message("error", lang("register_txt_30", true));
                            }
                        }
                    }
                }
            }
        }
        if ($error) {
            return false;
        }
        return true;
    }
    public function beginDbTrans($username, $username2 = NULL)
    {
        global $dB;
        global $dB2;
        if (!$this->accountOnline($username)) {
            if (config("SQL_USE_2_DB", true)) {
                $checkBan = $dB2->query_fetch_single("SELECT memb___id, bloc_code FROM MEMB_INFO WHERE memb___id = ?", [$username]);
                if ($checkBan["bloc_code"] == "0") {
                    $dB2->query("UPDATE MEMB_INFO SET bloc_code = ? WHERE memb___id = ?", [1, $username]);
                    $dB->query("INSERT INTO IMPERIAMUCMS_BANS (AccountID, banned_by, ban_date, ban_hours, ban_reason) VALUES (?, ?, ?, ?, ?)", [$username, "X", time(), 1, "ImperiaMuCMS Protection"]);
                }
                if ($username2 != NULL) {
                    $checkBan = $dB2->query_fetch_single("SELECT memb___id, bloc_code FROM MEMB_INFO WHERE memb___id = ?", [$username2]);
                    if ($checkBan["bloc_code"] == "0") {
                        $dB2->query("UPDATE MEMB_INFO SET bloc_code = ? WHERE memb___id = ?", [1, $username2]);
                        $dB->query("INSERT INTO IMPERIAMUCMS_BANS (AccountID, banned_by, ban_date, ban_hours, ban_reason) VALUES (?, ?, ?, ?, ?)", [$username2, "X", time(), 1, "ImperiaMuCMS Protection"]);
                    }
                }
                return true;
            }
            $checkBan = $dB->query_fetch_single("SELECT memb___id, bloc_code FROM MEMB_INFO WHERE memb___id = ?", [$username]);
            if ($checkBan["bloc_code"] == "0") {
                $dB->query("UPDATE MEMB_INFO SET bloc_code = ? WHERE memb___id = ?", [1, $username]);
                $dB->query("INSERT INTO IMPERIAMUCMS_BANS (AccountID, banned_by, ban_date, ban_hours, ban_reason) VALUES (?, ?, ?, ?, ?)", [$username, "X", time(), 1, "ImperiaMuCMS Protection"]);
            }
            if ($username2 != NULL) {
                $checkBan = $dB->query_fetch_single("SELECT memb___id, bloc_code FROM MEMB_INFO WHERE memb___id = ?", [$username2]);
                if ($checkBan["bloc_code"] == "0") {
                    $dB->query("UPDATE MEMB_INFO SET bloc_code = ? WHERE memb___id = ?", [1, $username2]);
                    $dB->query("INSERT INTO IMPERIAMUCMS_BANS (AccountID, banned_by, ban_date, ban_hours, ban_reason) VALUES (?, ?, ?, ?, ?)", [$username2, "X", time(), 1, "ImperiaMuCMS Protection"]);
                }
            }
            return true;
        }
        message("error", lang("error_14", true));
        return false;
    }
    public function endDbTrans($username, $username2 = NULL)
    {
        global $dB;
        global $dB2;
        if (config("SQL_USE_2_DB", true)) {
            $checkBan = $dB->query_fetch_single("SELECT AccountID FROM IMPERIAMUCMS_BANS WHERE AccountID = ? AND banned_by = ? AND ban_reason = ?", [$username, "X", "ImperiaMuCMS Protection"]);
            if (is_array($checkBan)) {
                $dB2->query("UPDATE MEMB_INFO SET bloc_code = ? WHERE memb___id = ?", [0, $username]);
                $dB->query("DELETE FROM IMPERIAMUCMS_BANS WHERE AccountID = ? AND banned_by = ? AND ban_reason = ?", [$username, "X", "ImperiaMuCMS Protection"]);
            }
            if ($username2 != NULL) {
                $checkBan = $dB->query_fetch_single("SELECT AccountID FROM IMPERIAMUCMS_BANS WHERE AccountID = ? AND banned_by = ? AND ban_reason = ?", [$username2, "X", "ImperiaMuCMS Protection"]);
                if (is_array($checkBan)) {
                    $dB2->query("UPDATE MEMB_INFO SET bloc_code = ? WHERE memb___id = ?", [0, $username2]);
                    $dB->query("DELETE FROM IMPERIAMUCMS_BANS WHERE AccountID = ? AND banned_by = ? AND ban_reason = ?", [$username2, "X", "ImperiaMuCMS Protection"]);
                }
            }
        } else {
            $checkBan = $dB->query_fetch_single("SELECT AccountID FROM IMPERIAMUCMS_BANS WHERE AccountID = ? AND banned_by = ? AND ban_reason = ?", [$username, "X", "ImperiaMuCMS Protection"]);
            if (is_array($checkBan)) {
                $dB->query("UPDATE MEMB_INFO SET bloc_code = ? WHERE memb___id = ?", [0, $username]);
                $dB->query("DELETE FROM IMPERIAMUCMS_BANS WHERE AccountID = ? AND banned_by = ? AND ban_reason = ?", [$username, "X", "ImperiaMuCMS Protection"]);
            }
            if ($username2 != NULL) {
                $checkBan = $dB->query_fetch_single("SELECT AccountID FROM IMPERIAMUCMS_BANS WHERE AccountID = ? AND banned_by = ? AND ban_reason = ?", [$username2, "X", "ImperiaMuCMS Protection"]);
                if (is_array($checkBan)) {
                    $dB->query("UPDATE MEMB_INFO SET bloc_code = ? WHERE memb___id = ?", [0, $username2]);
                    $dB->query("DELETE FROM IMPERIAMUCMS_BANS WHERE AccountID = ? AND banned_by = ? AND ban_reason = ?", [$username2, "X", "ImperiaMuCMS Protection"]);
                }
            }
        }
    }
}

?>