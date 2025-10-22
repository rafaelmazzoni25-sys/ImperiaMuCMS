<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h2>UserCP Settings</h2>\n";
if (isset($_GET["section_delete"])) {
    deletemainsection(intval($_GET["section_delete"]));
}
if (isset($_GET["module_delete"]) && isset($_GET["section"])) {
    deleteusercpmodule(intval($_GET["module_delete"]), intval($_GET["section"]));
}
if (isset($_GET["quick_delete"])) {
    deletequickmodule(intval($_GET["quick_delete"]));
}
if (check_value($_POST["submit_changes"])) {
    savechanges();
}
if (check_value($_POST["submit_section_changes"])) {
    savesectionchanges();
}
if (check_value($_POST["submit_modules_changes"])) {
    savemoduleschanges();
}
if (check_value($_POST["submit_quick_changes"])) {
    savequickmoduleschanges();
}
if (check_value($_POST["section_add"])) {
    addmainsection();
}
if (check_value($_POST["module_add"])) {
    addusercpmodule();
}
if (check_value($_POST["quick_add"])) {
    addquickmodule();
}
loadModuleConfigs("usercp");
$main_menu = mconfig("main_menu");
$quick_menu = mconfig("quick_menu");
$userCP = new UserCP();
$main_menu_sections = $userCP->create_main_manu($main_menu);
$quick_menu_modules = $userCP->create_quick_menu($quick_menu);
$_SESSION["token"] = time();
echo "<!--<form action=\"\" method=\"post\">-->\n<form action=\"index.php?module=modules_manager&amp;config=usercp\" method=\"post\">\n    <input type=\"hidden\" name=\"token\" value=\"";
echo $_SESSION["token"];
echo "\"/>\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\n        <tr>\n            <th width=\"70%\">Status<br/><span>Enable/disable the UserCP module.</span></th>\n            <td width=\"30%\">\n                ";
echo enabledisableCheckboxes("setting_1", mconfig("active"), "Enabled", "Disabled");
echo "            </td>\n        </tr>\n        <tr>\n            <td colspan=\"2\"><input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\" class=\"btn btn-success\" style=\"width: 100%;\"/></td>\n        </tr>\n    </table>\n</form>\n\n<form action=\"index.php?module=modules_manager&amp;config=usercp\" method=\"post\">\n    <input type=\"hidden\" name=\"token\" value=\"";
echo $_SESSION["token"];
echo "\"/>\n    <hr>\n    <h4 id=\"headMain\">Main Menu Categories</h4>\n    <table class=\"table table-striped table-bordered table-hover\">\n        <tr>\n            <th>Name</th>\n            <th>Custom</th>\n            <th>Active</th>\n        </tr>\n        ";
foreach ($main_menu_sections as $section) {
    echo "<tr>";
    if ($section["name"] == "myaccount_txt_21" || $section["name"] == "myaccount_txt_30" || $section["name"] == "myaccount_txt_55") {
        echo "<td width=\"40%\">" . lang($section["name"], true) . "<input type=\"hidden\" name=\"section_name[" . $section["id"] . "]\" class=\"form-control\" value=\"" . $section["name"] . "\"/></td>";
        $custom = "no";
    } else {
        echo "<td width=\"40%\"><input type=\"text\" name=\"section_name[" . $section["id"] . "]\" class=\"form-control\" value=\"" . $section["name"] . "\"/></td>";
        if (0 < count($section["modules"])) {
            $custom = "yes";
        } else {
            $custom = "<a href=\"index.php?module=modules_manager&amp;config=usercp&amp;section_delete=" . $section["id"] . "&amp;token=" . $_SESSION["token"] . "\" onclick=\"return confirm('Delete category " . $section["name"] . " with all modules?')\" class=\"btn btn-danger\">Delete</a>";
        }
    }
    echo "<td width=\"40%\">" . $custom . "</td>";
    echo "<td width=\"20%\">";
    echo enabledisableCheckboxes("section_active[" . $section["id"] . "]", $section["active"], "Yes", "No");
    echo "</td><tr>";
}
echo "        <tr>\n            <td colspan=\"3\" align=\"right\"><input type=\"submit\" name=\"submit_section_changes\" value=\"Save Section Changes\" class=\"btn btn-success\" style=\"width: 100%;\"/></td>\n        </tr>\n    </table>\n</form>\n\n<form action=\"index.php?module=modules_manager&amp;config=usercp\" method=\"post\">\n    <input type=\"hidden\" name=\"token\" value=\"";
echo $_SESSION["token"];
echo "\"/>\n    <hr>\n    <h4>Add Main Menu Category</h4>\n    <table class=\"table table-striped table-bordered table-hover\">\n        <tr>\n            <th>Name</th>\n        </tr>\n        <tr>\n            <td><input name=\"section_name\" class=\"form-control\" type=\"text\" value=\"\"/></td>\n        </tr>\n        <tr>\n            <td colspan=\"1\" align=\"right\"><input type=\"submit\" name=\"section_add\" class=\"btn btn-success\" value=\"Add\" style=\"width: 100%;\"/></td>\n        </tr>\n    </table>\n</form>\n\n<form action=\"index.php?module=modules_manager&amp;config=usercp\" method=\"post\">\n    <input type=\"hidden\" name=\"token\" value=\"";
echo $_SESSION["token"];
echo "\"/>\n    <hr>\n    <h3>Manage UserCP Main Menu</h3>\n    <table class=\"table table-striped table-bordered table-hover\">\n        <tr>\n            <th>Section</th>\n            <th>Name</th>\n            <th>Description</th>\n            <th>Module</th>\n            <th>Icon</th>\n            <th>Config File</th>\n        </tr>\n        <tr>\n            <td>\n                <select class=\"form-control\" name=\"module_section\">\n                    <option value=\"-1\">--Select section--</option>\n                    ";
foreach ($main_menu_sections as $section) {
    if ($section["name"] == "myaccount_txt_21" || $section["name"] == "myaccount_txt_30" || $section["name"] == "myaccount_txt_55") {
        $name = lang($section["name"], true);
    } else {
        $name = $section["name"];
    }
    echo "<option value=\"" . $section["id"] . "\">" . $name . "</option>";
}
echo "                </select>\n            </td>\n            <td><input name=\"module_name\" class=\"form-control\" type=\"text\" value=\"\" placeholder=\"Reset Character\"/></td>\n            <td><input name=\"module_desc\" class=\"form-control\" type=\"text\" value=\"\" placeholder=\"Reset your character.\"/></td>\n            <td><input name=\"module_module\" class=\"form-control\" type=\"text\" value=\"\" placeholder=\"usercp/reset\"/></td>\n            <td><input name=\"module_icon\" class=\"form-control\" type=\"text\" value=\"\" placeholder=\"CSS Class (e.g. 'icon-reset')\"/></td>\n            <td><input name=\"module_config\" class=\"form-control\" type=\"text\" value=\"\" placeholder=\"usercp.reset\"/></td>\n        </tr>\n        <tr>\n            <td colspan=\"6\" align=\"right\"><input type=\"submit\" name=\"module_add\" class=\"btn btn-success\" value=\"Add\" style=\"width: 100%;\"/></td>\n        </tr>\n    </table>\n</form>\n\n<form action=\"index.php?module=modules_manager&amp;config=usercp\" method=\"post\">\n    <input type=\"hidden\" name=\"token\" value=\"";
echo $_SESSION["token"];
echo "\"/>\n\n    ";
foreach ($main_menu_sections as $section) {
    if ($section["name"] == "myaccount_txt_21" || $section["name"] == "myaccount_txt_30" || $section["name"] == "myaccount_txt_55") {
        $section_name = lang($section["name"], true);
    } else {
        $section_name = $section["name"];
    }
    echo "        <hr><h4 id=\"headCustom\">";
    echo $section_name;
    echo "</h4>\n        <table class=\"table table-striped table-bordered table-hover\">\n            <tr>\n                <th>Name</th>\n                <th>Custom</th>\n                <th>Hidden</th>\n            </tr>\n            ";
    foreach ($section["modules"] as $module) {
        if (!$module["custom"]) {
            $name = lang($module["name"], true);
            $custom = "no";
        } else {
            $name = $module["name"];
            $custom = "<a href=\"index.php?module=modules_manager&amp;config=usercp&amp;module_delete=" . $module["id"] . "&amp;section=" . $section["id"] . "&amp;token=" . $_SESSION["token"] . "\" onclick=\"return confirm('Delete modul " . $module["name"] . "?')\" class=\"btn btn-danger\">Delete</a>";
        }
        echo "<tr>";
        echo "<td width=\"40%\">" . $name . "</td>";
        echo "<td width=\"40%\">" . $custom . "</td>";
        echo "<td width=\"20%\">";
        echo enabledisableCheckboxes("hidden[" . $section["id"] . "][" . $module["id"] . "]", $module["hidden"], "Yes", "No");
        echo "</td><tr>";
    }
    echo "        </table>\n    ";
}
echo "\n    \n    <table class=\"table table-striped table-bordered table-hover\">\n        <tr>\n            <td align=\"right\"><input type=\"submit\" name=\"submit_modules_changes\" value=\"Save Modules Changes\" class=\"btn btn-success\" style=\"width: 100%;\"/></td>\n        </tr>\n    </table>\n</form>\n\n<form action=\"index.php?module=modules_manager&amp;config=usercp\" method=\"post\">\n    <input type=\"hidden\" name=\"token\" value=\"";
echo $_SESSION["token"];
echo "\"/>\n    <hr>\n    <h3 id=\"headQuick\">Quick Menu Modules</h3>\n    <table class=\"table table-striped table-bordered table-hover\">\n        <tr>\n            <th>Name</th>\n            <th>Custom</th>\n            <th>Hidden</th>\n        </tr>\n        ";
foreach ($quick_menu_modules as $module) {
    echo "<tr>";
    if (!$module["custom"]) {
        echo "<td width=\"40%\">" . lang($module["name"], true) . "</td>";
        echo "<td width=\"40%\">no</td>";
    } else {
        echo "<td width=\"40%\">" . $module["name"] . "</td>";
        echo "<td width=\"40%\">";
        echo "<a href=\"index.php?module=modules_manager&amp;config=usercp&amp;quick_delete=" . $module["id"] . "&amp;token=" . $_SESSION["token"] . "\" onclick=\"return confirm('Delete quick modul " . $module["name"] . "?')\" class=\"btn btn-danger\">Delete</a>";
        echo "</td>";
    }
    echo "<td width=\"20%\">";
    echo enabledisableCheckboxes("quick_hidden[" . $module["id"] . "]", $module["hidden"], "Yes", "No");
    echo "</td><tr>";
}
echo "        <tr>\n            <td colspan=\"3\" align=\"right\"><input type=\"submit\" name=\"submit_quick_changes\" value=\"Save Quick Modules Changes\" class=\"btn btn-success\" style=\"width: 100%;\"/></td>\n        </tr>\n    </table>\n</form>\n\n\n<form action=\"index.php?module=modules_manager&amp;config=usercp\" method=\"post\">\n    <input type=\"hidden\" name=\"token\" value=\"";
echo $_SESSION["token"];
echo "\"/>\n    <hr>\n    <h4>Add Quick Menu Modules</h4>\n    <table class=\"table table-striped table-bordered table-hover\">\n        <tr>\n            <th>Name</th>\n            <th>Module</th>\n            <th>Config File</th>\n            <th>Class</th>\n        </tr>\n        <tr>\n            <td><input name=\"quick_name\" class=\"form-control\" type=\"text\" value=\"\" placeholder=\"Reset Character\"/></td>\n            <td><input name=\"quick_module\" class=\"form-control\" type=\"text\" value=\"\" placeholder=\"usercp/reset\"/></td>\n            <td><input name=\"quick_config\" class=\"form-control\" type=\"text\" value=\"\" placeholder=\"usercp.reset\"/></td>\n            <td><input name=\"quick_class\" class=\"form-control\" type=\"text\" value=\"\" placeholder=\"CSS Class (e.g. 'special')\"/></td>\n        </tr>\n        <tr>\n            <td colspan=\"4\" align=\"right\"><input type=\"submit\" name=\"quick_add\" class=\"btn btn-success\" value=\"Add\" style=\"width: 100%;\"/></td>\n        </tr>\n    </table>\n</form>";
function validToken()
{
    
    $ok = true;
    if ($_SESSION["token"] != $_POST["token"]) {
        message("info", "Form was already send.");
        $ok = false;
    }
    return $ok;
}
function validTokenGet()
{
    $_GET;
    $ok = true;
    if ($_SESSION["token"] != $_GET["token"]) {
        message("info", "Incorrect token.");
        $ok = false;
    }
    return $ok;
}
function validatePost()
{
    
    $ok = true;
    foreach ($_POST as $setting) {
        if (!check_value($setting)) {
            message("error", "Missing data (complete all fields).");
            $ok = false;
            return $ok;
        }
    }
}
function ShowSaveMsg($save)
{
    if ($save) {
        message("success", "Settings successfully saved.");
    } else {
        message("error", "There has been an error while saving changes.");
    }
}
function saveChanges()
{
    
    if (!validtoken() || !validatepost()) {
        return NULL;
    }
    $userCP = new UserCP();
    $save = $userCP->SaveActive($_POST["setting_1"]);
    showsavemsg($save);
}
function saveSectionChanges()
{
    
    if (!validtoken() || !validatepost()) {
        return NULL;
    }
    $userCP = new UserCP();
    $save = $userCP->SaveSection($_POST["section_name"], $_POST["section_active"]);
    showsavemsg($save);
}
function saveModulesChanges()
{
    
    if (!validtoken() || !validatepost()) {
        return NULL;
    }
    $userCP = new UserCP();
    $save = $userCP->SaveModules($_POST["hidden"]);
    showsavemsg($save);
}
function saveQuickModulesChanges()
{
    
    if (!validtoken() || !validatepost()) {
        return NULL;
    }
    $userCP = new UserCP();
    $save = $userCP->SaveQuickModules($_POST["quick_hidden"]);
    showsavemsg($save);
}
function addMainSection()
{
    
    if (!validtoken() || !validatepost()) {
        return NULL;
    }
    $userCP = new UserCP();
    $add = $userCP->AddSection($_POST["section_name"]);
    if ($add) {
        message("success", "Main menu category successfully add.");
    } else {
        message("error", "There has been an error while adding main menucategory.");
    }
}
function addUserCPModule()
{
    
    if (!validtoken() || !validatepost()) {
        return NULL;
    }
    $sid = intval($_POST["module_section"]);
    $m = new UserCPModule();
    $m->name = $_POST["module_name"];
    $m->desc = $_POST["module_desc"];
    $m->module = $_POST["module_module"];
    $m->config = $_POST["module_config"];
    $m->icon = $_POST["module_icon"];
    $userCP = new UserCP();
    $add = $userCP->AddModule($m, $sid);
    if ($add) {
        message("success", "Module successfully add.");
    } else {
        message("error", "There has been an error while adding module.");
    }
}
function addQuickModule()
{
    
    if (!validtoken()) {
        return NULL;
    }
    if (!check_value($_POST["quick_name"]) || !check_value($_POST["quick_module"]) || !check_value($_POST["quick_config"])) {
        message("error", "Missing data (complete all fields).");
    }
    $qm = new UserCPQuickModul();
    $qm->name = $_POST["quick_name"];
    $qm->module = $_POST["quick_module"];
    $qm->config = $_POST["quick_config"];
    $qm->class = $_POST["quick_class"];
    $userCP = new UserCP();
    $add = $userCP->AddQuickModule($qm);
    if ($add) {
        message("success", "Quick module successfully add.");
    } else {
        message("error", "There has been an error while adding quick module.");
    }
}
function deleteMainSection($id)
{
    if (!validtokenget()) {
        return NULL;
    }
    $userCP = new UserCP();
    $delete = $userCP->DeleteSection($id);
    if ($delete) {
        message("success", "Main menu category successfully deleted.");
    } else {
        message("error", "There has been an error while deleting category.");
    }
}
function deleteUserCPModule($id, $sid)
{
    if (!validtokenget()) {
        return NULL;
    }
    $userCP = new UserCP();
    $delete = $userCP->DeleteModule($id, $sid);
    if ($delete) {
        message("success", "Module successfully deleted.");
    } else {
        message("error", "There has been an error while deleting module.");
    }
}
function deleteQuickModule($id)
{
    if (!validtokenget()) {
        return NULL;
    }
    $userCP = new UserCP();
    $delete = $userCP->DeleteQuickModule($id);
    if ($delete) {
        message("success", "Quick module successfully deleted.");
    } else {
        message("error", "There has been an error while deleting quick module.");
    }
}

?>