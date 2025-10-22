<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h1 class=\"page-header\">Event Registration Manager</h1>\r\n";
$General = new xGeneral();
if ($General->ftanHCIfo_canUse_j8GsnawwvJ_Module("eventregistration")) {
    if (isset($_GET["delete"])) {
        $event_id = htmlspecialchars($_GET["delete"]);
        $delete = $dB->query("DELETE FROM IMPERIAMUCMS_EVENT_REGISTRATION WHERE id = ?", [$event_id]);
        if ($delete) {
            message("success", "Event #" . $event_id . " was successfully deleted.");
        } else {
            message("error", "Unexpected error occurred.");
        }
    }
    try {
        $events = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_EVENT_REGISTRATION ORDER BY id");
        echo "<a class=\"btn btn-success\" href=\"" . admincp_base("eventregistration_add") . "\">ADD NEW EVENT</a>";
        echo "<table id=\"promo_codes\" class=\"table table-condensed table-hover\"><thead><tr><th>ID</th><th>Name</th><th>Start Date</th><th>End Date</th><th>Price</th><th>Status</th><th>Action</th></tr></thead><tbody>";
        if (is_array($events)) {
            foreach ($events as $event) {
                if ($event["price_type"] == "1") {
                    $event["price_type"] = "Platinum Coins";
                } else {
                    if ($event["price_type"] == "2") {
                        $event["price_type"] = "Gold Coins";
                    } else {
                        if ($event["price_type"] == "3") {
                            $event["price_type"] = "Silver Coins";
                        } else {
                            if ($event["price_type"] == "4") {
                                $event["price_type"] = "WCoinC";
                            } else {
                                if ($event["price_type"] == "-4") {
                                    $event["price_type"] = "WCoinP";
                                } else {
                                    if ($event["price_type"] == "5") {
                                        $event["price_type"] = "Goblin Points";
                                    } else {
                                        if ($event["price_type"] == "6") {
                                            $event["price_type"] = "Zen";
                                        } else {
                                            if ($event["price_type"] == "7") {
                                                $event["price_type"] = "Jewel of Bless";
                                            } else {
                                                if ($event["price_type"] == "8") {
                                                    $event["price_type"] = "Jewel of Soul";
                                                } else {
                                                    if ($event["price_type"] == "9") {
                                                        $event["price_type"] = "Jewel of Life";
                                                    } else {
                                                        if ($event["price_type"] == "10") {
                                                            $event["price_type"] = "Jewel of Chaos";
                                                        } else {
                                                            if ($event["price_type"] == "11") {
                                                                $event["price_type"] = "Jewel of Harmony";
                                                            } else {
                                                                if ($event["price_type"] == "12") {
                                                                    $event["price_type"] = "Jewel of Creation";
                                                                } else {
                                                                    if ($event["price_type"] == "13") {
                                                                        $event["price_type"] = "Jewel of Guardian";
                                                                    } else {
                                                                        $customItems = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_WEB_BANK_CUSTOM");
                                                                        foreach ($customItems as $thisItem) {
                                                                            if ($event["price_type"] == $thisItem["ident"]) {
                                                                                $event["price_type"] = $thisItem["name"];
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
                                    }
                                }
                            }
                        }
                    }
                }
                if ($event["status"] == "0") {
                    $status = "<span class=\"label label-danger\">Disabled</span>";
                } else {
                    $status = "<span class=\"label label-success\">Enabled</span>";
                }
                echo "<tr>";
                echo "<td>" . $event["id"] . "</td>";
                echo "<td>" . $event["title"] . "</td>";
                echo "<td>" . date($config["time_date_format"], strtotime($event["start_date"])) . "</td>";
                echo "<td>" . date($config["time_date_format"], strtotime($event["end_date"])) . "</td>";
                echo "<td>" . $event["price"] . " " . $event["price_type"] . "</td>";
                echo "<td>" . $status . "</td>";
                echo "<td>";
                echo "<a class=\"btn btn-default btn-sm\" href=\"" . admincp_base("eventregistration_edit&id=" . $event["id"]) . "\"><i class=\"fa fa-edit\"></i> Edit</a>";
                echo " <a class=\"btn btn-danger btn-sm\" href=\"" . admincp_base("eventregistration_manager&delete=" . $event["id"]) . "\"><i class=\"fa fa-times-circle\"></i> Delete</a>";
                echo "</td></tr>";
            }
        }
        echo "</tbody></table>";
    } catch (Exception $ex) {
        message("error", $ex->getMessage());
    }
}

?>