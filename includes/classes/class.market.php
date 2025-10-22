<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class Market
{
    public function smartsearch2($username, $whbin, $itemX, $itemY)
    {
        global $dB;
        if (substr($whbin, 0, 2) == "0x") {
            $whbin = substr($whbin, 2);
        }
        $items = str_repeat("0", 120);
        $itemsm = str_repeat("1", 120);
        $i = 0;
        while ($i < 120) {
            $_item = substr($whbin, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
            $sy = hexdec(substr($_item, 0, 2));
            $ioo = hexdec(substr($_item, 14, 2));
            $type = hexdec(substr($_item, 18, 1));
            if (128 <= $ioo) {
                $sy = $sy + 256;
                $ioo -= 128;
            }
            $res = $dB->query_fetch_single("select [X],[Y] from [IMPERIAMUCMS_ITEMS] where [id]='" . $sy . "' and [type]='" . $type . "'");
            $y = 0;
            while ($y < $res["Y"]) {
                $y++;
                $x = 0;
                while ($x < $res["X"]) {
                    $items = substr_replace($items, "1", $i + $x + ($y - 1) * 8, 1);
                    $x++;
                }
            }
            $i++;
        }
        $y = 0;
        while ($y < $itemY) {
            $y++;
            $x = 0;
            while ($x < $itemX) {
                $x++;
                $spacerq[$x + 8 * ($y - 1)] = true;
            }
        }
        $walked = 0;
        $i = 0;
        while ($i < 120) {
            if (isset($spacerq[$i])) {
                $itemsm = substr_replace($itemsm, "0", $i - 1, 1);
                $last = $i;
                $walked++;
            }
            if ($walked == count($spacerq)) {
                $i = 119;
            }
            $i++;
        }
        $useforlength = substr($itemsm, 0, $last);
        $findslotlikethis = "/^" . str_replace("1", "[01]", $useforlength) . "\$/i";
        $i = 0;
        $nx = 0;
        $ny = 0;
        while ($i < 120) {
            if ($nx == 8) {
                $ny++;
                $nx = 0;
            }
            if (preg_match($findslotlikethis, substr($items, $i, strlen($useforlength))) && $itemX + $nx < 9 && $itemY + $ny < 16) {
                return $i;
            }
            $i++;
            $nx++;
        }
        if ($this->isExtendedVault($username)) {
            $whbin = substr($whbin, 7680, 7680);
            $items = str_repeat("0", 120);
            $itemsm = str_repeat("1", 120);
            $i = 0;
            while ($i < 120) {
                $_item = substr($whbin, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                $sy = hexdec(substr($_item, 0, 2));
                $ioo = hexdec(substr($_item, 14, 2));
                $type = hexdec(substr($_item, 18, 1));
                if (128 <= $ioo) {
                    $sy = $sy + 256;
                    $ioo -= 128;
                }
                $res = $dB->query_fetch_single("select [X],[Y] from [IMPERIAMUCMS_ITEMS] where [id]='" . $sy . "' and [type]='" . $type . "'");
                $y = 0;
                while ($y < $res["Y"]) {
                    $y++;
                    $x = 0;
                    while ($x < $res["X"]) {
                        $items = substr_replace($items, "1", $i + $x + ($y - 1) * 8, 1);
                        $x++;
                    }
                }
                $i++;
            }
            $y = 0;
            while ($y < $itemY) {
                $y++;
                $x = 0;
                while ($x < $itemX) {
                    $x++;
                    $spacerq[$x + 8 * ($y - 1)] = true;
                }
            }
            $walked = 0;
            $i = 0;
            while ($i < 120) {
                if (isset($spacerq[$i])) {
                    $itemsm = substr_replace($itemsm, "0", $i - 1, 1);
                    $last = $i;
                    $walked++;
                }
                if ($walked == count($spacerq)) {
                    $i = 119;
                }
                $i++;
            }
            $useforlength = substr($itemsm, 0, $last);
            $findslotlikethis = "/^" . str_replace("1", "[01]", $useforlength) . "\$/i";
            $i = 0;
            $nx = 0;
            $ny = 0;
            while ($i < 120) {
                if ($nx == 8) {
                    $ny++;
                    $nx = 0;
                }
                if (preg_match($findslotlikethis, substr($items, $i, strlen($useforlength))) && $itemX + $nx < 9 && $itemY + $ny < 16) {
                    return $i + 120;
                }
                $i++;
                $nx++;
            }
        }
        return 1337;
    }
    public function smartsearchInventory($username, $char, $whbin, $itemX, $itemY)
    {
        global $dB;
        if (substr($whbin, 0, 2) == "0x") {
            $whbin = substr($whbin, 2);
        }
        $whbinBackup = $whbin;
        $whbin = substr($whbinBackup, 768, 4096);
        $items = str_repeat("0", 64);
        $itemsm = str_repeat("1", 64);
        $i = 0;
        while ($i < 64) {
            $_item = substr($whbin, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
            $sy = hexdec(substr($_item, 0, 2));
            $ioo = hexdec(substr($_item, 14, 2));
            $type = hexdec(substr($_item, 18, 1));
            if (128 <= $ioo) {
                $sy = $sy + 256;
                $ioo -= 128;
            }
            $res = $dB->query_fetch_single("select [X],[Y] from [IMPERIAMUCMS_ITEMS] where [id]='" . $sy . "' and [type]='" . $type . "'");
            $y = 0;
            while ($y < $res["Y"]) {
                $y++;
                $x = 0;
                while ($x < $res["X"]) {
                    $items = substr_replace($items, "1", $i + $x + ($y - 1) * 8, 1);
                    $x++;
                }
            }
            $i++;
        }
        $y = 0;
        while ($y < $itemY) {
            $y++;
            $x = 0;
            while ($x < $itemX) {
                $x++;
                $spacerq[$x + 8 * ($y - 1)] = true;
            }
        }
        $walked = 0;
        $i = 0;
        while ($i < 64) {
            if (isset($spacerq[$i])) {
                $itemsm = substr_replace($itemsm, "0", $i - 1, 1);
                $last = $i;
                $walked++;
            }
            if ($walked == count($spacerq)) {
                $i = 63;
            }
            $i++;
        }
        $useforlength = substr($itemsm, 0, $last);
        $findslotlikethis = "/^" . str_replace("1", "[01]", $useforlength) . "\$/i";
        $i = 0;
        $nx = 0;
        $ny = 0;
        while ($i < 64) {
            if ($nx == 8) {
                $ny++;
                $nx = 0;
            }
            if (preg_match($findslotlikethis, substr($items, $i, strlen($useforlength))) && $itemX + $nx < 9 && $itemY + $ny < 16) {
                return $i + 12;
            }
            $i++;
            $nx++;
        }
        if (0 < $this->isExtendedInventory($username, $char)) {
            $whbin = substr($whbinBackup, 4096, 2048);
            $items = str_repeat("0", 32);
            $itemsm = str_repeat("1", 32);
            $i = 0;
            while ($i < 32) {
                $_item = substr($whbin, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                $sy = hexdec(substr($_item, 0, 2));
                $ioo = hexdec(substr($_item, 14, 2));
                $type = hexdec(substr($_item, 18, 1));
                if (128 <= $ioo) {
                    $sy = $sy + 256;
                    $ioo -= 128;
                }
                $res = $dB->query_fetch_single("select [X],[Y] from [IMPERIAMUCMS_ITEMS] where [id]='" . $sy . "' and [type]='" . $type . "'");
                $y = 0;
                while ($y < $res["Y"]) {
                    $y++;
                    $x = 0;
                    while ($x < $res["X"]) {
                        $items = substr_replace($items, "1", $i + $x + ($y - 1) * 8, 1);
                        $x++;
                    }
                }
                $i++;
            }
            $y = 0;
            while ($y < $itemY) {
                $y++;
                $x = 0;
                while ($x < $itemX) {
                    $x++;
                    $spacerq[$x + 8 * ($y - 1)] = true;
                }
            }
            $walked = 0;
            $i = 0;
            while ($i < 32) {
                if (isset($spacerq[$i])) {
                    $itemsm = substr_replace($itemsm, "0", $i - 1, 1);
                    $last = $i;
                    $walked++;
                }
                if ($walked == count($spacerq)) {
                    $i = 31;
                }
                $i++;
            }
            $useforlength = substr($itemsm, 0, $last);
            $findslotlikethis = "/^" . str_replace("1", "[01]", $useforlength) . "\$/i";
            $i = 0;
            $nx = 0;
            $ny = 0;
            while ($i < 32) {
                if ($nx == 8) {
                    $ny++;
                    $nx = 0;
                }
                if (preg_match($findslotlikethis, substr($items, $i, strlen($useforlength))) && $itemX + $nx < 9 && $itemY + $ny < 16) {
                    return $i + 76;
                }
                $i++;
                $nx++;
            }
        }
        if (1 < $this->isExtendedInventory($username, $char)) {
            $whbin = substr($whbinBackup, 6144, 2048);
            $items = str_repeat("0", 32);
            $itemsm = str_repeat("1", 32);
            $i = 0;
            while ($i < 32) {
                $_item = substr($whbin, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                $sy = hexdec(substr($_item, 0, 2));
                $ioo = hexdec(substr($_item, 14, 2));
                $type = hexdec(substr($_item, 18, 1));
                if (128 <= $ioo) {
                    $sy = $sy + 256;
                    $ioo -= 128;
                }
                $res = $dB->query_fetch_single("select [X],[Y] from [IMPERIAMUCMS_ITEMS] where [id]='" . $sy . "' and [type]='" . $type . "'");
                $y = 0;
                while ($y < $res["Y"]) {
                    $y++;
                    $x = 0;
                    while ($x < $res["X"]) {
                        $items = substr_replace($items, "1", $i + $x + ($y - 1) * 8, 1);
                        $x++;
                    }
                }
                $i++;
            }
            $y = 0;
            while ($y < $itemY) {
                $y++;
                $x = 0;
                while ($x < $itemX) {
                    $x++;
                    $spacerq[$x + 8 * ($y - 1)] = true;
                }
            }
            $walked = 0;
            $i = 0;
            while ($i < 32) {
                if (isset($spacerq[$i])) {
                    $itemsm = substr_replace($itemsm, "0", $i - 1, 1);
                    $last = $i;
                    $walked++;
                }
                if ($walked == count($spacerq)) {
                    $i = 31;
                }
                $i++;
            }
            $useforlength = substr($itemsm, 0, $last);
            $findslotlikethis = "/^" . str_replace("1", "[01]", $useforlength) . "\$/i";
            $i = 0;
            $nx = 0;
            $ny = 0;
            while ($i < 32) {
                if ($nx == 8) {
                    $ny++;
                    $nx = 0;
                }
                if (preg_match($findslotlikethis, substr($items, $i, strlen($useforlength))) && $itemX + $nx < 9 && $itemY + $ny < 16) {
                    return $i + 108;
                }
                $i++;
                $nx++;
            }
        }
        return 1337;
    }
    public function isExtendedVault($username)
    {
        global $dB;
        $result = $dB->query_fetch_single("SELECT TOP 1 WarehouseExpansion FROM AccountCharacter WHERE Id = ?", [$username]);
        if ($result["WarehouseExpansion"] == "1") {
            return true;
        }
        return false;
    }
    public function isExtendedInventory($username, $char)
    {
        global $dB;
        $result = $dB->query_fetch_single("SELECT TOP 1 InventoryExpansion FROM Character WHERE AccountID = ? AND Name = ?", [$username, $char]);
        return $result["InventoryExpansion"];
    }
    public function insertZen($username, $character_name, $amount)
    {
        global $dB;
        global $common;
        if (check_value($username) && check_value($character_name) && check_value($amount)) {
            if (!Validator::Number($amount)) {
                $error = true;
            }
            if (!Validator::UsernameLength($username)) {
                $error = true;
            }
            if (!Validator::AlphaNumeric($username)) {
                $error = true;
            }
            if ($amount < 1) {
                $error = true;
            }
            if (!$error) {
                $Character = new Character();
                $character_name = Decode($character_name);
                if ($Character->CharacterExists($character_name) && $Character->CharacterBelongsToAccount($character_name, $username)) {
                    if (!$common->accountOnline($username)) {
                        $BankData = $this->getBankData($username);
                        if (mconfig("zen_limit") < $BankData["zen"] + $amount) {
                            message("error", lang("market_txt_1", true));
                        } else {
                            $deductZen = $Character->DeductZEN($character_name, $amount);
                            if ($deductZen) {
                                $zen_ok = true;
                            } else {
                                $zen_ok = false;
                            }
                            if ($zen_ok) {
                                $update = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET zen = zen + ? WHERE AccountID = ?", [$amount, $username]);
                                message("success", sprintf(lang("market_txt_2", true), $character_name));
                                $logDate = date("Y-m-d H:i:s", time());
                                $common->accountLogs($username, "webbank", sprintf(lang("market_txt_3", true), number_format($amount), $character_name), $logDate);
                            } else {
                                message("error", lang("error_34", true));
                            }
                        }
                    } else {
                        message("error", lang("error_14", true));
                    }
                } else {
                    message("error", lang("error_32", true));
                }
            } else {
                message("error", lang("error_23", true));
            }
        } else {
            message("error", lang("error_23", true));
        }
    }
    public function getBankData($username)
    {
        global $dB;
        if (!check_value($username)) {
            message("error", lang("error_4", true));
        } else {
            if (!Validator::UsernameLength($username)) {
                message("error", lang("error_5", true));
            } else {
                if (!Validator::AlphaNumeric($username)) {
                    message("error", lang("error_6", true));
                } else {
                    $result = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$username]);
                    if (is_array($result)) {
                        return $result;
                    }
                    if ($result == NULL) {
                        $insert = $dB->query("INSERT INTO IMPERIAMUCMS_WEB_BANK(AccountID,zen,bless,soul,life,chaos,harmony,creation,guardian) VALUES('" . $username . "',0,0,0,0,0,0,0,0)");
                    }
                    $result = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$username]);
                    return $result;
                }
            }
        }
    }
    public function getGuildBankData($username)
    {
        global $dB;
        if (!check_value($username)) {
            message("error", lang("error_4", true));
        } else {
            if (!Validator::UsernameLength($username)) {
                message("error", lang("error_5", true));
            } else {
                if (!Validator::AlphaNumeric($username)) {
                    message("error", lang("error_6", true));
                } else {
                    $guildData = $dB->query_fetch_single("SELECT G_Name FROM GuildMember WHERE Name = ?", [$username]);
                    if (!empty($guildData["G_Name"])) {
                        $result = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_WEB_BANK_GUILD WHERE AccountID = ?", [$guildData["G_Name"]]);
                        if (is_array($result)) {
                            return $result;
                        }
                        if ($result == NULL) {
                            $dB->query("INSERT INTO IMPERIAMUCMS_WEB_BANK_GUILD(Guild) VALUES('" . $guildData["G_Name"] . "')");
                        }
                        $result = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_WEB_BANK_GUILD WHERE Guild = ?", [$guildData["G_Name"]]);
                        return $result;
                    }
                    return NULL;
                }
            }
        }
    }
    public function withdrawZen($username, $character_name, $amount)
    {
        global $dB;
        global $common;
        if (check_value($username) && check_value($character_name) && check_value($amount)) {
            if (!Validator::Number($amount)) {
                $error = true;
            }
            if (!Validator::UsernameLength($username)) {
                $error = true;
            }
            if (!Validator::AlphaNumeric($username)) {
                $error = true;
            }
            if ($amount < 1) {
                $error = true;
            }
            if (!$error) {
                $Character = new Character();
                $character_name = Decode($character_name);
                if ($Character->CharacterExists($character_name) && $Character->CharacterBelongsToAccount($character_name, $username)) {
                    if (!$common->accountOnline($username)) {
                        $BankData = $this->getBankData($username);
                        $characterData = $Character->CharacterData($character_name);
                        if (mconfig("inv_limit") < $characterData["Money"] + $amount) {
                            message("error", lang("market_txt_4", true));
                        } else {
                            if ($BankData["zen"] < $amount) {
                                message("error", lang("error_34", true));
                            } else {
                                $update = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET zen = zen - " . $amount . " WHERE AccountID = '" . $username . "'");
                                $update2 = $dB->query("UPDATE Character SET Money = Money + " . $amount . " WHERE AccountID = '" . $username . "' AND Name = '" . $character_name . "'");
                                message("success", sprintf(lang("market_txt_5", true), $character_name));
                                $logDate = date("Y-m-d H:i:s", time());
                                $common->accountLogs($username, "webbank", sprintf(lang("market_txt_6", true), number_format($amount), $character_name), $logDate);
                            }
                        }
                    } else {
                        message("error", lang("error_14", true));
                    }
                } else {
                    message("error", lang("error_32", true));
                }
            } else {
                message("error", lang("error_23", true));
            }
        } else {
            message("error", lang("error_23", true));
        }
    }
    public function findAllJewels($username)
    {
        global $dB;
        if (check_value($username)) {
            if (!Validator::UsernameLength($username)) {
                $error = true;
            }
            if (!Validator::AlphaNumeric($username)) {
                $error = true;
            }
            if (!$error) {
                $Market = new Market();
                $vault = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT Items FROM warehouse WHERE AccountID = '" . $username . "'), 2) AS vault");
                $vault = $vault["vault"];
                $jewels = [];
                $Items = new Items();
                $i = 0;
                while ($i < 120) {
                    $item = substr($vault, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                    $itemInfo = $Items->ItemInfo($item);
                    if (140 <= config("server_files_season", true)) {
                        if ($itemInfo["dur"] == 0 || $itemInfo["dur"] == NULL) {
                            $itemInfo["dur"] = 1;
                        }
                    } else {
                        $itemInfo["dur"] = 1;
                    }
                    if ($itemInfo["category"] == "12") {
                        if ($itemInfo["id"] == "15" && $itemInfo["sticklevel"] == "0") {
                            $easytoyou_decoder_beta_not_finish += $itemInfo["dur"];
                        }
                        if ($itemInfo["id"] == "30") {
                            if ($itemInfo["sticklevel"] == "0") {
                                $easytoyou_decoder_beta_not_finish += 10;
                            } else {
                                if ($itemInfo["sticklevel"] == "1") {
                                    $easytoyou_decoder_beta_not_finish += 20;
                                } else {
                                    if ($itemInfo["sticklevel"] == "2") {
                                        $easytoyou_decoder_beta_not_finish += 30;
                                    }
                                }
                            }
                        }
                        if ($itemInfo["id"] == "31") {
                            if ($itemInfo["sticklevel"] == "0") {
                                $easytoyou_decoder_beta_not_finish += 10;
                            } else {
                                if ($itemInfo["sticklevel"] == "1") {
                                    $easytoyou_decoder_beta_not_finish += 20;
                                } else {
                                    if ($itemInfo["sticklevel"] == "2") {
                                        $easytoyou_decoder_beta_not_finish += 30;
                                    }
                                }
                            }
                        }
                        if ($itemInfo["id"] == "136") {
                            if ($itemInfo["sticklevel"] == "0") {
                                $easytoyou_decoder_beta_not_finish += 10;
                            } else {
                                if ($itemInfo["sticklevel"] == "1") {
                                    $easytoyou_decoder_beta_not_finish += 20;
                                } else {
                                    if ($itemInfo["sticklevel"] == "2") {
                                        $easytoyou_decoder_beta_not_finish += 30;
                                    }
                                }
                            }
                        }
                        if ($itemInfo["id"] == "137") {
                            if ($itemInfo["sticklevel"] == "0") {
                                $easytoyou_decoder_beta_not_finish += 10;
                            } else {
                                if ($itemInfo["sticklevel"] == "1") {
                                    $easytoyou_decoder_beta_not_finish += 20;
                                } else {
                                    if ($itemInfo["sticklevel"] == "2") {
                                        $easytoyou_decoder_beta_not_finish += 30;
                                    }
                                }
                            }
                        }
                        if ($itemInfo["id"] == "138") {
                            if ($itemInfo["sticklevel"] == "0") {
                                $easytoyou_decoder_beta_not_finish += 10;
                            } else {
                                if ($itemInfo["sticklevel"] == "1") {
                                    $easytoyou_decoder_beta_not_finish += 20;
                                } else {
                                    if ($itemInfo["sticklevel"] == "2") {
                                        $easytoyou_decoder_beta_not_finish += 30;
                                    }
                                }
                            }
                        }
                        if ($itemInfo["id"] == "140") {
                            if ($itemInfo["sticklevel"] == "0") {
                                $easytoyou_decoder_beta_not_finish += 10;
                            } else {
                                if ($itemInfo["sticklevel"] == "1") {
                                    $easytoyou_decoder_beta_not_finish += 20;
                                } else {
                                    if ($itemInfo["sticklevel"] == "2") {
                                        $easytoyou_decoder_beta_not_finish += 30;
                                    }
                                }
                            }
                        }
                        if ($itemInfo["id"] == "141") {
                            if ($itemInfo["sticklevel"] == "0") {
                                $easytoyou_decoder_beta_not_finish += 10;
                            } else {
                                if ($itemInfo["sticklevel"] == "1") {
                                    $easytoyou_decoder_beta_not_finish += 20;
                                } else {
                                    if ($itemInfo["sticklevel"] == "2") {
                                        $easytoyou_decoder_beta_not_finish += 30;
                                    }
                                }
                            }
                        }
                    } else {
                        if ($itemInfo["category"] == "14") {
                            if ($itemInfo["id"] == "13" && $itemInfo["sticklevel"] == "0") {
                                $easytoyou_decoder_beta_not_finish += $itemInfo["dur"];
                            }
                            if ($itemInfo["id"] == "14" && $itemInfo["sticklevel"] == "0") {
                                $easytoyou_decoder_beta_not_finish += $itemInfo["dur"];
                            }
                            if ($itemInfo["id"] == "16" && $itemInfo["sticklevel"] == "0") {
                                $easytoyou_decoder_beta_not_finish += $itemInfo["dur"];
                            }
                            if ($itemInfo["id"] == "22" && $itemInfo["sticklevel"] == "0") {
                                $easytoyou_decoder_beta_not_finish += $itemInfo["dur"];
                            }
                            if ($itemInfo["id"] == "31" && $itemInfo["sticklevel"] == "0") {
                                $easytoyou_decoder_beta_not_finish += $itemInfo["dur"];
                            }
                            if ($itemInfo["id"] == "42" && $itemInfo["sticklevel"] == "0") {
                                $easytoyou_decoder_beta_not_finish += $itemInfo["dur"];
                            }
                        }
                    }
                    $i++;
                }
                return $jewels;
            }
            message("error", lang("error_23", true));
        } else {
            message("error", lang("error_23", true));
        }
    }
    public function insertJewels($username, $jewel, $amount)
    {
        global $dB;
        global $dB2;
        global $common;
        $amount = xss_clean($amount);
        if (check_value($username) && check_value($jewel) && check_value($amount)) {
            if (!Validator::Number($amount)) {
                $error = true;
            }
            if (!Validator::UsernameLength($username)) {
                $error = true;
            }
            if (!Validator::AlphaNumeric($username)) {
                $error = true;
            }
            if ($jewel != "bless" && $jewel != "soul" && $jewel != "life" && $jewel != "chaos" && $jewel != "harmony" && $jewel != "creation" && $jewel != "guardian") {
                $error = true;
            }
            if ($amount < 1) {
                $error = true;
            }
            if (!$error) {
                if (!$common->accountOnline($username)) {
                    if (!$this->duplicatedItemsVault($username)) {
                        if (140 <= config("server_files_season", true)) {
                            $jewels = $this->findJewelsS14($username, $jewel);
                            if ($this->canInsertJewelsS14($username, $jewel, $jewels, $amount)) {
                                message("success", lang("market_txt_7", true));
                                $logDate = date("Y-m-d H:i:s", time());
                                $common->accountLogs($username, "webbank", sprintf(lang("market_txt_8", true), $amount, ucfirst($jewel)), $logDate);
                            }
                        } else {
                            $jewels = $this->findJewels($username, $jewel);
                            if ($this->canInsertJewels($username, $jewel, $jewels, $amount)) {
                                message("success", lang("market_txt_7", true));
                                $logDate = date("Y-m-d H:i:s", time());
                                $common->accountLogs($username, "webbank", sprintf(lang("market_txt_8", true), $amount, ucfirst($jewel)), $logDate);
                            }
                        }
                    } else {
                        message("error", lang("market_txt_9", true));
                    }
                } else {
                    message("error", lang("error_14", true));
                }
            } else {
                message("error", lang("error_23", true));
            }
        } else {
            message("error", lang("error_23", true));
        }
    }
    public function duplicatedItemsVault($username)
    {
        global $dB;
        $Items = new Items();
        if (check_value($username)) {
            if (!Validator::UsernameLength($username)) {
                $error = true;
            }
            if (!Validator::AlphaNumeric($username)) {
                $error = true;
            }
            if (!$error) {
                $vault = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT Items FROM warehouse WHERE AccountID = '" . $username . "'), 2) AS vault");
                $vault = $vault["vault"];
                $stack = [];
                $i = 0;
                while ($i < 120) {
                    $item = $Items->ItemInfo(substr($vault, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__));
                    if (in_array($item["sn"], $stack, true) && $item["sn"] != "" && $item["sn"] != "0000000000000000") {
                        return true;
                    }
                    array_push($stack, $item["sn"]);
                    $i++;
                }
                if ($this->isExtendedVault($username)) {
                    $i = 120;
                    while ($i < 240) {
                        $item = $Items->ItemInfo(substr($vault, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__));
                        if (in_array($item["sn"], $stack, true) && $item["sn"] != "" && $item["sn"] != "0000000000000000") {
                            return true;
                        }
                        array_push($stack, $item["sn"]);
                        $i++;
                    }
                }
                return false;
            }
            message("error", lang("error_23", true));
        } else {
            message("error", lang("error_23", true));
        }
    }
    public function findJewels($username, $jewel)
    {
        global $dB;
        if (check_value($username) && check_value($jewel)) {
            if (!Validator::UsernameLength($username)) {
                $error = true;
            }
            if (!Validator::AlphaNumeric($username)) {
                $error = true;
            }
            if ($jewel != "bless" && $jewel != "soul" && $jewel != "life" && $jewel != "chaos" && $jewel != "harmony" && $jewel != "creation" && $jewel != "guardian") {
                $error = true;
            }
            if (!$error) {
                $vault = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT Items FROM warehouse WHERE AccountID = '" . $username . "'), 2) AS vault");
                $vault = $vault["vault"];
                $jewels = [];
                $jewels["count"][1] = 0;
                $jewels["count"][10] = 0;
                $jewels["count"][20] = 0;
                $jewels["count"][30] = 0;
                $Items = new Items();
                $i = 0;
                while ($i < 120) {
                    $item = substr($vault, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                    $itemInfo = $Items->ItemInfo($item);
                    if ($jewel == "bless") {
                        if ($itemInfo["category"] == "14" && $itemInfo["id"] == "13") {
                            $jewels["count"][1]++;
                        } else {
                            if ($itemInfo["category"] == "12" && $itemInfo["id"] == "30") {
                                if ($itemInfo["sticklevel"] == "0") {
                                    $jewels["count"][10]++;
                                } else {
                                    if ($itemInfo["sticklevel"] == "1") {
                                        $jewels["count"][20]++;
                                    } else {
                                        if ($itemInfo["sticklevel"] == "2") {
                                            $jewels["count"][30]++;
                                        }
                                    }
                                }
                            }
                        }
                    } else {
                        if ($jewel == "soul") {
                            if ($itemInfo["category"] == "14" && $itemInfo["id"] == "14") {
                                $jewels["count"][1]++;
                            } else {
                                if ($itemInfo["category"] == "12" && $itemInfo["id"] == "31") {
                                    if ($itemInfo["sticklevel"] == "0") {
                                        $jewels["count"][10]++;
                                    } else {
                                        if ($itemInfo["sticklevel"] == "1") {
                                            $jewels["count"][20]++;
                                        } else {
                                            if ($itemInfo["sticklevel"] == "2") {
                                                $jewels["count"][30]++;
                                            }
                                        }
                                    }
                                }
                            }
                        } else {
                            if ($jewel == "life") {
                                if ($itemInfo["category"] == "14" && $itemInfo["id"] == "16") {
                                    $jewels["count"][1]++;
                                } else {
                                    if ($itemInfo["category"] == "12" && $itemInfo["id"] == "136") {
                                        if ($itemInfo["sticklevel"] == "0") {
                                            $jewels["count"][10]++;
                                        } else {
                                            if ($itemInfo["sticklevel"] == "1") {
                                                $jewels["count"][20]++;
                                            } else {
                                                if ($itemInfo["sticklevel"] == "2") {
                                                    $jewels["count"][30]++;
                                                }
                                            }
                                        }
                                    }
                                }
                            } else {
                                if ($jewel == "chaos") {
                                    if ($itemInfo["category"] == "12" && $itemInfo["id"] == "15") {
                                        $jewels["count"][1]++;
                                    } else {
                                        if ($itemInfo["category"] == "12" && $itemInfo["id"] == "141") {
                                            if ($itemInfo["sticklevel"] == "0") {
                                                $jewels["count"][10]++;
                                            } else {
                                                if ($itemInfo["sticklevel"] == "1") {
                                                    $jewels["count"][20]++;
                                                } else {
                                                    if ($itemInfo["sticklevel"] == "2") {
                                                        $jewels["count"][30]++;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                } else {
                                    if ($jewel == "harmony") {
                                        if ($itemInfo["category"] == "14" && $itemInfo["id"] == "42") {
                                            $jewels["count"][1]++;
                                        } else {
                                            if ($itemInfo["category"] == "12" && $itemInfo["id"] == "140") {
                                                if ($itemInfo["sticklevel"] == "0") {
                                                    $jewels["count"][10]++;
                                                } else {
                                                    if ($itemInfo["sticklevel"] == "1") {
                                                        $jewels["count"][20]++;
                                                    } else {
                                                        if ($itemInfo["sticklevel"] == "2") {
                                                            $jewels["count"][30]++;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    } else {
                                        if ($jewel == "creation") {
                                            if ($itemInfo["category"] == "14" && $itemInfo["id"] == "22") {
                                                $jewels["count"][1]++;
                                            } else {
                                                if ($itemInfo["category"] == "12" && $itemInfo["id"] == "137") {
                                                    if ($itemInfo["sticklevel"] == "0") {
                                                        $jewels["count"][10]++;
                                                    } else {
                                                        if ($itemInfo["sticklevel"] == "1") {
                                                            $jewels["count"][20]++;
                                                        } else {
                                                            if ($itemInfo["sticklevel"] == "2") {
                                                                $jewels["count"][30]++;
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        } else {
                                            if ($jewel == "guardian") {
                                                if ($itemInfo["category"] == "14" && $itemInfo["id"] == "31") {
                                                    $jewels["count"][1]++;
                                                } else {
                                                    if ($itemInfo["category"] == "12" && $itemInfo["id"] == "138") {
                                                        if ($itemInfo["sticklevel"] == "0") {
                                                            $jewels["count"][10]++;
                                                        } else {
                                                            if ($itemInfo["sticklevel"] == "1") {
                                                                $jewels["count"][20]++;
                                                            } else {
                                                                if ($itemInfo["sticklevel"] == "2") {
                                                                    $jewels["count"][30]++;
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
                        }
                    }
                    $i++;
                }
                return $jewels;
            }
            message("error", lang("error_23", true));
        } else {
            message("error", lang("error_23", true));
        }
    }
    public function canInsertJewels($username, $jewel, $jewels, $amount)
    {
        global $dB;
        $amount = xss_clean($amount);
        if (check_value($username) && check_value($jewel) && check_value($jewels) && check_value($amount)) {
            if (!Validator::Number($amount)) {
                $error = true;
            }
            if (!Validator::UsernameLength($username)) {
                $error = true;
            }
            if (!Validator::AlphaNumeric($username)) {
                $error = true;
            }
            if ($jewel != "bless" && $jewel != "soul" && $jewel != "life" && $jewel != "chaos" && $jewel != "harmony" && $jewel != "creation" && $jewel != "guardian") {
                $error = true;
            }
            if ($amount < 1) {
                $error = true;
            }
            if (!$error) {
                $total_jewels = $this->totalJewels($jewels);
                if ($amount <= $total_jewels) {
                    $BankData = $this->getBankData($username);
                    if (mconfig("jewel_limit") < $BankData[$jewel] + $amount) {
                        message("error", lang("market_txt_79", true));
                    } else {
                        $j30 = 0;
                        $j20 = 0;
                        $j10 = 0;
                        $j1 = 0;
                        $amount_tmp = $amount;
                        if (0 < $jewels["count"][30] && 0 < $amount_tmp) {
                            if ($amount_tmp < $jewels["count"][30] * 30) {
                                $j30 = floor($amount_tmp / 30);
                                $amount_tmp = $amount_tmp % 30;
                            } else {
                                $j30 = $jewels["count"][30];
                                $amount_tmp = $amount_tmp - $jewels["count"][30] * 30;
                            }
                        }
                        if (0 < $jewels["count"][20] && 0 < $amount_tmp) {
                            if ($amount_tmp < $jewels["count"][20] * 20) {
                                $j20 = floor($amount_tmp / 20);
                                $amount_tmp = $amount_tmp % 20;
                            } else {
                                $j20 = $jewels["count"][20];
                                $amount_tmp = $amount_tmp - $jewels["count"][20] * 20;
                            }
                        }
                        if (0 < $jewels["count"][10] && 0 < $amount_tmp) {
                            if ($amount_tmp < $jewels["count"][10] * 10) {
                                $j10 = floor($amount_tmp / 10);
                                $amount_tmp = $amount_tmp % 10;
                            } else {
                                $j10 = $jewels["count"][10];
                                $amount_tmp = $amount_tmp - $jewels["count"][10] * 10;
                            }
                        }
                        if (0 < $jewels["count"][1] && 0 < $amount_tmp && $amount_tmp <= $jewels["count"][1] * 1) {
                            $j1 = $amount_tmp;
                            $amount_tmp = $amount_tmp - $j1;
                        }
                        if ($amount_tmp == 0 && $j30 * 30 + $j20 * 20 + $j10 * 10 + $j1 == $amount) {
                            $vault = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT Items FROM warehouse WHERE AccountID = '" . $username . "'), 2) AS vault");
                            $vault = $vault["vault"];
                            $newVault = $vault;
                            $Items = new Items();
                            $i = 0;
                            while ($i < 120) {
                                $item = substr($vault, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                                $itemInfo = $Items->ItemInfo($item);
                                if (0 < $j30) {
                                    if ($jewel == "bless") {
                                        if ($itemInfo["category"] == "12" && $itemInfo["id"] == "30" && $itemInfo["sticklevel"] == "2") {
                                            $newVault = substr_replace($newVault, __ITEM_EMPTY__, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                                            $j30--;
                                        }
                                    } else {
                                        if ($jewel == "soul") {
                                            if ($itemInfo["category"] == "12" && $itemInfo["id"] == "31" && $itemInfo["sticklevel"] == "2") {
                                                $newVault = substr_replace($newVault, __ITEM_EMPTY__, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                                                $j30--;
                                            }
                                        } else {
                                            if ($jewel == "life") {
                                                if ($itemInfo["category"] == "12" && $itemInfo["id"] == "136" && $itemInfo["sticklevel"] == "2") {
                                                    $newVault = substr_replace($newVault, __ITEM_EMPTY__, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                                                    $j30--;
                                                }
                                            } else {
                                                if ($jewel == "chaos") {
                                                    if ($itemInfo["category"] == "12" && $itemInfo["id"] == "141" && $itemInfo["sticklevel"] == "2") {
                                                        $newVault = substr_replace($newVault, __ITEM_EMPTY__, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                                                        $j30--;
                                                    }
                                                } else {
                                                    if ($jewel == "harmony") {
                                                        if ($itemInfo["category"] == "12" && $itemInfo["id"] == "140" && $itemInfo["sticklevel"] == "2") {
                                                            $newVault = substr_replace($newVault, __ITEM_EMPTY__, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                                                            $j30--;
                                                        }
                                                    } else {
                                                        if ($jewel == "creation") {
                                                            if ($itemInfo["category"] == "12" && $itemInfo["id"] == "137" && $itemInfo["sticklevel"] == "2") {
                                                                $newVault = substr_replace($newVault, __ITEM_EMPTY__, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                                                                $j30--;
                                                            }
                                                        } else {
                                                            if ($jewel == "guardian" && $itemInfo["category"] == "12" && $itemInfo["id"] == "138" && $itemInfo["sticklevel"] == "2") {
                                                                $newVault = substr_replace($newVault, __ITEM_EMPTY__, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                                                                $j30--;
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                } else {
                                    if (0 < $j20) {
                                        if ($jewel == "bless") {
                                            if ($itemInfo["category"] == "12" && $itemInfo["id"] == "30" && $itemInfo["sticklevel"] == "1") {
                                                $newVault = substr_replace($newVault, __ITEM_EMPTY__, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                                                $j20--;
                                            }
                                        } else {
                                            if ($jewel == "soul") {
                                                if ($itemInfo["category"] == "12" && $itemInfo["id"] == "31" && $itemInfo["sticklevel"] == "1") {
                                                    $newVault = substr_replace($newVault, __ITEM_EMPTY__, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                                                    $j20--;
                                                }
                                            } else {
                                                if ($jewel == "life") {
                                                    if ($itemInfo["category"] == "12" && $itemInfo["id"] == "136" && $itemInfo["sticklevel"] == "1") {
                                                        $newVault = substr_replace($newVault, __ITEM_EMPTY__, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                                                        $j20--;
                                                    }
                                                } else {
                                                    if ($jewel == "chaos") {
                                                        if ($itemInfo["category"] == "12" && $itemInfo["id"] == "141" && $itemInfo["sticklevel"] == "1") {
                                                            $newVault = substr_replace($newVault, __ITEM_EMPTY__, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                                                            $j20--;
                                                        }
                                                    } else {
                                                        if ($jewel == "harmony") {
                                                            if ($itemInfo["category"] == "12" && $itemInfo["id"] == "140" && $itemInfo["sticklevel"] == "1") {
                                                                $newVault = substr_replace($newVault, __ITEM_EMPTY__, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                                                                $j20--;
                                                            }
                                                        } else {
                                                            if ($jewel == "creation") {
                                                                if ($itemInfo["category"] == "12" && $itemInfo["id"] == "137" && $itemInfo["sticklevel"] == "1") {
                                                                    $newVault = substr_replace($newVault, __ITEM_EMPTY__, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                                                                    $j20--;
                                                                }
                                                            } else {
                                                                if ($jewel == "guardian" && $itemInfo["category"] == "12" && $itemInfo["id"] == "138" && $itemInfo["sticklevel"] == "1") {
                                                                    $newVault = substr_replace($newVault, __ITEM_EMPTY__, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                                                                    $j20--;
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    } else {
                                        if (0 < $j10) {
                                            if ($jewel == "bless") {
                                                if ($itemInfo["category"] == "12" && $itemInfo["id"] == "30" && $itemInfo["sticklevel"] == "0") {
                                                    $newVault = substr_replace($newVault, __ITEM_EMPTY__, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                                                    $j10--;
                                                }
                                            } else {
                                                if ($jewel == "soul") {
                                                    if ($itemInfo["category"] == "12" && $itemInfo["id"] == "31" && $itemInfo["sticklevel"] == "0") {
                                                        $newVault = substr_replace($newVault, __ITEM_EMPTY__, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                                                        $j10--;
                                                    }
                                                } else {
                                                    if ($jewel == "life") {
                                                        if ($itemInfo["category"] == "12" && $itemInfo["id"] == "136" && $itemInfo["sticklevel"] == "0") {
                                                            $newVault = substr_replace($newVault, __ITEM_EMPTY__, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                                                            $j10--;
                                                        }
                                                    } else {
                                                        if ($jewel == "chaos") {
                                                            if ($itemInfo["category"] == "12" && $itemInfo["id"] == "141" && $itemInfo["sticklevel"] == "0") {
                                                                $newVault = substr_replace($newVault, __ITEM_EMPTY__, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                                                                $j10--;
                                                            }
                                                        } else {
                                                            if ($jewel == "harmony") {
                                                                if ($itemInfo["category"] == "12" && $itemInfo["id"] == "140" && $itemInfo["sticklevel"] == "0") {
                                                                    $newVault = substr_replace($newVault, __ITEM_EMPTY__, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                                                                    $j10--;
                                                                }
                                                            } else {
                                                                if ($jewel == "creation") {
                                                                    if ($itemInfo["category"] == "12" && $itemInfo["id"] == "137" && $itemInfo["sticklevel"] == "0") {
                                                                        $newVault = substr_replace($newVault, __ITEM_EMPTY__, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                                                                        $j10--;
                                                                    }
                                                                } else {
                                                                    if ($jewel == "guardian" && $itemInfo["category"] == "12" && $itemInfo["id"] == "138" && $itemInfo["sticklevel"] == "0") {
                                                                        $newVault = substr_replace($newVault, __ITEM_EMPTY__, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                                                                        $j10--;
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        } else {
                                            if (0 < $j1) {
                                                if ($jewel == "bless") {
                                                    if ($itemInfo["category"] == "14" && $itemInfo["id"] == "13" && $itemInfo["sticklevel"] == "0") {
                                                        $newVault = substr_replace($newVault, __ITEM_EMPTY__, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                                                        $j1--;
                                                    }
                                                } else {
                                                    if ($jewel == "soul") {
                                                        if ($itemInfo["category"] == "14" && $itemInfo["id"] == "14" && $itemInfo["sticklevel"] == "0") {
                                                            $newVault = substr_replace($newVault, __ITEM_EMPTY__, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                                                            $j1--;
                                                        }
                                                    } else {
                                                        if ($jewel == "life") {
                                                            if ($itemInfo["category"] == "14" && $itemInfo["id"] == "16" && $itemInfo["sticklevel"] == "0") {
                                                                $newVault = substr_replace($newVault, __ITEM_EMPTY__, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                                                                $j1--;
                                                            }
                                                        } else {
                                                            if ($jewel == "chaos") {
                                                                if ($itemInfo["category"] == "12" && $itemInfo["id"] == "15" && $itemInfo["sticklevel"] == "0") {
                                                                    $newVault = substr_replace($newVault, __ITEM_EMPTY__, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                                                                    $j1--;
                                                                }
                                                            } else {
                                                                if ($jewel == "harmony") {
                                                                    if ($itemInfo["category"] == "14" && $itemInfo["id"] == "42" && $itemInfo["sticklevel"] == "0") {
                                                                        $newVault = substr_replace($newVault, __ITEM_EMPTY__, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                                                                        $j1--;
                                                                    }
                                                                } else {
                                                                    if ($jewel == "creation") {
                                                                        if ($itemInfo["category"] == "14" && $itemInfo["id"] == "22" && $itemInfo["sticklevel"] == "0") {
                                                                            $newVault = substr_replace($newVault, __ITEM_EMPTY__, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                                                                            $j1--;
                                                                        }
                                                                    } else {
                                                                        if ($jewel == "guardian" && $itemInfo["category"] == "14" && $itemInfo["id"] == "31" && $itemInfo["sticklevel"] == "0") {
                                                                            $newVault = substr_replace($newVault, __ITEM_EMPTY__, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                                                                            $j1--;
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
                                }
                                $i++;
                            }
                            if ($j30 == 0 && $j20 == 0 && $j10 == 0 && $j1 == 0) {
                                $newVault = "0x" . $newVault;
                                $update = $dB->query("UPDATE warehouse SET Items = " . $newVault . " WHERE AccountID = '" . $username . "'");
                                $update2 = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET " . $jewel . " = " . $jewel . " + " . $amount . " WHERE AccountID = '" . $username . "'");
                                return true;
                            }
                            message("error", lang("market_txt_80", true));
                            return false;
                        }
                        message("error", lang("market_txt_81", true));
                        return false;
                    }
                } else {
                    message("error", lang("market_txt_82", true));
                }
            } else {
                message("error", lang("error_23", true));
            }
        } else {
            message("error", lang("error_23", true));
        }
    }
    public function totalJewels($jewels)
    {
        if (is_array($jewels)) {
            $total = $jewels["count"][1] * 1 + $jewels["count"][10] * 10 + $jewels["count"][20] * 20 + $jewels["count"][30] * 30;
            return $total;
        }
        return NULL;
    }
    public function findJewelsS14($username, $jewel)
    {
        global $dB;
        if (check_value($username) && check_value($jewel)) {
            if (!Validator::UsernameLength($username)) {
                $error = true;
            }
            if (!Validator::AlphaNumeric($username)) {
                $error = true;
            }
            if ($jewel != "bless" && $jewel != "soul" && $jewel != "life" && $jewel != "chaos" && $jewel != "harmony" && $jewel != "creation" && $jewel != "guardian") {
                $error = true;
            }
            if (!$error) {
                $vault = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT Items FROM warehouse WHERE AccountID = '" . $username . "'), 2) AS vault");
                $vault = $vault["vault"];
                $jewels = [];
                $Items = new Items();
                $i = 0;
                $j = 0;
                $total = 0;
                while ($i < 120) {
                    $item = substr($vault, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                    $itemInfo = $Items->ItemInfo($item);
                    if ($jewel == "chaos" && $itemInfo["category"] == "12" && $itemInfo["id"] == "15" && $itemInfo["sticklevel"] == "0") {
                        $jewels[$j] = $itemInfo["dur"];
                        $total += $itemInfo["dur"];
                        $j++;
                    } else {
                        if ($itemInfo["category"] == "14") {
                            if ($jewel == "bless" && $itemInfo["id"] == "13" && $itemInfo["sticklevel"] == "0") {
                                $jewels[$j] = $itemInfo["dur"];
                                $total += $itemInfo["dur"];
                                $j++;
                            }
                            if ($jewel == "soul" && $itemInfo["id"] == "14" && $itemInfo["sticklevel"] == "0") {
                                $jewels[$j] = $itemInfo["dur"];
                                $total += $itemInfo["dur"];
                                $j++;
                            }
                            if ($jewel == "life" && $itemInfo["id"] == "16" && $itemInfo["sticklevel"] == "0") {
                                $jewels[$j] = $itemInfo["dur"];
                                $total += $itemInfo["dur"];
                                $j++;
                            }
                            if ($jewel == "creation" && $itemInfo["id"] == "22" && $itemInfo["sticklevel"] == "0") {
                                $jewels[$j] = $itemInfo["dur"];
                                $total += $itemInfo["dur"];
                                $j++;
                            }
                            if ($jewel == "guardian" && $itemInfo["id"] == "31" && $itemInfo["sticklevel"] == "0") {
                                $jewels[$j] = $itemInfo["dur"];
                                $total += $itemInfo["dur"];
                                $j++;
                            }
                            if ($jewel == "harmony" && $itemInfo["id"] == "42" && $itemInfo["sticklevel"] == "0") {
                                $jewels[$j] = $itemInfo["dur"];
                                $total += $itemInfo["dur"];
                                $j++;
                            }
                        }
                    }
                    $i++;
                }
                $jewels["total"] = $total;
                return $jewels;
            }
            message("error", lang("error_23", true));
        } else {
            message("error", lang("error_23", true));
        }
    }
    public function canInsertJewelsS14($username, $jewel, $jewels, $amount)
    {
        global $dB;
        $amount = xss_clean($amount);
        if (check_value($username) && check_value($jewel) && check_value($jewels) && check_value($amount)) {
            if (!Validator::Number($amount)) {
                $error = true;
            }
            if (!Validator::UsernameLength($username)) {
                $error = true;
            }
            if (!Validator::AlphaNumeric($username)) {
                $error = true;
            }
            if ($jewel != "bless" && $jewel != "soul" && $jewel != "life" && $jewel != "chaos" && $jewel != "harmony" && $jewel != "creation" && $jewel != "guardian") {
                $error = true;
            }
            if ($amount < 1) {
                $error = true;
            }
            if (!$error) {
                $total_jewels = $jewels["total"];
                $amountLoop = $amount;
                if ($amount <= $total_jewels) {
                    $BankData = $this->getBankData($username);
                    if (mconfig("jewel_limit") < $BankData[$jewel] + $amount) {
                        message("error", lang("market_txt_79", true));
                    } else {
                        $vault = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT Items FROM warehouse WHERE AccountID = '" . $username . "'), 2) AS vault");
                        $vault = $vault["vault"];
                        $newVault = $vault;
                        $Items = new Items();
                        $i = 0;
                        while ($i < 120) {
                            if (0 < $amountLoop) {
                                $item = substr($newVault, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                                $itemInfo = $Items->ItemInfo($item);
                                if ($jewel == "chaos" && $itemInfo["category"] == "12" && $itemInfo["id"] == "15" && $itemInfo["sticklevel"] == "0") {
                                    while (0 < $amountLoop && 1 <= $itemInfo["dur"]) {
                                        if ($itemInfo["dur"] == "1") {
                                            $itemInfo["dur"] = 0;
                                            $newVault = substr_replace($newVault, __ITEM_EMPTY__, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                                        } else {
                                            $itemInfo["dur"] = $itemInfo["dur"] - 1;
                                            $item = substr_replace($item, sprintf("%02s", dechex($itemInfo["dur"])), 4, 2);
                                            $newVault = substr_replace($newVault, $item, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                                        }
                                        $amountLoop--;
                                    }
                                } else {
                                    if ($itemInfo["category"] == "14") {
                                        if ($jewel == "bless" && $itemInfo["id"] == "13" && $itemInfo["sticklevel"] == "0") {
                                            while (0 < $amountLoop && 1 <= $itemInfo["dur"]) {
                                                if ($itemInfo["dur"] == "1") {
                                                    $itemInfo["dur"] = 0;
                                                    $newVault = substr_replace($newVault, __ITEM_EMPTY__, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                                                } else {
                                                    $itemInfo["dur"] = $itemInfo["dur"] - 1;
                                                    $item = substr_replace($item, sprintf("%02s", dechex($itemInfo["dur"])), 4, 2);
                                                    $newVault = substr_replace($newVault, $item, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                                                }
                                                $amountLoop--;
                                            }
                                        }
                                        if ($jewel == "soul" && $itemInfo["id"] == "14" && $itemInfo["sticklevel"] == "0") {
                                            while (0 < $amountLoop && 1 <= $itemInfo["dur"]) {
                                                if ($itemInfo["dur"] == "1") {
                                                    $itemInfo["dur"] = 0;
                                                    $newVault = substr_replace($newVault, __ITEM_EMPTY__, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                                                } else {
                                                    $itemInfo["dur"] = $itemInfo["dur"] - 1;
                                                    $item = substr_replace($item, sprintf("%02s", dechex($itemInfo["dur"])), 4, 2);
                                                    $newVault = substr_replace($newVault, $item, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                                                }
                                                $amountLoop--;
                                            }
                                        }
                                        if ($jewel == "life" && $itemInfo["id"] == "16" && $itemInfo["sticklevel"] == "0") {
                                            while (0 < $amountLoop && 1 <= $itemInfo["dur"]) {
                                                if ($itemInfo["dur"] == "1") {
                                                    $itemInfo["dur"] = 0;
                                                    $newVault = substr_replace($newVault, __ITEM_EMPTY__, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                                                } else {
                                                    $itemInfo["dur"] = $itemInfo["dur"] - 1;
                                                    $item = substr_replace($item, sprintf("%02s", dechex($itemInfo["dur"])), 4, 2);
                                                    $newVault = substr_replace($newVault, $item, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                                                }
                                                $amountLoop--;
                                            }
                                        }
                                        if ($jewel == "creation" && $itemInfo["id"] == "22" && $itemInfo["sticklevel"] == "0") {
                                            while (0 < $amountLoop && 1 <= $itemInfo["dur"]) {
                                                if ($itemInfo["dur"] == "1") {
                                                    $itemInfo["dur"] = 0;
                                                    $newVault = substr_replace($newVault, __ITEM_EMPTY__, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                                                } else {
                                                    $itemInfo["dur"] = $itemInfo["dur"] - 1;
                                                    $item = substr_replace($item, sprintf("%02s", dechex($itemInfo["dur"])), 4, 2);
                                                    $newVault = substr_replace($newVault, $item, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                                                }
                                                $amountLoop--;
                                            }
                                        }
                                        if ($jewel == "guardian" && $itemInfo["id"] == "31" && $itemInfo["sticklevel"] == "0") {
                                            while (0 < $amountLoop && 1 <= $itemInfo["dur"]) {
                                                if ($itemInfo["dur"] == "1") {
                                                    $itemInfo["dur"] = 0;
                                                    $newVault = substr_replace($newVault, __ITEM_EMPTY__, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                                                } else {
                                                    $itemInfo["dur"] = $itemInfo["dur"] - 1;
                                                    $item = substr_replace($item, sprintf("%02s", dechex($itemInfo["dur"])), 4, 2);
                                                    $newVault = substr_replace($newVault, $item, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                                                }
                                                $amountLoop--;
                                            }
                                        }
                                        if ($jewel == "harmony" && $itemInfo["id"] == "42" && $itemInfo["sticklevel"] == "0") {
                                            while (0 < $amountLoop && 1 <= $itemInfo["dur"]) {
                                                if ($itemInfo["dur"] == "1") {
                                                    $itemInfo["dur"] = 0;
                                                    $newVault = substr_replace($newVault, __ITEM_EMPTY__, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                                                } else {
                                                    $itemInfo["dur"] = $itemInfo["dur"] - 1;
                                                    $item = substr_replace($item, sprintf("%02s", dechex($itemInfo["dur"])), 4, 2);
                                                    $newVault = substr_replace($newVault, $item, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                                                }
                                                $amountLoop--;
                                            }
                                        }
                                    }
                                }
                                $i++;
                            }
                        }
                        if ($amountLoop == 0) {
                            $newVault = "0x" . $newVault;
                            $update = $dB->query("UPDATE warehouse SET Items = " . $newVault . " WHERE AccountID = '" . $username . "'");
                            $update2 = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET " . $jewel . " = " . $jewel . " + " . $amount . " WHERE AccountID = '" . $username . "'");
                            return true;
                        }
                        message("error", lang("market_txt_80", true));
                        return false;
                    }
                } else {
                    message("error", lang("market_txt_82", true));
                }
            } else {
                message("error", lang("error_23", true));
            }
        } else {
            message("error", lang("error_23", true));
        }
    }
    public function withdrawJewels($username, $jewel, $amount)
    {
        global $dB;
        global $dB2;
        global $common;
        $amount = xss_clean($amount);
        if (check_value($username) && check_value($jewel) && check_value($amount)) {
            if (!Validator::Number($amount)) {
                $error = true;
            }
            if (!Validator::UsernameLength($username)) {
                $error = true;
            }
            if (!Validator::AlphaNumeric($username)) {
                $error = true;
            }
            if ($jewel != "bless" && $jewel != "soul" && $jewel != "life" && $jewel != "chaos" && $jewel != "harmony" && $jewel != "creation" && $jewel != "guardian") {
                $error = true;
            }
            if ($amount < 1) {
                $error = true;
            }
            if (!$error) {
                if (!$common->accountOnline($username)) {
                    $BankData = $this->getBankData($username);
                    if ($BankData[$jewel] < $amount) {
                        message("error", lang("market_txt_83", true));
                    } else {
                        $amount_tmp = $amount;
                        $j30 = 0;
                        $j20 = 0;
                        $j10 = 0;
                        $j1 = 0;
                        $j30 = floor($amount_tmp / 30);
                        $amount_tmp = $amount_tmp % 30;
                        $j20 = floor($amount_tmp / 20);
                        $amount_tmp = $amount_tmp % 20;
                        $j10 = floor($amount_tmp / 10);
                        $amount_tmp = $amount_tmp % 10;
                        $j1 = $amount_tmp;
                        $jewels = [];
                        switch ($jewel) {
                            case "bless":
                                $jewels["code"][1] = "0D0001000000000000E000FFFFFFFFFF00000000FFFFFFFFFFFFFFFFFFFFFFFF";
                                $jewels["code"][10] = "1E0000000000000000C000FFFFFFFFFF00000000FFFFFFFFFFFFFFFFFFFFFFFF";
                                $jewels["code"][20] = "1E0801000000000000C000FFFFFFFFFF00000000FFFFFFFFFFFFFFFFFFFFFFFF";
                                $jewels["code"][30] = "1E1002000000000000C000FFFFFFFFFF00000000FFFFFFFFFFFFFFFFFFFFFFFF";
                                break;
                            case "soul":
                                $jewels["code"][1] = "0E0001000000000000E000FFFFFFFFFF00000000FFFFFFFFFFFFFFFFFFFFFFFF";
                                $jewels["code"][10] = "1F0000000000000000C000FFFFFFFFFF00000000FFFFFFFFFFFFFFFFFFFFFFFF";
                                $jewels["code"][20] = "1F0801000000000000C000FFFFFFFFFF00000000FFFFFFFFFFFFFFFFFFFFFFFF";
                                $jewels["code"][30] = "1F1002000000000000C000FFFFFFFFFF00000000FFFFFFFFFFFFFFFFFFFFFFFF";
                                break;
                            case "life":
                                $jewels["code"][1] = "100001000000000000E000FFFFFFFFFF00000000FFFFFFFFFFFFFFFFFFFFFFFF";
                                $jewels["code"][10] = "880000000000000000C000FFFFFFFFFF00000000FFFFFFFFFFFFFFFFFFFFFFFF";
                                $jewels["code"][20] = "880801000000000000C000FFFFFFFFFF00000000FFFFFFFFFFFFFFFFFFFFFFFF";
                                $jewels["code"][30] = "881002000000000000C000FFFFFFFFFF00000000FFFFFFFFFFFFFFFFFFFFFFFF";
                                break;
                            case "chaos":
                                $jewels["code"][1] = "0F0001000000000000C000FFFFFFFFFF00000000FFFFFFFFFFFFFFFFFFFFFFFF";
                                $jewels["code"][10] = "8D0000000000000000C000FFFFFFFFFF00000000FFFFFFFFFFFFFFFFFFFFFFFF";
                                $jewels["code"][20] = "8D0801000000000000C000FFFFFFFFFF00000000FFFFFFFFFFFFFFFFFFFFFFFF";
                                $jewels["code"][30] = "8D1002000000000000C000FFFFFFFFFF00000000FFFFFFFFFFFFFFFFFFFFFFFF";
                                break;
                            case "harmony":
                                $jewels["code"][1] = "2A0001000000000000E000FFFFFFFFFF00000000FFFFFFFFFFFFFFFFFFFFFFFF";
                                $jewels["code"][10] = "8C0000000000000000C000FFFFFFFFFF00000000FFFFFFFFFFFFFFFFFFFFFFFF";
                                $jewels["code"][20] = "8C0801000000000000C000FFFFFFFFFF00000000FFFFFFFFFFFFFFFFFFFFFFFF";
                                $jewels["code"][30] = "8C1002000000000000C000FFFFFFFFFF00000000FFFFFFFFFFFFFFFFFFFFFFFF";
                                break;
                            case "creation":
                                $jewels["code"][1] = "160001000000000000E000FFFFFFFFFF00000000FFFFFFFFFFFFFFFFFFFFFFFF";
                                $jewels["code"][10] = "890000000000000000C000FFFFFFFFFF00000000FFFFFFFFFFFFFFFFFFFFFFFF";
                                $jewels["code"][20] = "890801000000000000C000FFFFFFFFFF00000000FFFFFFFFFFFFFFFFFFFFFFFF";
                                $jewels["code"][30] = "891002000000000000C000FFFFFFFFFF00000000FFFFFFFFFFFFFFFFFFFFFFFF";
                                break;
                            case "guardian":
                                $jewels["code"][1] = "1F0001000000000000E000FFFFFFFFFF00000000FFFFFFFFFFFFFFFFFFFFFFFF";
                                $jewels["code"][10] = "8A0000000000000000C000FFFFFFFFFF00000000FFFFFFFFFFFFFFFFFFFFFFFF";
                                $jewels["code"][20] = "8A0801000000000000C000FFFFFFFFFF00000000FFFFFFFFFFFFFFFFFFFFFFFF";
                                $jewels["code"][30] = "8A1002000000000000C000FFFFFFFFFF00000000FFFFFFFFFFFFFFFFFFFFFFFF";
                                break;
                            default:
                                $total_jewels = $j30 + $j20 + $j10 + $j1;
                                $vault = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT Items FROM warehouse WHERE AccountID = '" . $username . "'), 2) AS vault");
                                $vault = $vault["vault"];
                                $newVault = $vault;
                                $freeSlots = $this->smartSearchJewels($vault, 1, 1);
                                $totalFreeSlots = substr_count($freeSlots, "0");
                                if ($totalFreeSlots < $total_jewels) {
                                    message("error", lang("market_txt_84", true));
                                } else {
                                    $totalJewels_tmp = $total_jewels;
                                    while (0 < $totalJewels_tmp) {
                                        $pos = strpos($freeSlots, "0");
                                        $freeSlots = substr_replace($freeSlots, "1", $pos, 1);
                                        $serial = $dB->query_fetch_single("exec WZ_GetItemSerial2 1");
                                        $serial = $serial["ItemSerial"];
                                        $serial = dechex($serial);
                                        while (strlen($serial) < 16) {
                                            $serial = "0" . $serial;
                                        }
                                        $serial2 = substr($serial, 0, 8);
                                        $serial = substr($serial, 8, 8);
                                        if (0 < $j30) {
                                            $jewelCode = substr_replace($jewels["code"][30], $serial2, 6, 8);
                                            $jewelCode = substr_replace($jewels["code"][30], $serial, 32, 8);
                                            $j30--;
                                        } else {
                                            if (0 < $j20) {
                                                $jewelCode = substr_replace($jewels["code"][20], $serial2, 6, 8);
                                                $jewelCode = substr_replace($jewels["code"][20], $serial, 32, 8);
                                                $j20--;
                                            } else {
                                                if (0 < $j10) {
                                                    $jewelCode = substr_replace($jewels["code"][10], $serial2, 6, 8);
                                                    $jewelCode = substr_replace($jewels["code"][10], $serial, 32, 8);
                                                    $j10--;
                                                } else {
                                                    if (0 < $j1) {
                                                        $jewelCode = substr_replace($jewels["code"][1], $serial2, 6, 8);
                                                        $jewelCode = substr_replace($jewels["code"][1], $serial, 32, 8);
                                                        $j1--;
                                                    }
                                                }
                                            }
                                        }
                                        $newVault = substr_replace($newVault, $jewelCode, $pos * __ITEM_LENGTH__, __ITEM_LENGTH__);
                                        $totalJewels_tmp--;
                                    }
                                }
                                if ($j30 == 0 && $j20 == 0 && $j10 == 0 && $j1 == 0 && $totalJewels_tmp == 0) {
                                    $newVault = "0x" . $newVault;
                                    $update = $dB->query("UPDATE warehouse SET Items = " . $newVault . " WHERE AccountID = '" . $username . "'");
                                    $update2 = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET " . $jewel . " = " . $jewel . " - " . $amount . " WHERE AccountID = '" . $username . "'");
                                    message("success", lang("market_txt_85", true));
                                    $logDate = date("Y-m-d H:i:s", time());
                                    $common->accountLogs($username, "webbank", sprintf(lang("market_txt_86", true), $amount, ucfirst($jewel)), $logDate);
                                } else {
                                    message("error", lang("market_txt_87", true));
                                }
                        }
                    }
                } else {
                    message("error", lang("error_14", true));
                }
            } else {
                message("error", lang("error_23", true));
            }
        } else {
            message("error", lang("error_23", true));
        }
    }
    public function withdrawJewelsS14($username, $jewel, $amount)
    {
        global $dB;
        global $common;
        $amount = xss_clean($amount);
        if (check_value($username) && check_value($jewel) && check_value($amount)) {
            if (!Validator::Number($amount)) {
                $error = true;
            }
            if (!Validator::UsernameLength($username)) {
                $error = true;
            }
            if (!Validator::AlphaNumeric($username)) {
                $error = true;
            }
            if ($jewel != "bless" && $jewel != "soul" && $jewel != "life" && $jewel != "chaos" && $jewel != "harmony" && $jewel != "creation" && $jewel != "guardian") {
                $error = true;
            }
            if ($amount < 1) {
                $error = true;
            }
            if (!$error) {
                if (!$common->accountOnline($username)) {
                    $BankData = $this->getBankData($username);
                    if ($BankData[$jewel] < $amount) {
                        message("error", lang("market_txt_83", true));
                    } else {
                        $vault = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT Items FROM warehouse WHERE AccountID = '" . $username . "'), 2) AS vault");
                        $vault = $vault["vault"];
                        $newVault = $vault;
                        $freeSlots = $this->smartSearchJewels($vault, 1, 1);
                        $totalFreeSlots = substr_count($freeSlots, "0");
                        $totalSlotsNeeded = floor($amount / 50);
                        if (0 < $amount % 50) {
                            $totalSlotsNeeded++;
                        }
                        if ($totalFreeSlots < $totalSlotsNeeded) {
                            message("error", lang("market_txt_84", true));
                        } else {
                            $newJewelCode = NULL;
                            switch ($jewel) {
                                case "bless":
                                    $newJewelCode = "0D0000000000000000E000FFFFFFFFFF00000000FFFFFFFFFFFFFFFFFFFFFFFF";
                                    break;
                                case "soul":
                                    $newJewelCode = "0E0000000000000000E000FFFFFFFFFF00000000FFFFFFFFFFFFFFFFFFFFFFFF";
                                    break;
                                case "life":
                                    $newJewelCode = "100000000000000000E000FFFFFFFFFF00000000FFFFFFFFFFFFFFFFFFFFFFFF";
                                    break;
                                case "chaos":
                                    $newJewelCode = "0F0000000000000000C000FFFFFFFFFF00000000FFFFFFFFFFFFFFFFFFFFFFFF";
                                    break;
                                case "harmony":
                                    $newJewelCode = "2A0000000000000000E000FFFFFFFFFF00000000FFFFFFFFFFFFFFFFFFFFFFFF";
                                    break;
                                case "creation":
                                    $newJewelCode = "160000000000000000E000FFFFFFFFFF00000000FFFFFFFFFFFFFFFFFFFFFFFF";
                                    break;
                                case "guardian":
                                    $newJewelCode = "1F0000000000000000E000FFFFFFFFFF00000000FFFFFFFFFFFFFFFFFFFFFFFF";
                                    break;
                                default:
                                    $amountTmp = $amount;
                                    $totalSlotsNeededTmp = $totalSlotsNeeded;
                                    while (0 < $totalSlotsNeededTmp) {
                                        if (0 < $amountTmp) {
                                            $pos = strpos($freeSlots, "0");
                                            $freeSlots = substr_replace($freeSlots, "1", $pos, 1);
                                            $newJewelCodeTmp = $newJewelCode;
                                            if (50 <= $amountTmp) {
                                                $newJewelCodeTmp = substr_replace($newJewelCodeTmp, sprintf("%02s", dechex(50)), 4, 2);
                                                $amountTmp = $amountTmp - 50;
                                            } else {
                                                $newJewelCodeTmp = substr_replace($newJewelCodeTmp, sprintf("%02s", dechex($amountTmp)), 4, 2);
                                                $amountTmp = 0;
                                            }
                                            $serial = $dB->query_fetch_single("exec WZ_GetItemSerial2 1");
                                            $serial = $serial["ItemSerial"];
                                            $serial = dechex($serial);
                                            while (strlen($serial) < 16) {
                                                $serial = "0" . $serial;
                                            }
                                            $serial2 = substr($serial, 0, 8);
                                            $serial = substr($serial, 8, 8);
                                            $newJewelCodeTmp = substr_replace($newJewelCodeTmp, $serial2, 6, 8);
                                            $newJewelCodeTmp = substr_replace($newJewelCodeTmp, $serial, 32, 8);
                                            $newVault = substr_replace($newVault, $newJewelCodeTmp, $pos * __ITEM_LENGTH__, __ITEM_LENGTH__);
                                            $totalSlotsNeededTmp--;
                                        }
                                    }
                                    if ($totalSlotsNeededTmp == 0 && $amountTmp == 0) {
                                        $newVault = "0x" . $newVault;
                                        $update = $dB->query("UPDATE warehouse SET Items = " . $newVault . " WHERE AccountID = '" . $username . "'");
                                        $update2 = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET " . $jewel . " = " . $jewel . " - " . $amount . " WHERE AccountID = '" . $username . "'");
                                        message("success", lang("market_txt_85", true));
                                        $logDate = date("Y-m-d H:i:s", time());
                                        $common->accountLogs($username, "webbank", sprintf(lang("market_txt_86", true), $amount, ucfirst($jewel)), $logDate);
                                    } else {
                                        message("error", lang("market_txt_87", true));
                                    }
                            }
                        }
                    }
                } else {
                    message("error", lang("error_14", true));
                }
            } else {
                message("error", lang("error_23", true));
            }
        } else {
            message("error", lang("error_23", true));
        }
    }
    public function smartSearchJewels($whbin, $itemX, $itemY)
    {
        global $dB;
        if (substr($whbin, 0, 2) == "0x") {
            $whbin = substr($whbin, 2);
        }
        $items = str_repeat("0", 120);
        $itemsm = str_repeat("1", 120);
        $i = 0;
        while ($i < 120) {
            $_item = substr($whbin, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
            $sy = hexdec(substr($_item, 0, 2));
            $ioo = hexdec(substr($_item, 14, 2));
            $type = hexdec(substr($_item, 18, 1));
            if (128 <= $ioo) {
                $sy = $sy + 256;
                $ioo -= 128;
            }
            $res = $dB->query_fetch_single("select [X],[Y] from [IMPERIAMUCMS_ITEMS] where [id]='" . $sy . "' and [type]='" . $type . "'");
            $y = 0;
            while ($y < $res["Y"]) {
                $y++;
                $x = 0;
                while ($x < $res["X"]) {
                    $items = substr_replace($items, "1", $i + $x + ($y - 1) * 8, 1);
                    $x++;
                }
            }
            $i++;
        }
        $y = 0;
        while ($y < $itemY) {
            $y++;
            $x = 0;
            while ($x < $itemX) {
                $x++;
                $spacerq[$x + 8 * ($y - 1)] = true;
            }
        }
        $walked = 0;
        $i = 0;
        while ($i < 120) {
            if (isset($spacerq[$i])) {
                $itemsm = substr_replace($itemsm, "0", $i - 1, 1);
                $last = $i;
                $walked++;
            }
            if ($walked == count($spacerq)) {
                $i = 119;
            }
            $i++;
        }
        return $items;
    }
    public function getMarketItems($page, $search, $category)
    {
        global $dB;
        $page = xss_clean($page);
        $search = xss_clean($search);
        $category = xss_clean($category);
        if (!check_value($page)) {
            message("error", lang("error_4", true));
        } else {
            if (!Validator::UnsignedNumber($page)) {
                message("error", lang("error_25", true));
            } else {
                $limit = mconfig("page");
                $total_items = $this->getTotalMarketItems($search, $category);
                $total_pages = ceil($total_items / $limit);
                if ($page < 1) {
                    $page = 1;
                }
                $start = $page * $limit - $limit;
                if ($search != NULL) {
                    if (!check_value($search)) {
                        message("error", lang("error_4", true));
                        return NULL;
                    }
                    if (!Validator::AlphaNumeric($search)) {
                        message("error", lang("error_6", true));
                        return NULL;
                    }
                    if ($category != NULL) {
                        if (!check_value($category)) {
                            message("error", lang("error_4", true));
                            return NULL;
                        }
                        if (!Validator::UnsignedNumber($category)) {
                            message("error", lang("error_25", true));
                            return NULL;
                        }
                        $query = "SELECT DISTINCT M.id, M.cat_id,M.item_id,M.sticklevel,M.item,M.price,M.price_type,M.seller,M.start_date,M.is_sold,M.sold_date,M.purchased_by FROM IMPERIAMUCMS_MARKET M INNER JOIN IMPERIAMUCMS_ITEMS I ON M.cat_id = I.type and M.item_id = I.id where M.is_sold = '0' and I.name LIKE '%" . $search . "%' AND M.cat_id = '" . $category . "' order by M.start_date desc OFFSET " . $start . " ROWS FETCH NEXT " . $limit . " ROWS ONLY";
                    } else {
                        $query = "SELECT DISTINCT M.id, M.cat_id,M.item_id,M.sticklevel,M.item,M.price,M.price_type,M.seller,M.start_date,M.is_sold,M.sold_date,M.purchased_by FROM IMPERIAMUCMS_MARKET M INNER JOIN IMPERIAMUCMS_ITEMS I ON M.cat_id = I.type and M.item_id = I.id where M.is_sold = '0' and I.name LIKE '%" . $search . "%' order by M.start_date desc OFFSET " . $start . " ROWS FETCH NEXT " . $limit . " ROWS ONLY";
                    }
                } else {
                    if ($category != NULL) {
                        if (!Validator::UnsignedNumber($category)) {
                            message("error", lang("error_25", true));
                            return NULL;
                        }
                        $query = "SELECT DISTINCT M.id, M.cat_id,M.item_id,M.sticklevel,M.item,M.price,M.price_type,M.seller,M.start_date,M.is_sold,M.sold_date,M.purchased_by FROM IMPERIAMUCMS_MARKET M INNER JOIN IMPERIAMUCMS_ITEMS I ON M.cat_id = I.type and M.item_id = I.id where M.is_sold = '0' AND M.cat_id = '" . $category . "' order by M.start_date desc OFFSET " . $start . " ROWS FETCH NEXT " . $limit . " ROWS ONLY";
                    } else {
                        $query = "SELECT DISTINCT M.id, M.cat_id,M.item_id,M.sticklevel,M.item,M.price,M.price_type,M.seller,M.start_date,M.is_sold,M.sold_date,M.purchased_by FROM IMPERIAMUCMS_MARKET M INNER JOIN IMPERIAMUCMS_ITEMS I ON M.cat_id = I.type and M.item_id = I.id where M.is_sold = '0' order by M.start_date desc OFFSET " . $start . " ROWS FETCH NEXT " . $limit . " ROWS ONLY";
                    }
                }
                $result = $dB->query_fetch($query);
                if (is_array($result)) {
                    return $result;
                }
                return NULL;
            }
        }
    }
    public function getMyMarketItems($username)
    {
        global $dB;
        if (!check_value($username)) {
            message("error", lang("error_4", true));
        } else {
            if (!Validator::UsernameLength($username)) {
                message("error", lang("error_5", true));
            } else {
                if (!Validator::AlphaNumeric($username)) {
                    message("error", lang("error_6", true));
                } else {
                    $query = "\r\n        SELECT DISTINCT M.id, M.cat_id,M.item_id,M.sticklevel,M.item,M.price,M.price_type,M.seller,M.start_date,M.is_sold,M.sold_date,M.purchased_by,M.Extend \r\n        FROM IMPERIAMUCMS_MARKET M \r\n        INNER JOIN IMPERIAMUCMS_ITEMS I ON M.cat_id = I.type AND M.item_id = I.id \r\n        WHERE M.seller = ? AND M.is_sold = '0' \r\n        ORDER BY M.start_date DESC";
                    $result = $dB->query_fetch($query, [$username]);
                    if (is_array($result)) {
                        return $result;
                    }
                    return NULL;
                }
            }
        }
    }
    public function getLatestMarketItems()
    {
        global $dB;
        $result = $dB->query_fetch("SELECT DISTINCT TOP 5 M.id, M.cat_id,M.item_id,M.sticklevel,M.item,M.price,M.price_type,M.seller,M.start_date,M.is_sold,M.sold_date,M.purchased_by FROM IMPERIAMUCMS_MARKET M INNER JOIN IMPERIAMUCMS_ITEMS I ON M.cat_id = I.type and M.item_id = I.id where M.is_sold = '0' order by M.start_date desc");
        if (is_array($result)) {
            return $result;
        }
        return NULL;
    }
    public function getTotalMarketItems($name_filter = NULL, $category_filter = NULL)
    {
        global $dB;
        $category_filter = xss_clean($category_filter);
        $name_filter = xss_clean($name_filter);
        if ($name_filter != NULL && $category_filter != NULL) {
            $query = "SELECT COUNT(*) as count FROM IMPERIAMUCMS_MARKET M INNER JOIN IMPERIAMUCMS_ITEMS I ON M.cat_id = I.type and M.item_id = I.id where M.is_sold = '0' and I.name LIKE ? AND M.cat_id = ?";
            $array = ["%" . $name_filter . "%", $category_filter];
        } else {
            if ($name_filter != NULL) {
                $query = "SELECT COUNT(*) as count FROM IMPERIAMUCMS_MARKET M INNER JOIN IMPERIAMUCMS_ITEMS I ON M.cat_id = I.type and M.item_id = I.id where M.is_sold = '0' and I.name LIKE ?";
                $array = ["%" . $name_filter . "%"];
            } else {
                if ($category_filter != NULL) {
                    $query = "SELECT COUNT(*) as count FROM IMPERIAMUCMS_MARKET M INNER JOIN IMPERIAMUCMS_ITEMS I ON M.cat_id = I.type and M.item_id = I.id where M.is_sold = '0' AND M.cat_id = ?";
                    $array = [$category_filter];
                } else {
                    $query = "SELECT COUNT(*) as count FROM IMPERIAMUCMS_MARKET where is_sold = '0'";
                }
            }
        }
        $result = $dB->query_fetch_single($query, $array);
        if (is_array($result)) {
            return $result["count"];
        }
        return 0;
    }
    public function getVaultData($username)
    {
        global $dB;
        global $common;
        if (!check_value($username)) {
            message("error", lang("error_4", true));
        } else {
            if (!Validator::UsernameLength($username)) {
                message("error", lang("error_5", true));
            } else {
                if (!Validator::AlphaNumeric($username)) {
                    message("error", lang("error_6", true));
                } else {
                    $result = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT Items FROM warehouse WHERE AccountID = ?), 2) AS vault", [$username]);
                    $result = $result["vault"];
                    return $result;
                }
            }
        }
    }
    public function protectMarketItem($market_id)
    {
        global $dB;
        $dB->query("UPDATE IMPERIAMUCMS_MARKET SET protected = ? WHERE id = ?", [1, $market_id]);
    }
    public function unprotectMarketItem($market_id)
    {
        global $dB;
        $dB->query("UPDATE IMPERIAMUCMS_MARKET SET protected = ? WHERE id = ?", [0, $market_id]);
    }
    public function buyItem($market_id, $username)
    {
        global $dB;
        global $dB2;
        global $common;
        $market_id = Decode($market_id);
        $Items = new Items();
        if (!check_value($username)) {
            message("error", lang("error_4", true));
        } else {
            if (!check_value($market_id)) {
                message("error", lang("error_4", true));
            } else {
                if (!Validator::UsernameLength($username)) {
                    message("error", lang("error_5", true));
                } else {
                    if (!Validator::AlphaNumeric($username)) {
                        message("error", lang("error_6", true));
                    } else {
                        if (!is_numeric($market_id)) {
                            return NULL;
                        }
                        $data = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_MARKET WHERE id = ?", [$market_id]);
                        if (is_array($data)) {
                            if ($data["is_sold"] == "0" && $data["protected"] == "0") {
                                $this->protectMarketItem($market_id);
                                $seller = $data["seller"];
                                if (mconfig("online_check") && $common->accountOnline($username) && $username != $seller) {
                                    $this->unprotectMarketItem($market_id);
                                    message("error", lang("error_14", true));
                                    return NULL;
                                }
                                switch ($data["price_type"]) {
                                    case "platinum":
                                        break;
                                    case "gold":
                                        break;
                                    case "silver":
                                        if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                            $currency = $dB2->query_fetch_single("SELECT * FROM MEMB_CREDITS WHERE memb___id = ?", [$username]);
                                        } else {
                                            $currency = $dB->query_fetch_single("SELECT * FROM MEMB_CREDITS WHERE memb___id = ?", [$username]);
                                        }
                                        break;
                                    case "WCoinC":
                                        break;
                                    case "GoblinPoint":
                                        $currency = $dB->query_fetch_single("SELECT * FROM T_InGameShop_Point WHERE AccountID = ?", [$username]);
                                        break;
                                    case "zen":
                                        break;
                                    case "bless":
                                        break;
                                    case "soul":
                                        break;
                                    case "life":
                                        break;
                                    case "chaos":
                                        break;
                                    case "harmony":
                                        break;
                                    case "creation":
                                        break;
                                    case "guardian":
                                        $currency = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$username]);
                                        $bankCheck = $dB->query_fetch_single("SELECT * from IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$seller]);
                                        if ($currency == NULL) {
                                            $insert = $dB->query("INSERT INTO IMPERIAMUCMS_WEB_BANK(AccountID,zen,bless,soul,life,chaos,harmony,creation,guardian)\r\n                                    VALUES('" . $username . "',0,0,0,0,0,0,0,0)");
                                        }
                                        if ($bankCheck == NULL) {
                                            $insert = $dB->query("INSERT INTO IMPERIAMUCMS_WEB_BANK(AccountID,zen,bless,soul,life,chaos,harmony,creation,guardian)\r\n                                    VALUES('" . $seller . "',0,0,0,0,0,0,0,0)");
                                        }
                                        break;
                                    default:
                                        if ($data["price_type"] == "WCoinC" && 100 <= config("server_files_season", true)) {
                                            $data["price_type"] = "WCoin";
                                        }
                                        if ($username == $seller) {
                                            if ($data["price_type"] == "platinum") {
                                                $price_type = 1;
                                            } else {
                                                if ($data["price_type"] == "gold") {
                                                    $price_type = 2;
                                                } else {
                                                    if ($data["price_type"] == "silver") {
                                                        $price_type = 4;
                                                    } else {
                                                        if ($data["price_type"] == "WCoinC" || $data["price_type"] == "WCoin") {
                                                            $price_type = 8;
                                                        } else {
                                                            if ($data["price_type"] == "GoblinPoint") {
                                                                $price_type = 9;
                                                            } else {
                                                                if ($data["price_type"] == "zen") {
                                                                    $price_type = 10;
                                                                } else {
                                                                    if ($data["price_type"] == "bless") {
                                                                        $price_type = 11;
                                                                    } else {
                                                                        if ($data["price_type"] == "soul") {
                                                                            $price_type = 12;
                                                                        } else {
                                                                            if ($data["price_type"] == "life") {
                                                                                $price_type = 13;
                                                                            } else {
                                                                                if ($data["price_type"] == "chaos") {
                                                                                    $price_type = 14;
                                                                                } else {
                                                                                    if ($data["price_type"] == "harmony") {
                                                                                        $price_type = 15;
                                                                                    } else {
                                                                                        if ($data["price_type"] == "creation") {
                                                                                            $price_type = 16;
                                                                                        } else {
                                                                                            if ($data["price_type"] == "guardian") {
                                                                                                $price_type = 17;
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
                                                    }
                                                }
                                            }
                                            $totalItems = $dB->query_fetch_single("SELECT COUNT(*) as count FROM IMPERIAMUCMS_WEBSHOP_ITEMS_INVENTORY WHERE AccountID = ? AND status = '0'", [$username]);
                                            if (mconfig("limit_inventory") <= $totalItems["count"]) {
                                                $this->unprotectMarketItem($market_id);
                                                $lack = $totalItems["count"] - mconfig("limit_inventory") + 1;
                                                message("error", sprintf(lang("market_txt_88", true), $lack));
                                            } else {
                                                $date = date("Y-m-d H:i:s", time());
                                                $update3 = $dB->query("UPDATE IMPERIAMUCMS_MARKET SET is_sold = '1', sold_date = ?, purchased_by = ? WHERE id = ?", [$date, $username, $market_id]);
                                                $insert1 = $dB->query("INSERT INTO IMPERIAMUCMS_WEBSHOP_ITEMS_INVENTORY (AccountID,item,price,price_type,date,status,type,giftFrom) VALUES(?,?,?,?,?,0,5,null)", [$username, $data["item"], $data["price"], $price_type, $date]);
                                                $insert2 = $dB->query("INSERT INTO IMPERIAMUCMS_MARKET_LOGS(buyer,seller,item,date,type) VALUES(?,?,?,?,'returned')", [$username, $seller, $data["item"], $date]);
                                                message("success", lang("market_txt_89", true));
                                                $logDate = date("Y-m-d H:i:s", time());
                                                $common->accountLogs($username, "market", sprintf(lang("market_txt_90", true), $data["item"]), $logDate);
                                            }
                                        } else {
                                            if ($data["price"] <= $currency[$data["price_type"]]) {
                                                if ($data["price_type"] == "platinum") {
                                                    $price_type = 1;
                                                } else {
                                                    if ($data["price_type"] == "gold") {
                                                        $price_type = 2;
                                                    } else {
                                                        if ($data["price_type"] == "silver") {
                                                            $price_type = 4;
                                                        } else {
                                                            if ($data["price_type"] == "WCoinC" || $data["price_type"] == "WCoin") {
                                                                $price_type = 8;
                                                            } else {
                                                                if ($data["price_type"] == "GoblinPoint") {
                                                                    $price_type = 9;
                                                                } else {
                                                                    if ($data["price_type"] == "zen") {
                                                                        $price_type = 10;
                                                                    } else {
                                                                        if ($data["price_type"] == "bless") {
                                                                            $price_type = 11;
                                                                        } else {
                                                                            if ($data["price_type"] == "soul") {
                                                                                $price_type = 12;
                                                                            } else {
                                                                                if ($data["price_type"] == "life") {
                                                                                    $price_type = 13;
                                                                                } else {
                                                                                    if ($data["price_type"] == "chaos") {
                                                                                        $price_type = 14;
                                                                                    } else {
                                                                                        if ($data["price_type"] == "harmony") {
                                                                                            $price_type = 15;
                                                                                        } else {
                                                                                            if ($data["price_type"] == "creation") {
                                                                                                $price_type = 16;
                                                                                            } else {
                                                                                                if ($data["price_type"] == "guardian") {
                                                                                                    $price_type = 17;
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
                                                        }
                                                    }
                                                }
                                                $item = $Items->ItemInfo($data["item"]);
                                                if ($item["type"] == 12 && (200 <= $item["id"] && $item["id"] <= 218 || 306 <= $item["id"] && $item["id"] <= 308)) {
                                                    $durabilityEdit = $item["dur"] - 1;
                                                    $data["item"] = substr_replace($data["item"], sprintf("%02s", dechex($durabilityEdit)), 4, 2);
                                                    $pentagram_slots = 0;
                                                    if (0 <= $item["soc1"] && $item["soc1"] < 254) {
                                                        $pentagram_slots++;
                                                    }
                                                    if (0 <= $item["soc2"] && $item["soc2"] < 254) {
                                                        $pentagram_slots++;
                                                    }
                                                    if (0 <= $item["soc3"] && $item["soc3"] < 254) {
                                                        $pentagram_slots++;
                                                    }
                                                    if (0 <= $item["soc4"] && $item["soc4"] < 254) {
                                                        $pentagram_slots++;
                                                    }
                                                    if (0 <= $item["soc5"] && $item["soc5"] < 254) {
                                                        $pentagram_slots++;
                                                    }
                                                    $buyerPentagram = $dB->query_fetch_single("SELECT TOP 1 JewelIndex FROM T_PentagramInfo WHERE AccountID = ? ORDER BY JewelIndex DESC");
                                                    if ($buyerPentagram["JewelIndex"] == NULL) {
                                                        $buyerPentagram["JewelIndex"] = 0;
                                                    }
                                                    if (254 <= $buyerPentagram["JewelIndex"] + $pentagram_slots) {
                                                        $this->unprotectMarketItem($market_id);
                                                        message("error", lang("market_txt_196", true));
                                                        return NULL;
                                                    }
                                                    if ($buyerPentagram["JewelIndex"] == 0) {
                                                        $soc1_index = 0;
                                                    } else {
                                                        $soc1_index = $buyerPentagram["JewelIndex"] + 1;
                                                    }
                                                    $soc2_index = $soc1_index + 1;
                                                    $soc3_index = $soc2_index + 1;
                                                    $soc4_index = $soc3_index + 1;
                                                    $soc5_index = $soc4_index + 1;
                                                    if (0 <= $item["soc1"] && $item["soc1"] < 254) {
                                                        $data["item"] = substr_replace($data["item"], sprintf("%02s", dechex($soc1_index)), 22, 2);
                                                    }
                                                    if (0 <= $item["soc2"] && $item["soc2"] < 254) {
                                                        $data["item"] = substr_replace($data["item"], sprintf("%02s", dechex($soc2_index)), 24, 2);
                                                    }
                                                    if (0 <= $item["soc3"] && $item["soc3"] < 254) {
                                                        $data["item"] = substr_replace($data["item"], sprintf("%02s", dechex($soc3_index)), 26, 2);
                                                    }
                                                    if (0 <= $item["soc4"] && $item["soc4"] < 254) {
                                                        $data["item"] = substr_replace($data["item"], sprintf("%02s", dechex($soc4_index)), 28, 2);
                                                    }
                                                    if (0 <= $item["soc5"] && $item["soc5"] < 254) {
                                                        $data["item"] = substr_replace($data["item"], sprintf("%02s", dechex($soc5_index)), 30, 2);
                                                    }
                                                    $update_pentagram1 = $dB->query("UPDATE T_PentagramInfo SET AccountID = ?, JewelIndex = ? WHERE AccountID = ? AND JewelIndex = ?", [$username, $soc1_index, $seller, $item["soc1"]]);
                                                    $update_pentagram2 = $dB->query("UPDATE T_PentagramInfo SET AccountID = ?, JewelIndex = ? WHERE AccountID = ? AND JewelIndex = ?", [$username, $soc2_index, $seller, $item["soc2"]]);
                                                    $update_pentagram3 = $dB->query("UPDATE T_PentagramInfo SET AccountID = ?, JewelIndex = ? WHERE AccountID = ? AND JewelIndex = ?", [$username, $soc3_index, $seller, $item["soc3"]]);
                                                    $update_pentagram4 = $dB->query("UPDATE T_PentagramInfo SET AccountID = ?, JewelIndex = ? WHERE AccountID = ? AND JewelIndex = ?", [$username, $soc4_index, $seller, $item["soc4"]]);
                                                    $update_pentagram5 = $dB->query("UPDATE T_PentagramInfo SET AccountID = ?, JewelIndex = ? WHERE AccountID = ? AND JewelIndex = ?", [$username, $soc5_index, $seller, $item["soc5"]]);
                                                }
                                                switch ($data["price_type"]) {
                                                    case "platinum":
                                                        break;
                                                    case "gold":
                                                        break;
                                                    case "silver":
                                                        if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                                            $update1 = $dB2->query("UPDATE MEMB_CREDITS SET " . $data["price_type"] . " = " . $data["price_type"] . " - " . $data["price"] . ", " . $data["price_type"] . "_used = " . $data["price_type"] . "_used + " . $data["price"] . " WHERE memb___id = '" . $username . "'");
                                                            $update2 = $dB2->query("UPDATE MEMB_CREDITS SET " . $data["price_type"] . " = " . $data["price_type"] . " + " . $data["price"] . " WHERE memb___id = '" . $seller . "'");
                                                        } else {
                                                            $update1 = $dB->query("UPDATE MEMB_CREDITS SET " . $data["price_type"] . " = " . $data["price_type"] . " - " . $data["price"] . ", " . $data["price_type"] . "_used = " . $data["price_type"] . "_used + " . $data["price"] . " WHERE memb___id = '" . $username . "'");
                                                            $update2 = $dB->query("UPDATE MEMB_CREDITS SET " . $data["price_type"] . " = " . $data["price_type"] . " + " . $data["price"] . " WHERE memb___id = '" . $seller . "'");
                                                        }
                                                        break;
                                                    case "WCoinC":
                                                        break;
                                                    case "WCoin":
                                                        break;
                                                    case "GoblinPoint":
                                                        $update1 = $dB->query("UPDATE T_InGameShop_Point SET " . $data["price_type"] . " = " . $data["price_type"] . " - " . $data["price"] . " WHERE AccountID = '" . $username . "'");
                                                        $update2 = $dB->query("UPDATE T_InGameShop_Point SET " . $data["price_type"] . " = " . $data["price_type"] . " + " . $data["price"] . " WHERE AccountID = '" . $seller . "'");
                                                        break;
                                                    case "zen":
                                                        break;
                                                    case "bless":
                                                        break;
                                                    case "soul":
                                                        break;
                                                    case "life":
                                                        break;
                                                    case "chaos":
                                                        break;
                                                    case "harmony":
                                                        break;
                                                    case "creation":
                                                        break;
                                                    case "guardian":
                                                        $update1 = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET " . $data["price_type"] . " = " . $data["price_type"] . " - " . $data["price"] . " WHERE AccountID = '" . $username . "'");
                                                        $update2 = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET " . $data["price_type"] . " = " . $data["price_type"] . " + " . $data["price"] . " WHERE AccountID = '" . $seller . "'");
                                                        break;
                                                    default:
                                                        $date = date("Y-m-d H:i:s", time());
                                                        $update3 = $dB->query("UPDATE IMPERIAMUCMS_MARKET SET is_sold = ?, sold_date = ?, purchased_by = ? WHERE id = ?", [1, $date, $username, $market_id]);
                                                        $insert1 = $dB->query("INSERT INTO IMPERIAMUCMS_WEBSHOP_ITEMS_INVENTORY(AccountID,item,price,price_type,date,status,type,giftFrom) VALUES(?,?,?,?,?,?,?,?)", [$username, $data["item"], $data["price"], $price_type, $date, 0, 4, NULL]);
                                                        $insert2 = $dB->query("INSERT INTO IMPERIAMUCMS_MARKET_LOGS (buyer,seller,item,date,type) VALUES (?, ?, ?, ?, ?)", [$username, $seller, $data["item"], $date, "purchased"]);
                                                        message("success", lang("market_txt_91", true));
                                                        $logDate = date("Y-m-d H:i:s", time());
                                                        $common->accountLogs($username, "market", sprintf(lang("market_txt_90", true), $data["item"]), $logDate);
                                                }
                                            } else {
                                                $this->unprotectMarketItem($market_id);
                                                $lack = $data["price"] - $currency[$data["price_type"]];
                                                $lackCurrency = $this->showStyledPrice($data["price_type"], $lack);
                                                message("error", sprintf(lang("market_txt_93", true), $lackCurrency));
                                            }
                                        }
                                }
                            } else {
                                $this->unprotectMarketItem($market_id);
                                message("error", lang("market_txt_94", true));
                            }
                        } else {
                            $this->unprotectMarketItem($market_id);
                            message("error", lang("market_txt_95", true));
                        }
                    }
                }
            }
        }
    }
    public function showStyledPrice($type, $price)
    {
        if (!check_value($type)) {
            message("error", lang("error_4", true));
        } else {
            if (!check_value($price)) {
                message("error", lang("error_4", true));
            } else {
                if (!Validator::UnsignedNumber($price)) {
                    throw new Exception(lang("error_25", true));
                }
                if (!Validator::AlphaNumeric($type)) {
                    message("error", lang("error_6", true));
                } else {
                    switch ($type) {
                        case "zen":
                            return "<font color=\"#ffffff\">" . number_format($price) . "</font> " . lang("currency_zen", true) . "";
                            break;
                        case "platinum":
                            return "<font color=\"#00ffa8\">" . number_format($price) . "</font> " . lang("currency_platinum", true);
                            break;
                        case "gold":
                            return "<font color=\"#b38e47\">" . number_format($price) . "</font> " . lang("currency_gold", true);
                            break;
                        case "silver":
                            return "<font color=\"#959595\">" . number_format($price) . "</font> " . lang("currency_silver", true);
                            break;
                        case "WCoinC":
                            return "<font color=\"#ffffff\">" . number_format($price) . "</font> " . lang("currency_wcoinc", true);
                            break;
                        case "GoblinPoint":
                            return "<font color=\"#ffffff\">" . number_format($price) . "</font> " . lang("currency_gp", true);
                            break;
                        case "bless":
                            return "<font color=\"#ffffff\">" . number_format($price) . "</font> " . lang("currency_bless", true) . "";
                            break;
                        case "soul":
                            return "<font color=\"#ffffff\">" . number_format($price) . "</font> " . lang("currency_soul", true) . "";
                            break;
                        case "life":
                            return "<font color=\"#ffffff\">" . number_format($price) . "</font> " . lang("currency_life", true) . "";
                            break;
                        case "chaos":
                            return "<font color=\"#ffffff\">" . number_format($price) . "</font> " . lang("currency_chaos", true) . "";
                            break;
                        case "harmony":
                            return "<font color=\"#ffffff\">" . number_format($price) . "</font> " . lang("currency_harmony", true) . "";
                            break;
                        case "creation":
                            return "<font color=\"#ffffff\">" . number_format($price) . "</font> " . lang("currency_creation", true) . "";
                            break;
                        case "guardian":
                            return "<font color=\"#ffffff\">" . number_format($price) . "</font> " . lang("currency_guardian", true) . "";
                            break;
                    }
                }
            }
        }
    }
    public function showPrice($type, $price)
    {
        if (!check_value($type)) {
            message("error", lang("error_4", true));
        } else {
            if (!check_value($price)) {
                message("error", lang("error_4", true));
            } else {
                if (!Validator::UnsignedNumber($price)) {
                    throw new Exception(lang("error_25", true));
                }
                if (!Validator::AlphaNumeric($type)) {
                    message("error", lang("error_6", true));
                } else {
                    switch ($type) {
                        case "zen":
                            return "<span class=\"market-widget-price\">" . number_format($price) . " " . lang("currency_zen", true) . "</span>";
                            break;
                        case "platinum":
                            return "<span class=\"market-widget-price\">" . number_format($price) . " " . lang("currency_platinum", true) . "</span>";
                            break;
                        case "gold":
                            return "<span class=\"market-widget-price\">" . number_format($price) . " " . lang("currency_gold", true) . "</span>";
                            break;
                        case "silver":
                            return "<span class=\"market-widget-price\">" . number_format($price) . " " . lang("currency_silver", true) . "</span>";
                            break;
                        case "WCoinC":
                            return "<span class=\"market-widget-price\">" . number_format($price) . " " . lang("currency_wcoinc", true) . "</span>";
                            break;
                        case "GoblinPoint":
                            return "<span class=\"market-widget-price\">" . number_format($price) . " " . lang("currency_gp", true) . "</span>";
                            break;
                        case "bless":
                            return "<span class=\"market-widget-price\">" . number_format($price) . " " . lang("currency_bless", true) . "</span>";
                            break;
                        case "soul":
                            return "<span class=\"market-widget-price\">" . number_format($price) . " " . lang("currency_soul", true) . "</span>";
                            break;
                        case "life":
                            return "<span class=\"market-widget-price\">" . number_format($price) . " " . lang("currency_life", true) . "</span>";
                            break;
                        case "chaos":
                            return "<span class=\"market-widget-price\">" . number_format($price) . " " . lang("currency_chaos", true) . "</span>";
                            break;
                        case "harmony":
                            return "<span class=\"market-widget-price\">" . number_format($price) . " " . lang("currency_harmony", true) . "</span>";
                            break;
                        case "creation":
                            return "<span class=\"market-widget-price\">" . number_format($price) . " " . lang("currency_creation", true) . "</span>";
                            break;
                        case "guardian":
                            return "<span class=\"market-widget-price\">" . number_format($price) . " " . lang("currency_guardian", true) . "</span>";
                            break;
                    }
                }
            }
        }
    }
    public function showVault($data, $isExpanded, $token)
    {
        $Items = new Items();
        echo "\r\n      <table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"table1\">\r\n        <tr>\r\n          <td colspan=\"3\"><img src=\"" . __PATH_TEMPLATE_IMG__ . "misc_images/warehouse_header.jpg\"></td>";
        if ($isExpanded) {
            echo "<td colspan=\"3\"><img src=\"" . __PATH_TEMPLATE_IMG__ . "misc_images/warehouse_header_expanded.jpg\"></td>";
        }
        echo "\r\n        </tr>\r\n        <tr>\r\n          <td><img src=\"" . __PATH_TEMPLATE_IMG__ . "misc_images/warehouse_left.jpg\"></td>\r\n          <td>\r\n            <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"vaults\">\r\n              <tr>";
        $il = __ITEM_LENGTH__;
        $wh_content = "";
        $user_items = $data;
        $check = "011111111";
        $xx = 0;
        $yy = 1;
        $line = 1;
        $onn = 0;
        $i = -1;
        while ($i < 119) {
            $i++;
            if ($xx == 8) {
                $xx = 1;
                $yy++;
            } else {
                $xx++;
            }
            $TT = substr($check, $xx, 1);
            if (round($i / 8) == $i / 8 && $i != 0) {
                $wh_content .= "</tr><tr>";
                $line++;
            }
            $l = $i;
            $item = $Items->ItemInfo(substr($user_items, $il * $i, $il));
            if (!$item["Y"]) {
                $InsPosY = 1;
            } else {
                $InsPosY = $item["Y"];
            }
            if (!$item["X"]) {
                $InsPosX = 1;
            } else {
                $InsPosX = $item["X"];
                $xxx = $xx;
                $InsPosXX = $InsPosX;
                $InsPosYY = $InsPosY;
                while (0 < $InsPosXX) {
                    $check = substr_replace($check, $InsPosYY, $xxx, 1);
                    $InsPosXX = $InsPosXX - 1;
                    $InsPosYY = $InsPosY + 1;
                    $xxx++;
                }
            }
            $item["name"] = addslashes($item["name"]);
            if (1 < $TT) {
                $check = substr_replace($check, $TT - 1, $xx, 1);
            } else {
                unset($plusche);
                unset($rqs);
                unset($luck);
                unset($skill);
                unset($option);
                unset($exl);
                unset($ancsetopt);
                if ($item["name"]) {
                    if ($item["level"]) {
                        $plusche = "+" . $item["level"];
                    }
                    $rqs = "";
                    if ($item["str"]) {
                        $rqs .= $item["str"] . " " . lang("market_txt_96", true) . "<br>";
                    }
                    if ($item["nrg"]) {
                        $rqs .= $item["nrg"] . " " . lang("market_txt_97", true) . "<br>";
                    }
                    if ($item["cmd"]) {
                        $rqs .= $item["cmd"] . " " . lang("market_txt_98", true) . "<br>";
                    }
                    if ($item["agi"]) {
                        $rqs .= $item["agi"] . " " . lang("market_txt_99", true) . "<br>";
                    }
                    if (!$item["luck"] && !$item["exl"] && !$item["skill"] && !$item["option"] && !$item["ancsetopt"]) {
                        $addx = "<br>";
                    }
                    if ($item["opt"]) {
                        $option = "<font color=#9aadd5>" . $item["opt"] . "</font><br>";
                    }
                    if ($item["luck"]) {
                        $luck = "<font color=#9aadd5>" . $item["luck"] . "</font>";
                    }
                    if ($item["skill"]) {
                        $skill = "<br><font color=#9aadd5>" . $item["skill"] . "<br></font>";
                    }
                    if ($item["exl"]) {
                        $exl = "<font color=#4d668d>" . str_replace("^^", "<br>", $item["exl"]) . "</font>";
                    }
                    if ($item["ancsetopt"]) {
                        $ancsetopt = "<font color=#9aadd5>" . str_replace("^^", "<br>", $item["ancsetopt"]) . "</font>";
                    }
                    if ($item["level"]) {
                        $item["level"] = " +" . $item["level"];
                    } else {
                        $item["level"] = NULL;
                    }
                    $exl = str_replace("'", "\\'", $exl);
                    $wh_content .= "\r\n          <td colspan=\"" . $InsPosX . "\" rowspan=\"" . $InsPosY . "\" style=\"width:" . 24 * $InsPosX . "px;height:" . 24 * $InsPosY . "px;border:0;margin:0;padding:0;\">\r\n            <a href=\"" . __BASE_URL__ . "usercp/vault/?item=" . Encode($item["sn2"] . $item["sn"]) . "\" onmouseover=\"Tip('<center><img src=" . $item["thumb"] . "><br /><font color=yellow><br>" . lang("market_txt_100", true) . " " . $item["sn2"] . $item["sn"] . "</font><br><font color=white><br>" . lang("market_txt_101", true) . " " . $item["dur"] . "</font><br><font color=#FF99CC>" . $item["jog"] . "</font><font color=FFCC00>" . $item["harm"] . "</font><br>" . $option . " " . $luck . " " . $skill . " " . $exl . " <br>" . $ancsetopt . "<br><font color=#4d668d>" . $item["socket"] . "</font><br><br><span class=itemTooltipClassReq>" . $item["classReq"] . "</span></center>', TITLEFONTCOLOR, '" . $item["color"] . "',TITLE,'" . $item["name"] . $item["level"] . "',TITLEBGCOLOR,'" . $item["anco"] . "')\" onmouseout=\"UnTip()\" style=\"width:" . 24 * $InsPosX . "px;height:" . 24 * $InsPosY . "px;\"><img src=\"" . $item["thumb"] . "\" style=\"width:" . 24 * $InsPosX . "px;height:" . 24 * $InsPosY . "px;\" class=\"m\"></a>\r\n          </td>\r\n          ";
                } else {
                    $wh_content .= "<td colspan='1' rowspan='1' style='width:24px;height:24px;border:0;margin:0;padding:0;'>\r\n          <img src='" . __PATH_TEMPLATE_IMG__ . "misc_images/warehouse_block.jpg' style='height: 24px;width: 24px;' class='m'></td>";
                }
            }
        }
        echo $wh_content;
        echo "\r\n              </tr>\r\n            </table>\r\n          </td>\r\n          <td><img src=\"" . __PATH_TEMPLATE_IMG__ . "misc_images/warehouse_right.jpg\"></td>";
        if ($isExpanded) {
            echo "<td><img src=\"" . __PATH_TEMPLATE_IMG__ . "misc_images/warehouse_left.jpg\"></td>\r\n          <td>\r\n            <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"vaults\">\r\n              <tr>";
            $il = __ITEM_LENGTH__;
            $wh_content = "";
            $user_items = substr($data, 7680, 7680);
            $check = "011111111";
            $xx = 0;
            $yy = 1;
            $line = 1;
            $onn = 0;
            $i = -1;
            while ($i < 119) {
                $i++;
                if ($xx == 8) {
                    $xx = 1;
                    $yy++;
                } else {
                    $xx++;
                }
                $TT = substr($check, $xx, 1);
                if (round($i / 8) == $i / 8 && $i != 0) {
                    $wh_content .= "</tr><tr>";
                    $line++;
                }
                $l = $i;
                $item = $Items->ItemInfo(substr($user_items, $il * $i, $il));
                if (!$item["Y"]) {
                    $InsPosY = 1;
                } else {
                    $InsPosY = $item["Y"];
                }
                if (!$item["X"]) {
                    $InsPosX = 1;
                } else {
                    $InsPosX = $item["X"];
                    $xxx = $xx;
                    $InsPosXX = $InsPosX;
                    $InsPosYY = $InsPosY;
                    while (0 < $InsPosXX) {
                        $check = substr_replace($check, $InsPosYY, $xxx, 1);
                        $InsPosXX = $InsPosXX - 1;
                        $InsPosYY = $InsPosY + 1;
                        $xxx++;
                    }
                }
                $item["name"] = addslashes($item["name"]);
                if (1 < $TT) {
                    $check = substr_replace($check, $TT - 1, $xx, 1);
                } else {
                    unset($plusche);
                    unset($rqs);
                    unset($luck);
                    unset($skill);
                    unset($option);
                    unset($exl);
                    unset($ancsetopt);
                    if ($item["name"]) {
                        if ($item["level"]) {
                            $plusche = "+" . $item["level"];
                        }
                        $rqs = "";
                        if ($item["str"]) {
                            $rqs .= $item["str"] . " " . lang("market_txt_96", true) . "<br>";
                        }
                        if ($item["nrg"]) {
                            $rqs .= $item["nrg"] . " " . lang("market_txt_97", true) . "<br>";
                        }
                        if ($item["cmd"]) {
                            $rqs .= $item["cmd"] . " " . lang("market_txt_98", true) . "<br>";
                        }
                        if ($item["agi"]) {
                            $rqs .= $item["agi"] . " " . lang("market_txt_99", true) . "<br>";
                        }
                        if (!$item["luck"] && !$item["exl"] && !$item["skill"] && !$item["option"] && !$item["ancsetopt"]) {
                            $addx = "<br>";
                        }
                        if ($item["opt"]) {
                            $option = "<font color=#9aadd5>" . $item["opt"] . "</font><br>";
                        }
                        if ($item["luck"]) {
                            $luck = "<font color=#9aadd5>" . $item["luck"] . "</font>";
                        }
                        if ($item["skill"]) {
                            $skill = "<br><font color=#9aadd5>" . $item["skill"] . "<br></font>";
                        }
                        if ($item["exl"]) {
                            $exl = "<font color=#4d668d>" . str_replace("^^", "<br>", $item["exl"]) . "</font>";
                        }
                        if ($item["ancsetopt"]) {
                            $ancsetopt = "<font color=#9aadd5>" . str_replace("^^", "<br>", $item["ancsetopt"]) . "</font>";
                        }
                        if ($item["level"]) {
                            $item["level"] = " +" . $item["level"];
                        } else {
                            $item["level"] = NULL;
                        }
                        $exl = str_replace("'", "\\'", $exl);
                        $wh_content .= "\r\n          <td colspan=\"" . $InsPosX . "\" rowspan=\"" . $InsPosY . "\" style=\"width:" . 24 * $InsPosX . "px;height:" . 24 * $InsPosY . "px;border:0;margin:0;padding:0;\">\r\n            <a href=\"" . __BASE_URL__ . "usercp/vault/?item=" . Encode($item["sn2"] . $item["sn"]) . "\" onmouseover=\"Tip('<center><img src=" . $item["thumb"] . "><br /><font color=yellow><br>" . lang("market_txt_100", true) . " " . $item["sn2"] . $item["sn"] . "</font><br><font color=white><br>" . lang("market_txt_101", true) . " " . $item["dur"] . "</font><br><font color=#FF99CC>" . $item["jog"] . "</font><font color=FFCC00>" . $item["harm"] . "</font><br>" . $option . " " . $luck . " " . $skill . " " . $exl . " <br>" . $ancsetopt . "<br><font color=#4d668d>" . $item["socket"] . "</font><br><br><span class=itemTooltipClassReq>" . $item["classReq"] . "</span></center>', TITLEFONTCOLOR, '" . $item["color"] . "',TITLE,'" . $item["name"] . $item["level"] . "',TITLEBGCOLOR,'" . $item["anco"] . "')\" onmouseout=\"UnTip()\" style=\"width:" . 24 * $InsPosX . "px;height:" . 24 * $InsPosY . "px;\"><img src=\"" . $item["thumb"] . "\" style=\"width:" . 24 * $InsPosX . "px;height:" . 24 * $InsPosY . "px;\" class=\"m\"></a>\r\n          </td>\r\n          ";
                    } else {
                        $wh_content .= "<td colspan='1' rowspan='1' style='width:24px;height:24px;border:0;margin:0;padding:0;'>\r\n          <img src='" . __PATH_TEMPLATE_IMG__ . "misc_images/warehouse_block.jpg' style='height: 24px;width: 24px;' class='m'></td>";
                    }
                }
            }
            echo $wh_content;
            echo "\r\n              </tr>\r\n            </table>\r\n          </td>\r\n          <td><img src=\"" . __PATH_TEMPLATE_IMG__ . "misc_images/warehouse_right.jpg\"></td>";
        }
        echo "\r\n        </tr>\r\n        <tr>\r\n          <td colspan=\"3\"><img src=\"" . __PATH_TEMPLATE_IMG__ . "misc_images/warehouse_bottom.jpg\"></td>";
        if ($isExpanded) {
            echo "<td colspan=\"3\"><img src=\"" . __PATH_TEMPLATE_IMG__ . "misc_images/warehouse_bottom.jpg\"></td>";
        }
        echo "\r\n        </tr>\r\n      </table>\r\n    ";
    }
    public function showVaultResponsive($data, $isExpanded, $token)
    {
        $Items = new Items();
        if ($isExpanded) {
            echo "\r\n        <div class=\"row\">\r\n            <div class=\"col-xs-12 col-md-6 text-right\">\r\n                <table class=\"my-vault text-center\">\r\n                    <tr>";
        } else {
            echo "\r\n        <div class=\"row\">\r\n            <div class=\"col-xs-12 text-center\">\r\n                <table class=\"my-vault text-center\">\r\n                    <tr>";
        }
        $il = __ITEM_LENGTH__;
        $wh_content = "";
        $user_items = $data;
        $check = "011111111";
        $xx = 0;
        $yy = 1;
        $line = 1;
        $onn = 0;
        $i = -1;
        while ($i < 119) {
            $i++;
            if ($xx == 8) {
                $xx = 1;
                $yy++;
            } else {
                $xx++;
            }
            $TT = substr($check, $xx, 1);
            if (round($i / 8) == $i / 8 && $i != 0) {
                $wh_content .= "</tr><tr>";
                $line++;
            }
            $l = $i;
            $item = $Items->ItemInfo(substr($user_items, $il * $i, $il), $_SESSION["username"], NULL, 1);
            if (!$item["Y"]) {
                $InsPosY = 1;
            } else {
                $InsPosY = $item["Y"];
            }
            if (!$item["X"]) {
                $InsPosX = 1;
            } else {
                $InsPosX = $item["X"];
                $xxx = $xx;
                $InsPosXX = $InsPosX;
                $InsPosYY = $InsPosY;
                while (0 < $InsPosXX) {
                    $check = substr_replace($check, $InsPosYY, $xxx, 1);
                    $InsPosXX = $InsPosXX - 1;
                    $InsPosYY = $InsPosY + 1;
                    $xxx++;
                }
            }
            $item["name"] = addslashes($item["name"]);
            if (1 < $TT) {
                $check = substr_replace($check, $TT - 1, $xx, 1);
            } else {
                unset($plusche);
                unset($rqs);
                unset($luck);
                unset($skill);
                unset($option);
                unset($exl);
                unset($ancsetopt);
                if ($item["name"]) {
                    $wh_content .= "\r\n                        <td class=\"wh-item\" colspan=\"" . $InsPosX . "\" rowspan=\"" . $InsPosY . "\" style=\"width:" . 32 * $InsPosX . "px;height:" . 32 * $InsPosY . "px;margin:0;padding:0;\">\r\n                            <a href=\"" . __BASE_URL__ . "usercp/vault/?item=" . Encode($item["sn2"] . $item["sn"]) . "\" onmouseover=\"Tip(" . $Items->generateItemTooltip($item, 1, 1, 1, 1, 0, 0) . ")\" onmouseout=\"UnTip()\" style=\"width:" . 24 * $InsPosX . "px;height:" . 24 * $InsPosY . "px;\"><img src=\"" . $item["thumb"] . "\" style=\"width:" . 24 * $InsPosX . "px;height:" . 24 * $InsPosY . "px;\" class=\"m\"></a>\r\n                        </td>";
                } else {
                    $wh_content .= "<td class='wh-item-empty' colspan='1' rowspan='1' style='width:32px;height:32px;margin:0;padding:0;'></td>";
                }
            }
        }
        echo $wh_content;
        echo "\r\n                    </tr>\r\n                </table>\r\n            </div>";
        if ($isExpanded) {
            echo "\r\n            <div class=\"col-xs-12 col-md-6 text-left\">\r\n                <table class=\"my-vault-ext text-center\">\r\n                    <tr>";
            $il = __ITEM_LENGTH__;
            $wh_content = "";
            $user_items = substr($data, 7680, 7680);
            $check = "011111111";
            $xx = 0;
            $yy = 1;
            $line = 1;
            $onn = 0;
            $i = -1;
            while ($i < 119) {
                $i++;
                if ($xx == 8) {
                    $xx = 1;
                    $yy++;
                } else {
                    $xx++;
                }
                $TT = substr($check, $xx, 1);
                if (round($i / 8) == $i / 8 && $i != 0) {
                    $wh_content .= "</tr><tr>";
                    $line++;
                }
                $l = $i;
                $item = $Items->ItemInfo(substr($user_items, $il * $i, $il), $_SESSION["username"], NULL, 1);
                if (!$item["Y"]) {
                    $InsPosY = 1;
                } else {
                    $InsPosY = $item["Y"];
                }
                if (!$item["X"]) {
                    $InsPosX = 1;
                } else {
                    $InsPosX = $item["X"];
                    $xxx = $xx;
                    $InsPosXX = $InsPosX;
                    $InsPosYY = $InsPosY;
                    while (0 < $InsPosXX) {
                        $check = substr_replace($check, $InsPosYY, $xxx, 1);
                        $InsPosXX = $InsPosXX - 1;
                        $InsPosYY = $InsPosY + 1;
                        $xxx++;
                    }
                }
                $item["name"] = addslashes($item["name"]);
                if (1 < $TT) {
                    $check = substr_replace($check, $TT - 1, $xx, 1);
                } else {
                    unset($plusche);
                    unset($rqs);
                    unset($luck);
                    unset($skill);
                    unset($option);
                    unset($exl);
                    unset($ancsetopt);
                    if ($item["name"]) {
                        $wh_content .= "\r\n                        <td class=\"wh-item\" colspan=\"" . $InsPosX . "\" rowspan=\"" . $InsPosY . "\" style=\"width:" . 32 * $InsPosX . "px;height:" . 32 * $InsPosY . "px;margin:0;padding:0;\">\r\n                            <a href=\"" . __BASE_URL__ . "usercp/vault/?item=" . Encode($item["sn2"] . $item["sn"]) . "\" onmouseover=\"Tip(" . $Items->generateItemTooltip($item, 1, 1, 1, 1, 0, 0) . ")\" onmouseout=\"UnTip()\" style=\"width:" . 24 * $InsPosX . "px;height:" . 24 * $InsPosY . "px;\"><img src=\"" . $item["thumb"] . "\" style=\"width:" . 24 * $InsPosX . "px;height:" . 24 * $InsPosY . "px;\" class=\"m\"></a>\r\n                        </td>";
                    } else {
                        $wh_content .= "<td class='wh-item-empty' colspan='1' rowspan='1' style='width:32px;height:32px;margin:0;padding:0;'></td>";
                    }
                }
            }
            echo $wh_content;
            echo "        \r\n                    </tr>\r\n                </table>\r\n            </div>";
        }
        echo "\r\n        </div>";
    }
    public function sellItem($username, $serial, $price, $price_type)
    {
        global $dB;
        global $dB2;
        global $common;
        if (mconfig("is_sell")) {
            $Items = new Items();
            $price_type = Decode($price_type);
            $price_type = xss_clean($price_type);
            if (!check_value($username)) {
                message("error", lang("error_4", true));
                return NULL;
            }
            if (!check_value($price)) {
                message("error", lang("error_4", true));
                return NULL;
            }
            if (!check_value($price_type)) {
                message("error", lang("error_4", true));
                return NULL;
            }
            if (!Validator::UsernameLength($username)) {
                message("error", lang("error_5", true));
                return NULL;
            }
            if (!Validator::AlphaNumeric($username)) {
                message("error", lang("error_6", true));
                return NULL;
            }
            if (!Validator::UnsignedNumber($price)) {
                message("error", lang("error_25", true));
                return NULL;
            }
            if (!Validator::AlphaNumeric($price_type)) {
                message("error", lang("error_6", true));
                return NULL;
            }
            $limit = mconfig("limit");
            $actualitemsonmarket = $dB->query_fetch_single("SELECT count(*) AS count FROM IMPERIAMUCMS_MARKET WHERE is_sold = '0' AND seller = ?", [$username]);
            $itemcount = $actualitemsonmarket["count"];
            $itemremaining = $limit - $itemcount;
            if ($common->accountOnline($username)) {
                message("error", lang("market_txt_102", true));
                $error = 1;
            }
            if ($itemremaining <= 0) {
                message("error", lang("market_txt_103", true));
                $error = 1;
            }
            if (strlen($serial) != 16 || $serial == "0000000000000000") {
                message("error", lang("market_txt_104", true));
                $error = 1;
            }
            if (!is_numeric($price) || $price <= 0) {
                message("error", lang("market_txt_105", true));
                $error = 1;
            }
            loadModuleConfigs("usercp.market");
            $marketTax = mconfig("tax");
            $return = [];
            mconfig("tax_type");
            switch (mconfig("tax_type")) {
                case 1:
                    $return["column"] = "platinum";
                    $return["table"] = "MEMB_CREDITS";
                    $return["ident"] = "memb___id";
                    $return["name"] = lang("currency_platinum", true);
                    break;
                case 2:
                    $return["column"] = "gold";
                    $return["table"] = "MEMB_CREDITS";
                    $return["ident"] = "memb___id";
                    $return["name"] = lang("currency_gold", true);
                    break;
                case 3:
                    $return["column"] = "silver";
                    $return["table"] = "MEMB_CREDITS";
                    $return["ident"] = "memb___id";
                    $return["name"] = lang("currency_silver", true);
                    break;
                case 4:
                    if (100 <= config("server_files_season", true)) {
                        $return["column"] = "WCoin";
                    } else {
                        $return["column"] = "WCoinC";
                    }
                    $return["table"] = "T_InGameShop_Point";
                    $return["ident"] = "AccountID";
                    $return["name"] = lang("currency_wcoinc", true);
                    break;
                case 5:
                    $return["column"] = "GoblinPoint";
                    $return["table"] = "T_InGameShop_Point";
                    $return["ident"] = "AccountID";
                    $return["name"] = lang("currency_gp", true);
                    break;
                case 6:
                    $return["column"] = "zen";
                    $return["table"] = "IMPERIAMUCMS_WEB_BANK";
                    $return["ident"] = "AccountID";
                    $return["name"] = "" . lang("currency_zen", true) . "";
                    break;
                default:
                    if (config("MEMB_CREDITS_MEMUONLINE", true) && ($return["column"] == "platinum" || $return["column"] == "gold" || $return["column"] == "silver")) {
                        $checkCurrency = $dB2->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$username]);
                    } else {
                        $checkCurrency = $dB->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$username]);
                    }
                    if ($checkCurrency[$return["column"]] < mconfig("tax")) {
                        message("error", sprintf(lang("market_txt_118", true), $return["name"]));
                        $error = 1;
                    }
                    loadModuleConfigs("usercp.vault");
                    $sqll = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT Items FROM warehouse WHERE AccountID = ?), 2) AS vault", [$username]);
                    $sqll = $sqll["vault"];
                    $stack = [25, 15];
                    $i = -1;
                    while ($i < 239) {
                        $i++;
                        $item = $Items->ItemInfo(substr($sqll, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__));
                        if (in_array($item["sn"], $stack, true) && $item["sn"] != "" && $item["sn"] != "0000000000000000") {
                            $i = 250;
                            $error = 1;
                            message("error", lang("market_txt_106", true));
                        } else {
                            array_push($stack, $item["sn"]);
                        }
                    }
                    switch ($price_type) {
                        case "zen":
                            break;
                        case "platinum":
                            if (mconfig("platinum") == 0) {
                                message("error", lang("market_txt_107", true));
                                $error = 1;
                            }
                            break;
                        case "gold":
                            if (mconfig("gold") == 0) {
                                message("error", lang("market_txt_107", true));
                                $error = 1;
                            }
                            break;
                        case "silver":
                            if (mconfig("silver") == 0) {
                                message("error", lang("market_txt_107", true));
                                $error = 1;
                            }
                            break;
                        case "WCoinC":
                            if (mconfig("WCoinC") == 0) {
                                message("error", lang("market_txt_107", true));
                                $error = 1;
                            }
                            break;
                        case "GoblinPoint":
                            if (mconfig("GoblinPoint") == 0) {
                                message("error", lang("market_txt_107", true));
                                $error = 1;
                            }
                            break;
                        case "bless":
                            if (mconfig("bless") == 0) {
                                message("error", lang("market_txt_107", true));
                                $error = 1;
                            }
                            break;
                        case "soul":
                            if (mconfig("soul") == 0) {
                                message("error", lang("market_txt_107", true));
                                $error = 1;
                            }
                            break;
                        case "life":
                            if (mconfig("life") == 0) {
                                message("error", lang("market_txt_107", true));
                                $error = 1;
                            }
                            break;
                        case "chaos":
                            if (mconfig("chaos") == 0) {
                                message("error", lang("market_txt_107", true));
                                $error = 1;
                            }
                            break;
                        case "harmony":
                            if (mconfig("harmony") == 0) {
                                message("error", lang("market_txt_107", true));
                                $error = 1;
                            }
                            break;
                        case "creation":
                            if (mconfig("creation") == 0) {
                                message("error", lang("market_txt_107", true));
                                $error = 1;
                            }
                            break;
                        case "guardian":
                            if (mconfig("guardian") == 0) {
                                message("error", lang("market_txt_107", true));
                                $error = 1;
                            }
                            break;
                        default:
                            $i = -1;
                            while ($i < 239) {
                                $i++;
                                $item = $Items->ItemInfo(substr($sqll, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__));
                                if ($item["sn2"] . $item["sn"] == $serial) {
                                    $item_code = substr($sqll, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                                    $i = 250;
                                }
                            }
                            unset($i);
                            if ($item_code) {
                                $canSell = $dB->query_fetch_single("SELECT sell FROM IMPERIAMUCMS_ITEMS WHERE type = ? AND id = ? AND level = ?", [$item["type"], $item["id"], $item["sticklevel"]]);
                                if ($canSell["sell"] == "1") {
                                    $it = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT Items FROM warehouse WHERE AccountID = ?), 2) AS vault", [$username]);
                                    $it = $it["vault"];
                                    $it1 = $item_code;
                                    $it3 = 0;
                                    while ($it3 < 241) {
                                        $it2 = substr($it, __ITEM_LENGTH__ * $it3, __ITEM_LENGTH__);
                                        if ($it1 != $it2) {
                                            $it3++;
                                        }
                                    }
                                    $ci = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT Items FROM warehouse WHERE AccountID = ?), 2) AS vault", [$username]);
                                    $ci = "0x" . $ci["vault"];
                                    if ($error != 1) {
                                        if ($item["type"] == 12 && (200 <= $item["id"] && $item["id"] <= 218 || 306 <= $item["id"] && $item["id"] <= 308)) {
                                            if ($item["dur"] < 1) {
                                                $canAddItem = false;
                                            } else {
                                                $canAddItem = true;
                                            }
                                        } else {
                                            $canAddItem = true;
                                        }
                                        if ($canAddItem) {
                                            $date = date("Y-m-d H:i:s", time());
                                            $newVault = substr_replace($ci, __ITEM_EMPTY__, $it3 * __ITEM_LENGTH__ + 2, __ITEM_LENGTH__);
                                            $insert = $dB->query("INSERT INTO IMPERIAMUCMS_MARKET ([cat_id],[item_id],[sticklevel],[item],[price],[price_type],[seller],[start_date],[is_sold])\r\n                              VALUES(?,?,?,?,?,?,?,?,'0')", [$item["type"], $item["id"], $item["sticklevel"], $item_code, $price, $price_type, $username, $date]);
                                            if ($insert) {
                                                $update = $dB->query("update [warehouse] set [Items]=" . $newVault . " where [AccountID]='" . $username . "' and [Items]=" . $ci);
                                                $update2 = $dB->query("UPDATE " . $return["table"] . " SET " . $return["column"] . " = " . $return["column"] . " - ?  WHERE " . $return["ident"] . " = ?", [$marketTax, $username]);
                                                message("success", lang("market_txt_108", true));
                                                $logDate = date("Y-m-d H:i:s", time());
                                                $common->accountLogs($username, "market", sprintf(lang("market_txt_109", true), $item_code), $logDate);
                                            } else {
                                                message("error", lang("error_23", true));
                                            }
                                        } else {
                                            message("error", lang("market_txt_201", true));
                                        }
                                    }
                                } else {
                                    message("error", lang("market_txt_197", true));
                                }
                            }
                    }
            }
        }
    }
    public function deleteItem($username, $serial)
    {
        global $dB;
        global $common;
        if (mconfig("is_delete")) {
            $Items = new Items();
            if (!check_value($username)) {
                message("error", lang("error_4", true));
                return NULL;
            }
            if (!Validator::UsernameLength($username)) {
                message("error", lang("error_5", true));
                return NULL;
            }
            if (!Validator::AlphaNumeric($username)) {
                message("error", lang("error_6", true));
                return NULL;
            }
            if ($common->accountOnline($username)) {
                message("error", lang("market_txt_102", true));
                $error = 1;
            }
            $sqll = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT Items FROM warehouse WHERE AccountID = ?), 2) AS vault", [$username]);
            $sqll = $sqll["vault"];
            $stack = [25, 15];
            $i = -1;
            while ($i < 239) {
                $i++;
                $item = $Items->ItemInfo(substr($sqll, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__));
                if (in_array($item["sn"], $stack, true) && $item["sn"] != "" && $item["sn"] != "0000000000000000") {
                    $i = 250;
                    $error = 1;
                    message("error", lang("market_txt_106", true));
                } else {
                    array_push($stack, $item["sn"]);
                }
            }
            $i = -1;
            while ($i < 239) {
                $i++;
                $item = $Items->ItemInfo(substr($sqll, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__));
                if ($item["sn2"] . $item["sn"] == $serial) {
                    $item_code = substr($sqll, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                    $i = 250;
                }
            }
            unset($i);
            if ($item_code) {
                $it = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT Items FROM warehouse WHERE AccountID = ?), 2) AS vault", [$username]);
                $it = $it["vault"];
                $it1 = $item_code;
                $it3 = 0;
                while ($it3 < 241) {
                    $it2 = substr($it, __ITEM_LENGTH__ * $it3, __ITEM_LENGTH__);
                    if ($it1 != $it2) {
                        $it3++;
                    }
                }
                $ci = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT Items FROM warehouse WHERE AccountID = ?), 2) AS vault", [$username]);
                $ci = "0x" . $ci["vault"];
                if ($error != 1) {
                    $date = date("Y-m-d H:i:s", time());
                    $newVault = substr_replace($ci, __ITEM_EMPTY__, $it3 * __ITEM_LENGTH__ + 2, __ITEM_LENGTH__);
                    $update = $dB->query("update [warehouse] set [Items]=" . $newVault . " where [AccountID]='" . $username . "' and [Items]=" . $ci);
                    message("success", lang("market_txt_110", true));
                    $logDate = date("Y-m-d H:i:s", time());
                    $common->accountLogs($username, "market", sprintf(lang("market_txt_111", true), $item_code), $logDate);
                }
            } else {
                message("error", lang("market_txt_112", true));
            }
        }
    }
    public function upgradeItem($username, $serial, $item_type, $item_id, $item_level, $operation)
    {
        global $dB;
        global $dB2;
        global $common;
        if (mconfig("is_upgrade")) {
            $Items = new Items();
            if (!check_value($username)) {
                message("error", lang("error_4", true));
                return NULL;
            }
            if (!Validator::UsernameLength($username)) {
                message("error", lang("error_5", true));
                return NULL;
            }
            if (!Validator::AlphaNumeric($username)) {
                message("error", lang("error_6", true));
                return NULL;
            }
            if ($common->accountOnline($username)) {
                message("error", lang("market_txt_102", true));
                $error = 1;
            }
            $sqll = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT Items FROM warehouse WHERE AccountID = ?), 2) AS vault", [$username]);
            $sqll = $sqll["vault"];
            $stack = [25, 15];
            $i = -1;
            while ($i < 239) {
                $i++;
                $item = $Items->ItemInfo(substr($sqll, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__));
                if (in_array($item["sn"], $stack, true) && $item["sn"] != "" && $item["sn"] != "0000000000000000") {
                    $i = 250;
                    $error = 1;
                    message("error", lang("market_txt_106", true));
                } else {
                    array_push($stack, $item["sn"]);
                }
            }
            $i = -1;
            while ($i < 239) {
                $i++;
                $item = $Items->ItemInfo(substr($sqll, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__));
                if ($item["sn2"] . $item["sn"] == $serial) {
                    $item_code = substr($sqll, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                    $i = 250;
                }
            }
            unset($i);
            if ($item_code) {
                $it = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT Items FROM warehouse WHERE AccountID = ?), 2) AS vault", [$username]);
                $it = $it["vault"];
                $it1 = $item_code;
                $it3 = 0;
                while ($it3 < 241) {
                    $it2 = substr($it, __ITEM_LENGTH__ * $it3, __ITEM_LENGTH__);
                    if ($it1 != $it2) {
                        $it3++;
                    }
                }
                $ci = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT Items FROM warehouse WHERE AccountID = ?), 2) AS vault", [$username]);
                $ci = "0x" . $ci["vault"];
                if ($error != 1) {
                    $itemData = $this->getItemInfo($item_type, $item_id, $item_level);
                    if (0 < $itemData["exc"]) {
                        $item = $Items->ItemInfo($item_code);
                        $itemType = $this->returnItemType($item_type, $item_id);
                        $itemTier = $itemData["class"] - 1;
                        $exc_non_exc = explode(",", mconfig("exc_non_exc_" . $itemType));
                        $exc_rand_opt = explode(",", mconfig("exc_rand_opt_" . $itemType));
                        $exc_max_opt = explode(",", mconfig("exc_max_opt_" . $itemType));
                        $exc_rand_price = explode(",", mconfig("exc_rand_price_" . $itemType));
                        $exc_price1 = explode(",", mconfig("exc_price1_" . $itemType));
                        $exc_price2 = explode(",", mconfig("exc_price2_" . $itemType));
                        $exc_price3 = explode(",", mconfig("exc_price3_" . $itemType));
                        $exc_price4 = explode(",", mconfig("exc_price4_" . $itemType));
                        $exc_price5 = explode(",", mconfig("exc_price5_" . $itemType));
                        $exc_price6 = explode(",", mconfig("exc_price6_" . $itemType));
                        $exc_price_type = explode(",", mconfig("exc_price_type_" . $itemType));
                        if ($itemType == "weapon") {
                            $skill_price = explode(",", mconfig("skill_price_" . $itemType));
                            $skill_price_type = explode(",", mconfig("skill_price_type_" . $itemType));
                        }
                        if ($itemType != "jewelry") {
                            $luck_price = explode(",", mconfig("luck_price_" . $itemType));
                            $luck_price_type = explode(",", mconfig("luck_price_type_" . $itemType));
                        }
                        if ($item["isanc"]) {
                            foreach ($exc_rand_price as $key => $value) {
                                $exc_rand_price[$key] = $exc_rand_price[$key] * mconfig("anc_price_rate");
                            }
                            foreach ($exc_price1 as $key => $value) {
                                $exc_price1[$key] = $exc_price1[$key] * mconfig("anc_price_rate");
                            }
                            foreach ($exc_price2 as $key => $value) {
                                $exc_price2[$key] = $exc_price2[$key] * mconfig("anc_price_rate");
                            }
                            foreach ($exc_price3 as $key => $value) {
                                $exc_price3[$key] = $exc_price3[$key] * mconfig("anc_price_rate");
                            }
                            foreach ($exc_price4 as $key => $value) {
                                $exc_price4[$key] = $exc_price4[$key] * mconfig("anc_price_rate");
                            }
                            foreach ($exc_price5 as $key => $value) {
                                $exc_price5[$key] = $exc_price5[$key] * mconfig("anc_price_rate");
                            }
                            foreach ($exc_price6 as $key => $value) {
                                $exc_price6[$key] = $exc_price6[$key] * mconfig("anc_price_rate");
                            }
                            foreach ($skill_price as $key => $value) {
                                $skill_price[$key] = $skill_price[$key] * mconfig("anc_price_rate");
                            }
                            foreach ($luck_price as $key => $value) {
                                $luck_price[$key] = $luck_price[$key] * mconfig("anc_price_rate");
                            }
                        }
                        if (0 < $itemData["exc"]) {
                            $exc_price_type = $this->upgradeItemPriceType($exc_price_type[$itemTier]);
                        }
                        if (0 < $itemData["skill"]) {
                            $skill_price_type = $this->upgradeItemPriceType($skill_price_type[$itemTier]);
                        }
                        if (0 < $itemData["luck"]) {
                            $luck_price_type = $this->upgradeItemPriceType($luck_price_type[$itemTier]);
                        }
                        switch ($operation) {
                            case "exc_rand_opt":
                                if (mconfig("enable_exc_" . $itemType)) {
                                    $max_exc_opts = 0;
                                    $current_exc_opts = 0;
                                    $freeExcOpt = [];
                                    if ($item["exc1_name"] != NULL && !empty($item["exc1_name"])) {
                                        $max_exc_opts++;
                                        if ($item["exc1"] == "0") {
                                            array_push($freeExcOpt, 1);
                                        }
                                    }
                                    if ($item["exc2_name"] != NULL && !empty($item["exc2_name"])) {
                                        $max_exc_opts++;
                                        if ($item["exc2"] == "0") {
                                            array_push($freeExcOpt, 2);
                                        }
                                    }
                                    if ($item["exc3_name"] != NULL && !empty($item["exc3_name"])) {
                                        $max_exc_opts++;
                                        if ($item["exc3"] == "0") {
                                            array_push($freeExcOpt, 4);
                                        }
                                    }
                                    if ($item["exc4_name"] != NULL && !empty($item["exc4_name"])) {
                                        $max_exc_opts++;
                                        if ($item["exc4"] == "0") {
                                            array_push($freeExcOpt, 8);
                                        }
                                    }
                                    if ($item["exc5_name"] != NULL && !empty($item["exc5_name"])) {
                                        $max_exc_opts++;
                                        if ($item["exc5"] == "0") {
                                            array_push($freeExcOpt, 16);
                                        }
                                    }
                                    if ($item["exc6_name"] != NULL && !empty($item["exc6_name"])) {
                                        $max_exc_opts++;
                                        if ($item["exc6"] == "0") {
                                            array_push($freeExcOpt, 32);
                                        }
                                    }
                                    if ($exc_max_opt[$itemTier] < $max_exc_opts) {
                                        $max_exc_opts = $exc_max_opt[$itemTier];
                                    }
                                    if ($item["exc1"]) {
                                        $current_exc_opts++;
                                    }
                                    if ($item["exc2"]) {
                                        $current_exc_opts++;
                                    }
                                    if ($item["exc3"]) {
                                        $current_exc_opts++;
                                    }
                                    if ($item["exc4"]) {
                                        $current_exc_opts++;
                                    }
                                    if ($item["exc5"]) {
                                        $current_exc_opts++;
                                    }
                                    if ($item["exc6"]) {
                                        $current_exc_opts++;
                                    }
                                    if ($current_exc_opts < $max_exc_opts) {
                                        if ($exc_rand_opt[$itemTier]) {
                                            if ($exc_non_exc[$itemTier] == "0" && $current_exc_opts == 0) {
                                                message("error", lang("market_txt_113", true));
                                            } else {
                                                if ($itemData["use_sockets"] && mconfig("enable_socket_exc") == "0") {
                                                    message("error", lang("market_txt_114", true));
                                                } else {
                                                    if ($item["isanc"] && mconfig("enable_anc_exc") == "0") {
                                                        message("error", lang("market_txt_115", true));
                                                    } else {
                                                        if (config("MEMB_CREDITS_MEMUONLINE", true) && ($exc_price_type["column"] == "platinum" || $exc_price_type["column"] == "gold" || $exc_price_type["column"] == "silver")) {
                                                            $check = $dB2->query_fetch_single("SELECT " . $exc_price_type["column"] . " FROM " . $exc_price_type["table"] . " WHERE " . $exc_price_type["ident"] . " = '" . $username . "'");
                                                        } else {
                                                            $check = $dB->query_fetch_single("SELECT " . $exc_price_type["column"] . " FROM " . $exc_price_type["table"] . " WHERE " . $exc_price_type["ident"] . " = '" . $username . "'");
                                                        }
                                                        if ($exc_rand_price[$itemTier] <= $check[$exc_price_type["column"]]) {
                                                            $excHex = hexdec(substr($item_code, 14, 2));
                                                            $rand = $freeExcOpt[array_rand($freeExcOpt)];
                                                            $excHex = $excHex + $rand;
                                                            $update = sprintf("%02s", dechex($excHex));
                                                            $item_code_new = substr_replace($item_code, $update, 14, 2);
                                                            if ($rand == "1") {
                                                                $exc_rand_opt_name = $item["exc1_name"];
                                                            }
                                                            if ($rand == "2") {
                                                                $exc_rand_opt_name = $item["exc2_name"];
                                                            }
                                                            if ($rand == "4") {
                                                                $exc_rand_opt_name = $item["exc3_name"];
                                                            }
                                                            if ($rand == "8") {
                                                                $exc_rand_opt_name = $item["exc4_name"];
                                                            }
                                                            if ($rand == "16") {
                                                                $exc_rand_opt_name = $item["exc5_name"];
                                                            }
                                                            if ($rand == "32") {
                                                                $exc_rand_opt_name = $item["exc6_name"];
                                                            }
                                                            $newVault = substr_replace($ci, $item_code_new, $it3 * __ITEM_LENGTH__ + 2, __ITEM_LENGTH__);
                                                            $update = $dB->query("UPDATE [warehouse] SET [Items] = " . $newVault . " WHERE [AccountID] = '" . $username . "' and [Items] = " . $ci);
                                                            if ($update) {
                                                                if (config("MEMB_CREDITS_MEMUONLINE", true) && ($exc_price_type["column"] == "platinum" || $exc_price_type["column"] == "gold" || $exc_price_type["column"] == "silver")) {
                                                                    $update2 = $dB2->query("UPDATE " . $exc_price_type["table"] . " SET " . $exc_price_type["column"] . " = " . $exc_price_type["column"] . " - " . $exc_rand_price[$itemTier] . " WHERE " . $exc_price_type["ident"] . " = '" . $username . "'");
                                                                } else {
                                                                    $update2 = $dB->query("UPDATE " . $exc_price_type["table"] . " SET " . $exc_price_type["column"] . " = " . $exc_price_type["column"] . " - " . $exc_rand_price[$itemTier] . " WHERE " . $exc_price_type["ident"] . " = '" . $username . "'");
                                                                }
                                                                if ($update2) {
                                                                    message("success", sprintf(lang("market_txt_116", true), $exc_rand_opt_name, $exc_rand_price[$itemTier], $exc_price_type["name"]));
                                                                    $logDate = date("Y-m-d H:i:s", time());
                                                                    $common->accountLogs($username, "vault", sprintf(lang("market_txt_117", true), $exc_rand_opt_name, $exc_rand_price[$itemTier], $exc_price_type["name"], $item_code), $logDate);
                                                                } else {
                                                                    message("error", lang("error_23", true));
                                                                }
                                                            } else {
                                                                message("error", lang("error_23", true));
                                                            }
                                                        } else {
                                                            message("error", sprintf(lang("market_txt_118", true), $exc_price_type["name"]));
                                                        }
                                                    }
                                                }
                                            }
                                        } else {
                                            message("error", lang("market_txt_119", true));
                                        }
                                    } else {
                                        message("error", lang("market_txt_120", true));
                                    }
                                } else {
                                    message("error", lang("market_txt_121", true));
                                }
                                break;
                            case "exc_opt_1":
                                if (mconfig("enable_exc_" . $itemType)) {
                                    $max_exc_opts = 0;
                                    $current_exc_opts = 0;
                                    if ($item["exc1_name"] != NULL && !empty($item["exc1_name"])) {
                                        $max_exc_opts++;
                                    }
                                    if ($item["exc2_name"] != NULL && !empty($item["exc2_name"])) {
                                        $max_exc_opts++;
                                    }
                                    if ($item["exc3_name"] != NULL && !empty($item["exc3_name"])) {
                                        $max_exc_opts++;
                                    }
                                    if ($item["exc4_name"] != NULL && !empty($item["exc4_name"])) {
                                        $max_exc_opts++;
                                    }
                                    if ($item["exc5_name"] != NULL && !empty($item["exc5_name"])) {
                                        $max_exc_opts++;
                                    }
                                    if ($item["exc6_name"] != NULL && !empty($item["exc6_name"])) {
                                        $max_exc_opts++;
                                    }
                                    if ($exc_max_opt[$itemTier] < $max_exc_opts) {
                                        $max_exc_opts = $exc_max_opt[$itemTier];
                                    }
                                    if ($item["exc1"]) {
                                        $current_exc_opts++;
                                    }
                                    if ($item["exc2"]) {
                                        $current_exc_opts++;
                                    }
                                    if ($item["exc3"]) {
                                        $current_exc_opts++;
                                    }
                                    if ($item["exc4"]) {
                                        $current_exc_opts++;
                                    }
                                    if ($item["exc5"]) {
                                        $current_exc_opts++;
                                    }
                                    if ($item["exc6"]) {
                                        $current_exc_opts++;
                                    }
                                    if ($current_exc_opts < $max_exc_opts) {
                                        if ($item["exc1_name"] != NULL && !empty($item["exc1_name"]) && $item["exc1"] == "0") {
                                            if ($exc_non_exc[$itemTier] == "0" && $current_exc_opts == 0) {
                                                message("error", lang("market_txt_113", true));
                                            } else {
                                                if ($itemData["use_sockets"] && mconfig("enable_socket_exc") == "0") {
                                                    message("error", lang("market_txt_114", true));
                                                } else {
                                                    if ($item["isanc"] && mconfig("enable_anc_exc") == "0") {
                                                        message("error", lang("market_txt_115", true));
                                                    } else {
                                                        if (config("MEMB_CREDITS_MEMUONLINE", true) && ($exc_price_type["column"] == "platinum" || $exc_price_type["column"] == "gold" || $exc_price_type["column"] == "silver")) {
                                                            $check = $dB2->query_fetch_single("SELECT " . $exc_price_type["column"] . " FROM " . $exc_price_type["table"] . " WHERE " . $exc_price_type["ident"] . " = '" . $username . "'");
                                                        } else {
                                                            $check = $dB->query_fetch_single("SELECT " . $exc_price_type["column"] . " FROM " . $exc_price_type["table"] . " WHERE " . $exc_price_type["ident"] . " = '" . $username . "'");
                                                        }
                                                        if ($exc_price1[$itemTier] <= $check[$exc_price_type["column"]]) {
                                                            $excHex = hexdec(substr($item_code, 14, 2));
                                                            $excHex = $excHex + 1;
                                                            $update = sprintf("%02s", dechex($excHex));
                                                            $item_code_new = substr_replace($item_code, $update, 14, 2);
                                                            $newVault = substr_replace($ci, $item_code_new, $it3 * __ITEM_LENGTH__ + 2, __ITEM_LENGTH__);
                                                            $update = $dB->query("UPDATE [warehouse] SET [Items] = " . $newVault . " WHERE [AccountID] = '" . $username . "' and [Items] = " . $ci);
                                                            if ($update) {
                                                                if (config("MEMB_CREDITS_MEMUONLINE", true) && ($exc_price_type["column"] == "platinum" || $exc_price_type["column"] == "gold" || $exc_price_type["column"] == "silver")) {
                                                                    $update2 = $dB2->query("UPDATE " . $exc_price_type["table"] . " SET " . $exc_price_type["column"] . " = " . $exc_price_type["column"] . " - " . $exc_price1[$itemTier] . " WHERE " . $exc_price_type["ident"] . " = '" . $username . "'");
                                                                } else {
                                                                    $update2 = $dB->query("UPDATE " . $exc_price_type["table"] . " SET " . $exc_price_type["column"] . " = " . $exc_price_type["column"] . " - " . $exc_price1[$itemTier] . " WHERE " . $exc_price_type["ident"] . " = '" . $username . "'");
                                                                }
                                                                if ($update2) {
                                                                    message("success", sprintf(lang("market_txt_122", true), $item["exc1_name"], $exc_price1[$itemTier], $exc_price_type["name"]));
                                                                    $logDate = date("Y-m-d H:i:s", time());
                                                                    $common->accountLogs($username, "vault", sprintf(lang("market_txt_123", true), $item["exc1_name"], $exc_price1[$itemTier], $exc_price_type["name"], $item_code), $logDate);
                                                                } else {
                                                                    message("error", lang("error_23", true));
                                                                }
                                                            } else {
                                                                message("error", lang("error_23", true));
                                                            }
                                                        } else {
                                                            message("error", sprintf(lang("market_txt_118", true), $exc_price_type["name"]));
                                                        }
                                                    }
                                                }
                                            }
                                        } else {
                                            message("error", lang("market_txt_124", true));
                                        }
                                    } else {
                                        message("error", lang("market_txt_120", true));
                                    }
                                } else {
                                    message("error", lang("market_txt_121", true));
                                }
                                break;
                            case "exc_opt_2":
                                if (mconfig("enable_exc_" . $itemType)) {
                                    $max_exc_opts = 0;
                                    $current_exc_opts = 0;
                                    if ($item["exc1_name"] != NULL && !empty($item["exc1_name"])) {
                                        $max_exc_opts++;
                                    }
                                    if ($item["exc2_name"] != NULL && !empty($item["exc2_name"])) {
                                        $max_exc_opts++;
                                    }
                                    if ($item["exc3_name"] != NULL && !empty($item["exc3_name"])) {
                                        $max_exc_opts++;
                                    }
                                    if ($item["exc4_name"] != NULL && !empty($item["exc4_name"])) {
                                        $max_exc_opts++;
                                    }
                                    if ($item["exc5_name"] != NULL && !empty($item["exc5_name"])) {
                                        $max_exc_opts++;
                                    }
                                    if ($item["exc6_name"] != NULL && !empty($item["exc6_name"])) {
                                        $max_exc_opts++;
                                    }
                                    if ($exc_max_opt[$itemTier] < $max_exc_opts) {
                                        $max_exc_opts = $exc_max_opt[$itemTier];
                                    }
                                    if ($item["exc1"]) {
                                        $current_exc_opts++;
                                    }
                                    if ($item["exc2"]) {
                                        $current_exc_opts++;
                                    }
                                    if ($item["exc3"]) {
                                        $current_exc_opts++;
                                    }
                                    if ($item["exc4"]) {
                                        $current_exc_opts++;
                                    }
                                    if ($item["exc5"]) {
                                        $current_exc_opts++;
                                    }
                                    if ($item["exc6"]) {
                                        $current_exc_opts++;
                                    }
                                    if ($current_exc_opts < $max_exc_opts) {
                                        if ($item["exc2_name"] != NULL && !empty($item["exc2_name"]) && $item["exc2"] == "0") {
                                            if ($exc_non_exc[$itemTier] == "0" && $current_exc_opts == 0) {
                                                message("error", lang("market_txt_113", true));
                                            } else {
                                                if ($itemData["use_sockets"] && mconfig("enable_socket_exc") == "0") {
                                                    message("error", lang("market_txt_114", true));
                                                } else {
                                                    if ($item["isanc"] && mconfig("enable_anc_exc") == "0") {
                                                        message("error", lang("market_txt_115", true));
                                                    } else {
                                                        if (config("MEMB_CREDITS_MEMUONLINE", true) && ($exc_price_type["column"] == "platinum" || $exc_price_type["column"] == "gold" || $exc_price_type["column"] == "silver")) {
                                                            $check = $dB2->query_fetch_single("SELECT " . $exc_price_type["column"] . " FROM " . $exc_price_type["table"] . " WHERE " . $exc_price_type["ident"] . " = '" . $username . "'");
                                                        } else {
                                                            $check = $dB->query_fetch_single("SELECT " . $exc_price_type["column"] . " FROM " . $exc_price_type["table"] . " WHERE " . $exc_price_type["ident"] . " = '" . $username . "'");
                                                        }
                                                        if ($exc_price2[$itemTier] <= $check[$exc_price_type["column"]]) {
                                                            $excHex = hexdec(substr($item_code, 14, 2));
                                                            $excHex = $excHex + 2;
                                                            $update = sprintf("%02s", dechex($excHex));
                                                            $item_code_new = substr_replace($item_code, $update, 14, 2);
                                                            $newVault = substr_replace($ci, $item_code_new, $it3 * __ITEM_LENGTH__ + 2, __ITEM_LENGTH__);
                                                            $update = $dB->query("UPDATE [warehouse] SET [Items] = " . $newVault . " WHERE [AccountID] = '" . $username . "' and [Items] = " . $ci);
                                                            if ($update) {
                                                                if (config("MEMB_CREDITS_MEMUONLINE", true) && ($exc_price_type["column"] == "platinum" || $exc_price_type["column"] == "gold" || $exc_price_type["column"] == "silver")) {
                                                                    $update2 = $dB2->query("UPDATE " . $exc_price_type["table"] . " SET " . $exc_price_type["column"] . " = " . $exc_price_type["column"] . " - " . $exc_price2[$itemTier] . " WHERE " . $exc_price_type["ident"] . " = '" . $username . "'");
                                                                } else {
                                                                    $update2 = $dB->query("UPDATE " . $exc_price_type["table"] . " SET " . $exc_price_type["column"] . " = " . $exc_price_type["column"] . " - " . $exc_price2[$itemTier] . " WHERE " . $exc_price_type["ident"] . " = '" . $username . "'");
                                                                }
                                                                if ($update2) {
                                                                    message("success", sprintf(lang("market_txt_122", true), $item["exc2_name"], $exc_price2[$itemTier], $exc_price_type["name"]));
                                                                    $logDate = date("Y-m-d H:i:s", time());
                                                                    $common->accountLogs($username, "vault", sprintf(lang("market_txt_123", true), $item["exc2_name"], $exc_price2[$itemTier], $exc_price_type["name"], $item_code), $logDate);
                                                                } else {
                                                                    message("error", lang("error_23", true));
                                                                }
                                                            } else {
                                                                message("error", lang("error_23", true));
                                                            }
                                                        } else {
                                                            message("error", sprintf(lang("market_txt_118", true), $exc_price_type["name"]));
                                                        }
                                                    }
                                                }
                                            }
                                        } else {
                                            message("error", lang("market_txt_124", true));
                                        }
                                    } else {
                                        message("error", lang("market_txt_120", true));
                                    }
                                } else {
                                    message("error", lang("market_txt_121", true));
                                }
                                break;
                            case "exc_opt_3":
                                if (mconfig("enable_exc_" . $itemType)) {
                                    $max_exc_opts = 0;
                                    $current_exc_opts = 0;
                                    if ($item["exc1_name"] != NULL && !empty($item["exc1_name"])) {
                                        $max_exc_opts++;
                                    }
                                    if ($item["exc2_name"] != NULL && !empty($item["exc2_name"])) {
                                        $max_exc_opts++;
                                    }
                                    if ($item["exc3_name"] != NULL && !empty($item["exc3_name"])) {
                                        $max_exc_opts++;
                                    }
                                    if ($item["exc4_name"] != NULL && !empty($item["exc4_name"])) {
                                        $max_exc_opts++;
                                    }
                                    if ($item["exc5_name"] != NULL && !empty($item["exc5_name"])) {
                                        $max_exc_opts++;
                                    }
                                    if ($item["exc6_name"] != NULL && !empty($item["exc6_name"])) {
                                        $max_exc_opts++;
                                    }
                                    if ($exc_max_opt[$itemTier] < $max_exc_opts) {
                                        $max_exc_opts = $exc_max_opt[$itemTier];
                                    }
                                    if ($item["exc1"]) {
                                        $current_exc_opts++;
                                    }
                                    if ($item["exc2"]) {
                                        $current_exc_opts++;
                                    }
                                    if ($item["exc3"]) {
                                        $current_exc_opts++;
                                    }
                                    if ($item["exc4"]) {
                                        $current_exc_opts++;
                                    }
                                    if ($item["exc5"]) {
                                        $current_exc_opts++;
                                    }
                                    if ($item["exc6"]) {
                                        $current_exc_opts++;
                                    }
                                    if ($current_exc_opts < $max_exc_opts) {
                                        if ($item["exc3_name"] != NULL && !empty($item["exc3_name"]) && $item["exc3"] == "0") {
                                            if ($exc_non_exc[$itemTier] == "0" && $current_exc_opts == 0) {
                                                message("error", lang("market_txt_113", true));
                                            } else {
                                                if ($itemData["use_sockets"] && mconfig("enable_socket_exc") == "0") {
                                                    message("error", lang("market_txt_114", true));
                                                } else {
                                                    if ($item["isanc"] && mconfig("enable_anc_exc") == "0") {
                                                        message("error", lang("market_txt_115", true));
                                                    } else {
                                                        if (config("MEMB_CREDITS_MEMUONLINE", true) && ($exc_price_type["column"] == "platinum" || $exc_price_type["column"] == "gold" || $exc_price_type["column"] == "silver")) {
                                                            $check = $dB2->query_fetch_single("SELECT " . $exc_price_type["column"] . " FROM " . $exc_price_type["table"] . " WHERE " . $exc_price_type["ident"] . " = '" . $username . "'");
                                                        } else {
                                                            $check = $dB->query_fetch_single("SELECT " . $exc_price_type["column"] . " FROM " . $exc_price_type["table"] . " WHERE " . $exc_price_type["ident"] . " = '" . $username . "'");
                                                        }
                                                        if ($exc_price3[$itemTier] <= $check[$exc_price_type["column"]]) {
                                                            $excHex = hexdec(substr($item_code, 14, 2));
                                                            $excHex = $excHex + 4;
                                                            $update = sprintf("%02s", dechex($excHex));
                                                            $item_code_new = substr_replace($item_code, $update, 14, 2);
                                                            $newVault = substr_replace($ci, $item_code_new, $it3 * __ITEM_LENGTH__ + 2, __ITEM_LENGTH__);
                                                            $update = $dB->query("UPDATE [warehouse] SET [Items] = " . $newVault . " WHERE [AccountID] = '" . $username . "' and [Items] = " . $ci);
                                                            if ($update) {
                                                                if (config("MEMB_CREDITS_MEMUONLINE", true) && ($exc_price_type["column"] == "platinum" || $exc_price_type["column"] == "gold" || $exc_price_type["column"] == "silver")) {
                                                                    $update2 = $dB2->query("UPDATE " . $exc_price_type["table"] . " SET " . $exc_price_type["column"] . " = " . $exc_price_type["column"] . " - " . $exc_price3[$itemTier] . " WHERE " . $exc_price_type["ident"] . " = '" . $username . "'");
                                                                } else {
                                                                    $update2 = $dB->query("UPDATE " . $exc_price_type["table"] . " SET " . $exc_price_type["column"] . " = " . $exc_price_type["column"] . " - " . $exc_price3[$itemTier] . " WHERE " . $exc_price_type["ident"] . " = '" . $username . "'");
                                                                }
                                                                if ($update2) {
                                                                    message("success", sprintf(lang("market_txt_122", true), $item["exc3_name"], $exc_price3[$itemTier], $exc_price_type["name"]));
                                                                    $logDate = date("Y-m-d H:i:s", time());
                                                                    $common->accountLogs($username, "vault", sprintf(lang("market_txt_123", true), $item["exc3_name"], $exc_price3[$itemTier], $exc_price_type["name"], $item_code), $logDate);
                                                                } else {
                                                                    message("error", lang("error_23", true));
                                                                }
                                                            } else {
                                                                message("error", lang("error_23", true));
                                                            }
                                                        } else {
                                                            message("error", sprintf(lang("market_txt_118", true), $exc_price_type["name"]));
                                                        }
                                                    }
                                                }
                                            }
                                        } else {
                                            message("error", lang("market_txt_124", true));
                                        }
                                    } else {
                                        message("error", lang("market_txt_120", true));
                                    }
                                } else {
                                    message("error", lang("market_txt_121", true));
                                }
                                break;
                            case "exc_opt_4":
                                if (mconfig("enable_exc_" . $itemType)) {
                                    $max_exc_opts = 0;
                                    $current_exc_opts = 0;
                                    if ($item["exc1_name"] != NULL && !empty($item["exc1_name"])) {
                                        $max_exc_opts++;
                                    }
                                    if ($item["exc2_name"] != NULL && !empty($item["exc2_name"])) {
                                        $max_exc_opts++;
                                    }
                                    if ($item["exc3_name"] != NULL && !empty($item["exc3_name"])) {
                                        $max_exc_opts++;
                                    }
                                    if ($item["exc4_name"] != NULL && !empty($item["exc4_name"])) {
                                        $max_exc_opts++;
                                    }
                                    if ($item["exc5_name"] != NULL && !empty($item["exc5_name"])) {
                                        $max_exc_opts++;
                                    }
                                    if ($item["exc6_name"] != NULL && !empty($item["exc6_name"])) {
                                        $max_exc_opts++;
                                    }
                                    if ($exc_max_opt[$itemTier] < $max_exc_opts) {
                                        $max_exc_opts = $exc_max_opt[$itemTier];
                                    }
                                    if ($item["exc1"]) {
                                        $current_exc_opts++;
                                    }
                                    if ($item["exc2"]) {
                                        $current_exc_opts++;
                                    }
                                    if ($item["exc3"]) {
                                        $current_exc_opts++;
                                    }
                                    if ($item["exc4"]) {
                                        $current_exc_opts++;
                                    }
                                    if ($item["exc5"]) {
                                        $current_exc_opts++;
                                    }
                                    if ($item["exc6"]) {
                                        $current_exc_opts++;
                                    }
                                    if ($current_exc_opts < $max_exc_opts) {
                                        if ($item["exc4_name"] != NULL && !empty($item["exc4_name"]) && $item["exc4"] == "0") {
                                            if ($exc_non_exc[$itemTier] == "0" && $current_exc_opts == 0) {
                                                message("error", lang("market_txt_113", true));
                                            } else {
                                                if ($itemData["use_sockets"] && mconfig("enable_socket_exc") == "0") {
                                                    message("error", lang("market_txt_114", true));
                                                } else {
                                                    if ($item["isanc"] && mconfig("enable_anc_exc") == "0") {
                                                        message("error", lang("market_txt_115", true));
                                                    } else {
                                                        if (config("MEMB_CREDITS_MEMUONLINE", true) && ($exc_price_type["column"] == "platinum" || $exc_price_type["column"] == "gold" || $exc_price_type["column"] == "silver")) {
                                                            $check = $dB2->query_fetch_single("SELECT " . $exc_price_type["column"] . " FROM " . $exc_price_type["table"] . " WHERE " . $exc_price_type["ident"] . " = '" . $username . "'");
                                                        } else {
                                                            $check = $dB->query_fetch_single("SELECT " . $exc_price_type["column"] . " FROM " . $exc_price_type["table"] . " WHERE " . $exc_price_type["ident"] . " = '" . $username . "'");
                                                        }
                                                        if ($exc_price4[$itemTier] <= $check[$exc_price_type["column"]]) {
                                                            $excHex = hexdec(substr($item_code, 14, 2));
                                                            $excHex = $excHex + 8;
                                                            $update = sprintf("%02s", dechex($excHex));
                                                            $item_code_new = substr_replace($item_code, $update, 14, 2);
                                                            $newVault = substr_replace($ci, $item_code_new, $it3 * __ITEM_LENGTH__ + 2, __ITEM_LENGTH__);
                                                            $update = $dB->query("UPDATE [warehouse] SET [Items] = " . $newVault . " WHERE [AccountID] = '" . $username . "' and [Items] = " . $ci);
                                                            if ($update) {
                                                                if (config("MEMB_CREDITS_MEMUONLINE", true) && ($exc_price_type["column"] == "platinum" || $exc_price_type["column"] == "gold" || $exc_price_type["column"] == "silver")) {
                                                                    $update2 = $dB2->query("UPDATE " . $exc_price_type["table"] . " SET " . $exc_price_type["column"] . " = " . $exc_price_type["column"] . " - " . $exc_price4[$itemTier] . " WHERE " . $exc_price_type["ident"] . " = '" . $username . "'");
                                                                } else {
                                                                    $update2 = $dB->query("UPDATE " . $exc_price_type["table"] . " SET " . $exc_price_type["column"] . " = " . $exc_price_type["column"] . " - " . $exc_price4[$itemTier] . " WHERE " . $exc_price_type["ident"] . " = '" . $username . "'");
                                                                }
                                                                if ($update2) {
                                                                    message("success", sprintf(lang("market_txt_122", true), $item["exc4_name"], $exc_price4[$itemTier], $exc_price_type["name"]));
                                                                    $logDate = date("Y-m-d H:i:s", time());
                                                                    $common->accountLogs($username, "vault", sprintf(lang("market_txt_123", true), $item["exc4_name"], $exc_price4[$itemTier], $exc_price_type["name"], $item_code), $logDate);
                                                                } else {
                                                                    message("error", lang("error_23", true));
                                                                }
                                                            } else {
                                                                message("error", lang("error_23", true));
                                                            }
                                                        } else {
                                                            message("error", sprintf(lang("market_txt_118", true), $exc_price_type["name"]));
                                                        }
                                                    }
                                                }
                                            }
                                        } else {
                                            message("error", lang("market_txt_124", true));
                                        }
                                    } else {
                                        message("error", lang("market_txt_120", true));
                                    }
                                } else {
                                    message("error", lang("market_txt_121", true));
                                }
                                break;
                            case "exc_opt_5":
                                if (mconfig("enable_exc_" . $itemType)) {
                                    $max_exc_opts = 0;
                                    $current_exc_opts = 0;
                                    if ($item["exc1_name"] != NULL && !empty($item["exc1_name"])) {
                                        $max_exc_opts++;
                                    }
                                    if ($item["exc2_name"] != NULL && !empty($item["exc2_name"])) {
                                        $max_exc_opts++;
                                    }
                                    if ($item["exc3_name"] != NULL && !empty($item["exc3_name"])) {
                                        $max_exc_opts++;
                                    }
                                    if ($item["exc4_name"] != NULL && !empty($item["exc4_name"])) {
                                        $max_exc_opts++;
                                    }
                                    if ($item["exc5_name"] != NULL && !empty($item["exc5_name"])) {
                                        $max_exc_opts++;
                                    }
                                    if ($item["exc6_name"] != NULL && !empty($item["exc6_name"])) {
                                        $max_exc_opts++;
                                    }
                                    if ($exc_max_opt[$itemTier] < $max_exc_opts) {
                                        $max_exc_opts = $exc_max_opt[$itemTier];
                                    }
                                    if ($item["exc1"]) {
                                        $current_exc_opts++;
                                    }
                                    if ($item["exc2"]) {
                                        $current_exc_opts++;
                                    }
                                    if ($item["exc3"]) {
                                        $current_exc_opts++;
                                    }
                                    if ($item["exc4"]) {
                                        $current_exc_opts++;
                                    }
                                    if ($item["exc5"]) {
                                        $current_exc_opts++;
                                    }
                                    if ($item["exc6"]) {
                                        $current_exc_opts++;
                                    }
                                    if ($current_exc_opts < $max_exc_opts) {
                                        if ($item["exc5_name"] != NULL && !empty($item["exc5_name"]) && $item["exc5"] == "0") {
                                            if ($exc_non_exc[$itemTier] == "0" && $current_exc_opts == 0) {
                                                message("error", lang("market_txt_113", true));
                                            } else {
                                                if ($itemData["use_sockets"] && mconfig("enable_socket_exc") == "0") {
                                                    message("error", lang("market_txt_114", true));
                                                } else {
                                                    if ($item["isanc"] && mconfig("enable_anc_exc") == "0") {
                                                        message("error", lang("market_txt_115", true));
                                                    } else {
                                                        if (config("MEMB_CREDITS_MEMUONLINE", true) && ($exc_price_type["column"] == "platinum" || $exc_price_type["column"] == "gold" || $exc_price_type["column"] == "silver")) {
                                                            $check = $dB2->query_fetch_single("SELECT " . $exc_price_type["column"] . " FROM " . $exc_price_type["table"] . " WHERE " . $exc_price_type["ident"] . " = '" . $username . "'");
                                                        } else {
                                                            $check = $dB->query_fetch_single("SELECT " . $exc_price_type["column"] . " FROM " . $exc_price_type["table"] . " WHERE " . $exc_price_type["ident"] . " = '" . $username . "'");
                                                        }
                                                        if ($exc_price5[$itemTier] <= $check[$exc_price_type["column"]]) {
                                                            $excHex = hexdec(substr($item_code, 14, 2));
                                                            $excHex = $excHex + 16;
                                                            $update = sprintf("%02s", dechex($excHex));
                                                            $item_code_new = substr_replace($item_code, $update, 14, 2);
                                                            $newVault = substr_replace($ci, $item_code_new, $it3 * __ITEM_LENGTH__ + 2, __ITEM_LENGTH__);
                                                            $update = $dB->query("UPDATE [warehouse] SET [Items] = " . $newVault . " WHERE [AccountID] = '" . $username . "' and [Items] = " . $ci);
                                                            if ($update) {
                                                                if (config("MEMB_CREDITS_MEMUONLINE", true) && ($exc_price_type["column"] == "platinum" || $exc_price_type["column"] == "gold" || $exc_price_type["column"] == "silver")) {
                                                                    $update2 = $dB2->query("UPDATE " . $exc_price_type["table"] . " SET " . $exc_price_type["column"] . " = " . $exc_price_type["column"] . " - " . $exc_price5[$itemTier] . " WHERE " . $exc_price_type["ident"] . " = '" . $username . "'");
                                                                } else {
                                                                    $update2 = $dB->query("UPDATE " . $exc_price_type["table"] . " SET " . $exc_price_type["column"] . " = " . $exc_price_type["column"] . " - " . $exc_price5[$itemTier] . " WHERE " . $exc_price_type["ident"] . " = '" . $username . "'");
                                                                }
                                                                if ($update2) {
                                                                    message("success", sprintf(lang("market_txt_122", true), $item["exc5_name"], $exc_price5[$itemTier], $exc_price_type["name"]));
                                                                    $logDate = date("Y-m-d H:i:s", time());
                                                                    $common->accountLogs($username, "vault", sprintf(lang("market_txt_123", true), $item["exc5_name"], $exc_price5[$itemTier], $exc_price_type["name"], $item_code), $logDate);
                                                                } else {
                                                                    message("error", lang("error_23", true));
                                                                }
                                                            } else {
                                                                message("error", lang("error_23", true));
                                                            }
                                                        } else {
                                                            message("error", sprintf(lang("market_txt_118", true), $exc_price_type["name"]));
                                                        }
                                                    }
                                                }
                                            }
                                        } else {
                                            message("error", lang("market_txt_124", true));
                                        }
                                    } else {
                                        message("error", lang("market_txt_120", true));
                                    }
                                } else {
                                    message("error", lang("market_txt_121", true));
                                }
                                break;
                            case "exc_opt_6":
                                if (mconfig("enable_exc_" . $itemType)) {
                                    $max_exc_opts = 0;
                                    $current_exc_opts = 0;
                                    if ($item["exc1_name"] != NULL && !empty($item["exc1_name"])) {
                                        $max_exc_opts++;
                                    }
                                    if ($item["exc2_name"] != NULL && !empty($item["exc2_name"])) {
                                        $max_exc_opts++;
                                    }
                                    if ($item["exc3_name"] != NULL && !empty($item["exc3_name"])) {
                                        $max_exc_opts++;
                                    }
                                    if ($item["exc4_name"] != NULL && !empty($item["exc4_name"])) {
                                        $max_exc_opts++;
                                    }
                                    if ($item["exc5_name"] != NULL && !empty($item["exc5_name"])) {
                                        $max_exc_opts++;
                                    }
                                    if ($item["exc6_name"] != NULL && !empty($item["exc6_name"])) {
                                        $max_exc_opts++;
                                    }
                                    if ($exc_max_opt[$itemTier] < $max_exc_opts) {
                                        $max_exc_opts = $exc_max_opt[$itemTier];
                                    }
                                    if ($item["exc1"]) {
                                        $current_exc_opts++;
                                    }
                                    if ($item["exc2"]) {
                                        $current_exc_opts++;
                                    }
                                    if ($item["exc3"]) {
                                        $current_exc_opts++;
                                    }
                                    if ($item["exc4"]) {
                                        $current_exc_opts++;
                                    }
                                    if ($item["exc5"]) {
                                        $current_exc_opts++;
                                    }
                                    if ($item["exc6"]) {
                                        $current_exc_opts++;
                                    }
                                    if ($current_exc_opts < $max_exc_opts) {
                                        if ($item["exc6_name"] != NULL && !empty($item["exc6_name"]) && $item["exc6"] == "0") {
                                            if ($exc_non_exc[$itemTier] == "0" && $current_exc_opts == 0) {
                                                message("error", lang("market_txt_113", true));
                                            } else {
                                                if ($itemData["use_sockets"] && mconfig("enable_socket_exc") == "0") {
                                                    message("error", lang("market_txt_114", true));
                                                } else {
                                                    if ($item["isanc"] && mconfig("enable_anc_exc") == "0") {
                                                        message("error", lang("market_txt_115", true));
                                                    } else {
                                                        if (config("MEMB_CREDITS_MEMUONLINE", true) && ($exc_price_type["column"] == "platinum" || $exc_price_type["column"] == "gold" || $exc_price_type["column"] == "silver")) {
                                                            $check = $dB2->query_fetch_single("SELECT " . $exc_price_type["column"] . " FROM " . $exc_price_type["table"] . " WHERE " . $exc_price_type["ident"] . " = '" . $username . "'");
                                                        } else {
                                                            $check = $dB->query_fetch_single("SELECT " . $exc_price_type["column"] . " FROM " . $exc_price_type["table"] . " WHERE " . $exc_price_type["ident"] . " = '" . $username . "'");
                                                        }
                                                        if ($exc_price6[$itemTier] <= $check[$exc_price_type["column"]]) {
                                                            $excHex = hexdec(substr($item_code, 14, 2));
                                                            $excHex = $excHex + 32;
                                                            $update = sprintf("%02s", dechex($excHex));
                                                            $item_code_new = substr_replace($item_code, $update, 14, 2);
                                                            $newVault = substr_replace($ci, $item_code_new, $it3 * __ITEM_LENGTH__ + 2, __ITEM_LENGTH__);
                                                            $update = $dB->query("UPDATE [warehouse] SET [Items] = " . $newVault . " WHERE [AccountID] = '" . $username . "' and [Items] = " . $ci);
                                                            if ($update) {
                                                                if (config("MEMB_CREDITS_MEMUONLINE", true) && ($exc_price_type["column"] == "platinum" || $exc_price_type["column"] == "gold" || $exc_price_type["column"] == "silver")) {
                                                                    $update2 = $dB2->query("UPDATE " . $exc_price_type["table"] . " SET " . $exc_price_type["column"] . " = " . $exc_price_type["column"] . " - " . $exc_price6[$itemTier] . " WHERE " . $exc_price_type["ident"] . " = '" . $username . "'");
                                                                } else {
                                                                    $update2 = $dB->query("UPDATE " . $exc_price_type["table"] . " SET " . $exc_price_type["column"] . " = " . $exc_price_type["column"] . " - " . $exc_price6[$itemTier] . " WHERE " . $exc_price_type["ident"] . " = '" . $username . "'");
                                                                }
                                                                if ($update2) {
                                                                    message("success", sprintf(lang("market_txt_122", true), $item["exc6_name"], $exc_price6[$itemTier], $exc_price_type["name"]));
                                                                    $logDate = date("Y-m-d H:i:s", time());
                                                                    $common->accountLogs($username, "vault", sprintf(lang("market_txt_123", true), $item["exc6_name"], $exc_price6[$itemTier], $exc_price_type["name"], $item_code), $logDate);
                                                                } else {
                                                                    message("error", lang("error_23", true));
                                                                }
                                                            } else {
                                                                message("error", lang("error_23", true));
                                                            }
                                                        } else {
                                                            message("error", sprintf(lang("market_txt_118", true), $exc_price_type["name"]));
                                                        }
                                                    }
                                                }
                                            }
                                        } else {
                                            message("error", lang("market_txt_124", true));
                                        }
                                    } else {
                                        message("error", lang("market_txt_120", true));
                                    }
                                } else {
                                    message("error", lang("market_txt_121", true));
                                }
                                break;
                            case "skill":
                                if (mconfig("enable_skill_" . $itemType)) {
                                    if ($itemData["skill"]) {
                                        if ($item["skill2"] == "0") {
                                            if ($itemData["use_sockets"] && mconfig("enable_socket_skill") == "0") {
                                                message("error", lang("market_txt_125", true));
                                            } else {
                                                if ($item["isanc"] && mconfig("enable_anc_skill") == "0") {
                                                    message("error", lang("market_txt_126", true));
                                                } else {
                                                    if (config("MEMB_CREDITS_MEMUONLINE", true) && ($skill_price_type["column"] == "platinum" || $skill_price_type["column"] == "gold" || $skill_price_type["column"] == "silver")) {
                                                        $check = $dB2->query_fetch_single("SELECT " . $skill_price_type["column"] . " FROM " . $skill_price_type["table"] . " WHERE " . $skill_price_type["ident"] . " = '" . $username . "'");
                                                    } else {
                                                        $check = $dB->query_fetch_single("SELECT " . $skill_price_type["column"] . " FROM " . $skill_price_type["table"] . " WHERE " . $skill_price_type["ident"] . " = '" . $username . "'");
                                                    }
                                                    if ($skill_price[$itemTier] <= $check[$skill_price_type["column"]]) {
                                                        $skillHex = hexdec(substr($item_code, 2, 2));
                                                        $skillHex = $skillHex + 128;
                                                        $update = sprintf("%02s", dechex($skillHex));
                                                        $item_code_new = substr_replace($item_code, $update, 2, 2);
                                                        $newVault = substr_replace($ci, $item_code_new, $it3 * __ITEM_LENGTH__ + 2, __ITEM_LENGTH__);
                                                        $update = $dB->query("UPDATE [warehouse] SET [Items] = " . $newVault . " WHERE [AccountID] = '" . $username . "' and [Items] = " . $ci);
                                                        if ($update) {
                                                            if (config("MEMB_CREDITS_MEMUONLINE", true) && ($skill_price_type["column"] == "platinum" || $skill_price_type["column"] == "gold" || $skill_price_type["column"] == "silver")) {
                                                                $update2 = $dB2->query("UPDATE " . $skill_price_type["table"] . " SET " . $skill_price_type["column"] . " = " . $skill_price_type["column"] . " - " . $skill_price[$itemTier] . " WHERE " . $skill_price_type["ident"] . " = '" . $username . "'");
                                                            } else {
                                                                $update2 = $dB->query("UPDATE " . $skill_price_type["table"] . " SET " . $skill_price_type["column"] . " = " . $skill_price_type["column"] . " - " . $skill_price[$itemTier] . " WHERE " . $skill_price_type["ident"] . " = '" . $username . "'");
                                                            }
                                                            if ($update2) {
                                                                message("success", sprintf(lang("market_txt_127", true), $skill_price[$itemTier], $skill_price_type["name"]));
                                                                $logDate = date("Y-m-d H:i:s", time());
                                                                $common->accountLogs($username, "vault", sprintf(lang("market_txt_128", true), $skill_price[$itemTier], $skill_price_type["name"], $item_code), $logDate);
                                                            } else {
                                                                message("error", lang("error_23", true));
                                                            }
                                                        } else {
                                                            message("error", lang("error_23", true));
                                                        }
                                                    } else {
                                                        message("error", sprintf(lang("market_txt_118", true), $skill_price_type["name"]));
                                                    }
                                                }
                                            }
                                        } else {
                                            message("error", lang("market_txt_129", true));
                                        }
                                    } else {
                                        message("error", lang("market_txt_130", true));
                                    }
                                } else {
                                    message("error", lang("market_txt_131", true));
                                }
                                break;
                            case "luck":
                                if (mconfig("enable_luck_" . $itemType)) {
                                    if ($itemData["luck"]) {
                                        if ($item["luck2"] == "0") {
                                            if ($itemData["use_sockets"] && mconfig("enable_socket_luck") == "0") {
                                                message("error", lang("market_txt_132", true));
                                            } else {
                                                if ($item["isanc"] && mconfig("enable_anc_luck") == "0") {
                                                    message("error", lang("market_txt_133", true));
                                                } else {
                                                    if (config("MEMB_CREDITS_MEMUONLINE", true) && ($luck_price_type["column"] == "platinum" || $luck_price_type["column"] == "gold" || $luck_price_type["column"] == "silver")) {
                                                        $check = $dB2->query_fetch_single("SELECT " . $luck_price_type["column"] . " FROM " . $luck_price_type["table"] . " WHERE " . $luck_price_type["ident"] . " = '" . $username . "'");
                                                    } else {
                                                        $check = $dB->query_fetch_single("SELECT " . $luck_price_type["column"] . " FROM " . $luck_price_type["table"] . " WHERE " . $luck_price_type["ident"] . " = '" . $username . "'");
                                                    }
                                                    if ($luck_price[$itemTier] <= $check[$luck_price_type["column"]]) {
                                                        $luckHex = hexdec(substr($item_code, 2, 2));
                                                        $luckHex = $luckHex + 4;
                                                        $update = sprintf("%02s", dechex($luckHex));
                                                        $item_code_new = substr_replace($item_code, $update, 2, 2);
                                                        $newVault = substr_replace($ci, $item_code_new, $it3 * __ITEM_LENGTH__ + 2, __ITEM_LENGTH__);
                                                        $update = $dB->query("UPDATE [warehouse] SET [Items] = " . $newVault . " WHERE [AccountID] = '" . $username . "' and [Items] = " . $ci);
                                                        if ($update) {
                                                            if (config("MEMB_CREDITS_MEMUONLINE", true) && ($luck_price_type["column"] == "platinum" || $luck_price_type["column"] == "gold" || $luck_price_type["column"] == "silver")) {
                                                                $update2 = $dB2->query("UPDATE " . $luck_price_type["table"] . " SET " . $luck_price_type["column"] . " = " . $luck_price_type["column"] . " - " . $luck_price[$itemTier] . " WHERE " . $luck_price_type["ident"] . " = '" . $username . "'");
                                                            } else {
                                                                $update2 = $dB->query("UPDATE " . $luck_price_type["table"] . " SET " . $luck_price_type["column"] . " = " . $luck_price_type["column"] . " - " . $luck_price[$itemTier] . " WHERE " . $luck_price_type["ident"] . " = '" . $username . "'");
                                                            }
                                                            if ($update2) {
                                                                message("success", sprintf(lang("market_txt_134", true), $luck_price[$itemTier], $luck_price_type["name"]));
                                                                $logDate = date("Y-m-d H:i:s", time());
                                                                $common->accountLogs($username, "vault", sprintf(lang("market_txt_134", true), $luck_price[$itemTier], $luck_price_type["name"], $item_code), $logDate);
                                                            } else {
                                                                message("error", lang("error_23", true));
                                                            }
                                                        } else {
                                                            message("error", lang("error_23", true));
                                                        }
                                                    } else {
                                                        message("error", sprintf(lang("market_txt_118", true), $luck_price_type["name"]));
                                                    }
                                                }
                                            }
                                        } else {
                                            message("error", lang("market_txt_136", true));
                                        }
                                    } else {
                                        message("error", lang("market_txt_137", true));
                                    }
                                } else {
                                    message("error", lang("market_txt_138", true));
                                }
                                break;
                        }
                    } else {
                        message("error", lang("market_txt_139", true));
                    }
                }
            } else {
                message("error", lang("market_txt_140", true));
            }
        }
    }
    public function showItem($data, $serial, $token)
    {
        global $dB;
        global $dB2;
        $Items = new Items();
        $i = -1;
        while ($i < 239) {
            $i++;
            $item = $Items->ItemInfo(substr($data, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__));
            if ($item["sn2"] . $item["sn"] == $serial) {
                $item_code = substr($data, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                $i = 250;
            }
        }
        unset($i);
        if ($item_code) {
            $item = $Items->ItemInfo($item_code);
            if ($item["name"]) {
                if ($item["level"]) {
                    $plusche = "+" . $item["level"];
                }
                $rqs = "";
                if ($item["str"]) {
                    $rqs .= $item["str"] . " " . lang("market_txt_96", true) . "<br>";
                }
                if ($item["nrg"]) {
                    $rqs .= $item["nrg"] . " " . lang("market_txt_97", true) . "<br>";
                }
                if ($item["cmd"]) {
                    $rqs .= $item["cmd"] . " " . lang("market_txt_98", true) . "<br>";
                }
                if ($item["agi"]) {
                    $rqs .= $item["agi"] . " " . lang("market_txt_99", true) . "<br>";
                }
                if (!$item["luck"] && !$item["exl"] && !$item["skill"] && !$item["option"] && !$item["ancsetopt"]) {
                    $addx = "<br>";
                }
                if ($item["opt"]) {
                    $option = "<font color=#9aadd5>" . $item["opt"] . "</font><br>";
                }
                if ($item["luck"]) {
                    $luck = "<font color=#9aadd5>" . $item["luck"] . "</font>";
                }
                if ($item["skill"]) {
                    $skill = "<br><font color=#9aadd5>" . $item["skill"] . "<br></font>";
                }
                if ($item["exl"]) {
                    $exl = "<font color=#4d668d>" . str_replace("^^", "<br>", $item["exl"]) . "</font>";
                }
                if ($item["ancsetopt"]) {
                    $ancsetopt = "<font color=#9aadd5>" . str_replace("^^", "<br>", $item["ancsetopt"]) . "</font>";
                }
                if ($item["level"]) {
                    $item["level"] = " +" . $item["level"];
                } else {
                    $item["level"] = NULL;
                }
                $exl = str_replace("'", "\\'", $exl);
                echo "\r\n                <script type=\"text/javascript\">\r\n                    \$(document).ready(function () {\r\n                        \$('#radio_sell').click(function () {\r\n                            document.getElementById(\"sell\").style.display = \"block\";\r\n                            document.getElementById(\"delete\").style.display = \"none\";\r\n                            document.getElementById(\"upgrade\").style.display = \"none\";\r\n                        });\r\n                        \$('#radio_delete').click(function () {\r\n                            document.getElementById(\"sell\").style.display = \"none\";\r\n                            document.getElementById(\"delete\").style.display = \"block\";\r\n                            document.getElementById(\"upgrade\").style.display = \"none\";\r\n                        });\r\n                        \$('#radio_upgrade').click(function () {\r\n                            document.getElementById(\"sell\").style.display = \"none\";\r\n                            document.getElementById(\"delete\").style.display = \"none\";\r\n                            document.getElementById(\"upgrade\").style.display = \"block\";\r\n                        });\r\n                    });\r\n                </script>\r\n\r\n                ";
                echo "\r\n        <div class=\"container_3 account-wide\" align=\"center\">\r\n          <table class=\"irq\" width=\"100%\" cellspacing=\"0\">\r\n            <tr>\r\n              <th width=\"40%\" rowspan=\"2\">\r\n                <div " . $item["anc"] . "><font color=\"" . $item["color"] . "\">" . $item["name"] . $item["level"] . "</font></div>\r\n                <center>\r\n                  <img src=\"" . $item["thumb"] . "\">\r\n                  <br /><font color=\"yellow\"><br>" . lang("market_txt_100", true) . " " . $item["sn2"] . $item["sn"] . "</font>\r\n                  <br>\r\n                  <font color=\"white\"><br>" . lang("market_txt_101", true) . " " . $item["dur"] . "</font><br>\r\n                  <font color=\"#FF99CC\">" . $item["jog"] . "</font>\r\n                  <font color=\"#FFCC00\">" . $item["harm"] . "</font>\r\n                  <br>" . $option . " " . $luck . " " . $skill . " " . $exl . " " . $ancsetopt . "<br>\r\n                  <font color=\"#4d668d\">" . $item["socket"] . "</font>\r\n                </center>\r\n              </th>\r\n              <td width=\"60%\" height=\"30px\">";
                $delCheck = "";
                $upgrdCheck = "";
                if (mconfig("is_sell")) {
                    echo "\r\n                <label class=\"label_radio\">\r\n                  <div></div>\r\n                  <input type=\"radio\" class=\"chItemPrice\" id=\"radio_sell\" name=\"type\" value=\"sell\" checked>\r\n                  <p>" . lang("market_txt_141", true) . "</p>\r\n                </label>";
                } else {
                    $delCheck = "checked";
                }
                if (mconfig("is_delete")) {
                    echo "\r\n                <label class=\"label_radio\">\r\n                  <div></div>\r\n                  <input type=\"radio\" class=\"chItemPrice\" id=\"radio_delete\" name=\"type\" value=\"delete\" " . $delCheck . ">\r\n                  <p>" . lang("market_txt_142", true) . "</p>\r\n                </label>";
                } else {
                    $upgrdCheck = "checked";
                }
                if (mconfig("is_upgrade")) {
                    echo "\r\n                <label class=\"label_radio\">\r\n                  <div></div>\r\n                  <input type=\"radio\" class=\"chItemPrice\" id=\"radio_upgrade\" name=\"type\" value=\"upgrade\" " . $upgrdCheck . ">\r\n                  <p>" . lang("market_txt_143", true) . "</p>\r\n                </label>";
                }
                echo "\r\n              </td>\r\n            </tr>\r\n            <tr>\r\n              <td style=\"vertical-align: top;\">";
                if (mconfig("is_sell")) {
                    $canSell = $dB->query_fetch_single("SELECT sell FROM IMPERIAMUCMS_ITEMS WHERE type = ? AND id = ? AND level = ?", [$item["type"], $item["id"], $item["sticklevel"]]);
                    if ($canSell["sell"] == "1") {
                        loadModuleConfigs("usercp.market");
                        $tax = mconfig("tax");
                        $tax_type = mconfig("tax_type");
                        if (1 <= $tax) {
                            if ($tax_type == "1") {
                                $tax_type = lang("currency_platinum", true);
                            } else {
                                if ($tax_type == "2") {
                                    $tax_type = lang("currency_gold", true);
                                } else {
                                    if ($tax_type == "3") {
                                        $tax_type = lang("currency_silver", true);
                                    } else {
                                        if ($tax_type == "4") {
                                            $tax_type = lang("currency_wcoinc", true);
                                        } else {
                                            if ($tax_type == "5") {
                                                $tax_type = lang("currency_gp", true);
                                            } else {
                                                if ($tax_type == "6") {
                                                    $tax_type = "" . lang("currency_zen", true) . "";
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                            $return = [];
                            mconfig("tax_type");
                            switch (mconfig("tax_type")) {
                                case 1:
                                    $return["column"] = "platinum";
                                    $return["table"] = "MEMB_CREDITS";
                                    $return["ident"] = "memb___id";
                                    $return["name"] = lang("currency_platinum", true);
                                    break;
                                case 2:
                                    $return["column"] = "gold";
                                    $return["table"] = "MEMB_CREDITS";
                                    $return["ident"] = "memb___id";
                                    $return["name"] = lang("currency_gold", true);
                                    break;
                                case 3:
                                    $return["column"] = "silver";
                                    $return["table"] = "MEMB_CREDITS";
                                    $return["ident"] = "memb___id";
                                    $return["name"] = lang("currency_silver", true);
                                    break;
                                case 4:
                                    if (100 <= config("server_files_season", true)) {
                                        $return["column"] = "WCoin";
                                    } else {
                                        $return["column"] = "WCoinC";
                                    }
                                    $return["table"] = "T_InGameShop_Point";
                                    $return["ident"] = "AccountID";
                                    $return["name"] = lang("currency_wcoinc", true);
                                    break;
                                case 5:
                                    $return["column"] = "GoblinPoint";
                                    $return["table"] = "T_InGameShop_Point";
                                    $return["ident"] = "AccountID";
                                    $return["name"] = lang("currency_gp", true);
                                    break;
                                case 6:
                                    $return["column"] = "zen";
                                    $return["table"] = "IMPERIAMUCMS_WEB_BANK";
                                    $return["ident"] = "AccountID";
                                    $return["name"] = "" . lang("currency_zen", true) . "";
                                    break;
                                default:
                                    if (config("MEMB_CREDITS_MEMUONLINE", true) && ($return["column"] == "platinum" || $return["column"] == "gold" || $return["column"] == "silver")) {
                                        $checkCurrency = $dB2->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$_SESSION["username"]]);
                                    } else {
                                        $checkCurrency = $dB->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$_SESSION["username"]]);
                                    }
                                    if ($checkCurrency[$return["column"]] < $tax) {
                                        $action = sprintf(lang("market_txt_118", true), $return["name"]);
                                    } else {
                                        $action = "<input type=\"submit\" name=\"sell\" value=\"" . lang("market_txt_145", true) . "\" class=\"simple_button purchase_button\">";
                                    }
                            }
                        } else {
                            $action = "<input type=\"submit\" name=\"sell\" value=\"" . lang("market_txt_145", true) . "\" class=\"simple_button purchase_button\">";
                        }
                        loadModuleConfigs("usercp.vault");
                        echo "\r\n                    <div id=\"sell\">";
                        if (1 <= $tax) {
                            echo "\r\n                      <p style=\"padding-bottom: 10px;\">" . sprintf(lang("market_txt_195", true), $tax, $tax_type) . "</p>";
                        }
                        echo "\r\n                      <form method=\"post\" action=\"" . __BASE_URL__ . "usercp/vault\">";
                        $currencies = "";
                        if (mconfig("zen") == 1) {
                            $currencies .= "<option value='" . Encode("zen") . "'>" . lang("currency_zen", true) . "</option>";
                        }
                        if (mconfig("platinum") == 1) {
                            $currencies .= "<option value='" . Encode("platinum") . "'>" . lang("currency_platinum", true) . "</option>";
                        }
                        if (mconfig("gold") == 1) {
                            $currencies .= "<option value='" . Encode("gold") . "'>" . lang("currency_gold", true) . "</option>";
                        }
                        if (mconfig("silver") == 1) {
                            $currencies .= "<option value='" . Encode("silver") . "'>" . lang("currency_silver", true) . "</option>";
                        }
                        if (mconfig("WCoinC") == 1) {
                            $currencies .= "<option value='" . Encode("WCoinC") . "'>" . lang("currency_wcoinc", true) . "</option>";
                        }
                        if (mconfig("GoblinPoint") == 1) {
                            $currencies .= "<option value='" . Encode("GoblinPoint") . "'>" . lang("currency_gp", true) . "</option>";
                        }
                        if (mconfig("bless") == 1) {
                            $currencies .= "<option value='" . Encode("bless") . "'>" . lang("currency_bless", true) . "</option>";
                        }
                        if (mconfig("soul") == 1) {
                            $currencies .= "<option value='" . Encode("soul") . "'>" . lang("currency_soul", true) . "</option>";
                        }
                        if (mconfig("life") == 1) {
                            $currencies .= "<option value='" . Encode("life") . "'>" . lang("currency_life", true) . "</option>";
                        }
                        if (mconfig("chaos") == 1) {
                            $currencies .= "<option value='" . Encode("chaos") . "'>" . lang("currency_chaos", true) . "</option>";
                        }
                        if (mconfig("harmony") == 1) {
                            $currencies .= "<option value='" . Encode("harmony") . "'>" . lang("currency_harmony", true) . "</option>";
                        }
                        if (mconfig("creation") == 1) {
                            $currencies .= "<option value='" . Encode("creation") . "'>" . lang("currency_creation", true) . "</option>";
                        }
                        if (mconfig("guardian") == 1) {
                            $currencies .= "<option value='" . Encode("guardian") . "'>" . lang("currency_guardian", true) . "</option>";
                        }
                        echo "\r\n                        <input type=\"text\" id=\"sell_price\" placeholder=\"Price\" name=\"sell_price\" value=\"\">\r\n                        <select id=\"sell_price_type\" name=\"sell_price_type\" styled=\"true\" style=\"display: none;\">\r\n                          <option value=\"\" disabled=\"disabled\">" . lang("market_txt_144", true) . "</option>\r\n                          " . $currencies . "\r\n                        </select><br /><br />\r\n                        <input type=\"hidden\" name=\"item\" value=\"" . Encode($serial) . "\">\r\n                        <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                        " . $action . "\r\n                      </form>\r\n                    </div>";
                    } else {
                        echo "<div id=\"sell\">" . lang("market_txt_197", true) . "</div>";
                    }
                } else {
                    echo "<div id=\"sell\" style=\"display: none\"></div>";
                }
                if (mconfig("is_delete")) {
                    if ($delCheck != NULL || !empty($delCheck)) {
                        $displayDel = "block";
                    } else {
                        $displayDel = "none";
                    }
                    echo "\r\n                <div id=\"delete\" style=\"display: " . $displayDel . "\">\r\n                  <form method=\"post\" action=\"" . __BASE_URL__ . "usercp/vault\">\r\n                    " . lang("market_txt_146", true) . "<br /><br />\r\n                    <input type=\"hidden\" name=\"item\" value=\"" . Encode($serial) . "\">\r\n                    <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                    <input type=\"submit\" name=\"delete\" value=\"" . lang("market_txt_147", true) . "\" class=\"simple_button purchase_button\">\r\n                  </form>\r\n                </div>";
                } else {
                    echo "<div id=\"delete\" style=\"display: none\"></div>";
                }
                if (mconfig("is_upgrade")) {
                    if ($upgrdCheck != NULL || !empty($upgrdCheckCheck)) {
                        $displayUpgrd = "block";
                    } else {
                        $displayUpgrd = "none";
                    }
                    echo "\r\n                <div id=\"upgrade\" style=\"display: " . $displayUpgrd . "\">";
                    $itemData = $this->getItemInfo($item["type"], $item["id"], $item["sticklevel"]);
                    $upgrd = "";
                    if (0 < $itemData["exc"]) {
                        echo "<form method=\"post\" action=\"" . __BASE_URL__ . "usercp/vault\">";
                        $operations = "";
                        $itemType = $this->returnItemType($item["type"], $item["id"]);
                        $itemTier = $itemData["class"] - 1;
                        $exc_non_exc = explode(",", mconfig("exc_non_exc_" . $itemType));
                        $exc_rand_opt = explode(",", mconfig("exc_rand_opt_" . $itemType));
                        $exc_max_opt = explode(",", mconfig("exc_max_opt_" . $itemType));
                        $exc_rand_price = explode(",", mconfig("exc_rand_price_" . $itemType));
                        $exc_price1 = explode(",", mconfig("exc_price1_" . $itemType));
                        $exc_price2 = explode(",", mconfig("exc_price2_" . $itemType));
                        $exc_price3 = explode(",", mconfig("exc_price3_" . $itemType));
                        $exc_price4 = explode(",", mconfig("exc_price4_" . $itemType));
                        $exc_price5 = explode(",", mconfig("exc_price5_" . $itemType));
                        $exc_price6 = explode(",", mconfig("exc_price6_" . $itemType));
                        $exc_price_type = explode(",", mconfig("exc_price_type_" . $itemType));
                        if ($itemType == "weapon") {
                            $skill_price = explode(",", mconfig("skill_price_" . $itemType));
                            $skill_price_type = explode(",", mconfig("skill_price_type_" . $itemType));
                        }
                        if ($itemType != "jewelry") {
                            $luck_price = explode(",", mconfig("luck_price_" . $itemType));
                            $luck_price_type = explode(",", mconfig("luck_price_type_" . $itemType));
                        }
                        if ($item["isanc"]) {
                            foreach ($exc_rand_price as $key => $value) {
                                $exc_rand_price[$key] = $exc_rand_price[$key] * mconfig("anc_price_rate");
                            }
                            foreach ($exc_price1 as $key => $value) {
                                $exc_price1[$key] = $exc_price1[$key] * mconfig("anc_price_rate");
                            }
                            foreach ($exc_price2 as $key => $value) {
                                $exc_price2[$key] = $exc_price2[$key] * mconfig("anc_price_rate");
                            }
                            foreach ($exc_price3 as $key => $value) {
                                $exc_price3[$key] = $exc_price3[$key] * mconfig("anc_price_rate");
                            }
                            foreach ($exc_price4 as $key => $value) {
                                $exc_price4[$key] = $exc_price4[$key] * mconfig("anc_price_rate");
                            }
                            foreach ($exc_price5 as $key => $value) {
                                $exc_price5[$key] = $exc_price5[$key] * mconfig("anc_price_rate");
                            }
                            foreach ($exc_price6 as $key => $value) {
                                $exc_price6[$key] = $exc_price6[$key] * mconfig("anc_price_rate");
                            }
                            foreach ($skill_price as $key => $value) {
                                $skill_price[$key] = $skill_price[$key] * mconfig("anc_price_rate");
                            }
                            foreach ($exc_price1 as $key => $value) {
                                $luck_price[$key] = $luck_price[$key] * mconfig("anc_price_rate");
                            }
                        }
                        if (0 < $itemData["exc"]) {
                            $exc_price_type = $this->upgradeItemPriceType($exc_price_type[$itemTier]);
                        }
                        if (0 < $itemData["skill"]) {
                            $skill_price_type = $this->upgradeItemPriceType($skill_price_type[$itemTier]);
                        }
                        if (0 < $itemData["luck"]) {
                            $luck_price_type = $this->upgradeItemPriceType($luck_price_type[$itemTier]);
                        }
                        if (0 < $itemData["exc"]) {
                            if (mconfig("enable_exc_" . $itemType)) {
                                $max_exc_opts = 0;
                                $current_exc_opts = 0;
                                if ($item["exc1_name"] != NULL && !empty($item["exc1_name"])) {
                                    $max_exc_opts++;
                                }
                                if ($item["exc2_name"] != NULL && !empty($item["exc2_name"])) {
                                    $max_exc_opts++;
                                }
                                if ($item["exc3_name"] != NULL && !empty($item["exc3_name"])) {
                                    $max_exc_opts++;
                                }
                                if ($item["exc4_name"] != NULL && !empty($item["exc4_name"])) {
                                    $max_exc_opts++;
                                }
                                if ($item["exc5_name"] != NULL && !empty($item["exc5_name"])) {
                                    $max_exc_opts++;
                                }
                                if ($item["exc6_name"] != NULL && !empty($item["exc6_name"])) {
                                    $max_exc_opts++;
                                }
                                if ($exc_max_opt[$itemTier] < $max_exc_opts) {
                                    $max_exc_opts = $exc_max_opt[$itemTier];
                                }
                                if ($item["exc1"]) {
                                    $current_exc_opts++;
                                }
                                if ($item["exc2"]) {
                                    $current_exc_opts++;
                                }
                                if ($item["exc3"]) {
                                    $current_exc_opts++;
                                }
                                if ($item["exc4"]) {
                                    $current_exc_opts++;
                                }
                                if ($item["exc5"]) {
                                    $current_exc_opts++;
                                }
                                if ($item["exc6"]) {
                                    $current_exc_opts++;
                                }
                                if ($current_exc_opts < $max_exc_opts) {
                                    if ($exc_rand_opt[$itemTier]) {
                                        $operations .= "<option value=\"" . Encode("exc_rand_opt") . "\">" . lang("market_txt_148", true) . " (" . $exc_rand_price[$itemTier] . " " . $exc_price_type["name"] . ")</option>";
                                    } else {
                                        if ($item["exc1_name"] != NULL && !empty($item["exc1_name"]) && $item["exc1"] == "0") {
                                            $operations .= "<option value=\"" . Encode("exc_opt_1") . "\">" . sprintf(lang("market_txt_149", true), $item["exc1_name"]) . " (" . $exc_price1[$itemTier] . " " . $exc_price_type["name"] . ")</option>";
                                        }
                                        if ($item["exc2_name"] != NULL && !empty($item["exc2_name"]) && $item["exc2"] == "0") {
                                            $operations .= "<option value=\"" . Encode("exc_opt_2") . "\">" . sprintf(lang("market_txt_149", true), $item["exc2_name"]) . " (" . $exc_price2[$itemTier] . " " . $exc_price_type["name"] . ")</option>";
                                        }
                                        if ($item["exc3_name"] != NULL && !empty($item["exc3_name"]) && $item["exc3"] == "0") {
                                            $operations .= "<option value=\"" . Encode("exc_opt_3") . "\">" . sprintf(lang("market_txt_149", true), $item["exc3_name"]) . " (" . $exc_price3[$itemTier] . " " . $exc_price_type["name"] . ")</option>";
                                        }
                                        if ($item["exc4_name"] != NULL && !empty($item["exc4_name"]) && $item["exc4"] == "0") {
                                            $operations .= "<option value=\"" . Encode("exc_opt_4") . "\">" . sprintf(lang("market_txt_149", true), $item["exc4_name"]) . " (" . $exc_price4[$itemTier] . " " . $exc_price_type["name"] . ")</option>";
                                        }
                                        if ($item["exc5_name"] != NULL && !empty($item["exc5_name"]) && $item["exc5"] == "0") {
                                            $operations .= "<option value=\"" . Encode("exc_opt_5") . "\">" . sprintf(lang("market_txt_149", true), $item["exc5_name"]) . " (" . $exc_price5[$itemTier] . " " . $exc_price_type["name"] . ")</option>";
                                        }
                                        if ($item["exc6_name"] != NULL && !empty($item["exc6_name"]) && $item["exc6"] == "0") {
                                            $operations .= "<option value=\"" . Encode("exc_opt_6") . "\">" . sprintf(lang("market_txt_149", true), $item["exc6_name"]) . " (" . $exc_price6[$itemTier] . " " . $exc_price_type["name"] . ")</option>";
                                        }
                                    }
                                }
                                if ($exc_non_exc[$itemTier] == "0" && $current_exc_opts == 0) {
                                    $operations = "";
                                }
                                if ($itemData["use_sockets"] && mconfig("enable_socket_exc") == "0") {
                                    $operations = "";
                                }
                                if ($item["isanc"] && mconfig("enable_anc_exc") == "0") {
                                    $operations = "";
                                }
                            }
                            if (mconfig("enable_skill_" . $itemType) && $itemData["skill"] && $item["skill2"] == "0") {
                                if ($item["isanc"]) {
                                    if (mconfig("enable_anc_skill")) {
                                        $operations .= "<option value=\"" . Encode("skill") . "\">" . lang("market_txt_150", true) . " (" . $skill_price[$itemTier] . " " . $skill_price_type["name"] . ")</option>";
                                    }
                                } else {
                                    if ($itemData["use_sockets"]) {
                                        if (mconfig("enable_socket_skill")) {
                                            $operations .= "<option value=\"" . Encode("skill") . "\">" . lang("market_txt_150", true) . " (" . $skill_price[$itemTier] . " " . $skill_price_type["name"] . ")</option>";
                                        }
                                    } else {
                                        $operations .= "<option value=\"" . Encode("skill") . "\">" . lang("market_txt_150", true) . " (" . $skill_price[$itemTier] . " " . $skill_price_type["name"] . ")</option>";
                                    }
                                }
                            }
                            if (mconfig("enable_luck_" . $itemType) && $itemData["luck"] && $item["luck2"] == "0") {
                                if ($item["isanc"]) {
                                    if (mconfig("enable_anc_luck")) {
                                        $operations .= "<option value=\"" . Encode("luck") . "\">" . lang("market_txt_151", true) . " (" . $luck_price[$itemTier] . " " . $luck_price_type["name"] . ")</option>";
                                    }
                                } else {
                                    if ($itemData["use_sockets"]) {
                                        if (mconfig("enable_socket_luck")) {
                                            $operations .= "<option value=\"" . Encode("luck") . "\">" . lang("market_txt_151", true) . " (" . $luck_price[$itemTier] . " " . $luck_price_type["name"] . ")</option>";
                                        }
                                    } else {
                                        $operations .= "<option value=\"" . Encode("luck") . "\">" . lang("market_txt_151", true) . " (" . $luck_price[$itemTier] . " " . $luck_price_type["name"] . ")</option>";
                                    }
                                }
                            }
                            $showButton = false;
                            if ($operations != NULL && !empty($operations)) {
                                $operations = "<option value=\"\" disabled=\"disabled\">" . lang("market_txt_152", true) . "</option>" . $operations;
                                $showButton = true;
                            }
                            if ($showButton) {
                                echo "\r\n                            <select id=\"operation_type\" name=\"operation_type\" styled=\"true\" style=\"display: none;\">\r\n                              " . $operations . "\r\n                            </select>";
                                if ($item["type"] == "0") {
                                    $item["type"] = "00";
                                }
                                if ($item["id"] == "0") {
                                    $item["id"] = "00";
                                }
                                if ($item["sticklevel"] == "0") {
                                    $item["sticklevel"] = "00";
                                }
                                echo "\r\n                            <br /><br />\r\n                            <input type=\"hidden\" name=\"item\" value=\"" . Encode($serial) . "\">\r\n                            <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                            <input type=\"hidden\" name=\"" . Encode("item_type") . "\" value=\"" . Encode($item["type"]) . "\">\r\n                            <input type=\"hidden\" name=\"" . Encode("item_id") . "\" value=\"" . Encode($item["id"]) . "\">\r\n                            <input type=\"hidden\" name=\"" . Encode("item_level") . "\" value=\"" . Encode($item["sticklevel"]) . "\">\r\n                            <input type=\"submit\" name=\"upgrade\" value=\"" . lang("market_txt_153", true) . "\" class=\"simple_button purchase_button\">\r\n                            ";
                            } else {
                                echo lang("market_txt_139", true);
                            }
                        }
                        echo "</form>";
                    } else {
                        echo lang("market_txt_139", true);
                    }
                    echo "</div>";
                } else {
                    echo "<div id=\"upgrade\" style=\"display: none\"></div>";
                }
                echo "\r\n              </td>\r\n            </tr>\r\n          </table>\r\n        </div>";
            }
        }
    }
    public function showItemResponsive($data, $serial, $token)
    {
        global $dB;
        global $dB2;
        $Items = new Items();
        $i = -1;
        while ($i < 239) {
            $i++;
            $item = $Items->ItemInfo(substr($data, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__));
            if ($item["sn2"] . $item["sn"] == $serial) {
                $item_code = substr($data, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                $i = 250;
            }
        }
        unset($i);
        if ($item_code) {
            $item = $Items->ItemInfo($item_code);
            if ($item["name"]) {
                $rqs = "";
                if ($item["str"]) {
                    $rqs .= $item["str"] . " " . lang("market_txt_96", true) . "<br>";
                }
                if ($item["nrg"]) {
                    $rqs .= $item["nrg"] . " " . lang("market_txt_97", true) . "<br>";
                }
                if ($item["cmd"]) {
                    $rqs .= $item["cmd"] . " " . lang("market_txt_98", true) . "<br>";
                }
                if ($item["agi"]) {
                    $rqs .= $item["agi"] . " " . lang("market_txt_99", true) . "<br>";
                }
                if (!$item["luck"] && !$item["exl"] && !$item["skill"] && !$item["option"] && !$item["ancsetopt"]) {
                    $addx = "<br>";
                }
                if ($item["opt"]) {
                    $option = "<span class=\"item-tooltip-opt\">" . $item["opt"] . "</span><br>";
                }
                if ($item["luck"]) {
                    $luck = "<span class=\"item-tooltip-luck\">" . $item["luck"] . "</span>";
                }
                if ($item["skill"]) {
                    $skill = "<br><span class=\"item-tooltip-skill\">" . $item["skill"] . "<br></span>";
                }
                if ($item["exl"]) {
                    $exl = "<span class=\"item-tooltip-exc\">" . str_replace("^^", "<br>", $item["exl"]) . "</span>";
                }
                if ($item["ancsetopt"]) {
                    $ancsetopt = "<span class=\"item-tooltip-anc\">" . str_replace("^^", "<br>", $item["ancsetopt"]) . "</span>";
                }
                if (!$item["level"]) {
                    $item["level"] = NULL;
                }
                $exl = str_replace("'", "\\'", $exl);
                echo "\r\n                <script type=\"text/javascript\">\r\n                    \$(document).ready(function () {\r\n                        \$('#radio_sell').click(function () {\r\n                            document.getElementById(\"sell\").style.display = \"block\";\r\n                            document.getElementById(\"delete\").style.display = \"none\";\r\n                            document.getElementById(\"upgrade\").style.display = \"none\";\r\n                        });\r\n                        \$('#radio_delete').click(function () {\r\n                            document.getElementById(\"sell\").style.display = \"none\";\r\n                            document.getElementById(\"delete\").style.display = \"block\";\r\n                            document.getElementById(\"upgrade\").style.display = \"none\";\r\n                        });\r\n                        \$('#radio_upgrade').click(function () {\r\n                            document.getElementById(\"sell\").style.display = \"none\";\r\n                            document.getElementById(\"delete\").style.display = \"none\";\r\n                            document.getElementById(\"upgrade\").style.display = \"block\";\r\n                        });\r\n                    });\r\n                </script>\r\n\r\n                ";
                echo "\r\n    <div class=\"row\">\r\n        <div class=\"col-xs-12 col-md-5\">\r\n            <div class=\"text-center\">\r\n                " . $Items->generateStyledItemInfo($item, 1, 1, 1) . "\r\n            </div>\r\n        </div>\r\n        <div class=\"col-xs-12 col-md-7\">";
                $delCheck = "";
                $upgrdCheck = "";
                if (mconfig("is_sell")) {
                    echo "\r\n            <label class=\"radio-inline\">\r\n                <input type=\"radio\" class=\"chItemPrice\" id=\"radio_sell\" name=\"type\" value=\"sell\" checked>\r\n                <p>" . lang("market_txt_141", true) . "</p>\r\n            </label>";
                } else {
                    $delCheck = "checked";
                }
                if (mconfig("is_delete")) {
                    echo "\r\n            <label class=\"radio-inline\">\r\n                <input type=\"radio\" class=\"chItemPrice\" id=\"radio_delete\" name=\"type\" value=\"delete\" " . $delCheck . ">\r\n                <p>" . lang("market_txt_142", true) . "</p>\r\n            </label>";
                } else {
                    $upgrdCheck = "checked";
                }
                if (mconfig("is_upgrade")) {
                    echo "\r\n            <label class=\"radio-inline\">\r\n                <input type=\"radio\" class=\"chItemPrice\" id=\"radio_upgrade\" name=\"type\" value=\"upgrade\" " . $upgrdCheck . ">\r\n                <p>" . lang("market_txt_143", true) . "</p>\r\n            </label>";
                }
                if (mconfig("is_sell")) {
                    $canSell = $dB->query_fetch_single("SELECT sell FROM IMPERIAMUCMS_ITEMS WHERE type = ? AND id = ? AND level = ?", [$item["type"], $item["id"], $item["sticklevel"]]);
                    if ($canSell["sell"] == "1") {
                        loadModuleConfigs("usercp.market");
                        $tax = mconfig("tax");
                        $tax_type = mconfig("tax_type");
                        if (1 <= $tax) {
                            if ($tax_type == "1") {
                                $tax_type = lang("currency_platinum", true);
                            } else {
                                if ($tax_type == "2") {
                                    $tax_type = lang("currency_gold", true);
                                } else {
                                    if ($tax_type == "3") {
                                        $tax_type = lang("currency_silver", true);
                                    } else {
                                        if ($tax_type == "4") {
                                            $tax_type = lang("currency_wcoinc", true);
                                        } else {
                                            if ($tax_type == "5") {
                                                $tax_type = lang("currency_gp", true);
                                            } else {
                                                if ($tax_type == "6") {
                                                    $tax_type = "" . lang("currency_zen", true) . "";
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                            $return = [];
                            mconfig("tax_type");
                            switch (mconfig("tax_type")) {
                                case 1:
                                    $return["column"] = "platinum";
                                    $return["table"] = "MEMB_CREDITS";
                                    $return["ident"] = "memb___id";
                                    $return["name"] = lang("currency_platinum", true);
                                    break;
                                case 2:
                                    $return["column"] = "gold";
                                    $return["table"] = "MEMB_CREDITS";
                                    $return["ident"] = "memb___id";
                                    $return["name"] = lang("currency_gold", true);
                                    break;
                                case 3:
                                    $return["column"] = "silver";
                                    $return["table"] = "MEMB_CREDITS";
                                    $return["ident"] = "memb___id";
                                    $return["name"] = lang("currency_silver", true);
                                    break;
                                case 4:
                                    if (100 <= config("server_files_season", true)) {
                                        $return["column"] = "WCoin";
                                    } else {
                                        $return["column"] = "WCoinC";
                                    }
                                    $return["table"] = "T_InGameShop_Point";
                                    $return["ident"] = "AccountID";
                                    $return["name"] = lang("currency_wcoinc", true);
                                    break;
                                case 5:
                                    $return["column"] = "GoblinPoint";
                                    $return["table"] = "T_InGameShop_Point";
                                    $return["ident"] = "AccountID";
                                    $return["name"] = lang("currency_gp", true);
                                    break;
                                case 6:
                                    $return["column"] = "zen";
                                    $return["table"] = "IMPERIAMUCMS_WEB_BANK";
                                    $return["ident"] = "AccountID";
                                    $return["name"] = "" . lang("currency_zen", true) . "";
                                    break;
                                default:
                                    if (config("MEMB_CREDITS_MEMUONLINE", true) && ($return["column"] == "platinum" || $return["column"] == "gold" || $return["column"] == "silver")) {
                                        $checkCurrency = $dB2->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$_SESSION["username"]]);
                                    } else {
                                        $checkCurrency = $dB->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$_SESSION["username"]]);
                                    }
                                    if ($checkCurrency[$return["column"]] < $tax) {
                                        $action = sprintf(lang("market_txt_118", true), $return["name"]);
                                    } else {
                                        $action = "<input type=\"submit\" name=\"sell\" value=\"" . lang("market_txt_145", true) . "\" class=\"btn btn-warning\">";
                                    }
                            }
                        } else {
                            $action = "<input type=\"submit\" name=\"sell\" value=\"" . lang("market_txt_145", true) . "\" class=\"btn btn-warning\">";
                        }
                        loadModuleConfigs("usercp.vault");
                        echo "\r\n            <div id=\"sell\">";
                        if (1 <= $tax) {
                            echo "\r\n                <p style=\"padding-bottom: 10px;\">" . sprintf(lang("market_txt_195", true), $tax, $tax_type) . "</p>";
                        }
                        echo "\r\n                <form method=\"post\" action=\"" . __BASE_URL__ . "usercp/vault\">";
                        $currencies = "";
                        if (mconfig("zen") == 1) {
                            $currencies .= "<option value='" . Encode("zen") . "'>" . lang("currency_zen", true) . "</option>";
                        }
                        if (mconfig("platinum") == 1) {
                            $currencies .= "<option value='" . Encode("platinum") . "'>" . lang("currency_platinum", true) . "</option>";
                        }
                        if (mconfig("gold") == 1) {
                            $currencies .= "<option value='" . Encode("gold") . "'>" . lang("currency_gold", true) . "</option>";
                        }
                        if (mconfig("silver") == 1) {
                            $currencies .= "<option value='" . Encode("silver") . "'>" . lang("currency_silver", true) . "</option>";
                        }
                        if (mconfig("WCoinC") == 1) {
                            $currencies .= "<option value='" . Encode("WCoinC") . "'>" . lang("currency_wcoinc", true) . "</option>";
                        }
                        if (mconfig("GoblinPoint") == 1) {
                            $currencies .= "<option value='" . Encode("GoblinPoint") . "'>" . lang("currency_gp", true) . "</option>";
                        }
                        if (mconfig("bless") == 1) {
                            $currencies .= "<option value='" . Encode("bless") . "'>" . lang("currency_bless", true) . "</option>";
                        }
                        if (mconfig("soul") == 1) {
                            $currencies .= "<option value='" . Encode("soul") . "'>" . lang("currency_soul", true) . "</option>";
                        }
                        if (mconfig("life") == 1) {
                            $currencies .= "<option value='" . Encode("life") . "'>" . lang("currency_life", true) . "</option>";
                        }
                        if (mconfig("chaos") == 1) {
                            $currencies .= "<option value='" . Encode("chaos") . "'>" . lang("currency_chaos", true) . "</option>";
                        }
                        if (mconfig("harmony") == 1) {
                            $currencies .= "<option value='" . Encode("harmony") . "'>" . lang("currency_harmony", true) . "</option>";
                        }
                        if (mconfig("creation") == 1) {
                            $currencies .= "<option value='" . Encode("creation") . "'>" . lang("currency_creation", true) . "</option>";
                        }
                        if (mconfig("guardian") == 1) {
                            $currencies .= "<option value='" . Encode("guardian") . "'>" . lang("currency_guardian", true) . "</option>";
                        }
                        echo "\r\n                    <div class=\"row\">\r\n                        <div class=\"col-xs-6\" style=\"padding-right: 0;\">\r\n                            <input type=\"text\" id=\"sell_price\" placeholder=\"Price\" name=\"sell_price\" value=\"\" class=\"form-control\">\r\n                        </div>\r\n                        <div class=\"col-xs-6\" style=\"padding-left: 10px;\">\r\n                            <select id=\"sell_price_type\" name=\"sell_price_type\" class=\"form-control\">\r\n                                <option value=\"\" disabled=\"disabled\">" . lang("market_txt_144", true) . "</option>\r\n                                " . $currencies . "\r\n                            </select>\r\n                        </div>\r\n                    </div>\r\n                    \r\n                    <br />\r\n                    <input type=\"hidden\" name=\"item\" value=\"" . Encode($serial) . "\">\r\n                    <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                    " . $action . "\r\n                </form>\r\n            </div>";
                    } else {
                        echo "<div id=\"sell\">" . lang("market_txt_197", true) . "</div>";
                    }
                } else {
                    echo "<div id=\"sell\" style=\"display: none\"></div>";
                }
                if (mconfig("is_delete")) {
                    if ($delCheck != NULL || !empty($delCheck)) {
                        $displayDel = "block";
                    } else {
                        $displayDel = "none";
                    }
                    echo "\r\n            <div id=\"delete\" style=\"display: " . $displayDel . "\">\r\n                <form method=\"post\" action=\"" . __BASE_URL__ . "usercp/vault\">\r\n                    " . lang("market_txt_146", true) . "<br />\r\n                    <input type=\"hidden\" name=\"item\" value=\"" . Encode($serial) . "\">\r\n                    <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                    <input type=\"submit\" name=\"delete\" value=\"" . lang("market_txt_147", true) . "\" class=\"btn btn-danger\">\r\n                </form>\r\n            </div>";
                } else {
                    echo "<div id=\"delete\" style=\"display: none\"></div>";
                }
                if (mconfig("is_upgrade")) {
                    if ($upgrdCheck != NULL || !empty($upgrdCheckCheck)) {
                        $displayUpgrd = "block";
                    } else {
                        $displayUpgrd = "none";
                    }
                    echo "\r\n                <div id=\"upgrade\" style=\"display: " . $displayUpgrd . "\">";
                    $itemData = $this->getItemInfo($item["type"], $item["id"], $item["sticklevel"]);
                    $upgrd = "";
                    if (0 < $itemData["exc"]) {
                        echo "<form method=\"post\" action=\"" . __BASE_URL__ . "usercp/vault\">";
                        $operations = "";
                        $itemType = $this->returnItemType($item["type"], $item["id"]);
                        $itemTier = $itemData["class"] - 1;
                        $exc_non_exc = explode(",", mconfig("exc_non_exc_" . $itemType));
                        $exc_rand_opt = explode(",", mconfig("exc_rand_opt_" . $itemType));
                        $exc_max_opt = explode(",", mconfig("exc_max_opt_" . $itemType));
                        $exc_rand_price = explode(",", mconfig("exc_rand_price_" . $itemType));
                        $exc_price1 = explode(",", mconfig("exc_price1_" . $itemType));
                        $exc_price2 = explode(",", mconfig("exc_price2_" . $itemType));
                        $exc_price3 = explode(",", mconfig("exc_price3_" . $itemType));
                        $exc_price4 = explode(",", mconfig("exc_price4_" . $itemType));
                        $exc_price5 = explode(",", mconfig("exc_price5_" . $itemType));
                        $exc_price6 = explode(",", mconfig("exc_price6_" . $itemType));
                        $exc_price_type = explode(",", mconfig("exc_price_type_" . $itemType));
                        if ($itemType == "weapon") {
                            $skill_price = explode(",", mconfig("skill_price_" . $itemType));
                            $skill_price_type = explode(",", mconfig("skill_price_type_" . $itemType));
                        }
                        if ($itemType != "jewelry") {
                            $luck_price = explode(",", mconfig("luck_price_" . $itemType));
                            $luck_price_type = explode(",", mconfig("luck_price_type_" . $itemType));
                        }
                        if ($item["isanc"]) {
                            foreach ($exc_rand_price as $key => $value) {
                                $exc_rand_price[$key] = $exc_rand_price[$key] * mconfig("anc_price_rate");
                            }
                            foreach ($exc_price1 as $key => $value) {
                                $exc_price1[$key] = $exc_price1[$key] * mconfig("anc_price_rate");
                            }
                            foreach ($exc_price2 as $key => $value) {
                                $exc_price2[$key] = $exc_price2[$key] * mconfig("anc_price_rate");
                            }
                            foreach ($exc_price3 as $key => $value) {
                                $exc_price3[$key] = $exc_price3[$key] * mconfig("anc_price_rate");
                            }
                            foreach ($exc_price4 as $key => $value) {
                                $exc_price4[$key] = $exc_price4[$key] * mconfig("anc_price_rate");
                            }
                            foreach ($exc_price5 as $key => $value) {
                                $exc_price5[$key] = $exc_price5[$key] * mconfig("anc_price_rate");
                            }
                            foreach ($exc_price6 as $key => $value) {
                                $exc_price6[$key] = $exc_price6[$key] * mconfig("anc_price_rate");
                            }
                            foreach ($skill_price as $key => $value) {
                                $skill_price[$key] = $skill_price[$key] * mconfig("anc_price_rate");
                            }
                            foreach ($exc_price1 as $key => $value) {
                                $luck_price[$key] = $luck_price[$key] * mconfig("anc_price_rate");
                            }
                        }
                        if (0 < $itemData["exc"]) {
                            $exc_price_type = $this->upgradeItemPriceType($exc_price_type[$itemTier]);
                        }
                        if (0 < $itemData["skill"]) {
                            $skill_price_type = $this->upgradeItemPriceType($skill_price_type[$itemTier]);
                        }
                        if (0 < $itemData["luck"]) {
                            $luck_price_type = $this->upgradeItemPriceType($luck_price_type[$itemTier]);
                        }
                        if (0 < $itemData["exc"]) {
                            if (mconfig("enable_exc_" . $itemType)) {
                                $max_exc_opts = 0;
                                $current_exc_opts = 0;
                                if ($item["exc1_name"] != NULL && !empty($item["exc1_name"])) {
                                    $max_exc_opts++;
                                }
                                if ($item["exc2_name"] != NULL && !empty($item["exc2_name"])) {
                                    $max_exc_opts++;
                                }
                                if ($item["exc3_name"] != NULL && !empty($item["exc3_name"])) {
                                    $max_exc_opts++;
                                }
                                if ($item["exc4_name"] != NULL && !empty($item["exc4_name"])) {
                                    $max_exc_opts++;
                                }
                                if ($item["exc5_name"] != NULL && !empty($item["exc5_name"])) {
                                    $max_exc_opts++;
                                }
                                if ($item["exc6_name"] != NULL && !empty($item["exc6_name"])) {
                                    $max_exc_opts++;
                                }
                                if ($exc_max_opt[$itemTier] < $max_exc_opts) {
                                    $max_exc_opts = $exc_max_opt[$itemTier];
                                }
                                if ($item["exc1"]) {
                                    $current_exc_opts++;
                                }
                                if ($item["exc2"]) {
                                    $current_exc_opts++;
                                }
                                if ($item["exc3"]) {
                                    $current_exc_opts++;
                                }
                                if ($item["exc4"]) {
                                    $current_exc_opts++;
                                }
                                if ($item["exc5"]) {
                                    $current_exc_opts++;
                                }
                                if ($item["exc6"]) {
                                    $current_exc_opts++;
                                }
                                if ($current_exc_opts < $max_exc_opts) {
                                    if ($exc_rand_opt[$itemTier]) {
                                        $operations .= "<option value=\"" . Encode("exc_rand_opt") . "\">" . lang("market_txt_148", true) . " (" . $exc_rand_price[$itemTier] . " " . $exc_price_type["name"] . ")</option>";
                                    } else {
                                        if ($item["exc1_name"] != NULL && !empty($item["exc1_name"]) && $item["exc1"] == "0") {
                                            $operations .= "<option value=\"" . Encode("exc_opt_1") . "\">" . sprintf(lang("market_txt_149", true), $item["exc1_name"]) . " (" . $exc_price1[$itemTier] . " " . $exc_price_type["name"] . ")</option>";
                                        }
                                        if ($item["exc2_name"] != NULL && !empty($item["exc2_name"]) && $item["exc2"] == "0") {
                                            $operations .= "<option value=\"" . Encode("exc_opt_2") . "\">" . sprintf(lang("market_txt_149", true), $item["exc2_name"]) . " (" . $exc_price2[$itemTier] . " " . $exc_price_type["name"] . ")</option>";
                                        }
                                        if ($item["exc3_name"] != NULL && !empty($item["exc3_name"]) && $item["exc3"] == "0") {
                                            $operations .= "<option value=\"" . Encode("exc_opt_3") . "\">" . sprintf(lang("market_txt_149", true), $item["exc3_name"]) . " (" . $exc_price3[$itemTier] . " " . $exc_price_type["name"] . ")</option>";
                                        }
                                        if ($item["exc4_name"] != NULL && !empty($item["exc4_name"]) && $item["exc4"] == "0") {
                                            $operations .= "<option value=\"" . Encode("exc_opt_4") . "\">" . sprintf(lang("market_txt_149", true), $item["exc4_name"]) . " (" . $exc_price4[$itemTier] . " " . $exc_price_type["name"] . ")</option>";
                                        }
                                        if ($item["exc5_name"] != NULL && !empty($item["exc5_name"]) && $item["exc5"] == "0") {
                                            $operations .= "<option value=\"" . Encode("exc_opt_5") . "\">" . sprintf(lang("market_txt_149", true), $item["exc5_name"]) . " (" . $exc_price5[$itemTier] . " " . $exc_price_type["name"] . ")</option>";
                                        }
                                        if ($item["exc6_name"] != NULL && !empty($item["exc6_name"]) && $item["exc6"] == "0") {
                                            $operations .= "<option value=\"" . Encode("exc_opt_6") . "\">" . sprintf(lang("market_txt_149", true), $item["exc6_name"]) . " (" . $exc_price6[$itemTier] . " " . $exc_price_type["name"] . ")</option>";
                                        }
                                    }
                                }
                                if ($exc_non_exc[$itemTier] == "0" && $current_exc_opts == 0) {
                                    $operations = "";
                                }
                                if ($itemData["use_sockets"] && mconfig("enable_socket_exc") == "0") {
                                    $operations = "";
                                }
                                if ($item["isanc"] && mconfig("enable_anc_exc") == "0") {
                                    $operations = "";
                                }
                            }
                            if (mconfig("enable_skill_" . $itemType) && $itemData["skill"] && $item["skill2"] == "0") {
                                if ($item["isanc"]) {
                                    if (mconfig("enable_anc_skill")) {
                                        $operations .= "<option value=\"" . Encode("skill") . "\">" . lang("market_txt_150", true) . " (" . $skill_price[$itemTier] . " " . $skill_price_type["name"] . ")</option>";
                                    }
                                } else {
                                    if ($itemData["use_sockets"]) {
                                        if (mconfig("enable_socket_skill")) {
                                            $operations .= "<option value=\"" . Encode("skill") . "\">" . lang("market_txt_150", true) . " (" . $skill_price[$itemTier] . " " . $skill_price_type["name"] . ")</option>";
                                        }
                                    } else {
                                        $operations .= "<option value=\"" . Encode("skill") . "\">" . lang("market_txt_150", true) . " (" . $skill_price[$itemTier] . " " . $skill_price_type["name"] . ")</option>";
                                    }
                                }
                            }
                            if (mconfig("enable_luck_" . $itemType) && $itemData["luck"] && $item["luck2"] == "0") {
                                if ($item["isanc"]) {
                                    if (mconfig("enable_anc_luck")) {
                                        $operations .= "<option value=\"" . Encode("luck") . "\">" . lang("market_txt_151", true) . " (" . $luck_price[$itemTier] . " " . $luck_price_type["name"] . ")</option>";
                                    }
                                } else {
                                    if ($itemData["use_sockets"]) {
                                        if (mconfig("enable_socket_luck")) {
                                            $operations .= "<option value=\"" . Encode("luck") . "\">" . lang("market_txt_151", true) . " (" . $luck_price[$itemTier] . " " . $luck_price_type["name"] . ")</option>";
                                        }
                                    } else {
                                        $operations .= "<option value=\"" . Encode("luck") . "\">" . lang("market_txt_151", true) . " (" . $luck_price[$itemTier] . " " . $luck_price_type["name"] . ")</option>";
                                    }
                                }
                            }
                            $showButton = false;
                            if ($operations != NULL && !empty($operations)) {
                                $operations = "<option value=\"\" disabled=\"disabled\">" . lang("market_txt_152", true) . "</option>" . $operations;
                                $showButton = true;
                            }
                            if ($showButton) {
                                echo "\r\n                            <select id=\"operation_type\" name=\"operation_type\" class=\"form-control\">\r\n                              " . $operations . "\r\n                            </select>";
                                if ($item["type"] == "0") {
                                    $item["type"] = "00";
                                }
                                if ($item["id"] == "0") {
                                    $item["id"] = "00";
                                }
                                if ($item["sticklevel"] == "0") {
                                    $item["sticklevel"] = "00";
                                }
                                echo "\r\n                            <br />\r\n                            <input type=\"hidden\" name=\"item\" value=\"" . Encode($serial) . "\">\r\n                            <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                            <input type=\"hidden\" name=\"" . Encode("item_type") . "\" value=\"" . Encode($item["type"]) . "\">\r\n                            <input type=\"hidden\" name=\"" . Encode("item_id") . "\" value=\"" . Encode($item["id"]) . "\">\r\n                            <input type=\"hidden\" name=\"" . Encode("item_level") . "\" value=\"" . Encode($item["sticklevel"]) . "\">\r\n                            <input type=\"submit\" name=\"upgrade\" value=\"" . lang("market_txt_153", true) . "\" class=\"btn btn-warning\">\r\n                            ";
                            } else {
                                echo lang("market_txt_139", true);
                            }
                        }
                        echo "</form>";
                    } else {
                        echo lang("market_txt_139", true);
                    }
                    echo "</div>";
                } else {
                    echo "<div id=\"upgrade\" style=\"display: none\"></div>";
                }
                echo "\r\n        </div>\r\n    </div>";
            }
        }
    }
    public function getItemInfo($type, $id, $lvl)
    {
        global $dB;
        $type = xss_clean($type);
        $id = xss_clean($id);
        $lvl = xss_clean($lvl);
        return $dB->query_fetch_single("SELECT TOP 1 * FROM IMPERIAMUCMS_ITEMS WHERE type = ? AND id = ? AND level = ?", [$type, $id, $lvl]);
    }
    public function upgradeItemPriceType($type)
    {
        global $dB;
        global $dB2;
        $type = xss_clean($type);
        $return = [];
        switch ($type) {
            case 1:
                $return["column"] = "platinum";
                $return["table"] = "MEMB_CREDITS";
                $return["ident"] = "memb___id";
                $return["name"] = lang("currency_platinum", true);
                break;
            case 2:
                $return["column"] = "gold";
                $return["table"] = "MEMB_CREDITS";
                $return["ident"] = "memb___id";
                $return["name"] = lang("currency_gold", true);
                break;
            case 3:
                $return["column"] = "silver";
                $return["table"] = "MEMB_CREDITS";
                $return["ident"] = "memb___id";
                $return["name"] = lang("currency_silver", true);
                break;
            case 4:
                if (100 <= config("server_files_season", true)) {
                    $return["column"] = "WCoin";
                } else {
                    $return["column"] = "WCoinC";
                }
                $return["table"] = "T_InGameShop_Point";
                $return["ident"] = "AccountID";
                $return["name"] = lang("currency_wcoinc", true);
                break;
            case 5:
                $return["column"] = "GoblinPoint";
                $return["table"] = "T_InGameShop_Point";
                $return["ident"] = "AccountID";
                $return["name"] = lang("currency_gp", true);
                break;
            case 6:
                $return["column"] = "zen";
                $return["table"] = "IMPERIAMUCMS_WEB_BANK";
                $return["ident"] = "AccountID";
                $return["name"] = "" . lang("currency_zen", true) . "";
                break;
            case 7:
                $return["column"] = "bless";
                $return["table"] = "IMPERIAMUCMS_WEB_BANK";
                $return["ident"] = "AccountID";
                $return["name"] = "" . lang("currency_bless", true) . "";
                break;
            case 8:
                $return["column"] = "soul";
                $return["table"] = "IMPERIAMUCMS_WEB_BANK";
                $return["ident"] = "AccountID";
                $return["name"] = "" . lang("currency_soul", true) . "";
                break;
            case 9:
                $return["column"] = "life";
                $return["table"] = "IMPERIAMUCMS_WEB_BANK";
                $return["ident"] = "AccountID";
                $return["name"] = "" . lang("currency_life", true) . "";
                break;
            case 10:
                $return["column"] = "chaos";
                $return["table"] = "IMPERIAMUCMS_WEB_BANK";
                $return["ident"] = "AccountID";
                $return["name"] = "" . lang("currency_chaos", true) . "";
                break;
            case 11:
                $return["column"] = "harmony";
                $return["table"] = "IMPERIAMUCMS_WEB_BANK";
                $return["ident"] = "AccountID";
                $return["name"] = "" . lang("currency_harmony", true) . "";
                break;
            case 12:
                $return["column"] = "creation";
                $return["table"] = "IMPERIAMUCMS_WEB_BANK";
                $return["ident"] = "AccountID";
                $return["name"] = "" . lang("currency_creation", true) . "";
                break;
            case 13:
                $return["column"] = "guardian";
                $return["table"] = "IMPERIAMUCMS_WEB_BANK";
                $return["ident"] = "AccountID";
                $return["name"] = "" . lang("currency_guardian", true) . "";
                break;
            default:
                $customItem = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_WEB_BANK_CUSTOM WHERE ident = ?", [$type]);
                $return["column"] = str_replace(" ", "_", $customItem["name"]);
                $return["table"] = "IMPERIAMUCMS_WEB_BANK";
                $return["ident"] = "AccountID";
                $return["name"] = $customItem["name"];
                return $return;
        }
    }
    public function returnItemType($cat, $index)
    {
        $cat = xss_clean($cat);
        $index = xss_clean($index);
        if (0 <= $cat && $cat <= 6) {
            return "weapon";
        }
        if (7 <= $cat && $cat <= 11) {
            return "set";
        }
        if ($cat == 12 && (0 <= $index && $index <= 6 || 36 <= $index && $index <= 43 || 49 <= $index && $index <= 50 || 262 <= $index && $index <= 268) || $cat == 13 && $index == 30) {
            return "wings";
        }
        if ($cat == 13) {
            return "jewelry";
        }
        return "unknown";
    }
    public function webBankAddCustomItem($name, $hex, $limit, $type, $ident)
    {
        global $dB;
        if (check_value($name) && check_value($hex) && check_value($limit) && check_value($type) && check_value($ident)) {
            if (!is_numeric($limit) || $limit < 1) {
                message("error", "Invalid limit.");
                return NULL;
            }
            $name2 = str_replace(" ", "_", $name);
            $save = $dB->query("INSERT INTO IMPERIAMUCMS_WEB_BANK_CUSTOM(name,hex,limit,type,ident) VALUES(?,?,?,?,?)", [$name, $hex, $limit, $type, $ident]);
            $alter = $dB->query("If Not Exists (Select Column_Name\r\n                                From INFORMATION_SCHEMA.COLUMNS\r\n                                Where Table_Name = 'IMPERIAMUCMS_WEB_BANK'\r\n                                And Column_Name = '" . $name2 . "')\r\n                                begin\r\n                                ALTER TABLE IMPERIAMUCMS_WEB_BANK ADD [" . $name2 . "] bigint DEFAULT(0) NOT NULL\r\n                                end");
            if ($save && $alter) {
                message("success", "Custom item successfully added!");
            } else {
                message("error", "There has been an error while adding the item.");
            }
        } else {
            message("error", "Missing data (complete all fields).");
        }
    }
    public function webBankGuildAddCustomItem($name, $hex, $limit, $type, $ident)
    {
        global $dB;
        if (check_value($name) && check_value($hex) && check_value($limit) && check_value($type) && check_value($ident)) {
            if (!is_numeric($limit) || $limit < 1) {
                message("error", "Invalid limit.");
                return NULL;
            }
            $name2 = str_replace(" ", "_", $name);
            $save = $dB->query("INSERT INTO IMPERIAMUCMS_WEB_BANK_GUILD_CUSTOM(name,hex,limit,type,ident) VALUES(?,?,?,?,?)", [$name, $hex, $limit, $type, $ident]);
            $alter = $dB->query("If Not Exists (Select Column_Name\r\n                                From INFORMATION_SCHEMA.COLUMNS\r\n                                Where Table_Name = 'IMPERIAMUCMS_WEB_BANK'\r\n                                And Column_Name = '" . $name2 . "')\r\n                                begin\r\n                                ALTER TABLE IMPERIAMUCMS_WEB_BANK_GUILD ADD [" . $name2 . "] bigint DEFAULT(0) NOT NULL\r\n                                end");
            if ($save && $alter) {
                message("success", "Custom item successfully added!");
            } else {
                message("error", "There has been an error while adding the item.");
            }
        } else {
            message("error", "Missing data (complete all fields).");
        }
    }
    public function webBankEditCustomItem($id, $hex, $limit, $type, $ident)
    {
        global $dB;
        if (check_value($id) && check_value($hex) && check_value($limit) && check_value($type) && check_value($ident)) {
            if (!is_numeric($limit) || $limit < 1) {
                message("error", "Invalid limit.");
                return NULL;
            }
            $save = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK_CUSTOM SET hex = ?, limit = ?, type = ?, ident = ? WHERE id = ?", [$hex, $limit, $type, $ident, $id]);
            if ($save) {
                message("success", "Custom item successfully edited!");
            } else {
                message("error", "There has been an error while editing the item.");
            }
        } else {
            message("error", "Missing data (complete all fields).");
        }
    }
    public function webBankGuildEditCustomItem($id, $hex, $limit, $type, $ident)
    {
        global $dB;
        if (check_value($id) && check_value($hex) && check_value($limit) && check_value($type) && check_value($ident)) {
            if (!is_numeric($limit) || $limit < 1) {
                message("error", "Invalid limit.");
                return NULL;
            }
            $save = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK_GUILD_CUSTOM SET hex = ?, limit = ?, type = ?, ident = ? WHERE id = ?", [$hex, $limit, $type, $ident, $id]);
            if ($save) {
                message("success", "Custom item successfully edited!");
            } else {
                message("error", "There has been an error while editing the item.");
            }
        } else {
            message("error", "Missing data (complete all fields).");
        }
    }
    public function webBankDeleteCustomItem($id)
    {
        global $dB;
        if (check_value($id)) {
            $name = $dB->query_fetch_single("SELECT name FROM IMPERIAMUCMS_WEB_BANK_CUSTOM WHERE id = ?", [$id]);
            $update = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET " . str_replace(" ", "_", $name["name"]) . " = 0");
            $delete = $dB->query("DELETE FROM IMPERIAMUCMS_WEB_BANK_CUSTOM WHERE id = ?", [$id]);
            if ($update && $delete) {
                message("success", "Custom item successfully deleted!");
            } else {
                message("error", "There has been an error while deleting the item.");
            }
        } else {
            message("error", "Missing data (complete all fields).");
        }
    }
    public function webBankGuildDeleteCustomItem($id)
    {
        global $dB;
        if (check_value($id)) {
            $name = $dB->query_fetch_single("SELECT name FROM IMPERIAMUCMS_WEB_BANK_GUILD_CUSTOM WHERE id = ?", [$id]);
            $update = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK_GUILD SET " . str_replace(" ", "_", $name["name"]) . " = 0");
            $delete = $dB->query("DELETE FROM IMPERIAMUCMS_WEB_BANK_GUILD_CUSTOM WHERE id = ?", [$id]);
            if ($update && $delete) {
                message("success", "Custom item successfully deleted!");
            } else {
                message("error", "There has been an error while deleting the item.");
            }
        } else {
            message("error", "Missing data (complete all fields).");
        }
    }
    public function findAllCustomItems($username, $char, $hex, $type)
    {
        global $dB;
        $hex = xss_clean($hex);
        $type = xss_clean($type);
        if (check_value($username) && check_value($hex) && check_value($type)) {
            if (!Validator::UsernameLength($username)) {
                $error = true;
            }
            if (!Validator::AlphaNumeric($username)) {
                $error = true;
            }
            if (strlen($hex) != __ITEM_LENGTH__) {
                $error = true;
            }
            if (!$error) {
                $totalCount = 0;
                if ($type == "1") {
                    $vault = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT Items FROM warehouse WHERE AccountID = '" . $username . "'), 2) AS vault");
                    $sizeWhile = 120;
                    $i = 0;
                } else {
                    if ($type == "2") {
                        $vault = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT Inventory FROM Character WHERE AccountID = '" . $username . "' AND Name = '" . $char . "'), 2) AS vault");
                        $sizeWhile = 236;
                        $i = 12;
                    }
                }
                $vault = $vault["vault"];
                while ($i < $sizeWhile) {
                    $item = substr($vault, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                    $item = substr_replace($item, "00000000", 6, 8);
                    $item = substr_replace($item, "00000000", 32, 8);
                    $hex = substr_replace($hex, "00000000", 6, 8);
                    $hex = substr_replace($hex, "00000000", 32, 8);
                    if ($item == $hex) {
                        $totalCount++;
                    }
                    $i++;
                }
                return $totalCount;
            }
            message("error", lang("error_23", true));
        } else {
            message("error", lang("error_23", true));
        }
    }
    public function insertCustomItem($username, $char, $item, $amount)
    {
        global $dB;
        global $common;
        $item = xss_clean($item);
        $amount = xss_clean($amount);
        if (check_value($username) && check_value($item) && check_value($amount)) {
            if (!Validator::UnsignedNumber($amount) || $amount < 1) {
                $error = true;
            }
            if (!Validator::UsernameLength($username)) {
                $error = true;
            }
            if (!Validator::AlphaNumeric($username)) {
                $error = true;
            }
            if (!$error) {
                if (!$common->accountOnline($username)) {
                    if (!$this->duplicatedItemsVault($username)) {
                        $itemName = str_replace("_", " ", $item);
                        $itemData = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_WEB_BANK_CUSTOM WHERE name = ?", [$itemName]);
                        $items = $this->findAllCustomItems($username, $char, $itemData["hex"], $itemData["type"]);
                        if ($itemData["type"] == 2 && $char == NULL) {
                            message("error", lang("error_23", true));
                            return NULL;
                        }
                        if ($this->canInsertItems($username, $char, $itemData["hex"], $items, $amount)) {
                            message("success", lang("market_txt_154", true));
                            $logDate = date("Y-m-d H:i:s", time());
                            if ($itemData["type"] == 1) {
                                $common->accountLogs($username, "webbank", sprintf(lang("market_txt_155", true), $amount, ucfirst($itemName)), $logDate);
                            } else {
                                if ($itemData["type"] == 2) {
                                    $common->accountLogs($username, "webbank", sprintf(lang("market_txt_156", true), $amount, ucfirst($itemName), $char), $logDate);
                                }
                            }
                        }
                    } else {
                        message("error", lang("market_txt_9", true));
                    }
                } else {
                    message("error", lang("error_14", true));
                }
            } else {
                message("error", lang("error_23", true));
            }
        } else {
            message("error", lang("error_23", true));
        }
    }
    public function canInsertItems($username, $char, $hex, $items, $amount)
    {
        global $dB;
        $amount = xss_clean($amount);
        $hex = xss_clean($hex);
        $items = xss_clean($items);
        if (check_value($username) && check_value($hex) && check_value($items) && check_value($amount)) {
            if (!Validator::UnsignedNumber($amount) || $amount < 1) {
                $error = true;
            }
            if (!Validator::UsernameLength($username)) {
                $error = true;
            }
            if (!Validator::AlphaNumeric($username)) {
                $error = true;
            }
            if (!$error) {
                $itemData = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_WEB_BANK_CUSTOM WHERE hex = ?", [$hex]);
                if ($amount <= $items) {
                    $BankData = $this->getBankData($username);
                    $itemName = str_replace(" ", "_", $itemData["name"]);
                    if ($itemData["limit"] < $BankData[$itemName] + $amount) {
                        message("error", lang("market_txt_157", true));
                    } else {
                        $amount_tmp = $amount;
                        if ($itemData["type"] == "1") {
                            $vault = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT Items FROM warehouse WHERE AccountID = '" . $username . "'), 2) AS vault");
                            $vault = $vault["vault"];
                            $from = 0;
                            $to = 120;
                        } else {
                            if ($itemData["type"] == "2") {
                                $vault = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT Inventory FROM Character WHERE AccountID = '" . $username . "' AND Name = '" . $char . "'), 2) AS inventory");
                                $vault = $vault["inventory"];
                                $from = 12;
                                $to = 236;
                            }
                        }
                        $newVault = $vault;
                        $i = $from;
                        while ($i < $to) {
                            $item = substr($vault, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                            $item = substr_replace($item, "00000000", 6, 8);
                            $item = substr_replace($item, "00000000", 32, 8);
                            $hex = substr_replace($hex, "00000000", 6, 8);
                            $hex = substr_replace($hex, "00000000", 32, 8);
                            if (0 < $amount_tmp && $item == $hex) {
                                $newVault = substr_replace($newVault, __ITEM_EMPTY__, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                                $amount_tmp--;
                            }
                            $i++;
                        }
                        if ($amount_tmp == 0) {
                            $newVault = "0x" . $newVault;
                            if ($itemData["type"] == "1") {
                                $update = $dB->query("UPDATE warehouse SET Items = " . $newVault . " WHERE AccountID = '" . $username . "'");
                            } else {
                                if ($itemData["type"] == "2") {
                                    $update = $dB->query("UPDATE Character SET Inventory = " . $newVault . " WHERE AccountID = '" . $username . "' AND Name = '" . $char . "'");
                                }
                            }
                            $update2 = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET " . $itemName . " = " . $itemName . " + " . $amount . " WHERE AccountID = '" . $username . "'");
                            if ($update && $update2) {
                                return true;
                            }
                            message("error", lang("error_23", true));
                            return false;
                        }
                        message("error", sprintf(lang("market_txt_158", true), $itemData["name"]));
                        return false;
                    }
                } else {
                    if ($itemData["type"] == 1) {
                        message("error", sprintf(lang("market_txt_159", true), $itemData["name"]));
                    } else {
                        if ($itemData["type"] == 2) {
                            message("error", sprintf(lang("market_txt_160", true), $itemData["name"], $char));
                        }
                    }
                }
            } else {
                message("error", lang("error_23", true));
            }
        } else {
            message("error", lang("error_23", true));
        }
    }
    public function withdrawCustomItem($username, $char, $item, $amount)
    {
        global $dB;
        global $common;
        $Items = new Items();
        $amount = xss_clean($amount);
        $item = xss_clean($item);
        if (check_value($username) && check_value($item) && check_value($amount)) {
            if (!Validator::UnsignedNumber($amount)) {
                $error = true;
            }
            if (!Validator::UsernameLength($username)) {
                $error = true;
            }
            if (!Validator::AlphaNumeric($username)) {
                $error = true;
            }
            if ($amount < 1) {
                $error = true;
            }
            if (!$error) {
                if (!$common->accountOnline($username)) {
                    $itemData = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_WEB_BANK_CUSTOM WHERE name = ?", [str_replace("_", " ", $item)]);
                    $itemName = str_replace(" ", "_", $itemData["name"]);
                    $BankData = $this->getBankData($username);
                    if ($BankData[$itemName] < $amount) {
                        message("error", sprintf(lang("market_txt_161", true), $itemData["name"]));
                    } else {
                        $amount_tmp = $amount;
                        if ($itemData["type"] == "1") {
                            $vault = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT Items FROM warehouse WHERE AccountID = '" . $username . "'), 2) AS vault");
                        } else {
                            if ($itemData["type"] == "2") {
                                $vault = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT Inventory FROM Character WHERE AccountID = '" . $username . "' AND Name = '" . $char . "'), 2) AS vault");
                            }
                        }
                        $vault = $vault["vault"];
                        $newVault = $vault;
                        $itemInfo = $Items->ItemInfo($itemData["hex"]);
                        $item_err = false;
                        while (0 < $amount_tmp) {
                            $newitem = $itemData["hex"];
                            $test = 0;
                            if ($itemData["type"] == "1") {
                                $slot = $this->smartsearch2($username, $newVault, $itemInfo["X"], $itemInfo["Y"]);
                            } else {
                                if ($itemData["type"] == "2") {
                                    $slot = $this->smartsearchInventory($username, $char, $newVault, $itemInfo["X"], $itemInfo["Y"]);
                                }
                            }
                            $test = $slot * __ITEM_LENGTH__;
                            if ($slot == 1337) {
                                message("error", lang("market_txt_84", true));
                                $item_err = true;
                            } else {
                                $serial = $dB->query_fetch_single("exec WZ_GetItemSerial2 1");
                                $serial = $serial["ItemSerial"];
                                $serial = dechex($serial);
                                while (strlen($serial) < 16) {
                                    $serial = "0" . $serial;
                                }
                                $serial2 = substr($serial, 0, 8);
                                $serial = substr($serial, 8, 8);
                                $newitem = substr_replace($newitem, $serial2, 6, 8);
                                $newitem = substr_replace($newitem, $serial, 32, 8);
                                $newVault = substr_replace($newVault, $newitem, $test, __ITEM_LENGTH__);
                                $amount_tmp--;
                            }
                        }
                        if (!$item_err && $amount_tmp == 0) {
                            $newVault = "0x" . $newVault;
                            if ($itemData["type"] == "1") {
                                $update = $dB->query("UPDATE warehouse SET Items = " . $newVault . " WHERE AccountID = '" . $username . "'");
                            } else {
                                if ($itemData["type"] == "2") {
                                    $update = $dB->query("UPDATE Character SET Inventory = " . $newVault . " WHERE AccountID = '" . $username . "' AND Name = '" . $char . "'");
                                }
                            }
                            $update2 = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET " . $itemName . " = " . $itemName . " - " . $amount . " WHERE AccountID = '" . $username . "'");
                            if ($update && $update2) {
                                message("success", sprintf(lang("market_txt_162", true), $amount, $itemData["name"]));
                                $logDate = date("Y-m-d H:i:s", time());
                                if ($itemData["type"] == "1") {
                                    $common->accountLogs($username, "webbank", sprintf(lang("market_txt_163", true), $amount, ucfirst($itemData["name"])), $logDate);
                                } else {
                                    if ($itemData["type"] == "2") {
                                        $common->accountLogs($username, "webbank", sprintf(lang("market_txt_164", true), $amount, ucfirst($itemData["name"]), $char), $logDate);
                                    }
                                }
                            } else {
                                message("error", lang("error_23", true));
                            }
                        } else {
                            message("error", sprintf(lang("market_txt_165", true), $itemData["name"]));
                        }
                    }
                } else {
                    message("error", lang("error_14", true));
                }
            } else {
                message("error", lang("error_23", true));
            }
        } else {
            message("error", lang("error_23", true));
        }
    }
    public function extendItem($marketId, $username)
    {
        global $dB;
        global $dB2;
        $marketId = Decode($marketId);
        if (!check_value($username)) {
            message("error", lang("error_4", true));
        } else {
            if (!Validator::UsernameLength($username)) {
                message("error", lang("error_5", true));
            } else {
                if (!Validator::AlphaNumeric($username)) {
                    message("error", lang("error_6", true));
                } else {
                    if (!is_numeric($marketId)) {
                        return NULL;
                    }
                    mconfig("tax_type");
                    switch (mconfig("tax_type")) {
                        case 1:
                            $return["column"] = "platinum";
                            $return["table"] = "MEMB_CREDITS";
                            $return["ident"] = "memb___id";
                            $return["name"] = lang("currency_platinum", true);
                            break;
                        case 2:
                            $return["column"] = "gold";
                            $return["table"] = "MEMB_CREDITS";
                            $return["ident"] = "memb___id";
                            $return["name"] = lang("currency_gold", true);
                            break;
                        case 3:
                            $return["column"] = "silver";
                            $return["table"] = "MEMB_CREDITS";
                            $return["ident"] = "memb___id";
                            $return["name"] = lang("currency_silver", true);
                            break;
                        case 4:
                            if (100 <= config("server_files_season", true)) {
                                $return["column"] = "WCoin";
                            } else {
                                $return["column"] = "WCoinC";
                            }
                            $return["table"] = "T_InGameShop_Point";
                            $return["ident"] = "AccountID";
                            $return["name"] = lang("currency_wcoinc", true);
                            break;
                        case 5:
                            $return["column"] = "GoblinPoint";
                            $return["table"] = "T_InGameShop_Point";
                            $return["ident"] = "AccountID";
                            $return["name"] = lang("currency_gp", true);
                            break;
                        case 6:
                            $return["column"] = "zen";
                            $return["table"] = "IMPERIAMUCMS_WEB_BANK";
                            $return["ident"] = "AccountID";
                            $return["name"] = "" . lang("currency_zen", true) . "";
                            break;
                        default:
                            if (config("MEMB_CREDITS_MEMUONLINE", true) && ($return["column"] == "platinum" || $return["column"] == "gold" || $return["column"] == "silver")) {
                                $checkCurrency = $dB2->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$username]);
                            } else {
                                $checkCurrency = $dB->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$username]);
                            }
                            if ($checkCurrency[$return["column"]] < mconfig("extend_price")) {
                                message("error", sprintf(lang("market_txt_118", true), $return["name"]));
                            } else {
                                $update = $dB->query("UPDATE IMPERIAMUCMS_MARKET SET Extend = 1 WHERE id = ?", [$marketId]);
                                if ($update) {
                                    $update2 = $dB->query("UPDATE " . $return["table"] . " SET " . $return["column"] . " = " . $return["column"] . " - ?  WHERE " . $return["ident"] . " = ?", [mconfig("extend_price"), $username]);
                                    if ($update2) {
                                        message("success", lang("market_txt_216", true));
                                    } else {
                                        message("error", lang("error_23", true));
                                    }
                                } else {
                                    message("error", lang("error_23", true));
                                }
                            }
                    }
                }
            }
        }
    }
}

?>