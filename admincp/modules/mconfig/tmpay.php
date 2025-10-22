<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h1 class=\"page-header\">TMPay Settings</h1>\n";
if (check_value($_POST["submit_changes"])) {
    savechanges();
}
if (check_value($_POST["package_add_submit"])) {
    if (check_value($_POST["id"]) && check_value($_POST["amount"]) && check_value($_POST["reward"]) && check_value($_POST["bonus"])) {
        $xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "donation.tmpay.xml");
        if ($xml !== false) {
            $array = [];
            $array["active"] = trim($xml->active);
            $array["merchant_id"] = trim($xml->merchant_id);
            $array["access_ip"] = trim($xml->access_ip);
            $array["credit_config"] = trim($xml->credit_config);
            $i = 1;
            foreach ($xml->options->children() as $tag => $option) {
                if ($tag == "option") {
                    $array["options"][$i]["id"] = intval($option["id"]);
                    $array["options"][$i]["amount"] = floatval($option["amount"]);
                    $array["options"][$i]["reward"] = floatval($option["reward"]);
                    $array["options"][$i]["bonus"] = floatval($option["bonus"]);
                    $i++;
                }
            }
            $array["options"][$i]["id"] = intval($_POST["id"]);
            $array["options"][$i]["amount"] = floatval($_POST["amount"]);
            $array["options"][$i]["reward"] = floatval($_POST["reward"]);
            $array["options"][$i]["bonus"] = floatval($_POST["bonus"]);
            $tmp = arraytoxml($array);
            file_put_contents(__PATH_MODULE_CONFIGS__ . "donation.tmpay.xml", $tmp);
            message("success", "Donation package was successfully created.");
        }
    } else {
        message("error", "Missing data (complete all fields).");
    }
}
if (check_value($_POST["package_edit_submit"])) {
    if (check_value($_POST["id"]) && check_value($_POST["amount"]) && check_value($_POST["reward"]) && check_value($_POST["bonus"])) {
        $xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "donation.tmpay.xml");
        if ($xml !== false) {
            $array = [];
            $array["active"] = trim($xml->active);
            $array["merchant_id"] = trim($xml->merchant_id);
            $array["access_ip"] = trim($xml->access_ip);
            $array["credit_config"] = trim($xml->credit_config);
            $i = 1;
            foreach ($xml->options->children() as $tag => $option) {
                if ($tag == "option") {
                    if (intval($option["id"]) == intval($_POST["id"])) {
                        $array["options"][$i]["id"] = intval($_POST["id"]);
                        $array["options"][$i]["amount"] = floatval($_POST["amount"]);
                        $array["options"][$i]["reward"] = floatval($_POST["reward"]);
                        $array["options"][$i]["bonus"] = floatval($_POST["bonus"]);
                    } else {
                        $array["options"][$i]["id"] = intval($option["id"]);
                        $array["options"][$i]["amount"] = floatval($option["amount"]);
                        $array["options"][$i]["reward"] = floatval($option["reward"]);
                        $array["options"][$i]["bonus"] = floatval($option["bonus"]);
                    }
                    $i++;
                }
            }
            $tmp = arraytoxml($array);
            file_put_contents(__PATH_MODULE_CONFIGS__ . "donation.tmpay.xml", $tmp);
            message("success", "Donation package #" . intval($_POST["id"]) . " was successfully edited.");
        }
    } else {
        message("error", "Missing data (complete all fields).");
    }
}
if (check_value($_GET["delete"])) {
    $xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "donation.tmpay.xml");
    if ($xml !== false) {
        $array = [];
        $array["active"] = trim($xml->active);
        $array["merchant_id"] = trim($xml->merchant_id);
        $array["access_ip"] = trim($xml->access_ip);
        $array["credit_config"] = trim($xml->credit_config);
        $found = false;
        $i = 1;
        foreach ($xml->options->children() as $tag => $option) {
            if ($tag == "option") {
                if (intval($option["id"]) == intval($_GET["delete"])) {
                    $found = true;
                } else {
                    $array["options"][$i]["id"] = intval($option["id"]);
                    $array["options"][$i]["amount"] = floatval($option["amount"]);
                    $array["options"][$i]["reward"] = floatval($option["reward"]);
                    $array["options"][$i]["bonus"] = floatval($option["bonus"]);
                    $i++;
                }
            }
        }
        $tmp = arraytoxml($array);
        file_put_contents(__PATH_MODULE_CONFIGS__ . "donation.tmpay.xml", $tmp);
        if ($found) {
            message("success", "Donation package #" . intval($_GET["delete"]) . " was successfully deleted.");
        }
    }
}
loadModuleConfigs("donation.tmpay");
$creditSystem = new CreditSystem($common, new Character(), $dB, $dB2);
echo "    <form action=\"\" method=\"post\">\n        <table class=\"table table-striped table-bordered table-hover module_config_tables\">\n            <tr>\n                <th>Status<br/><span>Enable/disable donation gateway.</span></th>\n                <td>\n                    ";
enabledisableCheckboxes("active", mconfig("active"), "Enabled", "Disabled");
echo "                </td>\n            </tr>\n            <tr>\n                <th>Merchant ID<br/><span>TMPay Merchant ID.</span></th>\n                <td>\n                    <input class=\"form-control\" type=\"text\" name=\"merchant_id\" value=\"";
echo mconfig("merchant_id");
echo "\"/>\n                </td>\n            </tr>\n            <tr>\n                <th>Allowed IP Addresses<br/><span>List of IP addresses which can access to TMPay API divided by semicolon \";\".</span></th>\n                <td>\n                    <input class=\"form-control\" type=\"text\" name=\"access_ip\" value=\"";
echo mconfig("access_ip");
echo "\"/>\n                </td>\n            </tr>\n            <tr>\n                <th>Credit Configuration<br/><span></span></th>\n                <td>\n                    ";
echo $creditSystem->buildSelectInput("credit_config", mconfig("credit_config"), "form-control");
echo "                </td>\n            </tr>\n            <tr>\n                <td colspan=\"2\"><input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\" class=\"btn btn-success\"/>\n                </td>\n            </tr>\n        </table>\n    </form>\n\n<hr><h3>Manage Donation Packages</h3><table class=\"table table-striped table-bordered table-hover\"><tr><th>ID (Unique)</th><th>Amount</th><th>Reward</th><th>Bonus</th><th></th></tr><form action=\"index.php?module=modules_manager&config=tmpay\" method=\"post\"><tr><td><input name=\"id\" class=\"form-control\" type=\"text\"/></td><td><input name=\"amount\" class=\"form-control\" type=\"text\"/></td><td><input name=\"reward\" class=\"form-control\" type=\"text\"/></td><td><input name=\"bonus\" class=\"form-control\" type=\"text\"/></td><td><input type=\"submit\" name=\"package_add_submit\" class=\"btn btn-success\" value=\"Add\"/></td></tr></form></table><table class=\"table table-striped table-bordered table-hover\"><tr><th>ID (Unique)</th><th>Amount</th><th>Reward</th><th>Bonus</th><th></th></tr>";
$xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "donation.tmpay.xml");
if ($xml !== false) {
    $options = [];
    $i = 1;
    foreach ($xml->options->children() as $tag => $option) {
        if ($tag == "option") {
            $options[$i]["id"] = intval($option["id"]);
            $options[$i]["amount"] = floatval($option["amount"]);
            $options[$i]["reward"] = floatval($option["reward"]);
            $options[$i]["bonus"] = floatval($option["bonus"]);
            echo "<form action=\"index.php?module=modules_manager&config=tmpay\" method=\"post\"><tr>";
            echo "<td><input name=\"id\" class=\"form-control\" type=\"text\" value=\"" . intval($option["id"]) . "\" /></td>";
            echo "<td><input name=\"amount\" class=\"form-control\" type=\"text\" value=\"" . floatval($option["amount"]) . "\" /></td>";
            echo "<td><input name=\"reward\" class=\"form-control\" type=\"text\" value=\"" . floatval($option["reward"]) . "\" /></td>";
            echo "<td><input name=\"bonus\" class=\"form-control\" type=\"text\" value=\"" . floatval($option["bonus"]) . "\" /></td>";
            echo "<td><input type=\"submit\" name=\"package_edit_submit\" class=\"btn btn-success\" value=\"Save\"/><a href=\"index.php?module=modules_manager&config=tmpay&delete=" . $option["id"] . "\" class=\"btn btn-danger\"><i class=\"fa fa-remove\"></i></a></td>";
            echo "</tr></form>";
            $i++;
        }
    }
}
echo "</table>";
function saveChanges()
{
    
    foreach ($_POST as $setting) {
        if (!check_value($setting)) {
            message("error", "Missing data (complete all fields).");
            return NULL;
        }
    }
    $xmlPath = __PATH_MODULE_CONFIGS__ . "donation.tmpay.xml";
    $xml = simplexml_load_file($xmlPath);
    $xml->active = $_POST["active"];
    $xml->merchant_id = $_POST["merchant_id"];
    $xml->access_ip = $_POST["access_ip"];
    $xml->credit_config = $_POST["credit_config"];
    $save = $xml->asXML($xmlPath);
    if ($save) {
        message("success", "[TMPay] Settings successfully saved.");
    } else {
        message("error", "[TMPay] There has been an error while saving changes.");
    }
}
function arrayToXML($array)
{
    $sxe = new SimpleXMLElement("<settings/>");
    $sxe->addChild("active", $array["active"]);
    $sxe->addChild("merchant_id", $array["merchant_id"]);
    $sxe->addChild("access_ip", $array["access_ip"]);
    $sxe->addChild("credit_config", $array["credit_config"]);
    $options = $sxe->addChild("options");
    foreach ($array["options"] as $thisOpt) {
        $option = $options->addChild("option");
        $option->addAttribute("id", $thisOpt["id"]);
        $option->addAttribute("amount", $thisOpt["amount"]);
        $option->addAttribute("reward", $thisOpt["reward"]);
        $option->addAttribute("bonus", $thisOpt["bonus"]);
    }
    return $sxe->asXML();
}

?>