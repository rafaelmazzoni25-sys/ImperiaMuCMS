<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h2>Boss Timer Settings</h2>\r\n";
if (check_value($_POST["submit_changes"])) {
    savechanges();
}
$cronFile = "../cron/boss_timer.php";
if (check_value($_POST["add_boss"])) {
    if (check_value($_POST["name"]) && check_value($_POST["monsterId"]) && check_value($_POST["respawn"]) && check_value($_POST["order"])) {
        if (is_numeric($_POST["monsterId"])) {
            if (is_numeric($_POST["respawn"])) {
                if (is_numeric($_POST["order"])) {
                    $insert = $dB->query("INSERT INTO IMPERIAMUCMS_BOSS_TIMER ([name], [monsterId], [respawn], [order], [active]) VALUES (?, ?, ?, ?, ?)", [$_POST["name"], $_POST["monsterId"], $_POST["respawn"], $_POST["order"], 1]);
                    if ($insert) {
                        include $cronFile;
                        message("success", "New boss has been successfully added into Boss Timer.");
                    } else {
                        message("error", "Could not insert boss into database.");
                    }
                } else {
                    message("error", "Order must be a number.");
                }
            } else {
                message("error", "Respawn must be a number in seconds.");
            }
        } else {
            message("error", "Monster ID must be a number.");
        }
    } else {
        message("error", "Please fill all fields.");
    }
}
if (check_value($_POST["edit_boss"])) {
    if (check_value($_POST["id"]) && check_value($_POST["monsterId"]) && check_value($_POST["respawn"]) && check_value($_POST["order"])) {
        if (is_numeric($_POST["id"]) && is_numeric($_POST["order"]) && is_numeric($_POST["monsterId"]) && is_numeric($_POST["respawn"])) {
            $update = $dB->query("UPDATE IMPERIAMUCMS_BOSS_TIMER SET [name] = ?, [monsterId] = ?, [respawn] = ?, [order] = ? WHERE [id] = ?", [$_POST["name"], $_POST["monsterId"], $_POST["respawn"], $_POST["order"], $_POST["id"]]);
            if ($update) {
                include $cronFile;
                message("success", "Boss #" . $_POST["id"] . " has been successfully saved.");
            } else {
                message("error", "Could not update Boss #" . $_POST["id"] . ".");
            }
        } else {
            message("error", "Invalid value in ID/Order/Monster ID/Respawn.");
        }
    } else {
        message("error", "Please fill all fields.");
    }
}
if (check_value($_GET["delete"]) && is_numeric($_GET["delete"])) {
    $delete = $dB->query("DELETE FROM IMPERIAMUCMS_BOSS_TIMER WHERE id = ?", [$_GET["delete"]]);
    if ($delete) {
        include $cronFile;
        message("success", "Boss #" . $_GET["delete"] . " was deleted successfully.");
    } else {
        message("error", "Could not delete Boss #" . $_GET["delete"] . ".");
    }
}
if (check_value($_GET["enable"]) && is_numeric($_GET["enable"])) {
    $update = $dB->query("UPDATE IMPERIAMUCMS_BOSS_TIMER SET active = ? WHERE id = ?", [1, $_GET["enable"]]);
    if ($update) {
        include $cronFile;
        message("success", "Boss #" . $_GET["enable"] . " was enabled successfully.");
    } else {
        message("error", "Could not update Boss #" . $_GET["enable"] . ".");
    }
}
if (check_value($_GET["disable"]) && is_numeric($_GET["disable"])) {
    $update = $dB->query("UPDATE IMPERIAMUCMS_BOSS_TIMER SET active = ? WHERE id = ?", [0, $_GET["disable"]]);
    if ($update) {
        include $cronFile;
        message("success", "Boss #" . $_GET["disable"] . " was disabled successfully.");
    } else {
        message("error", "Could not update Boss #" . $_GET["disable"] . ".");
    }
}
loadModuleConfigs("bosstimer");
echo "<form action=\"";
echo admincp_base("modules_manager&config=bosstimer");
echo "\" method=\"post\">\r\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n        <tr>\r\n            <th>Status<br/><span>Enable/disable boss timer widget.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("active", mconfig("active"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Display Seconds<br/><span>Enable/disable seconds in boss timer.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("display_seconds", mconfig("display_seconds"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Show Killer<br/><span>Enable/disable information about last killer.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("show_killer", mconfig("show_killer"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Show Date<br/><span>Enable/disable information about last killed date and time.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("show_date", mconfig("show_date"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan=\"2\"><input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\" class=\"btn btn-success\"/></td>\r\n        </tr>\r\n    </table>\r\n</form>\r\n\r\n<hr><h3>Manage Bosses</h3>";
$bosses = $dB->query_fetch("SELECT * FROM [dbo].[IMPERIAMUCMS_BOSS_TIMER] ORDER BY [order] ASC");
$editModals = "";
echo "<table class=\"table table-striped table-bordered table-hover\"><tr><th>Order</th><th>Name</th><th>Monster ID</th><th>Respawn (seconds)</th><th>Action</th></tr>";
if (is_array($bosses)) {
    foreach ($bosses as $thisBoss) {
        echo "\r\n    <tr>\r\n        <td>" . $thisBoss["order"] . "</td>\r\n        <td>" . $thisBoss["name"] . "</td>\r\n        <td>" . $thisBoss["monsterId"] . "</td>\r\n        <td>" . number_format($thisBoss["respawn"]) . "</td>\r\n        <td>\r\n            <button type=\"button\" class=\"btn btn-default btn-sm\" data-toggle=\"modal\" data-target=\"#boss" . intval($thisBoss["id"]) . "\"><i class=\"fa fa-edit\"></i> Edit</button>";
        if ($thisBoss["active"] == "1") {
            echo " <a href=\"index.php?module=modules_manager&config=bosstimer&disable=" . intval($thisBoss["id"]) . "\" class=\"btn btn-danger btn-sm\" onclick=\"if(confirm('Do you really want to disable this boss?')) return true; else return false;\">Disable</a> ";
        } else {
            echo " <a href=\"index.php?module=modules_manager&config=bosstimer&enable=" . intval($thisBoss["id"]) . "\" class=\"btn btn-success btn-sm\" onclick=\"if(confirm('Do you really want to enable this boss?')) return true; else return false;\">Enable</a> ";
        }
        echo "\r\n            <a href=\"index.php?module=modules_manager&config=bosstimer&delete=" . intval($thisBoss["id"]) . "\" class=\"btn btn-danger btn-sm\" onclick=\"if(confirm('Do you really want to delete this boss?')) return true; else return false;\"><i class=\"fa fa-remove\"></i> Delete</a>\r\n        </td>\r\n    </tr>";
        $editModals .= "\r\n        <form method=\"post\" action=\"" . admincp_base("modules_manager&config=bosstimer") . "\" class=\"form-horizontal\">\r\n            <div id=\"boss" . intval($thisBoss["id"]) . "\" class=\"modal fade\" role=\"dialog\">\r\n                <div class=\"modal-dialog modal-lg\">\r\n                    <div class=\"modal-content\">\r\n                        <div class=\"modal-header\">\r\n                            <button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>\r\n                            <h4 class=\"modal-title\">Edit Boss #" . intval($thisBoss["id"]) . "</h4>\r\n                        </div>\r\n                        <div class=\"modal-body\">\r\n                            <div style=\"min-height: 400px;\">\r\n                                <div class=\"form-group\">\r\n                                    <label class=\"col-sm-4 control-label\" for=\"name\">Name:</label>\r\n                                    <div class=\"col-sm-8\">\r\n                                        <input type=\"text\" name=\"name\" id=\"name\" class=\"form-control\" aria-describedby=\"helpBlock\" value=\"" . $thisBoss["name"] . "\">\r\n                                        <span id=\"idHelp\" class=\"help-block\">Enter boss name, for example Kundun.</span>\r\n                                    </div>\r\n                                </div>\r\n                                <div class=\"form-group\">\r\n                                    <label class=\"col-sm-4 control-label\" for=\"monsterId\">Monster ID:</label>\r\n                                    <div class=\"col-sm-8\">\r\n                                        <input type=\"text\" name=\"monsterId\" id=\"monsterId\" class=\"form-control\" aria-describedby=\"helpBlock\" value=\"" . $thisBoss["monsterId"] . "\">\r\n                                        <span id=\"idHelp\" class=\"help-block\">Enter monster ID from server files configuration - for example \"275\" for Kundun.</span>\r\n                                    </div>\r\n                                </div>\r\n                                <div class=\"form-group\">\r\n                                    <label class=\"col-sm-4 control-label\" for=\"respawn\">Respawn:</label>\r\n                                    <div class=\"col-sm-8\">\r\n                                        <input type=\"text\" name=\"respawn\" id=\"respawn\" class=\"form-control\" aria-describedby=\"helpBlock\" value=\"" . $thisBoss["respawn"] . "\">\r\n                                        <span id=\"idHelp\" class=\"help-block\">Enter boss respawn in seconds.</span>\r\n                                    </div>\r\n                                </div>\r\n                                <div class=\"form-group\">\r\n                                    <label class=\"col-sm-4 control-label\" for=\"order\">Order:</label>\r\n                                    <div class=\"col-sm-8\">\r\n                                        <input type=\"text\" name=\"order\" id=\"order\" class=\"form-control\" aria-describedby=\"helpBlock\" value=\"" . $thisBoss["order"] . "\">\r\n                                        <span id=\"idHelp\" class=\"help-block\">Enter number what will be used to sort bosses.</span>\r\n                                    </div>\r\n                                </div>\r\n                            </div>\r\n                        </div>\r\n                        <div class=\"modal-footer\">\r\n                            <button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>\r\n                            <input type=\"hidden\" name=\"id\" id=\"id\" class=\"form-control\" value=\"" . $thisBoss["id"] . "\">\r\n                            <input type=\"submit\" name=\"edit_boss\" class=\"btn btn-success\" value=\"Save\"/>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n            </div>\r\n        </form>";
    }
}
echo "</table>";
echo $editModals;
echo "\r\n<hr><h3>Add New Boss</h3>\r\n<form action=\"";
echo admincp_base("modules_manager&config=bosstimer");
echo "\" method=\"post\">\r\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n        <tr>\r\n            <th>Boss Name<br/><span>Enter boss name, for example Kundun.</span>\r\n            </th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"name\" value=\"\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Monster ID<br/><span>Enter monster ID from server files configuration - for example \"275\" for Kundun.</span>\r\n            </th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"monsterId\" value=\"\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Boss Respawn<br/><span>Enter boss respawn in seconds.</span>\r\n            </th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"respawn\" value=\"\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Order<br/><span>Enter number what will be used to sort bosses.</span>\r\n            </th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"order\" value=\"\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan=\"2\"><input type=\"submit\" name=\"add_boss\" value=\"Add Boss\" class=\"btn btn-success\" style=\"width: 100%;\"/></td>\r\n        </tr>\r\n    </table>\r\n</form>\r\n";
function saveChanges()
{
    
    foreach ($_POST as $setting) {
        if (!check_value($setting)) {
            message("error", "Missing data (complete all fields).");
            return NULL;
        }
    }
    $xmlPath = __PATH_MODULE_CONFIGS__ . "bosstimer.xml";
    $xml = simplexml_load_file($xmlPath);
    $xml->active = $_POST["active"];
    $xml->display_seconds = $_POST["display_seconds"];
    $xml->show_killer = $_POST["show_killer"];
    $xml->show_date = $_POST["show_date"];
    $save = $xml->asXML($xmlPath);
    if ($save) {
        message("success", "Settings successfully saved.");
    } else {
        message("error", "There has been an error while saving changes.");
    }
}

?>