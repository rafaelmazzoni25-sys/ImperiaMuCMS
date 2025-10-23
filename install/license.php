<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$errors = [];
$success = false;
$licenseKey = isset($_POST['license_key']) ? trim($_POST['license_key']) : '';
$licenseEmail = isset($_POST['license_email']) ? trim($_POST['license_email']) : '';
$licenseToken = '';

function generate_license_token(int $length = 32): string
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $token = '';

    for ($i = 0; $i < $length; $i++) {
        if (function_exists('random_int')) {
            try {
                $token .= $characters[random_int(0, $charactersLength - 1)];
                continue;
            } catch (Exception $exception) {
                // Fallback to mt_rand below.
            }
        }

        $token .= $characters[mt_rand(0, $charactersLength - 1)];
    }

    return $token;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($licenseKey === '') {
        $errors[] = 'License key is required.';
    }

    if ($licenseEmail === '') {
        $errors[] = 'License e-mail is required.';
    }

    if (!$errors) {
        $General = new xGeneral();
        $activationUrl = __IMPERIAMUCMS_LICENSE_SERVER__ . 'applications/nexus/interface/licenses/?activate&key=' . rawurlencode($licenseKey) . '&identifier=' . rawurlencode($licenseEmail) . '&setIdentifier=' . rawurlencode($licenseEmail) . '&extra=' . rawurlencode(json_encode(['url' => __BASE_URL__]));
        $activationResponse = curl_file_get_contents($activationUrl);

        if (!$activationResponse) {
            $errors[] = 'Unable to reach the License Server. Please verify that it is running and accessible.';
        } else {
            $activationData = json_decode(decodeLicData($activationResponse));

            if (!is_object($activationData) || strtoupper($activationData->response ?? '') !== 'OKAY' || !check_value($activationData->usage_id ?? null)) {
                $errors[] = 'The provided license could not be activated. Please confirm the key and e-mail address.';
            } else {
                $infoUrl = __IMPERIAMUCMS_LICENSE_SERVER__ . 'applications/nexus/interface/licenses/?info&key=' . rawurlencode($licenseKey) . '&identifier=' . rawurlencode($licenseEmail);
                $infoResponse = curl_file_get_contents($infoUrl);

                if (!$infoResponse) {
                    $errors[] = 'Unable to retrieve license details. Please try again.';
                } else {
                    $licenseInfo = json_decode(decodeLicData($infoResponse));

                    if (!is_object($licenseInfo) || isset($licenseInfo->error)) {
                        $errors[] = 'The License Server returned an invalid response for this key.';
                    } else {
                        $status = strtoupper($licenseInfo->status ?? '');
                        if ($status !== 'ACTIVE') {
                            $errors[] = 'The license is not active. Please check the status in the License Server.';
                        } else {
                            $customFields = json_decode(json_encode($licenseInfo->custom_fields ?? []), true);
                            if (!is_array($customFields)) {
                                $customFields = [];
                            }

                            $customFields = array_values($customFields);
                            $licenseType = $General->getLicenseType($licenseInfo->purchase_name ?? '');

                            if ($licenseType === null) {
                                $errors[] = 'This license tier is not recognized by the installer. Please verify the License Server configuration.';
                            } else {
                                $licenseData = new stdClass();
                                $licenseData->key = $licenseInfo->key ?? $licenseKey;
                                $licenseData->email = $licenseInfo->email ?? $licenseEmail;
                                $licenseData->usage_id = $licenseInfo->usage_id ?? $activationData->usage_id;
                                $licenseData->server = $customFields[0] ?? '';
                                $licenseData->domain = $customFields[1] ?? __DOMAIN__;
                                $licenseData->ip = $customFields[2] ?? gethostbyname($_SERVER['SERVER_NAME']);
                                $licenseData->copyright = $customFields[3] ?? '';
                                $licenseData->dynamicip = $customFields[4] ?? 'no';
                                $licenseData->season = $customFields[5] ?? '';
                                $licenseData->expires = isset($licenseInfo->expires) ? (int) $licenseInfo->expires : 0;
                                $licenseData->product = $licenseType;
                                $licenseData->last_checked = time();
                                $licenseData->last_result = 'ok';
                                $licenseData->last_checked_local = time();
                                $licenseData->last_result_local = 'ok';
                                $licenseData->fail_count = 0;

                                try {
                                    $General->updateLicenseFile($licenseData);

                                    $licenseDir = realpath(__DIR__ . '/../includes/license');
                                    if ($licenseDir === false) {
                                        $licenseDir = __DIR__ . '/../includes/license';
                                    }

                                    foreach (['log_global.txt', 'log_local.txt'] as $logFile) {
                                        $logPath = $licenseDir . '/' . $logFile;
                                        if (!file_exists($logPath)) {
                                            file_put_contents($logPath, '');
                                        }
                                    }

                                    $licenseToken = generate_license_token();
                                    $success = true;
                                } catch (Exception $exception) {
                                    $errors[] = 'Failed to save the license file. Please ensure the directory "includes/license" is writable.';
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}

if ($success) {
    echo '<div class="panel panel-success">';
    echo '    <div class="panel-heading">License activated successfully</div>';
    echo '    <div class="panel-body">Your ImperiaMuCMS installation is now linked to the provided license.</div>';
    echo '</div>';
    echo '<form action="' . __BASE_URL__ . 'index.php?step=config" method="post">';
    echo '    <input type="hidden" name="licenseok" value="' . htmlspecialchars($licenseToken, ENT_QUOTES, 'UTF-8') . '" />';
    echo '    <button type="submit" name="systemcheck" class="btn btn-primary btn-lg">Continue</button>';
    echo '</form>';
    return;
}

if ($errors) {
    echo '<div class="alert alert-danger" role="alert">';
    echo '    <strong>The following errors occurred:</strong>';
    echo '    <ul>';
    foreach ($errors as $error) {
        echo '        <li>' . htmlspecialchars($error, ENT_QUOTES, 'UTF-8') . '</li>';
    }
    echo '    </ul>';
    echo '</div>';
}

echo '<div class="panel panel-default">';
echo '    <div class="panel-heading">License Activation</div>';
echo '    <div class="panel-body">';
echo '        <p>Please provide the license credentials configured in your ImperiaMuCMS License Server.</p>';
echo '        <form method="post" action="">';
echo '            <div class="form-group">';
echo '                <label for="license_key">License Key</label>';
echo '                <input type="text" class="form-control" id="license_key" name="license_key" value="' . htmlspecialchars($licenseKey, ENT_QUOTES, 'UTF-8') . '" required />';
echo '            </div>';
echo '            <div class="form-group">';
echo '                <label for="license_email">License E-mail</label>';
echo '                <input type="email" class="form-control" id="license_email" name="license_email" value="' . htmlspecialchars($licenseEmail, ENT_QUOTES, 'UTF-8') . '" required />';
echo '            </div>';
echo '            <button type="submit" class="btn btn-success">Activate License</button>';
echo '        </form>';
echo '    </div>';
echo '</div>';
