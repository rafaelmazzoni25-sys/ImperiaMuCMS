<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h2>Character Reset Settings</h2>\r\n\r\n<script>\r\n    function popitup(url) {\r\n        newwindow = window.open(url, 'name', 'height = 550, width = 600');\r\n        if (window.focus) {\r\n            newwindow.focus()\r\n        }\r\n        return false;\r\n    }\r\n</script>\r\n\r\n<style>\r\n    .hidden {\r\n        display: none;\r\n    }\r\n</style>\r\n";
echo "<script type=\"text/javascript\" SRC=\"" . __PATH_TEMPLATE__ . "js/tooltip.js\"></script>";
$Items = new Items();
$customItems = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_WEB_BANK_CUSTOM");
if (check_value($_GET["delete"])) {
    $xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "usercp.reset.xml");
    if ($xml !== false) {
        $array = [];
        $array["active"] = trim($xml->active);
        $array["keep_gr_bonus"] = trim($xml->keep_gr_bonus);
        $array["check_equip_0"] = trim($xml->check_equip_0);
        $array["check_equip_1"] = trim($xml->check_equip_1);
        $array["check_equip_2"] = trim($xml->check_equip_2);
        $array["check_equip_3"] = trim($xml->check_equip_3);
        $array["check_equip_4"] = trim($xml->check_equip_4);
        $array["check_equip_5"] = trim($xml->check_equip_5);
        $array["check_equip_6"] = trim($xml->check_equip_6);
        $array["check_equip_7"] = trim($xml->check_equip_7);
        $array["check_equip_8"] = trim($xml->check_equip_8);
        $array["check_equip_9"] = trim($xml->check_equip_9);
        $array["check_equip_10"] = trim($xml->check_equip_10);
        $array["check_equip_11"] = trim($xml->check_equip_11);
        $array["check_equip_236"] = trim($xml->check_equip_236);
        $array["check_equip_237"] = trim($xml->check_equip_237);
        $array["check_equip_238"] = trim($xml->check_equip_238);
        $array["stage_price_separate"] = trim($xml->stage_price_separate);
        $found = false;
        $i = 1;
        foreach ($xml->resets->children() as $tag => $reset) {
            if ($tag == "reset") {
                if (intval($reset["id"]) == intval($_GET["delete"])) {
                    $found = true;
                } else {
                    $array["resets"][$i]["id"] = intval($reset["id"]);
                    $array["resets"][$i]["req_reset_min"] = intval($reset["req_reset_min"]);
                    $array["resets"][$i]["req_reset_max"] = intval($reset["req_reset_max"]);
                    $array["resets"][$i]["price_req"] = intval($reset["price_req"]);
                    $array["resets"][$i]["price_type"] = intval($reset["price_type"]);
                    $array["resets"][$i]["price"] = intval($reset["price"]);
                    $array["resets"][$i]["price_vip"] = intval($reset["price_vip"]);
                    $array["resets"][$i]["price_formula"] = intval($reset["price_formula"]);
                    $array["resets"][$i]["req_lvl"] = intval($reset["req_lvl"]);
                    $array["resets"][$i]["req_lvl_vip"] = intval($reset["req_lvl_vip"]);
                    $array["resets"][$i]["req_mlvl"] = intval($reset["req_mlvl"]);
                    $array["resets"][$i]["req_mlvl_vip"] = intval($reset["req_mlvl_vip"]);
                    $array["resets"][$i]["apply_equip_check"] = intval($reset["apply_equip_check"]);
                    $array["resets"][$i]["items_req"] = intval($reset["items_req"]);
                    $array["resets"][$i]["reset_stats"] = intval($reset["reset_stats"]);
                    $array["resets"][$i]["bonus_stats_type"] = intval($reset["bonus_stats_type"]);
                    if (intval($reset["bonus_stats_type"]) == "1") {
                        foreach ($custom["character_class"] as $classCode => $thisClass) {
                            $array["resets"][$i]["bonus_stats_" . $classCode] = intval($reset["bonus_stats_" . $classCode]);
                            $array["resets"][$i]["bonus_stats_vip_" . $classCode] = intval($reset["bonus_stats_vip_" . $classCode]);
                        }
                    } else {
                        $array["resets"][$i]["bonus_stats"] = intval($reset["bonus_stats"]);
                        $array["resets"][$i]["bonus_stats_vip"] = intval($reset["bonus_stats_vip"]);
                    }
                    $array["resets"][$i]["bonus_stats_formula"] = intval($reset["bonus_stats_formula"]);
                    $array["resets"][$i]["is_cred_reward"] = intval($reset["is_cred_reward"]);
                    $array["resets"][$i]["cred_reward"] = intval($reset["cred_reward"]);
                    $array["resets"][$i]["cred_reward_vip"] = intval($reset["cred_reward_vip"]);
                    $array["resets"][$i]["credit_config"] = intval($reset["credit_config"]);
                    $array["resets"][$i]["clear_ml"] = intval($reset["clear_ml"]);
                    $array["resets"][$i]["clear_ml_tree"] = intval($reset["clear_ml_tree"]);
                    $array["resets"][$i]["clear_4th_tree"] = intval($reset["clear_4th_tree"]);
                    $array["resets"][$i]["lvl_after_reset"] = intval($reset["lvl_after_reset"]);
                    $array["resets"][$i]["lvl_after_reset_vip"] = intval($reset["lvl_after_reset_vip"]);
                    $array["resets"][$i]["exp_after_reset"] = intval($reset["exp_after_reset"]);
                    $array["resets"][$i]["exp_after_reset_vip"] = intval($reset["exp_after_reset_vip"]);
                    $array["resets"][$i]["map_after_reset"] = intval($reset["map_after_reset"]);
                    $array["resets"][$i]["map_coord_x_after_reset"] = intval($reset["map_coord_x_after_reset"]);
                    $array["resets"][$i]["map_coord_y_after_reset"] = intval($reset["map_coord_y_after_reset"]);
                    $array["resets"][$i]["time"] = intval($reset["time"]);
                    $array["resets"][$i]["time_vip"] = intval($reset["time_vip"]);
                    $reset_req_items = [];
                    $xy = 0;
                    foreach ($reset->req_items->children() as $thisItem) {
                        $reset_req_items[$xy]["hexcode"] = strval($thisItem["hexcode"]);
                        $reset_req_items[$xy]["count"] = intval($thisItem["count"]);
                        $reset_req_items[$xy]["level"] = intval($thisItem["level"]);
                        $reset_req_items[$xy]["option"] = intval($thisItem["option"]);
                        $reset_req_items[$xy]["durability"] = intval($thisItem["durability"]);
                        $reset_req_items[$xy]["luck"] = intval($thisItem["luck"]);
                        $reset_req_items[$xy]["skill"] = intval($thisItem["skill"]);
                        $reset_req_items[$xy]["excellent"] = intval($thisItem["excellent"]);
                        $reset_req_items[$xy]["ancient"] = intval($thisItem["ancient"]);
                        $reset_req_items[$xy]["harmony"] = intval($thisItem["harmony"]);
                        $reset_req_items[$xy]["guardian"] = intval($thisItem["guardian"]);
                        $reset_req_items[$xy]["socket"] = intval($thisItem["socket"]);
                        $xy++;
                    }
                    $array["resets"][$i]["req_items"] = $reset_req_items;
                    $i++;
                }
            }
        }
        $tmp = arraytoxml($array);
        file_put_contents(__PATH_MODULE_CONFIGS__ . "usercp.reset.xml", $tmp);
        if ($found) {
            message("success", "Reset Stage #" . intval($_GET["delete"]) . " was successfully deleted.");
        }
    }
}
if (check_value($_POST["submit_changes"])) {
    savechanges();
}
if (check_value($_POST["add_stage"])) {
    if (check_value($_POST["id"]) && check_value($_POST["req_reset_min"]) && check_value($_POST["req_reset_max"]) && check_value($_POST["price_req"]) && check_value($_POST["price_type"]) && check_value($_POST["price"]) && check_value($_POST["price_vip"]) && check_value($_POST["price_formula"]) && check_value($_POST["req_lvl"]) && check_value($_POST["req_lvl_vip"]) && check_value($_POST["req_mlvl"]) && check_value($_POST["req_mlvl_vip"]) && check_value($_POST["apply_equip_check"]) && check_value($_POST["items_req"]) && check_value($_POST["reset_stats"]) && (check_value($_POST["bonus_stats_type"] == "1") && check_value($_POST["bonus_stats"]) && check_value($_POST["bonus_stats_vip"]) || check_value($_POST["bonus_stats_type"] == "0")) && check_value($_POST["bonus_stats_formula"]) && check_value($_POST["is_cred_reward"]) && check_value($_POST["cred_reward"]) && check_value($_POST["cred_reward_vip"]) && check_value($_POST["credit_config"]) && check_value($_POST["clear_ml"]) && check_value($_POST["clear_ml_tree"]) && check_value($_POST["lvl_after_reset"]) && check_value($_POST["lvl_after_reset_vip"]) && check_value($_POST["exp_after_reset"]) && check_value($_POST["exp_after_reset_vip"]) && check_value($_POST["time"]) && check_value($_POST["time_vip"]) && check_value($_POST["map_after_reset"]) && check_value($_POST["map_coord_x_after_reset"]) && check_value($_POST["map_coord_y_after_reset"])) {
        $xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "usercp.reset.xml");
        if ($xml !== false) {
            $array = [];
            $array["active"] = trim($xml->active);
            $array["keep_gr_bonus"] = trim($xml->keep_gr_bonus);
            $array["check_equip_0"] = trim($xml->check_equip_0);
            $array["check_equip_1"] = trim($xml->check_equip_1);
            $array["check_equip_2"] = trim($xml->check_equip_2);
            $array["check_equip_3"] = trim($xml->check_equip_3);
            $array["check_equip_4"] = trim($xml->check_equip_4);
            $array["check_equip_5"] = trim($xml->check_equip_5);
            $array["check_equip_6"] = trim($xml->check_equip_6);
            $array["check_equip_7"] = trim($xml->check_equip_7);
            $array["check_equip_8"] = trim($xml->check_equip_8);
            $array["check_equip_9"] = trim($xml->check_equip_9);
            $array["check_equip_10"] = trim($xml->check_equip_10);
            $array["check_equip_11"] = trim($xml->check_equip_11);
            $array["check_equip_236"] = trim($xml->check_equip_236);
            $array["check_equip_237"] = trim($xml->check_equip_237);
            $array["check_equip_238"] = trim($xml->check_equip_238);
            $array["stage_price_separate"] = trim($xml->stage_price_separate);
            $error = false;
            $newPos = -1;
            $j = 0;
            foreach ($xml->resets->children() as $tag => $reset) {
                if ($tag == "reset") {
                    if (intval($reset["id"]) == intval($_POST["id"])) {
                        message("error", "ID " . intval($_POST["id"]) . " already exists, please select another value.");
                        $error = true;
                        if (!$error) {
                            $i = 1;
                            $bonusPerClassError = false;
                            foreach ($xml->resets->children() as $tag => $reset) {
                                if ($tag == "reset") {
                                    if ($newPos == $i) {
                                        $reset_req_items = [];
                                        $xy = 0;
                                        foreach ($reset->req_items->children() as $thisItem) {
                                            $reset_req_items[$xy]["hexcode"] = strval($thisItem["hexcode"]);
                                            $reset_req_items[$xy]["count"] = intval($thisItem["count"]);
                                            $reset_req_items[$xy]["level"] = intval($thisItem["level"]);
                                            $reset_req_items[$xy]["option"] = intval($thisItem["option"]);
                                            $reset_req_items[$xy]["durability"] = intval($thisItem["durability"]);
                                            $reset_req_items[$xy]["luck"] = intval($thisItem["luck"]);
                                            $reset_req_items[$xy]["skill"] = intval($thisItem["skill"]);
                                            $reset_req_items[$xy]["excellent"] = intval($thisItem["excellent"]);
                                            $reset_req_items[$xy]["ancient"] = intval($thisItem["ancient"]);
                                            $reset_req_items[$xy]["harmony"] = intval($thisItem["harmony"]);
                                            $reset_req_items[$xy]["guardian"] = intval($thisItem["guardian"]);
                                            $reset_req_items[$xy]["socket"] = intval($thisItem["socket"]);
                                            $xy++;
                                        }
                                        $array["resets"][$i]["id"] = intval($reset["id"]);
                                        $array["resets"][$i]["req_reset_min"] = intval($reset["req_reset_min"]);
                                        $array["resets"][$i]["req_reset_max"] = intval($reset["req_reset_max"]);
                                        $array["resets"][$i]["price_req"] = intval($reset["price_req"]);
                                        $array["resets"][$i]["price_type"] = intval($reset["price_type"]);
                                        $array["resets"][$i]["price"] = intval($reset["price"]);
                                        $array["resets"][$i]["price_vip"] = intval($reset["price_vip"]);
                                        $array["resets"][$i]["price_formula"] = intval($reset["price_formula"]);
                                        $array["resets"][$i]["req_lvl"] = intval($reset["req_lvl"]);
                                        $array["resets"][$i]["req_lvl_vip"] = intval($reset["req_lvl_vip"]);
                                        $array["resets"][$i]["req_mlvl"] = intval($reset["req_mlvl"]);
                                        $array["resets"][$i]["req_mlvl_vip"] = intval($reset["req_mlvl_vip"]);
                                        $array["resets"][$i]["apply_equip_check"] = intval($reset["apply_equip_check"]);
                                        $array["resets"][$i]["items_req"] = intval($reset["items_req"]);
                                        $array["resets"][$i]["req_items"] = $reset_req_items;
                                        $array["resets"][$i]["reset_stats"] = intval($reset["reset_stats"]);
                                        $array["resets"][$i]["bonus_stats_type"] = intval($reset["bonus_stats_type"]);
                                        if (intval($reset["bonus_stats_type"]) == "1") {
                                            foreach ($custom["character_class"] as $classCode => $thisClass) {
                                                $array["resets"][$i]["bonus_stats_" . $classCode] = intval($reset["bonus_stats_" . $classCode]);
                                                $array["resets"][$i]["bonus_stats_vip_" . $classCode] = intval($reset["bonus_stats_vip_" . $classCode]);
                                            }
                                        } else {
                                            $array["resets"][$i]["bonus_stats"] = intval($reset["bonus_stats"]);
                                            $array["resets"][$i]["bonus_stats_vip"] = intval($reset["bonus_stats_vip"]);
                                        }
                                        $array["resets"][$i]["bonus_stats_formula"] = intval($reset["bonus_stats_formula"]);
                                        $array["resets"][$i]["is_cred_reward"] = intval($reset["is_cred_reward"]);
                                        $array["resets"][$i]["cred_reward"] = intval($reset["cred_reward"]);
                                        $array["resets"][$i]["cred_reward_vip"] = intval($reset["cred_reward_vip"]);
                                        $array["resets"][$i]["credit_config"] = intval($reset["credit_config"]);
                                        $array["resets"][$i]["clear_ml"] = intval($reset["clear_ml"]);
                                        $array["resets"][$i]["clear_ml_tree"] = intval($reset["clear_ml_tree"]);
                                        $array["resets"][$i]["clear_4th_tree"] = intval($reset["clear_4th_tree"]);
                                        $array["resets"][$i]["lvl_after_reset"] = intval($reset["lvl_after_reset"]);
                                        $array["resets"][$i]["lvl_after_reset_vip"] = intval($reset["lvl_after_reset_vip"]);
                                        $array["resets"][$i]["exp_after_reset"] = intval($reset["exp_after_reset"]);
                                        $array["resets"][$i]["exp_after_reset_vip"] = intval($reset["exp_after_reset_vip"]);
                                        $array["resets"][$i]["map_after_reset"] = intval($reset["map_after_reset"]);
                                        $array["resets"][$i]["map_coord_x_after_reset"] = intval($reset["map_coord_x_after_reset"]);
                                        $array["resets"][$i]["map_coord_y_after_reset"] = intval($reset["map_coord_y_after_reset"]);
                                        $array["resets"][$i]["time"] = intval($reset["time"]);
                                        $array["resets"][$i]["time_vip"] = intval($reset["time_vip"]);
                                        $i++;
                                        $req_items = [];
                                        $j = 0;
                                        $x = 0;
                                        while ($x < 50) {
                                            $index = "item" . $x;
                                            $index2 = "itemcount" . $x;
                                            if (!($_POST[$index] == NULL || $_POST[$index] == __ITEM_EMPTY__)) {
                                                $req_items[$j]["hexcode"] = strval($_POST[$index]);
                                                $req_items[$j]["count"] = intval($_POST[$index2]);
                                                $req_items[$j]["level"] = intval($_POST["level" . $x]);
                                                $req_items[$j]["option"] = intval($_POST["option" . $x]);
                                                $req_items[$j]["durability"] = intval($_POST["durability" . $x]);
                                                $req_items[$j]["luck"] = intval($_POST["luck" . $x]);
                                                $req_items[$j]["skill"] = intval($_POST["skill" . $x]);
                                                $req_items[$j]["excellent"] = intval($_POST["excellent" . $x]);
                                                $req_items[$j]["ancient"] = intval($_POST["ancient" . $x]);
                                                $req_items[$j]["harmony"] = intval($_POST["harmony" . $x]);
                                                $req_items[$j]["guardian"] = intval($_POST["guardian" . $x]);
                                                $req_items[$j]["socket"] = intval($_POST["socket" . $x]);
                                                $j++;
                                            }
                                            $x++;
                                        }
                                        $array["resets"][$i]["id"] = intval($_POST["id"]);
                                        $array["resets"][$i]["req_reset_min"] = intval($_POST["req_reset_min"]);
                                        $array["resets"][$i]["req_reset_max"] = intval($_POST["req_reset_max"]);
                                        $array["resets"][$i]["price_req"] = intval($_POST["price_req"]);
                                        $array["resets"][$i]["price_type"] = intval($_POST["price_type"]);
                                        $array["resets"][$i]["price"] = intval($_POST["price"]);
                                        $array["resets"][$i]["price_vip"] = intval($_POST["price_vip"]);
                                        $array["resets"][$i]["price_formula"] = intval($_POST["price_formula"]);
                                        $array["resets"][$i]["req_lvl"] = intval($_POST["req_lvl"]);
                                        $array["resets"][$i]["req_lvl_vip"] = intval($_POST["req_lvl_vip"]);
                                        $array["resets"][$i]["req_mlvl"] = intval($_POST["req_mlvl"]);
                                        $array["resets"][$i]["req_mlvl_vip"] = intval($_POST["req_mlvl_vip"]);
                                        $array["resets"][$i]["apply_equip_check"] = intval($_POST["apply_equip_check"]);
                                        $array["resets"][$i]["items_req"] = intval($_POST["items_req"]);
                                        $array["resets"][$i]["req_items"] = $req_items;
                                        $array["resets"][$i]["reset_stats"] = intval($_POST["reset_stats"]);
                                        $array["resets"][$i]["bonus_stats_type"] = intval($_POST["bonus_stats_type"]);
                                        if (intval($_POST["bonus_stats_type"]) == "1") {
                                            foreach ($custom["character_class"] as $classCode => $thisClass) {
                                                $array["resets"][$i]["bonus_stats_" . $classCode] = intval($_POST["bonus_stats_" . $classCode]);
                                                $array["resets"][$i]["bonus_stats_vip_" . $classCode] = intval($_POST["bonus_stats_vip_" . $classCode]);
                                                if (empty($array["resets"][$i]["bonus_stats_" . $classCode])) {
                                                    $array["resets"][$i]["bonus_stats_" . $classCode] = 0;
                                                }
                                                if (empty($array["resets"][$i]["bonus_stats_vip_" . $classCode])) {
                                                    $array["resets"][$i]["bonus_stats_vip_" . $classCode] = 0;
                                                }
                                            }
                                        } else {
                                            $array["resets"][$i]["bonus_stats"] = intval($_POST["bonus_stats"]);
                                            $array["resets"][$i]["bonus_stats_vip"] = intval($_POST["bonus_stats_vip"]);
                                        }
                                        $array["resets"][$i]["bonus_stats_formula"] = intval($_POST["bonus_stats_formula"]);
                                        $array["resets"][$i]["is_cred_reward"] = intval($_POST["is_cred_reward"]);
                                        $array["resets"][$i]["cred_reward"] = intval($_POST["cred_reward"]);
                                        $array["resets"][$i]["cred_reward_vip"] = intval($_POST["cred_reward_vip"]);
                                        $array["resets"][$i]["credit_config"] = intval($_POST["credit_config"]);
                                        $array["resets"][$i]["clear_ml"] = intval($_POST["clear_ml"]);
                                        $array["resets"][$i]["clear_ml_tree"] = intval($_POST["clear_ml_tree"]);
                                        $array["resets"][$i]["clear_4th_tree"] = intval($_POST["clear_4th_tree"]);
                                        $array["resets"][$i]["lvl_after_reset"] = intval($_POST["lvl_after_reset"]);
                                        $array["resets"][$i]["lvl_after_reset_vip"] = intval($_POST["lvl_after_reset_vip"]);
                                        $array["resets"][$i]["exp_after_reset"] = intval($_POST["exp_after_reset"]);
                                        $array["resets"][$i]["exp_after_reset_vip"] = intval($_POST["exp_after_reset_vip"]);
                                        $array["resets"][$i]["map_after_reset"] = intval($_POST["map_after_reset"]);
                                        $array["resets"][$i]["map_coord_x_after_reset"] = intval($_POST["map_coord_x_after_reset"]);
                                        $array["resets"][$i]["map_coord_y_after_reset"] = intval($_POST["map_coord_y_after_reset"]);
                                        $array["resets"][$i]["time"] = intval($_POST["time"]);
                                        $array["resets"][$i]["time_vip"] = intval($_POST["time_vip"]);
                                    } else {
                                        $reset_req_items = [];
                                        $xy = 0;
                                        foreach ($reset->req_items->children() as $thisItem) {
                                            $reset_req_items[$xy]["hexcode"] = strval($thisItem["hexcode"]);
                                            $reset_req_items[$xy]["count"] = intval($thisItem["count"]);
                                            $reset_req_items[$xy]["level"] = intval($thisItem["level"]);
                                            $reset_req_items[$xy]["option"] = intval($thisItem["option"]);
                                            $reset_req_items[$xy]["durability"] = intval($thisItem["durability"]);
                                            $reset_req_items[$xy]["luck"] = intval($thisItem["luck"]);
                                            $reset_req_items[$xy]["skill"] = intval($thisItem["skill"]);
                                            $reset_req_items[$xy]["excellent"] = intval($thisItem["excellent"]);
                                            $reset_req_items[$xy]["ancient"] = intval($thisItem["ancient"]);
                                            $reset_req_items[$xy]["harmony"] = intval($thisItem["harmony"]);
                                            $reset_req_items[$xy]["guardian"] = intval($thisItem["guardian"]);
                                            $reset_req_items[$xy]["socket"] = intval($thisItem["socket"]);
                                            $xy++;
                                        }
                                        $array["resets"][$i]["id"] = intval($reset["id"]);
                                        $array["resets"][$i]["req_reset_min"] = intval($reset["req_reset_min"]);
                                        $array["resets"][$i]["req_reset_max"] = intval($reset["req_reset_max"]);
                                        $array["resets"][$i]["price_req"] = intval($reset["price_req"]);
                                        $array["resets"][$i]["price_type"] = intval($reset["price_type"]);
                                        $array["resets"][$i]["price"] = intval($reset["price"]);
                                        $array["resets"][$i]["price_vip"] = intval($reset["price_vip"]);
                                        $array["resets"][$i]["price_formula"] = intval($reset["price_formula"]);
                                        $array["resets"][$i]["req_lvl"] = intval($reset["req_lvl"]);
                                        $array["resets"][$i]["req_lvl_vip"] = intval($reset["req_lvl_vip"]);
                                        $array["resets"][$i]["req_mlvl"] = intval($reset["req_mlvl"]);
                                        $array["resets"][$i]["req_mlvl_vip"] = intval($reset["req_mlvl_vip"]);
                                        $array["resets"][$i]["apply_equip_check"] = intval($reset["apply_equip_check"]);
                                        $array["resets"][$i]["items_req"] = intval($reset["items_req"]);
                                        $array["resets"][$i]["req_items"] = $reset_req_items;
                                        $array["resets"][$i]["reset_stats"] = intval($reset["reset_stats"]);
                                        $array["resets"][$i]["bonus_stats_type"] = intval($reset["bonus_stats_type"]);
                                        if (intval($reset["bonus_stats_type"]) == "1") {
                                            foreach ($custom["character_class"] as $classCode => $thisClass) {
                                                $array["resets"][$i]["bonus_stats_" . $classCode] = intval($reset["bonus_stats_" . $classCode]);
                                                $array["resets"][$i]["bonus_stats_vip_" . $classCode] = intval($reset["bonus_stats_vip_" . $classCode]);
                                            }
                                        } else {
                                            $array["resets"][$i]["bonus_stats"] = intval($reset["bonus_stats"]);
                                            $array["resets"][$i]["bonus_stats_vip"] = intval($reset["bonus_stats_vip"]);
                                        }
                                        $array["resets"][$i]["bonus_stats_formula"] = intval($reset["bonus_stats_formula"]);
                                        $array["resets"][$i]["is_cred_reward"] = intval($reset["is_cred_reward"]);
                                        $array["resets"][$i]["cred_reward"] = intval($reset["cred_reward"]);
                                        $array["resets"][$i]["cred_reward_vip"] = intval($reset["cred_reward_vip"]);
                                        $array["resets"][$i]["credit_config"] = intval($reset["credit_config"]);
                                        $array["resets"][$i]["clear_ml"] = intval($reset["clear_ml"]);
                                        $array["resets"][$i]["clear_ml_tree"] = intval($reset["clear_ml_tree"]);
                                        $array["resets"][$i]["clear_4th_tree"] = intval($reset["clear_4th_tree"]);
                                        $array["resets"][$i]["lvl_after_reset"] = intval($reset["lvl_after_reset"]);
                                        $array["resets"][$i]["lvl_after_reset_vip"] = intval($reset["lvl_after_reset_vip"]);
                                        $array["resets"][$i]["exp_after_reset"] = intval($reset["exp_after_reset"]);
                                        $array["resets"][$i]["exp_after_reset_vip"] = intval($reset["exp_after_reset_vip"]);
                                        $array["resets"][$i]["map_after_reset"] = intval($reset["map_after_reset"]);
                                        $array["resets"][$i]["map_coord_x_after_reset"] = intval($reset["map_coord_x_after_reset"]);
                                        $array["resets"][$i]["map_coord_y_after_reset"] = intval($reset["map_coord_y_after_reset"]);
                                        $array["resets"][$i]["time"] = intval($reset["time"]);
                                        $array["resets"][$i]["time_vip"] = intval($reset["time_vip"]);
                                    }
                                    $i++;
                                }
                            }
                            if (sizeof($xml->resets->children()) <= $newPos || $newPos == -1) {
                                $req_items = [];
                                $j = 0;
                                $x = 0;
                                while ($x < 50) {
                                    $index = "item" . $x;
                                    $index2 = "itemcount" . $x;
                                    if (!($_POST[$index] == NULL || $_POST[$index] == __ITEM_EMPTY__)) {
                                        $req_items[$j]["hexcode"] = strval($_POST[$index]);
                                        $req_items[$j]["count"] = intval($_POST[$index2]);
                                        $req_items[$j]["level"] = intval($_POST["level" . $x]);
                                        $req_items[$j]["option"] = intval($_POST["option" . $x]);
                                        $req_items[$j]["durability"] = intval($_POST["durability" . $x]);
                                        $req_items[$j]["luck"] = intval($_POST["luck" . $x]);
                                        $req_items[$j]["skill"] = intval($_POST["skill" . $x]);
                                        $req_items[$j]["excellent"] = intval($_POST["excellent" . $x]);
                                        $req_items[$j]["ancient"] = intval($_POST["ancient" . $x]);
                                        $req_items[$j]["harmony"] = intval($_POST["harmony" . $x]);
                                        $req_items[$j]["guardian"] = intval($_POST["guardian" . $x]);
                                        $req_items[$j]["socket"] = intval($_POST["socket" . $x]);
                                        $j++;
                                    }
                                    $x++;
                                }
                                $array["resets"][$i]["id"] = intval($_POST["id"]);
                                $array["resets"][$i]["req_reset_min"] = intval($_POST["req_reset_min"]);
                                $array["resets"][$i]["req_reset_max"] = intval($_POST["req_reset_max"]);
                                $array["resets"][$i]["price_req"] = intval($_POST["price_req"]);
                                $array["resets"][$i]["price_type"] = intval($_POST["price_type"]);
                                $array["resets"][$i]["price"] = intval($_POST["price"]);
                                $array["resets"][$i]["price_vip"] = intval($_POST["price_vip"]);
                                $array["resets"][$i]["price_formula"] = intval($_POST["price_formula"]);
                                $array["resets"][$i]["req_lvl"] = intval($_POST["req_lvl"]);
                                $array["resets"][$i]["req_lvl_vip"] = intval($_POST["req_lvl_vip"]);
                                $array["resets"][$i]["req_mlvl"] = intval($_POST["req_mlvl"]);
                                $array["resets"][$i]["req_mlvl_vip"] = intval($_POST["req_mlvl_vip"]);
                                $array["resets"][$i]["apply_equip_check"] = intval($_POST["apply_equip_check"]);
                                $array["resets"][$i]["items_req"] = intval($_POST["items_req"]);
                                $array["resets"][$i]["req_items"] = $req_items;
                                $array["resets"][$i]["reset_stats"] = intval($_POST["reset_stats"]);
                                $array["resets"][$i]["bonus_stats_type"] = intval($_POST["bonus_stats_type"]);
                                if (intval($_POST["bonus_stats_type"]) == "1") {
                                    foreach ($custom["character_class"] as $classCode => $thisClass) {
                                        $array["resets"][$i]["bonus_stats_" . $classCode] = intval($_POST["bonus_stats_" . $classCode]);
                                        $array["resets"][$i]["bonus_stats_vip_" . $classCode] = intval($_POST["bonus_stats_vip_" . $classCode]);
                                        if (empty($array["resets"][$i]["bonus_stats_" . $classCode])) {
                                            $array["resets"][$i]["bonus_stats_" . $classCode] = 0;
                                        }
                                        if (empty($array["resets"][$i]["bonus_stats_vip_" . $classCode])) {
                                            $array["resets"][$i]["bonus_stats_vip_" . $classCode] = 0;
                                        }
                                    }
                                } else {
                                    $array["resets"][$i]["bonus_stats"] = intval($_POST["bonus_stats"]);
                                    $array["resets"][$i]["bonus_stats_vip"] = intval($_POST["bonus_stats_vip"]);
                                }
                                $array["resets"][$i]["bonus_stats_formula"] = intval($_POST["bonus_stats_formula"]);
                                $array["resets"][$i]["is_cred_reward"] = intval($_POST["is_cred_reward"]);
                                $array["resets"][$i]["cred_reward"] = intval($_POST["cred_reward"]);
                                $array["resets"][$i]["cred_reward_vip"] = intval($_POST["cred_reward_vip"]);
                                $array["resets"][$i]["credit_config"] = intval($_POST["credit_config"]);
                                $array["resets"][$i]["clear_ml"] = intval($_POST["clear_ml"]);
                                $array["resets"][$i]["clear_ml_tree"] = intval($_POST["clear_ml_tree"]);
                                $array["resets"][$i]["clear_4th_tree"] = intval($_POST["clear_4th_tree"]);
                                $array["resets"][$i]["lvl_after_reset"] = intval($_POST["lvl_after_reset"]);
                                $array["resets"][$i]["lvl_after_reset_vip"] = intval($_POST["lvl_after_reset_vip"]);
                                $array["resets"][$i]["exp_after_reset"] = intval($_POST["exp_after_reset"]);
                                $array["resets"][$i]["exp_after_reset_vip"] = intval($_POST["exp_after_reset_vip"]);
                                $array["resets"][$i]["map_after_reset"] = intval($_POST["map_after_reset"]);
                                $array["resets"][$i]["map_coord_x_after_reset"] = intval($_POST["map_coord_x_after_reset"]);
                                $array["resets"][$i]["map_coord_y_after_reset"] = intval($_POST["map_coord_y_after_reset"]);
                                $array["resets"][$i]["time"] = intval($_POST["time"]);
                                $array["resets"][$i]["time_vip"] = intval($_POST["time_vip"]);
                            }
                            $tmp = arraytoxml($array);
                            file_put_contents(__PATH_MODULE_CONFIGS__ . "usercp.reset.xml", $tmp);
                            message("success", "Reset stage was successfully created.");
                        }
                    } else {
                        if ($newPos == -1 && intval($_POST["id"]) < intval($reset["id"])) {
                            $newPos = $j;
                        }
                        $j++;
                    }
                }
            }
        }
    } else {
        message("error", "Missing data (complete all fields).");
    }
}
if (check_value($_POST["save_stage"])) {
    if (check_value($_POST["id"]) && check_value($_POST["req_reset_min"]) && check_value($_POST["req_reset_max"]) && check_value($_POST["price_req"]) && check_value($_POST["price_type"]) && check_value($_POST["price"]) && check_value($_POST["price_vip"]) && check_value($_POST["price_formula"]) && check_value($_POST["req_lvl"]) && check_value($_POST["req_lvl_vip"]) && check_value($_POST["req_mlvl"]) && check_value($_POST["req_mlvl_vip"]) && check_value($_POST["apply_equip_check"]) && check_value($_POST["items_req"]) && check_value($_POST["reset_stats"]) && (check_value($_POST["bonus_stats_type"] == "1") && check_value($_POST["bonus_stats"]) && check_value($_POST["bonus_stats_vip"]) || check_value($_POST["bonus_stats_type"] == "0")) && check_value($_POST["bonus_stats_formula"]) && check_value($_POST["is_cred_reward"]) && check_value($_POST["cred_reward"]) && check_value($_POST["cred_reward_vip"]) && check_value($_POST["credit_config"]) && check_value($_POST["clear_ml"]) && check_value($_POST["clear_ml_tree"]) && check_value($_POST["lvl_after_reset"]) && check_value($_POST["lvl_after_reset_vip"]) && check_value($_POST["exp_after_reset"]) && check_value($_POST["exp_after_reset_vip"]) && check_value($_POST["time"]) && check_value($_POST["time_vip"]) && check_value($_POST["map_after_reset"]) && check_value($_POST["map_coord_x_after_reset"]) && check_value($_POST["map_coord_y_after_reset"])) {
        $xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "usercp.reset.xml");
        if ($xml !== false) {
            $array = [];
            $array["active"] = trim($xml->active);
            $array["keep_gr_bonus"] = trim($xml->keep_gr_bonus);
            $array["check_equip_0"] = trim($xml->check_equip_0);
            $array["check_equip_1"] = trim($xml->check_equip_1);
            $array["check_equip_2"] = trim($xml->check_equip_2);
            $array["check_equip_3"] = trim($xml->check_equip_3);
            $array["check_equip_4"] = trim($xml->check_equip_4);
            $array["check_equip_5"] = trim($xml->check_equip_5);
            $array["check_equip_6"] = trim($xml->check_equip_6);
            $array["check_equip_7"] = trim($xml->check_equip_7);
            $array["check_equip_8"] = trim($xml->check_equip_8);
            $array["check_equip_9"] = trim($xml->check_equip_9);
            $array["check_equip_10"] = trim($xml->check_equip_10);
            $array["check_equip_11"] = trim($xml->check_equip_11);
            $array["check_equip_236"] = trim($xml->check_equip_236);
            $array["check_equip_237"] = trim($xml->check_equip_237);
            $array["check_equip_238"] = trim($xml->check_equip_238);
            $array["stage_price_separate"] = trim($xml->stage_price_separate);
            $i = 1;
            foreach ($xml->resets->children() as $tag => $reset) {
                if ($tag == "reset") {
                    if (intval($reset["id"]) == intval($_POST["id"])) {
                        $req_items = [];
                        $j = 0;
                        $x = 0;
                        while ($x < 50) {
                            $index = "item" . $x;
                            $index2 = "itemcount" . $x;
                            if (!($_POST[$index] == NULL || $_POST[$index] == __ITEM_EMPTY__)) {
                                $req_items[$j]["hexcode"] = strval($_POST[$index]);
                                $req_items[$j]["count"] = intval($_POST[$index2]);
                                $req_items[$j]["level"] = intval($_POST["level" . $x]);
                                $req_items[$j]["option"] = intval($_POST["option" . $x]);
                                $req_items[$j]["durability"] = intval($_POST["durability" . $x]);
                                $req_items[$j]["luck"] = intval($_POST["luck" . $x]);
                                $req_items[$j]["skill"] = intval($_POST["skill" . $x]);
                                $req_items[$j]["excellent"] = intval($_POST["excellent" . $x]);
                                $req_items[$j]["ancient"] = intval($_POST["ancient" . $x]);
                                $req_items[$j]["harmony"] = intval($_POST["harmony" . $x]);
                                $req_items[$j]["guardian"] = intval($_POST["guardian" . $x]);
                                $req_items[$j]["socket"] = intval($_POST["socket" . $x]);
                                $j++;
                            }
                            $x++;
                        }
                        $array["resets"][$i]["id"] = intval($_POST["id"]);
                        $array["resets"][$i]["req_reset_min"] = intval($_POST["req_reset_min"]);
                        $array["resets"][$i]["req_reset_max"] = intval($_POST["req_reset_max"]);
                        $array["resets"][$i]["price_req"] = intval($_POST["price_req"]);
                        $array["resets"][$i]["price_type"] = intval($_POST["price_type"]);
                        $array["resets"][$i]["price"] = intval($_POST["price"]);
                        $array["resets"][$i]["price_vip"] = intval($_POST["price_vip"]);
                        $array["resets"][$i]["price_formula"] = intval($_POST["price_formula"]);
                        $array["resets"][$i]["req_lvl"] = intval($_POST["req_lvl"]);
                        $array["resets"][$i]["req_lvl_vip"] = intval($_POST["req_lvl_vip"]);
                        $array["resets"][$i]["req_mlvl"] = intval($_POST["req_mlvl"]);
                        $array["resets"][$i]["req_mlvl_vip"] = intval($_POST["req_mlvl_vip"]);
                        $array["resets"][$i]["apply_equip_check"] = intval($_POST["apply_equip_check"]);
                        $array["resets"][$i]["items_req"] = intval($_POST["items_req"]);
                        $array["resets"][$i]["req_items"] = $req_items;
                        $array["resets"][$i]["reset_stats"] = intval($_POST["reset_stats"]);
                        $array["resets"][$i]["bonus_stats_type"] = intval($_POST["bonus_stats_type"]);
                        if (intval($_POST["bonus_stats_type"]) == "1") {
                            foreach ($custom["character_class"] as $classCode => $thisClass) {
                                $array["resets"][$i]["bonus_stats_" . $classCode] = intval($_POST["bonus_stats_" . $classCode]);
                                $array["resets"][$i]["bonus_stats_vip_" . $classCode] = intval($_POST["bonus_stats_vip_" . $classCode]);
                                if (empty($array["resets"][$i]["bonus_stats_" . $classCode])) {
                                    $array["resets"][$i]["bonus_stats_" . $classCode] = 0;
                                }
                                if (empty($array["resets"][$i]["bonus_stats_vip_" . $classCode])) {
                                    $array["resets"][$i]["bonus_stats_vip_" . $classCode] = 0;
                                }
                            }
                        } else {
                            $array["resets"][$i]["bonus_stats"] = intval($_POST["bonus_stats"]);
                            $array["resets"][$i]["bonus_stats_vip"] = intval($_POST["bonus_stats_vip"]);
                        }
                        $array["resets"][$i]["bonus_stats_formula"] = intval($_POST["bonus_stats_formula"]);
                        $array["resets"][$i]["is_cred_reward"] = intval($_POST["is_cred_reward"]);
                        $array["resets"][$i]["cred_reward"] = intval($_POST["cred_reward"]);
                        $array["resets"][$i]["cred_reward_vip"] = intval($_POST["cred_reward_vip"]);
                        $array["resets"][$i]["credit_config"] = intval($_POST["credit_config"]);
                        $array["resets"][$i]["clear_ml"] = intval($_POST["clear_ml"]);
                        $array["resets"][$i]["clear_ml_tree"] = intval($_POST["clear_ml_tree"]);
                        $array["resets"][$i]["clear_4th_tree"] = intval($_POST["clear_4th_tree"]);
                        $array["resets"][$i]["lvl_after_reset"] = intval($_POST["lvl_after_reset"]);
                        $array["resets"][$i]["lvl_after_reset_vip"] = intval($_POST["lvl_after_reset_vip"]);
                        $array["resets"][$i]["exp_after_reset"] = intval($_POST["exp_after_reset"]);
                        $array["resets"][$i]["exp_after_reset_vip"] = intval($_POST["exp_after_reset_vip"]);
                        $array["resets"][$i]["map_after_reset"] = intval($_POST["map_after_reset"]);
                        $array["resets"][$i]["map_coord_x_after_reset"] = intval($_POST["map_coord_x_after_reset"]);
                        $array["resets"][$i]["map_coord_y_after_reset"] = intval($_POST["map_coord_y_after_reset"]);
                        $array["resets"][$i]["time"] = intval($_POST["time"]);
                        $array["resets"][$i]["time_vip"] = intval($_POST["time_vip"]);
                    } else {
                        $reset_req_items = [];
                        $xy = 0;
                        foreach ($reset->req_items->children() as $thisItem) {
                            $reset_req_items[$xy]["hexcode"] = strval($thisItem["hexcode"]);
                            $reset_req_items[$xy]["count"] = intval($thisItem["count"]);
                            $reset_req_items[$xy]["level"] = intval($thisItem["level"]);
                            $reset_req_items[$xy]["option"] = intval($thisItem["option"]);
                            $reset_req_items[$xy]["durability"] = intval($thisItem["durability"]);
                            $reset_req_items[$xy]["luck"] = intval($thisItem["luck"]);
                            $reset_req_items[$xy]["skill"] = intval($thisItem["skill"]);
                            $reset_req_items[$xy]["excellent"] = intval($thisItem["excellent"]);
                            $reset_req_items[$xy]["ancient"] = intval($thisItem["ancient"]);
                            $reset_req_items[$xy]["harmony"] = intval($thisItem["harmony"]);
                            $reset_req_items[$xy]["guardian"] = intval($thisItem["guardian"]);
                            $reset_req_items[$xy]["socket"] = intval($thisItem["socket"]);
                            $xy++;
                        }
                        $array["resets"][$i]["id"] = intval($reset["id"]);
                        $array["resets"][$i]["req_reset_min"] = intval($reset["req_reset_min"]);
                        $array["resets"][$i]["req_reset_max"] = intval($reset["req_reset_max"]);
                        $array["resets"][$i]["price_req"] = intval($reset["price_req"]);
                        $array["resets"][$i]["price_type"] = intval($reset["price_type"]);
                        $array["resets"][$i]["price"] = intval($reset["price"]);
                        $array["resets"][$i]["price_vip"] = intval($reset["price_vip"]);
                        $array["resets"][$i]["price_formula"] = intval($reset["price_formula"]);
                        $array["resets"][$i]["req_lvl"] = intval($reset["req_lvl"]);
                        $array["resets"][$i]["req_lvl_vip"] = intval($reset["req_lvl_vip"]);
                        $array["resets"][$i]["req_mlvl"] = intval($reset["req_mlvl"]);
                        $array["resets"][$i]["req_mlvl_vip"] = intval($reset["req_mlvl_vip"]);
                        $array["resets"][$i]["apply_equip_check"] = intval($reset["apply_equip_check"]);
                        $array["resets"][$i]["items_req"] = intval($reset["items_req"]);
                        $array["resets"][$i]["req_items"] = $reset_req_items;
                        $array["resets"][$i]["reset_stats"] = intval($reset["reset_stats"]);
                        $array["resets"][$i]["bonus_stats_type"] = intval($reset["bonus_stats_type"]);
                        if (intval($reset["bonus_stats_type"]) == "1") {
                            foreach ($custom["character_class"] as $classCode => $thisClass) {
                                $array["resets"][$i]["bonus_stats_" . $classCode] = intval($reset["bonus_stats_" . $classCode]);
                                $array["resets"][$i]["bonus_stats_vip_" . $classCode] = intval($reset["bonus_stats_vip_" . $classCode]);
                            }
                        } else {
                            $array["resets"][$i]["bonus_stats"] = intval($reset["bonus_stats"]);
                            $array["resets"][$i]["bonus_stats_vip"] = intval($reset["bonus_stats_vip"]);
                        }
                        $array["resets"][$i]["bonus_stats_formula"] = intval($reset["bonus_stats_formula"]);
                        $array["resets"][$i]["is_cred_reward"] = intval($reset["is_cred_reward"]);
                        $array["resets"][$i]["cred_reward"] = intval($reset["cred_reward"]);
                        $array["resets"][$i]["cred_reward_vip"] = intval($reset["cred_reward_vip"]);
                        $array["resets"][$i]["credit_config"] = intval($reset["credit_config"]);
                        $array["resets"][$i]["clear_ml"] = intval($reset["clear_ml"]);
                        $array["resets"][$i]["clear_ml_tree"] = intval($reset["clear_ml_tree"]);
                        $array["resets"][$i]["clear_4th_tree"] = intval($reset["clear_4th_tree"]);
                        $array["resets"][$i]["lvl_after_reset"] = intval($reset["lvl_after_reset"]);
                        $array["resets"][$i]["lvl_after_reset_vip"] = intval($reset["lvl_after_reset_vip"]);
                        $array["resets"][$i]["exp_after_reset"] = intval($reset["exp_after_reset"]);
                        $array["resets"][$i]["exp_after_reset_vip"] = intval($reset["exp_after_reset_vip"]);
                        $array["resets"][$i]["map_after_reset"] = intval($reset["map_after_reset"]);
                        $array["resets"][$i]["map_coord_x_after_reset"] = intval($reset["map_coord_x_after_reset"]);
                        $array["resets"][$i]["map_coord_y_after_reset"] = intval($reset["map_coord_y_after_reset"]);
                        $array["resets"][$i]["time"] = intval($reset["time"]);
                        $array["resets"][$i]["time_vip"] = intval($reset["time_vip"]);
                    }
                    $i++;
                }
            }
            $tmp = arraytoxml($array);
            file_put_contents(__PATH_MODULE_CONFIGS__ . "usercp.reset.xml", $tmp);
            message("success", "Reset Stage #" . intval($_POST["id"]) . " was successfully edited.");
        }
    } else {
        message("error", "Missing data (complete all fields).");
    }
}
$creditSystem = new CreditSystem($common, new Character(), $dB, $dB2);
if (check_value($_GET["edit"])) {
    if (is_numeric($_GET["edit"])) {
        $xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "usercp.reset.xml");
        if ($xml !== false) {
            $stageData = [];
            $i = 1;
            foreach ($xml->resets->children() as $tag => $reset) {
                if ($tag == "reset" && intval($reset["id"]) == $_GET["edit"]) {
                    $stageData["id"] = intval($reset["id"]);
                    $stageData["req_reset_min"] = intval($reset["req_reset_min"]);
                    $stageData["req_reset_max"] = intval($reset["req_reset_max"]);
                    $stageData["price_req"] = intval($reset["price_req"]);
                    $stageData["price_type"] = intval($reset["price_type"]);
                    $stageData["price"] = intval($reset["price"]);
                    $stageData["price_vip"] = intval($reset["price_vip"]);
                    $stageData["price_formula"] = intval($reset["price_formula"]);
                    $stageData["req_lvl"] = intval($reset["req_lvl"]);
                    $stageData["req_lvl_vip"] = intval($reset["req_lvl_vip"]);
                    $stageData["req_mlvl"] = intval($reset["req_mlvl"]);
                    $stageData["req_mlvl_vip"] = intval($reset["req_mlvl_vip"]);
                    $stageData["apply_equip_check"] = intval($reset["apply_equip_check"]);
                    $stageData["items_req"] = intval($reset["items_req"]);
                    $stageData["reset_stats"] = intval($reset["reset_stats"]);
                    $stageData["bonus_stats_type"] = intval($reset["bonus_stats_type"]);
                    if (intval($reset["bonus_stats_type"]) == "1") {
                        foreach ($custom["character_class"] as $classCode => $thisClass) {
                            $stageData["bonus_stats_" . $classCode] = intval($reset["bonus_stats_" . $classCode]);
                            $stageData["bonus_stats_vip_" . $classCode] = intval($reset["bonus_stats_vip_" . $classCode]);
                        }
                    } else {
                        $stageData["bonus_stats"] = intval($reset["bonus_stats"]);
                        $stageData["bonus_stats_vip"] = intval($reset["bonus_stats_vip"]);
                    }
                    $stageData["bonus_stats_formula"] = intval($reset["bonus_stats_formula"]);
                    $stageData["is_cred_reward"] = intval($reset["is_cred_reward"]);
                    $stageData["cred_reward"] = intval($reset["cred_reward"]);
                    $stageData["cred_reward_vip"] = intval($reset["cred_reward_vip"]);
                    $stageData["credit_config"] = intval($reset["credit_config"]);
                    $stageData["clear_ml"] = intval($reset["clear_ml"]);
                    $stageData["clear_ml_tree"] = intval($reset["clear_ml_tree"]);
                    $stageData["clear_4th_tree"] = intval($reset["clear_4th_tree"]);
                    $stageData["lvl_after_reset"] = intval($reset["lvl_after_reset"]);
                    $stageData["lvl_after_reset_vip"] = intval($reset["lvl_after_reset_vip"]);
                    $stageData["exp_after_reset"] = intval($reset["exp_after_reset"]);
                    $stageData["exp_after_reset_vip"] = intval($reset["exp_after_reset_vip"]);
                    $stageData["map_after_reset"] = intval($reset["map_after_reset"]);
                    $stageData["map_coord_x_after_reset"] = intval($reset["map_coord_x_after_reset"]);
                    $stageData["map_coord_y_after_reset"] = intval($reset["map_coord_y_after_reset"]);
                    $stageData["time"] = intval($reset["time"]);
                    $stageData["time_vip"] = intval($reset["time_vip"]);
                    $req_items_show = "";
                    if ($reset->req_items->children() != NULL) {
                        $tmpcounter = 0;
                        foreach ($reset->req_items->children() as $innerTag => $item) {
                            if ($innerTag == "item") {
                                $stageData["req_items"][$tmpcounter]["hexcode"] = strval($item["hexcode"]);
                                $stageData["req_items"][$tmpcounter]["count"] = intval($item["count"]);
                                $stageData["req_items"][$tmpcounter]["level"] = intval($item["level"]);
                                $stageData["req_items"][$tmpcounter]["option"] = intval($item["option"]);
                                $stageData["req_items"][$tmpcounter]["durability"] = intval($item["durability"]);
                                $stageData["req_items"][$tmpcounter]["luck"] = intval($item["luck"]);
                                $stageData["req_items"][$tmpcounter]["skill"] = intval($item["skill"]);
                                $stageData["req_items"][$tmpcounter]["excellent"] = intval($item["excellent"]);
                                $stageData["req_items"][$tmpcounter]["ancient"] = intval($item["ancient"]);
                                $stageData["req_items"][$tmpcounter]["harmony"] = intval($item["harmony"]);
                                $stageData["req_items"][$tmpcounter]["guardian"] = intval($item["guardian"]);
                                $stageData["req_items"][$tmpcounter]["socket"] = intval($item["socket"]);
                                $itemInfo = $Items->ItemInfo(strval($item["hexcode"]));
                                $luck = "";
                                $skill = "";
                                $option = "";
                                $exl = "";
                                $ancsetopt = "";
                                if ($itemInfo["level"]) {
                                    $itemInfo["level"] = " +" . $itemInfo["level"];
                                } else {
                                    $itemInfo["level"] = NULL;
                                }
                                if ($itemInfo["luck"]) {
                                    $luck = "<br><font color=#9aadd5>" . $itemInfo["luck"] . "</font>";
                                }
                                if ($itemInfo["skill"]) {
                                    $skill = "<br><font color=#9aadd5>" . $itemInfo["skill"] . "</font>";
                                }
                                if ($itemInfo["opt"]) {
                                    $option = "<font color=#9aadd5>" . $itemInfo["opt"] . "</font>";
                                }
                                if ($itemInfo["exl"]) {
                                    $exl = "<font color=#4d668d>" . str_replace("^^", "<br>", $itemInfo["exl"]) . "</font>";
                                }
                                if ($itemInfo["ancsetopt"]) {
                                    $ancsetopt = "<font color=#9aadd5>" . str_replace("^^", "<br>", $itemInfo["ancsetopt"]) . "</font>";
                                }
                                $req_items_show .= "<span  style=\"cursor: pointer;\" onmouseover=\"Tip('<center><img src=" . $itemInfo["thumb"] . "><br /><font color=yellow><br><font color=white><br>Durability: " . $itemInfo["dur"] . "</font><br><font color=#FF99CC>" . $itemInfo["jog"] . "</font><font color=FFCC00>" . $itemInfo["harm"] . "</font><br>" . $option . " " . $luck . " " . $skill . " " . $exl . " <br>" . $ancsetopt . "<br><font color=#4d668d>" . $itemInfo["socket"] . "</font><br><br><span class=itemTooltipClassReq>" . $itemInfo["classReq"] . "</span></center>', TITLEFONTCOLOR, '" . $itemInfo["color"] . "',TITLE,'" . addslashes($itemInfo["name"]) . $itemInfo["level"] . "',TITLEBGCOLOR,'" . $itemInfo["anco"] . "')\" onmouseout=\"UnTip()\">Item " . ($tmpcounter + 1) . "</span>: <input class=\"form-control\" type=\"text\" name=\"item" . $tmpcounter . "\" value=\"" . strval($item["hexcode"]) . "\" placeholder=\"Item Hex Code\" style=\"display:inline; width:70%;\" maxlength=\"64\" size=\"80\"/>";
                                $req_items_show .= " Count: <input type=\"text\" class=\"form-control\" style=\"display:inline; max-width:50px;\" maxlength=\"64\" size=\"4\" name=\"itemcount" . $tmpcounter . "\" value=\"" . intval($item["count"]) . "\" /> <button type=\"button\" class=\"btn btn-default btn-sm\" data-toggle=\"modal\" data-target=\"#reqitems" . $tmpcounter . "\"><i class=\"fa fa-edit\"></i> Edit</button><br>";
                                $req_items_show .= "\r\n                                        <div id=\"reqitems" . $tmpcounter . "\" class=\"modal fade\" role=\"dialog\">\r\n                                        <div class=\"modal-dialog modal-lg\">\r\n                                        <div class=\"modal-content\">\r\n                                        <div class=\"modal-header\">\r\n                                        <button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>\r\n                                        <h4 class=\"modal-title\">Edit checked Attributes for Item #" . ($tmpcounter + 1) . "</h4>\r\n                                        </div>\r\n                                        <div class=\"modal-body\">\r\n                                        <div style=\"min-height: 900px;\">\r\n                                        <div class=\"form-group\">\r\n                                        <label class=\"col-sm-4 control-label\" for=\"id\">Check Item Level:</label>\r\n                                        <div class=\"col-sm-8\">\r\n                                        <select name=\"level" . $tmpcounter . "\" id=\"level" . $tmpcounter . "\" class=\"form-control\" aria-describedby=\"helpBlock\">";
                                if (intval($item["level"]) == 1) {
                                    $req_items_show .= "<option value=\"1\" selected=\"selected\">Yes</option><option value=\"0\">No</option>";
                                } else {
                                    $req_items_show .= "<option value=\"1\">Yes</option><option value=\"0\" selected=\"selected\">No</option>";
                                }
                                $req_items_show .= "\r\n                                        </select>\r\n                                        <span id=\"levelHelp\" class=\"help-block\">If yes, item level will have to be exactly the same, as required. If no, this attribute will not be checked.</span>\r\n                                        </div>\r\n                                        </div>\r\n                                        <div class=\"form-group\">\r\n                                        <label class=\"col-sm-4 control-label\" for=\"id\">Check Item Option:</label>\r\n                                        <div class=\"col-sm-8\">\r\n                                        <select name=\"option" . $tmpcounter . "\" id=\"option" . $tmpcounter . "\" class=\"form-control\" aria-describedby=\"helpBlock\">";
                                if (intval($item["option"]) == 1) {
                                    $req_items_show .= "<option value=\"1\" selected=\"selected\">Yes</option><option value=\"0\">No</option>";
                                } else {
                                    $req_items_show .= "<option value=\"1\">Yes</option><option value=\"0\" selected=\"selected\">No</option>";
                                }
                                $req_items_show .= "\r\n                                        </select>\r\n                                        <span id=\"optionHelp\" class=\"help-block\">If yes, item option will have to be exactly the same, as required. If no, this attribute will not be checked.</span>\r\n                                        </div>\r\n                                        </div>\r\n                                        <div class=\"form-group\">\r\n                                        <label class=\"col-sm-4 control-label\" for=\"id\">Check Item Durability:</label>\r\n                                        <div class=\"col-sm-8\">\r\n                                        <select name=\"durability" . $tmpcounter . "\" id=\"durability" . $tmpcounter . "\" class=\"form-control\" aria-describedby=\"helpBlock\">";
                                if (intval($item["durability"]) == 1) {
                                    $req_items_show .= "<option value=\"1\" selected=\"selected\">Yes</option><option value=\"0\">No</option>";
                                } else {
                                    $req_items_show .= "<option value=\"1\">Yes</option><option value=\"0\" selected=\"selected\">No</option>";
                                }
                                $req_items_show .= "\r\n                                        </select>\r\n                                        <span id=\"durabilityHelp\" class=\"help-block\">If yes, item durability will have to be exactly the same, as required. If no, this attribute will not be checked.</span>\r\n                                        </div>\r\n                                        </div>\r\n                                        <div class=\"form-group\">\r\n                                        <label class=\"col-sm-4 control-label\" for=\"id\">Check Item Luck:</label>\r\n                                        <div class=\"col-sm-8\">\r\n                                        <select name=\"luck" . $tmpcounter . "\" id=\"luck" . $tmpcounter . "\" class=\"form-control\" aria-describedby=\"helpBlock\">";
                                if (intval($item["luck"]) == 1) {
                                    $req_items_show .= "<option value=\"1\" selected=\"selected\">Yes</option><option value=\"0\">No</option>";
                                } else {
                                    $req_items_show .= "<option value=\"1\">Yes</option><option value=\"0\" selected=\"selected\">No</option>";
                                }
                                $req_items_show .= "\r\n                                        </select>\r\n                                        <span id=\"luckHelp\" class=\"help-block\">If yes, item luck will have to be exactly the same, as required. If no, this attribute will not be checked.</span>\r\n                                        </div>\r\n                                        </div>\r\n                                        <div class=\"form-group\">\r\n                                        <label class=\"col-sm-4 control-label\" for=\"id\">Check Item Skill:</label>\r\n                                        <div class=\"col-sm-8\">\r\n                                        <select name=\"skill" . $tmpcounter . "\" id=\"skill" . $tmpcounter . "\" class=\"form-control\" aria-describedby=\"helpBlock\">";
                                if (intval($item["skill"]) == 1) {
                                    $req_items_show .= "<option value=\"1\" selected=\"selected\">Yes</option><option value=\"0\">No</option>";
                                } else {
                                    $req_items_show .= "<option value=\"1\">Yes</option><option value=\"0\" selected=\"selected\">No</option>";
                                }
                                $req_items_show .= "\r\n                                        </select>\r\n                                        <span id=\"skillHelp\" class=\"help-block\">If yes, item skill will have to be exactly the same, as required. If no, this attribute will not be checked.</span>\r\n                                        </div>\r\n                                        </div>\r\n                                        <div class=\"form-group\">\r\n                                        <label class=\"col-sm-4 control-label\" for=\"id\">Check Item Excellent Options:</label>\r\n                                        <div class=\"col-sm-8\">\r\n                                        <select name=\"excellent" . $tmpcounter . "\" id=\"excellent" . $tmpcounter . "\" class=\"form-control\" aria-describedby=\"helpBlock\">";
                                if (intval($item["excellent"]) == 1) {
                                    $req_items_show .= "<option value=\"1\" selected=\"selected\">Yes</option><option value=\"0\">No</option>";
                                } else {
                                    $req_items_show .= "<option value=\"1\">Yes</option><option value=\"0\" selected=\"selected\">No</option>";
                                }
                                $req_items_show .= "\r\n                                        </select>\r\n                                        <span id=\"excellentHelp\" class=\"help-block\">If yes, item excellent options will have to be exactly the same, as required. If no, this attribute will not be checked.</span>\r\n                                        </div>\r\n                                        </div>\r\n                                        <div class=\"form-group\">\r\n                                        <label class=\"col-sm-4 control-label\" for=\"id\">Check Item Ancient Option:</label>\r\n                                        <div class=\"col-sm-8\">\r\n                                        <select name=\"ancient" . $tmpcounter . "\" id=\"ancient" . $tmpcounter . "\" class=\"form-control\" aria-describedby=\"helpBlock\">";
                                if (intval($item["ancient"]) == 1) {
                                    $req_items_show .= "<option value=\"1\" selected=\"selected\">Yes</option><option value=\"0\">No</option>";
                                } else {
                                    $req_items_show .= "<option value=\"1\">Yes</option><option value=\"0\" selected=\"selected\">No</option>";
                                }
                                $req_items_show .= "\r\n                                        </select>\r\n                                        <span id=\"ancientHelp\" class=\"help-block\">If yes, item ancient option will have to be exactly the same, as required. If no, this attribute will not be checked.</span>\r\n                                        </div>\r\n                                        </div>\r\n                                        <div class=\"form-group\">\r\n                                        <label class=\"col-sm-4 control-label\" for=\"id\">Check Item Harmony Option:</label>\r\n                                        <div class=\"col-sm-8\">\r\n                                        <select name=\"harmony" . $tmpcounter . "\" id=\"harmony" . $tmpcounter . "\" class=\"form-control\" aria-describedby=\"helpBlock\">";
                                if (intval($item["harmony"]) == 1) {
                                    $req_items_show .= "<option value=\"1\" selected=\"selected\">Yes</option><option value=\"0\">No</option>";
                                } else {
                                    $req_items_show .= "<option value=\"1\">Yes</option><option value=\"0\" selected=\"selected\">No</option>";
                                }
                                $req_items_show .= "\r\n                                        </select>\r\n                                        <span id=\"harmonyHelp\" class=\"help-block\">If yes, item harmony option will have to be exactly the same, as required. If no, this attribute will not be checked.</span>\r\n                                        </div>\r\n                                        </div>\r\n                                        <div class=\"form-group\">\r\n                                        <label class=\"col-sm-4 control-label\" for=\"id\">Check Item Guardian Option:</label>\r\n                                        <div class=\"col-sm-8\">\r\n                                        <select name=\"guardian" . $tmpcounter . "\" id=\"guardian" . $tmpcounter . "\" class=\"form-control\" aria-describedby=\"helpBlock\">";
                                if (intval($item["guardian"]) == 1) {
                                    $req_items_show .= "<option value=\"1\" selected=\"selected\">Yes</option><option value=\"0\">No</option>";
                                } else {
                                    $req_items_show .= "<option value=\"1\">Yes</option><option value=\"0\" selected=\"selected\">No</option>";
                                }
                                $req_items_show .= "\r\n                                        </select>\r\n                                        <span id=\"guardianHelp\" class=\"help-block\">If yes, item guardian option will have to be exactly the same, as required. If no, this attribute will not be checked.</span>\r\n                                        </div>\r\n                                        </div>\r\n                                        <div class=\"form-group\">\r\n                                        <label class=\"col-sm-4 control-label\" for=\"id\">Check Item Socket Options:</label>\r\n                                        <div class=\"col-sm-8\">\r\n                                        <select name=\"socket" . $tmpcounter . "\" id=\"socket" . $tmpcounter . "\" class=\"form-control\" aria-describedby=\"helpBlock\">";
                                if (intval($item["socket"]) == 1) {
                                    $req_items_show .= "<option value=\"1\" selected=\"selected\">Yes</option><option value=\"0\">No</option>";
                                } else {
                                    $req_items_show .= "<option value=\"1\">Yes</option><option value=\"0\" selected=\"selected\">No</option>";
                                }
                                $req_items_show .= "\r\n                                        </select>\r\n                                        <span id=\"socketHelp\" class=\"help-block\">If yes, item socket options will have to be exactly the same, as required. If no, this attribute will not be checked.<br>It also applies for SX excellent options.</span>\r\n                                        </div>\r\n                                        </div>\r\n                                        </div>\r\n                                        </div>\r\n                                        <div class=\"modal-footer\">\r\n                                        <button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>\r\n                                        </div>\r\n                                        </div>\r\n                                        </div>\r\n                                        </div>";
                                $tmpcounter++;
                            }
                        }
                    }
                }
            }
        }
        echo "\r\n        <hr><h3>Edit Reset Stage #";
        echo $_GET["edit"];
        echo "</h3>\r\n        <form action=\"index.php?module=modules_manager&config=reset\" method=\"post\">\r\n            <div id=\"reqitems_edit\"></div>\r\n            <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n                <tr>\r\n                    <th>ID<br/><span>Must be unique and it's used to order priority of the reset stages.</span>\r\n                    </th>\r\n                    <td>\r\n                        <input class=\"form-control\" type=\"text\" name=\"id\" value=\"";
        echo $stageData["id"];
        echo "\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Minimum Reset<br/><span>Select minimum reset required to use this stage.</span>\r\n                    </th>\r\n                    <td>\r\n                        <input class=\"form-control\" type=\"text\" name=\"req_reset_min\" value=\"";
        echo $stageData["req_reset_min"];
        echo "\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Maximum Reset<br/><span>Select maximum reset required to use this stage.</span>\r\n                    </th>\r\n                    <td>\r\n                        <input class=\"form-control\" type=\"text\" name=\"req_reset_max\" value=\"";
        echo $stageData["req_reset_max"];
        echo "\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>\r\n                        Delay<br/><span>Delay time in minutes between resets.<br><b>Example:</b><br>0 = you can make next reset instantly<br>60 = you must wait at least 1 hour to make next reset</span>\r\n                    </th>\r\n                    <td>\r\n                        <input class=\"form-control\" type=\"text\" name=\"time\" value=\"";
        echo $stageData["time"];
        echo "\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Delay\r\n                        VIP<br/><span>Delay time in minutes between resets.<br><b>Example:</b><br>0 = you can make next reset instantly<br>60 = you must wait at least 1 hour to make next reset</span>\r\n                    </th>\r\n                    <td>\r\n                        <input class=\"form-control\" type=\"text\" name=\"time_vip\" value=\"";
        echo $stageData["time_vip"];
        echo "\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Price Requirement<br/></th>\r\n                    <td>\r\n                        ";
        enabledisableCheckboxes("price_req", $stageData["price_req"], "Enabled", "Disabled");
        echo "                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Price Type<br/><span></span>\r\n                    </th>\r\n                    <td>\r\n                        <select class=\"form-control\" name=\"price_type\">\r\n                            ";
        $customOpt = "";
        foreach ($customItems as $thisItem) {
            if (intval($stageData["price_type"]) == $thisItem["ident"]) {
                $customOpt .= "<option value=\"" . $thisItem["ident"] . "\" selected=\"selected\">" . $thisItem["name"] . " (Web Bank)</option>";
            } else {
                $customOpt .= "<option value=\"" . $thisItem["ident"] . "\">" . $thisItem["name"] . " (Web Bank)</option>";
            }
        }
        if (intval($stageData["price_type"]) == "1") {
            echo "<option value=\"1\" selected=\"selected\">Platinum Coins</option>";
        } else {
            echo "<option value=\"1\">Platinum Coins</option>";
        }
        if (intval($stageData["price_type"]) == "2") {
            echo "<option value=\"2\" selected=\"selected\">Gold Coins</option>";
        } else {
            echo "<option value=\"2\">Gold Coins</option>";
        }
        if (intval($stageData["price_type"]) == "3") {
            echo "<option value=\"3\" selected=\"selected\">Silver Coins</option>";
        } else {
            echo "<option value=\"3\">Silver Coins</option>";
        }
        if (intval($stageData["price_type"]) == "4") {
            echo "<option value=\"4\" selected=\"selected\">WCoinC</option>";
        } else {
            echo "<option value=\"4\">WCoinC</option>";
        }
        if (intval($stageData["price_type"]) == "5") {
            echo "<option value=\"5\" selected=\"selected\">Goblin Points</option>";
        } else {
            echo "<option value=\"5\">Goblin Points</option>";
        }
        if (intval($stageData["price_type"]) == "6") {
            echo "<option value=\"6\" selected=\"selected\">Zen</option>";
        } else {
            echo "<option value=\"6\">Zen</option>";
        }
        if (intval($stageData["price_type"]) == "7") {
            echo "<option value=\"7\" selected=\"selected\">Jewel of Bless</option>";
        } else {
            echo "<option value=\"7\">Jewel of Bless</option>";
        }
        if (intval($stageData["price_type"]) == "8") {
            echo "<option value=\"8\" selected=\"selected\">Jewel of Soul</option>";
        } else {
            echo "<option value=\"8\">Jewel of Soul</option>";
        }
        if (intval($stageData["price_type"]) == "9") {
            echo "<option value=\"9\" selected=\"selected\">Jewel of Life</option>";
        } else {
            echo "<option value=\"9\">Jewel of Life</option>";
        }
        if (intval($stageData["price_type"]) == "10") {
            echo "<option value=\"10\" selected=\"selected\">Jewel of Chaos</option>";
        } else {
            echo "<option value=\"10\">Jewel of Chaos</option>";
        }
        if (intval($stageData["price_type"]) == "11") {
            echo "<option value=\"11\" selected=\"selected\">Jewel of Harmony</option>";
        } else {
            echo "<option value=\"11\">Jewel of Harmony</option>";
        }
        if (intval($stageData["price_type"]) == "12") {
            echo "<option value=\"12\" selected=\"selected\">Jewel of Creation</option>";
        } else {
            echo "<option value=\"12\">Jewel of Creation</option>";
        }
        if (intval($stageData["price_type"]) == "13") {
            echo "<option value=\"13\" selected=\"selected\">Jewel of Guardian</option>";
        } else {
            echo "<option value=\"13\">Jewel of Guardian</option>";
        }
        echo $customOpt;
        echo "                        </select>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Price Value<br/><span>If price requirement is enabled, set the price of this feature.</span></th>\r\n                    <td>\r\n                        <input class=\"form-control\" type=\"text\" name=\"price\" value=\"";
        echo $stageData["price"];
        echo "\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Price Value VIP<br/><span>If price requirement is enabled, set the price of this feature.</span></th>\r\n                    <td>\r\n                        <input class=\"form-control\" type=\"text\" name=\"price_vip\" value=\"";
        echo $stageData["price_vip"];
        echo "\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Reset Price Formula<br/><span></span></th>\r\n                    <td>\r\n                        ";
        enabledisableCheckboxes2("price_formula", $stageData["price_formula"], "Price * (Resets + 1)", "Fixed Price");
        echo "                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Required Level<br/><span>Required level to reset.</span></th>\r\n                    <td>\r\n                        <input class=\"form-control\" type=\"text\" name=\"req_lvl\" value=\"";
        echo $stageData["req_lvl"];
        echo "\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Required Level VIP<br/><span>Required level to reset.</span></th>\r\n                    <td>\r\n                        <input class=\"form-control\" type=\"text\" name=\"req_lvl_vip\" value=\"";
        echo $stageData["req_lvl_vip"];
        echo "\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Required Master Level<br/><span>Required master level to reset.</span></th>\r\n                    <td>\r\n                        <input class=\"form-control\" type=\"text\" name=\"req_mlvl\" value=\"";
        echo $stageData["req_mlvl"];
        echo "\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Required Master Level VIP<br/><span>Required master level to reset.</span></th>\r\n                    <td>\r\n                        <input class=\"form-control\" type=\"text\" name=\"req_mlvl_vip\" value=\"";
        echo $stageData["req_mlvl_vip"];
        echo "\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Apply Equipment Check<br/></th>\r\n                    <td>\r\n                        ";
        enabledisableCheckboxes("apply_equip_check", $stageData["apply_equip_check"], "Enabled", "Disabled");
        echo "                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Enable Items Requirement<br/></th>\r\n                    <td>\r\n                        ";
        enabledisableCheckboxes("items_req", $stageData["items_req"], "Enabled", "Disabled");
        echo "                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Required Items<br/><span>All required items must be placed in character's inventory (normal, store, extended #1 or #2).</span></th>\r\n                    <td>\r\n                        ";
        if ($req_items_show != "") {
            echo $req_items_show . "<hr>";
        }
        echo "                        <div id=\"editItemAttributes\" class=\"alert alert-info\" style=\"display: none;\"><span class=\"error_icons info\"></span>\r\n                            <p>INFO: Please don't forget to edit item's attributes what have to be checked by clicking on \"Edit\" button near each item.</p></div>\r\n                        <div id=newItem></div>\r\n                        <script type=\"text/javascript\">\r\n                            var iid = 0;\r\n\r\n                            function addItem() {\r\n                                if (iid < 50) {\r\n                                    var newItem = \$('#newItem');\r\n                                    var reqitem_edit = \$('#newItem');\r\n                                    var html = 'Item ' + (iid + 1) + ': <input type=\"text\" class=\"form-control\" style=\"display:inline; width:70%;\" maxlength=\"64\" size=\"80\" name=\"item' + iid + '\" value=\"";
        echo __ITEM_EMPTY__;
        echo "\" /> Count: <input type=\"text\" class=\"form-control\" style=\"display:inline; max-width:50px;\" maxlength=\"64\" size=\"4\" name=\"itemcount' + iid + '\" value=\"1\" /> <button type=\"button\" class=\"btn btn-default btn-sm\" data-toggle=\"modal\" data-target=\"#reqitems' + iid + '\"><i class=\"fa fa-edit\"></i> Edit</button><br>';\r\n                                    var html2 = '<div id=\"reqitems' + iid + '\" class=\"modal fade\" role=\"dialog\">' +\r\n                                        '<div class=\"modal-dialog modal-lg\">' +\r\n                                        '<div class=\"modal-content\">' +\r\n                                        '<div class=\"modal-header\">' +\r\n                                        '<button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>' +\r\n                                        '<h4 class=\"modal-title\">Edit checked Attributes for Item #' + (iid + 1) + '</h4>' +\r\n                                        '</div>' +\r\n                                        '<div class=\"modal-body\">' +\r\n                                        '<div style=\"min-height: 900px;\">' +\r\n                                        '<div class=\"form-group\">' +\r\n                                        '<label class=\"col-sm-4 control-label\" for=\"id\">Check Item Level:</label>' +\r\n                                        '<div class=\"col-sm-8\">' +\r\n                                        '<select name=\"level' + iid + '\" id=\"level' + iid + '\" class=\"form-control\" aria-describedby=\"helpBlock\">' +\r\n                                        '<option value=\"1\">Yes</option>' +\r\n                                        '<option value=\"0\">No</option>' +\r\n                                        '</select>' +\r\n                                        '<span id=\"levelHelp\" class=\"help-block\">If yes, item level will have to be exactly the same, as required. If no, this attribute will not be checked.</span>' +\r\n                                        '</div>' +\r\n                                        '</div>' +\r\n                                        '<div class=\"form-group\">' +\r\n                                        '<label class=\"col-sm-4 control-label\" for=\"id\">Check Item Option:</label>' +\r\n                                        '<div class=\"col-sm-8\">' +\r\n                                        '<select name=\"option' + iid + '\" id=\"option' + iid + '\" class=\"form-control\" aria-describedby=\"helpBlock\">' +\r\n                                        '<option value=\"1\">Yes</option>' +\r\n                                        '<option value=\"0\">No</option>' +\r\n                                        '</select>' +\r\n                                        '<span id=\"optionHelp\" class=\"help-block\">If yes, item option will have to be exactly the same, as required. If no, this attribute will not be checked.</span>' +\r\n                                        '</div>' +\r\n                                        '</div>' +\r\n                                        '<div class=\"form-group\">' +\r\n                                        '<label class=\"col-sm-4 control-label\" for=\"id\">Check Item Durability:</label>' +\r\n                                        '<div class=\"col-sm-8\">' +\r\n                                        '<select name=\"durability' + iid + '\" id=\"durability' + iid + '\" class=\"form-control\" aria-describedby=\"helpBlock\">' +\r\n                                        '<option value=\"1\">Yes</option>' +\r\n                                        '<option value=\"0\">No</option>' +\r\n                                        '</select>' +\r\n                                        '<span id=\"durabilityHelp\" class=\"help-block\">If yes, item durability will have to be exactly the same, as required. If no, this attribute will not be checked.</span>' +\r\n                                        '</div>' +\r\n                                        '</div>' +\r\n                                        '<div class=\"form-group\">' +\r\n                                        '<label class=\"col-sm-4 control-label\" for=\"id\">Check Item Luck:</label>' +\r\n                                        '<div class=\"col-sm-8\">' +\r\n                                        '<select name=\"luck' + iid + '\" id=\"luck' + iid + '\" class=\"form-control\" aria-describedby=\"helpBlock\">' +\r\n                                        '<option value=\"1\">Yes</option>' +\r\n                                        '<option value=\"0\">No</option>' +\r\n                                        '</select>' +\r\n                                        '<span id=\"luckHelp\" class=\"help-block\">If yes, item luck will have to be exactly the same, as required. If no, this attribute will not be checked.</span>' +\r\n                                        '</div>' +\r\n                                        '</div>' +\r\n                                        '<div class=\"form-group\">' +\r\n                                        '<label class=\"col-sm-4 control-label\" for=\"id\">Check Item Skill:</label>' +\r\n                                        '<div class=\"col-sm-8\">' +\r\n                                        '<select name=\"skill' + iid + '\" id=\"skill' + iid + '\" class=\"form-control\" aria-describedby=\"helpBlock\">' +\r\n                                        '<option value=\"1\">Yes</option>' +\r\n                                        '<option value=\"0\">No</option>' +\r\n                                        '</select>' +\r\n                                        '<span id=\"skillHelp\" class=\"help-block\">If yes, item skill will have to be exactly the same, as required. If no, this attribute will not be checked.</span>' +\r\n                                        '</div>' +\r\n                                        '</div>' +\r\n                                        '<div class=\"form-group\">' +\r\n                                        '<label class=\"col-sm-4 control-label\" for=\"id\">Check Item Excellent Options:</label>' +\r\n                                        '<div class=\"col-sm-8\">' +\r\n                                        '<select name=\"excellent' + iid + '\" id=\"excellent' + iid + '\" class=\"form-control\" aria-describedby=\"helpBlock\">' +\r\n                                        '<option value=\"1\">Yes</option>' +\r\n                                        '<option value=\"0\">No</option>' +\r\n                                        '</select>' +\r\n                                        '<span id=\"excellentHelp\" class=\"help-block\">If yes, item excellent options will have to be exactly the same, as required. If no, this attribute will not be checked.</span>' +\r\n                                        '</div>' +\r\n                                        '</div>' +\r\n                                        '<div class=\"form-group\">' +\r\n                                        '<label class=\"col-sm-4 control-label\" for=\"id\">Check Item Ancient Option:</label>' +\r\n                                        '<div class=\"col-sm-8\">' +\r\n                                        '<select name=\"ancient' + iid + '\" id=\"ancient' + iid + '\" class=\"form-control\" aria-describedby=\"helpBlock\">' +\r\n                                        '<option value=\"1\">Yes</option>' +\r\n                                        '<option value=\"0\">No</option>' +\r\n                                        '</select>' +\r\n                                        '<span id=\"ancientHelp\" class=\"help-block\">If yes, item ancient option will have to be exactly the same, as required. If no, this attribute will not be checked.</span>' +\r\n                                        '</div>' +\r\n                                        '</div>' +\r\n                                        '<div class=\"form-group\">' +\r\n                                        '<label class=\"col-sm-4 control-label\" for=\"id\">Check Item Harmony Option:</label>' +\r\n                                        '<div class=\"col-sm-8\">' +\r\n                                        '<select name=\"harmony' + iid + '\" id=\"harmony' + iid + '\" class=\"form-control\" aria-describedby=\"helpBlock\">' +\r\n                                        '<option value=\"1\">Yes</option>' +\r\n                                        '<option value=\"0\">No</option>' +\r\n                                        '</select>' +\r\n                                        '<span id=\"harmonyHelp\" class=\"help-block\">If yes, item harmony option will have to be exactly the same, as required. If no, this attribute will not be checked.</span>' +\r\n                                        '</div>' +\r\n                                        '</div>' +\r\n                                        '<div class=\"form-group\">' +\r\n                                        '<label class=\"col-sm-4 control-label\" for=\"id\">Check Item Guardian Option:</label>' +\r\n                                        '<div class=\"col-sm-8\">' +\r\n                                        '<select name=\"guardian' + iid + '\" id=\"guardian' + iid + '\" class=\"form-control\" aria-describedby=\"helpBlock\">' +\r\n                                        '<option value=\"1\">Yes</option>' +\r\n                                        '<option value=\"0\">No</option>' +\r\n                                        '</select>' +\r\n                                        '<span id=\"guardianHelp\" class=\"help-block\">If yes, item guardian option will have to be exactly the same, as required. If no, this attribute will not be checked.</span>' +\r\n                                        '</div>' +\r\n                                        '</div>' +\r\n                                        '<div class=\"form-group\">' +\r\n                                        '<label class=\"col-sm-4 control-label\" for=\"id\">Check Item Socket Options:</label>' +\r\n                                        '<div class=\"col-sm-8\">' +\r\n                                        '<select name=\"socket' + iid + '\" id=\"socket' + iid + '\" class=\"form-control\" aria-describedby=\"helpBlock\">' +\r\n                                        '<option value=\"1\">Yes</option>' +\r\n                                        '<option value=\"0\">No</option>' +\r\n                                        '</select>' +\r\n                                        '<span id=\"socketHelp\" class=\"help-block\">If yes, item socket options will have to be exactly the same, as required. If no, this attribute will not be checked.<br>It also applies for SX excellent options.</span>' +\r\n                                        '</div>' +\r\n                                        '</div>' +\r\n                                        '</div>' +\r\n                                        '</div>' +\r\n                                        '<div class=\"modal-footer\">' +\r\n                                        '<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>' +\r\n                                        '</div>' +\r\n                                        '</div>' +\r\n                                        '</div>' +\r\n                                        '</div>';\r\n                                    newItem.append(html);\r\n                                    reqitem_edit.append(html2);\r\n                                    iid = iid + 1;\r\n                                }\r\n                            }\r\n                        </script>\r\n                        <br>\r\n                        <input type=\"button\" value=\"Add New\" class=\"btn btn-primary\" onClick=\"\$('#editItemAttributes').css('display', 'block'); addItem();\">\r\n                        <input class=\"btn btn-primary\" type=\"button\" onClick=\"popitup('item_hex_generator.php')\" value=\"Item Code Generator\" title=\"Item Code Generator\">\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Reset Stats<br/><span></span></th>\r\n                    <td>\r\n                        ";
        enabledisableCheckboxes("reset_stats", $stageData["reset_stats"], "Yes", "No");
        echo "                    </td>\r\n                </tr>\r\n\r\n                <tr>\r\n                    <th>Bonus Stats Type<br/><span></span></th>\r\n                    <td>\r\n                        <div class=\"radio_switch\">\r\n                            <label class=\"opt1\"><input type=\"radio\" name=\"bonus_stats_type\" value=\"1\"\r\n                                                       onclick=\"toggleBonusStatsType('perClass');\" ";
        if ($stageData["bonus_stats_type"] == "1") {
            echo "checked";
        }
        echo "><span>Per Class</span></label>\r\n                            <label class=\"opt2\"><input type=\"radio\" name=\"bonus_stats_type\" value=\"0\"\r\n                                                       onclick=\"toggleBonusStatsType('fixed');\" ";
        if ($stageData["bonus_stats_type"] == "0" || $stageData["bonus_stats_type"] == NULL) {
            echo "checked";
        }
        echo "><span>Fixed</span></label>\r\n                        </div>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Bonus Stats<br/><span></span></th>\r\n                    <td>\r\n                        <table width=\"100%\" id=\"bonusStatsPerClass\" class=\"";
        if ($stageData["bonus_stats_type"] == "0" || $stageData["bonus_stats_type"] == NULL) {
            echo "hidden";
        }
        echo "\">\r\n                            ";
        $itemsPerLine = 3;
        $currentLine = 0;
        $counter = 0;
        if (122 <= config("server_files_season", true)) {
            $itemsPerLine = 4;
        }
        if (is_array($custom["character_class"])) {
            foreach ($custom["character_class"] as $classCode => $thisClass) {
                if ($counter == 0) {
                    echo "<tr>";
                }
                echo "<td><b>" . $thisClass[0] . "</b> <input type=\"text\" name=\"bonus_stats_" . $classCode . "\" value=\"" . $stageData["bonus_stats_" . $classCode] . "\" class=\"form-control\" placeholder=\"" . $thisClass[0] . "\" /></td>";
                if ($currentLine == 3 || $currentLine == 4 || $currentLine == 6 || $currentLine == 7) {
                    if ($counter == $itemsPerLine - 2) {
                        echo "</tr>";
                        $counter = 0;
                        $currentLine++;
                    }
                } else {
                    if ($counter == $itemsPerLine - 1) {
                        echo "</tr>";
                        $counter = 0;
                        $currentLine++;
                    }
                }
                $counter++;
            }
        }
        echo "                        </table>\r\n                        <input id=\"bonusStatsFixed\" class=\"form-control";
        if ($stageData["bonus_stats_type"] == "1") {
            echo " hidden";
        }
        echo "\" type=\"text\" name=\"bonus_stats\"\r\n                               value=\"";
        echo $stageData["bonus_stats"];
        echo "\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Bonus Stats VIP<br/><span></span></th>\r\n                    <td>\r\n                        <table width=\"100%\" id=\"bonusStatsPerClassVIP\" class=\"";
        if ($stageData["bonus_stats_type"] == "0" || $stageData["bonus_stats_type"] == NULL) {
            echo "hidden";
        }
        echo "\">\r\n                            ";
        $itemsPerLine = 3;
        $currentLine = 0;
        $counter = 0;
        if (122 <= config("server_files_season", true)) {
            $itemsPerLine = 4;
        }
        if (is_array($custom["character_class"])) {
            foreach ($custom["character_class"] as $classCode => $thisClass) {
                if ($counter == 0) {
                    echo "<tr>";
                }
                echo "<td><b>" . $thisClass[0] . "</b> <input type=\"text\" name=\"bonus_stats_vip_" . $classCode . "\" value=\"" . $stageData["bonus_stats_vip_" . $classCode] . "\" class=\"form-control\" placeholder=\"" . $thisClass[0] . "\" /></td>";
                if ($currentLine == 3 || $currentLine == 4 || $currentLine == 6 || $currentLine == 7) {
                    if ($counter == $itemsPerLine - 2) {
                        echo "</tr>";
                        $counter = 0;
                        $currentLine++;
                    }
                } else {
                    if ($counter == $itemsPerLine - 1) {
                        echo "</tr>";
                        $counter = 0;
                        $currentLine++;
                    }
                }
                $counter++;
            }
        }
        echo "                        </table>\r\n                        <input id=\"bonusStatsFixedVIP\" class=\"form-control";
        if ($stageData["bonus_stats_type"] == "1") {
            echo " hidden";
        }
        echo "\" type=\"text\" name=\"bonus_stats_vip\"\r\n                               value=\"";
        echo $stageData["bonus_stats_vip"];
        echo "\"/>\r\n                    </td>\r\n                </tr>\r\n\r\n                <!--<tr>\r\n                    <th>Bonus Stats<br/><span></span></th>\r\n                    <td>\r\n                        <input class=\"form-control\" type=\"text\" name=\"bonus_stats\" value=\"";
        echo $stageData["bonus_stats"];
        echo "\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Bonus Stats VIP<br/><span></span></th>\r\n                    <td>\r\n                        <input class=\"form-control\" type=\"text\" name=\"bonus_stats_vip\" value=\"";
        echo $stageData["bonus_stats_vip"];
        echo "\"/>\r\n                    </td>\r\n                </tr>-->\r\n                <tr>\r\n                    <th>Bonus Stats Formula<br/><span></span></th>\r\n                    <td>\r\n                        ";
        enabledisableCheckboxes2("bonus_stats_formula", $stageData["bonus_stats_formula"], "Bonus * (Resets + 1)", "Fixed Bonus");
        echo "                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Clear Master Level<br/><span>If \"Yes\", after reset master level and 4th level will be set to 0 and master level points and 4th level points will be deleted.</span></th>\r\n                    <td>\r\n                        ";
        enabledisableCheckboxes("clear_ml", $stageData["clear_ml"], "Yes", "No");
        echo "                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Clear 3rd Skill Tree<br/><span>If \"Yes\", after reset 3rd skill tree will be cleared.</span></th>\r\n                    <td>\r\n                        ";
        enabledisableCheckboxes("clear_ml_tree", $stageData["clear_ml_tree"], "Yes", "No");
        echo "                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Clear 4th Skill Tree<br/><span>If \"Yes\", after reset 4th skill tree will be cleared.</span></th>\r\n                    <td>\r\n                        ";
        enabledisableCheckboxes("clear_4th_tree", $stageData["clear_4th_tree"], "Yes", "No");
        echo "                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Level after Reset<br/><span>Select level what will character get after reset.</span>\r\n                    </th>\r\n                    <td>\r\n                        <input class=\"form-control\" type=\"text\" name=\"lvl_after_reset\" value=\"";
        echo $stageData["lvl_after_reset"];
        echo "\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Level after Reset VIP<br/><span>Select level what will character get after reset.</span>\r\n                    </th>\r\n                    <td>\r\n                        <input class=\"form-control\" type=\"text\" name=\"lvl_after_reset_vip\" value=\"";
        echo $stageData["lvl_after_reset_vip"];
        echo "\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>EXP after Reset<br/><span>Select amount of exp what will character get after reset.<br><i>You can find exact values for each level in IGC.EssentailTools.</i></span>\r\n                    </th>\r\n                    <td>\r\n                        <input class=\"form-control\" type=\"text\" name=\"exp_after_reset\" value=\"";
        echo $stageData["exp_after_reset"];
        echo "\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>EXP after Reset VIP<br/><span>Select amount of exp what will character get after reset.<br><i>You can find exact values for each level in IGC.EssentailTools.</i></span>\r\n                    </th>\r\n                    <td>\r\n                        <input class=\"form-control\" type=\"text\" name=\"exp_after_reset_vip\" value=\"";
        echo $stageData["exp_after_reset_vip"];
        echo "\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Map after Reset<br/><span>Select map where will be moved character after reset.</span>\r\n                    </th>\r\n                    <td>\r\n                        <select class=\"form-control\" name=\"map_after_reset\">\r\n                            ";
        foreach ($custom["map_codes"] as $key => $thisMap) {
            if ($stageData["map_after_reset"] == $key) {
                echo "<option value=\"" . $key . "\" selected=\"selected\">" . $thisMap . "</option>";
            } else {
                echo "<option value=\"" . $key . "\">" . $thisMap . "</option>";
            }
        }
        echo "                        </select>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Map Coordinates after Reset<br/><span>Select map coordinates where will be moved character after reset.</span>\r\n                    </th>\r\n                    <td>\r\n                        X: <input class=\"form-control\" type=\"text\" name=\"map_coord_x_after_reset\" value=\"";
        echo $stageData["map_coord_x_after_reset"];
        echo "\"\r\n                                  style=\"width: calc(100% - 20px); display: inline;\"/><br/>\r\n                        Y: <input class=\"form-control\" type=\"text\" name=\"map_coord_y_after_reset\" value=\"";
        echo $stageData["map_coord_y_after_reset"];
        echo "\"\r\n                                  style=\"width: calc(100% - 20px); display: inline;\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Credits Reward<br/><span>Enable/disable giving credit(s) reward for every reset.</span></th>\r\n                    <td>\r\n                        ";
        enabledisableCheckboxes("is_cred_reward", $stageData["is_cred_reward"], "Enabled", "Disabled");
        echo "                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Reward<br/><span>If credits reward is enabled, set the amount of credits that will be rewarded for every reset.</span>\r\n                    </th>\r\n                    <td>\r\n                        <input class=\"form-control\" type=\"text\" name=\"cred_reward\" value=\"";
        echo $stageData["cred_reward"];
        echo "\" style=\"display: inline; width: 150px\"/> credit(s)\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Reward VIP<br/><span>If credits reward is enabled, set the amount of credits that will be rewarded for every reset.</span></th>\r\n                    <td>\r\n                        <input class=\"form-control\" type=\"text\" name=\"cred_reward_vip\" value=\"";
        echo $stageData["cred_reward_vip"];
        echo "\" style=\"display: inline; width: 150px\"/> credit(s)\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <th>Reward Type<br/><span></span></th>\r\n                    <td>\r\n                        ";
        echo $creditSystem->buildSelectInput("credit_config", $stageData["credit_config"], "form-control");
        echo "                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan=\"2\"><input type=\"submit\" name=\"save_stage\" value=\"Save Reset Stage\" class=\"btn btn-success\" style=\"width: 100%;\"/></td>\r\n                </tr>\r\n            </table>\r\n        </form>\r\n\r\n        ";
    }
} else {
    loadModuleConfigs("usercp.reset");
    echo "    <form action=\"\" method=\"post\">\r\n        <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n            <tr>\r\n                <th>Status<br/><span>Enable/disable the character reset module.</span></th>\r\n                <td>\r\n                    ";
    enabledisableCheckboxes("setting_1", mconfig("active"), "Enabled", "Disabled");
    echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Keep GR Bonus Stats after Reset<br/><span></span></th>\r\n                <td>\r\n                    ";
    enabledisableCheckboxes("setting_2", mconfig("keep_gr_bonus"), "Yes", "No");
    echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Calculate Price separately for each Stage<br/><span>If \"Yes\", price of reset in current stage won't be affected by price configuration of previous reset stages.</span></th>\r\n                <td>\r\n                    ";
    enabledisableCheckboxes("stage_price_separate", mconfig("stage_price_separate"), "Yes", "No");
    echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Check Equipment<br/><span>If enabled, character will have to remove item from specific slot to be able to proceed with reset.</span></th>\r\n                <td>\r\n                    <table width=\"100%\">\r\n                        <tr>\r\n                            <td width=\"30%\"><b>Left Hand:</b></td>\r\n                            <td width=\"70%\">";
    enabledisableCheckboxes("setting_3", mconfig("check_equip_0"), "Yes", "No");
    echo "</td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td width=\"30%\"><b>Right Hand:</b></td>\r\n                            <td width=\"70%\">";
    enabledisableCheckboxes("setting_4", mconfig("check_equip_1"), "Yes", "No");
    echo "</td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td width=\"30%\"><b>Helmet:</b></td>\r\n                            <td width=\"70%\">";
    enabledisableCheckboxes("setting_5", mconfig("check_equip_2"), "Yes", "No");
    echo "</td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td width=\"30%\"><b>Armor:</b></td>\r\n                            <td width=\"70%\">";
    enabledisableCheckboxes("setting_6", mconfig("check_equip_3"), "Yes", "No");
    echo "</td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td width=\"30%\"><b>Pants:</b></td>\r\n                            <td width=\"70%\">";
    enabledisableCheckboxes("setting_7", mconfig("check_equip_4"), "Yes", "No");
    echo "</td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td width=\"30%\"><b>Gloves:</b></td>\r\n                            <td width=\"70%\">";
    enabledisableCheckboxes("setting_8", mconfig("check_equip_5"), "Yes", "No");
    echo "</td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td width=\"30%\"><b>Boots:</b></td>\r\n                            <td width=\"70%\">";
    enabledisableCheckboxes("setting_9", mconfig("check_equip_6"), "Yes", "No");
    echo "</td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td width=\"30%\"><b>Wings:</b></td>\r\n                            <td width=\"70%\">";
    enabledisableCheckboxes("setting_10", mconfig("check_equip_7"), "Yes", "No");
    echo "</td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td width=\"30%\"><b>Pet:</b></td>\r\n                            <td width=\"70%\">";
    enabledisableCheckboxes("setting_11", mconfig("check_equip_8"), "Yes", "No");
    echo "</td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td width=\"30%\"><b>Pendant:</b></td>\r\n                            <td width=\"70%\">";
    enabledisableCheckboxes("setting_12", mconfig("check_equip_9"), "Yes", "No");
    echo "</td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td width=\"30%\"><b>Left Ring:</b></td>\r\n                            <td width=\"70%\">";
    enabledisableCheckboxes("setting_13", mconfig("check_equip_10"), "Yes", "No");
    echo "</td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td width=\"30%\"><b>Right Ring:</b></td>\r\n                            <td width=\"70%\">";
    enabledisableCheckboxes("setting_14", mconfig("check_equip_11"), "Yes", "No");
    echo "</td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td width=\"30%\"><b>Pentagram:</b></td>\r\n                            <td width=\"70%\">";
    enabledisableCheckboxes("setting_15", mconfig("check_equip_236"), "Yes", "No");
    echo "</td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td width=\"30%\"><b>Earring (R):</b></td>\r\n                            <td width=\"70%\">";
    enabledisableCheckboxes("check_equip_237", mconfig("check_equip_237"), "Yes", "No");
    echo "</td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td width=\"30%\"><b>Earring (L):</b></td>\r\n                            <td width=\"70%\">";
    enabledisableCheckboxes("check_equip_238", mconfig("check_equip_238"), "Yes", "No");
    echo "</td>\r\n                        </tr>\r\n                    </table>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td colspan=\"2\"><input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\" class=\"btn btn-success\"/></td>\r\n            </tr>\r\n        </table>\r\n    </form>\r\n\r\n    <hr><h3>Manage Reset Stages</h3>";
    $xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "usercp.reset.xml");
    echo "<table class=\"table table-striped table-bordered table-hover\"><tr><th>ID</th><th>Reset Range</th><th>Required Level</th><th>Required Master Level</th><th>Bonus Stats</th><th>Delay</th><th>Action</th>";
    if ($xml !== false) {
        $resets = [];
        $i = 1;
        foreach ($xml->resets->children() as $tag => $reset) {
            if ($tag == "reset") {
                $resets[$i]["id"] = intval($reset["id"]);
                $resets[$i]["req_reset_min"] = intval($reset["req_reset_min"]);
                $resets[$i]["req_reset_max"] = intval($reset["req_reset_max"]);
                $resets[$i]["price_req"] = intval($reset["price_req"]);
                $resets[$i]["price_type"] = intval($reset["price_type"]);
                $resets[$i]["price"] = intval($reset["price"]);
                $resets[$i]["price_vip"] = intval($reset["price_vip"]);
                $resets[$i]["price_formula"] = intval($reset["price_formula"]);
                $resets[$i]["req_lvl"] = intval($reset["req_lvl"]);
                $resets[$i]["req_lvl_vip"] = intval($reset["req_lvl_vip"]);
                $resets[$i]["req_mlvl"] = intval($reset["req_mlvl"]);
                $resets[$i]["req_mlvl_vip"] = intval($reset["req_mlvl_vip"]);
                $resets[$i]["apply_equip_check"] = intval($reset["apply_equip_check"]);
                $resets[$i]["items_req"] = intval($reset["items_req"]);
                $resets[$i]["reset_stats"] = intval($reset["reset_stats"]);
                $resets[$i]["bonus_stats"] = intval($reset["bonus_stats"]);
                $resets[$i]["bonus_stats_vip"] = intval($reset["bonus_stats_vip"]);
                $resets[$i]["bonus_stats_formula"] = intval($reset["bonus_stats_formula"]);
                $resets[$i]["is_cred_reward"] = intval($reset["is_cred_reward"]);
                $resets[$i]["cred_reward"] = intval($reset["cred_reward"]);
                $resets[$i]["cred_reward_vip"] = intval($reset["cred_reward_vip"]);
                $resets[$i]["credit_config"] = intval($reset["credit_config"]);
                $resets[$i]["clear_ml"] = intval($reset["clear_ml"]);
                $resets[$i]["clear_ml_tree"] = intval($reset["clear_ml_tree"]);
                $resets[$i]["clear_4th_tree"] = intval($reset["clear_4th_tree"]);
                $resets[$i]["lvl_after_reset"] = intval($reset["lvl_after_reset"]);
                $resets[$i]["lvl_after_reset_vip"] = intval($reset["lvl_after_reset_vip"]);
                $resets[$i]["exp_after_reset"] = intval($reset["exp_after_reset"]);
                $resets[$i]["exp_after_reset_vip"] = intval($reset["exp_after_reset_vip"]);
                $resets[$i]["map_after_reset"] = intval($reset["map_after_reset"]);
                $resets[$i]["map_coord_x_after_reset"] = intval($reset["map_coord_x_after_reset"]);
                $resets[$i]["map_coord_y_after_reset"] = intval($reset["map_coord_y_after_reset"]);
                $resets[$i]["time"] = intval($reset["time"]);
                $resets[$i]["time_vip"] = intval($reset["time_vip"]);
                $req_items_show = "";
                if ($reset->req_items->children() != NULL) {
                    $tmpcounter = 0;
                    foreach ($reset->req_items->children() as $innerTag => $item) {
                        if ($innerTag == "item") {
                            $resets[$i]["req_items"][$tmpcounter]["hexcode"] = strval($item["hexcode"]);
                            $resets[$i]["req_items"][$tmpcounter]["count"] = intval($item["count"]);
                            $itemInfo = $Items->ItemInfo(strval($item["hexcode"]));
                            $luck = "";
                            $skill = "";
                            $option = "";
                            $exl = "";
                            $ancsetopt = "";
                            if ($itemInfo["level"]) {
                                $itemInfo["level"] = " +" . $itemInfo["level"];
                            } else {
                                $itemInfo["level"] = NULL;
                            }
                            if ($itemInfo["luck"]) {
                                $luck = "<br><font color=#9aadd5>" . $itemInfo["luck"] . "</font>";
                            }
                            if ($itemInfo["skill"]) {
                                $skill = "<br><font color=#9aadd5>" . $itemInfo["skill"] . "</font>";
                            }
                            if ($itemInfo["opt"]) {
                                $option = "<font color=#9aadd5>" . $itemInfo["opt"] . "</font>";
                            }
                            if ($itemInfo["exl"]) {
                                $exl = "<font color=#4d668d>" . str_replace("^^", "<br>", $itemInfo["exl"]) . "</font>";
                            }
                            if ($itemInfo["ancsetopt"]) {
                                $ancsetopt = "<font color=#9aadd5>" . str_replace("^^", "<br>", $itemInfo["ancsetopt"]) . "</font>";
                            }
                            $req_items_show .= "<span  style=\"cursor: pointer;\" onmouseover=\"Tip('<center><img src=" . $itemInfo["thumb"] . "><br /><font color=yellow><br><font color=white><br>Durability: " . $itemInfo["dur"] . "</font><br><font color=#FF99CC>" . $itemInfo["jog"] . "</font><font color=FFCC00>" . $itemInfo["harm"] . "</font><br>" . $option . " " . $luck . " " . $skill . " " . $exl . " <br>" . $ancsetopt . "<br><font color=#4d668d>" . $itemInfo["socket"] . "</font><br><br><span class=itemTooltipClassReq>" . $itemInfo["classReq"] . "</span></center>', TITLEFONTCOLOR, '" . $itemInfo["color"] . "',TITLE,'" . addslashes($itemInfo["name"]) . $itemInfo["level"] . "',TITLEBGCOLOR,'" . $itemInfo["anco"] . "')\" onmouseout=\"UnTip()\">Item " . ($tmpcounter + 1) . "</span>: <input class=\"form-control\" type=\"text\" name=\"item" . $tmpcounter . "_" . intval($reset["id"]) . "\" value=\"" . strval($item["hexcode"]) . "\" placeholder=\"Item Hex Code\" style=\"display:inline; width:70%;\" maxlength=\"64\" size=\"80\"/>";
                            $req_items_show .= " Count: <input type=\"text\" class=\"form-control\" style=\"display:inline; max-width:50px;\" maxlength=\"64\" size=\"4\" name=\"itemcount" . $tmpcounter . "_" . intval($reset["id"]) . "\" value=\"" . intval($item["count"]) . "\" /><br>";
                            $tmpcounter++;
                        }
                    }
                }
                if ($reset["lvl_after_reset"] == NULL) {
                    $reset["lvl_after_reset"] = 1;
                }
                if ($reset["lvl_after_reset_vip"] == NULL) {
                    $reset["lvl_after_reset_vip"] = 1;
                }
                if ($reset["exp_after_reset"] == NULL) {
                    $reset["exp_after_reset"] = 0;
                }
                if ($reset["exp_after_reset_vip"] == NULL) {
                    $reset["exp_after_reset_vip"] = 0;
                }
                if ($reset["map_after_reset"] == NULL) {
                    $reset["map_after_reset"] = 0;
                }
                if ($reset["map_coord_x_after_reset"] == NULL) {
                    $reset["map_coord_x_after_reset"] = 130;
                }
                if ($reset["map_coord_y_after_reset"] == NULL) {
                    $reset["map_coord_y_after_reset"] = 130;
                }
                echo "<tr>";
                echo "<td>" . intval($reset["id"]) . "</td>";
                echo "<td>" . intval($reset["req_reset_min"]) . " - " . intval($reset["req_reset_max"]) . "</td>";
                echo "<td>" . intval($reset["req_lvl"]) . " (VIP: " . intval($reset["req_lvl_vip"]) . ")</td>";
                echo "<td>" . intval($reset["req_mlvl"]) . " (VIP: " . intval($reset["req_mlvl_vip"]) . ")</td>";
                echo "<td>" . intval($reset["bonus_stats"]) . " (VIP: " . intval($reset["bonus_stats_vip"]) . ")</td>";
                echo "<td>" . intval($reset["time"]) . " (VIP: " . intval($reset["time_vip"]) . ") min.</td>";
                echo "<td><a href=\"index.php?module=modules_manager&config=reset&edit=" . intval($reset["id"]) . "\"><button type=\"button\" class=\"btn btn-default btn-sm\"><i class=\"fa fa-edit\"></i> Edit</button></a> <a href=\"index.php?module=modules_manager&config=reset&delete=" . intval($reset["id"]) . "\" class=\"btn btn-danger btn-sm\" onclick=\"if(confirm('Do you really want to delete this reset stage?')) return true; else return false;\"><i class=\"fa fa-remove\"></i> Delete</a></td>";
                echo "</tr>";
                $i++;
            }
        }
    }
    echo "</table>";
    $customOpt = "";
    if (is_array($customItems)) {
        foreach ($customItems as $thisItem) {
            $customOpt .= "<option value=\"" . $thisItem["ident"] . "\">" . $thisItem["name"] . " (Web Bank)</option>";
        }
    }
    echo "\r\n    <hr><h3>Add New Reset Stage</h3>\r\n    <form action=\"\" method=\"post\">\r\n        <div id=\"reqitems_edit\"></div>\r\n        <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n            <tr>\r\n                <th>ID<br/><span>Must be unique and it's used to order priority of the reset stages.</span>\r\n                </th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"id\" value=\"\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Minimum Reset<br/><span>Select minimum reset required to use this stage.</span>\r\n                </th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"req_reset_min\" value=\"\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Maximum Reset<br/><span>Select maximum reset required to use this stage.</span>\r\n                </th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"req_reset_max\" value=\"\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Delay<br/><span>Delay time in minutes between resets.<br><b>Example:</b><br>0 = you can make next reset instantly<br>60 = you must wait at least 1 hour to make next reset</span>\r\n                </th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"time\" value=\"0\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Delay\r\n                    VIP<br/><span>Delay time in minutes between resets.<br><b>Example:</b><br>0 = you can make next reset instantly<br>60 = you must wait at least 1 hour to make next reset</span>\r\n                </th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"time_vip\" value=\"0\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Price Requirement<br/></th>\r\n                <td>\r\n                    ";
    enabledisableCheckboxes("price_req", 0, "Enabled", "Disabled");
    echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Price Type<br/><span></span>\r\n                </th>\r\n                <td>\r\n                    <select class=\"form-control\" name=\"price_type\">\r\n                        <option value=\"1\">Platinum Coins</option>\r\n                        <option value=\"2\">Gold Coins</option>\r\n                        <option value=\"3\">Silver Coins</option>\r\n                        <option value=\"4\">WCoinC</option>\r\n                        <option value=\"5\">Goblin Points</option>\r\n                        <option value=\"6\">Zen</option>\r\n                        <option value=\"7\">Jewel of Bless (Web Bank)</option>\r\n                        <option value=\"8\">Jewel of Soul (Web Bank)</option>\r\n                        <option value=\"9\">Jewel of Life (Web Bank)</option>\r\n                        <option value=\"10\">Jewel of Chaos (Web Bank)</option>\r\n                        <option value=\"11\">Jewel of Harmony (Web Bank)</option>\r\n                        <option value=\"12\">Jewel of Creation (Web Bank)</option>\r\n                        <option value=\"13\">Jewel of Guardian (Web Bank)</option>\r\n                        ";
    echo $customOpt;
    echo "                    </select>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Price Value<br/><span>If price requirement is enabled, set the price of this feature.</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"price\" value=\"\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Price Value VIP<br/><span>If price requirement is enabled, set the price of this feature.</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"price_vip\" value=\"\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Reset Price Formula<br/><span></span></th>\r\n                <td>\r\n                    ";
    enabledisableCheckboxes2("price_formula", 1, "Price * (Resets + 1)", "Fixed Price");
    echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Required Level<br/><span>Required level to reset.</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"req_lvl\" value=\"\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Required Level VIP<br/><span>Required level to reset.</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"req_lvl_vip\" value=\"\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Required Master Level<br/><span>Required master level to reset.</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"req_mlvl\" value=\"\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Required Master Level VIP<br/><span>Required master level to reset.</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"req_mlvl_vip\" value=\"\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Apply Equipment Check<br/></th>\r\n                <td>\r\n                    ";
    enabledisableCheckboxes("apply_equip_check", 1, "Enabled", "Disabled");
    echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Enable Items Requirement<br/></th>\r\n                <td>\r\n                    ";
    enabledisableCheckboxes("items_req", 0, "Enabled", "Disabled");
    echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Required Items<br/><span>All required items must be placed in character's inventory (normal, store, extended #1 or #2).</span></th>\r\n                <td>\r\n                    <div id=\"editItemAttributes\" class=\"alert alert-info\" style=\"display: none;\"><span class=\"error_icons info\"></span>\r\n                        <p>INFO: Please don't forget to edit item's attributes what have to be checked by clicking on \"Edit\" button near each item.</p></div>\r\n                    <div id=newItem></div>\r\n                    <script type=\"text/javascript\">\r\n                        var iid = 0;\r\n\r\n                        function addItem() {\r\n                            if (iid < 50) {\r\n                                var newItem = \$('#newItem');\r\n                                var reqitem_edit = \$('#newItem');\r\n                                var html = 'Item ' + (iid + 1) + ': <input type=\"text\" class=\"form-control\" style=\"display:inline; width:70%;\" maxlength=\"64\" size=\"80\" name=\"item' + iid + '\" value=\"";
    echo __ITEM_EMPTY__;
    echo "\" /> Count: <input type=\"text\" class=\"form-control\" style=\"display:inline; max-width:50px;\" maxlength=\"64\" size=\"4\" name=\"itemcount' + iid + '\" value=\"1\" /> <button type=\"button\" class=\"btn btn-default btn-sm\" data-toggle=\"modal\" data-target=\"#reqitems' + iid + '\"><i class=\"fa fa-edit\"></i> Edit</button><br>';\r\n                                var html2 = '<div id=\"reqitems' + iid + '\" class=\"modal fade\" role=\"dialog\">' +\r\n                                    '<div class=\"modal-dialog modal-lg\">' +\r\n                                    '<div class=\"modal-content\">' +\r\n                                    '<div class=\"modal-header\">' +\r\n                                    '<button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>' +\r\n                                    '<h4 class=\"modal-title\">Edit checked Attributes for Item #' + (iid + 1) + '</h4>' +\r\n                                    '</div>' +\r\n                                    '<div class=\"modal-body\">' +\r\n                                    '<div style=\"min-height: 900px;\">' +\r\n                                    '<div class=\"form-group\">' +\r\n                                    '<label class=\"col-sm-4 control-label\" for=\"id\">Check Item Level:</label>' +\r\n                                    '<div class=\"col-sm-8\">' +\r\n                                    '<select name=\"level' + iid + '\" id=\"level' + iid + '\" class=\"form-control\" aria-describedby=\"helpBlock\">' +\r\n                                    '<option value=\"1\">Yes</option>' +\r\n                                    '<option value=\"0\">No</option>' +\r\n                                    '</select>' +\r\n                                    '<span id=\"levelHelp\" class=\"help-block\">If yes, item level will have to be exactly the same, as required. If no, this attribute will not be checked.</span>' +\r\n                                    '</div>' +\r\n                                    '</div>' +\r\n                                    '<div class=\"form-group\">' +\r\n                                    '<label class=\"col-sm-4 control-label\" for=\"id\">Check Item Option:</label>' +\r\n                                    '<div class=\"col-sm-8\">' +\r\n                                    '<select name=\"option' + iid + '\" id=\"option' + iid + '\" class=\"form-control\" aria-describedby=\"helpBlock\">' +\r\n                                    '<option value=\"1\">Yes</option>' +\r\n                                    '<option value=\"0\">No</option>' +\r\n                                    '</select>' +\r\n                                    '<span id=\"optionHelp\" class=\"help-block\">If yes, item option will have to be exactly the same, as required. If no, this attribute will not be checked.</span>' +\r\n                                    '</div>' +\r\n                                    '</div>' +\r\n                                    '<div class=\"form-group\">' +\r\n                                    '<label class=\"col-sm-4 control-label\" for=\"id\">Check Item Durability:</label>' +\r\n                                    '<div class=\"col-sm-8\">' +\r\n                                    '<select name=\"durability' + iid + '\" id=\"durability' + iid + '\" class=\"form-control\" aria-describedby=\"helpBlock\">' +\r\n                                    '<option value=\"1\">Yes</option>' +\r\n                                    '<option value=\"0\">No</option>' +\r\n                                    '</select>' +\r\n                                    '<span id=\"durabilityHelp\" class=\"help-block\">If yes, item durability will have to be exactly the same, as required. If no, this attribute will not be checked.</span>' +\r\n                                    '</div>' +\r\n                                    '</div>' +\r\n                                    '<div class=\"form-group\">' +\r\n                                    '<label class=\"col-sm-4 control-label\" for=\"id\">Check Item Luck:</label>' +\r\n                                    '<div class=\"col-sm-8\">' +\r\n                                    '<select name=\"luck' + iid + '\" id=\"luck' + iid + '\" class=\"form-control\" aria-describedby=\"helpBlock\">' +\r\n                                    '<option value=\"1\">Yes</option>' +\r\n                                    '<option value=\"0\">No</option>' +\r\n                                    '</select>' +\r\n                                    '<span id=\"luckHelp\" class=\"help-block\">If yes, item luck will have to be exactly the same, as required. If no, this attribute will not be checked.</span>' +\r\n                                    '</div>' +\r\n                                    '</div>' +\r\n                                    '<div class=\"form-group\">' +\r\n                                    '<label class=\"col-sm-4 control-label\" for=\"id\">Check Item Skill:</label>' +\r\n                                    '<div class=\"col-sm-8\">' +\r\n                                    '<select name=\"skill' + iid + '\" id=\"skill' + iid + '\" class=\"form-control\" aria-describedby=\"helpBlock\">' +\r\n                                    '<option value=\"1\">Yes</option>' +\r\n                                    '<option value=\"0\">No</option>' +\r\n                                    '</select>' +\r\n                                    '<span id=\"skillHelp\" class=\"help-block\">If yes, item skill will have to be exactly the same, as required. If no, this attribute will not be checked.</span>' +\r\n                                    '</div>' +\r\n                                    '</div>' +\r\n                                    '<div class=\"form-group\">' +\r\n                                    '<label class=\"col-sm-4 control-label\" for=\"id\">Check Item Excellent Options:</label>' +\r\n                                    '<div class=\"col-sm-8\">' +\r\n                                    '<select name=\"excellent' + iid + '\" id=\"excellent' + iid + '\" class=\"form-control\" aria-describedby=\"helpBlock\">' +\r\n                                    '<option value=\"1\">Yes</option>' +\r\n                                    '<option value=\"0\">No</option>' +\r\n                                    '</select>' +\r\n                                    '<span id=\"excellentHelp\" class=\"help-block\">If yes, item excellent options will have to be exactly the same, as required. If no, this attribute will not be checked.</span>' +\r\n                                    '</div>' +\r\n                                    '</div>' +\r\n                                    '<div class=\"form-group\">' +\r\n                                    '<label class=\"col-sm-4 control-label\" for=\"id\">Check Item Ancient Option:</label>' +\r\n                                    '<div class=\"col-sm-8\">' +\r\n                                    '<select name=\"ancient' + iid + '\" id=\"ancient' + iid + '\" class=\"form-control\" aria-describedby=\"helpBlock\">' +\r\n                                    '<option value=\"1\">Yes</option>' +\r\n                                    '<option value=\"0\">No</option>' +\r\n                                    '</select>' +\r\n                                    '<span id=\"ancientHelp\" class=\"help-block\">If yes, item ancient option will have to be exactly the same, as required. If no, this attribute will not be checked.</span>' +\r\n                                    '</div>' +\r\n                                    '</div>' +\r\n                                    '<div class=\"form-group\">' +\r\n                                    '<label class=\"col-sm-4 control-label\" for=\"id\">Check Item Harmony Option:</label>' +\r\n                                    '<div class=\"col-sm-8\">' +\r\n                                    '<select name=\"harmony' + iid + '\" id=\"harmony' + iid + '\" class=\"form-control\" aria-describedby=\"helpBlock\">' +\r\n                                    '<option value=\"1\">Yes</option>' +\r\n                                    '<option value=\"0\">No</option>' +\r\n                                    '</select>' +\r\n                                    '<span id=\"harmonyHelp\" class=\"help-block\">If yes, item harmony option will have to be exactly the same, as required. If no, this attribute will not be checked.</span>' +\r\n                                    '</div>' +\r\n                                    '</div>' +\r\n                                    '<div class=\"form-group\">' +\r\n                                    '<label class=\"col-sm-4 control-label\" for=\"id\">Check Item Guardian Option:</label>' +\r\n                                    '<div class=\"col-sm-8\">' +\r\n                                    '<select name=\"guardian' + iid + '\" id=\"guardian' + iid + '\" class=\"form-control\" aria-describedby=\"helpBlock\">' +\r\n                                    '<option value=\"1\">Yes</option>' +\r\n                                    '<option value=\"0\">No</option>' +\r\n                                    '</select>' +\r\n                                    '<span id=\"guardianHelp\" class=\"help-block\">If yes, item guardian option will have to be exactly the same, as required. If no, this attribute will not be checked.</span>' +\r\n                                    '</div>' +\r\n                                    '</div>' +\r\n                                    '<div class=\"form-group\">' +\r\n                                    '<label class=\"col-sm-4 control-label\" for=\"id\">Check Item Socket Options:</label>' +\r\n                                    '<div class=\"col-sm-8\">' +\r\n                                    '<select name=\"socket' + iid + '\" id=\"socket' + iid + '\" class=\"form-control\" aria-describedby=\"helpBlock\">' +\r\n                                    '<option value=\"1\">Yes</option>' +\r\n                                    '<option value=\"0\">No</option>' +\r\n                                    '</select>' +\r\n                                    '<span id=\"socketHelp\" class=\"help-block\">If yes, item socket options will have to be exactly the same, as required. If no, this attribute will not be checked.<br>It also applies for SX excellent options.</span>' +\r\n                                    '</div>' +\r\n                                    '</div>' +\r\n                                    '</div>' +\r\n                                    '</div>' +\r\n                                    '<div class=\"modal-footer\">' +\r\n                                    '<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>' +\r\n                                    '</div>' +\r\n                                    '</div>' +\r\n                                    '</div>' +\r\n                                    '</div>';\r\n                                newItem.append(html);\r\n                                reqitem_edit.append(html2);\r\n                                iid = iid + 1;\r\n                            }\r\n                        }\r\n                    </script>\r\n                    <br>\r\n                    <input type=\"button\" value=\"Add New\" class=\"btn btn-primary\" onClick=\"\$('#editItemAttributes').css('display', 'block'); addItem();\">\r\n                    <input class=\"btn btn-primary\" type=\"button\" onClick=\"popitup('item_hex_generator.php')\" value=\"Item Code Generator\" title=\"Item Code Generator\">\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Reset Stats<br/><span></span></th>\r\n                <td>\r\n                    ";
    enabledisableCheckboxes("reset_stats", 1, "Yes", "No");
    echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Bonus Stats Type<br/><span></span></th>\r\n                <td>\r\n                    <div class=\"radio_switch\">\r\n                        <label class=\"opt1\"><input type=\"radio\" name=\"bonus_stats_type\" value=\"1\" onclick=\"toggleBonusStatsType('perClass');\"><span>Per Class</span></label>\r\n                        <label class=\"opt2\"><input type=\"radio\" name=\"bonus_stats_type\" value=\"0\" onclick=\"toggleBonusStatsType('fixed');\" checked><span>Fixed</span></label>\r\n                    </div>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Bonus Stats<br/><span></span></th>\r\n                <td>\r\n                    <table width=\"100%\" id=\"bonusStatsPerClass\" class=\"hidden\">\r\n                        ";
    $itemsPerLine = 3;
    $currentLine = 0;
    $counter = 0;
    if (122 <= config("server_files_season", true)) {
        $itemsPerLine = 4;
    }
    if (is_array($custom["character_class"])) {
        foreach ($custom["character_class"] as $classCode => $thisClass) {
            if ($counter == 0) {
                echo "<tr>";
            }
            echo "<td><b>" . $thisClass[0] . "</b> <input type=\"text\" name=\"bonus_stats_" . $classCode . "\" value=\"\" class=\"form-control\" placeholder=\"" . $thisClass[0] . "\" /></td>";
            if ($currentLine == 3 || $currentLine == 4 || $currentLine == 6 || $currentLine == 7) {
                if ($counter == $itemsPerLine - 2) {
                    echo "</tr>";
                    $counter = 0;
                    $currentLine++;
                }
            } else {
                if ($counter == $itemsPerLine - 1) {
                    echo "</tr>";
                    $counter = 0;
                    $currentLine++;
                }
            }
            $counter++;
        }
    }
    echo "                    </table>\r\n                    <input id=\"bonusStatsFixed\" class=\"form-control\" type=\"text\" name=\"bonus_stats\" value=\"\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Bonus Stats VIP<br/><span></span></th>\r\n                <td>\r\n                    <table width=\"100%\" id=\"bonusStatsPerClassVIP\" class=\"hidden\">\r\n                        ";
    $itemsPerLine = 3;
    $currentLine = 0;
    $counter = 0;
    if (122 <= config("server_files_season", true)) {
        $itemsPerLine = 4;
    }
    if (is_array($custom["character_class"])) {
        foreach ($custom["character_class"] as $classCode => $thisClass) {
            if ($counter == 0) {
                echo "<tr>";
            }
            echo "<td><b>" . $thisClass[0] . "</b> <input type=\"text\" name=\"bonus_stats_vip_" . $classCode . "\" value=\"\" class=\"form-control\" placeholder=\"" . $thisClass[0] . "\" /></td>";
            if ($currentLine == 3 || $currentLine == 4 || $currentLine == 6 || $currentLine == 7) {
                if ($counter == $itemsPerLine - 2) {
                    echo "</tr>";
                    $counter = 0;
                    $currentLine++;
                }
            } else {
                if ($counter == $itemsPerLine - 1) {
                    echo "</tr>";
                    $counter = 0;
                    $currentLine++;
                }
            }
            $counter++;
        }
    }
    echo "                    </table>\r\n                    <input id=\"bonusStatsFixedVIP\" class=\"form-control\" type=\"text\" name=\"bonus_stats_vip\" value=\"\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Bonus Stats Formula<br/><span></span></th>\r\n                <td>\r\n                    ";
    enabledisableCheckboxes2("bonus_stats_formula", 1, "Bonus * (Resets + 1)", "Fixed Bonus");
    echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Clear Master Level<br/><span>If \"Yes\", after reset will be master level set to 0, master level points will be deleted and skill tree will be cleared.</span></th>\r\n                <td>\r\n                    ";
    enabledisableCheckboxes("clear_ml", 0, "Yes", "No");
    echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Clear 3rd Skill Tree<br/><span>If \"Yes\", after reset 3rd skill tree will be cleared.</span></th>\r\n                <td>\r\n                    ";
    enabledisableCheckboxes("clear_ml_tree", 0, "Yes", "No");
    echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Clear 4th Skill Tree<br/><span>If \"Yes\", after reset 4th skill tree will be cleared.</span></th>\r\n                <td>\r\n                    ";
    enabledisableCheckboxes("clear_4th_tree", 0, "Yes", "No");
    echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Level after Reset<br/><span>Select level what will character get after reset.</span>\r\n                </th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"lvl_after_reset\" value=\"1\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Level after Reset VIP<br/><span>Select level what will character get after reset.</span>\r\n                </th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"lvl_after_reset_vip\" value=\"1\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>EXP after Reset<br/><span>Select amount of exp what will character get after reset.<br><i>You can find exact values for each level in IGC.EssentailTools.</i></span>\r\n                </th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"exp_after_reset\" value=\"0\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>EXP after Reset VIP<br/><span>Select amount of exp what will character get after reset.<br><i>You can find exact values for each level in IGC.EssentailTools.</i></span>\r\n                </th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"exp_after_reset_vip\" value=\"0\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Map after Reset<br/><span>Select map where will be moved character after reset.</span>\r\n                </th>\r\n                <td>\r\n                    <select class=\"form-control\" name=\"map_after_reset\">\r\n                        ";
    foreach ($custom["map_codes"] as $key => $thisMap) {
        echo "<option value=\"" . $key . "\">" . $thisMap . "</option>";
    }
    echo "                    </select>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Map Coordinates after Reset<br/><span>Select map coordinates where will be moved character after reset.</span>\r\n                </th>\r\n                <td>\r\n                    X: <input class=\"form-control\" type=\"text\" name=\"map_coord_x_after_reset\" value=\"0\" style=\"width: calc(100% - 20px); display: inline;\"/><br/>\r\n                    Y: <input class=\"form-control\" type=\"text\" name=\"map_coord_y_after_reset\" value=\"0\" style=\"width: calc(100% - 20px); display: inline;\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Credits Reward<br/><span>Enable/disable giving credit(s) reward for every reset.</span></th>\r\n                <td>\r\n                    ";
    enabledisableCheckboxes("is_cred_reward", 0, "Enabled", "Disabled");
    echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Reward<br/><span>If credits reward is enabled, set the amount of credits that will be rewarded for every reset.</span>\r\n                </th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"cred_reward\" value=\"0\" style=\"display: inline; width: 150px\"/> credit(s)\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Reward VIP<br/><span>If credits reward is enabled, set the amount of credits that will be rewarded for every reset.</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"cred_reward_vip\" value=\"0\" style=\"display: inline; width: 150px\"/> credit(s)\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Reward Type<br/><span></span></th>\r\n                <td>\r\n                    ";
    echo $creditSystem->buildSelectInput("credit_config", 2, "form-control");
    echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <td colspan=\"2\"><input type=\"submit\" name=\"add_stage\" value=\"Add Reset Stage\" class=\"btn btn-success\" style=\"width: 100%;\"/></td>\r\n            </tr>\r\n        </table>\r\n    </form>\r\n\r\n    ";
}
echo "\r\n<script type=\"text/javascript\">\r\n    function toggleBonusStatsType(type) {\r\n        if (type == \"perClass\") {\r\n            \$('#bonusStatsFixed').addClass('hidden');\r\n            \$('#bonusStatsPerClass').removeClass('hidden');\r\n            \$('#bonusStatsFixedVIP').addClass('hidden');\r\n            \$('#bonusStatsPerClassVIP').removeClass('hidden');\r\n        } else {\r\n            \$('#bonusStatsFixed').removeClass('hidden');\r\n            \$('#bonusStatsPerClass').addClass('hidden');\r\n            \$('#bonusStatsFixedVIP').removeClass('hidden');\r\n            \$('#bonusStatsPerClassVIP').addClass('hidden');\r\n        }\r\n    }\r\n</script>";
function saveChanges()
{
    
    foreach ($_POST as $setting) {
        if (!check_value($setting)) {
            message("error", "Missing data (complete all fields).");
            return NULL;
        }
    }
    $xmlPath = __PATH_MODULE_CONFIGS__ . "usercp.reset.xml";
    $xml = simplexml_load_file($xmlPath);
    $xml->active = $_POST["setting_1"];
    $xml->keep_gr_bonus = $_POST["setting_2"];
    $xml->check_equip_0 = $_POST["setting_3"];
    $xml->check_equip_1 = $_POST["setting_4"];
    $xml->check_equip_2 = $_POST["setting_5"];
    $xml->check_equip_3 = $_POST["setting_6"];
    $xml->check_equip_4 = $_POST["setting_7"];
    $xml->check_equip_5 = $_POST["setting_8"];
    $xml->check_equip_6 = $_POST["setting_9"];
    $xml->check_equip_7 = $_POST["setting_10"];
    $xml->check_equip_8 = $_POST["setting_11"];
    $xml->check_equip_9 = $_POST["setting_12"];
    $xml->check_equip_10 = $_POST["setting_13"];
    $xml->check_equip_11 = $_POST["setting_14"];
    $xml->check_equip_236 = $_POST["setting_15"];
    $xml->check_equip_237 = $_POST["check_equip_237"];
    $xml->check_equip_238 = $_POST["check_equip_238"];
    $xml->stage_price_separate = $_POST["stage_price_separate"];
    $save = $xml->asXML($xmlPath);
    if ($save) {
        message("success", "Settings successfully saved.");
    } else {
        message("error", "There has been an error while saving changes.");
    }
}
function arrayToXML($array)
{
    global $custom;
    $sxe = new SimpleXMLElement("<settings/>");
    if ($array["check_equip_0"] == NULL || $array["check_equip_0"] == "") {
        $array["check_equip_0"] = 0;
    }
    if ($array["check_equip_1"] == NULL || $array["check_equip_1"] == "") {
        $array["check_equip_1"] = 0;
    }
    if ($array["check_equip_2"] == NULL || $array["check_equip_2"] == "") {
        $array["check_equip_2"] = 0;
    }
    if ($array["check_equip_3"] == NULL || $array["check_equip_3"] == "") {
        $array["check_equip_3"] = 0;
    }
    if ($array["check_equip_4"] == NULL || $array["check_equip_4"] == "") {
        $array["check_equip_4"] = 0;
    }
    if ($array["check_equip_5"] == NULL || $array["check_equip_5"] == "") {
        $array["check_equip_5"] = 0;
    }
    if ($array["check_equip_6"] == NULL || $array["check_equip_6"] == "") {
        $array["check_equip_6"] = 0;
    }
    if ($array["check_equip_7"] == NULL || $array["check_equip_7"] == "") {
        $array["check_equip_7"] = 0;
    }
    if ($array["check_equip_8"] == NULL || $array["check_equip_8"] == "") {
        $array["check_equip_8"] = 0;
    }
    if ($array["check_equip_9"] == NULL || $array["check_equip_9"] == "") {
        $array["check_equip_9"] = 0;
    }
    if ($array["check_equip_10"] == NULL || $array["check_equip_10"] == "") {
        $array["check_equip_10"] = 0;
    }
    if ($array["check_equip_11"] == NULL || $array["check_equip_11"] == "") {
        $array["check_equip_11"] = 0;
    }
    if ($array["check_equip_236"] == NULL || $array["check_equip_236"] == "") {
        $array["check_equip_236"] = 0;
    }
    if ($array["check_equip_237"] == NULL || $array["check_equip_237"] == "") {
        $array["check_equip_237"] = 0;
    }
    if ($array["check_equip_238"] == NULL || $array["check_equip_238"] == "") {
        $array["check_equip_238"] = 0;
    }
    if ($array["stage_price_separate"] == NULL || $array["stage_price_separate"] == "") {
        $array["stage_price_separate"] = 0;
    }
    $sxe->addChild("active", $array["active"]);
    $sxe->addChild("keep_gr_bonus", $array["keep_gr_bonus"]);
    $sxe->addChild("check_equip_0", $array["check_equip_0"]);
    $sxe->addChild("check_equip_1", $array["check_equip_1"]);
    $sxe->addChild("check_equip_2", $array["check_equip_2"]);
    $sxe->addChild("check_equip_3", $array["check_equip_3"]);
    $sxe->addChild("check_equip_4", $array["check_equip_4"]);
    $sxe->addChild("check_equip_5", $array["check_equip_5"]);
    $sxe->addChild("check_equip_6", $array["check_equip_6"]);
    $sxe->addChild("check_equip_7", $array["check_equip_7"]);
    $sxe->addChild("check_equip_8", $array["check_equip_8"]);
    $sxe->addChild("check_equip_9", $array["check_equip_9"]);
    $sxe->addChild("check_equip_10", $array["check_equip_10"]);
    $sxe->addChild("check_equip_11", $array["check_equip_11"]);
    $sxe->addChild("check_equip_236", $array["check_equip_236"]);
    $sxe->addChild("check_equip_237", $array["check_equip_237"]);
    $sxe->addChild("check_equip_238", $array["check_equip_238"]);
    $sxe->addChild("stage_price_separate", $array["stage_price_separate"]);
    $resets = $sxe->addChild("resets");
    if (is_array($array["resets"])) {
        foreach ($array["resets"] as $thisReset) {
            $reset = $resets->addChild("reset");
            $reset->addAttribute("id", $thisReset["id"]);
            $reset->addAttribute("req_reset_min", $thisReset["req_reset_min"]);
            $reset->addAttribute("req_reset_max", $thisReset["req_reset_max"]);
            $reset->addAttribute("price_req", $thisReset["price_req"]);
            $reset->addAttribute("price_type", $thisReset["price_type"]);
            $reset->addAttribute("price", $thisReset["price"]);
            $reset->addAttribute("price_vip", $thisReset["price_vip"]);
            $reset->addAttribute("price_formula", $thisReset["price_formula"]);
            $reset->addAttribute("req_lvl", $thisReset["req_lvl"]);
            $reset->addAttribute("req_lvl_vip", $thisReset["req_lvl_vip"]);
            $reset->addAttribute("req_mlvl", $thisReset["req_mlvl"]);
            $reset->addAttribute("req_mlvl_vip", $thisReset["req_mlvl_vip"]);
            $reset->addAttribute("apply_equip_check", $thisReset["apply_equip_check"]);
            $reset->addAttribute("items_req", $thisReset["items_req"]);
            $reset->addAttribute("reset_stats", $thisReset["reset_stats"]);
            $reset->addAttribute("bonus_stats_type", $thisReset["bonus_stats_type"]);
            if ($thisReset["bonus_stats_type"] == "1") {
                foreach ($custom["character_class"] as $classCode => $thisClass) {
                    $reset->addAttribute("bonus_stats_" . $classCode, $thisReset["bonus_stats_" . $classCode]);
                    $reset->addAttribute("bonus_stats_vip_" . $classCode, $thisReset["bonus_stats_vip_" . $classCode]);
                }
            } else {
                $reset->addAttribute("bonus_stats", $thisReset["bonus_stats"]);
                $reset->addAttribute("bonus_stats_vip", $thisReset["bonus_stats_vip"]);
            }
            $reset->addAttribute("bonus_stats_formula", $thisReset["bonus_stats_formula"]);
            $reset->addAttribute("is_cred_reward", $thisReset["is_cred_reward"]);
            $reset->addAttribute("cred_reward", $thisReset["cred_reward"]);
            $reset->addAttribute("cred_reward_vip", $thisReset["cred_reward_vip"]);
            $reset->addAttribute("credit_config", $thisReset["credit_config"]);
            $reset->addAttribute("clear_ml", $thisReset["clear_ml"]);
            $reset->addAttribute("clear_ml_tree", $thisReset["clear_ml_tree"]);
            $reset->addAttribute("clear_4th_tree", $thisReset["clear_4th_tree"]);
            $reset->addAttribute("lvl_after_reset", $thisReset["lvl_after_reset"]);
            $reset->addAttribute("lvl_after_reset_vip", $thisReset["lvl_after_reset_vip"]);
            $reset->addAttribute("exp_after_reset", $thisReset["exp_after_reset"]);
            $reset->addAttribute("exp_after_reset_vip", $thisReset["exp_after_reset_vip"]);
            $reset->addAttribute("map_after_reset", $thisReset["map_after_reset"]);
            $reset->addAttribute("map_coord_x_after_reset", $thisReset["map_coord_x_after_reset"]);
            $reset->addAttribute("map_coord_y_after_reset", $thisReset["map_coord_y_after_reset"]);
            $reset->addAttribute("time", $thisReset["time"]);
            $reset->addAttribute("time_vip", $thisReset["time_vip"]);
            if (is_array($thisReset["req_items"])) {
                $items = $reset->addChild("req_items");
                foreach ($thisReset["req_items"] as $thisItem) {
                    $item = $items->addChild("item");
                    $item->addAttribute("count", $thisItem["count"]);
                    $item->addAttribute("hexcode", $thisItem["hexcode"]);
                    $item->addAttribute("level", $thisItem["level"]);
                    $item->addAttribute("option", $thisItem["option"]);
                    $item->addAttribute("durability", $thisItem["durability"]);
                    $item->addAttribute("luck", $thisItem["luck"]);
                    $item->addAttribute("skill", $thisItem["skill"]);
                    $item->addAttribute("excellent", $thisItem["excellent"]);
                    $item->addAttribute("ancient", $thisItem["ancient"]);
                    $item->addAttribute("harmony", $thisItem["harmony"]);
                    $item->addAttribute("guardian", $thisItem["guardian"]);
                    $item->addAttribute("socket", $thisItem["socket"]);
                }
            } else {
                $reset->addChild("req_items");
            }
        }
    }
    return $sxe->asXML();
}

?>