<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

function check_value($value)
{
    if (0 < @count($value) && !empty($value) && isset($value) || $value == "0") {
        return true;
    }
}
function redirect($type = 1, $location = NULL, $delay = 0)
{
    if (!check_value($location)) {
        $to = __BASE_URL__;
    } else {
        $to = __BASE_URL__ . $location;
        if ($location == "login") {
            $_SESSION["login_last_location"] = $_REQUEST["page"] . "/";
            if (check_value($_REQUEST["subpage"])) {
                $easytoyou_decoder_beta_not_finish .= $_REQUEST["subpage"] . "/";
            }
        }
    }
    switch ($type) {
        case 1:
            header("Location: " . $to . "");
            exit;
            break;
        case 2:
            echo "<meta http-equiv=\"REFRESH\" content=\"" . $delay . ";url=" . $to . "\">";
            break;
        case 3:
            header("Location: " . $location . "");
            exit;
            break;
        default:
            header("Location: " . $to . "");
            exit;
    }
}
function isLoggedIn()
{
    $login = new login();
    if ($login->isLoggedIN()) {
        return true;
    }
    return false;
}
function logOutUser()
{
    $login = new login();
    $login->logout();
}
function message($type = "neutral", $message = NULL, $newTitle = NULL, $return = false)
{
    switch ($type) {
        case "error":
            $class = "red";
            $icon = "attention";
            $class_admincp = " alert-danger";
            $title = lang("notification_error", true);
            break;
        case "success":
            $class = "green";
            $icon = "success";
            $class_admincp = " alert-success";
            $title = lang("notification_success", true);
            break;
        case "warning":
            $class = "orange";
            $icon = "attention";
            $class_admincp = " alert-warning";
            $title = lang("notification_warning", true);
            break;
        case "info":
            $class = "light_brown";
            $icon = "info";
            $class_admincp = " alert-info";
            $title = lang("notification_info", true);
            break;
        case "notice":
            $class = "light_brown";
            $icon = "info";
            $class_admincp = " alert-info";
            $title = lang("notification_notice", true);
            break;
        default:
            if (check_value($newTitle)) {
                $title = $newTitle;
            }
            $html = "";
            if (defined("admincp") && admincp || defined("gmcp") && gmcp) {
                $html .= "<div class=\"alert" . $class_admincp . "\">";
            } else {
                $html .= "<div class=\"container_3 " . $class . " wide fading-notification\" align=\"left\">";
            }
            if (check_value($title)) {
                $html .= "<span class=\"error_icons " . $icon . "\"></span><p>" . $title . " " . $message . "</p>";
            } else {
                $html .= "<span class=\"error_icons " . $icon . "\"></span><p>" . $message . "</p>";
            }
            $html .= "</div>";
            if ($return) {
                return $html;
            }
            echo $html;
    }
}
function set_flash_msg($type = "neutral", $message = NULL, $newTitle = NULL)
{
    $_SESSION["flash_msg"] = message($type, $message, $newTitle, true);
}
function show_flash_msg()
{
    if (isset($_SESSION["flash_msg"])) {
        echo $_SESSION["flash_msg"];
        unset($_SESSION["flash_msg"]);
    }
}
function lang($lang_name, $return = false)
{
    global $lang;
    if ($return) {
        return $lang[$lang_name];
    }
    echo $lang[$lang_name];
}
function Encode($txt)
{
    $encryption = new Encryption();
    return $encryption->encode($txt);
}
function Decode($txt)
{
    $encryption = new Encryption();
    return $encryption->decode($txt);
}
function debug($value)
{
    echo "<pre>";
    print_r($value);
    echo "</pre>";
}
function canAccessAdminCP($username)
{
    if (!check_value($username)) {
        return NULL;
    }
    if (array_key_exists($username, config("admins", true))) {
        return true;
    }
    return false;
}
function canAccessGMCP($username)
{
    if (!check_value($username)) {
        return NULL;
    }
    if (array_key_exists($username, config("gamemasters", true))) {
        return true;
    }
    return false;
}
function canAccessBT($username)
{
    if (check_value($username)) {
        $search = in_array($username, config("bt_users_access", true));
        if ($search) {
            return true;
        }
        return false;
    }
    return false;
}
function imperiamucms_id($var, $action = "encode")
{
    $base_chars = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $n = 0;
    while ($n < strlen($base_chars)) {
        $i[] = substr($base_chars, $n, 1);
        $n++;
    }
    $passhash = hash("sha256", config("encryption_hash", true));
    $passhash = strlen($passhash) < strlen($base_chars) ? hash("sha512", config("encryption_hash", true)) : $passhash;
    $n = 0;
    while ($n < strlen($base_chars)) {
        $p[] = substr($passhash, $n, 1);
        $n++;
    }
    array_multisort($p, SORT_DESC, $i);
    $base_chars = implode($i);
    switch ($action) {
        case "encode":
            $string = "";
            $len = strlen($base_chars);
            while ($len <= $var) {
                $mod = bcmod($var, $len);
                $var = bcdiv($var, $len);
                $string = $base_chars[$mod] . $string;
            }
            return $base_chars[$var] . $string;
            break;
        case "decode":
            $integer = 0;
            $var = strrev($var);
            $baselen = strlen($base_chars);
            $inputlen = strlen($var);
            $i = 0;
            while ($i < $inputlen) {
                $index = strpos($base_chars, $var[$i]);
                $integer = bcadd($integer, bcmul($index, bcpow($baselen, $i)));
                $i++;
            }
            return $integer;
            break;
    }
}
function Encode_id($id)
{
    return imperiamucms_id($id, "encode");
}
function Decode_id($id)
{
    return imperiamucms_id($id, "decode");
}
function BuildCacheData($data_array)
{
    $result = NULL;
    if (is_array($data_array)) {
        foreach ($data_array as $row) {
            $count = count($row);
            $i = 1;
            foreach ($row as $data) {
                $result .= $data;
                if ($i < $count) {
                    $result .= "¦";
                }
                $i++;
            }
            $result .= "\n";
        }
        return $result;
    } else {
        return NULL;
    }
}
function UpdateCache($file_name, $data)
{
    $file = __PATH_CACHE__ . $file_name;
    if (!file_exists($file)) {
        $fp = @fopen($file, "w");
        if ($fp) {
            chmod($file, 511);
            fclose($fp);
        }
    }
    if (file_exists($file) && is_writable($file)) {
        $fp = fopen($file, "w");
        fwrite($fp, time() . "\n");
        fwrite($fp, $data);
        fclose($fp);
        return true;
    }
    return false;
}
function LoadCacheData($file_name)
{
    $file = __PATH_CACHE__ . $file_name;
    if (file_exists($file) && is_readable($file)) {
        $cache_file = file_get_contents($file);
        $file_lanes = explode("\n", $cache_file);
        $nlines = count($file_lanes);
        $i = 0;
        while ($i < $nlines) {
            if (check_value($file_lanes[$i])) {
                $line_data[$i] = explode("¦", $file_lanes[$i]);
            }
            $i++;
        }
        return $line_data;
    }
    return NULL;
}
function sec_to_hms($input_seconds)
{
    if (1 <= $input_seconds) {
        $hours_module = $input_seconds % 3600;
        $hours = ($input_seconds - $hours_module) / 3600;
        $minutes_module = $hours_module % 60;
        $minutes = ($hours_module - $minutes_module) / 60;
        $seconds = $minutes_module;
        return [$hours, $minutes, $seconds];
    }
    return NULL;
}
function cs_CalculateTimeLeft()
{
    loadModuleConfigs("castlesiege");
    $weekDays = ["", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
    $battleDay = $weekDays[mconfig("cs_battle_day")];
    $today = date("l");
    $battleTime = mconfig("cs_battle_time");
    $battleDate = strtotime("next " . $battleDay . " " . $battleTime);
    $timeOffset = $battleDate - time();
    if ($today == $battleDay) {
        $currentTime = strtotime(date("H:i:s"));
        $battleTimeToday = strtotime($battleTime);
        $timeOffsetToday = $battleTimeToday - time();
        if ($currentTime < $battleTimeToday) {
            return $timeOffsetToday;
        }
        $timeOffsetToday = $timeOffsetToday * -1;
        if ($timeOffsetToday < mconfig("cs_battle_duration") * 60) {
            return NULL;
        }
        return $timeOffset;
    }
    return $timeOffset;
}
function listCronFiles($selected = "")
{
    $dir = opendir(__PATH_CRON__);
    while (($file = readdir($dir)) !== false) {
        if (filetype(__PATH_CRON__ . $file) == "file" && $file != ".htaccess" && $file != "cron.php") {
            if (check_value($selected) && $selected == $file) {
                $return[] = "<option value=\"" . $file . "\" selected=\"selected\">" . $file . "</option>";
            } else {
                $return[] = "<option value=\"" . $file . "\">" . $file . "</option>";
            }
        }
    }
    closedir($dir);
    return join("", $return);
}
function cronFileAlreadyExists($cron_file)
{
    global $dB;
    $check = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_CRON WHERE cron_file_run = '" . $cron_file . "'");
    if (!is_array($check)) {
        return true;
    }
}
function addCron($cron_times)
{
    global $dB;
    if (check_value($_POST["cron_name"]) && check_value($_POST["cron_file"]) && check_value($_POST["cron_time"])) {
        $filePath = __PATH_CRON__ . $_POST["cron_file"];
        if (!file_exists($filePath)) {
            message("error", "The selected file doesn't exist.");
            return NULL;
        }
        if (!cronfilealreadyexists($_POST["cron_file"])) {
            message("error", "A cron job with the same file already exists.");
            return NULL;
        }
        if (!array_key_exists($_POST["cron_time"], $cron_times)) {
            message("error", "The selected cron time doesn't exist.");
            return NULL;
        }
        $sql_data = [$_POST["cron_name"], $_POST["cron_description"], $_POST["cron_file"], $cron_times[$_POST["cron_time"]], 1, md5_file($filePath)];
        $query = $dB->query("INSERT INTO IMPERIAMUCMS_CRON (cron_name, cron_description, cron_file_run, cron_run_time, cron_status, cron_file_md5) VALUES (?, ?, ?, ?, ?, ?)", $sql_data);
        if ($query) {
            updateCronCache();
            message("success", "Cron job successfully added!");
        } else {
            message("error", "Could not add cron job.");
        }
    } else {
        message("error", "Please complete all the required fields.");
    }
}
function updateCronLastRun($file)
{
    global $dB;
    $update = $dB->query("UPDATE IMPERIAMUCMS_CRON SET cron_last_run = '" . time() . "' WHERE cron_file_run = '" . $file . "'");
    if ($update) {
        updateCronCache();
    }
}
function updateCronCache()
{
    global $dB;
    $cacheDATA = buildcachedata($dB->query_fetch("SELECT * FROM IMPERIAMUCMS_CRON"));
    updatecache("cron.cache", $cacheDATA);
}
function getCronJobDATA($id)
{
    global $dB;
    $result = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_CRON WHERE cron_id = '" . $id . "'");
    if (is_array($result)) {
        return $result;
    }
}
function deleteCronJob($id)
{
    global $dB;
    $cronDATA = getcronjobdata($id);
    if (is_array($cronDATA)) {
        if ($cronDATA["cron_protected"]) {
            message("error", "This cron job is protected therefore cannot be deleted.");
            return NULL;
        }
        $delete = $dB->query("DELETE FROM IMPERIAMUCMS_CRON WHERE cron_id = '" . $id . "'");
        if ($delete) {
            message("success", "Cron job \"<strong>" . $cronDATA["cron_name"] . "</strong>\" successfully deteled!");
            updatecroncache();
        } else {
            message("error", "Could not delete cron job.");
        }
    } else {
        message("error", "Could not find cron job.");
    }
}
function togglestatusCronJob($id)
{
    global $dB;
    $cronDATA = getcronjobdata($id);
    if (is_array($cronDATA)) {
        if ($cronDATA["cron_status"] == 1) {
            $status = 0;
        } else {
            $status = 1;
        }
        $toggle = $dB->query("UPDATE IMPERIAMUCMS_CRON SET cron_status = " . $status . " WHERE cron_id = '" . $id . "'");
        if ($toggle) {
            message("success", "Cron job \"<strong>" . $cronDATA["cron_name"] . "</strong>\" status successfully changed!");
            updatecroncache();
        } else {
            message("error", "Could not update cron job.");
        }
    } else {
        message("error", "Could not find cron job.");
    }
}
function editCronJob($id, $name, $desc, $file, $time, $cron_times, $current_file)
{
    global $dB;
    if (check_value($name) && check_value($file) && check_value($time)) {
        $filePath = __PATH_CRON__ . $file;
        if (!file_exists($filePath)) {
            message("error", "The selected file doesn't exist.");
            return NULL;
        }
        if ($file != $current_file && !cronfilealreadyexists($file)) {
            message("error", "A cron job with the same file already exists.");
            return NULL;
        }
        if (!array_key_exists($time, $cron_times)) {
            message("error", "The selected cron time doesn't exist.");
            return NULL;
        }
        $query = $dB->query("UPDATE IMPERIAMUCMS_CRON SET cron_name = '" . $name . "', cron_description = '" . $desc . "', cron_file_run = '" . $file . "', cron_run_time = '" . $cron_times[$time] . "' WHERE cron_id = " . $id);
        if ($query) {
            updatecroncache();
            message("success", "Cron job successfully updated!");
        } else {
            message("error", "Could not edit cron job.");
        }
    } else {
        message("error", "You must fill all the required fields.");
    }
}
function rankingsExcludeChars()
{
    global $custom;
    if (!is_array($custom["rankings_exclude"])) {
        return NULL;
    }
    $return = [];
    foreach ($custom["rankings_exclude"] as $characterName) {
        $return[] = "'" . $characterName . "'";
    }
    return implode(",", $return);
}
function returnGuildLogo($binaryData = "", $size = 4, $fixImg = false)
{
    $fixImgClass = "";
    if ($fixImg) {
        $fixImgClass = " class=\"fix-img\"";
    }
    $imgSize = Validator::UnsignedNumber($size) ? $size : 40;
    $imgData = config("gmark_bin2hex_enable", true) ? bin2hex($binaryData) : $binaryData;
    return "<img src=\"" . __BASE_URL__ . "helper.php?req=" . $imgData . "&s=" . urlencode($size) . "\" width=\"" . $imgSize . "\" height=\"" . $imgSize . "\"" . $fixImgClass . ">";
}
function safe_input($string, $escape = "")
{
    $string = preg_replace("/[^A-Za-z0-9" . $escape . "]/", "", $string);
    return $string;
}
function xss_clean($data)
{
    $data = str_ireplace("SELECT ", "", $data);
    $data = str_ireplace("COPY ", "", $data);
    $data = str_ireplace("DELETE ", "", $data);
    $data = str_ireplace("DROP ", "", $data);
    $data = str_ireplace("DUMP ", "", $data);
    $data = str_ireplace(" OR ", "", $data);
    $data = str_ireplace("%", "", $data);
    $data = str_ireplace("LIKE ", "", $data);
    $data = str_ireplace("--", "", $data);
    $data = str_ireplace("\\", "", $data);
    $data = str_ireplace("¡", "", $data);
    $data = str_ireplace("&", "", $data);
    $data = str_replace(["&amp;", "&lt;", "&gt;"], ["&amp;amp;", "&amp;lt;", "&amp;gt;"], $data);
    $data = preg_replace("/(&#*\\w+)[\\x00-\\x20]+;/u", "\$1;", $data);
    $data = preg_replace("/(&#x*[0-9A-F]+);*/iu", "\$1;", $data);
    $data = html_entity_decode($data, ENT_COMPAT, "UTF-8");
    $data = preg_replace("#(<[^>]+?[\\x00-\\x20\"'])(?:on|xmlns)[^>]*+>#iu", "\$1>", $data);
    $data = preg_replace("#([a-z]*)[\\x00-\\x20]*=[\\x00-\\x20]*([`'\"]*)[\\x00-\\x20]*j[\\x00-\\x20]*a[\\x00-\\x20]*v[\\x00-\\x20]*a[\\x00-\\x20]*s[\\x00-\\x20]*c[\\x00-\\x20]*r[\\x00-\\x20]*i[\\x00-\\x20]*p[\\x00-\\x20]*t[\\x00-\\x20]*:#iu", "\$1=\$2nojavascript...", $data);
    $data = preg_replace("#([a-z]*)[\\x00-\\x20]*=(['\"]*)[\\x00-\\x20]*v[\\x00-\\x20]*b[\\x00-\\x20]*s[\\x00-\\x20]*c[\\x00-\\x20]*r[\\x00-\\x20]*i[\\x00-\\x20]*p[\\x00-\\x20]*t[\\x00-\\x20]*:#iu", "\$1=\$2novbscript...", $data);
    $data = preg_replace("#([a-z]*)[\\x00-\\x20]*=(['\"]*)[\\x00-\\x20]*-moz-binding[\\x00-\\x20]*:#u", "\$1=\$2nomozbinding...", $data);
    $data = preg_replace("#(<[^>]+?)style[\\x00-\\x20]*=[\\x00-\\x20]*[`'\"]*.*?expression[\\x00-\\x20]*\\([^>]*+>#i", "\$1>", $data);
    $data = preg_replace("#(<[^>]+?)style[\\x00-\\x20]*=[\\x00-\\x20]*[`'\"]*.*?behaviour[\\x00-\\x20]*\\([^>]*+>#i", "\$1>", $data);
    $data = preg_replace("#(<[^>]+?)style[\\x00-\\x20]*=[\\x00-\\x20]*[`'\"]*.*?s[\\x00-\\x20]*c[\\x00-\\x20]*r[\\x00-\\x20]*i[\\x00-\\x20]*p[\\x00-\\x20]*t[\\x00-\\x20]*:*[^>]*+>#iu", "\$1>", $data);
    $data = preg_replace("#</*\\w+:\\w[^>]*+>#i", "", $data);
    do {
        $old_data = $data;
        $data = preg_replace("#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i", "", $data);
    } while ($old_data === $data);
    return $data;
}
function hex_encode($input)
{
    return bin2hex($input);
}
function hex_decode($input)
{
    return pack("H*", $input);
}
function curl_file_get_contents($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $data = curl_exec($ch);
    if (false === $data) {
        echo curl_error($ch);
    }
    curl_close($ch);
    return $data;
}
function canAccessModule($username, $moduleName = NULL, $group = NULL)
{
    global $dB;
    global $dB2;
    if ($moduleName != NULL) {
        $moduleName = xss_clean($moduleName);
        $result = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_ACCESS_RESTRICTION WHERE AccountID = ? AND module = ?", [$username, $moduleName]);
    }
    if (config("SQL_USE_2_DB", true)) {
        $userData = $dB2->query_fetch_single("SELECT bloc_code FROM MEMB_INFO WHERE memb___id = ?", [$username]);
    } else {
        $userData = $dB->query_fetch_single("SELECT bloc_code FROM MEMB_INFO WHERE memb___id = ?", [$username]);
    }
    if ($userData["bloc_code"] == "1" && $group != NULL) {
        $group = xss_clean($group);
        if ($group != "allow") {
            canAccessModuleMsg($username, $moduleName, $group);
            return false;
        }
        return true;
    }
    if (is_array($result)) {
        if ($result["expiration"] == NULL) {
            canAccessModuleMsg($username, $moduleName, $group);
            return false;
        }
        if ($result["expiration"] < date("Y-m-d H:i:s", time())) {
            return true;
        }
        canAccessModuleMsg($username, $moduleName, $group);
        return false;
    }
    return true;
}
function canAccessModuleMsg($username, $moduleName = NULL, $group = NULL)
{
    global $dB;
    global $dB2;
    if ($moduleName != NULL) {
        $moduleName = xss_clean($moduleName);
        $result = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_ACCESS_RESTRICTION WHERE AccountID = ? AND module = ?", [$username, $moduleName]);
    }
    if (config("SQL_USE_2_DB", true)) {
        $userData = $dB2->query_fetch_single("SELECT bloc_code FROM MEMB_INFO WHERE memb___id = ?", [$username]);
    } else {
        $userData = $dB->query_fetch_single("SELECT bloc_code FROM MEMB_INFO WHERE memb___id = ?", [$username]);
    }
    if ($userData["bloc_code"] == "1" && $group != NULL) {
        $group = xss_clean($group);
        if ($group != "allow") {
            message("error", lang("global_module_14", true));
            return false;
        }
    }
    if (is_array($result)) {
        if ($result["expiration"] == NULL) {
            message("error", sprintf(lang("global_module_15", true), lang("global_module_16", true)));
            return false;
        }
        if ($result["expiration"] < date("Y-m-d H:i:s", time())) {
            return NULL;
        }
        message("error", sprintf(lang("global_module_15", true), date(config("time_date_format", true), strtotime($result["expiration"]))));
        return false;
    }
}
function print_r_formatted($arrayData)
{
    echo "<pre>";
    print_r($arrayData);
    echo "</pre>";
}
function returnDayName($dayCode)
{
    switch ($dayCode) {
        case 1:
            return lang("monday", true);
            break;
        case 2:
            return lang("tuesday", true);
            break;
        case 3:
            return lang("wednesday", true);
            break;
        case 4:
            return lang("thursday", true);
            break;
        case 5:
            return lang("friday", true);
            break;
        case 6:
            return lang("saturday", true);
            break;
        case 7:
            return lang("sunday", true);
            break;
    }
}
function decodeLicData($string)
{
    if (!$string) {
        return false;
    }
    $url = __IMPERIAMUCMS_LICENSE_SERVER__ . "apiversion.php";
    $apiType = curl_file_get_contents($url);
    if ($apiType == "1") {
        $encrypt_method = "AES-256-CBC";
        $secret_key = "XFmva8nIbtoV88dzQoioafgZlipk9dBNhU4nEeS3SHH94LkdES58ThOozVjG0wFdeLPE3ZUhIKMkCPWAn17XzJzQ1Ax3K0zzu2AP2BsxbwLi8HJI73IjkkVAUSphN87Wsxd7cKi8zqSxUIzbe2otwHvVeZH6UhL7yFepgnx0BumReJ2gfAQdAwY8VvS3LBfz5SysoUHlJUuIli7HeuePjtyC6lrfuo1lz6lxKqaCBGecoJNeGoYflkEBJNmkoIF9";
        $secret_iv = "xk3xudsF8XjuItROFaMuiDcPHdB0VhCpFx09glr02rO98zcTtT1lmKATtHEeiuKH";
        $key = hash("sha256", $secret_key);
        $iv = substr(hash("sha256", $secret_iv), 0, 16);
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        return $output;
    }
    return $string;
}
function moduleAccess($username, $module)
{
    $moduleCfg = loadConfigurations($module);
    $publicAccess = $moduleCfg["publicAccess"];
    $userAccess = $moduleCfg["userAccess"];
    $vipAccess = $moduleCfg["vipAccess"];
    $gmAccess = $moduleCfg["gmAccess"];
    $adminAccess = $moduleCfg["adminAccess"];
    $userType = 1;
    if (isloggedin()) {
        $userType = 2;
        $Character = new Character();
        if ($Character->isVIP($username)) {
            $userType = 3;
        }
        if (array_key_exists($username, config("gamemasters", true))) {
            $userType = 4;
        }
        if (array_key_exists($username, config("admins", true))) {
            $userType = 5;
        }
    }
    $canAccess = false;
    if ($publicAccess == "1") {
        $canAccess = true;
    }
    if ($userAccess == "1" && 2 <= $userType) {
        $canAccess = true;
    }
    if ($vipAccess == "1" && $userType == 3) {
        $canAccess = true;
    }
    if ($gmAccess == "1" && $userType == 4) {
        $canAccess = true;
    }
    if ($adminAccess == "1" && $userType == 5) {
        $canAccess = true;
    }
    if (!$canAccess) {
        return false;
    }
    return true;
}
function generatePagination($totalPages, $currentPage, $url)
{
    echo "<li><a href=\"" . str_replace("%pageHolder%", 1, $url) . "\">&laquo; <span class=\"sr-only\">First</span></a></li>";
    if (3 <= $currentPage) {
        $firstPage = $currentPage - 2;
        $lastPage = $currentPage + 2;
    } else {
        if ($currentPage == 2) {
            $firstPage = $currentPage - 1;
            $lastPage = $currentPage + 3;
        } else {
            $firstPage = $currentPage;
            $lastPage = $currentPage + 4;
        }
    }
    if ($firstPage < 1) {
        $firstPage = 1;
    }
    if ($totalPages < $lastPage) {
        $lastPage = $totalPages;
    }
    if ($currentPage == $lastPage && 5 <= $lastPage) {
        $firstPage -= 2;
    }
    if ($currentPage == $lastPage - 1 && 5 <= $lastPage) {
        $firstPage -= 1;
    }
    $i = $firstPage;
    while ($i <= $lastPage) {
        $pageUrl = str_replace("%pageHolder%", $i, $url);
        if ($i == $currentPage) {
            echo "<li class=\"active\"><a href=\"" . $pageUrl . "\">" . $i . " <span class=\"sr-only\">(current)</span></a></li>";
        } else {
            echo "<li><a href=\"" . $pageUrl . "\">" . $i . "</a></li>";
        }
        $i++;
    }
    echo "<li><a href=\"" . str_replace("%pageHolder%", $totalPages, $url) . "\">&raquo; <span class=\"sr-only\">Last</span></a></li>";
}
function loadIceWindValleyConfigs()
{
    $xml = simplexml_load_file(__PATH_INCLUDES__ . "files/IGCN/IceWindValley.xml");
    if ($xml !== false) {
        return $xml;
    }
    return NULL;
}
function monsterList()
{
    $monsters = [];
    $monsters["monster_all"] = "All";
    $monsters["monster_0"] = "Bull Fighter";
    $monsters["monster_1"] = "Hound";
    $monsters["monster_2"] = "Budge Dragon";
    $monsters["monster_3"] = "Spider";
    $monsters["monster_4"] = "Elite Bull Fighter";
    $monsters["monster_5"] = "Hellhound";
    $monsters["monster_6"] = "Lich";
    $monsters["monster_7"] = "Giant";
    $monsters["monster_8"] = "Poison Bull Fighter";
    $monsters["monster_9"] = "Thunder Lich";
    $monsters["monster_10"] = "Dark Knight";
    $monsters["monster_11"] = "Ghost";
    $monsters["monster_12"] = "Larva";
    $monsters["monster_13"] = "Hell Spider";
    $monsters["monster_14"] = "Skeleton";
    $monsters["monster_15"] = "Skeleton Archer";
    $monsters["monster_16"] = "Chief Skeleton Warrior";
    $monsters["monster_17"] = "Cyclops";
    $monsters["monster_18"] = "Gorgon";
    $monsters["monster_19"] = "Yeti";
    $monsters["monster_20"] = "Elite Yeti";
    $monsters["monster_21"] = "Assassin";
    $monsters["monster_22"] = "Ice Monster";
    $monsters["monster_23"] = "Hommerd";
    $monsters["monster_24"] = "Worm";
    $monsters["monster_25"] = "Ice Queen";
    $monsters["monster_26"] = "Goblin";
    $monsters["monster_27"] = "Chain Scorpion";
    $monsters["monster_28"] = "Beetle Monster";
    $monsters["monster_29"] = "Hunter";
    $monsters["monster_30"] = "Forest Monster";
    $monsters["monster_31"] = "Agon";
    $monsters["monster_32"] = "Stone Golem";
    $monsters["monster_33"] = "Elite Goblin";
    $monsters["monster_34"] = "Cursed Wizard";
    $monsters["monster_35"] = "Death Gorgon";
    $monsters["monster_36"] = "Shadow";
    $monsters["monster_37"] = "Devil";
    $monsters["monster_38"] = "Balrog";
    $monsters["monster_39"] = "Poison Shadow";
    $monsters["monster_40"] = "Death Knight";
    $monsters["monster_41"] = "Death Cow";
    $monsters["monster_42"] = "Red Dragon";
    $monsters["monster_43"] = "Golden Budge Dragon";
    $monsters["monster_44"] = "Dragon";
    $monsters["monster_45"] = "Bahamut";
    $monsters["monster_46"] = "Vepar";
    $monsters["monster_47"] = "Valkyrie";
    $monsters["monster_48"] = "Lizard King";
    $monsters["monster_49"] = "Hydra";
    $monsters["monster_50"] = "Sea Worm";
    $monsters["monster_51"] = "Great Bahamut";
    $monsters["monster_52"] = "Silver Valkyrie";
    $monsters["monster_53"] = "Golden Titan";
    $monsters["monster_54"] = "Golden Soldier";
    $monsters["monster_55"] = "Death King";
    $monsters["monster_56"] = "Death Bone";
    $monsters["monster_57"] = "Iron Wheel";
    $monsters["monster_58"] = "Tantalos";
    $monsters["monster_59"] = "Zaikan";
    $monsters["monster_60"] = "Bloody wolf";
    $monsters["monster_61"] = "Beam Knight";
    $monsters["monster_62"] = "Mutant";
    $monsters["monster_63"] = "Death Beam Knight";
    $monsters["monster_64"] = "Ogre Archer";
    $monsters["monster_65"] = "Elite Ogre";
    $monsters["monster_66"] = "Cursed king";
    $monsters["monster_67"] = "Metal Balrog";
    $monsters["monster_68"] = "Molt";
    $monsters["monster_69"] = "Alquamos";
    $monsters["monster_70"] = "Queen Rainier";
    $monsters["monster_71"] = "Mega Crust";
    $monsters["monster_72"] = "Phantom Knight";
    $monsters["monster_73"] = "Drakan";
    $monsters["monster_74"] = "Alpha Crust";
    $monsters["monster_75"] = "Great Drakan";
    $monsters["monster_76"] = "Phoenix Darkness shield";
    $monsters["monster_77"] = "Phoenix of Darkness";
    $monsters["monster_78"] = "Golden Goblin";
    $monsters["monster_79"] = "Golden Derkon";
    $monsters["monster_80"] = "Golden Lizard King";
    $monsters["monster_81"] = "Golden Vepar";
    $monsters["monster_82"] = "Golden Tantalos";
    $monsters["monster_83"] = "Golden Wheel";
    $monsters["monster_84"] = "Chief Skeleton Warrior 1";
    $monsters["monster_85"] = "Chief Skeleton Archer 1";
    $monsters["monster_86"] = "Dark Skull Soldier 1";
    $monsters["monster_87"] = "Giant Ogre 1";
    $monsters["monster_88"] = "Red Skeleton Knight 1";
    $monsters["monster_89"] = "Magic Skeleton 1";
    $monsters["monster_90"] = "Chief Skeleton Warrior 2";
    $monsters["monster_91"] = "Chief Skeleton Archer 2";
    $monsters["monster_92"] = "Dark Skull Soldier 2";
    $monsters["monster_93"] = "Giant Ogre 2";
    $monsters["monster_94"] = "Red Skeleton Knight 2";
    $monsters["monster_95"] = "Magic Skeleton 2";
    $monsters["monster_96"] = "Chief Skeleton Warrior 3";
    $monsters["monster_97"] = "Chief Skeleton Archer 3";
    $monsters["monster_98"] = "Dark Skull Soldier 3";
    $monsters["monster_99"] = "Giant Ogre 3";
    $monsters["monster_100"] = "Lance";
    $monsters["monster_101"] = "Iron Stick";
    $monsters["monster_102"] = "Fire";
    $monsters["monster_103"] = "Meteorite";
    $monsters["monster_104"] = "Trap";
    $monsters["monster_105"] = "Canon Trap";
    $monsters["monster_106"] = "Laser Trap";
    $monsters["monster_111"] = "Red Skeleton Knight 3";
    $monsters["monster_112"] = "Magic Skeleton 3";
    $monsters["monster_113"] = "Chief Skeleton Warrior 4";
    $monsters["monster_114"] = "Chief Skeleton Archer 4";
    $monsters["monster_115"] = "Dark Skull Soldier 4";
    $monsters["monster_116"] = "Giant Ogre 4";
    $monsters["monster_117"] = "Red Skeleton Knight 4";
    $monsters["monster_118"] = "Magic Skeleton 4";
    $monsters["monster_119"] = "Chief Skeleton Warrior 5";
    $monsters["monster_120"] = "Chief Skeleton Archer 5";
    $monsters["monster_121"] = "Dark Skull Soldier 5";
    $monsters["monster_122"] = "Giant Ogre 5";
    $monsters["monster_123"] = "Red Skeleton Knight 5";
    $monsters["monster_124"] = "Magic Skeleton 5";
    $monsters["monster_125"] = "Chief Skeleton Warrior 6";
    $monsters["monster_126"] = "Chief Skeleton Archer 6";
    $monsters["monster_127"] = "Dark Skull Soldier 6";
    $monsters["monster_128"] = "Giant Ogre 6";
    $monsters["monster_129"] = "Red Skeleton Knight 6";
    $monsters["monster_130"] = "Magic Skeleton 6";
    $monsters["monster_131"] = "Castle Gate";
    $monsters["monster_132"] = "Statue of Saint";
    $monsters["monster_133"] = "Statue of Saint";
    $monsters["monster_134"] = "Statue of Saint";
    $monsters["monster_135"] = "White wizard";
    $monsters["monster_136"] = "Destructive ogre soldier";
    $monsters["monster_137"] = "Destructive ogre archer";
    $monsters["monster_138"] = "Chief Skeleton Warrior 7";
    $monsters["monster_139"] = "Chief Skeleton Archer 7";
    $monsters["monster_140"] = "Dark Skull Soldier 7";
    $monsters["monster_141"] = "Giant Ogre 7";
    $monsters["monster_142"] = "Red Skeleton Knight 7";
    $monsters["monster_143"] = "Magic Skeleton 7";
    $monsters["monster_144"] = "Death Angel1";
    $monsters["monster_145"] = "Death Centurion1";
    $monsters["monster_146"] = "Blood Soldier1";
    $monsters["monster_147"] = "Aegis1";
    $monsters["monster_148"] = "Rogue Centurion1";
    $monsters["monster_149"] = "Necron1";
    $monsters["monster_150"] = "Bali";
    $monsters["monster_151"] = "Soldier";
    $monsters["monster_152"] = "Magic stone of 1";
    $monsters["monster_153"] = "Magic stone of 2";
    $monsters["monster_154"] = "Magic stone of 3";
    $monsters["monster_155"] = "Magic stone of 4";
    $monsters["monster_156"] = "Magic stone of 5";
    $monsters["monster_157"] = "Magic stone of 6";
    $monsters["monster_158"] = "Magic stone of 7";
    $monsters["monster_160"] = "Schriker1";
    $monsters["monster_161"] = "Illusion of Kundun1";
    $monsters["monster_162"] = "Chaos Castle 1";
    $monsters["monster_163"] = "Chaos Castle 1";
    $monsters["monster_164"] = "Chaos Castle 2";
    $monsters["monster_165"] = "Chaos Castle 2";
    $monsters["monster_166"] = "Chaos Castle 3";
    $monsters["monster_167"] = "Chaos Castle 3";
    $monsters["monster_168"] = "Chaos Castle 4";
    $monsters["monster_169"] = "Chaos Castle 4";
    $monsters["monster_170"] = "Chaos Castle 5";
    $monsters["monster_171"] = "Chaos Castle 5";
    $monsters["monster_172"] = "Chaos Castle 6";
    $monsters["monster_173"] = "Chaos Castle 6";
    $monsters["monster_174"] = "Death Angel2";
    $monsters["monster_175"] = "Death Centurion2";
    $monsters["monster_176"] = "Blood Soldier2";
    $monsters["monster_177"] = "Aegis2";
    $monsters["monster_178"] = "Rogue Centurion2";
    $monsters["monster_179"] = "Necron2";
    $monsters["monster_180"] = "Schriker2";
    $monsters["monster_181"] = "Illusion of Kundun2";
    $monsters["monster_182"] = "Death Angel3";
    $monsters["monster_183"] = "Death Centurion3";
    $monsters["monster_184"] = "Blood Soldier3";
    $monsters["monster_185"] = "Aegis3";
    $monsters["monster_186"] = "Rogue Centurion3";
    $monsters["monster_187"] = "Necron3";
    $monsters["monster_188"] = "Schriker3";
    $monsters["monster_189"] = "Illusion of Kundun3";
    $monsters["monster_190"] = "Death Angel 4";
    $monsters["monster_191"] = "Death Centurion4";
    $monsters["monster_192"] = "Blood Soldier4";
    $monsters["monster_193"] = "Aegis4";
    $monsters["monster_194"] = "Rogue Centurion4";
    $monsters["monster_195"] = "Necron4";
    $monsters["monster_196"] = "Schriker4";
    $monsters["monster_197"] = "Illusion of Kundun4";
    $monsters["monster_200"] = "Soccer Ball";
    $monsters["monster_204"] = "Wolf Status";
    $monsters["monster_205"] = "Wolf Altar1";
    $monsters["monster_206"] = "Wolf Altar2";
    $monsters["monster_207"] = "Wolf Altar3";
    $monsters["monster_208"] = "Wolf Altar4";
    $monsters["monster_209"] = "Wolf Altar5";
    $monsters["monster_215"] = "Shield";
    $monsters["monster_216"] = "Crown";
    $monsters["monster_217"] = "Crown Switch2";
    $monsters["monster_218"] = "Crown Switch1";
    $monsters["monster_219"] = "Castle Gate Switch";
    $monsters["monster_220"] = "Gatekeeper";
    $monsters["monster_221"] = "Slingshot attack";
    $monsters["monster_222"] = "Slingshot defense";
    $monsters["monster_223"] = "Senior";
    $monsters["monster_224"] = "Guardsman";
    $monsters["monster_226"] = "Trainer";
    $monsters["monster_229"] = "Marlon";
    $monsters["monster_230"] = "Wandering Merchant Alex";
    $monsters["monster_231"] = "Thompson Kenel";
    $monsters["monster_232"] = "Archangel";
    $monsters["monster_233"] = "Messenger of Archangel";
    $monsters["monster_234"] = "Pet Trainer";
    $monsters["monster_235"] = "Sebina the Priest";
    $monsters["monster_236"] = "Golden Archer";
    $monsters["monster_237"] = "Charon";
    $monsters["monster_238"] = "Chaos Goblin";
    $monsters["monster_239"] = "Arena Guard";
    $monsters["monster_240"] = "Safety Guardian";
    $monsters["monster_241"] = "Royal Guard Captain Lorence";
    $monsters["monster_242"] = "Elf Lala";
    $monsters["monster_243"] = "Gallus the Elder";
    $monsters["monster_244"] = "Caren the Barmaid";
    $monsters["monster_245"] = "Wizard Izabel";
    $monsters["monster_246"] = "Weapons Merchant Zienna";
    $monsters["monster_247"] = "Guard Archer";
    $monsters["monster_248"] = "Wandering Merchant Martin";
    $monsters["monster_249"] = "Guard Lancer";
    $monsters["monster_250"] = "Wandering Merchant";
    $monsters["monster_251"] = "Hanzo the Blacksmith";
    $monsters["monster_252"] = "NPC 252";
    $monsters["monster_253"] = "Potion Girl Amy";
    $monsters["monster_254"] = "Pasi the Mage";
    $monsters["monster_255"] = "Lumen the Barmaid";
    $monsters["monster_256"] = "Lahap";
    $monsters["monster_257"] = "Shadow Phantom Soldier";
    $monsters["monster_258"] = "Luke the Helper";
    $monsters["monster_259"] = "Oracle Layla";
    $monsters["monster_260"] = "Death Angel5";
    $monsters["monster_261"] = "Death Centurion5";
    $monsters["monster_262"] = "Blood Soldier5";
    $monsters["monster_263"] = "Aegis5";
    $monsters["monster_264"] = "Rogue Centurion5";
    $monsters["monster_265"] = "Necron5";
    $monsters["monster_266"] = "Schriker5";
    $monsters["monster_267"] = "Illusion of Kundun5";
    $monsters["monster_268"] = "Death Angel6";
    $monsters["monster_269"] = "Death Centurion6";
    $monsters["monster_270"] = "Blood Soldier6";
    $monsters["monster_271"] = "Aegis6";
    $monsters["monster_272"] = "Rogue Centurion6";
    $monsters["monster_273"] = "Necron6";
    $monsters["monster_274"] = "Schriker6";
    $monsters["monster_275"] = "Kundun7";
    $monsters["monster_277"] = "Castle Gate1";
    $monsters["monster_278"] = "Life Stone";
    $monsters["monster_283"] = "Guardian Statue";
    $monsters["monster_284"] = "Monster 284";
    $monsters["monster_285"] = "Guardian";
    $monsters["monster_286"] = "Archer";
    $monsters["monster_287"] = "Spearman";
    $monsters["monster_288"] = "Canon Tower";
    $monsters["monster_290"] = "Lizard Warrior";
    $monsters["monster_291"] = "Fire Golem";
    $monsters["monster_292"] = "Queen Bee";
    $monsters["monster_293"] = "Poison Golem";
    $monsters["monster_294"] = "Ax Warrior";
    $monsters["monster_295"] = "Erohim";
    $monsters["monster_296"] = "NPC 296";
    $monsters["monster_297"] = "PK Dark Knight";
    $monsters["monster_300"] = "Hero Mutant";
    $monsters["monster_301"] = "Omega Wing";
    $monsters["monster_302"] = "Axl Hero";
    $monsters["monster_303"] = "Gigas Golem";
    $monsters["monster_304"] = "Witch Queen";
    $monsters["monster_305"] = "Blue Golem";
    $monsters["monster_306"] = "Death Rider";
    $monsters["monster_307"] = "Forest Orc";
    $monsters["monster_308"] = "Death Tree";
    $monsters["monster_309"] = "Hell Maine";
    $monsters["monster_310"] = "Hammer Scout";
    $monsters["monster_311"] = "Lance Scout";
    $monsters["monster_312"] = "Bow Scout";
    $monsters["monster_313"] = "Werewolf";
    $monsters["monster_314"] = "Scout(Hero)";
    $monsters["monster_315"] = "Werewolf(Hero)";
    $monsters["monster_316"] = "Balram";
    $monsters["monster_317"] = "Soram";
    $monsters["monster_318"] = "Beam Knight (Hero)";
    $monsters["monster_319"] = "Chrome Dragon";
    $monsters["monster_331"] = "Aegis7";
    $monsters["monster_332"] = "Rogue Centurion7";
    $monsters["monster_333"] = "Blood Soldier7";
    $monsters["monster_334"] = "Death Angel7";
    $monsters["monster_335"] = "Necron7";
    $monsters["monster_336"] = "Death Centurion7";
    $monsters["monster_337"] = "Schriker7";
    $monsters["monster_338"] = "Illusion of Kundun6";
    $monsters["monster_340"] = "Dark Elf";
    $monsters["monster_341"] = "Soram";
    $monsters["monster_344"] = "Balram";
    $monsters["monster_345"] = "Death spirit";
    $monsters["monster_348"] = "Tanker";
    $monsters["monster_349"] = "Balgass";
    $monsters["monster_350"] = "Berserker";
    $monsters["monster_351"] = "Splinter Wolf";
    $monsters["monster_352"] = "Iron Rider";
    $monsters["monster_353"] = "Satyros";
    $monsters["monster_354"] = "Blade Hunter";
    $monsters["monster_355"] = "Kentauros";
    $monsters["monster_356"] = "Gigantis";
    $monsters["monster_357"] = "Genocider";
    $monsters["monster_358"] = "Persona";
    $monsters["monster_359"] = "Twin Tale";
    $monsters["monster_360"] = "Dreadfear";
    $monsters["monster_361"] = "Nightmare";
    $monsters["monster_362"] = "Maya Hand";
    $monsters["monster_363"] = "Maya Hand";
    $monsters["monster_364"] = "Maya";
    $monsters["monster_365"] = "Pouch of Blessing";
    $monsters["monster_367"] = "Gateway Machine";
    $monsters["monster_368"] = "Elpis";
    $monsters["monster_369"] = "Osbourne";
    $monsters["monster_370"] = "Jerridon";
    $monsters["monster_371"] = "Leo the Helper";
    $monsters["monster_372"] = "Elite Skull Soldier";
    $monsters["monster_373"] = "Jack Olantern";
    $monsters["monster_374"] = "Santa";
    $monsters["monster_375"] = "Chaos Card Master";
    $monsters["monster_376"] = "Pamela the Supplier";
    $monsters["monster_377"] = "Angela the Supplier";
    $monsters["monster_378"] = "GameMaster";
    $monsters["monster_379"] = "Natasha Firecracker Merchant";
    $monsters["monster_380"] = "Stone Statue";
    $monsters["monster_381"] = "MU Allies General";
    $monsters["monster_382"] = "Illusion Sorcerer Elder";
    $monsters["monster_383"] = "Alliance Sacred Item Storage";
    $monsters["monster_384"] = "Illusion Castle Sacred Item Storage";
    $monsters["monster_385"] = "Mirage";
    $monsters["monster_386"] = "Illusion Sorcerer Spirit A";
    $monsters["monster_387"] = "Illusion Sorcerer Spirit B";
    $monsters["monster_388"] = "Illusion Sorcerer Spirit C";
    $monsters["monster_389"] = "Illusion Sorcerer Spirit A";
    $monsters["monster_390"] = "Illusion Sorcerer Spirit B";
    $monsters["monster_391"] = "Illusion Sorcerer Spirit C";
    $monsters["monster_392"] = "Illusion Sorcerer Spirit A";
    $monsters["monster_393"] = "Illusion Sorcerer Spirit B";
    $monsters["monster_394"] = "Illusion Sorcerer Spirit C";
    $monsters["monster_395"] = "Illusion Sorcerer Spirit A";
    $monsters["monster_396"] = "Illusion Sorcerer Spirit B";
    $monsters["monster_397"] = "Illusion Sorcerer Spirit C";
    $monsters["monster_398"] = "Illusion Sorcerer Spirit A";
    $monsters["monster_399"] = "Illusion Sorcerer Spirit B";
    $monsters["monster_400"] = "Illusion Sorcerer Spirit C";
    $monsters["monster_401"] = "Illusion Sorcerer Spirit A";
    $monsters["monster_402"] = "Illusion Sorcerer Spirit B";
    $monsters["monster_403"] = "Illusion Sorcerer Spirit C";
    $monsters["monster_404"] = "MU Allies";
    $monsters["monster_405"] = "Illusion Sorcerer";
    $monsters["monster_406"] = "Apostle Devin";
    $monsters["monster_407"] = "Werewolf Quarel";
    $monsters["monster_408"] = "Gatekeeper";
    $monsters["monster_409"] = "Balram (Trainee Soldier)";
    $monsters["monster_410"] = "Death Spirit (Trainee Soldier)";
    $monsters["monster_411"] = "Soram (Trainee Soldier)";
    $monsters["monster_412"] = "Dark Elf (Trainee Soldier)";
    $monsters["monster_413"] = "Gold Rabbit";
    $monsters["monster_414"] = "Helper Ellen";
    $monsters["monster_415"] = "Silvia";
    $monsters["monster_416"] = "Rhea";
    $monsters["monster_417"] = "Marce";
    $monsters["monster_418"] = "Strange Rabbit";
    $monsters["monster_419"] = "Hideous Rabbit";
    $monsters["monster_420"] = "Werewolf";
    $monsters["monster_421"] = "Polluted Butterfly";
    $monsters["monster_422"] = "Cursed Lich";
    $monsters["monster_423"] = "Totem Golem";
    $monsters["monster_424"] = "Grizzly";
    $monsters["monster_425"] = "Captain Grizzly";
    $monsters["monster_426"] = "Chaos Castle7";
    $monsters["monster_427"] = "Chaos Castle7";
    $monsters["monster_428"] = "Chief Skeleton Warrior8";
    $monsters["monster_429"] = "Chief Skeleton Archer8";
    $monsters["monster_430"] = "Dark Skull Soldier8";
    $monsters["monster_431"] = "Giant Ogre8";
    $monsters["monster_432"] = "Red Skeleton Knight8";
    $monsters["monster_433"] = "Magic Skeleton8";
    $monsters["monster_434"] = "Gigantis";
    $monsters["monster_435"] = "Berserker";
    $monsters["monster_436"] = "Balram (Trainee Soldier)";
    $monsters["monster_437"] = "Soram (Trainee Soldier)";
    $monsters["monster_438"] = "Persona";
    $monsters["monster_439"] = "Dreadfear";
    $monsters["monster_440"] = "Dark Elf";
    $monsters["monster_441"] = "Sapi-Unus";
    $monsters["monster_442"] = "Sapi-Duo";
    $monsters["monster_443"] = "Sapi-Tres";
    $monsters["monster_444"] = "Shadow Pawn";
    $monsters["monster_445"] = "Shadow Knight";
    $monsters["monster_446"] = "Shadow Look";
    $monsters["monster_447"] = "Thunder Napin";
    $monsters["monster_448"] = "Ghost Napin";
    $monsters["monster_449"] = "Blaze Napin";
    $monsters["monster_450"] = "Cherry Blossom Spirit";
    $monsters["monster_451"] = "Cherry Blossom Tree";
    $monsters["monster_452"] = "Seed Master";
    $monsters["monster_453"] = "Seed Researcher";
    $monsters["monster_454"] = "Ice Walker";
    $monsters["monster_455"] = "Giant Mammoth";
    $monsters["monster_456"] = "Ice Giant";
    $monsters["monster_457"] = "Coolutin";
    $monsters["monster_458"] = "Iron Knight";
    $monsters["monster_459"] = "Selupan";
    $monsters["monster_460"] = "Spider Eggs1";
    $monsters["monster_461"] = "Spider Eggs2";
    $monsters["monster_462"] = "Spider Eggs3";
    $monsters["monster_463"] = "Fire Flame Ghost";
    $monsters["monster_464"] = "Re-Initialization Helper";
    $monsters["monster_465"] = "Santa Claus";
    $monsters["monster_466"] = "Cursed Goblin";
    $monsters["monster_467"] = "Snowman";
    $monsters["monster_468"] = "Dasher";
    $monsters["monster_469"] = "Kermit";
    $monsters["monster_470"] = "Dancer";
    $monsters["monster_471"] = "Cupid";
    $monsters["monster_472"] = "Prancer";
    $monsters["monster_473"] = "Donner";
    $monsters["monster_474"] = "Vixen";
    $monsters["monster_475"] = "Blitzen";
    $monsters["monster_476"] = "Cursed Santa";
    $monsters["monster_477"] = "Transformed Snowman";
    $monsters["monster_478"] = "Delgado";
    $monsters["monster_479"] = "Doorkeeper Titus";
    $monsters["monster_480"] = "Zombie Fighter";
    $monsters["monster_481"] = "Zombie Fighter";
    $monsters["monster_482"] = "Resurrected Gladiator";
    $monsters["monster_483"] = "Resurrected Gladiator";
    $monsters["monster_484"] = "Ash Slaughterer";
    $monsters["monster_485"] = "Ash Slaughterer";
    $monsters["monster_486"] = "Blood Assassin";
    $monsters["monster_487"] = "Cruel Blood Assassin";
    $monsters["monster_488"] = "Cruel Blood Assassin";
    $monsters["monster_489"] = "Burning Lava Giant";
    $monsters["monster_490"] = "Ruthless Lava Giant";
    $monsters["monster_491"] = "Ruthless Lava Giant";
    $monsters["monster_492"] = "Moss";
    $monsters["monster_493"] = "Golden Dark Knight";
    $monsters["monster_494"] = "Golden Devil";
    $monsters["monster_495"] = "Golden Stone Golem";
    $monsters["monster_496"] = "Golden Crust";
    $monsters["monster_497"] = "Golden Satyros";
    $monsters["monster_498"] = "Golden Twin Tail";
    $monsters["monster_499"] = "Golden Iron Knight";
    $monsters["monster_500"] = "Golden Napin";
    $monsters["monster_501"] = "Great Golden Dragon";
    $monsters["monster_502"] = "Golden Rabbit";
    $monsters["monster_503"] = "Transformed Panda";
    $monsters["monster_504"] = "Gaion Kharein";
    $monsters["monster_505"] = "Jerint";
    $monsters["monster_506"] = "Raymond";
    $monsters["monster_507"] = "Erkanne";
    $monsters["monster_508"] = "Destler";
    $monsters["monster_509"] = "Vermont";
    $monsters["monster_510"] = "Kato";
    $monsters["monster_511"] = "Galia";
    $monsters["monster_512"] = "Quartermaster";
    $monsters["monster_513"] = "Combat Instructor";
    $monsters["monster_514"] = "Knight Commander";
    $monsters["monster_515"] = "Grand Wizard";
    $monsters["monster_516"] = "Master Assassin";
    $monsters["monster_517"] = "Cavalry Captain";
    $monsters["monster_518"] = "Shield Bearer";
    $monsters["monster_519"] = "Medic";
    $monsters["monster_520"] = "Knights";
    $monsters["monster_521"] = "Bodyguard";
    $monsters["monster_522"] = "Jerint the Assistant";
    $monsters["monster_523"] = "Trap";
    $monsters["monster_524"] = "Castle Gate 1";
    $monsters["monster_525"] = "Castle Gate 2";
    $monsters["monster_526"] = "Stone Statue 1";
    $monsters["monster_527"] = "Castle Gate 3";
    $monsters["monster_528"] = "Castle Gate 4";
    $monsters["monster_529"] = "Furious Slaughterer";
    $monsters["monster_530"] = "Slaughterer";
    $monsters["monster_531"] = "Ice Walker";
    $monsters["monster_532"] = "Larva";
    $monsters["monster_533"] = "Doppelganger";
    $monsters["monster_534"] = "Doppelganger Elf";
    $monsters["monster_535"] = "Doppelganger Knight";
    $monsters["monster_536"] = "Doppelganger Wizard";
    $monsters["monster_537"] = "Doppelganger Magic Gladiator";
    $monsters["monster_538"] = "Doppelganger Dark Lord";
    $monsters["monster_539"] = "Doppelganger Summoner";
    $monsters["monster_540"] = "Lugard";
    $monsters["monster_541"] = "Interim Reward Chest";
    $monsters["monster_542"] = "Final Reward Chest";
    $monsters["monster_543"] = "Gens Duprian Steward";
    $monsters["monster_544"] = "Gens Vanert Steward";
    $monsters["monster_545"] = "Christine the Merchant";
    $monsters["monster_546"] = "Jeweller Raul";
    $monsters["monster_547"] = "Market Union Member Julia";
    $monsters["monster_548"] = "Transformed Skeleton";
    $monsters["monster_549"] = "Bloody Orc";
    $monsters["monster_550"] = "Bloody Death Rider";
    $monsters["monster_551"] = "Bloody Golem";
    $monsters["monster_552"] = "Bloody Witch Queen";
    $monsters["monster_553"] = "Berserker Warrior";
    $monsters["monster_554"] = "Kentauros Warrior";
    $monsters["monster_555"] = "Gigantis Warrior";
    $monsters["monster_556"] = "Genocider Warrior";
    $monsters["monster_557"] = "Sapi Queen";
    $monsters["monster_558"] = "Ice Napin";
    $monsters["monster_559"] = "Shadow Master";
    $monsters["monster_560"] = "Sapi Queen";
    $monsters["monster_561"] = "Medusa";
    $monsters["monster_562"] = "Dark Mammoth";
    $monsters["monster_563"] = "Dark Giant";
    $monsters["monster_564"] = "Dark Coolutin";
    $monsters["monster_565"] = "Dark Iron Knight";
    $monsters["monster_566"] = "Mercenary Guild Manager Tercia";
    $monsters["monster_567"] = "Priestess Veina";
    $monsters["monster_568"] = "Wandering Merchant Zyro";
    $monsters["monster_569"] = "Venomous Chain Scorpion";
    $monsters["monster_570"] = "Bone Scorpion";
    $monsters["monster_571"] = "Orcus";
    $monsters["monster_572"] = "Gollock";
    $monsters["monster_573"] = "Crypta";
    $monsters["monster_574"] = "Crypos";
    $monsters["monster_575"] = "Condra";
    $monsters["monster_576"] = "Narcondra";
    $monsters["monster_577"] = "Leina the Merchant";
    $monsters["monster_578"] = "Weapons Merchant Bolo";
    $monsters["monster_579"] = "David";
    $monsters["monster_580"] = "Captain Slough";
    $monsters["monster_581"] = "Deruvish";
    $monsters["monster_582"] = "Adniel";
    $monsters["monster_583"] = "Jin";
    $monsters["monster_584"] = "Sir Lesnar";
    $monsters["monster_585"] = "Scarecrow";
    $monsters["monster_586"] = "Devilfairy";
    $monsters["monster_587"] = "Elemental Beast";
    $monsters["monster_588"] = "Elemental Knight";
    $monsters["monster_589"] = "Ubaid Devilfairy";
    $monsters["monster_590"] = "Ubaid Elemental Beast";
    $monsters["monster_591"] = "Ubaid Elemental Knight";
    $monsters["monster_592"] = "Undine";
    $monsters["monster_593"] = "Salamander";
    $monsters["monster_594"] = "Sylphid";
    $monsters["monster_595"] = "Gnome";
    $monsters["monster_596"] = "Hellraiser";
    $monsters["monster_597"] = "Summoned Satyros";
    $monsters["monster_598"] = "Fire Tower";
    $monsters["monster_599"] = "Water Tower";
    $monsters["monster_600"] = "Earth Tower";
    $monsters["monster_601"] = "Wind Tower";
    $monsters["monster_602"] = "Darkness Tower";
    $monsters["monster_603"] = "Arca Barrier";
    $monsters["monster_604"] = "Jin";
    $monsters["monster_605"] = "Mining Area (Small)";
    $monsters["monster_606"] = "Mining Area (Medium)";
    $monsters["monster_607"] = "Mining Area (Large)";
    $monsters["monster_608"] = "Debenter Devilfairy";
    $monsters["monster_609"] = "Deventer Elemental Beast";
    $monsters["monster_610"] = "Debenter Elemental Knight";
    $monsters["monster_611"] = "Sellihoden";
    $monsters["monster_612"] = "Ukanva";
    $monsters["monster_613"] = "Silla";
    $monsters["monster_614"] = "Normus";
    $monsters["monster_615"] = "Muff";
    $monsters["monster_616"] = "Brown Bear Transformation Ring";
    $monsters["monster_617"] = "Pink Bear Ring";
    $monsters["monster_618"] = "[GM] Romeu";
    $monsters["monster_619"] = "[VM] Nox";
    $monsters["monster_620"] = "[VM] Redd";
    $monsters["monster_621"] = "[EVM] Iza";
    $monsters["monster_622"] = "[VM] Hail";
    $monsters["monster_623"] = "[VM] Fast";
    $monsters["monster_624"] = "[GM] Ceth";
    $monsters["monster_625"] = "Robot Knight Transformation Ring";
    $monsters["monster_626"] = "Mini Robot Transformation Ring";
    $monsters["monster_627"] = "Cursed Fire Tower";
    $monsters["monster_628"] = "Cursed Water Tower";
    $monsters["monster_629"] = "Cursed Earth Tower";
    $monsters["monster_630"] = "Cursed Wind Tower";
    $monsters["monster_631"] = "Cursed Darkness Tower";
    $monsters["monster_632"] = "Cursed Undine";
    $monsters["monster_633"] = "Cursed Salamander";
    $monsters["monster_634"] = "Cursed Sylphid";
    $monsters["monster_635"] = "Cursed Gnome";
    $monsters["monster_636"] = "Cursed Hellraiser";
    $monsters["monster_637"] = "Cursed Sellihoden";
    $monsters["monster_638"] = "Cursed Ukanva";
    $monsters["monster_639"] = "Cursed Silla";
    $monsters["monster_640"] = "Cursed Normus";
    $monsters["monster_641"] = "Cursed Muff";
    $monsters["monster_642"] = "Great Heavenly Mage Transformation Ring";
    $monsters["monster_643"] = "Mait";
    $monsters["monster_644"] = "Chaos Castle 8";
    $monsters["monster_645"] = "Chaos Castle 8";
    $monsters["monster_646"] = "Brown Panda Transformation Ring";
    $monsters["monster_647"] = "Green Snake (Green)";
    $monsters["monster_648"] = "Yellow Snake (Yellow)";
    $monsters["monster_649"] = "Purple Snake (Purple)";
    $monsters["monster_650"] = "Red Snake (Red)";
    $monsters["monster_651"] = "Private Store Bulletin Board";
    $monsters["monster_652"] = "Golden Goblin";
    $monsters["monster_653"] = "Golden Titan";
    $monsters["monster_654"] = "Golden Tantalos";
    $monsters["monster_655"] = "Golden Erohim";
    $monsters["monster_656"] = "Golden Hell Maine";
    $monsters["monster_657"] = "Golden Kundun";
    $monsters["monster_658"] = "Cursed Statue";
    $monsters["monster_659"] = "Captured Stone Statue";
    $monsters["monster_660"] = "Captured Stone Statue";
    $monsters["monster_661"] = "Captured Stone Statue";
    $monsters["monster_662"] = "Captured Stone Statue";
    $monsters["monster_663"] = "Captured Stone Statue";
    $monsters["monster_664"] = "Captured Stone Statue";
    $monsters["monster_665"] = "Captured Stone Statue";
    $monsters["monster_666"] = "Captured Stone Statue";
    $monsters["monster_667"] = "Captured Stone Statue";
    $monsters["monster_668"] = "Captured Stone Statue";
    $monsters["monster_669"] = "Ellin";
    $monsters["monster_670"] = "Uruk Devil Fairy";
    $monsters["monster_671"] = "Uruk Elemental Beast";
    $monsters["monster_672"] = "Uruk Elemental Knight";
    $monsters["monster_673"] = "Lord Silvester";
    $monsters["monster_674"] = "Moon Rabbit";
    $monsters["monster_675"] = "Pouch of Blessing";
    $monsters["monster_676"] = "Fire Flame Ghost";
    $monsters["monster_677"] = "Golden Goblin";
    $monsters["monster_678"] = "Lord Devil Fairy";
    $monsters["monster_679"] = "Lord Elemental Beast";
    $monsters["monster_680"] = "Lord Elemental Knight";
    $monsters["monster_681"] = "Evomon";
    $monsters["monster_682"] = "Monica";
    $monsters["monster_683"] = "Marce";
    $monsters["monster_684"] = "Silvia";
    $monsters["monster_685"] = "Izabel";
    $monsters["monster_686"] = "Sophia (repair)";
    $monsters["monster_687"] = "Bolo (repair)";
    $monsters["monster_688"] = "Christine";
    $monsters["monster_689"] = "Flame Trap";
    $monsters["monster_690"] = "Special Evomon";
    $monsters["monster_691"] = "New Year Horse (Green)";
    $monsters["monster_692"] = "New Year Horse (Yellow)";
    $monsters["monster_693"] = "New Year Horse (Brown)";
    $monsters["monster_694"] = "New Year Horse (Blue)";
    $monsters["monster_695"] = "Levine";
    $monsters["monster_704"] = "Evolution Succeeded";
    $monsters["monster_705"] = "Evolution Failed";
    $monsters["monster_706"] = "Darkness Transformation Ring";
    $monsters["monster_707"] = "Phantom of Dark Wizard";
    $monsters["monster_708"] = "Paralyze Barrier";
    $monsters["monster_709"] = "Chaos Goblin";
    $monsters["monster_710"] = "Chaos Goblin";
    $monsters["monster_711"] = "Chaos Goblin";
    $monsters["monster_712"] = "Chaos Goblin";
    $monsters["monster_713"] = "Nars Devil Fairy";
    $monsters["monster_714"] = "Nars Elemental Beast";
    $monsters["monster_715"] = "Nars Elemental Knight";
    $monsters["monster_716"] = "Core Magriffy";
    $monsters["monster_717"] = "Core Magriffy";
    $monsters["monster_718"] = "Core Magriffy";
    $monsters["monster_719"] = "Archangel's Spirit";
    $monsters["monster_720"] = "Charon";
    $monsters["monster_721"] = "Jerint the Assistant";
    $monsters["monster_722"] = "Mirage";
    $monsters["monster_723"] = "Rugard";
    $monsters["monster_724"] = "Chaos Goblin";
    $monsters["monster_725"] = "Priest James";
    $monsters["monster_726"] = "Green Goat";
    $monsters["monster_727"] = "White Goat";
    $monsters["monster_728"] = "Purple Goat";
    $monsters["monster_729"] = "Red Goat";
    $monsters["monster_730"] = "Ferea Knight";
    $monsters["monster_731"] = "Ferea Archer";
    $monsters["monster_732"] = "Ferea Fighter";
    $monsters["monster_733"] = "Ferea General";
    $monsters["monster_734"] = "Lord of Ferea";
    $monsters["monster_735"] = "Ferea Crystal Orb";
    $monsters["monster_736"] = "Ferea Knight";
    $monsters["monster_737"] = "Ferea Archer";
    $monsters["monster_738"] = "Ferea Fighter";
    $monsters["monster_739"] = "Green Monkey";
    $monsters["monster_740"] = "White Monkey";
    $monsters["monster_741"] = "Purple Monkey";
    $monsters["monster_742"] = "Red Monkey";
    $monsters["monster_743"] = "Paraca";
    $monsters["monster_744"] = "Vasuki";
    $monsters["monster_745"] = "Bass";
    $monsters["monster_746"] = "Nix";
    $monsters["monster_747"] = "Crystal Stone";
    $monsters["monster_748"] = "Spirit Nixie";
    $monsters["monster_749"] = "Elena";
    $monsters["monster_750"] = "Portal Top";
    $monsters["monster_751"] = "Portal Bottom";
    $monsters["monster_752"] = "Portal Left";
    $monsters["monster_753"] = "Portal Right";
    $monsters["monster_754"] = "Kundun's Giant Swordsman";
    $monsters["monster_755"] = "Kundun's Soldier";
    $monsters["monster_756"] = "Kundun's Spearman";
    $monsters["monster_757"] = "Labyrinth Goblin";
    $monsters["monster_758"] = "Portal of Dimension";
    $monsters["monster_759"] = "Green Rooster";
    $monsters["monster_760"] = "White Rooster";
    $monsters["monster_761"] = "Purple Rooster";
    $monsters["monster_762"] = "Red Rooster";
    $monsters["monster_763"] = "Cent (Monster)";
    $monsters["monster_764"] = "Cent (Town)";
    $monsters["monster_765"] = "Cent (Entrance)";
    $monsters["monster_766"] = "Cent (Quest)";
    $monsters["monster_767"] = "Deep Dungeon Skeleton Warrior";
    $monsters["monster_768"] = "Deep Dungeon Chief Skeleton Archer";
    $monsters["monster_769"] = "Deep Dungeon Chief Skeleton";
    $monsters["monster_770"] = "Deep Dungeon Larva";
    $monsters["monster_771"] = "Deep Dungeon Cyclops";
    $monsters["monster_772"] = "Deep Dungeon Ghost";
    $monsters["monster_773"] = "Deep Dungeon Hellhound";
    $monsters["monster_774"] = "Deep Dungeon Hell Spider";
    $monsters["monster_775"] = "Deep Dungeon Thunder Lich";
    $monsters["monster_776"] = "Deep Dungeon Poison Bull Fighter";
    $monsters["monster_777"] = "Deep Dungeon Dark Knight";
    $monsters["monster_778"] = "Deep Dungeon Gorgon";
    $monsters["monster_779"] = "Blood Soldier";
    $monsters["monster_780"] = "Necron";
    $monsters["monster_781"] = "Balram";
    $monsters["monster_782"] = "Soram";
    $monsters["monster_783"] = "Sapi Queen";
    $monsters["monster_784"] = "Ice Napin";
    $monsters["monster_785"] = "Dark Iron Knight";
    $monsters["monster_786"] = "Swamp Ent";
    $monsters["monster_787"] = "Wooden Beast";
    $monsters["monster_788"] = "Swamp Wizard";
    $monsters["monster_789"] = "Mutantile ";
    $monsters["monster_790"] = "Swamp Monster";
    $monsters["monster_791"] = "Swamp Summoned Beast";
    $monsters["monster_792"] = "Swamp Summoned Beast";
    $monsters["monster_793"] = "Water Monster";
    $monsters["monster_794"] = "God of Darkness";
    $monsters["monster_795"] = "Puppy (Green)";
    $monsters["monster_796"] = "Puppy (White)";
    $monsters["monster_797"] = "Puppy (Purple)";
    $monsters["monster_798"] = "Puppy (Yellow)";
    $monsters["monster_806"] = "Baseball Player Ring";
    $monsters["monster_807"] = "Cheerleader Ring";
    $monsters["monster_808"] = "Power Chicken";
    $monsters["monster_810"] = "Mine Digger";
    $monsters["monster_811"] = "Mine Carrier";
    $monsters["monster_812"] = "Mine Porter";
    $monsters["monster_813"] = "Mine Driller";
    $monsters["monster_814"] = "Dead Digger";
    $monsters["monster_815"] = "Dead Shoveler";
    $monsters["monster_816"] = "Dead Porter";
    $monsters["monster_817"] = "Pig (Green)";
    $monsters["monster_818"] = "Pig (Blue)";
    $monsters["monster_819"] = "Pig (Purple)";
    $monsters["monster_820"] = "Pig (Red)";
    $monsters["monster_821"] = "Weakness Field";
    $monsters["monster_822"] = "Innovation Field";
    $monsters["monster_832"] = "Bahamut of Abyss";
    $monsters["monster_833"] = "Vepar of Abyss";
    $monsters["monster_834"] = "Medium Bahamut of Abyss";
    $monsters["monster_835"] = "Silver Valkyrie of Abyss";
    $monsters["monster_836"] = "Great Bahamut of Abyss";
    $monsters["monster_837"] = "Lizard King of Abyss";
    $monsters["monster_838"] = "Elite Zone Flag";
    $monsters["monster_839"] = "(Elite) Great Bahamut of Abyss";
    $monsters["monster_840"] = "(Elite) Lizard King of Abyss";
    $monsters["monster_841"] = "Doppelganger Fighter";
    $monsters["monster_842"] = "Doppelganger Lancer";
    $monsters["monster_843"] = "Doppelganger Rune Wizard";
    $monsters["monster_844"] = "Doppelganger Slayer";
    $monsters["monster_845"] = "Scotched Warrior";
    $monsters["monster_846"] = "Scorched Wizard";
    $monsters["monster_847"] = "Scotch Assassin";
    $monsters["monster_848"] = "(Elite) Scorched Warrior";
    $monsters["monster_849"] = "(Elite) Scorched Assassins";
    $monsters["monster_850"] = "(Elite) Scorched Wizard";
    $monsters["monster_854"] = "Scorched Wizard";
    return $monsters;
}

?>