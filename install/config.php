<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

if (!isset($_POST["licenseok"])) {
    echo "Direct access is not allowed.";
    exit;
}

$licenseToken = $_POST["licenseok"];

function generateRandomString(int $length): string
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';

    try {
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
    } catch (\Exception $exception) {
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[mt_rand(0, $charactersLength - 1)];
        }
    }

    return $randomString;
}

function html($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function parseBoolean($value, bool $default = false): bool
{
    if (!isset($value)) {
        return $default;
    }

    $value = strtolower((string) $value);
    if (in_array($value, ['1', 'true', 'yes', 'on'], true)) {
        return true;
    }
    if (in_array($value, ['0', 'false', 'no', 'off'], true)) {
        return false;
    }

    return $default;
}

function exportString(string $value): string
{
    return "'" . addslashes($value) . "'";
}

function exportBool(bool $value): string
{
    return $value ? 'true' : 'false';
}

function exportArray(array $values): string
{
    if (!$values) {
        return 'array()';
    }

    $escaped = array_map(static function ($item) {
        return "'" . addslashes($item) . "'";
    }, $values);

    return 'array(' . implode(', ', $escaped) . ')';
}

$defaultDriver = '2';
if (extension_loaded('pdo_dblib')) {
    $defaultDriver = '1';
} elseif (extension_loaded('PDO_SQLSRV')) {
    $defaultDriver = '2';
} elseif (extension_loaded('PDO_ODBC')) {
    $defaultDriver = '3';
}

$defaults = [
    'host' => '',
    'dbname' => 'MuOnline',
    'dbname2' => 'Me_MuOnline',
    'dbname3' => 'Events',
    'dbname4' => 'Ranking',
    'dbname5' => 'BattleCore',
    'user' => '',
    'password' => '',
    'port' => '1433',
    'use2db' => 'false',
    'driver' => $defaultDriver,
    'md5' => '0',
    'membcred_memuonline' => 'false',
    'server_names' => '',
    'template' => 'imperiamucms',
    'servername' => 'MU Online',
    'folder' => '/',
    'hash' => generateRandomString(16),
    'maintenance' => __IMPERIAMUCMS_LICENSE_SERVER__,
    'security' => generateRandomString(128),
    'default_charset' => 'UTF-8',
    'enable_ssl' => 'false',
    'enable_responsive' => 'false',
    'metadesc' => 'MU Online Private Server',
    'metakey' => 'muonline, season9, mu, mmorpg',
    'forumlink' => '',
    'server_files' => 'IGCN',
    'server_files_season' => '131',
    'useresets' => 'false',
    'usegresets' => 'false',
    'useplatinum' => 'false',
    'usegold' => 'false',
    'usesilver' => 'false',
    'isflood' => 'false',
    'flood' => '60',
    'ipblock' => 'false',
    'configcheck' => '',
];

$formData = $defaults;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($formData as $field => $defaultValue) {
        if (array_key_exists($field, $_POST)) {
            $value = $_POST[$field];
            if (is_string($value)) {
                $value = trim($value);
            }
            $formData[$field] = $value;
        }
    }
}

$configErrors = [];
$configWritten = false;
$configFilePath = realpath(__DIR__ . '/../includes/config.php');
if ($configFilePath === false) {
    $configFilePath = __DIR__ . '/../includes/config.php';
}

