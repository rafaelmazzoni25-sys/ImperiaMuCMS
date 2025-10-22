<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$General = new xGeneral();
if ($General->ftanHCIfo_canUse_j8GsnawwvJ_Module("cashshopgifts")) {
    $rewards = ["1" => ["Name" => "Seal of Exp ( Bùa Exp )", "UniqueID1" => 673, "UniqueID2" => 1128, "UniqueID3" => 1795, "InventoryType" => 1], "2" => ["Name" => "Seal of Weath ( Bùa Thiên Sứ )", "UniqueID1" => 673, "UniqueID2" => 1127, "UniqueID3" => 1790, "InventoryType" => 1], "3" => ["Name" => "Scroll of Speed ( Bùa Tốc Độ )", "UniqueID1" => 673, "UniqueID2" => 914, "UniqueID3" => 1171, "InventoryType" => 1], "4" => ["Name" => "Scroll of Protection ( Bùa Phòng Thủ )", "UniqueID1" => 673, "UniqueID2" => 915, "UniqueID3" => 1175, "InventoryType" => 1], "5" => ["Name" => "Scroll of Damage ( Bùa Sát Thương )", "UniqueID1" => 673, "UniqueID2" => 916, "UniqueID3" => 1179, "InventoryType" => 1], "6" => ["Name" => "Scroll of Magic ( Bùa phép thuật )", "UniqueID1" => 673, "UniqueID2" => 917, "UniqueID3" => 1183, "InventoryType" => 1], "7" => ["Name" => "Scroll of HP ( Bùa HP )", "UniqueID1" => 673, "UniqueID2" => 918, "UniqueID3" => 1187, "InventoryType" => 1], "8" => ["Name" => "Scroll of Mana ( Bùa Mana )", "UniqueID1" => 673, "UniqueID2" => 919, "UniqueID3" => 1191, "InventoryType" => 1], "9" => ["Name" => "Pet Panda", "UniqueID1" => 673, "UniqueID2" => 1056, "UniqueID3" => 1590, "InventoryType" => 1], "10" => ["Name" => "Panda Ring ( Nhẫn Panda )", "UniqueID1" => 673, "UniqueID2" => 1059, "UniqueID3" => 1599, "InventoryType" => 1]];
    if (check_value($_POST["submit"])) {
        if ($_POST["account"] != NULL && !empty($_POST["account"])) {
            if ($common->userExists($_POST["account"])) {
                foreach ($rewards as $key => $thisReward) {
                    if ($_POST["reward-" . $key]) {
                        $insert = $dB->query("exec WZ_IBS_AddItem ?, ?, ?, ?, ?", [$_POST["account"], $thisReward["UniqueID1"], $thisReward["UniqueID2"], $thisReward["UniqueID3"], $thisReward["InventoryType"]]);
                        if ($insert) {
                            message("success", "Gift " . $thisReward["Name"] . " was successfully sent to " . $_POST["account"] . ".");
                        } else {
                            message("error", "AccountID does not exist.");
                        }
                    }
                }
            } else {
                message("error", "AccountID does not exist.");
            }
        } else {
            if (config("SQL_USE_2_DB", true)) {
                $accounts = $dB2->query_fetch("SELECT * FROM MEMB_INFO");
            } else {
                $accounts = $dB->query_fetch("SELECT * FROM MEMB_INFO");
            }
            foreach ($accounts as $thisAccount) {
                foreach ($rewards as $key => $thisReward) {
                    if ($_POST["reward-" . $key]) {
                        $insert = $dB->query("exec WZ_IBS_AddItem ?, ?, ?, ?, ?", [$thisAccount["memb___id"], $thisReward["UniqueID1"], $thisReward["UniqueID2"], $thisReward["UniqueID3"], $thisReward["InventoryType"]]);
                        if ($insert) {
                            message("success", "Gift " . $thisReward["Name"] . " was successfully sent to " . $thisAccount["memb___id"] . ".");
                        } else {
                            message("error", "AccountID does not exist.");
                        }
                    }
                }
            }
            message("success", "Gift was successfully sent to " . count($accounts) . " players.");
        }
    }
    echo "    <h2>Cash Shop Gift</h2>\r\n    <form method=\"post\" action=\"\">\r\n        <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n            <tr>\r\n                <th>AccountID<br/><span>Leave empty if you would like to send gift to all existing accounts.</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"account\" value=\"\" placeholder=\"AccountID\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Gift Type<br/><span>Select gift to distribute.</span></th>\r\n                <td>\r\n                    <table width=\"100%\">\r\n                        ";
    foreach ($rewards as $key => $thisReward) {
        echo "<tr><td><input type=\"checkbox\" name=\"reward-" . $key . "\" value=\"" . $key . "\" checked=\"checked\" /> " . $thisReward["Name"] . "</td></tr>";
    }
    echo "                    </table>\r\n                    <!--<select name=\"gift_type\" class=\"form-control\">\r\n                        <option value=\"1\">Seal of Wealth - 7 Days</option>\r\n                        <option value=\"2\">Seal of Healing - 7 Days</option>\r\n                        <option value=\"3\">Pet Panda - 7 Days</option>\r\n                        <option value=\"4\">Jewel of Chaos Bundle</option>\r\n                        <option value=\"5\">Bundle of Jewel of Soul</option>\r\n                        <option value=\"6\">Bundle of Jewel of Bless</option>\r\n                    </select>-->\r\n                </td>\r\n            </tr>\r\n        </table>\r\n        <button type=\"submit\" class=\"btn btn-large btn-block btn-success\" name=\"submit\" value=\"1\">Send Gift</button>\r\n    </form>\r\n    ";
}

?>