<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h2>Character Reset Settings</h2>\r\n\r\n<script>\r\n    function popitup(url) {\r\n        newwindow = window.open(url, 'name', 'height = 550, width = 600');\r\n        if (window.focus) {\r\n            newwindow.focus()\r\n        }\r\n        return false;\r\n    }\r\n</script>\r\n\r\n<style>\r\n    .hidden {\r\n        display: none;\r\n    }\r\n</style>\r\n";
echo "<script type=\"text/javascript\" SRC=\"" . __PATH_TEMPLATE__ . "js/tooltip.js\"></script>";
$Items = new Items();
$customItems = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_WEB_BANK_CUSTOM");
if (check_value($_GET["delete"])) {
    $xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "usercp.reset-types.xml");
    if ($xml !== false) {
        $array = [];
        $array["active"] = trim($xml->active);
        $array["max_reset_per_day"] = trim($xml->max_reset_per_day);
        $array["max_reset_per_weekend"] = trim($xml->max_reset_per_weekend);
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
                    $i++;
                }
            }
        }
        $tmp = arraytoxml($array);
        file_put_contents(__PATH_MODULE_CONFIGS__ . "usercp.reset-types.xml", $tmp);
        if ($found) {
            message("success", "Reset Stage #" . intval($_GET["delete"]) . " was successfully deleted.");
        }
    }
}
if (check_value($_POST["submit_changes"])) {
    savechanges();
}
if (check_value($_POST["add_stage"])) {
    if (check_value($_POST["id"]) && check_value($_POST["req_reset_min"]) && check_value($_POST["req_reset_max"])) {
        $xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "usercp.reset-types.xml");
        if ($xml !== false) {
            $array = [];
            $array["active"] = trim($xml->active);
            $array["max_reset_per_day"] = trim($xml->max_reset_per_day);
            $array["max_reset_per_weekend"] = trim($xml->max_reset_per_weekend);
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
                            }
                            $tmp = arraytoxml($array);
                            file_put_contents(__PATH_MODULE_CONFIGS__ . "usercp.reset-types.xml", $tmp);
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
        $xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "usercp.reset-types.xml");
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
                    }
                    $i++;
                }
            }
            $tmp = arraytoxml($array);
            file_put_contents(__PATH_MODULE_CONFIGS__ . "usercp.reset-types.xml", $tmp);
            message("success", "Reset Stage #" . intval($_POST["id"]) . " was successfully edited.");
        }
    } else {
        message("error", "Missing data (complete all fields).");
    }
}
$creditSystem = new CreditSystem($common, new Character(), $dB, $dB2);
if (check_value($_GET["edit"])) {
    if (is_numeric($_GET["edit"])) {
        $xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "usercp.reset-types.xml");
        if ($xml !== false) {
            $stageData = [];
            $i = 1;
            foreach ($xml->resets->children() as $tag => $reset) {
                if ($tag == "reset" && intval($reset["id"]) == $_GET["edit"]) {
                    $stageData["id"] = intval($reset["id"]);
                    $stageData["req_reset_min"] = intval($reset["req_reset_min"]);
                    $stageData["req_reset_max"] = intval($reset["req_reset_max"]);
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
        echo "\"/>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan=\"2\"><input type=\"submit\" name=\"save_stage\" value=\"Save Reset Stage\" class=\"btn btn-success\" style=\"width: 100%;\"/></td>\r\n                </tr>\r\n            </table>\r\n        </form>\r\n\r\n        ";
    }
} else {
    loadModuleConfigs("usercp.reset-types");
    echo "    <form action=\"\" method=\"post\">\r\n        <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n            <tr>\r\n                <th>Status<br/><span>Enable/disable the character reset module.</span></th>\r\n                <td>\r\n                    ";
    enabledisableCheckboxes("setting_1", mconfig("active"), "Enabled", "Disabled");
    echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Max. Resets per Day<br/><span></span></th>\r\n                <td>\r\n                    <input type=\"text\" name=\"max_reset_per_day\" class=\"form-control\" value=\"";
    echo mconfig("max_reset_per_day");
    echo "\" />\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Max. Resets per Weekend<br/><span></span></th>\r\n                <td>\r\n                    <input type=\"text\" name=\"max_reset_per_weekend\" class=\"form-control\" value=\"";
    echo mconfig("max_reset_per_weekend");
    echo "\" />\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Keep GR Bonus Stats after Reset<br/><span></span></th>\r\n                <td>\r\n                    ";
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
    $xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "usercp.reset-types.xml");
    echo "<table class=\"table table-striped table-bordered table-hover\"><tr><th>ID</th><th>Reset Range</th><th>Action</th>";
    if ($xml !== false) {
        $resets = [];
        $i = 1;
        foreach ($xml->resets->children() as $tag => $reset) {
            if ($tag == "reset") {
                $resets[$i]["id"] = intval($reset["id"]);
                $resets[$i]["req_reset_min"] = intval($reset["req_reset_min"]);
                $resets[$i]["req_reset_max"] = intval($reset["req_reset_max"]);
                echo "<tr>";
                echo "<td>" . intval($reset["id"]) . "</td>";
                echo "<td>" . intval($reset["req_reset_min"]) . " - " . intval($reset["req_reset_max"]) . "</td>";
                echo "<td><a href=\"index.php?module=modules_manager&config=reset-types&edit=" . intval($reset["id"]) . "\"><button type=\"button\" class=\"btn btn-default btn-sm\"><i class=\"fa fa-edit\"></i> Edit</button></a> <a href=\"index.php?module=modules_manager&config=reset-types&delete=" . intval($reset["id"]) . "\" class=\"btn btn-danger btn-sm\" onclick=\"if(confirm('Do you really want to delete this reset stage?')) return true; else return false;\"><i class=\"fa fa-remove\"></i> Delete</a></td>";
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
    echo "\r\n    <hr><h3>Add New Reset Stage</h3>\r\n    <form action=\"\" method=\"post\">\r\n        <div id=\"reqitems_edit\"></div>\r\n        <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n            <tr>\r\n                <th>ID<br/><span>Must be unique and it's used to order priority of the reset stages.</span>\r\n                </th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"id\" value=\"\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Minimum Reset<br/><span>Select minimum reset required to use this stage.</span>\r\n                </th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"req_reset_min\" value=\"\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Maximum Reset<br/><span>Select maximum reset required to use this stage.</span>\r\n                </th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"req_reset_max\" value=\"\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td colspan=\"2\"><input type=\"submit\" name=\"add_stage\" value=\"Add Reset Stage\" class=\"btn btn-success\" style=\"width: 100%;\"/></td>\r\n            </tr>\r\n        </table>\r\n    </form>\r\n\r\n    ";
}
function saveChanges()
{
    
    foreach ($_POST as $setting) {
        if (!check_value($setting)) {
            message("error", "Missing data (complete all fields).");
            return NULL;
        }
    }
    $xmlPath = __PATH_MODULE_CONFIGS__ . "usercp.reset-types.xml";
    $xml = simplexml_load_file($xmlPath);
    $xml->active = $_POST["setting_1"];
    $xml->max_reset_per_day = $_POST["max_reset_per_day"];
    $xml->max_reset_per_weekend = $_POST["max_reset_per_weekend"];
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
    $sxe->addChild("max_reset_per_day", $array["max_reset_per_day"]);
    $sxe->addChild("max_reset_per_weekend", $array["max_reset_per_weekend"]);
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
            $normalReset = $reset->addChild("normalReset");
            $gpReset = $reset->addChild("gpReset");
            $wcoinReset = $reset->addChild("wcoinReset");
        }
    }
    return $sxe->asXML();
}

?>