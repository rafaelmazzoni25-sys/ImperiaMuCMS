<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h2>VIP Settings</h2>\r\n";
$Vip = new Vip();
if (check_value($_POST["submit_changes"])) {
    savechanges();
}
if (check_value($_POST["package_add_submit"])) {
    $Vip->addPackage($_POST["name"], $_POST["type"], $_POST["currency"], $_POST["price"], $_POST["length"], $_POST["length_type"]);
}
if (check_value($_POST["package_edit_submit"])) {
    $Vip->editPackage($_POST["id"], $_POST["name"], $_POST["type"], $_POST["currency"], $_POST["price"], $_POST["length"], $_POST["length_type"]);
}
if (check_value($_REQUEST["deleteplan"])) {
    $Vip->deletePackage($_REQUEST["deleteplan"]);
}
if (check_value($_POST["category_edit_submit"])) {
    $Vip->editCategory($_POST["id"], $_POST["name"], $_POST["position"], $_POST["currency"]);
}
loadModuleConfigs("usercp.vip");
message("", "Make sure that you configurated server side VIP settings properly!", "IMPORTANT:");
echo "    <form action=\"index.php?module=modules_manager&config=vip\" method=\"post\">\r\n        <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n            <tr>\r\n                <th>Status<br/><span>Enable/disable the vip module.</span></th>\r\n                <td>\r\n                    ";
enabledisableCheckboxes("setting_1", mconfig("active"), "Enabled", "Disabled");
echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Show VIP Status in UserCP<br/><span>Show/hide VIP status in UserCP.</span></th>\r\n                <td>\r\n                    ";
enabledisableCheckboxes("show_in_usercp", mconfig("show_in_usercp"), "Enabled", "Disabled");
echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <th rowspan=\"2\">Bronze VIP Bonus<br/><span>Use 0 in both configs if you want to disable this type of VIP in UserCP module.</span>\r\n                </th>\r\n                <td>\r\n                    Exp: <input class=\"form-control\" type=\"text\" name=\"setting_2\" value=\"";
echo mconfig("bronze_exp");
echo "\" style=\"display: inline; width: 150px\"/>%\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td>\r\n                    Drop: <input class=\"form-control\" type=\"text\" name=\"setting_3\" value=\"";
echo mconfig("bronze_drop");
echo "\" style=\"display: inline; width: 150px\"/>%\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th rowspan=\"2\">Silver VIP Bonus<br/><span>Use 0 in both configs if you want to disable this type of VIP in UserCP module.</span>\r\n                </th>\r\n                <td>\r\n                    Exp: <input class=\"form-control\" type=\"text\" name=\"setting_4\" value=\"";
echo mconfig("silver_exp");
echo "\" style=\"display: inline; width: 150px\"/>%\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td>\r\n                    Drop: <input class=\"form-control\" type=\"text\" name=\"setting_5\" value=\"";
echo mconfig("silver_drop");
echo "\" style=\"display: inline; width: 150px\"/>%\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th rowspan=\"2\">Gold VIP Bonus<br/><span>Use 0 in both configs if you want to disable this type of VIP in UserCP module.</span>\r\n                </th>\r\n                <td>\r\n                    Exp: <input class=\"form-control\" type=\"text\" name=\"setting_6\" value=\"";
echo mconfig("gold_exp");
echo "\" style=\"display: inline; width: 150px\"/>%\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td>\r\n                    Drop: <input class=\"form-control\" type=\"text\" name=\"setting_7\" value=\"";
echo mconfig("gold_drop");
echo "\" style=\"display: inline; width: 150px\"/>%\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th rowspan=\"2\">Platinum VIP Bonus<br/><span>Use 0 in both configs if you want to disable this type of VIP in UserCP module.</span>\r\n                </th>\r\n                <td>\r\n                    Exp: <input class=\"form-control\" type=\"text\" name=\"setting_8\" value=\"";
echo mconfig("platinum_exp");
echo "\" style=\"display: inline; width: 150px\"/>%\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td>\r\n                    Drop: <input class=\"form-control\" type=\"text\" name=\"setting_9\" value=\"";
echo mconfig("platinum_drop");
echo "\" style=\"display: inline; width: 150px\"/>%\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td colspan=\"2\"><input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\" class=\"btn btn-success\"/></td>\r\n            </tr>\r\n        </table>\r\n    </form>\r\n\r\n    <hr>\r\n    <h3>Manage VIP Packages</h3>\r\n<table class=\"table table-striped table-bordered table-hover\"><tr><th>Package Title</th><th>Type</th><th>Price</th><th>Length</th><th></th></tr>";
$vipPackages = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_VIP ORDER BY currency desc, type asc, price asc");
foreach ($vipPackages as $thisVip) {
    echo "<form action=\"index.php?module=modules_manager&config=vip\" method=\"post\">";
    echo "<input type=\"hidden\" name=\"id\" value=\"" . $thisVip["id"] . "\"/>";
    echo "<tr>";
    echo "<td><input name=\"name\" class=\"form-control\" type=\"text\" value=\"" . $thisVip["name"] . "\"/></td>";
    echo "<td>\r\n            <select name=\"type\" class=\"form-control\">";
    if ($thisVip["type"] == "1") {
        echo "<option value=\"1\"selected>Bronze</option>";
    } else {
        echo "<option value=\"1\">Bronze</option>";
    }
    if ($thisVip["type"] == "2") {
        echo "<option value=\"2\"selected>Silver</option>";
    } else {
        echo "<option value=\"2\">Silver</option>";
    }
    if ($thisVip["type"] == "3") {
        echo "<option value=\"3\"selected>Gold</option>";
    } else {
        echo "<option value=\"3\">Gold</option>";
    }
    if ($thisVip["type"] == "4") {
        echo "<option value=\"4\"selected>Platinum</option>";
    } else {
        echo "<option value=\"4\">Platinum</option>";
    }
    echo "\r\n            </select>\r\n          </td>";
    echo "<td>\r\n            <input name=\"price\" class=\"form-control\" type=\"text\" value=\"" . $thisVip["price"] . "\" style=\"display: inline; width: 49%\"/>\r\n            <select name=\"currency\" class=\"form-control\" style=\"display: inline; width: 49%\">";
    if ($thisVip["currency"] == "1") {
        echo "<option value=\"1\"selected>Platinum Coins</option>";
    } else {
        echo "<option value=\"1\">Platinum Coins</option>";
    }
    if ($thisVip["currency"] == "2") {
        echo "<option value=\"2\"selected>Gold Coins</option>";
    } else {
        echo "<option value=\"2\">Gold Coins</option>";
    }
    if ($thisVip["currency"] == "3") {
        echo "<option value=\"3\"selected>Silver Coins</option>";
    } else {
        echo "<option value=\"3\">Silver Coins</option>";
    }
    if ($thisVip["currency"] == "4") {
        echo "<option value=\"4\"selected>WCoinC</option>";
    } else {
        echo "<option value=\"4\">WCoinC</option>";
    }
    if ($thisVip["currency"] == "5") {
        echo "<option value=\"5\"selected>Goblin Points</option>";
    } else {
        echo "<option value=\"5\">Goblin Points</option>";
    }
    if ($thisVip["currency"] == "6") {
        echo "<option value=\"6\"selected>Zen</option>";
    } else {
        echo "<option value=\"6\">Zen</option>";
    }
    echo "\r\n            </select>\r\n          </td>";
    $length = NULL;
    $hours_selected = "";
    $days_selected = "";
    if ($thisVip["hours"] != NULL) {
        $length = $thisVip["hours"];
        $hours_selected = "selected";
    } else {
        $length = $thisVip["days"];
        $days_selected = "selected";
    }
    echo "<td><input name=\"length\" class=\"form-control\" type=\"text\" value=\"" . $length . "\" style=\"display: inline; width: 49%\"/>\r\n          <select name=\"length_type\" class=\"form-control\" style=\"display: inline; width: 49%\">\r\n            <option value=\"hours\" " . $hours_selected . ">Hours</option>\r\n            <option value=\"days\" " . $days_selected . ">Days</option>\r\n          </select></td>";
    echo "<td>\r\n    <input type=\"submit\" class=\"btn btn-success\" name=\"package_edit_submit\" value=\"Save\"/>\r\n    <a href=\"index.php?module=modules_manager&config=vip&deleteplan=" . $thisVip["id"] . "\" class=\"btn btn-danger\"><i class=\"fa fa-remove\"></i></a>\r\n\t\t</td>";
    echo "</tr></form>";
}
echo "<table class=\"table table-striped table-bordered table-hover\"><tr><th>Package Title</th><th>Type</th><th>Price</th><th>Length</th><th></th></tr><form action=\"index.php?module=modules_manager&config=vip\" method=\"post\"><tr><td><input name=\"name\" class=\"form-control\" type=\"text\"/></td><td>\r\n          <select name=\"type\" class=\"form-control\">\r\n            <option value=\"1\">Bronze</option>\r\n            <option value=\"2\">Silver</option>\r\n            <option value=\"3\">Gold</option>\r\n            <option value=\"4\">Platinum</option>\r\n          </select>\r\n        </td><td>\r\n          <input name=\"price\" class=\"form-control\" type=\"text\" style=\"display: inline; width: 49%\"/>\r\n          <select name=\"currency\" class=\"form-control\" style=\"display: inline; width: 49%\">\r\n            <option value=\"1\">Platinum Coins</option>\r\n            <option value=\"2\">Gold Coins</option>\r\n            <option value=\"3\">Silver Coins</option>\r\n            <option value=\"4\">WCoinC</option>\r\n            <option value=\"5\">Goblin Points</option>\r\n            <option value=\"6\">Zen</option>\r\n          </select>\r\n        </td><td>\r\n          <input name=\"length\" class=\"form-control\" type=\"text\" style=\"display: inline; width: 49%\"/>\r\n          <select name=\"length_type\" class=\"form-control\" style=\"display: inline; width: 49%\">\r\n            <option value=\"hours\">Hours</option>\r\n            <option value=\"days\">Days</option>\r\n          </select>\r\n        </td><td><input type=\"submit\" name=\"package_add_submit\" class=\"btn btn-success\" value=\"Add!\"/></td></tr></form></table>\r\n    <hr>\r\n    <h3>Manage VIP Categories</h3>\r\n<table class=\"table table-striped table-bordered table-hover\"><tr><th>Category Title</th><th>Position <small>(Use 0 to hide category)</small></th><th>Currency</th><th></th></tr>";
$vipPackages = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_VIP_CATEGORIES ORDER BY id");
foreach ($vipPackages as $thisVip) {
    echo "<form action=\"index.php?module=modules_manager&config=vip\" method=\"post\">";
    echo "<input type=\"hidden\" name=\"id\" value=\"" . $thisVip["id"] . "\"/>";
    echo "<tr>";
    echo "<td><input name=\"name\" class=\"form-control\" type=\"text\" value=\"" . $thisVip["name"] . "\"/></td>";
    echo "<td><input name=\"position\" class=\"form-control\" type=\"text\" value=\"" . $thisVip["position"] . "\"/></td>";
    echo "<td>\r\n            <select name=\"currency\" class=\"form-control\">";
    if ($thisVip["currency"] == "1") {
        echo "<option value=\"1\"selected>Platinum Coins</option>";
    } else {
        echo "<option value=\"1\">Platinum Coins</option>";
    }
    if ($thisVip["currency"] == "2") {
        echo "<option value=\"2\"selected>Gold Coins</option>";
    } else {
        echo "<option value=\"2\">Gold Coins</option>";
    }
    if ($thisVip["currency"] == "3") {
        echo "<option value=\"3\"selected>Silver Coins</option>";
    } else {
        echo "<option value=\"3\">Silver Coins</option>";
    }
    if ($thisVip["currency"] == "4") {
        echo "<option value=\"4\"selected>WCoinC</option>";
    } else {
        echo "<option value=\"4\">WCoinC</option>";
    }
    if ($thisVip["currency"] == "5") {
        echo "<option value=\"5\"selected>Goblin Points</option>";
    } else {
        echo "<option value=\"5\">Goblin Points</option>";
    }
    if ($thisVip["currency"] == "6") {
        echo "<option value=\"6\"selected>Zen</option>";
    } else {
        echo "<option value=\"6\">Zen</option>";
    }
    echo "\r\n            </select>\r\n          </td><td>\r\n    <input type=\"submit\" class=\"btn btn-success\" name=\"category_edit_submit\" value=\"Save\"/>\r\n\t\t</td></tr></form>";
}
function saveChanges()
{
    
    foreach ($_POST as $setting) {
        if (!check_value($setting)) {
            message("error", "Missing data (complete all fields).");
            return NULL;
        }
    }
    $xmlPath = __PATH_MODULE_CONFIGS__ . "usercp.vip.xml";
    $xml = simplexml_load_file($xmlPath);
    $xml->active = $_POST["setting_1"];
    $xml->show_in_usercp = $_POST["show_in_usercp"];
    $xml->bronze_exp = $_POST["setting_2"];
    $xml->bronze_drop = $_POST["setting_3"];
    $xml->silver_exp = $_POST["setting_4"];
    $xml->silver_drop = $_POST["setting_5"];
    $xml->gold_exp = $_POST["setting_6"];
    $xml->gold_drop = $_POST["setting_7"];
    $xml->platinum_exp = $_POST["setting_8"];
    $xml->platinum_drop = $_POST["setting_9"];
    $save = $xml->asXML($xmlPath);
    if ($save) {
        message("success", "Settings successfully saved.");
    } else {
        message("error", "There has been an error while saving changes.");
    }
}

?>