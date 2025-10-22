<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$General = new xGeneral();
if ($General->ftanHCIfo_canUse_j8GsnawwvJ_Module("merchant")) {
    echo "    <h2>Merchant Settings</h2>\r\n    ";
    function saveChanges()
    {
        foreach ($_POST as $setting) {
            if (!check_value($setting)) {
                message("error", "Missing data (complete all fields).");
                return NULL;
            }
        }
        $xmlPath = __PATH_MODULE_CONFIGS__ . "usercp.merchant.xml";
        $xml = simplexml_load_file($xmlPath);
        $xml->active = $_POST["setting_1"];
        $xml->ratio = $_POST["setting_2"];
        $xml->bonus_req = $_POST["setting_3"];
        $xml->bonus_amount = $_POST["setting_4"];
        $xml->bonus = $_POST["setting_5"];
        $xml->bonus_platinum_req = $_POST["setting_6"];
        $xml->bonus_platinum_amount = $_POST["setting_7"];
        $save = $xml->asXML($xmlPath);
        if ($save) {
            message("success", "Settings successfully saved.");
        } else {
            message("error", "There has been an error while saving changes.");
        }
    }
    if (check_value($_POST["submit_changes"])) {
        saveChanges();
    }
    if (check_value($_GET["delete"])) {
        $id = htmlspecialchars($_GET["delete"]);
        $delete = $dB->query("DELETE FROM IMPERIAMUCMS_MERCHANTS WHERE id = ?", [$id]);
        if ($delete) {
            message("success", "Merchant was successfully deleted.");
        } else {
            message("error", "Error occurred.");
        }
    }
    if (check_value($_POST["switchStatus"])) {
        $id = htmlspecialchars($_POST["id"]);
        if (check_value($id)) {
            if (is_numeric($id)) {
                $merchantStatus = $dB->query_fetch_single("SELECT active FROM IMPERIAMUCMS_MERCHANTS WHERE id = ?", [$id]);
                if ($merchantStatus["active"] == "1") {
                    $newStatus = 0;
                } else {
                    if ($merchantStatus["active"] == "0") {
                        $newStatus = 1;
                    }
                }
                $update = $dB->query("UPDATE IMPERIAMUCMS_MERCHANTS SET active = ? WHERE id = ?", [$newStatus, $id]);
                if ($update) {
                    message("success", "Data were updated successfully.");
                } else {
                    message("error", "Unexpected error occurred.");
                }
            } else {
                message("error", "Invalid values.");
            }
        } else {
            message("error", "Invalid values.");
        }
    }
    if (check_value($_POST["add_merchant"])) {
        if (check_value($_POST["account"]) && check_value($_POST["name"]) && check_value($_POST["contact"]) && check_value($_POST["wallet"])) {
            $update = $dB->query("INSERT INTO IMPERIAMUCMS_MERCHANTS (AccountID, name, contact, wallet, active)\r\n                              VALUES(?,?,?,?,?)", [$_POST["account"], $_POST["name"], $_POST["contact"], $_POST["wallet"], 1]);
            if ($update) {
                message("success", "Data were added successfully.");
            } else {
                message("error", "Unexpected error occurred.");
            }
        } else {
            message("error", "Invalid values.");
        }
    }
    if (check_value($_POST["merchant_edit"])) {
        if (check_value($_POST["id"]) && check_value($_POST["account"]) && check_value($_POST["name"]) && check_value($_POST["contact"]) && check_value($_POST["wallet"])) {
            $update = $dB->query("UPDATE IMPERIAMUCMS_MERCHANTS SET AccountID = ?, name = ?, contact = ?, wallet = ? WHERE id = ?", [$_POST["account"], $_POST["name"], $_POST["contact"], $_POST["wallet"], $_POST["id"]]);
            if ($update) {
                message("success", "Data were updated successfully.");
            } else {
                message("error", "Unexpected error occurred.");
            }
        } else {
            message("error", "Invalid values.");
        }
    }
    loadModuleConfigs("usercp.merchant");
    echo "    <form action=\"\" method=\"post\">\r\n        <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n            <tr>\r\n                <th>Status<br/><span>Enable/disable the merchant module.</span></th>\r\n                <td>\r\n                    ";
    enabledisableCheckboxes("setting_1", mconfig("active"), "Enabled", "Disabled");
    echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>WCoinC Exchange Ratio<br/><span>1 PHP = X WCoinC.</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"setting_2\" value=\"";
    echo mconfig("ratio");
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>WCoinC Bonus Requirement<br/><span>For each X PHP you will get Y WCoinC.</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"setting_3\" value=\"";
    echo mconfig("bonus_req");
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>WCoinC Bonus Reward<br/><span>For each PHP WCoinC you will get Y WCoinC.</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"setting_4\" value=\"";
    echo mconfig("bonus_amount");
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>WCoinC Bonus<br/><span>Configure WCoinC bonus reward in %. 0 = disabled</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"setting_5\" value=\"";
    echo mconfig("bonus");
    echo "\" style=\"display: inline; width: 150px\"/>%\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Platinum Coins Bonus Requirement<br/><span>For each X PHP you will get Y Platinum Coins.</span>\r\n                </th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"setting_6\" value=\"";
    echo mconfig("bonus_platinum_req");
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Platinum Coins Bonus Reward<br/><span>For each X PHP you will get Y Platinum Coins.</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"setting_7\" value=\"";
    echo mconfig("bonus_platinum_amount");
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td colspan=\"2\"><input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\" class=\"btn btn-success\"/>\r\n                </td>\r\n            </tr>\r\n        </table>\r\n    </form>\r\n\r\n    <hr>\r\n    <h3>Manage Merchants</h3>\r\n    <table class=\"table table-striped table-bordered table-hover\"><tr><th>AccountID</th><th>Name</th><th>Contact</th><th>Wallet</th><th></th></tr>";
    $merchants = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_MERCHANTS ORDER BY id");
    $i = 1;
    foreach ($merchants as $thisMerchant) {
        if ($thisMerchant["active"] == "1") {
            $activeBtn = "<input type=\"submit\" class=\"btn btn-danger\" name=\"switchStatus\" value=\"Disable\" />";
        } else {
            $activeBtn = "<input type=\"submit\" class=\"btn btn-success\" name=\"switchStatus\" value=\"Enable\" />";
        }
        echo "<form action=\"\" method=\"post\">";
        echo "<input type=\"hidden\" name=\"id\" value=\"" . $thisMerchant["id"] . "\"/>";
        echo "<tr>";
        echo "<td><input name=\"account\" class=\"form-control\" type=\"text\" value=\"" . $thisMerchant["AccountID"] . "\"/></td>";
        echo "<td><input name=\"name\" class=\"form-control\" type=\"text\" value=\"" . $thisMerchant["name"] . "\"/></td>";
        echo "<td><input name=\"contact\" class=\"form-control\" type=\"text\" value=\"" . $thisMerchant["contact"] . "\"/></td>";
        echo "<td><input name=\"wallet\" class=\"form-control\" type=\"text\" value=\"" . $thisMerchant["wallet"] . "\"/></td>";
        echo "<td>" . $activeBtn . " <input type=\"submit\" class=\"btn btn-success\" name=\"merchant_edit\" value=\"Save\"/>";
        echo " <a href=\"index.php?module=merchant_settings&delete=" . $thisMerchant["id"] . "\" class=\"btn btn-danger\" title=\"Delete\"><i class=\"fa fa-remove\"></i></a>";
        echo "</td></tr></form>";
        $i++;
    }
    echo "</table><table class=\"table table-striped table-bordered table-hover\"><tr><th>AccountID</th><th>Name</th><th>Contact</th><th>Wallet</th><th></th></tr><form action=\"index.php?module=merchant_settings\" method=\"post\"><tr><td><input name=\"account\" class=\"form-control\" type=\"text\" value=\"\"/></td><td><input name=\"name\" class=\"form-control\" type=\"text\" value=\"\"/></td><td><input name=\"contact\" class=\"form-control\" type=\"text\" value=\"\"/></td><td><input name=\"wallet\" class=\"form-control\" type=\"text\" value=\"\"/></td><td><input type=\"submit\" name=\"add_merchant\" class=\"btn btn-success\" value=\"Add!\"/></td></tr></form></table>";
} else {
    message("error", "You can't use this module!");
}

?>