<?php

/*
 * @ PHP 5.6
 * @ Decoder version : 1.0.0.1
 * @ Release on : 22.07.2018
 * @ Website    : http://EasyToYou.eu
 */

session_start();
ob_start();
define('__IMPERIAMUCMS_VERSION__', '1.1.1');
define('__IMPERIAMUCMS_FREE__', 'ImperiaMuCMS Free Package;Additional License for ImperiaMuCMS Free Package');
define('__IMPERIAMUCMS_LITE__', 'ImperiaMuCMS Lite Package;ImperiaMuCMS Lite Package (Rent);ImperiaMuCMS Lite Package (Lifetime);Additional License for ImperiaMuCMS Lite Package;Additional License for ImperiaMuCMS Lite Package (Lifetime)');
define('__IMPERIAMUCMS_PREMIUM__', 'ImperiaMuCMS Premium Package;ImperiaMuCMS Premium Package (Rent);ImperiaMuCMS Premium Package (Lifetime);Additional License for ImperiaMuCMS Premium Package;Additional License for ImperiaMuCMS Premium Package (Lifetime)');
define('__IMPERIAMUCMS_BRONZE__', 'ImperiaMuCMS Bronze Package;Additional License for Bronze Package');
define('__IMPERIAMUCMS_SILVER__', 'ImperiaMuCMS Silver Package;Additional License for Silver Package');
define('__IMPERIAMUCMS_GOLD__', 'ImperiaMuCMS Gold Package;Additional License for Gold Package;ImperiaMuCMS Gold Package [Lifetime];Additional License for Gold Package [Lifetime]');
$sapi_type = \PHP_SAPI;
if ('cli' === substr($sapi_type, 0, 3) || empty($_SERVER['REMOTE_ADDR'])) {
    define('__ACCESS_TYPE__', 'shell');
} else {
    define('__ACCESS_TYPE__', 'web');
}

if (!include_once(@__DIR__.'/config.php')) {
    throw new Exception('Could not load the configurations file.');
}

date_default_timezone_set($config['timezone_name']);
if ('IGCN' === $config['server_files']) {
    define('__ITEM_LENGTH__', '64');
    define('__ITEM_EMPTY__', 'FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF');
} else {
    define('__ITEM_LENGTH__', '32');
    define('__ITEM_EMPTY__', 'FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF');
}

define('__IMPERIAMUCMS_LICENSE_SERVER__', 'http://imperiamucms.com/');
if (!$config['system_active']) {
    if (!array_key_exists($_SESSION['username'], $config['admins']) && !defined('admincp')) {
        header('Location: '.$config['maintenance_page']);
        exit();
    }

    $config['enable_session_timeout'] = false;
    echo '<div style="text-align:center;border:1px solid #ff0000;padding:10px;background:#520000;color:#ff0000;font-size:16pt;position:fixed;z-index:99999;">OFFLINE MODE</div>';
}

if (!include_once(@__DIR__.'/tables.php')) {
    throw new Exception('Could not load the tables definitions.');
}

if ($config['error_reporting'] && __ACCESS_TYPE__ === 'web') {
    ini_set('display_errors', true);
    error_reporting(32767 & ~8);
} else {
    ini_set('display_errors', false);
    error_reporting(0);
}
/*
ini_set('display_errors', true);
	error_reporting(E_ALL & ~E_NOTICE);
*/
@ini_set('default_charset', $config['default_charset']);
$_SERVER['REMOTE_ADDR'] = (isset($_SERVER['HTTP_CF_CONNECTING_IP']) ? $_SERVER['HTTP_CF_CONNECTING_IP'] : $_SERVER['REMOTE_ADDR']);
if (empty($_SERVER['HTTP_HOST'])) {
    $server_host = $_SERVER['SERVER_NAME'];
} else {
    $server_host = $_SERVER['HTTP_HOST'];
}

