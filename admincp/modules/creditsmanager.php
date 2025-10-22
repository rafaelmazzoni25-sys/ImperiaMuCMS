<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h1 class=\"page-header\">Credit Manager</h1>";
$creditSystem = new CreditSystem($common, new Character(), $dB, $dB2);
if (check_value($_POST["creditsconfig"], $_POST["identifier"], $_POST["credits"], $_POST["transaction"])) {
    if ($common->userExists($_POST["identifier"])) {
        try {
            $creditSystem->setConfigId($_POST["creditsconfig"]);
            $creditSystem->setIdentifier($_POST["identifier"]);
            switch ($_POST["transaction"]) {
                case "add":
                    $creditSystem->addCredits($_POST["credits"]);
                    message("success", "Transaction completed.");
                    break;
                case "subtract":
                    $creditSystem->subtractCredits($_POST["credits"]);
                    message("success", "Transaction completed.");
                    break;
                default:
                    throw new Exception("Invalid transaction.");
            }
        } catch (Exception $ex) {
            message("error", $ex->getMessage());
        }
    } else {
        message("error", "User " . $_POST["identifier"] . " doesn't exist.");
    }
}
echo "<div class=\"row\"><div class=\"col-md-4\"><div class=\"panel panel-primary\"><div class=\"panel-heading\">Add/Subtract Credits</div><div class=\"panel-body\"><form role=\"form\" method=\"post\"><div class=\"form-group\"><label>Configuration:</label>";
echo $creditSystem->buildSelectInput("creditsconfig", 1, "form-control");
echo "</div><div class=\"form-group\"><label for=\"identifier1\">Identifier:</label><input type=\"text\" class=\"form-control\" id=\"identifier1\" name=\"identifier\" placeholder=\"Identifier\"><p class=\"help-block\">Depending on the selected configuration, this can be the userid, username, email or character name.</p></div><div class=\"form-group\"><label for=\"credits1\">Credit(s):</label><input type=\"number\" class=\"form-control\" id=\"credits1\" name=\"credits\" placeholder=\"0\"></div><div class=\"radio\"><label><input type=\"radio\" name=\"transaction\" id=\"transactionRadios1\" value=\"add\" checked> Add</label></div><div class=\"radio\"><label><input type=\"radio\" name=\"transaction\" id=\"transactionRadios1\" value=\"subtract\"> Subtract</label></div><button type=\"submit\" class=\"btn btn-default\">Go</button></form></div></div></div><div class=\"col-md-8\"><div class=\"panel panel-default\"><div class=\"panel-heading\">Logs</div><div class=\"panel-body\">";
$limit = 20;
$page = $_GET["pg"];
if ($page == NULL) {
    $page = 1;
}
$search = NULL;
if (isset($_GET["search"]) && $_GET["search"] != NULL && $_GET["search"] != "") {
    $search = $_GET["search"];
} else {
    unset($_GET["search"]);
    $search = NULL;
}
if (isset($_GET["start"]) && $_GET["start"] != NULL && $_GET["start"] != "") {
    $start = $_GET["start"];
} else {
    unset($_GET["start"]);
    $start = NULL;
}
if (isset($_GET["end"]) && $_GET["end"] != NULL && $_GET["end"] != "") {
    $end = $_GET["end"];
} else {
    unset($_GET["end"]);
    $end = NULL;
}
generateLogPage("creditsmanager", false, $page, $limit, $search, $start, $end);
echo "</div></div></div></div>";

?>