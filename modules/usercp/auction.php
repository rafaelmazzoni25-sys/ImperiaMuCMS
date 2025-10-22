<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

if (!isLoggedIn()) {
    redirect(1, "login");
} else {
    if (!isset($_GET["pg"])) {
        $_GET["pg"] = 1;
    }
    if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
        $breadcrumb = generateBreadcrumb();
        if (check_value($_GET["page"]) && $_GET["page"] == "ended") {
            echo "\r\n    <h3>\r\n        " . lang("auction_txt_1", true) . "\r\n        <a href=\"" . __BASE_URL__ . "usercp/auction/\" class=\"btn btn-warning btn-navtop\">" . lang("auction_txt_2", true) . "</a>\r\n        " . $breadcrumb . "\r\n    </h3>";
        } else {
            echo "\r\n    <h3>\r\n        " . lang("myaccount_txt_79", true) . "\r\n        <a href=\"" . __BASE_URL__ . "usercp/auction/page/ended/\" class=\"btn btn-warning btn-navtop\">" . lang("auction_txt_1", true) . "</a>\r\n        " . $breadcrumb . "\r\n    </h3>";
        }
        if (mconfig("active")) {
            echo "\r\n        <div class=\"row desc-row\">\r\n            <div class=\"col-xs-12\">" . lang("auction_txt_3", true) . "</div>\r\n        </div>";
            if (canAccessModule($_SESSION["username"], "auction", "block")) {
                $General = new xGeneral();
                $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("auction");
                $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("auction");
                $Auction = new Auction();
                $Market = new Market();
                $Items = new Items();
                echo "<script type=\"text/javascript\" SRC=\"" . __PATH_TEMPLATE_ASSETS__ . "js/tooltip.js\"></script>";
                if (check_value($_GET["page"]) && $_GET["page"] == "ended") {
                    $auctions = $Auction->getEndedAuctions();
                    if (is_array($auctions)) {
                        foreach ($auctions as $thisAuction) {
                            $currentBid = $Auction->getCurrentBid($thisAuction["id"]);
                            $totalBids = $Auction->getTotalBids($thisAuction["id"]);
                            $currency = $Auction->getCurrencyName($thisAuction["currency"]);
                            $highestBidData = $Auction->getHighestBidData($thisAuction["id"]);
                            $items = $Auction->getItems($thisAuction["id"]);
                            echo "\r\n            <div class=\"col-xs-12 auction\">\r\n                <table>\r\n                    <tbody>\r\n                        <tr>\r\n                            <td colspan=\"2\" class=\"auction-text\">\r\n                                <div class=\"auction-title\">" . $thisAuction["name"] . "</div>\r\n                            </td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td colspan=\"2\" align=\"center\">";
                            foreach ($items as $thisItem) {
                                $itemInfo = $Items->ItemInfo($thisItem["item"]);
                                echo "\r\n                                <div class=\"auction-item-frame\" style=\"cursor: pointer;\" onmouseover=\"Tip(" . $Items->generateItemTooltip($itemInfo, 1, 0, 1, 1, 0, 0) . ")\" onmouseout=\"UnTip()\">";
                                echo "\r\n                                   <span class=\"auction-img\"></span><img src=\"" . $itemInfo["thumb"] . "\">\r\n                                </div> ";
                            }
                            echo "\r\n                            </td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td colspan=\"2\">\r\n                                <div class=\"auction-rate-line\">\r\n                                    <div class=\"auction-rate-line-stage\" style=\"width: 100%\"></div>\r\n                                    <div class=\"auction-rate-text\">" . lang("auction_txt_11", true) . "</div>\r\n                                </div>\r\n                            </td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td>\r\n                                <table>\r\n                                    <tr>\r\n                                        <td width=\"120px\">" . lang("auction_txt_12", true) . ":</td>\r\n                                        <td><b>" . number_format($currentBid) . " " . $currency . "</b> (" . sprintf(lang("auction_txt_6", true), $totalBids) . ")</td>\r\n                                    </tr>\r\n                                    <tr>\r\n                                        <td>" . lang("auction_txt_13", true) . ":</td>\r\n                                        <td><b>" . date($config["time_date_format_logs"], strtotime($thisAuction["end_date"])) . "</b></td>\r\n                                    </tr>\r\n                                </table>\r\n                            </td>\r\n                        </tr>\r\n                    </tbody>\r\n                </table>";
                            if ($highestBidData["AccountID"] == $_SESSION["username"]) {
                                echo "<div class=\"auction-status-box\"><span class=\"auction-higest-bid\">";
                                echo lang("auction_txt_31", true);
                                echo "</span></div>";
                            } else {
                                if ($Auction->madeBid($_SESSION["username"], $thisAuction["id"])) {
                                    echo "<div class=\"auction-status-box\"><span class=\"auction-outbid\">";
                                    echo lang("auction_txt_20", true);
                                    echo "</span></div>";
                                }
                            }
                            echo "\r\n            </div>";
                        }
                    } else {
                        message("notice", lang("auction_txt_24", true));
                    }
                } else {
                    if (check_value($_POST["submit"])) {
                        $Auction->placeBid($_SESSION["username"], $_POST["amount"], Decode($_POST["id"]));
                    }
                    echo "                <script type=\"text/javascript\">\r\n                    /*function auction_ajax_bid_checker() {\r\n                        //console.log('bid checker');\r\n                        \$.getJSON('";
                    echo __BASE_URL__;
                    echo "ajax/auction_check_bid.php?pg=";
                    echo $_GET["pg"];
                    echo "&limit=";
                    echo mconfig("page_limit");
                    echo "', function (data) {\r\n                            if (data.status) {\r\n                                console.log(\"AUCTION AJAX auctions: \");\r\n                                console.log(data);\r\n                                //TODO:\r\n\r\n                                if (data.refresh) {\r\n                                    console.log('AUCTION AJAX refresh');\r\n                                    //location.reload();\r\n                                }\r\n                            } else {\r\n                                console.log(\"AUCTION AJAX ERROR: \" + data.error);\r\n                            }\r\n                        });\r\n                    }\r\n\r\n                    function auction_bid_checker_init() {\r\n                        setTimeout(function () {\r\n                            auction_ajax_bid_checker();\r\n                            auction_bid_checker_init();\r\n                        }, 30000);\r\n                    }\r\n\r\n                    auction_bid_checker_init();*/\r\n                </script>\r\n                ";
                    $auctions = $Auction->getActiveAuctions($_GET["pg"], mconfig("page_limit"));
                    if (is_array($auctions)) {
                        echo "                    <script type=\"text/javascript\">\r\n                        var auction_end = [];\r\n                        var total_sec = [];\r\n\r\n                        function sprintf () {\r\n                          //  discuss at: https://locutus.io/php/sprintf/\r\n                          // original by: Ash Searle (https://hexmen.com/blog/)\r\n                          // improved by: Michael White (https://getsprink.com)\r\n                          // improved by: Jack\r\n                          // improved by: Kevin van Zonneveld (https://kvz.io)\r\n                          // improved by: Kevin van Zonneveld (https://kvz.io)\r\n                          // improved by: Kevin van Zonneveld (https://kvz.io)\r\n                          // improved by: Dj\r\n                          // improved by: Allidylls\r\n                          //    input by: Paulo Freitas\r\n                          //    input by: Brett Zamir (https://brett-zamir.me)\r\n                          // improved by: Rafał Kukawski (https://kukawski.pl)\r\n                          //   example 1: sprintf(\"%01.2f\", 123.1)\r\n                          //   returns 1: '123.10'\r\n                          //   example 2: sprintf(\"[%10s]\", 'monkey')\r\n                          //   returns 2: '[    monkey]'\r\n                          //   example 3: sprintf(\"[%'#10s]\", 'monkey')\r\n                          //   returns 3: '[####monkey]'\r\n                          //   example 4: sprintf(\"%d\", 123456789012345)\r\n                          //   returns 4: '123456789012345'\r\n                          //   example 5: sprintf('%-03s', 'E')\r\n                          //   returns 5: 'E00'\r\n                          //   example 6: sprintf('%+010d', 9)\r\n                          //   returns 6: '+000000009'\r\n                          //   example 7: sprintf('%+0\\'@10d', 9)\r\n                          //   returns 7: '@@@@@@@@+9'\r\n                          //   example 8: sprintf('%.f', 3.14)\r\n                          //   returns 8: '3.140000'\r\n                          //   example 9: sprintf('%% %2\$d', 1, 2)\r\n                          //   returns 9: '% 2'\r\n\r\n                          var regex = /%%|%(?:(\\d+)\\\$)?((?:[-+#0 ]|'[\\s\\S])*)(\\d+)?(?:\\.(\\d*))?([\\s\\S])/g\r\n                          var args = arguments\r\n                          var i = 0\r\n                          var format = args[i++]\r\n\r\n                          var _pad = function (str, len, chr, leftJustify) {\r\n                            if (!chr) {\r\n                              chr = ' '\r\n                            }\r\n                            var padding = (str.length >= len) ? '' : new Array(1 + len - str.length >>> 0).join(chr)\r\n                            return leftJustify ? str + padding : padding + str\r\n                          }\r\n\r\n                          var justify = function (value, prefix, leftJustify, minWidth, padChar) {\r\n                            var diff = minWidth - value.length\r\n                            if (diff > 0) {\r\n                              // when padding with zeros\r\n                              // on the left side\r\n                              // keep sign (+ or -) in front\r\n                              if (!leftJustify && padChar === '0') {\r\n                                value = [\r\n                                  value.slice(0, prefix.length),\r\n                                  _pad('', diff, '0', true),\r\n                                  value.slice(prefix.length)\r\n                                ].join('')\r\n                              } else {\r\n                                value = _pad(value, minWidth, padChar, leftJustify)\r\n                              }\r\n                            }\r\n                            return value\r\n                          }\r\n\r\n                          var _formatBaseX = function (value, base, leftJustify, minWidth, precision, padChar) {\r\n                            // Note: casts negative numbers to positive ones\r\n                            var number = value >>> 0\r\n                            value = _pad(number.toString(base), precision || 0, '0', false)\r\n                            return justify(value, '', leftJustify, minWidth, padChar)\r\n                          }\r\n\r\n                          // _formatString()\r\n                          var _formatString = function (value, leftJustify, minWidth, precision, customPadChar) {\r\n                            if (precision !== null && precision !== undefined) {\r\n                              value = value.slice(0, precision)\r\n                            }\r\n                            return justify(value, '', leftJustify, minWidth, customPadChar)\r\n                          }\r\n\r\n                          // doFormat()\r\n                          var doFormat = function (substring, argIndex, modifiers, minWidth, precision, specifier) {\r\n                            var number, prefix, method, textTransform, value\r\n\r\n                            if (substring === '%%') {\r\n                              return '%'\r\n                            }\r\n\r\n                            // parse modifiers\r\n                            var padChar = ' ' // pad with spaces by default\r\n                            var leftJustify = false\r\n                            var positiveNumberPrefix = ''\r\n                            var j, l\r\n\r\n                            for (j = 0, l = modifiers.length; j < l; j++) {\r\n                              switch (modifiers.charAt(j)) {\r\n                                case ' ':\r\n                                case '0':\r\n                                  padChar = modifiers.charAt(j)\r\n                                  break\r\n                                case '+':\r\n                                  positiveNumberPrefix = '+'\r\n                                  break\r\n                                case '-':\r\n                                  leftJustify = true\r\n                                  break\r\n                                case \"'\":\r\n                                  if (j + 1 < l) {\r\n                                    padChar = modifiers.charAt(j + 1)\r\n                                    j++\r\n                                  }\r\n                                  break\r\n                              }\r\n                            }\r\n\r\n                            if (!minWidth) {\r\n                              minWidth = 0\r\n                            } else {\r\n                              minWidth = +minWidth\r\n                            }\r\n\r\n                            if (!isFinite(minWidth)) {\r\n                              throw new Error('Width must be finite')\r\n                            }\r\n\r\n                            if (!precision) {\r\n                              precision = (specifier === 'd') ? 0 : 'fFeE'.indexOf(specifier) > -1 ? 6 : undefined\r\n                            } else {\r\n                              precision = +precision\r\n                            }\r\n\r\n                            if (argIndex && +argIndex === 0) {\r\n                              throw new Error('Argument number must be greater than zero')\r\n                            }\r\n\r\n                            if (argIndex && +argIndex >= args.length) {\r\n                              throw new Error('Too few arguments')\r\n                            }\r\n\r\n                            value = argIndex ? args[+argIndex] : args[i++]\r\n\r\n                            switch (specifier) {\r\n                              case '%':\r\n                                return '%'\r\n                              case 's':\r\n                                return _formatString(value + '', leftJustify, minWidth, precision, padChar)\r\n                              case 'c':\r\n                                return _formatString(String.fromCharCode(+value), leftJustify, minWidth, precision, padChar)\r\n                              case 'b':\r\n                                return _formatBaseX(value, 2, leftJustify, minWidth, precision, padChar)\r\n                              case 'o':\r\n                                return _formatBaseX(value, 8, leftJustify, minWidth, precision, padChar)\r\n                              case 'x':\r\n                                return _formatBaseX(value, 16, leftJustify, minWidth, precision, padChar)\r\n                              case 'X':\r\n                                return _formatBaseX(value, 16, leftJustify, minWidth, precision, padChar)\r\n                                  .toUpperCase()\r\n                              case 'u':\r\n                                return _formatBaseX(value, 10, leftJustify, minWidth, precision, padChar)\r\n                              case 'i':\r\n                              case 'd':\r\n                                number = +value || 0\r\n                                // Plain Math.round doesn't just truncate\r\n                                number = Math.round(number - number % 1)\r\n                                prefix = number < 0 ? '-' : positiveNumberPrefix\r\n                                value = prefix + _pad(String(Math.abs(number)), precision, '0', false)\r\n\r\n                                if (leftJustify && padChar === '0') {\r\n                                  // can't right-pad 0s on integers\r\n                                  padChar = ' '\r\n                                }\r\n                                return justify(value, prefix, leftJustify, minWidth, padChar)\r\n                              case 'e':\r\n                              case 'E':\r\n                              case 'f': // @todo: Should handle locales (as per setlocale)\r\n                              case 'F':\r\n                              case 'g':\r\n                              case 'G':\r\n                                number = +value\r\n                                prefix = number < 0 ? '-' : positiveNumberPrefix\r\n                                method = ['toExponential', 'toFixed', 'toPrecision']['efg'.indexOf(specifier.toLowerCase())]\r\n                                textTransform = ['toString', 'toUpperCase']['eEfFgG'.indexOf(specifier) % 2]\r\n                                value = prefix + Math.abs(number)[method](precision)\r\n                                return justify(value, prefix, leftJustify, minWidth, padChar)[textTransform]()\r\n                              default:\r\n                                // unknown specifier, consume that char and return empty\r\n                                return ''\r\n                            }\r\n                          }\r\n\r\n                          try {\r\n                            return format.replace(regex, doFormat)\r\n                          } catch (err) {\r\n                            return false\r\n                          }\r\n                        }\r\n\r\n                        function auction_countdown(id, t) {\r\n                            //console.log(t);\r\n                            var h = 0, m = 0, s = 0;\r\n\r\n                            if (t > 0) {\r\n                                h = Math.floor((t / 60) / 60);\r\n                                m = Math.floor((t / 60) % 60);\r\n                                s = t % 60;\r\n                            }\r\n\r\n                            h = h < 10 ? \"0\" + h : h;\r\n                            m = m < 10 ? \"0\" + m : m;\r\n                            s = s < 10 ? \"0\" + s : s;\r\n\r\n                            var total = (total_sec[id] !== undefined) ? total_sec[id] : t;\r\n                            var progres = Math.floor((total - t) * 100 / total);\r\n                            var text = sprintf('";
                        echo lang("auction_txt_4", true);
                        echo "', h, m, s);\r\n\r\n                            \$('#auction_rate_text' + id).html(text);\r\n                            \$('#auction_rate_line_stage' + id).width(progres + '%');\r\n                        }\r\n\r\n                        function arrayHasOwnIndex(array, prop) {\r\n                            return array.hasOwnProperty(prop) && /^0\$|^[1-9]\\d*\$/.test(prop) && prop <= 4294967294; // 2^32 - 2\r\n                        }\r\n\r\n                        function auction_countdown_init(time) {\r\n                            for (var id in auction_end) {\r\n                                if (arrayHasOwnIndex(auction_end, id)) {\r\n                                    var t = auction_end[id] - time;\r\n                                    auction_countdown(id, t);\r\n                                }\r\n                            }\r\n                            setTimeout(function () {\r\n                                auction_countdown_init(++time);\r\n                            }, 1000);\r\n                        }\r\n                    </script>\r\n                    ";
                        foreach ($auctions as $thisAuction) {
                            $currentBid = $Auction->getCurrentBid($thisAuction["id"]);
                            $highestBidData = $Auction->getHighestBidData($thisAuction["id"]);
                            $totalBids = $Auction->getTotalBids($thisAuction["id"]);
                            $totalSeconds = strtotime($thisAuction["end_date"]) - strtotime($thisAuction["start_date"]);
                            $secondsLeft = strtotime($thisAuction["end_date"]) - time();
                            $progress = floor(($totalSeconds - $secondsLeft) * 100 / $totalSeconds);
                            $hoursLeft = floor($secondsLeft / 3600);
                            $secondsLeft = $secondsLeft % 3600;
                            $minutesLeft = floor($secondsLeft / 60);
                            $secondsLeft = $secondsLeft % 60;
                            if (strlen($hoursLeft) < 2) {
                                $hoursLeft = "0" . $hoursLeft;
                            }
                            if (strlen($minutesLeft) < 2) {
                                $minutesLeft = "0" . $minutesLeft;
                            }
                            if (strlen($secondsLeft) < 2) {
                                $secondsLeft = "0" . $secondsLeft;
                            }
                            $currency = $Auction->getCurrencyName($thisAuction["currency"]);
                            $items = $Auction->getItems($thisAuction["id"]);
                            echo "\r\n            <div class=\"col-xs-12 auction\">\r\n                <form method=\"post\">\r\n                    <table>\r\n                        <tbody>\r\n                            <tr>\r\n                                <td colspan=\"2\" class=\"auction-text\">\r\n                                    <div class=\"auction-title\">" . $thisAuction["name"] . "</div>\r\n                                </td>\r\n                            </tr>\r\n                            <tr>\r\n                                <td colspan=\"2\" align=\"center\">";
                            foreach ($items as $thisItem) {
                                $itemInfo = $Items->ItemInfo($thisItem["item"]);
                                echo "\r\n                                    <div class=\"auction-item-frame\" style=\"cursor: pointer;\" onmouseover=\"Tip(" . $Items->generateItemTooltip($itemInfo, 1, 0, 1, 1, 0, 0) . ")\" onmouseout=\"UnTip()\">";
                                echo "\r\n                                           <span class=\"auction-img\"></span><img src=\"" . $itemInfo["thumb"] . "\">\r\n                                    </div> ";
                            }
                            echo "\r\n                                </td>\r\n                            </tr>\r\n                            <tr>\r\n                                <td colspan=\"2\">\r\n                                    <div class=\"auction-rate-line\">\r\n                                        <div class=\"auction-rate-line-stage\" id=\"auction_rate_line_stage" . $thisAuction["id"] . "\" style=\"width: " . $progress . "%\"></div>\r\n                                        <div class=\"auction-rate-text\" id=\"auction_rate_text" . $thisAuction["id"] . "\">" . sprintf(lang("auction_txt_4", true), $hoursLeft, $minutesLeft, $secondsLeft) . "</div>\r\n                                    </div>\r\n                                </td>\r\n                            </tr>\r\n                            <tr>\r\n                                <td>\r\n                                    <table>\r\n                                        <tr>\r\n                                            <td width=\"120px\">" . lang("auction_txt_5", true) . ":</td>\r\n                                            <td>\r\n                                                <b>" . number_format($currentBid) . " " . $currency . "</b> (" . sprintf(lang("auction_txt_6", true), $totalBids) . ")\r\n                                            </td>\r\n                                        </tr>\r\n                                        <tr>\r\n                                            <td>" . lang("auction_txt_7", true) . ":</td>\r\n                                            <td><b>" . date($config["time_date_format_logs"], strtotime($thisAuction["end_date"])) . "</b></td>\r\n                                        </tr>\r\n                                    </table>\r\n                                </td>\r\n                                <td align=\"right\">";
                            if ($Auction->canBid($_SESSION["username"], $thisAuction["id"])) {
                                if ($totalBids == 0) {
                                    $nextBid = $currentBid;
                                    $buttonTxt = lang("auction_txt_9", true);
                                    $messageTxt = lang("auction_txt_8", true);
                                } else {
                                    $bidData = $Auction->getHighestBidData($thisAuction["id"]);
                                    if ($bidData["AccountID"] == $_SESSION["username"]) {
                                        $nextBid = $bidData["bid"] + $thisAuction["increment"];
                                        $buttonTxt = lang("auction_txt_15", true);
                                        $messageTxt = lang("auction_txt_16", true);
                                    } else {
                                        $nextBid = $currentBid + $thisAuction["increment"];
                                        $buttonTxt = lang("auction_txt_9", true);
                                        $messageTxt = lang("auction_txt_8", true);
                                    }
                                }
                                echo "              \r\n                                    " . sprintf($messageTxt, $currency) . ": <input type=\"text\" name=\"amount\" value=\"" . $nextBid . "\" class=\"form-control\" style=\"width: 50px; text-align: right; margin-top: 4px; display: inline;\" />\r\n                                    <input type=\"hidden\" name=\"id\" value=\"" . Encode($thisAuction["id"]) . "\"/>\r\n                                    <input type=\"submit\" class=\"btn btn-warning\" style=\"margin-top: -2px;\" name=\"submit\" value=\"" . $buttonTxt . "\" onclick=\"javascript:if(!confirm('" . lang("auction_txt_32", true) . "')){ return false; }\"/>";
                            } else {
                                echo sprintf(lang("auction_txt_10", true), $currency);
                            }
                            echo "\r\n                                </td>\r\n                            </tr>\r\n                        </tbody>\r\n                    </table>\r\n                </form>                        <script type=\"text/javascript\">\r\n\r\n                            auction_end[";
                            echo $thisAuction["id"];
                            echo "] = ";
                            echo strtotime($thisAuction["end_date"]);
                            echo ";\r\n                            total_sec[";
                            echo $thisAuction["id"];
                            echo "] = ";
                            echo $totalSeconds;
                            echo ";\r\n\r\n                        </script>\r\n                        ";
                            if ($highestBidData["AccountID"] == $_SESSION["username"]) {
                                echo "<div class=\"auction-status-box\"><span class=\"auction-higest-bid\">";
                                echo lang("auction_txt_19", true);
                                echo "</span></div>";
                            } else {
                                if ($Auction->madeBid($_SESSION["username"], $thisAuction["id"])) {
                                    echo "<div class=\"auction-status-box\"><span class=\"auction-outbid\">";
                                    echo lang("auction_txt_20", true);
                                    echo "</span></div>";
                                }
                            }
                            echo "\r\n            </div>";
                        }
                        echo "\r\n            <nav aria-label=\"pagination\" class=\"market-pagination\">\r\n                <ul class=\"pagination\">";
                        $limit = mconfig("page_limit");
                        $total_items = $Auction->getAllActiveAuctions();
                        $total_pages = ceil($total_items / $limit);
                        generatePagination($total_pages, $_GET["pg"], __BASE_URL__ . "usercp/auction/pg/%pageHolder%/");
                        echo "\r\n                </ul>\r\n            </nav>                    <script type=\"text/javascript\">\r\n                        var local_time = ";
                        echo time();
                        echo ";\r\n                        auction_countdown_init(local_time);\r\n                    </script>\r\n                    ";
                    } else {
                        message("notice", lang("auction_txt_17", true));
                    }
                }
            } else {
                canAccessModuleMsg($_SESSION["username"], "auction", "block");
            }
        } else {
            message("error", lang("error_47", true));
        }
    } else {
        echo "\r\n<div class=\"sub-page-title\">\r\n    <div id=\"title\">\r\n        <h1>" . lang("module_titles_txt_3", true) . "<p></p><span></span></h1>\r\n    </div>\r\n</div>\r\n<div class=\"container_2 account\" align=\"center\">\r\n    <div class=\"cont-image\">\r\n        <div class=\"container_3 account_sub_header\">\r\n            <div class=\"grad\">";
        if (check_value($_GET["page"]) && $_GET["page"] == "ended") {
            echo "\r\n                <div class=\"page-title\"><p>" . lang("auction_txt_1", true) . "</p></div>\r\n                <a href=\"" . __BASE_URL__ . "usercp/auction/\">" . lang("auction_txt_2", true) . "</a>";
        } else {
            echo "\r\n                <div class=\"page-title\"><p>" . lang("myaccount_txt_79", true) . "</p></div>\r\n                <a href=\"" . __BASE_URL__ . "usercp/auction/page/ended/\" style=\"background-image: none;padding: 9px 12px 10px 10px\">" . lang("auction_txt_1", true) . "</a>\r\n                <a href=\"" . __BASE_URL__ . "usercp/\">" . lang("global_module_1", true) . "</a>";
        }
        echo "\r\n            </div>\r\n        </div>\r\n        <div class=\"page-desc-holder\">" . lang("auction_txt_3", true) . "</div>";
        if (mconfig("active")) {
            if (canAccessModule($_SESSION["username"], "auction", "block")) {
                $General = new xGeneral();
                $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("auction");
                $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("auction");
                $Auction = new Auction();
                $Market = new Market();
                $Items = new Items();
                echo "<script type=\"text/javascript\" SRC=\"" . __PATH_TEMPLATE__ . "js/tooltip.js\"></script>";
                if (check_value($_GET["page"]) && $_GET["page"] == "ended") {
                    $auctions = $Auction->getEndedAuctions();
                    if (is_array($auctions)) {
                        foreach ($auctions as $thisAuction) {
                            $currentBid = $Auction->getCurrentBid($thisAuction["id"]);
                            $totalBids = $Auction->getTotalBids($thisAuction["id"]);
                            $currency = $Auction->getCurrencyName($thisAuction["currency"]);
                            $highestBidData = $Auction->getHighestBidData($thisAuction["id"]);
                            $items = $Auction->getItems($thisAuction["id"]);
                            echo "\r\n            <div class=\"auction\">\r\n                <table>\r\n                    <tbody>\r\n                        <tr>\r\n                            <td colspan=\"2\" class=\"auction-text\">\r\n                                <div class=\"auction-title\">" . $thisAuction["name"] . "</div>\r\n                            </td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td colspan=\"2\" align=\"center\">";
                            foreach ($items as $thisItem) {
                                $itemInfo = $Items->ItemInfo($thisItem["item"]);
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
                                if (isset($itemInfo["luck"])) {
                                    $luck = "<br><font color=#9aadd5>" . $itemInfo["luck"] . "</font>";
                                }
                                if (isset($itemInfo["skill"])) {
                                    $skill = "<br><font color=#9aadd5>" . $itemInfo["skill"] . "</font>";
                                }
                                if (isset($itemInfo["opt"])) {
                                    $option = "<font color=#9aadd5>" . $itemInfo["opt"] . "</font>";
                                }
                                if (isset($itemInfo["exl"])) {
                                    $exl = "<font color=#4d668d>" . str_replace("^^", "<br>", $itemInfo["exl"]) . "</font>";
                                }
                                if (isset($itemInfo["ancsetopt"])) {
                                    $ancsetopt = "<font color=#9aadd5>" . str_replace("^^", "<br>", $itemInfo["ancsetopt"]) . "</font>";
                                }
                                echo "\r\n                                <div class=\"auction-item-frame\" style=\"cursor: pointer;\" onmouseover=\"Tip('<center><img src=" . $itemInfo["thumb"] . "><br /><font color=white><br>Durability: " . $itemInfo["dur"] . "</font><br><font color=#FF99CC>" . $itemInfo["jog"] . "</font><font color=FFCC00>" . $itemInfo["harm"] . "</font><br>" . $option . " " . $luck . " " . $skill . " " . $exl . " <br>" . $ancsetopt . "<br><font color=#4d668d>" . $itemInfo["socket"] . "</font><br><br><span class=itemTooltipClassReq>" . $itemInfo["classReq"] . "</span></center>', TITLEFONTCOLOR, '" . $itemInfo["color"] . "',TITLE,'" . addslashes($itemInfo["name"]) . $itemInfo["level"] . "',TITLEBGCOLOR,'" . $itemInfo["anco"] . "')\" onmouseout=\"UnTip()\">";
                                echo "\r\n                                   <span class=\"auction-img\"></span><img src=\"" . $itemInfo["thumb"] . "\">\r\n                                </div> ";
                            }
                            echo "\r\n                            </td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td colspan=\"2\">\r\n                                <div class=\"auction-rate-line\">\r\n                                    <div class=\"auction-rate-line-stage\" style=\"width: 100%\"></div>\r\n                                    <div class=\"auction-rate-text\">" . lang("auction_txt_11", true) . "</div>\r\n                                </div>\r\n                            </td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td>\r\n                                <table>\r\n                                    <tr>\r\n                                        <td width=\"120px\">" . lang("auction_txt_12", true) . ":</td>\r\n                                        <td><b>" . number_format($currentBid) . " " . $currency . "</b> (" . sprintf(lang("auction_txt_6", true), $totalBids) . ")</td>\r\n                                    </tr>\r\n                                    <tr>\r\n                                        <td>" . lang("auction_txt_13", true) . ":</td>\r\n                                        <td><b>" . date($config["time_date_format_logs"], strtotime($thisAuction["end_date"])) . "</b></td>\r\n                                    </tr>\r\n                                </table>\r\n                            </td>\r\n                        </tr>\r\n                    </tbody>\r\n                </table>";
                            if ($highestBidData["AccountID"] == $_SESSION["username"]) {
                                echo "<div class=\"auction-status-box\"><span class=\"auction-higest-bid\">";
                                echo lang("auction_txt_31", true);
                                echo "</span></div>";
                            } else {
                                if ($Auction->madeBid($_SESSION["username"], $thisAuction["id"])) {
                                    echo "<div class=\"auction-status-box\"><span class=\"auction-outbid\">";
                                    echo lang("auction_txt_20", true);
                                    echo "</span></div>";
                                }
                            }
                            echo "\r\n            </div>";
                        }
                    } else {
                        message("notice", lang("auction_txt_24", true));
                    }
                } else {
                    if (check_value($_POST["submit"])) {
                        $Auction->placeBid($_SESSION["username"], $_POST["amount"], Decode($_POST["id"]));
                    }
                    echo "                <script type=\"text/javascript\">\r\n\r\n                    function auction_ajax_bid_checker() {\r\n                        //console.log('bid checker');\r\n                        \$.getJSON('";
                    echo __BASE_URL__;
                    echo "ajax/auction_check_bid.php', function (data) {\r\n                            if (data.status) {\r\n                                //console.log( \"AUCTION AJAX auctions: \" + data.auctions );\r\n                                //TODO:\r\n\r\n                                if (data.refresh) {\r\n                                    console.log('AUCTION AJAX refresh');\r\n                                    //location.reload();\r\n                                }\r\n                            } else {\r\n                                console.log(\"AUCTION AJAX ERROR: \" + data.error);\r\n                            }\r\n                        });\r\n                    }\r\n\r\n                    function auction_bid_checker_init() {\r\n                        setTimeout(function () {\r\n                            auction_ajax_bid_checker();\r\n                            auction_bid_checker_init();\r\n                        }, 30000);\r\n                    }\r\n\r\n                    auction_bid_checker_init();\r\n                </script>\r\n                ";
                    $auctions = $Auction->getActiveAuctions($_GET["pg"], mconfig("page_limit"));
                    if (is_array($auctions)) {
                        echo "                    <script type=\"text/javascript\">\r\n                        var auction_end = [];\r\n                        var total_sec = [];\r\n\r\n                        function auction_countdown(id, t) {\r\n                            //console.log(t);\r\n                            var h = 0, m = 0, s = 0;\r\n\r\n                            if (t > 0) {\r\n                                h = Math.floor((t / 60) / 60);\r\n                                m = Math.floor((t / 60) % 60);\r\n                                s = t % 60;\r\n                            }\r\n\r\n                            h = h < 10 ? \"0\" + h : h;\r\n                            m = m < 10 ? \"0\" + m : m;\r\n                            s = s < 10 ? \"0\" + s : s;\r\n\r\n                            var total = (total_sec[id] !== undefined) ? total_sec[id] : t;\r\n                            var progres = Math.floor((total - t) * 100 / total);\r\n                            var text = sprintf('";
                        echo lang("auction_txt_4", true);
                        echo "', h, m, s);\r\n\r\n                            \$('#auction_rate_text' + id).html(text);\r\n                            \$('#auction_rate_line_stage' + id).width(progres + '%');\r\n                        }\r\n\r\n                        function arrayHasOwnIndex(array, prop) {\r\n                            return array.hasOwnProperty(prop) && /^0\$|^[1-9]\\d*\$/.test(prop) && prop <= 4294967294; // 2^32 - 2\r\n                        }\r\n\r\n                        function auction_countdown_init(time) {\r\n                            for (var id in auction_end) {\r\n                                if (arrayHasOwnIndex(auction_end, id)) {\r\n                                    var t = auction_end[id] - time;\r\n                                    auction_countdown(id, t);\r\n                                }\r\n                            }\r\n                            setTimeout(function () {\r\n                                auction_countdown_init(++time);\r\n                            }, 1000);\r\n                        }\r\n                    </script>\r\n                    ";
                        foreach ($auctions as $thisAuction) {
                            $currentBid = $Auction->getCurrentBid($thisAuction["id"]);
                            $highestBidData = $Auction->getHighestBidData($thisAuction["id"]);
                            $totalBids = $Auction->getTotalBids($thisAuction["id"]);
                            $totalSeconds = strtotime($thisAuction["end_date"]) - strtotime($thisAuction["start_date"]);
                            $secondsLeft = strtotime($thisAuction["end_date"]) - time();
                            $progress = floor(($totalSeconds - $secondsLeft) * 100 / $totalSeconds);
                            $hoursLeft = floor($secondsLeft / 3600);
                            $secondsLeft = $secondsLeft % 3600;
                            $minutesLeft = floor($secondsLeft / 60);
                            $secondsLeft = $secondsLeft % 60;
                            if (strlen($hoursLeft) < 2) {
                                $hoursLeft = "0" . $hoursLeft;
                            }
                            if (strlen($minutesLeft) < 2) {
                                $minutesLeft = "0" . $minutesLeft;
                            }
                            if (strlen($secondsLeft) < 2) {
                                $secondsLeft = "0" . $secondsLeft;
                            }
                            $currency = $Auction->getCurrencyName($thisAuction["currency"]);
                            $items = $Auction->getItems($thisAuction["id"]);
                            echo "\r\n            <div class=\"auction\">\r\n                <form method=\"post\">\r\n                    <table>\r\n                        <tbody>\r\n                            <tr>\r\n                                <td colspan=\"2\" class=\"auction-text\">\r\n                                    <div class=\"auction-title\">" . $thisAuction["name"] . "</div>\r\n                                </td>\r\n                            </tr>\r\n                            <tr>\r\n                                <td colspan=\"2\" align=\"center\">";
                            foreach ($items as $thisItem) {
                                $itemInfo = $Items->ItemInfo($thisItem["item"]);
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
                                if (isset($itemInfo["luck"])) {
                                    $luck = "<br><font color=#9aadd5>" . $itemInfo["luck"] . "</font>";
                                }
                                if (isset($itemInfo["skill"])) {
                                    $skill = "<br><font color=#9aadd5>" . $itemInfo["skill"] . "</font>";
                                }
                                if (isset($itemInfo["opt"])) {
                                    $option = "<font color=#9aadd5>" . $itemInfo["opt"] . "</font>";
                                }
                                if (isset($itemInfo["exl"])) {
                                    $exl = "<font color=#4d668d>" . str_replace("^^", "<br>", $itemInfo["exl"]) . "</font>";
                                }
                                if (isset($itemInfo["ancsetopt"])) {
                                    $ancsetopt = "<font color=#9aadd5>" . str_replace("^^", "<br>", $itemInfo["ancsetopt"]) . "</font>";
                                }
                                echo "\r\n                                    <div class=\"auction-item-frame\" style=\"cursor: pointer;\" onmouseover=\"Tip('<center><img src=" . $itemInfo["thumb"] . "><br /><font color=white><br>Durability: " . $itemInfo["dur"] . "</font><br><font color=#FF99CC>" . $itemInfo["jog"] . "</font><font color=FFCC00>" . $itemInfo["harm"] . "</font><br>" . $option . " " . $luck . " " . $skill . " " . $exl . " <br>" . $ancsetopt . "<br><font color=#4d668d>" . $itemInfo["socket"] . "</font><br><br><span class=itemTooltipClassReq>" . $itemInfo["classReq"] . "</span></center>', TITLEFONTCOLOR, '" . $itemInfo["color"] . "',TITLE,'" . addslashes($itemInfo["name"]) . $itemInfo["level"] . "',TITLEBGCOLOR,'" . $itemInfo["anco"] . "')\" onmouseout=\"UnTip()\">";
                                echo "\r\n                                           <span class=\"auction-img\"></span><img src=\"" . $itemInfo["thumb"] . "\">\r\n                                    </div> ";
                            }
                            echo "\r\n                                </td>\r\n                            </tr>\r\n                            <tr>\r\n                                <td colspan=\"2\">\r\n                                    <div class=\"auction-rate-line\">\r\n                                        <div class=\"auction-rate-line-stage\" id=\"auction_rate_line_stage" . $thisAuction["id"] . "\" style=\"width: " . $progress . "%\"></div>\r\n                                        <div class=\"auction-rate-text\" id=\"auction_rate_text" . $thisAuction["id"] . "\">" . sprintf(lang("auction_txt_4", true), $hoursLeft, $minutesLeft, $secondsLeft) . "</div>\r\n                                    </div>\r\n                                </td>\r\n                            </tr>\r\n                            <tr>\r\n                                <td>\r\n                                    <table>\r\n                                        <tr>\r\n                                            <td width=\"120px\">" . lang("auction_txt_5", true) . ":</td>\r\n                                            <td>\r\n                                                <b>" . number_format($currentBid) . " " . $currency . "</b> (" . sprintf(lang("auction_txt_6", true), $totalBids) . ")\r\n                                            </td>\r\n                                        </tr>\r\n                                        <tr>\r\n                                            <td>" . lang("auction_txt_7", true) . ":</td>\r\n                                            <td><b>" . date($config["time_date_format_logs"], strtotime($thisAuction["end_date"])) . "</b></td>\r\n                                        </tr>\r\n                                    </table>\r\n                                </td>\r\n                                <td align=\"right\">";
                            if ($Auction->canBid($_SESSION["username"], $thisAuction["id"])) {
                                if ($totalBids == 0) {
                                    $nextBid = $currentBid;
                                    $buttonTxt = lang("auction_txt_9", true);
                                    $messageTxt = lang("auction_txt_8", true);
                                } else {
                                    $bidData = $Auction->getHighestBidData($thisAuction["id"]);
                                    if ($bidData["AccountID"] == $_SESSION["username"]) {
                                        $nextBid = $bidData["bid"] + $thisAuction["increment"];
                                        $buttonTxt = lang("auction_txt_15", true);
                                        $messageTxt = lang("auction_txt_16", true);
                                    } else {
                                        $nextBid = $currentBid + $thisAuction["increment"];
                                        $buttonTxt = lang("auction_txt_9", true);
                                        $messageTxt = lang("auction_txt_8", true);
                                    }
                                }
                                echo "              \r\n                                    " . sprintf($messageTxt, $currency) . ": <input type=\"text\" name=\"amount\" value=\"" . $nextBid . "\" style=\"width: 50px; text-align: right; margin-top: 4px;\" />\r\n                                    <input type=\"hidden\" name=\"id\" value=\"" . Encode($thisAuction["id"]) . "\"/>\r\n                                    <input type=\"submit\" name=\"submit\" value=\"" . $buttonTxt . "\" onclick=\"javascript:if(!confirm('" . lang("auction_txt_32", true) . "')){ return false; }\"/>";
                            } else {
                                echo sprintf(lang("auction_txt_10", true), $currency);
                            }
                            echo "\r\n                                </td>\r\n                            </tr>\r\n                        </tbody>\r\n                    </table>\r\n                </form>                        <script type=\"text/javascript\">\r\n\r\n                            auction_end[";
                            echo $thisAuction["id"];
                            echo "] = ";
                            echo strtotime($thisAuction["end_date"]);
                            echo ";\r\n                            total_sec[";
                            echo $thisAuction["id"];
                            echo "] = ";
                            echo $totalSeconds;
                            echo ";\r\n\r\n                        </script>\r\n                        ";
                            if ($highestBidData["AccountID"] == $_SESSION["username"]) {
                                echo "<div class=\"auction-status-box\"><span class=\"auction-higest-bid\">";
                                echo lang("auction_txt_19", true);
                                echo "</span></div>";
                            } else {
                                if ($Auction->madeBid($_SESSION["username"], $thisAuction["id"])) {
                                    echo "<div class=\"auction-status-box\"><span class=\"auction-outbid\">";
                                    echo lang("auction_txt_20", true);
                                    echo "</span></div>";
                                }
                            }
                            echo "\r\n            </div>";
                        }
                        echo "                    <script type=\"text/javascript\">\r\n                        var local_time = ";
                        echo time();
                        echo ";\r\n                        auction_countdown_init(local_time);\r\n                    </script>\r\n                    ";
                    } else {
                        message("notice", lang("auction_txt_17", true));
                    }
                }
            } else {
                canAccessModuleMsg($_SESSION["username"], "auction", "block");
            }
        } else {
            message("error", lang("error_47", true));
        }
        echo "\r\n\t</div>\r\n</div>";
    }
}

?>