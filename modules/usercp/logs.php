<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

if (!isLoggedIn()) {
    redirect(1, "login");
} else {
    if (!canAccessModule($_SESSION["username"], "logs", "allow")) {
        return NULL;
    }
    $Webshop = new Webshop();
    $Market = new Market();
    $Items = new Items();
    if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
        echo "<script type=\"text/javascript\" SRC=\"" . __PATH_TEMPLATE_ASSETS__ . "js/tooltip.js\"></script>";
        $breadcrumb = generateBreadcrumb();
        echo "\r\n    <h3>\r\n        " . lang("accountlog_txt_1", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
        if (mconfig("active")) {
            echo "\r\n    <div class=\"row desc-row\">\r\n        <div class=\"col-xs-12\">\r\n            " . lang("accountlog_txt_2", true) . "\r\n        </div>\r\n    </div>\r\n    <div class=\"table-responsive rankings-table\">\r\n        <table class=\"table table-hover text-center\">\r\n            <tr>\r\n                <th class=\"headerRow\">" . lang("accountlog_txt_3", true) . "</th>\r\n                <th class=\"headerRow\">" . lang("accountlog_txt_4", true) . "</th>\r\n            </tr>";
            if (is_numeric(mconfig("days")) && 1 <= mconfig("days")) {
                $historyDays = mconfig("days");
            } else {
                $historyDays = 7;
            }
            $date_select = date("Y-m-d H:i:s", strtotime("-" . $historyDays . " days"));
            $myLogs = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_ACCOUNT_LOGS WHERE AccountID = ? AND date > ?  ORDER BY date desc", [$_SESSION["username"], $date_select]);
            if (is_array($myLogs)) {
                foreach ($myLogs as $thisLog) {
                    $item = strstr($thisLog["text"], "Item: ");
                    $text = strstr($thisLog["text"], "Item: ", true);
                    $text = $common->replaceHtmlSymbols($text);
                    if ($item == NULL) {
                        $text = $thisLog["text"];
                    } else {
                        $text .= "Item: ";
                        $item = substr_replace($item, "", 0, 6);
                        $item = substr_replace($item, "", __ITEM_LENGTH__, 1);
                        $itemInfo = $Items->ItemInfo($item, $_SESSION["username"], NULL, 1);
                        $showItem = "<span style=\"cursor: pointer;\" onmouseover=\"Tip(" . $Items->generateItemTooltip($itemInfo, 1, 1, 1, 1, 0, 0) . ")\" onmouseout=\"UnTip()\"><b>" . $itemInfo["name"] . "</b></span>";
                        $text .= $showItem . "]";
                    }
                    echo "\r\n            <tr>\r\n                <td>" . date($config["time_date_format"], strtotime($thisLog["date"])) . "</td>\r\n                <td>" . $text . "</td>\r\n            </tr>";
                }
            } else {
                message("info", lang("accountlog_txt_5", true));
            }
            echo "\r\n        </table>\r\n    </div>";
        } else {
            message("error", lang("error_47", true));
        }
    } else {
        echo "<script type=\"text/javascript\" SRC=\"" . __PATH_TEMPLATE__ . "js/tooltip.js\"></script>";
        echo "\r\n<div class=\"sub-page-title\">\r\n  <div id=\"title\"><h1>" . lang("module_titles_txt_3", true) . "<p></p><span></span></h1></div>\r\n</div>\r\n<div class=\"container_2 account store\" align=\"center\">\r\n  <div class=\"cont-image\">\r\n    <div class=\"container_3 account_sub_header\">\r\n      <div class=\"grad\">\r\n        <div class=\"page-title\">" . lang("accountlog_txt_1", true) . "</div>\r\n        <a href=\"" . __BASE_URL__ . "usercp\">" . lang("global_module_1", true) . "</a>\r\n      </div>\r\n    </div>\r\n    <div class=\"page-desc-holder\">\r\n      " . lang("accountlog_txt_2", true) . "\r\n    </div>";
        if (mconfig("active")) {
            echo "\r\n    <div class=\"account-wide\" align=\"center\">\r\n      <table width=\"100%\" class=\"irq\">\r\n        <thead>\r\n          <tr>\r\n            <th align=\"center\" width=\"120px\">" . lang("accountlog_txt_3", true) . "</th>\r\n            <th align=\"center\">" . lang("accountlog_txt_4", true) . "</th>\r\n          </tr>\r\n        </thead>\r\n        <tbody>";
            if (is_numeric(mconfig("days")) && 1 <= mconfig("days")) {
                $historyDays = mconfig("days");
            } else {
                $historyDays = 7;
            }
            $date_select = date("Y-m-d H:i:s", strtotime("-" . $historyDays . " days"));
            $myLogs = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_ACCOUNT_LOGS WHERE AccountID = ? AND date > ?  ORDER BY date desc", [$_SESSION["username"], $date_select]);
            if (is_array($myLogs)) {
                foreach ($myLogs as $thisLog) {
                    $item = strstr($thisLog["text"], "Item: ");
                    $text = strstr($thisLog["text"], "Item: ", true);
                    $text = $common->replaceHtmlSymbols($text);
                    if ($item == NULL) {
                        $text = $thisLog["text"];
                    } else {
                        $text .= "Item: ";
                        $item = substr_replace($item, "", 0, 6);
                        $item = substr_replace($item, "", __ITEM_LENGTH__, 1);
                        $itemInfo = $Items->ItemInfo($item);
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
                        $showItem = "<span style=\"cursor: pointer;\" onmouseover=\"Tip('<center><img src=" . $itemInfo["thumb"] . "><br /><font color=yellow><br>Serial: " . $itemInfo["sn2"] . $itemInfo["sn"] . "</font><br><font color=white><br>Durability: " . $itemInfo["dur"] . "</font><br><font color=#FF99CC>" . $itemInfo["jog"] . "</font><font color=FFCC00>" . $itemInfo["harm"] . "</font><br>" . $option . " " . $luck . " " . $skill . " " . $exl . " <br>" . $ancsetopt . "<br><font color=#4d668d>" . $itemInfo["socket"] . "</font><br><br><span class=itemTooltipClassReq>" . $itemInfo["classReq"] . "</span></center>', TITLEFONTCOLOR, '" . $itemInfo["color"] . "',TITLE,'" . addslashes($itemInfo["name"]) . $itemInfo["level"] . "',TITLEBGCOLOR,'" . $itemInfo["anco"] . "')\" onmouseout=\"UnTip()\"><b>" . $itemInfo["name"] . "</b></span>";
                        $text .= $showItem . "]";
                    }
                    echo "\r\n            <tr>\r\n              <td>" . date($config["time_date_format"], strtotime($thisLog["date"])) . "</td>\r\n              <td>" . $text . "</td>\r\n            </tr>";
                }
            } else {
                message("info", lang("accountlog_txt_5", true));
            }
            echo "\r\n        </tbody>\r\n      </table>\r\n    </div>";
        } else {
            message("error", lang("error_47", true));
        }
        echo "\r\n  </div>\r\n</div>";
    }
}

?>