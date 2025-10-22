<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

if (!isLoggedIn()) {
    redirect(1, "login");
} else {
    if (!canAccessModule($_SESSION["username"], "smithy", "block")) {
        return NULL;
    }
    echo "\n<div class=\"content_holder\">\n\n    <script>\n        \$(document).ready(function () {\n            \$('html, body').animate({\n                scrollTop: \$('.sub-page-title').offset().top\n            }, 'fast');\n        });\n    </script>\n    <script type=\"text/javascript\" src=\"http://graph.imparts.lv:8080/templates/default/js/jscript-smithy.js\"></script>\n    <link rel=\"stylesheet\" type=\"text/css\" href=\"http://graph.imparts.lv:8080/templates/default/style/smithy.css\"/>\n    <div class=\"sub-page-title\">\n        <div id=\"title\">\n            <h1>Control Panel<p></p><span></span></h1>\n        </div>\n    </div>\n    <div class=\"container_2 account\" align=\"center\">\n        <div class=\"cont-image store\">\n            <div class=\"container_3 account_sub_header\">\n                <div class=\"grad\">\n                    <div class=\"page-title\"><p>Smithy</p></div>\n                    <a href=\"/usercp/items\" style=\"background-image: none;padding: 9px 12px 10px 10px\">Items Inventory</a>\n                    <a href=\"/usercp\">Back to Account</a>\n                </div>\n            </div>\n            <div>\n                ";
    $webshop = Smithy::Config();
    $_GET["filter"] = isset($_GET["filter"]) ? $_GET["filter"] : NULL;
    list($_cat, $_class, $_type, $_category, $_item, $_preview) = array_pad(explode(",", $_GET["filter"], 6), 6, NULL);
    echo "<div class=\"main\">";
    if (isset($_POST["action"]) && $_POST["action"] == "smithy-preview") {
        $SXCount = 0;
        $ExlCount = 0;
        $ErrtelCount = 0;
        $sx = 6;
        while ($sx <= 10) {
            if (isset($_POST["exl_" . $sx])) {
                $SXCount += 1;
            }
            $sx++;
        }
        $ec = 0;
        while ($ec <= 5) {
            if (isset($_POST["exl_" . $ec])) {
                $ExlCount += 1;
            }
            $ec++;
        }
        $er = 1;
        while ($er <= 4) {
            if (isset($_POST["element" . $er]) && $_POST["element" . $er] != "None") {
                $ErrtelCount += 1;
            }
            $er++;
        }
        if ($webshop["SX_opt_limit"] < $SXCount) {
            echo "<div class=\"container_3 red wide fading-notification\" align=\"left\"><span class=\"error_icons attention\"></span><p>ERROR: You can choose only " . $webshop["SX_opt_limit"] . " (SX) Excellent options!</p></div>";
            $displaypreview = false;
        } else {
            if ($webshop["Exl_opt_limit"] < $ExlCount) {
                echo "<div class=\"container_3 red wide fading-notification\" align=\"left\"><span class=\"error_icons attention\"></span><p>ERROR: You can choose only " . $webshop["Exl_opt_limit"] . " Excellent options!</p></div>";
                $displaypreview = false;
            } else {
                if ($ErrtelCount == 0 && $_type == "errtel") {
                    echo "<div class=\"container_3 red wide fading-notification\" align=\"left\"><span class=\"error_icons attention\"></span><p>ERROR: You did not select an option!</p></div>";
                    $displaypreview = false;
                }
            }
        }
    }
    if (isset($_POST["action"]) && $_POST["action"] == "smithy-buy") {
        $GetItemFromDB = Smithy::getSmithy_HexDB($_POST["preview_id"]);
        $credits = 0;
        $payment_type = 0;
        switch ($GetItemFromDB["payment"]) {
            case "W Coins":
                $payment_type = 8;
                $credits = $dB->query_fetch_single("SELECT [WCoin] FROM [T_InGameShop_Point] WHERE [AccountID] = '" . $GetItemFromDB["account"] . "'");
                $credits = !empty($credits["WCoin"]) ? $credits["WCoin"] : 0;
                $removeCredits = "UPDATE [T_InGameShop_Point] SET [WCoin] = ([WCoin] - " . $GetItemFromDB["price"] . ") WHERE [AccountID] = '" . $GetItemFromDB["account"] . "'";
                break;
            case "Goblin Points":
                $payment_type = 9;
                $credits = $dB->query_fetch_single("SELECT [GoblinPoint] FROM [T_InGameShop_Point] WHERE [AccountID] = '" . $GetItemFromDB["account"] . "'");
                $credits = !empty($credits["GoblinPoint"]) ? $credits["GoblinPoint"] : 0;
                $removeCredits = "UPDATE [T_InGameShop_Point] SET [GoblinPoint] = ([GoblinPoint] - " . $GetItemFromDB["price"] . ") WHERE [AccountID] = '" . $GetItemFromDB["account"] . "'";
                break;
            case "Platinum Coins":
                $payment_type = 1;
                $credits = $dB->query_fetch_single("SELECT [platinum] FROM [MEMB_CREDITS] WHERE [memb___id] = '" . $GetItemFromDB["account"] . "'");
                $credits = !empty($credits["platinum"]) ? $credits["platinum"] : 0;
                $removeCredits = "UPDATE [MEMB_CREDITS] SET [platinum] = ([platinum] - " . $GetItemFromDB["price"] . "), [platinum_used] = ([platinum_used] + " . $GetItemFromDB["price"] . ") WHERE [memb___id] = '" . $GetItemFromDB["account"] . "'";
                break;
            case "Gold Coins":
                $payment_type = 2;
                $credits = $dB->query_fetch_single("SELECT [gold] FROM [MEMB_CREDITS] WHERE [memb___id] = '" . $GetItemFromDB["account"] . "'");
                $credits = !empty($credits["gold"]) ? $credits["gold"] : 0;
                $removeCredits = "UPDATE [MEMB_CREDITS] SET [gold] = ([gold] - " . $GetItemFromDB["price"] . "), [gold_used] = ([gold_used] + " . $GetItemFromDB["price"] . ") WHERE [memb___id] = '" . $GetItemFromDB["account"] . "'";
                break;
            case "Silver Coins":
                $payment_type = 4;
                $credits = $dB->query_fetch_single("SELECT [silver] FROM [MEMB_CREDITS] WHERE [memb___id] = '" . $GetItemFromDB["account"] . "'");
                $credits = !empty($credits["silver"]) ? $credits["silver"] : 0;
                $removeCredits = "UPDATE [MEMB_CREDITS] SET [silver] = ([silver] - " . $GetItemFromDB["price"] . "), [silver_used] = ([silver_used] + " . $GetItemFromDB["price"] . ") WHERE [memb___id] = '" . $GetItemFromDB["account"] . "'";
                break;
            default:
                $credits = strpos($credits, ".") ? substr($credits, 0, strpos($credits, ".")) : $credits;
                if (!isset($GetItemFromDB["id"])) {
                    echo "<div class=\"container_3 red wide fading-notification\" align=\"left\"><span class=\"error_icons attention\"></span><p>ERROR: Item not found, try again.</p></div>";
                    $displaypreview = false;
                } else {
                    if ($credits <= $GetItemFromDB["price"]) {
                        echo "<div class=\"container_3 red wide fading-notification\" align=\"left\"><span class=\"error_icons attention\"></span><p>ERROR: You don't have enough " . $GetItemFromDB["payment"] . " to buy this item.</p></div>";
                        $displaypreview = false;
                    } else {
                        $item_newsn = $dB->query_fetch_single("exec WZ_GetItemSerial");
                        $item_newsn = sprintf("%08X", $item_newsn[""], 0);
                        $item_sn = substr($GetItemFromDB["item"], 32, 8);
                        $item = str_replace($item_sn, $item_newsn, $GetItemFromDB["item"]);
                        $update = $dB->query($removeCredits);
                        switch ($GetItemFromDB["type"]) {
                            case "muun":
                                break;
                            default:
                                $date = date("Y-m-d h:i:s", time());
                                $insert = $dB->query("INSERT INTO IMPERIAMUCMS_WEBSHOP_ITEMS_INVENTORY(AccountID,item,price,price_type,date,status,type,giftFrom) VALUES(?,?,?,?,?,?,?,?)", [$_SESSION["username"], $item, $GetItemFromDB["price"], $payment_type, $date, "0", "1", NULL]);
                                echo "<div class=\"container_3 green wide fading-notification\" align=\"left\"><span class=\"error_icons success\"></span><p>SUCCESS! Item has been successfully bought!</p></div>";
                                $displaypreview = false;
                        }
                    }
                }
        }
    }
    $categoriesType = $webshop["excellent_ancient"] == 1 || $webshop["excellent_socket"] == 1 ? "simple" : "default";
    echo "<div class=\"three\"><div>";
    $cat = !empty($_cat) ? $_cat : "excellent";
    $categories = Smithy::getSmithy_Categories($categoriesType);
    if (!Smithy::checkCategories($cat, $categories)) {
        exit(header("Location: /" . $webshop["url"]));
    }
    $checkActiveClass = isset($_class) ? "," . $_class : NULL;
    foreach ($categories as $category) {
        $categoryChecked = $category["url"] == $cat ? " active" : NULL;
        echo "<a href=\"?filter=" . $category["url"] . "\" class=\"non" . $categoryChecked . "\">" . $category["name"] . "</a>";
    }
    echo "</div><div class=\"center smithy-class\">";
    $type = isset($_cat) && $_cat == "elemental" || isset($_cat) && $_cat == "pets" ? "all" : (isset($_class) ? $_class : "dk");
    $classes = Smithy::getSmithy_Classes($cat);
    if (isset($_class) && !Smithy::checkCategories($type, $classes)) {
        exit(header("Location: /" . $webshop["url"]));
    }
    foreach ($classes as $class) {
        $classChecked = $class["url"] == $type ? "active" : NULL;
        $classChecked = $cat == "pets" || $cat == "elemental" ? "active" : $classChecked;
        echo "<a href=\"?filter=" . $cat . "," . $class["url"] . "\" class=\"nice-button " . $classChecked . "\">" . $class["name"] . "</a>";
    }
    echo "</div></div><table id=\"smithy\"><tr><td id=\"smithy-filter\"><table class=\"topics\"><tr><td class=\"smithy-content\"><div id=\"smithy-type\" class=\"center\">";
    $subtype = isset($_type) ? $_type : "weapons";
    $categoryType = Smithy::getSmithy_CategoryType($cat, $type);
    if (isset($_type) && !Smithy::checkCategories($subtype, $categoryType)) {
        exit(header("Location: /" . $webshop["url"]));
    }
    foreach ($categoryType as $i => $subcategory) {
        $categoryTypeChecked = $subcategory["url"] == $subtype ? " active" : NULL;
        if ($i == 0 && !isset($_type)) {
            $categoryTypeChecked = " active";
            $subtype = $subcategory["url"];
        }
        echo "<a href=\"?filter=" . $cat . "," . $type . "," . $subcategory["url"] . "\" class=\"mirror non" . $categoryTypeChecked . "\">" . $subcategory["name"] . "</a>";
    }
    echo "</div><div class=\"spacer_2px\"></div>";
    echo "<div style=\"width:" . ($subtype == "pentagram" ? "488px" : "440px") . ";height:154px;margin:0 auto;\">";
    if ($subtype == "muun") {
        echo "<p class=\"center\">Section under construction.</p>";
        $subtype = NULL;
    }
    $categoryList = Smithy::getSmithy_CategoryList($cat, $type, $subtype);
    foreach ($categoryList as $categoryItems) {
        echo "<div class=\"filter-left\">";
        $categoryItems["name"] = str_replace(["Rings", "Pendants"], "Items", $categoryItems["name"]);
        echo "<div class=\"smithy-select\" id=\"" . $categoryItems["url"] . "\"><p class=\"sel-value\">" . $categoryItems["name"] . "</p></div>";
        $smithyselectsublist = ["sets", "pentagram", "errtel"];
        $CheckcategoryIUrl = str_replace(["rings", "pendants", "classic", "muun"], "items", $categoryItems["url"]);
        $smithyselectlist = isset($_category) && $_category == $CheckcategoryIUrl || isset($_category) && in_array($categoryItems["url"], $smithyselectsublist) ? " style=\"display: block;\"" : NULL;
        echo "<div class=\"smithy-select-list\" id=\"" . $categoryItems["url"] . "-list\"" . $smithyselectlist . ">";
        $items = Smithy::getSmithy_ItemsList($cat, $type, $subtype, $categoryItems["url"]);
        foreach ($items["cat"] as $item) {
            if ($subtype == "sets") {
                $checkedItem = isset($_item) && $_item == $item["item_id"] ? " smithy-active" : NULL;
            } else {
                if ($cat == "ancient") {
                    $test1 = str_replace("-", "X", $_item);
                    $test2 = $item["item_id"] . "X" . $item["item_cat"];
                    $checkedItem = isset($_item) && $test1 == $test2 ? " smithy-active" : NULL;
                } else {
                    if ($cat == "elemental" || $cat == "pets") {
                        $checkedItem = isset($_category) && isset($_item) && $_item == $item["item_id"] ? " smithy-active" : NULL;
                    } else {
                        $checkedItem = isset($_category) && isset($_item) && $_category == $categoryItems["url"] && $_item == $item["item_id"] ? " smithy-active" : NULL;
                    }
                }
            }
            $item["name"] = $subtype == "sets" ? str_replace("Armor", "Set", $item["name"]) : $item["name"];
            $categoryItems["url"] = $subtype == "sets" ? str_replace("sets", "armors", $categoryItems["url"]) : ($subtype == "rings" || $subtype == "pendants" || $subtype == "classic" || $subtype == "muun" ? str_replace(["rings", "pendants", "classic", "muun"], "items", $categoryItems["url"]) : ($cat == "elemental" ? str_replace(["pentagram", "errtel"], "fire", $categoryItems["url"]) : $categoryItems["url"]));
            $categoryItems["url"] = $item["name"] == "Cape of Lord" ? "items" : $categoryItems["url"];
            $item["item_id"] = isset($item["item_cat"]) ? $item["item_id"] . "-" . $item["item_cat"] : $item["item_id"];
            $subSets = $subtype == "sets" ? " id=\"sub-sets-" . $item["item_id"] . "\"" : ($cat == "elemental" ? " id=\"sub-pentagram-" . $item["item_id"] . "\"" : ($cat == "pets" ? " id=\"sub-" . $subtype . "-" . $item["item_id"] . "\"" : NULL));
            echo "<a href=\"?filter=" . $cat . "," . $type . "," . $subtype . "," . $categoryItems["url"] . "," . $item["item_id"] . "\"" . $subSets . " class=\"non" . $checkedItem . "\">" . $item["name"] . "</a>";
        }
        echo "</div>";
        foreach ($items["cat"] as $subcheck) {
            if ($subtype == "sets") {
                $smithysetitem = isset($_item) && $subcheck["item_id"] == $_item ? " style=\"display: block;\"" : NULL;
                echo "<div class=\"smithy-list\" id=\"sets-" . $subcheck["item_id"] . "\"" . $smithysetitem . ">";
                $subitems = Smithy::getSmithy_ItemsList($cat, $type, "subsets", "sets", $subcheck["item_id"]);
                foreach ($subitems["subcat"] as $subitem) {
                    switch ($subitem["item_cat"]) {
                        case "7":
                            $itemtype = "helms";
                            break;
                        case "8":
                            $itemtype = "armors";
                            break;
                        case "9":
                            $itemtype = "pants";
                            break;
                        case "10":
                            $itemtype = "gloves";
                            break;
                        case "11":
                            $itemtype = "boots";
                            break;
                        default:
                            $checkedSubItem = isset($_item) && $_item == $subcheck["item_id"] && $itemtype == $_category ? " smithy-active" : NULL;
                            echo "<a href=\"?filter=" . $cat . "," . $type . "," . $subtype . "," . $itemtype . "," . $subcheck["item_id"] . "\" class=\"non" . $checkedSubItem . "\">" . $subitem["name"] . "</a>";
                    }
                }
                echo "</div>";
            }
            if ($cat == "elemental") {
                $smithysetitem = isset($_item) && $subcheck["item_id"] == $_item ? " style=\"display: block;\"" : NULL;
                echo "<div class=\"smithy-list\" id=\"pentagram-" . $subcheck["item_id"] . "\"" . $smithysetitem . ">";
                $elementalitems = Smithy::getSmithy_elementaltype();
                foreach ($elementalitems as $element) {
                    $checkedSubItem = isset($_item) && $_item == $subcheck["item_id"] && $element["url"] == $_category ? " smithy-active" : NULL;
                    echo "<a href=\"?filter=" . $cat . "," . $type . "," . $subtype . "," . $element["url"] . "," . $subcheck["item_id"] . "\" class=\"non" . $checkedSubItem . "\">" . $element["name"] . "</a>";
                }
                echo "</div>";
            }
            if ($cat == "pets") {
                $smithysetitem = isset($_item) && $subcheck["item_id"] == $_item ? " style=\"display: block;\"" : NULL;
                echo "<div class=\"smithy-list\" id=\"" . $subtype . "-" . $subcheck["item_id"] . "\"" . $smithysetitem . ">";
                $petsitems = Smithy::getSmithy_pets($subcheck["item_id"]);
                foreach ($petsitems as $p => $pets) {
                    $checkedSubItem = isset($_preview) && $p == $_preview && $subcheck["item_id"] == $_item ? " smithy-active" : NULL;
                    echo "<a href=\"?filter=" . $cat . "," . $type . "," . $subtype . "," . $categoryItems["url"] . "," . $subcheck["item_id"] . "," . $p . "\" class=\"non" . $checkedSubItem . "\">" . $pets["name"] . "</a>";
                }
                echo "</div>";
            }
        }
        echo "</div>";
    }
    echo "<div class=\"clear\"></div></div></td></tr></table></td></tr>";
    if (isset($_category) && isset($_item)) {
        $market = Smithy::getSmithy_Item($cat, $type, $subtype, $_category, $_item);
        if (isset($_preview)) {
            $checkItemId = preg_replace("/[^0-9]/", "", $_item);
            $ItemPets = Smithy::getSmithy_pets($checkItemId);
            $ItemPets = !empty($ItemPets[$_preview]) ? $ItemPets[$_preview] : $ItemPets[0];
            if (!empty($ItemPets)) {
                $market["name"] = $ItemPets["name"];
                $market["price"] = $ItemPets["price"];
            }
            $ItemPetInfo = !empty($ItemPets["itemInfo"]) ? $ItemPets["itemInfo"] : NULL;
        }
        echo "<tr><td>";
        if ($market) {
            if (isset($_POST["action"]) && $_POST["action"] == "smithy-preview" && !isset($displaypreview)) {
                $createItem = new Items();
                $pt = $market["payment_type"];
                $ptp = $_POST["item_percentID"];
                $payment["percent"] = !empty($webshop["payment_type"][$pt][$ptp]["percent"]) ? $webshop["payment_type"][$pt][$ptp]["percent"] : $webshop["payment_type"][$pt][0]["percent"];
                $payment["name"] = !empty($webshop["payment_type"][$pt][$ptp]["name"]) ? $webshop["payment_type"][$pt][$ptp]["name"] : $webshop["payment_type"][$pt][0]["name"];
                $payment["percent"] = "1." . $payment["percent"];
                $BB = 0;
                $ZZ = 0;
                $createItemId = 255 < $market["item_id"] ? $market["item_id"] - 256 : $market["item_id"];
                $AA = sprintf("%02X", $createItemId, 0);
                $CC = !empty($market["elemental"]) ? sprintf("%02X", "5", 0) : sprintf("%02X", "255", 0);
                $DDEE = sprintf("%08X", "10053715", 0);
                $FF = $market["item_cat"] * 16;
                $HH = 255 < $market["item_id"] ? 128 : 0;
                $item_price = intval($market["price"] * $payment["percent"]);
                if (isset($_POST["level"]) && is_numeric($_POST["level"]) && 0 < $_POST["level"]) {
                    $BB += $_POST["level"] * 8;
                    $item_price += $_POST["level"] == $market["lvl"] ? intval($webshop["lvl_price"] * ($_POST["level"] - 9) * $payment["percent"]) * 2 : intval($webshop["lvl_price"] * ($_POST["level"] - 9)) * $payment["percent"];
                }
                if (isset($_POST["opt"]) && is_numeric($_POST["opt"]) && 0 < $_POST["opt"] && $_POST["opt"] <= 7) {
                    if (4 <= $_POST["opt"]) {
                        $BB += $_POST["opt"] - 4;
                        $HH += 64;
                    } else {
                        $BB += $_POST["opt"];
                    }
                    $item_price += intval($webshop["opt_price"] * $_POST["opt"] * $payment["percent"]);
                }
                if (isset($_POST["skill"]) && $_POST["skill"] == 1) {
                    $BB += 128;
                    $item_price += intval($webshop["skill"] * $payment["percent"]);
                }
                if (isset($_POST["luck"]) && $_POST["luck"] == 1) {
                    $BB += 4;
                    $item_price += intval($webshop["luck"] * $payment["percent"]);
                }
                if (isset($_POST["pvp"]) && $_POST["pvp"] == 1) {
                    $FF = $FF + 8;
                    $item_price += intval($webshop["refinery"] * $payment["percent"]);
                }
                if ($BB < 0) {
                    $BB = 0;
                }
                if (!empty($market["excellent"])) {
                    if (!empty($market["excellent_additional_sets"]) && $market["excellent_additional_sets"] == 1) {
                        if (isset($_POST["exl_3"])) {
                            $HH += 4;
                            $item_price += intval($market["excellent"][3]["price"] * $payment["percent"]);
                        }
                        if (isset($_POST["exl_4"])) {
                            $HH += 2;
                            $item_price += intval($market["excellent"][4]["price"] * $payment["percent"]);
                        }
                    } else {
                        if (isset($_POST["exl_0"])) {
                            if ($subtype == "wings") {
                                $HH += 1;
                            } else {
                                $HH += 32;
                                $item_price += intval($market["excellent"][0]["price"] * $payment["percent"]);
                            }
                        }
                        if (isset($_POST["exl_1"])) {
                            if ($subtype == "wings") {
                                $HH += 2;
                            } else {
                                $HH += 16;
                                $item_price += intval($market["excellent"][1]["price"] * $payment["percent"]);
                            }
                        }
                        if (isset($_POST["exl_2"])) {
                            if ($subtype == "wings") {
                                $HH += 4;
                            } else {
                                $HH += 8;
                                $item_price += intval($market["excellent"][2]["price"] * $payment["percent"]);
                            }
                        }
                        if (isset($_POST["exl_3"])) {
                            if ($subtype == "wings") {
                                $HH += 8;
                            } else {
                                $HH += 4;
                                $item_price += intval($market["excellent"][3]["price"] * $payment["percent"]);
                            }
                        }
                        if (isset($_POST["exl_4"])) {
                            if ($subtype == "wings") {
                                $HH += 16;
                            } else {
                                $HH += 2;
                                $item_price += intval($market["excellent"][4]["price"] * $payment["percent"]);
                            }
                        }
                        if (isset($_POST["exl_5"])) {
                            if ($subtype == "wings") {
                                $HH += 32;
                            } else {
                                $HH += 1;
                                $item_price += intval($market["excellent"][5]["price"] * $payment["percent"]);
                            }
                        }
                    }
                    if (100 <= config("server_files_season", true)) {
                        $SX1 = NULL;
                        $SX2 = NULL;
                        $SX3 = NULL;
                        $SX4 = NULL;
                        if (isset($_POST["exl_6"])) {
                            $SX1 = "06";
                            $item_price += intval($market["excellent_additional"][0]["price"] * $payment["percent"]);
                        }
                        if (isset($_POST["exl_7"])) {
                            $SX2 = "07";
                            $item_price += intval($market["excellent_additional"][1]["price"] * $payment["percent"]);
                        }
                        if (isset($_POST["exl_8"])) {
                            $SX3 = "08";
                            $item_price += intval($market["excellent_additional"][2]["price"] * $payment["percent"]);
                        }
                        if (isset($_POST["exl_9"])) {
                            $SX4 = "09";
                            $item_price += intval($market["excellent_additional"][3]["price"] * $payment["percent"]);
                        }
                        $SXExl = $SX1 . $SX2 . $SX3 . $SX4;
                        $SXExlCount = 10 - strlen($SXExl);
                        $SXExlRepeat = str_repeat("F", $SXExlCount);
                        $HE = "00" . $SXExl . $SXExlRepeat;
                    }
                }
                if (!empty($market["elemental"])) {
                    switch ($_category) {
                        case "water":
                            $S1 = "12";
                            break;
                        case "earth":
                            $S1 = "13";
                            break;
                        case "wind":
                            $S1 = "14";
                            break;
                        case "darkness":
                            $S1 = "15";
                            break;
                        default:
                            $S1 = "11";
                            $S2 = "FE";
                            if (isset($_POST["slot1"])) {
                                $S3 = "FE";
                                $item_price += intval($market["elemental"][1]["price"] * $payment["percent"]);
                            }
                            if (isset($_POST["slot2"])) {
                                $S4 = "FE";
                                $item_price += intval($market["elemental"][2]["price"] * $payment["percent"]);
                            }
                            if (isset($_POST["slot3"])) {
                                $S5 = "FE";
                                $item_price += intval($market["elemental"][3]["price"] * $payment["percent"]);
                            }
                            if (isset($_POST["slot4"])) {
                                $S6 = "FE";
                                $item_price += intval($market["elemental"][4]["price"] * $payment["percent"]);
                            }
                    }
                }
                if (!empty($market["harmony"]) && $webshop["harmony_active"] == 1) {
                    $harmonyCount = count($market["harmony"]);
                    if (is_numeric($_POST["harmony"]) && 0 < $_POST["harmony"] && $_POST["harmony"] < $harmonyCount) {
                        $harmony = $_POST["harmony"];
                        $hoption = $market["harmony"][$harmony]["hoption"];
                        $hvalue = $market["harmony"][$harmony]["hvalue"];
                        if (!empty($hoption) && !empty($hvalue)) {
                            $S1 = sprintf("%01X", $hoption, 0) . sprintf("%01X", $hvalue, 0);
                            $HE = isset($HE) ? $S1 . substr($HE, 2) : $HE;
                            $item_price += intval($market["harmony"][$harmony]["price"] * $payment["percent"]);
                        }
                    }
                }
                if (!empty($market["socket"])) {
                    if (isset($_POST["socket1"]) && is_numeric($_POST["socket1"])) {
                        $S2value = $_POST["socket1"];
                        $S2 = sprintf("%02X", $market["socket"][$S2value]["socket_id"], 0);
                        $item_price += intval($market["socket"][$S2value]["socket_price"] * $payment["percent"]);
                    } else {
                        $S2 = "FE";
                    }
                    if (isset($_POST["socket2"]) && is_numeric($_POST["socket2"])) {
                        $S3value = $_POST["socket2"];
                        $S3 = sprintf("%02X", $market["socket"][$S3value]["socket_id"], 0);
                        $item_price += intval($market["socket"][$S3value]["socket_price"] * $payment["percent"]);
                    } else {
                        $S3 = "FE";
                    }
                    if (isset($_POST["socket3"]) && is_numeric($_POST["socket3"])) {
                        $S4value = $_POST["socket3"];
                        $S4 = sprintf("%02X", $market["socket"][$S4value]["socket_id"], 0);
                        $item_price += intval($market["socket"][$S4value]["socket_price"] * $payment["percent"]);
                    } else {
                        $S4 = "FE";
                    }
                    if (isset($_POST["socket4"]) && is_numeric($_POST["socket4"])) {
                        $S5value = $_POST["socket4"];
                        $S5 = sprintf("%02X", $market["socket"][$S5value]["socket_id"], 0);
                        $item_price += intval($market["socket"][$S5value]["socket_price"] * $payment["percent"]);
                    } else {
                        $S5 = "FE";
                    }
                    if (isset($_POST["socket5"]) && is_numeric($_POST["socket5"])) {
                        $S6value = $_POST["socket5"];
                        $S6 = sprintf("%02X", $market["socket"][$S6value]["socket_id"], 0);
                        $item_price += intval($market["socket"][$S6value]["socket_price"] * $payment["percent"]);
                    } else {
                        $S6 = "FE";
                    }
                    if (isset($_POST["socket_bonus"]) && is_numeric($_POST["socket1"]) && is_numeric($_POST["socket2"]) && is_numeric($_POST["socket3"]) && is_numeric($_POST["socket_bonus"])) {
                        $S1value = $_POST["socket_bonus"];
                        $S1 = sprintf("%02X", $market["socket_bonus"][$S1value]["element_id"], 0);
                        $item_price += intval($market["socket_bonus"][$S1value]["price"] * $payment["percent"]);
                    }
                }
                if (!empty($market["errtel"])) {
                    switch ($_category) {
                        case "water":
                            $S1 = "12";
                            break;
                        case "earth":
                            $S1 = "13";
                            break;
                        case "wind":
                            $S1 = "14";
                            break;
                        case "darkness":
                            $S1 = "15";
                            break;
                        default:
                            $S1 = "11";
                            if (isset($_POST["element1"]) && is_numeric($_POST["element1"])) {
                                $elementid = is_numeric($_POST["element1"]) ? $_POST["element1"] : 0;
                                $elementlvl = is_numeric($_POST["element_lvl1"]) ? $_POST["element_lvl1"] : 0;
                                $elementlvl = $elementlvl == 10 ? "A" : $elementlvl;
                                $S2 = $elementlvl . $elementid;
                                $ei = $elementid - 1;
                                $er = $_POST["element_lvl1"];
                                $item_price += intval($market["errtel"][0][$ei]["price"] * $payment["percent"]);
                                $item_price += intval($market["errtel_rank"][0][$er]["price"] * $payment["percent"]);
                            }
                            if (isset($_POST["element2"]) && is_numeric($_POST["element2"])) {
                                $elementid = is_numeric($_POST["element2"]) ? $_POST["element2"] : 0;
                                $elementlvl = is_numeric($_POST["element_lvl2"]) ? $_POST["element_lvl2"] : 0;
                                $elementlvl = $elementlvl == 10 ? "A" : $elementlvl;
                                $S3 = $elementlvl . $elementid;
                                $ei = $elementid - 1;
                                $er = $_POST["element_lvl2"];
                                $item_price += intval($market["errtel"][1][$ei]["price"] * $payment["percent"]);
                                $item_price += intval($market["errtel_rank"][0][$er]["price"] * $payment["percent"]);
                            }
                            if (isset($_POST["element3"]) && is_numeric($_POST["element3"])) {
                                $elementid = is_numeric($_POST["element3"]) ? $_POST["element3"] : 0;
                                $elementlvl = is_numeric($_POST["element_lvl3"]) ? $_POST["element_lvl3"] : 0;
                                $elementlvl = $elementlvl == 10 ? "A" : $elementlvl;
                                $S4 = $elementlvl . $elementid;
                                $ei = $elementid - 1;
                                $er = $_POST["element_lvl3"];
                                $item_price += intval($market["errtel"][2][$ei]["price"] * $payment["percent"]);
                                $item_price += intval($market["errtel_rank"][0][$er]["price"] * $payment["percent"]);
                            }
                            if (isset($_POST["element4"]) && is_numeric($_POST["element4"])) {
                                $elementid = is_numeric($_POST["element4"]) ? $_POST["element4"] : 0;
                                $elementlvl = is_numeric($_POST["element_lvl4"]) ? $_POST["element_lvl4"] : 0;
                                $elementlvl = $elementlvl == 10 ? "A" : $elementlvl;
                                $S5 = $elementlvl . $elementid;
                                $ei = $elementid - 1;
                                $er = $_POST["element_lvl4"];
                                $item_price += intval($market["errtel"][3][$ei]["price"] * $payment["percent"]);
                                $item_price += intval($market["errtel_rank"][0][$er]["price"] * $payment["percent"]);
                            }
                            if (isset($_POST["element5"]) && is_numeric($_POST["element5"])) {
                                $elementid = is_numeric($_POST["element5"]) ? $_POST["element5"] : 0;
                                $elementlvl = is_numeric($_POST["element_lvl5"]) ? $_POST["element_lvl5"] : 0;
                                $elementlvl = $elementlvl == 10 ? "A" : $elementlvl;
                                $S6 = $elementlvl . $elementid;
                                $ei = $elementid - 1;
                                $er = $_POST["element_lvl5"];
                                $item_price += intval($market["errtel"][4][$ei]["price"] * $payment["percent"]);
                                $item_price += intval($market["errtel_rank"][0][$er]["price"] * $payment["percent"]);
                            }
                    }
                }
                $HH = sprintf("%02X", $HH, 0);
                $BB = sprintf("%02X", $BB, 0);
                $ZZ = sprintf("%02X", $ZZ, 0);
                $FF = sprintf("%02X", $FF, 0);
                if (!empty($market["ancient"])) {
                    if ($webshop["excellent_ancient"] == 1 && $cat != "ancient") {
                        if (isset($_POST["excellent_ancient"])) {
                            $item_price += intval($webshop["excellent_ancient_price"] * $payment["percent"]);
                            $ZZ = $market["ancient_tier"] == 2 ? "06" : ($market["ancient_tier"] == 3 ? "20" : ($market["ancient_tier"] == 4 ? "24" : "05"));
                        }
                    } else {
                        $ZZ = $market["ancient_tier"] == 2 ? "06" : ($market["ancient_tier"] == 3 ? "20" : ($market["ancient_tier"] == 4 ? "24" : "05"));
                    }
                }
                $S1 = isset($S1) ? $S1 : "FF";
                $S2 = isset($S2) ? $S2 : "FF";
                $S3 = isset($S3) ? $S3 : "FF";
                $S4 = isset($S4) ? $S4 : "FF";
                $S5 = isset($S5) ? $S5 : "FF";
                $S6 = isset($S6) ? $S6 : "FF";
                $HE = isset($HE) && !empty($HE) ? $HE : $S1 . $S2 . $S3 . $S4 . $S5 . $S6;
                $DDEB = "00000000";
                $NOTINUSE = "FFFFFFFFFFFFFFFFFFFFFFFF";
                $newitem = isset($ItemPets["hex"]) ? $ItemPets["hex"] : $AA . $BB . $CC . $DDEB . $HH . $ZZ . $FF . $HE . $DDEE . $NOTINUSE;
                $createItem = $createItem->ItemInfo($newitem);
                $createItem["level"] = 0 < $createItem["level"] ? " +" . $createItem["level"] : NULL;
                if ($createItem["exl"]) {
                    $createItem["exl"] = "<div class=\"item_exc\">" . str_replace("^^", "<br>", $createItem["exl"]) . "</div>";
                }
                echo "<div class=\"shop-item-box\">";
                echo "<div class=\"item_name\">" . $createItem["name"] . $createItem["level"] . "</div>";
                echo "<img src=\"" . $createItem["thumb"] . "\" alt=\"\"><br />";
                echo $createItem["luck"] . $createItem["skill"] . $createItem["exl"] . $createItem["socket"] . $createItem["anc"] . $createItem["harm"] . $createItem["jog"] . $createItem["opt"] . "<br><font color=darkred>" . $createItem["classReq"] . "</font>";
                $account = $subtype == "muun" ? $_POST["char"] : $_SESSION["username"];
                $created_id = Smithy::getSmithy_addHextoDB($newitem, $item_price, $account, time(), $subtype, $payment["name"]);
                $_previewID = isset($_preview) ? "," . $_preview : NULL;
                echo "</div>";
                echo "<form action=\"?filter=" . $cat . "," . $type . "," . $subtype . "," . $_category . "," . $_item . $_previewID . "\" method=\"POST\">\n\t\t\t\t\t<div class=\"smithy-coins\">\n\t\t\t\t\t <p>Cost:  <span id=\"smithy-cost\">" . number_format($item_price) . "</span> " . $payment["name"] . "</p>\n\t\t\t\t\t  <input type=\"hidden\" name=\"preview_id\" value=\"" . $created_id . "\">\n\t\t\t\t\t  <input type=\"hidden\" name=\"action\" value=\"smithy-buy\">\n\t\t\t\t\t  <input class=\"nice-button rightfloat confirm\" id=\"smithyCreate\" type=\"submit\" name=\"enter\" value=\"Buy\">\n\t\t\t\t\t  <a class=\"nice-button rightfloat\" href=\"?filter=" . $cat . "," . $type . "," . $subtype . "," . $_category . "," . $_item . $_previewID . "\">Return</a>\n\t\t\t\t\t</div>\n\t\t\t\t\t<div class=\"clear\"></div>\n\t\t\t\t  </form>";
            } else {
                $_previewID = isset($_preview) ? "," . $_preview : NULL;
                echo "<form action=\"?filter=" . $cat . "," . $type . "," . $subtype . "," . $_category . "," . $_item . $_previewID . "\" method=\"POST\">";
                echo "<table class=\"topics\" style=\"border-top: 5px solid #231a16;\"><tr>";
                echo "<td class=\"smithy-image\">\n\t\t\t\t\t<div class=\"smithy-item\">\n\t\t\t\t\t  <div style=\"width:" . $market["X"] * 32 . "px;height:" . $market["Y"] * 32 . "px;\"></div>\n\t\t\t\t\t  <img src=\"http://warius.net/images/items/" . $market["image"] . "\" alt=\"\">\n\t\t\t\t\t</div>\n\t\t\t\t\t<span>" . $market["name"] . "</span>\n\t\t\t\t  </td>";
                echo "<td class=\"smithy-content\"><div><div class=\"three\" style=\"margin-bottom: 20px;\"><div>";
                $pt = $market["payment_type"];
                foreach ($webshop["payment_type"][$pt] as $p => $payment) {
                    $activePayment = $p == 0 ? " active" : NULL;
                    echo "<a class=\"percentage non" . $activePayment . "\" rel=\"" . $p . "\" percent=\"" . $payment["percent"] . "\" color=\"" . $payment["color"] . "\" style=\"cursor: pointer;\">" . $payment["name"] . "</a>";
                }
                echo "<input id=\"item_percentID\" name=\"item_percentID\" type=\"hidden\" value=\"0\" />";
                echo "<input id=\"item_percetCost\" name=\"item_percetCost\" type=\"hidden\" value=\"" . $webshop["payment_type"][$pt][0]["percent"] . "\" />";
                echo "</div></div><div id=\"smithy-options\">";
                echo "<input id=\"item_cost\" name=\"item_cost\" type=\"hidden\" value=\"" . $market["price"] . "\" />";
                echo "<div id=\"asunder\">";
                if (0 < $market["lvl"]) {
                    $lvl_count = 0;
                    $x = $webshop["start_lvl"];
                    echo "<select name=\"level\" class=\"select-box smithyCost\">";
                    echo "<option cost=\"0\">" . $market["name"] . " +0</option>";
                    while ($x <= $market["lvl"]) {
                        $lvl_count += 1;
                        $lvl_cost = $webshop["lvl_price"] * $lvl_count;
                        $lvl_cost = $x == $market["lvl"] ? $lvl_cost * 2 : $lvl_cost;
                        echo "<option value=\"" . $x . "\" cost=\"" . $lvl_cost . "\">" . $market["name"] . " +" . $x . "</option>";
                        $x++;
                    }
                    echo "</select>";
                }
                if (0 < $market["opt"]) {
                    $x = $webshop["start_opt"];
                    echo "<select name=\"opt\" class=\"select-box smithyCost\">";
                    echo "<option cost=\"0\">" . $market["opt_type"] . " +0</option>";
                    while ($x <= $market["opt"]) {
                        $lvl_cost = $webshop["opt_price"] * $x;
                        if ($x == 4 || $x == 7) {
                            echo "<option value=\"" . $x . "\" cost=\"" . $lvl_cost . "\">" . $market["opt_type"] . " +" . $x * 4 . "</option>";
                        }
                        $x++;
                    }
                    echo "</select>";
                }
                echo "</div><div class=\"spacer1\"></div>";
                if (!empty($market["notice"])) {
                    echo "<p class=\"color1 small\">" . $market["notice"] . "</p>";
                }
                echo "<div class=\"item_exc\"><ul class=\"leftUl\">";
                if (0 < $market["skill"]) {
                    echo "<li><label><input class=\"smithyCost\" name=\"skill\" type=\"checkbox\" value=\"1\" cost=\"" . $webshop["skill"] . "\"> - Skill</label></li>";
                }
                if (0 < $market["luck"]) {
                    echo "<li><label><input class=\"smithyCost\" name=\"luck\" type=\"checkbox\" value=\"1\" cost=\"" . $webshop["luck"] . "\"> - Luck</label></li>";
                }
                if (0 < $market["refinary"]) {
                    echo "<li class=\"item_pvp\"><label><input class=\"smithyCost\" name=\"pvp\" type=\"checkbox\" value=\"1\" cost=\"" . $webshop["refinery"] . "\"> - Refinery</label></li>";
                }
                echo "</ul></div>";
                if (!isset($_preview)) {
                    echo "<div class=\"spacer_2px\"></div>";
                }
                if (!empty($market["excellent"])) {
                    echo "<ul>";
                    foreach ($market["excellent"] as $e => $excellent) {
                        echo "<li class=\"item_name_exc\"><label><input class=\"smithyCost\" name=\"exl_" . $e . "\" type=\"checkbox\" cost=\"" . $excellent["price"] . "\" value=\"1\"> - " . $excellent["name"] . "</label></li>";
                    }
                    if (!empty($market["excellent_additional"])) {
                        $e = $e + 1;
                        echo "<div class=\"spacer_2px\"></div><br>";
                        foreach ($market["excellent_additional"] as $excellent_additional) {
                            echo "<li class=\"item_name_exc\"><label><input class=\"smithyCost\" name=\"exl_" . $e . "\" type=\"checkbox\" cost=\"" . $excellent_additional["price"] . "\" value=\"1\"> - " . $excellent_additional["name"] . "</label></li>";
                            $e++;
                        }
                    }
                    echo "</ul>";
                }
                if ($market["ancient"]) {
                    if ($webshop["excellent_ancient"] == 1 && $cat != "ancient") {
                        echo "<div class=\"spacer_2px\"></div>";
                        echo "<label><input class=\"smithyCost\" name=\"excellent_ancient\" type=\"checkbox\" cost=\"" . $webshop["excellent_ancient_price"] . "\" value=\"1\"> - Use Ancient " . $market["ancient_name"] . " set Options</label>";
                    }
                    echo "<div class=\"item_name_acient1\">";
                    echo preg_replace("/<font color=FFCC66>.+?<\\/font><br><br>/i", "", $market["ancient"]);
                    echo "</div><br>";
                }
                if ($market["socket"]) {
                    $s = 1;
                    while ($s <= $webshop["socket_limit"]) {
                        echo "<select name=\"socket" . $s . "\" class=\"select-box smithyCost\">";
                        echo "<option cost=\"0\">No item application</option>";
                        foreach ($market["socket"] as $sid => $socket) {
                            $elementname = explode(" ", $socket["socket_name"]);
                            $elementname = strtolower($elementname[0]);
                            $lastseed = Smithy::getSmithy_SocketSeed($socket["seed"]);
                            $ls = $lastseed == $socket["id"] ? "2" : "1";
                            echo "<option value=\"" . $sid . "\" cost=\"" . $socket["socket_price"] . "\" element=\"" . $elementname . $ls . "\">" . $socket["socket_name"] . "</option>";
                        }
                        echo "</select><div class=\"spacer\"></div>";
                        $s++;
                    }
                    echo "<div class=\"spacer2\"></div><select name=\"socket_bonus\" class=\"select-box smithyCost smithyElements\"><option cost=\"0\">No bonus item application</option>";
                    foreach ($market["socket_bonus"] as $sb => $socket_bonus) {
                        echo "<option value=\"" . $sb . "\" cost=\"" . $socket_bonus["price"] . "\" elements=\"" . $socket_bonus["element"] . "\" level=\"" . $socket_bonus["element_lvl"] . "\">" . $socket_bonus["name"] . "</option>";
                    }
                    echo "</select>";
                }
                if (!empty($market["elemental"])) {
                    echo "<ul>";
                    foreach ($market["elemental"] as $e => $elemental) {
                        $disablefirst = $e == 0 ? "disabled checked" : NULL;
                        echo "<li><label><input class=\"smithyCost\" name=\"slot" . $e . "\" type=\"checkbox\" cost=\"" . $elemental["price"] . "\" value=\"1\"" . $disablefirst . "> - " . $elemental["name"] . "</label></li>";
                    }
                    echo "</ul>";
                }
                if (!empty($market["errtel"])) {
                    $e = 1;
                    foreach ($market["errtel"] as $errtelItems) {
                        $errtel_items = NULL;
                        $errtel_lvls = NULL;
                        $c = 1;
                        foreach ($errtelItems as $errtel) {
                            $r = $errtel["rank"];
                            $disableItem = 1 < $e ? "  disabled=\"disabled\"" : NULL;
                            $errtel_items .= "<option value=\"" . $c . "\" cost=\"" . $errtel["price"] . "\" data-rank=\"" . $c . "\"" . $disableItem . ">" . $errtel["name"] . "</option>";
                            foreach ($market["errtel_rank"][$r] as $rank) {
                                $errtel_lvls .= "<option value=\"" . $rank["value"] . "\" cost=\"" . $rank["price"] . "\" data-rank=\"" . $c . "\" style=\"display: none;\">" . $rank["count"] . "</option>";
                            }
                            $c++;
                        }
                        if ($e <= $webshop["errtel_limit"]) {
                            echo "<select name=\"element" . $e . "\" class=\"select-box smithyCost smithyRanks help_text\" title=\"Rank\">";
                            echo "<option cost=\"0\">None</option>";
                            echo $errtel_items;
                            echo "</select>";
                            echo "<select name=\"element_lvl" . $e . "\" class=\"select-box smithyCost smithyLevel help_text\" title=\"Level\">";
                            echo "<option cost=\"0\">0</option>";
                            echo $errtel_lvls;
                            echo "</select><div class=\"spacer\"></div>";
                        }
                        $e++;
                    }
                }
                if (!empty($market["harmony"]) && $webshop["harmony_active"] == 1) {
                    echo "<div class=\"spacer2\"></div><select name=\"harmony\" class=\"select-box smithyCost\" style=\"width: 96%;\"><option value=\"\" cost=\"0\">No Harmony Option</option>";
                    foreach ($market["harmony"] as $h => $harmony) {
                        echo "<option value=\"" . $h . "\" cost=\"" . $harmony["price"] . "\">" . $harmony["hname"] . "</option>";
                    }
                    echo "</select>";
                }
                if (isset($_preview) && !empty($ItemPets)) {
                    echo "<div class=\"shop-item-box while\"><input class=\"smithyCost\" type=\"checkbox\" value=\"1\" cost=\"0\" style=\"display: none;\">";
                    echo "<div class=\"item_name\">" . $market["name"] . "</div>";
                    echo $ItemPetInfo;
                    echo "</div>";
                    if ($subtype == "muun") {
                        echo "\n\t\t\t\t\t\t\t<br /><p class=\"color1 small\">Item will be created in character MUUUN inventory.</p>\n\t\t\t\t\t\t\t<label>\n\t\t\t\t\t\t\t\t<div class=\"select-box\" style=\"margin-top: 10px;\">\n\t\t\t\t\t\t\t\t<select name=\"char\" class=\"char-select\">\n                                     <option value=\"ExtriM\">ExtriM</option>\n                                </select>\n\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t</label>";
                    }
                }
                echo "</div></div></td></tr><tr>";
                $percentage = "1." . $webshop["payment_type"][$pt][0]["percent"];
                echo "<td colspan=\"2\">\n\t\t\t\t\t<div class=\"smithy-coins\">\n\t\t\t\t\t <p style=\"color: " . $webshop["payment_type"][$pt][0]["color"] . ";\" class=\"smithy-color\">Cost:  <span id=\"smithy-cost\">" . number_format($market["price"] * $percentage) . "</span> <span id=\"smithy-payment\">" . $webshop["payment_type"][$pt][0]["name"] . "</span></p>\n\t\t\t\t\t  <input type=\"hidden\" name=\"action\" value=\"smithy-preview\">\n\t\t\t\t\t  <input class=\"nice-button rightfloat\" type=\"submit\" name=\"enter\" value=\"Further\">\n\t\t\t\t\t</div>\n\t\t\t\t\t<div class=\"clear\"></div>\n\t\t\t\t  </td>";
                echo "</tr></table></form>";
            }
        }
        echo "</td></tr>";
    }
    echo "</table></div>\n            </div>\n        </div>\n    </div>\n\n</div>";
}

?>