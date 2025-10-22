<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class General
{
    public function giveHost($host_with_subdomain)
    {
        $array = explode(".", $host_with_subdomain);
        return (array_key_exists(count($array) - 2, $array) ? $array[count($array) - 2] : "") . "." . $array[count($array) - 1];
    }
    public function processDomain($domain)
    {
        $currentDomain = $domain;
        if (substr($currentDomain, strlen($currentDomain) - 1, 1) == "/") {
            $currentDomain = substr($currentDomain, 0, strlen($currentDomain) - 1);
        }
        if (substr($currentDomain, 0, 8) == "https://") {
            $currentDomain = substr($currentDomain, 8);
        }
        if (substr($currentDomain, 0, 7) == "http://") {
            $currentDomain = substr($currentDomain, 7);
        }
        if (substr($currentDomain, 0, 4) == "www.") {
            $currentDomain = substr($currentDomain, 4);
        }
        $currentDomain = preg_replace("/:\\d+\$/", "", $currentDomain);
        return $currentDomain;
    }
    public function getLicenseType($purchase_name)
    {
        if (strpos(__IMPERIAMUCMS_BRONZE__, $purchase_name) !== false) {
            $licenseType = "bronze";
        } else {
            if (strpos(__IMPERIAMUCMS_SILVER__, $purchase_name) !== false) {
                $licenseType = "silver";
            } else {
                if (strpos(__IMPERIAMUCMS_GOLD__, $purchase_name) !== false) {
                    $licenseType = "gold";
                } else {
                    if (strpos(__IMPERIAMUCMS_FREE__, $purchase_name) !== false) {
                        $licenseType = "free";
                    } else {
                        if (strpos(__IMPERIAMUCMS_LITE__, $purchase_name) !== false) {
                            $licenseType = "lite";
                        } else {
                            if (strpos(__IMPERIAMUCMS_PREMIUM__, $purchase_name) !== false) {
                                $licenseType = "premium";
                            } else {
                                $licenseType = NULL;
                            }
                        }
                    }
                }
            }
        }
        return $licenseType;
    }
    public function checkLicense()
    {
        if (file_exists(__PATH_INCLUDES__ . "license/license.imperiamucms")) {
            $alternativeIP = gethostbyname($_SERVER["SERVER_NAME"]);
            $license = $this->decodel(file_get_contents(__PATH_INCLUDES__ . "license/license.imperiamucms"));
            $data = json_decode($license);
            if ($data->last_checked != NULL) {
                $needCheck = time() - 82800;
                $needCheck2 = time() - 3600;
                if ($data->last_checked <= $needCheck || $data->last_result != "ok" && $data->last_checked <= $needCheck2) {
                    $response = curl_file_get_contents(__IMPERIAMUCMS_LICENSE_SERVER__ . "applications/nexus/interface/licenses/?check&key=" . $data->key . "&identifier=" . $data->email . "&usage_id=" . $data->usage_id);
                    if ($response) {
                        $licenseData = json_decode(decodeLicData($response));
                        if ($licenseData->status == "INACTIVE") {
                            $data->last_result = 601;
                            $data->last_checked = time();
                            $this->updateLicenseFile($data);
                            if ($data->last_checked + 259200 < time()) {
                                throw new Exception("[601] ImperiaMuCMS license is not valid.");
                            }
                            return true;
                        }
                        if ($licenseData->status == "EXPIRED") {
                            if ($data->product == "bronze") {
                                return true;
                            }
                            $data->last_result = 602;
                            $data->last_checked = time();
                            $this->updateLicenseFile($data);
                            if ($data->last_checked + 259200 < time()) {
                                throw new Exception("[602] ImperiaMuCMS license is expired.");
                            }
                            return true;
                        }
                        if ($licenseData->status == "ACTIVE") {
                            $response = curl_file_get_contents(__IMPERIAMUCMS_LICENSE_SERVER__ . "applications/nexus/interface/licenses/?info&key=" . $data->key . "&identifier=" . $data->email);
                            $licenseInfo = json_decode(decodeLicData($response));
                            $cfields = json_decode(json_encode($licenseInfo->custom_fields), true);
                            $licenseType = $this->getLicenseType($licenseInfo->purchase_name);
                            $currentDomain = $this->processDomain(__DOMAIN__);
                            $licenseDomain = $this->processDomain($cfields[2]);
                            $currentDomain = $this->giveHost($currentDomain);
                            $licenseDomain = $this->giveHost($licenseDomain);
                            if ($currentDomain == $licenseDomain) {
                                if ($_SERVER["SERVER_ADDR"] == $cfields[3] || $_SERVER["LOCAL_ADDR"] == $cfields[3] || $alternativeIP == $cfields[3]) {
                                    if ($data->product == $licenseType) {
                                        if ($data->expires != $licenseInfo->expires) {
                                            $data->expires = $licenseInfo->expires;
                                        }
                                        $data->last_checked = time();
                                        if (0 < $data->fail_count) {
                                            $data->fail_count = 0;
                                        }
                                        $data->last_result = "ok";
                                        $this->updateLicenseFile($data);
                                        return true;
                                    }
                                    $data->last_result = 604;
                                    $data->last_checked = time();
                                    $this->updateLicenseFile($data);
                                    if ($data->last_checked + 259200 < time()) {
                                        throw new Exception("[604] Invalid license.");
                                    }
                                    return true;
                                }
                                $data->last_result = 606;
                                $data->last_checked = time();
                                $this->updateLicenseFile($data);
                                $file = "includes/license/log_global.txt";
                                $current = file_get_contents($file);
                                $current .= "[" . date("Y-m-d H:i:s") . "] Server IP: [" . $_SERVER["SERVER_ADDR"] . " / " . $_SERVER["LOCAL_ADDR"] . " / " . $alternativeIP . "] License IP: [" . $cfields[3] . "] Remote IP: [" . $_SERVER["REMOTE_ADDR"] . "] Current Domain: [" . $currentDomain . "] License Domain: [" . $licenseDomain . "]\n";
                                file_put_contents($file, $current);
                                if ($data->last_checked + 259200 < time()) {
                                    throw new Exception("[606] Invalid license.");
                                }
                                return true;
                            }
                            $data->last_result = 605;
                            $data->last_checked = time();
                            $this->updateLicenseFile($data);
                            $file = "includes/license/log_global.txt";
                            $current = file_get_contents($file);
                            $current .= "[" . date("Y-m-d H:i:s") . "] Server IP: [" . $_SERVER["SERVER_ADDR"] . " / " . $_SERVER["LOCAL_ADDR"] . " / " . $alternativeIP . "] License IP: [" . $cfields[3] . "] Remote IP: [" . $_SERVER["REMOTE_ADDR"] . "] Current Domain: [" . $currentDomain . "] License Domain: [" . $licenseDomain . "]\n";
                            file_put_contents($file, $current);
                            if ($data->last_checked + 259200 < time()) {
                                throw new Exception("[605] Invalid license.");
                            }
                            return true;
                        }
                        if ($data->last_checked + 259200 < time()) {
                            throw new Exception("[607] Invalid license.");
                        }
                        return true;
                    }
                    $data->fail_count += 1;
                    $data->last_result = 603;
                    $data->last_checked = time();
                    $this->updateLicenseFile($data);
                    if ($data->last_checked + 259200 < time()) {
                        throw new Exception("[603] Failed to check license.");
                    }
                    return true;
                }
                if ($data->last_result == "ok") {
                    return true;
                }
                switch ($data->last_result) {
                    case "600":
                        if ($data->last_checked + 259200 < time()) {
                            throw new Exception("[600] Invalid license.");
                        }
                        return true;
                        break;
                    case "601":
                        if ($data->last_checked + 259200 < time()) {
                            throw new Exception("[601] ImperiaMuCMS license is not valid.");
                        }
                        return true;
                        break;
                    case "602":
                        if ($data->last_checked + 259200 < time()) {
                            throw new Exception("[602] ImperiaMuCMS license is expired.");
                        }
                        return true;
                        break;
                    case "603":
                        if ($data->last_checked + 259200 < time()) {
                            throw new Exception("[603] Failed to check license.");
                        }
                        return true;
                        break;
                    case "604":
                        if ($data->last_checked + 259200 < time()) {
                            throw new Exception("[604] Invalid license.");
                        }
                        return true;
                        break;
                    case "605":
                        if ($data->last_checked + 259200 < time()) {
                            throw new Exception("[605] Invalid license.");
                        }
                        return true;
                        break;
                    case "606":
                        if ($data->last_checked + 259200 < time()) {
                            throw new Exception("[606] Invalid license.");
                        }
                        return true;
                        break;
                    case "607":
                        if ($data->last_checked + 259200 < time()) {
                            throw new Exception("[607] Invalid license.");
                        }
                        return true;
                        break;
                    default:
                        if ($data->last_checked + 259200 < time()) {
                            throw new Exception("[649] Invalid license.");
                        }
                        return true;
                }
            } else {
                if ($data->last_checked + 259200 < time()) {
                    throw new Exception("[608] Invalid license.");
                }
                return true;
            }
        } else {
            throw new Exception("[600] License file does not exist.");
        }
    }
    public function checkLocalLicense()
    {
        if (file_exists(__PATH_INCLUDES__ . "license/license.imperiamucms")) {
            $alternativeIP = gethostbyname($_SERVER["SERVER_NAME"]);
            $license = $this->decodel(file_get_contents(__PATH_INCLUDES__ . "license/license.imperiamucms"));
            $data = json_decode($license);
            if ($data->last_checked_local != NULL) {
                $needCheck = time() - 41400;
                $needCheck2 = time() - 1;
                if ($data->last_checked_local <= $needCheck || $data->last_result_local != "ok" && $data->last_checked_local <= $needCheck2) {
                    if ($data->expires + 86400 <= time()) {
                        if ($data->product == "bronze") {
                            $currentDomain = $this->processDomain(__DOMAIN__);
                            $licenseDomain = $this->processDomain($data->domain);
                            $currentDomain = $this->giveHost($currentDomain);
                            $licenseDomain = $this->giveHost($licenseDomain);
                            if ($currentDomain == $licenseDomain) {
                                if ($_SERVER["SERVER_ADDR"] == $data->ip || $_SERVER["LOCAL_ADDR"] == $data->ip || $alternativeIP == $data->ip) {
                                    $data->last_checked_local = time();
                                    $data->last_result_local = "ok";
                                    $this->updateLicenseFile($data);
                                    return true;
                                }
                                $data->last_result_local = 656;
                                $data->last_checked_local = time();
                                $this->updateLicenseFile($data);
                                throw new Exception("[656] Invalid license.");
                            }
                            $data->last_result_local = 655;
                            $data->last_checked_local = time();
                            $this->updateLicenseFile($data);
                            $file = "includes/license/log_local.txt";
                            $current = file_get_contents($file);
                            $current .= "Server IP: " . $_SERVER["SERVER_ADDR"] . " / " . $_SERVER["LOCAL_ADDR"] . " / " . $alternativeIP . " Remote IP: " . $_SERVER["REMOTE_ADDR"] . " Current Domain: " . $currentDomain . " License Domain: " . $licenseDomain . "\n";
                            file_put_contents($file, $current);
                            throw new Exception("[655] Invalid license.");
                        }
                        $data->last_result_local = 652;
                        $data->last_checked_local = time();
                        $this->updateLicenseFile($data);
                        throw new Exception("[652] ImperiaMuCMS license is expired.");
                    }
                    $currentDomain = $this->processDomain(__DOMAIN__);
                    $licenseDomain = $this->processDomain($data->domain);
                    $currentDomain = $this->giveHost($currentDomain);
                    $licenseDomain = $this->giveHost($licenseDomain);
                    if ($currentDomain == $licenseDomain) {
                        if ($_SERVER["SERVER_ADDR"] == $data->ip || $_SERVER["LOCAL_ADDR"] == $data->ip || $alternativeIP == $data->ip) {
                            $data->last_checked_local = time();
                            $data->last_result_local = "ok";
                            $this->updateLicenseFile($data);
                            return true;
                        }
                        $data->last_result_local = 656;
                        $data->last_checked_local = time();
                        $this->updateLicenseFile($data);
                        throw new Exception("[656] Invalid license.");
                    }
                    $data->last_result_local = 655;
                    $data->last_checked_local = time();
                    $this->updateLicenseFile($data);
                    $file = "includes/license/log_local.txt";
                    $current = file_get_contents($file);
                    $current .= "Server IP: " . $_SERVER["SERVER_ADDR"] . " / " . $_SERVER["LOCAL_ADDR"] . " / " . $alternativeIP . " Remote IP: " . $_SERVER["REMOTE_ADDR"] . " Current Domain: " . $currentDomain . " License Domain: " . $licenseDomain . "\n";
                    file_put_contents($file, $current);
                    throw new Exception("[655] Invalid license.");
                }
                if ($data->last_result_local == "ok") {
                    return true;
                }
                switch ($data->last_result_local) {
                    case "650":
                        throw new Exception("[650] Invalid license.");
                        break;
                    case "651":
                        throw new Exception("[651] ImperiaMuCMS license is not valid.");
                        break;
                    case "652":
                        throw new Exception("[652] ImperiaMuCMS license is expired.");
                        break;
                    case "653":
                        throw new Exception("[653] Failed to check license.");
                        break;
                    case "654":
                        throw new Exception("[654] Invalid license.");
                        break;
                    case "655":
                        throw new Exception("[655] Invalid license.");
                        break;
                    case "656":
                        throw new Exception("[656] Invalid license.");
                        break;
                    default:
                        throw new Exception("[699] Invalid license.");
                }
            } else {
                throw new Exception("[658] Invalid license.");
            }
        } else {
            throw new Exception("[650] License file does not exist.");
        }
    }
    public function decodel($value)
    {
        if (!$value) {
            return false;
        }
        $crypttext = $this->safe_b64decodel($value);
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, "PRVuDzZP8Xx7c8Nx", $crypttext, MCRYPT_MODE_ECB, $iv);
        return trim($decrypttext);
    }
    public function safe_b64decodel($string)
    {
        $data = str_replace(["-", "_"], ["+", "/"], $string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr("====", $mod4);
        }
        return base64_decode($data);
    }
    public function updateLicenseFile($data)
    {
        $license = json_encode($data);
        $license = $this->encodel($license);
        $file = fopen(__PATH_INCLUDES__ . "license/license.imperiamucms", "w");
        exit("Unable to open file!");
    }
    public function encodel($value)
    {
        if (!$value) {
            return false;
        }
        $text = $value;
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, "PRVuDzZP8Xx7c8Nx", $text, MCRYPT_MODE_ECB, $iv);
        return trim($this->safe_b64encodel($crypttext));
    }
    public function safe_b64encodel($string)
    {
        $data = base64_encode($string);
        $data = str_replace(["+", "/", "="], ["-", "_", ""], $data);
        return $data;
    }
    public function checkModuleLicense($module)
    {
        if (file_exists(__PATH_INCLUDES__ . "license/license.imperiamucms")) {
            $alternativeIP = gethostbyname($_SERVER["SERVER_NAME"]);
            $license = $this->decodel(file_get_contents(__PATH_INCLUDES__ . "license/license.imperiamucms"));
            $data = json_decode($license);
            if ($data->product != NULL) {
                if ($data->product == "gold" || $data->product == "premium") {
                    return true;
                }
                if (file_exists(__PATH_INCLUDES__ . "license/license_" . $module . ".imperiamucms")) {
                    $license = $this->decodel(file_get_contents(__PATH_INCLUDES__ . "license/license_" . $module . ".imperiamucms"));
                    $data = json_decode($license);
                    if ($data->last_checked != NULL) {
                        $needCheck = time() - 82800;
                        $needCheck2 = time() - 3600;
                        if ($data->last_checked <= $needCheck || $data->last_result != "ok" && $data->last_checked <= $needCheck2) {
                            $response = curl_file_get_contents(__IMPERIAMUCMS_LICENSE_SERVER__ . "applications/nexus/interface/licenses/?check&key=" . $data->key . "&identifier=" . $data->email . "&usage_id=" . $data->usage_id);
                            if ($response) {
                                $licenseData = json_decode(decodeLicData($response));
                                if ($licenseData->status == "INACTIVE") {
                                    $data->last_result = 701;
                                    $data->last_checked = time();
                                    $this->updateModuleLicenseFile($data, $module);
                                    throw new Exception("[701] " . ucfirst($module) . " license is not valid.");
                                }
                                if ($licenseData->status == "EXPIRED") {
                                    $data->last_result = 702;
                                    $data->last_checked = time();
                                    $this->updateModuleLicenseFile($data, $module);
                                    throw new Exception("[702] " . ucfirst($module) . " license is expired.");
                                }
                                if ($licenseData->status == "ACTIVE") {
                                    $response = curl_file_get_contents(__IMPERIAMUCMS_LICENSE_SERVER__ . "applications/nexus/interface/licenses/?info&key=" . $data->key . "&identifier=" . $data->email);
                                    $licenseInfo = json_decode(decodeLicData($response));
                                    $cfields = json_decode(json_encode($licenseInfo->custom_fields), true);
                                    $currentDomain = $this->processDomain(__DOMAIN__);
                                    $licenseDomain = $this->processDomain($cfields[2]);
                                    $currentDomain = $this->giveHost($currentDomain);
                                    $licenseDomain = $this->giveHost($licenseDomain);
                                    if ($currentDomain == $licenseDomain) {
                                        if ($_SERVER["SERVER_ADDR"] == $cfields[3] || $_SERVER["LOCAL_ADDR"] == $cfields[3] || $alternativeIP == $cfields[3]) {
                                            $data->last_checked = time();
                                            if (0 < $data->fail_count) {
                                                $data->fail_count = 0;
                                            }
                                            $data->last_result = "ok";
                                            $this->updateModuleLicenseFile($data, $module);
                                            return true;
                                        }
                                        $data->last_result = 706;
                                        $data->last_checked = time();
                                        $this->updateModuleLicenseFile($data, $module);
                                        throw new Exception("[706] Invalid license for " . ucfirst($module) . ".");
                                    }
                                    $data->last_result = 705;
                                    $data->last_checked = time();
                                    $this->updateModuleLicenseFile($data, $module);
                                    throw new Exception("[705] Invalid license for " . ucfirst($module) . ".");
                                }
                                throw new Exception("[707] Invalid license.");
                            }
                            $data->fail_count += 1;
                            $data->last_result = 703;
                            $data->last_checked = time();
                            $this->updateModuleLicenseFile($data, $module);
                            if ($data->last_checked + 259200 < time()) {
                                throw new Exception("[703] Failed to check license for " . ucfirst($module) . ".");
                            }
                            return true;
                        }
                        if ($data->last_result == "ok") {
                            return true;
                        }
                        switch ($data->last_result_local) {
                            case "700":
                                throw new Exception("[700] Invalid license for " . ucfirst($module) . ".");
                                break;
                            case "701":
                                throw new Exception("[701] " . ucfirst($module) . " license is not valid.");
                                break;
                            case "702":
                                throw new Exception("[702] " . ucfirst($module) . " license is expired.");
                                break;
                            case "703":
                                if ($data->last_checked + 259200 < time()) {
                                    throw new Exception("[703] Failed to check license for " . ucfirst($module) . ".");
                                }
                                return true;
                                break;
                            case "704":
                                throw new Exception("[704] Invalid license for " . ucfirst($module) . ".");
                                break;
                            case "705":
                                throw new Exception("[705] Invalid license for " . ucfirst($module) . ".");
                                break;
                            case "706":
                                throw new Exception("[706] Invalid license for " . ucfirst($module) . ".");
                                break;
                            default:
                                throw new Exception("[749] Invalid license for " . ucfirst($module) . ".");
                        }
                    } else {
                        throw new Exception("[708] Invalid license for " . ucfirst($module) . ".");
                    }
                } else {
                    throw new Exception("[700] License file for " . ucfirst($module) . " does not exist.");
                }
            } else {
                throw new Exception("[708] Invalid license.");
            }
        }
    }
    public function updateModuleLicenseFile($data, $module)
    {
        $license = json_encode($data);
        $license = $this->encodel($license);
        $file = fopen(__PATH_INCLUDES__ . "license/license_" . $module . ".imperiamucms", "w");
        exit("Unable to open file!");
    }
    public function checkLocalModuleLicense($module)
    {
        if (file_exists(__PATH_INCLUDES__ . "license/license.imperiamucms")) {
            $alternativeIP = gethostbyname($_SERVER["SERVER_NAME"]);
            $license = $this->decodel(file_get_contents(__PATH_INCLUDES__ . "license/license.imperiamucms"));
            $data = json_decode($license);
            if ($data->product == "gold" || $data->product == "premium") {
                return true;
            }
            if (file_exists(__PATH_INCLUDES__ . "license/license_" . $module . ".imperiamucms")) {
                $license = $this->decodel(file_get_contents(__PATH_INCLUDES__ . "license/license_" . $module . ".imperiamucms"));
                $data = json_decode($license);
                $needCheck = time() - 41400;
                $needCheck2 = time() - 1;
                if ($data->last_checked_local <= $needCheck || $data->last_result_local != "ok" && $data->last_checked_local <= $needCheck2) {
                    $currentDomain = $this->processDomain(__DOMAIN__);
                    $licenseDomain = $this->processDomain($data->domain);
                    $currentDomain = $this->giveHost($currentDomain);
                    $licenseDomain = $this->giveHost($licenseDomain);
                    if ($currentDomain == $licenseDomain) {
                        if ($_SERVER["SERVER_ADDR"] == $data->ip || $_SERVER["LOCAL_ADDR"] == $data->ip || $alternativeIP == $data->ip) {
                            $data->last_checked_local = time();
                            $data->last_result_local = "ok";
                            $this->updateModuleLicenseFile($data, $module);
                            return true;
                        }
                        $data->last_result_local = 756;
                        $this->updateModuleLicenseFile($data, $module);
                        throw new Exception("[756] Invalid license for " . ucfirst($module) . ".");
                    }
                    $data->last_result_local = 755;
                    $this->updateModuleLicenseFile($data, $module);
                    throw new Exception("[755] Invalid license for " . ucfirst($module) . ".");
                }
                if ($data->last_result_local == "ok") {
                    return true;
                }
                switch ($data->last_result_local) {
                    case "750":
                        throw new Exception("[750] Invalid license for " . ucfirst($module) . ".");
                        break;
                    case "751":
                        throw new Exception("[751] " . ucfirst($module) . " license is not valid.");
                        break;
                    case "752":
                        throw new Exception("[752] " . ucfirst($module) . " license is expired.");
                        break;
                    case "753":
                        throw new Exception("[753] Failed to check license for " . ucfirst($module) . ".");
                        break;
                    case "754":
                        throw new Exception("[754] Invalid license for " . ucfirst($module) . ".");
                        break;
                    case "755":
                        throw new Exception("[755] Invalid license for " . ucfirst($module) . ".");
                        break;
                    case "756":
                        throw new Exception("[756] Invalid license for " . ucfirst($module) . ".");
                        break;
                    default:
                        throw new Exception("[799] Invalid license for " . ucfirst($module) . ".");
                }
            } else {
                throw new Exception("License file for " . ucfirst($module) . " does not exist.");
            }
        }
    }
    public function isModuleActivated($module)
    {
        if (file_exists(__PATH_INCLUDES__ . "license/license.imperiamucms")) {
            $alternativeIP = gethostbyname($_SERVER["SERVER_NAME"]);
            $license = $this->decodel(file_get_contents(__PATH_INCLUDES__ . "license/license.imperiamucms"));
            $data = json_decode($license);
            if ($data->product != NULL) {
                if ($data->product == "gold" || $data->product == "premium") {
                    return true;
                }
                if (file_exists(__PATH_INCLUDES__ . "license/license_" . $module . ".imperiamucms")) {
                    $license = $this->decodel(file_get_contents(__PATH_INCLUDES__ . "license/license_" . $module . ".imperiamucms"));
                    $data = json_decode($license);
                    if ($data->key != NULL) {
                        $response = curl_file_get_contents(__IMPERIAMUCMS_LICENSE_SERVER__ . "applications/nexus/interface/licenses/?check&key=" . $data->key . "&identifier=" . $data->email . "&usage_id=" . $data->usage_id);
                        if ($response) {
                            $licenseData = json_decode(decodeLicData($response));
                            if ($licenseData->status == "INACTIVE") {
                                return false;
                            }
                            if ($licenseData->status == "EXPIRED") {
                                return false;
                            }
                            if ($licenseData->status == "ACTIVE") {
                                $response = curl_file_get_contents(__IMPERIAMUCMS_LICENSE_SERVER__ . "applications/nexus/interface/licenses/?info&key=" . $data->key . "&identifier=" . $data->email);
                                $licenseInfo = json_decode(decodeLicData($response));
                                $cfields = json_decode(json_encode($licenseInfo->custom_fields), true);
                                $currentDomain = $this->processDomain(__DOMAIN__);
                                $licenseDomain = $this->processDomain($cfields[2]);
                                $currentDomain = $this->giveHost($currentDomain);
                                $licenseDomain = $this->giveHost($licenseDomain);
                                if ($currentDomain == $licenseDomain) {
                                    if ($_SERVER["SERVER_ADDR"] == $cfields[3] || $_SERVER["LOCAL_ADDR"] == $cfields[3] || $alternativeIP == $cfields[3]) {
                                        return true;
                                    }
                                    return false;
                                }
                                return false;
                            }
                            return false;
                        }
                        return false;
                    }
                    return false;
                }
                return false;
            }
        }
    }
    public function activateModule($module, $key)
    {
        if (file_exists(__PATH_INCLUDES__ . "license/license.imperiamucms")) {
            $license = $this->decodel(file_get_contents(__PATH_INCLUDES__ . "license/license.imperiamucms"));
            $data = json_decode($license);
            $check = curl_file_get_contents(__IMPERIAMUCMS_LICENSE_SERVER__ . "applications/nexus/interface/licenses/?info&key=" . $key . "&identifier=" . $data->email . "");
            $productCheck = json_decode(decodeLicData($check));
            if ($productCheck->purchase_name == $this->premiumModules($module)) {
                $response = curl_file_get_contents(__IMPERIAMUCMS_LICENSE_SERVER__ . "applications/nexus/interface/licenses/?activate&key=" . $key . "&identifier=" . $data->email . "&setIdentifier=" . $data->email . "&extra={\"url\":\"" . __BASE_URL__ . "\"}");
                $licenseData = json_decode(decodeLicData($response));
                if ($licenseData->response == "OKAY") {
                    $usageId = $licenseData->usage_id;
                    $file = fopen("../includes/license/license_" . $module . ".imperiamucms", "w");
                    exit("Unable to open file!");
                }
                message("error", "Could not activate module.");
            } else {
                message("error", "License key is not valid for this premium module.");
            }
        }
    }
    public function canUseModule($module)
    {
        $array = ["merchant" => ["muphil2015@gmail.com", "imperiamucms@imperiamucms.com"], "mulords" => ["julius_jomar@yahoo.com", "imperiamucms@imperiamucms.com"], "networking" => ["julius_jomar@yahoo.com", "imperiamucms@imperiamucms.com"], "cashshopgifts" => ["hopz.games2@gmail.com", "imperiamucms@imperiamucms.com"], "transferaccount" => ["lalitablue@gmail.com", "imperiamucms@imperiamucms.com"], "eventregistration" => ["muphil2015@gmail.com", "imperiamucms@imperiamucms.com"], "transferaccount-relic" => ["relicmu@gmail.com", "imperiamucms@imperiamucms.com"]];
        if (file_exists(__PATH_INCLUDES__ . "license/license.imperiamucms")) {
            $license = $this->decodel(file_get_contents(__PATH_INCLUDES__ . "license/license.imperiamucms"));
            $data = json_decode($license);
            if ($data->email != NULL) {
                if (in_array($data->email, $array[$module])) {
                    return true;
                }
                return false;
            }
            return false;
        }
        return false;
    }
    public function getLiteModules()
    {
        $liteModules = ["bugtracker" => "Bug Tracker", "changelogs" => "Changelogs", "donation" => "Donation", "guides" => "Guides", "rankings_afk" => "AFK Rankings", "rankings_honor" => "Honor Rankings", "rankings_score" => "Score Rankings", "changeclass" => "Change Class", "changename" => "Change Name", "claimreward" => "Claim a Reward", "exchange" => "Exchange", "items" => "Items Inventory", "market" => "Market", "promo" => "Promo Codes", "recruit" => "Recruit a Friend", "transfercoins" => "Transfer Coins", "vault" => "MY Vault", "vip" => "VIP", "webbank" => "Changelogs", "webshop" => "Webshop"];
        return $liteModules;
    }
    public function liteModules($module)
    {
        $liteModules = $this->getLiteModules();
        return $liteModules[$module];
    }
    public function getPremiumModules()
    {
        $premiumModules = ["achievements" => "Achievements", "dualstats" => "Dual Stats", "dualskilltree" => "Dual Skill Tree", "lottery" => "Lottery", "auction" => "Auction", "startingkit" => "Starting Kit", "cashshop" => "Cash Shop", "wheeloffortune" => "Wheel of Fortune", "adventures" => "Adventures", "architect" => "Architect"];
        return $premiumModules;
    }
    public function premiumModules($module)
    {
        $premiumModules = $this->getPremiumModules();
        return $premiumModules[$module];
    }
}

?>