$serverSeasonOptions = ['60', '80', '90', '100', '121', '122', '131', '132', '140', '150'];
$serverFileOptions = ['IGCN', 'XTEAM'];
$driverOptions = ['1', '2', '3'];
$md5Options = ['0', '1', '2', '3'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['configcheck'])) {
    $host = (string) $formData['host'];
    if ($host === '') {
        $configErrors[] = 'SQL Host is required.';
    }

    $dbName = (string) $formData['dbname'];
    if ($dbName === '') {
        $configErrors[] = 'MuOnline database name is required.';
    }

    $dbName2 = (string) $formData['dbname2'];
    $dbNameEvents = (string) $formData['dbname3'];
    $dbNameRanking = (string) $formData['dbname4'];
    $dbNameBattlecore = (string) $formData['dbname5'];

    if ($dbName2 === '') {
        $configErrors[] = 'Me_MuOnline database name is required.';
    }
    if ($dbNameEvents === '') {
        $configErrors[] = 'Events database name is required.';
    }
    if ($dbNameRanking === '') {
        $configErrors[] = 'Ranking database name is required.';
    }
    if ($dbNameBattlecore === '') {
        $configErrors[] = 'BattleCore database name is required.';
    }

    $dbUser = (string) $formData['user'];
    if ($dbUser === '') {
        $configErrors[] = 'SQL User is required.';
    }

    $dbPass = (string) $formData['password'];

    $portValue = filter_var($formData['port'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    if ($portValue === false) {
        $configErrors[] = 'SQL Port must be a positive number.';
    } else {
        $portValue = (int) $portValue;
    }

    $selectedDriver = in_array((string) $formData['driver'], $driverOptions, true) ? (string) $formData['driver'] : $defaultDriver;
    $selectedMd5 = in_array((string) $formData['md5'], $md5Options, true) ? (string) $formData['md5'] : '0';
    $selectedServerFiles = in_array((string) $formData['server_files'], $serverFileOptions, true) ? (string) $formData['server_files'] : 'IGCN';
    $selectedSeason = in_array((string) $formData['server_files_season'], $serverSeasonOptions, true) ? (string) $formData['server_files_season'] : '131';

    $encryptionHash = (string) $formData['hash'];
    $hashLength = strlen($encryptionHash);
    if (!in_array($hashLength, [16, 24, 32], true)) {
        $configErrors[] = 'Encryption hash must contain 16, 24 or 32 characters.';
    }

    $securityPassword = (string) $formData['security'];
    if ($securityPassword === '') {
        $configErrors[] = 'Security password is required.';
    } elseif (strlen($securityPassword) > 128) {
        $configErrors[] = 'Security password cannot exceed 128 characters.';
    }

    $template = (string) $formData['template'];
    if ($template === '') {
        $configErrors[] = 'Template name is required.';
    }

    $serverName = (string) $formData['servername'];
    if ($serverName === '') {
        $configErrors[] = 'Server name is required.';
    }

    $websiteFolder = (string) $formData['folder'];
    if ($websiteFolder === '') {
        $configErrors[] = 'Website folder is required.';
    } elseif ($websiteFolder[0] !== '/') {
        $websiteFolder = '/' . ltrim($websiteFolder, '/');
    }

    $maintenancePage = (string) $formData['maintenance'];
    if ($maintenancePage === '') {
        $configErrors[] = 'Maintenance page URL is required.';
    }

    $defaultCharset = (string) $formData['default_charset'];
    if ($defaultCharset === '') {
        $configErrors[] = 'Default charset is required.';
    }

    $metaDescription = (string) $formData['metadesc'];
    $metaKeywords = (string) $formData['metakey'];
    if ($metaKeywords === '') {
        $configErrors[] = 'META keywords are required.';
    }

    $forumLink = (string) $formData['forumlink'];

    $floodLimit = filter_var($formData['flood'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    if ($floodLimit === false) {
        $configErrors[] = 'Anti-flood limit must be a positive number.';
    } else {
        $floodLimit = (int) $floodLimit;
    }

    $useSecondaryDatabase = parseBoolean($formData['use2db']);
    $membCreditsSecondary = parseBoolean($formData['membcred_memuonline']);
    $enableSsl = parseBoolean($formData['enable_ssl']);
    $enableResponsive = parseBoolean($formData['enable_responsive']);
    $useResets = parseBoolean($formData['useresets']);
    $useGrandResets = parseBoolean($formData['usegresets']);
    $usePlatinum = parseBoolean($formData['useplatinum']);
    $useGold = parseBoolean($formData['usegold']);
    $useSilver = parseBoolean($formData['usesilver']);
    $enableFlood = parseBoolean($formData['isflood']);
    $enableIpBlock = parseBoolean($formData['ipblock']);

    $serverNamesInput = array_filter(array_map(static function ($name) {
        return trim($name);
    }, explode(',', (string) $formData['server_names'])));

    if ($useSecondaryDatabase && empty($serverNamesInput)) {
        $configErrors[] = 'Server names are required when using the Me_MuOnline database.';
    }

    if (!$configErrors) {
        $configContent = "<?php\n\n";
        $configContent .= "/**\n * ImperiaMuCMS\n * http://imperiamucms.com/\n *\n * @version 2.0.0\n */\n\n";

        $configContent .= "/**\n * General Settings\n */\n";
        $configContent .= '$config["system_active"] = true;' . "\n";
        $configContent .= '$config["error_reporting"] = false;' . "\n";
        $configContent .= '$config["enable_logs"] = false;' . "\n";
        $configContent .= '$config["website_template"] = ' . exportString($template) . ';' . "\n";
        $configContent .= '$config["server_name"] = ' . exportString($serverName) . ';' . "\n";
        $configContent .= '$config["website_folder"] = ' . exportString($websiteFolder) . ';' . "\n";
        $configContent .= '$config["encryption_hash"] = ' . exportString($encryptionHash) . ';' . "\n";
        $configContent .= '$config["maintenance_page"] = ' . exportString($maintenancePage) . ';' . "\n";
        $configContent .= '$config["show_version"] = true;' . "\n";
        $configContent .= '$config["default_charset"] = ' . exportString($defaultCharset) . ';' . "\n";
        $configContent .= '$config["enable_ssl"] = ' . exportBool($enableSsl) . ';' . "\n";
        $configContent .= '$config["license_upgraded"] = true;' . "\n";
        $configContent .= '$config["enable_responsive"] = ' . exportBool($enableResponsive) . ';' . "\n\n";

        $configContent .= '$config["use_resets"] = ' . exportBool($useResets) . ';' . "\n";
        $configContent .= '$config["use_grand_resets"] = ' . exportBool($useGrandResets) . ';' . "\n";
        $configContent .= '$config["use_platinum"] = ' . exportBool($usePlatinum) . ';' . "\n";
        $configContent .= '$config["use_gold"] = ' . exportBool($useGold) . ';' . "\n";
        $configContent .= '$config["use_silver"] = ' . exportBool($useSilver) . ';' . "\n";
        $configContent .= '$config["flags"] = true;' . "\n\n";

        $configContent .= '$config["show_wcoinc"] = false;' . "\n";
        $configContent .= '$config["show_gp"] = false;' . "\n\n";

        $configContent .= '$config["show_countdown"] = false;' . "\n";
        $configContent .= '$config["countdown_date"] = "2025/01/01 00:00";' . "\n\n";

        $configContent .= '$config["timezone_name"] = "UTC";' . "\n\n";

        $configContent .= '$config["time_date_format"] = "d/m/Y, H:i";' . "\n";
        $configContent .= '$config["time_date_format_logs"] = "d/m/Y, H:i:s";' . "\n";
        $configContent .= '$config["date_format"] = "d/m/Y";' . "\n";
        $configContent .= '$config["time_format"] = "H:i";' . "\n";
        $configContent .= '$config["news_date"] = "d/m/Y";' . "\n\n";

        $configContent .= '$config["enable_scroll_down"] = false;' . "\n\n";

        $configContent .= '$config["admincp_security"] = ' . exportString($securityPassword) . ';' . "\n\n";

        $configContent .= '$config["admins"] = array(' . "\n";
        $configContent .= "    // \"account\" => level,\n";
        $configContent .= ");\n\n";

        $configContent .= '$config["admincp_modules_access"] = array(' . "\n";
        $configContent .= "    // Module => minimum level\n";
        $configContent .= ");\n\n";

        $configContent .= '$config["gamemasters"] = array(' . "\n";
        $configContent .= "    // \"account\" => level,\n";
        $configContent .= ");\n\n";

        $configContent .= '$config["gmcp_modules_access"] = array(' . "\n";
        $configContent .= "    // Module => minimum level\n";
        $configContent .= ");\n\n";

        $configContent .= '$config["website_meta_description"] = ' . exportString($metaDescription) . ';' . "\n";
        $configContent .= '$config["website_meta_keywords"] = ' . exportString($metaKeywords) . ';' . "\n";
        $configContent .= '$config["website_forum_link"] = ' . exportString($forumLink) . ';' . "\n\n";

        $configContent .= '$config["SQL_DB_HOST"] = ' . exportString($host) . ';' . "\n";
        $configContent .= '$config["SQL_DB_NAME"] = ' . exportString($dbName) . ';' . "\n";
        $configContent .= '$config["SQL_DB_2_NAME"] = ' . exportString($dbName2) . ';' . "\n";
        $configContent .= '$config["SQL_DB_NAME_EVENTS"] = ' . exportString($dbNameEvents) . ';' . "\n";
        $configContent .= '$config["SQL_DB_NAME_RANKING"] = ' . exportString($dbNameRanking) . ';' . "\n";
        $configContent .= '$config["SQL_DB_NAME_BATTLECORE"] = ' . exportString($dbNameBattlecore) . ';' . "\n";
        $configContent .= '$config["SQL_DB_PORT"] = ' . $portValue . ';' . "\n";
        $configContent .= '$config["SQL_DB_USER"] = ' . exportString($dbUser) . ';' . "\n";
        $configContent .= '$config["SQL_DB_PASS"] = ' . exportString($dbPass) . ';' . "\n";
        $configContent .= '$config["SQL_USE_2_DB"] = ' . exportBool($useSecondaryDatabase) . ';' . "\n";
        $configContent .= '$config["SQL_PDO_DRIVER"] = ' . (int) $selectedDriver . ';' . "\n";
        $configContent .= '$config["SQL_ENABLE_MD5"] = ' . (int) $selectedMd5 . ';' . "\n";
        $configContent .= '$config["MEMB_CREDITS_MEMUONLINE"] = ' . exportBool($membCreditsSecondary) . ';' . "\n";
        $configContent .= '$config["server_names"] = ' . exportArray($serverNamesInput) . ';' . "\n\n";

        $configContent .= '$config["SQL2_DB_HOST"] = ' . exportString($host) . ';' . "\n";
        $configContent .= '$config["SQL2_DB_NAME"] = ' . exportString($dbName) . ';' . "\n";
        $configContent .= '$config["SQL2_DB_2_NAME"] = ' . exportString($dbName2) . ';' . "\n";
        $configContent .= '$config["SQL2_DB_PORT"] = ' . $portValue . ';' . "\n";
        $configContent .= '$config["SQL2_DB_USER"] = ' . exportString($dbUser) . ';' . "\n";
        $configContent .= '$config["SQL2_DB_PASS"] = ' . exportString($dbPass) . ';' . "\n";
        $configContent .= '$config["SQL2_USE_2_DB"] = ' . exportBool($useSecondaryDatabase) . ';' . "\n";
        $configContent .= '$config["SQL2_ENABLE_MD5"] = ' . (int) $selectedMd5 . ';' . "\n\n";

        $configContent .= '$config["server_files"] = ' . exportString($selectedServerFiles) . ';' . "\n";
        $configContent .= '$config["server_files_season"] = ' . (int) $selectedSeason . ';' . "\n\n";

        $configContent .= '$config["language_switch_active"] = true;' . "\n";
        $configContent .= '$config["language_default"] = "en";' . "\n";
        $configContent .= '$config["languages"] = array(' . "\n";
        $configContent .= '    0 => array("English", "en", "us"),' . "\n";
        $configContent .= ");\n\n";

        $configContent .= '$config["gmark_bin2hex_enable"] = true;' . "\n";
        $configContent .= '$config["ip_block_system_enable"] = ' . exportBool($enableIpBlock) . ';' . "\n\n";

        $configContent .= '$config["flood_check_enable"] = ' . exportBool($enableFlood) . ';' . "\n";
        $configContent .= '$config["flood_actions_per_minute"] = ' . $floodLimit . ';' . "\n\n";

        $configContent .= "?>\n";

        if (@file_put_contents($configFilePath, $configContent) === false) {
            $configErrors[] = 'Unable to write the configuration file. Check permissions for includes/config.php.';
        } else {
            $configWritten = true;
        }
    }
}
?>
<?php if ($configWritten): ?>
    <div class="page-header">
        <h1>ImperiaMuCMS Install
            <small>Step: Website Config</small>
        </h1>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-3">
                    <ul class="nav nav-pills nav-stacked no-hover">
                        <li class="done"><a><i class="fa fa-check"></i>&nbsp;&nbsp;System Check</a></li>
                        <li class="done"><a><i class="fa fa-check"></i>&nbsp;&nbsp;License</a></li>
                        <li class="done"><a><i class="fa fa-check"></i>&nbsp;&nbsp;Website Config</a></li>
                        <li class=""><a><i class="fa fa-circle-o"></i>&nbsp;&nbsp;Install</a></li>
                    </ul>
                </div>
                <div class="col-md-9">
                    <div class="alert alert-success" role="alert">
                        <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                        Configuration file generated successfully at <strong><?php echo html($configFilePath); ?></strong>.
                    </div>
                    <p>Continue with the installation to import the required database structure and optional data.</p>
                    <form method="post" action="<?php echo html(__BASE_URL__ . 'index.php?step=install'); ?>" class="form">
                        <input type="hidden" name="licenseok" value="<?php echo html($licenseToken); ?>">
                        <div class="checkbox">
                            <label><input type="checkbox" name="import_struct" value="1" checked> Import database structure</label>
                        </div>
                        <div class="checkbox">
                            <label><input type="checkbox" name="import_data" value="1" checked> Import example data (recommended)</label>
                        </div>
                        <input type="hidden" name="configok" value="1">
                        <button type="submit" class="btn btn-primary btn-lg">Start Installation</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="page-header">
        <h1>ImperiaMuCMS Install
            <small>Step: Website Config</small>
        </h1>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-3">
                    <ul class="nav nav-pills nav-stacked no-hover">
                        <li class="done"><a><i class="fa fa-check"></i>&nbsp;&nbsp;System Check</a></li>
                        <li class="done"><a><i class="fa fa-check"></i>&nbsp;&nbsp;License</a></li>
                        <li class=""><a><i class="fa fa-circle"></i>&nbsp;&nbsp;Website Config</a></li>
                        <li class=""><a><i class="fa fa-circle-o"></i>&nbsp;&nbsp;Install</a></li>
                    </ul>
                </div>
                <div class="col-md-9">
                    <?php if ($configErrors): ?>
                        <div class="alert alert-danger" role="alert">
                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                            <ul class="list-unstyled" style="margin-bottom: 0;">
                                <?php foreach ($configErrors as $error): ?>
                                    <li><?php echo html($error); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <form method="post" action="<?php echo html(__BASE_URL__ . 'index.php?step=config'); ?>">
                        <input type="hidden" name="licenseok" value="<?php echo html($licenseToken); ?>">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="host" class="control-label">SQL Host</label>
                                <input name="host" type="text" id="host" value="<?php echo html($formData['host']); ?>" class="form-control" required placeholder="SQL Host">
                            </div>
                            <div class="form-group">
                                <label for="dbname" class="control-label">SQL Database Name - MuOnline</label>
                                <input name="dbname" type="text" id="dbname" value="<?php echo html($formData['dbname']); ?>" class="form-control" required placeholder="MuOnline">
                            </div>
                            <div class="form-group">
                                <label for="dbname2" class="control-label">SQL Database Name - Me_MuOnline</label>
                                <input name="dbname2" type="text" id="dbname2" value="<?php echo html($formData['dbname2']); ?>" class="form-control" required placeholder="Me_MuOnline">
                            </div>
                            <div class="form-group">
                                <label for="dbname3" class="control-label">SQL Database Name - Events</label>
                                <input name="dbname3" type="text" id="dbname3" value="<?php echo html($formData['dbname3']); ?>" class="form-control" required placeholder="Events">
                            </div>
                            <div class="form-group">
                                <label for="dbname4" class="control-label">SQL Database Name - Ranking</label>
                                <input name="dbname4" type="text" id="dbname4" value="<?php echo html($formData['dbname4']); ?>" class="form-control" required placeholder="Ranking">
                            </div>
                            <div class="form-group">
                                <label for="dbname5" class="control-label">SQL Database Name - BattleCore</label>
                                <input name="dbname5" type="text" id="dbname5" value="<?php echo html($formData['dbname5']); ?>" class="form-control" required placeholder="BattleCore">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user" class="control-label">SQL User</label>
                                <input name="user" type="text" id="user" value="<?php echo html($formData['user']); ?>" class="form-control" required placeholder="SQL User">
                            </div>
                            <div class="form-group">
                                <label for="password" class="control-label">SQL Password</label>
                                <input name="password" type="password" id="password" value="<?php echo html($formData['password']); ?>" class="form-control" placeholder="SQL Password">
                            </div>
                            <div class="form-group">
                                <label for="port" class="control-label">SQL Port</label>
                                <input name="port" type="text" id="port" value="<?php echo html($formData['port']); ?>" class="form-control" required placeholder="1433">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Use Me_MuOnline</label><br>
                                <label class="radio-inline"><input name="use2db" type="radio" value="false" <?php echo ($formData['use2db'] === 'true') ? '' : 'checked'; ?>> No</label>
                                <label class="radio-inline"><input name="use2db" type="radio" value="true" <?php echo ($formData['use2db'] === 'true') ? 'checked' : ''; ?>> Yes</label>
                            </div>
                            <div class="form-group">
                                <label for="driver" class="control-label">SQL PDO Driver</label>
                                <select name="driver" class="form-control">
                                    <option value="1" <?php echo ($formData['driver'] === '1') ? 'selected' : ''; ?>>DbLib</option>
                                    <option value="2" <?php echo ($formData['driver'] === '2') ? 'selected' : ''; ?>>Sqlsrv</option>
                                    <option value="3" <?php echo ($formData['driver'] === '3') ? 'selected' : ''; ?>>ODBC</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label">MD5 Type</label><br>
                                <label class="radio-inline"><input name="md5" type="radio" value="0" <?php echo ($formData['md5'] === '0') ? 'checked' : ''; ?>> No MD5</label>
                                <label class="radio-inline"><input name="md5" type="radio" value="1" <?php echo ($formData['md5'] === '1') ? 'checked' : ''; ?>> WZ_MD5</label>
                                <label class="radio-inline"><input name="md5" type="radio" value="2" <?php echo ($formData['md5'] === '2') ? 'checked' : ''; ?>> IGC_MD5</label>
                                <label class="radio-inline"><input name="md5" type="radio" value="3" <?php echo ($formData['md5'] === '3') ? 'checked' : ''; ?>> SHA256</label>
                            </div>
                            <div class="form-group">
                                <label class="control-label">MEMB_CREDITS in Me_MuOnline</label><br>
                                <label class="radio-inline"><input name="membcred_memuonline" type="radio" value="false" <?php echo ($formData['membcred_memuonline'] === 'true') ? '' : 'checked'; ?>> No</label>
                                <label class="radio-inline"><input name="membcred_memuonline" type="radio" value="true" <?php echo ($formData['membcred_memuonline'] === 'true') ? 'checked' : ''; ?>> Yes</label>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Server Names</label>
                                <textarea name="server_names" id="server_names" class="form-control" placeholder="Server1,Server2"><?php echo html($formData['server_names']); ?></textarea>
                                <span class="help-block">Enter server names separated by comma. Required when the Me_MuOnline database is enabled.</span>
                            </div>
                        </div>
                        <div class="col-md-12"><hr></div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Enable SSL</label><br>
                                <label class="radio-inline"><input name="enable_ssl" type="radio" value="false" <?php echo ($formData['enable_ssl'] === 'true') ? '' : 'checked'; ?>> No</label>
                                <label class="radio-inline"><input name="enable_ssl" type="radio" value="true" <?php echo ($formData['enable_ssl'] === 'true') ? 'checked' : ''; ?>> Yes</label>
                                <span class="help-block">Enable only if HTTPS is configured.</span>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Enable Responsive Features</label><br>
                                <label class="radio-inline"><input name="enable_responsive" type="radio" value="false" <?php echo ($formData['enable_responsive'] === 'true') ? '' : 'checked'; ?>> No</label>
                                <label class="radio-inline"><input name="enable_responsive" type="radio" value="true" <?php echo ($formData['enable_responsive'] === 'true') ? 'checked' : ''; ?>> Yes</label>
                                <span class="help-block">Enable for the default responsive template.</span>
                            </div>
                            <div class="form-group">
                                <label for="servername" class="control-label">Server Name</label>
                                <input name="servername" type="text" id="servername" value="<?php echo html($formData['servername']); ?>" class="form-control" required placeholder="MU Online">
                            </div>
                            <div class="form-group">
                                <label for="folder" class="control-label">Website Folder</label>
                                <input name="folder" type="text" id="folder" value="<?php echo html($formData['folder']); ?>" class="form-control" required placeholder="/">
                                <span class="help-block">Use "/" for root installations or "/path/" when placed in a subdirectory.</span>
                            </div>
                            <div class="form-group">
                                <label for="hash" class="control-label">Encryption Hash</label>
                                <input name="hash" type="text" id="hash" value="<?php echo html($formData['hash']); ?>" class="form-control" required>
                                <span class="help-block">Must contain 16, 24 or 32 characters.</span>
                            </div>
                            <div class="form-group">
                                <label for="maintenance" class="control-label">Maintenance Page</label>
                                <input name="maintenance" type="text" id="maintenance" value="<?php echo html($formData['maintenance']); ?>" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="server_files" class="control-label">Server Files</label>
                                <select name="server_files" class="form-control">
                                    <option value="IGCN" <?php echo ($formData['server_files'] === 'IGCN') ? 'selected' : ''; ?>>IGCN</option>
                                    <option value="XTEAM" <?php echo ($formData['server_files'] === 'XTEAM') ? 'selected' : ''; ?>>X-TEAM</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="server_files_season" class="control-label">Server Files Season</label>
                                <select name="server_files_season" class="form-control">
                                    <option value="60" <?php echo ($formData['server_files_season'] === '60') ? 'selected' : ''; ?>>Season 6</option>
                                    <option value="80" <?php echo ($formData['server_files_season'] === '80') ? 'selected' : ''; ?>>Season 8</option>
                                    <option value="90" <?php echo ($formData['server_files_season'] === '90') ? 'selected' : ''; ?>>Season 9</option>
                                    <option value="100" <?php echo ($formData['server_files_season'] === '100') ? 'selected' : ''; ?>>Season 10</option>
                                    <option value="121" <?php echo ($formData['server_files_season'] === '121') ? 'selected' : ''; ?>>Season 12 Part 1</option>
                                    <option value="122" <?php echo ($formData['server_files_season'] === '122') ? 'selected' : ''; ?>>Season 12 Part 2</option>
                                    <option value="131" <?php echo ($formData['server_files_season'] === '131') ? 'selected' : ''; ?>>Season 13 Part 1</option>
                                    <option value="132" <?php echo ($formData['server_files_season'] === '132') ? 'selected' : ''; ?>>Season 13 Part 2</option>
                                    <option value="140" <?php echo ($formData['server_files_season'] === '140') ? 'selected' : ''; ?>>Season 14</option>
                                    <option value="150" <?php echo ($formData['server_files_season'] === '150') ? 'selected' : ''; ?>>Season 15</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Use Resets</label><br>
                                <label class="radio-inline"><input name="useresets" type="radio" value="false" <?php echo ($formData['useresets'] === 'true') ? '' : 'checked'; ?>> No</label>
                                <label class="radio-inline"><input name="useresets" type="radio" value="true" <?php echo ($formData['useresets'] === 'true') ? 'checked' : ''; ?>> Yes</label>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Use Grand Resets</label><br>
                                <label class="radio-inline"><input name="usegresets" type="radio" value="false" <?php echo ($formData['usegresets'] === 'true') ? '' : 'checked'; ?>> No</label>
                                <label class="radio-inline"><input name="usegresets" type="radio" value="true" <?php echo ($formData['usegresets'] === 'true') ? 'checked' : ''; ?>> Yes</label>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Use Platinum Coins</label><br>
                                <label class="radio-inline"><input name="useplatinum" type="radio" value="false" <?php echo ($formData['useplatinum'] === 'true') ? '' : 'checked'; ?>> No</label>
                                <label class="radio-inline"><input name="useplatinum" type="radio" value="true" <?php echo ($formData['useplatinum'] === 'true') ? 'checked' : ''; ?>> Yes</label>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Use Gold Coins</label><br>
                                <label class="radio-inline"><input name="usegold" type="radio" value="false" <?php echo ($formData['usegold'] === 'true') ? '' : 'checked'; ?>> No</label>
                                <label class="radio-inline"><input name="usegold" type="radio" value="true" <?php echo ($formData['usegold'] === 'true') ? 'checked' : ''; ?>> Yes</label>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Use Silver Coins</label><br>
                                <label class="radio-inline"><input name="usesilver" type="radio" value="false" <?php echo ($formData['usesilver'] === 'true') ? '' : 'checked'; ?>> No</label>
                                <label class="radio-inline"><input name="usesilver" type="radio" value="true" <?php echo ($formData['usesilver'] === 'true') ? 'checked' : ''; ?>> Yes</label>
                            </div>
                            <div class="form-group">
                                <label for="metadesc" class="control-label">META Description</label>
                                <input name="metadesc" type="text" id="metadesc" value="<?php echo html($formData['metadesc']); ?>" class="form-control" placeholder="MU Online Private Server">
                            </div>
                            <div class="form-group">
                                <label for="metakey" class="control-label">META Keywords</label>
                                <input name="metakey" type="text" id="metakey" value="<?php echo html($formData['metakey']); ?>" class="form-control" required placeholder="muonline, season9, mu, mmorpg">
                            </div>
                            <div class="form-group">
                                <label for="forumlink" class="control-label">Forum Link</label>
                                <input name="forumlink" type="text" id="forumlink" value="<?php echo html($formData['forumlink']); ?>" class="form-control" placeholder="https://forum.example.com/">
                            </div>
                            <div class="form-group">
                                <label for="default_charset" class="control-label">Default Charset</label>
                                <input name="default_charset" type="text" id="default_charset" value="<?php echo html($formData['default_charset']); ?>" class="form-control" required placeholder="UTF-8">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Anti-Flood System</label><br>
                                <label class="radio-inline"><input name="isflood" type="radio" value="false" <?php echo ($formData['isflood'] === 'true') ? '' : 'checked'; ?>> Disabled</label>
                                <label class="radio-inline"><input name="isflood" type="radio" value="true" <?php echo ($formData['isflood'] === 'true') ? 'checked' : ''; ?>> Enabled</label>
                            </div>
                            <div class="form-group">
                                <label for="flood" class="control-label">Allowed actions per minute</label>
                                <input name="flood" type="text" id="flood" value="<?php echo html($formData['flood']); ?>" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label">IP Blocking System</label><br>
                                <label class="radio-inline"><input name="ipblock" type="radio" value="false" <?php echo ($formData['ipblock'] === 'true') ? '' : 'checked'; ?>> Disabled</label>
                                <label class="radio-inline"><input name="ipblock" type="radio" value="true" <?php echo ($formData['ipblock'] === 'true') ? 'checked' : ''; ?>> Enabled</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" name="configcheck" value="1" class="btn btn-primary btn-lg">Generate configuration</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
