<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<script src=\"js/Chart.min.js\"></script><div class=\"row\"><div class=\"col-md-6\">";
$General = new xGeneral();
$premiumModules = $General->getPremiumPlusModules();
$files = [];
$activePremiumModules = [];
foreach (glob(__PATH_INCLUDES__ . "license/*.imperiamucms") as $file) {
    $fileName = basename($file);
    $premiumModuleName = getbetween("_", ".", $fileName);
    if ($premiumModules[$premiumModuleName] != NULL) {
        $files[] = $fileName;
        $activePremiumModules[] = $premiumModules[$premiumModuleName];
    }
}
if (check_value($_POST["update_license"])) {
    $license = $General->encrypt_decrypt_license("decrypt", file_get_contents(__PATH_INCLUDES__ . "license/license.imperiamucms"));
    $dataLocal = json_decode($license);
    $response = curl_file_get_contents(__IMPERIAMUCMS_LICENSE_SERVER__ . "applications/nexus/interface/licenses/?info&key=" . $dataLocal->key . "&identifier=" . $dataLocal->email);
    if ($response) {
        $dataGlobal = json_decode(decodeLicData($response));
        if ($dataGlobal->key != NULL) {
            $cfields = json_decode(json_encode($dataGlobal->custom_fields), true);
            $licenseType = $General->getLicenseType($dataGlobal->purchase_name);
            list($dataLocal->server, $dataLocal->domain, $dataLocal->ip, $dataLocal->copyright, $dataLocal->dynamicip, $dataLocal->season) = $cfields;
            $dataLocal->expires = $dataGlobal->expires;
            $dataLocal->product = $licenseType;
            $dataLocal->last_checked = time() - 86400;
            $dataLocal->last_checked_local = time() - 43200;
            $General->updateLicenseFile($dataLocal);
            message("success", "License data were successfully updated.");
        } else {
            message("error", "Your license is invalid.");
        }
    } else {
        message("error", "Your license is invalid.");
    }
}
if (check_value($_POST["update_modules_license"])) {
    foreach ($files as $premiumModule) {
        $license = $General->encrypt_decrypt_license("decrypt", file_get_contents(__PATH_INCLUDES__ . "license/" . $premiumModule));
        $dataLocal = json_decode($license);
        $response = curl_file_get_contents(__IMPERIAMUCMS_LICENSE_SERVER__ . "applications/nexus/interface/licenses/?info&key=" . $dataLocal->key . "&identifier=" . $dataLocal->email);
        if ($response) {
            $dataGlobal = json_decode(decodeLicData($response));
            $cfields = json_decode(json_encode($dataGlobal->custom_fields), true);
            list($dataLocal->server, $dataLocal->domain, $dataLocal->ip) = $cfields;
            $dataLocal->last_checked = time() - 86400;
            $dataLocal->last_checked_local = time() - 43200;
            $premiumModuleName = getbetween("_", ".", $premiumModule);
            $General->updateModuleLicenseFile($dataLocal, $premiumModuleName);
            message("success", "License data for module " . $premiumModules[$premiumModuleName] . " were successfully updated.");
        } else {
            message("error", "Your license is invalid.");
        }
    }
}
if (file_exists(__PATH_INCLUDES__ . "license/license.imperiamucms")) {
    $license = $General->encrypt_decrypt_license("decrypt", file_get_contents(__PATH_INCLUDES__ . "license/license.imperiamucms"));
    $data = json_decode($license);
    $response = curl_file_get_contents(__IMPERIAMUCMS_LICENSE_SERVER__ . "applications/nexus/interface/licenses/?check&key=" . $data->key . "&identifier=" . $data->email . "&usage_id=" . $data->usage_id);
    if ($response) {
        $licenseData = json_decode(decodeLicData($response));
    } else {
        $status = "<span class=\"label label-danger\" style=\"font-size:12px;\">INVALID</span>";
    }
    if ($licenseData->status == "ACTIVE") {
        $status = "<span class=\"label label-success\" style=\"font-size:12px;\">ACTIVE</span>";
    } else {
        if ($licenseData->status == "INACTIVE") {
            $status = "<span class=\"label label-danger\" style=\"font-size:12px;\">INACTIVE</span>";
        } else {
            if ($licenseData->status == "EXPIRED") {
                $status = "<span class=\"label\" style=\"font-size:12px;background-color:#ff8c00\">EXPIRED</span>";
            }
        }
    }
}
echo "<div class=\"panel panel-primary\"><div class=\"panel-heading\">License Information</div><div class=\"panel-body\"><div class=\"list-group\"><div class=\"list-group-item\">Status";
echo "<span class=\"pull-right text-muted small\">" . $status . "</span>";
echo "</div>";
if ($licenseData->status == "ACTIVE") {
    if ($data->expires == NULL) {
        $expires = "Never";
    } else {
        $expires = date($config["time_date_format"], $data->expires);
    }
    echo "<div class=\"list-group-item\">Expires";
    echo "<span class=\"pull-right text-muted small\">" . $expires . "</span>";
    echo "</div><div class=\"list-group-item\">Server Name";
    echo "<span class=\"pull-right text-muted small\">" . $data->server . "</span>";
    echo "</div><div class=\"list-group-item\">Domain";
    echo "<span class=\"pull-right text-muted small\">" . $data->domain . "</span>";
    echo "</div><div class=\"list-group-item\">IP Address";
    echo "<span class=\"pull-right text-muted small\">" . $data->ip . "</span>";
    echo "</div><div class=\"list-group-item\">Max. Allowed Season Config";
    echo "<span class=\"pull-right text-muted small\">" . $data->season . "</span>";
    echo "</div><div class=\"list-group-item\">Copyright Removal";
    echo "<span class=\"pull-right text-muted small\">" . $data->copyright . "</span>";
    echo "</div><div class=\"list-group-item\">Dynamic IP";
    echo "<span class=\"pull-right text-muted small\">" . $data->dynamicip . "</span>";
    echo "</div>";
}
echo "</div><div style=\"width: 100%;\"><form method=\"post\" action=\"\"><button type=\"submit\" class=\"btn btn-large btn-block btn-success\" name=\"update_license\" value=\"update_license\">Update License Data</button></form></div></div></div>";
if ($data->product != "gold") {
    echo "<div class=\"panel panel-primary\"><div class=\"panel-heading\">Premium Modules</div><div class=\"panel-body\"><div class=\"list-group\">";
    if (is_array($files)) {
        foreach ($activePremiumModules as $module) {
            echo "<div class=\"list-group-item\">Module";
            echo "<span class=\"pull-right text-muted small\">" . $module . "</span>";
            echo "</div>";
        }
    }
    echo "</div><div style=\"width: 100%;\"><form method=\"post\" action=\"\"><button type=\"submit\" class=\"btn btn-large btn-block btn-info\" name=\"update_modules_license\" value=\"update_modules_license\">Update License Data</button></form></div></div></div>";
}
echo "<div class=\"panel panel-primary\"><div class=\"panel-heading\">General Information</div><div class=\"panel-body\"><div class=\"list-group\">";
echo "<a href=\"" . __IMPERIAMUCMS_LICENSE_SERVER__ . "\" class=\"list-group-item\" target=\"_blank\">";
if (checkVersion()) {
    echo "<i class=\"fa fa-remove\"></i> ImperiaMuCMS Version";
} else {
    echo "<i class=\"fa fa-check\"></i> ImperiaMuCMS Version";
}
echo "<span class=\"pull-right text-muted small\">";
if (checkVersion()) {
    echo "<span class=\"label label-danger\">Update ";
    echo latestVersion();
    echo " Available</span>  ";
}
echo "<em>" . __IMPERIAMUCMS_VERSION__ . "</em>";
echo "</span></a></div><div class=\"list-group\">";
$dbacc = config("SQL_USE_2_DB", true) ? $dB2 : $dB;
$totalAccounts = $dbacc->query_fetch_single("SELECT COUNT(*) as result FROM MEMB_INFO");
echo "<div class=\"list-group-item\">Registered Accounts";
echo "<span class=\"pull-right text-muted small\">" . number_format($totalAccounts["result"]) . "</span>";
echo "</div>";
$bannedAccounts = $dbacc->query_fetch_single("SELECT COUNT(*) as result FROM MEMB_INFO WHERE bloc_code = 1");
echo "<div class=\"list-group-item\">Banned Accounts";
echo "<span class=\"pull-right text-muted small\">" . number_format($bannedAccounts["result"]) . "</span>";
echo "</div>";
$totalCharacters = $dB->query_fetch_single("SELECT COUNT(*) as result FROM Character");
echo "<div class=\"list-group-item\">Characters";
echo "<span class=\"pull-right text-muted small\">" . number_format($totalCharacters["result"]) . "</span>";
echo "</div>";
$scheduledTasks = $dB->query_fetch_single("SELECT COUNT(*) as result FROM IMPERIAMUCMS_CRON");
echo "<div class=\"list-group-item\">Scheduled Tasks (cron)";
echo "<span class=\"pull-right text-muted small\">" . number_format($scheduledTasks["result"]) . "</span>";
echo "</div><div class=\"list-group-item\">Server Time (web)";
echo "<span class=\"pull-right text-muted small\">" . date($config["time_date_format"]) . "</span>";
echo "</div>";
$admincpUsers = implode(", ", array_keys(config("admins", true)));
echo "<div class=\"list-group-item\">Admins";
echo "<span class=\"pull-right text-muted small\">" . $admincpUsers . "</span>";
echo "</div>";
$gmcpUsers = implode(", ", array_keys(config("gamemasters", true)));
echo "<div class=\"list-group-item\">Game Masters";
echo "<span class=\"pull-right text-muted small\">" . $gmcpUsers . "</span>";
echo "</div></div></div></div></div><div class=\"col-md-6\"><div class=\"panel panel-default\"><div class=\"panel-heading\">Statistics</div><div class=\"panel-body\"><div class=\"row\"><div class=\"col-md-6\">";
$date = time() - 604800;
$date = date("Y-m-d H:i:s", $date);
if (config("SQL_USE_2_DB", true)) {
    $totalPlayers = $dB2->query_fetch_single("SELECT COUNT(memb___id) as count FROM MEMB_INFO");
} else {
    $totalPlayers = $dB->query_fetch_single("SELECT COUNT(memb___id) as count FROM MEMB_INFO");
}
if (config("SQL_USE_2_DB", true)) {
    $onlinePlayers = $dB2->query_fetch_single("SELECT COUNT(memb___id) as count FROM MEMB_STAT WHERE ConnectStat = '1'");
} else {
    $onlinePlayers = $dB->query_fetch_single("SELECT COUNT(memb___id) as count FROM MEMB_STAT WHERE ConnectStat = '1'");
}
if (config("SQL_USE_2_DB", true)) {
    $activePlayers = $dB2->query_fetch_single("SELECT COUNT(memb___id) as count FROM MEMB_STAT WHERE DisConnectTM >= '" . $date . "' AND  ConnectStat = '0'");
} else {
    $activePlayers = $dB->query_fetch_single("SELECT COUNT(memb___id) as count FROM MEMB_STAT WHERE DisConnectTM >= '" . $date . "' AND  ConnectStat = '0'");
}
if (config("SQL_USE_2_DB", true)) {
    $inactivePlayers = $dB2->query_fetch_single("SELECT COUNT(memb___id) as count FROM MEMB_STAT WHERE DisConnectTM < '" . $date . "'");
} else {
    $inactivePlayers = $dB->query_fetch_single("SELECT COUNT(memb___id) as count FROM MEMB_STAT WHERE DisConnectTM < '" . $date . "'");
}
if (config("SQL_USE_2_DB", true)) {
    $blockedPlayers = $dB2->query_fetch_single("SELECT COUNT(memb___id) as count FROM MEMB_INFO WHERE bloc_code = '1'");
} else {
    $blockedPlayers = $dB->query_fetch_single("SELECT COUNT(memb___id) as count FROM MEMB_INFO WHERE bloc_code = '1'");
}
echo "\r\n<h4>Players: " . $totalPlayers["count"] . "</h4>\r\n<canvas id=\"players\" width=\"300\" height=\"300\"></canvas>\r\n<script>\r\nvar playersData = {\r\n    labels: [\"Online\", \"Active\", \"Blocked\", \"Inactive\"],\r\n    datasets: [{\r\n        data: [" . $onlinePlayers["count"] . ", " . $activePlayers["count"] . ", " . $blockedPlayers["count"] . ", " . $inactivePlayers["count"] . "],\r\n        backgroundColor: [\"#00CC00\", \"#007700\", \"#555\", \"#BB0000\"]\r\n    }]\r\n};\r\nvar context = document.getElementById(\"players\").getContext(\"2d\");\r\nvar playersChart = new Chart(context, {\r\n    type: 'doughnut',\r\n    data: playersData\r\n});\r\n</script>";
echo "</div><div class=\"col-md-6\">";
if (131 <= $config["server_files_season"]) {
    $dw3code = 3;
    $dk3code = 19;
    $fe3code = 35;
    $su3code = 83;
} else {
    $dw3code = 2;
    $dk3code = 18;
    $fe3code = 34;
    $su3code = 82;
}
$wizard_1 = $dB->query_fetch_single("SELECT COUNT(Name) as count FROM Character WHERE Class = '0'");
$wizard_2 = $dB->query_fetch_single("SELECT COUNT(Name) as count FROM Character WHERE Class = '1'");
$wizard_3 = $dB->query_fetch_single("SELECT COUNT(Name) as count FROM Character WHERE Class = '" . $dw3code . "'");
$knight_1 = $dB->query_fetch_single("SELECT COUNT(Name) as count FROM Character WHERE Class = '16'");
$knight_2 = $dB->query_fetch_single("SELECT COUNT(Name) as count FROM Character WHERE Class = '17'");
$knight_3 = $dB->query_fetch_single("SELECT COUNT(Name) as count FROM Character WHERE Class = '" . $dk3code . "'");
$elf_1 = $dB->query_fetch_single("SELECT COUNT(Name) as count FROM Character WHERE Class = '32'");
$elf_2 = $dB->query_fetch_single("SELECT COUNT(Name) as count FROM Character WHERE Class = '33'");
$elf_3 = $dB->query_fetch_single("SELECT COUNT(Name) as count FROM Character WHERE Class = '" . $fe3code . "'");
$summoner_1 = $dB->query_fetch_single("SELECT COUNT(Name) as count FROM Character WHERE Class = '80'");
$summoner_2 = $dB->query_fetch_single("SELECT COUNT(Name) as count FROM Character WHERE Class = '81'");
$summoner_3 = $dB->query_fetch_single("SELECT COUNT(Name) as count FROM Character WHERE Class = '" . $su3code . "'");
$gladiator_1 = $dB->query_fetch_single("SELECT COUNT(Name) as count FROM Character WHERE Class = '48'");
$gladiator_3 = $dB->query_fetch_single("SELECT COUNT(Name) as count FROM Character WHERE Class = '50'");
$lord_1 = $dB->query_fetch_single("SELECT COUNT(Name) as count FROM Character WHERE Class = '64'");
$lord_3 = $dB->query_fetch_single("SELECT COUNT(Name) as count FROM Character WHERE Class = '66'");
$fighter_1 = $dB->query_fetch_single("SELECT COUNT(Name) as count FROM Character WHERE Class = '96'");
$fighter_3 = $dB->query_fetch_single("SELECT COUNT(Name) as count FROM Character WHERE Class = '98'");
if (100 <= config("server_files_season", true)) {
    $lancer_1 = $dB->query_fetch_single("SELECT COUNT(Name) as count FROM Character WHERE Class = '112'");
    $lancer_3 = $dB->query_fetch_single("SELECT COUNT(Name) as count FROM Character WHERE Class = '114'");
    $data1 = "data: [" . $wizard_1["count"] . ", " . $knight_1["count"] . ", " . $elf_1["count"] . ", " . $summoner_1["count"] . ", " . $gladiator_1["count"] . ", " . $lord_1["count"] . ", " . $fighter_1["count"] . ", " . $lancer_1["count"] . "]";
    $data2 = "data: [" . $wizard_2["count"] . ", " . $knight_2["count"] . ", " . $elf_2["count"] . ", " . $summoner_2["count"] . ", 0, 0, 0, 0]";
    $data3 = "data: [" . $wizard_3["count"] . ", " . $knight_3["count"] . ", " . $elf_3["count"] . ", " . $summoner_3["count"] . ", " . $gladiator_3["count"] . ", " . $lord_3["count"] . ", " . $fighter_3["count"] . ", " . $lancer_3["count"] . "]";
    if (122 <= config("server_files_season", true)) {
        $wizard_4 = $dB->query_fetch_single("SELECT COUNT(Name) as count FROM Character WHERE Class = '7'");
        $knight_4 = $dB->query_fetch_single("SELECT COUNT(Name) as count FROM Character WHERE Class = '23'");
        $elf_4 = $dB->query_fetch_single("SELECT COUNT(Name) as count FROM Character WHERE Class = '39'");
        $summoner_4 = $dB->query_fetch_single("SELECT COUNT(Name) as count FROM Character WHERE Class = '87'");
        $gladiator_4 = $dB->query_fetch_single("SELECT COUNT(Name) as count FROM Character WHERE Class = '54'");
        $lord_4 = $dB->query_fetch_single("SELECT COUNT(Name) as count FROM Character WHERE Class = '70'");
        $fighter_4 = $dB->query_fetch_single("SELECT COUNT(Name) as count FROM Character WHERE Class = '102'");
        $lancer_4 = $dB->query_fetch_single("SELECT COUNT(Name) as count FROM Character WHERE Class = '118'");
        $data4 = "data: [" . $wizard_4["count"] . ", " . $knight_4["count"] . ", " . $elf_4["count"] . ", " . $summoner_4["count"] . ", " . $gladiator_4["count"] . ", " . $lord_4["count"] . ", " . $fighter_4["count"] . ", " . $lancer_4["count"] . "]";
    }
    if (140 <= config("server_files_season", true)) {
        $rune_1 = $dB->query_fetch_single("SELECT COUNT(Name) as count FROM Character WHERE Class = '128'");
        $rune_2 = $dB->query_fetch_single("SELECT COUNT(Name) as count FROM Character WHERE Class = '129'");
        $rune_3 = $dB->query_fetch_single("SELECT COUNT(Name) as count FROM Character WHERE Class = '131'");
        $rune_4 = $dB->query_fetch_single("SELECT COUNT(Name) as count FROM Character WHERE Class = '135'");
        $data1 = "data: [" . $wizard_1["count"] . ", " . $knight_1["count"] . ", " . $elf_1["count"] . ", " . $summoner_1["count"] . ", " . $gladiator_1["count"] . ", " . $lord_1["count"] . ", " . $fighter_1["count"] . ", " . $lancer_1["count"] . ", " . $rune_1["count"] . "]";
        $data2 = "data: [" . $wizard_2["count"] . ", " . $knight_2["count"] . ", " . $elf_2["count"] . ", " . $summoner_2["count"] . ", 0, 0, 0, 0, " . $rune_2["count"] . "]";
        $data3 = "data: [" . $wizard_3["count"] . ", " . $knight_3["count"] . ", " . $elf_3["count"] . ", " . $summoner_3["count"] . ", " . $gladiator_3["count"] . ", " . $lord_3["count"] . ", " . $fighter_3["count"] . ", " . $lancer_3["count"] . ", " . $rune_3["count"] . "]";
        $data4 = "data: [" . $wizard_4["count"] . ", " . $knight_4["count"] . ", " . $elf_4["count"] . ", " . $summoner_4["count"] . ", " . $gladiator_4["count"] . ", " . $lord_4["count"] . ", " . $fighter_4["count"] . ", " . $lancer_4["count"] . ", " . $rune_4["count"] . "]";
    }
    if (150 <= config("server_files_season", true)) {
        $slayer_1 = $dB->query_fetch_single("SELECT COUNT(Name) as count FROM Character WHERE Class = '144'");
        $slayer_2 = $dB->query_fetch_single("SELECT COUNT(Name) as count FROM Character WHERE Class = '145'");
        $slayer_3 = $dB->query_fetch_single("SELECT COUNT(Name) as count FROM Character WHERE Class = '147'");
        $slayer_4 = $dB->query_fetch_single("SELECT COUNT(Name) as count FROM Character WHERE Class = '151'");
        $data1 = "data: [" . $wizard_1["count"] . ", " . $knight_1["count"] . ", " . $elf_1["count"] . ", " . $summoner_1["count"] . ", " . $gladiator_1["count"] . ", " . $lord_1["count"] . ", " . $fighter_1["count"] . ", " . $lancer_1["count"] . ", " . $rune_1["count"] . ", " . $slayer_1["count"] . "]";
        $data2 = "data: [" . $wizard_2["count"] . ", " . $knight_2["count"] . ", " . $elf_2["count"] . ", " . $summoner_2["count"] . ", 0, 0, 0, 0, " . $rune_2["count"] . ", " . $slayer_2["count"] . "]";
        $data3 = "data: [" . $wizard_3["count"] . ", " . $knight_3["count"] . ", " . $elf_3["count"] . ", " . $summoner_3["count"] . ", " . $gladiator_3["count"] . ", " . $lord_3["count"] . ", " . $fighter_3["count"] . ", " . $lancer_3["count"] . ", " . $rune_3["count"] . ", " . $slayer_3["count"] . "]";
        $data4 = "data: [" . $wizard_4["count"] . ", " . $knight_4["count"] . ", " . $elf_4["count"] . ", " . $summoner_4["count"] . ", " . $gladiator_4["count"] . ", " . $lord_4["count"] . ", " . $fighter_4["count"] . ", " . $lancer_4["count"] . ", " . $rune_4["count"] . ", " . $slayer_4["count"] . "]";
    }
} else {
    $data1 = "data: [" . $wizard_1["count"] . ", " . $knight_1["count"] . ", " . $elf_1["count"] . ", " . $summoner_1["count"] . ", " . $gladiator_1["count"] . ", " . $lord_1["count"] . ", " . $fighter_1["count"] . "]";
    $data2 = "data: [" . $wizard_2["count"] . ", " . $knight_2["count"] . ", " . $elf_2["count"] . ", " . $summoner_2["count"] . ", 0, 0, 0]";
    $data3 = "data: [" . $wizard_3["count"] . ", " . $knight_3["count"] . ", " . $elf_3["count"] . ", " . $summoner_3["count"] . ", " . $gladiator_3["count"] . ", " . $lord_3["count"] . ", " . $fighter_3["count"] . "]";
}
$totalCharacters = $dB->query_fetch_single("SELECT COUNT(Name) as count FROM Character");
echo "\r\n<h4>Characters: " . $totalCharacters["count"] . "</h4>\r\n<canvas id=\"classes\" width=\"300\" height=\"300\"></canvas>";
if (150 <= config("server_files_season", true)) {
    echo "\r\n<script>\r\nvar classesData = {\r\n    labels: [\"Wizard\", \"Knight\", \"Elf\", \"Summoner\", \"Gladiator\", \"Lord\", \"Fighter\", \"Lancer\", \"Rune Wizard\", \"Slayer\"],\r\n    datasets: [\r\n        {\r\n            label: \"1st Class\",\r\n            backgroundColor: \"rgba(0,0,220,0.3)\",\r\n            borderColor: \"rgba(0,0,220,1)\",\r\n            pointBackgroundColor: \"rgba(0,0,220,1)\",\r\n            pointBorderColor: \"#fff\",\r\n            pointHoverBackgroundColor: \"#fff\",\r\n            pointHoverBorderColor: \"rgba(0,0,220,1)\",\r\n            " . $data1 . "\r\n        },\r\n        {\r\n            label: \"2nd Class\",\r\n            backgroundColor: \"rgba(220,0,0,0.3)\",\r\n            borderColor: \"rgba(220,0,0,1)\",\r\n            pointBackgroundColor: \"rgba(220,0,0,1)\",\r\n            pointBorderColor: \"#fff\",\r\n            pointHoverBackgroundColor: \"#fff\",\r\n            pointHoverBorderColor: \"rgba(220,0,0,1)\",\r\n            " . $data2 . "\r\n        },\r\n        {\r\n            label: \"3rd Class\",\r\n            backgroundColor: \"rgba(0,220,0,0.3)\",\r\n            borderColor: \"rgba(0,220,0,1)\",\r\n            pointBackgroundColor: \"rgba(0,220,0,1)\",\r\n            pointBorderColor: \"#fff\",\r\n            pointHoverBackgroundColor: \"#fff\",\r\n            pointHoverBorderColor: \"rgba(0,220,0,1)\",\r\n            " . $data3 . "\r\n        },\r\n        {\r\n            label: \"4th Class\",\r\n            backgroundColor: \"rgba(255,255,0,0.3)\",\r\n            borderColor: \"rgba(255,255,0,1)\",\r\n            pointBackgroundColor: \"rgba(255,255,0,1)\",\r\n            pointBorderColor: \"#fff\",\r\n            pointHoverBackgroundColor: \"#fff\",\r\n            pointHoverBorderColor: \"rgba(255,255,0,1)\",\r\n            " . $data4 . "\r\n        }";
    echo "\r\n    ]\r\n};\r\nvar context = document.getElementById(\"classes\").getContext(\"2d\");\r\nvar classes = new Chart(context, {\r\n    type: 'radar',\r\n    data: classesData\r\n});\r\n</script>";
} else {
    if (140 <= config("server_files_season", true)) {
        echo "\r\n<script>\r\nvar classesData = {\r\n    labels: [\"Wizard\", \"Knight\", \"Elf\", \"Summoner\", \"Gladiator\", \"Lord\", \"Fighter\", \"Lancer\", \"Rune Wizard\"],\r\n    datasets: [\r\n        {\r\n            label: \"1st Class\",\r\n            backgroundColor: \"rgba(0,0,220,0.3)\",\r\n            borderColor: \"rgba(0,0,220,1)\",\r\n            pointBackgroundColor: \"rgba(0,0,220,1)\",\r\n            pointBorderColor: \"#fff\",\r\n            pointHoverBackgroundColor: \"#fff\",\r\n            pointHoverBorderColor: \"rgba(0,0,220,1)\",\r\n            " . $data1 . "\r\n        },\r\n        {\r\n            label: \"2nd Class\",\r\n            backgroundColor: \"rgba(220,0,0,0.3)\",\r\n            borderColor: \"rgba(220,0,0,1)\",\r\n            pointBackgroundColor: \"rgba(220,0,0,1)\",\r\n            pointBorderColor: \"#fff\",\r\n            pointHoverBackgroundColor: \"#fff\",\r\n            pointHoverBorderColor: \"rgba(220,0,0,1)\",\r\n            " . $data2 . "\r\n        },\r\n        {\r\n            label: \"3rd Class\",\r\n            backgroundColor: \"rgba(0,220,0,0.3)\",\r\n            borderColor: \"rgba(0,220,0,1)\",\r\n            pointBackgroundColor: \"rgba(0,220,0,1)\",\r\n            pointBorderColor: \"#fff\",\r\n            pointHoverBackgroundColor: \"#fff\",\r\n            pointHoverBorderColor: \"rgba(0,220,0,1)\",\r\n            " . $data3 . "\r\n        },\r\n        {\r\n            label: \"4th Class\",\r\n            backgroundColor: \"rgba(255,255,0,0.3)\",\r\n            borderColor: \"rgba(255,255,0,1)\",\r\n            pointBackgroundColor: \"rgba(255,255,0,1)\",\r\n            pointBorderColor: \"#fff\",\r\n            pointHoverBackgroundColor: \"#fff\",\r\n            pointHoverBorderColor: \"rgba(255,255,0,1)\",\r\n            " . $data4 . "\r\n        }";
        echo "\r\n    ]\r\n};\r\nvar context = document.getElementById(\"classes\").getContext(\"2d\");\r\nvar classes = new Chart(context, {\r\n    type: 'radar',\r\n    data: classesData\r\n});\r\n</script>";
    } else {
        if (100 <= config("server_files_season", true)) {
            echo "\r\n<script>\r\nvar classesData = {\r\n    labels: [\"Wizard\", \"Knight\", \"Elf\", \"Summoner\", \"Gladiator\", \"Lord\", \"Fighter\", \"Lancer\"],\r\n    datasets: [\r\n        {\r\n            label: \"1st Class\",\r\n            backgroundColor: \"rgba(0,0,220,0.3)\",\r\n            borderColor: \"rgba(0,0,220,1)\",\r\n            pointBackgroundColor: \"rgba(0,0,220,1)\",\r\n            pointBorderColor: \"#fff\",\r\n            pointHoverBackgroundColor: \"#fff\",\r\n            pointHoverBorderColor: \"rgba(0,0,220,1)\",\r\n            " . $data1 . "\r\n        },\r\n        {\r\n            label: \"2nd Class\",\r\n            backgroundColor: \"rgba(220,0,0,0.3)\",\r\n            borderColor: \"rgba(220,0,0,1)\",\r\n            pointBackgroundColor: \"rgba(220,0,0,1)\",\r\n            pointBorderColor: \"#fff\",\r\n            pointHoverBackgroundColor: \"#fff\",\r\n            pointHoverBorderColor: \"rgba(220,0,0,1)\",\r\n            " . $data2 . "\r\n        },\r\n        {\r\n            label: \"3rd Class\",\r\n            backgroundColor: \"rgba(0,220,0,0.3)\",\r\n            borderColor: \"rgba(0,220,0,1)\",\r\n            pointBackgroundColor: \"rgba(0,220,0,1)\",\r\n            pointBorderColor: \"#fff\",\r\n            pointHoverBackgroundColor: \"#fff\",\r\n            pointHoverBorderColor: \"rgba(0,220,0,1)\",\r\n            " . $data3 . "\r\n        }";
            if (122 <= config("server_files_season", true)) {
                echo ",\r\n        {\r\n            label: \"4th Class\",\r\n            backgroundColor: \"rgba(255,255,0,0.3)\",\r\n            borderColor: \"rgba(255,255,0,1)\",\r\n            pointBackgroundColor: \"rgba(255,255,0,1)\",\r\n            pointBorderColor: \"#fff\",\r\n            pointHoverBackgroundColor: \"#fff\",\r\n            pointHoverBorderColor: \"rgba(255,255,0,1)\",\r\n            " . $data4 . "\r\n        }";
            }
            echo "\r\n    ]\r\n};\r\nvar context = document.getElementById(\"classes\").getContext(\"2d\");\r\nvar classes = new Chart(context, {\r\n    type: 'radar',\r\n    data: classesData\r\n});\r\n</script>";
        } else {
            echo "\r\n<script>\r\nvar classesData = {\r\n    labels: [\"Wizard\", \"Knight\", \"Elf\", \"Summoner\", \"Gladiator\", \"Lord\", \"Fighter\"],\r\n    datasets: [\r\n        {\r\n            label: \"1st Class\",\r\n            backgroundColor: \"rgba(0,0,220,0.3)\",\r\n            borderColor: \"rgba(0,0,220,1)\",\r\n            pointBackgroundColor: \"rgba(0,0,220,1)\",\r\n            pointBorderColor: \"#fff\",\r\n            pointHoverBackgroundColor: \"#fff\",\r\n            pointHoverBorderColor: \"rgba(0,0,220,1)\",\r\n            " . $data1 . "\r\n        },\r\n        {\r\n            label: \"2nd Class\",\r\n            backgroundColor: \"rgba(220,0,0,0.3)\",\r\n            borderColor: \"rgba(220,0,0,1)\",\r\n            pointBackgroundColor: \"rgba(220,0,0,1)\",\r\n            pointBorderColor: \"#fff\",\r\n            pointHoverBackgroundColor: \"#fff\",\r\n            pointHoverBorderColor: \"rgba(220,0,0,1)\",\r\n            " . $data2 . "\r\n        },\r\n        {\r\n            label: \"3rd Class\",\r\n            backgroundColor: \"rgba(0,220,0,0.3)\",\r\n            borderColor: \"rgba(0,220,0,1)\",\r\n            pointBackgroundColor: \"rgba(0,220,0,1)\",\r\n            pointBorderColor: \"#fff\",\r\n            pointHoverBackgroundColor: \"#fff\",\r\n            pointHoverBorderColor: \"rgba(0,220,0,1)\",\r\n            " . $data3 . "\r\n        }\r\n    ]\r\n};\r\n\r\nvar context = document.getElementById(\"classes\").getContext(\"2d\");\r\nvar classes = new Chart(context, {\r\n    type: 'radar',\r\n    data: classesData\r\n});\r\n</script>";
        }
    }
}
echo "</div></div><div class=\"row\"><div class=\"col-md-12\"><h4>Latest registrations:</h4>";
$labels = "";
$i = 6;
while (0 <= $i) {
    $currDay = date($config["date_format"], strtotime("-" . $i . " days"));
    if ($i == 0) {
        $labels .= "\"" . $currDay . "\"";
    } else {
        $labels .= "\"" . $currDay . "\", ";
    }
    $i--;
}
$latestRegistrations = $dbacc->query_fetch("SELECT memb_guid, memb___id, appl_days FROM MEMB_INFO WHERE appl_days > ? ORDER BY appl_days ASC", [date("Y-m-d H:i:s", strtotime("-6 days"))]);
$data = [0, 0, 0, 0, 0, 0, 0];
if (is_array($latestRegistrations)) {
    foreach ($latestRegistrations as $thisAcc) {
        $regDay = date("Y-m-d", strtotime($thisAcc["appl_days"]));
        if ($regDay == date("Y-m-d", strtotime("-6 days"))) {
            $data[0] = $data[0] + 1;
        } else {
            if ($regDay == date("Y-m-d", strtotime("-5 days"))) {
                $data[1] = $data[1] + 1;
            } else {
                if ($regDay == date("Y-m-d", strtotime("-4 days"))) {
                    $data[2] = $data[2] + 1;
                } else {
                    if ($regDay == date("Y-m-d", strtotime("-3 days"))) {
                        $data[3] = $data[3] + 1;
                    } else {
                        if ($regDay == date("Y-m-d", strtotime("-2 days"))) {
                            $data[4] = $data[4] + 1;
                        } else {
                            if ($regDay == date("Y-m-d", strtotime("-1 days"))) {
                                $data[5] = $data[5] + 1;
                            } else {
                                if ($regDay == date("Y-m-d", time())) {
                                    $data[6] = $data[6] + 1;
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
echo "<canvas id=\"latestRegDays\" width=\"600\" height=\"150\"></canvas>\r\n<script>\r\nvar ctx = document.getElementById(\"latestRegDays\").getContext('2d');\r\nvar latestRegDaysChart = new Chart(ctx, {\r\n    type: 'bar',\r\n    data: {\r\n        labels: [" . $labels . "],\r\n        datasets: [{\r\n            label: '# of Registrations',\r\n            data: [" . $data[0] . ", " . $data[1] . ", " . $data[2] . ", " . $data[3] . ", " . $data[4] . ", " . $data[5] . ", " . $data[6] . "],\r\n            backgroundColor: [\r\n                'rgba(54, 162, 235, 0.2)',\r\n                'rgba(54, 162, 235, 0.2)',\r\n                'rgba(54, 162, 235, 0.2)',\r\n                'rgba(54, 162, 235, 0.2)',\r\n                'rgba(54, 162, 235, 0.2)',\r\n                'rgba(54, 162, 235, 0.2)',\r\n                'rgba(54, 162, 235, 0.2)'\r\n            ],\r\n            borderColor: [\r\n                'rgba(54, 162, 235, 1)',\r\n                'rgba(54, 162, 235, 1)',\r\n                'rgba(54, 162, 235, 1)',\r\n                'rgba(54, 162, 235, 1)',\r\n                'rgba(54, 162, 235, 1)',\r\n                'rgba(54, 162, 235, 1)',\r\n                'rgba(54, 162, 235, 1)'\r\n            ],\r\n            borderWidth: 1\r\n        }]\r\n    },\r\n    options: {\r\n        scales: {\r\n            yAxes: [{\r\n                ticks: {\r\n                    beginAtZero: true\r\n                }\r\n            }]\r\n        }\r\n    }\r\n});\r\n</script>";
echo "</div></div><div class=\"row\"><div class=\"col-md-12\">";
$labels = "";
$i = 6;
while (0 <= $i) {
    $currMonth = date("F", strtotime("-" . $i . " months"));
    if ($i == 0) {
        $labels .= "\"" . $currMonth . "\"";
    } else {
        $labels .= "\"" . $currMonth . "\", ";
    }
    $i--;
}
$latestRegistrations = $dbacc->query_fetch("SELECT memb_guid, memb___id, appl_days FROM MEMB_INFO WHERE appl_days > ? ORDER BY appl_days ASC", [date("Y-m-d H:i:s", strtotime("-6 months"))]);
$data = [0, 0, 0, 0, 0, 0, 0];
foreach ($latestRegistrations as $thisAcc) {
    $regDay = date("Y-m", strtotime($thisAcc["appl_days"]));
    if ($regDay == date("Y-m", strtotime("-6 months"))) {
        $data[0] = $data[0] + 1;
    } else {
        if ($regDay == date("Y-m", strtotime("-5 months"))) {
            $data[1] = $data[1] + 1;
        } else {
            if ($regDay == date("Y-m", strtotime("-4 months"))) {
                $data[2] = $data[2] + 1;
            } else {
                if ($regDay == date("Y-m", strtotime("-3 months"))) {
                    $data[3] = $data[3] + 1;
                } else {
                    if ($regDay == date("Y-m", strtotime("-2 months"))) {
                        $data[4] = $data[4] + 1;
                    } else {
                        if ($regDay == date("Y-m", strtotime("-1 months"))) {
                            $data[5] = $data[5] + 1;
                        } else {
                            if ($regDay == date("Y-m", time())) {
                                $data[6] = $data[6] + 1;
                            }
                        }
                    }
                }
            }
        }
    }
}
echo "<canvas id=\"latestRegMonths\" width=\"600\" height=\"150\"></canvas>\r\n<script>\r\nvar ctx = document.getElementById(\"latestRegMonths\").getContext('2d');\r\nvar latestRegMonthsChart = new Chart(ctx, {\r\n    type: 'bar',\r\n    data: {\r\n        labels: [" . $labels . "],\r\n        datasets: [{\r\n            label: '# of Registrations',\r\n            data: [" . $data[0] . ", " . $data[1] . ", " . $data[2] . ", " . $data[3] . ", " . $data[4] . ", " . $data[5] . ", " . $data[6] . "],\r\n            backgroundColor: [\r\n                'rgba(255, 99, 132, 0.2)',\r\n                'rgba(255, 99, 132, 0.2)',\r\n                'rgba(255, 99, 132, 0.2)',\r\n                'rgba(255, 99, 132, 0.2)',\r\n                'rgba(255, 99, 132, 0.2)',\r\n                'rgba(255, 99, 132, 0.2)',\r\n                'rgba(255, 99, 132, 0.2)'\r\n            ],\r\n            borderColor: [\r\n                'rgba(255, 99, 132, 1)',\r\n                'rgba(255, 99, 132, 1)',\r\n                'rgba(255, 99, 132, 1)',\r\n                'rgba(255, 99, 132, 1)',\r\n                'rgba(255, 99, 132, 1)',\r\n                'rgba(255, 99, 132, 1)',\r\n                'rgba(255, 99, 132, 1)'\r\n            ],\r\n            borderWidth: 1\r\n        }]\r\n    },\r\n    options: {\r\n        scales: {\r\n            yAxes: [{\r\n                ticks: {\r\n                    beginAtZero: true\r\n                }\r\n            }]\r\n        }\r\n    }\r\n});\r\n</script>";
echo "</div></div></div></div><div class=\"panel panel-default\"><div class=\"panel-heading\">ImperiaMuCMS Facebook Feed</div><div class=\"panel-body\"><iframe src=\"//www.facebook.com/plugins/likebox.php?\r\n      href=http%3A%2F%2Fwww.facebook.com%2FImperiaMuCMS&amp;\r\n      width=600&amp;height=400&amp;colorscheme=light&amp;\r\n      show_faces=false&amp;header=false&amp;stream=true&amp;\r\n      show_border=false&amp;appId=1439010682981422\" scrolling=\"no\"\r\n      frameborder=\"0\" style=\"border:none; overflow:hidden;\r\n      width:600px; height:400px;\" allowTransparency=\"true\"></iframe></div></div></div></div>";
function getBetween($var1 = "", $var2 = "", $pool)
{
    $temp1 = strpos($pool, $var1) + strlen($var1);
    $result = substr($pool, $temp1, strlen($pool));
    $dd = strpos($result, $var2);
    if ($dd == 0) {
        $dd = strlen($result);
    }
    return substr($result, 0, $dd);
}

?>