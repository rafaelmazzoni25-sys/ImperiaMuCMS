<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */
if (check_value($_GET["id"])) {
    $Auction = new Auction();
    if (check_value($_POST["edit_auction"])) {
        $Auction->editAuction($_GET["id"], $_POST["name"], $_POST["author"], $_POST["start"], $_POST["end"], $_POST["currency"], $_POST["bid"], $_POST["increment"], $_POST["bidType"], $_POST["extend"]);
        $auction_id = $_GET["id"];
        $delete = $dB->query("DELETE FROM IMPERIAMUCMS_AUCTIONS_ITEMS WHERE auction_id = ?", $auction_id);
        $i = 0;
        while ($i < 50) {
            $index = "item" . $i;
            if (!($_POST[$index] == NULL || $_POST[$index] == __ITEM_EMPTY__)) {
                $Auction->addAuctionItem($auction_id, $_POST[$index]);
            }
            $i++;
        }
    }
    $auctionData = $Auction->getAuction($_GET["id"]);
    $custom = "";
    $customItems = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_WEB_BANK_CUSTOM");
    foreach ($customItems as $thisItem) {
        if ($auctionData["currency"] == $thisItem["ident"]) {
            $custom .= "<option value=\"" . $thisItem["ident"] . "\" selected=\"selected\">" . $thisItem["name"] . "</option>";
        } else {
            $custom .= "<option value=\"" . $thisItem["ident"] . "\">" . $thisItem["name"] . "</option>";
        }
    }
    echo "    <h1 class=\"page-header\">Edit Auction</h1>\r\n    <form role=\"form\" method=\"post\">\r\n        <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n            <tr>\r\n                <th>Name<br/><span>Select auction's name.</span></th>\r\n                <td><input class=\"form-control\" type=\"text\" name=\"name\" value=\"";
    echo $auctionData["name"];
    echo "\" placeholder=\"Auction's Name\" maxlength=\"255\"/></td>\r\n            </tr>\r\n            <tr>\r\n                <th>Author<br/><span>Select auction's author. Maximum 50 characters.</span></th>\r\n                <td><input class=\"form-control\" type=\"text\" name=\"author\" value=\"";
    echo $auctionData["author"];
    echo "\" maxlength=\"50\"/></td>\r\n            </tr>\r\n            <tr>\r\n                <th>Start Date<br/><span>Format: <b>YYYY-MM-DD HH:MM:SS</b></span></th>\r\n                <td><input class=\"form-control\" type=\"text\" name=\"start\" value=\"";
    echo date("Y-m-d H:i:s", strtotime($auctionData["start_date"]));
    echo "\" placeholder=\"YYYY-MM-DD HH:MM:SS\"/></td>\r\n            </tr>\r\n            <tr>\r\n                <th>End Date<br/><span>Format: <b>YYYY-MM-DD HH:MM:SS</b></span></th>\r\n                <td><input class=\"form-control\" type=\"text\" name=\"end\" value=\"";
    echo date("Y-m-d H:i:s", strtotime($auctionData["end_date"]));
    echo "\" placeholder=\"YYYY-MM-DD HH:MM:SS\"/></td>\r\n            </tr>\r\n            <tr>\r\n                <th>Currency<br/><span>System supports all website and in-game currencies and all items from Web Bank module.</span></th>\r\n                <td>\r\n                    <select name=\"currency\" class=\"form-control\">\r\n                        ";
    if ($auctionData["currency"] == "0") {
        echo "<option value=\"0\" selected=\"selected\">Online Time (Hours)</option>";
    } else {
        echo "<option value=\"0\">Online Time (Hours)</option>";
    }
    if ($auctionData["currency"] == "1") {
        echo "<option value=\"1\" selected=\"selected\">Platinum Coins</option>";
    } else {
        echo "<option value=\"1\">Platinum Coins</option>";
    }
    if ($auctionData["currency"] == "2") {
        echo "<option value=\"2\" selected=\"selected\">Gold Coins</option>";
    } else {
        echo "<option value=\"2\">Gold Coins</option>";
    }
    if ($auctionData["currency"] == "3") {
        echo "<option value=\"3\" selected=\"selected\">Silver Coins</option>";
    } else {
        echo "<option value=\"3\">Silver Coins</option>";
    }
    if ($auctionData["currency"] == "4") {
        echo "<option value=\"4\" selected=\"selected\">WCoinC</option>";
    } else {
        echo "<option value=\"4\">WCoinC</option>";
    }
    if ($auctionData["currency"] == "5") {
        echo "<option value=\"5\" selected=\"selected\">GoblinPoint</option>";
    } else {
        echo "<option value=\"5\">GoblinPoint</option>";
    }
    if ($auctionData["currency"] == "6") {
        echo "<option value=\"6\" selected=\"selected\">Zen</option>";
    } else {
        echo "<option value=\"6\">Zen</option>";
    }
    if ($auctionData["currency"] == "7") {
        echo "<option value=\"7\" selected=\"selected\">Jewel of Bless</option>";
    } else {
        echo "<option value=\"7\">Jewel of Bless</option>";
    }
    if ($auctionData["currency"] == "8") {
        echo "<option value=\"8\" selected=\"selected\">Jewel of Soul</option>";
    } else {
        echo "<option value=\"8\">Jewel of Soul</option>";
    }
    if ($auctionData["currency"] == "9") {
        echo "<option value=\"9\" selected=\"selected\">Jewel of Life</option>";
    } else {
        echo "<option value=\"9\">Jewel of Life</option>";
    }
    if ($auctionData["currency"] == "10") {
        echo "<option value=\"10\" selected=\"selected\">Jewel of Chaos</option>";
    } else {
        echo "<option value=\"10\">Jewel of Chaos</option>";
    }
    if ($auctionData["currency"] == "11") {
        echo "<option value=\"11\" selected=\"selected\">Jewel of Harmony</option>";
    } else {
        echo "<option value=\"11\">Jewel of Harmony</option>";
    }
    if ($auctionData["currency"] == "12") {
        echo "<option value=\"12\" selected=\"selected\">Jewel of Creation</option>";
    } else {
        echo "<option value=\"12\">Jewel of Creation</option>";
    }
    if ($auctionData["currency"] == "13") {
        echo "<option value=\"13\" selected=\"selected\">Jewel of Guardian</option>";
    } else {
        echo "<option value=\"13\">Jewel of Guardian</option>";
    }
    echo $custom;
    echo "                    </select>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Starting Bid<br/><span>Select auction's starting bid.</span></th>\r\n                <td><input class=\"form-control\" type=\"text\" name=\"bid\" value=\"";
    echo $auctionData["bid"];
    echo "\"/></td>\r\n            </tr>\r\n            <tr>\r\n                <th>Bid Increment<br/><span>Select bid's increment. Minimum value is 1. Players will be able to increase current bid by this amount only.</span></th>\r\n                <td><input class=\"form-control\" type=\"text\" name=\"increment\" value=\"";
    echo $auctionData["increment"];
    echo "\"/></td>\r\n            </tr>\r\n            <tr>\r\n                <th>Bid Type<br/>\r\n                    <span>\r\n                    <b>With reserve: </b>When current highest bid is 100 and increment is 10 and another player will bid 200, new current highest bid will be 110, but he will have reserve up to 200, so if another player bids 120, he will be outbidded by first player and current bid will be increated from 110 to 120. First player will be outbidded only if someone will bid 210 or more.\r\n                    <br><b>Without reserve: </b>All bids will be actual and player won't be able to make a reserve to automatically outbid other players.\r\n                </span>\r\n                </th>\r\n                <td>\r\n                    ";
    enabledisableCheckboxes2("bidType", $auctionData["bidType"], "With reserve", "Without reserve");
    echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Time Extend<br/><span>If auction will end in less than this value, end of the auction will be extended to this value when someone will make new highest bid.<br>Value is expressed in minutes. Minimum value is 1.</span>\r\n                </th>\r\n                <td><input class=\"form-control\" type=\"text\" name=\"extend\" value=\"";
    echo $auctionData["extend"];
    echo "\"/></td>\r\n            </tr>\r\n            <tr>\r\n                <th>Items<br/><span>Enter hex code of items (maximum 50 items)</span></th>\r\n                <td>\r\n                    ";
    $id = 0;
    $items = $Auction->getItems($_GET["id"]);
    if (is_array($items)) {
        foreach ($items as $thisItem) {
            echo "Item " . ($id + 1) . ": <input type=text class=form-control style=display:inline;width:90%; maxlength=64 size=80 name=item" . $id . " value=\"" . $thisItem["item"] . "\"><hr>";
            $id++;
        }
    }
    echo "                    <div id=newItem></div>\r\n                    <script type=\"text/javascript\">\r\n                        var iid = ";
    echo $id;
    echo ";\r\n\r\n                        function popitup(url) {\r\n                            newwindow = window.open(url, 'name', 'height = 550, width = 600');\r\n                            if (window.focus) {\r\n                                newwindow.focus()\r\n                            }\r\n                            return false;\r\n                        }\r\n\r\n                        function addItem() {\r\n                            var newItem = \$('#newItem');\r\n                            var html = 'Item ' + (iid + 1) + ': <input type=\"text\" class=\"form-control\" style=\"display:inline; width:90%;\" maxlength=\"64\" size=\"80\" name=\"item' + iid + '\" value=\"";
    echo __ITEM_EMPTY__;
    echo "\" /><hr>';\r\n                            newItem.append(html);\r\n                            iid = iid + 1;\r\n                        }\r\n                    </script>\r\n                    <input type=\"button\" value=\"Add new\" class=\"btn btn-primary\" onClick=\"addItem();\">\r\n                    <input class=\"btn btn-primary\" type=\"button\" onClick=\"popitup('item_hex_generator.php')\" value=\"Item Code Generator\" title=\"Item Code Generator\">\r\n                </td>\r\n            </tr>\r\n        </table>\r\n        <button type=\"submit\" class=\"btn btn-large btn-block btn-success\" name=\"edit_auction\" value=\"ok\">Edit Auction</button>\r\n    </form>\r\n    ";
} else {
    message("error", "Invalid request.");
}

?>