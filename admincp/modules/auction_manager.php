<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h1 class=\"page-header\">Auction Manager</h1>\r\n";
$General = new xGeneral();
if (check_value($_POST["activate_module"])) {
    $key = $_POST["license_key"];
    $General->jIhfnHDm_activate_KdiupmNBd_Module("auction", $key);
}
$isActivated = $General->jHdksHgYYix_isModule_hDbMVOIfs_Activated("auction");
if (!$isActivated) {
    echo "\r\n    <form method=\"post\" action=\"\">\r\n        <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n            <tr>\r\n                <th>License Key<br/><span></span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"license_key\" value=\"\" size=\"30\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td colspan=\"2\"><input type=\"submit\" name=\"activate_module\" value=\"Activate Module\" class=\"btn btn-success\"/>\r\n                </td>\r\n            </tr>\r\n        </table>\r\n    </form>";
} else {
    $Auction = new Auction();
    if (isset($_GET["delete"])) {
        $auction_id = htmlspecialchars($_GET["delete"]);
        $delete = $dB->query("DELETE FROM IMPERIAMUCMS_AUCTIONS WHERE id = ?", [$auction_id]);
        if ($delete) {
            message("success", "Auction #" . $auction_id . " was successfully deleted.");
        } else {
            message("error", "Unexpected error occurred.");
        }
    }
    try {
        $auctions = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_AUCTIONS ORDER BY id");
        echo "<a class=\"btn btn-success\" href=\"" . admincp_base("auction_add") . "\">ADD NEW AUCTION</a>";
        echo "<table id=\"promo_codes\" class=\"table table-condensed table-hover\"><thead><tr><th>Name</th><th>Author</th><th>Start</th><th>End</th><th>Starting Bid</th><th>Action</th></tr></thead><tbody>";
        if (is_array($auctions)) {
            foreach ($auctions as $auction) {
                echo "<tr>";
                echo "<td>" . $auction["name"] . "</td>";
                echo "<td>" . $auction["author"] . "</td>";
                echo "<td>" . date($config["time_date_format_logs"], strtotime($auction["start_date"])) . "</td>";
                echo "<td>" . date($config["time_date_format_logs"], strtotime($auction["end_date"])) . "</td>";
                echo "<td>" . $auction["bid"] . "</td>";
                echo "<td>";
                echo "<a class=\"btn btn-default btn-sm\" href=\"" . admincp_base("auction_edit&id=" . $auction["id"]) . "\"><i class=\"fa fa-edit\"></i> Edit</a>";
                echo " <a class=\"btn btn-danger btn-sm\" href=\"" . admincp_base("auction_manager&delete=" . $auction["id"]) . "\"><i class=\"fa fa-times-circle\"></i> Delete</a>";
                echo "</td></tr>";
            }
        }
        echo "</tbody></table>";
    } catch (Exception $ex) {
        message("error", $ex->getMessage());
    }
}

?>