define('HTTP_HOST', $server_host);
if (!isset($config['enable_ssl']) || null === $config['enable_ssl']) {
    if (!empty($_SERVER['HTTPS']) && 'off' !== $_SERVER['HTTPS'] || '443' === $_SERVER['SERVER_PORT'] || !empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && 'https' === $_SERVER['HTTP_X_FORWARDED_PROTO'] || !empty($_SERVER['HTTP_X_FORWARDED_SSL']) && 'on' === $_SERVER['HTTP_X_FORWARDED_SSL']) {
        define('SERVER_PROTOCOL', 'https://');
    } else {
        define('SERVER_PROTOCOL', 'http://');
    }
} else {
    if (true === $config['enable_ssl']) {
        define('SERVER_PROTOCOL', 'https://');
    } else {
        define('SERVER_PROTOCOL', 'http://');
    }
}

define('__ROOT_DIR__', str_replace('\\', '/', dirname(__DIR__)).'/');
define('__RELATIVE_ROOT__', str_ireplace(rtrim(str_replace('\\', '/', realpath(str_replace($_SERVER['SCRIPT_NAME'], '', $_SERVER['SCRIPT_FILENAME']))), '/'), '', __ROOT_DIR__));
define('__DOMAIN__', SERVER_PROTOCOL.HTTP_HOST);
define('__BASE_URL__', SERVER_PROTOCOL.HTTP_HOST.__RELATIVE_ROOT__);
define('__PATH_INCLUDES__', __ROOT_DIR__.'includes/');
define('__PATH_TEMPLATES__', __ROOT_DIR__.'templates/');
define('__PATH_TEMPLATES_EXTRA__', __ROOT_DIR__.'templates/'.$config['website_template'].'/extra/');
define('__PATH_LANGUAGES__', __ROOT_DIR__.'languages/');
define('__PATH_CLASSES__', __PATH_INCLUDES__.'classes/');
define('__PATH_FUNCTIONS__', __PATH_INCLUDES__.'functions/');
define('__PATH_MODULES__', __ROOT_DIR__.'modules/');
define('__PATH_MODULES_USERCP__', __PATH_MODULES__.'usercp/');
define('__PATH_MODULES_RANKINGS__', __BASE_URL__.'rankings/');
define('__PATH_EMAILS__', __PATH_INCLUDES__.'emails/');
define('__PATH_CACHE__', __PATH_INCLUDES__.'cache/');
define('__PATH_ADMINCP__', __ROOT_DIR__.'admincp/');
define('__PATH_ADMINCP_INC__', __ROOT_DIR__.'admincp/inc/');
define('__PATH_ADMINCP_MODULES__', __ROOT_DIR__.'admincp/modules/');
define('__PATH_ADMINCP_HOME__', __BASE_URL__.'admincp/index.php');
define('__PATH_NEWS_CACHE__', __PATH_CACHE__.'news/');
define('__PATH_PLUGINS__', __PATH_INCLUDES__.'plugins/');
define('__PATH_CONFIGS__', __PATH_INCLUDES__.'config/');
define('__PATH_MODULE_CONFIGS__', __PATH_CONFIGS__.'modules/');
define('__PATH_CRON__', __ROOT_DIR__.'cron/');
define('__PATH_CHANGELOG_CACHE__', __PATH_CACHE__.'changelogs/');
define('__PATH_GMCP__', __ROOT_DIR__.'gmcp/');
define('__PATH_GMCP_INC__', __ROOT_DIR__.'gmcp/inc/');
define('__PATH_GMCP_MODULES__', __ROOT_DIR__.'gmcp/modules/');
define('__PATH_GMCP_HOME__', __BASE_URL__.'gmcp/index.php');
define('__PATH_TEMPLATE__', __BASE_URL__.'templates/'.$config['website_template'].'/');
define('__PATH_TEMPLATE_ROOT__', __ROOT_DIR__.'templates/'.$config['website_template'].'/');
define('__PATH_TEMPLATE_IMG__', __PATH_TEMPLATE__.'img/');
define('__PATH_TEMPLATE_CSS__', __PATH_TEMPLATE__.'css/');
define('__PATH_TEMPLATE_JS__', __PATH_TEMPLATE__.'js/');
define('__PATH_TEMPLATE_FONTS__', __PATH_TEMPLATE__.'fonts/');
define('__PATH_MODULES_TICKET__', __BASE_URL__.'ticket/');
if (!include_once(__PATH_CLASSES__.'class.database.php')) {
    throw new Exception('Could not load class (database).');
}

