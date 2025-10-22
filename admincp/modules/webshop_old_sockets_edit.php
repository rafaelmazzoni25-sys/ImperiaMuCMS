<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h1 class=\"page-header\">Edit Socket</h1>\r\n";
$Webshop = new Webshop();
loadModuleConfigs("webshop");
if (check_value($_POST["update_socket"])) {
    $Webshop->updateSocket($_REQUEST["id"], $_POST["setting_1"], $_POST["setting_2"], $_POST["setting_3"]);
}
$editItems = $Webshop->loadSocketData($_REQUEST["id"]);
if ($editItems) {
    echo "    <form role=\"form\" method=\"post\">\r\n        <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n            <tr>\r\n                <th>Name<br/><span>Socket Name</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"setting_1\"\r\n                           value=\"";
    echo $editItems["socket_name"];
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Price<br/><span>Socket Price</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"setting_2\"\r\n                           value=\"";
    echo $editItems["price"];
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Status<br/><span>Enable/disable socket option.</span></th>\r\n                <td>\r\n                    ";
    enabledisableCheckboxes("setting_3", $editItems["active"], "Enabled", "Disabled");
    echo "                </td>\r\n            </tr>\r\n        </table>\r\n        <button type=\"submit\" class=\"btn btn-large btn-block btn-success\" name=\"update_socket\" value=\"ok\">Update\r\n            Socket\r\n        </button>\r\n    </form>\r\n\r\n    ";
}

?>