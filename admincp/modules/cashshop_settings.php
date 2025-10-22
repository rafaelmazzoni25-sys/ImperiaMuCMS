<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h2>Cash Shop Settings</h2>\r\n";
if (check_value($_POST["submit_changes"])) {
    savechanges();
}
$General = new xGeneral();
if (check_value($_POST["activate_module"])) {
    $key = $_POST["license_key"];
    $General->jIhfnHDm_activate_KdiupmNBd_Module("cashshop", $key);
}
$isActivated = $General->jHdksHgYYix_isModule_hDbMVOIfs_Activated("cashshop");
if (!$isActivated) {
    echo "\r\n    <form method=\"post\" action=\"\">\r\n        <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n            <tr>\r\n                <th>License Key<br/><span></span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"license_key\" value=\"\" size=\"30\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td colspan=\"2\"><input type=\"submit\" name=\"activate_module\" value=\"Activate Module\" class=\"btn btn-success\"/>\r\n                </td>\r\n            </tr>\r\n        </table>\r\n    </form>";
} else {
    loadModuleConfigs("usercp.cashshop");
    $cats = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_CASHSHOP_CATEGORIES ORDER BY title");
    $subcats = [];
    $subcat_opt = "<option value=\"all\">All</option>";
    if (isset($cats) && !empty($cats)) {
        foreach ($cats as $cat) {
            if (mconfig("default_cat") == $cat["id"]) {
                $options .= "<option value=\"" . $cat["id"] . "\" selected=\"selected\">" . $cat["title"] . "</option>";
            } else {
                $options .= "<option value=\"" . $cat["id"] . "\">" . $cat["title"] . "</option>";
            }
            $dbdata = $dB->query_fetch("SELECT id, title, category_id FROM IMPERIAMUCMS_CASHSHOP_SUBCATEGORIES WHERE category_id = ? ORDER BY title", [$cat["id"]]);
            $subcats[$cat["id"]] = [];
            if (is_array($dbdata)) {
                foreach ($dbdata as $s) {
                    if (mconfig("default_cat") == $s["category_id"]) {
                        if (mconfig("default_subcat") == $s["id"]) {
                            $subcat_opt .= "<option value=\"" . $s["id"] . "\" selected=\"selected\">" . $s["title"] . "</option>";
                        } else {
                            $subcat_opt .= "<option value=\"" . $s["id"] . "\">" . $s["title"] . "</option>";
                        }
                    }
                    $subcats[$cat["id"]][] = ["id" => $s["id"], "title" => $s["title"]];
                }
            }
        }
    }
    echo "    <form action=\"\" method=\"post\">\r\n        <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n            <tr>\r\n                <th>Status<br/><span>Enable/disable cash shop module.</span></th>\r\n                <td>\r\n                    ";
    enabledisableCheckboxes("setting_1", mconfig("active"), "Enabled", "Disabled");
    echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Default Category<br/><span>Select default category what will be loaded.</span></th>\r\n                <td>\r\n                    <select name=\"setting_2\" class=\"form-control\" id=\"categories\">\r\n                        ";
    echo $options;
    echo "                    </select>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Default Subcategory<br/><span>Select default subcategory what will be loaded.</span></th>\r\n                <td>\r\n                    <select name=\"setting_3\" class=\"form-control\" id=\"subcategories\">\r\n                        ";
    echo $subcat_opt;
    echo "                    </select>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td colspan=\"2\"><input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\" class=\"btn btn-success\"/></td>\r\n            </tr>\r\n        </table>\r\n    </form>\r\n\r\n    <script type=\"text/javascript\">\r\n        ";
    echo "var subcat = " . json_encode($subcats) . ";";
    echo "        \$('#categories').change(function () {\r\n            var catid = \$(this).val();\r\n            var s = \$('#subcategories');\r\n            s.empty();\r\n            s.append('<option value=\"all\">All</option>');\r\n            if (catid != '') {\r\n                for (var i = 0; i < subcat[catid].length; i++) {\r\n                    s.append('<option value=\"' + subcat[catid][i].id + '\">' + subcat[catid][i].title + '</option>');\r\n                }\r\n            }\r\n        });\r\n    </script>\r\n\r\n    ";
}
function saveChanges()
{
    foreach ($_POST as $setting) {
        if (!check_value($setting)) {
            message("error", "Missing data (complete all fields).");
            return NULL;
        }
    }
    $xmlPath = __PATH_MODULE_CONFIGS__ . "usercp.cashshop.xml";
    $xml = simplexml_load_file($xmlPath);
    $xml->active = $_POST["setting_1"];
    $xml->default_cat = $_POST["setting_2"];
    $xml->default_subcat = $_POST["setting_3"];
    $save = $xml->asXML($xmlPath);
    if ($save) {
        message("success", "Settings successfully saved.");
    } else {
        message("error", "There has been an error while saving changes.");
    }
}

?>