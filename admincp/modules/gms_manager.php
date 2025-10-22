<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "\r\n<h2>GMCP Settings</h2>\r\n\r\n";
if (check_value($_POST["submit_changes2"])) {
    savechanges();
}
loadModuleConfigs("gmcp");
echo "\r\n<form action=\"\" method=\"post\">\r\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n        <tr>\r\n            <th>Status<br/><span>Enable/disable Game Master Control Panel.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_1", mconfig("active"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>VIP Add/Edit<br/><span>Enable/disable option to add/edit VIP on Account Info module.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_2", mconfig("enable_vip"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Account Management<br/><span>Enable/disable option to change account's password/email.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_3", mconfig("enable_edit_account"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan=\"2\"><input type=\"submit\" name=\"submit_changes2\" value=\"Save Changes\" class=\"btn btn-success\" style=\"width: 100%;\"/>\r\n            </td>\r\n        </tr>\r\n    </table>\r\n</form>\r\n\r\n<h2>Game Masters Manager</h2>\r\n\r\n";
if (check_value($_POST["submit_changes"])) {
    if (is_writable(__PATH_INCLUDES__ . "config.php")) {
        $configFile = file_get_contents(__PATH_INCLUDES__ . "config.php");
        $configStart = strstr($configFile, "\$config[\"gmcp_modules_access\"] = array(", true);
        $configPos = strstr($configFile, "\$config[\"gmcp_modules_access\"] = array(");
        $configMid = strstr($configPos, ");", true);
        $configEnd = strstr($configPos, ");");
        $i = 0;
        $newConfig = "\$config[\"gmcp_modules_access\"] = array(";
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
                        message("notice", "Please click <a href=\"" . admincp_base("gms_manager") . "\">HERE</a> to load updated settings.");
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
            $currentGMs = [];
            foreach ($config["gamemasters"] as $gm => $access) {
                array_push($currentGMs, $gm);
            }
            if (!in_array($_POST["name"], $currentGMs)) {
                if (is_numeric($_POST["access"]) && 0 <= $_POST["access"]) {
                    $configFile = file_get_contents(__PATH_INCLUDES__ . "config.php");
                    $configStart = strstr($configFile, "\$config[\"gamemasters\"] = array(", true);
                    $configPos = strstr($configFile, "\$config[\"gamemasters\"] = array(");
                    $configMid = strstr($configPos, ");", true);
                    $configEnd = strstr($configPos, ");");
                    $i = 0;
                    $newConfig = "\$config[\"gamemasters\"] = array(";
                    foreach ($config["gamemasters"] as $gm => $access) {
                        $newConfig .= "\r\n    \"" . $gm . "\" => " . $access . ",";
                    }
                    $newConfig .= "\r\n    \"" . $_POST["name"] . "\" => " . $_POST["access"] . ",";
                    $newConfig .= "\r\n";
                    $fileContent = $configStart . $newConfig . $configEnd;
                    file_put_contents(__PATH_INCLUDES__ . "config.php", $fileContent);
                    message("success", "New Game Master was successfully added.");
                    message("notice", "Please click <a href=\"" . admincp_base("gms_manager") . "\">HERE</a> to load updated settings.");
                } else {
                    message("error", "Access level must be a number.");
                }
            } else {
                message("error", "Account has already access to GMCP.");
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
                $configStart = strstr($configFile, "\$config[\"gamemasters\"] = array(", true);
                $configPos = strstr($configFile, "\$config[\"gamemasters\"] = array(");
                $configMid = strstr($configPos, ");", true);
                $configEnd = strstr($configPos, ");");
                $i = 0;
                $newConfig = "\$config[\"gamemasters\"] = array(";
                foreach ($config["gamemasters"] as $gm => $access) {
                    if ($gm == $_POST["name"]) {
                        $newConfig .= "\r\n    \"" . $gm . "\" => " . $_POST["access"] . ",";
                    } else {
                        $newConfig .= "\r\n    \"" . $gm . "\" => " . $access . ",";
                    }
                }
                $newConfig .= "\r\n";
                $fileContent = $configStart . $newConfig . $configEnd;
                file_put_contents(__PATH_INCLUDES__ . "config.php", $fileContent);
                message("success", "Game Master " . $_POST["name"] . " was successfully edited.");
                message("notice", "Please click <a href=\"" . admincp_base("gms_manager") . "\">HERE</a> to load updated settings.");
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
        $configStart = strstr($configFile, "\$config[\"gamemasters\"] = array(", true);
        $configPos = strstr($configFile, "\$config[\"gamemasters\"] = array(");
        $configMid = strstr($configPos, ");", true);
        $configEnd = strstr($configPos, ");");
        $i = 0;
        $newConfig = "\$config[\"gamemasters\"] = array(";
        foreach ($config["gamemasters"] as $gm => $access) {
            if ($gm != $_POST["name"]) {
                $newConfig .= "\r\n    \"" . $gm . "\" => " . $access . ",";
            }
        }
        $newConfig .= "\r\n";
        $fileContent = $configStart . $newConfig . $configEnd;
        file_put_contents(__PATH_INCLUDES__ . "config.php", $fileContent);
        message("success", "Game Master " . $_POST["name"] . " was successfully deleted.");
        message("notice", "Please click <a href=\"" . admincp_base("gms_manager") . "\">HERE</a> to load updated settings.");
    } else {
        message("error", __PATH_INCLUDES__ . "config.php is not writable!");
    }
}
echo "\r\n<table class=\"table table-striped table-bordered table-hover\">\r\n    <tr>\r\n        <th>#</th>\r\n        <th>Name</th>\r\n        <th>Access Level</th>\r\n        <th>Action</th>\r\n    </tr>\r\n\r\n    ";
$gms = $config["gamemasters"];
$i = 1;
foreach ($gms as $thisGM => $accessLevel) {
    echo "\r\n    <tr>\r\n        <form action=\"\" method=\"post\">\r\n        <td>" . $i . "</td>\r\n        <td><input name=\"name\" type=\"text\" class=\"form-control\" value=\"" . $thisGM . "\" readonly=\"readonly\"/></td>\r\n        <td><input name=\"access\" type=\"text\" class=\"form-control\" value=\"" . $accessLevel . "\"/></td>\r\n        <td>\r\n            <input type=\"submit\" name=\"save\" value=\"Save\" class=\"btn btn-success\"/>&nbsp;\r\n            <input type=\"submit\" name=\"delete\" value=\"Delete\" class=\"btn btn-danger\" onclick=\"if (confirm('Do you really want to delete GM access for " . $thisGM . "?')) return true; return false;\" />\r\n        </td>\r\n        </form>\r\n    </tr>";
    $i++;
}
echo "\r\n</table>\r\n\r\n<hr>\r\n<h3>Add new Game Master</h3>\r\n<form action=\"\" method=\"post\">\r\n    <table class=\"table table-striped table-bordered table-hover\">\r\n        <tr>\r\n            <th>Name</th>\r\n            <th>Access Level</th>\r\n            <th>Action</th>\r\n        </tr>\r\n        <tr>\r\n            <td><input name=\"name\" type=\"text\" class=\"form-control\" value=\"\" placeholder=\"Name\"/></td>\r\n            <td><input name=\"access\" type=\"text\" class=\"form-control\" value=\"\" placeholder=\"Access Level\"/></td>\r\n            <td><input type=\"submit\" name=\"add\" value=\"Add\" class=\"btn btn-success\"/></td>\r\n        </tr>\r\n    </table>\r\n</form>\r\n\r\n<hr>\r\n<h3>Manage Modules' Access Level</h3>\r\n<form action=\"\" method=\"post\">\r\n    <table class=\"table table-striped table-bordered table-hover\">\r\n        <tr>\r\n            <th>Name</th>\r\n            <th>Access Level</th>\r\n        </tr>\r\n\r\n        ";
$modulesAccessLevel = $config["gmcp_modules_access"];
foreach ($modulesAccessLevel as $module => $accessLevel) {
    echo "\r\n        <tr>\r\n            <td><input name=\"module_" . $module . "\" type=\"text\" value=\"" . $module . "\" class=\"form-control\" readonly=\"readonly\"/></td>\r\n            <td><input name=\"access_" . $module . "\" type=\"text\" value=\"" . $accessLevel . "\" class=\"form-control\"/></td>\r\n        </tr>";
}
echo "        <tr>\r\n            <td colspan=\"2\"><input type=\"submit\" class=\"btn btn-success\" name=\"submit_changes\" value=\"Save\"/></td>\r\n        </tr>\r\n    </table>\r\n</form>\r\n";
function saveChanges()
{
    $_POST;
    foreach ($_POST as $setting) {
        if (!check_value($setting)) {
            message("error", "Missing data (complete all fields).");
            return NULL;
        }
    }
    $xmlPath = __PATH_MODULE_CONFIGS__ . "gmcp.xml";
    $xml = simplexml_load_file($xmlPath);
    $xml->active = $_POST["setting_1"];
    $xml->enable_vip = $_POST["setting_2"];
    $xml->enable_edit_account = $_POST["setting_3"];
    $save = $xml->asXML($xmlPath);
    if ($save) {
        message("success", "Settings successfully saved.");
    } else {
        message("error", "There has been an error while saving changes.");
    }
}

?>