<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h1 class=\"page-header\">Credit Configurations</h1>";
$creditSystem = new CreditSystem($common, new Character(), $dB, $dB2);
if (check_value($_POST["new_submit"])) {
    try {
        if (!check_value($_POST["new_title"])) {
            throw new Exception("Please fill all the required fields.");
        }
        if (!check_value($_POST["new_database"])) {
            throw new Exception("Please fill all the required fields.");
        }
        if (!check_value($_POST["new_table"])) {
            throw new Exception("Please fill all the required fields.");
        }
        if (!check_value($_POST["new_credits_column"])) {
            throw new Exception("Please fill all the required fields.");
        }
        if (!check_value($_POST["new_user_column"])) {
            throw new Exception("Please fill all the required fields.");
        }
        if (!check_value($_POST["new_user_column_id"])) {
            throw new Exception("Please fill all the required fields.");
        }
        if (!check_value($_POST["new_checkonline"])) {
            throw new Exception("Please fill all the required fields.");
        }
        $creditSystem->setConfigTitle($_POST["new_title"]);
        $creditSystem->setConfigDatabase($_POST["new_database"]);
        $creditSystem->setConfigTable($_POST["new_table"]);
        $creditSystem->setConfigCreditsColumn($_POST["new_credits_column"]);
        $creditSystem->setConfigUserColumn($_POST["new_user_column"]);
        $creditSystem->setConfigUserColumnId($_POST["new_user_column_id"]);
        $creditSystem->setConfigCheckOnline($_POST["new_checkonline"]);
        $creditSystem->saveConfig();
    } catch (Exception $ex) {
        message("error", $ex->getMessage());
    }
}
if (check_value($_POST["edit_submit"])) {
    try {
        if (!check_value($_POST["edit_id"])) {
            throw new Exception("Please fill all the required fields.");
        }
        if (!check_value($_POST["edit_title"])) {
            throw new Exception("Please fill all the required fields.");
        }
        if (!check_value($_POST["edit_database"])) {
            throw new Exception("Please fill all the required fields.");
        }
        if (!check_value($_POST["edit_table"])) {
            throw new Exception("Please fill all the required fields.");
        }
        if (!check_value($_POST["edit_credits_column"])) {
            throw new Exception("Please fill all the required fields.");
        }
        if (!check_value($_POST["edit_user_column"])) {
            throw new Exception("Please fill all the required fields.");
        }
        if (!check_value($_POST["edit_user_column_id"])) {
            throw new Exception("Please fill all the required fields.");
        }
        if (!check_value($_POST["edit_checkonline"])) {
            throw new Exception("Please fill all the required fields.");
        }
        $creditSystem->setConfigId($_POST["edit_id"]);
        $creditSystem->setConfigTitle($_POST["edit_title"]);
        $creditSystem->setConfigDatabase($_POST["edit_database"]);
        $creditSystem->setConfigTable($_POST["edit_table"]);
        $creditSystem->setConfigCreditsColumn($_POST["edit_credits_column"]);
        $creditSystem->setConfigUserColumn($_POST["edit_user_column"]);
        $creditSystem->setConfigUserColumnId($_POST["edit_user_column_id"]);
        $creditSystem->setConfigCheckOnline($_POST["edit_checkonline"]);
        $creditSystem->editConfig();
    } catch (Exception $ex) {
        message("error", $ex->getMessage());
    }
}
if (check_value($_GET["delete"])) {
    try {
        $creditSystem->setConfigId($_GET["delete"]);
        $creditSystem->deleteConfig();
    } catch (Exception $ex) {
        message("error", $ex->getMessage());
    }
}
echo "<div class=\"row\"><div class=\"col-md-4\">";
if (!check_value($_GET["edit"])) {
    echo "<div class=\"panel panel-primary\"><div class=\"panel-heading\">New Configuration</div><div class=\"panel-body\">";
    echo "<form role=\"form\" action=\"" . admincp_base("creditsconfigs") . "\" method=\"post\">";
    echo "<div class=\"form-group\"><label for=\"input_1\">Title:</label><input type=\"text\" class=\"form-control\" id=\"input_1\" name=\"new_title\"/></div><label>Database:</label><div class=\"radio\"><label><input type=\"radio\" name=\"new_database\" id=\"databaseRadios1\" value=\"MuOnline\" checked> MuOnline</label></div><div class=\"radio\"><label><input type=\"radio\" name=\"new_database\" id=\"databaseRadios1\" value=\"Me_MuOnline\"> Me_MuOnline</label></div><br /><div class=\"form-group\"><label for=\"input_2\">Table:</label><input type=\"text\" class=\"form-control\" id=\"input_2\" name=\"new_table\"/></div><div class=\"form-group\"><label for=\"input_3\">Credits Column:</label><input type=\"text\" class=\"form-control\" id=\"input_3\" name=\"new_credits_column\"/></div><div class=\"form-group\"><label for=\"input_4\">User Column:</label><input type=\"text\" class=\"form-control\" id=\"input_4\" name=\"new_user_column\"/></div><label>User Identifier:</label><div class=\"radio\"><label><input type=\"radio\" name=\"new_user_column_id\" id=\"coRadios1\" value=\"userid\" checked> User ID</label>&nbsp;&nbsp;&nbsp;&nbsp;<label><input type=\"radio\" name=\"new_user_column_id\" id=\"coRadios1\" value=\"username\"> Username</label>&nbsp;&nbsp;&nbsp;&nbsp;<label><input type=\"radio\" name=\"new_user_column_id\" id=\"coRadios1\" value=\"email\"> Email</label>&nbsp;&nbsp;&nbsp;&nbsp;<label><input type=\"radio\" name=\"new_user_column_id\" id=\"coRadios1\" value=\"character\"> Character Name</label></div><br /><label>Check Online Status:</label><div class=\"radio\"><label><input type=\"radio\" name=\"new_checkonline\" id=\"coRadios1\" value=\"1\" checked> Yes</label></div><div class=\"radio\"><label><input type=\"radio\" name=\"new_checkonline\" id=\"coRadios1\" value=\"0\"> No</label></div><br /><button type=\"submit\" name=\"new_submit\" value=\"1\" class=\"btn btn-default\">Save Configuration</button></form></div></div>";
} else {
    $creditSystem->setConfigId($_GET["edit"]);
    $cofigsData = $creditSystem->showConfigs(true);
    echo "<div class=\"panel panel-yellow\"><div class=\"panel-heading\">Edit Configuration</div><div class=\"panel-body\">";
    echo "<form role=\"form\" action=\"" . admincp_base("creditsconfigs") . "\" method=\"post\">";
    echo "<input type=\"hidden\" name=\"edit_id\" value=\"" . $cofigsData["config_id"] . "\"/>";
    echo "<div class=\"form-group\"><label for=\"input_1\">Title:</label>";
    echo "<input type=\"text\" class=\"form-control\" id=\"input_1\" name=\"edit_title\" value=\"" . $cofigsData["config_title"] . "\"/>";
    echo "</div><label>Database:</label><div class=\"radio\"><label>";
    echo "<input type=\"radio\" name=\"edit_database\" id=\"databaseRadios1\" value=\"MuOnline\" " . ($cofigsData["config_database"] == "MuOnline" ? "checked" : NULL) . "> MuOnline";
    echo "</label></div><div class=\"radio\"><label>";
    echo "<input type=\"radio\" name=\"edit_database\" id=\"databaseRadios1\" value=\"Me_MuOnline\" " . ($cofigsData["config_database"] == "Me_MuOnline" ? "checked" : NULL) . "> Me_MuOnline";
    echo "</label></div><br /><div class=\"form-group\"><label for=\"input_2\">Table:</label>";
    echo "<input type=\"text\" class=\"form-control\" id=\"input_2\" name=\"edit_table\" value=\"" . $cofigsData["config_table"] . "\"/>";
    echo "</div><div class=\"form-group\"><label for=\"input_3\">Credits Column:</label>";
    echo "<input type=\"text\" class=\"form-control\" id=\"input_3\" name=\"edit_credits_column\" value=\"" . $cofigsData["config_credits_col"] . "\"/>";
    echo "</div><div class=\"form-group\"><label for=\"input_4\">User Column:</label>";
    echo "<input type=\"text\" class=\"form-control\" id=\"input_4\" name=\"edit_user_column\" value=\"" . $cofigsData["config_user_col"] . "\"/>";
    echo "</div><label>User Identifier:</label><div class=\"radio\"><label>";
    echo "<input type=\"radio\" name=\"edit_user_column_id\" id=\"coRadios1\" value=\"userid\" " . ($cofigsData["config_user_col_id"] == "userid" ? "checked" : NULL) . "> User ID";
    echo "</label>&nbsp;&nbsp;&nbsp;&nbsp;<label>";
    echo "<input type=\"radio\" name=\"edit_user_column_id\" id=\"coRadios1\" value=\"username\" " . ($cofigsData["config_user_col_id"] == "username" ? "checked" : NULL) . "> Username";
    echo "</label>&nbsp;&nbsp;&nbsp;&nbsp;<label>";
    echo "<input type=\"radio\" name=\"edit_user_column_id\" id=\"coRadios1\" value=\"email\" " . ($cofigsData["config_user_col_id"] == "email" ? "checked" : NULL) . "> Email";
    echo "</label>&nbsp;&nbsp;&nbsp;&nbsp;<label>";
    echo "<input type=\"radio\" name=\"edit_user_column_id\" id=\"coRadios1\" value=\"character\" " . ($cofigsData["config_user_col_id"] == "character" ? "checked" : NULL) . "> Character Name";
    echo "</label></div><br /><label>Check Online Status:</label><div class=\"radio\"><label>";
    echo "<input type=\"radio\" name=\"edit_checkonline\" id=\"coRadios1\" value=\"1\" " . ($cofigsData["config_checkonline"] == 1 ? "checked" : NULL) . "> Yes";
    echo "</label></div><div class=\"radio\"><label>";
    echo "<input type=\"radio\" name=\"edit_checkonline\" id=\"coRadios1\" value=\"0\" " . ($cofigsData["config_checkonline"] == 0 ? "checked" : NULL) . "> No";
    echo "</label></div><br /><button type=\"submit\" name=\"edit_submit\" value=\"1\" class=\"btn btn-warning\">Save Configuration</button></form></div></div>";
}
echo "</div><div class=\"col-md-8\"><div class=\"panel panel-default\"><div class=\"panel-heading\">Configurations</div><div class=\"panel-body\">";
$cofigsList = $creditSystem->showConfigs();
if (is_array($cofigsList)) {
    echo "<table class=\"table table-condensed table-hover\"><thead><tr><th>Title</th><th>Database</th><th>Table</th><th>Credits Column</th><th>User Column</th><th>User Column Identifier</th><th>Online Check</th><th></th></tr></thead><tbody>";
    foreach ($cofigsList as $data) {
        $checkOnline = $data["config_checkonline"] ? "<span class=\"label label-success\">Yes</span>" : "<span class=\"label label-default\">No</span>";
        if (check_value($_GET["edit"]) && $_GET["edit"] == $data["config_id"]) {
            echo "<tr class=\"warning\">";
        } else {
            echo "<tr>";
        }
        echo "<td>" . $data["config_title"] . "</td>";
        echo "<td>" . $data["config_database"] . "</td>";
        echo "<td>" . $data["config_table"] . "</td>";
        echo "<td>" . $data["config_credits_col"] . "</td>";
        echo "<td>" . $data["config_user_col"] . "</td>";
        echo "<td>" . $data["config_user_col_id"] . "</td>";
        echo "<td>" . $checkOnline . "</td>";
        echo "<td>";
        echo "<a href=\"" . admincp_base("creditsconfigs&edit=" . $data["config_id"]) . "\" class=\"btn btn-default btn-xs\">Edit</a> ";
        echo "<a href=\"" . admincp_base("creditsconfigs&delete=" . $data["config_id"]) . "\" class=\"btn btn-danger btn-xs\">Delete</a>";
        echo "</td></tr>";
    }
    echo "\n\t\t\t\t</tbody>\n\t\t\t\t</table>";
} else {
    message("warning", "You have not created any configuration.");
}
echo "</div></div></div></div>";

?>