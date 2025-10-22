<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

if (check_value($_POST["add"])) {
    if (is_writable(__PATH_INCLUDES__ . "config.php")) {
        if (file_exists(__PATH_LANGUAGES__ . $_POST["folder"] . "/language.php")) {
            $currentLangs = [];
            $maxKey = 0;
            foreach ($config["languages"] as $key => $thisLang) {
                array_push($currentLangs, $thisLang[1]);
                if ($maxKey < $key) {
                    $maxKey = $key;
                }
            }
            $maxKey++;
            if (!in_array($_POST["folder"], $currentLangs)) {
                $configFile = file_get_contents(__PATH_INCLUDES__ . "config.php");
                $configStart = strstr($configFile, "\$config[\"languages\"] = array(", true);
                $configPos = strstr($configFile, "\$config[\"languages\"] = array(");
                $configMid = strstr($configPos, ");", true);
                $configEnd = strstr($configPos, ");");
                $i = 0;
                $newConfig = "\$config[\"languages\"] = array(";
                foreach ($config["languages"] as $key => $thisLang) {
                    $newConfig .= "\r\n    " . $key . " => array(\"" . $thisLang[0] . "\", \"" . $thisLang[1] . "\", \"" . $thisLang[2] . "\"),";
                }
                $newConfig .= "\r\n    " . $maxKey . " => array(\"" . $_POST["name"] . "\", \"" . $_POST["folder"] . "\", \"" . $_POST["flag"] . "\"),";
                $newConfig .= "\r\n";
                $fileContent = $configStart . $newConfig . $configEnd;
                file_put_contents(__PATH_INCLUDES__ . "config.php", $fileContent);
                message("success", "New language was successfully added.");
                message("notice", "Please click <a href=\"" . admincp_base("languages_manager") . "\">HERE</a> to load updated settings.");
            } else {
                message("error", "Language already exists.");
            }
        } else {
            message("error", __PATH_LANGUAGES__ . $_POST["folder"] . "/language.php does not exist.");
        }
    } else {
        message("error", __PATH_INCLUDES__ . "config.php is not writable!");
    }
}
if (check_value($_POST["save"])) {
    if (is_writable(__PATH_INCLUDES__ . "config.php")) {
        if (file_exists(__PATH_LANGUAGES__ . $_POST["folder"] . "/language.php")) {
            $configFile = file_get_contents(__PATH_INCLUDES__ . "config.php");
            $configStart = strstr($configFile, "\$config[\"languages\"] = array(", true);
            $configPos = strstr($configFile, "\$config[\"languages\"] = array(");
            $configMid = strstr($configPos, ");", true);
            $configEnd = strstr($configPos, ");");
            $i = 0;
            $newConfig = "\$config[\"languages\"] = array(";
            foreach ($config["languages"] as $key => $thisLang) {
                if ($_POST["folder"] == $thisLang[1]) {
                    $newConfig .= "\r\n    " . $key . " => array(\"" . $_POST["name"] . "\", \"" . $_POST["folder"] . "\", \"" . $_POST["flag"] . "\"),";
                } else {
                    $newConfig .= "\r\n    " . $key . " => array(\"" . $thisLang[0] . "\", \"" . $thisLang[1] . "\", \"" . $thisLang[2] . "\"),";
                }
            }
            $newConfig .= "\r\n";
            $fileContent = $configStart . $newConfig . $configEnd;
            file_put_contents(__PATH_INCLUDES__ . "config.php", $fileContent);
            message("success", "New language was successfully added.");
            message("notice", "Please click <a href=\"" . admincp_base("languages_manager") . "\">HERE</a> to load updated settings.");
        } else {
            message("error", __PATH_LANGUAGES__ . $_POST["folder"] . "/language.php does not exist.");
        }
    } else {
        message("error", __PATH_INCLUDES__ . "config.php is not writable!");
    }
}
if (check_value($_POST["submit_changes"])) {
    if (is_writable(__PATH_INCLUDES__ . "config.php")) {
        $configFile = file_get_contents(__PATH_INCLUDES__ . "config.php");
        $configStart = strstr($configFile, "\$config[\"language_switch_active\"] = ", true);
        $configPos = strstr($configFile, "\$config[\"language_switch_active\"] = ");
        $configMid = strstr($configPos, "\";", true);
        $configEnd = strstr($configPos, "\";");
        if ($_POST["language_switch_active"]) {
            $langSwitch = "true";
        } else {
            $langSwitch = "false";
        }
        $newConfig = "\$config[\"language_switch_active\"] = " . $langSwitch . ";\r\n\$config[\"language_default\"] = \"" . $_POST["language_default"];
        $fileContent = $configStart . $newConfig . $configEnd;
        file_put_contents(__PATH_INCLUDES__ . "config.php", $fileContent);
        message("success", "Settings were successfully saved.");
        message("notice", "Please click <a href=\"" . admincp_base("languages_manager") . "\">HERE</a> to load updated settings.");
    } else {
        message("error", __PATH_INCLUDES__ . "config.php is not writable!");
    }
}
$languages = $config["languages"];
echo "\r\n<h2>Languages Settings</h2>\r\n\r\n<form action=\"\" method=\"post\">\r\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n        <tr>\r\n            <th>Language Switch<br/><span></span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("language_switch_active", $config["language_switch_active"], "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Default Language<br/><span></span></th>\r\n            <td>\r\n                <select name=\"language_default\" class=\"form-control\">\r\n                    ";
foreach ($languages as $thisLang) {
    if ($thisLang[1] == $config["language_default"]) {
        echo "<option value=\"" . $thisLang[1] . "\" selected=\"selected\">" . $thisLang[1] . "</option>";
    } else {
        echo "<option value=\"" . $thisLang[1] . "\">" . $thisLang[1] . "</option>";
    }
}
echo "                </select>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan=\"2\"><input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\" class=\"btn btn-success\" style=\"width: 100%;\"/></td>\r\n        </tr>\r\n    </table>\r\n</form>\r\n\r\n<h2>Languages Manager</h2>\r\n\r\n<table class=\"table table-striped table-bordered table-hover\">\r\n    <tr>\r\n        <th>#</th>\r\n        <th>Name</th>\r\n        <th>Language Folder</th>\r\n        <th>Flag</th>\r\n        <th>Action</th>\r\n    </tr>\r\n\r\n    ";
$i = 1;
foreach ($languages as $thisLang) {
    echo "\r\n    <tr>\r\n        <form action=\"\" method=\"post\">\r\n        <td>" . $i . "</td>\r\n        <td><input name=\"name\" type=\"text\" class=\"form-control\" value=\"" . $thisLang[0] . "\"/></td>\r\n        <td><input name=\"folder\" type=\"text\" class=\"form-control\" value=\"" . $thisLang[1] . "\"/></td>\r\n        <td><input name=\"flag\" type=\"text\" class=\"form-control\" value=\"" . $thisLang[2] . "\"/></td>\r\n        <td><input type=\"submit\" name=\"save\" value=\"Save\" class=\"btn btn-success\"/> <input type=\"submit\" name=\"delete\" value=\"Delete\" class=\"btn btn-danger\"/></td>\r\n        </form>\r\n    </tr>";
    $i++;
}
echo "\r\n</table>\r\n\r\n<hr>\r\n<h3>Add new Language</h3>\r\n<form action=\"\" method=\"post\">\r\n    <table class=\"table table-striped table-bordered table-hover\">\r\n        <tr>\r\n            <th>Name</th>\r\n            <th>Language Folder</th>\r\n            <th>Flag</th>\r\n            <th>Action</th>\r\n        </tr>\r\n        <tr>\r\n            <td><input name=\"name\" type=\"text\" class=\"form-control\" value=\"\" placeholder=\"Name\"/></td>\r\n            <td><input name=\"folder\" type=\"text\" class=\"form-control\" value=\"\" placeholder=\"Language Folder\"/></td>\r\n            <td><input name=\"flag\" type=\"text\" class=\"form-control\" value=\"\" placeholder=\"Flag\"/></td>\r\n            <td><input type=\"submit\" name=\"add\" value=\"Add\" class=\"btn btn-success\"/></td>\r\n        </tr>\r\n    </table>\r\n</form>\r\n";

?>