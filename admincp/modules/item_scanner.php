<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h1 class=\"page-header\">Item Scanner</h1>\r\n";
message("info", "Please be advised, that scanning can take couple minutes. Please do not refresh page during operation. It's highly recommended to change <b>max_execution_time</b> PHP setting to at least <b>300</b> (5 minutes). Serial must be entered in hexadecimal format.");
echo "    <table width=\"100%\">\r\n        <tr>\r\n            <td width=\"50%\">\r\n                <form class=\"form-inline\" role=\"form\" method=\"post\">\r\n                    <div class=\"form-group\">\r\n                        Search by Serial: <input type=\"text\" class=\"form-control\" id=\"input_1\" name=\"serial\" placeholder=\"Item Serial\"/>\r\n                    </div>\r\n                    <button type=\"submit\" class=\"btn btn-primary\" name=\"scan_serial\" value=\"ok\">Scan</button>\r\n                    <p><i>Enter item's serial in hexadecimal format.</i></p>\r\n                </form>\r\n            </td>\r\n            <td width=\"50%\">\r\n                <form class=\"form-inline\" role=\"form\" method=\"post\">\r\n                    <div class=\"form-group\">\r\n                        Search by Item Code: <input type=\"text\" class=\"form-control\" id=\"input_1\" name=\"code\" placeholder=\"Item Code\"/>\r\n                    </div>\r\n                    <button type=\"submit\" class=\"btn btn-primary\" name=\"scan_code\" value=\"ok\">Scan</button>\r\n                    <p><i>Enter item hexadecimal code. Serial during scan is ignored, so search is provided based on item's attributes only.</i></p>\r\n                </form>\r\n            </td>\r\n        </tr>\r\n    </table>\r\n    <br/>\r\n";
if (check_value($_POST["scan_serial"]) && check_value($_POST["serial"])) {
    $Market = new Market();
    $Items = new Items();
    $searchSerial = xss_clean($_POST["serial"]);
    while (strlen($searchSerial) < 16) {
        $searchSerial = "0" . $searchSerial;
    }
    $results = [];
    $resultsIndex = 0;
    $inventories = $dB->query_fetch("SELECT AccountID, Name, CONVERT(VARCHAR(MAX), Inventory, 2) AS Inventory FROM Character");
    foreach ($inventories as $thisInv) {
        if ($thisInv["Inventory"] != NULL && $thisInv["Inventory"] != "") {
            if (substr($thisInv["Inventory"], 0, 2) == "0x") {
                $thisInv["Inventory"] = substr($thisInv["Inventory"], 2);
            }
            $i = 0;
            if (132 <= config("server_files_season", true)) {
                $whileLoop = 239;
            } else {
                $whileLoop = 237;
            }
            while ($i < $whileLoop) {
                $_item = substr($thisInv["Inventory"], __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                if ($_item != __ITEM_EMPTY__) {
                    $item = $Items->ItemInfo($_item);
                    $serial1 = $item["sn"];
                    $serial2 = $item["sn2"];
                    $serial = $serial2 . $serial1;
                    if ($searchSerial == $serial) {
                        $results[$resultsIndex]["AccountID"] = $thisInv["AccountID"];
                        $results[$resultsIndex]["Name"] = $thisInv["Name"];
                        $results[$resultsIndex]["Type"] = "Inventory";
                        $resultsIndex++;
                    }
                }
                $i++;
            }
        }
    }
    $vaults = $dB->query_fetch("SELECT AccountID, CONVERT(VARCHAR(MAX), Items, 2) AS Items FROM warehouse");
    foreach ($vaults as $thisVault) {
        if ($thisVault["Items"] != NULL && $thisVault["Items"] != "") {
            if (substr($thisVault["Items"], 0, 2) == "0x") {
                $thisVault["Items"] = substr($thisVault["Items"], 2);
            }
            $i = 0;
            while ($i < 240) {
                $_item = substr($thisVault["Items"], __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                if ($_item != __ITEM_EMPTY__) {
                    $item = $Items->ItemInfo($_item);
                    $serial1 = $item["sn"];
                    $serial2 = $item["sn2"];
                    $serial = $serial2 . $serial1;
                    if ($searchSerial == $serial) {
                        $results[$resultsIndex]["AccountID"] = $thisVault["AccountID"];
                        $results[$resultsIndex]["Name"] = "--";
                        $results[$resultsIndex]["Type"] = "Vault";
                        $resultsIndex++;
                    }
                }
                $i++;
            }
        }
    }
    echo "Showing results for serial \"<b>" . $searchSerial . "</b>\"";
    echo "<table id=\"item_scanner\" class=\"table display\"><thead><tr><th>AccountID</th><th>Name</th><th>Type</th></tr></thead><tbody>";
    foreach ($results as $row) {
        echo "\r\n        <tr>\r\n            <td>" . $row["AccountID"] . "</td>\r\n            <td>" . $row["Name"] . "</td>\r\n            <td>" . $row["Type"] . "</td>\r\n        </tr>";
    }
    echo "</tbody></table>";
} else {
    if (check_value($_POST["scan_code"]) && check_value($_POST["code"])) {
        $Market = new Market();
        $searchCode = xss_clean($_POST["code"]);
        if (strlen($searchCode) != __ITEM_LENGTH__) {
            message("error", "Item code must consists of " . __ITEM_LENGTH__ . " characters.");
        } else {
            $searchCode = substr_replace($searchCode, "00000000", 6, 8);
            $searchCode = substr_replace($searchCode, "00000000", 32, 8);
            $results = [];
            $resultsIndex = 0;
            $inventories = $dB->query_fetch("SELECT AccountID, Name, CONVERT(VARCHAR(MAX), Inventory, 2) AS Inventory FROM Character");
            foreach ($inventories as $thisInv) {
                if ($thisInv["Inventory"] != NULL && $thisInv["Inventory"] != "") {
                    if (substr($thisInv["Inventory"], 0, 2) == "0x") {
                        $thisInv["Inventory"] = substr($thisInv["Inventory"], 2);
                    }
                    $i = 0;
                    if (132 <= config("server_files_season", true)) {
                        $whileLoop = 239;
                    } else {
                        $whileLoop = 237;
                    }
                    while ($i < $whileLoop) {
                        $_item = substr($thisInv["Inventory"], __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                        if ($_item != __ITEM_EMPTY__) {
                            $_item = substr_replace($_item, "00000000", 6, 8);
                            $_item = substr_replace($_item, "00000000", 32, 8);
                            if ($searchCode == $_item) {
                                $results[$resultsIndex]["AccountID"] = $thisInv["AccountID"];
                                $results[$resultsIndex]["Name"] = $thisInv["Name"];
                                $results[$resultsIndex]["Type"] = "Inventory";
                                $resultsIndex++;
                            }
                        }
                        $i++;
                    }
                }
            }
            $vaults = $dB->query_fetch("SELECT AccountID, CONVERT(VARCHAR(MAX), Items, 2) AS Items FROM warehouse");
            foreach ($vaults as $thisVault) {
                if ($thisVault["Items"] != NULL && $thisVault["Items"] != "") {
                    if (substr($thisVault["Items"], 0, 2) == "0x") {
                        $thisVault["Items"] = substr($thisVault["Items"], 2);
                    }
                    $i = 0;
                    while ($i < 240) {
                        $_item = substr($thisVault["Items"], __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                        if ($_item != __ITEM_EMPTY__) {
                            $_item = substr_replace($_item, "00000000", 6, 8);
                            $_item = substr_replace($_item, "00000000", 32, 8);
                            if ($searchCode == $_item) {
                                $results[$resultsIndex]["AccountID"] = $thisVault["AccountID"];
                                $results[$resultsIndex]["Name"] = "--";
                                $results[$resultsIndex]["Type"] = "Vault";
                                $resultsIndex++;
                            }
                        }
                        $i++;
                    }
                }
            }
            echo "Showing results for code \"<b>" . $searchCode . "</b>\"";
            echo "<table id=\"item_scanner\" class=\"table display\"><thead><tr><th>AccountID</th><th>Name</th><th>Type</th></tr></thead><tbody>";
            foreach ($results as $row) {
                echo "\r\n        <tr>\r\n            <td>" . $row["AccountID"] . "</td>\r\n            <td>" . $row["Name"] . "</td>\r\n            <td>" . $row["Type"] . "</td>\r\n        </tr>";
            }
            echo "</tbody></table>";
        }
    }
}

?>