if (!include_once(__PATH_CLASSES__.'class.general.php')) {
    throw new Exception('Could not load class (general).');
}

if (!include_once(__PATH_CLASSES__.'class.common.php')) {
    throw new Exception('Could not load class (common).');
}

if (!include_once(__PATH_CLASSES__.'class.handler.php')) {
    throw new Exception('Could not load class (handler).');
}

if (!include_once(__PATH_CLASSES__.'class.validator.php')) {
    throw new Exception('Could not load class (validator).');
}

if (!include_once(__PATH_CLASSES__.'class.login.php')) {
    throw new Exception('Could not load class (login).');
}

if (!include_once(__PATH_CLASSES__.'class.vote.php')) {
    throw new Exception('Could not load class (vote).');
}

if (!include_once(__PATH_CLASSES__.'class.character.php')) {
    throw new Exception('Could not load class (character).');
}

if (!include_once(__PATH_CLASSES__.'class.encryption.php')) {
    throw new Exception('Could not load class (encryption).');
}

if (!include_once(__PATH_CLASSES__.'class.phpmailer.php')) {
    throw new Exception('Could not load class (phpmailer).');
}

if (!include_once(__PATH_CLASSES__.'class.smtp.php')) {
    throw new Exception('Could not load class (smtp).');
}

if (!include_once(__PATH_CLASSES__.'class.vip.php')) {
    throw new Exception('Could not load class (vip).');
}

if (!include_once(__PATH_CLASSES__.'class.rankings.php')) {
    throw new Exception('Could not load class (rankings).');
}

if (!include_once(__PATH_CLASSES__.'class.news.php')) {
    throw new Exception('Could not load class (news).');
}

if (!include_once(__PATH_CLASSES__.'class.plugins.php')) {
    throw new Exception('Could not load class (plugins).');
}

if (!include_once(__PATH_CLASSES__.'class.profiles.php')) {
    throw new Exception('Could not load class (profiles).');
}

if (!include_once(__PATH_CLASSES__.'class.credits.php')) {
    throw new Exception('Could not load class (credits).');
}

if (!include_once(__PATH_CLASSES__.'class.email.php')) {
    throw new Exception('Could not load class (email).');
}

if (!include_once(__PATH_CLASSES__.'class.account.php')) {
    throw new Exception('Could not load class (account).');
}

if (!include_once(__PATH_CLASSES__.'class.market.php')) {
    throw new Exception('Could not load class (market).');
}

if (!include_once(__PATH_CLASSES__.'class.bugtracker.php')) {
    throw new Exception('Could not load class (bugtracker).');
}

if (!include_once(__PATH_CLASSES__.'class.changelog.php')) {
    throw new Exception('Could not load class (changelog).');
}

if (!include_once(__PATH_CLASSES__.'class.ticket.php')) {
    throw new Exception('Could not load class (ticket).');
}

if (!include_once(__PATH_CLASSES__.'class.webshop.php')) {
    throw new Exception('Could not load class (webshop).');
}

if (!include_once(__PATH_CLASSES__.'class.promo.php')) {
    throw new Exception('Could not load class (promo).');
}

if (!include_once(__PATH_CLASSES__.'class.recruit.php')) {
    throw new Exception('Could not load class (recruit).');
}

