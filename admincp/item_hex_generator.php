<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

if (!(include_once "../includes/imperiamucms.php")) {
    throw new Exception("Could not load ImperiaMuCMS.");
}
if (!isLoggedIn()) {
    redirect();
}
if (!canAccessAdminCP($_SESSION["username"])) {
    redirect();
}
if (check_value($_POST["generate"])) {
    $item_id = htmlspecialchars($_POST["item"]);
    $itemData = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_ITEMS WHERE [index] = '" . $item_id . "'");
    $level = htmlspecialchars($_POST["level"]);
    if ($level == NULL || empty($level)) {
        $level = 0;
    }
    $life = htmlspecialchars($_POST["life"]);
    if ($life == NULL || empty($life)) {
        $life = 0;
    }
    $luck = htmlspecialchars($_POST["luck"]);
    if ($luck == NULL || empty($luck)) {
        $luck = 0;
    }
    if ($luck) {
        $luck = 1;
    }
    $skill = htmlspecialchars($_POST["skill"]);
    if ($skill == NULL || empty($skill)) {
        $skill = 0;
    }
    if ($skill) {
        $skill = 1;
    }
    $anc = htmlspecialchars($_POST["anc"]);
    $stamina = htmlspecialchars($_POST["stamina"]);
    if ($anc == NULL || empty($anc)) {
        $anc = 0;
    }
    if ($stamina == NULL || empty($stamina)) {
        $stamina = 0;
    }
    if ("0" < $anc && $stamina == "0") {
        $anc = 0;
    }
    if ($anc == "0" && "0" < $stamina) {
        $stamina = 0;
    }
    if (0 < $anc) {
        $ancData = $dB->query_fetch_single("SELECT tier FROM IMPERIAMUCMS_WEBSHOP_ANC WHERE anc_id = '" . $anc . "'");
        if ($ancData["tier"] == 1 && $stamina == 10) {
            $stamina = 9;
        } else {
            if ($ancData["tier"] == 2 && $stamina == 5) {
                $stamina = 6;
            }
        }
    }
    $exc1 = htmlspecialchars($_POST["exc1"]);
    $exc2 = htmlspecialchars($_POST["exc2"]);
    $exc3 = htmlspecialchars($_POST["exc3"]);
    $exc4 = htmlspecialchars($_POST["exc4"]);
    $exc5 = htmlspecialchars($_POST["exc5"]);
    $exc6 = htmlspecialchars($_POST["exc6"]);
    if ($exc1 == NULL || empty($exc1)) {
        $exc1 = 0;
    }
    if ($exc2 == NULL || empty($exc2)) {
        $exc2 = 0;
    }
    if ($exc3 == NULL || empty($exc3)) {
        $exc3 = 0;
    }
    if ($exc4 == NULL || empty($exc4)) {
        $exc4 = 0;
    }
    if ($exc5 == NULL || empty($exc5)) {
        $exc5 = 0;
    }
    if ($exc6 == NULL || empty($exc6)) {
        $exc6 = 0;
    }
    if ($exc1) {
        $exc1 = 1;
    }
    if ($exc2) {
        $exc2 = 1;
    }
    if ($exc3) {
        $exc3 = 1;
    }
    if ($exc4) {
        $exc4 = 1;
    }
    if ($exc5) {
        $exc5 = 1;
    }
    if ($exc6) {
        $exc6 = 1;
    }
    $refinery = htmlspecialchars($_POST["refinery"]);
    if ($refinery == NULL || empty($refinery)) {
        $refinery = 0;
    }
    if ($refinery) {
        $refinery = 1;
    }
    $harmony = htmlspecialchars($_POST["harmony"]);
    if ($harmony == NULL || empty($harmony)) {
        $harmony = 0;
    }
    if (0 < $harmony) {
        $harmonyData = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_WEBSHOP_HARMONY WHERE id = '" . $harmony . "'");
        $harmony_opt = $harmonyData["hoption"];
        $harmony_lvl = $harmonyData["hvalue"];
    }
    $socket1 = htmlspecialchars($_POST["socket1"]);
    $socket2 = htmlspecialchars($_POST["socket2"]);
    $socket3 = htmlspecialchars($_POST["socket3"]);
    $socket4 = htmlspecialchars($_POST["socket4"]);
    $socket5 = htmlspecialchars($_POST["socket5"]);
    if ($socket1 == NULL) {
        $socket1 = 255;
    }
    if ($socket2 == NULL) {
        $socket2 = 255;
    }
    if ($socket3 == NULL) {
        $socket3 = 255;
    }
    if ($socket4 == NULL) {
        $socket4 = 255;
    }
    if ($socket5 == NULL) {
        $socket5 = 255;
    }
    $hop = 0;
    $xl = 0;
    $dur = 255;
    if ($luck) {
        $hop += 4;
    }
    if ($skill) {
        $hop += 128;
    }
    if (4 <= $life) {
        $hop += $life - 4;
        $xl += 64;
    } else {
        $hop += $life;
    }
    if (0 < $level) {
        $hop += $level * 8;
    }
    if ($exc1) {
        $xl += 1;
    }
    if ($exc2) {
        $xl += 2;
    }
    if ($exc3) {
        $xl += 4;
    }
    if ($exc4) {
        $xl += 8;
    }
    if ($exc5) {
        $xl += 16;
    }
    if ($exc6) {
        $xl += 32;
    }
    if (256 <= $itemData["id"]) {
        $itemData["id"] = $itemData["id"] - 256;
        $xl += 128;
    }
    $itemhex = "";
    $itemhex = sprintf("%02X", $itemData["id"], 0);
    $itemhex .= sprintf("%02X", $hop, 0);
    $itemhex .= sprintf("%02X", $dur, 0);
    $itemhex .= "00000000";
    $itemhex .= sprintf("%02X", $xl, 0);
    $itemhex .= sprintf("%02X", $stamina, 0);
    $itemhex .= dechex($itemData["type"]);
    if ($refinery) {
        $itemhex .= "8";
    } else {
        $itemhex .= "0";
    }
    $itemhex .= dechex($harmony_opt);
    $itemhex .= dechex($harmony_lvl);
    if ($itemData["use_sockets"] == "1") {
        $itemhex .= sprintf("%02X", $socket1, 0);
        $itemhex .= sprintf("%02X", $socket2, 0);
        $itemhex .= sprintf("%02X", $socket3, 0);
        $itemhex .= sprintf("%02X", $socket4, 0);
        $itemhex .= sprintf("%02X", $socket5, 0);
    } else {
        $itemhex .= "FFFFFFFFFF";
    }
    $itemhex .= "00000000";
    $itemhex .= "FFFFFFFFFFFFFFFFFFFFFFFF";
    $itemhex = strtoupper($itemhex);
    echo "Hex Code: " . $itemhex;
} else {
    if (check_value($_POST["submit"])) {
        $item_id = htmlspecialchars($_POST["item"]);
        $itemData = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_ITEMS WHERE [index] = '" . $item_id . "'");
        $ancData = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_WEBSHOP_ANC_ITEMS WHERE item_id = '" . $itemData["id"] . "' AND item_cat = '" . $itemData["type"] . "'");
        switch ($itemData["exc"]) {
            case 1:
                $op1 = "Increase Mana per kill +8";
                $op2 = "Increase hit points per kill +8";
                $op3 = "Increase attacking(wizardly)speed+7";
                $op4 = "Increase wizardly damage +2%";
                $op5 = "Increase Damage +level/20";
                $op6 = "Excellent Damage Rate +10%";
                $inf = "Additional Damage";
                break;
            case 2:
                $op1 = "Increase Zen After Hunt +30%";
                $op2 = "Defense success rate +10%";
                $op3 = "Reflect damage +5%";
                $op4 = "Damage Decrease +4%";
                $op5 = "Increase MaxMana +4%";
                $op6 = "Increase MaxHP +4%";
                $inf = "Additional Defense";
                break;
            case 3:
                $op1 = " +125 HP";
                $op2 = " +125 Mana";
                $op3 = " Ignore Enemy Defense 3%";
                $op4 = " AG +50";
                $op5 = " Attack(Wiz) Speed +5";
                $op6 = "";
                $inf = "Additional Damage";
                break;
            case 4:
                $op1 = " Ignore Enemy Defense 5%";
                $op2 = " 5% Reflect Probabilities";
                $op3 = " Life Recovery +5%";
                $op4 = " Mana Recovery +5%";
                $op5 = "";
                $op6 = "";
                $inf = "Additional Damage";
                break;
            case 5:
                $op1 = " +125 HP";
                $op2 = " +125 Mana";
                $op3 = " Ignore Enemy Defense 3%";
                $op4 = " Increase command +85";
                $op5 = "";
                $op6 = "";
                $inf = "Additional Damage";
                break;
            case 6:
                $op1 = " +125 HP";
                $op2 = " +125 Mana";
                $op3 = " Ignore Enemy Defense 3%";
                $op4 = "";
                $op5 = "";
                $op6 = "";
                $inf = "Additional Damage";
                break;
            case 7:
                $op1 = " Ignore Enemy Defense 3%";
                $op2 = " Life Recovery +5%";
                $op3 = "";
                $op4 = "";
                $op5 = "";
                $op6 = "";
                $inf = "Additional Damage";
                break;
            case 8:
                $op1 = " Chance of Fully Recovering Life +4%";
                $op2 = " Chance of Damage from Breaking Enemy's Defense +4%";
                $op3 = " Chance of Double damage +4%";
                $op4 = "";
                $op5 = "";
                $op6 = "";
                $inf = "Additional Damage";
                break;
            case 9:
                $op1 = " Chance of Fully Recovering Mana +5%";
                $op2 = " Chance of Fully Recovering Life +5%";
                $op3 = " Chance of Returning the Enemy's Attack Power +5%";
                $op4 = " Chance of Damage from Breaking Enemy's Defense +5%";
                $op5 = "";
                $op6 = "";
                $inf = "Additional Damage";
                break;
            default:
                echo "<form method=\"post\" action=\"\"><table><tr>";
                echo "<th colspan=\"2\">" . $itemData["name"] . "</th>";
                echo "</tr>";
                if ("0" < $itemData["max_level"]) {
                    echo "<tr><td>Level:</td><td><select name=\"level\">";
                    $i = 0;
                    while ($i <= $itemData["max_level"]) {
                        echo "<option value=\"" . $i . "\">+" . $i . "</option>";
                        $i++;
                    }
                    echo "</select></td></tr>";
                }
                if (0 < $itemData["max_option"]) {
                    echo "<tr><td>Life:</td><td><select name=\"life\">";
                    $i = 0;
                    while ($i <= $itemData["max_option"]) {
                        echo "<option value=\"" . $i . "\">" . $inf . " +" . $i * 4 . "</option>";
                        $i++;
                    }
                    echo "</select></td></tr>";
                }
                if (0 < $itemData["luck"]) {
                    echo "<tr><td>Luck:</td><td><input type=\"checkbox\" name=\"luck\"></td></tr>";
                }
                if (0 < $itemData["skill"]) {
                    echo "<tr><td>Skill:</td><td><input type=\"checkbox\" name=\"skill\"></td></tr>";
                }
                if (0 < $ancData["anc1"] || 0 < $ancData["anc2"]) {
                    echo "<tr><td>Ancient Set:</td><td><select name=\"anc\"><option value=\"\">None</option>";
                    if (0 < $ancData["anc1"]) {
                        $anc_data1 = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_WEBSHOP_ANC WHERE anc_id = '" . $ancData["anc1"] . "'");
                        echo "<option value=\"" . $ancData["anc1"] . "\">" . $anc_data1["anc_name"] . "</option>";
                    }
                    if (0 < $ancData["anc2"]) {
                        $anc_data2 = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_WEBSHOP_ANC WHERE anc_id = '" . $ancData["anc2"] . "'");
                        echo "<option value=\"" . $ancData["anc2"] . "\">" . $anc_data2["anc_name"] . "</option>";
                    }
                    echo "</select></td></tr><tr><td>Stamina:</td><td><select name=\"stamina\"><option value=\"\">None</option><option value=\"5\">+5</option><option value=\"10\">+10</option></select></td></tr>";
                }
                if (0 < $itemData["exc"]) {
                    echo "<tr><td>Excellent:</td><td>";
                    if ($op1 != NULL) {
                        echo "<input type=\"checkbox\" name=\"exc1\"> " . $op1;
                    }
                    if ($op2 != NULL) {
                        echo "<br /><input type=\"checkbox\" name=\"exc2\"> " . $op2;
                    }
                    if ($op3 != NULL) {
                        echo "<br /><input type=\"checkbox\" name=\"exc3\"> " . $op3;
                    }
                    if ($op4 != NULL) {
                        echo "<br /><input type=\"checkbox\" name=\"exc4\"> " . $op4;
                    }
                    if ($op5 != NULL) {
                        echo "<br /><input type=\"checkbox\" name=\"exc5\"> " . $op5;
                    }
                    if ($op6 != NULL) {
                        echo "<br /><input type=\"checkbox\" name=\"exc6\"> " . $op6;
                    }
                    echo "</td></tr>";
                }
                if ($itemData["use_refinary"] == 1) {
                    echo "<tr><td>Refinery (380 lvl opt):</td><td><input type=\"checkbox\" name=\"refinery\"></td></tr>";
                }
                if ($itemData["use_harmony"] == 1) {
                    $item_cat = $itemData["item_cat"];
                    if ($item_cat < 5) {
                        $item_type = 1;
                    } else {
                        if ($item_cat == 5) {
                            $item_type = 2;
                        } else {
                            if (5 < $item_cat && $item_cat < 12) {
                                $item_type = 3;
                            } else {
                                $item_type = -1;
                            }
                        }
                    }
                    $harmonyData = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_WEBSHOP_HARMONY WHERE itemtype = '" . $item_type . "' ORDER BY hoption asc, hvalue asc");
                    foreach ($harmonyData as $h) {
                        $harmony_options .= "<option value=\"" . $h["id"] . "\">" . $h["hname"] . "</option>";
                    }
                    echo "<tr><td>Harmony:</td><td><select name=\"harmony\"><option value=\"0\">None</option>";
                    echo $harmony_options;
                    echo "</select></td></tr>";
                }
                if ($itemData["use_sockets"] == 1) {
                    $item_cat = $itemData["item_cat"];
                    if ($item_cat < 6) {
                        $socket_part_type = 1;
                    } else {
                        if (5 < $item_cat && $item_cat < 12) {
                            $socket_part_type = 0;
                        } else {
                            $socket_part_type = -1;
                        }
                    }
                    $socketData = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_WEBSHOP_SOCKETS WHERE status = 1 AND (socket_part_type = '-1' OR socket_part_type = '" . $socket_part_type . "') ORDER BY sockettype asc");
                    foreach ($socketData as $s) {
                        $socket_options .= "<option value=\"" . $s["socket_id"] . "\">" . $s["socket_name"] . "</option>";
                    }
                    echo "<tr><td>Socket 1:</td><td><select name=\"socket1\"><option value=\"255\">None</option>";
                    echo $socket_options;
                    echo "</select></td></tr><tr><td>Socket 2:</td><td><select name=\"socket2\"><option value=\"255\">None</option>";
                    echo $socket_options;
                    echo "</select></td></tr><tr><td>Socket 3:</td><td><select name=\"socket3\"><option value=\"255\">None</option>";
                    echo $socket_options;
                    echo "</select></td></tr><tr><td>Socket 4:</td><td><select name=\"socket4\"><option value=\"255\">None</option>";
                    echo $socket_options;
                    echo "</select></td></tr><tr><td>Socket 5:</td><td><select name=\"socket5\"><option value=\"255\">None</option>";
                    echo $socket_options;
                    echo "</select></td></tr>";
                }
                echo "<tr>";
                echo "<th colspan=\"2\"><input type=\"hidden\" name=\"item\" value=\"" . $item_id . "\"><input type=\"submit\" name=\"generate\" value=\"Generate Hex Code\"></th>";
                echo "</tr></table></form>";
        }
    } else {
        $items = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_ITEMS ORDER BY type, id");
        $cat0 = 0;
        $cat1 = 0;
        $cat2 = 0;
        $cat3 = 0;
        $cat4 = 0;
        $cat5 = 0;
        $cat6 = 0;
        $cat7 = 0;
        $cat8 = 0;
        $cat9 = 0;
        $cat10 = 0;
        $cat11 = 0;
        $cat12 = 0;
        $cat13 = 0;
        $cat14 = 0;
        $cat15 = 0;
        $options = "<option value=\"\">Select Item</option>";
        foreach ($items as $thisItem) {
            if ($thisItem["type"] == 0 && $cat0 == 0) {
                $options .= "<optgroup label=\"Swords\">";
                $options .= "<option value=\"" . $thisItem["index"] . "\">" . $thisItem["name"] . "</option>";
                $cat0 = 1;
            } else {
                if ($thisItem["type"] == 0 && $cat0 == 1) {
                    $options .= "<option value=\"" . $thisItem["index"] . "\">" . $thisItem["name"] . "</option>";
                }
            }
            if ($thisItem["type"] == 1 && $cat1 == 0) {
                $options .= "</optgroup><optgroup label=\"Axes\">";
                $options .= "<option value=\"" . $thisItem["index"] . "\">" . $thisItem["name"] . "</option>";
                $cat1 = 1;
            } else {
                if ($thisItem["type"] == 1 && $cat1 == 1) {
                    $options .= "<option value=\"" . $thisItem["index"] . "\">" . $thisItem["name"] . "</option>";
                }
            }
            if ($thisItem["type"] == 2 && $cat2 == 0) {
                $options .= "</optgroup><optgroup label=\"Maces & Scepter\">";
                $options .= "<option value=\"" . $thisItem["index"] . "\">" . $thisItem["name"] . "</option>";
                $cat2 = 1;
            } else {
                if ($thisItem["type"] == 2 && $cat2 == 1) {
                    $options .= "<option value=\"" . $thisItem["index"] . "\">" . $thisItem["name"] . "</option>";
                }
            }
            if ($thisItem["type"] == 3 && $cat3 == 0) {
                $options .= "</optgroup><optgroup label=\"Spears\">";
                $options .= "<option value=\"" . $thisItem["index"] . "\">" . $thisItem["name"] . "</option>";
                $cat3 = 1;
            } else {
                if ($thisItem["type"] == 3 && $cat3 == 1) {
                    $options .= "<option value=\"" . $thisItem["index"] . "\">" . $thisItem["name"] . "</option>";
                }
            }
            if ($thisItem["type"] == 4 && $cat4 == 0) {
                $options .= "</optgroup><optgroup label=\"Bows & Crossbows\">";
                $options .= "<option value=\"" . $thisItem["index"] . "\">" . $thisItem["name"] . "</option>";
                $cat4 = 1;
            } else {
                if ($thisItem["type"] == 4 && $cat4 == 1) {
                    $options .= "<option value=\"" . $thisItem["index"] . "\">" . $thisItem["name"] . "</option>";
                }
            }
            if ($thisItem["type"] == 5 && $cat5 == 0) {
                $options .= "</optgroup><optgroup label=\"Staffs & Sticks\">";
                $options .= "<option value=\"" . $thisItem["index"] . "\">" . $thisItem["name"] . "</option>";
                $cat5 = 1;
            } else {
                if ($thisItem["type"] == 5 && $cat5 == 1) {
                    $options .= "<option value=\"" . $thisItem["index"] . "\">" . $thisItem["name"] . "</option>";
                }
            }
            if ($thisItem["type"] == 6 && $cat6 == 0) {
                $options .= "</optgroup><optgroup label=\"Shields\">";
                $options .= "<option value=\"" . $thisItem["index"] . "\">" . $thisItem["name"] . "</option>";
                $cat6 = 1;
            } else {
                if ($thisItem["type"] == 6 && $cat6 == 1) {
                    $options .= "<option value=\"" . $thisItem["index"] . "\">" . $thisItem["name"] . "</option>";
                }
            }
            if ($thisItem["type"] == 7 && $cat7 == 0) {
                $options .= "</optgroup><optgroup label=\"Helms\">";
                $options .= "<option value=\"" . $thisItem["index"] . "\">" . $thisItem["name"] . "</option>";
                $cat7 = 1;
            } else {
                if ($thisItem["type"] == 7 && $cat7 == 1) {
                    $options .= "<option value=\"" . $thisItem["index"] . "\">" . $thisItem["name"] . "</option>";
                }
            }
            if ($thisItem["type"] == 8 && $cat8 == 0) {
                $options .= "</optgroup><optgroup label=\"Armors\">";
                $options .= "<option value=\"" . $thisItem["index"] . "\">" . $thisItem["name"] . "</option>";
                $cat8 = 1;
            } else {
                if ($thisItem["type"] == 8 && $cat8 == 1) {
                    $options .= "<option value=\"" . $thisItem["index"] . "\">" . $thisItem["name"] . "</option>";
                }
            }
            if ($thisItem["type"] == 9 && $cat9 == 0) {
                $options .= "</optgroup><optgroup label=\"Pants\">";
                $options .= "<option value=\"" . $thisItem["index"] . "\">" . $thisItem["name"] . "</option>";
                $cat9 = 1;
            } else {
                if ($thisItem["type"] == 9 && $cat9 == 1) {
                    $options .= "<option value=\"" . $thisItem["index"] . "\">" . $thisItem["name"] . "</option>";
                }
            }
            if ($thisItem["type"] == 10 && $cat10 == 0) {
                $options .= "</optgroup><optgroup label=\"Gloves\">";
                $options .= "<option value=\"" . $thisItem["index"] . "\">" . $thisItem["name"] . "</option>";
                $cat10 = 1;
            } else {
                if ($thisItem["type"] == 10 && $cat10 == 1) {
                    $options .= "<option value=\"" . $thisItem["index"] . "\">" . $thisItem["name"] . "</option>";
                }
            }
            if ($thisItem["type"] == 11 && $cat11 == 0) {
                $options .= "</optgroup><optgroup label=\"Boots\">";
                $options .= "<option value=\"" . $thisItem["index"] . "\">" . $thisItem["name"] . "</option>";
                $cat11 = 1;
            } else {
                if ($thisItem["type"] == 11 && $cat11 == 1) {
                    $options .= "<option value=\"" . $thisItem["index"] . "\">" . $thisItem["name"] . "</option>";
                }
            }
            if ($thisItem["type"] == 12 && $cat12 == 0) {
                $options .= "</optgroup><optgroup label=\"Misc I\">";
                $options .= "<option value=\"" . $thisItem["index"] . "\">" . $thisItem["name"] . "</option>";
                $cat12 = 1;
            } else {
                if ($thisItem["type"] == 12 && $cat12 == 1) {
                    $options .= "<option value=\"" . $thisItem["index"] . "\">" . $thisItem["name"] . "</option>";
                }
            }
            if ($thisItem["type"] == 13 && $cat13 == 0) {
                $options .= "</optgroup><optgroup label=\"Misc II\">";
                $options .= "<option value=\"" . $thisItem["index"] . "\">" . $thisItem["name"] . "</option>";
                $cat13 = 1;
            } else {
                if ($thisItem["type"] == 13 && $cat13 == 1) {
                    $options .= "<option value=\"" . $thisItem["index"] . "\">" . $thisItem["name"] . "</option>";
                }
            }
            if ($thisItem["type"] == 14 && $cat14 == 0) {
                $options .= "</optgroup><optgroup label=\"Misc III\">";
                $options .= "<option value=\"" . $thisItem["index"] . "\">" . $thisItem["name"] . "</option>";
                $cat14 = 1;
            } else {
                if ($thisItem["type"] == 14 && $cat14 == 1) {
                    $options .= "<option value=\"" . $thisItem["index"] . "\">" . $thisItem["name"] . "</option>";
                }
            }
            if ($thisItem["type"] == 15 && $cat15 == 0) {
                $options .= "</optgroup><optgroup label=\"Scrolls\">";
                $options .= "<option value=\"" . $thisItem["index"] . "\">" . $thisItem["name"] . "</option>";
                $cat15 = 1;
            } else {
                if ($thisItem["type"] == 15 && $cat15 == 1) {
                    $options .= "<option value=\"" . $thisItem["index"] . "\">" . $thisItem["name"] . "</option>";
                }
            }
        }
        echo "\r\n  <form method=\"post\" action=\"\">\r\n    <select name=\"item\">\r\n      " . $options . "\r\n    </select>\r\n    <input type=\"submit\" name=\"submit\">\r\n  </form>\r\n  ";
    }
}

?>