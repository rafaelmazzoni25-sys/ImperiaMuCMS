<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

if (check_value($_POST["add_event"])) {
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
            $insert = $dB->query("INSERT INTO IMPERIAMUCMS_EVENT_REGISTRATION (title, req_class, req_lvl, req_mlvl, start_date, end_date, price, price_type, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)", [$_POST["title"], $class, $_POST["req_lvl"], $_POST["req_mlvl"], $_POST["start"], $_POST["end"], $_POST["price"], $_POST["price_type"], 1]);
            if ($insert) {
                message("success", "Event was created successfully.");
            } else {
                message("error", "Unexpected error occurred.");
            }
        }
    } else {
        message("error", "Please fill all fields.");
    }
}
$customStr = "";
$customItems = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_WEB_BANK_CUSTOM");
foreach ($customItems as $thisItem) {
    $customStr .= "<option value=\"" . $thisItem["ident"] . "\">" . $thisItem["name"] . "</option>";
}
echo "<h1 class=\"page-header\">Add New Event</h1>\r\n<form role=\"form\" method=\"post\">\r\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n        <tr>\r\n            <th>Name<br/><span>Select event's name.</span></th>\r\n            <td><input class=\"form-control\" type=\"text\" name=\"title\" value=\"\" placeholder=\"Event's Name\" maxlength=\"255\"/></td>\r\n        </tr>\r\n        <tr>\r\n            <th>Start Date<br/><span>Format: <b>YYYY-MM-DD HH:MM:SS</b></span></th>\r\n            <td><input class=\"form-control\" type=\"text\" name=\"start\" value=\"\" placeholder=\"YYYY-MM-DD HH:MM:SS\"/></td>\r\n        </tr>\r\n        <tr>\r\n            <th>End Date<br/><span>Format: <b>YYYY-MM-DD HH:MM:SS</b></span></th>\r\n            <td><input class=\"form-control\" type=\"text\" name=\"end\" value=\"\" placeholder=\"YYYY-MM-DD HH:MM:SS\"/></td>\r\n        </tr>\r\n        <tr>\r\n            <th>Required Level<br/><span>Required level to register.</span>\r\n            </th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"req_lvl\" value=\"\" placeholder=\"0\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Required Master Level<br/><span>Required master level to register.</span>\r\n            </th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"req_mlvl\" value=\"\" placeholder=\"0\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Class Filter<br/><span>Check all classes for what will be this event available.</span></th>\r\n            <td>\r\n                <table width=\"100%\">\r\n                    ";
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
    echo "<td><input type=\"checkbox\" name=\"class" . $classCode . "\" value=\"" . $classCode . "\" checked=\"checked\"/> " . $thisClass[0] . "</td>";
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
echo "                </table>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Price<br/><span>Enter registration fee for the event. Use \"<b>0</b>\" if registration will be for free.</span></th>\r\n            <td><input class=\"form-control\" type=\"text\" name=\"price\" value=\"\" placeholder=\"0\"/></td>\r\n        </tr>\r\n        <tr>\r\n            <th>Price Type<br/><span>System supports all website and in-game currencies and all items from Web Bank module.</span></th>\r\n            <td>\r\n                <select name=\"price_type\" class=\"form-control\">\r\n                    <option value=\"1\">Platinum Coins</option>\r\n                    <option value=\"2\">Gold Coins</option>\r\n                    <option value=\"3\">Silver Coins</option>\r\n                    <option value=\"4\">WCoinC</option>\r\n                    <option value=\"-4\">WCoinP</option>\r\n                    <option value=\"5\">Goblin Points</option>\r\n                    <option value=\"6\">Zen</option>\r\n                    <option value=\"7\">Jewel of Bless</option>\r\n                    <option value=\"8\">Jewel of Soul</option>\r\n                    <option value=\"9\">Jewel of Life</option>\r\n                    <option value=\"10\">Jewel of Chaos</option>\r\n                    <option value=\"11\">Jewel of Harmony</option>\r\n                    <option value=\"12\">Jewel of Creation</option>\r\n                    <option value=\"13\">Jewel of Guardian</option>\r\n                    ";
echo $customStr;
echo "                </select>\r\n            </td>\r\n        </tr>\r\n    </table>\r\n    <button type=\"submit\" class=\"btn btn-large btn-block btn-success\" name=\"add_event\" value=\"ok\">Add Event</button>\r\n</form>";

?>