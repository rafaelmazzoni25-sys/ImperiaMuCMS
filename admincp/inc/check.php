<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$configError = [];
$writablePaths = ["cache/", "cache/news/", "cache/changelogs/", "cache/profiles/guilds/", "cache/profiles/players/", "config/", "config/modules/", "PagSeguroLibrary/log/donationslog/"];
foreach (glob(__PATH_INCLUDES__ . "license/*.imperiamucms") as $file) {
    $fileName = basename($file);
    array_push($writablePaths, "license/" . $fileName);
}
foreach ($writablePaths as $thisPath) {
    if (file_exists(__PATH_INCLUDES__ . $thisPath)) {
        if (!is_writable(__PATH_INCLUDES__ . $thisPath)) {
            $configError[] = "<span style=\"color:#aaaaaa;\">[Permission Error]</span> " . $thisPath . " <span style=\"color:red;\">(file must be writable)</span>";
        }
    } else {
        $configError[] = "<span style=\"color:#aaaaaa;\">[Not Found]</span> " . $thisPath . " <span style=\"color:orange;\">(re-upload file)</span>";
    }
}
if (!check_value($config["encryption_hash"])) {
    $configError[] = "<span style=\"color:#aaaaaa;\">[Configuration]</span> encryption_hash <span style=\"color:green;\">(must be configured)</span>";
} else {
    if (!in_array(strlen($config["encryption_hash"]), [16, 24, 32])) {
        $configError[] = "<span style=\"color:#aaaaaa;\">[Configuration]</span> encryption_hash <span style=\"color:green;\">(must have 16, 24 or 32 characters)</span>";
    }
}
if (!function_exists("curl_version")) {
    $configError[] = "<span style=\"color:#aaaaaa;\">[PHP]</span> <span style=\"color:green;\">cURL not loaded (ImperiaMuCMS requires cURL)</span>";
}
if (1 <= count($configError)) {
    throw new Exception("<strong>The following errors ocurred:</strong><br /><br />" . implode("<br />", $configError));
}

?>