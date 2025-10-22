<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

if (!isLoggedIn()) {
    redirect(1, "login");
} else {
    if (!canAccessModule($_SESSION["username"], "items", "block")) {
        return NULL;
    }
    $Webshop = new Webshop();
    $Market = new Market();
    $Items = new Items();
    echo "<script type=\"text/javascript\" SRC=\"" . __PATH_TEMPLATE__ . "js/tooltip.js\"></script>";
    echo "\r\n<div class=\"sub-page-title\">\r\n  <div id=\"title\"><h1>" . lang("module_titles_txt_3", true) . "<p></p><span></span></h1></div>\r\n</div>\r\n<div class=\"container_2 account store\" align=\"center\">\r\n  <div class=\"cont-image\">\r\n    <div class=\"container_3 account_sub_header\">\r\n      <div class=\"grad\">\r\n        <div class=\"page-title\">" . lang("itemsinv_txt_1", true) . "</div>\r\n        <a href=\"" . __BASE_URL__ . "webshop/shop\" style=\"background-image: none;padding: 9px 12px 10px 10px\">" . lang("itemsinv_txt_2", true) . "</a>\r\n        <a href=\"" . __BASE_URL__ . "usercp/market\" style=\"background-image: none;padding: 9px 12px 10px 10px\">" . lang("itemsinv_txt_3", true) . "</a>\r\n        <a href=\"" . __BASE_URL__ . "usercp\">" . lang("global_module_1", true) . "</a>\r\n      </div>\r\n    </div>\r\n    <div class=\"page-desc-holder\">\r\n      " . lang("itemsinv_txt_4", true) . "\r\n    </div>";
    if (isset($_GET["action"]) && isset($_GET["item"]) && $_GET["action"] == "withdraw") {
        $item_id = Decode($_GET["item"]);
        $Webshop->withdrawItem($_SESSION["username"], $item_id, "store");
    }
    echo "\r\n    <div class=\"account-wide\" align=\"center\">\r\n      <table width=\"100%\" class=\"irq\">\r\n        <thead>\r\n          <tr>\r\n            <th align=\"center\">#</th>\r\n            <th align=\"center\">" . lang("itemsinv_txt_5", true) . "</th>\r\n            <th align=\"center\">" . lang("itemsinv_txt_6", true) . "</th>\r\n            <th align=\"center\">" . lang("itemsinv_txt_7", true) . "</th>\r\n            <th align=\"center\">" . lang("itemsinv_txt_8", true) . "</th>\r\n            <th align=\"center\">" . lang("itemsinv_txt_9", true) . "</th>\r\n          </tr>\r\n        </thead>\r\n        <tbody>";
    $myItems = $Webshop->getItemsInventory($_SESSION["username"]);
    $i = 1;
    if (is_array($myItems)) {
        foreach ($myItems as $thisItem) {
            $itemInfo = $Items->ItemInfo($thisItem["item"]);
            switch ($thisItem["price_type"]) {
                case "-1":
                    $price = "<font color=\"#ffffff\">" . number_format($thisItem["price"]) . "</font> " . lang("exchange_txt_7", true);
                    break;
                case "0":
                    $price = "--";
                    break;
                case "1":
                    if ($thisItem["type"] == "1" || $thisItem["type"] == "2") {
                        $price = "<font color=\"#00ffa8\">" . number_format($thisItem["price"]) . "</font> " . lang("currency_wcoinc", true);
                    } else {
                        $price = "<font color=\"#00ffa8\">" . number_format($thisItem["price"]) . "</font> " . lang("currency_platinum", true);
                    }
                    break;
                case "2":
                    if ($thisItem["type"] == "1" || $thisItem["type"] == "2") {
                        $price = "<font color=\"#b38e47\">" . number_format($thisItem["price"]) . "</font> " . lang("currency_wcoinp", true);
                    } else {
                        $price = "<font color=\"#b38e47\">" . number_format($thisItem["price"]) . "</font> " . lang("currency_gold", true);
                    }
                    break;
                case "4":
                    if ($thisItem["type"] == "1" || $thisItem["type"] == "2") {
                        $price = "<font color=\"#959595\">" . number_format($thisItem["price"]) . "</font> " . lang("currency_gp", true);
                    } else {
                        $price = "<font color=\"#959595\">" . number_format($thisItem["price"]) . "</font> " . lang("currency_silver", true);
                    }
                    break;
                case "8":
                    $price = "<font color=\"#ffffff\">" . number_format($thisItem["price"]) . "</font> " . lang("currency_wcoinc", true);
                    break;
                case "9":
                    $price = "<font color=\"#ffffff\">" . number_format($thisItem["price"]) . "</font>" . lang("currency_gp", true);
                    break;
                case "10":
                    $price = "<font color=\"#ffffff\">" . number_format($thisItem["price"]) . "</font> " . lang("currency_zen", true) . "";
                    break;
                case "11":
                    $price = "<font color=\"#ffffff\">" . number_format($thisItem["price"]) . "</font> " . lang("currency_bless", true) . "";
                    break;
                case "12":
                    $price = "<font color=\"#ffffff\">" . number_format($thisItem["price"]) . "</font> " . lang("currency_soul", true) . "";
                    break;
                case "13":
                    $price = "<font color=\"#ffffff\">" . number_format($thisItem["price"]) . "</font> " . lang("currency_life", true) . "";
                    break;
                case "14":
                    $price = "<font color=\"#ffffff\">" . number_format($thisItem["price"]) . "</font> " . lang("currency_chaos", true) . "";
                    break;
                case "15":
                    $price = "<font color=\"#ffffff\">" . number_format($thisItem["price"]) . "</font> " . lang("currency_harmony", true) . "";
                    break;
                case "16":
                    $price = "<font color=\"#ffffff\">" . number_format($thisItem["price"]) . "</font> " . lang("currency_creation", true) . "";
                    break;
                case "17":
                    $price = "<font color=\"#ffffff\">" . number_format($thisItem["price"]) . "</font> " . lang("currency_guardian", true) . "";
                    break;
                default:
                    $query = $dB->query_fetch_single("SELECT name FROM IMPERIAMUCMS_WEB_BANK_CUSTOM WHERE ident = ?", [$thisItem["price_type"] - 4]);
                    $price = $query["name"];
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
                    if ($thisItem["type"] == "1") {
                        $type = lang("itemsinv_txt_10", true);
                    } else {
                        if ($thisItem["type"] == "2") {
                            $type = lang("itemsinv_txt_11", true) . " " . $thisItem["from"];
                        } else {
                            if ($thisItem["type"] == "3") {
                                $type = lang("itemsinv_txt_12", true);
                            } else {
                                if ($thisItem["type"] == "4") {
                                    $type = lang("itemsinv_txt_13", true);
                                } else {
                                    if ($thisItem["type"] == "5") {
                                        $type = lang("itemsinv_txt_14", true);
                                    } else {
                                        if ($thisItem["type"] == "6") {
                                            $type = lang("itemsinv_txt_17", true);
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $exl = str_replace("'", "\\'", $exl);
                    echo "\r\n            <tr class=\"" . $m_table_class . "\" style=\"cursor: pointer;\">\r\n              <td align=\"center\">" . $i . "</td>\r\n              <td align=\"left\" onmouseover=\"Tip('<center><img src=" . $itemInfo["thumb"] . "><br /><font color=yellow><br>" . lang("market_txt_100", true) . " " . $itemInfo["sn2"] . $itemInfo["sn"] . "</font><br><font color=white><br>" . lang("market_txt_101", true) . " " . $itemInfo["dur"] . "</font><br><font color=#FF99CC>" . $itemInfo["jog"] . "</font><font color=FFCC00>" . $itemInfo["harm"] . "</font><br>" . $option . " " . $luck . " " . $skill . " " . $exl . " <br>" . $ancsetopt . "<br><font color=#4d668d>" . $itemInfo["socket"] . "</font><br><br><span class=itemTooltipClassReq>" . $itemInfo["classReq"] . "</span></center>', TITLEFONTCOLOR, '" . $itemInfo["color"] . "',TITLE,'" . addslashes($itemInfo["name"]) . $itemInfo["level"] . "',TITLEBGCOLOR,'" . $itemInfo["anco"] . "')\" onmouseout=\"UnTip()\" <img src=\"" . $itemInfo["thumb"] . "\" class=\"m\">\r\n              <center><font style=\"color:" . $itemInfo["color"] . ";background-color:" . $itemInfo["anco"] . "\">" . $itemInfo["name"] . "</font></center></td>\r\n              <td align=\"center\">" . $price . "</td>\r\n              <td align=\"center\">" . date($config["time_date_format"], strtotime($thisItem["date"])) . "</td>\r\n              <td align=\"center\">" . $type . "</td>\r\n              <td><a href=\"" . __BASE_URL__ . "usercp/items/?action=withdraw&item=" . encode($thisItem["id"]) . "\">" . lang("itemsinv_txt_15", true) . "</a></td>\r\n            </tr>";
                    if ($m_table_class != "even") {
                        $m_table_class = "even";
                    } else {
                        $m_table_class = "";
                    }
                    $i++;
            }
        }
    } else {
        message("info", lang("itemsinv_txt_16", true));
    }
    echo "\r\n        </tbody>\r\n      </table>\r\n    </div>\r\n  </div>\r\n</div>\r\n";
}

?>