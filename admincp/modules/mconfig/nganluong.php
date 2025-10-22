<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h1 class=\"page-header\">NganLuong Settings</h1>\n";
if (check_value($_POST["submit_changes"])) {
    savechanges();
}
if (check_value($_POST["submit_changes"])) {
    savechanges();
}
if (check_value($_POST["package_add_submit"])) {
    if (check_value($_POST["id"]) && check_value($_POST["name"]) && check_value($_POST["amount"]) && check_value($_POST["reward"]) && check_value($_POST["desc"])) {
        $xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "donation.nganluong.xml");
        if ($xml !== false) {
            $array = [];
            $array["active"] = trim($xml->active);
            $array["url_ws"] = trim($xml->url_ws);
            $array["receiver"] = trim($xml->receiver);
            $array["merchant_id"] = trim($xml->merchant_id);
            $array["merchant_pass"] = trim($xml->merchant_pass);
            $array["credit_config"] = trim($xml->credit_config);
            $i = 1;
            foreach ($xml->options->children() as $tag => $option) {
                if ($tag == "option") {
                    $array["options"][$i]["id"] = intval($option["id"]);
                    $array["options"][$i]["name"] = strval($option["name"]);
                    $array["options"][$i]["amount"] = floatval($option["amount"]);
                    $array["options"][$i]["currency"] = strval($option["currency"]);
                    $array["options"][$i]["reward"] = intval($option["reward"]);
                    $array["options"][$i]["desc"] = strval($option["desc"]);
                    $i++;
                }
            }
            $array["options"][$i]["id"] = intval($_POST["id"]);
            $array["options"][$i]["name"] = strval($_POST["name"]);
            $array["options"][$i]["amount"] = floatval($_POST["amount"]);
            $array["options"][$i]["currency"] = strval($_POST["currency"]);
            $array["options"][$i]["reward"] = intval($_POST["reward"]);
            $array["options"][$i]["desc"] = strval($_POST["desc"]);
            $tmp = arraytoxml($array);
            file_put_contents(__PATH_MODULE_CONFIGS__ . "donation.nganluong.xml", $tmp);
            message("success", "Donation package was successfully created.");
        }
    } else {
        message("error", "Missing data (complete all fields).");
    }
}
if (check_value($_POST["package_edit_submit"])) {
    if (check_value($_POST["id"]) && check_value($_POST["name"]) && check_value($_POST["amount"]) && check_value($_POST["reward"]) && check_value($_POST["desc"])) {
        $xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "donation.nganluong.xml");
        if ($xml !== false) {
            $array = [];
            $array["active"] = trim($xml->active);
            $array["url_ws"] = trim($xml->url_ws);
            $array["receiver"] = trim($xml->receiver);
            $array["merchant_id"] = trim($xml->merchant_id);
            $array["merchant_pass"] = trim($xml->merchant_pass);
            $array["credit_config"] = trim($xml->credit_config);
            $i = 1;
            foreach ($xml->options->children() as $tag => $option) {
                if ($tag == "option") {
                    if (intval($option["id"]) == intval($_POST["id"])) {
                        $array["options"][$i]["id"] = intval($_POST["id"]);
                        $array["options"][$i]["name"] = strval($_POST["name"]);
                        $array["options"][$i]["amount"] = floatval($_POST["amount"]);
                        $array["options"][$i]["currency"] = strval($_POST["currency"]);
                        $array["options"][$i]["reward"] = intval($_POST["reward"]);
                        $array["options"][$i]["desc"] = strval($_POST["desc"]);
                    } else {
                        $array["options"][$i]["id"] = intval($option["id"]);
                        $array["options"][$i]["name"] = strval($option["name"]);
                        $array["options"][$i]["amount"] = floatval($option["amount"]);
                        $array["options"][$i]["currency"] = strval($option["currency"]);
                        $array["options"][$i]["reward"] = intval($option["reward"]);
                        $array["options"][$i]["desc"] = strval($option["desc"]);
                    }
                    $i++;
                }
            }
            $tmp = arraytoxml($array);
            file_put_contents(__PATH_MODULE_CONFIGS__ . "donation.nganluong.xml", $tmp);
            message("success", "Donation package #" . intval($_POST["id"]) . " was successfully edited.");
        }
    } else {
        message("error", "Missing data (complete all fields).");
    }
}
if (check_value($_GET["delete"])) {
    $xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "donation.nganluong.xml");
    if ($xml !== false) {
        $array = [];
        $array["active"] = trim($xml->active);
        $array["url_ws"] = trim($xml->url_ws);
        $array["receiver"] = trim($xml->receiver);
        $array["merchant_id"] = trim($xml->merchant_id);
        $array["merchant_pass"] = trim($xml->merchant_pass);
        $array["credit_config"] = trim($xml->credit_config);
        $found = false;
        $i = 1;
        foreach ($xml->options->children() as $tag => $option) {
            if ($tag == "option") {
                if (intval($option["id"]) == intval($_GET["delete"])) {
                    $found = true;
                } else {
                    $array["options"][$i]["id"] = intval($option["id"]);
                    $array["options"][$i]["name"] = strval($option["name"]);
                    $array["options"][$i]["amount"] = floatval($option["amount"]);
                    $array["options"][$i]["currency"] = strval($option["currency"]);
                    $array["options"][$i]["reward"] = intval($option["reward"]);
                    $array["options"][$i]["desc"] = strval($option["desc"]);
                    $i++;
                }
            }
        }
        $tmp = arraytoxml($array);
        file_put_contents(__PATH_MODULE_CONFIGS__ . "donation.nganluong.xml", $tmp);
        if ($found) {
            message("success", "Donation package #" . intval($_GET["delete"]) . " was successfully deleted.");
        }
    }
}
loadModuleConfigs("donation.nganluong");
$creditSystem = new CreditSystem($common, new Character(), $dB, $dB2);
echo "    <form action=\"\" method=\"post\">\n        <table class=\"table table-striped table-bordered table-hover module_config_tables\">\n            <tr>\n                <th>Status<br/><span>Enable/disable the nganluong donation gateway.</span></th>\n                <td>\n                    ";
enabledisableCheckboxes("active", mconfig("active"), "Enabled", "Disabled");
echo "                </td>\n            </tr>\n            <tr>\n                <th>URL WS<br/><span>Enter URL WS.<br>Default value: https://www.nganluong.vn/micro_checkout_api.php?wsdl</span></th>\n                <td>\n                    <input class=\"form-control\" type=\"text\" name=\"url_ws\" value=\"";
echo mconfig("url_ws");
echo "\"/>\n\n                </td>\n            </tr>\n            <tr>\n                <th>NgangLuong Email Address<br/><span>Enter NgangLuong Email Address.</span></th>\n                <td>\n                    <input class=\"form-control\" type=\"text\" name=\"receiver\" value=\"";
echo mconfig("receiver");
echo "\"/>\n                </td>\n            </tr>\n            <tr>\n                <th>Merchant ID<br/><span>Enter NgangLuong Merchant ID.</span></th>\n                <td>\n                    <input class=\"form-control\" type=\"text\" name=\"merchant_id\" value=\"";
echo mconfig("merchant_id");
echo "\"/>\n                </td>\n            </tr>\n            <tr>\n                <th>Merchant Password<br/><span>Enter NgangLuong Merchant Password.</span></th>\n                <td>\n                    <input class=\"form-control\" type=\"text\" name=\"merchant_pass\" value=\"";
echo mconfig("merchant_pass");
echo "\"/>\n                </td>\n            </tr>\n            <tr>\n                <th>Credit Configuration<br/><span></span></th>\n                <td>\n                    ";
echo $creditSystem->buildSelectInput("credit_config", mconfig("credit_config"), "form-control");
echo "                </td>\n            </tr>\n            <tr>\n                <td colspan=\"2\"><input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\" class=\"btn btn-success\"/>\n                </td>\n            </tr>\n        </table>\n    </form>\n\n\n    <hr><h3>Manage Donation Packages</h3>\n    <table class=\"table table-striped table-bordered table-hover\">\n        <tr>\n            <th width=\"60px\">ID</th>\n            <th>Name</th>\n            <th>Price</th>\n            <th>Currency</th>\n            <th>Reward</th>\n            <th>Description</th>\n            <th></th>\n        </tr>\n        <form action=\"index.php?module=modules_manager&config=nganluong\" method=\"post\">\n            <tr>\n                <td><input name=\"id\" class=\"form-control\" type=\"text\"/></td>\n                <td><input name=\"name\" class=\"form-control\" type=\"text\"/></td>\n                <td><input name=\"amount\" class=\"form-control\" type=\"text\"/></td>\n                <td><input name=\"currency\" class=\"form-control\" type=\"text\"/></td>\n                <td><input name=\"reward\" class=\"form-control\" type=\"text\"/></td>\n                <td><input name=\"desc\" class=\"form-control\" type=\"text\"/></td>\n                <td><input type=\"submit\" name=\"package_add_submit\" class=\"btn btn-success\" value=\"Add\"/></td>\n            </tr>\n        </form>\n    </table>\n\n    <table class=\"table table-striped table-bordered table-hover\">\n        <tr>\n            <th width=\"60px\">ID</th>\n            <th>Name</th>\n            <th>Price</th>\n            <th>Currency</th>\n            <th>Reward</th>\n            <th>Description</th>\n            <th></th>\n        </tr>\n\n";
$xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "donation.nganluong.xml");
if ($xml !== false) {
    $options = [];
    $i = 1;
    foreach ($xml->options->children() as $tag => $option) {
        if ($tag == "option") {
            $options[$i]["id"] = intval($option["id"]);
            $options[$i]["name"] = strval($option["name"]);
            $options[$i]["amount"] = floatval($option["amount"]);
            $options[$i]["currency"] = strval($option["currency"]);
            $options[$i]["reward"] = floatval($option["reward"]);
            $options[$i]["desc"] = strval($option["desc"]);
            echo "<form action=\"index.php?module=modules_manager&config=nganluong\" method=\"post\"><tr>";
            echo "<td><input name=\"id\" class=\"form-control\" type=\"text\" value=\"" . $options[$i]["id"] . "\" /></td>";
            echo "<td><input name=\"name\" class=\"form-control\" type=\"text\" value=\"" . $options[$i]["name"] . "\" /></td>";
            echo "<td><input name=\"amount\" class=\"form-control\" type=\"text\" value=\"" . $options[$i]["amount"] . "\" /></td>";
            echo "<td><input name=\"currency\" class=\"form-control\" type=\"text\" value=\"" . $options[$i]["currency"] . "\" /></td>";
            echo "<td><input name=\"reward\" class=\"form-control\" type=\"text\" value=\"" . $options[$i]["reward"] . "\" /></td>";
            echo "<td><input name=\"desc\" class=\"form-control\" type=\"text\" value=\"" . $options[$i]["desc"] . "\" /></td>";
            echo "<td><input type=\"submit\" name=\"package_edit_submit\" class=\"btn btn-success\" value=\"Save\"/><a href=\"index.php?module=modules_manager&config=nganluong&delete=" . $option["id"] . "\" class=\"btn btn-danger\"><i class=\"fa fa-remove\"></i></a></td>";
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
    $xmlPath = __PATH_MODULE_CONFIGS__ . "donation.nganluong.xml";
    $xml = simplexml_load_file($xmlPath);
    $xml->active = $_POST["active"];
    $xml->url_ws = $_POST["url_ws"];
    $xml->receiver = $_POST["receiver"];
    $xml->merchant_id = $_POST["merchant_id"];
    $xml->merchant_pass = $_POST["merchant_pass"];
    $xml->credit_config = $_POST["credit_config"];
    $save = $xml->asXML($xmlPath);
    if ($save) {
        message("success", "[NganLuong] Settings successfully saved.");
    } else {
        message("error", "[NganLuong] There has been an error while saving changes.");
    }
}
function arrayToXML($array)
{
    $sxe = new SimpleXMLElement("<settings/>");
    $sxe->addChild("active", $array["active"]);
    $sxe->addChild("url_ws", $array["url_ws"]);
    $sxe->addChild("receiver", $array["receiver"]);
    $sxe->addChild("merchant_id", $array["merchant_id"]);
    $sxe->addChild("merchant_pass", $array["merchant_pass"]);
    $sxe->addChild("credit_config", $array["credit_config"]);
    $options = $sxe->addChild("options");
    foreach ($array["options"] as $thisOpt) {
        $option = $options->addChild("option");
        $option->addAttribute("id", $thisOpt["id"]);
        $option->addAttribute("name", $thisOpt["name"]);
        $option->addAttribute("amount", $thisOpt["amount"]);
        $option->addAttribute("currency", $thisOpt["currency"]);
        $option->addAttribute("reward", $thisOpt["reward"]);
        $option->addAttribute("desc", $thisOpt["desc"]);
    }
    return $sxe->asXML();
}

?>