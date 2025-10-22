<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class Smithy
{
    public static function Config()
    {
        $webshop["url"] = "smithy";
        $webshop["lvl_price"] = 80;
        $webshop["start_lvl"] = 10;
        $webshop["opt_price"] = 15;
        $webshop["start_opt"] = 4;
        $webshop["luck"] = 60;
        $webshop["skill"] = 180;
        $webshop["refinery"] = 900;
        $webshop["noimage"] = "no-img.png";
        $webshop["image_dir"] = "/images/items/";
        $webshop["SX_opt_limit"] = 3;
        $webshop["Exl_opt_limit"] = 4;
        $webshop["socket_limit"] = 5;
        $webshop["errtel_limit"] = 5;
        $webshop["harmony_active"] = 1;
        $webshop["excellent_ancient"] = 0;
        $webshop["excellent_ancient_price"] = 500;
        $webshop["excellent_socket"] = 0;
        $webshop["payment_type"] = ["6" => [["name" => "W Coins", "percent" => "0", "color" => "#ffbf68"], ["name" => "Goblin Points", "percent" => "20", "color" => "#ffbf68"]], "5" => [["name" => "Platinum Coins", "percent" => "0", "color" => "#00ffa8"], ["name" => "Gold Coins", "percent" => "50", "color" => "#b38e47"], ["name" => "Silver Coins", "percent" => "80", "color" => "#959595"]]];
        return $webshop;
    }
    private static function getCalled_Category($calledCategory)
    {
        switch ($calledCategory) {
            case "swords":
                $cat = 0;
                break;
            case "axes":
                $cat = 1;
                break;
            case "maces":
                $cat = 2;
                break;
            case "spears":
                $cat = 3;
                break;
            case "bows":
                $cat = 4;
                break;
            case "staffs":
                $cat = 5;
                break;
            case "shields":
                $cat = 6;
                break;
            case "helms":
                $cat = 7;
                break;
            case "armors":
                $cat = 8;
                break;
            case "pants":
                $cat = 9;
                break;
            case "gloves":
                $cat = 10;
                break;
            case "boots":
                $cat = 11;
                break;
            case "sets":
                $cat = 16;
                break;
            case "wings":
                $cat = 12;
                break;
            case "rings":
                $cat = 13;
                break;
            case "pendants":
                $cat = 14;
                break;
            case "pentagram":
                $cat = 17;
                break;
            case "errtel":
                $cat = 18;
                break;
            case "fire":
                $cat = 12;
                break;
            case "water":
                $cat = 12;
                break;
            case "earth":
                $cat = 12;
                break;
            case "wind":
                $cat = 12;
                break;
            case "darkness":
                $cat = 12;
                break;
            case "classic":
                $cat = 19;
                break;
            case "muun":
                $cat = 20;
                break;
            default:
                $cat = "-1";
                return $cat;
        }
    }
    public static function getSmithy_elementaltype()
    {
        $element = [["name" => "Fire element", "url" => "fire"], ["name" => "Water element", "url" => "water"], ["name" => "Earth element", "url" => "earth"], ["name" => "Wind element", "url" => "wind"], ["name" => "Darkness element", "url" => "darkness"]];
        return $element;
    }
    public static function getSmithy_pets($item)
    {
        global $dB;
        $item = preg_replace("/[^0-9]/", "", $item);
        $pets = $dB->query_fetch("SELECT * FROM [IMPERIAMUCMS_WEBSHOP_PETS] where [item_id] = '" . $item . "' order by id asc");
        if (!isset($pets)) {
            $pets = false;
        }
        return $pets;
    }
    public static function getSmithy_Categories($categoriesType)
    {
        switch ($categoriesType) {
            case "simple":
                $categories = [["name" => "Items", "url" => "excellent"], "3" => ["name" => "Elemental", "url" => "elemental"], "4" => ["name" => "Pets", "url" => "pets"]];
                break;
            default:
                $categories = [["name" => "Excellent", "url" => "excellent"], ["name" => "Ancient", "url" => "ancient"], ["name" => "Socket", "url" => "socket"], ["name" => "Elemental", "url" => "elemental"], ["name" => "Pets", "url" => "pets"]];
                return $categories;
        }
    }
    public static function getSmithy_Classes($cat)
    {
        $type = $cat == "elemental" || $cat == "pets" ? 1 : 0;
        switch ($type) {
            case 0:
                $classes = [["name" => "Dark Knight", "url" => "dk"], ["name" => "Dark Wizard", "url" => "dw"], ["name" => "Fairy Elf", "url" => "elf"], ["name" => "Magic Gladiator", "url" => "mg"], ["name" => "Dark Lord", "url" => "dl"], ["name" => "Summoner", "url" => "sum"], ["name" => "Rage Fighter", "url" => "rf"], ["name" => "Grow Lancer", "url" => "gl"]];
                break;
            case 1:
                $classes = [["name" => "All Classes", "url" => "all"]];
                break;
            default:
                return $classes;
        }
    }
    public static function getSmithy_addHextoDB($item, $price, $account, $time, $type, $payment)
    {
        global $dB;
        $dB->query("INSERT INTO [IMPERIAMUCMS_WEBSHOP_ORDERS] (item, price, account, time, type, payment) VALUES ('" . $item . "','" . $price . "','" . $account . "','" . $time . "', '" . $type . "', '" . $payment . "');");
        $lastid = $dB->query_fetch_single("SELECT IDENT_CURRENT('IMPERIAMUCMS_WEBSHOP_ORDERS') as created_id;");
        return $lastid["created_id"];
    }
    public static function getSmithy_HexDB($id)
    {
        global $dB;
        $id = preg_replace("/[^0-9]/", "", $id);
        $item = $dB->query_fetch_single("SELECT * FROM [IMPERIAMUCMS_WEBSHOP_ORDERS] where [id] = '" . $id . "'");
        if (!isset($item)) {
            $item = false;
        }
        return $item;
    }
    public static function getSmithy_SocketSeed($seed)
    {
        global $dB;
        $lastseed = $dB->query_fetch_single("SELECT * FROM [IMPERIAMUCMS_WEBSHOP_SOCKETS] where [seed] = '" . $seed . "' order by id desc");
        return $lastseed["id"];
    }
    public static function getSmithy_CategoryType($cat, $class)
    {
        switch ($cat) {
            case "excellent":
                $category = [["name" => "Weapons", "url" => "weapons"], ["name" => "Sets", "url" => "sets"], "3" => ["name" => "Wings", "url" => "wings"], "4" => ["name" => "Rings", "url" => "rings"], "5" => ["name" => "Pendants", "url" => "pendants"]];
                break;
            case "ancient":
                switch ($class) {
                    case "dk":
                        $category = [["name" => "Warrior's", "url" => "1", "price" => "225"], ["name" => "Anonymous's", "url" => "2", "price" => "225"], ["name" => "Hyperion's", "url" => "3", "price" => "450"], ["name" => "Mist's", "url" => "4", "price" => "675"], ["name" => "Eplete's", "url" => "5", "price" => "225"], ["name" => "Berserker's", "url" => "6", "price" => "225"], ["name" => "Garuda's", "url" => "7", "price" => "450"], ["name" => "Cloud's", "url" => "8", "price" => "450"], ["name" => "Kantata's", "url" => "9", "price" => "225"], ["name" => "Rave's", "url" => "10", "price" => "900"], ["name" => "Hyon's", "url" => "11", "price" => "675"], ["name" => "Vicious's", "url" => "12", "price" => "675"], ["name" => "Mahes's", "url" => "50", "price" => "900"], ["name" => "Bragi's", "url" => "57", "price" => "450"], ["name" => "Fury's", "url" => "78", "price" => "500"]];
                        break;
                    case "dw":
                        $category = [["name" => "Apollo's", "url" => "13", "price" => "225"], ["name" => "Barnake's", "url" => "14", "price" => "675"], ["name" => "Evis's", "url" => "15", "price" => "450"], ["name" => "Sylion's", "url" => "16", "price" => "450"], ["name" => "Heras's", "url" => "17", "price" => "450"], ["name" => "Minet's", "url" => "18", "price" => "675"], ["name" => "Anubis's", "url" => "19", "price" => "675"], ["name" => "Enis's", "url" => "20", "price" => "675"], ["name" => "Bes's", "url" => "51", "price" => "675"], ["name" => "Alvis's", "url" => "58", "price" => "900"], ["name" => "Transcendence's", "url" => "80", "price" => "500"]];
                        break;
                    case "elf":
                        $category = [["name" => "Ceto's", "url" => "21", "price" => "225"], ["name" => "Drake's", "url" => "22", "price" => "225"], ["name" => "Gaia's", "url" => "23", "price" => "225"], ["name" => "Fase's", "url" => "24", "price" => "450"], ["name" => "Odin's", "url" => "25", "price" => "225"], ["name" => "Elvian's", "url" => "26", "price" => "450"], ["name" => "Argo's", "url" => "27", "price" => "450"], ["name" => "Karis's", "url" => "28", "price" => "450"], ["name" => "Gywen's", "url" => "29", "price" => "225"], ["name" => "Aruan's", "url" => "30", "price" => "675"], ["name" => "Serket's", "url" => "52", "price" => "450"], ["name" => "Frigg's", "url" => "59", "price" => "225"], ["name" => "Flurry's", "url" => "82", "price" => "500"]];
                        break;
                    case "mg":
                        $category = [["name" => "Hyperion's", "url" => "3", "price" => "450"], ["name" => "Garuda's", "url" => "7", "price" => "450"], ["name" => "Kantata's", "url" => "9", "price" => "225"], ["name" => "Evis's", "url" => "15", "price" => "450"], ["name" => "Minet's", "url" => "18", "price" => "675"], ["name" => "Gaion's", "url" => "31", "price" => "675"], ["name" => "Muren's", "url" => "32", "price" => "675"], ["name" => "Apis's", "url" => "53", "price" => "450"], ["name" => "Tyr's", "url" => "60", "price" => "675"], ["name" => "Extremity's", "url" => "86", "price" => "500"]];
                        break;
                    case "dl":
                        $category = [["name" => "Warrior's", "url" => "1", "price" => "225"], ["name" => "Anonymous's", "url" => "2", "price" => "225"], ["name" => "Hyperion's", "url" => "3", "price" => "450"], ["name" => "Mist's", "url" => "4", "price" => "675"], ["name" => "Eplete's", "url" => "5", "price" => "225"], ["name" => "Berserker's", "url" => "6", "price" => "225"], ["name" => "Agnis's", "url" => "33", "price" => "675"], ["name" => "Broy's", "url" => "34", "price" => "675"], ["name" => "Khons's", "url" => "54", "price" => "225"], ["name" => "Surt's", "url" => "61", "price" => "450"], ["name" => "Conquest's", "url" => "88", "price" => "500"]];
                        break;
                    case "sum":
                        $category = [["name" => "Chrono's", "url" => "35", "price" => "675"], ["name" => "Semeden's", "url" => "36", "price" => "675"], ["name" => "Hapy's", "url" => "55", "price" => "675"], "4" => ["name" => "Elune's", "url" => "62", "price" => "675"], "5" => ["name" => "Honor's", "url" => "84", "price" => "500"]];
                        break;
                    case "rf":
                        $category = [["name" => "Cloud's", "url" => "8", "price" => "450"], ["name" => "Rave's", "url" => "10", "price" => "900"], ["name" => "Chamer's", "url" => "38", "price" => "675"], ["name" => "Vega's", "url" => "37", "price" => "675"], ["name" => "Horus's", "url" => "56", "price" => "900"], ["name" => "Magni's", "url" => "63", "price" => "225"], ["name" => "Destruction's", "url" => "90", "price" => "500"]];
                        break;
                    case "gl":
                        $category = [["name" => "Dorov's", "url" => "71", "price" => "300"], ["name" => "Anas's", "url" => "72", "price" => "750"], ["name" => "Akhir's", "url" => "73", "price" => "600"], ["name" => "Camil's", "url" => "74", "price" => "900"], ["name" => "Carthy's", "url" => "75", "price" => "750"], ["name" => "Tenacity's", "url" => "92", "price" => "500"]];
                        break;
                }
                break;
            case "socket":
                $category = [["name" => "Weapons", "url" => "weapons"], ["name" => "Sets", "url" => "sets"]];
                break;
            case "elemental":
                $category = [["name" => "Pentagram", "url" => "pentagram"], ["name" => "Errtel", "url" => "errtel"]];
                break;
            case "pets":
                $category = [["name" => "Classic Pets", "url" => "classic"], ["name" => "MUUN", "url" => "muun"]];
                break;
            default:
                return $category;
        }
    }
    public static function getSmithy_CategoryList($cat, $class, $type)
    {
        switch ($cat) {
            case "excellent":
                switch ($class) {
                    case "dk":
                        switch ($type) {
                            case "weapons":
                                $category = [["name" => "Swords", "url" => "swords"], ["name" => "Axes", "url" => "axes"], ["name" => "Maces", "url" => "maces"], ["name" => "Spears", "url" => "spears"], ["name" => "Shields", "url" => "shields"]];
                                break;
                        }
                        break;
                    case "dw":
                        switch ($type) {
                            case "weapons":
                                $category = [["name" => "Swords", "url" => "swords"], ["name" => "Axes", "url" => "axes"], ["name" => "Maces", "url" => "maces"], ["name" => "Staffs", "url" => "staffs"], ["name" => "Shields", "url" => "shields"]];
                                break;
                        }
                        break;
                    case "elf":
                        switch ($type) {
                            case "weapons":
                                $category = [["name" => "Swords", "url" => "swords"], ["name" => "Axes", "url" => "axes"], ["name" => "Maces", "url" => "maces"], ["name" => "Spears", "url" => "spears"], ["name" => "Bows", "url" => "bows"], ["name" => "Shields", "url" => "shields"]];
                                break;
                        }
                        break;
                    case "mg":
                        switch ($type) {
                            case "weapons":
                                $category = [["name" => "Swords", "url" => "swords"], ["name" => "Axes", "url" => "axes"], ["name" => "Maces", "url" => "maces"], ["name" => "Spears", "url" => "spears"], ["name" => "Staffs", "url" => "staffs"], ["name" => "Shields", "url" => "shields"]];
                                break;
                        }
                        break;
                    case "dl":
                        switch ($type) {
                            case "weapons":
                                $category = [["name" => "Swords", "url" => "swords"], ["name" => "Axes", "url" => "axes"], ["name" => "Maces", "url" => "maces"], ["name" => "Shields", "url" => "shields"]];
                                break;
                        }
                        break;
                    case "sum":
                        switch ($type) {
                            case "weapons":
                                $category = [["name" => "Swords", "url" => "swords"], ["name" => "Axes", "url" => "axes"], ["name" => "Staffs", "url" => "staffs"]];
                                break;
                        }
                        break;
                    case "rf":
                        switch ($type) {
                            case "weapons":
                                $category = [["name" => "Swords", "url" => "swords"], ["name" => "Axes", "url" => "axes"], ["name" => "Maces", "url" => "maces"]];
                                break;
                        }
                        break;
                    case "gl":
                        switch ($type) {
                            case "weapons":
                                $category = [["name" => "Swords", "url" => "swords"], ["name" => "Axes", "url" => "axes"], ["name" => "Spears", "url" => "spears"], ["name" => "Shields", "url" => "shields"]];
                                break;
                        }
                        break;
                    default:
                        switch ($type) {
                            case "sets":
                                $category = [["name" => "Sets", "url" => "sets"]];
                                break;
                            case "wings":
                                $category = [["name" => "Wings", "url" => "wings"]];
                                break;
                            case "rings":
                                $category = [["name" => "Rings", "url" => "rings"]];
                                break;
                            case "pendants":
                                $category = [["name" => "Pendants", "url" => "pendants"]];
                                break;
                        }
                }
                break;
            case "ancient":
                $category = [["name" => "Sets", "url" => "sets"]];
                break;
            case "socket":
                switch ($class) {
                    case "dk":
                        switch ($type) {
                            case "weapons":
                                $category = [["name" => "Swords", "url" => "swords"], ["name" => "Maces", "url" => "maces"], ["name" => "Spears", "url" => "spears"], ["name" => "Shields", "url" => "shields"]];
                                break;
                        }
                        break;
                    case "dw":
                        switch ($type) {
                            case "weapons":
                                $category = [["name" => "Staffs", "url" => "staffs"], ["name" => "Shields", "url" => "shields"]];
                                break;
                        }
                        break;
                    case "elf":
                        switch ($type) {
                            case "weapons":
                                $category = [["name" => "Maces", "url" => "maces"], ["name" => "Bows", "url" => "bows"], ["name" => "Shields", "url" => "shields"]];
                                break;
                        }
                        break;
                    case "mg":
                        switch ($type) {
                            case "weapons":
                                $category = [["name" => "Swords", "url" => "swords"], ["name" => "Staffs", "url" => "staffs"], ["name" => "Shields", "url" => "shields"]];
                                break;
                        }
                        break;
                    case "dl":
                        switch ($type) {
                            case "weapons":
                                $category = [["name" => "Maces", "url" => "maces"], ["name" => "Shields", "url" => "shields"]];
                                break;
                        }
                        break;
                    case "sum":
                        switch ($type) {
                            case "weapons":
                                $category = [["name" => "Staffs", "url" => "staffs"]];
                                break;
                        }
                        break;
                    case "rf":
                        switch ($type) {
                            case "weapons":
                                $category = [];
                                break;
                        }
                        break;
                    case "gl":
                        switch ($type) {
                            case "weapons":
                                $category = [];
                                break;
                        }
                        break;
                    default:
                        switch ($type) {
                            case "sets":
                                $category = [["name" => "Sets", "url" => "sets"]];
                                break;
                        }
                }
                break;
            case "elemental":
                switch ($type) {
                    case "pentagram":
                        $category = [["name" => "Pentagram", "url" => "pentagram"]];
                        break;
                    case "errtel":
                        $category = [["name" => "Errtel", "url" => "errtel"]];
                        break;
                }
                break;
            case "pets":
                switch ($type) {
                    case "classic":
                        $category = [["name" => "Classic Pets", "url" => "classic"]];
                        break;
                    case "muun":
                        $category = [["name" => "MUUN", "url" => "muun"]];
                        break;
                }
                break;
            default:
                if (empty($category)) {
                    $category = [];
                }
                return $category;
        }
    }
    public static function getSmithy_ItemsList($cat, $class, $type, $itemclass, $subclass = NULL)
    {
        global $dB;
        $webshop = smithy::Config();
        $searchablecat = $cat == "socket" ? "AND [use_sockets] = '1'" : ($cat == "elemental" || $cat == "pets" || $webshop["excellent_ancient"] == 1 || $webshop["excellent_socket"] == 1 ? NULL : "AND [item_exc] = '1' AND [use_sockets] = '0'");
        switch ($cat) {
            case "ancient":
                $items["cat"] = $dB->query_fetch("SELECT name, item_id, item_cat FROM [IMPERIAMUCMS_WEBSHOP_NEW] WHERE [i_" . $class . "] > '0' AND [ancient] LIKE '%;" . $type . ";%' OR [ancient] = '" . $type . "' order by [item_cat] asc");
                break;
            default:
                switch ($type) {
                    case "sets":
                        $items["cat"] = $dB->query_fetch("SELECT name, item_id FROM [IMPERIAMUCMS_WEBSHOP_NEW] WHERE [main_cat] = '" . Smithy::getCalled_Category($itemclass) . "' AND [i_" . $class . "] > '0' AND [sub_cat] = '0' " . $searchablecat . " order by [price] desc");
                        break;
                    case "subsets":
                        $items["subcat"] = $dB->query_fetch("SELECT name, item_id, item_cat FROM [IMPERIAMUCMS_WEBSHOP_NEW] WHERE [main_cat] = '" . Smithy::getCalled_Category($itemclass) . "' AND [i_" . $class . "] > '0' AND [item_id] = '" . $subclass . "' " . $searchablecat . " AND [item_cat] IN(7, 8, 9, 10, 11) order by [price] desc, [item_cat] asc");
                        break;
                    default:
                        $searchableclass = $class != "all" ? "AND [i_" . $class . "] > '0' order by [price] desc" : NULL;
                        $items["cat"] = $dB->query_fetch("SELECT name, item_id FROM [IMPERIAMUCMS_WEBSHOP_NEW] WHERE [main_cat] = '" . Smithy::getCalled_Category($itemclass) . "' " . $searchablecat . " " . $searchableclass . "");
                        $output["cat"] = !empty($items["cat"]) ? $items["cat"] : [];
                        $output["subcat"] = !empty($items["subcat"]) ? $items["subcat"] : [];
                        return $output;
                }
        }
    }
    public static function getSmithy_Item($cat, $class, $category, $subcategory, $item)
    {
        global $dB;
        $webshop = smithy::Config();
        $subcategory = preg_replace("/[^a-z_]/", "", $subcategory);
        $subcategory = $subcategory == "items" ? "rings" : $subcategory;
        $searchableclass = $class != "all" ? "AND [i_" . $class . "] > '0'" : NULL;
        $string = NULL;
        switch ($cat) {
            case "ancient":
                $item = preg_replace("/[^0-9-]/", "", $item);
                $anc = Smithy::getSmithy_CategoryType($cat, $class);
                foreach ($anc as $_anc) {
                    if ($_anc["url"] == $category) {
                        $anc_price = $_anc["price"];
                        $anc_id = $_anc["url"];
                    }
                }
                $urlstring = explode("-", $item);
                if (isset($urlstring[0]) && isset($urlstring[1])) {
                    $string = "WHERE [item_id] = '" . $urlstring[0] . "' AND [item_cat] = '" . $urlstring[1] . "' AND [i_" . $class . "] > '0' AND [ancient] LIKE '%" . $anc_id . "%'";
                }
                if (isset($urlstring[0]) && isset($urlstring[1])) {
                    $_position = $dB->query_fetch_single("SELECT X, Y FROM [IMPERIAMUCMS_ITEMS] WHERE [id] = '" . $urlstring[0] . "' AND [type] = '" . $urlstring[1] . "'");
                }
                break;
            default:
                $item = preg_replace("/[^0-9]/", "", $item);
                $string = "WHERE [item_id] = '" . $item . "' AND [item_cat] = '" . Smithy::getCalled_Category($subcategory) . "' " . $searchableclass . " " . $checkItem;
                $_position = $dB->query_fetch_single("SELECT X, Y FROM [IMPERIAMUCMS_ITEMS] WHERE [id] = '" . $item . "' AND [type] = '" . Smithy::getCalled_Category($subcategory) . "'");
                if ($string) {
                    $_item = $dB->query_fetch_single("SELECT * FROM [IMPERIAMUCMS_WEBSHOP_NEW] " . $string . "");
                    if (!$_item["id"]) {
                        exit;
                    }
                    if ($cat == "excellent") {
                        switch ($_item["exetype"]) {
                            case "1":
                                $exltype = $subcategory == "staffs" ? "Wizardy" : "Attack";
                                $options = [["name" => "Increase Excellent Damage Chance by +10%", "price" => "480"], ["name" => "" . $exltype . " Damage increases by 1 every 20Lv", "price" => "270"], ["name" => "" . $exltype . " Damage increases by 2%", "price" => "480"], ["name" => "Increase 50 Attack (Wizardry) speed", "price" => "160"], ["name" => "Obtains (Life/8) when monster is killed", "price" => "80"], ["name" => "Obtains (Mana/8) when monster is killed", "price" => "80"]];
                                if (100 <= config("server_files_season", true)) {
                                    $additional = [["name" => "" . $exltype . " Dmg increases by 2.2 every 20Lv", "price" => "300"], ["name" => "Increased by " . $exltype . " Dmg 46", "price" => "300"]];
                                    if ($_item["use_sockets"] == 1) {
                                        $options = [];
                                    }
                                }
                                break;
                            case "2":
                                $options = [["name" => "Increase Maximum Life by 4%", "price" => "100"], ["name" => "Increase Maximum Mana by 4%", "price" => "50"], ["name" => "Decreases Damage by 5%", "price" => "300"], ["name" => "Reflect Damage by 5%", "price" => "300"], ["name" => "Increases Defense Success Rate by 10%", "price" => "150"], ["name" => "Increases the amount of Zen acquired for hunting monsters by 30%", "price" => "150"]];
                                if ($category == "sets" && $_item["exe_additional"] && 100 <= config("server_files_season", true)) {
                                    $additional = [["name" => "Increase Maximum Life by 165", "price" => "100"], ["name" => "Increase Maximum Mana by 165", "price" => "50"], ["name" => "Decreases Damage by 45", "price" => "300"], ["name" => "Increase the amount Zen acquired for hunting monsters by 42%", "price" => "200"]];
                                    $options = ["3" => ["name" => "Reflect Damage by 5%", "price" => "300"], "4" => ["name" => "Increases Defense Success Rate by 10%", "price" => "150"]];
                                    if ($_item["use_sockets"] == 1) {
                                        $options = [];
                                    }
                                }
                                break;
                            case "3":
                                $options = [["name" => "Increase Life +50", "price" => "80"], ["name" => "Increase Mana +50", "price" => "80"], ["name" => "Increase chance of True Damage by 3%", "price" => "780"], ["name" => "Increase Maximum AG +50", "price" => "80"], ["name" => "Increase +5 Attack (Wizardry) speed", "price" => "80"]];
                                break;
                            case "4":
                                $options = [["name" => "Increase chance of True Damage by 5%", "price" => "2520"], ["name" => "Increase chance to return incoming damage by 5%", "price" => "1860"], ["name" => "Increase chance of Fully Recovering Life by 5%", "price" => "390"], ["name" => "Increase chance of Fully Recovering Mana by 5%", "price" => "180"]];
                                break;
                            case "5":
                                $options = [["name" => "Increase Command by 10", "price" => "300"], ["name" => "Increase chance of True Damage by 3%", "price" => "780"], ["name" => "Increases Mana by 50", "price" => "80"], ["name" => "Increases Life by 50", "price" => "80"]];
                                break;
                            case "6":
                                $options = [["name" => "Increase chance of True Damage by 3%", "price" => "780"], ["name" => "Increases Mana by 50", "price" => "80"], ["name" => "Increases Life by 50", "price" => "80"]];
                                break;
                            case "7":
                                $options = [["name" => "Increase chance of True Damage by 3%", "price" => "390"], ["name" => "Increase chance of Fully Recovering Life by 5%", "price" => "1260"]];
                                break;
                            default:
                                $options = [];
                                $additional = isset($additional) ? $additional : [];
                        }
                    }
                    if ($cat == "ancient" || $cat == "excellent" && $webshop["excellent_ancient"] == 1) {
                        if ($webshop["excellent_ancient"] == 1) {
                            $anc_types = explode(";", $_item["ancient"]);
                            $anc_id = $anc_types[1];
                            $webshop["excellent_ancient"] = empty($anc_id) ? 0 : 1;
                        }
                        $_ancient = $dB->query_fetch_single("SELECT anc_opt, anc_name, tier FROM [IMPERIAMUCMS_WEBSHOP_ANC] WHERE [anc_id] = '" . $anc_id . "'");
                        $anc_options = !empty($_ancient["anc_opt"]) ? $_ancient["anc_opt"] : "Unknown Ancient Option #" . $anc_id . "";
                        $_item["name"] = !empty($_ancient["anc_name"]) && $webshop["excellent_ancient"] != 1 ? $_ancient["anc_name"] . " " . $_item["name"] : $_item["name"];
                    }
                    if ($cat == "socket" || $cat == "excellent" && $webshop["excellent_socket"] == 1) {
                        switch ($category) {
                            case "sets":
                                $socket_options = $dB->query_fetch("SELECT id, socket_id, socket_name, socket_price, seed FROM [IMPERIAMUCMS_WEBSHOP_SOCKETS] WHERE [sockettype] IN(2,4,6) order by sockettype asc");
                                $socket_bonus_type1 = $webshop["socket_limit"] == 5 ? "water;earth;wind;water;earth" : "water;earth;wind";
                                $socket_bonus_type2 = $webshop["socket_limit"] == 5 ? "earth;wind;water;earth;wind" : "earth;wind;water";
                                $socket_bonus_type3 = $webshop["socket_limit"] == 5 ? "water;earth;wind;water;earth" : "water;earth;wind";
                                $socket_bonus_type4 = $webshop["socket_limit"] == 5 ? "earth;wind;water;earth;wind" : "earth;wind;water";
                                $socketbonus_options = [["name" => "Defense Increase +50", "element_id" => "4", "element_lvl" => "1", "element" => $socket_bonus_type1, "price" => "250"], ["name" => "Maximum Life Increase +200", "element_id" => "5", "element_lvl" => "1", "element" => $socket_bonus_type2, "price" => "250"], ["name" => "Increases Defense +75", "element_id" => "10", "element_lvl" => "2", "element" => $socket_bonus_type3, "price" => "350"], ["name" => "Increases Maximum Life +300", "element_id" => "11", "element_lvl" => "2", "element" => $socket_bonus_type4, "price" => "350"]];
                                break;
                            case "weapons":
                                $socket_options = $dB->query_fetch("SELECT id, socket_id, socket_name, socket_price, seed FROM [IMPERIAMUCMS_WEBSHOP_SOCKETS] WHERE [sockettype] IN(1,3,5) order by sockettype asc");
                                switch ($subcategory) {
                                    case "shields":
                                        $sbonus1 = "Defense Increase +50";
                                        $sbonus2 = "Maximum Life Increase +200";
                                        $sbonus3 = "Increases Defense +75";
                                        $sbonus4 = "Increases Maximum Life +300";
                                        break;
                                    case "staffs":
                                        $sbonus1 = "Attack/Wizardry Increase +50";
                                        $sbonus2 = "Skill Attack Increase +50";
                                        $sbonus3 = "Increases Attack Power and Magical Damage +75";
                                        $sbonus4 = "Increase Skill Damage +75";
                                        break;
                                    default:
                                        $sbonus1 = "Attack power Increase +50";
                                        $sbonus2 = "Skill Attack Increase +50";
                                        $sbonus3 = "Increases Attack +75";
                                        $sbonus4 = "Increase Skill Damage +75";
                                        $socket_bonus_type1 = $webshop["socket_limit"] == 5 ? "fire;lightning;ice;fire;lightning" : "fire;lightning;ice";
                                        $socket_bonus_type2 = $webshop["socket_limit"] == 5 ? "lightning;ice;fire;lightning;ice" : "lightning;ice;fire";
                                        $socket_bonus_type3 = $webshop["socket_limit"] == 5 ? "fire;lightning;ice;fire;lightning" : "fire;lightning;ice";
                                        $socket_bonus_type4 = $webshop["socket_limit"] == 5 ? "lightning;ice;fire;lightning;ice" : "lightning;ice;fire";
                                        $socketbonus_options = [["name" => $sbonus1, "element_id" => "2", "element_lvl" => "1", "element" => $socket_bonus_type1, "price" => "250"], ["name" => $sbonus2, "element_id" => "1", "element_lvl" => "1", "element" => $socket_bonus_type2, "price" => "250"], ["name" => $sbonus3, "element_id" => "6", "element_lvl" => "2", "element" => $socket_bonus_type3, "price" => "350"], ["name" => $sbonus4, "element_id" => "3", "element_lvl" => "2", "element" => $socket_bonus_type4, "price" => "350"]];
                                }
                                break;
                            default:
                                $socket_options = [];
                                $socketbonus_options = [];
                        }
                    }
                    if ($cat == "elemental") {
                        switch ($category) {
                            case "pentagram":
                                $elemental_options = [["name" => "Slot of Anger", "price" => "0"], ["name" => "Slot of Blessing", "price" => "225"], ["name" => "Slot of Integrity", "price" => "225"], ["name" => "Slot of Divinity", "price" => "225"], ["name" => "Slot of Radiance", "price" => "675"]];
                                break;
                            case "errtel":
                                switch ($item) {
                                    case 221:
                                        $errtel_options = [[["name" => "Elemental Dmg +[x]", "rank" => "0", "value" => "20", "price" => "105"]], [["name" => "+[x]% Attack Against Fire Element", "rank" => "1", "value" => "22", "price" => "135"], ["name" => "+[x]% Attack Against Water Element", "rank" => "1", "value" => "38", "price" => "135"], ["name" => "+[x]% Attack Against Earth Element", "rank" => "1", "value" => "46", "price" => "135"], ["name" => "+[x]% Attack Against Wind Element", "rank" => "1", "value" => "52", "price" => "135"], ["name" => "+[x]% Attack Against Dark Element", "rank" => "1", "value" => "58", "price" => "135"]], [["name" => "Elemental Attack Dmg (in PvP) +[x]", "rank" => "0", "value" => "9", "price" => "165"], ["name" => "Elemental Attack Dmg (in Raids) +[x]", "rank" => "0", "value" => "41", "price" => "165"]], [["name" => "Elemental Damage (in PvP) +[x]", "rank" => "0", "value" => "0", "price" => "185"], ["name" => "Elemental Damage (in Raids) +[x]", "rank" => "0", "value" => "0", "price" => "185"]], [["name" => "Elemental Damage +[x]%", "rank" => "1", "value" => "0", "price" => "200"]]];
                                        $errtel_rank = [[["value" => "0", "count" => "10", "price" => "45"], ["value" => "1", "count" => "21", "price" => "90"], ["value" => "2", "count" => "33", "price" => "135"], ["value" => "3", "count" => "46", "price" => "180"], ["value" => "4", "count" => "60", "price" => "225"], ["value" => "5", "count" => "75", "price" => "270"], ["value" => "6", "count" => "91", "price" => "315"], ["value" => "7", "count" => "108", "price" => "360"], ["value" => "8", "count" => "126", "price" => "405"], ["value" => "9", "count" => "145", "price" => "450"], ["value" => "10", "count" => "165", "price" => "495"]], [["value" => "0", "count" => "5", "price" => "45"], ["value" => "1", "count" => "6", "price" => "90"], ["value" => "2", "count" => "7", "price" => "135"], ["value" => "3", "count" => "8", "price" => "180"], ["value" => "4", "count" => "9", "price" => "225"], ["value" => "5", "count" => "10", "price" => "270"], ["value" => "6", "count" => "12", "price" => "315"], ["value" => "7", "count" => "14", "price" => "360"], ["value" => "8", "count" => "16", "price" => "405"], ["value" => "9", "count" => "18", "price" => "450"], ["value" => "10", "count" => "20", "price" => "495"]]];
                                        break;
                                    case 231:
                                        $errtel_options = [[["name" => "Elemental Defense +[x]", "rank" => "0", "value" => "4", "price" => "105"]], [["name" => "+[x]% Defense Against Fire Element", "rank" => "1", "value" => "25", "price" => "135"], ["name" => "+[x]% Defense Against Water Element", "rank" => "1", "value" => "34", "price" => "135"], ["name" => "+[x]% Defense Against Earth Element", "rank" => "1", "value" => "45", "price" => "135"], ["name" => "+[x]% Defense Against Wind Element", "rank" => "1", "value" => "54", "price" => "135"], ["name" => "+[x]% Defense Against Dark Element", "rank" => "1", "value" => "59", "price" => "135"]], [["name" => "Elemental Defense Dmg (in PvP) +[x]", "rank" => "0", "value" => "10", "price" => "165"], ["name" => "Elemental Defense Dmg (in Raids) +[x]", "rank" => "0", "value" => "29", "price" => "165"]], [["name" => "Elemental Damage Absorb (in Raids) +[x]%", "rank" => "1", "value" => "0", "price" => "185"], ["name" => "Elemental Damage Absorb (in PvP) +[x]%", "rank" => "1", "value" => "0", "price" => "185"]], [["name" => "Elemental Damage Absorb +[x]%", "rank" => "1", "value" => "0", "price" => "200"]]];
                                        $errtel_rank = [[["value" => "0", "count" => "10", "price" => "45"], ["value" => "1", "count" => "13", "price" => "90"], ["value" => "2", "count" => "17", "price" => "135"], ["value" => "3", "count" => "22", "price" => "180"], ["value" => "4", "count" => "22", "price" => "225"], ["value" => "5", "count" => "35", "price" => "270"], ["value" => "6", "count" => "43", "price" => "315"], ["value" => "7", "count" => "52", "price" => "360"], ["value" => "8", "count" => "62", "price" => "405"], ["value" => "9", "count" => "73", "price" => "450"], ["value" => "10", "count" => "85", "price" => "495"]], [["value" => "0", "count" => "5", "price" => "45"], ["value" => "1", "count" => "6", "price" => "90"], ["value" => "2", "count" => "7", "price" => "135"], ["value" => "3", "count" => "8", "price" => "180"], ["value" => "4", "count" => "9", "price" => "225"], ["value" => "5", "count" => "10", "price" => "270"], ["value" => "6", "count" => "12", "price" => "315"], ["value" => "7", "count" => "14", "price" => "360"], ["value" => "8", "count" => "16", "price" => "405"], ["value" => "9", "count" => "18", "price" => "450"], ["value" => "10", "count" => "20", "price" => "495"]]];
                                        break;
                                    case 241:
                                        $errtel_options = [[["name" => "Elemental Attack Success Rate +[x]", "rank" => "0", "value" => "18", "price" => "105"]], [["name" => "+[x]% Attack Against Fire Element", "rank" => "0", "value" => "16", "price" => "135"], ["name" => "+[x]% Attack Against Water Element", "rank" => "0", "value" => "40", "price" => "135"], ["name" => "+[x]% Attack Against Earth Element", "rank" => "0", "value" => "47", "price" => "135"], ["name" => "+[x]% Attack Against Wind Element", "rank" => "0", "value" => "55", "price" => "135"], ["name" => "+[x]% Attack Against Dark Element", "rank" => "0", "value" => "57", "price" => "135"]], [["name" => "Elemental Attack Dmg (in PvP) +[x]", "rank" => "1", "value" => "12", "price" => "165"], ["name" => "Elemental Attack Dmg (in Raids) +[x]", "rank" => "1", "value" => "30", "price" => "165"]], [["name" => "Elemental Attack Success (in Raids) +[x]", "rank" => "3", "value" => "0", "price" => "185"], ["name" => "Elemental Attack Success (in PvP) +[x]", "rank" => "3", "value" => "0", "price" => "185"]], [["name" => "Elemental Attack Success +[x]", "rank" => "1", "value" => "0", "price" => "200"]]];
                                        $errtel_rank = [[["value" => "0", "count" => "5", "price" => "45"], ["value" => "1", "count" => "6", "price" => "90"], ["value" => "2", "count" => "7", "price" => "135"], ["value" => "3", "count" => "8", "price" => "180"], ["value" => "4", "count" => "9", "price" => "225"], ["value" => "5", "count" => "10", "price" => "270"], ["value" => "6", "count" => "12", "price" => "315"], ["value" => "7", "count" => "14", "price" => "360"], ["value" => "8", "count" => "16", "price" => "405"], ["value" => "9", "count" => "18", "price" => "450"], ["value" => "10", "count" => "20", "price" => "495"]], [["value" => "0", "count" => "10", "price" => "45"], ["value" => "1", "count" => "21", "price" => "90"], ["value" => "2", "count" => "33", "price" => "135"], ["value" => "3", "count" => "46", "price" => "180"], ["value" => "4", "count" => "60", "price" => "225"], ["value" => "5", "count" => "75", "price" => "270"], ["value" => "6", "count" => "91", "price" => "315"], ["value" => "7", "count" => "108", "price" => "360"], ["value" => "8", "count" => "126", "price" => "405"], ["value" => "9", "count" => "145", "price" => "450"], ["value" => "10", "count" => "165", "price" => "495"]], "3" => [["value" => "0", "count" => "150", "price" => "45"], ["value" => "1", "count" => "173", "price" => "90"], ["value" => "2", "count" => "196", "price" => "135"], ["value" => "3", "count" => "219", "price" => "180"], ["value" => "4", "count" => "252", "price" => "225"], ["value" => "5", "count" => "285", "price" => "270"], ["value" => "6", "count" => "318", "price" => "315"], ["value" => "7", "count" => "361", "price" => "360"], ["value" => "8", "count" => "404", "price" => "405"], ["value" => "9", "count" => "447", "price" => "450"], ["value" => "10", "count" => "605", "price" => "495"]]];
                                        break;
                                    case 251:
                                        $errtel_options = [[["name" => "Elemental Defense Rate +[x]", "rank" => "0", "value" => "3", "price" => "105"]], [["name" => "+[x]% Defense Against Fire Element", "rank" => "0", "value" => "7", "price" => "135"], ["name" => "+[x]% Defense Against Water Element", "rank" => "0", "value" => "33", "price" => "135"], ["name" => "+[x]% Defense Against Earth Element", "rank" => "0", "value" => "50", "price" => "135"], ["name" => "+[x]% Defense Against Wind Element", "rank" => "0", "value" => "53", "price" => "135"], ["name" => "+[x]% Defense Against Dark Element", "rank" => "0", "value" => "56", "price" => "135"]], [["name" => "Elemental Defense (in PvP) +[x]", "rank" => "1", "value" => "11", "price" => "165"], ["name" => "Elemental Defense (in Raids) +[x]", "rank" => "1", "value" => "37", "price" => "165"]], [["name" => "Elemental Defense Success (in Raids) +[x]", "rank" => "2", "value" => "0", "price" => "185"], ["name" => "Elemental Defense Success (in PvP) +[x]", "rank" => "2", "value" => "0", "price" => "185"]], [["name" => "Elemental Defense Success Rate +[x]", "rank" => "3", "value" => "0", "price" => "200"]]];
                                        $errtel_rank = [[["value" => "0", "count" => "5", "price" => "45"], ["value" => "1", "count" => "6", "price" => "90"], ["value" => "2", "count" => "7", "price" => "135"], ["value" => "3", "count" => "8", "price" => "180"], ["value" => "4", "count" => "9", "price" => "225"], ["value" => "5", "count" => "10", "price" => "270"], ["value" => "6", "count" => "12", "price" => "315"], ["value" => "7", "count" => "14", "price" => "360"], ["value" => "8", "count" => "16", "price" => "405"], ["value" => "9", "count" => "18", "price" => "450"], ["value" => "10", "count" => "20", "price" => "495"]], [["value" => "0", "count" => "10", "price" => "45"], ["value" => "1", "count" => "13", "price" => "90"], ["value" => "2", "count" => "17", "price" => "135"], ["value" => "3", "count" => "22", "price" => "180"], ["value" => "4", "count" => "22", "price" => "225"], ["value" => "5", "count" => "35", "price" => "270"], ["value" => "6", "count" => "43", "price" => "315"], ["value" => "7", "count" => "52", "price" => "360"], ["value" => "8", "count" => "62", "price" => "405"], ["value" => "9", "count" => "73", "price" => "450"], ["value" => "10", "count" => "85", "price" => "495"]], [["value" => "0", "count" => "150", "price" => "45"], ["value" => "1", "count" => "173", "price" => "90"], ["value" => "2", "count" => "196", "price" => "135"], ["value" => "3", "count" => "219", "price" => "180"], ["value" => "4", "count" => "252", "price" => "225"], ["value" => "5", "count" => "285", "price" => "270"], ["value" => "6", "count" => "318", "price" => "315"], ["value" => "7", "count" => "361", "price" => "360"], ["value" => "8", "count" => "404", "price" => "405"], ["value" => "9", "count" => "447", "price" => "450"], ["value" => "10", "count" => "605", "price" => "495"]], [["value" => "0", "count" => "13", "price" => "45"], ["value" => "1", "count" => "23", "price" => "90"], ["value" => "2", "count" => "33", "price" => "135"], ["value" => "3", "count" => "43", "price" => "180"], ["value" => "4", "count" => "54", "price" => "225"], ["value" => "5", "count" => "65", "price" => "270"], ["value" => "6", "count" => "76", "price" => "315"], ["value" => "7", "count" => "90", "price" => "360"], ["value" => "8", "count" => "104", "price" => "405"], ["value" => "9", "count" => "118", "price" => "450"], ["value" => "10", "count" => "135", "price" => "495"]]];
                                        break;
                                    case 261:
                                        $errtel_options = [[["name" => "Elemental Damage (II) +[x]", "rank" => "0", "value" => "14", "price" => "255"], ["name" => "Elemental Defense (II) +[x]", "rank" => "0", "value" => "178", "price" => "255"], ["name" => "Elemental Attack Success Rate (II) +[x]", "rank" => "1", "value" => "181", "price" => "155"], ["name" => "Elemental Defense Success Rate (II) +[x]", "rank" => "1", "value" => "185", "price" => "155"], ["name" => "Elemental Damage (III) +[x]", "rank" => "2", "value" => "188", "price" => "305"], ["name" => "Elemental Defense (III) +[x]", "rank" => "2", "value" => "191", "price" => "305"]], [["name" => "Absorb Shield - 30% chance to absorb +[x]% damage as SD", "rank" => "3", "value" => "6", "price" => "285"], ["name" => "Absorb Life - 30% chance to absorb +[x]% damage as Life", "rank" => "3", "value" => "42", "price" => "285"], ["name" => "Bastion - Protection is activated for +[x] sec. by 50% chance when SD is below 20%", "rank" => "3", "value" => "49", "price" => "285"]], [["name" => "Bleeding - A durable effect invoking +[x] damages to the target with certain chance when attacking", "rank" => "4", "value" => "13", "price" => "315"], "2" => ["name" => "Paralyzing - Chance to decrease target's Moving Speed and every Healing ability by 90%", "rank" => "3", "value" => "39", "price" => "315"], "3" => ["name" => "Binding - Immobilize the target by holding its leg with certain chance when attacking", "rank" => "3", "value" => "48", "price" => "315"], "4" => ["name" => "Punish- 30% chance to inflict damage (+[x]% of target's MAX Life) upon Critical Elemantal Damage", "rank" => "3", "value" => "193", "price" => "315"], "5" => ["name" => "Blinding - Chance to greatly decrease target's Attack Success Rate by +[x]% when attacking", "rank" => "5", "value" => "196", "price" => "315"]], [["name" => "Can use Immune Skill I.", "rank" => "6", "value" => "0", "price" => "185"], ["name" => "Can use Immune Skill II.", "rank" => "6", "value" => "0", "price" => "185"]], [["name" => "Can use Berseker Skill I.", "rank" => "6", "value" => "0", "price" => "200"]]];
                                        $errtel_rank = [[["value" => "0", "count" => "13", "price" => "45"], ["value" => "1", "count" => "21", "price" => "90"], ["value" => "2", "count" => "29", "price" => "135"], ["value" => "3", "count" => "37", "price" => "180"], ["value" => "4", "count" => "46", "price" => "225"], ["value" => "5", "count" => "55", "price" => "270"], ["value" => "6", "count" => "64", "price" => "315"], ["value" => "7", "count" => "74", "price" => "360"], ["value" => "8", "count" => "84", "price" => "405"], ["value" => "9", "count" => "94", "price" => "450"], ["value" => "10", "count" => "107", "price" => "495"]], [["value" => "0", "count" => "150", "price" => "45"], ["value" => "1", "count" => "173", "price" => "90"], ["value" => "2", "count" => "196", "price" => "135"], ["value" => "3", "count" => "219", "price" => "180"], ["value" => "4", "count" => "252", "price" => "225"], ["value" => "5", "count" => "285", "price" => "270"], ["value" => "6", "count" => "318", "price" => "315"], ["value" => "7", "count" => "361", "price" => "360"], ["value" => "8", "count" => "404", "price" => "405"], ["value" => "9", "count" => "447", "price" => "450"], ["value" => "10", "count" => "605", "price" => "495"]], [["value" => "0", "count" => "13", "price" => "45"], ["value" => "1", "count" => "23", "price" => "90"], ["value" => "2", "count" => "33", "price" => "135"], ["value" => "3", "count" => "43", "price" => "180"], ["value" => "4", "count" => "54", "price" => "225"], ["value" => "5", "count" => "65", "price" => "270"], ["value" => "6", "count" => "76", "price" => "315"], ["value" => "7", "count" => "90", "price" => "360"], ["value" => "8", "count" => "104", "price" => "405"], ["value" => "9", "count" => "118", "price" => "450"], ["value" => "10", "count" => "135", "price" => "495"]], [["value" => "0", "count" => "1", "price" => "45"], ["value" => "1", "count" => "2", "price" => "90"], ["value" => "2", "count" => "3", "price" => "135"], ["value" => "3", "count" => "4", "price" => "180"], ["value" => "4", "count" => "5", "price" => "225"], ["value" => "5", "count" => "6", "price" => "270"], ["value" => "6", "count" => "7", "price" => "315"], ["value" => "7", "count" => "8", "price" => "360"], ["value" => "8", "count" => "9", "price" => "405"], ["value" => "9", "count" => "10", "price" => "450"], ["value" => "10", "count" => "11", "price" => "495"]], [["value" => "0", "count" => "500", "price" => "45"], ["value" => "1", "count" => "650", "price" => "90"], ["value" => "2", "count" => "800", "price" => "135"], ["value" => "3", "count" => "950", "price" => "180"], ["value" => "4", "count" => "1100", "price" => "225"], ["value" => "5", "count" => "1250", "price" => "270"], ["value" => "6", "count" => "1400", "price" => "315"], ["value" => "7", "count" => "1550", "price" => "360"], ["value" => "8", "count" => "1700", "price" => "405"], ["value" => "9", "count" => "1850", "price" => "450"], ["value" => "10", "count" => "2000", "price" => "495"]], [["value" => "0", "count" => "15", "price" => "45"], ["value" => "1", "count" => "17", "price" => "90"], ["value" => "2", "count" => "19", "price" => "135"], ["value" => "3", "count" => "21", "price" => "180"], ["value" => "4", "count" => "24", "price" => "225"], ["value" => "5", "count" => "27", "price" => "270"], ["value" => "6", "count" => "30", "price" => "315"], ["value" => "7", "count" => "34", "price" => "360"], ["value" => "8", "count" => "38", "price" => "405"], ["value" => "9", "count" => "42", "price" => "450"], ["value" => "10", "count" => "50", "price" => "495"]], [["value" => "10", "count" => "1", "price" => "45"]]];
                                        break;
                                    default:
                                        $notice = "*For the next rank selection minimum level of the previous rank must be +6.";
                                }
                                break;
                            default:
                                $elemental_options = [];
                                $elementalitems = Smithy::getSmithy_elementaltype();
                                $el = 1;
                                $ilvl = NULL;
                                foreach ($elementalitems as $element) {
                                    if ($subcategory == $element["url"]) {
                                        $ilvl = $el;
                                    }
                                    $el++;
                                }
                        }
                    }
                    if (0 < $_item["use_harmony"]) {
                        switch ($_item["use_harmony"]) {
                            case "1":
                                $harmony = $dB->query_fetch("SELECT id, hname, price, hoption, hvalue FROM [IMPERIAMUCMS_WEBSHOP_HARMONY] WHERE [itemtype] = '1' AND [status] = '1' order by id desc");
                                break;
                            case "2":
                                $harmony = $dB->query_fetch("SELECT id, hname, price, hoption, hvalue FROM [IMPERIAMUCMS_WEBSHOP_HARMONY] WHERE [itemtype] = '3' AND [status] = '1' order by id desc");
                                break;
                            case "3":
                                $harmony = $dB->query_fetch("SELECT id, hname, price, hoption, hvalue FROM [IMPERIAMUCMS_WEBSHOP_HARMONY] WHERE [itemtype] = '2' AND [status] = '1' order by id desc");
                                break;
                        }
                    }
                    $item_price = isset($anc_price) ? $anc_price : $_item["price"];
                    if ($cat == "excellent" && $webshop["excellent_socket"] == 1 && $_item["use_sockets"] == 1) {
                        $harmony = NULL;
                    }
                    $output["name"] = $_item["name"];
                    $output["item_id"] = $_item["item_id"];
                    $output["item_cat"] = $_item["item_cat"];
                    $output["payment_type"] = $_item["payment_type"];
                    $output["image"] = $_item["item_cat"] . "-" . $_item["item_id"] . (isset($ilvl) && 0 < $ilvl ? "-" . $ilvl : NULL) . ".gif";
                    $output["price"] = $item_price;
                    $output["luck"] = $_item["luck"] == 1 ? 1 : 0;
                    $output["skill"] = $_item["skill"] == 1 ? 1 : 0;
                    $output["lvl"] = 0 < $_item["max_item_lvl"] ? $_item["max_item_lvl"] : 0;
                    $output["opt"] = 0 < $_item["max_item_opt"] ? $_item["max_item_opt"] : 0;
                    $output["opt_type"] = $_item["opt_type"] == 1 ? "Automatic HP recovery" : ($_item["opt_type"] == 2 ? "Additional Wizard dmg" : ($_item["opt_type"] == 3 ? "Max AG increased" : ($_item["opt_type"] == 4 ? "Additional Defense" : ($_item["opt_type"] == 5 ? "Additional Defense rate" : "Additional Damage"))));
                    $output["harmony"] = 0 < $_item["use_harmony"] && $cat != "socket" ? $harmony : NULL;
                    $output["refinary"] = $_item["use_refinary"] == 1 && $cat == "excellent" ? 1 : 0;
                    $output["excellent"] = $cat == "excellent" ? $options : NULL;
                    $output["excellent_additional"] = $cat == "excellent" && !empty($additional) ? $additional : NULL;
                    $output["excellent_additional_sets"] = $cat == "excellent" && $_item["exe_additional"] == 1 ? 1 : NULL;
                    $output["ancient"] = $cat == "ancient" || $cat == "excellent" && $webshop["excellent_ancient"] == 1 ? $anc_options : NULL;
                    $output["ancient_tier"] = $cat == "ancient" || $cat == "excellent" && $webshop["excellent_ancient"] == 1 ? $_ancient["tier"] : NULL;
                    $output["ancient_name"] = $cat == "excellent" && $webshop["excellent_ancient"] == 1 ? $_ancient["anc_name"] : NULL;
                    $output["socket"] = $cat == "socket" || $cat == "excellent" && $webshop["excellent_socket"] == 1 && $_item["use_sockets"] == 1 ? $socket_options : NULL;
                    $output["socket_bonus"] = $cat == "socket" || $cat == "excellent" && $webshop["excellent_socket"] == 1 && $_item["use_sockets"] == 1 ? $socketbonus_options : NULL;
                    $output["elemental"] = $cat == "elemental" && isset($elemental_options) ? $elemental_options : NULL;
                    $output["errtel"] = $cat == "elemental" && isset($errtel_options) ? $errtel_options : NULL;
                    $output["errtel_rank"] = $cat == "elemental" && isset($errtel_rank) ? $errtel_rank : NULL;
                    $output["notice"] = isset($notice) ? $notice : NULL;
                    $output["X"] = $_position["X"];
                    $output["Y"] = $_position["Y"];
                    if (empty($_item)) {
                        $output = false;
                    }
                    return $output;
                } else {
                    exit;
                }
        }
    }
    public static function checkCategories($needle, $haystack)
    {
        $it = new RecursiveIteratorIterator(new RecursiveArrayIterator($haystack));
        foreach ($it as $element) {
            if ($element == $needle) {
                return true;
            }
        }
        return false;
    }
}

?>