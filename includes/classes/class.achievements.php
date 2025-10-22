<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class Achievements
{
    public function loadXML($xml)
    {
        $achievements = [];
        if ($xml !== false) {
            $i = 1;
            foreach ($xml->achievements->children() as $tag => $ach) {
                if ($tag == "achievement") {
                    $achievements[$i]["uid"] = trim($ach->uid);
                    $achievements[$i]["type"] = trim($ach->type);
                    $achievements[$i]["name"] = trim($ach->name);
                    $achievements[$i]["img"] = trim($ach->img);
                    $achievements[$i]["class"] = trim($ach->class);
                    $achievements[$i]["req_lvl"] = trim($ach->req_lvl);
                    $achievements[$i]["req_mlvl"] = trim($ach->req_mlvl);
                    $achievements[$i]["req_reset"] = trim($ach->req_reset);
                    $achievements[$i]["req_greset"] = trim($ach->req_greset);
                    if ($achievements[$i]["req_lvl"] == NULL) {
                        $achievements[$i]["req_lvl"] = 0;
                    }
                    if ($achievements[$i]["req_mlvl"] == NULL) {
                        $achievements[$i]["req_mlvl"] = 0;
                    }
                    if ($achievements[$i]["req_reset"] == NULL) {
                        $achievements[$i]["req_reset"] = 0;
                    }
                    if ($achievements[$i]["req_greset"] == NULL) {
                        $achievements[$i]["req_greset"] = 0;
                    }
                    $achievements[$i]["total_stages"] = trim($ach->total_stages);
                    $achievements[$i]["stage"] = [];
                    $x = 1;
                    while ($x <= $achievements[$i]["total_stages"]) {
                        $stage = NULL;
                        $monsters = NULL;
                        $monsters_count = NULL;
                        $items = NULL;
                        $items_count = NULL;
                        $rew_items = NULL;
                        $rew_items_count = NULL;
                        $stage = [];
                        $curr_stage = "stage" . $x;
                        $stage["desc"] = trim($ach->{$curr_stage}->desc);
                        if ($achievements[$i]["type"] == "0") {
                            $monsters = [];
                            $monsters_count = [];
                            $k = 1;
                            foreach ($ach->{$curr_stage}->monsters->children() as $tag => $monster) {
                                if ($tag == "monster") {
                                    $monsters[$k] = trim($monster);
                                    $monsters_count[$k] = intval($monster["count"]);
                                }
                                $k++;
                            }
                        } else {
                            if ($achievements[$i]["type"] == "1") {
                                $stage["zen"] = trim($ach->{$curr_stage}->zen);
                            } else {
                                if ($achievements[$i]["type"] == "2" || $achievements[$i]["type"] == "3" || $achievements[$i]["type"] == "4" || $achievements[$i]["type"] == "6" || $achievements[$i]["type"] == "7" || $achievements[$i]["type"] == "8" || $achievements[$i]["type"] == "9" || $achievements[$i]["type"] == "10" || $achievements[$i]["type"] == "11" || $achievements[$i]["type"] == "12" || $achievements[$i]["type"] == "13") {
                                    $stage["exp"] = trim($ach->{$curr_stage}->exp);
                                } else {
                                    if ($achievements[$i]["type"] == "5") {
                                        $items = [];
                                        $items_count = [];
                                        $k = 1;
                                        foreach ($ach->{$curr_stage}->items->children() as $tag => $item) {
                                            if ($tag == "item") {
                                                $items[$k] = trim($item);
                                                $items_count[$k] = intval($item["count"]);
                                            }
                                            $k++;
                                        }
                                    }
                                }
                            }
                        }
                        $stage["reward_type"] = trim($ach->{$curr_stage}->reward_type);
                        if ($stage["reward_type"] == "7") {
                            $rew_items = [];
                            $rew_items_count = [];
                            $m = 1;
                            foreach ($ach->{$curr_stage}->reward->children() as $tag => $item) {
                                if ($tag == "item") {
                                    $rew_items[$m] = trim($item);
                                    $rew_items_count[$m] = intval($item["count"]);
                                }
                                $m++;
                            }
                        } else {
                            $stage["reward"] = trim($ach->{$curr_stage}->reward);
                        }
                        $stage["points"] = trim($ach->{$curr_stage}->points);
                        $achievements[$i]["stage"][$x] = $stage;
                        $achievements[$i]["stage"][$x]["monsters"] = $monsters;
                        $achievements[$i]["stage"][$x]["monsters_count"] = $monsters_count;
                        $achievements[$i]["stage"][$x]["items"] = $items;
                        $achievements[$i]["stage"][$x]["items_count"] = $items_count;
                        $achievements[$i]["stage"][$x]["rew_items"] = $rew_items;
                        $achievements[$i]["stage"][$x]["rew_items_count"] = $rew_items_count;
                        $x++;
                    }
                    $i++;
                }
            }
            return $achievements;
        } else {
            message("error", lang("achievement_error_1", true));
        }
    }
    public function loadXMLforArray($xml)
    {
        $achievements = [];
        if ($xml !== false) {
            $i = 1;
            foreach ($xml->achievements->children() as $tag => $ach) {
                if ($tag == "achievement") {
                    $achievements[$i]["uid"] = trim($ach->uid);
                    $achievements[$i]["type"] = trim($ach->type);
                    $achievements[$i]["name"] = trim($ach->name);
                    $achievements[$i]["img"] = trim($ach->img);
                    $achievements[$i]["class"] = trim($ach->class);
                    $achievements[$i]["req_lvl"] = trim($ach->req_lvl);
                    $achievements[$i]["req_mlvl"] = trim($ach->req_mlvl);
                    $achievements[$i]["req_reset"] = trim($ach->req_reset);
                    $achievements[$i]["req_greset"] = trim($ach->req_greset);
                    if ($achievements[$i]["req_lvl"] == NULL) {
                        $achievements[$i]["req_lvl"] = 0;
                    }
                    if ($achievements[$i]["req_mlvl"] == NULL) {
                        $achievements[$i]["req_mlvl"] = 0;
                    }
                    if ($achievements[$i]["req_reset"] == NULL) {
                        $achievements[$i]["req_reset"] = 0;
                    }
                    if ($achievements[$i]["req_greset"] == NULL) {
                        $achievements[$i]["req_greset"] = 0;
                    }
                    $achievements[$i]["total_stages"] = trim($ach->total_stages);
                    $x = 1;
                    while ($x <= $achievements[$i]["total_stages"]) {
                        $stage = NULL;
                        $monsters = NULL;
                        $monsters_count = NULL;
                        $items = NULL;
                        $items_count = NULL;
                        $rew_items = NULL;
                        $rew_items_count = NULL;
                        $stage = [];
                        $curr_stage = "stage" . $x;
                        $stage["desc"] = trim($ach->{$curr_stage}->desc);
                        if ($achievements[$i]["type"] == "0") {
                            $monsters = [];
                            $monsters_count = [];
                            $k = 1;
                            foreach ($ach->{$curr_stage}->monsters->children() as $tag => $monster) {
                                if ($tag == "monster") {
                                    $monsters[$k] = trim($monster);
                                    $monsters_count[$k] = intval($monster["count"]);
                                }
                                $k++;
                            }
                        } else {
                            if ($achievements[$i]["type"] == "1") {
                                $stage["zen"] = trim($ach->{$curr_stage}->zen);
                            } else {
                                if ($achievements[$i]["type"] == "2" || $achievements[$i]["type"] == "3" || $achievements[$i]["type"] == "4" || $achievements[$i]["type"] == "6" || $achievements[$i]["type"] == "7" || $achievements[$i]["type"] == "8" || $achievements[$i]["type"] == "9" || $achievements[$i]["type"] == "10" || $achievements[$i]["type"] == "11" || $achievements[$i]["type"] == "12" || $achievements[$i]["type"] == "13") {
                                    $stage["exp"] = trim($ach->{$curr_stage}->exp);
                                } else {
                                    if ($achievements[$i]["type"] == "5") {
                                        $items = [];
                                        $items_count = [];
                                        $k = 1;
                                        foreach ($ach->{$curr_stage}->items->children() as $tag => $item) {
                                            if ($tag == "item") {
                                                $items[$k] = trim($item);
                                                $items_count[$k] = intval($item["count"]);
                                            }
                                            $k++;
                                        }
                                    }
                                }
                            }
                        }
                        $stage["reward_type"] = trim($ach->{$curr_stage}->reward_type);
                        if ($stage["reward_type"] == "7") {
                            $rew_items = [];
                            $rew_items_count = [];
                            $m = 1;
                            foreach ($ach->{$curr_stage}->reward->children() as $tag => $item) {
                                if ($tag == "item") {
                                    $rew_items[$m] = trim($item);
                                    $rew_items_count[$m] = intval($item["count"]);
                                }
                                $m++;
                            }
                        } else {
                            $stage["reward"] = trim($ach->{$curr_stage}->reward);
                        }
                        $stage["points"] = trim($ach->{$curr_stage}->points);
                        $achievements[$i]["stage"][$x] = $stage;
                        $achievements[$i]["stage"][$x]["monsters"] = $monsters;
                        $achievements[$i]["stage"][$x]["monsters_count"] = $monsters_count;
                        $achievements[$i]["stage"][$x]["items"] = $items;
                        $achievements[$i]["stage"][$x]["items_count"] = $items_count;
                        $achievements[$i]["stage"][$x]["rew_items"] = $rew_items;
                        $achievements[$i]["stage"][$x]["rew_items_count"] = $rew_items_count;
                        $x++;
                    }
                    $i++;
                }
            }
            return $achievements;
        } else {
            message("error", lang("achievement_error_1", true));
        }
    }
    public function arrayToXML($array)
    {
        $sxe = new SimpleXMLElement("<achievement_system/>");
        $achievements = $sxe->addChild("achievements");
        $i = 1;
        foreach ($array as $thisAch) {
            $j = 1;
            $achievement = $achievements->addChild("achievement");
            $achievement->addChild("uid", $thisAch["uid"]);
            $achievement->addChild("type", $thisAch["type"]);
            $achievement->addChild("name", $thisAch["name"]);
            $achievement->addChild("img", $thisAch["img"]);
            $achievement->addChild("class", $thisAch["class"]);
            $achievement->addChild("total_stages", $thisAch["total_stages"]);
            $achievement->addChild("req_lvl", $thisAch["req_lvl"]);
            $achievement->addChild("req_mlvl", $thisAch["req_mlvl"]);
            $achievement->addChild("req_reset", $thisAch["req_reset"]);
            $achievement->addChild("req_greset", $thisAch["req_greset"]);
            foreach ($thisAch["stage"] as $thisStage) {
                $k = 1;
                $l = 1;
                $m = 1;
                $stage = $achievement->addChild("stage" . $j);
                $stage->addChild("desc", $thisStage["desc"]);
                if ($thisAch["type"] == "0") {
                    $monsters = $stage->addChild("monsters");
                    foreach ($thisStage["monsters"] as $thisMonster) {
                        $monster = $monsters->addChild("monster", $thisMonster);
                        $monster->addAttribute("count", $thisStage["monsters_count"][$k]);
                        $k++;
                    }
                } else {
                    if ($thisAch["type"] == "1") {
                        $stage->addChild("zen", $thisStage["zen"]);
                    } else {
                        if ($thisAch["type"] == "5") {
                            $items = $stage->addChild("items");
                            foreach ($thisStage["items"] as $thisItem) {
                                $item = $items->addChild("item", $thisItem);
                                $item->addAttribute("count", $thisStage["items_count"][$l]);
                                $l++;
                            }
                        } else {
                            $stage->addChild("exp", $thisStage["exp"]);
                        }
                    }
                }
                $stage->addChild("reward_type", $thisStage["reward_type"]);
                if ($thisStage["reward_type"] == "7") {
                    $reward = $stage->addChild("reward");
                    foreach ($thisStage["rew_items"] as $thisItem) {
                        $item = $reward->addChild("item", $thisItem);
                        $item->addAttribute("count", $thisStage["rew_items_count"][$m]);
                        $m++;
                    }
                } else {
                    $stage->addChild("reward", $thisStage["reward"]);
                }
                $stage->addChild("points", $thisStage["points"]);
                $j++;
            }
            $i++;
        }
        return $sxe->asXML();
    }
    public function autoUnlock($username, $char)
    {
        global $dB;
        global $common;
        if (!check_value($username)) {
            message("error", lang("error_4", true));
        } else {
            if (!check_value($char)) {
                message("error", lang("error_4", true));
            } else {
                if (!Validator::UsernameLength($username)) {
                    message("error", lang("error_5", true));
                } else {
                    if (!Validator::AlphaNumeric($username)) {
                        message("error", lang("error_6", true));
                    } else {
                        $Character = new Character();
                        if ($Character->CharacterExists($char) && $Character->CharacterBelongsToAccount($char, $_SESSION["username"])) {
                            if ($common->accountOnline($username)) {
                                message("error", lang("error_14", true));
                                return NULL;
                            }
                            $charData = $dB->query_fetch_single("SELECT AccountID, Name, cLevel, LevelUpPoint, Class, Experience, Strength, Dexterity, Vitality, Energy, CONVERT(VARCHAR(MAX), MagicList, 2) AS MagicList, Money, Life, MaxLife, Mana, MaxMana, MapNumber, MapPosX, MapPosY, PkCount, PkLevel, PkTime, MDate, LDate, CtlCode, CONVERT(VARCHAR(MAX), Quest, 2) AS Quest, Leadership, ChatLimitTime, FruitPoint, RESETS, CONVERT(VARCHAR(MAX), Inventory, 2) AS Inventory, Married, MarryName, mLevel, mlPoint, mlExperience, mlNextExp, InventoryExpansion, WinDuels, LoseDuels, Grand_Resets FROM Character WHERE AccountID = ? AND Name = ?", [$username, $char]);
                            $data = $this->unlockData($username, $char);
                            if ($data["Unlock"] == "0") {
                                if (mconfig("level") <= $charData["cLevel"] && mconfig("mlevel") <= $charData["mLevel"] && mconfig("reset") <= $charData["RESETS"] && mconfig("greset") <= $charData["Grand_Resets"]) {
                                    $query = $dB->query("UPDATE IMPERIAMUCMS_ACHIEVEMENTS_UNLOCK SET Unlock = ? WHERE AccountID = ? AND Name = ?", ["1", $username, $char]);
                                    if ($query) {
                                        message("success", lang("achievement_txt_1", true));
                                        $logDate = date("Y-m-d H:i:s", time());
                                        $common->accountLogs($username, "achievements", lang("achievement_txt_2", true) . " " . $char . " " . lang("achievement_txt_3", true), $logDate);
                                    } else {
                                        message("error", lang("error_23", true));
                                    }
                                } else {
                                    message("error", lang("achievement_error_2", true));
                                }
                            } else {
                                message("error", lang("achievement_error_3", true));
                            }
                        } else {
                            message("error", lang("achievement_error_4", true));
                        }
                    }
                }
            }
        }
    }
    public function unlockData($username, $char)
    {
        global $dB;
        if (!check_value($username)) {
            message("error", lang("error_4", true));
        } else {
            if (!check_value($char)) {
                message("error", lang("error_4", true));
            } else {
                if (!Validator::UsernameLength($username)) {
                    message("error", lang("error_5", true));
                } else {
                    if (!Validator::AlphaNumeric($username)) {
                        message("error", lang("error_6", true));
                    } else {
                        $Character = new Character();
                        if ($Character->CharacterExists($char) && $Character->CharacterBelongsToAccount($char, $_SESSION["username"])) {
                            $result = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_ACHIEVEMENTS_UNLOCK WHERE AccountID = ? AND Name = ?", [$username, $char]);
                            if (is_array($result)) {
                                return $result;
                            }
                            $dB->query("INSERT INTO IMPERIAMUCMS_ACHIEVEMENTS_UNLOCK(AccountID,Name,Unlock,Item1,Item2,Item3,Zen) VALUES(?,?,?,?,?,?,?)", [$username, $char, 0, 0, 0, 0, 0]);
                            $result = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_ACHIEVEMENTS_UNLOCK WHERE AccountID = ? AND Name = ?", [$username, $char]);
                            if (is_array($result)) {
                                return $result;
                            }
                            return NULL;
                        }
                        message("error", lang("achievement_error_4", true));
                    }
                }
            }
        }
    }
    public function getMoneyInv($username, $char)
    {
        global $dB;
        if (!check_value($username)) {
            message("error", lang("error_4", true));
        } else {
            if (!check_value($char)) {
                message("error", lang("error_4", true));
            } else {
                if (!Validator::UsernameLength($username)) {
                    message("error", lang("error_5", true));
                } else {
                    if (!Validator::AlphaNumeric($username)) {
                        message("error", lang("error_6", true));
                    } else {
                        $Character = new Character();
                        if ($Character->CharacterExists($char) && $Character->CharacterBelongsToAccount($char, $_SESSION["username"])) {
                            $result = $dB->query_fetch_single("SELECT Money FROM Character where AccountID = ? AND Name = ?", [$username, $char]);
                            if (is_array($result)) {
                                return $result["Money"];
                            }
                            return 0;
                        }
                        message("error", lang("achievement_error_4", true));
                    }
                }
            }
        }
    }
    public function getReqItemInv($username, $char, $code)
    {
        global $dB;
        if (!check_value($username)) {
            message("error", lang("error_4", true));
        } else {
            if (!check_value($char)) {
                message("error", lang("error_4", true));
            } else {
                if (!check_value($code)) {
                    message("error", lang("error_4", true));
                } else {
                    if (!Validator::UsernameLength($username)) {
                        message("error", lang("error_5", true));
                    } else {
                        if (!Validator::AlphaNumeric($username)) {
                            message("error", lang("error_6", true));
                        } else {
                            $Character = new Character();
                            if ($Character->CharacterExists($char) && $Character->CharacterBelongsToAccount($char, $_SESSION["username"])) {
                                $inventory = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT Inventory FROM Character WHERE AccountID = ? AND Name = ?), 2) AS items", [$username, $char]);
                                $inventory = $inventory["items"];
                                $i = 0;
                                $Market = new Market();
                                $Items = new Items();
                                $found_items = 0;
                                $item_code = explode(",", $code);
                                while ($i < 173) {
                                    $item = $Items->ItemInfo(substr($inventory, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__));
                                    if ($item["sticklevel"] == NULL || empty($item["sticklevel"])) {
                                        $item["sticklevel"] = 0;
                                    }
                                    if ($item["skill2"] == NULL || empty($item["skill2"])) {
                                        $item["skill2"] = 0;
                                    }
                                    if ($item["luck2"] == NULL || empty($item["luck2"])) {
                                        $item["luck2"] = 0;
                                    }
                                    if ($item["opt2"] == NULL || empty($item["opt2"])) {
                                        $item["opt2"] = 0;
                                    }
                                    if ($item["exl2"] == NULL || empty($item["exl2"])) {
                                        $item["exl2"] = 0;
                                    }
                                    if ($item["isanc"] == NULL || empty($item["isanc"])) {
                                        $item["isanc"] = 0;
                                    }
                                    if ($item["type"] == $item_code[0] && $item["id"] == $item_code[1] && $item["sticklevel"] == $item_code[2] && $item["skill2"] == $item_code[3] && $item["luck2"] == $item_code[4] && $item["opt2"] == $item_code[5] && $item["exl2"] == $item_code[6] && $item["isanc"] == $item_code[7]) {
                                        if (140 <= config("server_files_season", true)) {
                                            if ($this->checkJewel($item["type"], $item["id"])) {
                                                $found_items = $found_items + $item["dur"];
                                            } else {
                                                $found_items++;
                                            }
                                        } else {
                                            $found_items++;
                                        }
                                    }
                                    $i++;
                                }
                                return $found_items;
                            }
                            message("error", lang("achievement_error_4", true));
                        }
                    }
                }
            }
        }
    }
    public function registerZen($username, $char, $amount)
    {
        global $dB;
        global $dB2;
        global $common;
        if (!check_value($username)) {
            message("error", lang("error_4", true));
        } else {
            if (!check_value($char)) {
                message("error", lang("error_4", true));
            } else {
                if (!check_value($amount)) {
                    message("error", lang("error_4", true));
                } else {
                    if (!Validator::UsernameLength($username)) {
                        message("error", lang("error_5", true));
                    } else {
                        if (!Validator::AlphaNumeric($username)) {
                            message("error", lang("error_6", true));
                        } else {
                            if (!Validator::UnsignedNumber($amount)) {
                                message("error", lang("error_25", true));
                            } else {
                                $Character = new Character();
                                if ($Character->CharacterExists($char) && $Character->CharacterBelongsToAccount($char, $_SESSION["username"])) {
                                    if (!$common->accountOnline($username)) {
                                        $total = $this->getMoneyInv($username, $char);
                                        if ($total < $amount) {
                                            message("error", lang("achievement_error_5", true));
                                        } else {
                                            if ($amount < 1) {
                                                message("error", lang("error_25", true));
                                            } else {
                                                $query = $dB->query("UPDATE IMPERIAMUCMS_ACHIEVEMENTS_UNLOCK SET Zen = Zen + ? WHERE AccountID = ? AND Name = ?", [$amount, $username, $char]);
                                                $query2 = $dB->query("UPDATE Character SET Money = Money - ? WHERE AccountID = ? AND Name = ?", [$amount, $username, $char]);
                                                if ($query && $query2) {
                                                    message("success", lang("achievement_txt_4", true) . " " . $amount . " " . lang("achievement_txt_5", true) . " " . $char . ".");
                                                    $logDate = date("Y-m-d H:i:s", time());
                                                    $common->accountLogs($username, "achievements", lang("achievement_txt_6", true) . " " . $amount . " " . lang("achievement_txt_7", true) . " " . $char . ".", $logDate);
                                                } else {
                                                    message("error", lang("error_23", true));
                                                }
                                            }
                                        }
                                    } else {
                                        message("error", lang("error_14", true));
                                    }
                                } else {
                                    message("error", lang("achievement_error_4", true));
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    public function registerItem($username, $char, $amount, $code, $index)
    {
        global $dB;
        global $dB2;
        global $common;
        if (!check_value($username)) {
            message("error", lang("error_4", true));
        } else {
            if (!check_value($char)) {
                message("error", lang("error_4", true));
            } else {
                if (!check_value($amount)) {
                    message("error", lang("error_4", true));
                } else {
                    if (!check_value($code)) {
                        message("error", lang("error_4", true));
                    } else {
                        if (!Validator::UsernameLength($username)) {
                            message("error", lang("error_5", true));
                        } else {
                            if (!Validator::AlphaNumeric($username)) {
                                message("error", lang("error_6", true));
                            } else {
                                if (!Validator::UnsignedNumber($amount)) {
                                    message("error", lang("error_25", true));
                                } else {
                                    $Character = new Character();
                                    if ($Character->CharacterExists($char) && $Character->CharacterBelongsToAccount($char, $_SESSION["username"])) {
                                        if (!$common->accountOnline($username)) {
                                            $total = $this->getReqItemInv($username, $char, $code);
                                            $item_code = explode(",", $code);
                                            $name = $dB->query_fetch_single("SELECT name FROM IMPERIAMUCMS_ITEMS WHERE type = ? AND id = ? and level = ?", [$item_code[0], $item_code[1], $item_code[2]]);
                                            if ($total < $amount) {
                                                message("error", lang("achievement_error_6", true) . " " . $name["name"] . ".");
                                            } else {
                                                if ($amount < 1) {
                                                    message("error", lang("error_25", true));
                                                } else {
                                                    $inventory = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT Inventory FROM Character WHERE AccountID = ? AND Name = ?), 2) AS items", [$username, $char]);
                                                    $inventory = $inventory["items"];
                                                    $i = 0;
                                                    $Market = new Market();
                                                    $Items = new Items();
                                                    $found_items = 0;
                                                    while ($i < 173) {
                                                        $itemHex = substr($inventory, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                                                        $item = $Items->ItemInfo($itemHex);
                                                        if ($item["sticklevel"] == NULL || empty($item["sticklevel"])) {
                                                            $item["sticklevel"] = 0;
                                                        }
                                                        if ($item["skill2"] == NULL || empty($item["skill2"])) {
                                                            $item["skill2"] = 0;
                                                        }
                                                        if ($item["luck2"] == NULL || empty($item["luck2"])) {
                                                            $item["luck2"] = 0;
                                                        }
                                                        if ($item["opt2"] == NULL || empty($item["opt2"])) {
                                                            $item["opt2"] = 0;
                                                        }
                                                        if ($item["exl2"] == NULL || empty($item["exl2"])) {
                                                            $item["exl2"] = 0;
                                                        }
                                                        if ($item["isanc"] == NULL || empty($item["isanc"])) {
                                                            $item["isanc"] = 0;
                                                        }
                                                        if ($item["type"] == $item_code[0] && $item["id"] == $item_code[1] && $item["sticklevel"] == $item_code[2] && $item["skill2"] == $item_code[3] && $item["luck2"] == $item_code[4] && $item["opt2"] == $item_code[5] && $item["exl2"] == $item_code[6] && $item["isanc"] == $item_code[7]) {
                                                            if (140 <= config("server_files_season", true)) {
                                                                if ($this->checkJewel($item["type"], $item["id"])) {
                                                                    if (0 < $item["dur"]) {
                                                                        $durCounter = 0;
                                                                        while ($durCounter < $item["dur"]) {
                                                                            $dur = hexdec(substr($itemHex, 4, 2));
                                                                            $dur = $dur - 1;
                                                                            if (0 < $dur) {
                                                                                $itemHex = substr_replace($itemHex, sprintf("%02X", $dur), 4, 2);
                                                                                $inventory = substr_replace($inventory, $itemHex, $i * __ITEM_LENGTH__, __ITEM_LENGTH__);
                                                                            } else {
                                                                                $inventory = substr_replace($inventory, __ITEM_EMPTY__, $i * __ITEM_LENGTH__, __ITEM_LENGTH__);
                                                                            }
                                                                            $found_items++;
                                                                            if ($found_items != $amount) {
                                                                                $durCounter++;
                                                                            }
                                                                        }
                                                                        if ($found_items != $amount) {
                                                                        }
                                                                    }
                                                                } else {
                                                                    $inventory = substr_replace($inventory, __ITEM_EMPTY__, $i * __ITEM_LENGTH__, __ITEM_LENGTH__);
                                                                    $found_items++;
                                                                    if ($found_items != $amount) {
                                                                    }
                                                                }
                                                            } else {
                                                                $inventory = substr_replace($inventory, __ITEM_EMPTY__, $i * __ITEM_LENGTH__, __ITEM_LENGTH__);
                                                                $found_items++;
                                                                if ($found_items != $amount) {
                                                                }
                                                            }
                                                        }
                                                        $i++;
                                                    }
                                                    $column = "Item" . $index;
                                                    $inventory = "0x" . $inventory;
                                                    $query = $dB->query("UPDATE IMPERIAMUCMS_ACHIEVEMENTS_UNLOCK SET " . $column . " = " . $column . " + ? WHERE AccountID = ? AND Name = ?", [$amount, $username, $char]);
                                                    $query2 = $dB->query("UPDATE Character SET Inventory = " . $inventory . " WHERE AccountID = '" . $username . "' AND Name = '" . $char . "'");
                                                    if ($query && $query2) {
                                                        message("success", lang("achievement_txt_4", true) . " " . $amount . " " . $name["name"] . " " . lang("achievement_txt_8", true) . " " . $char . ".");
                                                        $logDate = date("Y-m-d H:i:s", time());
                                                        $common->accountLogs($username, "achievements", lang("achievement_txt_6", true) . " " . $amount . " " . $name["name"] . " " . lang("achievement_txt_8", true) . " " . $char . ".", $logDate);
                                                    } else {
                                                        message("error", lang("error_23", true));
                                                    }
                                                }
                                            }
                                        } else {
                                            message("error", lang("error_14", true));
                                        }
                                    } else {
                                        message("error", lang("error_66", true));
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    public function unlockAchievements($username, $char)
    {
        global $dB;
        global $common;
        if (!check_value($username)) {
            message("error", lang("error_4", true));
        } else {
            if (!check_value($char)) {
                message("error", lang("error_4", true));
            } else {
                if (!Validator::UsernameLength($username)) {
                    message("error", lang("error_5", true));
                } else {
                    if (!Validator::AlphaNumeric($username)) {
                        message("error", lang("error_6", true));
                    } else {
                        $Character = new Character();
                        if ($Character->CharacterExists($char) && $Character->CharacterBelongsToAccount($char, $_SESSION["username"])) {
                            if ($common->accountOnline($username)) {
                                message("error", lang("error_14", true));
                                return NULL;
                            }
                            $data = $this->unlockData($username, $char);
                            if ($data["Unlock"] == "0") {
                                $characterData = $Character->CharacterData($char);
                                $can_unlock = true;
                                if (1 <= mconfig("req_items")) {
                                    if (mconfig("item1_count") > $data["Item1"]) {
                                        $can_unlock = false;
                                    }
                                    if (2 <= mconfig("req_items")) {
                                        if (mconfig("item2_count") > $data["Item2"]) {
                                            $can_unlock = false;
                                        }
                                        if (3 <= mconfig("req_items") && mconfig("item3_count") > $data["Item3"]) {
                                            $can_unlock = false;
                                        }
                                    }
                                }
                                if (0 < mconfig("zen") && mconfig("zen") > $data["Zen"]) {
                                    $can_unlock = false;
                                }
                                if (0 < mconfig("level") && mconfig("level") > $characterData["cLevel"]) {
                                    $can_unlock = false;
                                }
                                if (0 < mconfig("mlevel") && mconfig("mlevel") > $characterData["mLevel"]) {
                                    $can_unlock = false;
                                }
                                if (0 < mconfig("reset") && mconfig("reset") > $characterData["RESETS"]) {
                                    $can_unlock = false;
                                }
                                if (0 < mconfig("greset") && mconfig("greset") > $characterData["Grand_Resets"]) {
                                    $can_unlock = false;
                                }
                                if ($can_unlock) {
                                    $query = $dB->query("UPDATE IMPERIAMUCMS_ACHIEVEMENTS_UNLOCK SET Unlock = ? WHERE AccountID = ? AND Name = ?", ["1", $username, $char]);
                                    if ($query) {
                                        message("success", lang("achievement_txt_1", true));
                                        $logDate = date("Y-m-d H:i:s", time());
                                        $common->accountLogs($username, "achievements", lang("achievement_txt_2", true) . " " . $char . " " . lang("achievement_txt_3", true), $logDate);
                                    } else {
                                        message("error", lang("error_23", true));
                                    }
                                } else {
                                    message("error", lang("achievement_error_2", true));
                                }
                            } else {
                                message("error", lang("achievement_error_3", true));
                            }
                        } else {
                            message("error", lang("achievement_error_4", true));
                        }
                    }
                }
            }
        }
    }
    public function rewardType($achievements, $this_stage, $j)
    {
        $Market = new Market();
        $Items = new Items();
        switch ($achievements[$j]["stage"][$this_stage]["reward_type"]) {
            case 1:
                $reward_type_name = lang("currency_platinum", true);
                break;
            case 2:
                $reward_type_name = lang("currency_gold", true);
                break;
            case 3:
                $reward_type_name = lang("currency_silver", true);
                break;
            case 4:
                $reward_type_name = lang("currency_wcoinc", true);
                break;
            case 5:
                $reward_type_name = lang("currency_gp", true);
                break;
            case 6:
                $reward_type_name = "" . lang("currency_zen", true) . "";
                break;
            case 7:
                $ach_rew_items = count($achievements[$j]["stage"][$this_stage]["rew_items"]);
                $total_rew_items = array_sum($achievements[$j]["stage"][$this_stage]["rew_items_count"]);
                $found_rew_items = 0;
                $reward_type_name = "";
                $l = 1;
                while ($l <= $ach_rew_items) {
                    $rew_item = explode(",", $achievements[$j]["stage"][$this_stage]["rew_items"][$l]);
                    list($sy, $ioo) = $rew_item;
                    if (256 <= $sy) {
                        $sy = $sy - 256;
                        $ioo += 128;
                    }
                    $code = __ITEM_EMPTY__;
                    $code = substr_replace($code, sprintf("%01X", $rew_item[0]), 18, 1);
                    $code = substr_replace($code, sprintf("%02X", $sy), 0, 2);
                    if (3 < $rew_item[5]) {
                        $opt = 3;
                        $opt2 = $rew_item[5] - 3;
                    } else {
                        $opt = $rew_item[5];
                        $opt2 = 0;
                    }
                    if ($rew_item[7] != 0) {
                        $easytoyou_decoder_beta_not_finish -= 1;
                    }
                    $lvl = $rew_item[2] * 8 + $rew_item[3] * 128 + $rew_item[4] * 4 + $opt;
                    $code = substr_replace($code, sprintf("%02X", $lvl), 2, 2);
                    $code = substr_replace($code, sprintf("%02X", 0), 4, 2);
                    $code = substr_replace($code, sprintf("%02X", $ioo), 14, 2);
                    $code = substr_replace($code, sprintf("%02X", $rew_item[7]), 16, 2);
                    $code = substr_replace($code, "0", 19, 1);
                    $code = substr_replace($code, "0", 20, 1);
                    $code = substr_replace($code, "0", 21, 1);
                    $code = substr_replace($code, "00000000", 6, 8);
                    $ItemInfo = $Items->ItemInfo($code);
                    $tmp2 = $achievements[$j]["stage"][$this_stage]["rew_items_count"][$l];
                    if ($l < $ach_rew_items) {
                        $reward_type_name .= $tmp2 . "x " . $ItemInfo["name"] . ", ";
                    } else {
                        $reward_type_name .= $tmp2 . "x " . $ItemInfo["name"];
                    }
                    $l++;
                }
                break;
            case 8:
                $reward_type_name = lang("achievement_txt_9", true);
                break;
            case 9:
                $reward_type_name = lang("achievement_txt_10", true);
                break;
            default:
                $reward_type_name = NULL;
                return $reward_type_name;
        }
    }
    public function rewardTypeWithCount($achievements, $this_stage, $j)
    {
        $Market = new Market();
        $Items = new Items();
        switch ($achievements[$j]["stage"][$this_stage]["reward_type"]) {
            case 1:
                $reward_type_name = number_format($achievements[$j]["stage"][$this_stage]["reward"]) . " " . lang("currency_platinum", true);
                break;
            case 2:
                $reward_type_name = number_format($achievements[$j]["stage"][$this_stage]["reward"]) . " " . lang("currency_gold", true);
                break;
            case 3:
                $reward_type_name = number_format($achievements[$j]["stage"][$this_stage]["reward"]) . " " . lang("currency_silver", true);
                break;
            case 4:
                $reward_type_name = number_format($achievements[$j]["stage"][$this_stage]["reward"]) . " " . lang("currency_wcoinc", true);
                break;
            case 5:
                $reward_type_name = number_format($achievements[$j]["stage"][$this_stage]["reward"]) . " " . lang("currency_gp", true);
                break;
            case 6:
                $reward_type_name = number_format($achievements[$j]["stage"][$this_stage]["reward"]) . " " . lang("currency_zen", true) . "";
                break;
            case 7:
                $ach_rew_items = count($achievements[$j]["stage"][$this_stage]["rew_items"]);
                $total_rew_items = array_sum($achievements[$j]["stage"][$this_stage]["rew_items_count"]);
                $found_rew_items = 0;
                $reward_type_name = "";
                $l = 1;
                while ($l <= $ach_rew_items) {
                    $rew_item = explode(",", $achievements[$j]["stage"][$this_stage]["rew_items"][$l]);
                    list($sy, $ioo) = $rew_item;
                    if (256 <= $sy) {
                        $sy = $sy - 256;
                        $ioo += 128;
                    }
                    $code = __ITEM_EMPTY__;
                    $code = substr_replace($code, sprintf("%01X", $rew_item[0]), 18, 1);
                    $code = substr_replace($code, sprintf("%02X", $sy), 0, 2);
                    if (3 < $rew_item[5]) {
                        $opt = 3;
                        $opt2 = $rew_item[5] - 3;
                    } else {
                        $opt = $rew_item[5];
                        $opt2 = 0;
                    }
                    if ($rew_item[7] != 0) {
                        $easytoyou_decoder_beta_not_finish -= 1;
                    }
                    $lvl = $rew_item[2] * 8 + $rew_item[3] * 128 + $rew_item[4] * 4 + $opt;
                    $code = substr_replace($code, sprintf("%02X", $lvl), 2, 2);
                    $code = substr_replace($code, sprintf("%02X", 0), 4, 2);
                    $code = substr_replace($code, sprintf("%02X", $ioo), 14, 2);
                    $code = substr_replace($code, sprintf("%02X", $rew_item[7]), 16, 2);
                    $code = substr_replace($code, "0", 19, 1);
                    $code = substr_replace($code, "0", 20, 1);
                    $code = substr_replace($code, "0", 21, 1);
                    $code = substr_replace($code, "00000000", 6, 8);
                    $ItemInfo = $Items->ItemInfo($code);
                    $tmp2 = $achievements[$j]["stage"][$this_stage]["rew_items_count"][$l];
                    if ($l < $ach_rew_items) {
                        $reward_type_name .= $tmp2 . "x " . $ItemInfo["name"] . ", ";
                    } else {
                        $reward_type_name .= $tmp2 . "x " . $ItemInfo["name"];
                    }
                    $l++;
                }
                break;
            case 8:
                $reward_type_name = number_format($achievements[$j]["stage"][$this_stage]["reward"]) . " " . lang("achievement_txt_9", true);
                break;
            case 9:
                $reward_type_name = number_format($achievements[$j]["stage"][$this_stage]["reward"]) . " " . lang("achievement_txt_10", true);
                break;
            default:
                $reward_type_name = NULL;
                return $reward_type_name;
        }
    }
    public function generateAchievement($achievements, $this_stage, $charData, $data, $classes, $stars, $stars_total, $reward_type_name, $j, $token)
    {
        global $dB;
        global $config;
        $Items = new Items();
        if (in_array($charData["Class"], $classes) && $achievements[$j]["req_lvl"] <= $charData["cLevel"] && $achievements[$j]["req_mlvl"] <= $charData["mLevel"] && $achievements[$j]["req_reset"] <= $charData["RESETS"] && $achievements[$j]["req_greset"] <= $charData["Grand_Resets"]) {
            if ($achievements[$j]["type"] == "0") {
                $ach_monsters = count($achievements[$j]["stage"][$this_stage]["monsters"]);
                $total = array_sum($achievements[$j]["stage"][$this_stage]["monsters_count"]);
                $found = 0;
                $l = 1;
                while ($l <= $ach_monsters) {
                    $tmp_count = $achievements[$j]["stage"][$this_stage]["monsters_count"][$l];
                    $monsterid = $achievements[$j]["stage"][$this_stage]["monsters"][$l];
                    if (is_numeric($monsterid)) {
                        if ($monsterid == "-1") {
                            $check_monsters_db = $dB->query_fetch_single("SELECT SUM(count) as count FROM C_Monster_KillCount WHERE Name = ?", [$charData["Name"]]);
                            $found += $check_monsters_db["count"];
                            $easytoyou_decoder_beta_not_finish -= $check_monsters_db["count"];
                        } else {
                            $check_monsters_db = $dB->query_fetch_single("SELECT * FROM C_Monster_KillCount WHERE Name = ? AND MonsterId = ?", [$charData["Name"], $monsterid]);
                            $found += $check_monsters_db["count"];
                            $easytoyou_decoder_beta_not_finish -= $check_monsters_db["count"];
                        }
                    } else {
                        $all_monsterid = explode(",", $monsterid);
                        if (is_array($all_monsterid)) {
                            foreach ($all_monsterid as $thisM) {
                                $check_monsters_db = $dB->query_fetch_single("SELECT * FROM C_Monster_KillCount WHERE Name = ? AND MonsterId = ?", [$charData["Name"], $thisM]);
                                $easytoyou_decoder_beta_not_finish -= $check_monsters_db["count"];
                            }
                        }
                    }
                    if ($achievements[$j]["stage"][$this_stage]["monsters_count"][$l] != "0") {
                        if ($achievements[$j]["stage"][$this_stage]["monsters_count"][$l] < "0") {
                            $achievements[$j]["stage"][$this_stage]["monsters_count"][$l] = "0";
                            $found = $tmp_count;
                        }
                        $l++;
                    }
                }
            } else {
                if ($achievements[$j]["type"] == "1") {
                    $info = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$charData["AccountID"]]);
                    if ($info["zen"] == NULL || empty($info["zen"])) {
                        $info["zen"] = 0;
                    }
                    if ($achievements[$j]["stage"][$this_stage]["zen"] < $info["zen"]) {
                        $info["zen"] = $achievements[$j]["stage"][$this_stage]["zen"];
                    }
                    $found = $info["zen"];
                    $total = $achievements[$j]["stage"][$this_stage]["zen"];
                } else {
                    if ($achievements[$j]["type"] == "2") {
                        $info = $dB->query_fetch_single("SELECT SUM(Point) as Point FROM [" . $config["SQL_DB_NAME_RANKING"] . "].[dbo].[EVENT_INFO_BC_5TH] WHERE AccountID = ? AND CharacterName = ?", [$charData["AccountID"], $charData["Name"]]);
                        if ($info["Point"] == NULL || empty($info["Point"])) {
                            $info["Point"] = 0;
                        }
                        if ($achievements[$j]["stage"][$this_stage]["exp"] < $info["Point"]) {
                            $info["Point"] = $achievements[$j]["stage"][$this_stage]["exp"];
                        }
                        $found = $info["Point"];
                        $total = $achievements[$j]["stage"][$this_stage]["exp"];
                    } else {
                        if ($achievements[$j]["type"] == "3") {
                            $info = $dB->query_fetch_single("SELECT SUM(Point) as Point FROM [" . $config["SQL_DB_NAME_RANKING"] . "].[dbo].[EVENT_INFO] WHERE AccountID = ? AND CharacterName = ?", [$charData["AccountID"], $charData["Name"]]);
                            if ($info["Point"] == NULL || empty($info["Point"])) {
                                $info["Point"] = 0;
                            }
                            if ($achievements[$j]["stage"][$this_stage]["exp"] < $info["Point"]) {
                                $info["Point"] = $achievements[$j]["stage"][$this_stage]["exp"];
                            }
                            $found = $info["Point"];
                            $total = $achievements[$j]["stage"][$this_stage]["exp"];
                        } else {
                            if ($achievements[$j]["type"] == "4") {
                                $info = $dB->query_fetch_single("SELECT Wins FROM [" . $config["SQL_DB_NAME_RANKING"] . "].[dbo].[EVENT_INFO_CC] WHERE AccountID = ? AND Name = ?", [$charData["AccountID"], $charData["Name"]]);
                                if ($info["Wins"] == NULL || empty($info["Wins"])) {
                                    $info["Wins"] = 0;
                                }
                                if ($achievements[$j]["stage"][$this_stage]["exp"] < $info["Wins"]) {
                                    $info["Wins"] = $achievements[$j]["stage"][$this_stage]["exp"];
                                }
                                $found = $info["Wins"];
                                $total = $achievements[$j]["stage"][$this_stage]["exp"];
                            } else {
                                if ($achievements[$j]["type"] == "5") {
                                    $ach_items = count($achievements[$j]["stage"][$this_stage]["items"]);
                                    $total = array_sum($achievements[$j]["stage"][$this_stage]["items_count"]);
                                    $found = 0;
                                    $l = 1;
                                    while ($l <= $ach_items) {
                                        $req_item = explode(",", $achievements[$j]["stage"][$this_stage]["items"][$l]);
                                        $vault = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT Items FROM warehouse WHERE AccountID = ?), 2) AS vault", [$charData["AccountID"]]);
                                        $vault = $vault["vault"];
                                        $i = 0;
                                        while ($i < 240) {
                                            $itemHex = substr($vault, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                                            $item = $Items->ItemInfo($itemHex);
                                            if ($item["level"] == NULL || empty($item["level"])) {
                                                $item["level"] = 0;
                                            }
                                            if ($item["skill2"] == NULL || empty($item["skill2"])) {
                                                $item["skill2"] = 0;
                                            }
                                            if ($item["luck2"] == NULL || empty($item["luck2"])) {
                                                $item["luck2"] = 0;
                                            }
                                            if ($item["opt2"] == NULL || empty($item["opt2"])) {
                                                $item["opt2"] = 0;
                                            }
                                            if ($item["exl2"] == NULL || empty($item["exl2"])) {
                                                $item["exl2"] = 0;
                                            }
                                            if ($item["isanc"] == NULL || empty($item["isanc"])) {
                                                $item["isanc"] = 0;
                                            }
                                            if ($item["type"] == $req_item[0] && $item["id"] == $req_item[1] && $item["level"] == $req_item[2] && $item["skill2"] == $req_item[3] && $item["luck2"] == $req_item[4] && $item["opt2"] == $req_item[5] && $item["exl2"] == $req_item[6] && $item["isanc"] == $req_item[7]) {
                                                if (140 <= config("server_files_season", true)) {
                                                    if ($this->checkJewel($item["type"], $item["id"])) {
                                                        if (0 < $item["dur"]) {
                                                            if ($achievements[$j]["stage"][$this_stage]["items_count"][$l] <= $item["dur"]) {
                                                                $found = $found + $achievements[$j]["stage"][$this_stage]["items_count"][$l];
                                                                $achievements[$j]["stage"][$this_stage]["items_count"][$l] = 0;
                                                            } else {
                                                                $found = $found + $item["dur"];
                                                                $achievements[$j]["stage"][$this_stage]["items_count"][$l] = $achievements[$j]["stage"][$this_stage]["items_count"][$l] - $item["dur"];
                                                            }
                                                            if ($achievements[$j]["stage"][$this_stage]["items_count"][$l] != "0") {
                                                            }
                                                        }
                                                    } else {
                                                        $found++;
                                                        $achievements[$j]["stage"][$this_stage]["items_count"][$l]--;
                                                        if ($achievements[$j]["stage"][$this_stage]["items_count"][$l] != "0") {
                                                        }
                                                    }
                                                } else {
                                                    $found++;
                                                    $achievements[$j]["stage"][$this_stage]["items_count"][$l]--;
                                                    if ($achievements[$j]["stage"][$this_stage]["items_count"][$l] != "0") {
                                                    }
                                                }
                                            }
                                            $i++;
                                        }
                                        $l++;
                                    }
                                } else {
                                    if ($achievements[$j]["type"] == "6") {
                                        $info = $dB->query_fetch_single("SELECT sum(KillCount) as KillCount FROM [" . $config["SQL_DB_NAME_RANKING"] . "].[dbo].[EVENT_INFO_IT] WHERE AccountID = ? AND Name = ?", [$charData["AccountID"], $charData["Name"]]);
                                        if ($info["KillCount"] == NULL || empty($info["KillCount"])) {
                                            $info["KillCount"] = 0;
                                        }
                                        if ($achievements[$j]["stage"][$this_stage]["exp"] < $info["KillCount"]) {
                                            $info["KillCount"] = $achievements[$j]["stage"][$this_stage]["exp"];
                                        }
                                        $found = $info["KillCount"];
                                        $total = $achievements[$j]["stage"][$this_stage]["exp"];
                                    } else {
                                        if ($achievements[$j]["type"] == "7") {
                                            $info = $dB->query_fetch_single("SELECT WinDuels FROM Character WHERE AccountID = ? AND Name = ?", [$charData["AccountID"], $charData["Name"]]);
                                            if ($info["WinDuels"] == NULL || empty($info["WinDuels"])) {
                                                $info["WinDuels"] = 0;
                                            }
                                            if ($achievements[$j]["stage"][$this_stage]["exp"] < $info["WinDuels"]) {
                                                $info["WinDuels"] = $achievements[$j]["stage"][$this_stage]["exp"];
                                            }
                                            $found = $info["WinDuels"];
                                            $total = $achievements[$j]["stage"][$this_stage]["exp"];
                                        } else {
                                            if ($achievements[$j]["type"] == "8") {
                                                $info = $dB->query_fetch_single("SELECT RESETS FROM Character WHERE AccountID = ? AND Name = ?", [$charData["AccountID"], $charData["Name"]]);
                                                if ($info["RESETS"] == NULL || empty($info["RESETS"])) {
                                                    $info["RESETS"] = 0;
                                                }
                                                if ($achievements[$j]["stage"][$this_stage]["exp"] < $info["RESETS"]) {
                                                    $info["RESETS"] = $achievements[$j]["stage"][$this_stage]["exp"];
                                                }
                                                $found = $info["RESETS"];
                                                $total = $achievements[$j]["stage"][$this_stage]["exp"];
                                            } else {
                                                if ($achievements[$j]["type"] == "9") {
                                                    $info = $dB->query_fetch_single("SELECT Grand_Resets FROM Character WHERE AccountID = ? AND Name = ?", [$charData["AccountID"], $charData["Name"]]);
                                                    if ($info["Grand_Resets"] == NULL || empty($info["Grand_Resets"])) {
                                                        $info["Grand_Resets"] = 0;
                                                    }
                                                    if ($achievements[$j]["stage"][$this_stage]["exp"] < $info["Grand_Resets"]) {
                                                        $info["Grand_Resets"] = $achievements[$j]["stage"][$this_stage]["exp"];
                                                    }
                                                    $found = $info["Grand_Resets"];
                                                    $total = $achievements[$j]["stage"][$this_stage]["exp"];
                                                } else {
                                                    if ($achievements[$j]["type"] == "10") {
                                                        $info = $dB->query_fetch_single("SELECT cLevel FROM Character WHERE AccountID = ? AND Name = ?", [$charData["AccountID"], $charData["Name"]]);
                                                        if ($info["cLevel"] == NULL || empty($info["cLevel"])) {
                                                            $info["cLevel"] = 0;
                                                        }
                                                        if ($achievements[$j]["stage"][$this_stage]["exp"] < $info["cLevel"]) {
                                                            $info["cLevel"] = $achievements[$j]["stage"][$this_stage]["exp"];
                                                        }
                                                        $found = $info["cLevel"];
                                                        $total = $achievements[$j]["stage"][$this_stage]["exp"];
                                                    } else {
                                                        if ($achievements[$j]["type"] == "11") {
                                                            $info = $dB->query_fetch_single("SELECT mLevel FROM Character WHERE AccountID = ? AND Name = ?", [$charData["AccountID"], $charData["Name"]]);
                                                            if ($info["mLevel"] == NULL || empty($info["mLevel"])) {
                                                                $info["mLevel"] = 0;
                                                            }
                                                            if ($achievements[$j]["stage"][$this_stage]["exp"] < $info["mLevel"]) {
                                                                $info["mLevel"] = $achievements[$j]["stage"][$this_stage]["exp"];
                                                            }
                                                            $found = $info["mLevel"];
                                                            $total = $achievements[$j]["stage"][$this_stage]["exp"];
                                                        } else {
                                                            if ($achievements[$j]["type"] == "12") {
                                                                $info = $dB->query_fetch_single("SELECT count(*) as kills FROM C_PlayerKiller_Info WHERE Killer = ?", [$charData["Name"]]);
                                                                if ($info["kills"] == NULL || empty($info["kills"])) {
                                                                    $info["kills"] = 0;
                                                                }
                                                                if ($achievements[$j]["stage"][$this_stage]["exp"] < $info["kills"]) {
                                                                    $info["kills"] = $achievements[$j]["stage"][$this_stage]["exp"];
                                                                }
                                                                $found = $info["kills"];
                                                                $total = $achievements[$j]["stage"][$this_stage]["exp"];
                                                            } else {
                                                                if ($achievements[$j]["type"] == "13") {
                                                                    $info = $dB->query_fetch_single("SELECT sum(Points) as Points FROM IGC_Gens WHERE Name = ?", [$charData["Name"]]);
                                                                    if ($info["Points"] == NULL || empty($info["Points"])) {
                                                                        $info["Points"] = 0;
                                                                    }
                                                                    if ($achievements[$j]["stage"][$this_stage]["exp"] < $info["Points"]) {
                                                                        $info["Points"] = $achievements[$j]["stage"][$this_stage]["exp"];
                                                                    }
                                                                    $found = $info["Points"];
                                                                    $total = $achievements[$j]["stage"][$this_stage]["exp"];
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
            }
            $perc = $found * 100 / $total;
            if ($data["Stage"] == $achievements[$j]["total_stages"]) {
                $perc = 100;
            }
            if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
                echo "\r\n            <div class=\"col-xs-12 col-sm-12 col-md-6 col-lg-4 achievement\">\r\n                <form method=\"post\">\r\n                    <table>\r\n                        <tbody>\r\n                            <tr>\r\n                                <td class=\"ach-icon\"><img src=\"" . __PATH_TEMPLATE_ASSETS__ . "achievements/" . $achievements[$j]["img"] . "\" alt=\"\"></td>\r\n                                <td class=\"ach-text\">\r\n                                    <div class=\"ach-stage\">" . lang("achievement_txt_11", true) . ": " . $data["Stage"] . "/" . $achievements[$j]["total_stages"] . "</div>\r\n                                    <div class=\"ach-title\">" . $achievements[$j]["name"] . "</div>\r\n                                    <div class=\"reg_spacer\"></div>\r\n                                    <div class=\"small\"><b>" . lang("achievement_txt_13", true) . ":</b> " . $achievements[$j]["stage"][$this_stage]["reward"] . " " . $reward_type_name . "</div>\r\n                                    <div class=\"reg_spacer\"></div>\r\n                                    <div class=\"small\"><b>" . lang("achievement_txt_14", true) . ":</b> " . $achievements[$j]["stage"][$this_stage]["points"] . " " . lang("achievement_txt_15", true) . "</div>\r\n                                </td>\r\n                            </tr>\r\n                            <tr>\r\n                                <td class=\"ach-col\" colspan=\"2\">\r\n                                    <div class=\"small\"><b>" . lang("achievement_txt_16", true) . ":</b> " . $achievements[$j]["stage"][$this_stage]["desc"] . "</div>\r\n                                </td>\r\n                            </tr>\r\n                            <tr>\r\n                                <td class=\"ach-col\" colspan=\"2\">\r\n                                    <div class=\"rate-line\">\r\n                                        <div class=\"rate-line-stage\" style=\"width:" . $perc . "%\"></div>";
                if ($perc == 100) {
                    if ($data["Stage"] == $this_stage) {
                        echo "\r\n                                        <div class=\"rate-text\"><img src=\"" . __PATH_TEMPLATE_ASSETS__ . "achievements/done.png\" class=\"rightfloat\" alt=\"\">" . lang("achievement_txt_17", true) . "</div>\r\n                                    </div>\r\n                                </td>\r\n                            </tr>";
                    } else {
                        echo "\r\n                                        <div class=\"rate-text\"><img src=\"" . __PATH_TEMPLATE_ASSETS__ . "achievements/done.png\" class=\"rightfloat\" alt=\"\">" . number_format($total) . " / " . number_format($total) . "</div>\r\n                                    </div>\r\n                                </td>\r\n                            </tr>";
                    }
                    if ($data["Stage"] < $this_stage) {
                        echo "\r\n                            <tr>\r\n                                <td class=\"ach-col\" colspan=\"2\" align=\"center\">\r\n                                    <input type=\"hidden\" name=\"" . Encode("uid") . "\" value=\"" . Encode($achievements[$j]["uid"]) . "\">\r\n                                    <input type=\"hidden\" name=\"" . Encode("stage") . "\" value=\"" . Encode($this_stage) . "\">\r\n                                    <input type=\"hidden\" name=\"" . Encode("j") . "\" value=\"" . Encode($j) . "\">\r\n                                    <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                                    <input type=\"submit\" name=\"reward\" class=\"btn btn-warning full-width-btn\" value=\"" . lang("achievement_txt_18", true) . "\">\r\n                                </td>\r\n                            </tr>";
                    }
                } else {
                    echo "\r\n                                        <div class=\"rate-text\">" . number_format($found) . " / " . number_format($total) . "</div>\r\n                                    </div>\r\n                                </td>\r\n                            </tr>";
                }
                echo "\r\n                                    </div>\r\n                                </td>\r\n                            </tr>\r\n                        </tbody>\r\n                    </table>\r\n                </form>\r\n            </div>";
            } else {
                echo "\r\n            <div class=\"achievement\">\r\n                <form method=\"post\">\r\n                    <table>\r\n                        <tbody>\r\n                            <tr>\r\n                                <td class=\"ach-icon\"><img src=\"" . __PATH_TEMPLATE__ . "style/images/achievements/" . $achievements[$j]["img"] . "\" alt=\"\"></td>\r\n                                <td class=\"ach-text\">\r\n                                    <ul class=\"star-rating help_text\" title=\"" . lang("achievement_txt_11", true) . $data["Stage"] . "/" . $achievements[$j]["total_stages"] . lang("achievement_txt_12", true) . "\" style=\"width: " . $stars_total . "px;\">\r\n                                        <li class=\"current-rating\" style=\"width:" . $stars . "px\"></li>\r\n                                    </ul>\r\n                                    <div class=\"ach-title\">" . $achievements[$j]["name"] . "</div>\r\n                                    <div class=\"reg_spacer\"></div>\r\n                                    <div class=\"small\"><b>" . lang("achievement_txt_13", true) . ":</b> " . $achievements[$j]["stage"][$this_stage]["reward"] . " " . $reward_type_name . "</div>\r\n                                    <div class=\"reg_spacer\"></div>\r\n                                    <div class=\"small\"><b>" . lang("achievement_txt_14", true) . ":</b> " . $achievements[$j]["stage"][$this_stage]["points"] . " " . lang("achievement_txt_15", true) . "</div>\r\n                                </td>\r\n                            </tr>\r\n                            <tr>\r\n                                <td colspan=\"2\">\r\n                                    <div class=\"small\"><b>" . lang("achievement_txt_16", true) . ":</b> " . $achievements[$j]["stage"][$this_stage]["desc"] . "</div>\r\n                                </td>\r\n                            </tr>\r\n                            <tr>\r\n                                <td colspan=\"2\">\r\n                                    <div class=\"rate-line\">\r\n                                        <div class=\"rate-line-stage\" style=\"width:" . $perc . "%\"></div>";
                if ($perc == 100) {
                    if ($data["Stage"] == $this_stage) {
                        echo "\r\n                                        <div class=\"rate-text\"><img src=\"" . __PATH_TEMPLATE__ . "style/images/achievements/done.png\" class=\"rightfloat\" alt=\"\">" . lang("achievement_txt_17", true) . "</div>\r\n                                    </div>\r\n                                </td>\r\n                            </tr>";
                    } else {
                        echo "\r\n                                        <div class=\"rate-text\"><img src=\"" . __PATH_TEMPLATE__ . "style/images/achievements/done.png\" class=\"rightfloat\" alt=\"\">" . number_format($total) . " / " . number_format($total) . "</div>\r\n                                    </div>\r\n                                </td>\r\n                            </tr>";
                    }
                    if ($data["Stage"] < $this_stage) {
                        echo "\r\n                            <tr>\r\n                                <td colspan=\"2\" align=\"center\">\r\n                                    <input type=\"hidden\" name=\"" . Encode("uid") . "\" value=\"" . Encode($achievements[$j]["uid"]) . "\">\r\n                                    <input type=\"hidden\" name=\"" . Encode("stage") . "\" value=\"" . Encode($this_stage) . "\">\r\n                                    <input type=\"hidden\" name=\"" . Encode("j") . "\" value=\"" . Encode($j) . "\">\r\n                                    <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                                    <input type=\"submit\" name=\"reward\" value=\"" . lang("achievement_txt_18", true) . "\">\r\n                                </td>\r\n                            </tr>";
                    }
                } else {
                    echo "\r\n                                        <div class=\"rate-text\">" . number_format($found) . " / " . number_format($total) . "</div>\r\n                                    </div>\r\n                                </td>\r\n                            </tr>";
                }
                echo "\r\n                                    </div>\r\n                                </td>\r\n                            </tr>\r\n                        </tbody>\r\n                    </table>\r\n                </form>\r\n            </div>";
            }
        }
    }
    public function showAchievements($username, $char, $achievements, $total, $token)
    {
        global $dB;
        global $common;
        if (!check_value($username)) {
            message("error", lang("error_4", true));
        } else {
            if (!check_value($char)) {
                message("error", lang("error_4", true));
            } else {
                if (!check_value($achievements)) {
                    message("error", lang("error_4", true));
                } else {
                    if (!check_value($total)) {
                        message("error", lang("error_4", true));
                    } else {
                        if (!Validator::UsernameLength($username)) {
                            message("error", lang("error_5", true));
                        } else {
                            if (!Validator::AlphaNumeric($username)) {
                                message("error", lang("error_6", true));
                            } else {
                                if (!Validator::UnsignedNumber($total)) {
                                    message("error", lang("error_25", true));
                                } else {
                                    $Character = new Character();
                                    if ($Character->CharacterExists($char) && $Character->CharacterBelongsToAccount($char, $_SESSION["username"])) {
                                        $charData = $dB->query_fetch_single("SELECT AccountID, Name, cLevel, LevelUpPoint, Class, Experience, Strength, Dexterity, Vitality, Energy, CONVERT(VARCHAR(MAX), MagicList, 2) AS MagicList, Money, Life, MaxLife, Mana, MaxMana, MapNumber, MapPosX, MapPosY, PkCount, PkLevel, PkTime, MDate, LDate, CtlCode, CONVERT(VARCHAR(MAX), Quest, 2) AS Quest, Leadership, ChatLimitTime, FruitPoint, RESETS, CONVERT(VARCHAR(MAX), Inventory, 2) AS Inventory, Married, MarryName, mLevel, mlPoint, mlExperience, mlNextExp, InventoryExpansion, WinDuels, LoseDuels, Grand_Resets FROM Character WHERE AccountID = ? AND Name = ?", [$username, $char]);
                                        if (!defined(__RESPONSIVE__) && __RESPONSIVE__ != "TRUE") {
                                            echo "\r\n        <table width=\"100%\">\r\n            <tr>\r\n                <td>";
                                        }
                                        $j = 1;
                                        while ($j <= $total) {
                                            $data = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_ACHIEVEMENTS WHERE Achievement = ? AND AccountID = ? AND Name = ?", [$achievements[$j]["uid"], $username, $char]);
                                            if ($data["Stage"] == NULL || empty($data["Stage"])) {
                                                $data["Stage"] = 0;
                                                $this_stage = 1;
                                            } else {
                                                $this_stage = $data["Stage"] + 1;
                                            }
                                            $stars = $this_stage * 12 - 12;
                                            $stars_total = $achievements[$j]["total_stages"] * 12;
                                            if ($achievements[$j]["total_stages"] < $this_stage) {
                                                $this_stage = $achievements[$j]["total_stages"];
                                            }
                                            $reward_type_name = $this->rewardType($achievements, $this_stage, $j);
                                            $classes = explode(",", $achievements[$j]["class"]);
                                            $this->generateAchievement($achievements, $this_stage, $charData, $data, $classes, $stars, $stars_total, $reward_type_name, $j, $token);
                                            $j++;
                                        }
                                        if (!defined(__RESPONSIVE__) && __RESPONSIVE__ != "TRUE") {
                                            echo "\r\n                </td>\r\n            </tr>\r\n        </table>";
                                        }
                                    } else {
                                        message("error", lang("achievement_error_4", true));
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    public function giveReward($username, $char, $achievements, $uid, $stage, $j)
    {
        global $dB;
        global $dB2;
        global $common;
        global $config;
        if (!check_value($username)) {
            message("error", lang("error_4", true));
        } else {
            if (!check_value($char)) {
                message("error", lang("error_4", true));
            } else {
                if (!check_value($achievements)) {
                    message("error", lang("error_4", true));
                } else {
                    if (!check_value($uid)) {
                        message("error", lang("error_4", true));
                    } else {
                        if (!check_value($stage)) {
                            message("error", lang("error_4", true));
                        } else {
                            if (!check_value($j)) {
                                message("error", lang("error_4", true));
                            } else {
                                if (!Validator::UsernameLength($username)) {
                                    message("error", lang("error_5", true));
                                } else {
                                    if (!Validator::AlphaNumeric($username)) {
                                        message("error", lang("error_6", true));
                                    } else {
                                        if (!Validator::UnsignedNumber($uid)) {
                                            message("error", lang("error_25", true));
                                        } else {
                                            if (!Validator::UnsignedNumber($stage)) {
                                                message("error", lang("error_25", true));
                                            } else {
                                                if (!Validator::UnsignedNumber($j)) {
                                                    message("error", lang("error_25", true));
                                                } else {
                                                    $Market = new Market();
                                                    $Items = new Items();
                                                    $Character = new Character();
                                                    if ($Character->CharacterExists($char) && $Character->CharacterBelongsToAccount($char, $_SESSION["username"])) {
                                                        if (!$common->accountOnline($username)) {
                                                            $check_reward = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_ACHIEVEMENTS WHERE Achievement = ? AND AccountID = ? AND Name = ?", [$uid, $username, $char]);
                                                            if ($stage <= $check_reward["Stage"]) {
                                                                message("error", lang("achievement_error_8", true));
                                                                return NULL;
                                                            }
                                                            if ($achievements[$j]["type"] == "0") {
                                                                $ach_monsters = count($achievements[$j]["stage"][$stage]["monsters"]);
                                                                $total = array_sum($achievements[$j]["stage"][$stage]["monsters_count"]);
                                                                $found = 0;
                                                                $l = 1;
                                                                while ($l <= $ach_monsters) {
                                                                    $tmp_count = $achievements[$j]["stage"][$stage]["monsters_count"][$l];
                                                                    $monsterid = $achievements[$j]["stage"][$stage]["monsters"][$l];
                                                                    if (is_numeric($monsterid)) {
                                                                        if ($monsterid == "-1") {
                                                                            $check_monsters_db = $dB->query_fetch_single("SELECT SUM(count) as count FROM C_Monster_KillCount WHERE Name = ?", [$char]);
                                                                            $found += $check_monsters_db["count"];
                                                                            $easytoyou_decoder_beta_not_finish -= $check_monsters_db["count"];
                                                                        } else {
                                                                            $check_monsters_db = $dB->query_fetch_single("SELECT * FROM C_Monster_KillCount WHERE Name = ? AND MonsterId = ?", [$char, $monsterid]);
                                                                            $found += $check_monsters_db["count"];
                                                                            $easytoyou_decoder_beta_not_finish -= $check_monsters_db["count"];
                                                                        }
                                                                    } else {
                                                                        $all_monsterid = explode(",", $monsterid);
                                                                        if (is_array($all_monsterid)) {
                                                                            foreach ($all_monsterid as $thisM) {
                                                                                $check_monsters_db = $dB->query_fetch_single("SELECT * FROM C_Monster_KillCount WHERE Name = ? AND MonsterId = ?", [$char, $thisM]);
                                                                                $easytoyou_decoder_beta_not_finish -= $check_monsters_db["count"];
                                                                            }
                                                                        }
                                                                    }
                                                                    if ($achievements[$j]["stage"][$stage]["monsters_count"][$l] != "0") {
                                                                        if ($achievements[$j]["stage"][$stage]["monsters_count"][$l] < "0") {
                                                                            $achievements[$j]["stage"][$stage]["monsters_count"][$l] = "0";
                                                                            $found = $tmp_count;
                                                                        }
                                                                        $l++;
                                                                    }
                                                                }
                                                            } else {
                                                                if ($achievements[$j]["type"] == "1") {
                                                                    $info = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$username]);
                                                                    if ($info["zen"] == NULL || empty($info["zen"])) {
                                                                        $info["zen"] = 0;
                                                                    }
                                                                    if ($achievements[$j]["stage"][$stage]["zen"] < $info["zen"]) {
                                                                        $info["zen"] = $achievements[$j]["stage"][$stage]["zen"];
                                                                    }
                                                                    $found = $info["zen"];
                                                                    $total = $achievements[$j]["stage"][$stage]["zen"];
                                                                } else {
                                                                    if ($achievements[$j]["type"] == "2") {
                                                                        $info = $dB->query_fetch_single("SELECT sum(Point) as Point FROM [" . $config["SQL_DB_NAME_RANKING"] . "].[dbo].[EVENT_INFO_BC_5TH] WHERE AccountID = ? AND CharacterName = ?", [$username, $char]);
                                                                        if ($info["Point"] == NULL || empty($info["Point"])) {
                                                                            $info["Point"] = 0;
                                                                        }
                                                                        if ($achievements[$j]["stage"][$stage]["exp"] < $info["Point"]) {
                                                                            $info["Point"] = $achievements[$j]["stage"][$stage]["exp"];
                                                                        }
                                                                        $found = $info["Point"];
                                                                        $total = $achievements[$j]["stage"][$stage]["exp"];
                                                                    } else {
                                                                        if ($achievements[$j]["type"] == "3") {
                                                                            $info = $dB->query_fetch_single("SELECT sum(Point) as Point FROM [" . $config["SQL_DB_NAME_RANKING"] . "].[dbo].[EVENT_INFO] WHERE AccountID = ? AND CharacterName = ?", [$username, $char]);
                                                                            if ($info["Point"] == NULL || empty($info["Point"])) {
                                                                                $info["Point"] = 0;
                                                                            }
                                                                            if ($achievements[$j]["stage"][$stage]["exp"] < $info["Point"]) {
                                                                                $info["Point"] = $achievements[$j]["stage"][$stage]["exp"];
                                                                            }
                                                                            $found = $info["Point"];
                                                                            $total = $achievements[$j]["stage"][$stage]["exp"];
                                                                        } else {
                                                                            if ($achievements[$j]["type"] == "4") {
                                                                                $info = $dB->query_fetch_single("SELECT Wins FROM [" . $config["SQL_DB_NAME_RANKING"] . "].[dbo].[EVENT_INFO_CC] WHERE AccountID = ? AND Name = ?", [$username, $char]);
                                                                                if ($info["Wins"] == NULL || empty($info["Wins"])) {
                                                                                    $info["Wins"] = 0;
                                                                                }
                                                                                if ($achievements[$j]["stage"][$stage]["exp"] < $info["Wins"]) {
                                                                                    $info["Wins"] = $achievements[$j]["stage"][$stage]["exp"];
                                                                                }
                                                                                $found = $info["Wins"];
                                                                                $total = $achievements[$j]["stage"][$stage]["exp"];
                                                                            } else {
                                                                                if ($achievements[$j]["type"] == "5") {
                                                                                    $ach_items = count($achievements[$j]["stage"][$stage]["items"]);
                                                                                    $total = array_sum($achievements[$j]["stage"][$stage]["items_count"]);
                                                                                    $found = 0;
                                                                                    $l = 1;
                                                                                    while ($l <= $ach_items) {
                                                                                        $req_item = explode(",", $achievements[$j]["stage"][$stage]["items"][$l]);
                                                                                        $tmp_items_count = $achievements[$j]["stage"][$stage]["items_count"][$l];
                                                                                        $vault = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT Items FROM warehouse WHERE AccountID = ?), 2) AS vault", [$username]);
                                                                                        $vault = $vault["vault"];
                                                                                        $i = 0;
                                                                                        while ($i < 240) {
                                                                                            $itemHex = substr($vault, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                                                                                            $item = $Items->ItemInfo($itemHex);
                                                                                            if ($item["level"] == NULL || empty($item["level"])) {
                                                                                                $item["level"] = 0;
                                                                                            }
                                                                                            if ($item["skill2"] == NULL || empty($item["skill2"])) {
                                                                                                $item["skill2"] = 0;
                                                                                            }
                                                                                            if ($item["luck2"] == NULL || empty($item["luck2"])) {
                                                                                                $item["luck2"] = 0;
                                                                                            }
                                                                                            if ($item["opt2"] == NULL || empty($item["opt2"])) {
                                                                                                $item["opt2"] = 0;
                                                                                            }
                                                                                            if ($item["exl2"] == NULL || empty($item["exl2"])) {
                                                                                                $item["exl2"] = 0;
                                                                                            }
                                                                                            if ($item["isanc"] == NULL || empty($item["isanc"])) {
                                                                                                $item["isanc"] = 0;
                                                                                            }
                                                                                            if ($item["type"] == $req_item[0] && $item["id"] == $req_item[1] && $item["level"] == $req_item[2] && $item["skill2"] == $req_item[3] && $item["luck2"] == $req_item[4] && $item["opt2"] == $req_item[5] && $item["exl2"] == $req_item[6] && $item["isanc"] == $req_item[7]) {
                                                                                                if (140 <= config("server_files_season", true)) {
                                                                                                    if ($this->checkJewel($item["type"], $item["id"])) {
                                                                                                        if (0 < $item["dur"]) {
                                                                                                            if ($tmp_items_count <= $item["dur"]) {
                                                                                                                $found = $found + $tmp_items_count;
                                                                                                                $tmp_items_count = 0;
                                                                                                            } else {
                                                                                                                $found = $found + $item["dur"];
                                                                                                                $tmp_items_count = $tmp_items_count - $item["dur"];
                                                                                                            }
                                                                                                            if ($tmp_items_count > "0") {
                                                                                                            }
                                                                                                        }
                                                                                                    } else {
                                                                                                        $found++;
                                                                                                        $tmp_items_count--;
                                                                                                        if ($tmp_items_count > "0") {
                                                                                                        }
                                                                                                    }
                                                                                                } else {
                                                                                                    $found++;
                                                                                                    $tmp_items_count--;
                                                                                                    if ($tmp_items_count > "0") {
                                                                                                    }
                                                                                                }
                                                                                            }
                                                                                            $i++;
                                                                                        }
                                                                                        $l++;
                                                                                    }
                                                                                } else {
                                                                                    if ($achievements[$j]["type"] == "6") {
                                                                                        $info = $dB->query_fetch_single("SELECT sum(KillCount) as KillCount FROM [" . $config["SQL_DB_NAME_RANKING"] . "].[dbo].[EVENT_INFO_IT] WHERE AccountID = ? AND Name = ?", [$username, $char]);
                                                                                        if ($info["KillCount"] == NULL || empty($info["KillCount"])) {
                                                                                            $info["KillCount"] = 0;
                                                                                        }
                                                                                        if ($achievements[$j]["stage"][$stage]["exp"] < $info["KillCount"]) {
                                                                                            $info["KillCount"] = $achievements[$j]["stage"][$stage]["exp"];
                                                                                        }
                                                                                        $found = $info["KillCount"];
                                                                                        $total = $achievements[$j]["stage"][$stage]["exp"];
                                                                                    } else {
                                                                                        if ($achievements[$j]["type"] == "7") {
                                                                                            $info = $dB->query_fetch_single("SELECT WinDuels FROM Character WHERE AccountID = ? AND Name = ?", [$username, $char]);
                                                                                            if ($info["WinDuels"] == NULL || empty($info["WinDuels"])) {
                                                                                                $info["WinDuels"] = 0;
                                                                                            }
                                                                                            if ($achievements[$j]["stage"][$stage]["exp"] < $info["WinDuels"]) {
                                                                                                $info["WinDuels"] = $achievements[$j]["stage"][$stage]["exp"];
                                                                                            }
                                                                                            $found = $info["WinDuels"];
                                                                                            $total = $achievements[$j]["stage"][$stage]["exp"];
                                                                                        } else {
                                                                                            if ($achievements[$j]["type"] == "8") {
                                                                                                $info = $dB->query_fetch_single("SELECT RESETS FROM Character WHERE AccountID = ? AND Name = ?", [$username, $char]);
                                                                                                if ($info["RESETS"] == NULL || empty($info["RESETS"])) {
                                                                                                    $info["RESETS"] = 0;
                                                                                                }
                                                                                                if ($achievements[$j]["stage"][$stage]["exp"] < $info["RESETS"]) {
                                                                                                    $info["RESETS"] = $achievements[$j]["stage"][$stage]["exp"];
                                                                                                }
                                                                                                $found = $info["RESETS"];
                                                                                                $total = $achievements[$j]["stage"][$stage]["exp"];
                                                                                            } else {
                                                                                                if ($achievements[$j]["type"] == "9") {
                                                                                                    $info = $dB->query_fetch_single("SELECT Grand_Resets FROM Character WHERE AccountID = ? AND Name = ?", [$username, $char]);
                                                                                                    if ($info["Grand_Resets"] == NULL || empty($info["Grand_Resets"])) {
                                                                                                        $info["Grand_Resets"] = 0;
                                                                                                    }
                                                                                                    if ($achievements[$j]["stage"][$stage]["exp"] < $info["Grand_Resets"]) {
                                                                                                        $info["Grand_Resets"] = $achievements[$j]["stage"][$stage]["exp"];
                                                                                                    }
                                                                                                    $found = $info["Grand_Resets"];
                                                                                                    $total = $achievements[$j]["stage"][$stage]["exp"];
                                                                                                } else {
                                                                                                    if ($achievements[$j]["type"] == "10") {
                                                                                                        $info = $dB->query_fetch_single("SELECT cLevel FROM Character WHERE AccountID = ? AND Name = ?", [$username, $char]);
                                                                                                        if ($info["cLevel"] == NULL || empty($info["cLevel"])) {
                                                                                                            $info["cLevel"] = 0;
                                                                                                        }
                                                                                                        if ($achievements[$j]["stage"][$stage]["exp"] < $info["cLevel"]) {
                                                                                                            $info["cLevel"] = $achievements[$j]["stage"][$stage]["exp"];
                                                                                                        }
                                                                                                        $found = $info["cLevel"];
                                                                                                        $total = $achievements[$j]["stage"][$stage]["exp"];
                                                                                                    } else {
                                                                                                        if ($achievements[$j]["type"] == "11") {
                                                                                                            $info = $dB->query_fetch_single("SELECT mLevel FROM Character WHERE AccountID = ? AND Name = ?", [$username, $char]);
                                                                                                            if ($info["mLevel"] == NULL || empty($info["mLevel"])) {
                                                                                                                $info["mLevel"] = 0;
                                                                                                            }
                                                                                                            if ($achievements[$j]["stage"][$stage]["exp"] < $info["mLevel"]) {
                                                                                                                $info["mLevel"] = $achievements[$j]["stage"][$stage]["exp"];
                                                                                                            }
                                                                                                            $found = $info["mLevel"];
                                                                                                            $total = $achievements[$j]["stage"][$stage]["exp"];
                                                                                                        } else {
                                                                                                            if ($achievements[$j]["type"] == "12") {
                                                                                                                $info = $dB->query_fetch_single("SELECT count(*) as kills FROM C_PlayerKiller_Info WHERE Killer = ?", [$char]);
                                                                                                                if ($info["kills"] == NULL || empty($info["kills"])) {
                                                                                                                    $info["kills"] = 0;
                                                                                                                }
                                                                                                                if ($achievements[$j]["stage"][$stage]["exp"] < $info["kills"]) {
                                                                                                                    $info["kills"] = $achievements[$j]["stage"][$stage]["exp"];
                                                                                                                }
                                                                                                                $found = $info["kills"];
                                                                                                                $total = $achievements[$j]["stage"][$stage]["exp"];
                                                                                                            } else {
                                                                                                                if ($achievements[$j]["type"] == "13") {
                                                                                                                    $info = $dB->query_fetch_single("SELECT sum(Points) as Points FROM IGC_Gens WHERE Name = ?", [$char]);
                                                                                                                    if ($info["Points"] == NULL || empty($info["Points"])) {
                                                                                                                        $info["Points"] = 0;
                                                                                                                    }
                                                                                                                    if ($achievements[$j]["stage"][$stage]["exp"] < $info["Points"]) {
                                                                                                                        $info["Points"] = $achievements[$j]["stage"][$stage]["exp"];
                                                                                                                    }
                                                                                                                    $found = $info["Points"];
                                                                                                                    $total = $achievements[$j]["stage"][$stage]["exp"];
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
                                                            }
                                                            if ($total <= $found) {
                                                                $item_err = false;
                                                                switch ($achievements[$j]["stage"][$stage]["reward_type"]) {
                                                                    case 1:
                                                                        $reward = $achievements[$j]["stage"][$stage]["reward"];
                                                                        if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                                                            $give_reward = $dB2->query("UPDATE MEMB_CREDITS SET platinum = platinum + ? WHERE memb___id = ?", [$reward, $username]);
                                                                        } else {
                                                                            $give_reward = $dB->query("UPDATE MEMB_CREDITS SET platinum = platinum + ? WHERE memb___id = ?", [$reward, $username]);
                                                                        }
                                                                        $add_log = $dB->query("INSERT INTO IMPERIAMUCMS_ACHIEVEMENTS_LOGS (AccountID, Name, achiev_uid, achiev_stage, reward, date) VALUES (?, ?, ?, ?, ?, ?)", [$username, $char, $uid, $stage, $reward . " " . lang("currency_platinum", true), date("Y-m-d H:i:s", time())]);
                                                                        break;
                                                                    case 2:
                                                                        $reward = $achievements[$j]["stage"][$stage]["reward"];
                                                                        if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                                                            $give_reward = $dB2->query("UPDATE MEMB_CREDITS SET gold = gold + ? WHERE memb___id = ?", [$reward, $username]);
                                                                        } else {
                                                                            $give_reward = $dB->query("UPDATE MEMB_CREDITS SET gold = gold + ? WHERE memb___id = ?", [$reward, $username]);
                                                                        }
                                                                        $add_log = $dB->query("INSERT INTO IMPERIAMUCMS_ACHIEVEMENTS_LOGS (AccountID, Name, achiev_uid, achiev_stage, reward, date) VALUES (?, ?, ?, ?, ?, ?)", [$username, $char, $uid, $stage, $reward . " " . lang("currency_gold", true), date("Y-m-d H:i:s", time())]);
                                                                        break;
                                                                    case 3:
                                                                        $reward = $achievements[$j]["stage"][$stage]["reward"];
                                                                        if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                                                            $give_reward = $dB2->query("UPDATE MEMB_CREDITS SET silver = silver + ? WHERE memb___id = ?", [$reward, $username]);
                                                                        } else {
                                                                            $give_reward = $dB->query("UPDATE MEMB_CREDITS SET silver = silver + ? WHERE memb___id = ?", [$reward, $username]);
                                                                        }
                                                                        $add_log = $dB->query("INSERT INTO IMPERIAMUCMS_ACHIEVEMENTS_LOGS (AccountID, Name, achiev_uid, achiev_stage, reward, date) VALUES (?, ?, ?, ?, ?, ?)", [$username, $char, $uid, $stage, $reward . " " . lang("currency_silver", true), date("Y-m-d H:i:s", time())]);
                                                                        break;
                                                                    case 4:
                                                                        $reward = $achievements[$j]["stage"][$stage]["reward"];
                                                                        if (100 <= config("server_files_season", true)) {
                                                                            $give_reward = $dB->query("UPDATE T_InGameShop_Point SET WCoin = WCoin + ? WHERE AccountID = ?", [$reward, $username]);
                                                                        } else {
                                                                            $give_reward = $dB->query("UPDATE T_InGameShop_Point SET WCoinC = WCoinC + ? WHERE AccountID = ?", [$reward, $username]);
                                                                        }
                                                                        $add_log = $dB->query("INSERT INTO IMPERIAMUCMS_ACHIEVEMENTS_LOGS (AccountID, Name, achiev_uid, achiev_stage, reward, date) VALUES (?, ?, ?, ?, ?, ?)", [$username, $char, $uid, $stage, $reward . " " . lang("currency_wcoinc", true), date("Y-m-d H:i:s", time())]);
                                                                        break;
                                                                    case 5:
                                                                        $reward = $achievements[$j]["stage"][$stage]["reward"];
                                                                        $give_reward = $dB->query("UPDATE T_InGameShop_Point SET GoblinPoint = GoblinPoint + ? WHERE AccountID = ?", [$reward, $username]);
                                                                        $add_log = $dB->query("INSERT INTO IMPERIAMUCMS_ACHIEVEMENTS_LOGS (AccountID, Name, achiev_uid, achiev_stage, reward, date) VALUES (?, ?, ?, ?, ?, ?)", [$username, $char, $uid, $stage, $reward . " " . lang("currency_gp", true), date("Y-m-d H:i:s", time())]);
                                                                        break;
                                                                    case 6:
                                                                        $reward = $achievements[$j]["stage"][$stage]["reward"];
                                                                        $give_reward = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET zen = zen + ? WHERE AccountID = ?", [$reward, $username]);
                                                                        $add_log = $dB->query("INSERT INTO IMPERIAMUCMS_ACHIEVEMENTS_LOGS (AccountID, Name, achiev_uid, achiev_stage, reward, date) VALUES (?, ?, ?, ?, ?, ?)", [$username, $char, $uid, $stage, $reward . " " . lang("currency_zen", true) . "", date("Y-m-d H:i:s", time())]);
                                                                        break;
                                                                    case 7:
                                                                        $ach_rew_items = count($achievements[$j]["stage"][$stage]["rew_items"]);
                                                                        $total_rew_items = array_sum($achievements[$j]["stage"][$stage]["rew_items_count"]);
                                                                        $found_rew_items = 0;
                                                                        $reward_items_log = "";
                                                                        $vault = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT Items FROM warehouse WHERE AccountID = ?), 2) AS vault", [$username]);
                                                                        $vault = $vault["vault"];
                                                                        $l = 1;
                                                                        while ($l <= $ach_rew_items) {
                                                                            $rew_item = explode(",", $achievements[$j]["stage"][$stage]["rew_items"][$l]);
                                                                            list($sy, $ioo) = $rew_item;
                                                                            if (256 <= $sy) {
                                                                                $sy = $sy - 256;
                                                                                $ioo += 128;
                                                                            }
                                                                            $code = __ITEM_EMPTY__;
                                                                            $code = substr_replace($code, sprintf("%01X", $rew_item[0]), 18, 1);
                                                                            $code = substr_replace($code, sprintf("%02X", $sy), 0, 2);
                                                                            if (3 < $rew_item[5]) {
                                                                                $opt = 3;
                                                                                $opt2 = $rew_item[5] - 3;
                                                                            } else {
                                                                                $opt = $rew_item[5];
                                                                                $opt2 = 0;
                                                                            }
                                                                            if ($rew_item[7] != 0) {
                                                                                $easytoyou_decoder_beta_not_finish -= 1;
                                                                            }
                                                                            $lvl = $rew_item[2] * 8 + $rew_item[3] * 128 + $rew_item[4] * 4 + $opt;
                                                                            $code = substr_replace($code, sprintf("%02X", $lvl), 2, 2);
                                                                            $code = substr_replace($code, sprintf("%02X", 0), 4, 2);
                                                                            $code = substr_replace($code, sprintf("%02X", $ioo), 14, 2);
                                                                            $code = substr_replace($code, sprintf("%02X", $rew_item[7]), 16, 2);
                                                                            $code = substr_replace($code, "0", 19, 1);
                                                                            $code = substr_replace($code, "0", 20, 1);
                                                                            $code = substr_replace($code, "0", 21, 1);
                                                                            $code = substr_replace($code, "00000000", 6, 8);
                                                                            $ItemInfo = $Items->ItemInfo($code);
                                                                            $tmp2 = $achievements[$j]["stage"][$stage]["rew_items_count"][$l];
                                                                            while (0 < $tmp2) {
                                                                                $newitem = $code;
                                                                                $test = 0;
                                                                                $slot = $Market->smartsearch2($username, $vault, $ItemInfo["X"], $ItemInfo["Y"]);
                                                                                $test = $slot * __ITEM_LENGTH__;
                                                                                if ($slot == 1337) {
                                                                                    message("error", lang("achievement_error_9", true));
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
                                                                                    $vault = substr_replace($vault, $newitem, $test, __ITEM_LENGTH__);
                                                                                    $reward_items_log .= $newitem . ";";
                                                                                    $tmp2--;
                                                                                }
                                                                            }
                                                                            $l++;
                                                                        }
                                                                        if (!$item_err) {
                                                                            $vault = "0x" . $vault;
                                                                            $give_reward = $dB->query("UPDATE warehouse SET Items = " . $vault . " WHERE AccountID = '" . $username . "'");
                                                                            $add_log = $dB->query("INSERT INTO IMPERIAMUCMS_ACHIEVEMENTS_LOGS (AccountID, Name, achiev_uid, achiev_stage, reward, date) VALUES (?, ?, ?, ?, ?, ?)", [$username, $char, $uid, $stage, $reward_items_log, date("Y-m-d H:i:s", time())]);
                                                                        }
                                                                        break;
                                                                    case 8:
                                                                        $reward = $achievements[$j]["stage"][$stage]["reward"];
                                                                        $give_reward = $dB->query("UPDATE Character SET LevelUpPoint = LevelUpPoint + ? WHERE AccountID = ? AND Name = ?", [$reward, $username, $char]);
                                                                        $add_log = $dB->query("INSERT INTO IMPERIAMUCMS_ACHIEVEMENTS_LOGS (AccountID, Name, achiev_uid, achiev_stage, reward, date) VALUES (?, ?, ?, ?, ?, ?)", [$username, $char, $uid, $stage, $reward . " Level Up Points", date("Y-m-d H:i:s", time())]);
                                                                        break;
                                                                    case 9:
                                                                        $reward = $achievements[$j]["stage"][$stage]["reward"];
                                                                        $give_reward = $dB->query("UPDATE Character SET mlPoint = mlPoint + ? WHERE AccountID = ? AND Name = ?", [$reward, $username, $char]);
                                                                        $add_log = $dB->query("INSERT INTO IMPERIAMUCMS_ACHIEVEMENTS_LOGS (AccountID, Name, achiev_uid, achiev_stage, reward, date) VALUES (?, ?, ?, ?, ?, ?)", [$username, $char, $uid, $stage, $reward . " Master Points", date("Y-m-d H:i:s", time())]);
                                                                        break;
                                                                    default:
                                                                        if ($give_reward) {
                                                                            $points = $achievements[$j]["stage"][$stage]["points"];
                                                                            if ($check_reward["Stage"] == NULL || empty($check_reward["Stage"])) {
                                                                                $update = $dB->query("INSERT INTO IMPERIAMUCMS_ACHIEVEMENTS(AccountID,Name,Achievement,Stage) VALUES(?,?,?,?)", [$username, $char, $uid, $stage]);
                                                                            } else {
                                                                                $update = $dB->query("UPDATE IMPERIAMUCMS_ACHIEVEMENTS SET Stage = ? WHERE AccountID = ? AND Name = ? AND Achievement = ?", [$stage, $username, $char, $uid]);
                                                                            }
                                                                            $check_ranking = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_ACHIEVEMENTS_RANKING WHERE AccountID = ? AND Name = ?", [$username, $char]);
                                                                            if ($check_ranking["AccountID"] == NULL || empty($check_ranking["AccountID"])) {
                                                                                $update2 = $dB->query("INSERT INTO IMPERIAMUCMS_ACHIEVEMENTS_RANKING(AccountID,Name,Completed,Points) VALUES(?,?,?,?)", [$username, $char, 1, $points]);
                                                                            } else {
                                                                                $update2 = $dB->query("UPDATE IMPERIAMUCMS_ACHIEVEMENTS_RANKING SET Completed = Completed + ?, Points = Points + ? WHERE AccountID = ? AND Name = ?", [1, $points, $username, $char]);
                                                                            }
                                                                            if ($update && $update2) {
                                                                                if ($achievements[$j]["type"] == "1") {
                                                                                    $update3 = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET zen = zen - ? WHERE AccountID = ?", [$achievements[$j]["stage"][$stage]["zen"], $username]);
                                                                                } else {
                                                                                    if ($achievements[$j]["type"] == "5") {
                                                                                        $ach_items = count($achievements[$j]["stage"][$stage]["items"]);
                                                                                        $vault = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT Items FROM warehouse WHERE AccountID = ?), 2) AS vault", [$username]);
                                                                                        $vault = $vault["vault"];
                                                                                        $l = 1;
                                                                                        while ($l <= $ach_items) {
                                                                                            $req_item = explode(",", $achievements[$j]["stage"][$stage]["items"][$l]);
                                                                                            $i = 0;
                                                                                            $tmp = $achievements[$j]["stage"][$stage]["items_count"][$l];
                                                                                            while ($i < 240) {
                                                                                                $item_code = substr($vault, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__);
                                                                                                $item = $Items->ItemInfo($item_code);
                                                                                                if ($item["sticklevel"] == NULL || empty($item["sticklevel"])) {
                                                                                                    $item["sticklevel"] = 0;
                                                                                                }
                                                                                                if ($item["skill2"] == NULL || empty($item["skill2"])) {
                                                                                                    $item["skill2"] = 0;
                                                                                                }
                                                                                                if ($item["luck2"] == NULL || empty($item["luck2"])) {
                                                                                                    $item["luck2"] = 0;
                                                                                                }
                                                                                                if ($item["opt2"] == NULL || empty($item["opt2"])) {
                                                                                                    $item["opt2"] = 0;
                                                                                                }
                                                                                                if ($item["exl2"] == NULL || empty($item["exl2"])) {
                                                                                                    $item["exl2"] = 0;
                                                                                                }
                                                                                                if ($item["isanc"] == NULL || empty($item["isanc"])) {
                                                                                                    $item["isanc"] = 0;
                                                                                                }
                                                                                                if ($item["type"] == $req_item[0] && $item["id"] == $req_item[1] && $item["sticklevel"] == $req_item[2] && $item["skill2"] == $req_item[3] && $item["luck2"] == $req_item[4] && $item["opt2"] == $req_item[5] && $item["exl2"] == $req_item[6] && $item["isanc"] == $req_item[7]) {
                                                                                                    if (140 <= config("server_files_season", true)) {
                                                                                                        if ($this->checkJewel($item["type"], $item["id"])) {
                                                                                                            if (0 < $item["dur"]) {
                                                                                                                $durCounter = 0;
                                                                                                                while ($durCounter < $item["dur"]) {
                                                                                                                    $dur = hexdec(substr($item_code, 4, 2));
                                                                                                                    $dur = $dur - 1;
                                                                                                                    if (0 < $dur) {
                                                                                                                        $item_code = substr_replace($item_code, sprintf("%02X", $dur), 4, 2);
                                                                                                                        $vault = substr_replace($vault, $item_code, $i * __ITEM_LENGTH__, __ITEM_LENGTH__);
                                                                                                                    } else {
                                                                                                                        $vault = substr_replace($vault, __ITEM_EMPTY__, $i * __ITEM_LENGTH__, __ITEM_LENGTH__);
                                                                                                                    }
                                                                                                                    $tmp--;
                                                                                                                    if ($tmp > "0") {
                                                                                                                        $durCounter++;
                                                                                                                    }
                                                                                                                }
                                                                                                                if ($tmp > "0") {
                                                                                                                }
                                                                                                            }
                                                                                                        } else {
                                                                                                            $tmp--;
                                                                                                            $vault = substr_replace($vault, __ITEM_EMPTY__, $i * __ITEM_LENGTH__, __ITEM_LENGTH__);
                                                                                                            if ($tmp > "0") {
                                                                                                            }
                                                                                                        }
                                                                                                    } else {
                                                                                                        $tmp--;
                                                                                                        $vault = substr_replace($vault, __ITEM_EMPTY__, $i * __ITEM_LENGTH__, __ITEM_LENGTH__);
                                                                                                        if ($tmp > "0") {
                                                                                                        }
                                                                                                    }
                                                                                                }
                                                                                                $i++;
                                                                                            }
                                                                                            $l++;
                                                                                        }
                                                                                        $vault = "0x" . $vault;
                                                                                        $update3 = $dB->query("UPDATE warehouse SET Items = " . $vault . " WHERE AccountID = '" . $username . "'");
                                                                                    } else {
                                                                                        $update3 = true;
                                                                                    }
                                                                                }
                                                                                if ($update3) {
                                                                                    $reward_type_name = $this->rewardTypeWithCount($achievements, $stage, $j);
                                                                                    message("success", lang("achievement_txt_19", true) . " " . $reward_type_name . " " . lang("achievement_txt_20", true));
                                                                                    $logDate = date("Y-m-d H:i:s", time());
                                                                                    $common->accountLogs($username, "achievements", lang("achievement_txt_21", true) . " " . $reward_type_name . " " . lang("achievement_txt_22", true) . " " . $achievements[$j]["name"] . " " . lang("achievement_txt_23", true) . " " . $stage . ".", $logDate);
                                                                                }
                                                                            } else {
                                                                                message("error", lang("error_23", true));
                                                                            }
                                                                        } else {
                                                                            message("error", lang("error_23", true));
                                                                        }
                                                                }
                                                            } else {
                                                                message("error", lang("achievement_error_10", true));
                                                            }
                                                        } else {
                                                            message("error", lang("error_14", true));
                                                        }
                                                    } else {
                                                        message("error", lang("achievement_error_4", true));
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
    public function checkJewel($itemCat, $itemId)
    {
        if ($itemCat == 12 && $itemId == 15) {
            return true;
        }
        if ($itemCat == 14 && ($itemId == 13 || $itemId == 14 || $itemId == 16 || $itemId == 22 || $itemId == 31 || $itemId == 42)) {
            return true;
        }
        return false;
    }
}

?>