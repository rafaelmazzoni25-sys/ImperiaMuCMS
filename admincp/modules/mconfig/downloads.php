<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h2>Downloads Settings</h2>\r\n";
$downloadTypes = ["1" => "Client", "2" => "Patch", "3" => "Tool"];
if (check_value($_POST["submit_changes"])) {
    savechanges();
}
if (check_value($_POST["downloads_add_submit"])) {
    adddownload($_POST);
}
if (check_value($_POST["downloads_edit_submit"])) {
    editdownload($_POST);
}
if (check_value($_REQUEST["deletelink"])) {
    deletedownload($_REQUEST["deletelink"]);
}
loadModuleConfigs("downloads");
echo "<form action=\"\" method=\"post\">\r\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n        <tr>\r\n            <th>Status<br/><span>Enable/disable the downloads module.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_1", mconfig("active"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Show Client Downloads<br/></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_2", mconfig("show_client_downloads"), "Yes", "No");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Show Patches Downloads<br/></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_3", mconfig("show_patch_downloads"), "Yes", "No");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Show Tools Downloads<br/></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_4", mconfig("show_tool_downloads"), "Yes", "No");
echo "            </td>\r\n        </tr>\r\n\r\n        <tr>\r\n            <th>Show System Requirements<br/></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_5", mconfig("show_req"), "Yes", "No");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Show Drivers<br/></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_6", mconfig("show_drivers"), "Yes", "No");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan=\"2\"><input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\" class=\"btn btn-success\"/>\r\n            </td>\r\n        </tr>\r\n    </table>\r\n</form>\r\n\r\n<hr>\r\n<h3>Manage Downloads</h3>\r\n";
$downloads = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_DOWNLOADS ORDER BY download_type ASC, download_id ASC");
if (is_array($downloads)) {
    echo "\r\n<table class=\"table table-striped table-bordered table-hover\">\r\n\t<tr>\r\n\t\t<th>Title</th>\r\n\t\t<th>Host</th>\r\n\t\t<th>Link</th>\r\n\t\t<th>Size (MB)</th>\r\n\t\t<th>Type</th>\r\n\t\t<th>Open Type</th>\r\n\t\t<th></th>\r\n\t</tr>";
    foreach ($downloads as $thisDownload) {
        echo "\r\n\t<form action=\"index.php?module=modules_manager&config=downloads\" method=\"post\">\r\n\t<input type=\"hidden\" name=\"downloads_edit_id\" value=\"" . $thisDownload["download_id"] . "\"/>\r\n\t<tr>\r\n\t\t<td><input type=\"text\" name=\"downloads_edit_title\" class=\"form-control\" value=\"" . $thisDownload["download_title"] . "\" maxlength=\"100\"/></td>\r\n\t\t<td><input type=\"text\" name=\"downloads_edit_host\" class=\"form-control\" value=\"" . $thisDownload["download_host"] . "\"/></td>\r\n\t\t<td><input type=\"text\" name=\"downloads_edit_link\" class=\"form-control\" value=\"" . $thisDownload["download_link"] . "\"/></td>\r\n\t\t<td><input type=\"text\" name=\"downloads_edit_size\" class=\"form-control\" value=\"" . round($thisDownload["download_size"], 2) . "\"/></td>\r\n\t\t<td>\r\n\t\t\t<select name=\"downloads_edit_type\" class=\"form-control\">";
        downloadtypesselect($downloadTypes, $thisDownload["download_type"]);
        echo "\r\n\t\t\t</select>\r\n\t\t</td>\r\n\t\t<td>\r\n\t\t    <select name=\"downloads_edit_open\" class=\"form-control\">";
        if ($thisDownload["open_type"] == "0") {
            echo "<option value=\"0\" selected=\"selected\">New Window</option>";
        } else {
            echo "<option value=\"0\">New Window</option>";
        }
        if ($thisDownload["open_type"] == "1") {
            echo "<option value=\"1\" selected=\"selected\">Same Window</option>";
        } else {
            echo "<option value=\"1\">Same Window</option>";
        }
        echo "\r\n            </select>\r\n        </td>\r\n\t\t<td rowspan=\"2\">\r\n\t\t<input type=\"submit\" class=\"btn btn-success\" name=\"downloads_edit_submit\" value=\"Save\"/>\r\n\t\t<a href=\"index.php?module=modules_manager&config=downloads&deletelink=" . $thisDownload["download_id"] . "\" class=\"btn btn-danger\"><i class=\"fa fa-remove\"></i></a>\r\n\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t    <td colspan=\"6\"><b>Description:</b>\r\n\t        <textarea class=\"form-control\" name=\"downloads_edit_desc\" maxlength=\"1024\">" . $thisDownload["download_desc"] . "</textarea>\r\n\t    </td>\r\n\t</tr>\r\n\t</form>";
    }
    echo "</table>";
} else {
    message("info", "You have not added any download link.");
}
echo "\r\n<hr>\r\n<h3>Add Download</h3>\r\n<form action=\"index.php?module=modules_manager&config=downloads\" method=\"post\">\r\n    <table class=\"table table-striped table-bordered table-hover\">\r\n        <tr>\r\n            <th>Title</th>\r\n            <th>Host</th>\r\n            <th>Link</th>\r\n            <th>Size (MB)</th>\r\n            <th>Type</th>\r\n            <th>Open Type</th>\r\n        </tr>\r\n        <tr>\r\n            <td><input type=\"text\" name=\"downloads_add_title\" class=\"form-control\" maxlength=\"100\"/></td>\r\n            <td><input type=\"text\" name=\"downloads_add_host\" class=\"form-control\"/></td>\r\n            <td><input type=\"text\" name=\"downloads_add_link\" class=\"form-control\"/></td>\r\n            <td><input type=\"text\" name=\"downloads_add_size\" class=\"form-control\"/></td>\r\n            <td>\r\n                <select name=\"downloads_add_type\" class=\"form-control\">\r\n                    ";
downloadtypesselect($downloadTypes);
echo "                </select>\r\n            </td>\r\n            <td>\r\n                <select name=\"downloads_add_open\" class=\"form-control\">\r\n                    <option value=\"0\">New Window</option>\r\n                    <option value=\"1\">Same Window</option>\r\n                </select>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan=\"6\"><b>Description:</b>\r\n                <textarea class=\"form-control\" name=\"downloads_add_desc\" maxlength=\"1024\"></textarea>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan=\"6\"><input type=\"submit\" name=\"downloads_add_submit\" class=\"btn btn-success\" value=\"Add Download\"/></td>\r\n        </tr>\r\n    </table>\r\n</form>\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n";
function downloadTypesSelect($downloadTypes, $selected = NULL)
{
    foreach ($downloadTypes as $key => $typeOPTION) {
        if (check_value($selected)) {
            if ($key == $selected) {
                echo "<option value=\"" . $key . "\" selected=\"selected\">" . $typeOPTION . "</option>";
            } else {
                echo "<option value=\"" . $key . "\">" . $typeOPTION . "</option>";
            }
        } else {
            echo "<option value=\"" . $key . "\">" . $typeOPTION . "</option>";
        }
    }
}
function saveChanges()
{
    
    foreach ($_POST as $setting) {
        if (!check_value($setting)) {
            message("error", "Missing data (complete all fields).");
            return NULL;
        }
    }
    $xmlPath = __PATH_MODULE_CONFIGS__ . "downloads.xml";
    $xml = simplexml_load_file($xmlPath);
    $xml->active = $_POST["setting_1"];
    $xml->show_client_downloads = $_POST["setting_2"];
    $xml->show_patch_downloads = $_POST["setting_3"];
    $xml->show_tool_downloads = $_POST["setting_4"];
    $xml->show_req = $_POST["setting_5"];
    $xml->show_drivers = $_POST["setting_6"];
    $save = $xml->asXML($xmlPath);
    if ($save) {
        message("success", "Settings successfully saved.");
    } else {
        message("error", "There has been an error while saving changes.");
    }
}
function updateDownloadsCACHE()
{
    global $dB;
    $dbDATA = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_DOWNLOADS ORDER BY download_type ASC, download_id ASC");
    $cacheDATA = BuildCacheData($dbDATA);
    UpdateCache("downloads.cache", $cacheDATA);
}
function addDownload($DATA)
{
    global $dB;
    if (check_value($DATA["downloads_add_title"]) && check_value($DATA["downloads_add_link"]) && check_value($DATA["downloads_add_type"]) && check_value($DATA["downloads_add_open"])) {
        $sqlDATA = [$DATA["downloads_add_title"], $DATA["downloads_add_link"], $DATA["downloads_add_size"], $DATA["downloads_add_host"], $DATA["downloads_add_type"], $DATA["downloads_add_open"], $DATA["downloads_add_desc"]];
        $add = $dB->query("INSERT INTO IMPERIAMUCMS_DOWNLOADS (download_title, download_link, download_size, download_host, download_type, open_type, download_desc) VALUES (?, ?, ?, ?, ?, ?, ?)", $sqlDATA);
        if ($add) {
            updatedownloadscache();
            message("success", "The download link has been successfully added.");
        } else {
            message("error", "There has been an error while adding the download.");
        }
    } else {
        message("error", "Missing data (title, link and type are required fields!).");
    }
}
function editDownload($DATA)
{
    global $dB;
    if (check_value($DATA["downloads_edit_id"]) && check_value($DATA["downloads_edit_title"]) && check_value($DATA["downloads_edit_link"]) && check_value($DATA["downloads_edit_type"]) && check_value($DATA["downloads_edit_open"])) {
        $edit = $dB->query("UPDATE IMPERIAMUCMS_DOWNLOADS SET download_title = '" . $DATA["downloads_edit_title"] . "', download_link = '" . $DATA["downloads_edit_link"] . "', download_size = '" . $DATA["downloads_edit_size"] . "',\r\n                            download_host = '" . $DATA["downloads_edit_host"] . "', download_type = '" . $DATA["downloads_edit_type"] . "', open_type = '" . $DATA["downloads_edit_open"] . "',\r\n                            download_desc = '" . $DATA["downloads_edit_desc"] . "' WHERE download_id = '" . $DATA["downloads_edit_id"] . "'");
        if ($edit) {
            updatedownloadscache();
            message("success", "The download link has been successfully updated.");
        } else {
            message("error", "There has been an error while editing the download.");
        }
    } else {
        message("error", "Missing data (title, link and type are required fields!).");
    }
}
function deleteDownload($id)
{
    global $dB;
    if (check_value($id)) {
        $delete = $dB->query("DELETE FROM IMPERIAMUCMS_DOWNLOADS WHERE download_id = '" . $id . "'");
        if ($delete) {
            updatedownloadscache();
            message("success", "The download link has been successfully deleted.");
        } else {
            message("error", "Invalid download id.");
        }
    } else {
        message("error", "Invalid download id.");
    }
}

?>