<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h2>Events Timer Settings</h2>\r\n";
if (check_value($_POST["submit_changes"])) {
    savechanges();
}
$cronFile = "../cron/events_timer.php";
if (check_value($_POST["add_event"])) {
    if (check_value($_POST["name"]) && check_value($_POST["type"]) && check_value($_POST["times"]) && check_value($_POST["order"])) {
        if (is_numeric($_POST["order"])) {
            if ($_POST["monday"] == "on") {
                $_POST["monday"] = "1";
            } else {
                $_POST["monday"] = "0";
            }
            if ($_POST["tuesday"] == "on") {
                $_POST["tuesday"] = "1";
            } else {
                $_POST["tuesday"] = "0";
            }
            if ($_POST["wednesday"] == "on") {
                $_POST["wednesday"] = "1";
            } else {
                $_POST["wednesday"] = "0";
            }
            if ($_POST["thursday"] == "on") {
                $_POST["thursday"] = "1";
            } else {
                $_POST["thursday"] = "0";
            }
            if ($_POST["friday"] == "on") {
                $_POST["friday"] = "1";
            } else {
                $_POST["friday"] = "0";
            }
            if ($_POST["saturday"] == "on") {
                $_POST["saturday"] = "1";
            } else {
                $_POST["saturday"] = "0";
            }
            if ($_POST["sunday"] == "on") {
                $_POST["sunday"] = "1";
            } else {
                $_POST["sunday"] = "0";
            }
            $insert = $dB->query("INSERT INTO IMPERIAMUCMS_EVENTS_TIMER ([name], [times], [type], [time], [order], [active], [monday], [tuesday], [wednesday], [thursday], [friday], [saturday], [sunday]) \r\n              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$_POST["name"], $_POST["times"], $_POST["type"], $_POST["time"], $_POST["order"], 1, $_POST["monday"], $_POST["tuesday"], $_POST["wednesday"], $_POST["thursday"], $_POST["friday"], $_POST["saturday"], $_POST["sunday"]]);
            if ($insert) {
                include $cronFile;
                message("success", "New event has been successfully added into Events Timer.");
            } else {
                message("error", "Could not insert event into database.");
            }
        } else {
            message("error", "Order must be a number.");
        }
    } else {
        message("error", "Please fill all fields.");
    }
}
if (check_value($_POST["edit_event"])) {
    if (check_value($_POST["id"]) && check_value($_POST["name"]) && check_value($_POST["type"]) && check_value($_POST["times"]) && check_value($_POST["order"])) {
        if (is_numeric($_POST["id"]) && is_numeric($_POST["order"])) {
            if ($_POST["monday"] == "on") {
                $_POST["monday"] = "1";
            } else {
                $_POST["monday"] = "0";
            }
            if ($_POST["tuesday"] == "on") {
                $_POST["tuesday"] = "1";
            } else {
                $_POST["tuesday"] = "0";
            }
            if ($_POST["wednesday"] == "on") {
                $_POST["wednesday"] = "1";
            } else {
                $_POST["wednesday"] = "0";
            }
            if ($_POST["thursday"] == "on") {
                $_POST["thursday"] = "1";
            } else {
                $_POST["thursday"] = "0";
            }
            if ($_POST["friday"] == "on") {
                $_POST["friday"] = "1";
            } else {
                $_POST["friday"] = "0";
            }
            if ($_POST["saturday"] == "on") {
                $_POST["saturday"] = "1";
            } else {
                $_POST["saturday"] = "0";
            }
            if ($_POST["sunday"] == "on") {
                $_POST["sunday"] = "1";
            } else {
                $_POST["sunday"] = "0";
            }
            $update = $dB->query("UPDATE IMPERIAMUCMS_EVENTS_TIMER SET [name] = ?, [times] = ?, [type] = ?, [time] = ?, [order] = ?, [monday] = ?, [tuesday] = ?, [wednesday] = ?, [thursday] = ?, [friday] = ?, [saturday] = ?, [sunday] = ? \r\n              WHERE [id] = ?", [$_POST["name"], $_POST["times"], $_POST["type"], $_POST["time"], $_POST["order"], $_POST["monday"], $_POST["tuesday"], $_POST["wednesday"], $_POST["thursday"], $_POST["friday"], $_POST["saturday"], $_POST["sunday"], $_POST["id"]]);
            if ($update) {
                include $cronFile;
                message("success", "Event #" . $_POST["id"] . " has been successfully saved.");
            } else {
                message("error", "Could not update Event #" . $_POST["id"] . ".");
            }
        } else {
            message("error", "Invalid value in ID/Order.");
        }
    } else {
        message("error", "Please fill all fields.");
    }
}
if (check_value($_GET["delete"]) && is_numeric($_GET["delete"])) {
    $delete = $dB->query("DELETE FROM IMPERIAMUCMS_EVENTS_TIMER WHERE id = ?", [$_GET["delete"]]);
    if ($delete) {
        include $cronFile;
        message("success", "Event #" . $_GET["delete"] . " was deleted successfully.");
    } else {
        message("error", "Could not delete Event #" . $_GET["delete"] . ".");
    }
}
if (check_value($_GET["enable"]) && is_numeric($_GET["enable"])) {
    $update = $dB->query("UPDATE IMPERIAMUCMS_EVENTS_TIMER SET active = ? WHERE id = ?", [1, $_GET["enable"]]);
    if ($update) {
        include $cronFile;
        message("success", "Event #" . $_GET["enable"] . " was enabled successfully.");
    } else {
        message("error", "Could not update Event #" . $_GET["enable"] . ".");
    }
}
if (check_value($_GET["disable"]) && is_numeric($_GET["disable"])) {
    $update = $dB->query("UPDATE IMPERIAMUCMS_EVENTS_TIMER SET active = ? WHERE id = ?", [0, $_GET["disable"]]);
    if ($update) {
        include $cronFile;
        message("success", "Event #" . $_GET["disable"] . " was disabled successfully.");
    } else {
        message("error", "Could not update Event #" . $_GET["disable"] . ".");
    }
}
loadModuleConfigs("eventstimer");
echo "<form action=\"";
echo admincp_base("modules_manager&config=eventstimer");
echo "\" method=\"post\">\r\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n        <tr>\r\n            <th>Status<br/><span>Enable/disable events timer widget.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("active", mconfig("active"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Display Seconds<br/><span>Enable/disable seconds in events timer.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("display_seconds", mconfig("display_seconds"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan=\"2\"><input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\" class=\"btn btn-success\"/></td>\r\n        </tr>\r\n    </table>\r\n</form>\r\n\r\n<hr><h3>Manage Events</h3>";
$events = $dB->query_fetch("SELECT * FROM [dbo].[IMPERIAMUCMS_EVENTS_TIMER] ORDER BY [order] ASC");
$editModals = "";
echo "<table class=\"table table-striped table-bordered table-hover\"><tr><th>Order</th><th>Name</th><th>Times</th><th>Action</th></tr>";
if (is_array($events)) {
    foreach ($events as $thisEvent) {
        echo "\r\n    <tr>\r\n        <td>" . $thisEvent["order"] . "</td>\r\n        <td>" . $thisEvent["name"] . "</td>\r\n        <td>" . $thisEvent["times"] . "</td>\r\n        <td>\r\n            <button type=\"button\" class=\"btn btn-default btn-sm\" data-toggle=\"modal\" data-target=\"#event" . intval($thisEvent["id"]) . "\"><i class=\"fa fa-edit\"></i> Edit</button>";
        if ($thisEvent["active"] == "1") {
            echo " <a href=\"index.php?module=modules_manager&config=eventstimer&disable=" . intval($thisEvent["id"]) . "\" class=\"btn btn-danger btn-sm\" onclick=\"if(confirm('Do you really want to disable this event?')) return true; else return false;\">Disable</a> ";
        } else {
            echo " <a href=\"index.php?module=modules_manager&config=eventstimer&enable=" . intval($thisEvent["id"]) . "\" class=\"btn btn-success btn-sm\" onclick=\"if(confirm('Do you really want to enable this event?')) return true; else return false;\">Enable</a> ";
        }
        echo "\r\n            <a href=\"index.php?module=modules_manager&config=eventstimer&delete=" . intval($thisEvent["id"]) . "\" class=\"btn btn-danger btn-sm\" onclick=\"if(confirm('Do you really want to delete this event?')) return true; else return false;\"><i class=\"fa fa-remove\"></i> Delete</a>\r\n        </td>\r\n    </tr>";
        $editModals .= "\r\n        <form method=\"post\" action=\"" . admincp_base("modules_manager&config=eventstimer") . "\" class=\"form-horizontal\">\r\n            <div id=\"event" . intval($thisEvent["id"]) . "\" class=\"modal fade\" role=\"dialog\">\r\n                <div class=\"modal-dialog modal-lg\">\r\n                    <div class=\"modal-content\">\r\n                        <div class=\"modal-header\">\r\n                            <button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>\r\n                            <h4 class=\"modal-title\">Edit Event #" . intval($thisEvent["id"]) . "</h4>\r\n                        </div>\r\n                        <div class=\"modal-body\">\r\n                            <div style=\"min-height: 400px;\">\r\n                                <div class=\"form-group\">\r\n                                    <label class=\"col-sm-4 control-label\" for=\"id\">Name:</label>\r\n                                    <div class=\"col-sm-8\">\r\n                                        <input type=\"text\" name=\"name\" id=\"name\" class=\"form-control\" aria-describedby=\"helpBlock\" value=\"" . $thisEvent["name"] . "\">\r\n                                        <span id=\"idHelp\" class=\"help-block\">Enter event name, for example Blood Castle.</span>\r\n                                    </div>\r\n                                </div>\r\n                                <div class=\"form-group\">\r\n                                    <label class=\"col-sm-4 control-label\" for=\"times\">Times:</label>\r\n                                    <div class=\"col-sm-8\">\r\n                                        <input type=\"text\" name=\"times\" id=\"times\" class=\"form-control\" aria-describedby=\"helpBlock\" value=\"" . $thisEvent["times"] . "\">\r\n                                        <span id=\"idHelp\" class=\"help-block\">Enter event times in 24h format divided by comma without spaces. Times <b>MUST</b> be in chronological order.<br /><b>Example: </b>1:00,5:00,9:00,13:00,17:00,21:00</span>\r\n                                    </div>\r\n                                </div>\r\n                                <div class=\"form-group\">\r\n                                    <label class=\"col-sm-4 control-label\" for=\"type\">Type:</label>\r\n                                    <div class=\"col-sm-8\">\r\n                                        <select name=\"type\" id=\"type\" class=\"form-control\" aria-describedby=\"helpBlock\">";
        if ($thisEvent["type"] == "1") {
            $editModals .= "<option value=\"1\" selected=\"selected\">Open</option>";
        } else {
            $editModals .= "<option value=\"1\">Open</option>";
        }
        if ($thisEvent["type"] == "2") {
            $editModals .= "<option value=\"2\" selected=\"selected\">Start</option>";
        } else {
            $editModals .= "<option value=\"2\">Start</option>";
        }
        if ($thisEvent["type"] == "3") {
            $editModals .= "<option value=\"3\" selected=\"selected\">Appear</option>";
        } else {
            $editModals .= "<option value=\"3\">Appear</option>";
        }
        $day1checked = "";
        $day2checked = "";
        $day3checked = "";
        $day4checked = "";
        $day5checked = "";
        $day6checked = "";
        $day7checked = "";
        if ($thisEvent["monday"] == "1") {
            $day1checked = " checked=\"checked\"";
        }
        if ($thisEvent["tuesday"] == "1") {
            $day2checked = " checked=\"checked\"";
        }
        if ($thisEvent["wednesday"] == "1") {
            $day3checked = " checked=\"checked\"";
        }
        if ($thisEvent["thursday"] == "1") {
            $day4checked = " checked=\"checked\"";
        }
        if ($thisEvent["friday"] == "1") {
            $day5checked = " checked=\"checked\"";
        }
        if ($thisEvent["saturday"] == "1") {
            $day6checked = " checked=\"checked\"";
        }
        if ($thisEvent["sunday"] == "1") {
            $day7checked = " checked=\"checked\"";
        }
        $editModals .= "\r\n                                        </select>\r\n                                        <span id=\"idHelp\" class=\"help-block\"><b>Opening</b> - Event opens 5 minutes before start (Blood Castle like).<br /><b>Starting</b> - Event does not open and starts immediately (Golden Invasion like).</span>\r\n                                    </div>\r\n                                </div>\r\n                                <div class=\"form-group\">\r\n                                    <label class=\"col-sm-4 control-label\" for=\"time\">Time to Start/Appear:</label>\r\n                                    <div class=\"col-sm-8\">\r\n                                        <input type=\"text\" name=\"time\" id=\"time\" class=\"form-control\" aria-describedby=\"helpBlock\" value=\"" . $thisEvent["time"] . "\">\r\n                                        <span id=\"idHelp\" class=\"help-block\">Time in minutes. Example: 5 = 5 minutes before event starts text and color of event will be changed.</span>\r\n                                    </div>\r\n                                </div>\r\n                                <div class=\"form-group\">\r\n                                    <label class=\"col-sm-4 control-label\" for=\"order\">Order:</label>\r\n                                    <div class=\"col-sm-8\">\r\n                                        <input type=\"text\" name=\"order\" id=\"order\" class=\"form-control\" aria-describedby=\"helpBlock\" value=\"" . $thisEvent["order"] . "\">\r\n                                        <span id=\"idHelp\" class=\"help-block\">Enter number what will be used to sort events.</span>\r\n                                    </div>\r\n                                </div>\r\n                                <div class=\"form-group\">\r\n                                    <label class=\"col-sm-4 control-label\" for=\"order\">Days:</label>\r\n                                    <div class=\"col-sm-8\">\r\n                                        <input type=\"checkbox\" name=\"monday\"" . $day1checked . "/> Monday<br>\r\n                                        <input type=\"checkbox\" name=\"tuesday\"" . $day2checked . "/> Tuesday<br>\r\n                                        <input type=\"checkbox\" name=\"wednesday\"" . $day3checked . "/> Wednesday<br>\r\n                                        <input type=\"checkbox\" name=\"thursday\"" . $day4checked . "/> Thursday<br>\r\n                                        <input type=\"checkbox\" name=\"friday\"" . $day5checked . "/> Friday<br>\r\n                                        <input type=\"checkbox\" name=\"saturday\"" . $day6checked . "/> Saturday<br>\r\n                                        <input type=\"checkbox\" name=\"sunday\"" . $day7checked . "/> Sunday\r\n                                        <span id=\"idHelp\" class=\"help-block\">Check days when event is active.</span>\r\n                                    </div>\r\n                                </div>                                \r\n                            </div>\r\n                        </div>\r\n                        <div class=\"modal-footer\">\r\n                            <button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>\r\n                            <input type=\"hidden\" name=\"id\" id=\"id\" class=\"form-control\" value=\"" . $thisEvent["id"] . "\">\r\n                            <input type=\"submit\" name=\"edit_event\" class=\"btn btn-success\" value=\"Save\"/>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n            </div>\r\n        </form>";
    }
}
echo "</table>";
echo $editModals;
echo "\r\n<hr><h3>Add New Event</h3>\r\n<form action=\"";
echo admincp_base("modules_manager&config=eventstimer");
echo "\" method=\"post\">\r\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n        <tr>\r\n            <th>Event Name<br/><span>Enter event name, for example Blood Castle.</span>\r\n            </th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"name\" value=\"\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>\r\n                Times<br/><span>Enter event times in 24h format divided by comma without spaces. Times <b>MUST</b> be in chronological order.<br/><b>Example: </b>1:00,5:00,9:00,13:00,17:00,21:00</span>\r\n            </th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"times\" value=\"\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Event Type<br/><span>Open = Starts in / Opened, starts in<br>Start = Starts in / Hurry up, starts in<br>Appear = Appears in / Hurry up, appears in</span>\r\n            </th>\r\n            <td>\r\n                <select class=\"form-control\" name=\"type\">\r\n                    <option value=\"1\">Open</option>\r\n                    <option value=\"2\">Start</option>\r\n                    <option value=\"3\">Appear</option>\r\n                </select>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Time to Start/Appear<br/><span>Time in minutes. Example: 5 = 5 minutes before event starts text and color of event will be changed.</span>\r\n            </th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"time\" value=\"\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Order<br/><span>Enter number what will be used to sort events.</span>\r\n            </th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"order\" value=\"\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Days<br/><span>Check days when event is active.</span>\r\n            </th>\r\n            <td>\r\n                <input type=\"checkbox\" name=\"monday\" checked=\"checked\"/> Monday<br>\r\n                <input type=\"checkbox\" name=\"tuesday\" checked=\"checked\"/> Tuesday<br>\r\n                <input type=\"checkbox\" name=\"wednesday\" checked=\"checked\"/> Wednesday<br>\r\n                <input type=\"checkbox\" name=\"thursday\" checked=\"checked\"/> Thursday<br>\r\n                <input type=\"checkbox\" name=\"friday\" checked=\"checked\"/> Friday<br>\r\n                <input type=\"checkbox\" name=\"saturday\" checked=\"checked\"/> Saturday<br>\r\n                <input type=\"checkbox\" name=\"sunday\" checked=\"checked\"/> Sunday\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan=\"2\"><input type=\"submit\" name=\"add_event\" value=\"Add Event\" class=\"btn btn-success\" style=\"width: 100%;\"/></td>\r\n        </tr>\r\n    </table>\r\n</form>\r\n";
function saveChanges()
{
    
    foreach ($_POST as $setting) {
        if (!check_value($setting)) {
            message("error", "Missing data (complete all fields).");
            return NULL;
        }
    }
    $xmlPath = __PATH_MODULE_CONFIGS__ . "eventstimer.xml";
    $xml = simplexml_load_file($xmlPath);
    $xml->active = $_POST["active"];
    $xml->display_seconds = $_POST["display_seconds"];
    $save = $xml->asXML($xmlPath);
    if ($save) {
        message("success", "Settings successfully saved.");
    } else {
        message("error", "There has been an error while saving changes.");
    }
}

?>