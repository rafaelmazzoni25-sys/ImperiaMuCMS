<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

if (check_value($_POST["submit_changes"])) {
    if (is_writable(__PATH_INCLUDES__ . "config.php")) {
        $configFile = file_get_contents(__PATH_INCLUDES__ . "config.php");
        $configTmp1 = strstr($configFile, "\$config[\"admins\"]");
        $configSave1 = strstr($configTmp1, "\$config[\"website_meta_description\"]", true);
        $configTmp2 = strstr($configTmp1, "\$config[\"SQL_DB_USER\"]");
        $configSave2 = strstr($configTmp2, "\$config[\"SQL_DB_PORT\"]", true);
        $configTmp3 = strstr($configTmp2, "\$config[\"language_switch_active\"]");
        $configSave3 = strstr($configTmp3, "\$config[\"gmark_bin2hex_enable\"]", true);
        if ($_POST["system_active"]) {
            $_POST["system_active"] = "true";
        } else {
            $_POST["system_active"] = "false";
        }
        if ($_POST["error_reporting"]) {
            $_POST["error_reporting"] = "true";
        } else {
            $_POST["error_reporting"] = "false";
        }
        if ($_POST["enable_logs"]) {
            $_POST["enable_logs"] = "true";
        } else {
            $_POST["enable_logs"] = "false";
        }
        if ($_POST["show_version"]) {
            $_POST["show_version"] = "true";
        } else {
            $_POST["show_version"] = "false";
        }
        if ($_POST["enable_ssl"]) {
            $_POST["enable_ssl"] = "true";
        } else {
            $_POST["enable_ssl"] = "false";
        }
        if (strlen($_POST["encryption_hash"] != 16)) {
            $_POST["encryption_hash"] = generaterandom(16);
        }
        if (empty($_POST["website_template"])) {
            $_POST["website_template"] = "default";
        }
        if (empty($_POST["server_name"])) {
            $_POST["server_name"] = "MU Online";
        }
        if (empty($_POST["website_folder"])) {
            $_POST["website_folder"] = "/";
        }
        if (empty($_POST["maintenance_page"])) {
            $_POST["maintenance_page"] = __IMPERIAMUCMS_LICENSE_SERVER__;
        }
        if ($_POST["use_resets"]) {
            $_POST["use_resets"] = "true";
        } else {
            $_POST["use_resets"] = "false";
        }
        if ($_POST["use_grand_resets"]) {
            $_POST["use_grand_resets"] = "true";
        } else {
            $_POST["use_grand_resets"] = "false";
        }
        if ($_POST["use_platinum"]) {
            $_POST["use_platinum"] = "true";
        } else {
            $_POST["use_platinum"] = "false";
        }
        if ($_POST["use_gold"]) {
            $_POST["use_gold"] = "true";
        } else {
            $_POST["use_gold"] = "false";
        }
        if ($_POST["use_silver"]) {
            $_POST["use_silver"] = "true";
        } else {
            $_POST["use_silver"] = "false";
        }
        if ($_POST["flags"]) {
            $_POST["flags"] = "true";
        } else {
            $_POST["flags"] = "false";
        }
        if ($_POST["show_wcoinc"]) {
            $_POST["show_wcoinc"] = "true";
        } else {
            $_POST["show_wcoinc"] = "false";
        }
        if ($_POST["show_gp"]) {
            $_POST["show_gp"] = "true";
        } else {
            $_POST["show_gp"] = "false";
        }
        if ($_POST["show_countdown"]) {
            $_POST["show_countdown"] = "true";
        } else {
            $_POST["show_countdown"] = "false";
        }
        if (empty($_POST["countdown_date"])) {
            $_POST["countdown_date"] = "2016/01/01 00:00";
        }
        if (empty($_POST["timezone_name"])) {
            $_POST["timezone_name"] = "Europe/Bratislava";
        }
        if (empty($_POST["time_date_format"])) {
            $_POST["time_date_format"] = "d/m/Y, H:i";
        }
        if (empty($_POST["time_date_format"])) {
            $_POST["time_date_format"] = "d/m/Y, H:i:s";
        }
        if (empty($_POST["date_format"])) {
            $_POST["date_format"] = "d/m/Y";
        }
        if (empty($_POST["time_format"])) {
            $_POST["time_format"] = "H:i";
        }
        if (empty($_POST["news_date"])) {
            $_POST["news_date"] = "d/m/Y";
        }
        if ($_POST["enable_scroll_down"]) {
            $_POST["enable_scroll_down"] = "true";
        } else {
            $_POST["enable_scroll_down"] = "false";
        }
        if (strlen($_POST["admincp_security"] != 128)) {
            $_POST["admincp_security"] = generaterandom(128);
        }
        if (empty($_POST["website_meta_description"])) {
            $_POST["website_meta_description"] = "MU Online Private Server";
        }
        if (empty($_POST["website_meta_keywords"])) {
            $_POST["website_meta_keywords"] = "muonline, mmo, mmo rpg, free, rpg";
        }
        if (empty($_POST["website_forum_link"])) {
            $_POST["website_forum_link"] = __IMPERIAMUCMS_LICENSE_SERVER__;
        }
        if (empty($_POST["SQL_DB_HOST"])) {
            $_POST["SQL_DB_HOST"] = "127.0.0.1";
        }
        if (empty($_POST["SQL_DB_NAME"])) {
            $_POST["SQL_DB_NAME"] = "MuOnline";
        }
        if (empty($_POST["SQL_DB_2_NAME"])) {
            $_POST["SQL_DB_2_NAME"] = "Me_MuOnline";
        }
        if (empty($_POST["SQL_DB_NAME_EVENTS"])) {
            $_POST["SQL_DB_NAME_EVENTS"] = "Events";
        }
        if (empty($_POST["SQL_DB_NAME_RANKING"])) {
            $_POST["SQL_DB_NAME_RANKING"] = "Ranking";
        }
        if (empty($_POST["SQL_DB_NAME_BATTLECORE"])) {
            $_POST["SQL_DB_NAME_BATTLECORE"] = "BattleCore";
        }
        if (empty($_POST["SQL_DB_PORT"])) {
            $_POST["SQL_DB_PORT"] = "1433";
        }
        if ($_POST["SQL_USE_2_DB"]) {
            $_POST["SQL_USE_2_DB"] = "true";
        } else {
            $_POST["SQL_USE_2_DB"] = "false";
        }
        if ($_POST["MEMB_CREDITS_MEMUONLINE"]) {
            $_POST["MEMB_CREDITS_MEMUONLINE"] = "true";
        } else {
            $_POST["MEMB_CREDITS_MEMUONLINE"] = "false";
        }
        if (empty($_POST["SQL_PDO_DRIVER"])) {
            $_POST["SQL_PDO_DRIVER"] = "3";
        }
        if (empty($_POST["SQL_ENABLE_MD5"])) {
            $_POST["SQL_ENABLE_MD5"] = "0";
        }
        if (empty($_POST["server_files"])) {
            $_POST["server_files"] = "IGCN";
        }
        if (empty($_POST["server_files_season"])) {
            $_POST["server_files_season"] = "60";
        }
        if ($_POST["gmark_bin2hex_enable"]) {
            $_POST["gmark_bin2hex_enable"] = "true";
        } else {
            $_POST["gmark_bin2hex_enable"] = "false";
        }
        if ($_POST["ip_block_system_enable"]) {
            $_POST["ip_block_system_enable"] = "true";
        } else {
            $_POST["ip_block_system_enable"] = "false";
        }
        if ($_POST["flood_check_enable"]) {
            $_POST["flood_check_enable"] = "true";
        } else {
            $_POST["flood_check_enable"] = "false";
        }
        if (empty($_POST["flood_actions_per_minute"])) {
            $_POST["flood_actions_per_minute"] = "60";
        }
        $server_names = "";
        if ($_POST["server_names"] != NULL && !empty($_POST["server_names"])) {
            $tmp = explode(",", $_POST["server_names"]);
            foreach ($tmp as $thisName) {
                if ($server_names == "") {
                    $server_names = "'" . $thisName . "'";
                } else {
                    $server_names .= ", '" . $thisName . "'";
                }
            }
        }
        $configNew1 = "<?php\r\n\r\n/**\r\n * ImperiaMuCMS\r\n * http://imperiamucms.com/\r\n *\r\n * @version 2.0.0\r\n * @author jacubb <admin@imperiamucms.com>\r\n * @copyright (c) 2014 - 2019, ImperiaMuCMS\r\n */\r\n\r\n/**\r\n * General Settings\r\n */\r\n\$config[\"system_active\"] = " . $_POST["system_active"] . "; // false - website is inactive, true - website is active\r\n\$config[\"error_reporting\"] = " . $_POST["error_reporting"] . "; // false - disabled error reporting, true - enabled error reporting\r\n\$config[\"enable_logs\"] = " . $_POST["enable_logs"] . "; // false - disabled, true - enabled enhanced \$_POST and \$_GET logs (./__logs/)\r\n\$config[\"website_template\"] = \"" . $_POST["website_template"] . "\";\r\n\$config[\"server_name\"] = \"" . $_POST["server_name"] . "\";\r\n\$config[\"website_folder\"] = \"" . $_POST["website_folder"] . "\"; // root folder of website, if website is in root folder (public_html, htdocs, etc.), use \"/\"\r\n\$config[\"encryption_hash\"] = \"" . $_POST["encryption_hash"] . "\"; // 16 characters ONLY !!!\r\n\$config[\"maintenance_page\"] = \"" . $_POST["maintenance_page"] . "\"; // website where you will be redirected, if website is inactive\r\n\$config[\"show_version\"] = " . $_POST["show_version"] . ";  // false = don't show website version in footer, true = show website version in footer\r\n\$config[\"default_charset\"] = \"" . $_POST["default_charset"] . "\";\r\n\$config[\"enable_ssl\"] = " . $_POST["enable_ssl"] . ";\r\n\$config[\"license_upgraded\"] = " . $_POST["license_upgraded"] . ";            \r\n\$config[\"enable_responsive\"] = " . $_POST["enable_responsive"] . ";    // Use only for responsive templates !!!\r\n\r\n\$config[\"use_resets\"] = " . $_POST["use_resets"] . "; // false - not using resets, true - using resets, column RESETS\r\n\$config[\"use_grand_resets\"] = " . $_POST["use_grand_resets"] . "; // false - not using grand resets, true - using grand resets, column Grand_Resets\r\n\$config[\"use_platinum\"] = " . $_POST["use_platinum"] . ";\r\n\$config[\"use_gold\"] = " . $_POST["use_gold"] . ";\r\n\$config[\"use_silver\"] = " . $_POST["use_silver"] . ";\r\n\$config[\"flags\"] = " . $_POST["flags"] . "; // false - disable country flags, true - enable country flags\r\n\r\n/**\r\n * Show/hide WCoinC/GP balance in UserCP\r\n * Do NOT enable it while you are using more than 1 website currencies (platinum, gold, silver coins)\r\n */\r\n\$config[\"show_wcoinc\"] = " . $_POST["show_wcoinc"] . ";\r\n\$config[\"show_gp\"] = " . $_POST["show_gp"] . ";\r\n\r\n/**\r\n * Countdown Settings\r\n */\r\n\$config[\"show_countdown\"] = " . $_POST["show_countdown"] . ";\r\n\$config[\"countdown_date\"] = \"" . $_POST["countdown_date"] . "\"; // format YYYY/MM/DD HH:MM\r\n\r\n/**\r\n * Time Zone Config\r\n */\r\n\$config[\"timezone_name\"] = \"" . $_POST["timezone_name"] . "\";\r\n\r\n/**\r\n * Time & Date Format Settings\r\n * http://php.net/manual/en/function.date.php\r\n */\r\n\$config[\"time_date_format\"] = \"" . $_POST["time_date_format"] . "\";\r\n\$config[\"time_date_format_logs\"] = \"" . $_POST["time_date_format_logs"] . "\";\r\n\$config[\"date_format\"] = \"" . $_POST["date_format"] . "\";\r\n\$config[\"time_format\"] = \"" . $_POST["time_format"] . "\";\r\n\$config[\"news_date\"] = \"" . $_POST["news_date"] . "\";\r\n\r\n/**\r\n * Automatic scroll-down into module\r\n */\r\n\$config[\"enable_scroll_down\"] = " . $_POST["enable_scroll_down"] . "; // false = disable auto scroll down, true = enable auto scroll down\r\n\r\n/**\r\n * AdminCP Security Password\r\n */\r\n\$config[\"admincp_security\"] = \"" . $_POST["admincp_security"] . "\";\r\n\r\n/**\r\n * Administrators\r\n * account => access level\r\n */\r\n";
        $configNew2 = "\$config[\"website_meta_description\"] = \"" . $_POST["website_meta_description"] . "\";\r\n\$config[\"website_meta_keywords\"] = \"" . $_POST["website_meta_keywords"] . "\";\r\n\$config[\"website_forum_link\"] = \"" . $_POST["website_forum_link"] . "\";\r\n\r\n/**\r\n * MSSQL Connection Details\r\n */\r\n\$config[\"SQL_DB_HOST\"] = \"" . $_POST["SQL_DB_HOST"] . "\";\r\n\$config[\"SQL_DB_NAME\"] = \"" . $_POST["SQL_DB_NAME"] . "\";\r\n\$config[\"SQL_DB_2_NAME\"] = \"" . $_POST["SQL_DB_2_NAME"] . "\";\r\n\$config[\"SQL_DB_NAME_EVENTS\"] = \"" . $_POST["SQL_DB_NAME_EVENTS"] . "\";\r\n\$config[\"SQL_DB_NAME_RANKING\"] = \"" . $_POST["SQL_DB_NAME_RANKING"] . "\";\r\n\$config[\"SQL_DB_NAME_BATTLECORE\"] = \"" . $_POST["SQL_DB_NAME_BATTLECORE"] . "\";\r\n";
        $configNew3 = "\$config[\"SQL_DB_PORT\"] = " . $_POST["SQL_DB_PORT"] . ";\r\n\$config[\"SQL_USE_2_DB\"] = " . $_POST["SQL_USE_2_DB"] . ";\r\n\$config[\"SQL_PDO_DRIVER\"] = " . $_POST["SQL_PDO_DRIVER"] . "; // 1 = dblib || 2 = sqlsrv || 3 = odbc\r\n\$config[\"SQL_ENABLE_MD5\"] = " . $_POST["SQL_ENABLE_MD5"] . "; // 0 = No MD5 || 1 = WZ_MD5 || 2 = IGC_MD5 || 3 = SHA256\r\n\$config[\"MEMB_CREDITS_MEMUONLINE\"] = " . $_POST["MEMB_CREDITS_MEMUONLINE"] . "; // false = MEMB_CREDITS table is loaded from MuOnline, true = MEMB_CREDITS table is loaded from Me_MuOnline\r\n\$config[\"server_names\"] = array(" . $server_names . "); // list of server names used by this website, e.g. array('HARD-PvP-1', 'HARD-PvP-2', 'HARD-NonPvP-1', 'HARD-NonPvP-2');\r\n\r\n/**\r\n * Server Files\r\n * - IGCN\r\n * - XTEAM\r\n */\r\n\$config[\"server_files\"] = \"" . $_POST["server_files"] . "\";\r\n\$config[\"server_files_season\"] = " . $_POST["server_files_season"] . ";    // 60 = S6, 80 = S8, 90 = S9, 100 = SX, 121 = S12 P1, 122 = S12 P2, 131 = S13 P1\r\n\r\n/**\r\n * Language System\r\n * ISO 639-1\r\n */\r\n";
        $configNew4 = "\$config[\"gmark_bin2hex_enable\"] = " . $_POST["gmark_bin2hex_enable"] . ";\r\n\r\n/**\r\n * Ip Blocking System\r\n */\r\n\$config[\"ip_block_system_enable\"] = " . $_POST["ip_block_system_enable"] . ";\r\n\r\n/**\r\n * Anti-flood System (basic)\r\n */\r\n\$config[\"flood_check_enable\"] = " . $_POST["flood_check_enable"] . ";\r\n\$config[\"flood_actions_per_minute\"] = " . $_POST["flood_actions_per_minute"] . "; // lower = more strict";
        $fileContent = $configNew1 . $configSave1 . $configNew2 . $configSave2 . $configNew3 . $configSave3 . $configNew4;
        file_put_contents(__PATH_INCLUDES__ . "config.php", $fileContent);
        message("success", "Settings were successfully saved.");
        message("notice", "Please click <a href=\"" . admincp_base("website_config") . "\">HERE</a> to load updated settings.");
    } else {
        message("error", __PATH_INCLUDES__ . "config.php is not writable!");
    }
}
$templates = glob(__PATH_TEMPLATES__ . "*", GLOB_ONLYDIR);
$templatesSelect = "";
foreach ($templates as $thisTemplate) {
    if (basename($thisTemplate) == $config["website_template"]) {
        $templatesSelect .= "<option value=\"" . basename($thisTemplate) . "\" selected=\"selected\">" . basename($thisTemplate) . "</option>";
    } else {
        $templatesSelect .= "<option value=\"" . basename($thisTemplate) . "\">" . basename($thisTemplate) . "</option>";
    }
}
$server_names = "";
foreach ($config["server_names"] as $thisName) {
    if ($server_names == "") {
        $server_names = $thisName;
    } else {
        $server_names .= "," . $thisName;
    }
}
echo "<h2>General Settings</h2>\r\n\r\n<form action=\"\" method=\"post\">\r\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n        <tr>\r\n            <th>System Active<br/><span>If disabled, users will be redirected to maintenance page.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("system_active", $config["system_active"], "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Error Reporting<br/><span>Enable it only during testing, DO NOT use it on live website.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("error_reporting", $config["error_reporting"], "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Extended Logs<br/><span>If enabled, website will keeps tracking activity of users on the website. Logs are stored in \"__logs\" folder in root directory of the website.</span>\r\n            </th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("enable_logs", $config["enable_logs"], "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Default Charset<br/><span>Select default charset. If you are not sure, for what it is, use \"UTF-8\".<br>\r\n                    PHP Documentation: <a href=\"http://php.net/manual/en/mbstring.supported-encodings.php\"\r\n                                          target=\"_blank\">HERE</a></span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"default_charset\"\r\n                       value=\"";
echo $config["default_charset"];
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Enable SSL<br/><span>Enable SSL in case you are using HTTPS on your website, otherwise it MUST be disabled.</span>\r\n            </th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("enable_ssl", $config["enable_ssl"], "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n\r\n        <tr>\r\n            <th>License Upgraded<br/><span>Must be set to \"Yes\" if you are using version 2.0.0 or newer.</span>\r\n            </th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("license_upgraded", $config["license_upgraded"], "Yes", "No");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Enable Responsivity<br/><span>If enabled, all modules will be loaded in responsive mode.</span>\r\n            </th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("enable_responsive", $config["enable_responsive"], "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n\r\n        <tr>\r\n            <th>Website Template<br/><span>Select template for your website.</span></th>\r\n            <td>\r\n                <select name=\"website_template\" class=\"form-control\">\r\n                    ";
if (!empty($templatesSelect)) {
    echo $templatesSelect;
} else {
    echo "<option value=\"-1\">None</option>";
}
echo "                </select>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Server Name<br/><span>Choose your server's name.</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"server_name\" value=\"";
echo $config["server_name"];
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Website Folder<br/><span>For example, if your website is running on http://muonline.com/ImperiaMuCMS, use value \"/ImperiaMuCMS/\".<br>\r\n                if your website is running on http://muonline.com/, use value \"/\".</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"website_folder\" value=\"";
echo $config["website_folder"];
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Encryption Hash<br/><span>Used by encryption system on the website.<br>Requires 16 symbols.</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"encryption_hash\" value=\"";
echo $config["encryption_hash"];
echo "\"\r\n                       maxlength=\"16\" minlength=\"16\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Maintenance Page<br/><span>If website is disabled, users will be redirected to this page.</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"maintenance_page\"\r\n                       value=\"";
echo $config["maintenance_page"];
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Show Version<br/><span>If enabled, in footer will be visible your current version of website.</span>\r\n            </th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("show_version", $config["show_version"], "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Automated Scroll Down<br/><span>If enabled, page will scroll down to content after load (used for all pages except index).</span>\r\n            </th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("enable_scroll_down", $config["enable_scroll_down"], "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Guild Logo bin2hex<br/><span>If you have problems with displaying correct Guild Logo, change value of this setting.</span>\r\n            </th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("gmark_bin2hex_enable", $config["gmark_bin2hex_enable"], "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Forum Link<br><span>Link to your community forums.</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"website_forum_link\"\r\n                       value=\"";
echo $config["website_forum_link"];
echo "\"/>\r\n            </td>\r\n        </tr>\r\n    </table>\r\n    <h3>SEO Settings</h3>\r\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n        <tr>\r\n            <th>META Description<br><span></span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"website_meta_description\"\r\n                       value=\"";
echo $config["website_meta_description"];
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>META Description</th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"website_meta_keywords\"\r\n                       value=\"";
echo $config["website_meta_keywords"];
echo "\"/>\r\n            </td>\r\n        </tr>\r\n    </table>\r\n    </table>\r\n    <h3>Database Settings\r\n        <small>(Configuration of SQL User & Password is available only in config.php file)</small>\r\n    </h3>\r\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n        <tr>\r\n            <th>SQL Host<br><span>Use IP or IP\\PC-NAME\\SQL-INSTANCE-NAME to connect to your MSSQL Server.</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"SQL_DB_HOST\" value=\"";
echo $config["SQL_DB_HOST"];
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Database MuOnline<br><span>Name of MuOnline database.</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"SQL_DB_NAME\" value=\"";
echo $config["SQL_DB_NAME"];
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Database Me_MuOnline<br><span>Name of Me_MuOnline database.</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"SQL_DB_2_NAME\" value=\"";
echo $config["SQL_DB_2_NAME"];
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Database Events<br><span>Name of Events database.</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"SQL_DB_NAME_EVENTS\"\r\n                       value=\"";
echo $config["SQL_DB_NAME_EVENTS"];
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Database Ranking<br><span>Name of Ranking database.</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"SQL_DB_NAME_RANKING\"\r\n                       value=\"";
echo $config["SQL_DB_NAME_RANKING"];
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Database BattleCore<br><span>Name of BattleCore database.</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"SQL_DB_NAME_BATTLECORE\"\r\n                       value=\"";
echo $config["SQL_DB_NAME_BATTLECORE"];
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>SQL Port<br><span>Port for MSSQL Server. Default 1433. DO NOT forget open MSSQL port in firewall if you are connecting to database remotely for website's IP ONLY.</span>\r\n            </th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"SQL_DB_PORT\" value=\"";
echo $config["SQL_DB_PORT"];
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Use Me_MuOnline\r\n                Database<br/><span>Enable if you are using Me_MuOnline database to store accounts.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("SQL_USE_2_DB", $config["SQL_USE_2_DB"], "Yes", "No");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>SQL PDO Driver<br><span>Select PHP PDO driver.</span></th>\r\n            <td>\r\n                <select name=\"SQL_PDO_DRIVER\" class=\"form-control\">\r\n                    ";
if (extension_loaded("pdo_dblib")) {
    if ($config["SQL_PDO_DRIVER"] == 1) {
        echo "<option value=\"1\" selected=\"selected\">DBLib</option>";
    } else {
        echo "<option value=\"1\">DBLib</option>";
    }
}
if (extension_loaded("PDO_SQLSRV")) {
    if ($config["SQL_PDO_DRIVER"] == 2) {
        echo "<option value=\"2\" selected=\"selected\">SQLSrv</option>";
    } else {
        echo "<option value=\"2\">SQLSrv</option>";
    }
}
if (extension_loaded("PDO_ODBC")) {
    if ($config["SQL_PDO_DRIVER"] == 3) {
        echo "<option value=\"3\" selected=\"selected\">ODBC</option>";
    } else {
        echo "<option value=\"3\">ODBC</option>";
    }
}
echo "                </select>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>SQL MD5 Type<br><span>Select password encryption type (MUST be the same as you are using in DataServer configuration).</span>\r\n            </th>\r\n            <td>\r\n                <select name=\"SQL_ENABLE_MD5\" class=\"form-control\">\r\n                    ";
if ($config["SQL_ENABLE_MD5"] == 0) {
    echo "<option value=\"0\" selected=\"selected\">None</option>";
} else {
    echo "<option value=\"0\">None</option>";
}
if ($config["SQL_ENABLE_MD5"] == 1) {
    echo "<option value=\"1\" selected=\"selected\">WZ MD5</option>";
} else {
    echo "<option value=\"1\">WZ MD5</option>";
}
if ($config["SQL_ENABLE_MD5"] == 2) {
    echo "<option value=\"2\" selected=\"selected\">IGC MD5</option>";
} else {
    echo "<option value=\"2\">IGC MD5</option>";
}
if ($config["SQL_ENABLE_MD5"] == 3) {
    echo "<option value=\"3\" selected=\"selected\">SHA256</option>";
} else {
    echo "<option value=\"3\">SHA256</option>";
}
echo "                </select>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Credits in Me_MuOnline Database<br/><span>Enable if you want to use website currencies from Me_MuOnline database.<br>\r\n                If enabled, you will have to create MEMB_CREDITS table in Me_MuOnline database (copy it from MuOnline database - right-click on MEMB_CREDITS table -> Script Table as -> CREATE To -> New Query Editor Window and execute script over Me_MuOnline database).<br>\r\n                If enabled, you will have to edit configuration of website currencies. Click <a\r\n                            href=\"";
echo admincp_base("creditsconfigs");
echo "\" target=\"_blank\">HERE</a> and edit database type to Me_MuOnline for Platinum, Gold & Silver Coins.</span>\r\n            </th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("MEMB_CREDITS_MEMUONLINE", $config["MEMB_CREDITS_MEMUONLINE"], "Yes", "No");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Server Names<br><span>Enter server names what are used by this website. Use only if \"Use Me_MuOnline Database\" is enabled.<br>You must enter exact names from Game Server configs and separate names by comma (\",\").<br>Example: Hard-PvP1,Hard-PvP2,Hard-PvP3,Hard-VIP</span>\r\n            </th>\r\n            <td>\r\n                <textarea name=\"server_names\" class=\"form-control\">";
echo $server_names;
echo "</textarea>\r\n            </td>\r\n        </tr>\r\n    </table>\r\n    <h3>Server Files Settings</h3>\r\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n        <tr>\r\n            <th>Server Files<br><span>Select your server files.</span></th>\r\n            <td>\r\n                <select name=\"server_files\" class=\"form-control\">\r\n                    <option value=\"IGCN\">IGCN</option>\r\n                    <!--<option value=\"XTEAM\">X-TEAM</option>-->\r\n                </select>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Server Files Season<br/><span>Please select your server files season.</span></th>\r\n            <td>\r\n                <select name=\"server_files_season\" class=\"form-control\">\r\n                    ";
if ($config["server_files_season"] == "60") {
    echo "<option value=\"60\" selected=\"selected\">Season 6</option>";
} else {
    echo "<option value=\"60\">Season 6</option>";
}
if ($config["server_files_season"] == "80") {
    echo "<option value=\"80\" selected=\"selected\">Season 8</option>";
} else {
    echo "<option value=\"80\">Season 8</option>";
}
if ($config["server_files_season"] == "90") {
    echo "<option value=\"90\" selected=\"selected\">Season 9</option>";
} else {
    echo "<option value=\"90\">Season 9</option>";
}
if ($config["server_files_season"] == "100") {
    echo "<option value=\"100\" selected=\"selected\">Season 10</option>";
} else {
    echo "<option value=\"100\">Season 10</option>";
}
if ($config["server_files_season"] == "121") {
    echo "<option value=\"121\" selected=\"selected\">Season 12 Part 1</option>";
} else {
    echo "<option value=\"121\">Season 12 Part 1</option>";
}
if ($config["server_files_season"] == "122") {
    echo "<option value=\"122\" selected=\"selected\">Season 12 Part 2</option>";
} else {
    echo "<option value=\"122\">Season 12 Part 2</option>";
}
if ($config["server_files_season"] == "131") {
    echo "<option value=\"131\" selected=\"selected\">Season 13 Part 1</option>";
} else {
    echo "<option value=\"131\">Season 13 Part 1</option>";
}
if ($config["server_files_season"] == "132") {
    echo "<option value=\"132\" selected=\"selected\">Season 13 Part 2</option>";
} else {
    echo "<option value=\"132\">Season 13 Part 2</option>";
}
if ($config["server_files_season"] == "140") {
    echo "<option value=\"140\" selected=\"selected\">Season 14</option>";
} else {
    echo "<option value=\"140\">Season 14</option>";
}
if ($config["server_files_season"] == "150") {
    echo "<option value=\"150\" selected=\"selected\">Season 15</option>";
} else {
    echo "<option value=\"150\">Season 15</option>";
}
echo "                </select>\r\n            </td>\r\n        </tr>\r\n    </table>\r\n    <h3>Modules Settings</h3>\r\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n        <tr>\r\n            <th>Use Resets<br/><span>Enable/disable usaage of resets.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("use_resets", $config["use_resets"], "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Use Grand Resets<br/><span>Enable/disable usaage of grand resets.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("use_grand_resets", $config["use_grand_resets"], "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Use Platinum Coins<br/><span>Enable/disable usaage of platinum coins.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("use_platinum", $config["use_platinum"], "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Use Gold Coins<br/><span>Enable/disable usaage of gold coins.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("use_gold", $config["use_gold"], "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Use Silver Coins<br/><span>Enable/disable usaage of silver coins.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("use_silver", $config["use_silver"], "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Use Flags<br/><span>Enable/disable usaage of flags.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("flags", $config["flags"], "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Show\r\n                WCoinC<br/><span>Shows WCoinC balance in membership area above page's content. DO NOT enable it if you are using 2 or more website currencies. Used ONLY by default template.</span>\r\n            </th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("show_wcoinc", $config["show_wcoinc"], "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Show Goblin Points<br/><span>Shows GoblinPoint balance in membership area above page's content. DO NOT enable it if you are using 2 or more website currencies. Used ONLY by default template.</span>\r\n            </th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("show_gp", $config["show_gp"], "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n    </table>\r\n    <h3>Countdown Settings</h3>\r\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n        <tr>\r\n            <th>Show Countdown<br/><span>Enable/disable countdown.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("show_countdown", $config["show_countdown"], "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Countdown Date<br/><span>Format: YYYY/MM/DD HH:MM</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"countdown_date\" value=\"";
echo $config["countdown_date"];
echo "\"\r\n                       placeholder=\"";
echo date("Y/m/d H:i", time());
echo "\"/>\r\n            </td>\r\n        </tr>\r\n    </table>\r\n    <h3>Time & Date Settings</h3>\r\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n        <tr>\r\n            <th>Time Zone Name<br/><span>More info: <a href=\"http://php.net/manual/en/timezones.php\" target=\"_blank\">http://php.net/manual/en/timezones.php</a></span>\r\n            </th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"timezone_name\" value=\"";
echo $config["timezone_name"];
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Time & Date Format<br/><span>More info: <a href=\"http://php.net/manual/en/function.date.php\"\r\n                                                           target=\"_blank\">http://php.net/manual/en/function.date.php</a></span>\r\n            </th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"time_date_format\"\r\n                       value=\"";
echo $config["time_date_format"];
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Logs Time & Date Format<br/><span>More info: <a href=\"http://php.net/manual/en/function.date.php\"\r\n                                                                target=\"_blank\">http://php.net/manual/en/function.date.php</a></span>\r\n            </th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"time_date_format_logs\"\r\n                       value=\"";
echo $config["time_date_format_logs"];
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Date Format<br/><span>More info: <a href=\"http://php.net/manual/en/function.date.php\" target=\"_blank\">http://php.net/manual/en/function.date.php</a></span>\r\n            </th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"date_format\" value=\"";
echo $config["date_format"];
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Time Format<br/><span>More info: <a href=\"http://php.net/manual/en/function.date.php\" target=\"_blank\">http://php.net/manual/en/function.date.php</a></span>\r\n            </th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"time_format\" value=\"";
echo $config["time_format"];
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>News Date Format<br/><span>More info: <a href=\"http://php.net/manual/en/function.date.php\"\r\n                                                         target=\"_blank\">http://php.net/manual/en/function.date.php</a></span>\r\n            </th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"news_date\" value=\"";
echo $config["news_date"];
echo "\"/>\r\n            </td>\r\n        </tr>\r\n    </table>\r\n    <h3>Security Settings</h3>\r\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n        <tr>\r\n            <th>AdminCP Security\r\n                Password<br><span>Security password is used for direct login into your AdminCP. ";
echo __BASE_URL__;
echo "admincp/login.php</span>\r\n            </th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"admincp_security\"\r\n                       value=\"";
echo $config["admincp_security"];
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>IP Block System<br/><span>Enable/disable IP Block System. You can block IP address to access your website <a\r\n                            href=\"";
echo admincp_base("blockedips");
echo "\" target=\"_blank\">HERE</a>.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("ip_block_system_enable", $config["ip_block_system_enable"], "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Basic Anti-Flood System<br/><span>Enable/disable basic anti-flood protection on website.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("flood_check_enable", $config["flood_check_enable"], "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Flood Actions per Minute<br><span>Lower value = more strict.</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"flood_actions_per_minute\"\r\n                       value=\"";
echo $config["flood_actions_per_minute"];
echo "\"/>\r\n            </td>\r\n        </tr>\r\n    </table>\r\n    <input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\" class=\"btn btn-success\"/>\r\n</form>";
function generateRandom($length)
{
    $possibleChars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $password = "";
    $i = 0;
    while ($i < $length) {
        $rand = rand(0, strlen($possibleChars) - 1);
        $password .= substr($possibleChars, $rand, 1);
        $i++;
    }
    return $password;
}

?>