<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class Webshop
{
    public function retrieveItems($sub_cat = NULL)
    {
        global $dB;
        $sub_cat = xss_clean($sub_cat);
        if ($sub_cat != "all" && !is_numeric($sub_cat) && $sub_cat != NULL) {
            throw new Exception("Ouch.");
        }
        if ($sub_cat == NULL) {
            $result = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_WEBSHOP ORDER BY item_cat ASC, item_id ASC, item_lvl ASC");
        } else {
            if ($sub_cat == 0) {
                $result = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_WEBSHOP WHERE sub_cat = ? AND main_cat = '2' ORDER BY item_cat ASC, item_id ASC, item_lvl ASC", [$sub_cat]);
            } else {
                $result = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_WEBSHOP WHERE sub_cat = ? ORDER BY item_cat ASC, item_id ASC, item_lvl ASC", [$sub_cat]);
            }
        }
        if (is_array($result)) {
            return $result;
        }
        return NULL;
    }
    public function removeItem($id)
    {
        global $dB;
        $id = xss_clean($id);
        if (!is_numeric($id)) {
            return NULL;
        }
        $delete = $dB->query("DELETE FROM IMPERIAMUCMS_WEBSHOP WHERE id = ?", [$id]);
        if ($delete) {
            return true;
        }
        return false;
    }
    public function loadItemData($id)
    {
        global $dB;
        $id = xss_clean($id);
        if (!is_numeric($id)) {
            return NULL;
        }
        $data = $dB->query_fetch_single("SELECT TOP 1 * FROM IMPERIAMUCMS_WEBSHOP WHERE id = ?", [$id]);
        if (is_array($data)) {
            return $data;
        }
        return NULL;
    }
    public function addItem($item_id, $item_cat, $max_lvl, $max_opt, $exetype, $name, $price, $luck, $skill, $sock, $harm, $ref, $paytype, $desc, $maincat, $subcat, $img, $sale, $lvl, $store, $exc, $gift)
    {
        global $dB;
        $query = $dB->query("INSERT INTO [dbo].[IMPERIAMUCMS_WEBSHOP] ([item_id],[item_cat],[max_item_lvl],[max_item_opt],[exetype],[name],[price],[luck],[skill],[use_sockets],[use_harmony],[use_refinary],[total_bought],[payment_type],[description],[main_cat],[sub_cat],[image],[on_sale],[item_lvl],[store_count],[item_exc],[can_gift])\r\n                             VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", [$item_id, $item_cat, $max_lvl, $max_opt, $exetype, $name, $price, $luck, $skill, $sock, $harm, $ref, 0, $paytype, $desc, $maincat, $subcat, $img, $sale, $lvl, $store, $exc, $gift]);
        if ($query) {
            message("success", "Item was successfully added.");
        } else {
            message("error", "Error occurred.");
        }
    }
    public function updateItem($id, $item_id, $item_cat, $max_lvl, $max_opt, $exetype, $name, $price, $luck, $skill, $sock, $harm, $ref, $paytype, $desc, $maincat, $subcat, $img, $sale, $lvl, $store, $exc, $gift)
    {
        global $dB;
        $query = $dB->query("UPDATE [dbo].[IMPERIAMUCMS_WEBSHOP] SET [item_id] = ?,[item_cat] = ?,[max_item_lvl] = ?,[max_item_opt] = ?,[exetype] = ?,[name] = ?,[price] = ?,[luck] = ?,[skill] = ?,[use_sockets] = ?,[use_harmony] = ?,[use_refinary] = ?,[payment_type] = ?,[description] = ?,[main_cat] = ?,[sub_cat] = ?,[image] = ?,[on_sale] = ?,[item_lvl] = ?,[store_count] = ?,[item_exc] = ?,[can_gift] = ? WHERE [id] = ?", [$item_id, $item_cat, $max_lvl, $max_opt, $exetype, $name, $price, $luck, $skill, $sock, $harm, $ref, $paytype, $desc, $maincat, $subcat, $img, $sale, $lvl, $store, $exc, $gift, $id]);
        if ($query) {
            message("success", "Item was successfully updated.");
        } else {
            message("error", "Error occurred.");
        }
    }
    public function getItemsInventory($username)
    {
        global $dB;
        if (!Validator::UsernameLength($username)) {
            message("error", lang("error_5", true));
        } else {
            if (!Validator::AlphaNumeric($username)) {
                message("error", lang("error_6", true));
            } else {
                if (check_value($username)) {
                    $result = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_WEBSHOP_ITEMS_INVENTORY WHERE AccountID = ? AND status = '0' ORDER BY date desc", [$username]);
                }
                if (is_array($result)) {
                    return $result;
                }
                return NULL;
            }
        }
    }
    public function getGiftsInventory($username)
    {
        global $dB;
        if (!Validator::UsernameLength($username)) {
            message("error", lang("error_5", true));
        } else {
            if (!Validator::AlphaNumeric($username)) {
                message("error", lang("error_6", true));
            } else {
                if (check_value($username)) {
                    $result = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_WEBSHOP_GIFTS_INVENTORY WHERE AccountID_To = ? AND status = '0' ORDER BY date desc", [$username]);
                }
                if (is_array($result)) {
                    return $result;
                }
                return NULL;
            }
        }
    }
    public function withdrawItem($username, $item_id, $type)
    {
        global $dB;
        global $common;
        $item_id = xss_clean($item_id);
        if (!is_numeric($item_id)) {
            message("error", lang("webshop_txt_1", true));
        } else {
            $Market = new Market();
            $Items = new Items();
            if (!Validator::UsernameLength($username)) {
                message("error", lang("error_5", true));
            } else {
                if (!Validator::AlphaNumeric($username)) {
                    message("error", lang("error_6", true));
                } else {
                    if (check_value($username) && check_value($item_id)) {
                        if (!$common->accountOnline($username)) {
                            $vault = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT Items FROM warehouse WHERE AccountID = ?), 2) AS vault", [$username]);
                            $vault = $vault["vault"];
                            $item = $this->getItemById($username, $item_id, "store");
                            $item = $item["item"];
                            $ItemInfo = $Items->ItemInfo($item);
                            $test = 0;
                            $slot = $Market->smartsearch2($username, $vault, $ItemInfo["X"], $ItemInfo["Y"]);
                            $test = $slot * __ITEM_LENGTH__;
                            if ($slot == 1337) {
                                message("error", lang("webshop_txt_2", true));
                            } else {
                                $newvault = substr_replace($vault, $item, $test, __ITEM_LENGTH__);
                                $newvault = "0x" . $newvault;
                                if ($type == "store") {
                                    if ($this->checkItemById($username, $item_id, "store")) {
                                        $update = $dB->query("UPDATE [warehouse] SET [Items] = " . $newvault . " WHERE [AccountID] = '" . $username . "'");
                                        $update2 = $dB->query("UPDATE IMPERIAMUCMS_WEBSHOP_ITEMS_INVENTORY SET status = '1' WHERE id = ?", [$item_id]);
                                        message("success", lang("webshop_txt_3", true));
                                        redirect("2", "usercp/items", 5);
                                    } else {
                                        message("error", lang("webshop_txt_4", true));
                                        redirect("2", "usercp/items", 5);
                                    }
                                } else {
                                    if ($type == "gift") {
                                        if ($this->checkItemById($username, $item_id, "gift")) {
                                            $update = $dB->query("UPDATE [warehouse] SET [Items]= " . $newvault . " WHERE [AccountID] = '" . $username . "'");
                                            $update2 = $dB->query("UPDATE IMPERIAMUCMS_WEBSHOP_ITEMS_INVENTORY SET status = '1' WHERE id = ?", [$item_id]);
                                            message("success", lang("webshop_txt_3", true));
                                            redirect("2", "usercp/items", 5);
                                        } else {
                                            message("error", lang("webshop_txt_4", true));
                                            redirect("2", "usercp/items", 5);
                                        }
                                    }
                                }
                            }
                        } else {
                            message("error", lang("webshop_txt_5", true));
                        }
                    } else {
                        message("error", lang("error_4", true));
                    }
                }
            }
        }
    }
    public function getItemById($username, $item_id, $type)
    {
        global $dB;
        $item_id = xss_clean($item_id);
        if (!is_numeric($item_id)) {
            return NULL;
        }
        if (!Validator::UsernameLength($username)) {
            message("error", lang("error_5", true));
        } else {
            if (!Validator::AlphaNumeric($username)) {
                message("error", lang("error_6", true));
            } else {
                if (check_value($username) && check_value($item_id) && check_value($type)) {
                    if ($type == "store") {
                        $result = $dB->query_fetch_single("SELECT TOP 1 * FROM IMPERIAMUCMS_WEBSHOP_ITEMS_INVENTORY WHERE id = ? AND status = '0' AND AccountID = ?", [$item_id, $username]);
                    } else {
                        if ($type == "gift") {
                            $result = $dB->query_fetch_single("SELECT TOP 1 * FROM IMPERIAMUCMS_WEBSHOP_GIFTS_INVENTORY WHERE id = ? AND status = '0' AND AccountID_To = ?", [$item_id, $username]);
                        }
                    }
                    return $result;
                }
            }
        }
    }
    public function checkItemById($username, $item_id, $type)
    {
        global $dB;
        $item_id = xss_clean($item_id);
        if (!is_numeric($item_id)) {
            return NULL;
        }
        if (!Validator::UsernameLength($username)) {
            message("error", lang("error_5", true));
        } else {
            if (!Validator::AlphaNumeric($username)) {
                message("error", lang("error_6", true));
            } else {
                if (check_value($username) && check_value($item_id) && check_value($type)) {
                    if ($type == "store") {
                        $result = $dB->query_fetch_single("SELECT TOP 1 * FROM IMPERIAMUCMS_WEBSHOP_ITEMS_INVENTORY WHERE id = ? AND AccountID = ?", [$item_id, $username]);
                    } else {
                        if ($type == "gift") {
                            $result = $dB->query_fetch_single("SELECT TOP 1 * FROM IMPERIAMUCMS_WEBSHOP_GIFTS_INVENTORY WHERE id = ? AND AccountID_To = ?", [$item_id, $username]);
                        }
                    }
                    if ($result["status"] == "0") {
                        return true;
                    }
                    return false;
                }
            }
        }
    }
    public function getPaymentType($id, $cat)
    {
        global $dB;
        $id = xss_clean($id);
        $cat = xss_clean($cat);
        if (!is_numeric($id)) {
            return NULL;
        }
        if (!is_numeric($cat)) {
            return NULL;
        }
        $payment_type = $dB->query_fetch_single("SELECT TOP 1 payment_type FROM IMPERIAMUCMS_WEBSHOP WHERE item_id = ? AND item_cat = ?", [$id, $cat]);
        $payment_type = $payment_type["payment_type"];
        return $payment_type;
    }
    public function loadPayments($id = NULL, $table = "IMPERIAMUCMS_WEBSHOP")
    {
        global $dB;
        $id = xss_clean($id);
        if (!is_numeric($id)) {
            return NULL;
        }
        loadModuleConfigs("webshop");
        if (mconfig("is_global_active")) {
            $payments = mconfig("payment_type");
        } else {
            if ($id == NULL) {
                message("error", "Parameter can not be null.");
            } else {
                $tmp = $dB->query_fetch_single("SELECT TOP 1 payment_type FROM " . $table . " WHERE id = ?", [$id]);
                $payments = $tmp["payment_type"];
            }
        }
        if ($payments < 4) {
            $paymentx["gp"] = 0;
        } else {
            $paymentx["gp"] = 1;
            $payments += -4;
        }
        if ($payments < 2) {
            $paymentx["wcoinp"] = 0;
        } else {
            $paymentx["wcoinp"] = 1;
            $payments += -2;
        }
        if ($payments < 1) {
            $paymentx["wcoinc"] = 0;
        } else {
            $paymentx["wcoinc"] = 1;
            $payments += -1;
        }
        return $paymentx;
    }
    public function catName($cat)
    {
        switch ($cat) {
            case "1":
                $catName = "Special";
                break;
            case "2":
                $catName = "Weapons";
                break;
            case "3":
                $catName = "Equipment";
                break;
            case "4":
                $catName = "Wings";
                break;
            case "5":
                $catName = "Accessories";
                break;
            case "6":
                $catName = "Pets";
                break;
            case "7":
                $catName = "Crafting";
                break;
            default:
                $catName = "Unknown";
                return $catName;
        }
    }
    public function getAllCatItems($cat)
    {
        global $dB;
        $cat = xss_clean($cat);
        if (!is_numeric($cat)) {
            throw new Exception("Ouch.");
        }
        $query = "SELECT * FROM IMPERIAMUCMS_WEBSHOP WHERE main_cat = ? AND price > 0 ORDER BY on_sale DESC, sub_cat ASC, price ASC, item_id ASC";
        $array = [$cat];
        $items = $dB->query_fetch($query, $array);
        if (is_array($items)) {
            if (1 <= count($items)) {
                return $items;
            }
            return NULL;
        }
    }
    public function getCatItems($cat, $subcat)
    {
        global $dB;
        $cat = xss_clean($cat);
        $subcat = xss_clean($subcat);
        if ($subcat != "all" && !is_numeric($subcat) || !is_numeric($cat)) {
            throw new Exception("Ouch.");
        }
        $query = "SELECT * FROM IMPERIAMUCMS_WEBSHOP WHERE main_cat = ? AND sub_cat = ? AND price > 0 ORDER BY on_sale DESC, sub_cat ASC, price ASC, item_id ASC";
        $array = [$cat, $subcat];
        $items = $dB->query_fetch($query, $array);
        if (is_array($items)) {
            if (1 <= count($items)) {
                return $items;
            }
            return NULL;
        }
    }
    public function getPackages()
    {
        global $dB;
        $packages = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_WEBSHOP_PACKAGES WHERE status = '1' ORDER BY on_sale DESC, price ASC, name ASC");
        if (is_array($packages)) {
            if (1 <= count($packages)) {
                return $packages;
            }
            return NULL;
        }
    }
    public function getPackagesAdmin()
    {
        global $dB;
        $packages = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_WEBSHOP_PACKAGES ORDER BY id");
        if (is_array($packages)) {
            if (1 <= count($packages)) {
                return $packages;
            }
            return NULL;
        }
    }
    public function getMystery()
    {
        global $dB;
        $mystery = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_WEBSHOP_MYSTERY WHERE status = '1' ORDER BY on_sale DESC, price ASC, name ASC");
        if (is_array($mystery)) {
            if (1 <= count($mystery)) {
                return $mystery;
            }
            return NULL;
        }
    }
    public function getMysteryAdmin()
    {
        global $dB;
        $mystery = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_WEBSHOP_MYSTERY ORDER BY id");
        if (is_array($mystery)) {
            if (1 <= count($mystery)) {
                return $mystery;
            }
            return NULL;
        }
    }
    public function isOnSale($id, $type)
    {
        global $dB;
        $id = xss_clean($id);
        if (!is_numeric($id)) {
            return NULL;
        }
        if ($type == "normal") {
            $result = $dB->query_fetch_single("SELECT TOP 1 on_sale FROM IMPERIAMUCMS_WEBSHOP WHERE id = ?", [$id]);
        } else {
            if ($type == "mystery") {
                $result = $dB->query_fetch_single("SELECT TOP 1 on_sale FROM IMPERIAMUCMS_WEBSHOP_MYSTERY WHERE id = ?", [$id]);
            } else {
                if ($type == "package") {
                    $result = $dB->query_fetch_single("SELECT TOP 1 on_sale FROM IMPERIAMUCMS_WEBSHOP_PACKAGES WHERE id = ?", [$id]);
                }
            }
        }
        if ("0" < $result["on_sale"]) {
            return $result["on_sale"];
        }
        return 0;
    }
    public function getImage($id)
    {
        global $dB;
        $id = xss_clean($id);
        if (!is_numeric($id)) {
            return NULL;
        }
        $result = $dB->query_fetch_single("SELECT TOP 1 image,item_id,item_cat FROM IMPERIAMUCMS_WEBSHOP WHERE id = ?", [$id]);
        if ($result["image"] != NULL && $result["image"] != "") {
            return __PATH_TEMPLATE__ . "img/items/" . $result["image"];
        }
        $path = __PATH_TEMPLATE__ . "img/items/" . $result["item_cat"] . "-" . $result["item_id"] . "-" . $result["item_lvl"] . ".gif";
        if (file_exists($path)) {
            return $path;
        }
        $path = __PATH_TEMPLATE__ . "img/items/" . $result["item_cat"] . "-" . $result["item_id"] . ".gif";
        return $path;
    }
    public function getExcOpts($id)
    {
        global $dB;
        $id = xss_clean($id);
        if (!is_numeric($id)) {
            return NULL;
        }
        $result = $dB->query_fetch_single("SELECT TOP 1 exetype FROM IMPERIAMUCMS_WEBSHOP WHERE id = ?", [$id]);
        $opts["exetype"] = $result["exetype"];
        switch ($result["exetype"]) {
            case 1:
                $opts["exc1"] = lang("market_txt_20", true);
                $opts["exc2"] = lang("market_txt_21", true);
                $opts["exc3"] = lang("market_txt_22", true);
                $opts["exc4"] = lang("market_txt_23", true);
                $opts["exc5"] = lang("market_txt_24", true);
                $opts["exc6"] = lang("market_txt_25", true);
                $opts["life"] = lang("market_txt_26", true);
                break;
            case 2:
                $opts["exc1"] = lang("market_txt_27", true);
                $opts["exc2"] = lang("market_txt_28", true);
                $opts["exc3"] = lang("market_txt_29", true);
                $opts["exc4"] = lang("market_txt_30", true);
                $opts["exc5"] = lang("market_txt_31", true);
                $opts["exc6"] = lang("market_txt_32", true);
                $opts["life"] = lang("market_txt_33", true);
                break;
            case 3:
                $opts["exc1"] = lang("market_txt_34", true);
                $opts["exc2"] = lang("market_txt_35", true);
                $opts["exc3"] = lang("market_txt_36", true);
                $opts["exc4"] = lang("market_txt_37", true);
                $opts["exc5"] = lang("market_txt_38", true);
                $opts["exc6"] = "";
                $opts["life"] = lang("market_txt_26", true);
                break;
            case 4:
                $opts["exc1"] = lang("market_txt_39", true);
                $opts["exc2"] = lang("market_txt_40", true);
                $opts["exc3"] = lang("market_txt_41", true);
                $opts["exc4"] = lang("market_txt_42", true);
                $opts["exc5"] = "";
                $opts["exc6"] = "";
                $opts["life"] = lang("market_txt_26", true);
                break;
            case 5:
                $opts["exc1"] = lang("market_txt_34", true);
                $opts["exc2"] = lang("market_txt_35", true);
                $opts["exc3"] = lang("market_txt_36", true);
                $opts["exc4"] = lang("market_txt_43", true);
                $opts["exc5"] = "";
                $opts["exc6"] = "";
                $opts["life"] = lang("market_txt_26", true);
                break;
            case 6:
                $opts["exc1"] = lang("market_txt_34", true);
                $opts["exc2"] = lang("market_txt_35", true);
                $opts["exc3"] = lang("market_txt_36", true);
                $opts["exc4"] = "";
                $opts["exc5"] = "";
                $opts["exc6"] = "";
                $opts["life"] = lang("market_txt_26", true);
                break;
            case 7:
                $opts["exc1"] = lang("market_txt_36", true);
                $opts["exc2"] = lang("market_txt_41", true);
                $opts["exc3"] = "";
                $opts["exc4"] = "";
                $opts["exc5"] = "";
                $opts["exc6"] = "";
                $opts["life"] = lang("market_txt_26", true);
                break;
            case 8:
                $opts["exc1"] = lang("market_txt_44", true);
                $opts["exc2"] = lang("market_txt_45", true);
                $opts["exc3"] = lang("market_txt_46", true);
                $opts["exc4"] = "";
                $opts["exc5"] = "";
                $opts["exc6"] = "";
                $opts["life"] = "Additional Damage";
                break;
            case 9:
                $opts["exc1"] = lang("market_txt_47", true);
                $opts["exc2"] = lang("market_txt_48", true);
                $opts["exc3"] = lang("market_txt_49", true);
                $opts["exc4"] = lang("market_txt_50", true);
                $opts["exc5"] = "";
                $opts["exc6"] = "";
                $opts["life"] = lang("market_txt_26", true);
                break;
            default:
                $opts["exc1"] = "";
                $opts["exc2"] = "";
                $opts["exc3"] = "";
                $opts["exc4"] = "";
                $opts["exc5"] = "";
                $opts["exc6"] = "";
                $opts["life"] = "";
                return $opts;
        }
    }
    public function isAncient($id)
    {
        global $dB;
        $id = xss_clean($id);
        if (!is_numeric($id)) {
            return NULL;
        }
        $tmp = $dB->query_fetch_single("SELECT TOP 1 item_id,item_cat FROM IMPERIAMUCMS_WEBSHOP WHERE id = ?", [$id]);
        $result = $dB->query_fetch_single("SELECT TOP 1 * FROM IMPERIAMUCMS_DATA_ANCIENT_ITEMS WHERE item_id = ? AND item_cat = ?", [$tmp["item_id"], $tmp["item_cat"]]);
        if (is_array($result)) {
            $anc["anc1"] = $result["tier1"];
            $anc["anc2"] = $result["tier2"];
            return $anc;
        }
        return NULL;
    }
    public function getAncData($anc_id)
    {
        global $dB;
        $anc_id = xss_clean($anc_id);
        if (!is_numeric($anc_id)) {
            return NULL;
        }
        $result = $dB->query_fetch_single("SELECT TOP 1 * FROM IMPERIAMUCMS_DATA_ANCIENT_SETS WHERE ancient_id = ? AND available <= ?", [$anc_id, config("server_files_season", true)]);
        if (is_array($result)) {
            return $result;
        }
        return NULL;
    }
    public function getSockets($item_cat)
    {
        global $dB;
        $item_cat = xss_clean($item_cat);
        if (!is_numeric($item_cat)) {
            return NULL;
        }
        if ($item_cat < 6) {
            $socket_part_type = 0;
        } else {
            if (5 < $item_cat && $item_cat <= 12) {
                $socket_part_type = 1;
            } else {
                $socket_part_type = -1;
            }
        }
        $sockets = $dB->query_fetch("\r\n            SELECT * FROM IMPERIAMUCMS_DATA_SOCKETS \r\n            WHERE socket_type = ? AND (item_type = ? OR item_type = ?) AND available <= ? AND active = ?\r\n            ORDER BY socket_order ASC", [1, -1, $socket_part_type, config("server_files_season", true), 1]);
        if (is_array($sockets)) {
            if (1 <= count($sockets)) {
                return $sockets;
            }
            return NULL;
        }
    }
    public function getBonusSockets($item_cat)
    {
        global $dB;
        $item_cat = xss_clean($item_cat);
        if (!is_numeric($item_cat)) {
            return NULL;
        }
        if ($item_cat == 5) {
            $socket_part_type = 2;
        } else {
            if ($item_cat < 6) {
                $socket_part_type = 0;
            } else {
                if (5 < $item_cat && $item_cat <= 12) {
                    $socket_part_type = 1;
                } else {
                    $socket_part_type = -1;
                }
            }
        }
        $sockets = $dB->query_fetch("\r\n            SELECT * FROM IMPERIAMUCMS_DATA_SOCKETS \r\n            WHERE socket_type = ? AND (item_type = ? OR item_type = ?) AND available <= ? AND active = ?\r\n            ORDER BY socket_order ASC", [2, -1, $socket_part_type, config("server_files_season", true), 1]);
        if (is_array($sockets)) {
            if (1 <= count($sockets)) {
                return $sockets;
            }
            return NULL;
        }
    }
    public function getHarmony($item_cat)
    {
        global $dB;
        $item_cat = xss_clean($item_cat);
        if (!is_numeric($item_cat)) {
            return NULL;
        }
        if ($item_cat < 5) {
            $item_type = 1;
        } else {
            if ($item_cat == 5) {
                $item_type = 2;
            } else {
                if (5 < $item_cat && $item_cat < 12) {
                    $item_type = 3;
                } else {
                    $item_type = -1;
                }
            }
        }
        $harmony = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_WEBSHOP_HARMONY WHERE status = 1 AND itemtype = ? ORDER BY hoption, hvalue", [$item_type]);
        if (is_array($harmony)) {
            if (1 <= count($harmony)) {
                return $harmony;
            }
            return NULL;
        }
    }
    public function getPackageData($id)
    {
        global $dB;
        $id = xss_clean($id);
        if (!is_numeric($id)) {
            return NULL;
        }
        $data = $dB->query_fetch_single("SELECT TOP 1 * FROM IMPERIAMUCMS_WEBSHOP_PACKAGES WHERE id = ?", [$id]);
        if (is_array($data)) {
            return $data;
        }
        return NULL;
    }
    public function getPackageItems($id)
    {
        global $dB;
        $id = xss_clean($id);
        if (!is_numeric($id)) {
            return NULL;
        }
        $data = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_WEBSHOP_PACKAGES_ITEMS WHERE package_id = ?", [$id]);
        if (is_array($data)) {
            return $data;
        }
        return NULL;
    }
    public function getMysteryData($id)
    {
        global $dB;
        $id = xss_clean($id);
        if (!is_numeric($id)) {
            return NULL;
        }
        $data = $dB->query_fetch_single("SELECT TOP 1 * FROM IMPERIAMUCMS_WEBSHOP_MYSTERY WHERE id = ?", [$id]);
        if (is_array($data)) {
            return $data;
        }
        return NULL;
    }
    public function getMysteryItems($id)
    {
        global $dB;
        $id = xss_clean($id);
        if (!is_numeric($id)) {
            return NULL;
        }
        $data = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_WEBSHOP_MYSTERY_ITEMS WHERE mystery_id = ?", [$id]);
        if (is_array($data)) {
            return $data;
        }
        return NULL;
    }
    public function retrieveSockets($sub_cat = NULL)
    {
        global $dB;
        if ($sub_cat == NULL) {
            $result = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_DATA_SOCKETS WHERE available <= ? ORDER BY socket_order", [config("server_files_season", true)]);
        } else {
            $sub_cat = xss_clean($sub_cat);
            if (!is_numeric($sub_cat)) {
                return NULL;
            }
            $result = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_DATA_SOCKETS WHERE socket_name like ? AND available <= ? ORDER BY socket_order", ["%" . $sub_cat . "%", config("server_files_season", true)]);
        }
        if (is_array($result)) {
            return $result;
        }
        return NULL;
    }
    public function disableSocket($id)
    {
        global $dB;
        $update = $dB->query("UPDATE IMPERIAMUCMS_DATA_SOCKETS SET active = 0 where id = ?", [$id]);
        if ($update) {
            return true;
        }
        return false;
    }
    public function enableSocket($id)
    {
        global $dB;
        $update = $dB->query("UPDATE IMPERIAMUCMS_DATA_SOCKETS SET active = 1 where id = ?", [$id]);
        if ($update) {
            return true;
        }
        return false;
    }
    public function loadSocketData($id)
    {
        global $dB;
        $id = xss_clean($id);
        if (!is_numeric($id)) {
            return NULL;
        }
        $data = $dB->query_fetch_single("SELECT TOP 1 * FROM IMPERIAMUCMS_DATA_SOCKETS WHERE socket_id = ?", [$id]);
        if (is_array($data)) {
            return $data;
        }
        return NULL;
    }
    public function loadNormalSocketData($socket_id)
    {
        global $dB;
        $socket_id = xss_clean($socket_id);
        if (!is_numeric($socket_id)) {
            return NULL;
        }
        $data = $dB->query_fetch_single("SELECT TOP 1 * FROM IMPERIAMUCMS_DATA_SOCKETS WHERE socket_id = ? AND socket_type = ?", [$socket_id, 1]);
        if (is_array($data)) {
            return $data;
        }
        return NULL;
    }
    public function loadBonusSocketData($socket_id)
    {
        global $dB;
        $socket_id = xss_clean($socket_id);
        if (!is_numeric($socket_id)) {
            return NULL;
        }
        $data = $dB->query_fetch_single("SELECT TOP 1 * FROM IMPERIAMUCMS_DATA_SOCKETS WHERE socket_id = ? AND socket_type = ?", [$socket_id, 2]);
        if (is_array($data)) {
            return $data;
        }
        return NULL;
    }
    public function updateSocket($id, $name, $price, $status)
    {
        global $dB;
        $query = $dB->query("\r\n            UPDATE [dbo].[IMPERIAMUCMS_DATA_SOCKETS] SET [socket_name] = ?, [price] = ?, [active] = ?\r\n            WHERE id = ?", [$name, $price, $status, $id]);
        if ($query) {
            message("success", "Socket was successfully updated.");
        } else {
            message("error", "Error occurred.");
        }
    }
    public function retrieveHarmony($sub_cat = NULL)
    {
        global $dB;
        if ($sub_cat == NULL) {
            $result = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_WEBSHOP_HARMONY ORDER BY itemtype, hoption, hvalue");
        } else {
            $sub_cat = xss_clean($sub_cat);
            if (!is_numeric($sub_cat)) {
                return NULL;
            }
            $result = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_WEBSHOP_HARMONY WHERE itemtype = ? ORDER BY itemtype, hoption, hvalue", [$sub_cat]);
        }
        if (is_array($result)) {
            return $result;
        }
        return NULL;
    }
    public function disableHarmony($id)
    {
        global $dB;
        $update = $dB->query("UPDATE IMPERIAMUCMS_WEBSHOP_HARMONY SET status = 0 where id = ?", [$id]);
        if ($update) {
            return true;
        }
        return false;
    }
    public function enableHarmony($id)
    {
        global $dB;
        $update = $dB->query("UPDATE IMPERIAMUCMS_WEBSHOP_HARMONY SET status = 1 where id = ?", [$id]);
        if ($update) {
            return true;
        }
        return false;
    }
    public function loadHarmonyData($id)
    {
        global $dB;
        $id = xss_clean($id);
        if (!is_numeric($id)) {
            return NULL;
        }
        $data = $dB->query_fetch_single("SELECT TOP 1 * FROM IMPERIAMUCMS_WEBSHOP_HARMONY WHERE id = ?", [$id]);
        if (is_array($data)) {
            return $data;
        }
        return NULL;
    }
    public function updateHarmony($id, $name, $price, $status, $value)
    {
        global $dB;
        $query = $dB->query("\r\n      UPDATE [dbo].[IMPERIAMUCMS_WEBSHOP_HARMONY]\r\n         SET [hname] = '" . $name . "', [price] = " . $price . ", [status] = " . $status . ", [hvalue] = " . $value . "\r\n       WHERE id = '" . $id . "'");
        if ($query) {
            message("success", "Harmony was successfully updated.");
        } else {
            message("error", "Error occurred.");
        }
    }
    public function disablePackage($id)
    {
        global $dB;
        $update = $dB->query("UPDATE IMPERIAMUCMS_WEBSHOP_PACKAGES SET status = 0 where id = ?", [$id]);
        if ($update) {
            return true;
        }
        return false;
    }
    public function enablePackage($id)
    {
        global $dB;
        $update = $dB->query("UPDATE IMPERIAMUCMS_WEBSHOP_PACKAGES SET status = 1 where id = ?", [$id]);
        if ($update) {
            return true;
        }
        return false;
    }
    public function addPackage($name, $price, $payment_type, $on_sale, $img, $desc, $count)
    {
        global $dB;
        $insert = $dB->query("INSERT INTO IMPERIAMUCMS_WEBSHOP_PACKAGES(name,price,payment_type,on_sale,description,total_bought,image,status,store_count) VALUES(?,?,?,?,?,?,?,?,?)", [$name, $price, $payment_type, $on_sale, $desc, 0, $img, 1, $count]);
        if ($insert) {
            message("success", "Package was successfully created.");
        } else {
            message("error", "Error occurred.");
        }
    }
    public function addPackageItem($package_id, $item)
    {
        global $dB;
        $insert = $dB->query("INSERT INTO IMPERIAMUCMS_WEBSHOP_PACKAGES_ITEMS(package_id,item_hex) VALUES(?,?)", [$package_id, $item]);
        if ($insert) {
            message("success", "Item " . $item . " was successfully added to package #" . $package_id . ".");
        } else {
            message("error", "Error occurred.");
        }
    }
    public function editPackage($id, $name, $price, $payment_type, $on_sale, $img, $desc, $status, $count)
    {
        global $dB;
        $update = $dB->query("UPDATE IMPERIAMUCMS_WEBSHOP_PACKAGES SET name=?,price=?,payment_type=?,on_sale=?,description=?,image=?,status=?,store_count=? WHERE id = ?", [$name, $price, $payment_type, $on_sale, $desc, $img, $status, $count, $id]);
        if ($update) {
            message("success", "Package was successfully created.");
        } else {
            message("error", "Error occurred.");
        }
    }
    public function disableMystery($id)
    {
        global $dB;
        $update = $dB->query("UPDATE IMPERIAMUCMS_WEBSHOP_MYSTERY SET status = 0 where id = ?", [$id]);
        if ($update) {
            return true;
        }
        return false;
    }
    public function enableMystery($id)
    {
        global $dB;
        $update = $dB->query("UPDATE IMPERIAMUCMS_WEBSHOP_MYSTERY SET status = 1 where id = ?", [$id]);
        if ($update) {
            return true;
        }
        return false;
    }
    public function addMystery($name, $price, $payment_type, $on_sale, $img, $desc, $count)
    {
        global $dB;
        $insert = $dB->query("INSERT INTO IMPERIAMUCMS_WEBSHOP_MYSTERY(name,price,payment_type,on_sale,description,total_bought,image,status,store_count) VALUES(?,?,?,?,?,?,?,?,?)", [$name, $price, $payment_type, $on_sale, $desc, 0, $img, 1, $count]);
        if ($insert) {
            message("success", "Mystery Box was successfully created.");
        } else {
            message("error", "Error occurred.");
        }
    }
    public function addMysteryItem($mystery_id, $item, $chance)
    {
        global $dB;
        $insert = $dB->query("INSERT INTO IMPERIAMUCMS_WEBSHOP_MYSTERY_ITEMS(mystery_id,item_hex,chance) VALUES(?,?,?)", [$mystery_id, $item, $chance]);
        if ($insert) {
            message("success", "Item " . $item . " was successfully added to mystery box #" . $mystery_id . ".");
        } else {
            message("error", "Error occurred.");
        }
    }
    public function editMystery($id, $name, $price, $payment_type, $on_sale, $img, $desc, $status, $count)
    {
        global $dB;
        $update = $dB->query("UPDATE IMPERIAMUCMS_WEBSHOP_MYSTERY SET name=?,price=?,payment_type=?,on_sale=?,description=?,image=?,status=?,store_count=? WHERE id = ?", [$name, $price, $payment_type, $on_sale, $desc, $img, $status, $count, $id]);
        if ($update) {
            message("success", "Mystery Box was successfully created.");
        } else {
            message("error", "Error occurred.");
        }
    }
    public function buyItem($username, $item, $price, $pricetype, $item_id, $stock)
    {
        global $dB;
        global $dB2;
        $item = xss_clean($item);
        $price = xss_clean($price);
        $pricetype = xss_clean($pricetype);
        $item_id = xss_clean($item_id);
        $stock = xss_clean($stock);
        if (!is_numeric($item_id)) {
            return NULL;
        }
        if (!is_numeric($price)) {
            return NULL;
        }
        if (!check_value($username)) {
            message("error", lang("error_4", true));
        } else {
            if (!check_value($item)) {
                message("error", lang("error_4", true));
            } else {
                if (!check_value($price)) {
                    message("error", lang("error_4", true));
                } else {
                    if (!check_value($pricetype)) {
                        message("error", lang("error_4", true));
                    } else {
                        if (!check_value($item_id)) {
                            message("error", lang("error_4", true));
                        } else {
                            if (!check_value($stock)) {
                                message("error", lang("error_4", true));
                            } else {
                                if (!Validator::UsernameLength($username)) {
                                    message("error", lang("error_5", true));
                                } else {
                                    if (!Validator::AlphaNumeric($username)) {
                                        message("error", lang("error_6", true));
                                    } else {
                                        $date = date("Y-m-d H:i:s", time());
                                        $insert = $dB->query("INSERT INTO IMPERIAMUCMS_WEBSHOP_ITEMS_INVENTORY(AccountID,item,price,price_type,date,status,type,giftFrom)\r\n                          VALUES(?,?,?,?,?,?,?,?)", [$username, $item, $price, $pricetype, $date, "0", "1", NULL]);
                                        if ($stock == "-1") {
                                            $update = $dB->query("UPDATE IMPERIAMUCMS_WEBSHOP SET total_bought = total_bought + 1 WHERE id = ?", [$item_id]);
                                        } else {
                                            $update = $dB->query("UPDATE IMPERIAMUCMS_WEBSHOP SET store_count = store_count - 1, total_bought = total_bought + 1 WHERE id = ?", [$item_id]);
                                        }
                                        switch ($pricetype) {
                                            case "1":
                                                if (100 <= config("server_files_season", true)) {
                                                    $check = $dB->query_fetch_single("SELECT WCoin FROM T_InGameShop_Point WHERE AccountID = ?", [$username]);
                                                    if ($check["WCoin"] < $price) {
                                                        message("error", sprintf(lang("webshop_txt_6", true), lang("currency_wcoinc", true)));
                                                        return NULL;
                                                    }
                                                    $deduct = $dB->query("UPDATE T_InGameShop_Point SET WCoin = WCoin - ? WHERE AccountID = ?", [$price, $username]);
                                                } else {
                                                    $check = $dB->query_fetch_single("SELECT WCoinC FROM T_InGameShop_Point WHERE AccountID = ?", [$username]);
                                                    if ($check["WCoinC"] < $price) {
                                                        message("error", sprintf(lang("webshop_txt_6", true), lang("currency_wcoinc", true)));
                                                        return NULL;
                                                    }
                                                    $deduct = $dB->query("UPDATE T_InGameShop_Point SET WCoinC = WCoinC - ? WHERE AccountID = ?", [$price, $username]);
                                                }
                                                break;
                                            case "2":
                                                $check = $dB->query_fetch_single("SELECT WCoinP FROM T_InGameShop_Point WHERE AccountID = ?", [$username]);
                                                if ($check["WCoinP"] < $price) {
                                                    message("error", sprintf(lang("webshop_txt_6", true), lang("currency_wcoinp", true)));
                                                } else {
                                                    $deduct = $dB->query("UPDATE T_InGameShop_Point SET WCoinP = WCoinP - ? WHERE AccountID = ?", [$price, $username]);
                                                }
                                                break;
                                            case "4":
                                                $check = $dB->query_fetch_single("SELECT GoblinPoint FROM T_InGameShop_Point WHERE AccountID = ?", [$username]);
                                                if ($check["GoblinPoint"] < $price) {
                                                    message("error", sprintf(lang("webshop_txt_6", true), lang("currency_gp", true)));
                                                } else {
                                                    $deduct = $dB->query("UPDATE T_InGameShop_Point SET GoblinPoint = GoblinPoint - ? WHERE AccountID = ?", [$price, $username]);
                                                    if ($insert && $deduct) {
                                                        return true;
                                                    }
                                                    return false;
                                                }
                                                break;
                                            default:
                                                message("error", lang("webshop_txt_7", true));
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    public function addLog($username, $item, $price, $pricetype, $type)
    {
        global $dB;
        $item = xss_clean($item);
        $price = xss_clean($price);
        $pricetype = xss_clean($pricetype);
        $type = xss_clean($type);
        if (!is_numeric($price)) {
            return NULL;
        }
        if (!check_value($username)) {
            message("error", lang("error_4", true));
        } else {
            if (!check_value($item)) {
                message("error", lang("error_4", true));
            } else {
                if (!check_value($price)) {
                    message("error", lang("error_4", true));
                } else {
                    if (!check_value($pricetype)) {
                        message("error", lang("error_4", true));
                    } else {
                        if (!Validator::UsernameLength($username)) {
                            message("error", lang("error_5", true));
                        } else {
                            if (!Validator::AlphaNumeric($username)) {
                                message("error", lang("error_6", true));
                            } else {
                                $date = date("Y-m-d H:i:s", time());
                                $insert = $dB->query("INSERT INTO IMPERIAMUCMS_WEBSHOP_LOGS(AccountID,item,price,price_type,date,ip,type)\r\n                          VALUES(?,?,?,?,?,?,?)", [$username, $item, $price, $pricetype, $date, $_SERVER["REMOTE_ADDR"], $type]);
                            }
                        }
                    }
                }
            }
        }
    }
    public function computePrice($item_price, $exetype, $level, $life, $luck, $skill, $harmony_price, $refinery, $exc1, $exc2, $exc3, $exc4, $exc5, $exc6, $ancopt, $stamina, $socket1_price, $socket2_price, $socket3_price, $socket4_price, $socket5_price, $socket99_price, $on_sale)
    {
        $level_price = $level * mconfig("level");
        $life_price = $life * mconfig("life");
        $luck_price = $luck * mconfig("luck");
        $skill_price = $skill * mconfig("skill");
        $refinery_price = $refinery * mconfig("refin");
        $opt_price = 0;
        $opt_price += $level_price;
        $opt_price += $life_price;
        $opt_price += $luck_price;
        $opt_price += $skill_price;
        $opt_price += $harmony_price;
        $opt_price += $refinery_price;
        switch ($exetype) {
            case "1":
                $opt_price += $exc1 * mconfig("exc11");
                $opt_price += $exc2 * mconfig("exc12");
                $opt_price += $exc3 * mconfig("exc13");
                $opt_price += $exc4 * mconfig("exc14");
                $opt_price += $exc5 * mconfig("exc15");
                $opt_price += $exc6 * mconfig("exc16");
                break;
            case "2":
                $opt_price += $exc1 * mconfig("exc21");
                $opt_price += $exc2 * mconfig("exc22");
                $opt_price += $exc3 * mconfig("exc23");
                $opt_price += $exc4 * mconfig("exc24");
                $opt_price += $exc5 * mconfig("exc25");
                $opt_price += $exc6 * mconfig("exc26");
                break;
            case "3":
                $opt_price += $exc1 * mconfig("exc31");
                $opt_price += $exc2 * mconfig("exc32");
                $opt_price += $exc3 * mconfig("exc33");
                $opt_price += $exc4 * mconfig("exc34");
                $opt_price += $exc5 * mconfig("exc35");
                $opt_price += $exc6 * mconfig("exc36");
                break;
            case "4":
                $opt_price += $exc1 * mconfig("exc41");
                $opt_price += $exc2 * mconfig("exc42");
                $opt_price += $exc3 * mconfig("exc43");
                $opt_price += $exc4 * mconfig("exc44");
                $opt_price += $exc5 * mconfig("exc45");
                $opt_price += $exc6 * mconfig("exc46");
                break;
            case "5":
                $opt_price += $exc1 * mconfig("exc51");
                $opt_price += $exc2 * mconfig("exc52");
                $opt_price += $exc3 * mconfig("exc53");
                $opt_price += $exc4 * mconfig("exc54");
                $opt_price += $exc5 * mconfig("exc55");
                $opt_price += $exc6 * mconfig("exc56");
                break;
            case "6":
                $opt_price += $exc1 * mconfig("exc61");
                $opt_price += $exc2 * mconfig("exc62");
                $opt_price += $exc3 * mconfig("exc63");
                $opt_price += $exc4 * mconfig("exc64");
                $opt_price += $exc5 * mconfig("exc65");
                $opt_price += $exc6 * mconfig("exc66");
                break;
            case "7":
                $opt_price += $exc1 * mconfig("exc71");
                $opt_price += $exc2 * mconfig("exc72");
                $opt_price += $exc3 * mconfig("exc73");
                $opt_price += $exc4 * mconfig("exc74");
                $opt_price += $exc5 * mconfig("exc75");
                $opt_price += $exc6 * mconfig("exc76");
                break;
            case "8":
                $opt_price += $exc1 * mconfig("exc81");
                $opt_price += $exc2 * mconfig("exc82");
                $opt_price += $exc3 * mconfig("exc83");
                $opt_price += $exc4 * mconfig("exc84");
                $opt_price += $exc5 * mconfig("exc85");
                $opt_price += $exc6 * mconfig("exc86");
                break;
            case "9":
                $opt_price += $exc1 * mconfig("exc91");
                $opt_price += $exc2 * mconfig("exc92");
                $opt_price += $exc3 * mconfig("exc93");
                $opt_price += $exc4 * mconfig("exc94");
                $opt_price += $exc5 * mconfig("exc95");
                $opt_price += $exc6 * mconfig("exc96");
                break;
            default:
                if (0 < $ancopt && 0 < $stamina) {
                    switch ($stamina) {
                        case "5":
                            $opt_price += mconfig("anc11");
                            break;
                        case "6":
                            $opt_price += mconfig("anc21");
                            break;
                        case "9":
                            $opt_price += mconfig("anc12");
                            break;
                        case "10":
                            $opt_price += mconfig("anc22");
                            break;
                    }
                }
                $opt_price += $socket1_price;
                $opt_price += $socket2_price;
                $opt_price += $socket3_price;
                $opt_price += $socket4_price;
                $opt_price += $socket5_price;
                $opt_price += $socket99_price;
                $total_price = $item_price + $opt_price;
                if (0 < $on_sale && $on_sale < 100) {
                    $sale = 100 - $on_sale;
                    $total_price = $sale * $total_price / 100;
                }
                return $total_price;
        }
    }
    public function elementalTypes()
    {
        $elementTypes = ["None", "Fire", "Water", "Earth", "Wind", "Dark"];
        return $elementTypes;
    }
    public function elementalOptions()
    {
        $elements = ["anger" => ["1" => ["None", "Elemental Dmg %s"], "2" => ["None", "%s Attack Against Fire Element", "%s Attack Against Water Element", "%s Attack Against Earth Element", "%s Attack Against Wind Element", "%s Attack Against Dark Element"], "3" => ["None", "Elemental Attack Dmg (in PvP) %s", "Elemental Attack Dmg (in Raids) %s"], "4" => ["None", "Ranged Elemental Attack Dmg (in PvP) %s", "Melee Elemental Attack Dmg (in PvP) %s"], "5" => ["None", "Elemental Critical Rate (in PvP) %s", "Elemental Critical Rate (in Raids) %s"]], "blessing" => ["1" => ["None", "Elemental Defense %s"], "2" => ["None", "%s Defense Against Fire Element", "%s Defense Against Water Element", "%s Defense Against Earth Element", "%s Defense Against Wind Element", "%s Defense Against Dark Element"], "3" => ["None", "Elemental Defense (in PvP) %s", "Elemental Defense (in Raids) %s"], "4" => ["None", "Ranged Elemental Defense (in PvP) %s", "Melee Elemental Defense (in PvP) %s"], "5" => ["None", "Elemental Dmg (in PvP) %s", "Elemental Dmg (in Raids) %s"]], "integrity" => ["1" => ["None", "Elemental Attack Success Rate %s"], "2" => ["None", "%s Attack Against Fire Element", "%s Attack Against Water Element", "%s Attack Against Earth Element", "%s Attack Against Wind Element", "%s Attack Against Dark Element"], "3" => ["None", "Elemental Attack Dmg (in PvP) %s", "Elemental Attack Dmg (in Raids) %s"], "4" => ["None", "Ranged Elemental Attack Dmg (in PvP) %s", "Melee Elemental Attack Dmg (in PvP) %s"], "5" => ["None", "Elemental Damage (in PvP) %s", "Elemental Damage (in Raids) %s"]], "divinity" => ["1" => ["None", "Elemental Defense Success Rate %s"], "2" => ["None", "%s Defense Against Fire Element", "%s Defense Against Water Element", "%s Defense Against Earth Element", "%s Defense Against Wind Element", "%s Defense Against Dark Element"], "3" => ["None", "Elemental Defense (in PvP) %s", "Elemental Defense (in Raids) %s"], "4" => ["None", "Ranged Elemental Defense (in PvP) %s", "Melee Elemental Defense (in PvP) %s"], "5" => ["None", "Elemental Damage Absorb (in PvP) %s", "Elemental Damage Absorb (in Raids) %s"]], "gale" => ["1" => ["None", "Elemental Debuff Success Rate %s"], "2" => ["None", "Strength %s", "Agility %s", "Energy %s", "Stamina %s"], "3" => ["None", "Maximum HP %s", "Maximum Mana %s", "Maximum AG %s", "Maximum SD %s"], "4" => ["None", "Elemental Attack Excellent Rate (in PvP) %s", "Elemental Attack Excellent Rate (in Raids) %s"], "5" => ["None", "Additional Elemental Occurrence Chance %s"]]];
        return $elements;
    }
    public function elementalOptionsValues()
    {
        $elementsValues = ["anger" => ["1" => ["+30", "+33", "+38", "+45", "+54", "+65", "+78", "+93", "+113", "+138", "+168"], "2" => ["+5", "+6", "+7", "+8", "+9", "+10", "+12", "+14", "+16", "+18", "+20"], "3" => ["+30", "+35", "+43", "+54", "+66", "+80", "+97", "+117", "+142", "+172", "+207"], "4" => ["+30", "+35", "+43", "+54", "+66", "+80", "+97", "+117", "+142", "+172", "+207"], "5" => ["+5", "+6", "+7", "+8", "+9", "+10", "+12", "+14", "+16", "+18", "+20"]], "blessing" => ["1" => ["+10", "+13", "+17", "+22", "+28", "+35", "+43", "+52", "+62", "+73", "+85"], "2" => ["+5", "+6", "+7", "+8", "+9", "+10", "+12", "+14", "+16", "+18", "+20"], "3" => ["+10", "+13", "+17", "+22", "+28", "+35", "+43", "+52", "+62", "+73", "+85"], "4" => ["+10", "+13", "+17", "+22", "+28", "+35", "+43", "+52", "+62", "+73", "+85"], "5" => ["-5", "-6", "-7", "-8", "-9", "-10", "-12", "-14", "-16", "-18", "-20"]], "integrity" => ["1" => ["+5", "+6", "+7", "+8", "+9", "+10", "+12", "+14", "+16", "+18", "+20"], "2" => ["+5", "+6", "+7", "+8", "+9", "+10", "+12", "+14", "+16", "+18", "+20"], "3" => ["+30", "+35", "+43", "+54", "+66", "+80", "+97", "+117", "+142", "+172", "+207"], "4" => ["+30", "+35", "+43", "+54", "+66", "+80", "+97", "+117", "+142", "+172", "+207"], "5" => ["+5", "+7", "+9", "+11", "+13", "+15", "+18", "+21", "+24", "+27", "+30"]], "divinity" => ["1" => ["+5", "+6", "+7", "+8", "+9", "+10", "+12", "+14", "+16", "+18", "+20"], "2" => ["+5", "+6", "+7", "+8", "+9", "+10", "+12", "+14", "+16", "+18", "+20"], "3" => ["+10", "+13", "+17", "+22", "+28", "+35", "+43", "+52", "+62", "+73", "+85"], "4" => ["+10", "+13", "+17", "+22", "+28", "+35", "+43", "+52", "+62", "+73", "+85"], "5" => ["5", "7", "9", "11", "13", "15", "18", "21", "24", "27", "30"]], "gale" => ["1" => ["+1", "+2", "+3", "+4", "+5", "+6", "+7", "+8", "+10", "+12", "+15"], "2" => ["+10", "+15", "+20", "+25", "+30", "+35", "+40", "+45", "+50", "+55", "+60"], "3" => ["+20", "+25", "+30", "+35", "+40", "+50", "+60", "+70", "+80", "+90", "+100"], "4" => ["+30", "+35", "+43", "+54", "+66", "+80", "+97", "+117", "+142", "+172", "+207"], "5" => ["+1", "+2", "+3", "+4", "+5", "+6", "+7", "+8", "+10", "+12", "+15"]]];
        return $elementsValues;
    }
}

?>