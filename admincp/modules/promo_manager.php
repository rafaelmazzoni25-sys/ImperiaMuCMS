<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h1 class=\"page-header\">Promo Codes Manager</h1>\r\n";
$Promo = new Promo();
if (isset($_GET["enable"])) {
    $Promo->enableCode($_GET["enable"]);
} else {
    if (isset($_GET["disable"])) {
        $Promo->disableCode($_GET["disable"]);
    }
}
try {
    $codes = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_PROMO ORDER BY id");
    echo "<a class=\"btn btn-success\" href=\"" . admincp_base("promo_codes_add") . "\">ADD NEW CODE</a>";
    echo "<table id=\"promo_codes\" class=\"table table-condensed table-hover\"><thead><tr><th>Code</th><th>Type</th><th>Reward Type</th><th>Owner</th><th>Status</th><th>Action</th></tr></thead><tbody>";
    if (is_array($codes)) {
        foreach ($codes as $thisCode) {
            if ($thisCode["type"] == "1") {
                $type = "Unique";
            } else {
                if ($thisCode["type"] == "2") {
                    $type = "Per account";
                }
            }
            if ($thisCode["reward_type"] == "1") {
                $reward_type = "Gold Coins";
            } else {
                if ($thisCode["reward_type"] == "2") {
                    $reward_type = "Silver Coins";
                } else {
                    if ($thisCode["reward_type"] == "3") {
                        $reward_type = "Platinum Coins";
                    } else {
                        if ($thisCode["reward_type"] == "4") {
                            $reward_type = "Single Item";
                        } else {
                            if ($thisCode["reward_type"] == "5") {
                                $reward_type = "Random Item";
                            } else {
                                if ($thisCode["reward_type"] == "6") {
                                    $reward_type = "Multiple Items";
                                } else {
                                    if ($thisCode["reward_type"] == "7") {
                                        $reward_type = "VIP Subscription";
                                    } else {
                                        if ($thisCode["reward_type"] == "8") {
                                            $reward_type = "WCoinC";
                                        } else {
                                            if ($thisCode["reward_type"] == "9") {
                                                $reward_type = "Goblin Points";
                                            } else {
                                                if ($thisCode["reward_type"] == "10") {
                                                    $reward_type = "Zen";
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            if ($thisCode["owner"] == NULL) {
                $thisCode["owner"] = "--";
            }
            if ($thisCode["active"] == "1") {
                $active = "<a class=\"btn btn-danger btn-sm\" href=\"" . admincp_base("promo_manager&disable=" . $thisCode["id"]) . "\"><i class=\"fa fa-times-circle\"></i> Disable</a>";
            } else {
                if ($thisCode["active"] == "0") {
                    $active = "<a class=\"btn btn-success btn-sm\" href=\"" . admincp_base("promo_manager&enable=" . $thisCode["id"]) . "\"><i class=\"fa fa-check-circle\"></i> Enable</a>";
                }
            }
            echo "<tr>";
            echo "<td>" . $thisCode["code"] . "</td>";
            echo "<td>" . $type . "</td>";
            echo "<td>" . $reward_type . "</td>";
            echo "<td>" . $thisCode["owner"] . "</td>";
            if ($thisCode["active"] == "1") {
                echo "<td><span class=\"label label-success\">Active</span></td>";
            } else {
                echo "<td><span class=\"label label-danger\">Inactive</span></td>";
            }
            echo "<td>\r\n                <a class=\"btn btn-default btn-sm\" href=\"" . admincp_base("promo_codes_edit&id=" . $thisCode["id"]) . "\"><i class=\"fa fa-edit\"></i> Edit</a>\r\n                " . $active . "\r\n              </td>";
            echo "</tr>";
        }
    }
    echo "</tbody></table>";
} catch (Exception $ex) {
    message("error", $ex->getMessage());
}

?>