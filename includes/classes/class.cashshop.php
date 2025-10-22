<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class CashShop
{
    public function addItem($name, $UniqueID1, $UniqueID2, $UniqueID3, $can_gift, $price, $price_type, $position, $cat, $subcat, $img, $desc)
    {
        global $dB;
        if (check_value($name) && check_value($UniqueID1) && check_value($UniqueID2) && check_value($UniqueID3) && check_value($can_gift) && check_value($price) && check_value($price_type) && check_value($position) && check_value($cat) && check_value($subcat)) {
            $error = false;
            $name = xss_clean($name);
            $UniqueID1 = xss_clean($UniqueID1);
            $UniqueID2 = xss_clean($UniqueID2);
            $UniqueID3 = xss_clean($UniqueID3);
            $can_gift = xss_clean($can_gift);
            $price = xss_clean($price);
            $price_type = xss_clean($price_type);
            $position = xss_clean($position);
            $cat = xss_clean($cat);
            $subcat = xss_clean($subcat);
            $img = xss_clean($img);
            $desc = xss_clean($desc);
            if (!is_numeric($UniqueID1)) {
                $error = true;
                message("error", "UniqueID1 must be a number!");
            }
            if (!is_numeric($UniqueID2)) {
                $error = true;
                message("error", "UniqueID2 must be a number!");
            }
            if (!is_numeric($UniqueID3)) {
                $error = true;
                message("error", "UniqueID3 must be a number!");
            }
            if (!is_numeric($position)) {
                $error = true;
                message("error", "Position must be a number!");
            }
            if (!is_numeric($price)) {
                $error = true;
                message("error", "Price must be a number!");
            }
            if (!is_numeric($price_type)) {
                $error = true;
                message("error", "Price type must be a number!");
            }
            if (!$error) {
                $insert = $dB->query("INSERT INTO IMPERIAMUCMS_CASHSHOP_ITEMS (name, UniqueID1, UniqueID2, UniqueID3, can_gift, price, price_type, img, description, category_id, subcategory_id, position, active) \n                                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$name, $UniqueID1, $UniqueID2, $UniqueID3, $can_gift, $price, $price_type, $img, $desc, $cat, $subcat, $position, 1]);
                if ($insert) {
                    message("success", "Item was successfully added into Cash Shop.");
                } else {
                    message("error", "There was an unexpected error, please check your values.");
                }
            }
        } else {
            message("error", "Empty values.");
        }
    }
    public function editItem($id, $name, $UniqueID1, $UniqueID2, $UniqueID3, $can_gift, $price, $price_type, $position, $cat, $subcat, $img, $desc)
    {
        global $dB;
        if (check_value($id) && check_value($name) && check_value($UniqueID1) && check_value($UniqueID2) && check_value($UniqueID3) && check_value($can_gift) && check_value($price) && check_value($price_type) && check_value($position) && check_value($cat) && check_value($subcat)) {
            $error = false;
            $name = xss_clean($name);
            $UniqueID1 = xss_clean($UniqueID1);
            $UniqueID2 = xss_clean($UniqueID2);
            $UniqueID3 = xss_clean($UniqueID3);
            $can_gift = xss_clean($can_gift);
            $price = xss_clean($price);
            $price_type = xss_clean($price_type);
            $position = xss_clean($position);
            $cat = xss_clean($cat);
            $subcat = xss_clean($subcat);
            $img = xss_clean($img);
            $desc = xss_clean($desc);
            if (!is_numeric($id)) {
                $error = true;
                message("error", "ID must be a number!");
            }
            if (!is_numeric($UniqueID1)) {
                $error = true;
                message("error", "UniqueID1 must be a number!");
            }
            if (!is_numeric($UniqueID2)) {
                $error = true;
                message("error", "UniqueID2 must be a number!");
            }
            if (!is_numeric($UniqueID3)) {
                $error = true;
                message("error", "UniqueID3 must be a number!");
            }
            if (!is_numeric($position)) {
                $error = true;
                message("error", "Position must be a number!");
            }
            if (!is_numeric($price)) {
                $error = true;
                message("error", "Price must be a number!");
            }
            if (!is_numeric($price_type)) {
                $error = true;
                message("error", "Price type must be a number!");
            }
            if (!$error) {
                $update = $dB->query("UPDATE IMPERIAMUCMS_CASHSHOP_ITEMS SET name = ?, UniqueID1 = ?, UniqueID2 = ?, UniqueID3 = ?, can_gift = ?, price = ?, price_type = ?, img = ?, \n                                      description = ?, category_id = ?, subcategory_id = ?, position = ? WHERE id = ?", [$name, $UniqueID1, $UniqueID2, $UniqueID3, $can_gift, $price, $price_type, $img, $desc, $cat, $subcat, $position, $id]);
                if ($update) {
                    message("success", "Item #" . $id . " was successfully edited.");
                } else {
                    message("error", "There was an unexpected error, please check your values.");
                }
            }
        } else {
            message("error", "Empty values.");
        }
    }
    public function loadItemData($id)
    {
        global $dB;
        if (check_value($id) && is_numeric($id)) {
            $result = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_CASHSHOP_ITEMS WHERE id = ?", [$id]);
            if (is_array($result)) {
                return $result;
            }
            return NULL;
        }
        message("error", lang("error_23", true));
    }
}

?>