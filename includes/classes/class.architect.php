<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class Architect
{
    public function castleOwnerData()
    {
        global $dB;
        global $config;
        if (config("SQL_USE_2_DB", true)) {
            $memb_info = "[" . $config["SQL_DB_2_NAME"] . "].[dbo].[MEMB_INFO]";
            $memb_stat = "[" . $config["SQL_DB_2_NAME"] . "].[dbo].[MEMB_STAT]";
        } else {
            $memb_info = "[" . $config["SQL_DB_NAME"] . "].[dbo].[MEMB_INFO]";
            $memb_stat = "[" . $config["SQL_DB_NAME"] . "].[dbo].[MEMB_STAT]";
        }
        $castleOwnerData = [];
        $castleOwner = $dB->query_fetch_single("\r\n          SELECT t1.OWNER_GUILD, CONVERT(varchar(max), t2.G_Mark, 2) as G_Mark, t2.G_Master, t2.Number, t1.SIEGE_START_DATE, m.Country \r\n          FROM MuCastle_DATA t1 \r\n          INNER JOIN Guild t2 ON t2.G_Name = t1.OWNER_GUILD\r\n          INNER JOIN Character c ON c.Name = t2.G_Master\r\n          INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID");
        if (!empty($castleOwner["OWNER_GUILD"])) {
            $castleOwnerData["G_Name"] = $castleOwner["OWNER_GUILD"];
            $castleOwnerData["G_Master"] = $castleOwner["G_Master"];
            $castleOwnerData["G_Mark"] = $castleOwner["G_Mark"];
            $castleOwnerData["Number"] = $castleOwner["Number"];
            $castleOwnerData["SIEGE_START_DATE"] = $castleOwner["SIEGE_START_DATE"];
            $castleOwnerData["Country"] = $castleOwner["Country"];
            $castleOwnerData["Alliance"] = [];
            $allianceGuilds = $dB->query_fetch("\r\n              SELECT G_Name, CONVERT(varchar(max), G_Mark, 2) as G_Mark, G_Master\r\n              FROM Guild \r\n              WHERE G_Union = ? AND G_Name != ?", [$castleOwner["Number"], $castleOwner["OWNER_GUILD"]]);
            if (is_array($allianceGuilds)) {
                foreach ($allianceGuilds as $thisGuild) {
                    $guildData = [];
                    $guildData["G_Name"] = $thisGuild["G_Name"];
                    $guildData["G_Master"] = $thisGuild["G_Master"];
                    $guildData["G_Mark"] = $thisGuild["G_Mark"];
                    array_push($castleOwnerData["Alliance"], $guildData);
                }
            }
        } else {
            $castleOwnerData["G_Name"] = "--";
            $castleOwnerData["G_Master"] = NULL;
            $castleOwnerData["G_Mark"] = NULL;
            $castleOwnerData["Number"] = NULL;
            $castleOwnerData["SIEGE_START_DATE"] = "--";
            $castleOwnerData["Alliance"] = NULL;
        }
        return $castleOwnerData;
    }
    public function loadGuildData($char)
    {
        global $dB;
        if (10 < strlen($char)) {
            message("error", lang("error_23", true));
        } else {
            $charGuild = $dB->query_fetch_single("\r\n          SELECT g.G_Name, CONVERT(varchar(max), g.G_Mark, 2) as G_Mark, g.G_Master \r\n          FROM GuildMember gm\r\n          INNER JOIN Guild g ON g.G_Name = gm.G_Name\r\n          WHERE gm.Name = ?", [$char]);
            if (is_array($charGuild)) {
                return $charGuild;
            }
            return NULL;
        }
    }
    public function loadGuildWebBank($guild)
    {
        global $dB;
        $result = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_WEB_BANK_GUILD WHERE Guild = ?", [$guild]);
        if (is_array($result)) {
            return $result;
        }
        if ($result == NULL) {
            $dB->query("INSERT INTO IMPERIAMUCMS_WEB_BANK_GUILD(Guild) VALUES(?)", [$guild]);
        }
        $result = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_WEB_BANK_GUILD WHERE Guild = ?", [$guild]);
        return $result;
    }
    public function loadBuildingsData($guild)
    {
        global $dB;
        $result = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_ARCHITECT WHERE Guild = ?", [$guild]);
        if (is_array($result)) {
            return $result;
        }
        if ($result == NULL) {
            $dB->query("INSERT INTO IMPERIAMUCMS_ARCHITECT(Guild) VALUES(?)", [$guild]);
        }
        $result = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_ARCHITECT WHERE Guild = ?", [$guild]);
        return $result;
    }
    public function upgradeBuilding($char, $type)
    {
        global $dB;
        if ($type == "mine" || $type == "bank") {
            if ($this->isActiveDay()) {
                $ucfirstType = ucfirst($type);
                $castleOwnerData = $this->castleOwnerData();
                $guildData = $this->loadGuildData($char);
                if ($castleOwnerData["G_Name"] == $guildData["G_Name"] && $castleOwnerData["G_Master"] == $char) {
                    $buildingsData = $this->loadBuildingsData($castleOwnerData["G_Name"]);
                    $nextLevel = $buildingsData[$ucfirstType . "_Level"] + 1;
                    $nextLevelCfg = mconfig($type . "_stage" . $nextLevel);
                    if ($nextLevelCfg["active"]) {
                        $webBank = $this->loadGuildWebBank($castleOwnerData["G_Name"]);
                        $error = false;
                        $errorMsg = "";
                        if (0 < $nextLevelCfg["price_valor"] && $webBank["Valor"] < $nextLevelCfg["price_valor"]) {
                            $error = true;
                            $errorMsg .= "<br>" . sprintf(lang("architect_txt_32", true), lang("architect_txt_8", true));
                        }
                        if (0 < $nextLevelCfg["price_sol"] && $webBank["Sign_of_Lord"] < $nextLevelCfg["price_sol"]) {
                            $error = true;
                            $errorMsg .= "<br>" . sprintf(lang("architect_txt_32", true), lang("architect_txt_17", true));
                        }
                        if (0 < $nextLevelCfg["price_zen"] && $webBank["zen"] < $nextLevelCfg["price_zen"]) {
                            $error = true;
                            $errorMsg .= "<br>" . sprintf(lang("architect_txt_32", true), "" . lang("currency_zen", true) . "");
                        }
                        if (0 < $nextLevelCfg["price_bless"] && $webBank["bless"] < $nextLevelCfg["price_bless"]) {
                            $error = true;
                            $errorMsg .= "<br>" . sprintf(lang("architect_txt_32", true), "" . lang("currency_bless", true) . "");
                        }
                        if (0 < $nextLevelCfg["price_soul"] && $webBank["soul"] < $nextLevelCfg["price_soul"]) {
                            $error = true;
                            $errorMsg .= "<br>" . sprintf(lang("architect_txt_32", true), "" . lang("currency_soul", true) . "");
                        }
                        if (0 < $nextLevelCfg["price_life"] && $webBank["life"] < $nextLevelCfg["price_life"]) {
                            $error = true;
                            $errorMsg .= "<br>" . sprintf(lang("architect_txt_32", true), "" . lang("currency_life", true) . "");
                        }
                        if (0 < $nextLevelCfg["price_chaos"] && $webBank["chaos"] < $nextLevelCfg["price_chaos"]) {
                            $error = true;
                            $errorMsg .= "<br>" . sprintf(lang("architect_txt_32", true), "" . lang("currency_chaos", true) . "");
                        }
                        if (0 < $nextLevelCfg["price_harmony"] && $webBank["harmony"] < $nextLevelCfg["price_harmony"]) {
                            $error = true;
                            $errorMsg .= "<br>" . sprintf(lang("architect_txt_32", true), "" . lang("currency_harmony", true) . "");
                        }
                        if (0 < $nextLevelCfg["price_creation"] && $webBank["creation"] < $nextLevelCfg["price_creation"]) {
                            $error = true;
                            $errorMsg .= "<br>" . sprintf(lang("architect_txt_32", true), "" . lang("currency_creation", true) . "");
                        }
                        if (0 < $nextLevelCfg["price_guardian"] && $webBank["guardian"] < $nextLevelCfg["price_guardian"]) {
                            $error = true;
                            $errorMsg .= "<br>" . sprintf(lang("architect_txt_32", true), "" . lang("currency_guardian", true) . "");
                        }
                        if (!$error) {
                            $query = "";
                            if (0 < $nextLevelCfg["price_valor"]) {
                                if ($query != "") {
                                    $query .= ", ";
                                }
                                $query .= "Valor = Valor - " . $nextLevelCfg["price_valor"];
                            }
                            if (0 < $nextLevelCfg["price_sol"]) {
                                if ($query != "") {
                                    $query .= ", ";
                                }
                                $query .= "Sign_of_Lord = Sign_of_Lord - " . $nextLevelCfg["price_sol"];
                            }
                            if (0 < $nextLevelCfg["price_zen"]) {
                                if ($query != "") {
                                    $query .= ", ";
                                }
                                $query .= "zen = zen - " . $nextLevelCfg["price_zen"];
                            }
                            if (0 < $nextLevelCfg["price_bless"]) {
                                if ($query != "") {
                                    $query .= ", ";
                                }
                                $query .= "bless = bless - " . $nextLevelCfg["price_bless"];
                            }
                            if (0 < $nextLevelCfg["price_soul"]) {
                                if ($query != "") {
                                    $query .= ", ";
                                }
                                $query .= "soul = soul - " . $nextLevelCfg["price_soul"];
                            }
                            if (0 < $nextLevelCfg["price_life"]) {
                                if ($query != "") {
                                    $query .= ", ";
                                }
                                $query .= "life = life - " . $nextLevelCfg["price_life"];
                            }
                            if (0 < $nextLevelCfg["price_chaos"]) {
                                if ($query != "") {
                                    $query .= ", ";
                                }
                                $query .= "chaos = chaos - " . $nextLevelCfg["price_chaos"];
                            }
                            if (0 < $nextLevelCfg["price_harmony"]) {
                                if ($query != "") {
                                    $query .= ", ";
                                }
                                $query .= "harmony = harmony - " . $nextLevelCfg["price_harmony"];
                            }
                            if (0 < $nextLevelCfg["price_creation"]) {
                                if ($query != "") {
                                    $query .= ", ";
                                }
                                $query .= "creation = creation - " . $nextLevelCfg["price_creation"];
                            }
                            if (0 < $nextLevelCfg["price_guardian"]) {
                                if ($query != "") {
                                    $query .= ", ";
                                }
                                $query .= "guardian = guardian - " . $nextLevelCfg["price_guardian"];
                            }
                            $query = "UPDATE IMPERIAMUCMS_WEB_BANK_GUILD SET " . $query . " WHERE Guild = ?";
                            $update1 = $dB->query($query, [$castleOwnerData["G_Name"]]);
                            $update2 = $dB->query("UPDATE IMPERIAMUCMS_ARCHITECT SET " . $ucfirstType . "_Level = " . $ucfirstType . "_Level + 1, " . $ucfirstType . "_Updated = ? \r\n                            WHERE Guild = ?", [date("Y-m-d H:i:s", time()), $castleOwnerData["G_Name"]]);
                            if ($update1 && $update2) {
                                message("success", sprintf(lang("architect_txt_33", true), $nextLevel));
                            } else {
                                message("error", lang("error_23", true));
                            }
                        } else {
                            message("error", $errorMsg);
                        }
                    } else {
                        message("error", lang("architect_txt_26", true));
                    }
                } else {
                    message("error", lang("architect_txt_31", true));
                }
            } else {
                message("error", sprintf(lang("architect_txt_39", true), lang("day_" . mconfig("active_day_start"), true), lang("day_" . mconfig("active_day_end"), true)));
            }
        }
    }
    public function loadSignOfLordFromCharacter($username, $char)
    {
        global $dB;
        echo "START ";
        if (!Validator::UsernameLength($username)) {
            message("error", lang("error_23", true));
        } else {
            if (!Validator::AlphaNumeric($username)) {
                message("error", lang("error_23", true));
            } else {
                if (10 < strlen($char)) {
                    message("error", lang("error_23", true));
                } else {
                    $total = 0;
                    $Items = new Items();
                    $charInv = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT Inventory FROM Character WHERE AccountID = ? AND Name = ?), 2) AS Inventory", [$username, $char]);
                    $charInv = $charInv["Inventory"];
                    $index = 0;
                    while ($index < 237) {
                        $item = substr($charInv, __ITEM_LENGTH__ * $index, __ITEM_LENGTH__);
                        if ($item != __ITEM_EMPTY__) {
                            $itemInfo = $Items->ItemInfo($item);
                            if ($itemInfo["type"] == 14 && $itemInfo["id"] == 21 && $itemInfo["sticklevel"] == 3) {
                                $total += $itemInfo["dur"];
                            }
                        }
                        $index++;
                    }
                    return $total;
                }
            }
        }
    }
    public function insertSignOfLord($username, $char, $amount)
    {
        global $dB;
        global $common;
        if ($this->isActiveDay()) {
            $amount = xss_clean($amount);
            if (check_value($username) && check_value($amount)) {
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
                        $Market = new Market();
                        if (!$Market->duplicatedItemsVault($username)) {
                            $charInv = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT Inventory FROM Character WHERE AccountID = ? AND Name = ?), 2) AS Inventory", [$username, $char]);
                            $charInv = $charInv["Inventory"];
                            $total = 0;
                            $Items = new Items();
                            $index = 0;
                            while ($index < 237) {
                                $item = substr($charInv, __ITEM_LENGTH__ * $index, __ITEM_LENGTH__);
                                if ($item != __ITEM_EMPTY__) {
                                    $itemInfo = $Items->ItemInfo($item);
                                    if ($itemInfo["type"] == 14 && $itemInfo["id"] == 21 && $itemInfo["sticklevel"] == 3) {
                                        $total += $itemInfo["dur"];
                                    }
                                }
                                $index++;
                            }
                            $need = $amount;
                            if ($amount <= $total) {
                                $index = 0;
                                while ($index < 237) {
                                    $item = substr($charInv, __ITEM_LENGTH__ * $index, __ITEM_LENGTH__);
                                    if ($item != __ITEM_EMPTY__) {
                                        $itemInfo = $Items->ItemInfo($item);
                                        if ($itemInfo["type"] == 14 && $itemInfo["id"] == 21 && $itemInfo["sticklevel"] == 3) {
                                            if ($itemInfo["dur"] <= $need) {
                                                $charInv = substr_replace($charInv, __ITEM_EMPTY__, __ITEM_LENGTH__ * $index, __ITEM_LENGTH__);
                                                $need = $need - $itemInfo["dur"];
                                            } else {
                                                $newDur = $itemInfo["dur"] - $need;
                                                $newItem = substr_replace($item, dechex($newDur), 4, 2);
                                                $charInv = substr_replace($charInv, $newItem, __ITEM_LENGTH__ * $index, __ITEM_LENGTH__);
                                                $need = 0;
                                            }
                                            if ($need != 0) {
                                            }
                                        }
                                    }
                                    $index++;
                                }
                                $charInv = "0x" . $charInv;
                                $castleOwnerData = $this->castleOwnerData();
                                $update1 = $dB->query("UPDATE Character SET Inventory = " . $charInv . " WHERE AccountID = ? AND Name = ?", [$username, $char]);
                                $update2 = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK_GUILD SET Sign_of_Lord = Sign_of_Lord + ? WHERE Guild = ?", [$amount, $castleOwnerData["G_Name"]]);
                                if ($update1 && $update2) {
                                    $dB->query("INSERT INTO IMPERIAMUCMS_WEB_BANK_GUILD_LOGS (Guild, AccountID, Name, Date, Amount, Resource_Type, Operation_Type) VALUES (?, ?, ?, ?, ?, ?, ?)", [$castleOwnerData["G_Name"], $username, $char, date("Y-m-d H:i:s", time()), $amount, "signoflord", 1]);
                                    message("success", lang("webbankguild_txt_21", true));
                                } else {
                                    message("error", lang("error_23", true));
                                }
                            } else {
                                message("error", lang("webbankguild_txt_11", true));
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
        } else {
            message("error", sprintf(lang("architect_txt_39", true), lang("day_" . mconfig("active_day_start"), true), lang("day_" . mconfig("active_day_end"), true)));
        }
    }
    public function insertFromWebBank($username, $char, $amount, $type)
    {
        global $dB;
        if ($this->isActiveDay()) {
            $amount = xss_clean($amount);
            if (check_value($username) && check_value($amount)) {
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
                    $Market = new Market();
                    $webBankData = $Market->getBankData($username);
                    if ($amount <= $webBankData[$type]) {
                        $castleOwnerData = $this->castleOwnerData();
                        $update1 = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET " . $type . " = " . $type . " - ? WHERE AccountID = ?", [$amount, $username]);
                        $update2 = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK_GUILD SET " . $type . " = " . $type . " + ? WHERE Guild = ?", [$amount, $castleOwnerData["G_Name"]]);
                        if ($update1 && $update2) {
                            $dB->query("INSERT INTO IMPERIAMUCMS_WEB_BANK_GUILD_LOGS (Guild, AccountID, Name, Date, Amount, Resource_Type, Operation_Type) VALUES (?, ?, ?, ?, ?, ?, ?)", [$castleOwnerData["G_Name"], $username, $char, date("Y-m-d H:i:s", time()), $amount, $type, 1]);
                            message("success", lang("webbankguild_txt_22", true));
                        } else {
                            message("error", lang("error_23", true));
                        }
                    } else {
                        message("error", lang("webbankguild_txt_12", true));
                    }
                } else {
                    message("error", lang("error_23", true));
                }
            } else {
                message("error", lang("error_23", true));
            }
        } else {
            message("error", sprintf(lang("architect_txt_39", true), lang("day_" . mconfig("active_day_start"), true), lang("day_" . mconfig("active_day_end"), true)));
        }
    }
    public function withdrawToWebBank($username, $char, $amount, $type)
    {
        global $dB;
        if ($this->isActiveDay()) {
            $amount = xss_clean($amount);
            if (check_value($username) && check_value($amount)) {
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
                    $castleOwnerData = $this->castleOwnerData();
                    $guildWebBankData = $this->loadGuildWebBank($castleOwnerData["G_Name"]);
                    if ($amount <= $guildWebBankData[$type]) {
                        $update1 = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK_GUILD SET " . $type . " = " . $type . " - ? WHERE Guild = ?", [$amount, $castleOwnerData["G_Name"]]);
                        $update2 = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET " . $type . " = " . $type . " + ? WHERE AccountID = ?", [$amount, $username]);
                        if ($update1 && $update2) {
                            $dB->query("INSERT INTO IMPERIAMUCMS_WEB_BANK_GUILD_LOGS (Guild, AccountID, Name, Date, Amount, Resource_Type, Operation_Type) VALUES (?, ?, ?, ?, ?, ?, ?)", [$castleOwnerData["G_Name"], $username, $char, date("Y-m-d H:i:s", time()), $amount, $type, 2]);
                            message("success", lang("webbankguild_txt_26", true));
                        } else {
                            message("error", lang("error_23", true));
                        }
                    } else {
                        message("error", lang("webbankguild_txt_27", true));
                    }
                } else {
                    message("error", lang("error_23", true));
                }
            } else {
                message("error", lang("error_23", true));
            }
        } else {
            message("error", sprintf(lang("architect_txt_39", true), lang("day_" . mconfig("active_day_start"), true), lang("day_" . mconfig("active_day_end"), true)));
        }
    }
    public function returnResourceName($type)
    {
        switch ($type) {
            case "signoflord":
                return lang("architect_txt_17", true);
                break;
            case "zen":
                return "" . lang("currency_zen", true) . "";
                break;
            case "bless":
                return "" . lang("currency_bless", true) . "";
                break;
            case "soul":
                return "" . lang("currency_soul", true) . "";
                break;
            case "life":
                return "" . lang("currency_life", true) . "";
                break;
            case "chaos":
                return "" . lang("currency_chaos", true) . "";
                break;
            case "harmony":
                return "" . lang("currency_harmony", true) . "";
                break;
            case "creation":
                return "" . lang("currency_creation", true) . "";
                break;
            case "guardian":
                return "" . lang("currency_guardian", true) . "";
                break;
        }
    }
    public function isActiveDay()
    {
        $cfg = loadConfigurations("usercp.architect");
        $now = time();
        $currDay = date("N", $now);
        if ($cfg["active_day_start"] <= $currDay && $currDay <= $cfg["active_day_end"]) {
            if ($cfg["active_day_start"] == $cfg["reward_day"] && $currDay == $cfg["active_day_start"]) {
                $architectCache = LoadCacheData("architect_rewards.cache");
                $lastRun = NULL;
                $i = 0;
                foreach ($architectCache as $thisData) {
                    if ($i == 1) {
                        $lastRun = $thisData[0];
                        if ($lastRun == date("Y-m-d", $now)) {
                            return true;
                        }
                        return false;
                    }
                    $i++;
                }
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
    public function loadMineLastProduction()
    {
        global $dB;
        $production = $dB->query_fetch_single("SELECT TOP 1 * FROM IMPERIAMUCMS_ARCHITECT_MINE ORDER BY Date DESC");
        if (is_array($production)) {
            return $production;
        }
        return NULL;
    }
    public function loadAllInvestments()
    {
        global $dB;
        $investments = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_ARCHITECT_BANK");
        if (is_array($investments)) {
            return $investments;
        }
        return NULL;
    }
    public function loadMyInvestments($username, $char)
    {
        global $dB;
        if (!Validator::UsernameLength($username)) {
            message("error", lang("error_23", true));
        } else {
            if (!Validator::AlphaNumeric($username)) {
                message("error", lang("error_23", true));
            } else {
                if (10 < strlen($char)) {
                    message("error", lang("error_23", true));
                } else {
                    $investments = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_ARCHITECT_BANK WHERE AccountID = ? AND Name = ?", [$username, $char]);
                    if (is_array($investments)) {
                        return $investments;
                    }
                    return NULL;
                }
            }
        }
    }
    public function manageInvestments($operation, $username, $char, $amount, $type)
    {
        global $dB;
        global $dB2;
        if ($this->isActiveDay()) {
            if (check_value($username) && check_value($amount) && check_value($operation) && check_value($char) && check_value($type)) {
                $amount = xss_clean($amount);
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
                    $castleOwnerData = $this->castleOwnerData();
                    $totalCurrency = 0;
                    if ($operation == "invest") {
                        $checkInvestments = $dB->query_fetch_single("SELECT Name FROM IMPERIAMUCMS_ARCHITECT_BANK WHERE Guild = ? AND AccountID = ? AND Name = ?", [$castleOwnerData["G_Name"], $username, $char]);
                        if ($checkInvestments["Name"] == NULL) {
                            $dB->query("INSERT INTO IMPERIAMUCMS_ARCHITECT_BANK (Guild, AccountID, Name, Date) VALUES (?, ?, ?, ?)", [$castleOwnerData["G_Name"], $username, $char, date("Y-m-d H:i:s", time())]);
                        }
                        if ($type == "zen") {
                            $myWebBank = $dB->query_fetch_single("SELECT zen FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$username]);
                            $totalCurrency = $myWebBank["zen"];
                        } else {
                            if ($type == "platinum" || $type == "gold" || $type == "silver") {
                                if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                    $myWebBank = $dB2->query_fetch_single("SELECT platinum, gold, silver FROM MEMB_CREDITS WHERE memb___id = ?", [$username]);
                                } else {
                                    $myWebBank = $dB->query_fetch_single("SELECT platinum, gold, silver FROM MEMB_CREDITS WHERE memb___id = ?", [$username]);
                                }
                                $totalCurrency = $myWebBank[$type];
                            } else {
                                if ($type == "wcoin") {
                                    if (100 <= config("server_files_season", true)) {
                                        $myWebBank = $dB->query_fetch_single("SELECT WCoin FROM T_InGameShop_Point WHERE AccountID = ?", [$username]);
                                        $totalCurrency = $myWebBank["WCoin"];
                                    } else {
                                        $myWebBank = $dB->query_fetch_single("SELECT WCoinC FROM T_InGameShop_Point WHERE AccountID = ?", [$username]);
                                        $totalCurrency = $myWebBank["WCoinC"];
                                    }
                                } else {
                                    if ($type == "gp") {
                                        $myWebBank = $dB->query_fetch_single("SELECT GoblinPoint FROM T_InGameShop_Point WHERE AccountID = ?", [$username]);
                                        $totalCurrency = $myWebBank["GoblinPoint"];
                                    }
                                }
                            }
                        }
                        if ($amount <= $totalCurrency) {
                            $update1 = $dB->query("UPDATE IMPERIAMUCMS_ARCHITECT_BANK SET " . $type . " = " . $type . " + ? WHERE Guild = ? AND AccountID = ? AND Name = ?", [$amount, $castleOwnerData["G_Name"], $username, $char]);
                            if ($type == "zen") {
                                $update2 = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET zen = zen - ? WHERE AccountID = ?", [$amount, $username]);
                            } else {
                                if ($type == "platinum" || $type == "gold" || $type == "silver") {
                                    if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                        $update2 = $dB2->query("UPDATE MEMB_CREDITS SET " . $type . " = " . $type . " - ? WHERE memb___id = ?", [$amount, $username]);
                                    } else {
                                        $update2 = $dB->query("UPDATE MEMB_CREDITS SET " . $type . " = " . $type . " - ? WHERE memb___id = ?", [$amount, $username]);
                                    }
                                } else {
                                    if ($type == "wcoin") {
                                        if (100 <= config("server_files_season", true)) {
                                            $update2 = $dB->query("UPDATE T_InGameShop_Point SET WCoin = WCoin - ? WHERE AccountID = ?", [$amount, $username]);
                                        } else {
                                            $update2 = $dB->query("UPDATE T_InGameShop_Point SET WCoinC = WCoinC - ? WHERE AccountID = ?", [$amount, $username]);
                                        }
                                    } else {
                                        if ($type == "gp") {
                                            $update2 = $dB->query("UPDATE T_InGameShop_Point SET GoblinPoint = GoblinPoint - ? WHERE AccountID = ?", [$amount, $username]);
                                        }
                                    }
                                }
                            }
                            if ($update1 && $update2) {
                                $dB->query("INSERT INTO IMPERIAMUCMS_ARCHITECT_BANK_LOGS (Guild, AccountID, Name, Date, Amount, Resource_Type, Operation_Type) VALUES (?, ?, ?, ?, ?, ?, ?)", [$castleOwnerData["G_Name"], $username, $char, date("Y-m-d H:i:s", time()), $amount, $type, 1]);
                                message("success", lang("architect_txt_54", true));
                            } else {
                                message("error", lang("error_23", true));
                            }
                        } else {
                            message("error", lang("architect_txt_55", true));
                        }
                    } else {
                        if ($operation == "withdraw") {
                            $myInvestments = $this->loadMyInvestments($username, $char);
                            if ($amount <= $myInvestments[$type]) {
                                $update1 = $dB->query("UPDATE IMPERIAMUCMS_ARCHITECT_BANK SET " . $type . " = " . $type . " - ? WHERE Guild = ? AND AccountID = ? AND Name = ?", [$amount, $castleOwnerData["G_Name"], $username, $char]);
                                if ($type == "zen") {
                                    $update2 = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET zen = zen + ? WHERE AccountID = ?", [$amount, $username]);
                                } else {
                                    if ($type == "platinum" || $type == "gold" || $type == "silver") {
                                        if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                            $update2 = $dB2->query("UPDATE MEMB_CREDITS SET " . $type . " = " . $type . " + ? WHERE memb___id = ?", [$amount, $username]);
                                        } else {
                                            $update2 = $dB->query("UPDATE MEMB_CREDITS SET " . $type . " = " . $type . " + ? WHERE memb___id = ?", [$amount, $username]);
                                        }
                                    } else {
                                        if ($type == "wcoin") {
                                            if (100 <= config("server_files_season", true)) {
                                                $update2 = $dB->query("UPDATE T_InGameShop_Point SET WCoin = WCoin + ? WHERE AccountID = ?", [$amount, $username]);
                                            } else {
                                                $update2 = $dB->query("UPDATE T_InGameShop_Point SET WCoinC = WCoinC + ? WHERE AccountID = ?", [$amount, $username]);
                                            }
                                        } else {
                                            if ($type == "gp") {
                                                $update2 = $dB->query("UPDATE T_InGameShop_Point SET GoblinPoint = GoblinPoint + ? WHERE AccountID = ?", [$amount, $username]);
                                            }
                                        }
                                    }
                                }
                                if ($update1 && $update2) {
                                    $dB->query("INSERT INTO IMPERIAMUCMS_ARCHITECT_BANK_LOGS (Guild, AccountID, Name, Date, Amount, Resource_Type, Operation_Type) VALUES (?, ?, ?, ?, ?, ?, ?)", [$castleOwnerData["G_Name"], $username, $char, date("Y-m-d H:i:s", time()), $amount, $type, 2]);
                                    message("success", lang("architect_txt_53", true));
                                } else {
                                    message("error", lang("error_23", true));
                                }
                            } else {
                                message("error", lang("architect_txt_52", true));
                            }
                        }
                    }
                } else {
                    message("error", lang("error_23", true));
                }
            } else {
                message("error", lang("error_23", true));
            }
        } else {
            message("error", sprintf(lang("architect_txt_39", true), lang("day_" . mconfig("active_day_start"), true), lang("day_" . mconfig("active_day_end"), true)));
        }
    }
}

?>