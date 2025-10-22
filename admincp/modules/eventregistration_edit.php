<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

if (check_value($_GET["id"])) {
    $event_id = xss_clean($_GET["id"]);
    if (check_value($_POST["edit_event"])) {
        if (check_value($_POST["title"]) && check_value($_POST["start"]) && check_value($_POST["end"]) && check_value($_POST["req_lvl"]) && check_value($_POST["req_mlvl"]) && check_value($_POST["price"]) && check_value($_POST["price_type"])) {
            $error = false;
            if (255 < strlen($_POST["title"])) {
                message("error", "Event name can contains only 255 symbols.");
                $error = true;
            }
            if ($_POST["end"] < $_POST["start"]) {
                message("error", "Start date must be lower than end date.");
                $error = true;
            }
            if (!is_numeric($_POST["req_lvl"])) {
                message("error", "Required level must be a number.");
                $error = true;
            }
            if (!is_numeric($_POST["req_mlvl"])) {
                message("error", "Required master level must be a number.");
                $error = true;
            }
            if (!is_numeric($_POST["price"])) {
                message("error", "Price must be a number.");
                $error = true;
            }
            if (!is_numeric($_POST["price_type"])) {
                message("error", "Invalid price type.");
                $error = true;
            }
            if (!$error) {
                $classFilter = [];
                foreach ($custom["character_class"] as $classCode => $thisClass) {
                    if (isset($_POST["class" . $classCode])) {
                        $classFilter[$classCode] = $_POST["class" . $classCode];
                    }
                }
                $class = implode(",", $classFilter);
                $update = $dB->query("UPDATE IMPERIAMUCMS_EVENT_REGISTRATION SET title = ?, req_class = ?, req_lvl = ?, req_mlvl = ?, start_date = ?, end_date = ?, price = ?, price_type = ?, status = ? WHERE id = ?", [$_POST["title"], $class, $_POST["req_lvl"], $_POST["req_mlvl"], $_POST["start"], $_POST["end"], $_POST["price"], $_POST["price_type"], $_POST["status"], $event_id]);
                if ($update) {
                    message("success", "Event #" . $event_id . " was updated successfully.");
                } else {
                    message("error", "Unexpected error occurred.");
                }
            }
        } else {
            message("error", "Please fill all fields.");
        }
    }
    $event = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_EVENT_REGISTRATION WHERE id = ?", [$event_id]);
    if ($event["id"] != NULL) {
        $customStr = "";
        $customItems = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_WEB_BANK_CUSTOM");
        foreach ($customItems as $thisItem) {
            if ($event["price_type"] == $thisItem["ident"]) {
                $customStr .= "<option value=\"" . $thisItem["ident"] . "\" selected=\"selected\">" . $thisItem["name"] . "</option>";
            } else {
                $customStr .= "<option value=\"" . $thisItem["ident"] . "\">" . $thisItem["name"] . "</option>";
            }
        }
        $classFilter = explode(",", $event["req_class"]);
        echo "        <h1 class=\"page-header\">Edit Event #";
        echo $event_id;
        echo "</h1>\r\n        <form role=\"form\" method=\"post\">\r\n            <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n                <tr>\r\n                    <th>Status<br/><span>Enable/disable this event.</span></th>\r\n                    <td>\r\n                        ";
        enabledisableCheckboxes("status", $event["status"], "Enabled", "Disabled");
        echo "                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Name<br/><span>Select event's name.</span></th>\r\n                    <td><input class=\"form-control\" type=\"text\" name=\"title\" value=\"";
        echo $event["title"];
        echo "\" placeholder=\"Event's Name\" maxlength=\"255\"/></td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Start Date<br/><span>Format: <b>YYYY-MM-DD HH:MM:SS</b></span></th>\r\n                    <td><input class=\"form-control\" type=\"text\" name=\"start\" value=\"";
        echo $event["start_date"];
        echo "\" placeholder=\"YYYY-MM-DD HH:MM:SS\"/></td>\r\n                </tr>\r\n                <tr>\r\n                    <th>End Date<br/><span>Format: <b>YYYY-MM-DD HH:MM:SS</b></span></th>\r\n                    <td><input class=\"form-control\" type=\"text\" name=\"end\" value=\"";
        echo $event["end_date"];
        echo "\" placeholder=\"YYYY-MM-DD HH:MM:SS\"/></td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Required Level<br/><span>Required level to register.</span>\r\n                    </th>\r\n                    <td>\r\n                        <input class=\"form-control\" type=\"text\" name=\"req_lvl\" value=\"";
        echo $event["req_lvl"];
        echo "\" placeholder=\"0\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Required Master Level<br/><span>Required master level to register.</span>\r\n                    </th>\r\n                    <td>\r\n                        <input class=\"form-control\" type=\"text\" name=\"req_mlvl\" value=\"";
        echo $event["req_mlvl"];
        echo "\" placeholder=\"0\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Class Filter<br/><span>Check all classes for what will be this achievement available</span></th>\r\n                    <td>\r\n                        <table width=\"100%\">\r\n                            ";
        $itemsPerLine = 3;
        $currentLine = 0;
        $counter = 0;
        if (122 <= config("server_files_season", true)) {
            $itemsPerLine = 4;
        }
        foreach ($custom["character_class"] as $classCode => $thisClass) {
            if ($counter == 0) {
                echo "<tr>";
            }
            echo "<td><input type=\"checkbox\" name=\"class" . $classCode . "\" value=\"" . $classCode . "\" ";
            if (in_array($classCode, $classFilter)) {
                echo "checked=\"checked\"";
            }
            echo "/> " . $thisClass[0] . "</td>";
            if ($currentLine == 3 || $currentLine == 4 || $currentLine == 6 || $currentLine == 7) {
                if ($counter == $itemsPerLine - 2) {
                    echo "</tr>";
                    $counter = 0;
                    $currentLine++;
                }
            } else {
                if ($counter == $itemsPerLine - 1) {
                    echo "</tr>";
                    $counter = 0;
                    $currentLine++;
                }
            }
            $counter++;
        }
        echo "                        </table>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Price<br/><span>Enter registration fee for the event. Use \"<b>0</b>\" if registration will be for free.</span></th>\r\n                    <td><input class=\"form-control\" type=\"text\" name=\"price\" value=\"";
        echo $event["price"];
        echo "\" placeholder=\"0\"/></td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Price Type<br/><span>System supports all website and in-game currencies and all items from Web Bank module.</span></th>\r\n                    <td>\r\n                        <select name=\"price_type\" class=\"form-control\">\r\n                            ";
        if ($event["price_type"] == "1") {
            echo "<option value=\"1\" selected=\"selected\">Platinum Coins</option>";
        } else {
            echo "<option value=\"1\">Platinum Coins</option>";
        }
        if ($event["price_type"] == "2") {
            echo "<option value=\"2\" selected=\"selected\">Gold Coins</option>";
        } else {
            echo "<option value=\"2\">Gold Coins</option>";
        }
        if ($event["price_type"] == "3") {
            echo "<option value=\"3\" selected=\"selected\">Silver Coins</option>";
        } else {
            echo "<option value=\"3\">Silver Coins</option>";
        }
        if ($event["price_type"] == "4") {
            echo "<option value=\"4\" selected=\"selected\">WCoinC</option>";
        } else {
            echo "<option value=\"4\">WCoinC</option>";
        }
        if ($event["price_type"] == "-4") {
            echo "<option value=\"-4\" selected=\"selected\">WCoinP</option>";
        } else {
            echo "<option value=\"-4\">WCoinP</option>";
        }
        if ($event["price_type"] == "5") {
            echo "<option value=\"5\" selected=\"selected\">Goblin Points</option>";
        } else {
            echo "<option value=\"5\">Goblin Points</option>";
        }
        if ($event["price_type"] == "6") {
            echo "<option value=\"6\" selected=\"selected\">Zen</option>";
        } else {
            echo "<option value=\"6\">Zen</option>";
        }
        if ($event["price_type"] == "7") {
            echo "<option value=\"7\" selected=\"selected\">Jewel of Bless</option>";
        } else {
            echo "<option value=\"7\">Jewel of Bless</option>";
        }
        if ($event["price_type"] == "8") {
            echo "<option value=\"8\" selected=\"selected\">Jewel of Soul</option>";
        } else {
            echo "<option value=\"8\">Jewel of Soul</option>";
        }
        if ($event["price_type"] == "9") {
            echo "<option value=\"9\" selected=\"selected\">Jewel of Life</option>";
        } else {
            echo "<option value=\"9\">Jewel of Life</option>";
        }
        if ($event["price_type"] == "10") {
            echo "<option value=\"10\" selected=\"selected\">Jewel of Chaos</option>";
        } else {
            echo "<option value=\"10\">Jewel of Chaos</option>";
        }
        if ($event["price_type"] == "11") {
            echo "<option value=\"11\" selected=\"selected\">Jewel of Harmony</option>";
        } else {
            echo "<option value=\"11\">Jewel of Harmony</option>";
        }
        if ($event["price_type"] == "12") {
            echo "<option value=\"12\" selected=\"selected\">Jewel of Creation</option>";
        } else {
            echo "<option value=\"12\">Jewel of Creation</option>";
        }
        if ($event["price_type"] == "13") {
            echo "<option value=\"13\" selected=\"selected\">Jewel of Guardian</option>";
        } else {
            echo "<option value=\"13\">Jewel of Guardian</option>";
        }
        echo "                            ";
        echo $customStr;
        echo "                        </select>\r\n                    </td>\r\n                </tr>\r\n            </table>\r\n            <button type=\"submit\" class=\"btn btn-large btn-block btn-success\" name=\"edit_event\" value=\"ok\">Edit Event</button>\r\n        </form>\r\n\r\n        ";
    } else {
        message("error", "Invalid ID.");
    }
} else {
    message("error", "Invalid ID.");
}

?>