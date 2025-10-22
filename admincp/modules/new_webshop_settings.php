<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */
echo "<h1 class=\"page-header\">Webshop Settings</h1>\r\n";
if (check_value($_POST["submit_changes"])) {
    savechanges();
}
loadModuleConfigs("usercp.webshop");
echo "<form action=\"\" method=\"post\">\r\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n        <tr>\r\n            <th>Status<br/><span>Enable/disable the webshop module.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("active", mconfig("active"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Default Category<br/><span>Select default category.</span></th>\r\n            <td>\r\n                <select name=\"default_cat\" class=\"form-control\" onchange=\"loadSubcategories(this.value); return false;\">\r\n                    ";
$activeCats = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_WEBSHOP_CATEGORIES WHERE active = ? ORDER BY title", [1]);
foreach ($activeCats as $thisCat) {
    if ($thisCat["id"] == mconfig("default_cat")) {
        echo "<option value=\"" . $thisCat["id"] . "\" selected=\"selected\">" . $thisCat["title"] . "</option>";
    } else {
        echo "<option value=\"" . $thisCat["id"] . "\">" . $thisCat["title"] . "</option>";
    }
}
echo "                </select>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Default Subcategory<br/><span>Select default subcategory.</span></th>\r\n            <td>\r\n                <select id=\"default_sub\" name=\"default_sub\" class=\"form-control\">\r\n                    ";
$activeSubcats = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_WEBSHOP_SUBCATEGORIES WHERE active = ? ORDER BY title", [1]);
foreach ($activeSubcats as $thisSubcat) {
    if ($thisSubcat["category_id"] == mconfig("default_cat")) {
        $showSubcat = "block";
    } else {
        $showSubcat = "none";
    }
    if ($thisSubcat["id"] == mconfig("default_sub")) {
        echo "<option id=\"defaultCat" . $thisSubcat["category_id"] . "\" style=\"display: " . $showSubcat . "\" value=\"" . $thisSubcat["id"] . "\" selected=\"selected\">" . $thisSubcat["title"] . "</option>";
    } else {
        echo "<option id=\"defaultCat" . $thisSubcat["category_id"] . "\" style=\"display: " . $showSubcat . "\" value=\"" . $thisSubcat["id"] . "\">" . $thisSubcat["title"] . "</option>";
    }
}
echo "                </select>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Gifts<br/><span>Enable/disable the gifting.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("enable_gifts", mconfig("enable_gifts"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n    </table>\r\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n        <tr>\r\n            <th>Global Settings Active<br/><span>Enable/disable the global settings.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("enable_global", mconfig("enable_global"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Max Excellent Options<br/><span>Working only if global settings are active.</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"global_max_exc\" value=\"";
echo mconfig("global_max_exc");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Max Level<br/><span>Working only if global settings are active.</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"global_max_lvl\" value=\"";
echo mconfig("global_max_lvl");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Max Life Option<br/><span>Working only if global settings are active.</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"global_max_life\" value=\"";
echo mconfig("global_max_life");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Max Sockets<br/><span>Working only if global settings are active.</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"global_max_socket\" value=\"";
echo mconfig("global_max_socket");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Payment Type<br/><span>Working only if global settings are active.</span></th>\r\n            <td>\r\n                <table width=\"100%\">\r\n                    <tr>\r\n                        <td><input type=\"checkbox\" name=\"payment_type_platinum\" value=\"1\" ";
if (0 < mconfig("payment_type_platinum")) {
    echo "checked=\"checked\"";
}
echo "/> Platinum Coins</td>\r\n                        <td><input type=\"checkbox\" name=\"payment_type_gold\" value=\"1\" ";
if (0 < mconfig("payment_type_gold")) {
    echo "checked=\"checked\"";
}
echo "/> Gold Coins</td>\r\n                        <td><input type=\"checkbox\" name=\"payment_type_silver\" value=\"1\" ";
if (0 < mconfig("payment_type_silver")) {
    echo "checked=\"checked\"";
}
echo "/> Silver Coins</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td><input type=\"checkbox\" name=\"payment_type_wcoinc\" value=\"1\" ";
if (0 < mconfig("payment_type_wcoinc")) {
    echo "checked=\"checked\"";
}
echo "/> WCoinC</td>\r\n                        <td><input type=\"checkbox\" name=\"payment_type_wcoinp\" value=\"1\" ";
if (0 < mconfig("payment_type_wcoinp")) {
    echo "checked=\"checked\"";
}
echo "/> WCoinP</td>\r\n                        <td><input type=\"checkbox\" name=\"payment_type_gp\" value=\"1\" ";
if (0 < mconfig("payment_type_gp")) {
    echo "checked=\"checked\"";
}
echo "/> Goblin Points</td>\r\n                    </tr>\r\n                </table>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Ancient System<br/><span>Enable/disable the ancient system.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("enable_anc", mconfig("enable_anc"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Harmony System<br/><span>Enable/disable the harmony system.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("enable_harmony", mconfig("enable_harmony"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Socket System<br/><span>Enable/disable the socket system.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("enable_socket", mconfig("enable_socket"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Refinery System (380 lvl opts)<br/><span>Enable/disable the refinary system.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("enable_refinery", mconfig("enable_refinery"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n    </table>\r\n    <input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\" class=\"btn btn-success\"/>\r\n</form>\r\n\r\n<script type=\"text/javascript\">\r\n    function loadSubcategories(cat) {\r\n        \$('[id^=defaultCat]').hide();\r\n        \$('[id^=defaultCat' + cat + ']').show();\r\n        var tmp = \$('[id^=defaultCat' + cat + ']');\r\n        \$('[id^=default_sub]').val(tmp[0].value);\r\n    }\r\n</script>";
function saveChanges()
{
    foreach ($_POST as $setting) {
        if (!check_value($setting)) {
            message("error", "Missing data (complete all fields).");
            return NULL;
        }
    }
    $xmlPath = __PATH_MODULE_CONFIGS__ . "usercp.webshop.xml";
    $xml = simplexml_load_file($xmlPath);
    $xml->active = $_POST["active"];
    $xml->default_cat = $_POST["default_cat"];
    $xml->default_sub = $_POST["default_sub"];
    $xml->enable_gifts = $_POST["enable_gifts"];
    $xml->enable_global = $_POST["enable_global"];
    $xml->global_max_exc = $_POST["global_max_exc"];
    $xml->global_max_lvl = $_POST["global_max_lvl"];
    $xml->global_max_life = $_POST["global_max_life"];
    $xml->global_max_socket = $_POST["global_max_socket"];
    $xml->payment_type_platinum = $_POST["payment_type_platinum"];
    $xml->payment_type_gold = $_POST["payment_type_gold"];
    $xml->payment_type_silver = $_POST["payment_type_silver"];
    $xml->payment_type_wcoinc = $_POST["payment_type_wcoinc"];
    $xml->payment_type_wcoinp = $_POST["payment_type_wcoinp"];
    $xml->payment_type_gp = $_POST["payment_type_gp"];
    $xml->enable_anc = $_POST["enable_anc"];
    $xml->enable_harmony = $_POST["enable_harmony"];
    $xml->enable_socket = $_POST["enable_socket"];
    $xml->enable_refinery = $_POST["enable_refinery"];
    $save = $xml->asXML($xmlPath);
    if ($save) {
        message("success", "Settings successfully saved.");
    } else {
        message("error", "There has been an error while saving changes.");
    }
}

?>