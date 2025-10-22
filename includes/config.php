<?php

/**
 * ImperiaMuCMS
 * http://imperiamucms.com/
 *
 * @version 2.0.0
 * @author jacubb <admin@imperiamucms.com>
 * @copyright (c) 2014 - 2019, ImperiaMuCMS
 */

/**
 * General Settings
 */
$config["system_active"] = true; // false - website is inactive, true - website is active
$config["error_reporting"] = false; // false - disabled error reporting, true - enabled error reporting
$config["enable_logs"] = false; // false - disabled, true - enabled enhanced $_POST and $_GET logs (./__logs/)
$config["website_template"] = "imperiamucms";
$config["server_name"] = "Imperia MU";
$config["website_folder"] = "/"; // root folder of website, if website is in root folder (public_html, htdocs, etc.), use "/"
$config["encryption_hash"] = "A1B2C3D4E5F6G7H8"; // 16 characters ONLY !!!
$config["maintenance_page"] = "http://imperiamucms.com/"; // website where you will be redirected, if website is inactive
$config["show_version"] = true; // false = don't show website version in footer, true = show website version in footer
$config["default_charset"] = "UTF-8";
$config["enable_ssl"] = false;
$config["license_upgraded"] = true;
$config["enable_responsive"] = true;    // Use only for responsive templates !!!

$config["use_resets"] = true; // false - not using resets, true - using resets, column RESETS
$config["use_grand_resets"] = true; // false - not using grand resets, true - using grand resets, column Grand_Resets
$config["use_platinum"] = true;
$config["use_gold"] = true;
$config["use_silver"] = true;
$config["flags"] = true; // false - disable country flags, true - enable country flags

/**
 * Show/hide WCoinC/GP balance in UserCP
 * Do NOT enable it while you are using more than 1 website currencies (platinum, gold, silver coins)
 */
$config["show_wcoinc"] = false;
$config["show_gp"] = false;

/**
 * Countdown Settings
 */
$config["show_countdown"] = false;
$config["countdown_date"] = "2025/01/01 00:00"; // format YYYY/MM/DD HH:MM

/**
 * Time Zone Config
 */
$config["timezone_name"] = "America/Sao_Paulo";

/**
 * Time & Date Format Settings
 * http://php.net/manual/en/function.date.php
 */
$config["time_date_format"] = "d/m/Y, H:i";
$config["time_date_format_logs"] = "d/m/Y, H:i:s";
$config["date_format"] = "d/m/Y";
$config["time_format"] = "H:i";
$config["news_date"] = "d/m/Y";

/**
 * Automatic scroll-down into module
 */
$config["enable_scroll_down"] = false; // false = disable auto scroll down, true = enable auto scroll down

/**
 * AdminCP Security Password
 */
$config["admincp_security"] = "rxJlbKs1GGkURxlKrCneJo3pLJiWTbZMkKXv9n0bv8cnKTHKOf14VaDZcQzv3talztTAjIHDnYFloW41m7Xm0J3vwQFXnQfst7sxnSIow1KxCt97FhjXLwvV0wepb5f3";

/**
 * Administrators
 * account => access level
 */
$config["admins"] = array(
    // "account" => level,
    // "admin" => 100,
);

$config["admincp_modules_access"] = array(
    // Module => minimum level
);

/**
 * Game Masters
 * account => access level
 */
$config["gamemasters"] = array(
    // "account" => level,
);

$config["gmcp_modules_access"] = array(
    // Module => minimum level
);

$config["website_meta_description"] = "MU Online Private Server";
$config["website_meta_keywords"] = "muonline, mmo, rpg, private server";
$config["website_forum_link"] = "http://forum.imperiamucms.com/";

/**
 * MSSQL Connection Details
 */
$config["SQL_DB_HOST"] = "127.0.0.1";
$config["SQL_DB_NAME"] = "MuOnline";
$config["SQL_DB_2_NAME"] = "Me_MuOnline";
$config["SQL_DB_NAME_EVENTS"] = "Events";
$config["SQL_DB_NAME_RANKING"] = "Ranking";
$config["SQL_DB_NAME_BATTLECORE"] = "BattleCore";
$config["SQL_DB_PORT"] = 1433;
$config["SQL_DB_USER"] = "sa";
$config["SQL_DB_PASS"] = "ChangeMe123";
$config["SQL_USE_2_DB"] = false;
$config["SQL_PDO_DRIVER"] = 2; // 1 = dblib || 2 = sqlsrv || 3 = odbc
$config["SQL_ENABLE_MD5"] = 0; // 0 = No MD5 || 1 = WZ_MD5 || 2 = IGC_MD5 || 3 = SHA256
$config["MEMB_CREDITS_MEMUONLINE"] = false; // false = MEMB_CREDITS table is loaded from MuOnline, true = MEMB_CREDITS table is loaded from Me_MuOnline
$config["server_names"] = array('Main'); // list of server names used by this website, e.g. array('HARD-PvP-1', 'HARD-PvP-2')

/**
 * Secondary SQL Connection (Transfer / Verify modules)
 */
$config["SQL2_DB_HOST"] = "127.0.0.1";
$config["SQL2_DB_NAME"] = "MuOnline";
$config["SQL2_DB_2_NAME"] = "Me_MuOnline";
$config["SQL2_DB_PORT"] = 1433;
$config["SQL2_DB_USER"] = "sa";
$config["SQL2_DB_PASS"] = "ChangeMe123";
$config["SQL2_USE_2_DB"] = false;
$config["SQL2_ENABLE_MD5"] = 0;

/**
 * Server Files
 * - IGCN
 * - XTEAM
 */
$config["server_files"] = "IGCN";
$config["server_files_season"] = 131;    // 60 = S6, 80 = S8, 90 = S9, 100 = SX, 121 = S12 P1, 122 = S12 P2, 131 = S13 P1

/**
 * Language System
 * ISO 639-1
 */
$config["language_switch_active"] = true;
$config["language_default"] = "en";
$config["languages"] = array(
    0 => array("English", "en", "us"),
);

$config["gmark_bin2hex_enable"] = true;

/**
 * Ip Blocking System
 */
$config["ip_block_system_enable"] = false;

/**
 * Anti-flood System (basic)
 */
$config["flood_check_enable"] = true;
$config["flood_actions_per_minute"] = 60; // lower = more strict

?>
