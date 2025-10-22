<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

if (check_value($_POST["add_code"])) {
    $Promo = new Promo();
    $Promo->addCode($_POST["code"], $_POST["type"], $_POST["reward_type"], $_POST["owner"], 0);
    if ($_POST["reward_type"] == "1" || $_POST["reward_type"] == "2" || $_POST["reward_type"] == "3" || $_POST["reward_type"] == "8" || $_POST["reward_type"] == "9" || $_POST["reward_type"] == "10") {
        $Promo->addCodeCoins($_POST["code"], $_POST["count"]);
    } else {
        if ($_POST["reward_type"] == "4" || $_POST["reward_type"] == "5" || $_POST["reward_type"] == "6") {
            $i = 0;
            while ($i < 50) {
                $index = "item" . $i;
                if (!($_POST[$index] == NULL || $_POST[$index] == __ITEM_EMPTY__)) {
                    $Promo->addCodeItem($_POST["code"], $_POST[$index]);
                    if ($_POST["reward_type"] != "4") {
                    }
                }
                $i++;
            }
        } else {
            if ($_POST["reward_type"] == "7") {
                $Promo->addCodeVip($_POST["code"], $_POST["vip_type"], $_POST["count"]);
            }
        }
    }
}
$code = generaterandomstring(14);
echo "<h1 class=\"page-header\">Add New Promo Code</h1>\r\n<form role=\"form\" method=\"post\">\r\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n        <tr>\r\n            <th>Code<br/><span>Promo Code is generated automatically</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"code\" value=\"";
echo $code;
echo "\" readonly=\"readonly\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Type<br/><span>Type of promo code.</span></th>\r\n            <td>\r\n                <select class=\"form-control\" name=\"type\">\r\n                    <option value=\"1\">Unique</option>\r\n                    <option value=\"2\">Per account</option>\r\n                </select>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Reward Type<br/><span>Reward type of promo code.</span></th>\r\n            <td>\r\n                <select class=\"form-control\" name=\"reward_type\">\r\n                    <option value=\"3\">Platinum Coins</option>\r\n                    <option value=\"1\">Gold Coins</option>\r\n                    <option value=\"2\">Silver Coins</option>\r\n                    <option value=\"8\">WCoinC</option>\r\n                    <option value=\"9\">Goblin Points</option>\r\n                    <option value=\"10\">Zen</option>\r\n                    <option value=\"4\">Single Item</option>\r\n                    <option value=\"5\">Random Item</option>\r\n                    <option value=\"6\">Multiple Items</option>\r\n                    <option value=\"7\">VIP Subscription</option>\r\n                </select>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Owner<br/><span>AccountID - who can use promo code (leave empty if it can be used by anyone).</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"owner\" value=\"\"/>\r\n            </td>\r\n        </tr>\r\n    </table>\r\n\r\n    <h3>Rewards Config</h3>\r\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n        <tr>\r\n            <th>Vip Type<br/><span>Type of VIP subscription (select only if promo code has type \"VIP Subscription\").</span>\r\n            </th>\r\n            <td>\r\n                <select class=\"form-control\" name=\"vip_type\">\r\n                    <option value=\"\">Select</option>\r\n                    <option value=\"1\">Bronze</option>\r\n                    <option value=\"2\">Silver</option>\r\n                    <option value=\"3\">Gold</option>\r\n                    <option value=\"4\">Platinum</option>\r\n                </select>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Count<br/><span>Enter amount of Coins/length of VIP in days (leave empty if reward are items)</span>\r\n            </th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"count\" value=\"\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Items<br/><span>Enter hex code of items (maximum 50 items)</span></th>\r\n            <td>\r\n                <div id=newItem></div>\r\n                <script type=\"text/javascript\">\r\n                    var iid = 0;\r\n\r\n                    function popitup(url) {\r\n                        newwindow = window.open(url, 'name', 'height = 550, width = 600');\r\n                        if (window.focus) {\r\n                            newwindow.focus()\r\n                        }\r\n                        return false;\r\n                    }\r\n\r\n                    function addItem() {\r\n                        var newItem = \$('#newItem');\r\n                        var html = 'Item ' + (iid + 1) + ': <input type=\"text\" class=\"form-control\" style=\"display:inline; width:90%;\" maxlength=\"64\" size=\"80\" name=\"item' + iid + '\" value=\"";
echo __ITEM_EMPTY__;
echo "\" /><hr>';\r\n                        newItem.append(html);\r\n                        iid = iid + 1;\r\n                    }\r\n                </script>\r\n                <input type=\"button\" value=\"Add new\" class=\"btn btn-primary\" onClick=\"addItem();\">\r\n                <input class=\"btn btn-primary\" type=\"button\" onClick=\"popitup('item_hex_generator.php')\" value=\"Item Code Generator\" title=\"Item Code Generator\">\r\n            </td>\r\n        </tr>\r\n    </table>\r\n\r\n    <button type=\"submit\" class=\"btn btn-large btn-block btn-success\" name=\"add_code\" value=\"ok\">Add Code</button>\r\n</form>";
function generateRandomString($length = 10)
{
    global $dB;
    $characters = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $charactersLength = strlen($characters);
    $randomString = "";
    $i = 0;
    while ($i < $length) {
        if ($i != 4 && $i != 9) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        } else {
            $randomString .= "-";
        }
        $i++;
    }
    $check = $dB->query_fetch_single("SELECT code FROM IMPERIAMUCMS_PROMO WHERE code = '" . $randomString . "'");
    if ($check["code"] == NULL) {
        return $randomString;
    }
    generateRandomString(14);
}

?>