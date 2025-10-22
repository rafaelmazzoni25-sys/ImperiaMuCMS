<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h1 class=\"page-header\">PayU.pl Settings</h1>\n";
if (check_value($_POST["submit_changes"])) {
    savechanges();
}
if (check_value($_POST["package_add_submit"])) {
    if (check_value($_POST["id"]) && check_value($_POST["name"]) && check_value($_POST["amount"]) && check_value($_POST["reward"]) && check_value($_POST["desc"])) {
        $xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "donation.payu.xml");
        if ($xml !== false) {
            $array = [];
            $array["active"] = trim($xml->active);
            $array["pos_id"] = trim($xml->pos_id);
            $array["pos_auth_key"] = trim($xml->pos_auth_key);
            $array["first_md5_key"] = trim($xml->first_md5_key);
            $array["second_md5_key"] = trim($xml->second_md5_key);
            $array["credit_config"] = trim($xml->credit_config);
            $i = 1;
            foreach ($xml->options->children() as $tag => $option) {
                if ($tag == "option") {
                    $array["options"][$i]["id"] = intval($option["id"]);
                    $array["options"][$i]["name"] = strval($option["name"]);
                    $array["options"][$i]["amount"] = floatval($option["amount"]);
                    $array["options"][$i]["reward"] = intval($option["reward"]);
                    $array["options"][$i]["desc"] = strval($option["desc"]);
                    $i++;
                }
            }
            $array["options"][$i]["id"] = intval($_POST["id"]);
            $array["options"][$i]["name"] = strval($_POST["name"]);
            $array["options"][$i]["amount"] = floatval($_POST["amount"]);
            $array["options"][$i]["reward"] = intval($_POST["reward"]);
            $array["options"][$i]["desc"] = strval($_POST["desc"]);
            $tmp = arraytoxml($array);
            file_put_contents(__PATH_MODULE_CONFIGS__ . "donation.payu.xml", $tmp);
            message("success", "Donation package was successfully created.");
        }
    } else {
        message("error", "Missing data (complete all fields).");
    }
}
if (check_value($_POST["package_edit_submit"])) {
    if (check_value($_POST["id"]) && check_value($_POST["name"]) && check_value($_POST["amount"]) && check_value($_POST["reward"]) && check_value($_POST["desc"])) {
        $xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "donation.payu.xml");
        if ($xml !== false) {
            $array = [];
            $array["active"] = trim($xml->active);
            $array["pos_id"] = trim($xml->pos_id);
            $array["pos_auth_key"] = trim($xml->pos_auth_key);
            $array["first_md5_key"] = trim($xml->first_md5_key);
            $array["second_md5_key"] = trim($xml->second_md5_key);
            $array["credit_config"] = trim($xml->credit_config);
            $i = 1;
            foreach ($xml->options->children() as $tag => $option) {
                if ($tag == "option") {
                    if (intval($option["id"]) == intval($_POST["id"])) {
                        $array["options"][$i]["id"] = intval($_POST["id"]);
                        $array["options"][$i]["name"] = strval($_POST["name"]);
                        $array["options"][$i]["amount"] = floatval($_POST["amount"]);
                        $array["options"][$i]["reward"] = intval($_POST["reward"]);
                        $array["options"][$i]["desc"] = strval($_POST["desc"]);
                    } else {
                        $array["options"][$i]["id"] = intval($option["id"]);
                        $array["options"][$i]["name"] = strval($option["name"]);
                        $array["options"][$i]["amount"] = floatval($option["amount"]);
                        $array["options"][$i]["reward"] = intval($option["reward"]);
                        $array["options"][$i]["desc"] = strval($option["desc"]);
                    }
                    $i++;
                }
            }
            $tmp = arraytoxml($array);
            file_put_contents(__PATH_MODULE_CONFIGS__ . "donation.payu.xml", $tmp);
            message("success", "Donation package #" . intval($_POST["id"]) . " was successfully edited.");
        }
    } else {
        message("error", "Missing data (complete all fields).");
    }
}
if (check_value($_GET["delete"])) {
    $xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "donation.payu.xml");
    if ($xml !== false) {
        $array = [];
        $array["active"] = trim($xml->active);
        $array["pos_id"] = trim($xml->pos_id);
        $array["pos_auth_key"] = trim($xml->pos_auth_key);
        $array["first_md5_key"] = trim($xml->first_md5_key);
        $array["second_md5_key"] = trim($xml->second_md5_key);
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
                    $array["options"][$i]["reward"] = intval($option["reward"]);
                    $array["options"][$i]["desc"] = strval($option["desc"]);
                    $i++;
                }
            }
        }
        $tmp = arraytoxml($array);
        file_put_contents(__PATH_MODULE_CONFIGS__ . "donation.payu.xml", $tmp);
        if ($found) {
            message("success", "Donation package #" . intval($_GET["delete"]) . " was successfully deleted.");
        }
    }
}
loadModuleConfigs("donation.payu");
$creditSystem = new CreditSystem($common, new Character(), $dB, $dB2);
echo "    <form action=\"\" method=\"post\">\n        <table class=\"table table-striped table-bordered table-hover module_config_tables\">\n            <tr>\n                <th>Status<br/><span>Enable/disable the homepay.pl donation gateway.</span></th>\n                <td>\n                    ";
enabledisableCheckboxes("setting_1", mconfig("active"), "Enabled", "Disabled");
echo "                </td>\n            </tr>\n            <tr>\n                <th>PayU.pl UserID<br/><span></span></th>\n                <td>\n                    <input class=\"form-control\" type=\"text\" name=\"setting_2\" value=\"";
echo mconfig("pos_id");
echo "\"/>\n                </td>\n            </tr>\n            <tr>\n                <th>PayU.pl Auth Key<br/><span></span></th>\n                <td>\n                    <input class=\"form-control\" type=\"text\" name=\"setting_3\" value=\"";
echo mconfig("pos_auth_key");
echo "\"/>\n                </td>\n            </tr>\n            <tr>\n                <th>PayU.pl 1st MD5 Key<br/><span></span></th>\n                <td>\n                    <input class=\"form-control\" type=\"text\" name=\"setting_4\" value=\"";
echo mconfig("first_md5_key");
echo "\"/>\n                </td>\n            </tr>\n            <tr>\n                <th>PayU.pl 2nd MD5 Key<br/><span></span></th>\n                <td>\n                    <input class=\"form-control\" type=\"text\" name=\"setting_5\" value=\"";
echo mconfig("second_md5_key");
echo "\"/>\n                </td>\n            </tr>\n            <tr>\n                <th>Credit Configuration<br/><span></span></th>\n                <td>\n                    ";
echo $creditSystem->buildSelectInput("setting_6", mconfig("credit_config"), "form-control");
echo "                </td>\n            </tr>\n            <tr>\n                <td colspan=\"2\"><input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\" class=\"btn btn-success\"/>\n                </td>\n            </tr>\n        </table>\n    </form>\n\n<hr><h3>Manage Donation Packages</h3><table class=\"table table-striped table-bordered table-hover\"><tr><th>ID</th><th>Name</th><th>Price</th><th>Reward</th><th>Description</th><th></th></tr><form action=\"index.php?module=modules_manager&config=payu\" method=\"post\"><tr><td><input name=\"id\" class=\"form-control\" type=\"text\"/></td><td><input name=\"name\" class=\"form-control\" type=\"text\"/></td><td><input name=\"amount\" class=\"form-control\" type=\"text\"/></td><td><input name=\"reward\" class=\"form-control\" type=\"text\"/></td><td><input name=\"desc\" class=\"form-control\" type=\"text\"/></td><td><input type=\"submit\" name=\"package_add_submit\" class=\"btn btn-success\" value=\"Add\"/></td></tr></form></table><table class=\"table table-striped table-bordered table-hover\"><tr><th>ID</th><th>Name</th><th>Price</th><th>Reward</th><th>Description</th><th></th></tr>";
$xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "donation.payu.xml");
if ($xml !== false) {
    $options = [];
    $i = 1;
    foreach ($xml->options->children() as $tag => $option) {
        if ($tag == "option") {
            $options[$i]["id"] = intval($option["id"]);
            $options[$i]["name"] = strval($option["name"]);
            $options[$i]["amount"] = floatval($option["amount"]);
            $options[$i]["reward"] = floatval($option["reward"]);
            $options[$i]["desc"] = strval($option["desc"]);
            echo "<form action=\"index.php?module=modules_manager&config=payu\" method=\"post\"><tr>";
            echo "<td><input name=\"id\" class=\"form-control\" type=\"text\" value=\"" . $options[$i]["id"] . "\" /></td>";
            echo "<td><input name=\"name\" class=\"form-control\" type=\"text\" value=\"" . $options[$i]["name"] . "\" /></td>";
            echo "<td><input name=\"amount\" class=\"form-control\" type=\"text\" value=\"" . $options[$i]["amount"] . "\" /></td>";
            echo "<td><input name=\"reward\" class=\"form-control\" type=\"text\" value=\"" . $options[$i]["reward"] . "\" /></td>";
            echo "<td><input name=\"desc\" class=\"form-control\" type=\"text\" value=\"" . $options[$i]["desc"] . "\" /></td>";
            echo "<td><input type=\"submit\" name=\"package_edit_submit\" class=\"btn btn-success\" value=\"Save\"/><a href=\"index.php?module=modules_manager&config=payu&delete=" . $option["id"] . "\" class=\"btn btn-danger\"><i class=\"fa fa-remove\"></i></a></td>";
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
    $xmlPath = __PATH_MODULE_CONFIGS__ . "donation.payu.xml";
    $xml = simplexml_load_file($xmlPath);
    $xml->active = $_POST["setting_1"];
    $xml->pos_id = $_POST["setting_2"];
    $xml->pos_auth_key = $_POST["setting_3"];
    $xml->first_md5_key = $_POST["setting_4"];
    $xml->second_md5_key = $_POST["setting_5"];
    $xml->credit_config = $_POST["setting_6"];
    $save2 = $xml->asXML($xmlPath);
    if ($save2) {
        message("success", "[PayU.pl] Settings successfully saved.");
    } else {
        message("error", "[PayU.pl] There has been an error while saving changes.");
    }
}
function arrayToXML($array)
{
    $sxe = new SimpleXMLElement("<settings/>");
    $sxe->addChild("active", $array["active"]);
    $sxe->addChild("pos_id", $array["pos_id"]);
    $sxe->addChild("pos_auth_key", $array["pos_auth_key"]);
    $sxe->addChild("first_md5_key", $array["first_md5_key"]);
    $sxe->addChild("second_md5_key", $array["second_md5_key"]);
    $sxe->addChild("credit_config", $array["credit_config"]);
    $options = $sxe->addChild("options");
    foreach ($array["options"] as $thisOpt) {
        $option = $options->addChild("option");
        $option->addAttribute("id", $thisOpt["id"]);
        $option->addAttribute("name", $thisOpt["name"]);
        $option->addAttribute("amount", $thisOpt["amount"]);
        $option->addAttribute("reward", $thisOpt["reward"]);
        $option->addAttribute("desc", $thisOpt["desc"]);
    }
    return $sxe->asXML();
}

?>