if (!include_once(__PATH_CLASSES__.'class.exchange.php')) {
    throw new Exception('Could not load class (exchange).');
}

if (!include_once(__PATH_CLASSES__.'class.achievements.php')) {
    throw new Exception('Could not load class (achievements).');
}

if (!include_once(__PATH_CLASSES__.'class.lottery.php')) {
    throw new Exception('Could not load class (lottery).');
}

if (!include_once(__PATH_CLASSES__.'class.usercp.php')) {
    throw new Exception('Could not load class (usercp).');
}

if (!include_once(__PATH_CLASSES__.'class.auction.php')) {
    throw new Exception('Could not load class (auction).');
}

if (!include_once(__PATH_CLASSES__.'class.cashshop.php')) {
    throw new Exception('Could not load class (cashshop).');
}

if (!include_once(__PATH_CLASSES__.'class.items.php')) {
    throw new Exception('Could not load class (items).');
}

if (!include_once(__PATH_CLASSES__.'class.architect.php')) {
    throw new Exception('Could not load class (architect).');
}

if (!include_once(__PATH_FUNCTIONS__.'function.global.php')) {
    throw new Exception('Could not load function (global).');
}

if (!include_once(__PATH_FUNCTIONS__.'function.recaptchalib.php')) {
    throw new Exception('Could not load function (recaptchalib).');
}

if (!include_once(__PATH_FUNCTIONS__.'function.config.php')) {
    throw new Exception('Could not load function (config).');
}

/*
if (!file_exists(__PATH_INCLUDES__.'license/license.imperiamucms')) {
    redirect(1, 'install/index.php');
}
*/

$dB = new dB($config['SQL_DB_HOST'], $config['SQL_DB_PORT'], $config['SQL_DB_NAME'], $config['SQL_DB_USER'], $config['SQL_DB_PASS'], $config['SQL_PDO_DRIVER']);
if ($dB->dead) {
    if (config('error_reporting', true)) {
        throw new Exception($dB->error);
    }

    throw new Exception('Connection to database server failed. [01]');
}

if ($config['SQL_USE_2_DB']) {
    $dB2 = new dB($config['SQL_DB_HOST'], $config['SQL_DB_PORT'], $config['SQL_DB_2_NAME'], $config['SQL_DB_USER'], $config['SQL_DB_PASS'], $config['SQL_PDO_DRIVER']);
    if ($dB2->dead) {
        if (config('error_reporting', true)) {
            throw new Exception($dB2->error);
        }

        throw new Exception('Connection to database server failed. [02]');
    }
}

if (!defined('admincp') && !defined('gmcp') && 'index' === defined('access') && __LICENSE__) {
    $General = new General();
    $General->checkLicense();
    $General->checkLocalLicense();
}

$common = new common($dB, $dB2);
if ($config['ip_block_system_enable'] && __ACCESS_TYPE__ === 'web' && $common->isIpBlocked($_SERVER['REMOTE_ADDR'])) {
    throw new Exception('Your IP address has been blocked.');
}

if ($config['flood_check_enable'] && __ACCESS_TYPE__ === 'web') {
    if (!check_value($_SESSION['track_timestamp'])) {
        $_SESSION['track_timestamp'] = time();
        $_SESSION['track_actions'] = 0;
    }

    if ($_SESSION['track_timestamp'] + 60 < time()) {
        $_SESSION['track_timestamp'] = time();
        $_SESSION['track_actions'] = 0;
    }

    if ($config['flood_actions_per_minute'] <= $_SESSION['track_actions']) {
        throw new Exception('Flood limit reached, please try again in a moment.');
    }

    ++$_SESSION['track_actions'];
}

if (!include_once(__PATH_INCLUDES__.'custom.php')) {
    throw new Exception('Could not load custom data.');
}

if (__ACCESS_TYPE__ === 'web') {
    $handler = new Handler($dB, $dB2);
    $handler->loadPage();
}

?>