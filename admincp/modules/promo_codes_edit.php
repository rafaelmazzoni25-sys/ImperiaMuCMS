<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$Promo = new Promo();
if (check_value($_POST["edit_code"])) {
    $Promo->editCode($_REQUEST["id"], $_POST["code"], $_POST["type"], $_POST["reward_type"], $_POST["owner"], $_POST["active"]);
    if ($_POST["reward_type"] == "1" || $_POST["reward_type"] == "2" || $_POST["reward_type"] == "3" || $_POST["reward_type"] == "8" || $_POST["reward_type"] == "9" || $_POST["reward_type"] == "10") {
        $Promo->editCodeCoins($_POST["code"], $_POST["count"]);
    } else {
        if ($_POST["reward_type"] == "4" || $_POST["reward_type"] == "5" || $_POST["reward_type"] == "6") {
            $promoData = $Promo->getPromoData($_REQUEST["id"]);
            $delete = $dB->query("DELETE FROM IMPERIAMUCMS_PROMO_REWARDS WHERE code = '" . $promoData["code"] . "'");
            $i = 0;
            while ($i < 50) {
                $index = "item" . $i;
                if (!($_POST[$index] == NULL || $_POST[$index] == __ITEM_EMPTY__)) {
                    $Promo->addCodeItem($promoData["code"], $_POST[$index]);
                    if ($_POST["reward_type"] != "4") {
                    }
                }
                $i++;
            }
        } else {
            if ($_POST["reward_type"] == "7") {
                $Promo->editCodeVip($_POST["code"], $_POST["vip_type"], $_POST["count"]);
            }
        }
    }
}
$promoData = $Promo->getPromoData($_REQUEST["id"]);
if ($promoData["reward_type"] == "1" || $promoData["reward_type"] == "2" || $promoData["reward_type"] == "3" || $promoData["reward_type"] == "4" || $promoData["reward_type"] == "7" || $promoData["reward_type"] == "8" || $promoData["reward_type"] == "9" || $promoData["reward_type"] == "10") {
    $promoReward = $Promo->getReward($promoData["code"]);
} else {
    $promoReward = $Promo->getRewards($promoData["code"]);
}
echo "<h1 class=\"page-header\">Edit Promo Code</h1>\r\n<form role=\"form\" method=\"post\">\r\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n        <tr>\r\n            <th>Code<br/><span>Promo Code is generated automatically</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"code\" value=\"";
echo $promoData["code"];
echo "\"\r\n                       readonly=\"readonly\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Status<br/><span>Enable/disable package.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("active", $promoData["active"], "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Type<br/><span>Type of promo code</span></th>\r\n            <td>\r\n                <select class=\"form-control\" name=\"type\">\r\n                    ";
if ($promoData["type"] == "1") {
    echo "<option value=\"1\" selected>Unique</option>";
} else {
    echo "<option value=\"1\">Unique</option>";
}
if ($promoData["type"] == "2") {
    echo "<option value=\"2\" selected>Per account</option>";
} else {
    echo "<option value=\"2\">Per account</option>";
}
echo "                </select>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Reward Type<br/><span>Reward type of promo code</span></th>\r\n            <td>\r\n                <select class=\"form-control\" name=\"reward_type\">\r\n                    ";
if ($promoData["reward_type"] == "3") {
    echo "<option value=\"3\" selected>Platinum Coins</option>";
} else {
    echo "<option value=\"3\">Platinum Coins</option>";
}
if ($promoData["reward_type"] == "1") {
    echo "<option value=\"1\" selected>Gold Coins</option>";
} else {
    echo "<option value=\"1\">Gold Coins</option>";
}
if ($promoData["reward_type"] == "2") {
    echo "<option value=\"2\" selected>Silver Coins</option>";
} else {
    echo "<option value=\"2\">Silver Coins</option>";
}
if ($promoData["reward_type"] == "8") {
    echo "<option value=\"8\" selected>WCoinC</option>";
} else {
    echo "<option value=\"8\">WCoinC</option>";
}
if ($promoData["reward_type"] == "9") {
    echo "<option value=\"9\" selected>Goblin Points</option>";
} else {
    echo "<option value=\"9\">Goblin Points</option>";
}
if ($promoData["reward_type"] == "10") {
    echo "<option value=\"10\" selected>Zen</option>";
} else {
    echo "<option value=\"10\">Zen</option>";
}
if ($promoData["reward_type"] == "4") {
    echo "<option value=\"4\" selected>Single Item</option>";
} else {
    echo "<option value=\"4\">Single Item</option>";
}
if ($promoData["reward_type"] == "5") {
    echo "<option value=\"5\" selected>Random Item</option>";
} else {
    echo "<option value=\"5\">Random Item</option>";
}
if ($promoData["reward_type"] == "6") {
    echo "<option value=\"6\" selected>Multiple Items</option>";
} else {
    echo "<option value=\"6\">Multiple Items</option>";
}
if ($promoData["reward_type"] == "7") {
    echo "<option value=\"7\" selected>VIP Subscription</option>";
} else {
    echo "<option value=\"7\">VIP Subscription</option>";
}
echo "                </select>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Owner<br/><span>AccountID - who can use promo code (leave empty if it can be used by anyone)</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"owner\" value=\"\"/>\r\n            </td>\r\n        </tr>\r\n    </table>\r\n\r\n    <h3>Rewards Config</h3>\r\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n        <tr>\r\n            <th>Vip Type<br/><span>Type of VIP subscription (select only if promo code has type \"VIP Subscription\")</span></th>\r\n            <td>\r\n                <select class=\"form-control\" name=\"vip_type\">\r\n                    ";
if ($promoReward["vip_type"] == NULL) {
    echo "<option value=\"\" selected>Select</option>";
} else {
    echo "<option value=\"\"> selected</option>";
}
if ($promoReward["vip_type"] == "1") {
    echo "<option value=\"1\" selected>Bronze</option>";
} else {
    echo "<option value=\"1\">Bronze</option>";
}
if ($promoReward["vip_type"] == "2") {
    echo "<option value=\"2\" selected>Silver</option>";
} else {
    echo "<option value=\"2\">Silver</option>";
}
if ($promoReward["vip_type"] == "3") {
    echo "<option value=\"3\" selected>Gold</option>";
} else {
    echo "<option value=\"3\">Gold</option>";
}
if ($promoReward["vip_type"] == "4") {
    echo "<option value=\"4\" selected>Platinum</option>";
} else {
    echo "<option value=\"4\">Platinum</option>";
}
echo "                </select>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Count<br/><span>Enter amount of Coins/length of VIP in days (leave empty if reward are items)</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"count\" value=\"";
echo $promoReward["count"];
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Items<br/><span>Enter hex code of items (maximum 50 items)</span></th>\r\n            <td>\r\n                ";
$id = 0;
if ($promoData["reward_type"] == "5" || $promoData["reward_type"] == "6") {
    foreach ($promoReward as $thisItem) {
        echo "Item " . ($id + 1) . ": <input type=text class=form-control style=display:inline;width:90%; maxlength=64 size=80 name=item" . $id . " value=\"" . $thisItem["item"] . "\"><hr>";
        $id++;
    }
} else {
    if ($promoData["reward_type"] == "4") {
        echo "Item " . ($id + 1) . ": <input type=text class=form-control style=display:inline;width:90%; maxlength=64 size=80 name=item" . $id . " value=\"" . $promoReward["item"] . "\"><hr>";
        $id++;
    }
}
echo "                <div id=newItem></div>\r\n                <script type=\"text/javascript\">\r\n                    var iid = ";
echo $id;
echo ";\r\n\r\n                    function popitup(url) {\r\n                        newwindow = window.open(url, 'name', 'height = 550, width = 600');\r\n                        if (window.focus) {\r\n                            newwindow.focus()\r\n                        }\r\n                        return false;\r\n                    }\r\n\r\n                    function addItem() {\r\n                        var newItem = \$('#newItem');\r\n                        var html = 'Item ' + (iid + 1) + ': <input type=\"text\" class=\"form-control\" style=\"display:inline; width:90%;\" maxlength=\"64\" size=\"80\" name=\"item' + iid + '\" value=\"";
echo __ITEM_EMPTY__;
echo "\" /><hr>';\r\n                        newItem.append(html);\r\n                        iid = iid + 1;\r\n                    }\r\n                </script>\r\n                <input type=\"button\" value=\"Add new\" class=\"btn btn-primary\" onClick=\"addItem();\">\r\n                <input class=\"btn btn-primary\" type=\"button\" onClick=\"popitup('item_hex_generator.php')\" value=\"Item Code Generator\" title=\"Item Code Generator\">\r\n            </td>\r\n        </tr>\r\n    </table>\r\n\r\n    <button type=\"submit\" class=\"btn btn-large btn-block btn-success\" name=\"edit_code\" value=\"ok\">Edit Code</button>\r\n</form>";

?>