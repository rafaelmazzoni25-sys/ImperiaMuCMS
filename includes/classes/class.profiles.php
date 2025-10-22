<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class Profile
{
    private $_request = NULL;
    private $_type = NULL;
    private $_reqMaxLen = NULL;
    private $_guildsCachePath = NULL;
    private $_playersCachePath = NULL;
    private $_cacheUpdateTime = NULL;
    private $_fileData = NULL;
    public function __construct(dB $dB, common $common)
    {
        $this->common = $common;
        $this->dB = $dB;
        $this->_guildsCachePath = __PATH_CACHE__ . "profiles/guilds/";
        $this->_playersCachePath = __PATH_CACHE__ . "profiles/players/";
        $this->_cacheUpdateTime = 3600;
        $this->checkCacheDir($this->_guildsCachePath);
        $this->checkCacheDir($this->_playersCachePath);
    }
    private function checkCacheDir($path)
    {
        if (check_value($path)) {
            if (!file_exists($path) || !is_dir($path)) {
                if (config("error_reporting", true)) {
                    throw new Exception("Invalid cache directory (" . $path . ")");
                }
                throw new Exception(lang("error_21", true));
            }
            if (!is_writable($path)) {
                if (config("error_reporting", true)) {
                    throw new Exception("The cache directory is not writable (" . $path . ")");
                }
                throw new Exception(lang("error_21", true));
            }
        }
    }
    public function setType($input)
    {
        switch ($input) {
            case "guild":
                $this->_type = "guild";
                $this->_reqMaxLen = 8;
                break;
            default:
                $this->_type = "player";
                $this->_reqMaxLen = 10;
        }
    }
    public function setRequest($input)
    {
        mb_internal_encoding("UTF-8");
        $input2 = html_entity_decode($input, ENT_QUOTES, "UTF-8");
        if ($this->_reqMaxLen < mb_strlen($input2)) {
            throw new Exception(lang("error_25", true));
        }
        if (mb_strlen($input2) < 4) {
            throw new Exception(lang("error_25", true));
        }
        $this->_request = $input;
    }
    public function data()
    {
        if (!check_value($this->_type)) {
            throw new Exception(lang("error_21", true));
        }
        if (!check_value($this->_request)) {
            throw new Exception(lang("error_21", true));
        }
        $this->checkCache();
        return explode("|", $this->_fileData);
    }
    private function checkCache()
    {
        switch ($this->_type) {
            case "guild":
                $reqFile = $this->_guildsCachePath . hex_encode($this->_request) . ".cache";
                if (!file_exists($reqFile)) {
                    $this->cacheGuildData();
                }
                $fileData = file_get_contents($reqFile);
                $fileData = explode("|", $fileData);
                if (is_array($fileData)) {
                    if ($fileData[0] + $this->_cacheUpdateTime < time()) {
                        $this->cacheGuildData();
                    }
                    $this->_fileData = file_get_contents($reqFile);
                } else {
                    throw new Exception(lang("error_21", true));
                }
                break;
            default:
                $reqFile = $this->_playersCachePath . hex_encode($this->_request) . ".cache";
                if (!file_exists($reqFile)) {
                    $this->cachePlayerData();
                }
                $fileData = file_get_contents($reqFile);
                $fileData = explode("|", $fileData);
                if (is_array($fileData)) {
                    if ($fileData[0] + $this->_cacheUpdateTime < time()) {
                        $this->cachePlayerData();
                    }
                    $this->_fileData = file_get_contents($reqFile);
                } else {
                    throw new Exception(lang("error_21", true));
                }
        }
    }
    private function cacheGuildData()
    {
        global $config;
        if (config("SQL_USE_2_DB", true)) {
            $memb_info = "[" . $config["SQL_DB_2_NAME"] . "].[dbo].[MEMB_INFO]";
        } else {
            $memb_info = "MEMB_INFO";
        }
        $guildData = $this->dB->query_fetch_single("\r\n            SELECT g.G_Name, g.G_Master, CONVERT(varchar(max), g.G_Mark, 2) as G_Mark, g.G_Score, g.G_Union, g.G_Rival, mi.Country, g.Number\r\n            FROM Guild g\r\n            INNER JOIN Character c on g.G_Master = c.Name\r\n            INNER JOIN " . $memb_info . " mi on c.AccountID = mi.memb___id\r\n            WHERE G_Name = ?", [$this->_request]);
        if (!$guildData) {
            throw new Exception(lang("error_25", true));
        }
        if ($guildData["G_Union"] != 0) {
            $alliance = $this->dB->query_fetch("SELECT G_Name, CONVERT(varchar(max), G_Mark, 2) as G_Mark FROM Guild WHERE G_Union = ? AND G_Name != ?", [$guildData["G_Union"], $guildData["G_Name"]]);
            $alliance_str = "";
            $i = 1;
            foreach ($alliance as $thisGuild) {
                $alliance_str .= $thisGuild["G_Name"] . ":" . $thisGuild["G_Mark"];
                if ($i < count($alliance)) {
                    $alliance_str .= ",";
                }
                $i++;
            }
        }
        if ($guildData["G_Rival"] != 0) {
            $rivals = $this->dB->query_fetch("SELECT G_Name, CONVERT(varchar(max), G_Mark, 2) as G_Mark FROM Guild WHERE G_Union = ?", [$guildData["G_Rival"]]);
            if (!is_array($rivals)) {
                $rivals = $this->dB->query_fetch_single("SELECT G_Name, CONVERT(varchar(max), G_Mark, 2) as G_Mark FROM Guild WHERE Number = ?", [$guildData["G_Rival"]]);
                $rivals_str = "";
                $i = 1;
                $rivals_str .= $rivals["G_Name"] . ":" . $rivals["G_Mark"];
            } else {
                $rivals_str = "";
                $i = 1;
                foreach ($rivals as $thisGuild) {
                    $rivals_str .= $thisGuild["G_Name"] . ":" . $thisGuild["G_Mark"];
                    if ($i < count($rivals)) {
                        $rivals_str .= ",";
                    }
                    $i++;
                }
            }
        }
        $guildMembers = $this->dB->query_fetch("\r\n            SELECT gm.Name, gm.G_Name, gm.G_Level, gm.G_Status, mi.Country\r\n            FROM GuildMember gm\r\n            INNER JOIN Character c on gm.Name = c.Name\r\n            INNER JOIN " . $memb_info . " mi on c.AccountID = mi.memb___id\r\n            WHERE gm.G_Name = ?\r\n            ORDER BY gm.G_Status DESC", [$this->_request]);
        if (!$guildMembers) {
            throw new Exception(lang("error_25", true));
        }
        $members = [];
        foreach ($guildMembers as $gmember) {
            if ($gmember["G_Status"] == 128) {
                $gmember["G_Status"] = lang("profiles_txt_42", true);
            } else {
                if ($gmember["G_Status"] == 64) {
                    $gmember["G_Status"] = lang("profiles_txt_45", true);
                } else {
                    if ($gmember["G_Status"] == 32) {
                        $gmember["G_Status"] = lang("profiles_txt_46", true);
                    } else {
                        $gmember["G_Status"] = lang("profiles_txt_47", true);
                    }
                }
            }
            $members[] = $gmember["Name"] . ":" . $gmember["G_Status"] . ":" . $gmember["Country"];
        }
        $gmembers_str = implode(",", $members);
        if (substr($guildData["G_Mark"], 0, 2) == "0x") {
            $guildData["G_Mark"] = substr($guildData["G_Mark"], 2);
        }
        $data = [time(), $guildData["G_Name"], $guildData["G_Mark"], $guildData["G_Score"], $guildData["G_Master"], $gmembers_str, $alliance_str, $rivals_str, $guildData["Country"], $guildData["Number"]];
        $cacheData = implode("|", $data);
        $reqFile = $this->_guildsCachePath . hex_encode($this->_request) . ".cache";
        $fp = fopen($reqFile, "w+");
        fwrite($fp, $cacheData);
        fclose($fp);
    }
    private function cachePlayerData()
    {
        global $dB2;
        $playerData = $this->dB->query_fetch_single("\r\n            SELECT AccountID, Name, cLevel, LevelUpPoint, Class, Experience, Strength, Dexterity, Vitality, Energy, CONVERT(VARCHAR(MAX), MagicList, 2) AS MagicList, \r\n            Money, Life, MaxLife, Mana, MaxMana, MapNumber, MapPosX, MapPosY, PkCount, PkLevel, PkTime, MDate, LDate, CtlCode, CONVERT(VARCHAR(MAX), Quest, 2) AS Quest, \r\n            Leadership, ChatLimitTime, FruitPoint, RESETS, CONVERT(VARCHAR(MAX), Inventory, 2) AS Inventory, Married, MarryName, mLevel, mlPoint, mlExperience, mlNextExp, \r\n            InventoryExpansion, WinDuels, LoseDuels, Grand_Resets \r\n            FROM " . _TBL_CHR_ . " WHERE " . _CLMN_CHR_NAME_ . " = ?", [$this->_request]);
        if (!$playerData) {
            throw new Exception(lang("error_25", true));
        }
        if (config("SQL_USE_2_DB", true)) {
            $membData = $dB2->query_fetch_single("SELECT * FROM MEMB_STAT WHERE memb___id = ?", [$playerData["AccountID"]]);
        } else {
            $membData = $this->dB->query_fetch_single("SELECT * FROM MEMB_STAT WHERE memb___id = ?", [$playerData["AccountID"]]);
        }
        $guild = "";
        $guildData = $this->dB->query_fetch_single("SELECT * FROM " . _TBL_GUILDMEMB_ . " WHERE " . _CLMN_GUILDMEMB_CHAR_ . " = ?", [$this->_request]);
        $guildMembers = $this->dB->query_fetch_single("SELECT COUNT(*) as count FROM GuildMember WHERE G_Name = '" . $guildData["G_Name"] . "'");
        $guildMaster = $this->dB->query_fetch_single("SELECT G_Master, CONVERT(varchar(max), G_Mark, 2) as G_Mark FROM Guild WHERE G_Name = '" . $guildData["G_Name"] . "'");
        $status = 0;
        if ($this->common->accountOnline($playerData[_CLMN_CHR_ACCID_])) {
            $status = 1;
        }
        $Character = new Character();
        $country1 = $Character->getCharacterFlag($playerData[_CLMN_CHR_NAME_]);
        $country2 = "";
        $gens = $this->dB->query_fetch_single("SELECT * FROM IGC_Gens WHERE Name = ?", [$this->_request]);
        $chars = $this->dB->query_fetch("SELECT Name FROM Character WHERE AccountID = ?", [$playerData["AccountID"]]);
        $charsArray = [];
        foreach ($chars as $charName) {
            array_push($charsArray, $charName["Name"]);
        }
        $charsArray = array_filter($charsArray);
        $char_list = implode(",", $charsArray);
        if ($guildData["G_Name"] == NULL) {
            $guildData["G_Name"] = "--";
            $guildMaster["G_Master"] = "--";
            $guildMembers["count"] = "--";
        } else {
            $country2 = $Character->getCharacterFlag($guildMaster["G_Master"]);
        }
        $data = [time(), $playerData[_CLMN_CHR_NAME_], $playerData[_CLMN_CHR_CLASS_], $playerData[_CLMN_CHR_LVL_], $playerData["mLevel"], $playerData[_CLMN_CHR_RSTS_], $playerData[_CLMN_CHR_GRSTS_], $playerData["MapNumber"], $playerData["PkLevel"], $status, strtotime($membData["ConnectTM"]), strtotime($membData["DisConnectTM"]), $membData["OnlineTime"], $guildData["G_Name"], $guildMaster["G_Master"], $guildMembers["count"], $guildMaster["G_Mark"], $country1, $country2, $gens["Influence"], $gens["Points"], $gens["Class"], $playerData["Strength"], $playerData["Dexterity"], $playerData["Vitality"], $playerData["Energy"], $playerData["Leadership"], $char_list];
        $cacheData = implode("|", $data);
        $reqFile = $this->_playersCachePath . hex_encode($this->_request) . ".cache";
        $fp = fopen($reqFile, "w+");
        fwrite($fp, $cacheData);
        fclose($fp);
    }
    public function GetCharInventoryResponsive($name)
    {
        global $dB;
        $Items = new Items();
        $name = xss_clean($name);
        $getAccountId = $dB->query_fetch_single("SELECT TOP 1 AccountID FROM Character WHERE Name = ?", [$name]);
        $inventory = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT Inventory FROM Character WHERE Name = ?), 2) AS items", [$name]);
        $sqll = $inventory["items"];
        $i = 0;
        while ($i <= 238) {
            if ($i == 12) {
                $i = 236;
            } else {
                $item[$i] = $Items->ItemInfo(substr($sqll, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__), $getAccountId["AccountID"], $name, 0);
                if ($item[$i] != __ITEM_EMPTY__) {
                    $item[$i] = $Items->ItemInfo(substr($sqll, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__), $getAccountId["AccountID"], $name, 0);
                    if ($item[$i] == NULL) {
                        $item[$i]["thumb"] = "";
                        $title_content[$i] = lang("profiles_txt_48", true);
                    } else {
                        $title_content[$i] = $Items->generateItemTooltip($item[$i], 1, 1, 1, 1, 0, 0);
                    }
                }
                $i++;
            }
        }
        $bgImage = "inventory_bg2";
        if (132 <= config("server_files_season", true)) {
            $bgImage = "inventory_bg";
        }
        $inv = "<div style='width: 421px; height: 345px; background:url(" . __PATH_TEMPLATE_ASSETS__ . "images/" . $bgImage . ".png) no-repeat center top;'>";
        if ($item[0]["thumb"]) {
            $inv .= "<div class='profile_item0' style='background: url(" . $item[0]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip(" . $title_content[0] . ");\" onmouseout=\"UnTip();\">&nbsp;</div>";
        } else {
            $inv .= "<div class='profile_item0' style='background: url(" . $item[0]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip('" . lang("profiles_txt_48", true) . "');\" onmouseout=\"UnTip();\">&nbsp;</div>";
        }
        if ($item[1]["thumb"]) {
            $inv .= "<div class='profile_item1' style='background: url(" . $item[1]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip(" . $title_content[1] . ");\" onmouseout=\"UnTip();\">&nbsp;</div>";
        } else {
            $inv .= "<div class='profile_item1' style='background: url(" . $item[1]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip('" . lang("profiles_txt_48", true) . "');\" onmouseout=\"UnTip();\">&nbsp;</div>";
        }
        if ($item[2]["thumb"]) {
            $inv .= "<div class='profile_item2' style='background: url(" . $item[2]["thumb"] . ") no-repeat center center;' \tonmouseover=\"Tip(" . $title_content[2] . ");\" onmouseout=\"UnTip();\">&nbsp;</div>";
        } else {
            $inv .= "<div class='profile_item2' style='background: url(" . $item[2]["thumb"] . ") no-repeat center center;' \tonmouseover=\"Tip('" . lang("profiles_txt_48", true) . "');\" onmouseout=\"UnTip();\">&nbsp;</div>";
        }
        if ($item[3]["thumb"]) {
            $inv .= "<div class='profile_item3' style='background: url(" . $item[3]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip(" . $title_content[3] . ");\" onmouseout=\"UnTip();\">&nbsp;</div>";
        } else {
            $inv .= "<div class='profile_item3' style='background: url(" . $item[3]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip('" . lang("profiles_txt_48", true) . "');\" onmouseout=\"UnTip();\">&nbsp;</div>";
        }
        if ($item[4]["thumb"]) {
            $inv .= "<div class='profile_item4' style='background: url(" . $item[4]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip(" . $title_content[4] . ");\" onmouseout=\"UnTip();\">&nbsp;</div>";
        } else {
            $inv .= "<div class='profile_item4' style='background: url(" . $item[4]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip('" . lang("profiles_txt_48", true) . "');\" onmouseout=\"UnTip();\">&nbsp;</div>";
        }
        if ($item[5]["thumb"]) {
            $inv .= "<div class='profile_item5' style='background: url(" . $item[5]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip(" . $title_content[5] . ");\" onmouseout=\"UnTip();\">&nbsp;</div>";
        } else {
            $inv .= "<div class='profile_item5' style='background: url(" . $item[5]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip('" . lang("profiles_txt_48", true) . "');\" onmouseout=\"UnTip();\">&nbsp;</div>";
        }
        if ($item[6]["thumb"]) {
            $inv .= "<div class='profile_item6' style='background: url(" . $item[6]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip(" . $title_content[6] . ");\" onmouseout=\"UnTip();\">&nbsp;</div>";
        } else {
            $inv .= "<div class='profile_item6' style='background: url(" . $item[6]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip('" . lang("profiles_txt_48", true) . "');\" onmouseout=\"UnTip();\">&nbsp;</div>";
        }
        if ($item[7]["thumb"]) {
            $inv .= "<div class='profile_item7' style='background: url(" . $item[7]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip(" . $title_content[7] . ");\" onmouseout=\"UnTip();\">&nbsp;</div>";
        } else {
            $inv .= "<div class='profile_item7' style='background: url(" . $item[7]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip('" . lang("profiles_txt_48", true) . "');\" onmouseout=\"UnTip();\">&nbsp;</div>";
        }
        if ($item[8]["thumb"]) {
            $inv .= "<div class='profile_item8' style='background: url(" . $item[8]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip(" . $title_content[8] . ");\" onmouseout=\"UnTip();\">&nbsp;</div>";
        } else {
            $inv .= "<div class='profile_item8' style='background: url(" . $item[8]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip('" . lang("profiles_txt_48", true) . "');\" onmouseout=\"UnTip();\">&nbsp;</div>";
        }
        if ($item[9]["thumb"]) {
            $inv .= "<div class='profile_item9' style='background: url(" . $item[9]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip(" . $title_content[9] . ");\" onmouseout=\"UnTip();\">&nbsp;</div>";
        } else {
            $inv .= "<div class='profile_item9' style='background: url(" . $item[9]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip('" . lang("profiles_txt_48", true) . "');\" onmouseout=\"UnTip();\">&nbsp;</div>";
        }
        if ($item[10]["thumb"]) {
            $inv .= "<div class='profile_item10' style='background: url(" . $item[10]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip(" . $title_content[10] . ");\" onmouseout=\"UnTip();\">&nbsp;</div>";
        } else {
            $inv .= "<div class='profile_item10' style='background: url(" . $item[10]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip('" . lang("profiles_txt_48", true) . "');\" onmouseout=\"UnTip();\">&nbsp;</div>";
        }
        if ($item[11]["thumb"]) {
            $inv .= "<div class='profile_item11' style='background: url(" . $item[11]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip(" . $title_content[11] . ");\" onmouseout=\"UnTip();\">&nbsp;</div>";
        } else {
            $inv .= "<div class='profile_item11' style='background: url(" . $item[11]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip('" . lang("profiles_txt_48", true) . "');\" onmouseout=\"UnTip();\">&nbsp;</div>";
        }
        if (70 <= config("server_files_season", true)) {
            if ($item[236]["thumb"]) {
                $inv .= "<div class='profile_item236' style='background: url(" . $item[236]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip(" . $title_content[236] . ");\" onmouseout=\"UnTip();\">&nbsp;</div>";
            } else {
                $inv .= "<div class='profile_item236' style='background: url(" . $item[236]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip('" . lang("profiles_txt_48", true) . "');\" onmouseout=\"UnTip();\">&nbsp;</div>";
            }
            if (140 <= config("server_files_season", true)) {
                if ($item[237]["thumb"]) {
                    $inv .= "<div class='profile_item237' style='background: url(" . $item[237]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip(" . $title_content[237] . ");\" onmouseout=\"UnTip();\">&nbsp;</div>";
                } else {
                    $inv .= "<div class='profile_item237' style='background: url(" . $item[237]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip('" . lang("profiles_txt_48", true) . "');\" onmouseout=\"UnTip();\">&nbsp;</div>";
                }
                if ($item[238]["thumb"]) {
                    $inv .= "<div class='profile_item238' style='background: url(" . $item[238]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip(" . $title_content[238] . ");\" onmouseout=\"UnTip();\">&nbsp;</div>";
                } else {
                    $inv .= "<div class='profile_item238' style='background: url(" . $item[238]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip('" . lang("profiles_txt_48", true) . "');\" onmouseout=\"UnTip();\">&nbsp;</div>";
                }
            }
        }
        $inv .= "</div>";
        return $inv;
    }
    public function GetCharInventory($name, $class)
    {
        global $dB;
        $Items = new Items();
        $name = xss_clean($name);
        $inventory = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT Inventory FROM Character WHERE Name = ?), 2) AS items", [$name]);
        $sqll = $inventory["items"];
        $i = -1;
        while ($i < 11) {
            $i++;
            $item[$i] = $Items->ItemInfo(substr($sqll, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__));
            if ($item[$i] != __ITEM_EMPTY__) {
                $item[$i] = $Items->ItemInfo(substr($sqll, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__));
                if ($item[$i] == NULL) {
                    $item[$i]["thumb"] = "";
                    $title_content[$i] = lang("profiles_txt_48", true);
                } else {
                    $luck = "";
                    $skill = "";
                    $option = "";
                    $exl = "";
                    $ancsetopt = "";
                    if ($item[$i]["level"]) {
                        $item[$i]["level"] = " +" . $item[$i]["level"];
                    } else {
                        $item[$i]["level"] = NULL;
                    }
                    if ($item[$i]["luck"]) {
                        $luck = "<br><font color=#9aadd5>" . $item[$i]["luck"] . "</font>";
                    }
                    if ($item[$i]["skill"]) {
                        $skill = "<br><font color=#9aadd5>" . $item[$i]["skill"] . "</font>";
                    }
                    if ($item[$i]["opt"]) {
                        $option = "<font color=#9aadd5>" . $item[$i]["opt"] . "</font>";
                    }
                    if ($item[$i]["exl"]) {
                        $exl = "<font color=#4d668d>" . str_replace("^^", "<br>", $item[$i]["exl"]) . "</font>";
                    }
                    if ($item[$i]["ancsetopt"]) {
                        $ancsetopt = "<font color=#9aadd5>" . str_replace("^^", "<br>", $item[$i]["ancsetopt"]) . "</font>";
                    }
                    if (0 < $item[$i]["isanc"]) {
                        $title_content[$i] = "<div><span style=\\'color:#2FF387; background-color:#0066CC; padding: 2px 2px 2px 2px;\\'><b>" . addslashes($item[$i]["name"]) . $item[$i]["level"] . "</b></span></div>";
                    } else {
                        if ($item[$i]["socket"] != "") {
                            $title_content[$i] = "<div><span style=\\'color:#CC66CC;\\'><b>" . addslashes($item[$i]["name"]) . $item[$i]["level"] . "</b></span></div>";
                        } else {
                            if ($item[$i]["exl2"]) {
                                $title_content[$i] = "<div><span style=\\'color:#2FF387;\\'><b>" . addslashes($item[$i]["name"]) . $item[$i]["level"] . "</b></span></div>";
                            } else {
                                $title_content[$i] = "<div><b>" . addslashes($item[$i]["name"]) . $item[$i]["level"] . "</b></div>";
                            }
                        }
                    }
                }
            }
        }
        if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
            $bgImage = "inventory_bg2";
            if (132 <= config("server_files_season", true)) {
                $bgImage = "inventory_bg";
            }
            $inv = "<div style='min-width: 421px; height: 345px; background:url(" . __PATH_TEMPLATE_ASSETS__ . "images/" . $bgImage . ".png) no-repeat center top;'>";
        } else {
            $inv = "<div style='position:relative; height:380px; background:url(" . __PATH_TEMPLATE_IMG__ . "profiles/inv_" . $class . ".png) no-repeat center top;'>";
        }
        if ($item[0]["thumb"]) {
            $inv .= "<div class='profile_item0' style='background: url(" . $item[0]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip('" . $title_content[0] . "');\" onmouseout=\"UnTip();\">&nbsp;</div>";
        } else {
            $inv .= "<div class='profile_item0' style='background: url(" . $item[0]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip('" . lang("profiles_txt_48", true) . "');\" onmouseout=\"UnTip();\">&nbsp;</div>";
        }
        if ($item[1]["thumb"]) {
            $inv .= "<div class='profile_item1' style='background: url(" . $item[1]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip('" . $title_content[1] . "');\" onmouseout=\"UnTip();\">&nbsp;</div>";
        } else {
            $inv .= "<div class='profile_item1' style='background: url(" . $item[1]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip('" . lang("profiles_txt_48", true) . "');\" onmouseout=\"UnTip();\">&nbsp;</div>";
        }
        if ($item[2]["thumb"]) {
            $inv .= "<div class='profile_item2' style='background: url(" . $item[2]["thumb"] . ") no-repeat center center;' \tonmouseover=\"Tip('" . $title_content[2] . "');\" onmouseout=\"UnTip();\">&nbsp;</div>";
        } else {
            $inv .= "<div class='profile_item2' style='background: url(" . $item[2]["thumb"] . ") no-repeat center center;' \tonmouseover=\"Tip('" . lang("profiles_txt_48", true) . "');\" onmouseout=\"UnTip();\">&nbsp;</div>";
        }
        if ($item[3]["thumb"]) {
            $inv .= "<div class='profile_item3' style='background: url(" . $item[3]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip('" . $title_content[3] . "');\" onmouseout=\"UnTip();\">&nbsp;</div>";
        } else {
            $inv .= "<div class='profile_item3' style='background: url(" . $item[3]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip('" . lang("profiles_txt_48", true) . "');\" onmouseout=\"UnTip();\">&nbsp;</div>";
        }
        if ($item[4]["thumb"]) {
            $inv .= "<div class='profile_item4' style='background: url(" . $item[4]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip('" . $title_content[4] . "');\" onmouseout=\"UnTip();\">&nbsp;</div>";
        } else {
            $inv .= "<div class='profile_item4' style='background: url(" . $item[4]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip('" . lang("profiles_txt_48", true) . "');\" onmouseout=\"UnTip();\">&nbsp;</div>";
        }
        if ($item[5]["thumb"]) {
            $inv .= "<div class='profile_item5' style='background: url(" . $item[5]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip('" . $title_content[5] . "');\" onmouseout=\"UnTip();\">&nbsp;</div>";
        } else {
            $inv .= "<div class='profile_item5' style='background: url(" . $item[5]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip('" . lang("profiles_txt_48", true) . "');\" onmouseout=\"UnTip();\">&nbsp;</div>";
        }
        if ($item[6]["thumb"]) {
            $inv .= "<div class='profile_item6' style='background: url(" . $item[6]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip('" . $title_content[6] . "');\" onmouseout=\"UnTip();\">&nbsp;</div>";
        } else {
            $inv .= "<div class='profile_item6' style='background: url(" . $item[6]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip('" . lang("profiles_txt_48", true) . "');\" onmouseout=\"UnTip();\">&nbsp;</div>";
        }
        if ($item[7]["thumb"]) {
            $inv .= "<div class='profile_item7' style='background: url(" . $item[7]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip('" . $title_content[7] . "');\" onmouseout=\"UnTip();\">&nbsp;</div>";
        } else {
            $inv .= "<div class='profile_item7' style='background: url(" . $item[7]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip('" . lang("profiles_txt_48", true) . "');\" onmouseout=\"UnTip();\">&nbsp;</div>";
        }
        if ($item[8]["thumb"]) {
            $inv .= "<div class='profile_item8' style='background: url(" . $item[8]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip('" . $title_content[8] . "');\" onmouseout=\"UnTip();\">&nbsp;</div>";
        } else {
            $inv .= "<div class='profile_item8' style='background: url(" . $item[8]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip('" . lang("profiles_txt_48", true) . "');\" onmouseout=\"UnTip();\">&nbsp;</div>";
        }
        if ($item[9]["thumb"]) {
            $inv .= "<div class='profile_item9' style='background: url(" . $item[9]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip('" . $title_content[9] . "');\" onmouseout=\"UnTip();\">&nbsp;</div>";
        } else {
            $inv .= "<div class='profile_item9' style='background: url(" . $item[9]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip('" . lang("profiles_txt_48", true) . "');\" onmouseout=\"UnTip();\">&nbsp;</div>";
        }
        if ($item[10]["thumb"]) {
            $inv .= "<div class='profile_item10' style='background: url(" . $item[10]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip('" . $title_content[10] . "');\" onmouseout=\"UnTip();\">&nbsp;</div>";
        } else {
            $inv .= "<div class='profile_item10' style='background: url(" . $item[10]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip('" . lang("profiles_txt_48", true) . "');\" onmouseout=\"UnTip();\">&nbsp;</div>";
        }
        if ($item[11]["thumb"]) {
            $inv .= "<div class='profile_item11' style='background: url(" . $item[11]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip('" . $title_content[11] . "');\" onmouseout=\"UnTip();\">&nbsp;</div>";
        } else {
            $inv .= "<div class='profile_item11' style='background: url(" . $item[11]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip('" . lang("profiles_txt_48", true) . "');\" onmouseout=\"UnTip();\">&nbsp;</div>";
        }
        $inv .= "</div>";
        return $inv;
    }
    public function getPlayerBadges($charName)
    {
        global $dB;
        $accountName = $dB->query_fetch_single("SELECT AccountID FROM Character WHERE Name = ?", [$charName]);
        $accountId = $accountName["AccountID"];
        return $dB->query_fetch("\r\n            SELECT br.BadgeID, br.AccountID, br.Name, br.Date, br.Tooltip, b.Title, b.TitleLang, b.Image, b.Type1, b.Type2, br.MonsterID\r\n            FROM IMPERIAMUCMS_BADGES_REWARDS br \r\n            INNER JOIN IMPERIAMUCMS_BADGES b ON b.id = br.BadgeID \r\n            WHERE br.AccountID = ? AND br.Status = ?\r\n            ORDER BY Date DESC", [$accountId, 1]);
    }
    public function getGuildBadges($guildNumber)
    {
        global $dB;
        return $dB->query_fetch("\r\n            SELECT br.BadgeID, br.GuildNumber, br.Date, br.Tooltip, b.Title, b.TitleLang, b.Image, b.Type1, b.Type2\r\n            FROM IMPERIAMUCMS_BADGES_REWARDS br \r\n            INNER JOIN IMPERIAMUCMS_BADGES b ON b.id = br.BadgeID \r\n            WHERE br.GuildNumber = ? AND br.Status = ?\r\n            ORDER BY Date DESC", [$guildNumber, 1]);
    }
    public function displayBadge($thisBadge)
    {
        global $config;
        if ($thisBadge["TitleLang"] != NULL && lang($thisBadge["TitleLang"], true) != NULL) {
            if ($thisBadge["Type1"] == 15) {
                $badgeTitle = sprintf(lang($thisBadge["TitleLang"], true), lang("monster_" . $thisBadge["MonsterID"], true));
            } else {
                $badgeTitle = lang($thisBadge["TitleLang"], true);
            }
        } else {
            $badgeTitle = $thisBadge["Title"];
        }
        if (0 < $thisBadge["Type1"] && 1 <= $thisBadge["Type2"] && $thisBadge["Type2"] <= 3) {
            $tooltipData = explode(";", $thisBadge["Tooltip"]);
            $tooltip = sprintf(lang("badge_rank", true), $tooltipData[0]);
            $tooltip .= "<br>";
            $periodData = explode(" - ", $tooltipData[1]);
            $period = date($config["date_format"], strtotime($periodData[0]));
            if ($periodData[1] != NULL) {
                $period .= " - " . date($config["date_format"], strtotime($periodData[1]));
            }
            $tooltip .= sprintf(lang("badge_period", true), $period);
        } else {
            $tooltip = $thisBadge["Tooltip"];
        }
        $badgeTooltip = "<div class='badge-tooltip'><div class='title'>" . addslashes($badgeTitle) . "</div><small>" . addslashes($tooltip) . "</small></div>";
        if (file_exists("" . __PATH_TEMPLATE_ASSETS_ROOT__ . "badges/tooltip/" . $thisBadge["Image"] . "")) {
            $badgeTooltip = "<img src='" . __PATH_TEMPLATE_ASSETS__ . "badges/tooltip/" . $thisBadge["Image"] . "'>" . $badgeTooltip;
        }
        echo "<img src=\"" . __PATH_TEMPLATE_ASSETS__ . "badges/" . $thisBadge["Image"] . "\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"" . $badgeTooltip . "\">";
    }
}

?>