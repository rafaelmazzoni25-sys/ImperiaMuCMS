<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

if (check_value($_POST["fix_item_indexes"])) {
    $totalItems = $dB->query_fetch_single("SELECT COUNT(*) as total FROM IMPERIAMUCMS_ITEMS");
    $limit = 200;
    $index = 1;
    $totalLoops = ceil($totalItems["total"] / $limit);
    $i = 1;
    while ($i <= $totalLoops) {
        $start = $i * $limit - $limit;
        $items = $dB->query_fetch("SELECT [index], [name], [id], [type], [level], [X], [Y], [option], [exc], [purple], [sell], [class], [luck], [skill], [max_level], [max_option], \r\n        [max_exc], [use_harmony], [use_refinary], [use_sockets], [max_sockets], [payment_type], [item_slot], [item_skill_index], [item_twohanded], [item_width], [item_height], [item_serial], \r\n        [item_req_level], [item_dmg_min], [item_dmg_max], [item_attack_speed], [item_dur], [item_dur_magic], [item_magic_power], [item_req_str], [item_req_agi], [item_req_vit], [item_req_ene], \r\n        [item_req_cmd], [item_class_dw], [item_class_dk], [item_class_fe], [item_class_mg], [item_class_dl], [item_class_su], [item_class_rf], [item_class_gl], [item_type], [item_kind_a], \r\n        [item_kind_b], [item_def], [item_blocking], [item_walk_speed], [item_res_ice], [item_res_poison], [item_res_light], [item_res_fire], [item_res_earth], [item_res_wind], [item_res_water], \r\n        [item_class_rw], [item_class_sr] FROM IMPERIAMUCMS_ITEMS ORDER BY [type] ASC, [id] ASC, [level] ASC\r\n        OFFSET " . $start . " ROWS FETCH NEXT " . $limit . " ROWS ONLY");
        $query = "SET IDENTITY_INSERT [dbo].[IMPERIAMUCMS_ITEMS] ON;";
        foreach ($items as $thisItem) {
            foreach ($thisItem as $key => $thisAttr) {
                if (empty($thisAttr) && !is_numeric($thisAttr)) {
                    $thisItem[$key] = "NULL";
                }
            }
            $thisItem["name"] = str_replace("'", "''", $thisItem["name"]);
            $query .= "DELETE FROM IMPERIAMUCMS_ITEMS WHERE [type] = " . $thisItem["type"] . " AND [id] = " . $thisItem["id"] . " AND [level] = " . $thisItem["level"] . ";";
            $query .= "INSERT INTO [dbo].[IMPERIAMUCMS_ITEMS] ([index], [name], [id], [type], [level], [X], [Y], [option], [exc], [purple], [sell], [class], [luck], [skill], [max_level], [max_option], \r\n            [max_exc], [use_harmony], [use_refinary], [use_sockets], [max_sockets], [payment_type], [item_slot], [item_skill_index], [item_twohanded], [item_width], [item_height], [item_serial], \r\n            [item_req_level], [item_dmg_min], [item_dmg_max], [item_attack_speed], [item_dur], [item_dur_magic], [item_magic_power], [item_req_str], [item_req_agi], [item_req_vit], [item_req_ene], \r\n            [item_req_cmd], [item_class_dw], [item_class_dk], [item_class_fe], [item_class_mg], [item_class_dl], [item_class_su], [item_class_rf], [item_class_gl], [item_type], [item_kind_a], \r\n            [item_kind_b], [item_def], [item_blocking], [item_walk_speed], [item_res_ice], [item_res_poison], [item_res_light], [item_res_fire], [item_res_earth], [item_res_wind], [item_res_water], \r\n            [item_class_rw], [item_class_sr]) VALUES (" . $index . ", N'" . $thisItem["name"] . "', " . $thisItem["id"] . ", " . $thisItem["type"] . ", " . $thisItem["level"] . ", " . $thisItem["X"] . ", \r\n            " . $thisItem["Y"] . ", " . $thisItem["option"] . ", " . $thisItem["exc"] . ", " . $thisItem["purple"] . ", " . $thisItem["sell"] . ", " . $thisItem["class"] . ", " . $thisItem["luck"] . ", " . $thisItem["skill"] . ", \r\n            " . $thisItem["max_level"] . ", " . $thisItem["max_option"] . ", " . $thisItem["max_exc"] . ", " . $thisItem["use_harmony"] . ", " . $thisItem["use_refinary"] . ", " . $thisItem["use_sockets"] . ", \r\n            " . $thisItem["max_sockets"] . ", " . $thisItem["payment_type"] . ", " . $thisItem["item_slot"] . ", " . $thisItem["item_skill_index"] . ", " . $thisItem["item_twohanded"] . ", " . $thisItem["item_width"] . ", \r\n            " . $thisItem["item_height"] . ", " . $thisItem["item_serial"] . ", " . $thisItem["item_req_level"] . ", " . $thisItem["item_dmg_min"] . ", " . $thisItem["item_dmg_max"] . ", " . $thisItem["item_attack_speed"] . ", \r\n            " . $thisItem["item_dur"] . ", " . $thisItem["item_dur_magic"] . ", " . $thisItem["item_magic_power"] . ", " . $thisItem["item_req_str"] . ", " . $thisItem["item_req_agi"] . ", " . $thisItem["item_req_vit"] . ", \r\n            " . $thisItem["item_req_ene"] . ", " . $thisItem["item_req_cmd"] . ", " . $thisItem["item_class_dw"] . ", " . $thisItem["item_class_dk"] . ", " . $thisItem["item_class_fe"] . ", " . $thisItem["item_class_mg"] . ", \r\n            " . $thisItem["item_class_dl"] . ", " . $thisItem["item_class_su"] . ", " . $thisItem["item_class_rf"] . ", " . $thisItem["item_class_gl"] . ", " . $thisItem["item_type"] . ", " . $thisItem["item_kind_a"] . ", \r\n            " . $thisItem["item_kind_b"] . ", " . $thisItem["item_def"] . ", " . $thisItem["item_blocking"] . ", " . $thisItem["item_walk_speed"] . ", " . $thisItem["item_res_ice"] . ", " . $thisItem["item_res_poison"] . ", \r\n            " . $thisItem["item_res_light"] . ", " . $thisItem["item_res_fire"] . ", " . $thisItem["item_res_earth"] . ", " . $thisItem["item_res_wind"] . ", " . $thisItem["item_res_water"] . ", \r\n            " . $thisItem["item_class_rw"] . ", " . $thisItem["item_class_sr"] . ");";
            $index++;
        }
        $query .= "SET IDENTITY_INSERT [dbo].[IMPERIAMUCMS_ITEMS] OFF;";
        $check = $dB->query($query);
        if ($check) {
            message("success", "Iteration #" . $i . " succeed.");
        } else {
            message("error", "Iteration #" . $i . " failed.");
        }
        $i++;
    }
}
if (check_value($_POST["show_fix_item_indexes"])) {
    $totalItems = $dB->query_fetch_single("SELECT COUNT(*) as total FROM IMPERIAMUCMS_ITEMS");
    $limit = 200;
    $index = 1;
    $totalLoops = ceil($totalItems["total"] / $limit);
    echo "<pre>";
    $i = 1;
    while ($i <= $totalLoops) {
        $start = $i * $limit - $limit;
        $items = $dB->query_fetch("SELECT [index], [name], [id], [type], [level], [X], [Y], [option], [exc], [purple], [sell], [class], [luck], [skill], [max_level], [max_option], \r\n        [max_exc], [use_harmony], [use_refinary], [use_sockets], [max_sockets], [payment_type], [item_slot], [item_skill_index], [item_twohanded], [item_width], [item_height], [item_serial], \r\n        [item_req_level], [item_dmg_min], [item_dmg_max], [item_attack_speed], [item_dur], [item_dur_magic], [item_magic_power], [item_req_str], [item_req_agi], [item_req_vit], [item_req_ene], \r\n        [item_req_cmd], [item_class_dw], [item_class_dk], [item_class_fe], [item_class_mg], [item_class_dl], [item_class_su], [item_class_rf], [item_class_gl], [item_type], [item_kind_a], \r\n        [item_kind_b], [item_def], [item_blocking], [item_walk_speed], [item_res_ice], [item_res_poison], [item_res_light], [item_res_fire], [item_res_earth], [item_res_wind], [item_res_water], \r\n        [item_class_rw], [item_class_sr] FROM IMPERIAMUCMS_ITEMS ORDER BY [type] ASC, [id] ASC, [level] ASC\r\n        OFFSET " . $start . " ROWS FETCH NEXT " . $limit . " ROWS ONLY");
        $query = "\$import['imperiamucms_data_items_" . $i . "'] = \"<br>SET IDENTITY_INSERT [dbo].[IMPERIAMUCMS_ITEMS] ON;<br>";
        foreach ($items as $thisItem) {
            foreach ($thisItem as $key => $thisAttr) {
                if (empty($thisAttr) && !is_numeric($thisAttr)) {
                    $thisItem[$key] = "NULL";
                }
            }
            $thisItem["name"] = str_replace("'", "''", $thisItem["name"]);
            $query .= "INSERT INTO [dbo].[IMPERIAMUCMS_ITEMS] ([index], [name], [id], [type], [level], [X], [Y], [option], [exc], [purple], [sell], [class], [luck], [skill], [max_level], [max_option], [max_exc], [use_harmony], [use_refinary], [use_sockets], [max_sockets], [payment_type], [item_slot], [item_skill_index], [item_twohanded], [item_width], [item_height], [item_serial], [item_req_level], [item_dmg_min], [item_dmg_max], [item_attack_speed], [item_dur], [item_dur_magic], [item_magic_power], [item_req_str], [item_req_agi], [item_req_vit], [item_req_ene], [item_req_cmd], [item_class_dw], [item_class_dk], [item_class_fe], [item_class_mg], [item_class_dl], [item_class_su], [item_class_rf], [item_class_gl], [item_type], [item_kind_a], [item_kind_b], [item_def], [item_blocking], [item_walk_speed], [item_res_ice], [item_res_poison], [item_res_light], [item_res_fire], [item_res_earth], [item_res_wind], [item_res_water], [item_class_rw], [item_class_sr]) VALUES (" . $index . ", N'" . $thisItem["name"] . "', " . $thisItem["id"] . ", " . $thisItem["type"] . ", " . $thisItem["level"] . ", " . $thisItem["X"] . ", " . $thisItem["Y"] . ", " . $thisItem["option"] . ", " . $thisItem["exc"] . ", " . $thisItem["purple"] . ", " . $thisItem["sell"] . ", " . $thisItem["class"] . ", " . $thisItem["luck"] . ", " . $thisItem["skill"] . ", " . $thisItem["max_level"] . ", " . $thisItem["max_option"] . ", " . $thisItem["max_exc"] . ", " . $thisItem["use_harmony"] . ", " . $thisItem["use_refinary"] . ", " . $thisItem["use_sockets"] . ", " . $thisItem["max_sockets"] . ", " . $thisItem["payment_type"] . ", " . $thisItem["item_slot"] . ", " . $thisItem["item_skill_index"] . ", " . $thisItem["item_twohanded"] . ", " . $thisItem["item_width"] . ", " . $thisItem["item_height"] . ", " . $thisItem["item_serial"] . ", " . $thisItem["item_req_level"] . ", " . $thisItem["item_dmg_min"] . ", " . $thisItem["item_dmg_max"] . ", " . $thisItem["item_attack_speed"] . ", " . $thisItem["item_dur"] . ", " . $thisItem["item_dur_magic"] . ", " . $thisItem["item_magic_power"] . ", " . $thisItem["item_req_str"] . ", " . $thisItem["item_req_agi"] . ", " . $thisItem["item_req_vit"] . ", " . $thisItem["item_req_ene"] . ", " . $thisItem["item_req_cmd"] . ", " . $thisItem["item_class_dw"] . ", " . $thisItem["item_class_dk"] . ", " . $thisItem["item_class_fe"] . ", " . $thisItem["item_class_mg"] . ", " . $thisItem["item_class_dl"] . ", " . $thisItem["item_class_su"] . ", " . $thisItem["item_class_rf"] . ", " . $thisItem["item_class_gl"] . ", " . $thisItem["item_type"] . ", " . $thisItem["item_kind_a"] . ", " . $thisItem["item_kind_b"] . ", " . $thisItem["item_def"] . ", " . $thisItem["item_blocking"] . ", " . $thisItem["item_walk_speed"] . ", " . $thisItem["item_res_ice"] . ", " . $thisItem["item_res_poison"] . ", " . $thisItem["item_res_light"] . ", " . $thisItem["item_res_fire"] . ", " . $thisItem["item_res_earth"] . ", " . $thisItem["item_res_wind"] . ", " . $thisItem["item_res_water"] . ", " . $thisItem["item_class_rw"] . ", " . $thisItem["item_class_sr"] . ");<br>";
            $index++;
        }
        $query .= "SET IDENTITY_INSERT [dbo].[IMPERIAMUCMS_ITEMS] OFF;\";<br><br>";
        echo $query;
        $i++;
    }
    echo "</pre>";
}
if (check_value($_POST["import_webshop_items"])) {
    $xml = file_get_contents($_FILES["itemlist"]["tmp_name"]);
    $xmlArray = [];
    $p = xml_parser_create();
    xml_parse_into_struct($p, $xml, $xmlArray);
    xml_parser_free($p);
    $Items = new Items();
    $section = 0;
    $i = 0;
    foreach ($xmlArray as $element) {
        if ($element["tag"] == "SECTION" && $element["type"] == "open") {
            $section = $element["attributes"]["INDEX"];
        }
        if ($element["tag"] == "ITEM" && $section <= 11) {
            $check = $dB->query_fetch_single("SELECT TOP 1 * FROM IMPERIAMUCMS_WEBSHOP_ITEMS WHERE item_cat = ? AND item_id = ?", [$section, $element["attributes"]["INDEX"]]);
            if ($check["name"] == NULL && $element["attributes"]["NAME"] != "Pandora Pick (Two-Handed)" && strpos($element["attributes"]["NAME"], "[Bound]") === false) {
                if ($element["attributes"]["TYPE"] == "2") {
                    $useSocket = 1;
                    $maxSocket = 5;
                    $useHarmony = 0;
                } else {
                    $useSocket = 0;
                    $maxSocket = 0;
                    $useHarmony = 1;
                }
                if ($element["attributes"]["TYPE"] == "3") {
                    $useRefinary = 1;
                } else {
                    $useRefinary = 0;
                }
                if ($element["attributes"]["SKILLINDEX"] != "0") {
                    $useSkill = 1;
                } else {
                    $useSkill = 0;
                }
                if ("0" <= $element["attributes"]["SLOT"] && $element["attributes"]["SLOT"] <= "7") {
                    $useLuck = 1;
                } else {
                    $useLuck = 0;
                }
                if ($section <= 5) {
                    $exetype = 1;
                } else {
                    if ($section <= 11) {
                        $exetype = 1;
                    }
                }
                if ($useSocket == 1) {
                    $exetype = 0;
                }
                $price = $element["attributes"]["DROPLEVEL"] * 4;
                $excOpts = $Items->loadExcOptForItem($section, $element["attributes"]["INDEX"], $element["attributes"]["KINDA"], $element["attributes"]["KINDB"]);
                $insert = $dB->query("\r\n                        INSERT INTO [dbo].[IMPERIAMUCMS_WEBSHOP_ITEMS]\r\n                               ([item_id]\r\n                               ,[item_cat]\r\n                               ,[max_item_lvl]\r\n                               ,[max_item_opt]\r\n                               ,[exetype]\r\n                               ,[name]\r\n                               ,[price]\r\n                               ,[luck]\r\n                               ,[skill]\r\n                               ,[use_sockets]\r\n                               ,[use_harmony]\r\n                               ,[use_refinary]\r\n                               ,[total_bought]\r\n                               ,[payment_type]\r\n                               ,[description]\r\n                               ,[main_cat]\r\n                               ,[sub_cat]\r\n                               ,[image]\r\n                               ,[on_sale]\r\n                               ,[item_lvl]\r\n                               ,[store_count]\r\n                               ,[item_exc]\r\n                               ,[status]\r\n                               ,[max_exc_opt]\r\n                               ,[max_socket]\r\n                               ,[can_gift])\r\n                        VALUES\r\n                               (" . $element["attributes"]["INDEX"] . "\r\n                               ," . $section . "\r\n                               ,15\r\n                               ,7\r\n                               ," . $exetype . "\r\n                               ,'" . str_replace("'", "''", $element["attributes"]["NAME"]) . "'\r\n                               ," . $price . "\r\n                               ," . $useLuck . "\r\n                               ," . $useSkill . "\r\n                               ," . $useSocket . "\r\n                               ," . $useHarmony . "\r\n                               ," . $useRefinary . "\r\n                               ,0\r\n                               ,1\r\n                               ,null\r\n                               ," . $section . "\r\n                               ,0\r\n                               ,null\r\n                               ,0\r\n                               ,0\r\n                               ,-1\r\n                               ,0\r\n                               ,1\r\n                               ," . count($excOpts) . "\r\n                               ," . $maxSocket . "\r\n                               ,1)\r\n                    ");
                if ($insert) {
                    message("success", "Imported: " . $element["attributes"]["NAME"]);
                } else {
                    message("error", "Failed to import: " . $element["attributes"]["NAME"]);
                }
            }
        }
    }
}
if (check_value($_POST["update_items"])) {
    $xml = file_get_contents($_FILES["itemlist"]["tmp_name"]);
    $xmlArray = [];
    $p = xml_parser_create();
    xml_parse_into_struct($p, $xml, $xmlArray);
    xml_parser_free($p);
    $section = 0;
    $i = 0;
    foreach ($xmlArray as $element) {
        if ($element["tag"] == "SECTION" && $element["type"] == "open") {
            $section = $element["attributes"]["INDEX"];
        }
        if ($element["tag"] == "ITEM") {
            $check = $dB->query_fetch_single("SELECT TOP 1 * FROM IMPERIAMUCMS_ITEMS WHERE type = ? AND id = ?", [$section, $element["attributes"]["INDEX"]]);
            if ($check["name"] != NULL) {
                if ($element["attributes"]["TYPE"] == "2") {
                    $useSocket = 1;
                    $maxSocket = 5;
                    $useHarmony = 0;
                } else {
                    $useSocket = 0;
                    $maxSocket = 0;
                    $useHarmony = 1;
                }
                if ($element["attributes"]["TYPE"] == "3") {
                    $useRefinary = 1;
                } else {
                    $useRefinary = 0;
                }
                if ($element["attributes"]["SKILLINDEX"] != "0") {
                    $useSkill = 1;
                } else {
                    $useSkill = 0;
                }
                if ("0" <= $element["attributes"]["SLOT"] && $element["attributes"]["SLOT"] <= "7") {
                    $useLuck = 1;
                } else {
                    $useLuck = 0;
                }
                if ("0" <= $element["attributes"]["SLOT"] && $element["attributes"]["SLOT"] <= "11" && $element["attributes"]["SLOT"] != "8") {
                    if (0 <= $section && $section <= 5) {
                        $useExc = 1;
                    } else {
                        if (6 <= $section && $section <= 11) {
                            $useExc = 2;
                        } else {
                            $useExc = 0;
                        }
                    }
                    $useOption = 1;
                    $maxLvl = 15;
                    $maxOpt = 7;
                    $maxExc = 6;
                } else {
                    $useExc = 0;
                    $useOption = 0;
                    $maxLvl = 0;
                    $maxOpt = 0;
                    $maxExc = 0;
                }
                if ($element["attributes"]["TYPE"] == "2") {
                    $itemClass = 5;
                } else {
                    if ($element["attributes"]["TYPE"] == "3") {
                        $itemClass = 4;
                    } else {
                        if ($element["attributes"]["TYPE"] == "1") {
                            if ("55" <= $element["attributes"]["DROPLEVEL"]) {
                                $itemClass = 3;
                            } else {
                                if ("30" <= $element["attributes"]["DROPLEVEL"]) {
                                    $itemClass = 2;
                                } else {
                                    $itemClass = 1;
                                }
                            }
                        } else {
                            $itemClass = 0;
                        }
                    }
                }
                if ($element["attributes"]["SKILLINDEX"] == NULL) {
                    $element["attributes"]["SKILLINDEX"] = 0;
                }
                if ($element["attributes"]["TWOHAND"] == NULL) {
                    $element["attributes"]["TWOHAND"] = 0;
                }
                if ($element["attributes"]["REQLEVEL"] == NULL) {
                    $element["attributes"]["REQLEVEL"] = 0;
                }
                if ($element["attributes"]["DAMAGEMIN"] == NULL) {
                    $element["attributes"]["DAMAGEMIN"] = 0;
                }
                if ($element["attributes"]["DAMAGEMAX"] == NULL) {
                    $element["attributes"]["DAMAGEMAX"] = 0;
                }
                if ($element["attributes"]["ATTACKSPEED"] == NULL) {
                    $element["attributes"]["ATTACKSPEED"] = 0;
                }
                if ($element["attributes"]["DURABILITY"] == NULL) {
                    $element["attributes"]["DURABILITY"] = 0;
                }
                if ($element["attributes"]["MAGICDURABILITY"] == NULL) {
                    $element["attributes"]["MAGICDURABILITY"] = 0;
                }
                if ($element["attributes"]["MAGICPOWER"] == NULL) {
                    $element["attributes"]["MAGICPOWER"] = 0;
                }
                if ($element["attributes"]["REQSTRENGTH"] == NULL) {
                    $element["attributes"]["REQSTRENGTH"] = 0;
                }
                if ($element["attributes"]["REQDEXTERITY"] == NULL) {
                    $element["attributes"]["REQDEXTERITY"] = 0;
                }
                if ($element["attributes"]["REQVITALITY"] == NULL) {
                    $element["attributes"]["REQVITALITY"] = 0;
                }
                if ($element["attributes"]["REQENERGY"] == NULL) {
                    $element["attributes"]["REQENERGY"] = 0;
                }
                if ($element["attributes"]["REQCOMMAND"] == NULL) {
                    $element["attributes"]["REQCOMMAND"] = 0;
                }
                if ($section != "14") {
                    if ($element["attributes"]["DARKWIZARD"] == NULL) {
                        $element["attributes"]["DARKWIZARD"] = 0;
                    }
                    if ($element["attributes"]["DARKKNIGHT"] == NULL) {
                        $element["attributes"]["DARKKNIGHT"] = 0;
                    }
                    if ($element["attributes"]["FAIRYELF"] == NULL) {
                        $element["attributes"]["FAIRYELF"] = 0;
                    }
                    if ($element["attributes"]["MAGICGLADIATOR"] == NULL) {
                        $element["attributes"]["MAGICGLADIATOR"] = 0;
                    }
                    if ($element["attributes"]["DARKLORD"] == NULL) {
                        $element["attributes"]["DARKLORD"] = 0;
                    }
                    if ($element["attributes"]["SUMMONER"] == NULL) {
                        $element["attributes"]["SUMMONER"] = 0;
                    }
                    if ($element["attributes"]["RAGEFIGHTER"] == NULL) {
                        $element["attributes"]["RAGEFIGHTER"] = 0;
                    }
                    if ($element["attributes"]["GROWLANCER"] == NULL) {
                        $element["attributes"]["GROWLANCER"] = 0;
                    }
                    if ($element["attributes"]["RUNEWIZARD"] == NULL) {
                        $element["attributes"]["RUNEWIZARD"] = 0;
                    }
                    if ($element["attributes"]["SLAYER"] == NULL) {
                        $element["attributes"]["SLAYER"] = 0;
                    }
                } else {
                    if ($element["attributes"]["DARKWIZARD"] == NULL) {
                        $element["attributes"]["DARKWIZARD"] = 1;
                    }
                    if ($element["attributes"]["DARKKNIGHT"] == NULL) {
                        $element["attributes"]["DARKKNIGHT"] = 1;
                    }
                    if ($element["attributes"]["FAIRYELF"] == NULL) {
                        $element["attributes"]["FAIRYELF"] = 1;
                    }
                    if ($element["attributes"]["MAGICGLADIATOR"] == NULL) {
                        $element["attributes"]["MAGICGLADIATOR"] = 1;
                    }
                    if ($element["attributes"]["DARKLORD"] == NULL) {
                        $element["attributes"]["DARKLORD"] = 1;
                    }
                    if ($element["attributes"]["SUMMONER"] == NULL) {
                        $element["attributes"]["SUMMONER"] = 1;
                    }
                    if ($element["attributes"]["RAGEFIGHTER"] == NULL) {
                        $element["attributes"]["RAGEFIGHTER"] = 1;
                    }
                    if ($element["attributes"]["GROWLANCER"] == NULL) {
                        $element["attributes"]["GROWLANCER"] = 1;
                    }
                    if ($element["attributes"]["RUNEWIZARD"] == NULL) {
                        $element["attributes"]["RUNEWIZARD"] = 1;
                    }
                    if ($element["attributes"]["SLAYER"] == NULL) {
                        $element["attributes"]["SLAYER"] = 1;
                    }
                }
                if ($element["attributes"]["TYPE"] == NULL) {
                    $element["attributes"]["TYPE"] = 0;
                }
                if ($element["attributes"]["KINDA"] == NULL) {
                    $element["attributes"]["KINDA"] = 0;
                }
                if ($element["attributes"]["KINDB"] == NULL) {
                    $element["attributes"]["KINDB"] = 0;
                }
                if ($element["attributes"]["DEFENSE"] == NULL) {
                    $element["attributes"]["DEFENSE"] = 0;
                }
                if ($element["attributes"]["SUCCESSFULBLOCKING"] == NULL) {
                    $element["attributes"]["SUCCESSFULBLOCKING"] = 0;
                }
                if ($element["attributes"]["WALKSPEED"] == NULL) {
                    $element["attributes"]["WALKSPEED"] = 0;
                }
                if ($element["attributes"]["ICERES"] == NULL) {
                    $element["attributes"]["ICERES"] = 0;
                }
                if ($element["attributes"]["POISONRES"] == NULL) {
                    $element["attributes"]["POISONRES"] = 0;
                }
                if ($element["attributes"]["LIGHTRES"] == NULL) {
                    $element["attributes"]["LIGHTRES"] = 0;
                }
                if ($element["attributes"]["FIRERES"] == NULL) {
                    $element["attributes"]["FIRERES"] = 0;
                }
                if ($element["attributes"]["EARTHRES"] == NULL) {
                    $element["attributes"]["EARTHRES"] = 0;
                }
                if ($element["attributes"]["WINDRES"] == NULL) {
                    $element["attributes"]["WINDRES"] = 0;
                }
                if ($element["attributes"]["WATERRES"] == NULL) {
                    $element["attributes"]["WATERRES"] = 0;
                }
                $update = $dB->query("\r\n                    UPDATE [dbo].[IMPERIAMUCMS_ITEMS] SET\r\n                        [X] = " . $element["attributes"]["WIDTH"] . ", \r\n                        [Y] = " . $element["attributes"]["HEIGHT"] . ", \r\n                        [option] = " . $useOption . ", \r\n                        [luck] = " . $useLuck . ", \r\n                        [skill] = " . $useSkill . ", \r\n                        [item_width] = " . $element["attributes"]["WIDTH"] . ", \r\n                        [item_height] = " . $element["attributes"]["HEIGHT"] . ", \r\n                        [item_slot] = " . $element["attributes"]["SLOT"] . ", \r\n                        [item_skill_index] = " . $element["attributes"]["SKILLINDEX"] . ", \r\n                        [item_twohanded] = " . $element["attributes"]["TWOHAND"] . ", \r\n                        [item_serial] = " . $element["attributes"]["SERIAL"] . ", \r\n                        [item_req_level] = " . $element["attributes"]["REQLEVEL"] . ", \r\n                        [item_dmg_min] = " . $element["attributes"]["DAMAGEMIN"] . ", \r\n                        [item_dmg_max] = " . $element["attributes"]["DAMAGEMAX"] . ", \r\n                        [item_attack_speed] = " . $element["attributes"]["ATTACKSPEED"] . ", \r\n                        [item_dur] = " . $element["attributes"]["DURABILITY"] . ", \r\n                        [item_dur_magic] = " . $element["attributes"]["MAGICDURABILITY"] . ", \r\n                        [item_magic_power] = " . $element["attributes"]["MAGICPOWER"] . ", \r\n                        [item_req_str] = " . $element["attributes"]["REQSTRENGTH"] . ", \r\n                        [item_req_agi] = " . $element["attributes"]["REQDEXTERITY"] . ", \r\n                        [item_req_vit] = " . $element["attributes"]["REQVITALITY"] . ", \r\n                        [item_req_ene] = " . $element["attributes"]["REQENERGY"] . ", \r\n                        [item_req_cmd] = " . $element["attributes"]["REQCOMMAND"] . ", \r\n                        [item_type] = " . $element["attributes"]["TYPE"] . ", \r\n                        [item_kind_a] = " . $element["attributes"]["KINDA"] . ", \r\n                        [item_kind_b] = " . $element["attributes"]["KINDB"] . ", \r\n                        [item_def] = " . $element["attributes"]["DEFENSE"] . ", \r\n                        [item_blocking] = " . $element["attributes"]["SUCCESSFULBLOCKING"] . ", \r\n                        [item_walk_speed] = " . $element["attributes"]["WALKSPEED"] . ", \r\n                        [item_res_ice] = " . $element["attributes"]["ICERES"] . ", \r\n                        [item_res_poison] = " . $element["attributes"]["POISONRES"] . ", \r\n                        [item_res_light] = " . $element["attributes"]["LIGHTRES"] . ", \r\n                        [item_res_fire] = " . $element["attributes"]["FIRERES"] . ", \r\n                        [item_res_earth] = " . $element["attributes"]["EARTHRES"] . ", \r\n                        [item_res_wind] = " . $element["attributes"]["WINDRES"] . ", \r\n                        [item_res_water] = " . $element["attributes"]["WATERRES"] . ", \r\n                        [item_class_dw] = " . $element["attributes"]["DARKWIZARD"] . ",\r\n                        [item_class_dk] = " . $element["attributes"]["DARKKNIGHT"] . ",\r\n                        [item_class_fe] = " . $element["attributes"]["FAIRYELF"] . ",\r\n                        [item_class_mg] = " . $element["attributes"]["MAGICGLADIATOR"] . ",\r\n                        [item_class_dl] = " . $element["attributes"]["DARKLORD"] . ",\r\n                        [item_class_su] = " . $element["attributes"]["SUMMONER"] . ",\r\n                        [item_class_rf] = " . $element["attributes"]["RAGEFIGHTER"] . ",\r\n                        [item_class_gl] = " . $element["attributes"]["GROWLANCER"] . ",\r\n                        [item_class_rw] = " . $element["attributes"]["RUNEWIZARD"] . ",\r\n                        [item_class_sr] = " . $element["attributes"]["SLAYER"] . "\r\n                    WHERE [index] = " . $check["index"] . "\r\n                ");
                if ($update) {
                    message("notice", $element["attributes"]["NAME"] . " was updated. Please check it's attributes if you would like to change them.");
                }
            }
        }
    }
}
if (check_value($_POST["import_items"])) {
    $xml = file_get_contents($_FILES["itemlist"]["tmp_name"]);
    $xmlArray = [];
    $p = xml_parser_create();
    xml_parse_into_struct($p, $xml, $xmlArray);
    xml_parser_free($p);
    $section = 0;
    $i = 0;
    foreach ($xmlArray as $element) {
        if ($element["tag"] == "SECTION" && $element["type"] == "open") {
            $section = $element["attributes"]["INDEX"];
        }
        if ($element["tag"] == "ITEM") {
            $check = $dB->query_fetch_single("SELECT TOP 1 * FROM IMPERIAMUCMS_ITEMS WHERE type = ? AND id = ?", [$section, $element["attributes"]["INDEX"]]);
            if ($check["name"] == NULL) {
                if ($element["attributes"]["TYPE"] == "2") {
                    $useSocket = 1;
                    $maxSocket = 5;
                    $useHarmony = 0;
                } else {
                    $useSocket = 0;
                    $maxSocket = 0;
                    $useHarmony = 1;
                }
                if ($element["attributes"]["TYPE"] == "3") {
                    $useRefinary = 1;
                } else {
                    $useRefinary = 0;
                }
                if ($element["attributes"]["SKILLINDEX"] != "0") {
                    $useSkill = 1;
                } else {
                    $useSkill = 0;
                }
                if ("0" <= $element["attributes"]["SLOT"] && $element["attributes"]["SLOT"] <= "7") {
                    $useLuck = 1;
                } else {
                    $useLuck = 0;
                }
                if ("0" <= $element["attributes"]["SLOT"] && $element["attributes"]["SLOT"] <= "11" && $element["attributes"]["SLOT"] != "8") {
                    if (0 <= $section && $section <= 5) {
                        $useExc = 1;
                    } else {
                        if (6 <= $section && $section <= 11) {
                            $useExc = 2;
                        } else {
                            $useExc = 0;
                        }
                    }
                    $useOption = 1;
                    $maxLvl = 15;
                    $maxOpt = 7;
                    $maxExc = 6;
                } else {
                    $useExc = 0;
                    $useOption = 0;
                    $maxLvl = 0;
                    $maxOpt = 0;
                    $maxExc = 0;
                }
                if ($element["attributes"]["TYPE"] == "2") {
                    $itemClass = 5;
                } else {
                    if ($element["attributes"]["TYPE"] == "3") {
                        $itemClass = 4;
                    } else {
                        if ($element["attributes"]["TYPE"] == "1") {
                            if ("55" <= $element["attributes"]["DROPLEVEL"]) {
                                $itemClass = 3;
                            } else {
                                if ("30" <= $element["attributes"]["DROPLEVEL"]) {
                                    $itemClass = 2;
                                } else {
                                    $itemClass = 1;
                                }
                            }
                        } else {
                            $itemClass = 0;
                        }
                    }
                }
                $itemName = str_replace("'", "''", $element["attributes"]["NAME"]);
                if ($element["attributes"]["SKILLINDEX"] == NULL) {
                    $element["attributes"]["SKILLINDEX"] = 0;
                }
                if ($element["attributes"]["TWOHAND"] == NULL) {
                    $element["attributes"]["TWOHAND"] = 0;
                }
                if ($element["attributes"]["REQLEVEL"] == NULL) {
                    $element["attributes"]["REQLEVEL"] = 0;
                }
                if ($element["attributes"]["DAMAGEMIN"] == NULL) {
                    $element["attributes"]["DAMAGEMIN"] = 0;
                }
                if ($element["attributes"]["DAMAGEMAX"] == NULL) {
                    $element["attributes"]["DAMAGEMAX"] = 0;
                }
                if ($element["attributes"]["ATTACKSPEED"] == NULL) {
                    $element["attributes"]["ATTACKSPEED"] = 0;
                }
                if ($element["attributes"]["DURABILITY"] == NULL) {
                    $element["attributes"]["DURABILITY"] = 0;
                }
                if ($element["attributes"]["MAGICDURABILITY"] == NULL) {
                    $element["attributes"]["MAGICDURABILITY"] = 0;
                }
                if ($element["attributes"]["MAGICPOWER"] == NULL) {
                    $element["attributes"]["MAGICPOWER"] = 0;
                }
                if ($element["attributes"]["REQSTRENGTH"] == NULL) {
                    $element["attributes"]["REQSTRENGTH"] = 0;
                }
                if ($element["attributes"]["REQDEXTERITY"] == NULL) {
                    $element["attributes"]["REQDEXTERITY"] = 0;
                }
                if ($element["attributes"]["REQVITALITY"] == NULL) {
                    $element["attributes"]["REQVITALITY"] = 0;
                }
                if ($element["attributes"]["REQENERGY"] == NULL) {
                    $element["attributes"]["REQENERGY"] = 0;
                }
                if ($element["attributes"]["REQCOMMAND"] == NULL) {
                    $element["attributes"]["REQCOMMAND"] = 0;
                }
                if ($element["attributes"]["DARKWIZARD"] == NULL) {
                    $element["attributes"]["DARKWIZARD"] = 0;
                }
                if ($element["attributes"]["DARKKNIGHT"] == NULL) {
                    $element["attributes"]["DARKKNIGHT"] = 0;
                }
                if ($element["attributes"]["FAIRYELF"] == NULL) {
                    $element["attributes"]["FAIRYELF"] = 0;
                }
                if ($element["attributes"]["MAGICGLADIATOR"] == NULL) {
                    $element["attributes"]["MAGICGLADIATOR"] = 0;
                }
                if ($element["attributes"]["DARKLORD"] == NULL) {
                    $element["attributes"]["DARKLORD"] = 0;
                }
                if ($element["attributes"]["SUMMONER"] == NULL) {
                    $element["attributes"]["SUMMONER"] = 0;
                }
                if ($element["attributes"]["RAGEFIGHTER"] == NULL) {
                    $element["attributes"]["RAGEFIGHTER"] = 0;
                }
                if ($element["attributes"]["GROWLANCER"] == NULL) {
                    $element["attributes"]["GROWLANCER"] = 0;
                }
                if ($element["attributes"]["RUNEWIZARD"] == NULL) {
                    $element["attributes"]["RUNEWIZARD"] = 0;
                }
                if ($element["attributes"]["SLAYER"] == NULL) {
                    $element["attributes"]["SLAYER"] = 0;
                }
                if ($element["attributes"]["TYPE"] == NULL) {
                    $element["attributes"]["TYPE"] = 0;
                }
                if ($element["attributes"]["KINDA"] == NULL) {
                    $element["attributes"]["KINDA"] = 0;
                }
                if ($element["attributes"]["KINDB"] == NULL) {
                    $element["attributes"]["KINDB"] = 0;
                }
                if ($element["attributes"]["DEFENSE"] == NULL) {
                    $element["attributes"]["DEFENSE"] = 0;
                }
                if ($element["attributes"]["SUCCESSFULBLOCKING"] == NULL) {
                    $element["attributes"]["SUCCESSFULBLOCKING"] = 0;
                }
                if ($element["attributes"]["WALKSPEED"] == NULL) {
                    $element["attributes"]["WALKSPEED"] = 0;
                }
                if ($element["attributes"]["ICERES"] == NULL) {
                    $element["attributes"]["ICERES"] = 0;
                }
                if ($element["attributes"]["POISONRES"] == NULL) {
                    $element["attributes"]["POISONRES"] = 0;
                }
                if ($element["attributes"]["LIGHTRES"] == NULL) {
                    $element["attributes"]["LIGHTRES"] = 0;
                }
                if ($element["attributes"]["FIRERES"] == NULL) {
                    $element["attributes"]["FIRERES"] = 0;
                }
                if ($element["attributes"]["EARTHRES"] == NULL) {
                    $element["attributes"]["EARTHRES"] = 0;
                }
                if ($element["attributes"]["WINDRES"] == NULL) {
                    $element["attributes"]["WINDRES"] = 0;
                }
                if ($element["attributes"]["WATERRES"] == NULL) {
                    $element["attributes"]["WATERRES"] = 0;
                }
                $insert = $dB->query("\r\n                    INSERT INTO [dbo].[IMPERIAMUCMS_ITEMS]\r\n                       ([name]\r\n                       ,[id]\r\n                       ,[type]\r\n                       ,[level]\r\n                       ,[X]\r\n                       ,[Y]\r\n                       ,[option]\r\n                       ,[exc]\r\n                       ,[purple]\r\n                       ,[sell]\r\n                       ,[class]\r\n                       ,[luck]\r\n                       ,[skill]\r\n                       ,[max_level]\r\n                       ,[max_option]\r\n                       ,[max_exc]\r\n                       ,[use_harmony]\r\n                       ,[use_refinary]\r\n                       ,[use_sockets]\r\n                       ,[max_sockets]\r\n                       ,[payment_type]\r\n                       ,[item_slot]\r\n                       ,[item_skill_index]\r\n                       ,[item_twohanded]\r\n                       ,[item_width]\r\n                       ,[item_height]\r\n                       ,[item_serial]\r\n                       ,[item_req_level]\r\n                       ,[item_dmg_min]\r\n                       ,[item_dmg_max]\r\n                       ,[item_attack_speed]\r\n                       ,[item_dur]\r\n                       ,[item_dur_magic]\r\n                       ,[item_magic_power]\r\n                       ,[item_req_str]\r\n                       ,[item_req_agi]\r\n                       ,[item_req_vit]\r\n                       ,[item_req_ene]\r\n                       ,[item_req_cmd]\r\n                       ,[item_class_dw]\r\n                       ,[item_class_dk]\r\n                       ,[item_class_fe]\r\n                       ,[item_class_mg]\r\n                       ,[item_class_dl]\r\n                       ,[item_class_su]\r\n                       ,[item_class_rf]\r\n                       ,[item_class_gl]\r\n                       ,[item_class_rw]\r\n                       ,[item_class_sr]\r\n                       ,[item_type]\r\n                       ,[item_kind_a]\r\n                       ,[item_kind_b]\r\n                       ,[item_def]\r\n                       ,[item_blocking]\r\n                       ,[item_walk_speed]\r\n                       ,[item_res_ice]\r\n                       ,[item_res_poison]\r\n                       ,[item_res_light]\r\n                       ,[item_res_fire]\r\n                       ,[item_res_earth]\r\n                       ,[item_res_wind]\r\n                       ,[item_res_water])\r\n                    VALUES (\r\n                        N'" . $itemName . "', \r\n                        " . $element["attributes"]["INDEX"] . ", \r\n                        " . $section . ", \r\n                        0, \r\n                        " . $element["attributes"]["WIDTH"] . ", \r\n                        " . $element["attributes"]["HEIGHT"] . ", \r\n                        " . $useOption . ", \r\n                        " . $useExc . ", \r\n                        " . $useSocket . ", \r\n                        1, \r\n                        " . $itemClass . ", \r\n                        " . $useLuck . ", \r\n                        " . $useSkill . ", \r\n                        " . $maxLvl . ", \r\n                        " . $maxOpt . ", \r\n                        " . $maxExc . ", \r\n                        " . $useHarmony . ", \r\n                        " . $useRefinary . ", \r\n                        " . $useSocket . ", \r\n                        " . $maxSocket . ", \r\n                        0,\r\n                        " . $element["attributes"]["SLOT"] . ",\r\n                        " . $element["attributes"]["SKILLINDEX"] . ",\r\n                        " . $element["attributes"]["TWOHAND"] . ",\r\n                        " . $element["attributes"]["WIDTH"] . ",\r\n                        " . $element["attributes"]["HEIGHT"] . ",\r\n                        " . $element["attributes"]["SERIAL"] . ",\r\n                        " . $element["attributes"]["REQLEVEL"] . ",\r\n                        " . $element["attributes"]["DAMAGEMIN"] . ",\r\n                        " . $element["attributes"]["DAMAGEMAX"] . ",\r\n                        " . $element["attributes"]["ATTACKSPEED"] . ",\r\n                        " . $element["attributes"]["DURABILITY"] . ",\r\n                         " . $element["attributes"]["MAGICDURABILITY"] . ",\r\n                        " . $element["attributes"]["MAGICPOWER"] . ",\r\n                        " . $element["attributes"]["REQSTRENGTH"] . ",\r\n                        " . $element["attributes"]["REQDEXTERITY"] . ",\r\n                        " . $element["attributes"]["REQVITALITY"] . ",\r\n                        " . $element["attributes"]["REQENERGY"] . ",\r\n                        " . $element["attributes"]["REQCOMMAND"] . ",\r\n                        " . $element["attributes"]["DARKWIZARD"] . ",\r\n                        " . $element["attributes"]["DARKKNIGHT"] . ",\r\n                        " . $element["attributes"]["FAIRYELF"] . ",\r\n                        " . $element["attributes"]["MAGICGLADIATOR"] . ",\r\n                        " . $element["attributes"]["DARKLORD"] . ",\r\n                        " . $element["attributes"]["SUMMONER"] . ",\r\n                        " . $element["attributes"]["RAGEFIGHTER"] . ",\r\n                        " . $element["attributes"]["GROWLANCER"] . ",\r\n                        " . $element["attributes"]["RUNEWIZARD"] . ",\r\n                        " . $element["attributes"]["SLAYER"] . ",\r\n                        " . $element["attributes"]["TYPE"] . ",\r\n                        " . $element["attributes"]["KINDA"] . ",\r\n                        " . $element["attributes"]["KINDB"] . ",\r\n                        " . $element["attributes"]["DEFENSE"] . ",\r\n                        " . $element["attributes"]["SUCCESSFULBLOCKING"] . ",\r\n                        " . $element["attributes"]["WALKSPEED"] . ",\r\n                        " . $element["attributes"]["ICERES"] . ",\r\n                        " . $element["attributes"]["POISONRES"] . ",\r\n                        " . $element["attributes"]["LIGHTRES"] . ",\r\n                        " . $element["attributes"]["FIRERES"] . ",\r\n                        " . $element["attributes"]["EARTHRES"] . ",\r\n                        " . $element["attributes"]["WINDRES"] . ",\r\n                        " . $element["attributes"]["WATERRES"] . "\r\n                    )");
                if ($insert) {
                    message("notice", $element["attributes"]["NAME"] . " was added into database. Please check it's attributes if you would like to change them.");
                }
            }
        }
    }
}
if (check_value($_POST["import_castlesiege"])) {
    $xml = file_get_contents($_FILES["castlesiege"]["tmp_name"]);
    $xmlArray = [];
    $p = xml_parser_create();
    xml_parse_into_struct($p, $xml, $xmlArray);
    xml_parser_free($p);
    $configs = [];
    foreach ($xmlArray as $element) {
        if ($element["tag"] == "CYCLE") {
            if ($element["attributes"]["HOUR"] == "0") {
                $element["attributes"]["HOUR"] = "00";
            }
            if ($element["attributes"]["MINUTE"] == "0") {
                $element["attributes"]["MINUTE"] = "00";
            }
            if ($element["attributes"]["STAGE"] == "1") {
                $configs["setting_2"] = $element["attributes"]["DAY"];
                $configs["setting_3"] = $element["attributes"]["HOUR"] . ":" . $element["attributes"]["MINUTE"];
            } else {
                if ($element["attributes"]["STAGE"] == "2") {
                    $configs["setting_4"] = $element["attributes"]["DAY"];
                    $configs["setting_5"] = $element["attributes"]["HOUR"] . ":" . $element["attributes"]["MINUTE"];
                } else {
                    if ($element["attributes"]["STAGE"] == "3") {
                        $configs["setting_6"] = $element["attributes"]["DAY"];
                        $configs["setting_7"] = $element["attributes"]["HOUR"] . ":" . $element["attributes"]["MINUTE"];
                    } else {
                        if ($element["attributes"]["STAGE"] == "4") {
                            $configs["setting_8"] = $element["attributes"]["DAY"];
                            $configs["setting_9"] = $element["attributes"]["HOUR"] . ":" . $element["attributes"]["MINUTE"];
                        } else {
                            if ($element["attributes"]["STAGE"] == "5") {
                                $configs["setting_10"] = $element["attributes"]["DAY"];
                                $configs["setting_11"] = $element["attributes"]["HOUR"] . ":" . $element["attributes"]["MINUTE"];
                            } else {
                                if ($element["attributes"]["STAGE"] == "6") {
                                    $configs["setting_12"] = $element["attributes"]["DAY"];
                                    $configs["setting_13"] = $element["attributes"]["HOUR"] . ":" . $element["attributes"]["MINUTE"];
                                } else {
                                    if ($element["attributes"]["STAGE"] == "7") {
                                        $configs["setting_14"] = $element["attributes"]["DAY"];
                                        $configs["setting_15"] = $element["attributes"]["HOUR"] . ":" . $element["attributes"]["MINUTE"];
                                    } else {
                                        if ($element["attributes"]["STAGE"] == "8") {
                                            $configs["setting_16"] = $element["attributes"]["DAY"];
                                            $configs["setting_17"] = $element["attributes"]["HOUR"] . ":" . $element["attributes"]["MINUTE"];
                                        } else {
                                            if ($element["attributes"]["STAGE"] == "9") {
                                                $configs["setting_18"] = $element["attributes"]["DAY"];
                                                $configs["setting_19"] = $element["attributes"]["HOUR"] . ":" . $element["attributes"]["MINUTE"];
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
    $xmlPath = __PATH_MODULE_CONFIGS__ . "castlesiege.xml";
    $xml = simplexml_load_file($xmlPath);
    $xml->cs_period_register_day = $configs["setting_2"];
    $xml->cs_period_register_time = $configs["setting_3"];
    $xml->cs_period_idle1_day = $configs["setting_4"];
    $xml->cs_period_idle1_time = $configs["setting_5"];
    $xml->cs_period_registermark_day = $configs["setting_6"];
    $xml->cs_period_registermark_time = $configs["setting_7"];
    $xml->cs_period_idle2_day = $configs["setting_8"];
    $xml->cs_period_idle2_time = $configs["setting_9"];
    $xml->cs_period_notification_day = $configs["setting_10"];
    $xml->cs_period_notification_time = $configs["setting_11"];
    $xml->cs_period_ready_day = $configs["setting_12"];
    $xml->cs_period_ready_time = $configs["setting_13"];
    $xml->cs_period_start_day = $configs["setting_14"];
    $xml->cs_period_start_time = $configs["setting_15"];
    $xml->cs_period_end_day = $configs["setting_16"];
    $xml->cs_period_end_time = $configs["setting_17"];
    $xml->cs_period_cycle_day = $configs["setting_18"];
    $xml->cs_period_cycle_time = $configs["setting_19"];
    $save = $xml->asXML($xmlPath);
    if ($save) {
        message("success", "Castle Siege settings were successfully imported.");
    } else {
        message("error", "There has been an error while importing settings.");
    }
}
if (check_value($_POST["generate_monsterkillcount"])) {
    $xml = file_get_contents($_FILES["xml"]["tmp_name"]);
    $xmlArray = [];
    $p = xml_parser_create();
    xml_parse_into_struct($p, $xml, $xmlArray);
    xml_parser_free($p);
    $skills = [];
    echo "<pre>";
    echo htmlentities("<?xml version=\"1.0\" encoding=\"utf-8\"?>\r\n<!-- \r\n// ============================================================\r\n// == INTERNATIONAL GAMING CENTER NETWORK\r\n// == www.igcn.mu\r\n// == (C) 2019 IGC-Network (R)\r\n// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\r\n// == Modify if you know what you do only!\r\n// == File is a part of IGCN Group MuOnline Server files.\r\n// ============================================================\r\n//\r\n// ### MonsterKillCount::Monster ###\r\n//\tIndex: Index of a monster, see MonsterList.xml\r\n//\tEnable: Allows to enable or disable specified record, 0/1\r\n//\r\n//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\r\n//~~ Kill count of monsters for which Index was configured will be recorded \r\n//~~ in database -> MuOnline.[dbo].[C_Monster_KillCount]\r\n//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\r\n//\r\n// STRICTLY NO COMMENTS INSIDE TAGS \r\n-->\r\n\r\n<MonsterKillCount>");
    echo "<br />";
    foreach ($xmlArray as $element) {
        if ($element["tag"] == "MONSTER") {
            echo "\t" . htmlentities("<Monster Index=\"" . $element["attributes"]["INDEX"] . "\" Enable=\"1\" />");
            echo "<br />";
        }
    }
    echo htmlentities("</MonsterKillCount>");
    echo "</pre>";
}
if (check_value($_POST["SkillTreeData_3rd"])) {
    $xml = file_get_contents($_FILES["xml"]["tmp_name"]);
    $xmlArray = [];
    $p = xml_parser_create();
    xml_parse_into_struct($p, $xml, $xmlArray);
    xml_parser_free($p);
    $skills = [];
    foreach ($xmlArray as $element) {
        if ($element["tag"] == "SKILL" && ($element["attributes"]["USETYPE"] == "3" || $element["attributes"]["USETYPE"] == "4")) {
            array_push($skills, $element["attributes"]["INDEX"]);
        }
    }
    asort($skills);
    foreach ($skills as $thisSkill) {
        echo "'" . $thisSkill . "', ";
    }
}
if (check_value($_POST["show_webshop_items"])) {
    $items = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_ITEMS WHERE type <= 11 AND item_class_sr > 0 ORDER BY type, id");
    $Items = new Items();
    foreach ($items as $thisItem) {
        if (substr($thisItem["name"], 0, 7) != "[Bound]") {
            $exetype = 1;
            if (6 <= $thisItem["type"]) {
                $exetype = 2;
            }
            $itemData = $Items->loadItemFromItemList($thisItem["type"], $thisItem["id"]);
            $skill = 0;
            if (0 < $itemData["SkillIndex"]) {
                $skill = 1;
            }
            $socket = 0;
            $maxsocket = 0;
            if ($itemData["Type"] == "2") {
                $socket = 1;
                $maxsocket = 5;
            }
            $refinary = 0;
            if ($itemData["Type"] == "3") {
                $refinary = 1;
            }
            if ($socket == 0) {
                $harmony = 1;
            } else {
                $harmony = 0;
            }
            echo "INSERT [dbo].[IMPERIAMUCMS_WEBSHOP_ITEMS] ([item_id], [item_cat], [max_item_lvl], [max_item_opt], [exetype], [name], [price], \r\n            [luck], [skill], [use_sockets], [use_harmony], [use_refinary], [total_bought], [payment_type], [description], [main_cat], [sub_cat], \r\n            [image], [on_sale], [item_lvl], [store_count], [item_exc], [status], \r\n            [max_exc_opt], [max_socket], [can_gift]) \r\n            VALUES (" . $thisItem["id"] . ", " . $thisItem["type"] . ", 15, 7, " . $exetype . ", N'" . $thisItem["name"] . "', " . $itemData["DropLevel"] * 4 . ", \r\n            1, " . $skill . ", " . $socket . ", " . $harmony . ", " . $refinary . ", 0, 1, NULL, " . $thisItem["type"] . ", 1, \r\n            NULL, 0, 0, -1, 0, 1, 6, " . $maxsocket . ", 1)<br>";
        }
    }
}
if (check_value($_POST["MonsterListLang"])) {
    $xml = file_get_contents($_FILES["xml"]["tmp_name"]);
    $xmlArray = [];
    $p = xml_parser_create();
    xml_parse_into_struct($p, $xml, $xmlArray);
    xml_parser_free($p);
    $skills = [];
    echo "<pre>";
    foreach ($xmlArray as $element) {
        if ($element["tag"] == "MONSTER") {
            echo "\$lang['monster_" . $element["attributes"]["INDEX"] . "'] = '" . addslashes($element["attributes"]["NAME"]) . "';<br>";
        }
    }
    echo "</pre>";
}
echo "\r\n<h2>Special Tools</h2>\r\n\r\n<table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n    <tr>\r\n        <th>Fix Item Indexes<br><span>Script will fix broken indexes of items in database.</span></th>\r\n        <td>\r\n            <form action=\"\" method=\"post\">\r\n                <input id=\"fix_item_indexes\" name=\"fix_item_indexes\" type=\"submit\" class=\"btn btn-primary\" value=\"Submit\">\r\n            </form>\r\n        </td>\r\n    </tr>\r\n    <tr>\r\n        <th>Add Items into Database<br><span>Upload ItemList.xml from server files. After submit script will add missing items into database.</span></th>\r\n        <td>\r\n            <form action=\"\" method=\"post\" enctype=\"multipart/form-data\">\r\n                <input id=\"itemlist\" name=\"itemlist\" type=\"file\" class=\"file\" data-preview-file-type=\"text\">\r\n                <input id=\"import_items\" name=\"import_items\" type=\"hidden\" value=\"1\">\r\n            </form>\r\n        </td>\r\n    </tr>\r\n    <tr>\r\n        <th>Update Items in Database<br><span>Upload ItemList.xml from server files. After submit script will update items in database with new values. Script will update class requirements and items' stats.</span>\r\n        </th>\r\n        <td>\r\n            <form action=\"\" method=\"post\" enctype=\"multipart/form-data\">\r\n                <input id=\"itemlist\" name=\"itemlist\" type=\"file\" class=\"file\" data-preview-file-type=\"text\">\r\n                <input id=\"update_items\" name=\"update_items\" type=\"hidden\" value=\"1\">\r\n            </form>\r\n        </td>\r\n    </tr>\r\n    <tr>\r\n        <th>Add Items into Webshop<br><span>Upload ItemList.xml from server files. After submit script will add missing items into webshop database.<br>NOTE: Tool will import only categories 0 - 11 (weapons, shields and parts of sets). Wings, rings, pendants, pentagrams, scrolls, etc. are not imported!</span>\r\n        </th>\r\n        <td>\r\n            <form action=\"\" method=\"post\" enctype=\"multipart/form-data\">\r\n                <input id=\"itemlist\" name=\"itemlist\" type=\"file\" class=\"file\" data-preview-file-type=\"text\">\r\n                <input id=\"import_webshop_items\" name=\"import_webshop_items\" type=\"hidden\" value=\"1\">\r\n            </form>\r\n        </td>\r\n    </tr>\r\n    <tr>\r\n        <th>Import Castle Siege Settings<br><span>Upload CastleSiege.xml from server files. After submit script will import Castle Siege settings into website module.</span></th>\r\n        <td>\r\n            <form action=\"\" method=\"post\" enctype=\"multipart/form-data\">\r\n                <input id=\"castlesiege\" name=\"castlesiege\" type=\"file\" class=\"file\" data-preview-file-type=\"text\">\r\n                <input id=\"import_castlesiege\" name=\"import_castlesiege\" type=\"hidden\" value=\"1\">\r\n            </form>\r\n        </td>\r\n    </tr>\r\n    <tr>\r\n        <th>Generate MonsterKillCount\r\n            XML<br><span>Generates XML data for MonsterKillCount.xml file. Upload MonsterList.xml from server files. Copy generated data into MonsterKillCount.xml file.</span></th>\r\n        <td>\r\n            <form action=\"\" method=\"post\" enctype=\"multipart/form-data\">\r\n                <input id=\"xml\" name=\"xml\" type=\"file\" class=\"file\" data-preview-file-type=\"text\">\r\n                <input id=\"generate_monsterkillcount\" name=\"generate_monsterkillcount\" type=\"hidden\" value=\"1\">\r\n            </form>\r\n        </td>\r\n    </tr>\r\n</table>\r\n\r\n<br/><br/>\r\n\r\n<h4>Development Tools<br/><small>Used for development purposes of ImperiaMuCMS.</small></h4>\r\n<table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n    <tr>\r\n        <th>Display Indexes for 3rd Skill Tree<br><span>Upload SkillList.xml from server files. After submit script will show indexes for 3rd skill tree skills.</span></th>\r\n        <td>\r\n            <form action=\"\" method=\"post\" enctype=\"multipart/form-data\">\r\n                <input id=\"xml\" name=\"xml\" type=\"file\" class=\"file\" data-preview-file-type=\"text\">\r\n                <input id=\"SkillTreeData_3rd\" name=\"SkillTreeData_3rd\" type=\"hidden\" value=\"1\">\r\n            </form>\r\n        </td>\r\n    </tr>\r\n    <tr>\r\n        <th>Display query for Webshop items<br><span>Shows query to import items into Webshop for new class.</span></th>\r\n        <td>\r\n            <form action=\"\" method=\"post\">\r\n                <!--<input id=\"class\" name=\"class\" type=\"text\" class=\"form-control\">-->\r\n                <input id=\"show_webshop_items\" name=\"show_webshop_items\" type=\"submit\" class=\"btn btn-primary\" value=\"Submit\">\r\n            </form>\r\n        </td>\r\n    </tr>\r\n    <tr>\r\n        <th>Display query for items<br><span>Shows query to import items for installation database.</span></th>\r\n        <td>\r\n            <form action=\"\" method=\"post\">\r\n                <!--<input id=\"class\" name=\"class\" type=\"text\" class=\"form-control\">-->\r\n                <input id=\"show_fix_item_indexes\" name=\"show_fix_item_indexes\" type=\"submit\" class=\"btn btn-primary\" value=\"Submit\">\r\n            </form>\r\n        </td>\r\n    </tr>\r\n    <tr>\r\n        <th>Generate Language strings for Monsters<br><span>Upload MonsterList.xml from server files. After submit script will generate language strings for each monster.</span></th>\r\n        <td>\r\n            <form action=\"\" method=\"post\" enctype=\"multipart/form-data\">\r\n                <input id=\"xml\" name=\"xml\" type=\"file\" class=\"file\" data-preview-file-type=\"text\">\r\n                <input id=\"MonsterListLang\" name=\"MonsterListLang\" type=\"hidden\" value=\"1\">\r\n            </form>\r\n        </td>\r\n    </tr>\r\n</table>\r\n\r\n<script type=\"text/javascript\" language=\"javascript\" class=\"init\">\r\n    \$(document).ready(function () {\r\n        \$(\"#itemlist\").fileinput();\r\n        \$(\"#castlesiege\").fileinput();\r\n    });\r\n</script>";

?>