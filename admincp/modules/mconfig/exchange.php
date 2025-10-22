<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h2>Exchange Settings</h2>\r\n";
$Exchange = new Exchange();
if (check_value($_POST["submit_changes"])) {
    savechanges();
}
if (check_value($_POST["exchange_add_submit"])) {
    $Exchange->addExchange($_POST["exchange_from"], $_POST["exchange_to"], $_POST["exchange_from_amount"], $_POST["exchange_ratio"]);
}
if (check_value($_POST["exchange_edit_submit"])) {
    $Exchange->editExchange($_POST["id"], $_POST["exchange_from"], $_POST["exchange_to"], $_POST["exchange_from_amount"], $_POST["exchange_ratio"]);
}
if (check_value($_GET["switch"])) {
    $Exchange->switchStatusExchange($_GET["switch"]);
}
if (check_value($_GET["delete"])) {
    $Exchange->deleteExchange($_GET["delete"]);
}
loadModuleConfigs("usercp.exchange");
$creditSystem = new CreditSystem($common, new Character(), $dB, $dB2);
echo "    <form action=\"\" method=\"post\">\r\n        <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n            <tr>\r\n                <th>Status<br/><span>Enable/disable the exchange module.</span></th>\r\n                <td>\r\n                    ";
enabledisableCheckboxes("setting_1", mconfig("active"), "Enabled", "Disabled");
echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <td colspan=\"2\"><input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\" class=\"btn btn-success\"/>\r\n                </td>\r\n            </tr>\r\n        </table>\r\n    </form>\r\n\r\n    <hr>\r\n    <h3>Manage Exchanges</h3>\r\n";
$custom = "";
$customItems = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_WEB_BANK_CUSTOM");
foreach ($customItems as $thisItem) {
    $custom .= "<option value=\"" . $thisItem["ident"] . "\">" . $thisItem["name"] . "</option>";
}
echo "<table class=\"table table-striped table-bordered table-hover\"><tr><th>From</th><th>To</th><th>From Amount</th><th>Ratio</th><th></th></tr>";
$exchanges = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_EXCHANGE ORDER BY identFrom");
foreach ($exchanges as $thisExchange) {
    echo "<form action=\"index.php?module=modules_manager&config=exchange\" method=\"post\">";
    echo "<input type=\"hidden\" name=\"id\" value=\"" . $thisExchange["id"] . "\"/>";
    echo "<tr><td><select name=\"exchange_from\" class=\"form-control\">";
    if ($thisExchange["identFrom"] == "0") {
        echo "<option value=\"0\" selected=\"selected\">Online Time (Hours)</option>";
    } else {
        echo "<option value=\"0\">Online Time (Hours)</option>";
    }
    if ($thisExchange["identFrom"] == "1") {
        echo "<option value=\"1\" selected=\"selected\">Platinum Coins</option>";
    } else {
        echo "<option value=\"1\">Platinum Coins</option>";
    }
    if ($thisExchange["identFrom"] == "2") {
        echo "<option value=\"2\" selected=\"selected\">Gold Coins</option>";
    } else {
        echo "<option value=\"2\">Gold Coins</option>";
    }
    if ($thisExchange["identFrom"] == "3") {
        echo "<option value=\"3\" selected=\"selected\">Silver Coins</option>";
    } else {
        echo "<option value=\"3\">Silver Coins</option>";
    }
    if ($thisExchange["identFrom"] == "4") {
        echo "<option value=\"4\" selected=\"selected\">WCoinC</option>";
    } else {
        echo "<option value=\"4\">WCoinC</option>";
    }
    if ($thisExchange["identFrom"] == "-4") {
        echo "<option value=\"-4\" selected=\"selected\">WCoinP</option>";
    } else {
        echo "<option value=\"-4\">WCoinP</option>";
    }
    if ($thisExchange["identFrom"] == "5") {
        echo "<option value=\"5\" selected=\"selected\">GoblinPoint</option>";
    } else {
        echo "<option value=\"5\">GoblinPoint</option>";
    }
    if ($thisExchange["identFrom"] == "6") {
        echo "<option value=\"6\" selected=\"selected\">Zen</option>";
    } else {
        echo "<option value=\"6\">Zen</option>";
    }
    if (100 <= config("server_files_season", true)) {
        if ($thisExchange["identFrom"] == "-1") {
            echo "<option value=\"-1\" selected=\"selected\">Ruud</option>";
        } else {
            echo "<option value=\"-1\">Ruud</option>";
        }
    }
    if ($thisExchange["identFrom"] == "7") {
        echo "<option value=\"7\" selected=\"selected\">Jewel of Bless</option>";
    } else {
        echo "<option value=\"7\">Jewel of Bless</option>";
    }
    if ($thisExchange["identFrom"] == "8") {
        echo "<option value=\"8\" selected=\"selected\">Jewel of Soul</option>";
    } else {
        echo "<option value=\"8\">Jewel of Soul</option>";
    }
    if ($thisExchange["identFrom"] == "9") {
        echo "<option value=\"9\" selected=\"selected\">Jewel of Life</option>";
    } else {
        echo "<option value=\"9\">Jewel of Life</option>";
    }
    if ($thisExchange["identFrom"] == "10") {
        echo "<option value=\"10\" selected=\"selected\">Jewel of Chaos</option>";
    } else {
        echo "<option value=\"10\">Jewel of Chaos</option>";
    }
    if ($thisExchange["identFrom"] == "11") {
        echo "<option value=\"11\" selected=\"selected\">Jewel of Harmony</option>";
    } else {
        echo "<option value=\"11\">Jewel of Harmony</option>";
    }
    if ($thisExchange["identFrom"] == "12") {
        echo "<option value=\"12\" selected=\"selected\">Jewel of Creation</option>";
    } else {
        echo "<option value=\"12\">Jewel of Creation</option>";
    }
    if ($thisExchange["identFrom"] == "13") {
        echo "<option value=\"13\" selected=\"selected\">Jewel of Guardian</option>";
    } else {
        echo "<option value=\"13\">Jewel of Guardian</option>";
    }
    $customEditFrom = "";
    foreach ($customItems as $thisItem) {
        if ($thisExchange["identFrom"] == $thisItem["ident"]) {
            $customEditFrom .= "<option value=\"" . $thisItem["ident"] . "\" selected=\"selected\">" . $thisItem["name"] . "</option>";
        } else {
            $customEditFrom .= "<option value=\"" . $thisItem["ident"] . "\">" . $thisItem["name"] . "</option>";
        }
    }
    echo $customEditFrom;
    echo "</select></td><td><select name=\"exchange_to\" class=\"form-control\">";
    if ($thisExchange["identTo"] == "0") {
        echo "<option value=\"0\" selected=\"selected\">Online Time (Hours)</option>";
    } else {
        echo "<option value=\"0\">Online Time (Hours)</option>";
    }
    if ($thisExchange["identTo"] == "1") {
        echo "<option value=\"1\" selected=\"selected\">Platinum Coins</option>";
    } else {
        echo "<option value=\"1\">Platinum Coins</option>";
    }
    if ($thisExchange["identTo"] == "2") {
        echo "<option value=\"2\" selected=\"selected\">Gold Coins</option>";
    } else {
        echo "<option value=\"2\">Gold Coins</option>";
    }
    if ($thisExchange["identTo"] == "3") {
        echo "<option value=\"3\" selected=\"selected\">Silver Coins</option>";
    } else {
        echo "<option value=\"3\">Silver Coins</option>";
    }
    if ($thisExchange["identTo"] == "4") {
        echo "<option value=\"4\" selected=\"selected\">WCoinC</option>";
    } else {
        echo "<option value=\"4\">WCoinC</option>";
    }
    if ($thisExchange["identTo"] == "-4") {
        echo "<option value=\"-4\" selected=\"selected\">WCoinP</option>";
    } else {
        echo "<option value=\"-4\">WCoinP</option>";
    }
    if ($thisExchange["identTo"] == "5") {
        echo "<option value=\"5\" selected=\"selected\">GoblinPoint</option>";
    } else {
        echo "<option value=\"5\">GoblinPoint</option>";
    }
    if ($thisExchange["identTo"] == "6") {
        echo "<option value=\"6\" selected=\"selected\">Zen</option>";
    } else {
        echo "<option value=\"6\">Zen</option>";
    }
    if (100 <= config("server_files_season", true)) {
        if ($thisExchange["identTo"] == "-1") {
            echo "<option value=\"-1\" selected=\"selected\">Ruud</option>";
        } else {
            echo "<option value=\"-1\">Ruud</option>";
        }
    }
    if ($thisExchange["identTo"] == "7") {
        echo "<option value=\"7\" selected=\"selected\">Jewel of Bless</option>";
    } else {
        echo "<option value=\"7\">Jewel of Bless</option>";
    }
    if ($thisExchange["identTo"] == "8") {
        echo "<option value=\"8\" selected=\"selected\">Jewel of Soul</option>";
    } else {
        echo "<option value=\"8\">Jewel of Soul</option>";
    }
    if ($thisExchange["identTo"] == "9") {
        echo "<option value=\"9\" selected=\"selected\">Jewel of Life</option>";
    } else {
        echo "<option value=\"9\">Jewel of Life</option>";
    }
    if ($thisExchange["identTo"] == "10") {
        echo "<option value=\"10\" selected=\"selected\">Jewel of Chaos</option>";
    } else {
        echo "<option value=\"10\">Jewel of Chaos</option>";
    }
    if ($thisExchange["identTo"] == "11") {
        echo "<option value=\"11\" selected=\"selected\">Jewel of Harmony</option>";
    } else {
        echo "<option value=\"11\">Jewel of Harmony</option>";
    }
    if ($thisExchange["identTo"] == "12") {
        echo "<option value=\"12\" selected=\"selected\">Jewel of Creation</option>";
    } else {
        echo "<option value=\"12\">Jewel of Creation</option>";
    }
    if ($thisExchange["identTo"] == "13") {
        echo "<option value=\"13\" selected=\"selected\">Jewel of Guardian</option>";
    } else {
        echo "<option value=\"13\">Jewel of Guardian</option>";
    }
    $customEditTo = "";
    foreach ($customItems as $thisItem) {
        if ($thisExchange["identTo"] == $thisItem["ident"]) {
            $customEditTo .= "<option value=\"" . $thisItem["ident"] . "\" selected=\"selected\">" . $thisItem["name"] . "</option>";
        } else {
            $customEditTo .= "<option value=\"" . $thisItem["ident"] . "\">" . $thisItem["name"] . "</option>";
        }
    }
    echo $customEditTo;
    echo "</select></td>";
    echo "<td><input name=\"exchange_from_amount\" class=\"form-control\" type=\"text\" value=\"" . $thisExchange["fromAmount"] . "\" /></td>";
    echo "<td><input name=\"exchange_ratio\" class=\"form-control\" type=\"text\" value=\"" . $thisExchange["ratio"] . "\" /></td>";
    echo "<td>\r\n            <input type=\"submit\" class=\"btn btn-success\" name=\"exchange_edit_submit\" value=\"Save\"/> ";
    if ($thisExchange["active"]) {
        echo "<a href=\"index.php?module=modules_manager&config=exchange&switch=" . $thisExchange["id"] . "\" class=\"btn btn-danger\">Disable</a>";
    } else {
        echo "<a href=\"index.php?module=modules_manager&config=exchange&switch=" . $thisExchange["id"] . "\" class=\"btn btn-success\">Enable</a>";
    }
    echo "\r\n            <a href=\"index.php?module=modules_manager&config=exchange&delete=" . $thisExchange["id"] . "\" class=\"btn btn-danger\"><i class=\"fa fa-remove\"></i></a>\r\n          </td>";
    echo "</tr></form>";
}
echo "</table><table class=\"table table-striped table-bordered table-hover\"><tr><th>From</th><th>To</th><th>From Amount</th><th>Ratio</th><th></th></tr><form action=\"index.php?module=modules_manager&config=exchange\" method=\"post\"><tr><td>\r\n        <select name=\"exchange_from\" class=\"form-control\">\r\n            <option value=\"0\">Online Time (Hours)</option>\r\n            <option value=\"1\">Platinum Coins</option>\r\n            <option value=\"2\">Gold Coins</option>\r\n            <option value=\"3\">Silver Coins</option>\r\n            <option value=\"4\">WCoinC</option>\r\n            <option value=\"-4\">WCoinP</option>\r\n            <option value=\"5\">GoblinPoint</option>\r\n            <option value=\"6\">Zen</option>";
if (100 <= config("server_files_season", true)) {
    echo "<option value=\"-1\">Ruud</option>";
}
echo "\r\n            <option value=\"7\">Jewel of Bless</option>\r\n            <option value=\"8\">Jewel of Soul</option>\r\n            <option value=\"9\">Jewel of Life</option>\r\n            <option value=\"10\">Jewel of Chaos</option>\r\n            <option value=\"11\">Jewel of Harmony</option>\r\n            <option value=\"12\">Jewel of Creation</option>\r\n            <option value=\"13\">Jewel of Guardian</option>\r\n            " . $custom . "\r\n        </select>\r\n      </td>";
echo "<td>\r\n        <select name=\"exchange_to\" class=\"form-control\">\r\n            <option value=\"0\">Online Time (Hours)</option>\r\n            <option value=\"1\">Platinum Coins</option>\r\n            <option value=\"2\">Gold Coins</option>\r\n            <option value=\"3\">Silver Coins</option>\r\n            <option value=\"4\">WCoinC</option>\r\n            <option value=\"-4\">WCoinP</option>\r\n            <option value=\"5\">GoblinPoint</option>\r\n            <option value=\"6\">Zen</option>";
if (100 <= config("server_files_season", true)) {
    echo "<option value=\"-1\">Ruud</option>";
}
echo "\r\n            <option value=\"7\">Jewel of Bless</option>\r\n            <option value=\"8\">Jewel of Soul</option>\r\n            <option value=\"9\">Jewel of Life</option>\r\n            <option value=\"10\">Jewel of Chaos</option>\r\n            <option value=\"11\">Jewel of Harmony</option>\r\n            <option value=\"12\">Jewel of Creation</option>\r\n            <option value=\"13\">Jewel of Guardian</option>\r\n            " . $custom . "\r\n        </select>\r\n      </td>";
echo "<td><input name=\"exchange_from_amount\" class=\"form-control\" type=\"text\" value=\"1\" /></td><td><input name=\"exchange_ratio\" class=\"form-control\" type=\"text\" value=\"0\" /></td><td>\r\n        <input type=\"submit\" class=\"btn btn-success\" name=\"exchange_add_submit\" value=\"Add\"/>\r\n      </td></tr></form></table>";
function saveChanges()
{
    
    foreach ($_POST as $setting) {
        if (!check_value($setting)) {
            message("error", "Missing data (complete all fields).");
            return NULL;
        }
    }
    $xmlPath = __PATH_MODULE_CONFIGS__ . "usercp.exchange.xml";
    $xml = simplexml_load_file($xmlPath);
    $xml->active = $_POST["setting_1"];
    $save = $xml->asXML($xmlPath);
    if ($save) {
        message("success", "Settings successfully saved.");
    } else {
        message("error", "There has been an error while saving changes.");
    }
}

?>