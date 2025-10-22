<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$General = new xGeneral();
if ($General->ftanHCIfo_canUse_j8GsnawwvJ_Module("networking")) {
    echo "    <h2>Networking Manager</h2>\r\n    ";
    if (check_value($_POST["submit"])) {
        if (check_value($_POST["account"])) {
            if (config("SQL_USE_2_DB", true)) {
                $check1 = $dB2->query_fetch_single("SELECT memb___id FROM MEMB_INFO WHERE memb___id = ?", [$_POST["account"]]);
                if ($_POST["grad_1"] != NULL) {
                    $check2 = $dB2->query_fetch_single("SELECT memb___id FROM MEMB_INFO WHERE memb___id = ?", [$_POST["grad_1"]]);
                    if ($check2["memb___id"] != NULL) {
                        $check2 = true;
                    } else {
                        $check2 = false;
                    }
                } else {
                    $check2 = true;
                }
                if ($_POST["grad_2"] != NULL) {
                    $check3 = $dB2->query_fetch_single("SELECT memb___id FROM MEMB_INFO WHERE memb___id = ?", [$_POST["grad_2"]]);
                    if ($check3["memb___id"] != NULL) {
                        $check3 = true;
                    } else {
                        $check3 = false;
                    }
                } else {
                    $check3 = true;
                }
                if ($_POST["grad_3"] != NULL) {
                    $check4 = $dB2->query_fetch_single("SELECT memb___id FROM MEMB_INFO WHERE memb___id = ?", [$_POST["grad_3"]]);
                    if ($check4["memb___id"] != NULL) {
                        $check4 = true;
                    } else {
                        $check4 = false;
                    }
                } else {
                    $check4 = true;
                }
            } else {
                $check1 = $dB->query_fetch_single("SELECT memb___id FROM MEMB_INFO WHERE memb___id = ?", [$_POST["account"]]);
                if ($_POST["grad_1"] != NULL) {
                    $check2 = $dB->query_fetch_single("SELECT memb___id FROM MEMB_INFO WHERE memb___id = ?", [$_POST["grad_1"]]);
                    if ($check2["memb___id"] != NULL) {
                        $check2 = true;
                    } else {
                        $check2 = false;
                    }
                } else {
                    $check2 = true;
                }
                if ($_POST["grad_2"] != NULL) {
                    $check3 = $dB->query_fetch_single("SELECT memb___id FROM MEMB_INFO WHERE memb___id = ?", [$_POST["grad_2"]]);
                    if ($check3["memb___id"] != NULL) {
                        $check3 = true;
                    } else {
                        $check3 = false;
                    }
                } else {
                    $check3 = true;
                }
                if ($_POST["grad_3"] != NULL) {
                    $check4 = $dB->query_fetch_single("SELECT memb___id FROM MEMB_INFO WHERE memb___id = ?", [$_POST["grad_3"]]);
                    if ($check4["memb___id"] != NULL) {
                        $check4 = true;
                    } else {
                        $check4 = false;
                    }
                } else {
                    $check4 = true;
                }
            }
            if ($check1["memb___id"] != NULL && $check2 && $check3 && $check4) {
                $insert = $dB->query("INSERT INTO IMPERIAMUCMS_NETWORKING (AccountID,grad_1,grad_2,grad_3,grad_status) VALUES(?,?,?,?,?)", [$_POST["account"], $_POST["grad_1"], $_POST["grad_2"], $_POST["grad_3"], $_POST["grad_status"]]);
                if ($insert) {
                    message("success", "Data were added successfully.");
                } else {
                    message("error", "Unexpected error occurred.");
                }
            } else {
                message("error", "One of the accounts does not exist.");
            }
        } else {
            message("error", "Invalid values.");
        }
    }
    if (check_value($_POST["save"])) {
        if (check_value($_POST["account"])) {
            if (config("SQL_USE_2_DB", true)) {
                $check1 = $dB2->query_fetch_single("SELECT memb___id FROM MEMB_INFO WHERE memb___id = ?", [$_POST["account"]]);
                if ($_POST["grad_1"] != NULL) {
                    $check2 = $dB2->query_fetch_single("SELECT memb___id FROM MEMB_INFO WHERE memb___id = ?", [$_POST["grad_1"]]);
                    if ($check2["memb___id"] != NULL) {
                        $check2 = true;
                    } else {
                        $check2 = false;
                    }
                } else {
                    $check2 = true;
                }
                if ($_POST["grad_2"] != NULL) {
                    $check3 = $dB2->query_fetch_single("SELECT memb___id FROM MEMB_INFO WHERE memb___id = ?", [$_POST["grad_2"]]);
                    if ($check3["memb___id"] != NULL) {
                        $check3 = true;
                    } else {
                        $check3 = false;
                    }
                } else {
                    $check3 = true;
                }
                if ($_POST["grad_3"] != NULL) {
                    $check4 = $dB2->query_fetch_single("SELECT memb___id FROM MEMB_INFO WHERE memb___id = ?", [$_POST["grad_3"]]);
                    if ($check4["memb___id"] != NULL) {
                        $check4 = true;
                    } else {
                        $check4 = false;
                    }
                } else {
                    $check4 = true;
                }
            } else {
                $check1 = $dB->query_fetch_single("SELECT memb___id FROM MEMB_INFO WHERE memb___id = ?", [$_POST["account"]]);
                if ($_POST["grad_1"] != NULL) {
                    $check2 = $dB->query_fetch_single("SELECT memb___id FROM MEMB_INFO WHERE memb___id = ?", [$_POST["grad_1"]]);
                    if ($check2["memb___id"] != NULL) {
                        $check2 = true;
                    } else {
                        $check2 = false;
                    }
                } else {
                    $check2 = true;
                }
                if ($_POST["grad_2"] != NULL) {
                    $check3 = $dB->query_fetch_single("SELECT memb___id FROM MEMB_INFO WHERE memb___id = ?", [$_POST["grad_2"]]);
                    if ($check3["memb___id"] != NULL) {
                        $check3 = true;
                    } else {
                        $check3 = false;
                    }
                } else {
                    $check3 = true;
                }
                if ($_POST["grad_3"] != NULL) {
                    $check4 = $dB->query_fetch_single("SELECT memb___id FROM MEMB_INFO WHERE memb___id = ?", [$_POST["grad_3"]]);
                    if ($check4["memb___id"] != NULL) {
                        $check4 = true;
                    } else {
                        $check4 = false;
                    }
                } else {
                    $check4 = true;
                }
            }
            if ($check1["memb___id"] != NULL && $check2 && $check3 && $check4) {
                $update = $dB->query("UPDATE IMPERIAMUCMS_NETWORKING SET AccountID = ?, grad_1 = ?, grad_2 = ?, grad_3 = ?, grad_status = ? WHERE id = ?", [$_POST["account"], $_POST["grad_1"], $_POST["grad_2"], $_POST["grad_3"], $_POST["grad_status"], $_POST["id"]]);
                if ($update) {
                    message("success", "Data were updated successfully.");
                } else {
                    message("error", "Unexpected error occurred.");
                }
            } else {
                message("error", "One of the accounts does not exist.");
            }
        } else {
            message("error", "Invalid values.");
        }
    }
    if (check_value($_POST["edit"])) {
        $id = htmlspecialchars($_POST["id"]);
        $data = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_NETWORKING WHERE id = ?", [$id]);
        echo "<table class=\"table table-striped table-bordered table-hover\"><tr><th>AccountID</th><th>Graduate #1</th><th>Graduate #2</th><th>Graduate #3</th><th>Reward</th><th></th></tr><form action=\"index.php?module=networking_manager\" method=\"post\"><tr>";
        echo "<td><input name=\"account\" class=\"form-control\" type=\"text\" value=\"" . $data["AccountID"] . "\"/></td>";
        echo "<td><input name=\"grad_1\" class=\"form-control\" type=\"text\" value=\"" . $data["grad_1"] . "\"/></td>";
        echo "<td><input name=\"grad_2\" class=\"form-control\" type=\"text\" value=\"" . $data["grad_2"] . "\"/></td>";
        echo "<td><input name=\"grad_3\" class=\"form-control\" type=\"text\" value=\"" . $data["grad_3"] . "\"/></td>";
        echo "<td>";
        if ($data["grad_status"] == 0) {
            echo "<input type=\"radio\" name=\"grad_status\" value=\"0\" checked/> None ";
        } else {
            echo "<input type=\"radio\" name=\"grad_status\" value=\"0\" /> None ";
        }
        if ($data["grad_status"] == 1) {
            echo "<input type=\"radio\" name=\"grad_status\" value=\"1\" checked/> Available ";
        } else {
            echo "<input type=\"radio\" name=\"grad_status\" value=\"1\" /> Available ";
        }
        if ($data["grad_status"] == 2) {
            echo "<input type=\"radio\" name=\"grad_status\" value=\"2\" checked/> Claimed ";
        } else {
            echo "<input type=\"radio\" name=\"grad_status\" value=\"2\" /> Claimed ";
        }
        echo "</td>";
        echo "<td><input type=\"hidden\" name=\"id\" value=\"" . $data["id"] . "\"/><input type=\"submit\" name=\"save\" class=\"btn btn-success\" value=\"Save\"/></td>";
        echo "</tr></form></table>";
    } else {
        echo "<table class=\"table table-striped table-bordered table-hover\"><tr><th>AccountID</th><th>Graduate #1</th><th>Graduate #2</th><th>Graduate #3</th><th>Reward</th><th></th></tr><form action=\"index.php?module=networking_manager\" method=\"post\"><tr><td><input name=\"account\" class=\"form-control\" type=\"text\" value=\"\"/></td><td><input name=\"grad_1\" class=\"form-control\" type=\"text\" value=\"\"/></td><td><input name=\"grad_2\" class=\"form-control\" type=\"text\" value=\"\"/></td><td><input name=\"grad_3\" class=\"form-control\" type=\"text\" value=\"\"/></td><td><input type=\"radio\" name=\"grad_status\" value=\"0\" checked/> None <input type=\"radio\" name=\"grad_status\" value=\"1\"/> Available <input type=\"radio\" name=\"grad_status\" value=\"2\"/> Claimed</td><td><input type=\"submit\" name=\"submit\" class=\"btn btn-success\" value=\"Add\"/></td></tr></form></table>";
    }
    $accounts = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_NETWORKING ORDER BY id");
    if (is_array($accounts)) {
        echo "<table id=\"webshop_logs\" class=\"table display\"><thead><tr><th>ID</th><th>AccountID</th><th>Graduate #1</th><th>Graduate #2</th><th>Graduate #3</th><th>Reward</th><th></th></tr></thead><tbody>";
        foreach ($accounts as $thisAccount) {
            if ($thisAccount["grad_status"] == 0) {
                $reward_status = "<span style=\"-moz-border-radius: 3px; -webkit-border-radius: 3px; border-radius: 3px; padding-left: 5px; padding-right: 5px; padding-top: 2px; padding-bottom: 2px; color: #FFFFFF; background-color: #000088;\">none</span>";
            } else {
                if ($thisAccount["grad_status"] == 1) {
                    $reward_status = "<span style=\"-moz-border-radius: 3px; -webkit-border-radius: 3px; border-radius: 3px; padding-left: 5px; padding-right: 5px; padding-top: 2px; padding-bottom: 2px; color: #FFFFFF; background-color: #008800;\">available</span>";
                } else {
                    if ($thisAccount["grad_status"] == 2) {
                        $reward_status = "<span style=\"-moz-border-radius: 3px; -webkit-border-radius: 3px; border-radius: 3px; padding-left: 5px; padding-right: 5px; padding-top: 2px; padding-bottom: 2px; color: #FFFFFF; background-color: #880000;\">claimed</span>";
                    }
                }
            }
            echo "<tr>";
            echo "<td>" . $thisAccount["id"] . "</td>";
            echo "<td>" . $thisAccount["AccountID"] . "</td>";
            echo "<td>" . $thisAccount["grad_1"] . "</td>";
            echo "<td>" . $thisAccount["grad_2"] . "</td>";
            echo "<td>" . $thisAccount["grad_3"] . "</td>";
            echo "<td>" . $reward_status . "</td>";
            echo "<td><form method=\"post\"><input type=\"hidden\" name=\"id\" value=\"" . $thisAccount["id"] . "\"/><input type=\"submit\" name=\"edit\" class=\"btn btn-success\" value=\"Edit\"/></form></td>";
            echo "</tr>";
        }
        echo "</tbody></table>";
    }
} else {
    message("error", "You can't use this module!");
}

?>