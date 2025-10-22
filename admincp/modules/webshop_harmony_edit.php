<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h1 class=\"page-header\">Edit Harmony</h1>\r\n";
$Webshop = new Webshop();
loadModuleConfigs("webshop");
if (check_value($_POST["update_harmony"])) {
    $Webshop->updateHarmony($_REQUEST["id"], $_POST["setting_1"], $_POST["setting_2"], $_POST["setting_3"], $_POST["setting_4"]);
}
$editItems = $Webshop->loadHarmonyData($_REQUEST["id"]);
if ($editItems) {
    echo "    <form role=\"form\" method=\"post\">\r\n        <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n            <tr>\r\n                <th>Name<br/><span>Harmony Name</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"setting_1\"\r\n                           value=\"";
    echo $editItems["hname"];
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Price<br/><span>Harmony Price</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"setting_2\"\r\n                           value=\"";
    echo $editItems["price"];
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Value<br/><span>Harmony Value - for example, if value is 15, this harmony option can be used only on +15 item</span>\r\n                </th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"setting_4\"\r\n                           value=\"";
    echo $editItems["hvalue"];
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Status<br/><span>Enable/disable harmony option.</span></th>\r\n                <td>\r\n                    ";
    enabledisableCheckboxes("setting_3", $editItems["status"], "Enabled", "Disabled");
    echo "                </td>\r\n            </tr>\r\n        </table>\r\n        <button type=\"submit\" class=\"btn btn-large btn-block btn-success\" name=\"update_harmony\" value=\"ok\">Update\r\n            Socket\r\n        </button>\r\n    </form>\r\n\r\n    ";
}

?>