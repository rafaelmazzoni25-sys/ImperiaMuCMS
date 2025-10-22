<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

function gmcp_base($module = "")
{
    if (check_value($module)) {
        return __PATH_GMCP_HOME__ . "?module=" . $module;
    }
    return __PATH_GMCP_HOME__;
}
function enabledisableCheckboxes($name, $checked, $e_txt, $d_txt)
{
    echo "<div class=\"radio_switch\">";
    if ($checked == 1) {
        echo "<label class=\"on\"><input type=\"radio\" name=\"" . $name . "\" value=\"1\" checked><span>" . $e_txt . "</span></label>";
    } else {
        echo "<label class=\"on\"><input type=\"radio\" name=\"" . $name . "\" value=\"1\"><span>" . $e_txt . "</span></label>";
    }
    if ($checked == 0) {
        echo "<label class=\"off\"><input type=\"radio\" name=\"" . $name . "\" value=\"0\" checked><span>" . $d_txt . "</span></label>";
    } else {
        echo "<label class=\"off\"><input type=\"radio\" name=\"" . $name . "\" value=\"0\"><span>" . $d_txt . "</span></label>";
    }
    echo "</div>";
}
function enabledisableCheckboxes2($name, $checked, $e_txt, $d_txt)
{
    echo "<div class=\"radio_switch\">";
    if ($checked == 1) {
        echo "<label class=\"opt1\"><input type=\"radio\" name=\"" . $name . "\" value=\"1\" checked><span>" . $e_txt . "</span></label>";
    } else {
        echo "<label class=\"opt1\"><input type=\"radio\" name=\"" . $name . "\" value=\"1\"><span>" . $e_txt . "</span></label>";
    }
    if ($checked == 0) {
        echo "<label class=\"opt2\"><input type=\"radio\" name=\"" . $name . "\" value=\"0\" checked><span>" . $d_txt . "</span></label>";
    } else {
        echo "<label class=\"opt2\"><input type=\"radio\" name=\"" . $name . "\" value=\"0\"><span>" . $d_txt . "</span></label>";
    }
    echo "</div>";
}
function tableExists($table_name, $db)
{
    $tableExists = $db->query_fetch_single("SELECT * FROM sysobjects WHERE xtype = 'U' AND name = ?", [$table_name]);
    if (!$tableExists) {
        return false;
    }
    return true;
}
function checkVersion()
{
    $url = __IMPERIAMUCMS_LICENSE_SERVER__ . "version.php";
    $latestVersion = curl_file_get_contents($url);
    if (__IMPERIAMUCMS_VERSION__ < $latestVersion) {
        return true;
    }
    return false;
}
function latestVersion()
{
    $url = __IMPERIAMUCMS_LICENSE_SERVER__ . "version.php";
    $latestVersion = curl_file_get_contents($url);
    return $latestVersion;
}

?>