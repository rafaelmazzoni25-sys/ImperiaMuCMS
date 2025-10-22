<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h1 class=\"page-header\">Search Character</h1>\r\n    <form class=\"form-inline\" role=\"form\" method=\"post\">\r\n        <div class=\"form-group\">\r\n            <input type=\"text\" class=\"form-control\" id=\"input_1\" name=\"search_request\" placeholder=\"Character name\"/>\r\n        </div>\r\n        <button type=\"submit\" class=\"btn btn-primary\" name=\"search_character\" value=\"ok\">Search</button>\r\n    </form>\r\n    <br/>\r\n";
if (check_value($_POST["search_character"]) && check_value($_POST["search_request"])) {
    try {
        if (!Validator::Length($_POST["search_request"], 11, 2)) {
            throw new Exception("The name can be 3 to 10 characters long.");
        }
        $searchdb = $dB;
        $searchResults = $searchdb->query_fetch("SELECT TOP 10 Name, AccountID FROM Character WHERE Name LIKE '%" . $_POST["search_request"] . "%'");
        if (!$searchResults) {
            throw new Exception("No results found.");
        }
        if (is_array($searchResults)) {
            echo "<div class=\"row\"><div class=\"col-md-6\"><table class=\"table table-striped table-condensed table-hover\"><thead><tr>";
            echo "<th colspan=\"2\">Search Results for <span style=\"color:red;\"><i>" . $_POST["search_request"] . "</i></span></th>";
            echo "</tr></thead><tbody>";
            foreach ($searchResults as $character) {
                echo "<tr>";
                echo "<td>" . $common->replaceHtmlSymbols($character["Name"]) . "</td>";
                echo "<td style=\"text-align:right;\">";
                echo "<a href=\"" . admincp_base("accountinfo&id=" . $common->retrieveUserID($character["AccountID"])) . "\" class=\"btn btn-xs btn-default\">Account Information</a> ";
                echo "<a href=\"" . admincp_base("editcharacter&name=" . hex_encode($character["Name"])) . "\" class=\"btn btn-xs btn-warning\">Edit Character</a>";
                echo "</td></tr>";
            }
            echo "</tbody></table></div><div class=\"col-md-6\"></div></div>";
        }
    } catch (Exception $ex) {
        message("error", $ex->getMessage());
    }
}

?>