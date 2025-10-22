<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$req = "";
$req2 = "";
$req3 = "";
$error = false;
echo "\r\n<script>\r\nfunction reloadPage() {\r\n    location.reload();\r\n}\r\n</script>";
$phpVersion = PHP_VERSION;
if (0 <= version_compare(PHP_VERSION, "7.2.0")) {
    $req .= "<li class=\"success\">PHP version " . $phpVersion . ".</li>";
} else {
    $req .= "<li class=\"fail\">You need to update your PHP version.</li>";
    $error = true;
}
if (extension_loaded("curl")) {
    $req .= "<li class=\"success\">cURL extension loaded.</li>";
} else {
    $req .= "<li class=\"fail\">You do not have the cURL PHP extension loaded. You should contact your hosting provider or system administrator to ask either for cURL to be installed.</li>";
    $error = true;
}
if (ini_get("short_open_tag")) {
    $req .= "<li class=\"success\">short_open_tag enabled.</li>";
} else {
    $req .= "<li class=\"fail\">short_open_tag PHP setting is disabled. You should contact your hosting provider or system administrator to ask either for short_open_tag setting enabled.</li>";
    $error = true;
}
$dbextension = false;
if (extension_loaded("pdo_dblib")) {
    $req .= "<li class=\"success\">PDO Driver - DbLib extension loaded.</li>";
    $dbextension = true;
}
if (extension_loaded("PDO_SQLSRV")) {
    $req .= "<li class=\"success\">PDO Driver - Sqlsrv extension loaded.</li>";
    $dbextension = true;
}
if (extension_loaded("PDO_ODBC")) {
    $req .= "<li class=\"success\">PDO Driver - ODBC extension loaded.</li>";
    $dbextension = true;
}
if (!$dbextension) {
    $req .= "<li class=\"fail\">PDO Driver - You do not have the DbLib PHP / Sqlsrv / ODBC extension loaded.";
    $error = true;
}
if (function_exists("apache_get_modules")) {
    if (in_array("mod_rewrite", apache_get_modules())) {
        $req .= "<li class=\"success\">mod_rewrite module is enabled.</li>";
    } else {
        $req .= "<li class=\"fail\">mod_rewrite module is disabled. You should contact your hosting provider or system administrator to ask either for mod_rewrite module enabled.</li>";
        $error = true;
    }
} else {
    $req .= "<li class=\"warning\">mod_rewrite module could not be checked, please check manually if it's enabled on your web server.</li>";
}
if (extension_loaded("bcmath")) {
    $req .= "<li class=\"success\">BCMath extension loaded.</li>";
} else {
    $req .= "<li class=\"fail\">You do not have the BCMath PHP extension loaded.</li>";
    $error = true;
}
if (extension_loaded("gd")) {
    $req .= "<li class=\"success\">GD extension loaded.</li>";
} else {
    $req .= "<li class=\"fail\">You do not have the GD PHP extension loaded.</li>";
    $error = true;
}
if (extension_loaded("openssl")) {
    $req .= "<li class=\"success\">OpenSSL extension loaded.</li>";
} else {
    $req .= "<li class=\"fail\">You do not have the OpenSSL PHP extension loaded.</li>";
    $error = true;
}
if (extension_loaded("session")) {
    $req .= "<li class=\"success\">Session extension loaded.</li>";
} else {
    $req .= "<li class=\"fail\">You do not have the Session PHP extension loaded.</li>";
    $error = true;
}
if (extension_loaded("simplexml")) {
    $req .= "<li class=\"success\">Simple XML extension loaded.</li>";
} else {
    $req .= "<li class=\"fail\">You do not have the Simple XML PHP extension loaded.</li>";
    $error = true;
}
if (extension_loaded("xml")) {
    $req .= "<li class=\"success\">XML extension loaded.</li>";
} else {
    $req .= "<li class=\"fail\">You do not have the XML PHP extension loaded.</li>";
    $error = true;
}
if (extension_loaded("xmlreader")) {
    $req .= "<li class=\"success\">XML Reader extension loaded.</li>";
} else {
    $req .= "<li class=\"fail\">You do not have the XML Reader PHP extension loaded.</li>";
    $error = true;
}
if (extension_loaded("xmlwriter")) {
    $req .= "<li class=\"success\">XML Writer extension loaded.</li>";
} else {
    $req .= "<li class=\"fail\">You do not have the XML Writer PHP extension loaded.</li>";
    $error = true;
}
foreach (["includes/cache", "includes/license", "includes/cache/changelogs", "includes/cache/news", "includes/cache/profiles", "includes/config", "includes/config/modules", "includes/PagSeguroLibrary/log/donationslog", "includes/cache/daily_rankings", "includes/cache/weekly_rankings", "includes/cache/monthly_rankings"] as $dir) {
    if (is_writable(__ROOT_DIR__ . $dir)) {
        $req2 .= "<li class=\"success\">" . __ROOT_DIR__ . $dir . " is writable.</li>";
    } else {
        $req2 .= "<li class=\"fail\">" . __ROOT_DIR__ . $dir . " is not writable.</li>";
        $error = true;
    }
}
if (!file_exists(__ROOT_DIR__ . "includes/config.php")) {
    $req3 .= "<li class=\"fail\">" . __ROOT_DIR__ . "includes/config.php does not exist.</li>";
    $error = true;
} else {
    if (is_writable(__ROOT_DIR__ . "includes/config.php")) {
        $req3 .= "<li class=\"success\">" . __ROOT_DIR__ . "includes/config.php is writable.</li>";
    } else {
        $req3 .= "<li class=\"fail\">" . __ROOT_DIR__ . "includes/config.php is not writable.</li>";
        $error = true;
    }
}
echo "\r\n<div class=\"page-header\">\r\n    <h1>ImperiaMuCMS Install\r\n        <small>Step: System Check</small>\r\n    </h1>\r\n</div>\r\n<div class=\"panel panel-default\">\r\n    <div class=\"panel-body\">\r\n        <div class=\"row\">\r\n            <div class=\"col-md-3\">\r\n                <ul class=\"nav nav-pills nav-stacked no-hover\">\r\n                    <li class=''>\r\n                        <a><i class='fa fa-circle'></i>&nbsp;&nbsp;System Check</a>\r\n                    </li>\r\n                    <li class=''>\r\n                        <a><i class='fa fa-circle-o'></i>&nbsp;&nbsp;License</a>\r\n                    </li>\r\n                    <li class=''>\r\n                        <a><i class='fa fa-circle-o'></i>&nbsp;&nbsp;Website Config</a>\r\n                    </li>\r\n                    <li class=''>\r\n                        <a><i class='fa fa-circle-o'></i>&nbsp;&nbsp;Install</a>\r\n                    </li>\r\n                </ul>\r\n            </div>\r\n            <div class=\"col-md-9\">\r\n                <h4>PHP Requirements</h4>\r\n                <ul class=\"list-unstyled requirements\">\r\n                    ";
echo $req;
echo "                </ul>\r\n                <h4>File System Requirements</h4>\r\n                <h6>Make sure all files inside folders below have chmod 0777.</h6>\r\n                <ul class=\"list-unstyled requirements\">\r\n                    ";
echo $req2;
echo "                </ul>\r\n                <h4>Configuration Requirements</h4>\r\n                <ul class=\"list-unstyled requirements\">\r\n                    ";
echo $req3;
echo "                </ul>\r\n            </div>\r\n            <div class=\"text-center\">\r\n                ";
if (!$error) {
    echo "                    <form method=\"post\" action=\"";
    echo __BASE_URL__;
    echo "index.php?step=license\">\r\n                        <input type=\"submit\" name=\"systemcheck\" value=\"Continue\" class=\"btn btn-primary btn-lg\">\r\n                    </form>\r\n                ";
} else {
    echo "<div class=\"btn btn-danger btn-lg\" onclick=\"reloadPage();\">Fix errors and reload page</div>";
}
echo "            </div>\r\n        </div>\r\n    </div>\r\n</div>";

?>