<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

define("__RESPONSIVE__", "TRUE");
$accountId = NULL;
$accountName = NULL;
$Market = new Market();
$Items = new Items();
$Webshop = new Webshop();
echo "<script type=\"text/javascript\" SRC=\"" . __PATH_TEMPLATE_ASSETS__ . "js/tooltip.js\"></script>";
if (isset($_GET["account"])) {
    $accountId = $_GET["account"];
    if (isset($_GET["char"])) {
        $characterName = $_GET["char"];
    }
    if ($config["SQL_USE_2_DB"]) {
        $account = $dB2->query_fetch_single("SELECT memb___id, memb_guid FROM MEMB_INFO WHERE memb_guid = ?", [$accountId]);
    } else {
        $account = $dB->query_fetch_single("SELECT memb___id, memb_guid FROM MEMB_INFO WHERE memb_guid = ?", [$accountId]);
    }
    $accountName = $account["memb___id"];
    if (isset($_GET["slot"])) {
        if (isset($_GET["type"]) && $_GET["type"] == "1") {
            $item = $Items->loadItemFromVault($accountName, $_GET["slot"]);
        } else {
            if (isset($_GET["type"]) && $_GET["type"] == "2") {
                $item = $Items->loadItemFromInventory($accountName, $characterName, $_GET["slot"]);
            }
        }
    } else {
        $token = time();
        $_SESSION["token"] = $token;
        $vaultData = $Market->getVaultData($accountName);
        $isExpanded = $Market->isExtendedVault($accountName);
    }
    $characters = $dB->query_fetch("SELECT Name FROM Character WHERE AccountId = ?", [$accountName]);
    $characterOpts = "";
    if (is_array($characters)) {
        foreach ($characters as $thisChar) {
            if ($characterName == $thisChar["Name"]) {
                $characterOpts .= "<option value=\"" . $thisChar["Name"] . "\" selected=\"selected\">" . $thisChar["Name"] . "</option>";
            } else {
                $characterOpts .= "<option value=\"" . $thisChar["Name"] . "\">" . $thisChar["Name"] . "</option>";
            }
        }
    }
}
if ($config["SQL_USE_2_DB"]) {
    $accounts = $dB2->query_fetch("SELECT memb___id, memb_guid FROM MEMB_INFO ORDER BY memb___id ASC");
} else {
    $accounts = $dB->query_fetch("SELECT memb___id, memb_guid FROM MEMB_INFO ORDER BY memb___id ASC");
}
$accountOpts = "";
if (is_array($accounts)) {
    foreach ($accounts as $thisAcc) {
        if ($accountId == $thisAcc["memb_guid"]) {
            $accountOpts .= "<option value=\"" . $thisAcc["memb_guid"] . "\" selected=\"selected\">" . $thisAcc["memb___id"] . "</option>";
        } else {
            $accountOpts .= "<option value=\"" . $thisAcc["memb_guid"] . "\">" . $thisAcc["memb___id"] . "</option>";
        }
    }
}
echo "\r\n<h2>Items Editor</h2>\r\n<div>\r\n    <form method=\"get\" action=\"\">\r\n        <input type=\"hidden\" name=\"module\" value=\"items_editor\" />\r\n        Select Account:\r\n        <select class=\"form-control\" name=\"account\" onchange=\"this.form.submit();\">\r\n            <option value=\"\">-- None --</option>\r\n            " . $accountOpts . "\r\n        </select>";
if ($accountId != NULL) {
    echo "\r\n        Select Character:\r\n        <select class=\"form-control\" name=\"char\" onchange=\"this.form.submit();\">\r\n            <option value=\"\">-- None --</option>\r\n            " . $characterOpts . "\r\n        </select>";
}
echo "\r\n    </form>\r\n</div>";
if (isset($_GET["slot"]) && isset($_GET["type"])) {
    $currItem = $Items->getItemFromDb($item["category"], $item["id"], $item["sticklevel"]);
    $itemData = $Items->loadItemFromItemList($currItem["type"], $currItem["id"]);
    $itemDetail = $Items->generateItemDetails($itemData);
    $excData = $Items->loadExcOptForItem($currItem["type"], $currItem["id"], $itemData["KindA"], $itemData["KindB"]);
    print_r_formatted($item);
    print_r_formatted($currItem);
    print_r_formatted($itemData);
    echo "\r\n<div class=\"row\">\r\n    <div class=\"col-xs-12 webshop-right webshop-options\">\r\n        <div class=\"col-xs-12 col-md-4 text-center item-detail\">\r\n            <div class=\"item-detail-title\">" . $currItem["name"] . "</div>\r\n            <div>\r\n                <img src=\"" . __PATH_TEMPLATE_ASSETS__ . "items/" . $currItem["type"] . "-" . $currItem["id"] . ".gif\" />\r\n            </div>\r\n            <div class=\"item-detail-details\">" . $itemDetail["itemDetails"] . "</div>\r\n            <div class=\"item-detail-class-req\">" . $itemDetail["classReq"] . "</div>\r\n        </div>\r\n        <div class=\"col-xs-12 col-md-8\">\r\n            <form class=\"form-horizontal webshop-options-form\" method=\"post\">\r\n                <div class=\"form-group\">";
    if (0 < $currItem["max_level"]) {
        $itemLvl = "";
        $tmpCounter = 0;
        while ($tmpCounter <= $currItem["max_level"]) {
            if ($item["level"] == $tmpCounter) {
                $itemLvl .= "<option value=\"" . $tmpCounter . "\" selected=\"selected\">+" . $tmpCounter . "</option>";
            } else {
                $itemLvl .= "<option value=\"" . $tmpCounter . "\">+" . $tmpCounter . "</option>";
            }
            $tmpCounter++;
        }
        echo "\r\n                    <div class=\"input-group webshop-options-group\">\r\n                        <div class=\"input-group-addon\">Level:</div>\r\n                        <select name=\"item-level\" class=\"form-control\">\r\n                            " . $itemLvl . "\r\n                        </select>\r\n                    </div>";
    }
    if (0 < $currItem["max_option"]) {
        $itemLife = "";
        $optRate = 4;
        if ($currItem["type"] == "6") {
            $optRate = 5;
        }
        $tmpCounter = 0;
        while ($tmpCounter <= $currItem["max_option"]) {
            if ($item["opt2"] == $tmpCounter) {
                $itemLife .= "<option value=\"" . $tmpCounter . "\" selected=\"selected\">+" . $tmpCounter * $optRate . "</option>";
            } else {
                $itemLife .= "<option value=\"" . $tmpCounter . "\">+" . $tmpCounter * $optRate . "</option>";
            }
            $tmpCounter++;
        }
        echo "\r\n                    <div class=\"input-group webshop-options-group\">\r\n                        <div class=\"input-group-addon\">Life:</div>\r\n                        <select name=\"item-life\" class=\"form-control\">\r\n                            " . $itemLife . "\r\n                        </select>\r\n                    </div>";
    }
    if ($currItem["luck"] == "1") {
        echo "\r\n                    <div class=\"input-group webshop-options-group\">\r\n                        <div class=\"input-group-addon webshop-label-checkbox\">Luck:</div>\r\n                        <input name=\"item-luck\" type=\"checkbox\"";
        if ($item["luck2"] == "1") {
            echo " checked=\"checked\"";
        }
        echo " />\r\n                    </div>";
    }
    if ($currItem["skill"] == "1") {
        echo "\r\n                    <div class=\"input-group webshop-options-group\">\r\n                        <div class=\"input-group-addon webshop-label-checkbox\">Skill:</div>\r\n                        <input name=\"item-skill\" type=\"checkbox\"";
        if ($item["skill2"] == "1") {
            echo " checked=\"checked\"";
        }
        echo " />\r\n                    </div>";
    }
    $ancData = $dB->query_fetch_single("SELECT TOP 1 * FROM [IMPERIAMUCMS_DATA_ANCIENT_ITEMS] WHERE [item_id] = ? AND [item_cat] = ? AND [active] = ?", [$currItem["id"], $currItem["type"], 1]);
    if (is_array($ancData)) {
        $ancTierCurrent = 0;
        if ($item["isanc"] == "5" || $item["isanc"] == "9") {
            $ancTierCurrent = 1;
        } else {
            if ($item["isanc"] == "6" || $item["isanc"] == "10") {
                $ancTierCurrent = 2;
            }
        }
        $ancSets = $dB->query_fetch("SELECT * FROM [IMPERIAMUCMS_DATA_ANCIENT_SETS] WHERE [ancient_id] IN (?, ?, ?, ?) AND [available] <= ?", [$ancData["tier1"], $ancData["tier2"], $ancData["tier3"], $ancData["tier4"], config("server_files_season", true)]);
        $ancSetOpts = "";
        foreach ($ancSets as $thisAnc) {
            $ancTier = 0;
            if ($thisAnc["ancient_id"] == $ancData["tier1"]) {
                $ancTier = 1;
            }
            if ($thisAnc["ancient_id"] == $ancData["tier2"]) {
                $ancTier = 2;
            }
            if ($thisAnc["ancient_id"] == $ancData["tier3"]) {
                $ancTier = 3;
            }
            if ($thisAnc["ancient_id"] == $ancData["tier4"]) {
                $ancTier = 4;
            }
            if ($ancTier == $ancTierCurrent) {
                $ancSetOpts .= "<option value=\"" . $thisAnc["ancient_id"] . ":" . $ancTier . "\" selected=\"\"selected>" . $thisAnc["ancient_name"] . "</option>";
            } else {
                $ancSetOpts .= "<option value=\"" . $thisAnc["ancient_id"] . ":" . $ancTier . "\">" . $thisAnc["ancient_name"] . "</option>";
            }
        }
        echo "\r\n        <hr><!-- ANCIENT OPTION -->\r\n        <div class=\"input-group webshop-options-group\">\r\n            <div class=\"input-group-addon\">Ancient Set:</div>\r\n            <select name=\"item-ancient\" class=\"form-control\">\r\n                <option value=\"\">-- None --</option>\r\n                " . $ancSetOpts . "\r\n            </select>\r\n        </div>\r\n        <div class=\"input-group webshop-options-group\">\r\n            <div class=\"input-group-addon\">Stamina:</div>\r\n            <select name=\"item-stamina\" class=\"form-control\">\r\n                <option value=\"\">-- None --</option>";
        if ($item["isanc"] == "5" || $item["isanc"] == "6") {
            echo "<option value=\"5\" selected=\"selected\">+5</option>";
        } else {
            echo "<option value=\"5\">+5</option>";
        }
        if ($item["isanc"] == "9" || $item["isanc"] == "10") {
            echo "<option value=\"10\" selected=\"selected\">+10</option>";
        } else {
            echo "<option value=\"10\">+10</option>";
        }
        echo "\r\n            </select>\r\n        </div>";
    }
    if (0 < $currItem["max_exc"] && $currItem["exc"] != "10" && $currItem["exc"] != "11" && $currItem["exc"] != "12" && ($currItem["use_sockets"] == "0" || config("server_files_season", true) < 100 && $currItem["use_sockets"] == "1")) {
        $excIndex = 0;
        foreach ($excData as $thisExc) {
            $excName = "";
            if ($thisExc["FormulaID"] != "-1" && "0" <= $thisExc["FormulaID"]) {
                $formulaData = $Items->loadExcOptFormula($thisExc["FormulaID"]);
                $optValue = $Items->calculateValueByFormula($thisExc["FormulaID"], $formulaData["Data"], $itemData["DropLevel"]);
            } else {
                $optValue = $thisExc["Value"];
            }
            if ($itemDetail["KindA"] == "1" || $itemDetail["KindA"] == "2" || $itemDetail["KindA"] == "3" || $itemDetail["KindA"] == "4" || $itemDetail["KindA"] == "14" || $itemDetail["KindA"] == "15" || $itemDetail["KindA"] == "18" || $itemDetail["KindA"] == "100") {
                if ($thisExc["ID"] != "1" && $thisExc["ID"] != "2" && $thisExc["ID"] != "6" && $thisExc["ID"] != "7" && $thisExc["ID"] != "18") {
                    $excName = sprintf(lang("exc_opt_item_" . $thisExc["ID"], true), $optValue);
                } else {
                    if ($currItem["item_cat"] == "5") {
                        $excOptStringTmp = lang("item_detail_txt_13", true);
                    } else {
                        $excOptStringTmp = lang("item_detail_txt_12", true);
                    }
                    if ($thisExc["ID"] == "1") {
                        $excName = sprintf(lang("exc_opt_item_" . $thisExc["ID"], true), $excOptStringTmp, $optValue);
                    } else {
                        if ($thisExc["ID"] == "2") {
                            $excName = sprintf(lang("exc_opt_item_" . $thisExc["ID"], true), $excOptStringTmp, $optValue);
                        } else {
                            if ($thisExc["ID"] == "6") {
                                $excName = sprintf(lang("exc_opt_item_" . $thisExc["ID"], true), $excOptStringTmp, $optValue);
                            } else {
                                if ($thisExc["ID"] == "7") {
                                    $excName = sprintf(lang("exc_opt_item_" . $thisExc["ID"], true), $excOptStringTmp, $optValue);
                                } else {
                                    if ($thisExc["ID"] == "18") {
                                        $excName = sprintf(lang("exc_opt_item_" . $thisExc["ID"], true), lang("item_detail_txt_17", true), $optValue);
                                    }
                                }
                            }
                        }
                    }
                }
            } else {
                if ($itemDetail["KindA"] == "6") {
                    $excName = sprintf(lang("exc_opt_wings_" . $thisExc["ID"], true), $optValue);
                }
            }
            echo "\r\n                    <div class=\"input-group webshop-options-group\">\r\n                        <div class=\"input-group-addon webshop-label-checkbox exc-opt\">" . $excName . "</div>\r\n                        <input name=\"item-exc-" . ($excIndex + 1) . "\" type=\"checkbox\" ";
            if ($item["is_exc_" . ($excIndex + 1) . ""] == "1") {
                echo "checked=\"checked\"";
            }
            echo "/>\r\n                    </div>";
            $excIndex++;
        }
    }
    if ($currItem["use_refinary"] == "1") {
        echo "\r\n            <hr><!-- 380 LVL OPTION -->\r\n            <div class=\"input-group webshop-options-group\">\r\n                <div class=\"input-group-addon webshop-label-checkbox\">380 Lvl Option</div>\r\n                <input name=\"item-380lvl\" type=\"checkbox\" ";
        if ($item["isjog"] == "1") {
            echo "checked=\"checked\"";
        }
        echo "/>\r\n            </div>";
    }
    if ($currItem["use_harmony"] == "1") {
        $harmonyType = 0;
        if (0 <= $currItem["item_cat"] && $currItem["item_cat"] <= 4) {
            $harmonyType = 1;
        }
        if ($currItem["item_cat"] == 5) {
            $harmonyType = 2;
        }
        if (7 <= $currItem["item_cat"] && $currItem["item_cat"] <= 11) {
            $harmonyType = 3;
        }
        $harmonyData = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_WEBSHOP_HARMONY WHERE itemtype = ? AND status = ? ORDER BY hoption ASC, hvalue ASC", [$harmonyType, 1]);
        $harmonyOptions = "";
        $harmonyArray = [];
        if (is_array($harmonyData)) {
            foreach ($harmonyData as $thisHarmony) {
                $disableHarm = "";
                $harmonyOptions .= "<option value=\"" . $thisHarmony["id"] . ":" . $thisHarmony["hoption"] . ":" . $thisHarmony["price"] . ":" . $thisHarmony["hvalue"] . "\"" . $disableHarm . ">" . $thisHarmony["hname"] . "</option>";
            }
        }
        echo "\r\n                    <hr id=\"harmony-line\"><!-- HARMONY OPTION -->\r\n                    <div class=\"input-group webshop-options-group\">\r\n                        <div class=\"input-group-addon\">" . lang("webshop_txt_68", true) . "</div>\r\n                        <select name=\"item-harmony\" class=\"form-control\">\r\n                            <option value=\"\">" . lang("webshop_59", true) . "</option>\r\n                            " . $harmonyOptions . "\r\n                        </select>\r\n                    </div>";
    }
    if ($currItem["use_sockets"] == "1") {
        $dbSockets = $Webshop->getSockets($currItem["type"]);
        $dbBonusSockets = $Webshop->getBonusSockets($currItem["type"]);
        $socketOptions = "<option value=\"\">" . lang("webshop_59", true) . "</option>";
        $bonusSocketOptions = "<option value=\"\">" . lang("webshop_59", true) . "</option>";
        foreach ($dbSockets as $s) {
            $sockets[$s["socket_id"]]["id"] = $s["id"];
            $sockets[$s["socket_id"]]["price"] = $s["price"];
            $sockets[$s["socket_id"]]["type"] = $s["seed"];
            if ($s["socket_id"] == "254" && $s["socket_elem"] == "0") {
                $socketOptions .= "<option value=\"" . $s["socket_id"] . ":" . $s["socket_type"] . ":" . $s["seed"] . ":" . $s["price"] . "\">" . lang($s["socket_name_lang"], true) . "</option>";
            } else {
                $socketOptions .= "<option value=\"" . $s["socket_id"] . ":" . $s["socket_type"] . ":" . $s["seed"] . ":" . $s["price"] . "\">" . sprintf(lang($s["socket_name_lang"], true), $s["socket_lvl"], $s["socket_value"]) . "</option>";
            }
        }
        foreach ($dbBonusSockets as $s) {
            $bonusSockets[$s["socket_id"]]["id"] = $s["id"];
            $bonusSockets[$s["socket_id"]]["price"] = $s["price"];
            $bonusSockets[$s["socket_id"]]["type"] = $s["seed"];
            if ($s["socket_lvl"] == "1") {
                $socketBonusLvl = "socket_bonus_lvl1";
            } else {
                $socketBonusLvl = "socket_bonus_lvl2";
            }
            $bonusSocketOptions .= "<option value=\"" . $s["socket_id"] . ":" . $s["price"] . ":" . $s["seed"] . "\">" . sprintf(lang($s["socket_name_lang"], true), lang($socketBonusLvl, true), $s["socket_value"]) . "</option>";
        }
        echo "\r\n                    <hr><!-- SOCKET OPTIONS -->\r\n                    <div class=\"input-group webshop-options-group\">\r\n                        <div class=\"input-group-addon\">" . lang("webshop_txt_69", true) . " #1:</div>\r\n                        <select id=\"item-socket-1\" name=\"item-socket-1\" class=\"form-control\">\r\n                            " . $socketOptions . "\r\n                        </select>\r\n                    </div>\r\n                    <div class=\"input-group webshop-options-group\">\r\n                        <div class=\"input-group-addon\">" . lang("webshop_txt_69", true) . " #2:</div>\r\n                        <select id=\"item-socket-2\" name=\"item-socket-2\" class=\"form-control\">\r\n                            " . $socketOptions . "\r\n                        </select>\r\n                    </div>\r\n                    <div class=\"input-group webshop-options-group\">\r\n                        <div class=\"input-group-addon\">" . lang("webshop_txt_69", true) . " #3:</div>\r\n                        <select id=\"item-socket-3\" name=\"item-socket-3\" class=\"form-control\">\r\n                            " . $socketOptions . "\r\n                        </select>\r\n                    </div>\r\n                    <div class=\"input-group webshop-options-group\">\r\n                        <div class=\"input-group-addon\">" . lang("webshop_txt_69", true) . " #4:</div>\r\n                        <select id=\"item-socket-4\" name=\"item-socket-4\" class=\"form-control\">\r\n                            " . $socketOptions . "\r\n                        </select>\r\n                    </div>\r\n                    <div class=\"input-group webshop-options-group\">\r\n                        <div class=\"input-group-addon\">" . lang("webshop_txt_69", true) . " #5:</div>\r\n                        <select id=\"item-socket-5\" name=\"item-socket-5\" class=\"form-control\">\r\n                            " . $socketOptions . "\r\n                        </select>\r\n                    </div>";
        $bonusSockets = $Webshop->getBonusSockets($currItem["item_cat"]);
        echo "\r\n                    <div class=\"input-group webshop-options-group\">\r\n                        <div class=\"input-group-addon\">" . lang("webshop_txt_94", true) . ":</div>\r\n                        <select name=\"item-socket-bonus\" class=\"form-control\">\r\n                            " . $bonusSocketOptions . "\r\n                        </select>\r\n                    </div>";
    }
    if ($itemData["KindA"] == "6" && $itemData["KindB"] == "76") {
        $gradeOptionsData = $Items->loadGradeOptForItem();
        $gradeOptions = "<option value=\"\">" . lang("webshop_59", true) . "</option>";
        foreach ($gradeOptionsData as $thisGrade) {
            $gradeCounter = 0;
            while ($gradeCounter <= 9) {
                if (0 < $thisGrade["Grade" . $gradeCounter . "Val"]) {
                    $gradeName = sprintf(lang("exc_opt_wings_4th_" . $thisGrade["Index"], true), $thisGrade["Grade" . $gradeCounter . "Val"]);
                    $gradeOptions .= "<option value=\"" . $thisGrade["Index"] . ":" . $gradeCounter . ":" . mconfig("price_exc_opt_wings_4th_" . $thisGrade["Index"]) . "\">" . $gradeName . "</option>";
                }
                $gradeCounter++;
            }
        }
        echo "\r\n            <div class=\"input-group webshop-options-group\">\r\n                <div class=\"input-group-addon\">" . sprintf(lang("webshop_62", true), 1) . "</div>\r\n                <select id=\"item-exc-1\" name=\"item-exc-1\" class=\"form-control\">\r\n                    " . $gradeOptions . "\r\n                </select>\r\n            </div>\r\n            <div class=\"input-group webshop-options-group\">\r\n                <div class=\"input-group-addon\">" . sprintf(lang("webshop_62", true), 2) . "</div>\r\n                <select id=\"item-exc-2\" name=\"item-exc-2\" class=\"form-control\">\r\n                    " . $gradeOptions . "\r\n                </select>\r\n            </div>\r\n            <div class=\"input-group webshop-options-group\">\r\n                <div class=\"input-group-addon\">" . sprintf(lang("webshop_62", true), 3) . "</div>\r\n                <select id=\"item-exc-3\" name=\"item-exc-3\" class=\"form-control\">\r\n                    " . $gradeOptions . "\r\n                </select>\r\n            </div>\r\n            <div class=\"input-group webshop-options-group\">\r\n                <div class=\"input-group-addon\">" . sprintf(lang("webshop_62", true), 4) . "</div>\r\n                <select id=\"item-exc-4\" name=\"item-exc-4\" class=\"form-control\">\r\n                    " . $gradeOptions . "\r\n                </select>\r\n            </div>";
        $pentagramAttrData = $Items->loadPentagramOptForWings();
        $mainPentagramOptions = "<option value=\"\">" . lang("webshop_59", true) . "</option>";
        foreach ($pentagramAttrData["main"] as $thisOpt) {
            $mainPentCounter = 0;
            while ($mainPentCounter <= 15) {
                if (0 < $thisOpt["Value" . $mainPentCounter]) {
                    $mainPentName = sprintf(lang("pentagram_main_opt_4th_wings_0", true), $thisOpt["Value" . $mainPentCounter]);
                    $mainPentagramOptions .= "<option value=\"0:" . $mainPentCounter . ":" . mconfig("price_pent_main_wings_4th") . "\">" . $mainPentName . "</option>";
                }
                $mainPentCounter++;
            }
        }
        $additionalPentagramOptions = "<option value=\"\">" . lang("webshop_59", true) . "</option>";
        foreach ($pentagramAttrData["add"] as $thisOpt) {
            $addPentCounter = 0;
            while ($addPentCounter <= 15) {
                if (0 < $thisOpt["Value" . $addPentCounter]) {
                    $addPentName = sprintf(lang("pentagram_add_opt_4th_wings_" . $thisOpt["Index"], true), $thisOpt["Value" . $addPentCounter]);
                    $additionalPentagramOptions .= "<option value=\"" . $thisOpt["Index"] . ":" . $addPentCounter . ":" . mconfig("price_pent_add_wings_4th_" . $thisOpt["Index"]) . "\">" . $addPentName . "</option>";
                }
                $addPentCounter++;
            }
        }
        echo "\r\n                    <div class=\"input-group webshop-options-group\">\r\n                        <div class=\"input-group-addon\">" . lang("webshop_63", true) . "</div>\r\n                        <select id=\"item-pentagram-main\" name=\"item-pentagram-main\" class=\"form-control\">\r\n                            " . $mainPentagramOptions . "\r\n                        </select>\r\n                    </div>\r\n                    <div class=\"input-group webshop-options-group\">\r\n                        <div class=\"input-group-addon\">" . lang("webshop_64", true) . "</div>\r\n                        <select id=\"item-pentagram-add\" name=\"item-pentagram-add\" class=\"form-control\">\r\n                            " . $additionalPentagramOptions . "\r\n                        </select>\r\n                    </div>";
    }
    if ($itemData["KindA"] == "19" && $itemData["KindB"] == "77" && $itemData["Slot"] == "238") {
        echo "\r\n                    <hr id=\"exc-line\"><!-- EXCELLENT OPTIONS -->\r\n                    <div class=\"input-group webshop-options-group\">\r\n                        <div class=\"input-group-addon webshop-label-checkbox exc-opt\">" . lang("exc_opt_earring_left_0", true) . "</div>\r\n                        <input name=\"item-exc-1\" type=\"checkbox\" />\r\n                    </div>\r\n                    <div class=\"input-group webshop-options-group\">\r\n                        <div class=\"input-group-addon webshop-label-checkbox exc-opt\">" . lang("exc_opt_earring_left_1", true) . "</div>\r\n                        <input name=\"item-exc-2\" type=\"checkbox\"  />\r\n                    </div>\r\n                    <div class=\"input-group webshop-options-group\">\r\n                        <div class=\"input-group-addon webshop-label-checkbox exc-opt\">" . lang("exc_opt_earring_left_2", true) . "</div>\r\n                        <input name=\"item-exc-3\" type=\"checkbox\" />\r\n                    </div>\r\n                    <div class=\"input-group webshop-options-group\">\r\n                        <div class=\"input-group-addon webshop-label-checkbox exc-opt\">" . lang("exc_opt_earring_left_3", true) . "</div>\r\n                        <input name=\"item-exc-4\" type=\"checkbox\" />\r\n                    </div>\r\n                    <div class=\"input-group webshop-options-group\">\r\n                        <div class=\"input-group-addon webshop-label-checkbox exc-opt\">" . lang("exc_opt_earring_left_4", true) . "</div>\r\n                        <input name=\"item-exc-5\" type=\"checkbox\" />\r\n                    </div>";
    }
    if ($itemData["KindA"] == "19" && $itemData["KindB"] == "77" && $itemData["Slot"] == "237") {
        echo "\r\n                    <hr id=\"exc-line\"><!-- EXCELLENT OPTIONS -->\r\n                    <div class=\"input-group webshop-options-group\">\r\n                        <div class=\"input-group-addon webshop-label-checkbox exc-opt\">" . lang("exc_opt_earring_right_0", true) . "</div>\r\n                        <input name=\"item-exc-1\" type=\"checkbox\" />\r\n                    </div>\r\n                    <div class=\"input-group webshop-options-group\">\r\n                        <div class=\"input-group-addon webshop-label-checkbox exc-opt\">" . lang("exc_opt_earring_right_1", true) . "</div>\r\n                        <input name=\"item-exc-2\" type=\"checkbox\"  />\r\n                    </div>\r\n                    <div class=\"input-group webshop-options-group\">\r\n                        <div class=\"input-group-addon webshop-label-checkbox exc-opt\">" . lang("exc_opt_earring_right_2", true) . "</div>\r\n                        <input name=\"item-exc-3\" type=\"checkbox\" />\r\n                    </div>\r\n                    <div class=\"input-group webshop-options-group\">\r\n                        <div class=\"input-group-addon webshop-label-checkbox exc-opt\">" . lang("exc_opt_earring_right_3", true) . "</div>\r\n                        <input name=\"item-exc-4\" type=\"checkbox\" />\r\n                    </div>\r\n                    <div class=\"input-group webshop-options-group\">\r\n                        <div class=\"input-group-addon webshop-label-checkbox exc-opt\">" . lang("exc_opt_earring_right_4", true) . "</div>\r\n                        <input name=\"item-exc-5\" type=\"checkbox\" />\r\n                    </div>";
    }
    echo "\r\n                </div>\r\n            </form>\r\n        </div>\r\n    </div>\r\n</div>";
} else {
    if ($accountId != NULL) {
        echo "\r\n<div class=\"row\">\r\n    <div class=\"col-xs-12 col-md-6\">\r\n        <h3>Vault :: " . $accountName . "</h3>";
        echo $Items->admincpItemEditorVault($vaultData, $isExpanded, $token);
        echo "\r\n    </div>\r\n    <div class=\"col-xs-12 col-md-6\">\r\n        <h3>Inventory :: " . $characterName . "</h3>";
        if ($characterName != NULL) {
            $Profile = new Profile($dB, $common);
            echo $Items->admincpItemEditorInventory($characterName);
        }
        echo "\r\n    </div>\r\n</div>";
    }
}

?>