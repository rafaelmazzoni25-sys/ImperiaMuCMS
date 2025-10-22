<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h2>Admins Manager</h2>\r\n\r\n";
if (check_value($_POST["submit_changes"])) {
    if (is_writable(__PATH_INCLUDES__ . "config.php")) {
        $configFile = file_get_contents(__PATH_INCLUDES__ . "config.php");
        $configStart = strstr($configFile, "\$config[\"admincp_modules_access\"] = array(", true);
        $configPos = strstr($configFile, "\$config[\"admincp_modules_access\"] = array(");
        $configMid = strstr($configPos, ");", true);
        $configEnd = strstr($configPos, ");");
        $i = 0;
        $newConfig = "\$config[\"admincp_modules_access\"] = array(";
        foreach ($_POST as $thisValue) {
            if ($i + 1 < count($_POST)) {
                if ($i % 2 == 0) {
                    $newConfig .= "\r\n    \"" . $thisValue . "\" => ";
                } else {
                    if (is_numeric($thisValue) && 0 <= $thisValue) {
                        $newConfig .= "" . $thisValue . ",";
                    } else {
                        message("error", "Access level must be a number.");
                        $newConfig .= "\r\n";
                        $fileContent = $configStart . $newConfig . $configEnd;
                        file_put_contents(__PATH_INCLUDES__ . "config.php", $fileContent);
                        message("success", "Changes were successfully saved.");
                        message("notice", "Please click <a href=\"" . admincp_base("admins_manager") . "\">HERE</a> to load updated settings.");
                    }
                }
                $i++;
            }
        }
    } else {
        message("error", __PATH_INCLUDES__ . "config.php is not writable!");
    }
}
if (check_value($_POST["add"])) {
    if (is_writable(__PATH_INCLUDES__ . "config.php")) {
        if ($common->userExists($_POST["name"])) {
            $currentAdmins = [];
            foreach ($config["admins"] as $admin => $access) {
                array_push($currentAdmins, $admin);
            }
            if (!in_array($_POST["name"], $currentAdmins)) {
                if (is_numeric($_POST["access"]) && 0 <= $_POST["access"]) {
                    $configFile = file_get_contents(__PATH_INCLUDES__ . "config.php");
                    $configStart = strstr($configFile, "\$config[\"admins\"] = array(", true);
                    $configPos = strstr($configFile, "\$config[\"admins\"] = array(");
                    $configMid = strstr($configPos, ");", true);
                    $configEnd = strstr($configPos, ");");
                    $i = 0;
                    $newConfig = "\$config[\"admins\"] = array(";
                    foreach ($config["admins"] as $admin => $access) {
                        $newConfig .= "\r\n    \"" . $admin . "\" => " . $access . ",";
                    }
                    $newConfig .= "\r\n    \"" . $_POST["name"] . "\" => " . $_POST["access"] . ",";
                    $newConfig .= "\r\n";
                    $fileContent = $configStart . $newConfig . $configEnd;
                    file_put_contents(__PATH_INCLUDES__ . "config.php", $fileContent);
                    message("success", "New Administrator was successfully added.");
                    message("notice", "Please click <a href=\"" . admincp_base("admins_manager") . "\">HERE</a> to load updated settings.");
                } else {
                    message("error", "Access level must be a number.");
                }
            } else {
                message("error", "Account has already access to AdminCP.");
            }
        } else {
            message("error", "Account " . $_POST["name"] . " does not exist.");
        }
    } else {
        message("error", __PATH_INCLUDES__ . "config.php is not writable!");
    }
}
if (check_value($_POST["save"])) {
    if (is_writable(__PATH_INCLUDES__ . "config.php")) {
        if ($common->userExists($_POST["name"])) {
            if (is_numeric($_POST["access"]) && 0 <= $_POST["access"]) {
                $configFile = file_get_contents(__PATH_INCLUDES__ . "config.php");
                $configStart = strstr($configFile, "\$config[\"admins\"] = array(", true);
                $configPos = strstr($configFile, "\$config[\"admins\"] = array(");
                $configMid = strstr($configPos, ");", true);
                $configEnd = strstr($configPos, ");");
                $i = 0;
                $newConfig = "\$config[\"admins\"] = array(";
                foreach ($config["admins"] as $admin => $access) {
                    if ($admin == $_POST["name"]) {
                        $newConfig .= "\r\n    \"" . $admin . "\" => " . $_POST["access"] . ",";
                    } else {
                        $newConfig .= "\r\n    \"" . $admin . "\" => " . $access . ",";
                    }
                }
                $newConfig .= "\r\n";
                $fileContent = $configStart . $newConfig . $configEnd;
                file_put_contents(__PATH_INCLUDES__ . "config.php", $fileContent);
                message("success", "Administrator " . $_POST["name"] . " was successfully edited.");
                message("notice", "Please click <a href=\"" . admincp_base("admins_manager") . "\">HERE</a> to load updated settings.");
            } else {
                message("error", "Access level must be a number.");
            }
        } else {
            message("error", "Account " . $_POST["name"] . " does not exist.");
        }
    } else {
        message("error", __PATH_INCLUDES__ . "config.php is not writable!");
    }
}
if (check_value($_POST["delete"])) {
    if (is_writable(__PATH_INCLUDES__ . "config.php")) {
        $configFile = file_get_contents(__PATH_INCLUDES__ . "config.php");
        $configStart = strstr($configFile, "\$config[\"admins\"] = array(", true);
        $configPos = strstr($configFile, "\$config[\"admins\"] = array(");
        $configMid = strstr($configPos, ");", true);
        $configEnd = strstr($configPos, ");");
        $i = 0;
        $newConfig = "\$config[\"admins\"] = array(";
        foreach ($config["admins"] as $admin => $access) {
            if ($admin != $_POST["name"]) {
                $newConfig .= "\r\n    \"" . $admin . "\" => " . $access . ",";
            }
        }
        $newConfig .= "\r\n";
        $fileContent = $configStart . $newConfig . $configEnd;
        file_put_contents(__PATH_INCLUDES__ . "config.php", $fileContent);
        message("success", "Administrator " . $_POST["name"] . " was successfully deleted.");
        message("notice", "Please click <a href=\"" . admincp_base("admins_manager") . "\">HERE</a> to load updated settings.");
    } else {
        message("error", __PATH_INCLUDES__ . "config.php is not writable!");
    }
}
echo "\r\n<table class=\"table table-striped table-bordered table-hover\">\r\n    <tr>\r\n        <th>#</th>\r\n        <th>Name</th>\r\n        <th>Access Level</th>\r\n        <th>Action</th>\r\n    </tr>\r\n\r\n    ";
$admins = $config["admins"];
$i = 1;
foreach ($admins as $thisAdmin => $accessLevel) {
    echo "\r\n    <tr>\r\n        <form action=\"" . admincp_base("admins_manager") . "\" method=\"post\">\r\n        <td>" . $i . "</td>\r\n        <td><input name=\"name\" type=\"text\" class=\"form-control\" value=\"" . $thisAdmin . "\" readonly=\"readonly\"/></td>\r\n        <td><input name=\"access\" type=\"text\" class=\"form-control\" value=\"" . $accessLevel . "\"/></td>\r\n        <td>\r\n            <input type=\"submit\" name=\"save\" value=\"Save\" class=\"btn btn-success\"/>&nbsp;\r\n            <input type=\"submit\" name=\"delete\" value=\"Delete\" class=\"btn btn-danger\" onclick=\"if (confirm('Do you really want to delete admin access for " . $thisAdmin . "?')) return true; return false;\" />\r\n        </td>\r\n        </form>\r\n    </tr>";
    $i++;
}
echo "\r\n</table>\r\n\r\n<hr>\r\n<h3>Add new Admin</h3>\r\n<form action=\"";
echo admincp_base("admins_manager");
echo "\" method=\"post\">\r\n    <table class=\"table table-striped table-bordered table-hover\">\r\n        <tr>\r\n            <th>Name</th>\r\n            <th>Access Level</th>\r\n            <th>Action</th>\r\n        </tr>\r\n        <tr>\r\n            <td><input name=\"name\" type=\"text\" class=\"form-control\" value=\"\" placeholder=\"Name\"/></td>\r\n            <td><input name=\"access\" type=\"text\" class=\"form-control\" value=\"\" placeholder=\"Access Level\"/></td>\r\n            <td><input type=\"submit\" name=\"add\" value=\"Add\" class=\"btn btn-success\"/></td>\r\n        </tr>\r\n    </table>\r\n</form>\r\n\r\n<hr>\r\n<h3>Manage Modules' Access Level</h3>\r\n<form action=\"";
echo admincp_base("admins_manager");
echo "\" method=\"post\">\r\n    <table class=\"table table-striped table-bordered table-hover\">\r\n        <tr>\r\n            <th>Name</th>\r\n            <th>Access Level</th>\r\n        </tr>\r\n\r\n        ";
$modulesAccessLevel = $config["admincp_modules_access"];
foreach ($modulesAccessLevel as $module => $accessLevel) {
    echo "\r\n        <tr>\r\n            <td><input name=\"module_" . $module . "\" type=\"text\" value=\"" . $module . "\" class=\"form-control\" readonly=\"readonly\"/></td>\r\n            <td><input name=\"access_" . $module . "\" type=\"text\" value=\"" . $accessLevel . "\" class=\"form-control\"/></td>\r\n        </tr>";
}
echo "        <tr>\r\n            <td colspan=\"2\"><input type=\"submit\" class=\"btn btn-success\" name=\"submit_changes\" value=\"Save\"/></td>\r\n        </tr>\r\n    </table>\r\n</form>\r\n";

?>