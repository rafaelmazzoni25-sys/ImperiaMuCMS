<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h2>Donation Gateways Settings</h2>\r\n";
if (check_value($_POST["submit_changes"])) {
    savechanges();
}
if (check_value($_POST["package_add_submit"])) {
    if (check_value($_POST["name"]) && check_value($_POST["link"]) && check_value($_POST["image"])) {
        $xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "donation.xml");
        if ($xml !== false) {
            $array = [];
            $array["active"] = trim($xml->active);
            $i = 1;
            $max_id = 0;
            foreach ($xml->custom->children() as $tag => $method) {
                if ($tag == "method") {
                    $array["custom"][$i]["id"] = intval($method["id"]);
                    $array["custom"][$i]["name"] = strval($method["name"]);
                    $array["custom"][$i]["link"] = strval($method["link"]);
                    $array["custom"][$i]["image"] = strval($method["image"]);
                    if ($max_id < intval($method["id"])) {
                        $max_id = intval($method["id"]);
                    }
                    $i++;
                }
            }
            $max_id += 1;
            $array["custom"][$i]["id"] = $max_id;
            $array["custom"][$i]["name"] = strval($_POST["name"]);
            $array["custom"][$i]["link"] = strval($_POST["link"]);
            $array["custom"][$i]["link"] = strval($_POST["link"]);
            $array["custom"][$i]["image"] = strval($_POST["image"]);
            $tmp = arraytoxml($array);
            file_put_contents(__PATH_MODULE_CONFIGS__ . "donation.xml", $tmp);
            message("success", "Custom donation method was successfully created.");
        }
    } else {
        message("error", "Missing data (complete all fields).");
    }
}
if (check_value($_POST["package_edit_submit"])) {
    if (check_value($_POST["id"]) && check_value($_POST["name"]) && check_value($_POST["link"]) && check_value($_POST["image"])) {
        $xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "donation.xml");
        if ($xml !== false) {
            $array = [];
            $array["active"] = trim($xml->active);
            $i = 1;
            foreach ($xml->custom->children() as $tag => $method) {
                if ($tag == "method") {
                    if (intval($method["id"]) == intval($_POST["id"])) {
                        $array["custom"][$i]["id"] = intval($_POST["id"]);
                        $array["custom"][$i]["name"] = strval($_POST["name"]);
                        $array["custom"][$i]["link"] = strval($_POST["link"]);
                        $array["custom"][$i]["image"] = strval($_POST["image"]);
                    } else {
                        $array["custom"][$i]["id"] = intval($method["id"]);
                        $array["custom"][$i]["name"] = strval($method["name"]);
                        $array["custom"][$i]["link"] = strval($method["link"]);
                        $array["custom"][$i]["image"] = strval($method["image"]);
                    }
                    $i++;
                }
            }
            $tmp = arraytoxml($array);
            file_put_contents(__PATH_MODULE_CONFIGS__ . "donation.xml", $tmp);
            message("success", "Donation method #" . intval($_POST["id"]) . " was successfully edited.");
        }
    } else {
        message("error", "Missing data (complete all fields).");
    }
}
if (check_value($_GET["delete"])) {
    $xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "donation.xml");
    if ($xml !== false) {
        $array = [];
        $array["active"] = trim($xml->active);
        $found = false;
        $i = 1;
        foreach ($xml->custom->children() as $tag => $method) {
            if ($tag == "method") {
                if (intval($method["id"]) == intval($_GET["delete"])) {
                    $found = true;
                } else {
                    $array["custom"][$i]["id"] = intval($method["id"]);
                    $array["custom"][$i]["name"] = strval($method["name"]);
                    $array["custom"][$i]["link"] = strval($method["link"]);
                    $array["custom"][$i]["image"] = strval($method["image"]);
                    $i++;
                }
            }
        }
        $tmp = arraytoxml($array);
        file_put_contents(__PATH_MODULE_CONFIGS__ . "donation.xml", $tmp);
        if ($found) {
            message("success", "Donation method #" . intval($_GET["delete"]) . " was successfully deleted.");
        }
    }
}
loadModuleConfigs("donation");
echo "    <form action=\"\" method=\"post\">\r\n        <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n            <tr>\r\n                <th>Status<br/><span>Enable/disable the donation module.</span></th>\r\n                <td>\r\n                    ";
enabledisableCheckboxes("setting_1", mconfig("active"), "Enabled", "Disabled");
echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <td colspan=\"2\"><input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\" class=\"btn btn-success\"/>\r\n                </td>\r\n            </tr>\r\n        </table>\r\n    </form>\r\n\r\n<hr><h3>Manage Custom Donation Methods</h3><table class=\"table table-striped table-bordered table-hover\"><tr><th>Name</th><th>Link</th><th>Image</th><th></th></tr><form action=\"index.php?module=modules_manager&config=donation\" method=\"post\"><tr><td><input name=\"name\" class=\"form-control\" type=\"text\"/></td><td><input name=\"link\" class=\"form-control\" type=\"text\"/></td><td><input name=\"image\" class=\"form-control\" type=\"text\"/></td><td><input type=\"submit\" name=\"package_add_submit\" class=\"btn btn-success\" value=\"Add\"/></td></tr></form></table><p><b>Name</b> - just information<br><b>Link</b> - full link to module, for example http://muonline.com/donation/customMethod/<br><b>Image</b> - name of the image, for example customMethod.png (image must be located in templates/your_template/style/images/)</p><table class=\"table table-striped table-bordered table-hover\"><tr><th>ID</th><th>Name</th><th>Link</th><th>Image</th><th></th></tr>";
$xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "donation.xml");
if ($xml !== false) {
    $custom = [];
    $i = 1;
    foreach ($xml->custom->children() as $tag => $method) {
        if ($tag == "method") {
            $custom[$i]["id"] = intval($method["id"]);
            $custom[$i]["name"] = strval($method["name"]);
            $custom[$i]["link"] = strval($method["link"]);
            $custom[$i]["image"] = strval($method["image"]);
            echo "<form action=\"index.php?module=modules_manager&config=donation\" method=\"post\"><tr>";
            echo "<td><input name=\"id\" class=\"form-control\" type=\"text\" value=\"" . intval($method["id"]) . "\" readonly=\"readonly\" /></td>";
            echo "<td><input name=\"name\" class=\"form-control\" type=\"text\" value=\"" . strval($method["name"]) . "\" /></td>";
            echo "<td><input name=\"link\" class=\"form-control\" type=\"text\" value=\"" . strval($method["link"]) . "\" /></td>";
            echo "<td><input name=\"image\" class=\"form-control\" type=\"text\" value=\"" . strval($method["image"]) . "\" /></td>";
            echo "<td><input type=\"submit\" name=\"package_edit_submit\" class=\"btn btn-success\" value=\"Save\"/><a href=\"index.php?module=modules_manager&config=donation&delete=" . intval($method["id"]) . "\" class=\"btn btn-danger\"><i class=\"fa fa-remove\"></i></a></td>";
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
    $xmlPath = __PATH_MODULE_CONFIGS__ . "donation.xml";
    $xml = simplexml_load_file($xmlPath);
    $xml->active = $_POST["setting_1"];
    $save1 = $xml->asXML($xmlPath);
    if ($save1) {
        message("success", "[Donation] Settings successfully saved.");
    } else {
        message("error", "[Donation] There has been an error while saving changes.");
    }
}
function arrayToXML($array)
{
    $sxe = new SimpleXMLElement("<settings/>");
    $sxe->addChild("active", $array["active"]);
    $custom = $sxe->addChild("custom");
    if (is_array($array["custom"])) {
        foreach ($array["custom"] as $thisMethod) {
            $method = $custom->addChild("method");
            $method->addAttribute("id", $thisMethod["id"]);
            $method->addAttribute("name", $thisMethod["name"]);
            $method->addAttribute("link", $thisMethod["link"]);
            $method->addAttribute("image", $thisMethod["image"]);
        }
    }
    return $sxe->asXML();
}

?>