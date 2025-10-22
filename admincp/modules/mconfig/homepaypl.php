<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h1 class=\"page-header\">Homepay.pl Settings</h1>\n";
if (check_value($_POST["submit_changes"])) {
    savechanges();
}
if (check_value($_POST["package_add_submit"])) {
    if (check_value($_POST["id"]) && check_value($_POST["name"]) && check_value($_POST["netto"]) && check_value($_POST["brutto"]) && check_value($_POST["reward"]) && check_value($_POST["number"]) && check_value($_POST["text"])) {
        $xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "donation.homepaypl.xml");
        if ($xml !== false) {
            $array = [];
            $array["active"] = trim($xml->active);
            $array["user_id"] = trim($xml->user_id);
            $array["credit_config"] = trim($xml->credit_config);
            $i = 1;
            foreach ($xml->options->children() as $tag => $option) {
                if ($tag == "option") {
                    $array["options"][$i]["acc_id"] = intval($option["acc_id"]);
                    $array["options"][$i]["name"] = strval($option["name"]);
                    $array["options"][$i]["netto"] = floatval($option["netto"]);
                    $array["options"][$i]["brutto"] = floatval($option["brutto"]);
                    $array["options"][$i]["reward"] = intval($option["reward"]);
                    $array["options"][$i]["number"] = intval($option["number"]);
                    $array["options"][$i]["text"] = strval($option["text"]);
                    $i++;
                }
            }
            $array["options"][$i]["acc_id"] = intval($_POST["id"]);
            $array["options"][$i]["name"] = strval($_POST["name"]);
            $array["options"][$i]["netto"] = floatval($_POST["netto"]);
            $array["options"][$i]["brutto"] = floatval($_POST["brutto"]);
            $array["options"][$i]["reward"] = intval($_POST["reward"]);
            $array["options"][$i]["number"] = intval($_POST["number"]);
            $array["options"][$i]["text"] = strval($_POST["text"]);
            $tmp = arraytoxml($array);
            file_put_contents(__PATH_MODULE_CONFIGS__ . "donation.homepaypl.xml", $tmp);
            message("success", "Donation package was successfully created.");
        }
    } else {
        message("error", "Missing data (complete all fields).");
    }
}
if (check_value($_POST["package_edit_submit"])) {
    if (check_value($_POST["id"]) && check_value($_POST["name"]) && check_value($_POST["netto"]) && check_value($_POST["brutto"]) && check_value($_POST["reward"]) && check_value($_POST["number"]) && check_value($_POST["text"])) {
        $xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "donation.homepaypl.xml");
        if ($xml !== false) {
            $array = [];
            $array["active"] = trim($xml->active);
            $array["user_id"] = trim($xml->user_id);
            $array["credit_config"] = trim($xml->credit_config);
            $i = 1;
            foreach ($xml->options->children() as $tag => $option) {
                if ($tag == "option") {
                    if (intval($option["acc_id"]) == intval($_POST["id"])) {
                        $array["options"][$i]["acc_id"] = intval($_POST["id"]);
                        $array["options"][$i]["name"] = strval($_POST["name"]);
                        $array["options"][$i]["netto"] = floatval($_POST["netto"]);
                        $array["options"][$i]["brutto"] = floatval($_POST["brutto"]);
                        $array["options"][$i]["reward"] = intval($_POST["reward"]);
                        $array["options"][$i]["number"] = intval($_POST["number"]);
                        $array["options"][$i]["text"] = strval($_POST["text"]);
                    } else {
                        $array["options"][$i]["acc_id"] = intval($option["acc_id"]);
                        $array["options"][$i]["name"] = strval($option["name"]);
                        $array["options"][$i]["netto"] = floatval($option["netto"]);
                        $array["options"][$i]["brutto"] = floatval($option["brutto"]);
                        $array["options"][$i]["reward"] = intval($option["reward"]);
                        $array["options"][$i]["number"] = intval($option["number"]);
                        $array["options"][$i]["text"] = strval($option["text"]);
                    }
                    $i++;
                }
            }
            $tmp = arraytoxml($array);
            file_put_contents(__PATH_MODULE_CONFIGS__ . "donation.homepaypl.xml", $tmp);
            message("success", "Donation package #" . intval($_POST["id"]) . " was successfully edited.");
        }
    } else {
        message("error", "Missing data (complete all fields).");
    }
}
if (check_value($_GET["delete"])) {
    $xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "donation.homepaypl.xml");
    if ($xml !== false) {
        $array = [];
        $array["active"] = trim($xml->active);
        $array["user_id"] = trim($xml->user_id);
        $array["credit_config"] = trim($xml->credit_config);
        $found = false;
        $i = 1;
        foreach ($xml->options->children() as $tag => $option) {
            if ($tag == "option") {
                if (intval($option["acc_id"]) == intval($_GET["delete"])) {
                    $found = true;
                } else {
                    $array["options"][$i]["acc_id"] = intval($option["acc_id"]);
                    $array["options"][$i]["name"] = strval($option["name"]);
                    $array["options"][$i]["netto"] = floatval($option["netto"]);
                    $array["options"][$i]["brutto"] = floatval($option["brutto"]);
                    $array["options"][$i]["reward"] = intval($option["reward"]);
                    $array["options"][$i]["number"] = intval($option["number"]);
                    $array["options"][$i]["text"] = strval($option["text"]);
                    $i++;
                }
            }
        }
        $tmp = arraytoxml($array);
        file_put_contents(__PATH_MODULE_CONFIGS__ . "donation.homepaypl.xml", $tmp);
        if ($found) {
            message("success", "Donation package #" . intval($_GET["delete"]) . " was successfully deleted.");
        }
    }
}
loadModuleConfigs("donation.homepaypl");
$creditSystem = new CreditSystem($common, new Character(), $dB, $dB2);
echo "    <form action=\"\" method=\"post\">\n        <table class=\"table table-striped table-bordered table-hover module_config_tables\">\n            <tr>\n                <th>Status<br/><span>Enable/disable the homepay.pl donation gateway.</span></th>\n                <td>\n                    ";
enabledisableCheckboxes("setting_1", mconfig("active"), "Enabled", "Disabled");
echo "                </td>\n            </tr>\n            <tr>\n                <th>Homepay.pl UserID<br/><span>Homepay.pl UserID identification.</span></th>\n                <td>\n                    <input class=\"form-control\" type=\"text\" name=\"setting_2\" value=\"";
echo mconfig("user_id");
echo "\"/>\n                </td>\n            </tr>\n            <tr>\n                <th>Credit Configuration<br/><span></span></th>\n                <td>\n                    ";
echo $creditSystem->buildSelectInput("setting_3", mconfig("credit_config"), "form-control");
echo "                </td>\n            </tr>\n            <tr>\n                <td colspan=\"2\"><input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\" class=\"btn btn-success\"/>\n                </td>\n            </tr>\n        </table>\n    </form>\n\n<hr><h3>Manage Donation Packages</h3><table class=\"table table-striped table-bordered table-hover\"><tr><th>ID</th><th>SMS Text</th><th>Number</th><th>Price (Netto)</th><th>Price (Brutto)</th><th>Name</th><th>Reward</th><th></th></tr><form action=\"index.php?module=modules_manager&config=homepaypl\" method=\"post\"><tr><td><input name=\"id\" class=\"form-control\" type=\"text\"/></td><td><input name=\"text\" class=\"form-control\" type=\"text\"/></td><td><input name=\"number\" class=\"form-control\" type=\"text\"/></td><td><input name=\"netto\" class=\"form-control\" type=\"text\"/></td><td><input name=\"brutto\" class=\"form-control\" type=\"text\"/></td><td><input name=\"name\" class=\"form-control\" type=\"text\"/></td><td><input name=\"reward\" class=\"form-control\" type=\"text\"/></td><td><input type=\"submit\" name=\"package_add_submit\" class=\"btn btn-success\" value=\"Add\"/></td></tr></form></table><table class=\"table table-striped table-bordered table-hover\"><tr><th>ID</th><th>SMS Text</th><th>Number</th><th>Price (Netto)</th><th>Price (Brutto)</th><th>Name</th><th>Reward</th><th></th></tr>";
$xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "donation.homepaypl.xml");
if ($xml !== false) {
    $options = [];
    $i = 1;
    foreach ($xml->options->children() as $tag => $option) {
        if ($tag == "option") {
            $options[$i]["acc_id"] = intval($option["acc_id"]);
            $options[$i]["name"] = strval($option["name"]);
            $options[$i]["netto"] = floatval($option["netto"]);
            $options[$i]["brutto"] = floatval($option["brutto"]);
            $options[$i]["reward"] = intval($option["reward"]);
            $options[$i]["number"] = intval($option["number"]);
            $options[$i]["text"] = strval($option["text"]);
            echo "<form action=\"index.php?module=modules_manager&config=homepaypl\" method=\"post\"><tr>";
            echo "<td><input name=\"id\" class=\"form-control\" type=\"text\" value=\"" . intval($option["acc_id"]) . "\" /></td>";
            echo "<td><input name=\"text\" class=\"form-control\" type=\"text\" value=\"" . strval($option["text"]) . "\" /></td>";
            echo "<td><input name=\"number\" class=\"form-control\" type=\"text\" value=\"" . intval($option["number"]) . "\" /></td>";
            echo "<td><input name=\"netto\" class=\"form-control\" type=\"text\" value=\"" . floatval($option["netto"]) . "\" /></td>";
            echo "<td><input name=\"brutto\" class=\"form-control\" type=\"text\" value=\"" . floatval($option["brutto"]) . "\" /></td>";
            echo "<td><input name=\"name\" class=\"form-control\" type=\"text\" value=\"" . strval($option["name"]) . "\" /></td>";
            echo "<td><input name=\"reward\" class=\"form-control\" type=\"text\" value=\"" . intval($option["reward"]) . "\" /></td>";
            echo "<td><input type=\"submit\" name=\"package_edit_submit\" class=\"btn btn-success\" value=\"Save\"/><a href=\"index.php?module=modules_manager&config=homepaypl&delete=" . $option["acc_id"] . "\" class=\"btn btn-danger\"><i class=\"fa fa-remove\"></i></a></td>";
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
    $xmlPath = __PATH_MODULE_CONFIGS__ . "donation.homepaypl.xml";
    $xml = simplexml_load_file($xmlPath);
    $xml->active = $_POST["setting_1"];
    $xml->user_id = $_POST["setting_2"];
    $xml->credit_config = $_POST["setting_3"];
    $save = $xml->asXML($xmlPath);
    if ($save) {
        message("success", "[Homepay.pl] Settings successfully saved.");
    } else {
        message("error", "[Homepay.pl] There has been an error while saving changes.");
    }
}
function arrayToXML($array)
{
    $sxe = new SimpleXMLElement("<settings/>");
    $sxe->addChild("active", $array["active"]);
    $sxe->addChild("user_id", $array["user_id"]);
    $sxe->addChild("credit_config", $array["credit_config"]);
    $options = $sxe->addChild("options");
    foreach ($array["options"] as $thisOpt) {
        $option = $options->addChild("option");
        $option->addAttribute("acc_id", $thisOpt["acc_id"]);
        $option->addAttribute("name", $thisOpt["name"]);
        $option->addAttribute("netto", $thisOpt["netto"]);
        $option->addAttribute("brutto", $thisOpt["brutto"]);
        $option->addAttribute("reward", $thisOpt["reward"]);
        $option->addAttribute("number", $thisOpt["number"]);
        $option->addAttribute("text", $thisOpt["text"]);
    }
    return $sxe->asXML();
}

?>